<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseInvoice extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    private $from_date;


    //  public function __construct($from_date){
    //      $this->from_date = $from_date;
    //  }

    public function supplier()
    {
        return $this->belongsTo(User::class,'supplier_id')->withDefault();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // public function packSize()
    // {
    //     return $this->belongsTo(ProductPackSize::class, 'product_id', 'product_id');
    // }

    public function packSize()
    {
        return $this->belongsTo(ProductPackSize::class, 'size');
    }

    public function purchaseInvoice($from_date)
    {
        return $this->hasOne(PurchaseInvoice::class, 'id')->where('invoice_date','<', $from_date);
    }
}
