<template>
    <div>
        <div v-if="page_loading" class="widget box">
            <div class="widget-header">
                <div>
                    <section class="content">
                        <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                                        <h3 class="card-title d-none d-md-block">Fianl Settlement List</h3>
                                        <span class="float-sm-right" style="float: right;">
                                            <!-- <div  v-if="lists.self=='self'" @click="getModalData($event,{dataUrl:'create/final_settlement'}, resetModal, add_new_type = 1)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span> 
                                            </div> -->
                                            <div v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/final_settlement'}, resetModal, add_new_type = 2)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add Settlement</span> </div>
                                            <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                                        </span>
                                    </div>
                                </div>
                                    <div class="row">
                                    <div class="col-12 col-sm-12 col-md-3">
                                        <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-paper-plane"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Request </span>
                                            <span class="info-box-number">
                                            {{lists.requestApplications}}
                                            </span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-3">
                                        <div class="info-box">
                                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Pending </span>
                                            <span class="info-box-number">
                                            {{lists.pendingApplications}}
                                            </span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-3">
                                        <div class="info-box mb-3">
                                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Done </span>
                                            <span class="info-box-number">{{lists.acceptedApplications }}</span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="clearfix hidden-md-up"></div>
                                    <div class="col-12 col-sm-12 col-md-3">
                                        <div class="info-box mb-3">
                                        <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-ban"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Rejected </span>
                                            <span class="info-box-number">{{lists.rejectedApplications}}</span>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="card-body">
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
                                    <th v-bind:class="getSortingClass('employee_id_no')" @click="sortingChanged('employee_id_no')">Employee ID <i class="fas fa-sort"></i></th>
                                    <th v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Employee <i class="fas fa-sort"></i></th>
                                    <th v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Comp./SBU  <i class="fas fa-sort"></i></th>
                                    <th v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Department <i class="fas fa-sort"></i></th>
                                    <th v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Designation <i class="fas fa-sort"></i></th>
                                    <th v-bind:class="getSortingClass('employee_joining_date')" @click="sortingChanged('employee_joining_date')">Joining Date <i class="fas fa-sort"></i></th>
                                    <th v-bind:class="getSortingClass('separation_date')" @click="sortingChanged('separation_date')">Resignation Date <i class="fas fa-sort"></i></th>
                                    <th v-bind:class="getSortingClass('last_working_date')" @click="sortingChanged('last_working_date')">L.W. Date <i class="fas fa-sort"></i></th>
                                    <th v-bind:class="getSortingClass('settlement_date')" @click="sortingChanged('settlement_date')">Settlement Date <i class="fas fa-sort"></i></th>
                                    <th v-bind:class="getSortingClass('leave_apply_status')" @click="sortingChanged('leave_apply_status')">Status <i class="fas fa-sort"></i></th>
                                    <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="Object.keys(paginate_data.data).length > 0">
                                    <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
                                        <td class="text-center">{{index+1}}</td>
                                        <td>{{form_data.employee_id_no}}</td>
                                        <td>{{form_data.employee_fullname}}</td>
                                        <td>{{form_data.sbu_name}}</td>
                                        <td>{{form_data.department_name}}</td>
                                        <td>{{form_data.designation_name}}</td>
                                        <td class="text-center">{{ form_data.employee_joining_date }}</td>
                                        <td class="text-center">{{form_data.separation_date}}</td>
                                        <td class="text-center">{{form_data.last_working_date}}</td>
                                        <td class="text-center">{{form_data.settlement_date}}</td>
                                        <td class="text-center" v-if="form_data.settlement_status==1"> Requested</td>
                                        <td class="text-center" v-if="form_data.settlement_status==2"> Approved</td>
                                        <td class="text-center" v-if="form_data.settlement_status==3"> Forwarded</td>
                                        <td class="text-center" v-if="form_data.settlement_status==4"> Rejected</td>
                                        <td class="text-center" style="padding: 5px 5px">

                                            <!-- v-if="lists.approve=='approve'" -->
                                        <button @click="getModalData($event,{dataUrl:'edit/final_settlement/'+form_data.id},setModalData, add_new_type = 4)" class="btn-xs btn-success" title="Approve" > <i class="fa fa-eye"> </i></button>
                                        <button v-if="lists.edit=='edit' && form_data.settlement_status==2" class="btn-xs btn-info" title="Already Approved!" @click="AccessDenied($event,value='Already Approved')" style="opacity: 0.5"> <i class="fa fa-edit"> </i></button>

                                        <button v-if="lists.edit=='edit' && form_data.settlement_status==3" class="btn-xs btn-info" title="Already Forwarded!" @click="AccessDenied($event,value='Already Forwarded')" style="opacity: 0.5"> <i class="fa fa-edit"> </i></button>

                                        <button v-if="lists.edit=='edit' && form_data.settlement_status==4" class="btn-xs btn-info" title="Already Rejected!" @click="AccessDenied($event,value='Already Rejected')" style="opacity: 0.5"> <i class="fa fa-edit"> </i></button>

                                        <button v-if="lists.edit=='edit' && form_data.settlement_status==1" @click="getModalData($event,{dataUrl:'edit/final_settlement/'+form_data.id},setModalData, add_new_type = 3)" class="btn-xs btn-info" title="Edit"> <i class="fa fa-edit"> </i></button>

                                        <button  v-if="lists.delete=='delete' && form_data.settlement_status==1" @click="deleteItem({delUrl:'delete/final_settlement/'+form_data.id})" title="Delete" class="btn-xs btn-danger"><i class="fa fa-trash"></i> </button>

                                        <button  v-if="lists.delete=='delete' && form_data.settlement_status==2"  @click="AccessDenied($event,value='Already Approved!')" style="opacity: 0.5" title="Delete" class="btn-xs btn-danger"><i class="fa fa-trash"></i> </button>

                                        <button  v-if="lists.delete=='delete' && form_data.settlement_status==3"  @click="AccessDenied($event,value='Already Forwarded!')" style="opacity: 0.5" title="Delete" class="btn-xs btn-danger"><i class="fa fa-trash"></i> </button>

                                        <button  v-if="lists.delete=='delete' && form_data.settlement_status==4"  @click="AccessDenied($event,value='Already Rejected!')" style="opacity: 0.5" title="Delete" class="btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody v-else>
                                    <tr>
                                        <td colspan="14" :align="center">No data in database</td>
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
                </div>
                <modal ref="modal" class="employee-modal" name="myModal" height="auto" :clickToClose="false" body-class="p-0" width="700">
                    <div v-if="modal_loading">
                        <div class="widget-header modal-header">
                            <h4><i class="fa fa-bars"></i> Final Settlement </h4>
                            <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modify-wraper modal-body">
                            <div class="">
                                <span v-if="add_new_type==3 || add_new_type==1 || add_new_type==2">
                                    <form class="" @submit.prevent="add({add:'final_settlement/add'})">
                                        <div class="col-md-12">
                                            <div class="col-md-12" v-if='add_new_type==2'>
                                                <div class="form-group" style="border: 1px solid #ddd; padding: 15px; padding-bottom: 0px;">
                                                    <label style="margin-top: -10px;">Search Employee</label>
                                                    <vue-select v-model="employee_name_search" :options="option_data.employee_data" @select="onSelectEmployeeSearch" placeholder="Select one" label="text" track-by="text" class="search-employee-box"></vue-select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 row" style="margin: 0px;">
                                                <div class="col-md-6 employee-info" style="border: 1px solid #ddd; padding: 15px;">
                                                    <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                                                        <tbody>
                                                            <tr>
                                                                <td>Employee Name</td>
                                                                <td>:</td>
                                                                <td style="font-weight: bold;">
                                                                    {{form_data.user_employee_data.employee_fullname}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Grade</td>
                                                                <td>:</td>
                                                                <td>{{form_data.user_employee_data.jobgrade_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Date of Joining</td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ form_data.employee_joining_date_custom}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Date of Resigning</td>
                                                                <td>:</td>
                                                                <td>
                                                                    <span v-if="form_data.user_employee_data.separation_date"> 
                                                                        {{ formatCompat(form_data.user_employee_data.separation_date)}}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Last Working Date</td>
                                                                <td>:</td>
                                                                <td>
                                                                    <span v-if="form_data.user_employee_data.last_working_date"> 
                                                                        {{ formatCompat(form_data.user_employee_data.last_working_date) }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Years of Service</td>
                                                                <td>:</td>
                                                                <td>{{form_data.fs_service_length}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-6 employee-info" style="border: 1px solid #ddd; padding: 15px;">
                                                    <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                                                        <tbody>
                                                            <tr>
                                                                <td>ID Number</td>
                                                                <td>:</td>
                                                                <td>{{form_data.user_employee_data.employee_id_no}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Company/SBU</td>
                                                                <td>:</td>
                                                                <td>{{form_data.user_employee_data.sbu_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Designation</td>
                                                                <td>:</td>
                                                                <td>{{form_data.user_employee_data.designation_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Department</td>
                                                                <td>:</td>
                                                                <td>{{form_data.user_employee_data.department_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Work Location</td>
                                                                <td>:</td>
                                                                <td>{{form_data.user_employee_data.work_location_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Last Gross Salary</td>
                                                                <td>:</td>
                                                                <td>
                                                                    <input class="" v-model="form_data.fs_gross_amount" type="number">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top:15px; margin-bottom: 15px;">
                                            <div class="col-md-12 leave-info date_format_modal_design">
                                                <input type="hidden" v-model="form_data.employee_id">
                                                <div class="row" style="border: 1px solid #ddd; margin: 0px;">
                                                    <div class="col-md-6" style="border-right: 2px solid #ddd; padding: 0px;">
                                                        <div class="col-md-12 dues-head">
                                                            <label for="">Dues Head</label>
                                                        </div>
                                                        <div class="form-group datepicker-container">
                                                            <div class="row col-md-12 dues-head-row">
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">Unpaid Salary From</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.unpaid_salary_from" type="date">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">Unpaid Salary To</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.unpaid_salary_to" type="date"
                                                                            @click="updateValue($event.target)"  
                                                                            v-on:input="updateValue($event.target)" 
                                                                            v-on:keyup="updateValue($event.target)"
                                                                            >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row col-md-12" style="margin-top: 10px;">
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">Unpaid Sal. Days</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            {{ form_data.unpaid_salary_days }}
                                                                            <!-- <input class="form-control" v-model="form_data.unpaid_salary_days" type="number" readonly> -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="form-group col-md-4">
                                                                    <label class="col-md-12 control-label">Unp. Sal. Amount</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.unpaid_salary_amount" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                <div class="form-group col-md-6" style="padding-right: 0px;">
                                                                    <label class="col-md-12 control-label">PF on Unp. Sal.</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.unpaid_salary_pf" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row col-md-12" style="margin-top: 10px;">
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">Unpaid Overtime Hour</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.unpaid_overtime_hour" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6" style="padding-right: 0px;">
                                                                    <label class="col-md-12 control-label">Unpaid Overtime Rate</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.unpaid_overtime_rate" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row col-md-12" style="margin-top: 10px;">    
                                                                <div class="form-group col-md-4">
                                                                    <label class="col-md-12 control-label">PF Profit & Forfeited </label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.pf_profit_forfeited" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label class="col-md-12 control-label">PF Employee Contrib</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.pf_employee_contribution" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label class="col-md-12 control-label">PF Employer Contrib</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.pf_employer_contribution" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                            <div class="row col-md-12" style="margin-top: 10px;">
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">Annual Leave Days</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.annual_leave_days" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">Annual Leave Rate (Per Day)</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.annual_leave_rate" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row col-md-12" style="margin-top: 10px;">
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">GF 2009 to 2016 (Years)</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.gf_9_16_years" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">GF 2009 to 2016(Amount)</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.gf_9_16_gross" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row col-md-12" style="margin-top: 10px;">
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">GF 2017 to End (Years)</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.gf_17_end_years" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">GF 2017 to End (Amount)</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.gf_17_end_basic" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="row col-md-12" style="margin-top: 10px;">
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">Cashier Deposit</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.cashier_deposit" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">Uniform Deposit</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.uniform_deposit" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row col-md-12" style="margin-top: 10px;">
                                                                <div class="form-group col-md-3" style="padding-right: 0px;">
                                                                    <label class="col-md-12 control-label">Notice Pay Month</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.notice_pay_month" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-3" style="padding-right: 0px;">
                                                                    <label class="col-md-12 control-label">N. Pay Amount</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.notice_pay_amount" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">Covid Adjutment(Sal.& Bonus)</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.covid_adjustment_amount" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row col-md-12" style="margin-top: 10px;">
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">One off Bonus Month</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.due_oneoff_bonus_month" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-12 control-label">One off Bonus Rate</label>
                                                                    <div class="col-md-12 inputGroupContainer">
                                                                        <div class="input-group">
                                                                            <input class="form-control" v-model="form_data.due_oneoff_bonus_rate" type="number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding: 0px;">
                                                        <div class="col-md-12 dues-head">
                                                            <label for="">Deductions</label>
                                                        </div>
                                                        <div class="form-group datepicker-container dues-head-row">
                                                            <div class="form-group co-md-12">
                                                                <label class="col-md-12 control-label">Income Tax</label>
                                                                <div class="col-md-12 inputGroupContainer">
                                                                    <div class="input-group">
                                                                        <input class="form-control" v-model="form_data.income_tax" type="number">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group co-md-12" style="margin-top: 15px;">
                                                                <label class="col-md-12 control-label">Loan / Advance</label>
                                                                <div class="col-md-12 inputGroupContainer">
                                                                    <div class="input-group">
                                                                        <input class="form-control" v-model="form_data.loan_advance" type="number">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group co-md-12" style="margin-top: 15px;">
                                                                <label class="col-md-12 control-label">Bonus Reimbursement</label>
                                                                <div class="col-md-12 inputGroupContainer">
                                                                    <div class="input-group">
                                                                        <input class="form-control" v-model="form_data.bonus_reimbursement" type="number">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group co-md-12" style="margin-top: 15px;">
                                                                <label class="col-md-12 control-label">Uniform Deduction</label>
                                                                <div class="col-md-12 inputGroupContainer">
                                                                    <div class="input-group">
                                                                        <input class="form-control" v-model="form_data.uniform_deduction" type="number">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group co-md-12" style="margin-top: 15px;">
                                                                <label class="col-md-12 control-label">Excess Mobile Bill</label>
                                                                <div class="col-md-12 inputGroupContainer">
                                                                    <div class="input-group">
                                                                        <input class="form-control" v-model="form_data.excess_mobile_bill" type="number">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group co-md-12" style="margin-top: 15px;">
                                                                <label class="col-md-12 control-label">Notice Pay (Per Day Basic Salary)</label>
                                                                <div class="col-md-12 inputGroupContainer">
                                                                    <div class="input-group">
                                                                        <input class="form-control" v-model="form_data.notice_pay_deduct_rate" type="number">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group co-md-12" style="margin-top: 15px;">
                                                                <label class="col-md-12 control-label">Notice Pay Month</label>
                                                                <div class="col-md-12 inputGroupContainer">
                                                                    <div class="input-group">
                                                                        <input class="form-control" v-model="form_data.notice_pay_deduct_days" type="number">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group co-md-12" style="margin-top: 15px;">
                                                                <label class="col-md-12 control-label">PF (Advance Paid)</label>
                                                                <div class="col-md-12 inputGroupContainer">
                                                                    <div class="input-group">
                                                                        <input class="form-control" v-model="form_data.pf_advance_paid" type="number">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group co-md-12" style="margin-top: 15px;">
                                                                <label class="col-md-12 control-label">Other Deduction</label>
                                                                <div class="col-md-12 inputGroupContainer">
                                                                    <div class="input-group">
                                                                        <input class="form-control" v-model="form_data.fs_others_deduction" type="number">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group co-md-12" style="margin-top: 15px;">
                                                                <label class="col-md-12 control-label">Remarks</label>
                                                                <div class="col-md-12 inputGroupContainer">
                                                                    <div class="input-group">
                                                                        <input class="form-control" v-model="form_data.fs_remarks" type="text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions col-md-12">
                                            <input type="submit" tabindex="4" value="Submit" class="btn btn-sm btn-info float-right col-md-2">
                                            <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button>
                                        </div>
                                    </form>
                                </span>
                                <span v-if="add_new_type==4">
                                    <div class="col-md-1 offset-md-11 row" style="margin-top: -10px;">
                                        <button style="width: 63px; height: 22px; border-radius: 3px;"
                                            @click="printDiv()"
                                            class="btn-info float-right">
                                            Print
                                        </button>
                                    </div>
                                    <div class="col-md-12" id="printable">
                                        <div class="col-md-12">
                                            <div class="col-md-12" width="100%">
                                                <div class="form-group full-final-settlement-head" style="border: 1px solid #ddd; padding: 5px;background: #202020;color: #fff;">
                                                    <div class="text-center" style="width: 100% !important">
                                                        <div style="width: 50% !important;">
                                                            <div class="float-left" style="width: 75px; background: #fff; border-radius: 3px; float: left;">
                                                                <img :src="`company_logo/group_company_logo.png`" class="card-img-top border rounded float-left" style="height: 38px; object-fit: contain;">
                                                            </div>
                                                        </div>
                                                        <div class="settlement-header" style="width: 94% !important; text-align: center; vertical-align: middle;">
                                                            <h6 style="margin: 0px; font-size: 16px;">GEMCON GROUP</h6>
                                                            <h6 style="margin: 0px; font-size: 15px;">Full & Final Settlement</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 row" style="margin: 0px; margin-top: 8px;">
                                                <div class="col-md-12 employee-info" style="padding: 0px;">
                                                    <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table settlement-table-border employee-info-details" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td>Employee Name</td>
                                                                <td style="font-weight: bold;">
                                                                    {{form_data.user_employee_data.employee_fullname}}
                                                                </td>
                                                                <td>ID Number</td>
                                                                <td>{{form_data.user_employee_data.employee_id_no}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Grade</td>
                                                                <td>{{form_data.user_employee_data.jobgrade_name}}</td>
                                                                <td>Company/SBU</td>
                                                                <td>{{form_data.user_employee_data.sbu_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Date of Joining</td>
                                                                <td>
                                                                    {{ form_data.employee_joining_date_custom}}
                                                                </td>
                                                                <td>Designation</td>
                                                                <td>{{form_data.user_employee_data.designation_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Date of Resigning</td>
                                                                <td>
                                                                    <span v-if="form_data.user_employee_data.separation_date"> 
                                                                        {{ formatCompat(form_data.user_employee_data.separation_date)}}
                                                                    </span>
                                                                </td>
                                                                <td>Department</td>
                                                                <td>{{form_data.user_employee_data.department_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Last Working Date</td>
                                                                <td>
                                                                    <span v-if="form_data.user_employee_data.last_working_date"> 
                                                                        {{ formatCompat(form_data.user_employee_data.last_working_date) }}
                                                                    </span>
                                                                </td>
                                                                <td>Work Location</td>
                                                                <td>{{form_data.user_employee_data.work_location_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Years of Service</td>
                                                                <td>{{form_data.fs_service_length}}</td>
                                                                <td>Last Gross Salary</td>
                                                                <td>BDT 
                                                                    {{Number(form_data.fs_gross_amount).toLocaleString("en-IN")}}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style=" margin-top: 8px; margin-bottom: 15px;">
                                            <div class="col-md-12 leave-info date_format_modal_design">
                                                <div class="row" style="margin: 0px;">
                                                    <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table settlement-table-border dues-head-report" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <th style="text-align:left; background: #bfbfbf; width: 13%;">Dues Head</th>
                                                                <th style="text-align:center; background: #bfbfbf;" colspan="3">Particular</th>
                                                                <th style="text-align:center; background: #bfbfbf; width: 15%;">Amount (Tk.)</th>
                                                            </tr>
                                                            <tr>
                                                                <td rowspan="3">Unpaid Salary</td>
                                                                <td style="text-align:center;">From</td>
                                                                <td style="text-align:center;">To</td>
                                                                <td style="text-align:center;">Days</td>
                                                                <td style="text-align:center;"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align:center;">
                                                                    {{formatCompat(form_data.unpaid_salary_from)}}
                                                                </td>
                                                                <td style="text-align:center;">
                                                                    {{formatCompat(form_data.unpaid_salary_to)}}
                                                                </td>
                                                                <td style="text-align:center;">
                                                                    {{form_data.unpaid_salary_days}} Days
                                                                </td>
                                                                <td style="text-align:right;">
                                                                    {{ Number(form_data.unpaid_salary_amount).toLocaleString("en-IN") }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" style="text-align:center;">PF on Unpaid Salary (If service length => 3 years)</td>
                                                                <td style="text-align:right;">
                                                                    {{ Number(Math.round(form_data.unpaid_salary_pf)).toLocaleString("en-IN") }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">Unpaid Overtime</td>
                                                                <td style="text-align:center;">{{form_data.unpaid_overtime_hour}} Hours</td>
                                                                <td style="text-align:center;">Per Hour Rate: 
                                                                    {{Number(form_data.unpaid_overtime_rate).toLocaleString("en-IN")}}
                                                                </td>
                                                                <td style="text-align:right;">
                                                                    {{Number(form_data.unpaid_overtime_amount).toLocaleString("en-IN")}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td rowspan="2">Profident Fund</td>
                                                                <td style="text-align:center;">Employee+Employer+Profit+Forfeited up to {{form_data.profit_forfeited_year}}
                                                                </td>
                                                                <td style="text-align:center;">Employee Contribution from {{ form_data.joining_month_year }}</td>
                                                                <td style="text-align:center;">Employer Contribution from {{form_data.joining_month_year}}</td>
                                                                <td rowspan="2" style="text-align:right;">
                                                                    {{Number((+form_data.pf_employee_contribution)+(+form_data.pf_employer_contribution)+(+form_data.pf_profit_forfeited)).toLocaleString("en-IN")}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align:right;">{{Number(form_data.pf_employee_contribution).toLocaleString("en-IN")}}</td>
                                                                <td style="text-align:right;">{{Number(form_data.pf_employer_contribution).toLocaleString("en-IN")}}</td>
                                                                <td style="text-align:right;">
                                                                    {{Number(form_data.pf_profit_forfeited).toLocaleString("en-IN")}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align:left;">Leave Encashment (Annual Leave)</td>
                                                                <!-- <td style="text-align:left;">Annual Leave</td> -->
                                                                <td style="text-align:center;">{{form_data.annual_leave_days}} Days</td>
                                                                <td style="text-align:center;">
                                                                    {{Number(form_data.annual_leave_rate).toLocaleString("en-IN")}} per day
                                                                </td>
                                                                <td style="text-align:right;">
                                                                    {{Number(form_data.total_leave_encashment).toLocaleString("en-IN")}}
                                                                </td>
                                                            </tr>
                                                            <tr v-if="form_data.gratuity_9_16_view == 1">
                                                                <td rowspan="2" style="">Gratuity</td>
                                                                <td style="text-align:left;">2009 to 2016</td>
                                                                <td style="text-align:center;">{{form_data.gf_9_16_years}}</td>
                                                                <td style="text-align:center;">Gross Salary</td>
                                                                <td rowspan="2" style="text-align:right;">
                                                                    {{Number(form_data.total_gratuity_amount).toLocaleString("en-IN")}}
                                                                </td>
                                                            </tr>
                                                            <tr v-if="form_data.gratuity_9_16_view == 1">
                                                                <td style="text-align:left;">2017 to 2016</td>
                                                                <td style="text-align:center;">{{form_data.gf_17_end_years}}</td>
                                                                <td style="text-align:center;">Basic Salary</td>
                                                            </tr>
                                                            <tr v-if="form_data.gratuity_9_16_view != 1">
                                                                <td>Gratuity</td>
                                                                <td style="text-align:left;">2017 to 2016</td>
                                                                <td style="text-align:center;">{{form_data.gf_17_end_years}}</td>
                                                                <td style="text-align:center;">Basic Salary</td>
                                                                <td style="text-align:right;">
                                                                    {{Number(form_data.total_gratuity_amount).toLocaleString("en-IN")}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">Cashier Deposit</td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:right;">
                                                                    {{Number(form_data.cashier_deposit).toLocaleString("en-IN")}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">Uniform Deposit</td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:right;">
                                                                    {{ Number(form_data.uniform_deposit).toLocaleString("en-IN")}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Notice Pay</td>
                                                                <td style="text-align:center;">Months</td>
                                                                <td style="text-align:center;">{{form_data.notice_pay_month}}</td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:right;">
                                                                    {{ Number(form_data.notice_pay_amount).toLocaleString("en-IN") }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td rowspan="2">Special Payment</td>
                                                                <td colspan="3" style="text-align:center;">Covid Adjustsment (Salary & Bonus)</td>
                                                                <td style="text-align:right;">{{Number(form_data.covid_adjustment_amount).toLocaleString("en-IN")}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align:center;">Oneoff Bonus from {{ form_data.oneoffbonus_month_year }}</td>
                                                                <td style="text-align:center;">
                                                                    {{Number(form_data.due_oneoff_bonus_rate).toLocaleString("en-IN")}} monthly
                                                                </td>
                                                                <td style="text-align:center;">
                                                                    {{form_data.due_oneoff_bonus_month}} months
                                                                </td>
                                                                <td style="text-align:right;">
                                                                    {{Number(form_data.total_due_oneoff_bonus).toLocaleString("en-IN")}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" style="text-align:center;"><b>Total Payable (Tk.)</b></td>
                                                                <td style="text-align:right;"><b>
                                                                    {{Number(form_data.total_payable).toLocaleString("en-IN")}}
                                                                </b></td>
                                                            </tr>

                                                            <!-- Deductions parte start from here -->
                                                            <tr>
                                                                <th colspan="5" style="text-align:left; background: #bfbfbf;">Deductions</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align:left;">Income Tax</td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:right;">{{Number(form_data.income_tax).toLocaleString("en-IN")}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align:left;">Loan / Advance</td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:right;">{{Number(form_data.loan_advance).toLocaleString("en-IN")}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align:left;">Bonus Reimbursement</td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:right;">{{Number(form_data.bonus_reimbursement).toLocaleString("en-IN")}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align:left;">Uniform</td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:right;">{{Number(form_data.uniform_deduction).toLocaleString("en-IN")}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align:left;">Excess Mobile Bill</td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:right;">{{Number(form_data.excess_mobile_bill).toLocaleString("en-IN")}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align:left;">Notice Pay</td>
                                                                <td colspan="2" style="text-align:center;">{{Number(form_data.notice_pay_deduct_rate).toLocaleString("en-IN")}} Per Day Basic Salary</td>
                                                                <td style="text-align:center;">{{form_data.notice_pay_deduct_days}} Days</td>
                                                                <td style="text-align:right;">{{Number(form_data.notice_pay_deduct_amount).toLocaleString("en-IN")}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align:left;">PF (Advance Paid)</td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:right;">
                                                                    {{Number(form_data.pf_advance_paid).toLocaleString("en-IN")}}
                                                                    <!-- {{Number(form_data.pf_advance_paid).toLocaleString("en-IN",{minimumFractionDigits: 2, maximumFractionDigits: 2})}} -->
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align:left;">Other Deduction</td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:center;"></td>
                                                                <td style="text-align:right;">{{Number(form_data.fs_others_deduction).toLocaleString("en-IN")}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" style="text-align:center;"><b>Total Deduction (Tk.)</b></td>
                                                                <td style="text-align:right;">{{Number(form_data.total_deduction).toLocaleString("en-IN")}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" style="text-align:left;"><b>Net Payable (Tk.)</b></td>
                                                                <td style="text-align:right;">
                                                                    {{Number(form_data.net_payable).toLocaleString("en-IN")}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5" style="text-align:left;">In Word: {{ form_data.net_payable_inword }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5" style="text-align:left;">Remarks: {{ form_data.fs_remarks }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="table settlement-table-border dues-head-report" width="100%" style="margin-top:8px;">
                                                        <tbody style="margin-top:20px;">
                                                            <tr> 
                                                                <td style="text-align: center;">Prepared By:</td>
                                                                <td style="text-align: center;">Checked By:</td>
                                                                <td style="text-align: center;">Approved By:</td>
                                                                <td style="text-align: center;">Approved By:</td>
                                                            </tr>
                                                            <tr style="height: 90px !important;"> 
                                                                <td style="text-align: center;"></td>
                                                                <td style="text-align: center;"></td>
                                                                <td style="text-align: center;"></td>
                                                                <td style="text-align: center;"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td style="text-align: center;">
                                                                    <b>Nurul Huda Sayem</b>
                                                                    <p style="margin: 0px;">Manager, HR</p>
                                                                    <p style="margin: 0px;">Gemcon Group</p>
                                                                </td>
                                                                <td style="text-align: center;">
                                                                    <b>Tareq Bin Mahfuz</b>
                                                                    <p style="margin: 0px;">General Manager, Accounts</p>
                                                                    <p style="margin: 0px;">Gemcon Group</p>
                                                                </td>
                                                                <td style="text-align: center;">
                                                                    <b>S.M. Rakibul Haque</b>
                                                                    <p style="margin: 0px;">Cheif Human Resources Officer</p>
                                                                    <p style="margin: 0px;">Gemcon Group</p>
                                                                </td>
                                                                <td style="text-align: center;">
                                                                    <b>Firoz Alam</b>
                                                                    <p style="margin: 0px;">Cheif Financial Officer</p>
                                                                    <p style="margin: 0px;">Gemcon Group</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table> 
                                                    <div class="col-md-12" style="margin-top:8px; padding: 0px; border:none; font-size: 12px;">
                                                        <div class="col-md-12">
                                                            <p style="margin: 0px;">1. Approved Resignation Letter</p>
                                                            <p style="margin: 0px;">2. PF, Gratuity & Others calculation breakdown</p>
                                                            <p style="margin: 0px;">3. Clearance Report</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="border: 1px solid #000; margin: 0px;margin-top: 8px;">
                                                    <div class="col-md-12" style="padding: 0px;">
                                                        <div class="col-md-12" style="padding: 0px 3px; font-size: 12px;">
                                                            <p style="margin: 4px 0px;"><b>Receive a sum of BDT 
                                                                {{Number(form_data.net_payable).toLocaleString("en-IN")}}
                                                            </b></p>
                                                            <p style="text-align: justify;">As shown above is full and final settlement of my legal dues from the company. I do not have any further claims or dispute regarding payment / employment / re-employment of whatever nature. I confirm that I have returned all company properties and information.</p>

                                                            <p style="margin: 0px; margin-top: 5%;">Signature of </p>
                                                            <p style="margin: 0px;">Employee with Date:  <span style="float:right; margin-right: 30%;">Mobile No#</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions col-md-12">
                                        <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button>
                                    </div>
                                </span>
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
    export default {
        data(){
            return{
                employee_name_search:'',
                employee_name_value:'',
                // effective_date:'',
                center: '',
                date_format: '',
                get_service_length: '',
                add_new_type:'',
                totalDayss: ''
            }
        },
        components:{
            pageLoading:Loading
        },
        computed:{
        },
        created(){
            this.getResults(1);
        },
        methods:{
            formatCompat(date_format) {
                var ms = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                return new Date(date_format).getDate() + ' ' + ms[new Date(date_format).getMonth()] + ' ' + new Date(date_format).getFullYear();
            },
            dateToYYYYMMDD(d) {
                return d && new Date(d.getTime()-(d.getTimezoneOffset()*60*1000)).toISOString().split('T')[0];
            },
            // updateValue: function (target) {
            //     const date1 = new Date(this.form_data.last_working_date);
            //     const tomorrow = new Date(date1)
            //     this.effective_date = tomorrow.setDate(tomorrow.getDate() + 1);
            //     this.form_data.effective_date = new Date(this.effective_date);
            //     this.effective_date = new Date(this.effective_date);
            //     console.log(this.form_data.effective_date);
            // },
            selectAll: function (event) {
                setTimeout(function () {
                    event.target.select()
                }, 0)
            },
            onSelectEmployeeSearch(option){
                this.form_data.resignation_apply_by= option.id;
                let allData =this.form_data.user_employee_data_all[option.id];
                // console.log(allData);
                this.form_data.employee_id= allData['id']; 
                this.form_data.user_employee_data.employee_id_no= allData['employee_id_no']; 
                this.form_data.user_employee_data.employee_fullname= allData['employee_fullname']; 
                this.form_data.user_employee_data.employee_mobile= allData['employee_mobile']; 
                this.form_data.user_employee_data.employee_joining_date=allData['employee_joining_date'];
                this.form_data.user_employee_data.separation_date= allData['separation_date'] ?? '';
                this.form_data.resign_id= allData['resign_id'] ?? '';
                this.form_data.user_employee_data.last_working_date=allData['last_working_date'] ?? '';
                this.form_data.user_employee_data.employee_type=allData['employee_type'];
                this.form_data.user_employee_data.designation_name=allData['designation_name'];
                this.form_data.user_employee_data.department_name=allData['department_name'];
                this.form_data.user_employee_data.sbu_name=allData['sbu_name'];
                this.get_service_length = this.findServiceLength(allData['employee_joining_date'], allData['last_working_date']);
                this.form_data.fs_service_length = this.get_service_length;
                console.log(this.get_service_length);
                if (allData['employee_image']) {
                    this.form_data.user_employee_data.employee_image=allData['employee_image'];
                }else {
                    this.form_data.user_employee_data.employee_image='';
                }
            },
            findServiceLength(joining_date, last_working_date){
                const date1 = new Date(joining_date);
                const date2 = new Date(last_working_date);
                const diffTime = Math.abs(date2 - date1);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                const serviceLength = (diffDays/365).toFixed(2);
                return serviceLength;
            },
            setModalData(){
                this.employee_name_search=this.form_data.employee_name_search;
                this.employee_name_value=this.form_data.employee_name_value;
                this.leave_type_value=this.form_data.leave_type_value;
            },
            resetModal(){
                this.form_data.employee_id= this.form_data.user_employee_data.id;
                this.form_data.separation_type='';
                this.form_data.separation_reason='';
                this.employee_name_search='';
            },
            printDiv() {
                let contents = document.getElementById("printable");
                var htmlToPrint = '' +
                    '<style type="text/css">' +
                        'table th, table td {' +
                            'border:1px solid #000;' +
                            'padding:0px 3px;' +
                            'font-size:12px;' +
                        '}' +
                        'table {'+
                            'border-collapse: collapse;'+
                        '}'+
                        '.full-final-settlement-head {'+
                            'height: 38px;'+
                        '}'+
                        '#printable {'+
                            'font-family: sans-serif;'+
                        '}'+
                        '.settlement-header {'+
                            'vertical-align: middle'+
                        '}'+
                        '.employee-info-details td{'+
                            'padding: 3px;'+
                        '}'+
                    '</style>';
                htmlToPrint += contents.outerHTML;
                let frame1 = document.createElement("iframe");
                frame1.name = "frame1";
                frame1.style.position = "absolute";
                frame1.style.top = "-1000000px";
                document.body.appendChild(frame1);
                let frameDoc = frame1.contentWindow
                    ? frame1.contentWindow
                    : frame1.contentDocument.document
                    ? frame1.contentDocument.document
                    : frame1.contentDocument;
                frameDoc.document.open();
                frameDoc.document.write(
                    '<html lang="en"><head><title style="font-size: 6px; margin-left: 0px;">Full & Fianl Settlement</title>'
                );
                frameDoc.document.write("</head><body>");
                frameDoc.document.write(htmlToPrint);
                frameDoc.document.write("</body></html>");
                frameDoc.document.close();
                setTimeout(function () {
                    window.frames["frame1"].focus();
                    window.frames["frame1"].print();
                    document.body.removeChild(frame1);
                }, 500);
                return false;
            },

            updateValue: function (target) {
                // console.log('fff');
                const date1 = new Date(this.form_data.unpaid_salary_from);
                const date2 = new Date(this.form_data.unpaid_salary_to);
                const diffTime = Math.abs(date2 - date1);
                const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24)); 
                // this.totalDays=(+ diffDays)+(+1) + " d";
                this.form_data.unpaid_salary_days = (+ diffDays)+(+1);
            },
        }
    }
</script>
<style type="text/css">
    .vdp-datepicker {
        border-bottom: 0px solid #cfcfcf;
    }
    .vdp-datepicker input {
        border-bottom: 1px solid #dcdcdc;
        border-bottom-right-radius: 5px;
        height: 20px;
    }
    .dues-head{
        background: #ebebeb;
        padding: 5px;
        padding-left: 15px;
        text-align: center;
    }
    .dues-head-row{
        margin: 0px;
        padding: 0px;
        padding-top: 15px;
    }
    .search-employee-box .multiselect__tags .multiselect__single{
        padding: 5px 0px;
    }
    .search-employee-box .multiselect__tags .multiselect__placeholder{
        padding: 5px 0px;
    }
    .search-employee-box .multiselect__content-wrapper{
        width: 101% !important;
    }
    .settlement-table-border td{
        border: 1px solid;
        padding: 5px;
    }
    .settlement-table-border tbody{
        height: 140px !important;
    }
    .dues-head-report th{
        background: #ddd !important;
        padding: 5px !important;
        border: 1px solid;
    }
</style>