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
                               <h3 class="card-title d-none d-md-block">Bonus Process</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                               </span>
                           </div>
                       </div>
                    </div>
                    <div class="card-body col-md-12">
                      <div class="row col-md-12">
                          <div class="form-group col-md-2" style="padding:0px;">
                             <label class="col-md-12 control-label">Month <sup style="color:red; top: -2px;">*</sup></label>
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                   <select @change="monthsSelectsId($event)" class="form-control" v-model="monthly_id" >
                                      <option id="" disabled>--Select Month--</option>
                                      <option v-for="months in option_data.months_array"  :value='months.id' >{{months.text }}
                                      </option>
                                      
                                   </select>
                                </div>
                             </div>
                          </div>

                          <div class="form-group col-md-2" style="padding:0px;">
                             <label class="col-md-12 control-label">Bonus Grade <sup style="color:red; top: -2px;">*</sup></label>
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                   
                                   <select @change="SalaryGrade($event)" class="form-control" v-model="Salary_grade" >
                                      <option id="" disabled>--Salary Grade--</option>
                                       <option v-for="payrollPerm in option_data.payrollPermissions"  :value='payrollPerm.id' >{{payrollPerm.text }}
                                      </option>
                                   </select>
                                </div>
                             </div>
                          </div> 

                          <div class="form-group col-md-2" style="padding:0px;">
                             <label class="col-md-12 control-label">Bonus Type <sup style="color:red; top: -2px;">*</sup></label>
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                   <select @change="SalaryTypeId($event)" class="form-control" v-model="Salary_type" >
                                      <option id="" disabled>--Salary Type--</option>
                                      <option value='1'>Cash</option>
                                       <option value='2'>Bank </option>
                                      
                                   </select>
                                </div>
                             </div>
                          </div>  
                          <div class="form-group col-md-2" style="padding:0px;">
                             <label class="col-md-12 control-label">Bonus For <sup style="color:red; top: -2px;">*</sup></label>
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                   <select  @change="BonusForID($event)" class="form-control" v-model="bonus_for" >
                                      <option id="" disabled>--Bonus for--</option>
                                      <option value='1'>Eid-Ul-Fitr</option>
                                       <option value='2'>Eid-Ul-Adha</option>
                                   </select>
                                </div>
                             </div>
                          </div>
                          <div class="col-md-3" style="padding:0px;" >
                              <div class="form-group" id="company_sbu_show" >
                                 <label class="col-md-12 control-label">Company/SBU <sup style="color:red; top: -2px;">*</sup></label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                     <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                     <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbuId" placeholder="Select one" label="text" track-by="text"></vue-select>
                                   </div>
                                 </div>
                              </div>
                            </div>
                      <div class="form-group col-md-1" style="padding:0px;">
                             <label class="col-md-12 control-label"> </label>
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                <span v-if="employeesSbu && months_id && salary_grade">
                                   <a @click="addBonusProcess($event)" id="addCF" class="btn btn-xs " style="color: #212529 !important;padding: .3rem .25rem;background-color: #fac23c;border-color: #fac23c;"><i class="fa fa-spinner" style="color: #212529 !important;background-color: #fac23c;border-color: #fac23c;"></i> Submit </a>
                                </span>
                                </div>
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

        <section class="content" v-if="form_data.employee_data">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                       
                    </div>
                    <div class="card-body col-md-12">
                      <div class="row col-md-12" v-if="(form_data.employee_data).length > 0">
                        <form @submit.prevent="add({add:'add/bonus_process'})"  id="validate-1" style="overflow-x: scroll;" >
                            <input type="submit"    style="width: 130px;margin-bottom: 9px;" tabindex="4" value="Save" class="btn btn-sm btn-info col-md-1">
                          <div class="col-md-12" style="padding:0px;">
                            <!-- <div class="col-md-1">   -->
                            <!-- </div>    -->
                            <div class=" " style="min-height: 56px;" v-if="modal_loading">
                              <!-- <div class=""> -->
                            <table id="employeeTable_ids" class="table table-bordered  table-striped employeeTable" style="table-layout:fixed;width: 100% !important">
                              <thead>
                                <tr style="text-align: center;">
                                  <th rowspan="2" style="vertical-align: middle;width: 50px" >SL</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 120px;" >Employee ID</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 200px;" >Employee Name</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 200px;" >Designation</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 100px;" >Grade</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 95px;"  >Joining Date</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 100px;" >A/C No</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 100px;" >Gross Salary</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 90px;" >Basic Salary</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 90px;" >Bonus Per.</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 90px;" >Bonus Amount</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 120px;" >Net Payable</th>
                                </tr>
                              </thead>
                               <tbody>
                                <tr v-for="(form_data, index) in form_data.employee_data" v-bind:key="form_data.id" >
                                  <td class="text-center">{{index+1}}</td>
                                  <td > {{form_data.employee_id_no}}</td>
                                  <td>{{form_data.employee_fullname}}</td>
                                  <td>{{form_data.designation_name}}</td>
                                  <td>{{form_data.jobgrade_name}}</td>
                                  <td>{{form_data.employee_joining_date}}</td>
                                  <td>{{form_data.ebc_account_number}}</td>
                                  <td class="text-right" style="width: 81px;vertical-align: middle;">{{form_data.g_salary |number('0,0.00') }}</td>
                                  <td class="text-right" style="width: 81px;vertical-align: middle;">{{form_data.b_salary |number('0,0.00') }}</td>
                                  <td class="text-center" style="width: 81px;vertical-align: middle;">{{form_data.bonus_percentage }}</td>
                                  <td class="text-right" style="width: 81px;vertical-align: middle;">{{form_data.bonus_amount |number('0,0.00') }}</td>
                                  <td class="text-right" style="width: 180px;vertical-align: middle;">{{form_data.bonus_amount |number('0,0.00') }}</td>
                                </tr>
                              </tbody>
                            </table>
                           <!-- </div>  -->
                          </div>
                         <div v-if="!modal_loading">
                   <pageLoading></pageLoading>
               </div>
                          </div>
                         </form>
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
           employee_data_approvaldat:'',
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
           noticeToType:0,
           noticeToTypeName:'',
           employeesSbu:'',
           monthly_id:'',
           Salary_grade:'',
           Salary_type:'',
           bonus_for:'',
           week_id:'',
           roaster_type:'',
           permission_id:'',
           formDataAll:'',
           weekly_id:0,
           weeks_id:0,
           weekly_data:'',
           months_id:0,
           permission_id_name:'',
           employees_list:[],
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
           console.log(event.target.value);
            this.salary_type_id=event.target.value;
        }, 
        BonusForID(event){
          this.bonus_for=event.target.value;
          console.log(this.bonus_for);
        }, 
        SalaryGrade(event){
            this.salary_grade=event.target.value;
        },
        addBonusProcess(event){
          this.modal_loading= false;
          let uri = URL.baseUrl('bonus_process/find_employee_data');
          axios.post(uri,
            {
                id:this.employeesSbu,
                months_id:this.months_id,
                salary_type_id:this.salary_type_id,
                bonus_for:this.bonus_for,
                salary_grade:this.salary_grade,
            }).then(res => {
              console.log(res);
              this.form_data=res.data;
              this.modal_loading= true;
            })
            .catch(error => {
              this.modal_loading= true;
          })

        },

        employeesSbuId(option){
          this.employeesSbu=option.id;
        },
        // employeesSection(option){
        //   this.modal_loading= false;
        //   let uri = URL.baseUrl('shift_time/fiends');
        //   axios.post(uri,
        //     {
        //         types:'5',
        //         id:option.id,
        //         roaster_id:this.weekly_id,
        //         week_id:this.weeks_id,
        //         months_id:this.months_id,
        //     }).then(res => {
        //       console.log(res);
        //      this.form_data=res.data;
        //       this.modal_loading= true;
        //       console.log('hell');
        //     })
        //     .catch(error => {
        //       this.modal_loading= true;
        //   })
        // },
        // employeesSubSection(option){
        //   this.modal_loading= false;
        //   let uri = URL.baseUrl('shift_time/fiends');
        //   axios.post(uri,
        //     {
        //         types:'6',
        //         id:option.id,
        //         roaster_id:this.weekly_id,
        //         week_id:this.weeks_id,
        //         months_id:this.months_id,
        //     }).then(res => {
        //       console.log(res);
        //       this.form_data=res.data;
        //       this.modal_loading= true;
        //       console.log('hell');
        //     })
        //     .catch(error => {
        //       this.modal_loading= true;
        //   })
        // },
        // employeesGroup(option){
        //   // console.log(option);
        //   // this.form_data.employee_group= option.id;
        //   // this.permission_id=option.id;
        //   // this.permission_id_name=option.text;
        //   // console.log(this.form_data.employee_group);
        //   this.modal_loading= false;
        //   let uri = URL.baseUrl('shift_time/fiends');
        //   axios.post(uri,
        //     {
        //         types:'1',
        //         id:option.id,
        //         roaster_id:this.weekly_id,
        //         week_id:this.weeks_id,
        //         months_id:this.months_id,
        //     }).then(res => {
        //       console.log(res);
        //       this.form_data=res.data;
        //       this.modal_loading= true;
        //       console.log('hell');
        //     })
        //     .catch(error => {
        //       this.modal_loading= true;
        //   })
        // },
        // employeesSubUnit(option){
        //   // console.log(option);
        //   // this.form_data.subunit_id= option.id;
        //   // this.permission_id=option.id;
        //   // this.permission_id_name=option.text;
        //   this.modal_loading= false;
        //   let uri = URL.baseUrl('shift_time/fiends');
        //   axios.post(uri,
        //     {
        //         types:'4',
        //         id:option.id,
        //         roaster_id:this.weekly_id,
        //         week_id:this.weeks_id,
        //         months_id:this.months_id,
        //     }).then(res => {
        //       console.log(res);
        //       this.form_data=res.data;
        //       this.modal_loading= true;
        //       console.log('hell');
        //     })
        //     .catch(error => {
        //       this.modal_loading= true;
        //   })
        // },
        // employeesUnit(option){
        //   // console.log(option);
        //   // this.form_data.unit_id= option.id;
        //   // this.permission_id=option.id;
        //   // this.permission_id_name=option.text;
        //   this.modal_loading= false;
        //   let uri = URL.baseUrl('shift_time/fiends');
        //   axios.post(uri,
        //     {
        //         types:'3',
        //         id:option.id,
        //         roaster_id:this.weekly_id,
        //         week_id:this.weeks_id,
        //         months_id:this.months_id,
        //     }).then(res => {
        //       console.log(res);
        //       this.form_data=res.data;
        //       this.modal_loading= true;
        //       console.log('hell');
        //     })
        //     .catch(error => {
        //       this.modal_loading= true;
        //   })
        // },
        // employeesWorkLocation(option){
        //   // console.log(option);
        //   // this.form_data.employee_work_location= option.id;
        //   // this.permission_id=option.id;
        //   // this.permission_id_name=option.text;
        //   // console.log(this.form_data.employee_work_location);
        //   this.modal_loading= false;
        //   let uri = URL.baseUrl('shift_time/fiends');
        //   axios.post(uri,
        //     {
        //         types:'1',
        //         id:option.id,
        //         roaster_id:this.weekly_id,
        //         week_id:this.weeks_id,
        //         months_id:this.months_id,
        //     }).then(res => {
        //       console.log(res);
        //       this.form_data=res.data;
        //       this.modal_loading= true;
        //       console.log('hell');
        //     })
        //     .catch(error => {
        //       this.modal_loading= true;
        //   })
        // },
        // onSelectDepartment(option){
        //   console.log(option);
        //   // this.form_data.department_id= option.id;
        //   // this.permission_id=option.id;
        //   // this.permission_id_name=option.text;
        //   // console.log(this.form_data.employee_department);
        //   this.modal_loading= false;
        //   let uri = URL.baseUrl('shift_time/fiends');
        //   axios.post(uri,
        //     {
        //         types:'2',
        //         id:option.id,
        //         roaster_id:this.weekly_id,
        //         week_id:this.weeks_id,
        //         months_id:this.months_id,
        //     }).then(res => {
        //       console.log(res);
        //       this.form_data=res.data;
        //       this.modal_loading= true;
        //       console.log('hell');
        //     })
        //     .catch(error => {
        //       this.modal_loading= true;
        //   })
        // },
        // onSelectDesignation(option){
        //   // console.log(option);
        //   // this.form_data.employee_designation= option.id;
        //   // this.permission_id=option.id;
        //   // this.permission_id_name=option.text;
        //   // console.log(this.form_data.employee_designation);
        //   this.modal_loading= false;
        //   let uri = URL.baseUrl('shift_time/fiends');
        //   axios.post(uri,
        //     {
        //         types:'1',
        //         id:option.id,
        //         roaster_id:this.weekly_id,
        //         week_id:this.weeks_id,
        //         months_id:this.months_id,
        //     }).then(res => {
        //       console.log(res);
        //       this.form_data=res.data;
        //       this.modal_loading= true;
        //       console.log('hell');
        //     })
        //     .catch(error => {
        //       this.modal_loading= true;
        //   })
        // },
        onSelectJobGrade(option){
          console.log(option);
          this.form_data.employee_job_grade= option.id;
          this.permission_id=option.id;
          this.permission_id_name=option.text;
          console.log(this.form_data.employee_job_grade);
        },
        onSelectEmployee(option){
          console.log(option);
          this.form_data.employee_id = option.id;
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
           this.form_data.employee_status='1';
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
  content: '';
}
.select_id > .multiselect > .multiselect__tags{
  min-height: 41px !important;
}

</style>
