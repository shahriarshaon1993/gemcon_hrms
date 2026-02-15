<template>
<div>
    <div v-if="page_loading" class="widget box">
        <div class="widget-header">
            <h4><i class="icon-reorder"></i> Payment Type</h4>
            
            <div class="toolbar no-padding ">
                <div @click="getModalData($event,{dataUrl:'payment_mode/create'})" class="btn-group"> <span class="btn btn-xs btn-info"><i class="icon-plus"></i>Add New</span></div>
                        
                <div class="btn-group"> <span class="btn btn-xs  widget-collapse"><i class="icon-refresh"> </i></span> </div>
                <modal name="myModal" width="660" height="auto" :clickToClose="false">
                    <div v-if="modal_loading">
                        <div class="widget-header">
                            <h4><i class="icon-reorder"></i>Modal Forms</h4>
                             <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modify-wraper">
                            <form @submit.prevent="add({add:'payment_mode/add'})" class="form-horizontal  row-border" id="validate-1">
                                <div class="my-form-wraper">
                                    <div v-if="errors" class="alert alert-danger">
                                        <div v-for="(error, index) in errors">
                                            <span v-if="isObject(error)" v-for="err in error">{{err}}</span>
                                            <span v-if="!isObject(error)">{{error}}</span>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Name<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.name.$error }">
                                            {{$v.form_data.name.$touch()}}
                                            <input v-model="form_data.name" type="text" class="form-control required">
                                        </div>
                                    </div>
                                     <!-- <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Account Number<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.name.$error }">
                                            {{$v.form_data.name.$touch()}}
                                            <input v-model="form_data.number" type="text" class="form-control required">
                                        </div>
                                    </div> -->
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Ledger Account Head<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.name.$error }">
                                            {{$v.form_data.name.$touch()}}
                                            <input v-model="form_data.ledger_account_head" type="text" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Company Name<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.name.$error }">
                                            {{$v.form_data.name.$touch()}}
                                            <select  v-model="form_data.project_id"  class="form-control">
                                                <option v-for="Company in form_data['CompanyList']"  :value='Company.id' >{{Company.company_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Branch Name<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.name.$error }">
                                            {{$v.form_data.name.$touch()}}
                                            <select  v-model="form_data.branch_id"  class="form-control">
                                                <option v-for="Branch in form_data['BranchList']"  :value='Branch.id' >{{Branch.branch_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                 
                                    <!-- <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Status<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.name.$error }">
                                            {{$v.form_data.name.$touch()}}
                                            <select  v-model="form_data.status"  class="form-control">
                                                <option value='1' > Active</option>
                                                <option value='0' > Inactive</option>
                                            </select>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="form-actions">
                                    <input type="submit" :disabled="isComplete" value="Submit" class="btn btn-primary pull-right">
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
                            <td class="sortable" v-bind:class="getSortingClass('name')" @click="sortingChanged('name')">
                                Name
                            </td>
                            <!-- <td class="sortable" v-bind:class="getSortingClass('email')" @click="sortingChanged('email')">
                                Email
                            </td>-->
                            <td class="sortable" v-bind:class="getSortingClass('ledger_account_head')" @click="sortingChanged('ledger_account_head')">
                                Ledger Account Head
                            </td> 
                            <td class="action">
                                Action
                            </td>
                        </tr>
                    </thead>
                    <tbody v-if="Object.keys(paginate_data.data).length > 0">
                        <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
                            <td>{{order_no + index + 1}}</td>
                            <td>{{form_data.name}}</td>
                             <td>{{form_data.ledger_account_head}}</td>
                            <!-- <td>{{form_data.account_number}}</td> -->
                            <!-- <td> <samp v-if="form_data.status==1" > Active </samp>   <samp v-else> Inactive </samp> </td> -->
                            <td style="width: 20%" class="action">
                                <button @click="getModalData($event,{dataUrl:'payment_mode/edit/'+form_data.id})" class="btn-xs btn-info" data-toggle="modal" data-target="#myModal"><i class="icon-edit"></i> Edit</button>
                                <button @click="deleteItem({delUrl:'payment_mode/delete/'+form_data.id})" class="btn-xs btn-danger"><i class="icon-trash"></i> Delete</button>
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
    import { required, email, minLength } from "vuelidate/lib/validators";
    import Loading from '../Loading.vue';

    export default {

        created(){
            this.getResults(1);
        },

        validations() {
            if (this.form_data.id) {
                return {
                    form_data: {
                      name: { required },
                    //   number: { required },
                    //   username:{required}
                    }
                }
            } else {
                return {
                    form_data: {
                      name: { required },
                    //   number: { required },
                    //   password:{ required, min: minLength(6) },
                    //   username:{required}
                    }
                }
            }

        },

        components:{
            pageLoading:Loading
        },

        methods: {
            branch_list(event) {
                // console.log(event.target.value)
            // axios.post(URL.baseUrl(addUrl.add),
            //     {
            //         Branch_list:this.productionsData,
            //     }).then(res => {
            //     console.log(res)
            //         if(res.data.status==1){
            //             this.errors =null;
            //             this.showToster(res.data);
            //         }    
            //     })
            //     .catch(error => {
            //         var msg = 'opps! something went wrong';
            //         this.showToster({status:0,message:msg});
            //     });
                console.log(event.target.value)
            }
        }

        
        

    }
</script>
