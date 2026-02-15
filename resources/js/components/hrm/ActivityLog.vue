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
                               <h3 class="card-title d-none d-md-block">Activity Log List</h3>
                               <!-- <span class="float-sm-right" style="float: right;">
                                 <div v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/department'},resetModal)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>
                                 <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                               </span> -->
                           </div>
                       </div>
                        <!-- <div class="row">
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
                            <div class="col-12 col-sm-12 col-md-3">
                             <div class="info-box mb-3">
                               <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-ban"></i></span>
                               <div class="info-box-content">
                                 <span class="info-box-text">Rejected </span>
                                 <span class="info-box-number">DDD</span>
                               </div>
                             </div>
                           </div>
                       </div> -->
                    </div>
                    <div class="card-body col-md-12">
                      <div class="col-md-6 col-sm-6 col-6 float-left" style="padding:0px;">
                          <div id="DataTables_Table_0_length" class="">
                              Show
                              <label> 
                                  <select class="form-control pagination-number" @change="onChange($event)" v-model="paginate_num"  name="pageSize">
                                    <option value="100000000000000">All</option>  
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
                                  <option value="100">100</option>
                                  <option value="200">200</option>
                                  <option value="300">300</option>
                                  <option value="400">400</option>
                                  <option value="500">500</option>
                                  <option value="600">600</option>
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
                        <th class="text-center">SL<i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('log_name')" @click="sortingChanged('log_name')">Log Name <i class="fas fa-sort"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('description')" @click="sortingChanged('description')">Description<i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('subject_id')" @click="sortingChanged('subject_id')">Subject ID <i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('subject_type')" @click="sortingChanged('subject_type')">Subject Type<i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('employee_id')" @click="sortingChanged('employee_id')">Employee ID <i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('user_name')" @click="sortingChanged('user_name')">Employee Name <i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('created_at')" @click="sortingChanged('created_at')">Created At <i class="fas fa-sort text-right"></i></th>
                        <th class="text-center sortable" v-bind:class="getSortingClass('properties')" @click="sortingChanged('properties')">Properties <i class="fas fa-sort text-right"></i></th>
                      </tr>
                    </thead>
                     <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                        <td class="text-center">{{index+1}}</td>
                        <td class="text-left">{{form_data.log_name}}</td>
                        <td class="text-left">{{form_data.description}}</td>
                        <td class="text-center">{{form_data.subject_id}}</td>
                        <td class="text-left">{{form_data.subject_type}}</td>
                        <td class="text-center">{{form_data.employee_id}}</td>
                        <td class="text-left">{{form_data.user_name}}</td>
                        <td class="text-left">{{form_data.created_at}}</td>
                        <td class="text-left">{{form_data.properties}}</td>
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
                    <h4><i class="fa fa-bars"></i> Department</h4>
                    <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modify-wraper modal-body">
                  <div class="container">
                    <form @submit.prevent="add({add:'add/department'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                      <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label class="col-md-6 control-label">Department Name</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <input id="department_name" v-model="form_data.department_name" name="department_name" placeholder="" class="form-control" required="true" type="text"></div>
                              </div>
                           </div>
                           <!-- <div class="form-group">
                              <label class="col-md-6 control-label">Department Head</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                  <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                                </div>
                              </div>
                           </div> -->
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
                                    <select class="form-control" v-model="form_data.department_status" required="true">
                                       <option disabled>--Select--</option>
                                       <option value="1">Active</option>
                                       <option value="0">Inactive</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                             <br> 
                              <label class="col-md-12 control-label" style="margin-bottom: 5px;">
                               Department Heads
                              </label>
                               <div class="col-md-11 inputGroupContainer float-left" style="margin-bottom: 5px;">
                                  <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                   <vue-select v-model="approvalnamevalue1" :options="option_data.employee_data_approval" @select="onSelectEmployeeApproval" placeholder="Select one" label="text" track-by="text"></vue-select>
                                 </div>
                               </div>
                               <div class="col-md-1 float-right" style="margin-bottom: 5px;">
                                 
                                 <a @click="addRow($event,form_data.approval_infos,form_data.approve_by,employees_ids,employeesName)" id="addCF" class="btn btn-xs btn-success"><i class="fa fa-plus" style="color:#fff;"></i></a>
                               </div>
                               <br>
                               <!-- {{approval_infos}} -->
                               <table class="" style="width: 95%;margin-top: 44px;" >
                                 <tr class="text-center" style="border-bottom: 1px solid #cfcfcf;background: rgb(207, 207, 207);">
                                   <th width="3"> Level</th>
                                   <th width="10">ID </th>
                                   <th width="10">Name </th>
                                   <th width="40"> </th>
                                 </tr>
                                 <tr style="border: 1px solid #cfcfcf;" v-for="(formData, index) in form_data.approval_infos"  v-if="formData.employees_ids !=''" > 
                                     <td style="text-align: center;"> {{index+1}} </td>
                                     <!-- <td style="text-align: center;"> {{formData.dh_level}} </td> -->
                                     
                                     <td style="text-align: center;">{{formData.employees_ids}}  </td>
                                     <td> {{formData.dh_head_id_name}}  </td>
                                     <td style="text-align: right;"> 
                                          <a @click="deleteRow(index)" id="remCF" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                     </td>
                                 </tr>
                               </table>
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
           employee_name_value:'',
           approvalnamevalue1:'',
           approval_infos:[{
                dh_head_id:'',
             }],
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
          onSelectEmployeeApproval(option){
            console.log(option);
            this.form_data.approve_by= option.id;
            this.employeesName=option.employee_name;
            this.employees_ids=option.employee_ids;
            this.form_data.approve_by_name= option.text;
            console.log(this.form_data.approve_by);
          },
          addRow(event,approval_infos,id,ids,name) {
              var aaa= this.form_data.approval_infos.length;
              this.form_data.approval_infos.push({
                  approvalnamevalue1:'',
                  indexid:aaa,
                  dh_head_id:id,
                  employees_ids:ids,
                  dh_head_id_name:name,
              })
              console.log(this.form_data.approval_infos);
          },
          deleteRow(index) {
            this.form_data.approval_infos.splice(index,1);
          },
          setModalData(){
            this.employee_name_value=this.form_data.employee_name_value;
          },
          resetModal(){

          }
        }
    }



</script>