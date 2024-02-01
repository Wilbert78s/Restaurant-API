<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cash;
use App\Models\Vendor;
use App\Models\Storage;
use Illuminate\Http\Request;
use App\Models\VendorTransaction;
use App\Models\VendorDetailTransaction;

class VendorController extends Controller
{
    public function addVendor(Request $request){
        try{
            $validatedData = $request->validate([
                'name'=>['required'],
                'address' => ['required'], 
                'phone_number' => ['required', 'numeric'], 
            ]);
            Vendor::create($validatedData);
            return response()->json([
                "status" => "success",
                "message" => "Vendor added"
            ]);
        }
        catch(Exception $e){
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function addTransaction(Request $request){
        try{
            $validatedData = $request->validate([
                'vendor_id'=>['required','numeric'],
                'bahan' => ['array'], 
                'bahan.*.goods_id' => ['required', 'numeric'], 
                'bahan.*.quantity' => ['required', 'numeric'], 
                'bahan.*.price' => ['required', 'numeric'],
            ]);
            
            // cek uang
            $purchase=0;
            foreach($validatedData['bahan'] as $item){
                $purchase+=$item['price']*$item['quantity'];
            }
            $latestCash = Cash::latest()->first();
            $finalCash=$latestCash->nominal-$purchase;
            if(!$finalCash){
                return response()->json([
                "status" => "failed",
                "message" => "Not enough cash"
                ]);
            }                    

            // buat transaksi baru
            $vendorTransaction = VendorTransaction::create(['vendor_id' => $validatedData['vendor_id']]);
            $latestTransactionId = $vendorTransaction->id;

            // pengurangan uang
            Cash::create([
                'vendor_transaction_id'=>$latestTransactionId,
                'customer_transaction_id'=>0,
                'nominal'=>$finalCash,
                ]);

            // isi detail transaksi
            foreach($validatedData['bahan'] as $item){
                VendorDetailTransaction::create([
                    'vendor_transaction_id' => $latestTransactionId,
                    'goods_id' => $item['goods_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
                
                // update gudang
                $old = Storage::find($item['goods_id']);
                Storage::where('goods_id', $item['goods_id'])->update([
                    'quantity' => $old->quantity + $item['quantity'],
                    'price' => (($old->price * $old->quantity) + ($item['price'] * $item['quantity'])) / ($old->quantity + $item['quantity']),
                ]);
            }
        }
        catch(Exception $e){
            return response()->json(['error' => 'Something went wrong'], 500);
        }

        return response()->json([
            "status" => "success",
            "message" => "transaction completed"
        ]);
    }

    public function show(){
        return response()->json([
            "status" => "success",
            "message" => "data retrieved",
            "data" => Vendor::all(['id', 'name', 'address', 'phone_number'])
        ]);
    }

    public function showTransaction(Vendor $vendor){
        return response()->json([
            "status" => "success",
            "message" => "data retrieved",
            "data" => $vendor->vendorTransaction
        ]);
    }

    public function showVendorTransaction(){        
        return response()->json([
            "status" => "success",
            "message" => "data retrieved",
            "data" => VendorTransaction::all()
        ]); 
    }

    public function showDetailTransaction(VendorTransaction $vendorTransaction){   
        return response()->json([
            "status" => "success",
            "message" => "data retrieved",
            "data" => $vendorTransaction->vendorDetailTransaction
        ]); 
    }
}
