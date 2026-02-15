<template>
<div>
    <div v-if="this.page_loading" class="widget box">
        <div class="widget-header">
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                       <div class="row">
                           <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                               <h3 class="card-title d-none d-md-block">Interveiwer List</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <!-- <a class="btn btn-info" href="#" data-toggle="modal" data-target="#addNewJobGrade"><i class="fa fa-plus"></i> Add New</a> -->
                                 <div v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/interview_board_call'},resetModal)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>
                                 <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                               </span>
                           </div>
                       </div>
                    </div>
                    <div class="card-body col-md-12">
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
                                      <input v-on:keyup="getResults" v-model="search_input.search_key" type="text" aria-controls="DataTables_Table_0" class="form-control search-keyword" id="search"  placeholder="Search...">
                                  </div>
                              </label>
                          </div>
                      </div>

                      <table id="employeeTable" class="table table-bordered table-striped employeeTable">
                        <thead>
                          <tr>
                            <th class="text-center">SL</th>
                            <th class="text-center" v-bind:class="getSortingClass('jc_circular_id')" @click="sortingChanged('jc_circular_id')">Circular ID <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Vacant Name <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Examiner Name <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('employee_mobile')" @click="sortingChanged('employee_mobile')">Mobile <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('employee_email')" @click="sortingChanged('employee_email')">Email <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('ibc_email_status')" @click="sortingChanged('ibc_email_status')">Mail Sent Status <i class="fas fa-sort"></i></th>
                            <!-- <th class="text-center">Status</th> -->
                            <th class="text-center">Action</th>
                          </tr>
                        </thead>
                         <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                          <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i=index>
                            <td class="text-center">{{index+1}}</td>
                            <td>{{form_data.jc_circular_id}}</td>
                            <td>{{form_data.designation_name}}</td>
                            <td>{{form_data.employee_fullname}}</td>
                            <td class="text-center">{{form_data.employee_mobile}}</td>
                            <td>{{form_data.employee_email}}</td>
                            <td class="text-center">
                            	<span v-if="form_data.ibc_email_status==1" style="color:green">{{'Email Sent!'}}</span>
                            	<span v-if="form_data.ibc_email_status==2" style="color:orange">{{'Email not sent!!'}}</span>
                            </td>
                            <!-- <td class="text-center">
                            	<span v-if="form_data.ibc_status==1" style="color:green">{{'Active'}}</span>
                            	<span v-if="form_data.ibc_status==0" style="color:red">{{'Inactive'}}</span>
                            </td> -->
                            <td class="text-center" style="padding: 0px;">
                              <span v-if="lists.email_sent=='email_sent'">
                            	<span v-if="form_data.ibc_email_status!=1">
                            		<button @click="emailSendToExaminer(form_data.id,form_data.employee_fullname,form_data.employee_email)" class="btn-xs btn-warning" title="Email Sending!" data-toggle="modal" data-target="#addNewJobGrade" > <i class="fa fa-envelope"> </i></button>
                            	</span>
                            	<span v-else>
                            		<button disabled class="btn btn-xs btn-warning" title="Already email sent!" data-toggle="modal" data-target="#addNewJobGrade"><i class="fa fa-envelope"></i></button>
                            	</span>
                            </span>

                              	<button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/interview_board_call/'+form_data.id},setModalData)" class="btn-xs btn-info" title="Edit" data-toggle="modal" data-target="#addNewJobGrade" > <i class="fa fa-edit"></i></button>
                             
                              	<button  v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/interview_board_call/'+form_data.id})" title="Delete" class="btn btn-danger btn-xs" ><i class="fa fa-trash"></i> </button>
                             </td>
                          </tr>
                        </tbody>
                         <tbody v-else>
                            <tr>
                                <td colspan="8" align="center">No data in database</td>
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

          <modal class="" name="myModal" height="auto" :clickToClose="false">
	           <div v-if="modal_loading">
	               <div class="widget-header modal-header">
	                   <h4><i class="icon-reorder"></i>Interview Board Form</h4>
	                   <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	               </div>
	               <div class="modify-wraper modal-body">
	                   <form @submit.prevent="add({add:'add/interview_board_call'},resetModal)" class="form-horizontal row-border" id="validate-1">
	                     <div class="row">
	                       <div class="col-md-10 offset-md-1 date_format_modal_design">
	                          <div class="form-group">
	                             <label class="col-md-12 control-label">Job Circular<span class="required_sign">*</span></label>
	                             <div class="col-md-12 inputGroupContainer">
	                                <div class="input-group">
	                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
	                                   <vue-select v-model="job_circular_value" :options="option_data.job_circular_data" @select="onSelectJobCircular" placeholder="Select one" label="text" track-by="text"></vue-select>
	                                </div>
	                             </div>
	                          </div>
	                          <div class="form-group">
	                             <label class="col-md-12 control-label">Examiner Name <span class="required_sign">*</span></label>
	                             <div class="col-md-12 inputGroupContainer">
	                                <div class="input-group">
	                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
	                                   <vue-select multiple v-model="form_data.employee_name_value" :options="option_data.employee_data" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
	                                </div>
	                             </div>
	                          </div>

	                          <div class="form-group">
	                             <label class="col-md-6 control-label">Interview Date</label>
	                             <div class="col-md-12 inputGroupContainer">
	                                <div class="input-group">
	                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
	                                   <datepicker placeholder="Select Date" v-model="form_data.ibc_interview_date" class="form-control" required></datepicker>
	                                </div>
	                             </div>
	                          </div>

	                          <div class="form-group">
	                             <label class="col-md-6 control-label">Interview Time</label>
	                             <div class="col-md-12 inputGroupContainer">
	                                <div class="input-group">
	                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
	                                  <vue-timepicker class="form-control" v-model="form_data.ibc_interview_time" required></vue-timepicker>
	                                </div>
	                             </div>
	                          </div>

	                          <div class="form-group">
	                             <label class="col-md-6 control-label">Email Send?</label>
	                             <div class="col-md-12 inputGroupContainer">
	                                <div class="input-group">
	                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
	                                   <select class="mdb-select md-form form-control" v-model="form_data.ibc_email_status">
	                                     <option disabled>--Select--</option>
	                                     <option value="1">Yes</option>
	                                     <option value="2">No</option>
	                                   </select>
	                                </div>
	                             </div>
	                          </div>

	                          <!-- <div class="form-group">
	                             <label class="col-md-6 control-label">Status</label>
	                             <div class="col-md-12 inputGroupContainer">
	                                <div class="input-group">
	                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
	                                   <select class="form-control" v-model="form_data.ibc_status">
	                                     	<option disabled>--Select--</option>
	                                     	<option value="1">Active</option>
	                                     	<option value="0">Inactive</option>
	                                   </select>
	                                </div>
	                             </div>
	                          </div> -->
	                       </div>
	                     </div>
	                     <div class="form-actions col-md-12" style="padding:15px 60px 40px 0px;">
	                         <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2" style="margin-right: 50px;">
	                         <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button>
	                     </div>
	                 </form>
	             </div>
	         </div>
             <div v-if="!modal_loading">
                 <pageLoading></pageLoading>
             </div>
         </modal>

          <!-- <div class="modal fade addNewJobGrade" id="addNewJobGrade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">Add Job Grade</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body addNewEmployee">
                  <div class="container">
                         <table class="table table-striped">
                            <tbody>
                               <tr>
                                  <td colspan="1">
                                    <form @submit.prevent="add({add:'add/interview_board_call'})" class="form-horizontal  row-border" id="validate-1">
                                      <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                           
                                           <div class="form-group">
                                              <label class="col-md-6 control-label">Job Grade Name</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                  <input id="jobgrade_name" v-model="form_data.jobgrade_name" name="jobgrade_name" placeholder="" class="form-control" required="true" type="text"></div>
                                              </div>
                                           </div>
                                           
                                           
                                           <div class="form-group">
                                              <label class="col-md-6 control-label">Status</label>
                                              <div class="col-md-12 inputGroupContainer">
                                                 <div class="input-group">
                                                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                    <select class="form-control" v-model="form_data.jobgrade_status" required="true">
                                                       <option disabled>--Select--</option>
                                                       <option value="1">Active</option>
                                                       <option value="0">Inactive</option>
                                                    </select>
                                                 </div>
                                              </div>
                                           </div>
                                           <div style="margin-top:15px;">
                                             <button type="submit" class="btn btn-info float-right" style="margin-left: 10px;" hide-footer="true">Save changes</button>
                                             <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
                                           </div>
                                        </div>
                                      </div>
                                     </form>
                                  </td>
                               </tr>
                            </tbody>
                         </table>
                      </div>
                </div>
              </div>
            </div>
          </div> -->
        </div>
    </div>
    <div v-if="!this.page_loading">
        <pageLoading></pageLoading>
    </div>
</div>
</template>
<script>
    import Loading from '../Loading.vue';
    import $ from 'jquery'
    import VueTimepicker from 'vue2-timepicker'
    import 'vue2-timepicker/dist/VueTimepicker.css'
    export default {
    	data(){
    	  return{
    	    // employee_name_value:[],
    	    employee_name_value:'',
    	    job_circular_value:''

    	  }
    	},
        created(){
            this.getResults(1);
        },
        components:{
            pageLoading:Loading,
            VueTimepicker
        },
        methods:{
        	onSelectEmployee(option){
        	  	console.log(option);
        	  	this.form_data.ibc_examiner_name= option.id;
        	  	console.log(this.form_data.ibc_examiner_name);
            //  this.form_data.employee_id = option.id;
            // this.form_data.ibc_examiner_name = option.id
        	  	// alert(this);
              	// this.form_data.ibc_examiner_name=this.ibc_examiner_name;
              	// console.log(this.form_data.ibc_examiner_name);
        	},
        	onSelectJobCircular(option){
        	  	console.log(option);
        	  	this.form_data.ibc_circular_id= option.id;
        	  	console.log(this.form_data.ibc_circular_id);


        	},
        	setModalData(){
        	  	this.employee_name_value=this.form_data.employee_name_value;
        	  	this.job_circular_value=this.form_data.job_circular_value;
        	},
        	resetModal(){
        		this.employee_name_value='';
        		this.job_circular_value='';
        		this.job_circular_value='';
        		this.form_data.ibc_email_status='2';
        		// this.form_data.ibc_status='1';
        	},
        	emailSendToExaminer(id,name,email){
    				if(!window.confirm('Are you sure email to '+name+'?')){
    				  return;
    				}
    				// this.page_loading = true;
    				let uri = URL.baseUrl('emailSendToExaminer/interview_board_call/'+id+'/'+name+'/'+email);
    				console.log(uri);
    				axios.get(uri)
              			.then(res => {
    	          		console.log(res.data);
    	            	this.form_data =res.data;
    	            	this.getResults(1);
    	            	this.showToster({status:1,message:'Email Sent Successfull!'});
    	            	// this.page_loading = false;
    	          	})
    	          	.catch(error => {
    	            	this.showToster({status:0,message:'opps! something went wrong'});
    	            	// this.page_loading = false;
    	          	})
            	}
        }



    }



</script>

<style type="text/css">
	.modal-body {
	   overflow-y: auto;
	}
	.vue__time-picker .dropdown{
		top:auto !important;
		/*position: fixed !important;*/
	}
	input:focus {
		outline: none;
	}
</style>
