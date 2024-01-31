<?php

namespace App\Http\Controllers\role_setup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use Session;

class AssignUserRoleController extends Controller
{
    public function create()
    {
        $data['roles']          = DB::table('user_role')->get();
        $data['modules']        = DB::table('module')->get();
        $data['users']          = DB::table('users')->get();
        $data['userroles']      = DB::table('assign_user_role')
        ->join('users','users.id','=','assign_user_role.userID')
        ->join('user_role','user_role.roleID','=','assign_user_role.roleID')
        ->paginate(10);
        return view('role_setup/assignUser/assign',$data);
    }
    
    public function assignUser(Request $request)
    {
        $this->validate($request, [
            'role'              => 'required|numeric',
            'user'              => 'required|numeric',
            ]);

       // $modulename             = $request['name'];
        $roleID                 = $request['role'];
        $userID                 = $request['user'];
        $date                   = date('Y-m-d');
        $exist = DB::table('assign_user_role')->where('userID','=',$userID)->count();
        if($exist == 1)
        {
            DB::table('assign_user_role')->where('userID','=',$userID)->update(array( 
                'userID'                => $userID,
                'roleID'                => $roleID,
                'created_at'            => $date,
            ));
        }
        else
        {
            DB::table('assign_user_role')->insert(array( 
                'userID'                => $userID,
                'roleID'                => $roleID,
                'created_at'            => $date,
            ));
        }
        Session::forget('userModule');
        $userModule = DB::table('assign_user_role')
                ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
                ->join('assign_module_role', 'assign_module_role.roleID', '=', 'assign_user_role.roleID')
                ->join('module', 'module.moduleID', '=', 'assign_module_role.moduleID')
                ->where('assign_user_role.userID', '=', Session::get('userID'))
                ->whereRaw('module.moduleID = assign_module_role.moduleID')
                ->whereRaw('user_role.roleID = assign_user_role.roleID')
                ->distinct()
                ->select('module.modulename', 'module.moduleID', 'user_role.rolename')
                ->get();
        Session::put('userModule', $userModule);
        return redirect('user-assign/create')->with('message','User was Successfully assigned to a role');
    }

   
    public function displayModules()
    {
      $data['modules'] = DB::table('module')->get();
      return view('role_setup/module/viewmodules', $data);
    }

   
    public function editUser($id)
    {
         $data['edit'] = DB::table('assign_user_role')->where('assignuserID','=', $id)->first();
         return view('role_setup/assignUser/edit',$data);
    }

   
    public function updateModule(Request $request)
    {
        $modulename             = $request['name'];
        $moduleID               = $request['moduleID'];
        DB::table('module')->where('moduleID','=',$moduleID)->update(array( 
        'modulename'            => $modulename,

        ));
        return redirect('user-assign/edit/'.$moduleID)->with('message','Module Successfully Updated');
    }

    public function autocomplete(Request $request)
    {
        $query = $request->input('query');
        $search = DB::table('users')
                ->where('name', 'LIKE', '%'.$query.'%')
                //->orWhere('first_name', 'LIKE', '%'.$query.'%')
                ->orWhere('username', 'LIKE','%'.$query.'%')
                ->take(15)
                ->get();
        $return_array = null;
        foreach($search as $s)
        {
          $return_array[]  =  ["value"=>$s->name, "data"=>$s->id];
        }   
        return response()->json(array("suggestions"=>$return_array));
    }


    public function displayUser(Request $request)
    {  
        $data['roles']          = DB::table('user_role')->get();
        $data['modules']        = DB::table('module')->get();
        $data['users']          = DB::table('users')->get(); 
        $userID = $request['nameID'];  
        $data['userroles']  = DB::table('assign_user_role')
        ->join('users','users.id','=','assign_user_role.userID')
        ->join('user_role','user_role.roleID','=','assign_user_role.roleID')
        ->where('assign_user_role.userID','=',$userID)
        ->paginate(10);
        return view('role_setup/assignUser/assign',$data);
    }


}
