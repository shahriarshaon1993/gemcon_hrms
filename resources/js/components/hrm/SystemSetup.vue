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
                               <h3 class="card-title d-none d-md-block">Department List</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <!-- <a class="btn btn-info" href="#" data-toggle="modal" data-target="#addNewDepartment"><i class="fa fa-plus"></i> Add New</a> -->
                                 <div  @click="getModalData($event,{dataUrl:'create/department'},resetModal)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>

                                 <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>

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
                        <th class="text-center">#</th>
                        <th class="text-center">Department Code</th>
                        <th class="text-center">Department Name</th>
                        <th class="text-center">No. of Emploee</th>
                        <th class="text-center">Department Head</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                     <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                        <td class="text-center">{{index+1}}</td>
                        <td class="text-center">{{form_data.department_code}}</td>
                        <td>{{form_data.department_name}}</td>
                        <td class="text-center">{{0}}</td>
                        <td class="text-center">{{'--'}}</td>
                        <td class="text-center">
                          <button @click="getModalData($event,{dataUrl:'edit/department/'+form_data.id})" class="btn-xs" title="Edit" > <i class="fa fa-edit"> </i> Edit |</button>
                        
                          <button  @click="deleteItem({delUrl:'delete/department/'+form_data.id})" title="Delete" class="btn-xs" ><i class="fa fa-trash"></i> Delete</button>


                           </td>
                      </tr>
                    </tbody>
                     <tbody v-else>
                        <tr>
                            <td colspan="3" align="center">No data in database</td>
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

       <modal class="" name="myModal" height="auto" :clickToClose="false">
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
          </modal>




          <!-- Bootstrap Modal -->
           <!-- <modal name="myModal"  height="auto" :clickToClose="false"> -->
          <!-- <div class="modal fade addNewDepartment" id="addNewDepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">Add Department</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body addNewEmployee">
                  <div class="container">
                         <table class="table table-striped">
                            <tbody>
                               <tr>
                                  <td colspan="1">
                                    <form @submit.prevent="add({add:'add/department'})" class="form-horizontal  row-border" id="validate-1">
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
                                           <div style="margin-top:15px;">
                                             <button type="submit" class="btn btn-info float-right" style="margin-left: 10px;" hide-footer="true">Save changes</button>
                                             <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
                                           </div>
                                        </div>
                                      </div>
                                     </form>
                                  </td>
                               </tr>
                            </tbody>
                         </table>
                      </div>
                </div>
              </div>
            </div>
            </modal>
          </div> -->
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
        }
    }



</script>
