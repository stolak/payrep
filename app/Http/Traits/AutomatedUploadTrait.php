<?php
namespace App\Http\Traits;

use DB;
use Auth;

trait AutomatedUploadTrait
{
   
    public static function searchUpload($type,$from,$to,$status)
    {
	    return DB::table('automated_record')->get();
	}

	public static function agentsList()
    {
	    return DB::table('agents')->get();
	}
    
    
}