<template>
<div>
    <div v-if="loading" class="widget box">
            <div class="widget-header">
                <h4><i class="icon-reorder"></i>header</h4>
                
                <div class="toolbar no-padding ">
                    <div @click="getModalData($event,{dataUrl:'create/adminrole'})" class="btn-group"> <span class="btn btn-xs btn-info"><i class="icon-plus"></i>Add New</span> </div>


                    <div class="btn-group"> <span class="btn btn-xs  widget-collapse"><i class="icon-refresh"> </i></span> </div>
                    <modal name="myModal"  transition="scale" width="550" height="auto" :clickToClose="false">
                        <div v-if="modal_loading">
                            <div class="widget-header">
                                <h4><i class="icon-reorder"></i>Modal Form</h4>
                                 <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modify-wraper">
                                <form @submit.prevent="add({add:'add/adminrole'})" class="form-horizontal  row-border" id="validate-1">
                                    <div class="my-form-wraper">
                                        <div class="form-group modify-input">
                                            <label class="col-md-3 control-label">Role Name <span class="required">*</span></label>
                                            <div class="col-md-9" :class="{ 'has-error': $v.form_data.role_name.$error }">
                                                {{$v.form_data.role_name.$touch()}}
                                                <input v-model="form_data.role_name" type="text" class="form-control required">
                                            </div>
                                        </div>
                                        <div class="role-wraper">
                                            <div class="widget-header">
                                                <h4>
                                                    <label class="checkbox-inline" >
                                                        <input true-value="1" false-value="0" type="checkbox" @change="masterCheck" v-model="masterselect">Admin Panel {{form_data.access}}
                                                    </label>
                                                </h4>
                                            </div>
                                            <div class="widget-content">
                                                <table v-for="list  in form_data.menu_list"  class="responsive table table-striped table-bordered m-b-0" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <label class="checkbox-inline" >
                                                                    <input type="checkbox" v-model="form_data.access" true-value="1" :value="list.id+'-'+'0'"  @change="allowAll(list)" false-value="0">{{list.menu_name}}
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr v-if="form_data.internal_link[list.id]">
                                                            <td>
                                                                <label class="checkbox-inline" >
                                                                    <input type="checkbox" true-value="1" false-value="0" v-model="form_data.selectAll" :value="list.id"  @change="checkSelectAll(list)">Select All
                                                                </label>
                                                                <hr>
                                                                <label v-for="(link_internal in form_data.internal_link[list.id]" class="checkbox-inline" >
                                                                    <input type="checkbox" true-value="1" false-value="0" v-model="form_data.access" @change="allowParent(list.id+'-'+link_internal.id)" :value="list.id+'-'+link_internal.id">{{link_internal.link_name}}
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
                                                                                    <input type="checkbox" v-model="form_data.access" :value="sub.id+'-'+'0'"  @change="allowParent(sub,list)">{{sub.menu_name}}
                                                                                </label>
                                                                            </td>
                                                                        </tr>
                                                                        <tr v-if="form_data.internal_link[sub.id]">
                                                                            <td>
                                                                                <label class="checkbox-inline" ><input type="checkbox" true-value="1" false-value="0" v-model="form_data.selectAll" :value="sub.id"  @change="checkSelectAll(sub,list)">Select All</label>
                                                                                <hr>

                                                                                <label v-for="(link_internal in form_data.internal_link[sub.id]" class="checkbox-inline" >
                                                                                    <input type="checkbox" v-model="form_data.access" @change="allowParent(sub.id+'-'+link_internal.id,list)" :value="sub.id+'-'+link_internal.id">{{link_internal.link_name}}
                                                                                </label>
                                                                            </td>
                                                                        </tr>
                                                                        <tr v-if="sub.children">
                                                                            <td style="padding-left: 10px;">
                                                                                <table v-for="deep in sub.children" class="responsive table table-striped table-bordered m-b-0" cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td><label class="checkbox-inline" ><input type="checkbox" v-model="form_data.access" :value="deep.id+'-'+'0'"  @change="allowParent(deep,sub,list)">{{deep.menu_name}}</label></td>
                                                                                        </tr>
                                                                                        <tr v-if="form_data.internal_link[deep.id]">
                                                                                            <td>
                                                                                                <label class="checkbox-inline" ><input type="checkbox" v-model="form_data.selectAll" :value="deep.id" @change="checkSelectAll(deep,sub,list)">Select All</label>
                                                                                                <hr>
                                                                                                <label v-for="(link_internal in form_data.internal_link[deep.id]" class="checkbox-inline" >
                                                                                                    <input type="checkbox" v-model="form_data.access" @change="allowParent(deep.id+'-'+link_internal.id,sub,list)" :value="deep.id+'-'+link_internal.id">{{link_internal.link_name}}
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
            <div class="widget-content">
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
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="dataTables_filter" id="DataTables_Table_0_filter">
                                    <label>
                                        <div class="input-group"><span class="input-group-addon"><i class="icon-search"></i></span>
                                            <input v-on:keyup="getResults" v-model="search_key" type="text" aria-controls="DataTables_Table_0" class="form-control" id="search"  placeholder="Enter keyword...">
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
                                <td>Role Name</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody  v-if="Object.keys(lists.role.data).length > 0">
                            <tr v-for="(form_data, index) in lists.role.data" v-bind:key="form_data.id">
                                <td class="col-md-3">{{index + 1}}</td>
                                <td class="col-md-6">{{form_data.role_name}}</td>
                                <td class="col-md-3">
                                    <button @click="getModalData($event,{dataUrl:'adminrole/edit/'+form_data.id})" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Edit</button>
                                    <button @click="deleteItem({delUrl:'adminrole/delete/'+form_data.id})" class="btn btn-danger">Delete</button>
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
                                <div class="dataTables_info" id="DataTables_Table_0_info">Showing {{lists.role.current_page}} of {{lists.role.last_page}} pages</div>
                            </div>
                            <div class="col-md-6">
                                <div class="dataTables_paginate paging_bootstrap">
                                    <pagination :data="lists.role" @pagination-change-page="getResults"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div v-if="!loading">
        <pageLoading></pageLoading>
    </div>
</div>
</template>

<script>
    import Loading from '../Loading.vue'
    import { required, email, minLength } from "vuelidate/lib/validators";
    import loading_modal from 'vue-loading-overlay';

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
        components:{
            pageLoading:Loading
        },
        methods:{
            masterCheck(){
                let vm = this;
                this.form_data.access=[];
                this.form_data.selectAll=[];
                if (this.masterselect == 1){
                    this.form_data.menu_list.forEach(function(item) {
                        vm.form_data.access.push(item.id+'-'+'0');
                        vm.rowCheck(vm,item);
                        if(item.children){
                            item.children.forEach(function(sub){
                                vm.form_data.access.push(sub.id+'-'+'0');
                                vm.rowCheck(vm,sub);
                                if(sub.children){
                                    sub.children.forEach(function(deep){
                                        vm.form_data.access.push(deep.id+'-'+'0');
                                        vm.rowCheck(vm,deep);
                                    });
                                }
                            });
                        }
                    });
                }
            },
            allowAll(item){
                let vm = this;
                let value = this.form_data.access.includes(item.id+'-'+'0');
                if(this.form_data.access.includes(item.id+'-'+'0')){ 
                    vm.rowCheck(vm,item);
                    if(item.children){
                        item.children.forEach(function(childItem){
                            vm.rowCheck(vm,childItem);
    
                            vm.form_data.access.push(childItem.id+'-'+'0');
                            if(childItem.children){
                                vm.rowCheck(vm,childItem.children);
                                childItem.children.forEach(function(subChild){
                                    vm.rowCheck(vm,subChild);
                                    vm.form_data.access.push(subChild.id+'-'+'0');
                                });
                            }
                        });
                    }
                }else{
                    this.deleteInternal(vm,item)
                    if(item.children){
                        item.children.forEach(function(childItem){
                            let childInex = vm.form_data.access.indexOf(childItem.id+'-'+'0');
                            console.log(childInex);
                            if(childInex >= 0){
                                vm.form_data.access.splice(childInex, 1);
                                vm.deleteInternal(vm,childItem);
                            }
                            if(childItem.children){
                                childItem.children.forEach(function(subChild){
                                    let subChildIndex = vm.form_data.access.indexOf(subChild.id+'-'+'0');
                                    if(subChildIndex >= 0){
                                        vm.form_data.access.splice(subChildIndex, 1);
                                        vm.deleteInternal(vm,subChild);
                                    }
                                });
                            }
                        });
                    }
                }
            },
            rowCheck(vm,item){
                if(vm.form_data.internal_link[item.id]){
                    vm.form_data.selectAll.push(item.id);           
                    vm.form_data.internal_link[item.id].forEach(function(intLnk){
                        if(vm.form_data.access.includes(item.id+'-'+intLnk.id)){
                           vm.form_data.access.splice(vm.form_data.access.indexOf(item.id+'-'+intLnk.id), 1); 
                        }
                        vm.form_data.access.push(item.id+'-'+intLnk.id);  // All menu Internal link  selected
                    });
                }
            },
            deleteInternal(vm,item){
                if(this.form_data.internal_link[item.id]){
                    let sIndex = vm.form_data.selectAll.indexOf(item.id);
                    if(sIndex >= 0){
                        vm.form_data.selectAll.splice(sIndex, 1);
                    }
                    this.form_data.internal_link[item.id].forEach(function(internalItem){
                        let aIndex = vm.form_data.access.indexOf(item.id+'-'+internalItem.id);
                        if(aIndex >= 0){
                            vm.form_data.access.splice(aIndex, 1);
                        }
                    });
                }
            },
           checkSelectAll(item,parent,gparent){
                let vm = this;
                let value = this.form_data.selectAll.includes(item.id);
                if(value){
                    this.allowParent(item,parent,gparent);
                    if(vm.form_data.internal_link[item.id]){           
                        vm.form_data.internal_link[item.id].forEach(function(intLnk){
                            vm.form_data.access.push(item.id+'-'+intLnk.id);  // All menu Internal link  selected
                        });
                    }
                }else{
                    this.deleteInternal(this,item);
                }
            },
            allowParent(item,parent,gparent){
                console.log(item);

                if(parent){
                    if(!this.form_data.access.includes(parent.id+'-'+'0')){
                       this.form_data.access.push(parent.id+'-'+'0'); 
                    }
                } 

                if(gparent){
                    if(!this.form_data.access.includes(gparent.id+'-'+'0')){
                        this.form_data.access.push(gparent.id+'-'+'0');
                    }
                }

                if(!this.form_data.access.includes(item)){
                    this.allowAll(item);
                }else{
                    let itemSplit = item.split('-');
                    if(!this.form_data.access.includes(itemSplit[0]+'-'+'0')){
                        this.form_data.access.push(itemSplit[0]+'-'+'0');
                    }
                }

            }
        }
        
    }
</script>