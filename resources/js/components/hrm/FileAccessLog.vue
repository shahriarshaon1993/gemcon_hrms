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
                               <h3 class="card-title d-none d-md-block">File Access Log</h3>
                               <!-- <span class="float-sm-right" style="float: right;">
                                 <div  @click="getModalData($event,{dataUrl:'create/folder_file'},setModalData)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>
                                  <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                               </span> -->
                           </div>
                       </div>
                        <div class="row">
                          <div class="col-12 col-sm-12 col-md-3">
                            <div class="info-box">
                              <span class="info-box-icon bg-info elevation-1"><i class="fa fa-eye"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-text">View </span>
                                <span class="info-box-number">
                                  {{lists.total_view_data}}
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-sm-12 col-md-3">
                            <div class="info-box mb-3">
                              <span class="info-box-icon bg-success elevation-1"><i class="fa fa-download"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-text">Download </span>
                                <span class="info-box-number">
                                  {{lists.total_download_data}}
                                </span>
                              </div>
                            </div>
                          </div>
                           <div class="col-12 col-sm-12 col-md-3">
                             <div class="info-box">
                               <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-edit"></i></span>
                               <div class="info-box-content">
                                 <span class="info-box-text">Edit </span>
                                 <span class="info-box-number">
                                   {{lists.total_edit_data}}
                                 </span>
                               </div>
                             </div>
                           </div>
                           <div class="clearfix hidden-md-up"></div>
                           <div class="col-12 col-sm-12 col-md-3">
                             <div class="info-box mb-3">
                               <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-trash"></i></span>
                               <div class="info-box-content">
                                 <span class="info-box-text">Delete </span>
                                 <span class="info-box-number">
                                   {{lists.total_delete_data}}
                                 </span>
                               </div>
                             </div>
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
                            <th class="text-center" v-bind:class="getSortingClass('file_name')" @click="sortingChanged('file_name')">File Name <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('type_name')" @click="sortingChanged('type_name')">File Type <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('employee_id_no')" @click="sortingChanged('employee_id_no')">Emp. ID <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('employee_fullname')" @click="sortingChanged('employee_fullname')">Emp. Name <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('access_time')" @click="sortingChanged('access_time')">Access Time <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('access_date')" @click="sortingChanged('access_date')">Access Date <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('access_type')" @click="sortingChanged('access_type')">Details(View, Download, Delete) <i class="fas fa-sort"></i></th>
                          </tr>
                        </thead>
                         <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                          <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i = index>
                            <td class="text-center">{{index+1}}</td>
                            <td>{{form_data.file_name}}</td>
                            <td class="text-center">{{form_data.type_name }}</td>
                            <td class="text-center">{{form_data.employee_id_no }}</td>
                            <td class="text-left">{{form_data.employee_fullname}}</td>
                            <td class="text-center">{{form_data.access_time}}</td>
                            <td class="text-center">{{form_data.access_date}}</td>
                            <td class="text-center">{{form_data.access_type}}</td>
                            
                          </tr>
                        </tbody>
                         <tbody v-else>
                            <tr>
                                <td colspan="9" align="center">No data in database</td>
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
                  <!-- /.card -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
          </section>

          <modal class="" width= "40%" name="myModal" height="auto" :clickToClose="false">
               <div v-if="modal_loading">
                   <div class="widget-header modal-header">
                       <h4><i class="fa fa-bars"></i> File </h4>
                       <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   </div>
                   <div class="modify-wraper modal-body">
                       <form @submit.prevent="add({add:'add/folder_file'},resetModal)" class="form-horizontal row-border" id="validate-1">
                        <input type="hidden" v-model="folder_id_value">
                         <div class="" style="margin-right:0px">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="col-md-6 control-label">File Name</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                     <input id="designation_name" v-model="form_data.file_name" name="designation_name" placeholder="" class="form-control" required="true" type="text"></div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-md-6 control-label">File Type</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <vue-select v-model="file_type_value" :options="option_data.file_type_data" @select="onSelectFileType" placeholder="Select one" label="text" track-by="text"></vue-select>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-md-6 control-label">Expiration Date</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <datepicker placeholder="Select Date" v-model="form_data.expiration_date"   class="form-control" ></datepicker>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-md-6 control-label">Notification Period</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                     <input id="designation_name" v-model="form_data.notification_period" name="designation_name" placeholder="" class="form-control" required="true" type="number"></div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-md-6 control-label">File Attachment</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                     <input type="file" v-on:change="onFileChange" style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;" accept="image/*">
                                     <div v-if="form_data.file_attachment?form_data.file_attachment:''">
                                       <a target="_blank" :href="'/document_file/' + form_data.file_attachment"><i class="fa fa-eye"></i> View Attachment</a>
                                     </div>
                                   </div>
                                 </div>
                              </div>
                              <div class="form-group col-md-6" style="padding: 0px;">
                                 <div class="col-md-12 inputGroupContainer" style="margin-top:15px">
                                 <label class="col-md-12 control-label" style="padding-left:0px;">
                                    <div class="input-group" v-if="form_data.email_notify==1"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                       <input type="checkbox" style="margin: 5px 5px 0 0;" checked @input="addEvent" @change="addEvent" > Email Notify?
                                   </div>
                                    <div class="input-group" v-else><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                       <input type="checkbox" style="margin: 5px 5px 0 0;"   @input="addEvent" @change="addEvent" > Email Notify?
                                   </div>
                                 </label>
                                 </div>
                              </div>
                              <div class="form-group" v-if="form_data.id">
                                 <label class="col-md-6 control-label">Status</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <select class="form-control" v-model="form_data.file_status" required="true">
                                          <option disabled>--Select--</option>
                                          <option value="1">Active</option>
                                          <option value="2">Inactive</option>
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
    <div v-if="!page_loading">
        <pageLoading></pageLoading>
    </div>
</div>
</template>
<script>
    import Loading from '../Loading.vue';
       import $ from 'jquery'

    export default {
        data(){
          return{
            file_type_value:'',
            folder_id_value:'',
            folder_id:this.$route.params.folderId,
          }
        },
        created(){
            this.getResults(1,this.$route.params.folderId);
            // this.getList();
        },
        components:{
            pageLoading:Loading
        },
        methods:{
          onSelectFileType(option){
          console.log(option);
            this.form_data.file_type= option.id;
            console.log(this.form_data.file_type);
          },
          setModalData(){
            this.file_type_value=this.form_data.file_type_value;
            this.folder_id_value=this.$route.params.folderId;
            this.form_data.folder_id=this.$route.params.folderId;
          },
          onFileChange(e) {
            // alert(e);
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
                const file = e.target.files[0];
                this.url = URL.createObjectURL(file);
                
            },
          createImage(file) {
              let reader = new FileReader();
              let vm = this;
              reader.onload = (e) => {
                  this.form_data.file_attachment = e.target.result;
              };
              reader.readAsDataURL(file);
          },
          addEvent ({ type, target }) {
              if(target.checked == true ){
                  this.form_data.email_notify=1;
              }else{
                this.form_data.email_notify=2;
              }

              const event = {
                  type,
                  isCheckbox: target.type === 'checkbox',
                  target: {
                    value: target.value,
                    checked: target.checked
                  }
              }
              this.events.push(event)

            },
            eventText (e) {
              return `${e.type}: ${e.isCheckbox ? e.target.checked : e.target.value}`
            },
            // getList(){
            //   let uri = URL.baseUrl('employees/more-info-data/'+this.$route.params.employeeId);
            //   console.log(uri);
            //   axios.get(uri)
            //   .then(res => {
            //     console.log(res.data);
            //     this.form_data =res.data;
            //     this.sbu_name_value=this.form_data.sbu_name_value;
            //     this.section_value=this.form_data.section_value;
            //     this.department_name_value=this.form_data.department_name_value;
            //     this.designation_name_value=this.form_data.designation_name_value;
            //     this.jobgrade_name_value=this.form_data.jobgrade_name_value;
            //     this.sub_unit_value=this.form_data.sub_unit_value;
            //     this.employee_name_value=this.form_data.employee_name_value;
            //     this.work_location_value=this.form_data.work_location_value;
            //     })
            //   .catch(error => {
            //     this.showToster({status:0,message:'opps! something went wrong'});
            //   })
            // },
          resetModal(){
            // this.folder_id_value=this.$route.params.folderId;
            // this.form_data.folder_id=this.folder_id_value
          }
        }
    }



</script>