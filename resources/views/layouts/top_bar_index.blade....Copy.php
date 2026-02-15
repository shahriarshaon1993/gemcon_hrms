<body class="o_web_client o_home_menu_background"><div class="o_notification_manager"></div>
<header>
	<style type="text/css">
		.o_home_menu .o_home_menu_scrollable {
		    max-width: 100%;
		}
		.o_home_menu {
		    height: auto;
		}
		.o_home_menu_background:not(.o_home_menu_background_custom) .o_main_navbar {
		    background-color: #f1f1f1;
		    border-color: #bbbbbb;
		}
		.profile-img img {
		    max-width: 120px;
		    max-height: 120px;
		    /* text-align: left; */
		}
		.profile-img img {
		    display: inline-block;
		    width: 120px;
		    height: 120px;
		    border-radius: 50%;
		    background-repeat: no-repeat;
		    background-position: center center;
		    background-size: cover;
		    margin-right: 35px;
		    border:1px solid #ddd;
		    box-shadow: 0px 0px 5px 0px #919190;
		}
		.o_main_navbar > ul > li > a, .o_main_navbar > ul > li > label {
		    color: #0a0a0a;
		}
	</style>
	<!-- Bar Chart  -->

	<script src="http://www.chartjs.org/dist/2.7.3/Chart.bundle.js"></script>
	<script src="http://www.chartjs.org/samples/latest/utils.js"></script>
	<style>
	canvas {
	  -moz-user-select: none;
	  -webkit-user-select: none;
	  -ms-user-select: none;
	}
	</style>

	<nav class="o_main_navbar">
		<a href="#" class="fa o_menu_toggle" title="Applications" aria-label="Applications"> <img width="70" height="46" src="{{asset('admin_assets/images/gemcon-logo.png')}}" style="margin-top:-3px;"></a>
		<ul class="o_menu_systray" role="menu">
			<li class="o_user_menu dropdown">
				<a role="button" class="dropdown-toggle" data-toggle="dropdown" data-display="static" aria-expanded="false" href="#">
					<?php 
						$employee_image = isset($employee_data['employee_image'])?$employee_data['employee_image']:'';
					 ?>
					 <?php if (!empty($employee_image)): ?>
					 	<img src="{{asset('images/'.$employee_image )}}" width="25" height="25" class="rounded-circle">
					 <?php else: ?>
					 	<img src="{{asset('images/default.png')}}" width="25" height="25" class="rounded-circle">
					 <?php endif ?>
					<!-- <span class="oe_topbar_name"> -->
						{{$user->name}}
					<!-- </span> -->
				</a>
				<div class="dropdown-menu dropdown-menu-right profile-setting" role="menu">
					<!-- <a role="menuitem" href="#" data-menu="settings" class="dropdown-item">
						<i class="fa fa-user"></i> My Profile
					</a> -->
					<a href="#" role="menuitem" data-menu="settings" class="dropdown-item" data-toggle="modal" data-target="#changePasswordModal" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">
						<i class="fa fa-key"></i> Change Password
					</a>
					<div role="separator" class="dropdown-divider"></div>
					<a href="{{ route('user.logout') }}" onclick="event.preventDefault();
	                                document.getElementById('logout-form').submit();" class="dropdown-item fa fa-sign-out">  <i class="fa fa-sign-out-alt mr-2"></i> Log Out</a>
	                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
	                       @csrf
	                </form>
				</div>
			</li>
		</ul>
	</nav>
</header>

<!-- <div class="o_loading" style="display: none;">Loading</div> -->

<!-- All Module Link -->
<div class="o_home_menu">
	<div class="o_home_menu_scrollable">
		<?php //print_r(session('password_change')) ; 
		// print_r($value) =session()->get('password_change');

		?>
			@if (session('error'))
            <div class="alert alert-danger anyMessage">
                {{ session('error') }}
            </div>
        	@endif
            @if (session('success'))
                <div class="alert alert-success anyMessage">
                    {{ session('success') }}
                </div>
            @endif
			<div class="o_apps">
				<a class="o_app o_menuitem" data-menu="5" data-action-model="35" data-action-id="35" data-menu-xmlid="base.menu_management" href="#">
					<div class="o_app_icon" style="background-image: url('images/module-images/recruitment1.png');"></div>
					
					<div class="o_caption">Recruitment</div>
				</a>
				<a class="o_app o_menuitem" data-menu="95" data-action-model="137" data-action-id="137" data-menu-xmlid="hr.menu_hr_root" href="{{url('/dashboards')}}">

					<div class="o_app_icon" style="background-image: url('images/module-images/employee_list.png');"></div>
					<div class="o_caption">HRM - Employees</div>
				</a>
				<a class="o_app o_menuitem" data-menu="5" data-action-model="35" data-action-id="35" data-menu-xmlid="base.menu_management" href="#menu_id=5&amp;action_id=35">
					<div class="o_app_icon" style="background-image: url('images/module-images/payroll.png');"></div>
					
					<div class="o_caption">Payroll</div>
				</a>
				<a class="o_app o_menuitem" data-menu="95" data-action-model="137" data-action-id="137" data-menu-xmlid="hr.menu_hr_root" href="{{url('/settings')}}">
					<div class="o_app_icon" style="background-image: url('images/module-images/settings.png');"></div>
					
					<div class="o_caption">Settings</div>
				</a>
				<a class="o_app o_menuitem" data-menu="5" data-action-model="35" data-action-id="35" data-menu-xmlid="base.menu_management" href="#menu_id=5&amp;action_id=35">
					<div class="o_app_icon" style="background-image: url('images/module-images/module.png');"></div>
					<div class="o_caption">Module</div>
				</a>
				<a class="o_app o_menuitem" data-menu="95" data-action-model="137" data-action-id="137" data-menu-xmlid="hr.menu_hr_root" href="#menu_id=95&amp;action_id=137">
					<div class="o_app_icon" style="background-image: url('images/module-images/employee_list.png');"></div>
					<div class="o_caption">Another Module</div>
				</a>
			</div>
			<div class="o_home_menu_footer" aria-hidden="true">
			</div>
			<!-- End Module Link -->
			<!-- Employee Profile Start  -->
			<div class="clearfix employee-profile">
				<?php //phpinfo(); ?>


				<div class="col-12" style="margin-top:25px;">
					<div class="col-2 profile-img float-left" id="left">
						<?php if (!empty($employee_image)): ?>
							<img class="float-right " src="{{asset('images/'.$employee_image )}}">
						<?php else: ?>
							<img class="float-right " src="{{asset('images/default.png')}}">
						<?php endif ?>
					</div>
					<div class="col-10 float-left employee-info">
						<h1 style="font-size:25px;"><span class="" name="name" placeholder="Employee's Name">{{isset($employee_data['employee_fullname'])?$employee_data['employee_fullname']:$user->name}} </span></h1>
						<style>
						ul.menu li {
						  display:inline;
						  padding-left: 0px;
						}
						</style>
						<ul  class="menu" style="padding-left: 0px;">
								<li style="padding-right: 30px; font-size: 13px;"><i class="fa fa-suitcase"></i> 
									{{isset($employee_data['designation_name'])?$employee_data['designation_name']:'Not Found!'}}
								</li>
								<li style="padding-right: 30px; font-size: 13px;">
									<i class="fa fa-envelope"></i> {{isset($employee_data['employee_email'])?$employee_data['employee_email']:'Not Found!'}}
								</li>
								<li style="padding-right: 30px; font-size: 13px;">
									<i class="fa fa-phone"></i> {{isset($employee_data['employee_mobile'])?$employee_data['employee_mobile']:'Not Found!'}}
								</li>
								<li style="padding-right: 30px; font-size: 13px;">
									<i class="fa fa-heart"></i> Blood Group <samp style="background-color: #e04d4d; border-radius:4px; padding:0px 5px; color:#fff">
										{{isset($employee_data['employee_blood_group'])?$employee_data['employee_blood_group']:'Not Found!'
								}}</samp>
								</li>
						</ul>

						<table style="width:100%;margin-top: 20px; padding-left: 0px;">

							<tr style="padding-left: 0px;">
								<th style="width: 20%; font-size:13px;"><span>Department</span> </th>
								<th style="width: 20%; font-size:13px;"><span>Section</span> </th>
								<th style="width: 20%; font-size:13px;"><span>Joining Date</span> </th>
								<th style="width: 20%; font-size:13px;"><span>Employee Type</span> </th>
								<th style="width: 20%; font-size:13px;"><span>Reporting To</span> </th>
							</tr>		
							<tr style="padding-left: 0px;">
								<td style="font-size:13px;">
									{{isset($employee_data['department_name'])?$employee_data['department_name']:'Not Found!'}}
								</td>
								<td style="font-size:13px;">
									{{isset($employee_data['section_name'])?$employee_data['section_name']:'Not Found!'}}
								</td>
								<td style="font-size:13px;">
									<?php 
										$joining_date = isset($employee_data['employee_joining_date'])?$employee_data['employee_joining_date']:'';
										$date = date_create($joining_date);
										$Joining=  date_format($date, 'j F, Y');
									 ?>
									{{$Joining}}
								</td>
								<td style="font-size:13px;">
									<?php 
									
										if (!empty($employee_data['employee_type']) && $employee_data['employee_type']==1) {
											$employee_type = 'Permanent';
										}elseif(!empty($employee_data['employee_type']) && $employee_data['employee_type']==2){
											$employee_type = 'Probationary';
										}elseif(!empty($employee_data['employee_type']) && $employee_data['employee_type']==3){
											$employee_type = 'Contractual';
										}
									 ?>
									<span>{{isset($employee_type)?$employee_type:'Not Found!'}}</span>
								</td>
								<td style="font-size:13px;">
									 <span>{{isset($employee_data['reporting_boss'])?$employee_data['reporting_boss']:'Not Found!'}}</span>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="col-12 o_group"></div>
				<div class="" >
					<ul class="nav nav-tabs" id="myTab" role="tablist" >
						<li class="nav-item">
							<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">My Profile</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Leave & Attendance</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="tab-5" data-toggle="tab" href="#tab5" role="tab" aria-controls="contact" aria-selected="false">Performance</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="tab-4" data-toggle="tab" href="#tab4" role="tab" aria-controls="contact" aria-selected="false">Assets</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Payroll</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">File Manager</a>
						</li>
						
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
							<div class="row">
								
								<div class="col-6 col-sm-4 col-md-3">
									<div class="info-box mb-3">
										<span class="info-box-icon bg-success elevation-1"><i class="fa fa-clock-o"></i></span>

										<div class="info-box-content">
											<span class="info-box-text">Present Days</span>
											<span class="info-box-number present_day_count_html"></span>
										</div>
										<div role="separator" class="dropdown-divider"></div>
									</div>
								</div>
								<div class="col-6 col-sm-4 col-md-3">
									<div class="info-box mb-3">
										<span class="info-box-icon bg-warning elevation-1"><i class="fa fa-clock-o"></i></span>

										<div class="info-box-content">
											<span class="info-box-text">Late Day</span>
											<span class="info-box-number late_day_count_html"></span>
										</div>
										<div role="separator" class="dropdown-divider"></div>
									</div>
								</div>
								<div class="clearfix hidden-md-up"></div>
								<div class="col-6 col-sm-4 col-md-3">
									<div class="info-box mb-3">
										<span class="info-box-icon bg-danger elevation-1"><i class="fa fa-clock-o"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Absent Days</span>
											<span class="info-box-number absent_day_count_html"></span>
										</div>
										<div role="separator" class="dropdown-divider"></div>
									</div>
								</div>

								
								
								<div class="clearfix hidden-md-up"></div>

								<div class="col-6 col-sm-4 col-md-3">
									<div class="info-box mb-3">
										<span class="info-box-icon bg-primary elevation-1"><i class="fa fa-clock-o"></i></span>

										<div class="info-box-content">
											<span class="info-box-text"> Leave</span>
											<span class="info-box-number">0</span>
										</div>
										<div role="separator" class="dropdown-divider"></div>
									</div>
								</div>

								<!-- <div class="col-6 col-sm-4 col-md-2">
									<div class="info-box">
										<span class="info-box-icon bg-secondary  elevation-1"><i class="fa fa-clock-o"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Pay Days</span>
											<span class="info-box-number pay_days_html">
											</span>
										</div>
									</div>
								</div> -->

								<!-- <div class="col-6 col-sm-4 col-md-2">
									<div class="info-box mb-3">
										<span class="info-box-icon bg-dark elevation-1"><i class="fa fa-clock-o"></i></span>

										<div class="info-box-content">
											<span class="info-box-text">Holiday</span>
											<span class="info-box-number holiday_count_html"></span>
										</div>
									</div>
								</div> -->
								<!-- <div class="col-6 col-sm-4 col-md-2">
									<div class="info-box mb-3">
										<span class="info-box-icon bg-info elevation-1"><i class="fa fa-clock-o"></i></span>

										<div class="info-box-content">
											<span class="info-box-text">Late Hr.</span>
											<span class="info-box-number late_times_count_html"></span>
										</div>
									</div>
								</div>
								<div class="col-6 col-sm-4 col-md-2">
									<div class="info-box mb-3">
										<span class="info-box-icon bg-alert elevation-1"><i class="fa fa-clock-o"></i></span>

										<div class="info-box-content">
											<span class="info-box-text">Work Hr.</span>
											<span class="info-box-number work_times_count_html"></span>
										</div>
									</div>
								</div> -->
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="col-md-6 float-left" style="padding: 0px;">
										<h6>Attendance Details</h6>
									</div>
									<!-- <div class="col-md-6 float-left daterange-input" style="padding:0px;">
										<input type="text" name="daterange" value="01/01/2018 - 01/15/2018" />
									</div> -->
									<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" style="font-size:12px;">
									  <thead >
									    <tr>
									      <th class="th-sm text-center">Date

									      </th>
									      <th class="th-sm text-center">Shift Time

									      </th>
									      <th class="th-sm text-center">In Time

									      </th>
									      <th class="th-sm text-center">Out Time

									      </th>
									      <th class="th-sm text-center">Late Hr.

									      </th>
									      <th class="th-sm text-center">Work Hr.

									      </th>
									      <th class="th-sm text-center">Status

									      </th>
									    </tr>
									  </thead>
									  <tbody  id="example">
									  	<?php
										  	$tomorrow = date("Y-m-d", time() + 86400);
										  	$begin = new DateTime($month_first_date);
										  	$end = new DateTime($tomorrow);
										  	$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
										  	?>
										  	<?php 
										  	$pay_days_count = 0;
										  	$holiday_count = 0;
										  	$present_day_count = 0;
										  	$late_day_count = 0;
										  	$absent_day_count = 0;
										  	$total_late_time = 0;
										  	$total_work_time = 0;

										  	$late_times = array();
										  	$work_times = array();
										  	$dataLength = 0; 
										  	foreach($daterange as $date){
										  		$dataLength++;
										  		$pay_days_count++;
									  			foreach ($attendance_data as $key => $value){
									  				if (strtotime($date->format("Y-m-d"))==strtotime($value->TransactionDate)) {
														$office_start_time = date('H:i', strtotime($attendance_time->office_start_time));
														$office_end_time = date('H:i', strtotime($attendance_time->office_end_time));
														$intime = date('H:i', strtotime($value->intime));
														$outtime = date('H:i', strtotime($value->outtime));
														if ($intime<=$office_start_time) {
															$late_time = '00:00';
														}else{
															$late_time = strtotime($intime) - strtotime($office_start_time);
															$late_time = date('H:i',$late_time);
														}
														$work_time = strtotime($outtime) - strtotime($intime);
														$work_time = date('H:i',$work_time);
														break;
													}else{
														$office_start_time = date('H:i', strtotime($attendance_time->office_start_time));
														$office_end_time = date('H:i', strtotime($attendance_time->office_end_time));
														$intime = '00:00';
														$outtime = '00:00';
														$late_time = '00:00';
														$work_time = '00:00';
													}
												}
												$office_start = isset($office_start_time)?$office_start_time:'';
												$office_end = isset($office_end_time)?$office_end_time:'';		
												$intime = isset($intime)?$intime:'';		
												$outtime = isset($outtime)?$outtime:'';		
												$late_time = isset($late_time)?$late_time:'';		
												$work_time = isset($work_time)?$work_time:'';	

												$late_times[] = $late_time;
												$work_times[] = $work_time;
											  	?>
											    <tr >
										    		<td class="text-center"> 
										    			{{$date->format("j M, Y")}}
										    		</td>
											      
											      <td class="text-center">{{$office_start.' - '. $office_end}}</td>
											      <td class="text-center">{{$intime}}</td>
											      <td class="text-center">{{$outtime}}</td>
											      <td class="text-center">{{$late_time}}</td>
											      <td class="text-center">{{$work_time}}</td>
											      <td class="text-center">
											      	<?php 
											      	if ($intime!='00:00' && $intime!='' && $intime<=$office_start) {
											      		$present_day_count++;
											      		echo "<span class='btn btn-xs btn-success' style='height:25px;color:#fff;font-weight:bold'>P</span>";
											      	}elseif($intime>$office_start){
											      		$late_day_count++;
											      		echo "<span class='btn btn-xs btn-warning' style='height:25px;color:#fff;font-weight:bold'>L</span>";
											      	}elseif (date('D',strtotime($date->format("Y-m-d"))) == 'Sat' || date('D',strtotime($date->format("Y-m-d"))) == 'Fri') {
											      		$holiday_count++;
											      		echo "<span class='btn btn-xs bg-dark' style='height:25px;color:#ddd;font-weight:bold'>W</span>";
											      	}elseif($intime=='00:00'){
											      		$absent_day_count++;
											      		echo "<span class='btn btn-xs btn-danger' style='height:25px;color:#fff;font-weight:bold'>A</span>";
											      	}else{
											      		echo "-";
											      	}
											      	?>
											      </td>
											    </tr>	
									     <?php	
									     // $total_late_time += $late_time; 
									     // $total_work_time += $work_time; 


									     
										}

									     function AddPlayTime($times) {
									         $minutes = 0; //declare minutes either it gives Notice: Undefined variable
									         // loop throught all the times
									         // echo '<pre>'; print_r($times); 
									         // if ($times != '') {
										         foreach ($times as $time) {
										             list($hour, $minute) = explode(':', $time);
										             $minutes += $hour * 60;
										             $minutes += $minute;
										         }
										         $hours = floor($minutes / 60);
										         $minutes -= $hours * 60;
										         // returns the time already formatted
									         // }
									         return sprintf('%02d:%02d', $hours, $minutes);
									     }

									     // echo AddPlayTime($late_times);
									     // echo AddPlayTime($work_times);
										?>
									    </tr>
									  </tbody>
									</table>
										<?php
											$pay_days = $pay_days_count-$holiday_count; 
											$holiday_count = $holiday_count; 
											$present_day_count = $present_day_count; 
											$late_day_count = $late_day_count; 
											$absent_day_count = $absent_day_count;

											// echo $total_late_time; 
											// echo $total_work_time;
										?>
										<input id="pay_days" type="hidden" value="<?php echo $pay_days ?>">
										<input id="holiday_count" type="hidden" value="<?php echo $holiday_count ?>">
										<input id="present_day_count" type="hidden" value="<?php echo $present_day_count ?>">
										<input id="late_day_count" type="hidden" value="<?php echo $late_day_count ?>">
										<input id="absent_day_count" type="hidden" value="<?php echo $absent_day_count ?>">
										<input id="late_times_count" type="hidden" value="<?php echo AddPlayTime($late_times); ?>">
										<input id="work_times_count" type="hidden" value="<?php echo AddPlayTime($work_times); ?>">
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div>
										<h6>Attendance Graph</h6>
									</div>
									<ul class="nav nav-tabs" id="myTab" role="tablist" style="padding-left: 5px;">
										<li class="nav-item">
											<a class="nav-link active" id="present-tab" data-toggle="tab" href="#present_days" role="tab" aria-controls="present" aria-selected="false">Presents</a>
										</li>
										<li class="nav-item">
											<a class="nav-link " id="home-tab" data-toggle="tab" href="#late_days" role="tab" aria-controls="home" aria-selected="true">Lates</a>
										</li>
										<li class="nav-item">
											<a class="nav-link " id="home-tab" data-toggle="tab" href="#absent_days" role="tab" aria-controls="home" aria-selected="true">Absent</a>
										</li>
										<!-- <li class="nav-item">
											<a class="nav-link " id="home-tab" data-toggle="tab" href="#leave_days" role="tab" aria-controls="home" aria-selected="true">Leaves</a>
										</li>
										<li class="nav-item">
											<a class="nav-link " id="home-tab" data-toggle="tab" href="#weekend_days" role="tab" aria-controls="home" aria-selected="true">Weekend & Holidays</a>
										</li> -->
									</ul>
									<div class="tab-content" id="myTabContent">
										<div class="tab-pane fade show active" id="present_days" role="tabpanel" aria-labelledby="profile-tab">
											<canvas id="presentCanvas" style="height: 400px !important;"></canvas>
										</div>
										<div class="tab-pane fade" id="late_days" role="tabpanel" aria-labelledby="contact-tab">
											<canvas id="lateCanvas" style="height: 400px !important;"></canvas>
										</div>
										<div class="tab-pane fade" id="absent_days" role="tabpanel" aria-labelledby="contact-tab">
											<canvas id="absentCanvas" style="height: 400px !important;"></canvas>
										</div>
										<!-- <div class="tab-pane fade" id="leave_days" role="tabpanel" aria-labelledby="contact-tab">
											<canvas id="leaveCanvas"></canvas>
										</div>
										<div class="tab-pane fade" id="weekend_days" role="tabpanel" aria-labelledby="contact-tab">
											<canvas id="weekendCanvas"></canvas>
										</div> -->
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
							Under Construction 1
						</div>
						<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
							Under Construction 2
						</div>
						<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4">
							Under Construction 3
						</div>
						<div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab5">
							Under Construction 4
						</div>
					</div>
				</div>

			</div>
	</div>
</div>

<!-- Change Password Modal -->


<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePasswordModal" data-whatever="@getbootstrap">Open modal for @getbootstrap</button> -->

<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="false">&times;</span>
        </button>
      </div>
      	<form id="form-change-password" role="form" method="POST" action="{{ route('changePassword') }}" novalidate class="form-horizontal">
      <div class="modal-body">
      	  <div class="col-md-12">             
      	    <label for="current-password" class="col-sm-4 control-label float-left">Current Password<sup style="color:red;">*</sup></label>
      	    <div class="col-sm-8 float-left">
      	      <div class="form-group">
      	        <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
      	        <input type="password" class="form-control" id="current-password" name="current-password" placeholder="Password" required>
      	      </div>
      	    </div>
      	    <label for="password" class="col-sm-4 control-label float-left">New Password<sup style="color:red;">*</sup></label>
      	    <div class="col-sm-8 float-left">
      	      <div class="form-group">
      	        <input type="password" class="form-control" id="password" name="password" placeholder="New Password" data-rule-password="true" required>
      	      </div>
      	    </div>
      	    <label for="password_confirmation" class="col-sm-4 control-label float-left">Re-enter Password<sup style="color:red;">*</sup></label>
      	    <div class="col-sm-8 float-left">
      	      <div class="form-group">
      	        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter Password" data-rule-password_confirmation="true" data-rule-equalTo="#password" required>
      	      </div>
      	    </div>
      	  </div>
      	 <!--  <div class="form-group">
      	    <div class="col-sm-offset-5 col-sm-6">
      	      <button type="submit" class="btn btn-danger">Submit</button>
      	    </div>
      	  </div> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Submit</button>
      </div>
      	</form>
    </div>
  </div>
</div>




</body>

<script>
	<?php if (session('password_change')==0) { ?>
	$('#changePasswordModal').modal({backdrop: 'static', keyboard: false})  
	$(window).on('load',function(){
	       $('#changePasswordModal').modal('show');
	   });
	$('#changePasswordModal').on('hidden.bs.modal', function () {
	 location.reload();
	})
<?php }  ?>
setTimeout(function() {
    $('.anyMessage').fadeOut('slow');
}, 5000); //
$( document ).ready(function() {
	// $('#pay_days').
	// alert();
      var pay_days = $("#pay_days").val();
      $('.pay_days_html').html(pay_days);

		 var holiday_count = $("#holiday_count").val();
      $('.holiday_count_html').html(holiday_count);

      var present_day_count = $("#present_day_count").val();
      // alert(present_day_count);
      $('.present_day_count_html').html(present_day_count);

      var late_day_count = $("#late_day_count").val();
      $('.late_day_count_html').html(late_day_count);

      var absent_day_count = $("#absent_day_count").val();
      $('.absent_day_count_html').html(absent_day_count);

      var late_times_count = $("#late_times_count").val();
      $('.late_times_count_html').html(late_times_count);

      var work_times_count = $("#work_times_count").val();
      $('.work_times_count_html').html(work_times_count);

});

$('#example').paginate({

  // how many items per page
  perPage:      10,    

});

</script>

<style>

	.top-menu-list{
		position: absolute;
		left: 20%;
		top: 0;
		margin: 0px;
		padding: 0px;
	}
	.top-menu-list li{
		list-style: none;
		display: inline-block;
		margin-right: 10px;
	}
	.top-menu-list li a{
		color: #fff;
		line-height: 58px;
		padding: 16px 16px;
		position: relative;
	}
	.top-menu-list li a i{
		font-size: 28px;
	}
    .tooltiptext {
	  visibility: hidden;
	  width: 120px;
	  background-color: black;
	  color: #fff;
	  text-align: center;
	  border-radius: 6px;
	  padding: 5px 0;

	  /* Position the tooltip */
	  position: absolute;
	  z-index: 1;
	  left: 0;
	  top: 90%;
	  line-height: 20px;
	}

	.top-menu-list li a:hover .tooltiptext {
	  visibility: visible;
	}
	.daterangepicker {
		margin-top: 0px;
	}
	.daterange-input input{
		border: 1px solid #ddd;
		margin-bottom: 7px;
		text-align: center;
	}
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
	    background: whitesmoke;
	    box-shadow: 0px 0px 2px 1px #ddd;
	}
	.info-box .info-box-icon {
	    width: 40px;
	    height: 48px;
	    margin-top: 0px;
	}
	.info-box .info-box-text, .info-box .progress-description {
	    font-size: 16px;
	}
	.info-box .info-box-number {
	    font-size: 24px;
	    margin-top: 10px;
	}
	.info-box {
	   padding: 15px 15px;
	}
	.nav-link {
	    padding: 4px 30px;
	}
	.employee-profile {
	    width: 90%;
	}
</style>
<script>
jQuery('.o_user_menu').on('click', function() {
		if (jQuery('.profile-setting').hasClass('show')) {
			$('.profile-setting').removeClass('show');
		}else{
			$('.profile-setting').addClass('show');
		}
	});
	
</script>
<!-- <script src="<?php //echo url(route('pos.jsBaseURLs')); ?>"></script>   -->
<!-- <script src="{{asset('js/app.js')}}"></script> -->

<script type="text/javascript">
	$('.dropdown-toggle').dropdown();







/* present days graph*/

	var chartdata = {
		type: 'bar',
		data: {
			labels: <?php echo json_encode($months); ?>,
		// labels: month,
		datasets: [
		{
			label: 'this year',
			backgroundColor: '#28a745',
			borderWidth: 1,
			data: <?php echo json_encode($data); ?>
		}
		]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	}
	var ctx = document.getElementById('presentCanvas').getContext('2d');
	new Chart(ctx, chartdata);

	/* late days graph*/
	var latedaydata = {
		type: 'bar',
		data: {
			labels: <?php echo json_encode($months); ?>,
		// labels: month,
		datasets: [
		{
			label: 'this year',
			backgroundColor: '#ffc107',
			borderWidth: 1,
			data: <?php echo json_encode($late_data); ?>
		}
		]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	}
	var latedayctx = document.getElementById('lateCanvas').getContext('2d');
	new Chart(latedayctx, latedaydata);

	/* late days graph*/
	var absentdaydata = {
		type: 'bar',
		data: {
			labels: <?php echo json_encode($months); ?>,
		// labels: month,
		datasets: [
		{
			label: 'this year',
			backgroundColor: '#dc3545',
			borderWidth: 1,
			data: <?php echo json_encode($absent_data); ?>
		}
		]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	}
	var absentdayctx = document.getElementById('absentCanvas').getContext('2d');
	new Chart(absentdayctx, absentdaydata);
</script>
