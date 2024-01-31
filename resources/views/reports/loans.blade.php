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
								<h3 class="page-title">Loan Report</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Loan Report</li>
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
									<form method="post" name="mainform" id="mainform">
                                    {{ csrf_field() }}
										<div class="row">
										    <div class="col-md-2">
											    <div class="form-group">
													<label>Status </label>
													
													<select class="select2 form-control" name="status" id="status" onchange= 'Reload("mainform");'>
														<option value="All" >--All--</option>
														@foreach($statuses as $list)
														<option value="{{$list->code}}" {{$status == (string) $list->code? 'selected':''}}>{{$list->status}} </option>
														@endforeach
													</select>
												</div>
											</div>
                                            <div class="col-md-4">
											    <div class="form-group">
												<label>Account Officer</label>
													<select class="select2 form-control" name="marketer" id="marketer" onchange= 'Reload("mainform");'>
														<option value="All" >--All--</option>
														@foreach($Marketer as $list)
														<option value="{{$list->id}}" {{((string) $list->id==$marketer)? 'selected':''}}>{{$list->name}}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="col-md-2">
											    <div class="form-group">
													<label>From</label>
													<input type="date"  value="{{$fromDate}}" name= "fromDate" class="form-control"   autocomplete="off" >
                                                   
												</div>
											</div>
											<div class="col-md-2">
											    <div class="form-group">
													<label>To</label>
													<input type="date"  value="{{$toDate}}" name= "toDate" class="form-control"   autocomplete="off" >
                                                   
												</div>
											</div>
											<div class="col-md-2">
											    <div class="form-group">
													<label>Overdue?</label>
													<select class="select2 form-control" name="defaulted" id="defaulted" onchange= 'Reload("mainform");'>
														<option value="NA" >--N/A--</option>
														<option value="YES" {{($defaulted=='YES')? 'selected':''}}>YES</option>
														<option value="NO" {{($defaulted=='NO')? 'selected':''}}>NO</option>
													</select>
                                                   
												</div>
											</div>
										</div>
										<div class="text-right">
											<button type="submit" class="btn btn-primary">Search</button>
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
									<h4 class="card-title">Loan Report</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th rowspan="1">S/N</th>													
													<th rowspan="1">Names</th>
													<th rowspan="1">Int. Cal.</th>
													<th rowspan="1">Principal</th>
													<th rowspan="1">Period(M)</th>
													<th rowspan="1">Loan Balance</th>
                                                    <th rowspan="1">Rate%</th>
                                                    <th rowspan="1">Interest</th>
													<th rowspan="1">Exp. Repayment</th>
													<th rowspan="1">Overdue</th>
													<th rowspan="1">Next due date</th>
													<th rowspan="1">Status</th>
													<th rowspan="1">Action</th>
												</tr>
											</thead>
											<tbody>
											    @php
													$sn=1;
													$amount=0;
													$amount_interest=0;
													$repaid=0;
													$balance=0;
													$defaulted=0;
												@endphp
											   @foreach($Loans as $list)
													@php
														$amount += $list['amount'];
														
														
														$balance += $list['balance'];
														$defaulted += $list['amount_outstanding'];
													@endphp
												<tr>
													<td >
														{{$sn++}}
													</td>
													<td >
													{{$list['first_name']}} {{$list['middle_name']}} {{$list['last_name']}}
													</td>
													<td >
													{{$list['particular']}} {{$list['balance']}}
													</td>
													<td style="text-align: right;">
													
														{{number_format($list['amount'],2, '.', ',')}}
													</td>
                                                    <td style="text-align: center;">
														{{$list['period']}}
													</td>
													<td style="text-align: right;">
														{{number_format($list['balance'],2, '.', ',')}}
													</td>
													<td style="text-align: center;">
													{{$list['percentage']}}
													</td>
													
                                                    <td style="text-align: right;">
													@if($list['loan_type_id']==2)
													{{number_format($list['total_interest']/$list['period'],2, '.', ',')}}
													  @php $amount_interest += $list['total_interest']/$list['period']; @endphp
													@else
														{{number_format($list['balance']*$list['percentage']*0.01,2, '.', ',')}}
														@php	$amount_interest += $list['balance']*$list['percentage']*0.01; @endphp
													@endif
													</td>
													<td style="text-align: right;">
													@if($list['balance']==0)
													0.00
													@else

													@if($list['loan_type_id']==2)
													{{number_format(($list['amount']/$list['period'])+($list['total_interest']/$list['period']),2, '.', ',')}}
													@php $repaid +=  ($list['amount']/$list['period'])+($list['total_interest']/$list['period']); @endphp
													@else
													{{number_format(($list['amount']/$list['period'])+($list['balance']*$list['percentage']*0.01),2, '.', ',')}}
													@php $repaid += ($list['amount']/$list['period'])+($list['balance']*$list['percentage']*0.01) ; @endphp
													@endif
													@endif
													</td>
													<td style="text-align: right;">
                                                        <span
														@if($list['amount_outstanding'] >0  )
														class="btn btn-sm bg-danger-light"
														@endif
														>
															{{number_format($list['amount_outstanding'],2, '.', ',')}}
														</span>
													</td>
													<td >
														{{date_format(date_create($list['next_due_date']),'d-m-Y')}}
													</td>
													
													<td style="text-align: right;">
													<span
														@if($list['status'] ==0  )
														class="btn btn-sm bg-warning"
														@endif

														@if($list['status'] ==1  )
														class="btn btn-sm bg-success-light"
														@endif

														@if($list['status'] ==2  )
														class="btn btn-sm bg-info"
														@endif

														@if($list['status'] ==3  )
														class="btn btn-sm bg-success"
														@endif
														

														@if($list['status'] ==9  )
														class="btn btn-sm bg-danger"
														@endif
														>
                                                        {{$list['statusText']}}
														</span>
													</td>
													<td>
														<a class="btn btn-sm bg-success-light"
														href="javascript: viewFunc('{{$list['id']}}')">
															view
														</a>
													</td>
												</tr>
												@endforeach
												<tr>
													<td colspan=3>
														Total
													</td>
													<td style="text-align: right;">
														{{number_format($amount,2, '.', ',')}}
													</td>
													<td >
														
													</td>
													<td style="text-align: right;">
														{{number_format($balance,2, '.', ',')}}
													</td>
													<td style="text-align: right;">
														
													</td>
													<td style="text-align: right;">
														{{number_format($amount_interest,2, '.', ',')}}
													</td>
													<td style="text-align: right;">
														{{number_format($repaid,2, '.', ',')}}
													</td>
													<td style="text-align: right;">
													<span
														@if($defaulted >0  )
														class="btn btn-sm bg-danger-light"
														@endif
														>
														{{number_format($defaulted,2, '.', ',')}}
													</span>
													</td>
													<td colspan = 2>
														
													</td>
												</tr>
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
            <form method="post"   action="/loan-details" id ="form-detail" >
                {{ csrf_field() }}
                <input type="hidden" id="detail-id" name="loan" >
            </form>
				
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
    const viewFunc =(id)=>{
        document.getElementById('detail-id').value = id;
        Reload('form-detail')
    }
	
	const Reload = (form)=>document.forms[form].submit();
</script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->