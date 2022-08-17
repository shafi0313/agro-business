<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasRole extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_id',
        'model_type',
        'model_id',
    ];

    // protected $guarded = [];
    const UPDATED_AT = null;
    const CREATED_AT = null;



}
