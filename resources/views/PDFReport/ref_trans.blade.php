@extends('layouts.print_layout')
@section('content')  
	<div class="panel">
        <div class="panel-body">
			<div class="table-responsive" style="font-size: 11px; padding:10px;" id="tableData">
                <table class="table table-bordered table-striped table-highlight" ><thead>
                		  	<tr bgcolor="#c7c7c7">
                				<th >Transaction Date</th><th >Accout Description</th> <th>Debit</th><th>Credit</th><th>Ref No</th><th>Auto-Ref No</th><th>Remarks</th><th>System Date</th>
                			</tr>
                			</thead>
                			
                				@foreach($RefTrans as $data)
                				<tr>
                        		<td>{{  $data->transdate}}</td>
                        		<td>{{  $data->accountName}}({{  $data->accountcode}})</td>
                        		<td style="text-align: right; ">{{number_format(abs($data->debit),2, '.', ',') }}</td>
                        		<td style="text-align: right; ">{{  number_format(abs($data->credit),2, '.', ',')}} </td>
                        		<td>{{  $data->manual_ref}} </td>
                        		<td>&nbsp;{{  $data->ref}} </td>
                        		<td>{{  $data->remarks}} </td>
                        		<td>{{  $data->createdat}}</td>
		                        </tr>	
                				@endforeach                				               			
				        </table>
		     </div>             
		</div>       
    </div>

@endsection