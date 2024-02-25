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
use App\Http\Traits\LoanTrait;
use App\Http\Traits\SessionTrait;
use App\Http\Traits\AccountTrait;
use App\Models\Rate;
use App\Models\AccountChart;
use App\Models\CustomerNote;

class LoanTransactionController extends Controller
{
    function __construct(){
        define("REGEX", "/[^\d.]/");
    }
    
    
    public function index(Request $request)
    {
        
        if(!(URL::previous()==URL::current() )){
            $request->session()->forget('customer');
            $request->session()->forget('marketer');
            $request->session()->forget('amount');
        }

        $data['customer'] = SessionTrait::validate($request, 'customer');
        $data['marketer'] = SessionTrait::validate($request, 'marketer');
        $data['amount'] = SessionTrait::validate($request, 'amount');
        $data['period'] = SessionTrait::validate($request, 'period');
        $data['remarks'] = SessionTrait::validate($request, 'remarks');
        $data['calculator'] = SessionTrait::validate($request, 'calculator');
        $data['loanType'] = SessionTrait::validate($request, 'loanType');

        $data['rate']=$request->input('rate');
        if ($data['rate']=='') {$data['rate']= Rate::find(1)->value('rate');}

        if (isset ($_POST['addnew'])) {
            $this->validate($request,
            [
                'customer'  => 'required|integer',
                'amount'    => 'required',
                'rate'      => 'required',
                'marketer'  => 'required',
                'period'  => 'required',
                'calculator'  => 'required',
            ],
            [
                'customer.integer' => 'customer field is required',
            ]);
            $amount = preg_replace(REGEX, '', $request->input('amount'))?? 0 ;
            $rate = $request->input('rate')*0.01;
            $period= $request->input('period');
            $totalInterest = 0;
            $virtualAmount=$amount;
            $monthlyp= $amount/$period;
            for ($i=1; $i <= $period; $i++) {
				$totalInterest += $virtualAmount*$rate;
				$virtualAmount -= $monthlyp;
			}
            $totalRepayment=$totalInterest+$amount;
            $monthlyRepayment = $totalRepayment/$period;

                Loan::create([
                'customer_id' => $request->input('customer'),
                'marketer_id' => $request->input('marketer'),
                'amount' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'amount_marketer' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'amount_accountant' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'amount_approved' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'period' => $request->input('period'),
                'percentage' => $request->input('rate'),
                'total_interest' => $totalInterest,
                'monthly_repayment' => $monthlyRepayment,
                'total_repayment' => $totalRepayment,
                'remarks' => $request->input('loanType'),
                'loan_type_id' => $request->input('calculator'),
                'stage' => 1,
            ]);
            $request->session()->forget('marketer');
            $request->session()->forget('amount');
            $request->session()->forget('period');
            $request->session()->forget('rate');
            $request->session()->forget('interest');
            $request->session()->forget('monthlyRepayment');
            $request->session()->forget('remarks');
            return back()->with('message', 'New record successfully added.');
        }

        if (isset($_POST['update'])|| isset($_POST['submit'])) {
            $this->validate($request, [
                'customer'  => 'required',
                'amount'    => 'required',
                'rate'      => 'required',
                'marketer'  => 'required',
                'period'  => 'required',
                'calculator'  => 'required',
            ]);
            $amount = preg_replace(REGEX,'', $request->input('amount'))?? 0 ;
            $rate = $request->input('rate')*0.01;
            $period= $request->input('period');
            $totalInterest = 0;
            $virtualAmount=$amount;
            $monthlyp= $amount/$period;
            for ($i=1; $i <= $period; $i++) {
				$totalInterest += $virtualAmount*$rate;
				$virtualAmount -= $monthlyp;
			}
            $totalRepayment=$totalInterest+$amount;
            $monthlyRepayment = $totalRepayment/$period;

                Loan::where('id', $request->input('id'))->update([
                'customer_id' => $request->input('customer'),
                'marketer_id' => $request->input('marketer'),
                'amount' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'amount_marketer' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'amount_accountant' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'amount_approved' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'period' => $request->input('period'),
                'percentage' => $request->input('rate'),
                'total_interest' => $totalInterest,
                'monthly_repayment' => $monthlyRepayment,
                'total_repayment' => $totalRepayment,
                'stage' => isset($_POST['submit'])? 2 : 1,
                'loan_type_id' => $request->input('calculator'),
            ]);
            $request->session()->forget('marketer');
            $request->session()->forget('amount');
            $request->session()->forget('period');
            $request->session()->forget('rate');
            $request->session()->forget('interest');
            $request->session()->forget('monthlyRepayment');
            $request->session()->forget('remarks');
            return back()->with('message', 'New record successfully added.');
        }
        if (isset($_POST['delete'] ) ) {
            Loan::destroy($request->input('id'));
            return back()->with('message', ' Record successfully trashed.');
        }

        
        $data['Loans']= Loan::where('stage', '=', 1)
            ->where('customer_id', ($data['customer']=='All'||$data['customer']=='')? '<>':'=', $data['customer'])
            ->leftJoin('users', 'users.id', '=', 'loans.marketer_id')
            ->leftJoin('customers', 'customers.id', '=', 'loans.customer_id')
            ->leftJoin('loan_types', 'loan_types.id', '=', 'loans.loan_type_id')
            ->select('loans.*',
             'customers.first_name',
             'customers.middle_name',
             'customers.last_name',
            'users.name',
            'loan_types.particular'
            )
            ->get();
        $data['calculators']= DB::table('loan_types')->get();
        $data['customers']= Customer::where('status',1)->get();
        $data['is_return_customer']= Loan::where('customer_id', '=', $data['customer'])->first();

        $data['Marketers']= User::where('userrole', 3)->get();
            return view('loan.index', $data);
                
    }
     
    public function marketerReview(Request $request)
    {
        $data['remarks'] = SessionTrait::validate($request, 'remarks');

        if (isset ($_POST['update'])||isset ($_POST['submit'])) {
            $this->validate($request, [
                'amount'    => 'required',
                'rate'      => 'required',
                'period'  => 'required',
                'calculator'  => 'required',
            ]);
            $amount = preg_replace(REGEX,'', $request->input('amount'))?? 0 ;
            $rate = $request->input('rate')*0.01;
            $period= $request->input('period');
            $totalInterest = 0;
            $virtualAmount=$amount;
            $monthlyp= $amount/$period;
            for ($i=1; $i <= $period; $i++) {
				$totalInterest += $virtualAmount*$rate;
				$virtualAmount -= $monthlyp;
			}
            $totalRepayment=$totalInterest+$amount;
            $monthlyRepayment = $totalRepayment/$period;
                Loan::where('id', $request->input('id'))->update([
                'amount_marketer' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'amount_accountant' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'amount_approved' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'period' => $request->input('period'),
                'total_interest' => $totalInterest,
                'monthly_repayment' => $monthlyRepayment,
                'total_repayment' => $totalRepayment,
                'stage' => isset($_POST['submit'])? 3 : 2,
                'loan_type_id' => $request->input('calculator'),
            ]);
            
            if ($request->input('remarks')) {
                CustomerNote::create([
                    'customer_id' => Loan::find($request->input('id'))->value('customer_id'),
                    'loan_id' => $request->input('id'),
                    'notes' => $request->input('remarks') ,
                    'created_by' => Auth::User()->id ,
                ]);
            }
            $request->session()->forget('remarks');
            return back()->with('message', 'New record successfully added.');
        }
        if ( isset($_POST['delete']) ) {
            Loan::destroy($request->input('id'));
            return back()->with('message', ' Record successfully trashed.');
        }

        if ( isset($_POST['decline']) ) {
            Loan::where('id', $request->input('id'))->update([
                'stage' =>  1,
            ]);
            if ($request->input('remarks')) {
                CustomerNote::create([
                    'customer_id' => Loan::find($request->input('id'))->value('customer_id'),
                    'loan_id' => $request->input('id'),
                    'notes' => $request->input('remarks') ,
                    'created_by' => Auth::User()->id ,
                ]);
            }
            return back()->with('message', ' Record successfully declined.');
        }

        $data['Loans']= Loan::where('stage', '=', 2)
            ->where('marketer_id', '=', Auth::User()->id)
            ->leftJoin('users', 'users.id', '=', 'loans.marketer_id')
            ->leftJoin('customers', 'customers.id', '=', 'loans.customer_id')
            ->leftJoin('loan_types', 'loan_types.id', '=', 'loans.loan_type_id')
            ->select('loans.*',
             'customers.first_name',
             'customers.middle_name',
             'customers.last_name',
            'users.name',
            'loan_types.particular'
            ) ->get();
        $data['customers']= Customer::all();
        $data['Marketers']= User::where('userrole', 3)->get();
        $data['calculators']= DB::table('loan_types')->get();
        return view('loan.marketer', $data);
                
    }

    public function accountantReview(Request $request)
    {
        
        $data['remarks'] = SessionTrait::validate($request, 'remarks');

        if (isset ($_POST['update'])||isset ($_POST['submit'])) {
            $this->validate($request, [
                'amount'    => 'required',
                'rate'      => 'required',
                'period'  => 'required',
                'calculator'  => 'required',
            ]);
            $amount = preg_replace(REGEX,'', $request->input('amount'))?? 0 ;
            $rate = $request->input('rate')*0.01;
            $period= $request->input('period');
            $totalInterest = 0;
            $virtualAmount=$amount;
            $monthlyp= $amount/$period;
            for ($i=1; $i <= $period; $i++) {
				$totalInterest += $virtualAmount*$rate;
				$virtualAmount -= $monthlyp;
			}
            $totalRepayment=$totalInterest+$amount;
            $monthlyRepayment = $totalRepayment/$period;
                Loan::where('id', $request->input('id'))->update([
                'amount_accountant' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'amount_approved' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'period' => $request->input('period'),
                'total_interest' => $totalInterest,
                'monthly_repayment' => $monthlyRepayment,
                'total_repayment' => $totalRepayment,
                'percentage' => $request->input('rate'),
                'accountant_id' => Auth::User()->id,
                'stage' => isset($_POST['submit'])? 4 : 3,
                'loan_type_id' => $request->input('calculator'),
            ]);
            if ($request->input('remarks')) {
                CustomerNote::create([
                    'customer_id' => Loan::find($request->input('id'))->value('customer_id'),
                    'loan_id' => $request->input('id'),
                    'notes' => $request->input('remarks') ,
                    'created_by' => Auth::User()->id ,
                ]);
            }
           
            $request->session()->forget('remarks');
            return back()->with('message', 'New record successfully added.');
        }

        if ( isset($_POST['decline']) ) {
            Loan::where('id', $request->input('id'))->update([
                'stage' =>  2,
            ]);
            if ($request->input('remarks')) {
                CustomerNote::create([
                    'customer_id' => Loan::find($request->input('id'))->value('customer_id'),
                    'loan_id' => $request->input('id'),
                    'notes' => $request->input('remarks') ,
                    'created_by' => Auth::User()->id ,
                ]);
            }
            return back()->with('message', ' Record successfully declined.');
        }

        $data['Loans']= Loan::where('stage', '=', 3)->leftJoin('users', 'users.id', '=', 'loans.marketer_id')
            ->leftJoin('customers', 'customers.id', '=', 'loans.customer_id')
            ->select('loans.*', 'customers.first_name', 'customers.middle_name', 'customers.last_name', 'users.name')
            ->get();
        $data['customers']= Customer::all();
        $data['Marketers']= User::where('userrole', 3)->get();
        $data['calculators']= DB::table('loan_types')->get();
            return view('loan.accountant', $data);
                
    }
     public function analystReview(Request $request)
    {
        
        $data['remarks'] = SessionTrait::validate($request, 'remarks');

        if (isset ($_POST['update'])||isset ($_POST['submit'])) {
            $this->validate($request, [
                'amount'    => 'required',
                'rate'      => 'required',
                'period'  => 'required',
                'calculator'  => 'required',
            ]);
            $amount = preg_replace(REGEX,'', $request->input('amount'))?? 0 ;
            $rate = $request->input('rate')*0.01;
            $period= $request->input('period');
            $totalInterest = 0;
            $virtualAmount=$amount;
            $monthlyp= $amount/$period;
            for ($i=1; $i <= $period; $i++) {
				$totalInterest += $virtualAmount*$rate;
				$virtualAmount -= $monthlyp;
			}
            $totalRepayment=$totalInterest+$amount;
            $monthlyRepayment = $totalRepayment/$period;
                Loan::where('id', $request->input('id'))->update([
                'amount_accountant' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'amount_approved' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'period' => $request->input('period'),
                'total_interest' => $totalInterest,
                'monthly_repayment' => $monthlyRepayment,
                'total_repayment' => $totalRepayment,
                'percentage' => $request->input('rate'),
                'accountant_id' => Auth::User()->id,
                'stage' => isset($_POST['submit'])? 5 : 4,
                'loan_type_id' => $request->input('calculator'),
            ]);
            if ($request->input('remarks')) {
                CustomerNote::create([
                    'customer_id' => Loan::find($request->input('id'))->value('customer_id'),
                    'loan_id' => $request->input('id'),
                    'notes' => $request->input('remarks') ,
                    'created_by' => Auth::User()->id ,
                ]);
            }
           
            $request->session()->forget('remarks');
            return back()->with('message', 'New record successfully added.');
        }
        if ( isset($_POST['decline']) ) {
            Loan::where('id', $request->input('id'))->update([
                'stage' =>  3,
            ]);
            if ($request->input('remarks')) {
                CustomerNote::create([
                    'customer_id' => Loan::find($request->input('id'))->value('customer_id'),
                    'loan_id' => $request->input('id'),
                    'notes' => $request->input('remarks') ,
                    'created_by' => Auth::User()->id ,
                ]);
            }
            return back()->with('message', ' Record successfully declined.');
        }
        $data['Loans']= Loan::where('stage', '=', 4)->leftJoin('users', 'users.id', '=', 'loans.marketer_id')
            ->leftJoin('customers', 'customers.id', '=', 'loans.customer_id')
            ->select('loans.*', 'customers.first_name', 'customers.middle_name', 'customers.last_name', 'users.name')
            ->get();
        $data['customers']= Customer::all();
        $data['Marketers']= User::where('userrole', 3)->get();
        $data['calculators']= DB::table('loan_types')->get();
            return view('loan.analyst', $data);
                
    }

    public function finalReview(Request $request)
    {
        
        $data['remarks'] = SessionTrait::validate($request, 'remarks');
        if (isset ($_POST['update'])||isset ($_POST['submit'])) {
            $this->validate($request, [
                'amount'    => 'required',
                'approvalDate'    => 'required|date',
                'rate'      => 'required',
                'period'  => 'required',
                'calculator'  => 'required',
            ]);
            $amount = preg_replace(REGEX,'', $request->input('amount'))?? 0 ;
            $rate = $request->input('rate')*0.01;
            $period= $request->input('period');
            $totalInterest = 0;
            $virtualAmount=$amount;
            $monthlyp= $amount/$period;
            for ($i=1; $i <= $period; $i++) {
				$totalInterest += $virtualAmount*$rate;
				$virtualAmount -= $monthlyp;
			}
            $totalRepayment=$totalInterest+$amount;
            $monthlyRepayment = $totalRepayment/$period;
                Loan::where('id', $request->input('id'))->update([
                'amount_approved' => preg_replace(REGEX, '', $request->input('amount'))?? 0 ,
                'period' => $request->input('period'),
                'percentage' => $request->input('rate'),
                'total_interest' => $totalInterest,
                'percentage' => $request->input('rate'),
                'monthly_repayment' => $monthlyRepayment,
                'total_repayment' => $totalRepayment,
                'approver_id' => Auth::User()->id,
                'approval_date' => $request->input('approvalDate'),
                'stage' => isset($_POST['submit'])? 6 : 5,
                'status' => isset($_POST['submit'])? 1 : 0,
                'loan_type_id' => $request->input('calculator'),
            ]);

            $customer_details = Customer::find(Loan::where('id', $request->input('id'))->value('customer_id'));
            if ($request->input('remarks')) {
            CustomerNote::create([
                'customer_id' => $customer_details->id,
                'loan_id' => $request->input('id'),
                'notes' => $request->input('remarks') ,
                'created_by' => Auth::User()->id ,
            ]);
        }
            $request->session()->forget('remarks');
            return back()->with('message', 'New record successfully added.');
        }
        if ( isset($_POST['delete']) ) {
            Loan::destroy($request->input('id'));
            return back()->with('message', ' Record successfully trashed.');
        }

        if ( isset($_POST['reject']) ) {
            Loan::where('id', $request->input('id'))->update([
                'stage' =>  8,
                'status' => 9,
            ]);
            if ($request->input('remarks')) {
                CustomerNote::create([
                    'customer_id' => Loan::find($request->input('id'))->value('customer_id'),
                    'loan_id' => $request->input('id'),
                    'notes' => $request->input('remarks') ,
                    'created_by' => Auth::User()->id ,
                ]);
            }
            return back()->with('message', ' Record successfully rejected.');
        }

        if ( isset($_POST['decline']) ) {
            Loan::where('id', $request->input('id'))->update([
                'stage' =>  4,
            ]);
            if ($request->input('remarks')) {
                CustomerNote::create([
                    'customer_id' => Loan::find($request->input('id'))->value('customer_id'),
                    'loan_id' => $request->input('id'),
                    'notes' => $request->input('remarks') ,
                    'created_by' => Auth::User()->id ,
                ]);
            }
            return back()->with('message', ' Record successfully declined.');
        }
        $data['Loans']= Loan::where('stage', '=', 5 )->leftJoin('users', 'users.id', '=', 'loans.marketer_id')

            ->leftJoin('customers', 'customers.id', '=', 'loans.customer_id')
            ->select('loans.*', 'customers.first_name', 'customers.middle_name', 'customers.last_name', 'users.name')
            ->get();
        $data['customers']= Customer::all();
        $data['Marketers']= User::where('userrole', 3)->get();
        $data['calculators']= DB::table('loan_types')->get();
        return view('loan.final', $data);
                
    }

    public function disbursement(Request $request)
    {
        $data['remarks'] = SessionTrait::validate($request, 'remarks');
        $data['bank'] = SessionTrait::validate($request, 'bank');
        $data['disbursedDate'] = SessionTrait::validate($request, 'disbursedDate');
        $data['firstDueDate'] = SessionTrait::validate($request, 'firstDueDate');
        $data['percentage'] =DB::table('fee_charges')->where('id', 2)->value('amount');

        if (isset ($_POST['process'])) {
            $data['bank'] = SessionTrait::validate($request, 'bank');
            $data['paymentDate'] = SessionTrait::validate($request, 'paymentDate');
            $percentage =DB::table('fee_charges')->where('id', 2)->value('amount');
    
                $this->validate($request, [
                    'paymentDate'    => 'required',
                    'bank'    => 'required',
                ]);
                Loan::where('id', $request->input('id'))->update([
                    'is_processed' =>  1 ,
                ]);
    
                $loan = Loan::find($request->input('id'));
               
                $customer_details = Customer::find($loan->customer_id);
                $ref = AccountTrait::RefNo();
                $amount =$loan->amount_approved*$percentage*0.01;
                AccountTrait::debitAccount( $request->input('bank'),
                $amount,
                    $ref,  $request->input('paymentDate'),
                    'Processing fees: '.$customer_details->first_name, Auth::User()->id, $ref
                );
               
                $account= DB::table('account_setups')->where('id', 3)->value('account_id');
                AccountTrait::creditAccount(
                    $account,
                    $amount,
                    $ref,
                    $request->input('paymentDate'),
                    'Processing fees: '. $customer_details->first_name,
                    Auth::User()->id,
                     $ref
                );
                return back()->with('message', 'successfully update.');

        }
        if (isset ($_POST['update'])||isset ($_POST['submit'])) {
            $this->validate($request, [
                'disbursedDate'    => 'required',
                'firstDueDate'    => 'required',
                'bank'    => 'required',
            ]);
            Loan::where('id', $request->input('id'))->update([
                'disbursed_date' =>$request->input('disbursedDate'),
                'first_due_date' =>LoanTrait::prevCycle($request->input('firstDueDate')),
                'next_due_date' =>$request->input('firstDueDate'),
                'stage' => 7,
                'status' =>  2 ,
            ]);

            $loan = Loan::find($request->input('id'));
            LoanTransaction::create([
                'loan_id'           => $loan->id,
                'customer_id'       => $loan->customer_id,
                'debit'             => $loan->amount_approved ,
                'credit'            =>  0 ,
                'transaction_date'  => $request->input('disbursedDate') ,
                'transaction_type'  => 1,
                'remarks'  => "Loan disbursement",
            ]);
            $customer_details = Customer::find($loan->customer_id);
            AccountTrait::debitAccount(
                $customer_details->account_id,
                $loan->amount_approved,
                'ref', $request->input('disbursedDate'),
                'Loan disbursement '.$customer_details->first_name, Auth::User()->id, 'manual_ref'
            );
            AccountTrait::creditAccount(
                $data['bank'],
                $loan->amount_approved,
                'ref', $request->input('disbursedDate'),
                'Loan disbursement '. $customer_details->first_name, Auth::User()->id, 'manual_ref');
            // LoanTrait::computeBackLog($request->input('id'));
            LoanTrait::implimentDefaulter($request->input('id'));

            if ($request->input('remarks')) {
                CustomerNote::create([
                    'customer_id' => Loan::find($request->input('id'))->value('customer_id'),
                    'loan_id' => $request->input('id'),
                    'notes' => $request->input('remarks') ,
                    'created_by' => Auth::User()->id ,
                ]);
            }
            $request->session()->forget('remarks');
            return back()->with('message', 'New record successfully added.');
        }
        $data['Loans']= Loan::where('stage', '=', 6)->leftJoin('users', 'users.id', '=', 'loans.marketer_id')
            ->leftJoin('customers', 'customers.id', '=', 'loans.customer_id')
            ->select('loans.*', 'customers.first_name', 'customers.middle_name', 'customers.last_name', 'users.name')
            ->get();
        $data['banks'] = AccountChart::where('subheadid', 3)->get();
        $data['customers']= Customer::all();
        $data['Marketers']= User::where('userrole', 3)->get();
            return view('loan.disbursement', $data);
                
    }
    public function processPayment(Request $request)
    {
       
        $data['bank'] = SessionTrait::validate($request, 'bank');
        $data['paymentDate'] = SessionTrait::validate($request, 'paymentDate');
        $percentage =DB::table('fee_charges')->where('id', 2)->value('amount');

            $this->validate($request, [
                'paymentDate'    => 'required',
                'bank'    => 'required',
            ]);
            Loan::where('id', $request->input('id'))->update([
                'is_processed' =>  1 ,
            ]);

            $loan = Loan::find($request->input('id'));
           
            $customer_details = Customer::find($loan->customer_id);
            $ref = AccountTrait::RefNo();
            $amount =$loan->amount_approved*$percentage*0.01;
            AccountTrait::debitAccount( $request->input('bank'),
            $amount,
                $ref,  $request->input('paymentDate'),
                'Processing fees: '.$customer_details->first_name, Auth::User()->id, $ref
            );
           
            $account= DB::table('account_setups')->where('id', 3)->value('account_id');
            AccountTrait::creditAccount(
                $account,
                $amount,
                $ref,
                $request->input('paymentDate'),
                'Processing fees: '. $customer_details->first_name,
                Auth::User()->id,
                 $ref
            );

            return redirect('/');
                
    }

    public function schedule(Request $request)
    {
        
        if(!(URL::previous()==URL::current() )){
           
            $request->session()->forget('amount');
        }

        
        $data['amount'] = SessionTrait::validate($request, 'amount');
        $data['period'] = SessionTrait::validate($request, 'period');
        $data['rate']=$request->input('rate');
        $result=[];
        if ($data['rate']=='') {$data['rate']= Rate::find(1)->value('rate');}

        if (isset ($_POST['addnew'])) {
            $this->validate($request,
            [
                
                'amount'    => 'required',
                'rate'      => 'required',
                'period'  => 'required',
               
            ]);
            $amount = preg_replace(REGEX, '', $request->input('amount'))?? 0 ;
            $rate = $request->input('rate')*0.01;
            $period= $request->input('period');
            $totalInterest = 0;
            $virtualAmount=$amount;
            $monthlyp= $amount/$period;
            $balance = $amount;

            for ($i=1; $i <= $period; $i++) {
                $interest=$virtualAmount*$rate;
				$totalInterest += $interest;
				$virtualAmount -= $monthlyp;
                $result[]=(object)['opening_balance'=>$balance,'interest'=>$interest,'repayment'=>$interest+$monthlyp,'balance'=>$amount-($monthlyp*$i)];
                $balance -= $monthlyp;
            }

            // dd($result);
            $totalRepayment=$totalInterest+$amount;
            $monthlyRepayment = $totalRepayment/$period;
               
        } 
        $data['Loans'] =$result;
            return view('loan.schedule', $data);
                
    }
}
