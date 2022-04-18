<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name','tmm_so_id','email', 'password', 'role', 'is_', 'age', 'phone', 'business_name', 'shop_address','credit_limit','address','profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

    public function employeeInfo()
    {
        return $this->hasOne(EmployeeInfo::class, 'user_id');
    }

    public function customerInfo()
    {
        return $this->hasOne(CustomerInfo::class, 'user_id');
    }
    public function permission()
    {
        return $this->hasOne(ModelHasRole::class,'model_id');
    }
    public function invoice()
    {
        return $this->hasMany(SalesLedgerBook::class,'customer_id');
    }
}
