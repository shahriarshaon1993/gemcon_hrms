<template>
  <div>
    <div v-if="page_loading" class="widget box">
      <div class="widget-header">
        <div>
          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="row">
                        <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px">
                          <h3 class="card-title d-none d-md-block">
                            Employee Info
                          </h3>
                          <span class="float-sm-right" style="float: right">
                            <!-- <div v-if="lists.add == 'add'" @click="
                              getModalData(
                                $event,
                                { dataUrl: 'create/employees' },
                                resetModal,
                                (requested_data = 2)
                              )
                            " class="btn-group">
                              <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span>
                            </div> -->

                            <router-link href="#" v-if="lists.add == 'add'" :to="'/employeemoreinfo/0'" class=""
                              title="Add More Data" style="border: 1px solid;margin-right: 5px;border-radius: 4px;padding: 5px;">
                              <i style="padding-right: 6px" class="fa fa-plus"></i>
                              Add New
                            </router-link>

                            <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                          </span>
                        </div>
                      </div>
                      <!--  Info boxes -->
                      <!--  Info boxes -->
                      <div class="row box-info">
                                  <div class="col-12 col-sm-6 col-md-2" style="max-width: 12.50%;">
                          <a @click="getDataActiveIctive('team')" style="color: #000">
                            <div class="info-box mb-3">
                              <span class="info-box-icon bg-primary  elevation-1"><i class="fas fa-users"></i></span>

                              <div class="info-box-content">
                                <span class="info-box-text">My Team</span>
                                <span class="info-box-number">{{
                                    lists.my_team_employees
                                }}</span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                          </a>
                          <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-2" style="max-width: 12.50%;">
                          <a href="dashboards#/companysbu_list" style="color: #000">
                            <div class="info-box">
                              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-industry"></i></span>

                              <div class="info-box-content">
                                <span class="info-box-text">Company</span>
                                <span class="info-box-number">
                                  {{ lists.company_count }}
                                  <!-- <small>%</small> -->
                                </span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                          </a>
                          <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-2" style="max-width: 12.50%;">
                          <a href="dashboards#/department_list" style="color: #000">
                            <div class="info-box mb-3">
                              <span class="info-box-icon bg-primary elevation-1"><i
                                  class="fas fa-university"></i></span>

                              <div class="info-box-content">
                                <span class="info-box-text">Department</span>
                                <span class="info-box-number">{{
                                    lists.department_count
                                }}</span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                          </a>
                          <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>

                        <div class="col-12 col-sm-6 col-md-2" style="max-width: 12.50%;">
                          <a href="dashboards#/designation_list" style="color: #000">
                            <div class="info-box mb-3">
                              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-cog"></i></span>

                              <div class="info-box-content">
                                <span class="info-box-text">Designation</span>
                                <span class="info-box-number">{{
                                    lists.designation_count
                                }}</span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                          </a>
                          <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-2" style="max-width: 12.50%;">
                          <a @click="getDataActiveIctive('Active')"  style="color: #000">
                            <div class="info-box mb-3">
                              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-text">Act. Emp.</span>
                                <span class="info-box-number">
                                  {{lists.employee_count}}
                                  </span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                          </a>
                          <!-- /.info-box -->
                        </div>

                        <div class="col-12 col-sm-6 col-md-2" style="max-width: 12.50%;">
                          <a @click="getDataActiveIctive('Inactive')" style="color: #000">
                            <div class="info-box mb-3">
                              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                              <div class="info-box-content">
                                <span class="info-box-text">Inact. Emp.</span>
                                <span class="info-box-number">{{
                                    lists.inactive_employee_count
                                }}</span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                          </a>
                          <!-- /.info-box -->
                        </div>

                        <div class="col-12 col-sm-6 col-md-2" style="max-width: 12.50%;">
                          <a @click="getDataActiveIctive('Resign')" style="color: #000">
                            <div class="info-box mb-3">
                              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

                              <div class="info-box-content">
                                <span class="info-box-text">Seper. Emp.</span>
                                <span class="info-box-number">{{
                                    lists.resign_semployee_count
                                }}</span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                          </a>
                          <!-- /.info-box -->
                        </div>
                         <div class="col-12 col-sm-6 col-md-2" style="max-width: 12.50%;">
                          <a @click="getDataActiveIctive('Joing')" style="color: #000">
                            <div class="info-box mb-3">
                              <span class="info-box-icon bg-secondary  elevation-1"><i class="fas fa-users"></i></span>

                              <div class="info-box-content">
                                <span class="info-box-text">New Joining</span>
                                <span class="info-box-number">{{
                                    lists.newJoining
                                }}</span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                          </a>
                          <!-- /.info-box -->
                        </div>

                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <!-- <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#all_employee" role="tab" aria-controls="home" aria-selected="true">All Employee</a>
                                  </li> -->
                        <!-- <li class="nav-item">
                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Active Employee</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Inactive Employee</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Resigned Employee</a>
                                  </li> -->
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="all_employee" role="tabpanel"
                          aria-labelledby="home-tab">
                          <div class="col-md-6 col-sm-6 col-6 float-left" style="padding: 10px 0px">
                            <div id="DataTables_Table_0_length" class="">
                              Show
                              <label>
                                <select class="form-control pagination-number" @change="onChange($event)"
                                  v-model="paginate_num" name="pageSize">
                                  <option value="1000000000000">All</option>
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
                                  <option value="100">100</option>
                                  <option value="200">200</option>
                                </select>
                              </label>
                              <!--  entries, List total: 120 -->
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6 col-6 float-left" style="padding: 10px 0px">
                            <div class="dataTables_filter" id="DataTables_Table_0_filter">
                              <label class="float-right">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="icon-search"></i></span>
                                  <button style="margin-right: 5px; font-size: 14px" class="btn btn-xs btn-info" @click="
                                    tableToExcel('table', 'Employee Data')
                                  ">
                                    Export to excel
                                  </button>
                                  <input v-on:keyup="getResults" v-model="search_input.search_key" type="text"
                                    aria-controls="DataTables_Table_0" class="form-control search-keyword" id="search"
                                    placeholder="Search..." style="border-radius: 0px" />
                                </div>
                              </label>
                            </div>
                          </div>
                          <table ref="table" id="loremTable" summary="lorem ipsum sit amet" rules="groups"
                            frame="hsides" class="
                              table table-bordered table-striped
                              employeeTable
                            ">
                            <thead>
                              <tr>
                                <th style="width: 4%" class="text-center">
                                  SL
                                </th>
                                <th style="width: 6%" class="text-center sortable" v-bind:class="
                                  getSortingClass('employee_id_no')
                                " @click="sortingChanged('employee_id_no')">
                                  Emp ID <i class="fas fa-sort"></i>
                                </th>
                                <th style="width: 16%" class="text-center sortable" v-bind:class="
                                  getSortingClass('employee_fullname')
                                " @click="sortingChanged('employee_fullname')">
                                  Name <i class="fas fa-sort"></i>
                                </th>
                                <th style="width: 13%" class="text-center sortable"
                                  v-bind:class="getSortingClass('sbu_name')" @click="sortingChanged('sbu_name')">
                                  Comp./SBU <i class="fas fa-sort"></i>
                                </th>
                                <th style="width: 13%" class="text-center sortable"
                                  v-bind:class="getSortingClass('section_name')"
                                  @click="sortingChanged('section_name')">
                                  Section <i class="fas fa-sort"></i>
                                </th>
                                <th style="width: 13%" class="text-center sortable" v-bind:class="
                                  getSortingClass('department_name')
                                " @click="sortingChanged('department_name')">
                                  Department <i class="fas fa-sort"></i>
                                </th>
                                <th style="width: 11%" class="text-center sortable" v-bind:class="
                                  getSortingClass('designation_name')
                                " @click="sortingChanged('designation_name')">
                                  Designation <i class="fas fa-sort"></i>
                                </th>
                                <th style="width: 7%" class="text-center sortable" v-bind:class="
                                  getSortingClass('employee_joining_date')
                                " @click="
  sortingChanged('employee_joining_date')
">
                                  Join. Date <i class="fas fa-sort"></i>
                                </th>
                                <th style="width: 7%" class="text-center sortable" v-bind:class="
                                  getSortingClass('employee_mobile')
                                " @click="sortingChanged('employee_mobile')">
                                  Mobile <i class="fas fa-sort"></i>
                                </th>
                                <th style="width: 5%" class="text-center sortable" v-bind:class="
                                  getSortingClass('employee_status')
                                " @click="sortingChanged('employee_status')">
                                  Status <i class="fas fa-sort"></i>
                                </th>
                                <th style="width: 5%" class="text-center">
                                  Action
                                </th>
                              </tr>
                            </thead>
                            <tbody v-if="Object.keys(paginate_data.data).length > 0">
                              <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">

                                <td class="text-center"
                                  @click="getModalData($event, { dataUrl: 'edit/employees/' + form_data.id, }, setModalData, (requested_data = 3))">
                                  <!-- <span href="#" > -->
                                  {{ order_no + index + 1 }}
                                  <!-- </span> -->
                                </td>
                                <td class="text-center"
                                  @click="getModalData($event, { dataUrl: 'edit/employees/' + form_data.id, }, setModalData, (requested_data = 3))">
                                  {{ form_data.employee_id_no }}
                                </td>
                                <td
                                  @click="getModalData($event, { dataUrl: 'edit/employees/' + form_data.id, }, setModalData, (requested_data = 3))">
                                  {{ form_data.employee_fullname }}
                                </td>
                                <td
                                  @click="getModalData($event, { dataUrl: 'edit/employees/' + form_data.id, }, setModalData, (requested_data = 3))">
                                  {{ form_data.sbu_name }}
                                </td>
                                <td
                                  @click="getModalData($event, { dataUrl: 'edit/employees/' + form_data.id, }, setModalData, (requested_data = 3))">
                                  {{ form_data.section_name }}
                                </td>
                                <td
                                  @click="getModalData($event, { dataUrl: 'edit/employees/' + form_data.id, }, setModalData, (requested_data = 3))">
                                  {{ form_data.department_name }}
                                </td>
                                <td
                                  @click="getModalData($event, { dataUrl: 'edit/employees/' + form_data.id, }, setModalData, (requested_data = 3))">
                                  {{ form_data.designation_name }}
                                </td>
                                <td class="text-center"
                                  @click="getModalData($event, { dataUrl: 'edit/employees/' + form_data.id, }, setModalData, (requested_data = 3))">
                                  {{ form_data.employee_joining_date }}
                                </td>
                                <td class="text-center"
                                  @click="getModalData($event, { dataUrl: 'edit/employees/' + form_data.id, }, setModalData, (requested_data = 3))">
                                  {{ form_data.employee_mobile }}
                                </td>
                                <td class="text-center">

                                  <span v-if="form_data.employee_status == 1" style="color: green">{{ "Active" }}</span>
                                  <span v-if="form_data.employee_status == 0" style="color: red">{{ "Inactive" }}</span>
                                  <span v-if="form_data.employee_status == 2" style="color: red">{{ "Resign" }}</span>
                                  <span v-if="form_data.employee_status == 3" style="color: red">{{ "New Joining" }}</span>
                                </td>
                                <td class="text-center">
                                  <div class="dropdown">
                                    <!-- <button class="dropbtn">Dropdown</button> -->
                                    <!-- <div class="dropdown"> -->
                                    <button class="dropdown-toggle" data-toggle="dropdown" style="
                                        border: none;
                                        background: transparent;
                                        width: 76px;
                                        padding: 10px;
                                      ">
                                      <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" style="
                                        min-width: 13rem;
                                        left: -76px !important;
                                      ">
                                      <li v-if="lists.edit == 'edit'">
                                        <!-- <a href="#">HTML</a> -->
                                        <a href="#" @click="
                                          getModalData(
                                            $event,
                                            {
                                              dataUrl:
                                                'edit/employees/' +
                                                form_data.id,
                                            },
                                            setModalData,
                                            (requested_data = 3)
                                          )
                                        " class="" title="Edit">
                                          <i style="padding-right: 6px" class="fa fa-edit">
                                          </i>
                                          Basic &nbsp; &nbsp; &nbsp; &nbsp;
                                          &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                        </a>
                                      </li>
                                      <!--  -->
                                      <!-- v-if="lists.more_info=='more_info'" -->
                                      <li>
                                        <router-link href="#" v-if="lists.more_info == 'more_info'" :to="
                                          '/employeemoreinfo/' + form_data.id
                                        " class="" title="Add More Data">
                                          <i style="padding-right: 6px" class="fa fa-plus"></i>
                                          More Details &nbsp; &nbsp; &nbsp;
                                          &nbsp; &nbsp;
                                        </router-link>
                                      </li>
                                      <li v-if="
                                        lists.appointment == 'appointment'
                                      ">
                                        <router-link href="#" :to="'/appointment/' + form_data.id +'/bn'" class=""
                                          title="Appointment Letter">
                                          <i style="padding-right: 6px" class="fa fa-envelope"></i>
                                          App. letter(বাংলা)
                                        </router-link>
                                      </li>
                                      <li v-if="
                                        lists.appointment == 'appointment'
                                      ">
                                        <router-link href="#" :to="'/appointment/' + form_data.id +'/en'" class=""
                                          title="Appointment Letter">
                                          <i style="padding-right: 6px" class="fa fa-envelope"></i>
                                          Appointment letter
                                        </router-link>
                                      </li>
                                      <li v-if="lists.idcard == 'idcard'">
                                        <router-link href="#" :to="'/idcard/' + form_data.id" class="" title="Profile">
                                          <i style="padding-right: 6px" class="fa fa-id-card"></i>
                                          ID Card &nbsp; &nbsp; &nbsp;
                                        </router-link>
                                      </li>
                                      <!--  -->
                                      <li v-if="
                                        lists.emp_profile == 'emp_profile'
                                      ">
                                        <router-link href="#" :to="
                                          '/employee_basic_profile/' + form_data.id
                                        " class="" title="Employee Profile">
                                          <i style="padding-right: 6px" class="fa fa-user-circle"></i>
                                          Basic Profile &nbsp; &nbsp; &nbsp; &nbsp;
                                        </router-link>
                                      </li>
                                      <li v-if="
                                        lists.emp_profile == 'emp_profile'
                                      ">
                                        <router-link href="#" :to="
                                          '/employeeprofile/' + form_data.id
                                        " class="" title="Profile">
                                          <i style="padding-right: 6px" class="fa fa-user"></i>
                                          Profile &nbsp; &nbsp; &nbsp; &nbsp;
                                          &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                        </router-link>
                                      </li>
                                      <!-- v-if="lists.leave_apply=='leave_apply'" -->
                                      <li v-if="
                                        lists.leave_apply == 'leave_apply'
                                      ">
                                        <a href="#" @click="
                                          getModalData(
                                            $event,
                                            {
                                              dataUrl:
                                                'emp_create/leaveapplication/' +
                                                form_data.id,
                                            },
                                            setModalData,
                                            setModalDataOthers1,
                                            (requested_data = 5),
                                            add_new_type =1
                                          )
                                        " class="" title="Edit">
                                          <i style="padding-right: 6px" class="fa fa-smile">
                                          </i>
                                          Leave Apply &nbsp; &nbsp; &nbsp;
                                          &nbsp; &nbsp;
                                        </a>
                                      </li>
                                      <!-- v-if="lists.manual_attendance=='manual_attendance'" -->
                                      <li v-if="
                                        lists.manual_attendance ==
                                        'manual_attendance'
                                      ">
                                        <a href="#" @click="
                                          getModalData(
                                            $event,
                                            {
                                              dataUrl:
                                                'emp_create/manualattendance/' +
                                                form_data.id,
                                            },
                                            setModalData,
                                            (requested_data = 7)
                                          )
                                        " class="" title="Edit">
                                          <i style="padding-right: 6px" class="fas fa-clock">
                                          </i>
                                          Manual Attendance
                                        </a>
                                      </li>
                                      <!-- v-if="lists.resign_request=='resign_request'" -->
                                      <li v-if="
                                        lists.resign_request ==
                                        'resign_request'
                                      ">
                                        <a href="#" @click="
                                          getModalData(
                                            $event,
                                            {
                                              dataUrl:
                                                'emp_create/resignation/' +
                                                form_data.id,
                                            },
                                            setModalData,
                                            setModalDataOthers1,
                                            (requested_data = 6)
                                          )
                                        " class="" title="Edit">
                                          <i style="padding-right: 6px" class="fas fa-sign-out-alt">
                                          </i>
                                          Resign Request &nbsp; &nbsp;
                                        </a>
                                      </li>
                                      <li v-if="
                                        lists.employee_transfer == 'employee_transfer'
                                      ">
                                        <a href="#" @click="
                                          getModalData(
                                            $event,
                                            {
                                              dataUrl:
                                                'edit/employees/' +
                                                form_data.id,
                                            },
                                            setModalData,
                                            setModalDataOthers,
                                            (requested_data = 8)
                                          )
                                        " class="" title="Edit">
                                          <i style="padding-right: 6px" class="fa fa-forward">
                                          </i>
                                          Employee Transfer
                                        </a>
                                      </li>
                                      <li v-if="
                                        lists.promotion_increment == 'promotion_increment'
                                      ">
                                        <a href="#" @click="
                                          getModalData(
                                            $event,
                                            {
                                              dataUrl:
                                                'promotion_increment_info/employees/' +
                                                form_data.id,
                                            },
                                            setModalData,
                                            setModalDataOthers,
                                            (requested_data = 9)
                                          )
                                        " class="" title="Edit">
                                          <i style="padding-right: 6px" class="fa fa-bullhorn">
                                          </i>
                                          Promotion&Increment
                                        </a>
                                      </li>
                                      <li v-if="
                                        lists.reset_password ==
                                        'reset_password'
                                      ">
                                        <a href="#" @click="
                                          getModalData(
                                            $event,
                                            {
                                              dataUrl:
                                                'edit/employees/' +
                                                form_data.id,
                                            },
                                            setModalData,
                                            (requested_data = 4)
                                          )
                                        " class="" title="Edit">
                                          <i style="padding-right: 6px" class="fa fa-key">
                                          </i>
                                          Reset Password
                                        </a>
                                      </li>
                                      <li v-if="lists.delete == 'delete'">
                                        <a href="#" @click="
                                          deleteItem({
                                            delUrl:
                                              'delete/employees/' +
                                              form_data.id,
                                          })
                                        " title="Delete" class=""><i style="padding-right: 6px"
                                            class="fa fa-trash"></i>
                                          Delete &nbsp; &nbsp; &nbsp; &nbsp;
                                          &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                          &nbsp; &nbsp; &nbsp;
                                        </a>
                                      </li>
                                      <li v-if="
                                        lists.emp_request == 'emp_request'
                                      ">
                                        <a href="#" @click="
                                          getModalData(
                                            $event,
                                            {
                                              dataUrl:
                                                'requested_data/employees/' +
                                                form_data.id,
                                            },
                                            setModalData,
                                            (requested_data = 1)
                                          )
                                        " class="btn btn-xs btn-secondary" title="Edit">
                                          <i style="padding-right: 6px" class="fa fa-check">
                                          </i>
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                            <tbody v-else>
                              <tr>
                                <td colspan="10" align="center">
                                  No data in database
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="row">
                            <div class="dataTables_footer clearfix" style="width: 100%">
                              <div class="col-md-6" style="float: left">
                                <div class="dataTables_info" id="DataTables_Table_0_info">
                                  Showing {{ paginate_data.current_page }} of
                                  {{ paginate_data.last_page }} pages
                                </div>
                              </div>
                              <div class="col-md-6" style="float: right">
                                <div class="dataTables_paginate paging_bootstrap">
                                  <pagination :data="paginate_data" :limit="2" @pagination-change-page="getResults">
                                  </pagination>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!--   <div class="row">
                                         <div class="dataTables_footer clearfix col-md-12 col-12" style="padding: 10px 0px;">
                                             <div class="col-md-6 col-6 float-left">
                                                 <div class="dataTables_info" id="DataTables_Table_0_info">Showing {{paginate_data.current_page}} of {{paginate_data.last_page}} pages</div>
                                             </div>
                                             <div class="col-md-6 col-6 float-right">
                                                 <div class="dataTables_paginate paging_bootstrap float-right overflow-auto" style="width: 100%;">
                                                   <pagination :data="paginate_data" @pagination-change-page="getResults"></pagination>

                                                 </div>
                                             </div>
                                         </div>
                                      </div> -->
                        </div>
                        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                          Active Employee
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                          Inactive Employee
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                          Resigned Employee
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
          <!-- /.content -->
        </div>

        <modal ref="modal" class="employee-modal" name="myModal" height="auto" style="overflow-y: clip"
          :clickToClose="false" body-class="p-0">
          <div v-if="modal_loading">
            <span v-if="requested_data == 2 || requested_data == 3">
              <div class="widget-header modal-header">
                <h4><i class="fa fa-bars"></i> Employee</h4>
                <button type="button" @click="hideModal" class="close close-modify" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form @submit.prevent="add({ add: 'add/employees' })" class="well form-horizontal needs-validation"
                enctype="multipart/form-data">
                <div class="modify-wraper modal-body">
                  <div class="row col-md-12">
                    <div v-if="errors" class="alert alert-danger" style="">
                      <div v-for="(error, index) in errors">
                        <span v-if="isObject(error)" v-for="err in error">{{
                            err
                        }}</span>
                        <span v-if="!isObject(error)">{{ error }}</span>
                      </div>
                    </div>
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
                          <div class="col-md-12 inputGroupContainer" v-if="form_data.id">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                              <input v-model="form_data.employee_id_no" class="form-control" required="true"
                                placeholder="000000" type="text" readonly />
                              <input v-model="form_data.employee_number" class="form-control" required="true"
                                type="hidden" />
                            </div>
                          </div>
                          <div class="col-md-12 inputGroupContainer" v-else>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                              <input v-model="form_data.employee_id_no" class="form-control" required="true"
                                placeholder="000000" type="text" />
                              <input v-model="form_data.employee_number" class="form-control" required="true"
                                type="hidden" />
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-8" v-if="lists.name == 'name'">
                          <label class="col-md-12 control-label">Full Name
                            <sup style="color: red; top: -2px">*</sup></label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                              <input v-model="form_data.employee_fullname" class="form-control" required="true"
                                type="text" />
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-6" v-if="lists.designation == 'designation'">
                          <label class="col-md-4 control-label">Designation</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="designation_name_value" :options="option_data.designation_data"
                                @select="onSelectDesignation" placeholder="Select one" label="text" track-by="text">
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-6" v-if="lists.jobgrade == 'jobgrade'">
                          <label class="col-md-12 control-label">Job Grade</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="jobgrade_name_value" :options="option_data.jobgrade_data"
                                @select="onSelectJobGrade" placeholder="Select one" label="text" track-by="text">
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-12" v-if="lists.sbu == 'sbu'">
                          <label class="col-md-12 control-label">Company/SBU
                            <sup style="color: red; top: -2px">*</sup></label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data"
                                @select="employeesSbu1" placeholder="Select one" label="text" track-by="text">
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-6" v-if="lists.unit == 'unit'">
                          <label class="col-md-12 control-label">Unit</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="form_data.unit_value" :options="option_data.unit_data"
                                @select="employeesUnit1" placeholder="Select one" label="text" track-by="text">
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-6" v-if="lists.subunit == 'subunit'">
                          <label class="col-md-12 control-label">Sub Unit</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="sub_unit_value" :options="option_data.sub_unit_data"
                                @select="employeesSubUnit1" placeholder="Select one" label="text" track-by="text">
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-12" v-if="lists.department == 'department'">
                          <label class="col-md-12 control-label">Department
                            <sup style="color: red; top: -2px">*</sup></label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="department_name_value" :options="option_data.department_data"
                                @select="onSelectDepartment1" placeholder="Select one" label="text" track-by="text">
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-6" v-if="lists.section == 'section'">
                          <label class="col-md-12 control-label">Section</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="form_data.section_value" :options="option_data.section_data"
                                @select="employeesSection1" placeholder="Select one" label="text" track-by="text">
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-6" v-if="lists.subsection == 'subsection'">
                          <label class="col-md-12 control-label">Sub Section</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="sub_section_value" :options="option_data.sub_section_data"
                                @select="employeesSubSection1" placeholder="Select one" label="text" track-by="text">
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-6" v-if="lists.worklocation == 'worklocation'">
                          <label class="col-md-12 control-label">Work Location</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                              <vue-select v-model="work_location_value" :options="option_data.work_location_data"
                                @select="employeesWorkLocation1" placeholder="Select one" label="text" track-by="text">
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-6" v-if="lists.worklocation == 'worklocation'">
                          <label class="col-md-12 control-label">Work Area </label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                              <vue-select v-model="work_area_value" :options="form_data.work_area_data"
                                @select="employeesArea" placeholder="Select one" label="text" track-by="text">
                              </vue-select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="form-group col-md-12"
                            v-if="form_data.employee_type != 2 && lists.employeetype == 'employeetype'">
                            <label class="col-md-12 control-label">Employment Type</label>
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <select v-model="form_data.employee_type" name="employee_type"
                                  class="selectpicker form-control">
                                  <option>--Select--</option>
                                  <option value="1">Permanent</option>
                                  <option value="2">Probationary</option>
                                  <option value="3">Cotractual</option>
                                  <option value="6">Casual</option>
                                  <option value="4">Temporary</option>
                                  <option value="5">Intern</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-6"
                            v-if="form_data.employee_type == 2 && lists.probmonth == 'probmonth'">
                            <label class="col-md-12 control-label">Employment Type</label>
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <select v-model="form_data.employee_type" name="employee_type"
                                  class="selectpicker form-control">
                                  <option>--Select--</option>
                                  <option value="1">Permanent</option>
                                  <option value="2">Probationary</option>
                                  <option value="3">Cotractual</option>
                                  <option value="6">Casual</option>
                                  <option value="4">Temporary</option>
                                  <option value="5">Intern</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-3"
                            v-if="form_data.employee_type == 2 && lists.probmonth == 'probmonth'">
                            <label class="col-md-12 control-label" style="padding: 0px">Prob/Cont Period</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                              <!-- @click="joining_dateSelected($event.target)"  v-on:input="joining_dateSelected($event.target)" v-on:keyup="joining_dateSelected($event.target)"  -->
                              <input v-model="form_data.employee_due_month" v-on:keyup="employeeType($event.target)"
                                class="form-control" required="true" type="text" />
                            </div>
                          </div>
                          <div class="form-group col-md-3"
                            v-if="form_data.employee_type == 2 && lists.duedate == 'duedate'">
                            <label class="col-md-12 control-label">Due Date</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                              <datepicker placeholder="Select Date" v-model="form_data.employee_confirmation_due_date"
                                class="form-control"></datepicker>
                              <!-- <input  v-model="form_data.employee_confirmation_due_date" readonly class="form-control" required="true" type="text"> -->
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-8" v-if="lists.employeegroup == 'employeegroup'">
                          <label class="col-md-12 control-label">Employee Group</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                              <vue-select v-model="employee_group_value" :options="option_data.employee_group_data"
                                @select="employeesGroup1" placeholder="Select one" label="text" track-by="text">
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-4" v-if="lists.leavegroup == 'leavegroup'">
                          <label class="col-md-12 control-label">Leave Group</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                              <select v-model="form_data.employee_leave_group" class="selectpicker form-control">
                                <option>--Select--</option>
                                <option value="1">General</option>
                                <option value="2">Special</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group" style="margin-bottom: 5px">
                        <div class="row inputGroupContainer">
                          <div class="col-md-6" v-if="lists.time == 'time'">
                            <div class="form-group">
                              <label class="col-md-12 control-label" style="padding: 0px">Office Time</label>
                              <div class="col-md-12 inputGroupContainer" style="padding: 0px">
                                {{ shift_time }}
                                <div class="input-group" v-if="form_data.shift_time == ''">
                                  <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-home"></i>
                                  </span>
                                  <span v-if="shift_time != ''">
                                    {{ shift_time }}
                                  </span>
                                  <span v-else>
                                    <span class="input-group-addon">
                                      <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    {{ "00:00:00" }}
                                  </span>
                                </div>
                                <div class="input-group" v-else>
                                  <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-home"></i>
                                  </span>
                                  <span>
                                    {{ form_data.shift_time }}
                                  </span>
                                </div>
                              </div>
                            </div>
                            <label class="col-md-12 control-label" style="padding: 0px; padding-left: 0px"
                              v-if="lists.image == 'image'">Image Upload</label>
                            <div class="input-group file-upload-form">
                              <input type="file" v-on:change="onFileChange" style="
                                  text-overflow: ellipsis;
                                  overflow: hidden;
                                  white-space: nowrap;
                                " accept="image/*" />
                            </div>
                            <label class="col-md-12 control-label" style="padding-left: 0px; margin-top: 15px"
                              v-if="lists.employeecategory == 'employeecategory'">Employee Category</label>
                            <div class="col-md-12 inputGroupContainer" style="padding: 0px">
                              <div class="input-group" v-if="lists.employeecategory == 'employeecategory'">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <select v-model="
                                  form_data.emplyee_category_mgt_non_mgt
                                " name="employee_status" class="selectpicker form-control">
                                  <option>--Select--</option>
                                  <option value="1">Management</option>
                                  <option value="2">Non-Management</option>
                                </select>
                              </div>
                            </div>
                            <label class="col-md-12 control-label" style="padding-left: 0px; margin-top: 15px"
                              v-if="lists.religion == 'religion'">Religion</label>
                            <div class="col-md-12 inputGroupContainer" style="padding: 0px">
                              <div class="input-group" v-if="lists.religion == 'religion'">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <select v-model="form_data.employee_religion" class="selectpicker form-control">
                                  <option value="0">Select</option>
                                  <option value="1">Islam</option>
                                  <option value="2">Hinduism</option>
                                  <option value="3">Christianity</option>
                                  <option value="4">Buddhism</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6" style="margin-bottom: 0px">
                            <div class="image-preview text-center col-md-12" style="right: -27px">
                              <samp v-if="form_data.employee_image">
                                <img :src="`images/${form_data.employee_image}`" class="card-img-top border rounded"
                                  style="
                                    margin-top: 2px;
                                    width: 130px;
                                    height: 157px;
                                  " />
                              </samp>
                              <samp v-else>
                                <img v-if="
                                  url !== '' ||
                                  form_data.employee_image !== ''
                                " :src="`images/default.png`" class="card-img-top border rounded" style="
                                    margin-top: 2px;
                                    width: 130px;
                                    height: 157px;
                                  " />
                              </samp>
                              <div class="col-md-12 text-center" style="margin-top: 0px; padding-left: 0px"
                                v-if="lists.status == 'status'">
                                <label class="switch" v-if="
                                  form_data.employee_status == 1 ||
                                  form_data.employee_status == 0
                                ">
                                  <input type="checkbox" v-model="form_data.employee_status" checked />
                                  <span class="slider round"></span>
                                </label>
                                <label class="switch" v-if="form_data.employee_status == 2">
                                  <input type="checkbox" v-model="separation_status" checked />
                                  <span class="slider round"></span>
                                </label>
                                <label v-if="form_data.employee_status == 1">Active</label>
                                <label v-if="form_data.employee_status == 0">Inactive</label>
                                <label v-if="form_data.employee_status == 2">Separation</label>
                                <label v-if="form_data.employee_status == 3"> New Joining</label>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <!-- <div class="form-group col-md-6">
                          <label class="col-md-12 control-label"
                            >Date of Birth (Certificate)
                            <sup style="color: red; top: -2px">*</sup></label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <datepicker
                                placeholder="Select Date"
                                style="width: 131% !important"
                                v-model="form_data.employee_dob_certificate"
                                class="form-control"
                              ></datepicker>
                            </div>
                          </div>
                        </div> -->
                        <!-- <div class="form-group col-md-6">
                          <label class="col-md-12 control-label"
                            >Date of Birth (Actual)
                          </label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <datepicker
                                placeholder="Select Date"
                                v-model="form_data.employee_dob_actual"
                                class="form-control"
                              ></datepicker>
                            </div>
                          </div>
                        </div> -->
                        <!-- <div class="form-group col-md-6">
                          <label class="col-md-12 control-label"
                            >Interview Date</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <datepicker
                                placeholder="Select Date"
                                v-model="form_data.employee_interview_date"
                                class="form-control"
                              ></datepicker>
                            </div>
                          </div>
                        </div> -->
                        <!-- <div class="form-group col-md-6">
                          <label class="col-md-12 control-label"
                            >Appoinment Date</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <datepicker
                                placeholder="Select Date"
                                v-model="form_data.employee_appoinment_date"
                                class="form-control"
                              ></datepicker>
                            </div>
                          </div>
                        </div> -->
                        <div class="form-group col-md-6" v-if="lists.joiningdate == 'joiningdate'">
                          <label class="col-md-12 control-label">Joining Date</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <datepicker placeholder="Select Date" @click="joining_dateSelected($event.target)"
                                v-on:input="joining_dateSelected($event.target)"
                                v-on:keyup="joining_dateSelected($event.target)"
                                v-model="form_data.employee_joining_date" class="form-control"></datepicker>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6" v-if="lists.pmobile == 'pmobile'">
                          <label class="col-md-12 control-label">Mobile No.(Personal)</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon" style="max-width: 100%"><i
                                  class="glyphicon glyphicon-list"></i></span>
                              <input v-model="form_data.employee_mobile" id="mobile_number" name="mobile_number"
                                placeholder="" class="form-control" type="text" />
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-6" v-if="lists.omobile == 'omobile'">
                          <label class="col-md-12 control-label">Mobile No. (Official)</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <input v-model="form_data.official_mobile_no" placeholder="" class="form-control"
                                type="text" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-8" v-if="lists.emailid == 'emailid'">
                          <label class="col-md-12 control-label">Email ID (Official)</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <input v-model="form_data.official_email_id" placeholder="" class="form-control"
                                type="email" />
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-4" v-if="lists.pabx == 'pabx'">
                          <label class="col-md-12 control-label">PABX Number</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <input v-model="form_data.desk_phone_no" placeholder="" class="form-control"
                                type="number" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group" v-if="lists.reporting == 'reporting'">
                        <label class="col-md-6 control-label">Reporting to/Superior</label>
                        <div class="col-md-12 inputGroupContainer">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                            <vue-select v-model="employee_name_value" :options="option_data.employee_data"
                              @select="onSelectEmployee1" placeholder="Select one" label="text" track-by="text">
                            </vue-select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-4" v-if="lists.durationtype == 'durationtype'">
                          <label class="col-md-12 control-label">Duration type</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                              <select v-model="form_data.salary_duration_type" class="selectpicker form-control">
                                <option>--Select--</option>
                                <option value="1">Weekly</option>
                                <option value="2">Monthly</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-4" v-if="lists.attendancebonus == 'attendancebonus'">
                          <label class="col-md-12 control-label">Attendance Bonus</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                              <select v-model="form_data.attendance_bonus_get" class="selectpicker form-control">
                                <option>--Select--</option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-4" v-if="lists.salarytype == 'salarytype'">
                          <label class="col-md-12 control-label">Employee salary type</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                              <select v-model="form_data.employee_salary_type" class="selectpicker form-control">
                                <option>--Select--</option>
                                <option value="1">Time Based</option>
                                <option value="2">Production Based</option>
                                <option value="3">Residential Based</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div v-if="form_data.make_user == 1 && lists.portaluser == 'portaluser'" class="row">
                        <div class="form-group col-md-6">
                          <div class="col-md-12 inputGroupContainer" style="margin-top: 15px">
                            <label class="col-md-12 control-label" style="padding-left: 0px">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input type="checkbox" style="margin: 5px 5px 0 0" checked @input="addEvent"
                                  @change="addEvent" />
                                Enable Portal User?
                              </div>
                            </label>
                          </div>
                        </div>
                        <div v-if="form_data.make_user == 1" id="user_type_id" class="form-group col-md-6"
                          style="padding-left: 0px">
                          <div class="col-md-12 inputGroupContainer" style="margin-top: 15px">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                              <select v-model="form_data.user_type" name="employee_status"
                                class="selectpicker form-control">
                                <option value="0">-- User Type --</option>
                                <option v-if="form_data.role_id <= 1" value="1">
                                  Group User
                                </option>
                                <option v-if="form_data.role_id <= 2" value="2">
                                  SBU/Company User
                                </option>
                                <option v-if="form_data.role_id <= 3" value="3">
                                  Unit User
                                </option>
                                <option v-if="form_data.role_id <= 4" value="4">
                                  Sub Unit User
                                </option>
                                <option v-if="form_data.role_id <= 5" value="5">
                                  Department User
                                </option>
                                <option v-if="form_data.role_id <= 6" value="6">
                                  Section User
                                </option>
                                <option v-if="form_data.role_id <= 7" value="7">
                                  Sub Section User
                                </option>
                                <option v-if="form_data.role_id <= 8" value="8">
                                  Employee User
                                </option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row" v-else>
                        <div class="form-group col-md-6" v-if="lists.portaluser == 'portaluser'">
                          <div class="col-md-12 inputGroupContainer" style="margin-top: 15px">
                            <label class="col-md-12 control-label" style="padding-left: 0px">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input type="checkbox" style="margin: 5px 5px 0 0" @input="addEvent"
                                  @change="addEvent" />
                                Enable Portal User?
                              </div>
                            </label>
                          </div>
                        </div>
                        <div v-if="make_user == 1" id="user_type_id" class="form-group col-md-6"
                          style="padding-left: 0px">
                          <div class="col-md-12 inputGroupContainer" style="margin-top: 15px; padding: 0px">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                              <select v-model="form_data.user_type" name="employee_status"
                                class="selectpicker form-control">
                                <option value="0">-- User Type --</option>
                                <option value="1">Group User</option>
                                <option value="2">SBU/Company User</option>
                                <option value="3">Unit User</option>
                                <option value="4">Sub Unit User</option>
                                <option value="5">Department User</option>
                                <option value="6">Section User</option>
                                <option value="7">Sub Section User</option>
                                <option value="8">Employee User</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-12" v-if="lists.reporting == 'reporting'">
                      <br />
                      <label class="col-md-12 control-label" style="margin-bottom: 5px">
                        Approval Level
                      </label>
                      <div class="col-md-11 inputGroupContainer float-left" style="margin-bottom: 5px">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                          <vue-select v-model="approvalnamevalue1" :options="option_data.employee_data_approval"
                            @select="onSelectEmployeeApproval" placeholder="Select one" label="text" track-by="text">
                          </vue-select>
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
                        " id="addCF" class="btn btn-xs btn-success"><i class="fa fa-plus" style="color: #fff"></i></a>
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
                        <tr style="border: 1px solid #cfcfcf" v-for="(formData, index) in form_data.approval_infos"
                          v-if="formData.employees_ids != ''">
                          <td style="text-align: center">{{ index + 1 }}</td>
                          <td style="text-align: center">
                            {{ formData.employees_ids }}
                          </td>
                          <td>{{ formData.ea_approve_by_name }}</td>
                          <td style="text-align: right">
                            <a @click="deleteRow(index)" id="remCF" class="btn btn-xs btn-danger"><i
                                class="fa fa-times"></i></a>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="form-actions" style="margin-top: 5px;">
                  <input type="submit" tabindex="4" value="Save" class="btn-disabled btn btn-md btn-info float-right" />
                  <button type="button" @click="hideModal" class="btn btn-md btn-default float-right"
                    style="margin-right: 10px">
                    Close
                  </button>
                </div>
              </form>
            </span>
            <span v-else-if="requested_data == 1">
              <div class="widget-header modal-header">
                <h4><i class="fa fa-bars"></i>Employee's Request</h4>
                <button type="button" @click="hideModal" class="close close-modify" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modify-wraper modal-body" style="padding-top: 15px;s">
                <div class="col-md-12">
                  <label for="current-password" class="col-sm-4 control-label float-left">Personal Email</label>
                  <div class="col-sm-7 float-left">
                    <div class="form-group">
                      <input v-model="general_data_temp.personal_email_id" type="email" class="form-control"
                        name="personal_email_id" placeholder="Email ID"
                        :readonly="general_data_temp.personal_email_id" />
                    </div>
                  </div>
                  <div class="col-sm-1 float-left">
                    <button class="btn btn-sm btn-secondary" @click="
                      requestAccept(
                        1,
                        general_data_temp.created_by,
                        general_data_temp.personal_email_id
                      )
                    ">
                      <i class="fa fa-check"></i>
                    </button>
                  </div>
                  <label for="password" class="col-sm-4 control-label float-left">Personal Mobile</label>
                  <div class="col-sm-7 float-left">
                    <div class="form-group">
                      <input v-model="general_data_temp.personal_mobile_no" type="number" class="form-control"
                        name="personal_mobile_no" placeholder="Mobile No."
                        :readonly="general_data_temp.personal_mobile_no" />
                    </div>
                  </div>
                  <div class="col-sm-1 float-left">
                    <button class="btn btn-sm btn-secondary" @click="
                      requestAccept(
                        2,
                        general_data_temp.created_by,
                        general_data_temp.personal_mobile_no
                      )
                    ">
                      <i class="fa fa-check"></i>
                    </button>
                  </div>
                  <label for="password_confirmation" class="col-sm-4 control-label float-left">WhatsApp</label>
                  <div class="col-sm-7 float-left">
                    <div class="form-group">
                      <input v-model="general_data_temp.whatsapp" type="text" class="form-control"
                        id="password_confirmation" name="whatsapp" placeholder="WhatsApp"
                        :readonly="general_data_temp.whatsapp" />
                    </div>
                  </div>
                  <div class="col-sm-1 float-left">
                    <button class="btn btn-sm btn-secondary" @click="
                      requestAccept(
                        3,
                        general_data_temp.created_by,
                        general_data_temp.whatsapp
                      )
                    ">
                      <i class="fa fa-check"></i>
                    </button>
                  </div>
                  <label for="password_confirmation" class="col-sm-4 control-label float-left">Desk Phone</label>
                  <div class="col-sm-7 float-left">
                    <div class="form-group">
                      <input v-model="general_data_temp.desk_phone" type="number" class="form-control"
                        id="password_confirmation" name="desk_phone" placeholder="Desk Phone"
                        :readonly="general_data_temp.desk_phone" />
                    </div>
                  </div>
                  <div class="col-sm-1 float-left">
                    <button class="btn btn-sm btn-secondary" @click="
                      requestAccept(
                        4,
                        general_data_temp.created_by,
                        general_data_temp.desk_phone
                      )
                    ">
                      <i class="fa fa-check"></i>
                    </button>
                  </div>
                  <label for="password_confirmation" class="col-sm-4 control-label float-left">Skype</label>
                  <div class="col-sm-7 float-left">
                    <div class="form-group">
                      <input v-model="general_data_temp.skype_no" type="text" class="form-control" name="skype_no"
                        placeholder="Skype" :readonly="general_data_temp.skype_no" />
                    </div>
                  </div>
                  <div class="col-sm-1 float-left">
                    <button class="btn btn-sm btn-secondary" @click="
                      requestAccept(
                        5,
                        general_data_temp.created_by,
                        general_data_temp.skype_no
                      )
                    ">
                      <i class="fa fa-check"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="form-actions" style="margin-top: 5px; ">
                <input type="submit" tabindex="4" value="Submit" class="btn btn-md btn-info float-right" />
                <button type="button" @click="hideModal" class="btn btn-md btn-default float-right"
                  style="margin-right: 10px">
                  Close
                </button>
              </div>
              <!-- </form> -->
            </span>
            <span v-else-if="requested_data == 4">
              <div class="widget-header modal-header">
                <h4><i class="fa fa-bars"></i>Reset Password</h4>
                <button type="button" @click="hideModal" class="close close-modify" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form @submit.prevent="add({ add: 'reset_password/employees' })"
                class="well form-horizontal needs-validation" enctype="multipart/form-data">
                <div class="modify-wraper modal-body" style="padding-top: 15px;s">
                  <div class="col-md-12">
                    <input v-model="form_data.id" type="hidden" class="form-control" name="personal_email_id"
                      placeholder="Email ID" />
                    <label for="password" class="col-sm-4 control-label float-left">New Password</label>
                    <div class="col-sm-7 float-left">
                      <div class="form-group">
                        <input v-model="form_data.new_password" type="password" class="form-control"
                          placeholder="New Password" />
                      </div>
                    </div>
                    <label for="password_confirmation" class="col-sm-4 control-label float-left">Re-enter
                      Password</label>
                    <div class="col-sm-7 float-left">
                      <div class="form-group">
                        <input v-model="form_data.reenter_password" type="password" class="form-control"
                          id="password_confirmation" placeholder="Re-enter Password" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-actions" style="margin-top: 5px;">
                  <input type="submit" tabindex="4" value="Submit" class="btn btn-md btn-info float-right" />
                  <button type="button" @click="hideModal" class="btn btn-md btn-default float-right"
                    style="margin-right: 10px">
                    Close
                  </button>
                </div>
              </form>
            </span>

            <span v-if="requested_data == 5">
              <div class="widget-header modal-header">
                <h4><i class="fas fa-bars"></i> Leave Application</h4>
                <button type="button" @click="hideModal" class="close close-modify" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modify-wraper modal-body1">
                <!-- <div class="col-md-12" >
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Search Employee</label>
                            <vue-select v-model="employee_name_search" :options="option_data.employee_data" @select="onSelectEmployeeSearch" placeholder="Select one" label="text" track-by="text"></vue-select>
                          </div>
                        </div>
                      </div> -->
                <div class="row col-md-12">
                  <div v-if="errors" class="alert alert-danger" style="">
                    <div v-for="(error, index) in errors">
                      <span v-if="isObject(error)" v-for="err in error">{{
                          err
                      }}</span>
                      <span v-if="!isObject(error)">{{ error }}</span>
                    </div>
                  </div>
                  <div class="col-md-6 employee-info-table">
                    <table v-if="
                      form_data.user_employee_data
                        ? form_data.user_employee_data.employee_id_no
                        : ''
                    " class="table table-hover table-responsive">
                      <tbody>
                        <tr>
                          <td>Employee ID</td>
                          <td>:</td>
                          <td>
                            <input type="hidden" v-model="form_data.employee_id" name="" />
                            {{ form_data.user_employee_data.employee_id_no }}
                          </td>
                        </tr>
                        <tr>
                          <td>Employee Name</td>
                          <td>:</td>
                          <td>
                            {{ form_data.user_employee_data.employee_fullname }}
                          </td>
                        </tr>
                        <tr>
                          <td>Designation</td>
                          <td>:</td>
                          <td>
                            {{ form_data.user_employee_data.designation_name }}
                          </td>
                        </tr>
                        <tr>
                          <td>Department</td>
                          <td>:</td>
                          <td>
                            {{ form_data.user_employee_data.department_name }}
                          </td>
                        </tr>
                        <tr>
                          <td>Company/SBU/Project</td>
                          <td>:</td>
                          <td>{{ form_data.user_employee_data.sbu_name }}</td>
                        </tr>
                        <tr>
                          <td>Contact Phone</td>
                          <td>:</td>
                          <td>
                            {{ form_data.user_employee_data.employee_mobile }}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-3 leave-info text-center">
                    <h5 style="font-size: 18px; font-weight: bold" v-if="totalDays">
                      {{ totalDayss }} Days of {{ leave_type_value.text }} Leave
                    </h5>
                    <h6 v-if="this.remaining_days">
                      {{ this.remaining_days }} days remaining
                    </h6>
                  </div>
                  <div class="col-md-3 leave-info text-right">
                    <span v-if="form_data.user_employee_data">
                      <img :src="`images/${form_data.user_employee_data.employee_image}`"
                        class="card-img-top border rounded" style="margin-top: 2px; width: 150px; height: 170px" />
                    </span>
                    <span v-else>
                      <img v-if="
                        url !== '' ||
                        form_data.user_employee_data.employee_image !== ''
                      " :src="`images/default.png`" class="card-img-top border rounded"
                        style="margin-top: 2px; width: 150px; height: 170px" />
                    </span>
                  </div>
                </div>
                <form class="
                    well
                    form-horizontal
                    needs-validation
                    leave-application
                  " @submit.prevent="add({ add: 'add/leaveapplication' })">
                  <input type="hidden" v-model="form_data.employee_form_submit" />
                  <input type="hidden" v-model="form_data.employee_id" />
                  <input type="hidden" v-model="form_data.add_new_type" />
                  <div class="row" style="margin: 0px">
                    <div class="col-md-12">
                      <div class="col-md-7 float-left">
                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important">
                          <div class="col-md-4 float-left" style="padding-left: 0px">
                            <label class="control-label">Leave Type
                              <span class="required_sign">*</span></label>
                          </div>
                          <div class="col-md-8 float-left inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                              <vue-select v-model="leave_type_value" :options="option_data.leave_type_data"
                                @select="leaveTypeList" placeholder="Select one" label="text" track-by="text">
                              </vue-select>
                            </div>
                          </div>
                        </div>

                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important">
                          <div class="col-md-4 float-left" style="padding-left: 0px">
                            <label class="control-label">Date <span class="required_sign">*</span></label>
                          </div>
                          <div class="col-md-8 float-left inputGroupContainer" style="padding-right: 0px">
                            <div class="form-group datepicker-container">
                              <div class="col-md-5 float-left" style="padding: 0px">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <div class="col-md-12" style="padding: 0px">
                                    <input v-model="form_data.leave_from_date" type="date" ref="input"
                                      v-on:input="updateValue($event.target)" v-on:focus="selectAll"
                                      v-on:keyup="updateValue($event.target)" @click="updateValue($event.target)"
                                      style="width: 100%" />
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-5 float-left" style="padding: 0px">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <div class="col-md-12" style="padding: 0px">
                                    <input v-model="form_data.leave_to_date" type="date" ref="input"
                                      v-on:input="updateValue($event.target)" v-on:focus="selectAll"
                                      v-on:keyup="updateValue($event.target)" @click="updateValue($event.target)"
                                      style="width: 100%" />
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-2 float-right" style="padding: 0px">
                                <div class="col-md-12">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <div class="col-md-12" style="padding: 0px">
                                      {{ totalDays }}
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important">
                          <div class="col-md-4 float-left" style="padding-left: 0px">
                            <label class="control-label">Reason for Leave
                              <span class="required_sign">*</span></label>
                          </div>
                          <div class="col-md-8 float-left inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                              <textarea v-model="form_data.leave_reason" id="city" name="city" placeholder=""
                                class="form-control" required="true" type="text"></textarea>
                            </div>
                          </div>
                        </div>

                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important">
                          <div class="col-md-4 float-left" style="padding-left: 0px">
                            <label class="control-label">Address, on Leave<span class="required_sign">*</span></label>
                          </div>
                          <div class="col-md-8 float-left inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                              <textarea v-model="form_data.address_leave" id="city" name="city" placeholder=""
                                class="form-control" required="true" type="text"></textarea>
                            </div>
                          </div>
                        </div>

                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important">
                          <div class="col-md-4 float-left" style="padding-left: 0px">
                            <label class="control-label">Responsibe
                              <!-- <span class="required_sign">*</span> -->
                              </label>
                          </div>
                          <div class="col-md-8 float-left inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                              <vue-select v-model="employee_name_value" :options="option_data.employee_data"
                                @select="onSelectEmployeeLeave" placeholder="Select one" label="text" track-by="text">
                              </vue-select>
                            </div>
                          </div>
                        </div>

                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important">
                          <div class="col-md-4 float-left" style="padding-left: 0px">
                            <label class="control-label">Responsible Contact
                              <!-- <span class="required_sign">*</span> -->
                              </label>
                          </div>
                          <div class="col-md-8 float-left inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                              <input v-model="form_data.leave_reliever_contact" id="email" name="email" placeholder=""
                                class="form-control" type="text" />
                            </div>
                          </div>
                        </div>
                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important">
                          <div class="col-md-4 float-left" style="padding-left: 0px">
                            <label class="control-label">Upload Attachment</label>
                          </div>
                          <div class="col-md-8 float-left inputGroupContainer">
                            <div class="col-md-4 inputGroupContainer float-left">
                              <input type="file" v-on:change="onFileChange" />
                            </div>
                            <div v-if="
                              form_data.leave_attachment
                                ? form_data.leave_attachment
                                : ''
                            " class="col-md-6 float-right text-right">
                              <a target="_blank" :href="
                                '/attachments/' + form_data.leave_attachment
                              ">View Attachment</a>
                            </div>
                            <div v-else-if="form_data.leave_attachment == ''" class="col-md-6 float-right text-right">
                              <p style="color: orange">No attachment found!</p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-5 float-left">
                        <!-- <h5>Leave Status</h5> -->
                        <label class="control-label">Leave Status </label>
                        <table width="100%" class="
                            table table-hover table-bordered table-responsive
                          ">
                          <thead>
                            <tr class="text-center;">
                              <th style="
                                  width: 10%;
                                  text-align: center;
                                  vertical-align: middle;
                                  background: #f5f5f5;
                                ">
                                Type
                              </th>
                              <th style="
                                  width: 20%;
                                  text-align: center;
                                  vertical-align: middle;
                                  background: #f5f5f5;
                                ">
                                Entitle.
                              </th>
                              <th style="
                                  width: 20%;
                                  text-align: center;
                                  vertical-align: middle;
                                  background: #f5f5f5;
                                ">
                                Prev. Balance
                              </th>
                              <th style="
                                  width: 20%;
                                  text-align: center;
                                  vertical-align: middle;
                                  background: #f5f5f5;
                                ">
                                Total Entitle.
                              </th>
                              <th style="
                                  width: 15%;
                                  text-align: center;
                                  vertical-align: middle;
                                  background: #f5f5f5;
                                ">
                                Availed
                              </th>
                              <th style="
                                  width: 15%;
                                  text-align: center;
                                  vertical-align: middle;
                                  background: #f5f5f5;
                                ">
                                Balance
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- {{form_dat/a.leaveInfo}} -->
                            <tr v-for="(form_data, index) in form_data.leaveInfo" v-bind:key="form_data.id">
                              <td>{{ form_data.leave_type_name }}</td>
                              <td class="text-center">
                                {{ form_data.entitlementThisYear }}
                              </td>
                              <td class="text-center">
                                {{ form_data.previousBalance }}
                              </td>
                              <td class="text-center">
                                {{ form_data.totalEntitlement }}
                              </td>
                              <td class="text-center">
                                {{ form_data.totalDay }}
                              </td>
                              <td class="text-center">
                                {{ form_data.balance }}
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <input type="text" v-model="form_data.designation_name"
                          style="border: none; background: transparent" readonly />
                        <br />
                        <input type="text" v-model="form_data.sbu_name" style="border: none; background: transparent"
                          readonly />
                      </div>
                    </div>
                    <input type="hidden" v-model="form_data.leave_apply_type" class="lwutpay" name="apply_type"
                       /><!--  With Pay -->
                    <input type="hidden" v-model="form_data.leave_apply_type" class="lwutpay" name="apply_type"
                       />
                    <!-- Without Pay -->
                    <input v-model="form_data.leave_with_holiday" type="hidden" name="leave_holiday"
                      class="leave_holiday"  checked />
                    <!-- No -->
                    <input v-model="form_data.leave_with_holiday" type="hidden" name="leave_holiday"
                      class="leave_holiday"  />
                    <!-- Yes -->
                    <!-- hidden field -->
                  </div>
                  <div class="form-actions col-md-12">
                    <input type="submit" tabindex="4" value="Apply" class="btn btn-sm btn-info float-right col-md-2" />
                    <button type="button" @click="hideModal" class="
                        btn btn-sm btn-default
                        float-right
                        col-md-2
                        offset-md-6
                      " style="margin-right: 10px">
                      Close
                    </button>
                  </div>
                </form>
              </div>
            </span>
            <span v-if="requested_data == 6">
              <div class="widget-header modal-header">
                <h4><i class="fa fa-bars"></i> Resignation</h4>
                <button type="button" @click="hideModal" class="close close-modify" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modify-wraper modal-body" v-if="form_data.user_employee_data">
                <span>
                  <form class="" @submit.prevent="add({ add: 'add/resignation' })">
                    <div class="row col-md-12" style="
                        overflow-y: auto !important;
                        margin-top: 15px;
                        margin-bottom: 15px;
                      ">
                      <div class="col-md-5 leave-info">
                        <div class="col-md-12" v-if="add_new_type == 2">
                          <div class="form-group">
                            <label>Search Employee</label>
                            <vue-select v-model="employee_name_search" :options="option_data.employee_data"
                              @select="onSelectEmployeeSearch" placeholder="Select one" label="text" track-by="text">
                            </vue-select>
                          </div>
                        </div>
                        <input type="hidden" v-model="form_data.employee_form_submit" />
                        <!-- <input type="hidden" v-model="form_data.user_employee_data.id"> -->
                        <input type="hidden" v-model="form_data.employee_id" />
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group datepicker-container">
                              <div class="form-group">
                                <label class="col-md-12 control-label">Separation Type</label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <select v-model="form_data.separation_type" name="employee_type"
                                      class="selectpicker form-control" @change="onSelectSeparationType($event)">
                                      <option value="0">--Select--</option>
                                      <option value="1">Resignation</option>
                                      <option value="2">Termination</option>
                                      <option value="3">Retired</option>
                                      <option value="4">Retracement</option>
                                      <option value="5">Died</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-4 control-label">Reason</label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input style="padding-left: 0px" v-model="form_data.separation_reason" id="remarks"
                                      name="remarks" placeholder="" class="form-control" required="true" type="text" />
                                  </div>
                                </div>
                              </div>
                              <div class="form-group co-md-12">
                                <label class="col-md-12 control-label">{{ this.resignation_type_name }} Date</label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <input v-model="form_data.separation_date" type="date" ref="input"
                                      style="padding-left: 0px; width: 100%" />
                                  </div>
                                </div>
                              </div>
                              <div class="form-group co-md-12">
                                <label class="col-md-12 control-label">Last Working Date</label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <input v-model="form_data.last_working_date" type="date" ref="input"
                                      v-on:input="updateValue1($event.target)" v-on:focus="selectAll"
                                      v-on:keyup="updateValue1($event.target)"
                                      v-on:keydown="updateValue1($event.target)"
                                      style="padding-left: 0px; width: 100%" />
                                  </div>
                                </div>
                              </div>
                              <div class="form-group co-md-12">
                                <label class="col-md-12 control-label">Effective Date</label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <datepicker style="padding-left: 0px" v-if="
                                      form_data.effective_date && form_data.id
                                    " placeholder="Select Date" v-model="form_data.effective_date"
                                      class="form-control"></datepicker>

                                    <datepicker v-else style="padding-left: 0px" placeholder="Select Datee"
                                      v-model="effective_date" class="form-control"></datepicker>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-5 employee-info">
                        <table v-if="
                          form_data.user_employee_data
                            ? form_data.user_employee_data.employee_id_no
                            : ''
                        " class="table table-hover table-responsive">
                          <tbody>
                            <tr>
                              <td>Employee ID</td>
                              <td>:</td>
                              <td>
                                {{
                                    form_data.user_employee_data.employee_id_no
                                }}
                              </td>
                            </tr>
                            <tr>
                              <td>Name</td>
                              <td>:</td>
                              <td>
                                {{
                                    form_data.user_employee_data.employee_fullname
                                }}
                              </td>
                            </tr>
                            <tr>
                              <td>Contact No</td>
                              <td>:</td>
                              <td>
                                {{
                                    form_data.user_employee_data.employee_mobile
                                }}
                              </td>
                            </tr>
                            <tr>
                              <td>Joining Date</td>
                              <td>:</td>
                              <td>
                                {{ form_data.employee_joining_date_custom }}
                              </td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>
                                <span v-if="
                                  form_data.user_employee_data
                                    .employee_type == 1
                                ">{{ "Permanent" }}</span>
                                <span v-else-if="
                                  form_data.user_employee_data
                                    .employee_type == 2
                                ">{{ "Probationary" }}</span>
                                <span v-else-if="
                                  form_data.user_employee_data
                                    .employee_type == 3
                                ">{{ "Cotractual" }}</span>
                                <span v-else-if="
                                  form_data.user_employee_data
                                    .employee_type == 6
                                ">{{ "Casual" }}</span>
                                <span v-else-if="
                                  form_data.user_employee_data
                                    .employee_type == 4
                                ">{{ "Temporary" }}</span>
                                <span v-else-if="
                                  form_data.user_employee_data
                                    .employee_type == 5
                                ">{{ "Intern" }}</span>
                              </td>
                            </tr>
                            <tr>
                              <td>Designation</td>
                              <td>:</td>
                              <td>
                                {{
                                    form_data.user_employee_data.designation_name
                                }}
                              </td>
                            </tr>
                            <tr>
                              <td>Department</td>
                              <td>:</td>
                              <td>
                                {{
                                    form_data.user_employee_data.department_name
                                }}
                              </td>
                            </tr>
                            <tr>
                              <td>Company/SBU</td>
                              <td>:</td>
                              <td>
                                {{ form_data.user_employee_data.sbu_name }}
                              </td>
                            </tr>
                          </tbody>
                        </table>

                        <div class="form-group col-md-12">
                          <label class="col-md-12 control-label">
                            Upload Letter
                          </label>
                          <div class="col-md-12 inputGroupContainer float-left">
                            <input type="file" v-on:change="onFileChange" />
                          </div>
                          <div v-if="
                            form_data.resignation_attachment
                              ? form_data.resignation_attachment
                              : ''
                          " class="col-md-6 float-left">
                            <a target="_blank" :href="
                              '/attachments/' +
                              form_data.resignation_attachment
                            ">View Attachment</a>
                          </div>
                          <div v-else-if="form_data.resignation_attachment == ''" class="col-md-6 float-left">
                            <p style="color: orange">No attachment found!</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2 employee-info">
                        <samp v-if="form_data.user_employee_data">
                          <img v-if="
                            form_data.user_employee_data.employee_image != ''
                          " :src="`images/${form_data.user_employee_data.employee_image}`"
                            class="card-img-top border rounded" style="
                              margin-left: -20px;
                              height: 165px;
                              width: 145px;
                            " />
                        </samp>
                        <samp v-else>
                          <img v-eles :src="`images/default.png`" class="card-img-top border rounded" style="
                              margin-left: -20px;
                              height: 165px;
                              width: 145px;
                            " />
                        </samp>
                      </div>
                    </div>
                    <div class="form-actions col-md-12">
                      <input type="submit" tabindex="4" value="Submit"
                        class="btn btn-sm btn-info float-right col-md-2" />
                      <button type="button" @click="hideModal" class="
                          btn btn-sm btn-default
                          float-right
                          col-md-2
                          offset-md-6
                        " style="margin-right: 10px">
                        Close
                      </button>
                    </div>
                  </form>
                </span>
              </div>
            </span>
            <span v-if="requested_data == 7">
              <div class="widget-header modal-header">
                <h4><i class="fa fa-bars"></i> Manual Attendance</h4>
                <button type="button" @click="hideModal" class="close close-modify" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modify-wraper modal-body">
                <span>
                  <div class="">
                    <form @submit.prevent="
                      add({ add: 'add/manualattendance' }, resetModal)
                    " class="well form-horizontal needs-validation" novalidate>
                      <input class="form-control" type="hidden" v-model="form_data.employee_id" />
                      <div class="col-md-12">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="col-md-6 control-label">Employee Name</label>
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon" style="max-width: 100%"><i
                                    class="glyphicon glyphicon-list"></i></span>
                                <vue-select v-model="employee_name_value" :options="option_data.employee_data"
                                  @select="onSelectEmployeeManAttn" placeholder="Select one" label="text"
                                  track-by="text"></vue-select>
                                <!-- <input class="form-control"  type="text" v-model="employee_name"> -->
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-6 control-label">Attendance Issues</label>
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon" style="max-width: 100%"><i
                                    class="glyphicon glyphicon-list"></i></span>
                                <vue-select v-model="attendance_issues_name_value"
                                  :options="option_data.attendance_issues_data" @select="onSelectAttendanceIssue"
                                  placeholder="Select one" label="text" track-by="text"></vue-select>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-6 control-label">Attendance Date</label>
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon" style="max-width: 100%"><i
                                    class="glyphicon glyphicon-list"></i></span>
                                <input class="form-control" v-model="form_data.manual_attendance_date" type="date" />
                                <!-- <datepicker placeholder="Select Date" v-model="form_data.manual_attendance_date" class="form-control" required></datepicker> -->
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-6 control-label">Start Time</label>
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon" style="max-width: 100%"><i
                                    class="glyphicon glyphicon-list"></i></span>
                                <vue-timepicker class="form-control" v-model="form_data.manual_start_time" required>
                                </vue-timepicker>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-6 control-label">End Time</label>
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon" style="max-width: 100%"><i
                                    class="glyphicon glyphicon-list"></i></span>
                                <vue-timepicker class="form-control" v-model="form_data.manual_end_time" required>
                                </vue-timepicker>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-4 control-label">Remarks</label>
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <textarea v-model="form_data.manual_remarks" id="leave_note" name="leave_note"
                                  placeholder="" class="form-control" type="text"></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-actions">
                        <input type="submit" tabindex="4" value="Save"
                          class="btn btn-sm btn-info float-right col-md-2" />
                        <button type="button" @click="hideModal" class="
                            btn btn-sm btn-default
                            float-right
                            col-md-2
                            offset-md-6
                          " style="margin-right: 10px">
                          Close
                        </button>
                      </div>
                    </form>
                  </div>
                </span>
              </div>
            </span>
            <span v-if="requested_data == 8">
              <div class="widget-header modal-header">
                <h4>
                  <i class="fa fa-bars" style="color: black"></i> Employee
                  Transfer
                </h4>
                <button type="button" @click="hideModal" class="close close-modify" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div v-if="form_data.user_employee_data" class="row" style="margin: 0px; padding: 10px 20px">
                <div class="col-md-12 modify-wraper" style="border: 1px solid #ddd; padding: 0px">
                  <div class="col-md-8 float-left" style="padding-left: 0px">
                    <table v-if="
                      form_data.user_employee_data
                        ? form_data.user_employee_data.employee_id_no
                        : ''
                    " class="table table-hover table-responsive" style="margin: 0px">
                      <tbody class="modify-wraper">
                        <tr>
                          <td>Employee ID</td>
                          <td>:</td>
                          <td>
                            {{ form_data.user_employee_data.employee_id_no }}
                          </td>
                        </tr>
                        <tr>
                          <td>Name</td>
                          <td>:</td>
                          <td>
                            {{ form_data.user_employee_data.employee_fullname }}
                          </td>
                        </tr>
                        <tr>
                          <td>Contact No</td>
                          <td>:</td>
                          <td>
                            {{ form_data.user_employee_data.employee_mobile }}
                          </td>
                        </tr>
                        <tr>
                          <td>Joining Date</td>
                          <td>:</td>
                          <td>
                            {{
                                form_data.user_employee_data.employee_joining_date
                            }}
                          </td>
                        </tr>
                        <tr>
                          <td>Employment Type</td>
                          <td>:</td>
                          <td>
                            <span v-if="
                              form_data.user_employee_data.employee_type == 1
                            ">{{ "Permanent" }}</span>
                            <span v-else-if="
                              form_data.user_employee_data.employee_type == 2
                            ">{{ "Probationary" }}</span>
                            <span v-else-if="
                              form_data.user_employee_data.employee_type == 3
                            ">{{ "Cotractual" }}</span>
                            <span v-else-if="
                              form_data.user_employee_data.employee_type == 6
                            ">{{ "Casual" }}</span>
                            <span v-else-if="
                              form_data.user_employee_data.employee_type == 4
                            ">{{ "Temporary" }}</span>
                            <span v-else-if="
                              form_data.user_employee_data.employee_type == 5
                            ">{{ "Intern" }}</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-4 float-left text-right" style="padding-right: 15px">
                    <span v-if="form_data.user_employee_data">
                      <img :src="`images/${form_data.user_employee_data.employee_image}`"
                        class="card-img-top border rounded" style="margin-top: 2px; width: 124px; height: 142px" />
                    </span>
                    <span v-else>
                      <img v-if="
                        url !== '' ||
                        form_data.user_employee_data.employee_image !== ''
                      " :src="`images/default.png`" class="card-img-top border rounded"
                        style="margin-top: 2px; width: 124px; height: 142px" />
                    </span>
                  </div>
                </div>
              </div>
              <div class="row" style="margin: 0px; padding: 0px 20px">
                <div class="col-md-12 float-left" style="border: 1px solid #ddd; padding: 0px">
                  <form @submit.prevent="add({ add: 'transfer/employees' })"
                    class="well form-horizontal needs-validation" enctype="multipart/form-data">
                    <div class="modify-wraper modal-body">
                      <div class="row col-md-12" style="margin: 0px; padding-right: 0px">
                        <div v-if="errors" class="alert alert-danger" style="">
                          <div v-for="(error, index) in errors">
                            <span v-if="isObject(error)" v-for="err in error">{{
                                err
                            }}</span>
                            <span v-if="!isObject(error)">{{ error }}</span>
                          </div>
                        </div>
                        <div class="col-md-6" style="padding: 0px; border-right: 1px solid #ddd">
                          <div class="form-group transfer-text">
                            <h6>Transfer From</h6>
                          </div>
                          <input v-model="form_data.employee_id_no" class="form-control" required="true"
                            placeholder="000000" type="hidden" readonly />
                          <input v-model="form_data.employee_fullname" class="form-control" readonly type="hidden" />
                          <div class="form-group row">
                            <label class="col-md-5 control-label">Company/SBU
                              <sup style="color: red; top: -2px">*</sup></label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <span>:
                                  {{
                                      form_data.user_employee_data.sbu_name ||
                                      "Not Available!"
                                  }}</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-5 control-label">Department</label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <span>:
                                  {{
                                      form_data.user_employee_data
                                        .department_name || "Not Available!"
                                  }}</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-5 control-label">Section</label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <span>:
                                  {{
                                      form_data.user_employee_data.section_name ||
                                      "Not Available!"
                                  }}</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-5 control-label">Sub Section</label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <span>:
                                  {{
                                      form_data.user_employee_data
                                        .sub_section_name || "Not Available!"
                                  }}</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-5 control-label">Sub Unit</label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <span>:
                                  {{
                                      form_data.user_employee_data
                                        .sub_unit_name || "Not Available!"
                                  }}</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-5 control-label">Work Location</label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <span>:
                                  {{
                                      form_data.user_employee_data
                                        .work_location_name || "Not Available!"
                                  }}</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-5 control-label">Designation</label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <span>:
                                  {{
                                      form_data.user_employee_data
                                        .designation_name || "Not Available!"
                                  }}</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-5 control-label">Job Grade</label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <span>:
                                  {{
                                      form_data.user_employee_data
                                        .jobgrade_name || "Not Available!"
                                  }}</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-5 control-label">Reporting to</label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                <span>:
                                  {{
                                      form_data.user_employee_data
                                        .designation_name || "Not Available!"
                                  }}</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-5 control-label">Mobile No. (Official)</label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <span>:
                                  {{
                                      form_data.user_employee_data
                                        .official_mobile_no || "Not Available!"
                                  }}</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-5 control-label">Email ID (Official)</label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <span>:
                                  {{
                                      form_data.user_employee_data
                                        .official_email_id || "Not Available!"
                                  }}</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-5 control-label">PABX Number</label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <span>:
                                  {{
                                      form_data.user_employee_data.desk_phone ||
                                      "Not Available!"
                                  }}</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-5 control-label">Employee Group</label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <span>:
                                  {{
                                      form_data.user_employee_data
                                        .employee_group_name || "Not Available!"
                                  }}</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-5 control-label">Employment Type</label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <span v-if="
                                  form_data.user_employee_data
                                    .employee_type == 1
                                ">: {{ "Permanent" }}</span>
                                <span v-else-if="
                                  form_data.user_employee_data
                                    .employee_type == 2
                                ">: {{ "Probationary" }}</span>
                                <span v-else-if="
                                  form_data.user_employee_data
                                    .employee_type == 3
                                ">: {{ "Cotractual" }}</span>
                                <span v-else-if="
                                  form_data.user_employee_data
                                    .employee_type == 6
                                ">: {{ "Casual" }}</span>
                                <span v-else-if="
                                  form_data.user_employee_data
                                    .employee_type == 4
                                ">: {{ "Temporary" }}</span>
                                <span v-else-if="
                                  form_data.user_employee_data
                                    .employee_type == 5
                                ">: {{ "Intern" }}</span>
                                <span v-else>: {{ "Not Available!" }}</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6" style="padding-left: 8px">
                          <div class="form-group transfer-text">
                            <h6>Transfer To</h6>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-12 control-label">Company/SBU
                              <sup style="color: red; top: -2px">*</sup></label>
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data"
                                  @select="employeesSbuTransfer" placeholder="Select one" label="text" track-by="text">
                                </vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-12 control-label">Department</label>
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="department_name_value" :options="option_data.department_data"
                                  @select="onSelectDepartment1" placeholder="Select one" label="text" track-by="text">
                                </vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-4 control-label">Section</label>
                            <div class="col-md-8 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="section_value" :options="option_data.section_data"
                                  @select="employeesSection1" placeholder="Select one" label="text" track-by="text">
                                </vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-4 control-label">Sub Section</label>
                            <div class="col-md-8 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="sub_section_value" :options="option_data.sub_section_data"
                                  @select="employeesSubSection1" placeholder="Select one" label="text" track-by="text">
                                </vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-12 control-label">Sub Unit</label>
                            <div class="col-md-8 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="sub_unit_value" :options="option_data.sub_unit_data"
                                  @select="employeesSubUnit1" placeholder="Select one" label="text" track-by="text">
                                </vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-12 control-label">Work Location</label>
                            <div class="col-md-8 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <vue-select v-model="work_location_value" :options="option_data.work_location_data"
                                  @select="employeesWorkLocation1" placeholder="Select one" label="text"
                                  track-by="text"></vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-4 control-label">Designation</label>
                            <div class="col-md-8 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="designation_name_value" :options="option_data.designation_data"
                                  @select="onSelectDesignation" placeholder="Select one" label="text" track-by="text">
                                </vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-4 control-label">Job Grade</label>
                            <div class="col-md-8 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="jobgrade_name_value" :options="option_data.jobgrade_data"
                                  @select="onSelectJobGrade" placeholder="Select one" label="text" track-by="text">
                                </vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-4 control-label">Reporting to</label>
                            <div class="col-md-8 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                <vue-select v-model="employee_name_value" :options="option_data.employee_data"
                                  @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text">
                                </vue-select>
                              </div>
                            </div>
                          </div>
                          <!-- <div class="form-group row">
                                       <label class="col-md-12 control-label">Mobile No. (Official)</label>
                                       <div class="col-md-7 inputGroupContainer">
                                         <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="form_data.official_mobile_no" placeholder="" class="form-control"  type="number">
                                         </div>
                                       </div>
                                      </div>
                                      <div class="form-group row">
                                       <label class="col-md-12 control-label">Email ID (Official)</label>
                                       <div class="col-md-7 inputGroupContainer">
                                         <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                           <input v-model="form_data.official_email_id" placeholder="" class="form-control"  type="email">
                                         </div>
                                       </div>
                                      </div> -->
                          <div class="form-group row">
                            <label class="col-md-4 control-label">PABX Number</label>
                            <div class="col-md-8 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <input v-model="form_data.desk_phone_no" placeholder="" class="form-control"
                                  type="number" />
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-4 control-label">Employee Group</label>
                            <div class="col-md-8 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <vue-select v-model="employee_group_value" :options="option_data.employee_group_data"
                                  @select="employeesGroup1" placeholder="Select one" label="text" track-by="text">
                                </vue-select>
                              </div>
                            </div>
                          </div>
                          <!-- <div class="form-group row">
                                        <label class="col-md-4 control-label">Employment Type</label>
                                        <div class="col-md-8 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                            <select v-model="form_data.employee_type" name="employee_type" class="selectpicker form-control">
                                               <option>--Select--</option>
                                               <option value="1">Permanent</option>
                                               <option value="2">Probationary</option>
                                               <option value="3">Cotractual</option>
                                               <option value="6">Casual</option>
                                               <option value="4">Temporary</option>
                                               <option value="5">Intern</option>
                                            </select>
                                          </div>
                                        </div>
                                     </div> -->
                          <div class="form-group row">
                            <label class="col-md-4 control-label">Effective Date</label>
                            <div class="col-md-8 inputGroupContainer">
                              <div class="input-group">
                                <input class="form-control" v-model="form_data.transfer_date" type="date" ref="input"
                                  style="
                                    border: none;
                                    border-bottom: 1px solid #aaa;
                                    padding-left: 0px;
                                  " />
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-4 control-label">Remarks</label>
                            <div class="col-md-8 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <textarea v-model="form_data.remarks" placeholder="" class="form-control" type="number">
                                </textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-actions" style="margin-top: 5px;">
                      <input type="submit" tabindex="4" value="Transfer" class="btn btn-md btn-info float-right" />
                      <button type="button" @click="hideModal" class="btn btn-md btn-default float-right"
                        style="margin-right: 10px">
                        Close
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </span>
            <span v-if="requested_data == 9">
              <div class="widget-header modal-header">
                <h4>
                  <i class="fa fa-bars" style="color: black"></i> Promotion & Increment
                </h4>
                <button type="button" @click="hideModal" class="close close-modify" aria-label="Close" style="right:10px; top:4% !important;">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div v-if="form_data.user_employee_data" class="row" style="margin: 0px; padding: 10px 20px">
                <div class="col-md-12 modify-wraper" style="border: 1px solid #ddd; padding: 0px">
                  <div class="col-md-8 float-left" style="padding-left: 0px">
                    <table v-if="
                      form_data.user_employee_data
                        ? form_data.user_employee_data.employee_id_no
                        : ''
                    " class="table table-hover table-responsive" style="margin: 0px">
                      <tbody class="modify-wraper">
                        <tr>
                          <td>Employee ID</td>
                          <td>:</td>
                          <td>
                            {{ form_data.user_employee_data.employee_id_no }}
                          </td>
                        </tr>
                        <tr>
                          <td>Name</td>
                          <td>:</td>
                          <td>
                            {{ form_data.user_employee_data.employee_fullname }}
                          </td>
                        </tr>
                        <tr>
                          <td>Contact No</td>
                          <td>:</td>
                          <td>
                            {{ form_data.user_employee_data.employee_mobile }}
                          </td>
                        </tr>
                        <tr>
                          <td>Joining Date</td>
                          <td>:</td>
                          <td>
                            {{
                                form_data.user_employee_data.employee_joining_date
                            }}
                          </td>
                        </tr>
                        <tr>
                          <td>Employment Type</td>
                          <td>:</td>
                          <td>
                            <span v-if="
                              form_data.user_employee_data.employee_type == 1
                            ">{{ "Permanent" }}</span>
                            <span v-else-if="
                              form_data.user_employee_data.employee_type == 2
                            ">{{ "Probationary" }}</span>
                            <span v-else-if="
                              form_data.user_employee_data.employee_type == 3
                            ">{{ "Cotractual" }}</span>
                            <span v-else-if="
                              form_data.user_employee_data.employee_type == 6
                            ">{{ "Casual" }}</span>
                            <span v-else-if="
                              form_data.user_employee_data.employee_type == 4
                            ">{{ "Temporary" }}</span>
                            <span v-else-if="
                              form_data.user_employee_data.employee_type == 5
                            ">{{ "Intern" }}</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-4 float-left text-right" style="padding-right: 15px">
                    <span v-if="form_data.user_employee_data">
                      <img :src="`images/${form_data.user_employee_data.employee_image}`"
                        class="card-img-top border rounded" style="margin-top: 2px; width: 124px; height: 142px" />
                    </span>
                    <span v-else>
                      <img v-if="
                        url !== '' ||
                        form_data.user_employee_data.employee_image !== ''
                      " :src="`images/default.png`" class="card-img-top border rounded"
                        style="margin-top: 2px; width: 124px; height: 142px" />
                    </span>
                  </div>
                </div>
              </div>
              <div class="row" style="margin: 0px; padding: 0px 20px">
                <div class="col-md-12 float-left" style="border: 1px solid #ddd; padding: 0px">
                  <form @submit.prevent="add({ add: 'promotion/employees' })"
                    class="well form-horizontal needs-validation" enctype="multipart/form-data">
                    <div class="modify-wraper modal-body">
                      <div class="row col-md-12" style="margin: 0px; padding-right: 0px">
                        <div v-if="errors" class="alert alert-danger" style="">
                          <div v-for="(error, index) in errors">
                            <span v-if="isObject(error)" v-for="err in error">{{
                                err
                            }}</span>
                            <span v-if="!isObject(error)">{{ error }}</span>
                          </div>
                        </div>
                        <div class="col-md-12" style="padding: 0px; border-right: 1px solid #ddd">
                          <input v-model="form_data.employee_id_no" class="form-control" required="true"
                            placeholder="000000" type="hidden" readonly />
                          <input v-model="form_data.employee_fullname" class="form-control" readonly type="hidden" />
                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                              <div class="row col-md-6">
                                <div class="form-group transfer-text col-md-12">
                                  <h6>
                                    <span style="border-bottom: 1px solid #ddd; font-weight: bold;">
                                      <u>Existing Info :</u>
                                    </span>
                                  </h6>
                                </div>
                                <label class="col-md-4 control-label">Company/SBU
                                <sup style="color: red; top: -2px">*</sup></label>
                                <div class="col-md-8 inputGroupContainer">
                                  <div class="input-group" style="border-right:1px solid #ddd;">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <span>:
                                      {{
                                          form_data.user_employee_data.sbu_name ||
                                          "Not Available!"
                                      }}</span>
                                  </div>
                                </div>
                              </div>
                              <div class="row col-md-6">
                                <div class="form-group transfer-text col-md-12">
                                  <h6>
                                    <span style="border-bottom: 1px solid #ddd; font-weight: bold;">
                                      <u>New Info :</u>
                                    </span>
                                  </h6>
                                </div>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data"
                                    @select="employeesSbuTransfer" placeholder="Select one" label="text" track-by="text">
                                  </vue-select>
                                  </div>
                                </div>
                              </div>
                          </div>
                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">Department</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <span>:
                                    {{
                                        form_data.user_employee_data
                                          .department_name || "Not Available!"
                                    }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="row col-md-6">
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="department_name_value" :options="option_data.department_data"
                                    @select="onSelectDepartment1" placeholder="Select one" label="text" track-by="text">
                                  </vue-select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">Section</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <span>:
                                    {{
                                        form_data.user_employee_data.section_name ||
                                        "Not Available!"
                                    }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="row col-md-6">
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="section_value" :options="option_data.section_data"
                                    @select="employeesSection1" placeholder="Select one" label="text" track-by="text">
                                  </vue-select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">Sub Section</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <span>:
                                    {{
                                        form_data.user_employee_data
                                          .sub_section_name || "Not Available!"
                                    }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="row col-md-6">
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="sub_section_value" :options="option_data.sub_section_data"
                                    @select="employeesSubSection1" placeholder="Select one" label="text" track-by="text">
                                  </vue-select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">Sub Unit</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <span>:
                                    {{
                                        form_data.user_employee_data
                                          .sub_unit_name || "Not Available!"
                                    }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="row col-md-6">
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="sub_unit_value" :options="option_data.sub_unit_data"
                                    @select="employeesSubUnit1" placeholder="Select one" label="text" track-by="text">
                                  </vue-select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">Work Location</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                  <span>:
                                    {{
                                        form_data.user_employee_data
                                          .work_location_name || "Not Available!"
                                    }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="row col-md-6">
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="work_location_value" :options="option_data.work_location_data"
                                    @select="employeesWorkLocation1" placeholder="Select one" label="text"
                                    track-by="text"></vue-select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">Designation</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <span>:
                                    {{
                                        form_data.user_employee_data
                                          .designation_name || "Not Available!"
                                    }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="row col-md-6">
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="designation_name_value" :options="option_data.designation_data"
                                    @select="onSelectDesignation" placeholder="Select one" label="text" track-by="text">
                                  </vue-select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row" style="border-bottom:  1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">Job Grade</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <span>:
                                    {{
                                        form_data.user_employee_data
                                          .jobgrade_name || "Not Available!"
                                    }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="row col-md-6">
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="jobgrade_name_value" :options="option_data.jobgrade_data"
                                    @select="onSelectJobGrade" placeholder="Select one" label="text" track-by="text">
                                  </vue-select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">Employee Group</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                  <span>:
                                    {{
                                        form_data.user_employee_data
                                          .employee_group_name || "Not Available!"
                                    }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="row col-md-6">
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="employee_group_value" :options="option_data.employee_group_data"
                                    @select="employeesGroup1" placeholder="Select one" label="text" track-by="text">
                                  </vue-select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">Employment Type</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                  <span v-if="
                                    form_data.user_employee_data
                                      .employee_type == 1
                                  ">: {{ "Permanent" }}</span>
                                  <span v-else-if="
                                    form_data.user_employee_data
                                      .employee_type == 2
                                  ">: {{ "Probationary" }}</span>
                                  <span v-else-if="
                                    form_data.user_employee_data
                                      .employee_type == 3
                                  ">: {{ "Cotractual" }}</span>
                                  <span v-else-if="
                                    form_data.user_employee_data
                                      .employee_type == 6
                                  ">: {{ "Casual" }}</span>
                                  <span v-else-if="
                                    form_data.user_employee_data
                                      .employee_type == 4
                                  ">: {{ "Temporary" }}</span>
                                  <span v-else-if="
                                    form_data.user_employee_data
                                      .employee_type == 5
                                  ">: {{ "Intern" }}</span>
                                  <span v-else>: {{ "Not Available!" }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="row col-md-6">
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <select v-model="form_data.employee_type" name="employee_type" class="selectpicker form-control">
                                      <option>--Select--</option>
                                      <option value="1">Permanent</option>
                                      <option value="2">Probationary</option>
                                      <option value="3">Cotractual</option>
                                      <option value="6">Casual</option>
                                      <option value="4">Temporary</option>
                                      <option value="5">Intern</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">Salary Amount</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                  <span>:
                                    {{
                                        form_data.totalSalary || 0
                                    }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="row col-md-6" style="padding-right: 0px;">
                              <div class="col-md-6 inputGroupContainer">
                                <div class="input-group" style="width: 98%;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <input @input="InputNewSalary" v-model="form_data.new_salary" placeholder="New Salary" class="form-control"
                                  type="number"/>
                                </div>
                              </div>
                              <div class="col-md-6 inputGroupContainer">
                                <div class="input-group" style=" margin-left: -5px; width: 98%;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <input readonly v-model="form_data.total_increment" placeholder="Increment Amount" class="form-control"
                                  type="number"/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">One off Bonus</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                  <span>:
                                    {{
                                        form_data.one_off_bonus1
                                         ||
                                          "0.00"
                                    }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6" style="padding-right: 0px;">
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group" style=" margin-left: -5px; width: 98%;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <input v-model="form_data.one_off_bonus" placeholder="One Off Bonus" class="form-control"
                                  type="number"/>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">Increment Goes To</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                  <span>:
                                    {{
                                      form_data.salary_goes_to1
                                    }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6" style="padding-left: 0px;">
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group" style="width:99%;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <select v-model="form_data.salary_goes_to" required="required" class="form-control">
                                    <option disabled="disabled">--Select--</option>
                                    <option value="1">Cash</option>
                                    <option value="2">Bank</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">Car Allowance</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                  <span>:
                                    {{
                                        form_data.user_employee_data
                                          .car_allowance_status1 || "0.00"
                                    }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6" style="padding: 0px;">
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group col-md-6 float-left" style='padding: 0px;'>
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <select @change="onEnableDisbaled($event)"  v-model="form_data.car_allowance_status" required="required" class="form-control">
                                    <option disabled="disabled">--Select--</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                  </select>
                                </div>
                                <div class="input-group col-md-6 float-left">
                                  <input :disabled="disabled_value == 1" placeholder="Allowance Amount" class="" v-model="form_data.car_allowance_amount" type="number" ref="input"
                                  style="
                                    border: none;
                                    border-bottom: 1px solid #aaa;
                                    padding: 2px;
                                    width: 97%;
                                  " />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">Reporting to</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                  <span>:
                                    {{
                                        form_data.user_employee_data
                                          .repotingTonname || "Not Available!"
                                    }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6" style="padding-left: 0px;">
                              <!-- <label class="col-md-12 control-label">Reporting To</label> -->
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="employee_name_value" :options="option_data.employee_data"
                                      @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text">
                                  </vue-select>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group row" style="border-bottom: 1px solid #ddd;">
                            <div class="row col-md-6">
                              <label class="col-md-4 control-label">Effective Date</label>
                              <div class="col-md-8 inputGroupContainer">
                                <div class="input-group" style="border-right:1px solid #ddd;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                  <span>:
                                    {{
                                      form_data.effective_date1
                                    }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6" style="padding: 0px;">
                              <!-- <label class="col-md-12 control-label">Effective Date</label> -->
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group" style="padding: 0px;
                                    padding-right: 8px;">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <input class="form-control" v-model="form_data.effective_date" type="date" ref="input"
                                  style="
                                    border: none;
                                    border-bottom: 1px solid #aaa;
                                  " />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group row" style='padding-top:5px;'>
                            <label class="col-md-2 control-label">Remarks</label>
                            <div class="col-md-10 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <span style="margin-left: -4px;">:</span>
                                <textarea style="margin-left: 5px;" v-model="form_data.remarks" placeholder="Remarks" class="form-control" type="number">
                                </textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-actions" style="margin-top: 5px;">
                      <input type="submit" tabindex="4" value="Promote" class="btn btn-md btn-info float-right" />
                      <button type="button" @click="hideModal" class="btn btn-md btn-default float-right"
                        style="margin-right: 10px">
                        Close
                      </button>
                    </div>
                  </form>
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
import Loading from "../Loading.vue";
import Datepicker from "vuejs-datepicker";
import VueTimepicker from "vue2-timepicker";
import "vue2-timepicker/dist/VueTimepicker.css";
import moment from "moment";
export default {
  data() {
    return {
      separation_status: 0,
      attendance_machine_value: "",
      office_time_value: "",
      attendance_issues_name_value: "",
      employee_form_submit: 1,
      effective_date: "",
      leave_type_value: "",
      employee_name_search: "",
      employee_name_value: "",
      form_data:{
        add_new_type:1,
      },
      // leave_type_value:'',
      add_new_type: "",
      totalDays: 0,
      totalDayss: 0,
      remaining_days: 0,
      employee_image: "",
      requested_data: "",
      sbu_name_value: "",
      section_value: "",
      sub_section_value: "",
      employee_group_value: "",
      unit_value: "",
      make_user: 0,
      employeesName: "",
      employees_ids: "",
      url: null,
      sub_unit_value: "",
      work_location_value: "",
      department_name_value: "",
      designation_name_value: "",

      sbu_name_value_per: "",
      department_name_value_per: "",
      unit_value_per: "",
      sub_unit_value_per: "",
      section_value_per: "",
      work_area_value: "",
      sub_section_value_per: "",
      employee_name_value_per: "",

      jobgrade_name_value: "",
      employee_name_value: "",
      approvalnamevalue: "",
      approvalnamevalue1: "",
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
      date1: moment(new Date()).format("MM/DD/YYYY hh:mm"),
      sub_unit_value: "",
      work_location_value: "",
      personal_email_id: "",
      userType: 0,
      shift_time: "",
      userTypeName: "",
      permission_id: "",
      permission_id_name: "",
      employee_primary_id: "",
      disabled_value: 1,
      uri: "data:application/vnd.ms-excel;base64,",
      template:
        '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
      base64: function (s) {
        return window.btoa(unescape(encodeURIComponent(s)));
      },
      format: function (s, c) {
        return s.replace(/{(\w+)}/g, function (m, p) {
          return c[p];
        });
      },
    };
  },
  created() {
    this.getResults(1);
  },
  components: {
    pageLoading: Loading,
    VueTimepicker,
  },
  // props: {
  //   value: {
  //     type: Date,
  //     default: new Date()
  //   }
  // },
  methods: {
    onSelectSeparationType(option) {
      // console.log(event.target.value);
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
      console.log(event.target.name);
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
      console.log(approval_infosss);
      var aaa = this.form_data.approval_infosss.length;
      this.form_data.approval_infosss.push({
        permission_id: this.permission_id,
        permission_id_name: this.permission_id_name,
        permission_type: this.userType,
        permission_type_name: this.userTypeName,
      });
      console.log(this.form_data.approval_infosss);
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
    employeesArea(option) {
      // console.log(option);
      this.form_data.work_area = option.id;
      // console.log(this.form_data.work_area);
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
      console.log(this.form_data.employee_joining_date);
      const str = this.form_data.employee_joining_date;
      this.form_data.employee_joining_dates =
        str.getFullYear() + "-" + str.getMonth() + "-" + str.getDate();
      this.employeeType();
    },
    employeeType() {
      let joingDate = this.form_data.employee_joining_dates;
      const str = this.form_data.employee_joining_dates;
      // console.log(this.form_data.employee_joining_date);
      const datetext = str.split("-");
      let joingDates = new Date(datetext["0"], datetext["1"], datetext["2"]);
      console.log(joingDates);
      var dt = joingDates;
      var addDate = dt.setMonth(
        dt.getMonth() + parseInt(this.form_data.employee_due_month)
      );
      let getmonths = new Date(addDate).getMonth();
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
      console.log(option);
      this.form_data.attendance_office_time = option.id;
      console.log(this.form_data.attendance_office_time);
    },
    tableToExcel(table, name) {
      if (!table.nodeType) table = this.$refs.table;
      var ctx = { worksheet: name || "Worksheet", table: table.innerHTML };
      window.location.href =
        this.uri + this.base64(this.format(this.template, ctx));
    },

    employeesSbuTransfer(option) {
      console.log(option);
      this.form_data.employee_sbu = option.id;
      this.form_data.employee_number = option.id;

      // console.log(this.form_data.employee_sbu);
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
      console.log(uri1);
      axios
        .get(uri1)
        .then((res) => {
          // console.log(res.data);
          // console.log('aaaaaa');
          this.form_data.employee_id_no = res.data.employee_id_no;
          this.form_data.employee_number = res.data.employee_id_no;
          // console.log(this.form_data.employee_id_no);
          // console.log(this.form_data.employee_number);
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
    getDataActiveIctive(v){
      this.search_input.search_inpu_all=v;
      this.getResults();
    },

    employeesSection1(option) {
      console.log(option);
      this.form_data.employee_section = option.id;
      console.log(this.form_data.employee_section);
    },
    employeesSubSection1(option) {
      console.log(option);
      this.form_data.employee_sub_section = option.id;
      console.log(this.form_data.employee_sub_section);
    },
    employeesGroup1(option) {
      console.log(option);
      this.form_data.employee_group = option.id;
      console.log(this.form_data.employee_group);
    },
    employeesSubUnit1(option) {
      console.log(option);
      this.form_data.employee_sub_unit = option.id;
      console.log(this.form_data.employee_sub_unit);
    },
    employeesUnit1(option) {
      console.log(option);
      this.form_data.employee_unit = option.id;
      console.log(this.form_data.employee_unit);
    },
    employeesWorkLocation1(option) {
      console.log(option);
      this.form_data.employee_work_location = option.id;
      console.log(this.form_data.employee_work_location);
    },
    onSelectDepartment1(option) {
      console.log(option);
      this.form_data.employee_department = option.id;
      // console.log(this.form_data.employee_department);
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
    onSelectEmployeeManAttn(option) {
      console.log(option);
      this.form_data.employee_id = option.id;
      this.form_data.employee_id_no = option.employee_id_no;
      console.log(this.form_data.employee_id_no);
    },
    onSelectEmployee1(option) {
      console.log(option);
      this.form_data.employee_reporting_to = option.id;
      let employeeinfo = this.option_data.allEmployees[option.id];
      console.log(employeeinfo);
      this.form_data.approval_infos.push({
        approvalnamevalue1: "",
        ea_approve_by: employeeinfo["id"],
        employees_ids: employeeinfo["employee_id_no"],
        ea_approve_by_name: employeeinfo["employee_fullname"],
      });
      let datall = this.form_data.approval_infos;
      this.form_data.approval_infos = [];
      let approvalInfos = [];
      datall.forEach(function (value, i) {
        console.log("%d: %s", i, value);
        if (value.employees_ids == "") {
          console.log("sss");
        } else {
          console.log(approvalInfos);
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
      console.log(this.form_data.approval_infos);
    },
    onSelectEmployeeLeave(option) {
      this.form_data.leave_reliever = option.id;
      let allData = this.form_data.user_employee_data_all[option.id];
      // console.log(allData);
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
      console.log(option);
      this.form_data.approve_by = option.id;
      this.employeesName = option.employee_name;
      this.employees_ids = option.employee_ids;
      this.form_data.approve_by_name = option.text;
      console.log(this.form_data.approve_by);
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
        // console.log(this.form_data.approve_by);
      };
      reader.readAsDataURL(file);
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
      this.employee_name_search = this.form_data.employee_name_search;
      this.leave_type_value = this.form_data.leave_type_value;
      this.form_data.employee_form_submit = this.employee_form_submit;
      // this.form_data.employee_id=this.form_data.employee_primary_id;
    },
    setModalDataOthers() {
      this.form_data.employee_id = this.form_data.employee_name_value.id;
      // this.form_data.employee_id=this.form_data.employee_primary_id;
    },
    setModalDataOthers1() {
      // alert();
      this.form_data.employee_form_submit = 1;
      // this.form_data.employee_id=this.form_data.employee_primary_id;
    },
    resetModal() {
      this.sbu_name_value = "";
      this.section_value = "";
      this.sub_section_value = "";
      this.employee_group_value = "";
      this.department_name_value = "";
      this.designation_name_value = "";
      this.jobgrade_name_value = "";
      this.unit_value = "";
      this.sub_unit_value = "";
      this.employee_name_value = "";
      this.work_location_value = "";
      this.form_data.employee_status = "0";
      this.form_data.emplyee_category_mgt_non_mgt = "2";
      this.form_data.employee_leave_group = "1";
      this.form_data.employee_type = "2";
      this.form_data.make_user = "";
      this.form_data.user_type = "0";
      this.form_data.ea_approve_by_name = "";
      this.form_data.employee_mobile = "";
      this.form_data.employee_id_no = "";
      this.form_data.employee_number = "";
      this.form_data.employee_fullname = "";
      // this.form_data.employee_joining_date='';
      this.form_data.employee_image = "";
      this.form_data.make_user = "";
      this.approvalnamevalue1 = "";
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
      console.log(this.form_data.approval_infos);
    },
    deleteRow(index) {
      this.form_data.approval_infos.splice(index, 1);
    },

    requestAccept(sl, id, requestInfo) {
      // alert(id);
      // if(!window.confirm('Are you sure?')){
      //   return;
      // }
      let uri = URL.baseUrl(
        "update_requested_data/employees/" + sl + "/" + id + "/" + requestInfo
      );
      console.log(uri);
      axios
        .get(uri)
        .then((res) => {
          console.log(res.data.status);
          // this.form_data =res.data;
          this.getResults(1);
        })
        .catch((error) => {
          this.showToster({ status: 0, message: "opps! something went wrong" });
        });
    },
    addEvent({ type, target }) {
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
    leaveTypeList(option) {
      console.log(option);
      this.form_data.leave_type = option.id;
      this.form_data.leave_from_date = "";
      this.form_data.leave_to_date = "";
      this.remaining_days = "";
      this.totalDays = "";
      // this.form_data.add_new_type=1;
      console.log(this.form_data.leave_type);
    },
    onSelectEmployeeSearch(option) {
      this.getModalDataOther_id(option.id);
      this.form_data.leave_reliever = option.id;
      this.form_data.employee_id = this.form_data.leave_reliever;
      console.log(this.form_data.employee_id);
      console.log(option);
      let allData = this.form_data.user_employee_data_all[option.id];
      this.form_data.employee_id = allData["id"];
    },
    getModalDataOther_id(id) {
      console.log("aaaaaa");
      let uri = URL.baseUrl("edit/otherCreate/" + id);
      console.log(uri);
      axios
        .get(uri)
        .then((res) => {
          console.log(res.data);
          // console.log('aaaaaa');
          this.form_data = res.data;
          this.form_data.employee_id = id;
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

    leaveTypeList(option) {
      console.log(option);
      this.form_data.leave_type = option.id;
      this.form_data.leave_from_date = "";
      this.form_data.leave_to_date = "";
      this.remaining_days = "";
      this.totalDays = "";
      this.form_data.add_new_type = this.add_new_type;
      console.log(this.form_data.leave_type);
    },
    printLeave() {
      const modal = document.getElementById("modalInvoice");
      const cloned = modal.cloneNode(true);
      let section = document.getElementById("print");

      if (!section) {
        section = document.createElement("div");
        section.id = "print";
        document.body.appendChild(section);
      }

      section.innerHTML = "";
      section.appendChild(cloned);
      window.print();
    },

    dateToYYYYMMDD(d) {
      return (
        d &&
        new Date(d.getTime() - d.getTimezoneOffset() * 60 * 1000)
          .toISOString()
          .split("T")[0]
      );
    },
    // updateValue: function (target) {
    //   // alert(target)
    //   const date1 = new Date(this.form_data.leave_from_date);
    //   const date2 = new Date(this.form_data.leave_to_date);
    //   const diffTime = Math.abs(date2 - date1);
    //   const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    //   this.totalDays = +diffDays + +1 + " d";
    //   this.totalDayss = +diffDays + +1;
    //   this.$emit("input", target.valueAsDate);
    //   let leave_info = this.form_data.leaveInfo;
    //   let obj = leave_info.find((data) => data.id == this.form_data.leave_type);
    //   this.remaining_days = obj.balance - this.totalDayss;
    // },

    updateValue: function (target) {
      // console.log('fff');
      const date1 = new Date(this.form_data.leave_from_date);
      const date2 = new Date(this.form_data.leave_to_date);
      const diffTime = Math.abs(date2 - date1);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      this.totalDays=(+ diffDays)+(+1) + " d";
      this.totalDayss=(+ diffDays)+(+1);
      let leave_info = this.form_data.leaveInfo;
      let obj =leave_info.find(data => data.id == this.form_data.leave_type);
      console.log([this.form_data.employee_id, this.form_data.employee_sbu, this.totalDayss]);
      console.log('fff');
      if((date1 !='Invalid Date') && (date2 !='Invalid Date')){
          if(this.form_data.leave_type == 1 && date1 && date2){ // leave_type = 1 (Annual leave)
              let uri = URL.baseUrl('findActualAnnualLeaveDays');
              axios.post(
                uri,
                {
                  employee_id: this.form_data.employee_id,
                  employee_sbu: this.form_data.employee_sbu,
                  leave_form_date: date1,
                  leave_to_date: date2,
                  totalDayss: this.totalDayss,
                  url_type: 2
                }
              )
              .then(res => {
                this.totalDayss = res.data.rest_day_except_hw;
                this.totalDays= this.totalDayss + " d";
                this.remaining_days = obj.balance - this.totalDayss;
                this.form_data.leave_total_day = this.totalDayss;
                if(obj.balance < this.totalDayss){
                  this.showToster({status:0,message:'Opps! Annual leave not available ' + this.totalDayss + ' Days'});
                  this.totalDayss=0;
                  this.form_data.leave_from_date='';
                  this.form_data.leave_to_date='';
                  this.totalDays = 0;
                  this.remaining_days = 0;
                }
              })
              .catch(error => {
                console.log('Data not found!');
              })
          }else if((this.form_data.leave_type == 2)){
            if(this.totalDayss > 3){
                this.showToster({status:0,message:'opps! Casual leave not allowed more than 3 days !  '});
                this.totalDayss=0;
                this.form_data.leave_from_date='';
                this.form_data.leave_to_date='';
                this.totalDays=0;
                this.remaining_days =0;
            }
            if(obj.balance < this.totalDayss){
              this.showToster({status:0,message:'Opps! this leave not available ' + this.totalDayss + ' Days'});
              this.totalDayss=0;
              this.form_data.leave_from_date='';
              this.form_data.leave_to_date='';
              this.totalDays=0;
              this.remaining_days =0;
            }
            this.remaining_days = obj.balance - this.totalDayss;
            this.form_data.leave_total_day = this.totalDayss;
          }else if(this.form_data.leave_type == 3 || this.form_data.leave_type == 5){
            if(obj.balance < this.totalDayss){
              this.showToster({status:0,message:'Opps! this leave not available ' + this.totalDayss + ' Days'});
              this.totalDayss=0;
              this.form_data.leave_from_date='';
              this.form_data.leave_to_date='';
              this.totalDays=0;
              this.remaining_days =0;
            }
            this.remaining_days = obj.balance - this.totalDayss;
            this.form_data.leave_total_day = this.totalDayss;
          }else if(this.form_data.leave_type == 6){
              this.remaining_days = this.totalDayss;
              this.form_data.leave_total_day = this.totalDayss;
          }else{
            this.showToster({status:0,message:'Opps! Somthing went wrong'});
            this.totalDayss=0;
            this.form_data.leave_from_date='';
            this.form_data.leave_to_date='';
            this.totalDays=0;
            this.remaining_days =0;
          }
      }
    },



    updateValue1: function (target) {
      // alert(target);
      const date1 = new Date(this.form_data.last_working_date);
      const tomorrow = new Date(date1);
      this.effective_date = tomorrow.setDate(tomorrow.getDate() + 1);
      this.form_data.effective_date = new Date(this.effective_date);
      this.effective_date = new Date(this.effective_date);
      console.log(this.form_data.effective_date);
    },
    selectAll: function (event) {
      setTimeout(function () {
        event.target.select();
      }, 0);
    },
    dateSelectedTotal(event) {
      console.log(this.form_data.leave_from_date);
      console.log(this.form_data.leave_to_date);
    },
    onSelectAttendanceIssue(option) {
      console.log(option);
      this.form_data.manual_attendance_issues = option.id;
      console.log(this.form_data.manual_attendance_issues);
    },
    onEnableDisbaled(option){
      console.log(event.target.value);
      if(event.target.value == 1){
        this.disabled_value = 1;
        this.form_data.car_allowance_status = 1;
        this.form_data.car_allowance_amount = this.form_data.car_allowance_amount;
        this.disabled_value = (this.disabled_value + 1) % 2;
      }
      if(event.target.value == 2){
        this.disabled_value = 0;
        this.form_data.car_allowance_status = 2;
        this.form_data.car_allowance_amount = 0;
        this.disabled_value = (this.disabled_value + 1) % 2;
      }
      console.log(this.disabled_value);
    },
    InputNewSalary(){
      console.log(this.form_data.totalSalary);
      console.log(this.form_data.new_salary);
      this.increment_amount = parseInt(this.form_data.new_salary) - parseInt(this.form_data.totalSalary_int);
      console.log(this.increment_amount);
      this.form_data.total_increment = this.increment_amount;
      // if(this.increment_amount > 0){
      //   this.form_data.new_salary = this.form_data.new_salary;
      // }else{
      //   this.form_data.new_salary = this.form_data.totalSalary_int;
      // }

    },
  },
};
</script>
<style type="text/css">
.employeeTable.table th {
  padding: 6px 5px;
}

.employeeTable.table td {
  padding: 4px 5px;
}

.employeeTable .btn {
  margin-right: 5px;
}

.box-info a div:hover {
  background: #f2f4f6;
  font-weight: bold;
  transition: 0.9s;
}

.vdp-datepicker__calendar {
  right: 0px;
}
span {
  font-family: sans-serif !important;
}
.multiselect__single {
  font-size: .8rem;
}
</style>
