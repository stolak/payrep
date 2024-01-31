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
								<h3 class="page-title">Active Customer</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Active Customer</li>
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
								
								<div class="card-body">
									<form method="post" name="mainform" id="mainform">
                                    {{ csrf_field() }}
										
									</form>
								</div>
							</div>
						</div>
					</div>
					
				<div class="row">
						<div class="col-md-12">
						
							<!-- List of economic code -->
							<div class="card card-table">
								<div class="card-header">
									<h4 class="card-title"> List of customers</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th rowspan="1">S/N</th>
													<th rowspan="1">Names</th>
													<th rowspan="1">Phone Number</th>
													<th rowspan="1">email </th>
													<th rowspan="1">Address</th>
													<th rowspan="1">Marketer</th>
													<th rowspan="1">Active Loan</th>
													<th rowspan="1">Action</th>
												</tr>
											</thead>
											<tbody>
											    @php $sn=1;@endphp
											   @foreach($customers as $list)
											  
												<tr>
													<td >
														{{$sn++}}
													</td>
													
													<td >
													{{$list->title}} {{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}
													</td>
													<td >
													{{$list->phone}}
													</td>
													<td >
													{{$list->email}}
													</td>
													<td >
													{{$list->address}}
													</td>
													<td >
														{{$list->name}}
													</td>
													<td >
														{{number_format($list->balance,2, '.', ',')??'Nill'}}
													</td>
													<td>
													
														<a class="btn btn-sm bg-success-light" href="javascript: editFunc('{{$list->id}}','{{$list->titleID}}','{{$list->first_name}}','{{$list->middle_name}}','{{$list->last_name}}','{{$list->phone}}','{{$list->email}}','{{$list->marketerID}}','{{$list->address}}')">
																<i class="fe fe-pencil"></i> 
															</a>
														<a  class="btn btn-sm bg-danger-light" href="javascript: deleteFunc('{{$list->id}}')">
																<i class="fe fe-trash"></i> 
														</a>	
													</td>
												 
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- /List of economic code -->
							
						</div>
					</div>
				</div>		
@endsection
@section('scripts')
<script>

	
  </script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->