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

class SubModuleController extends Controller
{
    public function create()
    {
         $data['submodules'] = DB::table('submodules')
            ->leftjoin('modules', 'modules.id', '=', 'submodules.moduleid')
            ->orderBy('modules.module_rank', 'ASC')
            ->orderBy('modules.module', 'ASC')
            ->orderBy('submodules.rank', 'ASC')
            ->orderBy('submodules.submodule', 'ASC')
            ->get();
        $data['modules']    = Module::all() ;
        return view('subModule.create', $data);
    }

    public function addSubModule(Request $request)
    {
        $this->validate($request, [
            'module'        => 'required|string',
            'subModule'     => 'required|regex:/^[a-zA-Z0-9,.!?\-)\( ]*$/|max:1000|unique:submodules,submodule',
            'route'         => 'required|string',
            'ranks'         => 'required|string',
        ]);
        $route              = ltrim(rtrim($request['route'], "/"),  "/");
        $addSubModule = Submodule::create([
            'moduleid' => $request->input('module'),
            'submodule' => $request->input('subModule'),
            'links' => $route,
            'rank' => $request->input('ranks'),
        ]);
        if (!$addSubModule) {
            return redirect()
            ->route('createSubModule')
            ->with('error_message','Sorry, we cannot add new submodule. Try again');
        }
        return redirect()->route('createSubModule')
        ->with('message','Sub Module Created Successfully');
    }

    public function updateSubModule(Request $request)
    {
        $this->validate($request, [
            'subModules'     => 'required|regex:/^[a-zA-Z0-9,.!?\-)\( ]*$/|max:1000',
            'modules'        => 'required|numeric',
            'subModuleID'   => 'required|numeric',
        ]);

        $submoduleID = $request['subModuleID'];
        $route          = ltrim(rtrim($request['routes'], "/"), "/");
         Submodule::where('id', $submoduleID)->update([
            'moduleid' => $request->input('modules'),
            'submodule' => $request->input('subModules'),
            'links' => $route,
            'rank' => $request->input('ranks'),
        ]);
        return redirect()->route('createSubModule')->with('message','SubModule Successfully Updated');
    }
}
