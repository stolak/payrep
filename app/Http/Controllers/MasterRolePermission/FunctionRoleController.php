<?php

namespace App\Http\Controllers\MasterRolePermission;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterRolePermissionController;
use App\Http\Requests;
use Session;
use DB;
use Auth;

class FunctionRoleController extends MasterRolePermissionController
{

    public function create()
    {
        $data['allFunction'] = $this->getAllFunction(10);
        return view('MasterRolePermission/functionRole/create', $data);
    }

    
    public function processFunction(Request $request)
    {
        $this->validate($request, [
            'functionDescription'      => 'required|string',
            'functionName'             => 'required|regex:/^[a-zA-Z0-9,.!?\)\( ]*$/',
        ]);
        $functionDescription = trim($request['functionDescription']);
        $functionName        = trim($request['functionName']);
        $date                = date('Y-m-d');
        //
        $addNewFunctionRole = $this->getAddFunction($functionName, $functionDescription);
        if($addNewFunctionRole)
        {
            return redirect()->route('create_function')->with('message','New Role-Function Created Successfully');
        }else{
            return redirect()->route('create_function')->with('error_message','Sorry, we cannot add new Role-Function. Try again');
        }
    }

   
    public function updateSubModule(Request $request)
    {
        $this->validate($request, [
            'module'        => 'required|numeric',
            'subModule'     => 'required|regex:/^[a-zA-Z0-9,.!?\)\( ]*$/',
            'subModuleID'   => 'required|numeric',
        ]);
        $moduleID             = $request['module']; 
        $submodulename      = $request['subModule'];
        $submoduleID        = $request['subModuleID'];
        $route = ltrim(rtrim($request['route'], "/"),  "/");
        //
        $updateSubModule = $this->getUpdateSubModule($submoduleID, $moduleID, $submodulename, $route);
        if($updateSubModule)
        {
            return redirect('sub-module/edit/'.$submoduleID)->with('message','Sub-module Successfully Updated');
        }else{
            return redirect('sub-module/edit/'.$submoduleID)->with('error_message','Sorry, we cannot update this Sub-module');
        }
    }

    
}
