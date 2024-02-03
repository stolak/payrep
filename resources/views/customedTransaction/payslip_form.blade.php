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
								<h3 class="page-title">Payslip</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Payslip</li>
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
						
                                    {{ csrf_field() }}
										<div class="row">
										    
											
										    <div class="col-md-5">
												<div class="form-group">
													<label>Staff fullNames</label>
													<div class="input-group">
                                                        <input type="text" id="names" name="names"  class="form-control" style="text-align: left;"  >
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Employee ID</label>
													<div class="input-group">
                                                        <input type="text" id="firstName" name="emp_no"  class="form-control" style="text-align: left;"  >
                                                    </div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Position</label>
													<div class="input-group">
                                                        <input type="text" id="otherName" name="position"  class="form-control" style="text-align: left;"  >
                                                    </div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>Year</label>
													<div class="input-group">
                                                        <input type="text" id="otherName" name="Year"  class="form-control" style="text-align: left;"  >
                                                    </div>
												</div>
											</div>
											<div class="col-md-2">
											    <div class="form-group">
													<label>Month</label>
													<select class="select2 form-control" name="Month" id="title" >
														<option value="" >-select-</option>
														<option value="January" >January</option>
														<option value="February" >February</option>
														<option value="March" >March</option>
														<option value="April" >April</option>
														<option value="May" >May</option>
														<option value="June" >June</option>
														<option value="July" >July</option>
														<option value="August" >August</option>
														<option value="October" >October</option>
														<option value="November" >November</option>
														<option value="December" >December</option>
										
													</select>
												</div>
											</div>
										</div>
										<div class="row">
										    <div class="col-md-3">
											    <div class="form-group">
													<label>Basic</label>
													<div class="input-group">
                                                        <input type="text" id="basic" name="basic"  class="form-control" style="text-align: left;"  >
                                                    </div>
												</div>
											</div>
											
										    <div class="col-md-3">
												<div class="form-group">
													<label>Huosing Allowance</label> 
													<div class="input-group">
                                                        <input type="text" id="email" name="housing"  class="form-control" style="text-align: left;"  >
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Transportation Allowance</label>
													<div class="input-group">
                                                        <input type="text"  name="transportation"  class="form-control" style="text-align: left;"  >
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Medical Allowance</label>
													<div class="input-group">
                                                        <input type="text"  name="medical"  class="form-control" style="text-align: left;"  >
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Utility Allowance</label>
													<div class="input-group">
                                                        <input type="text"  name="utility"  class="form-control" style="text-align: left;"  >
                                                    </div>
												</div>
											</div>
											</div>
											<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label>Payee Tax</label>
													<div class="input-group">
                                                        <input type="text"  name="tax"  class="form-control" style="text-align: left;"  >
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Contributing Pension</label>
													<div class="input-group">
                                                        <input type="text"  name="pension"  class="form-control" style="text-align: left;"  >
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>NHF</label>
													<div class="input-group">
                                                        <input type="text"  name="nhf"  class="form-control" style="text-align: left;"  >
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Loan/Salary Advance</label>
													<div class="input-group">
                                                        <input type="text"  name="loan"  class="form-control" style="text-align: left;"  >
                                                    </div>
												</div>
											</div>
											
										</div>
									
										<div class="text-right">
											<button type="submit" class="btn btn-primary" name="addnew">Submit</button>
											
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
									<h4 class="card-title"> Payslips</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th rowspan="1">S/N</th>
													
													<th rowspan="1">Names</th>
													<th rowspan="1">Employee ID</th>
													<th rowspan="1">Position</th>
													<th rowspan="1">Year </th>
													<th rowspan="1">Month</th>
													
													<th rowspan="1">Action</th>
												</tr>
											</thead>
											<tbody>
											    @php $sn=1;@endphp
											   @foreach($payslips as $list)
											  
												<tr>
													<td >
														{{$sn++}}
													</td>
													
													<td >
													{{$list->names}} 
													</td>
													<td >
													{{$list->emp_no}}
													</td>
													<td >
													{{$list->position}}
													</td>
													<td >
													{{$list->Year}}
													</td>
													<td >
														{{$list->Month}}
													</td>
													<td>
													
														<a class="btn btn-sm bg-success-light" href="/payslip/{{$list->id}}" target="_blank">
																view
															</a>
														
													</td>
												 </tr>
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