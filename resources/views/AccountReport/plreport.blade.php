@extends('layouts.layout')
@section('pageTitle')
    Statement of Profit or Loss and Other Comprehensive Income
@endsection

@section('pageHead')
    <div id="page-head">

        <!--Page Title-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div id="page-title">
            <h1 class="page-header text-overflow">Report</h1>
        </div>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End page title-->


        <!--Breadcrumb-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <ol class="breadcrumb">
            <li><a href="/"><i class="demo-pli-home"></i></a></li>
            <li><a href="#">Statement of Profit or Loss and Other Comprehensive Income</a></li>
         
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
	        
                <form method="post">
                {{ csrf_field() }}
                    <div class="panel-body">
                        <<div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">From:</label>
                                    <input type="date" name="fromdate" value="{{$fromdate}}"   class="form-control" >
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label >To:</label> 
                                    <input type="date" name="todate" value="{{$todate}}"   class="form-control" >
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label ><br></label>
                                    <br>
                                    <button type="submit" class="btn btn-success" name="update" style="align:left">search</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" style="font-size: 12px; padding: 5px;" id="tableData">
                            <table class="table table-bordered table-striped table-highlight"  style="border:1px; padding:50px;" border="1"><thead>
                            <tr bgcolor="#c7c7c7">
                            	 <th >ACCOUNT TYPE</th>  <th >Amount</th><th >Note</th>
                            </tr>
                            </thead>
                            @php  
                			$income=0;
                			$expense=0;
                			$note=1;
                			@endphp
                            @foreach($Incomedata as $data)
                				<tr>
                        		<td><a target="_blank" href="/display/{{$todate}}/{{$data->subheadid}}" >{{  $data->Subhead}}</a></td>
                        		<td style="text-align: right; ">@if( $data->tVal<0){{  number_format(abs($data->tVal),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tVal),2, '.', ',')}} &#41; @endif</td>
                        		<td><a  style="margin:3px;" target="_blank" href="/display/{{$todate}}/{{$data->subheadid}}" class="btn btn-success">Note{{$note++}}</a></td>
                        		@php $income+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                        	<tr>
                            	 <td >Total</td>
                            	 <td style="text-align: right; "><b>@if( $income<0){{  number_format(abs($income),2, '.', ',')}}  @else  &#40;{{  number_format(abs($income),2, '.', ',')}} &#41; @endif </b></td>
                            </tr>
                        	@foreach($Expensedata as $data)
                				<tr>
                        		
                        		<td><a target="_blank" href="/display/{{$todate}}/{{$data->subheadid}}" >{{  $data->Subhead}}</a></td>
                        		<td style="text-align: right; ">@if( $data->tVal<0){{  number_format(abs($data->tVal),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tVal),2, '.', ',')}} &#41; @endif </td>
                        		<td><a style="margin:3px;" target="_blank" href="/display/{{$todate}}/{{$data->subheadid}}" class="btn btn-success">Note{{$note++}}</a></td>
                        		@php $expense+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                				<tr>
                                	 <td >Total</td>
                                	 <td style="text-align: right; "><b>@if( $expense<0){{  number_format(abs($expense),2, '.', ',')}}  @else  &#40; {{  number_format(abs($expense),2, '.', ',')}}  &#41;@endif </b></td>
                                </tr>
                                
                           <tr>
                        		<td colspan =3></td>
                        	</tr>
                            <thead>
                                <tr bgcolor="#c7c7c7">
                                    @php $netasset=$income+$expense; @endphp
                                	 <th >Net Profit/Loss</th> <th style="text-align: right; ">@if( $netasset<0) {{  number_format(abs($netasset),2, '.', ',')}} @else &#40; {{  number_format(abs($netasset),2, '.', ',')}} &#41;  @endif</th>
                                <th></th>
                                </tr>
                            </thead>
                            
                			
				        </table>
                        </div>
                    </div>
                </form>
                <input type="button" class="hidden-print" id="btnExport" value="Export to Excel" onclick="Export()" />   
                <input type="button" class="hidden-print" id="btnExport" value="Download PDF" onclick="ExportPDF()" />
                <!--===================================================-->
                <!-- End Inline Form  -->
            </div>
        </div>
    
    
   
    </div>
        <!--/// content end here -->
        </div>
    </div>
 <form method="post" target="_blank"  action="/profit-loss-pdf" id ="pdf" name="pdf">
    {{ csrf_field() }}
    <input type="hidden" name="fromdate"  value="{{$fromdate}}">
    <input type="hidden" name="todate"  value="{{$todate}}">
</form>
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
<script src="/assets/js/table2excel.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script>
function  ExportPDF(){	document.forms["pdf"].submit();}  
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
    
   function Export() {
            $("#tableData").table2excel({
                filename: "profit_or_loss.xls"
            });
        }          
</script>



  
@stop
