<?php

namespace App\Http\Controllers\MasterRolePermission;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterRolePermissionController;
use App\Http\Requests;
use Session;
use DB;
use Auth;

class CreateTechnicalUserController extends MasterRolePermissionController
{
    //Allow only Authenticated user
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

   

    //Load Create user form
    public function create()
    {
        return view('MasterRolePermission.createTechnicalUser.create');
    }



    //Create New Technical User
    public function store(Request $request)
    {
        $this->validate($request, [
            'fullName'              => 'required|regex:/^[a-zA-Z0-9,.!?\-)\( ]*$/|max:1000',
            'userName'              => 'required|alpha_dash|min:4|max:100|unique:users,name',
            'password'              => 'required|confirmed|min:5',
        ]);
        $fullName               = trim($request['fullName']);
        $userName               = trim($request['userName']);
        $password               = trim($request['password']);
        $getCreateTechnical     = $this->createStaffUser($fullName, $userName, $password);
        //$getCreateTechnical     = $this->getCreateTechnicalUser($fullName, $userName, $password);
        if($getCreateTechnical)
        {
          return redirect()->route('createTechnicalUser')->with('message', 'New Technical was added Successfully');
        }
        return redirect()->route('createTechnicalUser')->with('error_message', 'Sorry, We cannot add new technical to the system. Try again');
    }

   
   //Edit Technical User
    public function editTechnicalUser()
    {
      

    }

   
    
    
} //End class

