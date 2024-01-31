<?php

namespace App\Http\Controllers\MasterRolePermission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use DB;
use Auth;

class AssignUserRoleController extends Controller
{

    public function create()
    {
                //die("ksksk");

        $data['roles']          = $this->getUserRole(0);
                //die("ksksk");

        $data['modules']        = $this->getAllModule(0);
        $data['users']          = $this->getAllUser(0);

        $data['userroles']      = $this->getAllAssignUserRole(10);
        return view('MasterRolePermission/assignUser/assign', $data);
    }
    
    //Assign User
    public function assignUser(Request $request)
    {
        $this->validate($request, [
            'role'              => 'required|numeric',
            'user'              => 'required|numeric',
        ]);
       // $modulename             = $request['name'];
        $roleID                 = $request['role'];
        $userID                 = $request['user'];

        $getAssignUserRole = $this->getAssignUserRole($userID, $roleID);
        if($getAssignUserRole)
        {
             return redirect()->route('AssignUser')->with('message','User was Successfully assigned to a role');
        }else
        {
             return redirect()->route('AssignUser')->with('error_message','Sorry, we cannot assign this user to role. Try again');
        }
       
    }

   
    public function displayModules()
    {
      $data['modules'] = $this->getAllModule();
      return view('MasterRolePermission/module/viewmodules', $data);
    }

   
    public function editUsreAssign($id)
    {
         $data['edit'] = $this->getFindAssignRole($id);
         return view('MasterRolePermission/assignUser/edit', $data);
    }

   
    public function updateModule(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required|string',
            'moduleID'          => 'required|numeric',
        ]);
        $modulename             = $request['name'];
        $moduleID               = $request['moduleID'];
        $getModuleUpdate        = $this->getUpdateModule($moduleID, $modulename);
        if($getModuleUpdate)
        {
            return redirect()->route('AssignUser')->with('message','Module Successfully Updated');
        }else
        {
            return redirect()->route('AssignUser')->with('error_message','Sorry, we cannot update this Module. Try again');
        }
       
    }


    public function autocomplete(Request $request)
    {
        $query = $request->input('query');
        $search = DB::table('users')
                ->where('name', 'LIKE', '%'.$query.'%')
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
        $this->validate($request, [
            'nameID'            => 'required|string',
        ]);
        $userID                 = trim($request['nameID']); 
        // 
        $data['roles']          = $this->getUserRole();
        $data['modules']        = $this->getAllModule();
        $data['users']          = $this->getAllUser();
        $data['userroles']      = $this->getFindAllAssignUserRole($userID, 10);
        return view('MasterRolePermission/assignUser/assign', $data);
    }


}
