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
                          Note Request
                        </h3>
                        <span class="float-sm-right" style="float: right">
                          <!-- <div
                            v-if="lists.add == 'add'"
                            @click="
                              getModalData(
                                $event,
                                { dataUrl: 'create/note_request' },
                                resetModal,
                                (add_new_type = 2)
                              )
                            "
                            class="btn-group"
                          >
                            <span class="btn btn-sm btn-info"
                              ><i class="icon-plus"></i>Add New</span
                            >
                          </div> -->
                          <a class="btn btn-default" href="#"
                            ><i class="fa fa-arrow-left"></i> Back</a
                          >
                        </span>
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-12 col-sm-12 col-md-3" style="max-width: 20%;">
                       <a @click="getDataActiveIctive('team')"  style="color: #000">
                          <div class="info-box mb-3">
                            <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                              <span class="info-box-text">My Team</span>
                              <span class="info-box-number">{{lists.my_team_employees}}</span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                        </a>
                        <!-- /.info-box -->
                      </div>
                      <div class="col-12 col-sm-12 col-md-3" style="max-width: 20%;">
                      <a @click="getDataActiveIctive('Requested')"  style="color: #000">
                        <div class="info-box">
                          <span class="info-box-icon bg-info elevation-1"
                            ><i class="fa fa-paper-plane"></i
                          ></span>

                          <div class="info-box-content">
                            <span class="info-box-text">Requests</span>
                            <span class="info-box-number">
                              {{ lists.requestApplications }}
                              <!-- <small>%</small> -->
                            </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        </a>
                        <!-- /.info-box -->
                      </div>
                      <div class="col-12 col-sm-12 col-md-3" style="max-width: 20%;">
                      <a @click="getDataActiveIctive('Pending')"  style="color: #000">
                        <div class="info-box">
                          <span class="info-box-icon bg-warning elevation-1"
                            ><i class="fas fa-clock"></i
                          ></span>

                          <div class="info-box-content">
                            <span class="info-box-text">Pending</span>
                            <span class="info-box-number">
                              {{ lists.pendingApplications }}
                              <!-- <small>%</small> -->
                            </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        </a>
                        <!-- /.info-box -->
                      </div>
                      <!-- /.col -->
                      <div class="col-12 col-sm-12 col-md-3" style="max-width: 20%;">
                       <a @click="getDataActiveIctive('Accepted')"  style="color: #000">
                        <div class="info-box mb-3">
                          <span class="info-box-icon bg-success elevation-1"
                            ><i class="fa fa-check-circle"></i
                          ></span>

                          <div class="info-box-content">
                            <span class="info-box-text">Approved</span>
                            <span class="info-box-number">{{
                              lists.acceptedApplications
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

                      <div class="col-12 col-sm-12 col-md-3" style="max-width: 20%;">
                      <a @click="getDataActiveIctive('Rejected')"  style="color: #000">
                        <div class="info-box mb-3">
                          <span class="info-box-icon bg-danger elevation-1"
                            ><i class="fa fa-ban"></i
                          ></span>

                          <div class="info-box-content">
                            <span class="info-box-text">Rejected</span>
                            <span class="info-box-number">{{
                              lists.rejectedApplications
                            }}</span>
                          </div>

                          <!-- /.info-box-content -->
                        </div>
                        </a>
                        <!-- /.info-box -->
                      </div>
                      <!-- /.row -->
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body col-md-12">
                    <div
                      class="col-md-6 col-sm-6 col-6 float-left"
                      style="padding: 0px"
                    >
                      <div id="DataTables_Table_0_length" class="">
                        Show
                        <label>
                          <select
                            class="form-control pagination-number"
                            @change="onChange($event)"
                            v-model="paginate_num"
                            name="pageSize"
                          >
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
                    <div
                      class="col-md-6 col-sm-6 col-6 float-left"
                      style="padding: 0px"
                    >
                      <div
                        class="dataTables_filter"
                        id="DataTables_Table_0_filter"
                      >
                        <label class="float-right">
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="icon-search"></i
                            ></span>
                            <input
                              v-on:keyup="getResults"
                              v-model="search_input.search_key"
                              type="text"
                              aria-controls="DataTables_Table_0"
                              class="form-control search-keyword"
                              id="search"
                              placeholder="Search..."
                            />
                          </div>
                        </label>
                      </div>
                    </div>
                    <table
                      id="employeeTable"
                      class="table table-bordered table-striped employeeTable"
                    >
                      <thead>
                        <tr>
                          <th class="text-center">SL</th>
                          <th
                            class="text-center"
                            v-bind:class="
                              getSortingClass('add_note_date')
                            "
                            @click="sortingChanged('add_note_date')"
                          >
                            Date <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('employee_id_no')"
                            @click="sortingChanged('employee_id_no')"
                          >
                            Employee ID <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-left"
                            v-bind:class="getSortingClass('employee_fullname')"
                            @click="sortingChanged('employee_fullname')"
                          >
                            Employee Name <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('designation_name')"
                            @click="sortingChanged('designation_name')"
                          >
                            Designation <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('sbu_name')"
                            @click="sortingChanged('sbu_name')"
                          >
                            Company <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="
                              getSortingClass('note_issues')
                            "
                            @click="sortingChanged('note_issues')"
                          >
                            Note Issue <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('out_time')"
                            @click="sortingChanged('out_time')"
                          >
                             Time <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="
                              getSortingClass('note_type')
                            "
                            @click="sortingChanged('note_type')"
                          >
                            Note type <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="
                              getSortingClass('note_approve_status')
                            "
                            @click="sortingChanged('note_approve_status')"
                          >
                            Status <i class="fas fa-sort"></i>
                          </th>
                          <th class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody v-if="Object.keys(paginate_data.data).length > 0">
                        <tr
                          v-for="(form_data, index) in paginate_data.data"
                          v-bind:key="form_data.id"
                          i="index"
                        >
                          <td class="text-center">
                            {{ order_no + index + 1 }}
                          </td>
                          <td class="text-center">
                            {{ form_data.add_note_date }}
                          </td>
                          <td class="text-center">
                            {{ form_data.employee_id_no }}
                          </td>
                          <td class="text-left">
                            {{ form_data.employee_fullname }}
                          </td>
                          <td class="text-left">
                            {{ form_data.designation_name }}
                          </td>
                          <td class="text-left">{{ form_data.sbu_name }}</td>

                          <td class="text-left">
                            {{ form_data.note_issue }}
                          </td>

                          <td class="text-center">
                            {{
                              form_data.out_time +
                              "-" +
                              form_data.return_time
                            }}
                          </td>
                          <td class="text-left">
                            {{
                              form_data.note_type == 1
                                ? "Note Request"
                                : "Others"
                            }}
                          </td>
                          <td class="text-center">
                            <span
                              v-if="form_data.note_approve_status == 1"
                            >
                              Requested</span
                            >
                            <span
                              v-else-if="
                                form_data.note_approve_status == 2
                              "
                            >
                              Approved</span
                            >
                            <span
                              v-else-if="
                                form_data.note_approve_status == 3
                              "
                            >
                              Forwarded</span
                            >
                            <span
                              v-else-if="
                                form_data.note_approve_status == 4
                              "
                            >
                              Rejected</span
                            >
                            <span v-else> - </span>
                          </td>
                          <td class="text-center">
                            <button
                              @click="
                                getModalData(
                                  $event,
                                  {
                                    dataUrl:
                                      'edit/note_request/' + form_data.id,
                                  },
                                  setModalData,
                                  (add_new_type = 3)
                                )
                              "
                              class="btn-xs btn-success"
                              title="Approve"
                            >
                              <i class="fa fa-eye"> </i>
                            </button>
                            <span
                              v-if="form_data.note_approve_status == 1"
                            >
                              <button
                                v-if="lists.edit == 'edit'"
                                @click="
                                  getModalData(
                                    $event,
                                    {
                                      dataUrl:
                                        'edit/note_request/' + form_data.id,
                                    },
                                    setModalData,
                                    (add_new_type = 2)
                                  )
                                "
                                class="btn-xs btn-info"
                                title="Edit"
                              >
                                <i class="fa fa-edit"> </i>
                              </button>
                            </span>
                            <span
                              v-if="form_data.note_approve_status != 1"
                            >
                              <button
                                v-if="lists.edit == 'edit'"
                                class="btn-xs btn-info"
                                title="Already Task Completed!"
                                @click="
                                  AccessDenied(
                                    $event,
                                    (value = 'Already Task Completed!')
                                  )
                                "
                                style="opacity: 0.5"
                              >
                                <i class="fa fa-edit"> </i>
                              </button>
                            </span>
                            <span
                              v-if="form_data.note_approve_status == 1"
                            >
                              <button
                                v-if="lists.delete == 'delete'"
                                @click="
                                  deleteItem({
                                    delUrl:
                                      'delete/note_request/' + form_data.id,
                                  })
                                "
                                title="Delete"
                                class="btn-xs btn-danger"
                              >
                                <i class="fa fa-trash"></i>
                              </button>
                            </span>
                            <span
                              v-if="form_data.note_approve_status != 1"
                            >
                              <button
                                v-if="lists.delete == 'delete'"
                                class="btn-xs btn-danger"
                                title="Already Task Completed!"
                                @click="
                                  AccessDenied(
                                    $event,
                                    (value = 'Already Task Completed!')
                                  )
                                "
                                style="opacity: 0.5"
                              >
                                <i class="fa fa-trash"></i>
                              </button>
                            </span>
                          </td>
                        </tr>
                      </tbody>
                      <tbody v-else>
                        <tr>
                          <td colspan="11" align="center">
                            No data in database
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="row">
                      <div
                        class="dataTables_footer clearfix"
                        style="width: 100%"
                      >
                        <div class="col-md-6" style="float: left">
                          <div
                            class="dataTables_info"
                            id="DataTables_Table_0_info"
                          >
                            Showing {{ paginate_data.current_page }} of
                            {{ paginate_data.last_page }} pages
                          </div>
                        </div>
                        <div class="col-md-6" style="float: right">
                          <div class="dataTables_paginate paging_bootstrap">
                            <pagination
                              :data="paginate_data"
                              :limit="2"
                              @pagination-change-page="getResults"
                            ></pagination>
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

        <modal name="myModal" width="550" height="auto" :clickToClose="false">
          <div v-if="modal_loading">
            <div class="widget-header modal-header">
              <h4 v-if="add_new_type == 1 || add_new_type == 2">
                <i class="fa fa-bars"></i> Note Request Setup
              </h4>
              <h4 v-if="add_new_type == 3">
                <i class="fa fa-bars"></i> Note Request Approval
              </h4>
              <button
                type="button"
                @click="hideModal"
                class="close close-modify"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modify-wraper modal-body">
              <span v-if="add_new_type == 1 || add_new_type == 2">
                <div class="">
                  <form
                    @submit.prevent="
                      add({ add: 'add/note_request' }, resetModal)
                    "
                    class="well form-horizontal needs-validation"
                    novalidate
                  >
                    <div class="col-md-12 date_format_modal_design">
                      <div class="form-group">
                        <label class="col-md-6 control-label"
                          >Employee Name</label
                        >
                        <div class="col-md-12 inputGroupContainer">
                          <div class="input-group">
                            <span
                              class="input-group-addon"
                              style="max-width: 100%"
                              ><i class="glyphicon glyphicon-list"></i
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

                      <div class="form-group">
                        <label class="col-md-6 control-label"
                          >Note Issues</label
                        >
                        <div class="col-md-12 inputGroupContainer">
                          <div class="input-group">
                            <span
                              class="input-group-addon"
                              style="max-width: 100%"
                              ><i class="glyphicon glyphicon-list"></i
                            ></span>
                            <vue-select
                              v-model="note_issues_name_value"
                              :options="option_data.note_issues_data"
                              @select="onSelectNoteIssue"
                              placeholder="Select one"
                              label="text"
                              track-by="text"
                            ></vue-select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-6 control-label"
                          >Note Date</label
                        >
                        <div class="col-md-12 inputGroupContainer">
                          <div class="input-group">
                            <span
                              class="input-group-addon"
                              style="max-width: 100%"
                              ><i class="glyphicon glyphicon-list"></i
                            ></span>
                            <input class="form-control" v-model="form_data.add_note_date" type="date" @click="dateChange($event.target)"  v-on:input="dateChange($event.target)" v-on:keyup="dateChange($event.target)">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-6 control-label"
                          >Note Type</label
                        >
                        <div class="col-md-12 inputGroupContainer">
                          <div class="input-group">
                            <span
                              class="input-group-addon"
                              style="max-width: 100%"
                              ><i class="glyphicon glyphicon-list"></i
                            ></span>
                            <select
                              v-model="form_data.note_type"
                              class="form-control"
                              required
                            >
                              <option selected>Select one</option>
                              <option value="1">Note Request</option>
                              <option value="2">Manual Note</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-6 control-label">Out Time</label>
                        <div class="col-md-12 inputGroupContainer">
                          <div class="input-group">
                            <span
                              class="input-group-addon"
                              style="max-width: 100%"
                              ><i class="glyphicon glyphicon-list"></i
                            ></span>
                            <!-- <input v-model="form_data.office_start_time" id="leave_days" name="leave_days" placeholder="" class="form-control" required="true" type="text"> -->
                            <vue-timepicker
                              class="form-control"
                              v-model="form_data.out_time"
                              required
                            ></vue-timepicker>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-6 control-label">Return Time</label>
                        <div class="col-md-12 inputGroupContainer">
                          <div class="input-group">
                            <span
                              class="input-group-addon"
                              style="max-width: 100%"
                              ><i class="glyphicon glyphicon-list"></i
                            ></span>
                            <!-- <input v-model="form_data.office_end_time" id="leave_days" name="leave_days" placeholder="" class="form-control" required="true" type="text"> -->
                            <vue-timepicker
                              class="form-control"
                              v-model="form_data.return_time"
                              required
                            ></vue-timepicker>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-4 control-label">Remarks</label>
                        <div class="col-md-12 inputGroupContainer">
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-home"></i
                            ></span>
                            <textarea
                              v-model="form_data.add_note_remarks"
                              id="leave_note"
                              name="leave_note"
                              placeholder=""
                              class="form-control"
                             
                              type="text"
                            ></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-actions">
                      <input
                        type="submit"
                        tabindex="4"
                        value="Save"
                        class="btn btn-sm btn-info float-right col-md-2"
                      />
                      <button
                        type="button"
                        @click="hideModal"
                        class="
                          btn btn-sm btn-default
                          float-right
                          col-md-2
                          offset-md-6
                        "
                        style="margin-right: 10px"
                      >
                        Close
                      </button>
                    </div>
                  </form>
                </div>
              </span>
              <span v-else-if="add_new_type == 3">
                <div class="">
                  <form
                    class="well form-horizontal needs-validation"
                    novalidate
                  >
                    <div class="col-md-12">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-6 control-label"
                            >Employee Name</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span
                                class="input-group-addon"
                                style="max-width: 100%"
                                ><i class="glyphicon glyphicon-list"></i
                              ></span>
                              <vue-select
                                v-model="employee_name_value"
                                :options="option_data.employee_data"
                                @select="onSelectEmployee"
                                placeholder="Select one"
                                label="text"
                                track-by="text"
                                disabled
                              ></vue-select>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-6 control-label"
                            >Note Issues</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span
                                class="input-group-addon"
                                style="max-width: 100%"
                                ><i class="glyphicon glyphicon-list"></i
                              ></span>
                              <vue-select
                                v-model="note_issues_name_value"
                                :options="option_data.note_issues_data"
                                @select="onSelectNoteIssue"
                                placeholder="Select one"
                                label="text"
                                track-by="text"
                                disabled
                              ></vue-select>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-6 control-label"
                            >Note Date</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span
                                class="input-group-addon"
                                style="max-width: 100%"
                                ><i class="glyphicon glyphicon-list"></i
                              ></span>
                              <datepicker
                                placeholder="Select Date"
                                v-model="form_data.add_note_date"
                                class="form-control"
                                disabled
                                style="color: #35495e; font-size: 16px"
                              ></datepicker>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-6 control-label"
                            >Out Time</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span
                                class="input-group-addon"
                                style="max-width: 100%"
                                ><i class="glyphicon glyphicon-list"></i
                              ></span>
                              <vue-timepicker
                                class="form-control"
                                v-model="form_data.out_time"
                                disabled
                              ></vue-timepicker>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-6 control-label">Return Time</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span
                                class="input-group-addon"
                                style="max-width: 100%"
                                ><i class="glyphicon glyphicon-list"></i
                              ></span>
                              <vue-timepicker
                                class="form-control"
                                v-model="form_data.return_time"
                                disabled
                              ></vue-timepicker>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-4 control-label">Remarks</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <textarea
                                v-model="form_data.add_note_remarks"
                                id="leave_note"
                                name="leave_note"
                                placeholder=""
                                class="form-control"
                               
                                type="text"
                                readonly
                              ></textarea>
                            </div>
                          </div>
                        </div>
                        <span v-if="form_data.note_approve_status != 4">
                          <span
                            v-if="form_data.note_approve_status != 2"
                          >
                            <div class="form-group">
                              <label
                                class="col-md-4 control-label"
                                style="margin-bottom: 10px"
                                >Remarks</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <textarea
                                    v-model="form_data.manual_atten_comments"
                                    id="city"
                                    name="city"
                                    placeholder="Write your comment ......"
                                    class="form-control"
                                    required="true"
                                  ></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="form-actions col-md-12">
                              <button
                                type="button"
                                @click="
                                  add(
                                    { add: 'approveOrReject/note_request' },
                                    (form_data.approve_reject_status = 1)
                                  )
                                "
                                class="
                                  btn btn-sm btn-success
                                  float-right
                                  col-md-2
                                "
                              >
                                Approve
                              </button>
                              <button
                                type="button"
                                @click="
                                  add(
                                    { add: 'approveOrReject/note_request' },
                                    (form_data.approve_reject_status = 2)
                                  )
                                "
                                class="
                                  btn btn-sm btn-danger
                                  float-right
                                  col-md-2
                                  offset-md-6
                                "
                                style="margin-right: 10px"
                              >
                                Reject
                              </button>
                            </div>
                          </span>
                        </span>
                      </div>
                    </div>
                  </form>
                </div>
              </span>
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
import Loading from "../Loading.vue";
import VueTimepicker from "vue2-timepicker";
// CSS
import "vue2-timepicker/dist/VueTimepicker.css";

export default {
  data() {
    return {
      employee_name_value: "",
      attendance_machine_value: "",
      office_time_value: "",
      note_issues_name_value: "",
      add_new_type:'',
    };
  },

  created() {
    this.getResults(1);
  },
  components: {
    pageLoading: Loading,
    VueTimepicker,
  },
  methods: {
    getDataActiveIctive(v){
      this.page_loading = false;
      this.modal_loading=false;
      this.search_input.search_inpu_all=v;
      this.getResults();
    },
    onSelectEmployee(option) {
      this.today_date = this.form_data.add_note_date;
      this.form_data.employee_id = option.id;
      console.log(this.form_data.employee_id);
      this.form_data.employee_id_no = option.employee_id_no;
      console.log(this.form_data.employee_id_no);
      let uri = URL.baseUrl("shift_finds");
      axios
        .post(uri, {
          employee_id: option.id,
          today_date: this.today_date,
        })
        .then((res) => {
          console.log(res);
          this.form_data.out_time  = res.data.out_time;
          this.form_data.return_time = res.data.return_time;
        })
        .catch((error) => {
          this.form_data.out_time = '00:00';
          this.form_data.return_time = '00:00';
        });
    },
    dateChange: function (target) {
      this.employee_id = this.form_data.employee_id;
      this.today_date = this.form_data.add_note_date;

      let uri = URL.baseUrl("shift_finds");
      axios
        .post(uri, {
          employee_id: this.employee_id,
          today_date: this.today_date,
        })
        .then((res) => {
          console.log(res);
          this.form_data.out_time  = res.data.out_time;
          this.form_data.return_time = res.data.return_time;
        })
        .catch((error) => {
          this.form_data.out_time = '00:00';
          this.form_data.return_time = '00:00';
          // this.modal_loading = true;
        });
    },

    onSelectNoteIssue(option) {
      console.log(option);
      this.form_data.add_note_issues = option.id;
      console.log(this.form_data.note_issues);
    },
    setModalData() {
      this.employee_name_value = this.form_data.employee_name_value;
      this.attendance_machine_value = this.form_data.attendance_machine_value;
      this.office_time_value = this.form_data.office_time_value;
      this.note_issues_name_value =
        this.form_data.note_issues_name_value;
      this.note_type = this.form_data.note_type;
    },
    resetModal() {
      this.employee_name_value = "";
      this.attendance_machine_value = "";
      this.office_time_value = "";
      this.note_issues_name_value = "";
      this.note_type = "";
    },
  },
};
</script>
<style type="text/css">
.multiselect--disabled {
  opacity: 1;
}
.multiselect--disabled .multiselect__current,
.multiselect--disabled .multiselect__select,
.multiselect__option--disabled {
  background: transparent;
  color: #a6a6a6;
}
.vue__time-picker input.display-time.disabled,
.vue__time-picker input.display-time:disabled {
  color: #35495e;
}
</style>