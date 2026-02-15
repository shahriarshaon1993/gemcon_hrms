<template>
    <div>
        <div style="margin: 127px 155px" v-if="page_loading" class="widget box" >
            <div class="widget-header">
                <h4><i class="icon-reorder"></i>Email Configuration</h4>
                <div class="toolbar no-padding ">
                    <div @click="getModalData($event,{dataUrl:'create'})" class="btn-group"> <span class="btn btn-xs btn-info"><i class="icon-plus"></i>Add New</span> </div>
    
                    <div class="btn-group" @click="reload"> <span class="btn btn-xs"><i class="icon-refresh"> </i></span> </div>
                    <modal name="myModal" width="550" height="auto" :clickToClose="false">
                        <div v-if="modal_loading">
                            <div class="widget-header">
                                <h4><i class="icon-reorder"></i>Cofiguration</h4>
                                 <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modify-wraper">
                                    <form @submit.prevent="add({add:'email_configuration/add'})" class="form-horizontal  row-border" id="validate-1">
                                        <div class="my-form-wraper">
                                            <div v-if="errors" class="alert alert-danger">
                                                <div v-for="(error, index) in errors">
                                                    <span v-if="isObject(error)" v-for="err in error">{{err}}</span>
                                                    <span v-if="!isObject(error)">{{error}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group modify-input">
                                                <label class="col-md-3 control-label">Email Driver <span class="required">*</span></label>
                                                <div class="col-md-9" :class="{ 'has-error': $v.form_data.mail_driver.$error }">
                                                    {{$v.form_data.mail_driver.$touch()}}
                                                    <input v-model="form_data.mail_driver" type="text" class="form-control required" placeholder="Email Driver">
                                                </div>
                                            </div>
                                             <div class="form-group modify-input">
                                                <label class="col-md-3 control-label">Mail Host<span class="required">*</span></label>
                                                <div class="col-md-9" :class="{ 'has-error': $v.form_data.mail_host.$error }">
                                                    {{$v.form_data.mail_host.$touch()}}
                                                    <input v-model="form_data.mail_host" type="text" class="form-control required" placeholder="Mail Host">
                                                </div>
                                            </div>
                                            <div class="form-group modify-input">
                                                <label class="col-md-3 control-label">Mail Port <span class="required">*</span></label>
                                                <div class="col-md-9" :class="{ 'has-error': $v.form_data.mail_port.$error }">
                                                    {{$v.form_data.mail_port.$touch()}}
                                                    <input ref="input" v-model="form_data.mail_port"  type="text" class="form-control required" placeholder="Mail Port">
                                                </div>
                                            </div>
                                            <div class="form-group modify-input">
                                                <label class="col-md-3 control-label">Mail Username <span class="required">*</span></label>
                                                <div class="col-md-9" :class="{ 'has-error': $v.form_data.mail_username.$error }">
                                                    {{$v.form_data.mail_username.$touch()}}
                                                    <input ref="input" v-model="form_data.mail_username"  type="text" class="form-control required" placeholder="Mail Username">
                                                </div>
                                            </div>
                                            <div class="form-group modify-input">
                                                <label class="col-md-3 control-label">Mail Password <span class="required">*</span></label>
                                                <div class="col-md-9" :class="{ 'has-error': $v.form_data.mail_password.$error }">
                                                    {{$v.form_data.mail_password.$touch()}}
                                                    <input ref="input" v-model="form_data.mail_password"  type="text" class="form-control required" placeholder="Mail Password">
                                                </div>
                                            </div>
                                            <div class="form-group modify-input">
                                                <label class="col-md-3 control-label">Mail Encryption<span class="required">*</span></label>
                                                <div class="col-md-9" :class="{ 'has-error': $v.form_data.mail_encryption.$error }">
                                                    {{$v.form_data.mail_encryption.$touch()}}
                                                    <input ref="input" v-model="form_data.mail_encryption"  type="text" class="form-control required" placeholder="Mail Encryption">
                                                </div>
                                            </div>
                                            <div class="form-group modify-input">
                                                <label class="col-md-3 control-label">Mail From Name <span class="required">*</span></label>
                                                <div class="col-md-9" :class="{ 'has-error': $v.form_data.mail_from_name.$error }">
                                                    {{$v.form_data.mail_from_name.$touch()}}
                                                    <input ref="input" v-model="form_data.mail_from_name"  type="text" class="form-control required" placeholder="Mail From Name">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group modify-input">
                                                <label class="col-md-3 control-label">Status<span class="required">*</span></label>
                                                <div class="col-md-9">
                                                    <label><input type="radio" name="status" v-model="form_data.status" value="1">Active</label>
                                                    <label><input type="radio" v-model="form_data.status" name="status" value="0">Inactive</label>
                                                </div>
                                            </div>
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
                        <div class="widget-header">
                                <h4><i class="icon-reorder"></i>Cofiguration</h4>
                                 <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modify-wraper">
                                <form @submit.prevent="add({add:'email_configuration/add'})" class="form-horizontal  row-border" id="validate-1">
                                    <div class="my-form-wraper">
                                        <div v-if="errors" class="alert alert-danger">
                                            <div v-for="(error, index) in errors">
                                                <span v-if="isObject(error)" v-for="err in error">{{err}}</span>
                                                <span v-if="!isObject(error)">{{error}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Email Driver <span class="required">*</span></label>
                                            <div class="col-md-9" :class="{ 'has-error': $v.form_data.mail_driver.$error }">
                                                {{$v.form_data.mail_driver.$touch()}}
                                                <input v-model="form_data.mail_driver" type="text" class="form-control required" placeholder="Email Driver">
                                            </div>
                                        </div>
                                            <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Mail Host<span class="required">*</span></label>
                                            <div class="col-md-9" :class="{ 'has-error': $v.form_data.mail_host.$error }">
                                                {{$v.form_data.mail_host.$touch()}}
                                                <input v-model="form_data.mail_host" type="text" class="form-control required" placeholder="Mail Host">
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Mail Port <span class="required">*</span></label>
                                            <div class="col-md-9" :class="{ 'has-error': $v.form_data.mail_port.$error }">
                                                {{$v.form_data.mail_port.$touch()}}
                                                <input ref="input" v-model="form_data.mail_port"  type="text" class="form-control required" placeholder="Mail Port">
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Mail Username <span class="required">*</span></label>
                                            <div class="col-md-9" :class="{ 'has-error': $v.form_data.mail_username.$error }">
                                                {{$v.form_data.mail_username.$touch()}}
                                                <input ref="input" v-model="form_data.mail_username"  type="text" class="form-control required" placeholder="Mail Username">
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Mail Password <span class="required">*</span></label>
                                            <div class="col-md-9" :class="{ 'has-error': $v.form_data.mail_password.$error }">
                                                {{$v.form_data.mail_password.$touch()}}
                                                <input ref="input" v-model="form_data.mail_password"  type="text" class="form-control required" placeholder="Mail Password">
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Mail Encryption<span class="required">*</span></label>
                                            <div class="col-md-9" :class="{ 'has-error': $v.form_data.mail_encryption.$error }">
                                                {{$v.form_data.mail_encryption.$touch()}}
                                                <input ref="input" v-model="form_data.mail_encryption"  type="text" class="form-control required" placeholder="Mail Encryption">
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Mail From Name <span class="required">*</span></label>
                                            <div class="col-md-9" :class="{ 'has-error': $v.form_data.mail_from_name.$error }">
                                                {{$v.form_data.mail_from_name.$touch()}}
                                                <input ref="input" v-model="form_data.mail_from_name"  type="text" class="form-control required" placeholder="Mail From Name">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Status<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <label><input type="radio" name="status" v-model="form_data.status" value="1">Active</label>
                                                <label><input type="radio" v-model="form_data.status" name="status" value="0">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="form-actions">
                                            <input type="submit" :disabled="isComplete" value="Submit" class="btn btn-primary pull-right">
                                            <button type="button" @click="hideModal" class="btn btn-default pull-right">Close</button>
                                        </div>
                                </form>
                        </div>










                        <!-- <div class="dataTables_header clearfix">
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
                        </div> -->
                    </div>
    
                    <!-- <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td>No.</td>
                                <td class="sortable" v-bind:class="getSortingClass('name')" @click="sortingChanged('name')">
                                    Name
                                </td>
                                <td class="sortable" v-bind:class="getSortingClass('email')" @click="sortingChanged('email')">
                                    Email
                                    <i   aria-hidden="true"></i>
                                </td>
                                <td class="sortable" v-bind:class="getSortingClass('username')" @click="sortingChanged('username')">
                                    Username
                                    <i   aria-hidden="true"></i>
                                </td>
                                <td class="sortable status" v-bind:class="getSortingClass('status')" @click="sortingChanged('status')">
                                    Status
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
                                <td>{{form_data.email}}</td>
                                <td>{{form_data.username}}</td>
                                <td style="width: 10%" v-if="form_data.status==1" class="status">
                                    <span class="label label-success">Active</span>
                                </td>
                                <td style="width: 10%;" v-else class="status"><span class="label label-danger">Inactive</span></td>
                                <td style="width: 20%;" class="action">
                                    <button @click="getModalData($event,{dataUrl:'edit/'+form_data.id})" class="btn-xs btn-info" title="" data-original-title="Edit" data-toggle="modal" data-target="#myModal"><i class="icon-edit"></i> Edit</button>
                                    <button @click="deleteItem({delUrl:'delete/'+form_data.id})" class="btn-xs btn-danger" title="" data-original-title="Delete"><i class="icon-trash"></i> Delete</button>
                                </td>
                            </tr>   
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="5" align="center">No data in database</td>
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
                                    <pagination :data="paginate_data" :limit="2" @pagination-change-page="getResults"></pagination>
                                </div>
                            </div>
                        </div>
                    </div> -->
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
    
        export default {
            validations() {
                if (this.form_data.id) {
                    return {
                        form_data: {
                          name: { required },
                          email: { required, email },
                          username:{required}
                        }
                    }
                } else {
                    return {
                        form_data: {
                          name: { required },
                          email: { required, email },
                          password:{ required, min: minLength(6) },
                          username:{required}
                        }
                    }
                }
    
            },
            created(){
                this.getResults(1);
            },
            mounted(){
                this.$nextTick(() => {
                  console.log(this.$refs.email);
                  console.log("hellow");
                });
            }
            
        }
    </script>
    