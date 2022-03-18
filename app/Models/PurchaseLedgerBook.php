<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseLedgerBook extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function tmmSoId()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function preparedBy()
    {
        return $this->belongsTo(User::class, 'prepared_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
