<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTransaction extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    
    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function vendorDetailTransaction(){
        return $this->hasMany(VendorDetailTransaction::class);
    }
    
    public function cash(){
        return $this->hasMany(Cash::class);
    }
}
