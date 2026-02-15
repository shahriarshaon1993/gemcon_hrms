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
                               <h3 class="card-title d-none d-md-block">Attendance Log</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <!-- <div  @click="getModalData($event,{dataUrl:'create/department'},resetModal)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div> -->
                                 <a @click="$router.go(-1)" class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                               </span>
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
                        <th class="text-center">SL</th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('employee_id')" @click="sortingChanged('employee_Id')">Employee ID <i class="fas fa-sort"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Employee Name <i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('sbu_name')" @click="sortingChanged('sbu_name')">SBU<i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('department_name')" @click="sortingChanged('department_name')">Department<i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Designation<i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('total_dep_emp')" @click="sortingChanged('total_dep_emp')">Date<i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Time<i class="fas fa-sort text-right"></i></th>
                      </tr>
                    </thead>
                     <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                        <td class="text-center">{{order_no+index+1}}</td>
                        <td class="text-center">{{form_data.employee_id}}</td>
                        <td>{{form_data.employee_fullname}}</td>
                        <td class="">{{form_data.sbu_name}}</td>
                        <td class="">{{form_data.department_name}}</td>
                        <td class="">{{form_data.designation_name}}</td>
                        <td class="text-center">{{form_data.TransactionDate}}</td>
                        <td class="">{{form_data.TransactionTime}}</td>
                      </tr>
                    </tbody>
                     <tbody v-else>
                        <tr>
                            <td colspan="8" align="center">No data in database</td>
                        </tr>
                    </tbody>
                  </table>
                  <div class="row">
                        <div class="dataTables_footer clearfix" style="width: 100%">
                            <div class="col-md-6" style="float: left;">
                                <div class="dataTables_info" id="DataTables_Table_0_info">Showing {{paginate_data.current_page}} of {{paginate_data.last_page}} pages</div>
                            </div>
                            <div class="col-md-6" style="float: right;">
                                <div class="dataTables_paginate paging_bootstrap">
                                    <pagination :data="paginate_data" :limit="2" @pagination-change-page="getResults"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                  <!-- <div class="row">
                       <div class="dataTables_footer clearfix col-md-12 col-12" style="padding: 10px 0px;">
                           <div class="col-md-6 col-6 float-left">
                               <div class="dataTables_info" id="DataTables_Table_0_info">Showing {{paginate_data.current_page}} of {{paginate_data.last_page}} pages</div>
                           </div>
                           <div class="col-md-6 col-6 float-right">
                               <div class="dataTables_paginate paging_bootstrap float-right overflow-auto" style="width: 100%;">
                                 <pagination :data="paginate_data" @pagination-change-page="getResults"></pagination>
                               </div>
                           </div>
                       </div>
                    </div> -->
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

       <!-- <modal class="" name="myModal" height="auto" :clickToClose="false">
            <div v-if="modal_loading">
                <div class="widget-header modal-header">
                    <h4><i class="icon-reorder"></i>Department Form</h4>
                    <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modify-wraper modal-body">
                  <div class="container">
                    <form @submit.prevent="add({add:'add/department'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                      <div class="row">
                        <div class="col-md-8 offset-md-2">
                           <div class="form-group">
                              <label class="col-md-6 control-label">Department Name</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <input id="department_name" v-model="form_data.department_name" name="department_name" placeholder="" class="form-control" required="true" type="text"></div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-6 control-label">Department Head</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                  <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                                </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-6 control-label">Status</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <select class="form-control" v-model="form_data.department_status" required="true">
                                       <option disabled>--Select--</option>
                                       <option value="1">Active</option>
                                       <option value="0">Inactive</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>
                      </div>
                      <div class="form-actions col-md-12" style="padding:15px 60px 40px 0px;">
                          <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2" style="margin-right: 50px;">
                          <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button>
                      </div>
                  </form>
                </div>
              </div>
          </div>
              <div v-if="!modal_loading">
                  <pageLoading></pageLoading>
              </div>
          </modal> -->
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
           employee_name_value:'',
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
            this.form_data.department_head= option.id;
            console.log(this.form_data.department_head);
          },
          setModalData(){
            this.employee_name_value=this.form_data.employee_name_value;
          },
        }
    }



</script>
