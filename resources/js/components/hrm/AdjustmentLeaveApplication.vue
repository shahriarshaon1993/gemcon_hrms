
<template>
<div>
    <div v-if="page_loading" class="widget box">
        <div class="widget-header">
             <div >
                   <section class="content">
                     <div class="container-fluid">
                       <div class="row">
                         <div class="col-12">
                           <div class="card">
                             <div class="card-header">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                                        <h3 class="card-title d-none d-md-block">Leave Adjustment List</h3>
                                        <span class="float-sm-right" style="float: right;">
                                          <div v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/leaveapplication'}, resetModal, add_new_type = 2)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Adjustment Entry</span> </div>
                                            <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                                        </span>
                                    </div>
                                </div>
                               <div class="row">
                                <div class="col-12 col-sm-12 col-md-3">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-info elevation-1"><i class="fa fa-paper-plane"></i></span>

                                    <div class="info-box-content">
                                      <span class="info-box-text">Requested</span>
                                      <span class="info-box-number">
                                        {{lists.requestApplications}}
                                      </span>
                                    </div>
                                  </div>
                                </div>
                                 <div class="col-12 col-sm-12 col-md-3">
                                   <div class="info-box">
                                     <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>

                                     <div class="info-box-content">
                                       <span class="info-box-text">Pending</span>
                                       <span class="info-box-number">
                                         {{lists.pendingApplications}}
                                       </span>
                                     </div>
                                   </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-3">
                                   <div class="info-box mb-3">
                                     <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>
                                     <div class="info-box-content">
                                       <span class="info-box-text">Accepted</span>
                                       <span class="info-box-number">{{lists.acceptedApplications }}</span>
                                     </div>
                                   </div>
                                 </div>
                                 <div class="clearfix hidden-md-up"></div>
                                 <div class="col-12 col-sm-12 col-md-3">
                                   <div class="info-box mb-3">
                                     <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-ban"></i></span>
                                     <div class="info-box-content">
                                       <span class="info-box-text">Rejected</span>
                                       <span class="info-box-number">{{lists.rejectedApplications}}</span>
                                     </div>
                                   </div>
                                 </div>
                             </div>
                             </div>
                             <div class="card-body">
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
                                  <th class="text-center" v-bind:class="getSortingClass('employee_id_no')" @click="sortingChanged('employee_id_no')"> ID<i class="fas fa-sort"></i></th>
                                   <th class="text-center" v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Employee <i class="fas fa-sort"></i></th>
                                  <th class="text-center" v-bind:class="getSortingClass('leave_apply_date')" @click="sortingChanged('present_date')">Present Date <i class="fas fa-sort"></i></th>
                                  <th class="text-center" v-bind:class="getSortingClass('leave_from_date')" @click="sortingChanged('leave_from_date')">Adjustment Date <i class="fas fa-sort"></i></th>
                                  <th class="text-center" v-bind:class="getSortingClass('leave_type_name')" @click="sortingChanged('leave_type_name')">Type <i class="fas fa-sort"></i></th>
                                  <th class="text-center" v-bind:class="getSortingClass('leave_reason')" @click="sortingChanged('leave_reason')">Remarks <i class="fas fa-sort"></i></th>
                                  <th class="text-center" v-bind:class="getSortingClass('leave_apply_status')" @click="sortingChanged('leave_apply_status')">Status <i class="fas fa-sort"></i></th>
                                  <th class="text-center">Action</th>
                                 </tr>
                                 </thead>
                                 <tbody v-if="Object.keys(paginate_data.data).length > 0">
                                  <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id">
                                     <td class="text-center">{{index+order_no+1}}</td>
                                       <td class="text-center">{{form_data.employee_id_no}}</td>
                                       <td>{{form_data.employee_fullname}}</td>
                                     <td class="text-center">{{form_data.present_date}}</td>
                                     <td class="text-center">{{form_data.leave_adjutment_date}}</td>
                                     <td class="text-center">{{'RL'}}</td>
                                     <td>{{form_data.leave_adjustment_remarks}}</td>
                                     <td class="text-center" v-if="form_data.leave_adj_approve_status==1" style="color:black;"> Requested</td>
                                     <td class="text-center" v-if="form_data.leave_adj_approve_status==2" style="color:green;"> Approved</td>
                                     <td class="text-center" v-if="form_data.leave_adj_approve_status==3" style="color:blue;"> Forwarded</td>
                                     <td class="text-center" v-if="form_data.leave_adj_approve_status==4" style="color:red;"> Rejected</td>
                                     <td class="text-center" v-if="form_data.leave_adj_approve_status==5" style="color:orange;"> Cancelled</td>
                                     <td class="text-center" v-if="form_data.leave_adj_approve_status==6" style="color:red;"> 
                                        <span style="color:green;">
                                          Approved
                                        </span>
                                     </td>
                                     <td style="padding: 5px 5px" class="text-center">
                                       <span v-if="form_data.leave_adj_approve_status ==1"> 
                                          <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/adjustmentleaveapplication/'+form_data.id},setModalData, add_new_type = 3, cancel_application =0)" class="btn-xs btn-info" title="Edit" > <i class="fa fa-check-circle"> </i></button>
                                       </span>
                                       <span v-if="form_data.leave_adj_approve_status !=1">
                                         <button v-if="lists.edit=='edit'" class="btn-xs btn-info" title="Task Already Completed!" @click="AccessDenied($event,value='Task Already Completed')" style="opacity: 0.5"> <i class="fa fa-check-circle"> </i></button>
                                       </span>
                                       <span v-if="form_data.leave_adj_approve_status ==1">  
                                        <button  v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'delete/adjustmentleaveapplication/'+form_data.id})" title="Delete" class="btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                       </span>
                                       <span v-if="form_data.leave_adj_approve_status !=1">
                                         <button v-if="lists.delete=='delete'" class="btn-xs btn-danger" title="Task Already Completed!" @click="AccessDenied($event,value='Task Already Completed')" style="opacity: 0.5"> <i class="fa fa-trash"></i></button>
                                       </span>
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
                                    <div class="dataTables_footer clearfix" style="width: 100%">
                                        <div class="col-md-6" style="float: left;">
                                            <div class="dataTables_info" id="DataTables_Table_0_info">Showing {{paginate_data.current_page}} of {{paginate_data.last_page}} pages</div>
                                        </div>
                                        <div class="col-md-6" style="float: right;">
                                            <div class="dataTables_paginate paging_bootstrap">
                                                <pagination :data="paginate_data" :limit="2" @pagination-change-page="getResults"></pagination>
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
                 </div>

                <modal class="" name="myModal" height="auto" :clickToClose="false">
                  <div v-if="modal_loading">
                      <div class="widget-header modal-header">
                          <h4><i class="fa fa-bars"></i> Adjustment Leave</h4>
                          <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      </div>
                      <div class="modify-wraper modal-body">
                          <div class="col-md-12" v-if='add_new_type==2 || add_new_type ==7'>
                            <div class="form-group">
                              <label>Search Employee</label>
                              <vue-select v-model="employee_name_search" :options="option_data.employee_data" @select="onSelectEmployeeSearch" placeholder="Select one" label="text" track-by="text"></vue-select>
                            </div>
                          </div>
                          <div class="row" style="margin:0px;">
                              <div class="col-md-12">
                                <div class="col-md-6 employee-info-table float-left" style="padding-right:0px;">
                                  <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                                      <tbody>
                                        <tr>
                                          <td> ID</td>
                                          <td>:</td>
                                          <td>
                                            <input type="hidden" v-model="form_data.employee_id" name="">
                                          {{form_data.user_employee_data.employee_id_no}}
                                        </td>
                                        </tr>
                                        <tr>
                                          <td> Name</td>
                                          <td>:</td>
                                          <td>{{form_data.user_employee_data.employee_fullname}}</td>
                                        </tr>
                                        <tr>
                                          <td>Designation</td>
                                          <td>:</td>
                                          <td>{{form_data.user_employee_data.designation_name}}</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6 employee-info-table float-left" style="padding-right:0px;">
                                   <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                                      <tbody>
                                        <tr>
                                          <td>Department</td>
                                          <td>:</td>
                                          <td>{{form_data.user_employee_data.department_name}}</td>
                                        </tr>
                                        <tr>
                                          <td>SBU/Project</td>
                                          <td>:</td>
                                          <td>{{form_data.user_employee_data.sbu_name}}</td>
                                        </tr>
                                        <tr>
                                          <td>Contact Phone</td>
                                          <td>:</td>
                                          <td>{{form_data.user_employee_data.employee_mobile}}</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                </div>
                              </div>
                          </div>
                          <div class="row" style="margin:0px;">
                                <form @submit.prevent="add({add:'add/adjustmentleaveapplication'},resetModal)" class="form-horizontal  row-border col-md-12" id="validate-1">
                                <div class="">
                                  <div class="col-md-12" style="padding:0px;">
                                      <div class="row adjustment_leave">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="col-md-6 control-label">Present Date</label>
                                            <div class="col-md-12 inputGroupContainer">
                                                <div class="input-group">
                                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                  <input v-if="form_data.id" type="text" class="form-control" v-model="form_data.present_date" readonly>
                                                  <datepicker v-if="!form_data.id" placeholder="Select Date" v-model="form_data.present_date" class="form-control"></datepicker>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="col-md-6 control-label">Adjustment Date</label>
                                            <div class="col-md-12 inputGroupContainer">
                                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                  <datepicker placeholder="Select Date" v-model="form_data.leave_adjutment_date" class="form-control"></datepicker>
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
                                              <textarea v-if="!form_data.id" v-model="form_data.leave_adjustment_remarks" placeholder="Enter your remarks..." type="text" class="form-control" style="height: 100px;"></textarea>
                                            </div>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                <div class="form-actions col-md-12" style="padding-right:0px !important;">
                                    <span v-if='add_new_type!=2'>
                                      <!-- <div class="col-md-12 " v-if="form_data.approveParmition==1"> -->
                                      <div class="col-md-12" v-if="form_data.approveParmition==1">
                                        <p style="margin-bottom: 3px;font-size: 18px;font-weight: 400 !important;"><label style="font-weight: 400 !important;">Comment</label></p>
                                        <textarea style="border: 1px solid #7ef0ff;background: #18aaff0d;font-weight: 400 !important;"  class="form-control" v-model="form_data.leave_adjust_comments"></textarea>
                                      </div>
                                      <div class="col-md-12 " style="margin-top:15px; margin-bottom:30px;" v-if="form_data.approveParmition==1">
                                        <button type="button" @click="add({add:'approveOrReject/adjustmentleaveapplication'}, form_data.approve_reject_status=1)" class="btn btn-md btn-info float-right col-md-3"
                                        style="background-color:#3ca6ea; border-color:#3ca6ea;font-family: 'Source Sans Pro';">
                                          <i class="fa fa-check"></i> 
                                            Approve
                                        </button>
                                        <button type="button" @click="add({add:'approveOrReject/adjustmentleaveapplication'},form_data.approve_reject_status=2)" class="btn btn-md btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px; font-family: 'Source Sans Pro';   margin-bottom: 15px;    color: #d48c06;"> 
                                            Decline
                                        </button>
                                      </div>
                                    </span>
                                    <input  v-if='add_new_type==2 || add_new_type ==7' type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2 col-2">
                                    <button  v-if='add_new_type==2 || add_new_type ==7' type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6 col-2" style="margin-right: 10px;">Close</button>
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
            leave_type_value:'',
            employee_name_search:'',
            employee_name_value:'',
            leave_type_value:'',
            add_new_type:'',
            totalDays:0,
            totalDayss:0,
            remaining_days:0,
            employee_image:'',
            cancel_application:0,
            // moment:'',
          }
        },
         props: {
          value: {
            type: Date,
            default: new Date()
          }
        },
        created(){
            this.getResults(1);
        },
        components:{
            pageLoading:Loading,
            Datepicker,
        },
        methods:{

          printLeave () {
            const modal = document.getElementById("modalInvoice")
            const cloned = modal.cloneNode(true)
            let section = document.getElementById("print")

            if (!section) {
               section  = document.createElement("div")
               section.id = "print"
               document.body.appendChild(section)
            }

            section.innerHTML = "";
            section.appendChild(cloned);
            window.print();
          },

        dateToYYYYMMDD(d) {
            return d && new Date(d.getTime()-(d.getTimezoneOffset()*60*1000)).toISOString().split('T')[0];
        },
        updateValue: function (target) {
          // console.log(target);
          const date1 = new Date(this.form_data.leave_from_date);
          const date2 = new Date(this.form_data.leave_to_date);
          const diffTime = Math.abs(date2 - date1);
          const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
          this.totalDays=(+ diffDays)+(+1) + " d";
          this.totalDayss=(+ diffDays)+(+1);
          // this.$emit('input', target.valueAsDate);
          // alert('sss');
          let leave_info = this.form_data.leaveInfo;
          let obj =leave_info.find(data => data.id == this.form_data.leave_type);  

          // console.log(this.form_data.leave_type);

          if((date1 !='Invalid Date') && (date2 !='Invalid Date')){
              if((obj.balance - this.totalDayss) > 0){
                // alert(this.totalDayss);
                if((this.form_data.leave_type == 2) && (this.totalDayss > 3)){
                  this.showToster({status:0,message:'opps! Casual leave not allowed more than 3 days !  '});
                  this.totalDayss=0;
                  this.form_data.leave_from_date='';
                  this.form_data.leave_to_date='';
                   this.totalDays=0;
                   this.remaining_days =0;
                }else{
                    this.remaining_days = obj.balance - this.totalDayss;
                }
              }else{
                  this.showToster({status:0,message:'opps! Casual leave not available ' + this.totalDayss + ' Days'});
                  this.totalDayss=0;
                  this.form_data.leave_from_date='';
                  this.form_data.leave_to_date='';
                  this.totalDays=0;
                  this.remaining_days =0;
              }
          }
         

          console.log(this.remaining_days);
        },
         selectAll: function (event) {
            setTimeout(function () {
              event.target.select()
            }, 0)
          },
          dateSelectedTotal(event){
            console.log(this.form_data.leave_from_date);
            console.log(this.form_data.leave_to_date);
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
          getModalDataOther(id){
               console.log('aaaaaa');
                let uri = URL.baseUrl('edit/otherCreate/'+id);
                console.log(uri);
                axios.get(uri)
                .then(res => {
                  console.log(res.data);
                  // console.log('aaaaaa');
                  this.form_data = res.data;
                  this.form_data.employee_id=id;
                  this.errors =null;
                  if(callback){
                    callback();
                  }
                })
                .catch(error => {
                  // this.showToster({status:0,message:'opps! something went wrong'});
                  this.modal_page_loading= true;
                })
            },

          leaveTypeList(option){
            console.log(option);
            this.form_data.leave_type= option.id;
            this.form_data.leave_from_date= '';
            this.form_data.leave_to_date= '';
            this.remaining_days= '';
            this.totalDays= '';
            this.form_data.add_new_type=this.add_new_type;
            console.log(this.form_data.leave_type);
          },
          onSelectEmployee(option){
            console.log(option);
            this.form_data.leave_reliever= option.id;
            console.log(this.form_data.leave_reliever);
            let allData =this.form_data.user_employee_data_all[option.id];

            // alert(allData);
            // console.log(allData);

            // this.form_data.leave_reliever_contact=allData['employee_desi'];
            if (allData['employee_mobile']!='') {
              this.form_data.leave_reliever_contact=allData['employee_mobile'];
              this.form_data.designation_name=allData['designation_name'];
              this.form_data.sbu_name=allData['sbu_name'];
            }else{
              this.form_data.leave_reliever_contact=allData['official_mobile_no'];
              this.form_data.designation_name=allData['designation_name'];
              this.form_data.sbu_name=allData['sbu_name'];
            }
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
                  this.form_data.leave_attachment = e.target.result;
              };
              reader.readAsDataURL(file);
          },
          setModalData(){
            this.employee_name_search=this.form_data.employee_name_search;
            this.employee_name_value=this.form_data.employee_name_value;
            this.leave_type_value=this.form_data.leave_type_value;
            this.form_data.cancel_application=this.cancel_application;
          },
          resetModal(){
            // alert('ss');
            this.form_data.employee_id= this.form_data.user_employee_data.id;
            this.form_data.leave_with_holiday='0';
            this.form_data.leave_apply_type='1';
            this.form_data.employee_name_value='';
            this.form_data.leave_reliever= '';
            this.form_data.leave_type_value='';
            this.form_data.employee_name_search='';
            this.form_data.employee_name_value='';
            this.form_data.leave_type_value='';
            this.form_data.leave_reliever="";
            this.employee_name_value="";
            this.totalDays=0;
            this.totalDayss=0;
            this.leave_type_value='';
            this.form_data.leave_type= '';
            this.cancel_applicatione=0;
            // this.leaveTypeList="";

            
          },
        }
    }

   
</script>
<style type="text/css">
  .vdp-datepicker {
      border-bottom: 0px solid #cfcfcf;
  }
  .vdp-datepicker input {
      border-bottom: 1px solid #dcdcdc;
      border-bottom-right-radius: 5px;
      height: 20px;
  }
  .table tbody+tbody {
    border-top: 1px solid #dee2e6;
    border-bottom: 1px solid #dee2e6;

}

.leave_app_model .v--modal-box{
    width: 60% !important;
    left: 20% !important;

    /*width: 65%*/
    /*left: 20%*/
    /*transition: transform .3s ease-out;*/
}

#modalInvoice > table td, .table th {
    padding: 1px .75rem;
}

@media screen {
  #print {
    display: none;
   }
}

@media print {
 body * {
  visibility:hidden;
  }
  #print, #print * {
    visibility:visible;
  }
  #print {
    position:absolute;
    left:0;
    top:0;
  }
}
.example-print {
    display: none;
}
@media print {
   .example-screen {
       display: none;
    }
    .example-print {
       display: block;
    }
}
@media print {
    .pagebreak {
        clear: both;
        page-break-after: always;
    }
}
@media print {
    #modalInvoice {
        height: auto; 
        /*background: #000; */
    }
    #modalInvoice:last-child {
     page-break-after: auto;
   }
   
   
}

.adjustment_leave .vdp-datepicker__calendar {
    position: absolute;
    z-index: 100;
    background: #fff;
    width: 300px;
    left: 0px;
    border: 1px solid #ccc;
}
</style>