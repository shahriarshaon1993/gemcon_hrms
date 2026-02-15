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
                               <h3 class="card-title d-none d-md-block">Salary List</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <div   @click="getModalData($event,{dataUrl:'create/salary'},resetModal, type=1)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>

                                 <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>

                               </span>
                           </div>
                       </div>
                    </div>
                    <div class="card-body col-md-12">
                      <nav style="padding-bottom: 15px" id="salary_tab">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                          <a class="nav-item nav-link active salary_tab" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Bank Salary</a>
                          <a class="nav-item nav-link salary_tab" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Cash Salary</a>
                        </div>
                      </nav>
                      <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
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
                                <th class="text-center">Emp. ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Joining Date</th>
                                <!-- <th class="text-center">Provident Fund</th> -->
                                <th class="text-center">Confirm. Date</th>
                                <th class="text-center">Gross </th>
                                <th class="text-center">Basic </th>
                                <th class="text-center">House</th>
                                <th class="text-center">Conveyance </th>
                                <th class="text-center">Medical </th>
                                <th class="text-center">Car Allowance</th>
                                <th class="text-center">others Allowance </th>
                                <th class="text-center">PF </th>
                                <th class="text-center">Salary On </th>
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
                                <!-- <td class="text-center">
                                  <span v-if="form_data.provident_fund==1">{{'Yes'}}</span>
                                  <span v-else>{{'No'}}</span>
                                </td> -->
                                <td class="text-center">{{form_data.confirmation_date}}</td>
                                <td class="text-right">{{form_data.gross_salary  |number('0,0')}}</td>
                                <td class="text-right">{{form_data.basic_salary |number('0,0')}}</td>
                                <td class="text-right">{{form_data.housing_allowance |number('0,0')}}</td>
                                <td class="text-right">{{form_data.conveyance_allowance |number('0,0')}}</td>
                                <td class="text-right">{{form_data.medical_allowance |number('0,0')}}</td>
                                <td class="text-right">{{form_data.car_allowance_amount |number('0,0')}}</td>
                                <td class="text-right">{{form_data.others_allowance |number('0,0')}}</td>
                                <td class="text-right">{{form_data.provident_fund_amount |number('0,0')}}</td>
                                
                                <td class="text-center">
                                  <span v-if="form_data.salary_goes_to==1" style="color:green;">Cash</span>
                                  <span v-if="form_data.salary_goes_to==2" style="color:green;">Bank</span>
                                  <!-- <span v-else style="color:red;">Inactive</span> -->
                                </td>
                                <td class="text-center">
                                  <span v-if="form_data.salary_status==1" style="color:green;">Active</span>
                                  <span v-else style="color:red;">Inactive</span>
                                </td>
                                <td class="text-center" style="width: 18%;">
                                  <!-- v-if="lists.view=='view'" -->
                                  <button  class="btn btn-xs btn-success" @click="getModalData($event,{dataUrl:'salary_details/salary/'+form_data.employee_id}, setModalData, type=2)" title="Edit" > <i class="fa fa-info-circle"> </i> Info </button>
                                  <!-- v-if="lists.edit=='edit'" -->
                                  <button  class="btn btn-xs btn-info" @click="getModalData($event,{dataUrl:'salary_edit/salary/'+form_data.id}, setModalData, type=1)" title="Edit" > <i class="fa fa-edit"> </i> Edit </button>
                                  <!-- v-if="lists.delete=='delete'" -->
                                  <button  class="btn btn-xs btn-danger"  @click="deleteItem({delUrl:'delete/salary/'+form_data.id})" title="Delete" ><i class="fa fa-trash"></i> Delete</button>
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
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
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
                                <th class="text-center">Emp. ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Joining Date</th>
                                <!-- <th class="text-center">Provident Fund</th> -->
                                <th class="text-center">Confirm. Date</th>
                                <th class="text-center">Gross </th>
                                <th class="text-center">Basic </th>
                                <th class="text-center">House</th>
                                <th class="text-center">Conveyance </th>
                                <th class="text-center">Medical </th>
                                <th class="text-center">Car Allowance</th>
                                <th class="text-center">others Allowance </th>
                                <th class="text-center">PF </th>
                                <th class="text-center">Salary On </th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                              </tr>
                            </thead>
                             <tbody  v-if="Object.keys(paginate_data1.data).length > 0">
                              <tr v-for="(form_data, index) in paginate_data1.data" v-bind:key="form_data.id" i=index>
                                <td class="text-center">{{index+1}}</td>
                                <td class="text-center">{{form_data.employee_id_no}}</td>
                                <td class="text-left">{{form_data.employee_fullname}}</td>
                                <td class="text-center">{{form_data.employee_joining_date}}</td>
                                <!-- <td class="text-center">
                                  <span v-if="form_data.provident_fund==1">{{'Yes'}}</span>
                                  <span v-else>{{'No'}}</span>
                                </td> -->
                                <td class="text-center">{{form_data.confirmation_date}}</td>
                                <td class="text-right">{{form_data.gross_salary  |number('0,0')}}</td>
                                <td class="text-right">{{form_data.basic_salary |number('0,0')}}</td>
                                <td class="text-right">{{form_data.housing_allowance |number('0,0')}}</td>
                                <td class="text-right">{{form_data.conveyance_allowance |number('0,0')}}</td>
                                <td class="text-right">{{form_data.medical_allowance |number('0,0')}}</td>
                                <td class="text-right">{{form_data.car_allowance_amount |number('0,0')}}</td>
                                <td class="text-right">{{form_data.others_allowance |number('0,0')}}</td>
                                <td class="text-right">{{form_data.provident_fund_amount |number('0,0')}}</td>
                                
                                <td class="text-center">
                                  <span v-if="form_data.salary_goes_to==1" style="color:green;">Cash</span>
                                  <span v-if="form_data.salary_goes_to==2" style="color:green;">Bank</span>
                                  <!-- <span v-else style="color:red;">Inactive</span> -->
                                </td>
                                <td class="text-center">
                                  <span v-if="form_data.salary_status==1" style="color:green;">Active</span>
                                  <span v-else style="color:red;">Inactive</span>
                                </td>
                                <td class="text-center" style="width: 18%;">
                                  <!-- v-if="lists.view=='view'" -->
                                  <button  class="btn btn-xs btn-success" @click="getModalData($event,{dataUrl:'salary_details/salary/'+form_data.employee_id}, setModalData, type=2)" title="Edit" > <i class="fa fa-info-circle"> </i> Info </button>
                                  <!-- v-if="lists.edit=='edit'" -->
                                  <button  class="btn btn-xs btn-info" @click="getModalData($event,{dataUrl:'salary_edit/salary/'+form_data.id}, setModalData, type=1)" title="Edit" > <i class="fa fa-edit"> </i> Edit </button>
                                  <!-- v-if="lists.delete=='delete'" -->
                                  <button  class="btn btn-xs btn-danger"  @click="deleteItem({delUrl:'delete/salary/'+form_data.id})" title="Delete" ><i class="fa fa-trash"></i> Delete</button>
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
                        <!-- <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">ccc</div> -->
                      </div>
                </div>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>

       <modal class="" name="myModal" height="auto" :clickToClose="false" width="800">
            <div v-if="modal_loading">
              <!-- Salary Details -->
              <span v-if="type==1">
                  <div class="widget-header modal-header">
                      <h4><i class="fa fa-bars"></i> Salary Add</h4>
                      <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modify-wraper modal-body" style="margin-top:-10px;">
                    <div class="container">
                      <form @submit.prevent="add({add:'add/salary'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                        <br>
                        <div class="row">
                          <div class="col-md-12">
                              <div class="form-group" v-if="!form_data.id">
                                 <label class="col-md-6 control-label">Employee <sup style="color: red; top: -2px;">*</sup></label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployeeSearch" placeholder="Select one" label="text" track-by="text"></vue-select>
                                    </div>
                                 </div>
                              </div>
                               <div class="row" v-if="profile_open==1" style="margin-bottom: 10px;margin-right: -1.5px;">
                                 <!-- {{ this.modal_loading== false ? 'Loading...' : '' }} -->
                                  <div class="col-md-12" style="border: 1px solid #cfcfcf;margin-left: 12px;    padding-right: 0px;   max-width: 98%;">
                                    <div class="col-md-10 modify-wraper float-left" style="padding:0px;">
                                      <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                                        <tbody>
                                          <tr>
                                              <td style="font-weight:bold;width:10%">Name </td>
                                              <td style="font-weight:bold;">:</td>
                                              <td style="width:55%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.employee_fullname}}</td>
                                              <td style="font-weight:bold;width:5%"> ID </td>
                                              <td style="font-weight:bold">:</td>
                                              <td style="width:40%; padding-left:0px; padding-right:0px; ">
                                                <input type="hidden" v-model="form_data.employee_id" name="">
                                              {{form_data.company_sbu_id}}                                   {{form_data.user_employee_data.employee_id_no}}
                                              </td>
                                          </tr>
                                          <tr>
                                            <td style="font-weight:bold;width:10%" >Designation </td>
                                            <td style="font-weight:bold" >:</td>
                                            <td style="width:40%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.designation_name}}</td>
                                            <td style="font-weight:bold">Contact</td>
                                            <td style="font-weight:bold">:</td>
                                            <td style="width:25%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.employee_mobile}}</td>
                                          </tr>
                                          <tr>
                                            <td style="font-weight:bold;width:10%" >Department</td>
                                            <td style="font-weight:bold" >:</td>
                                            <td style="width:40%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.department_name}}</td>
                                            <td style="font-weight:bold" >Joining</td>
                                            <td style="font-weight:bold">:</td>
                                            <td style="width:25%; padding-left:0px; padding-right:0px; ">{{form_data.user_employee_data.employee_joining_date}}</td>
                                          </tr>
                                          <tr>
                                            <td style="font-weight:bold">SBU</td>
                                            <td style="font-weight:bold">:</td>
                                            <td style="width:33%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.sbu_name}}</td>
                                            <td style="font-weight:bold" >Location</td>
                                            <td style="font-weight:bold">:</td>
                                            <td style="width:33%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.work_location_name}}</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                     <div class="col-md-2 float-left" style="padding: 0px;text-align: right !important;">
                                       <span v-if="form_data.user_employee_data.employee_image">
                                         <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top: 1px;width: 119px;height: 132px;margin-left: -9px;margin-right: 1px;">
                                       </span>
                                       <span v-else>
                                         <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="    margin-top: 1px;width: 119px;height: 132px;margin-left: -9px;margin-right: 1px;">
                                       </span>
                                     </div>
                                  </div>
                                      <hr>
                               </div>
                                <div class="row"  style="margin-bottom: 10px;margin-right: -1.5px;margin-top: 38px;">
                                  <div class="col-md-12" style="padding:0px;"> 
                                    <div class="col-md-6 float-left">
                                        <div class="form-group" >
                                          <label class="col-md-6 control-label">Company/SBU <sup style="color: red; top: -2px;">*</sup></label>
                                          <div class="col-md-12 inputGroupContainer">
                                              <div class="input-group">
                                                <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                <vue-select v-model="company_sbu_value" :options="option_data.company_sbu_data" @select="onSelectEsbuData" placeholder="Select one" label="text" track-by="text"></vue-select>
                                              </div>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 float-left"> 
                                      <div class="form-group">
                                        <label class="col-md-12 control-label">Bank A/C <sup style="color: red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                            <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input v-model="form_data.user_employee_data.ebc_account_number" name="department_name" placeholder="" class="form-control" type="number" step="0.01">
                                            <input  v-model="form_data.ebc_account_number" name="department_name" placeholder="" class="form-control" type="number" step="0.01">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-md-3"> 
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Gross Salary <sup style="color: red; top: -2px;">*</sup></label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group">
                                           <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="gross_salary_entry" name="department_name" placeholder="" class="form-control" type="number" step="0.01">
                                         </div>
                                       </div>
                                    </div>
                                  </div>

                                   <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Mode of Payment <sup style="color: red; top: -2px;">*</sup></label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <select class="form-control" v-model="form_data.salary_goes_to" required="true" disabled>
                                              <option disabled>--Select--</option>
                                              <option value="1">Cash</option>
                                              <option value="2" selected>Bank</option>
                                           </select>
                                       </div>
                                    </div>
                                  </div>
                                  </div>

                                  <div class="col-md-3">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Effective Date <sup style="color: red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <datepicker placeholder="Select Date" style="width: 131% !important;" v-model="form_data.confirmation_date"   class="form-control" ></datepicker>
                                         </div>
                                        </div>
                                     </div>
                                   </div>
                                   <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Car Allowance</label>
                                       <div class="col-md-6 inputGroupContainer float-left">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <select @click="car_allowance($event)" class="form-control" v-model="form_data.car_allowance_status" required="true">
                                              <option disabled>--Select--</option>
                                              <option value="1">Yes</option>
                                              <option value="2">No</option>
                                           </select>
                                         </div>
                                       </div>
                                       <div v-if="car_allowance_field==1 || form_data.car_allowance_amount"  class="col-md-6 inputGroupContainer float-left">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="form_data.car_allowance_amount" name="department_name" placeholder="" class="form-control" type="number" step="0.01">
                                         </div>
                                       </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Basic Salary</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="basic_salary_entry" name="department_name" placeholder="" readonly="true" class="form-control" type="number" step="0.01">
                                         </div>
                                       </div>
                                    </div>
                                  </div>
                                   <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Housing Allowance</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="housing_allowance_entry" name="department_name" placeholder="" readonly="true" class="form-control" type="number" step="0.01"></div>
                                       </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Medical Allowance</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="medical_allowance_entry" name="department_name" placeholder="" readonly="true" class="form-control" type="number" step="0.01"></div>
                                       </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Conveyance Allowance</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="conveyance_allowance_entry" name="department_name" placeholder="" readonly="true" class="form-control" type="number" step="0.01"></div>
                                       </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                     <div class="form-group col-md-12 float-left" style="padding: 0px;">  <label class="col-md-12 float-left">Provident Fund 
                                         </label>
                                         <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                          <input  v-model="provident_fund_amount_entry" class="form-control" readonly="true" type="number" step="0.01"></div>
                                       </div>
                                     </div>
                                   </div>

                                  <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Others Allowance</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="form_data.others_allowance" name="department_name" placeholder="" class="form-control" type="number" step="0.01"></div>
                                       </div>
                                    </div>
                                  </div>

                                  <div class="col-md-3">
                                      <div class="form-group">   
                                         <label class="col-md-12">Gratuity Fund                    
                                           <input v-model="form_data.gratuity_fund" type="checkbox" value="1" style="margin-left: 29px;">  
                                         </label>                  
                                     </div>
                                  </div>
                                  <div class="col-md-3">
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

                                  <div class="col-md-12">
                                      <button v-if="view_cash_salary==0" type="button" @click="ViewCashSalary" class="btn btn-sm btn-success float-left col-md-2" style="margin-left: 10px;padding: 5px 3px;"><i class="fa fa-plus"></i> Add Cash Salary</button>
                                      <button v-if="view_cash_salary==1" type="button" @click="CloseCashSalary" class="btn btn-sm btn-success float-left col-md-2" style="margin-left: 10px;padding: 5px 3px;"><i class="fa fa-minus"></i> Cash Salary</button>
                                  </div>
                                </div>

                                <div v-if="view_cash_salary==1" class="row"  style="margin-bottom: 10px;margin-right: -1.5px;margin-top: 38px;">
                                  <div class="col-md-12" style="padding:0px;"> 
                                    <div class="col-md-6 float-left">
                                        <div class="form-group" >
                                          <label class="col-md-6 control-label">Company/SBU <sup style="color: red; top: -2px;">*</sup></label>
                                          <div class="col-md-12 inputGroupContainer">
                                              <div class="input-group">
                                                <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                <vue-select v-model="company_sbu_value" :options="option_data.company_sbu_data" @select="onSelectEsbuData" placeholder="Select one" label="text" track-by="text"></vue-select>
                                              </div>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 float-left"> 
                                      <div class="form-group">
                                        <label class="col-md-12 control-label">Bank A/C <sup style="color: red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                            <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input v-model="form_data.user_employee_data.ebc_account_number" name="department_name" placeholder="" class="form-control" type="number" step="0.01">
                                            <input  v-model="form_data.ebc_account_number" name="department_name" placeholder="" class="form-control" type="number" step="0.01">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-md-3"> 
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Gross Salary <sup style="color: red; top: -2px;">*</sup></label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group">
                                           <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="gross_salary_entry" name="department_name" placeholder="" class="form-control" type="number" step="0.01">
                                         </div>
                                       </div>
                                    </div>
                                  </div>

                                   <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Mode of Payment <sup style="color: red; top: -2px;">*</sup></label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <select class="form-control" v-model="form_data.salary_goes_to" required="true" disabled>
                                              <option disabled>--Select--</option>
                                              <option value="1">Cash</option>
                                              <option value="2" selected>Bank</option>
                                           </select>
                                       </div>
                                    </div>
                                  </div>
                                  </div>

                                  <div class="col-md-3">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Effective Date <sup style="color: red; top: -2px;">*</sup></label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <datepicker placeholder="Select Date" style="width: 131% !important;" v-model="form_data.confirmation_date"   class="form-control" ></datepicker>
                                         </div>
                                        </div>
                                     </div>
                                   </div>
                                   <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Car Allowance</label>
                                       <div class="col-md-6 inputGroupContainer float-left">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <select @click="car_allowance($event)" class="form-control" v-model="form_data.car_allowance_status" required="true">
                                              <option disabled>--Select--</option>
                                              <option value="1">Yes</option>
                                              <option value="2">No</option>
                                           </select>
                                         </div>
                                       </div>
                                       <div v-if="car_allowance_field==1 || form_data.car_allowance_amount"  class="col-md-6 inputGroupContainer float-left">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="form_data.car_allowance_amount" name="department_name" placeholder="" class="form-control" type="number" step="0.01">
                                         </div>
                                       </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Basic Salary</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="basic_salary_entry" name="department_name" placeholder="" readonly="true" class="form-control" type="number" step="0.01">
                                         </div>
                                       </div>
                                    </div>
                                  </div>
                                   <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Housing Allowance</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="housing_allowance_entry" name="department_name" placeholder="" readonly="true" class="form-control" type="number" step="0.01"></div>
                                       </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Medical Allowance</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="medical_allowance_entry" name="department_name" placeholder="" readonly="true" class="form-control" type="number" step="0.01"></div>
                                       </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Conveyance Allowance</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="conveyance_allowance_entry" name="department_name" placeholder="" readonly="true" class="form-control" type="number" step="0.01"></div>
                                       </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                     <div class="form-group col-md-12 float-left" style="padding: 0px;">  <label class="col-md-12 float-left">Provident Fund 
                                         </label>
                                         <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                          <input  v-model="provident_fund_amount_entry" class="form-control" readonly="true" type="number" step="0.01"></div>
                                       </div>
                                     </div>
                                   </div>

                                  <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label">Others Allowance</label>
                                       <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="form_data.others_allowance" name="department_name" placeholder="" class="form-control" type="number" step="0.01"></div>
                                       </div>
                                    </div>
                                  </div>

                                  <div class="col-md-3">
                                      <div class="form-group">   
                                         <label class="col-md-12">Gratuity Fund                    
                                           <input v-model="form_data.gratuity_fund" type="checkbox" value="1" style="margin-left: 29px;">  
                                         </label>                  
                                     </div>
                                  </div>
                                  <div class="col-md-3">
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
                  <div class="widget-header modal-header" >
                      <h4><i class="fa fa-bars"></i> Salary Info: <span style="color:green;">{{form_data.emp_info.employee_fullname}}</span></h4>
                      <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body">
                    <div class="row" v-if="profile_open==1" style="margin: 10px 5px 10px -5px;">
                                  <div class="col-md-12" style="border: 1px solid #cfcfcf;margin-left: 12px;    padding-right: 0px;   max-width: 98%;">
                                    <div class="col-md-10 modify-wraper float-left" style="padding:0px;">
                                      <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                                        <tbody>
                                          <tr>
                                              <td style="font-weight:bold;width:10%">Name </td>
                                              <td style="font-weight:bold;">:</td>
                                              <td style="width:55%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.employee_fullname}}</td>
                                              <td style="font-weight:bold;width:5%"> ID </td>
                                              <td style="font-weight:bold">:</td>
                                              <td style="width:40%; padding-left:0px; padding-right:0px; ">
                                                <input type="hidden" v-model="form_data.employee_id" name="">
                                              {{form_data.company_sbu_id}}                                   {{form_data.user_employee_data.employee_id_no}}
                                              </td>
                                              
                                          </tr>
                                          <tr>
                                            <td style="font-weight:bold;width:10%" >Designation </td>
                                            <td style="font-weight:bold" >:</td>
                                            <td style="width:40%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.designation_name}}</td>
                                            <td style="font-weight:bold">Contact</td>
                                            <td style="font-weight:bold">:</td>
                                            <td style="width:25%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.employee_mobile}}</td>
                                          </tr>
                                          <tr>
                                            <td style="font-weight:bold;width:10%" >Department</td>
                                            <td style="font-weight:bold" >:</td>
                                            <td style="width:40%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.department_name}}</td>
                                            <td style="font-weight:bold" >Joining</td>
                                            <td style="font-weight:bold">:</td>
                                            <td style="width:25%; padding-left:0px; padding-right:0px; ">{{form_data.user_employee_data.employee_joining_date}}</td>
                                          </tr>
                                          <tr>
                                            <td style="font-weight:bold">SBU</td>
                                            <td style="font-weight:bold">:</td>
                                            <td style="width:33%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.sbu_name}}</td>
                                            <td style="font-weight:bold" >Location</td>
                                            <td style="font-weight:bold">:</td>
                                            <td style="width:33%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.work_location_name}}</td>

                                          </tr>
                                          
                                        </tbody>
                                      </table>
                                      <!-- <hr> -->
                                    </div>
                                     <div class="col-md-2 float-left" style="padding: 0px;text-align: right !important;">
                                       <span v-if="form_data.user_employee_data.employee_image">
                                         <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top: 1px;width: 119px;height: 132px;margin-left: -9px;margin-right: 1px;">
                                       </span>
                                       <span v-else>
                                         <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="    margin-top: 1px;width: 119px;height: 132px;margin-left: -9px;margin-right: 1px;">
                                       </span>
                                     </div>
                                  </div>
                                      <hr>
                    </div>
                    <div class="container">
                      <table id="employeeTable" class="table table-bordered table-striped salaryTable">
                        <thead>
                          <tr>
                            <th colspan="10" style="color:green;text-align: right;">Total Salary : {{form_data.totalSalary}} </th>
                          </tr>
                          <tr>
                            <th rowspan="2" class="text-center">Salary On </th>
                            <!-- <th rowspan="2" class="text-center">Salary Type </th> -->
                            <th rowspan="2" class="text-center">Entry</th>
                            <th rowspan="2" class="text-center">Confirm. Date</th>
                            <th rowspan="2" class="text-center">Gross</th>
                            <th colspan="2" class="text-center">Allowance</th>
                            <th rowspan="2" class="text-center">PF </th>
<!--                             <th class="text-center">Medical </th>
 -->                            <!-- <th class="text-center">Overtime </th> -->
                            <th rowspan="2" class="text-center">Total </th>
                          </tr>
                          <tr> 
                            <th class="text-center">Car </th>
                            <th class="text-center">others </th>
                          </tr>
                        </thead>
                         <tbody  v-if="Object.keys(form_data.emp_salary).length > 0">
                          <tr v-for="(form_data, index) in form_data.emp_salary" v-bind:key="form_data.id" i=index>
                            <td class="text-center">
                               <span v-if="form_data.salary_goes_to==1" style="color:green;">Cash</span>
                                <span v-if="form_data.salary_goes_to==2" style="color:green;">Bank</span>
                            </td>
                            <!-- <td class="text-center">
                               <span v-if="form_data.type==1" style="color:green;">Salary</span>
                                <span v-if="form_data.type==2" style="color:green;">Increment</span>
                            </td> -->
                            <td class="text-center">{{form_data.entry_date}}</td>
                            <td class="text-center">{{form_data.confirmation_date}}</td>
                            <td class="text-right">{{form_data.gross_salary |number('0,0')}}</td>
                            <td class="text-right">{{form_data.car_allowance_amount |number('0,0')}}</td>
                            <td class="text-right">{{form_data.others_allowance |number('0,0')}}</td>
                            <td class="text-right">{{form_data.pf |number('0,0')}}</td>
                            <!-- <td class="text-right">{{form_data.overtime_work_compensation}}</td> -->
                            <td class="text-right">{{((form_data.gross_salary+ form_data.car_allowance_amount + form_data.others_allowance))|number('0,0') }}</td>
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
           provident_fund_amount_entry:'',
           basic_salary_entry:'',
           housing_allowance_entry:'',
           medical_allowance_entry:'',
           conveyance_allowance_entry:'',
           overtime_work_compensation_entry:'',
           profile_open:'',
           car_allowance_field:'',
           others_allowance_entry:'',
           provident_fund:1,
           company_sbu_value:'',
           getContext:'',
           view_cash_salary:0,
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
              // alert('sss');
               this.form_data.gross_salary = val;
               this.basic_salary_entry = (this.form_data.gross_salary*(this.form_data.salary_setting.basic_salary/100)).toFixed(2);
               this.form_data.basic_salary = this.basic_salary_entry;

               this.provident_fund_amount_entry = (this.form_data.basic_salary*(this.form_data.salary_setting.provident_fund/100)).toFixed(2);
               this.form_data.provident_fund_amount = this.provident_fund_amount_entry;

               this.housing_allowance_entry = (this.form_data.gross_salary*(this.form_data.salary_setting.housing_allowance/100)).toFixed(2);
               this.form_data.housing_allowance = this.housing_allowance_entry;

               this.medical_allowance_entry = (this.form_data.gross_salary*(this.form_data.salary_setting.medical_allowance/100)).toFixed(2);
               this.form_data.medical_allowance =  this.medical_allowance_entry;

               this.conveyance_allowance_entry = (this.form_data.gross_salary*(this.form_data.salary_setting.conveyance_allowance/100)).toFixed(2);
               this.form_data.conveyance_allowance = this.conveyance_allowance_entry;

               this.overtime_work_compensation_entry = (this.form_data.gross_salary*(this.form_data.salary_setting.overtime_work_compensation/100)).toFixed(2);
               this.form_data.overtime_work_compensation = this.overtime_work_compensation_entry;
             }, 
             basic_salary_entry: function(val){
               this.form_data.basic_salary = val;
             },
             provident_fund_amount_entry: function(val){
               this.form_data.provident_fund_amount = val;
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
          ViewCashSalary(){
            this.view_cash_salary = 1;
          },
          CloseCashSalary(){
            this.view_cash_salary = 0;
          },
          onSelectEsbuData(option){
            this.form_data.salary_sbu_id= option.id;
          },
          onSelectEmployeeSearch(option){
             this.resetModal();
             this.profile_open = 1;
             this.getModalDataOther(option.id);
             this.form_data.employee_id= option.id;
             this.form_data.employee_id=this.form_data.employee_id;
             this.form_data.company_sbu_id= this.form_data.user_employee_data.employee_sbu;
             // let allData =this.form_data.user_employee_data_all[option.id];
             // this.form_data.employee_id= allData['id']; 
           },
           getModalDataOther(id){
            this.modal_loading= false;
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
               this.form_data.salary_goes_to=2;
               this.errors =null;
                this.modal_loading= true;
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
                this.form_data.car_allowance_amount=this.form_data.car_allowance_amount;
              }else{
                this.car_allowance_field=2;
                this.form_data.car_allowance_amount=0;
              }
              console.log(this.car_allowance_field);
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
             this.provident_fund_amount_entry='';
           },
         }
    }



</script>
<style type="text/css">
  .salaryTable.table td{
    padding: 5px 5px !important;
  }
  .table thead th {
    vertical-align: middle;
    border-bottom: 2px solid #dee2e6;
}
#salary_tab .salary_tab{
    color: #495057;
    padding: 15px 30px !important;
    font-weight: bold !important;
   padding-left: 30px !important;
    
}
#salary_tab .salary_tab.active{
    color: #495057;
    padding: 15px 30px !important;
    font-weight: bold !important;
   padding-left: 30px !important;
    
}
</style>