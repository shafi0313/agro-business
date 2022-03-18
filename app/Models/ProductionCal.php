<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionCal extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $dates = ['deleted_at'];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function packSize()
    {
        return $this->belongsTo(ProductPackSize::class, 'size', 'id');
    }

    public function purInv()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'pur_inv_id', 'id');
    }



    // public function packSize()
    // {
    //     return $this->belongsTo(ProductPackSize::class, 'size');
    // }
}
