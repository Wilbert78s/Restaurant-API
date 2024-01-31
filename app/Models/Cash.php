<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function vendorTransaction(){
        return $this->belongsTo(VendorTransaction::class);
    }

    public function customerTransactiion(){
        return $this->belongsTo(CustomerTransaction::class);
    }
}
