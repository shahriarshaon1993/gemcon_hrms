@include('includs.deshboard_header')
<?php 
	$employsData = DB::table('employees')->where('id', Auth::guard('user')->user()->employee_id)->first();
	$companyTheme= DB::table('company_sbus')->where('id',$employsData->employee_sbu)->first();
	if(!empty($companyTheme)){
		$backgroundCollor=$companyTheme->modal_header_color;
		$fontColor=$companyTheme->header_font_color;
		$fontSizes=$companyTheme->header_font_size.'px';
	}else{
		$backgroundCollor='#fec23c';
		$fontColor='#fff';
		$fontSizes='15px';
	}
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light"  style="background: {{$backgroundCollor}}">
	 	 <ul class="navbar-nav">
		      <li class="nav-item">
		        <a style="padding-top: 11px;" class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		      </li>
		      <li class="nav-item d-none d-sm-inline-block">
		        <a style="padding-top: 11px;" href="/index" class="nav-link">Home</a>
		      </li>
		    </ul>
		    <!-- SEARCH FORM -->
		    <form class="form-inline ml-3">
		      <div class="input-group input-group-sm">
		        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
		        <div class="input-group-append">
		          <button class="btn btn-navbar" type="submit">
		            <i class="fas fa-search"></i>
		          </button>
		        </div>
		      </div>
		    </form>
	 	 <!-- Right navbar links -->
		    <ul class="navbar-nav ml-auto">
			  <li class="nav-item dropdown">
			  	<a style="padding-top: 11px;" class="nav-link" href="#" data-toggle="dropdown"><i class="fas fa-th-large"></i></a>
		        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
		          <div class="dropdown-divider"></div>
		          <a href="{{url('dashboards#/job_circular_list')}}" class="dropdown-item" target="_blank">
					<img src="{{asset('images/module-images/recruitment1.png')}}" width="30" height="30">
					Recruitment
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="{{url('/dashboards')}}" class="dropdown-item" target="_blank">
				  <img src="{{asset('images/module-images/employee_list.png')}}" width="30" height="30">
				   HRM - Employees
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="{{url('/dashboards_payroll#/payroll')}}" class="dropdown-item" target="_blank">
		            <img src="{{asset('images/module-images/payroll.png')}}" width="30" height="30">
					 Payroll
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="{{url('/dashboard_appraisal')}}" class="dropdown-item" target="_blank">
		            <img src="{{asset('images/module-images/module.png')}}" width="30" height="30">
					 KRA & KPI
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="{{url('/settings')}}" class="dropdown-item" target="_blank">
		            <img src="{{asset('images/module-images/settings.png')}}" width="30" height="30">
					 Settings
		          </a>
		          <div class="dropdown-divider"></div>
		        </div>
		      </li>
		      <!-- Notifications Dropdown Menu -->
		      <li class="nav-item dropdown">
		        <a style="padding-top: 11px; font-size: 15px;" class="nav-link" data-toggle="dropdown" href="#">
		          <i class="far fa-bell"></i>
		          <span style="top: 3px;" class="badge badge-danger navbar-badge hrm-navbar-badge total_notifications">0</span>
		        </a>
		        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
		          <span class="dropdown-item dropdown-header"><span class = "total_notifications"></span> Notifications</span>
		          <div class="dropdown-divider"></div>
		          <a href="/dashboards#/leaveapplication_list" class="dropdown-item">
		            <i class="fas fa-smile mr-2"></i> <span id = "get_leave_application"></span> Leave Applications
		            <!-- <span class="float-right text-muted text-sm">3 mins</span> -->
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="/dashboards#/manualattendance_list" class="dropdown-item">
		            <i class="fas fa-clock mr-2"></i> <span id = "get_manual_attendance"></span> Manual Attend. Requests
		            <!-- <span class="float-right text-muted text-sm">12 hours</span> -->
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="/dashboards#/late_approval_list" class="dropdown-item">
		            <i class="fas fa-paper-plane mr-2"></i> <span id = "get_late_application"></span> Late Applications
		            <!-- <span class="float-right text-muted text-sm">2 days</span> -->
		          </a>
		          <span class="more_notifications" style="display: none;">
					<div class="dropdown-divider"></div>
					<a href="/dashboards#/service_request_list" class="dropdown-item">
						<i class="fa fa-list mr-2"></i> <span id = "get_service_requests"></span> Service Requests
						<!-- <span class="float-right text-muted text-sm">12 hours</span> -->
					</a>
					<div class="dropdown-divider"></div>
					<a href="/dashboards#/stationary_service" class="dropdown-item">
						<i class="fa fa-paperclip mr-2"></i> <span id = "get_stationery_services"></span> Stationery Services
						<!-- <span class="float-right text-muted text-sm">2 days</span> -->
					</a>
				  </span>
		          <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item dropdown-footer" id = "notificationsMore">See More</a>
		          <a href="#" class="dropdown-item dropdown-footer" id = "notificationsLess" style="display:none;">See Less</a>
		        </div>
		      </li>
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" style="padding-top:4px;">
		            <?php
		            	$username = isset($user->name)?$user->name:'';
		            	$employee_image = isset($employee_data['employee_image'])?$employee_data['employee_image']:'';
		             ?>
		             <?php if (!empty($employee_image)): ?>
		             	<img src="{{asset('images/'.$employee_image )}}" width="30" height="30" class="rounded-circle">
		             <?php else: ?>
		             	<img src="{{asset('images/default.png')}}" width="30" height="30" class="rounded-circle">
		             <?php endif ?>
		            <span>{{$username}}</span>
		        </a>
		        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right profile-setting">
		          <a href="#" class="dropdown-item">
		            <i class="fa fa-key mr-2"></i> Change Password
		          </a>

		          <div class="dropdown-divider"></div>
		          <a href="{{ route('user.logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="dropdown-item">  <i class="fa fa-sign-out-alt mr-2"></i> Log Out</a>
		          <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                       @csrf
                </form>
		        </div>
		      </li>
		    </ul>
	</nav>
 <style type="text/css">
	.modal-header {
	    background: {{ $backgroundCollor }};
	    color:{{ $fontColor }};
	}
	.modal-header > h4{
		 font-size:{{$fontSizes}};
	}
    .hrm-navbar-badge{
		font-size: 0.5rem !important;
		right: -3px !important;
		top: 5px !important;
	}
    .navbar-badge {
        right: 0px !important;
        top: 2px !important;
    }
	.dropdown-item:active {
		background-color: #fac100 !important;
	}
</style>