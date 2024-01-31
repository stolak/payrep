<!-- Page Wrapper -->
@extends('layouts.layout')
@section('pageTitle')
     {{env('Page_Title')}}
@endsection
@section('content')
            <div class="page-wrapper">
				<div class="content container-fluid">
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col">
								
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Profit and Lost</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<!-- include notoifcation -->
        			 @include('_partialView.nofication')
        			 <!-- /include notoifcation -->
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Profit/Lost</h4>
								</div>
								<div class="card-body">
									<form method="post" name="mainform" id="mainform">
                                    {{ csrf_field() }}
									<div class="panel-body">
                        <div class="row">
                            
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label >As at:</label> 
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
                        <div class="table-responsive" style="padding: 5px;" id="tableData">
                            <table class="table table-bordered table-striped table-highlight"  style="border:1px; padding:50px;" border="1"><thead>
                            <tr bgcolor="#c7c7c7">
                            	 <th >ACCOUNT TYPE</th>  <th >Amount</th>
                            </tr>
                            </thead>
                            @php  
                			$income=0;
                			$expense=0;
                			$note=1;
                			@endphp
                            @foreach($Incomedata as $data)
                				<tr>
                        		<td>{{  $data->subhead}}</td>
                        		<td style="text-align: right; ">@if( $data->tVal<0){{  number_format(abs($data->tVal),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tVal),2, '.', ',')}} &#41; @endif</td>
                        	
                        		@php $income+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                        	<tr>
                            	 <td >Sub-total</td>
                            	 <td style="text-align: right; "><b>@if( $income<0){{  number_format(abs($income),2, '.', ',')}}  @else  &#40;{{  number_format(abs($income),2, '.', ',')}} &#41; @endif </b></td>
                            </tr>
                        	@foreach($Expensedata as $data)
                				<tr>
                        		
                        		<td>{{ $data->subhead}}</td>
                        		<td style="text-align: right; ">@if( $data->tVal<0){{  number_format(abs($data->tVal),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tVal),2, '.', ',')}} &#41; @endif </td>
                        		@php $expense+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                				<tr>
                                	 <td >Sub-total</td>
                                	 <td style="text-align: right; "><b>@if( $expense<0){{  number_format(abs($expense),2, '.', ',')}}  @else  &#40; {{  number_format(abs($expense),2, '.', ',')}}  &#41;@endif </b></td>
                                </tr>
                                
                           <tr>
                        		<td colspan =2></td>
                        	</tr>
                            <thead>
                                <tr bgcolor="#c7c7c7">
                                    @php $netasset=$income+$expense; @endphp
                                	 <th >Net Profit/Loss</th> <th style="text-align: right; ">@if( $netasset<0) {{  number_format(abs($netasset),2, '.', ',')}} @else &#40; {{  number_format(abs($netasset),2, '.', ',')}} &#41;  @endif</th>
                               
                                </tr>
                            </thead>
                            
                			
				        </table>
                        </div>
                    </div>
									</form>
								</div>
							</div>
						</div>
					</div>
					
			
			<!-- Delete Modal -->
			<div class="modal fade" id="delete_modal" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<form method="post" >
                                    {{ csrf_field() }}
						<div class="modal-body">
							<div class="form-content p-2">
								<h4 class="modal-title">Delete</h4>
								<p class="mb-4">Are you sure want to delete?</p>
								<button type="submit" class="btn btn-primary" name="delete">Continue </button>
								<input type="hidden" id="d-id" name="delid" >
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
			<!-- /Delete Modal -->
		
			</div>
			
			<!-- /Edit Details Modal -->
@endsection
@section('scripts')
<script>
	
	const ValidateInput=(id)=>{
    document.getElementById(id).value = formatValue(document.getElementById(id).value);
   }

   const formatValue=(val)=>{
    return parseFloat(val
		.toString().replace(/\,/g,'')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
   }
	const deleteRecord=(id)=>{
        document.getElementById('d-id').value = id;
        $("#delete_modal").modal('show')
    }
	
	const Reload = (form)=>document.forms[form].submit();

	
        
</script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->