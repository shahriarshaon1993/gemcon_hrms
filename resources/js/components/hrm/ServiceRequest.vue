<template>
<div>
    <!-- add_new_type = 1 for Apply -->
    <!-- add_new_type = 2 for Add New -->
    <!-- add_new_type = 3 for Edit -->
    <!-- add_new_type = 4 for View -->
    <!-- add_new_type = 5 for Approve -->
    <!-- add_new_type = 7 for Leave Form -->
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
                                        <h3 class="card-title d-none d-md-block">
                                        Service Requests</h3>
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
                                      <span class="info-box-text">Request </span>
                                      <span class="info-box-number">
                                        {{lists.requestApplications}}
                                      </span>
                                    </div>
                                  </div>
                                  </a>
                                </div>
                                 <div class="col-12 col-sm-12 col-md-3" style="max-width: 20%;">
                                  <a @click="getDataActiveIctive('Pending')"  style="color: #000">
                                   <div class="info-box">
                                     <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
                                     <div class="info-box-content">
                                       <span class="info-box-text">Pending </span>
                                       <span class="info-box-number">
                                         {{lists.pendingApplications}}
                                       </span>
                                     </div>
                                   </div>
                                   </a>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-3" style="max-width: 20%;">
                                  <a @click="getDataActiveIctive('Accepted')"  style="color: #000">
                                   <div class="info-box mb-3">
                                     <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>

                                     <div class="info-box-content">
                                       <span class="info-box-text">Done </span>
                                       <span class="info-box-number">{{lists.acceptedApplications }}</span>
                                     </div>
                                   </div>
                                   </a>
                                 </div>

                                 <!-- fix for small devices only -->
                                 <div class="clearfix hidden-md-up"></div>
                                 <div class="col-12 col-sm-12 col-md-3" style="max-width: 20%;">
                                 <a @click="getDataActiveIctive('Rejected')"  style="color: #000">
                                   <div class="info-box mb-3">
                                     <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-ban"></i></span>
                                     <div class="info-box-content">
                                       <span class="info-box-text">Rejected </span>
                                       <span class="info-box-number">{{lists.rejectedApplications}}</span>
                                     </div>
                                   </div>
                                   </a>
                                 </div>

                             </div>
                             </div>
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
                                    <th class="text-center" v-bind:class="getSortingClass('service_date')" @click="sortingChanged('service_date')">Request Date <i class="fas fa-sort"></i></th>
                                    <th class="text-center" v-bind:class="getSortingClass('employee_id_no')" @click="sortingChanged('employee_id_no')">ID <i class="fas fa-sort"></i></th>
                                    <th class="text-center" v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Employee <i class="fas fa-sort"></i></th>
                                    <th class="text-center" v-bind:class="getSortingClass('leave_type_name')" @click="sortingChanged('leave_type_name')"> Serv. Type <i class="fas fa-sort"></i></th>
                                    <th class="text-center" v-bind:class="getSortingClass('service_date_from')" @click="sortingChanged('service_date_from')">Date <i class="fas fa-sort"></i></th>
                                    <th class="text-center" v-bind:class="getSortingClass('service_purpose')" @click="sortingChanged('service_purpose')">Purpose <i class="fas fa-sort"></i></th>
                                    <th class="text-center" v-bind:class="getSortingClass('approve_status')" @click="sortingChanged('approve_status')">Status <i class="fas fa-sort"></i></th>
                                    <th>Action</th>
                                 </tr>
                                 </thead>
                                 <tbody v-if="Object.keys(paginate_data.data).length > 0">
                                  <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
                                     <td class="text-center">{{index+1}}</td>
                                     <td class="text-center">{{form_data.service_date}}</td>
                                     <td>{{form_data.employee_id_no}}</td>
                                     <td>{{form_data.employee_fullname}}</td>
                                     <td>
                                        <span v-if="form_data.service_type==1">
                                           NOC (No Objection Certificate)
                                        </span>
                                        <span v-if="form_data.service_type==2">
                                           Salary Certificate
                                        </span>
                                        <span v-if="form_data.service_type==3">
                                           Pay Slip
                                        </span>
                                        <span v-if="form_data.service_type==5">
                                           Employment Certificate
                                        </span>
                                        <span v-if="form_data.service_type==6">
                                           Experience Certificate
                                        </span>
                                     </td>
                                     <td>{{form_data.service_date_from+' to '+form_data.service_date_to}}</td>
                                     <td>{{form_data.service_purpose}}</td>
                                     <td class="text-center" v-if="form_data.approve_status==1"> Requested</td>
                                     <td class="text-center" v-if="form_data.approve_status==2"> Done</td>
                                     <td class="text-center" v-if="form_data.approve_status==3"> Forwarded</td>
                                     <td class="text-center" v-if="form_data.approve_status==4"> Rejected</td>
                                     <td style="padding: 5px 5px; text-align: center;">
                                        <button v-if="lists.view=='view'" @click="getModalData($event,{dataUrl:'edit/service_request/'+form_data.id},setModalData, add_new_type = 4)" class="btn-xs btn-success" title="Approve" style="margin-bottom:5px;"> <i class="fa fa-eye"> </i></button>
                                        <button v-if="lists.employment_certificate=='employment_certificate' && form_data.service_type==5" @click="getModalData($event,{dataUrl:'salary_certificate/service_request/'+form_data.id},setModalData, add_new_type =12)" class="btn-xs btn-info" title="Employment Certificate" > <i class="fa fa-print"> </i></button>
                                        <button v-if="lists.emp_experience_print=='emp_experience_print' && form_data.service_type==6" @click="getModalData($event,{dataUrl:'salary_certificate/service_request/'+form_data.id},setModalData, add_new_type =13)" class="btn-xs btn-info" title="Experience Certificate" > <i class="fa fa-print"> </i></button>
                                        <button v-if="lists.employee_noc=='employee_noc' && form_data.service_type==1" @click="getModalData($event,{dataUrl:'salary_certificate/service_request/'+form_data.id},setModalData, add_new_type =14)" class="btn-xs btn-info" title="Employee NOC" > <i class="fa fa-print"> </i></button>
                                       
                                        <button v-if="lists.print=='print' && form_data.service_type==2" @click="getModalData($event,{dataUrl:'salary_certificate/service_request/'+form_data.id},setModalData, add_new_type =9)" class="btn-xs btn-info" title="Salary Print"><i class="fa fa-print"></i></button>
                                       
                                       <span v-if="form_data.approve_status ==1"> 
                                          <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/service_request/'+form_data.id},setModalData, add_new_type = 3)" class="btn-xs btn-info" title="Edit" > <i class="fa fa-edit"> </i></button>
                                       </span>
                                       <span v-if="form_data.approve_status !=1">
                                         <button v-if="lists.edit=='edit'" class="btn-xs btn-info" title="Already Task Completed!" @click="AccessDenied($event,value='Already Task Completed')" style="opacity: 0.5"> <i class="fa fa-edit"> </i></button>
                                       </span>
                                       <span v-if="form_data.approve_status ==1">  
                                        <button  v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/service_request/'+form_data.id})" title="Delete" class="btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                       </span>
                                       <span v-if="form_data.approve_status !=1">
                                         <button v-if="lists.delete=='delete'" class="btn-xs btn-danger" title="Already Task Completed!" @click="AccessDenied($event,value='Already Task Completed')" style="opacity: 0.5"> <i class="fa fa-trash"></i></button>
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

                <modal v-if="add_new_type==3 || add_new_type==4" ref="modal" class="" name="myModal" height="auto" :clickToClose="false" body-class="p-0">
                      <div v-if="modal_loading">
                            <div class="widget-header modal-header">
                            <h5 v-if="add_new_type!=5">
                                <i class="fa fa-bars"></i>
                              Service Request
                            </h5>
                            <h5 v-if="add_new_type==5">
                              <i class="fa fa-bars"></i>
                              Service Request Approval
                            </h5>
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
                                            <td>Name</td>
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
                                      <div class="col-md-4 leave-info text-right" v-if="add_new_type==5">
                                        <span v-if="form_data.user_employee_data.employee_image">
                                          <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top:2px; width: 150px; height: 170px;">
                                        </span>
                                        <span v-else>
                                          <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-top: 2px; width: 150px; height: 170px;">
                                        </span>
                                      </div>
                                      <span class="col-md-12 leave-info" v-if="add_new_type==4">
                                          <input type="hidden" v-model="form_data.employee_id">
                                          <div class="col-md-12 float-left">
                                            <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                                <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Service Type <span class="required_sign">*</span></label>
                                                </div>
                                                <div class="col-md-8 float-left inputGroupContainer">
                                                  <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                  <select class="form-control js-example-basic-single" v-model="form_data.service_type" disabled>
                                                        <option class="select_subject_type">--Select--</option>
                                                        <option value="1">NOC (No Objection Certificate)</option>
                                                        <option value="2">Salary Certificate</option>
                                                        <option value="3">Pay Slip</option>
                                                        <option value="4">Manual Attendance</option>
                                                        <option value="5">Late Approval</option>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div> 
                                          
                                            <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                                <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Date <span class="required_sign">*</span></label>
                                                </div>
                                                <div class="col-md-8 float-left inputGroupContainer" style="padding-right: 0px;">
                                                  <div class="form-group datepicker-container">
                                                      <div class="col-md-6 float-left" style="padding: 0px;">
                                                        <div class="input-group">
                                                          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                              <input 
                                                                v-model="form_data.service_date_from" 
                                                                type="date"
                                                                ref="input"
                                                                v-on:input="updateValue($event.target)"
                                                                v-on:focus="selectAll"
                                                                v-on:keyup="updateValue($event.target)"
                                                                @click="updateValue($event.target)"
                                                                style="width:100%;"
                                                                readonly>
                                                            </div>
                                                        </div>
                                                      </div>

                                                      <div class="col-md-6 float-left" style="padding:0px;">
                                                            <div class="input-group">
                                                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <input 
                                                                v-model="form_data.service_date_to" 
                                                                type="date"
                                                                ref="input"
                                                                v-on:input="updateValue($event.target)"
                                                                v-on:focus="selectAll"
                                                                v-on:keyup="updateValue($event.target)"
                                                                @click="updateValue($event.target)"
                                                                style="width:100%;"
                                                                readonly>
                                                            </div>
                                                            </div>
                                                      </div>
                                                  </div>
                                                </div>
                                            </div> 
                                            <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                                <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Purposes <span class="required_sign">*</span></label>
                                                </div>
                                                <div class="col-md-8 float-left inputGroupContainer">
                                                  <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                  <textarea v-model="form_data.service_purpose" class="form-control"  type="text" readonly></textarea>
                                                    </div>
                                                </div>
                                            </div> 
                                          </div>
                                          <span v-if="form_data.approve_status !=4">  
                                          <span v-if="form_data.approve_status !=2"> 
                                          <div v-if="form_data.approveParmition==1" class="col-md-12" style="padding:0px;">
                                              <div class="form-group">
                                                <label class="col-md-4 control-label" style="margin-bottom: 10px;">Remarks</label>
                                                <div class="col-md-12 inputGroupContainer">
                                                    <div class="input-group">
                                                      <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                      <textarea v-model="form_data.comments" id="city" name="city" placeholder="Write your comment ......" class="form-control" required="true" type="text"></textarea>
                                                  </div>
                                                </div>
                                              </div>
                                          </div>
                                          <div class="form-actions col-md-12" v-if="form_data.approveParmition==1">
                                                <button type="button" @click="add({add:'approveOrReject/service_request'}, form_data.approve_reject_status=1)" class="btn btn-sm btn-success float-right col-md-2">Accept</button>
                                              <button type="button" @click="add({add:'approveOrReject/service_request'},form_data.approve_reject_status=2)" class="btn btn-sm btn-danger float-right col-md-2 offset-md-6" style="margin-right: 10px;">Reject</button>
                                          </div>
                                        </span>
                                        </span>
                                      </span>
                                </div>

                                <span v-if="add_new_type==3 || add_new_type==1 || add_new_type==2">
                                <form class="well form-horizontal needs-validation leave-application" @submit.prevent="add({add:'add/service_request'})">
                                  <input type="hidden" v-model="form_data.employee_id">
                                  <div class="row" style="margin:0px">
                                    <div class="col-md-12">
                                      <div class="col-md-12 float-left">
                                        <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                            <label class="control-label">Service Type <span class="required_sign">*</span></label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer">
                                              <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                              <select class="form-control js-example-basic-single" v-model="form_data.service_type">
                                                    <option>--Select--</option>
                                                    <option value="1">NOC (No Objection Certificate)</option>
                                                    <option value="2">Salary Certificate</option>
                                                    <option value="3">Pay Slip</option>
                                                    <option value="4">Manual Attendance</option>
                                                    <option value="5">Late Approval</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                            <label class="control-label">Date <span class="required_sign">*</span></label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer" style="padding-right: 0px;">
                                              <div class="form-group datepicker-container">
                                                  <div class="col-md-6 float-left" style="padding: 0px;">
                                                    <div class="input-group">
                                                      <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                          <input 
                                                            v-model="form_data.service_date_from" 
                                                            type="date"
                                                            ref="input"
                                                            v-on:input="updateValue($event.target)"
                                                            v-on:focus="selectAll"
                                                            v-on:keyup="updateValue($event.target)"
                                                            @click="updateValue($event.target)"
                                                            style="width:100%;"
                                                            >
                                                        </div>
                                                    </div>
                                                  </div>

                                                  <div class="col-md-6 float-left" style="padding:0px;">
                                                        <div class="input-group">
                                                          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <input 
                                                            v-model="form_data.service_date_to" 
                                                            type="date"
                                                            ref="input"
                                                            v-on:input="updateValue($event.target)"
                                                            v-on:focus="selectAll"
                                                            v-on:keyup="updateValue($event.target)"
                                                            @click="updateValue($event.target)"
                                                            style="width:100%;"
                                                            >
                                                        </div>
                                                        </div>
                                                  </div>

                                                  <!-- <div class="col-md-2 float-right" style="padding:0px">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            {{totalDays}}
                                                        </div>
                                                        </div>
                                                    </div>
                                                  </div> -->
                                              </div>
                                            </div>
                                        </div> 
                                        <div class="row form-group col-md-12" style="margin-bottom:20px !important;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                            <label class="control-label">Purposes <span class="required_sign">*</span></label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer">
                                              <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                              <textarea v-model="form_data.service_purpose" id="city" name="city" placeholder="" class="form-control" required="true" type="text"></textarea>
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
                            </div>
                          </div>
                      </div>
                      <div v-if="!modal_loading">
                          <pageLoading></pageLoading>
                      </div>
                </modal>

                 <modal v-if="add_new_type==9" ref="modal" id="salary-certificate" class="" name="myModal" transition="scale" height="auto" :clickToClose="false" body-class="p-0" style="width:101% !important">
                    <div class="widget-header modal-header">
                      <h5>
                        <i class="fa fa-bars"></i>
                        Salary Certificate
                      </h5>  
                      <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modify-wraper modal-body1">
                      <div class="row form-group" style="margin-top:10px;">
                          <div class="col-md-10"></div>
                          <div class="col-md-2">
                            <button  @click="printLeave(9)" class="btn-xs btn-info" data-toggle="modal" data-target="#myModal1">Print</button>
                            <button class="btn-xs btn-primary" @click="Export2Word('salaryCertificatePrint', 'Salary Certificate')">Word</button>
                          </div>
                      </div>
                      <div id="salaryCertificatePrint"  class="col-md-12 print" style="padding: 70px;text-align: justify !important;" align="center">
                        <p style="margin-bottom:0px !important;">Ref: &nbsp;&nbsp;&nbsp;&nbsp; {{form_data.sbu_short_name}}/HR/Salary Certificate/{{form_data.no_of_salary_certificate}}/{{form_data.current_year}}</p>
                        <p style="margin-bottom:0px !important;">Date:&nbsp;&nbsp;&nbsp; {{form_data.current_day}}<sup>{{form_data.sup_format}}</sup> of {{form_data.current_month}}, {{form_data.current_year}}</p>
                        <p>&nbsp;</p>
                        <p style="text-align:center;font-size: 20px;"><strong><u>Letter of Introduction</u></strong></p>
                        <p>We are pleased to certify that <strong></strong><strong>{{form_data.mr_ms}} {{form_data.user_employee_data.employee_fullname}} </strong>has been working with {{form_data.sbu_name}} since {{form_data.employee_joining_day}}<sup>{{form_data.joining_sup_format}}</sup>{{form_data.employee_joining_month_year}}. {{form_data.he_or_she}} is a {{form_data.employee_type_value}} employee of the company and currently holding the position of {{form_data.designation_name}} of {{form_data.sbu_name}}.</p>
                        <p>His monthly salary structure is as follows:</p>
                        <table style="margin-left: 10%;">
                          <tbody>
                            <tr>
                              <td width="374">
                                <p style="margin:0px !important;">Basic Salary ({{form_data.basic_salary_percentage}}% of Gross Salary)</p>
                              </td>
                              <td width="45">
                                <p style="margin:0px !important;">: Tk.</p>
                              </td>
                              <td width="105" style="text-align:right;">
                                <p style="margin:0px !important;">{{form_data.basic_salary}}</p>
                              </td>
                            </tr>
                            <tr>
                              <td width="374">
                                <p style="margin:0px !important;">House Rent ({{form_data.housing_allowance_percentage}}% of Gross Salary)</p>
                              </td>
                              <td width="45">
                                <p style="margin:0px !important;">: Tk.</p>
                              </td>
                              <td width="105" style="text-align:right;">
                                <p style="margin:0px !important;">{{form_data.housing_allowance}}</p>
                              </td>
                            </tr>
                            <tr>
                              <td width="374">
                                <p style="margin:0px !important;">Medical Allowance ({{form_data.medical_allowance_percentage}}% of Gross Salary)</p>
                              </td>
                              <td width="45">
                                <p style="margin:0px !important;">: Tk.</p>
                              </td>
                              <td width="105" style="text-align:right;">
                                <p style="margin:0px !important;">{{form_data.medical_allowance}}</p>
                              </td>
                            </tr>
                            <tr>
                              <td width="374">
                                <p style="margin:0px !important;">Conveyance ({{form_data.conveyance_allowance_percentage}}% of Gross Salary)</p>
                              </td>
                              <td width="45">
                                <p style="margin:0px !important;">: Tk.</p>
                              </td>
                              <td width="105" style="text-align:right;">
                                <p style="margin:0px !important;">{{form_data.conveyance_allowance}}</p>
                              </td>
                            </tr>
                            <tr>
                              <td width="374">
                                <p style="margin:0px !important;"><strong>Gross Salary</strong></p>
                              </td>
                              <td width="45">
                                <p style="margin:0px !important;"><strong>: Tk.</strong></p>
                              </td>
                              <td width="105"  style="text-align:right;">
                                <p style="margin:0px !important;"><span style="border-top:2px solid #000; font-weight:bold;">{{form_data.gross_salary}}</span></p>
                              </td>
                            </tr>
                            <tr>
                              <td width="374">
                                <p style="margin:0px !important;"><u>Deductions</u></p>
                              </td>
                              <td width="45">
                                <p style="margin:0px !important;">&nbsp;</p>
                              </td>
                              <td width="105"  style="text-align:right;">
                                <p style="margin:0px !important;">&nbsp;</p>
                              </td>
                            </tr>
                            <tr>
                              <td width="374">
                                <p style="margin:0px !important;">Provident Fund ({{form_data.provident_fund_percentage}}% of Basic Salary)</p>
                              </td>
                              <td width="45">
                                <p style="margin:0px !important;">: Tk.</p>
                              </td>
                              <td width="105"  style="text-align:right;">
                                <p style="margin:0px !important;">{{form_data.provident_fund}}</p>
                              </td>
                            </tr>
                            <tr>
                              <td width="374">
                                <p style="margin:0px !important;">Tax</p>
                              </td>
                              <td width="45">
                                <p style="margin:0px !important;">: Tk.</p>
                              </td>
                              <td width="105"  style="text-align:right;">
                                <p style="margin:0px !important;">{{form_data.tax_deduction}}</p>
                              </td>
                            </tr>
                            <tr>
                              <td width="374">
                                <p style="margin:0px !important;"><strong>Take Home Salary</strong></p>
                              </td>
                              <td width="45">
                                <p style="margin:0px !important;"><strong>: Tk.</strong></p>
                              </td>
                              <td width="105"  style="text-align:right;">
                                <p><span style="border-top:2px solid #000; font-weight:bold;">{{form_data.salary_goes_bank}}</span></p>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3">
                                <p style="margin:0px !important;">In word: {{form_data.total_amount_inwords}}</p>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <p>&nbsp;</p>
                        <p style="margin:0px !important;">In addition, <span v-if="form_data.cash_salary != 0">{{form_data.user_employee_data.employee_fullname}} receives Tk.{{form_data.cash_salary}} in cash and</span><span v-else> {{form_data.he_or_she}} is</span>  entitled to get yearly festival bonus (one gross salary in two festivals).</p>
                        <p>&nbsp;</p>
                        <p>Best Regards,</p>
                        <p>&nbsp;</p>
                        <p style="margin-bottom:0px;">______________</p>
                        <p style="margin-bottom:0px;"><strong>S. M. Rakibul Haque</strong></p>
                        <p style="margin-bottom:0px;">Head of HR &amp; Administration</p>
                        <p style="margin-bottom:0px;">Gemcon Group</p>
                        <p style="margin-bottom:0px;">&nbsp;</p>
                        <p>Cc: Personal File</p>
                        <p>&nbsp;</p>  
                      </div>
                    </div>
                </modal>   

                <modal v-if="add_new_type==12" ref="modal" id="salary-certificate" class="" name="myModal" transition="scale" height="auto" :clickToClose="false" body-class="p-0" style="width:101% !important">
                    <div class="widget-header modal-header">
                      <h5>
                        <i class="fa fa-bars"></i>
                        Employment Certificate
                      </h5>  
                      <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modify-wraper modal-body1">
                      <div class="row form-group" style="margin-top:10px;">
                          <div class="col-md-10"></div>
                          <div class="col-md-2">
                            <button  @click="printLeave(12)" class="btn-xs btn-info">Print</button>
                            <button class="btn-xs btn-primary" @click="Export2Word('employmentCertificatePrint', 'Salary Certificate')">Word</button>
                          </div>
                      </div>
                      <div id="employmentCertificatePrint"  class="col-md-12 print" style="padding: 70px;text-align: justify !important;" align="center">
                        <p style="margin-bottom:5px;">Ref: &nbsp;&nbsp;&nbsp;&nbsp; GG/HR/EL/{{form_data.current_year}}</p>
                        <p>Date:&nbsp;&nbsp;&nbsp; {{form_data.current_date}}</p>
                        <p>&nbsp;</p>
                        <p style="text-align:center"><strong><u>TO WHOM IT MAY CONCERN</u></strong></p>

                        <p>This is to certify that <strong>{{form_data.mr_ms}} {{form_data.user_employee_data.employee_fullname}}</strong>, S/O: <span v-if="form_data.user_employee_data.employee_father_name">{{form_data.user_employee_data.employee_father_name}}</span><span style="color:#A52A2A;" v-else>not found!</span> and <span v-if="form_data.user_employee_data.employee_mother_name">{{form_data.user_employee_data.employee_mother_name}}</span><span style="color:#A52A2A;" v-else>not found!</span>, House {{form_data.user_employee_data.present_holding_no}} <span v-if="form_data.user_employee_data.present_house_name">,{{form_data.user_employee_data.present_house_name}}</span> <span v-if="form_data.user_employee_data.present_road_no">,{{form_data.user_employee_data.present_road_no}}</span> <span v-if="form_data.user_employee_data.present_road_name">,{{form_data.user_employee_data.present_road_name}}</span>, {{form_data.user_employee_data.district_name}} has been working with {{form_data.sbu_name}} since {{form_data.employee_joining_date}}. He is a {{form_data.employee_type_value}} employee of the company and currently holding the position of {{form_data.designation_name}} of {{form_data.sbu_name}}, {{form_data.department_name}} of Gemcon Group.</p>
                        
                        <p>&nbsp;</p>
                        <p>I wish him every success and an enlightened future.</p>
                        <p>&nbsp;</p>
                        <p>Best Regards,</p>
                        <p>&nbsp;</p>
                        <p style="margin-bottom:5px;">______________</p>
                        <p style="margin-bottom:5px;"><strong>S. M. Rakibul Haque</strong></p>
                        <p style="margin-bottom:5px;">Head of HR &amp; Administration</p>
                        <p style="margin-bottom:5px;">Gemcon Group</p>
                        <p style="margin-bottom:5px;">&nbsp;</p>
                        <p>Cc: Personal File</p>
                        <p>&nbsp;</p>  
                      </div>
                    </div>
                </modal>

                <modal v-if="add_new_type==13" ref="modal" id="salary-certificate" class="" name="myModal" transition="scale" height="auto" :clickToClose="false" body-class="p-0" style="width:101% !important">
                    <div class="widget-header modal-header">
                      <h5>
                        <i class="fa fa-bars"></i>
                        Experience Certificate
                      </h5>  
                      <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modify-wraper modal-body1">
                      <div class="row form-group" style="margin-top:10px;">
                          <div class="col-md-11"></div>
                          <div class="col-md-1">
                            <button  @click="printLeave(13)" class="btn-xs btn-info">Print</button>
                          </div>
                      </div>
                      <div id="experienceCertificatePrint"  class="col-md-12 print" style="padding: 70px;text-align: justify !important;" align="center">
                        <p style="margin-bottom:5px;">Ref: &nbsp;&nbsp;&nbsp;&nbsp; GG/HR/EL/{{form_data.current_year}}</p>
                        <p>Date:&nbsp;&nbsp;&nbsp; {{form_data.current_date}}</p>
                        <p>&nbsp;</p>
                        <p style="text-align:center"><strong><u>TO WHOM IT MAY CONCERN</u></strong></p>

                        <p>This is to certify that <strong>{{form_data.mr_ms}} {{form_data.user_employee_data.employee_fullname}} </strong> served {{form_data.sbu_name}} from {{form_data.employee_joining_date}} to {{form_data.current_date}} as {{form_data.designation_name}}. During his tenure, his services were found satisfactory.</p>

                        <p>&nbsp;</p>
                        <p>We wish him all the best in his future endeavors.</p>
                        <p>&nbsp;</p>
                        <p>Best Regards,</p>
                        <p>&nbsp;</p>
                        <p style="margin-bottom:5px;">______________</p>
                        <p style="margin-bottom:5px;"><strong>S. M. Rakibul Haque</strong></p>
                        <p style="margin-bottom:5px;">Head of HR &amp; Administration</p>
                        <p style="margin-bottom:5px;">Gemcon Group</p>
                        <p style="margin-bottom:5px;">&nbsp;</p>
                        <p>Cc: Personal File</p>
                        <p>&nbsp;</p>  
                      </div>
                    </div>
                </modal> 

                <modal v-if="add_new_type==14" ref="modal" id="salary-certificate" class="" name="myModal" transition="scale" height="auto" :clickToClose="false" body-class="p-0" style="width:101% !important">
                    <div class="widget-header modal-header">
                      <h5>
                        <i class="fa fa-bars"></i>
                        No Objection Certificate (NOC)
                      </h5>  
                      <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modify-wraper modal-body1">
                      <div class="row form-group" style="margin-top:10px;">
                          <div class="col-md-11"></div>
                          <div class="col-md-1">
                            <button  @click="printLeave(13)" class="btn-xs btn-info">Print</button>
                          </div>
                      </div>
                      <div id="experienceCertificatePrint"  class="col-md-12 print" style="padding: 70px;text-align: justify !important;" align="center">
                        <p style="margin-bottom:5px;">Ref: &nbsp;&nbsp;&nbsp;&nbsp; GG/HR/NOC/{{form_data.current_year}}</p>
                        <!-- <p>Date:&nbsp;&nbsp;&nbsp; 28<sup>th</sup> of December, 2021</p> -->
                        <p>Date:&nbsp;&nbsp;&nbsp; {{form_data.current_date}}</p>
                        <p>&nbsp;</p>
                        <p style="text-align:center"><strong><u>TO WHOM IT MAY CONCERN</u></strong></p>
                        <p>
                          This is to certify that <strong>{{form_data.mr_ms}} {{form_data.user_employee_data.employee_fullname}},</strong> {{form_data.designation_name}} in {{form_data.department_name}} Department has been working with {{form_data.sbu_name}} since {{form_data.employee_joining_date}} to till date. He is interested that {{form_data.service_purpose}} from {{form_data.service_date_from}} to {{form_data.service_date_to}}. The management has approved his leave for the mentioned period. 
                        </p>

                        <p>&nbsp;</p>
                        <p>All his tour expenditure regarding his travel will be borne by himself. We do appreciate your co-operation in this regard.</p>
                        <p>&nbsp;</p>
                        <p>Best Regards,</p>
                        <p>&nbsp;</p>
                        <p style="margin-bottom:5px;">______________</p>
                        <p style="margin-bottom:5px;"><strong>S. M. Rakibul Haque</strong></p>
                        <p style="margin-bottom:5px;">Head of HR &amp; Administration</p>
                        <p style="margin-bottom:5px;">Gemcon Group</p>
                        <p style="margin-bottom:5px;">&nbsp;</p>
                        <p>Cc: Personal File</p>
                        <p>&nbsp;</p>  
                      </div>
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
            getContext:'',
          }
        },
         props: {
          value: {
            type: Date,
            default: new Date()
          }
        },
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
          wordExport(){
            let header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>"+
            "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
            let footer = "</body></html>";
            let sourceHTML = header+document.getElementById("salaryCertificatePrint").innerHTML+footer;
            
            let source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
            let fileDownload = document.createElement("a");
            document.body.appendChild(fileDownload);
            fileDownload.href = source;
            fileDownload.download = 'document.doc';
            fileDownload.click();
            document.body.removeChild(fileDownload);
        },

          printLeave (print_value=False) {
            // alert(print_value);
            if(print_value == 9){
                const modal = document.getElementById("salaryCertificatePrint")
                const cloned = modal.cloneNode(true)
                let section = document.getElementById("print")
                if (!section) {
                  section  = document.createElement("div")
                  section.id = "print"
                  document.body.appendChild(section)
                }
                section.innerHTML = "";
                section.appendChild(cloned);
                window.print(); 
                window.close(); 
            }else if(print_value == 12){
                const modal = document.getElementById("employmentCertificatePrint")
                const cloned = modal.cloneNode(true)
                let section = document.getElementById("print")
                if (!section) {
                  section  = document.createElement("div")
                  section.id = "print"
                  document.body.appendChild(section)
                }
                section.innerHTML = "";
                section.appendChild(cloned);
                window.print(); 
                window.close(); 
            }else if(print_value == 13){
                const modal = document.getElementById("experienceCertificatePrint")
                const cloned = modal.cloneNode(true)
                let section = document.getElementById("print")
                if (!section) {
                  section  = document.createElement("div")
                  section.id = "print"
                  document.body.appendChild(section)
                }
                section.innerHTML = "";
                section.appendChild(cloned);
                window.print(); 
                window.close(); 
            } 
            // else{
            //     const modal = '';
            // } 
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
            
            // this.getModalData($event,{dataUrl:'create/service_request'});
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

  #salary-certificate .v--modal-box {
    width: 60%!important;
    left: 20% !important;
  }

  .print:last-child {
     page-break-after: auto;
  }

@media print{
    p{
        font-size: 20px;
    }
    #salaryCertificatePrint{
         margin-top:80px;
    }
}
</style>