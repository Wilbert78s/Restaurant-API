<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\Goods;
use App\Models\Menu;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function showRecipe(Menu $menu){
        $temp = $menu->recipe;
        $resultArray = [];

        foreach ($temp as $item) {
            $goods = Goods::find($item['goods_id']);
            $resultArray[] = [
                'goods_id' => $item['goods_id'],
                'name'=>$goods->name,
                'quantity' => $item['quantity'],
            ];
        }
        return $resultArray;
    }

    public function showCash(){
        return response()->json([
            "status" => "success",
            "message" => "data retrieved",
            "data" => Cash::all()
        ]);
    }

    public function showMenu(){
        return response()->json([
            "status" => "success",
            "message" => "data retrieved",
            "data" => Menu::all(['id', 'name', 'price'])
        ]);
    }
}
