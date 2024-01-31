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
								<h3 class="page-title">Default setting</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Default setting</li>
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
								<div class="card-header">
		
								</div>
							
									<form method="post" name="mainform" id="mainform">
                                    {{ csrf_field() }}
										
										<div class="row">
										    <div class="col-md-3">
											    <div class="form-group">
													<label>Rate %</label>
													<div class="input-group">
                                                        <input type="text" id="rate" name="rate" value="{{$rate}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											
										    <div class="col-md-3">
												<div class="form-group">
													<label>Registration fee</label>
													<div class="input-group">
                                                        <input type="text" id="registrationFee" name="registrationFee" value="{{$registrationFee}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Processing charge %</label>
													<div class="input-group">
                                                        <input type="text" id="processingFee" name="processingFee" value="{{$processingFee}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Defaulter charge %</label>
													<div class="input-group">
                                                        <input type="text" id="defaulterFee" name="defaulterFee" value="{{$defaulterFee}}" class="form-control" style="text-align: left;"  autocomplete="off">
                                                    </div>
												</div>
											</div>
										</div>
										
										
										<div class="text-right">
											
											<button type="submit" class="btn btn-primary" name="update">Save Changes</button>
										</div>
									</form>
								</div>
							</div>
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