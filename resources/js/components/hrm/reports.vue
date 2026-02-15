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
                               <h3 class="card-title d-none d-md-block">All Reports</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <a @click="$router.go(-1)" class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                               </span>
                           </div>
                       </div>
                    </div>
                   <div class="card-body row" style="padding-top:0px;">
                      <div class="col-md-12">
                      	<div class="col-md-12" style="margin:10px 0px;">
                      	     <div class="input-group" >
	                      	      <label class="col-md-2 control-label"><strong>Report Type</strong></label>
	                      	      <div class="col-md-3" style="padding-left:0px;">
	                      	            <select v-model="form_data.report_type" @change="reportTypes($event)"  name="typ" class="form-control" style="font-size: 14px; height: 30px;">
	                      	              <option >--Select--</option>
	                      	               <option value="1">Attendance Report</option>
	                      	               <option value="2">Employees Report</option>
	                      	               <option value="3">Leave Report</option>
	                      	            </select>
	                      	      </div>

	                      	      <label v-if="reportTypesVelu==1" class="col-md-2 control-label text-right"><strong>Attendance Report</strong></label>
	                      	      <div v-if="reportTypesVelu==1" class="col-md-3" style="padding-left:0px;">
	                      	            <select v-model="form_data.att_report_type"  @change="DailyreportTypes($event)"  name="typ" class="form-control" style="font-size: 14px; height: 30px;">
	                      	              <option value="0" disabled>-- Select Attendance Report Type --</option>
      	                      	          <option value="1">Daily Report</option>
      	                      	          <option value="2">Daily Summary</option>
      	                      	          <option value="3">Individual Report</option>
      	                      	          <option value="4">Periodic Report</option>
      	                      	          <option value="5">Periodic Report Details</option>
	                      	            </select>
	                      	      </div>
	                      	    <!-- <div class="col-md-3" style="padding-left:0px;">
	                      	    	<label class="col-md-2 control-label"><strong>Report Type</strong></label>
	                      	        <select v-model="form_data.att_report_type"  name="typ" class="form-control" style="font-size: 14px;margin-bottom: 10px;" required>
	                      	          <option value="0" disabled>-- Select Attendance Report Type --</option>
	                      	          <option value="1">Daily Report</option>
	                      	          <option value="2">Daily Summary</option>
	                      	          <option value="3">Individual Report</option>
	                      	          <option value="4">Periodic Report</option>
	                      	          <option value="5">Periodic Report Details</option>
	                      	        </select>
	                      	    </div> -->
                      	    </div> 
                      	</div>
                        <!-- v-if="AllreportTypesVelu==1" -->
	                <div class="row report-box"  >
                        <div class="form-group col-md-2 float-left" style="padding:0px;">
	                	   <label class="col-md-12 control-label">Company/SBU</label>
	                	   <div class="col-md-12 inputGroupContainer">
	                	      <div class="input-group">
	                	       <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>

                         <!--   <select name="sel-02" id="sel-02" class="select2-original multiselect__input" @change="companyAll1($event)"  multiple >
                          <option v-for="company in option_data.company_sbu_data"  :value='company.id' >{{company.text }}
                          </option>
                          </select> -->
                          <vue-select v-model="branch_value" :options="option_data.Branch" @select="onSelectBranch" placeholder="Select one"  multiple="multiple" label="text" track-by="text"></vue-select>

<!-- 
	                	       <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data"  multiple="multiple" @select="employeesSbu" placeholder="Select one" label="text" track-by="text"></vue-select>
 -->
	                	     </div>
	                	   </div>
	                	</div>

	                	<div class="form-group col-md-2 float-left" style="padding:0px;">
	                	   <label class="col-md-12 control-label">Section</label>
	                	   <div class="col-md-12 inputGroupContainer">
	                	      <div class="input-group">
	                	       <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                          <!--  <select name="sel-07" id="sel-07" class="select2-original multiselect__input" @change="departmentAll($event)" v-model="form_data.employee_section" multiple>
                            <option v-for="section in option_data.section_data"  :value='section.id' >{{section.text }}
                            </option>
                          </select> -->

	                	       <vue-select v-model="section_value" :options="option_data.section_data" @select="employeesSection" placeholder="Select one" label="text" track-by="text"></vue-select>
	                	     </div>
	                	   </div>
	                	</div>
	                	<div class="form-group col-md-2 float-left" style="padding:0px;">
	                	   <label class="col-md-12 control-label">Sub Section</label>
	                	   <div class="col-md-12 inputGroupContainer">
	                	      <div class="input-group">
	                	       <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                           <select name="sel-06" id="sel-06" class="select2-original multiselect__input" @change="departmentAll($event)" multiple v-model="form_data.employee_sub_section">
                            <option v-for="sub_section in option_data.sub_section_data"  :value='sub_section.id' >{{sub_section.text }}
                            </option>
                          </select>

	                	       <!-- <vue-select v-model="sub_section_value" :options="option_data.sub_section_data" @select="employeesSubSection" placeholder="Select one" label="text" track-by="text"></vue-select> -->
	                	     </div>
	                	   </div>
	                	</div>
	                	<div class="form-group col-md-2 float-left" style="padding:0px;">
	                	   <label class="col-md-12 control-label">Department</label>
	                	   <div class="col-md-12 inputGroupContainer">
	                	      <div class="input-group">
	                	       <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                           

                         <select name="sel-03" id="sel-03" class="select2-original multiselect__input" @change="departmentAll($event)" multiple v-model="form_data.employee_department">
                          <option v-for="department in option_data.department_data"  :value='department.id' >{{department.text }}
                          </option>
                        </select>
	                	      <!--  <vue-select v-model="department_name_value" :options="option_data.department_data" mult @select="onSelectDepartment" placeholder="Select one" label="text" track-by="text"></vue-select> -->

	                	     </div>
	                	   </div>
	                	</div>
	                	<div class="form-group col-md-2 float-left" style="padding:0px;">
	                	   <label class="col-md-12 control-label">Designation</label>
	                	   <div class="col-md-12 inputGroupContainer">
	                	      <div class="input-group">
	                	       <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                          <select name="sel-05" id="sel-05" class="select2-original multiselect__input" @change="departmentAll($event)" multiple v-model="form_data.employee_designation">
                            <option v-for="designation in option_data.designation_data"  :value='designation.id' >{{designation.text }}
                            </option>
                          </select>

	                	       <!-- <vue-select v-model="designation_name_value" :options="option_data.designation_data" @select="onSelectDesignation" placeholder="Select one" label="text" track-by="text"></vue-select> -->
	                	     </div>
	                	   </div>
	                	</div>

	                	<div  v-if="individualReportTypesVelu ==1" class="form-group col-md-2 float-left" style="padding:0px;">
	                	   <label class="col-md-12 control-label">Employees</label>
	                	   <div class="col-md-12 inputGroupContainer">
	                	      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                            <select name="sel-05" id="sel-05" class="select2-original multiselect__input" @change="departmentAll($event)" multiple v-model="form_data.employee_id">
                            <option v-for="employee in option_data.employee_data"  :value='employee.id' >{{employee.text }}
                            </option>
                          </select>
	                	      <!--  <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select> -->
	                	     </div>
	                	   </div>
	                	</div>
         <!--                              dailyReportTypesVelu:0,
           periodicReportTypesVelu:0,
           individualReportTypesVelu:0, -->

	                	<div class="form-group col-md-2 float-left" style="padding:0px;">
	                	   <label v-if="dailyReportTypesVelu==1" class="col-md-12 control-label">Date</label>
                       <label v-if="periodicReportTypesVelu==1 || individualReportTypesVelu==1" class="col-md-12 control-label">From</label>
	                	   <div v-if="periodicReportTypesVelu==1 || individualReportTypesVelu==1 || dailyReportTypesVelu==1" class="col-md-12 inputGroupContainer">
	                	      <div class="input-group">
	                	       <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
	                	       <datepicker placeholder="Select Date" v-model="form_data.from_date" class="form-control1"></datepicker>
	                	     </div>
	                	   </div>
	                	</div>
	                	<div v-if="periodicReportTypesVelu==1 || individualReportTypesVelu==1" class="form-group col-md-2 float-left" style="padding:0px;">
	                	   <label class="col-md-12 control-label">To</label>
	                	   <div class="col-md-12 inputGroupContainer">
	                	      <div class="input-group">
	                	       <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
	                	       <datepicker placeholder="Select Date" v-model="form_data.to_date"   class="form-control1"></datepicker>
	                	     </div>
	                	   </div>
	                	</div>
	                </div>
                 	<div class="row report-box" v-if="reportTypesVelu==2">
                 	  <!-- <label><strong>Report Columns: </strong></label> -->
                 	  <div class="col-md-12 attendance-column" style="">
                      <!-- style="height: 150px;overflow-y: auto;" -->
                 	    <div class="col-md-3 attendance-column report-box float-left" >
                        <!-- <div  v-if="individualReportTypesVelu ==1" class="form-group col-md-3 float-left" style="padding:0px;"> -->
                           <label class="col-md-12 control-label">Report Columns:</label>
                           <div class="col-md-12 inputGroupContainer">
                              <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                <vue-select  class="report_fileds" v-model="attendanceColumn_value" :options="option_data.attendanceColumn" style="padding: 3px 8px 0px 8px;" @select="onSelectAttendanceColumn" placeholder="Select one"  multiple="multiple" label="text" track-by="text"></vue-select>
                             </div>
                           <!-- </div> -->
                        </div>
                 	      <!-- <label class="col-md-12"><strong>Report Columns: </strong></label>
                 	         <div class="age-option" v-for="attcol in attendanceColumn">
                 	           <label class="checkbox-label"  @click="columncheck($event,attcol)" >

                 	               <input type="checkbox" :value="attcol.value" v-model="checkedattcols">
                 	               <span>{{ attcol.label }}</span>

                 	           </label>
                 	          </div> -->
                 	     </div>
                 	     <div class="col-md-9 float-left">
                 	       <ul class="tags">
                          <!-- uncheck(checkedName) -->
                 	           <li  class="badge badge-pill badge-success" v-for="(checkedName,index) in checkedattcolsaddText" v-if="checkedName.text !=''" >
                              <!-- <li v-for="attcol in checkedattcolsaddText"> -->
                                 <samp @click="uncheck($event,checkedName)" > {{checkedName.text}} 
                                  <span class="btn-xs btn-danger"> <i class="fa fa-times"></i></span>  
                                </samp>
                              <!-- </li> -->
                              
                 	        	<!-- <span v-if="index > 0">
                 	        		{{ checkedName.label}} 
                 	        		
                 	        	</span> -->
                 	           </li>
                 	         </ul>
                 	     </div>
                 	  </div>
                 	</div>
                 	<div class="col-md-12">
                 	    <!-- <button type="submit" class="btn btn-sm btn-info float-right"> <i class="fa fa-search"></i> Search</button> -->
                 		<button style="border-radius: 5px;"  @click="viewReport(form_data,urls)" type="button" class="btn btn-info float-right">Search</button>
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

    export default {
       data(){
         return{
         	visable:'',
         	sbu_name_value:[],
         	section_value:'',
         	sub_section_value:'',
         	employee_group_value:'',
         	sub_unit_value:'',
          permision:[],
         	work_location_value:'',
         	department_name_value:'',
         	designation_name_value:'',
         	jobgrade_name_value:'',
         	employee_name_value:'',
           employee_name_value:'',
           reportTypesVelu:0,
           dailyReportTypesVelu:0,
           periodicReportTypesVelu:0,
           individualReportTypesVelu:0,
           AllreportTypesVelu:0,
           checkedName: true,
           employee_sbu:[],
           checkNameArray:[
           			{
           				label:'',
           			}
           ],
           checkedattcols: [],
           isCheckAll: false,
           checkedattcolsaddText: [{
              id:'',
              text:'',
           }],
           checkedattcolsadd:[],
          //  attendanceColumn: [
	         //     // { label: 'Employee ID', value: 'employee_id_no' },
	         //     // { label: 'Employee Name', value: 'employee_full_name' },
	         //     // { label: 'Company', value: 'sbu_name' },
	         //     // { label: 'Department', value: 'department_name' },
	         //     // { label: 'Designation', value: 'designation_name' },
	         //     { text: 'Section', id: 'section_name' },
	         //     { text: 'Sub Section', id: 'sub_section_name' },
	         //     // { label: 'In Time', value: 'in_time' },
	         //     // { label: 'Out Time', value: 'out_time' },
	         //     // { label: 'Late', value: 'late' },
	         //     // { label: 'Status', value: 'status' },
	         //     // { label: 'Remarks', value: 'remarks' },
	         // ],
         }
       },

        created(){
            this.getResults(1);
            this.setFormData();
            this.getUrl();
            this.departmentAll();
            this.companyAll();
            Vue.nextTick(function () {
              this.departmentAll();
            }.bind(this));
            Vue.nextTick(function () {
              this.companyAll();
            }.bind(this))
            
        },
        components:{
            pageLoading:Loading
        },
      methods:{
        departmentAll(event){ 
                $('.select2-original').select2({
                  placeholder: "Select One",
                  width: "100%"
                });

        },
        companyAll1(event){
          console.log(event.target.value);
          this.employee_sbu=event.target.value;
          this.form_data.employee_sbu=this.employee_sbu;
        },
        companyAll(event){
          $('#select2-original-company').select2({
                  placeholder: "Select One",
                  width: "100%"
                });
        },
        reportTypes(event) {
          this.AllreportTypesVelu=1;
          if(event.target.value==1){
            this.reportTypesVelu=1;
            this.dailyReportTypesVelu=0;
            this.periodicReportTypesVelu=0;
            this.individualReportTypesVelu=0;
           this.fromDataReset();
          }else if(event.target.value==2){
            this.reportTypesVelu=2;
            this.dailyReportTypesVelu=0;
            this.periodicReportTypesVelu=0;
            this.individualReportTypesVelu=0;
             this.fromDataReset();
          }else{
            this.reportTypesVelu=0;
          }
          this.allreportfuntioncall();
          console.log(event.target.value)
        },

        allreportfuntioncall(){
               this.departmentAll();
              this.companyAll();
        },
        fromDataReset(){
            this.form_data.att_report_type='';
            this.form_data.employee_sbu='';
            this.form_data.employee_section='';
            this.form_data.employee_group='';
            this.form_data.employee_sub_unit='';
            this.form_data.employee_work_location='';
            this.form_data.employee_department='';
            this.form_data.employee_designation='';
            this.form_data.employee_job_grade='';
            this.form_data.employee_id='';
            this.sbu_name_value='';
           this.section_value='';
           this.sub_section_value='';
           this.employee_group_value='';
           this.sub_unit_value='';
           this.work_location_value='';
           this.department_name_value='';
           this.designation_name_value='';
           this.jobgrade_name_value='';
           this.employee_name_value='';
           this.employee_name_value='';
        },
        DailyreportTypes(event){
          if(event.target.value==1 || event.target.value==2){
            this.dailyReportTypesVelu=1;
            this.periodicReportTypesVelu=0;
            this.individualReportTypesVelu=0;
          }else if(event.target.value==3){
            this.dailyReportTypesVelu=0;
            this.individualReportTypesVelu=1;
            this.periodicReportTypesVelu=0;
          }else if(event.target.value==4 || event.target.value==5){
            this.periodicReportTypesVelu=1;
            this.dailyReportTypesVelu=0;
            this.individualReportTypesVelu=0;
          }else{
            this.dailyReportTypesVelu=0;
            this.periodicReportTypesVelu=0;
            this.individualReportTypesVelu=0;
          }
          console.log(event.target.value)
        },

      	getUrl(){
      		this.urls = 'getlist/report';
      	},
      	columncheck(event,id) {
      		 if(event.target.value ==undefined){
      		 }else{
      		 	this.checkedattcolsadd.push(event.target.value);
      		 	this.form_data.checkedattcolsadd = this.checkedattcolsadd;
      		 	this.checkNameArray.push({
      		 		label:id['label'],
      		 		}
      		 	);
      		 }
  		},
  		
  		uncheck(event,checkedName) {
  		  		console.log(this.attendanceColumn_value);
  		  	let datall=  this.form_data.checkedattcolsadd;
          this.checkedattcolsadd=[];
              this.checkedattcolsaddText= [{
                  id:'',
                  text:'',
               }];
  		  	datall.forEach(element => {
  	  		  if (checkedName.id ===element) {
  	  		  // console.log(element);
            }else{
              let datall=  this.option_data.attendanceColumn;
              let obj =datall.find(data => data.id == element);
              this.checkedattcolsadd.push(element);
              this.checkedattcolsaddText.push({
                id:element,
                text:obj['text'],
              });
              this.form_data.checkedattcolsadd=this.checkedattcolsadd;
              
            }
            this.attendanceColumn_value=this.checkedattcolsaddText;

  		  	});
  		},
          employeesSbu(option){
            // this.sbu_name_value=option;
            this.form_data.employee_sbu= this.sbu_name_value;
            // console.log(this.form_data.employee_sbu);
            this.empsbu();
          },
          empsbu(){
            var result = this.sbu_name_value; 
              console.log(result);
              // result.forEach(element => {
              //   console.log(element);
              //    this.permision.push(element[1]['id']);
              // });
            // this.form_data.permision=this.permision;
            // console.log(this.permision);
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
            this.form_data.employee_id= option.id;
            console.log(this.form_data.employee_id);
          },
          setModalData(){
            this.employee_name_value=this.form_data.employee_name_value;
          },

          onSelectAttendanceColumn(option){
            this.checkedattcolsadd.push(option.id);
            this.checkedattcolsaddText.push({
              id:option.id,
              text:option.text,
            });
            this.form_data.checkedattcolsadd=this.checkedattcolsadd;
          },

          setFormData(){
          	// this.form_data.att_report_type = 0;
          	// this.form_data.report_type = 0;
          }


        }
    }



</script>
<style type="text/css">
  .report_fileds > .multiselect__tags > .multiselect__tags-wrap > .multiselect__tag {
    display: none;
  }
</style>