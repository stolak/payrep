<?php
namespace App\Http\Traits;

use App\Models\Loan;
use App\Models\LoanTransaction;
use DB;
use Auth;
use App\Http\Traits\AccountTrait;
use App\Models\Customer;

trait LoanTrait
{
    public function implimentDefaulter($id)
    {
        $loan = Loan::find($id);
        if (!$loan) return ;
        if ($loan->status !==2) return;
        $monthDiff = self::monthDiff($loan->first_due_date, $loan->next_due_date);
        
        $monthDiff -=1;
        
        if ($monthDiff>0){
            if ($loan->loan_type_id==2) {
                $expectToDate = $monthDiff*$loan->monthly_repayment;
                $expectedBalance = $loan->total_repayment-$expectToDate;
                $defaulted= self::computeBalance($id)-$expectedBalance;
                $defaultAmount= ($defaulted>0)? $defaulted: 0;
    
               
            } else {
                $inibal=$loan->amount_approved;
                $monthly= $loan->amount_approved/$loan->period;
                $expectToDate=0;
                for ($i=0; $i < $monthDiff; $i++) {
                    // $expectToDate += $inibal*$loan->percentage *0.01 + $monthly;
                    $inibal -= $monthly;
                }
                
                // $expectedBalance = $inibal-$expectToDate;
                $defaultAmount=self::computeBalance($id)-$inibal;
            }
            if($defaultAmount<0){
                $defaultAmount=0;
            }
            
           

            Loan::where('id', $id)->update([
                'amount_outstanding' =>$defaultAmount,
            ]);

        }
        
        
    }
    
    public function monthDiff($date1, $date2)
    {
        $datetime1 =  date_create($date1);
        $datetime2 =  date_create($date2);
        $interval2 = date_diff($datetime1, $datetime2);
        return $interval2->y*12 + $interval2->m;
    }
    public function nextCycle($date)
    {
        $dt = date_create($date);
        date_modify($dt, '+1 month');
        return date_format($dt, 'Y-m-d');
    }
    public function prevCycle($date)
    {
        $dt = date_create($date);
        date_modify($dt, '-1 month');
        return date_format($dt, 'Y-m-d');
    }
    public function computeBackLog($id)
    {
        $loan = Loan::find($id);
        $monthDiff = self::monthDiff($loan->next_due_date, date('Y-m-d'));
       
            if ($loan->loan_type_id==2) {
                for ($i=0; $i<=$monthDiff; $i++) {
                    $loan = Loan::find($id);
                $expectToDate = $loan->total_interest/$loan->period;
                
                LoanTransaction::create([
                    'loan_id'           => $loan->id,
                    'customer_id'       => $loan->customer_id,
                    'debit'             => $expectToDate ,
                    'credit'            =>  0 ,
                    'transaction_date'  => $loan->next_due_date ,
                    'transaction_type'  => 1,
                    'remarks'  => 'Total Acrued interest',
                ]);
                Loan::where('id', $id)->update([
                    'next_due_date' =>self::nextCycle($loan->next_due_date),
                ]);
            }
            } else {
                $amount  = $loan->amount_approved;
                $monthly = $amount/$loan->period;
                $rate = $loan->percentage*0.01;
                for ($i=0; $i<=$monthDiff; $i++) {
                    $loan = Loan::find($id);
                    $debit = $amount * $rate;
                    $amount -= $monthly;
                    LoanTransaction::create([
                        'loan_id'           => $loan->id,
                        'customer_id'       => $loan->customer_id,
                        'debit'             => $debit ,
                        'credit'            =>  0 ,
                        'transaction_date'  => $loan->next_due_date,
                        'transaction_type'  => 1,
                        'remarks'  => 'Total Acrued interest',
                    ]);
                    Loan::where('id', $id)->update([
                        'next_due_date' =>self::nextCycle($loan->next_due_date),
                    ]);
                }
            
        }
    }
    public function computeDueLoan($date)
    {
        $dueLoans = Loan::where('next_due_date', '<=', $date )
        ->where('status', 2)->get();

        foreach ($dueLoans as $v) {
            self::computeBackLog2($v->id, $date);
            // self::implimentDefaulter($v->id);
        }
    }

    public function computeBackLog2($id, $date)
    {
        while (Loan::where('next_due_date', '<=', $date)->where('id', $id)->where('status', 2)->first()) {
            $debit = self::nextInterest($id);
            $loan = Loan::find($id);
            // if (Loan::where('id', $id)->first()->loan_type_id==2) {
            //     $loan = Loan::find($id);
            //     $debit = $loan->total_interest/$loan->period;
            // } else {
            //     $loan = Loan::find($id);
            //     $rate = $loan->percentage*0.01;
            //     $balance = DB::table('loan_transactions')
            //         ->groupBy('loan_transactions.loan_id')
            //         ->where('loan_id', $id)
            //         ->select(DB::raw('SUM(debit-credit) as balance'))
            //         ->value('balance');
            //     $debit= $balance * $rate;
            // }

            LoanTransaction::create([
                'loan_id'           => $loan->id,
                'customer_id'       => $loan->customer_id,
                'debit'             => $debit ,
                'credit'            =>  0 ,
                'transaction_date'  => $loan->next_due_date,
                'transaction_type'  => 1,
                'remarks'  => 'Interest charge',
            ]);
               
            
            $customer_details = Customer::find($loan->customer_id);
            $ref = AccountTrait::RefNo();
            AccountTrait::debitAccount($customer_details->account_id,
            $debit,
                $ref, $loan->next_due_date,
                'Interest charge: '.$customer_details->first_name, Auth::User()->id, $ref
            );
            $account= DB::table('account_setups')->where('id',1)->value('account_id');
            AccountTrait::creditAccount(
                $account,
                $debit,
                $ref, $loan->next_due_date,
                'Interest charge: '. $customer_details->first_name, Auth::User()->id, $ref);
            Loan::where('id', $id)->update([
                'next_due_date' =>self::nextCycle($loan->next_due_date),
            ]);
                
            }
            self::implimentDefaulter($id);
        }

        public function computeBalance($id)
        {
            return DB::table('loan_transactions')->groupBy('loan_transactions.loan_id')
            ->where('loan_id', $id)->select( DB::raw('SUM(debit-credit) as balance'))->value('balance');
        }
        public function nextInterest($id)
        {
            if (Loan::where('id', $id)->first()->loan_type_id==2) {
                $loan = Loan::find($id);
                $debit = $loan->total_interest/$loan->period;
            } else {
                $loan = Loan::find($id);
                $rate = $loan->percentage*0.01;
                $balance = DB::table('loan_transactions')
                    ->groupBy('loan_transactions.loan_id')
                    ->where('loan_id', $id)
                    ->select(DB::raw('SUM(debit-credit) as balance'))
                    ->value('balance');
                $debit= $balance * $rate;
            }
            return $debit;
        }
}