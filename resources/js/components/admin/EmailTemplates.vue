<template>
<div>
    <div v-if="page_loading" class="widget box" style="margin-left: 30px;">
        <div class="widget-header">
          <section class="content">
            <div class="container-fluid">
              <div class="">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                       <div class="">
                           <div class="col-12 col-sm-6 col-md-12">
                               <h3 class="card-title d-none d-md-block">
                                <i class="fa fa-list"></i>
                                Email Template List</h3>
                               <!-- <span class="float-sm-right" style="float: right;">
                                 <div  v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/email_templates'})" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>
                                  <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                               </span> -->
                           </div>
                       </div>
                      <!--   <div class="row">
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
                            <th class="text-center" v-bind:class="getSortingClass('template_name')" @click="sortingChanged('template_name')">Template Name </th>
                            <th class="text-center" v-bind:class="getSortingClass('subject')" @click="sortingChanged('subject')">Subjects </th>
                            
                            <!-- <th class="text-center" v-bind:class="getSortingClass('priority')" @click="sortingChanged('priority')">Priority </th> -->
                            <th class="text-center" v-bind:class="getSortingClass('status')" @click="sortingChanged('status')">Status </th>
                            <th class="text-center">Action</th>
                          </tr>
                        </thead>
                         <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                          <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i = index>
                            <td class="text-center">{{index+1}}</td>
                            <td>{{form_data.template_name}}</td>
                            <td class="text-left">{{form_data.subject}}</td>
                            <!-- <td class="text-center">{{form_data.priority}}</td> -->
                            <td class="text-center">
                               <span v-if="form_data.status==1">
                                {{"Active"}}
                              </span>
                              <span v-else>
                                {{"Inactive"}}
                              </span>
                            </td>
                            <td class="text-center">
                              <!-- v-if="lists.edit=='edit'" -->
                               <!-- v-if="lists.edit=='edit'"  -->
                              <button class="btn btn-xs btn-info" @click="getModalData($event,{dataUrl:'edit/email_templates/'+form_data.id})" title="Edit" > <i class="fa fa-edit"> </i> Edit </button>
                            
                              <!-- <button v-if="lists.delete=='delete'" class="btn btn-xs btn-danger"  @click="deleteItem({delUrl:'delete/designation/'+form_data.id})" title="Delete" ><i class="fa fa-trash"></i> Delete</button> -->

                               </td>
                          </tr>
                        </tbody>
                         <tbody v-else>
                            <tr>
                                <td colspan="3" :align="center">No data in database</td>
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

          <modal class="" width= "40%" name="myModal" height="auto" :clickToClose="false">
               <div v-if="modal_loading">
                   <div class="widget-header modal-header">
                       <h4><i class="fa fa-bars"></i> Email Template</h4>
                       <button style="right: 0px; top: 30% !important;" type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   </div>
                   <div class="modify-wraper modal-body">
                       <form @submit.prevent="add({add:'add/email_templates'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                         <div class="row" style="margin-right:0px">
                           <div class="col-md-12">
                              
                              <div class="form-group">
                                 <label class="col-md-12 control-label">Template Name<sup style="color:red; top: -2px;">*</sup></label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span class="input-group-addon"></span>
                                     <input v-model="form_data.template_name" placeholder="Template Name" class="form-control" required="true" readonly type="text"></div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-md-12 control-label">Subject<sup style="color:red; top: -2px;">*</sup></label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span class="input-group-addon"></span>
                                     <input id="designation_name" v-model="form_data.subject" name="designation_name" placeholder="" class="form-control" required="true" type="text"></div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-md-12 control-label">Email Body<sup style="color:red; top: -2px;">*</sup></label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon"></span>
                                        <ckeditor v-model="form_data.email_body" :config="editorConfig"></ckeditor>
                                     </div>
                                 </div>
                              </div>
                              <div class="form-group">

                                 <label class="col-md-12 control-label">Company/SBU</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group email-template">
                                        <span class="input-group-addon">
                                        </span>
                                        <vue-select multiple v-model="form_data.sbu_name_value" :options="option_data.company_sbu_data"
                                        @select="sbuSelect" placeholder="Select one" label="text" track-by="text" class="email-template-opiton">
                                      </vue-select>
                                    </div>
                                  </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-12 control-label">Employee wise CC</label>
                                <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group email-template">
                                      <span class="input-group-addon">
                                      </span>
                                      <vue-select multiple v-model="form_data.employee_name_value" :options="option_data.employee_data"
                                      @select="employeeSelect" placeholder="Select one" label="text" track-by="text" class="email-template-opiton">
                                    </vue-select>
                                  </div>
                                </div>
                                </div>
                              <div class="form-group">
                                 <label class="col-md-12 control-label">Common CC
                                  <!-- <sup style="color:red; top: -2px;">*</sup> -->
                                </label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span class="input-group-addon"></span>
                                     <input v-model="form_data.email_cc" class="form-control" placeholder="Emaill CC" type="text"></div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-md-12 control-label">Common BCC
                                  <!-- <sup style="color:red; top: -2px;">*</sup> -->
                                </label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span class="input-group-addon"></span>
                                     <input v-model="form_data.email_bcc" class="form-control" placeholder="Emaill BCC" type="text"></div>
                                 </div>
                              </div>
                              <div class="form-group" v-if="form_data.id">
                                 <label class="col-md-12 control-label">Status</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;">
                                        <!-- <i class="glyphicon glyphicon-list"></i> -->
                                      </span>
                                       <select class="form-control" v-model="form_data.status" required="true">
                                          <option disabled>--Select--</option>
                                          <option value="1">Active</option>
                                          <option value="2">Inactive</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                         </div>
                         <div class="form-actions col-md-12" >
                             <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2 col-2" style="float: right;">
                             <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6 col-2" style="margin-right: 10px; float: right;">Close</button>
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
        data(){
          return{
             editorConfig: {
                 table: {
                     toolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
                 },
                extraPlugins: this.imageuploader
             },
             sbu_name_value: "",
          }
        },
        created(){
            this.getResults(1);
        },
        components:{
            pageLoading:Loading
        },
        methods: {
          sbuSelect(option) {
            console.log(option);
            // this.form_data.employee_sbu = option.id;

            // this.form_data.employee_sbu.push(option.id);
          },
          employeeSelect(option) {
            console.log(option);
            const employee_email_address = option.email_address;
            console.log(employee_email_address);
            if(employee_email_address == null){
              alert('Email address not found!');
              // this.form_data.employee_name_value = '';
            }

            // this.form_data.employee_sbu.push(option.id);
          },
          resetModal(){

          }
        }



    }



</script>
<!-- <style type="text/css">
  button.close.close-modify {
      position: absolute;
      right: 0px;
      top: 25% !important;
      transform: translateY(-50%);
  }
</style> -->
<style>
  .email-template .multiselect .multiselect__tags .multiselect__placeholder{
    padding-left: 10px !important;
  }
  .email-template .multiselect .multiselect__tags .multiselect__tags-wrap .multiselect__tag{
    display: grid;
  }
</style>