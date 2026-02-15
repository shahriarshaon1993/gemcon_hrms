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
                                   <h3 class="card-title d-none d-md-block">Insurance Eligible List</h3>
                                   <span class="float-sm-right" style="float: right;">
                                    
                                     <a @click="$router.go()" class="btn bg-info"><i class="fa fa-spinner" aria-hidden="false"></i> Refresh</a>
                                      <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                                   </span>
                               </div>
                           </div>
                            <div class="row">
                              <div class="col-12 col-sm-12 col-md-4">
                                <div class="info-box">
                                  <span class="info-box-icon bg-info elevation-1"><i class="fa fa-paper-plane"></i></span>
                                  <div class="info-box-content">
                                    <span class="info-box-text">Total </span>
                                    <span class="info-box-number">
                                      {{lists.total_data}}
                                    </span>
                                  </div>
                                </div>
                              </div>
                               <div class="col-12 col-sm-12 col-md-4">
                                 <div class="info-box">
                                   <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
                                   <div class="info-box-content">
                                     <span class="info-box-text">Inactive </span>
                                     <span class="info-box-number">
                                       {{lists.inactive_data}}
                                     </span>
                                   </div>
                                 </div>
                               </div>
                               <div class="col-12 col-sm-12 col-md-4">
                                 <div class="info-box mb-3">
                                   <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>
                                   <div class="info-box-content">
                                     <span class="info-box-text">Active </span>
                                     <span class="info-box-number">
                                       {{lists.active_data}}
                                     </span>
                                   </div>
                                 </div>
                               </div>
                               <div class="clearfix hidden-md-up"></div>
                               <!-- <div class="col-12 col-sm-12 col-md-3">
                                 <div class="info-box mb-3">
                                   <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-ban"></i></span>
                                   <div class="info-box-content">
                                     <span class="info-box-text">Rejected </span>
                                     <span class="info-box-number">DDD</span>
                                   </div>
                                 </div>
                               </div> -->
                           </div>
                        </div>
                        <div class="card-body col-md-12">
                          <div class="col-md-6 col-sm-6 col-6 float-left" style="padding:0px;">
                              <div id="DataTables_Table_0_length" class="">
                                  Show
                                  <label> 
                                      <select class="form-control pagination-number" @change="onChange($event)" v-model="paginate_num"  name="pageSize">
                                          <option value="1000000000000">All</option>
                                          <!-- <option value="2">2</option>
                                          <option value="3">3</option> -->
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
                                          <option value="200">200</option>
                                          <option value="500">500</option>
                                      </select>
                                  </label>
                                  entries
                              </div>
                          </div>
    
                          <div class="col-md-6 col-sm-6 col-6 float-left" style="padding:0px;">
                              <div class="dataTables_filter" id="DataTables_Table_0_filter">
                                  <label class="float-right">
                                      <div class="input-group"><span class="input-group-addon"><i class="icon-search"></i></span>
                                          <button style="margin-right: 5px; font-size: 14px" class="btn btn-xs btn-info" @click="
                                            tableToExcel('table', 'Insurance Eligible List')
                                          ">
                                          <i class="fa fa-file-excel"></i>
                                            Export
                                          </button>
                                          <input v-on:keyup="getResults" v-model="search_input.search_key" type="text" aria-controls="DataTables_Table_0" class="form-control search-keyword" id="search"  placeholder="Search...">
                                      </div>
                                  </label>
                              </div>
                          </div>
    
                          <table ref="table" id="employeeTable" class="table table-bordered table-striped employeeTable">
                            <thead>
                              <tr>
                                <th class="text-center">SL</th>
                                <th class="text-center" v-bind:class="getSortingClass('employee_id')" @click="sortingChanged('employee_id')"> ID<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Name <i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Designation<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('department_name')" @click="sortingChanged('department_name')">Department<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('sbu_name')" @click="sortingChanged('sbu_name')">SBU<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('work_location_name')" @click="sortingChanged('work_location_name')">W. Locat.<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('eligible_date_entry')" @click="sortingChanged('eligible_date_entry')">Entry<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('employee_joining_date')" @click="sortingChanged('employee_joining_date')">DOJ<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('employee_dob')" @click="sortingChanged('employee_dob')">DOB<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('service_length')" @click="sortingChanged('service_length')">S. Leng.<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('employee_age')" @click="sortingChanged('employee_age')">Age<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('jobgrade_name')" @click="sortingChanged('jobgrade_name')">Grade<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('emplyee_category_mgt_non_mgt')" @click="sortingChanged('emplyee_category_mgt_non_mgt')"> Category<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('employee_type')" @click="sortingChanged('employee_type')"> Type<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('insurance_amount')" @click="sortingChanged('insurance_amount')">Insurance Amount<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('yearly_premium_amount')" @click="sortingChanged('yearly_premium_amount')">Yearly Premium<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('status')" @click="sortingChanged('status')">Status <i class="fas fa-sort"></i></th>
                                <th class="text-center" style="width: 10% !important;">Action</th>
                              </tr>
                            </thead>
                             <tbody  v-if="paginate_data.data != '' && Object.keys(paginate_data.data).length > 0">
                              <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i = index>
                                <td class="text-center">{{index+1}}</td>
                                <td class="text-center">{{form_data.employee_id_no}}</td>
                                <td class="text-left">{{form_data.employee_fullname}}</td>
                                <td class="text-left">{{form_data.designation_name}}</td>
                                <td class="text-left">{{form_data.department_name}}</td>
                                <td class="text-left">{{form_data.sbu_name}}</td>
                                <td class="text-left">{{form_data.work_location_name}}</td>
                                <td class="text-center">{{formatCompat(form_data.eligible_date_entry)}}</td>
                                <td class="text-center">{{formatCompat(form_data.employee_joining_date)}}</td>
                                <td class="text-center">{{formatCompat(form_data.employee_dob_certificate)}}</td>
                                <td class="text-center">{{Number(form_data.service_length).toFixed(1)}}</td>
                                <td class="text-center">{{Math.round(form_data.employee_age)}}</td>
                                <td class="text-center">{{form_data.jobgrade_name}}</td>
                                <td class="text-center">
                                  <span v-if="form_data.emplyee_category_mgt_non_mgt == 1">
                                    {{ 'Management' }}
                                  </span>
                                  <span v-else-if="form_data.emplyee_category_mgt_non_mgt == 2">
                                    {{ 'Non-Management' }}
                                  </span>
                                  <span v-else>{{ '-' }}</span>
                                </td>
                                <td class="text-center">
                                  <span v-if="form_data.employee_type == 1">
                                    {{ 'Permanent' }}
                                  </span>
                                  <span v-else-if="form_data.employee_type == 2">
                                    {{ 'Probationary' }}
                                  </span>
                                  <span v-else-if="form_data.employee_type == 3">
                                    {{ 'Cotractual' }}
                                  </span>
                                  <span v-else-if="form_data.employee_type == 4">
                                    {{ 'Casual' }}
                                  </span>
                                  <span v-else-if="form_data.employee_type == 5">
                                    {{ 'Temporary' }}
                                  </span>
                                  <span v-else-if="form_data.employee_type == 6">
                                    {{ 'Intern' }}
                                  </span>
                                  <span v-else>{{ '-' }}</span>
                                </td>
                                <td style="text-align: right;"> {{ Number(form_data.insurance_amount).toFixed(2) }} </td>
                                <td style="text-align: right;"> {{ Number(form_data.yearly_premium_cost).toFixed(2) }} </td>
                                <td class="text-center">
                                   <span v-if="form_data.status==1" style="color: green;">
                                    {{"Eligible"}}
                                  </span>
                                  <span v-else style="color: red;">
                                    {{"Not Eligible"}}
                                  </span>
                                </td>
                                <td class="text-center">
                                  <button style="border-radius: 3px;" v-if="lists.edit=='edit'" class="btn btn-xs btn-info" @click="getModalData($event,{dataUrl:'edit/insurance_eligible/'+form_data.id})" title="Edit" > <i class="fa fa-edit"> </i> Edit </button>
                                  <button style="border-radius: 3px;" v-if="lists.delete=='delete'" class="btn btn-xs btn-danger"  @click="deleteItem({delUrl:'delete/insurance_eligible/'+form_data.id})" title="Delete" ><i class="fa fa-trash"></i> Delete</button>
                                </td>
                              </tr>
                            </tbody>
                             <tbody v-else>
                                <tr>
                                    <td colspan="19" :align="center" style="text-align: center; color: #ffc107;">No data in database</td>
                                </tr>
                            </tbody>
                          </table>
                          <div class="row" style="padding: 10px 0px;">
                            <div class="dataTables_footer clearfix" style="width: 100%">
                              <div class="col-md-6" style="float: left">
                                <div class="dataTables_info" id="DataTables_Table_0_info">
                                  Showing {{ paginate_data.current_page }} of
                                  {{ paginate_data.last_page }} pages
                                </div>
                              </div>
                              <div class="col-md-6" style="float: right">
                                <div class="dataTables_paginate paging_bootstrap">
                                  <pagination :data="paginate_data" :limit="2" @pagination-change-page="getResults">
                                  </pagination>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <modal class="" width= "40%" name="myModal" height="auto" :clickToClose="false">
                   <div v-if="modal_loading">
                       <div class="widget-header modal-header">
                           <h4><i class="fa fa-bars"></i> Insurance Eligible Employee</h4>
                           <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       </div>
                       <div class="modify-wraper modal-body">
                           <form @submit.prevent="add({add:'update/insurance_eligible'},resetModal)" class="form-horizontal row-border col-md-12" id="validate-1">
                            <div class="col-md-12 row" style="margin: 0px;">
                                <div class="col-md-6 employee-info" style="border: 1px solid #ddd; padding: 15px;">
                                    <table class="table table-hover table-responsive">
                                        <tbody>
                                            <tr>
                                                <td>Employee Name</td>
                                                <td>:</td>
                                                <td style="font-weight: bold;">
                                                    {{ form_data.employee_fullname }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Employee Type</td>
                                                <td>:</td>
                                                <td>
                                                  <span v-if="form_data.emplyee_category_mgt_non_mgt == 1">
                                                    {{ 'Management' }}
                                                  </span>
                                                  <span v-else-if="form_data.emplyee_category_mgt_non_mgt == 2">
                                                    {{ 'Non-Management' }}
                                                  </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Grade</td>
                                                <td>:</td>
                                                <td>{{ form_data.jobgrade_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Date of Joining</td>
                                                <td>:</td>
                                                <td>
                                                    {{ formatCompat(form_data.employee_joining_date) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Date of Birth</td>
                                                <td>:</td>
                                                <td>
                                                  {{ formatCompat(form_data.employee_dob_certificate) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Age</td>
                                                <td>:</td>
                                                <td>
                                                    <span> 
                                                        {{ Math.round(form_data.employee_age) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6 employee-info" style="border: 1px solid #ddd; padding: 15px;">
                                    <table class="table table-hover table-responsive">
                                        <tbody>
                                            <tr>
                                                <td>ID Number</td>
                                                <td>:</td>
                                                <td>{{form_data.employee_id_no}}</td>
                                            </tr>
                                            <tr>
                                                <td>Company/SBU</td>
                                                <td>:</td>
                                                <td>{{form_data.sbu_name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Designation</td>
                                                <td>:</td>
                                                <td>{{form_data.designation_name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Department</td>
                                                <td>:</td>
                                                <td>{{form_data.department_name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Work Location</td>
                                                <td>:</td>
                                                <td>{{form_data.work_location_name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Years of Service</td>
                                                <td>:</td>
                                                <td>{{ Number(form_data.service_length).toFixed(1) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                             <div class="row" style="margin-top: 10px">
                               <div class="col-md-12">
                                  <div class="form-group">
                                     <label class="col-md-6 control-label">Entry Date</label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                          <input type="date" v-model="form_data.eligible_date_entry" placeholder="Entry Date" class="form-control" required="true">
                                        </div>
                                     </div>
                                  </div>
                                  
                                  <div class="form-group" v-if="form_data.id">
                                     <label class="col-md-6 control-label">Status</label>
                                     <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                           <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                           <select class="form-control" v-model="form_data.status" required="true">
                                              <option disabled>--Select--</option>
                                              <option value="1">Eligible</option>
                                              <option value="2">Not Eligible</option>
                                           </select>
                                        </div>
                                     </div>
                                  </div>
                               </div>
                             </div>
                             <div class="form-actions col-md-12" >
                                 <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2 col-2">
                                 <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6 col-2" style="margin-right: 10px;">Close</button>
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
        <div v-if="!this.page_loading">
            <pageLoading></pageLoading>
        </div>
    </div>
    </template>
    <script>
      import Loading from '../Loading.vue';
      export default {
          data(){
            return{
              uri: "data:application/vnd.ms-excel;base64,",
              template:
                '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
              base64: function (s) {
                return window.btoa(unescape(encodeURIComponent(s)));
              },
              format: function (s, c) {
                return s.replace(/{(\w+)}/g, function (m, p) {
                  return c[p];
                });
              },
            }
          },
          created(){
              this.getResults(1);
          },
          components:{
              pageLoading:Loading
          },
          methods:{
            tableToExcel(table, name) {
              if (!table.nodeType) table = this.$refs.table;
              var ctx = { worksheet: name || "Worksheet", table: table.innerHTML };
              window.location.href =
                this.uri + this.base64(this.format(this.template, ctx));
            },
            formatCompat(date_format) {
              var ms = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
              return new Date(date_format).getDate() + ' ' + ms[new Date(date_format).getMonth()] + ' ' + new Date(date_format).getFullYear();
            },
          }
      }
    </script>
    <style>
    .employeeTable.table th {
        background: #e0e0e0;
        border: 1px solid #efefef;
    }
    .table thead th {
        background: #ddd;
    }
  </style>