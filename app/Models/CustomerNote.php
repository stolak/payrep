<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNote extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'loan_id',
        'notes',
        'last_name',
        'created_by',
    ];
}
