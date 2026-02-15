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
                          <!-- v-if="lists.add=='add'" -->
                          <div
                            @click="
                              getModalDatadeduction(
                                $event,
                                { dataUrl: 'create/deduction_option' },
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
                          <a class="btn btn-default" @click="$router.go(-1)"
                            ><i class="fa fa-arrow-left"></i> Back</a
                          >
                        </span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-sm-12 col-md-3">
                        <div class="info-box">
                          <span class="info-box-icon bg-info elevation-1"
                            ><i class="fa fa-paper-plane"></i
                          ></span>
                          <div class="info-box-content">
                            <span class="info-box-text"
                              >Total Deduction No.</span
                            >
                            <span
                              class="info-box-number"
                              v-if="lists.total_data"
                            >
                              {{ lists.total_data }}
                            </span>
                            <span class="info-box-number" v-else>
                              {{ "0.00" }}
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-3">
                        <div class="info-box">
                          <span class="info-box-icon bg-warning elevation-1"
                            ><i class="fas fa-list"></i
                          ></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Deduction Amount </span>
                            <span
                              class="info-box-number"
                              v-if="lists.total_loan_amount"
                            >
                              {{ lists.total_loan_amount }}
                            </span>
                            <span class="info-box-number" v-else>
                              {{ "0.00" }}
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-3">
                        <div class="info-box">
                          <span class="info-box-icon bg-success elevation-1"
                            ><i class="fas fa-list"></i
                          ></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Paid Amount </span>
                            <span
                              class="info-box-number"
                              v-if="lists.total_paid_loan_amount"
                            >
                              {{ lists.total_paid_loan_amount }}
                            </span>
                            <span class="info-box-number" v-else>
                              {{ "0.00" }}
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-3">
                        <div class="info-box">
                          <span class="info-box-icon bg-danger elevation-1"
                            ><i class="fas fa-list"></i
                          ></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Due Amount </span>
                            <span
                              class="info-box-number"
                              v-if="lists.total_due_amount"
                            >
                              {{
                                lists.total_due_amount -
                                lists.total_paid_loan_amount
                              }}
                            </span>
                            <span class="info-box-number" v-else>
                              {{ "0.00" }}
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix hidden-md-up"></div>
                    </div>
                  </div>
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
                          <th class="text-center">#</th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('employee_id_no')"
                            @click="sortingChanged('employee_id_no')"
                          >
                            Employee ID <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('employee_fullname')"
                            @click="sortingChanged('employee_fullname')"
                          >
                            Name <i class="fas fa-sort"></i>
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
                            v-bind:class="getSortingClass('department_name')"
                            @click="sortingChanged('department_name')"
                          >
                            Department<i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('sbu_name')"
                            @click="sortingChanged('sbu_name')"
                          >
                            Company/SBU<i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('loan_type')"
                            @click="sortingChanged('loan_type')"
                          >
                            Deduction Type <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('loan_amount')"
                            @click="sortingChanged('loan_amount')"
                          >
                            Deduction Amount <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('disburse_date')"
                            @click="sortingChanged('disburse_date')"
                          >
                            Received Date <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('no_of_installment')"
                            @click="sortingChanged('no_of_installment')"
                          >
                            No of EMI <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="
                              getSortingClass('first_installment_date')
                            "
                            @click="sortingChanged('first_installment_date')"
                          >
                            First Deduction Date <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="
                              getSortingClass('last_installment_date')
                            "
                            @click="sortingChanged('last_installment_date')"
                          >
                            Last Deduction Date <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('loan_status')"
                            @click="sortingChanged('loan_status')"
                          >
                            Status <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('refundable')"
                            @click="sortingChanged('refundable')"
                          >
                            Refundable <i class="fas fa-sort"></i>
                          </th>
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
                          <td class="text-left">
                            {{ form_data.designation_name }}
                          </td>
                          <td class="text-left">
                            {{ form_data.department_name }}
                          </td>
                          <td class="text-left">{{ form_data.sbu_name }}</td>
                          <td class="text-center">
                            <span v-if="form_data.loan_type == 1">
                              {{ "Salary" }}
                            </span>
                            <span v-if="form_data.loan_type == 2">
                              {{ "Personal" }}
                            </span>
                            <span v-if="form_data.loan_type == 3">
                              {{ "PF" }}
                            </span>
                            <span v-if="form_data.loan_type == 4">
                              {{ "Others" }}
                            </span>
                            <!-- {{form_data.loan_type}} -->
                          </td>
                          <td class="text-right">
                            {{ form_data.loan_amount | number("0,0") }}
                          </td>
                          <td class="text-center">
                            {{ form_data.disburse_date }}
                          </td>
                          <td class="text-center">
                            {{ form_data.no_of_installment }}
                          </td>
                          <td class="text-center">
                            {{ form_data.first_installment_date }}
                          </td>
                          <td class="text-center">
                            {{ form_data.last_installment_date }}
                          </td>
                          <td class="text-center">
                            <span
                              v-if="form_data.loan_clearance_status == 2"
                              style="color: green"
                            >
                              {{ "Active" }}
                            </span>
                            <span v-else style="color: red">
                              {{ "Clear" }}
                            </span>
                          </td>
                          <td class="text-center">
                            <span
                              v-if="form_data.refundable == 1"
                              style="color: green"
                            >
                              {{ "Yes" }}
                            </span>
                            <span v-else style="color: red">
                              {{ "No" }}
                            </span>
                          </td>
                          <td class="text-center" style="width: 18%">
                            <button
                              class="btn btn-xs btn-success"
                              @click="
                                getModalDatadeduction(
                                  $event,
                                  {
                                    dataUrl:
                                      'schedule/deduction_option/' +
                                      form_data.id,
                                  },
                                  setModalData,
                                  (type = 2)
                                )
                              "
                              title="Edit"
                            >
                              <i class="fa fa-calendar"> </i> Schedule
                            </button>
                            <button
                              class="btn btn-xs btn-info"
                              @click="
                                getModalDatadeduction(
                                  $event,
                                  {
                                    dataUrl:
                                      'edit/deduction_option/' + form_data.id,
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
                                    'delete/deduction_option/' + form_data.id,
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
            <span v-if="type == 1">
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
                <form class="form-horizontal row-border" id="validate-1">
                  <div class="" style="margin-right: 0px">
                    <div class="col-md-12">
                      <div class="form-group" v-if="!form_data.id">
                        <label class="col-md-6 control-label"
                          >Employee
                          <sup style="color: red; top: -2px">*</sup></label
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
                      <div
                        class="row"
                        v-if="profile_open == 1"
                        style="
                          margin-bottom: 10px;
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
                                  ? form_data.user_employee_data.employee_id_no
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
                                    {{ form_data.user_employee_data.sbu_name }}
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
                            style="padding: 0px; text-align: right !important"  v-if="form_data.user_employee_data"
                          >
                            <span
                              v-if="form_data.user_employee_data.employee_image"
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

                      <div
                        class="col-md-12"
                        v-if="profile_open == 1"
                        style="margin-bottom: 10px"
                      >
                        <!--                             <hr>
 -->
                      </div>
                      <div class="row">
                        <div
                          class="col-md-6"
                          v-bind:class="form_data.loanEligblity"
                        >
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="col-md-12 control-label"
                                  >Deduction Type
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
                                    <select
                                      class="form-control"
                                      v-model="form_data.loan_type"
                                      required="true"
                                    >
                                      <option disabled value="0">
                                        --Select--
                                      </option>
                                      <option value="1">Uniform</option>
                                      <option value="2">
                                        Security Deposit
                                      </option>
                                      <option value="3">Others</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="col-md-12 control-label"
                                  >Deduction Amount
                                  <sup style="color: red; top: -2px">*</sup>
                                </label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
                                    <input
                                      id="department_name"
                                      v-model="form_data.loan_amount"
                                      name="department_name"
                                      placeholder=""
                                      class="form-control"
                                      required="true"
                                     
                                      type="number"
                                      step="0.01"
                                    />
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="col-md-12 control-label"
                                  >No. of Installment
                                  <sup style="color: red; top: -2px">*</sup>
                                </label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
                                    <input
                                      id="department_name"
                                      v-model="form_data.no_of_installment"
                                      name="department_name"
                                      @keyup="installmentNumber($event)"
                                      placeholder=""
                                      class="form-control"
                                      required="true"
                                     
                                      type="number"
                                      step="0.01"
                                    />
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="col-md-12 control-label"
                                  >Disbursement Date
                                  <sup style="color: red; top: -2px">*</sup>
                                </label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
                                    <input class="form-control" v-model="form_data.disburse_date" type="date">
                                    <!-- <datepicker
                                      placeholder="Select Date"
                                      :required="true"
                                      style="width: 131% !important"
                                      v-model="form_data.disburse_date"
                                      class="form-control"
                                    ></datepicker> -->
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="col-md-12 control-label"
                                  >First Installment Date
                                  <sup style="color: red; top: -2px">*</sup>
                                </label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
                                    <input class="form-control"  v-on:input="updateValue($event.target)"
                                      v-on:focus="selectAll"
                                      v-on:keyup="updateValue($event.target)"
                                      v-on:keydown="updateValue($event.target)" v-model="form_data.first_installment_date" type="date">
                                    <!-- <datepicker
                                      placeholder="Select Date"
                                      :required="true"
                                      style="width: 131% !important"
                                      v-model="form_data.first_installment_date"
                                      class="form-control"
                                      v-on:input="updateValue($event.target)"
                                      v-on:focus="selectAll"
                                      v-on:keyup="updateValue($event.target)"
                                      v-on:keydown="updateValue($event.target)"
                                    ></datepicker> -->
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="col-md-12 control-label"
                                  >Last Installment Date</label
                                >
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
                                    <datepicker
                                      placeholder="Select Date"
                                      readonly="true"
                                      style="width: 131% !important"
                                      v-model="form_data.last_installment_date"
                                      class="form-control"
                                    ></datepicker>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="col-md-12 control-label"
                                  >Deduction mode
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
                                    <select
                                      class="form-control"
                                      v-model="form_data.loan_deduct_policy"
                                      required="true"
                                    >
                                      <option disabled>
                                        --Select--
                                      </option>
                                      <option value="1" selected>Auto</option>
                                      <option value="0">Manual</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="col-md-12 control-label"
                                  >Refundable??</label
                                >
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <input
                                      type="checkbox"
                                      v-model="form_data.refundable"
                                    />
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group" v-if="form_data.id">
                            <label class="col-md-12 control-label"
                              >Status</label
                            >
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span
                                  class="input-group-addon"
                                  style="max-width: 100%"
                                  ><i class="glyphicon glyphicon-list"></i
                                ></span>
                                <select
                                  class="form-control"
                                  v-model="form_data.loan_status"
                                  required="true"
                                >
                                  <option disabled>--Select--</option>
                                  <option value="1">Active</option>
                                  <option value="0">Inactive</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div v-if="profile_open == 1">
                            <label>Deduction Eligiblity:</label>
                            <span
                              v-if="form_data.loanEligblitys == 0"
                              style="color: green"
                              class="blink_me"
                              ><strong>Yes</strong></span
                            >
                            <span
                              v-if="form_data.loanEligblitys == 1"
                              style="color: red"
                              class="blink_me"
                              ><strong>No</strong></span
                            >
                          </div>
                          <div class="">
                            <label class="control-label">Salary Info:</label>
                            <table
                              class="
                                table table-hover table-bordered
                                loan_salary_info_table
                              "
                              style="width: 100%"
                            >
                              <thead>
                                <tr class="text-center;">
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Gross
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Basic
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    House
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Transport
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Medical
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-if="profile_open == 1">
                                  <td class="text-center">
                                    <span
                                      v-if="
                                        form_data.employee_salary.total_salary
                                      "
                                    >
                                      {{
                                        form_data.employee_salary.total_salary
                                      }}
                                    </span>
                                    <span v-else> - </span>
                                  </td>
                                  <td class="text-center">
                                    {{ form_data.employee_salary.total_basic }}
                                  </td>
                                  <td class="text-center">
                                    {{ form_data.employee_salary.total_house }}
                                  </td>
                                  <td class="text-center">
                                    {{
                                      form_data.employee_salary.total_medical
                                    }}
                                  </td>
                                  <td class="text-center">
                                    {{
                                      form_data.employee_salary.total_transport
                                    }}
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <div>
                            <label class="control-label"
                              >Previous Disbursement History:</label
                            >
                            <table
                              class="
                                table table-hover table-bordered
                                loan_salary_info_table
                              "
                              style="width: 100%"
                            >
                              <thead>
                                <tr class="text-center;">
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Date
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Type
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Amount
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Status
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="loan in form_data.employee_loan">
                                  <td
                                    class="text-center"
                                    style="padding: 5px 0px"
                                  >
                                    {{ loan.disburse_date }}
                                  </td>
                                  <td class="text-center">
                                    <span v-if="loan.loan_type == 1">
                                      {{ "Salary" }}
                                    </span>
                                    <span v-if="loan.loan_type == 2">
                                      {{ "Personal" }}
                                    </span>
                                    <span v-if="loan.loan_type == 3">
                                      {{ "PF" }}
                                    </span>
                                    <span v-if="loan.loan_type == 4">
                                      {{ "Others" }}
                                    </span>
                                  </td>
                                  <td class="text-center">
                                    {{ loan.loan_amount }}
                                  </td>
                                  <td class="text-center">
                                    <span
                                      v-if="loan.loan_clearance_status == 1"
                                      style="color: green"
                                    >
                                      {{ "Clear" }}
                                    </span>
                                    <span
                                      v-if="loan.loan_clearance_status == 2"
                                      style="color: red"
                                    >
                                      {{ "Not Clear" }}
                                    </span>
                                    <span v-else style="color: red">{{
                                      "Not Clear"
                                    }}</span>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <button class="btn btn-primary" @click="addRow()">
                            Add more
                          </button>
                          <div>
                            <table
                              class="
                                table table-hover table-bordered
                                loan_salary_info_table
                              "
                              style="width: 100%"
                            >
                              <thead>
                                <tr class="text-center;">
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    No of installment
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Loan type
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Loan amount
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Disburse date
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    First installment date
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Last installment date
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Loan deduct policy
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Refundable
                                  </th>
                                  <th
                                    style="
                                      text-align: center;
                                      vertical-align: middle;
                                      background: rgb(245, 245, 245) none repeat
                                        scroll 0% 0%;
                                    "
                                  >
                                    Remove
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr
                                  v-for="(add_more, index) in add_more_data"
                                  :key="index"
                                >
                                  <td
                                    class="text-center"
                                    style="padding: 5px 0px"
                                  >
                                    {{ add_more.no_of_installment }}
                                  </td>
                                  <td class="text-center">
                                    {{ add_more.loan_type }}
                                  </td>
                                  <td class="text-center">
                                    {{ add_more.loan_amount }}
                                  </td>
                                  <td class="text-center">
                                    {{ add_more.disburse_date }}
                                  </td>
                                  <td class="text-center">
                                    {{ add_more.first_installment_date }}
                                  </td>
                                  <td class="text-center">
                                    {{ add_more.last_installment_date }}
                                  </td>
                                  <td class="text-center">
                                    {{ add_more.loan_deduct_policy }}
                                  </td>
                                  <td class="text-center">
                                    {{ add_more.refundable }}
                                  </td>
                                  <td class="text-center">
                                    <button
                                      class="btn btn-primary"
                                      @click="RemoveRow(index)"
                                    >
                                      -
                                    </button>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-actions col-md-12">
                    <input
                      type="submit"
                      v-bind:class="form_data.loanEligblity"
                      tabindex="4"
                      value="Save"
                      @click="
                        add_deduction(
                          { add: 'add/deduction_option' },
                          resetModal
                        )
                      "
                      class="btn btn-sm btn-info float-right col-md-2 col-2"
                    />
                    <button
                      type="button"
                      @click="hideModal"
                      class="
                        btn btn-sm btn-default
                        float-right
                        col-md-2
                        offset-md-6
                        col-2
                      "
                      style="margin-right: 10px"
                    >
                      Close
                    </button>
                  </div>
                </form>
              </div>
            </span>
            <span v-if="type == 2">
              <div class="widget-header modal-header">
                <h4><i class="fa fa-bars"></i> Deduction Schedule</h4>
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
                <div style="margin-right: 0px">
                  <div class="col-md-12">
                    <div
                      class="row"
                      v-if="profile_open == 1"
                      style="
                        margin-bottom: 10px;
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
                                ? form_data.user_employee_data.employee_id_no
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
                                <td style="font-weight: bold; width: 5%">ID</td>
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
                                    form_data.user_employee_data.employee_id_no
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
                                    form_data.user_employee_data.employee_mobile
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
                                    form_data.user_employee_data.department_name
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
                                  {{ form_data.user_employee_data.sbu_name }}
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
                          style="padding: 0px; text-align: right !important" v-if="form_data.user_employee_data"
                        >
                          <span
                            v-if="form_data.user_employee_data.employee_image"
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
                                form_data.user_employee_data.employee_image !==
                                  ''
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
                    <div class="col-md-12" v-if="profile_open == 1">
                      <!-- <hr> -->
                    </div>
                    <!-- {{form_data.loan_approve_status}} -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="">
                          <label class="control-label" style="margin-top: 5px"
                            >Schedule Info:</label
                          >
                          <button
                            v-if="form_data.loan_approve_status != 2"
                            type="button"
                            @click="
                              add(
                                { add: 'approveOrReject/deduction_option' },
                                (form_data.approve_reject_status = 1)
                              )
                            "
                            class="
                              btn btn-sm btn-md btn-success
                              float-right
                              col-md-2
                            "
                            style="border-color: #3ca6ea"
                          >
                            <i class="fa fa-check"></i>
                            Approve
                          </button>
                          <button
                            v-if="form_data.loan_approve_status != 2"
                            type="button"
                            @click="
                              add(
                                { add: 'approveOrReject/deduction_option' },
                                (form_data.approve_reject_status = 2)
                              )
                            "
                            class="
                              btn btn-sm btn-md btn-warning
                              float-right
                              col-md-2
                              offset-md-6
                            "
                            style="
                              margin-right: 10px;
                              margin-bottom: 10px;
                              color: #fff;
                            "
                          >
                            <i class="fa fa-ban"></i>
                            Decline
                          </button>
                          <span v-else style="color: green">
                            Deduction Approved!
                          </span>
                          <table
                            class="
                              table table-hover table-bordered
                              loan_salary_info_table
                            "
                            style="width: 100%"
                          >
                            <thead>
                              <tr class="text-center;">
                                <th
                                  style="
                                    text-align: center;
                                    vertical-align: middle;
                                    background: rgb(245, 245, 245) none repeat
                                      scroll 0% 0%;
                                  "
                                >
                                  SL
                                </th>
                                <th
                                  style="
                                    text-align: center;
                                    vertical-align: middle;
                                    background: rgb(245, 245, 245) none repeat
                                      scroll 0% 0%;
                                  "
                                >
                                  Date
                                </th>
                                <th
                                  style="
                                    text-align: center;
                                    vertical-align: middle;
                                    background: rgb(245, 245, 245) none repeat
                                      scroll 0% 0%;
                                  "
                                >
                                  Amount
                                </th>
                                <th
                                  style="
                                    text-align: center;
                                    vertical-align: middle;
                                    background: rgb(245, 245, 245) none repeat
                                      scroll 0% 0%;
                                  "
                                >
                                  EMI
                                </th>
                                <th
                                  style="
                                    text-align: center;
                                    vertical-align: middle;
                                    background: rgb(245, 245, 245) none repeat
                                      scroll 0% 0%;
                                  "
                                >
                                  Rest
                                </th>
                                <th
                                  style="
                                    text-align: center;
                                    vertical-align: middle;
                                    background: rgb(245, 245, 245) none repeat
                                      scroll 0% 0%;
                                  "
                                >
                                  Policy
                                </th>
                                <th
                                  style="
                                    text-align: center;
                                    vertical-align: middle;
                                    background: rgb(245, 245, 245) none repeat
                                      scroll 0% 0%;
                                  "
                                >
                                  Status
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                              <!-- <span v-if="profile_open==1"> -->
                              <tr
                                v-if="form_data.loan_schedule"
                                v-for="schedule in form_data.loan_schedule"
                              >
                                <td class="text-center">
                                  {{ schedule.serial_no }}
                                </td>
                                <td class="text-center">
                                  {{ schedule.installment_date }}
                                </td>
                                <td class="text-right">
                                  {{ schedule.loan_amount | number("0,0.00") }}
                                </td>
                                <td class="text-right">
                                  {{
                                    schedule.installment_amount
                                      | number("0,0.00")
                                  }}
                                </td>
                                <td class="text-right">
                                  {{
                                    schedule.remaining_amount | number("0,0.00")
                                  }}
                                </td>
                                <td class="text-right">
                                  {{ schedule.loan_deduct_policy }}
                                </td>
                                <td class="text-center">
                                  <span
                                    style="color: orange"
                                    v-if="schedule.installment_status == 'Due'"
                                  >
                                    {{ schedule.installment_status }}
                                  </span>
                                  <span style="color: green" v-else>
                                    {{ "Paid" }}
                                  </span>
                                </td>
                              </tr>
                              <tr>
                                <th
                                  colspan="3"
                                  style="
                                    text-align: right;
                                    vertical-align: middle;
                                    background: rgb(245, 245, 245) none repeat
                                      scroll 0% 0%;
                                  "
                                >
                                  Total Amount
                                  {{ form_data.loan_amount | number("0,0.00") }}
                                </th>
                                <th
                                  style="
                                    text-align: right;
                                    vertical-align: middle;
                                    background: rgb(245, 245, 245) none repeat
                                      scroll 0% 0%;
                                  "
                                >
                                  Paid:
                                  {{ form_data.paid_amount | number("0,0.00") }}
                                </th>
                                <th
                                  colspan="3"
                                  style="
                                    text-align: left;
                                    vertical-align: middle;
                                    background: rgb(245, 245, 245) none repeat
                                      scroll 0% 0%;
                                  "
                                >
                                  Due:
                                  {{
                                    (form_data.loan_amount -
                                      form_data.paid_amount)
                                      | number("0,0.00")
                                  }}
                                </th>
                              </tr>
                              <!-- </span> -->
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
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
import $ from "jquery";

export default {
  data() {
    return {
      add_more_data: [],
      employee_name_value: "",
      gross_salary_entry: "",
      basic_salary_entry: "",
      housing_allowance_entry: "",
      medical_allowance_entry: "",
      conveyance_allowance_entry: "",
      overtime_work_compensation_entry: "",
      profile_open: "",
      increment_type_field: "",
      car_allowance_field: "",
      increment_percentage_entry: "",
      gross_salary_entryyy: "",
      last_installment_dateeee: "",
      total_salary: "",
      type: 0,
      edit_id: null,
    };
  },
  created() {
    this.getResults(1);
  },
  components: {
    pageLoading: Loading,
  },
  methods: {
    RemoveRow(index) {
      this.add_more_data.splice(index, 1);
    },
    getModalDatadeduction(event, obj, callback) {
      // console.log(this.types);
      if (this.types == undefined) {
        this.showModal();
      } else if (this.types == false) {
        this.showModal();
        this.temporary_pric.get_pey = this.temporary_pric.total_pay;
      } else {
        this.showModal();
      }

      // console.log( this.types);
      if (obj && obj.dataUrl) {
        console.log(obj.dataUrl);
        this.modal_loading = false;
        axios
          .get(URL.baseUrl(obj.dataUrl))

          .then((res) => {
            // alert(this.types);

            console.log(res.data);
            if (res.data.status == 0) {
              this.showToster(res.data);

              // this.form_data = res.data;
            }
            
            this.option_data = res.data;
            this.item_unit = res.data.item_unit;
            this.items = res.data.items;
            this.r_items = res.data.r_items;
            this.Branch = res.data.Branch;
            (this.posStatus = res.data.posStatus),
              //  this.lists.pos_status=1;
              //  this.lists.posStatus='';
              //  this.lists.pos_status = res.data.pos_status;
              //  this.OpeingAmount = res.data.OpeingAmount;
              (this.OpeingItems = res.data.OpeingItems);
            this.termsAndCondition = res.data.termsAndCondition;
            this.modal_loading = true;
            this.errors = null;
            this.pos_status = res.data.pos_status;
            // this.getAccountCollection();
            if (this.types == undefined) {
              this.form_data = res.data;
              this.edit_id = res.data.id;
              this.add_more_data.push({
                no_of_installment: this.form_data.no_of_installment,
                loan_type: this.form_data.loan_type,
                loan_amount: this.form_data.loan_amount,
                disburse_date: this.form_data.disburse_date,
                first_installment_date: this.form_data.first_installment_date,
                last_installment_date: this.form_data.last_installment_date,
                loan_deduct_policy: this.form_data.loan_deduct_policy,
                refundable: this.form_data.refundable,
              });
            }
            // (this.types = 1), (this.types = true), (this.form_data = res.data);
            if (!this.form_data.id) {
              if (callback) {
                callback();
              }
            } else {
              if (callback) {
                callback();
              }
            }
          })
          .catch((error) => {
            this.showToster({
              status: 0,
              message: "opps! something went wrong",
            });
            this.modal_loading = true;
          });
      } else {
        this.form_data = {};
        this.modal_loading = true;
      }
    },
    addRow() {
      // alert("dfdf");
      // form_data.no_of_installment
      // console.log(event);
      if (this.form_data.loan_type) {
        this.add_more_data.push({
          no_of_installment: this.form_data.no_of_installment,
          loan_type: this.form_data.loan_type,
          loan_amount: this.form_data.loan_amount,
          disburse_date: this.form_data.disburse_date,
          first_installment_date: this.form_data.first_installment_date,
          last_installment_date: this.form_data.last_installment_date,
          loan_deduct_policy: this.form_data.loan_deduct_policy,
          refundable: this.form_data.refundable,
        });
        this.form_data.no_of_installment = "";
        this.form_data.loan_type = "";
        this.form_data.loan_amount = "";
        this.form_data.disburse_date = "";
        this.form_data.first_installment_date = "";
        this.form_data.last_installment_date = "";
        this.form_data.loan_deduct_policy = "";
        this.form_data.refundable = "";
      } else {
        alert("Please fill all the fields");
      }

      console.log(this.add_more_data);
    },
    add_deduction(addUrl, callback) {
      if (!this.form_data.employee_id) {
        alert("Please select employee");
        return false;
      }
      let sendData = {
        id: this.edit_id,
        employee_id: this.form_data.employee_id,
        list: this.add_more_data,
      };
      console.log(this.add_more_data);
      console.log(this.form_data);
      console.log(URL.baseUrl(addUrl.add));
      this.modal_loading = false;
      axios
        .post(URL.baseUrl(addUrl.add), sendData)
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
    // formatCompat(date) {
    //   var ms = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    //   return date.getDate() + ' ' + ms[date.getMonth()] + ' ' + date.getFullYear();
    // },
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
      this.modal_loading = false;
      // console.log('aaaaaa');
      let uri = URL.baseUrl("other_create/deduction_option/" + id);
      console.log(uri);
      axios
        .get(uri)
        .then((res) => {
          console.log(res.data);
          if (res.data.status == 0) {
            this.showToster(res.data);
          }
          this.form_data = res.data;
          if (res.data.employee_salary != null) {
            this.form_data.employee_salary = res.data.employee_salary;
          } else {
            this.form_data.employee_salary = "";
          }
          if (res.data.employee_loan != null) {
            this.form_data.employee_loan = res.data.employee_loan;
          } else {
            this.form_data.employee_loan = "";
          }
          this.form_data.employee_id = id;
          this.modal_loading = true;
          this.errors = null;
          if (callback) {
            callback();
          }
        })
        .catch((error) => {
          this.modal_loading = true;
          this.modal_page_loading = true;
        });
    },

    setModalData() {
      this.profile_open = 1;
    },
    resetModal() {
      this.add_more_data = [];
      this.profile_open = "";
      this.employee_name_value = "";
    },
    installmentNumber(event) {
      var period = this.form_data.salary_setting.loan_settlement_period;
      if (event.target.value > 0 && event.target.value <= period) {
        this.form_data.no_of_installment = event.target.value;
      } else {
        alert("The minimum value 1 and maximum value " + period);
        this.form_data.no_of_installment = 1;
      }
      console.log(event.target.value);
    },
    updateValue: function (target) {
      const date1 = new Date(this.form_data.first_installment_date);
      const installment_no = this.form_data.no_of_installment;
      console.log(installment_no);
      this.last_installment_dateeee = new Date(
        date1.setMonth(date1.getMonth() + parseInt(installment_no) - 1)
      );
      this.form_data.last_installment_date = new Date(
        this.last_installment_dateeee
      );
    },
    selectAll: function (event) {
      setTimeout(function () {
        event.target.select();
      }, 0);
    },
  },
};
</script>
<style type="text/css">
.loan_salary_info_table td {
  border: 1px solid #ddd !important;
}

.loanEligblity {
  pointer-events: none;
  opacity: 0.3;
}
</style>