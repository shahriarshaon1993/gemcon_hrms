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
                               <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                                   <h3 class="card-title d-none d-md-block">Insurance Eligible Finding</h3>
                                   <span class="float-sm-right" style="float: right;">
                                    <a @click="$router.go()" class="btn bg-info"><i class="fa fa-spinner" aria-hidden="false"></i> Refresh</a>
                                     <a @click="$router.go(-1)" class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                                   </span>
                               </div>
                           </div>
                        </div>
                       <div class="card-body row" style="padding-top:0px;">
                          <div class="col-md-12">
                            <div class="row" style="margin:10px 0px;">
                                 <div class="input-group">
                                    <div class="col-md-2" style="padding-left:0px;">
                                      <label class="col-md-12" style="padding-left:1px;">Insurance Eligible Type</label>
                                      <select v-model="form_data.insurance_eligible_type" name="typ" class="form-control" style="font-size: 14px; height: 30px;">
                                          <option value="0" disabled>-- Select Status --</option>
                                          <!-- <option> All </option> -->
                                          <option value="1">Eligible</option>
                                          <option value="2">Inclusion</option>
                                          <option value="3">Exclusion</option>
                                      </select>
                                    </div>
                                    <!-- {{ form_data.employee_status }} -->
                                    <div class="col-md-2" style="padding-left:0px;">
                                      <label  class="col-md-12" style="padding-left:1px;">Status</label>
                                      <vue-select v-model="form_data.employee_status" :options="option_data.employee_status_data" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                                      </vue-select>
                                    </div>
                                    <div class="form-group col-md-2 float-left" style="padding:0px;">
                                      <label class="col-md-12 control-label">From Date</label>
                                      <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group">
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                          <!-- <datepicker placeholder="Select Date" v-model="form_data.from_date" class="form-control"></datepicker> -->
                                          <input placeholder="Select Date" v-model="form_data.from_date" type="date" class="form-control">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group col-md-2 float-left" style="padding:0px;">
                                      <label class="col-md-12 control-label">To Date</label>
                                      <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group">
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                          <!-- <datepicker placeholder="Select Date" v-model="form_data.to_date"   class="form-control"></datepicker> -->
                                          <input placeholder="Select Date" v-model="form_data.to_date" type="date" class="form-control">
                                        </div>
                                      </div>
                                    </div>
                                </div> 
                            </div>
                       <div class="row report-box" style="margin:10px 0px;">
                          <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 11%">
                            <label class="col-md-12 control-label">Company/SBU</label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="form_data.sbu_name_value" multiple="multiple" :options="option_data.company_sbu_data" @select="employeesSbu" placeholder="Select one"   label="text" track-by="text"></vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-2" style="max-width: 11%;">
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
                          <div class="form-group col-md-2" style="max-width: 11%">
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
                          <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 11%">
                            <label class="col-md-12 control-label">Department</label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="form_data.department_name_value" :options="form_data.department_data" @select="onSelectDepartment" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                                  </vue-select>
                              </div>
                            </div>
                          </div>
                          <div  class="form-group col-md-2 float-left" style="padding:0px;max-width: 11%">
                            <label class="col-md-12 control-label">Section</label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="form_data.section_value" :options="form_data.section_data" @select="employeesSection" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                                  </vue-select>
                              </div>
                            </div>
                          </div>
                          <div  class="form-group col-md-2 float-left" style="padding:0px;max-width: 11%">
                            <label class="col-md-12 control-label">Sub Section</label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="form_data.sub_section_value" :options="form_data.sub_section_data" @select="employeesSubSection" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                                  </vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 11%">
                              <label class="col-md-12 control-label">Work Location</label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="form_data.work_location_value" :options="form_data.work_location_data" @select="employeesWorkLocation" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                                  </vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 11%">
                            <label class="col-md-12 control-label">Designation</label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="form_data.designation_name_value" :options="option_data.designation_data" @select="onSelectDesignation" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                                  </vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-2 float-left" style="padding:0px; max-width: 11%">
                            <label class="col-md-12 control-label">Employees</label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                <vue-select v-model="form_data.employee_name_value" :options="form_data.employee_data" multiple="multiple" placeholder="Select one" label="text" track-by="text"></vue-select>
                              </div>
                            </div>
                          </div>
                       </div>
                        <div class="row report-box" style="margin:10px 0px;">      
                          <div class="form-group col-md-2 float-left" style="padding:0px;">
                            <label class="col-md-12 control-label">Job Grade</label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="form_data.jobgradeData_value" :options="option_data.jobgrade_data" @select="jobgradeData" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                                  </vue-select>
                              </div>
                            </div>
                          </div>    
                          <div class="form-group col-md-2 float-left" style="padding:0px;">
                            <label class="col-md-12 control-label">Employee Category</label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="form_data.employee_Category_value" :options="option_data.emplyeeCategory" @select="employeesCategory" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                                  </vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-2 float-left" style="padding:0px;">
                            <label class="col-md-12 control-label">Employee Type</label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="form_data.employee_type_value" :options="option_data.employeeType" @select="employeeTypes" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                                  </vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-2 float-left" style="padding:0px;">
                            <label class="col-md-12 control-label">Employee Group</label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="form_data.employee_group_value" :options="option_data.employee_group_data" @select="employeesGroup" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                                  </vue-select>
                              </div>
                            </div>
                          </div>    
                          <div class="form-group col-md-2 float-left" style="padding:0px;">
                            <label class="col-md-12 control-label">Age (Year)</label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <input placeholder="Age From" required="true" type="number" v-model="form_data.age_from" class="form-control">
                                <input placeholder="Age To" type="number" required="true" v-model="form_data.age_to" class="form-control" style="margin-left: 5px">
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-2 float-left" style="padding:0px;">
                            <label class="col-md-12 control-label">Service Length (Year)</label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <input placeholder="Length From" required="true" type="number" v-model="form_data.service_length_from" class="form-control">
                                <input placeholder="Length To" type="number" required="true" v-model="form_data.service_length_to" class="form-control" style="margin-left: 5px">
                              </div>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-12">
                        <button style="border-radius: 5px; margin-right: -10px;padding: 5px 30px;"  @click="findInsuranceEligibleEmployee(form_data,urls)" type="button" class="btn btn-info float-right">Search</button>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <div class="loader">
          </div>
          <div class="col-md-12 text-center success_error_message"></div>
          <section class="content local_excel_print">
                <div class="container-fluid hide_show_eligible">
                  <div class="row">
                      <div class="col-12">
                        <div class="card">
                          <div class="col-12">
                            <button id="btnExport"  @click="tableToExcel" class="btn-success float-right" style="margin-left:10px;">Export</button>
                            <button @click="printDiv()" class="btn-info float-right">Print</button>
                          </div>
                            <div class="POMIS_2A_REPORT_VIEW1" id="printable" style="overflow-x: auto;">
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
          leave_view_type: 0,
          leaveStatusValue: 0,
          leave_type_info: [],
          urls: '',
          district_value: "",
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
          column_selection15: "",
          column_selection16: "",
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
          attendanceLateTypesVelu: 0,
          checkedName: true,
          value: [],
          monthNameList: [
            {'month_id' : '01',  'month_name': "January"}, 
            {'month_id' : '02',  'month_name': "February"}, 
            {'month_id' : '03',  'month_name': "March"}, 
            {'month_id' : '04',  'month_name': "April"}, 
            {'month_id' : '05',  'month_name': "May"}, 
            {'month_id' : '06',  'month_name': "June"},
            {'month_id' : '07',  'month_name': "July"}, 
            {'month_id' : '08',  'month_name': "August"}, 
            {'month_id' : '09',  'month_name': "September"}, 
            {'month_id' : '10', 'month_name': "October"}, 
            {'month_id' : '11', 'month_name': "November"}, 
            {'month_id' : '12', 'month_name': "December"}
          ],
          turnover_view_type: "",
          turnover_year: "",
          turnover_month: "",
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


          form_data: {
            age_from: 18,
            age_to: 18,
          }
        };
      },
      directives: {
        print,
      },
      created() {
        this.getResults(1);
        this.setFormData();
        // this.getUrl();
      },
      
      components: {
        pageLoading: Loading,
        Multiselect,
      },
      computed: {
        yearList() {
          const startYear = 1979;
          const years = [];
          const current_year = new Date().getFullYear();
          for (let i = current_year; i >= startYear; i--) {
            years.push(i);
          }
          return years;
        },
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
    
          $(".table-bordered").each(function () {
            this.style.setProperty("border", "1px solid #000", "important");
            this.style.setProperty("padding", "2px .75rem", "important");
            this.style.setProperty("border-collapse", "collapse", "important");
          });

          $(".ths").each(function () {
            this.style.setProperty("border", "1px solid rgb(0 0 0 / 87%)", "important");
            this.style.setProperty("padding", "2px 2px", "important");
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
        tableToExcel() {
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
          link.download = "export.xls";
          link.href = uri + base64(format(template, ctx));
          link.click();
        },
        findInsuranceEligibleEmployee(form_data, url) {
          $('.success_error_message').css('display', 'none');
          $(".local_excel_print").hide();
          $(".loader").show();
          var urla = URL.baseUrl("find_insurance_eligible_employee");
          console.log(urla);
          $.ajax({
            url: urla,
            data: {
              insurance_eligible_type: this.form_data.insurance_eligible_type,
              employee_department: this.form_data.employee_department,
              employee_designation: this.form_data.employee_designation,
              employee_sbu: this.form_data.employee_sbu,
              att_report_type: this.form_data.att_report_type,
              from_date: this.form_data.from_date,
              to_date: this.form_data.to_date,
              employee_id: this.form_data.employee_id,
              employee_id_all: this.form_data.employee_name_value,
              employee_section: this.form_data.employee_section,
              employee_sub_section: this.form_data.employee_sub_section,
              age_from: this.form_data.age_from,
              age_to: this.form_data.age_to,
              employee_department: this.form_data.employee_department,
              employee_designation: this.form_data.employee_designation,
              employee_name_value: this.form_data.employee_name_value,
              designation_name_value: this.form_data.designation_name_value,
              department_name_value: this.form_data.department_name_value,
              work_location_value: this.form_data.work_location_value,
              sbu_name_value: this.form_data.sbu_name_value,
              section_value: this.form_data.section_value,
              sub_section_value: this.form_data.sub_section_value,
              employee_group_value: this.form_data.employee_group_value,
              employee_type_value: this.form_data.employee_type_value,
              employee_Category_value: this.form_data.employee_Category_value,
              employee_status: this.form_data.employee_status,
              jobgradeData_value: this.form_data.jobgradeData_value,
              service_length_from: this.form_data.service_length_from,
              service_length_to: this.form_data.service_length_to,
              sub_unit_value: this.form_data.sub_unit_value,
              unit_value: this.form_data.unit_value,
              _token: $("input[name=_token]").val(),
            },
            type: "POST",
            success: function (return_data) {
              console.log(return_data);
              this.report_container = 1;
              $("#report_container").show();
              $(".POMIS_2A_REPORT_VIEW1").html(return_data);
              $(".loader").hide();
              $(".local_excel_print").show();
              this.printStyles();
              this.printDiv();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
              ajax_request_handaler(errorThrown);
              var msg = "opps! something went wrong";
              this.showToster({ status: 0, message: msg });
            },
          });
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
          this.form_data.employee_status =1;
          this.sbu_name_value = [];
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
          this.form_data.att_status = "";
          this.form_data.att_status = "";
          this.AttStatus_value = "";
          this.leave_type_info= [];
        },
        fullScreenView() {},
        printText() {},
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
         onSelectReporting(option) {
          console.log(option);
          this.form_data.employee_reporting_to = option.id;
          console.log(this.form_data.employee_reporting_to);
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
        //   var urla = URL.baseUrl("find_insurance_eligible_employee");
        //   console.log(urla);
        //   $.ajax({
        //     url: urla,
        //     data: {
        //       employee_department: this.form_data.employee_department,
        //       employee_designation: this.form_data.employee_designation,
        //       employee_sbu: this.form_data.employee_sbu,
        //       employee_section: this.form_data.employee_section,
        //       employee_sub_section: this.form_data.employee_sub_section,
        //       employee_department: this.form_data.employee_department,
        //       employee_designation: this.form_data.employee_designation,
        //       employee_name_value: this.form_data.employee_name_value,
        //       designation_name_value: this.form_data.designation_name_value,
        //       department_name_value: this.form_data.department_name_value,
        //       work_location_value: this.form_data.work_location_value,
        //       sbu_name_value: this.form_data.sbu_name_value,
        //       section_value: this.form_data.section_value,
        //       sub_section_value: this.form_data.sub_section_value,
        //       employee_group_value: this.form_data.employee_group_value,
        //       employee_type_value: this.form_data.employee_type_value,
        //       employee_Category_value: this.form_data.employee_Category_value,
        //       employee_status: this.form_data.employee_status,
        //       jobgradeData_value: this.form_data.jobgradeData_value,
        //       service_length_from: this.form_data.service_length_from,
        //       service_length_to: this.form_data.service_length_to,
        //       sub_unit_value: this.form_data.sub_unit_value,
        //       unit_value: this.form_data.unit_value,
        //       _token: $("input[name=_token]").val(),
        //     },
        //     type: "POST",
        //     success: function (return_data) {
        //       console.log(return_data);
        //     },
        //     error: function (XMLHttpRequest, textStatus, errorThrown) {
        //       ajax_request_handaler(errorThrown);
        //       var msg = "opps! something went wrong";
        //       this.showToster({ status: 0, message: msg });
        //     },
        //   });
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
        // onSelectEmployee(option) {
        //   // alert('s')
        //   console.log(option);
        //   this.form_data.employee_id = option.id;
        //   console.log(this.form_data.employee_id);
        // },

        setModalData() {
          this.employee_name_value = this.form_data.employee_name_value;
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
      .service_length,.employee_status,.leave_total_days,.employee_id_no,.employee_joining_date, .in_time, .shift_time, .out_time, .late, .status, .employee_mobile{
        text-align: center !important;
      }
    </style>