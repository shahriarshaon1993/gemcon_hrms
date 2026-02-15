<template>
  <div>
    <div v-if="page_loading" class="widget box">
      <div class="widget-header">
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body col-md-12">
                    <div class="row" style="padding: 0px">
                      <div
                        class="col-md-12"
                        style="border: 1px solid #ddd; padding: 15px"
                      >
                        <div class="row">
                          <div class="col-md-12">
                            <div
                              class="form-group row"
                              style="margin-bottom: 0px"
                            >
                              <div class="col-md-2">
                                <label
                                  class="control-label"
                                  style="margin-bottom: 5px"
                                >
                                  Company
                                  <!-- {{company_sbu_data}} -->
                                </label>
                                <div
                                  class="inputGroupContainer"
                                  style="margin-bottom: 5px"
                                >
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i
                                        class="glyphicon glyphicon-envelope"
                                      ></i
                                    ></span>
                                    <vue-select
                                      v-model="sbu_name_value"
                                      :options="company_sbu_data"
                                      @select="employeesSbuId"
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
                                      v-model="unit_value"
                                      :options="unit_data"
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
                                      v-model="sub_unit_value"
                                      :options="sub_unit_data"
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
                                      v-model="department_name_value"
                                      :options="department_data"
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

                              <div class="col-md-2">
                                <label
                                  class="control-label"
                                  style="margin-bottom: 5px"
                                >
                                  Shift
                                </label>
                                <div
                                  class="inputGroupContainer"
                                  style="margin-bottom: 5px"
                                >
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i
                                        class="glyphicon glyphicon-envelope"
                                      ></i
                                    ></span>
                                    <vue-select
                                      v-model="employee_shift_value"
                                      :options="employeeShift"
                                      @select="onSelectEmployeeShift"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <label
                                  class="control-label"
                                  style="margin-bottom: 5px"
                                >
                                  Product
                                </label>
                                <div
                                  class="inputGroupContainer"
                                  style="margin-bottom: 5px"
                                >
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i
                                        class="glyphicon glyphicon-envelope"
                                      ></i
                                    ></span>
                                    <vue-select
                                      v-model="product_data_value"
                                      :options="product_array"
                                      @select="onSelectProduct"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <label
                                  class="control-label"
                                  style="margin-bottom: 5px"
                                >
                                  Bundle
                                </label>
                                <div
                                  class="inputGroupContainer"
                                  style="margin-bottom: 5px"
                                >
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i
                                        class="glyphicon glyphicon-envelope"
                                      ></i
                                    ></span>
                                    <vue-select
                                      v-model="bundle_data_value"
                                      :options="bundle_array"
                                      @select="onSelectBundle"
                                      placeholder="Select one"
                                      label="text"
                                      track-by="text"
                                    ></vue-select>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <label
                                  class="control-label"
                                  style="margin-bottom: 5px"
                                >
                                  Product Grade
                                </label>
                                <div
                                  class="inputGroupContainer"
                                  style="margin-bottom: 5px"
                                >
                                  <div class="input-group">
                                    <span class="input-group-addon"
                                      ><i
                                        class="glyphicon glyphicon-envelope"
                                      ></i
                                    ></span>
                                    <vue-select
                                      v-model="product_grade_value"
                                      :options="product_grade_array"
                                      @select="onSelectProductGrade"
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
                                    :options="employee_data_approval"
                                    @select="onSelectEmployee"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                              <div class="form-group col-md-2">
                                <label
                                  class="control-label"
                                  style="margin-bottom: 5px"
                                >
                                  From Date
                                </label>
                                <datepicker
                                  placeholder="Select Date"
                                  v-model="from_date"
                                  class="form-control"
                                ></datepicker>
                              </div>

                              <div class="form-group col-md-2">
                                <label
                                  class="control-label"
                                  style="margin-bottom: 5px"
                                >
                                  To Date
                                </label>
                                <datepicker
                                  placeholder="Select Date"
                                  v-model="to_date"
                                  class="form-control"
                                ></datepicker>
                              </div>
                              <div
                                class="col-md-1 float-right"
                                style="margin-bottom: 5px; margin-top: 8px"
                              >
                                <a
                                  id="addCF"
                                  @click="daily_production"
                                  class="btn btn-xs btn-success"
                                  style="margin-top: 8px; padding: 10px 6px"
                                  ><i class="fa fa-search" style="color: #fff">
                                    Search</i
                                  ></a
                                >
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="float-right">
                      <button @click="tableToExcel()" class="btn-info">
                        Excel
                      </button>
                      <button @click="printDiv()" class="btn-success">
                        Print
                      </button>
                    </div>
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
                                 {{optionData.report_title}}
                                </h5>
                                <h6
                                  v-if="from_date != '' && to_date != ''"
                                  class="text-center"
                                  style="text-align: center !important"
                                >
                                {{optionData.report_name}}
                                 
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
                                  {{optionData.reportDate}}
                                </p>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <table
                        id="employeeTable"
                        class="table table-bordered table-striped employeeTable"
                      >
                        <thead>
                          <tr class="text-center">
                            <th class="ths">SL</th>
                            <th class="ths">ID No.</th>
                            <th class="ths" style="width: 15%">Name</th>
                            <th class="ths" style="width: 95px">Date</th>
                            <th class="ths">Shift</th>
                            <th class="ths">Product</th>
                            <th class="ths">Bundle</th>
                            <th class="ths">Grade</th>
                            <th class="ths">Machine</th>
                            <th class="ths">Line</th>
                            <th class="ths">Quantity</th>
                            <th class="ths">OT Qty</th>
                            <th class="ths">Rate</th>
                            <th class="ths">Amount</th>
                          </tr>
                        </thead>
                        <tbody class="text-left">
                          <tr
                            v-for="(data, index) in daily_production_data"
                            :key="index"
                          >
                            <td class="ths">{{ index + 1 }}</td>
                            <td class="ths">
                              {{
                                data.joinemployee
                                  ? data.joinemployee.employee_id_no
                                  : ""
                              }}
                            </td>
                            <td class="ths">
                              {{
                                data.joinemployee
                                  ? data.joinemployee.employee_fullname
                                  : ""
                              }}
                            </td>
                            <td class="ths">{{ data.production_date }}</td>
                            <td class="ths text-center ">
                              {{ data.joinshift ? data.joinshift.title : "" }} 
                            </td>
                            <td class="ths">
                              {{
                                data.joinproduct
                                  ? data.joinproduct.product_name
                                  : ""
                              }}
                            </td>
                            <td class="ths">
                              {{
                                data.joinbundle
                                  ? data.joinbundle.bundle_name
                                  : ""
                              }}
                            </td>
                            <td class="ths text-center">
                              {{
                                data.joingrade ? data.joingrade.grade_name : ""
                              }}
                            </td>
                            <td class="ths ">
                              {{
                                data.joinmachine
                                  ? data.joinmachine.machine_name
                                  : ""
                              }}
                            </td>
                            <td class="ths">
                              {{ data.joinline ? data.joinline.line_name : "" }}
                            </td>
                            <td class="ths text-center">{{ data.product_quantity }}</td>
                            <td class="ths text-center">{{ data.product_qt_quantity }}</td>
                            <td class="ths text-right">{{ data.product_rate }}</td>
                            <td class="ths text-right">{{ data.amount | number('0,0.00') }}</td>
                          </tr>
                          <tr>
                            <th colspan="10" class="ths text-center">{{ "Total" }}</th>
                            <th class="ths text-center">{{ quantity || 0  | number('0,0.00')}}</th>
                            <th class="ths text-center">{{ oTQty || 0 | number('0,0.00')}}</th>
                            <th colspan="2" class="ths text-right">{{ total_amount || 0 | number('0,0.00') }}</th>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="float-right">
                  <button @click="tableToExcel()" class="btn-info">
                    Excel
                  </button>
                  <button @click="printDiv()" class="btn-success">Print</button>
                </div>
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
import Datepicker from "vuejs-datepicker";
import * as xlsx from 'xlsx/xlsx';

export default {
  data() {
    return {
      page_loading: true,
      from_date: "",
      sbu_id: "",
      machine_id: "",
      line_id: "",
      shift_id: "",
      grade_id: "",
      bundle_id: "",
      product_id: "",
      to_date: "",
      optionData: {},
      click_data: [],
      company_sbu_data: "",
      employeeShift: "",
      product_array: "",
      bundle_array: "",
      unit_data:"",
      sub_unit_data:"",
      unit_data:"",
      product_grade_array: "",
      employee_data_approval:'',
      daily_production_data: [],
      employee_name_value: "",
      product_data_value: "",
      approvalnamevalue1: "",
      employee_shift_value: "",
      bundle_data_value: "",
      product_grade_value: "",
      line_data_value: "",
      machine_data_value: "",
      shift_name: "",
      bundle_name: "",
      grade_name: "",
      employee_id:'',
      line_name: "",
      machine_name: "",
      product_name: "",
      production_quantity: "",
      production_qt_quantity: "",
      sbu_name_value: null,
      product_rate: "",
      bundle_id: "",
      department_name_value : '',
      sub_unit_value : '',
      unit_value : '',  
      quantity:0,
      oTQty:0,
      total_amount:0,
    };
  },

  created() {
    this.daily_production();
  },
  components: {
    pageLoading: Loading,
  },
  methods: {
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
      var toExcel = document.getElementById("employeeTable").innerHTML;
      var ctx = {
        worksheet: name || "",
        table: toExcel,
      };
      var link = document.createElement("a");
      link.download = "export.xls";
      link.href = uri + base64(format(template, ctx));
      link.click();
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
      $(".text-center").each(function () {
        this.style.setProperty("text-align", "center", "important");
      });
       $(".text-right").each(function () {
        this.style.setProperty("text-align", "right", "important");
      });
      $(".ths").each(function () {
        this.style.setProperty("border", "1px solid #dee2e6", "important");
        this.style.setProperty("padding", "5px 5px", "important");
        this.style.setProperty("border-collapse", "collapse", "important");
      });
      let contents = document.getElementById("printable").innerHTML;

      let frame1 = document.createElement("iframe");
      frame1.name = "frame1";
      document.body.appendChild(frame1);
      let frameDoc = frame1.contentWindow
        ? frame1.contentWindow
        : frame1.contentDocument.document
        ? frame1.contentDocument.document
        : frame1.contentDocument;
      frameDoc.document.open();
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
    onSelectEmployeeShift(option) {
      // this.shift_id= option.id;
      this.shift_name = option.text;
      this.shift_id = option.id;
      console.log(option);
    },
    onSelectEmployee(option) {
      // alert('s')
      console.log(option);
      this.form_data.employee_id = option.id;
      this.employee_id = option.id;
      console.log(this.form_data.employee_id);
    },
    onSelectProduct(option) {
      // this.product_id= option.id;
      this.product_name = option.text;
      this.product_id = option.id;
    },
    onSelectBundle(option) {
      // this.bundle_id= option.id;
      this.bundle_name = option.text;
      this.bundle_id = option.id;
    },
    onSelectDepartment(option){
      console.log(option);
      this.form_data.employee_department= option.id;
      console.log(this.form_data.employee_department);
    },
     employeesUnit(option){
      this.form_data.employee_unit= option.id;
    },
    employeesSubUnit(option){
       this.form_data.employee_sub_unit= option.id;
    },
    onSelectProductGrade(option) {
      // this.grade_id= option.id;
      this.grade_name = option.text;
      this.grade_id = option.id;
      this.product_rate = option.product_rate;
      amount: (+product_quantity + +product_qt_quantity) * +product_rate || 0;
      // console.log( this.product_rate);
    },
    onSelectProductGrade1(option, event, formData) {
      // this.grade_name = option.text;
      // this.grade_id = option.id;
      // this.product_rate = option.product_rate;
      // console.log(option);
      formData.grade_id = formData.gradeData.id;
      formData.grade_name = formData.gradeData.text;
      // console.log(formData.gradeData.product_rate);
      formData.product_rate = formData.gradeData.product_rate;
      formData.amount =
        (+formData.product_quantity + +formData.product_qt_quantity) *
          +formData.gradeData.product_rate || 0;
      // console.log(formData);
    },
    onSelectLine(option) {
      // this.line_id= option.id;
      this.line_name = option.text;
      this.line_id = option.id;
    },
    onSelectMachine(option) {
      // this.machine_id= option.id;
      this.machine_name = option.text;
      this.machine_id = option.id;
    },
    employeesSbuId(option) {
      this.sbu_id = option.id;
    },
    showModel_aa(data) {
      this.click_data = data;
      this.$modal.show("myModal");
    },
    hideModel_aa() {
      this.$modal.hide("myModal");
    },
    daily_production() {
       this.page_loading = false;
       this.modal_loading = false;
      let data = {
        from_date: this.from_date,
        to_date: this.to_date,
        sbu_id: this.sbu_id,
        shift_id: this.shift_id,
        product_id: this.product_id,
        bundle_id: this.bundle_id,
        grade_id: this.grade_id,
        line_id: this.line_id,
        employee_id: this.employee_id,
        machine_id: this.machine_id,
        department_name_value: this.department_name_value,
        sub_unit_value : this.sub_unit_value, 
        unit_value : this.unit_value, 
        employee_sub_unit : this.form_data.employee_sub_unit,   
        employee_unit : this.form_data.employee_unit,
        employee_department : this.form_data.employee_department,
      };
      let urls = URL.baseUrl("daily_production_report");
      axios
        .get(urls, {
          params: data,
        })
        .then((res) => {
          if (res.data.status == "logout") {
            window.location.href = res.data.url;
          } else {
           
            this.optionData = res.data;
            this.daily_production_data = res.data.employee_data_list;
            this.company_sbu_data = res.data.company_sbu_data;
            this.employeeShift = res.data.employeeShift;
            this.product_array = res.data.product_array;
            this.bundle_array = res.data.bundle_array;
            this.product_grade_array = res.data.product_grade_array;
            this.employee_data_approval = res.data.employee_data_approval;
            this.department_data = res.data.department_data;
            this.sub_unit_data = res.data.sub_unit_data;
            this.unit_data = res.data.unit_data;
            this.quantity = res.data.quantity;
            this.oTQty = res.data.oTQty;
            this.total_amount =res.data.total_amount;
            console.log(res.data.company_sbu_data);
            console.log(this.optionData.company_sbu_data);
            this.page_loading = true;
            this.modal_loading = true;
          }
        })

        .catch((error) => {
          console.log(error);
          this.showToster({ status: 0, message: "opps! something went wrong" });
        });
    },
  },
};
</script>
<style type="text/css">
.salaryTable.table td {
  padding: 15px 5px;
}
</style>