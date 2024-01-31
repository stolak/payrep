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
								<h3 class="page-title">Lodgement Approval</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Lodgement Approval</li>
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
							<!-- List of economic code -->
							<div class="card card-table">
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th rowspan="1">S/N</th>													
													<th rowspan="1">Date</th>
													<th rowspan="1">Names</th>
													<th rowspan="1">Amount</th>
													<th rowspan="1">Payment Details </th>
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
												
														{{date_format(date_create($list->payment_date??''),'d-m-Y')}}
													</td>
													<td >
													{{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}
													</td>
													<td >
														{{number_format($list->amount,2, '.', ',')}}
													</td>
													<td >
														{{$list->details}}
													</td>
													<td>
														<a class="btn btn-sm bg-success-light"
														href="javascript: editFunc('{{$list->id}}', '{{$list->amount}}', '{{$list->payment_date}}', '{{$list->details}}')">
															Process
														</a>
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
							<h5 class="modal-title">Confirm and Approve Payment</h5>
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
											<label>Amount</label>
											<input type="text" class="form-control" id="e-amount"  name="amount"
											readonly
											>
										</div>
									</div>
							    </div>
								
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Payment Date</label>
											<input type="date" class="form-control" id="e-paymentDate"  name="paymentDate" >
										</div>
									</div>
								</div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Banks</label>
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
											<label>Payment details</label>
											<input type="text" class="form-control" id="e-details"  name="details" readonly>
										</div>
									</div>
								</div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Remarks</label>
											<input type="text" class="form-control" id="e-remarks"  name="remarks" >
										</div>
									</div>
								</div>
								
								<input type="hidden" id="e-id" name="id" >
								<div class="form-content p-2">
									<button type="submit" class="btn btn-primary " name="update">Approve Now</button>
								</div>
								
								
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Edit Details Modal -->
@endsection
@section('scripts')
<script>

	const ValidateInput=(id)=>{
    document.getElementById(id).value = parseFloat(document.getElementById(id).value
		.toString().replace(/\,/g,'')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
   }
	const deleteRecord=(id)=>{
        document.getElementById('d-id').value = id;
        $("#delete_modal").modal('show')
    }
	const editFunc=(id,amount, paymentDate, details )=>{
        document.getElementById('e-id').value = id;
		document.getElementById('e-amount').value = amount;
		document.getElementById('e-paymentDate').value = paymentDate;
		document.getElementById('e-details').value = details;
        $("#edit_details").modal('show')
    }
	const Reload = (form)=>document.forms[form].submit();
</script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->