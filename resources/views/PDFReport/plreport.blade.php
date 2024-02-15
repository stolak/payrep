@extends('layouts.print_layout')
@section('content')  
	
        <div class="panel-body">
             <center><h3>{{env('Coy_Name')}} </h3></center>
            <center><h5>Statement of Profit or Loss and Other Comprehensive Income from {{date("d/m/Y", strtotime($fromdate))}} to {{date("d/m/Y", strtotime($todate))}} </h5></center>
			<div class="table-responsive" style="font-size: 12px; padding:10px; color: black;" id="tableData">
                <table id="mytable" class="table table-bordered table-striped table-highlight" style="color: black;" >
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
                        		<td>{{  $data->Subhead}}</td>
                        		<td style="text-align: right; ">@if( $data->tVal<0){{  number_format(abs($data->tVal),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tVal),2, '.', ',')}} &#41; @endif</td>
                        	
                        		@php $income+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                        	<tr>
                            	 <td >Total</td>
                            	 <td style="text-align: right; "><b>@if( $income<0){{  number_format(abs($income),2, '.', ',')}}  @else  &#40;{{  number_format(abs($income),2, '.', ',')}} &#41; @endif </b></td>
                            </tr>
                        	@foreach($Expensedata as $data)
                				<tr>
                        		
                        		<td>{{  $data->Subhead}}</td>
                        		<td style="text-align: right; ">@if( $data->tVal<0){{  number_format(abs($data->tVal),2, '.', ',')}}  @else  &#40;{{  number_format(abs($data->tVal),2, '.', ',')}} &#41; @endif </td>
                        		
                        		@php $expense+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                				<tr>
                                	 <td >Total</td>
                                	 <td style="text-align: right; "><b>@if( $expense<0){{  number_format(abs($expense),2, '.', ',')}}  @else  &#40; {{  number_format(abs($expense),2, '.', ',')}}  &#41;@endif </b></td>
                                </tr>
                                
                           <tr>
                        		<td colspan =2></td>
                        	</tr>
                            <thead>
                                <tr bgcolor="#c7c7c7">
                                    @php $netasset=$income+$expense; @endphp
                                	 <th >Net Profit</th> <th style="text-align: right; ">@if( $netasset<0) {{  number_format(abs($netasset),2, '.', ',')}} @else &#40; {{  number_format(abs($netasset),2, '.', ',')}} &#41;  @endif</th>
                                
                                </tr>
                            </thead>
                            
                			
				        </table>
		     </div>             
		</div>       

@endsection