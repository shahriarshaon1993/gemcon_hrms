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
                                        <h3 class="card-title d-none d-md-block">Separation List</h3>
                                        <span class="float-sm-right" style="float: right;">
                                          <div  v-if="lists.self=='self'" @click="getModalData($event,{dataUrl:'create/resignation'}, resetModal, add_new_type = 1)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span> </div>

                                          <div v-if="lists.others=='others'" @click="getModalData($event,{dataUrl:'create/resignation'}, resetModal, add_new_type = 2)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Others Resign </span> </div>
                                            <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                                        </span>
                                    </div>
                                </div>
                                  <div class="row">
                                   <div class="col-12 col-sm-12 col-md-3">
                                     <div class="info-box">
                                       <span class="info-box-icon bg-info elevation-1"><i class="fa fa-paper-plane"></i></span>

                                       <div class="info-box-content">
                                         <span class="info-box-text">Request </span>
                                         <span class="info-box-number">
                                           {{lists.requestApplications}}
                                         </span>
                                       </div>
                                     </div>
                                   </div>
                                    <div class="col-12 col-sm-12 col-md-3">
                                      <div class="info-box">
                                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
                                        <div class="info-box-content">
                                          <span class="info-box-text">Pending </span>
                                          <span class="info-box-number">
                                            {{lists.pendingApplications}}
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-3">
                                      <div class="info-box mb-3">
                                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>

                                        <div class="info-box-content">
                                          <span class="info-box-text">Done </span>
                                          <span class="info-box-number">{{lists.acceptedApplications }}</span>
                                        </div>
                                      </div>
                                    </div>

                                    <!-- fix for small devices only -->
                                    <div class="clearfix hidden-md-up"></div>
                                    <div class="col-12 col-sm-12 col-md-3">
                                      <div class="info-box mb-3">
                                        <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-ban"></i></span>
                                        <div class="info-box-content">
                                          <span class="info-box-text">Rejected </span>
                                          <span class="info-box-number">{{lists.rejectedApplications}}</span>
                                        </div>
                                      </div>
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
                                  <th class="text-center">SL</th>
                                  <th v-bind:class="getSortingClass('employee_id_no')" @click="sortingChanged('employee_id_no')">Employee ID <i class="fas fa-sort"></i></th>
                                  <th v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Employee <i class="fas fa-sort"></i></th>
                                  <th v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Comp./SBU  <i class="fas fa-sort"></i></th>
                                  <th v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Department <i class="fas fa-sort"></i></th>
                                  <th v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Designation <i class="fas fa-sort"></i></th>
                                  <th v-bind:class="getSortingClass('separation_type')" @click="sortingChanged('separation_type')">Separation Type <i class="fas fa-sort"></i></th>
                                  <th v-bind:class="getSortingClass('employee_joining_date')" @click="sortingChanged('employee_joining_date')">Joining Date <i class="fas fa-sort"></i></th>
                                  <th v-bind:class="getSortingClass('separation_date')" @click="sortingChanged('separation_date')">Resignation Date <i class="fas fa-sort"></i></th>
                                  <th v-bind:class="getSortingClass('separation_date')" @click="sortingChanged('separation_date')">Last Working Date <i class="fas fa-sort"></i></th>
                                  <th v-bind:class="getSortingClass('leave_apply_status')" @click="sortingChanged('leave_apply_status')">Status <i class="fas fa-sort"></i></th>
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
                                       <span v-if="form_data.separation_type==1">Resignation</span>
                                       <span v-if="form_data.separation_type==2">Termination</span>
                                       <span v-if="form_data.separation_type==3">Retired</span>
                                       <span v-if="form_data.separation_type==4">Retracement</span>
                                       <span v-if="form_data.separation_type==5">Died</span>
                                     </td>
                                     <td>{{form_data.employee_joining_date}}</td>
                                     <td>{{form_data.separation_date}}</td>
                                     <td>{{form_data.last_working_date}}</td>
                                     
                                     
                                     <td v-if="form_data.resignation_status==1"> Requested</td>
                                     <td v-if="form_data.resignation_status==2"> Approved</td>
                                     <td v-if="form_data.resignation_status==3"> Forwarded</td>
                                     <td v-if="form_data.resignation_status==4"> Rejected</td>
                                     <td style="padding: 5px 5px">
                                        <button v-if="lists.approve=='approve'" @click="getModalData($event,{dataUrl:'edit/resignation/'+form_data.id},setModalData, add_new_type = 4)" class="btn-xs btn-success" title="Approve" > <i class="fa fa-eye"> </i></button>


                                        <!-- Edit Button Task -->
                                        <button v-if="lists.edit=='edit' && form_data.resignation_status==2" class="btn-xs btn-info" title="Already Approved!" @click="AccessDenied($event,value='Already Approved')" style="opacity: 0.5"> <i class="fa fa-edit"> </i></button>

                                        <button v-if="lists.edit=='edit' && form_data.resignation_status==3" class="btn-xs btn-info" title="Already Forwarded!" @click="AccessDenied($event,value='Already Forwarded')" style="opacity: 0.5"> <i class="fa fa-edit"> </i></button>

                                        <button v-if="lists.edit=='edit' && form_data.resignation_status==4" class="btn-xs btn-info" title="Already Rejected!" @click="AccessDenied($event,value='Already Rejected')" style="opacity: 0.5"> <i class="fa fa-edit"> </i></button>

                                        <button v-if="lists.edit=='edit' && form_data.resignation_status==1" @click="getModalData($event,{dataUrl:'edit/resignation/'+form_data.id},setModalData, add_new_type = 3)" class="btn-xs btn-info" title="Edit"> <i class="fa fa-edit"> </i></button>
                                        <!-- Edit Button Task -->

                                        <button  v-if="lists.delete=='delete' && form_data.resignation_status==1" @click="deleteItem({delUrl:'delete/resignation/'+form_data.id})" title="Delete" class="btn-xs btn-danger"><i class="fa fa-trash"></i> </button>

                                        <button  v-if="lists.delete=='delete' && form_data.resignation_status==2"  @click="AccessDenied($event,value='Already Approved!')" style="opacity: 0.5" title="Delete" class="btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                        <button  v-if="lists.delete=='delete' && form_data.resignation_status==3"  @click="AccessDenied($event,value='Already Forwarded!')" style="opacity: 0.5" title="Delete" class="btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                        <button  v-if="lists.delete=='delete' && form_data.resignation_status==4"  @click="AccessDenied($event,value='Already Rejected!')" style="opacity: 0.5" title="Delete" class="btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
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
                                  <div class="dataTables_footer clearfix col-md-12 col-12" style="padding: 10px 0px; float: right;">
                                      <div class="col-md-6 col-6 float-left">
                                          <div class="dataTables_info" id="DataTables_Table_0_info">Showing {{paginate_data.current_page}} of {{paginate_data.last_page}} pages</div>
                                      </div>
                                      <div class="col-md-6 col-6 float-right">
                                          <div class="dataTables_paginate paging_bootstrap float-right overflow-auto" style="width: 100%;">
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

                 <modal ref="modal" class="employee-modal" name="myModal" height="auto" :clickToClose="false" body-class="p-0">
                      <div v-if="modal_loading">
                          <div class="widget-header modal-header">
                              <h4 v-if="add_new_type==3 || add_new_type==1 || add_new_type==4"><i class="fa fa-bars"></i> Self {{this.resignation_type_name}}</h4>
                              <h4 v-if="add_new_type==2"><i class="fa fa-bars"></i> Others {{this.resignation_type_name}}</h4>
                              <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          </div>
                          <div class="modify-wraper modal-body">
                                    <div class="">
                                  <span v-if="add_new_type==3 || add_new_type==1 || add_new_type==2">
                                    <form class="" @submit.prevent="add({add:'add/resignation'})">
                                        <div class="row col-md-12" style="overflow-y:auto !important; margin-top:15px;margin-bottom: 15px;">
                                          <div class="col-md-5 leave-info date_format_modal_design">
                                            <div class="col-md-12" v-if='add_new_type==2'>
                                              <!-- <div class="col-md-12"> -->
                                                <div class="form-group">
                                                  <label>Search Employee</label>
                                                  <vue-select v-model="employee_name_search" :options="option_data.employee_data" @select="onSelectEmployeeSearch" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                </div>
                                              <!-- </div> -->
                                            </div>
                                              <input type="hidden" v-model="form_data.employee_id">
                                              <div class="row">
                                                <div class="col-md-12">
                                                   <div class="form-group datepicker-container">
                                                      <div class="form-group">
                                                         <label class="col-md-12 control-label">Separation Type</label>
                                                         <div class="col-md-12 inputGroupContainer">
                                                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                             <select v-model="form_data.separation_type" name="employee_type" class="selectpicker form-control" @change="onSelectSeparationType($event)">
                                                                <option value="0">--Select--</option>
                                                                <option value="1">Resignation</option>
                                                                <option value="2">Termination</option>
                                                                <option value="3">Retired</option>
                                                                <option value="4">Retracement</option>
                                                                <option value="5">Died</option>
                                                             </select>
                                                           </div>
                                                         </div>
                                                      </div>
                                                      <div class="form-group">
                                                         <label class="col-md-4 control-label">Reason</label>
                                                         <div class="col-md-12 inputGroupContainer">
                                                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                              <input style="padding-left:0px;" v-model="form_data.separation_reason" id="remarks" name="remarks" placeholder="" class="form-control" required="true" type="text"></div>
                                                         </div>
                                                      </div>
                                                      <!-- <div class="row col-md-12"> -->
                                                        <div class="form-group co-md-12">
                                                           <label class="col-md-12 control-label">{{this.resignation_type_name}} Date</label>
                                                           <div class="col-md-12 inputGroupContainer">
                                                              <div class="input-group">
                                                             <!--   <datepicker placeholder="Select Date" v-model="form_data.separation_date"   class="form-control" ></datepicker> -->
                                                               <!-- <input 
                                                                v-model="form_data.separation_date" 
                                                                type="date"
                                                                ref="input"
                                                                style="padding-left:0px; width:100%"
                                                                > -->
                                                                 <input class="form-control" v-model="form_data.separation_date" type="date">
                                                                <!-- <datepicker placeholder="Select Date" v-model="form_data.separation_date" class="form-control"></datepicker> -->
                                                             </div>
                                                           </div>
                                                        </div>
                                                        <div class="form-group co-md-12">
                                                           <label class="col-md-12 control-label">Last Working Date</label>
                                                           <div class="col-md-12 inputGroupContainer">
                                                              <div class="input-group">
                                                               <!-- <datepicker @change="selectAll()"  placeholder="Select Date" v-model="form_data.last_working_date"   class="form-control" ></datepicker> -->
                                                               <!-- <input 
                                                                v-model="form_data.last_working_date" 
                                                                type="date"
                                                                ref="input"
                                                                v-on:input="updateValue($event.target)"
                                                                v-on:focus="selectAll"
                                                                v-on:keyup="updateValue($event.target)"
                                                                v-on:keydown="updateValue($event.target)"
                                                                style="padding-left:0px; width:100%"
                                                                > -->
                                                                 <input class="form-control" v-model="form_data.last_working_date" type="date">
                                                                <!-- <datepicker placeholder="Select Date" v-model="form_data.last_working_date" class="form-control"></datepicker> -->
                                                             </div>
                                                           </div>
                                                        </div>
                                                        <div class="form-group co-md-12">
                                                           <label class="col-md-12 control-label">Effective Date</label>
                                                           <div class="col-md-12 inputGroupContainer">
                                                              <div class="input-group">
                                                                 <input class="form-control" v-model="form_data.effective_date" type="date">
                                                                <!-- <datepicker placeholder="Select Date" v-model="form_data.effective_date" class="form-control"></datepicker> -->

                                                               <!-- <datepicker style="padding-left:0px;" v-if="form_data.effective_date && form_data.id" placeholder="Select Date" v-model="form_data.effective_date" class="form-control"></datepicker>

                                                               <datepicker v-else style="padding-left:0px;" placeholder="Select Datee" v-model="effective_date" class="form-control"></datepicker> -->

                                                             </div>
                                                           </div>
                                                        </div>
                                                      </div>
                                                   <!-- </div> -->
                                                </div>
                                                </div>
                                            
                                          </div>

                                          <div class="col-md-5 employee-info">
                                          <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                                              <tbody>
                                                <tr>
                                                  <td>Employee ID</td>
                                                  <td>:</td>
                                                  <td>{{form_data.user_employee_data.employee_id_no}}</td>
                                                </tr>
                                                <tr>
                                                  <td>Name</td>
                                                  <td>:</td>
                                                  <td>{{form_data.user_employee_data.employee_fullname}}</td>
                                                </tr>
                                                <tr>
                                                  <td>Contact No</td>
                                                  <td>:</td>
                                                  <td>{{form_data.user_employee_data.employee_mobile}}</td>
                                                </tr>
                                                <tr>
                                                  <td>Joining Date</td>
                                                  <td>:</td>
                                                  <td>{{form_data.employee_joining_date_custom}}</td>
                                                </tr>
                                                <tr>
                                                  <td>Status</td>
                                                  <td>:</td>
                                                  <td>
                                                    <span v-if="form_data.user_employee_data.employee_type == 1">{{'Permanent'}}</span>
                                                    <span v-else-if="form_data.user_employee_data.employee_type == 2">{{'Probationary'}}</span>
                                                    <span v-else-if="form_data.user_employee_data.employee_type == 3">{{'Cotractual'}}</span>
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
                                              </tbody>
                                            </table>

                                            <div class="form-group col-md-12">
                                               <label class="col-md-12 control-label">
                                                 Upload Letter
                                                 <!-- <a @click="addRow" id="addCF" class="btn btn-xs btn-info"><i class="fa fa-plus" style="color:#fff;"></i></a> -->
                                               </label>
                                               <!-- <div class="col-md-4 inputGroupContainer float-left"  v-for="(form_data, index) in form_data.educational_infos"> -->
                                               <div class="col-md-12 inputGroupContainer float-left">
                                                 <input type="file" v-on:change="onFileChange"> 
                                               </div>
                                                 <div v-if="form_data.resignation_attachment?form_data.resignation_attachment:''" class="col-md-6 float-left">
                                                   <a target="_blank" :href="'/attachments/' + form_data.resignation_attachment">View Attachment</a>
                                                 </div>
                                                 <div v-else-if="form_data.resignation_attachment==''" class="col-md-6 float-left">
                                                    <p style="color:orange">No attachment found!</p>
                                                 </div>


                                            </div>
                                          </div>
                                          <div class="col-md-2 employee-info">
                                            <samp v-if="form_data.user_employee_data.employee_image">
                                                   <img v-if="form_data.user_employee_data.employee_image!=''" :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-left:-20px; height: 165px; width:145px;">
                                            </samp>
                                            <samp v-else>
                                                <img v-eles :src="`images/default.png`" class="card-img-top border rounded" style="margin-left:-20px; height: 165px; width:145px;">
                                            </samp>
                                        

                                             
                                          </div>
                                      </div>
                                     <div class="form-actions col-md-12">
                                         <input type="submit" tabindex="4" value="Submit" class="btn btn-sm btn-info float-right col-md-2">
                                         <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button>
                                     </div>
                                    </form>
                                </span>
                                 <!-- Approve leave application of employee: modal start from here -->
                                 <!-- Approve leave application of employee: modal start from here -->
                                 <span v-else-if="add_new_type==4">
                                    <form class="well form-horizontal needs-validation leave-application">
                                        <div class="row col-md-12" style="overflow-y:auto !important; margin-top:15px;margin-bottom: 15px;">
                                          <div class="col-md-5 leave-info">
                                            <div class="col-md-12" v-if='add_new_type==2'>
                                              <!-- <div class="col-md-12"> -->
                                                <div class="form-group">
                                                  <label>Search Employee</label>
                                                  <vue-select v-model="employee_name_search" :options="option_data.employee_data" @select="onSelectEmployeeSearch" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                </div>
                                              <!-- </div> -->
                                            </div>
                                              <input type="hidden" v-model="form_data.employee_id">
                                              <div class="row">
                                                <div class="col-md-12">
                                                   <div class="form-group datepicker-container">
                                                      <div class="form-group">
                                                         <label class="col-md-12 control-label">Separation Type</label>
                                                         <div class="col-md-12 inputGroupContainer">
                                                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                             <select style="padding-left:0px;" v-model="form_data.separation_type" name="employee_type" class="selectpicker form-control" @change="onSelectSeparationType($event)">
                                                                <option value="0">--Select--</option>
                                                                <option value="1">Resignation</option>
                                                                <option value="2">Termination</option>
                                                                <option value="3">Retired</option>
                                                                <option value="4">Retracement</option>
                                                                <option value="5">Died</option>
                                                             </select>
                                                           </div>
                                                         </div>
                                                      </div>
                                                      <div class="form-group">
                                                         <label class="col-md-4 control-label">Reason</label>
                                                         <div class="col-md-12 inputGroupContainer">
                                                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                              <input style="padding-left:0px;" v-model="form_data.separation_reason" id="remarks" name="remarks" placeholder="" class="form-control" required="true" type="text" readonly>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <!-- <div class="row col-md-12"> -->
                                                        <div class="form-group co-md-12">
                                                           <label class="col-md-12 control-label">{{this.resignation_type_name}}  Date</label>
                                                           <div class="col-md-12 inputGroupContainer">
                                                              <div class="input-group">
                                                               <!-- <datepicker placeholder="Select Date" v-model="form_data.separation_date" class="form-control" diabled></datepicker> -->
                                                               <input style="padding-left:0px;" v-model="form_data.separation_date" id="remarks" name="remarks" placeholder="" class="form-control" type="text" readonly>
                                                             </div>
                                                           </div>
                                                        </div>
                                                        <div class="form-group co-md-12">
                                                           <label class="col-md-12 control-label">Last Working Date</label>
                                                           <div class="col-md-12 inputGroupContainer">
                                                              <div class="input-group">
                                                               <!-- <datepicker placeholder="Select Date" v-model="form_data.last_working_date" class="form-control" diabled></datepicker> -->
                                                               <input style="padding-left:0px;" v-model="form_data.last_working_date" id="remarks" name="remarks" placeholder="" class="form-control" type="text" readonly>
                                                             </div>
                                                           </div>
                                                        </div>
                                                        <div class="form-group co-md-12">
                                                           <label class="col-md-12 control-label">Effective Date</label>
                                                           <div class="col-md-12 inputGroupContainer">
                                                              <div class="input-group">
                                                               <!-- <datepicker placeholder="Select Date" v-model="form_data.effective_date" class="form-control" diabled></datepicker> -->
                                                               <input style="padding-left:0px;" v-model="form_data.effective_date" id="remarks" name="remarks" placeholder="" class="form-control" type="text" readonly>
                                                             </div>
                                                           </div>
                                                        </div>
                                                      </div>
                                                   <!-- </div> -->
                                                </div>
                                                </div>
                                            
                                          </div>

                                          <div class="col-md-5 employee-info">
                                          <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                                              <tbody>
                                                <tr>
                                                  <td>Employee ID</td>
                                                  <td>:</td>
                                                  <td>{{form_data.user_employee_data.employee_id_no}}</td>
                                                </tr>
                                                <tr>
                                                  <td>Name</td>
                                                  <td>:</td>
                                                  <td>{{form_data.user_employee_data.employee_fullname}}</td>
                                                </tr>
                                                <tr>
                                                  <td>Contact No</td>
                                                  <td>:</td>
                                                  <td>{{form_data.user_employee_data.employee_mobile}}</td>
                                                </tr>
                                                <tr>
                                                  <td>Joining Date</td>
                                                  <td>:</td>
                                                  <td>{{form_data.employee_joining_date_custom}}</td>
                                                </tr>
                                                <tr>
                                                  <td>Status</td>
                                                  <td>:</td>
                                                  <td>
                                                    <span v-if="form_data.user_employee_data.employee_type == 1">{{'Permanent'}}</span>
                                                    <span v-else-if="form_data.user_employee_data.employee_type == 2">{{'Probationary'}}</span>
                                                    <span v-else-if="form_data.user_employee_data.employee_type == 3">{{'Cotractual'}}</span>
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
                                              </tbody>
                                            </table>

                                            <div class="form-group col-md-12">
                                                <div class="row col-md-12" style="padding:0px;">
                                                  <div v-if="form_data.resignation_attachment?form_data.resignation_attachment:''" class="col-md-12 float-left">
                                                    <a target="_blank" :href="'/attachments/' + form_data.resignation_attachment">View Attachment</a>
                                                  </div>
                                                  <div v-else-if="form_data.resignation_attachment==''" class="col-md-12 float-left">
                                                     <p style="color:orange">No attachment found!</p>

                                                  </div>
                                                </div>
                                                 <div class="row col-md-12" >
                                                  <label>
                                                    <strong>Superior Comments:</strong>
                                                 
                                                  </label>
                                                    <table class="table table-hover table-responsive" style="margin-left:-12px;">
                                                        <tbody v-for="(form_data, index) in form_data.resignation_comments" v-if="form_data.comments">
                                                          <tr>
                                                            <td>Name</td>
                                                            <td>:</td>
                                                            <td>{{form_data.employee_fullname}}</td>
                                                          </tr>
                                                          
                                                          <tr>
                                                            <td>ID</td>
                                                            <td>:</td>
                                                            <td>{{form_data.employee_id_no}}</td>
                                                          </tr>
                                                          <tr>
                                                            <td>Designation</td>
                                                            <td>:</td>
                                                            <td>{{form_data.designation_name}}</td>
                                                          </tr>
                                                         
                                                          <tr>
                                                            <td>Comment</td>
                                                            <td>:</td>
                                                            <td>{{form_data.comments}}</td>
                                                          </tr>
                                                        </tbody>
                                                      </table>
                                                 </div>
                                            </div>
                                          </div>
                                          <div class="col-md-2 employee-info">
                                            <img v-if="form_data.user_employee_data.employee_image" :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-left:-20px; height: 165px; width:145px;">

                                             <img v-if="form_data.user_employee_data.employee_image == ''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-left:-20px; height: 165px; width:145px;">

                                           <!--  <img v-if="form_data.user_employee_data.employee_image ==''" :src="images/default.png" class="card-img-top border rounded" style="margin-left:-20px; height: 165px; width:145px;"> -->
                                            

                                          </div>
                                      </div>
                                      <input type="hidden" v-model="form_data.employee_id">
                                      <div class="col-md-12" v-if="form_data.resignation_status!=2 && form_data.resignation_status!=4">
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
                                     <div class="form-actions col-md-12" v-if="form_data.resignation_status!=2 && form_data.resignation_status!=4">
                                          <button type="button" @click="add({add:'approveOrReject/resignation'}, form_data.approve_reject_status=1)" class="btn btn-sm btn-success float-right col-md-2">Approve</button>
                                         <button type="button" @click="add({add:'approveOrReject/resignation'},form_data.approve_reject_status=2)" class="btn btn-sm btn-danger float-right col-md-2 offset-md-6" style="margin-right: 10px;">Reject</button>
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
            effective_date:'',
            resignation_type_name:'',
          }
        },

   
        components:{
            pageLoading:Loading
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
        methods:{
          addRow() {
          this.form_data.educational_infos.push({
            eeq_degree_name: '',
            eeq_major_group: '',
            eeq_major_group: '',
            eeq_board_university: '',
            eeq_session_from: '',
            eeq_session_to: '',
            eeq_passing_year: '',
            eeq_division_gpa: ''
          })
          console.log(this.form_data.educational_infos);
        },
        deleteRow(index) {
          this.form_data.educational_infos.splice(index,1);
        },

        dateToYYYYMMDD(d) {
            return d && new Date(d.getTime()-(d.getTimezoneOffset()*60*1000)).toISOString().split('T')[0];
        },
        updateValue: function (target) {
          // alert(target);
          const date1 = new Date(this.form_data.last_working_date);
          const tomorrow = new Date(date1)
          this.effective_date = tomorrow.setDate(tomorrow.getDate() + 1);
          this.form_data.effective_date = new Date(this.effective_date);
          this.effective_date = new Date(this.effective_date);
          console.log(this.form_data.effective_date);
        },
         selectAll: function (event) {
            setTimeout(function () {
              event.target.select()
            }, 0)
          },

          // selectAll(){

          //   console.log('ok');
          //   alert(this.last_working_date);
          // },

          onSelectSeparationType(option){
            // console.log(event.target.value);
            // this.form_data.separation_type = option;
            if(event.target.value == 1){
              this.resignation_type_name = 'Resignation';
            }else if(event.target.value == 2){
              this.resignation_type_name = 'Termination';
            }else if(event.target.value == 3){
              this.resignation_type_name = 'Retirement';
            }else if(event.target.value == 4){ 
              this.resignation_type_name = 'Retracement';
            }else if(event.target.value == 5){
              this.resignation_type_name = 'Died';
            }else{
              this.resignation_type_name = 'Other';
            } 

          },




          onSelectEmployeeSearch(option){
            this.form_data.resignation_apply_by= option.id;
            // console.log(this.form_data.user_employee_data);
            console.log(option);
            let allData =this.form_data.user_employee_data_all[option.id];
            this.form_data.employee_id= allData['id']; 
            this.form_data.user_employee_data.employee_id_no= allData['employee_id_no']; 
            this.form_data.user_employee_data.employee_fullname= allData['employee_fullname']; 
            this.form_data.user_employee_data.employee_mobile= allData['employee_mobile']; 
            this.form_data.user_employee_data.employee_joining_date=allData['employee_joining_date'];
            this.form_data.user_employee_data.employee_type=allData['employee_type'];
            this.form_data.user_employee_data.designation_name=allData['designation_name'];
            this.form_data.user_employee_data.department_name=allData['department_name'];
            this.form_data.user_employee_data.sbu_name=allData['sbu_name'];
            if (allData['employee_image']) {
              this.form_data.user_employee_data.employee_image=allData['employee_image'];
            }else {
              this.form_data.user_employee_data.employee_image='';
            }
            console.log(this.form_data.user_employee_data);
          // }
          },
          leaveTypeList(option){
            console.log(option);
            this.form_data.leave_type= option.id;
            console.log(this.form_data.leave_type);
          },
          onSelectEmployee(option){
            console.log(option);
            this.form_data.leave_reliever= option.id;
            console.log(this.form_data.leave_reliever);
            let allData =this.form_data.user_employee_data_all[option.id];
            if (allData['employee_mobile']!='') {
              this.form_data.leave_reliever_contact=allData['employee_mobile'];
            }else{
              this.form_data.leave_reliever_contact=0;
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
                  this.form_data.resignation_attachment = e.target.result;
              };
              reader.readAsDataURL(file);
          },
          setModalData(){
            this.employee_name_search=this.form_data.employee_name_search;
            this.employee_name_value=this.form_data.employee_name_value;
            this.leave_type_value=this.form_data.leave_type_value;
          },
          resetModal(){
            this.form_data.employee_id= this.form_data.user_employee_data.id;
            this.form_data.separation_type='';
            this.form_data.separation_reason='';
            // this.form_data.separation_date='';
            // this.form_data.last_working_date='';
            // this.form_data.effective_date='';
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
</style>