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
								<h3 class="page-title">Transaction upload</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Agent upload</li>
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
									<div class="text-right">
									<button type="button" class="btn btn-secondary" onclick ="Upload()">Upload</button>
										</div>
										<div class="row">
										
										    
                                           
											<div class="col-md-2">
											    <div class="form-group">
													<label>From</label>
													<input type="date"  value="{{$fromDate}}" name= "fromDate" class="form-control"   autocomplete="off" >
                                                   
												</div>
											</div>
											<div class="col-md-2">
											    <div class="form-group">
													<label>To</label>
													<input type="date"  value="{{$toDate}}" name= "toDate" class="form-control"   autocomplete="off" >
                                                   
												</div>
											</div>
											
										</div>
										<div class="text-right">
											<button type="submit" class="btn btn-primary">Search</button>
										</div>
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
									<h4 class="card-title">Agent List</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th rowspan="1">S/N</th>													
													<th rowspan="1">Account Name</th>
													<th rowspan="1">Account Number</th>
													<th rowspan="1">Business Name</th>
                                                    <th rowspan="1">Closing Balance</th>
                                                   
													<th rowspan="1">Action</th>
												</tr>
											</thead>
											<tbody>
											    @php
													$sn=1;
													
												@endphp
											   @foreach($records as $list)
													
												<tr>
													<td >
														{{$sn++}}
													</td>
													<td >
													{{$list->agent_name}}
													</td>
													<td >
													{{$list->account_ref}}
													</td>
                                                    <td >
													{{$list->business_name}}
													</td>
													
													<td style="text-align: right;">
													{{number_format($list->opening_bal,2, '.', ',')}}
													
													</td>
													<td >
													{{$list->as_at}}
													</td>
													
													<td style="text-align: right;">
												
													</td>
												</tr>
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
								<input type="hidden" id="d-id" name="id" >
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
			<!-- /Delete Modal -->

				<!-- Upload Modal -->
				<div class="modal fade" id="upload" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Agent Upload</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
							    
								
								
								
								<div class="row ">
									<div class="col-12 col-sm-12">
										<div class="form-group">
											<label>File</label>
											<input type="file" class="form-control" name="file">
										</div>
									</div>
							    </div>
								
								<button type="submit" class="btn btn-primary" name="upload">Continue</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Upload Modal -->
		
			</div>
           
				
@endsection
@section('scripts')
<script>

	const ValidateInput=(id)=>{
    document.getElementById(id).value = parseFloat(document.getElementById(id).value
		.toString().replace(/\,/g,'')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
   }
	const deleteRecord=(id)=>{
        document.getElementById('d-id').value = id;
        $("#delete_modal").modal('show')
    }
	const Upload=()=>{
       
	   $("#upload").modal('show')
   }
    
	
	const Reload = (form)=>document.forms[form].submit();
</script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->