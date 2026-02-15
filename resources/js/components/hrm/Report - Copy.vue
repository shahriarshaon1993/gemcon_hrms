<template>
<div>
    <div class="widget box">
        <div class="widget-header">
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                       <div class="row">
                           <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                               <h3 class="card-title d-none d-md-block">Reports</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <a @click="$router.go(-1)" class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                               </span>
                           </div>
                       </div>
                    </div> 
                    <div class="card-body row" style="padding-top:0px;">
                  <form @submit.prevent="add({add:'report/search'})">
                      <div class="col-md-12">
                            <div class="col-md-12" style="margin:10px 0px;">
                               <div class="input-group" >
                                <label class="col-md-2 control-label"><strong>Report Type</strong></label>
                                <div class="col-md-4" style="padding-left:0px;">
                                      <select v-model="report_data.report_type" name="typ" class="form-control" style="font-size: 14px; height: 30px;">
                                        <option value="0" selected="selected" disabled>--Select--</option>
                                         <option value="1">Attendance Report</option>
                                         <option value="2">Employees Report</option>
                                         <option value="3">Leave Report</option>
                                      </select>
                                </div>
                              </div> 
                          </div>
                          <div class="row report-box">
                            <div class="form-group col-md-3 float-left" style="padding:0px;">
                                <label class="col-md-12 control-label">Company/SBU</label>
                                <div class="col-md-12 inputGroupContainer">
                                   <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbu" placeholder="Select one" label="text" track-by="text"></vue-select>

                                  </div>
                                </div>
                             </div>
                             <div class="form-group col-md-3 float-left" style="padding:0px;">
                                <label class="col-md-12 control-label">Department</label>
                                <div class="col-md-12 inputGroupContainer">
                                   <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>

                                    <vue-select v-model="department_name_value" :options="option_data.department_data" @select="onSelectDepartment" placeholder="Select one" label="text" track-by="text"></vue-select>

                                  </div>
                                </div>
                             </div>
                             <div class="form-group col-md-3 float-left" style="padding:0px;">
                                <label class="col-md-12 control-label">Designation</label>
                                <div class="col-md-12 inputGroupContainer">
                                   <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <vue-select v-model="designation_name_value" :options="option_data.designation_data" @select="onSelectDesignation" placeholder="Select one" label="text" track-by="text"></vue-select>
                                  </div>
                                </div>
                             </div>
                             <div class="form-group col-md-3 float-left" style="padding:0px;">
                                <label class="col-md-12 control-label">Section</label>
                                <div class="col-md-12 inputGroupContainer">
                                   <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <vue-select v-model="section_value" :options="option_data.section_data" @select="employeesSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                                  </div>
                                </div>
                             </div>

                             <div class="form-group col-md-3 float-left" style="padding:0px;">
                                <label class="col-md-12 control-label">Sub Section</label>
                                <div class="col-md-12 inputGroupContainer">
                                   <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <vue-select v-model="sub_section_value" :options="option_data.sub_section_data" @select="employeesSubSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                                  </div>
                                </div>
                             </div>
                             <div class="form-group col-md-3 float-left" style="padding:0px;">
                                <label class="col-md-6 control-label">Employee</label>
                                <div class="col-md-12 inputGroupContainer">
                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                    <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                                  </div>
                                </div>
                             </div>
                             <div class="form-group col-md-3 float-left" style="padding:0px;">
                                <label class="col-md-12 control-label">From</label>
                                <div class="col-md-12 inputGroupContainer">
                                   <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <datepicker placeholder="Select Date" v-model="report_data.leave_from_date" class="form-control"></datepicker>
                                  </div>
                                </div>
                             </div>
                             <div class="form-group col-md-3 float-left" style="padding:0px;">
                                <label class="col-md-12 control-label">To</label>
                                <div class="col-md-12 inputGroupContainer">
                                   <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <datepicker placeholder="Select Date" v-model="report_data.leave_to_date"   class="form-control"></datepicker>
                                  </div>
                                </div>
                             </div>
                          </div>
                          <div class="row report-box">
                            <label><strong>Report Columns: </strong></label>
                            <div class="col-md-12 attendance-column" style="">
                              <div class="col-md-3" style="padding-left:0px;">
                                  <select v-model="report_data.att_report_type"  name="typ" class="form-control" style="font-size: 14px;margin-bottom: 10px;">
                                    <option value="0" selected="selected" disabled>Attendance Report Type</option>
                                    <option value="1">Daily Report</option>
                                    <option value="2">Daily Summary</option>
                                    <option value="3">Individual Report</option>
                                    <option value="4">Periodic Report</option>
                                    <option value="5">Periodic Report Details</option>
                                  </select>
                              </div>
                             
                              <div class="col-md-3 attendance-column report-box float-left" style="height: 200px;overflow-y: auto;">
                                <label class="col-md-12"><strong>Report Columns: </strong></label>
                                   <div class="age-option" v-for="attcol in attendanceColumn">
                                     <label :for="'input-attcol-'+attcol.value" class="checkbox-label">
                                         <input :id="'input-attcol-'+attcol.value" type="checkbox" name="filters[attcol_data][]" :value="attcol.value" v-model="checkedattcols">
                                         <span>{{ attcol.label }}</span>
                                     </label>
                                    </div>
                               </div>
                               <div class="col-md-12">
                                 <ul class="tags">
                                     <li @click="uncheck(checkedName)" class="badge badge-pill badge-warning" v-for="checkedName in checkedattcols">
                                       {{ checkedName}} <span class="btn-xs btn-danger"> <i class="fa fa-times"></i></span>
                                     </li>
                                   </ul>
                               </div>
                            </div>
                          </div>
                         

                          <div class="col-md-12">
                              <!-- <button type="submit" class="btn btn-sm btn-info float-right"> <i class="fa fa-search"></i> Search</button> -->
                              <!-- <button style="border-radius: 5px;margin-top: 10px;" :disabled="visable" @click="viewReport()" type="button" class="btn btn-primary pull-left float-right">submit</button> -->
                              <button style="border-radius: 5px;margin-top: 10px;" :disabled="visable" @click="viewReport(report_data,urls)" type="button" class="btn btn-primary pull-left">submit</button>
                          </div>

                          <!-- <div class="row">
                            <label class="col-md-12"><strong>Report Columns: </strong></label>
                            <div class="col-md-2 attendance-column">
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Employee ID
                              </label>
                              <br>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Employee Name
                              </label>
                              <br>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Company
                              </label>
                              <br>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Department
                              </label>
                              <br>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Designation
                              </label>
                              <br>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Section
                              </label>
                              <br>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Sub Section
                              </label>
                              <br>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> In Time
                              </label>
                              <br>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Out Time
                              </label>
                              <br>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Late
                              </label>
                              <br>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Status
                              </label>
                              <br>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Remarks
                              </label>
                              <br>
                            </div>

                          </div> -->

                         <!--  <div class="row" style="border:1px solid #ddd; padding:10px; box-shadow: 0px 0px 5px 0px #ddd; margin-bottom: 10px;">
                            <label><strong>Leave Report Columns: </strong></label>
                            <div class="col-md-12 attendance-column">
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Employee ID
                              </label>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Employee Name
                              </label>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Company
                              </label>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Department
                              </label>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Designation
                              </label>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Section
                              </label>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Sub Section
                              </label>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> In Time
                              </label>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Out Time
                              </label>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Late
                              </label>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Status
                              </label>
                              <label class="checkbox-inline">
                                <input class="check" type="checkbox"> Remarks
                              </label>
                            </div>

                          </div> -->
                          
                          <!-- <div class="col-md-12">
                            Employee Data load
                          </div>
                          <div class="col-md-12">
                             Leave Data load
                          </div> -->
                      </div>
                  </form>    
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
<!-- <div v-if="!page_loading">
    <pageLoading></pageLoading>
</div> -->
</div>
</template>
<script>
    import Loading from '../Loading.vue';
    import $ from 'jquery'
    export default {
       data(){
         return{
           report_data:[],
           employee_name_value:'',
           isHidden: false,
           sbu_name_value:'',
           section_value:'',
           sub_section_value:'',
           employee_group_value:'',
           sub_unit_value:'',
           work_location_value:'',
           department_name_value:'',
           designation_name_value:'',
           jobgrade_name_value:'',
           employee_name_value:'',
           approvalnamevalue:'',
           approvalnamevalue1:'',
           approval_infos:[{
                ea_approve_by:'',
             }],
          checkbook:[],
          urls:'',
          checkedCategories: [],   
          sub_unit_value:'',
          work_location_value:'',
          checkedName: true,
          checkedattcols: [],
          attendanceColumn: [
                { label: 'Employee ID', value: 'employee_id_no' },
                { label: 'Employee Name', value: 'employee_full_name' },
                { label: 'Company', value: 'sbu_name' },
                { label: 'Department', value: 'department_name' },
                { label: 'Designation', value: 'designation_name' },
                { label: 'Section', value: 'section_name' },
                { label: 'Sub Section', value: 'sub_section_name' },
                { label: 'In Time', value: 'in_time' },
                { label: 'Out Time', value: 'out_time' },
                { label: 'Late', value: 'late' },
                { label: 'Status', value: 'status' },
                { label: 'Remarks', value: 'remarks' },
            ],
         }
       },
       // computed: {
       //        checkedattcols() {
       //            return this.item.checked.filter(item => item.checked).map(name => name.name)
       //        }
       //    },

        created(){
           this.getList();
        },
        components:{
            pageLoading:Loading
        },
      methods:{
        getList(){
            axios.get(URL.baseUrl("report_list"))
            .then(res => {
              console.log(res.data.company_sbu_data);
             
              this.form_data = res;
              this.option_data = res;
              this.option_data.company_sbu_data = res.data;
              this.modal_loading= false;
              this.urls = 'getlist/report';
            })
            .catch(error => {
               this.modal_loading= true;
              this.showToster({status:0,message:'opps! something went wrong'});
            })
          },

          uncheck(checkedName) {
            // alert(checkedName);
            console.log(checkedName);
               this.checkedattcols = this.checkedattcols.filter(name => name !== checkedName);
          },
          setModalData(){
            this.employee_name_value=this.form_data.employee_name_value;
          },
        },

        employeesSbu(option){
          console.log(option);
          this.form_data.employee_sbu= option.id;
          console.log(this.form_data.employee_sbu);
        },
        employeesSection(option){
          console.log(option);
          this.form_data.employee_section= option.id;
          console.log(this.form_data.employee_section);
        },
        employeesSubSection(option){
          console.log(option);
          this.form_data.employee_sub_section= option.id;
          console.log(this.form_data.employee_sub_section);
        },
        employeesGroup(option){
          console.log(option);
          this.form_data.employee_group= option.id;
          console.log(this.form_data.employee_group);
        },
        employeesSubUnit(option){
          console.log(option);
          this.form_data.employee_sub_unit= option.id;
          console.log(this.form_data.employee_sub_unit);
        },
        employeesWorkLocation(option){
          console.log(option);
          this.form_data.employee_work_location= option.id;
          console.log(this.form_data.employee_work_location);
        },
        onSelectDepartment(option){
          console.log(option);
          this.form_data.employee_department= option.id;
          console.log(this.form_data.employee_department);
        },
        onSelectDesignation(option){
          console.log(option);
          this.form_data.employee_designation= option.id;
          console.log(this.form_data.employee_designation);
        },
        onSelectJobGrade(option){
          console.log(option);
          this.form_data.employee_job_grade= option.id;
          console.log(this.form_data.employee_job_grade);
        },
        onSelectEmployee(option){
          console.log(option);
          this.form_data.employee_reporting_to= option.id;
          console.log(this.form_data.employee_reporting_to);
        },
        onSelectEmployeeApproval(option){
          console.log(option);
          this.form_data.approve_by= option.id;
          this.form_data.approve_by_name= option.text;
          console.log(this.form_data.approve_by);
        },
        onFileChange(e) {
              let files = e.target.files || e.dataTransfer.files;
              if (!files.length)
                  return;
              this.createImage(files[0]);
              
          },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                this.form_data.employee_image = e.target.result;
            };
            reader.readAsDataURL(file);
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
        },
        resetModal(){
          this.sbu_name_value='';
          this.section_value='';
          this.sub_section_value='';
          this.employee_group_value='';
          this.department_name_value='';
          this.designation_name_value='';
          this.jobgrade_name_value='';
          this.sub_unit_value='';
          this.employee_name_value='';
          this.work_location_value='';
          this.form_data.employee_status='1';
          this.form_data.emplyee_category_mgt_non_mgt='2';
          this.form_data.employee_leave_group='1';
          this.form_data.employee_type='2';
          this.form_data.make_user='1';
        },
       addRow(event,approval_infos,id) {
              this.approval_infos.push({
                  approvalnamevalue1:'',
                  ea_approve_by:id,
                  ea_approve_by_name:name,
              })
              this.form_data.approval_infos=this.approval_infos;
              console.log(this.approval_infos);
          }, 
    }
</script>
<style type="text/css">
  .checkbox-inline{
    padding-right: 15px;
  }


 
  </style>