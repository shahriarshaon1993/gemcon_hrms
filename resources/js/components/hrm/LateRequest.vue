<template>
<div>
    <div v-if="page_loading" class="widget box">
        <div class="widget-header">
             <div >
                   <section class="content">
                     <div class="container-fluid">
                       <div class="row">
                         <div class="col-12">
                           <div class="card">
                             <div class="card-header">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                                        <h3 class="card-title d-none d-md-block">Late Approve Requests</h3>
                                        <span class="float-sm-right" style="float: right;">
                                        </span>
                                    </div>
                                </div>
                               <!--  Info boxes -->
                               <div class="row">
                               <div class="col-12 col-sm-12 col-md-3" style="max-width: 20%;">
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
                                <div class="col-12 col-sm-12 col-md-3" style="max-width: 20%;">
                                 <a @click="getDataActiveIctive('Requested')"  style="color: #000">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-info elevation-1"><i class="fa fa-paper-plane"></i></span>

                                    <div class="info-box-content">
                                      <span class="info-box-text">Requests</span>
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
                                 <div class="col-12 col-sm-12 col-md-3" style="max-width: 20%;">
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
                                 <div class="col-12 col-sm-12 col-md-3" style="max-width: 20%;">
                                 <a @click="getDataActiveIctive('Accepted')"  style="color: #000">
                                   <div class="info-box mb-3">
                                     <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>

                                     <div class="info-box-content">
                                       <span class="info-box-text">Approved</span>
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

                                 <div class="col-12 col-sm-12 col-md-3" style="max-width: 20%;">
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
                                  <th class="text-center" v-bind:class="getSortingClass('id')" @click="sortingChanged('id')">SL</th>
                                  <th class="text-center" v-bind:class="getSortingClass('late_date')" @click="sortingChanged('late_date')"> Attendance Date <i class="fas fa-sort"></i></th>
                                  <th class="text-center" v-bind:class="getSortingClass('employee_id_no')" @click="sortingChanged('employee_id_no')">ID <i class="fas fa-sort"></i></th>
                                  <th class="text-center" v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Employee <i class="fas fa-sort"></i></th>
                                  <th class="text-center" v-bind:class="getSortingClass('in_time')" @click="sortingChanged('in_time')">In Time <i class="fas fa-sort"></i></th>
                                  <th class="text-center" v-bind:class="getSortingClass('actual_in_time')" @click="sortingChanged('actual_in_time')">Actual In Time <i class="fas fa-sort"></i></th>
                                  <th class="text-center" v-bind:class="getSortingClass('late_reason')" @click="sortingChanged('late_reason')">Reason <i class="fas fa-sort"></i></th>
                                  <th class="text-center" v-bind:class="getSortingClass('late_approve_status')" @click="sortingChanged('late_approve_status')">Status <i class="fas fa-sort"></i></th>
                                  <th class="text-center">Action</th>
                                 </tr>
                                 </thead>
                                 <tbody v-if="Object.keys(paginate_data.data).length > 0">
                                  <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
                                     <td class="text-center">{{index+1}}</td>
                                     <td class="text-center">{{form_data.late_date}}</td>
                                     <td>{{form_data.employee_id_no}}</td>
                                     <td>{{form_data.employee_fullname}}</td>
                                     <td>{{form_data.in_time}}</td>
                                     <td>{{form_data.actual_in_time}}</td>
                                     <td>{{form_data.late_reason}}</td>
                                     <td v-if="form_data.late_approve_status==1"> Requested</td>
                                     <td v-if="form_data.late_approve_status==2"> Approved</td>
                                     <td v-if="form_data.late_approve_status==3"> Forwarded</td>
                                     <td v-if="form_data.late_approve_status==4"> Rejected</td>
                                     <td style="padding: 5px 5px">
                                        <button v-if="lists.view=='view'" @click="getModalData($event,{dataUrl:'edit/late_request/'+form_data.id},setModalData, add_new_type = 4)" class="btn-xs btn-success" title="Approve" > <i class="fa fa-eye"> </i></button>
                                       <span v-if="form_data.late_approve_status ==1"> 
                                          <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/late_request/'+form_data.id},setModalData, add_new_type = 3)" class="btn-xs btn-info" title="Edit" > <i class="fa fa-edit"> </i></button>
                                       </span>
                                       <span v-if="form_data.late_approve_status !=1">
                                         <button v-if="lists.edit=='edit'" class="btn-xs btn-info" title="Already Task Completed!" @click="AccessDenied($event,value='Already Task Completed!')" style="opacity: 0.5"> <i class="fa fa-edit"> </i></button>
                                       </span>
                                       <span v-if="form_data.late_approve_status ==1">  
                                        <button  v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/late_request/'+form_data.id})" title="Delete" class="btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                       </span>
                                       <span v-if="form_data.late_approve_status !=1">
                                         <button v-if="lists.delete=='delete'" class="btn-xs btn-danger" title="Already Task Completed!" @click="AccessDenied($event,value='Already Task Completed!')" style="opacity: 0.5"> <i class="fa fa-trash"></i></button>
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
                               </div>
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

                 <modal ref="modal" class="" name="myModal" height="auto" :clickToClose="false" body-class="p-0">
                      <div v-if="modal_loading">
                          <div class="widget-header modal-header">
                              <h5 v-if="add_new_type!=5"><i class="fa fa-bars"></i> Late Request</h5>
                              <h5 v-if="add_new_type==5"><i class="fa fa-bars"></i> Late Approval</h5>
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
                                          <div class="col-md-8 employee-info-table">
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
                                                  <td>{{form_data.user_employee_data.employee_mobile}}</td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                            <div class="col-md-4 leave-info text-right" >
                                              <span v-if="form_data.user_employee_data">
                                                <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top:2px; width: 150px; height: 170px;">
                                              </span>
                                              <span v-else>
                                                <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-top: 2px; width: 150px; height: 170px;">
                                              </span>
                                            </div>
                                      </div>
                                <span v-if="add_new_type==3 || add_new_type==1 || add_new_type==2">
                                 <form class="well form-horizontal needs-validation leave-application" @submit.prevent="add({add:'add/late_request'})">
                                  <input type="hidden" v-model="form_data.employee_id">
                                  <div class="row" style="margin:0px">
                                    <div class="col-md-12">
                                      <div class="col-md-12 float-left">
                                         <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                            <label class="control-label">Attendance Date <span class="required_sign">*</span></label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer" style="padding-right: 0px;">
                                               <div class="form-group datepicker-container">
                                                  <div class="col-md-5 float-left" style="padding: 0px;">
                                                     <div class="input-group">
                                                      <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                         <div class="col-md-12" style="padding: 0px;">
                                                          <input 
                                                            v-model="form_data.late_date" 
                                                            type="date"
                                                            ref="input"
                                                            style="width:100%;"
                                                            >
                                                         </div>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                         </div> 
                                         <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                            <label class="control-label">In Time <span class="required_sign">*</span></label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer">
                                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                               <input v-model="form_data.in_time" id="email" name="email" placeholder="" class="form-control" required="true" type="text">
                                                </div>
                                            </div>
                                         </div>
                                         <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                            <label class="control-label">Actual In Time <span class="required_sign">*</span></label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer">
                                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                               <input v-model="form_data.actual_in_time" id="email" name="email" placeholder="" class="form-control" required="true" type="text">
                                                </div>
                                            </div>
                                         </div>
                                         <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                            <label class="control-label">Late Reason <span class="required_sign">*</span></label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer">
                                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                               <textarea v-model="form_data.late_reason" id="city" name="city" placeholder="" class="form-control" required="true" type="text"></textarea>
                                                </div>
                                            </div>
                                         </div> 
                                      </div>
                                    </div> 
                                  </div>
                                  <div class="form-actions col-md-12">
                                      <input type="submit" tabindex="4" value="Update" class="btn btn-sm btn-info float-right col-md-2">
                                      <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button>
                                  </div>
                                </form>
                              </span>

                                 <!-- Approve leave application of employee: modal start from here -->
                                 <!-- Approve leave application of employee: modal start from here -->

                                 <span v-else-if="add_new_type==4">
                                  <form class="well form-horizontal needs-validation leave-application">
                                     <div class="row" style="margin:0px">
                                       <div class="col-md-12">
                                         <div class="col-md-12 float-left">
                                            <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                               <div class="col-md-4 float-left" style="padding-left: 0px;">
                                               <label class="control-label">Attendance Date <span class="required_sign">*</span></label>
                                               </div>
                                               <div class="col-md-8 float-left inputGroupContainer" style="padding-right: 0px;">
                                                  <div class="form-group datepicker-container">
                                                     <div class="col-md-5 float-left" style="padding: 0px;">
                                                        <div class="input-group">
                                                         <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                             <input 
                                                               v-model="form_data.late_date" 
                                                               type="date"
                                                               ref="input"
                                                               style="width:100%;"
                                                               readonly 
                                                               >
                                                            </div>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div> 

                                            <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                               <div class="col-md-4 float-left" style="padding-left: 0px;">
                                               <label class="control-label">In Time <span class="required_sign">*</span></label>
                                               </div>
                                               <div class="col-md-8 float-left inputGroupContainer">
                                                  <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                  <input v-model="form_data.in_time" id="email" name="email" placeholder="" class="form-control" required="true" type="text" readonly>
                                                   </div>
                                               </div>
                                            </div>
                                            <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                               <div class="col-md-4 float-left" style="padding-left: 0px;">
                                               <label class="control-label">Actual In Time <span class="required_sign">*</span></label>
                                               </div>
                                               <div class="col-md-8 float-left inputGroupContainer">
                                                  <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                  <input v-model="form_data.actual_in_time" id="email" name="email" placeholder="" class="form-control" required="true" type="text" readonly>
                                                   </div>
                                               </div>
                                            </div>

                                            <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                               <div class="col-md-4 float-left" style="padding-left: 0px;">
                                               <label class="control-label">Late Reason <span class="required_sign">*</span></label>
                                               </div>
                                               <div class="col-md-8 float-left inputGroupContainer">
                                                  <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                  <textarea v-model="form_data.late_reason" id="city" name="city" placeholder="" class="form-control" required="true" type="text" readonly></textarea>
                                                   </div>
                                               </div>
                                            </div> 
                                          
                                         </div>

                                       </div> 
                                     </div>
                                     <input type="hidden" v-model="form_data.employee_id">
                                    <span v-if="form_data.late_approve_status !=4">  
                                    <span v-if="form_data.late_approve_status !=2"> 
                                     <!-- <div v-if="form_data.approveParmition==1" class="col-md-12"> -->
                                     <div class="col-md-12">
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
                                   <!-- <div class="form-actions col-md-12" v-if="form_data.approveParmition==1"> -->
                                   <div class="form-actions col-md-12" >
                                        <button type="button" @click="add({add:'approveOrReject/late_request'}, form_data.approve_reject_status=1)" class="btn btn-sm btn-success float-right col-md-2">Approve</button>
                                       <button type="button" @click="add({add:'approveOrReject/late_request'},form_data.approve_reject_status=2)" class="btn btn-sm btn-danger float-right col-md-2 offset-md-6" style="margin-right: 10px;">Reject</button>
                                   </div>
                                   </span>
                                    </span>
                                  </form>
                                  </span>
                                   <span v-if="add_new_type==7">
                                    <div class="row form-group">
                                         <div class="col-md-11"></div>
                                         <div class="col-md-1">
                                            <button  @click="print()" class="btn-xs btn-info" data-toggle="modal" data-target="#myModal1">Print</button>
                                         </div>
                                     </div>
                                    <div id="incom-report" class="row" style="margin-left: 15px;margin-right: 15px;">
                                     <table width="100%" cellspacing="0" style="margin-bottom: -10px; font-family: 'Font Awesome 5 Free';" class="table" border="0" cellpadding="7">
                                          <tbody style="border: 1px solid #dee2e6;">
                                          <tr valign="bottom">
                                          <td style="background: transparent;vertical-align: middle;" width="105" >
                                            
                                            <p v-if='form_data.user_employee_data.sbu_logo'>
                                              <img :src="`company_logo/${form_data.user_employee_data.sbu_logo}`" width="100" height="60" >
                                            <!-- <img src="company_logo/group_company_logo.png" width="100" height="60" > -->
                                            </p>
                                          <p v-else>
                                            <img src="company_logo/group_company_logo.png" width="100" height="60" >
                                            </p>

                                          </td>
                                          <td style="background: transparent;vertical-align: middle;" colspan="5" width="461">
                                          <p align="center" style="vertical-align: middle;margin:0px"> <span style="font-family: Arial, serif;"><strong><span style="font-size: large;">Gemcon Group</span></strong></span></p>
                                          <p align="center"><span style="font-family: Arial, serif;"><strong>Leave Application Form</strong></span></p>
                                          </td>
                                          <td style="background: transparent;" width="82">
                                          <p>&nbsp;</p>
                                          </td>
                                          </tr>
                                          <tr valign="bottom">
                                          <td style="background: transparent;" colspan="7" width="560">
                                          <p align="right" style="vertical-align: middle;margin:0px"><span style="font-family: Arial, serif;"><span style="font-size: small;"> <strong> Employee ID: </strong></span> {{form_data.user_employee_data.employee_id_no}}</span></p>
                                          </td>
                                          </tr>
                                          </tbody>
                                       </table>
                                       <table width="100%" cellspacing="0" style="font-family: 'Font Awesome 5 Free';" class="table" border="0" cellpadding="7">
                                        
                                          <tbody style="border: 1px solid #dee2e6;"> 
                                            <tr>
                                              <td style="width: 18%;"> 
                                                <strong> Applicant's Name </strong> 
                                              </td>
                                              <td style="width: 1%;"><strong>:</strong></td>
                                              <td colspan="5" style="width: 85%;">
                                                  {{form_data.user_employee_data.employee_fullname}}
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td style="width: 14%;">
                                                  <strong>Designation </strong>
                                              </td>
                                              <td style="width: 1%;"><strong>:</strong></td>
                                              <td colspan="5" style="width: 85%;">
                                                  {{form_data.user_employee_data.designation_name}}
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td style="width: 14%;">
                                                  <strong>Department </strong>
                                              </td>
                                              <td style="width: 1%;"><strong>:</strong></td>
                                              <td colspan="5" style="width: 85%;">
                                                   {{form_data.user_employee_data.department_name}}
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td style="width: 14%;">
                                                <strong>Company/Project</strong>
                                              </td>
                                              <td style="width: 1%;"><strong>:</strong></td>
                                              <td  colspan="5" style="width: 85%;">
                                                {{form_data.user_employee_data.sbu_name}}
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td style="width: 14%;">
                                                <strong>Location</strong>
                                              </td>
                                              <td style="width: 1%;"><strong>:</strong></td>
                                              <td colspan="5" style="width: 85%;">
                                                {{form_data.user_employee_data.work_location_name}}
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td style="width: 14%;">
                                                  <strong>Applied for</strong>
                                              </td>
                                              <td style="width: 1%;"><strong>:</strong></td>
                                              <td colspan="5" style="width: 85%;">

                                                  <lo  style="margin-right: 20px;"> 
                                                    <label class="checkbox-inline"><input style="margin: 4px;" type="checkbox">Annual Leave</label>
                                                  </lo>
                                                  <lo style="margin-right: 20px;"> 
                                                    <label class="checkbox-inline"><input style="margin: 4px;" type="checkbox">Casual Leave</label>
                                                  </lo>
                                                   <lo style="margin-right: 20px;"> 
                                                    <label class="checkbox-inline"><input style="margin: 4px;" type="checkbox">Medical Leave</label>
                                                  </lo>
                                                  <lo style="margin-right: 20px;"> 
                                                    <label class="checkbox-inline"><input style="margin: 4px;" type="checkbox">Maternity Leave</label>
                                                  </lo>
                                                  
                                              </td>                                              
                                            </tr>
                                          </tbody>
                                          <tbody style="border: 1px solid #dee2e6;">

                                          
                                            <tr>
                                              <td style="width: 14%;">
                                               <strong>Period</strong>
                                              </td>
                                              <td style="width: 1%;"><strong>:</strong></td>
                                              <td colspan="5" style="width: 85%;">

                                                  <lo  style="margin-right: 5px;"> 
                                                    <label class="checkbox-inline"><strong> From </strong> </label>
                                                  </lo>
                                                  <lo style="margin-right: 20px;"> 
                                                    <input 
                                                    v-model="form_data.leave_from_date" 
                                                    type="date"
                                                    ref="input"
                                                    v-on:input="updateValue($event.target)"
                                                    v-on:focus="selectAll"
                                                    v-on:keyup="updateValue($event.target)"
                                                    @click="updateValue($event.target)"
                                                    >
                                                  </lo>
                                                   <lo style="margin-right: 5px;"> 
                                                    <label class="checkbox-inline"><strong>TO</strong></label>
                                                  </lo>
                                                   <lo style="margin-right: 20px;"> 
                                                    <input
                                                      type="date"
                                                      ref="input"
                                                      v-model="form_data.leave_to_date"
                                                      v-on:input="updateValue($event.target)"
                                                      v-on:focus="selectAll"
                                                      v-on:keyup="updateValue($event.target)"
                                                      @click="updateValue($event.target)"
                                                    >
                                                
                                                  </lo>
                                                  <lo style="margin-right: 20px;"> 
                                                    <label class="checkbox-inline"><strong> Total Days </strong></label>
                                                  </lo>
                                                   <lo style="margin-right: 20px;"> 
                                                    {{totalDays}}
                                                   
                                                  </lo>
                                                  
                                              </td>             
                                              
                                            </tr>
                                          </tbody>
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td style="width: 14%;">
                                                    <strong> Reason </strong>
                                              </td>
                                              <td style="width: 1%;"> : </td>
                                              <td colspan="5" style="width: 85%;">
                                                    
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td style="width: 14%;">
                                                <strong> Contact Phone </strong>
                                              </td>
                                              <td style="width: 1%;"> : </td>
                                              <td colspan="5" style="width: 85%;">
                                                  
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td style="width: 14%;">
                                                  <strong> Address, while on Leave </strong>
                                              </td>
                                              <td style="width: 1%;"> : </td>
                                              <td colspan="5" style="width: 85%;">  
                                                
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <table width="100%" cellspacing="0" style="font-family: 'Font Awesome 5 Free';" class="table" :border="0" cellpadding="7">
                                          
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr class="text-center; ">
                                              <td style="width: 16%; vertical-align: middle; background: rgb(245, 245, 245);" rowspan="5" >
                                                  <strong>Leave Status</strong>
                                              </td>
                                              <th style="width: 18%; text-align: center; vertical-align: middle; background: #f5f5f5;">Leave Type</th>
                                              <th style="width: 14%; text-align: center; vertical-align: middle; background: #f5f5f5;">Entitlement This Year</th>
                                              <th style="width: 14%; text-align: center; vertical-align: middle; background: #f5f5f5;">Previous Balance</th>
                                              <th style="width: 14%; text-align: center; vertical-align: middle; background: #f5f5f5;">Total Entitlement</th>
                                              <th style="width: 14%; text-align: center; vertical-align: middle; background: #f5f5f5;">Availed This Year</th>
                                              <th style="width: 14%; text-align: center; vertical-align: middle; background: #f5f5f5;">Balance</th>
                                            </tr>
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
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td style="background: transparent;" colspan="7" valign="bottom" width="676" >
                                              <p>&nbsp;</p>
                                              </td>
                                            </tr>
                                            <tr valign="bottom">
                                              <td style="background: transparent;text-align: center;" colspan="3" width="294" >
                                                   <strong> Signature of HR Personnel </strong>
                                              </td>
                                              <td style="background: transparent;text-align: center;" colspan="4" width="368">
                                                 <strong> Signature of Applicant with date </strong>
                                              </td>
                                            </tr>
                                          </tbody>
                                          
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td style="background: rgb(245, 245, 245);text-align: center;" colspan="7" width="676" >
                                                    Recommendation: (By Immediate Supervisor)
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td  colspan="7" style="background: transparent;" >
                                                 <lo  style="margin-right: 20px;margin-left: 36%;"> 
                                                    <label class="checkbox-inline"><input style="margin: 4px;" type="checkbox">Recommended</label>
                                                  </lo>
                                                  <lo style="margin-right: 20px;margin-right: 30%;"> 
                                                    <label class="checkbox-inline"><input style="margin: 4px;" type="checkbox">Not Recommended</label>
                                                  </lo>
                                              </td>
                                              
                                            </tr>
                                          </tbody>
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td style="background: transparent;vertical-align: middle;" rowspan="2" width="105" >
                                                  Reason, if not recommended
                                              </td>
                                              <td style="background: transparent;vertical-align: middle;" rowspan="2" width="105" >
                                                  :
                                              </td>
                                              <td style="background: transparent;" colspan="5" rowspan="2" valign="bottom" width="557">
                                                  &nbsp;
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr valign="bottom">
                                              <td style="background: transparent;" width="105" height="2">
                                              <p>&nbsp;</p>
                                              </td>
                                              <td style="background: transparent;" width="84">
                                              <p>&nbsp;</p>
                                              </td>
                                              <td style="background: transparent;" width="78">
                                              <p>&nbsp;</p>
                                              </td>
                                              <td style="background: transparent;" width="98">
                                              <p>&nbsp;</p>
                                              </td>
                                              <td style="background: transparent;" width="70">
                                              <p>&nbsp;</p>
                                              </td>
                                              <td style="background: transparent;" width="76">
                                              <p>&nbsp;</p>
                                              </td>
                                              <td style="background: transparent;" width="82">
                                              <p>&nbsp;</p>
                                              </td>
                                            </tr>
                                            <tr valign="bottom">
                                              <td style="background: transparent;width: 14%;" colspan="3" >
                                                  <strong> Name :</strong> 
                                                  <span v-if="form_data.approvalfristId">
                                                    [ {{form_data.approvalfristId.employee_id_no}} ] {{form_data.approvalfristId.employee_fullname}} 
                                                  </span> 
                                                  <span v-else>
                                                    Supervisor Name Not Found..
                                                  </span>
                                              </td>
                                              
                                              
                                              <td style="background: transparent;" colspan="4" width="368">
                                              <p align="center"><span style="font-family: Arial, serif;"><span style="font-size: small;"><strong>Signature with date</strong></span></span></p>
                                              </td>
                                            </tr>
                                          </tbody>
                                          
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td style="background: rgb(245, 245, 245);text-align: center;" colspan="7" width="676">
                                               Approval: (By Director/CEO/COO/Head of Department/Project In charge)
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td  colspan="7" style="background: transparent;" >
                                                 <lo  style="margin-right: 20px;margin-left: 36%;"> 
                                                    <label class="checkbox-inline"><input style="margin: 4px;" type="checkbox">Approved</label>
                                                  </lo>
                                                  <lo style="margin-right: 20px;margin-right: 30%;"> 
                                                    <label class="checkbox-inline"><input style="margin: 4px;" type="checkbox">Not Approved</label>
                                                  </lo>
                                              </td>
                                              
                                            </tr>
                                          </tbody>
                                          <tbody style="border: 1px solid #dee2e6;">
                                            <tr>
                                              <td style="background: transparent;vertical-align: middle;" rowspan="2" width="105" >
                                                  Reason, if not approved
                                              </td>
                                              <td style="background: transparent;vertical-align: middle;" rowspan="2" width="105" >
                                                  :
                                              </td>
                                              <td style="background: transparent;" colspan="5" rowspan="2" valign="bottom" width="557">
                                                  &nbsp;
                                              </td>
                                            </tr>
                                          </tbody>
                                         
                                          <tbody style="border: 1px solid #dee2e6;">
                                          
                                          <tr valign="bottom">
                                          <td style="background: transparent;" width="105" height="2">
                                          <p>&nbsp;</p>
                                          </td>
                                          <td style="background: transparent;" width="84">
                                          <p>&nbsp;</p>
                                          </td>
                                          <td style="background: transparent;" width="78">
                                          <p>&nbsp;</p>
                                          </td>
                                          <td style="background: transparent;" width="98">
                                          <p>&nbsp;</p>
                                          </td>
                                          <td style="background: transparent;" width="70">
                                          <p>&nbsp;</p>
                                          </td>
                                          <td style="background: transparent;" width="76">
                                          <p>&nbsp;</p>
                                          </td>
                                          <td style="background: transparent;" width="82">
                                          <p>&nbsp;</p>
                                          </td>
                                          </tr>
                                          <tr valign="bottom">
                                          <td style="background: transparent;width: 14%;" colspan="3" >
                                            <strong> Name : </strong>
                                            <span v-if="form_data.approval2ndId">
                                                [ {{form_data.approval2ndId.employee_id_no}} ] {{form_data.approval2ndId.employee_fullname}} 
                                            </span>
                                            <span v-else>
                                              Not Found
                                            </span>
                                            
                                          </td>
                                          
                                          <td style="background: transparent;" colspan="4" width="368">
                                          <p align="center"><span style="font-family: Arial, serif;"><span style="font-size: small;"><strong>Signature with date</strong></span></span></p>
                                          </td>
                                          </tr>
                                          </tbody>
                                          </table>
                                        </div>

                                   </span>

























                                   <span v-if="add_new_type==5">
                                    <div class="row col-md-12" style="margin-left:0px;">
                                      <div class="col-md-2">
                                        <span v-if="form_data.user_employee_data">
                                          <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top:2px; width: 90px; height: 95px; border-radius:35px !important;">
                                        </span>
                                        
                                        <span v-else>
                                          <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-top: 2px; width: 90px; height: 95px; border-radius:35px !important;">
                                        </span>
                                      </div>
                                      <div class="col-md-5">
                                        <h2 style="color:#6f6d6d; margin-top: 50px;     font-weight: bold;">{{form_data.user_employee_data.employee_fullname}}</h2>
                                      </div>
                                      <div class="col-md-5 text-right" style="font-size: 22px;color:#6f6d6d;">
                                        <i class="fa fa-check-circle" aria-hidden="true" style="margin-left:-22px;color: #90c53c;font-size: 25px;"></i>
                                        <span>There are</span> <br>
                                        <span style="color: #20a2afe0;">0 Conflicts</span><br>
                                        <span>with this request</span>
                                      </div>
                                    </div>
                                    <div class="row col-md-12" style="margin-left:0px; margin-top: 15px;">
                                      <nav class="col-md-12 approval_tabs">
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                          <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Summary</a>
                                          <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Details</a>
                                          <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Attachment</a>
                                        </div>
                                      </nav>
                                      <div class="tab-content col-md-12" id="nav-tabContent">
                                          <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <form>
                                            <div class="col-md-11" style="font-size: 18px; color:#6f6d6d; margin-top:15px;">
                                              <p class="text-left" style="margin-bottom: 5px;"> From : {{form_data.leave_from_date_custom}}</p>
                                              <p class="text-left"> To : {{form_data.leave_to_date_custom}}</p>
                                            </div>
                                            <div class="col-md-12">
                                              <div class="col-md-11 float-left text-right">
                                                <h5 style="margin-top:6px;margin-bottom: 0px;">Requested</h5>
                                                <p>{{form_data.user_employee_data.employee_fullname}}, {{form_data.created_at_custom}}</p>
                                              </div>
                                              <div class="col-md-1 float-left text-right">
                                                <span v-if="form_data.user_employee_data">
                                                  <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top:2px; width: 55px; height: 55px; border-radius:50px !important;">
                                                </span>
                                                
                                                <span v-else>
                                                  <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-top: 2px; width: 55px; height: 55px; border-radius:50px !important;">
                                                </span>
                                              </div>
                                            </div>

                                            <div class="col-md-12" v-for="approveDatas in form_data.approveData">
                                              <div class="col-md-11 float-left text-right">
                                                <p v-if="approveDatas.leave_comments" style="margin-top:6px;margin-bottom: 0px;">
                                                  <span style="border: 1px solid #7ef0ff;padding: 5px 50px;background: #18aaff0d;">{{approveDatas.leave_comments}}</span>
                                                </p>
                                                <p v-else>
                                                  &nbsp;
                                                </p>
                                                <p style="margin-top: 5px;">{{approveDatas.employee_fullname}}, {{approveDatas.created_at}}</p>
                                              </div>
                                              <!-- {{approveDatas}} -->
                                              <div class="col-md-1 float-left text-right">
                                                <!-- <span v-if="approveDatas.employee_image">
                                                  <img  :src="`images/${approveDatas.employee_image}`" class="card-img-top border rounded" style="margin-top:2px; width: 55px; height: 55px; border-radius:50px !important;">
                                                </span>
                                                
                                                <span v-else>
                                                  <img v-if="url !== '' || approveDatas.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-top: 2px; width: 55px; height: 55px; border-radius:50px !important;">
                                                </span> -->
                                              </div>
                                            </div>
                                             <input type="hidden" v-model="form_data.employee_id">
                                            <span v-if="form_data.approveParmition==1">  
                                              <span v-if="form_data.late_approve_status !=2 && form_data.late_approve_status !=4"> 
                                                  <div class="col-md-12">
                                                    <p style="margin-bottom: 3px;font-size: 17px;"><label>Comment</label></p>
                                                    <textarea style="border: 1px solid #7ef0ff;background: #18aaff0d;"  class="form-control" v-model="form_data.leave_comments"></textarea>
                                                  </div>

                                                  <div class="col-md-12" style="margin-top:15px; margin-bottom:30px;">
                                                    <button type="button" @click="add({add:'approveOrReject/late_request'}, form_data.approve_reject_status=1)" class="btn btn-md btn-info float-right col-md-2"
                                                    style="background-color:#3ca6ea; border-color:#3ca6ea">
                                                      <i class="fa fa-check"></i> 
                                                        Approve
                                                    </button>
                                                    <button type="button" @click="add({add:'approveOrReject/late_request'},form_data.approve_reject_status=2)" class="btn btn-md btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;    margin-bottom: 15px;    color: #d48c06;"> 
                                                        Decline
                                                    </button>
                                                  </div>
                                                </span>
                                              </span>
                                          </form>
                                        </div>


                                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" style="margin-top:15px;">
                                          
                                            <div class="row col-md-12">
                                              <div class="col-md-7 employee-info">
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
                                                   
                                                    
                                                    <tr>
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
                                                    </tr>
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
                                                      <td>{{form_data.designation_name}}</td>
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
                                                          <span v-if="approveDatas.leave_late_approve_status==3">
                                                              <strong> Forwarded </strong>
                                                          </span>
                                                          <span v-if="approveDatas.leave_late_approve_status==2">
                                                              <strong> Approved </strong>
                                                          </span>
                                                           <span v-if="approveDatas.leave_late_approve_status==4">
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
            // moment:'',
          }
        },
        //  props: {
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
        },
        methods:{
          getDataActiveIctive(v){
            this.page_loading = false;
            this.modal_loading=false;
            this.search_input.search_inpu_all=v;
            this.getResults();
          },
        dateToYYYYMMDD(d) {
            return d && new Date(d.getTime()-(d.getTimezoneOffset()*60*1000)).toISOString().split('T')[0];
        },
        updateValue: function (target) {




          // console.log(this.form_data.leave_from_date);
          // console.log(this.form_data.leave_to_date);

          const date1 = new Date(this.form_data.leave_from_date);
          const date2 = new Date(this.form_data.leave_to_date);
          const diffTime = Math.abs(date2 - date1);
          const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
          this.totalDays=(+ diffDays)+(+1) + " d";
          this.totalDayss=(+ diffDays)+(+1);
          this.$emit('input', target.valueAsDate);


          let leave_info = this.form_data.leaveInfo;
          let obj =leave_info.find(data => data.id == this.form_data.leave_type);
          this.remaining_days = obj.balance - this.totalDayss;
          // console.log(this.remaining_days);

          
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
            this.form_data.leave_reliever= option.id;
            this.form_data.employee_id=this.form_data.leave_reliever;
            console.log(this.form_data.employee_id);
            console.log(option);
            let allData =this.form_data.user_employee_data_all[option.id];
            this.form_data.employee_id= allData['id']; 


             

            // form_data.leaveInfo
            // this.form_data.user_employee_data.employee_id_no= allData['employee_id_no']; 
            // this.form_data.user_employee_data.employee_fullname= allData['employee_fullname']; 
            // this.form_data.user_employee_data.employee_mobile= allData['employee_mobile']; 
            // this.form_data.user_employee_data.employee_joining_date=allData['employee_joining_date'];
            // this.form_data.user_employee_data.employee_type=allData['employee_type'];
            // this.form_data.user_employee_data.designation_name=allData['designation_name'];
            // this.form_data.user_employee_data.department_name=allData['department_name'];
            // this.form_data.user_employee_data.sbu_name=allData['sbu_name'];
            
            // this.getModalData($event,{dataUrl:'create/late_request'});
            // console.log(this.form_data.user_employee_data);
          },
          getModalDataOther(id){
               console.log('aaaaaa');
                let uri = URL.baseUrl('edit/otherCreate/'+id);
                console.log(uri);
                axios.get(uri)
                .then(res => {
                  console.log(res.data);
                  // console.log('aaaaaa');
                  this.form_data = res.data;
                  this.form_data.employee_id=id;
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
            console.log(this.form_data.leave_type);
          },
          onSelectEmployee(option){
            console.log(option);
            this.form_data.leave_reliever= option.id;
            console.log(this.form_data.leave_reliever);
            let allData =this.form_data.user_employee_data_all[option.id];

            // alert(allData);
            // console.log(allData);

            // this.form_data.leave_reliever_contact=allData['employee_desi'];
            if (allData['employee_mobile']!='') {
              this.form_data.leave_reliever_contact=allData['employee_mobile'];
              this.form_data.designation_name=allData['designation_name'];
              this.form_data.sbu_name=allData['sbu_name'];
            }else{
              this.form_data.leave_reliever_contact='';
              this.form_data.designation_name=allData['designation_name'];
              this.form_data.sbu_name=allData['sbu_name'];
            }
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
          setModalData(){
            this.employee_name_search=this.form_data.employee_name_search;
            this.employee_name_value=this.form_data.employee_name_value;
            this.leave_type_value=this.form_data.leave_type_value;
          },
          resetModal(){
            // alert('ss');
            this.form_data.employee_id= this.form_data.user_employee_data.id;
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
</style>