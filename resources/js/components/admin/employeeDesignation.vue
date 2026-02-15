<template>
<div>
    <div v-if="page_loading" class="widget box">
        <div class="widget-header">
            <h4><i class="icon-reorder"></i>Employee Designation</h4>

            <div class="toolbar no-padding ">
                <div @click="getModalData($event,{dataUrl:'create/em_designation'}),form_data.status=1"  class="btn-group"> <span class="btn btn-xs btn-info"><i class="icon-plus"></i>Add New</span></div>

                <div class="btn-group"> <span class="btn btn-xs  widget-collapse"><i class="icon-refresh"> </i></span> </div>
                <modal name="myModal" width="677" height="auto" :clickToClose="false">
                    <div v-if="modal_loading">
                        <div class="widget-header">
                            <h4><i class="icon-reorder"></i> Employee Designation Form</h4>
                             <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modify-wraper">
                            <form @submit.prevent="add({add:'add/em_designation'})" class="form-horizontal  row-border" id="validate-1">
                                <div class="pos-form-wraper">
                                    <div v-if="errors" class="alert alert-danger">
                                        <div v-for="(error, index) in errors">
                                            <span v-if="isObject(error)" v-for="err in error">{{err}}</span>
                                            <span v-if="!isObject(error)">{{error}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Designation Code</label>
                                        <div class="col-md-7">
                                            <input v-model="form_data.emloyee_design_code" readonly type="text" class="form-control multiselect__tags required">
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Designation</label>
                                        <div class="col-md-7">
                                            <input v-model="form_data.emp_designation" type="text" class="form-control multiselect__tags required">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-6 control-label">Conpany Name</label>
                                                <div class="col-md-6">
                                                    <select  v-model="form_data.project_id" class="form-control">
                                                            <option v-for="Company in company.data"  :value='Company.id' >{{Company.company_name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-2 control-label">Status</label>
                                                <div class="col-md-6">
                                                <select  v-model="form_data.status"  class="form-control required ">
                                                    <option value='1' selected >Active</option>
                                                    <option value='0' >Inactive</option> 
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <input type="submit"  value="Submit" class="btn btn-primary pull-right">
                                    <button type="button" @click="hideModal" class="btn btn-default pull-right">Close</button>
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
        <div class="widget-content size-table-layout">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                <div class="row">
                    <div class="dataTables_header clearfix">
                        <div class="col-md-6">
                            <div id="DataTables_Table_0_length" class="">
                                <label>
                                    <select class="form-control" @change="onChange($event)" v-model="paginate_num"  name="pageSize">
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
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="dataTables_filter" id="DataTables_Table_0_filter">
                                <label>
                                    <div class="input-group"><span class="input-group-addon"><i class="icon-search"></i></span>
                                        <input v-on:keyup="getResults" v-model="search_input.search_key" type="text" aria-controls="DataTables_Table_0" class="form-control" id="search"  placeholder="Enter keyword...">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="sortable" v-bind:class="getSortingClass('id')" @click="sortingChanged('id')">No.</td>
                             <td class="sortable" v-bind:class="getSortingClass('emloyee_design_code')" @click="sortingChanged('emloyee_design_code')">
                               Designation Code
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('emp_designation')" @click="sortingChanged('emp_designation')">
                               Designation
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('status')" @click="sortingChanged('status')">
                               Status
                            </td>
                            <td class="action">
                                Action
                            </td>
                        </tr>
                    </thead>
                    <tbody v-if="Object.keys(paginate_data.data).length > 0">
                        
                        <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
                            <td>{{index + 1}}</td>
                            <td>  {{form_data.emloyee_design_code }}</td>
                            <td>  {{form_data.emp_designation }}</td>
                            <td class="text-center"> 
                                <samp v-if="form_data.status==1" style="background: #4abad2;padding: 5px;border-radius: 5px;color: #fff;">
                                    {{"Active"}}
                                </samp>
                                <samp v-else style="background: #bd362f;padding: 5px;border-radius: 5px;color: #fff;"> 
                                    inactive
                                </samp>
                            </td>
                            <td class="action">
                                <button @click="getModalData($event,{dataUrl:'edit/em_designation/'+form_data.id})" class="btn-xs btn-info" data-toggle="modal" data-target="#myModal"><i class="icon-edit"></i> Edit</button>
                                <button @click="deleteItem({delUrl:'delete/em_designation/'+form_data.id})" class="btn-xs btn-danger"><i class="icon-trash"></i> Delete</button>
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
                    <div class="dataTables_footer clearfix">
                        <div class="col-md-6">
                            <div class="dataTables_info" id="DataTables_Table_0_info">Showing {{paginate_data.current_page}} of {{paginate_data.last_page}} pages</div>
                        </div>
                        <div class="col-md-6">
                            <div class="dataTables_paginate paging_bootstrap">
                                <pagination :data="paginate_data" @pagination-change-page="getResults"></pagination>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        created(){
            this.getResults(1);
        },
        components:{
            pageLoading:Loading
        },
        data(){
			return {
                company:[],
               
			}
        },
    
        // methods:{
        //     companyData: function companyData() {
        //          var fetchUrl = this.$route.meta.fetchUrl;
        //         var _this = this;

        //         console.log(fetchUrl)
        //         axios.get(URL.baseUrl(fetchUrl)).then(function (res) {
        //             _this.Company_names = res.data['company_name'];
        //             // _this.option_data = res.data;
        //             })["catch"](function (error) {
        //             _this.showToster({
        //             status: 0,
        //             message: 'opps! something went wrong'
        //             });
        //         });
        //     },
        // }   

    }
</script>
