<template>
<div>
	<div class="card-header">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
			<h3 class="card-title d-none d-md-block">All Circular Info</h3>
				<span class="float-sm-right" style="float: right;">
					<a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
				</span>
			</div>
		</div>
	</div>
	<div class="col-md-12" style="margin-bottom: 33px;margin-top:2px">
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
                        <!-- <button style="margin-right: 5px; font-size:14px;" class="btn btn-xs btn-info"  @click="tableToExcel('table', 'Employee Data')">Export to excel</button> -->
                        <input v-on:keyup="getResults" v-model="search_input.search_key" type="text" aria-controls="DataTables_Table_0" class="form-control search-keyword" id="search"  placeholder="Search..." style="border-radius: 0px;">
                      </div>
                  </label>
              </div>
          </div>
	</div>
	<div class="col-md-12 job-circular-list">
	     <table ref="table" id="loremTable" summary="lorem ipsum sit amet" rules="groups" frame="hsides"  class="table table-bordered table-striped employeeTable">
	      <!-- <thead>
		      <tr>
		        <th class="text-center">#</th>
		        <th class="text-center">Emp ID</th>
		        <th class="text-center">Name</th>
		        <th class="text-center">Company/SBU</th>
		        <th class="text-center">Section</th>
		        <th class="text-center">Department</th>
		        <th class="text-center">Designation</th>
		        <th class="text-center">Joining Date</th>
		        <th class="text-center">Mobile</th>
		        <th class="text-center">Action</th>
		      </tr>
	      </thead> -->
	     <tbody v-if="Object.keys(paginate_data.data).length > 0">
		     <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
		        <td>
		        	<div class="norm-jobs-wrapper">
		        	    <div class="row">
		        	        <div class="col-sm-3 col-sm-push-3"></div>                                
		        	        <div class="col-sm-9 col-sm-pull-9">
		        	            <div class="row">
		        	                <div class="col-sm-12">
		        	                    <div class="job-title-text">
		        	                        <a onclick="clickJObTitle()" target="_blank" href="jobdetails.asp?id=915530&amp;fcatId=8&amp;ln=1">
		        	                            {{form_data.designation_name}}
		        	                        </a>
		        	                    </div>
		        	                </div>
		        	                <div class="col-sm-12">
		        	                    <div class="comp-name-text">
		        	                        {{form_data.work_location_name}}
		        	                    </div>
		        	                </div>
		        	                
		        	                
		        	                <div class="col-sm-12">
		        	                    <div class="locon-text">
		        	                        <div class="row">
		        	                            <div class="col-sm-12">
		        	                                <div class="locon-text-d">
		        	                                <i class="fa fa-map-marker"></i> {{form_data.jc_educational_requirements}}</div>
		        	                            </div>
		        	                        </div>
		        	                    </div>
		        	                </div>
		        	                
		        	                <div class="col-sm-12">
		        	                    <div class="edu-text">
		        	                        <div class="edu-text-d">
		        	                            <ul><li> <i class="fa fa-graduation-cap"></i>
		        	                            	{{form_data.designation_name}}
		        	                            </li></ul>

		        	                        </div>
		        	                    </div>
		        	                </div>
		        	                
		        	                
		        	            </div>
		        	        </div>

		        	        <div class="col-sm-12">

		        	            <div class="row">
		        	                <div class="col-sm-9">
		        	                    <div class="exp-text">
		        	                        <div class="row">
		        	                            <div class="col-sm-12">
		        	                                <div class="exp-text-d" style="padding-left: 10px;">
		        	                                    <i class="fa fa-clock"></i>
		        	                                    {{form_data.jc_experience_requirements}}
		        	                                </div>
		        	                            </div>
		        	                        </div>
		        	                    </div>
		        	                </div>
		        	                <div class="col-sm-3">
		        	                    <div class="dead-text">
		        	                    	<button @click="getModalData($event,{dataUrl:'edit/job_circular/'+form_data.id},setModalData)" class="btn btn-info btn-xs" title="Edit"> <i class="fa fa-eye"></i> View Details </button>
		        	                    	<button @click="getModalData($event,{dataUrl:'edit/job_circular/'+form_data.id},setModalData)" class="btn btn-success btn-xs" title="Edit"> <i class="fa fa-edit"> </i> Apply Now </button>
		        	                        <div class="dead-text-s"><i class="fa fa-calendar" aria-hidden="true"></i> Deadline:&nbsp; <strong>{{form_data.jc_circular_expired_date}}</strong></div>
		        	                    </div>
		        	                </div>
		        	            </div>
		        	        </div>

		        	    </div>
		        	</div>
		        </td>
		      </tr>
	      </tbody>
	       <tbody v-else>
	         <tr>
	             <td colspan="14" align="center">No data in database</td>
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
    <modal ref="modal" class="employee-modal" name="myModal" height="auto" :clickToClose="false" body-class="p-0">
      	<div v-if="modal_loading">
          	<div class="widget-header modal-header">
              	<!-- <h4><i class="icon-reorder"></i>Employee Form</h4> -->
              	<button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          	</div>
          	<div class="modify-wraper modal-body">
            	<div class="container">
            		<div class="col-md-8">
                        <div class="">
                            <div class="left">  
                            <div class="row">
                                <!-- <div class="col-sm-3 col-sm-push-3"></div> -->
                                <div class="col-sm-9 col-sm-pull-9">
                                    <h4 class="job-title ">{{form_data.designation_name}}</h4>
                                    <h3 class="company-name " id="com_name">{{form_data.sbu_name}}<span style="font-weight: normal;"> </span></h3>
                                </div> 
                            </div>
                            <div class="view-all-jobs">
                            </div>
                            <div class="vac">
                                <h5>Vacancy</h5>
                                <p>
                                {{form_data.jc_job_vacancy}}
                                </p>
                            </div>
                            <div class="job_des">
                                <h5>
                                	Job Context
                                </h5>
                                <ul v-html="form_data.jc_job_description">
                                	
                                </ul>
                            </div>
                            <div class="job_des">
                                <h5>Job Responsibilities </h5>
                                <ul v-html="form_data.jc_job_responsibility">
                                </ul>
                            </div>
                            <div class="job_nat">
                                <h5>
                                    Employment Status
                                </h5>
                        
                                <p v-if="form_data.jc_job_nature==1">
                                    {{'Full Time'}}
                                </p>
                                <p v-if="form_data.jc_job_nature==2">
                                    {{'Half Time'}}
                                </p>
                                <p v-if="form_data.jc_job_nature==3">
                                    {{'Contractual'}}
                                </p>
                            </div>
                            <div class="edu_req">
                                <h5>Educational Requirements</h5>
                                <ul >
                                    <li v-html="form_data.jc_educational_requirements"></li>
                                    
                                </ul>
                            </div>
                            <div class="edu_req">
                                <h5>Experience Requirements</h5>
                                <ul>
                                   	<li v-html="form_data.jc_experience_requirements"></li>
                                </ul>
                            </div>
							<div class="job_req">
								<h5>
								    Additional Requirements
								</h5>
								<ul v-html="form_data.jc_job_requirements">
                                </ul>
							</div>	
                            <div class="job_loc " style="line-height: 24px;">
                                <h5>Job Location</h5>
                                <p>{{form_data.work_location_name}}</p>
                            </div>
                            <div class="salary_range">
                                <h5>Salary</h5>
                                <ul>
                                	{{form_data.jc_salary_range}}
                                </ul>
                            </div>
                            <div class="oth_ben">
                                <h5>
                                    Compensation &amp; Other Benefits
                                </h5>

                                <ul v-html="form_data.jc_other_benefits">
                                </ul>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="guide text-center ">                               
	                    <div class="rba">
	                        <h4>
	                            Read Before Apply
	                        </h4>
	                        <div class="rba-title-divider-l"></div>	                       
	                    </div>
                        <div class="pho-txt">
                            <h4>
                                <span class="red">*Photograph</span> must be enclosed with the resume. 
                            </h4>	 	                                 
                        </div>
	                    <div class="apto">
	                        <h3>
	                        Apply Procedure
	                        </h3>
	                    </div>
	                        <div class="apply text-center">
	                            <a class="btn btn-success" href="#oappm" data-toggle="modal" data-target="#appliTermsModal" onclick="CreateHTMLPopup_new('FLORA LIMITED', 1, 915528)">Apply Online</a>
	                        </div>                                                     
	                    <br>  
	                    <div>
	                        <span class="date">
	                            Application Deadline : <strong>{{form_data.jc_circular_expired_date}}</strong>
	                        </span>
	                    </div>
	            	</div>
            	</div>
          	</div>
    	</div>
        <div v-if="!modal_loading">
            <pageLoading></pageLoading>
        </div>
    </modal>
	<div v-if="!page_loading">
	    <pageLoading></pageLoading>
	</div>
</div>
</template>


<script>
    import Loading from '../Loading.vue';
    import Datepicker from 'vuejs-datepicker';

    export default {
        data(){
          return{
            sbu_name_value:'',
            section_value:'',
            sub_unit_value:'',
            work_location_value:'',
            department_name_value:'',
            designation_name_value:'',
            jobgrade_name_value:'',
            employee_name_value:'',
            sub_unit_value:'',
            work_location_value:'',
            uri :'data:application/vnd.ms-excel;base64,',
                  template:'<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
                  base64: function(s){ return window.btoa(unescape(encodeURIComponent(s))) },
                  format: function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) },
          }
        },
        created(){
            this.getResults(1);
        },
        components:{
            pageLoading:Loading
        },

        methods:{
          tableToExcel(table, name){
                if (!table.nodeType) table = this.$refs.table
                var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
                window.location.href = this.uri + this.base64(this.format(this.template, ctx))
              },
          employeesSbu(option){
            console.log(option);
            this.form_data.employee_sbu= option.id;
            console.log(this.form_data.employee_sbu);
          },
          employeesSection(option){
            console.log(option);
            this.form_data.employee_section= option.id;
            console.log(this.form_data.employee_section);
          },
          employeesSubUnit(option){
            console.log(option);
            this.form_data.employee_sub_unit= option.id;
            console.log(this.form_data.employee_sub_unit);
          },
          employeesWorkLocation(option){
            console.log(option);
            this.form_data.employee_work_location= option.id;
            console.log(this.form_data.employee_work_location);
          },
          onSelectDepartment(option){
            console.log(option);
            this.form_data.employee_department= option.id;
            console.log(this.form_data.employee_department);
          },
          onSelectDesignation(option){
            console.log(option);
            this.form_data.employee_designation= option.id;
            console.log(this.form_data.employee_designation);
          },
          onSelectJobGrade(option){
            console.log(option);
            this.form_data.employee_job_grade= option.id;
            console.log(this.form_data.employee_job_grade);
          },
          onSelectEmployee(option){
            console.log(option);
            this.form_data.employee_reporting_to= option.id;
            console.log(this.form_data.employee_reporting_to);
          },
          onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
                
            },
          createImage(file) {
              let reader = new FileReader();
              let vm = this;
              reader.onload = (e) => {
                  this.form_data.employee_image = e.target.result;
              };
              reader.readAsDataURL(file);
          },
          setModalData(){
            this.sbu_name_value=this.form_data.sbu_name_value;
            this.section_value=this.form_data.section_value;
            this.department_name_value=this.form_data.department_name_value;
            this.designation_name_value=this.form_data.designation_name_value;
            this.jobgrade_name_value=this.form_data.jobgrade_name_value;
            this.sub_unit_value=this.form_data.sub_unit_value;
            this.employee_name_value=this.form_data.employee_name_value;
            this.work_location_value=this.form_data.work_location_value;
          },
          resetModal(){
            this.sbu_name_value='';
            this.section_value='';
            this.department_name_value='';
            this.designation_name_value='';
            this.jobgrade_name_value='';
            this.sub_unit_value='';
            this.employee_name_value='';
            this.work_location_value='';;
          },
        }

       
    }

   
</script>
<style type="text/css">
	.norm-jobs-wrapper {
	    background: #FBFBFB;
	    border: 1px solid #d5d5d5;
	    cursor: pointer;
	    padding: 5px 18px 15px 10px;
	    margin: 0px 0px 5px 0px;
	    border-radius: 8px;
	    color: #656565;
	}
	.norm-jobs-wrapper .col-sm-push-3 {
	    left: 75%;
	}	  	
	.norm-jobs-wrapper .col-sm-pull-9 {
	    right: 25%;
	}
	.job-title-text {
	    color: #43A047;
	    font-weight: bold;
	    margin: 10px 0px 0px 10px;
	    font-size: 18px;
	}
	.comp-name-text {
	    margin: 5px 0px 5px 10px;
	    font-size: 14px;
	    font-weight: bold;
	    color: #333333;
	}
	.locon-text {
	    margin: 5px 0px 0px 10px;
	}
	.edu-text {
	    margin: 5px 0px -3px 10px;
	}
	.edu-text-d {
	    margin: 0px;
	}
	.edu-text-d img {
	    width: 18px;
	    height: 18px;
	    vertical-align: top !important;
	    float: left;
	}
	.job-title-text a:visited {
	    color: #551a8b;
	}
	.job-title-text a {
	    text-decoration: none;
	    color: #348334;
	}
	.locon-text-d img {
	    width: 18px;
	    height: 18px;
	    margin-right: 7px;
	    float: left;
	}
	.edu-text-d ul {
	    list-style: none;
	    padding-left: 0px;
	}
	.norm-jobs-wrapper:hover {
	    background: #F5F5F5;
	    cursor: pointer;
	    -webkit-box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16);
	    -moz-box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16);
	    box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16);
	}
	.job-circular-list .table td, .table th {
	    padding: 0px;
	}
</style>