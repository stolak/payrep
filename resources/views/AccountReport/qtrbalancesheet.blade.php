@extends('layouts.layout')
@section('pageTitle')
    Quarterly Balance Sheet
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
            <li><a href="#">Qaurterly Balance Sheet</a></li>
         
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
                        
                         <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label class="control-label">Current Year</label>
                                    <select name="year"  class="form-control" id="year">
                                    <option value="">Select Year</option>
                                   <?php $curyr= date("Y"); ?>
                                    @for ($i = 2017; $i <= $curyr +1; $i++)
        				<option value="{{ $i }}" {{(old('year') == $i ||($year) == $i) ? "selected" : ""}}>{{ $i }}</option>
    				    @endfor
                                    
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label class="control-label">Current Quarter</label>
                                    <select name="qtr"  class="form-control" id="qtr">
                                    <option value="">Select Quarter</option>
                                    @foreach($QuarterlyPeriod as $list)
				     	<option value="{{ $list->id}}" {{(old('qtr') == $list->id ||($qtr) == $list->id) ? "selected" : ""}}>{{$list->period}}</option>     
				    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label ><br></label>
                                    <br>
                                    <button type="submit" class="btn btn-success" name="update" style="align:left">search</button>
                                </div>
                            </div>
                        </div>
                        
                            
                            <div class="table-responsive" style="font-size: 12px;" id="tableData">
                              <table class="table table-bordered table-striped table-highlight" >
                        
                                            <thead>
                                                <tr bgcolor="#c7c7c7">
                                                	  <th></th><th><h4> As at {{date("jS M, Y", strtotime($curdate))}}</h4></th><th><h4> As at {{date("jS M, Y", strtotime($prevdate))}}</h4></th>
                                                </tr>
                                                
                                                <tr bgcolor="#c7c7c7">
                                                	  <th>ASSETS</th><th colspan=2>Amount</th> 
                                                </tr>
                                                </thead>
                                                @php  
                                    			$Totalasset=0;
                                    			$Totalliablity=0;
                                    			$Total_C_liablity=0;
                                    			$Totalasset2=0;
                                    			$Totalliablity2=0;
                                    			$Total_C_liablity2=0;
                                    			$note=1;
                                    			@endphp
                                                @foreach($CurrentAsset as $data)
                                    				<tr>
                                            	
                                            		
                                            		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" >{{  $data->Subhead}}</a>(Current)</td>
                                            		
                                            		<td style="text-align: right; ">@if( $data->tval1<0)({{  number_format(abs($data->tval1),2, '.', ',')}})  @else{{  number_format(abs($data->tval1),2, '.', ',')}} @endif</td>
                                            		<td style="text-align: right; ">@if( $data->tval2<0)({{  number_format(abs($data->tval2),2, '.', ',')}})  @else{{  number_format(abs($data->tval2),2, '.', ',')}} @endif</td>
                                            		
                                            		@php 
                                            		$Totalasset+= $data->tval1;
                                            		$Totalasset2+= $data->tval2;
                                            		@endphp
                                            		</tr>
                                            	@endforeach
                                            	@foreach($FixedAsset as $data)
                                    				<tr>
                                            		
                                            		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" >{{  $data->Subhead}}</a>(Fixed)</td>
                                            		<td style="text-align: right; ">@if( $data->tval1<0)({{  number_format(abs($data->tval1),2, '.', ',')}})  @else{{  number_format(abs($data->tval1),2, '.', ',')}} @endif </td>
                                            		<td style="text-align: right; ">@if( $data->tval2<0)({{  number_format(abs($data->tval2),2, '.', ',')}})  @else{{  number_format(abs($data->tval2),2, '.', ',')}} @endif </td>
                                            		
                                            		@php 
                                            		$Totalasset+= $data->tval1;
                                            		$Totalasset2+= $data->tval2;
                                            		@endphp
                                            		</tr>
                                            	@endforeach
                                    				<tr>
                                                    	 <td colspan=1>Total</td>
                                                    	 <td style="text-align: right; "><b>@if( $Totalasset<0)({{  number_format(abs($Totalasset),2, '.', ',')}})  @else{{  number_format(abs($Totalasset),2, '.', ',')}} @endif </b></td>
                                                        <td style="text-align: right; "><b>@if( $Totalasset2<0)({{  number_format(abs($Totalasset2),2, '.', ',')}})  @else{{  number_format(abs($Totalasset2),2, '.', ',')}} @endif </b></td>
                                                    </tr>
                                                    <thead>
                                                <tr bgcolor="#c7c7c7">
                                                	 <th >CURRENT LIABLITY</th><th colspan=2 >AMOUNT</th>
                                                </tr>
                                                </thead>
                                                @foreach($Liability as $data)
                                    				<tr>
                                            		
                                            		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" >{{  $data->Subhead}}</a>(Current)</td>
                                            		<td style="text-align: right; ">@if( $data->tval1<0){{  number_format(abs($data->tval1),2, '.', ',')}}  @else &#40; {{  number_format(abs($data->tval1),2, '.', ',')}} &#41; @endif </td>
                                            		<td style="text-align: right; ">@if( $data->tval2<0){{  number_format(abs($data->tval2),2, '.', ',')}}  @else &#40; {{  number_format(abs($data->tval2),2, '.', ',')}} &#41; @endif </td>
                                            		
                                            		@php 
                                            		$Total_C_liablity+= $data->tval1;
                                            		$Total_C_liablity2+= $data->tval2;
                                            		@endphp
                                            		</tr>
                                            	@endforeach
                                            	<tr>
                                                    	 <td colspan=1>Total</td>
                                                    	 <td style="text-align: right; "><b>@if( $Total_C_liablity<0){{  number_format(abs($Total_C_liablity),2, '.', ',')}}  @else &#40; {{  number_format(abs($Total_C_liablity),2, '.', ',')}} &#41; @endif </b></0></td>
                                            		     <td style="text-align: right; "><b>@if( $Total_C_liablity2<0){{  number_format(abs($Total_C_liablity2),2, '.', ',')}}  @else &#40; {{  number_format(abs($Total_C_liablity2),2, '.', ',')}} &#41; @endif </b></0></td>
                                            		     
                                                </tr>
                                                <thead>
                                                    <tr bgcolor="#c7c7c7">
                                                        @php $netasset=$Totalasset-$Total_C_liablity; @endphp
                                                        @php $netasset2=$Totalasset2-$Total_C_liablity2; @endphp
                                                    	 <th>Net Current Asset</th> <th style="text-align: right; ">@if( $netasset<0) &#40; {{  number_format(abs($netasset),2, '.', ',')}} &#41; @else  {{  number_format(abs($netasset),2, '.', ',')}}  @endif</th>
                                                    <th style="text-align: right; ">@if( $netasset2<0) &#40; {{  number_format(abs($netasset2),2, '.', ',')}} &#41; @else  {{  number_format(abs($netasset2),2, '.', ',')}}  @endif</th>
                                                    
                                                    </tr>
                                                </thead>
                                                <thead>
                                                <tr>
                                            		<td ></td>
                                            	</tr>
                                                <tr bgcolor="#c7c7c7">
                                                	 <th >EQUITY</th><th colspan=2>AMOUNT</th>
                                                </tr>
                                                </thead>
                                               
                                                
                                            	@foreach($LongLiability as $data)
                                    				<tr>
                                            		
                                            		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" >{{  $data->Subhead}}</a>(Long Term)</td>
                                            	
                                            		<td style="text-align: right; ">@if( $data->tval1<0)({{  number_format(abs($data->tval1),2, '.', ',')}})  @else{{  number_format(abs($data->tval1),2, '.', ',')}} @endif </td>
                                            		<td style="text-align: right; ">@if( $data->tval2<0)({{  number_format(abs($data->tval2),2, '.', ',')}})  @else{{  number_format(abs($data->tval2),2, '.', ',')}} @endif </td>
                                            		@php $Totalliablity+= $data->tval1; @endphp
                                            		@php $Totalliablity2+= $data->tval2; @endphp
                                            		</tr>
                                            	@endforeach
                                            	@foreach($Equity as $data)
                                    				<tr>
                                            		
                                            		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" >{{  $data->Subhead}}</a>(Equity)</td>
                                            		
                                            		<td style="text-align: right; ">@if( $data->tval1<0)({{  number_format(abs($data->tval1),2, '.', ',')}})  @else{{  number_format(abs($data->tval1),2, '.', ',')}} @endif </td>
                                            		<td style="text-align: right; ">@if( $data->tval2<0)({{  number_format(abs($data->tval2),2, '.', ',')}})  @else{{  number_format(abs($data->tval2),2, '.', ',')}} @endif </td>
                                            		
                                            		@php $Totalliablity+= $data->tval1; @endphp
                                            		@php $Totalliablity2+= $data->tval2; @endphp
                                            		</tr>
                                            	@endforeach
                                            	@foreach($PL as $data)
                                    				<tr>
                                            		
                                            		<td><a target="_blank" href="/display/{{$asatdate}}/0" >P & L</a></td>
                                            		
                                            		<td style="text-align: right; ">@if( $data->tval1<0)({{  number_format(abs($data->tval1),2, '.', ',')}})  @else{{  number_format(abs($data->tval1),2, '.', ',')}} @endif </td>
                                            	    <td style="text-align: right; ">@if( $data->tval2<0)({{  number_format(abs($data->tval2),2, '.', ',')}})  @else{{  number_format(abs($data->tval2),2, '.', ',')}} @endif </td>
                                            	@php $Totalliablity+= $data->tval1; @endphp
                                            		@php $Totalliablity2+= $data->tval2; @endphp
                                            		</tr>
                                            	@endforeach
                                    	 		<tr>
                                                	 <td colspan=1>Total</td>
                                                	 	
                                            		  <td style="text-align: right; "><b>@if( $Totalliablity<0)({{  number_format(abs($Totalliablity),2, '.', ',')}})  @else{{  number_format(abs($Totalliablity),2, '.', ',')}} @endif</b> </td>   
                                            		  <td style="text-align: right; "><b>@if( $Totalliablity2<0)({{  number_format(abs($Totalliablity2),2, '.', ',')}})  @else{{  number_format(abs($Totalliablity2),2, '.', ',')}} @endif</b> </td>   
                                                </tr>
                                                </table>
                            </div>
                            
                        <div class="table-responsive" style="font-size: 12px;" id="tableData2">
                            <h3>P/L</h3>
                            <table class="table table-bordered table-striped table-highlight" >
                                <tr>
                                    <td colspan=3>Current year</td>
                                    <td colspan=3>Previous year</td>
                                    
                                </tr>
                                <tr>
                                    <td>Current Year Current Quarter</td>
                                    <td>Previous Quarter of the Current year</td>
                                    <td> Cummulative up to {{date("jS M, Y", strtotime($curdate))}}</td>
                                    <td>Previous Year of Current Quarter</td>
                                    <td>Previous Quarter of the Previous year</td>
                                    <td> Cummulative up to {{date("jS M, Y", strtotime($prevdate))}}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right; "><b>@if($PLWithinCurrentYearCurrentQtr[0]->tVal<0)({{  number_format(abs($PLWithinCurrentYearCurrentQtr[0]->tVal),2, '.', ',')}})  @else{{  number_format(abs($PLWithinCurrentYearCurrentQtr[0]->tVal),2, '.', ',')}} @endif</b></td>
                                    <td style="text-align: right; "><b>@if($PLWithinCurrentYearCurrentQtr2[0]->tVal<0)({{  number_format(abs($PLWithinCurrentYearCurrentQtr2[0]->tVal),2, '.', ',')}})  @else{{  number_format(abs($PLWithinCurrentYearCurrentQtr2[0]->tVal),2, '.', ',')}} @endif</b></td>
                                    <td style="text-align: right; "> <b>@if($PL[0]->tval1<0)({{  number_format(abs($PL[0]->tval1),2, '.', ',')}})  @else{{  number_format(abs($PL[0]->tval1),2, '.', ',')}} @endif</b></td>
                                    
                                    <td style="text-align: right; "><b>@if($PLWithinPrevYearCurrentQtr[0]->tVal<0)({{  number_format(abs($PLWithinPrevYearCurrentQtr[0]->tVal),2, '.', ',')}})  @else{{  number_format(abs($PLWithinPrevYearCurrentQtr[0]->tVal),2, '.', ',')}} @endif</b></td>
                                    <td style="text-align: right; "><b>@if($PLWithinPrevYearCurrentQtr2[0]->tVal<0)({{  number_format(abs($PLWithinPrevYearCurrentQtr2[0]->tVal),2, '.', ',')}})  @else{{  number_format(abs($PLWithinPrevYearCurrentQtr2[0]->tVal),2, '.', ',')}} @endif</b></td>
                                 
                                    <td style="text-align: right; "> <b>@if( $PL[0]->tval2<0)({{  number_format(abs($PL[0]->tval2),2, '.', ',')}})  @else{{  number_format(abs($PL[0]->tval2),2, '.', ',')}} @endif</b></td>
                                </tr>
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
<form method="post" target="_blank"  action="/balance-sheet-pdf" id ="pdf" name="pdf">
    {{ csrf_field() }}
    <input type="hidden" name="asatdate"  value="{{$asatdate}}">
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
            filename: "_financial_position.xls"
        });
    }
             
</script>



  
@stop
