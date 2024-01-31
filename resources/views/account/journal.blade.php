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
								
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Journal Transfer</li>
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
									<h4 class="card-title">Journal Transfer</h4>
								</div>
								<div class="card-body">
									<form method="post" name="mainform" id="mainform">
                                    {{ csrf_field() }}
									<div class="table-responsive" style="font-size: 12px;">
										<table class="table table-bordered table-striped table-highlight" >
											<tr>
												<th >Transaction Type</th> <th >Account</th><th >Debit </th> <th >Credit</th><th>Remarks</th><th>Action</th>
											</tr>
											<tr> 
											<td ><select id="transactiontype" name="transactiontype" style="width:150px;" class="form-control" onchange="TextBoxState()">
												<option value="">-Select-</option>
												@foreach($AccountTransType as $list)
													<option value="{{ $list->transtype }}"  {{ (old('transactiontype') == $list->transtype ||($transactiontype) == $list->transtype  ) ? 'selected':'' }}>{{ $list->transtype }}</option>
												@endforeach
												</select>
											</td>
											<td >
											<select class="select2 form-control" name="accountNumber" id="accountNumber"
											style="width:200px;>
												<option value="" >--Select--</option>
												@foreach($AccountList as $list)
												<option value="{{$list->id}}" {{$accountNumber==$list->id? 'selected':''}}>{{$list->accountdescription}}</option>
												@endforeach
											</select>
											
											</td>
											<td >   @php
													$dbtstatus='';
													$crdtstatus="";
													if($transactiontype=='') $transactiontype= old('transactiontype');
													if($transactiontype=="Credit") $dbtstatus="disabled";
													if($transactiontype=="Debit") $crdtstatus="disabled";
													@endphp
												
												<?php if($debitamount=='') $debitamount= old('debitamount'); ?>
											<input type="text" id="debitamount" name="debitamount" value="{{$debitamount}}" class="form-control" style="width:150px; text-align: right;" {{$dbtstatus}} autocomplete="off"></td>
											<td >
												<?php if($creditamount=='') $creditamount= old('creditamount'); ?>
											<input type="text" id="creditamount" name="creditamount" value="{{$creditamount}}" class="form-control" style="width:150px; text-align: right;" {{$crdtstatus}} autocomplete="off"></td>
											<?php if($remarks=='') $remarks= old('remarks'); ?>
											<td><input type="text" id="remarks" name="remarks" value="{{$remarks}}" class="form-control" style="width:250px;" autocomplete="off"></td>
											<td ><button type="submit" class="btn btn-primary" name="add">Add</button></td>
											</tr>
											@php
												$totaldebit =0;
												$totalcredit =0 ;
											@endphp
											@foreach($JournalPending as $data)
											@php
												$totaldebit +=$data->debit;
												$totalcredit +=$data->credit ;
											@endphp
											
											<tr>
												<td><input type="text" class="form-control"  value="{{$data->transtype}}"  readonly></td>
												<td><input type="text" class="form-control"  value="{{  $data->accountdescription}}"  readonly></td>
												<td><input type="text" class="form-control"  value="{{  number_format($data->debit,2, '.', ',')}}"  readonly style="text-align: right; "></td>
												<td><input type="text" class="form-control"  value="{{  number_format($data->credit,2, '.', ',')}}"  readonly style="text-align: right; "></td>
												
												<td><input type="text" class="form-control"  value="{{  $data->remarks}}"  readonly></td>
												<td>
												<a href="javascript: deleteRecord('{{$data->id}}')"><i class="fa fa-minus-square" style="color:red"></i></a>
												</td>
											</tr>
												@endforeach
											<tr> <td>Total</td>
												<td >@if((number_format($totalcredit,2, '.', ',')==number_format($totaldebit,2, '.', ',')) && ($totaldebit >0))<b>Transaction Date:</b><input type="date" name="transdate" value="{{$transdate}}"   class="form-control" style="width:150px;"> @endif</td>
												<td><input type="text" class="form-control"  value="{{number_format($totaldebit,2, '.', ',')}}"  readonly style="text-align: right; "></td>
												<td><input type="text" class="form-control"  value="{{number_format($totalcredit,2, '.', ',')}}"  readonly style="text-align: right; "></td>
												<td >@if((number_format($totalcredit,2, '.', ',')==number_format($totaldebit,2, '.', ',')) && ($totaldebit >0))<b>Ref No:</b><input type="text" id="manual_ref" name="manual_ref" value="{{$manual_ref}}" class="form-control" style="width:250px;" autocomplete="off"> @endif </td>
												<?php $totalcredit= round($totalcredit,2) ; $totaldebit = round($totaldebit,2)?>
												<td colspan =2>@if(($totaldebit == $totalcredit) && ($totaldebit >0))<button type="submit" class="btn btn-primary" name="post">Post</button> @endif </td>
											</tr>
										</table>
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
								<input type="hidden" id="d-id" name="delid" >
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
			<!-- /Delete Modal -->
		
			</div>
			
			<!-- /Edit Details Modal -->
@endsection
@section('scripts')
<script>
	
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
	
	const Reload = (form)=>document.forms[form].submit();

	function  TextBoxState()
    {
    var Val=document.getElementById("transactiontype").value;
    
       if(Val=="Debit"){
        document.getElementById('debitamount').value="{{$drbal}}";
        document.getElementById('creditamount').value="";
        document.getElementById('debitamount').removeAttribute('disabled');
        document.getElementById('creditamount').setAttribute('disabled', 'disabled');
      }
      if(Val=="Credit"){
        document.getElementById('creditamount').removeAttribute('disabled');
        document.getElementById('debitamount').setAttribute('disabled', 'disabled');
        document.getElementById('debitamount').value="";
        document.getElementById('creditamount').value="{{$crbal}}";
      }
      document.getElementById('remarks').value="{{$defaultremark}}"
    return;
    }
        
</script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->