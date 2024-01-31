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
								<h3 class="page-title">Income Account Setup</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Setup</li>
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
										<div class="row">
										    <div class="col-md-5">
											    <div class="form-group">
													<label>Status </label>
													
													<select class="select2 form-control" name="particular">
														<option value="" >--Select--</option>
														@foreach($particulars as $list)
														<option value="{{$list->id}}" {{$particular == (string) $list->id? 'selected':''}}>{{$list->particular}} </option>
														@endforeach
													</select>
												</div>
											</div>
                                            <div class="col-md-7">
											    <div class="form-group">
												<label>Income Account</label>
													<select class="select2 form-control" name="account" >
														<option value="" >--Select--</option>
														@foreach($accounts as $list)
														<option value="{{$list->id}}" {{((string) $list->id==$account)? 'selected':''}}>{{$list->accountdescription}}</option>
														@endforeach
													</select>
												</div>
											</div>
										</div>
										<div class="text-right">
											<button type="submit" class="btn btn-primary" name="update">Update Now</button>
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
								
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th rowspan="1">S/N</th>													
													<th rowspan="1">Particular</th>
													<th rowspan="1">Income Account</th>	
												</tr>
											</thead>
											<tbody>
											    @php
													$sn=1;
													
												@endphp
											   @foreach($particulars as $list)
													
												<tr>
													<td >
														{{$sn++}}
													</td>
													<td >
													{{$list->particular}} 
													</td>
													<td >
													{{$list->accountdescription}}
													</td>
													
												@endforeach
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
							
							
						</div>
					</div>
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
    const viewFunc =(id)=>{
        document.getElementById('detail-id').value = id;
        Reload('form-detail')
    }
	
	const Reload = (form)=>document.forms[form].submit();
</script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->