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
                          Mobile / Internet Bill List
                        </h3>
                        <span class="float-sm-right" style="float: right">
                          <div
                            @click="
                              getModalData(
                                $event,
                                { dataUrl: 'create/mobile_internet_bills' },
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
                    <div class="row">
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
                            <span class="info-box-text">Mobile Bill </span>
                            <span class="info-box-number">
                              {{ lists.mobile_bill }}
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
                            <span class="info-box-text">Internet Bill </span>
                            <span class="info-box-number">
                              {{ lists.internet_bill }}
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
                            <span class="info-box-text">Total Bill</span>
                            <span class="info-box-number">{{
                              lists.mobile_bill + lists.internet_bill
                            }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
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
                      class="col-md-2 col-sm-2 col-2 float-left"
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
                    </div>
                    <div class="col-md-2 col-sm-2 col-2 float-left"> 
                      <div class="button_group">
                        <a
                          :href="'payroll/mobile_internet_bills/filedownload'"
                          class="
                            button_s
                            my_file
                            el-button
                            button_s
                            el-button--primary el-button--small btn btn-sm btn-info
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
                          <th class="text-center">Bill Type</th>
                          <th class="text-center">Date</th>
                          <th class="text-center">Amount</th>
                          <th class="text-center">Extra Amount</th>
                          <th class="text-center">Status</th>
                          <th class="text-center">Action</th>
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
                          <td class="text-center">
                            <span
                              v-if="form_data.bill_types == 1"
                              style="color: green"
                              >Mobile Bill</span
                            >
                            <span
                              v-if="form_data.bill_types == 2"
                              style="color: green"
                              >Internet Bill
                            </span>
                          </td>
                          <td class="text-left">{{ form_data.bill_date }}</td>
                          <td class="text-right">
                            {{ form_data.bill_amount | number("0,0.00") }}
                          </td>
                          <td class="text-right">
                            <!-- approve action button -->

                            <button
                              v-if="form_data.request_bill"
                              type="button"
                              class="btn btn-primary"
                              data-toggle="modal"
                              data-target="#exampleModalCenter"
                              @click="
                                setExtraAmountModal(
                                  form_data.id,
                                  form_data.bill_amount,
                                  form_data.bill_amount_extra
                                )
                              "
                            >
                              Click Approve
                            </button>
                            <button
                              v-if="!form_data.request_bill && form_data.bill_amount_extra"
                              type="button"
                              class="btn btn-danger"
                              @click="requestApproveSubmit(form_data.id)"
                            >
                              Approve Request
                            </button>

                            {{ form_data.bill_amount_extra | number("0,0.00") }}
                          </td>
                          <td class="text-center">
                            <span
                              v-if="form_data.bill_status == 1"
                              style="color: green"
                              >Active</span
                            >
                            <span v-else style="color: red">Inactive</span>
                          </td>
                          <td class="text-center">
                            <button
                              class="btn btn-xs btn-info"
                              @click="
                                getModalData(
                                  $event,
                                  {
                                    dataUrl:
                                      'edit/mobile_internet_bills/' +
                                      form_data.id,
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
                                    'delete/mobile_internet_bills/' +
                                    form_data.id,
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
        <!-- Modal -->
        <!-- <div
          class="modal fade bd-example-modal-sm"
          id="exampleModalCenter"
          tabindex="-1"
          role="dialog"
          aria-labelledby="exampleModalCenterTitle"
          aria-hidden="true"
        > -->
        <modal
          class=""
          name="exampleModalCenter"
          height="auto"
          :clickToClose="false"
          width="800"
        >
          <div
            class="modal-dialog modal-dialog-centered modal-sm"
            role="document"
          >
            <div class="modal-content">
              <form @submit.prevent="amountApproveSubmit">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">
                    Modal title
                  </h5>
                  <button
                    type="button"
                    class="close"
                    @click="closeExtraAmountModal"
                    aria-label="Close"
                  >
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="col-md-8">
                    <div class="form-group">
                      <label for="Approveamount"> Approve Amount</label>
                      <input
                        id="Approveamount"
                        type="text"
                        class="form-control"
                        v-model="approveamount"
                        placeholder="Enter amount"
                      />
                    </div>
                    <div class="form-group">
                      <label for="limitAmount"> Limit Amount</label>
                      <input
                        id="limitAmount"
                        readonly
                        disabled
                        type="text"
                        class="form-control"
                        v-model="limitamount"
                      />
                    </div>
                    <div class="form-group">
                      <label for="ExtraAmount"> Extra Amount</label>
                      <input
                        id="ExtraAmount"
                        readonly
                        disabled
                        type="text"
                        class="form-control"
                        v-model="extraamount"
                      />
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    @click="closeExtraAmountModal"
                  >
                    Close
                  </button>
                  <button type="submit" class="btn btn-primary">
                    Save changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </modal>
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
                <h4><i class="fa fa-bars"></i> Mobile / Internet Bill</h4>
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
                      add({ add: 'add/mobile_internet_bills' }, resetModal)
                    "
                    class="form-horizontal row-border"
                    id="validate-1"
                  >
                    <div class="row">
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
                          style="margin-bottom: 10px; margin-right: -1.5px"
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

                        <!-- <div class="col-md-12"> -->
                        <div class="row" style="margin-top: 47px">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Bill Type
                                <sup style="color: red; top: -2px">*</sup>
                              </label>
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <select
                                    @click="car_allowance($event)"
                                    required="true"
                                    class="form-control"
                                    v-model="form_data.bill_types"
                                  >
                                    <option disabled>
                                      --Select--
                                    </option>
                                    <option value="1">Mobile Bill</option>
                                    <option value="2">Internet Bill</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- <div class="row"> -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Bill Date
                                <sup style="color: red; top: -2px">*</sup>
                              </label>
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <datepicker
                                    placeholder="Select Date"
                                    style="width: 131% !important"
                                    v-model="form_data.bill_date"
                                    class="form-control"
                                  ></datepicker>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- </div> -->
                          <!-- <div class="row"> -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Bill Amount
                                <sup style="color: red; top: -2px"
                                  >*</sup
                                ></label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    id="department_name"
                                    v-model="form_data.bill_amount"
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
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="col-md-12 control-label"
                              >Bill Remarks</label
                            >
                            <div class="col-md-12 inputGroupContainer">
                              <div class="input-group">
                                <span class="input-group-addon"
                                  ><i class="glyphicon glyphicon-home"></i
                                ></span>
                                <input
                                  id="department_name"
                                  v-model="form_data.bill_remarks"
                                  name="department_name"
                                  placeholder=""
                                  class="form-control"
                                  type="text"
                                  step="0.01"
                                />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" v-if="form_data.id">
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
                                v-model="form_data.bill_status"
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
                    </div>
                    <div
                      class="form-actions col-md-12"
                      style="margin-top: 47px"
                    >
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

            <!-- Salary Info  -->
            <span v-if="type == 2">
              <div class="widget-header modal-header">
                <h4>
                  <i class="fa fa-bars"></i> Salary Info:
                  <span style="color: green">{{
                    form_data.emp_info.employee_fullname
                  }}</span>
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
              <div class="modal-body">
                <div class="row" v-if="profile_open == 1">
                  <div class="col-md-12">
                    <div
                      class="col-md-9 modify-wraper float-left"
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
                            <td>ID :</td>
                            <td
                              style="
                                width: 25%;
                                padding: 0px;
                                font-weight: bold;
                              "
                            >
                              <input
                                type="hidden"
                                v-model="form_data.employee_id"
                                name=""
                              />
                              {{ form_data.user_employee_data.employee_id_no }}
                            </td>
                            <td>Name :</td>
                            <td
                              style="
                                width: 30%;
                                padding: 0px;
                                font-weight: bold;
                              "
                            >
                              {{
                                form_data.user_employee_data.employee_fullname
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td>Designation:</td>
                            <td
                              style="
                                width: 30%;
                                padding: 0px;
                                font-weight: bold;
                              "
                            >
                              {{
                                form_data.user_employee_data.designation_name
                              }}
                            </td>
                            <td>Department:</td>
                            <td
                              style="
                                width: 30%;
                                padding: 0px;
                                font-weight: bold;
                              "
                            >
                              {{ form_data.user_employee_data.department_name }}
                            </td>
                          </tr>
                          <tr>
                            <td>SBU:</td>
                            <td
                              style="
                                width: 33%;
                                padding: 0px;
                                font-weight: bold;
                              "
                            >
                              {{ form_data.user_employee_data.sbu_name }}
                            </td>
                            <td>Contact:</td>
                            <td
                              style="
                                width: 25%;
                                padding: 0px;
                                font-weight: bold;
                              "
                            >
                              {{ form_data.user_employee_data.employee_mobile }}
                            </td>
                          </tr>
                          <tr>
                            <td>Section:</td>
                            <td
                              style="
                                width: 33%;
                                padding-left: 0px;
                                padding-right: 0px;
                                font-weight: bold;
                              "
                            >
                              {{ form_data.user_employee_data.section_name }}
                            </td>
                            <td>Joining:</td>
                            <td
                              style="
                                width: 25%;
                                padding-left: 0px;
                                padding-right: 0px;
                                font-weight: bold;
                              "
                            >
                              {{
                                form_data.user_employee_data
                                  .employee_joining_date
                              }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <!-- <hr> -->
                    </div>
                    <div class="col-md-3 float-left text-center">
                      <span v-if="form_data.user_employee_data.employee_image">
                        <img
                          :src="`images/${form_data.user_employee_data.employee_image}`"
                          class="card-img-top border rounded"
                          style="margin-top: 2px; width: 130px; height: 150px"
                        />
                      </span>
                      <span v-else>
                        <img
                          v-if="
                            url !== '' ||
                            form_data.user_employee_data.employee_image !== ''
                          "
                          :src="`images/default.png`"
                          class="card-img-top border rounded"
                          style="margin-top: 2px; width: 130px; height: 150px"
                        />
                      </span>
                    </div>
                  </div>
                  <hr />
                </div>
                <div class="container">
                  <table
                    id="employeeTable"
                    class="table table-bordered table-striped salaryTable"
                  >
                    <thead>
                      <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">Basic</th>
                        <th class="text-center">House</th>
                        <th class="text-center">Conveyance</th>
                        <th class="text-center">Medical</th>
                        <th class="text-center">Overtime</th>
                        <th class="text-center">Total</th>
                      </tr>
                    </thead>
                    <tbody v-if="Object.keys(form_data.emp_salary).length > 0">
                      <tr
                        v-for="(form_data, index) in form_data.emp_salary"
                        v-bind:key="form_data.id"
                        i="index"
                      >
                        <td class="text-center">
                          {{ form_data.confirmation_date }}
                        </td>
                        <td class="text-right">{{ form_data.basic_salary }}</td>
                        <td class="text-right">
                          {{ form_data.housing_allowance }}
                        </td>
                        <td class="text-right">
                          {{ form_data.medical_allowance }}
                        </td>
                        <td class="text-right">
                          {{ form_data.conveyance_allowance }}
                        </td>
                        <td class="text-right">
                          {{ form_data.overtime_work_compensation }}
                        </td>
                        <td class="text-right">{{ form_data.gross_salary }}</td>
                      </tr>
                      <tr></tr>
                    </tbody>
                    <tbody v-else>
                      <tr>
                        <td colspan="12" align="center">No data in database</td>
                      </tr>
                    </tbody>
                  </table>
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
      approve_amount_id: 0,
      approveamount: 0,
      limitamount: 0,
      extraamount: 0,
      file_upload_error: "",
      csv_file: "",
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
      excels: "",
      excelData: [],
    };
  },

  created() {
    this.getResults(1);
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
    amountApproveSubmit() {
      let data = {
        approve_amount_id: this.approve_amount_id,
        approveamount: this.approveamount,
      };
      let urls = URL.baseUrl("mobile_bill_update");
      axios
        .get(urls, {
          params: data,
        })
        .then((res) => {
          if (res.data.status == "logout") {
            window.location.href = res.data.url;
          } else {
            if (res.data.status == 1) {
              this.showToster({ status: 1, message: "Update successfull" });
              this.getResults(1);
            } else {
              this.showToster({
                status: 0,
                message: "opps! something went wrong",
              });
            }
            this.$modal.hide("exampleModalCenter");
          }
        })

        .catch((error) => {
          console.log(error);
          this.$modal.hide("exampleModalCenter");
          this.showToster({ status: 0, message: "opps! something went wrong" });
        });
    },
    requestApproveSubmit(id) {
      let data = {
        approve_amount_id: id,
        request_bill: 1,
      };
      let urls = URL.baseUrl("mobile_bill_update_request");
      axios
        .get(urls, {
          params: data,
        })
        .then((res) => {
          if (res.data.status == "logout") {
            window.location.href = res.data.url;
          } else {
            if (res.data.status == 1) {
              this.showToster({ status: 1, message: "Update successfull" });
              this.getResults(1);
            } else {
              this.showToster({
                status: 0,
                message: "opps! something went wrong",
              });
            }
          }
        })

        .catch((error) => {
          console.log(error);
          this.showToster({ status: 0, message: "opps! something went wrong" });
        });
    },
    closeExtraAmountModal() {
      this.$modal.hide("exampleModalCenter");
    },
    setExtraAmountModal(id, amount, extra_amount) {
      this.$modal.show("exampleModalCenter");
      this.approve_amount_id = id;
      this.limitamount = amount;
      this.approveamount = extra_amount;
      this.extraamount = extra_amount;
    },
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
          return alert("Read failure!");
        }
      };
      fileReader.readAsBinaryString(files[0]);
      var input = document.getElementById("upload");
      input.value = "";
    },

    excelFileUpload(excellist) {
      this.modal_page_loading = false;
      let uri = URL.baseUrl("add/excel");
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
      let uri = URL.baseUrl("other_create/increment/" + id);
      console.log(uri);
      axios
        .get(uri)
        .then((res) => {
          console.log(res.data);
          this.form_data = res.data;
          this.form_data.employee_id = id;
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