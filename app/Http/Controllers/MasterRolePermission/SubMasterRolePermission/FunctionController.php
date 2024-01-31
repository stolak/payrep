<?php

namespace App\Http\Controllers\function_setup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;

class FunctionController extends Controller
{
   public function create()
    {
        $data['roles']          = DB::table('user_role')->get();
        $data['functions']        = DB::table('function')->paginate(15);
        return view('function_setup/function/create',$data);
    }

    
    public function addFunction(Request $request)
    {
        $this->validate($request, [
            'name'                 => 'required|string',
            ]);

        $functionname              = $request['name'];
         $rank                     = $request['rank'];
        $date                      = date('Y-m-d');
        DB::table('function')->insert(array( 
        'function_name'            => $functionname,
        'function_rank'            => $rank,
        'created_at'               => $date,
        ));
        return redirect('function/create')->with('message','Function Created Successfully');
    }

   
    public function displayModules()
    {
      $data['modules'] = DB::table('function')->get();
      return view('function_setup/function/viewfunction', $data);
    }

   
    public function editFunction($id)
    {
         $data['edit'] = DB::table('function')->where('functionID','=', $id)->first();
         return view('function_setup/function/edit',$data);
    }

   
    public function updateFunction(Request $request)
    {
        $functionname             = $request['name'];
        $functionID               = $request['functionID'];
        $rank                     = $request['rank'];

        DB::table('function')->where('functionID','=',$functionID)->update(array( 
        'function_name'            => $functionname,
        'function_rank'            => $rank,
        ));
        return redirect('/function/edit/'.$functionID)->with('message','Function Successfully Updated');
    }

    
}
