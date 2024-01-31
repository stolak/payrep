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
								<h3 class="page-title">Customer Registration</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Registration</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<!-- include notoifcation -->
        			 @include('_partialView.nofication')
        			 <!-- /include notoifcation -->
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
								<form method="post" id="form1" >
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Search</label>
											<select class="select2 form-control" name="rid" onchange= 'Reload("form1");'>
												<option value="search" >search..</option>
												@foreach($customers as $list)
												<option value="{{$list->id}}" >{{$list->title}} {{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								</form>
									<div class="text-right">
										<button  class="btn btn-danger" name="addnew">Registration fees: {{number_format($fees,2, '.', ',')}}</button>
									</div>
								</div>
								<div class="card-body">
								<form method="post"  id="r-form">
								{{ csrf_field() }}
									<input type="hidden"  id="r-id" name="rid" >
								</form>
									<form method="post" name="mainform" id="mainform">
									<input type="hidden" name="id" value = "{{$id}}" >
                                    {{ csrf_field() }}
										<div class="row">
										    <div class="col-md-3">
											    <div class="form-group">
													<label>Title</label>
													<select class="select2 form-control" name="title" id="title">
														<option value="" >--Select--</option>
														@foreach($Title as $list)
														<option value="{{$list->id}}" {{($list->id==$title)? 'selected':''}}>{{$list->title}}</option>
														@endforeach
													</select>
												</div>
											</div>
											
										    <div class="col-md-3">
												<div class="form-group">
													<label>Surname</label>
													<div class="input-group">
                                                        <input type="text" id="lastName" name="lastName" value="{{$lastName}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>First name</label>
													<div class="input-group">
                                                        <input type="text" id="firstName" name="firstName" value="{{$firstName}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Other name</label>
													<div class="input-group">
                                                        <input type="text" id="otherName" name="otherName" value="{{$otherName}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
										</div>
										<div class="row">
										    <div class="col-md-3">
											    <div class="form-group">
													<label>Phone number</label>
													<div class="input-group">
                                                        <input type="text" id="phoneNumber" name="phoneNumber" value="{{$phoneNumber}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											
										    <div class="col-md-5">
												<div class="form-group">
													<label>Email Address</label>
													<div class="input-group">
                                                        <input type="text" id="email" name="email" value="{{$email}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											<div class="col-md-4">
											    <div class="form-group">
													<label>Account Officer</label>
													<select class="select2 form-control" name="marketer" id="marketer">
														<option value="" >--Select--</option>
														@foreach($Marketer as $list)
														<option value="{{$list->id}}" {{($list->id==$marketer)? 'selected':''}}>{{$list->name}}</option>
														@endforeach
													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label>State of Orgin</label>
													<div class="input-group">
                                                        <input type="text" id="state" name="state" value="{{$state}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>LGA/Home Town</label>
													<div class="input-group">
                                                        <input type="text" id="lga" name="lga" value="{{$lga}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Nature of Business</label>
													<div class="input-group">
                                                        <input type="text" id="business" name="business" value="{{$business}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Home Address</label>
													<div class="input-group">
                                                        <input type="text" id="address" name="address" value="{{$address}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
													<div class="status-toggle"> Verified
														<input type="checkbox" id="status_home" name="status_home" class="check" {{$status_home? 'checked':''}}>
														<label for="status_home" class="checktoggle"></label>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Office Address</label>
													<div class="input-group">
                                                        <input type="text" id="officeAddress" name="officeAddress" value="{{$officeAddress}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
													<div class="status-toggle"> Verified
														<input type="checkbox" id="status_office" name="status_office" class="check" {{$status_office? 'checked':''}}>
														<label for="status_office" class="checktoggle"></label>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
										   
										    <div class="col-md-3">
												<div class="form-group">
													<label>BVN</label>
													<div class="input-group">
                                                        <input type="text" id="bvn" name="bvn" value="{{$bvn}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>NIN/Means of Identification</label>
													<div class="input-group">
                                                        <input type="text" id="nin" name="nin" value="{{$nin}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Remarks</label>
													<div class="input-group">
                                                        <input type="text" id="remark" name="remark" value="{{$remark}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
										</div>
										<div class="row">
										    
											
										    <div class="col-md-6">
												<div class="form-group">
													<label>Guarantor's Full Names</label>
													<div class="input-group">
                                                        <input type="text" id="guarantorName" name="guarantorName" value="{{$guarantorName}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
											    <div class="form-group">
													<label>Phone number</label>
													<div class="input-group">
                                                        <input type="text" id="guarantorPhoneNumber" name="guarantorPhoneNumber" value="{{$guarantorPhoneNumber}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											
										    <div class="col-md-3">
												<div class="form-group">
													<label>Email Address</label>
													<div class="input-group">
                                                        <input type="text" id="guarantorEmail" name="guarantorEmail" value="{{$guarantorEmail}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
										</div>
										<div class="row">
										    
											<div class="col-md-4">
												<div class="form-group">
													<label>Home Address</label>
													<div class="input-group">
                                                        <input type="text" id="guarantorHomeAddress" name="guarantorHomeAddress" value="{{$guarantorHomeAddress}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Office Address</label>
													<div class="input-group">
                                                        <input type="text" id="guarantorOfficeAddress" name="guarantorOfficeAddress" value="{{$guarantorOfficeAddress}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Nature of Business</label>
													<div class="input-group">
                                                        <input type="text" id="guarantorBusiness" name="guarantorBusiness" value="{{$guarantorBusiness}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
										</div>
										
										<div class="text-right">
											@if(!$id)<button type="submit" class="btn btn-primary" name="addnew">Submit</button>@endif
											@if($id)<button type="submit" class="btn btn-primary" name="update">Save Changes</button>@endif
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					
				<div class="row">
						<div class="col-md-12">
						
							<!-- List of economic code -->
							<div class="card card-table">
								<div class="card-header">
									<h4 class="card-title"> List of customers</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th rowspan="1">S/N</th>
													
													<th rowspan="1">Names</th>
													<th rowspan="1">Phone Number</th>
													<th rowspan="1">email </th>
													<th rowspan="1">Address</th>
													<th rowspan="1">Marketer</th>
													<th rowspan="1">Action</th>
												</tr>
											</thead>
											<tbody>
											    @php $sn=1;@endphp
											   @foreach($customers as $list)
											  
												<tr>
													<td >
														{{$sn++}}
													</td>
													
													<td >
													{{$list->title}} {{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}
													</td>
													<td >
													{{$list->phone}}
													</td>
													<td >
													{{$list->email}}
													</td>
													<td >
													{{$list->address}}
													</td>
													<td >
														{{$list->name}}
													</td>
													<td>
													
														<a class="btn btn-sm bg-success-light" href="javascript: editFunc('{{$list->id}}')">
																Edit<i class="fe fe-pencil"></i>
															</a>
															@if($list->status===1)
														<a  class="btn btn-sm bg-danger-light" href="javascript: deactivateFunc('{{$list->id}}')">
																deactivate
														</a>
														@endif
														@if($list->status===0)
														<a  class="btn btn-sm bg-success" href="javascript: activateFunc('{{$list->id}}','{{$list->title}} {{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}')">
																activate
														</a>
														@endif
														<!--<a  class="btn btn-sm bg-danger-light" href="javascript: deleteFunc('{{$list->id}}')">
																<i class="fe fe-trash"></i>
														</a>-->
													</td>
												 
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- /List of economic code -->
							
						</div>
					</div>
				</div>
		
			
			<!-- Delete Modal -->
			<div class="modal fade" id="delete_modal" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<form method="post" >
                                    {{ csrf_field() }}
						<div class="modal-body">
							<div class="form-content p-2">
								<h4 class="modal-title">Delete</h4>
								<p class="mb-4">Are you sure want to delete?</p>
								<button type="submit" class="btn btn-primary" name="delete">Continue </button>
								<input type="hidden" id="d-id" name="id" >
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
			<!-- /Delete Modal -->
			<!-- Deactivate Modal -->
			<div class="modal fade" id="deactivate_modal" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<form method="post" >
                                    {{ csrf_field() }}
						<div class="modal-body">
							<div class="form-content p-2">
								<h4 class="modal-title">Delete</h4>
								<p class="mb-4">Are you sure want to deactivate this customer?</p>
								<p class="mb-4">Note that to re-activate this customer new registration fees will be apply</p>
								<button type="submit" class="btn btn-primary" name="deactivate">Continue </button>
								<input type="hidden" id="deactivate-id" name="id" >
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
			<!-- /Deactivate Modal -->

				<!-- Activation Modal -->
			<div class="modal fade" id="activate_modal" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Activation</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form method="post" >
                                    {{ csrf_field() }}
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Customer</label>
											<input type="text" class="form-control" id="e-customer"
											readonly disabled
											>
										</div>
									</div>
							    </div>
							    
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Paid to</label>
											<select class="form-control" name="bank" id="e-bank" >
												@foreach($banks as $list)
													<option value="{{$list->id}}" >{{$list->accountdescription}} </option>
												@endforeach
											</select>
										</div>
									</div>
							    </div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Payment Date</label>
											<input type="date" class="form-control" name="paymentDate">
										</div>
									</div>
							    </div>
								
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Remarks</label>
											<input type="text" class="form-control" id="e-remarks"  name="remarks">
										</div>
									</div>
								</div>
								
								<input type="hidden" id="activate-id" name="id" >
								<button type="submit" class="btn btn-primary" name="activate">Activate</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Activation Modal -->
			</div>
@endsection
@section('scripts')
<script>
const Reload = (form)=>document.forms[form].submit();
const editFunc=(id)=>{
        document.getElementById('r-id').value = id;
		Reload('r-form');
       
    }
	const deleteFunc=(id)=>{
        document.getElementById('d-id').value = id;
        $("#delete_modal").modal('show')
    }
	const activateFunc=(id, customer)=>{
        document.getElementById('activate-id').value = id;
		document.getElementById('e-customer').value = customer;
        $("#activate_modal").modal('show')
    }
	const deactivateFunc=(id)=>{
        document.getElementById('deactivate-id').value = id;
        $("#deactivate_modal").modal('show')
    }

  </script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->