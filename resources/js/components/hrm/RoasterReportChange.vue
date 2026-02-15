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
                        <h3 class="card-title d-none d-md-block">
                          Attendance Wise Roster Update
                        </h3>
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
                          class="form-group col-md-2 float-left"
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

                        <div
                          v-if="individualReportTypesVelu == 1"
                          class="form-group col-md-3 float-left"
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
                                v-model="employee_name_value"
                                :options="form_data.employee_data"
                                @select="onSelectEmployee"
                                placeholder="Select one"
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
                            >Shift</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>

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
                          </div>
                        </div>
                        <div
                          class="form-group col-md-3 float-left"
                          style="padding: 0px"
                        >
                          <label
                           
                            class="col-md-12 control-label"
                            >Date</label
                          >
                          <!-- <label
                            v-if="
                              periodicReportTypesVelu == 1 ||
                              individualReportTypesVelu == 1
                            "
                            class="col-md-12 control-label"
                            >From</label
                          > -->
                          <div
                            
                            class="col-md-12 inputGroupContainer"
                          >
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
                          v-if="
                            periodicReportTypesVelu == 1 ||
                            individualReportTypesVelu == 1
                          "
                          class="form-group col-md-3 float-left"
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
                      </div>

                      <div class="row report-box" v-if="reportTypesVelu == 2">
                        <!-- <label><strong>Report Columns: </strong></label> -->
                        <div class="col-md-12 attendance-column" style="">
                          <!-- style="height: 150px;overflow-y: auto;" -->
                          <div
                            class="
                              col-md-3
                              attendance-column
                              report-box
                              float-left
                            "
                          >
                            <!-- <div  v-if="individualReportTypesVelu ==1" class="form-group col-md-3 float-left" style="padding:0px;"> -->
                            <label class="col-md-12 control-label"
                              >Report Columns:</label
                            >
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"
                                  ><i class="glyphicon glyphicon-earphone"></i
                                ></span>
                                <vue-select
                                  class="report_fileds"
                                  v-model="attendanceColumn_value"
                                  :options="option_data.attendanceColumn"
                                  style="padding: 3px 8px 0px 8px"
                                  @select="onSelectAttendanceColumn"
                                  placeholder="Select one"
                                  multiple="multiple"
                                  label="text"
                                  track-by="text"
                                ></vue-select>
                              </div>
                              <!-- </div> -->
                            </div>
                            <!-- <label class="col-md-12"><strong>Report Columns: </strong></label>
                              <div class="age-option" v-for="attcol in attendanceColumn">
                                <label class="checkbox-label"  @click="columncheck($event,attcol)" >

                                    <input type="checkbox" :value="attcol.value" v-model="checkedattcols">
                                    <span>{{ attcol.label }}</span>

                                </label>
                                </div> -->
                          </div>
                          <div class="col-md-9 float-left">
                            <ul class="tags">
                              <!-- uncheck(checkedName) -->
                              <li
                                class="badge badge-pill badge-success"
                                v-for="(
                                  checkedName, index
                                ) in checkedattcolsaddText"
                                v-if="checkedName.text != ''"
                              >
                                <!-- <li v-for="attcol in checkedattcolsaddText"> -->
                                <samp @click="uncheck($event, checkedName)">
                                  {{ checkedName.text }}
                                  <span
                                    class="btn-xs btn-danger"
                                    style="margin-right: -7px"
                                  >
                                    <i class="fa fa-times"></i
                                  ></span>
                                </samp>
                                <!-- </li> -->

                                <!-- <span v-if="index > 0">
                                  {{ checkedName.label}} 
                                  
                                </span> -->
                              </li>
                            </ul>
                          </div>
                          <!-- <div  v-if="!checkedattcolsaddText" class="col-md-9 float-left ">
                            <p>No Data Selection!</p>
                          </div> -->
                        </div>
                      </div>

                      <div class="row report-box" v-if="reportTypesVelu == 2">
                        <!-- Purposes for Employee Report Start -->
                        <div
                          v-if="column_selection6 == 'age'"
                          class="form-group col-md-3 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label">Age</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <input
                                placeholder="Age From"
                                required="true"
                                type="number"
                                v-model="form_data.age_from"
                                class="form-control"
                              />
                              <input
                                placeholder="Age To"
                                type="number"
                                required="true"
                                v-model="form_data.age_to"
                                class="form-control"
                              />
                            </div>
                          </div>
                        </div>
                        <div
                          v-if="column_selection7 == 'salary'"
                          class="form-group col-md-3 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label">Salary</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <input
                                placeholder="Salary From"
                                required="true"
                                type="number"
                                v-model="form_data.salary_from"
                                class="form-control"
                              />
                              <input
                                placeholder="Salary To"
                                required="true"
                                type="number"
                                v-model="form_data.salary_to"
                                class="form-control"
                              />
                            </div>
                          </div>
                        </div>
                        <div
                          v-if="column_selection5 == 'permanent_district'"
                          class="form-group col-md-3 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label"
                            >District</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <!--  <vue-select v-model="district_value" :options="option_data.district_data" @select="employeesDistrict" placeholder="Select one" label="text" track-by="text"></vue-select> -->
                              <vue-select
                                v-model="form_data.district_value"
                                :options="option_data.district_data"
                                @select="employeesDistrict"
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
                          v-if="column_selection3 == 'employee_marital_status'"
                          class="form-group col-md-3 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label"
                            >Marital Status</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <select
                                v-model="form_data.employee_marital_status"
                                name="employee_status"
                                class="selectpicker form-control"
                              >
                                <option value="0">Select</option>
                                <option value="1">Single</option>
                                <option value="2">Married</option>
                                <option value="3">Widowed</option>
                                <option value="4">Divorced</option>
                                <option value="5">Separated</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div
                          v-if="column_selection14 == 'employee_gender'"
                          class="form-group col-md-3 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label">Gender</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <select
                                v-model="form_data.employee_gender"
                                name="employee_status"
                                class="selectpicker form-control"
                              >
                                <option value="0">Select</option>
                                <option value="1">Female</option>
                                <option value="2">Male</option>
                                <option value="3">Others</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div
                          v-if="column_selection10 == 'employee_job_grade'"
                          class="form-group col-md-3 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label"
                            >Job Grade</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <vue-select
                                v-model="form_data.jobgradeData_value"
                                :options="option_data.jobgrade_data"
                                @select="jobgradeData"
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
                          v-if="column_selection9 == 'service_length'"
                          class="form-group col-md-3 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label"
                            >Service Length</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <input
                                placeholder="Service Length From"
                                required="true"
                                type="number"
                                v-model="form_data.service_length_from"
                                class="form-control"
                              />
                              <input
                                placeholder="Service Length To"
                                type="number"
                                required="true"
                                v-model="form_data.service_length_to"
                                class="form-control"
                              />
                            </div>
                          </div>
                        </div>

                        <div
                          v-if="column_selection4 == 'employee_blood_group'"
                          class="form-group col-md-3 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label"
                            >Blood Group</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <select
                                v-model="form_data.employee_blood_group"
                                class="selectpicker form-control"
                              >
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

                        <div
                          v-if="
                            column_selection11 == 'emplyee_category_mgt_non_mgt'
                          "
                          class="form-group col-md-3 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label"
                            >Employee Category</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <vue-select
                                v-model="form_data.employee_Category_value"
                                :options="option_data.emplyeeCategory"
                                @select="employeesCategory"
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
                          v-if="column_selection12 == 'employee_type'"
                          class="form-group col-md-3 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label"
                            >Employee Type</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <vue-select
                                v-model="form_data.employee_type_value"
                                :options="option_data.employeeType"
                                @select="employeeTypes"
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
                          v-if="column_selection13 == 'employee_group'"
                          class="form-group col-md-3 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label"
                            >Employee Group</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <vue-select
                                v-model="form_data.employee_group_value"
                                :options="option_data.employee_group_data"
                                @select="employeesGroup"
                                placeholder="Select one"
                                multiple="multiple"
                                label="text"
                                track-by="text"
                              >
                              </vue-select>
                            </div>
                          </div>
                        </div>

                        <!-- if(option.id=='emplyee_category_mgt_non_mgt') {
              this.column_selection11=option.id;
            }
           if(option.id=='employee_type') {
            this.column_selection12=option.id;
           }
           if(option.id=='employee_group') {
            this.column_selection13=option.id; -->

                        <!-- Purposes for Employee Report End -->
                      </div>
                      <div class="col-md-12">
                        <!-- <button type="submit" class="btn btn-sm btn-info float-right"> <i class="fa fa-search"></i> Search</button> -->
                        <button
                          style="
                            border-radius: 5px;
                            margin-right: -15px;
                            padding: 5px 30px;
                          "
                          @click="viewReportss11111(form_data, urls)"
                          type="button"
                          class="btn btn-info float-right"
                        >
                          Search
                        </button>
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
        <section class="content local_excel_print">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="col-12">
                    <!-- <button id="btnExport"  @click="tableToExcel" class="btn-success float-right" style="margin-left:10px;">Export</button> -->
                    <!-- <button v-print="'#printMe'" class="btn-info float-right">Print</button> -->
                    <!-- <button @click="printDiv()" class="btn-info float-right">Print</button> -->
                    <!-- <button data-toggle-fullscreen>Toggle Fullscreen</button> -->
                  </div>
                  <!-- <div class="POMIS_2A_REPORT_VIEW1"  id="printMe" style="padding: 10px 25px 50px 20px"> -->
                  <!-- <div class="POMIS_2A_REPORT_VIEW1" id="printable" style="overflow-x: auto;">
                      </div> -->
                  <div class="card-body">
                    <form
                      id="form_data"
                      @submit.prevent="shift_update()"
                      method="post"
                    >
                      <div class="table-responsive">
                        <table
                          class="table table-bordered table-striped table-hover"
                          id="example1"
                        >
                          <thead>
                            <tr>
                              <th>Employee ID</th>
                              <th>Employee Name</th>
                              <th>Designation</th>
                              <th>Department</th>
                              <th>Work Location</th>
                              <th>Company</th>
                              <th>Shift Time</th>
                              <th>Shift Change</th>
                              <th>In Time</th>
                              <th>Out Time</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr
                              v-for="(
                                show_return_data, index
                              ) in all_return_data"
                              :key="index"
                            >
                              <td>{{ show_return_data.employee_card_no }}</td>
                              <td>{{ show_return_data.employee_full_name }}</td>
                              <td>{{ show_return_data.designation_name }}</td>
                              <td>{{ show_return_data.department_name }}</td>
                              <td>
                                {{ show_return_data.employee_work_location }}
                              </td>
                              <td>{{ show_return_data.sbu_name }}</td>
                              <td>{{ show_return_data.shift_time }}</td>
                              <td>
                                <!-- <input type="text" v-model="show_return_data.shift_id"> -->
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
                                    <vue-select
                                      v-model="show_return_data.shift_id"
                                      :options="option_data.officeTime"
                                      @select="shift_change(show_return_data)"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    >
                                    </vue-select>
                                  </div>
                                </div>
                              </td>
                              <td>{{ show_return_data.in_time }}</td>
                              <td>{{ show_return_data.out_time }}</td>
                              <td>{{ show_return_data.status }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-12">
                        <input
                          type="submit"
                          tabindex="4"
                          value="Shift Update"
                          class="btn btn-sm btn-info float-right col-md-2"
                        />
                      </div>
                    </form>
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
      info_data: [],
      all_return_data: [],
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
    this.getUrl();
  },
  components: {
    pageLoading: Loading,
    Multiselect,
  },
  methods: {
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
    shift_change(event) {
      event.shift_is_change = 1;
    },
    shift_update() {
      axios
        .post(URL.baseUrl("shift_update"), {
          shift_data: this.all_return_data,
        })
        .then((return_data) => {
          console.log(return_data);
          if (return_data.data.status == 0) {
            this.showToster({
              status: 1,
              message: "opps! something went wrong",
            });
          }
          this.showToster({ status: 1, message: "Shift Updated" });
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
          var msg = "opps! something went wrong";
          this.showToster({ status: 0, message: msg });
        });
    },
    viewReportss11111(form_data, url) {
      $(".local_excel_print").hide();
      $(".loader").show();
      // var urla = URL.baseUrl("get_roaster_report_change");
      // console.log(urla);
      axios
        .post(URL.baseUrl("get_roaster_report_change"), {
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
        })
        .then((return_data) => {
          console.log(return_data);
          this.report_container = 1;
          $("#report_container").show();
          // $(".POMIS_2A_REPORT_VIEW1").html(return_data);
          this.all_return_data = return_data.data;
          $(".loader").hide();
          $(".local_excel_print").show();
          // this.printStyles();
          // this.printDiv();
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
  .test {
    background-color: #1a4567 !important;
    -webkit-print-color-adjust: exact;
  }
}
.multiselect__content-wrapper {
  width: 200% !important;
}
</style>