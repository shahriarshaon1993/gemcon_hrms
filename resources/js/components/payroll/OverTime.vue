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
                           <h3 class="card-title d-none d-md-block">Over Time Setup</h3>
                           <span class="float-sm-right" style="float: right;">
                             <div v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/over_time'},resetModal)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span> </div>
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
                                    <option value="100">100</option>
                                    <option value="200">200</option>
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
                      <th class="text-center" v-bind:class="getSortingClass('employee_id_no')" @click="sortingChanged('employee_id_no')">Employee ID <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Employee Name <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('employee_fullname')">Designation <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('ot_tye')" @click="sortingChanged('ot_tye')">OT Type <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('hour_rate')" @click="sortingChanged('hour_rate')">Rate/Amount <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('ot_status')" @click="sortingChanged('ot_status')">Status <i class="fas fa-sort"></i></th>
                      <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                        <td class="text-center">{{order_no+index+1}}</td>
                        <td class="">{{form_data.employee_id_no}}</td>
                        <td class="">{{form_data.employee_fullname}}</td>
                        <td class="text-center">{{form_data.designation_name}}</td>
                        <td class="text-center" v-if="form_data.ot_type==1">{{'Fixed'}}</td>
                        <td class="text-center" v-else>{{'Percentage'}}</td>
                        <td class="text-center">{{form_data.hour_rate}}</td>
                        <td class="text-center" v-if="form_data.ot_status==1">{{'Active'}}</td>
                        <td class="text-center" v-else>{{'Inactive'}}</td>
                        <td class="text-center">
                          <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/over_time/'+form_data.id},setModalData)" class="btn-xs btn-info" title="Edit" > <i class="fa fa-edit"> </i> </button>
                          <button  v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/over_time/'+form_data.id})" title="Delete" class="btn-xs btn-danger" ><i class="fa fa-trash"></i> </button>
                        </td>
                    </tr>
                    </tbody>
                     <tbody v-else>
                        <tr>
                            <td colspan="9" align="center">No data in database</td>
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
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <modal name="myModal" width="850" height="auto"  :clickToClose="false"> 
            <div v-if="modal_loading">
                <div class="widget-header modal-header">
                    <h4><i class="fa fa-bars"></i> Over Time Setup</h4>
                    <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modify-wraper modal-body">
                  <div class="container over-time">
                     <form @submit.prevent="add({add:'add/over_time'},resetModal)" class="well form-horizontal needs-validation" novalidate>
                      <div class="">
                        <div class="col-md-12">
                            <div class="row report-box">    
                          <div class="form-group col-md-4">
                             <label class="col-md-12 control-label">SBU <sup style="color:red; top: -2px;">*</sup></label>
                             <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group">
                                 <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                 <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbu" placeholder="Select one" label="text" track-by="text"></vue-select>
                               </div>
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label class="col-md-12 control-label">Unit</label>
                             <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group">
                                 <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                 <vue-select v-model="unit_value" :options="option_data.unit_data" @select="employeesUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                               </div>
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label class="col-md-12 control-label">Sub Unit</label>
                             <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group">
                                 <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                 <vue-select v-model="sub_unit_value" :options="option_data.sub_unit_data" @select="employeesSubUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                               </div>
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label class="col-md-12 control-label">Department</label>
                             <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group">
                                 <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                 <vue-select v-model="department_name_value" :options="option_data.department_data" @select="onSelectDepartment" placeholder="Select one" label="text" track-by="text"></vue-select>
                               </div>
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label class="col-md-12 control-label">Section</label>
                             <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group">
                                 <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                 <vue-select v-model="section_value" :options="option_data.section_data" @select="employeesSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                               </div>
                             </div>
                          </div>
                          <div class="form-group col-md-4">
                             <label class="col-md-12 control-label">Sub Section</label>
                             <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group">
                                 <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                 <vue-select v-model="sub_section_value" :options="option_data.sub_section_data" @select="employeesSubSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                               </div>
                             </div>
                          </div>
                          <div class="form-group col-md-4" >
                             <label class="col-md-12 control-label">Work Loc.</label>
                             <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                 <vue-select v-model="work_location_value" :options="option_data.work_location_data" @select="employeesWorkLocation" placeholder="Select one" label="text" track-by="text"></vue-select>
                               </div>
                             </div>
                          </div>
                           <div class="form-group col-md-4" id="employee_wise_show">
                              <label class="col-md-6 control-label">Employee</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                  <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                                </div>
                              </div>
                           </div>
                           <!-- <div class="form-group">
                              <label class="col-md-6 control-label">Employee</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                                 </div>
                              </div>
                           </div> -->
                           <div class="form-group  col-md-4">
                              <label class="col-md-6 control-label">Type</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <select class="form-control" v-model="form_data.ot_type" required="true">
                                       <option disabled>--Select--</option>
                                       <option value="1">Fixed</option>
                                       <option value="2">Percentage</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-6 control-label">Hour Rate</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                     <input  v-model="form_data.hour_rate" class="form-control" type="number">
                                     <!-- <input  v-model="form_data.hour_rate" class="form-control" type="number"> -->
                                 </div>
                              </div>
                           </div>
                           
                           <div class="form-group" v-if="form_data.id">
                              <label class="col-md-6 control-label">Over Time Status</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <select class="form-control" v-model="form_data.ot_status" required="true">
                                       <option disabled>--Select--</option>
                                       <option value="1">Active</option>
                                       <option value="2">Inactive</option>
                                    </select>
                                 </div>
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
            unit_value:'',
            sub_unit_value:'',
            department_name_value:'',
            section_value:'',
            sub_section_value:'',
            work_location_value:'',
            designation_name_value:'',
            employee_name_value:'',
            work_location_value:'',
            employee_name_value:'',
            attendance_machine_value:'',
            office_time_value:'',
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
          console.log('sss');
          this.sbu_id= option.id;
          },
          employeesSection(option){
            this.section_id= option.id;
          },
          employeesSubSection(option){
            this.subsection_id= option.id;
          },
          employeesGroup(option){
            this.employee_group= option.id;
          },
          employeesSubUnit(option){
            this.subunit_id= option.id;
          },
          employeesUnit(option){
            this.unit_id= option.id;
          },
          employeesWorkLocation(option){
            this.employee_work_location= option.id;
          },
          onSelectDepartment(option){
            this.department_id= option.id;
          },
          onSelectDesignation(option){
            this.employee_designation= option.id;
          },
          onSelectEmployee(option){
            console.log(option);
            this.form_data.employee_id= option.id;
            console.log(this.form_data.employee_id);
          },
          onSelectMachine(option){
            console.log(option);
            this.form_data.attendance_machine_no= option.id;
            console.log(this.form_data.attendance_machine_no);
          },
          onSelectOfficeTime(option){
            console.log(option);
            this.form_data.attendance_office_time= option.id;
            console.log(this.form_data.attendance_office_time);
          },
          setModalData(){
            this.employee_name_value=this.form_data.employee_name_value;
            this.attendance_machine_value=this.form_data.attendance_machine_value;
            this.office_time_value=this.form_data.office_time_value;
          },
          resetModal(){
            this.employee_name_value='';
            this.attendance_machine_value='';
            this.office_time_value='';
            this.form_data.attendance_setup_status='1';
          },
        }
    }
</script>
<style>
  .over-time .multiselect__content-wrapper {
      width: 200% !important;
  }
</style>