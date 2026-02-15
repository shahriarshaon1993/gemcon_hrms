<template>
<div>
    <div v-if="page_loading" class="widget box">
        <div class="widget-header">
            <h4><i class="icon-reorder"></i>Menu</h4>

            
            <div class="toolbar no-padding ">
                <div @click="getModalData($event,{dataUrl:'create/menu'})" class="btn-group"> <span class="btn btn-xs btn-info"><i class="icon-plus"></i> Add New</span> </div>


                <div class="btn-group" @click="reload"> <span class="btn btn-xs"><i class="icon-refresh"> </i></span> </div>
                <modal name="myModal" width="550" height="auto" :clickToClose="false">
                    <div v-if="modal_loading">
                        <div class="widget-header">
                            <h4><i class="icon-reorder"></i>Menu</h4>
                             <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modify-wraper">
                                <form class="form-horizontal  row-border" id="validate-1">
                                    <div class="my-form-wraper">
                                        <div v-if="errors" class="alert alert-danger">
                                            <div v-for="(error, index) in errors">
                                                <span v-if="isObject(error)" v-for="err in error">{{err}}</span>
                                                <span v-if="!isObject(error)">{{error}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Order No<span class="required">*</span></label>
                                            <div class="col-md-9" :class="{ 'has-error': $v.form_data.order_no.$error }">
                                                {{$v.form_data.order_no.$touch()}}
                                                <input v-model="form_data.order_no" type="text" class="form-control required">
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Menu<span class="required">*</span></label>
                                            <div class="col-md-9" :class="{ 'has-error': $v.form_data.menu_name.$error }">
                                                {{$v.form_data.menu_name.$touch()}}
                                                <input v-model="form_data.menu_name" type="text" class="form-control required" placeholder="Menu Name">
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Uid<span class="required">*</span></label>
                                            <div class="col-md-9" :class="{ 'has-error': $v.form_data.uid.$error }">
                                                {{$v.form_data.uid.$touch()}}
                                                <input v-model="form_data.uid" type="text" class="form-control required" placeholder="Uid">
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Menu Link<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input v-model="form_data.menu_link" type="text" class="form-control required" placeholder="Menu Link">
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Parent</label>
                                            <div class="col-md-9">
                                                <select v-model="form_data.parent_id" class="form-control">
                                                    <option value='0'>No Parent</option>
                                                    <option v-for='parent in form_data.parents' :value="parent.id">{{parent.menu_name}} - {{parent.type_name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Menu Icone <span class="required">*</span></label>
                                            <div class="col-md-9" :class="{ 'has-error': $v.form_data.menu_icon.$error }">
                                                {{$v.form_data.menu_icon.$touch()}}
                                                <input v-model="form_data.menu_icon"  type="text" class="form-control required" placeholder="Menu Icone">
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Panel Type<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <select v-model="form_data.panel_type" v-on:input="$v.form_data.panel_type.$touch" class="form-control">
                                                    <option disabled>Select Panel</option>
                                                    <option v-for='panel in option_data.panels' :value='panel.id'>{{panel.type_name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Has Child<span class="required">*</span></label>
                                            <div class="col-md-9">

                                                <label><input type="radio" v-model="form_data.has_child" value="1">Yes</label>
                                                <label><input type="radio" v-model="form_data.has_child" value="0">No</label>
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Status<span class="required">*</span></label>
                                            <div class="col-md-9">

                                                <label><input type="radio" name="status" v-model="form_data.status" value="1">Active</label>
                                                <label><input type="radio" v-model="form_data.status" name="status" value="0">Inactive</label>
                                            </div>
                                        </div>
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Menu Topbar<span class="required">*</span></label>
                                            <div class="col-md-9">

                                                <label><input type="radio" v-model="form_data.is_top_bar" value="1">Yes</label>
                                                <label><input type="radio" v-model="form_data.is_top_bar" value="0">No</label>
                                            </div>
                                        </div>
                                        <p style="margin-top: 6px;margin-bottom: 0"><b>Internal menu link</b></p>
                                        <div class="overflow">
                                            <table class="responsive table table-striped table-bordered m-b-0" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="addRowPading">Order</th>
                                                        <th class="addRowPading">Link Name</th>
                                                        <th class="addRowPading">Uid</th>
                                                        <th class="text-center addRowPading" width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-if='form_data.id' v-for="(row,index) in form_data.add_row">
                                                        <td class="text-center addRowPading" valign="middle">
                                                            <input type="text" style="height: 23px" name="order_no" class="form-control ng-pristine ng-untouched ng-valid ng-empty" v-model="row.order_no" autocomplete="off" placeholder="Order">   
                                                        </td>
                                                         <td class="text-center addRowPading" valign="middle">
                                                            <input type="text" style="height: 23px" name="order_no" class="form-control ng-pristine ng-untouched ng-valid ng-empty" v-model="row.link_name" autocomplete="off" placeholder="Link Name">   
                                                        </td>
                                                        <td class="text-center addRowPading" valign="middle">
                                                            <input type="text" style="height: 23px" name="order_no" class="form-control ng-pristine ng-untouched ng-valid ng-empty" v-model="row.link_uid" autocomplete="off" placeholder="Uid">   
                                                        </td>
                                                        
                                                        <td class="text-center addRowPading">
                                                            <button @click="internalGridAdd($event)" v-if='(index === form_data.add_row.length - 1)' class="btn btn-info btn-xs "><i style="margin-top: 4px" class="fa fa-plus"></i></button>

                                                            <button v-else @click="internalGridRemove($event,row)" class="btn btn-danger btn-xs "><i style="margin-top: 4px" class="fa fa-times"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="!form_data.id" v-for="(row,index) in form_data.add_row">
                                                        <td class="text-center addRowPading" valign="middle">
                                                            <input type="text" style="height: 23px" name="order_no" class="form-control ng-pristine ng-untouched ng-valid ng-empty" v-model="row.order_no" autocomplete="off" placeholder="Order">   
                                                        </td>
                                                         <td class="text-center addRowPading" valign="middle">
                                                            <input type="text" style="height: 23px" name="order_no" class="form-control ng-pristine ng-untouched ng-valid ng-empty" v-model="row.link_name" autocomplete="off" placeholder="Link Name">   
                                                        </td>
                                                        <td class="text-center addRowPading" valign="middle">
                                                            <input type="text" style="height: 23px" name="order_no" class="form-control ng-pristine ng-untouched ng-valid ng-empty" v-model="row.link_uid" autocomplete="off" placeholder="Uid">   
                                                        </td>
                                                        
                                                        <td class="text-center addRowPading">
                                                            <button @click="internalGridAdd($event)" v-if='(index === form_data.add_row.length - 1)' class="btn btn-info btn-xs "><i style="margin-top: 4px" class="fa fa-plus"></i></button>

                                                            <button v-else @click="internalGridRemove($event,row)" class="btn btn-danger btn-xs "><i style="margin-top: 4px" class="fa fa-times"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                        <div class="form-actions">
                                            <button type="button" @click="add({add:'add/menu'})" :disabled="isComplete" class="btn btn-primary pull-right">Submit</button>
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
                        <div class="col-md-4">
                            <div id="DataTables_Table_0_length" class="">
                                <label>
                                    <select class="form-control" @change="onChange($event)" v-model="paginate_num"  name="pageSize">
                                        <option value="2">10</option>
                                        <option value="3">25</option>
                                        <option value="5">50</option>
                                        <option value="10">100</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="selected-panel">
                                        <label>Select Panel</label>
                                        <select v-model="search_input.selected_panel" @change="getResults" class="form-control">
                                            <option v-if="!search_input.selected_panel" :value="search_input.selected_panel">--All--</option>
                                            <option v-else>--All--</option>
                                            <option v-for='panel in lists.panels' :value='panel.id'>{{panel.type_name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
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
                    </div>
                </div>

                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td class="sortable" v-bind:class="getSortingClass('menu_name')" @click="sortingChanged('menu_name')">
                                Menu Name
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('panel_type')" @click="sortingChanged('panel_type')">
                                Panel Type
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('uid')" @click="sortingChanged('uid')">
                                Uid
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('order_no')" @click="sortingChanged('order_no')">
                                Order No
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('menu_link')" @click="sortingChanged('menu_link')">
                                Menu Link
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('has_child')" @click="sortingChanged('has_child')">
                                Has Child
                            </td>
                            <td>
                                Internal Link
                            </td>
                            <td class="sortable status" v-bind:class="getSortingClass('status')" @click="sortingChanged('status')">Status</td>
                            <td class="action" width="16%">
                                Action
                            </td>
                        </tr>
                    </thead>
                    <tbody v-if="Object.keys(paginate_data.data).length > 0">
                        <tr v-for="(list, index) in paginate_data.data" v-bind:key="index">
                            <td>{{order_no + index + 1}}</td>
                            <td>{{list.menu_name}}</td>
                            <td>{{list.type_name}}</td>
                            <td>{{list.uid}}</td>
                            <td>{{list.order_no}}</td>
                            <td>{{list.menu_link}}</td>
                            <td v-if="list.has_child==1">Yes</td>
                            <td v-else>No</td>
                            <td>
                                <b v-for="(link,index) in lists.internal_link[list.id]" v-bind:key="index">
                                    {{link.link_name}} 
                                </b>
                            </td>
                            <td v-if="list.status==1" class="status">
                                <span class="label label-success">Active</span>
                            </td>
                            <td v-else class="status"><span class="label label-danger">Inactive</span></td>
                            <td class="action">
                                <button @click="getModalData($event,{dataUrl:'edit/menu/'+list.id})" class="btn-info btn-xs" title="" data-original-title="Edit" data-toggle="modal" data-target="#myModal"><i class="icon-edit"></i> Edit</button>
                                <button @click="deleteItem({delUrl:'delete/menu/'+list.id})" class="btn-xs btn-danger" title="" data-original-title="Delete"><i class="icon-trash"></i> Delete</button>
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

    export default {
        created(){
            this.getResults(1);
        },
        validations: {
            form_data: {
              order_no: { required },
              menu_name:{required},
              uid:{required},
              menu_icon:{required},
              panel_type:{required}
            }
        },
        methods: {
            myChangeEvent(val){
                console.log(val);
            },
            mySelectEvent({id, text}){
                console.log({id, text})
            },
            internalGridAdd(event){
                event.preventDefault();
                this.form_data.add_row.push({id:0,order_no:'',link_name:'',link_uid:''});
            },
            internalGridRemove(event, item){
                event.preventDefault();
                let index = this.form_data.add_row.indexOf(item);
                this.form_data.add_row.splice(index, 1);
            }
        }
    }
    
</script>