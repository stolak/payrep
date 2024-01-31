<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titleID',
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'email',
        'bvn',
        'nin',
        'office_address',
        'address',
        'guarrantor_full_name',
        'is_o_address_verified',
        'is_h_address_verified',
        'guarrantor_phone',
        'guarrantor_email',
        'marketerID',
        'guarrantor_address',
        'registerdBy',
        'remarks',
    ];
}
