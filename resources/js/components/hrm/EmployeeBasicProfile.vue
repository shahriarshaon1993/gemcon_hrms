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
											<div class="row">
												<div class="col-md-12">
												  <button id="btnExport"  @click="tableToExcel" class="btn-success float-right" style="margin-left:10px;">Export</button>
												  <button @click="printDiv()" class="btn-info float-right">Print</button>
												</div>
											</div>
											<div class="col-md-12" style="margin-bottom:30px;">
												<h2 class="text-center" style="font-size:20px; font-weight: bold">Gemcon Group</h2>
												<h6 class="text-center"><span style="border-bottom: 1px solid #a1a1a1;">Employee Profile Information</span></h6>
											</div>
											<div class="row employee-details-info" id="printable">
												<div class="col-md-12">
													<div class="row profile-header" style="width: 100%; margin: auto; margin-bottom: 5px;">
                                                        <div class="col-md-4" style="float:left; width:40% !important;">
                                                            <samp v-if="employee_info.sbu_logo">
																<img :src="`company_logo/${employee_info.sbu_logo}`" class="card-img-top border rounded"
																  style="
																	margin-top: 2px;
																	width: 90px;
																	height: 68px;
																  " />
															</samp>
															<samp v-else>
															<img v-if="
																url !== '' ||
																employee_info.sbu_logo !== ''
															" :src="`/company_logo/group_company_logo.png`" class="card-img-top border rounded" style="
																margin-top: 2px;
																width: 90px;
																height: 68px;
																" />
															</samp>
                                                        </div>
                                                        <div class="col-md-4 text-center" style="float:left; width:45% !important;">
                                                            <h5><strong>Employee Profile</strong></h5>
                                                        </div>
                                                        <div class="col-md-4 text-right" >
                                                            <samp v-if="employee_info.employee_image">
																<img :src="`images/${employee_info.employee_image}`" class="card-img-top border rounded"
																  style="
																	margin-top: 2px;
																	width: 90px;
																	height: 100px;
																  " />
															</samp>
															<samp v-else>
															<img v-if="
																url !== '' ||
																employee_info.employee_image !== '' || employee_info.employee_image == ''
															" :src="`images/default.png`" class="card-img-top border rounded" style="
																margin-top: 2px;
																width: 90px;
																height: 100px;
																" />
															</samp>
                                                        </div>
													</div>
													<div class="row official-info" style="border: 2px solid;border-radius: 15px;margin: auto;">
														<div class="col-md-12 text-center official-info-div" style="text-align:center; background-color: rgb(18, 80, 191);color: rgb(255, 255, 255);border-radius: 15px;padding: 2px;font-size: 15px;">
															<strong>Official Information</strong>
														</div>
														<div class="col-md-12">
															<table class="table table-condensed table-responsive-sm" style="width: 98%; margin: auto;">
																<tbody>
																	<tr>
																		<td style="width: 35.5%;">Name</td>
																		<td style="width: 3.8%;"><strong>:</strong></td>
																		<td><strong>{{employee_info.employee_fullname}}</strong>
																		</td>
																	</tr>
																	<tr>
																		<td>ID</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{employee_info.employee_id_no}}</strong></td>
																	</tr>
																	<tr>
																		<td>Designation</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{employee_info.designation_name}}</strong></td>
																	</tr>
																	<tr>
																		<td>Department</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{employee_info.department_name}}</strong> </td>
																	</tr>
																	<tr>
																		<td>Company</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{employee_info.sbu_name}}</strong></td>
																	</tr>
																	<tr>
																		<td>Date of Joining</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{employee_joining_date}}</strong></td>
																	</tr>
																	<tr>
																		<td>Length of Service</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{service_length}}</strong></td>
																	</tr>
																	<tr>
																		<td>Present Salary</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{employee_present_salary}}</strong></td>
																	</tr>
																	<tr>
																		<td>One Off Bonus</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{one_off_bonus}}</strong></td>
																	</tr>
																	<tr>
																		<td>Last Promotion Date</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{last_promotion_date}}</strong></td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="row official-info" style="margin-top: 35px; border: 2px solid;border-radius: 15px;">
														<div class="col-md-12 text-center official-info-div" style="text-align:center; background-color: rgb(18, 80, 191);color: rgb(255, 255, 255);border-radius: 15px;padding: 2px;font-size: 15px;">
															<strong>Personal Information</strong>
														</div>
														<div class="col-md-12">
															<table class="table table-condensed table-responsive-sm" style="width: 98%; margin: auto;">
																<tbody>
																	<tr>
																		<td style="width: 35.5%;">Highest Education</td>
																		<td style="width: 3.8%;"><strong>:</strong></td>
																		<td><strong>{{highest_educstion}}</strong>
																		</td>
																	</tr>
																	<tr>
																		<td style="padding-left:20px;">Bachelor Degree</td>
																		<td><strong>:</strong></td>
																		<td><strong></strong></td>
																	</tr>
																	<tr>
																		<td style="padding-left:20px;">HSC/Alim</td>
																		<td><strong>:</strong></td>
																		<td><strong></strong></td>
																	</tr>
																	<tr>
																		<td style="padding-left:20px;">SSC/Dakhil</td>
																		<td><strong>:</strong></td>
																		<td><strong></strong></td>
																	</tr>
																	<tr>
																		<td>Professional Degree</td>
																		<td><strong>:</strong></td>
																		<td><strong></strong></td>
																	</tr>
																	<tr>
																		<td>Home District</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{permanent_district.name}}</strong> </td>
																	</tr>
																	<tr>
																		<td>Residence Area</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{present_thana.name}}</strong></td>
																	</tr>
																	<tr>
																		<td>Date of Birth</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{employee_birthday}}</strong></td>
																	</tr>
																	<tr>
																		<td>Age on Today</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{employee_age}}</strong></td>
																	</tr>
																	<tr>
																		<td>Marital Status</td>
																		<td><strong>:</strong></td>
																		<td>
																			<strong v-if="personal_infos.employee_marital_status==1">{{'Female'}}</strong>
																			<strong v-if="personal_infos.employee_marital_status==2">{{'Male'}}</strong>
																			<strong v-if="personal_infos.employee_marital_status==3">{{'Others'}}</strong>
																		</td>
																	</tr>
																	<tr>
																		<td>Child</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{personal_infos.employee_children_no}}</strong></td>
																	</tr>
																	<tr>
																		<td>NID</td>
																		<td><strong>:</strong></td>
																		<td>
																			<strong v-if="identification_supporting">{{identification_supporting.nid_number}}</strong>
																			<strong v-else>{{''}}</strong>
																		</td>
																	</tr>
																	<tr>
																		<td>Blood Group</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{personal_infos.employee_blood_group}}</strong></td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="row official-info" style="margin-top: 35px; border: 2px solid;border-radius: 15px;">
														<div class="col-md-12 text-center official-info-div" style="text-align:center; background-color: rgb(18, 80, 191);color: rgb(255, 255, 255);border-radius: 15px;padding: 2px;font-size: 15px;">
															<strong>Contact Information</strong>
														</div>
														<div class="col-md-12">
															<table class="table table-condensed table-responsive-sm" style="width: 98%; margin: auto;">
																<tbody>
																	<tr>
																		<td style="width: 35.5%;">Mobile No.</td>
																		<td style="width: 3.8%;"><strong>:</strong></td>
																		<td><strong>{{employee_info.employee_mobile}}</strong>
																		</td>
																	</tr>
																	<tr>
																		<td>Email Address</td>
																		<td><strong>:</strong></td>
																		<td><strong>{{personal_infos.employee_email}}</strong></td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
                                                </div>
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
				employee_joining_date:'',
				service_length:'',
				employee_present_salary:'',
				one_off_bonus:'',
				last_promotion_date:'',
				highest_educstion:'',
				permanent_district:'',
				present_thana:'',
				employee_birthday:'',
				employee_age:'',
				nid_number:'',
				url:'',
				printObj: {
					id: "printMe",
					popTitle: "good print",
					extraCss: "https://www.google.com,https://www.google.com",
					extraHead: '<meta http-equiv="Content-Language"content="zh-cn"/>',
				},
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
					this.employee_joining_date =res.data.employee_joining_date;
					this.service_length =res.data.service_length;
					this.employee_present_salary =res.data.employee_present_salary;
					this.one_off_bonus =res.data.one_off_bonus;
					this.last_promotion_date =res.data.last_promotion_date;
					this.highest_educstion = res.data.highest_educstion;
					this.permanent_district = res.data.permanent_district; 
					this.present_thana = res.data.present_thana;
					this.employee_birthday = res.data.employee_birthday; 
					this.employee_age = res.data.employee_age; 
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

			printDiv() {
				$("h3").each(function () {
					this.style.setProperty("margin", "0px", "important");
					this.style.setProperty("font-size", "1.75rem", "important");
				});
				$("h4").each(function () {
					this.style.setProperty("margin", "0px", "important");
					this.style.setProperty("font-size", "1.5rem", "important");
				});
				$("h5").each(function () {
					this.style.setProperty("margin", "0px", "important");
					this.style.setProperty("font-size", "1.25rem", "important");
				});
				$("h6").each(function () {
					this.style.setProperty("margin", "0px", "important");
					this.style.setProperty("font-size", "1rem", "important");
				});
				$(".table-bordered").each(function () {
					this.style.setProperty("border", "1px solid #dee2e6", "important");
					this.style.setProperty("padding", "5px .75rem", "important");
					this.style.setProperty("border-collapse", "collapse", "important");
				});
				$(".ths").each(function () {
					this.style.setProperty("border", "1px solid #dee2e6", "important");
					this.style.setProperty("padding", "5px 5px", "important");
					this.style.setProperty("border-collapse", "collapse", "important");
				});
				let contents = document.getElementById("printable").innerHTML;

				let frame1 = document.createElement("iframe");
				frame1.name = "frame1";
				frame1.style.position = "absolute";
				frame1.style.top = "-1000000px";
				document.body.appendChild(frame1);
				let frameDoc = frame1.contentWindow
					? frame1.contentWindow
					: frame1.contentDocument.document
					? frame1.contentDocument.document
					: frame1.contentDocument;
				frameDoc.document.open();
				frameDoc.document.write(
					'<html lang="en"><head><title>Gemcon Group</title>'
				);
				frameDoc.document.write(
					'<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.0.0-alpha/fullcalendar.print.min.css"/>'
				);
				frameDoc.document.write("</head><body>");
				frameDoc.document.write(contents);
				frameDoc.document.write("</body></html>");
				frameDoc.document.close();
				setTimeout(function () {
					window.frames["frame1"].focus();
					window.frames["frame1"].print();
					document.body.removeChild(frame1);
				}, 500);
				return false;
			},
			tableToExcel() {
				$("h3").each(function () {
					this.style.setProperty("margin", "0px", "important");
					this.style.setProperty("font-size", "1.75rem", "important");
				});
				$("h4").each(function () {
					this.style.setProperty("margin", "0px", "important");
					this.style.setProperty("font-size", "1.5rem", "important");
				});
				$("h5").each(function () {
					this.style.setProperty("margin", "0px", "important");
					this.style.setProperty("font-size", "1.25rem", "important");
				});
				$("h6").each(function () {
					this.style.setProperty("margin", "0px", "important");
					this.style.setProperty("font-size", "1rem", "important");
				});
			
				$(".table-bordered").each(function () {
					this.style.setProperty("border", "1px solid #dee2e6", "important");
					this.style.setProperty("padding", "5px .75rem", "important");
					this.style.setProperty("border-collapse", "collapse", "important");
				});
				$(".ths").each(function () {
					this.style.setProperty("border", "1px solid #dee2e6", "important");
					this.style.setProperty("padding", "5px 5px", "important");
					this.style.setProperty("border-collapse", "collapse", "important");
				});
				var uri = "data:application/vnd.ms-excel;base64,",
					template =
					'<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
					base64 = function (s) {
					return window.btoa(unescape(encodeURIComponent(s)));
					},
					format = function (s, c) {
					return s.replace(/{(\w+)}/g, function (m, p) {
						return c[p];
					});
					};

				var toExcel = document.getElementById("printable").innerHTML;
				var ctx = {
					worksheet: name || "",
					table: toExcel,
				};
				var link = document.createElement("a");
				link.download = "export.xls";
				link.href = uri + base64(format(template, ctx));
				link.click();
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
.official-info{
	width: 60% !important;
	border: 2px solid;
    border-radius: 15px;
	margin: auto;
}
.profile-header{
	width: 60% !important;
}
/* .official-info-div{
	background-color: rgb(18, 80, 191);
    color: rgb(255, 255, 255);
    border-radius: 15px;
    padding: 2px;
    font-size: 15px;
} */
@media print {
    .official-info-div {
        background: rgb(18, 80, 191);
		print-color-adjust: exact;
    }
}
.employee-details-info .table td, .table th {
    border: 1px solid #ffffff;
	padding: 5px;
}

</style>
