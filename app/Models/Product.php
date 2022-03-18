<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $table = 'product_pack_sizes';

    public function productPack()
    {
        return $this->hasMany(ProductPackSize::class,'product_id');
    }

    public function productPackSize()
    {
        return $this->hasOne(ProductPackSize::class,'product_id');
    }

    public function productCat()
    {
        return $this->belongsTo(ProductCat::class, 'cat_id');
    }
}
