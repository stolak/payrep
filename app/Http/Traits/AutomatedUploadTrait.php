<?php
namespace App\Http\Traits;

use DB;
use Auth;

trait AutomatedUploadTrait
{
   
    public static function searchUpload($type,$from,$to,$status)
    {
	    return DB::table('automated_record')
		->where('formatted_date',">=",$from)
		->where('formatted_date',"<=",$to)
		->where('process_status',"=",$status)
		->where(function($query) use ($type) {
			if(!isset($type) || !$type==='All') {
				$query->where('transaction_type_id', '<>', null); 
			} else {
				$query->where('transaction_type_id', '=', $type);
				
			}
			
		})
		->get();
	}

	public static function uploadDetails($batch,$type)
    {
	    return DB::table('automated_record')
		->where('upload_batch', "=", $batch)
		->where(function($query) use ($type) {
			if(!isset($type) || !$type==='All') {
				$query->where('transaction_type_id', '<>', null); 
			} else {
				$query->where('transaction_type_id', '=', $type);
				
			}
			
		})
		->get();
	}

	public static function agentsList($to,$from)
    {
	    return DB::table('agents')->where('as_at',">=",$from)->where('as_at',"<=",$to)->get();
	}

	public static function transactionTypes()
    {
	    return DB::table('product_types')->get();
	}
    
    
}
