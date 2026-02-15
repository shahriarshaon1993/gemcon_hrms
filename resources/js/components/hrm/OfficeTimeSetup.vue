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
                           <h3 class="card-title d-none d-md-block">Office Time Setup</h3>
                           <span class="float-sm-right" style="float: right;">
                             <div v-if="lists.add=='add'"  @click="getModalData($event,{dataUrl:'create/officetimesetup'})" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span> </div>
                             <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                           </span>
                       </div>
                   </div>
                    <div class="row">
                      <div class="col-12 col-sm-12 col-md-4">
                        <div class="info-box">
                          <span class="info-box-icon bg-info elevation-1"><i class="fa fa-paper-plane"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Total </span>
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
                       <!-- <div class="col-12 col-sm-12 col-md-3">
                         <div class="info-box mb-3">
                           <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-ban"></i></span>
                           <div class="info-box-content">
                             <span class="info-box-text">Rejected </span>
                             <span class="info-box-number">DDD</span>
                           </div>
                         </div>
                       </div> -->
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
                      <th class="text-center">SL<i class="fa fa-sort"></i></th>
                      <th class="text-left" v-bind:class="getSortingClass('office_time_start_date')" @click="sortingChanged('office_time_start_date')">Title <i class="fa fa-sort"></i></th>
                      <!-- <th class="text-center" v-bind:class="getSortingClass('office_time_start_date')" @click="sortingChanged('office_time_start_date')">Office Start Date <i class="fa fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('office_time_end_date')" @click="sortingChanged('office_time_end_date')">Office End Date <i class="fa fa-sort"></i></th> -->
                      <th class="text-center" v-bind:class="getSortingClass('office_start_time')" @click="sortingChanged('office_start_time')">Office Start Time <i class="fa fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('office_end_time')" @click="sortingChanged('office_end_time')">Office End Time <i class="fa fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('priority')" @click="sortingChanged('priority')">Priority <i class="fa fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('office_time_status')" @click="sortingChanged('office_time_status')">Status <i class="fa fa-sort"></i></th>
                      <th class="text-center">Action <i class="fa fa-sort"></i></th>
                    </tr>
                    </thead>
                    <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                        <td class="text-center">{{index+1}}</td>
                        <td class="text-left">{{form_data.title}}</td>
                        <!-- <td class="text-center">{{form_data.office_time_start_date}}</td>
                        <td class="text-center">{{form_data.office_time_end_date}}</td> -->
                        <td class="text-center">{{form_data.office_start_time}}</td>
                        <td class="text-center">{{form_data.office_end_time}}</td>
                        <td class="text-center">{{form_data.priority}}</td>
                        <td class="text-center" v-if="form_data.office_time_status==1">{{'Active'}}</td>
                        <td class="text-center" v-else>{{'Inactive'}}</td>
                        <td class="text-center">
                          <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/officetimesetup/'+form_data.id})" class="btn btn-info btn-xs" title="Edit"> <i class="fa fa-edit"> </i> Edit </button>
                          <button  v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/officetimesetup/'+form_data.id})" title="Delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
                        </td>
                    </tr>
                    </tbody>
                     <tbody v-else>
                        <tr>
                            <td colspan="8" align="center">No data in database</td>
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


       <modal ref="modal" class=""  width="400" name="myModal" height="auto" :clickToClose="false" body-class="p-0">
            <div v-if="modal_loading">
                <div class="widget-header modal-header">
                    <h4><i class="fa fa-bars"></i> Office Time Setup</h4>
                    <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modify-wraper modal-body">
                  
                  <div class="">
                     <form @submit.prevent="add({add:'add/officetimesetup'},resetModal)" class="well form-horizontal needs-validation" novalidate>
                      <div class="row" style="margin:0px">
                        <div class="col-md-12">

                          <div class="form-group">
                             <label class="col-md-6 control-label">Title</label>
                             <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                  
                                   <input v-model="form_data.title"  class="form-control" type="text">
                                </div>
                             </div>
                          </div>
                           
                           <!-- <div class="form-group">
                              <label class="col-md-6 control-label">Office Start Date</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <datepicker placeholder="Select Date" v-model="form_data.office_time_start_date" class="form-control" required></datepicker>
                                 </div>
                              </div>
                           </div>
                           
                           
                           <div class="form-group">
                              <label class="col-md-6 control-label">Office End Date</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <datepicker placeholder="Select Date" v-model="form_data.office_time_end_date" class="form-control" required></datepicker>
                                 </div>
                              </div>
                           </div> -->

                           <div class="form-group">
                              <label class="col-md-6 control-label">Office Start Time</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                   <vue-timepicker class="form-control" v-model="form_data.office_start_time" required></vue-timepicker>
                                 </div>
                              </div>
                           </div>
                            <div class="form-group">
                              <label class="col-md-6 control-label">Late Consider Time</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <vue-timepicker class="form-control" v-model="form_data.lateConsiderTime" required></vue-timepicker>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-6 control-label">Office End Time</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <!-- <input v-model="form_data.office_end_time" id="leave_days" name="leave_days" placeholder="" class="form-control" required="true" type="text"> -->
                                    <vue-timepicker class="form-control" v-model="form_data.office_end_time" required></vue-timepicker>
                                 </div>
                              </div>
                           </div>
                          

                           <div class="form-group">
                              <label class="col-md-4 control-label">Office Time Note</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <textarea v-model="form_data.office_time_note" id="leave_note" name="leave_note" placeholder="" class="form-control" type="text"></textarea>
                                  </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-6 control-label">Office Type</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <select class="form-control" v-model="form_data.office_type" required="true">
                                       <option disabled>--Select--</option>
                                       <option value="1">General</option>
                                       <option value="2">Dayoff</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-6 control-label">Priority</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <input id="sbu_name" v-model="form_data.priority" name="sbu_name" placeholder="" class="form-control" type="number"></div>
                              </div>
                           </div>
                           <div class="form-group" v-if="form_data.id">
                              <label class="col-md-6 control-label">Office Time Status</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <select class="form-control" v-model="form_data.office_time_status" required="true">
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
                          <input type="submit" tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2">
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
    // Main JS (in UMD format)
    import VueTimepicker from 'vue2-timepicker'
    // CSS
    import 'vue2-timepicker/dist/VueTimepicker.css'
    export default {
        data(){
          return{
            // office_start_time:'',
          }
        },
        created(){
            this.getResults(1);
        },
        components:{
            pageLoading:Loading,
            VueTimepicker 
        },
        methods:{
          // setModalData(){
          //   this.office_start_time_value=this.form_data.office_start_time;
          // },
          // resetModal(){
          //   this.sbu_name_value='';
          //   this.section_value='';
          // },
        }

    }
</script>