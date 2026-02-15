<template>
<div>
    <div v-if="page_loading" class="widget box">
        <div class="widget-header">
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                       <div class="row">
                           <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                               <h3 class="card-title d-none d-md-block">Document List:
                               <span style="text-transform: uppercase; font-weight: bold; color: green;">{{lists.folder_name_data.folder_name}}</span> 
                               </h3>
                               <span class="float-sm-right" style="float: right;">
                                 <div  @click="getModalData($event,{dataUrl:'create/folder_file'},setModalData)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="fa fa-upload"></i> Add New</span></div>
                                  <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                               </span>
                           </div>
                       </div>
                        <div class="row">
                          <div class="col-12 col-sm-12 col-md-4">
                            <div class="info-box">
                              <span class="info-box-icon bg-info elevation-1"><i class="fa fa-paper-plane"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-text">Total </span>
                                <span class="info-box-number">
                                  {{lists.total_data}}
                                </span>
                              </div>
                            </div>
                          </div>
                           <div class="col-12 col-sm-12 col-md-4">
                             <div class="info-box">
                               <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
                               <div class="info-box-content">
                                 <span class="info-box-text">Inactive </span>
                                 <span class="info-box-number">
                                   {{lists.inactive_data}}
                                 </span>
                               </div>
                             </div>
                           </div>
                           <div class="col-12 col-sm-12 col-md-4">
                             <div class="info-box mb-3">
                               <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>
                               <div class="info-box-content">
                                 <span class="info-box-text">Active </span>
                                 <span class="info-box-number">
                                   {{lists.active_data}}
                                 </span>
                               </div>
                             </div>
                           </div>
                           <div class="clearfix hidden-md-up"></div>
                           <!-- <div class="col-12 col-sm-12 col-md-3">
                             <div class="info-box mb-3">
                               <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-ban"></i></span>
                               <div class="info-box-content">
                                 <span class="info-box-text">Rejected </span>
                                 <span class="info-box-number">DDD</span>
                               </div>
                             </div>
                           </div> -->
                       </div>
                    </div>
                    <div class="card-body col-md-12">
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
                            <th class="text-center">#</th>
                            <th class="text-center" v-bind:class="getSortingClass('file_name')" @click="sortingChanged('file_name')">File Name <i class="fas fa-sort"></i></th>
                            <!-- <th class="text-center" v-bind:class="getSortingClass('file_type')" @click="sortingChanged('file_type')">File Type <i class="fas fa-sort"></i></th> -->
                            <th class="text-center" v-bind:class="getSortingClass('expiration_date')" @click="sortingChanged('expiration_date')">File Expiration <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('notification_period')" @click="sortingChanged('notification_period')">Notification Period <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('expiration_date')" @click="sortingChanged('expiration_date')">Email Notify <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('file_attachment')" @click="sortingChanged('file_attachment')"> View Attachment <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('file_name')" @click="sortingChanged('file_name')"> File Size <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('file_status')" @click="sortingChanged('file_status')">File Status <i class="fas fa-sort"></i></th>
                            <th class="text-center">Action</th>
                          </tr>
                        </thead>
                         <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                          <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i = index>
                            <td class="text-center">{{index+1}}</td>
                            <td><i class="fa fa-file" aria-hidden="true"></i> {{form_data.file_name}}</td>
                            <!-- <td class="text-center">{{form_data.type_name }}</td> -->
                            <td class="text-center">{{form_data.expiration_date}}</td>
                            <td class="text-center">{{form_data.notification_period}}</td>
                            <td v-if="form_data.email_notify==1" style="color:green;" class="text-center">{{'Emailed'}}</td>
                            <td v-else class="text-center">{{'Not Email'}}</td>
                            <td class="text-center">
                              <div v-if="form_data.file_attachment?form_data.file_attachment:''">
                                <a  @click="viewDownloadAttachment(form_data.id,1)" target="_blank" :href="'/document_file/' + form_data.file_attachment"><i class="fa fa-eye"></i> View </a> 
                                /
                                <a  @click="viewDownloadAttachment(form_data.id,2)" download title="Download" target="_blank" :href="'/document_file/' + form_data.file_attachment" ><i class="fa fa-download"></i> <strong>Download</strong></a>
                              </div>
                              <div v-else-if="form_data.file_attachment==''">
                                 <p style="color:orange">No attachment found!</p>
                              </div>
                            </td>
                            <td class="text-center">{{file_size_find(form_data.file_size)}}</td>
                            <td class="text-center" v-if="form_data.file_status==1" style="color:green;">{{'Active'}}</td>
                            <td class="text-center" v-if="form_data.file_status==2" style="color:orange;">{{'Inactive'}}</td>
                          
                            <td class="text-center">
                              <button class="btn btn-xs btn-info" @click="getModalData($event,{dataUrl:'edit/folder_file/'+form_data.id},setModalData)" title="Edit" > <i class="fa fa-edit"> </i> Edit </button>
                            
                              <button  class="btn btn-xs btn-danger"  @click="deleteItem({delUrl:'delete/folder_file/'+form_data.id})" title="Delete" ><i class="fa fa-trash"></i> Delete</button>
                            </td>
                          </tr>
                        </tbody>
                         <tbody v-else>
                            <tr>
                                <td colspan="9" align="center">No data in database</td>
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
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
          </section>

          <modal class="" width= "40%" name="myModal" height="auto" :clickToClose="false">
               <div v-if="modal_loading">
                   <div class="widget-header modal-header">
                       <h4><i class="fa fa-bars" style="padding-right: 15px;"></i> File Add</h4>
                       <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   </div>
                   <div class="modify-wraper modal-body">
                       <form @submit.prevent="add({add:'add/folder_file'},resetModal)" class="form-horizontal row-border" id="validate-1"  enctype="multipart/form-data">
                        <input type="hidden" v-model="folder_id_value">
                         <div class="" style="margin-right:0px">
                           <div class="col-md-12">
                              <div class="row" style="padding-top:15px;">
                                <div class="col-md-4">
                                  <div class="form-group">
                                     <label class="col-md-12 control-label">Add File</label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <input type="file" v-on:change="onFileChange" style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;" accept="image/*">
                                         <div v-if="form_data.file_attachment?form_data.file_attachment:''">
                                           <a target="_blank" :href="'/document_file/' + form_data.file_attachment"><i class="fa fa-eye"></i> View Attachment</a>
                                         </div>
                                       </div>
                                     </div>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                     <label class="col-md-12 control-label">Folder Name</label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <vue-select v-model="folder_name_value" :options="option_data.folder_list_data" @select="folderSelection" placeholder="Select one" label="text" track-by="text"></vue-select>
                                       </div>
                                     </div>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                     <label class="col-md-12 control-label">Expiration Date</label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                           <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                           <input type="date" v-model="form_data.expiration_date"   class="form-control">
                                           <!-- <datepicker placeholder="Select Date" v-model="form_data.expiration_date"   class="form-control"></datepicker> -->
                                        </div>
                                     </div>
                                  </div>
                                </div>
                               
                              </div>
                    
                              <div class="form-group" v-if="form_data.id">
                                 <label class="col-md-6 control-label">Status</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <select class="form-control" v-model="form_data.file_status" required="true">
                                          <option disabled>--Select--</option>
                                          <option value="1">Active</option>
                                          <option value="2">Inactive</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="row col-md-12">
                                 <div class="form-group col-md-4" style="padding:0px;">
                                    <label class="col-md-12 control-label">Permission Type<sup style="color:red; top: -2px;">*</sup></label>
                                    <div class="col-md-12 inputGroupContainer">
                                       <div class="input-group">
                                          <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                          <select @change="permission_to($event)" class="form-control" v-model="form_data.file_permission_to" >
                                             <option id="" disabled>--Select--</option>
                                             <option value="1">Company/SBU</option>
                                             <option value="2">Department</option>
                                             <option value="3">Unit</option>
                                             <option value="4">Sub Unit</option>
                                             <option value="5">Section</option>
                                             <option value="6">Sub Section</option>
                                             <option value="7">Ind. Employee</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-4" style="padding:0px;" v-if="folderType !='' ">
                                     <div class="form-group" id="company_sbu_show" v-if="folderType==1">
                                        <label class="col-md-12 control-label">Company/SBU <sup style="color:red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbu" placeholder="Select one" label="text" track-by="text"></vue-select>
                                          </div>
                                        </div>
                                     </div>
                                     <div class="form-group" id="unit_show" v-if="folderType==3">
                                        <label class="col-md-12 control-label">Unit<sup style="color:red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <vue-select v-model="unit_value" :options="option_data.unit_data" @select="employeesUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                                          </div>
                                        </div>
                                     </div>
                                     <div class="form-group" id="sub_unit_show" v-if="folderType==4">
                                        <label class="col-md-12 control-label">Sub Unit<sup style="color:red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <vue-select v-model="sub_unit_value" :options="option_data.sub_unit_data" @select="employeesSubUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                                          </div>
                                        </div>
                                     </div>
                                     <div class="form-group" id="department_show" v-if="folderType==2">
                                        <label class="col-md-12 control-label">Department<sup style="color:red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <vue-select v-model="department_name_value" :options="option_data.department_data" @select="onSelectDepartment" placeholder="Select one" label="text" track-by="text"></vue-select>
                                          </div>
                                        </div>
                                     </div>
                                     <div class="form-group" id="section_show" v-if="folderType==5">
                                        <label class="col-md-12 control-label">Section<sup style="color:red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <vue-select v-model="section_value" :options="option_data.section_data" @select="employeesSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                                          </div>
                                        </div>
                                     </div>
                                     <div class="form-group" id="sub_section_show" v-if="folderType==6">
                                        <label class="col-md-12 control-label">Sub Section<sup style="color:red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <vue-select v-model="sub_section_value" :options="option_data.sub_section_data" @select="employeesSubSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                                          </div>
                                        </div>
                                     </div>
                                     
                                    <div class="form-group" id="employee_wise_show" v-if="folderType==7">
                                       <label class="col-md-6 control-label">Employee Wise<sup style="color:red; top: -2px;">*</sup></label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                           <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                                         </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-4" style="padding:0px;" v-else>
                                     <div class="form-group" id="company_sbu_show" v-if="form_data.file_permission_to==1">
                                        <label class="col-md-12 control-label">Company/SBU <sup style="color:red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbu" placeholder="Select one" label="text" track-by="text"></vue-select>
                                          </div>
                                        </div>
                                     </div>
                                     <div class="form-group" id="unit_show" v-if="form_data.file_permission_to==3">
                                        <label class="col-md-12 control-label">Unit<sup style="color:red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <vue-select v-model="unit_value" :options="option_data.unit_data" @select="employeesUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                                          </div>
                                        </div>
                                     </div>
                                     <div class="form-group" id="sub_unit_show" v-if="form_data.file_permission_to==4">
                                        <label class="col-md-12 control-label">Sub Unit<sup style="color:red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <vue-select v-model="sub_unit_value" :options="option_data.sub_unit_data" @select="employeesSubUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                                          </div>
                                        </div>
                                     </div>
                                     <div class="form-group" id="department_show" v-if="form_data.file_permission_to==2">
                                        <label class="col-md-12 control-label">Department<sup style="color:red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <vue-select v-model="department_name_value" :options="option_data.department_data" @select="onSelectDepartment" placeholder="Select one" label="text" track-by="text"></vue-select>
                                          </div>
                                        </div>
                                     </div>
                                     <div class="form-group" id="section_show" v-if="form_data.file_permission_to==5">
                                        <label class="col-md-12 control-label">Section<sup style="color:red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <vue-select v-model="section_value" :options="option_data.section_data" @select="employeesSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                                          </div>
                                        </div>
                                     </div>
                                     <div class="form-group" id="sub_section_show" v-if="form_data.file_permission_to==6">
                                        <label class="col-md-12 control-label">Sub Section<sup style="color:red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <vue-select v-model="sub_section_value" :options="option_data.sub_section_data" @select="employeesSubSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                                          </div>
                                        </div>
                                     </div>
                                     
                                    <div class="form-group" id="employee_wise_show" v-if="form_data.file_permission_to==7">
                                       <label class="col-md-6 control-label">Employee Wise<sup style="color:red; top: -2px;">*</sup></label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                           <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                                         </div>
                                       </div>
                                    </div>

                                    <!-- <input  style="height: 50px;padding: 3px;" type="checkbox" v-model="form_data.eeq_highest_education
                                                "  checked="checked"  name="form_data.view_permissions" /> -->
                                    
                                 

                                    
                                 </div>
                                 <div class="col-md-3" style="padding:0px;">
                                   <p style="margin-bottom: 0rem;">
                                    <input type="checkbox" style="height: 13px;padding: 3px;"  name="form_data.view_permissions" value="view" checked="checked"  v-model="form_data.view_permissions">
                                    <label for="view">View</label>
                                  </p>
                                  <p style="margin-bottom: 0rem;">
                                    <input type="checkbox" style="height: 13px;padding: 3px;" name="form_data.print_permissions" value="print" checked="checked"  v-model="form_data.print_permissions">
                                    <label for="print">Print</label>
                                  </p>
                                  <p style="margin-bottom: 0rem;">
                                    <input type="checkbox" style="height: 13px;padding: 3px;" name="form_data.download_permissions" value="download" checked="checked"  v-model="form_data.download_permissions">
                                    <label for="download">Download</label>
                                  </p>
                                </div>


                                  <div class="col-md-1 float-right" style="padding: 22px;">
                                     <a @click="addRow($event,form_data.approval_infos,form_data.approve_by,employees_ids,employeesName)" id="addCF" class="btn btn-xs btn-success"><i class="fa fa-plus" style="color:#fff;"></i></a>
                                   </div>
                              </div>
                              <div class="col-md-12"> 
                                 <table class="" style="width: 95%; margin-top: 44px;" >
                                     <tr class="text-center" style="border-bottom: 1px solid rgb(207, 207, 207); background: rgb(207, 207, 207);">
                                       <th width="3" style="font-size: 13px; padding: 5px;"> Permission Type</th>
                                       <th width="10"  style="font-size: 13px; padding: 5px;">Name </th>
                                       <th width="40"  style="font-size: 13px; padding: 5px;"> </th>
                                     </tr>
                                     <tr style="border: 1px solid #ccc;" v-for="(formData, index) in form_data.approval_infos"  v-if="formData.permission_id !=''" > 
                                         <td style="border: 1px solid #ccc;font-size: 13px;padding: 5px;">  {{formData.permission_type_name}} </td>
                                         <td style="border: 1px solid #ccc;font-size: 13px;padding: 5px;"> {{formData.permission_id_name}}  </td>
                                         <td style="text-align: right;border: 1px solid #ccc;font-size: 13px;padding: 5px;"> 
                                              <a @click="deleteRow(index)" id="remCF" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                         </td>
                                     </tr>
                                   </table>
                              </div>
                              <br>
                              <br>
                           </div>
                         </div>
                         <div class="col-md-6">
                                  <div class="form-group" style="padding: 0px;">
                                     <div class="col-md-12 inputGroupContainer" style="margin-top:15px">
                                     <label class="col-md-12 control-label" style="padding-left:0px;">
                                        <div class="input-group" v-if="form_data.email_notify==1"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                           <input type="checkbox" style="margin: 5px 5px 0 0;" checked @input="addEvent" @change="addEvent" > Send email notification
                                       </div>
                                        <div class="input-group" v-else><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                           <input type="checkbox" style="margin: 5px 5px 0 0;"   @input="addEvent" @change="addEvent" > Send email notification
                                       </div>
                                     </label>
                                     </div>
                                  </div>
                                </div>
                         <div class="form-actions col-md-12" >
                             <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2 col-2">
                             <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6 col-2" style="margin-right: 10px;">Close</button>
                         </div>
                     </form>
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
       import $ from 'jquery'

    export default {
        data(){
          return{
            folder_name_value:'',
            file_type_value:'',
            folder_id_value:'',
            folder_id:this.$route.params.folderId,
            sbu_name_value:'',
            section_value:'',
            sub_section_value:'',
            employee_group_value:'',
            unit_value:'',
            make_user:0,
            employeesName:'',
            employees_ids:'',
            url: null,
            sub_unit_value:'',
            work_location_value:'',
            department_name_value:'',
            designation_name_value:'',
            jobgrade_name_value:'',
            employee_name_value:'',
            sub_unit_value:'',
            work_location_value:'',
            personal_email_id:'',
            folderType:0,
            folderTypeName:'',
            permission_id:'',
            permission_id_name:'',
            grid_or_list_view:2,
          }
        },
        created(){
            this.getResults(1,this.$route.params.folderId);
        },
        components:{
            pageLoading:Loading
        },
        methods:{
          onSelectFileType(option){
          console.log(option);
            this.form_data.file_type= option.id;
            console.log(this.form_data.file_type);
          },
          onFileChange(e) {
            // alert(e);
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
                const file = e.target.files[0];
                this.form_data.file_name=file.name;
                console.log(file);
                // this.url = URL.createObjectURL(file);
                
            },
          createImage(file) {
              let reader = new FileReader();
              let vm = this;
              reader.onload = (e) => {
                  this.form_data.file_attachment = e.target.result;
              };
              reader.readAsDataURL(file);
          },
          addEvent ({ type, target }) {
              if(target.checked == true ){
                  this.form_data.email_notify=1;
              }else{
                this.form_data.email_notify=2;
              }

              const event = {
                  type,
                  isCheckbox: target.type === 'checkbox',
                  target: {
                    value: target.value,
                    checked: target.checked
                  }
              }
              this.events.push(event)

            },
            eventText (e) {
              return `${e.type}: ${e.isCheckbox ? e.target.checked : e.target.value}`
            },
            viewDownloadAttachment(file_id, action_type){
                // if(!window.confirm('Are you sure want to select?')){
                //   return;
                // }
                let uri = URL.baseUrl('veiw_or_download/file_access_log/'+file_id+'/'+action_type);
                // alert(uri);
                console.log(uri);
                axios.get(uri)
                .then(res => {
                  // alert(res.data);
                  console.log(res.data);
                    // this.form_data =res.data;
                   // console.log(res.data);
                })
                .catch(error => {
                  this.showToster({status:0,message:'opps! something went wrong'});
                })
            },
            file_size_find(x){
              const units = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
              let l = 0, n = parseInt(x, 10) || 0;
              while(n >= 1024 && ++l){
                  n = n/1024;
              }
              return(n.toFixed(n < 10 && l > 0 ? 1 : 0) + ' ' + units[l]);
            },
          folderSelection(option){
             console.log(option);
             this.form_data.folder_id= option.id;
             // this.permission_id=option.id;
             // this.permission_id_name=option.text;
          },
          addRow(event,approval_infos) {
             var aaa= this.form_data.approval_infos.length;
             this.form_data.approval_infos.push({
                permission_id:this.permission_id,
                permission_type:this.folderType,
                permission_type_name:this.folderTypeName,
                permission_id_name:this.permission_id_name,
             })
             console.log(this.form_data.approval_infos);
           },
           deleteRow(index) {
               this.form_data.approval_infos.splice(index,1);
           },
           employeesSbu(option){
              console.log(option);
              this.form_data.sbu_id= option.id;
              this.permission_id=option.id;
              this.permission_id_name=option.text;
           },
           employeesSection(option){
              console.log(option);
              this.form_data.section_id= option.id;
              this.permission_id=option.id;
              this.permission_id_name=option.text;
              console.log(this.form_data.section_id);
            },
            employeesSubSection(option){
              console.log(option);
              this.form_data.subsection_id= option.id;
              this.permission_id=option.id;
              this.permission_id_name=option.text;
            },
            employeesGroup(option){
              console.log(option);
              this.form_data.employee_group= option.id;
              this.permission_id=option.id;
              this.permission_id_name=option.text;
              console.log(this.form_data.employee_group);
            },
            employeesSubUnit(option){
              console.log(option);
              this.form_data.subunit_id= option.id;
              this.permission_id=option.id;
              this.permission_id_name=option.text;
            },
            employeesUnit(option){
              console.log(option);
              this.form_data.unit_id= option.id;
              this.permission_id=option.id;
              this.permission_id_name=option.text;
            },
            employeesWorkLocation(option){
              console.log(option);
              this.form_data.employee_work_location= option.id;
              this.permission_id=option.id;
              this.permission_id_name=option.text;
              console.log(this.form_data.employee_work_location);
            },
            onSelectDepartment(option){
              console.log(option);
              this.form_data.department_id= option.id;
              this.permission_id=option.id;
              this.permission_id_name=option.text;
              // console.log(this.form_data.employee_department);
            },
            onSelectDesignation(option){
              console.log(option);
              this.form_data.employee_designation= option.id;
              this.permission_id=option.id;
              this.permission_id_name=option.text;
              console.log(this.form_data.employee_designation);
            },
            onSelectJobGrade(option){
              console.log(option);
              this.form_data.employee_job_grade= option.id;
              this.permission_id=option.id;
              this.permission_id_name=option.text;
              console.log(this.form_data.employee_job_grade);
            },
            onSelectEmployee(option){
              console.log(option);
              this.form_data.employee_id = option.id;
              this.permission_id=option.id;
              this.permission_id_name=option.text;
            },
            setModalData(){
              this.file_type_value=this.form_data.file_type_value;
              this.folder_name_value=this.form_data.folder_name_value;
              this.folder_id_value=this.$route.params.folderId;
              this.form_data.folder_id=this.$route.params.folderId;
              this.sbu_name_value=this.form_data.sbu_name_value;
              this.section_value=this.form_data.section_value;
              this.sub_section_value=this.form_data.sub_section_value;
              this.employee_group_value=this.form_data.employee_group_value;
              this.department_name_value=this.form_data.department_name_value;
              this.designation_name_value=this.form_data.designation_name_value;
              this.jobgrade_name_value=this.form_data.jobgrade_name_value;
              this.sub_unit_value=this.form_data.sub_unit_value;
              this.employee_name_value=this.form_data.employee_name_value;
              this.work_location_value=this.form_data.work_location_value;
              this.general_data_temp=this.form_data.general_info_temp;
            },
            resetModal(){
              this.sbu_name_value='';
              this.section_value='';
              this.sub_section_value='';
              this.employee_group_value='';
              this.department_name_value='';
              this.designation_name_value='';
              this.jobgrade_name_value='';
              this.unit_value='';
              this.sub_unit_value='';
              this.employee_name_value='';
              this.work_location_value='';
              this.form_data.employee_status='1';
              this.form_data.emplyee_category_mgt_non_mgt='2';
              this.form_data.employee_leave_group='1';
              this.form_data.employee_type='2';
              this.form_data.make_user='';
              this.form_data.user_type='0'
              this.form_data.ea_approve_by_name='';
              this.form_data.employee_mobile='';
              this.form_data.employee_id='';
              this.form_data.employee_number='';
              this.form_data.employee_fullname='';
              this.form_data.employee_joining_date='';
              this.form_data.employee_image='';
              this.form_data.make_user='';
              this.approvalnamevalue1="";
            },
            permission_to(event){
             console.log(event.target.name);
             if (event.target.value==1) {
               this.folderType=1;
               this.folderTypeName='Company/SBU';
             }else if(event.target.value==2){
               this.folderType=2;
               this.folderTypeName='Department';
             }else if(event.target.value==3){
               this.folderType=3;
               this.folderTypeName='Unit';
             }else if(event.target.value==4){
               this.folderType=4;
               this.folderTypeName='Sub Unit';
             }else if(event.target.value==5){
               this.folderType=5;
               this.folderTypeName='Section';
             }else if(event.target.value==6){
               this.folderType=6;
               this.folderTypeName='Sub Section';
             }else if(event.target.value==7){
               this.folderType=7;
               this.folderTypeName='Employee';
             }
            },
        }
    }



</script>