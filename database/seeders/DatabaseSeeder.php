<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cash;
use App\Models\Goods;
use App\Models\Menu;
use App\Models\Recipe;
use App\Models\Vendor;
use App\Models\Storage;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // vendor and customer
        Vendor::factory(5)->create();
        Customer::factory(5)->create();

        //goods
        Goods::create(['name'=>'beras putih']);
        Goods::create(['name'=>'ayam']);
        Goods::create(['name'=>'ikan lele']);
        Goods::create(['name'=>'telur']);
        Goods::create(['name'=>'kol']);
        Goods::create(['name'=>'kopi']);
        Goods::create(['name'=>'teh']);

        // storage
        Storage::create(['goods_id'=>1, 'quantity'=>10, 'price'=>0]);
        Storage::create(['goods_id'=>2, 'quantity'=>10, 'price'=>0]);
        Storage::create(['goods_id'=>3, 'quantity'=>10, 'price'=>0]);
        Storage::create(['goods_id'=>4, 'quantity'=>10, 'price'=>0]);
        Storage::create(['goods_id'=>5, 'quantity'=>10, 'price'=>0]);
        Storage::create(['goods_id'=>6, 'quantity'=>10, 'price'=>0]);
        Storage::create(['goods_id'=>7, 'quantity'=>10, 'price'=>0]);

        // menu
        Menu::create(['name'=>'nasi goreng', 'price'=>25000]);
        Menu::create(['name'=>'nasi ayam penyet', 'price'=>20000]);
        Menu::create(['name'=>'nasi lele penyet', 'price'=>20000]);
        Menu::create(['name'=>'kopi', 'price'=>5000]);
        Menu::create(['name'=>'teh', 'price'=>5000]);

        // recipe
        Recipe::create(['menu_id'=>1,'goods_id'=>1,'quantity'=>1]);
        Recipe::create(['menu_id'=>2,'goods_id'=>1,'quantity'=>1]);
        Recipe::create(['menu_id'=>2,'goods_id'=>2,'quantity'=>1]);
        Recipe::create(['menu_id'=>2,'goods_id'=>4,'quantity'=>1]);
        Recipe::create(['menu_id'=>2,'goods_id'=>5,'quantity'=>1]);
        Recipe::create(['menu_id'=>3,'goods_id'=>1,'quantity'=>1]);
        Recipe::create(['menu_id'=>3,'goods_id'=>3,'quantity'=>1]);
        Recipe::create(['menu_id'=>3,'goods_id'=>4,'quantity'=>1]);
        Recipe::create(['menu_id'=>3,'goods_id'=>5,'quantity'=>1]);
        Recipe::create(['menu_id'=>4,'goods_id'=>6,'quantity'=>1]);
        Recipe::create(['menu_id'=>5,'goods_id'=>7,'quantity'=>1]);

        // cash
        Cash::create(['vendor_transaction_id'=>0,'customer_transaction_id'=>0,'nominal'=>2000000]);

    }
}
