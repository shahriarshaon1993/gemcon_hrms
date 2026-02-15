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
                                        <h3 class="card-title d-none d-md-block">Employee Info</h3>
                                        <span class="float-sm-right" style="float: right;">
                                        <div   @click="getModalData($event)" class="btn-group"> <span class="btn btn-xs btn-info"><i class="icon-plus"></i>Add New</span> </div>
                                        
                                          <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                                        </span>
                                    </div>
                                </div>
                               <!--  Info boxes -->
                               <div class="row">
                                 <div class="col-12 col-sm-6 col-md-3">
                                   <div class="info-box">
                                     <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                                     <div class="info-box-content">
                                       <span class="info-box-text">Company</span>
                                       <span class="info-box-number">
                                         16
                                         <!-- <small>%</small> -->
                                       </span>
                                     </div>
                                     <!-- /.info-box-content -->
                                   </div>
                                   <!-- /.info-box -->
                                 </div>
                                 <!-- /.col -->
                                 <div class="col-12 col-sm-6 col-md-3">
                                   <div class="info-box mb-3">
                                     <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                                     <div class="info-box-content">
                                       <span class="info-box-text">Department</span>
                                       <span class="info-box-number">45</span>
                                     </div>
                                     <!-- /.info-box-content -->
                                   </div>
                                   <!-- /.info-box -->
                                 </div>
                                 <!-- /.col -->

                                 <!-- fix for small devices only -->
                                 <div class="clearfix hidden-md-up"></div>

                                 <div class="col-12 col-sm-6 col-md-3">
                                   <div class="info-box mb-3">
                                     <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                                     <div class="info-box-content">
                                       <span class="info-box-text">Designation</span>
                                       <span class="info-box-number">760</span>
                                     </div>
                                     <!-- /.info-box-content -->
                                   </div>
                                   <!-- /.info-box -->
                                 </div>
                                 <!-- /.col -->
                                 <div class="col-12 col-sm-6 col-md-3">
                                   <div class="info-box mb-3">
                                     <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                                     <div class="info-box-content">
                                       <span class="info-box-text">Employees</span>
                                       <span class="info-box-number">2,000</span>
                                     </div>
                                     <!-- /.info-box-content -->
                                   </div>
                                   <!-- /.info-box -->
                                 </div>
                                 <!-- /.col -->
                               </div>
                               <!-- /.row -->
                             </div>
                             <!-- /.card-header -->
                             <div class="card-body">
                              <div class="row">
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label>Company</label>
                                    <select class="form-control select2" style="width: 100%;">
                                      <option selected="selected">--Select--</option>
                                      <option>Alaska</option>
                                      <option>California</option>
                                      <option>Delaware</option>
                                      <option>Tennessee</option>
                                      <option>Texas</option>
                                      <option>Washington</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control select2" style="width: 100%;">
                                      <option selected="selected">--Select--</option>
                                      <option>Alaska</option>
                                      <option>California</option>
                                      <option>Delaware</option>
                                      <option>Tennessee</option>
                                      <option>Texas</option>
                                      <option>Washington</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label>Designation</label>
                                    <select class="form-control select2" style="width: 100%;">
                                      <option selected="selected">--Select--</option>
                                      <option>Alaska</option>
                                      <option>California</option>
                                      <option>Delaware</option>
                                      <option>Tennessee</option>
                                      <option>Texas</option>
                                      <option>Washington</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label>Mobile</label>
                                    <select class="form-control select2" style="width: 100%;">
                                      <option selected="selected">--Select--</option>
                                      <option>Alaska</option>
                                      <option>California</option>
                                      <option>Delaware</option>
                                      <option>Tennessee</option>
                                      <option>Texas</option>
                                      <option>Washington</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control select2" style="width: 100%;">
                                      <option selected="selected">--Select--</option>
                                      <option>Alaska</option>
                                      <option>California</option>
                                      <option>Delaware</option>
                                      <option>Tennessee</option>
                                      <option>Texas</option>
                                      <option>Washington</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-md-2">
                                    <label class="control-label">&nbsp;</label><br>
                                    <button type="submit" class="btn btn-info" style="font-size: 14px;padding: 4px 15px; width: 100%"> <i class="fa fa-search"></i> Search</button>
                                </div>
                                <!-- /.col -->
                              </div>


                               <table id="employeeTable" class="table table-bordered table-striped employeeTable">
                                 <thead>
                                 <tr>
                                   <th>Name</th>
                                   <th>Mobile</th>
                                   <th>Designation</th>
                                   <th>Company/SBU</th>
                                   <th>Emp ID</th>
                                   <th>Joining Date</th>
                                   <th>Blood</th>
                                   <th>Action</th>
                                 </tr>
                                 </thead>
                                <tbody v-if="Object.keys(paginate_data.data).length > 0">
                                <tr v-for="(list, index) in paginate_data.data" v-bind:key="list.id">
                                   <td>Faruk Khan</td>
                                   <td>01678617707</td>
                                   <td>Software Engineer</td>
                                   <td>100407</td>
                                   <td>Gemcon Group</td>
                                   <td> 01/06/2020</td>
                                   <td>A+</td>
                                   <td style="padding: 5px 15px">
                                       <div class="btn-group btn-default btn-xs">
                                            <button type="button" data-toggle="dropdown" class="btn dropdown-toggle pad-0">&nbsp;<i class="fa fa-ellipsis-h"></i>&nbsp;</button>
                                            <ul class="dropdown-menu" id="actionlink" style="padding-left:15px;">
                                                <li><a class="badge badge-info" href="" title="View Profile"><i class="fa fa-search"></i> View Profile</a></li>
                                                <li><a class="badge badge-warning" href="./employee_more_info.php" title="Add More Info"><i class="fa fa-plus"></i> Add More Info</a></li>
                                                <li><a class="badge badge-primary" href="" title="Edit"><i class="fa fa-edit"></i> Edit</a></li>
                                                <li><a class="badge badge-danger" href="javascript:void()" title="Inactive" onclick="inactive_items('767')"><i class="fa fa-times"></i> Inactive</a></li>
                                                <li><a class="badge badge-default" href="javascript:void()" title="Sattlement" data-name="A. Rahim" onclick="detais_info('767')" data-toggle="modal" data-target="#detailsmodal"><i class="fa fa-bars" aria-hidden="true"></i> Status</a></li>
                                            </ul>
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


            <div class="toolbar no-padding ">
                <div v-if="lists.add=='add'" @click="getModalData($event, {dataUrl:'salesPerson/create'})" class="btn-group"> <span class="btn btn-xs btn-info"><i class="icon-plus"></i>Add New</span></div>

                <div class="btn-group"> <span class="btn btn-xs  widget-collapse"><i class="icon-refresh"> </i></span> </div>
               <modal name="myModal"  transition="scale" width="550" height="auto" :clickToClose="false">
                   <div v-if="modal_loading">
                       <div class="widget-header">
                           <h4><i class="icon-reorder"></i>Day End Form</h4>
                            <button type="button" @click="hideModal" style="right: -7px;top: 53% !important;" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       </div>
                       <div class="modify-wraper">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td colspan="1">
                                 <form class="well form-horizontal needs-validation" novalidate>
                                  <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Full Name</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                              <input id="fullName" name="fullName"  class="form-control" required="true" type="text">
                                              </div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Father's Name</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine1" name="addressLine1"  class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Mother's Name</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine2" name="addressLine2" placeholder="" class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Company</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="city" name="city" placeholder="" class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Department</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="state" name="state" placeholder="" class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Designation</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="postcode" name="postcode" placeholder="" class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Personal Mobile</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group">
                                                <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                <select class="selectpicker form-control">
                                                   <option></option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Office Mobile</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input id="email" name="email" placeholder="" class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Personal Email</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span><input id="phoneNumber" name="phoneNumber" placeholder="" class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                    </div>
                                  <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Office Email</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="fullName" name="fullName" placeholder="" class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Joining Date</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine1" name="addressLine1" placeholder="" class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Date of Birth</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine2" name="addressLine2" placeholder="" class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Blood Group</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="city" name="city" placeholder="" class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">PBAX No.</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="state" name="state" placeholder="" class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Employee ID</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="postcode" name="postcode" placeholder="" class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">National ID</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group">
                                                <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                                <select class="selectpicker form-control">
                                                   <option></option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Machine ID</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input id="email" name="email" placeholder="" class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-md-4 control-label">Phone Number</label>
                                          <div class="col-md-12 inputGroupContainer">
                                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span><input id="phoneNumber" name="phoneNumber" placeholder="" class="form-control" required="true" type="text"></div>
                                          </div>
                                       </div>
                                       <div style="margin-top:15px;">
                                         <button type="submit" class="btn btn-info float-right" style="margin-left: 10px;">Save changes</button>
                                         <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
                                       </div>
                                    </div>
                                  </div>
                                 </form>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                       </div>
                   </div>
                   <div v-if="!modal_loading">
                       <pageLoading></pageLoading>
                   </div>
                   
               </modal>
            </div>
        </div>
   <!--      <div class="widget-content size-table-layout">
            
        </div> -->
    </div>
    <div v-if="!page_loading">
        <pageLoading></pageLoading>
    </div>
</div>
</template>

<script>
    import Loading from '../Loading.vue';

    export default {

        created(){
            this.getResults(1);
        },
        components:{
            pageLoading:Loading
        }

    }
</script>
