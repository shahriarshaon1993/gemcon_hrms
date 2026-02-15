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
                               <h3 class="card-title d-none d-md-block">Employee Info Reports</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <a @click="$router.go(-1)" class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                               </span>
                           </div>
                       </div>
                    </div>
                   <div class="card-body row" style="padding-top:0px;">
                      <div class="col-md-12">
                        <div class="row" style="margin:10px 0px;">
                             <div class="input-group" >
                                <div class="form-group col-md-3 float-left" style="padding:0px;">
                                    <label class="col-md-12 control-label">From</label>
                                    <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <datepicker placeholder="Select Date" v-model="form_data.from_date" class="form-control"></datepicker>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group col-md-3 float-left" style="padding:0px;">
                                    <label class="col-md-12 control-label">To</label>
                                    <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <datepicker placeholder="Select Date" v-model="form_data.to_date"   class="form-control"></datepicker>
                                      </div>
                                    </div>
                                  </div>
                            </div> 
                        </div>
                
                   <div class="row report-box">
                      <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 10%">
                        <label class="col-md-12 control-label">Company/SBU</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="form_data.sbu_name_value" multiple="multiple" :options="option_data.company_sbu_data" @select="employeesSbu" placeholder="Select one"   label="text" track-by="text"></vue-select>
                          </div>
                        </div>
                      </div>
                       <div class="form-group col-md-2" style="max-width: 10%;">
                        <label class="col-md-12 control-label">Unit</label>
                        <div
                          class="col-md-12 inputGroupContainer"
                          style="padding: 0px"
                        >
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-home"></i
                            ></span>
                            <!-- {{form_data.unit_data}} -->
                            <vue-select
                              v-model="form_data.unit_value"
                              :options="form_data.unit_data"
                              @select="employeesUnit"
                              multiple="multiple"
                              placeholder="Select one"
                              label="text"
                              track-by="text"
                            ></vue-select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-2" style="max-width: 10%">
                        <label class="col-md-12 control-label">Sub Unit</label>
                        <div
                          class="col-md-12 inputGroupContainer"
                          style="padding: 0px"
                        >
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-home"></i
                            ></span>
                            <vue-select
                              v-model="form_data.sub_unit_value"
                              :options="form_data.sub_unit_data"
                              @select="employeesSubUnit"
                              placeholder="Select one"
                              multiple="multiple"
                              label="text"
                              track-by="text"
                            ></vue-select>
                          </div>
                        </div>
                      </div>
                   
                       <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 10%">
                        <label class="col-md-12 control-label">Department</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="form_data.department_name_value" :options="form_data.department_data" @select="onSelectDepartment" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>
                      <div  class="form-group col-md-2 float-left" style="padding:0px;max-width: 10%">
                        <label class="col-md-12 control-label">Section</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="form_data.section_value" :options="form_data.section_data" @select="employeesSection" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>
                      <div  class="form-group col-md-2 float-left" style="padding:0px;max-width: 10%">
                        <label class="col-md-12 control-label">Sub Section</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="form_data.sub_section_value" :options="form_data.sub_section_data" @select="employeesSubSection" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 10%">
                          <label class="col-md-12 control-label">Work Location</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="form_data.work_location_value" :options="form_data.work_location_data" @select="employeesWorkLocation" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>

                     
                      <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 10%">
                        <label class="col-md-12 control-label">Designation</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <vue-select v-model="form_data.designation_name_value" :options="option_data.designation_data" @select="onSelectDesignation" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 10%">
                        <label class="col-md-12 control-label">Employees</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                            <vue-select v-model="employee_name_value" :options="form_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 10%">
                        <label  class="col-md-12" style="margin:1px;">Status</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                              <select v-model="form_data.employee_status"  @change="EmplysStatus($event)" name="typ" class="form-control" style="font-size: 14px; height: 30px;">
                                <option value="0" disabled>-- Select Status --</option>
                                  <option> All </option>
                                  <option value="1">Active</option>
                                  <option value="3">Inactive</option>
                                  <option value="2">Resign</option>
                              </select>
                          </div>
                        </div>
                      </div>
                   </div>
                    <div class="row report-box" v-if="reportTypesVelu==2">
                        <div class="col-md-12 attendance-column" style="">
                          <div class="col-md-3 attendance-column report-box float-left" >
                              <label class="col-md-12 control-label">Report Columns:</label>
                              <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                    <vue-select  class="report_fileds" v-model="attendanceColumn_value" :options="option_data.attendanceColumn" style="padding: 3px 8px 0px 8px;" @select="onSelectAttendanceColumn" placeholder="Select one"  multiple="multiple" label="text" track-by="text"></vue-select>
                                </div>
                            </div>
                          </div>
                          <div class="col-md-9 float-left">
                            <ul class="tags">
                                <li  class="badge badge-pill badge-success" v-for="(checkedName, index) in checkedattcolsaddText" v-if="checkedName.text !=''" v-bind:key="checkedName.id">
                                    <samp @click="uncheck($event,checkedName)" > {{checkedName.text}} 
                                      <span class="btn-xs btn-danger" style="margin-right: -7px;"> <i class="fa fa-times"></i></span>  
                                    </samp>
                                </li>
                              </ul>
                          </div>
                        </div>
                     </div>

                    
                    <div class="row report-box" v-if="reportTypesVelu==2"> 
                      <!-- Purposes for Employee Report Start -->                
                      <div v-if="column_selection6=='age'" class="form-group col-md-3 float-left" style="padding:0px;">
                        <label class="col-md-12 control-label">Age</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input placeholder="Age From" required="true" type="number" v-model="form_data.age_from" class="form-control"></input>
                            <input placeholder="Age To" type="number" required="true" v-model="form_data.age_to" class="form-control"></input>
                          </div>
                        </div>
                      </div>
                      <div v-if="column_selection7=='salary'" class="form-group col-md-3 float-left" style="padding:0px;">
                        <label class="col-md-12 control-label">Salary</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input placeholder="Salary From" required="true" type="number" v-model="form_data.salary_from" class="form-control"></input>
                            <input placeholder="Salary To" required="true" type="number" v-model="form_data.salary_to" class="form-control"></input>
                          </div>
                        </div>
                      </div>
                      <div v-if="column_selection5=='permanent_district'" class="form-group col-md-3 float-left" style="padding:0px;">
                        <label class="col-md-12 control-label">District</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <!--  <vue-select v-model="district_value" :options="option_data.district_data" @select="employeesDistrict" placeholder="Select one" label="text" track-by="text"></vue-select> -->
                              <vue-select v-model="form_data.district_value" :options="option_data.district_data" @select="employeesDistrict" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>
                      <div v-if="column_selection3=='employee_marital_status'" class="form-group col-md-3 float-left" style="padding:0px;">
                        <label class="col-md-12 control-label">Marital Status</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <select v-model="form_data.employee_marital_status" name="employee_status" class="selectpicker form-control">
                              <option value="0">Select</option>
                              <option value="1">Single</option>
                              <option  value="2">Married</option>
                              <option value="3">Widowed</option>
                              <option value="4">Divorced</option>
                              <option value="5">Separated </option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div v-if="column_selection14=='employee_gender'" class="form-group col-md-3 float-left" style="padding:0px;">
                        <label class="col-md-12 control-label">Gender</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <select v-model="form_data.employee_gender" name="employee_status" class="selectpicker form-control">
                              <option value="0">Select</option>
                              <option value="1">Female</option>
                              <option  value="2">Male</option>
                              <option value="3">Others</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div v-if="column_selection10=='employee_job_grade'" class="form-group col-md-3 float-left" style="padding:0px;">
                        <label class="col-md-12 control-label">Job Grade</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <vue-select v-model="form_data.jobgradeData_value" :options="option_data.jobgrade_data" @select="jobgradeData" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>
                      <div v-if="column_selection9=='service_length'" class="form-group col-md-3 float-left" style="padding:0px;">
                        <label class="col-md-12 control-label">Service Length</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input placeholder="Service Length From" required="true" type="number" v-model="form_data.service_length_from" class="form-control"></input>
                            <input placeholder="Service Length To" type="number" required="true" v-model="form_data.service_length_to" class="form-control"></input>
                          </div>
                        </div>
                      </div>

                      <div v-if="column_selection4=='employee_blood_group'" class="form-group col-md-3 float-left" style="padding:0px;">
                        <label class="col-md-12 control-label">Blood Group</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <select v-model="form_data.employee_blood_group" class="selectpicker form-control">
                              <option value="0">Select</option>
                              <option value="A(+ve)">A(+ve)</option>
                              <option value="A(-ve)">A(-ve)</option>
                              <option value="B(+ve)">B(+ve)</option>
                              <option value="B(-ve)">B(-ve)</option>
                              <option value="O(+ve)">O(+ve)</option>
                              <option value="O(-ve)">O(-ve)</option>
                              <option value="AB(+ve)">AB(+ve)</option>
                              <option value="AB(-ve)">AB(-ve)</option>
                              <option value="N/A">N/A</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    

                    <div v-if="column_selection11=='emplyee_category_mgt_non_mgt'" class="form-group col-md-3 float-left" style="padding:0px;">
                        <label class="col-md-12 control-label">Employee Category</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <vue-select v-model="form_data.employee_Category_value" :options="option_data.emplyeeCategory" @select="employeesCategory" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>
                    <div v-if="column_selection12=='employee_type'" class="form-group col-md-3 float-left" style="padding:0px;">
                        <label class="col-md-12 control-label">Employee Type</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="form_data.employee_type_value" :options="option_data.employeeType" @select="employeeTypes" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>
                      
                      <div v-if="column_selection13=='employee_group'" class="form-group col-md-3 float-left" style="padding:0px;">
                        <label class="col-md-12 control-label">Employee Group</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <vue-select v-model="form_data.employee_group_value" :options="option_data.employee_group_data" @select="employeesGroup" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                    <button style="border-radius: 5px; margin-right: -15px;padding: 5px 30px;"  @click="viewReportss11111($event)" type="button" class="btn btn-info float-right">Search</button>
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
      <div class="loader">
      </div>
    
      <!-- v-if="form_data.payroll_employee_data" -->
       <!-- v-if="form_data.employee_infos" -->
        <!-- v-if="(form_data.employee_infos).length > 0" -->
       
      <section class="content local_excel_print">
            <div class="container-fluid">
              <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="col-12">
                        <button id="btnExport"  @click="tableToExcel" class="btn-success float-right" style="margin-left:10px;">Export</button>
                        <!-- <button v-print="'#printMe'" class="btn-info float-right">Print</button> -->
                        <button @click="printDiv()" class="btn-info float-right">Print</button>
                        <!-- <button data-toggle-fullscreen>Toggle Fullscreen</button> -->
                      </div>
                        <!-- <div class="POMIS_2A_REPORT_VIEW1"  id="printMe" style="padding: 10px 25px 50px 20px"> -->
                        <div class="POMIS_2A_REPORT_VIEW1" id="printable" style="overflow-x: auto;">
                      </div>
                    </div>
                  </div>
              </div>
            </div>
      </section>
       
        </div>
    </div>
     <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body col-md-12">
                     
                      <div class="row col-md-12" >
                          <div class="col-12">
                            <button id="btnExport"  @click="tableToExcel" class="btn-success float-right" style="margin-left:10px;">Export</button>
                            <button @click="printDiv()" class="btn-info float-right">
                             
                            Print</button>
                          </div>
                          <div class="col-md-12" id="printable">
                            <div class=" " style="min-height: 56px;" v-if="modal_loading">
                            <div class="col-md-12">
                              <h4 class="text-center" style="margin:0px;">Gemcon Group</h4>
                              <p class="text-center" style="margin:0px;">List of Employees Entitled for insurance</p>
                              <p class="text-center" style="margin:0px;">Date: {{form_data.report_print_date}}</p>
                            </div>
                            {{this.form_datas}}
                            <table id="employeeTable_ids" class="table table-bordered  table-striped employeeTable" style="table-layout:fixed;width: 100% !important">
                              <thead>
                                <tr style="text-align: center;">
                                  <th style="vertical-align: middle;width: 50px" >SL</th>
                                  <th style="vertical-align: middle;width: 120px;">Employee ID</th>
                                  <th style="vertical-align: middle;width: 200px;"> Name</th>
                                  <th style="vertical-align: middle;width: 200px;">Designation</th>
                                  <th style="vertical-align: middle;width: 200px;">Department</th>
                                  <th style="vertical-align: middle;width: 200px;">Section</th>
                                  <th style="vertical-align: middle;width: 200px;">Sub Section</th>
                                  <th style="vertical-align: middle;width: 200px;">Work Location</th>
                                  <th style="vertical-align: middle;width: 200px;">SBU</th>
                                  <th style="vertical-align: middle;width: 90px;">Grade New</th>
                                  <th style="vertical-align: middle;width: 90px;">Salary (Tk.)</th>
                                  <th style="vertical-align: middle;width: 200px;">Date of Joining</th>
                                  <th style="vertical-align: middle;width: 200px;">Length of Service (Year)</th>
                                  <th style="vertical-align: middle;width: 200px;">Years of Experience</th>
                                  <th style="vertical-align: middle;width: 200px;">Permanent Address (C/O or House No. or 1st Line)</th>
                                  <th style="vertical-align: middle;width: 100px;">Village</th>
                                  <th style="vertical-align: middle;width: 200px;">P.O</th>
                                  <th style="vertical-align: middle;width: 100px;">P.S</th>
                                  <th style="vertical-align: middle;width: 150px;">Home District</th>
                                  <th style="vertical-align: middle;width: 150px;">Present Address (C/O or House No. or 1st Line)</th>
                                  <th style="vertical-align: middle;width: 200px;">Mobile No.</th>
                                  <th style="vertical-align: middle;width: 200px;">Short/Nick Name</th>
                                  <th style="vertical-align: middle;width: 200px;">Date of Birth</th>
                                  <th style="vertical-align: middle;width: 200px;">Age (on today)</th>
                                  <th style="vertical-align: middle;width: 200px;">Blood Group</th>
                                  <th style="vertical-align: middle;width: 200px;">Gender</th>
                                  <th style="vertical-align: middle;width: 200px;">Educational Qualification</th>
                                  <th style="vertical-align: middle;width: 200px;">National ID No.</th>
                                  <th style="vertical-align: middle;width: 200px;">Passport</th>
                                  <th style="vertical-align: middle;width: 200px;">Employment Status</th>
                                  <th style="vertical-align: middle;width: 200px;">Mgt./Non-Mgt.</th>
                                  <th style="vertical-align: middle;width: 200px;">Reporting Supervisor's ID</th>
                                  <th style="vertical-align: middle;width: 200px;">Reporting Supervisor's Name</th>
                                  <th style="vertical-align: middle;width: 200px;">Remarks</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="(form_data, index) in this.form_datas" v-bind:key="form_data.id" >
                                  <td class="text-center">{{index+1}}</td>
                                  <td class="text-center"> {{form_data.employee_id_no}}</td>
                                  <td>{{form_data.employee_fullname}}</td>
                                  <td>{{form_data.designation_name}}</td>
                                  <td>{{form_data.work_location_name}}</td>
                                  <td class="text-center">{{form_data.employee_joining_date}}</td>
                                  <td class="text-center">{{form_data.service_length}}</td>
                                  <td class="text-center">{{form_data.employee_dob}}</td>
                                  <td class="text-center">{{form_data.employee_age}}</td>
                                  <td class="text-center">{{form_data.jobgrade_name}}</td>
                                  <td class="text-right">{{form_data.insurance_amount |number('0,0.00')}}</td>
                                  <td class="text-right">{{form_data.yearly_premium_cost |number('0,0.00') }}</td>
                                  <td>{{form_data.employee_sbu}}</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                         <div v-if="!modal_loading">
                            <pageLoading></pageLoading>
                        </div>
              </div>
        </div>
        <!-- <div class="row col-md-12" v-else>
            <h4 style="color: darkgrey;">No Data Found ! </h4>
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
    <div v-if="!page_loading">
        <pageLoading></pageLoading>
    </div>
</div>
</template>
<script>
import Loading from "../Loading.vue";
import print from "vue-print-nb";
import $ from "jquery";
import Multiselect from "vue-multiselect";

export default {
  data() {
    return {
      info_data: [],
      district_value: "",
      employee_group_value: "",
      column_selection1: "",
      column_selection2: "",
      column_selection3: "",
      column_selection4: "",
      column_selection5: "",
      column_selection6: "",
      column_selection7: "",
      column_selection8: "",
      column_selection9: "",
      column_selection10: "",
      column_selection11: "",
      column_selection12: "",
      column_selection13: "",
      column_selection14: "",
      attendanceColumn_value: "",
      employee_Category_value: "",
      visable: "",
      report_container: 0,
      // sbu_name_value:'',
      sbu_name_value: [],
      employeeSbuData: [],
      form_datas: [],
      section_value: "",
      district_value: "",
      sub_section_value: "",
      employee_group_value: "",
      sub_unit_value: "",
      work_location_value: [],
      department_name_value: "",
      department_name_value: [],
      work_location_value: [],
      AttStatus_value: "",
      employee_type_value: "",
      work_location_value: "",
      designation_name_value: "",
      jobgrade_name_value: "",
      employee_name_value: "",
      employee_name_value: "",
      report_data: [],
      reportTypesVelu: 0,
      dailyReportTypesVelu: 0,
      periodicReportTypesVelu: 0,
      individualReportTypesVelu: 0,
      checkedName: true,
      urls: '',
      value: [],
      options: [
        { name: "Vue.js", language: "JavaScript" },
        { name: "Adonis", language: "JavaScript" },
        { name: "Rails", language: "Ruby" },
        { name: "Sinatra", language: "Ruby" },
        { name: "Laravel", language: "PHP" },
        { name: "Phoenix", language: "Elixir" },
      ],
      checkNameArray: [
        {
          label: "",
        },
      ],
      checkedattcols: [],
      isCheckAll: false,
      checkedattcolsaddText: [
        {
          id: "",
          text: "",
        },
      ],
      checkedattcolsadd: [],
      printObj: {
        id: "printMe",
        popTitle: "good print",
        extraCss: "https://www.google.com,https://www.google.com",
        extraHead: '<meta http-equiv="Content-Language"content="zh-cn"/>',
      },
    };
  },
  directives: {
    print,
  },
  created() {
    this.getResults(1);
    // this.setFormData();
    // this.getUrl();
  },
  components: {
    pageLoading: Loading,
    Multiselect,
  },
  methods: {
    printDiv() {
      $("h3").each(function () {
        this.style.setProperty("margin", "0px", "important");
        this.style.setProperty("font-size", "1.75rem", "important");
      });
      $("h4").each(function () {
        this.style.setProperty("margin", "0px", "important");
        this.style.setProperty("font-size", "1.5rem", "important");
      });
      $("h5").each(function () {
        this.style.setProperty("margin", "0px", "important");
        this.style.setProperty("font-size", "1.25rem", "important");
      });
      $("h6").each(function () {
        this.style.setProperty("margin", "0px", "important");
        this.style.setProperty("font-size", "1rem", "important");
      });
      $(".table-bordered").each(function () {
        this.style.setProperty("border", "1px solid #dee2e6", "important");
        this.style.setProperty("padding", "5px .75rem", "important");
        this.style.setProperty("border-collapse", "collapse", "important");
      });
      $(".ths").each(function () {
        this.style.setProperty("border", "1px solid #dee2e6", "important");
        this.style.setProperty("padding", "5px 5px", "important");
        this.style.setProperty("border-collapse", "collapse", "important");
      });
      let contents = document.getElementById("printable").innerHTML;

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
    reportTypes(event) {
      if (event.target.value == 1) {
        this.reportTypesVelu = 1;
        this.dailyReportTypesVelu = 0;
        this.periodicReportTypesVelu = 0;
        this.individualReportTypesVelu = 0;
        this.column_selection1 = "";
        this.column_selection2 = "";
        this.column_selection3 = "";
        this.column_selection4 = "";
        this.column_selection5 = "";
        this.column_selection6 = "";
        this.column_selection7 = "";
        this.column_selection8 = "";
        this.column_selection9 = "";
        this.column_selection10 = "";
        this.column_selection11 = "";
        this.column_selection12 = "";
        this.column_selection13 = "";
        this.column_selection14 = "";
        this.form_data.checkedattcolsadd = "";

        this.fromDataReset();
      } else if (event.target.value == 2) {
        this.reportTypesVelu = 2;
        this.dailyReportTypesVelu = 0;
        this.periodicReportTypesVelu = 0;
        this.individualReportTypesVelu = 0;

        this.fromDataReset();
      } else if (event.target.value == 4) {
        this.reportTypesVelu = 4;
        this.dailyReportTypesVelu = 0;
        this.periodicReportTypesVelu = 0;
        this.individualReportTypesVelu = 0;

        this.fromDataReset();
      } else {
        this.reportTypesVelu = 0;
      }
      console.log(event.target.value);
    },
    fromDataReset() {
      this.employee_name_value = "";
      this.form_data.att_report_type = "";
      this.form_data.employee_sbu = "";
      this.form_data.employee_section = "";
      this.form_data.employee_group = "";
      this.form_data.employee_sub_unit = "";
      this.form_data.employee_work_location = "";
      this.form_data.employee_department = "";
      this.form_data.employee_designation = "";
      this.form_data.employee_job_grade = "";
      this.form_data.employee_id = "";
      this.form_data.employee_status = "";
      this.sbu_name_value = [];
      // this.sbu_name_value='';
      this.employeeSbuData = [];
      this.section_value = "";
      this.sub_section_value = "";
      this.employee_group_value = "";
      this.sub_unit_value = "";
      this.work_location_value = [];
      this.department_name_value = "";
      this.work_location_value = "";
      this.designation_name_value = "";
      this.jobgrade_name_value = "";
      this.employee_name_value = "";
      this.employee_name_value = "";
      this.DailyreportStatus = "";
      this.jobgradeData_value = "";
      this.service_length_from = "";
      this.service_length_to = "";
      // this.EmplysStatus='';
      this.form_data.att_status = "";
      this.form_data.att_status = "";
      this.AttStatus_value = "";
    },


    tableToExcel() {
      var uri = "data:application/vnd.ms-excel;base64,",
        template =
          '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
        base64 = function (s) {
          return window.btoa(unescape(encodeURIComponent(s)));
        },
        format = function (s, c) {
          return s.replace(/{(\w+)}/g, function (m, p) {
            return c[p];
          });
        };
      var toExcel = document.getElementById("tblCustomers").innerHTML;
      var ctx = {
        worksheet: name || "",
        table: toExcel,
      };
      var link = document.createElement("a");
      link.download = "export.xls";
      link.href = uri + base64(format(template, ctx));
      link.click();
    },
    fullScreenView() {},
    printText() {},

    // viewReportss11111(form_data, url) {
    viewReportss11111(event) {
      // $(".local_excel_print").hide();
      // $(".loader").show();
      this.modal_loading= false;
      let urla = URL.baseUrl("employee_get_report");
      console.log(urla);
      $.ajax({
        url: urla,
        data: {
          checkedattcolsadd: this.form_data.checkedattcolsadd,
          report_type: this.form_data.report_type,
          employee_department: this.form_data.employee_department,
          employee_designation: this.form_data.employee_designation,
          employee_sbu: this.form_data.employee_sbu,
          att_report_type: this.form_data.att_report_type,
          from_date: this.form_data.from_date,
          to_date: this.form_data.to_date,
          employee_id: this.form_data.employee_id,
          employee_section: this.form_data.employee_section,
          employee_sub_section: this.form_data.employee_sub_section,
          age_from: this.form_data.age_from,
          age_to: this.form_data.age_to,
          salary_from: this.form_data.salary_from,
          salary_to: this.form_data.salary_to,
          permanent_district: this.form_data.permanent_district,
          employee_marital_status: this.form_data.employee_marital_status,
          employee_gender: this.form_data.employee_gender,

          employee_blood_group: this.form_data.employee_blood_group,
          employee_department: this.form_data.employee_department,
          employee_designation: this.form_data.employee_designation,

          employee_name_value: this.form_data.employee_name_value,
          designation_name_value: this.form_data.designation_name_value,
          department_name_value: this.form_data.department_name_value,
          work_location_value: this.form_data.work_location_value,
          sbu_name_value: this.form_data.sbu_name_value,

          section_value: this.form_data.section_value,
          sub_section_value: this.form_data.sub_section_value,
          district_value: this.form_data.district_value,
          employee_group_value: this.form_data.employee_group_value,
          employee_type_value: this.form_data.employee_type_value,
          employee_Category_value: this.form_data.employee_Category_value,
          att_status: this.form_data.att_status,
          employee_status: this.form_data.employee_status,

          jobgradeData_value: this.form_data.jobgradeData_value,
          service_length_from: this.form_data.service_length_from,
          service_length_to: this.form_data.service_length_to,
          AttStatus_value: this.AttStatus_value,
          OfficeTime: this.form_data.OfficeTimeVelu,
          sub_unit_value: this.form_data.sub_unit_value,
          unit_value: this.form_data.unit_value,

          _token: $("input[name=_token]").val(),
        },
        type: "POST",
        success: function (res) {
          console.log(res);
          // this.form_data=return_data.data;
          //     this.modal_loading= true;
          // this.report_container = 1;
          // $("#report_container").show();
          // $(".POMIS_2A_REPORT_VIEW1").html(return_data);
          // $(".loader").hide();
          // $(".local_excel_print").show();
          // this.printStyles();
          // this.printDiv();
              this.form_datas=res.employee_infos;
               console.log(this.form_datas);
              this.modal_loading= true;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          ajax_request_handaler(errorThrown);
          var msg = "opps! something went wrong";
          this.showToster({ status: 0, message: msg });
        },
      });
    },
    employeesCategory() {},
    employeeTypes() {},
    printStyles() {
      $("h3").each(function () {
        this.style.setProperty("margin", "0px", "important");
        this.style.setProperty("font-size", "1.75rem", "important");
      });
      $("h4").each(function () {
        this.style.setProperty("margin", "0px", "important");
        this.style.setProperty("font-size", "1.5rem", "important");
      });
      $("h5").each(function () {
        this.style.setProperty("margin", "0px", "important");
        this.style.setProperty("font-size", "1.25rem", "important");
      });
      $("h6").each(function () {
        this.style.setProperty("margin", "0px", "important");
        this.style.setProperty("font-size", "1rem", "important");
      });
    },
 
    onSelectAtt_status(option) {
      this.form_data.att_status = option;
    },
    onSelectOfficeTime(option) {
      this.form_data.OfficeTime = option;
    },
    jobgradeData(option) {
      this.form_data.employee_job_grade = option.id;
    },
    employeesGroup(option) {
      console.log(option);
      this.form_data.employee_group = option.id;
      console.log(this.form_data.employee_group);
    },
    onSelectDesignation(option) {
      console.log(option);
      this.form_data.employee_designation = option.id;
      console.log(this.form_data.employee_designation);
    },
    onSelectJobGrade(option) {
      console.log(option);
      this.form_data.employee_job_grade = option.id;
      console.log(this.form_data.employee_job_grade);
    },
    onSelectEmployee(option) {
      // alert('s')
      console.log(option);
      this.form_data.employee_id = option.id;
      console.log(this.form_data.employee_id);
    },
    employeesDistrict(option) {
      console.log(option);
      this.form_data.permanent_district = option.id;
      console.log(this.form_data.permanent_district);
    },
    setModalData() {
      this.employee_name_value = this.form_data.employee_name_value;
    },


    setFormData() {
      // this.form_data.att_report_type = 0;
      // this.form_data.report_type = 0;
    },
  },
};
</script>
<style type="text/css">
.report_fileds
  > .multiselect__tags
  > .multiselect__tags-wrap
  > .multiselect__tag {
  display: none;
}
.local_excel_print {
  display: none;
}
.loader {
  display: none;
}
.loader {
  border: 10px solid #ffffff;
  border-radius: 50%;
  border-top: 10px solid #fec23c;
  border-bottom: 10px solid #fec23c;
  width: 60px;
  height: 60px;
  position: fixed;
  left: 50%;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
  }
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@media print {
  .test {
    background-color: #1a4567 !important;
    -webkit-print-color-adjust: exact;
  }
}
.multiselect__content-wrapper {
  width: 200% !important;
}
</style>