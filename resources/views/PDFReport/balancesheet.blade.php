@extends('layouts.layout')
@section('pageTitle')
    Balance Sheet
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
            <li><a href="#">Statement of Financial Position</a></li>
         
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
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">As At:</label>
                                    <input type="date" name="asatdate" value="{{$asatdate}}"   class="form-control" >
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
                        <div class="table-responsive" style="font-size: 12px;" id="tableData">
                            <table class="table table-bordered table-striped table-highlight" >
                                <thead>
                                    <tr bgcolor="#c7c7c7">
                                    	 <th >ACCOUNT TYPE</th> <th>ASSETS</th> <th >Amount</th><th >Note</th>
                                    </tr>
                                </thead>
                            @php  
                			$Totalasset=0;
                			$Totalliablity=0;
                			$Total_C_liablity=0;
                			$note=1;
                			@endphp
                            @foreach($CurrentAsset as $data)
                				<tr>
                            		<td>Current</td>
                            		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" >{{  $data->Subhead}}</a></td>
                            		<td style="text-align: right; ">@if( $data->tVal<0)({{  number_format(abs($data->tVal),2, '.', ',')}})  @else{{  number_format(abs($data->tVal),2, '.', ',')}} @endif</td>
                            		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" class="btn btn-success">Note{{$note++}}</a></td>
                        		@php $Totalasset+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                        	@foreach($FixedAsset as $data)
                				<tr>
                        		<td>Fixed</td>
                        		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" >{{  $data->Subhead}}</a></td>
                        		<td style="text-align: right; ">@if( $data->tVal<0)({{  number_format(abs($data->tVal),2, '.', ',')}})  @else{{  number_format(abs($data->tVal),2, '.', ',')}} @endif </td>
                        		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" class="btn btn-success">Note{{$note++}}</a></td>
                        		@php $Totalasset+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                				<tr>
                                	 <td colspan=2>Total</td>
                                	 <td style="text-align: right; "><b>@if( $Totalasset<0)({{  number_format(abs($Totalasset),2, '.', ',')}})  @else{{  number_format(abs($Totalasset),2, '.', ',')}} @endif </b></td>
                                </tr>
                                <thead>
                            <tr bgcolor="#c7c7c7">
                            	 <th >ACCOUNT TYPE</th> <th >CURRENT LIABLITY</th><th >AMOUNT</th><th ></th>
                            </tr>
                            </thead>
                            @foreach($Liability as $data)
                				<tr>
                        		<td>Current</td>
                        		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" >{{  $data->Subhead}}</a></td>
                        		<td style="text-align: right; ">@if( $data->tVal<0){{  number_format(abs($data->tVal),2, '.', ',')}}  @else &#40; {{  number_format(abs($data->tVal),2, '.', ',')}} &#41; @endif </td>
                        		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" class="btn btn-success">Note{{$note++}}</a></td>
                        		@php $Total_C_liablity+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                        	<tr>
                                	 <td colspan=2>Total</td>
                                	 
                                	 <td style="text-align: right; "><b>@if( $Totalasset<0){{  number_format(abs($Total_C_liablity),2, '.', ',')}}  @else &#40; {{  number_format(abs($Total_C_liablity),2, '.', ',')}} &#41; @endif </b></0></td>
                        		     
                            </tr>
                            <thead>
                                <tr bgcolor="#c7c7c7">
                                    @php $netasset=$Totalasset-$Total_C_liablity; @endphp
                                	 <th colspan =2>Net Current Asset</th> <th style="text-align: right; ">@if( $netasset<0) &#40; {{  number_format(abs($netasset),2, '.', ',')}} &#41; @else  {{  number_format(abs($netasset),2, '.', ',')}}  @endif</th>
                                </tr>
                            </thead>
                            <thead>
                            <tr>
                        		<td colspan =4></td>
                        	</tr>
                            <tr bgcolor="#c7c7c7">
                            	 <th >ACCOUNT TYPE</th> <th >EQUITY</th><th >AMOUNT</th><th ></th>
                            </tr>
                            </thead>
                           
                            
                        	@foreach($LongLiability as $data)
                				<tr>
                        		<td>Long Term</td>
                        		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" >{{  $data->Subhead}}</a></td>
                        	
                        		<tdstyle="text-align: right; ">@if( $data->tVal<0)({{  number_format(abs($data->tVal),2, '.', ',')}})  @else{{  number_format(abs($data->tVal),2, '.', ',')}} @endif </td>
                        		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" class="btn btn-success">Note{{$note++}}</a></td>
                        		@php $Totalliablity+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                        	@foreach($Equity as $data)
                				<tr>
                        		<td>Equity</td>
                        		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" >{{  $data->Subhead}}</a></td>
                        		<td style="text-align: right; ">@if( $data->tVal<0)({{  number_format(abs($data->tVal),2, '.', ',')}})  @else{{  number_format(abs($data->tVal),2, '.', ',')}} @endif </td>
                        		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" class="btn btn-success">Note{{$note++}}</a></td>
                        		
                        		@php $Totalliablity+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                        	@foreach($PL as $data)
                				<tr>
                        		<td>P & L</td>
                        		<td><a target="_blank" href="/display/{{$asatdate}}/0" >P & L</a></td>
                        		
                        		<td style="text-align: right; ">@if( $data->tVal<0)({{  number_format(abs($data->tVal),2, '.', ',')}})  @else{{  number_format(abs($data->tVal),2, '.', ',')}} @endif </td>
                        		<td><a target="_blank" href="/display/{{$asatdate}}/0" class="btn btn-success">Note{{$note++}}</a></td>
                        		@php $Totalliablity+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                	 		<tr>
                            	 <td colspan=2>Total</td>
                            	 	
                        		  <td style="text-align: right; "><b>@if( $Totalliablity<0)({{  number_format(abs($Totalliablity),2, '.', ',')}})  @else{{  number_format(abs($Totalliablity),2, '.', ',')}} @endif</b> </td>   
                            </tr>
                			
				        </table>
                        </div>
                    </div>
                </form>
                <input type="button" class="hidden-print" id="btnExport" value="Export to Excel" onclick="Export()" /> 
                <input type="button" class="hidden-print" id="btnExport" value="Export to PDF" onclick="Export_PDF()" />
                <!--===================================================-->
                <!-- End Inline Form  -->
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
<script src="/assets/js/table2excel.js"></script>
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
    function Export() {
        $("#tableData").table2excel({
            filename: "_financial_position.xls"
        });
    }
   
   
    
function Export_PDF() {
var doc = new jsPDF(); 

var elementHandler = {
  '#ignorePDF': function (element, renderer) {
    return true;
  }
};

//var source = window.document.getElementsByTagName("body")[0];
var source =document.getElementById("tableData");
//doc.setFontSize(40)
//doc.text(35, 25, 'Paranyan loves jsPDF');
//alert("jdjdj");
doc.fromHTML(
    source,
    15,
    15,
    {
      'width': 180
    });
//alert("hello");
doc.output("dataurlnewwindow");

}
</script>



  
@stop
