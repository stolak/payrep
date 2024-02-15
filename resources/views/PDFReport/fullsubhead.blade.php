@extends('layouts.print_layout')
@section('content')  
	<div class="panel">
        <div class="panel-body">
			<div class="table-responsive" style="font-size: 11px; padding:10px;" id="tableData">
                <table class="table table-bordered table-striped table-highlight" ><thead>
                            <tr bgcolor="#c7c7c7">
                            	 <th >ACCOUNT SUB-HEAD</th><th >ACCOUNT DESCRIPTION</th><th >AMOUNT</th>
                            </tr>
                            </thead>
                            @php  
                			$TotalVal=0;
                			$Totalliablity=0;
                			@endphp
                            @foreach($BalanceSheetFullSubHead as $data)
                				<tr>
                        		
                        		<td>{{$data->Subhead}}</td>
                        		<td>{{$data->accountName}}</td>
                        		<td style="text-align: right; ">@if( $data->tVal<0)({{  number_format(abs($data->tVal),2, '.', ',')}})  @else{{  number_format(abs($data->tVal),2, '.', ',')}} @endif</td>
                        		@php $TotalVal+= $data->tVal; @endphp
                        		</tr>
                        	@endforeach
                        	
                	 		<tr>
                            	 <td colspan=2 ><b>Total</b></td>
                            	 <td style="text-align: right; "> <b>@if( $TotalVal<0)({{  number_format(abs($TotalVal),2, '.', ',')}})  @else{{  number_format(abs($TotalVal),2, '.', ',')}} @endif </b></td>
                            	 	
                        		     
                            </tr>
                			
				        </table>
		     </div>             
		</div>       
    </div>

@endsection