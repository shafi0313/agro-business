<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesLedgerBook extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function customerInfo()
    {
        return $this->belongsTo(CustomerInfo::class, 'customer_id','user_id');
    }

    public function customerInfoAcc()
    {
        return $this->belongsTo(Account::class, 'user_id','user_id');
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

    public function sampleNote()
    {
        return $this->hasOne(SampleNote::class, 'sales_ledger_book_id');
    }

    public function invoice()
    {
        return $this->hasMany(SalesInvoice::class, 'invoice_no','invoice_no');
    }


}
