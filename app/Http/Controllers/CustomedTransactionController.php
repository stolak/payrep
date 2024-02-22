<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountTrait;
use App\Http\Traits\AutomatedUploadTrait;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Session;

class CustomedTransactionController extends Controller
{
    public function __construct()
    {
        define("REGEX", "/[^\d.]/");
        set_time_limit(0);
    }

    public function formattedDate($dateStr)
    {

        $date = Carbon::createFromFormat('d/m/Y, H:i:s', $dateStr);

        if ($date) {
            // Format the date in the desired format
            return $date->format('Y-m-d');
        } else {
            return date("Y-m-d");
        }
    }

    public function updateRecord($record, $ref)
    {

        DB::table('automated_record')
            ->where('formatted_date', $record->formatted_date)
            ->where('account_id', $record->account_id)
            ->where('account_number', $record->account_number)
            ->where('transaction_type', $record->transaction_type)
            ->update([
                'ref_no' => $ref,
                'processed_at' => date('Y-m-d'),
                'process_status' => 1,

            ]);
    }
    public function upload(Request $request)
    {

        if (URL::previous() !== URL::current()) {
            $request->session()->forget('transactionType');
        }
        $data['transactionType'] = $request->input('transactionType');
        if ($data['transactionType'] == '') {
            $data['transactionType'] = Session::get('transactionType');
        }
        Session(['transactionType' => $data['transactionType']]);

        $data['toDate'] = $request->input('toDate');
        if ($data['toDate'] == "") {
            $data['toDate'] = date("Y-m-d");
        }

        $data['fromDate'] = $request->input('fromDate');
        if ($data['fromDate'] == "") {
            $data['fromDate'] = date("Y") . '-01-01';
        }

        $data['description'] = $request->input('description');
        if (isset($_POST['upload'])) {
            $this->validate($request, [
                'description' => 'required|string|unique:automated_record,upload_title',
            ]);
            $refno = AccountTrait::RefNo();
            $transactionDetails = DB::table('product_types_text')
                ->leftJoin('product_types', 'product_types.id', 'product_types_text.product_type_id')
                ->select('product_types_text.description', 'product_types.id', 'product_types.account_id')
                ->get()->toArray();

            $mimes = array('application/vnd.ms-excel', 'text/csv', 'text/tsv');
            $file = $_FILES['file']['tmp_name'];
            if (($file == "") || !(in_array($_FILES['file']['type'], $mimes))) {
                return back()->with('error_message', 'Invalid file.');
            } else {

                $handle = fopen($file, "r");
                $c = 0;

                while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {

                    $dateval = $filesop[0];
                    $accountvalue = $filesop[3];

                    if ($c == 0 || $dateval == "" || $accountvalue == "") {
                        $c = 1;

                    } else {

                        // if (($filesop[16] == 'successful')) {
                            $searchText = $filesop[6];
                            $matchingObjects = array_filter($transactionDetails, function ($obj) use ($searchText) {
                                return $obj->description === $searchText;
                            });

                            $filesop10 = preg_replace('/[^\d.]/', '', $filesop[10]);
                            $filesop11 = preg_replace('/[^\d.]/', '', $filesop[11]);
                            $filesop12 = preg_replace('/[^\d.]/', '', $filesop[12]);
                            $filesop12 = preg_replace('/[^\d.]/', '', $filesop[12]);
                            $filesop13 = preg_replace('/[^\d.]/', '', $filesop[13]);
                            $filesop18 = preg_replace('/[^\d.]/', '', $filesop[18]);
                            $filesop19 = preg_replace('/[^\d.]/', '', $filesop[19]);
                            $filesop20 = preg_replace('/[^\d.]/', '', $filesop[20]);

                            $filesop21 = preg_replace('/[^\d.]/', '', $filesop[21]);

                            $filesop22 = preg_replace('/[^\d.]/', '', $filesop[22]);

                            $filesop23 = preg_replace('/[^\d.]/', '', $filesop[23]);
                            try {
                                DB::table('automated_record')->insert([
                                    'trans_date' => $filesop[0],
                                    'serial_number' => $filesop[1], // $transdate,
                                    'account_name' => $filesop[2],
                                    'account_number' => $filesop[3],
                                    'business_name' => $filesop[4],
                                    'card_account_number' => $filesop[5],
                                    'transaction_type' => $filesop[6],
                                    'service_provider' => $filesop[7],
                                    'bank' => $filesop[8],
                                    'beneficiaryname' => $filesop[9],
                                    'debit' => !is_numeric($filesop10) ? 0 : $filesop10,
                                    'credit' => !is_numeric($filesop11) ? 0 : $filesop11,
                                    'balance' => !is_numeric($filesop12) ? 0 : $filesop12,
                                    'fees' => !is_numeric($filesop13) ? 0 : $filesop13,
                                    'terminalID' => $filesop[14],
                                    'rrn' => $filesop[15],
                                    'status' => $filesop[16],
                                    'reference_number' => $filesop[17],
                                    'bank_charges' => !is_numeric($filesop18) ? 0 : $filesop18,
                                    'agent_commission' => !is_numeric($filesop19) ? 0 : $filesop19,
                                    'bonus' => !is_numeric($filesop20) ? 0 : $filesop20,
                                    'aggregator_commission' => !is_numeric($filesop21) ? 0 : $filesop21,
                                    'aggregator_referral' => !is_numeric($filesop22) ? 0 : $filesop22,
                                    'company_commission' => !is_numeric($filesop23) ? 0 : $filesop23,
                                    'process_status' => 0,
                                    'upload_title' => $data['description'],
                                    'upload_batch' => $refno,
                                    'transaction_type_id' => reset($matchingObjects)->id ?? 0,
                                    'account_id' => reset($matchingObjects)->account_id ?? 0,
                                    'formatted_date' => $this->formattedDate($filesop[0]),
                                    'descriptions' => $request->input('description'),
                                ]);
                            } catch (\Exception $e) {
                                DB::table('failed_transaction_upload')->insert([
                                    'account_number' => $filesop[3],
                                    'system_ref' => $refno,
                                    'file_ref' => $filesop[17],
                                ]);
                            }

                        // }
                    }
                }
            }
            return back()->with('message', 'record successfully updated.');
        }

        $data['records'] = AutomatedUploadTrait::searchUpload('', $data['fromDate'], $data['toDate'], 0);

        $data['transactionTypes'] = AutomatedUploadTrait::transactionTypes();

        return view('customedTransaction.upload', $data);
    }

    public function agentupload(Request $request)
    {

        if (URL::previous() !== URL::current()) {
            $request->session()->forget('transactionType');
        }

        $data['asat'] = $request->input('asat');

        $data['toDate'] = $request->input('toDate');
        if ($data['toDate'] == "") {
            $data['toDate'] = date("Y-m-d");
        }

        $data['fromDate'] = $request->input('fromDate');
        if ($data['fromDate'] == "") {
            $data['fromDate'] = date("Y") . '-01-01';
        }
       
        if (isset($_POST['upload'])) {
            $this->validate($request, [
                'asat' => 'required|string',
            ]);
            $refno = AccountTrait::RefNo();
            $agentPayable = DB::table('account_setups')
            ->where('id', 11)
            ->value('account_id');
            $agentWalletId = DB::table('account_setups')
            ->where('id', 12)
            ->value('account_id');
            $agentWallet =DB::table('account_charts')->where('id', $agentWalletId)->first();
            
            $confirmagentPayable =DB::table('account_charts')->where('id', $agentPayable)->first();
            if (!$agentWallet) {

                return back()->with('error_message', ' Make sure setup account for agent wallet');
            }
            if (!$confirmagentPayable) {

                return back()->with('error_message', ' Make sure setup account for agent payable');
            }

            $mimes = array('application/vnd.ms-excel', 'text/csv', 'text/tsv');
            $file = $_FILES['file']['tmp_name'];
            if (($file == "") || !(in_array($_FILES['file']['type'], $mimes))) {
                return back()->with('error_message', 'Invalid file.');
            } else {

                $handle = fopen($file, "r");
                $c = 0;
                $subheadid = DB::table('setup_subheads')->where('id', 3)->value('subhead_id');
                while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {

                    $accountvalue = $filesop[2];
                    $ref = AccountTrait::RefNo();
                    if ($c == 0 || $accountvalue == "") {
                        $c = 1;

                    } else {
                        try {
                            $string = mb_convert_encoding($filesop[1], 'UTF-8', 'UTF-8');
                            $filesop1= (preg_replace('/[^\PC\s]/u', '',$string));
                            
                            $string = mb_convert_encoding($filesop[3], 'UTF-8', 'UTF-8');
                            $filesop3= (preg_replace('/[^\PC\s]/u', '',$string));


                            $filesop4 = (float) str_replace(',', '',  $filesop[4]);


                            $id = DB::table('agents')->insertGetId([
                                'agent_name' => $filesop1,
                                'account_ref' => $filesop[2],
                                'business_name' =>$filesop3,
                                'opening_bal' => !is_numeric($filesop4) ? 0 : $filesop4,
                                'as_at' => $filesop[5],

                            ]);

                           

                           
                                $account = DB::table('account_charts_sub')->insertGetId([
                                    'groupid' => $agentWallet->groupid,
                                    'chart_id' => $agentWallet->id,
                                    'headid' => $agentWallet->headid,
                                    'subheadid' => $agentWallet->subheadid,
                                    'accountno' => $filesop[2],
                                    'accountdescription' => $filesop1,
                                    'status' => 1,
                                    'rank' => 0,
                                ]);
                                DB::table('agents')->where('id', $id)->update([
                                    'account_id' => $account,
                                ]);
if(floatval($filesop4)<0){
    AccountTrait::creditAccount(
        $agentPayable,
        abs( $filesop4),
        $ref,
        $request->input('asat'),
        $filesop1 . ' Opening Balance',
        Auth::User()->id,
        $ref
    );

    AccountTrait::debitAccount(
        $agentWalletId,
        abs( $filesop4),
        $ref,
        $request->input('asat'),
        $filesop1. 'Opening Balance',
        Auth::User()->id,
        $ref,
        $account
    );
}else{

    AccountTrait::debitAccount(
        $agentPayable,
        abs( $filesop4),
        $ref,
        $request->input('asat'),
        $filesop1 . 'Opening Balance',
        Auth::User()->id,
        $ref
    );

    AccountTrait::creditAccount(
        $agentWalletId,
        abs( $filesop4),
        $ref,
        $request->input('asat'),
        $filesop1 . 'Opening Balance',
        Auth::User()->id,
        $ref,
        $account
    );
}
                               

                            
                        } catch (\Exception $e) {
                           
                            DB::table('failed_agent_upload')->insertGetId([
                                'account_number' => $filesop[2],
                                'system_ref' => $refno,
                            ]);
                            DB::table('account_transactions')->where('ref', '=', $ref)->delete();
                           

                        }

                    }
                }
            }
            return back()->with('message', 'record successfully updated.');
        }

        $data['records'] = AutomatedUploadTrait::agentsList();

        return view('customedTransaction.agentUpload', $data);
    }

    public function ProcessUpload(Request $request)
    {

        if (URL::previous() !== URL::current()) {
            $request->session()->forget('transactionType');
        }
        $data['transactionType'] = $request->input('transactionType');
        if ($data['transactionType'] == '') {
            $data['transactionType'] = Session::get('transactionType');
        }
        Session(['transactionType' => $data['transactionType']]);

        $data['toDate'] = $request->input('toDate');
        if ($data['toDate'] == "") {
            $data['toDate'] = date("Y-m-d");
        }

        $data['fromDate'] = $request->input('fromDate');
        if ($data['fromDate'] == "") {
            $data['fromDate'] = date("Y") . '-01-01';
        }

        $data['description'] = $request->input('description');

        $data['records'] = DB::table('automated_record')
        ->leftJoin('account_charts_sub', 'account_charts_sub.accountno', 'automated_record.account_number')
            ->select(
                DB::raw('sum(`debit`) as debits'),
                DB::raw('sum(`credit`) as credits'),
                DB::raw('sum(`fees`) as fees'),
                DB::raw('sum(`bank_charges`) as bank_charges'),
                DB::raw('sum(`agent_commission`) as agent_commission'),
                DB::raw('sum(`bonus`) as bonus'),
                DB::raw('sum(`aggregator_commission`) as aggregator_commission'),
                DB::raw('sum(`aggregator_referral`) as aggregator_referral'),
                DB::raw('sum(`company_commission`) as company_commission'),
                'account_number',
                DB::raw('MAX(`account_name`) as account_name'), 
                DB::raw('MAX(`account_charts_sub`.`chart_id`) as agent_account'),
                DB::raw('MAX(`account_charts_sub`.`id`) as agent_account_sub'),
                

                'account_id',
                'formatted_date',
                'transaction_type'
            )
            ->where('transaction_type_id', '=', $data['transactionType'])
            ->where('process_status', 0)
            ->where('formatted_date', ">=", $data['fromDate'])
            ->where('formatted_date', "<=", $data['toDate'])
            ->groupBy('formatted_date', 'account_id', 'account_number', 'transaction_type')
            ->get();

        if (isset($_POST['process'])) {

            $defaultSetup = DB::table('account_setups')->get()->toArray();
            $bank_charges = array_filter($defaultSetup, function ($obj) {
                return $obj->id === 6;
            });
            $agent_commission1 = array_filter($defaultSetup, function ($obj) {
                return $obj->id === 6;
            });
            $agent_commission = reset($agent_commission1)->account_id ?? 0;

            $bonus1 = array_filter($defaultSetup, function ($obj) {
                return $obj->id === 7;
            });
            $bonus = reset($bonus1)->account_id ?? 0;

            $aggregator_commission1 = array_filter($defaultSetup, function ($obj) {
                return $obj->id === 8;
            });
            $aggregator_commission = reset($aggregator_commission1)->account_id ?? 0;

            $aggregator_referral1 = array_filter($defaultSetup, function ($obj) {
                return $obj->id === 9;
            });
            $aggregator_referral = reset($aggregator_referral1)->account_id ?? 0;

            $company_commission1 = array_filter($defaultSetup, function ($obj) {
                return $obj->id === 10;
            });
            $company_commission = reset($company_commission1)->account_id ?? 0;


            $stamp_duty_account1 = array_filter($defaultSetup, function ($obj) {
                return $obj->id === 13;
            });
            $stamp_duty_account = reset($stamp_duty_account1)->account_id ?? 0;

            switch ($data['transactionType']) {
                case 1:
                    // do Bank Transfer'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Bank Transfer - $record->account_name";

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            $record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // debit agent wallet with fees charge
                        AccountTrait::debitAccount(
                            $record->agent_account,
                            !is_numeric($record->fees) ? 0 : $record->fees,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );
                        // credit bank with debit amount
                        AccountTrait::creditAccount(
                            $record->account_id,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit bank with Bank Charges amount
                        AccountTrait::creditAccount(
                            $record->account_id,
                            !is_numeric($record->bank_charges) ? 0 : $record->bank_charges,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit agent commission payable
                        AccountTrait::creditAccount(
                            $agent_commission,
                            !is_numeric($record->agent_commission) ? 0 : $record->agent_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit bonus payable
                        AccountTrait::creditAccount(
                            $bonus,
                            !is_numeric($record->bonus) ? 0 : $record->bonus,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit aggregator_commission payable
                        AccountTrait::creditAccount(
                            $aggregator_commission,
                            !is_numeric($record->aggregator_commission) ? 0 : $record->aggregator_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit aggregator_referral payable
                        AccountTrait::creditAccount(
                            $aggregator_referral,
                            !is_numeric($record->aggregator_referral) ? 0 : $record->aggregator_referral,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit company_commission payable
                        AccountTrait::creditAccount(
                            $company_commission,
                            !is_numeric($record->company_commission) ? 0 : $record->company_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);
                    }

                    break;
                case 2:
                    // do Bank Transfer Reversal'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Bank Transfer Reversal  - $record->account_name";

                        //debit agent wallet with debit amount
                        AccountTrait::creditAccount(
                            $record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // debit agent wallet with fees charge
                        AccountTrait::creditAccount(
                            $record->agent_account,
                            !is_numeric($record->fees) ? 0 : $record->fees,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );
                        // credit bank with debit amount
                        AccountTrait::debitAccount(
                            $record->account_id,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit bank with Bank Charges amount
                        AccountTrait::debitAccount(
                            $record->account_id,
                            !is_numeric($record->bank_charges) ? 0 : $record->bank_charges,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit agent commission payable
                        AccountTrait::debitAccount(
                            $agent_commission,
                            !is_numeric($record->agent_commission) ? 0 : $record->agent_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit bonus payable
                        AccountTrait::debitAccount(
                            $bonus,
                            !is_numeric($record->bonus) ? 0 : $record->bonus,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit aggregator_commission payable
                        AccountTrait::debitAccount(
                            $aggregator_commission,
                            !is_numeric($record->aggregator_commission) ? 0 : $record->aggregator_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit aggregator_referral payable
                        AccountTrait::debitAccount(
                            $aggregator_referral,
                            !is_numeric($record->aggregator_referral) ? 0 : $record->aggregator_referral,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit company_commission payable
                        AccountTrait::debitAccount(
                            $company_commission,
                            !is_numeric($record->company_commission) ? 0 : $record->company_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);
                    }
                    break;
                case 3:
                    // do POS Withdrawal'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "POS Withdral - $record->account_name";

                        //debit agent wallet with debit amount
                        AccountTrait::creditAccount(
                            $record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // debit agent wallet with fees charge
                        AccountTrait::debitAccount(
                            $record->agent_account,
                            !is_numeric($record->fees) ? 0 : $record->fees,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );
                        // credit bank with debit amount
                        AccountTrait::debitAccount(
                            $record->account_id,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit bank with Bank Charges amount
                        AccountTrait::creditAccount(
                            $record->account_id,
                            !is_numeric($record->bank_charges) ? 0 : $record->bank_charges,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit agent commission payable
                        AccountTrait::creditAccount(
                            $agent_commission,
                            !is_numeric($record->agent_commission) ? 0 : $record->agent_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit bonus payable
                        AccountTrait::creditAccount(
                            $bonus,
                            !is_numeric($record->bonus) ? 0 : $record->bonus,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit aggregator_commission payable
                        AccountTrait::creditAccount(
                            $aggregator_commission,
                            !is_numeric($record->aggregator_commission) ? 0 : $record->aggregator_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit aggregator_referral payable
                        AccountTrait::creditAccount(
                            $aggregator_referral,
                            !is_numeric($record->aggregator_referral) ? 0 : $record->aggregator_referral,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // Handle logic for stamp duuty
                        $stamp_duty= 0;
                        $company_commision_amount= $record->company_commission;
                        if($record->credits >= 10000){
                            $stamp_duty= 50;
                            $company_commision_amount = $record->fees-($record->aggregator_referral + $record->bank_charges+$record->agent_commission+$record->bonus+$record->bonus+$record->aggregator_commission);
                            AccountTrait::creditAccount(
                                $stamp_duty_account,
                                $stamp_duty,
                                $ref,
                                $record->formatted_date,
                                $remarks,
                                Auth::User()->id,
                                $ref
                            );
                        }
 // credit company_commission payable
                            if($company_commision_amount>0){
                                AccountTrait::creditAccount(
                                    $company_commission,
                                    $company_commision_amount,
                                    $ref,
                                    $record->formatted_date,
                                    $remarks,
                                    Auth::User()->id,
                                    $ref
                                );
                            } else{
                                AccountTrait::debitAccount(
                                    $company_commission,
                                    abs($company_commision_amount),
                                    $ref,
                                    $record->formatted_date,
                                    $remarks,
                                    Auth::User()->id,
                                    $ref
                                );
                            }
                        $this->updateRecord($record, $ref);
                    }
                    break;
                case 4:
                    // do POS Withdrawal Reversal'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "POS withdral Reversal - $record->account_name";

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            $record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // debit agent wallet with fees charge
                        AccountTrait::creditAccount(
                            $record->agent_account,
                            !is_numeric($record->fees) ? 0 : $record->fees,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );
                        // credit bank with debit amount
                        AccountTrait::creditAccount(
                            $record->account_id,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit bank with Bank Charges amount
                        AccountTrait::debitAccount(
                            $record->account_id,
                            !is_numeric($record->bank_charges) ? 0 : $record->bank_charges,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit agent commission payable
                        AccountTrait::debitAccount(
                            $agent_commission,
                            !is_numeric($record->agent_commission) ? 0 : $record->agent_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit bonus payable
                        AccountTrait::debitAccount(
                            $bonus,
                            !is_numeric($record->bonus) ? 0 : $record->bonus,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit aggregator_commission payable
                        AccountTrait::debitAccount(
                            $aggregator_commission,
                            !is_numeric($record->aggregator_commission) ? 0 : $record->aggregator_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit aggregator_referral payable
                        AccountTrait::debitAccount(
                            $aggregator_referral,
                            !is_numeric($record->aggregator_referral) ? 0 : $record->aggregator_referral,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit company_commission payable
                        AccountTrait::debitAccount(
                            $company_commission,
                            !is_numeric($record->company_commission) ? 0 : $record->company_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);
                    }
                    break;
                case 5:
                    // do IRecharge'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "IRecharge - $record->account_name";

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            $record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // credit bank with debit amount
                        AccountTrait::creditAccount(
                            $record->account_id,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit bank with Bank Charges amount
                        AccountTrait::creditAccount(
                            $record->account_id,
                            !is_numeric($record->bank_charges) ? 0 : $record->bank_charges,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // debit agent wallet with fees charge
                        $fees = $record->agent_commission + $record->bonus + $record->aggregator_commission + $record->aggregator_referral + $record->company_commission;
                        AccountTrait::debitAccount(
                            $record->account_id,
                            $fees,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit agent commission payable
                        AccountTrait::creditAccount(
                            $agent_commission,
                            !is_numeric($record->agent_commission) ? 0 : $record->agent_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit bonus payable
                        AccountTrait::creditAccount(
                            $bonus,
                            !is_numeric($record->bonus) ? 0 : $record->bonus,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit aggregator_commission payable
                        AccountTrait::creditAccount(
                            $aggregator_commission,
                            !is_numeric($record->aggregator_commission) ? 0 : $record->aggregator_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit aggregator_referral payable
                        AccountTrait::creditAccount(
                            $aggregator_referral,
                            !is_numeric($record->aggregator_referral) ? 0 : $record->aggregator_referral,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit company_commission payable
                        AccountTrait::creditAccount(
                            $company_commission,
                            !is_numeric($record->company_commission) ? 0 : $record->company_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);
                    }
                    break;
                case 6:
                    // do IRecharge Reversal'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "IRecharge Reversal - $record->account_name";

                        //debit agent wallet with debit amount
                        AccountTrait::creditAccount(
                            $record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // credit bank with debit amount
                        AccountTrait::debitAccount(
                            $record->account_id,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // debit agent wallet with fees charge
                        AccountTrait::creditAccount(
                            $record->account_id,
                            !is_numeric($record->fees) ? 0 : $record->fees,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit bank with Bank Charges amount
                        AccountTrait::debitAccount(
                            $record->account_id,
                            !is_numeric($record->bank_charges) ? 0 : $record->bank_charges,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit agent commission payable
                        AccountTrait::debitAccount(
                            $agent_commission,
                            !is_numeric($record->agent_commission) ? 0 : $record->agent_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit bonus payable
                        AccountTrait::debitAccount(
                            $bonus,
                            !is_numeric($record->bonus) ? 0 : $record->bonus,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit aggregator_commission payable
                        AccountTrait::debitAccount(
                            $aggregator_commission,
                            !is_numeric($record->aggregator_commission) ? 0 : $record->aggregator_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit aggregator_referral payable
                        AccountTrait::debitAccount(
                            $aggregator_referral,
                            !is_numeric($record->aggregator_referral) ? 0 : $record->aggregator_referral,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        // credit company_commission payable
                        AccountTrait::debitAccount(
                            $company_commission,
                            !is_numeric($record->company_commission) ? 0 : $record->company_commission,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);
                    }
                    break;
                case 7:
                    // do Cash Out'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Cash Out - $record->account_name";

                        //debit agent wallet with debit amount
                        AccountTrait::creditAccount(
                            $record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // credit bank with debit amount
                        AccountTrait::debitAccount(
                            $record->account_id,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);
                    }
                    break;
                case 8:
                    // do KYC'

                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Cash Out - $record->account_name";

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            $record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // credit bank with debit amount
                        AccountTrait::creditAccount(
                            $record->account_id,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);

                    }
                    break;

                case 9:
                    // do Settlement'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Settlement - $record->account_name";

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            $record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // credit bank with debit amount
                        AccountTrait::creditAccount(
                            $record->account_id,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);

                    }
                    break;
                case 10:
                    // do Device Retrieval'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Device Retrieval - $record->account_name";

                        //credit agent wallet with debit amount
                        AccountTrait::creditAccount(
                            $record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // debit bank with debit amount
                        AccountTrait::debitAccount(
                            $record->account_id,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);
                    }
                    break;

                case 11:
                    // do Pos Sales Revenue'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Pos Sales Revenue - $record->account_name";

                        //debit agent wallet with debit amount
                        AccountTrait::creditAccount(
                            $record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // credit bank with debit amount
                        AccountTrait::debitAccount(
                            $record->account_id,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);
                    }
                    break;
                case 12:
                    // do Pos Security Deposit'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Pos Sales Revenue - $record->account_name";

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            $record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // credit bank with debit amount
                        AccountTrait::creditAccount(
                            $record->account_id,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);
                    }
                    break;
                case 14:
                    // do Funding'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Funding - $record->account_name";

                        //credit agent wallet with debit amount
                        AccountTrait::creditAccount(
                            $record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // credit bank with debit amount
                        AccountTrait::debitAccount(
                            $record->account_id,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);
                    }
                    break;
                case 15:
                    // do Deduction'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Deduction - $record->account_name";

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            $record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // credit bank with debit amount
                        AccountTrait::creditAccount(
                            $record->account_id,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);
                    }
                    break;
                case 16:
                    // do wallet top-up'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "wallet top-up - $record->account_name";

                        //credit agent wallet with credit amount
                        AccountTrait::creditAccount(
                            $record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // credit bank with credit amount
                        AccountTrait::debitAccount(
                            $record->account_id,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);
                    }
                    break;
                case 17:
                    // do Wallet Transfer'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Wallet Transfer - $record->account_name";

                        //credit agent wallet with credit amount
                        AccountTrait::creditAccount(
                            $record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // debit bank with credit amount
                        AccountTrait::debitAccount(
                            $record->account_id,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            $record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref,
                            $record->agent_account_sub
                        );

                        // credit bank with debit amount
                        AccountTrait::creditAccount(
                            $record->account_id,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                        $this->updateRecord($record, $ref);
                    }
                    break;
                default:
                    // do something if $variable does not match any of the above cases
                    echo "Default Value";
            }
            return back()->with('message', 'record successfully process.');
        }

        $data['transactionTypes'] = AutomatedUploadTrait::transactionTypes();

        return view('customedTransaction.process_uploads', $data);
    }

    public function viewGroupUpoad(Request $request)
    {

        if (URL::previous() !== URL::current()) {
            $request->session()->forget('transactionType');
        }
        $data['transactionType'] = $request->input('transactionType');
        if ($data['transactionType'] == '') {
            $data['transactionType'] = Session::get('transactionType');
        }
        Session(['transactionType' => $data['transactionType']]);

        $data['toDate'] = $request->input('toDate');
        if ($data['toDate'] == "") {
            $data['toDate'] = date("Y-m-d");
        }

        $data['fromDate'] = $request->input('fromDate');
        if ($data['fromDate'] == "") {
            $data['fromDate'] = date("Y") . '-01-01';
        }

        $data['description'] = $request->input('description');
        

        // $data['records'] = AutomatedUploadTrait::searchUpload('', $data['fromDate'], $data['toDate'], 0);

        $data['records'] = DB::table('automated_record')
       
        ->select(
           
            'descriptions', 'upload_batch',
            DB::raw('MAX(`process_status`) as max_process_status'), 
            DB::raw('MAX(`formatted_date`) as max_formatted_date'),
            DB::raw('MIN(`process_status`) as min_process_status'), 
            DB::raw('MIN(`formatted_date`) as min_formatted_date'),
            DB::raw('sum(`debit`) as debits'),
            DB::raw('sum(`credit`) as credits'),
            DB::raw('sum(`fees`) as fees'),
           
        )
        
        ->groupBy('descriptions', 'upload_batch')
        ->get();

        $data['transactionTypes'] = AutomatedUploadTrait::transactionTypes();

        return view('customedTransaction.view-group-upload', $data);
    }
    public function uploadDetails(Request $request, $id)
    {

        if (URL::previous() !== URL::current()) {
            $request->session()->forget('transactionType');
        }
        $data['transactionType'] = $request->input('transactionType');
        if ($data['transactionType'] == '') {
            $data['transactionType'] = Session::get('transactionType');
        }
        Session(['transactionType' => $data['transactionType']]);

        if (isset($_POST['delete'] ) ) {
            if(DB::table('automated_record')
            ->where('id', '=', $request->input('id'))
            ->where('process_status', '=', 0)          
            ->delete())
            return back()->with('message', ' Record successfully trashed.');
            return back()->with('error_message', ' Action not perform! it is either the record have been processed or deleted.');
        }
       
        if (isset($_POST['modify'] ) ) {
            if(DB::table('automated_record')
            ->where('id', '=', $request->input('id'))
            ->where('process_status', '=', 0)
            ->update(['service_provider' => $request->input('provider')]))
            return back()->with('message', ' Record successfully trashed.');
            return back()->with('error_message', ' Action not perform! it is either the record have been processed or deleted.');
        }
       

        $data['records'] = AutomatedUploadTrait::uploadDetails($id,  $request->input('transactionType'));

        $data['transactionTypes'] = AutomatedUploadTrait::transactionTypes();

        return view('customedTransaction.upload-details', $data);
    }   

}
