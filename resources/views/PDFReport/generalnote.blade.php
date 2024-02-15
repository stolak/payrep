@extends('layouts.print_layout')
@section('content')  
	
        <div class="panel-body">
            <center><h3>{{env('Coy_Name')}} </h3></center>
            <center><h5> Ledger note as at {{date("d/m/Y", strtotime($asatdate))}} </h5></center>
			<div class="table-responsive" style="font-size: 11px; padding:10px;" id="tableData">
                <table class="table table-bordered table-striped table-highlight" ><thead>
                            <tr bgcolor="#c7c7c7">
                            	 <th ></th> <th >ACCOUNT DESCRIPTION</th><th >Amount</th>
                            </tr>
                            </thead>
                            @php  
                			$TotalVal=0;
                			$Totalliablity=0;
                			$subhead='';
                			$subtotal=0;
                			@endphp
                            @foreach($BalanceSheetFullSubHead as $data)
                                @if($subhead!=$data->Subhead)
                                @if($subhead!='')
                                <tr>
                        		<td></td>
                        		<td><b>Sub-total</b></td>
                        		<td style="text-align: right; "><b>@if( $subtotal<0)({{  number_format(abs($subtotal),2, '.', ',')}})  @else{{  number_format(abs($subtotal),2, '.', ',')}} @endif</b></td>
                        		</tr>
                        		<tr>
                        		<td colspan=3></td>
                        		</tr>
                                @endif
                                <tr>
                        		<td></td>
                        		<td colspan=2><b>{{$data->Subhead}}:{{$data->Head}}</b></td>
                        		</tr>
                                    @php
                                    $subtotal=0;
                        			$subhead=$data->Subhead;
                        			@endphp
                    			
                    			@endif
                				<tr>
                        		<td></td>
                        		<td>{{$data->accountName}}({{$data->accountcode}})</td>
                        		<td style="text-align: right; ">@if( $data->tVal<0)({{  number_format(abs($data->tVal),2, '.', ',')}})  @else{{  number_format(abs($data->tVal),2, '.', ',')}} @endif</td>
                        		</tr>
                        		@php $TotalVal+= $data->tVal; 
                        		$subtotal+= $data->tVal; 
                        		@endphp
                        	@endforeach
                        	<tr>
                        		<td></td>
                        		<td><b>Sub-total</b></td>
                        		<td style="text-align: right; ">@if( $subtotal<0)({{  number_format(abs($subtotal),2, '.', ',')}})  @else{{  number_format(abs($subtotal),2, '.', ',')}} @endif</td>
                        		</tr>
                        	
                	 		<tr>
                            	 <td colspan=2>Total</td>
                            	 <td style="text-align: right; ">@if( $TotalVal<0)({{  number_format(abs($TotalVal),2, '.', ',')}})  @else{{  number_format(abs($TotalVal),2, '.', ',')}} @endif</td>
                            	 	
                        		     
                            </tr>
                			
				        </table>
		     </div>             
		</div>       
    </div>

@endsection