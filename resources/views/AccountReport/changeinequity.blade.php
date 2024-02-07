@extends('layouts.layout')
@section('pageTitle')
    Change in equity
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
            <li><a href="#">Statement of Change in Equity</a></li>
         
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
	        
	        @php
	        $Ownerscapital1=$OwnersTransaction1->capital?? 0.00;
	        $Ownerscapital2=$OwnersTransaction2->capital?? 0.00;
	        $Ownersearning1=$OwnersTransaction1->earning?? 0.00;
	        $Ownersearning2=$OwnersTransaction2->earning?? 0.00;
	        $total1=$Ownerscapital1+$Ownersearning1;
	        $total2=$Ownerscapital2+$Ownersearning2;
	        @endphp
                <form method="post">
                {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label ><br></label>
                                    <br>
                                    <button type="submit" class="btn btn-success" style="align:left">search</button>
                                </div>
                            </div>
                            </div>
                        <div class="table-responsive" style="font-size: 12px;" id="tableData">
                            <table class="table table-bordered table-striped table-highlight" ><thead>
                                <tr bgcolor="#c7c7c7">
                                	  <th>
                                    <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Current year</label>
                                    <select name="year"  class="form-control">
                                    <option value="">Select year</option>
                                    <?php $curyr= date("Y"); ?>
                                    @for ($i = 2017; $i <= $curyr +1; $i++)
        				<option value="{{ $i }}" {{(old('year1') == $i ||($year1) == $i) ? "selected" : ""}}>{{ $i }}</option>
    				    @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Current month</label>
                                    <select name="qtr"  class="form-control">
                                    <option value="">Select month</option>
                                    @foreach($Months as $list)
				     	<option value="{{ $list->id}}" {{(old('month1') == $list->id ||($month1) == $list->id) ? "selected" : ""}}>{{$list->month}}</option>    
				    @endforeach
                                    </select>
                                </div>
                            </div>
                                    </th> <th >Note</th><th > Share Capital </th><th > Retained Earnings </th><th > Total Equities </th>
                                </tr>
                                </thead>
                                <tr>
                                    <td>At {{date("j F, Y",strtotime($beginat1))}}</td>
                                     <td></td>
                                     <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Lost for the period</td>
                                     <td></td>
                                     <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Total comprehensive income for the month</td>
                                     <td></td>
                                     <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Transactions with owner company</td>
                                     <td></td>
                                      <td><div  onclick="OwnerTransaction('{{$year1}}','{{$month1}}',{{$OwnersTransaction1->capital?? '0.00'}},{{$OwnersTransaction1->earning?? '0.00'}})">{{number_format($OwnersTransaction1->capital?? 0.00,2)}}</div></td>
                                    <td><div  onclick="OwnerTransaction('{{$year1}}','{{$month1}}',{{$OwnersTransaction1->capital?? '0.00'}},{{$OwnersTransaction1->earning??'0.00'}})">{{number_format($OwnersTransaction1->earning??0.00,2)}}</div></td>
                                    <td><div  onclick="OwnerTransaction('{{$year1}}','{{$month1}}',{{$OwnersTransaction1->capital?? '0.00'}},{{$OwnersTransaction1->earning??'0.00'}})">{{number_format($total1,2)}}</div></td>
                               
                                </tr>
                                <tr>
                                    <td>At {{date("j F, Y",strtotime($asatdate1))}}</td>
                                     <td></td>
                                     <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr bgcolor="#c7c7c7">
                                	  <th><div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Current year</label>
                                    <select name="year"  class="form-control">
                                    <option value="">Select year</option>
                                    <?php $curyr= date("Y"); ?>
                                    @for ($i = 2017; $i <= $curyr +1; $i++)
        				<option value="{{ $i }}" {{(old('year2') == $i ||($year2) == $i) ? "selected" : ""}}>{{ $i }}</option>
    				    @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Current month</label>
                                    <select name="qtr"  class="form-control">
                                    <option value="">Select month</option>
                                    @foreach($Months as $list)
                				     	<option value="{{ $list->id}}" {{(old('month2') == $list->id ||($month2) == $list->id) ? "selected" : ""}}>{{$list->month}}</option>    
                				    @endforeach
                                    </select>
                                </div>
                            </div>
                                    </th> <th >Note</th><th > Share Capital </th><th > Retained Earnings </th><th > Total Equities </th>
                                </tr>
                                </thead>
                                <tr>
                                    <td>At {{date("j F, Y",strtotime($beginat2))}}</td>
                                     <td></td>
                                     <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Lost for the period</td>
                                     <td></td>
                                     <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Total comprehensive income for the month</td>
                                     <td></td>
                                     <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Transactions with owner company</td>
                                     <td></td>
                                     <td><div  onclick="OwnerTransaction('{{$year2}}','{{$month2}}',{{$OwnersTransaction2->capital?? '0.00'}},{{$OwnersTransaction2->earning?? '0.00'}})">{{number_format($OwnersTransaction2->capital?? 0.00,2)}}</div></td>
                                    <td><div  onclick="OwnerTransaction('{{$year2}}','{{$month2}}',{{$OwnersTransaction2->capital?? '0.00'}},{{$OwnersTransaction2->earning??'0.00'}})">{{number_format($OwnersTransaction2->earning??0.00,2)}}</div></td>
                                    <td><div  onclick="OwnerTransaction('{{$year2}}','{{$month2}}',{{$OwnersTransaction2->capital?? '0.00'}},{{$OwnersTransaction2->earning??'0.00'}})">{{number_format($total2,2)}}</div></td>
                                </tr>
                                <tr>
                                    <td>At {{date("j F, Y",strtotime($asatdate2))}}</td>
                                     <td></td>
                                     <td></td>
                                    <td></td>
                                    <td></td>
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
    
     <div id="editModal" class="modal fade" >
        <div class="modal-dialog box box-default" role="document" style="color:black;font-size:24px;">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Owner transactions</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal"  method="post"  role="form">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    
                      <input type="hidden" class="form-control" id="yr" name="year">
                      <input type="hidden" class="form-control" id="mnt" name="month">
                      <div class="col-sm-12">
			             <div class="form-group">
                      <label class="control-label"><h5>Share Capital: </h5></label>
                      <input type="text" class="form-control" id="share_capital" name="share_capital">
                        </div>
                      </div>
                      <div class="col-sm-12">
			             <div class="form-group">
                      <label class="control-label"><h5>Retail Earning: </h5></label>
                      <input type="text" class="form-control" id="retain_earning" name="retain_earning">
                      
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
    
    function OwnerTransaction(yr,mnt,capital,earning)
    {
        //alert("jcjdjd");
        document.getElementById('yr').value = yr;
        document.getElementById('mnt').value = mnt;
        document.getElementById('share_capital').value = capital;
        document.getElementById('retain_earning').value = earning;
        $("#editModal").modal('show')
    }
    
    
    function Export() {
        $("#tableData").table2excel({
            filename: "_financial_position.xls"
        });
    }
             
</script>



  
@stop
