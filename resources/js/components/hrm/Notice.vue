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
                               <h3 class="card-title d-none d-md-block">Notice List</h3>
                               <span class="float-sm-right" style="float: right;">
                                <!-- v-if="lists.add=='add'" -->
                                 <div v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/notice'},resetModal)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>
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
                        <th class="text-center">SL<i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('notice_title')" @click="sortingChanged('notice_title')">Notice Title <i class="fas fa-sort"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('notice_sdate')" @click="sortingChanged('notice_sdate')" style="width: 15%;">Notice Date <i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('notice_stime')" @click="sortingChanged('notice_stime')" style="width: 15%;">Notice Time<i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('notice_details')" @click="sortingChanged('notice_details')">Notice Details <i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('notice_details')" @click="sortingChanged('notice_details')">Status<i class="fas fa-sort text-right"></i></th>
                        <th class="text-center" style="width: 15%;">Action</th>
                      </tr>
                    </thead>
                     <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                        <td class="text-center">{{index+1}}</td>
                        <td>{{form_data.notice_title}}</td>
                        <td  class="text-center">{{form_data.notice_sdate}} - {{form_data.notice_edate}}</td>
                        <td class="text-center">{{form_data.notice_stime}} - {{form_data.notice_etime}}</td>
                        <td class="">
                          {{form_data.notice_details | truncate(150, '...')}}
                        </td>
                        <td class="text-center" v-if="form_data.notice_status==1">{{'Active'}}</td>
                        <td class="text-center" v-else>{{'Inactive'}}</td>
                        <td class="text-center">
                          <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/notice/'+form_data.id},setModalData)" class="btn btn-info btn-xs" title="Edit" > <i class="fa fa-edit"> </i> Edit </button>
                          <button  v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/notice/'+form_data.id})" title="Delete" class="btn btn-danger btn-xs" ><i class="fa fa-trash"></i> Delete</button>
                           </td>
                      </tr>
                    </tbody>
                     <tbody v-else>
                        <tr>
                            <td colspan="6" align="center">No data in database</td>
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

       <modal class="" name="myModal" height="auto" :clickToClose="false">
            <div v-if="modal_loading">
                <div class="widget-header modal-header">
                    <h4><i class="fa fa-bars"></i> Notice</h4>
                    <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modify-wraper modal-body">
                  <div class="container">
                    <form @submit.prevent="add({add:'add/notice'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                      <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label class="col-md-6 control-label">Notice Title<sup style="color:red; top: -2px;">*</sup></label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <input v-model="form_data.notice_title"  placeholder="" class="form-control" required="true" type="text"></div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-12 control-label">Notice Details<sup style="color:red; top: -2px;">*</sup></label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <!-- <textarea v-model="form_data.notice_details" class="form-control" type="text" style="height: 70px;" required></textarea> -->
                                     <ckeditor v-model="form_data.notice_details" :config="editorConfig"></ckeditor>
                                  </div>
                              </div>
                           </div>
                           <div class="row col-md-12">
                              <div class="form-group col-md-6" style="padding:0px;">
                                 <label class="col-md-6 control-label">Start Date<sup style="color:red; top: -2px;">*</sup></label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <datepicker placeholder="Select Date" v-model="form_data.notice_sdate" class="form-control" required></datepicker>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group col-md-6" style="padding:0px;">
                                 <label class="col-md-6 control-label">End Date<sup style="color:red; top: -2px;">*</sup></label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <datepicker placeholder="Select Date" v-model="form_data.notice_edate" class="form-control" required></datepicker>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row col-md-12">
                              <div class="form-group col-md-6" style="padding:0px;">
                                 <label class="col-md-6 control-label">Start Time</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                      <vue-timepicker class="form-control" v-model="form_data.notice_stime" required></vue-timepicker>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group col-md-6" style="padding:0px;">
                                 <label class="col-md-6 control-label">End Time</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <vue-timepicker class="form-control" v-model="form_data.notice_etime" required></vue-timepicker>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group" v-if="form_data.id">
                              <label class="col-md-6 control-label">Status</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <select class="form-control" v-model="form_data.notice_status" required="true">
                                       <option disabled>--Select--</option>
                                       <option value="1">Active</option>
                                       <option value="2">Inactive</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>
                           <div class="row col-md-12">
                              <div class="form-group col-md-6" style="padding:0px;">
                                 <label class="col-md-6 control-label">Permission Type<sup style="color:red; top: -2px;">*</sup></label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <select @change="notice_to($event)" class="form-control" v-model="form_data.notice_to" >
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
                              <div class="col-md-5" style="padding:0px;" v-if="noticeToType !='' ">
                                  <div class="form-group" id="company_sbu_show" v-if="noticeToType==1">
                                     <label class="col-md-12 control-label">Company/SBU <sup style="color:red; top: -2px;">*</sup></label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                         <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbu" placeholder="Select one" label="text" track-by="text"></vue-select>
                                       </div>
                                     </div>
                                  </div>
                                  <div class="form-group" id="unit_show" v-if="noticeToType==3">
                                     <label class="col-md-12 control-label">Unit<sup style="color:red; top: -2px;">*</sup></label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                         <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <vue-select v-model="unit_value" :options="option_data.unit_data" @select="employeesUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                                       </div>
                                     </div>
                                  </div>
                                  <div class="form-group" id="sub_unit_show" v-if="noticeToType==4">
                                     <label class="col-md-12 control-label">Sub Unit<sup style="color:red; top: -2px;">*</sup></label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                         <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <vue-select v-model="sub_unit_value" :options="option_data.sub_unit_data" @select="employeesSubUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                                       </div>
                                     </div>
                                  </div>
                                  <div class="form-group" id="department_show" v-if="noticeToType==2">
                                     <label class="col-md-12 control-label">Department<sup style="color:red; top: -2px;">*</sup></label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                         <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <vue-select v-model="department_name_value" :options="option_data.department_data" @select="onSelectDepartment" placeholder="Select one" label="text" track-by="text"></vue-select>
                                       </div>
                                     </div>
                                  </div>
                                  <div class="form-group" id="section_show" v-if="noticeToType==5">
                                     <label class="col-md-12 control-label">Section<sup style="color:red; top: -2px;">*</sup></label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                         <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <vue-select v-model="section_value" :options="option_data.section_data" @select="employeesSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                                       </div>
                                     </div>
                                  </div>
                                  <div class="form-group" id="sub_section_show" v-if="noticeToType==6">
                                     <label class="col-md-12 control-label">Sub Section<sup style="color:red; top: -2px;">*</sup></label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                         <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <vue-select v-model="sub_section_value" :options="option_data.sub_section_data" @select="employeesSubSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                                       </div>
                                     </div>
                                  </div>
                                  
                                 <div class="form-group" id="employee_wise_show" v-if="noticeToType==7">
                                    <label class="col-md-6 control-label">Employee Wise<sup style="color:red; top: -2px;">*</sup></label>
                                    <div class="col-md-12 inputGroupContainer">
                                       <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                        <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                                      </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- {{ form_data.notice_to}} -->
                              <div class="col-md-5" style="padding:0px;" v-else>
                                  <div class="form-group" id="company_sbu_show" v-if="form_data.notice_to==1">
                                     <label class="col-md-12 control-label">Company/SBU <sup style="color:red; top: -2px;">*</sup></label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                         <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbu" placeholder="Select one" label="text" track-by="text"></vue-select>
                                       </div>
                                     </div>
                                  </div>
                                  <div class="form-group" id="unit_show" v-if="form_data.notice_to==3">
                                     <label class="col-md-12 control-label">Unit<sup style="color:red; top: -2px;">*</sup></label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                         <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <vue-select v-model="unit_value" :options="option_data.unit_data" @select="employeesUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                                       </div>
                                     </div>
                                  </div>
                                  <div class="form-group" id="sub_unit_show" v-if="form_data.notice_to==4">
                                     <label class="col-md-12 control-label">Sub Unit<sup style="color:red; top: -2px;">*</sup></label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                         <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <vue-select v-model="sub_unit_value" :options="option_data.sub_unit_data" @select="employeesSubUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                                       </div>
                                     </div>
                                  </div>
                                  <div class="form-group" id="department_show" v-if="form_data.notice_to==2">
                                     <label class="col-md-12 control-label">Department<sup style="color:red; top: -2px;">*</sup></label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                         <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <vue-select v-model="department_name_value" :options="option_data.department_data" @select="onSelectDepartment" placeholder="Select one" label="text" track-by="text"></vue-select>
                                       </div>
                                     </div>
                                  </div>
                                  <div class="form-group" id="section_show" v-if="form_data.notice_to==5">
                                     <label class="col-md-12 control-label">Section<sup style="color:red; top: -2px;">*</sup></label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                         <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <vue-select v-model="section_value" :options="option_data.section_data" @select="employeesSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                                       </div>
                                     </div>
                                  </div>
                                  <div class="form-group" id="sub_section_show" v-if="form_data.notice_to==6">
                                     <label class="col-md-12 control-label">Sub Section<sup style="color:red; top: -2px;">*</sup></label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                         <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <vue-select v-model="sub_section_value" :options="option_data.sub_section_data" @select="employeesSubSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                                       </div>
                                     </div>
                                  </div>
                                  
                                 <div class="form-group" id="employee_wise_show" v-if="form_data.notice_to==7">
                                    <label class="col-md-6 control-label">Employee Wise<sup style="color:red; top: -2px;">*</sup></label>
                                    <div class="col-md-12 inputGroupContainer">
                                       <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                        <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                                      </div>
                                    </div>
                                 </div>
                              </div>
                               <div class="col-md-1 float-right" style="padding: 22px;">
                                  <a @click="addRow($event,form_data.approval_infos,form_data.approve_by,employees_ids,employeesName)" id="addCF" class="btn btn-xs btn-success"><i class="fa fa-plus" style="color:#fff;"></i></a>
                                </div>
                           </div>
                           <div class="row col-md-12"> 
                              <table class="" style="width: 95%;margin-top: 44px;" >
                                  <tr class="text-center" style="border-bottom: 1px solid #cfcfcf;background: rgb(207, 207, 207);">
                                    <th width="3"> Permission Type</th>
                                    <th width="10">Name </th>
                                    <th width="40"> </th>
                                  </tr>
                                  <tr style="border: 1px solid #cfcfcf;" v-for="(formData, index) in form_data.approval_infos"  v-if="formData.permission_id !=''" > 
                                      <td>  {{formData.permission_type_name}} </td>
                                      <td> {{formData.permission_id_name}}  </td>
                                      <td style="text-align: right;"> 
                                           <a @click="deleteRow(index)" id="remCF" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                      </td>
                                  </tr>
                                </table>
                           </div>
                      </div>
                      <div class="form-actions col-md-12">
                          <input type="submit"   tabindex="4" value="Submit" class="btn btn-sm btn-info float-right col-md-2">
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
        </div>
    </div>
    <div v-if="!page_loading">
        <pageLoading></pageLoading>
    </div>
</div>
</template>


<script>
    import Loading from '../Loading.vue';
    import $ from 'jquery';
    import VueTimepicker from 'vue2-timepicker';
    import 'vue2-timepicker/dist/VueTimepicker.css' ;  
    import Vue from 'vue';
    import CKEditor from 'ckeditor4-vue';

    Vue.use( CKEditor );

    export default {
       data(){
         return{
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
           noticeToType:0,
           noticeToTypeName:'',
           permission_id:'',
           permission_id_name:'',
                      // editor: ClassicEditor,
            extraPlugins: [this.imageuploader],
             // editor: ClassicEditor,
            editorConfig: {
                table: {
                    toolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
                },
               extraPlugins: this.imageuploader
            },
         }
       },

        created(){
            this.getResults(1);
        },
        components:{
            pageLoading:Loading,
            VueTimepicker 
        },
      methods:{
           addRow(event,approval_infos) {
              var aaa= this.form_data.approval_infos.length;
              this.form_data.approval_infos.push({
                  permission_id:this.permission_id,
                  permission_type:this.noticeToType,
                  permission_type_name:this.noticeToTypeName,
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

     notice_to(event){
      console.log(event.target.name);
      if (event.target.value==1) {
        this.noticeToType=1;
        this.noticeToTypeName='Company/SBU';
      }else if(event.target.value==2){
        this.noticeToType=2;
        this.noticeToTypeName='Department';
      }else if(event.target.value==3){
        this.noticeToType=3;
        this.noticeToTypeName='Unit';
      }else if(event.target.value==4){
        this.noticeToType=4;
        this.noticeToTypeName='Sub Unit';
      }else if(event.target.value==5){
        this.noticeToType=5;
        this.noticeToTypeName='Section';
      }else if(event.target.value==6){
        this.noticeToType=6;
        this.noticeToTypeName='Sub Section';
      }else if(event.target.value==7){
        this.noticeToType=7;
        this.noticeToTypeName='Employee';
      }
     }
  }
}



</script>