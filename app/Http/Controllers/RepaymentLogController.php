<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Auth;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Input;
use Session;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Loan;
use App\Models\User;
use App\Models\LoanTransaction;
use App\Models\RepaymentLog;
use App\Http\Traits\LoanTrait;
use App\Models\AccountChart;
use App\Http\Traits\AccountTrait;
use App\Models\CustomerNote;

class RepaymentLogController extends Controller
{
    function __construct(){
        define("REGEX", "/[^\d.]/");
    }
    public function index(Request $request)
    {
        
        if(!(URL::previous()==URL::current() )){
            $request->session()->forget('details');
            $request->session()->forget('amount');
        }
        $data['loan']=$request->input('loan');
        if ($data['loan']=='') {$data['loan']=Session::get('loan');}
        Session(['loan' => $data['loan']]);

        $data['amount']= Loan::find($data['loan'])['amount_outstanding']??0;


        $data['details']=$request->input('details');
        if ($data['details']=='') {$data['details']=Session::get('details');}
        Session(['details' => $data['details']]);

        if (isset ($_POST['addnew'])) {
            $this->validate(
                $request,
                [
                    'loan'  => 'required',
                    'amount'    => 'required',
                    'details'      => 'required',
                    'paymentDate'  => 'required',
                ]
            );
            $amount = preg_replace(REGEX, '', $request->input('amount'))?? 0 ;
            RepaymentLog::create([
                'customer_id' => Loan::find($request->input('loan'))->customer_id,
                'loan_id' => $request->input('loan'),
                'amount' => $amount ,
                'details' => $request->input('details'),
                'payment_date' => $request->input('paymentDate') ,
                'created_by'=> Auth::user()->id,
            ]);
            $request->session()->forget('amount');
            $request->session()->forget('details');
            $request->session()->forget('paymentDate');
            return back()->with('message', 'New record successfully added.');
        }

        if (isset($_POST['update'])|| isset($_POST['submit'])) {
            $this->validate(
                $request,
                [
                    'amount'    => 'required',
                    'details'      => 'required',
                    'paymentDate'  => 'required',
                ]
            );
            $amount = preg_replace(REGEX,'', $request->input('amount'))?? 0 ;
            RepaymentLog::where('id', $request->input('id'))->update([
                'amount' => $amount ,
                'details' => $request->input('details'),
                'payment_date' => $request->input('paymentDate') ,
            ]);
            $request->session()->forget('amount');
            $request->session()->forget('details');
            $request->session()->forget('paymentDate');
            return back()->with('message', 'New record successfully added.');
        }
        if (isset($_POST['delete'] ) ) {
            RepaymentLog::destroy($request->input('id'));
            return back()->with('message', ' Record successfully trashed.');
        }
        $data['Loans'] = RepaymentLog::where('loan_id', '=', $data['loan'])->get();
        // $data['Loans2']= LoanTransaction::groupBy('loan_id')
        $data['Loans2']= DB::table('loan_transactions')->groupBy('loan_transactions.loan_id')
        ->groupBy('customers.first_name')
        ->groupBy('customers.middle_name')
        ->groupBy('customers.last_name')
         ->groupBy('loans.amount_approved')
         ->groupBy('loans.amount_outstanding')
            ->leftJoin('customers', 'customers.id', '=', 'loan_transactions.customer_id')
            ->leftJoin('loans', 'loans.id', '=', 'loan_transactions.loan_id')
            ->select(
                'loan_transactions.loan_id',
                'loans.amount_approved',
                'loans.amount_outstanding',
                'customers.first_name',
                'customers.middle_name',
                'customers.last_name',
                DB::raw('SUM(debit-credit) as balance')
            )
            ->havingRaw('SUM(debit-credit) > ?', [0])
            ->get();

            // dd($data['Loans']);
        $data['customers']= Customer::all();
        

        // dd($data['loanDetails']);
        return view('payment.repayment', $data);
                
    }

    public function approval(Request $request)
    {
        
        if (isset($_POST['update'])|| isset($_POST['submit'])) {
            $this->validate(
                $request,
                [
                    'amount'    => 'required',
                    'bank'    => 'required',
                    'details'      => 'required',
                    'paymentDate'  => 'required',
                ]
            );
            

            $details = RepaymentLog::find($request->input('id'));
            
            $balance = LoanTrait::computeBalance($details->loan_id);
            $loan=Loan::find($details->loan_id);
            if ((float)$balance < (float)$details->amount) {
                return back()->with('error_message', 'Amount deposit cannot be greater than balance.');
            }
            if (((float)$loan->amount_outstanding < (float)$details->amount) && $loan->status != 4 ) {
                
                $expectedNextRepayent = LoanTrait::nextRepayment($details->loan_id);
                if((float)$expectedNextRepayent < (float)$details->amount){
                return back()->with('error_message', 'You cannot pay advance unless you liquidate.');
                }
                LoanTrait::computeBackLog2($details->loan_id, $loan->next_due_date);
                
            }
            RepaymentLog::where('id', $request->input('id'))->update([
                'is_approved' => 1,
                'payment_date' => $request->input('paymentDate'),
                'approved_by' => Auth::user()->id,
            ]);
            LoanTransaction::create([
                'loan_id'           => $details->loan_id,
                'customer_id'       => $details->customer_id,
                'debit'             => 0 ,
                'credit'            =>  $details->amount ,
                'transaction_date'  => $request->input('paymentDate') ,
                'transaction_type'  => 2,
                'remarks'  => "Loan repayment with ref to $details->details",
            ]);
            $customer_details = Customer::find($details->customer_id);
            AccountTrait::creditAccount(
                $customer_details->account_id,
                $details->amount,
                'ref', $request->input('paymentDate'),
                'Loan repayment: '. $request->input('remarks'), Auth::User()->id, 'manual_ref'
            );
            AccountTrait::debitAccount(
                $request->input('bank'),
                $details->amount,
                'ref', $request->input('paymentDate'),
                'Loan repayment: '. $request->input('remarks'), Auth::User()->id, 'manual_ref');
           
            if ($request->input('remarks')) {
                CustomerNote::create([
                    'customer_id' => $details->customer_id,
                    'loan_id' => $details->loan_id,
                    'notes' => $request->input('remarks') ,
                    'created_by' => Auth::User()->id ,
                ]);
            }
            LoanTrait::implimentDefaulter($details->loan_id);

            if (round((float)LoanTrait::computeBalance($details->loan_id))==(float)round(0)) {
                Loan::where('id', $details->loan_id)->update([
                    'status' => 3,
                ]);

            }
            return back()->with('message', 'New record successfully added.');
        }
        
        $data['Loans'] = RepaymentLog::where('is_approved', '=', 0)
            ->leftJoin('customers', 'customers.id', '=', 'repayment_logs.customer_id')
            ->select(
                'repayment_logs.*',
                'customers.first_name',
                'customers.middle_name',
                'customers.last_name'
            )->get();
        $data['banks'] = AccountChart::where('subheadid', 3)->get();
        return view('payment.approval', $data);
                
    }
}
