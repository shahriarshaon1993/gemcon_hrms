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
                               <h3 class="card-title d-none d-md-block">Pay Slip List</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <!-- <div v-if="lists.add=='add'"  @click="getModalData($event,{dataUrl:'create/increment'},resetModal)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>

                                 <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a> -->
                               </span>
                           </div>
                       </div>
                       <!-- <div class="row">
                          <div class="col-12 col-sm-12 col-md-4">
                            <div class="info-box">
                              <span class="info-box-icon bg-info elevation-1"><i class="fa fa-paper-plane"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-text">No. of Pay Slip </span>
                                <span class="info-box-number">
                                  {{lists.total_data}}
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-sm-12 col-md-4">
                             <div class="info-box">
                               <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
                               <div class="info-box-content">
                                 <span class="info-box-text">Inactive </span>
                                 <span class="info-box-number">
                                   {{lists.inactive_data}}
                                 </span>
                               </div>
                             </div>
                          </div>
                          <div class="col-12 col-sm-12 col-md-4">
                             <div class="info-box mb-3">
                               <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>
                               <div class="info-box-content">
                                 <span class="info-box-text">Active </span>
                                 <span class="info-box-number">
                                   {{lists.active_data}}
                                 </span>
                               </div>
                             </div>
                          </div>
                          <div class="clearfix hidden-md-up"></div>
                        </div> -->
                    </div>
                    <div class="card-body col-md-12">
                      <div class="col-md-6 col-sm-6 col-6 float-left" style="padding:0px;">
                          <div id="DataTables_Table_0_length" class="">
                              Show
                              <label> 
                                  <select class="form-control pagination-number" @change="onChange($event)" v-model="paginate_num"  name="pageSize">
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="5">5</option>
                                      <option value="10">10</option>
                                      <option value="15">15</option>
                                      <option value="20">20</option>
                                      <option value="25">25</option>
                                      <option value="30">30</option>
                                      <option value="35">35</option>
                                      <option value="40">40</option>
                                  <option value="45">45</option>
                                  <option value="50">50</option>
                              </select>
                          </label>
                          entries
                      </div>
                  </div>

                  <div class="col-md-6 col-sm-6 col-6 float-left" style="padding:0px;">
                      <div class="dataTables_filter" id="DataTables_Table_0_filter">
                          <label class="float-right">
                              <div class="input-group"><span class="input-group-addon"><i class="icon-search"></i></span>
                                  <input v-on:keyup="getResults" v-model="search_input.search_key" type="text" aria-controls="DataTables_Table_0" class="form-control search-keyword" id="search"  placeholder="Search...">
                              </div>
                          </label>
                      </div>
                  </div>

                  <table id="employeeTable" class="table table-bordered table-striped employeeTable">
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Designation</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Company/SBU</th>
                        <th class="text-center">Work Loc.</th>
                        <th class="text-center">Month</th>
                        <th class="text-center">Gross Salary</th>
                        <th class="text-center">Addition</th>
                        <th class="text-center">Deduction</th>
                        <th class="text-center">Net Payable</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                     <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                        <td class="text-center">{{index+1}}</td>
                        <td class="text-center">{{form_data.employee_id_no}}</td>
                        <td>{{form_data.employee_fullname}}</td>
                        <td class="text-left">{{form_data.designation_name}}</td>
                        <td class="text-left">{{form_data.department_name}}</td>
                        <td class="text-left">{{form_data.sbu_name}}</td>
                        <td class="text-center">{{form_data.work_location_name}}</td>
                        <td class="text-right">{{form_data.paymonth}}</td>
                        <td class="text-right">{{form_data.gross_salary |number('0,0.00')}}</td>
                        <td class="text-right">{{form_data.total_additions |number('0,0.00')}}</td>
                        <td class="text-right">{{form_data.total_deduction |number('0,0.00')}}</td>
                        <td class="text-right">{{form_data.netpay |number('0,0.00')}}</td>
                        <td class="text-center">
                          <!-- v-if="lists.view=='view'" -->
                          <router-link  href="#" :to="'/pay_slip_details/'+form_data.id" class="btn btn-xs btn-info" title="Add More Data">
                            <i class="fa fa-info" aria-hidden="true"></i> Pay Slip
                          </router-link>
                        </td>
                      </tr>
                    </tbody>
                     <tbody v-else>
                        <tr>
                            <td colspan="12" align="center">No data in database</td>
                        </tr>
                    </tbody>
                  </table>
                  <div class="row">
                    <div class="dataTables_footer clearfix col-md-12 col-12" style="padding: 10px 0px;">
                        <div class="col-md-6 col-6 float-left">
                            <div class="dataTables_info" id="DataTables_Table_0_info">Showing {{paginate_data.current_page}} of {{paginate_data.last_page}} pages</div>
                        </div>
                        <div class="col-md-6 col-6 float-right">
                            <div class="dataTables_paginate paging_bootstrap float-right">
                              <pagination :data="paginate_data" @pagination-change-page="getResults"></pagination>
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

       
      </div>
  </div>
  <div v-if="!page_loading">
      <pageLoading></pageLoading>
  </div>
</div>
</template>
<script>
  import Loading from '../Loading.vue';
  import Datepicker from 'vuejs-datepicker';
  export default {
    data(){
      return{
        employee_name_value:'',
        gross_salary_entry:'',
        basic_salary_entry:'',
        housing_allowance_entry:'',
        medical_allowance_entry:'',
        conveyance_allowance_entry:'',
        overtime_work_compensation_entry:'',
        profile_open:'',
        increment_type_field:'',
        car_allowance_field:'',
        increment_percentage_entry:'',
        gross_salary_entryyy:'',
        provident_fund_amount_entry:'',
      }
    },
    created(){
      this.getResults(1);
    },
    components:{
        pageLoading:Loading
    },
   
    methods:{
      onSelectEmployee(option){
        console.log(option);
        this.form_data.employee_id= option.id;
        console.log(this.form_data.employee_id);
      },
      onSelectEmployeeSearch(option){
        this.profile_open=1;
        this.getModalDataOther(option.id);
        this.form_data.employee_id= option.id;
        this.form_data.employee_id=this.form_data.employee_id;
        console.log(this.form_data.employee_id);
        console.log(option);
        let allData =this.form_data.user_employee_data_all[option.id];
        this.form_data.employee_id= allData['id']; 
      },
      getModalDataOther(id){
        // console.log('aaaaaa');
        let uri = URL.baseUrl('other_create/increment/'+id);
        console.log(uri);
        axios.get(uri)
        .then(res => {
          console.log(res.data);
          this.form_data = res.data;
          this.form_data.employee_id=id;
          this.form_data.car_allowance_status=2;
          this.form_data.increment_type=2;
          this.increment_type_field=2;
          this.errors =null;
          if(callback){
            callback();
          }
        })
        .catch(error => {
          this.modal_page_loading= true;
        })
      },
      
      setModalData(){
        this.employee_name_value=this.form_data.employee_name_value;
        this.gross_salary_entry=this.form_data.gross_salary.toFixed(2);
        this.basic_salary_entry=this.form_data.basic_salary.toFixed(2);
        this.housing_allowance_entry=this.form_data.housing_allowance.toFixed(2);
        this.medical_allowance_entry=this.form_data.medical_allowance.toFixed(2);
        this.conveyance_allowance_entry=this.form_data.conveyance_allowance.toFixed(2);
        this.overtime_work_compensation_entry=this.form_data.overtime_work_compensation.toFixed(2);
        this.profile_open=1;
        this.increment_type_field = this.form_data.increment_type;
        this.increment_percentage_entry = this.form_data.increment_percentage;
      },
      resetModal(){
        this.gross_salary_entry='';
        this.basic_salary_entry='';
        this.housing_allowance_entry='';
        this.medical_allowance_entry='';
        this.conveyance_allowance_entry='';
        this.overtime_work_compensation_entry='';
        this.profile_open='';
        this.employee_name_value='';
        this.car_allowance_field='';
        this.increment_type_field=2;
        this.form_data.car_allowance_status=2;
        this.form_data.increment_type=2;
      },
      car_allowance(e){
         var val = e.target.value;
         if (val==1) {
           this.car_allowance_field=1;
         }else{
           this.car_allowance_field=2;
         }
      },
      increment_type(e){
          var val = e.target.value;
          if (val==1) {
            this.increment_type_field=1;
            this.increment_percentage_entry='';
            this.gross_salary_entry='';
            this.basic_salary_entry='';
            this.housing_allowance_entry='';
            this.medical_allowance_entry='';
            this.conveyance_allowance_entry='';
          }else{
            this.increment_type_field=2;
            this.increment_percentage_entry='';
            this.basic_salary_entry='';
            this.gross_salary_entry='';
            this.housing_allowance_entry='';
            this.medical_allowance_entry='';
            this.conveyance_allowance_entry='';
          }

      }
    }
  }
</script>