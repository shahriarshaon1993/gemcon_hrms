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
                                    <h3 class="card-title d-none d-md-block">Employee's More Info</h3>
                                    <span class="float-sm-right" style="float: right;">
                                        <a class="btn btn-default" href="./employees.php"><i class="fa fa-arrow-left"></i> Back</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="page-wrapper">
                                <div class="row" style="margin-top: -10px;">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label>Employee</label>
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

                                    <div class="col-md-3">
                                        <label class="control-label">&nbsp;</label><br>
                                        <button type="submit" class="btn btn-info" style="font-size: 14px;padding: 4px 15px; width: 100%"> <i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3 class="page-header">Faruk Khan</h3>           
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-md-2"> Father's Name:</div>
                                            <div class="col-md-3" style="text-align: left;">Akbar Ali Khan</div>
                                            <div class="col-md-2">Contact No.:</div>
                                            <div class="col-md-5" style="text-align: left;">01678617707</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">Joining Date:</div>
                                            <div class="col-md-3" style="text-align: left;">01 June 2020</div>
                                            <div class="col-md-2">Designation:</div>
                                            <div class="col-md-5" style="text-align: left;">Software Engineer</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">Department:</div>
                                            <div class="col-md-3" style="text-align: left;">IT</div>
                                            <div class="col-md-2">Company/SBU:</div>
                                            <div class="col-md-5" style="text-align: left;">Gemcon Group</div>
                                        </div>           
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#employmentinfo" role="tab" aria-controls="home" aria-selected="true">Employment<br>Information</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#personalinfo" role="tab" aria-controls="home" aria-selected="true">Personal <br>Information</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="employmentinfo">
                                                    <div class="alert alert-success alert-dismissable" style="display: none;">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                        <span id="submitxt"></span>
                                                    </div>
                                                    <h5 class="col-md-12" style="padding: 10px 28px;"><u>Employment Information</u></h5>     
                                                    <form class="form-horizontal" id="employmentinfo">
                                                        <input type="hidden" name="empid" value="767">
                                                        <div class="container">
                                                           <table class="table table-striped">
                                                              <tbody>
                                                                 <tr>
                                                                    <td colspan="1">
                                                                       <form class="well form-horizontal needs-validation" novalidate>
                                                                        <div class="row">
                                                                          <div class="col-md-6">
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Employee Name</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                                                    <input id="fullName" name="fullName"  class="form-control" required="true" type="text">
                                                                                    </div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Designation</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine1" name="addressLine1"  class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Department</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine2" name="addressLine2" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Interview Date</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="city" name="city" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Appoinment Date</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="postcode" name="postcode" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                          </div>
                                                                       <!-- </form> -->
                                                                   <!--  </td>
                                                                    <td colspan="1"> -->
                                                                        <div class="col-md-6">
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">ID</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="fullName" name="fullName" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Job Grade</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine1" name="addressLine1" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">SBU</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine2" name="addressLine2" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Work Location</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="city" name="city" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Joining Date</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="state" name="state" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div style="margin-top:15px;">
                                                                               <button type="submit" class="btn btn-info float-right" style="margin-left: 10px;">Save changes</button>
                                                                             </div>
                                                                          </div>
                                                                        </div>
                                                                       </form>
                                                                    </td>
                                                                 </tr>
                                                              </tbody>
                                                           </table>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="personalinfo">
                                                    <div class="alert alert-success alert-dismissable" style="display: none;">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                        <span id="submitxt"></span>
                                                    </div>
                                                    <h5 class="col-md-12" style="padding: 10px 28px;"><u>Personal Information</u></h5>                      
                                                    <form class="form-horizontal" id="personalinfo">
                                                        <input type="hidden" name="empid" value="767">
                                                        <div class="container">
                                                           <table class="table table-striped">
                                                              <tbody>
                                                                 <tr>
                                                                    <td colspan="1">
                                                                       <form class="well form-horizontal needs-validation" novalidate>
                                                                        <div class="row">
                                                                          <div class="col-md-6">
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">NID/Certificate Name</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                                                    <input id="fullName" name="fullName"  class="form-control" required="true" type="text">
                                                                                    </div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Father’s Name</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine1" name="addressLine1"  class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Date of Birth(Certificate)</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine1" name="addressLine1"  class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Marital Status</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine2" name="addressLine2" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Spouse Name</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine2" name="addressLine2" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Nationality</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="postcode" name="postcode" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Blood Group</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="postcode" name="postcode" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Mobile No.</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="postcode" name="postcode" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Email</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="postcode" name="postcode" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                          </div>
                                                                        <div class="col-md-6">
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Nick Name</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="fullName" name="fullName" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Mother’s Name</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine1" name="addressLine1" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Date of Birth(Actual)</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine2" name="addressLine2" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Marriage Date</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine2" name="addressLine2" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">No. of Children</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="city" name="city" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Religion</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="city" name="city" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Height</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="state" name="state" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                <label class="col-md-4 control-label">Weight (kg)</label>
                                                                                <div class="col-md-12 inputGroupContainer">
                                                                                   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="state" name="state" placeholder="" class="form-control" required="true" type="text"></div>
                                                                                </div>
                                                                             </div>
                                                                             <div style="margin-top:15px;">
                                                                               <button type="submit" class="btn btn-info float-right" style="margin-left: 10px;">Save changes</button>
                                                                             </div>
                                                                          </div>
                                                                        </div>
                                                                       </form>
                                                                    </td>
                                                                 </tr>
                                                              </tbody>
                                                           </table>
                                                        </div>
                                                    </form>
                                                </div>    
                                            </div>
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
