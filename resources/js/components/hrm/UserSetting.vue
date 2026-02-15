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
                           <h3 class="card-title d-none d-md-block">User Setting</h3>
                           <span class="float-sm-right" style="float: right;">
                             <!-- <a class="btn btn-info" href="#" data-toggle="modal" data-target="#addNewDesignation"><i class="fa fa-plus"></i> Add New</a> -->
                             <div  v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/usersetting'},resetModal)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span> </div>
                             <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                           </span>
                       </div>
                   </div>
                </div>
                <!-- /.card-header -->
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
                      <th class="text-center" v-bind:class="getSortingClass('employee_card_no')" @click="sortingChanged('employee_card_no')">Employee ID <i class="fas fa-sort"></i></th>
                       <th class="text-center" v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Employee <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('name')" @click="sortingChanged('name')">Name <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('email')" @click="sortingChanged('email')">Email <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('role_name')" @click="sortingChanged('role_name')">Role <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('user_type')" @click="sortingChanged('user_type')">Access Level <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('sbu_name')" @click="sortingChanged('sbu_name')">Company <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('status')" @click="sortingChanged('status')">Status <i class="fas fa-sort"></i></th>
                      <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                        <td class="text-center">{{index+1}}</td>
                        <td class="text-center">{{form_data.employee_card_no}}</td>
                        <td class="text-left">{{form_data.employee_fullname}}</td>
                        <td>{{form_data.name}}</td>
                        <td >
                          <span v-if="form_data.email">
                            {{form_data.email}}
                          </span>
                          <span v-else> - </span>
                        </td>
                        <td class="text-center">{{form_data.role_name}}</td>
                        <td class="text-center">
                            <span v-if='form_data.user_type==1'>
                              Company/SBU
                            </span>
                            <span v-if='form_data.user_type==2'>
                              Company/SBU
                            </span>
                            <span v-if='form_data.user_type==3'>
                              Unit
                            </span>
                            <span v-if='form_data.user_type==4'>
                             Sub Unit
                            </span>
                            <span v-if='form_data.user_type==5'>
                             Department
                            </span>
                            <span v-if='form_data.user_type==6'>
                             Section
                            </span>
                            <span v-if='form_data.user_type==7'>
                             Sub Section
                            </span>
                            <span v-if='form_data.user_type==8'>
                              Work Loc.
                            </span>
                            <span v-if='form_data.user_type==9'>
                              Employee
                            </span>
                           
                        </td>
                        <td class="text-left">{{form_data.sbu_name}}</td>
                        
                        <td class="text-center" v-if="form_data.status==1">{{'Active'}}</td>
                        <td class="text-center" v-else>{{'Inactive'}}</td>
                        <td class="text-center">
                          <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/usersetting/'+form_data.id},setModalData)" class="btn-xs btn-info" title="Edit" > <i class="fa fa-edit"> </i> Edit </button>
                          <button  v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/usersetting/'+form_data.id})" title="Delete" class="btn-xs btn-danger" ><i class="fa fa-trash"></i> Delete</button>
                        </td>
                    </tr>
                    </tbody>
                     <tbody v-else>
                        <tr>
                            <td colspan="5" align="center">No data in database</td>
                        </tr>
                    </tbody>
                  </table>
                   <div class="row">
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


       <modal ref="modal" class="employee-modal" name="myModal" height="auto" :clickToClose="false" body-class="p-0">
            <div v-if="modal_loading">
                <div class="widget-header modal-header">
                    <h4><i class="fa fa-bars"></i>User Form</h4>
                    <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modify-wraper modal-body">
                  
                  <div class="container">
                                     <form @submit.prevent="add({add:'add/usersetting'},resetModal)" class="well form-horizontal needs-validation" novalidate>
                                      <div class="row">
                                        <div class="col-md-12">
                                           <div class="form-group">
                                              <label class="col-md-4 control-label">Name</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                  <input v-model="form_data.name" placeholder="" class="form-control" required="true" type="text">
                                                </div>
                                              </div>
                                           </div>
                                           <div class="form-group">
                                              <label class="col-md-4 control-label">Email</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                  <input v-model="form_data.email" placeholder="" class="form-control" required="true" type="email">
                                                </div>
                                              </div>
                                           </div>
                                           <div class="form-group">
                                              <label class="col-md-4 control-label">Password</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                  <input v-model="form_data.password" placeholder="" class="form-control" required="true" type="password">
                                                </div>
                                              </div>
                                           </div>
                                           <div class="form-group">
                                              <label class="col-md-6 control-label">Company</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                    <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbu" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                 </div>
                                              </div>
                                           </div>
                                           <div class="form-group">
                                              <label class="col-md-6 control-label">Role</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                    <select v-model="form_data.role_id" class="selectpicker form-control">
                                                       <option>--Select--</option>
                                                       <option value="1">General</option>
                                                       <option value="2">Special</option>
                                                    </select>
                                                 </div>
                                              </div>
                                           </div>
                                           <div class="form-group">
                                              <label class="col-md-6 control-label">Employee</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                    <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                 </div>
                                              </div>
                                           </div>
                                           <div class="form-group" v-if="form_data.id">
                                              <label class="col-md-6 control-label">Status</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                    <select class="form-control" v-model="form_data.status" required="true">
                                                       <option disabled>--Select--</option>
                                                       <option value="1">Active</option>
                                                       <option value="0">Inactive</option>
                                                    </select>
                                                 </div>
                                              </div>
                                           </div>
                                        </div>
                                      </div>
                                      <div class="form-actions">
                                          <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2">
                                          <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button>
                                      </div>
                                     </form>
                      </div>
              </div>
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
       import $ from 'jquery'

    export default {
        data(){
          return{
            sbu_name_value:'',
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
          employeesSbu(option){
            console.log(option);
            this.form_data.company_id= option.id;
            console.log(this.form_data.company_id);
          },
          onSelectEmployee(option){
            console.log(option);
            this.form_data.employee_id= option.id;
            console.log(this.form_data.employee_id);
          },
          setModalData(){
            this.sbu_name_value=this.form_data.sbu_name_value;
            this.employee_name_value=this.form_data.employee_name_value;
          },
          resetModal(){
            this.sbu_name_value='';
            this.employee_name_value='';
          },
        }
    }
</script>
<style type="text/css">
  div.dataTables_paginate {
      float: right;
      margin: 0;
  }
</style>