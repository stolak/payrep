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
use App\Models\User;
use App\Models\Rate;
use App\Http\Traits\SessionTrait;

class SettingController extends Controller
{
    function __construct(){
        define("REGEX", "/[^\d.]/");
    }
    
    
    public function defaultSetup(Request $request)
    {
        
        if((URL::previous()!==URL::current() )){
            $request->session()->forget('rate');
            $request->session()->forget('registrationFee');
            $request->session()->forget('processingFee');
        }

        $data['rate'] = SessionTrait::validate($request, 'rate');
        $data['registrationFee'] = SessionTrait::validate($request, 'registrationFee');
        $data['processingFee'] = SessionTrait::validate($request, 'processingFee');
        $data['defaulterFee'] = SessionTrait::validate($request, 'defaulterFee');
        if ($data['rate']=='') {$data['rate']= Rate::find(1)->value('rate');}
        if ($data['registrationFee']=='') {
            $data['registrationFee']= DB::table('fee_charges')->where('id',1)->value('amount');
        }
        if ($data['processingFee']=='') {
            $data['processingFee']= DB::table('fee_charges')->where('id',2)->value('amount');
        }
        if ($data['defaulterFee']=='') {
            $data['defaulterFee']= DB::table('fee_charges')->where('id',3)->value('amount');
        }

        if (isset ($_POST['update'])) {
            $this->validate($request, [
                'rate'  => 'required|numeric',
                'registrationFee'    => 'required|numeric',
                'defaulterFee'      => 'required|numeric',
                'processingFee'  => 'required|numeric',
            ]
            );
            
            DB::table('fee_charges')->where('id', 1)->update([
                'amount' => preg_replace(REGEX, '', $request->input('registrationFee'))?? 0 ,
            ]);
            DB::table('fee_charges')->where('id', 2)->update([
                'amount' => preg_replace(REGEX, '', $request->input('processingFee'))?? 0 ,
            ]);
            DB::table('rates')->where('id', 1)->update([
                'rate' => preg_replace(REGEX, '', $request->input('rate'))?? 0 ,
            ]);
               
            $request->session()->forget('registrationFee');
            $request->session()->forget('processingFee');
            $request->session()->forget('rate');
            return back()->with('message', 'New record successfully updated.');
        }
        return view('setup.default', $data);
                
    }
    public function incomeSetup(Request $request)
    {
        
        if((URL::previous()!==URL::current() )){
            $request->session()->forget('account');
            $request->session()->forget('particular');
        }

        $data['account'] = SessionTrait::validate($request, 'account');
        $data['particular'] = SessionTrait::validate($request, 'particular');
        if (isset ($_POST['update'])) {
            $this->validate($request, [
                'account'  => 'required',
                'particular'    => 'required',
            ]
            );
            
            DB::table('account_setups')
            ->where('id', $request->input('particular'))->update([
                'account_id' => $request->input('account') ,
            ]);
              
            $request->session()->forget('account');
            $request->session()->forget('particular');

            return back()->with('message', 'New record successfully updated.');
        }
        $data['particulars']=DB::table('account_setups')->where('account_setups.status', 1)
        ->leftjoin('account_charts', 'account_setups.account_id', 'account_charts.id')
        ->select('account_setups.*', 'account_charts.accountdescription' )->get();
        $data['accounts']=DB::table('account_charts')->get();
        // $data['accounts']=DB::table('account_charts')->where('headid', 7)->get();

        return view('setup.income', $data);
                
    }
     
    
}
