<?php
namespace App\Http\Traits;

use DB;
use Auth;

trait AutomatedUploadTrait
{
   
    public static function searchUpload($type,$from,$to,$status)
    {
	    return DB::table('automated_record')
		->where('formatted_date',">=",$from)->where('formatted_date',"<=",$to)->where('process_status',"=",$status)
		->get();
	}

	public static function agentsList()
    {
	    return DB::table('agents')->get();
	}

	public static function transactionTypes()
    {
	    return DB::table('product_types')->get();
	}
    
    
}