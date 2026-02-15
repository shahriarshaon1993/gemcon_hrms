<template>
    <div>
        <div v-if="page_loading" class="widget box">
            <div class="widget-header">
                <div>
                    <!-- Main content -->
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                                                    <h3 class="card-title d-none d-md-block">Job Circular Info</h3>
                                                    <span class="float-sm-right" style="float: right;">
                            <a v-if="lists.view_job=='view_job'" target="_blank" class="btn btn-warning" href="/career" style="color:#fff;"><i class="fa fa-list"></i> View All Job</a>
                            <div v-if="lists.add=='add'" @click="openAddModal" class="btn-group">
                                <span class="btn btn-sm btn-info">
                                    <i class="icon-plus"></i>Add Circular
                                </span>
                            </div>
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
                                                            <button style="margin-right: 5px; font-size:14px;" class="btn btn-xs btn-info"  @click="tableToExcel('table', 'Employee Data')">Export to excel</button>
                                                            <input v-on:keyup="getResults" v-model="search_input.search_key" type="text" aria-controls="DataTables_Table_0" class="form-control search-keyword" id="search"  placeholder="Search..." style="border-radius: 0px;">
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>

                                            <table ref="table" id="loremTable" summary="lorem ipsum sit amet" rules="groups" frame="hsides"  class="table table-bordered table-striped employeeTable">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">SL</th>
                                                    <th class="text-center" v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Job Position <i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('department_code')" @click="sortingChanged('jc_circular_id')">Circular ID <i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('jc_circular_id')" @click="sortingChanged('jc_job_vacancy')">Vacancy <i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('jc_job_vacancy')" @click="sortingChanged('designation_name')">Applied No. <i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Short Listed <i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Selected <i class="fas fa-sort"></i></th>
                                                    <!-- <th class="text-center" v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Appointed <i class="fas fa-sort"></i></th> -->
                                                    <th class="text-center" v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Assign To <i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Publish Date <i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('jc_circular_publish_date')" @click="sortingChanged('jc_circular_publish_date')">Expired Date <i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('jc_circular_expired_date')" @click="sortingChanged('jc_circular_expired_date')">Status <i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('jc_circular_status')" @click="sortingChanged('jc_circular_status')">Action <i class="fas fa-sort"></i></th>
                                                </tr>
                                                </thead>
                                                <tbody v-if="Object.keys(paginate_data.data).length > 0">
                                                <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
                                                    <td class="text-center">{{index+1}}</td>
                                                    <td>{{form_data.designation_name}}</td>
                                                    <td>{{form_data.jc_circular_id}}</td>
                                                    <td class="text-center">{{form_data.jc_job_vacancy}}</td>
                                                    <td class="text-center">
                              <span v-for="candidate_count in lists.apply_candidate_count">
                                <span v-if="candidate_count.circular_id == form_data.id">
                                  {{candidate_count.total_candidate}}
                                </span>
                              </span>
                                                    </td>
                                                    <td class="text-center">
                              <span v-for="candidate_count in lists.shorlist_candidate_count">
                                <span v-if="candidate_count.circular_id == form_data.id">
                                  {{candidate_count.total_candidate}}
                                </span>
                              </span>
                                                    </td>
                                                    <td class="text-center">
                              <span v-for="candidate_count in lists.selected_candidate_count">
                                <span v-if="candidate_count.circular_id == form_data.id">
                                  {{candidate_count.total_candidate}}
                                </span>
                              </span>
                                                    </td>
                                                    <td>{{form_data.employee_fullname}}</td>
                                                    <td>{{form_data.jc_circular_publish_date}}</td>
                                                    <td>{{form_data.jc_circular_expired_date}}</td>
                                                    <td v-if="form_data.jc_circular_status==1" style="color:green;">{{'Publish'}}</td>
                                                    <td v-if="form_data.jc_circular_status==2">{{'Unpublish'}}</td>
                                                    <td style="padding: 5px 5px">
                                                        <router-link v-if="lists.cv_list=='cv_list'" :to="'/cv-list/'+form_data.id" class="btn btn-warning btn-xs" title="Applicant List">
                                                            <i class="fa fa-list"></i>
                                                        </router-link>
                                                        <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/job_circular/'+form_data.id},setModalData)" class="btn btn-info btn-xs" title="Edit" > <i class="fa fa-edit"> </i>  </button>
                                                        <button  v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/job_circular/'+form_data.id})" title="Delete" class="btn btn-danger btn-xs" ><i class="fa fa-trash"></i> </button>
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
                    <!-- /.content -->
                </div>

                <!-- data form modal -->
                <modal v-if="!isSubmitting" ref="modal" class="employee-modal" name="myModal" height="auto" :clickToClose="false" body-class="p-0">
                    <div v-if="modal_loading">
                        <div class="widget-header modal-header">
                            <h4>
                                <i class="icon-reorder"></i>
                                Job Circular Form
                            </h4>
                            <button type="button" @click="hideModal" class="close close-modify" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modify-wraper modal-body">
                            <div class="container px-3">
                                <form @submit.prevent="onSubmit">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="">
                                                Company Name
                                                <span style="color:red;">*</span>
                                            </label>
                                            <vue-select
                                                v-model="form.jc_company_name"
                                                :options="company_sbu_data"
                                                label="text"
                                                track-by="text"
                                            ></vue-select>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_circular_id">
                                                Job Circular ID
                                                <span style="color:red;">*</span>
                                            </label>
                                            <input
                                                v-model="form.jc_circular_id"
                                                id="remarks" name="remarks"
                                                placeholder=""
                                                class="form-control"
                                                type="text"
                                            />
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_job_position">
                                                Job Position
                                                <span style="color:red;">*</span>
                                            </label>
                                            <vue-select
                                                v-model="form.jc_job_position"
                                                :options="designation_data"
                                                @select="onSelectDesignation"
                                                placeholder="Select one"
                                                label="text" track-by="text"
                                            ></vue-select>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_job_department">
                                                Department
                                                <span style="color:red;">*</span>
                                            </label>
                                            <vue-select
                                                v-model="form.jc_job_department"
                                                :options="department_data"
                                                placeholder="Select one"
                                                label="text" track-by="text"
                                            ></vue-select>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_job_vacancy">
                                                Job Vacancy
                                                <span style="color:red;">*</span>
                                            </label>
                                            <input
                                                v-model="form.jc_job_vacancy"
                                                id="remarks"
                                                name="remarks"
                                                placeholder=""
                                                class="form-control"
                                                type="number"
                                            />
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_job_description">
                                                Job Description
                                                <span style="color:red;">*</span>
                                            </label>
                                            <vue-editor
                                                v-model="form.jc_job_description"
                                                style="width: 100%;"
                                            ></vue-editor>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_job_responsibility">Job Responsibility</label>
                                            <vue-editor
                                                v-model="form.jc_job_responsibility"
                                                style="width: 100%;"
                                            ></vue-editor>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_applied_requirements">Applied Requirements</label>
                                            <vue-editor
                                                v-model="form.jc_applied_requirements"
                                                style="width: 100%;"
                                            ></vue-editor>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_job_requirements">Job Requirements</label>
                                            <vue-editor
                                                v-model="form.jc_job_requirements"
                                                style="width: 100%;"
                                            ></vue-editor>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_job_nature">
                                                Job Nature
                                                <span style="color:red;">*</span>
                                            </label>
                                            <select v-model="form.jc_job_nature" name="employee_status" class="form-control">
                                                <option>--Select--</option>
                                                <option value="1">Full Time</option>
                                                <option value="2">Half Time</option>
                                                <option value="3">Contractual</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_educational_requirements">Educational Requirements</label>
                                            <input
                                                v-model="form.jc_educational_requirements"
                                                id="jc_experience_requirements"
                                                placeholder=""
                                                class="form-control"
                                                type="text"
                                            />
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_educational_requirements">Experience Requirements</label>
                                            <input
                                                v-model="form.jc_experience_requirements"
                                                id="jc_experience_requirements"
                                                placeholder=""
                                                class="form-control"
                                                type="text"
                                            />
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_job_location">
                                                Work Location
                                                <span style="color: red;">*</span>
                                            </label>
                                            <vue-select
                                                v-model="form.jc_job_location"
                                                :options="work_location_data"
                                                @select="onSelectWorkLocation"
                                                placeholder="Select one"
                                                label="text" track-by="text"
                                            ></vue-select>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_salary_range">
                                                Salary Range
                                                <span style="color: red;">*</span>
                                            </label>
                                            <input
                                                v-model="form.jc_salary_range"
                                                id="jc_salary_range"
                                                placeholder=""
                                                class="form-control"
                                                type="text"
                                            />
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_salary_range">Other Benefits</label>
                                            <vue-editor
                                                v-model="form.jc_other_benefits"
                                                style="width: 100%;"
                                            ></vue-editor>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_salary_range">
                                                Circular Assign To
                                                <span style="color:red;">*</span>
                                            </label>
                                            <vue-select
                                                v-model="form.jc_person_assign"
                                                :options="employee_data"
                                                @select="onSelectEmployee"
                                                placeholder="Select one"
                                                label="text" track-by="text"
                                            ></vue-select>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_exam_type">
                                                Exam Type
                                                <span style="color:red;">*</span>
                                            </label>

                                            <div>
                                                <label class="radio-inline">
                                                    <input
                                                        v-model="form.jc_exam_type"
                                                        type="checkbox" class="lwutpay"
                                                        value="1"
                                                    /> Written
                                                </label>
                                                <label class="radio-inline" style="margin-left: 10px;">
                                                    <input
                                                        v-model="form.jc_exam_type"
                                                        type="checkbox"
                                                        class="lwutpay"
                                                        value="2"
                                                    /> Viva
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_circular_publish_date">
                                                Publish Date
                                                <span style="color:red;">*</span>
                                            </label>
                                            <Datepicker
                                                placeholder="Select Date"
                                                v-model="form.jc_circular_publish_date"
                                                class="form-control"
                                            ></Datepicker>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_circular_expired_date">
                                                Expired Date
                                                <span style="color:red;">*</span>
                                            </label>
                                            <Datepicker
                                                placeholder="Select Date"
                                                style="width: 131% !important;"
                                                v-model="form.jc_circular_expired_date"
                                                class="form-control">
                                            </Datepicker>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="jc_circular_status">
                                                Circular Status
                                                <span style="color:red;">*</span>
                                            </label>
                                            <select v-model="form.jc_circular_status" name="employee_status" class="selectpicker form-control">
                                                <option>--Select--</option>
                                                <option value="1">Publish</option>
                                                <option value="2">Unpublish</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <input type="submit" value="Save" class="btn btn-sm btn-info mr-1" :disabled="isSubmitting">
                                        <button type="button" @click="hideModal" class="btn btn-sm btn-default">
                                            Close
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div v-if="!modal_loading">
                        <PageLoading></PageLoading>
                    </div>
                </modal>
            </div>
        </div>
        <div v-if="!page_loading">
            <PageLoading></PageLoading>
        </div>

        <PageLoading v-if="isSubmitting"></PageLoading>
    </div>
</template>

<script>
import axios from 'axios';
import PageLoading from '../Loading.vue';
import Datepicker from 'vuejs-datepicker';
import { VueEditor } from "vue2-editor";

export default {
    components:{
        VueEditor,
        Datepicker,
        PageLoading,
    },
    data() {
        return {
            form: {
                jc_company_name: '',
                jc_circular_id: '',
                jc_job_position: '',
                jc_job_department: '',
                jc_job_vacancy: '',
                jc_job_description: '',
                jc_job_responsibility: '',
                jc_applied_requirements: '',
                jc_job_requirements: '',
                jc_job_nature: '',
                jc_educational_requirements: '',
                jc_experience_requirements: '',
                jc_job_location: '',
                jc_salary_range: '',
                jc_other_benefits: '',
                jc_exam_type: '',
                jc_exam_type: '',
                jc_circular_publish_date: '',
                jc_circular_expired_date: '',
                jc_circular_status: '',
                jc_person_assign: '',
            },
            employee_data: [],
            designation_data: [],
            department_data: [],
            company_sbu_data: [],
            work_location_data: [],
            editorData: '',
            editorConfig: {},
            isSubmitting: false,
        }
    },
    created(){
        this.getResults(1);
    },
    methods: {
        tableToExcel(table, name){
            if (!table.nodeType) table = this.$refs.table
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            window.location.href = this.uri + this.base64(this.format(this.template, ctx))
        },
        onSelectWorkLocation(option) {
            this.form.jc_job_location= option.id;
        },
        onSelectDepartment(option){
            this.form_data.employee_department= option.id;
        },
        onSelectDesignation(option) {
            axios.post(URL.baseUrl('circular/get-circular'), {id: option.id})
                .then((res) => {
                    this.form.jc_job_description = res.data.job_description;
                    this.form.jc_job_responsibility = res.data.job_responsibility;
                    this.form.jc_applied_requirements = res.data.applied_requirements;
                    this.form.jc_job_requirements = res.data.job_requirements;
                    this.form.jc_other_benefits = res.data.other_benefits;
                });
        },
        onSelectJobGrade(option){
            this.form_data.employee_job_grade= option.id;
        },
        onSelectEmployee(option) {
            this.form.jc_person_assign= option.id;
        },
        formReset() {
            this.form = {
                sbu_name_value: '',
                jc_circular_id: '',
                jc_job_vacancy: '',
                jc_job_description: '',
                jc_job_responsibility: '',
                jc_applied_requirements: '',
                jc_job_requirements: '',
                jc_job_nature: '',
                jc_educational_requirements: '',
                jc_experience_requirements: '',
                jc_salary_range: '',
                jc_other_benefits: '',
                jc_exam_type: '',
                jc_exam_type: '',
                jc_circular_publish_date: '',
                jc_circular_expired_date: '',
                jc_circular_status: '',
                jc_person_assign: ''
            }
        },
        async openAddModal() {
            await axios.get(URL.baseUrl('create/job_circular'))
                .then(({data}) => {
                    this.company_sbu_data = data.company_sbu_data;
                    this.form.jc_company_name = data.sbu_name_value;
                    this.form.jc_circular_id = data.jc_circular_id;

                    this.employee_data = data.employee_data;
                    this.designation_data = data.designation_data;
                    this.department_data = data.department_data;
                    this.work_location_data = data.work_location_data;

                    this.showModal();
                });

        },
        async onSubmit() {
            this.isSubmitting = true;
            await axios.post(URL.baseUrl('add/job_circular'), this.form)
                .then(res => {
                    this.hideModal();
                    this.showToster(res.data);
                    this.getResults(1);
                    this.formReset();
                    this.isSubmitting = false;
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
}
</script>
