<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function userForSR()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function user()
    {
        return $this->belongsTo(EmployeeInfo::class, 'user_id','user_id');
    }

    public function zsm()
    {
        return $this->belongsTo(User::class, 'zsm_id');
    }

    public function sso()
    {
        return $this->belongsTo(User::class, 'sso_id', 'id');
    }
    public function so()
    {
        return $this->belongsTo(User::class, 'so_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }


}
