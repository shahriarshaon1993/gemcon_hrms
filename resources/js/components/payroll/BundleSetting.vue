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
                               <h3 class="card-title d-none d-md-block">Bundle List</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <div v-if="lists.add=='add'" @click="getModalData($event)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>
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
                            <th class="text-center" v-bind:class="getSortingClass('bundle_code')" @click="sortingChanged('bundle_code')">Bundle Code <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('bundle_name')" @click="sortingChanged('bundle_name')">Bundle Name <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('priority')" @click="sortingChanged('priority')">Priority <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('bundle_status')" @click="sortingChanged('bundle_status')">Status <i class="fas fa-sort"></i></th>
                            <th class="text-center">Action</th>
                          </tr>
                        </thead>
                         <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                          <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                            <td class="text-center">{{index+1}}</td>
                            <td class="text-center">{{form_data.bundle_code}}</td>
                            <td class="text-left">{{form_data.bundle_name}}</td>
                            <td class="text-center">{{form_data.priority}}</td>
                            <td class="text-center">
                              <span v-if="form_data.bundle_status==1" style="color:green;">
                                {{"Active"}}
                              </span>
                              <span v-else style="color:red;">
                                {{"Inactive"}}
                              </span>
                           </td>
                            <td class="text-center">
                              <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/bundle_setting/'+form_data.id},setModalData)" class="btn btn-info btn-xs" title="Edit" data-toggle="modal" data-target="#addNewJobGrade" > <i class="fa fa-edit"> </i> Edit </button>
                              <button v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/bundle_setting/'+form_data.id})" title="Delete" class="btn btn-danger btn-xs" ><i class="fa fa-trash"></i> Delete</button>
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

          <modal class="" name="myModal" height="auto" :clickToClose="false">
               <div v-if="modal_loading">
                   <div class="widget-header modal-header">
                       <h4><i class="fa fa-bars"></i> Bundle</h4>
                       <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   </div>
                   <div class="modify-wraper modal-body">
                       <form @submit.prevent="add({add:'add/bundle_setting'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                         <div class="">
                           <div class="col-md-12">
                              <div class="form-group" v-if="form_data.id">
                                  <label class="col-md-6 control-label">Company/SBU <sup style="color:red; top: -2px;">*</sup></label>
                                  <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="CompanySbu" placeholder="Select one" label="text" track-by="text"></vue-select>
                                    </div>
                                  </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-md-6 control-label">Bundle Name</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                     <input id="bundle_name" v-model="form_data.bundle_name" name="bundle_name" placeholder="" class="form-control" required="true" type="text"></div>
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
                                 <label class="col-md-6 control-label">Status</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <select class="form-control" v-model="form_data.bundle_status" required="true">
                                          <option disabled>--Select--</option>
                                          <option value="1">Active</option>
                                          <option value="2">Inactive</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                         </div>
                         <div class="form-actions col-md-12">
                             <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2" >
                             <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button>
                         </div>
                     </form>
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
  import $ from 'jquery';
  export default {
      data(){
        return{
          sbu_name_value:'',
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
        CompanySbu(option){
          console.log(option);
          this.form_data.sbu_id= option.id;
        },
        setModalData(){
            this.sbu_name_value=this.form_data.sbu_name_value;
        },
        resetModal(){
            this.sbu_name_value='';
        },
      }
  }
</script>