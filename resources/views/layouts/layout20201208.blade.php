<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>@yield('pageTitle')</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
		
		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/feathericon.min.css') }}">
		
		<link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css') }}">
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
       
		 @yield('styles')
    </head>
    <body>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		<div class="d-print-none">
			<!-- Header -->
            <div class="header">
			
				<!-- Logo -->
                <div class="header-left">
                    <a href="/" class="logo">
						<img src="{{ asset('assets/img/njc-logo2.jpg') }}" alt="Logo">
					</a>
					<a href="/" class="logo logo-small">
						<img src="{{ asset('assets/img/njc-logo2.jpg') }}" alt="Logo" width="30" height="30">
					</a>
                </div>
				<!-- /Logo -->
				
				<a href="javascript:void(0);" id="toggle_btn">
					<i class="fe fe-text-align-left"></i>
				</a>
				
				<div class="top-nav-search">
					<form>
						<input type="text" class="form-control" placeholder="Search here">
						<button class="btn" type="submit"><i class="fa fa-search"></i></button>
					</form>
				</div>
				
				<!-- Mobile Menu Toggle -->
				<a class="mobile_btn" id="mobile_btn">
					<i class="fa fa-bars"></i>
				</a>
				<!-- /Mobile Menu Toggle -->
				
				<!-- Header Right Menu -->
				<ul class="nav user-menu">

					<!-- Notifications -->
					<li class="nav-item dropdown noti-dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<i class="fe fe-bell"></i> <span class="badge badge-pill">3</span>
						</a>
						<div class="dropdown-menu notifications">
							<div class="topnav-dropdown-header">
								<span class="notification-title">Notifications</span>
								<a href="javascript:void(0)" class="clear-noti"> Clear All </a>
							</div>
							<div class="noti-content">
								<ul class="notification-list">
									<li class="notification-message">
										<a href="#">
											<div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="{{ asset('assets/img/doctors/doctor-thumb-01.jpg')}}">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">Dr. Ruby Perrin</span> Schedule <span class="noti-title">her appointment</span></p>
													<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="#">
											<div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src=""{{ asset('assets/img/patients/patient1.jpg')}}"">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">Charlene Reed</span> has booked her appointment to <span class="noti-title">Dr. Ruby Perrin</span></p>
													<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									
								</ul>
							</div>
							<div class="topnav-dropdown-footer">
								<a href="#">View all Notifications</a>
							</div>
						</div>
					</li>
					<!-- /Notifications -->
					
					<!-- User Menu -->
					<li class="nav-item dropdown has-arrow">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<span class="user-img"><img class="rounded-circle" src="{{asset('assets/img/profiles/avatar-01.jpg')}}" width="31" alt="Ryan Taylor"></span>
						</a>
						<div class="dropdown-menu">
							<div class="user-header">
								<div class="avatar avatar-sm">
									<img src="{{asset('assets/img/profiles/avatar-01.jpg')}}" alt="User Image" class="avatar-img rounded-circle">
								</div>
								<div class="user-text">
									<h6>{{Auth::user()->name}}</h6>
									<p class="text-muted mb-0">Administrator</p>
								</div>
							</div>
							<a class="dropdown-item" href="/">My Profile</a>
							<a class="dropdown-item" href="/">Settings</a>
							<a class="dropdown-item" href="{{url('logout')}}">Logout</a>
						</div>
					</li>
					<!-- /User Menu -->
					
				</ul>
				<!-- /Header Right Menu -->
				
            </div>
			<!-- /Header -->
			
			<!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="menu-title"> 
								<span>Main</span>
							</li>
							<li class="active"> 
								<a href="/"><i class="fe fe-home"></i> <span>Dashboard</span></a>
							</li>
							
							
							<li class="submenu">
								<a href="#"><i class="fe fe-vector"></i> <span> Settings</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="/judicial-registration">Judicial Institution</a></li>
									<li><a href="/annual-budget-setup">Annual Budget</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="#"><i class="fe fe-vector"></i> <span> Computation</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="/disbursement-computation">Compute</a></li>
									<li><a href="/voucher-computation">Generate Voucher</a></li>
									<li><a href="/voucher-checking">Check Voucher</a></li>
									<li><a href="/voucher-auditing">Audit Voucher</a></li>
									
								</ul>
							</li>
							<li class="submenu">
								<a href="#"><i class="fe fe-document"></i> <span> Reports</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="/">Invoice Reports</a></li>
									<li><a href="/funds/FRE">FRE Reports</a></li>
									<li><a href="/funds/SRE">SRE Reports</a></li>
									<li><a href="/funds/FRE-summary">FRE Reports Summary</a></li>
									<li><a href="/funds/SRE-summary">SRE Reports Summary</a></li>
									<li><a href="/funds/SRES-summary">State Reports Summary</a></li>
								</ul>
							</li>
							<li class=""> 
								<a href="/funds/set-salary"><i class="fe fe-document"></i> <span>Consolidated Setup</span></a>
							</li>
								<li class=""> 
								<a href="/funds/judges"><i class="fe fe-document"></i> <span>Judges</span></a>
							</li>
							<li class=""> 
								<a href="/funds/variables"><i class="fe fe-document"></i> <span>Variables Setup</span></a>
							</li>
							<li class="submenu">
								<a href="#"><i class="fe fe-document"></i> <span> Users </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="/create-user"> Register </a></li>
								</ul>
							</li>
							
							
						</ul>
					</div>
                </div>
            </div>
			<!-- /Sidebar -->
		</div>
			<!-- Page Wrapper -->
            @yield('content')
			<!-- /Page Wrapper -->
		
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="{{ asset('assets/js/jquery-3.2.1.min.js')}}"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="{{ asset('assets/js/popper.min.js')}}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
		
		<!-- Slimscroll JS -->
        <script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
		
		<!--<script src="{{ asset('assets/plugins/raphael/raphael.min.js')}}"></script>    
		<script src="{{ asset('assets/plugins/morris/morris.min.js')}}"></script>  
		<script src="{{ asset('assets/js/chart.morris.js')}}"></script>-->
		<script src="{{ asset('assets/js/select2.min.js')}}"></script>
       
		<!-- Custom JS -->
		<script  src="{{ asset('assets/js/script.js')}}"></script>
		@yield('scripts')
    </body>

</html>