<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\UserRole;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function userAccount()
    {
        return view('auth.editAccount');
    }

    public function userAccountUpdate(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:5'],
        ]);
        DB::table('users')->where('id',    Auth::user()->id)->update([
            'password' => bcrypt($request['password']) ,
           ]);
        return redirect('/user/account')->with('msg','Successfully Update');
    }
    public function createUser()
    {
        $data['roles'] = UserRole::where('assignabled', 1)->get();
        $data['StatusList'] = DB::table('statuses')->get();
        $data['RegisteredUser'] = User::where('usertype', '<>', 1)
        ->leftJoin('user_roles', 'users.userrole', 'user_roles.id')
        ->orderby('name')
        ->select('users.*', 'user_roles.rolename')->get();
        return view('auth.register', $data);
    }
    public function saveUser(Request $request)
    {
        $this->validate($request, [
             // 'username'    => 'required|string|unique:users,username',
              'email'       => 'required|string|unique:users,email',
              'role'        => 'required',
              'password'    => 'required|confirmed|min:5',
            ]);
       $id = DB::table('users')->insertGetId(array(
            'name' => $request['name'],
            'username' => $request['email'],
            'email' => $request['email'],
            'userrole' => $request['role'],
            'usertype' => 2,
            'createdby' => Auth::user()->id,
            'password' => Hash::make($request['password']),
        ));
        return redirect('/create-user')->with('msg','Successfully Entered');
    }
    
   	public function updateUser(Request $request)
   	{
   		$this->validate($request, [
			'names'      	     => 'required',
			'email'			     => 'required|email',
			'role'			    => 'required',
			'status'			   => 'required',
			]);
		if (DB::table('users')->where('username', $request['username'])
        ->where('id', '<>', $request['userid'])
        ->first()) return back()->with('err', 'Whops! usename already exist with another user!');
		DB::table('users')->where('id',$request['userid'])->update([
            'name' =>$request['names'] ,
            'email' => $request['email'] ,
            'userrole' => $request['role'] ,
            'status' => $request['status'] ,
            'username' => $request['email'],
        ]);
        if ($request['password']!='') {
           $this->validate($request, [
                'names'      	   => 'required|regex:/^[\pL\s\-]+$/u',
                'email'			      => 'required|email',
                'password'			   => 'required|min:5',
                'role'			   => 'required',
			]);
            DB::table('users')->where('id',$request['userid'])->update([
         'password' => bcrypt($request['password']) ,
        ]);
        }
        if ($request['status']=='0') {
            DB::table('users')->where('id', $request['userid'])->update(['password' => 0 ,]);
        }
		return back()->with('msg', 'User Profile successfully updated!');
   	}

}
