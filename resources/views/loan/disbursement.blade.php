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
								<h3 class="page-title">Loan Disbursement</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Loan Disbursement</li>
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
							<div class="card card-table">
								<div class="card-header">
									<h4 class="card-title"> Approved Loan</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th rowspan="1">S/N</th>
													<th rowspan="1">Names</th>
													<th rowspan="1">Amount</th>
													<th rowspan="1">Remarks</th>
													<th rowspan="1">Approved By</th>
													<th rowspan="1">Approved Date</th>
													<th rowspan="1">Action</th>
												</tr>
											</thead>
											<tbody>
											    @php $sn=1;@endphp
											   @foreach($Loans as $list)
												<tr>
													<td >
														{{$sn++}}
													</td>
													<td >
													{{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}
													</td>
													<td >
													{{number_format($list->amount_approved,2, '.', ',')}}
													</td>
													<td >
														{{$list->remarks}}
													</td>
													<td >
														{{$list->name}}
													</td>
													<td >
													
														{{date_format(date_create($list->approval_date??''),'d-m-Y')}}
													</td>
													<td>
														@if($list->is_processed===1)
														<a class="btn btn-sm bg-success-light" href="javascript: editFunc('{{$list->id}}', '{{$list->customer_id}}', '{{$list->marketer_id}}', '{{$list->amount_approved}}', '{{$list->period}}', '{{$list->percentage}}', '{{$list->total_interest}}', '{{$list->total_repayment}}', '{{$list->monthly_repayment}}')">
															Process
														</a>
														@endif
														@if($list->is_processed===0)
														<a  class="btn btn-sm bg-success" href="javascript: processFunc('{{$list->id}}','{{$list->title}} {{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}','{{$list->amount_approved}}')">
																Pressing Charge
														</a>
														@endif
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
		
			</div>
				<!-- Edit Details Modal -->
			<div class="modal fade" id="edit_details" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Loan Disbursement</h5>
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
											<select class="form-control" name="customer" id="e-customer" readonly disabled>
												@foreach($customers as $list)
													<option value="{{$list->id}}" >{{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}</option>
												@endforeach
											</select>
										</div>
									</div>
							    </div>
							    <div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Amount</label>
											<input type="text" class="form-control" id="e-amount"  name="amount"
											readonly disabled
											>
										</div>
									</div>
							    </div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Payment Source</label>
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
											<input type="date" class="form-control" name="disbursedDate">
										</div>
									</div>
							    </div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>First Due Date</label>
											<input type="date" class="form-control" name="firstDueDate">
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
								
								<input type="hidden" id="e-id" name="id" >
								<button type="submit" class="btn btn-primary" name="update">Disburse</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Edit Details Modal -->

		<!-- Activation Modal -->
		<div class="modal fade" id="activate_modal" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Processing Fees charge</h5>
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
											<input type="text" class="form-control" id="p-customer"
											readonly disabled
											>
										</div>
									</div>
							    </div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Processing fees</label>
											<input type="text" class="form-control" id="p-amount"
											readonly disabled
											>
										</div>
									</div>
							    </div>
							    
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Paid to</label>
											<select class="form-control" name="bank" >
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
								<button type="submit" class="btn btn-primary" name="process">Continue</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Activation Modal -->
@endsection
@section('scripts')
<script>
	const editFunc=(id,customer, marketer, amount, period, rate, interest, totalRepayment, monthlyRepayment )=>{
        document.getElementById('e-id').value = id;
		document.getElementById('e-customer').value = customer;
		document.getElementById('e-amount').value = parseFloat(amount
		.toString().replace(/\,/g,'')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");;
        $("#edit_details").modal('show')
    }

	
	const processFunc=(id, customer,amount,)=>{
        document.getElementById('activate-id').value = id;
		document.getElementById('p-customer').value = customer;
		let comp_amount= amount * {{$percentage*0.01}} ;
		document.getElementById('p-amount').value = parseFloat(comp_amount
		.toString().replace(/\,/g,'')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $("#activate_modal").modal('show')
    }
    
</script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->