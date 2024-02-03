@extends('layouts.layout')
@section('pageTitle')
    Journal Validation
@endsection

@section('pageHead')
    <div id="page-head">

        <!--Page Title-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div id="page-title">
            <h1 class="page-header text-overflow">Transaction</h1>
        </div>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End page title-->


        <!--Breadcrumb-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <ol class="breadcrumb">
            <li><a href="/"><i class="demo-pli-home"></i></a></li>
            <li><a href="#">Journal Validation</a></li>
         
        </ol>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End breadcrumb-->

    </div>
@endsection
@section('content')

    <!--- content comes here -->

    <div class="boxed">

        <!--CONTENT CONTAINER-->
        <!--===================================================-->

    <div id="page-content">

        <div class="panel">
            <div class="panel-body">

                @if(session('message'))
	        <div class="alert alert-success alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
	          <strong>Successful!</strong> {{ session('message') }}</div>
	        @endif
	        @if(session('error_message'))
	        <div class="alert alert-danger alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
	          <strong>Error!</strong> {{ session('error_message') }}</div>
	        @endif
	        
		@if (count($errors) > 0)
	                    <div class="alert alert-danger alert-dismissible" role="alert">
	                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
	                        </button>
	                        <strong>Error!</strong> 
	                        @foreach ($errors->all() as $error)
	                            <p>{{ $error }}</p>
	                        @endforeach
	                    </div>
	        @endif
	        
                
                <form method="post" id="transdetails" name="transdetails">
                    <input type="hidden" name="ref" id="refid" >
                {{ csrf_field() }}
                    <div class="panel-body">
                       
<div class="table-responsive" style="font-size: 12px;">
<table class="table table-bordered table-striped table-highlight" >
		  	<tr>
				<th >Transaction Type</th> <th >Account</th><th >Debit </th> <th >Credit</th><th>Remarks</th><th>Action</th>
	 		</tr>
			 @php
		        $totaldebit =0;
			    $totalcredit =0 ;
			 @endphp
			 @foreach($SelectedJournalPending as $data)
			  @php
		        $totaldebit +=$data->debit;
			    $totalcredit +=$data->credit ;
			 @endphp
					<tr>
					<td><input type="text" class="form-control"  value="{{$data->transtype}}"  readonly></td>
					<td><input type="text" class="form-control"  value="{{  $data->account_details}}"  readonly></td>
					<td><input type="text" class="form-control"  value="{{  number_format($data->debit,2, '.', ',')}}"  readonly style="text-align: right; "></td>
					<td><input type="text" class="form-control"  value="{{  number_format($data->credit,2, '.', ',')}}"  readonly style="text-align: right; "></td>
					<td><input type="text" class="form-control"  value="{{  $data->remarks}}"  readonly></td>
					<td>
					
					</td>
					</tr>
		@endforeach
			<tr> <td>Total</td>
			<td >@if((number_format($totalcredit,2, '.', ',')==number_format($totaldebit,2, '.', ',')) && ($totaldebit >0))<b>Transaction Date:</b>{{ $data->transdate}} @endif</td>
			<td><input type="text" class="form-control"  value="{{number_format($totaldebit,2, '.', ',')}}"  readonly style="text-align: right; "></td>
			<td><input type="text" class="form-control"  value="{{number_format($totalcredit,2, '.', ',')}}"  readonly style="text-align: right; "></td>
			<td >@if((number_format($totalcredit,2, '.', ',')==number_format($totaldebit,2, '.', ',')) && ($totaldebit >0))<b>Ref No:</b>{{ $data->manual_ref}}  @endif </td>
			<?php $totalcredit= round($totalcredit,2) ; $totaldebit = round($totaldebit,2)?>
			<td colspan =2>@if(($totaldebit == $totalcredit) && ($totaldebit >0))<button type="submit" class="btn btn-primary" name="post">Post</button> @endif </td>
			</tr>
				
			
 </table>
</div>
<div class="table-responsive" style="font-size: 12px;">
<table class="table table-bordered table-striped table-highlight" >
		  	<tr>
				<th >Transaction Date</th> <th >Total Amount</th><th >PV/JV </th><th >Input by </th> <th>Action</th>
	 		</tr>
			 @foreach($UnpostedJournalPending as $data)
					<tr>
					<td>{{$data->transdate}}</td>
					<td>{{  number_format($data->t_val,2, '.', ',')}}  </td>
					<td>{{  $data->manual_ref}}</td>
					<td>{{  $data->name}}</td>
					
					<td><a onclick="TransactionDetail('{{$data->ref}}')" class="btn btn-success">View</a>
					</td>
					</tr>
		@endforeach
			
				
			
 </table>
</div>
                    </div>
                </form>
                <!--===================================================-->
                <!-- End Inline Form  -->
            </div>
        </div>
    
    
    </div>
        
        </div>
    

@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<style>
label {
  color: black
  text-shadow: 1px 1px 2px #fff;
}
</style>
@stop
@section('scripts')

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script>

   function deletefunc(id)
    {
        document.getElementById('delid').value = id;
        document.forms["mainform"].submit();
	   return;            
    }
    function  TransactionDetail(ref){	
    document.getElementById('refid').value = ref;
    document.forms["transdetails"].submit();
    
}
    
    function fetchMain()
    {
      var txv=document.getElementById('refaccountid').value;
    	var tx = txv.split(':');
    	var id=tx[0];
        //var id = document.getElementById('refaccountid').value;
         
        document.getElementById('acctid').value= id; 
        
        document.getElementById('refaccountname').value=document.getElementById('desc'+id).value +" "+ document.getElementById('acct'+id).value;
    }
    
   
    
        
</script>
@stop
