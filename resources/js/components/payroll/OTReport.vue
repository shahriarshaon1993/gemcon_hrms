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
                        <h3 class="card-title d-none d-md-block">OT Reports</h3>
                        <span class="float-sm-right" style="float: right">
                          <a
                            @click="$router.go(-1)"
                            class="btn btn-default"
                            href="#"
                            ><i class="fa fa-arrow-left"></i> Back</a
                          >
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="card-body row" style="padding-top: 0px">
                    <div class="col-md-12">
                      <div class="row report-box">
                        
                        <div
                          class="form-group col-md-2"
                          style="padding: 0px; max-width: 12%"
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
                                multiple="multiple"
                                :options="option_data.company_sbu_data"
                                @select="employeesSbu"
                                placeholder="Select one"
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
                              <!-- {{form_data.unit_data}} -->
                              <vue-select
                                v-model="form_data.unit_value"
                                :options="form_data.unit_data"
                                @select="employeesUnit"
                                multiple="multiple"
                                placeholder="Select one"
                                label="text"
                                track-by="text"
                              ></vue-select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-2" style="max-width: 12%">
                          <label class="col-md-12 control-label"
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
                                v-model="form_data.sub_unit_value"
                                :options="form_data.sub_unit_data"
                                @select="employeesSubUnit"
                                placeholder="Select one"
                                multiple="multiple"
                                label="text"
                                track-by="text"
                              ></vue-select>
                            </div>
                          </div>
                        </div>

                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px; max-width: 12%"
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
                                :options="form_data.department_data"
                                @select="onSelectDepartment"
                                placeholder="Select one"
                                multiple="multiple"
                                label="text"
                                track-by="text"
                              >
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px; max-width: 12%"
                        >
                          <label class="col-md-12 control-label">Section</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <vue-select
                                v-model="form_data.section_value"
                                :options="form_data.section_data"
                                @select="employeesSection"
                                placeholder="Select one"
                                multiple="multiple"
                                label="text"
                                track-by="text"
                              >
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px; max-width: 12%"
                        >
                          <label class="col-md-12 control-label"
                            >Sub Section</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <vue-select
                                v-model="form_data.sub_section_value"
                                :options="form_data.sub_section_data"
                                @select="employeesSubSection"
                                placeholder="Select one"
                                multiple="multiple"
                                label="text"
                                track-by="text"
                              >
                              </vue-select>
                            </div>
                          </div>
                        </div>

                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px; max-width: 12%"
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
                                :options="form_data.work_location_data"
                                @select="employeesWorkLocation"
                                placeholder="Select one"
                                multiple="multiple"
                                label="text"
                                track-by="text"
                              >
                              </vue-select>
                            </div>
                          </div>
                        </div>

                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px; max-width: 12%"
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
                                multiple="multiple"
                                label="text"
                                track-by="text"
                              >
                              </vue-select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-2">
                          <label class="col-md-12"
                            ><strong>Shift</strong></label
                          >
                          <vue-select
                            v-model="form_data.OfficeTimeVelu"
                            :options="option_data.officeTime"
                            @select="onSelectOfficeTime"
                            placeholder="Select one"
                            label="text"
                            multiple="multiple"
                            track-by="text"
                          ></vue-select>
                        </div>

                        <div
                          class="form-group col-md-3 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label"
                            >Employees</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-earphone"></i
                              ></span>
                              <vue-select
                                v-model="employee_name_value"
                                :options="form_data.employee_data"
                                @select="onSelectEmployee"
                                placeholder="Select one"
                                label="text"
                                track-by="text"
                              ></vue-select>
                            </div>
                          </div>
                        </div>
                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label">From</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <datepicker
                                placeholder="Select Date"
                                v-model="form_data.from_date"
                                class="form-control"
                              ></datepicker>
                            </div>
                          </div>
                        </div>
                        <div
                          class="form-group col-md-2 float-left"
                          style="padding: 0px"
                        >
                          <label class="col-md-12 control-label">To</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <datepicker
                                placeholder="Select Date"
                                v-model="form_data.to_date"
                                class="form-control"
                              ></datepicker>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <!-- <button type="submit" class="btn btn-sm btn-info float-right"> <i class="fa fa-search"></i> Search</button> -->
                        <button
                          style="
                            border-radius: 5px;
                            margin-right: -15px;
                            padding: 5px 30px;
                          "
                          @click="viewReportss11111()"
                          type="button"
                          class="btn btn-info float-right"
                        >
                          Search
                        </button>
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
        <div class="loader"></div>
        <section class="content local_excel_print">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="col-12">
                    <button
                      id="btnExport"
                      @click="tableToExcel"
                      class="btn-success float-right"
                      style="margin-left: 10px"
                    >
                      Export
                    </button>
                    <!-- <button v-print="'#printMe'" class="btn-info float-right">Print</button> -->
                    <button @click="printDiv()" class="btn-info float-right">
                      Print
                    </button>
                    <!-- <button data-toggle-fullscreen>Toggle Fullscreen</button> -->
                  </div>
                  <!-- <div class="POMIS_2A_REPORT_VIEW1"  id="printMe" style="padding: 10px 25px 50px 20px"> -->
                  <div id="printable">
                    <table style="width: 100%">
                      <tbody>
                        <tr>
                          <td style="width: 20%">
                            <div class="row" style="margin-left: 21px">
                              <div
                                class="col-md-12"
                                style="padding: 0px; margin-top: 17px"
                              >
                                <img
                                  :src="`asset/1-1.jpg`"
                                  style="width: 50%"
                                />
                              </div>
                            </div>
                          </td>
                          <td style="width: 55%">
                            <div class="col-md-12" style="padding: 0px">
                              <h3
                                class="text-center"
                                style="
                                  margin: 0px;
                                  text-align: center !important;
                                "
                              >
                                Gem Jute Ltd
                              </h3>
                              <h5
                                class="text-center"
                                style="text-align: center !important"
                              >
                                OT Report
                              </h5>
                              <h6
                                v-if=" this.form_data.from_date != '' &&  this.form_data.to_date != ''"
                                class="text-center"
                                style="text-align: center !important"
                              >
                                Date: {{ format_Date( this.form_data.from_date) }} to
                                {{ format_Date( this.form_data.to_date) }}
                              </h6>
                            </div>
                          </td>
                          <td style="width: 25%">
                            <div
                              class="col-md-12"
                              style="padding: 0px; margin-top: 17px"
                            >
                              <p>
                                <strong>Print Date :</strong>
                                {{ format_Date(new Date()) }}
                              </p>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <table
                      class="table table-bordered"
                      border="0"
                      style="width: 100%"
                    >
                      <thead>
                        <tr style="background: #eee">
                          <th class="ths">Sl.</th>
                          <th class="ths">Employee ID</th>
                          <th class="ths">Employee Name</th>
                          <th class="ths">Designation</th>
                          <th class="ths">Department</th>
                          <th class="ths">Work Location</th>
                          <th class="ths">Company</th>
                          <th class="ths">Shift</th>
                          <th class="ths">Date</th>
                          <th class="ths">In Time</th>
                          <th class="ths">Out Time</th>
                          <th class="ths">Assigned OT</th>
                          <!-- <th class="ths">OT</th> -->
                          <th class="ths">Remarks</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- {{this.alldata}} -->
                        <!-- {{list_data}} -->
                        <!-- <tr class="body_td" v-for="(data,index) in list_data" :key="index"> -->
                        <tr v-for="(data, index) in alldata" v-bind:key="index">
                          <td class="ths">{{ index + 1 }}</td>
                          <td class="ths" style="text-align: center;">{{ data.employee_card_no }}</td>
                          <td class="ths">{{ data.employee_fullname }}</td>
                          <td class="ths">{{ data.designation_name }}</td>
                          <td class="ths">{{ data.department_name }}</td>
                          <td class="ths">{{ data.work_location_name }}</td>
                          <td class="ths">{{ data.sbu_name }}</td>
                          <td class="ths" style="text-align: center;">{{ data.title }}</td>
                          <td class="ths">{{ data.pdate }}</td>
                          <td class="ths">{{ data.intime }}</td>
                          <td class="ths">{{ data.outime }}</td>
                          <td class="ths" style="text-align: center;">{{ data.ot_entry }}</td>
                          <!-- <td class="ths">{{ data.ot_time }}</td> -->
                          <td class="ths">{{ data.remarks }}</td>
                        </tr>
                      </tbody>
                    </table>
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
import Loading from "../Loading.vue";
import print from "vue-print-nb";
import $ from "jquery";
import Multiselect from "vue-multiselect";

export default {
  data() {
    return {
      info_data: [],
      district_value: "",
      list_data: "",
      alldata: [],
      employee_group_value: "",
      column_selection1: "",
      column_selection2: "",
      column_selection3: "",
      column_selection4: "",
      column_selection5: "",
      column_selection6: "",
      column_selection7: "",
      column_selection8: "",
      column_selection9: "",
      column_selection10: "",
      column_selection11: "",
      column_selection12: "",
      column_selection13: "",
      column_selection14: "",
      attendanceColumn_value: "",
      employee_Category_value: "",
      visable: "",
      report_container: 0,
      // sbu_name_value:'',
      sbu_name_value: [],
      employeeSbuData: [],
      section_value: "",
      district_value: "",
      sub_section_value: "",
      employee_group_value: "",
      sub_unit_value: "",
      work_location_value: [],
      department_name_value: "",
      department_name_value: [],
      work_location_value: [],
      AttStatus_value: "",
      employee_type_value: "",
      work_location_value: "",
      designation_name_value: "",
      jobgrade_name_value: "",
      employee_name_value: "",
      employee_name_value: "",
      reportTypesVelu: 0,
      dailyReportTypesVelu: 0,
      periodicReportTypesVelu: 0,
      individualReportTypesVelu: 0,
      checkedName: true,
      value: [],
      options: [
        { name: "Vue.js", language: "JavaScript" },
        { name: "Adonis", language: "JavaScript" },
        { name: "Rails", language: "Ruby" },
        { name: "Sinatra", language: "Ruby" },
        { name: "Laravel", language: "PHP" },
        { name: "Phoenix", language: "Elixir" },
      ],
      checkNameArray: [
        {
          label: "",
        },
      ],
      checkedattcols: [],
      isCheckAll: false,
      checkedattcolsaddText: [
        {
          id: "",
          text: "",
        },
      ],
      checkedattcolsadd: [],
      printObj: {
        id: "printMe",
        popTitle: "good print",
        extraCss: "https://www.google.com,https://www.google.com",
        extraHead: '<meta http-equiv="Content-Language"content="zh-cn"/>',
      },
    };
  },
  directives: {
    print,
  },
  created() {
    this.getResults(1);
    this.setFormData();
    this.getUrl();
  },
  components: {
    pageLoading: Loading,
    Multiselect,
  },
  methods: {
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
      // $('table').each(function() {
      //   this.style.setProperty('border', '1px solid #dee2e6', 'important');
      //   this.style.setProperty('padding', '5px .75rem', 'important');
      //   this.style.setProperty('border-collapse', 'collapse', 'important');
      // });
      // $('td').each(function() {
      //   this.style.setProperty('border', '1px solid #dee2e6', 'important');
      //   this.style.setProperty('padding', '5px .75rem', 'important');
      //   this.style.setProperty('border-collapse', 'collapse', 'important');
      // });
      $(".table-bordered").each(function () {
        this.style.setProperty("border", "1px solid #dee2e6", "important");
        this.style.setProperty("padding", "5px .75rem", "important");
        this.style.setProperty("border-collapse", "collapse", "important");
      });
      // $('').each(function() {
      //   this.style.setProperty('border', '1px solid #dee2e6', 'important');
      //   this.style.setProperty('padding', 'padding: 5px .75rem;', 'important');
      // });
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

      //      $('#filePrintPreview').html("TEST");
      // //way 1: pure JS exmple
      // document.getElementById('filePrintPreview').style.setProperty('color', 'red', 'important');
      // //way 2: wrapped inside jQuery's each() example
      // $('h3').each(function() {
      //   this.style.setProperty('color', '#12FF12', 'important');
      // });

      // var contents = document.getElementById("printable").innerHTML;
      // var frame1 = document.createElement('iframe');
      // frame1.name = "frame1";
      // frame1.style.position = "absolute";
      // frame1.style.top = "-1000000px";
      // document.body.appendChild(frame1);
      // var frameDoc = (frame1.contentWindow) ? frame1.contentWindow : (frame1.contentDocument.document) ? frame1.contentDocument.document : frame1.contentDocument;
      // frameDoc.document.open();
      // frameDoc.document.write('<html><head><title>Gemcon Group HR</title>');
      // frameDoc.document.write('</head><body>');
      // frameDoc.document.write(contents);
      // frameDoc.document.write('</body></html>');
      // frameDoc.document.close();
      // setTimeout(function () {
      //     window.frames["frame1"].focus();
      //     window.frames["frame1"].print();
      //     document.body.removeChild(frame1);
      // }, 500);
      // return false;
    },
    tableToExcel() {
      var uri = "data:application/vnd.ms-excel;base64,",
        template =
          '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
        base64 = function (s) {
          return window.btoa(unescape(encodeURIComponent(s)));
        },
        format = function (s, c) {
          return s.replace(/{(\w+)}/g, function (m, p) {
            return c[p];
          });
        };
      var toExcel = document.getElementById("printable").innerHTML;
      var ctx = {
        worksheet: name || "",
        table: toExcel,
      };
      var link = document.createElement("a");
      link.download = "weekly_Payroll.xls";
      link.href = uri + base64(format(template, ctx));
      link.click();
    },
    reportTypes(event) {
      if (event.target.value == 1) {
        this.reportTypesVelu = 1;
        this.dailyReportTypesVelu = 0;
        this.periodicReportTypesVelu = 0;
        this.individualReportTypesVelu = 0;
        this.column_selection1 = "";
        this.column_selection2 = "";
        this.column_selection3 = "";
        this.column_selection4 = "";
        this.column_selection5 = "";
        this.column_selection6 = "";
        this.column_selection7 = "";
        this.column_selection8 = "";
        this.column_selection9 = "";
        this.column_selection10 = "";
        this.column_selection11 = "";
        this.column_selection12 = "";
        this.column_selection13 = "";
        this.column_selection14 = "";
        this.form_data.checkedattcolsadd = "";

        this.fromDataReset();
      } else if (event.target.value == 2) {
        this.reportTypesVelu = 2;
        this.dailyReportTypesVelu = 0;
        this.periodicReportTypesVelu = 0;
        this.individualReportTypesVelu = 0;

        this.fromDataReset();
      } else {
        this.reportTypesVelu = 0;
      }
      console.log(event.target.value);
    },
    fromDataReset() {
      this.employee_name_value = "";
      this.form_data.att_report_type = "";
      this.form_data.employee_sbu = "";
      this.form_data.employee_section = "";
      this.form_data.employee_group = "";
      this.form_data.employee_sub_unit = "";
      this.form_data.employee_work_location = "";
      this.form_data.employee_department = "";
      this.form_data.employee_designation = "";
      this.form_data.employee_job_grade = "";
      this.form_data.employee_id = "";
      this.form_data.employee_status = "";
      this.sbu_name_value = [];
      // this.sbu_name_value='';
      this.employeeSbuData = [];
      this.section_value = "";
      this.sub_section_value = "";
      this.employee_group_value = "";
      this.sub_unit_value = "";
      this.work_location_value = [];
      this.department_name_value = "";
      this.work_location_value = "";
      this.designation_name_value = "";
      this.jobgrade_name_value = "";
      this.employee_name_value = "";
      this.employee_name_value = "";
      this.DailyreportStatus = "";
      this.jobgradeData_value = "";
      this.service_length_from = "";
      this.service_length_to = "";
      // this.EmplysStatus='';
      this.form_data.att_status = "";
      this.form_data.att_status = "";
      this.AttStatus_value = "";
    },
    DailyreportStatus(event) {
      this.form_data.att_status = event.target.value;
    },
    DailyreportTypes(event) {
      if (event.target.value == 1 || event.target.value == 2) {
        this.dailyReportTypesVelu = 1;
        this.form_data.att_report_type = event.target.value;
        this.periodicReportTypesVelu = 0;
        this.individualReportTypesVelu = 0;
      } else if (event.target.value == 3) {
        this.dailyReportTypesVelu = 0;
        this.DailyreportStatus = "";
        this.form_data.att_status = "";
        this.form_data.att_report_type = event.target.value;
        this.individualReportTypesVelu = 1;
        this.periodicReportTypesVelu = 0;
      } else if (event.target.value == 4 || event.target.value == 5) {
        this.periodicReportTypesVelu = 1;
        this.dailyReportTypesVelu = 0;
        this.form_data.att_report_type = event.target.value;
        this.individualReportTypesVelu = 0;
        this.DailyreportStatus = "";
        this.form_data.att_status = "";
      } else {
        this.form_data.att_report_type = 0;
        this.dailyReportTypesVelu = 0;
        this.periodicReportTypesVelu = 0;
        this.individualReportTypesVelu = 0;
        this.DailyreportStatus = "";
        this.form_data.att_status = "";
      }
      console.log(event.target.value);
    },

    tableToExcel() {
      var uri = "data:application/vnd.ms-excel;base64,",
        template =
          '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
        base64 = function (s) {
          return window.btoa(unescape(encodeURIComponent(s)));
        },
        format = function (s, c) {
          return s.replace(/{(\w+)}/g, function (m, p) {
            return c[p];
          });
        };
      var toExcel = document.getElementById("tblCustomers").innerHTML;
      var ctx = {
        worksheet: name || "",
        table: toExcel,
      };
      var link = document.createElement("a");
      link.download = "export.xls";
      link.href = uri + base64(format(template, ctx));
      link.click();
    },
    fullScreenView() {},
    printText() {},

    viewReportss11111() {
      $(".local_excel_print").hide();
      $(".loader").show();
      // var urla = URL.baseUrl("get_report");
      // console.log(urla);
      axios
        .post(URL.baseUrl("get_report"), {
          checkedattcolsadd: this.form_data.checkedattcolsadd,
          report_type: this.form_data.report_type,
          employee_department: this.form_data.employee_department,
          employee_designation: this.form_data.employee_designation,
          employee_sbu: this.form_data.employee_sbu,
          att_report_type: this.form_data.att_report_type,
          from_date: this.form_data.from_date,
          to_date: this.form_data.to_date,
          employee_id: this.form_data.employee_id,
          employee_section: this.form_data.employee_section,
          employee_sub_section: this.form_data.employee_sub_section,
          age_from: this.form_data.age_from,
          age_to: this.form_data.age_to,
          salary_from: this.form_data.salary_from,
          salary_to: this.form_data.salary_to,
          permanent_district: this.form_data.permanent_district,
          employee_marital_status: this.form_data.employee_marital_status,
          employee_gender: this.form_data.employee_gender,

          employee_blood_group: this.form_data.employee_blood_group,
          employee_department: this.form_data.employee_department,
          employee_designation: this.form_data.employee_designation,

          employee_name_value: this.form_data.employee_name_value,
          designation_name_value: this.form_data.designation_name_value,
          department_name_value: this.form_data.department_name_value,
          work_location_value: this.form_data.work_location_value,
          sbu_name_value: this.form_data.sbu_name_value,

          section_value: this.form_data.section_value,
          sub_section_value: this.form_data.sub_section_value,
          district_value: this.form_data.district_value,
          employee_group_value: this.form_data.employee_group_value,
          employee_type_value: this.form_data.employee_type_value,
          employee_Category_value: this.form_data.employee_Category_value,
          att_status: this.form_data.att_status,
          employee_status: this.form_data.employee_status,

          jobgradeData_value: this.form_data.jobgradeData_value,
          service_length_from: this.form_data.service_length_from,
          service_length_to: this.form_data.service_length_to,
          AttStatus_value: this.AttStatus_value,
          OfficeTime: this.form_data.OfficeTimeVelu,
          sub_unit_value: this.form_data.sub_unit_value,
          unit_value: this.form_data.unit_value,

          _token: $("input[name=_token]").val(),
        })
        .then((res) => {
          console.log(res);
          if (res.data.status == 1) {
            this.report_container = 1;
            this.alldata = res.data.attendance_data;
            $(".loader").hide();
            $(".local_excel_print").show();
          } else {
            var msg = "opps! something went wrong";
            this.showToster({ status: 0, message: msg });
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
          var msg = "opps! something went wrong";
          this.showToster({ status: 0, message: msg });
        });
    },
    employeesCategory() {},
    employeeTypes() {},
    printStyles() {
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
    },
    columncheck(event, id) {
      if (event.target.value == undefined) {
      } else {
        this.checkedattcolsadd.push(event.target.value);
        this.form_data.checkedattcolsadd = this.checkedattcolsadd;
        this.checkNameArray.push({
          label: id["label"],
        });
      }
    },

    uncheck(event, checkedName) {
      if (checkedName.id == "section_name") {
        this.column_selection1 = "";
      }
      if (checkedName.id == "sub_section_name") {
        this.column_selection2 = "";
      }
      if (checkedName.id == "employee_marital_status") {
        this.column_selection3 = "";
      }
      if (checkedName.id == "employee_blood_group") {
        this.column_selection4 = "";
      }
      if (checkedName.id == "permanent_district") {
        this.column_selection5 = "";
      }
      if (checkedName.id == "age") {
        this.column_selection6 = "";
      }
      if (checkedName.id == "salary") {
        this.column_selection7 = "";
      }

      if (checkedName.id == "service_length") {
        this.column_selection9 = "";
      }
      if (checkedName.id == "employee_job_grade") {
        this.column_selection10 = "";
      }

      if (checkedName.id == "emplyee_category_mgt_non_mgt") {
        this.column_selection11 = "";
      }
      if (checkedName.id == "employee_type") {
        this.column_selection12 = "";
      }
      if (checkedName.id == "employee_group") {
        this.column_selection13 = "";
      }
      if (checkedName.id == "employee_gender") {
        this.column_selection14 = "";
      }

      console.log(this.attendanceColumn_value);
      let datall = this.form_data.checkedattcolsadd;
      this.checkedattcolsadd = [];
      this.checkedattcolsaddText = [
        {
          id: "",
          text: "",
        },
      ];
      datall.forEach((element) => {
        if (checkedName.id === element) {
          // console.log(element);
        } else {
          let datall = this.option_data.attendanceColumn;
          let obj = datall.find((data) => data.id == element);
          this.checkedattcolsadd.push(element);
          this.checkedattcolsaddText.push({
            id: element,
            text: obj["text"],
          });
          this.form_data.checkedattcolsadd = this.checkedattcolsadd;
        }
        this.attendanceColumn_value = this.checkedattcolsaddText;
      });
    },
    // employeesSbu(option){
    //   console.log(option);
    //   this.employeeSbuData.push(option.id)
    //   this.form_data.employee_sbu= this.employeeSbuData;

    // },
    // onchentdata(){
    //     var result = Object.entries(this.form_data.branch_value);
    //     console.log(result);
    //     result.forEach(element => {
    //       console.log(element[1]['id']);
    //        this.permision.push(element[1]['id']);
    //     });
    //   // this.permision.push(option.id)
    //   this.form_data.permision=this.permision;
    //   // this.form_data.branch_value;
    //  console.log(this.form_data.permision);
    // },
    // employeesUnit(option){
    //   this.form_data.employee_unit= option.id;
    // },
    // employeesSubUnit(option){
    //    this.form_data.employee_sub_unit= option.id;
    // },
    // employeesSection(option){
    //   console.log(option);
    //   this.form_data.employee_section= option.id;
    //   console.log(this.form_data.employee_section);
    // },
    onSelectAtt_status(option) {
      this.form_data.att_status = option;
    },
    onSelectOfficeTime(option) {
      this.form_data.OfficeTime = option;
    },
    // employeesSubSection(option){
    //   console.log(option);
    //   this.form_data.employee_sub_section= option.id;
    //   console.log(this.form_data.employee_sub_section);
    // },
    jobgradeData(option) {
      this.form_data.employee_job_grade = option.id;
    },
    employeesGroup(option) {
      console.log(option);
      this.form_data.employee_group = option.id;
      console.log(this.form_data.employee_group);
    },
    // employeesSubUnit(option){
    //   console.log(option);
    //   this.form_data.employee_sub_unit= option.id;
    //   console.log(this.form_data.employee_sub_unit);
    // },

    // employeesWorkLocation(option){
    //   console.log(option);
    //   this.form_data.employee_work_location= option.id;
    //   console.log(this.form_data.employee_work_location);

    // },
    // onSelectDepartment(option){
    //   console.log(option);
    //   this.form_data.employee_department= option.id;
    //   console.log(this.form_data.employee_department);

    // },
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
    onSelectEmployee(option) {
      // alert('s')
      console.log(option);
      this.form_data.employee_id = option.id;
      console.log(this.form_data.employee_id);
    },
    employeesDistrict(option) {
      console.log(option);
      this.form_data.permanent_district = option.id;
      console.log(this.form_data.permanent_district);
    },
    setModalData() {
      this.employee_name_value = this.form_data.employee_name_value;
    },

    onSelectAttendanceColumn(option) {
      if (option.id == "section_name") {
        this.column_selection1 = option.id;
      }
      if (option.id == "sub_section_name") {
        this.column_selection2 = option.id;
      }
      if (option.id == "employee_marital_status") {
        this.column_selection3 = option.id;
      }
      if (option.id == "employee_blood_group") {
        this.column_selection4 = option.id;
      }
      if (option.id == "permanent_district") {
        this.column_selection5 = option.id;
      }
      if (option.id == "age") {
        this.column_selection6 = option.id;
      }
      if (option.id == "salary") {
        this.column_selection7 = option.id;
      }
      if (option.id == "employee_job_grade") {
        this.column_selection10 = option.id;
      }
      if (option.id == "service_length") {
        this.column_selection9 = option.id;
      }

      if (option.id == "emplyee_category_mgt_non_mgt") {
        this.column_selection11 = option.id;
      }
      if (option.id == "employee_type") {
        this.column_selection12 = option.id;
      }
      if (option.id == "employee_group") {
        this.column_selection13 = option.id;
      }
      if (option.id == "employee_gender") {
        this.column_selection14 = option.id;
      }

      // console.log('sss');
      // console.log(option);
      // console.log(this.column_selection);
      this.checkedattcolsadd.push(option.id);
      this.checkedattcolsaddText.push({
        id: option.id,
        text: option.text,
      });

      this.form_data.checkedattcolsadd = this.checkedattcolsadd;
      console.log(this.form_data.checkedattcolsadd);
    },

    setFormData() {
      // this.form_data.att_report_type = 0;
      // this.form_data.report_type = 0;
    },
  },
};
</script>
<style type="text/css">
.report_fileds
  > .multiselect__tags
  > .multiselect__tags-wrap
  > .multiselect__tag {
  display: none;
}
.local_excel_print {
  display: none;
}
.loader {
  display: none;
}
.loader {
  border: 10px solid #ffffff;
  border-radius: 50%;
  border-top: 10px solid #fec23c;
  border-bottom: 10px solid #fec23c;
  width: 60px;
  height: 60px;
  position: fixed;
  left: 50%;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
  }
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@media print {
  .test {
    background-color: #1a4567 !important;
    -webkit-print-color-adjust: exact;
  }
}
.multiselect__content-wrapper {
  width: 200% !important;
}
</style>