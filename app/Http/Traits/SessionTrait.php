<?php

namespace App\Http\Traits;

use Session;

trait SessionTrait
{
    public static function validate($request, $input)
    {
        $data = $request->input($input);
   	    if ($data=='') {
            $data=Session::get($input);
        }
   	    Session([$input => $data]);
        return  $data;
    }
    public static function forget($request, $arr)
    {
        

        foreach ($arr as $v) {
           //echo(array_keys($v));
            $request->session()->forget($v);
        }
        //dd(array_keys($arr));
    }
}