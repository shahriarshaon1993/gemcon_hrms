<template>
<div>
    <div v-if="page_loading" class="widget box">
        <div class="widget-header">
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body col-md-12">
                      <nav style="padding-bottom: 15px" id="salary_tab">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                          <a class="nav-item nav-link active salary_tab" id="nav-home-tab" data-toggle="tab" href="#pabx-list" role="tab" aria-controls="pabx-list" aria-selected="true">PABX List</a>
                          <a class="nav-item nav-link salary_tab" id="nav-profile-tab" data-toggle="tab" href="#email-list" role="tab" aria-controls="email-list" aria-selected="false">Email List</a>
                        </div>
                      </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="pabx-list" role="tabpanel" aria-labelledby="nav-home-tab">
                          <div class="card-header" style="padding:0px !important; border:0px;">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                                    <h3 class="card-title d-none d-md-block">PABX List</h3>
                                    <span class="float-sm-right" style="float: right;">
                                      <div  v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/others_pabx_email'},resetModal)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>
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
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6 col-6 float-left" style="padding:10px 0px;">
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
                                <th class="text-center" v-bind:class="getSortingClass('sbu_others_name')" @click="sortingChanged('sbu_others_name')">SBU/Others<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('department_others_name')" @click="sortingChanged('department_others_name')">Department/Others<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('employee_or_others')" @click="sortingChanged('employee_or_others')">Employee/Others<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('pabx_or_email')" @click="sortingChanged('pabx_or_email')">PABX<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('ope_status')" @click="sortingChanged('ope_status')">Status <i class="fas fa-sort"></i></th>
                                <th class="text-center">Action</th>
                              </tr>
                            </thead>
                            <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                              <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i = index>
                                <td class="text-center">{{index+1}}</td>
                                <td class="text-center">{{form_data.sbu_others_name}}</td>
                                <td class="text-center">{{form_data.department_others_name}}</td>
                                <td class="text-center">{{form_data.employee_or_others}}</td> 
                                <td class="text-center">{{form_data.pabx_or_email}}</td> 
                                <td class="text-center">
                                  <span v-if="form_data.ope_status==1" style="color:green;">
                                    {{"Active"}}
                                  </span>
                                  <span v-else style="color:red;">
                                    {{"Inactive"}}
                                  </span>
                                </td>
                                <td class="text-center">
                                  <button  v-if="lists.edit=='edit'" class="btn btn-xs btn-info" @click="getModalData($event,{dataUrl:'edit/others_pabx_email/'+form_data.id})" title="Edit" > <i class="fa fa-edit"> </i> Edit </button>
                                  <button v-if="lists.delete=='delete'" class="btn btn-xs btn-danger"  @click="deleteItem({delUrl:'delete/others_pabx_email/'+form_data.id})" title="Delete" ><i class="fa fa-trash"></i> Delete</button>
                                  </td>
                              </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="6" align="center">No data in database</td>
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
                        <div class="tab-pane fade" id="email-list" role="tabpanel" aria-labelledby="nav-profile-tab"> 
                            <div class="card-header" style="padding:0px !important; border:0px;">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                                    <h3 class="card-title d-none d-md-block">Email List</h3>
                                    <span class="float-sm-right" style="float: right;">
                                      <div  v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/others_pabx_email'},resetModal)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>
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
                                        {{lists.total_data1}}
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
                                        {{lists.inactive_data1}}
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
                                        {{lists.active_data1}}
                                      </span>
                                    </div>
                                  </div>
                                </div>
                                <div class="clearfix hidden-md-up"></div>
                            </div>
                          </div>
                            <div class="col-md-6 col-sm-6 col-6 float-left" style="padding:10px 0px;">
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
                                <th class="text-center" v-bind:class="getSortingClass('sbu_others_name')" @click="sortingChanged('sbu_others_name')">SBU/Others<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('department_others_name')" @click="sortingChanged('department_others_name')">Department/Others<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('employee_or_others')" @click="sortingChanged('employee_or_others')">Employee/Others<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('pabx_or_email')" @click="sortingChanged('pabx_or_email')">Email<i class="fas fa-sort"></i></th>
                                <th class="text-center" v-bind:class="getSortingClass('ope_status')" @click="sortingChanged('ope_status')">Status <i class="fas fa-sort"></i></th>
                                <th class="text-center">Action</th>
                              </tr>
                            </thead>
                            <tbody  v-if="Object.keys(paginate_data1.data).length > 0">
                              <tr v-for="(form_data, index) in paginate_data1.data" v-bind:key="form_data.id" i = index>
                                <td class="text-center">{{index+1}}</td>
                                <td class="text-center">{{form_data.sbu_others_name}}</td>
                                <td class="text-center">{{form_data.department_others_name}}</td>
                                <td class="text-center">{{form_data.employee_or_others}}</td> 
                                <td class="text-center">{{form_data.pabx_or_email}}</td> 
                                <td class="text-center">
                                  <span v-if="form_data.ope_status==1" style="color:green;">
                                    {{"Active"}}
                                  </span>
                                  <span style="color:red;" v-else>
                                    {{"Inactive"}}
                                  </span>
                                </td>
                                <td class="text-center">
                                  <button  v-if="lists.edit=='edit'" class="btn btn-xs btn-info" @click="getModalData($event,{dataUrl:'edit/others_pabx_email/'+form_data.id}, setModalData)" title="Edit" > <i class="fa fa-edit"> </i> Edit </button>
                                  <button v-if="lists.delete=='delete'" class="btn btn-xs btn-danger"  @click="deleteItem({delUrl:'delete/others_pabx_email/'+form_data.id}, setModalData)" title="Delete" ><i class="fa fa-trash"></i> Delete</button>
                                  </td>
                              </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="6" align="center">No data in database</td>
                                </tr>
                            </tbody>
                          </table>
                          <div class="row">
                            <div class="dataTables_footer clearfix col-md-12 col-12" style="padding: 10px 0px;">
                                <div class="col-md-6 col-6 float-left">
                                    <div class="dataTables_info" id="DataTables_Table_0_info">Showing {{paginate_data1.current_page}} of {{paginate_data1.last_page}} pages</div>
                                </div>
                                <div class="col-md-6 col-6 float-right">
                                    <div class="dataTables_paginate paging_bootstrap float-right">
                                      <pagination :data="paginate_data1" @pagination-change-page="getResults"></pagination>
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
          <modal class="" width= "40%" name="myModal" height="auto" :clickToClose="false">
               <div v-if="modal_loading">
                   <div class="widget-header modal-header">
                       <h4><i class="fa fa-bars"></i> Others PABX / Email</h4>
                       <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   </div>
                   <div class="modify-wraper modal-body">
                       <form @submit.prevent="add({add:'add/others_pabx_email'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                         <div class="row" style="margin-right:0px; padding:8px;">
                           <div class="col-md-12">
                              <div class="form-group">
                                <label class="col-md-6 control-label">SBU/Others</label>
                                <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                      <vue-select v-model="others_sbu_value" :options="option_data.otehrs_sbu_list" @select="onSelectSBUType" placeholder="Select one" label="text" track-by="text"></vue-select>
                                    </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-6 control-label">Department/Floor</label>
                                <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                      <vue-select v-model="others_department_value" :options="option_data.otehrs_department_list" @select="onSelectDepartmentType" placeholder="Select one" label="text" track-by="text"></vue-select>
                                    </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-12 control-label">List Type</label>
                                <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                      <select v-model="form_data.ope_type" class="selectpicker form-control">
                                          <option>--Select--</option>
                                          <option value="1">PABX</option>
                                          <option value="2">Email</option>
                                      </select>
                                    </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-6 control-label">Employee/Others</label>
                                <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <input id="designation_name" v-model="form_data.employee_or_others" name="designation_name" placeholder="" class="form-control" required="true" type="text"></div>
                                </div>
                              </div>
                              <div class="form-group" v-if="form_data.ope_type==1">
                                <label class="col-md-6 control-label">PABX</label>
                                <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <input id="designation_name" v-model="form_data.pabx_or_email" name="designation_name" placeholder="" class="form-control" required="true" type="number"></div>
                                </div>
                              </div>
                              <div class="form-group" v-if="form_data.ope_type==2">
                                <label class="col-md-6 control-label">Email</label>
                                <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <input id="designation_name" v-model="form_data.pabx_or_email" name="designation_name" placeholder="" class="form-control" required="true" type="email"></div>
                                </div>
                              </div>
                              <div class="form-group" v-if="form_data.id">
                                 <label class="col-md-6 control-label">Status</label>
                                 <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                       <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                       <select class="form-control" v-model="form_data.ope_status" required="true">
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
  export default {
    data(){
          return{
            others_sbu_value:'',
            others_department_value:'',
            getContext:'',
          }
        },
      created(){
          this.getResults(1);
      },
      components:{
          pageLoading:Loading
      },
      methods:{
        onSelectSBUType(option){
          console.log(option);
          this.form_data.sbu_or_others= option.id;
          this.form_data.sbu_others_name= option.text;
        },
        onSelectDepartmentType(option){
          console.log(option);
          this.form_data.department_or_othes= option.id;
          this.form_data.department_others_name= option.text;
        },
        setModalData(){
          this.others_sbu_value=this.form_data.others_sbu_value;
          this.others_department_value=this.form_data.others_department_value;
        },
        resetModal(){
          this.others_sbu_value=''; 
          this.others_department_value=''; 
        },
        // onSelectType(event){
        //   console.log(event.target.value);
        //   if(event.target.value==1){
        //     this.pabx_email_type_view=1;
        //   }
        //   if(event.target.value==2){
        //     this.pabx_email_type_view=2;
        //   }
        // },
      }
  }
</script>