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
							<div class="col-sm-12">
								<h3 class="page-title">Welcome {{Auth::user()->name}}! </h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item active">Dashboard</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header --> 

					<div class="row">
						@If(Auth::user()->userrole!==5)
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
								<a href="/active-customer">
									<div class="dash-widget-header">
										<span class="dash-widget-icon text-primary border-primary">
											<i class="fe fe-users"></i>
										</span>
										<div class="dash-count">
											<h3>{{$activeCustomer}}</h3>
										</div>
									</div>
									
									<div class="dash-widget-info">
									
										<h6 class="text-muted">Active Customers</h6>
										<div class="progress progress-sm">
											<div class="progress-bar bg-primary w-50"></div>
										</div>
									
									</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
								<a href="/active-loan">
									<div class="dash-widget-header">
										<span class="dash-widget-icon text-success">
											<i class="fe fe-credit-card"></i>
										</span>
										<div class="dash-count">
											<h3>{{$activeLoans}}</h3>
										</div>
									</div>
									<div class="dash-widget-info">
										
										<h6 class="text-muted">Active Loans</h6>
										<div class="progress progress-sm">
											<div class="progress-bar bg-success w-50"></div>
										</div>
									</div>
								</a>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
								<a href="/application-loan">
									<div class="dash-widget-header">
										<span class="dash-widget-icon text-danger border-danger">
											<i class="fe fe-money"></i>
										</span>
										<div class="dash-count">
											<h5>{{$applications}}</h5>
										</div>
									</div>
									<div class="dash-widget-info">
										
										<h6 class="text-muted">Applications</h6>
										<div class="progress progress-sm">
											<div class="progress-bar bg-danger w-50"></div>
										</div>
									</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
								<a href="/overdue-loan">
									<div class="dash-widget-header">
										<span class="dash-widget-icon text-warning border-warning">
											<i class="fe fe-folder"></i>
										</span>
										<div class="dash-count">
											<h5>{{number_format($overdue,2, '.', ',')}}</h5>
										</div>
									</div>
									<div class="dash-widget-info">
										
										<h6 class="text-muted">Overdue Repayment</h6>
										<div class="progress progress-sm">
											<div class="progress-bar bg-warning w-50"></div>
										</div>
									</div>
							</a>
								</div>
							</div>
						</div>
						@endif
					</div>
					
					
					
					
				</div>			
			</div>
			@endsection
@section('scripts')

        
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->