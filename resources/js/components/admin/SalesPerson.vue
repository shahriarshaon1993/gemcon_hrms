<template>
<div>
    <div v-if="page_loading" class="widget box">
        <div class="widget-header">
            <h4><i class="icon-reorder"></i>Sales Person</h4>

            <div class="toolbar no-padding ">
                <div @click="getModalData($event, {dataUrl:'salesPerson/create'})" class="btn-group"> <span class="btn btn-xs btn-info"><i class="icon-plus"></i>Add New</span></div>

                <div class="btn-group"> <span class="btn btn-xs  widget-collapse"><i class="icon-refresh"> </i></span> </div>
                <modal name="myModal" width="650" height="auto" :clickToClose="false">
                    <div v-if="modal_loading">
                        <div class="widget-header">
                            <h4><i class="icon-reorder"></i>Sales Person Form</h4>
                             <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modify-wraper">
                            <form @submit.prevent="add({add:'salesPerson/add'})" class="form-horizontal  row-border" id="validate-1">
                                <div class="pos-form-wraper">
                                    <div v-if="errors" class="alert alert-danger">
                                        <div v-for="(error, index) in errors">
                                            <span v-if="isObject(error)" v-for="err in error">{{err}}</span>
                                            <span v-if="!isObject(error)">{{error}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Salesperson #</label>
                                        <div class="col-md-3">
                                            <input v-model="form_data.number" type="text" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-6">
                                            <input v-model="form_data.name" type="text" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">User Name</label>
                                        <div class="col-md-6">
                                            <input v-model="form_data.username" type="text" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Password</label>
                                        <div class="col-md-6">
                                            <input v-model="form_data.password" type="password" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Address</label>
                                        <div class="col-md-6">
                                            <input v-model="form_data.address_line_1" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-6">
                                            <input v-model="form_data.address_line_2" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-6 control-label">Phone</label>
                                                <div class="col-md-6">
                                                    <input v-model="form_data.phone" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-4 control-label">Email</label>
                                                <div class="col-md-8">
                                                    <input v-model="form_data.email" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Social Security #</label>
                                        <div class="col-md-3">
                                            <input v-model="form_data.ssn" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-6 control-label">Commission%</label>
                                                <div class="col-md-6">
                                                    <input v-model="form_data.commission_percentage" type="text" class="form-control required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-5 control-label">Commission On</label>
                                                <div class="col-md-7">
                                                    <select name="commission_on" id="commission_on" class="form-control" v-model="form_data.commission_on" style="height: 22px">
                                                        <option value="profit">PROFIT</option>
                                                        <option value="gross">GROSS</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-7 paddingZero">
                                            <div class="salesman-table">
                                                <h5>Salesperson Totals</h5>
                                                <div class="col-md-12">
                                                    <div class="table-border sales-person">
                                                        <table width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center"></th>
                                                                    <th class="text-center">Daily</th>
                                                                    <th class="text-center">Monthly</th>
                                                                    <th class="text-center">Year To Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Total Sales</td>
                                                                    <td v-if="form_data.id" class="text-right">{{form_data.total_sales_1}}</td>
                                                                    <td v-else class="text-right">$0.00</td>
                                                                    <td v-if="form_data.id" class="text-right">{{form_data.total_sales_2}}</td>
                                                                    <td v-else class="text-right">$0.00</td>
                                                                    <td v-if="form_data.id" class="text-right">{{form_data.total_sales_3}}</td>
                                                                    <td v-else class="text-right">$0.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Commission  </td>
                                                                    <td v-if="form_data.id" class="text-right">{{form_data.commission_earned_1}}</td>
                                                                    <td v-else class="text-right">$0.00</td>
                                                                    <td v-if="form_data.id" class="text-right">{{form_data.commission_earned_2}}</td>
                                                                    <td v-else class="text-right">$0.00</td>
                                                                    <td v-if="form_data.id" class="text-right">{{form_data.commission_earned_3}}</td>
                                                                    <td v-else class="text-right">$0.00</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 paddingZero">
                                            <label class="col-md-12 control-label" style="text-align: left;">Comments</span></label>
                                            <div class="col-md-12 city-field">
                                                <textarea v-model="form_data.comments" type="text" class="form-control required textarea-height-set" placeholder="Comments"></textarea>
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
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
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
                            <td class="sortable" v-bind:class="getSortingClass('number')" @click="sortingChanged('number')">
                                Number
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('name')" @click="sortingChanged('name')">
                                Name
                            </td>

                            <td class="sortable" v-bind:class="getSortingClass('username')" @click="sortingChanged('username')">
                                username
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('commission_percentage')" @click="sortingChanged('commission_percentage')">
                                Commission(%)
                            </td>
                            <td class="action">
                                Action
                            </td>
                        </tr>
                    </thead>
                    <tbody v-if="Object.keys(paginate_data.data).length > 0">
                        <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
                            <td>{{index + 1}}</td>
                            <td>{{form_data.number}}</td>
                            <td>{{form_data.name}}</td>
                            <td>{{form_data.username}}</td>
                            <td>{{form_data.commission_percentage}}</td>
                            <td class="action">
                                <button @click="getModalData($event,{dataUrl:'salesPerson/edit/'+form_data.id})" class="btn-xs btn-info" data-toggle="modal" data-target="#myModal"><i class="icon-edit"></i> Edit</button>
                                <button @click="deleteItem({delUrl:'salesPerson/delete/'+form_data.id})" class="btn-xs btn-danger"><i class="icon-trash"></i> Delete</button>
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
        }

    }
</script>
