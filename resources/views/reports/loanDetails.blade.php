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
								<h3 class="page-title">Loan Details</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Loan Details</li>
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
								@if($Loan)
									<div class="text-right">
										<a  class="btn btn-danger" href="#" target="_blank">{{$Loan['statusText']}} </a>
									</div>
									@endif
								</div>
								
								<div class="card-body">
									<form method="post" name="mainform" id="mainform">
                                    {{ csrf_field() }}
										<div class="row">
										    <div class="col-md-2">
											    <div class="form-group">
													<label>Status</label>
													<select class="select2 form-control" name="status" id="status" onchange= 'Reload("mainform");'>
														<option value="All" >--All--</option>
														@foreach($statuses as $list)
														<option value="{{$list->code}}" {{$status==(string)$list->code? 'selected':''}}>{{$list->status}} </option>
														@endforeach
													</select>
												</div>
											</div>
                                            <div class="col-md-4">
											    <div class="form-group">
													<label>Loan Particular</label>
													<select class="select2 form-control" name="loan" id="loan" onchange= 'Reload("mainform");'>
														<option value="All" >--Select--</option>
														@foreach($Loans as $list)
														<option value="{{$list->id}}" {{$loan==$list->id? 'selected':''}}>{{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="col-md-3">
											    <div class="form-group">
													<label>Account Officer</label>
													<input type="text"  value="{{$Loan['marketer']??''}}" class="form-control"   autocomplete="off" disabled>
                                                   
												</div>
											</div>
											<div class="col-md-3">
											    <div class="form-group">
													<label>Calculator</label>
													<input type="text"  value="{{$Loan['particular']??''}}" class="form-control"   autocomplete="off" disabled>
                                                   
												</div>
											</div>
										</div>
										<div class="row">
										    <div class="col-md-2">
												<div class="form-group">
													<label>Principal</label>
													<div class="input-group">
                                                        <input type="text"
														value="{{number_format($Loan['amount_approved']??0,2, '.', ',')}}" class="form-control"
														style="text-align: right;"
                                                        disabled
														>
                                                    </div>
												</div>
											</div>
											
											<div class="col-md-2">
											    <div class="form-group">
													<label>Period</label>
													<input type="text"
                                                    value="{{$Loan['period']??''}}-month{{$Loan['period']??0>1? 's':'' }}"
                                                    class="form-control"
                                                    readonly>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>Rate</label>
                                                    <input type="text"
                                                    value="{{$Loan['percentage']??''}}" class="form-control"  readonly>
                                                </div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>Balance</label>
													<div class="input-group">
                                                        <input type="text"
                                                        value="{{number_format($Loan['balance']??0,2, '.', ',')}}"
                                                        class="form-control" style="text-align: right;" disabled>
                                                    </div>
												</div>
											</div>
											<div class="col-md-2">
											    <div class="form-group">
												
													<label>Next Interest</label>
													@if($Loan)
														@if($Loan['loan_type_id']==2)
															@php 
															$interest1= $Loan['total_interest']/$Loan['period']; 
															$interest= number_format($interest1,2, '.', ',');
															@endphp
														@else
															@php
															$interest1 = $Loan['balance']*$Loan['percentage']*0.01;
															if($Loan['status']==0 || $Loan['status']==1)$interest1 = $Loan['amount_approved']*$Loan['percentage']*0.01;
															$interest = number_format($interest1,2, '.', ',');
															@endphp
														@endif
													@endif
													<div class="input-group">
                                                        <input type="text"
                                                        value="{{$interest??0}}"
                                                         class="form-control" style="text-align: right;"  readonly>
                                                    </div>
												</div>
											</div>
                                            <div class="col-md-2">
												<div class="form-group">
													<label>Next Repayment</label>
													@if($Loan)
													@if($Loan['balance']>0)
														@if($Loan['loan_type_id']==2)
															@php $next_repayment= number_format(($Loan['amount']/$Loan['period'])+($Loan['total_interest']/$Loan['period']),2, '.', ','); @endphp
														@else
															@php $next_repayment= number_format(($Loan['amount']/$Loan['period'])+($Loan['balance']*$Loan['percentage']*0.01),2, '.', ','); @endphp
														@endif
													@else
													@php $next_repayment=0; @endphp
													@endif
													@endif
													<div class="input-group">
                                                        <input type="text"
                                                        value="{{$next_repayment??0}}"
                                                        class="form-control" style="text-align: right;" disabled>
                                                    </div>
												</div>
											</div>
											
											
										</div>
										@php
										
										if(($Loan['status']??'')==1){
										$stage_text='';
										}
										else{
										$stage_text = $Loan['stage_text']??'';
										}
								
										
										@endphp
                                        <div class="row">
										    <div class="col-md-4">
												<div class="form-group">
													<label>Approver</label>
													<div class="input-group">
                                                        <input type="text"
														value="{{$Loan['approver']?? $stage_text}}"
                                                        class="form-control"
                                                        disabled
														>
                                                    </div>
												</div>
											</div>
											<div class="col-md-2">
											    <div class="form-group">
													<label>Approval Date</label>
													<input type="text"
													
                                                    value="{{($Loan['status']??0>0)? date_format(date_create($Loan['approval_date']??''),'d-m-Y'):'Pending'}}"
                                                    class="form-control"
                                                    readonly>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>Disbursed Date</label>
                                                    <input type="text"
                                                    value="{{ (($Loan['status']??0) > 1 )? date_format(date_create($Loan['disbursed_date']??''),'d-m-Y'):'Pending'}}" class="form-control"  readonly>
                                                </div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>Next Due</label>
                                                    <input type="text"
                                                    value="{{(($Loan['status']??0) >1)?date_format(date_create($Loan['next_due_date']??''),'d-m-Y'):'Pending'}}" class="form-control"  readonly>
                                                </div>
											</div>
											
                                            <div class="col-md-2">
												<div class="form-group">
													<label>Overdue</label>
													<div class="input-group">
                                                        <input type="text"
                                                        value="{{number_format($Loan['amount_outstanding']??0,2, '.', ',')}}"
                                                        class="form-control" style="text-align: right;" disabled>
                                                    </div>
												</div>
											</div>
											
											
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Remarks</label>
													<div class="input-group">
                                                        <input
                                                            type="text"
                                                            value="{{$Loan['remarks']??''}}" class="form-control"
                                                            disabled>
                                                    </div>
												</div>
											</div>
										</div>
										<div class="row">
						<div class="col-md-12">
							<div class="card card-table">
								<div class="card-header">
									<h4 class="card-title">File Attachement</h4>
								</div>
							</div>
							@foreach($documents as $doc)
							<a href="{{$doc->url}}">
								<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16">
								<path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
								<path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
								</svg>{{$doc->description}}
							</a>

							@endforeach
						</div>
					</div>
										<div class="text-center">
											<button type="button" class="btn btn-secondary" onclick ="Comment()">View comments</button>
											@if($Loan['amount_outstanding']??0>0)
											<button type="button" class="btn btn-danger" onclick ="Charge()">Charge Now</button>
											@endif
											@if($Loan['status']??0==2)
												<button type="button" class="btn btn-secondary" onclick ="Liquidate()">Liquidate</button>
												<button type="button" class="btn btn-secondary" onclick ="PauseInterest({{$loan??0}})">Pause Interest</button>
											@endif
											<button type="button" class="btn btn-secondary" onclick ="Upload()">Upload</button>
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
									<h4 class="card-title">Transaction History</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th rowspan="1">S/N</th>													
													<th rowspan="1">Date</th>
													<th rowspan="1">Debit</th>
                                                    <th rowspan="1">Credit</th>
													<th rowspan="1">Balance </th>
													<th rowspan="1">Remarks</th>
												</tr>
											</thead>
											<tbody>
											    @php 
                                                $sn=1;
                                                $balance=0;
                                                @endphp
											   @foreach($Transactions as $list)
                                               @php 
                                                $balance+= $list->debit-$list->credit;
                                                @endphp
												<tr>
													<td >
														{{$sn++}}
													</td>
													<td >
													{{date_format(date_create($list->transaction_date??''),'d-m-Y')}}
													</td>
													<td >
													{{number_format($list->debit,2, '.', ',')}}
													</td>
													<td >
													{{number_format($list->credit,2, '.', ',')}}
													</td>
													<td >
													{{number_format($balance,2, '.', ',')}}
													</td>
                                                    <td >
														{{$list->remarks}}
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
						<!-- Edit Details Modal -->
						<div class="modal fade" id="liquidate" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Loan Liquidation</h5>
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
											<label>Balance</label>
											<input type="text" class="form-control"
											value="{{number_format($Loan['balance']??0,2, '.', ',')}}"
											readonly disabled
											>
										</div>
									</div>
							    </div>
								
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Next Due date</label>
											<input type="text" class="form-control"
											value="{{date_format(date_create($Loan['next_due_date']??''),'d-m-Y')}}" 
											readonly disabled
											>
										</div>
									</div>
							    </div>
								
								
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Transaction Date</label>
											<input type="date" class="form-control" name="applyDate" id='applyDate' onblur='amountCharge()'
											value="{{date('Y-m-d')}}"
											>
										</div>
									</div>
							    </div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Calulator</label>
											<select class="form-control" name="liquidator" id="e-liquidator"
											onchange = 'amountCharge()'
												>
												@foreach($liquidators as $list)
												<option value="{{$list->id}}" >{{$list->particular}}</option>
												@endforeach
											</select>
										</div>
									</div>
							    </div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Applicable Interest/charges	</label>
											<input type="text" class="form-control"  name="interest" id="e-interest"
											onblur='ValidateInput("e-interest");finalAmountCharge()'
											>
										</div>
									</div>
							    </div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Final Payment	</label>
											<input type="text" class="form-control"  id="f-amount"
											readonly
											>
										</div>
									</div>
							    </div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Remarks</label>
											<input type="text" class="form-control"   name="remarks">
										</div>
									</div>
								</div>
								
								<input type="hidden" name="loan" value="{{$Loan['id']??0}}" >
								<button type="submit" class="btn btn-primary" name="liquidate">Submit</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Edit Details Modal -->
				<!-- Edit Details Modal -->
				<div class="modal fade" id="edit_details" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Defauting charges</h5>
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
											<label>Amount Overdue</label>
											<input type="text" class="form-control"
											value="{{number_format($Loan['amount_outstanding']??0,2, '.', ',')}}"
											readonly disabled
											>
										</div>
									</div>
							    </div>
								
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Percentage Applied</label>
											<input type="text" class="form-control"  name="rate" id="c-rate" value="{{$percentage}}"
											onblur='chargesCal();'
											>
										</div>
									</div>
							    </div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Defaulting Charge</label>
											<input type="text" class="form-control"  name="amount" id="c-amount"
											readonly
											>
										</div>
									</div>
							    </div>
								
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Date Applied</label>
											<input type="date" class="form-control" name="applyDate">
										</div>
									</div>
							    </div>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Remarks</label>
											<input type="text" class="form-control"   name="remarks">
										</div>
									</div>
								</div>
								
								<input type="hidden" name="id" value="{{$Loan['id']??0}}" >
								<button type="submit" class="btn btn-primary" name="default">Submit</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Edit Details Modal -->

			<!-- Upload Modal -->
			<div class="modal fade" id="upload" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Attachment</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
							    
								
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>File Description</label>
											<input type="text" class="form-control"  name="description" >
										</div>
									</div>
							    </div>
								
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>File</label>
											<input type="file" class="form-control" name="document">
										</div>
									</div>
							    </div>
								<input type="hidden" name="loan" value="{{$Loan['id']??0}}" >
								<input type="hidden" name="id" value="{{$Loan['id']??0}}" >
								<button type="submit" class="btn btn-primary" name="upload">Continue</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Upload Modal -->
	<!-- Comment Modal -->
	<div class="modal fade" id="comment_details" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Remarks/comment</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						@foreach($notes as $list)
						<div class="modal-body">
							<h5>Comment by {{$list->name}}</h5>
							<p>{{$list->notes}}</p>
							<code>{{date_format(date_create($list->created_at),'h:i:s d-m-Y')}}</code>
							<hr>
						</div>
						@endforeach
						
					</div>
				</div>
			</div>
			<!-- /Edit Details Modal -->
			<!-- Delete Modal -->
			<div class="modal fade" id="pause_modal" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<form method="post" >
                                    {{ csrf_field() }}
						<div class="modal-body">
							<div class="form-content p-2">
								<h4 class="modal-title">Pause Interest</h4>
								<p class="mb-4">Are you sure want to pause this loan from charging subsequent interest?</p>
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>Remarks</label>
											<input type="text" class="form-control"   name="remarks">
										</div>
									</div>
								</div>
								<button type="submit" class="btn btn-primary" name="pause">Continue </button>
								<input type="hidden"  name="loan"  value="{{$Loan['id']??0}}">
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
const Charge=()=>{
	chargesCal();
        $("#edit_details").modal('show')
    }
const Upload=()=>{
       
	   $("#upload").modal('show')
   }
   const chargesCal=()=>{
	const charge= {{$Loan['amount_outstanding']??0}} * 0.01 * document.getElementById('c-rate').value;
	document.getElementById('c-amount').value = formatValue(charge);
	   
   }
	const Liquidate=()=>{
       
	   $("#liquidate").modal('show')
   }
const Comment=()=>{
       
	   $("#comment_details").modal('show')
   }

   const ValidateInput=(id)=>{
    document.getElementById(id).value = formatValue(document.getElementById(id).value);
   }
   const PauseInterest=()=>{
        $("#pause_modal").modal('show')
    }
   const formatValue=(val)=>{
    return parseFloat(val
		.toString().replace(/\,/g,'')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
   }

   const days = (d1, d2) =>{
	const date_1 = new Date(d1)
	const date_2 = new Date(d2)
    let difference = date_1.getTime() - date_2.getTime();
    let TotalDays = Math.ceil(difference / (1000 * 3600 * 24));
    return TotalDays;
}

const amountCharge = () =>{
	let interest
	if(document.getElementById('e-liquidator').value==2) {
		interest = {{$interest1??0}};
	} else {
		let transactionDate= document.getElementById('applyDate').value;
	 	let daysConsidered= days(transactionDate,'{{$prevCycle}}');
		interest = {{$interest1??0}}*daysConsidered/30;
	}
	document.getElementById('e-interest').value = formatValue(interest);
	finalAmountCharge();

}
const finalAmountCharge = () =>{
	
	const amount = parseFloat(document.getElementById('e-interest').value.replace(/,/g, ''));
	const famount=amount+{{$Loan['balance']??0}}
	document.getElementById('f-amount').value=formatValue(famount);
}
amountCharge();
</script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->