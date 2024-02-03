@extends('layouts.layout')
@section('pageTitle')
    Journal Transfer
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
            <li><a href="#">Journal Transfer</a></li>
         
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
	        
	            @foreach($AccountList as $list)
                <input type="hidden" id="id{{$list->id}}"  value="{{$list->id}}">
                <input type="hidden" id="acct{{$list->id}}"  value="({{$list->accountno}})">
                <input type="hidden" id="desc{{$list->id}}"  value="{{$list->accountdescription}}">
                @endforeach
                <form method="post">
                {{ csrf_field() }}
                    <div class="panel-body">
                       
                        <div class="table-responsive" style="font-size: 12px;">
<table class="table table-bordered table-striped table-highlight" >
		  	<tr>
				<th >Transaction Type</th> <th >Account</th><th >Debit Amount</th> <th >Credit Amount</th><th>Trans Date</th><th>Remarks</th><th>Action</th>
	 		</tr>
			<tr> 
			<td ><select id="transactiontype" name="transactiontype" style="width:150px;" class="form-control" onchange="TextBoxState()">
				<option value="">-Select-</option>
				@foreach($AccountTransType as $list)
                    <option value="{{ $list->transtype }}"  {{ (old('transactiontype') == $list->transtype ||($transactiontype) == $list->transtype  ) ? 'selected':'' }}>{{ $list->transtype }}</option>
                @endforeach
				</select>
			</td>
			<td ><?php if($acctids=='') $acctids= old('acctids'); ?>
			    <input type="hidden"  id="acctids" name="acctids"  value="{{$acctids}}">
			    <input type="text" list="refaccounts" name="refaccounts" id="refaccountids" @if($acctids!='')style="display:none" @endif style="width:200px;"  class="form-control"  placeholder="Select Account" onchange="fetchMains()" autocomplete="off">
                    <datalist id="refaccounts">
                        @foreach($AccountList as $list)
                        <option value="{{ $list->id }}:{{ $list->accountdescription }}({{ $list->accountno}})">{{ $list->accountdescription }}({{ $list->accountno}})</option>
                        @endforeach
        			</datalist>
        		<?php if($accountnames=='') $accountnames= old('accountnames'); ?>	
			    <div class="input-group" id="hiddenid" style="width:200px;"><input type="text" value="{{$accountnames}}" class="form-control" id="refaccountnames" readonly name="accountnames">
    			    <span class="input-group-btn">
                    <button type="button" class="btn btn-default" onclick="UnfetchMains()">X</button>
                    </span>
                </div>
			</td>
			<td >   @php 
			        $dbtstatus="2";
			        $crdtstatus="2";
			        if($transactiontype=='') $transactiontype= old('transactiontype');
			        if($transactiontype=="Credit") $dbtstatus="disabled";
        			if($transactiontype=="Debit") $crdtstatus="disabled";
			        @endphp
			    <div class="input-group"><span class="input-group-btn">
                <button type="button" class="btn btn-default" >N</button>
            </span><input type="text" id="debitamount" name="debitamount" value="{{$debitamount}}" class="form-control" style="width:150px;" {{$dbtstatus}}></div></td>
			<td ><div class="input-group"><span class="input-group-btn">
                <button type="button" class="btn btn-default" >N</button>
            </span><input type="text" id="creditamount" name="creditamount" value="{{$creditamount}}" class="form-control" style="width:150px;" {{$crdtstatus}}></div></td>
            <td><input type="date" name="transdate" value="{{$transdate}}"   class="form-control" style="width:150px;"></td>
             <td><input type="text" id="remarks" name="remarks" value="{{$remarks}}" class="form-control" style="width:250px;"></td>
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
					<td><input type="text" class="form-control"  value="{{  $data->account_details}}"  readonly></td>
					<td><input type="text" class="form-control"  value="{{  number_format($data->debit,2, '.', ',')}}"  readonly></td>
					<td><input type="text" class="form-control"  value="{{  number_format($data->credit,2, '.', ',')}}"  readonly></td>
					<td><input type="text" class="form-control"  value="{{  $data->transdate}}"  readonly></td>
					<td><input type="text" class="form-control"  value="{{  $data->remarks}}"  readonly></td>
					<td><a href="javascript: del('{{$data->id}}')"><i class="fa fa-minus-square" style="color:red"></i></a></td>
					</tr>
		@endforeach
			<tr> <td colspan=2>Total</td>
			<td><input type="text" class="form-control"  value="{{number_format($totaldebit,2, '.', ',')}}"  readonly style="width:150px;"></td>
			<td><input type="text" class="form-control"  value="{{number_format($totalcredit,2, '.', ',')}}"  readonly style="width:150px;"></td>
			<td ></td>
			<td ></td>
			<td>@if(($totaldebit==$totalcredit) && ($totaldebit >0))<button type="submit" class="btn btn-primary" name="post">Post</button> @endif</td>
			</tr>
				
			
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

    function editfunc(id,manu,brand)
    {
        document.getElementById('id').value = id;
        document.getElementById('manu').value = manu;
        document.getElementById('brand').value = brand;
        
        $("#editModal").modal('show')
    }
   function deletefunc(id)
    {
        document.getElementById('deleteid').value = id;
                     
        $("#deleteModal").modal('show')
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
    function fetchMains()
    {
        var txv=document.getElementById('refaccountids').value;
    	var tx = txv.split(':');
    	var id=tx[0];
    	//alert(id);
        //var id = document.getElementById('refaccountids').value;
        document.getElementById('acctids').value= id; 
        document.getElementById("refaccountids").style.display="none";
        document.getElementById('refaccountnames').value=document.getElementById('desc'+id).value +" "+ document.getElementById('acct'+id).value;
       // document.getElementById("hiddenid").style.display="block";
    }
    function UnfetchMains()
    {
        
        document.getElementById('acctids').value= '';
        document.getElementById('refaccountids').value= '';
        document.getElementById("refaccountids").style.display="block";
        document.getElementById('refaccountnames').value='';
       
    }
    function  TextBoxState()
    {	
    var Val=document.getElementById("transactiontype").value;
    
      if(Val=="Debit"){
        document.getElementById('debitamount').value="";
        document.getElementById('creditamount').value="";
        document.getElementById('debitamount').removeAttribute('disabled'); 
        document.getElementById('creditamount').setAttribute('disabled', 'disabled');
      }
      if(Val=="Credit"){
        document.getElementById('creditamount').removeAttribute('disabled'); 
        document.getElementById('debitamount').setAttribute('disabled', 'disabled');
        document.getElementById('debitamount').value="";
        document.getElementById('creditamount').value="";
      }
    return;
    }
        
</script>
@stop
