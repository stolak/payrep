<?php

namespace App\Http\Controllers\MasterRolePermission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use DB;
use Auth;
use App\Models\Module;
use App\Models\Submodule;
use App\Models\UserRole;
use App\Models\AssignRoleModule;

class AssignModuleRoleController extends Controller
{
    public function create(Request $request)
    {
    $data['role']=$request->input('role');
   	if ($data['role']=='') {$data['role']=Session::get('role');}
   	    Session(['role' => $data['role']]);
        $data['roles']         = UserRole::all();
          $data['submodules']    = DB::table('modules')->where('submodules.status', 1)
        ->join('submodules', 'submodules.moduleid', '=', 'modules.id')
        ->selectRaw('submodules.id as modID, modules.id as moduleID, submodules.id, modules.module, submodules.submodule')
       ->orderBy('moduleID')
        ->get();
        foreach ($data['submodules'] as $b){
            $b->active=(db::table('assign_role_modules')->where('roleid',$data['role'])->where('submoduleid',$b->modID)->first())?1:0;
        }
        
        return view('assignModule.assign', $data);
    }

    
    public function assignSubModule(Request $request)
    {
        $data['role']=$request->input('role');
       	if($data['role']==''){$data['role']=Session::get('role');}
       	Session(['role' => $data['role']]);
        $this->validate($request, [
            'role'          => 'required|numeric',
        ]);
        $roleID             = $request['role'];
        $data['submodules']    = DB::table('submodules')->where('submodules.status', 1)->get();
        AssignRoleModule::where('roleid', $roleID)->delete();
        //$this->getDeleteAssignModuleRole($roleID); //clear and assign afresh
        foreach($data['submodules'] as $b){
            
                if($request['arraysubModule_'.$b->id]){
                    AssignRoleModule::create([
                        'roleid' => $roleID,
                        'submoduleid' => $b->id,
                    ]);
                    // $this->getAssignSubModuleRole($roleID, $b->id);
                }
        }
        
        return redirect()->route('AssignModule')->with('message','Module Assigned Successfully');
    }


    public function displaySubModules()
    {
      $data['submodules'] = $this->getAllSubModule(0);
      return view('subModule/viewsubmodules', $data);
    }


    
}
