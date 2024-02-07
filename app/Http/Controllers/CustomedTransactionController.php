<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountTrait;
use App\Http\Traits\AutomatedUploadTrait;
use App\Models\LoanStatus;
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

            $mimes = array('application/vnd.ms-excel', 'text/csv', 'text/tsv');
            $file = $_FILES['file']['tmp_name'];
            if (($file == "") || !(in_array($_FILES['file']['type'], $mimes))) {
                return back()->with('error_message', 'Invalid file.');
            } else {

                $handle = fopen($file, "r");
                $c = 0;

                while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
                    // dd($filesop);
                    $dateval = $filesop[0];
                    $accountvalue = $filesop[3];

                    if ($c == 0 || $dateval == "" || $accountvalue == "") {
                        $c = 1;
                        array_push($statues, $filesop[16]);

                    } else {

                        if (($filesop[16] == 'successful')) {

                            // $transdate = $this->UpdatetransactionDate($filesop[0]);
                            $transdate = $filesop[0];
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

                            ]);
                        }
                    }
                }
            }
            return back()->with('message', 'record successfully updated.');
        }

        $data['records'] = AutomatedUploadTrait::searchUpload('', '', '', '');

        $data['transactionTypes'] = LoanStatus::all();

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

                            DB::table('agents')->insert([
                                'agent_name' => $filesop[1],
                                'account_ref' => $filesop[2],
                                'business_name' => $filesop[3],
                                'opening_bal' => !is_numeric($filesop4) ? 0 : $filesop4,
                                'as_at' => $filesop[5],

                            ]);
                        
                    }
                }
            }
            return back()->with('message', 'record successfully updated.');
        }

        $data['records'] = AutomatedUploadTrait::agentsList();

        

        return view('customedTransaction.agentUpload', $data);
    }
}
