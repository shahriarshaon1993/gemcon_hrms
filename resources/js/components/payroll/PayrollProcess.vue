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
                                 <h3 class="card-title d-none d-md-block">Payroll Process</h3>
                                 <span class="float-sm-right" style="float: right;">
                                   <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                                 </span>
                             </div>
                         </div>
                      </div>
                      <div class="card-body col-md-12">
                        <div class="row col-md-12">
                            <div class="row report-box col-md-12">
                              <div class="form-group col-md-2" style="padding:0px;">
                                <label class="col-md-12 control-label">Date Type <sup style="color:red; top: -2px;">*</sup></label>
                                  <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <select @change="DateTypeId($event)" class="form-control" v-model="date_type" >
                                          <option id="" disabled value="">--Select Type--</option>
                                          <option value='1' selected>Monthwise</option>
                                          <option value='2'>Datewise </option>
                                      </select>
                                    </div>
                                </div>
                              </div>
  
                             <!-- <div> -->
                                <div class="form-group col-md-3" style="padding:0px;" v-if="date_type==2">
                                <label class="col-md-12 control-label">From Date <sup style="color:red; top: -2px;">*</sup></label>
                                  <div class="col-md-12 inputGroupContainer">
                                    <div class="form-group">
                                      <div class="col-md-12 inputGroupContainer"  style="padding:0px;">
                                         <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                          <datepicker placeholder="Select Date" style="width: 100% !important;" v-model="from_date"  class="form-control" ></datepicker>
                                        </div>
                                      </div>
                                   </div>
                                </div>
                              </div>
                              <div class="form-group col-md-2" style="padding:0px;" v-if="date_type==2">
                                <label class="col-md-12 control-label">To Date <sup style="color:red; top: -2px;">*</sup></label>
                                  <div class="col-md-12 inputGroupContainer"  style="padding:0px;">
                                    <div class="form-group">
                                      <div class="col-md-12 inputGroupContainer">
                                         <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                          <datepicker placeholder="Select Date" style="width: 100% !important;" v-model="to_date"  class="form-control" ></datepicker>
                                        </div>
                                      </div>
                                   </div>
                                </div>
                              </div>
                             <!-- </div> -->
  
                              <div class="form-group col-md-3" style="padding:0px;" v-if="date_type==1">
                                <label class="col-md-12 control-label">Month <sup style="color:red; top: -2px;">*</sup></label>
                                  <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                      <select @change="monthsSelectsId($event)" class="form-control" v-model="monthly_id" >
                                          <option id="" disabled value="">--Select Month--</option>
                                          <option v-for="months in option_data.months_array"  :value='months.id' >{{months.text }}
                                          </option>
                                      </select>
                                    </div>
                                </div>
                              </div>
  
                              <div class="form-group col-md-2" style="padding:0px;">
                                <label class="col-md-12 control-label">Salary Grade <sup style="color:red; top: -2px;">*</sup></label>
                                  <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                      
                                      <select @change="SalaryGrade($event)" class="form-control" v-model="Salary_grade" >
                                          <option id="" disabled value="">--Salary Grade--</option>
                                          <option v-for="payrollPerm in option_data.payrollPermissions"  :value='payrollPerm.id' >{{payrollPerm.text }}
                                          </option>
                                      </select>
                                    </div>
                                </div>
                              </div> 
  
                              <div class="form-group col-md-2" style="padding:0px;">
                                <label class="col-md-12 control-label">Salary Type <sup style="color:red; top: -2px;">*</sup></label>
                                  <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                      <select @change="SalaryTypeId($event)" class="form-control" v-model="form_data.salary_type_id" >
                                          <option id="" disabled value="">--Salary Type--</option>
                                          <option value='1' selected>Cash</option>
                                          <option value='2' >Bank </option>
                                      </select>
                                    </div>
                                </div>
                              </div>  
                              <div class="form-group col-md-2" style="padding:0px;">
                                <label class="col-md-12 control-label">Employee Category</label>
                                  <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                      <select v-model="
                                        form_data.emplyee_category_mgt_non_mgt
                                      " name="employee_status" class="selectpicker form-control">
                                        <option value="">--Select--</option>
                                        <option value="1">Management</option>
                                        <option value="2">Non-Management</option>
                                      </select>
                                    </div>
                                </div>
                              </div>  
  
                              <!-- <div class="col-md-3" style="padding:0px;" >
                                  <div class="form-group" id="company_sbu_show" >
                                    <label class="col-md-12 control-label">Company/SBU <sup style="color:red; top: -2px;">*</sup></label>
                                    <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbuId" placeholder="Select one" label="text" track-by="text"></vue-select>
                                      </div>
                                    </div>
                                  </div>
                              </div> -->
                            </div>
  
                            <div class="row report-box col-md-12">
                              <div class="form-group col-md-2" style="max-width: 10%; padding:0px;">
                                <label class="col-md-12 control-label"
                                  >SBU <sup style="color: red; top: -2px">*</sup></label
                                >
                                <div
                                  class="col-md-12 inputGroupContainer"
                                  style="padding: 0px"
                                >
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <vue-select
                                      v-model="form_data.sbu_name_value"
                                      :options="option_data.company_sbu_data"
                                      @select="employeesSbu"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-md-2" style="max-width: 10%; padding:0px;">
                                <label class="col-md-12 control-label">Unit</label>
                                <div
                                  class="col-md-12 inputGroupContainer"
                                  style="padding: 0px"
                                >
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
                                    <vue-select
                                      v-model="form_data.unit_value"
                                      :options="option_data.unit_data"
                                      @select="employeesUnit"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                      multiple="multiple"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-md-2" style="max-width: 10%; padding:0px;">
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
                                      :options="option_data.sub_unit_data"
                                      @select="employeesSubUnit"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                      multiple="multiple"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-md-2" style="max-width: 10%; padding:0px;">
                                <label class="col-md-12 control-label"
                                  >Department</label
                                >
                                <div
                                  class="col-md-12 inputGroupContainer"
                                  style="padding: 0px"
                                >
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
                                    <vue-select
                                      v-model="form_data.department_name_value"
                                      :options="option_data.department_data"
                                      @select="onSelectDepartment"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                      multiple="multiple"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-md-2" style="max-width: 10%; padding:0px;">
                                <label class="col-md-12 control-label">Section</label>
                                <div
                                  class="col-md-12 inputGroupContainer"
                                  style="padding: 0px"
                                >
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
                                    <vue-select
                                      v-model="form_data.section_value"
                                      :options="option_data.section_data"
                                      @select="employeesSection"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                      multiple="multiple"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-md-2" style="max-width: 10%; padding:0px;">
                                <label class="col-md-12 control-label"
                                  >Sub Section</label
                                >
                                <div
                                  class="col-md-12 inputGroupContainer"
                                  style="padding: 0px"
                                >
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
  
                                    <vue-select
                                      v-model="form_data.sub_section_value"
                                      :options="option_data.sub_section_data"
                                      @select="employeesSubSection"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                      multiple="multiple"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-md-2" style="max-width: 10%; padding:0px;">
                                <label class="col-md-12 control-label">Work Loc.</label>
                                <div
                                  class="col-md-12 inputGroupContainer"
                                  style="padding: 0px"
                                >
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-envelope"></i
                                    ></span>
                                    <vue-select
                                      v-model="form_data.work_location_value"
                                      :options="option_data.work_location_data"
                                      @select="employeesWorkLocation"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                      multiple="multiple"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
  
                              <div
                                class="form-group col-md-2"
                                id="employee_wise_show"
                                style="max-width: 10%; padding:0px;"
                              >
                                <label class="col-md-12 control-label">Employee</label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-earphone"></i
                                    ></span>
                                    <vue-select
                                      v-model="form_data.employee_name_value"
                                      :options="option_data.employee_data"
                                      @select="onSelectEmployee"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                      multiple="multiple"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div
                                class="form-group col-md-2"
                                id="employee_wise_show"
                                style="max-width: 10%; padding:0px;"
                              >
                                <label class="col-md-12 control-label">Grade</label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-earphone"></i
                                    ></span>
                                    <vue-select
                                      v-model="form_data.jobgrade_name_value"
                                      :options="option_data.jobgrade_data"
                                      @select="onSelectJobGrade"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                      multiple="multiple"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div
                                class="col-md-1 float-right"
                                style="max-width: 6%; padding: 18px 0px"
                              >
                                <!-- <span>
                                  <a
                                    @click="onSearchAllData($event)"
                                    class="btn btn-xs"
                                    style="
                                      color: #212529 !important;
                                      background-color: #fac23c;
                                      border-color: #fac23c;
                                      width: 50px;
                                      height: 30px;
                                    "
                                    ><i
                                      class="fa fa-search"
                                      style="
                                        color: #212529 !important;
                                        background-color: #fac23c;
                                        border-color: #fac23c;
                                        margin-top: 5px;
                                      "
                                    ></i
                                  ></a>
                                </span> -->
                                <span v-if="employeesSbu && salary_grade">
                                  <a @click="addPayrollProcess($event)" id="addCF" class="btn btn-xs " style="color: #fff !important;padding: .3rem .25rem;background-color: #17a2b8;border-color: #17a2b8; width: 100px;">
                                    <!-- <i class="fa fa-search" style="color: #10707f !important;background-color: #fac23c;border-color: #fac23c;"></i>  -->
                                    Search 
                                  </a>
                                </span>
                              </div>
                            </div>
                            <!-- <div class="form-group col-md-1" style="padding:0px;">
                               <label class="col-md-12 control-label"> </label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span v-if="employeesSbu && months_id && salary_grade">
                                      <a @click="addPayrollProcess($event)" id="addCF" class="btn btn-xs " style="color: #212529 !important;padding: .3rem .25rem;background-color: #fac23c;border-color: #fac23c;"><i class="fa fa-plus" style="color: #212529 !important;background-color: #fac23c;border-color: #fac23c;"></i> Submit </a>
                                    </span>
                                  </div>
                               </div>
                            </div> -->
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
  
          <section class="content" v-if="form_data.payroll_employee_data">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                         
                      </div>
                      <div class="card-body col-md-12">
                        <!-- <div class="dbgOuter">
                          <div class="dbgCont">
                              <input type="checkbox" id="dbgTrace" class="dbgCheck" />
                              <label for="dbgTrace">Trace</label>
                          </div>
                          <div class="dbgCont">
                              <input type="checkbox" id="dbgDebug" class="dbgCheck" />
                              <label for="dbgDebug">Debug</label>
                          </div>
                          <div class="dbgCont">
                              <input type="checkbox" id="dbgInfo" class="dbgCheck" checked="checked" />
                              <label for="dbgInfo">Info</label>
                          </div>
                          <div class="dbgCont">
                              <input type="checkbox" id="dbgWarn"  class="dbgCheck" />
                              <label for="dbgWarn">Warn</label>
                          </div>
                          <div class="dbgCont">
                              <input type="checkbox" id="dbgErr"  class="dbgCheck" />
                              <label for="dbgErr">Error</label>
                          </div>
                        </div> -->

                         <button id="btnExport"  @click="tableToExcel" class="btn-success float-right" style="margin-left:10px;">Export</button>
                         <button @click="printDiv()" class="btn-info float-right">Print</button>
                        <div class="row col-md-12" id="printable" v-if="(form_data.payroll_employee_data).length > 0">
                          <div class="col-lg-12 text-center">
                              <h4 style=" margin-top: -5px;">{{form_data.company_name}}</h4>
                          </div>
                          <!-- style="overflow-x: scroll;" -->
                          <form @submit.prevent="add({add:'add/payrollprocess'})"  id="validate-1" class="payroll-process">
                            <div class="row">
                              <input type="submit" style="margin-bottom: 9px; height: 40px; margin-left: 15px;" tabindex="4" value="Save" class="btn btn-sm btn-info col-md-1">
                              <textarea v-model="form_data.summary_remarks" class="form-control  col-md-9" placeholder="Remarks"   style="margin-bottom: 8px; height: 40px;  margin-left: 15px;"></textarea>
                            </div>
                            <div class="col-md-12  ">
                              <!-- <div class="col-md-1">   -->
                                 
                              <!-- </div>    -->
                              <div class=" " style="min-height: 56px;" v-if="modal_loading">
                                <!-- <div class=""> -->
                              <table id="tblCustomers" class="table table-bordered  table-striped employeeTable" style="table-layout:fixed;width: 100% !important">
                                <thead>
                                  <tr style="text-align: center;">
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 65px" >Action</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 50px" >Sl.</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 120px;" >Employee ID</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Employee Name</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Designation</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Department</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Work Location</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >SBU</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 60px;" >Grade</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 95px;"  >Joining Date</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >A/C No</th>
                                    <th class="ths" colspan="6" style="vertical-align: middle;width: 500px;" >Attendance</th>
                                    <th v-if="this.company_id == 26" class="ths" rowspan="2" style="vertical-align: middle;width: 85px;" >T. Off Days Worked</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 85px;" >G. Salary</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 80px;" >Absent Deduc.</th>
                                    <!-- <th class="ths" rowspan="2" style="vertical-align: middle;text-align: center" title="Absent Deduction">Absent</th> -->
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 85px;" >G. Payable</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 85px;" >Basic Salary</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 85px;" >House Rent</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 85px;" >Med. Allow</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 82px;" >Conv. Allow</th>
                                    <th v-if="this.company_id == 26"  class="ths" rowspan="2" style="vertical-align: middle;width: 82px;" >Day off allow.</th>
                                    <th class="ths" colspan="7" style="vertical-align: middle;width: 500px;" >Addition</th>
                                    <th class="ths" colspan="3" style="vertical-align: middle;width: 200px;" > Provident Fund </th>
                                    <th class="ths" colspan="8" style="vertical-align: middle;width: 550px;" >Deduction</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Net Payable</th>
                                    <!-- <th class="ths" rowspan="2" style="vertical-align: middle;width: 120px;" >Remarks</th> -->
                                  </tr>
                                  <tr>
                                    <th class="ths" style="vertical-align: middle;text-align: center; width: 30px;"  title="Present Day"> P</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center; width: 30px;"  title="Late Day"> L</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center"  title="Absent Day"> A</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center; width: 30px;"  title="Leave Day"> LV</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center"  title="Weekend/Holiday"> W/H</th>
                                    <!-- <th class="ths" style="vertical-align: middle;text-align: center" title="Total Deduction Day"> D. Day</th> -->
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Pay Day</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Arrear</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Mobile</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Car</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Incentive</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Allowance</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Other</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Total</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center"  title="Provident Fund"> PF</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center"  title="Company Provident Fund"> CPF</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" title="Total Provident Fund"> TPF</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" title="Advance"> Adv./Loan</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Uniform</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Deposit</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > TAX</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Mobile</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Late</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Other</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Total</th>
                                    
                                  </tr>
                                </thead>
                                 <tbody>
                                  <tr v-for="(form_data, index) in payroll_employee_data" v-bind:key="form_data.id" >
                                    <td class="text-center">
                                      <button  type="button"  @click="internalGridRemove($event,form_data)" class="btn btn-danger btn-xs btn-custom-padding" title="Remove from list"><i style="margin-top: 4px" class="fa fa-times"></i></button>
                                    </td>
                                    <td style="text-align: center;">{{index+1}}</td>
                                    <td style="text-align: center;"> {{form_data.employee_id_no}}</td>
                                    <td>{{form_data.employee_fullname}}</td>
                                    <td>{{form_data.designation_name}}</td>
                                    <td>{{form_data.department_name}}</td>
                                    <td>{{form_data.work_location_name}}</td>
                                    <td style="text-align: center;">{{form_data.sbu_short_name}}</td>
                                    <td style="text-align: center;">{{form_data.jobgrade_name}}</td>
                                    <td style="text-align: center;">{{form_data.employee_joining_date}}</td>
                                    <td style="text-align: center;">{{form_data.ebc_account_number}}</td>
                                    <td style="vertical-align: middle;text-align: center">{{form_data.prtot}}</td>
                                    <td style="vertical-align: middle;text-align: center">{{form_data.lttot}}</td>
                                    <td style="vertical-align: middle;text-align: center">{{form_data.abtot}}</td>
                                    <td style="vertical-align: middle;text-align: center">{{form_data.levtot}}</td>
                                    <td style="vertical-align: middle;text-align: center">{{form_data.whtot}}</td>
                                     <td style="vertical-align: middle;text-align: center">
                                        <input @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'pay_day',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'pay_day'+form_data.id" v-model="form_data.pay_day" class="form-control" type="text" readonly>
                                     </td>
                                    <td v-if="form_data.company_sbu_id == 26" style="vertical-align: middle;text-align: center"> 
                                         {{form_data.total_day_off_worked | number('0,0') }}
                                    </td>
                                    <td style="vertical-align: middle;text-align: right"> 
                                         {{form_data.g_salary | number('0,0') }}
                                    </td>
                                    <td style="vertical-align: middle;text-align: right"> 
                                        {{form_data.absent_amount | number('0,0') }}
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                      {{form_data.g_payble_daywise | number('0,0') }}
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                    {{form_data.b_salary_daywise |number('0,0') }}
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                    {{form_data.h_allowance |number('0,0') }}
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                    {{form_data.m_allowance_daywise |number('0,0') }}
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                    {{form_data.c_allowance_daywise |number('0,0') }}
                                    </td>
                                    <td v-if="form_data.company_sbu_id == 26" class="text-right" style="width: 81px;vertical-align: middle;">
                                    {{form_data.day_off_allowance |number('0,0') }}
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                      <input  @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'arrear_amount',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'arrear_amount'+form_data.id" v-model="form_data.arrear_amount" class="form-control" type="text" readonly>
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                      <input  @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'mobile_addition',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'mobile_addition'+form_data.id" v-model="form_data.phone_allowance" class="form-control" type="text" readonly>
                                    </td>
                                    <td class="text-right" style="width: 100px;vertical-align: middle;">
                                      <input  @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'car_allowance',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'car_allowance'+form_data.id" v-model="form_data.car_allowance" class="form-control" type="text" readonly>
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                      <input  @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'incentive',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'incentive'+form_data.id" v-model="form_data.incentive" class="form-control" type="text" readonly>
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                      <input  @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'addition_allownce',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'addition_allownce'+form_data.id" v-model="form_data.addition_allownce" class="form-control" type="text" readonly>
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                      <input  @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'other_allowance',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'other_allowance'+form_data.id" v-model="form_data.other_allowance" class="form-control" type="text" readonly>
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                    {{form_data.total_addition |number('0,0') }}
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                      <input  @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'p_fund',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'p_fund'+form_data.id" v-model="form_data.p_fund" class="form-control" type="text" readonly>
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                    {{form_data.p_fund |number('0,0') }}
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                      {{(form_data.t_p_fund) |number('0,0') }}
                                    </td>
  
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                      <input  @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'ad_or_lone',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'ad_or_lone'+form_data.id" v-model="form_data.ad_or_lone" class="form-control" type="text" readonly>
                                    </td> 
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                      <input  @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'uniform',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'uniform'+form_data.id" v-model="form_data.uniform" class="form-control" type="text" readonly>
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                      <input  @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'deposit',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'deposit'+form_data.id" v-model="form_data.deposit" class="form-control" type="text" readonly>
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                      <input  @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'tax_amount',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'tax_amount'+form_data.id" v-model="form_data.tax_amount" class="form-control" type="text" readonly>
                                    </td> 
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                      <input  @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'mobile_amount',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'mobile_amount'+form_data.id" v-model="form_data.mobile_amount" class="form-control" type="text" readonly>
                                    </td>
                                    <td class="text-right" style="width: 180px;vertical-align: middle;">
                                      {{form_data.late_deduction | number('0,0') }}
                                    </td>
                                    <td class="text-right" style="width: 81px;vertical-align: middle;">
                                      <input  @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'other_amount',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'other_amount'+form_data.id" v-model="form_data.other_amount" class="form-control" type="text" readonly>
                                    </td>
                                    <td class="text-right" style="width: 180px;vertical-align: middle;">
                                      {{form_data.total_deduction | number('0,0') }}
                                    </td>
                                    <td class="text-right" style="width: 180px;vertical-align: middle;">
                                      {{form_data.net_payable | number('0,0') }}
                                    </td>
                                    <td class="text-right" style="width: 180px;vertical-align: middle;">
                                      <input  @keyup="inlineCalculation1($event,form_data,index)" v-on:dblclick="counter += 1, funcao($event, 'ind_remarks',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'ind_remarks'+form_data.id" v-model="form_data.ind_remarks" class="form-control" type="text">
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <small> 
                                <strong>Note: </strong>  <strong>Pay Day = </strong> (P + L + W/H + A)-(D.Day), <strong> Deduction Day(D.Day)</strong>  = L + A, <strong>Gross Payable</strong>= (Salary Period/Gross Salary)* Pay Day, <strong> Basic Salary	</strong>	= (Gross Payable*{{form_data.employee_payroll_setting.basic_salary}})/100, <strong> House Rent</strong>	= (Gross Payable*{{form_data.employee_payroll_setting.housing_allowance}})/100, <strong>Med. Allow</strong>	= (Gross Payable*{{form_data.employee_payroll_setting.medical_allowance}})/100, <strong>Conv. Allow	</strong>	= (Gross Payable*{{form_data.employee_payroll_setting.conveyance_allowance}})/100, <strong>PF </strong>	= (Basic Salary	*{{form_data.employee_payroll_setting.provident_fund}})/100,<strong>CPF </strong>	= PF,<strong>TPF </strong>	= PF + CPF, <strong>Net Payable	 </strong>	= (Gross Payable	+ Arrear + Mobile + Car + Other)- (PF + Adv.+ Uniform + Deposit + TAX + Mobile + Other),
                              </small>
                            </div>
                           <div v-if="!modal_loading">
                     <pageLoading></pageLoading>
                 </div>
                            </div>
                           </form>
                        </div>
                        <div class="row col-md-12" v-else>
                           <h4 style="color: darkgrey;">No Data Found ! </h4>
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
        <div v-if="!modal_loading">
            <pageLoading></pageLoading>
        </div>
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
      import VueTimepicker from 'vue2-timepicker'
      // CSS
      import 'vue2-timepicker/dist/VueTimepicker.css'   
  
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
             employee_data_approvaldat:'',
             datesList:'',
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
             monthly_id:'',
             salary_grade:'',
             Salary_grade:'',
             salary_type:'',
             Salary_type:'',
             employee_id:'',
             week_id:'',
             roaster_type:'',
             permission_id:'',
             formDataAll:'',
             weekly_id:0,
             weeks_id:0,
             weekly_data:'',
             months_id:0,
             permission_id_name:'',
             date_type:1,
             employees_list:[],
             payroll_employee_data:[],
             counter: 0,
             clicks: 0,
             from_date: '',
             to_date: '',
             salary_type_id:1,
             company_id:''
           }
         },
  
          created(){
              this.getResults(1);
              this.modal_loading= true;
          },
          components:{
              pageLoading:Loading,
              VueTimepicker 
          },
          computed: {
      options: () => countries,
    },
        methods:{
  
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
        $(".text-center").each(function () {
          this.style.setProperty("text-align", "center", "important");
        });
        $(".text-right").each(function () {
          this.style.setProperty("text-align", "right", "important");
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
  
      //  inlineCalculation(event,form_data,index){
        //     form_data.c_p_fund = form_data.p_fund;
      //     form_data.pay_day = ((+form_data.prtot)+(+form_data.lttot)+(+form_data.whtot)+(+form_data.abtot))-(+form_data.total_deduction_day);
      //     console.log(form_data.c_p_fund);
      //  },
      
          inlineCalculation1(event,row,index){
            // console.log (row);
            // console.log('fff');
            // console.log(row);
            // console.log('fff');
             
            let total_salary = 0;
            let total_deduction = 0;
            let final_net_payable = 0;
            let net_payable = 0;
            // row.pay_day = ((+row.prtot)+(+row.lttot)+(+row.levtot)+(+row.whtot)+(+row.abtot))-(+row.total_deduction_day);
            // g_payble_daywise
            row.pay_day = (+row.pay_day);
            if(row.pay_day != ''){
             
              row.b_salary_daywise = (+(row.per_day_b_salary) * (+row.pay_day)).toFixed(2);
              row.h_allowance_daywise = ((+row.per_day_h_allowance) * (+row.pay_day)).toFixed(2);
              row.m_allowance_daywise = ((+row.per_day_m_allowance) * (+row.pay_day)).toFixed(2);
              row.c_allowance_daywise = ((+row.per_day_c_allowance) * (+row.pay_day)).toFixed(2);
              
              row.g_payble_daywise = ((+row.b_salary_daywise) + (+row.h_allowance_daywise) + (+row.m_allowance_daywise) + (+row.c_allowance_daywise)).toFixed(2);
              
              // row.arrear_amount = 
              // row.phone_allowance = 
              // row.car_allowance = 
              // row.other_allowance =
              // console.log(row.arrear_amount);
              // console.log(row.phone_allowance);
              // console.log(row.car_allowance);
              // console.log(row.other_allowance);
              // console.log(row);
              console.log(row.g_payble_daywise);
              row.total_addition = ((+row.arrear_amount) + (+row.phone_allowance) + (+row.car_allowance) + (+row.other_allowance) + (+row.incentive) + (+row.addition_allownce)).toFixed(2);
              // console.log(row.total_addition);
              
              // row.p_fund = 
              row.c_p_fund = row.p_fund;
              row.t_p_fund = ((+row.p_fund) + (+row.c_p_fund)).toFixed(2);
              // row.ad_or_lone = 
              // row.uniform = 
              // row.deposit = 
              // row.tax_amount = 
              // row.mobile_amount = 
              // row.other_amount = 
              row.total_deduction = ((+row.ad_or_lone) + (+row.uniform) + (+row.deposit) + (+row.tax_amount) + (+row.mobile_amount) + (+row.other_amount)).toFixed(2);
              row.net_payable = ((+row.g_payble_daywise) + (+row.total_addition) - (+row.p_fund) - (+row.total_deduction)).toFixed(2);
            }else{
              row.b_salary_daywise = 0;
              row.h_allowance_daywise = 0;
              row.m_allowance_daywise = 0;
              row.c_allowance_daywise = 0;
              row.g_payble_daywise = 0;
              row.total_addition = 0;
              row.total_deduction = 0;
              row.net_payable = 0;
              row.t_p_fund = 0;
            }
  
            // console.log(row.pay_day);
            // console.log(row);
            // console.log(row.arrear_amount);
          },
          internalGridRemove(event, item){
              event.preventDefault();
              let index = this.form_data.payroll_employee_data.indexOf(item);
              this.form_data.payroll_employee_data.splice(index, 1);
          },
          funcao: function(event, id, emp_id){
            console.log (event.target.value);
            console.log (id);
            console.log (emp_id);
            if(event.target.value){
              $('#'+id+emp_id).attr('readonly', false);
            }else{
              $('#'+id+emp_id).attr('readonly', true);
            }
          },
          // oneClick: function(event, id, emp_id){
            // this.clicks++ 
            // if(this.clicks === 1) {
            //    $('#'+id+emp_id).attr('readonly', false);
            // } else{
            //    $('#'+id+emp_id).attr('readonly', true);
            // }   
            // this.clicks = 0;     	
          // },  
          updateCountry (form_data,shift) {
            form_data.shift =shift ;
          },
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
  
  
          monthlySelect(event){
            if(event.target.value==1){
              this.weekly_id=0;
            }else{
              this.weekly_id=1;
            }
          },
          weekSelect(event){
            this.weeks_id=event.target.value;
          },
          monthsSelectsId(event){
              this.form_data.months_id=event.target.value;
              this.months_id=event.target.value;
          }, 
          SalaryTypeId(event){
            // alert(event.target.value);
              this.form_data.salary_type_id=event.target.value;
              this.salary_type_id=event.target.value;
          }, 
          DateTypeId(event){
              this.form_data.date_type_id=event.target.value;
              this.date_type_id=event.target.value;
          }, 
          SalaryGrade(event){
              this.form_data.salary_grade=event.target.value;
              this.salary_grade=event.target.value;
          },
          addPayrollProcess(event){
            this.modal_loading= false;
            let uri = URL.baseUrl('payrollprocess/fiends');
            axios.post(uri,
              {
                id:this.sbu_id,
                section_id: this.form_data.section_value,
                subsection_id: this.form_data.sub_section_value,
                employee_group: this.form_data.employee_group,
                subunit_id: this.form_data.sub_unit_value,
                unit_id: this.form_data.unit_value,
                employee_work_location: this.form_data.work_location_value,
                employee_designation: this.form_data.employee_designation,
                department_id: this.form_data.department_name_value,
                employeeId:this.form_data.employee_name_value,
                jobgrade_name_value:this.form_data.jobgrade_name_value,
                emplyee_category_mgt_non_mgt:this.form_data.emplyee_category_mgt_non_mgt,
                roaster_id: this.weekly_id,
                week_id: this.form_data.weeks_id,
                months_id:this.months_id,
                from_date:this.from_date,
                to_date:this.to_date,
                salary_type_id:this.salary_type_id,
                salary_grade:this.salary_grade
              }).then(res => {
                console.log(res);
                this.form_data.employeeData=res.data.employeeData;
                this.company_id=res.data.company_id;
                this.form_data.payroll_employee_data=res.data.payroll_employee_data;
                this.payroll_employee_data=res.data.payroll_employee_data;
                this.form_data.employee_payroll_setting=res.data.employeeData.employee_payroll_setting;
                this.modal_loading= true;
              })
              .catch(error => {
                this.modal_loading= true;
            })
  
          },
  
    // form_data.sbu_name_value
    //             form_data.unit_value
    //             form_data.sub_unit_value
    //             form_data.department_name_value
    //             form_data.section_value
    //             form_data.sub_section_value
    //             form_data.work_location_value
    //             form_data.employee_name_value
    //             form_data.jobgrade_name_value
          // employeesSbuId(option){
          //   this.employeesSbu=option.id;
          // },
          // employeesSection(option){
          //   this.modal_loading= false;
          //   let uri = URL.baseUrl('shift_time/fiends');
          //   axios.post(uri,
          //     {
          //         types:'5',
          //         id:option.id,
          //         roaster_id:this.weekly_id,
          //         week_id:this.weeks_id,
          //         months_id:this.months_id,
          //     }).then(res => {
          //       console.log(res);
          //      this.form_data=res.data;
          //       this.modal_loading= true;
          //       console.log('hell');
          //     })
          //     .catch(error => {
          //       this.modal_loading= true;
          //   })
          // },
          // employeesSubSection(option){
          //   this.modal_loading= false;
          //   let uri = URL.baseUrl('shift_time/fiends');
          //   axios.post(uri,
          //     {
          //         types:'6',
          //         id:option.id,
          //         roaster_id:this.weekly_id,
          //         week_id:this.weeks_id,
          //         months_id:this.months_id,
          //     }).then(res => {
          //       console.log(res);
          //       this.form_data=res.data;
          //       this.modal_loading= true;
          //       console.log('hell');
          //     })
          //     .catch(error => {
          //       this.modal_loading= true;
          //   })
          // },
          // employeesGroup(option){
          //   // console.log(option);
          //   // this.form_data.employee_group= option.id;
          //   // this.permission_id=option.id;
          //   // this.permission_id_name=option.text;
          //   // console.log(this.form_data.employee_group);
          //   this.modal_loading= false;
          //   let uri = URL.baseUrl('shift_time/fiends');
          //   axios.post(uri,
          //     {
          //         types:'1',
          //         id:option.id,
          //         roaster_id:this.weekly_id,
          //         week_id:this.weeks_id,
          //         months_id:this.months_id,
          //     }).then(res => {
          //       console.log(res);
          //       this.form_data=res.data;
          //       this.modal_loading= true;
          //       console.log('hell');
          //     })
          //     .catch(error => {
          //       this.modal_loading= true;
          //   })
          // },
          // employeesSubUnit(option){
          //   // console.log(option);
          //   // this.form_data.subunit_id= option.id;
          //   // this.permission_id=option.id;
          //   // this.permission_id_name=option.text;
          //   this.modal_loading= false;
          //   let uri = URL.baseUrl('shift_time/fiends');
          //   axios.post(uri,
          //     {
          //         types:'4',
          //         id:option.id,
          //         roaster_id:this.weekly_id,
          //         week_id:this.weeks_id,
          //         months_id:this.months_id,
          //     }).then(res => {
          //       console.log(res);
          //       this.form_data=res.data;
          //       this.modal_loading= true;
          //       console.log('hell');
          //     })
          //     .catch(error => {
          //       this.modal_loading= true;
          //   })
          // },
          // employeesUnit(option){
          //   // console.log(option);
          //   // this.form_data.unit_id= option.id;
          //   // this.permission_id=option.id;
          //   // this.permission_id_name=option.text;
          //   this.modal_loading= false;
          //   let uri = URL.baseUrl('shift_time/fiends');
          //   axios.post(uri,
          //     {
          //         types:'3',
          //         id:option.id,
          //         roaster_id:this.weekly_id,
          //         week_id:this.weeks_id,
          //         months_id:this.months_id,
          //     }).then(res => {
          //       console.log(res);
          //       this.form_data=res.data;
          //       this.modal_loading= true;
          //       console.log('hell');
          //     })
          //     .catch(error => {
          //       this.modal_loading= true;
          //   })
          // },
          // employeesWorkLocation(option){
          //   // console.log(option);
          //   // this.form_data.employee_work_location= option.id;
          //   // this.permission_id=option.id;
          //   // this.permission_id_name=option.text;
          //   // console.log(this.form_data.employee_work_location);
          //   this.modal_loading= false;
          //   let uri = URL.baseUrl('shift_time/fiends');
          //   axios.post(uri,
          //     {
          //         types:'1',
          //         id:option.id,
          //         roaster_id:this.weekly_id,
          //         week_id:this.weeks_id,
          //         months_id:this.months_id,
          //     }).then(res => {
          //       console.log(res);
          //       this.form_data=res.data;
          //       this.modal_loading= true;
          //       console.log('hell');
          //     })
          //     .catch(error => {
          //       this.modal_loading= true;
          //   })
          // },
          // onSelectDepartment(option){
          //   console.log(option);
          //   // this.form_data.department_id= option.id;
          //   // this.permission_id=option.id;
          //   // this.permission_id_name=option.text;
          //   // console.log(this.form_data.employee_department);
          //   this.modal_loading= false;
          //   let uri = URL.baseUrl('shift_time/fiends');
          //   axios.post(uri,
          //     {
          //         types:'2',
          //         id:option.id,
          //         roaster_id:this.weekly_id,
          //         week_id:this.weeks_id,
          //         months_id:this.months_id,
          //     }).then(res => {
          //       console.log(res);
          //       this.form_data=res.data;
          //       this.modal_loading= true;
          //       console.log('hell');
          //     })
          //     .catch(error => {
          //       this.modal_loading= true;
          //   })
          // },
          // onSelectDesignation(option){
          //   // console.log(option);
          //   // this.form_data.employee_designation= option.id;
          //   // this.permission_id=option.id;
          //   // this.permission_id_name=option.text;
          //   // console.log(this.form_data.employee_designation);
          //   this.modal_loading= false;
          //   let uri = URL.baseUrl('shift_time/fiends');
          //   axios.post(uri,
          //     {
          //         types:'1',
          //         id:option.id,
          //         roaster_id:this.weekly_id,
          //         week_id:this.weeks_id,
          //         months_id:this.months_id,
          //     }).then(res => {
          //       console.log(res);
          //       this.form_data=res.data;
          //       this.modal_loading= true;
          //       console.log('hell');
          //     })
          //     .catch(error => {
          //       this.modal_loading= true;
          //   })
          // },
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
            this.employee_id = option.id;
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
  
  <style type="text/css">
    .employeeTable_ids.table th {
          padding: 4px 5px !important;
  }
  .div_class {
    /*width: 500px;*/
    /*overflow-x: scroll;*/
    margin-left: 193px;
    overflow-y: visible;
    padding: 0;
  }
  .headcol {
    position: absolute;
    /*width: 5em;*/
    width: 200px;
    left: 0;
    top: auto;
    border-top-width: 1px;
    /*only relevant for first row*/
    margin-top: -1px;
    /*compensate for top border*/
  }
  .headcol:before {
    content: '';
  }
  .select_id > .multiselect > .multiselect__tags{
    min-height: 41px !important;
  }

  .payroll-process{
    font-size: 12px !important;
  }

  .payroll-process table thead th{
    background: #ddd !important;
    padding: 5px !important;
    font-size: 12px !important;
  }
  .payroll-process table tbody td{
    font-size: 12px !important;
  }
  .payroll-process table td{
    padding: 0px !important;
  }


  /* Checkbox list design */

  .dbgOuter{
          border: solid 1px #ced4da;
          border-radius: 4px;
          padding: 3px 8px 0px 14px;
          width: 50%;
          margin: 0 auto;
          font-size: 12px;

        }
        .dbgCont{
            display: inline-block;
            height: 24px;
            margin-left: 6px;
        }
        /* Base for label styling */
        .dbgCheck:not(:checked),
        .dbgCheck:checked {
            position: absolute;
            left: -9999px;
        }
        .dbgCheck:not(:checked) + label,
        .dbgCheck:checked + label {
            display:inline-block;
            position: relative;
            padding-left: 25px;
            cursor: pointer;
        }

        /* checkbox aspect */
        .dbgCheck:not(:checked) + label:before,
        .dbgCheck:checked + label:before {
            content: '';
            position: absolute;
            left:0; top: 1px;
            width: 17px; height: 17px;
            border: 1px solid #aaa;
            background: #f8f8f8;
            border-radius: 3px;
            box-shadow: inset 0 1px 3px   rgba(0,0,0,.3)
        }
        /* checkmark aspect */
        .dbgCheck:not(:checked) + label:after,
        .dbgCheck:checked + label:after {
            content: '✔';
            position: absolute;
            top: 0px; left: 3px;
            font-size: 14px;
            color: #09ad7e;
            transition: all .2s;
        }
        /* checked mark aspect changes */
        .dbgCheck:not(:checked) + label:after {
            opacity: 0;
            transform: scale(0);
        }
        .dbgCheck:checked + label:after {
            opacity: 1;
            transform: scale(1);
        }
        /* disabled checkbox */
        .dbgCheck:disabled:not(:checked) + label:before,
        .dbgCheck:disabled:checked + label:before {
            box-shadow: none;
            border-color: #bbb;
            background-color: #ddd;
        }
        .dbgCheck:disabled:checked + label:after {
            color: #999;
        }
        .dbgCheck:disabled + label {
            color: #aaa;
        }
        /* accessibility */
        .dbgCheck:checked:focus + label:before,
        .dbgCheck:not(:checked):focus + label:before {
            border: 1px dotted blue;
        }

        .dbgCheck{
            display:inline-block;
            width:90px;
            height:24px;
            margin:1em;
        }





        /* Useless styles, just for demo design */

       


  /* Checkbox list design */
  
  </style>
  