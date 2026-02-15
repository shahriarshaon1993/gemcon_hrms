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
                      <div class="col-12 col-sm-6 col-md-12 row"  style="padding: 5px 10px">
                        <h3 class="card-title d-none d-md-block col-5 col-sm-5 col-md-5">
                          Employee Info [{{ form_data.employee_id_no }} - {{ form_data.employee_fullname }} ]
                          <input type="hidden" v-model="form_data.id">
                        </h3>
                        <!-- middel employee search -->
                        <span class="col-5 col-sm-5 col-md-5 employeeSerch" style="float: center;text-align: center;">
                          <vue-select v-model="employee_search_value" :options="form_data.employee_data"
                            @select="emp_search_by_id" placeholder="Select Employee Id ..." label="text" track-by="text">
                          </vue-select>
                        </span>
                        <span class="float-sm-right col-2 col-sm-2 col-md-2" style="float: right;text-align: end;">
                          <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                        </span>
                      </div>
                      <!-- <div class="col-6 col-sm-6 col-md-6" style="margin: 0px auto;">
                        <div class="input-group">
                          <vue-select v-model="employee_search_value" :options="form_data.employee_data"
                            @select="emp_search_by_id" placeholder="Select one" label="text" track-by="text">
                          </vue-select>

                        </div>
                      </div> -->
                    </div>
                  </div>
                  <div class="card-body" style="padding-left: 0px; padding-top: 7px">
                    <div id="page-wrapper">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="">
                            <div class="col-md-2 float-left">
                              <ul class="nav nav-tabs" id="myTab" role="tablist" style="display: list-item">
                                <li class="nav-item">
                                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#basicinfo"
                                    role="tab" aria-controls="home" aria-selected="true">Basic Information</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="home-tab" data-toggle="tab" href="#personalinfo" role="tab"
                                    aria-controls="home" aria-selected="true">Personal Information</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="home-tab" data-toggle="tab" href="#addressdetails" role="tab"
                                    aria-controls="home" aria-selected="true">Address Details</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="home-tab" data-toggle="tab" href="#identification" role="tab"
                                    aria-controls="home" aria-selected="true">Identification Supporting</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="home-tab" data-toggle="tab" href="#education" role="tab"
                                    aria-controls="home" aria-selected="true">Educational Qualification</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="home-tab" data-toggle="tab" href="#professional" role="tab"
                                    aria-controls="home" aria-selected="true">Professional Qualification</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="home-tab" data-toggle="tab" href="#employmenthistory"
                                    role="tab" aria-controls="home" aria-selected="true">Employment History</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="home-tab" data-toggle="tab" href="#familydetails" role="tab"
                                    aria-controls="home" aria-selected="true">Family Details</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#trainingrecord"
                                    role="tab" aria-controls="contact" aria-selected="false">Training Record</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#professionalmember"
                                    role="tab" aria-controls="contact" aria-selected="false">Professional Membership</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#bankaccount" role="tab"
                                    aria-controls="contact" aria-selected="false">Bank Account Details</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#emergencycontact"
                                    role="tab" aria-controls="contact" aria-selected="false">Emergency Contact</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#othersContactInfo"
                                    role="tab" aria-controls="contact" aria-selected="false">Others Contact</a>
                                </li>
                                <li class="nav-item">

                                  <router-link href="#" :to="'/appointment/' + form_data.id+'/bn'" class="nav-link"
                                    title="Appointment Letter">
                                    <i style="padding-right: 6px" class="fa fa-user"></i>
                                    Appointment letter (বাংলা)
                                  </router-link>
                                </li>
                                <li class="nav-item">

                                  <router-link href="#" :to="'/appointment/' + form_data.id+'/en'" class="nav-link"
                                    title="Appointment Letter">
                                    <i style="padding-right: 6px" class="fa fa-user"></i>
                                    Appointment letter
                                  </router-link>
                                </li>

                              </ul>
                            </div>
                            <div class="col-md-10 float-left" style="border: 1px solid #ccc; border-radius: 5px">
                              <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="basicinfo">
                                  <form @submit.prevent="
                                    basicadd({ add: 'add/employees' })
                                  " class="
                                      well
                                      form-horizontal
                                      needs-validation
                                    " enctype="multipart/form-data">
                                    <div class="modify-wraper" style="padding-top: 10px">
                                      <div v-if="errors" class="alert alert-danger" style="">
                                        <div v-for="(error, index) in errors">
                                          <span v-if="isObject(error)" v-for="err in error">{{ err }}</span>
                                          <span v-if="!isObject(error)">{{
                                              error
                                          }}</span>
                                        </div>
                                      </div>
                                      <div class="row col-md-12">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="form-group col-md-4">
                                              <label class="col-md-12 control-label">ID No.<sup
                                                  style="color: red; top: -2px">*</sup></label>
                                              <!-- <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                              <input  v-model="form_data.employee_id_no" class="form-control" required="true" placeholder="000000" type="text" readonly>
                                              <input  v-model="form_data.employee_number" class="form-control" required="true" type="hidden">
                                              </div>
                                          </div> -->
                                          <!-- emplyeeIDEdit -->
                                          <!-- this.$route.params.employeeId != 0 -->
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                " v-if="emplyeeIdEditeValue ==0">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-user
                                                      "></i></span>
                                                  <input v-model="
                                                    form_data.employee_id_no
                                                  " class="form-control" required="true" placeholder="000000"
                                                    type="text" readonly />
                                                  <input v-model="
                                                    form_data.employee_number
                                                  " class="form-control" required="true" type="hidden" />
                                                  <a class="" @click="emplyeeIDEdit($event)" title="Add More Data"><i class="fa fa-edit" style="padding-right: 6px;"></i></a>
                                                </div>

                                              </div>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                " v-else>
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-user
                                                      "></i></span>
                                                  <input v-model="
                                                    form_data.employee_id_no
                                                  " class="form-control" required="true" placeholder="000000"
                                                    type="text" />
                                                  <input v-model="
                                                    form_data.employee_number
                                                  " class="form-control" required="true" type="hidden" />
                                                  <a class="" @click="emplyeeIDEdit($event)" title="Add More Data"><i class="fa fa-edit" style="padding-right: 6px;"></i></a>
                                                </div>

                                              </div>
                                            </div>
                                            <div class="form-group col-md-8">
                                              <label class="col-md-12 control-label">Full Name
                                                <sup style="color: red; top: -2px">*</sup></label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group background-shed">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-user
                                                      "></i></span>
                                                  <input v-model="
                                                    form_data.employee_fullname
                                                  " class="form-control" required="true" type="text" />
                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="form-group col-md-6">
                                              <label class="col-md-12 control-label">Father's Name
                                              </label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-user
                                                      "></i></span>
                                                  <input v-model="
                                                    form_data.employee_father_name
                                                  " class="form-control" type="text" />
                                                </div>
                                              </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <label class="
                                                    col-md-12
                                                    control-label
                                                  ">Mother's Name
                                                </label>
                                                <div class="
                                                    col-md-12
                                                    inputGroupContainer
                                                  ">
                                                  <div class="input-group">
                                                    <span class="input-group-addon"><i class="
                                                          glyphicon
                                                          glyphicon-user
                                                        "></i></span>
                                                    <input v-model="
                                                      form_data.employee_mother_name
                                                    " class="form-control" type="text" />
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="form-group col-md-4">
                                              <label class="col-md-12 control-label">Marital Status
                                                <sup style="color: red; top: -2px">*</sup>
                                              </label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group background-shed">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-user
                                                      "></i></span>
                                                  <select @change="
                                                    selectMarried($event)
                                                  " v-model="
  form_data.employee_marital_status
" name="employee_status" class="
                                                      selectpicker
                                                      form-control
                                                    ">
                                                    <option value="0">
                                                      Select
                                                    </option>
                                                    <option value="1">
                                                      Single
                                                    </option>
                                                    <option value="2">
                                                      Married
                                                    </option>
                                                    <option value="3">
                                                      Widowed
                                                    </option>
                                                    <option value="4">
                                                      Divorced
                                                    </option>
                                                    <option value="5">
                                                      Separated
                                                    </option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <label class="
                                                    col-md-12
                                                    control-label
                                                  ">Gender
                                                  <sup style="
                                                      color: red;
                                                      top: -2px;
                                                    ">*</sup>
                                                </label>
                                                <div class="
                                                    col-md-12
                                                    inputGroupContainer
                                                  ">
                                                  <div class="input-group background-shed">
                                                    <span class="input-group-addon"><i class="
                                                          glyphicon
                                                          glyphicon-user
                                                        "></i></span>
                                                    <select v-model="
                                                      form_data.employee_gender
                                                    " class="
                                                        selectpicker
                                                        form-control
                                                      ">
                                                      <option value="0">
                                                        Select
                                                      </option>
                                                      <option value="1">
                                                        Female
                                                      </option>
                                                      <option value="2">
                                                        Male
                                                      </option>
                                                      <option value="3">
                                                        Others
                                                      </option>
                                                    </select>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <label class="
                                                    col-md-12
                                                    control-label
                                                  ">Blood Group
                                                  <sup style="
                                                      color: red;
                                                      top: -2px;
                                                    ">*</sup>
                                                </label>
                                                <div class="
                                                    col-md-12
                                                    inputGroupContainer
                                                  ">
                                                  <div class="input-group background-shed">
                                                    <span class="input-group-addon"></span>
                                                    <select v-model="
                                                      form_data.employee_blood_group
                                                    " class="
                                                        selectpicker
                                                        form-control
                                                      ">
                                                      <option value="0">
                                                        Select
                                                      </option>
                                                      <option value="A(+ve)">
                                                        A(+ve)
                                                      </option>
                                                      <option value="A(-ve)">
                                                        A(-ve)
                                                      </option>
                                                      <option value="B(+ve)">
                                                        B(+ve)
                                                      </option>
                                                      <option value="B(-ve)">
                                                        B(-ve)
                                                      </option>
                                                      <option value="O(+ve)">
                                                        O(+ve)
                                                      </option>
                                                      <option value="O(-ve)">
                                                        O(-ve)
                                                      </option>
                                                      <option value="AB(+ve)">
                                                        AB(+ve)
                                                      </option>
                                                      <option value="AB(-ve)">
                                                        AB(-ve)
                                                      </option>
                                                      <option value="N/A">
                                                        N/A
                                                      </option>
                                                    </select>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                              <label class="col-md-12 control-label">Designation <sup
                                                  style="color: red; top: -2px">*</sup></label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group background-shed">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-home
                                                      "></i></span>
                                                  <vue-select v-model="
                                                    designation_name_value
                                                  " :options="
  form_data.designation_data
" @select="
  onSelectDesignation
" placeholder="Select one" label="text" track-by="text">
                                                  </vue-select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                              <label class="col-md-4 control-label">Job Grade <sup
                                                  style="color: red; top: -2px">*</sup> </label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group background-shed">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-home
                                                      "></i></span>
                                                  <vue-select v-model="
                                                    jobgrade_name_value
                                                  " :options="
  form_data.jobgrade_data
" @select="onSelectJobGrade" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="col-md-4 control-label">Company/SBU
                                              <sup style="color: red; top: -2px">*</sup></label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group background-shed">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <vue-select v-model="
                                                  form_data.sbu_name_value
                                                " :options="
  form_data.company_sbu_data
" @select="employeesSbu1" placeholder="Select one" label="text" track-by="text"></vue-select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="form-group col-md-6">
                                              <label class="col-md-4 control-label">Unit</label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-home
                                                      "></i></span>
                                                  <vue-select v-model="
                                                    form_data.unit_value
                                                  " :options="
  form_data.unit_data
" @select="employeesUnit1" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                              <label class="col-md-4 control-label">Sub Unit<sup style="color: red; top: -2px"> *</sup></label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group background-shed">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-home
                                                      "></i></span>
                                                  <vue-select v-model="sub_unit_value" :options="
                                                    form_data.sub_unit_data
                                                  " @select="employeesSubUnit1" placeholder="Select one" label="text"
                                                    track-by="text"></vue-select>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-4 control-label">Department
                                              <sup style="color: red; top: -2px">*</sup></label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group background-shed">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <vue-select v-model="
                                                  department_name_value
                                                " :options="
  form_data.department_data
" @select="onSelectDepartment1" placeholder="Select one" label="text" track-by="text"></vue-select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="form-group col-md-6">
                                              <label class="col-md-12 control-label">Section</label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-home
                                                      "></i></span>
                                                  <vue-select v-model="form_data.section_value" :options="
                                                    form_data.section_data
                                                  " @select="employeesSection1" placeholder="Select one" label="text"
                                                    track-by="text"></vue-select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                              <label class="col-md-12 control-label">Sub Section</label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-home
                                                      "></i></span>
                                                  <vue-select v-model="
                                                    form_data.sub_section_value
                                                  " :options="
  form_data.sub_section_data
" @select="
  employeesSubSection1
" placeholder="Select one" label="text" track-by="text">
                                                  </vue-select>
                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="form-group col-md-4">
                                              <label class="col-md-12 control-label">Work Location</label>
                                              <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                                <div class="input-group">
                                                  <span class="input-group-addon">
                                                      <i class="glyphicon glyphicon-envelope "></i>
                                                  </span>
                                                  <vue-select
                                                      v-model="work_location_value"
                                                      :options="form_data.work_location_data"
                                                      @select="employeesWorkLocation1"
                                                      placeholder="Select one" label="text" track-by="text"
                                                  ></vue-select>
                                                </div>
                                              </div>
                                            </div>

                                              <div class="form-group col-md-4">
                                                  <label class="col-md-4 control-label">Floors</label>
                                                  <div class="col-md-12 inputGroupContainer">
                                                      <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                      glyphicon
                                                      glyphicon-envelope
                                                    "></i></span>
                                                          <vue-select
                                                              v-model="floor_value"
                                                              :options="form_data.floors"
                                                              @select="selectFloor"
                                                              placeholder="Select one"
                                                              label="text" track-by="text"
                                                          ></vue-select>
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="form-group col-md-4">
                                                  <label class="control-label">Work Area</label>
                                                  <div class="col-md-12 inputGroupContainer">
                                                      <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                      glyphicon
                                                      glyphicon-envelope
                                                    "></i></span>
                                                          <vue-select v-model="work_area_value" :options="
                                                    form_data.work_area_data
                                                  " @select="
  employeesArea
" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="row">
                                            <div class="form-group col-md-6">
                                              <label class="col-md-12 control-label">Employee Type <sup
                                                  style="color: red; top: -2px">*</sup> </label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group background-shed">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon
                                                        glyphicon-envelope
                                                      "></i></span>

                                                  <select v-model="
                                                    form_data.employee_type
                                                  " @change="employee_typeChange($event)"  name="employee_type" class="
                                                      selectpicker
                                                      form-control
                                                    ">
                                                    <option>--Select--</option>
                                                    <option value="1">
                                                      Permanent
                                                    </option>
                                                    <option value="2">
                                                      Probationary
                                                    </option>
                                                    <option value="3">
                                                      Cotractual
                                                    </option>
                                                    <option value="6">
                                                      Casual
                                                    </option>
                                                    <option value="4">
                                                      Temporary
                                                    </option>
                                                    <option value="5">
                                                      Intern
                                                    </option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                              <label class="col-md-12 control-label">Employee Type ( বাংলা )</label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-user
                                                      "></i></span>
                                                  <!-- @click="joining_dateSelected($event.target)"  v-on:input="joining_dateSelected($event.target)" v-on:keyup="joining_dateSelected($event.target)"  -->
                                                  <select v-model="
                                                    form_data.employee_type_bangla
                                                  " name="employee_type_bangla" class="
                                                      selectpicker
                                                      form-control
                                                    ">
                                                    <option>--Select--</option>
                                                    <option value="1"> Permanent - স্থায়ী</option>
                                                    <option value="2">Probationary - শিক্ষানবিস</option>
                                                    <option value="3"> Cotractual - চুক্তিভিত্তিক</option>
                                                    <option value="6">Casual - সাময়িক</option>
                                                    <option value="4">Temporary - অস্থায়ী</option>
                                                    <option value="5">Intern - ইর্ন্টান</option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="form-group col-md-3" v-if="
                                              form_data.employee_type != 1
                                            " style="margin-left: 8px;">
                                              <label class="col-md-12 control-label" style="padding: 0px">
                                              Prob./Cont. Period</label>
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-user
                                                    "></i></span>
                                                <!-- @click="joining_dateSelected($event.target)"  v-on:input="joining_dateSelected($event.target)" v-on:keyup="joining_dateSelected($event.target)"  -->
                                                <input v-model="
                                                  form_data.employee_due_month
                                                " v-on:keyup="
  employeeType($event.target)
" class="form-control" type="text" />
                                              </div>
                                            </div>
                                            <div class="form-group col-md-3" v-if="
                                              form_data.employee_type != 1
                                            ">
                                              <label class="col-md-12 control-label">Due Date</label>
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-user
                                                    "></i></span>
                                                <datepicker placeholder="Select Date" v-model="
                                                  form_data.employee_confirmation_due_date
                                                " class="form-control"></datepicker>
                                                <!-- <input  v-model="form_data.employee_confirmation_due_date" readonly class="form-control" required="true" type="text"> -->
                                              </div>
                                            </div>

                                          </div>

                                          <div class="row">
                                            <div class="form-group col-md-8">
                                              <label class="col-md-12 control-label">Employee Group</label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon
                                                        glyphicon-envelope
                                                      "></i></span>
                                                  <vue-select v-model="
                                                    form_data.employee_group_value
                                                  " :options="
  form_data.employee_group_data
" @select="employeesGroup1" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                              <label class="col-md-12 control-label">Leave Group</label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon
                                                        glyphicon-envelope
                                                      "></i></span>
                                                  <select v-model="
                                                    form_data.employee_leave_group
                                                  " class="
                                                      selectpicker
                                                      form-control
                                                    ">
                                                    <option>--Select--</option>
                                                    <option value="1">
                                                      General
                                                    </option>
                                                    <option value="2">
                                                      Special
                                                    </option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                          <div v-if="form_data.make_user == 1" class="row">
                                            <div class="form-group col-md-6">
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                " style="margin-top: 15px">
                                                <label class="
                                                    col-md-12
                                                    control-label
                                                  " style="padding-left: 0px">
                                                  <div class="input-group">
                                                    <span class="input-group-addon"><i class="
                                                          glyphicon
                                                          glyphicon-envelope
                                                        "></i></span>
                                                    <input type="checkbox" style="
                                                        margin: 5px 5px 0 0;
                                                      " checked @input="addEvent" @change="addEvent" />
                                                    Enable Portal User?
                                                  </div>
                                                </label>
                                              </div>
                                            </div>
                                            <div v-if="form_data.make_user == 1" id="user_type_id"
                                              class="form-group col-md-6" style="padding-left: 0px">
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                " style="margin-top: 15px">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon
                                                        glyphicon-envelope
                                                      "></i></span>
                                                  <select v-model="
                                                    form_data.user_type
                                                  " name="employee_status" class="
                                                      selectpicker
                                                      form-control
                                                    ">
                                                    <option value="0">
                                                      -- User Type --
                                                    </option>
                                                    <option v-if="
                                                      form_data.role_id <= 1
                                                    " value="1">
                                                      Group User
                                                    </option>
                                                    <option v-if="
                                                      form_data.role_id <= 2
                                                    " value="2">
                                                      SBU/Company User
                                                    </option>
                                                    <option v-if="
                                                      form_data.role_id <= 3
                                                    " value="3">
                                                      Unit User
                                                    </option>
                                                    <option v-if="
                                                      form_data.role_id <= 4
                                                    " value="4">
                                                      Sub Unit User
                                                    </option>
                                                    <option v-if="
                                                      form_data.role_id <= 5
                                                    " value="5">
                                                      Department User
                                                    </option>
                                                    <option v-if="
                                                      form_data.role_id <= 6
                                                    " value="6">
                                                      Section User
                                                    </option>
                                                    <option v-if="
                                                      form_data.role_id <= 7
                                                    " value="7">
                                                      Sub Section User
                                                    </option>
                                                    <option v-if="
                                                      form_data.role_id <= 8
                                                    " value="8">
                                                      Employee User
                                                    </option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row" v-else>
                                            <div class="form-group col-md-6">
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                " style="margin-top: 15px">
                                                <label class="
                                                    col-md-12
                                                    control-label
                                                  " style="padding-left: 0px">
                                                  <div class="input-group">
                                                    <span class="input-group-addon"><i class="
                                                          glyphicon
                                                          glyphicon-envelope
                                                        "></i></span>
                                                    <input type="checkbox" style="
                                                        margin: 5px 5px 0 0;
                                                      " @input="addEvent" @change="addEvent" />
                                                    Enable Portal User?
                                                  </div>
                                                </label>
                                              </div>
                                            </div>
                                            <div v-if="make_user == 1" id="user_type_id" class="form-group col-md-6"
                                              style="padding-left: 0px">
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                " style="
                                                  margin-top: 15px;
                                                  padding: 0px;
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon
                                                        glyphicon-envelope
                                                      "></i></span>
                                                  <select v-model="
                                                    form_data.user_type
                                                  " name="employee_status" class="
                                                      selectpicker
                                                      form-control
                                                    ">
                                                    <option value="0">
                                                      -- User Type --
                                                    </option>
                                                    <option value="1">
                                                      Group User
                                                    </option>
                                                    <option value="2">
                                                      SBU/Company User
                                                    </option>
                                                    <option value="3">
                                                      Unit User
                                                    </option>
                                                    <option value="4">
                                                      Sub Unit User
                                                    </option>
                                                    <option value="5">
                                                      Department User
                                                    </option>
                                                    <option value="6">
                                                      Section User
                                                    </option>
                                                    <option value="7">
                                                      Sub Section User
                                                    </option>
                                                    <option value="8">
                                                      Employee User
                                                    </option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group" style="margin-bottom: 5px">
                                            <div class="row inputGroupContainer">
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label class="
                                                      col-md-12
                                                      control-label
                                                    " style="padding: 0px">Office Time</label>
                                                  <div class="
                                                      col-md-12
                                                      inputGroupContainer
                                                    " style="padding: 0px">
                                                    {{ shift_time }}
                                                    <div class="input-group" v-if="
                                                      form_data.shift_time ==
                                                      ''
                                                    ">
                                                      <span class="
                                                          input-group-addon
                                                        ">
                                                        <i class="
                                                            glyphicon
                                                            glyphicon-home
                                                          "></i>
                                                      </span>
                                                      <span v-if="shift_time != ''">
                                                        {{ shift_time }}
                                                      </span>
                                                      <span v-else>
                                                        <span class="
                                                            input-group-addon
                                                          ">
                                                          <i class="
                                                              glyphicon
                                                              glyphicon-home
                                                            "></i>
                                                        </span>
                                                        {{ "00:00:00" }}
                                                      </span>
                                                    </div>
                                                    <div class="input-group" v-else>
                                                      <span class="
                                                          input-group-addon
                                                        ">
                                                        <i class="
                                                            glyphicon
                                                            glyphicon-home
                                                          "></i>
                                                      </span>
                                                      <span>
                                                        {{
                                                            form_data.shift_time
                                                        }}
                                                      </span>
                                                    </div>
                                                  </div>
                                                </div>
                                                <label class="
                                                    col-md-12
                                                    control-label
                                                  " style="
                                                    padding: 0px;
                                                    padding-left: 0px;
                                                  ">Image Upload</label>
                                                <div class="
                                                    input-group
                                                    file-upload-form
                                                  ">
                                                  <input type="file" v-on:change="onFileChange" style="
                                                      text-overflow: ellipsis;
                                                      overflow: hidden;
                                                      white-space: nowrap;
                                                    " accept="image/*" />
                                                </div>
                                                <label class="
                                                    col-md-12
                                                    control-label
                                                  " style="
                                                    padding-left: 0px;
                                                    margin-top: 15px;
                                                  ">Employee Category <sup
                                                  style="color: red; top: -2px">*</sup> </label>
                                                <div class="
                                                    col-md-12
                                                    inputGroupContainer
                                                  " style="padding: 0px">
                                                  <div class="input-group background-shed">
                                                    <span class="input-group-addon"><i class="
                                                          glyphicon
                                                          glyphicon-envelope
                                                        "></i></span>
                                                    <select v-model="
                                                      form_data.emplyee_category_mgt_non_mgt
                                                    " name="employee_status" class="
                                                        selectpicker
                                                        form-control
                                                      ">
                                                      <option>
                                                        --Select--
                                                      </option>
                                                      <option value="1">
                                                        Management
                                                      </option>
                                                      <option value="2">
                                                        Non-Management
                                                      </option>
                                                    </select>
                                                  </div>
                                                </div>
                                                <label class="
                                                    col-md-12
                                                    control-label
                                                  " style="
                                                    padding-left: 0px;
                                                    margin-top: 15px;
                                                  ">Religion <sup
                                                  style="color: red; top: -2px">*</sup></label>
                                                <div class="
                                                    col-md-12
                                                    inputGroupContainer
                                                  " style="padding: 0px">
                                                  <div class="input-group background-shed">
                                                    <span class="input-group-addon"><i class="
                                                          glyphicon
                                                          glyphicon-envelope
                                                        "></i></span>
                                                    <select v-model="
                                                      form_data.employee_religion
                                                    " class="
                                                        selectpicker
                                                        form-control
                                                      ">
                                                      <option value="0">
                                                        Select
                                                      </option>
                                                      <option value="1">
                                                        Islam
                                                      </option>
                                                      <option value="2">
                                                        Hinduism
                                                      </option>
                                                      <option value="3">
                                                        Christianity
                                                      </option>
                                                      <option value="4">
                                                        Buddhism
                                                      </option>
                                                    </select>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-md-6" style="margin-bottom: 0px">
                                                <div class="
                                                    image-preview
                                                    text-center
                                                    col-md-12
                                                  " style="right: -27px">
                                                  <samp v-if="
                                                    form_data.employee_image
                                                  ">
                                                    <img :src="`images/${form_data.employee_image}`" class="
                                                        card-img-top
                                                        border
                                                        rounded
                                                      " style="
                                                        margin-top: 2px;
                                                        width: 130px;
                                                        height: 157px;
                                                      " />
                                                  </samp>
                                                  <samp v-else>
                                                    <img v-if="
                                                      url !== '' ||
                                                      form_data.employee_image !==
                                                      ''
                                                    " :src="`images/default.png`" class="
                                                        card-img-top
                                                        border
                                                        rounded
                                                      " style="
                                                        margin-top: 2px;
                                                        width: 130px;
                                                        height: 157px;
                                                      " />
                                                  </samp>
                                                  <div class="
                                                      col-md-12
                                                      text-center
                                                    " style="
                                                      margin-top: 0px;
                                                      padding-left: 0px;
                                                    ">
                                                    <label class="switch" v-if="
                                                      form_data.employee_status ==
                                                      1 ||
                                                      form_data.employee_status ==
                                                      0 ||
                                                      form_data.employee_status ==
                                                      ' '
                                                    ">
                                                      <input type="checkbox" v-model="
                                                        form_data.employee_status
                                                      " checked />
                                                      <span class="slider round"></span>
                                                    </label>
                                                    <label class="switch" v-if="
                                                      form_data.employee_status ==
                                                      2
                                                    ">
                                                      <input type="checkbox" v-model="
                                                        separation_status
                                                      " checked />
                                                      <span class="slider round"></span>
                                                    </label>
                                                    <label v-if="
                                                      form_data.employee_status ==
                                                      1
                                                    ">Active</label>
                                                    <label v-if="
                                                      form_data.employee_status ==
                                                      0
                                                    ">Inactive</label>
                                                    <label v-if="
                                                      form_data.employee_status ==
                                                      2
                                                    ">Separation</label>
                                                     <label v-if="
                                                      form_data.employee_status ==
                                                      3
                                                    ">New Joining</label>


                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="form-group col-md-6">
                                              <label class="col-md-12 control-label">Date of Birth (Certificate)
                                                <sup style="color: red; top: -2px">*</sup></label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group background-shed">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-home
                                                      "></i></span>
                                                  <input class="form-control"
                                                  @click="
                                                    dateoOfBirth_dateSelected(
                                                      $event.target
                                                    )
                                                  " v-on:input="
                                                  dateoOfBirth_dateSelected(
                                                      $event.target
                                                    )
                                                  " v-on:keyup="
                                                  dateoOfBirth_dateSelected(
                                                      $event.target
                                                    )
                                                  "
                                                  v-model="form_data.employee_dob_certificate" type="date" ref="input" />
                                                </div>
                                                <!-- <div class="input-group"> -->
                                                <!-- <input
                                                  class="form-control"
                                                  v-model="
                                                    form_data.employee_dob_certificate
                                                  "
                                                  type="date"
                                                  ref="input"
                                                /> -->
                                                <!-- <datepicker
                                                    placeholder="Select Date"
                                                    style="
                                                      width: 131% !important;
                                                    "
                                                    v-model="
                                                      form_data.employee_dob_certificate
                                                    "
                                                    class="form-control"
                                                  ></datepicker> -->
                                                <!-- </div> -->
                                              </div>
                                              &nbsp &nbsp &nbsp Age : {{ages}} Years
                                            </div>
                                            <div class="form-group col-md-6">
                                              <label class="col-md-12 control-label">Date of Birth (Actual)
                                              </label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-home
                                                      "></i></span>
                                                  <input class="form-control" v-model="
                                                    form_data.employee_dob_actual
                                                  " type="date" ref="input" />
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                              <label class="col-md-12 control-label">Interview Date</label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <datepicker placeholder="Select Date" v-model="
                                                    form_data.employee_interview_date
                                                  " class="form-control"></datepicker>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                              <label class="col-md-12 control-label">Appoinment Date</label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <datepicker placeholder="Select Date" v-model="
                                                    form_data.employee_appoinment_date
                                                  " class="form-control"></datepicker>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                              <label class="col-md-12 control-label">Joining Date <sup
                                                  style="color: red; top: -2px">*</sup> </label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group background-shed">
                                                  <datepicker placeholder="Select Date" @click="
                                                    joining_dateSelected(
                                                      $event.target
                                                    )
                                                  " v-on:input="
                                                    joining_dateSelected(
                                                      $event.target
                                                    )
                                                  " v-on:keyup="
                                                    joining_dateSelected(
                                                      $event.target
                                                    )
                                                  " v-model="
                                                    form_data.employee_joining_date
                                                  " class="form-control"></datepicker>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="form-group col-md-6">
                                              <label class="col-md-12 control-label">Mobile No.(Personal)</label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon" style="max-width: 100%"><i class="
                                                        glyphicon glyphicon-list
                                                      "></i></span>
                                                  <input v-model="
                                                    form_data.employee_mobile
                                                  " id="mobile_number" name="mobile_number" placeholder=""
                                                    class="form-control" type="text" />
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                              <label class="col-md-12 control-label">Mobile No. (Official)</label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-home
                                                      "></i></span>
                                                  <input v-model="
                                                    form_data.official_mobile_no
                                                  " placeholder="" class="form-control" type="text" />
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="form-group col-md-8">
                                              <label class="col-md-12 control-label">Email ID (Official)</label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-home
                                                      "></i></span>
                                                  <input v-model="
                                                    form_data.official_email_id
                                                  " placeholder="" class="form-control" type="email" />
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                              <label class="col-md-12 control-label">PABX Number</label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-home
                                                      "></i></span>
                                                  <input v-model="
                                                    form_data.desk_phone_no
                                                  " placeholder="" class="form-control" type="number" />
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-6 control-label">Reporting to/Superior <sup
                                                  style="color: red; top: -2px">*</sup> </label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group background-shed">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon
                                                      glyphicon-earphone
                                                    "></i></span>
                                                <vue-select v-model="employee_name_value" :options="
                                                  form_data.employee_data
                                                " @select="onSelectEmployee1" placeholder="Select one" label="text"
                                                  track-by="text"></vue-select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="form-group col-md-4">
                                              <label class="col-md-12 control-label">Salary Cycle <sup
                                                  style="color: red; top: -2px">*</sup> </label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group background-shed">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon
                                                        glyphicon-envelope
                                                      "></i></span>
                                                  <select v-model="
                                                    form_data.salary_duration_type
                                                  " class="
                                                      selectpicker
                                                      form-control
                                                    " required>
                                                    <option>--Select--</option>
                                                    <option value="1">
                                                      Weekly
                                                    </option>
                                                    <option value="2">
                                                      Monthly
                                                    </option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                              <label class="col-md-12 control-label">Attendance Bonus <sup
                                                  style="color: red; top: -2px">*</sup>  </label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group background-shed">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon
                                                        glyphicon-envelope
                                                      "></i></span>
                                                  <select v-model="
                                                    form_data.attendance_bonus_get
                                                  " class="
                                                      selectpicker
                                                      form-control
                                                    " required>
                                                    <option>--Select--</option>
                                                    <option value="1">
                                                      Yes
                                                    </option>
                                                    <option value="2">
                                                      No
                                                    </option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                              <label class="col-md-12 control-label">Employee salary type <sup
                                                  style="color: red; top: -2px">*</sup>  </label>
                                              <div class="
                                                  col-md-12
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group background-shed">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon
                                                        glyphicon-envelope
                                                      "></i></span>
                                                  <select v-model="
                                                    form_data.employee_salary_type
                                                  " class="
                                                      selectpicker
                                                      form-control
                                                    " required>
                                                    <option>--Select--</option>
                                                    <option value="1">
                                                      Time Based
                                                    </option>
                                                    <option value="2">
                                                      Production Based
                                                    </option>
                                                    <option value="3">
                                                      Residential Based
                                                    </option>
                                                    <option value="4">
                                                      Attendance Based
                                                    </option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                            <!-- Employee id card information -->
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="col-md-12 control-label">ID Card (Proximity No.)</label>
                                                    <div class="col-md-12 inputGroupContainer">
                                                        <div class="input-group ">
                                                            <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-user"></i>
                                                            </span>
                                                            <input v-model="form_data.proximity_no" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label class="col-md-12 control-label">Finger Print</label>
                                                    <div class="col-md-12 inputGroupContainer ">
                                                        <div class="input-group ">
                                                            <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-envelope"></i>
                                                            </span>
                                                            <select v-model="form_data.finger_print" class="selectpicker form-control">
                                                                <option>--Select--</option>
                                                                <option value="1">Yes</option>
                                                                <option value="2">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Employee id card information -->


                                        </div>
                                        <div class="form-group col-md-12">
                                          <br />
                                          <label class="col-md-12 control-label" style="margin-bottom: 5px">
                                            Approval Level
                                          </label>
                                          <div class="
                                              col-md-11
                                              inputGroupContainer
                                              float-left
                                            " style="margin-bottom: 5px">
                                            <div class="input-group">
                                              <span class="input-group-addon"><i class="
                                                    glyphicon glyphicon-envelope
                                                  "></i></span>
                                              <vue-select v-model="approvalnamevalue1" :options="
                                                form_data.employee_data_approval
                                              " @select="
  onSelectEmployeeApproval
" placeholder="Select one" label="text" track-by="text"></vue-select>
                                            </div>
                                          </div>
                                          <div class="col-md-1 float-right" style="margin-bottom: 5px">
                                            <a @click="
                                              addRow(
                                                $event,
                                                form_data.approval_infos,
                                                form_data.approve_by,
                                                employees_ids,
                                                employeesName
                                              )
                                            " id="addCF" class="btn btn-xs btn-success"><i class="fa fa-plus"
                                                style="color: #fff"></i></a>
                                          </div>
                                          <br />
                                          <table class="" style="width: 95%; margin-top: 44px">
                                            <tr class="text-center" style="
                                                border-bottom: 1px solid #cfcfcf;
                                                background: rgb(207, 207, 207);
                                              ">
                                              <th width="3">Level</th>
                                              <th width="10">ID</th>
                                              <th width="10">Name</th>
                                              <th width="40"></th>
                                            </tr>
                                            <tr style="border: 1px solid #cfcfcf" v-for="(
                                                formData, index
                                              ) in form_data.approval_infos" :key="index" v-if="
                                                formData.employees_ids != ''
                                              ">
                                              <td style="text-align: center">
                                                {{ index + 1 }}
                                              </td>
                                              <td style="text-align: center">
                                                {{ formData.employees_ids }}
                                              </td>
                                              <td>
                                                {{
                                                    formData.ea_approve_by_name
                                                }}
                                              </td>
                                              <td style="text-align: right">
                                                <a @click="deleteRow(index)" id="remCF" class="btn btn-xs btn-danger"><i
                                                    class="fa fa-times"></i></a>
                                              </td>
                                            </tr>
                                          </table>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-actions" style="margin-top: 5px">
                                      <button type="submit" class="btn-disabled btn btn-info float-right" style="margin-left: 10px">
                                        Save
                                      </button>
                                    </div>
                                  </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="personalinfo">
                                  <div class="
                                      alert alert-success alert-dismissable
                                    " style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                      Ã—
                                    </button>
                                    <span id="submitxt"></span>
                                  </div>
                                  <h6 class="col-md-12" style="padding: 10px 6px">
                                    Personal Information
                                  </h6>
                                  <div class="">
                                    <form class="
                                        well
                                        form-horizontal
                                        needs-validation
                                        personal-info
                                      " @submit.prevent="
                                        EmployAdd({
                                          add: 'employees/personal-info-store',
                                        })
                                      ">
                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">NID/Certificate Name
                                              <sup style="color: red; top: -2px">*</sup></label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-user
                                                    "></i></span>
                                                <input v-if="
                                                  form_data.employee_nid_name
                                                " v-model="
  form_data.employee_nid_name
" required class="form-control" type="text" />
                                                <input v-else v-model="
                                                  form_data.employee_fullname
                                                " required class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">
                                              Name ( বাংলা )
                                            </label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-user
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.employee_nid_name_bangla
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Father's Name</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.employee_father_name
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Father's Name ( বাংলা )</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.employee_father_name_bangla
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Date of Birth(Certificate)</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input class="form-control" v-model="
                                                  form_data.employee_dob_certificate
                                                " type="date" ref="input" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Marital Status</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <select @change="
                                                  selectMarried($event)
                                                " v-model="
  form_data.employee_marital_status
" name="employee_status" class="
                                                    selectpicker
                                                    form-control
                                                  ">
                                                  <option value="0">
                                                    Select
                                                  </option>
                                                  <option value="1">
                                                    Single
                                                  </option>
                                                  <option value="2">
                                                    Married
                                                  </option>
                                                  <option value="3">
                                                    Widowed
                                                  </option>
                                                  <option value="4">
                                                    Divorced
                                                  </option>
                                                  <option value="5">
                                                    Separated
                                                  </option>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                          <div v-if="
                                            form_data.employee_marital_status ==
                                            2
                                          " class="form-group">
                                            <label class="col-md-12 control-label">Spouse Name</label>
                                            <div class="col-md-12">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.employee_spouse_name
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Gender</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <select v-model="
                                                  form_data.employee_gender
                                                " class="
                                                    selectpicker
                                                    form-control
                                                  ">
                                                  <option value="0">
                                                    Select
                                                  </option>
                                                  <option value="1">
                                                    Female
                                                  </option>
                                                  <option value="2">
                                                    Male
                                                  </option>
                                                  <option value="3">
                                                    Others
                                                  </option>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Nationality</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.employee_nationality
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Blood Group</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <select v-model="
                                                  form_data.employee_blood_group
                                                " class="
                                                    selectpicker
                                                    form-control
                                                  ">
                                                  <option value="0">
                                                    Select
                                                  </option>
                                                  <option value="A(+ve)">
                                                    A(+ve)
                                                  </option>
                                                  <option value="A(-ve)">
                                                    A(-ve)
                                                  </option>
                                                  <option value="B(+ve)">
                                                    B(+ve)
                                                  </option>
                                                  <option value="B(-ve)">
                                                    B(-ve)
                                                  </option>
                                                  <option value="O(+ve)">
                                                    O(+ve)
                                                  </option>
                                                  <option value="O(-ve)">
                                                    O(-ve)
                                                  </option>
                                                  <option value="AB(+ve)">
                                                    AB(+ve)
                                                  </option>
                                                  <option value="AB(-ve)">
                                                    AB(-ve)
                                                  </option>
                                                  <option value="N/A">
                                                    N/A
                                                  </option>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Email</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.employee_email
                                                " class="form-control" type="email" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">WhatsApp</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.whats_app_no
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Nick Name</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-user
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.employee_nick_name
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Mother’s Name</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.employee_mother_name
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Mother’s Name ( বাংলা )</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.employee_mother_name_bangla
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Date of Birth(Actual)</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input class="form-control" v-model="
                                                  form_data.employee_dob_actual
                                                " type="date" ref="input" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group" v-if="
                                            form_data.employee_marital_status ==
                                            2
                                          ">
                                            <label class="col-md-12 control-label">Marriage Date</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input class="form-control" v-model="
                                                  form_data.employee_marriage_date
                                                " type="date" ref="input" />
                                              </div>
                                            </div>
                                          </div>
                                          <div v-if="
                                            form_data.employee_marital_status ==
                                            2
                                          " class="form-group">
                                            <label class="col-md-12 control-label">No. of Children</label>
                                            <div class="col-md-12">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.employee_children_no
                                                " class="form-control" type="number" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Religion</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <select v-model="
                                                  form_data.employee_religion
                                                " class="
                                                    selectpicker
                                                    form-control
                                                  ">
                                                  <option value="0">
                                                    Select
                                                  </option>
                                                  <option value="1">
                                                    Islam
                                                  </option>
                                                  <option value="2">
                                                    Hinduism
                                                  </option>
                                                  <option value="3">
                                                    Christianity
                                                  </option>
                                                  <option value="4">
                                                    Buddhism
                                                  </option>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Height</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="
                                                  col-md-6
                                                  input-group
                                                  float-left
                                                " style="padding-left: 0px">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.employee_feet
                                                " class="form-control" type="number" placeholder="Feet" />
                                              </div>
                                              <div class="
                                                  col-md-6
                                                  input-group
                                                  float-right
                                                ">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.employee_inch
                                                " class="form-control" type="number" placeholder="Inch" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group" style="margin-top: 30px">
                                            <label class="col-md-12 control-label">Weight (kg)</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.employee_weight
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Skype</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="form_data.skype_no" class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="form-group col-md-4 ">
                                              <label class="control-label">Salary</label>
                                              <div class="
                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-home
                                                      "></i></span>
                                                  <input v-model="form_data.gross_salary_bangla" class="form-control"
                                                    type="number" />
                                                </div>
                                              </div>
                                            </div>

                                            <div class="form-group col-md-8 ">
                                              <label class=" control-label">Salary Inword (বাংলা)</label>
                                              <div class="

                                                  inputGroupContainer
                                                ">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="
                                                        glyphicon glyphicon-home
                                                      "></i></span>
                                                  <input v-model="form_data.gross_salary_bangla_text"
                                                    class="form-control" type="text" />
                                                </div>
                                              </div>
                                            </div>


                                          </div>
                                          <div style="margin-top: 15px">
                                            <button type="submit" class="btn btn-info float-right"
                                              style="margin-left: 10px">
                                              Save
                                            </button>
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="addressdetails">
                                  <div class="
                                      alert alert-success alert-dismissable
                                    " style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                      Ã—
                                    </button>
                                    <span id="submitxt"></span>
                                  </div>
                                  <h6 class="col-md-12" style="padding: 10px 6px">
                                    Address Details
                                  </h6>
                                  <div class="">
                                    <form class="
                                        well
                                        form-horizontal
                                        needs-validation
                                      " @submit.prevent="
                                        EmployAdd({
                                          add: 'employees/addressdetails',
                                        })
                                      ">
                                      <div class="row">
                                        <div class="col-md-6">
                                          <h6 style="
                                              padding: 8px;
                                              border: 1px solid #ccc;
                                            ">
                                            Present Contact/ Mailing/ Residence
                                          </h6>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Holding/House No:
                                              <sup style="color: red; top: -2px">*</sup></label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-user
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.present_holding_no
                                                " id="fullName" name="fullName" class="form-control"
                                                  placeholder="Holding/House No" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">House Name:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.present_house_name
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Road No.</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.present_road_no
                                                    " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Road Name:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.present_road_name
                                                    " placeholder="" class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Vill. / Area:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.present_vill_area
                                                    " placeholder="" class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Ward No.:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.present_ward_no
                                                    " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">District:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <vue-select v-model="
                                                  form_data.present_district_value
                                                " :options="
  form_data.present_district_data
" @select="onSelectDistrict" placeholder="Select one" label="text" track-by="text"></vue-select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Thana:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <vue-select v-model="
                                                  form_data.present_thana_value
                                                " :options="
  form_data.permanent_thana_data
" @select="onSelectThana" placeholder="Select one" label="text" track-by="text"></vue-select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Union:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <vue-select v-model="
                                                  form_data.present_union_value
                                                " :options="
  form_data.present_union_data
" @select="onSelectPunion" placeholder="Select one" label="text" track-by="text"></vue-select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Post Office:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.present_post_office
                                                    " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>


                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Mobile (2nd contact):</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.present_mobile_2nd
                                                    " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Full Present Address ( à¦¬à¦¾à¦‚à¦²à¦¾
                                              )</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.present_address_bangla
                                                    " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <h6 style="
                                              padding: 8px;
                                              border: 1px solid #ccc;
                                            ">
                                            Permanent
                                          </h6>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Holding/House No:
                                              <sup style="color: red; top: -2px">*</sup></label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-user
                                                    "></i></span><input v-model="
                                                      form_data.permanent_holding_no
                                                    " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">House Name:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.permanent_house_name
                                                    " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Road No.</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.permanent_road_no
                                                    " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Road Name:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.permanent_road_name
                                                    " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Vill. / Area:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.permanent_vill_area
                                                    " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Ward No.:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.permanent_ward_no
                                                    " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">District:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <vue-select v-model="
                                                  form_data.permanent_district_value
                                                " :options="
  form_data.present_district_data
" @select="onSelectPdistrict" placeholder="Select one" label="text" track-by="text"></vue-select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Thana:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <vue-select v-model="
                                                  form_data.permanent_thana_value
                                                " :options="
  form_data.permanent_thana_data
" @select="onSelectPthana" placeholder="Select one" label="text" track-by="text"></vue-select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Union:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <vue-select v-model="
                                                  form_data.permanent_union_value
                                                " :options="
  form_data.present_union_data
" @select="onSelectPrunion" placeholder="Select one" label="text" track-by="text"></vue-select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Post Office:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.permanent_post_office
                                                    " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>





                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Mobile (3rd contact):</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.permanent_mobile_3rd
                                                    " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Full Permanent Address ( à¦¬à¦¾à¦‚à¦²à¦¾
                                              )</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span><input v-model="
                                                      form_data.permanent_address_bangla
                                                    " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div style="margin-top: 15px">
                                            <button type="submit" class="btn btn-info float-right"
                                              style="margin-left: 10px">
                                              Save
                                            </button>
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="identification">
                                  <div class="
                                      alert alert-success alert-dismissable
                                    " style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                      Ã—
                                    </button>
                                    <span id="submitxt"></span>
                                  </div>
                                  <h6 class="col-md-12" style="padding: 10px 10px">
                                    Identification Supporting:
                                    <span style="color: red; padding-left: 15px; font-weight: bold;" v-if = "this.resignation_message == 1">{{ 'Red Profile' }}</span>
                                    <span style="color: green; padding-left: 15px; font-weight: bold;" v-if = "this.resignation_message == 0">{{ ' ' }}</span>
                                  </h6>
                                  <form class="form-horizontal" id="personalinfo" @submit.prevent="
                                    EmployAdd({
                                      add: 'employees/identificationSupporting',
                                    })
                                  ">
                                    <div class="">
                                      <table class="
                                          table table-striped table-bordered
                                          identification
                                        ">
                                        <thead>
                                          <tr>
                                            <th class="text-center" style="width: 20%">
                                              ID Type
                                            </th>
                                            <th class="text-center" style="width: 25%">
                                              <sup style="color: red">*</sup>ID
                                              Number
                                            </th>
                                            <th class="text-center" style="width: 20%">
                                              Issue / Renew Date
                                            </th>
                                            <th class="text-center" style="width: 20%">
                                              Date of Expiry
                                            </th>
                                            <th class="text-center" style="">
                                              Documents
                                            </th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr class="identification">
                                            <th>
                                              National ID Card
                                              <sup style="color: red; top: -2px">*</sup>
                                            </th>
                                            <td>
                                              <input @input = onSelectNID(form_data.nid_number) v-model="form_data.nid_number" name="nid_no" class="form-control"
                                                type="text" placeholder="National ID Card Number" />
                                            </td>
                                            <td>
                                              <input class="form-control" v-model="
                                                form_data.nid_issue_renew_date
                                              " type="date" ref="input" />
                                            </td>
                                            <td>
                                              <input class="form-control" v-model="
                                                form_data.nid_expiry_date
                                              " type="date" ref="input" />
                                            </td>
                                            <td class="text-center" style="
                                                padding-left: 15px !important;
                                              ">
                                              <input type="file" v-on:change="onNIDChange" style="
                                                  text-overflow: ellipsis;
                                                  overflow: hidden;
                                                  white-space: nowrap;
                                                  float: left;
                                                " accept="image/*" />
                                              <span v-if="
                                                form_data.nid_document
                                                  ? form_data.nid_document
                                                  : ''
                                              " class="text-left" style="float: left">
                                                <a class="identification_files" target="_blank" :href="
                                                  '/identification_files/' +
                                                  form_data.nid_document
                                                ">View NID</a>
                                              </span>
                                              <span v-else-if="
                                                form_data.nid_document == ''
                                              " class="text-left" style="float: left">
                                                <span style="color: orange">No attachment
                                                  available!</span>
                                              </span>
                                            </td>
                                          </tr>
                                          <tr>
                                            <th>Passport</th>
                                            <td>
                                              <input v-model="
                                                form_data.passport_number
                                              " name="nid_no" placeholder="Passport Number" class="form-control"
                                                type="text" />
                                            </td>
                                            <td>
                                              <input class="form-control" v-model="
                                                form_data.passport_issue_renew_date
                                              " type="date" ref="input" />
                                            </td>
                                            <td>
                                              <input class="form-control" v-model="
                                                form_data.passport_expiry_date
                                              " type="date" ref="input" />
                                            </td>
                                            <td class="text-center" style="
                                                padding-left: 15px !important;
                                              ">
                                              <input type="file" v-on:change="onPassportChange" style="
                                                  text-overflow: ellipsis;
                                                  overflow: hidden;
                                                  white-space: nowrap;
                                                " accept="image/*" />
                                              <span v-if="
                                                form_data.passport_document
                                                  ? form_data.passport_document
                                                  : ''
                                              " class="text-left" style="float: left">
                                                <a class="identification_files" target="_blank" :href="
                                                  '/identification_files/' +
                                                  form_data.passport_document
                                                ">View Passport</a>
                                              </span>
                                              <span v-else-if="
                                                form_data.passport_document ==
                                                ''
                                              " class="text-left" style="float: left">
                                                <span style="color: orange">No attachment
                                                  available!</span>
                                              </span>
                                            </td>
                                          </tr>
                                          <tr>
                                            <th>Driving License</th>
                                            <td>
                                              <input v-model="
                                                form_data.driving_license_number
                                              " name="nid_no" placeholder="Driving License" class="form-control"
                                                type="text" />
                                            </td>
                                            <td>
                                              <input class="form-control" v-model="
                                                form_data.driving_license_issue_renew_date
                                              " type="date" ref="input" />
                                            </td>
                                            <td>
                                              <input class="form-control" v-model="
                                                form_data.driving_license_expiry_date
                                              " type="date" ref="input" />
                                            </td>
                                            <td class="text-center" style="
                                                padding-left: 15px !important;
                                              ">
                                              <input type="file" v-on:change="onLicenceChange" style="
                                                  text-overflow: ellipsis;
                                                  overflow: hidden;
                                                  white-space: nowrap;
                                                " accept="image/*" />
                                              <span v-if="
                                                form_data.dl_document
                                                  ? form_data.dl_document
                                                  : ''
                                              " class="text-left" style="float: left">
                                                <a class="identification_files" target="_blank" :href="
                                                  '/identification_files/' +
                                                  form_data.dl_document
                                                ">View Driving Licence</a>
                                              </span>
                                              <span v-else-if="
                                                form_data.dl_document == ''
                                              " class="text-left" style="float: left">
                                                <span style="color: orange">No attachment
                                                  available!</span>
                                              </span>
                                            </td>
                                          </tr>
                                          <tr>
                                            <th>TIN</th>
                                            <td>
                                              <input v-model="form_data.tin_number" name="nid_no"
                                                placeholder="TIN Certificate" class="form-control" type="text" />
                                            </td>
                                            <td>
                                              <input class="form-control" v-model="
                                                form_data.tin_issue_renew_date
                                              " type="date" ref="input" />
                                            </td>
                                            <td>
                                              <input class="form-control" v-model="
                                                form_data.tin_expiry_date
                                              " type="date" ref="input" />
                                            </td>
                                            <td class="text-center" style="
                                                padding-left: 15px !important;
                                              ">
                                              <input type="file" v-on:change="onTINChange" style="
                                                  text-overflow: ellipsis;
                                                  overflow: hidden;
                                                  white-space: nowrap;
                                                " accept="image/*" />
                                              <span v-if="
                                                form_data.tin_document
                                                  ? form_data.tin_document
                                                  : ''
                                              " class="text-left" style="float: left">
                                                <a class="identification_files" target="_blank" :href="
                                                  '/identification_files/' +
                                                  form_data.tin_document
                                                ">View TIN</a>
                                              </span>
                                              <span v-else-if="
                                                form_data.tin_document == ''
                                              " class="text-left" style="float: left">
                                                <span style="color: orange">No attachment
                                                  available!</span>
                                              </span>
                                            </td>
                                          </tr>
                                          <tr>
                                            <th>Birth Certificate</th>
                                            <td>
                                              <input v-model="
                                                form_data.birth_cer_number
                                              " name="nid_no" placeholder="Birth Certificate" class="form-control"
                                                type="text" />
                                            </td>
                                            <td>
                                              <input class="form-control" v-model="
                                                form_data.birth_cer_issue_renew_date
                                              " type="date" ref="input" />
                                            </td>
                                            <td>
                                              <input class="form-control" v-model="
                                                form_data.birth_cer_expiry_date
                                              " type="date" ref="input" />
                                            </td>
                                            <td class="text-center" style="
                                                padding-left: 15px !important;
                                              ">
                                              <input type="file" v-on:change="onBirthCChange" style="
                                                  text-overflow: ellipsis;
                                                  overflow: hidden;
                                                  white-space: nowrap;
                                                " accept="image/*" />
                                              <span v-if="
                                                form_data.birthC_document
                                                  ? form_data.birthC_document
                                                  : ''
                                              " class="text-left" style="float: left">
                                                <a class="identification_files" target="_blank" :href="
                                                  '/identification_files/' +
                                                  form_data.birthC_document
                                                ">View Birth Certificate</a>
                                              </span>
                                              <span v-else-if="
                                                form_data.birthC_document ==
                                                ''
                                              " class="text-left" style="float: left">
                                                <span style="color: orange">No attachment
                                                  available!</span>
                                              </span>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <div style="margin-top: 15px">
                                        <button type="submit" class="btn btn-info float-right"
                                          style="margin-left: 10px">
                                          Save
                                        </button>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="education">
                                  <div class="
                                      alert alert-success alert-dismissable
                                    " style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                      Ã—
                                    </button>
                                    <span id="submitxt"></span>
                                  </div>
                                  <h6 class="col-md-12" style="padding: 10px 10px">
                                    Educational Qualification (Please write down
                                    last academic degree first)
                                  </h6>
                                  <form class="form-horizontal" @submit.prevent="
                                    EmployAdd({
                                      add: 'employees/educationalQualification',
                                    })
                                  ">
                                    <div class="form-group">
                                      <div class="col-md-12">
                                        <table class="
                                            form-table
                                            educationFields
                                            table-bordered
                                          " id="educationFields" style="width: 100%">
                                          <thead>
                                            <tr>
                                              <th rowspan="2" style="width: 20% !important">
                                                Name of Degree
                                                <span class="required_sign">*</span>
                                              </th>
                                              <th rowspan="2" style="width: 10% !important">
                                                Major/ Group
                                              </th>
                                              <th rowspan="2" style="width: 10% !important">
                                                Name of Institute
                                              </th>
                                              <th rowspan="2" style="width: 10% !important">
                                                Board/ University
                                              </th>
                                              <th colspan="2">Session</th>
                                              <th rowspan="2" style="width: 5% !important">
                                                Passing Year
                                              </th>
                                              <th rowspan="2" style="width: 5% !important">
                                                Division/GPA (out of scale)
                                              </th>
                                              <th rowspan="2" style="width: 5% !important">
                                                Highest Degree?
                                              </th>
                                              <th rowspan="2" style="width: 5% !important">
                                                Add/Rem.
                                                <br />
                                                <a @click="addRowmm" id="addCF" class="btn btn-sm btn-info"><i
                                                    class="fa fa-plus"></i></a>
                                              </th>
                                            </tr>
                                            <tr>
                                              <th>From</th>
                                              <th>To</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr valign="top" class="tr_clone" v-for="(
                                                form_data, index
                                              ) in form_data.educational_infos" v-bind:key="form_data.id">
                                              <td style="">
                                                <textarea v-model="
                                                  form_data.eeq_degree_name
                                                " type="text" class="form-control" name="educational_exam[]"
                                                  placeholder="Exam Title" style="
                                                    height: 50px;
                                                    padding: 3px;
                                                  ">
                                                </textarea>
                                              </td>
                                              <td style="">
                                                <textarea v-model="
                                                  form_data.eeq_major_group
                                                " type="text" class="form-control" name="educational_major[]"
                                                  placeholder="Major" style="
                                                    height: 50px;
                                                    padding: 3px;
                                                  ">
                                                </textarea>
                                              </td>
                                              <td style="">
                                                <textarea v-model="
                                                  form_data.eeq_institute_name
                                                " type="text" class="form-control" name="educational_inst[]"
                                                  placeholder="Institute" style="
                                                    height: 50px;
                                                    padding: 3px;
                                                  ">
                                                </textarea>
                                              </td>
                                              <td style="">
                                                <textarea v-model="
                                                  form_data.eeq_board_university
                                                " type="text" class="form-control" name="educational_result[]"
                                                  placeholder="Board/ University" style="
                                                    height: 50px;
                                                    padding: 3px;
                                                  ">
                                                </textarea>
                                              </td>
                                              <td class="professional_datepicker" style="width: 10% !important">
                                                <input class="form-control" v-model="
                                                  form_data.eeq_session_from
                                                " type="date" ref="input" style="
                                                    height: 50px;
                                                    padding: 3px;
                                                  " />
                                              </td>
                                              <td class="professional_datepicker" style="width: 10% !important">
                                                <input class="form-control" v-model="
                                                  form_data.eeq_session_to
                                                " type="date" ref="input" style="
                                                    height: 50px;
                                                    padding: 3px;
                                                  " />
                                              </td>
                                              <td style="width: 5% !important" id="debitcol">
                                                <input v-model="
                                                  form_data.eeq_passing_year
                                                " type="text" class="form-control" name="educational_pyear[]"
                                                  placeholder="Passing Year " style="
                                                    height: 50px;
                                                    padding: 3px;
                                                  " />
                                              </td>
                                              <td style="width: 5% !important">
                                                <input v-model="
                                                  form_data.eeq_division_gpa
                                                " type="text" class="form-control" name="educational_achiv[]"
                                                  placeholder="Division/GPA" style="
                                                    height: 50px;
                                                    padding: 3px;
                                                  " />
                                              </td>
                                              <td class="text-center" style="
                                                  vertical-align: middle;
                                                  width: 5% !important;
                                                ">
                                                <span v-if="form_data.eeq_highest_education === 1">
                                                  <input  style="
                                                  height: 50px;
                                                  padding: 3px;
                                                " type="checkbox" v-model="
                                                  form_data.eeq_highest_education
                                                "  checked="checked"  name="form_data.eeq_highest_education" />
                                                </span>
                                                <span v-else >
                                                  <input  style="
                                                  height: 50px;
                                                  padding: 3px;
                                                " type="checkbox" v-model="
                                                  form_data.eeq_highest_education
                                                "   name="form_data.eeq_highest_education" />
                                                </span>                                                 <!-- v-if="form_data.eeq_highest_education === 1" -->
                                                <!-- v-else -->

                                                  <!-- <input  style="
                                                    height: 50px;
                                                    padding: 3px;
                                                  " type="radio" v-model="
                                                    form_data.eeq_highest_education
                                                  " :value="form_data.eeq_highest_education" name="form_data.eeq_highest_education" /> -->
                                              </td>
                                              <td style="
                                                  text-align: center;
                                                  vertical-align: middle;
                                                ">
                                                <a @click="deleteRowmm(index)" id="remCF"
                                                  class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <div style="margin-top: 15px">
                                          <button type="submit" class="btn btn-info float-right"
                                            style="margin-left: 10px">
                                            Save
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="professional">
                                  <div class="
                                      alert alert-success alert-dismissable
                                    " style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                      Ã—
                                    </button>
                                    <span id="submitxt"></span>
                                  </div>
                                  <h6 class="col-md-12" style="padding: 10px 10px">
                                    Professional Qualification
                                  </h6>
                                  <form class="form-horizontal" @submit.prevent="
                                    EmployAdd({
                                      add: 'employees/professionalQualification',
                                    })
                                  ">
                                    <div class="form-group">
                                      <div class="col-md-12">
                                        <table class="
                                            form-table
                                            educationFields
                                            table-bordered
                                          " id="educationFields" style="width: 100%">
                                          <thead>
                                            <tr>
                                              <th rowspan="2">
                                                Course Title
                                                <span class="required_sign">*</span>
                                              </th>
                                              <th rowspan="2">
                                                Name of Institute
                                              </th>
                                              <th rowspan="2">Location</th>
                                              <th colspan="2">Duration</th>
                                              <th rowspan="2">Result</th>
                                              <th rowspan="2">
                                                Add/Remove<br />
                                                <a @click="addProfessionalRow" id="addCF" class="btn btn-sm btn-info"><i
                                                    class="fa fa-plus"></i></a>
                                              </th>
                                            </tr>
                                            <tr>
                                              <th>From</th>
                                              <th>To</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr valign="top" class="tr_clone" v-for="(
                                                form_data, index
                                              ) in form_data.professional_infos" v-bind:key="form_data.id">
                                              <td>
                                                <textarea v-model="
                                                  form_data.pq_course_title
                                                " type="text" class="form-control" placeholder="Course Title"
                                                  required="true">
                                                </textarea>
                                              </td>
                                              <td>
                                                <textarea v-model="
                                                  form_data.pq_institute_name
                                                " type="text" class="form-control" placeholder="Institute">
                                                </textarea>
                                              </td>

                                              <td></td>
                                              <td>
                                                <textarea v-model="
                                                  form_data.pq_location
                                                " type="text" class="form-control" placeholder="Location">
                                                </textarea>
                                              </td>
                                              <td class="professional_datepicker">
                                                <input class="form-control" v-model="
                                                  form_data.pq_duration_from
                                                " type="date" ref="input" />
                                              </td>
                                              <td class="professional_datepicker">
                                                <input class="form-control" v-model="
                                                  form_data.pq_duration_to
                                                " type="date" ref="input" />
                                              </td>
                                              <td>
                                                <input v-model="form_data.pq_result" type="text" class="form-control"
                                                  placeholder="Result" />
                                              </td>
                                              <td style="text-align: center">
                                                <a @click="
                                                  deleteProfessionalRow(index)
                                                " id="remCF" class="btn btn-sm btn-danger"><i
                                                    class="fa fa-times"></i></a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <div style="margin-top: 15px">
                                          <button type="submit" class="btn btn-info float-right"
                                            style="margin-left: 10px">
                                            Save
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="employmenthistory">
                                  <div class="
                                      alert alert-success alert-dismissable
                                    " style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                      Ã—
                                    </button>
                                    <span id="submitxt"></span>
                                  </div>
                                  <h6 class="col-md-12" style="padding: 10px 10px">
                                    Employment History (Please write down most
                                    recent or present position first)
                                  </h6>
                                  <form class="form-horizontal" @submit.prevent="
                                    EmployAdd({
                                      add: 'employees/employmentHistory',
                                    })
                                  ">
                                    <div class="form-group">
                                      <div class="col-md-12">
                                        <table class="
                                            form-table
                                            educationFields
                                            table-bordered
                                          " id="educationFields" style="width: 100%">
                                          <thead>
                                            <tr>
                                              <th>
                                                Job Title/ Position Held<span class="required_sign">*</span>
                                              </th>
                                              <th>Name of Organization</th>
                                              <th>Industry Type</th>
                                              <th>From</th>
                                              <th>To</th>
                                              <th>Length of Service</th>
                                              <th>
                                                Add/Remove<br />
                                                <a @click="
                                                  addEmploymentHistoryRow
                                                " id="addCF" class="btn btn-sm btn-info"><i class="fa fa-plus"></i></a>
                                              </th>
                                            </tr>
                                          </thead>

                                          <tbody>
                                            <tr valign="top" class="tr_clone" v-for="(
                                                form_data, index
                                              ) in form_data.employment_histories" v-bind:key="form_data.id">
                                              <td style="">
                                                <textarea v-model="
                                                  form_data.eeh_job_title
                                                " type="text" class="form-control" name="exam[]"
                                                  placeholder="Job Title/ Position Held" reuired>
                                                </textarea>
                                              </td>
                                              <td style="">
                                                <textarea v-model="
                                                  form_data.eeh_organization_name
                                                " type="text" class="form-control" name="inst[]"
                                                  placeholder="Name of Organization">
                                                </textarea>
                                              </td>
                                              <td style="">
                                                <textarea v-model="
                                                  form_data.eeh_industry_type
                                                " type="text" class="form-control" name="result[]"
                                                  placeholder="Industry Type">
                                                </textarea>
                                              </td>
                                              <td class="professional_datepicker">
                                                <input class="form-control" v-model="
                                                  form_data.eeh_duration_from
                                                " type="date" ref="input" />
                                              </td>
                                              <td class="professional_datepicker">
                                                <input class="form-control" v-model="
                                                  form_data.eeh_duration_to
                                                " type="date" ref="input" />
                                              </td>
                                              <td id="debitcol">
                                                <input v-model="
                                                  form_data.eeh_service_length
                                                " type="text" class="form-control" name="pyear[]"
                                                  placeholder="Length of Service" />
                                              </td>
                                              <td style="text-align: center">
                                                <a @click="
                                                  deleteEmploymentHistoryRow(
                                                    index
                                                  )
                                                " id="remCF" class="btn btn-sm btn-danger"><i
                                                    class="fa fa-times"></i></a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <div style="margin-top: 15px">
                                          <button type="submit" class="btn btn-info float-right"
                                            style="margin-left: 10px">
                                            Save
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="familydetails">
                                  <div class="
                                      alert alert-success alert-dismissable
                                    " style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                      Ã—
                                    </button>
                                    <span id="submitxt"></span>
                                  </div>
                                  <h6 class="col-md-12" style="padding: 10px 10px">
                                    Family Details (dependents only i.e.
                                    Parents, Spouse, Children if any)
                                  </h6>
                                  <form class="form-horizontal" @submit.prevent="
                                    EmployAdd({
                                      add: 'employees/familyDetails',
                                    })
                                  ">
                                    <div class="form-group">
                                      <div class="col-md-12">
                                        <table class="
                                            form-table
                                            educationFields
                                            table-bordered
                                          " id="educationFields" style="width: 100%">
                                          <thead>
                                            <tr>
                                              <th>
                                                Family Memberâ€™s Name<span class="required_sign">*</span>
                                              </th>
                                              <th>Relationship</th>
                                              <th>Date of Birth</th>
                                              <th>Occupation</th>
                                              <th>Contact Mobile No.</th>
                                              <th>
                                                Add/Remove<br />
                                                <a @click="addFamilyDetailsRow" id="addCF"
                                                  class="btn btn-sm btn-info"><i class="fa fa-plus"></i></a>
                                              </th>
                                            </tr>
                                          </thead>

                                          <tbody>
                                            <tr valign="top" class="tr_clone" v-for="(
                                                form_data, index
                                              ) in form_data.family_details" v-bind:key="form_data.id">
                                              <td style="">
                                                <input v-model="
                                                  form_data.efd_family_member_name
                                                " type="text" class="form-control" name="exam[]"
                                                  placeholder="Family Memberâ€™s Name" required />
                                              </td>
                                              <td style="">
                                                <input v-model="
                                                  form_data.efd_relationship
                                                " type="text" class="form-control" name="inst[]"
                                                  placeholder="Relationship" />
                                              </td>
                                              <td class="professional_datepicker">
                                                <input class="form-control" v-model="
                                                  form_data.efd_date_of_birth
                                                " type="date" ref="input" />
                                              </td>
                                              <td style="" id="creditcol">
                                                <input v-model="
                                                  form_data.efd_occupation
                                                " type="text" class="form-control" name="from[]"
                                                  placeholder="Occupation" />
                                              </td>
                                              <td style="" id="debitcol">
                                                <input v-model="
                                                  form_data.efd_contact_mobile_no
                                                " type="number" class="form-control" name="mobile_no[]"
                                                  placeholder="Contact Mobile No." />
                                              </td>
                                              <td style="text-align: center">
                                                <a @click="
                                                  deleteFamilyDetailsRow(
                                                    index
                                                  )
                                                " id="remCF" class="btn btn-sm btn-danger"><i
                                                    class="fa fa-times"></i></a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <div style="margin-top: 15px">
                                          <button type="submit" class="btn btn-info float-right"
                                            style="margin-left: 10px">
                                            Save
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="references">
                                  <div class="
                                      alert alert-success alert-dismissable
                                    " style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                      Ã—
                                    </button>
                                    <span id="submitxt"></span>
                                  </div>
                                  <div class="row">
                                    <h6 class="col-md-10" style="padding: 10px 15px">
                                      References (Preferably Relatives except
                                      Parents, Siblings, Spouse)
                                    </h6>
                                    <div class="col-md-6"></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12" v-for="(
                                        form_data, index
                                      ) in form_data.references_details" v-bind:key="form_data.id">
                                      <form class="form-horizontal" @submit.prevent="
                                        EmployAdd({
                                          add: 'employees/references',
                                        })
                                      ">
                                        <div class="col-md-6" style="float: left">
                                          <h6 style="
                                              padding: 8px;
                                              border: 1px solid #ccc;
                                              background: #ddd;
                                            ">
                                            Basic Info:
                                          </h6>
                                          <div class="form-group">
                                            <label class="col-md-8 control-label">Name:
                                              <span class="required_sign">*</span></label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-user
                                                    "></i></span>
                                                <input v-model="form_data.er_name1" class="form-control" required="true"
                                                  type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-8 control-label">Relationship:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.er_relationship1
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-8 control-label">Occupation:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.er_occupation1
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-8 control-label">Designation & Department:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.er_designation_department1
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-8 control-label">Company & Office Address:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.er_company_address1
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-8 control-label">Mobile No.</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.er_mobile_no1
                                                " class="form-control" type="number" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-8 control-label">National ID Card No.:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.er_national_id1
                                                " class="form-control" type="number" />
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6" style="
                                            float: left;
                                            border-left: 1px solid #ccc;
                                          ">
                                          <h6 style="
                                              padding: 8px;
                                              border: 1px solid #ccc;
                                              background: #ddd;
                                            ">
                                            Permanent Address:

                                            <a @click="
                                              deleteReferencesRow(index)
                                            " id="remCF" class="
                                                btn btn-sm btn-danger
                                                float-right
                                              " style="
                                                margin-right: -6px;
                                                margin-top: -6px;
                                              "><i class="fa fa-times" style="color: #fff"></i></a>
                                          </h6>
                                          <div class="
                                              form-group
                                              col-md-6
                                              float-left
                                            ">
                                            <label class="col-md-12 control-label">Holding/House No:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.er_holding_no1
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="
                                              form-group
                                              col-md-6
                                              float-left
                                            ">
                                            <label class="col-md-8 control-label">Road No.</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.er_road_no1
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="
                                              form-group
                                              col-md-6
                                              float-left
                                            ">
                                            <label class="col-md-8 control-label">House Name:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.er_house_name1
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="
                                              form-group
                                              col-md-6
                                              float-left
                                            ">
                                            <label class="col-md-8 control-label">Road Name:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.er_road_name1
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-8 control-label">Ward No.:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.er_ward_no1
                                                " class="form-control" type="number" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-12 control-label">Union/Pourosova/City Corp:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.er_union_pouro_city1
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-8 control-label">Post Office:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.er_post_office1
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-8 control-label">Thana:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="form_data.er_thana1" class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-8 control-label">District:</label>
                                            <div class="
                                                col-md-12
                                                inputGroupContainer
                                              ">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="
                                                      glyphicon glyphicon-home
                                                    "></i></span>
                                                <input v-model="
                                                  form_data.er_district1
                                                " class="form-control" type="text" />
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-12" style="">
                                          <button type="submit" class="btn btn-info float-right" style="
                                              margin-bottom: 10px;
                                              margin-left: 10px;
                                            ">
                                            Update
                                          </button>
                                        </div>
                                      </form>
                                    </div>
                                    <div class="col-md-12">
                                      <a @click="addReferencesRow" title="Add More" id="addCF" class="
                                          btn btn-sm btn-warning
                                          float-right
                                        " style="
                                          margin-right: 8px;
                                          margin-top: 5px;
                                          color: #fff;
                                        ">Add More
                                        <i class="fa fa-plus" style="color: #fff"></i></a>
                                    </div>
                                    }
                                  </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="trainingrecord">
                                  <div class="
                                      alert alert-success alert-dismissable
                                    " style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                      Ã—
                                    </button>
                                    <span id="submitxt"></span>
                                  </div>
                                  <h6 class="col-md-12" style="padding: 10px 10px">
                                    Training Record
                                  </h6>
                                  <form class="form-horizontal" @submit.prevent="
                                    EmployAdd({
                                      add: 'employees/trainingRecord',
                                    })
                                  ">
                                    <div class="form-group">
                                      <div class="col-md-12">
                                        <table class="
                                            form-table
                                            educationFields
                                            table-bordered
                                          " id="educationFields" style="width: 100%">
                                          <thead>
                                            <tr>
                                              <th rowspan="2">
                                                Training Title
                                                <span class="required_sign">*</span>
                                              </th>
                                              <th rowspan="2">
                                                Name of Training Institute
                                              </th>
                                              <th colspan="2">Duration</th>
                                              <th rowspan="2">
                                                Nominated/ Sponsored by
                                              </th>
                                              <th rowspan="2">
                                                Certificate Received
                                              </th>
                                              <th rowspan="2">
                                                Add/Remove<br />
                                                <a @click="addTrainingRecordsRow" id="addCF"
                                                  class="btn btn-sm btn-info"><i class="fa fa-plus"></i></a>
                                              </th>
                                            </tr>
                                            <tr>
                                              <th>From</th>
                                              <th>To</th>
                                            </tr>
                                          </thead>

                                          <tbody>
                                            <tr valign="top" class="tr_clone" v-for="(
                                                form_data, index
                                              ) in form_data.training_records" v-bind:key="form_data.id">
                                              <td style="">
                                                <textarea v-model="
                                                  form_data.etr_training_title
                                                " type="text" class="form-control" placeholder="Training Title"
                                                  required>
                                                </textarea>
                                              </td>
                                              <td style="">
                                                <textarea v-model="
                                                  form_data.etr_institute_name
                                                " type="text" class="form-control" placeholder="Institute">
                                                </textarea>
                                              </td>
                                              <td class="professional_datepicker">
                                                <input class="form-control" v-model="
                                                  form_data.etr_duration_from
                                                " type="date" ref="input" />
                                              </td>
                                              <td class="professional_datepicker">
                                                <input class="form-control" v-model="
                                                  form_data.etr_duration_to
                                                " type="date" ref="input" />
                                              </td>
                                              <td style="">
                                                <input v-model="
                                                  form_data.etr_sponsored_by
                                                " type="text" class="form-control"
                                                  placeholder="Nominated/ Sponsored by" />
                                              </td>
                                              <td id="debitcol">
                                                <input v-model="
                                                  form_data.etr_certificate_received
                                                " type="text" class="form-control"
                                                  placeholder="Certificate Received" />
                                              </td>
                                              <td style="text-align: center">
                                                <a @click="
                                                  deleteTrainingRecordsRow(
                                                    index
                                                  )
                                                " class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <div style="margin-top: 15px">
                                          <button type="submit" class="btn btn-info float-right"
                                            style="margin-left: 10px">
                                            Save
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="professionalmember">
                                  <div class="
                                      alert alert-success alert-dismissable
                                    " style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                      Ã—
                                    </button>
                                    <span id="submitxt"></span>
                                  </div>
                                  <h6 class="col-md-12" style="padding: 10px 10px">
                                    Professional Membership / Affiliation
                                  </h6>
                                  <form class="form-horizontal" @submit.prevent="
                                    EmployAdd({
                                      add: 'employees/professionalMembership',
                                    })
                                  ">
                                    <div class="form-group">
                                      <div class="col-md-12">
                                        <table class="
                                            form-table
                                            educationFields
                                            table-bordered
                                          " id="educationFields" style="width: 100%">
                                          <thead>
                                            <tr>
                                              <th>
                                                Membership Title<span class="required_sign">*</span>
                                              </th>
                                              <th>
                                                Name of the Membership
                                                Organization
                                              </th>
                                              <th>Obtained On</th>
                                              <th>Valid Up to</th>
                                              <th>
                                                Add/Remove<br />
                                                <a @click="
                                                  addProfessionalMembershipRow
                                                " id="addCF" class="btn btn-sm btn-info"><i class="fa fa-plus"></i></a>
                                              </th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr valign="top" class="tr_clone" v-for="(
                                                form_data, index
                                              ) in form_data.professinal_memberships" v-bind:key="form_data.id">
                                              <td style="">
                                                <input v-model="
                                                  form_data.epm_membership_title
                                                " type="text" class="form-control" name="exam[]"
                                                  placeholder="Membership Title" required />
                                              </td>
                                              <td style="">
                                                <input v-model="
                                                  form_data.epm_organization_name
                                                " type="text" class="form-control" name="inst[]"
                                                  placeholder="Organization" />
                                              </td>
                                              <td class="professional_datepicker">
                                                <input class="form-control" v-model="
                                                  form_data.epm_obtained_on
                                                " type="date" ref="input" />
                                              </td>
                                              <td class="professional_datepicker">
                                                <input class="form-control" v-model="
                                                  form_data.epm_valid_upto
                                                " type="date" ref="input" />
                                              </td>
                                              <td style="text-align: center">
                                                <a @click="
                                                  deleteProfessionalMembershipRow(
                                                    index
                                                  )
                                                " id="remCF" class="btn btn-sm btn-danger"><i
                                                    class="fa fa-times"></i></a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <div style="margin-top: 15px">
                                          <button type="submit" class="btn btn-info float-right"
                                            style="margin-left: 10px">
                                            Save
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="bankaccount">
                                  <div class="
                                      alert alert-success alert-dismissable
                                    " style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                      Ã—
                                    </button>
                                    <span id="submitxt"></span>
                                  </div>
                                  <h6 class="col-md-12" style="padding: 10px 10px">
                                    Bank Account Details
                                  </h6>
                                  <form class="form-horizontal" @submit.prevent="
                                    EmployAdd({
                                      add: 'employees/bankAccount',
                                    })
                                  ">
                                    <div class="form-group">
                                      <div class="col-md-12">
                                        <table class="
                                            form-table
                                            educationFields
                                            table-bordered
                                          " id="educationFields" style="width: 100%">
                                          <thead>
                                            <tr>
                                              <th>
                                                Bank Name<span class="required_sign">*</span>
                                              </th>
                                              <th>Branch Name & District</th>
                                              <th>Name of Account Holder</th>
                                              <th>Account Number</th>
                                              <th>Account Status</th>
                                              <th>
                                                Add/Remove<br />
                                                <a @click="addBankAccountsRow" id="addCF" class="btn btn-sm btn-info"><i
                                                    class="fa fa-plus"></i></a>
                                              </th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr valign="top" class="tr_clone" v-for="(
                                                form_data_single, index
                                              ) in form_data.bank_accounts" v-bind:key="index">
                                              <td>
                                                <input v-model="
                                                  form_data_single.ebc_bank_name
                                                " type="text" class="form-control" placeholder="Bank Name" required />
                                              </td>
                                              <td>
                                                <input v-model="
                                                  form_data_single.ebc_branch_district
                                                " type="text" class="form-control" placeholder="Branch Name" />
                                              </td>
                                              <td id="creditcol">
                                                <input v-model="
                                                  form_data_single.ebc_ac_holder_name
                                                " type="text" class="form-control" placeholder="Account Holder" />
                                              </td>
                                              <td id="creditcol">
                                                <input v-model="
                                                  form_data_single.ebc_account_number
                                                "
                                                @keyup="status_active_inactive($event, form_data_single)"
                                                 type="text" class="form-control" placeholder="Account Number" />
                                              </td>
                                              <td id="creditcol">
                                                <select v-model="
                                                  form_data_single.status
                                                " class="form-control">
                                                  <option value="1">
                                                    Active
                                                  </option>
                                                  <option value="0">
                                                    Inactive
                                                  </option>
                                                </select>
                                              </td>
                                              <td style="text-align: center">
                                                <a @click="
                                                  deleteBankAccountsRow(index)
                                                " id="remCF" class="btn btn-sm btn-danger"><i
                                                    class="fa fa-times"></i></a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <div style="margin-top: 15px">
                                          <button type="submit" class="btn btn-info float-right"
                                            style="margin-left: 10px">
                                            Save
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="emergencycontact">
                                  <div class="
                                      alert alert-success alert-dismissable
                                    " style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                      Ã—
                                    </button>
                                    <span id="submitxt"></span>
                                  </div>
                                  <h6 class="col-md-12" style="padding: 10px 10px">
                                    In-case of Emergency Contact Person
                                  </h6>
                                  <form class="form-horizontal" @submit.prevent="
                                    EmployAdd({
                                      add: 'employees/emergencyContact',
                                    })
                                  ">
                                    <div class="form-group">
                                      <div class="col-md-12">
                                        <table class="
                                            form-table
                                            educationFields
                                            table-bordered
                                          " id="educationFields" style="width: 100%">
                                          <thead>
                                            <tr>
                                              <th>
                                                Name<span class="required_sign">*</span>
                                              </th>
                                              <th>Relationship</th>
                                              <th>Present Address</th>
                                              <th>Mobile No</th>
                                              <th>
                                                Add/Remove<br />
                                                <a @click="
                                                  addEmergencyContactsRow
                                                " id="addCF" class="btn btn-sm btn-info"><i class="fa fa-plus"></i></a>
                                              </th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr valign="top" class="tr_clone" v-for="(
                                                form_data, index
                                              ) in form_data.emergency_contacts" v-bind:key="form_data.id">
                                              <td style="">
                                                <input v-model="form_data.eec_name" type="text" class="form-control"
                                                  placeholder="Name" required="true" />
                                              </td>
                                              <td style="">
                                                <input v-model="
                                                  form_data.eec_relationship
                                                " type="text" class="form-control" placeholder="Relationship" />
                                              </td>
                                              <td style="" id="creditcol">
                                                <input v-model="
                                                  form_data.eec_present_address
                                                " type="text" class="form-control" placeholder="Present Address" />
                                              </td>
                                              <td style="" id="creditcol">
                                                <input v-model="
                                                  form_data.eec_mobile_no
                                                " type="number" class="form-control" placeholder="Mobile No" />
                                              </td>
                                              <td style="text-align: center">
                                                <a @click="
                                                  deleteEmergencyContactsRow(
                                                    index
                                                  )
                                                " id="remCF" class="btn btn-sm btn-danger"><i
                                                    class="fa fa-times"></i></a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <div style="margin-top: 15px">
                                          <button type="submit" class="btn btn-info float-right"
                                            style="margin-left: 10px">
                                            Save
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="othersContactInfo">
                                  <div class="
                                      alert alert-success alert-dismissable
                                    " style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                      Ã—
                                    </button>
                                    <span id="submitxt"></span>
                                  </div>
                                  <h6 class="col-md-12" style="padding: 10px 10px">
                                    Others Contact Information
                                  </h6>
                                  <form class="form-horizontal" @submit.prevent="
                                    EmployAdd({
                                      add: 'employees/othersContactInfo',
                                    })
                                  ">
                                    <div class="form-group">
                                      <div class="col-md-12">
                                        <table class="
                                            form-table
                                            educationFields
                                            table-bordered
                                          " id="educationFields" style="width: 100%">
                                          <thead>
                                            <tr>
                                              <th>
                                                Contact Title<span class="required_sign">*</span>
                                              </th>
                                              <th>Contact Number</th>
                                              <th>Remarks</th>
                                              <th>
                                                Add/Remove<br />
                                                <a @click="addOthersContactRow" id="addCF"
                                                  class="btn btn-sm btn-info"><i class="fa fa-plus"></i></a>
                                              </th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr valign="top" class="tr_clone" v-for="(
                                                form_data, index
                                              ) in form_data.others_contact_info" v-bind:key="form_data.id">
                                              <td>
                                                <input v-model="form_data.eoc_title" type="text" class="form-control"
                                                  placeholder="Title" required="true" />
                                              </td>
                                              <td>
                                                <input v-model="form_data.eoc_number" type="text" class="form-control"
                                                  placeholder="Contact Number" />
                                              </td>
                                              <td id="creditcol">
                                                <input v-model="
                                                  form_data.eoc_remarks
                                                " type="text" class="form-control" placeholder="Contact Remarks" />
                                              </td>
                                              <td style="text-align: center">
                                                <a @click="
                                                  deleteOthersContactRow(
                                                    index
                                                  )
                                                " id="remCF" class="btn btn-sm btn-danger"><i
                                                    class="fa fa-times"></i></a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <div style="margin-top: 15px">
                                          <button type="submit" class="btn btn-info float-right"
                                            style="margin-left: 10px">
                                            Save
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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
import {Alert} from "bootstrap";
import Loading from "../Loading.vue";
import Datepicker from "vuejs-datepicker";

export default {
    data() {
        return {
            approval_infos: [
                {
                    ea_approve_by: "",
                },
            ],
            approval_infosss: [
                {
                    ea_approve_by: "",
                },
            ],
            sub_section_value: "",
            employee_group_value: "",
            shift_time: "",
            make_user: 0,
            approvalnamevalue1: "",
            url: null,
            ages: 0,
            sbu_name_value: "",
            section_value: "",
            sub_unit_value: "",
            editData: true,
            work_area_value: "",
            floor_value: "",
            department_name_value: "",
            designation_name_value: "",
            jobgrade_name_value: "",
            employee_name_value: "",
            sub_unit_value: "",
            work_location_value: "",
            employeeId: null,
            emplyeeIdEditeValue: 0,
            present_district_value: "",
            permanent_district_value: "",
            permanent_thana_value: "",
            present_thana_value: "",
            permanent_union_value: "",
            present_union_value: "",
            separation_status: '',
            resignation_message: ''
        };
    },
    created() {
        // this.getList(1);
        // this.getResults(1,this.$route.params.employeeId);
        // this.resetModal();
        this.getList();
    },
    components: {
        pageLoading: Loading,
    },

    methods: {
        emplyeeIDEdit() {
            if (this.emplyeeIdEditeValue == 0) {
                this.emplyeeIdEditeValue = 1;
            } else {
                this.emplyeeIdEditeValue = 0;
            }
            this.form_data.emplyeeIdEditeValue = this.emplyeeIdEditeValue;
        },

        status_active_inactive: function (val, form_data_single) {
            if (val.target.value == '') {
                form_data_single.status = 0;
            } else {
                form_data_single.status = 1;
            }
            this.bank_status();
        },
        bank_status() {
            this.form_data_single.status = this.form_data_single.status;
        },
        emp_search_by_id(option) {
            this.form_data.id = option.id;
            this.$router.push("/employeemoreinfo/" + option.id);
            this.getList();
        },

        basicadd(addUrl, callback) {
            $('.btn-disabled').attr('disabled', 'disabled');
            this.modal_loading = false;
            axios
                .post(URL.baseUrl(addUrl.add), this.form_data)
                .then((res) => {
                    $('.btn-disabled').removeAttr('disabled', 'disabled');
                    if (res.data.status == 1) {
                        this.showToster({status: 1, message: "Success"});
                        this.page_loading = true;
                        this.modal_loading = true;
                        if (this.$route.params.employeeId == 0) {
                            this.form_data.id = res.data.data.id;
                            this.form_data.employee_id_no = res.data.data.employee_id_no;
                            this.form_data.employee_number = res.data.data.employee_number;
                            this.$router.push("/employeemoreinfo/" + res.data.data.id);
                        }
                    }
                })
                .catch((error) => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                    this.page_loading = true;
                    this.modal_loading = true;
                    // this.hideModal();
                    $('.btn-disabled').removeAttr('disabled', 'disabled');
                    var msg = "opps! something went wrong";
                    this.showToster({status: 0, message: msg});
                });
        },
        addEvent({type, target}) {
            // alert(target.checked);
            if (target.checked == true) {
                this.make_user = 1;
                this.form_data.make_user = 1;
            } else {
                this.make_user = 0;
                this.form_data.make_user = 0;
            }

            const event = {
                type,
                isCheckbox: target.type === "checkbox",
                target: {
                    value: target.value,
                    checked: target.checked,
                },
            };
            this.events.push(event);
        },
        eventText(e) {
            return `${e.type}: ${e.isCheckbox ? e.target.checked : e.target.value}`;
        },

        checkPortalUser(e) {
            if (this.form_data.make_user == false) {
                this.make_user = 0;
            } else {
                this.make_user = 1;
            }

            // alert(this.form_data.make_user);

            return `${e.type}: ${e.isCheckbox ? e.target.checked : e.target.value}`;

            // if(this.form_data.make_user == 'false'){

            // }else{

            // }
            // this.form_data.make_user=
            if ($("#portal_user_id").is(":checked")) {
                // $('#P').prop('checked',true);
                // alert('chceked');
                $("#user_type_id").css("display", "inline");
            } else {
                // alert('unchceked');
                $("#user_type_id").css("display", "none");
            }
        },
        onSelectSeparationType(option) {
            // this.form_data.separation_type = option;
            if (event.target.value == 1) {
                this.resignation_type_name = "Resignation";
            } else if (event.target.value == 2) {
                this.resignation_type_name = "Termination";
            } else if (event.target.value == 3) {
                this.resignation_type_name = "Retirement";
            } else if (event.target.value == 4) {
                this.resignation_type_name = "Retracement";
            } else if (event.target.value == 5) {
                this.resignation_type_name = "Died";
            } else {
                this.resignation_type_name = "Other";
            }
        },
        user_type_to(event) {
            if (event.target.value == 2) {
                this.userType = 2;
                this.userTypeName = "Company/SBU";
            } else if (event.target.value == 3) {
                this.userType = 3;
                this.userTypeName = "Department";
            } else if (event.target.value == 4) {
                this.userType = 4;
                this.userTypeName = "Unit";
            } else if (event.target.value == 5) {
                this.userType = 5;
                this.userTypeName = "Sub Unit";
            } else if (event.target.value == 6) {
                this.userType = 6;
                this.userTypeName = "Section";
            } else if (event.target.value == 7) {
                this.userType = 7;
                this.userTypeName = "Sub Section";
            } else if (event.target.value == 8) {
                this.userType = 8;
                this.userTypeName = "Employee";
            } else if (event.target.value == 1) {
                this.userType = 1;
                this.userTypeName = "";
            }
        },
        addRowUserlevel(event, approval_infosss) {
            var aaa = this.form_data.approval_infosss.length;
            this.form_data.approval_infosss.push({
                permission_id: this.permission_id,
                permission_id_name: this.permission_id_name,
                permission_type: this.userType,
                permission_type_name: this.userTypeName,
            });
        },
        employeesSbu_per(option) {
            this.permission_id = option.id;
            this.permission_id_name = option.text;
        },
        onSelectDepartment_per(option) {
            this.permission_id = option.id;
            this.permission_id_name = option.text;
        },
        employeesUnit_per(option) {
            this.permission_id = option.id;
            this.permission_id_name = option.text;
        },
        employeesSubUnit_per(option) {
            this.permission_id = option.id;
            this.permission_id_name = option.text;
        },
        employeesSection_per(option) {
            this.permission_id = option.id;
            this.permission_id_name = option.text;
        },
        employeesSubSection_per(option) {
            this.permission_id = option.id;
            this.permission_id_name = option.text;
        },
        // @selected="joining_dateSelected()" v-model="form_data.employee_joining_date"
        //  updateValue: function (target) {
        joining_dateSelected(target) {
            const str = this.form_data.employee_joining_date;
            this.form_data.employee_joining_dates =
                str.getFullYear() + "-" + str.getMonth() + "-" + str.getDate();
            this.employeeType();
        },
        dateoOfBirth_dateSelected(target) {
            var dob = new Date(this.form_data.employee_dob_certificate);
            var diff_ms = Date.now() - dob.getTime();
            var age_dt = new Date(diff_ms);
            this.ages = Math.abs(age_dt.getUTCFullYear() - 1970);
        },
        employeeType() {
            let joingDate = this.form_data.employee_joining_dates;
            const str = this.form_data.employee_joining_dates;
            const datetext = str.split("-");
            let joingDates = new Date(datetext["0"], datetext["1"], datetext["2"]);
            var dt = joingDates;
            var addDate = dt.setMonth(
                dt.getMonth() + parseInt(this.form_data.employee_due_month)
            );
            let getmonths = new Date(addDate).getMonth() + 1;
            let getDays = datetext["2"];
            let getMonthDigit = 0;
            if (getmonths > 9) {
                getMonthDigit = getmonths;
            } else {
                if (getmonths == 0) {
                    getMonthDigit = 12;
                } else {
                    getMonthDigit = "0" + getmonths;
                }
            }
            let getDaysDigit = datetext["2"];
            this.form_data.employee_confirmation_due_date =
                new Date(addDate).getFullYear() +
                "-" +
                getMonthDigit +
                "-" +
                getDaysDigit;
            this.employee_confirmation_due_date();
        },
        employee_confirmation_due_date() {
            this.form_data.employee_confirmation_due_date =
                this.form_data.employee_confirmation_due_date;
        },
        deleteRowMlevel(index) {
            this.form_data.approval_infosss.splice(index, 1);
        },
        onSelectOfficeTime(option) {
            this.form_data.attendance_office_time = option.id;
        },
        tableToExcel(table, name) {
            if (!table.nodeType) table = this.$refs.table;
            var ctx = {worksheet: name || "Worksheet", table: table.innerHTML};
            window.location.href =
                this.uri + this.base64(this.format(this.template, ctx));
        },

        employeesSbuTransfer(option) {
            this.form_data.employee_sbu = option.id;
            this.form_data.employee_number = option.id;
            // this.getModalDataOther(option.id);
        },
        employeesSbu1(option) {
            this.form_data.employee_sbu = option.id;
            this.form_data.employee_number = option.id;
            this.form_data.office_start_time = option.office_start_time;
            this.form_data.office_end_time = option.office_end_time;
            this.shift_time = option.shift_time;
            this.getModalDataOther(option.id);
        },

        getModalDataOther(id) {
            let uri1 = URL.baseUrl("create_id/employees/" + id);
            axios
                .get(uri1)
                .then((res) => {
                    this.form_data.employee_id_no = res.data.employee_id_no;
                    this.form_data.employee_number = res.data.employee_id_no;
                    this.errors = null;
                    if (callback) {
                        callback();
                    }
                })
                .catch((error) => {
                    // this.showToster({status:0,message:'opps! something went wrong'});
                    this.modal_page_loading = true;
                });
        },
        employee_typeChange(event) {
            this.form_data.employee_type_bangla = event.target.value;
            this.form_data.employee_type = event.target.value;
        },
        employeesSection1(option) {
            this.form_data.employee_section = option.id;
        },
        employeesSubSection1(option) {
            this.form_data.employee_sub_section = option.id;
        },
        employeesGroup1(option) {
            this.form_data.employee_group = option.id;
        },
        employeesSubUnit1(option) {
            this.form_data.employee_sub_unit = option.id;
        },
        employeesUnit1(option) {
            this.form_data.employee_unit = option.id;
        },
        employeesWorkLocation1(option) {
            this.form_data.employee_work_location = option.id;

            axios.get(URL.baseUrl(`employees/get-floors/${option.id}`))
                .then(({data}) => {
                    this.form_data.floors = data;
                });
        },
        selectFloor(option) {
            this.form_data.floor_number = option.id;
        },
        employeesArea(option) {
            this.form_data.work_area = option.id;
        },
        onSelectDepartment1(option) {
            this.form_data.employee_department = option.id;
        },
        onSelectDesignation(option) {
            this.form_data.employee_designation = option.id;
        },
        onSelectJobGrade(option) {
            this.form_data.employee_job_grade = option.id;
        },
        onSelectEmployeeManAttn(option) {
            this.form_data.employee_id = option.id;
            this.form_data.employee_id_no = option.employee_id_no;
        },
        onSelectEmployee1(option) {
            this.form_data.employee_reporting_to = option["employeeNo"];
            this.form_data.approval_infos.push({
                approvalnamevalue1: "",
                // ea_approve_by: option["employeeNo"],
                ea_approve_by: option["id"],
                employees_ids: option["employeeNo"],
                ea_approve_by_name: option["text"],
            });

            let datall = this.form_data.approval_infos;
            this.form_data.approval_infos = [];
            let approvalInfos = [];
            datall.forEach(function (value, i) {
                if (value.employees_ids == "") {
                } else {
                    approvalInfos.push(value);
                }
            });
            approvalInfos.forEach((element) => {
                this.form_data.approval_infos.push({
                    approvalnamevalue1: "",
                    ea_approve_by: element.ea_approve_by,
                    employees_ids: element.employees_ids,
                    ea_approve_by_name: element.ea_approve_by_name,
                });
            });
        },
        onSelectEmployeeLeave(option) {
            this.form_data.leave_reliever = option.id;
            let allData = this.form_data.user_employee_data_all[option.id];
            if (allData["official_mobile_no"]) {
                this.form_data.leave_reliever_contact = allData["official_mobile_no"];
                this.form_data.designation_name = allData["designation_name"];
                this.form_data.sbu_name = allData["sbu_name"];
            } else if (allData["employee_mobile"]) {
                this.form_data.leave_reliever_contact = allData["employee_mobile"];
                this.form_data.designation_name = allData["designation_name"];
                this.form_data.sbu_name = allData["sbu_name"];
            } else {
                this.form_data.leave_reliever_contact = "";
                this.form_data.designation_name = allData["designation_name"];
                this.form_data.sbu_name = allData["sbu_name"];
            }
        },
        onSelectEmployeeApproval(option) {
            this.form_data.approve_by = option.id;
            this.employeesName = option.employee_name;
            this.employees_ids = option.employee_ids;
            this.form_data.approve_by_name = option.text;
        },
        onFileChange(e) {
            // alert(e);
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.createImage(files[0]);
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                this.form_data.employee_image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        onNIDChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.createNID(files[0]);
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
        createNID(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                this.form_data.nid_document = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        onPassportChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.createPassport(files[0]);
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
        createPassport(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                this.form_data.passport_document = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        onLicenceChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.createLicence(files[0]);
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
        createLicence(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                this.form_data.dl_document = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        onTINChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.createTIN(files[0]);
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
        createTIN(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                this.form_data.tin_document = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        onBirthCChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.createBirthC(files[0]);
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
        createBirthC(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                this.form_data.birthC_document = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        addRowmm() {
            this.form_data.educational_infos.push({
                eeq_degree_name: "",
                eeq_major_group: "",
                eeq_major_group: "",
                eeq_board_university: "",
                eeq_session_from: "",
                eeq_session_to: "",
                eeq_passing_year: "",
                eeq_division_gpa: "",
                eeq_highest_education: "",
            });
        },
        deleteRowmm(index) {
            this.form_data.educational_infos.splice(index, 1);
        },
        addRow(event, approval_infos, id, ids, name) {
            var aaa = this.form_data.approval_infos.length;
            this.form_data.approval_infos.push({
                approvalnamevalue1: "",
                indexid: aaa,
                ea_approve_by: id,
                employees_ids: ids,
                ea_approve_by_name: name,
            });
        },
        deleteRow(index) {
            this.form_data.approval_infos.splice(index, 1);
        },
        addProfessionalRow() {
            this.form_data.professional_infos.push({
                pq_course_title: "",
                pq_institute_name: "",
                pq_location: "",
                pq_duration_from: "",
                pq_duration_to: "",
                pq_result: "",
            });
        },
        deleteProfessionalRow(index) {
            this.form_data.professional_infos.splice(index, 1);
        },
        addEmploymentHistoryRow() {
            this.form_data.employment_histories.push({
                eeh_job_title: "",
                eeh_organization_name: "",
                eeh_industry_type: "",
                eeh_duration_from: "",
                eeh_duration_to: "",
                eeh_service_length: "",
            });
        },
        deleteEmploymentHistoryRow(index) {
            this.form_data.employment_histories.splice(index, 1);
        },

        addFamilyDetailsRow() {
            this.form_data.family_details.push({
                efd_family_member_name: "",
                efd_relationship: "",
                efd_date_of_birth: "",
                efd_occupation: "",
                efd_contact_mobile_no: "",
            });
        },
        deleteFamilyDetailsRow(index) {
            this.form_data.family_details.splice(index, 1);
        },

        addReferencesRow() {
            this.form_data.references_details.push({
                er_name1: "",
                er_relationship1: "",
                er_occupation1: "",
                er_designation_department1: "",
                er_company_address1: "",
                er_mobile_no1: "",
                er_national_id1: "",
                er_holding_no1: "",
                er_road_no1: "",
                er_house_name1: "",
                er_road_name1: "",
                er_ward_no1: "",
                er_union_pouro_city1: "",
                er_post_office1: "",
                er_thana1: "",
                er_district1: "",
            });
        },
        deleteReferencesRow(index) {
            this.form_data.references_details.splice(index, 1);
        },

        addTrainingRecordsRow() {
            this.form_data.training_records.push({
                etr_training_title: "",
                etr_institute_name: "",
                etr_duration_from: "",
                etr_duration_to: "",
                etr_sponsored_by: "",
                etr_certificate_received: "",
            });
        },
        deleteTrainingRecordsRow(index) {
            this.form_data.training_records.splice(index, 1);
        },

        addProfessionalMembershipRow() {
            this.form_data.professinal_memberships.push({
                epm_membership_title: "",
                epm_organization_name: "",
                epm_obtained_on: "",
                epm_valid_upto: "",
            });
        },
        deleteProfessionalMembershipRow(index) {
            this.form_data.professinal_memberships.splice(index, 1);
        },

        addBankAccountsRow() {
            this.form_data.bank_accounts.push({
                ebc_bank_name: "",
                ebc_branch_district: "",
                ebc_ac_holder_name: "",
                ebc_account_number: "",
                status: "",
            });
        },
        deleteBankAccountsRow(index) {
            this.form_data.bank_accounts.splice(index, 1);
        },

        addEmergencyContactsRow() {
            this.form_data.emergency_contacts.push({
                eec_name: "",
                eec_relationship: "",
                eec_present_address: "",
                eec_mobile_no: "",
            });
        },
        deleteEmergencyContactsRow(index) {
            this.form_data.emergency_contacts.splice(index, 1);
        },

        addOthersContactRow() {
            this.form_data.others_contact_info.push({
                eoc_title: "",
                eoc_number: "",
                eoc_remarks: "",
            });
        },
        deleteOthersContactRow(index) {
            this.form_data.others_contact_info.splice(index, 1);
        },

        getList() {
            this.page_loading = false;
            let uri = URL.baseUrl(
                "employees/more-info-data/" + this.$route.params.employeeId
            );
            axios
                .get(uri)
                .then((res) => {
                    // this.getResults(1);
                    this.form_data = res.data;
                    // this.form_data =res.data.employee_personal_data[0];
                    this.sbu_name_value = this.form_data.sbu_name_value;
                    this.section_value = this.form_data.section_value;
                    this.department_name_value = this.form_data.department_name_value;
                    this.designation_name_value = this.form_data.designation_name_value;
                    this.jobgrade_name_value = this.form_data.jobgrade_name_value;
                    this.sub_unit_value = this.form_data.sub_unit_value;
                    this.employee_name_value = this.form_data.employee_name_value;
                    this.employee_search_value = this.form_data.employee_search_value;
                    this.work_location_value = this.form_data.work_location_value;
                    this.work_area_value = this.form_data.work_area_value;
                    this.floor_value = this.form_data.floor_value;
                    this.page_loading = true;
                })
                .catch((error) => {
                    this.page_loading = true;
                    this.showToster({status: 0, message: "opps! something went wrong"});
                });
        },

        EmployAdd(addUrl, callback) {
            this.modal_loading = false;
            axios
                .post(URL.baseUrl(addUrl.add), this.form_data)
                .then((res) => {
                    if (res.data.status == 1) {
                        this.getList();
                        if (!this.form_data.id) {
                            this.modal_loading = true;
                            this.getResults(1);
                        } else {
                            this.modal_loading = true;
                        }
                    }
                    this.errors = null;
                    this.modal_loading = true;
                    this.showToster(res.data);
                    if (callback) {
                        callback();
                    }
                })
                .catch((error) => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                    var msg = "opps! something went wrong";
                    this.showToster({status: 0, message: msg});
                });
        },

        employeesSbu(option) {
            this.form_data.employee_sbu = option.id;
        },
        employeesSection(option) {
            this.form_data.employee_section = option.id;
        },
        employeesSubUnit(option) {
            this.form_data.employee_sub_unit = option.id;
        },
        employeesWorkLocation(option) {
            this.form_data.employee_work_location = option.id;
        },
        onSelectDepartment(option) {
            this.form_data.employee_department = option.id;
        },
        onSelectDistrict(option) {
            this.form_data.present_district = option.id;
        },
        onSelectPdistrict(option) {
            this.form_data.permanent_district = option.id;
        },
        onSelectPthana(option) {
            this.form_data.permanent_thana = option.id;
        },
        onSelectThana(option) {
            this.form_data.present_thana = option.id;
        },
        onSelectPunion(option) {
            this.form_data.present_union = option.id;
        },
        onSelectPrunion(option) {
            this.form_data.permanent_union = option.id;
        },
        onSelectDesignation(option) {
            this.form_data.employee_designation = option.id;
        },
        onSelectJobGrade(option) {
            this.form_data.employee_job_grade = option.id;
        },
        onSelectEmployee(option) {
            let uri = URL.baseUrl("employeemoreinfo/" + this.form_data.id);
            axios.get(uri)
                .then((res) => {
                    this.form_data = res.data;
                })
                .catch((error) => {
                    this.showToster({status: 0, message: "opps! something went wrong"});
                });

            this.form_data.id = option.id;
        },
        onFileChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.createImage(files[0]);
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                this.form_data.employee_image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        // setModalData(){
        //   this.sbu_name_value=this.form_data.sbu_name_value;
        //   this.section_value=this.form_data.section_value;
        //   this.department_name_value=this.form_data.department_name_value;
        //   this.designation_name_value=this.form_data.designation_name_value;
        //   this.jobgrade_name_value=this.form_data.jobgrade_name_value;
        //   this.sub_unit_value=this.form_data.sub_unit_value;
        //   this.employee_name_value=this.form_data.employee_name_value;
        //   this.work_location_value=this.form_data.work_location_value;
        // },
        resetModal() {
            this.sbu_name_value = "";
            this.section_value = "";
            this.department_name_value = "";
            this.designation_name_value = "";
            this.jobgrade_name_value = "";
            this.sub_unit_value = "";
            this.employee_name_value = "";
            this.employee_search_value = "";
            this.work_location_value = "";
            this.work_area_value = "";
            this.floor.value = "",
                this.form_data.employee_blood_group = "0";
            this.form_data.employee_nationality = "Bangladeshi";
            this.form_data.employee_status = 3;
            this.form_data.emplyee_category_mgt_non_mgt = "2";
            this.form_data.employee_leave_group = "1";
            this.form_data.employee_type = "2";
            this.form_data.make_user = "";
            this.form_data.user_type = "0";
            this.emplyeeIdEditeValue = 0;
            this.form_data.emplyeeIdEditeValue = 0;
        },

        selectMarried(event) {
            this.form_data.employee_marital_status = event.target.value;
            // alert(event.target.value);
            // if (event.target.value==2) {

            // $('#spouse_name').css('display', 'inline');
            // $('#spouse_name1').css('display', 'none');
            //  $('#no_of_children').css('display', 'inline');
            //  $('#no_of_children1').css('display', 'none');
            // }else{
            // $('#spouse_name').css('display', 'none');
            //  $('#no_of_children').css('display', 'none');
            // }
        },

        onSelectNID(employee_nid) {
            const nid_length = employee_nid.toString().length;
            if (nid_length == 0 || nid_length == 10 || nid_length == 13 || nid_length == 17) {
                if (nid_length == 0) {
                    this.resignation_message = 0;
                    exit();
                }
                let uri = URL.baseUrl("employeemoreinfo_nid_check/" + employee_nid);
                axios
                    .get(uri)
                    .then((res) => {
                        if (res.data == 1) {
                            this.resignation_message = 1;
                        } else {
                            this.resignation_message = 0;
                        }
                        // this.form_data = res.data;
                    })
                    .catch((error) => {
                        this.showToster({status: 0, message: "opps! something went wrong"});
                    });
            }
        },
    },
};

</script>
<style type="text/css">
.employee-search .multiselect__tags {
  border-bottom: 0px solid #cfcfcf !important;
}

.employee-search .multiselect {
  height: 22px;
  width: 97%;
  padding-top: 4px;
  padding-left: 5px;
  padding-bottom: 4px;
}

.tab-content label:not(.form-check-label):not(.custom-file-label) {
  margin-bottom: 0px !important;
}

.identification .vdp-datepicker input {
  border-bottom: none;
  height: 30px;
  padding-left: 15px;
}

.professional_datepicker .vdp-datepicker input {
  height: 30px !important;
  border: none !important;
  padding-left: 15px !important;
}

#applicant-list.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link {
  padding-left: 5px;
  text-align: left;
  border: 1px solid #ddd;
  /*padding-top: 10px;*/
  /*padding-bottom: 10px;*/
}

.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
  border-right: none !important;
  border-left: 1px solid #ddd !important;
}

.educationFields .form-control {
  font-size: 14px;
}

.modal-header {
  margin-bottom: 10px;
}

.identification_files {
  font-size: 14px;
  font-style: italic;
}

.modal-body {
  padding-top: 10px;
}
.employeeSerch > .multiselect > .multiselect__content-wrapper{
  width: 100% !important;
}
.background-shed input, .vdp-datepicker, .selectpicker{
  background: #fff9e8;
}
.background-shed select{
  background: #fff9e8;
}
.background-shed .multiselect__single{
  background: #fff9e8;
}
.background-shed .multiselect__tags{
  background: #fff9e8;
}
</style>
