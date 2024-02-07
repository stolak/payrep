@extends('layouts.layout')
@section('pageTitle')
    Chart of Account
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
            <li><a href="#">Chart of Account</a></li>
         
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

               
	        
	        
	
               
                
                <!--===================================================-->
                <!-- End Inline Form  -->
<div class="table-responsive" style="font-size: 11px; padding:10px;" id="tableData">
                <table id="mytable" class="table table-bordered table-striped table-highlight">
		        <thead>
		          <tr bgcolor="#c7c7c7">
		          
		            <th>S/N</th>
		            <th>Account Head</th>
		            <th>Account Type</th>
		            <th>AFS</th>
		            <th>Account Number</th>
		            <th>Account Description</th>
		          </tr>
		        </thead>
		               
		        <tbody>
		        
		          @php
		          $i=1;
		          @endphp
		           
		            @foreach($AccountList as $list)
		               <tr>
		               <td>{{ $i++ }} </td>
		               <td>{{$list->accounthead}} </td>
		               <td>{{ $list->subhead}}</td>
		               <td>{{ $list->afs}}</td>
		               <td>{{ $list->accountno}}</td>
		               <td>{{ $list->accountdescription}}</td>
		               </tr>
		            @endforeach
		            </tbody>
		                   
		      </table>
		     </div>
            </div>
        </div>
   <input type="button" class="hidden-print" id="btnExport" value="Export to Excel" onclick="Export()" />  
   <input type="button" class="hidden-print" id="btnExport" value="Download PDF" onclick="ExportPDF()" />
    <!--modal for deleting record-->
  
    </div>
        <!--/// content end here -->
        </div>
    </div>
<form method="post" target="_blank"  action="/account-chart-pdf" id ="pdf" name="pdf">
    {{ csrf_field() }}
    
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
    function  Reload()
	{	
	  document.forms["mainform"].submit();
	   return;
	}
 function Export() {
            $("#tableData").table2excel({
                filename: "chart_of_account.xls"
            });
        }       
</script>



  
@stop
