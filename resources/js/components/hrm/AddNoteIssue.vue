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
                                   <h3 class="card-title d-none d-md-block">Note Issue List</h3>
                                   <span class="float-sm-right" style="float: right;">
                                     <div  @click="getModalData($event)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>
                                      <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
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
                                <th class="text-center" v-bind:class="getSortingClass('id')" @click="sortingChanged('id')">SL</th>
                                <th class="text-left" v-bind:class="getSortingClass('note_issue')" @click="sortingChanged('note_issue')">Note Issue <i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('note_issue_status')" @click="sortingChanged('note_issue_status')">Status <i class="fas fa-sort"></i></th>
                                <th class="text-center">Action</th>
                              </tr>
                            </thead>
                             <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                              <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i = index>
                                <td class="text-center">{{index+1}}</td>
                                <td class="text-left">{{form_data.note_issue}}</td>
                                <td class="text-center" v-if="form_data.note_issue_status==1">{{'Active'}}</td>
                                <td class="text-center" v-else>{{'Inactive'}}</td>
                                <td class="text-center">
                                  <button class="btn btn-xs btn-info" @click="getModalData($event,{dataUrl:'edit/note_issue/'+form_data.id})" title="Edit" > <i class="fa fa-edit"> </i> Edit </button>
                                
                                  <button class="btn btn-xs btn-danger"  @click="deleteItem({delUrl:'delete/note_issue/'+form_data.id})" title="Delete" ><i class="fa fa-trash"></i> Delete</button>
    
                                   </td>
                              </tr>
                            </tbody>
                             <tbody v-else>
                                <tr>
                                    <td colspan="4" align="center">No data in database</td>
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
                       <!--    <div class="row">
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
    
              <modal class="" name="myModal" height="auto" :clickToClose="false">
                   <div v-if="modal_loading">
                       <div class="widget-header modal-header">
                           <h4><i class="fa fa-bars"></i>Note Issue</h4>
                           <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       </div>
                       <div class="modify-wraper modal-body">
                           <form @submit.prevent="add({add:'add/note_issue'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                             <div class="">
                               <div class="col-md-12">
                                  
                                  <div class="form-group">
                                     <label class="col-md-6 control-label">Note Issue</label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                         <input v-model="form_data.note_issue" placeholder="Note Issue" class="form-control" required="true" type="text"></div>
                                     </div>
                                  </div>
                                  <div class="form-group" v-if="form_data.id">
                                     <label class="col-md-6 control-label">Status</label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                           <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                           <select class="form-control" v-model="form_data.note_issue_status" required="true">
                                              <option disabled>--Select--</option>
                                              <option value="1">Active</option>
                                              <option value="0">Inactive</option>
                                           </select>
                                        </div>
                                     </div>
                                  </div>
                               </div>
                             </div>
                             <div class="form-actions col-md-12" style="">
                                 <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2 col-2" >
                                 <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6 col-2" style="margin-right: 10px;">Close</button>
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
           import $ from 'jquery'
    
        export default {
    
            created(){
                this.getResults(1);
            },
            components:{
                pageLoading:Loading
            },
            methods:{
              //   resetModal(){
              //       this.sbu_name_value='';
              //       this.section_value='';
              //       this.sub_section_value='';
              //       this.employee_group_value='';
              //       this.department_name_value='';
              //       this.designation_name_value='';
              //       this.jobgrade_name_value='';
              //       this.unit_value='';
              //       this.sub_unit_value='';
              //       this.employee_name_value='';
              //       this.work_location_value='';
              //       this.form_data.employee_status='1';
              //       this.form_data.emplyee_category_mgt_non_mgt='2';
              //       this.form_data.employee_leave_group='1';
              //       this.form_data.employee_type='2';
              //       this.form_data.make_user='';
              //       this.form_data.user_type='0'
              //       this.form_data.ea_approve_by_name='';
              //       this.form_data.employee_mobile='';
              //       this.form_data.employee_id_no='';
              //       this.form_data.employee_number='';
              //       this.form_data.employee_fullname='';
              //       this.form_data.employee_joining_date='';
              //       this.form_data.employee_image='';
              //       this.form_data.make_user='';
              //       this.approvalnamevalue1="";
              // },
            }
    
    
    
        }
    
    
    
    </script>