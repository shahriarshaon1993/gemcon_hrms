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
                             <div  v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/leavesetup'},resetModal)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span> </div>
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
                      <th class="text-center" v-bind:class="getSortingClass('leave_group')" @click="sortingChanged('leave_group')">Leave Group <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('leave_type_name')" @click="sortingChanged('leave_type_name')">Leave Type <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('leave_day_no')" @click="sortingChanged('leave_day_no')">Leave Days <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('leave_note')" @click="sortingChanged('leave_note')">Leave Note <i class="fas fa-sort"></i></th>
                      <th class="text-center sortable" v-bind:class="getSortingClass('priority')" @click="sortingChanged('priority')">Status <i class="fas fa-sort text-right"></i></th>
                      <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                        <td class="text-center">{{index+1}}</td>
                        <td class="text-center" v-if="form_data.leave_group==1">{{'General'}}</td>
                        <td class="text-center" v-else>{{'Special'}}</td>
                        <td class="text-center">{{form_data.leave_type_name}}</td>
                        <td class="text-center">{{form_data.leave_day_no}}</td>
                        <td class="text-left">{{form_data.leave_note}}</td>
                        <td class="text-center">
                          <span v-if="form_data.leave_status==1">
                                {{"Active"}}
                              </span>
                              <span v-else>
                                {{"Inactive"}}
                              </span>
                        </td>
                        <td class="text-center">
                          <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/leavesetup/'+form_data.id},setModalData)" class="btn-xs btn-info" title="Edit" > <i class="fa fa-edit"> </i> </button>
                          <button  v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/leavesetup/'+form_data.id})" title="Delete" class="btn-xs btn-danger" ><i class="fa fa-trash"></i> </button>
                        </td>
                    </tr>
                    </tbody>
                     <tbody v-else>
                        <tr>
                            <td colspan="6" align="center">No data in database</td>
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


      <modal name="myModal" width="400" height="auto"  :clickToClose="false"> 
            <div v-if="modal_loading">
                <div class="widget-header modal-header">
                    <h4><i class="fa fa-bars"></i>Leave Setup </h4>
                    <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modify-wraper modal-body">
                  
                  <div class="container">
                         <!-- <table class="table table-striped">
                            <tbody>
                               <tr>
                                  <td colspan="1"> -->
                                     <form @submit.prevent="add({add:'add/leavesetup'},resetModal)" class="well form-horizontal needs-validation" novalidate>
                                      <div class="row" style="margin: 0px">
                                        <div class="col-md-12">
                                           <div v-if="errors" class="alert alert-danger" style="">
                                              <div v-for="(error, index) in errors">
                                                  <span v-if="isObject(error)" v-for="err in error">{{err}}</span>
                                                  <span v-if="!isObject(error)">{{error}}</span>
                                              </div>
                                            </div>
                                           <div class="form-group">
                                              <label class="col-md-12 control-label">Leave Group</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                    <select v-model="form_data.leave_group" class="selectpicker form-control">
                                                       <option>--Select--</option>
                                                       <option value="1">General</option>
                                                       <option value="2">Special</option>
                                                    </select>
                                                 </div>
                                              </div>
                                           </div>
                                           <div class="form-group">
                                              <label class="col-md-6 control-label">Leave Type</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                    <!-- <select v-model="form_data.leave_type" class="selectpicker form-control">
                                                       <option>--Select--</option>
                                                       <option value="1">Annual Leave</option>
                                                       <option value="2">Casual Leave</option>
                                                       <option value="3">Sick Leave</option>
                                                    </select> -->
                                                    <vue-select v-model="leave_type_value" :options="option_data.leave_type_data" @select="onSelectLeaveType" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                 </div>
                                              </div>
                                           </div>

                                           <div class="form-group">
                                              <label class="col-md-4 control-label">Leave Days</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                  <input v-model="form_data.leave_day_no" id="leave_days" name="leave_days" placeholder="" class="form-control" required="true" type="number">
                                                </div>
                                              </div>
                                           </div>
                                           <div class="form-group">
                                              <label class="col-md-4 control-label">Note</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                    <textarea v-model="form_data.leave_note" id="leave_note" name="leave_note" placeholder="" class="form-control" required="true" type="text"></textarea>
                                                  </div>
                                              </div>
                                           </div>
                                           <div class="form-group" v-if="form_data.id">
                                              <label class="col-md-6 control-label">Status</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                    <select class="form-control" v-model="form_data.leave_status" required="true">
                                                       <option disabled>--Select--</option>
                                                       <option value="1">Active</option>
                                                       <option value="0">Inactive</option>
                                                    </select>
                                                 </div>
                                              </div>
                                           </div>
                                        </div>
                                      </div>
                                      <div class="form-actions " style="padding:5px 5px 42px 0px;">
                                          <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2">
                                          <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button>
                                      </div>
                                     </form>
                          <!--         </td>
                               </tr>
                            </tbody>
                         </table> -->
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
            leave_type_value:'',
          }
        },

        created(){
            this.getResults(1);
        },
        components:{
            pageLoading:Loading
        },
        methods:{
          onSelectLeaveType(option){
            console.log(option);
            this.form_data.leave_type= option.id;
            console.log(this.form_data.leave_type);
          },
          setModalData(){
            this.leave_type_value=this.form_data.leave_type_value;
          },
          resetModal(){
            this.leave_type_value='';
          },
        }
    }



</script>