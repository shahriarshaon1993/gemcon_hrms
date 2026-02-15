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
                               <h3 class="card-title d-none d-md-block">Insurance Report</h3>
                               <!-- <span class="float-sm-right" style="float: right;">
                                 <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                               </span> -->
                           </div>
                       </div>
                    </div>
                    <div class="card-body col-md-12">
                      <div class="row col-md-12">
                        <div class="row col-md-12">
                            <div class="form-group col-md-2 float-left" style="padding:0px;">
                              <label class="col-md-12 control-label" style="margin:0px;">Insurance Eligible Type</label>
                              <div class="col-md-12 inputGroupContainer input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <select v-model="employee_ins_eligible_value"  @change="onEmployeeEligible($event)" name="typ" class="form-control" style="font-size: 14px; height: 30px;">
                                    <option value="0" disabled>-- Select Status --</option>
                                    <option value="1">Eligible</option>
                                    <option value="2">Inclusion</option>
                                    <option value="3">Exclusion</option>
                                  </select>
                              </div>
                            </div>
                            <div class="form-group col-md-2 float-left" style="padding:0px;">
                              <label class="col-md-12 control-label" style="margin:0px;">Status</label>
                              <div class="col-md-12 inputGroupContainer input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <select v-model="employee_status_value"  @change="EmplysStatus($event)" name="typ" class="form-control" style="font-size: 14px; height: 30px;">
                                      <option value="4" disabled>-- Select Status --</option>
                                      <option value="5"> All </option>
                                      <option value="1">Active</option>
                                      <option value="0">Inactive</option>
                                      <option value="2">Resigned</option>
                                  </select>
                              </div>
                            </div>
                          <div class="form-group col-md-2 float-left" style="padding:0px;">
                            <label class="col-md-12 control-label" style="margin:0px;">Date Range</label>
                            <div class="col-md-12 inputGroupContainer input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <select v-model="date_range_value"  @change="DateRange($event)" name="typ" class="form-control" style="font-size: 14px; height: 30px;">
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                          </div>
                          <div class="form-group col-md-2 float-left" style="padding:0px;"  v-if="this.date_range_value==1">
                              <label class="col-md-12 control-label">From</label>
                              <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group calendar_left">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <datepicker placeholder="Select Date" v-model="from_date" class="form-control1" required></datepicker>
                                </div>
                              </div>
                          </div>
                            <div class="form-group col-md-2 float-left" style="padding:0px;"  v-if="this.date_range_value==1 || 2">
                              <label class="col-md-12 control-label">To</label>
                              <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group calendar_left">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <datepicker placeholder="Select Date" v-model="to_date"   class="form-control1" required></datepicker>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row report-box col-md-12">
                            <div class="form-group col-md-2" style="max-width: 11%">
                              <label class="col-md-12 control-label"
                                >SBU <sup style="color: red; top: -2px">*</sup></label
                              >
                              <div
                                class="col-md-12 inputGroupContainer"
                                style="padding: 0px"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbu" placeholder="Select one" label="text" track-by="text"></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
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
                                    v-model="sub_unit_value"
                                    :options="option_data.sub_unit_data"
                                    @select="employeesSubUnit"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
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
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
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
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
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
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
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
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div
                              class="form-group col-md-2"
                              id="employee_wise_show"
                              style="max-width: 11%"
                            >
                              <label class="col-md-12 control-label">Employee</label>
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
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-md-1 float-right"
                              style="max-width: 6%; padding: 18px 0px"
                            >
                              <span v-if="employeesSbu">
                                <a @click="findInsuranceReport($event)" id="addCF" class="btn btn-xs " style="color: #212529 !important;padding: .3rem .25rem;background-color: #fac23c;border-color: #fac23c;"><i class="fa fa-search" style="color: #212529 !important;background-color: #fac23c;border-color: #fac23c;"></i> Search </a>
                              </span>
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
      <!-- v-if="form_data.payroll_employee_data" -->
        <section class="content"  v-if="form_data.insurance_info">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body col-md-12">
                      <div class="row col-md-12" v-if="(form_data.insurance_info).length > 0">
                        <!-- <form @submit.prevent="add({add:'add/weeklypayrollprocess'})"  id="validate-1" style="overflow-x: scroll;" > -->
                          <div class="col-12">
                            <button id="btnExport"  @click="tableToExcel" class="btn-success float-right" style="margin-left:10px;">Export</button>
                            <button @click="printDiv()" class="btn-info float-right">Print</button>
                          </div>
                          <div class="col-md-12" id="printable">
                            <div class=" " style="min-height: 56px;" v-if="modal_loading">
                            <div class="col-md-12">
                              <h4 class="text-center" style="margin:0px;">Gemcon Group</h4>
                              <p class="text-center" style="margin:0px;">List of Employees Entitled for insurance</p>
                              <p class="text-center" style="margin:0px;">Date: {{form_data.report_print_date}}</p>
                              <p class="text-right" style="margin:0px; font-weight: bold;">Total: {{form_data.total_insurance_employee}}</p>
                            </div>
                            <table id="employeeTable_ids" class="table table-bordered  table-striped employeeTable" style="table-layout:fixed;width: 100% !important">
                              <thead>
                                <tr style="text-align: center;">
                                  <th style="vertical-align: middle;width: 50px" >SL</th>
                                  <th style="vertical-align: middle;width: 120px;" >Employee ID</th>
                                  <th style="vertical-align: middle;width: 200px;" >Employee Name</th>
                                  <th style="vertical-align: middle;width: 200px;" >Designation</th>
                                  <th style="vertical-align: middle;width: 200px;" >Work Location</th>
                                  <th style="vertical-align: middle;width: 200px;"  >Date of Joining</th>
                                  <th style="vertical-align: middle;width: 100px;" >LOS</th>
                                  <th style="vertical-align: middle;width: 200px;" >Date of Birth</th>
                                  <th style="vertical-align: middle;width: 100px;" >AGE</th>
                                  <th style="vertical-align: middle;width: 100px;" >Category</th>
                                  <th style="vertical-align: middle;width: 100px;" >Type</th>
                                  <th style="vertical-align: middle;width: 90px;" >Grade</th>
                                  <th style="vertical-align: middle;width: 150px;" >Insurance Amount</th>
                                  <th style="vertical-align: middle;width: 150px;" >Yearly Premium Cost</th>
                                  <th style="vertical-align: middle;width: 200px;" >SBU of Gemcon Group</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="(form_data, index) in form_data.insurance_info" v-bind:key="form_data.id" >
                                  <td class="text-center">{{index+1}}</td>
                                  <td class="text-center"> {{form_data.employee_id_no}}</td>
                                  <td>{{form_data.employee_fullname}}</td>
                                  <td>{{form_data.designation_name}}</td>
                                  <td>{{form_data.work_location_name}}</td>
                                  <td class="text-center">{{form_data.employee_joining_date}}</td>
                                  <td class="text-center">{{form_data.service_length}}</td>
                                  <td class="text-center">{{form_data.employee_dob}}</td>
                                  <td class="text-center">{{form_data.employee_age}}</td>
                                  <td class="text-center">
                                    <span v-if="form_data.emplyee_category_mgt_non_mgt == 1">
                                      {{ 'Management' }}
                                    </span>
                                    <span v-else-if="form_data.emplyee_category_mgt_non_mgt == 2">
                                      {{ 'Non-Management' }}
                                    </span>
                                    <span v-else>
                                      {{ '-' }}
                                    </span>
                                  </td>
                                  <td class="text-center">
                                    <span v-if="
                                      form_data.employee_type == 1
                                    ">{{ "Permanent" }}</span>
                                    <span v-else-if="
                                      form_data.employee_type == 2
                                    ">{{ "Probationary" }}</span>
                                    <span v-else-if="
                                      form_data.employee_type == 3
                                    ">{{ "Cotractual" }}</span>
                                    <span v-else-if="
                                      form_data.employee_type == 6
                                    ">{{ "Casual" }}</span>
                                    <span v-else-if="
                                      form_data.employee_type == 4
                                    ">{{ "Temporary" }}</span>
                                    <span v-else-if="
                                      form_data.employee_type == 5
                                    ">{{ "Intern" }}</span>
                                  </td>
                                  
                                  <td class="text-center">{{form_data.jobgrade_name}}</td>
                                  <td class="text-right">{{form_data.insurance_amount |number('0,0.00')}}</td>
                                  <td class="text-right">{{form_data.yearly_premium_cost |number('0,0.00') }}</td>
                                  <td>{{form_data.employee_sbu}}</td>
                                </tr>
                              </tbody>
                            </table>
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
           to_date: new Date(),
           personal_email_id:'',
           date_range_value:2,
           employee_status_value:5,
           employees_list:[],
           employee_ins_eligible_value: 1,
           insurance_eligible_type:'',
         }
       },
        created(){
            this.getResults(1);
            this.modal_loading= true;
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
        updateCountry (form_data,shift) {
          form_data.shift =shift ;
        },
        addRow(event,approval_infos) {
            var aaa= this.form_data.approval_infos.length;
            this.form_data.approval_infos.push({
                permission_id:this.permission_id,
                permission_type:this.noticeToType,
                permission_type_name:this.noticeToTypeName,
                permission_id_name:this.permission_id_name,
            })
            console.log(this.form_data.approval_infos);
        },
        deleteRow(index) {
          this.form_data.approval_infos.splice(index,1);
        },
        monthlySelect(event){
          if(event.target.value==1){
            this.weekly_id=0;
          }else{
            this.weekly_id=1;
          }
        },
        weekSelect(event){
          this.weeks_id=event.target.value;
        },
        monthsSelectsId(event){
            this.months_id=event.target.value;
        }, 
        SalaryTypeId(event){
            this.salary_type_id=event.target.value;
        }, 
        SalaryGrade(event){
            this.salary_grade=event.target.value;
        },
        WeeklyProcessType(event){
            this.process_type=event.target.value;
        },
        onEmployeeEligible(event){
            this.insurance_eligible_type = event.target.value;
        },
        EmplysStatus(event){
            this.employee_status=event.target.value;
        },
        findInsuranceReport(event){
          this.modal_loading= false;
          let uri = URL.baseUrl('insurance_report/finding');
          axios.post(uri,
            {
              id: this.sbu_id,
              unit_id: this.unit_id,
              subunit_id: this.subunit_id,
              department_id: this.department_id,
              section_id: this.section_id,
              subsection_id: this.subsection_id,
              employee_work_location: this.employee_work_location,
              employeeId:this.employee_id,
              from_date:this.from_date,
              to_date:this.to_date,
              insurance_eligible_type:this.insurance_eligible_type,
              employee_status:this.employee_status_value,
              date_range_value:this.date_range_value,
            }).then(res => {
              console.log(res);
              this.form_data=res.data;
              this.modal_loading= true;
            })
            .catch(error => {
              this.modal_loading= true;
          })
        },
        onSelectJobGrade(option){
          console.log(option);
          this.form_data.employee_job_grade= option.id;
          this.permission_id=option.id;
          this.permission_id_name=option.text;
          console.log(this.form_data.employee_job_grade);
        },
        onSelectEmployee(option){
          console.log(this.employee_id);
          this.form_data.employee_id = option.id;
          this.employee_id = option.id;
          this.permission_id=option.id;
          this.permission_id_name=option.text;
        },  
       setModalData(){
         this.sbu_name_value=this.form_data.sbu_name_value;
         this.section_value=this.form_data.section_value;
         this.sub_section_value=this.form_data.sub_section_value;
         this.employee_group_value=this.form_data.employee_group_value;
         this.department_name_value=this.form_data.department_name_value;
         this.designation_name_value=this.form_data.designation_name_value;
         this.jobgrade_name_value=this.form_data.jobgrade_name_value;
         this.sub_unit_value=this.form_data.sub_unit_value;
         this.employee_name_value=this.form_data.employee_name_value;
         this.work_location_value=this.form_data.work_location_value;
         this.general_data_temp=this.form_data.general_info_temp;
         this.form_data.employee_status=this.form_data.employee_status;
       },
       resetModal(){
           this.sbu_name_value='';
           this.section_value='';
           this.sub_section_value='';
           this.employee_group_value='';
           this.department_name_value='';
           this.designation_name_value='';
           this.jobgrade_name_value='';
           this.unit_value='';
           this.sub_unit_value='';
           this.employee_name_value='';
           this.work_location_value='';
          //  this.form_data.employee_status='1';
           this.form_data.emplyee_category_mgt_non_mgt='2';
           this.form_data.employee_leave_group='1';
           this.form_data.employee_type='2';
           this.form_data.make_user='';
           this.form_data.user_type='0'
           this.form_data.ea_approve_by_name='';
           this.form_data.employee_mobile='';
           this.form_data.employee_id='';
           this.form_data.employee_number='';
           this.form_data.employee_fullname='';
           this.form_data.employee_joining_date='';
           this.form_data.employee_image='';
           this.form_data.make_user='';
           this.approvalnamevalue1="";
           this.form_data.employee_status='';
     },

     notice_to(event){
     	console.log(event.target.name);
     	if (event.target.value==1) {
     		this.noticeToType=1;
        this.noticeToTypeName='Company/SBU';
     	}else if(event.target.value==2){
     		this.noticeToType=2;
        this.noticeToTypeName='Department';
     	}else if(event.target.value==3){
     		this.noticeToType=3;
        this.noticeToTypeName='Unit';
     	}else if(event.target.value==4){
     		this.noticeToType=4;
        this.noticeToTypeName='Sub Unit';
     	}else if(event.target.value==5){
     		this.noticeToType=5;
        this.noticeToTypeName='Section';
     	}else if(event.target.value==6){
     		this.noticeToType=6;
        this.noticeToTypeName='Sub Section';
     	}else if(event.target.value==7){
     		this.noticeToType=7;
        this.noticeToTypeName='Employee';
     	}
     }
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
