<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsReturn extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    const UPDATED_AT = null;
    const CREATED_AT = null;

    public function isReturnToInv()
    {
        return $this->belongsTo(SalesInvoice::class, 'sales_invoice_id');
    }
}
