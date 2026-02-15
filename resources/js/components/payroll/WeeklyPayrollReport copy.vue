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
                        <h3 class="card-title d-none d-md-block">Weekly Payroll Report</h3>
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
                            >Company/SBU</label
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
                                    <option value='4'>TR </option>
                                </select>
                              </div>
                          </div>
                        </div>  
                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label">Report Type</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                               <select v-model="form_data.report_type" class="form-control" @change="clickReportView($event)">
                                  <option value="0">--Select--</option>
                                  <option value="7">Payroll Report</option>
                                  <option value="1">Top Sheet</option>
                                  <option value="2">Payment A</option>
                                  <option value="3">Payment B</option>
                                  <option value="4">Payment C</option>
                                  <option value="5">Ledger</option>
                                  <option value="6">All Deduction</option>
                               </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <button v-if="this.search_button==1" style="border-radius: 5px;margin-right: -15px;padding: 5px 30px;" @click="viewReportss11111('get_weekly_report')" type="button" class="btn btn-info float-right">Search</button>
                        <button v-if="this.search_button==2" style="border-radius: 5px;margin-right: -15px;padding: 5px 30px;" @click="viewReportss11111('get_weekly_report_payment_a')" type="button" class="btn btn-info float-right">Search </button>
                        <button v-if="this.search_button==3" style="border-radius: 5px;margin-right: -15px;padding: 5px 30px;" @click="viewReportss11111('get_weekly_report_payment_b')" type="button" class="btn btn-info float-right">Search</button>
                        <button v-if="this.search_button==4" style="border-radius: 5px;margin-right: -15px;padding: 5px 30px;" @click="viewReportss11111('get_weekly_report_payment_c')" type="button" class="btn btn-info float-right">Search</button>
                        <button v-if="this.search_button==5" style="border-radius: 5px;margin-right: -15px;padding: 5px 30px;" @click="viewReportss11111('get_weekly_report_ledger')" type="button" class="btn btn-info float-right">Search</button>
                        <button v-if="this.search_button==6" style="border-radius: 5px;margin-right: -15px;padding: 5px 30px;" @click="viewReportss11111('get_weekly_report_deduction')" type="button" class="btn btn-info float-right">Search</button>
                         <button v-if="this.search_button==7" style="border-radius: 5px;margin-right: -15px;padding: 5px 30px;" @click="viewReportss11111('get_weekly_report_payroll')" type="button" class="btn btn-info float-right">Search</button>
                        
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
                    <table style="width: 100%">
                      <tbody>
                        <tr>
                          <td style="width: 20%">
                            <div class="row" style="margin-left: 21px">
                              <div
                                class="col-md-12"
                                style="padding: 0px; margin-top: 17px"
                              >
                                <img
                                  :src="`asset/1-1.jpg`"
                                  style="width: 25%"
                                />
                              </div>
                            </div>
                          </td>
                          <td style="width: 55%">
                            <div class="col-md-12" style="padding: 0px">
                              <h3
                                class="text-center"
                                style="margin: 0px;text-align: center !important;font-size: 18px;"
                              >
                                Gem Jute Ltd
                              </h3>
                              <h5
                                class="text-center"
                                style="text-align: center !important;font-size: 14px;"
                              >
                                <!-- <span v-if="this.search_button==1">Top Sheet</span>
                                <span v-if="this.search_button==2">Payment List - A Shift</span>
                                <span v-if="this.search_button==3">Payment List - B Shift</span>
                                <span v-if="this.search_button==4">Payment List - C Shift</span>
                                <span v-if="this.search_button==5">Ledger of Wages</span> -->
                                <span >{{ alldata.report_name }} </span>
                              </h5>
                              
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
                    <table v-if="search_button==1"
                      class="table table-bordered"
                      border="0"
                      style="width: 100%"
                    >
                      <thead>
                        <tr style="background: #eee">
                          <th class="ths text-center" rowspan="2">Unit</th>
                          <th class="ths text-center" rowspan="2">Department</th>
                          <th class="ths text-center" rowspan="2"> Salary Type</th>
                          <th class="ths text-center" colspan="3">Total Wages</th>
                          <th class="ths text-center" rowspan="2">Total Wages</th>
                          <th class="ths text-center" colspan="2">Attendance Bonus</th>
                          <th class="ths text-center">Gross Wages</th>
                          <th class="ths text-center" colspan="6">Deduction</th>
                          <th class="ths text-center" rowspan="2">Net Wages</th>
                          <th class="ths text-center" rowspan="2">Head</th>
                          <th class="ths text-center" rowspan="2">Remarks</th>
                        </tr>
                        <tr style="background: #eee">
                          <th class="ths text-center">A</th>
                          <th class="ths text-center">B</th>
                          <th class="ths text-center">C</th>
                          <th class="ths text-center">Hands</th>
                          <th class="ths text-center">Amount</th>
                          <th class="ths text-center">(Wages + Bonus)</th>
                          <th class="ths text-center">DAD</th>
                          <th class="ths text-center">Salary</th>
                          <th class="ths text-center">Canteen</th>
                          <th class="ths text-center">Appron</th>
                          <th class="ths text-center"> Bus Ticket</th>
                          <th class="ths text-center">Total Deduction</th>
                        </tr>
                        
                      </thead>
                      <tbody>
                        <tr v-for="(form_data, index) in alldata.payrollDataDetels" v-bind:key="form_data.id" >
                          <!-- <td class="ths">{{ index + 1 }}</td> -->
                          <td class="ths">{{ form_data.sub_unit_name }}</td>
                          <td class="ths">{{ form_data.department_name }}</td> 
                          <td class="ths">{{ form_data.salary_type }}</td>
                          <td class="ths text-right">{{ form_data.total_a_wages |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_b_wages |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_c_wages |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_wages |number('0,0.00') }}</td>
                          <td class="ths text-center">{{ form_data.bonus_hands  }}</td>
                          <td class="ths text-right">{{ form_data.bonus_amount |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.wages_and_bonus |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_dad |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.salary_loan |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_canteen_deduct |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_appron |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_ticket |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_deduction |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.net_wages |number('0,0.00') }}</td>
                          <td class="ths text-center">{{ form_data.top_sheet_head }}</td>
                          <td class="ths text-right">{{ form_data.top_sheet_remarks }}</td>
                        </tr>
                        <tr >
                          <!-- <td class="ths">{{ index + 1 }}</td> -->
                          <th colspan="3" class="ths">{{ 'Total' }}</th>
                          <th class="ths text-right">{{ alldata.Ttotal_a_wages |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ttotal_b_wages |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ttotal_c_wages |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ttotal_wages |number('0,0.00') }}</th>
                          <th class="ths text-center">{{ alldata.Tbonus_hands  }}</th>
                          <th class="ths text-right">{{ alldata.Tbonus_amount |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Twages_and_bonus |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ttotal_dad |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Tsalary_loan |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ttotal_canteen_deduct |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ttotal_appron |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ttotal_ticket |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ttotal_deduction |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Tnet_wages |number('0,0.00') }}</th>
                          <th class="ths text-center">{{ alldata.Ttop_sheet_head }}</th>
                          <th class="ths text-right">{{ alldata.Ttop_sheet_remarks }}</th>
                        </tr>
                      </tbody> 
                    </table>
                    <table v-if="search_button==2 || search_button==3 || search_button==4"
                      class="table table-bordered"
                      border="0"
                      style="width: 100%"
                    >
                      <thead>
                        <tr style="background: #eee">
                          <th class="ths text-center">SL No.</th>
                          <th class="ths text-center" style="width: 19%;">Name of Paying officer</th>
                          <th class="ths text-center"> Sub Unit </th>
                          <th class="ths text-center"> Department </th>
                          
                          <th class="ths text-center"> Gross Wages </th>
                          <th class="ths text-center">DAD</th>
                          <th class="ths text-center">Salary Loan</th>
                          <th class="ths text-center">Canteen Deduct</th>
                          <th class="ths text-center">Appron</th>
                          <th class="ths text-center">Bus Ticket</th>
                          <th class="ths text-center">Total Deduction</th>
                          <th class="ths text-center">Net Amount</th>
                          <th class="ths text-center">Rocket</th>
                          <th class="ths text-center">Heldup</th>
                          <th class="ths text-center">Cash Payment</th>
                          <th class="ths text-center" style="width: 10%;">Signature</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(form_data, index) in alldata.payrollDataDetels" v-bind:key="form_data.id" >
                          <td class="ths text-center">{{ index + 1 }}</td>
                          <td class="ths"></td>
                          <td class="ths">{{ form_data.sub_unit_name }}</td>
                          <td class="ths">{{ form_data.department_name }}</td>
                          
                          <td class="ths text-right">{{ form_data.total_wages  |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_dad  |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.salary_loan  |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_canteen_deduct  |number('0,0.00') }}</td>
                          <td class="ths text-right"> {{ form_data.total_appron_deduct |number('0,0.00') }} </td>
                          <td class="ths text-right"> {{ form_data.total_ticket_deduct |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_deduction  |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.net_wages  |number('0,0.00') }}</td>
                          <td class="ths"></td>
                          <td class="ths"></td>
                          <td class="ths"></td>
                          <td class="ths"> <p> &nbsp;</p></td>
                          
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th class="ths" colspan="4">Total</th>
                          <th class="ths text-right"><b>{{ alldata.total_gross_wages |number('0,0.00')  }}</b></th>
                          <th class="ths text-right"><b>{{ alldata.total_dad_wages |number('0,0.00')  }}</b></th>
                          <th class="ths text-right"><b>{{ alldata.total_loan_deduct |number('0,0.00')  }}</b></th>
                          <th class="ths text-right"><b>{{ alldata.total_canteen_deduct |number('0,0.00')  }}</b></th>
                          <th class="ths text-right"><b>{{ alldata.total_appron_deduct |number('0,0.00')  }}</b></th>
                          <th class="ths text-right"><b>{{ alldata.total_tic_deduct |number('0,0.00')  }}</b></th>
                          <th class="ths text-right"><b>{{ alldata.total_total_deduct |number('0,0.00')  }}</b></th>
                          <th class="ths text-right"><b>{{ alldata.total_net_amount |number('0,0.00')  }}</b></th>
                          <th class="ths"></th>
                          <th class="ths"></th>
                          <th class="ths"></th>
                          <th class="ths"></th>
                        </tr>
                      </tfoot>
                    </table>
                    <table v-if="search_button==5"
                      class="table table-bordered"
                      border="0"
                      style="width: 100%"
                    >
                      <thead>
                        <tr style="background: #eee">
                          <th class="ths text-center" rowspan="2">Department</th>
                          <th class="ths text-center" rowspan="2">Shift</th>
                          <th class="ths text-center" rowspan="2">Wages</th>
                          <th class="ths text-center" rowspan="2">OT Wages</th>
                          <th class="ths text-center" rowspan="2">Night Allowance</th>
                          <th class="ths text-center" rowspan="2">R.A</th>
                          <th class="ths text-center" rowspan="2">Other's Allowance</th>
                          <th class="ths text-center" rowspan="2">Total Wages</th>
                          <th class="ths text-center" rowspan="2">Attendance Bonus</th>
                          <th class="ths text-center" colspan="4">Deduction</th>
                          <th class="ths text-center" rowspan="2">Net Wages</th>
                          <th class="ths text-center" rowspan="2">Ledger</th>
                          <th class="ths text-center" rowspan="2">Top Sheet</th>
                        </tr>
                        <tr style="background: #eee">
                          <th class="ths text-center">Appron</th>
                          <th class="ths text-center">DAD</th>
                          <th class="ths text-center">Canteen</th>
                          <th class="ths text-center">Other's Deduction</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(data, index) in alldata" v-bind:key="index">
                          <td class="ths text-center">{{ data.department_name }}</td>
                          <td class="ths text-center">{{ data.title }}</td>
                          <td class="ths text-right">{{ data.total_a_wages |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ data.overtime.toFixed(2) }}</td>
                          <td class="ths text-right">{{ data.night_allownce.toFixed(2) }}</td>
                          <td class="ths text-right">{{ data.residential_allowance.toFixed(2) }}</td>
                          <td class="ths text-right">{{ data.allowance.toFixed(2) }}</td>
                          <td class="ths text-right">{{ data.total_wages.toFixed(2) }}</td>
                          <td class="ths text-right">{{ data.attendance_bonus.toFixed(2) }}</td>
                          <td class="ths text-right">{{ data.deduction_uniform.toFixed(2) }}</td>
                          <td class="ths text-right">{{ data.dad_deduction.toFixed(2) }}</td>
                          <td class="ths text-right">{{ data.deduction_canteen.toFixed(2) }}</td>
                          <td class="ths text-right">{{ data.deduction_others.toFixed(2) }}</td>
                          <td class="ths text-right">{{ data.net_wages.toFixed(2) }}</td>
                          <td class="ths"></td>
                          <td class="ths"></td>
                        </tr>
                      </tbody>
                    </table>
                    <table id="tblCustomers" v-if="search_button==6" class="table table-bordered  table-striped employeeTable" >
                      <thead>
                        
                        <tr style="background: #eee">
                          <th class="ths text-center" rowspan="2"> Sub Unit</th>
                          <th class="ths text-center" rowspan="2">Department</th>
                          <th class="ths text-center" rowspan="2"> Salary Type</th>
                          <th class="ths text-center" colspan="4">DAD</th>
                          <th class="ths text-center" colspan="4">Salary Loan</th>
                          <th class="ths text-center" colspan="4">Canteen</th>
                          <th class="ths text-center" colspan="4">Bus Ticket</th>
                          <th class="ths text-center" rowspan="2">Total Deduction</th>
                        </tr>
                        <tr style="background: #eee">
                          <th class="ths text-center">A</th>
                          <th class="ths text-center">B</th>
                          <th class="ths text-center">C</th>
                          <th class="ths text-center">Total</th>
                          <th class="ths text-center">A</th>
                          <th class="ths text-center">B</th>
                          <th class="ths text-center">C</th>
                          <th class="ths text-center">Total</th>
                          <th class="ths text-center">A</th>
                          <th class="ths text-center">B</th>
                          <th class="ths text-center">C</th>
                          <th class="ths text-center">Total</th>
                          <th class="ths text-center">A</th>
                          <th class="ths text-center">B</th>
                          <th class="ths text-center">C</th>
                          <th class="ths text-center">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                        <tr v-for="(form_data, index) in alldata.payrollDataDetels" v-bind:key="form_data.id" >
                          <td class="ths text-left">{{ form_data.sub_unit_name }}</td>
                          <td class="ths text-leeft">{{ form_data.department_name }}</td>
                          <td class="ths text-left">{{ form_data.salary_type }}</td>
                          <td class="ths text-right">{{ form_data.a_deduction_dad |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.b_deduction_dad |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.c_deduction_dad |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_dad_deduction |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.a_deduction_loan |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.b_deduction_loan |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.c_deduction_loan |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_loan_deduction |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.a_deduction_canteen |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.b_deduction_canteen |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.c_deduction_canteen |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_canteen_deduction |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.a_deduction_bus_ticket |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.b_deduction_bus_ticket |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.c_deduction_bus_ticket |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_bus_ticket_deduction |number('0,0.00') }}</td>
                          <!-- <td class="ths text-right">{{ form_data.a_deduction_uniform |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.b_deduction_uniform |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.c_deduction_uniform |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_uniform_deduction |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.a_deduction_others |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.b_deduction_others |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.c_deduction_others |number('0,0.00') }}</td>
                          <td class="ths text-right">{{ form_data.total_others_deduction |number('0,0.00') }}</td> -->
                          <td class="ths text-right">{{ (form_data.total_dad_deduction+form_data.total_loan_deduction+form_data.total_canteen_deduction+form_data.total_bus_ticket_deduction) |number('0,0.00') }}</td>
                        </tr>
                        <tr>
                          <th class="ths text-left" colspan="3">{{ "Total" }}</th>
                          <th class="ths text-right">{{ alldata.Ta_deduction_dad |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Tb_deduction_dad |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Tc_deduction_dad |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ttotal_dad_deduction |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ta_deduction_loan |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Tb_deduction_loan |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Tb_deduction_loan |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ttotal_loan_deduction |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ta_deduction_canteen |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Tb_deduction_canteen |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Tc_deduction_canteen |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ttotal_canteen_deduction |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ta_deduction_bus_ticket |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Tb_deduction_bus_ticket |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Tc_deduction_bus_ticket |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ alldata.Ttotal_bus_ticket_deduction |number('0,0.00') }}</th>
                          <th class="ths text-right">{{ (alldata.Ttotal_dad_deduction+alldata.Ttotal_loan_deduction+alldata.Ttotal_canteen_deduction+alldata.Ttotal_bus_ticket_deduction) |number('0,0.00') }}</th>
                        </tr>
                      </tbody>
                    </table>
                    <table id="tblCustomers" v-if="search_button==6" style="width: 50%;margin-top: 36px;margin-left: 25%;" class="table table-bordered  table-striped employeeTable" >
                      <thead>
                        <tr style="background: #eee">
                          <th class="ths text-center" >Salary Type</th>
                          <th class="ths text-center" >DAD</th>
                          <th class="ths text-center" >Salary Loan</th>
                          <th class="ths text-center" >Canteen</th>
                          <th class="ths text-center" >Bus Ticket</th>
                          <th class="ths text-center" >Total Deduction</th>
                        </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(form_data, index) in alldata.SalaryType" v-bind:key="form_data.id" >
                            <td class="ths text-left">{{ form_data.Salary_Type_name }}</td>
                            <td class="ths text-right">{{ form_data.dadAmount |number('0,0.00') }}</td>
                            <td class="ths text-right">{{ form_data.SalaryLoan |number('0,0.00') }}</td>
                            <td class="ths text-right">{{ form_data.canteen |number('0,0.00') }}</td>
                            <td class="ths text-right">{{ form_data.BusTicket |number('0,0.00') }}</td>
                            <td class="ths text-right">{{ form_data.TotalDeduction |number('0,0.00') }}</td>
                          </tr>
                          <tr>
                            <th class="ths text-left">{{ 'Total'}}</th>
                            <th class="ths text-right">{{ alldata.TdadAmount |number('0,0.00') }}</th>
                            <th class="ths text-right">{{ alldata.TSalaryLoan |number('0,0.00') }}</th>
                            <th class="ths text-right">{{ alldata.Tcanteen |number('0,0.00') }}</th>
                            <th class="ths text-right">{{ alldata.TBusTicket |number('0,0.00') }}</th>
                            <th class="ths text-right">{{ alldata.TTotalDeduction |number('0,0.00') }}</th>
                          </tr>
                          <tr>
                            <td class="ths text-left">{{ 'Sarder Releiver'}}</td>
                            <td class="ths text-right">{{ alldata.SRdadAmount |number('0,0.00') }}</td>
                            <td class="ths text-right">{{ alldata.SRSalaryLoan |number('0,0.00') }}</td>
                            <td class="ths text-right">{{ alldata.SRcanteen |number('0,0.00') }}</td>
                            <td class="ths text-right">{{ alldata.SRBusTicket |number('0,0.00') }}</td>
                            <td class="ths text-right">{{ alldata.SRTotalDeduction |number('0,0.00') }}</td>
                          </tr>
                          
                          <tr>
                            <th class="ths text-left">{{ 'Gross Total'}}</th>
                            <th class="ths text-right">{{ alldata.GTdadAmount |number('0,0.00') }}</th>
                            <th class="ths text-right">{{ alldata.GTSalaryLoan |number('0,0.00') }}</th>
                            <th class="ths text-right">{{ alldata.GTcanteen |number('0,0.00') }}</th>
                            <th class="ths text-right">{{ alldata.GTBusTicket |number('0,0.00') }}</th>
                            <th class="ths text-right">{{ alldata.GTTotalDeduction |number('0,0.00') }}</th>
                          </tr>
                        </tbody>
                    </table>


                    <table id="tblCustomers" v-if="search_button==7" class="table table-bordered  table-striped employeeTable" >
                      <thead>
                        <tr style="text-align: center;">
                          <th class='ths' rowspan="0" style="vertical-align: middle;width: 5%" >SL.NO</th>
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
                           <th class='ths' v-if="alldata.process_type!=2" rowspan="0" style="vertical-align: middle;" >Wages Rate</th>
                          <th class='ths' v-if="alldata.process_type!=2" rowspan="0" style="vertical-align: middle;" >Wages</th> 
                          <th class='ths' v-if="alldata.process_type==2" rowspan="0" style="vertical-align: middle;" >Amount</th>
                          <th class='ths' v-if="alldata.process_type!=2" rowspan="0" style="vertical-align: middle;" >OT Hour</th>
                          <th class='ths' v-if="alldata.process_type!=2" rowspan="0" style="vertical-align: middle;" >OT Wages</th>
                          <th class='ths' rowspan="0" v-if="alldata.process_type==2" style="vertical-align: middle;" >OT Amount</th>
                          <th class='ths' rowspan="0" style="vertical-align: middle;" >Att. Bonus</th>
                          <th class='ths' rowspan="0" style="vertical-align: middle;" >Adj. Amount</th>
                          <th class='ths' rowspan="0" style="vertical-align: middle;" >Night Alwnc.</th>
                          <th class='ths' rowspan="0" style="vertical-align: middle;" >R.A</th>
                          <th class='ths' v-if="alldata.process_type!=2" rowspan="0" style="vertical-align: middle;" >Total Wages</th>
                          <th class='ths'  v-if="alldata.process_type==2" rowspan="0" style="vertical-align: middle;" >Total Amount</th>
                          <th class='ths' rowspan="0" style="vertical-align: middle;" title="D deduction">DAD</th>
                          <th class='ths' rowspan="0" style="vertical-align: middle;" >Other's Deduct</th>
                          <th class='ths' rowspan="0" style="vertical-align: middle;" >Cant. Ded.</th>
                          <th class='ths' rowspan="0" style="vertical-align: middle;" >Appron</th>
                          <th class='ths' rowspan="0" style="vertical-align: middle;" >Total Deduction</th>
                          <th class='ths' v-if="alldata.process_type!=2" rowspan="0" style="vertical-align: middle;" >Net Wages</th>
                          <th class='ths' v-if="alldata.process_type==2" rowspan="0" style="vertical-align: middle;" >Net Amount</th>
                          <th class='ths' rowspan="0" style="vertical-align: middle;" >Signature</th>

                        </tr>
                      </thead>
                       <tbody>
                        <tr v-for="(form_data, index) in alldata.payrollDataDetels" v-bind:key="index" >
                          
                          <td class="text-center ths">{{index+1}}</td>
                          <td class='ths'> {{form_data.employee_id_no}}</td>
                          <td class='ths'>{{form_data.employee_fullname}}</td>
                          <td class='ths'>{{form_data.designation_name}}</td>
                          <td class='ths'>{{form_data.department_name}}</td>
                          <!-- <td class="text-center">{{form_data.jobgrade_name}}</td> -->
                          <td class='ths' style="">{{form_data.sub_unit_name}}</td>
                          <td class="text-cente ths" style="vertical-align: middle;text-align: center">
                            {{form_data.shift_name}}
                          </td>
                          
                          <td class="text-center ths" style="vertical-align: middle;text-align: center">{{form_data.present_shift_name}}</td>
                          <td class='ths' style="vertical-align: middle;text-align: center">
                            {{form_data.prtot}}
                          </td>
                          <td class='ths' style="vertical-align: middle;text-align: center">
                            {{form_data.holiday || 0}}
                          </td>
                          <td  class="text-right ths" style="width: 81px;vertical-align: middle;">
                           {{form_data.g_salary  |number('0,0.00') }}  
                          </td>
                          
                           <td  v-if="form_data.process_type != 2" class="text-right ths" style="width: 81px;vertical-align: middle;">
                              {{(form_data.total_wages) |number('0,0.00') }}
                          </td>
                          <td v-if="form_data.process_type != 2" class="text-right ths" style="width: 81px;vertical-align: middle;">
                            {{form_data.ot_time |number('0,0.00') }}
                          </td> 
                          
                           <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                            {{form_data.overtime |number('0,0.00') }}
                          </td>
                          <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                              {{form_data.attendance_bonus |number('0,0.00') }}
                          </td>
                          <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                     
                            {{form_data.arear |number('0,0.00') }}
                          </td>
                          <td class="text-right ths" style="width: 81px;vertical-align: middle;">
               
                              {{form_data.night_allownce || 0 |number('0,0.00') }}
                          </td>
                          <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                            
                              {{form_data.residential_allowance || 0 |number('0,0.00') }}
                          </td>
                          
                          <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                          {{form_data.final_total_wages |number('0,0.00') }}
                          </td>
                          <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                            {{form_data.dad_deduction || 0 |number('0,0.00') }}
                          </td>
                          <td class="text-right ths" style="width: 81px;vertical-align: middle;">
             
                             {{form_data.deduction_others || 0 |number('0,0.00') }}
                          </td>
                          <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                          
                              {{form_data.deduction_canteen || 0 |number('0,0.00') }}
                            
                        </td>
                          <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                       
                              {{form_data.deduction_uniform || 0 |number('0,0.00') }}
                          </td>
                          <td class="text-right ths" style="width: 81px;vertical-align: middle;">
                          {{form_data.total_deduction || 0 |number('0,0.00') }}
                          </td>
                         
                          <td  class="text-right ths" style="width: 81px;vertical-align: middle;">
                          {{ (form_data.final_total_wages-form_data.total_deduction) || 0 |number('0,0.00') }}
                          </td>
                          <td  class="text-right ths" style="width: 120px;vertical-align: middle;"> <br> <br> </td> 
                        </tr>
                        <tr >
                          
                          <th v-if="alldata.process_type == 2" colspan ="10" class="text-center ths">Total</th>
                          <th v-if="alldata.process_type != 2" colspan ="11" class="text-center ths">Total</th>
                         
                          <th v-if="alldata.process_type == 2" class="text-right ths" style="width: 81px;vertical-align: middle;">
                           {{alldata.tAmount |number('0,0.00') }} 
                          </th>
                          <th v-if="alldata.process_type != 2" class="text-right ths" style="width: 81px;vertical-align: middle;">
                            {{alldata.Twagess |number('0,0.00') }} 
                           </th>
                          
                           <th class="text-right ths"  v-if="alldata.process_type != 2" style="width: 81px;vertical-align: middle;">
                            
                           </th>
                          <th class="text-right ths"  style="width: 81px;vertical-align: middle;">
                            
                            {{alldata.totAmount |number('0,0.00') }}
                          </th>
                          <th class="text-right ths" style="width: 81px;vertical-align: middle;">
                              {{alldata.tattBonus |number('0,0.00') }}
                          </th>
                          
                          <th class="text-right ths" style="width: 81px;vertical-align: middle;">
                     
                            {{alldata.tadjAmount |number('0,0.00') }}
                          </th>
                          <th class="text-right ths" style="width: 81px;vertical-align: middle;">
               
                              {{alldata.tnightAlwnc || 0 |number('0,0.00') }}
                          </th>
                          <th class="text-right ths" style="width: 81px;vertical-align: middle;">
                            
                              {{alldata.TrA || 0 |number('0,0.00') }}
                          </th>
                          
                          <th class="text-right ths" style="width: 81px;vertical-align: middle;">
                          {{alldata.totalAmount |number('0,0.00') }}
                          <!-- <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'final_total_wages',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'final_total_wages'+form_data.id" v-model="form_data.final_total_wages" class="form-control" type="text" readonly> -->
                          </th>
                          <th class="text-right ths" style="width: 81px;vertical-align: middle;">
                            {{alldata.totalDadDeduction || 0 |number('0,0.00') }} 
                          <!-- <input @keyup="TotalAmount($event,form_data,index, process_type)" v-on:dblclick="counter += 1, funcao($event, 'dad',form_data.id)" style="padding: 0;height: 25px;text-align: center;" :id="'dad'+form_data.id" v-model="form_data.dad" class="form-control" type="text" readonly> -->
                          </th>
                          <th class="text-right ths" style="width: 81px;vertical-align: middle;">
             
                             {{alldata.TOtherDeduct || 0 |number('0,0.00') }}
                          </th>
                          <th class="text-right ths" style="width: 81px;vertical-align: middle;">
                          
                              {{alldata.TCantDed || 0 |number('0,0.00') }}
                            
                        </th>
                          <th class="text-right ths" style="width: 81px;vertical-align: middle;">
                       
                              {{alldata.tdeduction_uniform || 0 |number('0,0.00') }}
                          </th>
                          <th class="text-right ths" style="width: 81px;vertical-align: middle;">
                          {{alldata.TotalDeduction || 0 |number('0,0.00') }}
                          </th>
                         
                          <th  class="text-right ths" style="width: 81px;vertical-align: middle;">
                          {{ (alldata.NetAmoun) || 0 |number('0,0.00') }}
                          </th>
                          <th  class="text-right ths" style="width: 120px;vertical-align: middle;"> <br> <br> </th>
                        </tr>
                        
                      </tbody>
                    </table>
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
                           Project Head</td>
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
    };
  },
  directives: {
    print,
  },
  created() {
    this.getResults(1);
    this.setFormData();
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
      }else if(event.target.value == 7){
        this.search_button = 7;
      }else{
        this.search_button = 0;
      }
      console.log(this.search_button);
      // event.target.value == 1
    },
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
      this.form_data.att_status = "";
      this.form_data.att_status = "";
      this.AttStatus_value = "";
    },
    DailyreportStatus(event) {
      this.form_data.att_status = event.target.value;
    },
    DailyreportTypes(event) {
      if (event.target.value == 1 || event.target.value == 2) {
        this.dailyReportTypesVelu = 1;
        this.form_data.att_report_type = event.target.value;
        this.periodicReportTypesVelu = 0;
        this.individualReportTypesVelu = 0;
      } else if (event.target.value == 3) {
        this.dailyReportTypesVelu = 0;
        this.DailyreportStatus = "";
        this.form_data.att_status = "";
        this.form_data.att_report_type = event.target.value;
        this.individualReportTypesVelu = 1;
        this.periodicReportTypesVelu = 0;
      } else if (event.target.value == 4 || event.target.value == 5) {
        this.periodicReportTypesVelu = 1;
        this.dailyReportTypesVelu = 0;
        this.form_data.att_report_type = event.target.value;
        this.individualReportTypesVelu = 0;
        this.DailyreportStatus = "";
        this.form_data.att_status = "";
      } else {
        this.form_data.att_report_type = 0;
        this.dailyReportTypesVelu = 0;
        this.periodicReportTypesVelu = 0;
        this.individualReportTypesVelu = 0;
        this.DailyreportStatus = "";
        this.form_data.att_status = "";
      }
      console.log(event.target.value);
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

    viewReportss11111(report_url) {
      $(".local_excel_print").hide();
      $(".loader").show();
      // var urla = URL.baseUrl("get_report");
      // console.log(urla);
      // get_weekly_report
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
          _token: $("input[name=_token]").val(),
        })
        .then((res) => {
          console.log(res.data);
          // if (res.data.status == 1) {
          //   this.report_container = 1;
            // if(report_url == 'get_weekly_report'){
            //   this.alldata1 = res.data;
            // }else{
              this.alldata = res.data;
              this.search_button = res.data.search_button;
            // }
            $(".loader").hide();
            $(".local_excel_print").show();
          // } else {
          //   var msg = "opps! something went wrong";
          //   this.showToster({ status: 0, message: msg });
          // }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
          var msg = "opps! something went wrong";
          this.showToster({ status: 0, message: msg });
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
    columncheck(event, id) {
      if (event.target.value == undefined) {
      } else {
        this.checkedattcolsadd.push(event.target.value);
        this.form_data.checkedattcolsadd = this.checkedattcolsadd;
        this.checkNameArray.push({
          label: id["label"],
        });
      }
    },

    uncheck(event, checkedName) {
      if (checkedName.id == "section_name") {
        this.column_selection1 = "";
      }
      if (checkedName.id == "sub_section_name") {
        this.column_selection2 = "";
      }
      if (checkedName.id == "employee_marital_status") {
        this.column_selection3 = "";
      }
      if (checkedName.id == "employee_blood_group") {
        this.column_selection4 = "";
      }
      if (checkedName.id == "permanent_district") {
        this.column_selection5 = "";
      }
      if (checkedName.id == "age") {
        this.column_selection6 = "";
      }
      if (checkedName.id == "salary") {
        this.column_selection7 = "";
      }

      if (checkedName.id == "service_length") {
        this.column_selection9 = "";
      }
      if (checkedName.id == "employee_job_grade") {
        this.column_selection10 = "";
      }

      if (checkedName.id == "emplyee_category_mgt_non_mgt") {
        this.column_selection11 = "";
      }
      if (checkedName.id == "employee_type") {
        this.column_selection12 = "";
      }
      if (checkedName.id == "employee_group") {
        this.column_selection13 = "";
      }
      if (checkedName.id == "employee_gender") {
        this.column_selection14 = "";
      }

      console.log(this.attendanceColumn_value);
      let datall = this.form_data.checkedattcolsadd;
      this.checkedattcolsadd = [];
      this.checkedattcolsaddText = [
        {
          id: "",
          text: "",
        },
      ];
      datall.forEach((element) => {
        if (checkedName.id === element) {
          // console.log(element);
        } else {
          let datall = this.option_data.attendanceColumn;
          let obj = datall.find((data) => data.id == element);
          this.checkedattcolsadd.push(element);
          this.checkedattcolsaddText.push({
            id: element,
            text: obj["text"],
          });
          this.form_data.checkedattcolsadd = this.checkedattcolsadd;
        }
        this.attendanceColumn_value = this.checkedattcolsaddText;
      });
    },
    // employeesSbu(option){
    //   console.log(option);
    //   this.employeeSbuData.push(option.id)
    //   this.form_data.employee_sbu= this.employeeSbuData;

    // },
    // onchentdata(){
    //     var result = Object.entries(this.form_data.branch_value);
    //     console.log(result);
    //     result.forEach(element => {
    //       console.log(element[1]['id']);
    //        this.permision.push(element[1]['id']);
    //     });
    //   // this.permision.push(option.id)
    //   this.form_data.permision=this.permision;
    //   // this.form_data.branch_value;
    //  console.log(this.form_data.permision);
    // },
    // employeesUnit(option){
    //   this.form_data.employee_unit= option.id;
    // },
    // employeesSubUnit(option){
    //    this.form_data.employee_sub_unit= option.id;
    // },
    // employeesSection(option){
    //   console.log(option);
    //   this.form_data.employee_section= option.id;
    //   console.log(this.form_data.employee_section);
    // },
    onSelectAtt_status(option) {
      this.form_data.att_status = option;
    },
    onSelectOfficeTime(option) {
      this.form_data.OfficeTime = option;
    },
    // employeesSubSection(option){
    //   console.log(option);
    //   this.form_data.employee_sub_section= option.id;
    //   console.log(this.form_data.employee_sub_section);
    // },
    jobgradeData(option) {
      this.form_data.employee_job_grade = option.id;
    },
    employeesGroup(option) {
      console.log(option);
      this.form_data.employee_group = option.id;
      console.log(this.form_data.employee_group);
    },
    // employeesSubUnit(option){
    //   console.log(option);
    //   this.form_data.employee_sub_unit= option.id;
    //   console.log(this.form_data.employee_sub_unit);
    // },

    // employeesWorkLocation(option){
    //   console.log(option);
    //   this.form_data.employee_work_location= option.id;
    //   console.log(this.form_data.employee_work_location);

    // },
    // onSelectDepartment(option){
    //   console.log(option);
    //   this.form_data.employee_department= option.id;
    //   console.log(this.form_data.employee_department);

    // },
    
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
    WeeklyProcessType(event){
          this.process_type=event.target.value;
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

    onSelectAttendanceColumn(option) {
      if (option.id == "section_name") {
        this.column_selection1 = option.id;
      }
      if (option.id == "sub_section_name") {
        this.column_selection2 = option.id;
      }
      if (option.id == "employee_marital_status") {
        this.column_selection3 = option.id;
      }
      if (option.id == "employee_blood_group") {
        this.column_selection4 = option.id;
      }
      if (option.id == "permanent_district") {
        this.column_selection5 = option.id;
      }
      if (option.id == "age") {
        this.column_selection6 = option.id;
      }
      if (option.id == "salary") {
        this.column_selection7 = option.id;
      }
      if (option.id == "employee_job_grade") {
        this.column_selection10 = option.id;
      }
      if (option.id == "service_length") {
        this.column_selection9 = option.id;
      }

      if (option.id == "emplyee_category_mgt_non_mgt") {
        this.column_selection11 = option.id;
      }
      if (option.id == "employee_type") {
        this.column_selection12 = option.id;
      }
      if (option.id == "employee_group") {
        this.column_selection13 = option.id;
      }
      if (option.id == "employee_gender") {
        this.column_selection14 = option.id;
      }

      // console.log('sss');
      // console.log(option);
      // console.log(this.column_selection);
      this.checkedattcolsadd.push(option.id);
      this.checkedattcolsaddText.push({
        id: option.id,
        text: option.text,
      });

      this.form_data.checkedattcolsadd = this.checkedattcolsadd;
      console.log(this.form_data.checkedattcolsadd);
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
</style>