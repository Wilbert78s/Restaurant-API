<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function goods(){
        return $this->belongsTo(Goods::class);
    }

    public function menu(){
        return $this->belongsTo(Menu::class);
    }
}
