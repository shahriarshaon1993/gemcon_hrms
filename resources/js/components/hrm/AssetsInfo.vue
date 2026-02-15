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
                               <h3 class="card-title d-none d-md-block">Assets Info List</h3>
                               <!-- <span class="float-sm-right" style="float: right;">
                                 <div  v-if="lists.add=='add'" @click="getModalData($event,{dataUrl:'create/designation'})" class="btn-group"> <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span></div>
                                  <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                               </span> -->
                           </div>
                       </div>
            
                    </div>
                    <div class="card-body col-md-12">
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
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                </select>
                            </label>
                           <!--  entries, List total: 120 -->
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
                            <th class="text-center">#</th>
                            <th class="text-center" v-bind:class="getSortingClass('designation_code')" @click="sortingChanged('designation_code')">Employee ID <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Employee Name <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Designation <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Company/SBU <i class="fas fa-sort"></i></th>
                            <th class="text-center" v-bind:class="getSortingClass('designation_name')" @click="sortingChanged('designation_name')">Department <i class="fas fa-sort"></i></th>
                            <th class="text-center">Action</th>
                          </tr>
                        </thead>
                         <tbody  v-if="Object.keys(paginate_data.data).length > 0">
                          <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i = index>
                            <!-- <span></span> -->
                            <td class="text-center">{{order_no+index+1}}</td>
                            <td class="text-center">{{form_data.employee_id_no}}</td>
                            <td>{{form_data.employee_fullname}}</td>
                            <td class="text-left">{{form_data.designation_name}}</td>
                            <td class="text-left">{{form_data.sbu_name}}</td>
                            <td class="text-left">{{form_data.department_name}}</td>
                            <td class="text-center">
                              <button  v-if="lists.edit=='edit'" class="btn btn-xs btn-success" @click="getModalData($event,{dataUrl:'edit/assets_info/'+form_data.id})" title="View" > <i class="fa fa-eye"> </i> Details </button>
                            </td>
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

          <modal class="" width= "50%" name="myModal" height="auto" :clickToClose="false">
               <div v-if="modal_loading">
                   <div class="widget-header modal-header">
                       <h4><i class="fa fa-bars"></i> Assets Detail Info</h4>
                       <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   </div>
                   <div class="modal-body">
                    <div class="row">
                      <div class="col-md-8 float-left modify-wraper" style="border: 1.5px solid #ddd;
                      border-radius: 5px;
                      margin-left: 21px;max-width: 64.666667%;">
                        <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                          <tbody>
                            <tr>
                              <td>Employee ID &nbsp; </td>
                              <td>:</td>
                              <td>
                                <input type="hidden" v-model="form_data.employee_id" name="">
                               <strong> &nbsp; {{form_data.user_employee_data.employee_id_no}} </strong>
                            </td>
                            </tr>
                            <tr>
                              <td>Employee Name &nbsp; </td>
                              <td>:</td>
                              <td> <strong> &nbsp; {{form_data.user_employee_data.employee_fullname}} </strong></td>
                            </tr>
                            <tr> 
                              <td> &nbsp; </td>
                            </tr>
                            <tr>
                              <td>Designation &nbsp; </td>
                              <td>:</td>
                              <td> &nbsp; {{form_data.user_employee_data.designation_name}}</td>
                            </tr>
                            <tr>
                              <td>Department &nbsp; </td>
                              <td>:</td>
                              <td> &nbsp; {{form_data.user_employee_data.department_name}}</td>
                            </tr>
                            <tr>
                              <td>Company/SBU/Project &nbsp; </td>
                              <td>:</td>
                              <td> &nbsp; {{form_data.user_employee_data.sbu_name}}</td>
                            </tr>
                            <tr>
                              <td>Contact Phone &nbsp; </td>
                              <td>:</td>
                              <td> &nbsp; {{form_data.user_employee_data.employee_mobile}}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-4 float-left text-center" style="max-width: 30.666667%;padding-left: 53px;" v-if="form_data.user_employee_data">
                        <span v-if="form_data.user_employee_data.employee_image">
                          <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top:2px; width: 150px; height: 170px;">
                        </span>
                        <span v-else>
                          <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-top: 2px; width: 150px; height: 170px;">
                        </span>
                      </div>
                    </div>

                      <div class="col-md-12" style="padding:15px;">
                        <table id="assetsTable" class="table table-striped table-bordered fileListTable" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th scope='col' style='border:1px solid #ddd !important;'>#</th>
                                    <th scope='col' style='border:1px solid #ddd !important;'>Barcode </th>
                                    <th scope='col' style='border:1px solid #ddd !important;'>Description </th>
                                    <th scope='col' style='border:1px solid #ddd !important;'>Brand </th>
                                    <th scope='col' style='border:1px solid #ddd !important;'>  Condition </th>
                                    <th scope='col' style='border:1px solid #ddd !important; '>  Assigning Date </th>
                                    <th scope='col' style='border:1px solid #ddd !important; '>  Status </th>
                                </tr>
                            </thead>
                            <tbody>
                              <!-- {{form_data.assets_detail}} -->
                            </tbody>
                            <tbody >
                              <tr v-for="(asset_data, index) in form_data.assets_detail" v-bind:key="asset_data.id" i=index>
                                  
                                  <td class="text-center">{{index+1}}</td>
                                  <td class="text-center">{{asset_data.assets_id}}</td>
                                  <td class="text-left">{{asset_data.assets_master_description}}</td>
                                  <td class="text-left">{{asset_data.brand_or_model}}</td>
                                  <td class="text-left">
                                    <span v-if="asset_data.condidtion==1">
                                      Good & In use
                                    </span>
                                    <span v-else-if="asset_data.condidtion==2">
                                      Good But Idle
                                    </span>
                                    <span v-else-if="asset_data.condidtion==3">
                                      Stand By
                                    </span>
                                    <span v-else-if="asset_data.condidtion==4">
                                      Damage but Serviceable
                                    </span>
                                    <span v-else-if="asset_data.condidtion==5">
                                      Obsolete/ Serviceable
                                    </span>
                                    <span v-else-if="asset_data.condidtion==6">
                                      Obsolete/ Impaired/ Damage
                                    </span>
                                    <span v-else-if="asset_data.condidtion==7">
                                      Out of Service
                                    </span>
                                    <span v-else-if="asset_data.condidtion==8">
                                      Service Out
                                    </span>
                                    <span v-else-if="asset_data.condidtion==9">
                                      New
                                    </span>
                                    <span v-else>
                                      -
                                    </span>
                                  </td>
                                  <td class="text-center">
                                      {{asset_data.assign_create_at}}
                                  </td>
                                  <td class="text-left">
                                    <span v-if="asset_data.asset_checkout==1">
                                      Check In
                                    </span>
                                    <span v-else-if="asset_data.asset_checkout==0">
                                      Check Out
                                    </span>
                                  </td>
                               </tr>
                            </tbody>
                            
                        </table> 
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
       import $ from 'jquery'

    export default {
         data(){
          return{
            separation_status:0,
          }
        },
        created(){
            this.getResults(1);
        },
        components:{
            pageLoading:Loading
        }



    }


    // $('#assetsTable').dataTable( {
    //   "destroy": true,
    //     "pageLength": 5,
    //     "bLengthChange": false,
    //     "bFilter": true,
    //     "bInfo": false,
    //     "bAutoWidth": false
    // });
    // $('.assetsInfo').show(500);
</script>