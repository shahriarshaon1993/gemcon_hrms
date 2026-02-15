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
                                                    <h3 class="card-title d-none d-md-block">Peoples</h3>
                                                    <span class="float-sm-right" style="float: right;">

                            <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                          </span>
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
                                                            <input
                                                                v-on:keyup="getResults"
                                                                v-model="search_input.search_key"
                                                                type="text" aria-controls="DataTables_Table_0"
                                                                class="form-control search-keyword" id="search"
                                                                placeholder="Search..." style="border-radius: 0px;"
                                                            >
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>

                                            <table ref="table" id="loremTable" summary="lorem ipsum sit amet" rules="groups" frame="hsides"  class="table table-bordered table-striped employeeTable">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">SL</th>
                                                    <th class="text-center" v-bind:class="getSortingClass('name')" @click="sortingChanged('name')">Name<i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('email')" @click="sortingChanged('email')">Email <i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('phone')" @click="sortingChanged('phone')">Phone <i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('department_id')" @click="sortingChanged('department_id')">Department <i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('experience_level')" @click="sortingChanged('experience_level')">Experience <i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('cv')" @click="sortingChanged('cv')">CV <i class="fas fa-sort"></i></th>
                                                    <th class="text-center" v-bind:class="getSortingClass('cv')" @click="sortingChanged('cv')">Action <i class="fas fa-sort"></i></th>
                                                </tr>
                                                </thead>
                                                <tbody v-if="Object.keys(paginate_data.data).length > 0">
                                                <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
                                                    <td class="text-center">{{index+1}}</td>
                                                    <td>{{form_data.name}}</td>
                                                    <td>{{form_data.email}}</td>
                                                    <td class="text-center">{{form_data.phone}}</td>
                                                    <td class="text-center">{{form_data.department.department_name}}</td>
                                                    <td class="text-center">{{form_data.experience_level}}</td>
                                                    <td class="text-center">
                                                        <a class="btn btn-sm btn-info" target="_blank" :href="form_data.cv">
                                                            <i class="fa fa-download text-white"></i>
                                                        </a>
                                                    </td>

                                                    <td class="text-center" style="padding: 5px 5px">
                                                        <button
                                                            v-if="lists.edit=='edit'"
                                                            class="btn btn-primary btn-sm"
                                                            title="Sending Mail"
                                                            @click="mailSend(form_data.id)"
                                                        >
                                                            <div
                                                                v-if="isMailingId === form_data.id"
                                                                class="spinner-border text-white"
                                                                role="status" style="width: 16px; height: 16px;"
                                                            >
                                                                <span class="sr-only">Loading...</span>
                                                            </div>

                                                            <i v-else class="fa fa-envelope"></i>
                                                        </button>

                                                        <button
                                                            v-if="lists.delete=='delete'"
                                                            @click="deleteItem({delUrl:'delete/talents/'+form_data.id})"
                                                            title="Delete"
                                                            class="btn btn-danger btn-sm"
                                                        >
                                                            <i class="fa fa-trash"></i>
                                                        </button>
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
            </div>
        </div>
        <div v-if="!page_loading">
            <PageLoading></PageLoading>
        </div>
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
            isMailingId: null,
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
        formReset() {},
        async openAddModal() {
            await axios.get(URL.baseUrl('create/job_circular'))
                .then(({data}) => {
                    this.company_sbu_data = data.company_sbu_data;
                    this.form.jc_company_name = data.sbu_name_value;
                    this.form.jc_circular_id = data.jc_circular_id;

                    this.employee_data = data.employee_data;
                    this.designation_data = data.designation_data;
                    this.work_location_data = data.work_location_data;

                    this.showModal();
                });

        },
        async onSubmit() {
            await axios.post(URL.baseUrl('add/job_circular'), this.form)
                .then(res => {
                    this.hideModal();
                    this.showToster(res.data);
                    this.getResults(1);
                    this.formReset();
                })
                .catch(error => {
                    console.error(error);
                });
        },
        async mailSend(id) {
            this.isMailingId = id;

            await axios.post(URL.baseUrl(`talent/send-mail/${id}`))
                .then(res => {
                    this.showToster(res.data);
                    this.isMailingId = null;
                })
                .catch(error => {
                    console.error(error);
                })
                .finally(() => {
                    this.isMailingId = null;
                })

        }
    }
}
</script>
