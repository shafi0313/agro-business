<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesInvoice extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function customer()
    {
        return $this->belongsTo(User::class,'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function packSize()
    {
        return $this->belongsTo(ProductPackSize::class, 'size');
    }

    public function isReturnInv()
    {
        return $this->hasOne(IsReturn::class);
    }

    public function isReturnInvC()
    {
        return $this->hasOne(IsReturn::class, 'invoice_no','invoice_no');
    }

    // not work
    // public function invCancel()
    // {
    //     return $this->belongsTo(SalesInvoice::class, 'product_id','size','product_id','size');
    // }
}
