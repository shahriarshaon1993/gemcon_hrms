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
                           <h3 class="card-title d-none d-md-block">Leave Setup</h3>
                           <span class="float-sm-right" style="float: right;">
                            
                             <div  v-if="lists.add=='add'" @click="getModalData($event)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span> </div>
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
                      <th class="text-center">#</th>
                      <th class="text-center" v-bind:class="getSortingClass('attendance_machine_code')" @click="sortingChanged('attendance_machine_code')">Attendance Machine Code <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('attendance_machine_name')" @click="sortingChanged('attendance_machine_name')">Attendance Machine Name <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('attendance_machine_status')" @click="sortingChanged('attendance_machine_status')">Attendance Machine Status <i class="fas fa-sort"></i></th>
                      <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                        <td class="text-center">{{index+1}}</td>
                        <td class="text-center">{{form_data.attendance_machine_code}}</td>
                        <td class="text-center">{{form_data.attendance_machine_name}}</td>
                        <td class="text-center" v-if="form_data.attendance_machine_status==1">{{'Active'}}</td>
                        <td class="text-center" v-else>{{'Inactive'}}</td>
                        <td class="text-center">
                          <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/attendancemachine/'+form_data.id})" class="btn-xs btn-info" title="Edit" > <i class="fa fa-edit"> </i> </button>
                          <button  v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/attendancemachine/'+form_data.id})" title="Delete" class="btn-xs btn-danger" ><i class="fa fa-trash"></i> </button>
                        </td>
                    </tr>
                    </tbody>
                     <tbody v-else>
                        <tr>
                            <td colspan="7" align="center">No data in database</td>
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


       <modal name="myModal" width="550" height="auto"  :clickToClose="false"> 
            <div v-if="modal_loading">
                <div class="widget-header modal-header">
                    <h4><i class="icon-reorder"></i>Attendance Machine Form</h4>
                    <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modify-wraper modal-body">
                  
                  <div class="container">
                         <table class="table table-striped">
                            <tbody>
                               <tr>
                                  <td colspan="1">
                                     <form @submit.prevent="add({add:'add/attendancemachine'},resetModal)" class="well form-horizontal needs-validation" novalidate>
                                      <div class="row">
                                        <div class="col-md-12">
                                           <div class="form-group">
                                              <label class="col-md-6 control-label">Attendance Machine Name</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                    <input v-model="form_data.attendance_machine_name" id="leave_days" name="leave_days" placeholder="" class="form-control" required="true" type="text">
                                                 </div>
                                              </div>
                                           </div>
                                           <div class="form-group">
                                              <label class="col-md-6 control-label">Attendance Machine Status</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                    <select class="form-control" v-model="form_data.attendance_machine_status" required="true">
                                                       <option disabled>--Select--</option>
                                                       <option value="1">Active</option>
                                                       <option value="0">Inactive</option>
                                                    </select>
                                                 </div>
                                              </div>
                                           </div>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                                    <button type="button" @click="hideModal" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                                    <input type="submit"  value="Submit" class="btn btn-primary pull-right">
                                                </div>
                                     </form>
                                  </td>
                               </tr>
                            </tbody>
                         </table>
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
            form_data:{
              attendance_machine_status:1,
            },
            attendance_machine_value:'',
            office_time_value:'',
          }
        },
        created(){
            this.getResults(1);
        },

        components:{
            pageLoading:Loading
        }
    }



</script>
