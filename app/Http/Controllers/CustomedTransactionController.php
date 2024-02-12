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

            // dd($transactionDetails);
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

                        if (($filesop[16] == 'successful')) {
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
                            ]);
                        }
                    }
                }
            }
            return back()->with('message', 'record successfully updated.');
        }

        $data['records'] = AutomatedUploadTrait::searchUpload('', '', '', '');

        $data['transactionTypes'] = AutomatedUploadTrait::transactionTypes();

        return view('customedTransaction.upload', $data);
    }

    public function agentupload(Request $request)
    {

        if (URL::previous() !== URL::current()) {
            $request->session()->forget('transactionType');
        }

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

            $refno = AccountTrait::RefNo();
            $transactionDetails = DB::table('product_types_text')->get();
            dd($transactionDetails);

            $mimes = array('application/vnd.ms-excel', 'text/csv', 'text/tsv');
            $file = $_FILES['file']['tmp_name'];
            if (($file == "") || !(in_array($_FILES['file']['type'], $mimes))) {
                return back()->with('error_message', 'Invalid file.');
            } else {

                $handle = fopen($file, "r");
                $c = 0;

                while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {

                    $accountvalue = $filesop[2];

                    if ($c == 0 || $accountvalue == "") {
                        $c = 1;

                    } else {

                        $filesop4 = preg_replace('/[^\d.]/', '', $filesop[4]);

                        $id = DB::table('agents')->insertGetId([
                            'agent_name' => $filesop[1],
                            'account_ref' => $filesop[2],
                            'business_name' => $filesop[3],
                            'opening_bal' => !is_numeric($filesop4) ? 0 : $filesop4,
                            'as_at' => $filesop[5],

                        ]);

                        $subheadid = DB::table('setup_subheads')->where('id', 1)->value('subhead_id');
                        $subhead = AccountTrait::getSubheadDetails($subheadid);
                        if ($subhead) {
                            $account = DB::table('account_charts')->insertGetId([
                                'groupid' => $subhead->groupid,
                                'headid' => $subhead->headid,
                                'subheadid' => $subheadid,
                                'accountno' => $filesop[2],
                                'accountdescription' => $filesop[1],
                                'status' => 1,
                                'rank' => 0,
                            ]);
                            DB::table('agents')->where('id', $id)->update([
                                'account_id' => $account,
                            ]);

                            $ref = AccountTrait::RefNo();
                            $accountPayable = 1;
                            AccountTrait::debitAccount(
                                $accountPayable,
                                !is_numeric($filesop4) ? 0 : $filesop4,
                                $ref,
                                date('Y-m-d'),
                                $filesop[1] . 'Opening Balance',
                                Auth::User()->id,
                                $ref
                            );

                            AccountTrait::creditAccount(
                                $account,
                                !is_numeric($filesop4) ? 0 : $filesop4,
                                $ref,
                                date('Y-m-d'),
                                $filesop[1] . 'Opening Balance',
                                Auth::User()->id,
                                $ref);

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

        $data['records'] = DB::table('automated_record')->leftJoin('account_charts', 'account_charts.account_ref', 'automated_record.account_number')
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
                DB::raw('MAX(`account_name`) as account_name'), // Aggregating account_name
                DB::raw('MAX(`account_charts`.`id`) as agent_account'),
                'account_id',
                'formatted_date',
                'transaction_type'
            )
            ->where('transaction_type_id', '=', $data['transactionType'])
            ->groupBy('formatted_date', 'account_id', 'account_number', 'transaction_type')
            ->get();
// dd( $data['records']);
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

            switch ($data['transactionType']) {
                case 1:
                    // do Bank Transfer'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Bank Transfer";

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );

                        // debit agent wallet with fees charge
                        AccountTrait::debitAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->fees) ? 0 : $record->fees,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                    }

                    break;
                case 2:
                    // do Bank Transfer Reversal'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Bank Transfer Reversal";

                        //debit agent wallet with debit amount
                        AccountTrait::creditAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );

                        // debit agent wallet with fees charge
                        AccountTrait::creditAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->fees) ? 0 : $record->fees,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                    }
                    break;
                case 3:
                    // do POS Withdrawal'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "POS Transfer";

                        //debit agent wallet with debit amount
                        AccountTrait::creditAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );

                        // debit agent wallet with fees charge
                        AccountTrait::debitAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->fees) ? 0 : $record->fees,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                    }
                    break;
                case 4:
                    // do POS Withdrawal Reversal'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "POS Reversal";

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );

                        // debit agent wallet with fees charge
                        AccountTrait::creditAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->fees) ? 0 : $record->fees,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                    }
                    break;
                case 5:
                    // do IRecharge'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "IRecharge";

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                            fees,
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
                    }
                    break;
                case 6:
                    // do IRecharge Reversal'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "IRecharge Reversal";

                        //debit agent wallet with debit amount
                        AccountTrait::creditAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                    }
                    break;
                case 7:
                    // do Cash Out'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Cash Out";

                        //debit agent wallet with debit amount
                        AccountTrait::creditAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                    
                    }
                    break;
                case 8:
                    // do KYC'
                 
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Cash Out";

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                    
                    }
                    break;

                case 9:
                    // do Settlement'
                    echo "Value 3";
                    break;
                case 10:
                    // do Device Retrieval'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Device Retrieval";

                        //credit agent wallet with debit amount
                        AccountTrait::creditAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                    
                    }
                    break;
                    break;
                case 11:
                    // do Pos Sales Revenue'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Pos Sales Revenue";

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );

                        // credit bank with debit amount
                        AccountTrait::creditAccount(
                            $record->account_id,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
                        );
                    
                    }
                    break;
                case 12:
                    // do Pos Security Deposit'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Pos Sales Revenue";

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                    
                    }
                    break;
                case 14:
                    // do Funding'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Funding";

                        //credit agent wallet with debit amount
                        AccountTrait::creditAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                    
                    }
                    break;
                case 15:
                    // do Deduction'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Funding";

                        //debit agent wallet with debit amount
                        AccountTrait::debitAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                    
                    }
                    break;
                case 16:
                    // do wallet top-up'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Funding";

                        //credit agent wallet with credit amount
                        AccountTrait::creditAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                    
                    }
                    break;
                case 17:
                    // do Wallet Transfer'
                    foreach ($data['records'] as $record) {

                        $ref = AccountTrait::RefNo();
                        $remarks = "Funding";

                        //credit agent wallet with credit amount
                        AccountTrait::creditAccount(
                            1, //$record->agent_account,
                            !is_numeric($record->credits) ? 0 : $record->credits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                            1, //$record->agent_account,
                            !is_numeric($record->debits) ? 0 : $record->debits,
                            $ref,
                            $record->formatted_date,
                            $remarks,
                            Auth::User()->id,
                            $ref
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
                    
                    }
                    break;
                default:
                    // do something if $variable does not match any of the above cases
                    echo "Default Value";
            }

        }

        $data['transactionTypes'] = AutomatedUploadTrait::transactionTypes();

        return view('customedTransaction.process_uploads', $data);
    }

}
