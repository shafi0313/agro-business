<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseLedgerBook extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id')->withDefault();
    }

    public function tmmSoId()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function preparedBy()
    {
        return $this->belongsTo(User::class, 'prepared_id')->withDefault();
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id')->withDefault();
    }
}
