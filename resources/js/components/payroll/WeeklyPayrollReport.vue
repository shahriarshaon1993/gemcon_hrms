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
                      <div
                        class="col-12 col-sm-6 col-md-12"
                        style="padding: 5px 10px"
                      >
                        <h3 class="card-title d-none d-md-block"> Payroll Report</h3>
                        <span class="float-sm-right" style="float: right">
                          <a
                            @click="$router.go(-1)"
                            class="btn btn-default"
                            href="#"
                            ><i class="fa fa-arrow-left"></i> Back</a
                          >
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="card-body row" style="padding-top: 0px">
                    <div class="col-md-12">
                      <div class="row report-box">
                        <div
                          class="form-group col-md-2"
                          style="padding: 0px; max-width: 12%"
                        >
                          <label class="col-md-12 control-label"
                            >Company/SBU <sup style="color:red; top: -2px;">*</sup></label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <vue-select
                                v-model="form_data.sbu_name_value"
                                multiple="multiple"
                                :options="option_data.company_sbu_data"
                                @select="employeesSbu"
                                placeholder="Select one"
                                label="text"
                                track-by="text"
                              ></vue-select>
                            </div>
                          </div>
                        </div>
                        
                        <div class="form-group col-md-2" style="max-width: 12%">
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
                        <div class="form-group col-md-2" style="max-width: 12%">
                          <label class="col-md-12 control-label"
                            >Sub Unit</label
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

                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px; max-width: 12%"
                        >
                          <label class="col-md-12 control-label"
                            >Department</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <vue-select
                                v-model="form_data.department_name_value"
                                :options="form_data.department_data"
                                @select="onSelectDepartment"
                                placeholder="Select one"
                                multiple="multiple"
                                label="text"
                                track-by="text"
                              >
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px; max-width: 12%"
                        >
                          <label class="col-md-12 control-label">Section</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <vue-select
                                v-model="form_data.section_value"
                                :options="form_data.section_data"
                                @select="employeesSection"
                                placeholder="Select one"
                                multiple="multiple"
                                label="text"
                                track-by="text"
                              >
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px; max-width: 12%"
                        >
                          <label class="col-md-12 control-label"
                            >Sub Section</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <vue-select
                                v-model="form_data.sub_section_value"
                                :options="form_data.sub_section_data"
                                @select="employeesSubSection"
                                placeholder="Select one"
                                multiple="multiple"
                                label="text"
                                track-by="text"
                              >
                              </vue-select>
                            </div>
                          </div>
                        </div>

                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px; max-width: 12%"
                        >
                          <label class="col-md-12 control-label"
                            >Work Location</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <vue-select
                                v-model="form_data.work_location_value"
                                :options="form_data.work_location_data"
                                @select="employeesWorkLocation"
                                placeholder="Select one"
                                multiple="multiple"
                                label="text"
                                track-by="text"
                              >
                              </vue-select>
                            </div>
                          </div>
                        </div>

                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px; max-width: 12%"
                        >
                          <label class="col-md-12 control-label"
                            >Designation</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <vue-select
                                v-model="form_data.designation_name_value"
                                :options="option_data.designation_data"
                                @select="onSelectDesignation"
                                placeholder="Select one"
                                multiple="multiple"
                                label="text"
                                track-by="text"
                              >
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-2">
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
                        </div>

                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label"
                            >Employees</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-earphone"></i
                              ></span>
                              <vue-select
                                v-model="form_data.employee_name_value"
                                :options="form_data.employee_data"
                                @select="onSelectEmployee"
                                placeholder="Select one"
                                label="text"
                                multiple="multiple"
                                track-by="text"
                              ></vue-select>
                            </div>
                          </div>
                        </div>
                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label">From</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <datepicker
                                placeholder="Select Date"
                                v-model="form_data.from_date"
                                class="form-control"
                              ></datepicker>
                            </div>
                          </div>
                        </div>
                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label">To</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <datepicker
                                placeholder="Select Date"
                                v-model="form_data.to_date"
                                class="form-control"
                              ></datepicker>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-1" style="padding:0px;">
                          <label class="col-md-12 control-label">Payroll Month <sup style="color:red; top: -2px;">*</sup></label>
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                <select @change="WeeklyProcessType($event)" class="form-control" v-model="payroll_month" >
                                    <option id="">--Month--</option>
                                    <option value='January'>January</option>
                                    <option value='February'>February </option>
                                    <option value='March'>March </option>
                                    <option value='April'>April</option>
                                    <option value='May'>May</option>
                                    <option value='June'>June</option>
                                    <option value='July'>July</option>
                                    <option value='August'>August</option>
                                    <option value='September'>September</option>
                                    <option value='October'>October</option>
                                    <option value='November'>November</option>
                                    <option value='December'>December</option>
                                </select>
                              </div>
                          </div>
                        </div>  
                        <div class="form-group col-md-1" style="padding:0px;">
                          <label class="col-md-12 control-label">Year <sup style="color:red; top: -2px;">*</sup></label>
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                <!-- {{form_data.year_lists}} -->
                                <select @change="payrollProcessYear($event)" class="form-control" v-model="this.payroll_year" >
                                    <option id="" disabled>--Year--</option>
                                    <option v-for="(year, index) in form_data.year_lists" >{{year}}</option>
                                   
                                </select>

                                 <!-- {{ alldata.employee_data_salary_list }} -->
                              </div>
                          </div>
                        </div>
                        <div
                          class="form-group col-md-2 float-left"
                          style="max-width: 13% !important;"
                        >
                          <label class="col-md-12 control-label">Report Type <sup style="color:red; top: -2px;">*</sup></label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                               <select v-model="form_data.report_type" class="form-control" @change="clickReportView($event)">
                                  <option value="0">--Select--</option>
                                  <option value="10">Cash Salary</option>
                                  <option value="20">Bank Salary</option>
                                  <option value="30">Details Salary</option>
                                  <option value="11">Pay Slip</option>
                                  <option value="12">OT Report</option>
                                  <option value="1133">Salary List</option>
                               </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="col-md-11 float-left" v-if="this.report_column == 1 && alldata.employee_data_ds" style="padding: 0px; margin-left: -1%; margin-top: 8px;">
                          <div class="dbgOuter" style="text-align: center;">
                            <div class="dbgCont" style="padding-right: 5%;">
                                <input type="checkbox" id="id100" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 100)"/>
                                <label for="id100">Select/Unselect All</label>
                            </div>
                          </div>  
                          <div class="dbgOuter">
                            <div class="dbgCont">
                                <input type="checkbox" id="id1" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 1)"/>
                                <label for="id1">SBU</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id2" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 2)"/>
                                <label for="id2">Grade</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id02" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 12)"/>
                                <label for="id02">Off Days Worked(Friday)</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id12" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 13)"/>
                                <label for="id12">Bank</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id13" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 14)"/>
                                <label for="id13">Cash</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id14" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 15)"/>
                                <label for="id14">PF (Cash)	</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id15" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 16)"/>
                                <label for="id15">Total Cash	</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id16" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 17)"/>
                                <label for="id16">Basic Salary	</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id17" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 18)"/>
                                <label for="id17">House Rent	</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id18" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 19)"/>
                                <label for="id18">Med. Allow	</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id19" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 20)"/>
                                <label for="id19">Conv. Allow</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id20" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 21)"/>
                                <label for="id20">Day off allow.</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id21" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 22)"/>
                                <label for="id21">Bank Payable	</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id22" class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 23)"/>
                                <label for="id22">Cash Payable</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id3" class="dbgCheck" checked="checked" @click="clickDetaislSalaryCheckBox($event, 3)"/>
                                <label for="id3">Add. Mobile</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id4"  class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 4)"/>
                                <label for="id4">Car</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id5"  class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 5)"/>
                                <label for="id5">Incentive</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id6"  class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 6)"/>
                                <label for="id6">Allownce</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id7"  class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 7)"/>
                                <label for="id7">Add. Other</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id8"  class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 8)"/>
                                <label for="id8">Uniform</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id9"  class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 9)"/>
                                <label for="id9">Deposit</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id10"  class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 10)"/>
                                <label for="id10">Ded. Mobile</label>
                            </div>
                            <div class="dbgCont">
                                <input type="checkbox" id="id11"  class="dbgCheck"  checked="checked" @click="clickDetaislSalaryCheckBox($event, 11)"/>
                                <label for="id11">Ded. Other</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-1 float-right">
                          <button v-if="this.search_button==10" style="border-radius: 5px;margin-right: -15px;padding: 5px 30px;" @click="viewReportss11111('cash_salary_report')" type="button" class="btn btn-info float-right">Search</button>
                          <button v-if="this.search_button==20" style="border-radius: 5px;margin-right: -15px;padding: 5px 30px;" @click="viewReportss11111('bank_salary_report')" type="button" class="btn btn-info float-right">Search </button>
                          <button v-if="this.search_button==30" style="border-radius: 5px;margin-right: -15px;padding: 5px 30px;" @click="viewReportss11111('details_salary_report')" type="button" class="btn btn-info float-right">Search</button>
                          <button v-if="this.search_button==11" style="border-radius: 5px;margin-right: -15px;padding: 5px 30px;" @click="viewReportss11111('pay_slip_report')" type="button" class="btn btn-info float-right">Search</button>
                          <button v-if="this.search_button==12" style="border-radius: 5px;margin-right: -15px;padding: 5px 30px;" @click="viewReportss11111('ot_report')" type="button" class="btn btn-info float-right">Search</button>
                           <button v-if="this.search_button==1133" style="border-radius: 5px;margin-right: -15px;padding: 5px 30px;" @click="viewReportss11111('salary_list_report')" type="button" class="btn btn-info float-right">Search</button>
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
        <div class="loader"></div>
        <section  class="content local_excel_print">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="col-12">
                    <button
                      id="btnExport"
                      @click="tableToExcel"
                      class="btn-success float-right"
                      style="margin-left: 10px"
                    >
                      Export
                    </button>
                    <button @click="printDiv()" class="btn-info float-right">
                      Print
                    </button>
                  </div>
                  <div id="printable">
                    
                    <!-- pay slip report start -->
                    <div class="col-md-12 payroll-process" v-if="search_button == 11 && !!pay_slip_details" >
                      <span >
                          <table width="70%" style="margin-left: 15%;">
                              <tr>
                                  <td colspan="3" style="width: 20%;text-align: right;">
                                      <div class="row">
                                          <div class="col-md-12 text-right">
                                              <p><i>Printing Date: {{alldata.print_date}}</i></p>
                                          </div>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td style="width: 20%">
                                      <div class="col-md-12">
                                          <img :src="`company_logo/${alldata.sbu_logo}`" class="card-img-top  rounded" style="margin-top: 2px; width: 100px;  border-radius: 50px;" alt="Company Logo">
                                      </div>
                                  </td>
                                  <td style="width: 60%; text-align: center;">
                                      <div class="col-md-12 text-center">
                                          <h4>Pay Slip</h4>
                                          <h5>Month of {{alldata.salary_date}}</h5>
                                      </div>
                                  </td>
                                  <td style="width: 20%">
                                  </td>
                              </tr>
                              <tr>
                                  <td colspan="3" style="text-align: right;">
                                      <div class="col-md-12 text-right">
                                          <p> ( Office Copy ) </p>
                                      </div>
                                  </td>
                              </tr>
                              
                              <tr>
                                  <td colspan="3">
                                      <table width="100%">
                                          <tr>
                                              <td width="50%">
                                                  <div class="col-md-12 text-left">
                                                      <h6>{{pay_slip_details.employee_fullname}}</h6>
                                                      {{pay_slip_details.designation_name}}
                                                  </div>
                                              </td>
                                              <td width="50%" style="text-align: right;">
                                                  <div class="col-md-12 text-right">
                                                      Employee ID : {{pay_slip_details.employee_id_no}} <br>
                                                      Location : {{pay_slip_details.work_location_name}}
                                                  </div>
                                              </td>
                                          </tr>
                                      </table>
                                  </td>
                              </tr>
                              <tr  v-if="alldata.salary_type_bank === 2" class="trs" style="border-top: 1px solid #6c757d;border-bottom: 1px solid #6c757d;background: #eee;font-size: 15px;font-weight: 600;">
                                  <td class="trs" colspan="2" style="padding: 0px 5px;"> Gross Salary - Bank </td>
                                  <td class="trs" style="text-align: right;padding: 0px 5px;"> {{paySlipDetails.gross_salary ?? 0 |number('0,0.00') }}</td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2">
                                  <td colspan="2" style="padding: 0px 5px;">Arrears/Addition</td>
                                  <td style="text-align: right;padding: 0px 5px;" > {{paySlipDetails.total_additions ?? 0 |number('0,0.00')}}  </td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2" >
                                  <td colspan="2" style="padding: 0px 5px;">Employee PF </td>
                                  <td style="text-align: right;padding: 0px 5px;" >( {{paySlipDetails.deduction_pfbasic ?? 0 |number('0,0.00')}} )</td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2" >
                                  <td colspan="2" style="padding: 0px 5px;">With Holding TAX</td>
                                  <td style="text-align: right;padding: 0px 5px;" >( {{paySlipDetails.deduction_tax ?? 0 |number('0,0.00')}} )
                                  </td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2" >
                                  <td colspan="2" style="padding: 0px 5px;">Deduction</td>
                                  <td style="text-align: right;padding: 0px 5px;" >( {{paySlipDetails.total_deduction ?? 0 |number('0,0.00')}} ) </td>
                              </tr>
                              <tr  v-if="alldata.salary_type_bank === 2" class="trs" style="border-top: 1px solid #6c757d;border-bottom: 1px solid #6c757d;background: #eee;font-size: 15px;font-weight: 600;">
                                  <td class="trs" style="padding: 0px 5px;" colspan="2">Net Payable(Bank)</td>
                                  <td class="trs" style="text-align: right;padding: 0px 5px;" > {{paySlipDetails.netpay ?? 0 |number('0,0.00') }}
                                  </td>
                              </tr>
                                  <tr v-if="alldata.salary_type_bank === 2"  style="line-height: 8px;">
                                  <td colspan="3"> &nbsp; </td>
                              </tr>
                              <tr  v-if="alldata.salary_type_bank === 2" class="trs" style="border-top: 1px solid #6c757d;border-bottom: 1px solid #6c757d;background: #eee;font-size: 15px;font-weight: 600;">
                                  <td  class="trs" colspan="2" style="padding: 0px 5px;"> Opening Balance PF </td>
                                  <td class="trs" style="text-align: right;padding: 0px 5px;"> {{(alldata.openigPf+alldata.openigPf) ?? 0 |number('0,0.00') }} </td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2" >
                                  <td colspan="2" style="padding: 0px 5px;">Employee PF </td>
                                  <td style="text-align: right;padding: 0px 5px;" >
                                      {{(alldata.Pf) ?? 0 |number('0,0.00') }} 
                                  </td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2" >
                                  <td colspan="2" style="padding: 0px 5px;">PF(Company's Contribution) </td>
                                  <td style="text-align: right;padding: 0px 5px;" >{{(alldata.Pf) ?? 0 |number('0,0.00') }} </td>
                              </tr>
                              
                              <tr  v-if="alldata.salary_type_bank === 2" class="trs" style="border-top: 1px solid #6c757d;border-bottom: 1px solid #6c757d;background: #eee;font-size: 15px;font-weight: 600;">
                                  <td class="trs" style="padding: 0px 5px;" colspan="2">Closing Balance PF</td> 
                                  <td class="trs" style="text-align: right;padding: 0px 5px;" > {{(alldata.clPf+alldata.clPf) ?? 0 |number('0,0.00') }}</td>
                              </tr>
                                  <tr style="line-height: 8px;">
                                  <td colspan="3"> &nbsp; </td>
                              </tr>
                              <tr v-if="alldata.salary_type_cash === 1" class="trs" style="border-top: 1px solid #6c757d;border-bottom: 1px solid #6c757d;background: #eee;font-size: 15px;font-weight: 600;">
                                  <td  class="trs" colspan="2" style="padding: 0px 5px;"> Gross Salary – Cash </td>
                                  <td class="trs" style="text-align: right;padding: 0px 5px;"> {{paySlipCash.gross_salary ?? 0 |number('0,0.00') }}</td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2">
                                  <td colspan="2" style="padding: 0px 5px;">Arrears/Addition</td>
                                  <td style="text-align: right;padding: 0px 5px;" > {{paySlipCash.total_additions ?? 0 |number('0,0.00')}}  </td>
                              </tr>
                              <tr v-if="alldata.salary_type_cash === 1">
                                  <td colspan="2" style="padding: 0px 5px;">PF(Company's Contribution)   </td>
                                  <td style="text-align: right;padding: 0px 5px;" >{{paySlipCash.deduction_pfbasic ?? 0 |number('0,0.00')}} </td>
                              </tr>
                              <tr v-if="alldata.salary_type_cash === 1">
                                  <td colspan="2" style="padding: 0px 5px;">Car Allowance</td>
                                  <td style="text-align: right;padding: 0px 5px;" >{{paySlipCash.car_allowance ?? 0 |number('0,0.00') }}</td>
                              </tr>
                              
                              <tr v-if="alldata.salary_type_cash === 1" class="trs" style="border-top: 1px solid #6c757d;border-bottom: 1px solid #6c757d;background: #eee;font-size: 15px;font-weight: 600;">
                                  <td class="trs"  style="padding: 0px 5px;" colspan="2">Net Payable(Cash)</td>
                                  <td class="trs"  style="text-align: right;padding: 0px 5px;" > {{paySlipCash.netpay ?? 0 |number('0,0.00') }}</td>
                              </tr>
                                  <tr style="line-height: 8px;">
                                  <td colspan="3"> &nbsp; </td>
                              </tr>
                          </table>
                          <p style="border-bottom: 1px dashed rgb(0, 0, 0);"></p>
                          <table width="70%" style="margin-left: 15%;">
                              <tr>
                                  <td colspan="3" style="width: 20%;text-align: right;">
                                      <div class="row">
                                          <div class="col-md-12 text-right">
                                              <p><i>Printing Date: {{alldata.print_date}}</i></p>
                                          </div>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td style="width: 20%">
                                      <div class="col-md-12">
                                          <img :src="`company_logo/${alldata.sbu_logo}`" class="card-img-top  rounded" style="margin-top: 2px; width: 100px;  border-radius: 50px;" alt="Company Logo">
                                      </div>
                                  </td>
                                  <td style="width: 60%; text-align: center;">
                                      <div class="col-md-12 text-center">
                                          <h4>Pay Slip</h4>
                                          <h5>Month of {{alldata.salary_date}}</h5>
                                      </div>
                                  </td>
                                  <td style="width: 20%">
                                  </td>
                              </tr>
                              <tr>
                                  <td colspan="3" style="text-align: right;">
                                      <div class="col-md-12 text-right">
                                          <p> ( Employee Copy ) </p>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td colspan="3">
                                      <table width="100%">
                                          <tr>
                                              <td width="50%">
                                                  <div class="col-md-12 text-left">
                                                      <h6>{{pay_slip_details.employee_fullname}}</h6>
                                                      {{pay_slip_details.designation_name}}
                                                  </div>
                                              </td>
                                              <td width="50%" style="text-align: right;">
                                                  <div class="col-md-12 text-right">
                                                      Employee ID : {{pay_slip_details.employee_id_no}} <br>
                                                      Location : {{pay_slip_details.work_location_name}}
                                                  </div>
                                              </td>
                                          </tr>
                                      </table>
                                  </td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2" class="trs" style="border-top: 1px solid #6c757d;border-bottom: 1px solid #6c757d;background: #eee;font-size: 15px;font-weight: 600;">
                                  <td class="trs" colspan="2" style="padding: 0px 5px;"> Gross Salary - Bank </td>
                                  <td class="trs" style="text-align: right;padding: 0px 5px;"> {{paySlipDetails.gross_salary ?? 0 |number('0,0.00') }}</td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2">
                                  <td colspan="2" style="padding: 0px 5px;">Arrears/Addition</td>
                                  <td style="text-align: right;padding: 0px 5px;" > {{paySlipDetails.total_additions ?? 0 |number('0,0.00')}}  </td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2">
                                  <td colspan="2" style="padding: 0px 5px;">Employee PF </td>
                                  <td style="text-align: right;padding: 0px 5px;" >( {{paySlipDetails.deduction_pfbasic ?? 0 |number('0,0.00')}} )</td>
                              </tr>
                              <tr  v-if="alldata.salary_type_bank === 2">
                                  <td colspan="2" style="padding: 0px 5px;">With Holding TAX</td>
                                  <td style="text-align: right;padding: 0px 5px;" >( {{paySlipDetails.deduction_tax ?? 0 |number('0,0.00')}} )
                                  </td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2" >
                                  <td colspan="2" style="padding: 0px 5px;">Deduction</td>
                                  <td style="text-align: right;padding: 0px 5px;" >( {{paySlipDetails.total_deduction ?? 0 |number('0,0.00')}} ) </td>
                              </tr>
                              <tr  v-if="alldata.salary_type_bank === 2" class="trs" style="border-top: 1px solid #6c757d;border-bottom: 1px solid #6c757d;background: #eee;font-size: 15px;font-weight: 600;">
                                  <td class="trs" style="padding: 0px 5px;" colspan="2">Net Payable(Bank)</td>
                                  <td class="trs" style="text-align: right;padding: 0px 5px;" > {{paySlipDetails.netpay ?? 0 |number('0,0.00') }}
                                  </td>
                              </tr>
                                  <tr v-if="alldata.salary_type_bank === 2" style="line-height: 8px;">
                                  <td colspan="3"> &nbsp; </td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2" class="trs" style="border-top: 1px solid #6c757d;border-bottom: 1px solid #6c757d;background: #eee;font-size: 15px;font-weight: 600;">
                                  <td  class="trs" colspan="2" style="padding: 0px 5px;"> Opening Balance PF </td>
                                  <td class="trs" style="text-align: right;padding: 0px 5px;"> {{(alldata.openigPf+alldata.openigPf) ?? 0 |number('0,0.00') }} </td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2">
                                  <td colspan="2" style="padding: 0px 5px;">Employee PF </td>
                                  <td style="text-align: right;padding: 0px 5px;" >
                                      {{alldata.Pf ?? 0 |number('0,0.00') }} 
                                  </td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2">
                                  <td colspan="2" style="padding: 0px 5px;">PF(Company's Contribution)</td>
                                  <td style="text-align: right;padding: 0px 5px;" >{{alldata.Pf ?? 0 |number('0,0.00') }} </td>
                              </tr>
                              
                              <tr v-if="alldata.salary_type_bank === 2" class="trs" style="border-top: 1px solid #6c757d;border-bottom: 1px solid #6c757d;background: #eee;font-size: 15px;font-weight: 600;">
                                  <td class="trs" style="padding: 0px 5px;" colspan="2">Closing Balance PF</td> 
                                  <td class="trs" style="text-align: right;padding: 0px 5px;" > {{(alldata.clPf+alldata.clPf) ?? 0 |number('0,0.00') }}</td>
                              </tr>
                                  <tr style="line-height: 8px;">
                                  <td colspan="3"> &nbsp; </td>
                              </tr>
                              <tr v-if="salary_type_cash === 1" class="trs" style="border-top: 1px solid #6c757d;border-bottom: 1px solid #6c757d;background: #eee;font-size: 15px;font-weight: 600;">
                                  <td  class="trs" colspan="2" style="padding: 0px 5px;"> Gross Salary – Cash </td>
                                  <td  class="trs" style="text-align: right;padding: 0px 5px;"> {{paySlipCash.gross_salary ?? 0 |number('0,0.00') }}</td>
                              </tr>
                              <tr v-if="alldata.salary_type_bank === 2">
                                  <td colspan="2" style="padding: 0px 5px;">Arrears/Addition</td>
                                  <td style="text-align: right;padding: 0px 5px;" > {{paySlipCash.total_additions ?? 0 |number('0,0.00')}}  </td>
                              </tr>
                              <tr v-if="salary_type_cash === 1">
                                  <td colspan="2" style="padding: 0px 5px;">PF(Company's Contribution) </td>
                                  <td style="text-align: right;padding: 0px 5px;" >{{paySlipCash.deduction_pfbasic ?? 0 |number('0,0.00')}}</td>
                              </tr>
                              <tr v-if="salary_type_cash === 1">
                                  <td colspan="2" style="padding: 0px 5px;">Car Allowance</td>
                                  <td style="text-align: right;padding: 0px 5px;" >{{paySlipCash.car_allowance ?? 0 |number('0,0.00') }}</td>
                              </tr>
                              
                              <tr v-if="salary_type_cash === 1" class="trs" style="border-top: 1px solid #6c757d;border-bottom: 1px solid #6c757d;background: #eee;font-size: 15px;font-weight: 600;">
                                  <td class="trs"  style="padding: 0px 5px;" colspan="2">Net Payable(Cash)</td>
                                  <td class="trs"  style="text-align: right;padding: 0px 5px;" > {{paySlipCash.netpay ?? 0 |number('0,0.00') }}</td>
                              </tr>
                                  <tr style="line-height: 8px;">
                                  <td colspan="3"> &nbsp; </td>
                              </tr>
                              

                              <tr>
                                  <td colspan="3">
                                      <hr style="margin-top: 1rem;margin-bottom: 0rem;border-top: 1.6px solid rgb(52 58 65);">
                                      <div class="row text-center">
                                          <p class="text-center"> <i>This is computer generated pay slip & does not required any signature.</i></p>
                                      </div>
                                  </td>
                              </tr>
                          </table>
                      </span>
                  </div>
                    <!-- pay slip report end -->
                    <table style="width: 100%" v-if="this.search_button != 11">
                      <tbody>
                        <tr>
                          <td style="width: 20%">
                            <div class="row" style="margin-left: 21px">
                              <div
                                class="col-md-12"
                                style="padding: 0px; margin-top: 17px"
                              >
                                <!-- <img
                                  :src="`asset/1-1.jpg`"
                                  style="width: 25%"
                                /> -->
                              </div>
                            </div>
                          </td>
                          <td style="width: 55%">
                            <div class="col-lg-12 text-center">
                              <h5 style=" margin-top: -5px;">{{alldata.company_info}}</h5>
                              <h6 style=" margin-top: -6px;" v-if = "alldata.salary_list != 1">
                                For the Month of {{ alldata.month_name}} <span style=" font-size: 12px;">({{ alldata.report_date }})</span></h6>
                                <h6 style=" margin-top: -6px;" v-else>
                                {{ alldata.report_name }}</h6>
                            </div>
                          </td>
                          <td style="width: 25%">
                            <div
                              class="col-md-12"
                              style="padding: 0px; margin-top: 17px"
                            >
                              <p>
                                <strong>Print Date :</strong>
                                {{ alldata.print_date || ''}}
                              </p>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <!-- table cash salary start here -->
                    <div class="col-md-12 payroll-process" v-if="search_button == 10">
                        <div class=" " style="min-height: 56px;" v-if="modal_loading">
                        <table id='tblCustomers' class="table table-bordered  table-striped employeeTable" style="table-layout:fixed;width: 100% !important">
                          <thead>
                            <tr style="text-align: center;">
                              <th class="ths" style="vertical-align: middle;width: 50px;" >Sl.</th>
                              <th class="ths" style="vertical-align: middle;width: 120px;" >Employee ID</th>
                              <th class="ths" style="vertical-align: middle;width: 200px;" >Employee Name</th>
                              <th class="ths" style="vertical-align: middle;width: 200px;" >Designation</th>
                              <th class="ths" style="vertical-align: middle;width: 200px;" >Department</th>
                              <th class="ths" style="vertical-align: middle;width: 200px;" >Work Location</th>
                              <th class="ths" style="vertical-align: middle;width: 100px;" >A/C No</th>
                              <th class="ths" style="vertical-align: middle;width: 120px;" >Net Payable</th>
                            </tr>
                          </thead>
                            <tbody>
                            <tr v-for="(form_data, index) in alldata.employee_data_cash" v-bind:key="form_data.id" >
                              
                              <td class="ths" style="text-align: center" >{{index+1}}</td>
                              <td class="ths" style="text-align: center" > {{form_data.employee_id_no}}</td>
                              <td class="ths">{{form_data.employee_fullname}}</td>
                              <td class="ths">{{form_data.designation_name}}</td>
                              <td class="ths">{{form_data.department_name}}</td>
                              <td class="ths" >{{form_data.work_location_name}}</td>
                              <td class="ths" >{{form_data.ebc_account_number}}</td>
                              <td class="ths"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.netpay) |number('0,0.00') }}
                              </td>
                            </tr>

                            <tr>
                              <td class="ths" colspan="7" style="text-align: right;font-weight: bold">Total</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_netpay | number('0,0.00') }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <!-- table bank salary start here -->
                    <div class="col-md-12 payroll-process" v-if="search_button == 20">
                        <div class=" " style="min-height: 56px;" v-if="modal_loading">
                        <table id='tblCustomers' class="table table-bordered  table-striped employeeTable" style="table-layout:fixed;width: 100% !important">
                          <thead>
                            <tr style="text-align: center;">
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 50px;" >Sl.</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 120px;" >Employee ID</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Employee Name</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Designation</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Department</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Work Location</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >A/C No</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 120px;" >Net Payable</th>
                            </tr>
                          </thead>
                            <tbody>
                            <tr v-for="(form_data, index) in alldata.employee_data_bank" v-bind:key="form_data.id" >
                              <td class="ths" style="text-align: center" >{{index+1}}</td>
                              <td class="ths" style="text-align: center" > {{form_data.employee_id_no}}</td>
                              <td class="ths">{{form_data.employee_fullname}}</td>
                              <td class="ths">{{form_data.designation_name}}</td>
                              <td class="ths">{{form_data.department_name}}</td>
                              <td class="ths" >{{form_data.work_location_name}}</td>
                              <td class="ths" >{{form_data.ebc_account_number}}</td>
                              <td class="ths"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.netpay) |number('0,0.00') }}
                              </td>
                            </tr>
                            <tr>
                              <td class="ths" colspan="7" style="text-align: right;font-weight: bold">Total</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_netpay | number('0,0.00') }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>


                    <!-- details salary start here -->
                    <div class="col-md-12 payroll-process" v-if="search_button == 30">
                        <div class=" " style="min-height: 56px;" v-if="modal_loading">
                        <table id='tblCustomers' class="table table-bordered  table-striped employeeTable" style="table-layout:fixed;width: 100% !important">
                          <thead>
                            <tr style="text-align: center;">
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 50px;" >Sl.</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 120px;" >Employee ID</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Employee Name</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Designation</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Department</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Work Location</th>
                              <th v-if="sbu_checkbox == 1" class="ths id1" rowspan="2" style="vertical-align: middle;width: 100px;" >SBU</th>
                              <th v-if="grade_checkbox == 1" class="ths id2" rowspan="2" style="vertical-align: middle;width: 60px;" >Grade</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 95px;"  >Joining Date</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >A/C No</th>
                              <th class="ths" colspan="6" style="vertical-align: middle;width: 400px;" >Attendance</th>
                              <th v-if="total_dayoff_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Off Days Worked(Friday)</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Gross Salary</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Absent</th>
                              <th v-if="bank_salary_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Bank </th>
                              <th v-if="cash_salary_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Cash </th>
                              <th v-if="cash_pf_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >PF (Cash) </th>
                              <th v-if="cash_payable_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Total Cash </th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Gross Payable</th>
                              <th v-if="basic_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 90px;" >Basic Salary</th>
                              <th v-if="house_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 90px;" >House Rent</th>
                              <th v-if="medical_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 90px;" >Med. Allow</th>
                              <th v-if="conveyence_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 81px;" >Conv. Allow</th>
                              <th v-if="day_off_allowance_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 81px;" >Day off allow.</th>
                              <th class="ths" :colspan="alldata.addition_colspan" style="vertical-align: middle;width: 450px;" >Addition</th>
                              <th class="ths" :colspan="alldata.deduction_colspan" style="vertical-align: middle;width: 600px;" >Deduction</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 120px;" >Net Payable</th>
                              <th v-if="bank_payable_checkbox == 1" class="ths" rowspan="2" style="text-align: center;width: 120px; " >Bank Payable</th>
                              <th v-if="cash_payable_checkbox == 1" class="ths" rowspan="2" style="text-align: center;width: 120px; " >Cash Payable</th>
                              <th class="ths" rowspan="2" style="text-align: center;width: 120px; " >Actual Salary</th>
                            </tr>
                            <tr>
                              <th class="ths" style="vertical-align: middle;text-align: center" title="Present Day"> P</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" title="Late Day"> L</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" title="Weekend/Holiday"> W/H</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" title="Absent Day"> A</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" title="Deduction Day"> D. Day</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" title=""> Pay Day</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" title=""> Arrear</th>
                              <th v-if="add_mobile_checkbox == 1" class="ths id3" style="vertical-align: middle;text-align: center" title=""> Mobile</th>
                              <th v-if="car_checkbox == 1" class="ths id4" style="vertical-align: middle;text-align: center"> Car</th>
                              <th v-if="incentive_checkbox == 1" class="ths id5" style="vertical-align: middle;text-align: center"> Incentive</th>
                              <th v-if="add_allownce_checkbox == 1" class="ths id6" style="vertical-align: middle;text-align: center"> Allowance</th>
                              <th v-if="other_allowance_checkbox == 1" class="ths id7" style="vertical-align: middle;text-align: center"> Other</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" title="Provident Fund"> PF</th>
                              <th v-if="adv_loan_checkbox == 1" class="ths" style="vertical-align: middle;text-align: center" title="Advance"> Adv./Loan</th>
                              <th v-if="deduction_uniform_checkbox == 1" class="ths id8" style="vertical-align: middle;text-align: center" > Uniform</th>
                              <th v-if="deduction_deposit_checkbox == 1" class="ths id9" style="vertical-align: middle;text-align: center" > Deposit</th>
                              <th v-if="tax_checkbox == 1" class="ths" style="vertical-align: middle;text-align: center" > TAX</th>
                              <th v-if="deduction_mobilebill_checkbox == 1" class="ths id10" style="vertical-align: middle;text-align: center" > Mobile</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" > Late</th>
                              <th v-if="deduction_others_checkbox == 1" class="ths id11" style="vertical-align: middle;text-align: center" > Other</th>
                            </tr>
                          </thead>
                            <tbody>
                            <tr v-for="(form_data, index) in alldata.employee_data_ds" v-bind:key="form_data.id" >
                              <td class="ths" style="text-align: center" >{{index+1}}</td>
                              <td class="ths" style="text-align: center" > {{form_data.employee_id_no}}</td>
                              <td class="ths">{{form_data.employee_fullname}}</td>
                              <td class="ths">{{form_data.designation_name}}</td>
                              <td class="ths">{{form_data.department_name}}</td>
                              <td class="ths" >{{form_data.work_location_name}}</td>
                              <td v-if="sbu_checkbox == 1" class="ths id1" style="text-align: center; width: 100px;">{{form_data.sbu_short_name}}</td>
                              <td v-if="grade_checkbox == 1" sclass="ths id2" style="text-align: center; width: 60px;" >{{form_data.jobgrade_name}}</td>
                              <td class="ths" style="text-align: center" >{{form_data.employee_joining_date}}</td>
                              <td class="ths" >{{form_data.ebc_account_number}}</td>
                              <td class="ths" style="vertical-align: middle;text-align: center">{{form_data.prtot}}</td>
                              <td class="ths" style="vertical-align: middle;text-align: center">{{form_data.lttot}}</td>
                              <td class="ths" style="vertical-align: middle;text-align: center">{{form_data.whtot}}</td>
                              <td class="ths" style="vertical-align: middle;text-align: center">{{form_data.abtot}}</td>
                              <td class="ths" style="vertical-align: middle;text-align: center">{{form_data.total_deduction_day}}</td>
                              <td class="ths" style="vertical-align: middle;text-align: center">{{form_data.pay_day}}</td>

                              <td v-if="total_dayoff_checkbox == 1" class="ths" style="width: 81px;vertical-align: middle; text-align: center;">{{form_data.total_day_off_worked ?? 0 }}</td>

                              <td class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.g_salary ?? 0 }}</td>


                              <td class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.absent_deduction ?? 0 }}</td>

                              <td v-if="bank_salary_checkbox == 1" class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.bank_salary) ?? 0 }}
                              </td>

                              <td v-if="cash_salary_checkbox == 1" class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.cash_salary) ?? 0 }}
                              </td>

                              <td v-if="cash_pf_checkbox == 1" class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.cash_pf) ?? 0 }}
                              </td>

                              <td v-if="cash_payable_checkbox == 1" class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.cash_payable) ?? 0 }}
                              </td>

                              <!-- <td class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.actual_salary) ?? 0 }}
                              </td> -->

                              <td class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.g_payble ?? 0 }}</td> <!-- bank_payable -->

                              <td v-if="basic_checkbox == 1" class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.basic ?? 0 }}</td>
                              <td v-if="house_checkbox == 1" class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.houserent ?? 0 }}</td>
                              <td v-if="medical_checkbox == 1" class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.medical ?? 0 }}</td>
                              <td v-if="conveyence_checkbox == 1" class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.transport ?? 0 }}</td>
                              <td v-if="day_off_allowance_checkbox == 1" class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.day_off_allowance ?? 0 }}</td>
                              
                              <td class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.arear ?? 0 }}</td>
                              <td v-if="add_mobile_checkbox == 1"  class="ths id3"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.additional_mobile ?? 0 }}</td>


                              <td v-if="car_checkbox == 1" class="ths id4"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.car_allowance ?? 0 ?? 0 }}</td>
                              <td v-if="incentive_checkbox == 1" class="ths id5"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.incentive ?? 0 }}</td>
                              <td v-if="add_allownce_checkbox == 1" class="ths id6"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.allowance ?? 0 }}</td>
                              <td v-if="other_allowance_checkbox == 1" class="ths id7"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.other_allownce ?? 0 }}</td>

                              <td class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_pfbasic ?? 0 ?? 0 }}</td>

                              <!-- <td v-if = 'form_data.bank_pf != 0' class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.bank_pf) ?? 0 }}
                              </td>
                              <td v-else class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.cash_pf) ?? 0 }}
                              </td> -->
                              

                              <td v-if="adv_loan_checkbox == 1" class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_loan ?? 0 }}</td> 
                              <td v-if="deduction_uniform_checkbox == 1" class="ths id8"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_uniform ?? 0 }}</td>
                              <td v-if="deduction_deposit_checkbox == 1" class="ths id9"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_deposit ?? 0 }}</td>
                              <td  v-if="tax_checkbox == 1"class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_tax ?? 0 ?? 0 }}</td> 
                              <td v-if="deduction_mobilebill_checkbox == 1" class="ths id10"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_mobilebill ?? 0 }}</td>
                              <td class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.late_deduction ?? 0 }}</td>
                              <td v-if="deduction_others_checkbox == 1" class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_others ?? 0 }}</td>
                              <td class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.net_payable) ?? 0 }}
                              </td>
                              <td v-if="bank_payable_checkbox == 1" class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.bank_payable) ?? 0 }}
                              </td>
                              <td v-if="cash_payable_checkbox == 1" class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.cash_payable_f) ?? 0 }}
                              </td>
                              <td class="ths id11" style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.actual_salary) ?? 0 }}
                              </td>
                            </tr>
                            <tr>
                              <td class="ths" style="text-align: right;font-weight: bold">Total</td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_gross_salary ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_absent_amount ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_bank ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_cash ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_pf_cash ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_total_cash ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_gross_payable ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_basic ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_houserent ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_medical ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_transport ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_arear ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_additional_mobile ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_car_allowance ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_incentive ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_allowance ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_other_allownce ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_deduction_pfbasic ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_deduction_loan ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_deduction_uniform ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_deduction_deposit ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_deduction_tax ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_deduction_mobilebill ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_late_deduction ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_deduction_others ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_netpay ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_bank_payable ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_cash_payable ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_actual_salary ?? 0 }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>


                    <!-- details salary start here -->
                    <div class="col-md-12 payroll-process" v-if="search_button == 12">
                        <div class=" " style="min-height: 56px;" v-if="modal_loading">
                        <table id='tblCustomers' class="table table-bordered  table-striped employeeTable" style="table-layout:fixed;width: 100% !important">
                          <thead>
                            <tr style="text-align: center;">
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 50px;" >Sl.</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 120px;" >Employee ID</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Employee Name</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Designation</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Department</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Work Location</th>
                              <th v-if="sbu_checkbox == 1" class="ths id1" rowspan="2" style="vertical-align: middle;width: 100px;" >SBU</th>
                              <th v-if="grade_checkbox == 1" class="ths id2" rowspan="2" style="vertical-align: middle;width: 60px;" >Grade</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 95px;"  >Joining Date</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >A/C No</th>
                              <th class="ths" colspan="6" style="vertical-align: middle;width: 400px;" >Attendance</th>
                              <th v-if="total_dayoff_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Off Days Worked(Friday)</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Gross Salary</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Absent</th>
                              <th v-if="bank_salary_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Bank </th>
                              <th v-if="cash_salary_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Cash </th>
                              <th v-if="cash_pf_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >PF (Cash) </th>
                              <th v-if="cash_payable_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Total Cash </th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Gross Payable</th>
                              <th v-if="basic_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 90px;" >Basic Salary</th>
                              <th v-if="house_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 90px;" >House Rent</th>
                              <th v-if="medical_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 90px;" >Med. Allow</th>
                              <th v-if="conveyence_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 81px;" >Conv. Allow</th>
                              <th v-if="day_off_allowance_checkbox == 1" class="ths" rowspan="2" style="vertical-align: middle;width: 81px;" >Day off allow.</th>
                              <th class="ths" :colspan="alldata.addition_colspan" style="vertical-align: middle;width: 450px;" >Addition</th>
                              <th class="ths" :colspan="alldata.deduction_colspan" style="vertical-align: middle;width: 600px;" >Deduction</th>
                              <th class="ths" rowspan="2" style="vertical-align: middle;width: 120px;" >Net Payable</th>
                              <th v-if="bank_payable_checkbox == 1" class="ths" rowspan="2" style="text-align: center;width: 120px; " >Bank Payable</th>
                              <th v-if="cash_payable_checkbox == 1" class="ths" rowspan="2" style="text-align: center;width: 120px; " >Cash Payable</th>
                            </tr>
                            <tr>
                              <th class="ths" style="vertical-align: middle;text-align: center" title="Present Day"> P</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" title="Late Day"> L</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" title="Weekend/Holiday"> W/H</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" title="Absent Day"> A</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" title="Deduction Day"> D. Day</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" title=""> Pay Day</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" title=""> Arrear</th>
                              <th v-if="add_mobile_checkbox == 1" class="ths id3" style="vertical-align: middle;text-align: center" title=""> Mobile</th>
                              <th v-if="car_checkbox == 1" class="ths id4" style="vertical-align: middle;text-align: center"> Car</th>
                              <th v-if="incentive_checkbox == 1" class="ths id5" style="vertical-align: middle;text-align: center"> Incentive</th>
                              <th v-if="add_allownce_checkbox == 1" class="ths id6" style="vertical-align: middle;text-align: center"> Allowance</th>
                              <th v-if="other_allowance_checkbox == 1" class="ths id7" style="vertical-align: middle;text-align: center"> Other</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" title="Provident Fund"> PF</th>
                              <th v-if="adv_loan_checkbox == 1" class="ths" style="vertical-align: middle;text-align: center" title="Advance"> Adv./Loan</th>
                              <th v-if="deduction_uniform_checkbox == 1" class="ths id8" style="vertical-align: middle;text-align: center" > Uniform</th>
                              <th v-if="deduction_deposit_checkbox == 1" class="ths id9" style="vertical-align: middle;text-align: center" > Deposit</th>
                              <th v-if="tax_checkbox == 1" class="ths" style="vertical-align: middle;text-align: center" > TAX</th>
                              <th v-if="deduction_mobilebill_checkbox == 1" class="ths id10" style="vertical-align: middle;text-align: center" > Mobile</th>
                              <th class="ths" style="vertical-align: middle;text-align: center" > Late</th>
                              <th v-if="deduction_others_checkbox == 1" class="ths id11" style="vertical-align: middle;text-align: center" > Other</th>
                            </tr>
                          </thead>
                            <tbody>
                            <tr v-for="(form_data, index) in alldata.employee_data_ds" v-bind:key="form_data.id" >
                              <td class="ths" style="text-align: center" >{{index+1}}</td>
                              <td class="ths" style="text-align: center" > {{form_data.employee_id_no}}</td>
                              <td class="ths">{{form_data.employee_fullname}}</td>
                              <td class="ths">{{form_data.designation_name}}</td>
                              <td class="ths">{{form_data.department_name}}</td>
                              <td class="ths" >{{form_data.work_location_name}}</td>
                              <td v-if="sbu_checkbox == 1" class="ths id1" style="text-align: center; width: 100px;">{{form_data.sbu_short_name}}</td>
                              <td v-if="grade_checkbox == 1" sclass="ths id2" style="text-align: center; width: 60px;" >{{form_data.jobgrade_name}}</td>
                              <td class="ths" style="text-align: center" >{{form_data.employee_joining_date}}</td>
                              <td class="ths" >{{form_data.ebc_account_number}}</td>
                              <td class="ths" style="vertical-align: middle;text-align: center">{{form_data.prtot}}</td>
                              <td class="ths" style="vertical-align: middle;text-align: center">{{form_data.lttot}}</td>
                              <td class="ths" style="vertical-align: middle;text-align: center">{{form_data.whtot}}</td>
                              <td class="ths" style="vertical-align: middle;text-align: center">{{form_data.abtot}}</td>
                              <td class="ths" style="vertical-align: middle;text-align: center">{{form_data.total_deduction_day}}</td>
                              <td class="ths" style="vertical-align: middle;text-align: center">{{form_data.pay_day}}</td>
                              <td v-if="total_dayoff_checkbox == 1" class="ths" style="width: 81px;vertical-align: middle; text-align: center;">{{form_data.total_day_off_worked ?? 0 }}</td>
                              <td class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.g_salary ?? 0 }}</td>
                              <td class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.absent_deduction ?? 0 }}</td>
                              <td v-if="bank_salary_checkbox == 1" class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.bank_salary) ?? 0 }}
                              </td>
                              <td v-if="cash_salary_checkbox == 1" class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.cash_salary) ?? 0 }}
                              </td>
                              <td v-if="cash_pf_checkbox == 1" class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.cash_pf) ?? 0 }}
                              </td>
                              <td v-if="cash_payable_checkbox == 1" class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.cash_payable) ?? 0 }}
                              </td>
                              <td class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.g_payble ?? 0 }}</td>
                              <td v-if="basic_checkbox == 1" class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.basic ?? 0 }}</td>
                              <td v-if="house_checkbox == 1" class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.houserent ?? 0 }}</td>
                              <td v-if="medical_checkbox == 1" class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.medical ?? 0 }}</td>
                              <td v-if="conveyence_checkbox == 1" class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.transport ?? 0 }}</td>
                              <td v-if="day_off_allowance_checkbox == 1" class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.day_off_allowance ?? 0 }}</td>
                              <td class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.arear ?? 0 }}</td>
                              <td v-if="add_mobile_checkbox == 1"  class="ths id3"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.additional_mobile ?? 0 }}</td>
                              <td v-if="car_checkbox == 1" class="ths id4"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.car_allowance ?? 0 ?? 0 }}</td>
                              <td v-if="incentive_checkbox == 1" class="ths id5"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.incentive ?? 0 }}</td>
                              <td v-if="add_allownce_checkbox == 1" class="ths id6"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.allowance ?? 0 }}</td>
                              <td v-if="other_allowance_checkbox == 1" class="ths id7"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.other_allownce ?? 0 }}</td>
                              <td class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_pfbasic ?? 0 ?? 0 }}</td>
                              <td v-if="adv_loan_checkbox == 1" class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_loan ?? 0 }}</td> 
                              <td v-if="deduction_uniform_checkbox == 1" class="ths id8"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_uniform ?? 0 }}</td>
                              <td v-if="deduction_deposit_checkbox == 1" class="ths id9"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_deposit ?? 0 }}</td>
                              <td  v-if="tax_checkbox == 1"class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_tax ?? 0 ?? 0 }}</td> 
                              <td v-if="deduction_mobilebill_checkbox == 1" class="ths id10"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_mobilebill ?? 0 }}</td>
                              <td class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.late_deduction ?? 0 }}</td>
                              <td v-if="deduction_others_checkbox == 1" class="ths"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_others ?? 0 }}</td>
                              <td class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.net_payable) ?? 0 }}
                              </td>
                              <td v-if="bank_payable_checkbox == 1" class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.bank_payable) ?? 0 }}
                              </td>
                              <td v-if="cash_payable_checkbox == 1" class="ths id11"  style="width: 180px;vertical-align: middle; text-align: right;">
                                {{(form_data.cash_payable_f) ?? 0 }}
                              </td>
                            </tr>
                            <tr>
                              <td class="ths" style="text-align: right;font-weight: bold">Total</td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right;font-weight: bold"></td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_gross_salary ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_absent_amount ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_bank ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_cash ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_pf_cash ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_total_cash ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_gross_payable ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_basic ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_houserent ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_medical ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_transport ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_dayoff_allowance ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_arear ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_additional_mobile ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_car_allowance ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_incentive ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_allowance ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_other_allownce ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_deduction_pfbasic ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_deduction_loan ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_deduction_uniform ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_deduction_deposit ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_deduction_tax ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_deduction_mobilebill ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_late_deduction ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_deduction_others ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_netpay ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_bank_payable ?? 0 }}</td>
                              <td class="ths" style="text-align: right; font-weight: bold">{{ alldata.total_cash_payable ?? 0 }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                
                    <!-- employee salary list start here -->
                    <div class="col-md-12 payroll-process" v-if="search_button == 1133">
                        <div class=" " style="min-height: 56px;" v-if="modal_loading">
                        <table id='tblCustomers' class="table table-bordered  table-striped employeeTable" style="table-layout:fixed;width: 100% !important">
                          <thead>
                            <tr style="text-align: center;">
                              <th class="ths" style="vertical-align: middle;width: 50px;">Sl.</th>
                              <th class="ths" style="vertical-align: middle;width: 120px;">Employee ID</th>
                              <th class="ths" style="vertical-align: middle;width: 200px;">Employee Name</th>
                              <th class="ths" style="vertical-align: middle;width: 200px;">Designation</th>
                              <th class="ths" style="vertical-align: middle;width: 200px;"> Status</th>
                              <th class="ths" style="vertical-align: middle;width: 200px;">Salary</th>
                              <th class="ths" style="vertical-align: middle;width: 200px;">Previou Salary</th>
                              <th class="ths" style="vertical-align: middle;width: 200px;" >Salary Diff.</th>
                            </tr>
                          </thead>
                             
                            <tbody>
                            <tr v-for="(form_data, index) in alldata.employee_data_salary_list" v-bind:key="form_data.id">
                              <td class="ths" style="text-align: center" >{{index+1}}</td>
                              <td class="ths" style="text-align: center" > {{form_data.employee_id_no}}</td>
                              <td class="ths">{{form_data.employee_fullname}}</td>
                              <td class="ths">{{form_data.designation_name}}</td>
                              <td class="ths" style="text-align: center">
                                <span v-if="form_data.employee_status == 1">{{ 'Active' }}</span>
                                <span v-else-if ="form_data.employee_status == 2">{{ 'Resigned' }}</span>
                                <span v-else>{{ 'Inactive' }}</span>
                              </td>
                              <td class="ths" style="text-align: right">{{form_data.gross_salary}}</td>
                              <td class="ths" style="text-align: right">{{form_data.previous_gross_salary}}</td>
                              <td class="ths" style="text-align: right">{{form_data.gross_salary - form_data.previous_gross_salary}}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>


                    
                    <br>
                    <br>
            
                    <table  style="width: 100%;" class="table report_bottom table-striped employeeTable" > 
                      <tr style="border: 0px solid #0000;">
                         <td style="width: 20%;border: 0px solid #0000;text-align: center;"> 
                          <p> &nbsp;<br></p>
                          Prepared By </td>
                         <td style="width: 20%;border: 0px solid #0000;text-align: center;"> 
                          <p> &nbsp;<br></p>
                          Verification BY HR  </td>
                         <td style="width: 20%;border: 0px solid #0000;text-align: center;"> 
                          <p> &nbsp;<br></p>
                          Checked By Accounts</td>
                         <td style="width: 20%;border: 0px solid #0000;text-align: center;">
                          <p> &nbsp;<br></p>
                           Department Head</td>
                         <td style="width: 20%;border: 0px solid #0000;text-align: center;">
                          <p> &nbsp;<br></p>
                           CFO</td>
                      </tr>
                    </table>


                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
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
      d_salary_checked: 0,
      form_data: {
         report_type: 0,
      },
      payroll_year: new Date().getFullYear(),
      report_column: 0,
      payroll_month:'',
      pay_slip_details:'',
      paySlipCash:'',
      paySlipDetails:'',
      total_dad_wages:'',
      total_loan_deduct:'',
      total_canteen_deduct:'',
      total_tic_deduct:'',
      total_total_deduct:'',
      total_net_amount:'',
      search_button:0,
      search_option:0,
      info_data: [],
      district_value: "",
      list_data: "",
      alldata:{},
      process_type:'',
      employee_group_value: "",
      attendanceColumn_value: "",
      employee_Category_value: "",
      visable: "",
      report_container: 0,
      sbu_name_value: [],
      employeeSbuData: [],
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
      reportTypesVelu: 0,
      dailyReportTypesVelu: 0,
      periodicReportTypesVelu: 0,
      individualReportTypesVelu: 0,
      checkedName: true,
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
      sbu_checkbox: 1,
      grade_checkbox: 1,
      add_mobile_checkbox: 1,
      car_checkbox: 1,
      incentive_checkbox: 1,
      add_allownce_checkbox: 1,
      other_allowance_checkbox: 1,
      deduction_uniform_checkbox: 1,
      deduction_deposit_checkbox: 1,
      deduction_mobilebill_checkbox: 1,
      deduction_others_checkbox: 1,
      bank_payable_checkbox: 1,
      cash_payable_checkbox: 1,
      basic_checkbox: 1,
      house_checkbox: 1,
      medical_checkbox: 1,
      conveyence_checkbox: 1,
      day_off_allowance_checkbox: 1,
      total_dayoff_checkbox: 1,
      bank_salary_checkbox: 1,
      cash_salary_checkbox: 1,
      cash_pf_checkbox: 1,
      adv_loan_checkbox: 1,
      tax_checkbox: 1,
      page_loading:'',
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
  computed: {
    total_gross_wages: function(){
      const total = this.alldata.reduce((sum, equity) => {
        return sum + equity.total_wages;
      }, 0)
      return total;
    },
    total_gross_wages: function(){
      const total = this.alldata.reduce((sum, equity) => {
        return sum + equity.total_wages;
      }, 0)
      return total;
    },
  },
  methods: {
    clickReportView(event){
      this.report_column = 0;
      if(event.target.value == 1){
        this.search_button = 1;
      }else if(event.target.value == 2){
        this.search_button = 2;
      }else if(event.target.value == 3){
        this.search_button = 3;
      }else if(event.target.value == 4){
        this.search_button = 4;
      }else if(event.target.value == 5){
        this.search_button = 5;
      }else if(event.target.value == 6){
        this.search_button = 6;
      }
      else if(event.target.value == 7){
        this.search_button = 7;
      }
      else if(event.target.value == 10){
        this.search_button = 10;
      }
      else if(event.target.value == 20){
        this.search_button = 20;
      }
      else if(event.target.value == 30){
        this.search_button = 30;
        this.report_column = 1;
      }
      else if(event.target.value == 11){
        this.search_button = 11;
      }
      else if(event.target.value == 12){
        this.search_button = 12;
      }
      else if(event.target.value == 1133){
        this.search_button = 1133;
      }
      else{
        this.search_button = 0;
      }
      // console.log(this.search_button);
      // alert(this.search_button);
      // event.target.value == 1
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
    $(".report_bottom").each(function () {
      this.style.setProperty("position", "fixed", "important");
      this.style.setProperty("bottom", "0px", "important");
      this.style.setProperty(" margin-top", "5px", "important");
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
      var toExcel = document.getElementById("printable").innerHTML;
      var ctx = {
        worksheet: name || "",
        table: toExcel,
      };
      var link = document.createElement("a");
      link.download = "weekly_Payroll.xls";
      link.href = uri + base64(format(template, ctx));
      link.click();
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

    viewReportss11111(report_url) {
      $(".local_excel_print").hide();
      $(".loader").show();
      console.log(report_url);
      axios
        .post(URL.baseUrl(report_url), {
          report_type: this.form_data.report_type,
          employee_department: this.form_data.employee_department,
          employee_designation: this.form_data.employee_designation,
          employee_sbu: this.form_data.employee_sbu,
          from_date: this.form_data.from_date,
          to_date: this.form_data.to_date,
          employee_id: this.form_data.employee_id,
          employee_section: this.form_data.employee_section,
          employee_sub_section: this.form_data.employee_sub_section,
          employee_department: this.form_data.employee_department,
          employee_designation: this.form_data.employee_designation,
          employee_name_value: this.form_data.employee_name_value,
          designation_name_value: this.form_data.designation_name_value,
          department_name_value: this.form_data.department_name_value,
          work_location_value: this.form_data.work_location_value,
          sbu_name_value: this.form_data.sbu_name_value,
          section_value: this.form_data.section_value,
          sub_section_value: this.form_data.sub_section_value,
          sub_unit_value: this.form_data.sub_unit_value,
          unit_value: this.form_data.unit_value,
          OfficeTime : this.form_data.OfficeTimeVelu,
          process_type: this.process_type,
          payroll_year: this.payroll_year,
          _token: $("input[name=_token]").val(),
        })
        .then((res) => {
                this.alldata = res.data;
                this.pay_slip_details = res.data.pay_slip_details;
                this.paySlipCash = res.data.paySlipCash;
                this.paySlipDetails = res.data.paySlipDetails;
                this.search_button = res.data.search_button;
                if(res.data.error_message == '0'){
                  var msg = "opps! something went wrong";
                  this.showToster({ status: 0, message: res.data.message });
                }
            $(".loader").hide();
            $(".local_excel_print").show();
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
          var msg = "opps! something went wrong";
          this.showToster({ status: 0, message: msg });
        });
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

    WeeklyProcessType(event){
          this.process_type=event.target.value;
      },
      payrollProcessYear(event){
          this.payroll_year = event.target.value;
      },
    onSelectEmployee(option) {
      console.log(option);
      this.form_data.employee_id = option.id;
      console.log(this.form_data.employee_id);
    },

    clickDetaislSalaryCheckBox(event, column_id){
      // this.d_salary_checked = 0;
      console.log(event.target.checked, column_id);

      if(event.target.checked == 1 && column_id == 100){
        this.select_all = 1;
        this.sbu_checkbox = 1;
        this.grade_checkbox = 1;

        this.add_mobile_checkbox = 1;
        this.alldata.addition_colspan = this.alldata.addition_colspan + 1;

        this.car_checkbox = 1;
        this.alldata.addition_colspan = this.alldata.addition_colspan + 1;

        this.incentive_checkbox = 1;
        this.alldata.addition_colspan = this.alldata.addition_colspan + 1;

        this.add_allownce_checkbox = 1;
        this.alldata.addition_colspan = this.alldata.addition_colspan + 1;

        this.other_allowance_checkbox = 1;
        this.alldata.addition_colspan = this.alldata.addition_colspan + 1;

        this.deduction_uniform_checkbox = 1;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan + 1;

        this.deduction_deposit_checkbox = 1;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan + 1;

        this.deduction_mobilebill_checkbox = 1;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan + 1;

        this.deduction_others_checkbox = 1;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan + 1;

        this.total_dayoff_checkbox = 1;
        this.bank_salary_checkbox = 1;
        this.cash_pf_checkbox = 1;
        this.cash_payable_checkbox = 1;
        this.basic_checkbox = 1;
        this.house_checkbox = 1;
        this.medical_checkbox = 1;
        this.conveyence_checkbox = 1;
        this.day_off_allowance_checkbox = 1;
        this.bank_payable_checkbox = 1;
        this.cash_payable_checkbox = 1;

        $('.dbgCheck').prop('checked', true).attr('checked', 'checked');
      }
      if(event.target.checked == 0 && column_id == 100){
        // alert('ok');
        this.select_all = 0;
        this.sbu_checkbox = 0;
        this.grade_checkbox = 0;

        this.add_mobile_checkbox = 0;
        this.alldata.addition_colspan = this.alldata.addition_colspan - 1;

        this.car_checkbox = 0;
        this.alldata.addition_colspan = this.alldata.addition_colspan - 1;

        this.incentive_checkbox = 0;
        this.alldata.addition_colspan = this.alldata.addition_colspan - 1;

        this.add_allownce_checkbox = 0;
        this.alldata.addition_colspan = this.alldata.addition_colspan - 1;

        this.other_allowance_checkbox = 0;
        this.alldata.addition_colspan = this.alldata.addition_colspan - 1;

        this.deduction_uniform_checkbox = 0;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan - 1;

        this.deduction_deposit_checkbox = 0;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan - 1;

        this.deduction_mobilebill_checkbox = 0;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan - 1;

        this.deduction_others_checkbox = 0;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan - 1;

        this.total_dayoff_checkbox = 0;
        this.bank_salary_checkbox = 0;
        this.cash_pf_checkbox = 0;
        this.cash_payable_checkbox = 0;
        this.basic_checkbox = 0;
        this.house_checkbox = 0;
        this.medical_checkbox = 0;
        this.conveyence_checkbox = 0;
        this.day_off_allowance_checkbox = 0;
        this.bank_payable_checkbox = 0;
        this.cash_payable_checkbox = 0;

        $('.dbgCheck').prop('checked', false).removeAttr('checked');
      }


      // this.alldata.addition_colspan = 6;
      if(event.target.checked == 1 && column_id == 1){
        this.sbu_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 1){
        this.sbu_checkbox = 0;
      }

      if(event.target.checked == 1 && column_id == 2){
        this.grade_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 2){
        this.grade_checkbox = 0;
      }
      if(event.target.checked == 1 && column_id == 3){
        this.add_mobile_checkbox = 1;
        this.alldata.addition_colspan = this.alldata.addition_colspan + 1;
      }
      if(event.target.checked == 0 && column_id == 3){
        this.add_mobile_checkbox = 0;
        this.alldata.addition_colspan = this.alldata.addition_colspan - 1;
      }
      if(event.target.checked == 1 && column_id == 4){
        this.car_checkbox = 1;
        this.alldata.addition_colspan = this.alldata.addition_colspan + 1;
      }
      if(event.target.checked == 0 && column_id == 4){
        this.car_checkbox = 0;
        this.alldata.addition_colspan = this.alldata.addition_colspan - 1;
      }
      if(event.target.checked == 1 && column_id == 5){
        this.incentive_checkbox = 1;
        this.alldata.addition_colspan = this.alldata.addition_colspan + 1;
      }
      if(event.target.checked == 0 && column_id == 5){
        this.incentive_checkbox = 0;
        this.alldata.addition_colspan = this.alldata.addition_colspan - 1;
      }
      if(event.target.checked == 1 && column_id == 6){
        this.add_allownce_checkbox = 1;
        this.alldata.addition_colspan = this.alldata.addition_colspan + 1;
      }
      if(event.target.checked == 0 && column_id == 6){
        this.add_allownce_checkbox = 0;
        this.alldata.addition_colspan = this.alldata.addition_colspan - 1;
      }
      if(event.target.checked == 1 && column_id == 7){
        this.other_allowance_checkbox = 1;
        this.alldata.addition_colspan = this.alldata.addition_colspan + 1;
      }
      if(event.target.checked == 0 && column_id == 7){
        this.other_allowance_checkbox = 0;
        this.alldata.addition_colspan = this.alldata.addition_colspan - 1;
      }
      if(event.target.checked == 1 && column_id == 8){
        this.deduction_uniform_checkbox = 1;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan + 1;
      }
      if(event.target.checked == 0 && column_id == 8){
        this.deduction_uniform_checkbox = 0;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan - 1;
      }
      if(event.target.checked == 1 && column_id == 9){
        this.deduction_deposit_checkbox = 1;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan + 1;
      }
      if(event.target.checked == 0 && column_id == 9){
        this.deduction_deposit_checkbox = 0;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan - 1;
      }
      if(event.target.checked == 1 && column_id == 10){
        this.deduction_mobilebill_checkbox = 1;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan + 1;
      }
      if(event.target.checked == 0 && column_id == 10){
        this.deduction_mobilebill_checkbox = 0;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan - 1;
      }
      if(event.target.checked == 1 && column_id == 11){
        this.deduction_others_checkbox = 1;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan + 1;
      }
      if(event.target.checked == 0 && column_id == 11){
        this.deduction_others_checkbox = 0;
        this.alldata.deduction_colspan = this.alldata.deduction_colspan - 1;
      }


      if(event.target.checked == 1 && column_id == 12){
        this.total_dayoff_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 12){
        this.total_dayoff_checkbox = 0;
      }

      if(event.target.checked == 1 && column_id == 13){
        this.bank_salary_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 13){
        this.bank_salary_checkbox = 0;
      }

      if(event.target.checked == 1 && column_id == 14){
        this.cash_salary_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 14){
        this.cash_salary_checkbox = 0;
      }

      if(event.target.checked == 1 && column_id == 15){
        this.cash_pf_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 15){
        this.cash_pf_checkbox = 0;
      }

      if(event.target.checked == 1 && column_id == 16){
        this.cash_payable_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 16){
        this.cash_payable_checkbox = 0;
      }

      if(event.target.checked == 1 && column_id == 17){
        this.basic_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 17){
        this.basic_checkbox = 0;
      }

      if(event.target.checked == 1 && column_id == 18){
        this.house_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 18){
        this.house_checkbox = 0;
      }

      if(event.target.checked == 1 && column_id == 19){
        this.medical_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 19){
        this.medical_checkbox = 0;
      }

      if(event.target.checked == 1 && column_id == 20){
        this.conveyence_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 20){
        this.conveyence_checkbox = 0;
      }

      if(event.target.checked == 1 && column_id == 21){
        this.day_off_allowance_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 21){
        this.day_off_allowance_checkbox = 0;
      }

      if(event.target.checked == 1 && column_id == 22){
        this.bank_payable_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 22){
        this.bank_payable_checkbox = 0;
      }

      if(event.target.checked == 1 && column_id == 23){
        this.cash_payable_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 23){
        this.cash_payable_checkbox = 0;
      }

      if(event.target.checked == 1 && column_id == 1133){
        this.cash_payable_checkbox = 1;
      }
      if(event.target.checked == 0 && column_id == 1133){
        this.cash_payable_checkbox = 0;
      }
      

    }


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
  footer {page-break-after: always;}
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
.ths{
  vertical-align: middle !important;
}


/* Checkbox list design */

  .dbgOuter{
    border: solid 1px #ced4da;
    border-radius: 2px;
    padding: 3px 8px 0px 0px;
    width: 100%;
    margin: 0 auto;
    font-size: 12px;

  }
  .dbgCont{
      display: inline-block;
      height: 24px;
      margin-left: 6px;
      margin-bottom: 5px;
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
  /* Checkbox list design */
</style>