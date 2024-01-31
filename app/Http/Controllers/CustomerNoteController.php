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

class CustomerController extends Controller
{
    function __construct(){
        define("REGEX", "/[^\d.]/");
        define("MYID", Customer::where('user_id', Auth::user()->id)->value('id') );
    }
    public function repayment(Request $request)
    {
        
        if(!(URL::previous()==URL::current() )){
            $request->session()->forget('details');
            $request->session()->forget('amount');
        }
        $data['loan']=$request->input('loan');
        if ($data['loan']=='') {$data['loan']=Session::get('loan');}
        Session(['loan' => $data['loan']]);

        $data['amount']=$request->input('amount');
        if ($data['amount']=='') {$data['amount']=Session::get('amount');}
        if ($data['amount']=='') {$data['amount']= Loan::find($data['loan'])['amount_outstanding'];}
        Session(['amount' => $data['amount']]);



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
                ],
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
                ],
            );
            $amount = preg_replace(REGEX, '', $request->input('amount'))?? 0 ;
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
        $data['Loans2']= DB::table('loan_transactions')
        ->where('customer_id', MYID)
        ->groupBy('loan_transactions.loan_id')
        ->groupBy('customers.first_name')
        ->groupBy('customers.middle_name')
        ->groupBy('customers.last_name')
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
        return view('customer.repayment', $data);
                
    }

    
}
