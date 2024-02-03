@extends('layouts.layout')
@section('pageTitle')
    Sub-Account
@endsection

@section('pageHead')
    <div id="page-head">

        <!--Page Title-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div id="page-title">
            <h1 class="page-header text-overflow">Setup</h1>
        </div>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End page title-->


        <!--Breadcrumb-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <ol class="breadcrumb">
            <li><a href="/"><i class="demo-pli-home"></i></a></li>
            <li><a href="#">Sub-account Setup</a></li>
         
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
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Reference Account:</label>
                                    <input type="hidden"  id="acctid" name="acctid"  value="{{$acctid}}">
                                    <input type="text" list="refaccount" name="refaccount" id="refaccountid"  class="form-control" autocomplete="off"  placeholder="Select Account" onchange="fetchMain()">
                                    <datalist id="refaccount">
                                        @foreach($AccountList as $list)
                                        <option value="{{ $list->id }}">{{ $list->accountdescription }}({{ $list->accountno}})</option>
                                        @endforeach
                        			</datalist>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label >Account Name:</label> 
                                    <input type="text"  value="{{$accountname}}" class="form-control" id="refaccountname" readonly>
                                </div>
                            </div>
                            </div>
                        <div class="table-responsive" style="font-size: 12px;">
                            <table class="table table-bordered table-striped table-highlight" >
                		  	<tr>
                				<th >Module</th> <th >Account</th><th >Deposit</th> <th >Payment</th><th>Trans Date</th><th>Remarks</th><th>Action</th>
                	 		</tr>
                			<tr> 
                			<td ><select id="transactiontype" name="transactiontype" style="width:150px;" class="form-control" onchange="TextBoxState()">
                				<option value="">-Select-</option>
                				    @foreach($BatchModule as $list)
                                    <option value="{{ $list->batch_module }}" {{ (old('transactiontype') == $list->batch_module ||($transactiontype) == $list->batch_module  ) ? 'selected':'' }}>{{ $list->batch_module }}</option>
                                    @endforeach
                				</select>
                			</td>
                			<td >
                			    <?php if($acctids=='') $acctids= old('acctids'); ?>
                			    <input type="hidden"  id="acctids" name="acctids"  value="{{$acctids}}">
                			    <input type="text" list="refaccounts" name="refaccounts" id="refaccountids" @if($acctids!='')style="display:none" @endif style="width:200px;"  class="form-control"  placeholder="Select Account" onchange="fetchMains()" autocomplete="off">
                                    <datalist id="refaccounts">
                                        @foreach($AccountList as $list)
                                        <option value="{{ $list->id }}">{{ $list->accountdescription }}({{ $list->accountno}})</option>
                                        @endforeach
                        			</datalist>
                        		<?php if($accountnames=='') $accountnames= old('accountnames'); ?>	
                			    <div class="input-group" id="hiddenid" style="width:200px;"><input type="text" value="{{$accountnames}}" class="form-control" id="refaccountnames" readonly name="accountnames">
                    			    <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" onclick="UnfetchMains()">X</button>
                                    </span>
                                </div>
                                
                                    
                			</td>
                			<td><?php if($debitamount=='') $debitamount= old('debitamount'); ?>
                			    <div class="input-group"><span class="input-group-btn">
                                <button type="button" class="btn btn-default" >N</button>
                            </span><input type="text" id="debitamount" name="debitamount" value="{{$debitamount}}" class="form-control" style="width:150px;" autocomplete="off"></div></td>
                			<td ><?php if($creditamount=='') $creditamount= old('creditamount'); ?>
                			<div class="input-group"><span class="input-group-btn">
                                <button type="button" class="btn btn-default" >N</button>
                            </span><input type="text" id="creditamount" name="creditamount" value="{{$creditamount}}" class="form-control" style="width:150px;" autocomplete="off"></div></td>
                            <td>
                                <?php if($transdate=='') $transdate= old('transdate'); ?>
                                <input type="date" name="transdate" value="{{$transdate}}"   class="form-control" style="width:150px;"></td>
                            <td>
                                <?php if($remarks=='') $remarks= old('remarks'); ?>
                                <input type="text" id="remarks" name="remarks" value="{{$remarks}}" class="form-control" style="width:250px;" autocomplete="off"></td>
                			<td ><button type="submit" class="btn btn-primary" name="add">Add</button></td>
                			</tr>
                			@php 
                			    $totaldebit =0;
                			    $totalcredit =0;
                			 @endphp
                			 @foreach($BatchPending as $data)
                			@php
                			 $totaldebit +=$data->debit;
                			 $totalcredit +=$data->credit;
                			@endphp
                					<tr>
                					<td><input type="text" class="form-control"  value="{{$data->M_type}}"  readonly></td>
                					<td><input type="text" class="form-control"  value="{{$data->secondary}}"  readonly></td>
                					<td><input type="text" class="form-control"  value="{{number_format($data->debit,2, '.', ',')}}"  readonly></td>
                					<td><input type="text" class="form-control"  value="{{number_format($data->credit,2, '.', ',')}}"  readonly></td>
                					<td><input type="text" class="form-control"  value="{{$data->trans_date}}"  readonly></td>
                					<td><input type="text" class="form-control"  value="{{$data->remark}}"  readonly></td>
                					<td><a href="javascript: del('{{$data->id}}')"><i class="fa fa-minus-square" style="color:red"></i></a></td>
                					</tr>
                			@endforeach
                			<tr> <td colspan=2>Total</td>
                			<td><input type="text" class="form-control"  value="{{number_format($totaldebit,2, '.', ',')}}"  readonly style="width:150px;"></td>
                			<td><input type="text" class="form-control"  value="{{number_format($totalcredit,2, '.', ',')}}"  readonly style="width:150px;"></td>
                			<td ></td>
                			<td ></td>
                			<td>@if (($totalcredit >0) || ($totaldebit >0))<button type="submit" class="btn btn-primary" name="post">Post</button> @endif</td>
                			</tr>
				        </table>
                        </div>
                    </div>
                </form>
                <!--===================================================-->
                <!-- End Inline Form  -->
            </div>
        </div>
    <div id="editModal" class="modal fade" >
        <div class="modal-dialog box box-default" role="document" style="color:black;font-size:24px;">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Account Type</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal"  method="post"  role="form">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    
                      <input type="hidden" class="form-control" id="id" name="id">
                      <div class="col-sm-12">
			             <div class="form-group">
                      <label class="control-label"><h5>Account Head: </h5></label>
                      <select  class="form-control" id="manu"name="acchead" >
                                     <option value="">--Select--</option>
                                          @foreach($AccountHead as $list)
                                     <option value="{{ $list->id }}" >{{ $list->accounthead }}({{ $list->accoundheadcode }})</option>
                                          @endforeach
                                   </select>
                        </div>
                      </div>
                      <div class="col-sm-12">
			             <div class="form-group">
                      <label class="control-label"><h5>Account Type: </h5></label>
                      <input type="text" class="form-control" id="brand" name="subhead">
                        </div>
                      </div>
                      </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="update">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>
    <!--modal for deleting record-->
    <div id="deleteModal" class="modal fade" >
        <div class="modal-dialog box box-default" role="document" style="color:black;font-size:24px;">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Brand Record</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal"  method="post"  role="form">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    
                      <input type="hidden" class="form-control" id="deleteid" name="id" value="">
                                          
                      <div class="col-sm-12">
                     <center><h1 style="color:black;">Are you sure?</h1></center>
                      </div>
                </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" name="del" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            
                </form>
            </div>
            
          </div>
    </div>
    </div>
        <!--/// content end here -->
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
      
        var id = document.getElementById('refaccountid').value;
         
        document.getElementById('acctid').value= id; 
        
        document.getElementById('refaccountname').value=document.getElementById('desc'+id).value +" "+ document.getElementById('acct'+id).value;
    }
    function fetchMains()
    {
        var id = document.getElementById('refaccountids').value;
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
    
             
</script>



  
@stop
