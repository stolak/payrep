<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use Carbon\Carbon;
use Session;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CaseProgress;
use Auth;
use Excel;
use PDF;
use App\Http\Traits\AccountTrait;

class PDFReport extends Controller
{

   public function viewPDF($id)
   {
       	$data['asatdate']=date("Y-m-d");
        $data['CurrentAsset'] = AccountTrait::CurrentAsset($data['asatdate']);
        $data['FixedAsset'] = AccountTrait::FixedAsset($data['asatdate']);
        $data['Liability'] = AccountTrait::Liability($data['asatdate']);
        $data['LongLiability'] = AccountTrait::LongLiability($data['asatdate']);
        $data['Equity'] = AccountTrait::Equity($data['asatdate']);
        $data['PL'] = AccountTrait::PL($data['asatdate']);
        $pdf = PDF::loadView('PDFReport.balancesheetpdf', $data);
        return $pdf->download(env('DATABASE_URL').'fP.pdf');
   }



    public function AccountStatements(Request $request)
    {
            $data['acctid']=$request->input('acctid');
            if($data['acctid']==''){$data['acctid']=Session::get('acctid');}
            Session(['acctid' => $data['acctid']]);
            $data['accountname']= AccountTrait::AccountName($data['acctid']);
            $data['fromdate']=$request->input('fromdate');
            $data['todate']=$request->input('todate');
            if($data['todate']==""){$data['todate']=date("Y-m-d");}
            if($data['fromdate']==""){$data['fromdate']=date("Y-m-d");}
            $data['TrialBal'] = AccountTrait::trialBal($data['fromdate'],$data['todate']);
            $data['AccountStatementRunningTotal'] = AccountTrait::AccountStatementRunningTotal($data['acctid'],$data['fromdate'],$data['todate']);
            //return view('AccountReport.accountstatement', $data);
            $pdf = PDF::loadView('PDFReport.accountstatement', $data)->setPaper('a4', 'landscape');
            return $pdf->download(env('Coy_download_Ext').'Account_transaction_'.date("Y-m-d").'.pdf');
    }


    public function TrialBalance(Request $request){
        //if (!$this->AuthenticateRoute("new-brand")) return view('lock.index');
       	$data['fromdate']=$request->input('fromdate');
       	$data['todate']=$request->input('todate');
       	if($data['todate']==""){$data['todate']=date("Y-m-d");}
        if($data['fromdate']==""){$data['fromdate']=date("Y-m-d");}
        $data['TrialBal'] = $this->TrialBal($data['fromdate'],$data['todate']);
    	$pdf = PDF::loadView('PDFReport.trialbalance', $data);
       return $pdf->download(env('Coy_download_Ext').'Trial_balance_'.$data['fromdate'].'_'.$data['todate'].'.pdf');
    }

   public function BalanceSheet(Request $request)
   {
        //if (!$this->AuthenticateRoute("new-brand")) return view('lock.index');
        $data['asatdate']=$request->input('asatdate');
        if($data['asatdate']==""){$data['asatdate']=date("Y-m-d");}
        $data['CurrentAsset'] = $this->CurrentAsset($data['asatdate']);
        $data['FixedAsset'] = $this->FixedAsset($data['asatdate']);
        $data['Liability'] = $this->Liability($data['asatdate']);
        $data['LongLiability'] = $this->LongLiability($data['asatdate']);
        $data['Equity'] = $this->Equity($data['asatdate']);
        $data['PL'] = $this->PL($data['asatdate']);
        //return view('AccountReport.balancesheet', $data);
        //return view('AccountReport.balancesheetpdf', $data);
        $pdf = PDF::loadView('PDFReport.balancesheetpdf', $data);
        return $pdf->download(env('Coy_download_Ext').'Financial_position_'.date("Y-m-d").'.pdf');

   }


   public function IncomeExpense(Request $request)
   {
        //if (!$this->AuthenticateRoute("new-brand")) return view('lock.index');
        $data['fromdate']=$request->input('fromdate');
            $data['todate']=$request->input('todate');
            if($data['todate']==""){$data['todate']=date("Y-m-d");}
            if($data['fromdate']==""){$data['fromdate']=date("Y-m-d");}
        $data['Incomedata'] = $this->Income($data['fromdate'],$data['todate']);
        $data['Expensedata'] = $this->Expenses($data['fromdate'],$data['todate']);

        //return view('AccountReport.plreport', $data);
        $pdf = PDF::loadView('PDFReport.plreport', $data);
        return $pdf->download(env('Coy_download_Ext').'P_L_'.$data['fromdate'].'_'.$data['todate'].'.pdf');
   }


   public function Notes($d_at = null,$id=0)
   {
        //if (!$this->AuthenticateRoute("new-brand")) return view('lock.index');
        $data['asatdate']=$d_at;
        if($data['asatdate']==""){$data['asatdate']=date("Y-m-d");}
        if($id==0) {$data['BalanceSheetFullSubHead'] = $this->PLFull($d_at);} else{
        $data['BalanceSheetFullSubHead'] = $this->BalanceSheetFullSubHead($d_at,$id);}
        //dd($data['BalanceSheetFullSubHead']);

        //return view('AccountReport.fullsubhead', $data);
        $pdf = PDF::loadView('PDFReport.fullsubhead', $data);
        return $pdf->download('fP.pdf');
   }

   public function GeneralNotes(Request $request)
   {
        $data['asatdate']=$request->input('asatdate');
        if($data['asatdate']==""){$data['asatdate']=date("Y-m-d");}
        $data['BalanceSheetFullSubHeadPL'] = $this->PLFull($data['asatdate']);
        $data['BalanceSheetFullSubHead'] = $this->GeneralNote($data['asatdate']);
        //return view('AccountReport.generalnote', $data);
        $pdf = PDF::loadView('PDFReport.generalnote', $data);
        return $pdf->download('ledger_note.pdf');
   }


   public function Transaction_Summary(Request $request){
        //if (!$this->AuthenticateRoute("new-brand")) return view('lock.index');
       	$data['fromdate']=$request->input('fromdate');
       	$data['todate']=$request->input('todate');
       	if($data['todate']==""){$data['todate']=date("Y-m-d");}
        if($data['fromdate']==""){$data['fromdate']=date("Y-m-d");}
        $data['Trans_Summary'] = $this->Trans_Summary($data['fromdate'],$data['todate']);
    	$pdf = PDF::loadView('PDFReport.transaction_summary', $data);
        return $pdf->download(env('Coy_download_Ext').'Summary_trans_'.$data['fromdate'].'_'.$data['todate'].'.pdf');
   }


   public function RefTransaction($ref = null){
       	$data['ref']=$ref;
        $data['RefTrans'] = DB::Select("SELECT *
        ,(SELECT `accountdescription` FROM `account_charts` WHERE `account_charts`.`id`=accountid) as accountName
        FROM `tblaccount_transaction` WHERE `ref`='$ref'");
    	//return view('AccountReport.ref_trans', $data);
    	$pdf = PDF::loadView('PDFReport.ref_trans', $data);
        return $pdf->download('fP.pdf');
   }

   public function General_Transaction(Request $request){
        //if (!$this->AuthenticateRoute("new-brand")) return view('lock.index');
       	$data['fromdate']=$request->input('fromdate');
       	$data['todate']=$request->input('todate');
       	if($data['todate']==""){$data['todate']=date("Y-m-d");}
        if($data['fromdate']==""){$data['fromdate']=date("Y-m-d");}

        $data['Gen_Transaction'] = $this->Gen_Transaction($data['fromdate'],$data['todate']);
    	//return view('AccountReport.general_trans', $data);
    	$pdf = PDF::loadView('PDFReport.general_trans', $data);
        return $pdf->download('fP.pdf');
   }

   public function Chart_of_Account(){
        $data['AccountList'] = $this->AccountList('','');
        $pdf = PDF::loadView('PDFReport.chart_account', $data)->setPaper('a4', 'landscape');;
        return $pdf->download(env('Coy_download_Ext').'chart_account_'.date("Y-m-d").'.pdf');
   }

}//end class
