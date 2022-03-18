<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeExpenseCat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function subCat()
    {
        return $this->hasMany(OfficeExpenseCat::class, 'parent_id','id');
    }
    public function subCatName()
    {
        return $this->belongsTo(OfficeExpenseCat::class, 'parent_id','id');
    }
}
