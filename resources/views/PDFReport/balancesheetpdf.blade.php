@extends('layouts.print_layout')
@section('content')
            <div class="panel-body">
                        <center><h3>{{env('Coy_Name')}} </h3></center>
                        <center><h5> Statement of Financial Position as at {{date("d/m/Y", strtotime($asatdate))}} </h5></center>
                        <div class="table-responsive" style="font-size: 12px; padding:10px; color: black;" id="tableData">
                        <table id="mytable" class="table table-bordered table-striped table-highlight" style="color: black;" >
                                <thead>
                                    <tr bgcolor="#c7c7c7">
                                    	 <th >ACCOUNT TYPE</th> <th>ASSETS</th> <th >AMOUNT</th>
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
                                	 
                                	 <td style="text-align: right; "><b>@if( $Totalasset<0){{  number_format(abs($Total_C_liablity),2, '.', ',')}}  @else &#40; {{  number_format(abs($Total_C_liablity),2, '.', ',')}} &#41; @endif </b></td>
                            </tr>
                           
                                <tr bgcolor="#c7c7c7">
                                    @php $netasset=$Totalasset-$Total_C_liablity; @endphp
                                	 <td><b>Net Current Asset </b></td><td></td> <th style="text-align: right; ">@if( $netasset<0) &#40; {{  number_format(abs($netasset),2, '.', ',')}} &#41; @else  {{  number_format(abs($netasset),2, '.', ',')}}  @endif</th>
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
                <!--===================================================-->
                <!-- End Inline Form  -->
            </div>
        </div>
    </div>

@endsection




  

