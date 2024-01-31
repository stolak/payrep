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
								<h3 class="page-title">Role privileges</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Role Privileges</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<!-- include notoifcation -->
        			 @include('_partialView.nofication')
        			 <!-- /include notoifcation -->
        			 <form method="post" name="mainform" id="mainform" action="{{ url('/assign-module/assign') }}">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
								
                                    {{ csrf_field() }}
										<div class="row">
											<div class="col-md-5">
											    <div class="form-group">
													<label>Select user role</label>
													<select class="select2 form-control" name="role" id="role" onchange="Reload();">
														<option value="" >--Select--</option>
													    @foreach($roles as $list)
                                                         <option value="{{ $list->id }}" {{ (old('role') == $list->id ||($role) == $list->id  ) ? 'selected':'' }}>{{ $list->rolename }}</option>
                                                        @endforeach
													</select>
												</div>
											</div>
										</div>
										
										<div class="text-right">
											<button type="submit" class="btn btn-primary" name="addnew">Submit</button>
										</div>
								</div>
							</div>
						</div>
					</div>
						<!-- Recent Orders -->
					<div class="card card-table">
						<div class="card-header">
							<h4 class="card-title">Privileges</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>Module</th>
											<th>Submodule</th>
									
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
									     @foreach($submodules as $list)
										<tr>
											
											<td>{{$list->module}}</td>
											<td>{{$list->submodule}}</td>
											
											<td>
												<div class="status-toggle">
													<input type="checkbox" id="status_{{$list->modID}}" name="arraysubModule_{{$list->modID}}" class="check" {{$list->active? 'checked':''}}>
													<label for="status_{{$list->modID}}" class="checktoggle"></label>
												</div>
											</td>
											
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
			</form>		<!-- /Recent Orders -->
				
				</div>
			
			</div>
			<form method="post" name="mainform1" id="mainform1" >
			     {{ csrf_field() }}
			    <input type ="hidden" id='id' name="role"/>
			  </form  
@endsection
@section('scripts')
<script>
function  Reload()
	{
	document.getElementById('id').value = document.getElementById('role').value;
	 document.forms["mainform1"].submit();
	 return;
	}   
 function editfunc(id,judicial,location,category)
    {
        document.getElementById('e-id').value = id;
        document.getElementById('e-judicial').value = judicial;
        document.getElementById('e-location').value = location;
        document.getElementById('e-category').value = category;
        $("#edit_details").modal('show')
    }
   function deletefunc(id)
    {
        document.getElementById('d-id').value = id;
        $("#delete_modal").modal('show')
    }
    function NewBank(id ,judicial)
    {
        document.getElementById('bank-id').value = id;
        document.getElementById('b-judicial').value = judicial;
        $("#new_bank").modal('show')
    }
    function EditBank(bid ,judicial,subaccount,bank,bank_number)
    {
        document.getElementById('bank-e-id').value = bid;
        document.getElementById('b-e-judicial').value = judicial;
        document.getElementById('b-e-subaccount').value = subaccount;
        document.getElementById('b-e-bank').value = bank;
        document.getElementById('b-e-bank_number').value = bank_number;
        $("#edit_bank").modal('show')
    }
    function deleteBank(id)
    {
        document.getElementById('d-b-id').value = id;
        $("#delete_bank_modal").modal('show')
    }
  </script>      
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->