<?php

namespace App\Http\Controllers\role_setup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Requests;
use Session;
use DB;

class UserRoleController extends Controller
{
    
   
    public function create()
    {
         $data['allRoles']     = DB::table('user_role')->paginate(10);

        return view('role_setup/roleuser/create',$data);
    }

    
    public function addRole(Request $request)
    {
        $this->validate($request, [
        'name'                  => 'required|string',
        ]);
        $rolename               = $request['name'];

        $exist = DB::table('user_role')->where('rolename', '=', $rolename)->count();
        if($exist ==1)
        {
            return redirect('/user-role/create')->with('err','Role Already Exist');
        }
        else
        {
        $date                   = date('Y-m-d');
        DB::table('user_role')->insert(array( 
        'rolename'              => $rolename,
        'created_at'            => $date,
        ));
          return redirect('/user-role/create')->with('message','Role Created Successfully');
      }
    }

   
    public function displayRoles()
    {
      $data['allRoles'] = DB::table('user_role')->get();
      return view('role_setup/roleuser/viewroles', $data);
    }

   
    public function editRole($id)
    {
         $data['edit'] = DB::table('user_role')->where('roleID','=', $id)->first();
         return view('role_setup/roleuser/edit',$data);
    }

   
    public function updateRole(Request $request)
    {
         $rolename                = $request['name'];
         $roleID                  = $request['roleID'];
        DB::table('user_role')->where('roleId','=',$roleID)->update(array( 
                'rolename'        => $rolename,
                ));
        return redirect('/user-role/edit/'.$roleID)->with('message','Role Successfully Updated');
    }

    public function destroy($id)
    {
        //
    }
}
