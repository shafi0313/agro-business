<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productPackSize()
    {
        return $this->belongsTo(ProductPackSize::class, 'product_pack_size_id');
    }

    // public function productPackSizeforDashboard()
    // {
    //     return $this->belongsTo(ProductPackSize::class, 'product_pack_size_id');
    // }
}
