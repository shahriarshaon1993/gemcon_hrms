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
                               <h3 class="card-title d-none d-md-block">SIM Inventory List</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <div  @click="getModalData($event,{dataUrl:'create/sim_allocation'},resetModal, type=1)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>
                                 <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                               </span>
                           </div>
                       </div>
                        <div class="row">
                          <div class="col-12 col-sm-12 col-md-3">
                            <div class="info-box">
                              <span class="info-box-icon bg-info elevation-1">
                              <i class="fa fa-paper-plane"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-text">No. of Employee </span>
                                <span class="info-box-number">
                                  {{lists.total_data}}
                                </span>
                              </div>
                            </div>
                          </div>
                           <div class="col-12 col-sm-12 col-md-3">
                             <div class="info-box">
                               <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                               <div class="info-box-content">
                                 <span class="info-box-text">SIM Assigned </span>
                                 <span class="info-box-number">
                                   {{lists.assign_no}}
                                 </span>
                               </div>
                             </div>
                           </div>
                           <div class="col-12 col-sm-12 col-md-3">
                             <div class="info-box mb-3">
                               <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-ban"></i></span>
                               <div class="info-box-content">
                                 <span class="info-box-text">Not Assigned </span>
                                 <span class="info-box-number">
                                   {{lists.not_assign_bo}}
                                 </span>
                               </div>
                             </div>
                           </div>
                           <div class="clearfix hidden-md-up"></div>
                           <div class="col-12 col-sm-12 col-md-3">
                             <div class="info-box mb-3">
                               <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-clock"></i></span>
                               <div class="info-box-content">
                                 <span class="info-box-text">Total Assigned Ceiling </span>
                                 <span class="info-box-number">{{lists.total_ceiling}}</span>
                               </div>
                             </div>
                           </div>
                       </div>
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
                        <th class="text-center" v-bind:class="getSortingClass('sim_number')" @click="sortingChanged('sim_number')">SIM Number <i class="fas fa-sort"></i></th>
                        <th class="text-center" v-bind:class="getSortingClass('sim_number')" @click="sortingChanged('sim_number')">Operator Name <i class="fas fa-sort"></i></th>
                        <th class="text-center" v-bind:class="getSortingClass('sim_number')" @click="sortingChanged('sim_number')"> Custodian<i class="fas fa-sort"></i></th>
                        <th class="text-center" v-bind:class="getSortingClass('sim_number')" @click="sortingChanged('sim_number')">Ceiling Amount <i class="fas fa-sort"></i></th>
                        <th class="text-center" v-bind:class="getSortingClass('sim_status')" @click="sortingChanged('sim_status')">Status <i class="fas fa-sort"></i></th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                     <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="index">
                        <td class="text-center">{{index+1}}</td>
                        <td class="text-center">{{form_data.sim_number}}</td>
                        <td class="text-center">{{form_data.operator_name}}</td>
                        <td class="text-left">
                          <span v-if="form_data.employee_id_no">
                            {{form_data.employee_fullname}} -[ {{form_data.employee_id_no }} ]
                          </span>
                          <span v-else> - </span>
                          
                      </td>
                        <td class="text-right">
                        
                            <span v-if="form_data.employee_id_no">
                           {{form_data.sim_ceiling_limit |number('0,0.00')}}
                            </span>
                            <span v-else> - </span>
                          
                        </td>
                        <td style="color:green;" class="text-center" v-if="form_data.sim_status==1">{{'Active'}}</td>
                        <td style="color:red;" class="text-center" v-else>{{'Inactive'}}</td>
                        <td class="text-center">
                          <button  @click="getModalData($event,{dataUrl:'edit/sim_inventory/'+form_data.id})" class="btn btn-info btn-xs" title="Edit" > <i class="fa fa-edit"> </i> Edit </button>
                          <button   @click="deleteItem({delUrl:'delete/sim_inventory/'+form_data.id})" title="Delete" class="btn btn-danger btn-xs" ><i class="fa fa-trash"></i> Delete</button>

                           </td>
                      </tr>
                    </tbody>
                     <tbody v-else>
                        <tr>
                            <td colspan="14" align="center">No data in database</td>
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

        <modal class="" name="myModal" height="auto" :clickToClose="false" width="800">
            <div v-if="modal_loading">
              <!-- <span v-if="type==1"> -->
                  <div class="widget-header modal-header">
                      <h4><i class="fa fa-bars"></i> SIM Inventory</h4>
                      <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modify-wraper modal-body">
                    <div class="container">
                      <form @submit.prevent="add({add:'add/sim_inventory'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                        <div class="row">
                          <div class="col-md-12">
                              <div class="row" style="margin-top: 47px;">
                               <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="col-md-12 control-label">SIM Number <sup style="color: red; top: -2px;">*</sup></label>
                                    <div class="col-md-12 inputGroupContainer">
                                       <div class="input-group">
                                          <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                          <input v-model="form_data.sim_number"  class="form-control" type="text" required="requiered">
                                       </div>
                                    </div>
                                 </div>
                               </div>
                               
                                <div class="col-md-6"> 
                                     <div class="form-group">
                                       <label class="col-md-6 control-label">Operator Name <sup style="color: red; top: -2px;">*</sup></label>
                                       <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <select class="form-control" v-model="form_data.operator_name" required="true">
                                                <option disabled>--Select--</option>
                                                <option value="GP">GP</option>
                                                <option value="BL">BL</option>
                                                <option value="Robi">Robi</option>
                                                <option value="AirTel">Air Tel</option>
                                                <option value="Teletalk">Teletalk</option>
                                             </select>
                                       </div>
                                    </div>
                                  </div> 
                                </div>
                                </div>
                                <div class="form-group" v-if="form_data.id">
                                   <label class="col-md-6 control-label">Status</label>
                                   <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group">
                                         <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                         <select class="form-control" v-model="form_data.sim_status" required="true">
                                            <option disabled>--Select--</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                         </select>
                                      </div>
                                   </div>
                                </div>
                          </div>
                        </div>
                        <div class="form-actions col-md-12" style="margin-top: 47px;">
                            <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2">
                            <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button>
                        </div>
                    </form>
                  </div>
                </div>
              <!-- </span> -->
          </div>
              <div v-if="!modal_loading">
                  <pageLoading></pageLoading>
              </div>
          </modal>

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
            getContext:'',
         }
       },

        created(){
            this.getResults(1);
        },
        components:{
            pageLoading:Loading
        },
             
         methods:{
           setModalData(){
             this.profile_open=1;
             this.employee_name_value=this.form_data.employee_name_value;
             this.sim_number_value=this.form_data.sim_number_value;
             this.gross_salary_entry=this.form_data.gross_salary;
             this.basic_salary_entry=this.form_data.basic_salary;
             this.housing_allowance_entry=this.form_data.housing_allowance;
             this.medical_allowance_entry=this.form_data.medical_allowance;
             this.conveyance_allowance_entry=this.form_data.conveyance_allowance;
             this.overtime_work_compensation_entry=this.form_data.overtime_work_compensation;
           },
           resetModal(){
             this.gross_salary_entry='';
             this.basic_salary_entry='';
             this.housing_allowance_entry='';
             this.medical_allowance_entry='';
             this.conveyance_allowance_entry='';
             this.overtime_work_compensation_entry='';
             this.employee_name_value='';
             this.profile_open='';
             this.form_data.car_allowance_status=2;
             this.form_data.provident_fund=1;
             this.form_data.arrear_others_allowance=1;
             this.car_allowance_field='';
             this.others_allowance_entry='';
           },
         }
    }



</script>
<style type="text/css">
  .salaryTable.table td{
    padding: 15px 5px;
  }
</style>