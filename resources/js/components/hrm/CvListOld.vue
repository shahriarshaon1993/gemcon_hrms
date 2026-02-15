<template>
  <div>
    <div v-if="page_loading" class="widget box">
      <div class="widget-header">
        <div >
          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="row">
                        <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                          <!-- <h3 class="card-title d-none d-md-block">All Candidate List: <span style="color:green;">{{paginate_data.data[0].designation_name}}</span></h3> -->
                          <span class="float-sm-right" style="float: right;">
                            <div class="btn-group" style="padding:0px;"> <span class="badge badge-warning"><i class="icon-plus"></i>
                              <router-link :to="'/interview-board-call/'" class="nav-link badge badge-warning">
                                <i class="fa fa-clipboard"> </i> Interview Board Call
                              </router-link>
                            </span></div>
                            <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                          </span>
                        </div>
                      </div>

                      <div class="col-md-12" style="margin-bottom: 15px;">
                        <div class="row" style="border: 1px solid #ddd; padding:5px; border-radius: 5px; box-shadow: 0 0 1px #00000021, 0 1px 3px #00000033;">
                            <div class="form-group col-md-2" style="max-width: 16%;">
                               <label class="col-md-12 control-label">Gender</label>
                               <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                     <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                     <select class="form-control" v-model="form_data.candidate_gender" required="true">
                                        <option disabled>--Select--</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                        <option value="3">Others</option>
                                     </select>
                                  </div>
                               </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 16%;">
                               <label class="col-md-12 control-label">Age</label>
                               <div class="col-md-12 inputGroupContainer">
                                  <div class="col-md-6 float-left" style="padding: 0px;">
                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                     <input v-model="form_data.age_from" placeholder="Age From" class="form-control" type="number"></div>
                                  </div>
                                  <div class="col-md-6 float-left" style="padding: 0px;">
                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                     <input v-model="form_data.age_to" placeholder="Age To" class="form-control" type="number"></div>
                                  </div>
                               </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 16%;">
                               <label class="col-md-12 control-label">Designation</label>
                               <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                     <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                     <!-- <select class="form-control" v-model="form_data.candidate_designation" required="true">
                                        <option disabled>--Select--</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                     </select> -->
                                     <vue-select v-model="designation_name_value" :options="option_data.designation_data" @select="onSelectDesignation" placeholder="Select one" label="text" track-by="text"></vue-select>
                                  </div>
                               </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 16%;">
                               <label class="col-md-12 control-label">Experience</label>
                               <div class="col-md-12 inputGroupContainer">
                                  <div class="col-md-6 float-left" style="padding: 0px;">
                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                     <input v-model="form_data.experience_from" placeholder="From" class="form-control" type="number"></div>
                                  </div>
                                  <div class="col-md-6 float-left" style="padding: 0px;">
                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                     <input v-model="form_data.experience_to" placeholder="To" class="form-control" type="number"></div>
                                  </div>
                               </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 16%;">
                               <label class="col-md-12 control-label">Expected Salary</label>
                               <div class="col-md-12 inputGroupContainer">
                                  <div class="col-md-6 float-left" style="padding: 0px;">
                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                     <input v-model="form_data.salary_from" placeholder="From" class="form-control" type="number"></div>
                                  </div>
                                  <div class="col-md-6 float-left" style="padding: 0px;">
                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                     <input v-model="form_data.salary_to" placeholder="To" class="form-control" type="number"></div>
                                  </div>
                               </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 16%;">
                               <label class="col-md-12 control-label">Education</label>
                               <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group">
                                     <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                     <!-- <select class="form-control" v-model="form_data.candidate_education" required="true">
                                        <option disabled>--Select--</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                     </select> -->
                                     <vue-select v-model="highest_education_value" :options="option_data.highest_education" @select="onSelecthighest_education" placeholder="Select one" label="text" track-by="text"></vue-select>
                                  </div>
                               </div>
                            </div>
                            <div class="col-md-1 float-right" style="max-width: 4%; padding: 15px 0px;">
                              <a  @click="viewReportss11111(form_data,urls)" class="btn btn-xs " style="color: rgb(33, 37, 41) !important; background-color: rgb(250, 194, 60); border-color: rgb(250, 194, 60); width: 50px; height: 30px;">
                                <i class="fa fa-search" style="color: rgb(33, 37, 41) !important; background-color: rgb(250, 194, 60); border-color: rgb(250, 194, 60); margin-top: 7px;"></i>
                              </a>
                              <!-- <button style="border-radius: 5px; margin-right: -15px;padding: 5px 30px;"  @click="viewReportss11111(form_data,urls)" type="button" class="btn btn-info float-right">Search</button> -->
                            </div>
                        </div>
                      </div>
                      <div class="row nav nav-tabs">
                         <div class="cv-list-four-box col-12 col-sm-12 col-md-3 active" id="home-tab" data-toggle="tab" href="#applicant" role="tab" aria-controls="home" aria-selected="true">
                             <div class="info-box" style="cursor:pointer;">
                               <span class="info-box-icon bg-info elevation-1"><i class="fa fa-paper-plane"></i></span>
                               <div class="info-box-content">
                                 <span class="info-box-text">No. of Applicant</span>
                                 <span class="info-box-number">
                                   {{form_data.all_candidate_count}}
                                 </span>
                               </div>
                             </div>
                         </div>
                          <div class="cv-list-four-box col-12 col-sm-12 col-md-3 " id="profile-tab" data-toggle="tab" href="#shortlistTab" role="tab" aria-controls="profile" aria-selected="false">
                              <div class="info-box" style="cursor:pointer;">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text">Shortlisted</span>
                                  <span class="info-box-number">
                                    {{form_data.shortlist_candidate_count}}
                                  </span>
                                </div>
                              </div>
                          </div>
                          <div class="cv-list-four-box col-12 col-sm-12 col-md-3" id="contact-tab" data-toggle="tab" href="#selected" role="tab" aria-controls="contact" aria-selected="false">
                            <div class="info-box mb-3" style="cursor: pointer;">
                              <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-text">Selected</span>
                                <span class="info-box-number">{{form_data.selected_candidate_count }}</span>
                              </div>
                            </div>
                          </div>
                          <div class="clearfix hidden-md-up"></div>
                          <div class="cv-list-four-box col-12 col-sm-12 col-md-3" id="contact-tab" data-toggle="tab" href="#rejected" role="tab" aria-controls="contact" aria-selected="false">
                            <div class="info-box mb-3" style="cursor:pointer;">
                              <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-ban"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-text">Rejected</span>
                                <span class="info-box-number">{{form_data.rejected_candidate_count}}</span>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="loader"></div><!-- Loader -->
                    <div id="applicant-list" class="card-body" style="padding-top: 0px;">
                      <div class="tab-content" id="myTabContent" style="padding-top: 15px;">
                        <div class="tab-pane fade show active" id="applicant" role="tabpanel" aria-labelledby="home-tab">
                                <div class="col-md-6 col-sm-6 col-6 float-left">
                                    <div id="DataTables_Table_0_length" class="">
                                        Show
                                        <label>
                                            <select class="form-control pagination-number" @change="onChange($event)" v-model="paginate_num" name="pageSize">
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
                            <table ref="table" id="loremTable" summary="lorem ipsum sit amet" rules="groups" frame="hsides"  class="table table-striped employeeTable applicant_table" style=" border-collapse: separate;border-spacing: 0 20px; border-color:#fff;">
                                <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                                   <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
                                     <!-- {{form_data}} -->
                                        <td class="text-center " style="vertical-align: top;padding: 0px;top: 5px;">
                                          <span class="applicant_sl">{{order_no+index+1}}</span>
                                        </td>
                                        <td v-if="form_data.jac_image" class="text-left" style="vertical-align: middle;">
                                          <img :src="`${form_data.jac_image}`" class="card-img-top border rounded" style="width:100px; border-radius:50% !important">
                                        </td>
                                        <td v-if="!form_data.jac_image" class="text-left" style="vertical-align: middle;">
                                          <img :src="`admin_assets/images/candidate_default.png`" class="card-img-top border rounded" style="width:100px; border-radius:50% !important">
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div class="col-md-12">
                                              <p style="margin: 2px;font-size: 20px;font-weight: bold;color: #1e999e;" class="text-justify">
                                               {{form_data.jac_candidate_name}} <span style="border: 1px solid #1e99a1;border-radius: 5px;padding: 0px 10px;font-size: 16px;"> Age: {{calculateAge(form_data.jac_birth_day)}}</span>
                                              </p>
                                              <p style="margin: 2px;font-style: italic;font-size: 16px;color: #1e99a1;" class="text-justify">

                                                <i class="fa fa-map-marker"></i>
                                                {{form_data.jac_candidate_address}}

                                              </p>
                                              <p style="margin: 2px;font-size: 16px;color: #4a4a4a;font-weight: bold;" class="text-justify">
                                               {{form_data.jac_universitgy_name}}
                                              </p>
                                              <p style="margin: 2px;font-size: 16px;font-style: italic;" class="text-justify">
                                               {{form_data.jac_highest_education}}
                                              </p>
                                               <p style="font-size: 16px;margin: 2px;" class="text-justify">
                                                <i class="fa fa-phone"></i>
                                               {{form_data.jac_contact_no}}
                                              </p>
                                            </div>
                                        </td>
                                        <td class="text-center" style="vertical-align: top;">
                                          <div class="col-md-12">
                                            <p style="margin: 2px;font-size: 16px;" class="text-justify">
                                             {{form_data.jac_last_employment}}
                                            </p>
                                            <p style="margin: 2px;" class="text-justify">
                                              {{form_data.jac_last_designation}}

                                            </p>

                                             <p style="font-size: 16px;margin: 2px;" class="text-justify">
                                              <a download title="Download CV" target="_blank" :href="form_data.jac_cv" style="color: #1e99a1;"><i class="fa fa-download"></i> Download CV</a>
                                            </p>
                                          </div>
                                        </td>

                                        <td class="text-center" style="vertical-align: top;">
                                          <div class="col-md-12">
                                            <p style="margin: 2px;font-size: 16px;" class="text-justify">
                                              <i class="fa fa-history"></i>
                                             {{form_data.jac_last_experience}}
                                            </p>
                                            <p style="margin: 2px;" class="text-justify">
                                            <i class="fa fa-usd"></i>
                                              {{form_data.jac_expected_salary}}

                                            </p>

                                             <p style="font-size: 16px;margin: 2px;" class="text-justify">
                                              <span style="vertical-align: middle; text-align: center;" v-if="form_data.jac_status==1">
                                                Applied
                                                </span>
                                                <span style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==2">
                                                    Shortlisted <br>
                                                    <p style="color:orange; text-align: left;" v-if="form_data.jac_email_send_status==2">Email not sent!</p>
                                                    <p style="color:green;font-weight: bold; text-align: left;" v-if="form_data.jac_email_send_status==1">Email sent!</p>
                                                </span>
                                                <span style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==3">Selected</span>
                                                <span style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==4">Rejected</span>
                                                <span style="vertical-align: middle; text-align: center;" v-else>Applied</span>
                                            </p>
                                          </div>
                                        </td>

                                        <td style="padding: 10px; text-align: center; width: 20%" class="text-center">
                                          <div class="row">
                                            <div class="col-md-12">
                                            <span v-if="form_data.jac_status==2 && form_data.jac_email_send_status==2">
                                              <div class="col-md-4 float-left">
                                                <button  @click="unListed(form_data.id,form_data.jac_candidate_name,form_data.jac_status)" class="btn-sm" title="CV Unlist" style="background: rgb(241 181 45);border-radius: 50%;border: none;color: #fff;"> <i class="fa fa-check"> </i></button>
                                                <p>Unlist</p>
                                              </div>
                                              <div class="col-md-4 float-left">
                                                <button  @click="emailToCandidate(form_data.id,form_data.jac_candidate_name,form_data.jac_email_address)" class="btn-sm" title="CV Shortlist" style="    background: #05bd05;border-radius: 50%;border: none;    color: #fff;"> <i class="fa fa-envelope"> </i></button>
                                                <p>Email</p>
                                              </div>
                                            </span>
                                            <span v-else-if="form_data.jac_status==2 && form_data.jac_email_send_status==1">
                                              <div class="col-md-4 float-left" style="padding-left:15px;">
                                                <button  @click="unListed(form_data.id,form_data.jac_candidate_name,form_data.jac_status)" class="btn-sm" title="CV Unlist" style="background: rgb(241 181 45);border-radius: 50%;border: none; color: #fff;"> <i class="fa fa-check"> </i></button>
                                               <p>Unlist</p>
                                              </div>
                                            </span>
                                            <span v-else>
                                               <div class="col-md-4 float-left">
                                              <button @click="showModal(form_data.id,form_data.jac_candidate_name,form_data.jac_email_address)" class="btn-sm" title="CV Short List" style="    background: #05bd05;border-radius: 50%;border: none;    color: #fff;"> <i class="fa fa-check"> </i></button>
                                               <p>Shortlist</p>
                                              </div>
                                            </span>
                                            <span>
                                              <div class="col-md-4 float-left">
                                              <button @click="rejectCandidate(form_data.id)" class="btn-danger btn-sm btn-icon reject_applicant" title="Reject Applicant?" style="    background: red;border-radius: 50%;border: none;    color: #fff;"><i class="fa fa-times"></i>
                                                    </button>
                                              <p>Reject</p>
                                              </div>
                                            </span>
                                         </div>
                                         </div>
                                         <div class="col-md-12 text-center" style="padding-top: 40px;">
                                             <span><i><strong>Applied on: </strong></i>  {{form_data.jac_date_time}}</span>
                                         </div>
                                        </td>
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
                        <div class="tab-pane fade " id="shortlistTab" role="tabpanel" aria-labelledby="profile-tab">
                            <!-- <div class="row">
                            <div class="col-sm-12">
                              <div class="dataTables_length" id="editable1_length">
                                <strong>
                                  Totlal Applicant: {{form_data.shortlist_candidate_count}}

                              </div>
                            </div>
                          </div> -->
                                <div class="col-md-6 col-sm-6 col-6 float-left">
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
                            <table ref="table" id="loremTable" summary="lorem ipsum sit amet" rules="groups" frame="hsides"  class="table table-striped employeeTable applicant_table" style=" border-collapse: separate;border-spacing: 0 20px; border-color:#fff;">
                              <!-- {{lists.paginate_data1}} -->
                               <tbody  v-if="Object.keys(lists.paginate_data1.data).length > 0">
                                   <tr v-for="(form_data, index) in lists.paginate_data1.data">
                                    <!-- {{form_data}} -->
                                        <td class="text-center " style="vertical-align: top;padding: 0px;top: 5px;">
                                          <span class="applicant_sl">{{order_no+index+1}}</span>
                                        </td>
                                        <td v-if="form_data.jac_image" class="text-left" style="vertical-align: middle;">
                                          <img :src="`${form_data.jac_image}`" class="card-img-top border rounded" style="width:100px; border-radius:50% !important">
                                        </td>
                                        <td v-if="!form_data.jac_image" class="text-left" style="vertical-align: middle;">
                                          <img :src="`admin_assets/images/candidate_default.png`" class="card-img-top border rounded" style="width:100px; border-radius:50% !important">
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div class="col-md-12">
                                              <p style="margin: 2px;font-size: 20px;font-weight: bold;color: #1e999e;" class="text-justify">
                                               {{form_data.jac_candidate_name}} <span style="border: 1px solid #1e99a1;border-radius: 5px;padding: 0px 10px;font-size: 16px;"> Age: {{calculateAge(form_data.jac_birth_day)}}</span>
                                              </p>
                                              <p style="margin: 2px;font-style: italic;font-size: 16px;color: #1e99a1;" class="text-justify">

                                                <i class="fa fa-map-marker"></i>
                                                {{form_data.jac_candidate_address}}

                                              </p>
                                              <p style="margin: 2px;font-size: 16px;color: #4a4a4a;font-weight: bold;" class="text-justify">
                                               {{form_data.jac_universitgy_name}}
                                              </p>
                                              <p style="margin: 2px;font-size: 16px;font-style: italic;" class="text-justify">
                                               {{form_data.jac_highest_education}}
                                              </p>
                                               <p style="font-size: 16px;margin: 2px;" class="text-justify">
                                                <i class="fa fa-phone"></i>
                                               {{form_data.jac_contact_no}}
                                              </p>
                                            </div>
                                        </td>
                                        <td class="text-center" style="vertical-align: top;">
                                          <div class="col-md-12">
                                            <p style="margin: 2px;font-size: 16px;" class="text-justify">
                                             {{form_data.jac_last_employment}}
                                            </p>
                                            <p style="margin: 2px;" class="text-justify">
                                              {{form_data.jac_last_designation}}

                                            </p>

                                             <p style="font-size: 16px;margin: 2px;" class="text-justify">
                                              <a download title="Download CV" target="_blank" :href="form_data.jac_cv" style="color: #1e99a1;"><i class="fa fa-download"></i> Download CV</a>
                                            </p>
                                          </div>
                                        </td>

                                        <td class="text-center" style="vertical-align: top;">
                                          <div class="col-md-12">
                                            <p style="margin: 2px;font-size: 16px;" class="text-justify">
                                              <i class="fa fa-history"></i>
                                             {{form_data.jac_last_experience}}
                                            </p>
                                            <p style="margin: 2px;" class="text-justify">
                                            <i class="fa fa-usd"></i>
                                              {{form_data.jac_expected_salary}}

                                            </p>

                                             <p style="font-size: 16px;margin: 2px;" class="text-justify">
                                              <span style="vertical-align: middle; text-align: center;" v-if="form_data.jac_status==1">
                                                Applied
                                                </span>
                                                <span style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==2">
                                                    Shortlisted <br>
                                                    <p style="color:orange; text-align: left;" v-if="form_data.jac_email_send_status==2">Email not sent!</p>
                                                    <p style="color:green;font-weight: bold; text-align: left;" v-if="form_data.jac_email_send_status==1">Email sent!</p>
                                                </span>
                                                <span style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==3">Selected</span>
                                                <span style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==4">Rejected</span>
                                                <span style="vertical-align: middle; text-align: center;" v-else>Applied</span>
                                            </p>
                                          </div>
                                        </td>

                                        <td class="text-center" style="vertical-align: middle;">
                                          <span v-if='form_data.cim_total_mark'>{{form_data.cim_total_mark}}</span>
                                          <span v-else>Mark not given!</span>
                                        </td>
                                        <td style="padding: 10px; vertical-align: top; text-align: center;" class="text-center">
                                          <div class="row">
                                              <div class="col-md-12">
                                                <div class="col-md-4 float-left">
                                                  <button data-controls-modal="marksEntryModal" data-backdrop="static" data-keyboard="false" @click="marksEntry(form_data.id,form_data.jac_job_circular_id)" class="open-resultEdit btn-rounded btn-sm btn-icon btn-info" title="Result Edit" data-toggle="modal" data-target="#result-edit-modal" style="border-radius:50%;"><i class="fa fa-plus"></i> </button>
                                                  <p>Mark Entry</p>
                                                </div>

                                                <span v-if="form_data.jac_status==3">
                                                  <div class="col-md-4 float-left">
                                                  <button class="btn-rounded btn-sm btn-icon btn-success unselect_applicant" title="Unselect Applicant?" style="border-radius:50%;">
                                                    <i class="fa fa-check"></i>
                                                  </button>
                                                  <p>Select</p>
                                                  </div>
                                                </span>
                                                <span v-if="form_data.jac_status!=3">
                                                  <div class="col-md-4 float-left">
                                                    <button  @click="selectCandidate(form_data.id)" class="btn-rounded btn-sm btn-icon btn-primary unselect_applicant" title="Select Applicant?" style="border-radius:50%;">
                                                    <i class="fa fa-check"></i>
                                                  </button>
                                                  <p>Select</p>
                                                  </div>
                                                </span>
                                                <span v-if="form_data.jac_status==4">
                                                  <div class="col-md-4 float-left">
                                                  <button class="btn-rounded btn-sm btn-icon btn-danger unselect_applicant" title="Unselect Applicant?"  style="border-radius:50%;">
                                                    <i class="fa fa-check"></i>
                                                  </button>
                                                  <p>Select</p>
                                                  </div>
                                                </span>
                                                <span v-if="form_data.jac_status!=4">
                                                  <div class="col-md-4 float-left">
                                                    <button @click="rejectCandidate(form_data.id)" class="btn-rounded btn-warning btn-sm btn-icon reject_applicant" title="Reject Applicant?" style="color:#fff;border-radius:50%;"><i class="fa fa-times"></i>
                                                    </button>
                                                    <p>Reject</p>
                                                  </div>
                                                </span>
                                              </div>
                                          </div>
                                        </td>
                                    </tr>
                                </tbody>
                              </table>
                                <div class="row">
                                  <div class="dataTables_footer clearfix col-md-12 col-12" style="padding: 10px 0px;">
                                      <div class="col-md-6 col-6 float-left">
                                          <div class="dataTables_info" id="DataTables_Table_0_info">Showing {{lists.paginate_data1.current_page}} of {{lists.paginate_data1.last_page}} pages</div>
                                      </div>
                                      <div class="col-md-6 col-6 float-right">
                                          <div class="dataTables_paginate paging_bootstrap float-right">
                                            <pagination :data="lists.paginate_data1" @pagination-change-page="getResults"></pagination>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                        </div>
                        <div class="tab-pane fade" id="selected" role="tabpanel" aria-labelledby="contact-tab">
                           <!--  <div class="row">
                            <div class="col-sm-12">
                              <div class="dataTables_length" id="editable1_length">
                                <strong>
                                  Totlal Applicant: {{form_data.selected_candidate_count}}

                              </div>
                            </div>
                          </div> -->
                              <div class="col-md-6 col-sm-6 col-6 float-left">
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
                            <table ref="table" id="loremTable" summary="lorem ipsum sit amet" rules="groups" frame="hsides"  class="table table-striped employeeTable applicant_table" style=" border-collapse: separate;border-spacing: 0 20px; border-color:#fff;">
                                <tbody  v-if="Object.keys(lists.paginate_data2.data).length > 0">
                                   <tr v-for="(form_data, index) in lists.paginate_data2.data" v-bind:key="form_data.id">
                                        <td class="text-center " style="vertical-align: top;padding: 0px;top: 5px;">
                                          <span class="applicant_sl">{{order_no+index+1}}</span>
                                        </td>
                                        <td v-if="form_data.jac_image" class="text-left" style="vertical-align: middle;">
                                          <img :src="`${form_data.jac_image}`" class="card-img-top border rounded" style="width:100px; border-radius:50% !important">
                                        </td>
                                        <td v-if="!form_data.jac_image" class="text-left" style="vertical-align: middle;">
                                          <img :src="`admin_assets/images/candidate_default.png`" class="card-img-top border rounded" style="width:100px; border-radius:50% !important">
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div class="col-md-12">
                                              <p style="margin: 2px;font-size: 20px;font-weight: bold;color: #1e999e;" class="text-justify">
                                               {{form_data.jac_candidate_name}} <span style="border: 1px solid #1e99a1;border-radius: 5px;padding: 0px 10px;font-size: 16px;"> Age: {{calculateAge(form_data.jac_birth_day)}}</span>
                                              </p>
                                              <p style="margin: 2px;font-style: italic;font-size: 16px;color: #1e99a1;" class="text-justify">

                                                <i class="fa fa-map-marker"></i>
                                                {{form_data.jac_candidate_address}}

                                              </p>
                                              <p style="margin: 2px;font-size: 16px;color: #4a4a4a;font-weight: bold;" class="text-justify">
                                               {{form_data.jac_universitgy_name}}
                                              </p>
                                              <p style="margin: 2px;font-size: 16px;font-style: italic;" class="text-justify">
                                               {{form_data.jac_highest_education}}
                                              </p>
                                               <p style="font-size: 16px;margin: 2px;" class="text-justify">
                                                <i class="fa fa-phone"></i>
                                               {{form_data.jac_contact_no}}
                                              </p>
                                            </div>
                                        </td>
                                        <td class="text-center" style="vertical-align: top;">
                                          <div class="col-md-12">
                                            <p style="margin: 2px;font-size: 16px;" class="text-justify">
                                             {{form_data.jac_last_employment}}
                                            </p>
                                            <p style="margin: 2px;" class="text-justify">
                                              {{form_data.jac_last_designation}}

                                            </p>

                                             <p style="font-size: 16px;margin: 2px;" class="text-justify">
                                              <a download title="Download CV" target="_blank" :href="form_data.jac_cv" style="color: #1e99a1;"><i class="fa fa-download"></i> Download CV</a>
                                            </p>
                                          </div>
                                        </td>

                                        <td class="text-center" style="vertical-align: top;">
                                          <div class="col-md-12">
                                            <p style="margin: 2px;font-size: 16px;" class="text-justify">
                                              <i class="fa fa-history"></i>
                                             {{form_data.jac_last_experience}}
                                            </p>
                                            <p style="margin: 2px;" class="text-justify">
                                            <i class="fa fa-usd"></i>
                                              {{form_data.jac_expected_salary}}

                                            </p>

                                             <p style="font-size: 16px;margin: 2px;" class="text-justify">
                                              <span style="vertical-align: middle; text-align: center;" v-if="form_data.jac_status==1">
                                                Applied
                                                </span>
                                                <span style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==2">
                                                    Shortlisted <br>
                                                    <p style="color:orange; text-align: left;" v-if="form_data.jac_email_send_status==2">Email not sent!</p>
                                                    <p style="color:green;font-weight: bold; text-align: left;" v-if="form_data.jac_email_send_status==1">Email sent!</p>
                                                </span>
                                                <span style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==3">Selected</span>
                                                <span style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==4">Rejected</span>
                                                <span style="vertical-align: middle; text-align: center;" v-else>Applied</span>
                                            </p>
                                          </div>
                                        </td>
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
                        <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="contact-tab">
                            <!-- <div class="row">
                            <div class="col-sm-12">
                              <div class="dataTables_length" id="editable1_length">
                                <strong>
                                  Totlal Applicant: {{form_data.rejected_candidate_count}}

                              </div>
                            </div>
                          </div> -->
                              <div class="col-md-6 col-sm-6 col-6 float-left">
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
                            <table ref="table" id="loremTable" summary="lorem ipsum sit amet" rules="groups" frame="hsides"  class="table table-striped employeeTable applicant_table" style=" border-collapse: separate;border-spacing: 0 20px; border-color:#fff;">
                                <tbody  v-if="Object.keys(lists.paginate_data3.data).length > 0">
                                   <tr v-for="(form_data, index) in lists.paginate_data3.data" v-bind:key="form_data.id">
                                        <td class="text-center " style="vertical-align: top;padding: 0px;top: 5px;">
                                          <span class="applicant_sl">{{order_no+index+1}}</span>
                                        </td>
                                        <td v-if="form_data.jac_image" class="text-left" style="vertical-align: middle;">
                                          <img :src="`${form_data.jac_image}`" class="card-img-top border rounded" style="width:100px; border-radius:50% !important">
                                        </td>
                                        <td v-if="!form_data.jac_image" class="text-left" style="vertical-align: middle;">
                                          <img :src="`admin_assets/images/candidate_default.png`" class="card-img-top border rounded" style="width:100px; border-radius:50% !important">
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div class="col-md-12">
                                              <p style="margin: 2px;font-size: 20px;font-weight: bold;color: #1e999e;" class="text-justify">
                                               {{form_data.jac_candidate_name}} <span style="border: 1px solid #1e99a1;border-radius: 5px;padding: 0px 10px;font-size: 16px;"> Age: {{calculateAge(form_data.jac_birth_day)}}</span>
                                              </p>
                                              <p style="margin: 2px;font-style: italic;font-size: 16px;color: #1e99a1;" class="text-justify">

                                                <i class="fa fa-map-marker"></i>
                                                {{form_data.jac_candidate_address}}

                                              </p>
                                              <p style="margin: 2px;font-size: 16px;color: #4a4a4a;font-weight: bold;" class="text-justify">
                                               {{form_data.jac_universitgy_name}}
                                              </p>
                                              <p style="margin: 2px;font-size: 16px;font-style: italic;" class="text-justify">
                                               {{form_data.jac_highest_education}}
                                              </p>
                                               <p style="font-size: 16px;margin: 2px;" class="text-justify">
                                                <i class="fa fa-phone"></i>
                                               {{form_data.jac_contact_no}}
                                              </p>
                                            </div>
                                        </td>
                                        <td class="text-center" style="vertical-align: top;">
                                          <div class="col-md-12">
                                            <p style="margin: 2px;font-size: 16px;" class="text-justify">
                                             {{form_data.jac_last_employment}}
                                            </p>
                                            <p style="margin: 2px;" class="text-justify">
                                              {{form_data.jac_last_designation}}

                                            </p>

                                             <p style="font-size: 16px;margin: 2px;" class="text-justify">
                                              <a download title="Download CV" target="_blank" :href="form_data.jac_cv" style="color: #1e99a1;"><i class="fa fa-download"></i> Download CV</a>
                                            </p>
                                          </div>
                                        </td>

                                        <td class="text-center" style="vertical-align: top;">
                                          <div class="col-md-12">
                                            <p style="margin: 2px;font-size: 16px;" class="text-justify">
                                              <i class="fa fa-history"></i>
                                             {{form_data.jac_last_experience}}
                                            </p>
                                            <p style="margin: 2px;" class="text-justify">
                                            <i class="fa fa-usd"></i>
                                              {{form_data.jac_expected_salary}}

                                            </p>

                                             <p style="font-size: 16px;margin: 2px;" class="text-justify">
                                              <span style="vertical-align: middle; text-align: center;" v-if="form_data.jac_status==1">
                                                Applied
                                                </span>
                                                <span style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==2">
                                                    Shortlisted <br>
                                                    <p style="color:orange; text-align: left;" v-if="form_data.jac_email_send_status==2">Email not sent!</p>
                                                    <p style="color:green;font-weight: bold; text-align: left;" v-if="form_data.jac_email_send_status==1">Email sent!</p>
                                                </span>
                                                <span style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==3">Selected</span>
                                                <span style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==4">Rejected</span>
                                                <span style="vertical-align: middle; text-align: center;" v-else>Applied</span>
                                            </p>
                                          </div>
                                        </td>
                                        <!-- <td style="vertical-align: middle; text-align: center;" v-if="form_data.jac_status==1">Applied</td>
                                        <td style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==2">
                                            Shortlisted <br>
                                            <span style="color:orange" v-if="form_data.jac_email_send_status==2">Email not sent!</span>
                                            <span style="color:green;font-weight: bold" v-if="form_data.jac_email_send_status==1">Email sent!</span>
                                        </td>
                                        <td style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==3">Selected</td>
                                        <td style="vertical-align: middle; text-align: center;" v-else-if="form_data.jac_status==4">Rejected</td>
                                        <td style="vertical-align: middle; text-align: center;" v-else>Applied</td> -->
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
            <!-- /.content -->
        </div>
        <div class="modal fade" id="shortListModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you sure want to short list '{{candidate_name}}'?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <!-- Do you want to delete this user? -->
                        <!-- {{candidate_id}} -->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="shortListNemail(candidate_id,candidate_name,candidate_email)">Short List & Send Email</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" @click="onlyShortList(candidate_id)">Only Short List</button>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

        <!--  Marks Entry Modal  -->
        <div class="modal fade" id="marksEntryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fa fa-bars"></i>
                         Interview Marks Entry</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="addMarks({add:'marksEntry/interview_board_call'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                          <input type="hidden" v-model="form_data.cim_candidate_id">
                          <input type="hidden" v-model="form_data.cim_circular_id">
                         <div class="">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="col-md-12 control-label">Experiences (Out of 10)<span class="required_sign">*</span></label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <input  v-model="cim_experience_mark" class="form-control" required="true" type="number">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-md-12 control-label">Dress-up/Smartness (Out of 10)<span class="required_sign">*</span></label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <input  v-model="cim_dressup_mark" class="form-control" required="true" type="number">
                                    </div>
                                 </div>
                              </div>

                              <div class="form-group">
                                 <label class="col-md-12 control-label">Academic Qualification (Out of 10)<span class="required_sign">*</span></label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <input  v-model="cim_academic_mark" class="form-control" required="true" type="number">
                                    </div>
                                 </div>
                              </div>

                              <div class="form-group">
                                 <label class="col-md-12 control-label">Viva Marks (Out of 10)<span class="required_sign">*</span></label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <input  v-model="cim_viva_mark" class="form-control" required="true" type="number">
                                    </div>
                                 </div>
                              </div>


                              <div class="form-group">
                                 <label class="col-md-12 control-label">Written Marks (Out of 10)</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                        <input  v-model="cim_written_mark" class="form-control" required="true" type="number">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-md-12 control-label">Total Mark</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <input  v-model="cim_total_mark" class="form-control" readonly  type="number">
                                    </div>
                                 </div>
                              </div>
                           </div>
                         </div>
                         <div class="form-actions col-md-12">
                             <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2">
                             <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button>
                         </div>
                     </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

        <!-- <modal class="" name="myModal" height="auto" :clickToClose="false">
           <div v-if="modal_loading">
               <div class="widget-header modal-header">
                   <h4><i class="fa fa-bars"></i>Interview Board Form</h4>
                   <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <div class="modify-wraper modal-body">
                   <form @submit.prevent="add({add:'add/interview_board_call'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                     <div class="row">
                       <div class="col-md-8 offset-md-2">
                          <div class="form-group">
                             <label class="col-md-12 control-label">Experiences (Out of 10)<span class="required_sign">*</span></label>
                             <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                   <input  v-model="form_data.employee_fullname" class="form-control" required="true" type="number">
                                </div>
                             </div>
                          </div>
                          <div class="form-group">
                             <label class="col-md-12 control-label">Dress-up/Smartness<span class="required_sign">*</span></label>
                             <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                   <input  v-model="form_data.employee_fullname" class="form-control" required="true" type="number">
                                </div>
                             </div>
                          </div>

                          <div class="form-group">
                             <label class="col-md-6 control-label">Academic Qualification<span class="required_sign">*</span></label>
                             <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                   <input  v-model="form_data.employee_fullname" class="form-control" required="true" type="number">
                                </div>
                             </div>
                          </div>

                          <div class="form-group">
                             <label class="col-md-6 control-label">Viva Marks<span class="required_sign">*</span></label>
                             <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                   <input  v-model="form_data.employee_fullname" class="form-control" required="true" type="number">
                                </div>
                             </div>
                          </div>

                          <div class="form-group">
                             <label class="col-md-6 control-label">Written Marks</label>
                             <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                    <input  v-model="form_data.employee_fullname" class="form-control" required="true" type="number">
                                </div>
                             </div>
                          </div>
                          <div class="form-group">
                             <label class="col-md-12 control-label">Total Mark</label>
                             <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                   <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                   <input  v-model="form_data.employee_fullname" class="form-control" required="true" type="number">
                                </div>
                             </div>
                          </div>
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
       </modal> -->
    </div>
    </div>
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
            candidate_id: 0,
            designation_name_value: '',
            highest_education_value: '',
            urls: '',
            candidate_name: '',
            candidate_email: '',
            cim_experience_mark:'',
            cim_dressup_mark:'',
            cim_academic_mark:'',
            cim_viva_mark:'',
            cim_written_mark:'',
            cim_total_mark:'',
              uri :'data:application/vnd.ms-excel;base64,',
              template:'<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
              base64: function(s){ return window.btoa(unescape(encodeURIComponent(s))) },
              format: function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) },
        // editorData: '',
        // editorConfig: {
        // }
      }

    },
    created(){
      this.getResults(1,this.$route.params.jobId);
      // this.getList();
    },
    components:{
      pageLoading:Loading
    },
    watch: {
            cim_experience_mark: function(val){
                this.form_data.cim_experience_mark = val;
                this.cim_experience_mark =val;
                let total=(+this.cim_experience_mark)+ (+this.cim_dressup_mark)+(+this.cim_academic_mark)+(+this.cim_viva_mark)+(+this.cim_written_mark);
                 this.cim_total_mark=(total).toFixed(2);
                 this.form_data.cim_total_mark=(total).toFixed(2);
            },
            cim_dressup_mark: function(val){
                this.form_data.cim_dressup_mark = val;
                this.cim_dressup_mark =val;
                let total=(+this.cim_experience_mark)+ (+this.cim_dressup_mark)+(+this.cim_academic_mark)+(+this.cim_viva_mark)+(+this.cim_written_mark);
                 this.cim_total_mark=(total).toFixed(2);
                 this.form_data.cim_total_mark=(total).toFixed(2);
            },
            cim_academic_mark: function(val){
                this.form_data.cim_academic_mark = val;
                this.cim_academic_mark =val;
                let total=(+this.cim_experience_mark)+ (+this.cim_dressup_mark)+(+this.cim_academic_mark)+(+this.cim_viva_mark)+(+this.cim_written_mark);
                 this.cim_total_mark=(total).toFixed(2);
                 this.form_data.cim_total_mark=(total).toFixed(2);
            },
            cim_viva_mark: function(val){
                this.form_data.cim_viva_mark = val;
                this.cim_viva_mark =val;
                let total=(+this.cim_experience_mark)+ (+this.cim_dressup_mark)+(+this.cim_academic_mark)+(+this.cim_viva_mark)+(+this.cim_written_mark);
                 this.cim_total_mark=(total).toFixed(2);
                 this.form_data.cim_total_mark=(total).toFixed(2);
            },
            cim_written_mark: function(val){
                this.form_data.cim_written_mark = val;
                this.cim_written_mark =val;
                let total=(+this.cim_experience_mark)+ (+this.cim_dressup_mark)+(+this.cim_academic_mark)+(+this.cim_viva_mark)+(+this.cim_written_mark);
                 this.cim_total_mark=(total).toFixed(2);
                 this.form_data.cim_total_mark=(total).toFixed(2);
            },

     },

    methods:{
      calculateAge(dob){
        let currentDate = new Date();
        let birthDate = new Date(dob);
        let difference = currentDate - birthDate;
        let age = Math.floor(difference/31557600000);
        return age;
      },
      tableToExcel(table, name){
          if (!table.nodeType) table = this.$refs.table
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
          window.location.href = this.uri + this.base64(this.format(this.template, ctx))
      },
      getList(){
        let uri = URL.baseUrl('allcvlist/job_circular/'+this.$route.params.jobId);
        axios.get(uri)
            .then(res => {
                this.form_data =res.data;
            })
            .catch(error => {
              this.showToster({status:0,message:'opps! something went wrong'});
            })
      },
      showModal(id,candidate_name,email) {
              this.candidate_id = id;
              this.candidate_name = candidate_name;
              this.candidate_email = email;
              // this.shortListStatus = status;
              $('#shortListModal').modal('show');
          },
          shortListNemail(id,name,email){
            let uri = URL.baseUrl('shortListNemail/job_circular/'+id+'/'+name+'/'+email);
            axios.get(uri)
                .then(res => {
                    this.form_data =res.data;
                    this.getList();
                })
                .catch(error => {
                  this.showToster({status:0,message:'opps! something went wrong'});
                })
          },
        onlyShortList(id){
          let uri = URL.baseUrl('onlyShortList/job_circular/'+id);
          axios.get(uri)
              .then(res => {
                  this.form_data =res.data;
                  this.getList();
              })
              .catch(error => {
                this.showToster({status:0,message:'opps! something went wrong'});
              })
        },
      unListed(id,candidate_name,status){
        if(!window.confirm('Are you sure want to back list '+candidate_name+'?')){
          return;
        }
        let uri = URL.baseUrl('unListed/job_circular/'+id);
        axios.get(uri)
            .then(res => {
                this.form_data =res.data;
                this.getList();
            })
            .catch(error => {
              this.showToster({status:0,message:'opps! something went wrong'});
            })
      },
      emailToCandidate(id,name,email){
        if(!window.confirm('Are you sure email to '+name+'?')){
          return;
        }
        let uri = URL.baseUrl('shortListNemail/job_circular/'+id+'/'+name+'/'+email);
        axios.get(uri)
          .then(res => {
              this.form_data =res.data;
              this.getList();
          })
          .catch(error => {
            this.showToster({status:0,message:'opps! something went wrong'});
          })
      },
      marksEntry(cim_candidate_id,circular_id) {
          this.form_data.cim_candidate_id = cim_candidate_id;
          this.form_data.cim_circular_id = circular_id;
          this.resetModalmarks();
            $('#marksEntryModal').modal('show');
          let uri = URL.baseUrl('findMarks/job_circular/'+cim_candidate_id);
          axios.get(uri)
          .then(res => {
             $('#marksEntryModal').modal('show');
          })
      },
      selectCandidate(candidate_id){
          if(!window.confirm('Are you sure want to select?')){
            return;
          }
          let uri = URL.baseUrl('selectCandidate/job_circular/'+candidate_id);
          axios.get(uri)
          .then(res => {
              this.form_data =res.data;
              this.getList();
          })
          .catch(error => {
            this.showToster({status:0,message:'opps! something went wrong'});
          })
      },

      rejectCandidate(candidate_id){
        if(!window.confirm('Are you sure want to reject?')){
          return;
        }
        let uri = URL.baseUrl('rejectCandidate/job_circular/'+candidate_id);
        axios.get(uri)
        .then(res => {
            this.form_data =res.data;
            this.getList();
        })
        .catch(error => {
          this.showToster({status:0,message:'opps! something went wrong'});
        })
      },



          addMarks(addUrl,callback){
            this.modal_loading= false;
            axios.post(URL.baseUrl(addUrl.add),this.form_data)
            .then(res => {
               this.resetModalmarks();
              if(res.data.status==1){
                if(!this.form_data.id){
                  this.modal_loading= true;
                  this.getResults(1);
                   $('#marksEntryModal').modal('hide');
                }else{

                  this.modal_loading= true;
                  $('#marksEntryModal').modal('hide');
                  this.getResults(this.current_page_no);
                }
              }
              this.errors =null;
              this.modal_loading= true;
              this.showToster(res.data);
              if(callback){
                callback();
              }
            })
            .catch(error => {
              if(error.response.status == 422){
                this.errors = error.response.data.errors;
              }
              this.modal_loading= true;
              // this.hideModal();
              var msg = 'opps! something went wrong';
              this.showToster({status:0,message:msg});
            });
          },
          resetModalmarks(){
            this.cim_experience_mark='';
            this.cim_dressup_mark='';
            this.cim_academic_mark='';
            this.cim_viva_mark='';
            this.cim_written_mark='';
            this.cim_total_mark='';
          },

          viewReportss11111(form_data,url){
             // $(".local_purchase").hide();
             // $('.loader').show();
             // location.reload();
             // location.reload();
            var urla =URL.baseUrl('get_applicant_data');
            $.ajax({
              url: urla,
              data: {
                  'paginate_num':20,
                  'page':1,
                  'order':"desc",
                  'sort':"id",
                  'page_ref_id':this.$route.params.jobId,
                  'candidate_gender':this.form_data.candidate_gender,
                  'age_from':this.form_data.age_from,
                  'age_to':this.form_data.age_to,
                  'candidate_designation':this.form_data.candidate_designation,
                  'experience_from':this.form_data.experience_from,
                  'experience_to':this.form_data.experience_to,
                  'salary_from':this.form_data.salary_from,
                  'salary_to':this.form_data.salary_to,
                  'candidate_education':this.form_data.candidate_education,
                  '_token': $('input[name=_token]').val()
              },
              type: "POST",
              success: function(return_data) {
                  form_data.all_candidate_count = return_data.all_candidate_count;
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                  ajax_request_handaler(errorThrown);
                  var msg = 'opps! something went wrong';
                  this.showToster({status:0,message:msg});
              }

          });

        },
        onSelectDesignation(option){
          this.form_data.employee_designation= option.id;
        },
        onSelecthighest_education(option){
          this.form_data.employee_designation= option.id;
        },
    }
  }
</script>

<style type="text/css">
  .shortList-modal .v--modal-box {
      width: 35% !important;
      left: 35% !important;
      text-align: center;
  }
   #applicant-list.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
      font-size: 13px;
      padding-left: 15px;
      font-weight: bold;
      padding-right: 15px;
  }
   #applicant-list.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link{
      font-size: 13px;
      padding-left: 15px;
      font-weight: bold;
      padding-right: 15px;
  }

  #marksEntryModal .modal-dialog{
    width: 30% !important;
  }
  .applicant_table tbody tr:nth-of-type(odd) {
      background-color: #fff !important;
     box-shadow: 0px 0px 5px -2px #000;
  }

  .applicant_table tbody tr:nth-of-type(even) {
      background-color: #fff !important;
     box-shadow: 0px 0px 5px -2px #000;
  }
  .applicant_table td, .applicant_table th {
      border: 0px solid #dee2e6;
  }
  .applicant_sl{
    padding: 5px;
    background: #777777;
    padding-top: 2px;
    margin-left: -7px;
    color: #fff;
    font-weight: bold;
    font-size: 15px;
  }
  .cv-list-four-box .info-box:hover {
      border: 1px solid #ddd;
      background: #f8f8f8;
      color: #000;
  }
  .active .info-box {
    border: 1px solid #fec23c;
  }

    .loader {
      border: 10px solid #ffffff;
      border-radius: 50%;
      border-top: 10px solid #fec23c;
      border-bottom: 10px solid #fec23c;
      width: 60px;
      height: 60px;
      position: fixed;
      left: 50%;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
  }

  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>
