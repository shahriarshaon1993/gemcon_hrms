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
                               <h3 class="card-title d-none d-md-block">Leave Adjustment Report</h3>
                           </div>
                       </div>
                    </div>
                    <div class="card-body col-md-12">
                      <div class="row col-md-12">
                            <div class="form-group col-md-2 float-left" style="padding:0px;">
                                <label class="col-md-12 control-label">From</label>
                                <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group calendar_left">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <datepicker placeholder="Select Date" v-model="from_date" class="form-control1" required></datepicker>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2 float-left" style="padding:0px;">
                              <label class="col-md-12 control-label">To</label>
                              <div class="col-md-12 inputGroupContainer">
                                  <div class="input-group calendar_left">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <datepicker placeholder="Select Date" v-model="to_date"   class="form-control1" required></datepicker>
                                </div>
                              </div>
                            </div>
                          <div class="row report-box col-md-12">
                            <div class="form-group col-md-2" style="max-width: 11%">
                              <label class="col-md-12 control-label"
                                >SBU <sup style="color: red; top: -2px">*</sup></label
                              >
                              <div
                                class="col-md-12 inputGroupContainer"
                                style="padding: 0px"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                  <vue-select v-model="sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbu" placeholder="Select one" label="text" track-by="text"></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
                              <label class="col-md-12 control-label">Unit</label>
                              <div
                                class="col-md-12 inputGroupContainer"
                                style="padding: 0px"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <vue-select
                                    v-model="unit_value"
                                    :options="option_data.unit_data"
                                    @select="employeesUnit"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
                              <label class="col-md-12 control-label">Sub Unit</label>
                              <div
                                class="col-md-12 inputGroupContainer"
                                style="padding: 0px"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <vue-select
                                    v-model="sub_unit_value"
                                    :options="option_data.sub_unit_data"
                                    @select="employeesSubUnit"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
                              <label class="col-md-12 control-label"
                                >Department</label
                              >
                              <div
                                class="col-md-12 inputGroupContainer"
                                style="padding: 0px"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <vue-select
                                    v-model="department_name_value"
                                    :options="option_data.department_data"
                                    @select="onSelectDepartment"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
                              <label class="col-md-12 control-label">Section</label>
                              <div
                                class="col-md-12 inputGroupContainer"
                                style="padding: 0px"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <vue-select
                                    v-model="section_value"
                                    :options="option_data.section_data"
                                    @select="employeesSection"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
                              <label class="col-md-12 control-label"
                                >Sub Section</label
                              >
                              <div
                                class="col-md-12 inputGroupContainer"
                                style="padding: 0px"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-home"></i
                                  ></span>
                                  <vue-select
                                    v-model="sub_section_value"
                                    :options="option_data.sub_section_data"
                                    @select="employeesSubSection"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-2" style="max-width: 11%">
                              <label class="col-md-12 control-label">Work Loc.</label>
                              <div
                                class="col-md-12 inputGroupContainer"
                                style="padding: 0px"
                              >
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-envelope"></i
                                  ></span>
                                  <vue-select
                                    v-model="work_location_value"
                                    :options="option_data.work_location_data"
                                    @select="employeesWorkLocation"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div
                              class="form-group col-md-2"
                              id="employee_wise_show"
                              style="max-width: 11%"
                            >
                              <label class="col-md-12 control-label">Employee</label>
                              <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                  <span class="input-group-addon"
                                    ><i class="glyphicon glyphicon-earphone"></i
                                  ></span>
                                  <vue-select
                                    v-model="employee_name_value"
                                    :options="option_data.employee_data"
                                    @select="onSelectEmployee"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                  ></vue-select>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-md-1 float-right"
                              style="max-width: 6%; padding: 18px 0px"
                            >
                              <span v-if="employeesSbu">
                                <a @click="findInsuranceReport($event)" id="addCF" class="btn btn-xs " style="color: #212529 !important;padding: .3rem .25rem;background-color: #fac23c;border-color: #fac23c;"><i class="fa fa-search" style="color: #212529 !important;background-color: #fac23c;border-color: #fac23c;"></i> Search </a>
                              </span>
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
      <!-- v-if="form_data.payroll_employee_data" -->
        <section class="content"  v-if="form_data.adjustment_info">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body col-md-12">
                      <div class="row col-md-12" v-if="(form_data.adjustment_info).length > 0">
                          <div class="col-12">
                            <button id="btnExport"  @click="tableToExcel" class="btn-success float-right" style="margin-left:10px;">Export</button>
                            <button @click="printDiv()" class="btn-info float-right">Print</button>
                          </div>
                          <div class="col-md-12" id="printable">
                            <div class=" " style="min-height: 56px;" v-if="modal_loading">
                            <div class="col-md-12">
                              <h4 class="text-center" style="margin:0px;">{{form_data.company_name}}
                                <!-- {{form_data.holiday_present_data}} -->
                              </h4>
                              <p class="text-center" style="margin:0px;">List of Employees Entitled for insurance</p>
                              <p class="text-center" style="margin:0px;">Date: {{form_data.report_print_date}} </p>
                            </div>
                            <table id="employeeTable_ids" class="table table-bordered  table-striped employeeTable" style="table-layout:fixed;width: 100% !important">
                              <thead>
                                <tr style="text-align: center;">
                                  <th style="vertical-align: middle;width: 50px">SL</th>
                                  <th style="vertical-align: middle;width: 80px">ID</th>
                                  <th style="vertical-align: middle;width: 150px">Name</th>
                                  <th style="vertical-align: middle;width: 150px">Designation</th>
                                  <th style="vertical-align: middle;width: 100px">Joining</th>
                                  <th style="vertical-align: middle;width: 150px">Location</th>
                                  <th style="vertical-align: middle;width: 150px">Department</th>
                                  <th style="vertical-align: middle;width: 200px;" v-for="(formData, index) in form_data.unique_date_find" v-bind:key="formData.id">
                                    {{formData.pdate}} [<span v-if="formData.pstatus==4">W</span><span v-if="formData.pstatus==5">H</span>]
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="(formData, index) in form_data.adjustment_info" v-bind:key="formData.id" >
                                  <td class="text-center">{{index+1}}</td>
                                  <td class="text-center"> {{formData.employee_id_no}}</td>
                                  <td>{{formData.employee_fullname}}</td>
                                  <td>{{formData.designation_name}}</td>
                                  <td class="text-center">{{formData.employee_joining_date}}</td>
                                  <td>{{formData.work_location_name}}</td>
                                  <td>{{formData.department_name}}</td>

                                  <td  v-for="(form_data1, index) in formData.holiday_present_data" v-bind:key="form_data1.id" >
                                    <div class="row">
                                        <div class="col-md-12 text-center float-left">
                                          <span v-if="formData.adjustment_leave_data == ''">
                                            <div @click="getModalDataAd($event,formData, form_data1,form_data1.pdate, index)" class="col-md-12" style="border:1px solid #bdbdbe; width:100%; background:#d9ffd9;">
                                              <h6 class="col-md-12" style="font-size:14px; margin-bottom:3px;"><u>{{form_data1.remarks}}</u></h6>
                                              <div class="col-md-12">
                                                <p style="margin:0px;">{{form_data1.intime}} - {{form_data1.outime}}</p>
                                                <p style="margin:0px;">Status - Present</p>
                                              </div>
                                            </div>
                                          </span>
                                          <span v-if="formData.adjustment_leave_data != ''">
                                            <span v-for="(form_data2, index) in formData.adjustment_leave_data" v-bind:key="form_data2.id">
                                              <span v-if="form_data2.present_date!=form_data1.pdate">
                                                <div @click="getModalDataAd($event,formData, form_data1,form_data1.pdate, index)" class="col-md-12" style="border:1px solid #bdbdbe; width:100%; background:#d9ffd9;">
                                                  <h6 class="col-md-12" style="font-size:14px; margin-bottom:3px;"><u>{{form_data1.remarks}}</u></h6>
                                                  <div class="col-md-12">
                                                    <p style="margin:0px;">{{form_data1.intime}} - {{form_data1.outime}}</p>
                                                    <p style="margin:0px;">Status - Present</p>
                                                  </div>
                                                </div>  
                                               </span>
                                               <span v-else>
                                                  <div class="col-md-12" style="border:1px solid #bdbdbe; width:100%; background:#d6e0d6;">
                                                    <h6 class="col-md-12" style="font-size:14px; margin-bottom:3px;"><u>{{form_data1.remarks}}</u></h6>
                                                    <div class="col-md-12">
                                                      <p style="margin:0px;">{{form_data1.intime}} - {{form_data1.outime}}</p>
                                                      <p style="margin:0px;">Status - Present</p>
                                                    </div>
                                                  </div>
                                               </span>
                                            </span>
                                          </span>
                                          <div v-for="(form_data2, index) in formData.adjustment_leave_data" v-bind:key="form_data2.id" class="col-md-12" style="border:1px solid #bdbdbe; width:100%; background:#cee8ff;">
                                            <span v-if="form_data2.present_date==form_data1.pdate">
                                              <h6 style="font-size:14px; margin-bottom:3px;"><u>Replacement Leave On</u></h6>
                                              <p style="margin:0px;">{{form_data2.pdate}}</p>
                                              <p style="margin:0px;">Status - {{form_data2.remarks}}</p>
                                            </span>
                                          </div>
                                        </div>
                                    </div>
                                  </td>

                                  <!-- <td  v-for="(form_data1, index) in formData.holiday_present_data" v-bind:key="form_data1.id" >
                                    <div class="row">
                                        <div class="col-md-12 text-center float-left">
                                          <span v-for="(form_data3, index) in formData.adjustment_leave_data" v-bind:key="form_data3.id">
                                          <span v-if="form_data1.pdate!=form_data3.present_date">
                                            <div @click="getModalDataAd($event,formData, form_data1,form_data1.pdate, index)" class="col-md-12" style="border:1px solid #bdbdbe; width:100%; background:#d9ffd9;">
                                              <h6 class="col-md-12" style="font-size:14px; margin-bottom:3px;"><u>{{form_data1.remarks}}</u></h6>
                                              <div class="col-md-12">
                                                <p style="margin:0px;">{{form_data1.intime}} - {{form_data1.outime}}</p>
                                                <p style="margin:0px;">Status - Present</p>
                                              </div>
                                            </div>
                                          </span>
                                          <span v-else>
                                            <span v-if="formData.adjustment_leave_data == ''">
                                            <div @click="getModalDataAd($event,formData, form_data1,form_data1.pdate, index)" class="col-md-12" style="border:1px solid #bdbdbe; width:100%; background:#d9ffd9;">
                                              <h6 class="col-md-12" style="font-size:14px; margin-bottom:3px;"><u>{{form_data1.remarks}}</u></h6>
                                              <div class="col-md-12">
                                                <p style="margin:0px;">{{form_data1.intime}} - {{form_data1.outime}}</p>
                                                <p style="margin:0px;">Status - Present</p>
                                              </div>
                                            </div>
                                          </span>
                                            <div class="col-md-12" style="border:1px solid #bdbdbe; width:100%; background:#d6e0d6;">
                                              <h6 class="col-md-12" style="font-size:14px; margin-bottom:3px;"><u>{{form_data1.remarks}}</u></h6>
                                              <div class="col-md-12">
                                                <p style="margin:0px;">{{form_data1.intime}} - {{form_data1.outime}}</p>
                                                <p style="margin:0px;">Status - Present</p>
                                              </div>
                                            </div>
                                          </span>
                                          </span>
                                          <div v-for="(form_data2, index) in formData.adjustment_leave_data" v-bind:key="form_data2.id" class="col-md-12" style="border:1px solid #bdbdbe; width:100%; background:#cee8ff;">
                                            <span v-if="form_data2.present_date==form_data1.pdate">
                                              <h6 style="font-size:14px; margin-bottom:3px;"><u>Replacement Leave On</u></h6>
                                              <p style="margin:0px;">{{form_data2.pdate}}</p>
                                              <p style="margin:0px;">Status - {{form_data2.remarks}}</p>
                                            </span>
                                          </div>
                                        </div>
                                    </div>
                                  </td> -->
                                </tr>
                              </tbody>
                            </table>


                             <modal class="" name="myModalAd" height="auto" :clickToClose="false" width="500">
                                <div v-if="modal_loading">
                                    <div class="widget-header modal-header">
                                        <h4><i class="fa fa-bars"></i> Adjustment Leave</h4>
                                        <button type="button" @click="hideModalAd" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modify-wraper modal-body">
                                        <div class="row" style="margin:0px;">
                                              <form @submit.prevent="add({add:'add/adjustmentleaveapplication'},resetModal)" class="form-horizontal  row-border col-md-12" id="validate-1">
                                              <div class="">
                                                <div class="col-md-12" style="padding:0px;">
                                                    <div class="row adjustment_leave">
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                          <label class="col-md-6 control-label">Employee Name</label>
                                                          <div class="col-md-12 inputGroupContainer">
                                                              <div class="input-group">
                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                                <input type="hidden" class="form-control" v-model="form_data.employee_id" readonly>
                                                                <input type="hidden" class="form-control" v-model="form_data.present_date" readonly>
                                                                <input type="text" v-model="selectedUser.employee_fullname" class="form-control" readonly>
                                                              </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                          <label class="col-md-6 control-label">Employee ID</label>
                                                          <div class="col-md-12 inputGroupContainer">
                                                              <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                              <input type="text" v-model="selectedUser.employee_id_no" class="form-control" readonly>
                                                              </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="row adjustment_leave">
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                          <label class="col-md-6 control-label">Present Date</label>
                                                          <div class="col-md-12 inputGroupContainer">
                                                              <div class="input-group">
                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                                <input type="text" class="form-control" v-model="selectedUser.pdate" readonly> [{{selectedUser.intime}} - {{selectedUser.outime}}]
                                                              </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                          <label class="col-md-6 control-label">Adjustment Date</label>
                                                          <div class="col-md-12 inputGroupContainer">
                                                              <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                                <!-- <datepicker placeholder="Select Date" v-model="form_data.leave_adjutment_date" class="form-control"></datepicker> -->
                                                                <input type="date" v-model="form_data.leave_adjutment_date" class="form-control">
                                                              </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="form-group">
                                                      <label class="col-md-6 control-label">Remarks</label>
                                                      <div class="col-md-12 inputGroupContainer">
                                                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                            <span v-if="form_data.id"> {{form_data.leave_adjustment_remarks}}</span>
                                                            <textarea v-if="!form_data.id" v-model="form_data.leave_adjustment_remarks" placeholder="Enter your remarks..." type="text" class="form-control" style="height: 120px;"></textarea>
                                                          </div>
                                                      </div>
                                                    </div>
                                                </div>
                                              </div>
                                              <div class="form-actions col-md-12" style="padding-right:0px !important;">
                                                  <input  type="submit"   tabindex="4" value="Submit" class="btn btn-sm btn-info float-right col-md-2 col-2">
                                                  <button  type="button" @click="hideModalAd" class="btn btn-sm btn-default float-right col-md-2 offset-md-6 col-2" style="margin-right: 10px;">Close</button>
                                              </div>
                                          </form>
                                        </div>
                                  </div>
                              </div>
                                  <div v-if="!modal_loading">
                                      <pageLoading></pageLoading>
                                  </div>
                              </modal>
                          </div>
                         <div v-if="!modal_loading">
                            <pageLoading></pageLoading>
                        </div>
              </div>
            <!-- </form> -->
        </div>
        <div class="row col-md-12" v-else>
            <h4 style="color: darkgrey;">No Data Found ! </h4>
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
      <div v-if="!modal_loading">
          <pageLoading></pageLoading>
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
    import $ from 'jquery'
    import VueTimepicker from 'vue2-timepicker'
    // CSS
    import 'vue2-timepicker/dist/VueTimepicker.css'   
    export default {
       data(){
         return{
           sbu_name_value:'',
           section_value:'',
           sub_section_value:'',
           employee_group_value:'',
           unit_value:'',
           make_user:0,
           employeesName:'',
           employees_ids:'',
           employee_id:'',
           datesList:'',
           DateRange:'',
           url: null,
           sub_unit_value:'',
           work_location_value:'',
           department_name_value:'',
           designation_name_value:'',
           jobgrade_name_value:'',
           employee_name_value:'',
           sub_unit_value:'',
           work_location_value:'',
           personal_email_id:'',
           from_date:'',
           from_date: new Date(),
           to_date: new Date(),
           personal_email_id:'',
           date_range_value:2,
           employee_status_value:5,
           employee_name_search:'',
           employees_list:[],
           selectedUser:'',
          //  selectedUser1:'',
         }
       },
        created(){
            this.getResults(1);
            this.modal_loading= true;
        },
        components:{
            pageLoading:Loading,
            VueTimepicker 
        },
        computed: {
      options: () => countries,
    },
    methods:{
       showModalAd() {
            this.$modal.show('myModalAd');
        },
        hideModalAd() {
            this.$modal.hide('myModalAd');
        },
        getModalDataAd(event, obj, obj1, date, index){
          // alert('ok');
          console.log(obj);
          console.log(index);
          // this.form_data = {};
          this.selectedUser = {};
          this.selectedUser = obj;
          this.selectedUser.intime = obj1.intime;
          this.selectedUser.outime = obj1.outime;
          this.selectedUser.pdate = date;
          this.form_data.employee_id = obj.employee_id;
          this.form_data.present_date = date;
          console.log(this.selectedUser.intime);
          this.showModalAd();
          // if (obj && obj.dataUrl) {
          //     console.log(obj.dataUrl);
          //     this.modal_loading = false;
          //     axios.get(URL.baseUrl(obj.dataUrl))
          //     .then(res => {
          //         console.log(res.data);
          //         if (res.data.status == 0) {
          //             this.showToster(res.data);
          //         }
          //         this.types = 1,
          //         this.form_data = res.data;
          //         this.showModalAd();
          //         this.modal_loading = true;
          //         this.errors = null;
          //         if (!this.form_data.id) {
          //             if (callback) {
          //                 callback();
          //             }
          //         } else {
          //             if (callback) {
          //                 callback();
          //             }
          //         }  
                    
          //     })
          //     .catch(error => {
          //         this.showToster({ status: 0, message: 'opps! something went wrong' });
          //         this.modal_loading = true;
          //     })
          // } else {
          //     this.form_data = {};
          //     this.modal_loading = true;
          // }
       },

       add(addUrl, callback) {
          console.log(this.form_data);
          console.log(URL.baseUrl(addUrl.add));
          this.modal_loading = false;
          axios.post(URL.baseUrl(addUrl.add), this.form_data)
              .then(res => {
                  if (res.data.status == 1) {
                       this.showToster(res.data);
                        if (!this.form_data.id) {
                            this.getResults(1);
                        this.hideModal();
                        this.emphideModal();
                        
                        this.page_loading = true;
                        this.modal_loading=true;
                      } else {
                          this.modal_loading = true;
                          this.page_loading = true;
                          this.hideModal();
                          this.getResults(this.current_page_no);
                          
                      }
                      this.page_loading = true;
                      this.modal_loading=true;
                  }
                  this.showToster(res.data);
                  this.modal_loading = true;
                  this.errors = null;
                  this.getResults(1);
                  if (callback) {
                      callback();
                  }
              })
              .catch(error => {
                  console.log(error);
                  if (error.response.status == 422) {
                      this.errors = error.response.data.errors;
                  }
                  this.page_loading = true;
                  this.modal_loading=true;
                  var msg = 'opps! something went wrong';
                  this.showToster({ status: 0, message: msg });
              });
        },
       printDiv() {
            $('h3').each(function() {
              this.style.setProperty('margin', '0px', 'important');
              this.style.setProperty('font-size', '1.75rem', 'important');
            });
             $('h4').each(function() {
              this.style.setProperty('margin', '0px', 'important');
              this.style.setProperty('font-size', '1.5rem', 'important');
            });
              $('h5').each(function() {
              this.style.setProperty('margin', '0px', 'important');
              this.style.setProperty('font-size', '1.25rem', 'important');
            });
            $('h6').each(function() {
              this.style.setProperty('margin', '0px', 'important');
              this.style.setProperty('font-size', '1rem', 'important');
            });
             $('.table-bordered').each(function() {
              this.style.setProperty('border', '1px solid #dee2e6', 'important');
              this.style.setProperty('padding', '5px .75rem', 'important');
              this.style.setProperty('border-collapse', 'collapse', 'important');
            });
            $('.ths').each(function() {
               this.style.setProperty('border', '1px solid #dee2e6', 'important');
              this.style.setProperty('padding', '5px 5px', 'important');
              this.style.setProperty('border-collapse', 'collapse', 'important');
            });
           let contents = document.getElementById("printable").innerHTML
            
             let frame1 = document.createElement('iframe');
             frame1.name = "frame1";
             frame1.style.position = "absolute";
             frame1.style.top = "-1000000px";
             document.body.appendChild(frame1);
             let frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
             frameDoc.document.open();
             frameDoc.document.write('<html lang="en"><head><title>Gemcon Group</title>');
             frameDoc.document.write('<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.0.0-alpha/fullcalendar.print.min.css"/>');
             frameDoc.document.write('</head><body>');
             frameDoc.document.write(contents);
             frameDoc.document.write('</body></html>');
             frameDoc.document.close();
             setTimeout(function () {
                 window.frames["frame1"].focus();
                 window.frames["frame1"].print();
                 document.body.removeChild(frame1);
             }, 500);
             return false;
         },
        tableToExcel(){
        var uri = 'data:application/vnd.ms-excel;base64,',
          template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64 = function(s) {
              return window.btoa(unescape(encodeURIComponent(s)))
            },
            format = function(s, c) {
              return s.replace(/{(\w+)}/g, function(m, p) {
                return c[p];
              })
            }
          var toExcel = document.getElementById("printable").innerHTML;
          var ctx = {
            worksheet: name || '',
            table: toExcel
          };
          var link = document.createElement("a");
          link.download = "export.xls";
          link.href = uri + base64(format(template, ctx))
          link.click();
  
        },
        updateCountry (form_data,shift) {
          form_data.shift =shift ;
        },
        addRow(event,approval_infos) {
            var aaa= this.form_data.approval_infos.length;
            this.form_data.approval_infos.push({
                permission_id:this.permission_id,
                permission_type:this.noticeToType,
                permission_type_name:this.noticeToTypeName,
                permission_id_name:this.permission_id_name,
            })
            console.log(this.form_data.approval_infos);
        },
        deleteRow(index) {
          this.form_data.approval_infos.splice(index,1);
        },
        monthlySelect(event){
          if(event.target.value==1){
            this.weekly_id=0;
          }else{
            this.weekly_id=1;
          }
        },
        weekSelect(event){
          this.weeks_id=event.target.value;
        },
        monthsSelectsId(event){
            this.months_id=event.target.value;
        }, 
        SalaryTypeId(event){
            this.salary_type_id=event.target.value;
        }, 
        SalaryGrade(event){
            this.salary_grade=event.target.value;
        },
        WeeklyProcessType(event){
            this.process_type=event.target.value;
        },
        EmplysStatus(event){
            this.employee_status=event.target.value;
        },
        findInsuranceReport(event){
          this.modal_loading= false;
          let uri = URL.baseUrl('leave_adjustment_report/finding');
          axios.post(uri,
            {
              id: this.sbu_id,
              unit_id: this.unit_id,
              subunit_id: this.subunit_id,
              department_id: this.department_id,
              section_id: this.section_id,
              subsection_id: this.subsection_id,
              employee_work_location: this.employee_work_location,
              employeeId:this.employee_id,
              from_date:this.from_date,
              to_date:this.to_date,
              employee_status:this.employee_status_value,
              date_range_value:this.date_range_value,
            }).then(res => {
              console.log(res);
              this.form_data=res.data;
              this.modal_loading= true;
            })
            .catch(error => {
              this.modal_loading= true;
          })
        },
        onSelectJobGrade(option){
          console.log(option);
          this.form_data.employee_job_grade= option.id;
          this.permission_id=option.id;
          this.permission_id_name=option.text;
          console.log(this.form_data.employee_job_grade);
        },
        onSelectEmployee(option){
          console.log(this.employee_id);
          this.form_data.employee_id = option.id;
          this.employee_id = option.id;
          this.permission_id=option.id;
          this.permission_id_name=option.text;
        },  
        onSelectEmployeeSearch(option){
          this.getModalDataOther(option.id);
          this.form_data.leave_reliever= option.id;
          this.form_data.employee_id=this.form_data.leave_reliever;
          console.log(this.form_data.employee_id);
          console.log(option);
          let allData =this.form_data.user_employee_data_all[option.id];
          this.form_data.employee_id= allData['id']; 

        },
       setModalData(){
         this.sbu_name_value=this.form_data.sbu_name_value;
         this.section_value=this.form_data.section_value;
         this.sub_section_value=this.form_data.sub_section_value;
         this.employee_group_value=this.form_data.employee_group_value;
         this.department_name_value=this.form_data.department_name_value;
         this.designation_name_value=this.form_data.designation_name_value;
         this.jobgrade_name_value=this.form_data.jobgrade_name_value;
         this.sub_unit_value=this.form_data.sub_unit_value;
         this.employee_name_value=this.form_data.employee_name_value;
         this.work_location_value=this.form_data.work_location_value;
         this.general_data_temp=this.form_data.general_info_temp;
         this.form_data.employee_status=this.form_data.employee_status;
         this.employee_name_search=this.form_data.employee_name_search;
       },
       resetModal(){
           this.sbu_name_value='';
           this.section_value='';
           this.sub_section_value='';
           this.employee_group_value='';
           this.department_name_value='';
           this.designation_name_value='';
           this.jobgrade_name_value='';
           this.unit_value='';
           this.sub_unit_value='';
           this.employee_name_value='';
           this.work_location_value='';
           this.form_data.emplyee_category_mgt_non_mgt='2';
           this.form_data.employee_leave_group='1';
           this.form_data.employee_type='2';
           this.form_data.make_user='';
           this.form_data.user_type='0'
           this.form_data.ea_approve_by_name='';
           this.form_data.employee_mobile='';
           this.form_data.employee_id='';
           this.form_data.employee_number='';
           this.form_data.employee_fullname='';
           this.form_data.employee_joining_date='';
           this.form_data.employee_image='';
           this.form_data.make_user='';
           this.approvalnamevalue1="";
           this.form_data.employee_status='';
           this.employee_name_search='';
           this.form_data.employee_id = '';
           this.form_data.present_date = '';
     },

     notice_to(event){
     	console.log(event.target.name);
     	if (event.target.value==1) {
     		this.noticeToType=1;
        this.noticeToTypeName='Company/SBU';
     	}else if(event.target.value==2){
     		this.noticeToType=2;
        this.noticeToTypeName='Department';
     	}else if(event.target.value==3){
     		this.noticeToType=3;
        this.noticeToTypeName='Unit';
     	}else if(event.target.value==4){
     		this.noticeToType=4;
        this.noticeToTypeName='Sub Unit';
     	}else if(event.target.value==5){
     		this.noticeToType=5;
        this.noticeToTypeName='Section';
     	}else if(event.target.value==6){
     		this.noticeToType=6;
        this.noticeToTypeName='Sub Section';
     	}else if(event.target.value==7){
     		this.noticeToType=7;
        this.noticeToTypeName='Employee';
     	}
     }
	}
}
</script>
<style type="text/css">
  .employeeTable_ids.table th {
    padding: 4px 5px !important;
  }
  .div_class {
    margin-left: 193px;
    overflow-y: visible;
    padding: 0;
  }
  .headcol {
    position: absolute;
    width: 200px;
    left: 0;
    top: auto;
    border-top-width: 1px;
    margin-top: -1px;
  }
  .headcol:before {
    content: '';
  }
  .select_id > .multiselect > .multiselect__tags{
    min-height: 41px !important;
  }
  .calendar_left .vdp-datepicker__calendar{
    left: 3px !important;
  }
</style>
