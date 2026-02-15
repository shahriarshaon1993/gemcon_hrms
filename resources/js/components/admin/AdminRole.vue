<template>
<div>
    <div v-if="page_loading" class="widget box">
        <div class="widget-header">
            <h4><i class="icon-reorder"></i>Admin Role</h4>

            <div class="toolbar no-padding ">
                <div @click="getModalData($event,{dataUrl:'create/adminrole'})" class="btn-group"> <span class="btn btn-xs btn-info"><i class="icon-plus"></i>Add New</span> </div>


                <div class="btn-group" @click="reload"> <span class="btn btn-xs"><i class="icon-refresh"> </i></span> </div>
                <modal name="myModal"  transition="scale" width="550" height="auto" :clickToClose="false">
                    <div v-if="modal_loading">
                        <div class="widget-header">
                            <h4><i class="icon-reorder"></i>Admin Role</h4>
                             <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modify-wraper">
                            <form @submit.prevent="add({add:'add/adminrole'})" class="form-horizontal  row-border" id="validate-1">
                                <div class="my-form-wraper">
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Role<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.role_name.$error }">
                                            {{$v.form_data.role_name.$touch()}}
                                            <input v-model="form_data.role_name" type="text" class="form-control required" placeholder="Role Name">
                                        </div>
                                    </div>
                                    <div class="role-wraper">
                                        <div class="widget-header">
                                            <h4>
                                                <label class="checkbox-inline" >
                                                    <input true-value="1" false-value="0" type="checkbox" @change="masterCheck" v-model="masterselect">Admin Panel
                                                </label>
                                            </h4>
                                        </div>
                                        <div class="widget-content">
                                            <table v-for="list  in option_data.menu_list"  class="responsive table table-striped table-bordered m-b-0" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox-inline" >
                                                                <input type="checkbox" v-model="form_data.access" true-value="1" :value="list.id+'-'+'0'"  @change="allowAll(list)" false-value="0">{{list.menu_name}}
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="option_data.internal_link[list.id]">
                                                        <td>
                                                            <label class="checkbox-inline" >
                                                                <input type="checkbox" true-value="1" false-value="0" v-model="form_data.selectAll" :value="list.id"  @change="checkSelectAll(list)">Select All
                                                            </label>
                                                            <hr>
                                                            <label v-for="(link_internal in option_data.internal_link[list.id]" class="checkbox-inline" >
                                                                <input type="checkbox" true-value="1" false-value="0" v-model="form_data.access" @change="allowParent(list,'','',option_data.internal_link[list.id])" :value="list.id+'-'+link_internal.id">{{link_internal.link_name}}
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="list.children">
                                                        <td style="padding-left: 10px;">
                                                            <table v-for="sub in list.children" class="responsive table table-striped table-bordered m-b-0" cellspacing="0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <label class="checkbox-inline" >
                                                                                <input type="checkbox" v-model="form_data.access" :value="sub.id+'-'+'0'"  @change="allowAll(sub,list)">{{sub.menu_name}}
                                                                            </label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr v-if="option_data.internal_link[sub.id]">
                                                                        <td>
                                                                            <label class="checkbox-inline" ><input type="checkbox" true-value="1" false-value="0" v-model="form_data.selectAll" :value="sub.id"  @change="checkSelectAll(sub,list)">Select All</label>
                                                                            <hr>

                                                                            <label v-for="(link_internal in option_data.internal_link[sub.id]" class="checkbox-inline" >
                                                                                <input type="checkbox" v-model="form_data.access" @change="allowParent(list,sub,'',option_data.internal_link[sub.id])" :value="sub.id+'-'+link_internal.id">{{link_internal.link_name}}
                                                                            </label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr v-if="sub.children">
                                                                        <td style="padding-left: 10px;">
                                                                            <table v-for="deep in sub.children" class="responsive table table-striped table-bordered m-b-0" cellspacing="0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td><label class="checkbox-inline" ><input type="checkbox" v-model="form_data.access" :value="deep.id+'-'+'0'"  @change="allowAll(deep,sub,list)">{{deep.menu_name}}</label></td>
                                                                                    </tr>
                                                                                    <tr v-if="option_data.internal_link[deep.id]">
                                                                                        <td>
                                                                                            <label class="checkbox-inline" ><input type="checkbox" v-model="form_data.selectAll" :value="deep.id" @change="checkSelectAll(deep,sub,list)">Select All</label>
                                                                                            <hr>
                                                                                            <label v-for="(link_internal in option_data.internal_link[deep.id]" class="checkbox-inline" >
                                                                                                <input type="checkbox" v-model="form_data.access" @change="allowParent(list,sub,deep,option_data.internal_link[deep.id])" :value="deep.id+'-'+link_internal.id">{{link_internal.link_name}}
                                                                                            </label>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                            <td>No.</td>
                            <td class="sortable" v-bind:class="getSortingClass('role_name')" @click="sortingChanged('role_name')">Role Name</td>
                            <td class="action">Action</td>
                        </tr>
                    </thead>
                    <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                        <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
                            <td style="width: 5%">{{order_no + index + 1}}</td>
                            <td>{{form_data.role_name}}</td>
                            <td style="width: 20%" class="action">
                                <button @click="getModalData($event,{dataUrl:'adminrole/edit/'+form_data.id},editSlection)" class="btn-xs btn-info" title="" data-original-title="Edit" data-toggle="modal" data-target="#myModal"><i class="icon-edit"></i> Edit</button>
                                <button @click="deleteItem({delUrl:'adminrole/delete/'+form_data.id})" class="btn-xs btn-danger" title="" data-original-title="Delete"><i class="icon-trash"></i> Delete</button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="3" align="center">No data in database</td>
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
        data(){
            return {
               masterselect:"",
            }
        },
        created(){
            this.getResults(1);
        },
        validations: {
            form_data: {
              role_name: { required }
            }
        },
        methods:{
            editSlection(){
                let vm = this;
                this.form_data.menu_list.forEach(function(item) {
                    if(vm.form_data.internal_link[item.id]){
                        vm.parentSelectAll(item,vm.form_data.internal_link[item.id],vm);
                    }
                    if(item.children){
                        item.children.forEach(function(sub){
                            if(vm.form_data.internal_link[sub.id]){
                                vm.parentSelectAll(sub,vm.form_data.internal_link[sub.id],vm);
                            }
                            if(sub.children){
                                sub.children.forEach(function(deep){
                                    if(vm.form_data.internal_link[deep.id]){
                                        vm.parentSelectAll(deep,vm.form_data.internal_link[deep.id],vm);
                                    }
                                });
                            }
                        });
                    }
                });
            },
            masterCheck(){
                let vm = this;
                this.form_data.access=[];
                this.form_data.selectAll=[];
                if (this.masterselect == 1){
                    this.form_data.menu_list.forEach(function(item) {
                        vm.allowMenuItem(item,vm);
                        if(item.children){
                            item.children.forEach(function(sub){
                                vm.allowMenuItem(sub,vm);
                                if(sub.children){
                                    sub.children.forEach(function(deep){
                                       vm.allowMenuItem(deep,vm);
                                    });
                                }
                            });
                        }
                    });
                }
            },
            allowAll(item,parent,granParent){
                let vm = this;
                this.selectUpperParent(parent,granParent);
                if(this.form_data.access.includes(item.id+'-'+'0')){
                    vm.allowMenuItem(item,vm);
                    if(item.children){
                        item.children.forEach(function(childItem){
                            vm.allowMenuItem(childItem,vm);
                            if(childItem.children){
                                childItem.children.forEach(function(subChild){
                                    vm.allowMenuItem(subChild,vm);
                                });
                            }
                        });
                    }
                }else{
                    this.deleteMenuIitem(item,vm);
                    if(item.children){
                        item.children.forEach(function(childItem){
                            vm.deleteMenuIitem(childItem,vm);
                            if(childItem.children){
                                childItem.children.forEach(function(subChild){
                                    vm.deleteMenuIitem(subChild,vm);
                                });
                            }
                        });
                    }
                }
            },
            allowMenuItem(item,vm){
                if(vm.form_data.access.includes(item.id+'-'+'0')){
                    vm.form_data.access.splice(vm.form_data.access.indexOf(item.id+'-'+'0'), 1);
                }
                if(vm.form_data.internal_link[item.id]){
                    if(vm.form_data.selectAll.includes(item.id)){
                        vm.form_data.selectAll.splice(vm.form_data.selectAll.indexOf(item.id), 1);
                    }
                    vm.form_data.selectAll.push(item.id);
                    vm.form_data.internal_link[item.id].forEach(function(intLnk){
                        if(vm.form_data.access.includes(item.id+'-'+intLnk.id)){
                           vm.form_data.access.splice(vm.form_data.access.indexOf(item.id+'-'+intLnk.id), 1);
                        }
                        vm.form_data.access.push(item.id+'-'+intLnk.id);
                    });
                }
                vm.form_data.access.push(item.id+'-'+'0');
            },
            deleteMenuIitem(item,vm){
                if(vm.form_data.access.includes(item.id+'-'+'0')){
                    vm.form_data.access.splice(vm.form_data.access.indexOf(item.id+'-'+'0'), 1);
                }
                vm.deleteMenuInternal(vm,item);
            },
            deleteMenuInternal(vm,item){
                if(vm.form_data.internal_link[item.id]){
                    if(vm.form_data.selectAll.includes(item.id)){
                        vm.form_data.selectAll.splice(vm.form_data.selectAll.indexOf(item.id), 1);
                    }
                    vm.form_data.internal_link[item.id].forEach(function(internalItem){
                        if(vm.form_data.access.includes(item.id+'-'+internalItem.id)){
                            vm.form_data.access.splice(vm.form_data.access.indexOf(item.id+'-'+internalItem.id), 1);
                        }
                    });
                }
            },
            selectUpperParent(parent,granParent){
                if(granParent){
                    if(!this.form_data.access.includes(granParent.id+'-'+'0')){
                       this.form_data.access.push(granParent.id+'-'+'0');
                    }
                }
                if(parent){
                    if(!this.form_data.access.includes(parent.id+'-'+'0')){
                       this.form_data.access.push(parent.id+'-'+'0');
                    }
                }
            },
            checkSelectAll(item,parent,granParent){
                this.selectUpperParent(parent,granParent);
                let vm = this;
                if(this.form_data.selectAll.includes(item.id)){
                    if(!this.form_data.access.includes(item.id+'-'+'0')){
                        this.form_data.access.push(item.id+'-'+'0');
                    }
                    if(vm.form_data.internal_link[item.id]){
                        vm.form_data.internal_link[item.id].forEach(function(intLnk){
                            if(vm.form_data.access.includes(item.id+'-'+intLnk.id)){
                                vm.form_data.access.splice(vm.form_data.access.indexOf(item.id+'-'+intLnk.id),1);
                            }
                            vm.form_data.access.push(item.id+'-'+intLnk.id);
                        });
                    }
                }else{
                    this.deleteMenuInternal(this,item);
                }
            },
            parentSelectAll(item,intLnklist,vm){
                let allCheck = true;
                intLnklist.forEach(function(intLnk){
                    if(!vm.form_data.access.includes(item.id+'-'+intLnk.id)){
                        allCheck = false;
                    }
                });
                if(allCheck){
                    this.form_data.selectAll.push(item.id);
                }else{
                    let sIndex = this.form_data.selectAll.indexOf(item.id);
                    if(sIndex >= 0){
                        this.form_data.selectAll.splice(sIndex, 1);
                    }
                }
            },
            allowParent(granParent,parent,child,intLnklist){

                let vm = this;
                this.selectUpperParent(parent,granParent);
                if(child){
                    if(!this.form_data.access.includes(child.id+'-'+'0')){
                       this.form_data.access.push(child.id+'-'+'0');
                    }
                    this.parentSelectAll(child,intLnklist,vm);
                }else if(parent){
                    this.parentSelectAll(parent,intLnklist,vm);
                }else{
                    this.parentSelectAll(granParent,intLnklist,vm);
                }
            }
        }

    }
</script>
