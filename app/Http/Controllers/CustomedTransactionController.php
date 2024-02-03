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
use App\Models\Title;
use App\Models\User;
use App\Models\LoanTransaction;
use App\Http\Traits\LoanTrait;
use App\Models\RepaymentLog;
use App\Models\CustomerNote;
use App\Models\LoanStatus;
use App\Http\Traits\SessionTrait;
use App\Http\Traits\AccountTrait;

class CustomedTransactionController extends Controller
{
    function __construct(){
        define("REGEX", "/[^\d.]/");
    }
    
    public function upload(Request $request)
    {
        
        
        if (URL::previous()!==URL::current()) {
            $request->session()->forget('transactionType');
           
        }
        $data['transactionType'] = $request->input('transactionType');
        if ($data['transactionType'] == '') {$data['transactionType'] = Session::get('transactionType');}
        Session(['transactionType' => $data['transactionType']]);

        
       

           $data['toDate']=$request->input('toDate');
           if($data['toDate']==""){$data['toDate']=date("Y-m-d");}

           $data['fromDate']=$request->input('fromDate');
           if($data['fromDate']==""){$data['fromDate']=date("Y").'-01-01';}

           if (isset($_POST['addnew'])) {
            $this->validate($request, [
                'description' => 'required|string|unique:tblautomated_record,upload_title',
            ]);
            $refno = $this->RefNo();
            
            $mimes = array('application/vnd.ms-excel', 'text/csv', 'text/tsv');
            $file = $_FILES['upload']['tmp_name'];
            if (($file == "") || !(in_array($_FILES['upload']['type'], $mimes))) {return back()->with('error_message', 'Invalid file.');} else {

                $handle = fopen($file, "r");
                $c = 0;
                while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {

                    $tmpphoneno = $filesop[0];
                    $tmpvalue = $filesop[1];
                    if ($c == 0 || $tmpphoneno == "" || $tmpvalue == "") {
                        $c = 1;
                    } else {
                       
                        if (($filesop[9] == 'successful')) {
                            $transdate = $this->UpdatetransactionDate($filesop[0]);
                            $filesop5 = preg_replace('/[^\d.]/', '', $filesop[5]);
                            $filesop6 = preg_replace('/[^\d.]/', '', $filesop[6]);
                            $filesop7 = preg_replace('/[^\d.]/', '', $filesop[7]);
                            $filesop11 = preg_replace('/[^\d.]/', '', $filesop[11]);
                            $filesop12 = preg_replace('/[^\d.]/', '', $filesop[12]);
                            $filesop13 = preg_replace('/[^\d.]/', '', $filesop[13]);
                            $filesop14 = preg_replace('/[^\d.]/', '', $filesop[14]);
                            DB::table('tblautomated_record')->insert([
                                'date_time' => $filesop[0],
                                'trans_date' => $transdate,
                                'agent' => $filesop[1],
                                'organisation' => $filesop[2],
                                'product_type' => $filesop[3],
                                'bankpos' => $filesop[4],
                                'debit' => !is_numeric($filesop5) ? 0 : $filesop5,
                                'credit' => !is_numeric($filesop6) ? 0 : $filesop6,
                                'fees' => !is_numeric($filesop7) ? 0 : $filesop7,
                                'third_party_ref' => $filesop[8],
                                'status' => $filesop[9],
                                'ref_no' => $filesop[10],
                                'bank_charge' => !is_numeric($filesop11) ? 0 : $filesop11,
                                'agentcom' => !is_numeric($filesop12) ? 0 : $filesop12,
                                'payrepcom' => !is_numeric($filesop13) ? 0 : $filesop13,
                                'discount' => !is_numeric($filesop14) ? 0 : $filesop14,
                                'process_status' => 0,
                                'upload_title' => $data['description'],
                                'upload_batch' => $refno,
                                'is_old' => $data['isold'] ? $data['isold'] : 0,

                            ]);
                        }
                    }
                }
            }
            return back()->with('message', 'record successfully updated.');
        }
       
        $data['records']= [];

        $data['transactionTypes']= LoanStatus::all();
   
        return view('customedTransaction.upload', $data);
                
    }
    public function loanDetails(Request $request)
    {
        ini_set('max_execution_time', 0);
        if (URL::previous()!==URL::current()) {
            $request->session()->forget('loan');
            $request->session()->forget('status');
            $request->session()->forget('description');
        }
        $data['percentage'] =DB::table('fee_charges')->where('id', 3)->value('amount');
        $data['loan']= $request->input('loan');
        if ($data['loan']=='') {$data['loan']=Session::get('loan');}
        Session(['loan' => $data['loan']]);
        if (!$data['loan']) {
            return redirect('/');
        }
        $data['status']=$request->input('status');
        if ($data['status']=='') {$data['status']=Session::get('status');}
        Session(['status' => $data['status']]);
        if (isset ($_POST['upload'])) {
            $this->validate($request, [
                'loan'    => 'required',
                'description'    => 'required',
                'document' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:20480',
            ]);
            $imageName = time().'.'.request()->document->getClientOriginalExtension();
            // dd(public_path());
            //  request()->document->move(public_path().'/upload/', $imageName);
              request()->document->move(env('UPLOAD_PATH', '').'upload/', $imageName);
             DB::table('customer_documents')->insert([
                'customer_id' => DB::table('loans')->where('id',$request->input('loan'))->value('customer_id'),
                'loan_id' => $request->input('loan'),
                'description' => $request->input('description'),
                'url' => '/upload/'.$imageName,
                'created_by' => Auth::user()->id,
                
            ]);
            return back()->with('message', 'New record successfully uploaded.');
        }

        if (isset ($_POST['pause'])) {
            $this->validate($request, [
                'loan'    => 'required',
                'remarks'    => 'required',
            ]);
            LoanTrait::implimentDefaulter($request->input('loan'));
            Loan::where('id', $request->input('loan'))->update([
                'status' => 4,
                
            ]);
            
                CustomerNote::create([
                    'customer_id' => Loan::find($request->input('loan'))->value('customer_id'),
                    'loan_id' => $request->input('loan'),
                    'notes' => $request->input('remarks') ,
                    'created_by' => Auth::User()->id ,
                ]);
            
            return back()->with('message', 'New record successfully paused.');
        }
        if (isset ($_POST['liquidate'])) {
            $this->validate($request, [
                'loan'    => 'required',
                'remarks'    => 'required',
            ]);
            

            $loan = Loan::find($request->input('loan'));
            LoanTransaction::create([
                'loan_id'           => $loan->id,
                'customer_id'       => $loan->customer_id,
                'debit'             => preg_replace(REGEX, '', $request->input('interest'))??0 ,
                'credit'            =>  0 ,
                'transaction_date'  => $request->input('applyDate') ,
                'transaction_type'  => 3,
                'remarks'  => 'Liquidation: '.$request->input('remarks'),
            ]);
            $customer_details = Customer::find($loan->customer_id);
            AccountTrait::debitAccount(
                $customer_details->account_id,
                preg_replace(REGEX, '', $request->input('interest'))??0,
                'ref', $request->input('applyDate'),
                'Liquidation: '.$request->input('remarks').' '. $customer_details->first_name, Auth::User()->id, 'manual_ref'
            );
            $account= DB::table('account_setups')->where('id', 1)->value('account_id');
            AccountTrait::creditAccount(
                $account,
                preg_replace(REGEX, '', $request->input('interest'))??0,
                'ref', $request->input('applyDate'),
                'Liquidation: '.$request->input('remarks').' '. $customer_details->first_name, Auth::User()->id, 'manual_ref');
            
            if ($request->input('remarks')) {
                CustomerNote::create([
                    'customer_id' => Loan::find($request->input('loan'))->value('customer_id'),
                    'loan_id' => $request->input('loan'),
                    'notes' => $request->input('remarks') ,
                    'created_by' => Auth::User()->id ,
                ]);
            }
            LoanTrait::implimentDefaulter($request->input('loan'));

            Loan::where('id', $request->input('loan'))->update([
                'status' => 4,
            ]);
            return back()->with('message', 'New record successfully paused.');
        }

        if (isset ($_POST['default'])) {
            $this->validate($request, [
                'applyDate'    => 'required',
                'amount'    => 'required',
            ]);
            

            $loan = Loan::find($request->input('id'));
            LoanTransaction::create([
                'loan_id'           => $loan->id,
                'customer_id'       => $loan->customer_id,
                'debit'             => preg_replace(REGEX, '', $request->input('amount'))??0 ,
                'credit'            =>  0 ,
                'transaction_date'  => $request->input('applyDate') ,
                'transaction_type'  => 3,
                'remarks'  => 'Default charge: '.$request->input('remarks'),
            ]);
            $customer_details = Customer::find($loan->customer_id);
            AccountTrait::debitAccount(
                $customer_details->account_id,
                preg_replace(REGEX, '', $request->input('amount'))??0,
                'ref', $request->input('applyDate'),
                'Default charge: '.$request->input('remarks').' '. $customer_details->first_name, Auth::User()->id, 'manual_ref'
            );
            $account= DB::table('account_setups')->where('id', 4)->value('account_id');
            AccountTrait::creditAccount(
                $account,
                preg_replace(REGEX, '', $request->input('amount'))??0,
                'ref', $request->input('applyDate'),
                'Default charge: '.$request->input('remarks').' '. $customer_details->first_name, Auth::User()->id, 'manual_ref');
            LoanTrait::implimentDefaulter($request->input('id'));

            if ($request->input('remarks')) {
                CustomerNote::create([
                    'customer_id' => Loan::find($request->input('id'))->value('customer_id'),
                    'loan_id' => $request->input('id'),
                    'notes' => $request->input('remarks') ,
                    'created_by' => Auth::User()->id ,
                ]);
            }
            LoanTrait::implimentDefaulter($loan->id);
            $request->session()->forget('remarks');
            return back()->with('message', 'New record successfully added.');
        }

        $data['Loans']= Loan::where('loans.status', ($data['status']=='All'||$data['status']=='')? '<>':'=', $data['status'])
            ->leftJoin('customers', 'customers.id', '=', 'loans.customer_id')
            ->select('loans.*', 'customers.first_name', 'customers.middle_name', 'customers.last_name')
            ->get();
            
        $data['Loan']= Loan::where('loans.id', '=', $data['loan'])
            ->leftJoin('users as marketer', 'marketer.id', '=', 'loans.marketer_id')
            ->leftJoin('users as approver', 'approver.id', '=', 'loans.approver_id')
            ->leftJoin('fstage', 'fstage.id', '=', 'loans.stage')
            ->leftJoin('loan_types', 'loan_types.id', '=', 'loans.loan_type_id')
            ->leftJoin('loan_statuses', 'loan_statuses.code', '=', 'loans.status')
            ->select('loans.*', 'marketer.name as marketer', 'approver.name as approver',
            'loan_types.particular','fstage.stage_text',
            'loan_statuses.status as statusText'
            )
            ->first();
            $data['prevCycle']='';
        if($data['Loan']) {
        $data['Loan']->balance = DB::table('loan_transactions')
            ->groupBy('loan_transactions.loan_id')
            ->where('loan_id', $data['Loan']->id)
            ->select(DB::raw('SUM(debit-credit) as balance'))
            ->value('balance');
        
         $data['Loan']=$data['Loan']->toArray();
         $data['prevCycle'] = LoanTrait::prevCycle($data['Loan']['next_due_date']);
         
        }
        $data['Transactions']= DB::table('loan_transactions')
            ->where('loan_transactions.loan_id', $data['loan'])
            ->select(
                'loan_transactions.*'
            )
           ->orderBy('loan_transactions.transaction_date')
            ->get();
            

        $data['statuses']= LoanStatus::orderby('rank')->get();
        $data['liquidators']= DB::table('liquidation_types')->get();

        $data['documents']= DB::table('customer_documents')->where('loan_id',$data['loan'])->get();

        $data['notes'] = CustomerNote::where('loan_id', $data['loan'])
        ->leftJoin('users', 'users.id', '=', 'customer_notes.created_by')
        ->select('customer_notes.*','users.name')
        ->get();
       
        
        return view('reports.loanDetails', $data);
                
    }
    public function activeCustomer(Request $request)
    {
    
    

    $data['title'] = SessionTrait::validate($request, 'title');
    $data['Title']= Title::all();
    $data['customers']= Customer::where('customers.status', 1)->leftJoin('titles', 'titles.id', '=', 'customers.titleID')
                            ->leftJoin('users', 'users.id', '=', 'customers.marketerID')
                            ->select('customers.*', 'titles.title', 'users.name')
                            ->get();
    foreach ( $data['customers'] as $v) {
        $v->balance=DB::table('loan_transactions')->groupBy('loan_transactions.customer_id')
            ->where('customer_id', $v->id)->select( DB::raw('SUM(debit-credit) as balance'))->value('balance');
    }
	return view('reports.activecustomers', $data);
	    
   }

   public function activeLoan(Request $request)
    {
        
        
        $data['Loans']= Loan::where('loans.status', 2)
            ->leftJoin('users', 'users.id', '=', 'loans.marketer_id')
            ->leftJoin('customers', 'customers.id', '=', 'loans.customer_id')
            ->leftJoin('loan_statuses', 'loan_statuses.code', '=', 'loans.status')
            ->leftJoin('loan_types', 'loan_types.id', '=', 'loans.loan_type_id')
            ->select(
                'loans.*',
                'customers.first_name',
                'customers.middle_name',
                'customers.last_name',
                'users.name',
                'loan_statuses.status',
                'loan_types.particular'
                )
            ->get();
            foreach ( $data['Loans'] as $v) {
                $v->balance=DB::table('loan_transactions')->groupBy('loan_transactions.loan_id')
                    ->where('loan_id', $v->id)->select( DB::raw('SUM(debit-credit) as balance'))->value('balance');
            }
        return view('reports.activeloans', $data);
                
    }
    public function applicationLoan(Request $request)
    {
        $data['Loans']= Loan::where('loans.status', 0)
            ->leftJoin('users', 'users.id', '=', 'loans.marketer_id')
            ->leftJoin('customers', 'customers.id', '=', 'loans.customer_id')
            ->leftJoin('loan_statuses', 'loan_statuses.code', '=', 'loans.status')
            ->leftJoin('loan_types', 'loan_types.id', '=', 'loans.loan_type_id')
            ->select(
                'loans.*',
                'customers.first_name',
                'customers.middle_name',
                'customers.last_name',
                'users.name',
                'loan_statuses.status',
                'loan_types.particular'
                )
            ->get();
            foreach ( $data['Loans'] as $v) {
                $v->balance=DB::table('loan_transactions')->groupBy('loan_transactions.loan_id')
                    ->where('loan_id', $v->id)->select( DB::raw('SUM(debit-credit) as balance'))->value('balance');
            }
        return view('reports.applicationloans', $data);
                
    }
    public function overdueLoan(Request $request)
    {
        $data['Loans']= Loan::where('loans.amount_outstanding','>', 0)
            ->leftJoin('users', 'users.id', '=', 'loans.marketer_id')
            ->leftJoin('customers', 'customers.id', '=', 'loans.customer_id')
            ->leftJoin('loan_statuses', 'loan_statuses.code', '=', 'loans.status')
            ->leftJoin('loan_types', 'loan_types.id', '=', 'loans.loan_type_id')
            ->select(
                'loans.*',
                'customers.first_name',
                'customers.middle_name',
                'customers.last_name',
                'users.name',
                'loan_statuses.status',
                'loan_types.particular'
                )
            ->get();
            foreach ( $data['Loans'] as $v) {
                $v->balance=DB::table('loan_transactions')->groupBy('loan_transactions.loan_id')
                    ->where('loan_id', $v->id)->select( DB::raw('SUM(debit-credit) as balance'))->value('balance');
            }
        return view('reports.overdueloans', $data);
                
    }
    public function customerLoan($id)
    {
        $data['Loans']= Loan::where('loans.customer_id', $id)
            ->leftJoin('users', 'users.id', '=', 'loans.marketer_id')
            ->leftJoin('customers', 'customers.id', '=', 'loans.customer_id')
            ->leftJoin('loan_statuses', 'loan_statuses.code', '=', 'loans.status')
            ->leftJoin('loan_types', 'loan_types.id', '=', 'loans.loan_type_id')
            ->select(
                'loans.*',
                'customers.first_name',
                'customers.middle_name',
                'customers.last_name',
                'users.name',
                'loan_types.particular',
                'loan_statuses.status as statusText'
                )
            ->get();
            foreach ( $data['Loans'] as $v) {
                $v->balance=DB::table('loan_transactions')->groupBy('loan_transactions.loan_id')
                    ->where('loan_id', $v->id)->select( DB::raw('SUM(debit-credit) as balance'))->value('balance');
            }
        return view('reports.customerloans', $data);
                
    }
}