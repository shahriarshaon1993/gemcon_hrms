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
                           <h3 class="card-title d-none d-md-block">Attendance Setup</h3>
                           <span class="float-sm-right" style="float: right;">
                             <!-- <a class="btn btn-info" href="#" data-toggle="modal" data-target="#addNewDesignation"><i class="fa fa-plus"></i> Add New</a> -->
                             <div v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/attendancesetup'},resetModal)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span> </div>
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
                      <th class="text-center" v-bind:class="getSortingClass('employee_id_no')" @click="sortingChanged('employee_id_no')">Employee ID <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Employee Name <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('attendance_type')" @click="sortingChanged('attendance_type')">Attendance Type <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('attendance_category')" @click="sortingChanged('attendance_category')">Attendance Category <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('attendance_machine_name')" @click="sortingChanged('attendance_machine_name')">Machine No <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('start_date')" @click="sortingChanged('start_date')">Start Date <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('end_date')" @click="sortingChanged('end_date')">End Date <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('office_start_time')" @click="sortingChanged('office_start_time')">Office Time <i class="fas fa-sort"></i></th>
                      <th class="text-center" v-bind:class="getSortingClass('attendance_setup_status')" @click="sortingChanged('attendance_setup_status')">Attendance Status <i class="fas fa-sort"></i></th>
                      <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                      <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                        <td class="text-center">{{order_no+index+1}}</td>
                        <td class="text-center">{{form_data.employee_id_no}}</td>
                        <td class="">{{form_data.employee_fullname}}</td>
                        <!-- <td class="text-center">{{form_data.attendance_type}}</td> -->
                        <td class="text-center" v-if="form_data.attendance_type==1">{{'Applicable'}}</td>
                        <td class="text-center" v-else>{{'Not Applicable'}}</td>
                        <!-- <td class="text-center">{{form_data.attendance_category}}</td> -->
                        <td class="text-center" v-if="form_data.attendance_category==1">{{'As Usual'}}</td>
                        <td class="text-center" v-else>{{'Flexible'}}</td>
                        <td class="text-center">{{form_data.attendance_machine_name}}</td>
                         <td class="text-center">{{form_data.start_date}}</td>
                          <td class="text-center">{{form_data.end_date}}</td>
                        <td class="text-center">{{form_data.office_start_time+' - '+form_data.office_end_time}}</td>
                        <td class="text-center" v-if="form_data.attendance_setup_status==1">{{'Active'}}</td>
                        <td class="text-center" v-else>{{'Inactive'}}</td>
                        <td class="text-center">
                          <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/attendancesetup/'+form_data.id},setModalData)" class="btn-xs btn-info" title="Edit" > <i class="fa fa-edit"> </i> </button>
                          <button  v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/attendancesetup/'+form_data.id})" title="Delete" class="btn-xs btn-danger" ><i class="fa fa-trash"></i> </button>
                        </td>
                    </tr>
                    </tbody>
                     <tbody v-else>
                        <tr>
                            <td colspan="11" align="center">No data in database</td>
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
            <!--         <div class="row">
                      <div class="dataTables_footer clearfix col-md-12 col-12" style="padding: 10px 0px;">
                          <div class="col-md-6 col-6 float-left">
                              <div class="dataTables_info" id="DataTables_Table_0_info">Showing {{paginate_data.current_page}} of {{paginate_data.last_page}} pages</div>
                          </div>
                          <div class="col-md-6 col-6 float-right">
                              <div class="dataTables_paginate paging_bootstrap float-right overflow-auto" style="width: 100%;">
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


       <modal name="myModal" width="550" height="auto"  :clickToClose="false"> 
            <div v-if="modal_loading">
                <div class="widget-header modal-header">
                    <h4><i class="fa fa-bars"></i> Attendance Setup</h4>
                    <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modify-wraper modal-body" style="margin: 30px;">
                  <div class="container">
                     <form @submit.prevent="add({add:'add/attendancesetup'},resetModal)" class="well form-horizontal needs-validation" novalidate>
                      <div class="">
                        <div class="col-md-12 date_format_modal_design">
                           
                           <div class="form-group">
                              <label class="col-md-6 control-label">Employee Name</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <vue-select v-model="employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                                 </div>
                              </div>
                           </div>
                           
                           
                           <div class="form-group">
                              <label class="col-md-6 control-label">Attendance Type</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <select class="form-control" v-model="form_data.attendance_type" required="true">
                                       <option disabled>--Select--</option>
                                       <option value="1">Applicable</option>
                                       <option value="0">Not Applicable</option>
                                    </select>
                                 </div>
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="col-md-6 control-label">Attendance Category</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <select class="form-control" v-model="form_data.attendance_category" required="true">
                                       <option disabled>--Select--</option>
                                       <option value="1">As usual</option>
                                       <option value="0">Flexible
                                       </option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           
                           
                           <div class="form-group">
                              <label class="col-md-6 control-label">Machine No</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                     <vue-select v-model="attendance_machine_value" :options="option_data.attendance_machine_data" @select="onSelectMachine" placeholder="Select one" label="text" track-by="text"></vue-select>
                                 </div>
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="col-md-4 control-label">Office Time</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <vue-select v-model="office_time_value" :options="option_data.office_time_data" @select="onSelectOfficeTime" placeholder="Select one" label="text" track-by="text"></vue-select>
                                  </div>
                              </div>
                           </div>
                           <div class="row col-md-12">
                              <div class="form-group col-md-6" style="padding:0px;">
                                 <label class="col-md-6 control-label">Start Date<sup style="color:red; top: -2px;">*</sup></label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <input class="form-control" v-model="form_data.start_date" type="date">
                                       <!-- <datepicker placeholder="Select Date" v-model="form_data.start_date" class="form-control" required></datepicker> -->
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group col-md-6" style="padding:0px;">
                                 <label class="col-md-6 control-label">End Date<sup style="color:red; top: -2px;">*</sup></label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <input class="form-control" v-model="form_data.end_date" type="date">
                                       <!-- <datepicker placeholder="Select Date" v-model="form_data.end_date" class="form-control" required></datepicker> -->
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group" v-if="form_data.id">
                              <label class="col-md-6 control-label">Attendance Status</label>
                              <div class="col-md-12 inputGroupContainer">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <select class="form-control" v-model="form_data.attendance_setup_status" required="true">
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