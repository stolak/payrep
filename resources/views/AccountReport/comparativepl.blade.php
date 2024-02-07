@extends('layouts.layout')
@section('pageTitle')
    Comparative P&L
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
            <li><a href="#">Comparative P&L</a></li>
         
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
                            
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label ><br></label>
                                    <br>
                                    <button type="submit" class="btn btn-success" name="update" style="align:left">search</button>
                                </div>
                            </div>
                        </div>
                        
                            
                           
                            
                        <div class="table-responsive" style="font-size: 12px;" id="tableData">
                            <h3>P/L</h3>
                            <table class="table table-bordered table-striped table-highlight" >
                                <tr>
                                    <td ></td>
                                    <td colspan=3>Current year</td>
                                    <td colspan=3>Previous year</td>
                                    
                                </tr>
                                <tr>
                                    <td >Income Account Type</td>
                                    <td>
                                        <div class="form-group">
                                            <label class="control-label">from:</label>
                                            <input type="date" name="asatdate5" value="{{$asatdate5}}"   class="form-control" >
                                            <label class="control-label">to:</label>
                                            <input type="date" name="asatdate5b" value="{{$asatdate5b}}"   class="form-control" >
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label class="control-label">from:</label>
                                            <input type="date" name="asatdate6" value="{{$asatdate6}}"   class="form-control" >
                                            <label class="control-label">to:</label>
                                            <input type="date" name="asatdate6b" value="{{$asatdate6b}}"   class="form-control" >
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label class="control-label">Cummulative at:</label>
                                            <input type="date" name="asatdate7" value="{{$asatdate7}}"   class="form-control" >
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label class="control-label">from:</label>
                                            <input type="date" name="asatdate8" value="{{$asatdate8}}"   class="form-control" >
                                            <label class="control-label">to:</label>
                                            <input type="date" name="asatdate8b" value="{{$asatdate8b}}"   class="form-control" >
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                           <label class="control-label">from:</label>
                                            <input type="date" name="asatdate9" value="{{$asatdate9}}"   class="form-control" >
                                            <label class="control-label">to:</label>
                                            <input type="date" name="asatdate9b" value="{{$asatdate9b}}"   class="form-control" >
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label class="control-label">Cummulative at:</label>
                                            <input type="date" name="asatdate10" value="{{$asatdate10}}"   class="form-control" >
                                        </div>
                                    </td>
                                </tr>
                                @php  
                			$income1=0;
                			$income2=0;
                			$income3=0;
                			$income4=0;
                			$income5=0;
                			$income6=0;
                			$expense1=0;
                			$expense2=0;
                			$expense3=0;
                			$expense4=0;
                			$expense5=0;
                			$expense6=0;
                			$note=1;
                			@endphp
                            @foreach($IncomeComparative as $data)
                				<tr>
                        		<td><a target="_blank" href="/display-pl/{{$asatdate5}}/{{$asatdate5b}}/{{$data->subheadid}}" >{{$data->Subhead}}</a></td>
                        		<td style="text-align: right; "><a target="_blank" href="/display-pl/{{$asatdate5}}/{{$asatdate5b}}/{{$data->subheadid}}" >@if( $data->tval1<0){{  number_format(abs($data->tval1),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tval1),2, '.', ',')}} &#41; @endif</a></td>
                        		<td style="text-align: right; "><a target="_blank" href="/display-pl/{{$asatdate6}}/{{$asatdate6b}}/{{$data->subheadid}}" >@if( $data->tval2<0){{  number_format(abs($data->tval2),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tval2),2, '.', ',')}} &#41; @endif</a></td>
                        		<td style="text-align: right; "><a target="_blank" href="/display-pl/{{'2000-01-01'}}/{{$asatdate7}}/{{$data->subheadid}}" >@if( $data->tval5<0){{  number_format(abs($data->tval5),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tval5),2, '.', ',')}} &#41; @endif</a></td>
                        		
                        		<td style="text-align: right; "><a target="_blank" href="/display-pl/{{$asatdate8}}/{{$asatdate8b}}/{{$data->subheadid}}" >@if( $data->tval3<0){{  number_format(abs($data->tval3),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tval3),2, '.', ',')}} &#41; @endif</a></td>
                        		<td style="text-align: right; "><a target="_blank" href="/display-pl/{{$asatdate9}}/{{$asatdate9b}}/{{$data->subheadid}}" >@if( $data->tval4<0){{  number_format(abs($data->tval4),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tval4),2, '.', ',')}} &#41; @endif</a></td>
                        		<td style="text-align: right; "><a target="_blank" href="/display-pl/{{'2000-01-01'}}/{{$asatdate10}}/{{$data->subheadid}}" >@if( $data->tval6<0){{  number_format(abs($data->tval6),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tval6),2, '.', ',')}} &#41; @endif</a></td>
                        		
                        		@php $income1+= $data->tval1; @endphp
                        		@php $income2+= $data->tval2; @endphp
                        		@php $income3+= $data->tval3; @endphp
                        		@php $income4+= $data->tval4; @endphp
                        		@php $income5+= $data->tval5; @endphp
                        		@php $income6+= $data->tval6; @endphp
                        		</tr>
                        	@endforeach
                        	<tr>
                                    <td ><b> Income</b> </td>
                                    <td style="text-align: right; "><b>@if($income1<0)({{  number_format(abs($income1),2, '.', ',')}})  @else &#40;{{  number_format(abs($income1),2, '.', ',')}} &#41; @endif</b></td>
                                    <td style="text-align: right; "><b>@if($income2<0)({{  number_format(abs($income2),2, '.', ',')}})  @else &#40;{{  number_format(abs($income2),2, '.', ',')}} &#41; @endif</b></td>
                                    <td style="text-align: right; "><b>@if($income3<0)({{  number_format(abs($income3),2, '.', ',')}})  @else &#40;{{  number_format(abs($income3),2, '.', ',')}} &#41; @endif</b></td>
                                    <td style="text-align: right; "><b>@if($income4<0)({{  number_format(abs($income4),2, '.', ',')}})  @else &#40;{{  number_format(abs($income4),2, '.', ',')}} &#41; @endif</b></td>
                                    <td style="text-align: right; "><b>@if($income5<0)({{  number_format(abs($income5),2, '.', ',')}})  @else &#40;{{  number_format(abs($income4),2, '.', ',')}} &#41; @endif</b></td>
                                    <td style="text-align: right; "><b>@if($income6<0)({{  number_format(abs($income6),2, '.', ',')}})  @else &#40;{{  number_format(abs($income6),2, '.', ',')}} &#41; @endif</b></td>
                            </tr>
                        	@foreach($ExpensesComparative as $data)
                				<tr>
                        		<td><a target="_blank" href="/display-pl/{{$asatdate5}}/{{$asatdate5b}}/{{$data->subheadid}}" >{{$data->Subhead}}</a></td>
                        		<td style="text-align: right; "><a target="_blank" href="/display-pl/{{$asatdate5}}/{{$asatdate5b}}/{{$data->subheadid}}" >@if( $data->tval1<0){{  number_format(abs($data->tval1),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tval1),2, '.', ',')}} &#41; @endif</a></td>
                        		<td style="text-align: right; "><a target="_blank" href="/display-pl/{{$asatdate6}}/{{$asatdate6b}}/{{$data->subheadid}}" >@if( $data->tval2<0){{  number_format(abs($data->tval2),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tval2),2, '.', ',')}} &#41; @endif</a></td>
                        		<td style="text-align: right; "><a target="_blank" href="/display-pl/{{'2000-01-01'}}/{{$asatdate7}}/{{$data->subheadid}}" >@if( $data->tval5<0){{  number_format(abs($data->tval5),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tval5),2, '.', ',')}} &#41; @endif</a></td>
                        		
                        		<td style="text-align: right; "><a target="_blank" href="/display-pl/{{$asatdate8}}/{{$asatdate8b}}/{{$data->subheadid}}" >@if( $data->tval3<0){{  number_format(abs($data->tval3),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tval3),2, '.', ',')}} &#41; @endif</a></td>
                        		<td style="text-align: right; "><a target="_blank" href="/display-pl/{{$asatdate9}}/{{$asatdate9b}}/{{$data->subheadid}}" >@if( $data->tval4<0){{  number_format(abs($data->tval4),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tval4),2, '.', ',')}} &#41; @endif</a></td>
                        		<td style="text-align: right; "><a target="_blank" href="/display-pl/{{'2000-01-01'}}/{{$asatdate10}}/{{$data->subheadid}}" >@if( $data->tval6<0){{  number_format(abs($data->tval6),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tval6),2, '.', ',')}} &#41; @endif</a></td>
                        		
                        		@php $expense1+= $data->tval1; @endphp
                        		@php $expense2+= $data->tval2; @endphp
                        		@php $expense3+= $data->tval3; @endphp
                        		@php $expense4+= $data->tval4; @endphp
                        		@php $expense5+= $data->tval5; @endphp
                        		@php $expense6+= $data->tval6; @endphp
            
                        		</tr>
                        	@endforeach
                        	<tr>
                                    <td ><b> Expense</b> </td>
                                    <td style="text-align: right; "><b>@if($expense1<0)({{  number_format(abs($expense1),2, '.', ',')}})  @else &#40;{{  number_format(abs($expense1),2, '.', ',')}} &#41; @endif</b></td>
                                    <td style="text-align: right; "><b>@if($expense2<0)({{  number_format(abs($expense2),2, '.', ',')}})  @else &#40;{{  number_format(abs($expense2),2, '.', ',')}} &#41; @endif</b></td>
                                    <td style="text-align: right; "><b>@if($expense3<0)({{  number_format(abs($expense3),2, '.', ',')}})  @else &#40;{{  number_format(abs($expense3),2, '.', ',')}} &#41; @endif</b></td>
                                    <td style="text-align: right; "><b>@if($expense4<0)({{  number_format(abs($expense4),2, '.', ',')}})  @else &#40;{{  number_format(abs($expense4),2, '.', ',')}} &#41; @endif</b></td>
                                    <td style="text-align: right; "><b>@if($expense5<0)({{  number_format(abs($expense5),2, '.', ',')}})  @else &#40;{{  number_format(abs($expense4),2, '.', ',')}} &#41; @endif</b></td>
                                    <td style="text-align: right; "><b>@if($expense6<0)({{  number_format(abs($expense6),2, '.', ',')}})  @else &#40;{{  number_format(abs($expense6),2, '.', ',')}} &#41; @endif</b></td>
                            </tr>
                                <tr>
                                    <td ><b>Cummulative P&L </b></td>
                                    <td style="text-align: right; "><b>@if($PLWithinCurrentYearCurrentQtr[0]->tVal<0)({{  number_format(abs($PLWithinCurrentYearCurrentQtr[0]->tVal),2, '.', ',')}})  @else{{  number_format(abs($PLWithinCurrentYearCurrentQtr[0]->tVal),2, '.', ',')}} @endif</b></td>
                                    <td style="text-align: right; "><b>@if($PLWithinPrevYearCurrentQtr[0]->tVal<0)({{  number_format(abs($PLWithinPrevYearCurrentQtr[0]->tVal),2, '.', ',')}})  @else{{  number_format(abs($PLWithinPrevYearCurrentQtr[0]->tVal),2, '.', ',')}} @endif</b></td>
                                    
                                     <td style="text-align: right; "> <b>@if($CPL[0]->tVal<0)({{  number_format(abs($CPL[0]->tVal),2, '.', ',')}})  @else{{  number_format(abs($CPL[0]->tVal),2, '.', ',')}} @endif</b></td>
                                    
                                    <td style="text-align: right; "><b>@if($PLWithinCurrentYearCurrentQtr2[0]->tVal<0)({{  number_format(abs($PLWithinCurrentYearCurrentQtr2[0]->tVal),2, '.', ',')}})  @else{{  number_format(abs($PLWithinCurrentYearCurrentQtr2[0]->tVal),2, '.', ',')}} @endif</b></td>
                                    <td style="text-align: right; "><b>@if($PLWithinPrevYearCurrentQtr2[0]->tVal<0)({{  number_format(abs($PLWithinPrevYearCurrentQtr2[0]->tVal),2, '.', ',')}})  @else{{  number_format(abs($PLWithinPrevYearCurrentQtr2[0]->tVal),2, '.', ',')}} @endif</b></td>
                                    <td style="text-align: right; "> <b>@if( $PPL[0]->tVal<0)({{  number_format(abs($PPL[0]->tVal),2, '.', ',')}})  @else{{  number_format(abs($PPL[0]->tVal),2, '.', ',')}} @endif</b></td>
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
    <input type="hidden" name="asatdate"  value="{{$asatdate5}}">
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
            filename: "_comparative_pl.xls"
        });
    }
             
</script>



  
@stop
