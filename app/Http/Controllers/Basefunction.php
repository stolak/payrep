<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Auth;
use App\Http\Requests;
use DB;
use Auth;
use session;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class Basefunction extends Controller
{


    Public function BatchModule() {
	    return DB::Select("SELECT * FROM `tblbatch_module`");
	}
	Public function Months() {
	    return DB::Select("SELECT * FROM `tblmonths`");
	}
	 Public function AFS() {
	    return DB::Select("SELECT * FROM `tblafs`");
	}
	Public function DepreciationType() {
	    return DB::Select("SELECT * FROM `tbldepreciation_type`");
	}
	 Public function Manufacture() {
	    return DB::Select("SELECT * FROM `tblmanufacturer`");
	}
	Public function YesNo() {
	    return DB::Select("SELECT * FROM `tblyesno`");
	}
	Public function MFormat() {
	    return DB::Select("SELECT * FROM `tblmeasurementformat`");
	}
	Public function ItemsCategory() {
	    return DB::Select("SELECT * FROM `tblitemcategory`");
	}
	Public function TaxPerc() {
	    return DB::Select("SELECT * FROM `tbltax_percentage`");
	}

	 Public function BrandList() {
	    return DB::Select("SELECT * FROM `tblbrand` join `tblmanufacturer` on `tblmanufacturer`.id= `tblbrand`.manufacturerid");
	}
	Public function CurrentPeriod() {
		return DB::table ('tblcurrent_period')->select('*','tblevaluation_period.id as pid')
		->join('tblevaluation_period','tblcurrent_period.quarterid', '=', 'tblevaluation_period.id')
		->first();
	}

	public function loadCourtJudges(Request $request)
	{
	 $courtId = Input::get('court_id');
	 $qcourt=1;
	 if ($courtId!=null){$qcourt="`court_id`='$courtId'";}
	 $data = $data= DB::Select("SELECT concat(`titles`,' ', `judgename`) as Judges, `tbljudges`.`id` FROM `tbljudges` join `tbltitle` on `tbltitle`.`ID`=`tbljudges`.`title`  WHERE $qcourt");
	 //dd( response()->json($data));
	 return response()->json($data);
	}
	public function loadCourtDivision(Request $request)
	{
	 $courtId = Input::get('court_id');
	 $data= DB::Select("SELECT * FROM `tbldivision` WHERE `court_id`='$courtId'");
	 return response()->json($data);
	}




	Public function ComputableCases($yr,$qtr) {
	return DB::Select("SELECT * FROM `tblcases` WHERE `qtrcommenced`='0' or `qtrclosed`='0' or
	(`qtrcommenced`='$qtr' and `yearcommenced`='$yr')
	or (`yearclosed`='$yr' and `qtrclosed`='$qtr')");
	}
	Public function MyComputableCases($yr,$qtr,$judge) {
	return DB::Select("SELECT * FROM `tblcases` WHERE (`qtrcommenced`='0' or `qtrclosed`='0' or
	(`qtrcommenced`='$qtr' and `yearcommenced`='$yr')
	or (`yearclosed`='$yr' and `qtrclosed`='$qtr'))and `leadJudge`='$judge'");
	}
	Public function TotalWitness($id) {
	$dt=DB::Select("SELECT count(*) as cnt FROM `tblwitness` WHERE `case_id`='$id'");
	if($dt) return $dt[0]->cnt;
	return 0 ;
	}
	Public function DeleteThisPeriodReports($yr,$qtr) {
	DB::Select("DELETE FROM `tblevaluation` WHERE `year`='$yr' and `qtr`='$qtr'");
	DB::Select("DELETE FROM `tblevaluation_judges` WHERE `year`='$yr' and `qtr`='$qtr'");
	return null ;
	}
	Public function DeleteMyThisPeriodReports($yr,$qtr,$judge) {
	$tobedeleted=DB::Select("SELECT `caseid` FROM `tblevaluation` WHERE `year`='$yr' and `qtr`='$qtr' and `leadjudge`='$judge'");
	foreach ($tobedeleted as $d){
	$caseid=$d->caseid;
	DB::Select("DELETE FROM `tblevaluation_judges` WHERE `year`='$yr' and `qtr`='$qtr' and `caseid`='$caseid'");
	}
	DB::Select("DELETE FROM `tblevaluation` WHERE `year`='$yr' and `qtr`='$qtr' and `leadjudge`='$judge'");
	return null ;
	}
	Public function Quarterslist() {
	return DB::Select("SELECT * FROM `tblevaluation_period`");
	}

	Public function CourtList() {
	return DB::Select("SELECT * FROM `tblcourt`");
	}
	Public function ReportStatus() {
	return DB::Select("SELECT * FROM `tblreportstatus`");
	}
	Public function JudgesList($court) {
	$qcourt="1";
	if($court <>''){$qcourt = "`court_id`='$court'";}
	//dd($qcourt);
	return DB::Select("SELECT * FROM `tbljudges` WHERE $qcourt");
	}




  	 function dateDiff($date2, $date1)
	  {
	    list($year2, $mth2, $day2) = explode("-", $date2);
	    list($year1, $mth1, $day1) = explode("-", $date1);
	    if ($year1 > $year2) dd('Invalid Input - dates do not match');
	    $days_month = 0;
	    //$days_month = cal_days_in_month(CAL_GREGORIAN, $mth1, $year1);
	    $day_diff = 0;

	    if($year2 == $year1){
	      $mth_diff = $mth2 - $mth1;
	    }
	    else{
	      $yr_diff = $year2 - $year1;
	      $mth_diff = (12 * $yr_diff) - $mth1 + $mth2;
	    }
	    if($day1 > 1){
	      $mth_diff--;
	      //dd($mth1.",".$year1);
	      //$day_diff = $days_month - $day1 + 1;
	    }

	    $result = array('months'=>$mth_diff, 'days'=> $day_diff, 'days_of_month'=>$days_month);
	    return($result);
	  } //end of


    Public function InventoryList($brand,$category) {
	return DB::Select("SELECT `tblinventory`.*, tblbrand.brand, tblitemcategory.category
	FROM `tblinventory` left join tblbrand on tblbrand.id=`brandid` left join tblitemcategory  on
	tblitemcategory.id = `catid` WHERE 1 ");
	}

	Public function SelectItemdetails($id) {

	$data= DB::Select("SELECT `tblinventory`.*, tblbrand.brand, tblitemcategory.category, tblmeasurementformat.format
	FROM `tblinventory`
	left join tblbrand on tblbrand.id=`brandid`
	left join tblitemcategory  on tblitemcategory.id = `catid`
	left join tblmeasurementformat  on tblmeasurementformat.id = `minsku`
	WHERE  `tblinventory`.`id`='$id' ");
	if($data) return $data[0];
	return [];
	}

	Public function SalesFormat($itemid) {
	return DB::Select("SELECT tblsellingformat.*,tblmeasurementformat.format
	FROM `tblsellingformat`  left join tblmeasurementformat on tblmeasurementformat.id=`formatid`
	WHERE `itemid`='$itemid' order by minskuqty");
	}
	Public function PurchaseFormat($itemid) {
	return DB::Select("SELECT tblpurchaseformat.*,tblmeasurementformat.format
	FROM `tblpurchaseformat`  left join tblmeasurementformat on tblmeasurementformat.id=`formatid`
	WHERE `itemid`='$itemid' order by minskuqty");
	}
 Public function GetRegisterUserId($names, $username,$email,$pass,$usertype) {
    $role=DB::table('tblpredefined_role')->where('id', '=', $usertype)->value('roleid');
    //dd($role);
	return DB::table('users')->insertGetId([
    	          'name' => $names ,
    	          'username' => $username ,
    	          'userrole' => $role ,
    	          'usertype' => $usertype ,
    	          'password' =>bcrypt($pass),// Hash::make($pass) ,
    	          'email' => $email ,
    	        ]);
	}
	function AuthenticateRoute($route) {
	    $role=Auth::user()->userrole;
	    return DB::SELECT("SELECT * FROM `tblassign_role_module` WHERE `roleid`='$role' and exists(SELECT null FROM `tblsubmodule` WHERE `links`='$route' and `tblsubmodule`.`id`=`submoduleid`)");
	}
	 Public function DefaultPassword() {
	     return '12345';
	 }
	 Public function SupCode($id) {
	    $tempdata ="SUP";
	    $newcode=$tempdata.$id;
        while(strlen($newcode)<8)
        {
        $tempdata=$tempdata . "0";
        $newcode=$tempdata.$id;
        }
		return $newcode;
	}
	Public function NewAccSubCode($head) {
	    $data=0;
	    $hcode =$this->FetchAccHeadCode($head);
	    $dt=DB::Select("SELECT * FROM `tblaccountsubhead` WHERE `headid`='$head' order by `subheadcode` DESC  LIMIT 1");
	    if($dt){
	        $lastcode=$dt[0]->subheadcode;
	        $intc=strlen($lastcode);
	        $intchcode=strlen($hcode);
	        $data=substr($lastcode, $intchcode, ($intc-$intchcode));
	    }
	    $data+=1;
	    $newcode=$hcode.$data;
        while(strlen($newcode)<5)
        {
        $hcode=$hcode . "0";
        $newcode=$hcode.$data;
        }
		return $newcode;
	}
	Public function NewAccCode($subhead) {
	    $data=0;
	    $hcode =$this->FetchSubAccountCode($subhead);
	    $dt=DB::Select("SELECT * FROM `tblaccountchart` WHERE `subheadid`='$subhead' order by `accountno` DESC  LIMIT 1");
	    if($dt){
	        $lastcode=$dt[0]->accountno;
	        $intc=strlen($lastcode);
	        $intchcode=strlen($hcode);
	        $data=substr($lastcode, $intchcode, ($intc-$intchcode));
	    }
	    $data+=1;
	    $newcode=$hcode.$data;
        while(strlen($newcode)<10)
        {
        $hcode=$hcode . "0";
        $newcode=$hcode.$data;
        }
		return $newcode;
	}
	Public function FetchAccHeadCode($id) {
	    return DB::table('tblaccounthead')->where('id', '=', $id)->value('accoundheadcode');
	}
	Public function FetchSubAccountCode($id) {
	    return DB::table('tblaccountsubhead')->where('id', '=', $id)->value('subheadcode');
	}
	Public function FetchAccHeadID($id) {
	    return DB::table('tblaccountsubhead')->where('id', '=', $id)->value('headid');
	}
	Public function getGroupid($id) {
	    return DB::table('tblaccounthead')->where('id', '=', $id)->value('groupid');
	}

	Public function Suppliers() {
	    return DB::Select("SELECT * FROM `tblsupplier`");
	}
	Public function AccountHead() {
	    return DB::Select("SELECT * FROM `tblaccounthead` order by `accoundheadcode`");
	}
	Public function SubAccountList($id) {
	    $qid=1;
	    if($id!='')$qid="`headid`='$id'";
	    return DB::Select("SELECT tblaccountsubhead.*,accounthead,tblafs.afs as Rank_order  FROM `tblaccountsubhead` left join tblaccounthead on tblaccounthead.id=`headid`
	    left join tblafs on tblafs.id=tblaccountsubhead.`afs`
	    WHERE $qid order by `headid`,rank");
	}
	Public function AccountList($hid,$shid) {
	    $qhid=1;
	    if($hid!='')$qhid="tblaccountchart.`headid`='$hid'";
	    $qshid=1;
	    if($shid!='')$qshid="tblaccountchart.`subheadid`='$shid'";
	    //die("SELECT tblaccountchart.*,accounthead,subhead  FROM `tblaccountchart` left join tblaccountsubhead on tblaccountsubhead.id=tblaccountchart.`subheadid` left join tblaccounthead on tblaccounthead.id=tblaccountchart.`headid`
	    //WHERE $qhid and $qshid order by `accountno`");
	    return DB::Select("SELECT tblaccountchart.*,accounthead,subhead,tblafs.afs
	    FROM `tblaccountchart` left join tblaccountsubhead on tblaccountsubhead.id=tblaccountchart.`subheadid` left join tblaccounthead on tblaccounthead.id=tblaccountchart.`headid`
	    left join tblafs on tblafs.id=tblaccountsubhead.`afs`
	    WHERE $qhid and $qshid order by `tblaccountsubhead`.`afs`,`tblaccountsubhead`.`rank`,subheadid,tblaccountchart.rank ,`tblaccountchart`.`accountno`");
	}

	function FetchAccountCodes($id) {
	    return DB::table('tblaccountchart')->where('id', '=', $id)->first();
	}

	Public function CreditAccount($accountid, $amount,$ref,$transdate,$remark,$userid,$manual_ref) {
	    $accountdetails=$this->FetchAccountCodes($accountid);
	    return DB::table('tblaccount_transaction')->insertGetId([
    	          'groupid' => $accountdetails->groupid ,
    	          'headid' => $accountdetails->headid ,
    	          'subheadid' => $accountdetails->subheadid ,
    	          'accountid' => $accountid ,
    	          'accountcode' => $accountdetails->accountno ,
    	          'debit' => 0 ,
    	          'credit' => $amount ,
    	          'remarks' => $remark ,
    	          'ref' => $ref ,
    	          'manual_ref' => $manual_ref ,
    	          'transdate' => $transdate ,
    	          'postby' => $userid ,

    	]);
	}


	Public function DebitAccount($accountid, $amount,$ref,$transdate,$remark,$userid,$manual_ref) {
	    $accountdetails=$this->FetchAccountCodes($accountid);
	    return DB::table('tblaccount_transaction')->insertGetId([
    	          'groupid' => $accountdetails->groupid ,
    	          'headid' => $accountdetails->headid ,
    	          'subheadid' => $accountdetails->subheadid ,
    	          'accountid' => $accountid ,
    	          'accountcode' => $accountdetails->accountno ,
    	          'debit' => $amount ,
    	          'credit' => 0 ,
    	          'remarks' => $remark ,
    	          'ref' => $ref ,
    	          'manual_ref' => $manual_ref ,
    	          'transdate' => $transdate ,
    	          'postby' => $userid ,

    	]);
	}
	Public function RefNo() {
        $alphabet = "0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $date = date_create();
        $initcode= date_format($date, 'U' ) ;
        $Reference= $initcode . implode($pass);
        return $Reference;
    }
    Public function BatchPending($id,$status) {
	    $userid=Auth::user()->id;
	    return DB::Select("SELECT *
	    ,(SELECT Concat(`accountdescription`,'(',`accountno`,')') FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=principal_account) as principal
	    ,(SELECT Concat(`accountdescription`,'(',`accountno`,')') FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=secondary_account) as secondary
	    FROM `tblbatch_post_temp` WHERE postby='$userid' and status='$status' and principal_account='$id'");
	}


	Public function AccountName($id) {
	    $dt=$this->FetchAccountCodes($id);

	    if($dt) return $dt->accountdescription.'('.$dt->accountno.')';
	    return '';
	}
	Public function TrialBal($from,$to) {
	    if (date('m-d',strtotime($from))=="01-01")$from="1900-01-01";
	    $timedate= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$from' AND '$to')";
	    return DB::Select("SELECT *, Sum(`debit`-`credit`) as  Credit
	    ,(SELECT `accountdescription` FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accountid) as accountName
	    FROM `tblaccount_transaction` WHERE  $timedate  group by `accountid` order by `accountcode`");
	    return DB::Select("SELECT *, Sum(`debit`-`credit`) as  Credit
	    ,(SELECT `accountdescription` FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accountid) as accountName
	    FROM `tblaccount_transaction` WHERE  $timedate  and is_trial= 1 group by `accountid` order by `accountcode`");

	}
	Public function PL($date) {
	    return DB::Select("SELECT SUM(credit-debit) as tVal,`subheadid` FROM `tblaccount_transaction` WHERE (`headid`=7 or `headid`=6) and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date'");
	}
	Public function PL_List($date) {
	    return DB::Select("SELECT SUM(credit-debit) as tVal,accountid FROM `tblaccount_transaction` WHERE (`headid`=7 or `headid`=6) and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `accountid`");
	}
	Public function Equity($date) {
	    return DB::Select("SELECT SUM(credit-debit) as tVal,`subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	    FROM `tblaccount_transaction` WHERE `headid`=5 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `subheadid`
	    order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function LongLiability($date) {
	    return DB::Select("SELECT SUM(credit-debit) as tVal,`subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	     FROM `tblaccount_transaction` WHERE `headid`=4 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `subheadid`
	     order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function Liability($date) {
	    return DB::Select("SELECT SUM(credit-debit) as tVal,`subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=3 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `subheadid`
	      order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function FixedAsset($date) {
	    return DB::Select("SELECT SUM(debit-credit) as tVal,`subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=2 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `subheadid`
	      order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function CurrentAsset($date) {
	    return DB::Select("SELECT SUM(debit-credit) as tVal,`subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=1 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `subheadid`
	      order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function Income($fromdate,$todate) {
	    $timedate= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$fromdate' AND '$todate')";
	    return DB::Select("SELECT SUM(debit-credit) as tVal,`subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=7 and $timedate and `is_trial`=1 group by `subheadid`");

	}
	Public function Expenses($fromdate,$todate) {
	    $timedate= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$fromdate' AND '$todate')";
	    return DB::Select("SELECT SUM(debit-credit) as tVal,`subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=6 and $timedate and `is_trial`=1 group by `subheadid`");

	}
	Public function ExpensesComparative($f1,$t1,$f2,$t2,$f3,$t3,$f4,$t4,$t5,$t6) {
	    $timedate1= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$f1' AND '$t1')";
		$timedate2= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$f2' AND '$t2')";
		$timedate3= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$f3' AND '$t3')";
		$timedate4= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$f4' AND '$t4')";
		$timedate5= "DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$t5'";
		$timedate6= "DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$t6'";
	    return DB::Select(" Select *,
		ifnull(sum( case when  $timedate1 then (debit-credit) end),0) as tval1
		,ifnull(sum( case when  $timedate2 then (debit-credit) end),0) as tval2
		,ifnull(sum( case when  $timedate3 then (debit-credit) end),0) as tval3
		,ifnull(sum( case when  $timedate4 then (debit-credit) end),0) as tval4
		,ifnull(sum( case when  $timedate5 then (debit-credit) end),0) as tval5
		,ifnull(sum( case when  $timedate6 then (debit-credit) end),0) as tval6
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=6 and `is_trial`=1 group by `subheadid`");
	}
	Public function IncomeComparative($f1,$t1,$f2,$t2,$f3,$t3,$f4,$t4,$t5,$t6) {
	    $timedate1= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$f1' AND '$t1')";
		$timedate2= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$f2' AND '$t2')";
		$timedate3= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$f3' AND '$t3')";
		$timedate4= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$f4' AND '$t4')";
		$timedate5= "DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$t5'";
		$timedate6= "DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$t6'";
	    return DB::Select(" select*,
		ifnull(sum( case when  $timedate1 then (debit-credit) end),0) as tval1
		,ifnull(sum( case when  $timedate2 then (debit-credit) end),0) as tval2
		,ifnull(sum( case when  $timedate3 then (debit-credit) end),0) as tval3
		,ifnull(sum( case when  $timedate4 then (debit-credit) end),0) as tval4
		,ifnull(sum( case when  $timedate5 then (debit-credit) end),0) as tval5
		,ifnull(sum( case when  $timedate6 then (debit-credit) end),0) as tval6
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=7  and `is_trial`=1 group by `subheadid`");
	}
	Public function PLFull($date) {
	     //
	    return DB::Select("SELECT SUM(credit-debit) as tVal
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	    ,(SELECT `accountdescription` FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accountid) as accountName
	    FROM `tblaccount_transaction` WHERE (`headid`=7 or `headid`=6) and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `accountid`");

	}
	Public function EquityFull($date) {
	    return DB::Select("SELECT SUM(credit-debit) as tVal
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	    ,(SELECT `accountdescription` FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accountid) as accountName
	    FROM `tblaccount_transaction` WHERE `headid`=5 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `accountid`");

	}
	Public function LongLiabilityFull($date) {
	    return DB::Select("SELECT SUM(credit-debit) as tVal
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	    ,(SELECT `accountdescription` FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accountid) as accountName
	     FROM `tblaccount_transaction` WHERE `headid`=4 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `accountid`");

	}
	Public function LiabilityFull($date) {
	    return DB::Select("SELECT SUM(credit-debit) as tVal
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	    ,(SELECT `accountdescription` FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accountid) as accountName
	      FROM `tblaccount_transaction` WHERE `headid`=3 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `accountid`");

	}
	Public function FixedAssetFull($date) {
	    return DB::Select("SELECT SUM(debit-credit) as tVal
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	    ,(SELECT `accountdescription` FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accountid) as accountName
	      FROM `tblaccount_transaction` WHERE `headid`=2 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `accountid`");

	}
	Public function CurrentAssetFull($date) {
	    return DB::Select("SELECT SUM(debit-credit) as tVal
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	    ,(SELECT `accountdescription` FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accountid) as accountName
	      FROM `tblaccount_transaction` WHERE `headid`=1 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `accountid`");

	}
	Public function BalanceSheetFullSubHead($date,$id) {
	    return DB::Select("SELECT SUM(debit-credit) as tVal
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	    ,(SELECT `accountdescription` FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accountid) as accountName
	      FROM `tblaccount_transaction` WHERE `subheadid`='$id' and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `accountid`");

	}
	Public function PLFullSubHead($from,$to,$id) {
	    return DB::Select("SELECT SUM(debit-credit) as tVal
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	    ,(SELECT `accountdescription` FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accountid) as accountName
	      FROM `tblaccount_transaction` WHERE `subheadid`='$id' and  (DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$from' AND '$to')  group by `accountid`");

	}
	Public function DefaultAccountLookUp($id) {
	    $id2=DB::table('tblDefault_setup')->where('id', '=', $id)->value('headid');
	    return DB::Select("SELECT * FROM `tblaccountchart` WHERE `headid`='$id2'");
	}
	Public function DefaultAccount() {
	    return DB::Select("SELECT * ,(SELECT Concat(`accountdescription`,'(',`accountno`,')') FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accoountId) as AccountName FROM `tblDefault_setup`");
	}
	Public function ProjectAccount() {
	    return DB::Select("SELECT * ,(SELECT Concat(`accountdescription`,'(',`accountno`,')') FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=expensenid) as AccountName FROM `tblproject_expense`");
	}
		Public function PettyTransaction($petty='',$br='') {
	    $qpetty=1;
	    if($petty!='')$qpetty="`tblpettyhandling_transaction`.`projectid`='$petty'";
	    $qbr=1;
	    if($br!='')$qbr="`tblpettyhandling_transaction`.`branch_id`='$br'";
	    return DB::Select("SELECT tblpettyhandling_transaction.*
	    ,(SELECT Concat(`accountdescription`,'(',`accountno`,')') FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accountid) as AccountName
	    ,(SELECT particular FROM `tblproject_expense` WHERE `tblproject_expense`.`id`=projectid) as Particular
	    ,(SELECT name FROM `users` WHERE `users`.`id`=postby) as Postedby
	    ,tblbranch.branch as Branch
	    ,users.name as FPost
	    FROM `tblpettyhandling_transaction`
	    left join tblbranch  on `tblpettyhandling_transaction`.`branch_id`=tblbranch.id
	    left join users  on `users`.`id`=tblpettyhandling_transaction.final_post_by where $qbr and $qpetty");
	}
	Public function AccountTransType() {
	    return DB::Select("SELECT * FROM `tbltranstype`");
	}
	Public function JournalPending($status) {
	    $userid=Auth::user()->id;
	    return DB::Select("SELECT *
	    ,(SELECT Concat(`accountdescription`,'(',`accountno`,')') FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=`temp_journal_transfer`.accountid) as account_details
	    FROM `temp_journal_transfer` WHERE `postby`='$userid' and `status`='0'");
	}
	Public function AccountStatementRunningTotal($account,$fromdate,$todate) {
    $opening="0";
    $result = DB::Select("SELECT Sum(`credit`-`debit`)as Opening FROM `tblaccount_transaction` WHERE DATE_FORMAT(`transdate`,'%Y-%m-%d')<'$fromdate' and `accountid`='$account'");
    if($result){$opening=$result[0]->Opening;}

    $timedate= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$fromdate' AND '$todate')";
     $result1 = " SELECT *, (@csum) as prev, `debit`,`credit`, (@csum := @csum +`credit`-`debit`) as `current`  FROM `tblaccount_transaction` JOIN (SELECT @csum := '$opening') r WHERE  $timedate and `accountid`='$account' order by DATE_FORMAT(`transdate`,'%Y-%m-%d') ,`id`";
    return DB::Select($result1);

	}
	Public function AssetCategoryList() {
	    return DB::Select("SELECT *
	    ,(SELECT concat(`accountdescription`, '(',`accountno`,')' )FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=tblasset_category.asset_account) as AAcct1
	    ,(SELECT concat(`accountdescription`, '(',`accountno`,')') FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=tblasset_category.depreciation_account) as AAcct2
	    ,(SELECT concat(`accountdescription`, '(',`accountno`,')') FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=tblasset_category.sales_account) as AAcct3
	    ,(SELECT `d_type` FROM `tbldepreciation_type` WHERE `tbldepreciation_type`.`id`=depreciation_type) as type

	    FROM `tblasset_category`");
	}
		Public function AssetCategoryPara($id) {
		   $dt= DB::table('tblasset_category')->where('id',$id)->first();
		   if($dt) return $dt;
	        return DB::Select("SELECT  '' as `cat_code`, '' as `asset_account`, '' as `depreciation_account`, '' as `sales_account`, '' as `category`, '' as `depreciation_type`  ")[0];
	}
	Public function AssetTypeList($category) {
	    return DB::Select("SELECT *
        ,  ( select tblasset_category.category from tblasset_category where  tblasset_category.id = `tblasset_type`.`asset_category`) as Catgory FROM `tblasset_type` WHERE asset_category='$category'");
	}
Public function AssetList($category,$type) {
    $qtype=$type?"`typeID`='$type'":1;
   $qcategory=$category?"`categoryId`='$category'":1;
	    return DB::Select("SELECT *
    ,  ( select tblasset_category.category from tblasset_category where  tblasset_category.id = `tblasset`.`categoryId`) as Catgory
    ,  ( select tblasset_type.assettype from tblasset_type where  tblasset_type.id = `tblasset`.`typeID`) as Type
    FROM `tblasset` WHERE $qtype and $qcategory");
	}

	Public function AssetEntityList($category,$type,$status) {
	    $qtype=$type?"`typeId`='$type'":1;
        $qcategory=$category?"`categoryId`='$category'":1;
	    return DB::Select("SELECT *
	    ,(SELECT `accountdescription` FROM `tblaccountchart` WHERE `tblaccountchart`.id=`tblasset_entity`.supplier) as sup
	    ,(SELECT `category` FROM `tblasset_category` WHERE `tblasset_category`.id=`tblasset_entity`.categoryId) as cat
	    ,(SELECT `assettype` FROM `tblasset_type` WHERE  tblasset_type.id=`tblasset_entity`.typeId) as typ
	    ,(SELECT `asset_description` FROM `tblasset` WHERE tblasset.id=`tblasset_entity`.assetId) asset
	    ,(SELECT `d_type` FROM `tbldepreciation_type` WHERE tbldepreciation_type.id=`tblasset_entity`.depr_type) Dpt
	    FROM `tblasset_entity` WHERE  status='$status' and $qcategory and $qtype");
	}
		Public function AssetBatchPending($id,$status) {
	    $userid=Auth::user()->id;
	    return DB::Select("SELECT *
	    ,(SELECT Concat(`accountdescription`,'(',`accountno`,')') FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=supplier) as principal
	    ,(SELECT asset_account FROM `tblasset_category` WHERE `tblasset_category`.`id`=categoryId) as asset_account
	    ,(SELECT `asset_description` FROM `tblasset` WHERE tblasset.id=`tblasset_entity`.assetId) asset
	    FROM `tblasset_entity` WHERE createdby='$userid' and status='$status'");
	}
	Public function GeneralNote($date) {
	    return DB::Select("SELECT SUM(debit-credit) as tVal
	    ,(SELECT `accounthead` FROM `tblaccounthead` WHERE tblaccounthead.id=headid)as Head
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	    ,(SELECT `accountdescription` FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accountid) as accountName
	    ,accountcode
	      FROM `tblaccount_transaction` WHERE  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `accountid` order by `headid`,`subheadid`");

	}

	Public function NewAccountApi($particularid,$desription,$code='') {
	        $subhead=DB::table('tblaccount_setup_subhead')->where('id', $particularid)->value('subheadid');
	        $headid=$this->FetchAccHeadID($subhead);
            DB::table('tblaccountchart')->insert([
    	          'groupid' => $this->getGroupid($headid) ,
    	          'headid' => $headid ,
    	          'subheadid' => $subhead ,
    	          'accountno' => $this->NewAccCode($subhead) ,
    	          'accountdescription' => $desription ,
    	          'createdby' => Auth::user()->id ,
    	        ]);
    	        return null;

	}
Public function Trans_Summary($from,$to,$ref=null) {
	    $timedate= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$from' AND '$to')";
	    //$timedate=1;
	    if($ref) return DB::Select("SELECT *, sum(`debit`) as sum_total FROM `tblaccount_transaction` WHERE  `ref`='$ref'  and is_trial= 1   group by `ref` order by  `transdate`");
	    return DB::Select("SELECT *, sum(`debit`) as sum_total FROM `tblaccount_transaction` WHERE  $timedate  and is_trial= 1   group by `ref` order by  `transdate`");

	}

	Public function Gen_Transaction($from,$to) {
	    $timedate= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$from' AND '$to')";
	    //$timedate=1;
	    return DB::Select("SELECT *
	    ,(SELECT `accountdescription` FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accountid) as accountName
	     FROM `tblaccount_transaction` WHERE  $timedate   order by `transdate`, `ref`");

	}
	protected function RegisteredUser(){
         $role = DB::Select("SELECT *
         ,(SELECT `rolename` FROM `user_role` WHERE `user_role`.`roleID`=`users`.`userrole`) as Role
         FROM `users` WHERE `usertype` is null");
        return $role;
    }
Public function RefBatch() {
	    return DB::Select("SELECT `ref`,`manual_ref` FROM `tblaccount_transaction` group by`ref`  order by `manual_ref`");
	}
	Public function RegOrganisation() {
	    return DB::Select("SELECT *
	    ,(SELECT `accountdescription` FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=accountid) as accountName
	     FROM `tblorganisation` ");

	}
	Public function EOYList() {
	    return DB::Select("SELECT * FROM `tblfinancial_end`   order by `year_end_date`");
	}

	Public function UnpostedJournalPendingOLD($status) { // by mr steve
	    $userid=Auth::user()->id;
	    return DB::Select("SELECT temp_journal_transfer.*,sum(temp_journal_transfer.credit) as t_val,users.name
	    FROM `temp_journal_transfer` left join users  on `users`.`id`=temp_journal_transfer.postby WHERE  `batch_status`='0' and temp_journal_transfer.status=1 group by ref
	    order by temp_journal_transfer.transdate,temp_journal_transfer.id");
	}

    public function UnpostedJournalPending($status) {
        $userid = Auth::user()->id;

        return DB::select("
            SELECT
                temp_journal_transfer.ref,
                SUM(temp_journal_transfer.credit) AS t_val,
                users.name
            FROM
                `temp_journal_transfer`
            LEFT JOIN
                users ON `users`.`id` = temp_journal_transfer.postby
            WHERE
                `batch_status` = '0' AND
                temp_journal_transfer.status = :status
            GROUP BY
                temp_journal_transfer.ref, users.name
            ORDER BY
                temp_journal_transfer.transdate, temp_journal_transfer.id
        ", ['status' => $status]);
    }
    
	Public function UnpostedJournalPending_sefOLD($status) {
	    $userid=Auth::user()->id;
	    return DB::Select("SELECT temp_journal_transfer.*,sum(temp_journal_transfer.credit) as t_val,users.name
	    FROM `temp_journal_transfer` left join users  on `users`.`id`=temp_journal_transfer.postby WHERE  `batch_status`='0' and  `postby`='$userid'
        group by temp_journal_transfer.ref
	    order by temp_journal_transfer.transdate,temp_journal_transfer.id");

	}

    public function UnpostedJournalPending_sef($status) {
        $userid = Auth::user()->id;
        return DB::select("
            SELECT
                temp_journal_transfer.*,
                sum(temp_journal_transfer.credit) as t_val,
                users.name
            FROM
                `temp_journal_transfer`
            LEFT JOIN
                users ON `users`.`id` = temp_journal_transfer.postby
            WHERE
                `batch_status` = '0' AND `postby` = '$userid'
            GROUP BY
                temp_journal_transfer.id,
                temp_journal_transfer.ref,
                temp_journal_transfer.transtype,
                temp_journal_transfer.accountid,
                temp_journal_transfer.debit,
                temp_journal_transfer.credit,
                temp_journal_transfer.status,
                temp_journal_transfer.batch_status,
                temp_journal_transfer.manual_ref,
                temp_journal_transfer.post_at,
                temp_journal_transfer.postby,
                temp_journal_transfer.remarks,
                temp_journal_transfer.created_at,
                temp_journal_transfer.f_post_at,
                temp_journal_transfer.final_post_by,
                users.name,
                temp_journal_transfer.transdate
            ORDER BY
                temp_journal_transfer.transdate,
                temp_journal_transfer.id
        ");
    }


	Public function SelectedJournalPending($ref,$status) {
	    return DB::Select("SELECT *
	    ,(SELECT Concat(`accountdescription`,'(',`accountno`,')') FROM `tblaccountchart` WHERE `tblaccountchart`.`id`=`temp_journal_transfer`.accountid) as account_details
	    FROM `temp_journal_transfer` WHERE `ref`='$ref' and `batch_status`='$status'");
	}
	Public function QuarterlyPeriod() {
	    return DB::Select("SELECT * FROM `tblevaluation_period`");
	}
	Public function PLWithin($from ,$to) {
	    $timedate= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$from' AND '$to')";
	    return DB::Select("SELECT SUM(credit-debit) as tVal,`subheadid` FROM `tblaccount_transaction` WHERE (`headid`=7 or `headid`=6) and $timedate");
	}

	Public function LiabilityCompare($curdate,$predate) {
	    return DB::Select("SELECT ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$curdate'then (credit-debit) end),0) as tval1
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$predate'then (credit-debit) end),0) as tval2,
	    `subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=3  group by `subheadid`
	      order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function EquityCompare($curdate,$predate) {
	    return DB::Select("SELECT ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$curdate'then (credit-debit) end),0) as tval1
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$predate'then (credit-debit) end),0) as tval2,
	    `subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=5  group by `subheadid`
	      order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function LongLiabilityCompare($curdate,$predate) {
	    return DB::Select("SELECT ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$curdate'then (credit-debit) end),0) as tval1
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$predate'then (credit-debit) end),0) as tval2,
	    `subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=4  group by `subheadid`
	      order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function FixedAssetCompare($curdate,$predate) {
	    return DB::Select("SELECT ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$curdate'then (debit-credit) end),0) as tval1
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$predate'then (debit-credit) end),0) as tval2,
	    `subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=2  group by `subheadid`
	      order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function CurrentAssetCompare($curdate,$predate) {
	    return DB::Select("SELECT ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$curdate'then (debit-credit) end),0) as tval1
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$predate'then (debit-credit) end),0) as tval2,
	    `subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=1  group by `subheadid`
	      order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function PLCompare($curdate,$predate) {
	    return DB::Select("SELECT  ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$curdate'then (credit-debit) end),0) as tval1
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$predate'then (credit-debit) end),0) as tval2
	    ,`subheadid` FROM `tblaccount_transaction` WHERE (`headid`=7 or `headid`=6)");
	}
	Public function LiabilityComparative($date1,$date2,$date3,$date4) {
	    return DB::Select("SELECT ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date1'then (credit-debit) end),0) as tval1
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date2'then (credit-debit) end),0) as tval2
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date3'then (credit-debit) end),0) as tval3
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date4'then (credit-debit) end),0) as tval4,
	    `subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=3  group by `subheadid`
	      order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function EquityComparative($date1,$date2,$date3,$date4) {
	    return DB::Select("SELECT ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date1'then (credit-debit) end),0) as tval1
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date2'then (credit-debit) end),0) as tval2
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date3'then (credit-debit) end),0) as tval3
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date4'then (credit-debit) end),0) as tval4,
	    `subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=5  group by `subheadid`
	      order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function LongLiabilityComparative($date1,$date2,$date3,$date4) {
	    return DB::Select("SELECT ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date1'then (credit-debit) end),0) as tval1
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date2'then (credit-debit) end),0) as tval2
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date3'then (credit-debit) end),0) as tval3
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date4'then (credit-debit) end),0) as tval4

	    ,
	    `subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=4  group by `subheadid`
	      order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function FixedAssetComparative($date1,$date2,$date3,$date4) {
	    return DB::Select("SELECT ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date1'then (debit-credit) end),0) as tval1
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date2'then (debit-credit) end),0) as tval2
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date3'then (debit-credit) end),0) as tval3
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date4'then (debit-credit) end),0) as tval4
	    ,
	    `subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=2  group by `subheadid`
	      order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function CurrentAssetComparative($date1,$date2,$date3,$date4) {
	    return DB::Select("SELECT ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date1'then (debit-credit) end),0) as tval1
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date2'then (debit-credit) end),0) as tval2
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date3'then (debit-credit) end),0) as tval3
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date4'then (debit-credit) end),0) as tval4
	    ,`subheadid`
	    ,(SELECT `subhead` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)as Subhead
	      FROM `tblaccount_transaction` WHERE `headid`=1  group by `subheadid`
	      order by (SELECT `rank` FROM `tblaccountsubhead` WHERE tblaccountsubhead.id=subheadid)");

	}
	Public function PLComparative($date1,$date2,$date3,$date4) {
	    return DB::Select("SELECT  ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date1'then (credit-debit) end),0) as tval1
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date2'then (credit-debit) end),0) as tval2
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date3'then (credit-debit) end),0) as tval3
	    ,ifnull(sum( case when  DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date4'then (credit-debit) end),0) as tval4
	    ,`subheadid` FROM `tblaccount_transaction` WHERE (`headid`=7 or `headid`=6)");
	}
	Public function OwnersTransaction($year,$month) {
	    return DB::table('tblowner_transactions')->where('year',$year)->where('month',$month)->first();
	}
}
