<?php

namespace App\Http\Controllers\MasterRolePermission;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterRolePermissionController;
use App\Http\Requests;
use Session;
use DB;
use Auth;

class UserRoleController extends MasterRolePermissionController
{
    //Allow only Authenticated user
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

   
    public function create()
    {
        $data['allRoles']     = $this->getUserRole(10);
        return view('MasterRolePermission.roleUser.create', $data);
    }

    
    public function addRole(Request $request)
    {
        $this->validate($request, [
            'roleName' => 'required|regex:/^[a-zA-Z0-9,.!?\-)\( ]*$/|max:1000|unique:user_role,rolename',
        ]);
        $roleName        = trim($request['roleName']);
        $getCreateRole   = $this->getCreateRole($roleName);
        if(!$getCreateRole)
        {
          return redirect()->route('CreateUserRole')->with('error_message', 'Sorry, We cannot add new role. Try again');
        }
        return redirect()->route('CreateUserRole')->with('message', 'New Role Created Successfully');
    }

   
    public function displayRoles()
    {
      $data['allRoles'] = $this->getUserRole(0);
      return view('MasterRolePermission.roleUser.viewroles', $data);
    }

   
    public function editRole($id)
    {
         $data['edit'] = $this->getFindRole($id);
        if($data['edit'])
        {
           return view('MasterRolePermission.roleUser.edit', $data); 
       }else{
            return redirect()->route('CreateUserRole')->with('error_message', 'No record found !'); 
         
       }
         
    }

   
    public function updateRole(Request $request)
    {
        $this->validate($request, [
            'roleName' => 'required|regex:/^[a-zA-Z0-9,.!?\-)\( ]*$/|max:1000',
             'roleID'   => 'required|numeric',
        ]);
        $roleName      = trim($request['roleName']);
        $roleID        = trim($request['roleID']);
        //dd($roleID);
        $getUpdateRole = $this->getUpdateRole($roleID, $roleName);
        
        return back()->with('message','Role Successfully Updated');
    }

    public function destroy($id)
    {
        //
    }
}
