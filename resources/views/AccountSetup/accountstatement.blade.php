@extends('layouts.layout')
@section('pageTitle')
    Batch Post
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
            <li><a href="#">Batch Post</a></li>
         
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
                                        <option value="{{ $list->id }}:{{ $list->accountdescription }}({{ $list->accountno}})">{{ $list->accountdescription }}({{ $list->accountno}})</option>
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
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">From:</label>
                                    <input type="date" name="fromdate" value="{{$fromdate}}"   class="form-control" style="width:150px;">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label >To:</label> 
                                    <input type="date" name="todate" value="{{$todate}}"   class="form-control" style="width:150px;">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label ><br></label>
                                    <br>
                                    <button type="submit" class="btn btn-primary" name="post">Post</button>
                                </div>
                            </div>
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
    
             
</script>



  
@stop
