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
                               <h3 class="card-title d-none d-md-block">Gratuity Fund List</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <!-- <div  @click="getModalData($event,{dataUrl:'create/gratuity_fund'},resetModal, type=1)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div> -->
                                 <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                               </span>
                           </div>
                       </div>
                        <div class="row">
                          <!-- <div class="col-12 col-sm-12 col-md-3">
                            <div class="info-box">
                              <span class="info-box-icon bg-info elevation-1">
                              <i class="fa fa-paper-plane"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-text">No. of Employee </span>
                                <span class="info-box-number">
                                  {{lists.total_data}}
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-sm-12 col-md-3">
                            <div class="info-box">
                              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-text">Employee Contribution </span>
                                <span class="info-box-number">
                                  {{lists.inactive_data}}
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-sm-12 col-md-3">
                            <div class="info-box mb-3">
                              <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-text">Company Contribution </span>
                                <span class="info-box-number">
                                  {{lists.active_data}}
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-sm-12 col-md-3">
                            <div class="info-box mb-3">
                              <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-ban"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-text">Total PF </span>
                                <span class="info-box-number">{{lists.total_gf}}</span>
                              </div>
                            </div>
                          </div> -->
                          <div class="col-12 col-sm-12 col-md-3">
                            <div class="info-box">
                              <span class="info-box-icon bg-info elevation-1">
                              <i class="fa fa-paper-plane"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-text">No. Of Employee </span>
                                <span class="info-box-number">
                                  {{lists.total_data}}
                                </span>
                              </div>
                            </div>
                          </div>
                           <div class="col-12 col-sm-12 col-md-3">
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
                           <div class="col-12 col-sm-12 col-md-3">
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
                           <div class="col-12 col-sm-12 col-md-3">
                             <div class="info-box mb-3">
                               <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-ban"></i></span>
                               <div class="info-box-content">
                                 <span class="info-box-text">Total PF </span>
                                 <span class="info-box-number">{{lists.total_gf}}</span>
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
                        <th class="text-center">ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Joining</th>
                        <th class="text-center">Designation</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Comapny</th>
                        <th class="text-center">Year </th>
                        <th class="text-center">Gross</th>
                        <th class="text-center">Basic</th>
                        <th class="text-center">Total GF</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                     <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                        <td class="text-center">{{index+1}}</td>
                        <td class="text-center">{{form_data.employee_id_no}}</td>
                        <td class="text-left">{{form_data.employee_fullname}}</td>
                        <td class="text-center">{{form_data.employee_joining_date}}</td>
                        <td class="text-left">{{form_data.designation_name}}</td>
                        <td class="text-left">{{form_data.department_name}}</td>
                        <td class="text-left">{{form_data.sbu_name}}</td>
                        <td class="text-center">{{form_data.gf_year}}</td>
                        <td class="text-right">
                          <span v-for="salary in lists.employee_salary">
                            <span v-if="salary.employee_id==form_data.employee_id">
                              {{salary.total_salary}}
                            </span>
                          </span>
                        </td>
                        <td class="text-right">
                          <span v-for="salary in lists.employee_salary">
                            <span v-if="salary.employee_id==form_data.employee_id">
                              {{salary.total_basic}}
                            </span>
                          </span>
                        </td>
                        <td class="text-right">
                          <span v-for="salary in lists.employee_salary">
                            <span v-if="salary.employee_id==form_data.employee_id">
                              {{salary.total_basic*8}}
                            </span>
                          </span>
                        </td>
                        <td class="text-center">
                          <span v-if="form_data.gf_status==1" style="color:green;">Active</span>
                          <span v-else style="color:red;">Inactive</span>
                        </td>
                        <td class="text-center">
                          <!-- <button class="btn btn-xs btn-success" @click="getModalData($event,{dataUrl:'salary_details/gratuity_fund/'+form_data.employee_id}, setModalData, type=2)" title="Edit" > <i class="fa fa-info-circle"> </i> Details </button> -->
                          <router-link href="#" :to="'/gratuity_fund_details/'+form_data.employee_id" class="btn btn-xs btn-success" title="Add More Data">
                            <i class="fa fa-search" aria-hidden="true"></i> Details
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

       <modal class="" name="myModal" height="auto" :clickToClose="false" width="700">
            <div v-if="modal_loading">
              <span v-if="type==1">
                  <div class="widget-header modal-header">
                      <h4><i class="fa fa-bars"></i> Gratuity Fund</h4>
                      <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modify-wraper modal-body">
                    <div class="container">
                      <form @submit.prevent="add({add:'add/gratuity_fund'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                        <div class="row">
                          <div class="col-md-12">
                              <div class="form-group" v-if="!form_data.id">
                                 <label class="col-md-6 control-label">Employee</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployeeSearch" placeholder="Select one" label="text" track-by="text"></vue-select>
                                    </div>
                                 </div>
                              </div>
                               <div class="row" v-if="profile_open==1">
                                <div class="col-md-12">
                                  <div class="col-md-9 modify-wraper float-left" style="padding:0px;">
                                    <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                                      <tbody>
                                        <tr>
                                            <td> ID :</td>
                                            <td style="width:25%; padding-left:0px; padding-right:0px; font-weight:bold;">
                                              <input type="hidden" v-model="form_data.employee_id" name="">
                                              {{form_data.user_employee_data.employee_id_no}}
                                            </td>
                                            <td>Name :</td>
                                            <td style="width:30%; padding-left:0px; padding-right:0px; font-weight:bold;">{{form_data.user_employee_data.employee_fullname}}</td>
                                        </tr>
                                        <tr>
                                          <td>Designation: </td>
                                          <td style="width:30%; padding-left:0px; padding-right:0px; font-weight:bold;">{{form_data.user_employee_data.designation_name}}</td>
                                          <td>Department: </td>
                                          <td style="width:30%; padding-left:0px; padding-right:0px; font-weight:bold;">{{form_data.user_employee_data.department_name}}</td>
                                        </tr>
                                        <tr>
                                          <td>SBU: </td>
                                          <td style="width:33%; padding-left:0px; padding-right:0px; font-weight:bold;">{{form_data.user_employee_data.sbu_name}}</td>
                                          <td>Contact: </td>
                                          <td style="width:25%; padding-left:0px; padding-right:0px; font-weight:bold;">{{form_data.user_employee_data.employee_mobile}}</td>
                                        </tr>
                                        <tr>
                                          <td>Section: </td>
                                          <td style="width:33%; padding-left:0px; padding-right:0px; font-weight:bold;">{{form_data.user_employee_data.section_name}}</td>
                                          <td>Joining: </td>
                                          <td style="width:25%; padding-left:0px; padding-right:0px; font-weight:bold;">{{form_data.user_employee_data.employee_joining_date}}</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <!-- <hr> -->
                                  </div>
                                   <div class="col-md-3 float-left text-center">
                                     <span v-if="form_data.user_employee_data.employee_image">
                                       <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top:2px; width: 130px; height: 150px;">
                                     </span>
                                     <span v-else>
                                       <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-top: 2px; width: 130px; height: 150px;">
                                     </span>
                                   </div>
                                </div>
                                      <hr>
                               </div>
                                <!-- <div class="col-md-12"> -->
                               <div class="row">
                                   <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Confirmation Date <sup style="color: red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <datepicker placeholder="Select Date" style="width: 131% !important;" v-model="form_data.confirmation_date"   class="form-control" ></datepicker>
                                         </div>
                                        </div>
                                     </div>
                                   </div>
                                   <div class="col-md-6">
                                     <div class="form-group">   
                                         <label class="col-md-8">Provident Fund                    
                                           <input v-model="form_data.provident_fund" type="checkbox" value="1" style="margin-left: 29px;">  
                                         </label>                  
                                     </div>
                                     <div class="form-group">   
                                         <label class="col-md-8">Gratuity Fund                    
                                           <input v-model="form_data.gratuity_fund" type="checkbox" value="1" style="margin-left: 29px;">  
                                         </label>                  
                                     </div>
                                   </div>
                               </div>
                                <div class="row">
                                  <div class="col-md-6"> 
                                    <div class="form-group">
                                       <label class="col-md-6 control-label">Gross Salary </label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group">
                                           <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input id="department_name" v-model="gross_salary_entry" name="department_name" placeholder="" class="form-control" type="number" step="0.01">
                                         </div>
                                       </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Basic Salary</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input id="department_name" v-model="basic_salary_entry" name="department_name" placeholder="" class="form-control" type="number" step="0.01">
                                         </div>
                                       </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Housing Allowance</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input id="department_name" v-model="housing_allowance_entry" name="department_name" placeholder="" class="form-control" type="number" step="0.01"></div>
                                       </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Medical Allowance</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input id="department_name" v-model="medical_allowance_entry" name="department_name" placeholder="" class="form-control" type="number" step="0.01"></div>
                                       </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Conveyance Allowance</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input id="department_name" v-model="conveyance_allowance_entry" name="department_name" placeholder="" class="form-control" type="number" step="0.01"></div>
                                       </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Overtime Work Compensation</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input id="department_name" v-model="overtime_work_compensation_entry" name="department_name" placeholder="" class="form-control" type="number" step="0.01"></div>
                                       </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Others Allowance</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input id="department_name" v-model="form_data.others_allowance" name="department_name" placeholder="" class="form-control" type="number" step="0.01"></div>
                                       </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Car Allowance</label>
                                       <div class="col-md-5 inputGroupContainer float-left">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <select @click="car_allowance($event)" class="form-control" v-model="form_data.car_allowance_status" required="true">
                                              <option disabled>--Select--</option>
                                              <option value="1">Yes</option>
                                              <option value="2">No</option>
                                           </select>
                                         </div>
                                       </div>
                                       <div v-if="car_allowance_field==1 || form_data.car_allowance_amount" class="col-md-7 inputGroupContainer float-left">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input id="department_name" v-model="form_data.car_allowance_amount" name="department_name" placeholder="" class="form-control" type="number" step="0.01">
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
                                         <select class="form-control" v-model="form_data.salary_status" required="true">
                                            <option disabled>--Select--</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                         </select>
                                      </div>
                                   </div>
                                </div>
                          </div>
                        </div>
                        <div class="form-actions col-md-12">
                            <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2">
                            <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button>
                        </div>
                    </form>
                  </div>
                </div>
              </span>

              <!-- Salary Info  -->
              <span v-if="type==2">
                  <div class="widget-header modal-header">
                      <h4><i class="fa fa-bars"></i> Salary Info: <span style="color:green;">{{form_data.emp_info.employee_fullname}}</span></h4>
                      <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body">
                   <!--  <div class="col-md-12 modify-wraper" style="padding:0px;">
                      <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                        <tbody>
                          <tr>
                              <td>Employee ID :</td>
                              <td style="width:25%; padding:0px; font-weight:bold;">
                                <input type="hidden" v-model="form_data.employee_id" name="">
                                {{form_data.user_employee_data.employee_id_no}}
                              </td>
                              <td>Name :</td>
                              <td style="width:30%; padding:0px; font-weight:bold;">{{form_data.user_employee_data.employee_fullname}}</td>
                          </tr>
                          <tr>
                            <td>Designation: </td>
                            <td style="width:30%; padding:0px; font-weight:bold;">{{form_data.user_employee_data.designation_name}}</td>
                            <td>Department: </td>
                            <td style="width:30%; padding:0px; font-weight:bold;">{{form_data.user_employee_data.department_name}}</td>
                          </tr>
                          <tr>
                            <td>SBU: </td>
                            <td style="width:33%; padding:0px; font-weight:bold;">{{form_data.user_employee_data.sbu_name}}</td>
                            <td>Contact: </td>
                            <td style="width:25%; padding:0px; font-weight:bold;">{{form_data.user_employee_data.employee_mobile}}</td>
                          </tr>
                        </tbody>
                      </table>
                      <hr>
                    </div> -->
                    <div class="row" v-if="profile_open==1">
                     <div class="col-md-12">
                       <div class="col-md-9 modify-wraper float-left" style="padding:0px;">
                         <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                           <tbody>
                             <tr>
                                 <td> ID :</td>
                                 <td style="width:25%; padding:0px; font-weight:bold;">
                                   <input type="hidden" v-model="form_data.employee_id" name="">
                                   {{form_data.user_employee_data.employee_id_no}}
                                 </td>
                                 <td>Name :</td>
                                 <td style="width:30%; padding:0px; font-weight:bold;">{{form_data.user_employee_data.employee_fullname}}</td>
                             </tr>
                             <tr>
                               <td>Designation: </td>
                               <td style="width:30%; padding:0px; font-weight:bold;">{{form_data.user_employee_data.designation_name}}</td>
                               <td>Department: </td>
                               <td style="width:30%; padding:0px; font-weight:bold;">{{form_data.user_employee_data.department_name}}</td>
                             </tr>
                             <tr>
                               <td>SBU: </td>
                               <td style="width:33%; padding:0px; font-weight:bold;">{{form_data.user_employee_data.sbu_name}}</td>
                               <td>Contact: </td>
                               <td style="width:25%; padding:0px; font-weight:bold;">{{form_data.user_employee_data.employee_mobile}}</td>
                             </tr>
                             <tr>
                               <td>Section: </td>
                               <td style="width:33%; padding-left:0px; padding-right:0px; font-weight:bold;">{{form_data.user_employee_data.section_name}}</td>
                               <td>Joining: </td>
                               <td style="width:25%; padding-left:0px; padding-right:0px; font-weight:bold;">{{form_data.user_employee_data.employee_joining_date}}</td>
                             </tr>
                           </tbody>
                         </table>
                         <!-- <hr> -->
                       </div>
                        <div class="col-md-3 float-left text-center">
                          <span v-if="form_data.user_employee_data.employee_image">
                            <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top:2px; width: 130px; height: 150px;">
                          </span>
                          <span v-else>
                            <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-top: 2px; width: 130px; height: 150px;">
                          </span>
                        </div>
                     </div>
                           <hr>
                    </div>
                    <div class="container">
                      <table id="employeeTable" class="table table-bordered table-striped salaryTable">
                        <thead>
                          <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Basic </th>
                            <th class="text-center">House</th>
                            <th class="text-center">Conveyance </th>
                            <th class="text-center">Medical </th>
                            <th class="text-center">Overtime </th>
                            <th class="text-center">Total </th>
                          </tr>
                        </thead>
                         <tbody  v-if="Object.keys(form_data.emp_salary).length > 0">
                          <tr v-for="(form_data, index) in form_data.emp_salary" v-bind:key="form_data.id" i=index>
                            <td class="text-center">{{form_data.confirmation_date}}</td>
                            <td class="text-right">{{form_data.basic_salary}}</td>
                            <td class="text-right">{{form_data.housing_allowance}}</td>
                            <td class="text-right">{{form_data.medical_allowance}}</td>
                            <td class="text-right">{{form_data.conveyance_allowance}}</td>
                            <td class="text-right">{{form_data.overtime_work_compensation}}</td>
                            <td class="text-right">{{form_data.gross_salary }}</td>
                          </tr>
                          <tr>
               
                          </tr>
                        </tbody>
                         <tbody v-else>
                            <tr>
                                <td colspan="12" align="center">No data in database</td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                </div>
              </span>
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

    export default {
       data(){
         return{
           employee_name_value:'',
           gross_salary_entry:'',
           basic_salary_entry:'',
           housing_allowance_entry:'',
           medical_allowance_entry:'',
           conveyance_allowance_entry:'',
           overtime_work_compensation_entry:'',
           profile_open:'',
           car_allowance_field:'',
           others_allowance_entry:'',
         }
       },

        created(){
            this.getResults(1);
        },
        components:{
            pageLoading:Loading
        },
     watch: {
             gross_salary_entry: function(val){
               this.form_data.gross_salary = val;
               this.basic_salary_entry = (this.form_data.gross_salary*(this.form_data.salary_setting.basic_salary/100));
               this.form_data.basic_salary = this.basic_salary_entry;

               this.housing_allowance_entry = (this.form_data.gross_salary*(this.form_data.salary_setting.housing_allowance/100));
               this.form_data.housing_allowance = this.housing_allowance_entry;

               this.medical_allowance_entry = (this.form_data.gross_salary*(this.form_data.salary_setting.medical_allowance/100));
               this.form_data.medical_allowance =  this.medical_allowance_entry;

               this.conveyance_allowance_entry = (this.form_data.gross_salary*(this.form_data.salary_setting.conveyance_allowance/100));
               this.form_data.conveyance_allowance = this.conveyance_allowance_entry;

               this.overtime_work_compensation_entry = (this.form_data.gross_salary*(this.form_data.salary_setting.overtime_work_compensation/100));
               this.form_data.overtime_work_compensation = this.overtime_work_compensation_entry;
             }, 
             basic_salary_entry: function(val){
               this.form_data.basic_salary = val;
             },
             housing_allowance_entry: function(val){
               this.form_data.housing_allowance = val;
             }, 
             medical_allowance_entry: function(val){
               this.form_data.medical_allowance = val;
             }, 
             conveyance_allowance_entry: function(val){
               this.form_data.conveyance_allowance = val;
             }, 
             overtime_work_compensation_entry: function(val){
               this.form_data.overtime_work_compensation = val;
             }                        
         },
         methods:{
           onSelectEmployee(option){
             console.log(option);
             this.form_data.employee_id= option.id;
             console.log(this.form_data.employee_id);
           },
           onSelectEmployeeSearch(option){
             this.profile_open = 1;
             this.getModalDataOther(option.id);
             this.form_data.employee_id= option.id;
             this.form_data.employee_id=this.form_data.employee_id;
             console.log(this.form_data.employee_id);
             console.log(option);
             let allData =this.form_data.user_employee_data_all[option.id];
             this.form_data.employee_id= allData['id']; 
           },
           getModalDataOther(id){
             // console.log('aaaaaa');
             let uri = URL.baseUrl('other_create/increment/'+id);
             console.log(uri);
             axios.get(uri)
             .then(res => {
               console.log(res.data);
               this.form_data = res.data;
               this.form_data.employee_id=id;
               this.form_data.car_allowance_status=2;
               this.form_data.provident_fund=1;
               this.form_data.gratuity_fund=1;
               this.errors =null;
               if(callback){
                 callback();
               }
             })
             .catch(error => {
               this.modal_page_loading= true;
             })
           },
           car_allowance(e){
              var val = e.target.value
            // console.log(e.target.value);
              if (val==1) {
                this.car_allowance_field=1;
              }else{
                this.car_allowance_field=2;
              }
           },
           
           setModalData(){
             this.profile_open=1;
             this.employee_name_value=this.form_data.employee_name_value;
             this.gross_salary_entry=this.form_data.gross_salary;
             this.basic_salary_entry=this.form_data.basic_salary;
             this.housing_allowance_entry=this.form_data.housing_allowance;
             this.medical_allowance_entry=this.form_data.medical_allowance;
             this.conveyance_allowance_entry=this.form_data.conveyance_allowance;
             this.overtime_work_compensation_entry=this.form_data.overtime_work_compensation;
           },
           resetModal(){
             this.gross_salary_entry='';
             this.basic_salary_entry='';
             this.housing_allowance_entry='';
             this.medical_allowance_entry='';
             this.conveyance_allowance_entry='';
             this.overtime_work_compensation_entry='';
             this.employee_name_value='';
             this.profile_open='';
             this.form_data.car_allowance_status=2;
             this.form_data.provident_fund=1;
             this.form_data.gratuity_fund=1;
             this.car_allowance_field='';
             this.others_allowance_entry='';
           },
         }
    }



</script>
<style type="text/css">
  .salaryTable.table td{
    padding: 15px 5px;
  }
</style>