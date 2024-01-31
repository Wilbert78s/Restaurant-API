<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDetailTransaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function customerTransaction(){
        return $this->belongsTo(customerTransaction::class);
    }
    
    public function menu(){
        return $this->hasMany(Menu::class);
    }
}
