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
								<h3 class="page-title">Profile</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Profile</li>
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
													<select class="select2 form-control" name="title" id="title" disabled>
														<option value="" ></option>
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
                                                        <input type="text" id="lastName" name="lastName" value="{{$lastName}}" class="form-control" style="text-align: left;"  readonly>
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>First name</label>
													<div class="input-group">
                                                        <input type="text" id="firstName" name="firstName" value="{{$firstName}}" class="form-control" style="text-align: left;"  readonly>
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Other name</label>
													<div class="input-group">
                                                        <input type="text" id="otherName" name="otherName" value="{{$otherName}}" class="form-control" style="text-align: left;"  readonly>
                                                    </div>
												</div>
											</div>
										</div>
										<div class="row">
										    <div class="col-md-3">
											    <div class="form-group">
													<label>Phone number</label>
													<div class="input-group">
                                                        <input type="text" id="phoneNumber" name="phoneNumber" value="{{$phoneNumber}}" class="form-control" style="text-align: left;"  readonly>
                                                    </div>
												</div>
											</div>
											
										    <div class="col-md-5">
												<div class="form-group">
													<label>Email Address</label>
													<div class="input-group">
                                                        <input type="text" id="email" name="email" value="{{$email}}" class="form-control" style="text-align: left;"  readonly>
                                                    </div>
												</div>
											</div>
											<div class="col-md-4">
											    <div class="form-group">
													<label>Account Officer</label>
													<select class="select2 form-control" name="marketer" disabled>
														<option value="" >	</option>
														@foreach($Marketer as $list)
														<option value="{{$list->id}}" {{($list->id==$marketer)? 'selected':''}}>{{$list->name}}</option>
														@endforeach
													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Home Address</label>
													<div class="input-group">
                                                        <input type="text" id="address" name="address" value="{{$address}}" class="form-control" style="text-align: left;"  readonly>
                                                    </div>
													
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Office Address</label>
													<div class="input-group">
                                                        <input type="text" id="officeAddress" name="officeAddress" value="{{$officeAddress}}" class="form-control" style="text-align: left;"  readonly>
                                                    </div>
													
												</div>
											</div>
										</div>
										<div class="row">
										   
										    <div class="col-md-3">
												<div class="form-group">
													<label>BVN</label>
													<div class="input-group">
                                                        <input type="text" id="bvn" name="bvn" value="{{$bvn}}" class="form-control" style="text-align: left;"  readonly>
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>NIN</label>
													<div class="input-group">
                                                        <input type="text" id="nin" name="nin" value="{{$nin}}" class="form-control" style="text-align: left;"  readonly>
                                                    </div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Remarks</label>
													<div class="input-group">
                                                        <input type="text" id="remark" name="remark" value="{{$remark}}" class="form-control" style="text-align: left;"  readonly>
                                                    </div>
												</div>
											</div>
										</div>
										<div class="row">
										    
											
										    <div class="col-md-6">
												<div class="form-group">
													<label>Guarantor's Full Names</label>
													<div class="input-group">
                                                        <input type="text" id="guarantorName" name="guarantorName" value="{{$guarantorName}}" class="form-control" style="text-align: left;"  readonly>
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
											    <div class="form-group">
													<label>Phone number</label>
													<div class="input-group">
                                                        <input type="text" id="guarantorPhoneNumber" name="guarantorPhoneNumber" value="{{$guarantorPhoneNumber}}" class="form-control" style="text-align: left;" readonly>
                                                    </div>
												</div>
											</div>
											
										    <div class="col-md-3">
												<div class="form-group">
													<label>Email Address</label>
													<div class="input-group">
                                                        <input type="text" id="guarantorEmail" name="guarantorEmail" value="{{$guarantorEmail}}" class="form-control" style="text-align: left;"  readonly>
                                                    </div>
												</div>
											</div>
										</div>
										<div class="row">
										    
											<div class="col-md-6">
												<div class="form-group">
													<label>Home Address</label>
													<div class="input-group">
                                                        <input type="text" id="guarantorHomeAddress" name="guarantorHomeAddress" value="{{$guarantorHomeAddress}}" class="form-control" style="text-align: left;"  readonly>
                                                    </div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Office Address</label>
													<div class="input-group">
                                                        <input type="text" id="guarantorOfficeAddress" name="guarantorOfficeAddress" value="{{$guarantorOfficeAddress}}" class="form-control" style="text-align: left;"  readonly>
                                                    </div>
												</div>
											</div>
										</div>
										
										
									</form>
								</div>
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

  </script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->