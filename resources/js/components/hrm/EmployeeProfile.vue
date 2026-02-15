<template>
	<div>
		<div v-if="page_loading" class="widget box">
			<div class="widget-header">
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="row">
											<div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
												<h3 class="card-title d-none d-md-block text-center">Employee Profile</h3>
												<span class="float-sm-right" style="float: right;">
													<a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
												</span>
											</div>
										</div>
									</div>
									<div class="card-body">
										<div id="page-wrapper">
											<h2 class="text-center" style="font-size:20px; font-weight: bold">Gemcon Group</h2>
											<h6 class="text-center"><span style="border-bottom: 1px solid #a1a1a1;">Employee Information Form</span></h6>
											<div class="row employee-details-info">
												<table class="table table-condensed table-responsive-sm ">
													<p style="margin-bottom: 0px;">Employment Information </p>
													<tbody>
														<tr>
															<td>Employee Name</td>
															<td colspan="3"><strong>
																{{employee_info.employee_fullname}}
															   </strong>
														    </td>
															<td>ID</td>
															<td><strong>{{employee_info.employee_id_no}}</strong></td>
														</tr>
														<tr>
															<td>Designation</td>
															<td colspan="2"><strong>{{employee_info.designation_name}}</strong></td>
															<td>Job Grade</td>
															<td colspan="2"><strong>{{employee_info.jobgrade_name}}</strong></td>
														</tr>
														<tr>
															<td>Department</td>
															<td colspan="2"><strong>{{employee_info.department_name}}</strong> </td>
															<td>SBU</td>
															<td colspan="2"><strong>{{employee_info.sbu_name}}</strong></td>
														</tr>
														<tr>
															<td>Interview Date</td>
															<td><strong>{{employee_info.employee_interview_date}}</strong> </td>
															<td>Appoinment Date</td>
															<td><strong>{{employee_info.employee_appoinment_date}}</strong></td>
															<td>Joining Date</td>
															<td><strong>{{employee_info.employee_joining_date	}}</strong></td>
														</tr>
														<tr>
															<td>Work Location</td>
															<td><strong>{{employee_info.work_location_name}}</strong> </td>
															<td>Supervisor's Name</td>
															<td><strong>{{employee_info.employee_fullname}}</strong></td>
															<td>Designation</td>
															<td><strong>{{employee_info.designation_name}}</strong></td>
														</tr>
													</tbody>
												</table>
												<table v-if="personal_infos!=null" class="table table-condensed table-responsive-sm ">
													<p style="margin-bottom: 0px;">Personal Information </p>
													<tbody>
														<tr>
															<td>NID Certificate Name</td>
															<td colspan="2"><strong>{{personal_infos.employee_nid_name}}</strong></td>
															<td>Nick Name</td>
															<td colspan="2"><strong>{{personal_infos.employee_nick_name}}</strong></td>
														</tr>
														<tr>
															<td>Father's Name</td>
															<td colspan="2"><strong>{{personal_infos.employee_father_name}}</strong></td>
															<td>Mother's Name</td>
															<td colspan="2"><strong>{{personal_infos.employee_mother_name}}</strong></td>
														</tr>
														<tr>
															<td>Marital Status</td>
															<td><strong>{{personal_infos.employee_marital_status}}</strong> </td>
															<td>Marriage Date</td>
															<td><strong>{{personal_infos.employee_marriage_date}}</strong></td>
															<td>Spouse Name</td>
															<td><strong>{{personal_infos.employee_spouse_name}}</strong></td>
														</tr>
														<tr>
															<td>No. of Children</td>
															<td><strong>{{personal_infos.employee_children_no}}</strong> </td>
															<td>Date of Birth(Certificate)</td>
															<td><strong>{{personal_infos.employee_dob_certificate}}</strong></td>
															<td>Date of Birth(Actual)</td>
															<td><strong>{{personal_infos.employee_dob_actual}}</strong></td>
														</tr>
														<tr>
															<td>Nationality</td>
															<td colspan="2"><strong>{{personal_infos.employee_nationality}}</strong> </td>
															<td>Religion</td>
															<td colspan="2"><strong>{{personal_infos.employee_religion}}</strong></td>
														</tr>
														<tr>
															<td>Blood Group</td>
															<td><strong>{{personal_infos.employee_blood_group}}</strong> </td>
															<td>Height(feet/inch)</td>
															<td><strong>{{personal_infos.employee_height}}</strong></td>
															<td>Weight(kg)</td>
															<td><strong>{{personal_infos.employee_weight}}</strong></td>
														</tr>
														<tr>
															<td>Mobile No</td>
															<td colspan="2"><strong>{{personal_infos.employee_mobile}}</strong></td>
															<td>e-mail</td>
															<td colspan="2"><strong>{{personal_infos.employee_email}}</strong></td>
														</tr>
													</tbody>
												</table>
												<table v-if="address_info!=null" class="table table-condensed table-responsive-sm">
													<p style="margin-bottom: 0px;">Address Details</p>
													<tbody>
														<tr>
															<td colspan="3">Present Contact/Mailing/Residence</td>
															<td colspan="3">Permanent</td>
														</tr>
														<tr>
															<td>Holding No</td>
															<td colspan="2"><strong>{{address_info.present_holding_no}}</strong></td>
															<td>Holding No</td>
															<td colspan="2"><strong>{{address_info.permanent_holding_no}}</strong></td>
														</tr>
														<tr>
															<td>House Name</td>
															<td colspan="2"><strong>{{address_info.present_house_name}}</strong></td>
															<td>House Name</td>
															<td colspan="2"><strong>{{address_info.permanent_house_name}}</strong></td>
														</tr>
														<tr>
															<td>Road No.</td>
															<td colspan="2"><strong>{{address_info.present_road_no}}</strong></td>
															<td>Road No.</td>
															<td colspan="2"><strong>{{address_info.permanent_road_no}}</strong></td>
														</tr>
														<tr>
															<td>Road Name</td>
															<td colspan="2"><strong>{{address_info.present_road_name}}</strong></td>
															<td>Road Name</td>
															<td colspan="2"><strong>{{address_info.permanent_road_name}}</strong></td>
														</tr>
														<tr>
															<td>Vill. / Area</td>
															<td colspan="2"><strong>{{address_info.present_vill_area}}</strong></td>
															<td>Vill. / Area</td>
															<td colspan="2"><strong>{{address_info.permanent_vill_area}}</strong></td>
														</tr>
														<tr>
															<td>Ward No.</td>
															<td colspan="2"><strong>{{address_info.present_ward_no}}</strong></td>
															<td>Ward No.</td>
															<td colspan="2"><strong>{{address_info.permanent_ward_no}}</strong></td>
														</tr>
														<tr>
															<td>Union</td>
															<td colspan="2"><strong>{{address_info.present_union}}</strong></td>
															<td>Union</td>
															<td colspan="2"><strong>{{address_info.permanent_union}}</strong></td>
														</tr>
														<tr>
															<td>Post Office</td>
															<td colspan="2"><strong>{{address_info.present_post_office}}</strong></td>
															<td>Post Office</td>
															<td colspan="2"><strong>{{address_info.permanent_post_office}}</strong></td>
														</tr>
														<tr>
															<td>Thana</td>
															<td colspan="2"><strong>{{address_info.present_thana}}</strong></td>
															<td>Thana</td>
															<td colspan="2"><strong>{{address_info.permanent_thana}}</strong></td>
														</tr>
														<tr>
															<td>District</td>
															<td colspan="2"><strong>{{address_info.present_district}}</strong></td>
															<td>District</td>
															<td colspan="2"><strong>{{address_info.permanent_district}}</strong></td>
														</tr>
														<tr>
															<td>Mobile (2nd contact)</td>
															<td colspan="2"><strong>{{address_info.present_mobile_2nd}}</strong></td>
															<td>Mobile (3rd contact)</td>
															<td colspan="2"><strong>{{address_info.permanent_mobile_3rd}}</strong></td>
														</tr>
													</tbody>
												</table>
												<table  v-if="identification_supporting!=null" class="table table-condensed table-responsive-sm">
													<p style="margin-bottom: 0px;">Part 4: Identification Supporting</p>
													<tbody>
														<tr>
															<td class="text-center">ID Type</td>
															<td class="text-center">ID Number</td>
															<td class="text-center">Issue/ Renew Date</td>
															<td class="text-center">Date of Expiry</td>
														</tr>
														<tr>
															<td>National ID Card</td>
															<td>
																<strong>{{identification_supporting.nid_number}}</strong> 
															</td>
															<td>
																<strong>{{identification_supporting.nid_issue_renew_date}}</strong> 
															</td>
															<td>
																<strong>{{identification_supporting.nid_expiry_date}}</strong> 
															</td>
														</tr>
														<tr>
															<td>Passport</td>
															<td>
																<strong>{{identification_supporting.passport_number}}</strong>
															</td>
															<td>
																<strong>{{identification_supporting.passport_issue_renew_date}}</strong> 
															</td>
															<td>
																<strong>{{identification_supporting.passport_expiry_date}}</strong> 
															</td>
														</tr>
														<tr>
															<td>Driving License</td>
															<td>
																<strong>{{identification_supporting.driving_license_number}}</strong>
															</td>
															<td>
																<strong>{{identification_supporting.driving_license_issue_renew_date}}</strong> 
															</td>
															<td>
																<strong>{{identification_supporting.driving_license_expiry_date}}</strong> 
															</td>
														</tr>
														<tr>
															<td>TIN</td>
															<td>
																<strong>{{identification_supporting.tin_number}}</strong>
															</td>
															<td>
																<strong>{{identification_supporting.tin_issue_renew_date}}</strong> 
															</td>
															<td>
																<strong>{{identification_supporting.tin_expiry_date}}</strong> 
															</td>
														</tr>
														<tr>
															<td>Birth Certificate</td>
															<td>
																<strong>{{identification_supporting.birth_cer_number}}</strong>
															</td>
															<td>
																<strong>{{identification_supporting.birth_cer_issue_renew_date}}</strong> 
															</td>
															<td>
																<strong>{{identification_supporting.birth_cer_expiry_date}}</strong> 
															</td>
														</tr>
													</tbody>
												</table>
												<table v-if="educational_infos!=null" class="table table-condensed table-responsive-sm">
													<p style="margin-bottom: 0px;">Part 5: Educational Qualification</p>                                        
													<tbody>
														<tr>
															<td rowspan="2">Name of Degree</td>             
															<td rowspan="2">Major/ Group</td>               
															<td rowspan="2">Name of Institute</td>   
															<td rowspan="2">Board/ University</td>   
															<td colspan="2">Session</td>   
															<td rowspan="2">Passing Year</td>   
															<td rowspan="2">Division/GPA (out of scale)</td>  
														</tr>
														<tr>         
															<td>From</td>   
															<td>To</td>     
														</tr>
														<tr v-for="(educational_info, index) in educational_infos">
															<td> 
																<strong>{{educational_info.eeq_degree_name}}</strong>
															</td> 
															<td> 
																<strong>{{educational_info.eeq_major_group}}</strong>
															</td> 
															<td> 
																<strong>{{educational_info.eeq_institute_name}}</strong>
															</td>                                                                       
															<td> 
																<strong>{{educational_info.eeq_board_university}}</strong> 
															</td>                                                                       
															<td>
																<strong>{{educational_info.eeq_session_from}}</strong>
															</td>
															<td>
																<strong>{{educational_info.eeq_session_to}}</strong>
															</td>
															<td>
																<strong>{{educational_info.eeq_passing_year}}</strong>
															</td>
															<td>
																<strong>{{educational_info.eeq_division_gpa}}</strong>
															</td>
														</tr>
													</tbody>
												</table>
												<table v-if="professional_infos!=null" class="table table-condensed table-responsive-sm">
													<p style="margin-bottom: 0px;">Part 6: Professional Qualification</p>                                        
													<tbody>
														<tr>
															<td rowspan="2">Course Title</td>           
															<td  rowspan="2">Name of Institute</td>   
															<td rowspan="2">Location</td>   
															<td colspan="2">Duration</td>   
															<td rowspan="2">Result</td>    
														</tr>
														<tr>         
															<td>From</td>   
															<td>To</td>     
														</tr>
														<tr v-for="(professional_info, index) in professional_infos">
															<td> 
																<strong>{{professional_info.pq_course_title}}</strong>
															</td> 
															<td> 
																<strong>{{professional_info.pq_institute_name}}</strong> 
															</td>                                                                       
															<td> 
																<strong>{{professional_info.pq_location}}</strong> 
															</td>                                                                       
															<td>
																<strong>{{professional_info.pq_duration_from}}</strong>
															</td>
															<td>
																<strong>{{professional_info.pq_duration_to}}</strong>
															</td>
															<td>
																<strong>{{professional_info.pq_result}}</strong>
															</td>
														</tr>
													</tbody> 
												</table>
												<table v-if="employment_history!=null" class="table table-condensed table-responsive-sm">
													<p style="margin-bottom: 0px;">Part 6: Employment History</p>                                      
												    <tbody>
												    	<tr>
												    	    <td>Job Title/ Position Held<span class="required_sign">*</span></td>           
												    	    <td >Name of Organization</td>   
												    	    <td>Industry Type</td>   
												    	    <td>From </td>   
												    	    <td>To </td>   
												    	    <td>Lengtd of Service</td>    
												    	</tr>
												        <tr v-for="(employment_history, index) in employment_history"> 
												            <td> 
												               <strong>{{employment_history.eeh_job_title}}</strong>  
												            </td> 
												            <td> 
												               <strong>{{employment_history.eeh_organization_name}}</strong>  
												            </td>                              
												            <td> 
												               <strong>{{employment_history.eeh_industry_type}}</strong>  
												            </td>                               
												            <td>
												               <strong>{{employment_history.eeh_duration_from}}</strong>  
												            </td>
												            <td>
												               <strong>{{employment_history.eeh_duration_to}}</strong>  
												            </td>
												            <td>
												               <strong>{{employment_history.eeh_service_length}}</strong>  
												            </td>
												        </tr>
												    </tbody> 
												</table>
												<table v-if="family_details!=null" class="table table-condensed table-responsive-sm">
													<p style="margin-bottom: 0px;">Part 7: Family Details</p>
								                        <tbody>
								                        	<tr>
								                        	    <td>Family Member’s Name</td>           
								                        	    <td >Relationship</td>   
								                        	    <td>Date of Birtd</td>   
								                        	    <td>Occupation </td>   
								                        	    <td>Contact Mobile No. </td> 
								                        	</tr>
								                            <tr valign="top" class="tr_clone" v-for="(family_details, index) in form_data.family_details">
								                                <td>
																	<strong>{{family_details.efd_family_member_name}}</strong>
																</td> 
								                                <td>
																	<strong>{{family_details.efd_family_member_name}}</strong>
																</td>                              
								                                <td>
																	<strong>{{family_details.efd_date_of_birth}}</strong>
																</td>                               
								                                <td>
																	<strong>{{family_details.efd_occupation}}</strong>
																</td>
								                                <td>
																	<strong>{{family_details.efd_contact_mobile_no}}</strong>
																</td>
								                            </tr>
								                        </tbody>  
												</table>
												<table v-if="training_records!=null" class="table table-condensed table-responsive-sm">
													<p style="margin-bottom: 0px;">Part 8: Training Record</p> 
			                                            <tbody>
			                                            	<tr>
			                                            	    <td rowspan="2">Training Title</td>           
			                                            	    <td  rowspan="2">Name of Training Institute </td>   
			                                            	    <td colspan="2">Duration </td>   
			                                            	    <td rowspan="2">Nominated/ Sponsored by </td>   
			                                            	    <td rowspan="2">Certificate Received</td>    
			                                            	</tr>
			                                            	<tr>         
			                                            	    <td>From</td>   
			                                            	    <td>To</td>     
			                                            	</tr>
			                                                <tr valign="top" class="tr_clone" v-for="(training_records, index) in training_records">
			                                                    <td>
																	<strong>{{training_records.etr_training_title}}</strong>
																</td>
			                                                    <td>
																	<strong>{{training_records.etr_institute_name}}</strong>
																</td>                                                                      
			                                                    <td>
																	<strong>{{training_records.etr_duration_from}}</strong>
																</td>
			                                                    <td>
																	<strong>{{training_records.etr_duration_to}}</strong>
																</td>
			                                                    <td>
																	<strong>{{training_records.etr_sponsored_by}}</strong>
																</td> 
			                                                    <td>
																	<strong>{{training_records.etr_certificate_received}}</strong>
																</td>
			                                                </tr>
			                                            </tbody>  
												</table>
												<table v-if="professinal_memberships!=null" class="table table-condensed table-responsive-sm">
													<p style="margin-bottom: 0px;">Part 9: Professional Membership / Affiliation</p>
													<tbody>
														<tr>
														    <td>Membership Title</td>           
														    <td >Name of tde Membership Organization</td>   
														    <td>Obtained On </td>   
														    <td>Valid Up to</td>     
														</tr>
                                                        <tr valign="top" class="tr_clone" v-for="(professinal_memberships, index) in professinal_memberships">
                                                            <td>
																<strong>{{professinal_memberships.epm_membership_title}}</strong>
															</td> 
                                                            <td>
																<strong>{{professinal_memberships.epm_organization_name}}</strong>
															</td>                                                                       
                                                            <td>
																<strong>{{professinal_memberships.epm_obtained_on}}</strong>
															</td>
                                                            <td>
																<strong>{{professinal_memberships.epm_valid_upto}}</strong>
															</td>
                                                        </tr>
	                                                    </tbody> 
												</table>
												<table v-if="bank_accounts!=null" class="table table-condensed table-responsive-sm">
													<p style="margin-bottom: 0px;">Part 10: Bank Account Details</p>                                        
								                    <tbody>
								                    	<tr>
								                    	    <td>Bank Name</td>           
								                    	    <td >Branch Name & District</td>   
								                    	    <td>Name of Account Holder</td>   
								                    	    <td>Account Number</td> 
								                    	</tr>
								                        <tr valign="top" class="tr_clone" v-for="(bank_accounts, index) in bank_accounts">
								                            <td>
																<strong>{{bank_accounts.ebc_bank_name}}</strong>
															</td>
															<td>
																<strong>{{bank_accounts.ebc_branch_district}}</strong>
															</td>
															<td>
																<strong>{{bank_accounts.ebc_ac_holder_name}}</strong>
															</td>
															<td>
																<strong>{{bank_accounts.ebc_account_number}}</strong>
															</td>
								                        </tr>
								                    </tbody> 
												</table>
												<table v-if="emergency_contacts!=null" class="table table-condensed table-responsive-sm">
													<p style="margin-bottom: 0px;">Part 11: Emergency Contact Person</p>                    
				                                        <tbody>
				                                        	<tr>
				                                        	    <td>Name</td>           
				                                        	    <td >Relationship</td>   
				                                        	    <td>Present Address</td>   
				                                        	    <td>Mobile No</td>     
				                                        	</tr>
				                                            <tr valign="top" class="tr_clone" v-for="(form_data, index) in emergency_contacts">
				                                                <td>
																	<strong>{{emergency_contacts.eec_name}}</strong>
																</td>
																<td>
																	<strong>{{emergency_contacts.eec_relationship}}</strong>
																</td>
																<td>
																	<strong>{{emergency_contacts.eec_relationship}}</strong>
																</td>
																<td>
																	<strong>{{emergency_contacts.eec_mobile_no}}</strong>
																</td>
				                                            </tr>
				                                        </tbody>  
												</table>
											</div>
											<div class="row">

											</div>
										</div>
									</div>
								</div>
								<div v-if="!page_loading">
									<pageLoading></pageLoading>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</template>
<script>
	import Loading from '../Loading.vue';
	import Datepicker from 'vuejs-datepicker';
	export default {
		data(){
			return{
				employeeId: null,
				employee_info:'',
				personal_infos:'',
				professional_infos:'',
				address_info:'',
				identification_supporting:'',
				educational_infos:'',
				employment_history:'',
				family_details:'',
				training_records:'',
				professinal_memberships:'',
				bank_accounts:'',
				emergency_contacts:'',
			}
		},
		created(){
			this.getResults(1);
			this.getList();
		},
		components:{
			pageLoading:Loading
		},

		methods:{
			getList(){
				let uri = URL.baseUrl('employees/profileDetails/'+this.$route.params.employeeId);
				console.log(uri);
				axios.get(uri)
				.then(res => {
					console.log(res.data);
					this.employee_info =res.data['employee_info'];
					this.personal_infos =res.data['personal_infos'];
					this.professional_infos =res.data['professional_infos'];
					this.address_info =res.data['address_info'];
					this.identification_supporting =res.data['identification_supporting'];
					this.educational_infos =res.data['educational_infos'];
					this.employment_history =res.data['employment_history'];
					this.family_details =res.data['family_details'];
					this.training_records =res.data['training_records'];
					this.professinal_memberships =res.data['professinal_memberships'];
					this.bank_accounts =res.data['bank_accounts'];
					this.emergency_contacts =res.data['emergency_contacts'];
				})
				.catch(error => {
					this.showToster({status:0,message:'opps! something went wrong'});
				})
			},
}
};
</script>
<style type="text/css">
.employee-search .multiselect__tags {
	border-bottom: 0px solid #cfcfcf !important;
}
.employee-search .multiselect {
	height: 22px;
	width: 97%;
	padding-top: 4px;
	padding-left: 5px;
	padding-bottom: 4px;
}
.tab-content label:not(.form-check-label):not(.custom-file-label){
	margin-bottom: 0px !important;
}
.identification .vdp-datepicker input {
	border-bottom: none;
	height: 30px;
	padding-left:15px;
}
.professional_datepicker .vdp-datepicker input{
	height: 30px !important;
	border: none !important;
	padding-left: 15px !important;
}

.employee-details-info .table td, .table th {
	/*padding: .75rem;*/
	vertical-align: top;
	border-top: 1px solid #dee2e6;
	border: 1px solid #dee2e6;
}
</style>
