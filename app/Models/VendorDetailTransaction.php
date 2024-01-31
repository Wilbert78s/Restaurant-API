<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorDetailTransaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function goods(){
        return $this->belongsTo(Goods::class);
    }
}
