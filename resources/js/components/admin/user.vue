<template>
<div>
    <div v-if="page_loading" class="widget box" style="margin-left: 3% !important;">
        <div class="widget-header">
            <h4><i class="icon-reorder"></i>User</h4>
            
            <div class="toolbar no-padding ">
                <!-- <div @click="getModalData($event,{dataUrl:'user/create'})" class="btn-group"> <span class="btn btn-xs btn-info"><i class="icon-plus"></i>Add New</span></div> -->
                        
                <div class="btn-group"> <span class="btn btn-xs  widget-collapse"><i class="icon-refresh"> </i></span> </div>
                <modal name="myModal" width="660" height="auto" :clickToClose="false">
                    <div v-if="modal_loading">
                        <div class="widget-header">
                            <h4><i class="icon-reorder"></i>Modal Forms</h4>
                             <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modify-wraper">
                            <form @submit.prevent="add({add:'user/add'})" class="form-horizontal  row-border" id="validate-1">
                                <div class="my-form-wraper">
                                    <div v-if="errors" class="alert alert-danger">
                                        <div v-for="(error, index) in errors">
                                            <span v-if="isObject(error)" v-for="err in error">{{err}}</span>
                                            <span v-if="!isObject(error)">{{error}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Employee ID #</label>
                                        <div class="col-md-3">
                                            <input v-model="form_data.employee_card_no" type="text" class="form-control readonly">
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Name<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.name.$error }">
                                            {{$v.form_data.name.$touch()}}
                                            <input v-model="form_data.name" type="text" class="form-control required">
                                        </div>
                                    </div>
                                     <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Designation<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.name.$error }">
                                            {{$v.form_data.name.$touch()}}
                                             <select  v-model="form_data.employee_designation"  @change="onSelectpayType($event)" class="form-control required multiselect__tags">
                                                <option v-for="designation in form_data['designations']"  :value='designation.id' >{{designation.designation_name }}</option>
                                            </select>
                                            <!-- <vue-select v-model="designationValue" :options="option_data.designation" @select="onSelectDesignations" placeholder="Select one" label="text" track-by="text"></vue-select> -->
                                            <!-- <input v-model="form_data.designation" type="text" class="form-control required"> -->
                                        </div>
                                    </div>
                                     <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Department<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.name.$error }">
                                            {{$v.form_data.name.$touch()}}
                                            <select  v-model="form_data.employee_department"  @change="onSelectpayType($event)" class="form-control required multiselect__tags">
                                                <option v-for="department in form_data['departments']"  :value='department.id' >{{department.department_name }}</option>
                                            </select>
                                             <!-- <vue-select v-model="categoryValue" :options="option_data.department" @select="onSelectDepartments" placeholder="Select one" label="text" track-by="text"></vue-select> -->
                                            <!-- <input v-model="form_data.designation" type="text" class="form-control required"> -->
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Company Name<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.name.$error }">
                                            {{$v.form_data.name.$touch()}}
                                            <select  v-model="form_data.project_id" @change="onSelectpayType($event)" class="form-control required multiselect__tags">
                                                <option v-for="Company in form_data['CompanyList']"  :value='Company.id' >{{Company.company_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Branch Name<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.name.$error }">
                                            {{$v.form_data.name.$touch()}}
                                            <select  v-model="form_data.branch_id"  @change="onSelectpayType($event)" class="form-control required multiselect__tags">
                                                <option v-for="Branch in form_data['BranchList']"  :value='Branch.id' >{{Branch.branch_name }}</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <!-- <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">UserID<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.username.$error }">
                                            {{$v.form_data.username.$touch()}}
                                            <input v-model="form_data.username" type="text" class="form-control required required multiselect__tags">
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Email <span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.email.$error }">
                                            {{$v.form_data.email.$touch()}}
                                            <input v-model="form_data.email"  type="text" class="form-control required required multiselect__tags">
                                        </div>
                                    </div> -->
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">UserID<span class="required">*</span></label>
                                        <div class="col-md-9">
                                            <input v-model="form_data.employee_card_no" type="text" class="form-control required required multiselect__tags">
                                        </div>
                                    </div>
                                    <div v-if="form_data.id" class="form-group modify-input">
                                        <label class="col-md-3 control-label">Password</label>
                                        <div class="col-md-9">
                                            <input v-model="form_data.password"  type="password" class="form-control required multiselect__tags">
                                        </div>
                                    </div>
                                    <div v-if="!form_data.id" class="form-group modify-input">
                                        <label class="col-md-3 control-label">Password<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.password.$error }">
                                            {{$v.form_data.password.$touch()}}
                                            <input v-model="form_data.password"  type="password" class="form-control required multiselect__tags required">
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">User Role<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.name.$error }">
                                            {{$v.form_data.name.$touch()}}
                                            <select  v-model="form_data.role_id"  class="form-control required multiselect__tags">
                                                <option v-for="role in form_data['userRole']"  :value='role.id' >{{role.role_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Status<span class="required">*</span></label>
                                        <div class="col-md-9">
                                            <select  v-model="form_data.user_type"  class="form-control required multiselect__tags">
                                                <option value="0">--Select--</option>
                                                <option value="1">Group User</option>
                                                <option value="2">SBU/Company User</option>
                                                <option value="3">Unit User</option>
                                                <option value="4">Sub Unit User</option>
                                                <option value="5">Department User</option>
                                                <option value="6">Section User</option>
                                                <option value="7">Sub Section User</option>
                                             </select>
                                        </div>
                                    </div>
                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Status<span class="required">*</span></label>
                                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.name.$error }">
                                            {{$v.form_data.name.$touch()}}
                                            <select  v-model="form_data.status"  class="form-control required ">
                                                <option value='1' selected >Active</option>
                                                <option value='0' >Inactive</option>
                                             </select>
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
                            <td class="sortable" v-bind:class="getSortingClass('employee_id_no')" @click="sortingChanged('employee_id_no')">
                                ID
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('name')" @click="sortingChanged('name')">
                                Name
                            </td>
                            <!-- <td class="sortable" v-bind:class="getSortingClass('email')" @click="sortingChanged('email')">
                                Email
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('username')" @click="sortingChanged('username')">
                                username
                            </td> -->
                             <td class="sortable" v-bind:class="getSortingClass('department_name')" @click="sortingChanged('department_name')">
                                Department
                            </td>
                             <td class="sortable" v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">
                                Designation
                            </td>
                             <td class="sortable" v-bind:class="getSortingClass('role_id')" @click="sortingChanged('role_id')">
                                Roll
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
                            <td>{{order_no + index + 1}}</td>
                            <td class="text-center">{{form_data.employee_id_no}}</td>
                            <td>{{form_data.name}}</td>
                            <!-- <td>{{form_data.email}}</td> -->
                            <!-- <td>{{form_data.username}}</td> -->
                            <td>{{form_data.department_name}}</td>
                            <td>{{form_data.designation_name}}</td>
                           <!--  <td>
                                <samp v-for="depart in lists.departments" v-if="depart.id==form_data.department"> 
                                    {{depart.department_name}}
                                </samp>
                            </td>
                            <td>
                                <samp v-for="desig in lists.designations" v-if="desig.id==form_data.designation"> 
                                    {{desig.emp_designation}}
                                </samp>
                            </td> -->
                            <td>
                                <samp v-for="role in lists.userRole" v-if="role.id==form_data.role_id"> 
                                    {{role.role_name}}
                                </samp>
                            </td>
                            <td class="text-center">
                                <samp v-if="form_data.status==1" style="background: #4abad2;padding: 5px;border-radius: 5px;color: #fff;">
                                    {{"Active"}}
                                </samp>
                                <samp v-else style="background: #bd362f;padding: 5px;border-radius: 5px;color: #fff;"> 
                                    inactive
                                </samp>
                                <!-- {{form_data.status}} -->
                            </td>
                            <td style="width: 20%" class="action">
                                <button @click="getModalData($event,{dataUrl:'user/edit/'+form_data.id})" class="btn-xs btn-info" data-toggle="modal" data-target="#myModal"><i class="icon-edit"></i> Edit</button>
                                <button @click="deleteItem({delUrl:'user/delete/'+form_data.id})" class="btn-xs btn-danger"><i class="icon-trash"></i> Delete</button>
                            </td>
                        </tr>   
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="8" align="center">No data in database</td>
                        </tr>
                    </tbody>
                </table>


                <!-- <div class="row">
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
                </div> -->

                <div class="row">
                    <div
                    class="dataTables_footer clearfix"
                    style="width: 100%"
                    >
                    <div class="col-md-6" style="float: left">
                        <div
                        class="dataTables_info"
                        id="DataTables_Table_0_info"
                        >
                        Showing {{ paginate_data.current_page }} of
                        {{ paginate_data.last_page }} pages
                        </div>
                    </div>
                    <div class="col-md-6" style="float: right">
                        <div class="dataTables_paginate paging_bootstrap">
                        <pagination
                            :data="paginate_data"
                            :limit="2"
                            @pagination-change-page="getResults"
                        ></pagination>
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
         data(){
            return {
               designationValue:'',
               categoryValue:'',
            }
        },
        created(){
            this.getResults(1);
        },
       
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
            },
            onSelectpayType(event){
                var str =this.form_data.name;
                var trimmed = str.replace(/^\s+|\s+$/g, '').toLowerCase();
                trimmed =  str.split(" ")
                var titelLanth=(trimmed.length)-1;
                var email=trimmed[0]+'.'+trimmed[titelLanth]+'@gemcongroup.com';
                this.form_data.email=email;
                this.form_data.password=this.form_data.number;
                this.form_data.username=email;

            },
             onSelectDepartments(option){
                  
                this.form_data.department=option.id;
            //    console.log( this.form_data.department);
            },
            onSelectDesignations(option){
                this.form_data.designation=option.id;
                // console.log(this.form_data.permision);
            },
           
        }

        
        

    }
</script>
