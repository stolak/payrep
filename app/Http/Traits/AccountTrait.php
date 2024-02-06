<?php
namespace App\Http\Traits;

use DB;
use Auth;

trait AccountTrait
{
    public static function debitAccount($accountid, $amount, $ref, $transdate, $remark, $userid, $manual_ref)
    {

	    $accountdetails = AccountTrait::getAccountDetails($accountid);
	    return DB::table('account_transactions')->insert([
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
    public static  function creditAccount($accountid, $amount, $ref, $transdate, $remark, $userid, $manual_ref)
    {
	    $accountdetails=AccountTrait::getAccountDetails($accountid);
	    return DB::table('account_transactions')->insert([
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
    public static function getAccountDetails($id)
    {
	    return DB::table('account_charts')->where('id', '=', $id)->first();
	}
    public static function getSubheadDetails($id)
    {
	    return DB::table('account_subheads')->where('id', $id)->first();;
	}

	public static function journalPending($status) {
	    $userid=Auth::user()->id;
		return DB::table('tbltemp_journal_transfer')
		->where('tbltemp_journal_transfer.status', $status)
		->where('tbltemp_journal_transfer.postby', $userid)
		->leftjoin('account_charts','account_charts.id','tbltemp_journal_transfer.accountid')
		->select('tbltemp_journal_transfer.*','account_charts.accountdescription')->get();
	}

	public static function RefNo() {
        $alphabet = "0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $date = date_create();
        $initcode= date_format($date, 'U' ) ;
        return $initcode . implode($pass);

    }

    public static function trialBal($from,$to) {
	    if (date('m-d',strtotime($from))=="01-01")$from="1900-01-01";
	    $timedate= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$from' AND '$to')";
	    return DB::Select("SELECT  Sum(`debit`-`credit`) as  Credit, accountdescription as accountName
	    FROM `account_transactions`
        left join account_charts on account_charts.id=account_transactions.accountid
         WHERE  $timedate

         group by `accountid`,`accountdescription`   order by accountName");

	}
    public static function income($fromdate, $todate) {
	    $timedate= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$fromdate' AND '$todate')";
	    return DB::Select("SELECT SUM(debit-credit) as tVal,`subheadid`,subhead

	      FROM `account_transactions`
          left join `account_subheads` on account_subheads.id=account_transactions.subheadid
          WHERE `account_transactions`.`headid`=7 and $timedate and `is_trial`=1 group by `subheadid`,`subhead`");

	}
	public static function expenses($fromdate, $todate) {
	    $timedate= "(DATE_FORMAT(`transdate`,'%Y-%m-%d') BETWEEN '$fromdate' AND '$todate')";
        return DB::Select("SELECT SUM(debit-credit) as tVal,`subheadid`,subhead
        FROM `account_transactions`
        left join `account_subheads` on account_subheads.id=account_transactions.subheadid
        WHERE `account_transactions`.`headid`=6 and $timedate and `is_trial`=1 group by `subheadid`,`subhead`");

	}
	public static function PL($date) {
	    return DB::Select("SELECT SUM(credit-debit) as tVal FROM `account_transactions` WHERE (`headid`=7 or `headid`=6) and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date'");
	}
	public static function PL_List($date) {
	    return DB::Select("SELECT SUM(credit-debit) as tVal,accountid FROM `account_transactions` WHERE (`headid`=7 or `headid`=6) and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `accountid`");
	}
	public static function Equity($date) {
	    return DB::Select("SELECT SUM(credit-debit) as tVal,`subheadid`
	    ,(SELECT `subhead` FROM `account_subheads` WHERE account_subheads.id=subheadid)as Subhead
	    FROM `account_transactions` WHERE `headid`=5 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `subheadid`
	    order by (SELECT `rank` FROM `account_subheads` WHERE account_subheads.id=subheadid)");

	}
	public static function LongLiability($date) {
	    return DB::Select("SELECT SUM(credit-debit) as tVal,`subheadid`
	    ,(SELECT `subhead` FROM `account_subheads` WHERE account_subheads.id=subheadid)as Subhead
	     FROM `account_transactions` WHERE `headid`=4 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `subheadid`
	     order by (SELECT `rank` FROM `account_subheads` WHERE account_subheads.id=subheadid)");

	}
	public static function Liability($date) {
	    return DB::Select("SELECT SUM(credit-debit) as tVal,`subheadid`
	    ,(SELECT `subhead` FROM `account_subheads` WHERE account_subheads.id=subheadid)as Subhead
	      FROM `account_transactions` WHERE `headid`=3 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `subheadid`
	      order by (SELECT `rank` FROM `account_subheads` WHERE account_subheads.id=subheadid)");

	}
	public static function FixedAsset($date) {
	    return DB::Select("SELECT SUM(debit-credit) as tVal,`subheadid`
	    ,(SELECT `subhead` FROM `account_subheads` WHERE account_subheads.id=subheadid)as Subhead
	      FROM `account_transactions` WHERE `headid`=2 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `subheadid`
	      order by (SELECT `rank` FROM `account_subheads` WHERE account_subheads.id=subheadid)");

	}
	public static function CurrentAsset($date) {
	    return DB::Select("SELECT SUM(debit-credit) as tVal,`subheadid`
	    ,(SELECT `subhead` FROM `account_subheads` WHERE account_subheads.id=subheadid)as Subhead
	      FROM `account_transactions` WHERE `headid`=1 and DATE_FORMAT(`transdate`,'%Y-%m-%d')<='$date' group by `subheadid`
	      order by (SELECT `rank` FROM `account_subheads` WHERE account_subheads.id=subheadid)");

	}

    public function UnpostedJournalPending($status) {
        $userid = Auth::user()->id;

        return DB::select("
            SELECT
                tbltemp_journal_transfer.ref,
                SUM(tbltemp_journal_transfer.credit) AS t_val,
                users.name
            FROM
                `tbltemp_journal_transfer`
            LEFT JOIN
                users ON `users`.`id` = tbltemp_journal_transfer.postby
            WHERE
                `batch_status` = '0' AND
                tbltemp_journal_transfer.status = :status
            GROUP BY
                tbltemp_journal_transfer.ref, users.name
            ORDER BY
                tbltemp_journal_transfer.transdate, tbltemp_journal_transfer.id
        ", ['status' => $status]);
    }
}
