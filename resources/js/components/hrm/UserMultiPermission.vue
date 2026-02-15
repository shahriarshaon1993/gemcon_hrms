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
                               <h3 class="card-title d-none d-md-block">User Multi Permission</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <a @click="$router.go(-1)" class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                               </span>
                           </div>
                       </div>
                    </div>
                   <div class="card-body row user_multi_layer" style="padding-top:0px;">
                      <div class="col-md-12" style="    padding-right: 0px;">
                      	<div class="col-md-12" style="margin:10px 0px;padding-right: 0px;">
                      	     <div class="input-group" >
	                      	      <label class="col-md-2 control-label"><strong>Employee <sup style="color:red; top: -2px;">*</sup></strong></label>
	                      	      <div class="col-md-3" style="padding-left:0px;">
	                      	            <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
	                      	      </div>
                                <div class="col-md-2" style="padding-left:0px;">
                                </div>
                                <div class="col-md-5" style="padding-left:0px;">
                                  <div class="input-group input-group-sm">
                                    <!--   <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search"> -->
                                      <input v-on:keyup="EmployeegetResults" v-model="search_input" type="text" aria-controls="DataTables_Table_0" class="form-control" id="search" placeholder="Enter keyword...">
                                      <div class="input-group-append" style="background: #fac23c;">
                                        <button class="btn btn-navbar" type="submit">
                                          <i class="fas fa-search" ></i>
                                        </button>
                                      </div>
                                    </div>
                                   <!--  <input v-on:keyup="EmployeegetResults" v-model="search_input.search_key" type="text" aria-controls="DataTables_Table_0" class="form-control" id="search" placeholder="Enter keyword..."> -->
                                </div> 

	                      	   
                      	    </div> 
                      	</div>
	                <div class="row report-box">
                        <div class="form-group col-md-2" style="max-width: 13.5%;">
                           <label class="col-md-12 control-label">SBU <sup style="color:red; top: -2px;">*</sup></label>
                           <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                              <div class="input-group">
                               <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                               <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbu" placeholder="Select one" label="text" track-by="text"></vue-select>
                             </div>
                           </div>
                        </div>
                        <div class="form-group col-md-2" style="max-width: 13.5%;">
                           <label class="col-md-12 control-label">Unit</label>
                           <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                              <div class="input-group">
                               <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                               <vue-select v-model="unit_value" :options="option_data.unit_data" @select="employeesUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                             </div>
                           </div>
                        </div>
                        <div class="form-group col-md-2" style="max-width: 13.5%;">
                           <label class="col-md-12 control-label">Sub Unit</label>
                           <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                              <div class="input-group">
                               <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                               <vue-select v-model="sub_unit_value" :options="option_data.sub_unit_data" @select="employeesSubUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                             </div>
                           </div>
                        </div>

                        <div class="form-group col-md-2" style="max-width: 13.5%;">
                           <label class="col-md-12 control-label">Department</label>
                           <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                              <div class="input-group">
                               <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                               <vue-select v-model="department_name_value" :options="option_data.department_data" @select="onSelectDepartment" placeholder="Select one" label="text" track-by="text"></vue-select>
                             </div>
                           </div>
                        </div>
                        <div class="form-group col-md-2" style="max-width: 13.5%;">
                           <label class="col-md-12 control-label">Section</label>
                           <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                              <div class="input-group">
                               <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                               <vue-select v-model="section_value" :options="option_data.section_data" @select="employeesSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                             </div>
                           </div>
                        </div>
                        <div class="form-group col-md-2" style="max-width: 13.5%;">
                           <label class="col-md-12 control-label">Sub Section</label>
                           <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                              <div class="input-group">
                               <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                               <vue-select v-model="sub_section_value" :options="option_data.sub_section_data" @select="employeesSubSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                             </div>
                           </div>
                        </div>
                        <div class="form-group col-md-2"  style="max-width: 13.5%;">
                           <label class="col-md-12 control-label">Work Loc.</label>
                           <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                              <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                               <vue-select v-model="work_location_value" :options="option_data.work_location_data" @select="employeesWorkLocation" placeholder="Select one" label="text" track-by="text"></vue-select>
                             </div>
                           </div>
                        </div>
                        <div class="col-md-1 float-right" style="padding: 22px;max-width: 4.333333%;">
                
                          <span v-if="this.employee_id && this.sbu_permission">
                             <a @click="addRowUserlevel($event,form_data.userPermission,form_data.approve_by,employees_ids,employeesName)" id="addCF" class="btn btn-xs " style="color: #212529 !important;background-color: #fac23c;border-color: #fac23c;"><i class="fa fa-plus" style="color: #212529 !important;background-color: #fac23c;border-color: #fac23c;"></i></a>
                          </span>
                          
                         </div>
                        
                          <form @submit.prevent="add({add:'add/userMultiPermission'})" class="" style="width: 100%" id="validate-1">
                         <div class="row col-md-12"> 
                            <table class="" style="width: 100%;">

                                <tr class="text-center  table-bordered table-striped employeeTable" style="border-bottom: 1px solid #cfcfcf;background: rgb(207, 207, 207);">
                                  <th width="3"> SBU</th>
                                  <th width="3"> Unit</th>
                                  <th width="3"> Sub Unit</th>
                                  <th width="3"> Department</th>
                                  <th width="3"> Section</th>
                                  <th width="3"> Sub Section</th>
                                  <th width="10">Work Loc. </th>
                                  <th width="40"> </th>
                                </tr>
                             
                                <!-- {{userPermission }} -->
                               
                                <tr class="table table-bordered table-striped employeeTable " style="border: 1px solid rgb(207, 207, 207);" v-for="(form_data, index) in userPermission"   > 
                                    <td> 
                                        <span v-if="form_data.sbu_name">
                                           {{form_data.sbu_name}} 
                                        </span>
                                        <span v-else>
                                           -
                                        </span>

                                    </td>
                                    <td> 
                                        <span v-if="form_data.unit_name">
                                           {{form_data.unit_name}} 
                                        </span>
                                        <span v-else>
                                           -
                                        </span>
                                    </td>
                                    <td> 
                                        <span v-if="form_data.sub_unit_name">
                                           {{form_data.sub_unit_name}} 
                                        </span>
                                        <span v-else>
                                           -
                                        </span>
                                   </td>
                                    <td> 
                                      <span v-if="form_data.department_name">
                                           {{form_data.department_name}} 
                                        </span>
                                        <span v-else>
                                           -
                                        </span>
                                    </td>
                                    <td> 
                                        <span v-if="form_data.section_name">
                                           {{form_data.section_name}} 
                                        </span>
                                        <span v-else>
                                           -
                                        </span>

                                    </td>
                                    <td> 
                                        <span v-if="form_data.sub_section_name">
                                           {{form_data.sub_section_name}} 
                                        </span>
                                        <span v-else>
                                           -
                                        </span>
                                    </td>
                                    <td> 
                                      <span v-if="form_data.work_location_name">
                                           {{form_data.work_location_name}} 
                                        </span>
                                        <span v-else>
                                           -
                                        </span>

                                   </td>
                                    <td style="text-align: right;"> 
                                         <a @click="deleteRowMlevel(index)" id="remCF" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>

                              </table>
                          
                         </div>
                        <div class="col-md-12">
                         <div class="form-actions" style="margin-top: 5px;">
                            <input type="submit" tabindex="4" value="Save" class="btn btn-md btn-info float-right "> 
                            <button type="button" class="btn btn-md btn-default float-right" style="margin-right: 10px;">Close</button>
                          </div>
                      </div>
                      </form>
                    </div>
                
               		</div>
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
    import Loading from '../Loading.vue';

    export default {
        data(){
          return{
            attendance_machine_value:'',
            office_time_value:'',
            attendance_issues_name_value:'',
            employee_form_submit:1,
            effective_date:'',
            leave_type_value:'',
            employee_name_search:'',
            employee_name_value:'',
            add_new_type:'',
            totalDays:0,
            totalDayss:0,
            remaining_days:0,
            employee_image:'',
            requested_data:'',
            sbu_name_value:'',
            section_value:'',
            sub_section_value:'',
            employee_group_value:'',
            unit_value:'',
            make_user:0,
            employeesName:'',
            employees_ids:'',
            search_input:'',
            url: null,
            sub_unit_value:'',
            work_location_value:'',
            department_name_value:'',
            designation_name_value:'',
            sbu_name_value_per:'',
            department_name_value_per:'',
            unit_value_per:'',
            sub_unit_value_per:'',
            section_value_per:'',
            sub_section_value_per:'',
            employee_name_value_per:'',
            jobgrade_name_value:'',
            employee_name_value:'',
            approvalnamevalue:'',
            approvalnamevalue1:'',
            userPermission:'',
            employee_id:'',
            sbu_permission:'',
            sbu_name:'',
            unit_permission:'',
            unit_name:'',
            sub_unit_permission:'',
            sub_unit_name:'',
            department_permission:'',
            department_name:'',
            section_permission:'',
            section_name:'',
            employee_id_no:'',
            sub_section_permission:'',
            sub_section_name:'',
            work_location_permission:'',
            work_location_name:'',


            approval_infos:[{
                 ea_approve_by:'',
              }],
            approval_infosss:[{
                 ea_approve_by:'',
              }],
            sub_unit_value:'',
            work_location_value:'',
            personal_email_id:'',
            userType:0,
            shift_time:'',
            userTypeName:'',
            permission_id:'',
            permission_id_name:'',
           
          }
        },
        created(){
            this.getResults(1);
        },
        components:{
            pageLoading:Loading,
        },
  
        methods:{
            user_type_to(event){
            console.log(event.target.name);
            if (event.target.value==2) {
              this.userType=2;
              this.userTypeName='Company/SBU';
            }else if(event.target.value==3){
              this.userType=3;
              this.userTypeName='Department';
            }else if(event.target.value==4){
              this.userType=4;
              this.userTypeName='Unit';
            }else if(event.target.value==5){
              this.userType=5;
              this.userTypeName='Sub Unit';
            }else if(event.target.value==6){
              this.userType=6;
              this.userTypeName='Section';
            }else if(event.target.value==7){
              this.userType=7;
              this.userTypeName='Sub Section';
            }else if(event.target.value==8){
              this.userType=8;
              this.userTypeName='Employee';
            }else if(event.target.value==1){
              this.userType=1;
              this.userTypeName='';
            }
           },
           addRowUserlevel(event,userPermission) {
            console.log(this.userPermission);
              // var aaa= this.form_data.userPermission.length;
              console.log(this.employee_id);
              console.log(this.sbu_permission);

             if(this.employee_id !== undefined &&  this.sbu_permission !== undefined){
                this.userPermission.push({
                  'employee_id':this.employee_id,
                  'sbu_permission':this.sbu_permission,
                  'sbu_name':this.sbu_name,
                  'unit_permission':this.unit_permission,
                  'unit_name':this.unit_name,
                  'sub_unit_permission':this.sub_unit_permission,
                  'sub_unit_name':this.sub_unit_name,
                  'department_permission':this.department_permission,
                  'department_name':this.department_name,
                  'section_permission':this.section_permission,
                  'section_name':this.section_name,
                  'sub_section_permission':this.sub_section_permission,
                  'sub_section_name':this.sub_section_name,
                  'work_location_permission':this.work_location_permission,
                  'work_location_name':this.work_location_name
              })
             this.form_data.userPermission=this.userPermission;
              this.sub_section_value='';
              this.unit_value='';
              this.sbu_name_value='';
              this.department_name_value='';
              this.section_value='';
              this.sub_section_value='';
              this.work_location_value='';
              this.sbu_permission='';
              this.sbu_name='';
              this.unit_permission='';
              this.unit_name='';
              this.sub_unit_name='';
              this.sub_unit_permission='';
              this.sub_unit_name='';
              this.department_permission='';
              this.department_name='';
              this.section_permission='';
              this.sub_unit_value='';
              this.section_name='';
              this.sub_section_permission='';
              this.sub_section_name='';
              this.sub_section_permission='';
              this.sub_section_name='';
              this.work_location_permission='';
              this.work_location_name='';

             }else{
              alert('Sorry ! Select Employee and SUB Name !');
             }
              
              console.log(this.form_data.userPermission);
          },
          
           deleteRowMlevel(index) {
            this.userPermission.splice(index,1);
            this.form_data.userPermission=this.userPermission;
            console.log( this.form_data.userPermission);
          },

          
          onSelectOfficeTime(option){
            console.log(option);
            this.form_data.attendance_office_time= option.id;
            console.log(this.form_data.attendance_office_time);
          },
          tableToExcel(table, name){
                if (!table.nodeType) table = this.$refs.table
                var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
                window.location.href = this.uri + this.base64(this.format(this.template, ctx))
              },
          
          employeesSbu(option){
            this.sbu_permission= option.id;
            this.form_data.sbu_permission= option.id;
            this.sbu_name= option.text;
          },
          employeesUnit(option){
            this.unit_permission= option.id;
            this.form_data.unit_permission= option.id;
            this.unit_name= option.text;
          },
          employeesSubUnit(option){
            this.sub_unit_permission= option.id;
            this.form_data.sub_unit_permission= option.id;
            this.sub_unit_name= option.text;
          },
          onSelectDepartment(option){
            this.department_permission= option.id;
            this.form_data.department_permission= option.id;
            this.department_name= option.text;
          },

          employeesSection(option){
            this.section_permission= option.id;
            this.form_data.section_permission= option.id;
            this.section_name= option.text;
          },
          employeesSubSection(option){
            this.form_data.sub_section_permission= option.id;
            this.sub_section_permission= option.id;
            this.sub_section_name= option.text;
          },
          employeesWorkLocation(option){
            this.work_location_permission= option.id;
            this.form_data.work_location_permission= option.id;
           this.work_location_name= option.text;
          },
         
          onSelectEmployee(option){
            this.employee_id= option.id;
            this.form_data.employee_id= option.id;
              let uri = URL.baseUrl('employees_user_permission/'+option.id);
              console.log(uri);
              axios.get(uri)
                  .then(res => {
                    console.log(res.data);
                      // this.getResults(1);
                      this.userPermission=res.data;
                  })
                  .catch(error => {
                    this.showToster({status:0,message:'opps! something went wrong'});
                  })


          },
          EmployeegetResults(event){
            // var aa=this.search_input.length;
               console.log(this.search_input);
           if(this.search_input.length >= 5){
               let obj =this.option_data.employee_data.find(data => data.employee_id_no == this.search_input);
               let uri = URL.baseUrl('employees_user_permission/'+obj['id']);
                axios.get(uri)
                    .then(res => {
                      console.log(res.data);
                        // this.getResults(1);
                        this.userPermission=res.data;
                    })
                    .catch(error => {
                      this.showToster({status:0,message:'opps! something went wrong'});
                    })
            }

           } 
            

          
          
         
          
          
        }
    }
</script>
