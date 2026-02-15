<template>
    <!-- v-if="typsss===1" -->
    <span v-if="this.uris['3']=='admin'">
       <h2 style="text-align: center;"> Admin Panel </h2>
    </span>
    <span v-else-if="this.uris['3']=='payroll'">
        <home_payroll></home_payroll>
        <!-- aaa -->
    </span>
    <span v-else>
      <modal name="myModal" width="50%" height="auto"  :clickToClose="false"> 
        <div v-if="modal_loading">
              <div class="widget-header modal-header">
                  <h4 v-if="this.modal_open_value == 1 "><i class="fa fa-bars"></i> 
                    Job Confirmation Due List
                  </h4>
                  <h4 v-if="this.modal_open_value == 2"><i class="fa fa-bars"></i> 
                    <span v-if="this.upcoming_vent_view == 1"> Event</span>
                    <span v-if="this.upcoming_vent_view == 2">Upcoming Event</span>
                  </h4>
                  <h4 v-if="this.modal_open_value == 3"><i class="fa fa-bars"></i> 
                    Contractual Employee Due List
                  </h4>
                  <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modify-wraper modal-body" style="padding-top: 0px;">
                <div class="">
                      <form class="well form-horizontal needs-validation" novalidate>
                      <div class="row" style="margin:0px; padding-top: 0px;">
                        <div class="col-md-12">
  
                          <table class="upcoming-event table table-striped table-hover" v-if="this.modal_open_value == 1">
                            <template v-if = "red_due_employee != '' || yellow_due_employee != ''">
                              <tr>
                                <th class="text-center" style="width: 7%">ID No.</th>
                                <th class="text-center" style="width: 20%">Name</th>
                                <th class="text-center" style="width: 20%">Designation</th>
                                <th class="text-center" style="width: 25%">Company</th>
                                <th class="text-center" style="width: 10%">Join. Date</th>
                                <th class="text-center" style="width: 10%">Due Date</th>
                                <th class="text-center" style="width: 5%">Action</th>
                              </tr>
                              <tr v-for="due_list in red_due_employee">
                                <td class="text-center" style="color: #d30505;">{{ due_list.employee_id_no  }}</td>
                                <td style="color: #d30505;">{{ due_list.employee_fullname }}</td>
                                <td style="color: #d30505;">{{ due_list.designation_name }}</td>
                                <td style="color: #d30505;">{{ due_list.sbu_name }}</td>
                                <td class="text-center" style="color: #d30505;">{{ due_list.employee_confirmation_due_date }}</td>
                                <td class="text-center" style="color: #d30505;">{{ due_list.employee_joining_date }}</td>
                                <td class="text-center" style="color: #d30505;"><router-link  :to="'/performance_evaluation/'+due_list.id" class="btn btn-success btn-xs" title="Performance Evaluation">
                          <i class="fa fa-eye"> </i>
                        </router-link></td>
                              </tr>
                              <tr v-for="due_list1 in yellow_due_employee">
                                <td class="text-center"  style="color: #28a745;">{{ due_list1.employee_id_no  }}</td>
                                <td style="color: #28a745">{{ due_list1.employee_fullname }} </td>
                                <td style="color: #28a745;">{{ due_list1.designation_name }}</td>
                                <td style="color: #28a745;">{{ due_list1.sbu_name }}</td>
                                <td class="text-center" style="color: #28a745;">{{ due_list1.employee_confirmation_due_date }}</td>
                                <td class="text-center" style="color: #28a745;">{{ due_list1.employee_joining_date }}</td>
                                <td class="text-center"  style="color: #28a745"> <router-link  :to="'/performance_evaluation/'+due_list1.id" class="btn btn-success btn-xs" title="Performance Evaluation">
                          <i class="fa fa-eye"> </i>
                        </router-link> </td>
                              </tr>
                            </template>
                          </table>
  
                          <table class="upcoming-event table table-striped table-hover" v-if="this.modal_open_value == 2">
                            <template v-if = 'upcoming_event != ""'>
                              <tr>
                                <th class="text-center" style="width: 32%">Title</th>
                                <th class="text-center" style="width: 12%">Start Date</th>
                                <th class="text-center" style="width: 12%">End Date</th>
                                <th class="text-center">Details</th>
                              </tr>
                              <tr v-for="event in upcoming_event">
                                <td class="text-left">{{ event.notice_title }}</td>
                                <td class="text-center">{{ event.notice_sdate }}</td>
                                <td class="text-center">{{ event.notice_edate }}</td>
                                <td class="text-left">
                                  <span v-html="event.notice_details"></span>
                                </td>
                              </tr>
                            </template>
                          </table>
  
                          <table class="upcoming-event table table-striped table-hover" v-if="this.modal_open_value == 3">
                            <template v-if = "contractual_red_due_employee != '' || contractual_yellow_due_employee != ''">
                              <tr>
                                <th class="text-center" style="width: 7%">ID No.</th>
                                <th class="text-center" style="width: 20%">Name</th>
                                <th class="text-center" style="width: 20%">Designation</th>
                                <th class="text-center" style="width: 25%">Company</th>
                                <th class="text-center" style="width: 10%">Join. Date</th>
                                <th class="text-center" style="width: 10%">Due</th>
                                <th class="text-center" style="width: 5%">Action</th>
                              </tr>
                              <tr v-for="due_list in contractual_red_due_employee">
                                <td class="text-center" style="color: #d30505;">{{ due_list.employee_id_no  }}</td>
                                <td style="color: #d30505;">{{ due_list.employee_fullname }}</td>
                                <td style="color: #d30505;">{{ due_list.designation_name }}</td>
                                <td style="color: #d30505;">{{ due_list.sbu_name }}</td>
                                <td class="text-center" style="color: #d30505;">{{ due_list.employee_confirmation_due_date }}</td>
                                <td class="text-center" style="color: #d30505;">{{ due_list.employee_joining_date }}</td>
                                <td class="text-center" style="color: #d30505;"><a href="#" @click.prevent="selectedPage ='Foo'"><i class="fa fa-eye"></i></a></td>
                              </tr>
                              <tr v-for="due_list1 in contractual_yellow_due_employee">
                                <td class="text-center"  style="color: #d30505;">{{ due_list1.employee_id_no  }}</td>
                                <td style="color: #28a745">{{ due_list1.employee_fullname }} </td>
                                <td style="color: #d30505;">{{ due_list1.designation_name }}</td>
                                <td style="color: #d30505;">{{ due_list1.sbu_name }}</td>
                                <td class="text-center" style="color: #28a745;">{{ due_list1.employee_confirmation_due_date }}</td>
                                <td class="text-center" style="color: #28a745;">{{ due_list1.employee_joining_date }}</td>
                                <td class="text-center"  style="color: #28a745"> <a href="#" @click.prevent="selectedPage ='Foo'"><i class="fa fa-eye"></i></a> </td>
                              </tr>
                            </template>
                          </table>
                        </div>
                      </div>
                      <div class="form-actions " style="padding:5px 5px 42px 0px;">
                          <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-if="!modal_loading">
            <pageLoading></pageLoading>
        </div>
      </modal>
  
      <!-- {{ this.uris['1'] }}
      {{ this.uris['2'] }}
      {{ this.uris['3'] }} -->
  
      <div style="background: #fff;"> 
          <div class="" style="margin-right: 12px; margin-left: 12px;">
          <div class="row dashboard-sub-heading">
            <div class="col-12 col-sm-3 col-md-3 col-lg-3 gemcon-established text-white">
              GEMCON GROUP established
              <!-- {{ selected_sbu }} -->
            </div>
            <div class="row col-12 col-sm-5 col-md-5 col-lg-5 gemcon-established text-white text-center">
                <select v-model="selected_sbu" class="col-md-5 recruitment-Outgoing" @change="findSbuData($event)">
                  <option v-for="sbu_list in get_sbu_list" :value="sbu_list.id" style="color: #000">{{ sbu_list.sbu_name }}</option>
                </select>
                <div class="col-md-3 recruitment-Outgoing">
                  <input class="form-control date-design" v-model="first_from_date" type="date" placeholder="From Date" title="From Date">
                </div>
                <div @input="date_change_search()" class="col-md-3 recruitment-Outgoing">
                  <input class="form-control date-design" v-model="last_to_date" type="date" placeholder="To Date" title="To Date">
                </div>
                <!-- <select v-if="this.year_search == 1" v-model="selectedYear" class="col-md-2 recruitment-Outgoing text-center" @change="findRecruitingOutgoing($event)" >
                    <option v-for="year_data in yearList" :value="year_data" style="color: #000">{{ year_data }}</option>
                </select> -->
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-4 text-right dashboard-year-month-time text-white">
              {{ this.establishement_date_time }}
              <!-- <Countdown/> -->
            </div>
          </div> <!-- sub heading -->
  
          <div class="row">
            <div class="col-12 col-sm-3 col-md-3 col-lg-3 chairman-image pl0 pr0" style="border-left: 2px solid #eee; border-top: 2px solid #eee; border-bottom: 2px solid #eee;">
              <!-- <img src="hrms_dashboard/images/Kazi-Shahid_ahmed.jpg" class="float-left" alt="photo" width="80" height="90" style="padding: 5px 2px 2px 5px;">
  
              <div class="name-title">
                Late Kazi Shahid Ahmed <br>
              </div> -->
              <!-- <div class="designation-title" style="margin-left: 2%; display: inline-block;">
                The Former Chairman
              </div> -->
  
              
              <div class="heading-bg col-sm-12 col-md-12 col-lg-12" style="display: inline-block; border-top: 2px solid #eee;">
                <div class="col-10 col-sm-10 clo-md-10 col-lg-10 float-left">Recruitment & Outgoing Status</div>
                <div class="col-2 col-sm-2 clo-md-2 clo-lg-2 float-right">
                  <select v-model="selectedYear" class="recruitment-Outgoing" @change="findRecruitingOutgoing($event)" style="border:none !important; padding: 0px;">
                    <option v-for="year in yearList" :value="year" style="color: #000">{{ year }}</option>
                  </select>
                </div>
              </div>
              <div id="RecruitmentOutgoingStatus">
              <!-- <v-col cols="12" sm="8">
                  <v-card class="pa-2" outlined :align="center"> -->
                    <RecruitmentOutgoingStatus_Chart v-bind:ro_chart = this.ro_chart />
                  <!-- </v-card>
                </v-col> -->
              </div >
          
  
              <!-- <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center"  style="border-top: 2px solid #eee; padding-top: 10px;">
                <h6>Employee From</h6>
              </div> -->
              <div class="heading-bg col-sm-12 col-md-12 col-lg-12" style="display: inline-block; border-top: 2px solid #eee;">
                <div class="col-10 col-sm-10 clo-md-10 col-lg-10 float-left">Employee From</div>
                <div class="col-2 col-sm-2 clo-md-2 clo-lg-2 float-right">
                  
                </div>
              </div>
              <!-- <v-container class="lighten-5" id="EmployeeFrom">
                <v-col cols="12" sm="8">
                  <v-card class="pa-2" outlined :align="center"> -->
                    <EmployeeFrom_Chart :chart_from_series = this.chart_from_series :page_loading_from = this.page_loading_from />
                  <!-- </v-card>
                </v-col>
              </v-container> -->
  
             <div class="heading-bg col-sm-12 col-md-12 col-lg-12" style="display: inline-block; border-top: 2px solid #eee;">
                  <div class="text-center" style="z-index:1; position: relative;">Employee Type</div>
                <div class="col-2 col-sm-2 clo-md-2 clo-lg-2 float-right"></div>
              </div> 	
              <br>
  
              <div class="animate__animated animate__rotateIn" style="margin-top: 28%;">
                <!-- <v-container class="lighten-5" id="EmployeeType">
                  <v-col cols="12" sm="8">
                    <v-card class="pa-2" outlined :align="center"> -->
                      <EmployeeType_Chart :seriesData = this.seriesData />
                    <!-- </v-card>
                  </v-col>
                </v-container> -->
              </div>
  
              
  
            </div> <!-- 1st column -->
  
            <div class="col-12 col-sm-4 col-md-4 col-lg-4 text-center" style="border-left: 2px solid #eee; border-top: 2px solid #eee; border-bottom: 2px solid #eee; padding:0px;">
              <!-- <h6>Headcount Today</h6>    -->
              <div class="heading-bg col-sm-12 col-md-12 col-lg-12" style="display: inline-block; border-top: 2px solid #eee;">
                <div class="col-12 col-sm-12 clo-md-12 col-lg-12 float-left">Headcount Today</div>
              </div>             
                      <div class="tree animate__animated animate__bounce">
                        <ul style="padding-top: 30px;">
                          <li style="overflow-x: scroll; height: 30%;">
                            <a href="#" style="width: 30%">All Department <br/>
                              <b>{{ this.total_headcount }}</b>
                            </a>
                            <ul style="width: 3000%">
                              <li v-for="headcount in dept_headcount" :key="headcount.id">
                                <a>
                                  <b>{{headcount.employee_no}}</b>
                                  <br/>{{headcount.department_name}}
                                </a>
                              </li>
                          </ul>
                        </li>
                        </ul>
                        </div>
              <!-- Headcount end chart -->
  
              <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="clear: left; padding: 0px">	
                <div class="col-md-12" style="padding: 0px">
                    <div class="heading-bg col-sm-12 col-md-12 col-lg-12" style="display: inline-block; border-top: 2px solid #eee;">
                      <div class="text-center">Employee by Gender</div>
                    </div>
                    <div class="row col-md-12" style="padding: 15px; padding-bottom: 0px;">
                      <div class="col-4 col-sm-4 clo-md-4">
                        <p> Male</p>
                        <img src="hrms_dashboard/images/male.jpg" alt="photo" height="80" width="80" style="border: solid 2px #28a745; border-radius: 50%; text-align: center;">
                        <p>{{ this.male_employee }}</p>
                      </div>
                      <div class="col-4 col-sm-4 clo-md-4">
                          <p> Female</p>
                          <img src="hrms_dashboard/images/female.jpg" alt="photo" height="80" width="80" style="border: solid 2px #28a745; border-radius: 50%; text-align: center;">
                          <p>{{ this.female_employee}}</p>
                      </div>
                      <div class="col-4 col-sm-4 clo-md-4">
                          <p> Others</p>
                          <img src="hrms_dashboard/images/cisgender.png" alt="photo" height="80" width="80" style="border: solid 2px #28a745; border-radius: 50%; text-align: center; background: #e6e6e6;">
                          <p>{{ this.others_employee}}</p>
                      </div>
                    </div>
                </div>
                <div class="row bt-2" style="margin: 0px;">
                  <div class="col-md-6" style="padding: 0px;min-height: 379px;border: 1px solid #ddd;">
                    <div class="heading-bg text-center">
                      Job Confirmation Due List
                    </div>
                    <table class="upcoming-event" style="font-size: 12px;">
                      <template v-if = "red_due_employee != ''">
                        <tr v-for="due_list in red_due_employee.slice(0, 5)">
                          <td style="color: #d30505;">{{due_list.employee_fullname }} {{ '(' + due_list.employee_id_no + ')'}}</td>
                          <td style="color: #d30505; width: 35%;">{{ due_list.employee_confirmation_due_date }}</td>
                          <td style="color: #d30505;">
                            <router-link  :to="'/performance_evaluation/'+due_list.id" class="btn btn-success btn-xs" title="Performance Evaluation">
                            <i class="fa fa-eye"> </i>
                            </router-link>
                          </td>
                        </tr>
                      </template>
                      <template v-if = "yellow_due_employee != ''">
                        <tr v-for="due_list1 in yellow_due_employee.slice(0, 3)" >
                          <td style="color: #28a745">{{due_list1.employee_fullname }} {{ '(' + due_list1.employee_id_no + ')'}}</td>
                          <td style="color: #28a745; width: 35%;">{{ due_list1.employee_confirmation_due_date }}</td>
                          <td style="color: #28a745"> 
                            <router-link  :to="'/performance_evaluation/'+due_list1.id" class="btn btn-success btn-xs" title="Performance Evaluation">
                            <i class="fa fa-eye"> </i>
                            </router-link>
                           </td>
                        </tr>
                      </template>
                      <tr v-if = "yellow_due_employee != '' || red_due_employee != ''" style="position: absolute; bottom: 0px; right: 0px;">
                        <td colspan="3" style="text-align: right; padding: 5px 0px; cursor: pointer; vertical-align: bottom;">
                          <a @click="getModalData($event, modal_open_value = 1)" class="btn-xs btn-default" title="See more" style="padding: 5px;"> See more... </a>
                        </td>
                      </tr>
                    </table>
                  </div>
  
                  <div class="col-md-6" style="padding: 0px;min-height: 379px;border: 1px solid #ddd;">
                    <div class="heading-bg text-center">
                      Contractual Employee Due List
                    </div>
                    <table class="upcoming-event" style="font-size: 12px;">
                      <template v-if = "contractual_red_due_employee != ''">
                        <tr v-for="contrac_due_list in contractual_red_due_employee.slice(0, 6)">
                          <td style="color: #d30505;">{{contrac_due_list.employee_fullname }} {{ '(' + contrac_due_list.employee_id_no + ')'}}</td>
                          <td style="color: #d30505; width: 35%;">{{ contrac_due_list.employee_confirmation_due_date }}</td>
                          <td style="color: #d30505;"><a href="#" @click.prevent="selectedPage ='Foo'"><i class="fa fa-eye"></i></a></td>
                        </tr>
                      </template>
                      <template v-if = "contractual_yellow_due_employee != ''">
                        <tr v-for="contrac_due_list1 in contractual_yellow_due_employee.slice(0, 3)">
                          <td style="color: #28a745">{{contrac_due_list1.employee_fullname }} {{ '(' + contrac_due_list1.employee_id_no + ')'}}</td>
                          <td style="color: #28a745; width: 35%;">{{ contrac_due_list1.employee_confirmation_due_date }}</td>
                          <td style="color: #28a745"> <a href="#" @click.prevent="selectedPage ='Foo'"><i class="fa fa-eye"></i></a> </td>
                        </tr>
                      </template>
                      <tr v-if = "contractual_yellow_due_employee != '' || contractual_red_due_employee != ''" style="position: absolute; bottom: 0px; right: 0px;">
                        <td colspan="3" style="text-align: right; padding: 5px 0px; cursor: pointer; vertical-align: bottom;">
                          <a @click="getModalData($event, modal_open_value = 3)" class="btn-xs btn-default" title="See more" style="padding: 5px;"> See more... </a>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div> <!-- 2nd column -->
  
            <div class="clo-12 col-sm-2 col-md-2 col-lg-2 text-center pl-0 bl-2 bt-2 bb-2" style="padding-right: 0px;">
              <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="border-top: 2px solid #eee; padding:0px;">
                <div class="heading-bg col-sm-12 col-md-12 col-lg-12" style="display: inline-block; border-top: 2px solid #eee;">
                  <div v-if="this.attendance_view == 1" class="text-center" style="z-index:1; position: relative;"> Attendance</div>
                  <div v-if="this.attendance_view == 2" class="text-center" style="z-index:1; position: relative;">Today's Attendance</div>
                  <div class="col-2 col-sm-2 clo-md-2 clo-lg-2 float-right"></div>
                </div> 
              </div>
              
              <div class="animate__animated animate__rotateIn" style="height: 250px; margin-top: 75px;">
                <!-- <v-container class="lighten-5" id="TodayAttendance">
                  <v-col cols="12" sm="8">
                    <v-card class="pa-2" outlined :align="center"> -->
                      <TodayAttendance_Chart :seriesData_attendance = this.seriesData_attendance />
                    <!-- </v-card>
                  </v-col>
                </v-container> -->
              </div>
  
  
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-10 dashboard-chart-heading bt-2" style="padding:0px;  margin-top: 30px;">
                <div class="heading-bg col-sm-12 col-md-12 col-lg-12" style="display: inline-block; border-top: 2px solid #eee;">
                <div class="text-center" style="z-index:1; position: relative;">Employee Turnover</div>
                <div class="col-2 col-sm-2 clo-md-2 clo-lg-2 float-right"></div>
              </div>
        
                <div class="row" style="padding: 15px;">
                  <div class="align-self-left col-4 col-sm-4 col-md-4 col-lg-4 pl0">
                    <img src="hrms_dashboard/images/turnover-empmoyees.png" alt="" height="80" width="80" style="border: solid 4px #28a745; margin-top: 5px;">
                  </div>
                  <div class="align-self-left col-8 col-sm-8 col-md-8 col-lg-8 mb-10">
                    <span style="font-size: 20px; font-weight: 800; color: #f41127;">{{turn_over_employee.resigned_employee}} <span style="color:#efefef; font-size: 40px;">|</span> {{turn_over_employee.to_employee}}%</span>
                    <span style="font-size: 12px; display: inline-block;">Turnover-{{turn_over_employee.this_year}}</span>
                  </div>
                </div>
              <!-- <div class="animate__animated animate__rotateIn" style="margin-top: 35%;">
                <v-container class="lighten-5" id="EmployeeType">
                  <v-col cols="12" sm="8">
                    <v-card class="pa-2" outlined :align="center">
                      <EmployeeType_Chart :seriesData = this.seriesData />
                    </v-card>
                  </v-col>
                </v-container>
              </div> -->
              
                
                <div class="" style="padding: 0px;">
                  <div class="heading-bg col-sm-12 col-md-12 col-lg-12" style="display: inline-block; border-top: 2px solid #eee;">
                    <div class="text-center">Employee Age Group</div>
                    <div class="col-2 col-sm-2 clo-md-2 clo-lg-2 float-right"></div>
                  </div> 			
             
                  <EmployeeAgeGroup_Chart v-bind:chart_series = this.chart_series />
                </div>
              </div>
            </div>
  
            <div class="col-12 col-sm-3 col-md-3 col-lg-3 pr0 pl0" style="border: 2px solid #eee;">
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 dashboard-chart-heading bb-2" style="padding:0px;">
                <div class="heading-bg text-center" style="border-top: 2px solid #eeeeee;">
                  <span v-if="this.upcoming_vent_view == 1"> Event </span>
                  <span v-if="this.upcoming_vent_view == 2">Upcoming Event</span>
                </div>
                    <table class="upcoming-event">
                      <template v-if = 'upcoming_event != ""'>
                        <tr v-for="event in upcoming_event.slice(0, 3)">
                          <td colspan="2">{{ event.notice_title }}</td>
                          <td>{{ event.notice_sdate }}</td>
                        </tr>
                      </template>
                      <tr v-else>
                        <td colspan="3" style="color:#ca8402; text-align: center; height: 236px;">
                          <i class='fa fa-envelope-open' style='font-size:48px; color:#28a745; '></i>
                          <p style="margin-top: 10px;">{{ 'No upcoming event available right now!' }}</p>
                        </td>
                      </tr>
                      <tr v-if = 'upcoming_event != ""'>
                        <td colspan="3" style="text-align: right; padding: 5px 0px; cursor: pointer;">
                          <a @click="getModalData($event, modal_open_value = 2)" class="btn-xs btn-default" title="See more" style="padding: 5px;"> See more... </a>
                        </td>
                      </tr>
                  </table>
              </div>
           
  
              <div class="heading-bg col-sm-12 col-md-12 col-lg-12" style="display: inline-block; border-top: 2px solid #eee;">
                <div class="text-center" style="z-index:1">Employee Blood Group</div>
              </div> 	
              <div class="chart bb-2" style="padding-left: 10px;">
                <div class="option" v-for="blood_group in employee_blood_group">
                  <div class="thermometer" :title="blood_group.percentage+'%'">
                    <div class="results">
                      <div class="on" :style="'height:'+blood_group.percentage+'%'">
                        <span class="count">{{blood_group.numbers}}</span>
                      </div>
                    </div>
                  </div>
                  <h3 class="option-label">{{blood_group.text}}</h3>
                </div>
              </div>
  
              <!-- partial -->
  
  
  
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 bb-2" style="padding-left: 20px;">
              </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center" style="padding:0px;">
                  <div class="heading-bg col-sm-12 col-md-12 col-lg-12" style="display: inline-block; border-top: 2px solid #eee;">
                    <div class="text-center" style="z-index:1">Unit Wise Employee Salary</div>
                  </div> 	
  
                <!-- <v-container class="lighten-5" id="UnitWiseEmployeeSalary">
                  <v-col cols="12" sm="8">
                    <v-card class="pa-2" outlined :align="center"> -->
                      <UnitWiseEmployeeSalary_Chart/>
                    <!-- </v-card>
                  </v-col>
                </v-container> -->
                </div>
            </div> <!-- 4th column -->
  
              </div> <!-- main row -->
          </div> <!-- container -->
  
          
  
      <!-- v-if="typsss===1"  old code -->
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
                        <td colspan="14" :align="center">No data in database</td>
                    </tr>
                  </tbody>
                </table>
                <div class="row" style="padding-top:10px;"> 
                    <div class="dataTables_footer clearfix" style="width:100%;">
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
  
              <!-- Leve aaaa------------------------------------------------------------------------------------------->
  
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
    </span>
  </template>
  <!-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> -->
  <script>
  import Vue from "vue";
  
  // Import syncfusion dashboardlayout component from layouts package
  import { DashboardLayoutPlugin } from "@syncfusion/ej2-vue-layouts";
  import { DialogPlugin } from "@syncfusion/ej2-vue-popups";
  // import { detach, isNullOrUndefined } from "@syncfusion/ej2-base";
  import activeVisitorTemplate from "./dashboard-layout/activeVisitors.vue";
  import visitorsByTypeTempalte from "./dashboard-layout/linetemplate.vue";
  import useageStatisticsTemplate from "./dashboard-layout/useage.vue";
  import splineTemplate from "./dashboard-layout/splinetemplate.vue";
  import CreatingPieChart from "./dashboard-layout/creating_pie_chart.vue";
  import RecruitmentOutgoingStatus_Chart from "./dashboard-layout/RecruitmentOutgoingStatus_Chart.vue";
  import EmployeeAgeGroup_Chart from "./dashboard-layout/EmployeeAgeGroup_Chart.vue";
  import UnitWiseEmployeeSalary_Chart from "./dashboard-layout/UnitWiseEmployeeSalary_Chart.vue";
  import EmployeeType_Chart from "./dashboard-layout/EmployeeType_Chart.vue";
  import EmployeeFrom_Chart from "./dashboard-layout/EmployeeFrom_Chart.vue";
  import TodayAttendance_Chart from "./dashboard-layout/TodayAttendance_Chart.vue";
  import Countdown from "./dashboard-layout/Countdown.vue";
  
  import "@progress/kendo-ui";
  import "@progress/kendo-theme-default/dist/all.css";
  import { Chart, ChartInstaller } from "@progress/kendo-charts-vue-wrapper";
  import Loading from "./Loading.vue";
  import home_payroll from "./home_payroll.vue";
  Vue.use(ChartInstaller);
  Vue.use(DialogPlugin);
  Vue.use(DashboardLayoutPlugin);
  export default {
    components: {
      pageLoading: Loading,
      home_payroll: home_payroll,
      activeVisitorTemplate,
      CreatingPieChart,
      Chart,
      RecruitmentOutgoingStatus_Chart,
      EmployeeAgeGroup_Chart,
      UnitWiseEmployeeSalary_Chart,
      EmployeeType_Chart,
      EmployeeFrom_Chart,
      TodayAttendance_Chart,
      Countdown,
    },
    data: function () {
      return {
        page_loading_from:false,
        cellSpacing: [7, 35],
        typsss: 0,
        column_4: 4,
        form_data1: "",
        form_data: "",
        uris:"",
        tooltipRender:'',
        center:'',
        date_time: '',
        startYear: 1979,
        endYear: new Date().getFullYear(),
        current_year: new Date().getFullYear(),
        selectedYear: new Date().getFullYear(),
        ro_chart:[],
        total_headcount: 0,
        dept_headcount: [],
        male_employee: 0,
        female_employee: 0,
        others_employee: 0,
        get_sbu_list: [],
        selected_sbu: 0,
        establishement_date_time: [],
        chart_series: [],
        upcoming_event: [],
        red_due_employee: [],
        yellow_due_employee: [],
        employee_blood_group: [],
        turn_over_employee: [],
        all_red_yellow_employee: [],
        modal_open_value: 0,
        sbu_id: 0,
        chart_from_series: [],
        seriesData: [],
        seriesData_attendance: [],
        contractual_red_due_employee: [],
        contractual_yellow_due_employee: [],
        first_from_date: '',
        last_to_date: '',
        year_search: 1,
        attendance_view: 2,
        upcoming_vent_view: 2,
        // first_from_date: new Date().toISOString().slice(0,10),
        last_to_date: new Date().toISOString().slice(0,10),
      };
    },
    computed: {
      yearList() {
        const years = [];
        // years.push('ALL');
        for (let i = this.current_year; i >= this.startYear; i--) {
          years.push(i);
        }
        return years;
      },
    },
    created() {
      this.uris=URL.baseUrl('').split('/');
      if(this.uris['3']!='admin'){
        this.dashboard();
        this.findRecruitingOutgoing(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
        this.employeesFrom(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
        this.todaysAttendance(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
        this.employeeAgeGroup(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
        this.employeesType(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
      }
    },
    methods: {
      findSbuData(event){
        this.sbu_id = event.target.value;
        this.dashboard();
        this.findRecruitingOutgoing(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
        this.employeesFrom(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
        this.todaysAttendance(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
        this.employeeAgeGroup(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
        this.employeesType(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
        // this.date_change_search(this.sbu_id);
      },
      date_change_search(){
        // console.log([this.first_from_date, this.last_to_date]);
        // if(this.first_from_date == '' && this.endYear != ''){
        //   alert('Please select from date at first!');
        //   this.last_to_date = '';
        // }
        // this.yearList = '';
        const d = new Date(this.last_to_date);
        let year = d.getFullYear();
        this.current_year = year;
        this.startYear = year;
        // alert(year);
        if(this.first_from_date == '' && this.last_to_date != ''){
          this.endYear = '';
          this.year_search = 2;
          this.attendance_view = 2;
          this.upcoming_vent_view = 2;
        }
        // else{
        //   this.endYear = this.selectedYear;
        //   this.year_search = 1;
        //   this.first_from_date = '';
        //   this.attendance_view = 2;
        //   this.upcoming_vent_view = 2;
        // }
        if(this.first_from_date == '' && this.last_to_date == ''){
          this.endYear = this.selectedYear;
          this.year_search = 1;
          this.first_from_date = '';
          this.attendance_view = 1;
          this.upcoming_vent_view = 1;
        }
        if(this.first_from_date != '' && this.last_to_date != ''){
          this.endYear = '';
          this.year_search = 2;
          this.attendance_view = 1;
          this.upcoming_vent_view = 1;
        }
        this.dashboard(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
        this.findRecruitingOutgoing(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
        this.employeesFrom(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
        this.todaysAttendance(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
        this.employeeAgeGroup(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
        this.employeesType(this.endYear, this.sbu_id, this.first_from_date, this.last_to_date);
      },
      dashboard(){
        // console.log(sbu_id);
        let uri = URL.baseUrl("find_dashboard_data");
        axios.post(uri, 
          {
            year : this.endYear,
            sbu_id: this.sbu_id,
            first_from_date: this.first_from_date,
            last_to_date: this.last_to_date,
          }
        ).then((res) => {


          this.contractual_red_due_employee = res.data.contractual_red_due_employee;
          this.contractual_yellow_due_employee = res.data.contractual_yellow_due_employee;
          this.all_red_yellow_employee = res.data.all_red_yellow_employee;
          this.turn_over_employee = res.data.turn_over_employee;
          this.employee_blood_group = res.data.employee_blood_group;
          this.upcoming_event = res.data.upcoming_event;
          this.yellow_due_employee = res.data.yellow_due_employee;
          this.red_due_employee = res.data.red_due_employee;
          this.establishement_date_time = res.data.establishement_date_time;
          this.get_sbu_list = res.data.get_sbu_list;
          this.dept_headcount = res.data.dept_headcount;
          this.total_headcount = res.data.total_headcount;
          this.male_employee = res.data.male_employee.employee_no;
          this.female_employee = res.data.female_employee.employee_no;
          this.others_employee = res.data.others_employee.employee_no ?? 0;
        })
        .catch((error) => {
          // this.showToster({ status: 0, message: "All chart data not found! Please search again." });
        });
      },
      findRecruitingOutgoing(event){
        this.page_loading_from = false;
        // console.log();
        if(event.target){
          this.endYear = event.target.value;
        }
        // alert(this.endYear);
        // console.log([this.year,this.sbu_id]);            
        let uri = URL.baseUrl("find_recuiting_outgoing");
        axios.post(uri,
          {
            year : this.endYear,
            sbu_id: this.sbu_id,
            first_from_date: this.first_from_date,
            last_to_date: this.last_to_date,
          }
        )
        .then((res) => {
          this.ro_chart =  res.data;
          // console.log(this.ro_chart);
          this.page_loading_from = true;
        })
        .catch((error) => {
          this.showToster({ status: 0, message: "opps! something went wrong" });
        });
      },
      employeesFrom(){
        this.page_loading_from = false;
        let uri = URL.baseUrl("dashboard_emp_from");
        axios.post(uri,
          {
            year : this.endYear,
            sbu_id: this.sbu_id,
            first_from_date: this.first_from_date,
            last_to_date: this.last_to_date,
          }
        )
        .then((res) => {
            this.chart_from_series = res.data;
            this.page_loading_from = true;
            // console.log([this.chart_from_series, this.pageLoading]);
        })
          .catch((error) => {
            this.showToster({ status: 0, message: "opps! something went wrong" });
          });
      },
      todaysAttendance(){
        let uri = URL.baseUrl("emp_today_attendance");
        axios.post(uri,
          {
            year : this.endYear,
            sbu_id: this.sbu_id,
            first_from_date: this.first_from_date,
            last_to_date: this.last_to_date,
          }
        )
        .then((res) => {
          this.seriesData_attendance = res.data.seriesData;
          console.log();
        })
        .catch((error) => {
          this.showToster({ status: 0, message: "opps! something went wrong" });
        });
      },
      employeesType(){
         // this.page_loading = false;
        let uri = URL.baseUrl("dashboard_emp_type");
        axios.post(uri,
          {
            year : this.endYear,
            sbu_id: this.sbu_id,
            first_from_date: this.first_from_date,
            last_to_date: this.last_to_date,
          }
        )
        .then((res) => {
          this.seriesData = res.data.seriesData;
          // this.page_loading = true;
        })
          .catch((error) => {
            this.showToster({ status: 0, message: "opps! something went wrong" });
            // this.page_loading = true;
          });
      },
      employeeAgeGroup(sbu_id = null){
        // console.log(sbu_id);        
        // console.log('sbu_id');        
        let uri = URL.baseUrl("emp_age_group");
        axios.post(uri,
          {
            year : this.endYear,
            sbu_id: this.sbu_id,
            first_from_date: this.first_from_date,
            last_to_date: this.last_to_date,
          }
        )
        .then((res) => {
          this.chart_series = res.data;
          // console.log(this.chart_series);            
        })
        .catch((error) => {
          this.showToster({ status: 0, message: "opps! something went wrong" });
        });
      },
      getWidgetData() {
        let uri = URL.baseUrl("home_dashboard");
        axios
          .get(uri)
          .then((res) => {
            this.form_data = res.data;
            this.paginate_data = res.data.paginate_data;
            console.log(this.form_data);
            console.log('fff');
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
      },
  
      onCreated: function (args) {
        this.$refs.dashboard.$el.ej2_instances[0].movePanel("layout_0", 1, 0);
      },
      onChange: function (args) {
        console.log("Change event Triggered");
        console.log(args.changedPanels);
        var data = args.changedPanels;
        let uri = URL.baseUrl("dashboard_update");
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
      background: #28a745;
      padding: 10px 0px;
      font-size: 14px;
      margin-bottom: 15px;
  }
  .dashboard-chart-heading{
      /*background: #28a745;*/
      padding: 5px;
      font-size: 12px;
      color: #000000;
      /*text-align: center;*/
  }
  .dashboard-chart-heading table{
      /*background: #28a745;*/
      padding: 5px;
      font-size: 12px;
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
      color: #28a745;
      margin-left: 10px;
      display: inline-block;
      padding-top: 20px;
  }
  .designation-title{
      font-size: 14px;
      font-weight: 700;
      color: #000000;
      margin-left: 10px;
      /*display: inline-block;*/
      display: table-caption;
  }
  
  .heading-bg{
      background: #28a745;
      /*background: #000;*/
      color: #fff;
      font-size: 12px;
      padding: 5px 10px;
  }
  
  
  /* Recruitment Outgoing Status */
  #RecruitmentOutgoingStatus .highcharts-container {
      overflow: hidden;
      margin-left: -20px;
      margin-bottom: -50px;
  }
  #RecruitmentOutgoingStatus .highcharts-text-outline{
      stroke-width: 0px !important;
  }
  
  /* Employee Age Group */
  #EmployeeAgeGroup .highcharts-container{
      overflow: hidden;
      /*margin-left: -20px;*/
      margin-bottom: -50px;
  }
  #EmployeeAgeGroup .highcharts-text-outline{
      stroke-width: 0px !important;
  }
  
  /* Unit Wise Employee Salary */
  #UnitWiseEmployeeSalary .highcharts-container{
      overflow: hidden;
      /*margin-left: -20px;*/
      margin-bottom: -50px;
  }
  /*#UnitWiseEmployeeSalary .highcharts-column-series rect.highcharts-point{
      width: 12px;
  }*/
  .highcharts-point{
      width: 11px;
  }
  
  /* Today's Attendance */
  #TodayAttendance #doughnut-chart{
      height: 200px !important;
  }
  
  
  #TodayAttendance .chartjs-render-monitor{
      /*width: 200px !important;*/
      /*max-width: 100%;*/
      /*height: 200px !important;*/
      padding: 0px 5px 0px 5px !important;
      /*margin-bottom: -22px !important;*/
  }
  
  #EmployeeType #doughnut-chart{
      height: 150px !important;
      margin-top: -20px;
  }
  #EmployeeType .speedometer{
      margin-left: -10px;
      padding: 0px;
      overflow: hidden;
      /*margin-bottom: -50px;*/
  }
  
  @media only screen and (min-width: 320px) and (max-width: 480px) {
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
  
  /* =========== Blood Group Start ============= */
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
  /* =========== Blood Group End ============= */
      .recruitment-Outgoing{
        background: none;
        border: 1px solid #fff !important;
        border-radius: 4px;
        color:#fff;
        outline-color: transparent;
        padding: 5px;
      }
      select:focus-visible{
        border: none;
      }
  
      .recruitment-Outgoing option[value='0']{
        text-align: center;
      }
      /*  upcoming event */
      .upcoming-event {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }
  
      .upcoming-event td, .upcoming-event th {
        border: 1px solid #ddd;
        padding: 8px;
      }
  
      .upcoming-event tr:nth-child(even){background-color: #f2f2f2;}
  
      .upcoming-event tr:hover {background-color: #ddd;}
  
      .upcoming-event th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
      }
  
      .thermometer[title]:hover::after {
        content: attr(title);
        position: absolute;
        top: -42px;
        left: -12px;
        color: #db3f02;
        font-size: 11px;
      }
      .count{
        transform: rotate(268deg);
      }
      .thermometer .results .on .count {
        left: -6px;
        font-size: 11px;
        top: -35px;
      }
      .thermometer > .results {
          height: 100%;
          bottom: -3px;
      }
      .thermometer .results .on {
          bottom: 0px;
      }
      .date-design{
        background: none;
        border: none;
        color: #fff;
        padding: 0px;
        text-align: center;
        height: 20px;
        margin-top: 3px !important;
      }
      .date-design:focus {
        color: #fff;
        background-color: transparent;
        border-bottom: none !important;
      }
      .date-design[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        width: 15px;
        height: 15px;
        padding: 3px 5px 5px 15px;
        text-align: right;
      }
  </style>