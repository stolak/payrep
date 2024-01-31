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
								<h3 class="page-title">Loan Request</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Loan Request</li>
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
									<h4 class="card-title">Request Form</h4>
								</div>
								<div class="card-body">
									<form method="post" name="mainform" id="mainform">
                                    {{ csrf_field() }}
										<div class="row">
										    <div class="col-md-5">
											    <div class="form-group">
													<label>Customer</label>
													<select class="select2 form-control" name="customer" id="customer"  onchange= 'Reload("mainform");'>
														<option value="All" >--Select--</option>
														@foreach($customers as $list)
														<option value="{{$list->id}}" {{$customer==$list->id? 'selected':''}}>{{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="col-md-3">
											    <div class="form-group">
													<label>Calculator</label>
													<select class="select2 form-control" name="calculator" id="calculator"
													onchange =  'doAfterSelection("amount","rate","period","interest","monthlyRepayment","totalRepayment");'
													>
														@foreach($calculators as $list)
														<option value="{{$list->id}}" >{{$list->particular}}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="col-md-4">
											    <div class="form-group">
													<label>Account Officer</label>
													<select class="select2 form-control" name="marketer" id="marketer">
														<option value="" >--Select--</option>
														@foreach($Marketers as $list)
														<option value="{{$list->id}}" >{{$list->name}}</option>
														@endforeach
													</select>
												</div>
											</div>
										</div>
										<div class="row">
										    <div class="col-md-2">
												<div class="form-group">
													<label>Amount</label>
													<div class="input-group">
                                                        <input type="text" id="amount" name="amount"
														value="{{$amount}}" class="form-control"
														style="text-align: right;"  autocomplete="off"
														onblur='ValidateInput("amount"); doAfterSelection("amount","rate","period","interest","monthlyRepayment","totalRepayment");'
														>
                                                    </div>
												</div>
											</div>
											<div class="col-md-2">
											    <div class="form-group">
													<label>Repayment Period</label>
													<select class="select2 form-control" name="period" id="period"
													onchange =  'doAfterSelection("amount","rate","period","interest","monthlyRepayment","totalRepayment");'
													>
														<option value="" >--Select--</option>
														@for ($i = 1; $i <= 24; $i++)
														<option value="{{$i}}" {{ ($period==$i)? 'selected':''}}>{{$i}} month{{$i>1? 's':''}}</option>
														@endfor
													</select>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>Rate%</label>
													<div class="input-group">
                                                        <input type="text" id="rate" name="rate" value="{{$rate}}" class="form-control" style="text-align: right;" readonly>
                                                    </div>
												</div>
											</div>
											<div class="col-md-2">
											    <div class="form-group">
													<label>Interest</label>
													<div class="input-group">
                                                        <input type="text" id="interest" name="interest" value="{{$interest}}" class="form-control" style="text-align: left;"  autocomplete="off" readonly>
                                                    </div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>Monthly Repayment</label>
													<div class="input-group">
                                                        <input type="text" id="monthlyRepayment" name="monthlyRepayment" value="{{$monthlyRepayment}}" class="form-control" style="text-align: left;"  autocomplete="off" readonly>
                                                    </div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>Total Repayment</label>
													<div class="input-group">
                                                        <input type="text" id="totalRepayment"  value="{{$totalRepayment}}" class="form-control" style="text-align: left;"  autocomplete="off" readonly>
                                                    </div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Remarks</label>
													<div class="input-group">
                                                        <input type="text" id="remarks" name="remarks" value="{{$remarks}}" class="form-control" style="text-align: left;"  autocomplete="off">
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
									<h4 class="card-title"> Loans</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th rowspan="1">S/N</th>													
													<th rowspan="1">Names</th>
													<th rowspan="1">Amount</th>
													<th rowspan="1">Period </th>
													<th rowspan="1">Rate</th>
													<th rowspan="1">Total Interest</th>
													<th rowspan="1">Monthly Repayment</th>
													<th rowspan="1">Total Repayment</th>
													<th rowspan="1">Remarks</th>
													<th rowspan="1">Account Officer</th>
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
													{{number_format($list->amount,2, '.', ',')}}
													</td>
													<td >
													{{$list->period}}
													</td>
													<td >
													{{$list->percentage}}
													</td>
													<td >
													{{number_format($list->total_interest,2, '.', ',')}}
													</td>
													<td >
													{{number_format($list->monthly_repayment,2, '.', ',')}}
													</td>
													<td >
													{{number_format($list->total_repayment,2, '.', ',')	}}
													</td>
													<td >
														{{$list->remarks}}
													</td>
													<td >
														{{$list->name}}
													</td>
													<td>
														<a class="btn btn-sm bg-success-light" href="javascript: editFunc('{{$list->id}}', '{{$list->customer_id}}', '{{$list->marketer_id}}', '{{$list->amount}}', '{{$list->period}}', '{{$list->percentage}}', '{{$list->total_interest}}', '{{$list->total_repayment}}', '{{$list->monthly_repayment}}')">
															<i class="fe fe-pencil"></i>
														</a>
														<a  class="btn btn-sm bg-danger-light" href="javascript: deleteRecord('{{$list->id}}')">
															<i class="fe fe-trash"></i>
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
							<h5 class="modal-title">Edit Details</h5>
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
											<select class="form-control" name="customer" id="e-customer">
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
											<label>Account Officer</label>
											<select class="form-control" name="marketer" id="e-marketer">
												@foreach($Marketers as $list)
												<option value="{{$list->id}}" >{{$list->name}}</option>
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
											onblur='ValidateInput("e-amount"); doAfterSelection("e-amount","e-rate","e-period","e-interest","e-monthlyRepayment","e-totalRepayment");'
											>
										</div>
									</div>
							    </div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Period</label>
											<select class="form-control" name="period" id="e-period" onchange = 'doAfterSelection("e-amount","e-rate","e-period","e-interest","e-monthlyRepayment","e-totalRepayment")'>
												<option value="" >--Select--</option>
												@for ($i = 1; $i <= 24; $i++)
												<option value="{{$i}}" >{{$i}} month{{$i>1? 's':''}}</option>
												@endfor
											</select>
										</div>
									</div>
							    </div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Rate</label>
											<input type="text" class="form-control" id="e-rate"  name="rate" readonly>
										</div>
									</div>
								</div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Interest</label>
											<input type="text" class="form-control" id="e-interest"  name="interest" readonly>
										</div>
									</div>
								</div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Total Repayment</label>
											<input type="text" class="form-control" id="e-totalRepayment"  name="totalRepayment" readonly>
										</div>
									</div>
								</div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Monthly Repayment</label>
											<input type="text" class="form-control" id="e-monthlyRepayment"  name="monthlyRepayment" readonly>
										</div>
									</div>
								</div>
								<input type="hidden" id="e-id" name="id" >
								<div class="form-content p-2">
									<button type="submit" class="btn btn-primary " name="update">Save Changes</button>
									<button type="submit" class="btn btn-primary " name="submit">Submit</button>
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
	const doAfterSelection=(famount,frate,fperiod,finterest,fmonthlyRepayment,ftotalRepayment)=>{
		const amount = parseFloat(document.getElementById(famount).value.replace(/,/g, ''));
		const rate = document.getElementById(frate).value*0.01;
		const period = document.getElementById(fperiod).value;
		const calculator = document.getElementById('calculator').value;
			let totalRepayment;
			let totalInterest;
			let interest;
			let monthlyRepayment;
		if(calculator==2){
			console.log('strayyy');
			totalRepayment = amount* (Math.pow((1 + (rate/12) ), period));
			totalInterest = totalRepayment - amount;
			interest = totalInterest/period;
			monthlyRepayment = totalRepayment/period;
		}else{
			console.log('reducing');
			interest = amount *rate;
			monthlyp= amount/period;
			let virtualAmount= amount;
			totalInterest = 0;
			for(let i=1; i<=period; i++){
				totalInterest += virtualAmount*rate;
				virtualAmount -= monthlyp;
				console.log(i, totalInterest, monthlyp);
			}
			monthlyRepayment=monthlyp+interest;
			totalRepayment =amount + totalInterest;
		}
		document.getElementById(finterest).value = formatValue(interest);
		document.getElementById(fmonthlyRepayment).value =formatValue(monthlyRepayment);
		document.getElementById(ftotalRepayment).value =formatValue(totalRepayment);
	}
	const ValidateInput=(id)=>{
    document.getElementById(id).value = formatValue(document.getElementById(id).value);
   }

   const formatValue=(val)=>{
    return parseFloat(val
		.toString().replace(/\,/g,'')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
   }
	const deleteRecord=(id)=>{
        document.getElementById('d-id').value = id;
        $("#delete_modal").modal('show')
    }
	const editFunc=(id,customer, marketer, amount, period, rate, interest, totalRepayment, monthlyRepayment )=>{
        document.getElementById('e-id').value = id;
		document.getElementById('e-customer').value = customer;
		document.getElementById('e-marketer').value = marketer;
		document.getElementById('e-amount').value = formatValue(amount);
		document.getElementById('e-period').value = period;
		document.getElementById('e-rate').value = rate;
		document.getElementById('e-interest').value = formatValue(interest);
		document.getElementById('e-totalRepayment').value = formatValue(totalRepayment);
		document.getElementById('e-monthlyRepayment').value = formatValue(monthlyRepayment);
        $("#edit_details").modal('show')
    }
	const Reload = (form)=>document.forms[form].submit();
</script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->