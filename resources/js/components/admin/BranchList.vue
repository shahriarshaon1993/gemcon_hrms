<template>
<div>
    <div v-if="page_loading" class="widget box">
        <div class="widget-header">
            <h4><i class="icon-reorder"></i>Branch </h4>

            <div class="toolbar no-padding ">
                <div  @click="getModalData($event,{dataUrl:'create/branch'})" class="btn-group"> <span class="btn btn-xs btn-info"><i class="icon-plus"></i>Add New</span></div>

                <div class="btn-group"> <span class="btn btn-xs  widget-collapse"><i class="icon-refresh"> </i></span> </div>
                <modal name="myModal" width="677" height="auto" :clickToClose="false">
                    <div v-if="modal_loading">
                        <div class="widget-header">
                            <h4><i class="icon-reorder"></i>Branch Form</h4>
                             <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modify-wraper">
                            <form @submit.prevent="add({add:'add/branch'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                                <div class="pos-form-wraper">
                                     <div v-if="errors" class="alert alert-danger">
                                        <div v-for="(error, index) in errors">
                                            <span v-if="isObject(error)" v-for="err in error">{{err}}</span>
                                            <span v-if="!isObject(error)">{{error}}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-6 control-label">Branch Code</label>
                                                <div class="col-md-6">
                                                    <input v-model="form_data.branch_code" readonly  placeholder="Branch Code" style="height: 35px;" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-4 control-label"> Name</label>
                                                <div class="col-md-8">
                                                    <input v-model="form_data.branch_name" placeholder="Branch Name" style="height: 35px;" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-6 control-label">Branch Reg Number</label>
                                                <div class="col-md-6">
                                                    <input v-model="form_data.branch_reg"  placeholder="Branch Reg Number" style="height: 35px;" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-4 control-label"> Branch size</label>
                                                <div class="col-md-6">
                                                    <input v-model="form_data.branch_size"  placeholder="Branch size"  style="height: 35px;" @change="BranchProgses($event)" type="text" class="form-control">
                                                    <!-- <progress id="file" value="32" max="100"> 32% </progress> -->
                                                </div>
                                                <div class="col-md-2">
                                                    <p style="font-size: 9px; margin-left: -27px; margin-top: -10px;margin-bottom: -4px;">{{form_data.progses}} out of 10 </p>
                                                     <progress id="file" style="width: 48px;margin-left: -29px;height: 27px;margin-top: -7px;" :value="form_data.progses" max="10"> 32% </progress>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group modify-input">
                                        <label class="col-md-3 control-label">Address</label>
                                        <div class="col-md-9">
                                            <input v-model="form_data.address" placeholder="Branch Address" style="height: 35px;" type="text" class="form-control">
                                        </div>
                                    </div> 
                                
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-6 control-label">Phone</label>
                                                <div class="col-md-6">
                                                    <input v-model="form_data.phone" placeholder="Phone" style="height: 35px;" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-4 control-label">Email</label>
                                                <div class="col-md-8">
                                                    <input v-model="form_data.email" placeholder="Email" style="height: 35px;" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-6 control-label">Conpany Name</label>
                                                <div class="col-md-6">
                                                    <select  v-model="form_data.company_id" placeholder="Conpany Name" class="form-control">
                                                            <option v-for="Company in lists.company"  :value='Company.id' >{{Company.company_name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-5 control-label">Branch Type</label>
                                                <div class="col-md-7">
                                                    <select  v-model="form_data.branch_type"  style="width: 184px; margin-left: -26px;" placeholder="Branch Type" class="form-control">
                                                            <option value="1">Head Office</option>
                                                            <option value="2">Zone Office</option>
                                                            <option value="3">Area Office</option>
                                                            <option value="4">Branch Office</option>
                                                            <option value="5">Factory Office</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-6 control-label">Customer ID </label>
                                                <div class="col-md-6">
                                                    <input v-model="form_data.coustomer_id" placeholder="Customer Id" style="height: 35px;" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="form-group modify-input">
                                                <label class="col-md-4 control-label">Vendor ID</label>
                                                <div class="col-md-8">
                                                    <input v-model="form_data.vendor_id" placeholder="Vendor Id" style="height: 35px;" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                
                                    </div>
                                    
                                   
                                    <div class="row">
                                        <br>
                                     <hr>
                                         <div class="col-md-12">
                                            <div class="form-group modify-input">
                                                 <div class="col-md-12">
                                                    <table class="auto-style10 eku-member-table" style=" margin-bottom: 30px;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="width: 11%;"><span style="font-size:13px">Items Permision</span></td>

                                                                <td style="width: 20%;">   
                                                                    <ul style="list-style-type: none;">
                                                                        <li>
                                                                            <input style="height: 13px;" type="checkbox"  :id="12" :value="0" v-model="permisionall" @change="handleTasksall()">
                                                                            <label :for="12"> All Items </label>
                                                                        </li>

                                                                        <li v-for="task in form_data.CatgoryType">
                                                                            <input style="height: 13px;" type="checkbox" :id="task.catgory_name" :value="task" v-model="permision" @change="handleTasks()">
                                                                            <label :for="task.catgory_name">{{task.catgory_name}}</label>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
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
                             <td class="sortable" v-bind:class="getSortingClass('branch_code')" @click="sortingChanged('branch_code')">
                                Branch Code 
                            </td>
                             <td class="sortable" v-bind:class="getSortingClass('branch_reg')" @click="sortingChanged('branch_reg')">
                                BIIN Number
                            </td>

                            <td class="sortable" v-bind:class="getSortingClass('branch_name')" @click="sortingChanged('branch_name')">
                                Name
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('address')" @click="sortingChanged('address')">
                                Address
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('phone')" @click="sortingChanged('phone')">
                                Phone
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('email')" @click="sortingChanged('email')">
                                Email
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('branch_type')" @click="sortingChanged('branch_type')">
                                Type
                            </td>
                            <td class="sortable" v-bind:class="getSortingClass('branch_size')" @click="sortingChanged('branch_size')">
                                Size
                            </td>
                            <td class="action">
                                Action
                            </td>
                        </tr>
                    </thead>
                    <tbody v-if="Object.keys(paginate_data.data).length > 0">
                        
                        <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
                            <td>{{index + 1}}</td>
                             <td>  {{form_data.branch_code }}</td>
                             <td>  {{form_data.branch_reg }}</td>
                            <td>  {{form_data.branch_name }}</td>
                            <td>{{form_data.address}}</td>
                            <td>{{form_data.phone}}</td>
                            <td>{{form_data.email}}</td>
                            <td>
                                <p v-if="form_data.branch_type=='1'"> Head Office </p>
                                <p v-if="form_data.branch_type=='2'"> Zone Office </p>
                                <p v-if="form_data.branch_type=='3'"> Area Office </p>
                                <p v-if="form_data.branch_type=='4'"> Branch Office </p>
                                <p v-if="form_data.branch_type=='5'"> Factory Office </p>
                                             
                            </td>
                             <td>{{form_data.branch_size}}</td>
                            <td class="action">
                                <button @click="getModalData($event,{dataUrl:'edit/branch/'+form_data.id})" class="btn-xs btn-info" data-toggle="modal" data-target="#myModal"><i class="icon-edit"></i> </button>
                                <button v-if="form_data.status != 1" @click="approveItem({delUrl:'delete/branch/approve/'+form_data.id})" class="btn-xs btn-danger" title="" data-original-title="Not Approve"><span aria-hidden="true">&times;</span> </button>
								<button  v-if="form_data.status != 0" @click="approveItem({delUrl:'delete/branch/approve/'+form_data.id})" class="btn-xs btn-success" title="" data-original-title="Approve"><i class="fa fa-check"></i> </button>
                                <button @click="deleteItem({delUrl:'delete/branch/'+form_data.id})" class="btn-xs btn-danger"><i class="icon-trash"></i> </button>
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
                permision: [],
                form_data:[{
                    permision:[],
                }],
                permisionall:[],
                progses:0,
			}
        },
    
        methods:{
               resetModal(){
                this.form_data.branch_code='';
                this.form_data.branch_type='';
                this.form_data.company_id='';
                this.form_data.email='';
                this.form_data.phone='';
                this.form_data.address='';
                this.form_data.branch_size='';
                this.form_data.branch_reg='';
                this.form_data.permision=[];
                this.form_data.permision=[];
                this.permision=[];
          },
          BranchProgses(event){
              if(event.target.value <= 10 ){
                   this.form_data.progses=event.target.value;
              }else{
                  this.form_data.branch_size=0;
                  this.showToster({status:0,message:'Sorry !Please input Any One of the 10 Numbers...'});
              }
             
              console.log(event.target.value);
          },
          handleTasks() {
           this.permisionall='';
           this.form_data.permision=[];
           this.form_data.permision=this.permision;
            console.log(this.permision)
         },
        handleTasksall(){
             this.permisionall=this.permisionall;
            this.form_data.permision=[];
            this.permision=[];
            this.permisionall=[{
                 id:0,
            }];

            this.form_data.permision=[{
                id:0,
            }]
            this.form_data.permision= this.permisionall;
         console.log( this.form_data.permision)
        },

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
        }   

    }
</script>
