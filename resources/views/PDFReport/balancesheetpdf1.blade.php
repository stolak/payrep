@extends('Layouts.print_layout')
@section('content')

    <!--- content comes here -->

    <div class="boxed">

        <!--CONTENT CONTAINER-->
        <!--===================================================-->

    <div id="page-content">

        <div class="panel">
            <div class="panel-body">
                        
                        <div class="table-responsive" style="font-size: 12px;" id="tableData">
                            <h5> Financial Position </h5>
                            <table class="table table-bordered table-striped table-highlight" >
                                <thead>
                                    <tr bgcolor="#c7c7c7">
                                    	 <th >ACCOUNT TYPE</th> <th>ASSETS</th> <th >Amount</th>
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
                            		<td>{{  $data->Subhead}}</td>
                            		<td style="text-align: right; ">@if( $data->tVal<0)({{  number_format(abs($data->tVal),2, '.', ',')}})  @else{{  number_format(abs($data->tVal),2, '.', ',')}} @endif</td>
        
                        		@php $Totalasset+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                        	@foreach($FixedAsset as $data)
                				<tr>
                        		<td>Fixed</td>
                        		<td>{{  $data->Subhead}}</td>
                        		<td style="text-align: right; ">@if( $data->tVal<0)({{  number_format(abs($data->tVal),2, '.', ',')}})  @else{{  number_format(abs($data->tVal),2, '.', ',')}} @endif </td>
                        		
                        		@php $Totalasset+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                				<tr>
                                	 <td>Total</td><td></td>
                                	 <td style="text-align: right; "><b>@if( $Totalasset<0)({{  number_format(abs($Totalasset),2, '.', ',')}})  @else{{  number_format(abs($Totalasset),2, '.', ',')}} @endif </b></td>
                                </tr>
                                
                            <tr bgcolor="#c7c7c7">
                            	 <th >ACCOUNT TYPE</th> <th >CURRENT LIABLITY</th><th ></th>
                            </tr>
                            
                            @foreach($Liability as $data)
                				<tr>
                        		<td>Current</td>
                        		<td><a target="_blank" href="/display/{{$asatdate}}/{{$data->subheadid}}" >{{  $data->Subhead}}</a></td>
                        		<td style="text-align: right; ">@if( $data->tVal<0){{  number_format(abs($data->tVal),2, '.', ',')}}  @else &#40; {{  number_format(abs($data->tVal),2, '.', ',')}} &#41; @endif </td>
                        		@php $Total_C_liablity+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                        	<tr>
                                	 <td>Total</td><td></td>
                                	 
                                	 <td style="text-align: right; "><b>@if( $Totalasset<0){{  number_format(abs($Total_C_liablity),2, '.', ',')}}  @else &#40; {{  number_format(abs($Total_C_liablity),2, '.', ',')}} &#41; @endif </b></0></td>
                            </tr>
                           
                                <tr bgcolor="#c7c7c7">
                                    @php $netasset=$Totalasset-$Total_C_liablity; @endphp
                                	 <td>Net Current Asset</td><td></td> <th style="text-align: right; ">@if( $netasset<0) &#40; {{  number_format(abs($netasset),2, '.', ',')}} &#41; @else  {{  number_format(abs($netasset),2, '.', ',')}}  @endif</th>
                                </tr>
                            
                           
                                    <tr bgcolor="#c7c7c7">
                            	    <th >ACCOUNT TYPE</th> <th >EQUITY</th><th ></th>
                                    </tr>
                                
                            
                        	@foreach($LongLiability as $data)
                				<tr>
                        		<td>Long Term</td>
                        		<td>{{  $data->Subhead}}</td>
                        		<td style="text-align: right; ">@if( $data->tVal<0)({{  number_format(abs($data->tVal),2, '.', ',')}})  @else{{  number_format(abs($data->tVal),2, '.', ',')}} @endif </td>
                        		@php $Totalliablity+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                        	@foreach($Equity as $data)
                				<tr>
                        		<td>Equity</td>
                        		<td>{{  $data->Subhead}}</td>
                        		<td style="text-align: right; ">@if( $data->tVal<0)({{  number_format(abs($data->tVal),2, '.', ',')}})  @else{{  number_format(abs($data->tVal),2, '.', ',')}} @endif </td>
                        		@php $Totalliablity+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                        	@foreach($PL as $data)
                				<tr>
                        		<td>P & L</td>
                        		<td>P & L</td>
                        		<td style="text-align: right; ">@if( $data->tVal<0)({{  number_format(abs($data->tVal),2, '.', ',')}})  @else{{  number_format(abs($data->tVal),2, '.', ',')}} @endif </td>
                        		@php $Totalliablity+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                	 		<tr>
                            	 <td>Total</td><td></td>
                        		  <td style="text-align: right; "><b>@if( $Totalliablity<0)({{  number_format(abs($Totalliablity),2, '.', ',')}})  @else{{  number_format(abs($Totalliablity),2, '.', ',')}} @endif</b> </td>   
                            </tr>
				        </table>
                        </div>
                
                
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script>


</script>



  
@stop
