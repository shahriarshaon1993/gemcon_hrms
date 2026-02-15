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
                          Deduction List
                        </h3>
                        <span class="float-sm-right" style="float: right">
                          <div
                            @click="
                              getModalData(
                                $event,
                                { dataUrl: 'create/others_deduction' },
                                resetModal,
                                (type = 1)
                              )
                            "
                            class="btn-group"
                          >
                            <span class="btn btn-sm btn-info"
                              ><i class="icon-plus"></i>Add New</span
                            >
                          </div>
                          <a class="btn btn-default" href="#"
                            ><i class="fa fa-arrow-left"></i> Back</a
                          >
                        </span>
                      </div>
                    </div>
                    <!-- <div class="row">
                      <div class="col-12 col-sm-12 col-md-3">
                        <div class="info-box">
                          <span class="info-box-icon bg-info elevation-1">
                            <i class="fa fa-paper-plane"></i
                          ></span>
                          <div class="info-box-content">
                            <span class="info-box-text">No. of Employee </span>
                            <span class="info-box-number">
                              {{ lists.total_data }}
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-3">
                        <div class="info-box">
                          <span class="info-box-icon bg-warning elevation-1"
                            ><i class="fas fa-clock"></i
                          ></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Total Uniform </span>
                            <span class="info-box-number">
                              {{ lists.total_uniform }}
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-3">
                        <div class="info-box mb-3">
                          <span class="info-box-icon bg-success elevation-1"
                            ><i class="fa fa-check-circle"></i
                          ></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Total Deposit </span>
                            <span class="info-box-number">
                              {{ lists.total_deposit }}
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix hidden-md-up"></div>
                      <div class="col-12 col-sm-12 col-md-3">
                        <div class="info-box mb-3">
                          <span class="info-box-icon bg-danger elevation-1"
                            ><i class="fa fa-ban"></i
                          ></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Total Others </span>
                            <span class="info-box-number">{{
                              lists.total_others
                            }}</span>
                          </div>
                        </div>
                      </div>
                    </div> -->
                  </div>
                  <div class="card-body col-md-12">
                    <div
                      class="col-md-4 col-sm-4 col-4 float-left"
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
                      class="col-md-4 col-sm-4 col-4 float-left"
                      style="padding: 0px"
                    >
                      <div class="button_group">
                        <a
                          href="javascript:;"
                          class="
                            button_s
                            my_file
                            el-button
                            button_s
                            el-button--primary el-button--small
                          "
                        >
                          <input
                            type="file"
                            class="my_input"
                            @change="importExcel"
                            id="upload"
                          />
                        </a>
                      </div>
                      <div class="button_group">
                        <a
                          :href="'payroll/others_deduction_excel/filedownload'"
                          class="
                            button_s
                            my_file
                            el-button
                            button_s
                            el-button--primary el-button--small
                          "
                        >
                          Exmple File {{ this.backend_url }}
                        </a>
                      </div>
                    </div>
                    <div
                      class="col-md-4 col-sm-4 col-4 float-left"
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
                    <div
                      class="col-md-12 col-sm-12 col-12 float-left"
                      style="padding: 0px"
                    >
                      <p style="color: red" v-for="error in file_upload_error">
                        {{ error }}
                      </p>
                    </div>
                    <table
                      id="employeeTable"
                      class="table table-bordered table-striped employeeTable"
                    >
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th class="text-center">ID</th>
                          <th class="text-center">Name</th>
                          <th class="text-center">Joining</th>
                          <th class="text-center">Designation</th>
                          <th class="text-center">Department</th>
                          <th class="text-center">Comapny</th>
                          <th class="text-center">Type</th>
                          <th class="text-center">Date</th>
                          <th class="text-center">Amount</th>
                          <th class="text-center">Status</th>
                          <th class="text-center" style="width: 18%">Action</th>
                        </tr>
                      </thead>
                      <tbody v-if="Object.keys(paginate_data.data).length > 0">
                        <tr
                          v-for="(form_data, index) in paginate_data.data"
                          v-bind:key="form_data.id"
                          i="index"
                        >
                          <td class="text-center">{{ index + 1 }}</td>
                          <td class="text-center">
                            {{ form_data.employee_id_no }}
                          </td>
                          <td class="text-left">
                            {{ form_data.employee_fullname }}
                          </td>
                          <td class="text-center">
                            {{ form_data.employee_joining_date }}
                          </td>
                          <td class="text-left">
                            {{ form_data.designation_name }}
                          </td>
                          <td class="text-left">
                            {{ form_data.department_name }}
                          </td>
                          <td class="text-left">{{ form_data.sbu_name }}</td>
                          <td class="text-left">{{ form_data.type_name }}</td>

                          <td class="text-left">
                            {{ form_data.deduction_date }}
                          </td>
                          <td class="text-right">
                            {{ form_data.deduction_amount | number("0,0.00") }}
                          </td>
                          <td class="text-center">
                            <span
                              v-if="form_data.deduction_status == 1"
                              style="color: green"
                              >Active</span
                            >
                            <span v-else style="color: red">Inactive</span>
                          </td>
                          <td class="text-center" style="width: 18%">
                            <button
                              class="btn btn-xs btn-info"
                              @click="
                                getModalData(
                                  $event,
                                  {
                                    dataUrl:
                                      'edit/others_deduction/' + form_data.id,
                                  },
                                  setModalData,
                                  (type = 1)
                                )
                              "
                              title="Edit"
                            >
                              <i class="fa fa-edit"> </i> Edit
                            </button>
                            <button
                              class="btn btn-xs btn-danger"
                              @click="
                                deleteItem({
                                  delUrl:
                                    'delete/others_deduction/' + form_data.id,
                                })
                              "
                              title="Delete"
                            >
                              <i class="fa fa-trash"></i> Delete
                            </button>
                          </td>
                        </tr>
                      </tbody>
                      <tbody v-else>
                        <tr>
                          <td colspan="14" align="center">
                            No data in database
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="row">
                      <div
                        class="dataTables_footer clearfix col-md-12 col-12"
                        style="padding: 10px 0px"
                      >
                        <div class="col-md-6 col-6 float-left">
                          <div
                            class="dataTables_info"
                            id="DataTables_Table_0_info"
                          >
                            Showing {{ paginate_data.current_page }} of
                            {{ paginate_data.last_page }} pages
                          </div>
                        </div>
                        <div class="col-md-6 col-6 float-right">
                          <div
                            class="
                              dataTables_paginate
                              paging_bootstrap
                              float-right
                            "
                          >
                            <pagination
                              :data="paginate_data"
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

        <modal
          class=""
          name="myModal"
          height="auto"
          :clickToClose="false"
          width="800"
        >
          <div v-if="modal_loading">
            <span>
              <div class="widget-header modal-header">
                <h4><i class="fa fa-bars"></i> Deduction</h4>
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
                <div class="container">
                  <form
                    @submit.prevent="
                      others_deduction_add(
                        { add: 'add/others_deduction' },
                        resetModal
                      )
                    "
                    class="form-horizontal row-border"
                    id="validate-1"
                  >
                    <div class="row">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group" v-if="!form_data.id">
                              <label class="col-md-6 control-label"
                                >Employee
                                <sup style="color: red; top: -2px"
                                  >*</sup
                                ></label
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
                                    @select="onSelectEmployeeSearch"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="col-md-12 control-label">
                                Date
                                <sup style="color: red; top: -2px"
                                  >*</sup
                                ></label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <datepicker
                                    placeholder="Select Date"
                                    style="width: 131% !important"
                                    v-model="form_data.deduction_date"
                                    class="form-control"
                                  ></datepicker>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="row"
                          v-if="profile_open == 1"
                          style="
                            margin-bottom: 5px;
                            margin-top: 8px;
                            margin-right: -1.5px;
                          "
                        >
                          <div
                            class="col-md-12"
                            style="
                              border: 1px solid #cfcfcf;
                              margin-left: 12px;
                              padding-right: 0px;
                              max-width: 98%;
                            "
                          >
                            <div
                              class="col-md-10 modify-wraper float-left"
                              style="padding: 0px"
                            >
                              <table
                                v-if="
                                  form_data.user_employee_data
                                    ? form_data.user_employee_data
                                        .employee_id_no
                                    : ''
                                "
                                class="table table-hover table-responsive"
                              >
                                <tbody>
                                  <tr>
                                    <td style="font-weight: bold; width: 10%">
                                      Name
                                    </td>
                                    <td style="font-weight: bold">:</td>
                                    <td
                                      style="
                                        width: 55%;
                                        padding-left: 0px;
                                        padding-right: 0px;
                                      "
                                    >
                                      {{
                                        form_data.user_employee_data
                                          .employee_fullname
                                      }}
                                    </td>
                                    <td style="font-weight: bold; width: 5%">
                                      ID
                                    </td>
                                    <td style="font-weight: bold">:</td>
                                    <td
                                      style="
                                        width: 40%;
                                        padding-left: 0px;
                                        padding-right: 0px;
                                      "
                                    >
                                      <input
                                        type="hidden"
                                        v-model="form_data.employee_id"
                                        name=""
                                      />
                                      {{ form_data.company_sbu_id }}
                                      {{
                                        form_data.user_employee_data
                                          .employee_id_no
                                      }}
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="font-weight: bold; width: 10%">
                                      Designation
                                    </td>
                                    <td style="font-weight: bold">:</td>
                                    <td
                                      style="
                                        width: 40%;
                                        padding-left: 0px;
                                        padding-right: 0px;
                                      "
                                    >
                                      {{
                                        form_data.user_employee_data
                                          .designation_name
                                      }}
                                    </td>
                                    <td style="font-weight: bold">Contact</td>
                                    <td style="font-weight: bold">:</td>
                                    <td
                                      style="
                                        width: 25%;
                                        padding-left: 0px;
                                        padding-right: 0px;
                                      "
                                    >
                                      {{
                                        form_data.user_employee_data
                                          .employee_mobile
                                      }}
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="font-weight: bold; width: 10%">
                                      Department
                                    </td>
                                    <td style="font-weight: bold">:</td>
                                    <td
                                      style="
                                        width: 40%;
                                        padding-left: 0px;
                                        padding-right: 0px;
                                      "
                                    >
                                      {{
                                        form_data.user_employee_data
                                          .department_name
                                      }}
                                    </td>
                                    <td style="font-weight: bold">Joining</td>
                                    <td style="font-weight: bold">:</td>
                                    <td
                                      style="
                                        width: 25%;
                                        padding-left: 0px;
                                        padding-right: 0px;
                                      "
                                    >
                                      {{
                                        form_data.user_employee_data
                                          .employee_joining_date
                                      }}
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="font-weight: bold">SBU</td>
                                    <td style="font-weight: bold">:</td>
                                    <td
                                      style="
                                        width: 33%;
                                        padding-left: 0px;
                                        padding-right: 0px;
                                      "
                                    >
                                      {{
                                        form_data.user_employee_data.sbu_name
                                      }}
                                    </td>
                                    <td style="font-weight: bold">Location</td>
                                    <td style="font-weight: bold">:</td>
                                    <td
                                      style="
                                        width: 33%;
                                        padding-left: 0px;
                                        padding-right: 0px;
                                      "
                                    >
                                      {{
                                        form_data.user_employee_data
                                          .work_location_name
                                      }}
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <!-- <hr> -->
                            </div>
                            <div
                              class="col-md-2 float-left"
                              style="padding: 0px; text-align: right !important"
                            >
                              <span
                                v-if="
                                  form_data.user_employee_data.employee_image
                                "
                              >
                                <img
                                  :src="`images/${form_data.user_employee_data.employee_image}`"
                                  class="card-img-top border rounded"
                                  style="
                                    margin-top: 1px;
                                    width: 119px;
                                    height: 132px;
                                    margin-left: -9px;
                                    margin-right: 1px;
                                  "
                                />
                              </span>
                              <span v-else>
                                <img
                                  v-if="
                                    url !== '' ||
                                    form_data.user_employee_data
                                      .employee_image !== ''
                                  "
                                  :src="`images/default.png`"
                                  class="card-img-top border rounded"
                                  style="
                                    margin-top: 1px;
                                    width: 119px;
                                    height: 132px;
                                    margin-left: -9px;
                                    margin-right: 1px;
                                  "
                                />
                              </span>
                            </div>
                          </div>
                          <hr />
                        </div>
                        <div class="row" style="margin-top: 47px">
                          <!-- <div class="col-md-12"> -->
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>Deduction types</th>
                                <th>Deduction amount</th>
                                <th>Deduction remarks</th>
                                <th>
                                  <i
                                    @click="addDeductionData()"
                                    class="fa fa-plus btn btn-success btn-sm"
                                    >+</i
                                  >
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr
                                v-for="(item, index) in deduction_multiple"
                                :key="index"
                              >
                                <td>
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
                                    <select
                                      class="form-control"
                                      v-model="item.deduction_type"
                                      required="true"
                                    >
                                      <option disabled>
                                        --Select--
                                      </option>
                                      <option
                                        v-for="(
                                          deduction, index
                                        ) in deduction_types"
                                        :value="deduction.id"
                                        :key="index"
                                      >
                                        {{ deduction.type_name }}
                                      </option>
                                    </select>
                                  </div>
                                </td>
                                <td>
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
                                    <input
                                      id="department_name"
                                      v-model="item.deduction_amount"
                                      name="department_name"
                                      required="true"
                                      placeholder=""
                                      class="form-control"
                                      type="number"
                                      step="0.01"
                                    />
                                  </div>
                                </td>
                                <td>
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
                                    <input
                                      id="department_name"
                                      v-model="item.deduction_remarks"
                                      name="department_name"
                                      placeholder=""
                                      class="form-control"
                                      type="text"
                                      step="0.01"
                                    />
                                  </div>
                                </td>
                                <td>
                                  <i
                                    @click="removeDeductionData(index)"
                                    class="fas fa-trash btn btn-danger btn-sm"
                                    >-</i
                                  >
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          <!-- <div class="row"> -->
                        </div>
                        <!-- </div> -->
                        <!-- <div class="row"> -->
                        <!-- <div class="form-group" v-if="form_data.id">
                          <label class="col-md-6 control-label">Status</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span
                                class="input-group-addon"
                                style="max-width: 100%"
                                ><i class="glyphicon glyphicon-list"></i
                              ></span>
                              <select
                                class="form-control"
                                v-model="form_data.deduction_status"
                                required="true"
                              >
                                <option disabled>--Select--</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                              </select>
                            </div>
                          </div>
                        </div> -->
                      </div>
                    </div>
                    <div class="form-actions col-md-12">
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
import * as xlsx from 'xlsx/xlsx';
export default {
  data() {
    return {
      deduction_multiple: [
        {
          deduction_amount: "",
          deduction_remarks: "",
          deduction_type: "",
        },
      ],
      deduction_types: [],
      file_upload_error: "",
      employee_name_value: "",
      gross_salary_entry: "",
      basic_salary_entry: "",
      housing_allowance_entry: "",
      medical_allowance_entry: "",
      conveyance_allowance_entry: "",
      overtime_work_compensation_entry: "",
      profile_open: "",
      car_allowance_field: "",
      others_allowance_entry: "",
      sbu_id: "",
    };
  },

  created() {
    this.getResults(1);
    this.gettypeData();
  },
  components: {
    pageLoading: Loading,
  },
  watch: {
    gross_salary_entry: function (val) {
      this.form_data.gross_salary = val;
      this.basic_salary_entry =
        this.form_data.gross_salary *
        (this.form_data.salary_setting.basic_salary / 100);
      this.form_data.basic_salary = this.basic_salary_entry;

      this.housing_allowance_entry =
        this.form_data.gross_salary *
        (this.form_data.salary_setting.housing_allowance / 100);
      this.form_data.housing_allowance = this.housing_allowance_entry;

      this.medical_allowance_entry =
        this.form_data.gross_salary *
        (this.form_data.salary_setting.medical_allowance / 100);
      this.form_data.medical_allowance = this.medical_allowance_entry;

      this.conveyance_allowance_entry =
        this.form_data.gross_salary *
        (this.form_data.salary_setting.conveyance_allowance / 100);
      this.form_data.conveyance_allowance = this.conveyance_allowance_entry;

      this.overtime_work_compensation_entry =
        this.form_data.gross_salary *
        (this.form_data.salary_setting.overtime_work_compensation / 100);
      this.form_data.overtime_work_compensation =
        this.overtime_work_compensation_entry;
    },
    basic_salary_entry: function (val) {
      this.form_data.basic_salary = val;
    },
    housing_allowance_entry: function (val) {
      this.form_data.housing_allowance = val;
    },
    medical_allowance_entry: function (val) {
      this.form_data.medical_allowance = val;
    },
    conveyance_allowance_entry: function (val) {
      this.form_data.conveyance_allowance = val;
    },
    overtime_work_compensation_entry: function (val) {
      this.form_data.overtime_work_compensation = val;
    },
  },
  methods: {
    importExcel(e) {
      const files = e.target.files;
      console.log(files);
      if (!files.length) {
        return;
      } else if (!/\.(xls|xlsx)$/.test(files[0].name.toLowerCase())) {
        return alert(
          "The upload format is incorrect. Please upload xls or xlsx format"
        );
      }
      const fileReader = new FileReader();
      fileReader.onload = (ev) => {
        try {
          const data = ev.target.result;
          const XLSX = xlsx;
          const workbook = XLSX.read(data, {
            type: "binary",
          });
          const wsname = workbook.SheetNames[0]; // Take the first sheet，wb.SheetNames[0] :Take the name of the first sheet in the sheets
          const ws = XLSX.utils.sheet_to_json(workbook.Sheets[wsname]); // Generate JSON table content，wb.Sheets[Sheet名]    Get the data of the first sheet
          const excellist = []; // Clear received data
          // Edit data
          for (var i = 0; i < ws.length; i++) {
            excellist.push(ws[i]);
          }
          this.excelFileUpload(excellist);
          console.log("Read results", excellist); // At this point, you get an array containing objects that need to be processed
        } catch (e) {
          console.log("Error", e);
          return alert("Read failure!");
        }
      };
      fileReader.readAsBinaryString(files[0]);
      var input = document.getElementById("upload");
      input.value = "";
    },
    excelFileUpload(excellist) {
      this.modal_page_loading = false;
      let uri = URL.baseUrl("add/others_deduction_excel");
      axios
        .post(uri, {
          form_data: excellist,
        })
        .then((res) => {
          console.log(res.data);
          this.getResults();
          // this.form_data = excellist;
          this.modal_page_loading = true;
          this.errors = null;
          if (res.data.status == 3) {
            //  alert("qqq");
            this.file_upload_error = res.data.error;
          } else {
            this.file_upload_error = null;
          }
          if (callback) {
            callback();
          }
        })
        .catch((error) => {
          this.modal_page_loading = true;
        });
    },
    others_deduction_add(addUrl, callback) {
      console.log(this.form_data);
      console.log(URL.baseUrl(addUrl.add));
      this.modal_loading = false;
      this.form_data.deduction_multiple = this.deduction_multiple;
      axios
        .post(URL.baseUrl(addUrl.add), this.form_data)
        .then((res) => {
          console.log(res);
          if (res.data.status == 1) {
            // this.showToster(res.data);
            if (!this.form_data.id) {
              this.formReset();
              if (this.$route.params.folderId) {
                this.getResults(1, this.$route.params.folderId);
              } else {
                this.getResults(1);
              }
              this.hideModal();
              // var functionString = "emphideModal"
              // eval("typeof " + functionString)
              // console.log());
              if (typeof emphideModal == "function") {
                this.emphideModal();
              }

              this.page_loading = true;
              this.modal_loading = true;
            } else {
              this.modal_loading = true;
              this.page_loading = true;
              this.hideModal();
              // this.emphideModal();
              // var functionString = "emphideModal"
              // console.log(eval("typeof " + functionString));
              if (typeof emphideModal == "function") {
                this.emphideModal();
              }
              if (this.$route.params.folderId) {
                this.getResults(1, this.$route.params.folderId);
              } else {
                this.getResults(this.current_page_no);
              }
            }
            this.page_loading = true;
            this.modal_loading = true;
          }
          this.errors = null;
          this.modal_loading = true;
          this.showToster(res.data);
          if (callback) {
            callback();
          }
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
          this.page_loading = true;
          this.modal_loading = true;
          // this.hideModal();
          var msg = "opps! something went wrong";
          this.showToster({ status: 0, message: msg });
        });
    },
    removeDeductionData(index) {
      this.deduction_multiple.splice(index, 1);
    },
    addDeductionData() {
      this.deduction_multiple.push({
        deduction_amount: "",
        deduction_remarks: "",
        deduction_type: "",
      });
    },
    gettypeData() {
      // console.log('aaaaaa');
      let uri = URL.baseUrl("get_deduction_type");
      // console.log(uri);
      axios
        .get(uri)
        .then((res) => {
          this.deduction_types = res.data;
          // console.log(res.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    onSelectEmployee(option) {
      console.log(option);
      this.form_data.employee_id = option.id;
      console.log(this.form_data.employee_id);
    },
    onSelectEmployeeSearch(option) {
      this.profile_open = 1;
      this.getModalDataOther(option.id);
      this.form_data.employee_id = option.id;
      this.form_data.employee_id = this.form_data.employee_id;
      console.log(this.form_data.employee_id);
      console.log(option);
      let allData = this.form_data.user_employee_data_all[option.id];
      this.form_data.employee_id = allData["id"];
    },
    getModalDataOther(id) {
      // console.log('aaaaaa');
      this.modal_loading = false;
      let uri = URL.baseUrl("other_create/increment/" + id);
      console.log(uri);
      axios
        .get(uri)
        .then((res) => {
          console.log(res.data);
          this.form_data = res.data;
          this.form_data.employee_id = id;
          this.form_data.company_sbu_id =
            this.form_data.user_employee_data.employee_sbu;
          this.form_data.car_allowance_status = 2;
          this.form_data.provident_fund = 1;
          this.form_data.arrear_others_allowance = 1;
          this.modal_loading = true;
          this.errors = null;
          if (callback) {
            callback();
          }
        })
        .catch((error) => {
          this.modal_page_loading = true;
        });
    },
    car_allowance(e) {
      var val = e.target.value;
      // console.log(e.target.value);
      if (val == 1) {
        this.car_allowance_field = 1;
      } else {
        this.car_allowance_field = 2;
      }
    },

    setModalData() {
      this.profile_open = 1;
      this.employee_name_value = this.form_data.employee_name_value;
      this.gross_salary_entry = this.form_data.gross_salary;
      this.basic_salary_entry = this.form_data.basic_salary;
      this.housing_allowance_entry = this.form_data.housing_allowance;
      this.medical_allowance_entry = this.form_data.medical_allowance;
      this.conveyance_allowance_entry = this.form_data.conveyance_allowance;
      this.overtime_work_compensation_entry =
        this.form_data.overtime_work_compensation;
    },
    resetModal() {
      this.gross_salary_entry = "";
      this.basic_salary_entry = "";
      this.housing_allowance_entry = "";
      this.medical_allowance_entry = "";
      this.conveyance_allowance_entry = "";
      this.overtime_work_compensation_entry = "";
      this.employee_name_value = "";
      this.profile_open = "";
      this.form_data.car_allowance_status = 2;
      this.form_data.provident_fund = 1;
      this.form_data.arrear_others_allowance = 1;
      this.car_allowance_field = "";
      this.others_allowance_entry = "";
    },
  },
};
</script>
<style type="text/css">
.salaryTable.table td {
  padding: 15px 5px;
}
</style>