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
                          Roster Setup
                        </h3>
                        <span class="float-sm-right" style="float: right">
                          <a class="btn btn-default" @click="$router.go(-1)"
                            ><i class="fa fa-arrow-left"></i> Back</a
                          >
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="card-body col-md-12">
                    <div class="row col-md-12">
                       <div class="form-group col-md-2" style="padding:0px;">
                              <label class="col-md-12 control-label">Date Type <sup style="color:red; top: -2px;">*</sup></label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                     <select @change="DateTypeId($event)" class="form-control" v-model="date_type_id" >
                                        <option id="" disabled>--Select Type--</option>
                                        <option value='1' selected>Month wise</option>
                                        <option value='2'>Date wise </option>
                                    </select>
                                  </div>
                              </div>
                      </div>
                      <div class="form-group col-md-2" v-if="date_type_id==2" style="max-width: 12%">
                        <label class="col-md-12 control-label"
                          >From Date <sup style="color: red; top: -2px">*</sup> </label
                        >
                        <div
                          class="col-md-12 inputGroupContainer"
                          style="padding: 0px"
                        >
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-home"></i
                            ></span>
                              <input  v-model="form_data.from_date"  placeholder="" class="form-control" type="date">
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-2"  v-if="date_type_id==2" style="max-width: 12%">
                        <label class="col-md-12 control-label"
                          >To Date <sup style="color: red; top: -2px">*</sup> </label
                        >
                        <div
                          class="col-md-12 inputGroupContainer"
                          style="padding: 0px"
                        >
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-home"></i
                            ></span>
                              <input  v-model="form_data.to_date"  placeholder="" class="form-control" type="date">
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-2"  v-if="date_type_id==1" style="padding: 0px">
                        <label class="col-md-12 control-label"
                          >Month
                          <sup style="color: red; top: -2px">*</sup></label
                        >
                        <div class="col-md-12 inputGroupContainer">
                          <div class="input-group">
                            <span
                              class="input-group-addon"
                              style="max-width: 100%"
                              ><i class="glyphicon glyphicon-list"></i
                            ></span>
                            <select
                              @change="monthsSelectsId($event)"
                              class="form-control"
                              v-model="monthly_id"
                            >
                              <option id="" disabled>
                                --Select Month--
                              </option>
                              <option
                                v-for="months in option_data.months_array"
                                :value="months.id"
                              >
                                {{ months.text }}
                              </option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-2"  v-if="date_type_id==1" style="padding: 0px">
                        <label class="col-md-12 control-label">Week </label>
                        <div class="col-md-12 inputGroupContainer">
                          <div class="input-group">
                            <span
                              class="input-group-addon"
                              style="max-width: 100%"
                              ><i class="glyphicon glyphicon-list"></i
                            ></span>
                            <select
                              @change="weekSelect($event)"
                              class="form-control"
                              v-model="week_id"
                            >
                              <option id="" disabled>
                                --Select Week--
                              </option>
                              <option id="">Deselect</option>
                              <option
                                v-for="weeks in weekly_data.week"
                                :value="weeks.id"
                              >
                                {{ weeks.text }}
                              </option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row report-box">
                      <div class="form-group col-md-2" style="max-width: 12%">
                        <label class="col-md-12 control-label"
                          >SBU <sup style="color: red; top: -2px">*</sup></label
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
                              v-model="sbu_name_value"
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
                      <div class="form-group col-md-2" style="max-width: 12%">
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
                      <div class="form-group col-md-2" style="max-width: 12%">
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
                      <div class="form-group col-md-2" style="max-width: 12%">
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
                      <div class="form-group col-md-2" style="max-width: 12%">
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
                      <div class="form-group col-md-2" style="max-width: 12%">
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
                        style="max-width: 12%"
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
                        style="max-width: 4%; padding: 15px 0px"
                      >
                        <span>
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
                        </span>
                      </div>

                      <!-- </div> -->
                      <!--  <div class="form-group col-md-4" style="padding:0px;">
                             <label class="col-md-12 control-label">Permission Type<sup style="color:red; top: -2px;">*</sup></label>
                             <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                   <select @change="notice_to($event)" class="form-control" v-model="roaster_type" >
                                      <option id="" disabled>--Select Roaster Type--</option>
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

                            <div class="col-md-4" style="padding:0px;" v-if="noticeToType !='' ">
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

                          <div class="col-md-4" style="padding:0px;" v-else>
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

        <section class="content" v-if="form_data.datesList">
          <div class="container-fluid">
            <div class="row" style="margin: 0 !important;" >
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    {{ "Total Employee :" }}
                    {{ form_data.employee_data_approvaldat.length }}
                  </div>
                  
                  <div class="card-body col-md-12" v-if="page_loading">
                    
                    <div class="row col-md-12">
                      <form
                        @submit.prevent="add({ add: 'add/shifting_setup' })"
                        id="validate-1"
                      >
                     <div class="row">
                        <div class="col-md-2">
                          <input
                            type="submit"
                            style="width: 130px; margin-bottom: 9px"
                            tabindex="4"
                            value="Save"
                            class="btn btn-sm btn-info"
                          />
                        </div>
                        <div class="col-md-7"> 
                          <div class="form-group col-md-5 float-left" v-if="date_type_id == 2" style="max-width: 20%">
                            <label class="col-md-12 control-label"
                              >Copy to F. Date </label>
                            <div
                              class="col-md-12 inputGroupContainer"
                              style="padding: 0px"
                            >
                              <div class="input-group">
                                <span class="input-group-addon"
                                  ><i class="glyphicon glyphicon-home"></i
                                ></span>
                                  <input  v-model="form_data.copy_from_date"  placeholder="" class="form-control" type="date">
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-5 float-left"  v-if="date_type_id==2" style="max-width: 20%">
                            <label class="col-md-12 control-label"
                              >Copy to T. Date </label
                            >
                            <div
                              class="col-md-12 inputGroupContainer"
                              style="padding: 0px"
                            >
                              <div class="input-group">
                                <span class="input-group-addon"
                                  ><i class="glyphicon glyphicon-home"></i
                                ></span>
                                  <input  v-model="form_data.copy_to_date"  placeholder="" class="form-control" type="date">
                              </div>
                            </div>
                          </div>
                          <a
                          @click="roster_copy($event)" 
                          class="btn btn-sm btn-info form-group col-md-2 float-left"
                          href="#"
                        >
                        <i class="fa fa-copy"
                          > Roster Copy</i
                        >
                      </a>
                      </div>
                       <div class="col-md-3">
                        <a
                        @click="roster_maping()"
                        class="btn btn-sm btn-info"
                        href="#"
                      >
                        <i class="fa fa-copy"
                          > Roster Maping next 7 days</i
                        >
                      </a>
                      </div>
                     </div>

                        <div class="col-md-12">
                          <!-- <div class="col-md-1">   -->

                          <!-- </div>    -->
                          <div class="div_maintb" style="min-height: 500px">
                             <table>
                                <tr>
                                    <th> Employee Name</th>
                                    <!-- <th> Employee Name</th> -->
                                    <th style="z-index: 1; text-align: center;" v-for="(form_data, index) in form_data.datesList" v-bind:key="form_data.id" i="index">{{ form_data.dates }} <br />
                                    {{ form_data.days }}</th>
                                    <!-- <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th>
                                    <th>Column</th> -->
                                </tr>
                                <tr v-for="(form_data, index) in form_data.employee_data_approvaldat" v-bind:key="form_data.id">
                                    <td>
                                      {{ index + 1 }}.
                                    {{ form_data.employee_fullname }} [
                                    {{ form_data.employee_id_no }} ]
                                    <input
                                      type="hidden"
                                      v-model="form_data.id"
                                      name=""
                                    />
                                    <input
                                      type="hidden"
                                      v-model="form_data.employee_id"
                                      name=""
                                    /></td>
                                    <!-- <td>Row</td> -->
                                    <td id="roster-input-field" style="padding: 0px 4px;" v-for="(formData, index) in form_data.datesLists" v-bind:key="formData.id">
                                        <vue-select
                                          v-model="formData.shiftTimeid"
                                          :options="option_data.officeTime"
                                          :value="
                                            index + 1 + form_data.employee_id_no
                                          "
                                          @select="onSelectEmployee"
                                          placeholder="Select one"
                                          style="min-height: 0px !important"
                                          label="text"
                                          track-by="text"
                                        ></vue-select>
                                    </td>
                                    <!-- <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td>
                                    <td>Row</td> -->
                                </tr>
                            </table>
                            <!-- <div class=""> -->
                            <!-- </div>  -->
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div v-if="!page_loading">
                    <pageLoading></pageLoading>
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
      </div>
    </div>


     <modal ref="modal" class=""  width="400" name="myModal" height="auto" :clickToClose="false" body-class="p-0">
            <div v-if="modal_loading">
                <div class="widget-header modal-header">
                    <h4><i class="fa fa-bars"></i> Shift Time Setup</h4>
                    <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modify-wraper modal-body">
                <!-- 01915961932 -->
                <!-- 01316639298 -->
                <!-- 01721412628 -->
                  
                  <div class="">
                     <form @submit.prevent="add({add:'add/shifting_setup_new'},resetModal)" class="well form-horizontal needs-validation" novalidate>
                      <div class="row" style="margin:0px">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label class="col-md-6 control-label">Copy From Date</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <input  v-model="form_data.copy_from_date"  placeholder="" class="form-control" type="date">
                                 </div>
                              </div>
                           </div>
                            <div class="form-group">
                              <label class="col-md-6 control-label">Copy To Date</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                     <input  v-model="form_data.copy_to_date"  placeholder="" class="form-control" type="date">
                                 </div>
                              </div>
                           </div>
                        </div>
                      </div>
                      <div class="form-actions">
                          <input type="submit" tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2">
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

    <div v-if="!page_loading">
      <pageLoading></pageLoading>
    </div>
  </div>
</template>
<script>
import Loading from "../Loading.vue";
import $ from "jquery";
import VueTimepicker from "vue2-timepicker";
import "vue2-timepicker/dist/VueTimepicker.css";
export default {
  data() {
    return {
      sbu_name_value: "",
      section_value: "",
      sub_section_value: "",
      employee_group_value: "",
      unit_value: "",
      make_user: 0,
      employeesName: "",
      employees_ids: "",
      employee_data_approvaldat: "",
      datesList: "",
      url: null,
      sub_unit_value: "",
      work_location_value: "",
      department_name_value: "",
      designation_name_value: "",
      jobgrade_name_value: "",
      employee_name_value: "",
      sub_unit_value: "",
      work_location_value: "",
      personal_email_id: "",
      noticeToType: 0,
      noticeToTypeName: "",
      monthly_id: "",
      week_id: "",
      roaster_type: "",
      permission_id: "",
      formDataAll: "",
      weekly_id: 0,
      weeks_id: 0,
      weekly_data: "",
      months_id: 0,
      permission_id_name: "",
      employees_list: [],
      date_type_id:2,
    };
  },
  created() {
    this.getResults(1);
    this.modal_loading = true;
  },
  components: {
    pageLoading: Loading,
    VueTimepicker,
  },
  computed: {
    options: () => countries,
  },
  methods: {
    roster_copy(e){
      if(!this.form_data.copy_from_date || !this.form_data.copy_to_date){
        alert('Select Copy from & to date at first!');
        exit();
      }
      // this.form_data.copy_from_date=this.form_data.from_date;
      // this.form_data.copy_to_date=this.form_data.to_date;
      if (confirm("Are you sure copy roster from date ("+this.form_data.from_date+"  -  "+this.form_data.to_date+") to date ("+this.form_data.copy_from_date+"  -  "+this.form_data.copy_to_date+")?")) {

        this.modal_loading = false;
        this.page_loading = false;
        let uri = URL.baseUrl("add/shifting_setup_new");
        axios
          .post(uri, {
            sbu_id: this.sbu_id,
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
            months_id: this.months_id,
            sbu_name_value: this.sbu_name_value,
            unit_value: this.unit_value,
            sub_unit_value: this.sub_unit_value,
            department_name_value: this.department_name_value,
            section_value: this.section_value,
            sub_section_value: this.sub_section_value,
            work_location_value: this.work_location_value,
            employee_name_value: this.employee_name_value,
            copy_from_date: this.form_data.copy_from_date,
            copy_to_date: this.form_data.copy_to_date,
            from_date: this.form_data.from_date,
            to_date: this.form_data.to_date,
          })
          .then((res) => {
            this.modal_loading = true;
            this.page_loading = true;
            console.log(res);
            if (res.data.status == 1) {
              this.showToster({ status: 1, message: res.data.message });
            } else {
              this.showToster({ status: 0, message: res.data.message });
            }
          })
          .catch((error) => {
            this.showToster({
              status: 0,
              message: "opps! something went wrong",
            });

            console.log(error);
            this.modal_loading = true;
            this.page_loading = true;
          });
      }
      // this.showModal();
    },
    roster_maping() {
      if (confirm("Do you really want to mapping next 7 days?")) {
        this.modal_loading = false;
        this.page_loading = false;
        let uri = URL.baseUrl("shift_time/roaster_maping");
        axios
          .post(uri, {
            sbu_id: this.sbu_id,
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
            months_id: this.months_id,

            sbu_name_value: this.sbu_name_value,
            unit_value: this.unit_value,
            sub_unit_value: this.sub_unit_value,
            department_name_value: this.department_name_value,
            section_value: this.section_value,
            sub_section_value: this.sub_section_value,
            work_location_value: this.work_location_value,
            employee_name_value: this.employee_name_value,
          })
          .then((res) => {
            this.modal_loading = true;
            this.page_loading = true;
            console.log(res);
            if (res.data.status == 1) {
              this.showToster({ status: 1, message: res.data.message });
            } else {
              this.showToster({ status: 0, message: res.data.message });
            }
          })
          .catch((error) => {
            this.showToster({
              status: 0,
              message: "opps! something went wrong",
            });

            console.log(error);
            this.modal_loading = true;
            this.page_loading = true;
          });
      }
    },
    DateTypeId(event){
            this.date_type_id=event.target.value;
        },
    updateCountry(form_data, shift) {
      form_data.shift = shift;
    },
    addRow(event, approval_infos) {
      var aaa = this.form_data.approval_infos.length;
      this.form_data.approval_infos.push({
        permission_id: this.permission_id,
        permission_type: this.noticeToType,
        permission_type_name: this.noticeToTypeName,
        permission_id_name: this.permission_id_name,
      });
      console.log(this.form_data.approval_infos);
    },
    deleteRow(index) {
      this.form_data.approval_infos.splice(index, 1);
    },
    monthlySelect(event) {
      if (event.target.value == 1) {
        this.weekly_id = 0;
      } else {
        this.weekly_id = 1;
      }
    },
    weekSelect(event) {
      this.weeks_id = event.target.value;
    },
    monthsSelectsId(event) {
      // this.modal_loading= false;
      this.months_id = event.target.value;
      console.log(this.weekly_id);
      // if(this.weekly_id==1){

      let uri = URL.baseUrl("shift_week/fiends");
      axios
        .post(uri, {
          // types:this.weekly_id,
          id: event.target.value,
        })
        .then((res) => {
          console.log(res);
          this.weekly_data = res.data;
          this.modal_loading = true;
        })
        .catch((error) => {
          this.modal_loading = true;
        });
      // }
      this.modal_loading = true;
    },
    // employeesSbu(option) {
    //   console.log("sss");
    //   this.sbu_id = option.id;
    // },
    // employeesSection(option) {
    //   this.section_id = option.id;
    // },
    // employeesSubSection(option) {
    //   this.subsection_id = option.id;
    // },
    // employeesGroup(option) {
    //   this.employee_group = option.id;
    // },
    // employeesSubUnit(option) {
    //   this.subunit_id = option.id;
    // },
    // employeesUnit(option) {
    //   this.unit_id = option.id;
    // },
    // employeesWorkLocation(option) {
    //   this.employee_work_location = option.id;
    // },
    // onSelectDepartment(option) {
    //   this.department_id = option.id;
    // },
    onSelectDesignation(option) {
      this.employee_designation = option.id;
    },
    onSearchAllData() {
      this.modal_loading = false;
      this.page_loading = false;
      // alert('ss');
      console.log(this.form_data.to_date);
      let uri = URL.baseUrl("shift_time/fiends");
      axios
        .post(uri, {
          sbu_id: this.sbu_id,
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
          months_id: this.months_id,
          employeeId:this.employees_ids,
          from_date:this.form_data.from_date,
          to_date:this.form_data.to_date,
        })
        .then((res) => { 
          console.log(res);
          this.form_data = res.data;
          this.modal_loading = true;
          this.page_loading = true;
          this.resetModal();
        })
        .catch((error) => {
          this.modal_loading = true;
          this.page_loading = true;
        });
    },
    onSelectJobGrade(option) {
      console.log(option);
      this.form_data.employee_job_grade = option.id;
      this.permission_id = option.id;
      this.permission_id_name = option.text;
      console.log(this.form_data.employee_job_grade);
    },
    onSelectEmployee(option) {
      console.log(option);
      this.form_data.employee_id = option.id;
      this.employees_ids=option.id;
      this.permission_id = option.id;
      this.permission_id_name = option.text;
      console.log(this.form_data.employee_id);
    },
    setModalData() {
      this.sbu_name_value = this.form_data.sbu_name_value;
      this.section_value = this.form_data.section_value;
      this.sub_section_value = this.form_data.sub_section_value;
      this.employee_group_value = this.form_data.employee_group_value;
      this.department_name_value = this.form_data.department_name_value;
      this.designation_name_value = this.form_data.designation_name_value;
      this.jobgrade_name_value = this.form_data.jobgrade_name_value;
      this.sub_unit_value = this.form_data.sub_unit_value;
      this.employee_name_value = this.form_data.employee_name_value;
      this.work_location_value = this.form_data.work_location_value;
      this.general_data_temp = this.form_data.general_info_temp;
    },
    resetModal() {
      // this.sbu_name_value='';
      // this.section_value='';
      // this.sub_section_value='';
      // this.employee_group_value='';
      // this.department_name_value='';
      // this.designation_name_value='';
      // this.jobgrade_name_value='';
      // this.unit_value='';
      // this.sub_unit_value='';
      // this.employee_name_value='';
      // this.work_location_value='';
      this.form_data.employee_status = "1";
      this.form_data.emplyee_category_mgt_non_mgt = "2";
      this.form_data.employee_leave_group = "1";
      this.form_data.employee_type = "2";
      this.form_data.make_user = "";
      this.form_data.user_type = "0";
      this.form_data.ea_approve_by_name = "";
      this.form_data.employee_mobile = "";
      this.form_data.employee_id = "";
      this.form_data.employee_number = "";
      this.form_data.employee_fullname = "";
      this.form_data.employee_joining_date = "";
      this.form_data.employee_image = "";
      this.form_data.make_user = "";
      // this.approvalnamevalue1="";
    },

    // notice_to(event){
    //  console.log(event.target.name);
    //  if (event.target.value==1) {
    //    this.noticeToType=1;
    //    this.noticeToTypeName='Company/SBU';
    //  }else if(event.target.value==2){
    //    this.noticeToType=2;
    //    this.noticeToTypeName='Department';
    //  }else if(event.target.value==3){
    //    this.noticeToType=3;
    //    this.noticeToTypeName='Unit';
    //  }else if(event.target.value==4){
    //    this.noticeToType=4;
    //    this.noticeToTypeName='Sub Unit';
    //  }else if(event.target.value==5){
    //    this.noticeToType=5;
    //    this.noticeToTypeName='Section';
    //  }else if(event.target.value==6){
    //    this.noticeToType=6;
    //    this.noticeToTypeName='Sub Section';
    //  }else if(event.target.value==7){
    //    this.noticeToType=7;
    //    this.noticeToTypeName='Employee';
    //  }
    // }
  },
};
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
  content: "";
}
.select_id > .multiselect > .multiselect__tags {
  min-height: 41px !important;
}

.employeeOption > .multiselect__content-wrapper{
    right: -76px!important;
}
 /* h1 {
      font-size: 20pt;
      margin: 0 0 20px;
      padding: 0;
      line-height: 100%;
  } */

  .div_maintb {
      height: calc(55vh);
      width: calc(83vw);
      overflow: scroll;
      border: 1px solid #6f6f6f;
  }

      .div_maintb table {
          border-spacing: 0;
      }

      .div_maintb th {
          position: sticky;
          top: 0;
          background: #464646;
          color: #d1d1d1;
          width: 100px;
          min-width: 100px;
          padding: 6px;
          outline: 1px solid #7a7a7a;
          font-weight: normal;
      }

      .div_maintb td {
          padding: 6px;
          outline: 1px solid #c3c3c3;
      }

          .div_maintb th:nth-child(1),
          .div_maintb td:nth-child(1) {
              position: sticky;
              left: 0;
              width: 200px;
              min-width: 200px;
          }

          /* .div_maintb th:nth-child(2),
          .div_maintb td:nth-child(2) {
              position: sticky;
              left: 142px;
              width: 50px;
              min-width: 50px;
          } */

          .div_maintb td:nth-child(1) {
              background: #464646;
              color:#fff;
              z-index: 200;
          }

      .div_maintb th:nth-child(1),
      .div_maintb th:nth-child(2) {
          z-index: 300;
      }
      td > .multiselect > .multiselect__tags{
        padding: 0px 0px 0 0px !important; 
    border-radius: 0px !important;
    border-bottom-right-radius: 0px !important;
    border: none;
     min-height: 100% !important;
      }
      #roster-input-field .multiselect__single{
        padding: 17px;
      }

</style>