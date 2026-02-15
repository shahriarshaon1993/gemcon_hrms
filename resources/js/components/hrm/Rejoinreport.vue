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
                          Rejoin Report
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
                    <div class="row col-md-12"></div>
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
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <table
                      id="employeeTable"
                      class="table table-bordered table-striped employeeTable"
                    >
                      <thead>
                        <tr>
                          <th class="text-center">SL</th>
                          <th>Employee ID</th>
                          <th>Employee</th>
                          <th>Comp./SBU</th>
                          <th>Department</th>
                          <th>Designation</th>

                          <th>Joining Date</th>
                          <th>Effective Date</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody v-if="Object.keys(rejoinreport).length > 0">
                        <tr
                          v-for="(data, index) in rejoinreport"
                          v-bind:key="index"
                        >
                          <!-- {{rejoinreport}} -->
                          <td class="text-center">{{ index + 1 }}</td>
                          <td>{{ data.employee_id_no }}</td>
                          <td>{{ data.employee_fullname }}</td>
                          <td>{{ data.sbu_name }}</td>
                          <td>{{ data.department_name }}</td>
                          <td>{{ data.designation_name }}</td>

                          <td>{{ data.joining_date }}</td>
                          <td>{{ data.effective_date }}</td>
                          <td>{{ data.remark }}</td>
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
      rejoinreport: [],
      total_absent: "",
      date_absent: "",
      sbu_name_value: "",
      section_value: "",
      sub_section_value: "",
      employee_group_value: "",
      sub_section_value: "",
      absent_day_value: 5,
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
    onSearchAllData() {
      this.modal_loading = false;
      this.page_loading = false;
      let uri = URL.baseUrl("rejoin/report");
      axios
        .post(uri, {
          sbu_id: this.sbu_id,
          absent_day_value: this.absent_day_value,
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
          // console.log(res);
          this.rejoinreport = res.data.rejoinreport;
          this.modal_loading = true;
          this.page_loading = true;
          this.resetModal();
        })
        .catch((error) => {
          this.modal_loading = true;
          this.page_loading = true;
        });
    },
    tableToExcel(table, name) {
      if (!table.nodeType) table = this.$refs.table;
      var ctx = { worksheet: name || "Worksheet", table: table.innerHTML };
      window.location.href =
        this.uri + this.base64(this.format(this.template, ctx));
    },
    updateCountry(form_data, shift) {
      form_data.shift = shift;
    },

    onSelectDesignation(option) {
      this.employee_designation = option.id;
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