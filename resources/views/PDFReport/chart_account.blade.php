@extends('layouts.print_layout')
@section('content')  
	
        <div class="panel-body">
            <center><h3>{{env('Coy_Name')}} </h3></center>
           <center><h5> Charts of Account as at {{date("d/m/Y")}} </h5></center>
			<div class="table-responsive" style="font-size: 11px; padding:10px; color: black;" id="tableData">
                <table id="mytable" class="table table-bordered table-striped table-highlight" style="color: black;" >
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

@endsection