<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cash;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Storage;
use Illuminate\Http\Request;
use App\Models\CustomerTransaction;
use Illuminate\Support\Facades\Http;
use App\Models\CustomerDetailTransaction;

class CustomerController extends Controller
{
    public function addTransaction(Request $request){
        try{
            $validatedData = $request->validate([
                'customer_id'=>['required','numeric'],
                'order' => ['array'], 
                'order.*.menu_id' => ['required', 'numeric'], 
                'order.*.quantity' => ['required', 'numeric'], 
            ]);

            // cek bahan makanan
            $ingredientsTotal=[];
            foreach($validatedData['order'] as $item){
                $temp=$item['menu_id'];
                $response = Http::get("http://api_restaurant.test/restaurant/recipe/$temp"); 
                $ingredients = $response->json();
                foreach($ingredients as $ingredient){
                    $id = $ingredient['goods_id'];
                    $quantity = $ingredient['quantity']*$item['quantity'];
                    try{
                        $ingredientsTotal[$id]+=$quantity;
                    }
                    catch(Exception $e){
                        $ingredientsTotal[$id]=$quantity;
                    } 
                }
            }
            
            // kurangi bahan
            foreach($ingredientsTotal as $key=>$value){
                $old = Storage::find($key);
                if($value > $old->quantity){
                    return response()->json([
                    'status' => 'failed',
                    'message' => 'not enough ingredients'
                    ]);
                }
            }
            foreach($ingredientsTotal as $key=>$value){
                $old = Storage::find($key);
                Storage::where('goods_id', $key)->update([
                    'quantity' => $old->quantity - $value,
                ]);
            }       

            // buat transaksi baru
            $customerTransaction = CustomerTransaction::create(['customer_id' => $validatedData['customer_id']]);
            $latestTransactionId = $customerTransaction->id;

            // isi detail transaksi
            foreach($validatedData['order'] as $item){
                CustomerDetailTransaction::create([
                    'customer_transaction_id' => $latestTransactionId,
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity']
                ]);                
            }
            
            // penambahan uang
            $purchase=0;
            foreach($validatedData['order'] as $item){
                $menu = Menu::find($item['menu_id']);
                $purchase+=$menu->price*$item['quantity'];
            }
            $latestWallet = Cash::latest()->first();
            $finalCash = $latestWallet->nominal + $purchase;
            Cash::create([
            'vendor_transaction_id'=>0,
            'customer_transaction_id'=>$latestTransactionId,
            'nominal'=>$finalCash,
            ]);     

            // tambah transaksi cuustomer            
            $old = Customer::find($validatedData['customer_id']);
            Customer::where('id', $validatedData['customer_id'])->update([
                'transaction' => $old->transaction+1,
            ]);
        }
        catch(Exception $e){
            return response()->json(['error' => 'Something went wrong'], 500);
        }

        return response()->json([
            "status" => "berhasil",
            "message" => "transaksi berhasil, total pesanan Rp.$purchase"
        ]);
    }

    public function show(){
        return response()->json([
            "status" => "success",
            "message" => "data retrieved",
            "data" => Customer::all()
        ]);
    }

    public function showCustomerTransaction(){        
        return response()->json([
            "status" => "success",
            "message" => "data retrieved",
            "data" => CustomerTransaction::all()
        ]); 
    }

    public function showTransaction(Customer $customer){
        return response()->json([
            "status" => "success",
            "message" => "data retrieved",
            "data" => $customer->customerTransaction
        ]);
    }

    public function showDetailTransaction(CustomerTransaction $customerTransaction){  
        echo($customerTransaction); 
        return response()->json([
            "status" => "success",
            "message" => "data retrieved",
            "data" => $customerTransaction->customerDetailTransaction
        ]); 
    }
}
