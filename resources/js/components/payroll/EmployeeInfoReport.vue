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
                               <h3 class="card-title d-none d-md-block">Employee Info Reports</h3>
                           </div>
                       </div>
                    </div>
                    <div class="card-body col-md-12">
                      <!-- <div class="col-md-12">
                          <div class="row" style="margin:10px 0px;">
                             <div class="input-group" >
                                <div class="form-group col-md-3 float-left" style="padding:0px;">
                                    <label class="col-md-12 control-label">From</label>
                                    <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <datepicker placeholder="Select Date" v-model="form_data.from_date" class="form-control"></datepicker>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group col-md-3 float-left" style="padding:0px;">
                                    <label class="col-md-12 control-label">To</label>
                                    <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <datepicker placeholder="Select Date" v-model="form_data.to_date"   class="form-control"></datepicker>
                                      </div>
                                    </div>
                                  </div>
                            </div> 
                        </div>
                      </div> -->
                 <div class=" col-md-12">
                   <div class="row report-box">
                      <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 9.5%">
                        <label class="col-md-12 control-label">Company/SBU <span style="color:red;">*</span></label>
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
                   
                       <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 9.5%">
                        <label class="col-md-12 control-label">Department</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="form_data.department_name_value" :options="form_data.department_data" @select="onSelectDepartment" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>
                      <div  class="form-group col-md-2 float-left" style="padding:0px;max-width: 9.5%">
                        <label class="col-md-12 control-label">Section</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="form_data.section_value" :options="form_data.section_data" @select="employeesSection" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>
                      <div  class="form-group col-md-2 float-left" style="padding:0px;max-width: 9.5%">
                        <label class="col-md-12 control-label">Sub Section</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="form_data.sub_section_value" :options="form_data.sub_section_data" @select="employeesSubSection" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 9.5%">
                          <label class="col-md-12 control-label">Work Location</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="form_data.work_location_value" :options="form_data.work_location_data" @select="employeesWorkLocation" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>

                     
                      <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 9.5%">
                        <label class="col-md-12 control-label">Designation</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <vue-select v-model="form_data.designation_name_value" :options="option_data.designation_data" @select="onSelectDesignation" placeholder="Select one"  multiple="multiple" label="text" track-by="text">
                              </vue-select>
                          </div>
                        </div>
                      </div>

                      <!-- <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 9.5%">
                        <label class="col-md-12 control-label">Employees</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                            <vue-select v-model="employee_name_value" :options="form_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                          </div>
                        </div>
                      </div> -->
                      <div class="form-group col-md-2 float-left" style="padding:0px;max-width: 9.5%">
                        <label  class="col-md-12" style="margin:1px;">Status</label>
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                              <select v-model="form_data.employee_status"  @change="EmplysStatus($event)" name="typ" class="form-control" style="font-size: 14px; height: 30px;">
                                <option value="0" disabled>-- Select Status --</option>
                                  <option> All </option>
                                  <option value="1">Active</option>
                                  <option value="3">Inactive</option>
                                  <option value="2">Resign</option>
                              </select>
                          </div>
                        </div>
                      </div>
                   </div>
                    <div class="col-md-1 float-right" style="max-width: 6%; padding: 18px 0px" >
                        <span v-if="employeesSbu">
                          <a @click="findReport($event)" id="addCF" class="btn btn-xs " style="color: #212529 !important;padding: .3rem .25rem;background-color: #fac23c;border-color: #fac23c;"><i class="fa fa-search" style="color: #212529 !important;background-color: #fac23c;border-color: #fac23c;"></i> Search </a>
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
      <!-- v-if="form_data.payroll_employee_data" -->
        <section class="content"  v-if="form_data.employee_infos">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body col-md-12">
                      <div class="row col-md-12" v-if="(form_data.employee_infos).length > 0">
                          <div class="col-12">
                            <button id="btnExport"  @click="tableToExcel" class="btn-success float-right" style="margin-left:10px;">Export</button>
                            <button @click="printDiv()" class="btn-info float-right">Print</button>
                          </div>
                          <div class="col-md-12" id="printable">
                            <div class=" " style="min-height: 56px;" v-if="modal_loading">
                            <div  id="printable">
                              <div class="col-md-12">
                                <h4 class="text-center" style="margin:0px;">{{form_data.report_hade.sbu_name}}</h4>
                                <p class="text-center" style="margin:0px;">Details Employee Info</p>
                                <p class="text-center" style="margin:0px;">Date: {{form_data.report_hade.report_print_date}}</p>
                              </div>
                              <table id="employeeTable_ids" class="table table-bordered  table-striped employeeTable" style="table-layout:fixed;width: 100% !important">
                                <thead>
                                  <tr style="text-align: center;">
                                    <th style="vertical-align: middle;width: 50px" >SL</th>
                                    <th style="vertical-align: middle;width: 120px;">Employee ID</th>
                                    <th style="vertical-align: middle;width: 200px;"> Name</th>
                                    <th style="vertical-align: middle;width: 200px;">Designation</th>
                                    <th style="vertical-align: middle;width: 200px;">Department</th>
                                    <th style="vertical-align: middle;width: 200px;">Section</th>
                                    <th style="vertical-align: middle;width: 200px;">Sub Section</th>
                                    <th style="vertical-align: middle;width: 200px;">Work Location</th>
                                    <th style="vertical-align: middle;width: 200px;">SBU</th>
                                    <th style="vertical-align: middle;width: 90px;">Grade New</th>
                                    <th style="vertical-align: middle;width: 90px;">Salary (Tk.)</th>
                                    <th style="vertical-align: middle;width: 200px;">Date of Joining</th>
                                    <th style="vertical-align: middle;width: 200px;">Length of Service (Year)</th>
                                    <th style="vertical-align: middle;width: 200px;">Years of Experience</th>
                                    <th style="vertical-align: middle;width: 200px;">Permanent Address (C/O or House No. or 1st Line)</th>
                                    <th style="vertical-align: middle;width: 100px;">Village</th>
                                    <th style="vertical-align: middle;width: 200px;">P.O</th>
                                    <th style="vertical-align: middle;width: 100px;">P.S</th>
                                    <th style="vertical-align: middle;width: 150px;">Home District</th>
                                    <th style="vertical-align: middle;width: 150px;">Present Address (C/O or House No. or 1st Line)</th>
                                    <th style="vertical-align: middle;width: 200px;">Mobile No.</th>
                                    <th style="vertical-align: middle;width: 200px;">Short/Nick Name</th>
                                    <th style="vertical-align: middle;width: 200px;">Date of Birth</th>
                                    <th style="vertical-align: middle;width: 200px;">Age (on today)</th>
                                    <th style="vertical-align: middle;width: 200px;">Blood Group</th>
                                    <th style="vertical-align: middle;width: 200px;">Gender</th>
                                    <th style="vertical-align: middle;width: 200px;">Educational Qualification</th>
                                    <th style="vertical-align: middle;width: 200px;">National ID No.</th>
                                    <th style="vertical-align: middle;width: 200px;">Passport</th>
                                    <th style="vertical-align: middle;width: 200px;">Employment Status</th>
                                    <th style="vertical-align: middle;width: 200px;">Mgt./Non-Mgt.</th>
                                    <th style="vertical-align: middle;width: 200px;">Reporting Supervisor's ID</th>
                                    <th style="vertical-align: middle;width: 200px;">Reporting Supervisor's Name</th>
                                    <th style="vertical-align: middle;width: 200px;">Remarks</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(form_data, index) in form_data.employee_infos" v-bind:key="form_data.id" >
                                    <td class="text-center">{{index+1}}</td>
                                    <td class="text-center"> {{form_data.employee_id_no}}</td>
                                    <td>{{form_data.employee_fullname}}</td>
                                    <td>{{form_data.designation_name}}</td>
                                    <td>{{form_data.department_name}}</td>
                                    <td>{{form_data.section_name}}</td>
                                    <td>{{form_data.sub_section_name}}</td>
                                    <td>{{form_data.work_location_name}}</td>
                                    <td>{{form_data.sbu_name}}</td>
                                    <td class="text-center">{{form_data.jobgrade_name}}</td>
                                    <td class="text-right">{{form_data.gross_salary |number('0,0.00') }}</td>
                                    <td class="text-center">{{form_data.employee_joining_date}}</td>
                                    <td class="text-center">{{form_data.service_length}}</td>
                                    <td class="text-center">{{form_data.service_length}}</td>
                                    <td>
                                      <span v-if="form_data.permanent_holding_no">{{form_data.present_holding_no}}</span>
                                      <span v-if="form_data.permanent_house_name">, {{form_data.permanent_house_name}}</span>
                                      <span v-if="form_data.permanent_road_no">, {{form_data.permanent_road_no}}</span>
                                      <span v-if="form_data.permanent_road_name">, {{form_data.permanent_road_name}}</span>
                                    </td>
                                    <td>{{form_data.permanent_vill_area}}</td>
                                    <td>{{form_data.permanent_post_office}}</td>
                                    <td>{{form_data.permanent_thana}}</td>
                                    <td>{{form_data.district_name}}</td>
                                    <td>
                                      <span v-if="form_data.present_holding_no">{{form_data.present_holding_no}}</span>
                                      <span v-if="form_data.present_house_name">, {{form_data.present_house_name}}</span>
                                      <span v-if="form_data.present_road_no">, {{form_data.present_road_no}}</span>
                                      <span v-if="form_data.present_road_name">, {{form_data.present_road_name}}</span>
                                    </td>
                                    <td class="text-center">{{form_data.mobile_no}}</td>
                                    <td class="text-center">{{form_data.employee_nick_name}}</td>
                                    <td class="text-center">{{form_data.employee_dob}}</td>
                                    <td class="text-center">{{form_data.employee_age}}</td>
                                    <td class="text-center">{{form_data.employee_blood_group}}</td>
                                    <td class="text-center">{{form_data.employee_gender}}</td>
                                    <td>{{form_data.eeq_degree_name}}</td>
                                    <td>{{form_data.nid_number}}</td>
                                    <td>{{form_data.passport_number}}</td>
                                    <td class="text-center">{{form_data.employee_status}}</td>
                                    <td>{{form_data.emplyee_category_mgt_non_mgt}}</td>
                                    <td>{{form_data.reporting_to}}</td>
                                    <td class="text-center">{{form_data.reporting_to_id}}</td>
                                    <td></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                         <div v-if="!modal_loading">
                            <pageLoading></pageLoading>
                        </div>
              </div>
            <!-- </form> -->
        </div>
        <div class="row col-md-12" v-else>
            <h4 style="color: darkgrey;">No Data Found ! </h4>
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
      <div v-if="!modal_loading">
          <pageLoading></pageLoading>
      </div>
    </div>
    </div>
    <div v-if="!page_loading">
        <pageLoading></pageLoading>
    </div>
</div>
</template>
<script>
    import Loading from '../Loading.vue';
    import $ from 'jquery'
    import VueTimepicker from 'vue2-timepicker'
    // CSS
    import 'vue2-timepicker/dist/VueTimepicker.css'   
    export default {
       data(){
         return{
           sbu_name_value:'',
           section_value:'',
           sub_section_value:'',
           employee_group_value:'',
           unit_value:'',
           make_user:0,
           employeesName:'',
           employees_ids:'',
           employee_id:'',
           datesList:'',
           url: null,
           sub_unit_value:'',
           work_location_value:'',
           department_name_value:'',
           designation_name_value:'',
           jobgrade_name_value:'',
           employee_name_value:'',
           sub_unit_value:'',
           work_location_value:'',
           personal_email_id:'',
           from_date:'',
           to_date: '',
           personal_email_id:'',
           date_range_value:2,
           employee_status_value:5,
           employees_list:[],
         }
       },
        created(){
            this.getResults(1);
            // this.modal_loading= true;
        },
        components:{
            pageLoading:Loading,
            VueTimepicker 
        },
        computed: {
      options: () => countries,
    },
    methods:{
       printDiv() {
            $('h3').each(function() {
              this.style.setProperty('margin', '0px', 'important');
              this.style.setProperty('font-size', '1.75rem', 'important');
            });
             $('h4').each(function() {
              this.style.setProperty('margin', '0px', 'important');
              this.style.setProperty('font-size', '1.5rem', 'important');
            });
              $('h5').each(function() {
              this.style.setProperty('margin', '0px', 'important');
              this.style.setProperty('font-size', '1.25rem', 'important');
            });
            $('h6').each(function() {
              this.style.setProperty('margin', '0px', 'important');
              this.style.setProperty('font-size', '1rem', 'important');
            });
             $('.table-bordered').each(function() {
              this.style.setProperty('border', '1px solid #dee2e6', 'important');
              this.style.setProperty('padding', '5px .75rem', 'important');
              this.style.setProperty('border-collapse', 'collapse', 'important');
            });
            $('.ths').each(function() {
               this.style.setProperty('border', '1px solid #dee2e6', 'important');
              this.style.setProperty('padding', '5px 5px', 'important');
              this.style.setProperty('border-collapse', 'collapse', 'important');
            });
           let contents = document.getElementById("printable").innerHTML
            
             let frame1 = document.createElement('iframe');
             frame1.name = "frame1";
             frame1.style.position = "absolute";
             frame1.style.top = "-1000000px";
             document.body.appendChild(frame1);
             let frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
             frameDoc.document.open();
             frameDoc.document.write('<html lang="en"><head><title>Gemcon Group</title>');
             frameDoc.document.write('<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.0.0-alpha/fullcalendar.print.min.css"/>');
             frameDoc.document.write('</head><body>');
             frameDoc.document.write(contents);
             frameDoc.document.write('</body></html>');
             frameDoc.document.close();
             setTimeout(function () {
                 window.frames["frame1"].focus();
                 window.frames["frame1"].print();
                 document.body.removeChild(frame1);
             }, 500);
             return false;
         },
        tableToExcel(){
        var uri = 'data:application/vnd.ms-excel;base64,',
          template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64 = function(s) {
              return window.btoa(unescape(encodeURIComponent(s)))
            },
            format = function(s, c) {
              return s.replace(/{(\w+)}/g, function(m, p) {
                return c[p];
              })
            }
          var toExcel = document.getElementById("printable").innerHTML;
          var ctx = {
            worksheet: name || '',
            table: toExcel
          };
          var link = document.createElement("a");
          link.download = "export.xls";
          link.href = uri + base64(format(template, ctx))
          link.click();
  
        },


        findReport(event){
          this.modal_loading= false;
          // this.page_loading= false;
          let uri = URL.baseUrl('employee_get_report');
          axios.post(uri,
            {
              employee_department: this.form_data.employee_department,
              employee_designation: this.form_data.employee_designation,
              employee_sbu: this.form_data.employee_sbu,
              from_date: this.form_data.from_date,
              to_date: this.form_data.to_date,
              employee_section: this.form_data.employee_section,
              employee_sub_section: this.form_data.employee_sub_section,
              employee_department: this.form_data.employee_department,
              employee_designation: this.form_data.employee_designation,

              employee_name_value: this.form_data.employee_name_value,
              designation_name_value: this.form_data.designation_name_value,
              department_name_value: this.form_data.department_name_value,
              work_location_value: this.form_data.work_location_value,
              sbu_name_value: this.form_data.sbu_name_value,

              section_value: this.form_data.section_value,
              sub_section_value: this.form_data.sub_section_value,
              employee_status: this.form_data.employee_status,
              sub_unit_value: this.form_data.sub_unit_value,
              unit_value: this.form_data.unit_value,

            }).then(res => {
              console.log(res);
              //  this.getResults(1);
              this.form_data.employee_infos=res.data.employee_infos;
              this.form_data.report_hade=res.data.report_hade;
              this.modal_loading= true;
              // this.page_loading= true;
            })
            .catch(error => {
              this.modal_loading= true;
          })
        },


        onSelectAtt_status(option) {
      this.form_data.att_status = option;
    },
    onSelectOfficeTime(option) {
      this.form_data.OfficeTime = option;
    },
    jobgradeData(option) {
      this.form_data.employee_job_grade = option.id;
    },
    employeesGroup(option) {
      console.log(option);
      this.form_data.employee_group = option.id;
      console.log(this.form_data.employee_group);
    },
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


    setFormData() {
      // this.form_data.att_report_type = 0;
      // this.form_data.report_type = 0;
    },
        // onSelectJobGrade(option){
        //   console.log(option);
        //   this.form_data.employee_job_grade= option.id;
        //   this.permission_id=option.id;
        //   this.permission_id_name=option.text;
        //   console.log(this.form_data.employee_job_grade);
        // },
        // onSelectEmployee(option){
        //   console.log(this.employee_id);
        //   this.form_data.employee_id = option.id;
        //   this.employee_id = option.id;
        //   this.permission_id=option.id;
        //   this.permission_id_name=option.text;
        // },  
       setModalData(){
        //  this.sbu_name_value=this.form_data.sbu_name_value;
        //  this.section_value=this.form_data.section_value;
        //  this.sub_section_value=this.form_data.sub_section_value;
        //  this.employee_group_value=this.form_data.employee_group_value;
        //  this.department_name_value=this.form_data.department_name_value;
        //  this.designation_name_value=this.form_data.designation_name_value;
        //  this.jobgrade_name_value=this.form_data.jobgrade_name_value;
        //  this.sub_unit_value=this.form_data.sub_unit_value;
        //  this.employee_name_value=this.form_data.employee_name_value;
        //  this.work_location_value=this.form_data.work_location_value;
        //  this.general_data_temp=this.form_data.general_info_temp;
        //  this.form_data.employee_status=this.form_data.employee_status;
       },
    //    resetModal(){
    //        this.sbu_name_value='';
    //        this.section_value='';
    //        this.sub_section_value='';
    //        this.employee_group_value='';
    //        this.department_name_value='';
    //        this.designation_name_value='';
    //        this.jobgrade_name_value='';
    //        this.unit_value='';
    //        this.sub_unit_value='';
    //        this.employee_name_value='';
    //        this.work_location_value='';
    //        this.form_data.emplyee_category_mgt_non_mgt='2';
    //        this.form_data.employee_leave_group='1';
    //        this.form_data.employee_type='2';
    //        this.form_data.make_user='';
    //        this.form_data.user_type='0'
    //        this.form_data.ea_approve_by_name='';
    //        this.form_data.employee_mobile='';
    //        this.form_data.employee_id='';
    //        this.form_data.employee_number='';
    //        this.form_data.employee_fullname='';
    //        this.form_data.employee_joining_date='';
    //        this.form_data.employee_image='';
    //        this.form_data.make_user='';
    //        this.approvalnamevalue1="";
    //        this.form_data.employee_status='';
    //  },

   
	}
}
</script>
<style type="text/css">
  .employeeTable_ids.table th {
    padding: 4px 5px !important;
  }
  .div_class {
    margin-left: 193px;
    overflow-y: visible;
    padding: 0;
  }
  .headcol {
    position: absolute;
    width: 200px;
    left: 0;
    top: auto;
    border-top-width: 1px;
    margin-top: -1px;
  }
  .headcol:before {
    content: '';
  }
  .select_id > .multiselect > .multiselect__tags{
    min-height: 41px !important;
  }
  .calendar_left .vdp-datepicker__calendar{
    left: 3px !important;
  }
</style>
