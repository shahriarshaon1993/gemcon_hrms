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
                               <h3 class="card-title d-none d-md-block">Increment List</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <!-- <a class="btn btn-info" href="#" data-toggle="modal" data-target="#addNewDepartment"><i class="fa fa-plus"></i> Add New</a> -->
                                 <!-- v-if="lists.add=='add'" -->
                                 <div   @click="getModalData($event,{dataUrl:'create/increment'},resetModal)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>

                                 <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>

                               </span>
                           </div>
                       </div>
                    </div>
                    <div class="card-body col-md-12">
                      <div class="col-md-4 col-sm-4 col-4 float-left" style="padding:0px;">
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
                  <div class="col-md-2 col-sm-2 col-2 float-left" style="padding:0px;"> 
                    <div class="button_group">
                        <a
                        href="javascript:;"
                        class="button_s my_file el-button button_s el-button--primary el-button--small"
                        >
                          <input type="file" class="my_input" @change="importExcel" id="upload" />
                        </a>
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-2 col-2 float-left"> 
                     <div class="button_group">
                        <a
                        :href="'payroll/increment/filedownload'"
                        class="button_s my_file el-button button_s btn btn-sm btn-info el-button--primary el-button--small"
                        >
                        Exmple File {{this.backend_url}}
                        </a>
                    </div>
                  </div>
                  
                  <div class="col-md-4 col-sm-4 col-4 float-left" style="padding:0px;">
                      <div class="dataTables_filter" id="DataTables_Table_0_filter">
                          <label class="float-right">
                              <div class="input-group"><span class="input-group-addon"><i class="icon-search"></i></span>
                                  <input v-on:keyup="getResults" v-model="search_input.search_key" type="text" aria-controls="DataTables_Table_0" class="form-control search-keyword" id="search"  placeholder="Search...">
                              </div>
                          </label>
                      </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-12 float-left" style="padding:0px;">
                    <p style="color:red" v-for="error in file_upload_error">{{error}}</p>
                  </div>

                  <table id="employeeTable" class="table table-bordered table-striped employeeTable">
                    <thead>
                      <tr>
                        <!-- <th class="text-center">#</th>
                        <th class="text-center">Emp. ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Joining Date</th>
                        <th class="text-center">Effective Date</th>
                        <th class="text-center">Basic Salary</th>
                        <th class="text-center">Housing Rent</th>
                        <th class="text-center">Transport Allow.</th>
                        <th class="text-center">Medical Allow.</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 15%;">Action</th> -->
                        <th class="text-center">Sl</th>
                        <th class="text-center">ID</th>
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
                        <td class="text-center" style="width: 15%;">
                          <!-- v-if="lists.edit=='edit'" -->
                          <button  class="btn btn-xs btn-info" @click="getModalData($event,{dataUrl:'edit/increment/'+form_data.id}, setModalData)" title="Edit" > <i class="fa fa-edit"> </i> Edit </button>
                          <!-- v-if="lists.delete=='delete'" -->
                          <button  class="btn btn-xs btn-danger"  @click="deleteItem({delUrl:'delete/increment/'+form_data.id}, setModalData)" title="Delete" ><i class="fa fa-trash"></i> Delete</button>
                        </td>
                      </tr>
                    </tbody>
                     <tbody v-else>
                        <tr>
                            <td colspan="16" align="center">No data in database</td>
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

       <modal class="" name="myModal" height="auto" :clickToClose="false" width="800">
            <div v-if="modal_loading">
                <div class="widget-header modal-header">
                    <h4><i class="fa fa-bars"></i> Increment Entry  </h4>
                    <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modify-wraper modal-body">
                  <div class="container">
                    <form @submit.prevent="add({add:'add/increment'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                      <!-- <div class="row"> -->
                        <!-- <div class="col-md-12"> -->
                          <div class="form-group" v-if="!form_data.id">
                             <label class="col-md-6 control-label">Employee</label>
                             <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                   <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployeeSearch" placeholder="Select one" label="text" track-by="text"></vue-select>
                                  
                                </div>
                             </div>
                          </div>
                          <div class="row" v-if="profile_open==1" style="margin: 10px 5px 10px -5px;">
                             <input  v-model="form_data.company_sbu_id" class="form-control" required="true" type="hidden" step="0.01">
                              <input v-model="form_data.salary_sbu_id" class="form-control" required="true" type="hidden" step="0.01">
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
                                           {{form_data.user_employee_data.employee_id_no}}
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
                               <div class="col-md-2 float-left" style="padding: 0px;text-align: right !important;" v-if="form_data.user_employee_data">
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
                          <div class="row" v-if="profile_open==1">
                             <div class="col-md-12" style="border: 1px solid #cfcfcf;margin-left: 13px;    padding-right: 0px;padding: 0px; max-width: 96.5%;">
                                <table id="employeeTable" style="margin-bottom: 0rem;width: 100.2%;margin-left: -0.2px;" class="table table-bordered table-striped salaryTable">
                                  <thead>
                                    <tr>
                                      <th colspan="2" style="color:green;text-align: left;border-right: 1px solid #">  Salary Info </th>
                                      <th colspan="8" style="color:green;text-align: right;">Total Salary : {{form_data.totalSalary}} </th>
                                    </tr>
                                    <tr>
                                      <th rowspan="2" class="text-center">Salary On </th>
                                      <th rowspan="2" class="text-center">Entry</th>
                                      <th rowspan="2" class="text-center">Confirm. Date</th>
                                      <th rowspan="2" class="text-center">Gross</th>
                                      <th colspan="2" class="text-center">Allowance</th>
                                      <th rowspan="2" class="text-center">PF </th>
                                      <th rowspan="2" class="text-center">Total </th>
                                    </tr>
                                    <tr> 
                                      <th class="text-center">Car </th>
                                      <th class="text-center">others </th>
                                    </tr>
                                  </thead>
                                   <tbody  v-if="form_data.emp_salary && Object.keys(form_data.emp_salary).length > 0">
                                    <tr v-for="(form_data, index) in form_data.emp_salary" v-bind:key="form_data.id" i=index>
                                        <td style="border: 1px solid #dee2e6;" class="text-center">
                                           <span v-if="form_data.salary_goes_to==1" style="color:green;">Cash</span>
                                            <span v-if="form_data.salary_goes_to==2" style="color:green;">Bank</span>
                                        </td>
                                        <td style="border: 1px solid #dee2e6;" class="text-center">{{form_data.entry_date}}</td>
                                        <td style="border: 1px solid #dee2e6;" class="text-center">{{form_data.confirmation_date}}</td>
                                        <td style="border: 1px solid #dee2e6;" class="text-right">{{form_data.gross_salary |number('0,0')}}</td>
                                        <td style="border: 1px solid #dee2e6;" class="text-right">{{form_data.car_allowance_amount |number('0,0')}}</td>
                                        <td style="border: 1px solid #dee2e6;" class="text-right">{{form_data.others_allowance |number('0,0')}}</td>
                                        <td style="border: 1px solid #dee2e6;" class="text-right">{{form_data.pf |number('0,0')}}</td>
                                        <td style="border: 1px solid #dee2e6;" class="text-right">{{((form_data.gross_salary+ form_data.car_allowance_amount + form_data.others_allowance))|number('0,0') }}</td>
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
                          <br>
                          <br>

                           <div class="row">
                             <div class="col-md-3"> 
                               <div class="form-group">
                                  <label class="col-md-12 control-label">Increment Type</label>
                                  <div class="col-md-12 inputGroupContainer">
                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <select @change="increment_type($event)" class="form-control" v-model="form_data.increment_type" required="true">
                                         <option disabled>--Select--</option>
                                         <option value="1">Fixed</option>
                                         <!-- <option value="2">Percentage</option> -->
                                      </select>
                                    </div>
                                  </div>
                               </div>
                             </div>
                             <div class="col-md-3"> 
                               <div class="form-group" v-if="increment_type_field==1">
                                  <label class="col-md-12 control-label">Total Amount</label>
                                  <div class="col-md-12 inputGroupContainer">
                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input v-model="gross_salary_entry" name="department_name" placeholder="" class="form-control" required="true" type="number" step="0.01">
                                    </div>
                                  </div>
                               </div>
                               <div class="form-group" v-if="increment_type_field==2">
                                  <label class="col-md-12 control-label">Increment percentage(%)</label>
                                  <div class="col-md-12 inputGroupContainer">
                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input v-model="increment_percentage_entry" class="form-control" required="true" type="number" step="0.01">
                                    </div>
                                  </div>
                               </div>
                             </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                   <label class="col-md-12 control-label">Effective From <sup style="color: red; top: -2px;">*</sup></label>
                                   <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <input type="date" name="begin" placeholder="dd-mm-yyyy"  style="width: 131% !important;" v-model="form_data.confirmation_date" class="form-control" min="1997-01-01" max="2030-12-31">

                                       <!-- <datepicker placeholder="Select Date" style="width: 131% !important;" v-model="form_data.confirmation_date"   class="form-control" ></datepicker> -->
                                    </div>
                                   </div>
                                </div>
                              </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                   <label class="col-md-12 control-label">Salary Goes To <sup style="color: red; top: -2px;">*</sup></label>
                                   <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                       <select class="form-control" v-model="form_data.salary_goes_to" required="true">
                                          <option disabled>--Select--</option>
                                          <option value="1">Cash</option>
                                          <option value="2">Bank</option>
                                       </select>
                                   </div>
                                </div>
                              </div>
                              </div>

                             
                             <div class="col-md-3">
                               <div class="form-group">
                                  <label class="col-md-12 control-label">Basic Salary</label>
                                  <div class="col-md-12 inputGroupContainer">
                                     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input v-model="basic_salary_entry" name="department_name" placeholder="" class="form-control" readonly="true" required="true" type="number" step="0.01">
                                    </div>
                                  </div>
                               </div>
                             </div>

                              <div class="col-md-3">
                               <div class="form-group">
                                  <label class="col-md-12 control-label">House Rent</label>
                                  <div class="col-md-12 inputGroupContainer">
                                     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input v-model="housing_allowance_entry" name="department_name" placeholder="" class="form-control" readonly="true" required="true" type="number" step="0.01"></div>
                                  </div>
                               </div>
                             </div>

                             <div class="col-md-3">
                               <div class="form-group">
                                  <label class="col-md-12 control-label">Medical Allowance</label>
                                  <div class="col-md-12 inputGroupContainer">
                                     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input v-model="medical_allowance_entry" name="department_name" placeholder="" class="form-control" readonly="true" required="true" type="number" step="0.01"></div>
                                  </div>
                               </div>
                             </div>
                              <div class="col-md-3">
                               <div class="form-group">
                                  <label class="col-md-12 control-label">Transport Allowance</label>
                                  <div class="col-md-12 inputGroupContainer">
                                     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input v-model="conveyance_allowance_entry" name="department_name" placeholder="" class="form-control" readonly="true" required="true" type="number" step="0.01"></div>
                                  </div>
                               </div>
                             </div>
                              <div class="col-md-3">
                                <div class="form-group float-left" style="padding: 0px;"> 
                                <label class="col-md-12 control-label">Provident Fund Entry</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                     <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                     <input  v-model="provident_fund_amount_entry" class="form-control" type="number" readonly="true" step="0.01">
                                   </div>
                                 </div>
                               </div>
                             </div>

                             <div class="col-md-3">
                               <div class="form-group">
                                  <label class="col-md-12 control-label">Special Allowance</label>
                                  <div class="col-md-12 inputGroupContainer">
                                     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input v-model="form_data.others_allowance" name="department_name" placeholder="" class="form-control" type="number" step="0.01"></div>
                                  </div>
                               </div>
                             </div>

                              <div class="col-md-4">
                                <div class="form-group float-left">
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
                                  <div v-if="car_allowance_field==1 || form_data.car_allowance_amount" class="col-md-6 inputGroupContainer float-left">
                                     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input v-model="form_data.car_allowance_amount" name="department_name" placeholder="Car Allowance*" class="form-control" type="number" step="0.01">
                                    </div>
                                  </div>
                               </div>
                              </div>
                               <div class="col-md-2">
                                 <div class="form-group" v-if="form_data.id" style="padding-top:15px">
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


                           <div class="row">
                             <div class="col-md-3">
                               
                             </div>
                           </div>
                          
                     <!--    </div>
                      </div> -->
                      <div class="form-actions col-md-12" style="padding-top:15px;">
                          <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2">
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
  import Datepicker from 'vuejs-datepicker';
  import * as xlsx from 'xlsx/xlsx';
  export default {
    data(){
      return{
        file_upload_error:'',
        employee_name_value:'',
        gross_salary_entry:'',
        basic_salary_entry:'',
        housing_allowance_entry:'',
        medical_allowance_entry:'',
        conveyance_allowance_entry:'',
        overtime_work_compensation_entry:'',
        profile_open:'',
        increment_type_field:'',
        car_allowance_field:'',
        increment_percentage_entry:'',
        gross_salary_entryyy:'',
        provident_fund_amount_entry:'',
        backend_url:'',
      }
    },
    created(){
      this.getResults(1);
    },
    components:{
        pageLoading:Loading
    },
    watch: {
          // increment_percentage_entry: function(val){
          //   console.log('aaa');
          //   console.log(val);
          //   console.log(this.form_data.employee_salary);
          //   console.log('aaa');
          //   // alert(val);
          //   this.form_data.increment_percentage = val;

          //   this.basic_salary_entry = ((this.form_data.employee_salary.basic_salary*val)/100);
          //   this.form_data.basic_salary = this.basic_salary_entry;

          //   this.provident_fund_amount_entry = (this.form_data.basic_salary*(this.form_data.salary_setting.provident_fund/100)).toFixed(2);
          //   this.form_data.provident_fund_amount = this.provident_fund_amount_entry;

          //   this.housing_allowance_entry = (this.form_data.employee_salary.basic_salary*(this.form_data.salary_setting.housing_allowance/100)).toFixed(2);
          //   this.form_data.housing_allowance = this.housing_allowance_entry;

          //   this.medical_allowance_entry = (this.form_data.employee_salary.basic_salary*(this.form_data.salary_setting.medical_allowance/100)).toFixed(2);
          //   this.form_data.medical_allowance =  this.medical_allowance_entry;

          //   this.conveyance_allowance_entry = (this.form_data.employee_salary.basic_salary*(this.form_data.salary_setting.conveyance_allowance/100)).toFixed(2);
          //   this.form_data.conveyance_allowance = this.conveyance_allowance_entry;

          //   this.overtime_work_compensation_entry = (this.form_data.employee_salary.basic_salary*(this.form_data.salary_setting.overtime_work_compensation/100)).toFixed(2);

          //   this.form_data.overtime_work_compensation = this.overtime_work_compensation_entry;ta.overtime_work_compensation = this.overtime_work_compensation_entry;

          //   this.form_data.gross_salary = (this.basic_salary_entry + this.housing_allowance_entry + this.medical_allowance_entry + this.conveyance_allowance_entry);
          // }, 
        gross_salary_entry: function(val){
          this.form_data.gross_salary = val;

          // this.gross_salary_entryyy = ((this.form_data.increment_percentage*this.form_data.employee_salary.basic_salary)/100);

          this.basic_salary_entry = (this.form_data.gross_salary*(this.form_data.salary_setting.basic_salary/100)).toFixed(2);
          this.form_data.basic_salary = this.basic_salary_entry;


          // console.log(this.form_data.basic_salary);
          // console.log(this.form_data.salary_setting.basic_salary);
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
      importExcel(e) {
            const files = e.target.files;
            console.log(files);
            if (!files.length) {
              return ;
            } else if (!/\.(xls|xlsx)$/.test(files[0].name.toLowerCase())) {
              return alert("The upload format is incorrect. Please upload xls or xlsx format");
            }
            const fileReader = new FileReader();
            fileReader.onload = ev => {
              try {
                const data = ev.target.result;
                const XLSX = xlsx;
                const workbook = XLSX.read(data, {
                  type: "binary"
                });
                const wsname = workbook.SheetNames[0]; // Take the first sheet，wb.SheetNames[0] :Take the name of the first sheet in the sheets
                const ws = XLSX.utils.sheet_to_json(workbook.Sheets[wsname]); // Generate JSON table content，wb.Sheets[Sheet名]    Get the data of the first sheet
                const excellist = [];  // Clear received data
                // Edit data
                for (var i = 0; i < ws.length; i++) {
                  excellist.push(ws[i]);
                }
                this.excelFileUpload(excellist);
                console.log("Read results", excellist); // At this point, you get an array containing objects that need to be processed
              } catch (e) {
                console.log(e);
                return alert("Read failure!");;
              }
            };
            fileReader.readAsBinaryString(files[0]);
            var input = document.getElementById("upload");
            input.value = "";
          },

          excelFileUpload(excellist){
              this.modal_page_loading= false;
               let uri = URL.baseUrl('add/excel/increment');
              axios.post(uri,
                {
                  form_data:excellist,
                })
                .then(res => {
                   console.log(res.data);
                   this.getResults();
                   // this.form_data = excellist;
                   this.modal_page_loading= true;
                   this.errors =null;
                   if(res.data.status == 3){
                    //  alert("qqq");
                     this.file_upload_error = res.data.error;
                   }else{
                     this.file_upload_error = null;
                   }
                   if(callback){
                     callback();
                   }
                 })
                .catch(error => {
                  this.modal_page_loading= true;
                })
           },
      onSelectEmployee(option){
        console.log(option);
        this.form_data.employee_id= option.id;
        console.log(this.form_data.employee_id);
      },
      onSelectEmployeeSearch(option){
        this.profile_open=1;
        this.getModalDataOther(option.id);
        this.form_data.employee_id = option.id;
        this.form_data.employee_id = this.form_data.employee_id;
        console.log(this.form_data.employee_id);
        console.log(option);
        let allData =this.form_data.employee_data[option.id];
        this.form_data.employee_id= allData['id']; 
      },
      getModalDataOther(id){
        // console.log('aaaaaa');
        this.modal_loading= false;
        let uri = URL.baseUrl('other_create/increment/'+id);
        console.log(uri);
        axios.get(uri)
        .then(res => {
          console.log(res.data);
          this.form_data = res.data;
          this.form_data.employee_id=id;
          this.form_data.car_allowance_status=2;
          this.form_data.increment_type=2;
          this.increment_type_field=2;
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
      
      setModalData(){
        this.employee_name_value=this.form_data.employee_name_value;
        this.gross_salary_entry=this.form_data.gross_salary.toFixed(2);
        this.basic_salary_entry=this.form_data.basic_salary.toFixed(2);
        this.housing_allowance_entry=this.form_data.housing_allowance.toFixed(2);
        this.medical_allowance_entry=this.form_data.medical_allowance.toFixed(2);
        this.conveyance_allowance_entry=this.form_data.conveyance_allowance.toFixed(2);
        this.overtime_work_compensation_entry=this.form_data.overtime_work_compensation.toFixed(2);
        this.profile_open=1;
        this.increment_type_field = this.form_data.increment_type;
        this.increment_percentage_entry = this.form_data.increment_percentage;
      },
      resetModal(){
        this.gross_salary_entry='';
        this.basic_salary_entry='';
        this.housing_allowance_entry='';
        this.medical_allowance_entry='';
        this.conveyance_allowance_entry='';
        this.overtime_work_compensation_entry='';
        this.profile_open='';
        this.employee_name_value='';
        this.car_allowance_field='';
        this.increment_type_field=2;
        this.form_data.car_allowance_status=2;
        this.form_data.increment_type=2;
      },
      car_allowance(e){
         var val = e.target.value;
         if (val==1) {
           this.car_allowance_field=1;
           this.form_data.car_allowance_amount=this.form_data.car_allowance_amount;
         }else{
           this.car_allowance_field=2;
           this.form_data.car_allowance_amount=0;
         }
      },
      increment_type(e){
          var val = e.target.value;
          if (val==1) {
            this.increment_type_field=1;
            this.increment_percentage_entry='';
            this.gross_salary_entry='';
            this.basic_salary_entry='';
            this.housing_allowance_entry='';
            this.medical_allowance_entry='';
            this.conveyance_allowance_entry='';
          }else{
            this.increment_type_field=2;
            this.increment_percentage_entry='';
            this.basic_salary_entry='';
            this.gross_salary_entry='';
            this.housing_allowance_entry='';
            this.medical_allowance_entry='';
            this.conveyance_allowance_entry='';
          }

      }
    }
  }
</script>