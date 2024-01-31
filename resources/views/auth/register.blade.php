<!-- Page Wrapper -->
@extends('layouts.layout')
@section('pageTitle')
     {{env('Page_Title')}}
@endsection
@section('content')
            <div class="page-wrapper">
				<div class="content container-fluid">
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col">
								<h3 class="page-title">User registration</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">User registration</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<!-- include notification -->
        			 @include('_partialView.nofication')
        			 <!-- /include notification -->
        			 <div class="panel-body">
                        <form method="post" action="{{ url('create-user') }}">
                        {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input type="text" class="form-control " name="name" value="{{ old('name') }}" autocomplete="off">
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Username</label>
                                        <input type="text" name="username" class="form-control " value="{{ old('username') }}" autocomplete="off">
                                        @if ($errors->has('username'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="email" class="form-control " name="email" autocomplete="off">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <label >{{ __('Role') }}</label>
					            <select name='role' class="form-control select2" >
                                      <option value=""></option>
                                      @foreach($roles as $list)
                                      <option value="{{$list->id}}">{{$list->rolename}}</option>
                                      @endforeach
                                      </select>
                                       
                                    </div>
                                </div>
                                </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Password</label>
                                        <input type="password" name="password" class="form-control " autocomplete="off">
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off">
                                    </div>
                                </div>

                            </div>
                        <div class="panel-footer text-right">
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </form>
			<div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                <table id="mytable" class="table table-bordered table-striped table-highlight" >
                    <thead>
                        <tr bgcolor="#c7c7c7">
            <th>S/N</th>
            <th>Username</th>
            <th>Names</th>
            
            <th>User Roles</th>
            <th>Email Address</th>
            <th>Status</th>
            <th>Action</th>
            
          </tr>
        </thead>
          <tbody>
        
          @php
          $i=1;
          @endphp
            
            @foreach($RegisteredUser as $pv)     
       <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $pv->username }}</td>
            <td>{{ $pv->name }} </td>
            <td>{{ $pv->rolename}}</td>
            <td>{{ $pv->email}}</td>
            <td>{{ ($pv->status==1)?'Active':'Suspended'}}</td>
            <td>
             <div class="actions">
    			<a class="btn btn-sm bg-success-light" href="javascript: updateuser('{{$pv->id}}','{{$pv->username}}','{{$pv->name}}','{{$pv->email}}','{{$pv->userrole}}','{{$pv->status}}')">
    				<i class="fe fe-pencil"></i> Edit
    			</a>
    		</div>
            </td>
               
       </tr>
             @endforeach
          </tbody>      
      </table>
       <hr />
    </div>
			<div id="editmodal" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">User profile Update</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal"  role="form" method="POST"  action="{{ url('/user/update') }}">
                {{ csrf_field() }}
        <div class="modal-body"> 
        
            <div class="form-group" style="margin: 0 10px;">
                <div class="col-sm-12">
                <label class="control-label">User Name</label>
                <input type="text" class="form-control"   id="username2" name="username">
                </div>
            </div>
             <div class="form-group" style="margin: 0 10px;">
                <div class="col-sm-12">
                <label class="control-label">Full Name</label>
                <input type="text" class="form-control" value="" name="names" id="names2" >
                </div>
            </div>
            <div class="form-group" style="margin: 0 10px;">
                <div class="col-sm-12">
                <label class="control-label">email</label>
                <input type="text" class="form-control" value="" name="email" id="email2" >
                </div>
            </div>
             <div class="form-group" style="margin: 0 10px;">
                <div class="col-sm-12">
                <label class="control-label">New Password</label>
                <input type="password" name="password" class="form-control" >
                </div>
            </div>
            <div class="form-group" style="margin: 0 10px;">
                <div class="col-sm-12">
                <label for="userName">Role Privilege</label>
                <select class="form-control" id="roleedit" name="role" required>                                         
	                <option value=""> Select Role Privilege</option>
	                 @foreach ($roles as $j)
	                <option value="{{$j->id}}"> {{$j->rolename}}</option>
	                @endforeach
	                  
	            </select>
                </div>
            </div>
            <div class="form-group" style="margin: 0 10px;">
                <div class="col-sm-12">
                <label class="control-label">User Status</label>
                <select  class="form-control" id="status"  name="status" >
                     <option value="">--select--</option>
                          @foreach($StatusList as $list)
                     <option value="{{ $list->id }}">{{ $list->status }}</option>
                          @endforeach
                    </select>
                </div>
            </div>
        </div>
        
            <div class="modal-footer">
                <input type="hidden" class="form-control"  name="userid" id="userid" >
                <button type="Submit" class="btn btn-success" name="priceupdate">Update</button>
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
            </div>
        </form>
            
        </div>
        
      </div>
</div>
			</div>
		</div>
		</div>
@endsection
@section('scripts')
<script>

   function updateuser(id, username,names,email,role,status){
    document.getElementById('userid').value = id;
    document.getElementById('username2').value = username;
    document.getElementById('names2').value = names;
    document.getElementById('email2').value = email;
     document.getElementById('roleedit').value = role;
      document.getElementById('status').value = status;
    
    $("#editmodal").modal('show')
      
   }
  </script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->