<template>
  <!-- v-if="typsss===1" -->
 <div> 
    <div class="container" v-if="uris['3']=='admin' "> </div>
    <div class="container" v-else >
		<div class="row">
			<div class="col-12 col-sm-12 animate__animated animate__fadeIn col-md-12 col-lg-12 text-center dashboard-heading">
				Gemcon HRIS Dashboard
			</div>
		</div> <!-- heading -->

		<div class="row dashboard-sub-heading">
			<div class="col-12 col-sm-6 col-md-6 col-lg-6 gemcon-established">
				GEMCON GROUP established
			</div>
			<div class="col-12 col-sm-6 col-md-6 col-lg-6 text-right dashboard-year-month-time">
				42 Years 3 Month 5 Days 22 Hours 47 Minutes 17 Seconds
			</div>
		</div> <!-- sub heading -->

		<div class="row">
			<div class="col-12 col-sm-3 col-md-3 col-lg-3 chairman-image pl0 pr0" style="border-left: 2px solid #eee; border-top: 2px solid #eee; border-bottom: 2px solid #eee;">
				<img src="hrms_dashboard/images/Kazi-Shahid_ahmed.jpg" class="float-left" alt="photo" width="80" height="90" style="padding: 5px 2px 2px 5px;">
				<div class="name-title">
					Kazi Shahid Ahmed
				</div>
				<div class="designation-title">
					Chairman
				</div>

				<div class="heading-bg col-sm-12 col-md-12 col-lg-12" style="display: inline-block; border-top: 2px solid #eee;">
					<div class="col-10 col-sm-10 clo-md-10 col-lg-10 float-left">Recruitment & Outgoing Status</div>
					<div class="col-2 col-sm-2 clo-md-2 clo-lg-2 float-right">2021</div>
				</div>

				<!-- <div id="recruitmentOutgoingStatus" class="chart"></div> -->
				<div id="recruitmentOutgoingStatus"></div>


				<div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center"  style="border-top: 2px solid #eee; padding-top: 10px;">
					Employee From
				</div>
				<div id="EmployeeForm"></div>

			</div> <!-- 1st column -->


			<div class="col-12 col-sm-4 col-md-4 col-lg-4 text-center" style="border-left: 2px solid #eee; border-top: 2px solid #eee; border-bottom: 2px solid #eee; padding-top: 10px;">
				<h6>Headcount Today</h6>                
                <!-- Headcount Today Chart -->
                <div class="tree animate__animated animate__bounce">
                	<ul>
                		<li><a href="#">Root <br/><b>2,649</b></a>
                			<ul>
                        <li><a><b>679</b><br/>Administration</a></li>
                        <li><a><b>614</b><br/>Finance</a></li>
                        <li><a><b>413</b><br/>Marketing</a></li>
                        <li><a><b>542</b><br/>Sales</a></li>
                        <li><a><b>401</b><br/>IT</a></li>
                    </ul>
                  </li>
                  </ul>
                  </div>
<!-- Headcount end chart -->



<!-- <div class="card-body"> -->

	<!-- </div> -->


	<div class="row">                    
		<div class="align-self-start col-12 col-sm-6 col-md-6 col-lg-6 text-center bt-2 br-2" style="padding-top: 10px;">
			<h6>Employee by Gender</h6>
			Male<br/>
			<img src="hrms_dashboard/images/male.jpg" alt="" height="80" width="80" style="border-radius: 50%; text-align: center;"><br/>
			1987<br/><br/>
			Female<br/>
			<img src="hrms_dashboard/images/female.jpg" alt="" height="80" width="80" style="border-radius: 50%; text-align: center;"><br/>
			452<br/><br/>

			<!-- All dropdown button -->
			<div class="btn-group btn-block mb-0">
				<button class="btn btn-light btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					All
				</button>
				<div class="dropdown-menu">
					<button class="dropdown-item" type="button">Male</button>
					<button class="dropdown-item" type="button">Female</button>
					<button class="dropdown-item" type="button">Others</button>
				</div>
			</div>

		</div>
		<div class="align-self-left clo-12 col-sm-6 col-md-6 col-lg-6 mb-10 bt-2" style="padding-top: 10px;">
			Employee Age Group

			<!-- <div id="employeeAgeGroup" class="chart"></div> -->
			<div id="EmployeeAgeGroup" style="width: 100%;"></div>

		</div>
	</div>				

</div> <!-- 2nd column -->

<div class="clo-12 col-sm-2 col-md-2 col-lg-2 text-center pl-0 bl-2 bt-2 bb-2" style="padding-right: 0px; padding-top: 10px;">
	<h6>Employee Type</h6>

	<div id="js-pie-chart" class="animate__animated animate__bounceIn" ></div>

	<div class="btn-group btn-block">
		<button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 10px; margin-bottom: 10px;">
			Gemcon Group Corporate
		</button>
		<div class="dropdown-menu" style="font-size: 10px;">
			<button class="dropdown-item" type="button">Engineering</button>
			<button class="dropdown-item" type="button">Gemcon City</button>
			<button class="dropdown-item" type="button">Gemcon Ltd</button>
			<button class="dropdown-item" type="button">Pathar Ltd</button>
			<button class="dropdown-item" type="button">Spcpoles</button>
			<button class="dropdown-item" type="button">Steel</button>
			<button class="dropdown-item" type="button">Organikare</button>
			<button class="dropdown-item" type="button">Meena Bazar</button>
			<button class="dropdown-item" type="button">Meena Click</button>
			<button class="dropdown-item" type="button">MSCL</button>
			<button class="dropdown-item" type="button">GJL</button>
			<button class="dropdown-item" type="button">KKT (PU)</button>
			<button class="dropdown-item" type="button">KKT (Garden)</button>
			<button class="dropdown-item" type="button">KSF</button>
			<button class="dropdown-item" type="button">Others</button>
		</div>
	</div>


	<!-- <div class="chart-gauge"></div>  -->

	<div class="col-12 col-sm-12 col-md-12 col-lg-12" style="border-top: 2px solid #eee; padding-top: 10px;">
		Today's Attendance
	</div>

	<div id="todaysAttendance"></div>
	<!-- <p style="color: #000; font-size: 11px;">Gemcon Group Corporate</p> -->
	<!-- All dropdown button -->
	<div class="btn-group btn-block">
		<button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 10px; margin-bottom: 10px;">
			Gemcon Group Corporate
		</button>
		<div class="dropdown-menu" style="font-size: 10px;">
			<button class="dropdown-item" type="button">Engineering</button>
			<button class="dropdown-item" type="button">Gemcon City</button>
			<button class="dropdown-item" type="button">Gemcon Ltd</button>
			<button class="dropdown-item" type="button">Pathar Ltd</button>
			<button class="dropdown-item" type="button">Spcpoles</button>
			<button class="dropdown-item" type="button">Steel</button>
			<button class="dropdown-item" type="button">Organikare</button>
			<button class="dropdown-item" type="button">Meena Bazar</button>
			<button class="dropdown-item" type="button">Meena Click</button>
			<button class="dropdown-item" type="button">MSCL</button>
			<button class="dropdown-item" type="button">GJL</button>
			<button class="dropdown-item" type="button">KKT (PU)</button>
			<button class="dropdown-item" type="button">KKT (Garden)</button>
			<button class="dropdown-item" type="button">KSF</button>
			<button class="dropdown-item" type="button">Others</button>
		</div>
	</div>

	<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-10 dashboard-chart-heading bt-2" style="padding-top: 10px;">
		<div class="heading-bg text-center">
			Job Confirmation Due List
		</div>

		<table>
			<tr>
				<td>Mostafa Jaman</td>
				<td>&nbsp; &nbsp;</td>
				<td>27 January 2022</td>
			</tr>
			<tr>
				<td>Sharmin Nahar</td>
				<td>&nbsp; &nbsp;</td>
				<td>1 January 2022</td>
			</tr>
			<tr>
				<td>Khalequzzaman</td>
				<td>&nbsp; &nbsp;</td>
				<td>3 January 2022</td>
			</tr>
			<tr>
				<td>Saidur Rahman</td>
				<td>&nbsp; &nbsp;</td>
				<td>12 February 2022</td>
			</tr>
			<tr>
				<td>Mostafa Jaman</td>
				<td>&nbsp; &nbsp;</td>
				<td>27 February 2022</td>
			</tr>
			<tr>
				<td>Sharmin Nahar</td>
				<td>&nbsp; &nbsp;</td>
				<td>1 February 2022</td>
			</tr>
			<tr>
				<td>Khalequzzaman</td>
				<td>&nbsp; &nbsp;</td>
				<td>3 February 2022</td>
			</tr>
			<tr>
				<td>Saidur Rahman</td>
				<td>&nbsp; &nbsp;</td>
				<td>12 February 2022</td>
			</tr>
			<tr>
				<td>Mostafa Jaman</td>
				<td>&nbsp; &nbsp;</td>
				<td>27 February 2022</td>
			</tr>
			<tr>
				<td>Sharmin Nahar</td>
				<td>&nbsp; &nbsp;</td>
				<td>1 February 2022</td>
			</tr>
			<tr>
				<td>Khalequzzaman</td>
				<td>&nbsp; &nbsp;</td>
				<td>3 February 2022</td>
			</tr>
			<tr>
				<td>Saidur Rahman</td>
				<td>&nbsp; &nbsp;</td>
				<td>12 February 2022</td>
			</tr>
			<tr>
				<td>Azibur Rahman</td>
				<td>&nbsp; &nbsp;</td>
				<td>13 February 2022</td>
			</tr>
			<tr>
				<td>Nur Amin Rubel</td>
				<td>&nbsp; &nbsp;</td>
				<td>14 February 2022</td>
			</tr>
			<tr>
				<td>........</td>
				<td></td>
				<td></td>
			</tr>
			<td></td>
		</table>
	</div>
</div> <!-- 3rd column -->


<div class="col-12 col-sm-3 col-md-3 col-lg-3 pr0 pl0" style="border: 2px solid #eee;">
	<!-- <h6>Blood Group Chart</h6> -->

	<!-- partial:index.partial.html -->

	<!-- <h1 class="title">Poll Title</h1> -->
	<div class="chart bb-2" style="padding-left: 10px;">
		<div id="option-1" class="option" >
			<div class="thermometer">
				<div class="results">
					<div class="on">
						<span class="count">90</span>
					</div>
				</div>
			</div>
			<h3 class="option-label">A+</h3>
		</div>
		<div id="option-2" class="option" >
			<div class="thermometer">
				<div class="results">
					<div class="on">
						<span class="count">30</span>
					</div>
				</div>
			</div>
			<h3 class="option-label">O+</h3>
		</div>
		<div id="option-3" class="option" >
			<div class="thermometer">
				<div class="results">
					<div class="on">
						<span class="count">50</span>
					</div>
				</div>
			</div>
			<h3 class="option-label">B+</h3>
		</div>
		<div id="option-4" class="option" >
			<div class="thermometer">
				<div class="results">
					<div class="on">
						<span class="count">35</span>
					</div>
				</div>
			</div>
			<h3 class="option-label">AB+</h3>
		</div>
		<div id="option-5" class="option" >
			<div class="thermometer">
				<div class="results">
					<div class="on">
						<span class="count">40</span>
					</div>
				</div>
			</div>
			<h3 class="option-label">A-</h3>
		</div>
		<div id="option-6" class="option" >
			<div class="thermometer">
				<div class="results">
					<div class="on">
						<span class="count">50</span>
					</div>
				</div>
			</div>
			<h3 class="option-label">O-</h3>
		</div>
		<div id="option-7" class="option" >
			<div class="thermometer">
				<div class="results">
					<div class="on">
						<span class="count">70</span>
					</div>
				</div>
			</div>
			<h3 class="option-label">B-</h3>
		</div>
		<div id="option-8" class="option" >
			<div class="thermometer">
				<div class="results">
					<div class="on">
						<span class="count">80</span>
					</div>
				</div>
			</div>
			<h3 class="option-label">AB-</h3>
		</div>
	</div>

	<!-- partial -->



	<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-10 bb-2" style="padding-left: 20px;">
		<!-- Turnover-December 2021 -->
		<div class="row">                    
			<div class="align-self-left col-4 col-sm-4 col-md-4 col-lg-4 pl0">                    
				<img src="hrms_dashboard/images/turnover-empmoyees.png" alt="" height="80" width="80" style="border: solid 4px #2fa95e; margin-top: 5px;">
			</div>
			<div class="align-self-left col-8 col-sm-8 col-md-8 col-lg-8 mb-10">
				<span style="font-size: 25px; font-weight: 800; color: #f41127;">73 <span style="color:#efefef; font-size: 40px;">|</span> 3.3%</span>

				<span style="font-size: 12px;">Turnover-December 2021</span>

				<!-- <div id="employeeAgeGroup" class="chart"></div> -->

			</div>
		</div>
	</div>
	<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-10 dashboard-chart-heading bb-2">

		<div class="heading-bg text-center">Upcoming Event</div>

		<table>
			<tr>
				<td>Int. Mother Language Day</td>
				<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
				<td>21 February 2022</td>
			</tr>
			<tr>
				<td>Women's Day</td>
				<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
				<td>8 March 2022</td>
			</tr>
			<tr>
				<td>Chairman Sir's Brithday</td>
				<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
				<td>29 July 2022</td>
			</tr>
                        <!-- <tr>
                            <td>Victory Day</td>
                            <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
                            <td>16 December 2020</td>
                        </tr> -->
                        <tr>
                        	<td>........</td>
                        	<td></td>
                        	<td></td>
                        </tr>
                        <td></td>
                    </table>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-10 text-center">
                	Unit Wise Employee Salary
                	<!-- <div id="unitWiseEmployeeSalary" class="chart"></div> -->
                	<div id="UnitWiseEmployeeSalary">
                	</div>
                </div>
            </div> <!-- 4th column -->
        </div>
    </div>












    <div v-if="typsss===1" class="control-section row" style="margin-right: 12px; margin-left: 12px">
      <div>
        <div class="card-body" style="padding:15px 0px;">
          <div class="col-md-6 col-sm-6 col-6 float-left" style="padding:0px;">
            <div id="DataTables_Table_0_length" class="">
                Show
                <label> 
                    <select class="form-control pagination-number" @change="onChange($event)" v-model="paginate_num"  name="pageSize">
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="30">30</option>
                        <option value="35">35</option>
                        <option value="40">40</option>
                        <option value="45">45</option>
                        <option value="50">50</option>
                    </select>
                </label>
                entries
              </div>
          </div>
          <div class="col-md-6 col-sm-6 col-6 float-left" style="padding:0px;">
              <div class="dataTables_filter" id="DataTables_Table_0_filter">
                  <label class="float-right">
                      <div class="input-group"><span class="input-group-addon"><i class="icon-search"></i></span>
                          <input v-on:keyup="getResults" v-model="search_input.search_key" type="text" aria-controls="DataTables_Table_0" class="form-control search-keyword" id="search"  placeholder="Search...">
                      </div>
                  </label>
              </div>
          </div>
            <table id="employeeTable" class="table table-bordered table-striped employeeTable">
              <thead>
              <tr>
              <th class="text-center">SL</th>
              <th v-bind:class="getSortingClass('employee_id_no')" @click="sortingChanged('employee_id_no')">Employee ID <i class="fas fa-sort"></i></th>
              <th v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Employee <i class="fas fa-sort"></i></th>
              <th v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Comp./SBU  <i class="fas fa-sort"></i></th>
              <th v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Department <i class="fas fa-sort"></i></th>
              <th v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Designation <i class="fas fa-sort"></i></th>
              <th v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Separation Type <i class="fas fa-sort"></i></th>
              <th v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Date <i class="fas fa-sort"></i></th>
              <th v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Status <i class="fas fa-sort"></i></th>
              <th>Action</th>
              </tr>
              </thead>
              <tbody v-if="Object.keys(paginate_data.data).length > 0">
              <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
                  <td class="text-center">{{index+1}}</td>
                  <td>{{form_data.employee_id_no}}</td>
                  <td>{{form_data.employee_fullname}}</td>
                  <td>{{form_data.sbu_name}}</td>
                  <td>{{form_data.department_name}}</td>
                  <td>{{form_data.designation_name}}</td>
                  <td>
                    <span>Resignation</span>
                  </td>
                  <td>{{form_data.designation_name}}</td>
                  <td > Requested</td>
                  <td style="padding: 5px 5px; text-align:center">
                    <!-- <button @click="getModalData($event,{dataUrl:'edit/resignation/'+form_data.id},setModalData, add_new_type = 4)" class="btn-xs btn-success" title="Approve" > <i class="fa fa-eye"> </i></button> -->
                    <router-link  :to="'/performance_evaluation/'+form_data.id" class="btn btn-success btn-xs" title="Performance Evaluation">
                      <i class="fa fa-eye"> </i>
                    </router-link>
                  </td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                    <td colspan="14" align="center">No data in database</td>
                </tr>
              </tbody>
            </table>
            <div class="row" style="padding-top:10px;s"> 
                <div class="dataTables_footer clearfix" style="width: 100%">
                    <div class="col-md-6" style="float: left;">
                        <div class="dataTables_info" id="DataTables_Table_0_info">Showing {{paginate_data.current_page}} of {{paginate_data.last_page}} pages</div>
                    </div>
                    <div class="col-md-6" style="float: right;">
                        <div class="dataTables_paginate paging_bootstrap">
                            <pagination :data="paginate_data" :limit="2" @pagination-change-page="getResults"></pagination>
                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>

      <!--  DashboardLayout element declaration -->
      <ejs-dashboardlayout
        id="dashboard_layout"
        :columns="12"
        :cellSpacing="cellSpacing"
        :dragStart="onDragStart"
        :drag="onDrag"
        :dragStop="onDragStop"
        :created="onCreated"
        :change="onChange"
      >
        <e-panels>
        <e-panel
            v-for="(widget_data, index) in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 0 && widget_data.col == 6"
            :sizeX="6"
            :sizeY="3"
            :row="widget_data.row"
            :col="widget_data.col"
            header=""
            :content="line"
          ></e-panel>

          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 0 && widget_data.col == 2"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                        <div class='row box-info'>
                          <div class='col-12 col-sm-12 col-md-12'>
                              <div class='info-box iner_conten'>
                                <span class='info-box-icon bg-info elevation-1 dashboard-imo'> <i class='fas fa-users'></i></span>
                                <div class='info-box-content'>
                                  <a href='dashboards#/d_employees_list/0' style='color:#000;'>
                                  <span class='info-box-text'>Inactive Employee</span>
                                  <span class='info-box-number inactive_employee'>
                                  </span>
                                  </a>
                                </div>
                              </div>
                          </div>
                        </div> 
                  "
          ></e-panel>

          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 0 && widget_data.col == 4"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                        <div class='row box-info'>
                        <div class='col-12 col-sm-12 col-md-12'>
                          <div class='info-box mb-3 iner_conten'>
                            <span class='info-box-icon bg-success elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>
                            <div class='info-box-content'>
                              <a href='dashboards#/d_employees_list/1' style='color:#000;'>
                              <span class='info-box-text'>Active Employee</span>
                              <span class='info-box-number actvie_employee'>123456</span>
                              </a>
                            </div>
                          </div>
                        </div>
                        </div>
                  "
          ></e-panel>

          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 0 && widget_data.col == 0"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                      <div class='row box-info'>   
                          <div class='col-12 col-sm-12 col-md-12'>
                            <div class='info-box mb-3 iner_conten'>
                              <span class='info-box-icon bg-warning elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>
                              <div class='info-box-content'>
                                <a href='dashboards#/d_employees_list/10' style='color:#000;'>
                                <span class='info-box-text'>Total Employee</span>
                                <span class='info-box-number total_employee'></span>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                  "
          ></e-panel>

          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 1 && widget_data.col == 4"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                          <div class='row box-info'>   
                          <div class='col-12 col-sm-12 col-md-12'>
                            <div class='info-box mb-3 iner_conten'>
                                <span class='info-box-icon bg-info elevation-1 dashboard-imo'> <i class='fas fa-users'></i></span>
                              <div class='info-box-content'>
                                <a href='dashboards#/d_employees_list/33' style='color:#000;'>
                                <span class='info-box-text'>Cotractual Emp.</span>
                                <span class='info-box-number contractual_emp'></span>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                  "
          ></e-panel>

          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 1 && widget_data.col == 2"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                      <div class='row box-info'>   
                          <div class='col-12 col-sm-12 col-md-12'>
                            <div class='info-box mb-3 iner_conten'>
                              <span class='info-box-icon bg-warning elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>
                              <div class='info-box-content'>
                                <a href='dashboards#/d_employees_list/22' style='color:#000;'>
                                <span class='info-box-text'>Probationary Emp.</span>
                                <span class='info-box-number probationary_emp'></span>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>

                  "
          ></e-panel>
          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 1 && widget_data.col == 0"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                      <div class='row box-info'>   
                          <div class='col-12 col-sm-12 col-md-12'>
                            <div class='info-box mb-3 iner_conten'>
                              <span class='info-box-icon bg-success elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>
                              <div class='info-box-content'>
                                <a href='dashboards#/d_employees_list/11' style='color:#000;'>
                                <span class='info-box-text'>Permanent Emp.</span>
                                <span class='info-box-number permanent_emp'></span>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                  "
          ></e-panel>

          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 2 && widget_data.col == 4"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
            
                        <div class='row box-info'>   
                          <div class='col-12 col-sm-12 col-md-12'>
                            <div class='info-box mb-3 iner_conten'>
                              <span class='info-box-icon bg-danger elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>
                              <div class='info-box-content'>
                                <a href='dashboards#/d_employees_list/2' style='color:#000;'>
                                <span class='info-box-text'>Separation Emp.</span>
                                <span class='info-box-number separation_emp'></span>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>

                    "
          ></e-panel>
          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 2 && widget_data.col == 2"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                      <div class='row box-info'>   
                          <div class='col-12 col-sm-12 col-md-12'>
                            <div class='info-box mb-3 iner_conten'>
                              <span class='info-box-icon bg-danger elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>
                              <div class='info-box-content'>
                                <a href='dashboards#/d_employees_list/44' style='color:#000;'>
                                <span class='info-box-text'>Temporary Emp.</span>
                                <span class='info-box-number temporary_emp'></span>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>

                  "
          ></e-panel>
          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 2 && widget_data.col == 0"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                      <div class='row box-info'>   
                          <div class='col-12 col-sm-12 col-md-12'>
                            <div class='info-box mb-3 iner_conten'>
                              <span class='info-box-icon bg-warning elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>
                              <div class='info-box-content'>
                                <a href='dashboards#/d_employees_list/55' style='color:#000;'>
                                <span class='info-box-text'>Intern Emp.</span>
                                <span class='info-box-number intern_emp'> 4234</span>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                  "
          ></e-panel>
          <!-- Leve -------------------------------------------------------------------------------------------->

          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 3 && widget_data.col == 0"
            :sizeX="4"
            :sizeY="4"
            :row="widget_data.row"
            :col="widget_data.col"
            header="<div>Leave</div> "
            :content="visitor"
          ></e-panel>
          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 3 && widget_data.col == 4"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                          <div class='row box-info'>
                            <div class='col-12 col-sm-12 col-md-12'>
                              <!-- <a href='dashboards#/companysbu_list' style='color:#000;'> -->
                                <div class='info-box iner_conten'>
                                  <span class='info-box-icon bg-info elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>
                                  <div class='info-box-content'>
                                    <span class='info-box-text'>Leave</span>
                                    <span class='info-box-number leave_emp'>
                                    </span>
                                  </div>
                                </div>
                              <!-- </a> -->
                            </div>
                          </div> 
                    "
          ></e-panel>
          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 4 && widget_data.col == 4"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                          <div class='row box-info'>
                          <div class='col-12 col-sm-12 col-md-12'>
                            <!-- <a href='dashboards#/d_employees_list' style='color:#000;'> -->
                            <div class='info-box mb-3 iner_conten'>
                              <span class='info-box-icon bg-success elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>

                              <div class='info-box-content'>
                                <span class='info-box-text'>Leave2</span>
                                <span class='info-box-number leave_emp'></span>
                              </div>
                            </div>
                          <!-- </a> -->
                          </div>
                          </div>

                    "
          ></e-panel>
          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 5 && widget_data.col == 4"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                        <div class='row box-info'>   
                            <div class='col-12 col-sm-12 col-md-12'>
                              <!-- <a href='dashboards#/d_employees_list' style='color:#000;'> -->
                              <div class='info-box mb-3 iner_conten'>
                                <span class='info-box-icon bg-warning elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>

                                <div class='info-box-content'>
                                  <span class='info-box-text'>Weekend</span>
                                  <span class='info-box-number weekend_day'></span>
                                </div>
                              </div>
                            <!-- </a> -->
                            </div>
                          </div>
                    "
          ></e-panel>
          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 6 && widget_data.col == 4"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                        <div class='row box-info'>   
                            <div class='col-12 col-sm-12 col-md-12'>
                              <!-- <a href='dashboards#/d_employees_list' style='color:#000;'> -->
                              <div class='info-box mb-3 iner_conten'>
                                <span class='info-box-icon bg-warning elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>

                                <div class='info-box-content'>
                                  <span class='info-box-text'>Holiday</span>
                                  <span class='info-box-number holiday_day'></span>
                                </div>
                              </div>
                            <!-- </a> -->
                            </div>
                          </div>
                    "
          ></e-panel>

          <!-- Leve aaaa-------------------------------------------------------------------------------------------->

          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 3 && widget_data.col == 8"
            :sizeX="4"
            :sizeY="4"
            :row="widget_data.row"
            :col="widget_data.col"
            header="<div>Attendance</div> "
            :content="usage"
          ></e-panel>
          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 3 && widget_data.col == 6"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                          <div class='row box-info'>
                            <div class='col-12 col-sm-12 col-md-12'>
                              <!-- <a href='dashboards#/companysbu_list' style='color:#000;'> -->
                                <div class='info-box iner_conten'>
                                  <span class='info-box-icon bg-info elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>
                                  <div class='info-box-content'>
                                    <span class='info-box-text'>Present</span>
                                    <span class='info-box-number present_emp'>
                                        
                                    </span>
                                  </div>
                                </div>
                              <!-- </a> -->
                            </div>
                          </div> 
                    "
          ></e-panel>
          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 4 && widget_data.col == 4"
            :sizeX="2"
            :sizeY="0"
            :row="8"
            :col="6"
            content="
                          <div class='row box-info'>
                          <div class='col-12 col-sm-12 col-md-12'>
                            <!-- <a href='dashboards#/d_employees_list' style='color:#000;'> -->
                            <div class='info-box mb-3 iner_conten'>
                              <span class='info-box-icon bg-success elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>

                              <div class='info-box-content'>
                                <span class='info-box-text'> Late </span>
                                <span class='info-box-number late_emp'></span>
                              </div>
                            </div>
                          <!-- </a> -->
                          </div>
                          </div>

                    "
          ></e-panel>
          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 5 && widget_data.col == 6"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                        <div class='row box-info'>   
                            <div class='col-12 col-sm-12 col-md-12'>
                              <!-- <a href='dashboards#/d_employees_list' style='color:#000;'> -->
                              <div class='info-box mb-3 iner_conten'>
                                <span class='info-box-icon bg-warning elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>

                                <div class='info-box-content'>
                                  <span class='info-box-text'>Absent</span>
                                  <span class='info-box-number absent_emp'></span>
                                </div>
                              </div>
                            <!-- </a> -->
                            </div>
                          </div>
                    "
          ></e-panel>
          <e-panel
            v-for="widget_data in form_data1.dashboard_widget_list"
            v-bind:key="form_data.id"
            v-if="widget_data.row == 6 && widget_data.col == 6"
            :sizeX="2"
            :sizeY="0"
            :row="widget_data.row"
            :col="widget_data.col"
            content="
                        <div class='row box-info'>   
                            <div class='col-12 col-sm-12 col-md-12'>
                              <!-- <a href='dashboards#/d_employees_list' style='color:#000;'> -->
                              <div class='info-box mb-3 iner_conten'>
                                <span class='info-box-icon bg-warning elevation-1 dashboard-imo'><i class='fas fa-users'></i></span>

                                <div class='info-box-content'>
                                  <span class='info-box-text'> Manual Attend. </span>
                                  <span class='info-box-number weekend_day'></span>
                                </div>
                              </div>
                            <!-- </a> -->
                            </div>
                          </div>
                    "
          ></e-panel>
        </e-panels>
      </ejs-dashboardlayout>

      <br />
      <br /><br /><br /><br /><br />
      <!-- <Chart/> -->
      <!-- end of dashboardlayout element -->
    </div>
  </div>
</template>

<script>
import Vue from "vue";
// Import syncfusion dashboardlayout component from layouts package
import { DashboardLayoutPlugin } from "@syncfusion/ej2-vue-layouts";
import { DialogPlugin } from "@syncfusion/ej2-vue-popups";
import { detach, isNullOrUndefined } from "@syncfusion/ej2-base";
// import { ButtonPugin } from "@syncfusion/ej2-vue-buttons";
import activeVisitorTemplate from "./dashboard-layout/activeVisitors.vue";
import visitorsByTypeTempalte from "./dashboard-layout/linetemplate.vue";
// import mapTemplate from "./map.vue";
import useageStatisticsTemplate from "./dashboard-layout/useage.vue";
import splineTemplate from "./dashboard-layout/splinetemplate.vue";
import CreatingPieChart from "./dashboard-layout/creating_pie_chart.vue";
import "@progress/kendo-ui";
import "@progress/kendo-theme-default/dist/all.css";
import { Chart, ChartInstaller } from "@progress/kendo-charts-vue-wrapper";
Vue.use(ChartInstaller);
Vue.use(DialogPlugin);
Vue.use(DashboardLayoutPlugin);
export default {
  components: {
    activeVisitorTemplate,
    CreatingPieChart,
    Chart,
  },
  data: function () {
    return {
      cellSpacing: [7, 35],
      typsss: 0,
      column_4: 4,
      form_data1: "",
      form_data: "",
    };
  },
  created() {
    // this.getWidgetList();
    // this.getWidgetData();
    // this.getWidgetDataChart();
  },
  methods: {
    // console.log(this.form_data);

    getWidgetDataChart(){
       Highcharts.chart('todaysAttendance', {
         	chart: {
         		plotBackgroundColor: null,
         		plotBorderWidth: 0,
         		styledMode: true,
         		plotShadow: false
         	},
         	credits: {
         		enabled: false
         	},
         	title: {
            // text: 'Browser<br>shares<br>2017',
            // align: 'center',
            verticalAlign: 'middle',
            y: 50
        },
        tooltip: {
        	pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
        	point: {
        		valueSuffix: '%'
        	}
        },
        plotOptions: {
        	pie: {
        		dataLabels: {
        			enabled: true,
        			distance: -20,
        			style: {
        				fontWeight: 'bold',
        				color: 'white'
        			}
        		},
        		startAngle: -90,
        		endAngle: 90,
        		center: ['50%', '75%'],
        		size: '120%'
        	}
        },
        series: [{
        	type: 'pie',
        	name: 'Attendance',
        	innerSize: '50%',
        	data: [
        	['P', 57],
        	['A', 15],
                // ['14', 14],
                // ['9', 9],
                ['L', 20], {
                    // name: 'Other',
                    // y: 7.61,
                    dataLabels: {
                    	enabled: false
                    }
                }
                ]
            }]
        });

    },
    getWidgetData() {
      let uri = URL.baseUrl("home_dashboard");
      axios
        .get(uri)
        .then((res) => {
          this.form_data = res.data;
           this.paginate_data = res.data.paginate_data;
          // this.getWidgetList();
          console.log(this.form_data);
          $(".total_employee").text(
            this.form_data.employee_count +
              this.form_data.inactive_employee_count
          );
          $(".actvie_employee").text(this.form_data.employee_count);
          $(".inactive_employee").text(this.form_data.inactive_employee_count);
          $(".permanent_emp").text(this.form_data.permanent_emp);
          $(".probationary_emp").text(this.form_data.probationary_emp);
          $(".contractual_emp").text(this.form_data.contractual_emp);
          $(".temporary_emp").text(this.form_data.temporary_emp);
          $(".intern_emp").text(this.form_data.intern_emp);
          $(".separation_emp").text(this.form_data.resign_semployee_count);
          /* Attendance */
          $(".present_emp").text(this.form_data.present_emp);
          $(".late_emp").text(this.form_data.late_emp);
          $(".absent_emp").text(this.form_data.absent_emp);
          $(".leave_emp").text(this.form_data.leave_emp);
          $(".weekend_day").text(this.form_data.weekend_day);
          $(".holiday_day").text(this.form_data.holiday_day);
        })
        .catch((error) => {
          this.showToster({ status: 0, message: "opps! something went wrong" });
        });
    },

    getWidgetList() {
      let uri = URL.baseUrl("find_widget_list");
      axios
        .get(uri)
        .then((res) => {
          this.form_data1 = res.data;
          console.log(this.form_data1);
        })
        .catch((error) => {
          this.showToster({ status: 0, message: "opps! something went wrong" });
        });
    },

    onDragStart: function (args) {
      console.log("Drag start");
      // console.log(args)
    },

    onDrag: function (args) {
      console.log("Dragging");
      // console.log(args)
    },

    onDragStop: function (args) {
      console.log("Drag Stop");
      // console.log(args)
      // alert('ddd');
      // console.log(args.target)
      // alert(event.target.layerX);
      // console.log(args.event.screenY);
      // console.log(args.helper);

      // console.log( args);
      // console.log(args.target.attributes.data-col);
    },

    onCreated: function (args) {
      // movePanel("id", row, col)
      this.$refs.dashboard.$el.ej2_instances[0].movePanel("layout_0", 1, 0);
      // console.log(this.$refs.dashboard.$el.ej2_instances[0]);
    },
    //Dashboard Layout's change event function
    onChange: function (args) {
      // alert('sss');
      console.log("Change event Triggered");
      console.log(args.changedPanels);
      var data = args.changedPanels;
      // console.log(data);
      let uri = URL.baseUrl("dashboard_update");
      // console.log(uri);
       axios.post(URL.baseUrl("dashboard_update"),
                {
                    temporary_pric:data,
                })
        .then(res => {
            console.log(res);
        })
        .catch(error => {
            this.showToster({ status: 0, message: "1111" });
        });
        
    },
    visitor: function () {
      return { template: activeVisitorTemplate };
    },
    line: function () {
      return { template: visitorsByTypeTempalte };
    },
    usage: function () {
      return { template: useageStatisticsTemplate };
    },
    spline: function () {
      return { template: splineTemplate };
    },
    PieChart: function () {
      return { template: CreatingPieChart };
    },
  },
};
</script>

<style>
@import "./material.css";
/*@import "../node_modules/@syncfusion/ej2-vue-layouts/styles/material.css";*/

/* DashboardLayout element styles  */
#dashboard_layout .e-panel .e-panel-content {
  vertical-align: middle;
  font-weight: 400;
  font-size: 14px !important;
  text-align: center;
  line-height: 80px;
}

#dashboard_layout .e-panel {
  transition: none !important;
}
/*div#layout_1 {
        width: 450.714px !important;
    left: 14.857px !important;
}
div#layout_0 {
    width: 1112.429px !important;
    left: 471.571px !important;
}*/

div#layout_1 {
  /*width: 1036.33px !important;*/
  /*margin-left: 18px !important;*/
  /*height: 275.167px !important;*/
  background: #fff0;
  box-shadow: 0 2px 5px 0 rgb(0 0 0 / 0%);
  box-sizing: border-box;
  position: absolute;
}
div#layout_0 {
  /*width: 520.667px !important;
     margin-left: 18px !important;
     margin-right:  18px !important;*/
  /*height: 275.167px !important;*/
}
.iner_conten {
  height: 125.333px;
}
svg#chart_57723_1_svg {
  margin-top: -89px;
}

.dashboard-imo {
  width: 55px !important;
  height: 105px !important;
}













.pl0{
	padding-left: 0px;
}
.pr0{
	padding-right: 0px;
}
.mb-10{
	margin-bottom: 10px;
}
.bt-2{
	border-top: 2px solid #eee;
}
.bl-2{
	border-left: 2px solid #eee;
}
.br-2{
	border-right: 2px solid #eee;
}
.bb-2{
	border-bottom: 2px solid #eee;
}

.dashboard-heading{
	font-size: 25px;
	color: #000000;
	font-weight: 700;
	text-align: center;
	padding: 15px;
}
.dashboard-sub-heading{
	background: #2fa95e;
	padding: 10px 0px;
	font-size: 14px;
	margin-bottom: 15px;
}
.dashboard-chart-heading{
	/*background: #2fa95e;*/
	padding: 5px;
	font-size: 10px;
	color: #000000;
	/*text-align: center;*/
}
.dashboard-chart-heading table{
	/*background: #2fa95e;*/
	padding: 5px;
	font-size: 10px;
	color: #000000;
	/*text-align: center;*/
}
.gemcon-established{
	font-weight: 600;
	padding-left: 10px;
	/*float: left;*/
}
.dashboard-year-month-time{
	font-weight: 600;
	padding-right: 10px;
}
.chairman-image{
	/*margin: 15px 0px;*/
}
.chairman-image img{
	margin-bottom: 15px;
}
.name-title{
	font-size: 16px;
	font-weight: 700;
	color: #2fa95e;
	margin-left: 10px;
	display: inline-block;
	padding-top: 20px;
}
.designation-title{
	font-size: 14px;
	font-weight: 700;
	color: #000000;
	margin-left: 10px;
	display: inline-block;
}

.heading-bg{
	background: #2fa95e;
	/*background: #000;*/
	color: #fff;
	font-size: 12px;
	padding: 5px 10px;
}
/*.heading-text-left{	
	float: left;
}
.heading-text-right{
	text-align: right;
	float: right;
}*/

@media screen (min-width: 320px) and (max-width: 480px) {
 .pl0{
	padding-left: 15px;
}
.pr0{
	padding-right: 15px;
}
.mb-10{
	margin-bottom: 0px;
}
.bt-2{
	border-top: 0px solid #eee;
}
.bl-2{
	border-left: 0px solid #eee;
}
.br-2{
	border-right: 0px solid #eee;
}
.bb-2{
	border-bottom: 0px solid #eee;
} 
}
@media screen and (min-width: 480px) {
  
}
@media screen and (min-width: 480px) {
  
}


	#option-1 .results .on {
			height: 90%;
		}

		#option-2 .results .on {
			height: 30%;
		}

		#option-3 .results .on {
			height: 50%;
		}

		#option-4 .results .on {
			height: 35%;
		}
		#option-5 .results .on {
			height: 40%;
		}
		#option-6 .results .on {
			height: 50%;
		}
		#option-7 .results .on {
			height: 70%;
		}
		#option-8 .results .on {
			height: 80%;
		}

</style>