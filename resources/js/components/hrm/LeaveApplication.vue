<template>
    <div>
        <div v-if="page_loading" class="widget box">
            <div class="widget-header">
                 <div>
                       <section class="content">
                         <div class="container-fluid">
                           <div class="row">
                             <div class="col-12">
                               <div class="card">
                                 <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                                            <h3 class="card-title d-none d-md-block">Leave Applications</h3>
                                            <span class="float-sm-right" style="float: right;">
                                              <!-- <a class="btn btn-info" href="#" data-toggle="modal" data-target="#addNewLeaveApplication"><i class="fa fa-paper-plane"></i> Apply</a> -->
                                              <div  v-if="lists.apply=='apply'" @click="getModalData($event,{dataUrl:'create/leaveapplication'}, resetModal, add_new_type = 1)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Apply</span> </div>
                                              <div v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/leaveapplication'}, resetModal, add_new_type = 2)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Leave Entry</span> </div>
                                              <div v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/leaveapplication'}, resetModal, add_new_type = 7)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Leave Form</span> </div>
                                                <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                                            </span>
                                        </div>
                                    </div>
                                   <!--  Info boxes -->
                                   <div class="row">
                                     <div class="col-12 col-sm-12 col-md-3" style="max-width: 16.66%;">
                                      <a @click="getDataActiveIctive('team')"  style="color: #000">
                                       <div class="info-box mb-3">
                                         <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-users"></i></span>
    
                                         <div class="info-box-content">
                                           <span class="info-box-text">My Team</span>
                                           <span class="info-box-number">{{lists.my_team_employees}}</span>
                                         </div>
    
                                         <!-- /.info-box-content -->
                                       </div>
                                       </a>
                                       <!-- /.info-box -->
                                     </div>
                                    <div class="col-12 col-sm-12 col-md-3" style="max-width: 16.66%;">
                                      <a @click="getDataActiveIctive('AllRequested')"  style="color: #000">
                                      <div class="info-box">
                                        <span class="info-box-icon bg-secondary elevation-1"><i class="fa fa-list"></i></span>
                                        <div class="info-box-content">
                                          <span class="info-box-text">All Requested</span>
                                          <span class="info-box-number">
                                            {{lists.requestApplications}}
                                            <!-- <small>%</small> -->
                                          </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                      </div>
                                      </a>
                                      <!-- /.info-box -->
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-3" style="max-width: 16.66%;">
                                      <a @click="getDataActiveIctive('Requested')"  style="color: #000">
                                      <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-paper-plane"></i></span>
                                        <div class="info-box-content">
                                          <span class="info-box-text">Requested</span>
                                          <span class="info-box-number">
                                            {{lists.onlyRequested}}
                                            <!-- <small>%</small> -->
                                          </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                      </div>
                                      </a>
                                      <!-- /.info-box -->
                                    </div>
                                     <div class="col-12 col-sm-12 col-md-3" style="max-width: 16.66%;">
                                      <a @click="getDataActiveIctive('Pending')"  style="color: #000">
                                       <div class="info-box">
                                         <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
    
                                         <div class="info-box-content">
                                           <span class="info-box-text">Pending</span>
                                           <span class="info-box-number">
                                             {{lists.pendingApplications}}
                                             <!-- <small>%</small> -->
                                           </span>
                                         </div>
                                         <!-- /.info-box-content -->
                                       </div>
                                       </a>
                                       <!-- /.info-box -->
                                     </div>
                                     <!-- /.col -->
                                     <div class="col-12 col-sm-12 col-md-3" style="max-width: 16.66%;">
                                      <a @click="getDataActiveIctive('Accepted')"  style="color: #000">
                                       <div class="info-box mb-3">
                                         <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>
    
                                         <div class="info-box-content">
                                           <span class="info-box-text">Accepted</span>
                                           <span class="info-box-number">{{lists.acceptedApplications }}</span>
                                         </div>
                                         <!-- /.info-box-content -->
                                       </div>
                                       </a>
                                       <!-- /.info-box -->
                                     </div>
                                     <!-- /.col -->
    
                                     <!-- fix for small devices only -->
                                     <div class="clearfix hidden-md-up"></div>
    
                                     <div class="col-12 col-sm-12 col-md-3" style="max-width: 16.66%;">
                                      <a @click="getDataActiveIctive('Rejected')"  style="color: #000">
                                       <div class="info-box mb-3">
                                         <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-ban"></i></span>
    
                                         <div class="info-box-content">
                                           <span class="info-box-text">Rejected</span>
                                           <span class="info-box-number">{{lists.rejectedApplications}}</span>
                                         </div>
    
                                         <!-- /.info-box-content -->
                                       </div>
                                       </a>
                                       <!-- /.info-box -->
                                     </div>
                                     
                                   <!-- /.row -->
                                 </div>
                                 </div>
                                 <!-- /.card-header -->
                                 <div class="card-body">
                                  <div class="col-md-6 col-sm-6 col-6 float-left" style="padding:0px;">
                                      <div id="DataTables_Table_0_length" class="">
                                          Show
                                          <label> 
                                              <select class="form-control pagination-number" @change="onChange($event)" v-model="paginate_num"  name="pageSize">
                                                 <option value="100000000000000">All</option>
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
                                          <th v-bind:class="getSortingClass('employee_id_no')" @click="sortingChanged('employee_id_no')"> ID<i class="fas fa-sort"></i></th>
                                          <th v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Employee <i class="fas fa-sort"></i></th>
                                          <th v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Designation <i class="fas fa-sort"></i></th>
                                          <th v-bind:class="getSortingClass('department_name')" @click="sortingChanged('department_name')">Department <i class="fas fa-sort"></i></th>
                                          <th v-bind:class="getSortingClass('sbu_name')" @click="sortingChanged('sbu_name')">SBU <i class="fas fa-sort"></i></th>
                                          <th v-bind:class="getSortingClass('leave_apply_date')" @click="sortingChanged('leave_apply_date')">Apply Date <i class="fas fa-sort"></i></th>
                                          <th v-bind:class="getSortingClass('leave_type_name')" @click="sortingChanged('leave_type_name')">Type <i class="fas fa-sort"></i></th>
                                          <th v-bind:class="getSortingClass('leave_from_date')" @click="sortingChanged('leave_from_date')">Date <i class="fas fa-sort"></i></th>
                                          <th v-bind:class="getSortingClass('leave_total_day')" @click="sortingChanged('leave_total_day')">Days <i class="fas fa-sort"></i></th>
                                          <th v-bind:class="getSortingClass('leave_reason')" @click="sortingChanged('leave_reason')">Reason <i class="fas fa-sort"></i></th>
                                          <th v-bind:class="getSortingClass('reliever_name')" @click="sortingChanged('reliever_name')">Reliver <i class="fas fa-sort"></i></th>
                                          <th v-bind:class="getSortingClass('leave_apply_status')" @click="sortingChanged('leave_apply_status')" class="text-center">Status <i class="fas fa-sort"></i></th>
                                          <th>Action</th>
                                        </tr>
                                     </thead>
                                     <tbody v-if="Object.keys(paginate_data.data).length > 0">
                                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
                                         <td class="text-center">{{index+order_no+1}}</td>
                                           <td class="text-center">{{form_data.employee_id_no}}</td>
                                           <td>{{form_data.employee_fullname}}</td>
                                           <td>{{form_data.designation_name}}</td>
                                           <td>{{form_data.department_name}}</td>
                                           <td>{{form_data.sbu_name}}</td>
                                           <td>{{form_data.leave_apply_date}}</td>
                                           <td class="text-center">{{form_data.leave_type_name}}</td>
                                           <td>{{form_data.leave_from_date+' to '+form_data.leave_to_date}}</td>
                                           <td class="text-center">{{form_data.leave_total_day}}</td>
                                           <td>{{form_data.leave_reason}}</td>
                                           <td>{{form_data.reliever_name}}</td>
                                           <td class="text-center" v-if="form_data.leave_apply_status==1" style="color:black;"> Requested</td>
                                           <td class="text-center" v-if="form_data.leave_apply_status==2" style="color:green;"> Approved</td>
                                           <td class="text-center" v-if="form_data.leave_apply_status==3" style="color:blue;"> Forwarded</td>
                                           <td class="text-center" v-if="form_data.leave_apply_status==4" style="color:red;"> Rejected</td>
                                           <td class="text-center" v-if="form_data.leave_apply_status==5" style="color:orange;"> Cancelled</td>
                                           <td class="text-center" v-if="form_data.leave_apply_status==6" style="color:red;"> 
                                            <span style="color:green;">
                                              Approved
                                              <br>
                                            </span>
                                            <span style="color:#e2a700;">
                                              Cancel Request
                                            </span>
                                         </td>
                                         <td style="padding: 5px 5px">
                                            <button v-if="lists.approve=='approve'" @click="getModalData($event,{dataUrl:'edit/leaveapplication/'+form_data.id},setModalData, add_new_type = 5)" class="btn-xs btn-info" title="Approve" > <i class="fa fa-check-circle"> </i></button>
                                            <button v-if="lists.view=='view'" @click="getModalData($event,{dataUrl:'edit/leaveapplication/'+form_data.id},setModalData, add_new_type = 4)" class="btn-xs btn-success" title="Approve" > <i class="fa fa-eye"> </i></button>
                                           <span v-if="form_data.leave_apply_status ==1"> 
                                              <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/leaveapplication/'+form_data.id},setModalData, add_new_type = 3, cancel_application =0)" class="btn-xs btn-info" title="Edit" > <i class="fa fa-edit"> </i></button>
                                           </span>
                                           <!-- <span v-if="form_data.approveParmition==1">d -->
                                            <span v-if="form_data.leave_apply_status == 2"> 
                                                <button v-if="lists.cancel=='cancel'" @click="getModalData($event,{dataUrl:'edit/leaveapplication/'+form_data.id},setModalData, add_new_type = 3, cancel_application =1)" class="btn-xs btn-info" title="Hard Cancel" > <i class="fa fa-times"> </i></button>
                                            </span>
                                            <span v-if="form_data.leave_apply_status == 6"> 
                                                <button v-if="lists.cancel=='cancel'" @click="getModalData($event,{dataUrl:'edit/leaveapplication/'+form_data.id},setModalData, add_new_type = 3, cancel_application =1)" class="btn-xs btn-info" title="Hard Cancel" > <i class="fa fa-times"> </i></button>
                                            </span>
                                           <!-- </span> -->
                                           <span v-if="form_data.leave_apply_status !=1">
                                             <button v-if="lists.edit=='edit'" class="btn-xs btn-info" title="Already Forwarded!" @click="AccessDenied($event,value='Already Forwarded')" style="opacity: 0.5"> <i class="fa fa-edit"> </i></button>
                                           </span>
                                           <span v-if="form_data.leave_apply_status ==1">  
                                            <button  v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/leaveapplication/'+form_data.id})" title="Delete" class="btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                           </span>
                                           <span v-if="form_data.leave_apply_status !=1">
                                             <button v-if="lists.delete=='delete'" class="btn-xs btn-danger" title="Already Forwarded!" @click="AccessDenied($event,value='Already Forwarded')" style="opacity: 0.5"> <i class="fa fa-trash"></i></button>
                                           </span>
                                            
                                         </td>
                                       </tr>
                                     
                                     </tbody>
                                      <tbody v-else>
                                        <tr>
                                            <td colspan="14" align="center">No data in database</td>
                                        </tr>
                                     </tbody>
                                   </table>
                                   <div class="row">
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
                                     <!-- <div class="row">
                                       <div class="dataTables_footer clearfix col-md-12 col-12" style="padding: 10px 0px;">
                                           <div class="col-md-6 col-6 float-left">
                                               <div class="dataTables_info" id="DataTables_Table_0_info">Showing {{paginate_data.current_page}} of {{paginate_data.last_page}} pages</div>
                                           </div>
                                           <div class="col-md-6 col-6 float-right">
                                               <div class="dataTables_paginate paging_bootstrap float-right">
                                                 <pagination :data="paginate_data" @pagination-change-page="getResults"></pagination>
                                               </div>
                                           </div>
                                       </div>
                                   </div> -->
                                 </div>
                                 <!-- /.card-body -->
                               </div>
                               <!-- /.card -->
                             </div>
                             <!-- /.col -->
                           </div>
                           <!-- /.row -->
                         </div>
                         <!-- /.container-fluid -->
                       </section>
                     </div>
    
                       <modal name="myModal"  class="leave_app_model" height="auto"  :clickToClose="false"> 
                          <div v-if="modal_loading">
                              <div class="widget-header modal-header">
                                  <h4 v-if="add_new_type!=5"><i class="fas fa-bars"></i> Leave Application</h4>
                                  <h4 v-if="add_new_type==5"><i class="fas fa-bars"></i> Leave Approval</h4>
                                  <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              </div>
                              <div class="modify-wraper modal-body1">
                                        <div class="col-md-12">
                                            <div class="col-md-12" v-if='add_new_type==2 || add_new_type ==7'>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label>Search Employee</label>
                                                  <vue-select v-model="employee_name_search" :options="option_data.employee_data" @select="onSelectEmployeeSearch" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                </div>
                                              </div>
                                            </div>
                                            <div v-if="add_new_type !=7 && add_new_type !=5" class="row col-md-12">
                                              <div v-if="errors" class="alert alert-danger" style="">
                                                  <div v-for="(error, index) in errors">
                                                      <span v-if="isObject(error)" v-for="err in error">{{err}}</span>
                                                      <span v-if="!isObject(error)">{{error}}</span>
                                                  </div>
                                                </div>
                                              <div class="col-md-6 employee-info-table" style="padding: 15px;">
                                              <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                                                  <tbody>
                                                    <tr>
                                                      <td>Employee ID</td>
                                                      <td>:</td>
                                                      <td>
                                                        <input type="hidden" v-model="form_data.employee_id" name="">
                                                      {{form_data.user_employee_data.employee_id_no}}
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                      <td>Employee Name</td>
                                                      <td>:</td>
                                                      <td>{{form_data.user_employee_data.employee_fullname}}</td>
                                                    </tr>
                                                    <tr>
                                                      <td>Employee Status</td>
                                                      <td>:</td>
                                                      <td>
                                                        <span v-if="form_data.user_employee_data.employee_type == 1">
                                                          {{ 'Permanent' }}
                                                        </span>
                                                        <span v-else-if="form_data.user_employee_data.employee_type == 2">
                                                          {{ 'Probationary' }}
                                                        </span>
                                                        <span v-else-if="form_data.user_employee_data.employee_type == 3">
                                                          {{ 'Cotractual' }}
                                                        </span>
                                                        <span v-else-if="form_data.user_employee_data.employee_type == 4">
                                                          {{ 'Casual' }}
                                                        </span>
                                                        <span v-else-if="form_data.user_employee_data.employee_type == 5">
                                                          {{ 'Temporary' }}
                                                        </span>
                                                        <span v-else-if="form_data.user_employee_data.employee_type == 6">
                                                          {{ 'Intern' }}
                                                        </span>
                                                        <span v-else>{{ '-' }}</span>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                      <td>Designation</td>
                                                      <td>:</td>
                                                      <td>{{form_data.user_employee_data.designation_name}}</td>
                                                    </tr>
                                                    <tr>
                                                      <td>Department</td>
                                                      <td>:</td>
                                                      <td>{{form_data.user_employee_data.department_name}}</td>
                                                    </tr>
                                                    <tr>
                                                      <td>Company/SBU</td>
                                                      <td>:</td>
                                                      <td>{{form_data.user_employee_data.sbu_name}}</td>
                                                    </tr>
                                                    <tr>
                                                      <td>Contact Phone</td>
                                                      <td>:</td>
                                                      <td>
                                                        {{ form_data.user_employee_data.official_mobile_no ?? form_data.user_employee_data.employee_mobile}}
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                      <td>Joining Date</td>
                                                      <td>:</td>
                                                      <td>
                                                        {{ formatCompat(new Date(form_data.user_employee_data.employee_joining_date)) }}
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                      <td>Service Length</td>
                                                      <td>:</td>
                                                      <td>
                                                        {{Number(form_data.user_employee_data.service_length).toFixed(1) + ' Years'}}
                                                      </td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                              </div>
                                              <div  class="col-md-3 leave-info text-center" v-if="add_new_type!=4">
                                                <!-- {{remaining_days}} -->
                                                <h5 style="font-size: 18px; font-weight: bold;" v-if="totalDays || form_data.leave_total_day">
                                                  <span v-if = "!form_data.id">
                                                    {{totalDayss}}
                                                  </span>
                                                   <span v-if = "form_data.id">
                                                    {{ form_data.leave_total_day }}
                                                   </span>
                                                  Days of {{leave_type_value.text}} Leave</h5>
                                                <h6 v-if="remaining_days">{{remaining_days}} days remaining</h6>
                                              </div>
                                                <div class="col-md-3 leave-info text-right" v-if="add_new_type ==1 || add_new_type ==2">
                                                  <span v-if="form_data.user_employee_data">
                                                    <span v-if="form_data.user_employee_data.employee_image">
                                                      <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top:2px; width: 150px; height: 170px;">
                                                    </span>
                                                    <span v-else>
                                                      <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-top: 2px; width: 150px; height: 170px;">
                                                    </span>
                                                  </span>
                                                </div>
                                                <div class="col-md-6 leave-info text-right" v-if="add_new_type==4">
                                                  <table width="100%" class="table table-hover table-bordered table-responsive">
                                                      <thead>
                                                        <tr class="text-center; ">
                                                          <th style="width: 10%;text-align: center;vertical-align: middle;background: #f5f5f5;">Type</th>
                                                          <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Entitle.</th>
                                                          <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Prev. Balance</th>
                                                          <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Total Entitle.</th>
                                                          <th style="width: 15%;text-align: center;vertical-align: middle;background: #f5f5f5;">Availed</th>
                                                          <th style="width: 15%;text-align: center;vertical-align: middle;background: #f5f5f5;">Balance</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>
                                                        <tr  v-for="(form_data, index) in form_data.leaveInfo" v-bind:key="form_data.id">
                                                          <td>{{form_data.leave_type_name }}</td>
                                                          <td class="text-center">{{form_data.entitlementThisYear}}
                                                          </td>
                                                          <td class="text-center"> 
                                                          {{form_data.previousBalance}}
                                                           </td>
                                                          <td class="text-center">
                                                          {{form_data.totalEntitlement}}
                                                          </td>
                                                          <td class="text-center">{{form_data.totalDay}}</td>
                                                          <td class="text-center">{{form_data.balance}}</td>
                                                        </tr>
                                                      </tbody>
                                                  </table>
                                                </div>
                                          </div>
                                    <span v-if="add_new_type==3 || add_new_type==1 || add_new_type==2">
                                     <form class="well form-horizontal needs-validation leave-application" @submit.prevent="add({add:'add/leaveapplication'})">
                                      <input type="hidden" v-model="form_data.employee_id">
                                      <div class="row" style="margin:0px">
                                        <div class="col-md-12">
    
    
                                          <div class="col-md-7 float-left">
                                             <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                                <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Leave Type <span class="required_sign">*</span></label>
                                                </div>
                                                <div class="col-md-8 float-left inputGroupContainer">
                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                   <vue-select v-model="leave_type_value" :options="option_data.leave_type_data" @select="leaveTypeList" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                    </div>
                                                </div>
                                             </div> 
    
                                             <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                                <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Date <span class="required_sign">*</span></label>
                                                </div>
                                                <div class="col-md-8 float-left inputGroupContainer" style="padding-right: 0px;">
                                                   <div class="form-group datepicker-container">
                                                      <div class="col-md-5 float-left" style="padding: 0px;">
                                                         <div class="input-group">
                                                          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                             <div class="col-md-12" style="padding: 0px;">
                                                                <datepicker placeholder="From" @click="updateValue($event.target)"  v-on:input="updateValue($event.target)" v-on:keyup="updateValue($event.target)"  v-model="form_data.leave_from_date" class="form-control"></datepicker>
                                                             </div>
                                                         </div>
                                                      </div>
    
                                                      <div class="col-md-5 float-left" style="padding:0px;">
                                                            <div class="input-group">
                                                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <datepicker placeholder="To"  @click="updateValue($event.target)"  v-on:input="updateValue($event.target)"  v-on:keyup="updateValue($event.target)" v-model="form_data.leave_to_date" class="form-control"></datepicker>
                                                             </div>
                                                            </div>
                                                      </div>
    
                                                      <div class="col-md-2 float-right" style="padding:0px">
                                                         <div class="col-md-12">
                                                            <div class="input-group">
                                                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <span v-if = "!form_data.id">
                                                                  {{totalDays}}
                                                                </span>
                                                                <span v-if = "form_data.id">
                                                                  {{ form_data.leave_total_day }} d
                                                                </span>
                                                             </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                                <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Reason for Leave <span class="required_sign">*</span></label>
                                                </div>
                                                <div class="col-md-8 float-left inputGroupContainer">
                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                   <textarea v-model="form_data.leave_reason" id="city" name="city" placeholder="" class="form-control" required="true" type="text"></textarea>
                                                    </div>
                                                </div>
                                             </div> 
    
                                             <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                                <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Address, on Leave<span class="required_sign">*</span></label>
                                                </div>
                                                <div class="col-md-8 float-left inputGroupContainer">
                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                   <textarea v-model="form_data.address_leave" id="city" name="city" placeholder="" class="form-control" required="true" type="text"></textarea>
                                                    </div>
                                                </div>
                                             </div>
    
                                           <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                              <div class="col-md-4 float-left" style="padding-left: 0px;">
                                              <label class="control-label">Responsibe 
                                                <!-- <span class="required_sign">*</span> -->
                                                </label>
                                              </div>
                                              <div class="col-md-8 float-left inputGroupContainer">
                                                 <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                 <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                  </div>
                                              </div>
                                           </div>
    
                                           <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                              <div class="col-md-4 float-left" style="padding-left: 0px;">
                                              <label class="control-label">Responsible Contact </label>
                                              </div>
                                              <div class="col-md-8 float-left inputGroupContainer">
                                                 <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                  
                                                  <input v-model="form_data.leave_reliever_contact" placeholder="Contact Number" class="form-control"  type="text">
                                                  <!-- <input v-else-if="form_data.official_mobile_no" v-model="form_data.official_mobile_no" placeholder="Contact Number" class="form-control"  type="text">
                                                  <input v-else v-model="form_data.employee_mobile" placeholder="Contact Number" class="form-control"  type="text"> -->
                                                </div>
                                              </div>
                                           </div>
                                           <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                              <div class="col-md-4 float-left" style="padding-left: 0px;">
                                              <label class="control-label">Upload Attachment</label>
                                              </div>
                                              <div class="col-md-8 float-left inputGroupContainer">
                                                 <div class="col-md-4 inputGroupContainer float-left">
                                                  <input type="file" v-on:change="onFileChange"> 
                                                  </div>
                                                 <div v-if="form_data.leave_attachment?form_data.leave_attachment:''" class="col-md-6 float-right text-right">
                                                   <a target="_blank" :href="'/attachments/' + form_data.leave_attachment">View Attachment</a>
                                                 </div>
                                                 <div v-else-if="form_data.leave_attachment==''" class="col-md-6 float-right text-right">
                                                    <p style="color:orange">No attachment found!</p>
                                                 </div>
                                              </div>
                                           </div>
                                          </div>
    
                                          <div class="col-md-5 float-left">
                                            <!-- <h5>Leave Status</h5> -->
                                            <label class="control-label">Leave Status </label>
                                            <table width="100%" class="table table-hover table-bordered table-responsive">
                                                <thead>
                                                  <tr class="text-center; ">
                                                    <th style="width: 10%;text-align: center;vertical-align: middle;background: #f5f5f5;">Type</th>
                                                    <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Entitle.</th>
                                                    <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Prev. Balance</th>
                                                    <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Total Entitle.</th>
                                                    <th style="width: 15%;text-align: center;vertical-align: middle;background: #f5f5f5;">Availed</th>
                                                    <th style="width: 15%;text-align: center;vertical-align: middle;background: #f5f5f5;">Balance</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr  v-for="(form_data, index) in form_data.leaveInfo" v-bind:key="form_data.id">
                                                    <td>{{form_data.leave_type_name }}</td>
                                                    <td class="text-center">{{form_data.entitlementThisYear ?? 0}}
                                                    </td>
                                                    <td class="text-center"> 
                                                    {{form_data.previousBalance ?? 0}}
                                                      </td>
                                                    <td class="text-center">
                                                    {{form_data.totalEntitlement ?? 0}}
                                                    </td>
                                                    <td class="text-center">{{form_data.totalDay ?? 0}}</td>
                                                    <td class="text-center">{{form_data.balance ?? 0}}</td>
                                                  </tr>
                                                </tbody>
                                            </table>
                                            <!-- <table width="100%" class="table table-hover table-bordered table-responsive">
                                                <thead>
                                                  <tr class="text-center; ">
                                                    <th style="width: 10%;text-align: center;vertical-align: middle;background: #f5f5f5;">Type</th>
                                                    <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Entitle.</th>
                                                    <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Prev. Balance</th>
                                                    <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Total Entitle.</th>
                                                    <th style="width: 15%;text-align: center;vertical-align: middle;background: #f5f5f5;">Availed</th>
                                                    <th style="width: 15%;text-align: center;vertical-align: middle;background: #f5f5f5;">Balance</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr  v-for="(form_data, index) in form_data.leaveInfo" v-bind:key="form_data.id">
                                                    <td>{{form_data.leave_type_name }}</td>
                                                    <td class="text-center">{{form_data.entitlementThisYear}}
                                                    </td>
                                                    <td class="text-center"> 
                                                    {{form_data.previousBalance}}
                                                     </td>
                                                    <td class="text-center">
                                                    {{form_data.totalEntitlement}}
                                                    </td>
                                                    <td class="text-center">{{form_data.totalDay}}</td>
                                                    <td class="text-center">{{form_data.balance}}</td>
                                                  </tr>
                                                </tbody>
                                            </table> -->
    
                                              <input type="text" v-model="form_data.designation_name" style="border: none;background: transparent;" readonly>
                                              <br>
                                              <input type="text" v-model="form_data.sbu_name" style="border: none;background: transparent;" readonly>
                                          </div>
                                        </div> 
    
                                          
                                        <!-- hidden field -->
                                          <input type="hidden" v-model="form_data.leave_apply_type" class="lwutpay" name="apply_type"   ><!--  With Pay -->
                                          <input type="hidden" v-model="form_data.leave_apply_type" class="lwutpay" name="apply_type" > <!-- Without Pay -->
                                          <input v-model="form_data.leave_with_holiday" type="hidden" name="leave_holiday" class="leave_holiday"  checked> <!-- No -->
                                          <input v-model="form_data.leave_with_holiday" type="hidden" name="leave_holiday" class="leave_holiday" > <!-- Yes -->
                                        <!-- hidden field -->
                                                  
                                   
                                         </div>
                                      <div class="form-actions col-md-12">
                                        <button type="button" @click="hideModal" class="btn btn-sm btn-default float-left col-md-2" style="margin-left: 15px;">Close</button>
                                        <span v-if="form_data.approveParmition==1 || lists.cancel=='cancel' ">
                                          <input v-if="cancel_application==1" type="submit" tabindex="4" value="Cancel" class="btn btn-sm btn-warning float-right col-md-2">
                                          <input v-if="cancel_application==1" type="submit" tabindex="4" value="Udate" @click="cancelUpdate" class="btn btn-sm btn-info  col-md-2 float-right " style="margin-right: 10px;">
                                        </span>  
                                          <input v-if="cancel_application!=1" type="submit" tabindex="4" value="Apply" class="btn btn-sm btn-info float-right col-md-2">
                                      </div>
                                     </form>
                                    </span>
    
                                     <!-- Approve leave application of employee: modal start from here -->
                                     <!-- Approve leave application of employee: modal start from here -->
    
                                     <span v-else-if="add_new_type==4">
                                      <form class="well form-horizontal needs-validation leave-application">
                                          <div class="row col-md-12">
                                            <div class="col-md-6 employee-info">
                                            <h5>Application Info</h5>
                                            <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive" style="margin-bottom:0px;">
                                                <tbody>
                                                  <tr>
                                                    <td>Apply Date</td>
                                                    <td>:</td>
                                                    <td>{{form_data.created_at_custom}}</td>
                                                  </tr>
                                                   <tr>
                                                    <td>Applied for</td>
                                                    <td>:</td>
                                                    <td>{{leave_type_value.text}}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>From Date</td>
                                                    <td>:</td>
                                                    <td>{{form_data.leave_from_date_custom}}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>To Date</td>
                                                    <td>:</td>
                                                    <td>{{form_data.leave_to_date_custom}}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Total Days</td>
                                                    <td>:</td>
                                                    <td>{{form_data.leave_total_day}} Days</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Reason for Leave</td>
                                                    <td>:</td>
                                                    <td>{{form_data.leave_reason}}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Address, while on Leave </td>
                                                    <td>:</td>
                                                    <td>{{form_data.address_leave}}</td>
                                                  </tr>
                                                 
                                                  
                                                  <!-- <tr>
                                                    <td>Apply Type</td>
                                                    <td>:</td>
                                                    <td>
                                                      <label class="radio-inline" v-if="form_data.leave_apply_type==1">
                                                          With Pay
                                                      </label>
                                                      <label class="radio-inline"  v-if="form_data.leave_apply_type==2">
                                                          Without Pay
                                                      </label>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>Leave with Holiday</td>
                                                    <td>:</td>
                                                    <td>
                                                      <label class="radio-inline" v-if="form_data.leave_with_holiday==0">
                                                          No
                                                      </label>
                                                      <label class="radio-inline" v-if="form_data.leave_with_holiday==1">
                                                          Yes
                                                      </label>
                                                    </td>
                                                  </tr> -->
                                                  <tr>
                                                    <td>Attachment</td>
                                                    <td>:</td>
                                                    <td>
                                                      <label class="">
                                                        <span v-if="form_data.leave_attachment?form_data.leave_attachment:''">
                                                          <a target="_blank" :href="'/attachments/' + form_data.leave_attachment">View Attachment</a>
                                                        </span>
                                                        <span v-else-if="form_data.leave_attachment==''" >
                                                           <p style="color:orange">No attachment found!</p>
                                                        </span>
                                                        </label>                                              
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </div>
                                            <div class="col-md-6 employee-info">
                                            <h5>Responsible Person Info</h5>
                                            <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                                                <tbody>
                                                  <tr>
                                                    <td>Name</td>
                                                    <td>:</td>
                                                    <td>{{employee_name_value.text}}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Designation</td>
                                                    <td>:</td>
                                                    <td>{{employee_name_value.designation_name}}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Contact</td>
                                                    <td>:</td>
                                                    <td>{{form_data.leave_reliever_contact}}</td>
                                                  </tr>
                                                  
                                                </tbody>
                                              </table>
                                            <h5>Approval person Info</h5>
                                            <table  class="table table-hover table-responsive">
                                                <tbody v-for="approveDatas in form_data.approveData">
                                                  <tr> 
                                                    <td colspan="3" >
                                                        <span v-if="approveDatas.leave_approve_status==3">
                                                            <strong> Forwarded </strong>
                                                        </span>
                                                        <span v-if="approveDatas.leave_approve_status==2">
                                                            <strong> Approved </strong>
                                                        </span>
                                                         <span v-if="approveDatas.leave_approve_status==4">
                                                            <strong> Rejected </strong>
                                                        </span>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>Name</td>
                                                    <td>:</td>
                                                    <td>{{approveDatas.employee_fullname}}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Designation</td>
                                                    <td>:</td>
                                                    <td>{{approveDatas.designation_name}}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Contact</td>
                                                    <td>:</td>
                                                    <td>{{approveDatas.employee_mobile}}</td>
                                                  </tr>
                                                   <tr>
                                                    <td>Comment</td>
                                                    <td>:</td>
                                                    <td>{{approveDatas.leave_comments}}</td>
                                                  </tr>
                                                  
                                                </tbody>
                                            </table>
    
                                            </div>
                                        </div>
                                        <br>
                                         <input type="hidden" v-model="form_data.employee_id">
                                        <span v-if="form_data.leave_apply_status !=4">  
                                        <span v-if="form_data.leave_apply_status !=2"> 
                                         <div v-if="form_data.approveParmition==1" class="col-md-12">
                                            <div class="form-group">
                                               <label class="col-md-4 control-label" style="margin-bottom: 10px;">Remarks</label>
                                               <div class="col-md-12 inputGroupContainer">
                                                   <div class="input-group">
                                                     <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                     <textarea v-model="form_data.leave_comments" id="city" name="city" placeholder="Write your comment ......" class="form-control" required="true" type="text"></textarea>
                                                 </div>
                                               </div>
                                            </div>
                                         </div>
                                         <!-- {{ form_data.user_ids}} -->
                                       <div class="form-actions col-md-12" v-if="form_data.approveParmition==1">
                                            <button type="button" @click="add({add:'approveOrReject/leaveapplication'}, form_data.approve_reject_status=1)" class="btn btn-sm btn-success float-right col-md-2">Approve</button>
                                           <button type="button" @click="add({add:'approveOrReject/leaveapplication'},form_data.approve_reject_status=2)" class="btn btn-sm btn-danger float-right col-md-2 offset-md-6" style="margin-right: 10px;">Reject</button>
                                       </div>
                                       </span>
                                        </span>
                                      </form>
                                     </span>
                                     <span v-if="add_new_type==7">
                                        <div class="row form-group">
                                             <div class="col-md-11"></div>
                                             <div class="col-md-1">
                                                <!-- <button  @click="print1()" class="btn-xs btn-info" data-toggle="modal" data-target="#myModal1">Print</button> -->
                                                <button  @click="printDiv()"  data-toggle="modal" data-target="#myModal1">Print</button>
                                             </div>
                                         </div>
                                        <!-- <div id="incom-report" class="row" style="margin-left: 15px;margin-right: 15px;"> -->
                                      <div id="modalInvoice" class="container-fluid modalInvoice" style="margin-left: 0px;font-size: 18px;margin-right: 15px;page-break-before: auto;">
                                          <!-- <div  class="row col-md-12" id="print"  width="100%"> -->
                                         <table  width="100%" cellspacing="0" style="margin-bottom: -10px; " class="table emp_leave_form" border="0" cellpadding="7">
                                              <tbody style="border: 0px solid #343a40;">
                                              <tr valign="bottom">
                                              <td style="background: transparent;vertical-align: middle;" width="105" >
                                                
                                                <p v-if='form_data.user_employee_data.sbu_logo'>
                                                  <img :src="`company_logo/${form_data.user_employee_data.sbu_logo}`" width="100"  >
                                                <!-- <img src="company_logo/group_company_logo.png" width="100" height="60" > -->
                                                </p>
                                              <p v-else>
                                                <img src="company_logo/group_company_logo.png" width="100" height="60" >
                                                </p>
    
                                              </td>
                                              <td style="background: transparent;vertical-align: middle; border: none !important;" colspan="5" width="461">
                                              <!-- <p align="center" style="vertical-align: middle;margin:0px"> <span style="font-family: Arial, serif;"><strong><span style="font-size: xx-large;">Gemcon Group</span></strong></span></p> -->
                                              <p align="center" style="margin-bottom: 0rem;"><span style="font-family: Arial, serif;font-size: x-large;margin-top: -15px !important;"><strong>{{form_data.user_employee_data.sbu_name}}</strong></span></p>
                                              <p align="center" style="margin-bottom: 0px;"><span style="font-family: Arial, serif;font-size: large;margin-top: -25px; margin-bottom: 0px;"><strong>Leave Application Form</strong></span></p>
                                              </td>
                                              <td style="background: transparent;border: none !important;" width="82">
                                              <p>&nbsp;</p>
                                              </td>
                                              </tr>
                                              <tr valign="bottom">
                                              <td style="background: transparent;border: none !important;" colspan="7" width="560">
                                              <p align="right" style="vertical-align: middle;margin:0px;    margin-bottom: 9px;"><span> <strong> Employee ID:  {{form_data.user_employee_data.employee_id_no}}</strong> </span></p>
                                              </td>
                                              </tr>
                                              </tbody>
                                           </table>
                                           <table width="100%" cellspacing="0"  class="table emp_leave_form2" :border="0" cellpadding="7">
                                            
                                              <tbody style="border: 1px solid #343a40 !important;"> 
                                                <tr>
                                                  <td class="basic_info_class" style="width: 18%; border-top: 1px solid #343a40;"> 
                                                    <strong> Applicant's Name </strong> 
                                                  </td>
                                                  <td style="width: 1%;border-top: 1px solid #343a40;"><strong>:</strong></td>
                                                  <td colspan="5" style="width: 85%;border-top: 1px solid #343a40;">
                                                      <strong>{{form_data.user_employee_data.employee_fullname}}</strong>
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td class="basic_info_class" style="width: 14%;border-top: 1px solid #343a40;">
                                                    <strong>Employee Status</strong>
                                                  </td>
                                                  <td style="width: 1%;border-top: 1px solid #343a40;"><strong>:</strong></td>
                                                  <td colspan="5" style="width: 85%;border-top: 1px solid #343a40;">
                                                    <span v-if="form_data.user_employee_data.employee_type == 1">
                                                      {{ 'Permanent' }}
                                                    </span>
                                                    <span v-else-if="form_data.user_employee_data.employee_type == 2">
                                                      {{ 'Probationary' }}
                                                    </span>
                                                    <span v-else-if="form_data.user_employee_data.employee_type == 3">
                                                      {{ 'Cotractual' }}
                                                    </span>
                                                    <span v-else-if="form_data.user_employee_data.employee_type == 4">
                                                      {{ 'Casual' }}
                                                    </span>
                                                    <span v-else-if="form_data.user_employee_data.employee_type == 5">
                                                      {{ 'Temporary' }}
                                                    </span>
                                                    <span v-else-if="form_data.user_employee_data.employee_type == 6">
                                                      {{ 'Intern' }}
                                                    </span>
                                                    <span v-else>{{ '-' }}</span>
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td class="basic_info_class" style="width: 14%;border-top: 1px solid #343a40;">
                                                      <strong>Designation </strong>
                                                  </td>
                                                  <td style="width: 1%;border-top: 1px solid #343a40;"><strong>:</strong></td>
                                                  <td colspan="5" style="width: 85%;border-top: 1px solid #343a40;">
                                                      {{form_data.user_employee_data.designation_name}}
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td class="basic_info_class" style="width: 14%;border-top: 1px solid #343a40;">
                                                      <strong>Department </strong>
                                                  </td>
                                                  <td style="width: 1%;border-top: 1px solid #343a40;"><strong>:</strong></td>
                                                  <td colspan="5" style="width: 85%;border-top: 1px solid #343a40;">
                                                       {{form_data.user_employee_data.department_name}}
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td class="basic_info_class" style="width: 14%;border-top: 1px solid #343a40;">
                                                    <strong>Company/Project</strong>
                                                  </td>
                                                  <td style="width: 1%;border-top: 1px solid #343a40;"><strong>:</strong></td>
                                                  <td  colspan="5" style="width: 85%;border-top: 1px solid #343a40;">
                                                    {{form_data.user_employee_data.sbu_name}}
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td class="basic_info_class" style="width: 14%;border-top: 1px solid #343a40;">
                                                    <strong>Location</strong>
                                                  </td>
                                                  <td style="width: 1%;border-top: 1px solid #343a40;"><strong>:</strong></td>
                                                  <td colspan="5" style="width: 85%;border-top: 1px solid #343a40;">
                                                    {{form_data.user_employee_data.work_location_name}}
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td class="basic_info_class" style="width: 14%;border-top: 1px solid #343a40;">
                                                    <strong>Date of Joining</strong>
                                                  </td>
                                                  <td style="width: 1%;border-top: 1px solid #343a40;"><strong>:</strong></td>
                                                  <td colspan="5" style="width: 85%;border-top: 1px solid #343a40;">
                                                    {{formatCompat(form_data.user_employee_data.employee_joining_date)}}
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td class="basic_info_class" style="width: 14%;border-top: 1px solid #343a40;">
                                                    <strong>Length of Service</strong>
                                                  </td>
                                                  <td style="width: 1%;border-top: 1px solid #343a40;"><strong>:</strong></td>
                                                  <td colspan="5" style="width: 85%;border-top: 1px solid #343a40;">
                                                    {{Number(form_data.user_employee_data.service_length).toFixed(1) + ' Years'}} 
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td class="basic_info_class" style="width: 14%;border-top: 1px solid #343a40;">
                                                      <strong>Applied for</strong>
                                                  </td>
                                                  <td style="width: 1%;border-top: 1px solid #343a40;"><strong>:</strong></td>
                                                  <td colspan="5" style="width: 85%;border-top: 1px solid #343a40;">
    
                                                      <span  style="margin-right: 20px;"> 
                                                        <label class="checkbox-inline" style="margin: 0px;"><input style="margin-right: 4px;" type="checkbox">Annual Leave</label>
                                                      </span>
                                                      <span style="margin-right: 20px;"> 
                                                        <label class="checkbox-inline" style="margin: 0px;"><input style="margin-right: 4px;" type="checkbox">Casual Leave</label>
                                                      </span>
                                                       <span style="margin-right: 20px;"> 
                                                        <label class="checkbox-inline" style="margin: 0px;"><input style="margin-right: 4px;" type="checkbox">Sick Leave</label>
                                                      </span>

                                                       <span style="margin-right: 20px;"> 
                                                        <label class="checkbox-inline" style="margin: 0px;"><input style="margin-right: 4px;" type="checkbox">Without Pay Leave</label>
                                                      </span>
    
                                                      <span style="margin-right: 20px;" v-if="form_data.user_employee_data.employee_gender ==1 " > 
                                                        <label class="checkbox-inline" style="margin: 0px;"><input style="margin-right: 4px;" type="checkbox">Maternity Leave</label>
                                                      </span>
                                                      
                                                  </td>                                              
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
    
                                              
                                                <tr>
                                                  <td class="basic_info_class" style="width: 14%;border-top: 1px solid #343a40;">
                                                   <strong>Period</strong>
                                                  </td>
                                                  <td style="width: 1%;border-top: 1px solid #343a40;"><strong>:</strong></td>
                                                  <td colspan="5" style="width: 85%;border-top: 1px solid #343a40;">
    
                                                      <span  style="margin-right: 5px;"> 
                                                        <label class="checkbox-inline" style="margin: 0px;"><strong> From :</strong> </label>
                                                      </span>
                                                      <span style="margin-right: 0px;"> 
                                                        <input style="width: 147px;text-align: center;border: #000;" type="text"   placeholder="" name="">
                                                      </span>
                                                       <span style="margin-right: 5px;"> 
                                                        <label class="checkbox-inline" style="margin: 0px;"><strong>To :</strong></label>
                                                      </span>
                                                       <span style="margin-right: 0px;">
                                                       <input style="width: 147px;text-align: center;border: #000;" type="text"   placeholder="" name="">
                                                    
    
                                                      </span>
                                                      <span style="margin-right: 42px;"> 
                                                        <label class="checkbox-inline" style="margin: 0px;"><strong> Total  : </strong></label>
                                                      </span>
                                                       <span style="margin-right: 0px;"> 
                                                        <!-- {{totalDays}} -->
                                                        Days
                                                      </span>
                                                      
                                                  </td>             
                                                  
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td class="basic_info_class" style="width: 14%;border-top: 1px solid #343a40;">
                                                        <strong> Reason </strong>
                                                  </td>
                                                  <td style="width: 1%;border-top: 1px solid #343a40;"> : </td>
                                                  <td colspan="5" style="width: 85%;border-top: 1px solid #343a40;">
                                                        
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td class="basic_info_class" style="width: 14%;border-top: 1px solid #343a40;">
                                                    <strong> Contact Phone </strong>
                                                  </td>
                                                  <td style="width: 1%;border-top: 1px solid #343a40;"> : </td>
                                                  <td colspan="5" style="width: 85%;border-top: 1px solid #343a40;">
                                                      {{ form_data.user_employee_data.official_mobile_no ?? form_data.user_employee_data.employee_mobile}}
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td class="basic_info_class" style="width: 14%;border-top: 1px solid #343a40;">
                                                      <strong> Address, while on Leave </strong>
                                                  </td>
                                                  <td style="width: 1%;border-top: 1px solid #343a40;"> : </td>
                                                  <td colspan="5" style="width: 85%;border-top: 1px solid #343a40;">  
                                                    
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td class="basic_info_class" style="width: 14%;border-top: 1px solid #343a40;">
                                                      <strong> Responsibilities hand over to </strong>
                                                  </td>
                                                  <td style="width: 1%;border-top: 1px solid #343a40;"> : </td>
                                                  <td colspan="5" style="width: 85%;border-top: 1px solid #343a40;">  
                                                    
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                            <table width="100%" cellspacing="0"  class="table" border="0" cellpadding="7">
                                              
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr class="text-center; ">
                                                  <td style="width: 16%;vertical-align: middle;background: rgb(245, 245, 245);border: 1px solid #343a40; " :rowspan="form_data.leave_status_rowspan" >
                                                      <strong>Leave Status</strong>
                                                  </td>
                                                  <th style="width: 18%;text-align: center;vertical-align: middle;background: #f5f5f5;border: 1px solid #343a40;">Leave Type</th>
                                                  <th style="width: 14%;text-align: center;vertical-align: middle;background: #f5f5f5;border: 1px solid #343a40;">Entitlement This Year</th>
                                                  <th style="width: 14%;text-align: center;vertical-align: middle;background: #f5f5f5;border: 1px solid #343a40;">Previous Balance</th>
                                                  <th style="width: 14%;text-align: center;vertical-align: middle;background: #f5f5f5;border: 1px solid #343a40;">Total Entitlement</th>
                                                  <th style="width: 14%;text-align: center;vertical-align: middle;background: #f5f5f5;border: 1px solid #343a40;">Availed This Year</th>
                                                  <th style="width: 14%;text-align: center;vertical-align: middle;background: #f5f5f5;border: 1px solid #343a40;">Balance</th>
                                                </tr>
                                                <tr  v-for="(form_data, index) in form_data.leaveInfo" v-bind:key="form_data.id">
                                                  <td style="border: 1px solid #343a40;">{{form_data.leave_type_name }}</td>
                                                  <td style="border: 1px solid #343a40;text-align: center" class="text-center">{{form_data.entitlementThisYear}}
                                                  </td>
                                                  <td style="border: 1px solid #343a40; text-align: center"  class="text-center"> 
                                                  {{form_data.previousBalance}}
                                                   </td>
                                                  <td style="border: 1px solid #343a40; text-align: center" class="text-center">
                                                  {{form_data.totalEntitlement}}
                                                  </td>
                                                  <td style="border: 1px solid #343a40; text-align: center" class="text-center">{{form_data.totalDay}}</td>
                                                  <td style="border: 1px solid #343a40; text-align: center" class="text-center">{{form_data.balance}}</td>
                                                </tr>
    
    
                                                
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td style="background: transparent;border: none !important;" colspan="7" valign="bottom" width="676" >
                                                  <p style="margin-bottom: 1.0rem;">&nbsp;</p>
                                                  </td>
                                                </tr>
                                                <tr valign="bottom">
                                                  <td style="background: transparent;text-align: left;border: none !important;" colspan="3" width="294" >
                                                       <strong> Signature of HR Personnel </strong>
                                                  </td>
                                                  <td style="background: transparent;border: none !important;text-align: right;" colspan="4" width="368">
                                                     <strong> Signature of Applicant with date </strong>
                                                  </td>
                                                </tr>
                                              </tbody>
                                              
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td style="background: rgb(245, 245, 245);text-align: center;border-top: 1px solid #343a40;" colspan="7" width="676" >
                                                        Recommendation (By Immediate Supervisor):
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td  colspan="7" style="background: transparent;border-top: 1px solid #343a40;" >
                                                     <span  style="margin-right: 20px;margin-left: 30%;"> 
                                                        <label class="checkbox-inline" style="margin: 0px;"><input style="margin-right: 4px;" type="checkbox">Recommended</label>
                                                      </span>
                                                      <span style="margin-right: 20px;margin-right: 30%;"> 
                                                        <label class="checkbox-inline" style="margin: 0px;"><input style="margin-right: 4px;" type="checkbox">Not Recommended</label>
                                                      </span>
                                                  </td>
                                                  
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td class="reason_class" style="background: transparent;vertical-align: middle;border-top: 1px solid #343a40;" rowspan="2" width="105" >
                                                      Reason, if not recommended
                                                  </td>
                                                  <td style="background: transparent;vertical-align: middle;border-top: 1px solid #343a40;" rowspan="2" width="105" >
                                                      :
                                                  </td>
                                                  <td style="background: transparent;border-top: 1px solid #343a40;" colspan="5" rowspan="2" valign="bottom" width="557">
                                                      &nbsp;
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr valign="bottom">
                                                  <td  colspan="7" style="background: transparent;border-top: 1px solid #343a40;" width="82">
                                                  <p style="margin-bottom: 1.0rem;">&nbsp;</p>
                                                  </td>
                                                </tr>
                                                <tr valign="bottom">
                                                  <td style="background: transparent;width: 14%;border: none !important" colspan="3" >
                                                      <strong> Name :</strong> 
                                                      <strong v-if="form_data.approvalfristId && form_data.approval2ndId">
                                                         {{form_data.approvalfristId.employee_fullname}}  [ {{form_data.approvalfristId.employee_id_no}} ]
                                                      </strong>
                                                      <!-- <strong v-else-if="form_data.approvalfristId.employee_id_no == form_data.approval2ndId.employee_id_no">
                                                         {{ '' }}
                                                      </strong> -->
                                                  </td>
                                                  <td style="background: transparent;border: none !important;text-align: right;" colspan="4" width="368">
                                                    <strong>Signature with date</strong>
                                                  </td>
                                                </tr>
                                              </tbody>
                                              
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td style="background: rgb(245, 245, 245);text-align: center;border-top: 1px solid #343a40;" colspan="7" width="676">
                                                   Approval: (By Director / CEO / COO / Head of Department / Project In charge)
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td  colspan="7" style="background: transparent;border-top: 1px solid #343a40;" >
                                                     <span  style="margin-right: 20px;margin-left: 36%;"> 
                                                        <label class="checkbox-inline" style="margin: 0px;"><input style="margin: 4px;" type="checkbox">Approved</label>
                                                      </span>
                                                      <span style="margin-right: 20px;margin-right: 30%;"> 
                                                        <label class="checkbox-inline" style="margin: 0px;"><input style="margin: 4px;" type="checkbox">Not Approved</label>
                                                      </span>
                                                  </td>
                                                </tr>
                                              </tbody>
                                              <tbody style="border: 1px solid #343a40;">
                                                <tr>
                                                  <td class="reason_class" style="background: transparent;border-top: 1px solid #343a40;vertical-align: middle;" rowspan="2" width="105" >
                                                      Reason, if not approved
                                                  </td>
                                                  <td style="background: transparent;border-top: 1px solid #343a40;vertical-align: middle;" rowspan="2" width="105" >
                                                      :
                                                  </td>
                                                  <td style="background: transparent;border-top: 1px solid #343a40;" colspan="5" rowspan="2" valign="bottom" width="557">
                                                      &nbsp;
                                                  </td>
                                                </tr>
                                              </tbody>
                                             
                                              <tbody style="border: 1px solid #343a40;">
                                              
                                              <tr valign="bottom">
                                                <td colspan="7" style="background: transparent;border-top: 1px solid #343a40;" width="82">
                                                <p style="margin-bottom: 1.0rem;">&nbsp;</p>
                                                </td>
                                              </tr>
                                              <tr valign="bottom" style="border-top: 0px solid #000;">
                                                <td style="background: transparent;width: 14%;border-top: 0px solid #000;border: none !important" colspan="3" >
                                                  <strong> Name : 
                                                    <span v-if="form_data.approval2ndId">
                                                        {{form_data.approval2ndId.employee_fullname}} 
                                                        [ {{form_data.approval2ndId.employee_id_no}} ] 
                                                    </span>
                                                    <span v-else > 
                                                      <span v-if="form_data.approvalfristId">
                                                        {{form_data.approvalfristId.employee_fullname}}  [ {{form_data.approvalfristId.employee_id_no}} ]
                                                      </span>
                                                    </span>
                                                  </strong>
                                                </td>
                                              
                                                <td style="background: transparent;border-top: 0px solid #000;border: none !important;text-align: right;" colspan="4" width="368">
                                                   <strong>Signature with date</strong>
                                                </td>
                                              </tr>
                                              </tbody>
                                              </table>
                                          <!-- </div> -->
                                      </div>
                                      
    
                                     </span>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
                                       <span v-if="add_new_type==5" >
                                        <div class="row col-md-12" v-if="form_data.user_employee_data" style="margin-left:0px;margin-top: 5px;">
                                          <div class="col-md-1">
                                            <span v-if="form_data.user_employee_data">
                                              <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top:2px; width: 90px; height: 95px; border-radius:35px !important;">
                                            </span>
                                            
                                            <span v-else>
                                              <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-top: 2px; width: 90px; height: 95px; border-radius:35px !important;">
                                            </span>
                                          </div>
                                          <div class="col-md-6" style="margin-top: 25px;margin-bottom: -22px;">
                                            <samp v-if="form_data.approveData">
                                            <span v-for="approveDatas in form_data.approveData">  
                                              <span v-if="approveDatas.leave_approve_status==3">
                                                  <img  :src="`admin_assets/images/blank.png`"  style="margin-top: -19px;position: absolute; width: 120px;    margin-left: 343px;">
                                              </span>
                                              <span v-if="approveDatas.leave_approve_status==2">
                                                 <img  :src="`admin_assets/images/approval.png`"  style="margin-top: -19px; width: 120px;    margin-left: 343px;position: absolute;">
                                              </span>
                                               <span v-if="approveDatas.leave_approve_status==4">
                                                  <img  :src="`admin_assets/images/rejected_icon.png`"  style="margin-top: -19px; width: 120px;     position: absolute;   margin-left: 343px;">
                                              </span>
                                              <!-- <span v-if="approveDatas.leave_approve_status==5">
                                                  <h4 style="color:orange;">Cancelled</h4>
                                              </span> -->
                                            </span>  
                                            </samp>
                                             <samp else >
    
                                                <img  :src="`admin_assets/images/blank.png`"  style="margin-top: -19px; width: 120px;    margin-left: 343px;">
                                             </samp>
    
    
                                            
    
                                            <h4 style="color:#6f6d6d; margin-top: 23px;    font-weight: 400 !important;margin-left: 28px;">{{form_data.user_employee_data.employee_fullname}}</h4>
                                          </div>
                                        
                                          <div class="col-md-5 text-right" style="font-size: 14px;color: rgb(111, 109, 109);padding-top: 24px;padding-right: 93px;">
                                            <i class="fa fa-check-circle" aria-hidden="true" style="margin-left:-22px;color: #90c53c;font-size: 14px;"></i>
                                            <span>There are</span> <br>
                                            <span style="color: rgb(8 167 255);">{{form_data.conflictsNo}} Conflicts</span><br>
                                            <span>with this request</span>
                                          </div>
    
                                        </div>
    
                                        <div class="row col-md-12" v-if="form_data.user_employee_data" style="margin-left:0px; margin-top: 0px !important;">
                                          <nav class="col-md-12 approval_tabs">
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                              <a style="font-weight: 400 !important;padding-top: 13px;font-size: 18px !important;padding-bottom: 0px;padding-left: 0px !important;" class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Summary</a>
                                              <a style="font-weight: 400 !important;padding-top: 13px;font-size: 18px !important;padding-bottom: 0px;" class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Details</a>
                                              <a style="font-weight: 400 !important;padding-top: 13px;font-size: 18px !important;padding-bottom: 0px;" class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Attachment</a>
                                            </div>
                                          </nav>
                                          <div class="tab-content col-md-12" id="nav-tabContent">
                                              <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <form>
                                                <div class="col-md-11" style="font-size: 18px; color:#6f6d6d; margin-top:15px;">
                                                  <p class="text-left" style="margin-bottom: 5px;font-size: 14px;"> From : {{form_data.leave_from_date_custom}}</p>
                                                  <p class="text-left" style="font-size: 14px;"> To : {{form_data.leave_to_date_custom}}</p>
                                                </div>
                                                <div class="col-md-12">
                                                  <div class="col-md-11 float-left text-right">
                                                    <h5 style="margin-top:6px;margin-bottom: 0px;">Requested</h5>
                                                    <p>{{form_data.user_employee_data.employee_fullname}}, {{form_data.created_at_custom}}</p>
                                                  </div>
                                                  <div class="col-md-1 float-left text-right">
                                                    <span v-if="form_data.user_employee_data.employee_image">
                                                      <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top:2px; width: 55px; height: 55px; border-radius:50px !important;">
                                                    </span>
                                                    
                                                    <span v-else>
                                                      <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-top: 2px; width: 55px; height: 55px; border-radius:50px !important;">
                                                    </span>
                                                  </div>
                                                </div>
                                               <!--  <td>Name</td>
                                                          <td>:</td>
                                                          <td>{{employee_name_value.text}}</td>
                                                        </tr>
                                                        <tr>
                                                          <td>Designation</td>
                                                          <td>:</td>
                                                          <td>{{form_data.designation_name}}</td>
                                                        </tr>
                                                        <tr>
                                                          <td>Contact</td>
                                                          <td>:</td>
                                                          <td>{{form_data.leave_reliever_contact}}</td>
                                                        </tr> -->
    
                                                <div class="col-md-12">
                                                  <div class="col-md-11 float-left text-right">
                                                    <h5 style="margin-top:6px;margin-bottom: 0px;">Responsible</h5>
                                                    <p>{{employee_name_value.text}}, {{form_data.created_at_custom}}</p>
                                                  </div>
                                                  <div class="col-md-1 float-left text-right">
                                                    <span v-if="employee_name_value.reliever_image">
                                                      <img  :src="`images/${employee_name_value.reliever_image}`" class="card-img-top border rounded" style="margin-top:2px; width: 55px; height: 55px; border-radius:50px !important;">
                                                    </span>
                                                    
                                                    <span v-else>
                                                      <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-top: 2px; width: 55px; height: 55px; border-radius:50px !important;">
                                                    </span>
                                                  </div>
                                                </div>
                                                <div class="col-md-12" v-for="approveDatas in form_data.approveData">
                                                  <div class="col-md-11 float-left text-right">
                                                    <h5 style="margin-top:6px;margin-bottom: 0px;">
                                                    <!-- {{form_data.leave_apply_status}} -->
                                                    Approval By
                                                    </h5>
                                                  </div>
                                                </div>
                                                <div class="col-md-12" v-for="approveDatas in form_data.approveData">
                                                  <div class="col-md-11 float-left text-right">
    
                                                    <p v-if="approveDatas.leave_comments" style="margin-top:6px;margin-bottom: 0px;">
                                                      <span style="border: 1px solid #7ef0ff;padding: 5px 50px;background: #18aaff0d;">{{approveDatas.leave_comments}}</span>
                                                    </p>
                                                    <p v-else style="margin-top:6px;margin-bottom: 0px;">
                                                      <span style="border: 1px solid #7ef0ff;padding: 5px 50px;background: #18aaff0d;">{{'No Comment Found!'}}</span>
                                                    </p>
                                                    <p style="margin-top: 5px;">{{approveDatas.employee_fullname}}, {{approveDatas.updated_at_approval}}</p>
                                                  </div>
                                                  <!-- {{approveDatas}} -->
                                                  <div class="col-md-1 float-left text-right">
                                                    <span v-if="approveDatas.employee_image">
                                                      <img  :src="`images/${approveDatas.employee_image}`" class="card-img-top border rounded" style="margin-top:2px; width: 55px; height: 55px; border-radius:50px !important;">
                                                    </span>
                                                    
                                                    <span v-else>
                                                      <img v-if="url !== '' || approveDatas.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-top: 2px; width: 55px; height: 55px; border-radius:50px !important;">
                                                    </span>
                                                  </div>
                                                </div>
                                                 <input type="hidden" v-model="form_data.employee_id">
                                                 <input type="hidden" v-model="cancel_application" >
                                                <span v-if="form_data.approveParmition==1 && form_data.leave_apply_status == 2">
                                                  <div v-if="form_data.leave_apply_status == 2" class="col-md-12 " style="margin-top:15px; margin-bottom:30px;">
                                                    <button type="button" @click="add({add:'add/leaveapplication'},form_data.cancel_application=1, form_data.approve_reject_status=3)" class="btn btn-md btn-default col-md-2" style="float:right; font-family: 'Source Sans Pro';   margin-bottom: 15px;    color: #ff0000;"> 
                                                        Cancel
                                                    </button>
                                                  </div>
                                                </span>    
                                                <!-- <span v-if="form_data.approveParmition==1">   -->
                                                  <span v-if="form_data.leave_apply_status !=2 && form_data.leave_apply_status !=4">
                                                      <div class="col-md-12 " v-if="form_data.approveParmition==1">
                                                        <p style="margin-bottom: 3px;font-size: 18px;font-weight: 400 !important;"><label style="font-weight: 400 !important;">Comment</label></p>
                                                        <textarea style="border: 1px solid #7ef0ff;background: #18aaff0d;font-weight: 400 !important;"  class="form-control" v-model="form_data.leave_comments"></textarea>
                                                      </div>
    
                                                      <div class="col-md-12 " style="margin-top:15px; margin-bottom:30px;" v-if="form_data.approveParmition==1">
                                                        <button type="button" @click="add({add:'approveOrReject/leaveapplication'}, form_data.approve_reject_status=1)" class="btn btn-md btn-info float-right col-md-2"
                                                        style="background-color:#3ca6ea; border-color:#3ca6ea;font-family: 'Source Sans Pro';">
                                                          <i class="fa fa-check"></i> 
                                                            Approve
                                                        </button>
                                                        <button type="button" @click="add({add:'approveOrReject/leaveapplication'},form_data.approve_reject_status=2)" class="btn btn-md btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px; font-family: 'Source Sans Pro';   margin-bottom: 15px;    color: #d48c06;"> 
                                                            Decline
                                                        </button>
                                                      </div>
                                                      
                                                    </span>
                                                  <!-- </span> -->
                                              </form>
                                            </div>
    
    
                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" style="margin-top:15px;">
                                              
                                                <div class="row col-md-12">
                                                  <div class="col-md-7 employee-info">
                                                  <h5>Leave Info</h5>
                                                  <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive" style="margin-bottom:0px;">
                                                      <tbody>
                                                        <tr>
                                                          <td>Apply Date</td>
                                                          <td>:</td>
                                                          <td>{{form_data.created_at_custom}}</td>
                                                        </tr>
                                                         <tr>
                                                          <td>Applied for</td>
                                                          <td>:</td>
                                                          <td>{{leave_type_value.text}}</td>
                                                        </tr>
                                                        <tr>
                                                          <td>From Date</td>
                                                          <td>:</td>
                                                          <td>{{form_data.leave_from_date_custom}}</td>
                                                        </tr>
                                                        <tr>
                                                          <td>To Date</td>
                                                          <td>:</td>
                                                          <td>{{form_data.leave_to_date_custom}}</td>
                                                        </tr>
                                                        <tr>
                                                          <td>Total Days</td>
                                                          <td>:</td>
                                                          <td>{{form_data.leave_total_day}} Days</td>
                                                        </tr>
                                                        <tr>
                                                          <td>Reason for Leave</td>
                                                          <td>:</td>
                                                          <td>{{form_data.leave_reason}}</td>
                                                        </tr>
                                                        <tr>
                                                          <td>Address, while on Leave </td>
                                                          <td>:</td>
                                                          <td>{{form_data.address_leave}}</td>
                                                        </tr>
                                                       
                                                        
                                                        <!-- <tr>
                                                          <td>Apply Type</td>
                                                          <td>:</td>
                                                          <td>
                                                            <label class="radio-inline" v-if="form_data.leave_apply_type==1">
                                                                With Pay
                                                            </label>
                                                            <label class="radio-inline"  v-if="form_data.leave_apply_type==2">
                                                                Without Pay
                                                            </label>
                                                          </td>
                                                        </tr>
                                                        <tr>
                                                          <td>Leave with Holiday</td>
                                                          <td>:</td>
                                                          <td>
                                                            <label class="radio-inline" v-if="form_data.leave_with_holiday==0">
                                                                No
                                                            </label>
                                                            <label class="radio-inline" v-if="form_data.leave_with_holiday==1">
                                                                Yes
                                                            </label>
                                                          </td>
                                                        </tr> -->
                                                        <!-- <tr>
                                                          <td>Attachment</td>
                                                          <td>:</td>
                                                          <td>
                                                            <label class="">
                                                              <span v-if="form_data.leave_attachment?form_data.leave_attachment:''">
                                                                <a target="_blank" :href="'/attachments/' + form_data.leave_attachment">View Attachment</a>
                                                              </span>
                                                              <span v-else-if="form_data.leave_attachment==''" >
                                                                 <p style="color:orange">No attachment found!</p>
                                                              </span>
                                                              </label>                                              
                                                          </td>
                                                        </tr> -->
                                                      </tbody>
                                                    </table>
                                                  </div>
                                                  <div class="col-md-5 employee-info">
                                                  <h5>Responsible</h5>
                                                  <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                                                      <tbody>
                                                        <tr>
                                                          <td>Name</td>
                                                          <td>:</td>
                                                          <td>{{employee_name_value.text}}</td>
                                                        </tr>
                                                        <tr>
                                                          <td>Designation</td>
                                                          <td>:</td>
                                                          <td>{{employee_name_value.designation_name}}</td>
                                                        </tr>
                                                        <tr>
                                                          <td>Contact</td>
                                                          <td>:</td>
                                                          <td>{{form_data.leave_reliever_contact}}</td>
                                                        </tr>
                                                        
                                                      </tbody>
                                                    </table>
                                                  <h5>Approval By</h5>
                                                  <table  class="table table-hover table-responsive">
                                                      <tbody v-for="approveDatas in form_data.approveData">
                                                        <tr> 
                                                          <td colspan="3" >
                                                              <span v-if="approveDatas.leave_approve_status==3">
                                                                  <strong> Forwarded </strong>
                                                              </span>
                                                              <span v-if="approveDatas.leave_approve_status==2">
                                                                  <strong> Approved </strong>
                                                              </span>
                                                               <span v-if="approveDatas.leave_approve_status==4">
                                                                  <strong> Rejected </strong>
                                                              </span>
    
                                                          </td>
                                                        </tr>
                                                        <tr>
                                                          <td>Name</td>
                                                          <td>:</td>
                                                          <td>{{approveDatas.employee_fullname}}</td>
                                                        </tr>
                                                        <tr>
                                                          <td>Designation</td>
                                                          <td>:</td>
                                                          <td>{{approveDatas.designation_name}}</td>
                                                        </tr>
                                                        <tr>
                                                          <td>Contact</td>
                                                          <td>:</td>
                                                          <td>{{approveDatas.employee_mobile}}</td>
                                                        </tr>
                                                         <tr>
                                                          <td>Comment</td>
                                                          <td>:</td>
                                                          <td>{{approveDatas.leave_comments}}</td>
                                                        </tr>
                                                        
                                                      </tbody>
                                                    </table>
    
                                                  </div>
                                              </div>
    
                                            </div>
                                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" style="height: 300px; text-align: center; margin-top:15px;">
                                              <h5>Attachment</h5>
                                              <p>
                                                <label class="">
                                                  <span v-if="form_data.leave_attachment?form_data.leave_attachment:''">
                                                    <a target="_blank" :href="'/attachments/' + form_data.leave_attachment">View Attachment</a>
                                                  </span>
                                                  <span v-else-if="form_data.leave_attachment==''" >
                                                     <p style="color:orange">No attachment found!</p>
                                                  </span>
                                                  </label>
                                              </p>
    
    
                                            </div>
                                          </div>
                                        
                                        </div>
    
    
    
    
    
    
    
    
                                         
                                       </span>
                                </div>
                            </div>
                        </div>
                            <div v-if="!modal_loading">
                                <pageLoading></pageLoading>
                            </div>
                        </modal>
    
            </div>
        </div>
        <div v-if="!page_loading">
            <pageLoading></pageLoading>
        </div>
    </div>
    </template>
    
    
    <script>
        import Loading from '../Loading.vue';
        import Datepicker from 'vuejs-datepicker';
        import moment from "moment";
    
        export default {
            data(){
              return{
                leave_type_value:'',
                employee_name_search:'',
                employee_name_value:'',
                leave_type_value:'',
                add_new_type:'',
                totalDays:0,
                totalDayss:0,
                remaining_days:0,
                employee_image:'',
                cancel_application:0,
                url:'',
              }
            },
            // props: {
            //   value: {
            //     type: Date,
            //     default: new Date()
            //   }
            // },
            created(){
                this.getResults(1);
            },
            components:{
                pageLoading:Loading,
                Datepicker,
            },
            methods:{
              formatCompat(date_format) {
                var ms = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                return new Date(date_format).getDate() + ' ' + ms[new Date(date_format).getMonth()] + ' ' + new Date(date_format).getFullYear();
              },
              getDataActiveIctive(v){
                this.page_loading = false;
                this.modal_loading=false;
                this.search_input.search_inpu_all=v;
                this.getResults();
              },
              printDiv() {
              $("table th").each(function () {
                this.style.setProperty("padding", ".35rem", "important");
                this.style.setProperty("font-size", ".8rem", "important");
              });
              $("table td").each(function () {
                this.style.setProperty("padding", ".35rem", "important");
                this.style.setProperty("font-size", ".8rem", "important");
              });

              $(".emp_leave_form2 .basic_info_class").each(function () {
                this.style.setProperty("width", "25%", "important");
                this.style.setProperty("text-align", "left", "important");
              });

              $(".reason_class").each(function () {
                this.style.setProperty("width", "25%", "important");
              });
  
              // $('input').addClass('leave_form_placeholder');
          let contents = document.getElementById("modalInvoice").innerHTML;
    
          let frame1 = document.createElement("iframe");
          frame1.name = "frame1";
          frame1.style.position = "absolute";
          frame1.style.top = "-1000000px";
          document.body.appendChild(frame1);
          let frameDoc = frame1.contentWindow
            ? frame1.contentWindow
            : frame1.contentDocument.document
            ? frame1.contentDocument.document
            : frame1.contentDocument;
          frameDoc.document.open();
          frameDoc.document.write(
            '<html lang="en"><head><title>Gemcon Group</title>'
          );
          frameDoc.document.write(
            '<link href="https://cdn.rawgit.com/sh4hids/bangla-web-fonts/bangla/stylesheet.css" rel="stylesheet">',
            '<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.0.0-alpha/fullcalendar.print.min.css"/>'
          );
          frameDoc.document.write("</head><body>");
          frameDoc.document.write(contents);
          frameDoc.document.write("</body></html>");
          frameDoc.document.close();
          setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            document.body.removeChild(frame1);
          }, 500);
          return false;
        },
    
              // printLeave () {
              //   const modal = document.getElementById("modalInvoice")
              //   const cloned = modal.cloneNode(true)
              //   let section = document.getElementById("print")
    
              //   if (!section) {
              //      section  = document.createElement("div")
              //      section.id = "print"
              //      document.body.appendChild(section)
              //   }
    
              //   section.innerHTML = "";
              //   section.appendChild(cloned);
              //   window.print();
              // },
    
            dateToYYYYMMDD(d) {
                return d && new Date(d.getTime()-(d.getTimezoneOffset()*60*1000)).toISOString().split('T')[0];
            },
            updateValue: function (target) {
              // console.log('fff');
              const date1 = new Date(this.form_data.leave_from_date);
              const date2 = new Date(this.form_data.leave_to_date);
              const diffTime = Math.abs(date2 - date1);
              const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
              this.totalDays=(+ diffDays)+(+1) + " d";
              this.totalDayss=(+ diffDays)+(+1);
              let leave_info = this.form_data.leaveInfo;
              let obj =leave_info.find(data => data.id == this.form_data.leave_type);
              // console.log([this.form_data.employee_id, this.form_data.employee_sbu, this.totalDayss]);
              // console.log('fff');
              if((date1 !='Invalid Date') && (date2 !='Invalid Date')){
                  if(this.form_data.leave_type == 1 && date1 && date2){ // leave_type = 1 (Annual leave)
                      let uri = URL.baseUrl('findActualAnnualLeaveDays');
                      axios.post(
                        uri,
                        { 
                          employee_id: this.form_data.employee_id, 
                          employee_sbu: this.form_data.employee_sbu, 
                          leave_form_date: date1,
                          leave_to_date: date2,
                          totalDayss: this.totalDayss,
                          url_type: 2
                        }
                      )
                      .then(res => {
                        console.log(res.data);
                        this.totalDayss = res.data.rest_day_except_hw;
                        this.totalDays= this.totalDayss + " d";
                        this.remaining_days = obj.balance - this.totalDayss;
                        this.form_data.leave_total_day = this.totalDayss;
                        if(obj.balance < this.totalDayss){
                          this.showToster({status:0,message:'Opps! Annual leave not available ' + this.totalDayss + ' Days'});
                          this.totalDayss=0;
                          this.form_data.leave_from_date='';
                          this.form_data.leave_to_date='';
                          this.totalDays = 0;
                          this.remaining_days = 0;
                        }
                      })
                      .catch(error => {
                        console.log('Data not found!');
                      })
                  }else if((this.form_data.leave_type == 2)){
                    if(this.totalDayss > 3){
                        this.showToster({status:0,message:'opps! Casual leave not allowed more than 3 days !  '});
                        this.totalDayss=0;
                        this.form_data.leave_from_date='';
                        this.form_data.leave_to_date='';
                        this.totalDays=0;
                        this.remaining_days =0;
                    }
                    if(obj.balance < this.totalDayss){
                      this.showToster({status:0,message:'Opps! this leave not available ' + this.totalDayss + ' Days'});
                      this.totalDayss=0;
                      this.form_data.leave_from_date='';
                      this.form_data.leave_to_date='';
                      this.totalDays=0;
                      this.remaining_days =0;
                    }  
                    this.remaining_days = obj.balance - this.totalDayss;
                    this.form_data.leave_total_day = this.totalDayss;
                  }else if(this.form_data.leave_type == 3 || this.form_data.leave_type == 5){
                    if(obj.balance < this.totalDayss){
                      this.showToster({status:0,message:'Opps! this leave not available ' + this.totalDayss + ' Days'});
                      this.totalDayss=0;
                      this.form_data.leave_from_date='';
                      this.form_data.leave_to_date='';
                      this.totalDays=0;
                      this.remaining_days =0;
                    }
                    this.remaining_days = obj.balance - this.totalDayss;
                    this.form_data.leave_total_day = this.totalDayss;
                  }else if(this.form_data.leave_type == 6){
                      this.remaining_days = this.totalDayss;
                      this.form_data.leave_total_day = this.totalDayss;
                  }else{
                    this.showToster({status:0,message:'Opps! Somthing went wrong'});
                    this.totalDayss=0;
                    this.form_data.leave_from_date='';
                    this.form_data.leave_to_date='';
                    this.totalDays=0;
                    this.remaining_days =0;
                  }
              }
            },
             selectAll: function (event) {
                setTimeout(function () {
                  event.target.select()
                }, 0)
              },
              dateSelectedTotal(event){
                console.log(this.form_data.leave_from_date);
                console.log(this.form_data.leave_to_date);
              },
              onSelectEmployeeSearch(option){
                this.getModalDataOther(option.id);
                // this.form_data.employee_id=this.form_data.leave_reliever;
                // console.log(this.form_data.employee_id);
                // console.log(option);
                // let allData =this.form_data.employee_data[option.id];
                
                // this.form_data.leave_reliever= option.id;
                this.form_data.employee_id = option.id;
                // this.form_data.employee_sbu = option.employee_sbu;
                // this.form_data.leave_reliever = option.id;
                // this.form_data.leave_reliever_contact = option.employee_mobile ?? '';
                // this.form_data.designation_name = option.designation_name ?? '';
                // this.form_data.sbu_name = option.sbu_name ?? '';

                this.leave_type_value = '';
                this.totalDayss = 0;
                this.form_data.leave_from_date = '';
                this.form_data.leave_to_date = '';
                this.totalDays = 0;
                this.remaining_days = 0;
              },
              getModalDataOther(id){
                  let uri = URL.baseUrl('edit/otherCreate/'+id);
                  console.log(uri);
                  axios.get(uri)
                  .then(res => {
                    // console.log(res.data);
                    this.form_data = res.data;
                    if(this.form_data.approvalfristId == null && this.form_data.approval2ndId == null){
                      alert('Reporting/Supervisor is not set yet!');
                    }
                    this.form_data.employee_id=id;
                    this.option_data.leave_type_data = res.data.leave_type_data;
                    this.errors =null;
                    if(callback){
                      callback();
                    }
                  })
                  .catch(error => {
                    // this.showToster({status:0,message:'opps! something went wrong'});
                    this.modal_page_loading= true;
                  })
                },
    
              leaveTypeList(option){
                console.log(option);
                this.form_data.leave_type= option.id;
                this.form_data.leave_from_date= '';
                this.form_data.leave_to_date= '';
                this.remaining_days= '';
                this.totalDays= '';
                this.form_data.add_new_type=this.add_new_type;
                console.log(this.form_data.leave_type);
              },
              onSelectEmployee(option){
                // console.log(this.form_data.leave_reliever);
                // console.log(this.form_data.user_employee_data_all);
                // let allData =this.form_data.employee_data[option.id];
                // console.log('FFF');
                // console.log(option.id);
                // console.log(option.employee_mobile);
                // if (allData['official_mobile_no']) {
                  //   this.form_data.leave_reliever_contact=allData['official_mobile_no'];
                  // }else{
                    //   this.form_data.leave_reliever_contact=allData['employee_mobile'];
                    // }
                // this.form_data.leave_reliever= option.id;
                this.form_data.leave_reliever = option.id;
                this.form_data.leave_reliever_contact = option.employee_mobile ?? '';
                this.form_data.designation_name = option.designation_name ?? '';
                this.form_data.sbu_name = option.sbu_name ?? '';
              },
              onFileChange(e) {
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.createImage(files[0]);
                    
                },
              createImage(file) {
                  let reader = new FileReader();
                  let vm = this;
                  reader.onload = (e) => {
                      this.form_data.leave_attachment = e.target.result;
                  };
                  reader.readAsDataURL(file);
              },
              cancelUpdate(){
                 this.form_data.cancel_application = 2;
              },
              setModalData(){
                this.employee_name_search=this.form_data.employee_name_search;
                this.employee_name_value=this.form_data.employee_name_value;
                this.leave_type_value=this.form_data.leave_type_value;
                this.form_data.cancel_application=this.cancel_application;
              },
              resetModal(){
                // alert('ss');
                this.form_data.employee_id= this.form_data.user_employee_data.id;
                this.form_data.employee_sbu= this.form_data.user_employee_data.employee_sbu;
                this.form_data.leave_with_holiday='0';
                this.form_data.leave_apply_type='1';
                this.form_data.employee_name_value='';
                this.form_data.leave_reliever= '';
                this.form_data.leave_type_value='';
                this.form_data.employee_name_search='';
                this.form_data.employee_name_value='';
                this.form_data.leave_type_value='';
                this.form_data.leave_reliever="";
                this.employee_name_value="";
                this.totalDays=0;
                this.totalDayss=0;
                this.leave_type_value='';
                this.form_data.leave_type= '';
                this.cancel_applicatione=0;
                this.employee_name_search = '';
                // this.leaveTypeList="";
    
                
              },
            }
        }
    
       
    </script>
    <style type="text/css">
      .vdp-datepicker {
          border-bottom: 0px solid #cfcfcf;
      }
      .vdp-datepicker input {
          border-bottom: 1px solid #dcdcdc;
          border-bottom-right-radius: 5px;
          height: 20px;
      }
      .table tbody+tbody {
        border-top: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
    
    }
    
    .leave_app_model .v--modal-box{
        width: 60% !important;
        left: 20% !important;
    
        /*width: 65%*/
        /*left: 20%*/
        /*transition: transform .3s ease-out;*/
    }
    
    .modalInvoice > table td, .table th {
        padding: 1px .75rem;
    }
    
    @media screen {
      #print {
        display: none;
       }
    }
    
    @media print {
     body * {
      visibility:hidden;
      }
      #print, #print * {
        visibility:visible;
      }
      #print {
        position:absolute;
        left:0;
        top:0;
      }
    }
    .example-print {
        display: none;
    }
    
    @media print {
        /* #modalInvoice {
           height: 100vh;
       width: 800px;
    
        } */
       
       
       
    }
  
  </style>