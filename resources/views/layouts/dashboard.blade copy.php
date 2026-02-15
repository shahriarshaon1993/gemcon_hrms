<style>
	.loader {
	border: 10px solid #f3f3f3;
	border-radius: 50%;
	border-top: 16px solid #fec23c;
	border-bottom: 16px solid #fec23c;
	width: 80px;
	height: 80px;
		position: fixed;
		left: 50%;
		top: 50%;
	-webkit-animation: spin 2s linear infinite;
	animation: spin 2s linear infinite;
	}

	#loader-wrapper .loader {
		position: fixed;
		top: 0;
		width: 100%;
		height: 100%;
		background: #222222;
	}
	@-webkit-keyframes spin {
	0% { -webkit-transform: rotate(0deg); }
	100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
	0% { transform: rotate(0deg); }
	100% { transform: rotate(360deg); }
	}
	.hrm-navbar-badge{
		font-size: 0.5rem !important;
		right: 3px !important;
		top: -3px !important;
	}
	.dropdown-item:active {
		background-color: #fac100 !important;
	}
</style>

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
<!-- <div class="loader loader-wrapper">
		
</div> -->
<div id="app">
<nav class="main-header navbar navbar-expand navbar-white navbar-light"  style="background: {{$backgroundCollor}}">
	 	 <ul class="navbar-nav">
		      <li class="nav-item">
		        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		      </li>
		      <li class="nav-item d-none d-sm-inline-block">
		        <a href="/index" class="nav-link">Home</a>
		      </li>
		      <!-- <li class="nav-item d-none d-sm-inline-block">
		        <a href="#" class="nav-link">Contact</a>
		      </li> -->
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

	 	<!-- <div id="app"> -->

       		<!-- <pos-topbar></pos-topbar>  -->
       <!-- </div> -->
       	
	 	 <!-- Right navbar links -->
		    <ul class="navbar-nav ml-auto">
		      <!-- <li class="nav-item">
		        <a class="nav-link" href="/index"><i class="fas fa-th-large"></i></a>
		      </li> -->

			  <li class="nav-item dropdown">
			  	<a class="nav-link" href="#" data-toggle="dropdown"><i class="fas fa-th-large"></i></a>
		        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
		          <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item">
		            <!-- <i class="mr-2" style="background-image: url('images/module-images/recruitment1.png');"></i>  -->
					<img src="{{asset('images/module-images/recruitment1.png')}}" width="30" height="30" >
					Recruitment
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="{{url('/dashboards')}}" class="dropdown-item">
				  <img src="{{asset('images/module-images/employee_list.png')}}" width="30" height="30" >
				   HRM - Employees
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="{{url('/dashboards_payroll')}}" class="dropdown-item">
		            <img src="{{asset('images/module-images/payroll.png')}}" width="30" height="30" >
					 Payroll
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="{{url('/dashboard_appraisal')}}" class="dropdown-item">
		            <img src="{{asset('images/module-images/module.png')}}" width="30" height="30" >
					 KRA & KPI
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="{{url('/settings')}}" class="dropdown-item">
		            <img src="{{asset('images/module-images/settings.png')}}" width="30" height="30" >
					 Settings
		          </a>
		          <div class="dropdown-divider"></div>
		        </div>
		      </li>
		      <!-- <li class="nav-item">
		        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
		            class="fas fa-th-large"></i></a>
		      </li> -->
		      <!-- Messages Dropdown Menu -->
		      <!-- <li class="nav-item dropdown">
		        <a class="nav-link" data-toggle="dropdown" href="#">
					<i class="fas fa-th-large"></i>
		        </a>
		        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
		          <a href="#" class="dropdown-item">
		            <div class="media">
		              <img src="admin_assets/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
		              <div class="media-body">
		                <h3 class="dropdown-item-title">
		                  Brad Diesel
		                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
		                </h3>
		                <p class="text-sm">Call me whenever you can...</p>
		                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
		              </div>
		            </div>
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item">
		            <div class="media">
		              <img src="admin_assets/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
		              <div class="media-body">
		                <h3 class="dropdown-item-title">
		                  John Pierce
		                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
		                </h3>
		                <p class="text-sm">I got your message bro</p>
		                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
		              </div>
		            </div>
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item">
		            <div class="media">
		              <img src="admin_assets/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
		              <div class="media-body">
		                <h3 class="dropdown-item-title">
		                  Nora Silvester
		                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
		                </h3>
		                <p class="text-sm">The subject goes here</p>
		                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
		              </div>
		            </div>
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
		        </div>
		      </li> -->
			  
		      <!-- Notifications Dropdown Menu -->
		      <li class="nav-item dropdown">
		        <a class="nav-link" data-toggle="dropdown" href="#">
		          <i class="far fa-bell"></i>
		          <span class="badge badge-danger navbar-badge hrm-navbar-badge total_notifications">0</span>
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
			  <!-- <header-top> </header-top> -->
		      <!-- Notifications Dropdown Menu -->
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" style="padding-top:4px;">
		            <!-- <img src="{{asset('admin_assets/images/default.png')}}" width="30" height="30" class="rounded-circle"> -->
		            <?php 

		            // echo "<pre>"; print_r($employee_data); 
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
		          <!-- <a href="#" class="dropdown-item">
		            <i class="fa fa-user mr-2"></i> Profile
		          </a> -->
		          <a href="#" class="dropdown-item">
		            <i class="fa fa-key mr-2"></i> Change Password
		          </a>

		          <div class="dropdown-divider"></div>
		          <a href="{{ route('user.logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="dropdown-item">  <i class="fa fa-sign-out-alt mr-2"></i> Log Out</a>

		          <!-- <a href="http://localhost/gemconerp/index.php" class="dropdown-item">
		            <i class="fa fa-sign-out-alt mr-2"></i> Logout
		          </a> -->
		          <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                       @csrf
                </form>
		        </div>
		      </li>
		    </ul>
	 </nav>
       <pos-sidebar></pos-sidebar>
        <div class="content-wrapper">
	        <bredcrumb></bredcrumb>
	        <router-view></router-view>
       </div>
</div>  

<style type="text/css">
	.modal-header {
	    background: {{ $backgroundCollor }};
	    color:{{ $fontColor }};
	}
	.modal-header > h4{
		 font-size:{{$fontSizes}};
	}

</style>

<script src="<?php echo url(route('hrm.jsBaseURLs')); ?>"></script>  
<script src="{{asset('js/app.js')}}"></script>
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
@include('includs.deshboard_footer')
</body>
</html>
<script type="text/javascript">
	$('.dropdown-toggle').dropdown();
	$(document).ready(function() {
		// var user_employee_id = "<?php //echo Auth::guard('user')->user()->id; ?>";
		var employee_id = "<?php echo Auth::guard('user')->user()->employee_id; ?>";
		$.ajax({
			type: 'GET',
			url: "{{ url('/') }}/find_unreadNotifications/" + employee_id,
			success: function(data) {
				const get_leave_application = data.get_leave_application;
				const get_late_application = data.get_late_application;
				const get_manual_attendance = data.get_manual_attendance;
				const get_service_requests = data.get_service_requests;
				const get_stationery_services = data.get_stationery_services;

				const summary_data = data.summary_data;
				const total_notifications = get_leave_application + get_late_application + get_manual_attendance + get_service_requests + get_stationery_services;
				$("#get_leave_application").text(get_leave_application);
				$("#get_late_application").text(get_late_application);
				$("#get_manual_attendance").text(get_manual_attendance);
				$("#get_service_requests").text(get_service_requests);
				$("#get_stationery_services").text(get_stationery_services);

				$(".total_notifications").text(total_notifications);
				$("#summary_data").text(summary_data);
			},
			error: function() {
				console.log('Error occured!');
			}
		});
	});

	$('#notificationsMore').on('click', function(event) {
		event.stopPropagation();
        $('.more_notifications').css('display', 'block');
        $('#notificationsLess').css('display', 'block');
		$('#notificationsMore').css('display', 'none');
		// $(this).parent().toggleClass('open');
		// $( "#notificationsLess" ).addClass( 'dropdown-item dropdown-footer');
    });
	$('#notificationsLess').on('click', function(event) {
		event.stopPropagation();
        $('.more_notifications').css('display', 'none');
        $('#notificationsLess').css('display', 'none');
        $('#notificationsMore').css('display', 'block');
		// $(this).parent().toggleClass('open');
		// $( "#notificationsMore" ).addClass( 'dropdown-item dropdown-footer');
    });
    
</script>


