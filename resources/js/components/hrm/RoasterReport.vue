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
                          Roster Report Search
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
                      <div class="form-group col-md-2" v-if="date_type_id==1" style="padding: 0px">
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
                      <div class="form-group col-md-2" v-if="date_type_id==1" style="padding: 0px">
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
                              multiple="multiple"
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
                              multiple="multiple"
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
                              multiple="multiple"
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
                              multiple="multiple"
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
                              multiple="multiple"
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
                              multiple="multiple"
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
                              multiple="multiple"
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
                        <label class="col-md-6 control-label">Employee</label>
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
                              multiple="multiple"
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
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <div
                      class="col-md-12 float-right"
                      style="padding: 10px 0px"
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
                            <a
                             style="margin-right: 5px; font-size: 14px"
                              @click="roster_maping()"
                              class="btn btn-sm btn-info"
                              href="#"
                            >
                              <i class="fa fa-copy"
                                > Roster Maping next 7 days</i
                              >
                            </a>
                            <button
                              style="margin-right: 5px; font-size: 14px"
                              class="btn btn-xs btn-success"
                              @click="tableToExcel('table', 'Employee Data')"
                            >
                              Export
                            </button>
                            <button
                              @click="printDiv()"
                              style="margin-right: 5px; font-size: 14px"
                              class="btn-info float-right"
                            >
                              Print
                            </button>

                            <div class="dropdown">
                              <button
                                class="btn btn-secondary dropdown-toggle"
                                type="button"
                                id="dropdownMenuButton"
                                data-toggle="dropdown"
                                aria-expanded="false"
                              >
                                Roster Copy
                              </button>
                              <div
                                class="dropdown-menu"
                                aria-labelledby="dropdownMenuButton"
                              >
                                <div v-if="this.weeks_id">
                                  <span
                                    v-for="(
                                      months, index
                                    ) in option_data.months_array"
                                    :key="index"
                                    :value="months.id"
                                  >
                                    <span
                                      v-for="(weeks, index) in weekly_data.week"
                                      :value="weeks.id"
                                      :key="index"
                                    >
                                      <a
                                        @click="copy(months.id, weeks.id)"
                                        class="dropdown-item"
                                        href="#"
                                      >
                                        <i class="fa fa-copy"
                                          >{{ months.text }} -
                                          {{ weeks.text }}</i
                                        >
                                      </a>
                                    </span>
                                  </span>
                                </div>
                                <div v-else>
                                  <a
                                    class="dropdown-item"
                                    href="#"
                                    v-for="(
                                      months, index
                                    ) in option_data.months_array"
                                    :key="index"
                                    :value="months.id"
                                    @click="copy(months.id, 0)"
                                  >
                                    <i class="fa fa-copy">{{ months.text }}</i>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="card-body col-md-12" v-if="page_loading">
                    <div class="row col-md-12" id="printable">
                      <div class="col-md-12">
                        <div
                          class=""
                          style="min-height: 56px"
                          v-for="(
                            formData1, key, index
                          ) in form_data.employee_data_approvaldat"
                          v-bind:key="form_data.id"
                        >
                          <table ref="table" class="table table-bordered">
                            <thead>
                              <tr>
                                <td :colspan="form_data.datesList.length + 6">
                                  <strong
                                    ><h3>{{ key }}</h3></strong
                                  >
                                  <h5>
                                    Employee Duty Roster:
                                    {{ form_data.start_date }} To
                                    {{ form_data.end_date }}
                                  </h5>
                                </td>
                              </tr>
                            </thead>
                          </table>
                          <table
                            ref="table"
                            class="table table-bordered"
                            v-for="(formData, key, index) in formData1"
                            v-bind:key="form_data.id"
                          >
                            <thead>
                              <tr style="border: 1px solid #000">
                                <td
                                  style="border: 1px solid #000"
                                  :colspan="form_data.datesList.length + 6"
                                >
                                  <strong>{{ key }} </strong>
                                </td>
                              </tr>
                            </thead>
                            <thead>
                              <tr>
                                <th style="border: 1px solid #000">Sl.</th>
                                <th style="border: 1px solid #000">Name</th>
                                <th style="border: 1px solid #000">ID</th>
                                <th style="border: 1px solid #000">
                                  Designatoin
                                </th>
                                <th style="border: 1px solid #000">
                                  Department
                                </th>
                                <th style="width: 10%; border: 1px solid #000">
                                  W. Location
                                </th>
                                <th
                                  style="
                                    width: 15%;
                                    border: 1px solid #000;
                                    text-align: center;
                                  "
                                  v-for="(
                                    form_data, index
                                  ) in form_data.datesList"
                                  v-bind:key="form_data.id"
                                  i="index"
                                >
                                  {{ form_data.dates }} <br />
                                  {{ form_data.days }}
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr
                                style="border: 1px solid #000"
                                v-for="(form_data, index) in formData"
                                v-bind:key="form_data.id"
                              >
                                <td style="border: 1px solid #000">
                                  {{ index + 1 }}
                                </td>
                                <td style="border: 1px solid #000">
                                  {{ form_data.employee_fullname }}
                                </td>
                                <td style="border: 1px solid #000">
                                  {{ form_data.employee_id_no }}
                                </td>
                                <td style="border: 1px solid #000">
                                  {{ form_data.designation_name }}
                                </td>
                                <td style="border: 1px solid #000">
                                  {{ form_data.department_name }}
                                </td>
                                <td style="border: 1px solid #000">
                                  {{ form_data.work_locations }}
                                </td>
                                <td
                                  class="select_id"
                                  style="
                                    height: 50px;
                                    border: 1px solid #000;
                                    text-align: center;
                                  "
                                  v-for="(
                                    formData, index
                                  ) in form_data.datesLists"
                                  v-bind:key="formData.id"
                                >
                                  {{ formData.shiftTimeid.text }}
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
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
      date_type_id:2,
      weeks_id: 0,
      weekly_data: "",
      months_id: 0,
      permission_id_name: "",
      employees_list: [],
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
    tableToExcel(table, name) {
      if (!table.nodeType) table = this.$refs.table;
      var ctx = { worksheet: name || "Worksheet", table: table.innerHTML };
      window.location.href =
        this.uri + this.base64(this.format(this.template, ctx));
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
     DateTypeId(event){
            this.date_type_id=event.target.value;
        },
    weekSelect(event) {
      this.weeks_id = event.target.value;
    },
    monthsSelectsId(event) {
      this.months_id = event.target.value;
      console.log(this.weekly_id);
      let uri = URL.baseUrl("shift_week/fiends");
      axios
        .post(uri, {
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
    //   axios
    //     .get(URL.baseUrl("get_department_company_wise"), {
    //       params: {
    //             employee_sbu: this.sbu_id
    //         },
    //     })
    //     .then((res) => {
    //       this.page_loading = true;
    //       this.modal_loading = true;
    //     })

    //     .catch((error) => {
    //       console.log(error);
    //       this.showToster({ status: 0, message: "opps! something went wrong" });
    //       this.page_loading = true;
    //     });
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

    copy(monyh_id, weeks_id) {
      if (confirm("Do you really want to copy?")) {
        console.log(monyh_id);
        console.log(weeks_id);
        this.modal_loading = false;
        this.page_loading = false;
        let uri = URL.baseUrl("roaster/copy");
        axios
          .post(uri, {
            copy_monyh_id: monyh_id,
            copy_weeks_id: weeks_id,
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
             from_date:this.form_data.from_date,
             to_date:this.form_data.to_date,
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
    onSearchAllData() {
      this.modal_loading = false;
      this.page_loading = false;
      let uri = URL.baseUrl("roaster_report/find");
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
      this.permission_id = option.id;
      this.permission_id_name = option.text;
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
    },

    printDiv() {
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
      $(".table-bordered").each(function () {
        this.style.setProperty("border", "1px solid #dee2e6", "important");
        this.style.setProperty("padding", "5px .75rem", "important");
        this.style.setProperty("border-collapse", "collapse", "important");
      });
      $(".ths").each(function () {
        this.style.setProperty("border", "1px solid #dee2e6", "important");
        this.style.setProperty("padding", "5px 5px", "important");
        this.style.setProperty("border-collapse", "collapse", "important");
      });
      let contents = document.getElementById("printable").innerHTML;
      let frame1 = document.createElement("iframe");
      frame1.name = "frame1";
      frame1.style.position = "absolute";
      frame1.style.top = "-1000000px";
      document.body.appendChild(frame1);
      let frameDoc = frame1.contentWindow
        ? frame1.contentWindow
        : frame1.contentDocument.document
        ? frame1.contentDocument.document
        : frame1.contentDocument;
      frameDoc.document.open();
      frameDoc.document.write(
        '<html lang="en"><head><title>Gemcon Group</title>'
      );
      frameDoc.document.write(
        '<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.0.0-alpha/fullcalendar.print.min.css"/>'
      );
      frameDoc.document.write("</head><body>");
      frameDoc.document.write(contents);
      frameDoc.document.write("</body></html>");
      frameDoc.document.close();
      setTimeout(function () {
        window.frames["frame1"].focus();
        window.frames["frame1"].print();
        document.body.removeChild(frame1);
      }, 500);
      return false;
    },
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
.table-bordered td,
.table-bordered th {
  height: auto !important;
}
</style>