<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'marketer_id',
        'amount',
        'amount_marketer',
        'amount_accountant',
        'amount_approved',
        'period',
        'percentage',
        'total_interest',
        'monthly_repayment',
        'total_repayment',
        'remarks',
        'stage',
        'loan_type_id',

    ];
}
