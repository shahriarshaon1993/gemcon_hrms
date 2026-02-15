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
                           <h3 class="card-title d-none d-md-block">Holiday Setup</h3>
                           <span class="float-sm-right" style="float: right;">
                             <div  v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/holidaysetup'})" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span> </div>
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
                      <th class="text-center">SL</th>
                      <th class="text-center" v-bind:class="getSortingClass('holiday_event')" @click="sortingChanged('holiday_event')">Event <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('holiday_start_date')" @click="sortingChanged('holiday_start_date')">Start Date <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('holiday_end_date')" @click="sortingChanged('holiday_end_date')">End Date <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('holiday_note')" @click="sortingChanged('holiday_note')" style="width: 35%;">Holiday Note <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('priority')" @click="sortingChanged('priority')">Priority<i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('holiday_status')" @click="sortingChanged('holiday_status')"> Status <i class="fas fa-sort"></i></th>
                      <th class="text-center" style="width:150px;">Action</th>
                    </tr>
                    </thead>
                    <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                        <td class="text-center">{{index+1}}</td>
                        <td class="text-left">{{form_data.holiday_event}}</td>
                        <td class="text-center">{{form_data.holiday_start_date}}</td>
                        <td class="text-center">{{form_data.holiday_end_date}}</td>
                        <td class="text-left">{{form_data.holiday_note}}</td>
                        <td class="text-center">{{form_data.priority}}</td>
                        <td class="text-center" v-if="form_data.holiday_status==1">{{'Active'}}</td>
                        <td class="text-center" v-else>{{'Inactive'}}</td>
                        <td class="text-center">
                          <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/holidaysetup/'+form_data.id})" class="btn btn-info btn-xs" title="Edit" > <i class="fa fa-edit"> </i> Edit </button>
                          <button  v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/holidaysetup/'+form_data.id})" title="Delete" class="btn btn-danger btn-xs" ><i class="fa fa-trash"></i> Delete</button>
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


       <modal ref="modal" class="" name="myModal" height="auto" :clickToClose="false" body-class="p-0" width="1200">
          <div v-if="modal_loading">
                <div class="widget-header modal-header">
                    <h4><i class="fa fa-bars"></i> Holiday Setup</h4>
                    <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modify-wraper modal-body">
                  
                  <div class="container">
                     <form @submit.prevent="add({add:'add/holidaysetup'})" class="well form-horizontal needs-validation" novalidate>
                      <div class="row">
                        <div class="col-md-12" style="padding:0px; margin:-5px;">
                           
                           <div class="form-group">
                              <label class="col-md-6 control-label">Event</label>
                              <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <input v-model="form_data.holiday_event" class="form-control" required="true" type="text">
                                  </div>
                              </div>
                           </div>
                           <div class="row">
                              <!-- <div class="col-md-12"> -->
                                  <div class="col-md-4" style="float:left;">
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Start Date</label>
                                        <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group">
                                              <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                              <datepicker placeholder="Select Date" v-model="form_data.holiday_start_date"   class="form-control" ></datepicker>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4" style="float:left;">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">End Date</label>
                                        <div class="col-md-12 inputGroupContainer">
                                          <div class="input-group">
                                              <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                              <datepicker placeholder="Select Date" v-model="form_data.holiday_end_date" class="form-control" ></datepicker>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4" style="float:left;">
                                    <div class="form-group">
                                          <label class="col-md-6 control-label">Priority</label>
                                          <div class="col-md-12 inputGroupContainer">
                                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                              <input id="sbu_name" v-model="form_data.priority" name="sbu_name" placeholder="" class="form-control" type="number"></div>
                                          </div>
                                      </div>
                                  </div>
                              <!-- </div> -->
                           </div>
                           
                           <div class="form-group">
                              <label class="col-md-4 control-label">Holiday Note/Remarks</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <textarea v-model="form_data.holiday_note" id="leave_note" name="leave_note" placeholder="" class="form-control" required="true" type="text"></textarea>
                                  </div>
                              </div>
                           </div>
                           
                           <div class="form-group" v-if="form_data.id">
                              <label class="col-md-6 control-label">Status</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <select class="form-control" v-model="form_data.holiday_status" required="true">
                                       <option disabled>--Select--</option>
                                       <option value="1">Active</option>
                                       <option value="0">Inactive</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>


                        <div class="row report-box" style="margin-top:15px;">
                          <div class="col-md-12"> 
                            <h6>
                              <u>Permission Type</u>
                            </h6>
                          </div>
                          <div class="form-group col-md-2" style="max-width: 11.5%;">
                            <label class="col-md-12 control-label">SBU <sup style="color:red; top: -2px;">*</sup></label>
                            <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbu" placeholder="Select one" label="text" track-by="text"></vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-2" style="max-width: 11.5%;">
                            <label class="col-md-12 control-label">Unit</label>
                            <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="unit_value" :options="option_data.unit_data" @select="employeesUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-2" style="max-width: 11.5%;">
                            <label class="col-md-12 control-label">Sub Unit</label>
                            <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="sub_unit_value" :options="option_data.sub_unit_data" @select="employeesSubUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                              </div>
                            </div>
                          </div>

                          <div class="form-group col-md-2" style="max-width: 11.5%;">
                            <label class="col-md-12 control-label">Department</label>
                            <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="department_name_value" :options="option_data.department_data" @select="onSelectDepartment" placeholder="Select one" label="text" track-by="text"></vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-2" style="max-width: 11.5%;">
                            <label class="col-md-12 control-label">Section</label>
                            <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="section_value" :options="option_data.section_data" @select="employeesSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-2" style="max-width: 11.5%;">
                            <label class="col-md-12 control-label">Sub Section</label>
                            <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <vue-select v-model="sub_section_value" :options="option_data.sub_section_data" @select="employeesSubSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-2"  style="max-width: 11.5%;">
                            <label class="col-md-12 control-label">Work Loc.</label>
                            <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <vue-select v-model="work_location_value" :options="option_data.work_location_data" @select="employeesWorkLocation" placeholder="Select one" label="text" track-by="text"></vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-2"  style="max-width: 11.5%;">
                            <label class="col-md-12 control-label">Employee</label>
                            <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-1 float-right" style="padding: 22px;max-width: 4.333333%;">
                            <span v-if="this.sbu_permission">
                              <a @click="addRowUserlevel($event,form_data.userPermission,form_data.approve_by,employees_ids,employeesName)" id="addCF" class="btn btn-xs " style="color: #212529 !important;background-color: #fac23c;border-color: #fac23c; padding: 5px 15px;"><i class="fa fa-plus" style="color: #212529 !important;background-color: #fac23c;border-color: #fac23c;"></i></a>
                            </span>
                          </div>
                            <!-- <form @submit.prevent="add({add:'add/userMultiPermission'})" class="" style="width: 100%" id="validate-1"> -->
                          <div class="row col-md-12" style="margin-bottom: 30px;"> 
                              <table class="" style="width: 100%;">

                                  <tr class="text-center  table-bordered table-striped employeeTable" style="border-bottom: 1px solid #cfcfcf;background: rgb(207, 207, 207);">
                                    <th > SBU</th>
                                    <th > Unit</th>
                                    <th > Sub Unit</th>
                                    <th > Department</th>
                                    <th > Section</th>
                                    <th > Sub Sect.</th>
                                    <th >Work Loc. </th>
                                    <th >Employee</th>
                                    <th > </th>
                                  </tr>
                                  <tr class="table table-bordered table-striped employeeTable " style="border: 1px solid rgb(207, 207, 207);" v-for="(form_data, index) in form_data.userPermission" v-bind:key="form_data.id"> 
                                      <td> 
                                          <span v-if="form_data.sbu_name">
                                            {{form_data.sbu_name}} 
                                          </span>
                                          <span v-else>
                                            -
                                          </span>

                                      </td>
                                      <td> 
                                          <span v-if="form_data.unit_name">
                                            {{form_data.unit_name}} 
                                          </span>
                                          <span v-else>
                                            -
                                          </span>
                                      </td>
                                      <td> 
                                          <span v-if="form_data.sub_unit_name">
                                            {{form_data.sub_unit_name}} 
                                          </span>
                                          <span v-else>
                                            -
                                          </span>
                                    </td>
                                      <td> 
                                        <span v-if="form_data.department_name">
                                            {{form_data.department_name}} 
                                          </span>
                                          <span v-else>
                                            -
                                          </span>
                                      </td>
                                      <td> 
                                          <span v-if="form_data.section_name">
                                            {{form_data.section_name}} 
                                          </span>
                                          <span v-else>
                                            -
                                          </span>

                                      </td>
                                      <td> 
                                          <span v-if="form_data.sub_section_name">
                                            {{form_data.sub_section_name}} 
                                          </span>
                                          <span v-else>
                                            -
                                          </span>
                                      </td>
                                      <td> 
                                        <span v-if="form_data.work_location_name">
                                            {{form_data.work_location_name}} 
                                          </span>
                                          <span v-else>
                                            -
                                          </span>
                                      </td>
                                      <td> 
                                        <span v-if="form_data.employee_fullname">
                                          {{form_data.employee_fullname}} 
                                        </span>
                                        <span v-else>
                                          -
                                        </span>
                                      </td>
                                      <td style="text-align: right;"> 
                                          <a @click="deleteRowMlevel(index)" id="remCF" class="btn btn-xs btn-danger" style="padding: 3px 10px;"><i class="fa fa-times"></i></a>
                                      </td>
                                  </tr>

                                </table>
                            
                          </div>
                          <!-- <div class="col-md-12">
                             <div class="form-actions" style="margin-top: 5px;">
                                <input type="submit" tabindex="4" value="Save" class="btn btn-md btn-info float-right "> 
                                <button type="button" class="btn btn-md btn-default float-right" style="margin-right: 10px;">Close</button>
                            </div>
                          </div> -->
                        <!-- </form> -->
                      </div>
                      </div>
                      <div class="form-actions " style="padding:5px 5px 42px 0px;">
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
           section_value:'',
           sub_section_value:'',
           employee_group_value:'',
           unit_value:'',
           make_user:0,
           employeesName:'',
           employees_ids:'',
           url: null,
           sub_unit_value:'',
           work_location_value:'',
           department_name_value:'',
           designation_name_value:'',
           jobgrade_name_value:'',
           employee_name_value:'',
           sub_unit_value:'',
           work_location_value:'',
           personal_email_id:'',
           noticeToType:0,
           noticeToTypeName:'',
           permission_id:'',
           sbu_permission:'',
           permission_id_name:'',
           userPermission:''
         }
       },
        created(){
            this.getResults(1);
        },
        components:{
            pageLoading:Loading
        },
        methods:{
           addRowUserlevel(event,userPermission) {
            console.log(this.form_data.userPermission);
              // var aaa= this.form_data.userPermission.length;
              console.log(this.employee_id);
              console.log(this.sbu_permission);

             if(this.sbu_permission !== undefined){
                this.form_data.userPermission.push({
                  'employee_id':this.employee_id,
                  'sbu_permission':this.sbu_permission,
                  'sbu_name':this.sbu_name,
                  'unit_permission':this.unit_permission,
                  'unit_name':this.unit_name,
                  'sub_unit_permission':this.sub_unit_permission,
                  'sub_unit_name':this.sub_unit_name,
                  'department_permission':this.department_permission,
                  'department_name':this.department_name,
                  'section_permission':this.section_permission,
                  'section_name':this.section_name,
                  'sub_section_permission':this.sub_section_permission,
                  'sub_section_name':this.sub_section_name,
                  'work_location_permission':this.work_location_permission,
                  'work_location_name':this.work_location_name,
                  'employee_id_permission':this.employee_id_permission,
                  'employee_fullname':this.employee_fullname
              })
             this.form_data.userPermission=this.form_data.userPermission;
              this.sub_section_value='';
              this.unit_value='';
              this.sbu_name_value='';
              this.department_name_value='';
              this.section_value='';
              this.sub_section_value='';
              this.work_location_value='';
              this.sbu_permission='';
              this.sbu_name='';
              this.unit_permission='';
              this.unit_name='';
              this.sub_unit_name='';
              this.sub_unit_permission='';
              this.sub_unit_name='';
              this.department_permission='';
              this.department_name='';
              this.section_permission='';
              this.sub_unit_value='';
              this.section_name='';
              this.sub_section_permission='';
              this.sub_section_name='';
              this.sub_section_permission='';
              this.sub_section_name='';
              this.work_location_permission='';
              this.work_location_name='';
              this.employee_id_permission='';
              this.employee_fullname='';

             }else{
              alert('Sorry! Select Company/SUB Name First!');
             }
              
              console.log(this.form_data.userPermission);
          },
          
           deleteRowMlevel(index) {
            this.form_data.userPermission.splice(index,1);
            this.form_data.userPermission=this.form_data.userPermission;
            console.log( this.form_data.userPermission);
          },

          addRow(event,approval_infos) {
              var aaa= this.form_data.approval_infos.length;
              this.form_data.approval_infos.push({
                  permission_id:this.permission_id,
                  permission_type:this.noticeToType,
                  permission_type_name:this.noticeToTypeName,
                  permission_id_name:this.permission_id_name,
              })
              console.log(this.form_data.approval_infos);
          },
          deleteRow(index) {
            this.form_data.approval_infos.splice(index,1);
          },


          employeesSbu(option){
            console.log(option);
            this.form_data.sbu_id= option.id;
            this.sbu_permission= option.id;
            this.form_data.sbu_permission= option.id;
            this.sbu_name= option.text;
          },
          employeesSection(option){
            console.log(option);
            this.form_data.section_id= option.id;
            this.section_permission= option.id;
            this.form_data.section_permission= option.id;
            this.section_name= option.text;
          },
          employeesSubSection(option){
            console.log(option);
            this.form_data.subsection_id= option.id;
            this.form_data.sub_section_permission= option.id;
            this.sub_section_permission= option.id;
            this.sub_section_name= option.text;
          },
          employeesGroup(option){
            console.log(option);
            this.form_data.employee_group= option.id;
            this.permission_id=option.id;
            this.permission_id_name=option.text;
            console.log(this.form_data.employee_group);
          },
          employeesSubUnit(option){
            console.log(option);
            this.form_data.subunit_id= option.id;
            this.sub_unit_permission= option.id;
            this.form_data.sub_unit_permission= option.id;
            this.sub_unit_name= option.text;
          },
          employeesUnit(option){
            console.log(option);
            this.form_data.unit_id= option.id;
            this.unit_permission= option.id;
            this.form_data.unit_permission= option.id;
            this.unit_name= option.text;
          },
          employeesWorkLocation(option){
            console.log(option);
            this.form_data.employee_work_location= option.id;
             this.work_location_permission= option.id;
            this.form_data.work_location_permission= option.id;
            this.work_location_name= option.text;
          },
          onSelectDepartment(option){
            console.log(option);
            this.form_data.department_id= option.id;
            this.department_permission= option.id;
            this.form_data.department_permission= option.id;
            this.department_name= option.text;
          },
          onSelectDesignation(option){
            console.log(option);
            this.form_data.employee_designation= option.id;
            this.permission_id=option.id;
            this.permission_id_name=option.text;
            console.log(this.form_data.employee_designation);
          },
          onSelectJobGrade(option){
            console.log(option);
            this.form_data.employee_job_grade= option.id;
            this.permission_id=option.id;
            this.permission_id_name=option.text;
            console.log(this.form_data.employee_job_grade);
          },
          onSelectEmployee(option){
            console.log(option);
            this.form_data.employee_id = option.id;
            this.employee_id_permission= option.id;
            this.employee_fullname= option.text;

            // let uri = URL.baseUrl('employees_user_permission/'+option.id);
            //   console.log(uri);
            //   axios.get(uri)
            //       .then(res => {
            //         console.log(res.data);
            //           this.form_data.userPermission=res.data;
            //       })
            //       .catch(error => {
            //         this.showToster({status:0,message:'opps! something went wrong'});
            //       })
          },  
        setModalData(){
          this.sbu_name_value=this.form_data.sbu_name_value;
          this.section_value=this.form_data.section_value;
          this.sub_section_value=this.form_data.sub_section_value;
          this.employee_group_value=this.form_data.employee_group_value;
          this.department_name_value=this.form_data.department_name_value;
          this.designation_name_value=this.form_data.designation_name_value;
          this.jobgrade_name_value=this.form_data.jobgrade_name_value;
          this.sub_unit_value=this.form_data.sub_unit_value;
          this.employee_name_value=this.form_data.employee_name_value;
          this.work_location_value=this.form_data.work_location_value;
          this.general_data_temp=this.form_data.general_info_temp;
        },
        resetModal(){
            this.sbu_name_value='';
            this.section_value='';
            this.sub_section_value='';
            this.employee_group_value='';
            this.department_name_value='';
            this.designation_name_value='';
            this.jobgrade_name_value='';
            this.unit_value='';
            this.sub_unit_value='';
            this.employee_name_value='';
            this.work_location_value='';
            this.form_data.employee_status='1';
            this.form_data.emplyee_category_mgt_non_mgt='2';
            this.form_data.employee_leave_group='1';
            this.form_data.employee_type='2';
            this.form_data.make_user='';
            this.form_data.user_type='0'
            this.form_data.ea_approve_by_name='';
            this.form_data.employee_mobile='';
            this.form_data.employee_id='';
            this.form_data.employee_number='';
            this.form_data.employee_fullname='';
            this.form_data.employee_joining_date='';
            this.form_data.employee_image='';
            this.form_data.make_user='';
            this.approvalnamevalue1="";
      },
          notice_to(event){
            console.log(event.target.name);
            if (event.target.value==1) {
              this.noticeToType=1;
              this.noticeToTypeName='Company/SBU';
            }else if(event.target.value==2){
              this.noticeToType=2;
              this.noticeToTypeName='Department';
            }else if(event.target.value==3){
              this.noticeToType=3;
              this.noticeToTypeName='Unit';
            }else if(event.target.value==4){
              this.noticeToType=4;
              this.noticeToTypeName='Sub Unit';
            }else if(event.target.value==5){
              this.noticeToType=5;
              this.noticeToTypeName='Section';
            }else if(event.target.value==6){
              this.noticeToType=6;
              this.noticeToTypeName='Sub Section';
            }else if(event.target.value==7){
              this.noticeToType=7;
              this.noticeToTypeName='Employee';
            }
          }
        }
    }
</script>