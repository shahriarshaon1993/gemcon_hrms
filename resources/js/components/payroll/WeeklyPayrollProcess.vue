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
                               <h3 class="card-title d-none d-md-block">Weekly Payroll Process</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                               </span>
                           </div>
                       </div>
                    </div>
                    <div class="card-body col-md-12">
                      <div class="row col-md-12">
                          <div class="row report-box col-md-12">
                            <div class="form-group col-md-3" style="padding:0px;">
                              <label class="col-md-12 control-label">From Date <sup style="color:red; top: -2px;">*</sup></label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="form-group">
                                    <div class="col-md-12 inputGroupContainer"  style="padding:0px;">
                                       <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <datepicker placeholder="Select Date" style="width: 131% !important;" v-model="weekly_from_date"  class="form-control" ></datepicker>
                                      </div>
                                    </div>
                                 </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="padding:0px;">
                              <label class="col-md-12 control-label">To Date <sup style="color:red; top: -2px;">*</sup></label>
                                <div class="col-md-12 inputGroupContainer"  style="padding:0px;">
                                  <div class="form-group">
                                    <div class="col-md-12 inputGroupContainer">
                                       <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <datepicker placeholder="Select Date" style="width: 131% !important;" v-model="weekly_to_date"  class="form-control" ></datepicker>
                                      </div>
                                    </div>
                                 </div>
                              </div>
                            </div>

                            <!-- <div class="form-group col-md-2" style="padding:0px;">
                              <label class="col-md-12 control-label">Salary Grade <sup style="color:red; top: -2px;">*</sup></label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    
                                    <select @change="SalaryGrade($event)" class="form-control" v-model="Salary_grade" >
                                        <option id="" disabled>--Salary Grade--</option>
                                        <option v-for="payrollPerm in option_data.payrollPermissions"  :value='payrollPerm.id' v-bind:key="payrollPerm.id">{{payrollPerm.text }}
                                        </option>
                                    </select>
                                  </div>
                              </div>
                            </div>  -->

                            <div class="form-group col-md-2" style="padding:0px;">
                              <label class="col-md-12 control-label">Salary Type <sup style="color:red; top: -2px;">*</sup></label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <select @change="SalaryTypeId($event)" class="form-control" v-model="Salary_type" >
                                        <option id="" disabled>--Salary Type--</option>
                                        <option value='1' >Cash</option>
                                        <option value='2' >Bank </option>
                                        
                                    </select>
                                  </div>
                              </div>
                            </div>  
                            <div class="form-group col-md-2" style="padding:0px;">
                              <label class="col-md-12 control-label">Weekly Process Type <sup style="color:red; top: -2px;">*</sup></label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <select @change="WeeklyProcessType($event)" class="form-control" v-model="process_type" >
                                        <option id="" disabled>--Process Type--</option>
                                        <!-- <option value='4'>All</option> -->
                                        <option value='1'>Time Based</option>
                                        <option value='2'>Production Based </option>
                                        <option value='3'>Residential Based </option>
                                        <option value='4'> TR </option>
                                    </select>
                                  </div>
                              </div>
                            </div>  
                            <!-- <div class="form-group col-md-2" style="padding:0px;">
                              <label class="col-md-12"
                                ><strong>Shift</strong></label
                              >
                              <vue-select
                                v-model="form_data.OfficeTimeVelu"
                                :options="option_data.officeTime"
                                @select="onSelectOfficeTime"
                                placeholder="Select one"
                                label="text"
                                multiple="multiple"
                                track-by="text"
                              ></vue-select>
                            </div>   -->
    

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
                            <div class="form-group col-md-2" style="max-width: 11%">
                              <label class="col-md-12 control-label"
                                >SBU <sup style="color: red; top: -2px">*</sup></label
                              >
                              <div
                                class="col-md-12 inputGroupContainer"
                                style="padding: 0px"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbu" placeholder="Select one" label="text" track-by="text"></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
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
                                    v-model="unit_value"
                                    :options="option_data.unit_data"
                                    @select="employeesUnit"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
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
                                    v-model="sub_unit_value"
                                    :options="option_data.sub_unit_data"
                                    @select="employeesSubUnit"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
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
                                    v-model="department_name_value"
                                    :options="option_data.department_data"
                                    @select="onSelectDepartment"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
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
                                    v-model="section_value"
                                    :options="option_data.section_data"
                                    @select="employeesSection"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
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
                                    v-model="sub_section_value"
                                    :options="option_data.sub_section_data"
                                    @select="employeesSubSection"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
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
                                    v-model="work_location_value"
                                    :options="option_data.work_location_data"
                                    @select="employeesWorkLocation"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div
                              class="form-group col-md-2"
                              id="employee_wise_show"
                              style="max-width: 11%"
                            >
                              <label class="col-md-12 control-label">Employee</label>
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-earphone"></i
                                  ></span>
                                  <vue-select
                                    v-model="employee_name_value"
                                    :options="option_data.employee_data"
                                    @select="onSelectEmployee"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-md-1 float-right"
                              style="max-width: 6%; padding: 18px 0px"
                            >
                              <span v-if="employeesSbu">
                                <a @click="addPayrollProcess($event)" id="addCF" class="btn btn-xs " style="color: #212529 !important;padding: .3rem .25rem;background-color: #fac23c;border-color: #fac23c;"><i class="fa fa-search" style="color: #212529 !important;background-color: #fac23c;border-color: #fac23c;"></i> Submit </a>
                              </span>
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
        <section class="content" v-if="form_data.payroll_employee_data">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                       
                    </div>
                    <div class="card-body col-md-12">
                            <button id="btnExport"  @click="tableToExcel" class="btn-success float-right" style="margin-left:10px;">Export</button>
                            <button @click="printDiv()" class="btn-info float-right">Print</button>
                            <button @click="payrollEdite()" class="btn-info float-right" style="margin-left:10px;">Edite</button>
                      <div class="row col-md-12" id="printable" v-if="(form_data.payroll_employee_data).length > 0">
                           
                        <form @submit.prevent="add({add:'add/weeklypayrollprocess'})"  id="validate-1" style="overflow-x: scroll;" >
                            <input  v-if="editeOption == 1" type="submit"    style="width: 130px;margin-bottom: 9px;" tabindex="4" value="Save" class="btn btn-sm btn-info col-md-1">
                            
                          <div class="col-md-12" >
                            <!-- <div class="col-md-1">   -->
                               
                            <!-- </div>    -->
                            <div class=" " style="min-height: 56px;" v-if="modal_loading">
                              <!-- <div class=""> -->
                                <!-- style="table-layout:fixed;width: 100% !important" -->
                            <table id="tblCustomers" class="table table-bordered  table-striped employeeTable" >
                              <thead>
                                <tr style="text-align: center;">
                                  <th v-if="editeOption == 1" class='ths hid' rowspan="0" style="vertical-align: middle;width: 7%" >Action</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;width: 5%" >#</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;width: 6%;" >ID</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;width: 13%;" >Name</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;width: 7%;" >Designation</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;width: 7%;" >Department</th>
                                  <!-- <th rowspan="2" style="vertical-align: middle;width: 100px;" >Grade</th> -->
                                  <th  rowspan="0" class="report ths" style="vertical-align: middle;" >Sub Unit </th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;" > <p style="transform: rotate(270deg);">Shift</p></th>
                                  <th class='ths'  rowspan="0" style="vertical-align: middle;" >PS</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;" >PD</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;" >HD</th>
                                  <th class='ths' v-if="form_data.process_type!=2" rowspan="0" style="vertical-align: middle;" >Wages Rate</th>
                                  <th class='ths' v-if="form_data.process_type!=2" rowspan="0" style="vertical-align: middle;" >Wages</th>
                                  <th class='ths' v-if="form_data.process_type==2" rowspan="0" style="vertical-align: middle;" >Amount</th>
                                  <th class='ths' v-if="form_data.process_type!=2" rowspan="0" style="vertical-align: middle;" >OT Hour</th>
                                  <th class='ths' v-if="form_data.process_type!=2" rowspan="0" style="vertical-align: middle;" >OT Wages</th>
                                  <th class='ths' v-if="form_data.process_type==2" rowspan="0" style="vertical-align: middle;" >OT Amount</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;" >Att. Bonus</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;" >Adj. Amount</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;" >Night Alwnc.</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;" >R.A</th>
                                  <th class='ths' v-if="form_data.process_type!=2" rowspan="0" style="vertical-align: middle;" >Total Wages</th>
                                  <th class='ths' v-if="form_data.process_type==2" rowspan="0" style="vertical-align: middle;" >Total Amount</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;" title="D deduction">DAD</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;" >Other's Deduct</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;" >Cant. Ded.</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;" >Appron</th>
                                  <th class='ths' rowspan="0" style="vertical-align: middle;" >Total Deduction</th>
                                  <th class='ths' v-if="form_data.process_type!=2" rowspan="0" style="vertical-align: middle;" >Net Wages</th>
                                  <th class='ths' v-if="form_data.process_type==2" rowspan="0" style="vertical-align: middle;" >Net Amount</th>
                                </tr>
                              </thead>
                               <tbody>
                                <tr v-for="(form_data, index) in form_data.payroll_employee_data" v-bind:key="form_data.id" >
                                  <td  v-if="editeOption == 1" class="text-center hid">
                                    <button  type="button"  @click="internalGridRemove($event,form_data)" class="btn btn-danger btn-xs btn-custom-padding" title="Remove from list"><i style="margin-top: 4px" class="fa fa-times"></i></button>
                                  </td>
                                  <td class="text-center ths">{{index+1}}</td>
                                  <td class='ths'> {{form_data.employee_id_no}}</td>
                                  <td class='ths'>{{form_data.employee_fullname}}</td>
                                  <td class='ths'>{{form_data.designation_name}}</td>
                                  <td class='ths'>{{form_data.department_name}}</td>
                                  <!-- <td class="text-center">{{form_data.jobgrade_name}}</td> -->
                                  <td class='ths' style="">{{form_data.sub_unit_name}}</td>
                                  <td class="text-cente ths" style="vertical-align: middle;text-align: center">
                                    <input type="hidden" v-model="form_data.shift_name_id">
                                    <input type="hidden" v-model="form_data.present_shift_name_id">
                                    {{form_data.shift_name}}
                                  </td>
                                  
                                  <td class="text-center ths" style="vertical-align: middle;text-align: center">{{form_data.present_shift_name}}</td>
                                  <td class='ths' style="vertical-align: middle;text-align: center">
                                    {{form_data.prtot}}
                                    <!-- <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'prtot',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'prtot'+form_data.id" v-model="form_data.prtot" class="form-control" type="text" readonly> -->
                                  </td>
                                  <td class='ths' style="vertical-align: middle;text-align: center">
                                    {{form_data.holiday}}
                                    <!-- <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'holiday',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'holiday'+form_data.id" v-model="form_data.holiday" class="form-control" type="text" readonly> -->
                                  </td>
                                  <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                                    <p v-if="editeOption == 1">
                                    <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'g_salary',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'g_salary'+form_data.id" v-model="form_data.g_salary  " class="form-control" type="text" readonly>
                                    </p>
                                    <p v-if="editeOption == 0" > {{form_data.g_salary |number('0,0.00') }} </p>
                                  </td>
                                  <td  v-if="form_data.process_type != 2" class="text-right ths" style="width: 81px;vertical-align: middle;">
                                  
                                    <p v-if="editeOption == 1">
                                      <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'net_wages',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'net_wages'+form_data.id" v-model="form_data.net_wages" class="form-control" type="text" readonly>
                                    </p>
                                    <p v-if="editeOption == 0" > {{(form_data.net_wages) |number('0,0.00') }} </p>
                                  </td>
                                  <td v-if="form_data.process_type != 2" class="text-right ths" style="width: 81px;vertical-align: middle;">
                                  
                                    <p v-if="editeOption == 1">
                                    <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'ot_time',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'ot_time'+form_data.id" v-model="form_data.ot_time" class="form-control" type="text" readonly>
                                    </p>
                                    <p v-if="editeOption == 0">
                                    {{form_data.ot_time |number('0,0.00') }}
                                    </p>
                                  </td>
                                  <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                                    <p v-if="editeOption == 1">
                                    <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'ot_wages',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'ot_wages'+form_data.id" v-model="form_data.ot_wages" class="form-control" type="text" readonly>
                                    </p>
                                    <p v-if="editeOption == 0">
                                    {{form_data.ot_wages |number('0,0.00') }}
                                    </p>
                                  </td>
                                  <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                                    <p v-if="editeOption == 1">
                                    <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'attendance_bonus',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'attendance_bonus'+form_data.id" v-model="form_data.attendance_bonus" class="form-control" type="text" readonly>
                                    </p>
                                    <p v-if="editeOption == 0">
                                      {{form_data.attendance_bonus |number('0,0.00') }}
                                     </p>
                                  </td>
                                  <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                                    <p v-if="editeOption == 1">
                                    <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'arrear_amount',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'arrear_amount'+form_data.id" v-model="form_data.arrear_amount" class="form-control" type="text" readonly>
                                    </p>
                                    <p v-if="editeOption == 0">
                                    {{form_data.arrear_amount |number('0,0.00') }}
                                    </p>
                                  </td>
                                  <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                                    <p v-if="editeOption == 1">
                                      <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'night_allownce',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'night_allownce'+form_data.id" v-model="form_data.night_allownce" class="form-control" type="text" readonly>
                                    </p>
                                    <p v-if="editeOption == 0">
                                      {{form_data.night_allownce |number('0,0.00') }}
                                      </p>
                                  </td>
                                  <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                                    <p v-if="editeOption == 1">
                                      <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'residential_allowance',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'residential_allowance'+form_data.id" v-model="form_data.residential_allowance" class="form-control" type="text" readonly>
                                    </p>
                                    <p v-if="editeOption == 0">
                                      {{form_data.residential_allowance |number('0,0.00') }}
                                    </p>
                                  </td>
                                  <td v-if="form_data.process_type!=2" class="text-right ths" style="width: 81px;vertical-align: middle;">
                                  {{form_data.final_total_wages |number('0,0.00') }}
                                  <!-- <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'final_total_wages',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'final_total_wages'+form_data.id" v-model="form_data.final_total_wages" class="form-control" type="text" readonly> -->
                                  </td>
                                  <td v-if="form_data.process_type==2" class="text-right ths" style="width: 81px;vertical-align: middle;">
                                  {{form_data.final_total_wages |number('0,0.00') }}
                                  <!-- <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'final_total_wages',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'final_total_wages'+form_data.id" v-model="form_data.final_total_wages" class="form-control" type="text" readonly> -->
                                  </td>
                                  <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                                    {{form_data.dad_deduction |number('0,0.00') }}
                                  <!-- <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'dad',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'dad'+form_data.id" v-model="form_data.dad" class="form-control" type="text" readonly> -->
                                  </td>
                                  <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                                    <p v-if="editeOption == 1">
                                     <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'other_amount',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'other_amount'+form_data.id" v-model="form_data.other_amount" class="form-control" type="text" readonly>
                                    </p>
                                    <p v-if="editeOption == 0">
                                     {{form_data.other_amount |number('0,0.00') }}
                                     </p>
                                  </td>
                                  <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                                    <p v-if="editeOption == 1">
                                      <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'canteen_amount',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'canteen_amount'+form_data.id" v-model="form_data.canteen_amount" class="form-control" type="text" readonly>
                                    </p>
                                    <p v-if="editeOption == 0">
                                      {{form_data.canteen_amount |number('0,0.00') }}
                                    </p>
                                </td>
                                  <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                                    <p v-if="editeOption == 1">
                                      <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'uniform',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'uniform'+form_data.id" v-model="form_data.uniform" class="form-control" type="text" readonly>
                                    </p>
                                    <p v-if="editeOption == 0">
                                      {{form_data.uniform |number('0,0.00') }}
                                    </p>
                                  </td>
                                  <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                                  {{form_data.total_deduction |number('0,0.00') }}
                                  <!-- <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'total_deduction',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'total_deduction'+form_data.id" v-model="form_data.total_deduction" class="form-control" type="text" readonly> -->
                                  </td>
                                  <td v-if="form_data.process_type!=2" class="text-right ths" style="width: 81px;vertical-align: middle;">
                                  {{form_data.final_net_wages |number('0,0.00') }}
                                  <!-- <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'final_net_wages',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'final_net_wages'+form_data.id" v-model="form_data.final_net_wages" class="form-control" type="text" readonly> -->
                                  </td>
                                  <td v-if="form_data.process_type==2" class="text-right ths" style="width: 81px;vertical-align: middle;">
                                  {{form_data.final_net_wages |number('0,0.00') }}
                                  <!-- <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'final_net_wages',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'final_net_wages'+form_data.id" v-model="form_data.final_net_wages" class="form-control" type="text" readonly> -->
                                  </td>
                                  <!-- <td class="text-right ths"></td> -->
                                </tr>
                              </tbody>
                            </table>
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
    import $ from 'jquery';
    import VueTimepicker from 'vue2-timepicker';
    import 'vue2-timepicker/dist/VueTimepicker.css';   

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
           employee_id:'',
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
           Salary_grade:'',
           salary_grade:'',
           Salary_type:'',
           editeOption:0,
           process_type:'',
           week_id:'',
           roaster_type:'',
           permission_id:'',
           formDataAll:'',
           weekly_id:0,
           weeks_id:0,
           weekly_data:'',
           months_id:0,
           weekly_from_date:'',
           weekly_to_date:'',
           permission_id_name:'',
           employees_list:[],
           counter  : 0,
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
   
         printDiv1() {
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
      $(".text-center").each(function () {
        this.style.setProperty("text-align", "center", "important");
      });
      $(".text-right").each(function () {
        this.style.setProperty("text-align", "right", "important");
      });
      
      $(".hid").each(function () {
        this.style.setProperty("border", "1px solid #000", "important");
        this.style.setProperty("padding", "2px .75rem", "important");
        this.style.setProperty("border-collapse", "collapse", "important");
      });
      $(".table-bordered").each(function () {
        this.style.setProperty("border", "1px solid #000", "important");
        this.style.setProperty("padding", "2px .75rem", "important");
        this.style.setProperty("border-collapse", "collapse", "important");
      });
      $(".ths").each(function () {
        this.style.setProperty("border", "1px solid rgb(0 0 0 / 87%)", "important");
        this.style.setProperty("padding", "2px 2px", "important");
        this.style.setProperty("border-collapse", "collapse", "important");
        this.style.setProperty("vertical-align", "middle");
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
    payrollEdite(){
      if(this.editeOption == 0){
        this.editeOption = 1;
      }else{
        this.editeOption = 0;
      }
       
    },

        TotalAmount(event,row,index, process_type=false){
          console.log(process_type);
          // this.form_data.net_wages=this.total_wages;
          // row.ot_wages = 
          if(process_type != 2){
            row.ot_wages = (row.g_salary / 8) * row.ot_time;
          }
          row.net_wages=(((+ row.g_salary) * (+row.prtot)) || 0).toFixed(2);
          row.final_total_wages=(((+ row.net_wages) + (+row.ot_wages)+ (+row.attendance_bonus)+ (+row.arrear_amount)+ (+row.night_allownce)+ (+row.residential_allowance)) || 0).toFixed(2);
          row.total_deduction=(((+row.other_amount)+ (+row.canteen_amount)+ (+row.uniform)) || 0).toFixed(2);
          
          row.final_net_wages=(((+ row.final_total_wages) - (+row.total_deduction)) || 0).toFixed(2);
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
            this.months_id=event.target.value;
        }, 
        SalaryTypeId(event){
            this.salary_type_id=event.target.value;
        }, 

        SalaryGrade(event){
            this.salary_grade=event.target.value;
        },
        WeeklyProcessType(event){
            this.process_type=event.target.value;
        },
        addPayrollProcess(event){
          this.modal_loading= false;
          let uri = URL.baseUrl('weeklypayrollprocess/fiends');
          axios.post(uri,
            {
              id: this.sbu_id,
              section_id: this.section_id,
              subsection_id: this.subsection_id,
              employee_group: this.employee_group,
              subunit_id: this.subunit_id,
              unit_id: this.unit_id,
              employee_work_location: this.employee_work_location,
              employee_designation: this.employee_designation,
              department_id: this.department_id,
              roaster_id: this.weekly_id,
              week_id: this.weeks_id,
              // months_id: this.months_id,
              weekly_from_date: this.weekly_from_date,
              weekly_to_date: this.weekly_to_date,
              employeeId:this.employee_id,
              months_id:this.months_id,
              salary_type_id:this.salary_type_id,
              salary_grade:this.salary_grade,
              process_type:this.process_type,
              // OfficeTime:this.form_data.OfficeTime,
            }).then(res => {
              console.log(res);
              this.form_data=res.data;
              this.modal_loading= true;
            })
            .catch(error => {
              this.modal_loading= true;
          })

        },

      
        onSelectJobGrade(option){
          console.log(option);
          this.form_data.employee_job_grade= option.id;
          this.permission_id=option.id;
          this.permission_id_name=option.text;
          console.log(this.form_data.employee_job_grade);
        },
        onSelectEmployee(option){
          console.log(this.employee_id);
          this.form_data.employee_id = option.id;
          this.employee_id = option.id;
          this.permission_id=option.id;
          this.permission_id_name=option.text;
        },  
      onSelectOfficeTime(option) {
        this.form_data.OfficeTime = option;
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
.report p {
  /* Abs positioning makes it not take up vert space */
  position: absolute;
  top: 0;
  left: 0;
  /* Rotate from top left corner (not default) */
  transform-origin: 0 0;
  transform: rotate(90deg);
}
.ths{
  vertical-align: middle !important;
}

</style>
