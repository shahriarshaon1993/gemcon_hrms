<template>
  <div>
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-12 mb-1 mt-0">
            <div class="row breadcrumbs-top">
              <div class="col-12">
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb p-0 mb-0">
                    <li class="breadcrumb-item">
                      <router-link :to="{ path: '/' }"
                        ><i class="bx bx-home-alt"></i>
                      </router-link>
                    </li>
                    <li class="breadcrumb-item active">
                      Settings KRA, KPI and MOS
                    </li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="content-body">
          <transition>
            <section class="input-validation">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">Settings KRA, KPI and MOS</h4>
                    </div>
                    <div class="card-content">
                      <form @submit.prevent="create()">
                        <div class="card-body">
                          <div class="col-md-12" style="padding: 0px">
                            <div class="row report-box">
                              <div class="form-group col-md-3">
                                <label
                                  class="col-md-12 control-label"
                                  style="padding: 0px"
                                  >SBU
                                  <sup style="color: red; top: -2px"
                                    >*</sup
                                  ></label
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
                                      v-model="addForm.sbu_id"
                                      :options="sbuSelect2Aarry"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-md-3">
                                <label
                                  class="col-md-12 control-label"
                                  style="padding: 0px"
                                  >Unit</label
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
                                      v-model="addForm.unit_id"
                                      :options="unitSelect2Aarry"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-md-3">
                                <label
                                  class="col-md-12 control-label"
                                  style="padding: 0px"
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
                                      v-model="addForm.subunit_id"
                                      :options="subUnitSelect2Aarry"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>

                              <div class="form-group col-md-3">
                                <label
                                  class="col-md-12 control-label"
                                  style="padding: 0px"
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
                                      v-model="addForm.department_id"
                                      :options="departmentSelect2Aarry"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-md-3">
                                <label
                                  class="col-md-12 control-label"
                                  style="padding: 0px"
                                  >Section</label
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
                                      v-model="addForm.section_id"
                                      :options="sectionSelect2Aarry"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-md-3">
                                <label
                                  class="col-md-12 control-label"
                                  style="padding: 0px"
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
                                      v-model="addForm.subsection_id"
                                      :options="subSectionSelect2Aarry"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-md-3">
                                <label
                                  class="col-md-12 control-label"
                                  style="padding: 0px"
                                  >Work Loc.</label
                                >
                                <div
                                  class="col-md-12 inputGroupContainer"
                                  style="padding: 0px"
                                >
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i
                                        class="glyphicon glyphicon-envelope"
                                      ></i
                                    ></span>
                                    <vue-select
                                      v-model="addForm.employee_work_location"
                                      :options="workLocationSelect2Aarry"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>

                              <div class="form-group col-md-3">
                                <label
                                  class="col-md-6 control-label"
                                  style="padding: 0px"
                                  >Employee</label
                                >
                                <div
                                  class="col-md-12 inputGroupContainer"
                                  style="padding: 0px"
                                >
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i
                                        class="glyphicon glyphicon-earphone"
                                      ></i
                                    ></span>
                                    <vue-select
                                      v-model="addForm.employee_id"
                                      :options="employeeSelect2Aarry"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <label class="text-gray-600 font-semibold text-lg"
                            >KRA</label
                          >
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <div class="controls">
                                  <input
                                    type="text"
                                    v-model="kar_kpi_mos.name"
                                    class="form-control"
                                    placeholder="Entry KRA"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <div class="controls">
                                  <input
                                    type="number"
                                    @keypress="onlyNumber"
                                    v-model="kar_kpi_mos.kra_weight"
                                    class="form-control"
                                    placeholder="KRA WEIGHTAGE"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <div class="controls">
                                  <button
                                    type="button"
                                    @click="addFieldKPI(kar_kpi_mos.children)"
                                    class="btn btn-primary"
                                  >
                                    Add KPI
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div
                              v-for="(item, index) in kar_kpi_mos.children"
                              :key="`phoneInput-${index}`"
                              class="input wrapper flex items-center label_2"
                            >
                              <label class="text-gray-600 font-semibold text-lg"
                                >KPI {{ index + 1 }}</label
                              >
                              <div class="row">
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <div class="controls">
                                      <input
                                        type="text"
                                        v-model="item.name"
                                        class="form-control"
                                        placeholder="Entry kpi"
                                      />
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <div class="controls">
                                      <input
                                        type="number"
                                        @keypress="onlyNumber"
                                        v-model="item.kpi_weight"
                                        class="form-control"
                                        placeholder="KPI WEIGHTAGE"
                                      />
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <div class="controls">
                                      <button
                                        type="button"
                                        @click="addFieldMOS(item)"
                                        class="btn btn-primary"
                                      >
                                        Add MOS
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div
                                v-for="(row, m) in kar_kpi_mos.children[index]
                                  .children"
                                :key="`phoneInput-${m}`"
                                class="input wrapper flex items-center label_3"
                              >
                                <label
                                  class="text-gray-600 font-semibold text-lg"
                                  >MOS {{ m + 1 }}</label
                                >
                                <div class="row">
                                  <div class="col-md-5">
                                    <div class="form-group">
                                      <div class="controls">
                                        <input
                                          type="text"
                                          v-model="row.name"
                                          class="form-control"
                                          placeholder="Enter MOS Name"
                                        />
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-primary">
                            Submit
                          </button>
                        </div>
                      </form>
                    </div>

                    <!-- COPY KRA KPI MOD AREA --->
                    <!-- <div class="row">
                                            <div class="col-md-4 text-right">
                                                <br>
                                                <h4 class="card-title">COPYING DETAILS KRA, KPI and MOS</h4>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="">From Year</label>
                                                <input type="text" name="" v-model="fromYear" readonly="readonly"
                                                    class="form-control">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="">To Year</label>
                                                <input type="text" name="" v-model="toYear" readonly="readonly"
                                                    class="form-control">
                                            </div>

                                            <div class="col-md-1">
                                                <label for=""></label><br>
                                                <button class="btn btn-success" @click="copyKraKpiMos()">COPY</button>
                                            </div>
                                        </div> -->
                    <br />
                  </div>
                </div>
              </div>
            </section>
          </transition>
        </div>
        <div class="content-body">
          <section id="basic-datatable">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-content">
                    <div class="card-body card-dashboard">
                      <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                          <thead class="thead-dark">
                            <tr>
                              <th>KRA</th>
                              <th>Weightage</th>
                              <th>KPI</th>
                              <th>MOS</th>
                              <th>Jan</th>
                              <th>Feb</th>
                              <th>Mar</th>
                              <th>Apr</th>
                              <th>May</th>
                              <th>Jun</th>
                              <th>Jul</th>
                              <th>Aug</th>
                              <th>Sep</th>
                              <th>Oct</th>
                              <th>Nov</th>
                              <th>Dec</th>
                              <th v-if="role_id == 5 || role_id == 6">
                                Action
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <template v-for="(item, index) in itemsData" :key="item.id"> 
                              <tr>
                                <!-- <td :rowspan="item.kra_count"
                                                                    v-if="itemsData[index > 0 ? index - 1 : 0 ].kra_id != item.kra_id || index ==0">
                                                                    {{ item.krajoin ? item.krajoin.kra_name : '' }}</td>
                                                                <td :rowspan="item.kra_count"
                                                                    v-if="itemsData[index > 0 ? index - 1 : 0 ].kra_id != item.kra_id || index ==0">
                                                                    {{ item.krajoin ? item.krajoin.kra_weight : '' }}
                                                                </td>
                                                                <td :rowspan="item.kpi_count"
                                                                    v-if="itemsData[index > 0 ? index - 1 : 0 ].kpi_id != item.kpi_id || index ==0">
                                                                    {{ item.kpijoin ? item.kpijoin.kpi_name : '' }}</td>
                                                                <td>{{ item.mos_name }}</td> -->

                                <td
                                  :rowspan="rowVisible(index, item, 'kra')"
                                  v-if="
                                    itemsData[index > 0 ? index - 1 : 0]
                                      .kra_id != item.kra_id || index == 0
                                  "
                                >
                                  {{
                                    item.krajoin ? item.krajoin.kra_name : ""
                                  }}
                                </td>
                                <td
                                  :rowspan="rowVisible(index, item, 'kra')"
                                  v-if="
                                    itemsData[index > 0 ? index - 1 : 0]
                                      .kra_id != item.kra_id || index == 0
                                  "
                                >
                                  {{
                                    item.krajoin ? item.krajoin.kra_weight : ""
                                  }}
                                </td>
                                <td
                                  :rowspan="rowVisible(index, item, 'kpi')"
                                  v-if="
                                    itemsData[index > 0 ? index - 1 : 0]
                                      .kpi_id != item.kpi_id || index == 0
                                  "
                                >
                                  {{
                                    item.kpijoin ? item.kpijoin.kpi_name : ""
                                  }}
                                </td>
                                <!-- <td v-if="filterForm.show_mos==1">{{ item.mos_name }}  ({{ Number(moduleTotal(item)).toFixed(2) }}) </td> -->
                                <td>{{ item.mos_name }}</td>

                                <td>
                                  <i
                                    v-if="
                                      item.mostargetjoin
                                        ? item.mostargetjoin.january
                                        : 0 > 0
                                    "
                                    class="bx bx-map"
                                  ></i>
                                </td>
                                <td>
                                  <i
                                    v-if="
                                      item.mostargetjoin
                                        ? item.mostargetjoin.february
                                        : 0 > 0
                                    "
                                    class="bx bx-map"
                                  ></i>
                                </td>
                                <td>
                                  <i
                                    v-if="
                                      item.mostargetjoin
                                        ? item.mostargetjoin.march
                                        : 0 > 0
                                    "
                                    class="bx bx-map"
                                  ></i>
                                </td>
                                <td>
                                  <i
                                    v-if="
                                      item.mostargetjoin
                                        ? item.mostargetjoin.april
                                        : 0 > 0
                                    "
                                    class="bx bx-map"
                                  ></i>
                                </td>
                                <td>
                                  <i
                                    v-if="
                                      item.mostargetjoin
                                        ? item.mostargetjoin.may
                                        : 0 > 0
                                    "
                                    class="bx bx-map"
                                  ></i>
                                </td>
                                <td>
                                  <i
                                    v-if="
                                      item.mostargetjoin
                                        ? item.mostargetjoin.june
                                        : 0 > 0
                                    "
                                    class="bx bx-map"
                                  ></i>
                                </td>
                                <td>
                                  <i
                                    v-if="
                                      item.mostargetjoin
                                        ? item.mostargetjoin.july
                                        : 0 > 0
                                    "
                                    class="bx bx-map"
                                  ></i>
                                </td>
                                <td>
                                  <i
                                    v-if="
                                      item.mostargetjoin
                                        ? item.mostargetjoin.august
                                        : 0 > 0
                                    "
                                    class="bx bx-map"
                                  ></i>
                                </td>
                                <td>
                                  <i
                                    v-if="
                                      item.mostargetjoin
                                        ? item.mostargetjoin.september
                                        : 0 > 0
                                    "
                                    class="bx bx-map"
                                  ></i>
                                </td>
                                <td>
                                  <i
                                    v-if="
                                      item.mostargetjoin
                                        ? item.mostargetjoin.october
                                        : 0 > 0
                                    "
                                    class="bx bx-map"
                                  ></i>
                                </td>
                                <td>
                                  <i
                                    v-if="
                                      item.mostargetjoin
                                        ? item.mostargetjoin.november
                                        : 0 > 0
                                    "
                                    class="bx bx-map"
                                  ></i>
                                </td>
                                <td>
                                  <i
                                    v-if="
                                      item.mostargetjoin
                                        ? item.mostargetjoin.december
                                        : 0 > 0
                                    "
                                    class="bx bx-map"
                                  ></i>
                                </td>
                                <td>
                                  <div class="dropup">
                                    <span
                                      class="
                                        bx bx-dots-vertical-rounded
                                        font-medium-3
                                        dropdown-toggle
                                        nav-hide-arrow
                                        cursor-pointer
                                      "
                                      data-toggle="dropdown"
                                      aria-haspopup="true"
                                      aria-expanded="false"
                                      role="menu"
                                    >
                                    </span>
                                    <div
                                      class="dropdown-menu dropdown-menu-right"
                                    >
                                      <!-- <a class="dropdown-item" @click="add_kpi(item )"><i class="bx bxs-comment-add mr-1"></i> Add || Edit KPI </a>   -->

                                      <a
                                        @click="showassign(item)"
                                        class="dropdown-item"
                                      >
                                        <i class="bx bx-edit-alt mr-1"> </i>
                                        modal
                                      </a>
                                      <router-link
                                        class="dropdown-item"
                                        :to="{
                                          path:
                                            '/measure_of_success/' +
                                            item.kpi_id,
                                        }"
                                      >
                                        <i class="bx bx-edit-alt mr-1"></i> MOS
                                      </router-link>
                                      <router-link
                                        class="dropdown-item"
                                        :to="{
                                          path: '/assessment_qus/' + item.id,
                                        }"
                                      >
                                        <i class="bx bx-edit-alt mr-1"></i> JD
                                        setup
                                      </router-link>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </template>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>

        <!-- ADD NEW MOS -->

        <modal
          width="60%"
          height="70%"
          style="padding: 50px"
          name="user_assaign"
        >
          <i @click="hiddenMos()" class="bx bx-x-circle x-circle"></i>
          <div class="app-content">
            <div class="card">
              <form @submit.prevent="mosassaign()">
                <div class="card-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="text-gray-600 font-semibold text-lg"
                            >Employee
                          </label>
                          <div class="controls">
                            <vue-select
                              v-model="mosAssaign.employee_id"
                              :options="myemployeeSelect2Aarry"
                              :multiple="true"
                              placeholder="Select one"
                              label="text"
                              track-by="text"
                            ></vue-select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <ul>
                          <li
                            :key="index"
                            v-for="(item, index) in getmosassaign_data"
                            style="list-style: decimal; padding: 10px"
                          >
                            <span style="float: left">
                              {{ item.employeedata.employee_number }}
                              {{ item.employeedata.employee_fullname }}
                            </span>
                            <span style="float: right">
                              <a @click="delete_mos_user(item.id)">
                                <i class="bx bx-trash mr-1"> </i>
                              </a>
                            </span>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </modal>
      </div>
    </div>
  </div>
</template>
<script>
import { Form } from "vform";
import axios from "../../axios_instance";
//import VueTree from '@ssthouse/vue-tree-chart';
export default {
  props: {},
  components: {
    //'vue-tree': VueTree
    // VueRecaptcha, facebookLogin
  },
  data() {
    return {
      sbuSelect2Aarry: [],
      unitSelect2Aarry: [],
      subUnitSelect2Aarry: [],
      departmentSelect2Aarry: [],
      sectionSelect2Aarry: [],
      subSectionSelect2Aarry: [],
      workLocationSelect2Aarry: [],
      employeeSelect2Aarry: [],
      myemployeeSelect2Aarry: [],
      deptItems: [],
      itemsData: [],
      getmosassaign_data: [],
      items: [],
      item: [],
      kar_kpi_mos: {
        name: "",
        kra_weight: 0,
        children: [
          {
            name: "",
            kpi_weight: 0,
            children: [{ name: "" }],
          },
        ],
      },
      chart: [],
      base_url: window.base_url,
      api_url: window.api_url,
      token: this.$localStorage.get("d_token"),
      user_data: JSON.parse(this.$localStorage.get("user")).data,
      role_id: "",
      sampleData: [],
      filterForm: new Form({
        dept_id: "",
      }),
      treeConfig: { nodeWidth: 200, nodeHeight: 100, levelHeight: 170 },
      addForm: new Form({
        arrayData: "",
        sbu_id: 0,
        section_id: 0,
        subsection_id: 0,
        unit_id: 0,
        subunit_id: 0,
        employee_work_location: 0,
        department_id: 0,
        employee_id: null,
      }),
      mosAssaign: new Form({
        employee_id: null,
        kra_id: 0,
        kpi_id: 0,
        mos_id: 0,
        year: 0,
      }),

      mos_item: [],
      kpi_item: [],
      kra_item: [],
      year: this.$localStorage.get("year")
        ? this.$localStorage.get("year")
        : new Date().getFullYear(),
      optionFromYearValue: "",
      optionToYearValue: "",
      sbu_id: 0,
      fromYear: new Date().getFullYear(),
      toYear: new Date().getFullYear() + 1,
    };
  },
  created() {
    this.role_id = this.user_data.role_id;
    this.filterForm.dept_id = this.user_data.department;
    this.getItems();
    this.getDept();
    this.getYearWiseKraKpiMosItems();

    this.getSbuSelect2();
    this.getUnitSelect2();
    this.getSubUnitSelect2();
    this.getDeptSelect2();
    this.getSectionSelect2();
    this.getSubSectionSelect2();
    this.getWorkLocationSelect2();
    this.getEmployeeSelect2();
    this.getMyEmployee();
  },
  methods: {
    async delete_mos_user(id) {
      this.$swal({
        title: "Are you sure you want to delete?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          this.deletemos_user(id);
        }
      });
    },
    async deletemos_user(id) {
      await axios
        .delete(this.api_url + "user_m_os/" + id, {
          headers: {
            "Content-Type": "application/json",
            // Authorization: this.token ? `Bearer ${this.token}` : "",
          },
        })
        .then((data) => {
          this.$toasted.show(data.data.message, {
            theme: "bubble",
            duration: 5000,
            position: "bottom-right",
          });
          this.getmosassaign(this.mosAssaign.mos_id);
          console.log(data);
        });
    },
    getmosassaign(id) {
      try {
        axios
          .get(this.api_url + "user_m_os?mos_id=" + id, {
            headers: {
              "Content-Type": "application/json",
            },
          })
          .then(({ data }) => {
            if (data.success) {
              this.getmosassaign_data = data.data;
            }
          });
      } catch (error) {
        console.log(error);
      }
    },
    mosassaign() {
      let loader = this.$loading.show();
      try {
        this.mosAssaign
          .post(this.api_url + "user_m_os", {
            headers: {
              "Content-Type": "application/json",
              // Authorization: this.token ? `Bearer ${this.token}` : "",
            },
          })
          .then((res) => {
            console.log(res);
            if (res.data.success) {
              this.addForm.name = "";
              this.$toasted.show(res.data.message, {
                theme: "bubble",
                duration: 5000,
                position: "bottom-right",
              });
              this.getmosassaign(this.mosAssaign.mos_id);
              this.mosAssaign.employee_id = null;
            }
            loader.hide();
          });
      } catch (error) {
        loader.hide();
        console.log(error);
      }
    },
    getMyEmployee() {
      try {
        axios
          .get(this.api_url + "user_wise_emp", {
            headers: {
              "Content-Type": "application/json",
            },
          })
          .then(({ data }) => {
            console.log(data);
            if (data.success) {
              console.log(data);
              this.myemployeeSelect2Aarry = data.data;
            }
          });
      } catch (error) {
        console.log(error);
      }
    },
    showassign(item) {
      console.log(item);
      this.getmosassaign(item.id);
      this.mosAssaign.kra_id = item.kra_id;
      this.mosAssaign.kpi_id = item.kpi_id;
      this.mosAssaign.mos_id = item.id;
      this.mosAssaign.year = this.year;
      this.$modal.show("user_assaign");
    },
    async getDept() {
      let loader = this.$loading.show();
      this.getDepartments(this.status).then(({ data }) => {
        if (data.success) {
          loader.hide();
          this.deptItems = data.data;
          //this.getItems();
        } else {
          loader.hide();
        }
      });
    },

    onlyNumber($event) {
      //console.log($event.keyCode); //keyCodes value
      let keyCode = $event.keyCode ? $event.keyCode : $event.which;
      if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) {
        // 46 is dot
        $event.preventDefault();
      }
    },

    async hidepopup() {
      this.$modal.hide("user_assaign");
    },

    addFieldKPI(array) {
      array.push({
        children: [{ name: "", kpi_weight: 100 }],
      });
      // this.chart  = this.kar_kpi_mos ;
    },
    addFieldMOS(array) {
      array.children.push({ name: "" });
      console.log(this.kar_kpi_mos);
      // this.chart  = this.kar_kpi_mos ;
    },
    addField(value, fieldType) {
      fieldType.push({ value: "" });
      console.log(this.kar_kpi_mos);
    },
    removeField(index, fieldType) {
      console.log(fieldType);
      fieldType.splice(index, 1);
    },
    async getItems() {
      let where = "";
      // if (this.filterForm.dept_id) {
      //     where += '?dept_id=' + this.filterForm.dept_id;
      // }

      where = "?year=" + (this.year ? this.year : new Date().getFullYear());
      let loader = this.$loading.show();
      try {
        await axios
          .get(this.api_url + "kra_kpi_mos" + where, {
            headers: {
              "Content-Type": "application/json",
              Authorization: this.token ? `Bearer ${this.token}` : "",
            },
          })
          .then(({ data }) => {
            if (data.success) {
              this.items = data.data;
              console.log(this.items);
            }
            loader.hide();
          });
      } catch (error) {
        loader.hide();
      }
    },

    //YEAR WISE KRA KPI MOS DATA
    async getYearWiseKraKpiMosItems() {
      if (this.filterForm.dept_id != "") {
        let where = "";
        if (this.filterForm.dept_id) {
          where += "?dept_id=" + this.filterForm.dept_id;
        }

        //ADD YEAR PARAM
        where = "?year=" + (this.year ? this.year : new Date().getFullYear());

        let loader = this.$loading.show();
        try {
          await axios
            .get(this.api_url + "kra_kpi_mos_list" + where, {
              headers: {
                "Content-Type": "application/json",
                Authorization: this.token ? `Bearer ${this.token}` : "",
              },
            })
            .then(({ data }) => {
              if (data.success) {
                this.itemsData = data.data;
                // console.log( this.yearWiseKraKpiMosItems );
              }
              loader.hide();
            });
        } catch (error) {
          loader.hide();
        }
      }
    },

    //COPY KRA KPI MOS DATA FROM YEAR TO YEAR
    async copyKraKpiMos() {
      let loader = this.$loading.show();

      try {
        await axios
          .get(
            this.api_url +
              "copy_kra_kpi_mos?fromYear=" +
              this.fromYear +
              "&toYear=" +
              this.toYear,
            {
              headers: {
                "Content-Type": "application/json",
                Authorization: this.token ? `Bearer ${this.token}` : "",
              },
            }
          )
          .then(({ data }) => {
            if (data.success) {
              this.$toasted.show(data.message, {
                theme: "bubble",
                duration: 5000,
                position: "bottom-right",
              });

              //GET LATEST YEAR DATA
              this.$localStorage.set("year", "2022"),
                this.getYearWiseKraKpiMosItems();
            } else {
              this.$toasted.show(data.message, {
                theme: "bubble",
                duration: 5000,
                position: "bottom-right",
              });

              //GET LATEST YEAR DATA
              this.$localStorage.set("year", "2021"), this.getItems();
            }

            loader.hide();
          });
      } catch (error) {
        loader.hide();
      }
    },

    rowVisible(index, item, type) {
      let crount = 0;
      this.itemsData.filter((row) => {
        if (type == "kra") {
          if (row.kra_id === item.kra_id) {
            crount += 1;
          }
        } else if (type == "kpi") {
          if (row.kpi_id === item.kpi_id) {
            crount += 1;
          }
        }
      });
      return crount;
    },

    create() {
      let loader = this.$loading.show();
      try {
        console.log(this.kar_kpi_mos);
        this.addForm.arrayData = this.kar_kpi_mos;
        this.addForm.year = this.year;
        this.addForm
          .post(this.api_url + "kra_kpi_setting", {
            headers: {
              "Content-Type": "application/json",
              Authorization: this.token ? `Bearer ${this.token}` : "",
            },
          })
          .then((res) => {
            console.log(res);
            if (res.data.success) {
              this.addForm.name = "";
              this.$toasted.show(res.data.message, {
                theme: "bubble",
                duration: 5000,
                position: "bottom-right",
              });
              this.getItems();
            }
            loader.hide();
          });
      } catch (error) {
        loader.hide();
        console.log(error);
      }
    },

    checkConditionKra(length, kpi_index, mos_index) {
      if (kpi_index == 0 && mos_index == 0) {
        return true;
      } else {
        return false;
      }
    },
    checkConditionKpi(length, mos_index) {
      if (mos_index == 0) {
        return true;
      } else {
        return false;
      }
    },
  },

  computed: {},
};
</script>
<style>
.input.wrapper.flex.items-center.label_2 {
  margin: 0 0 0 100px;
}

.input.wrapper.flex.items-center.label_3 {
  margin: 0 0 0 100px;
}
</style>


<style scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.rich-media-node {
  width: 180px;
  padding: 8px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  color: white;
  background-color: #f7c616;
  border-radius: 4px;
}

.settings ul {
  list-style: none;
  line-height: 33px;
}

.settings ul ul li {
  border-bottom: 1px solid #c1bbbb;
}

.main {
  background: #efefef;
  padding: 14px 11px 17px 16px;
  margin-top: 20px;
  margin-right: 47px;
}
</style>