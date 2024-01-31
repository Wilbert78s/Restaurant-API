<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function vendorDetailTransaction(){
        return $this->hasMany(VendorDetailTransaction::class);
    }

    public function storage(){
        return $this->hasMany(Storage::class);
    }

    public function recipe(){
        return $this->hasMany(Recipe::class);
    }
}
