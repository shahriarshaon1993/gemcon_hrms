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
                          Salary List
                        </h3>
                        <!-- <span class="float-sm-right" style="float: right">
                          <div
                            v-if="lists.add == 'add'"
                            @click="
                              getModalData(
                                $event,
                                { dataUrl: 'create/salary' },
                                userresetModal,
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
                        </span> -->
                      </div>
                    </div>
                    <nav style="padding-bottom: 15px" id="salary_tab">
                      <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a
                          class="nav-item nav-link active salary_tab"
                          id="nav-employeeList-tab"
                          data-toggle="tab"
                          href="#nav-employeeList"
                          role="tab"
                          aria-controls="nav-profile"
                          aria-selected="true"
                        >
                          Employee List</a
                        >
                        <a
                          class="nav-item nav-link salary_tab"
                          v-if="lists.bank == 'bank'"
                          id="nav-home-tab"
                          data-toggle="tab"
                          href="#nav-home"
                          role="tab"
                          aria-controls="nav-home"
                          aria-selected="false"
                          >Bank Salary</a
                        >
                        <a
                          class="nav-item nav-link salary_tab"
                          v-if="lists.cash == 'cash'"
                          id="nav-profile-tab"
                          data-toggle="tab"
                          href="#nav-profile"
                          role="tab"
                          aria-controls="nav-profile"
                          aria-selected="false"
                          >Cash Salary</a
                        >
                      </div>
                    </nav>
                  </div>
                  <div class="tab-content" id="nav-tabContent">
                    <div
                      class="tab-pane fade show active"
                      id="nav-employeeList"
                      role="tabpanel"
                      aria-labelledby="nav-employeeList-tab"
                    >
                      <div class="card-body col-md-12">
                        <div class="row report-box">
                          <!-- <div
                            class="form-group col-md-3 float-left"
                            style="padding: 0px"
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
                                  :options="option_data.company_sbu_data"
                                  @select="employeesSbu"
                                  placeholder="Select one"
                                  label="text"
                                  track-by="text"
                                ></vue-select>
                              </div>
                            </div>
                          </div>
                          <div
                            class="form-group col-md-3 float-left"
                            style="padding: 0px"
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
                                  :options="option_data.department_data"
                                  @select="onSelectDepartment"
                                  placeholder="Select one"
                                  label="text"
                                  track-by="text"
                                >
                                </vue-select>
                              </div>
                            </div>
                          </div>

                          <div
                            class="form-group col-md-3 float-left"
                            style="padding: 0px"
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
                                  :options="option_data.work_location_data"
                                  @select="employeesWorkLocation"
                                  placeholder="Select one"
                                  label="text"
                                  track-by="text"
                                >
                                </vue-select>
                              </div>
                            </div>
                          </div>

                          <div
                            class="form-group col-md-3 float-left"
                            style="padding: 0px"
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
                                  label="text"
                                  track-by="text"
                                >
                                </vue-select>
                              </div>
                            </div>
                          </div> -->
                          <div class="col-md-12">
                            <!-- <button type="submit" class="btn btn-sm btn-info float-right"> <i class="fa fa-search"></i> Search</button> -->
                            <button
                              style="
                                border-radius: 5px;
                                margin-right: -15px;
                                padding: 5px 30px;
                              "
                              @click="viewReportsssaz"
                              type="button"
                              class="btn btn-info float-right"
                            >
                              Search
                            </button>
                          </div>
                        </div>
                        <div
                          class="col-md-6 col-sm-6 col-6 float-left"
                          style="padding: 5px"
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
                                <option value="1000000">All</option>
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
                          style="padding: 0px; text-align: end; color: #17a2b8"
                        >
                          <strong>
                            Panding :
                            {{ Object.keys(paginate_data_2nd.data).length }}
                          </strong>
                        </div>
                        <div
                          class="col-md-2 col-sm-2 col-2 float-left"
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
                                <!-- <input
                                  v-on:keyup="viewReportsssaz"
                                  v-model="search_input.search_key"
                                  type="text"
                                  aria-controls="DataTables_Table_0"
                                  class="form-control search-keyword"
                                  id="search"
                                  placeholder="Search..."
                                /> -->
                              </div>
                            </label>
                          </div>
                        </div>
                        <table
                          id="employeeTable"
                          class="
                            table table-bordered table-striped
                            employeeTable
                          "
                        >
                          <thead>
                            <tr>
                              <th
                                class="text-center"
                                v-bind:class="getSortingClass('id')"
                                @click="sortingChanged('id')"
                              >
                                SL <i class="fas fa-sort"></i>
                              </th>
                              <th
                                class="text-center"
                                v-bind:class="getSortingClass('employee_id_no')"
                                @click="sortingChanged('employee_id_no')"
                              >
                                Emp. ID <i class="fas fa-sort"></i>
                              </th>
                              <th
                                class="text-center"
                                v-bind:class="
                                  getSortingClass('employee_fullname')
                                "
                                @click="sortingChanged('employee_fullname')"
                              >
                                Name <i class="fas fa-sort"></i>
                              </th>
                              <th
                                class="text-center"
                                v-bind:class="
                                  getSortingClass('employee_joining_date')
                                "
                                @click="sortingChanged('employee_joining_date')"
                              >
                                Joining Date <i class="fas fa-sort"></i>
                              </th>
                              <th
                                class="text-center"
                                v-bind:class="
                                  getSortingClass('employee_designation')
                                "
                                @click="sortingChanged('employee_designation')"
                              >
                                Designation <i class="fas fa-sort"></i>
                              </th>
                              <th
                                class="text-center"
                                v-bind:class="
                                  getSortingClass('employee_department')
                                "
                                @click="sortingChanged('employee_department')"
                              >
                                Department <i class="fas fa-sort"></i>
                              </th>
                              <th
                                class="text-center"
                                v-bind:class="getSortingClass('employee_sbu')"
                                @click="sortingChanged('employee_sbu')"
                              >
                                Company/SBU <i class="fas fa-sort"></i>
                              </th>
                              <th
                                class="text-center"
                                v-bind:class="
                                  getSortingClass('employee_status')
                                "
                                @click="sortingChanged('employee_status')"
                              >
                                Status <i class="fas fa-sort"></i>
                              </th>
                              <th class="text-center">Action</th>
                            </tr>
                          </thead>
                          <tbody
                            v-if="
                              Object.keys(paginate_data_2nd.data).length > 0
                            "
                          >
                            <tr
                              v-for="(
                                form_data, index
                              ) in paginate_data_2nd.data"
                              v-bind:key="form_data.id"
                              i="index"
                            >
                              <td class="text-center">
                                {{ order_no + index + 1 }}
                              </td>
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
                              <td class="text-left">
                                {{ form_data.sbu_name }}
                              </td>
                              <td class="text-center">
                                <span
                                  v-if="form_data.employee_status == 1"
                                  style="color: green"
                                  >Active</span
                                >
                                <span v-else style="color: red">Inactive</span>
                              </td>
                              <td class="text-center" style="width: 2px">
                                <button
                                  class="btn btn-xs btn-info"
                                  @click="
                                    EmpgetModalData(
                                      $event,
                                      {
                                        dataUrl:
                                          'update/salary/' + form_data.id,
                                      },
                                      usersetModalData,
                                      (type = 1)
                                    )
                                  "
                                  title="Edit"
                                >
                                  <i class="fa fa-edit"> </i> Edit
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
                            class="dataTables_footer clearfix"
                            style="width: 100%"
                          >
                            <div class="col-md-6" style="float: left">
                              <div
                                class="dataTables_info"
                                id="DataTables_Table_0_info"
                              >
                                Showing {{ paginate_data_2nd.current_page }} of
                                {{ paginate_data_2nd.last_page }} pages
                              </div>
                            </div>
                            <div class="col-md-6" style="float: right">
                              <div class="dataTables_paginate paging_bootstrap">
                                <pagination
                                  :data="paginate_data_2nd"
                                  :limit="2"
                                  @pagination-change-page="viewReportsssaz"
                                ></pagination>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="nav-home"
                      role="tabpanel"
                      aria-labelledby="nav-home-tab"
                    >
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
                                <option value="1000000">All</option>
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
                          style="padding: 0px; text-align: end; color: #17a2b8"
                        >
                          <strong>
                            Bank: {{ Object.keys(paginate_data.data).length }}
                          </strong>
                        </div>
                        <div
                          class="col-md-2 col-sm-2 col-2 float-left"
                          style="padding: 5px"
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
                          class="
                            table table-bordered table-striped
                            employeeTable
                          "
                        >
                          <thead>
                            <tr>
                              <th class="text-center">#</th>
                              <th class="text-center">Emp. ID</th>
                              <th class="text-center" style="width: 14%">
                                Name
                              </th>
                              <th class="text-center" style="width: 7%">
                                Joining Date
                              </th>
                              <!-- <th class="text-center">Provident Fund</th> -->
                              <th class="text-center" style="width: 7%">
                                Confirm. Date
                              </th>
                              <th class="text-center">Gross</th>
                              <th class="text-center">Basic</th>
                              <th class="text-center">House</th>
                              <th class="text-center">Conveyance</th>
                              <th class="text-center">Medical</th>
                              <th class="text-center">Car Allowance</th>
                              <th class="text-center">others Allowance</th>
                              <th class="text-center">Phone Allowance</th>
                              <th class="text-center">PF</th>
                              <th class="text-center">Salary On</th>
                              <th class="text-center">Status</th>
                              <th class="text-center" style="width: 14%">
                                Action
                              </th>
                            </tr>
                          </thead>
                          <tbody
                            v-if="Object.keys(paginate_data.data).length > 0"
                          >
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
                              <!-- <td class="text-center">
                                      <span v-if="form_data.provident_fund==1">{{'Yes'}}</span>
                                      <span v-else>{{'No'}}</span>
                                    </td> -->
                              <td class="text-center">
                                {{ form_data.confirmation_date }}
                              </td>
                              <td class="text-right">
                                {{ form_data.gross_salary | number("0,0") }}
                              </td>
                              <td class="text-right">
                                {{ form_data.basic_salary | number("0,0") }}
                              </td>
                              <td class="text-right">
                                {{
                                  form_data.housing_allowance | number("0,0")
                                }}
                              </td>
                              <td class="text-right">
                                {{
                                  form_data.conveyance_allowance | number("0,0")
                                }}
                              </td>
                              <td class="text-right">
                                {{
                                  form_data.medical_allowance | number("0,0")
                                }}
                              </td>
                              <td class="text-right">
                                {{
                                  form_data.car_allowance_amount | number("0,0")
                                }}
                              </td>
                              <td class="text-right">
                                {{ form_data.others_allowance | number("0,0") }}
                              </td>
                              <td class="text-right">
                                {{ form_data.phone_allowance | number("0,0") }}
                              </td>
                              <td class="text-right">
                                {{
                                  form_data.provident_fund_amount
                                    | number("0,0")
                                }}
                              </td>

                              <td class="text-center">
                                <span
                                  v-if="form_data.salary_goes_to == 1"
                                  style="color: green"
                                  >Cash</span
                                >
                                <span
                                  v-if="form_data.salary_goes_to == 2"
                                  style="color: green"
                                  >Bank</span
                                >
                                <!-- <span v-else style="color:red;">Inactive</span> -->
                              </td>
                              <td class="text-center">
                                <span
                                  v-if="form_data.salary_status == 1"
                                  style="color: green"
                                  >Active</span
                                >
                                <span v-else style="color: red">Inactive</span>
                              </td>
                              <td class="text-center" style="width: 12%">
                                <!-- v-if="lists.view=='view'" -->
                                <button
                                  class="btn btn-xs btn-success"
                                  @click="
                                    getModalData(
                                      $event,
                                      {
                                        dataUrl:
                                          'salary_details/salary/' +
                                          form_data.employee_id,
                                      },
                                      setModalData,
                                      (type = 2)
                                    )
                                  "
                                  title="Edit"
                                >
                                  <i class="fa fa-info-circle"> </i> Info
                                </button>
                                <!-- v-if="lists.edit=='edit'" -->
                                <button
                                  class="btn btn-xs btn-info"
                                  v-if="lists.add == 'add'"
                                  @click="
                                    getModalData(
                                      $event,
                                      {
                                        dataUrl:
                                          'salary_edit/salary/' + form_data.id,
                                      },
                                      setModalData,
                                      (type = 1)
                                    )
                                  "
                                  title="Edit"
                                >
                                  <i class="fa fa-edit"> </i> Edit
                                </button>
                                <!-- v-if="lists.delete=='delete'" -->
                                <button
                                  class="btn btn-xs btn-danger"
                                  v-if="lists.delete == 'delete'"
                                  @click="
                                    deleteItem({
                                      delUrl: 'delete/salary/' + form_data.id,
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
                    </div>

                    <div
                      class="tab-pane fade"
                      id="nav-profile"
                      role="tabpanel"
                      aria-labelledby="nav-profile-tab"
                    >
                      <div class="card-body col-md-12">
                        <div
                          class="col-md-6 col-sm-6 col-6 float-left"
                          style="padding: 5px"
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
                                <option value="1000000">All</option>
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
                          style="padding: 0px; text-align: end; color: #17a2b8"
                        >
                          <strong>
                            Cash: {{ Object.keys(paginate_data1.data).length }}
                          </strong>
                        </div>
                        <div
                          class="col-md-2 col-sm-2 col-2 float-left"
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
                          class="
                            table table-bordered table-striped
                            employeeTable
                          "
                        >
                          <thead>
                            <tr>
                              <th class="text-center">#</th>
                              <th class="text-center">Emp. ID</th>
                              <th class="text-center" style="width: 14%">
                                Name
                              </th>
                              <th class="text-center" style="width: 7%">
                                Joining Date
                              </th>
                              <!-- <th class="text-center">Provident Fund</th> -->
                              <th class="text-center" style="width: 7%">
                                Confirm. Date
                              </th>
                              <th class="text-center">Gross</th>
                              <th class="text-center">Basic</th>
                              <th class="text-center">House</th>
                              <th class="text-center">Conveyance</th>
                              <th class="text-center">Medical</th>
                              <th class="text-center">Car Allowance</th>
                              <th class="text-center">others Allowance</th>
                              <th class="text-center">Phone Allowance</th>
                              <th class="text-center">PF</th>
                              <th class="text-center">Salary On</th>
                              <th class="text-center">Status</th>
                              <th class="text-center" style="width: 14%">
                                Action
                              </th>
                            </tr>
                          </thead>
                          <tbody
                            v-if="Object.keys(paginate_data1.data).length > 0"
                          >
                            <tr
                              v-for="(form_data, index) in paginate_data1.data"
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
                              <!-- <td class="text-center">
                                      <span v-if="form_data.provident_fund==1">{{'Yes'}}</span>
                                      <span v-else>{{'No'}}</span>
                                    </td> -->
                              <td class="text-center">
                                {{ form_data.confirmation_date }}
                              </td>
                              <td class="text-right">
                                {{ form_data.gross_salary | number("0,0") }}
                              </td>
                              <td class="text-right">
                                {{ form_data.basic_salary | number("0,0") }}
                              </td>
                              <td class="text-right">
                                {{
                                  form_data.housing_allowance | number("0,0")
                                }}
                              </td>
                              <td class="text-right">
                                {{
                                  form_data.conveyance_allowance | number("0,0")
                                }}
                              </td>
                              <td class="text-right">
                                {{
                                  form_data.medical_allowance | number("0,0")
                                }}
                              </td>
                              <td class="text-right">
                                {{
                                  form_data.car_allowance_amount | number("0,0")
                                }}
                              </td>
                              <td class="text-right">
                                {{ form_data.others_allowance | number("0,0") }}
                              </td>
                              <td class="text-right">
                                {{ form_data.phone_allowance | number("0,0") }}
                              </td>
                              <td class="text-right">
                                {{
                                  form_data.provident_fund_amount
                                    | number("0,0")
                                }}
                              </td>

                              <td class="text-center">
                                <span
                                  v-if="form_data.salary_goes_to == 1"
                                  style="color: green"
                                  >Cash</span
                                >
                                <span
                                  v-if="form_data.salary_goes_to == 2"
                                  style="color: green"
                                  >Bank</span
                                >
                                <!-- <span v-else style="color:red;">Inactive</span> -->
                              </td>
                              <td class="text-center">
                                <span
                                  v-if="form_data.salary_status == 1"
                                  style="color: green"
                                  >Active</span
                                >
                                <span v-else style="color: red">Inactive</span>
                              </td>
                              <td class="text-center">
                                <!-- v-if="lists.view=='view'" -->
                                <button
                                  class="btn btn-xs btn-success"
                                  @click="
                                    getModalData(
                                      $event,
                                      {
                                        dataUrl:
                                          'salary_details/salary/' +
                                          form_data.employee_id,
                                      },
                                      setModalData,
                                      (type = 2)
                                    )
                                  "
                                  title="Edit"
                                >
                                  <i class="fa fa-info-circle"> </i> Info
                                </button>
                                <!-- v-if="lists.edit=='edit'" -->
                                <button
                                  class="btn btn-xs btn-info"
                                  @click="
                                    getModalData(
                                      $event,
                                      {
                                        dataUrl:
                                          'salary_edit/salary/' + form_data.id,
                                      },
                                      setModalData,
                                      (type = 1)
                                    )
                                  "
                                  title="Edit"
                                >
                                  <i class="fa fa-edit"> </i> Edit
                                </button>
                                <!-- v-if="lists.delete=='delete'" -->
                                <button
                                  class="btn btn-xs btn-danger"
                                  @click="
                                    deleteItem({
                                      delUrl: 'delete/salary/' + form_data.id,
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
                            class="dataTables_footer clearfix"
                            style="width: 100%"
                          >
                            <div class="col-md-6" style="float: left">
                              <div
                                class="dataTables_info"
                                id="DataTables_Table_0_info"
                              >
                                Showing {{ paginate_data1.current_page }} of
                                {{ paginate_data1.last_page }} pages
                              </div>
                            </div>
                            <div class="col-md-6" style="float: right">
                              <div class="dataTables_paginate paging_bootstrap">
                                <pagination
                                  :data="paginate_data1"
                                  :limit="2"
                                  @pagination-change-page="getResults"
                                ></pagination>
                              </div>
                            </div>
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
            <!-- Salary Details -->
            <span v-if="type == 1">
              <div class="widget-header modal-header">
                <h4><i class="fa fa-bars"></i> Salary Add</h4>
                <button
                  type="button"
                  @click="hideModal"
                  class="close close-modify"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modify-wraper modal-body" style="margin-top: -10px">
                <div class="container">
                  <form
                    @submit.prevent="add({ add: 'add/salary' }, resetModal)"
                    class="form-horizontal row-border"
                    id="validate-1"
                  >
                    <br />
                    <div class="row">
                      <div class="col-md-12">
                        <!-- <div class="form-group" v-if="!form_data.id">
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
                        </div> -->
                        <div
                          class="row"
                          v-if="profile_open == 1"
                          style="margin-bottom: 10px; margin-right: -1.5px"
                        >
                          <!-- {{ this.modal_loading== false ? 'Loading...' : '' }} -->
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
                                      <!-- {{ form_data.company_sbu_id }} -->
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
                            </div>
                            <div
                              class="col-md-2 float-left"
                              style="padding: 0px; text-align: right !important"
                            >
                              <span
                                v-if="
                                  form_data.user_employee_data
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
                                    form_data.user_employee_data !== ''
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
                          class="row"
                          style="
                            margin-bottom: 0px;
                            margin-right: -1.5px;
                            margin-top: 0px;
                          "
                        >
                          <div class="col-md-12" style="padding: 0px">
                            <div class="col-md-5 float-left">
                              <div class="form-group">
                                <label class="col-md-6 control-label"
                                  >Company/SBU
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
                                      v-model="company_sbu_value"
                                      :options="option_data.company_sbu_data"
                                      @select="onSelectEsbuData"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-4 float-left">
                              <div class="form-group">
                                <label class="col-md-12 control-label"
                                  >Bank A/C
                                  <sup style="color: red; top: -2px"
                                    >*</sup
                                  ></label
                                >
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
                                    <input v-if = "form_data.user_employee_data"
                                      v-model="
                                        form_data.user_employee_data
                                          .ebc_account_number
                                      "
                                      name="department_name"
                                      placeholder=""
                                      class="form-control"
                                      type="text"
                                    />
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3 float-left">
                              <div class="form-group">
                                <div class="form-group">
                                  <label class="col-md-12 control-label"
                                    >Bank-Status</label
                                  >
                                  <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span
                                        class="input-group-addon"
                                        style="max-width: 100%"
                                        ><i class="glyphicon glyphicon-list"></i
                                      ></span>
                                      <select v-if = "form_data.user_employee_data"
                                        class="form-control"
                                        v-model="
                                          form_data.user_employee_data
                                            .bank_status
                                        "
                                        required="true"
                                      >
                                        <option disabled>
                                          --Select--
                                        </option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Gross Salary
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
                                    v-model="gross_salary_entry"
                                    name="department_name"
                                    placeholder=""
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Mode of Payment
                                <sup style="color: red; top: -2px"
                                  >*</sup
                                ></label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <select
                                    class="form-control"
                                    v-model="form_data.salary_goes_to"
                                    required="true"
                                  >
                                    <option disabled>
                                      --Select--
                                    </option>
                                    <option value="1">Cash</option>
                                    <option value="2" selected>Bank</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Effective Date
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
                                    v-model="form_data.confirmation_date"
                                    class="form-control"
                                  ></datepicker>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Car Allowance</label
                              >
                              <div
                                class="col-md-6 inputGroupContainer float-left"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <select
                                    @click="car_allowance($event)"
                                    class="form-control"
                                    v-model="form_data.car_allowance_status"
                                  >
                                    <option disabled>
                                      --Select--
                                    </option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                  </select>
                                </div>
                              </div>
                              <div
                                v-if="
                                  car_allowance_field == 1 ||
                                  form_data.car_allowance_amount
                                "
                                class="col-md-6 inputGroupContainer float-left"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="form_data.car_allowance_amount"
                                    name="department_name"
                                    placeholder=""
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Basic Salary</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="basic_salary_entry"
                                    name="department_name"
                                    placeholder=""
                                    readonly="true"
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Housing Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="housing_allowance_entry"
                                    name="department_name"
                                    placeholder=""
                                    readonly="true"
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Medical Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="medical_allowance_entry"
                                    name="department_name"
                                    placeholder=""
                                    readonly="true"
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Conveyance Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="conveyance_allowance_entry"
                                    name="department_name"
                                    placeholder=""
                                    readonly="true"
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div
                              class="form-group col-md-12 float-left"
                              style="padding: 0px"
                            >
                              <label class="col-md-12 float-left"
                                >Provident Fund
                                <!-- <input v-model="form_data.provident_fund"  @change="ProvidentFund($event)" type="checkbox" value="1" style="margin-left: 29px;">   -->
                              </label>
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="provident_fund_amount_entry"
                                    class="form-control"
                                    readonly="true"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Others Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="form_data.others_allowance"
                                    name="department_name"
                                    placeholder=""
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Phone Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="form_data.phone_allowance"
                                    name="department_name"
                                    placeholder=""
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12"
                                >Gratuity Fund
                                <input
                                  v-model="form_data.gratuity_fund"
                                  type="checkbox"
                                  value="1"
                                  style="margin-left: 29px"
                                />
                              </label>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group" v-if="form_data.id">
                              <label class="col-md-6 control-label"
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
                                    v-model="form_data.salary_status"
                                    required="true"
                                  >
                                    <option disabled>
                                      --Select--
                                    </option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
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

            <!-- Salary Info  -->
            <span v-if="type == 2">
              <div class="widget-header modal-header">
                <h4>
                  <i class="fa fa-bars"></i> Salary Info:
                  <span style="color: green" v-if = "form_data.emp_info">{{
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
                <div
                  class="row"
                  v-if="profile_open == 1"
                  style="margin: 10px 5px 10px -5px"
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
                            <td style="font-weight: bold; width: 10%">Name</td>
                            <td style="font-weight: bold">:</td>
                            <td
                              style="
                                width: 55%;
                                padding-left: 0px;
                                padding-right: 0px;
                              "
                            >
                              {{
                                form_data.user_employee_data.employee_fullname
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
                              {{ form_data.user_employee_data.employee_id_no }}
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
                                form_data.user_employee_data.designation_name
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
                              {{ form_data.user_employee_data.employee_mobile }}
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
                              {{ form_data.user_employee_data.department_name }}
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
                                form_data.user_employee_data.work_location_name
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
                      <span v-if="form_data.user_employee_data">
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
                            form_data.user_employee_data !== ''
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
                <div class="container">
                  <table
                    id="employeeTable"
                    class="table table-bordered table-striped salaryTable"
                  >
                    <thead>
                      <tr>
                        <th
                          colspan="10"
                          style="color: green; text-align: right"
                        >
                          Total Salary : {{ form_data.totalSalary }}
                        </th>
                      </tr>
                      <tr>
                        <th rowspan="2" class="text-center">Salary On</th>
                        <!-- <th rowspan="2" class="text-center">Salary Type </th> -->
                        <th rowspan="2" class="text-center">Entry</th>
                        <th rowspan="2" class="text-center">Confirm. Date</th>
                        <th rowspan="2" class="text-center">Gross</th>
                        <th colspan="2" class="text-center">Allowance</th>
                        <th rowspan="2" class="text-center">PF</th>
                        <!--                             <th class="text-center">Medical </th> -->
                        <!-- <th class="text-center">Overtime </th> -->
                        <th rowspan="2" class="text-center">Total</th>
                      </tr>
                      <tr>
                        <th class="text-center">Car</th>
                        <th class="text-center">others</th>
                      </tr>
                    </thead>
                    <tbody v-if="form_data.emp_salary && Object.keys(form_data.emp_salary).length > 0">
                      <tr
                        v-for="(form_data, index) in form_data.emp_salary"
                        v-bind:key="form_data.id"
                        i="index"
                      >
                        <td class="text-center">
                          <span
                            v-if="form_data.salary_goes_to == 1"
                            style="color: green"
                            >Cash</span
                          >
                          <span
                            v-if="form_data.salary_goes_to == 2"
                            style="color: green"
                            >Bank</span
                          >
                        </td>
                        <!-- <td class="text-center">
                               <span v-if="form_data.type==1" style="color:green;">Salary</span>
                                <span v-if="form_data.type==2" style="color:green;">Increment</span>
                            </td> -->
                        <td class="text-center">{{ form_data.entry_date }}</td>
                        <td class="text-center">
                          {{ form_data.confirmation_date }}
                        </td>
                        <td class="text-right">
                          {{ form_data.gross_salary | number("0,0") }}
                        </td>
                        <td class="text-right">
                          {{ form_data.car_allowance_amount | number("0,0") }}
                        </td>
                        <td class="text-right">
                          {{ form_data.others_allowance | number("0,0") }}
                        </td>
                        <td class="text-right">
                          {{ form_data.pf | number("0,0") }}
                        </td>
                        <!-- <td class="text-right">{{form_data.overtime_work_compensation}}</td> -->
                        <td class="text-right">
                          {{
                            (form_data.gross_salary +
                              form_data.car_allowance_amount +
                              form_data.others_allowance)
                              | number("0,0")
                          }}
                        </td>
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

        <modal
          class=""
          name="EmpmyModal"
          height="auto"
          :clickToClose="false"
          width="800"
        >
          <div v-if="modal_loading">
            <!-- Salary Details -->
            <span v-if="type == 1">
              <div class="widget-header modal-header">
                <h4><i class="fa fa-bars"></i> Salary add/edit</h4>
                <button
                  type="button"
                  @click="emphideModal"
                  class="close close-modify"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modify-wraper modal-body" style="margin-top: -10px">
                <div class="container">
                  <form
                    @submit.prevent="add({ add: 'store_or_update/salary' })"
                    class="form-horizontal row-border"
                    id="validate-1"
                  >
                    <br />
                    <div class="row">
                      <div class="col-md-12">
                        <div
                          class="form-group"
                          v-if="!form_data.id"
                          style="display: none"
                        >
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
                              <!-- <vue-select
                                v-model="employee_name_value"
                                :options="option_data.employee_data"
                                @select="onSelectEmployeeSearch"
                                placeholder="Select one"
                                label="text"
                                track-by="text"
                              ></vue-select> -->
                              <input
                                type="text"
                                class="form-control"
                                placeholder="Employee"
                                v-model="form_data.employee_id"
                              />
                            </div>
                          </div>
                        </div>
                        <div
                          class="row"
                          v-if="profile_open == 1"
                          style="margin-bottom: 10px; margin-right: -1.5px"
                        >
                          <!-- {{ this.modal_loading== false ? 'Loading...' : '' }} -->
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
                                      <!-- {{ form_data.company_sbu_id }} -->
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
                            </div>
                            <div
                              class="col-md-2 float-left"
                              style="padding: 0px; text-align: right !important"
                            >
                              <span
                                v-if="
                                  form_data.user_employee_data
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
                                    form_data.user_employee_data !== ''
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
                        <p style="color: red">{{ this.errors_mes }}</p>
                        <label for="bank">
                          <input
                            v-model="click_bank"
                            type="checkbox"
                            id="bank"
                            name="bank"
                          />
                          <span>Bank</span>
                        </label>
                        <label for="cash">
                          <input
                            v-model="click_cash"
                            type="checkbox"
                            id="cash"
                            name="cash"
                          />
                          <span>Cash</span>
                        </label>

                        <div
                          v-if="click_bank"
                          class="row"
                          style="
                            margin-bottom: 2px;
                            margin-right: -1.5px;
                            margin-top: 0px;
                            margin-left: 0.9px;
                            border: 1px solid rgb(207, 207, 207);
                          "
                        >
                          <div class="col-md-12" style="padding: 0px">
                            <div class="col-md-12">
                              <div class="form-group">
                                <strong> Bank info</strong>
                              </div>
                            </div>
                            <div class="col-md-4 float-left">
                              <div class="form-group">
                                <label class="col-md-6 control-label"
                                  >Company/SBU
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
                                      v-model="company_sbu_value"
                                      :options="option_data.company_sbu_data"
                                      @select="onSelectEsbuData"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-3 float-left">
                              <div class="form-group">
                                <label class="col-md-12 control-label"
                                  >Bank A/C
                                  <sup style="color: red; top: -2px"
                                    >*</sup
                                  ></label
                                >
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i class="glyphicon glyphicon-home"></i
                                    ></span>
                                    <input v-if = "form_data.user_employee_data"
                                      v-model="
                                        form_data.user_employee_data
                                          .ebc_account_number
                                      "
                                      @keyup="status_active_inactive($event)"
                                      name="department_name"
                                      placeholder=""
                                      class="form-control"
                                      type="text"
                                    />
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2 float-left">
                              <div class="form-group">
                                <div class="form-group">
                                  <label class="col-md-12 control-label"
                                    >Bank-Status</label
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
                                        v-model="form_data.bank_status"
                                        required="true"
                                      >
                                        <option disabled>
                                          --Select--
                                        </option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3 float-left">
                              <div class="form-group">
                                <label>
                                  <span>Gross or Basic</span>
                                </label>
                                <div class="radio-wrapper">
                                  <input
                                    type="radio"
                                    name="select"
                                    id="option-1"
                                    value="1"
                                    checked
                                    v-model="bank_salary_on_gross_basic"
                                  />
                                  <input
                                    type="radio"
                                    value="2"
                                    v-model="bank_salary_on_gross_basic"
                                    name="select"
                                    id="option-2"
                                  />
                                  <label
                                    for="option-1"
                                    class="option option-1"
                                    @click="
                                      change_bank_salary_on_gross_basic(1)
                                    "
                                  >
                                    <div class="dot"></div>
                                    <span>Gross </span>
                                  </label>
                                  <label
                                    for="option-2"
                                    class="option option-2"
                                    @click="
                                      change_bank_salary_on_gross_basic(2)
                                    "
                                  >
                                    <div class="dot"></div>
                                    <span>Basic</span>
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Gross Salary
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
                                    v-model="gross_salary_entry"
                                    name="department_name"
                                    placeholder=""
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Mode of Payment
                                <sup style="color: red; top: -2px"
                                  >*</sup
                                ></label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <select
                                    class="form-control"
                                    v-model="form_data.salary_goes_to"
                                    required="true"
                                  >
                                    <option disabled>
                                      --Select--
                                    </option>
                                    <!-- <option value="1">Cash</option> -->
                                    <option value="2" selected>Bank</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Effective Date
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
                                    v-model="form_data.confirmation_date"
                                    class="form-control"
                                  ></datepicker>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-3"
                            v-if="bank_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Car Allowance</label
                              >
                              <div
                                class="col-md-6 inputGroupContainer float-left"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <select
                                    @click="car_allowance($event)"
                                    class="form-control"
                                    v-model="form_data.car_allowance_status"
                                    required="true"
                                  >
                                    <option disabled>
                                      --Select--
                                    </option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                  </select>
                                </div>
                              </div>
                              <div
                                v-if="
                                  car_allowance_field == 1 ||
                                  form_data.car_allowance_amount
                                "
                                class="col-md-6 inputGroupContainer float-left"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="form_data.car_allowance_amount"
                                    name="department_name"
                                    placeholder=""
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-3"
                            v-if="bank_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Basic Salary</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="basic_salary_entry"
                                    name="department_name"
                                    placeholder=""
                                    readonly="true"
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-3"
                            v-if="bank_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Housing Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="housing_allowance_entry"
                                    name="department_name"
                                    placeholder=""
                                    readonly="true"
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-3"
                            v-if="bank_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Medical Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="medical_allowance_entry"
                                    name="department_name"
                                    placeholder=""
                                    readonly="true"
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-3"
                            v-if="bank_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Conveyance Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="conveyance_allowance_entry"
                                    name="department_name"
                                    placeholder=""
                                    readonly="true"
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-3"
                            v-if="bank_salary_on_gross_basic == 2"
                          >
                            <div
                              class="form-group col-md-12 float-left"
                              style="padding: 0px"
                            >
                              <label class="col-md-12 float-left"
                                >Provident Fund
                                <!-- <input v-model="form_data.provident_fund"  @change="ProvidentFund($event)" type="checkbox" value="1" style="margin-left: 29px;">   -->
                              </label>
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="provident_fund_amount_entry"
                                    class="form-control"
                                    readonly="true"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div
                            class="col-md-3"
                            v-if="bank_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Others Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="form_data.others_allowance"
                                    name="department_name"
                                    placeholder=""
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-3"
                            v-if="bank_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Phone Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="form_data.phone_allowance"
                                    name="department_name"
                                    placeholder=""
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div
                            class="col-md-3"
                            v-if="bank_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12"
                                >Gratuity Fund
                                <input
                                  v-model="form_data.gratuity_fund"
                                  type="checkbox"
                                  value="1"
                                  style="margin-left: 29px"
                                />
                              </label>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group" v-if="form_data.bank_id">
                              <label class="col-md-6 control-label"
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
                                    v-model="form_data.salary_status"
                                    required="true"
                                  >
                                    <option disabled>
                                      --Select--
                                    </option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          v-if="click_cash"
                          class="row"
                          style="
                            margin-bottom: 2px;
                            margin-right: -1.5px;
                            margin-top: 0px;
                            margin-left: 0.9px;
                            border: 1px solid rgb(207, 207, 207);
                          "
                        >
                          <div class="col-md-12" style="padding: 0px">
                            <div class="col-md-12">
                              <div class="form-group">
                                <strong> Cash info</strong>
                              </div>
                            </div>
                            <div class="col-md-6 float-left">
                              <div class="form-group">
                                <label class="col-md-6 control-label"
                                  >Company/SBU
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
                                      v-model="cash_company_sbu_value"
                                      :options="option_data.company_sbu_data"
                                      @select="cash_onSelectEsbuData"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3 float-left">
                              <div class="form-group">
                                <label>
                                  <span>Gross or Basic</span>
                                </label>
                                <div class="radio-wrapper">
                                  <input
                                    type="radio"
                                    name="cash_select"
                                    id="cash-option-1"
                                    value="1"
                                    checked
                                    v-model="cash_salary_on_gross_basic"
                                  />
                                  <input
                                    type="radio"
                                    value="2"
                                    v-model="cash_salary_on_gross_basic"
                                    name="cash_select"
                                    id="cash-option-2"
                                  />
                                  <label
                                    for="cash-option-1"
                                    class="option cash-option-1"
                                    @click="
                                      change_cash_salary_on_gross_basic(1)
                                    "
                                  >
                                    <div class="dot"></div>
                                    <span>Gross </span>
                                  </label>
                                  <label
                                    for="cash-option-2"
                                    class="option cash-option-2"
                                    @click="
                                      change_cash_salary_on_gross_basic(2)
                                    "
                                  >
                                    <div class="dot"></div>
                                    <span>Basic</span>
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Gross Salary
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
                                    v-model="cash_gross_salary_entry"
                                    name="department_name"
                                    placeholder=""
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Mode of Payment
                                <sup style="color: red; top: -2px"
                                  >*</sup
                                ></label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <select
                                    class="form-control"
                                    v-model="form_data.cash_salary_goes_to"
                                    required="true"
                                  >
                                    <option disabled>
                                      --Select--
                                    </option>
                                    <!-- <option value="1">Cash</option> -->
                                    <option value="1" selected>Cash</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Effective Date
                                <sup style="color: red; top: -2px"
                                  >*</sup
                                ></label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <!-- <datepicker
                                    placeholder="Select Date"
                                    style="width: 131% !important"
                                    v-model="form_data.cash_confirmation_date"
                                    class="form-control"
                                  ></datepicker> -->
                                  <!-- {{form_data.cash_confirmation_date}} -->
                                  <datepicker
                                    placeholder="Select Date"
                                    style="width: 131% !important"
                                    v-model="form_data.confirmation_date"
                                    class="form-control"
                                  ></datepicker>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-3"
                            v-if="cash_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Car Allowance</label
                              >
                              <div
                                class="col-md-6 inputGroupContainer float-left"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <select
                                    @click="cash_car_allowance($event)"
                                    class="form-control"
                                    v-model="
                                      form_data.cash_car_allowance_status
                                    "
                                    required="true"
                                  >
                                    <option disabled>
                                      --Select--
                                    </option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                  </select>
                                </div>
                              </div>
                              <div
                                v-if="
                                  car_allowance_field == 1 ||
                                  form_data.car_allowance_amount
                                "
                                class="col-md-6 inputGroupContainer float-left"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="
                                      form_data.cash_car_allowance_amount
                                    "
                                    name="department_name"
                                    placeholder=""
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-3"
                            v-if="cash_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Basic Salary</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="cash_basic_salary_entry"
                                    name="department_name"
                                    placeholder=""
                                    readonly="true"
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-3"
                            v-if="cash_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Housing Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="cash_housing_allowance_entry"
                                    name="department_name"
                                    placeholder=""
                                    readonly="true"
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-3"
                            v-if="cash_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Medical Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="cash_medical_allowance_entry"
                                    name="department_name"
                                    placeholder=""
                                    readonly="true"
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-3"
                            v-if="cash_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Conveyance Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="cash_conveyance_allowance_entry"
                                    name="department_name"
                                    placeholder=""
                                    readonly="true"
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-3"
                            v-if="cash_salary_on_gross_basic == 2"
                          >
                            <div
                              class="form-group col-md-12 float-left"
                              style="padding: 0px"
                            >
                              <label class="col-md-12 float-left"
                                >Provident Fund
                                <!-- <input v-model="form_data.provident_fund"  @change="ProvidentFund($event)" type="checkbox" value="1" style="margin-left: 29px;">   -->
                              </label>
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="cash_provident_fund_amount_entry"
                                    class="form-control"
                                    readonly="true"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div
                            class="col-md-3"
                            v-if="cash_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Others Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="form_data.cash_others_allowance"
                                    name="department_name"
                                    placeholder=""
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-3"
                            v-if="cash_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12 control-label"
                                >Phone Allowance</label
                              >
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <input
                                    v-model="form_data.cash_phone_allowance"
                                    name="department_name"
                                    placeholder=""
                                    class="form-control"
                                    type="number"
                                    step="0.01"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div
                            class="col-md-3"
                            v-if="cash_salary_on_gross_basic == 2"
                          >
                            <div class="form-group">
                              <label class="col-md-12"
                                >Gratuity Fund
                                <input
                                  v-model="form_data.cash_gratuity_fund"
                                  type="checkbox"
                                  value="1"
                                  style="margin-left: 29px"
                                />
                              </label>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group" v-if="form_data.cash_id">
                              <label class="col-md-6 control-label"
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
                                    v-model="form_data.salary_status"
                                    required="true"
                                  >
                                    <option disabled>
                                      --Select--
                                    </option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
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
                        @click="emphideModal"
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
                  <span style="color: green" v-if = "form_data.emp_info">{{
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
                <div
                  class="row"
                  v-if="profile_open == 1"
                  style="margin: 10px 5px 10px -5px"
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
                            <td style="font-weight: bold; width: 10%">Name</td>
                            <td style="font-weight: bold">:</td>
                            <td
                              style="
                                width: 55%;
                                padding-left: 0px;
                                padding-right: 0px;
                              "
                            >
                              {{
                                form_data.user_employee_data.employee_fullname
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
                              {{ form_data.user_employee_data.employee_id_no }}
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
                                form_data.user_employee_data.designation_name
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
                              {{ form_data.user_employee_data.employee_mobile }}
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
                              {{ form_data.user_employee_data.department_name }}
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
                                form_data.user_employee_data.work_location_name
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
                      <span v-if="form_data.user_employee_data">
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
                            form_data.user_employee_data !== ''
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
                <div class="container">
                  <table
                    id="employeeTable"
                    class="table table-bordered table-striped salaryTable"
                  >
                    <thead>
                      <tr>
                        <th
                          colspan="10"
                          style="color: green; text-align: right"
                        >
                          Total Salary : {{ form_data.totalSalary }}
                        </th>
                      </tr>
                      <tr>
                        <th rowspan="2" class="text-center">Salary On</th>
                        <!-- <th rowspan="2" class="text-center">Salary Type </th> -->
                        <th rowspan="2" class="text-center">Entry</th>
                        <th rowspan="2" class="text-center">Confirm. Date</th>
                        <th rowspan="2" class="text-center">Gross</th>
                        <th colspan="2" class="text-center">Allowance</th>
                        <th rowspan="2" class="text-center">PF</th>
                        <!--                             <th class="text-center">Medical </th> -->
                        <!-- <th class="text-center">Overtime </th> -->
                        <th rowspan="2" class="text-center">Total</th>
                      </tr>
                      <tr>
                        <th class="text-center">Car</th>
                        <th class="text-center">others</th>
                      </tr>
                    </thead>
                    <tbody v-if="form_data.emp_salary && Object.keys(form_data.emp_salary).length > 0">
                      <tr
                        v-for="(form_data, index) in form_data.emp_salary"
                        v-bind:key="form_data.id"
                        i="index"
                      >
                        <td class="text-center">
                          <span
                            v-if="form_data.salary_goes_to == 1"
                            style="color: green"
                            >Cash</span
                          >
                          <span
                            v-if="form_data.salary_goes_to == 2"
                            style="color: green"
                            >Bank</span
                          >
                        </td>
                        <!-- <td class="text-center">
                               <span v-if="form_data.type==1" style="color:green;">Salary</span>
                                <span v-if="form_data.type==2" style="color:green;">Increment</span>
                            </td> -->
                        <td class="text-center">{{ form_data.entry_date }}</td>
                        <td class="text-center">
                          {{ form_data.confirmation_date }}
                        </td>
                        <td class="text-right">
                          {{ form_data.gross_salary | number("0,0") }}
                        </td>
                        <td class="text-right">
                          {{ form_data.car_allowance_amount | number("0,0") }}
                        </td>
                        <td class="text-right">
                          {{ form_data.others_allowance | number("0,0") }}
                        </td>
                        <td class="text-right">
                          {{ form_data.pf | number("0,0") }}
                        </td>
                        <!-- <td class="text-right">{{form_data.overtime_work_compensation}}</td> -->
                        <td class="text-right">
                          {{
                            (form_data.gross_salary +
                              form_data.car_allowance_amount +
                              form_data.others_allowance)
                              | number("0,0")
                          }}
                        </td>
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
<style>
.radio-wrapper {
  box-sizing: border-box;
  display: inline-flex;
  height: auto;
  width: auto;
  align-items: center;
  border-radius: 5px;
  padding: 5px 5px;
  box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.2);
}
.radio-wrapper .option {
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 5px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 5px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.radio-wrapper .option .dot {
  height: 10px;
  width: 10px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.radio-wrapper .option .dot::before {
  position: absolute;
  content: "";
  top: 3px;
  left: 3px;
  width: 4px;
  height: 4px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.radio-wrapper input[type="radio"] {
  display: none;
}
#option-1:checked:checked ~ .option-1,
#option-2:checked:checked ~ .option-2 {
  border-color: #0069d9;
  background: #0069d9;
}
#option-1:checked:checked ~ .option-1 .dot,
#option-2:checked:checked ~ .option-2 .dot {
  background: #fff;
}
#option-1:checked:checked ~ .option-1 .dot::before,
#option-2:checked:checked ~ .option-2 .dot::before {
  opacity: 1;
  transform: scale(1);
}
#cash-option-1:checked:checked ~ .cash-option-1,
#cash-option-2:checked:checked ~ .cash-option-2 {
  border-color: #0069d9;
  background: #0069d9;
}
#cash-option-1:checked:checked ~ .cash-option-1 .dot,
#cash-option-2:checked:checked ~ .cash-option-2 .dot {
  background: #fff;
}
#cash-option-1:checked:checked ~ .cash-option-1 .dot::before,
#cash-option-2:checked:checked ~ .cash-option-2 .dot::before {
  opacity: 1;
  transform: scale(1);
}
.radio-wrapper .option span {
  /* font-size: 20px; */
  color: #808080;
}
#option-1:checked:checked ~ .option-1 span,
#option-2:checked:checked ~ .option-2 span {
  color: #fff;
}

#cash-option-1:checked:checked ~ .cash-option-1 span,
#cash-option-2:checked:checked ~ .cash-option-2 span {
  color: #fff;
}
</style>
<script>
import Loading from "../Loading.vue";
import Datepicker from "vuejs-datepicker";
export default {
  data() {
    return {
      bank_salary_on_gross_basic: 2,
      cash_salary_on_gross_basic: 2,
      url: "",
      employee_work_location: "",
      employee_department: "",
      employee_designation: "",
      employee_sbu: "",
      sbu_name_value: "",
      employeeSbuData: "",
      work_location_value: "",
      department_name_value: "",
      work_location_value: "",
      designation_name_value: "",
      info_data: [],
      paginate_data_2nd: [],
      type: 0,
      click_cash: false,
      click_bank: true,
      errors_mes: "",
      employee_name_value: "",
      gross_salary_entry: "",
      provident_fund_amount_entry: "",
      basic_salary_entry: "",
      housing_allowance_entry: "",
      medical_allowance_entry: "",
      conveyance_allowance_entry: "",
      overtime_work_compensation_entry: "",
      profile_open: "",
      car_allowance_field: "",
      others_allowance_entry: "",
      provident_fund: 1,
      company_sbu_value: "",

      cash_employee_name_value: "",
      cash_gross_salary_entry: "",
      cash_provident_fund_amount_entry: "",
      cash_basic_salary_entry: "",
      cash_housing_allowance_entry: "",
      cash_medical_allowance_entry: "",
      cash_conveyance_allowance_entry: "",
      cash_overtime_work_compensation_entry: "",
      cash_profile_open: "",
      cash_car_allowance_field: "",
      cash_others_allowance_entry: "",
      cash_provident_fund: 1,
      cash_company_sbu_value: "",
      getContext: "",
    };
  },

  created() {
    this.getResults(1);
    this.viewReportsssaz(1);
  },
  components: {
    pageLoading: Loading,
  },
  watch: {
    click_cash(val) {
      if (val) {
        this.click_cash = true;
        this.form_data.click_cash = true;
      } else {
        this.click_cash = false;
        this.form_data.click_cash = false;
      }
    },
    click_bank(val) {
      if (val) {
        this.click_bank = true;
        this.form_data.click_bank = true;
      } else {
        this.click_bank = false;
        this.form_data.click_bank = false;
      }
    },
    gross_salary_entry: function (val) {
      // alert('sss');
      console.log(this.form_data.salary_setting);
      if (!this.form_data.salary_setting) {
        console.log("salary_setting");
        this.errors_mes = "Please Setting Employee Company Salary";
      } else {
        this.errors_mes = "";
      }
      this.form_data.gross_salary = val;
      this.basic_salary_entry = (
        this.form_data.gross_salary *
        (this.form_data.salary_setting.basic_salary / 100)
      ).toFixed(2);
      this.form_data.basic_salary = this.basic_salary_entry;

      this.provident_fund_amount_entry = (
        this.form_data.basic_salary *
        (this.form_data.salary_setting.provident_fund / 100)
      ).toFixed(2);
      this.form_data.provident_fund_amount = this.provident_fund_amount_entry;

      this.housing_allowance_entry = (
        this.form_data.gross_salary *
        (this.form_data.salary_setting.housing_allowance / 100)
      ).toFixed(2);
      this.form_data.housing_allowance = this.housing_allowance_entry;

      this.medical_allowance_entry = (
        this.form_data.gross_salary *
        (this.form_data.salary_setting.medical_allowance / 100)
      ).toFixed(2);
      this.form_data.medical_allowance = this.medical_allowance_entry;

      this.conveyance_allowance_entry = (
        this.form_data.gross_salary *
        (this.form_data.salary_setting.conveyance_allowance / 100)
      ).toFixed(2);
      this.form_data.conveyance_allowance = this.conveyance_allowance_entry;

      this.overtime_work_compensation_entry = (
        this.form_data.gross_salary *
        (this.form_data.salary_setting.overtime_work_compensation / 100)
      ).toFixed(2);
      this.form_data.overtime_work_compensation =
        this.overtime_work_compensation_entry;
    },
    basic_salary_entry: function (val) {
      this.form_data.basic_salary = val;
    },
    employee_id: function (val) {
      this.form_data.employee_id = val;
    },
    provident_fund_amount_entry: function (val) {
      this.form_data.provident_fund_amount = val;
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
    cash_gross_salary_entry: function (val) {
      // alert(val);
      console.log(this.form_data.salary_setting);
      if (!this.form_data.salary_setting) {
        console.log("salary_setting");
        this.errors_mes = "Please Setting Employee Company Salary";
      } else {
        this.errors_mes = "";
      }
      this.form_data.cash_gross_salary = val;
      this.cash_basic_salary_entry = (
        this.form_data.cash_gross_salary *
        (this.form_data.salary_setting.basic_salary / 100)
      ).toFixed(2);
      this.form_data.cash_basic_salary = this.cash_basic_salary_entry;

      this.cash_provident_fund_amount_entry = (
        this.form_data.cash_basic_salary *
        (this.form_data.salary_setting.provident_fund / 100)
      ).toFixed(2);
      this.form_data.cash_provident_fund_amount =
        this.cash_provident_fund_amount_entry;

      this.cash_housing_allowance_entry = (
        this.form_data.cash_gross_salary *
        (this.form_data.salary_setting.housing_allowance / 100)
      ).toFixed(2);
      this.form_data.cash_housing_allowance = this.cash_housing_allowance_entry;

      this.cash_medical_allowance_entry = (
        this.form_data.cash_gross_salary *
        (this.form_data.salary_setting.medical_allowance / 100)
      ).toFixed(2);
      this.form_data.cash_medical_allowance = this.cash_medical_allowance_entry;

      this.cash_conveyance_allowance_entry = (
        this.form_data.cash_gross_salary *
        (this.form_data.salary_setting.conveyance_allowance / 100)
      ).toFixed(2);
      this.form_data.cash_conveyance_allowance =
        this.cash_conveyance_allowance_entry;

      this.cash_overtime_work_compensation_entry = (
        this.form_data.cash_gross_salary *
        (this.form_data.salary_setting.overtime_work_compensation / 100)
      ).toFixed(2);
      this.form_data.cash_overtime_work_compensation =
        this.cash_overtime_work_compensation_entry;
    },
    basic_salary_entry: function (val) {
      this.form_data.cash_basic_salary = val;
    },
    cash_provident_fund_amount_entry: function (val) {
      this.form_data.cash_provident_fund_amount = val;
    },
    cash_housing_allowance_entry: function (val) {
      this.form_data.cash_housing_allowance = val;
    },
    cash_medical_allowance_entry: function (val) {
      this.form_data.cash_medical_allowance = val;
    },
    cash_conveyance_allowance_entry: function (val) {
      this.form_data.cash_conveyance_allowance = val;
    },
    cash_overtime_work_compensation_entry: function (val) {
      this.form_data.cash_overtime_work_compensation = val;
    },
  },
  methods: {
    status_active_inactive: function (val) {
      // console.log(val);
       console.log( this.form_data.bank_status);
      if(val.target.value == ''){
      this.form_data.bank_status = 0;
      }else{
        this.form_data.bank_status = 1;
      }
      this.bank_status();
      console.log(this.form_data.bank_status, val.target.value);

    },
    bank_status(){
      this.form_data.bank_status=this.form_data.bank_status;
    },
    change_cash_salary_on_gross_basic(val) {
      this.form_data.cash_gross_basic = val;
    },
    change_bank_salary_on_gross_basic(val) {
      this.form_data.bank_gross_basic = val;
    },
    viewReportsssaz(page, page_ref_id = false) {
      // alert("sfd");
      this.modal_loading = false;
      if (page_ref_id) {
        page_ref_id = page_ref_id;
      } else if (this.$route.params.jobId) {
        page_ref_id = this.$route.params.jobId;
      } else {
        page_ref_id = "";
      }

      if (typeof page === "undefined") {
        page = 1;
      }

      // var obj_params = {
      //   paginate_num: this.paginate_num,
      //   page: page,
      //   sort: this.sort,
      //   order: this.order,
      //   page_ref_id: page_ref_id,
      // };
      // var data_params = Object.assign(this.search_input, obj_params);
      var fetchUrl = this.$route.meta.fetchUrl;
      this.current_page_no = page;
      var urla = URL.baseUrl("salary/list");
      console.log(urla);
      var data = {
        designation_name_value: this.employee_designation,
        department_name_value: this.employee_department,
        work_location_value: this.employee_work_location,
        sbu_name_value: this.employee_sbu,
        paginate_num: this.paginate_num,
        page: page,
        sort: this.sort,
        order: this.order,
        page_ref_id: page_ref_id,
      };
      axios
        .get(urla, {
          params: data,
        })
        .then((res) => {
          if (res.data.status == "logout") {
            window.location.href = res.data.url;
          } else {
            console.log(res.data.paginate_data_2nd);
            this.lists = res.data;
            // this.pos_status = res.data.pos_status;
            this.form_data = res.data;
            this.paginate_data = res.data.paginate_data;
            this.paginate_data1 = res.data.paginate_data1;
            // this.permission = res.data.permission;

            this.paginate_data_2nd = res.data.paginate_data_2nd;
            // this.transfer = res.data.transfer;
            // this.company = res.data.company;
            // this.vendors = res.data.vendors;
            // this.stores = res.data.stores;
            // this.category_data = res.data.category_data;
            // this.all_voucher_lists = res.data.all_voucher_lists;
            // this.catagory_products = res.data;
            // this.temporary_pric = res.data.temporary_pric;
            // this.temporary_cart = res.data.temporary_cart;

            this.cards = res.data.cards;

            this.option_data = res.data;

            // if (res.data.pos_status == 0) {
            //   this.showModal();
            // }

            if (res.data.formData) {
              this.form_data = res.data.formData;
              //this.option_data = res.data.formData;
            }
            if (res.data.search_input) {
              this.search_input = res.data.search_input;
            }
            this.pagetitle = res.data.pagetitle;
          }
          if (page > 1) {
            this.order_no = this.paginate_num * (page - 1);
          } else {
            this.order_no = 0;
          }
          this.page_loading = true;
          this.modal_loading = true;
        })

        .catch((error) => {
          console.log(error);
          this.showToster({ status: 0, message: "opps! something went wrong" });
          this.page_loading = true;
        });
    },
    employeesWorkLocation(option) {
      console.log(option);
      this.employee_work_location = option.id;
      console.log(this.employee_work_location);
    },
    onSelectDepartment(option) {
      console.log(option);
      this.employee_department = option.id;
      console.log(this.employee_department);
    },
    onSelectDesignation(option) {
      console.log(option);
      this.employee_designation = option.id;
      console.log(this.employee_designation);
    },
    employeesSbu(option) {
      console.log(option);
      this.employee_sbu = option.id;
    },
    // emphideModal() {
    //   this.$modal.hide("EmpmyModal");
    //   this.userresetModal();
    // },
    //  onSelectEmployee(option){
    //    console.log(option);
    //    this.form_data.employee_id= option.id;
    //    this.form_data.company_sbu_id=option.employee_sbu;
    //    console.log(this.form_data.employee_id);
    //  },

    onSelectEsbuData(option) {
      this.form_data.salary_sbu_id = option.id;
    },
    cash_onSelectEsbuData(option) {
      this.form_data.cash_salary_sbu_id = option.id;
    },
    onSelectEmployeeSearch(option) {
      this.resetModal();
      this.profile_open = 1;
      this.getModalDataOther(option.id);
      this.form_data.employee_id = option.id;
      this.form_data.employee_id = this.form_data.employee_id;
      this.form_data.company_sbu_id =
        this.form_data.user_employee_data.employee_sbu;
      // let allData =this.form_data.user_employee_data_all[option.id];
      // this.form_data.employee_id= allData['id'];
    },
    cash_onSelectEmployeeSearch(option) {
      this.resetModal();
      this.profile_open = 1;
      this.getModalDataOther(option.id);
      this.form_data.employee_id = option.id;
      this.form_data.employee_id = this.form_data.employee_id;
      this.form_data.cash_company_sbu_id =
        this.form_data.user_employee_data.employee_sbu;
      // let allData =this.form_data.user_employee_data_all[option.id];
      // this.form_data.employee_id= allData['id'];
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
          this.form_data.gratuity_fund = 1;
          this.form_data.salary_goes_to = 2;
          this.errors = null;
          this.modal_loading = true;
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
        this.form_data.car_allowance_amount =
          this.form_data.car_allowance_amount;
      } else {
        this.car_allowance_field = 2;
        this.form_data.car_allowance_amount = 0;
      }
      console.log(this.car_allowance_field);
    },
    cash_car_allowance(e) {
      var val = e.target.value;
      // console.log(e.target.value);
      if (val == 1) {
        this.car_allowance_field = 1;
        this.form_data.cash_car_allowance_amount =
          this.form_data.cash_car_allowance_amount;
      } else {
        this.car_allowance_field = 2;
        this.form_data.cash_car_allowance_amount = 0;
      }
      console.log(this.car_allowance_field);
    },

    setModalData() {
      this.profile_open = 1;
      this.employee_name_value = this.form_data.employee_name_value;
      this.gross_salary_entry = this.form_data.gross_salary;
      this.basic_salary_entry = this.form_data.basic_salary;
      this.housing_allowance_entry = this.form_data.housing_allowance;
      this.medical_allowance_entry = this.form_data.medical_allowance;
      this.conveyance_allowance_entry = this.form_data.conveyance_allowance;
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
      this.form_data.gratuity_fund = 1;
      this.car_allowance_field = "";
      this.others_allowance_entry = "";
      this.provident_fund_amount_entry = "";
    },
    usersetModalData() {
      this.bank_salary_on_gross_basic = 2;
      this.cash_salary_on_gross_basic = 2;
      this.errors_mes = "";
      this.profile_open = 1;
      this.form_data.salary_sbu_id = this.form_data.salary_sbu_id;

      this.company_sbu_value = this.form_data.company_sbu_value;

      this.form_data.company_sbu_id =
        this.form_data.user_employee_data.employee_sbu;
      this.form_data.cash_id = this.form_data.cash_id;
      this.form_data.bank_id = this.form_data.bank_id;
      this.form_data.employee_id = this.form_data.user_employee_data.id;
      this.employee_name_value = this.form_data.user_employee_data.id;
      // this.employee_name_value = this.$route.params.id;
      this.gross_salary_entry = this.form_data.gross_salary;
      this.basic_salary_entry = this.form_data.basic_salary;
      this.housing_allowance_entry = this.form_data.housing_allowance;
      this.medical_allowance_entry = this.form_data.medical_allowance;
      this.conveyance_allowance_entry = this.form_data.conveyance_allowance;
      this.overtime_work_compensation_entry =
        this.form_data.overtime_work_compensation;
      this.form_data.car_allowance_status = 2;
      this.form_data.provident_fund = 1;
      this.form_data.gratuity_fund = 1;
      this.form_data.others_allowance = 0;
      ////////////////////////

      this.cash_company_sbu_value = this.form_data.cash_company_sbu_value;
      this.form_data.cash_others_allowance = 0;
      this.form_data.cash_salary_sbu_id = this.form_data.cash_salary_sbu_id;
      this.form_data.cash_car_allowance_status = 2;
      this.form_data.cash_provident_fund = 1;
      this.form_data.cash_gratuity_fund = 1;
      this.cash_gross_salary_entry = this.form_data.cash_gross_salary;
      this.cash_basic_salary_entry = this.form_data.cash_basic_salary;
      this.cash_housing_allowance_entry = this.form_data.cash_housing_allowance;
      this.cash_medical_allowance_entry = this.form_data.cash_medical_allowance;
      this.cash_conveyance_allowance_entry =
        this.form_data.cash_conveyance_allowance;
      this.cash_overtime_work_compensation_entry =
        this.form_data.cash_overtime_work_compensation;
      this.form_data.click_bank = true;
    },
    userresetModal() {
      this.company_sbu_value = { id: "", text: "" };
      this.form_data.others_allowance = 0;
      this.form_data.salary_sbu_id = "";
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
      this.form_data.gratuity_fund = 1;
      this.car_allowance_field = "";
      this.others_allowance_entry = "";
      this.provident_fund_amount_entry = 0;

      this.cash_company_sbu_value = { id: "", text: "" };
      this.form_data.cash_others_allowance = 0;
      this.form_data.cash_salary_sbu_id = "";
      this.cash_gross_salary_entry = "";
      this.cash_basic_salary_entry = "";
      this.cash_housing_allowance_entry = "";
      this.cash_medical_allowance_entry = "";
      this.cash_conveyance_allowance_entry = "";
      this.cash_overtime_work_compensation_entry = "";
      this.cash_employee_name_value = "";
      this.cash_profile_open = "";
      this.form_data.cash_car_allowance_status = 2;
      this.form_data.cash_provident_fund = 1;
      this.form_data.cash_gratuity_fund = 1;
      this.cash_car_allowance_field = "";
      this.cash_others_allowance_entry = "";
      this.cash_provident_fund_amount_entry = 0;
      this.click_cash = false;
      this.form_data.click_cash = false;
      this.type = 0;
    },
  },
};
</script>
<style type="text/css">
.salaryTable.table td {
  padding: 5px 5px !important;
}
.table thead th {
  vertical-align: middle;
  border-bottom: 2px solid #dee2e6;
}
#salary_tab .salary_tab {
  color: #495057;
  padding: 15px 30px !important;
  font-weight: bold !important;
  padding-left: 30px !important;
}
#salary_tab .salary_tab.active {
  color: #495057;
  padding: 15px 30px !important;
  font-weight: bold !important;
  padding-left: 30px !important;
}
</style>