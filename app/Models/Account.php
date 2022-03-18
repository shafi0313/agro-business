<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function usersAcc()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    public function userBank()
    {
        return $this->belongsTo(UserBankAc::class, 'user_bank_ac_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(BankList::class, 'bank_list_id', 'id');
    }

    public function officeExp()
    {
        return $this->belongsTo(OfficeExpenseCat::class, 'office_expense_cat_id', 'id');
    }

    public function officeExpMainCat()
    {
        return $this->belongsTo(OfficeExpenseCat::class, 'exp_type', 'id');
    }
}
