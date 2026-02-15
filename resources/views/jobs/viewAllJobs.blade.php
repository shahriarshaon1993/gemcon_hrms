@include('includs.Header')
<style type="text/css">
    .o_home_menu_background {
        background: none;
    }
</style>
<div class="card-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <a href="https://gemcongroup.com">
                    <img src="{{ asset('admin_assets/images/gemcon-logo.png') }}" alt="Logo" width="100">
                </a>
            </div>
            <div>
                <h3 class="card-title">All Circular Info</h3>
            </div>
            <div></div>
        </div>
    </div>
</div>


<div class="container col-md-12 job-circular-list" style="margin-top: 15px;">
    <div class="container av-logo-container">
        @if (session()->has('message'))
            <div id="successMessage" class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <table ref="table" id="loremTable" summary="lorem ipsum sit amet" rules="groups" frame="hsides"
            class="table table-bordered table-striped employeeTable" border="0">
            <tbody>
                <?php foreach ($all_jobs_data as $key => $value): ?>
                <tr>
                    <td>
                        <div class="norm-jobs-wrapper trigger" style="margin-bottom: 15px;"
                            data-job_circular_id='<?php echo $value->id; ?>' data-jc_company_name='<?php echo $value->jc_company_name; ?>'
                            data-jc_job_position='<?php echo $value->jc_job_position; ?>' data-job_circular_id='<?php echo $value->id; ?>'
                            data-designation='<?php echo $value->designation_name; ?>' data-sbu_name='<?php echo $value->sbu_name; ?>'
                            data-jc_job_vacancy='<?php echo $value->jc_job_vacancy; ?>' data-jc_job_description='<?php echo $value->jc_job_description; ?>'
                            data-jc_job_responsibility='<?php echo $value->jc_job_responsibility; ?>' data-jc_job_nature='<?php echo $value->jc_job_nature; ?>'
                            data-jc_job_location='<?php echo $value->work_location_name; ?>'
                            data-jc_educational_requirements='<?php echo $value->jc_educational_requirements; ?>'
                            data-jc_experience_requirements='<?php echo $value->jc_experience_requirements; ?>'
                            data-jc_job_requirements='<?php echo $value->jc_job_requirements; ?>' data-jc_salary_range='<?php echo $value->jc_salary_range; ?>'
                            data-jc_other_benefits='<?php echo $value->jc_other_benefits; ?>'
                            data-jc_circular_publish_date='<?php echo date('d M Y', strtotime($value->jc_circular_publish_date)); ?>'
                            data-jc_circular_expired_date='<?php echo date('d M Y', strtotime($value->jc_circular_expired_date)); ?>'>
                            <div class="row">
                                <div class="col-sm-3 col-sm-push-3"></div>
                                <div class="col-sm-9 col-sm-pull-9">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="job-title-text">
                                                <a onclick="clickJObTitle()" target="_blank"
                                                    href="jobdetails.asp?id=915530&amp;fcatId=8&amp;ln=1">
                                                    <?php echo $value->designation_name; ?>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="comp-name-text">
                                                <?php echo $value->sbu_name; ?>
                                                <?php //echo $value->jc_job_responsibility;
                                                ?>
                                            </div>
                                        </div>


                                        <div class="col-sm-12">
                                            <div class="locon-text">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="locon-text-d">
                                                            <i class="fa fa-map-marker"></i>
                                                            <?php echo $value->work_location_name; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="edu-text">
                                                <div class="edu-text-d">
                                                    <ul>
                                                        <li> <i class="fa fa-graduation-cap"></i>
                                                            <?php echo $value->jc_educational_requirements; ?>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="col-sm-12">

                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="exp-text">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="exp-text-d" style="padding-left: 10px;">
                                                            <i class="fa fa-clock"></i>
                                                            <?php echo $value->jc_experience_requirements; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="dead-text">
                                                <button id="trigger" data-toggle="modal"
                                                    data-target=".bd-example-modal-lg"
                                                    class="btn btn-info btn-xs trigger" title="Edit"
                                                    data-job_circular_id='<?php echo $value->id; ?>'
                                                    data-jc_company_name='<?php echo $value->jc_company_name; ?>'
                                                    data-jc_job_position='<?php echo $value->jc_job_position; ?>'
                                                    data-job_circular_id='<?php echo $value->id; ?>'
                                                    data-designation='<?php echo $value->designation_name; ?>'
                                                    data-sbu_name='<?php echo $value->sbu_name; ?>'
                                                    data-jc_job_vacancy='<?php echo $value->jc_job_vacancy; ?>'
                                                    data-jc_job_description='<?php echo $value->jc_job_description; ?>'
                                                    data-jc_job_responsibility='<?php echo $value->jc_job_responsibility; ?>'
                                                    data-jc_job_nature='<?php echo $value->jc_job_nature; ?>'
                                                    data-jc_job_location='<?php echo $value->work_location_name; ?>'
                                                    data-jc_educational_requirements='<?php echo $value->jc_educational_requirements; ?>'
                                                    data-jc_experience_requirements='<?php echo $value->jc_experience_requirements; ?>'
                                                    data-jc_job_requirements='<?php echo $value->jc_job_requirements; ?>'
                                                    data-jc_salary_range='<?php echo $value->jc_salary_range; ?>'
                                                    data-jc_other_benefits='<?php echo $value->jc_other_benefits; ?>'
                                                    data-jc_circular_publish_date='<?php echo date('d M Y', strtotime($value->jc_circular_publish_date)); ?>'
                                                    data-jc_circular_expired_date='<?php echo date('d M Y', strtotime($value->jc_circular_expired_date)); ?>'>
                                                    <i class="fa fa-eye"></i>
                                                    View Details
                                                </button>


                                                <button class="btn btn-success btn-xs apply_online" data-toggle="modal"
                                                    data-target="#exampleModal"
                                                    data-job_circular_id='<?php echo $value->id; ?>'
                                                    data-jc_company_name='<?php echo $value->jc_company_name; ?>'
                                                    data-jc_job_position='<?php echo $value->jc_job_position; ?>'
                                                    data-designation='<?php echo $value->designation_name; ?>'
                                                    data-sbu_name='<?php echo $value->sbu_name; ?>'> <i
                                                        class="fa fa-paper-plane"> </i> Apply Online </button>
                                                <div class="dead-text-s"><i class="fa fa-calendar"
                                                        aria-hidden="true"></i> Deadline:&nbsp; <strong>
                                                        <?php echo date('d M Y', strtotime($value->jc_circular_expired_date)); ?>
                                                    </strong></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>


<!-- ######################### View Details Modal ################################-->
<!-- ######################### View Details Modal ################################-->
<!-- ######################### View Details Modal ################################-->
<!-- ######################### View Details Modal ################################-->

<div id="myModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title job-title" id="exampleModalLabel"></h5>
                <!-- (<span class="sbu_name"></span>) -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="">
                        <div class="left">
                            <div class="row">
                                <div class="col-sm-9 col-sm-pull-9">
                                    <h4 class="job-title designation"></h4>
                                    <h2 class="company-name sbu_name" id="com_name"><span
                                            style="font-weight: normal;"> </span></h2>
                                </div>
                            </div>
                            <div class="vac">
                                <h5>Vacancy</h5>
                                <p class="jc_job_vacancy">
                                </p>
                            </div>
                            <div class="job_des">
                                <h5 class="">
                                    Job Context
                                </h5>
                                <p class="col-md-12  jc_job_description">
                                </p>
                            </div>
                            <div class="job_des">
                                <h5>Job Responsibilities </h5>
                                <span class="jc_job_responsibility">
                                </span>
                            </div>
                            <div class="job_nat">
                                <h5>
                                    Employment Status
                                </h5>

                                <p class="col-md-12  jc_job_nature">
                                </p>
                            </div>
                            <div class="job_nat">
                                <h5>
                                    Workplace
                                </h5>
                                <span class="col-md-12  jc_job_location">
                                </span>
                            </div>
                            <div class="edu_req">
                                <h5>Educational Requirements</h5>
                                <span class="col-md-12  jc_educational_requirements">
                                </span>
                            </div>
                            <div class="edu_req">
                                <h5>Experience Requirements</h5>
                                <span class="col-md-12  jc_experience_requirements">
                                </span>
                            </div>
                            <div class="job_req">
                                <h5 class="">
                                    Additional Requirements
                                </h5>
                                <sapn class="jc_job_requirements">
                                </sapn>
                            </div>
                            <div class="job_loc " style="line-height: 24px;">
                                <h5>Job Location</h5>
                                <p class="col-md-12 jc_job_location"></p>
                            </div>
                            <div class="salary_range">
                                <h5>Salary</h5>
                                <span class="col-md-12 jc_salary_range">
                                </span>
                            </div>
                            <div class="oth_ben">
                                <h5>
                                    Compensation &amp; Other Benefits
                                </h5>
                                <span class="jc_other_benefits">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="guide text-center ">
                        <div class="rba">
                            <h4>
                                Read Before Apply
                            </h4>
                            <div class="rba-title-divider-l"></div>
                            <div class="s-sug-txt">
                                <div class="instruction-details">This is an urgent requirements.</div>
                            </div>
                        </div>
                        <div class="pho-txt">
                            <h4>
                                <span class="red">*Photograph</span> must be enclosed with the resume.
                            </h4>
                        </div>
                        <div class="apto">
                            <h3>
                                Apply Procedure
                            </h3>
                        </div>
                        <input type="hidden" name="" class="job_circular_id">
                        <input type="hidden" name="" class="jc_company_name">
                        <input type="hidden" name="" class="jc_job_position">
                        <div class="apply text-center">
                            <a class="btn btn-success apply_online_1" href="#oappm" data-toggle="modal"
                                data-target="#exampleModal">Apply Online</a>
                        </div>
                        <br>
                        <div>
                            <span class="date">
                                Application Deadline : <strong class="jc_circular_expired_date"></strong>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
</div>

<!-- ############################# Apply Online Modal ##############################-->
<!-- ############################# Apply Online Modal ##############################-->
<!-- ############################# Apply Online Modal ##############################-->

<div class="modal fade applyModal" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border: 0px;">
            <div class="modal-header" style="background: #fec23c;color: #fff;">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fa fa-bars"></i>
                    Apply Online
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 cv_form">
                    <form action="{{ route('jobApply') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <fieldset>
                            <input name="jac_job_circular_id" type="hidden"
                                class="form-control input-md circular_id">
                            <input name="jac_company_name" type="hidden"
                                class="form-control input-md company_name_id">
                            <input name="jac_job_position" type="hidden"
                                class="form-control input-md job_position_id">
                            <div class="form-group">
                                <label class="col-md-12 control-label" for="post">
                                    Position Applied
                                    <!-- <span class="required" style="color:red">*</span> -->
                                </label>
                                <div class="col-md-12">
                                    <input id="name" type="text" placeholder=""
                                        class="form-control input-md job_position" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 control-label" for="name">Name <span class="required"
                                        style="color:red">*</span></label>
                                <div class="col-md-12">
                                    <input id="name" name="jac_candidate_name" type="text"
                                        placeholder="Full Name" class="form-control input-md" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 control-label" for="name">Address <span class="required"
                                        style="color:red">*</span></label>
                                <div class="col-md-12">
                                    <textarea id="name" name="jac_candidate_address" placeholder="Example: Mirpur, Dhaka"
                                        class="form-control input-md" required=""></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" style="padding-right: 0px;">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="Gender">Gender </label>
                                        <div class="col-md-12">
                                            <label class="radio-inline" for="Gender-0">
                                                <input type="radio" name="jac_gender" id="Gender-0"
                                                    value="1" checked="checked">
                                                Male
                                            </label>
                                            <label class="radio-inline" for="Gender-1">
                                                <input type="radio" name="jac_gender" id="Gender-1"
                                                    value="2">
                                                Female
                                            </label>
                                            <label class="radio-inline" for="Gender-2">
                                                <input type="radio" name="jac_gender" id="Gender-2"
                                                    value="3">
                                                Others
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding-left: 0px;">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="date">Date of Birth <span
                                                class="required" style="color:red">*</span></label>
                                        <div class="col-md-12 input-group"
                                            style="padding-left:15px;padding-right:15px;">
                                            <div class="input-group-addon" style="border-radius: 0px;">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input class="form-control input-md" id="date" name="jac_birth_day"
                                                placeholder="dd-mm-yyyy" type="text" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" style="padding-right:0px;">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="contact_no">Contact No. <span
                                                class="required" style="color:red">*</span></label>
                                        <div class="col-md-12">
                                            <input id="contact_no" name="jac_contact_no" type="number"
                                                placeholder="Contact No." class="form-control input-md"
                                                required="">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding-left: 0px;">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="email">Email Address <span
                                                class="required" style="color:red">*</span></label>
                                        <div class="col-md-12">
                                            <input id="email" name="jac_email_address" type="email"
                                                placeholder="Keep your email address" class="form-control input-md"
                                                required="">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" style="padding-right:0px">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="name">Highest Education
                                        </label>
                                        <div class="col-md-12">
                                            <input id="name" name="jac_highest_education" type="text"
                                                placeholder="Master of Science" class="form-control input-md"
                                                required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding-left:0px">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="name">University Name </label>
                                        <div class="col-md-12">
                                            <div class="input-group" id="leave_type_id_select2">
                                                <select name="jac_universitgy_name" class="js-example-basic-single"
                                                    style="width: 100%;">
                                                    <option>--Select--</option>
                                                    <?php foreach ($university_lists_data as $key => $value): ?>
                                                    <option value="<?php echo $value->id; ?>"><?php echo $value->university_name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12 control-label" for="name">Last Employment</label>
                                <div class="col-md-12">
                                    <input id="name" name="jac_last_employment" type="text"
                                        placeholder="Last Employment Office Name" class="form-control input-md"
                                        required="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" style="padding-right:0px">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="name">Designation </label>
                                        <div class="col-md-12">
                                            <input id="name" name="jac_last_designation" type="text"
                                                placeholder="Last Designation" class="form-control input-md"
                                                required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding-left:0px">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="name">Experience </label>
                                        <div class="col-md-12">
                                            <input id="name" name="jac_last_experience" type="text"
                                                placeholder="Last Experience" class="form-control input-md"
                                                required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 control-label" for="name">Expected Salary</label>
                                <div class="col-md-12">
                                    <input id="name" name="jac_expected_salary" type="number"
                                        placeholder="Expected Salary" class="form-control input-md" required="">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" style="padding-right:0px;">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="imgInp">Picture <span
                                                class="required" style="color:red">*</span></label>
                                        <div class="col-md-12 input-group"
                                            style="padding-left:15px;padding-right:15px;">
                                            <div class="col-md-12" style="padding:0px;">
                                                <input type="file" name="jac_image" class="form-control">
                                                <span style="font-size:10px;color:red;">(Accepted File Type: .jpg,
                                                    .jpeg, .png)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding-left: 0px;">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="cv_file">Attach CV <span
                                                class="required" style="color:red">*</span></label>
                                        <div class="col-md-12 input-group">
                                            <div class="col-md-12" style="padding:0px;">
                                                <input class="form-control" type="file" name="jac_cv"
                                                    id="cv_file" required="">
                                                <span style="font-size:10px;color:red;">(Accepted File Type: .doc,
                                                    .docx, .pdf)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-info">SUBMIT</button>
                <!-- <input type="submit" name="submit" value="Submit" class="btn btn-success">SUBMIT</input> -->
            </div>
            </form>
        </div>
    </div>
</div>
















<footer style="position: fixed; padding: 15px; background: #f1f1f1;   bottom: 0;  left: 0; text-align: center;"
    class="col-md-12">
    Copyright @ <?php echo date('Y'); ?> <a href="https://gemcongroup.com/" target="_blank">Gemcon Group</a>. All rights
    reserved. Developed by Gemcon IT.
</footer>
@include('includs.Footer')
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />
<script type="text/javascript">
    $(function() {
        setTimeout(function() {
            $("#successMessage").hide('blind', {}, 500)
        }, 3000);
    });
    $(document).ready(function() {
        var date_input = $('input[name="jac_birth_day"]'); //our date input has the name "date"
        var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'dd-mm-yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    })
    $('.trigger').click(function() {
        var job_circular_id = $(this).data('job_circular_id');
        var jc_company_name = $(this).data('jc_company_name');
        var jc_job_position = $(this).data('jc_job_position');
        var designation = $(this).data('designation');
        var sbu_name = $(this).data('sbu_name');
        var jc_job_vacancy = $(this).data('jc_job_vacancy');
        var jc_job_description = $(this).data('jc_job_description');
        var jc_job_responsibility = $(this).data('jc_job_responsibility');
        var jc_job_nature = $(this).data('jc_job_nature');
        if (jc_job_nature == 1) {
            jc_job_nature = 'Full Time';
        } else if (jc_job_nature == 2) {
            jc_job_nature = 'Half Time';
        } else if (jc_job_nature == 3) {
            jc_job_nature = 'Contractual';
        }
        var jc_job_location = $(this).data('jc_job_location');
        var jc_educational_requirements = $(this).data('jc_educational_requirements');
        var jc_experience_requirements = $(this).data('jc_experience_requirements');
        var jc_job_requirements = $(this).data('jc_job_requirements');
        var jc_salary_range = $(this).data('jc_salary_range');
        var jc_other_benefits = $(this).data('jc_other_benefits');
        var jc_circular_publish_date = $(this).data('jc_circular_publish_date');
        var jc_circular_expired_date = $(this).data('jc_circular_expired_date');
        // alert(designation);

        $(".job_circular_id").val(job_circular_id);
        $(".jc_company_name").val(jc_company_name);
        $(".jc_job_position").val(jc_job_position);
        $(".job-title").html(designation);
        $(".sbu_name").html(sbu_name);
        $(".jc_job_vacancy").html(jc_job_vacancy);
        $(".jc_job_description").html(jc_job_description);
        $(".jc_job_responsibility").html(jc_job_responsibility);
        $(".jc_job_nature").html(jc_job_nature);
        $(".jc_job_location").html(jc_job_location);
        $(".jc_educational_requirements").html(jc_educational_requirements);
        $(".jc_experience_requirements").html(jc_experience_requirements);
        $(".jc_job_requirements").html(jc_job_requirements);
        $(".jc_salary_range").html(jc_salary_range);
        $(".jc_other_benefits").html(jc_other_benefits);
        $(".jc_circular_publish_date").html(jc_circular_publish_date);
        $(".jc_circular_expired_date").html(jc_circular_expired_date);
        $('#myModal').modal('show');
        return false;
    })
    $('.apply_online').click(function() {
        var designation = $(this).data('designation');
        var job_circular_id = $(this).data('job_circular_id');
        var jc_company_name = $(this).data('jc_company_name');
        var jc_job_position = $(this).data('jc_job_position');
        $(".circular_id").val(job_circular_id);
        $(".company_name_id").val(jc_company_name);
        $(".job_position_id").val(jc_job_position);
        $(".job_position").val(designation);
        $('.applyModal').modal('show');
        $('#myModal').modal('hide');
        return false;
    })
    $('.apply_online_1').click(function() {
        var designation = $('.designation').text();
        var job_circular_id = $('.job_circular_id').val();
        var jc_company_name = $('.jc_company_name').val();
        var jc_job_position = $('.jc_job_position').val();
        $(".company_name_id").val(jc_company_name);
        $(".job_position_id").val(jc_job_position);
        $(".job_position").val(designation);
        $(".circular_id").val(job_circular_id);
        $('.applyModal').modal('show');
        $('#myModal').modal('hide');
        return false;
    })

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>

<style type="text/css">
    .table-bordered {
        border: 1px solid #ffffff;
    }

    .border-top {
        display: none !important;
    }

    .norm-jobs-wrapper {
        background: #FBFBFB;
        border: 1px solid #d5d5d5;
        cursor: pointer;
        padding: 5px 18px 15px 10px;
        /*margin: 0px 0px 5px 0px;*/
        border-radius: 8px;
        color: #656565;
    }

    .norm-jobs-wrapper .col-sm-push-3 {
        left: 75%;
    }

    .norm-jobs-wrapper .col-sm-pull-9 {
        right: 25%;
    }

    .job-title-text {
        color: #43A047;
        font-weight: bold;
        margin: 10px 0px 0px 10px;
        font-size: 18px;
    }

    .comp-name-text {
        margin: 5px 0px 5px 10px;
        font-size: 14px;
        font-weight: bold;
        color: #333333;
    }

    .locon-text {
        margin: 5px 0px 0px 10px;
    }

    .edu-text {
        margin: 5px 0px -3px 10px;
    }

    .edu-text-d {
        margin: 0px;
    }

    .edu-text-d img {
        width: 18px;
        height: 18px;
        vertical-align: top !important;
        float: left;
    }

    .job-title-text a:visited {
        color: #551a8b;
    }

    .job-title-text a {
        text-decoration: none;
        color: #348334;
    }

    .locon-text-d img {
        width: 18px;
        height: 18px;
        margin-right: 7px;
        float: left;
    }

    .edu-text-d ul {
        list-style: none;
        padding-left: 0px;
    }

    .norm-jobs-wrapper:hover {
        background: #F5F5F5;
        cursor: pointer;
        -webkit-box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16);
        -moz-box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16);
        box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16);
    }

    .job-circular-list .table td,
    .table th {
        padding: 0px;
    }

    .logo img {
        width: 100px;
        height: 60px;
        margin-top: 0px;
    }

    .table-bordered td,
    .table-bordered th {
        border: none !important;
    }

    .cv_form {
        box-shadow: 0PX 0PX 5PX #ccc;
        /* margin-bottom: 25px; */
        border: 0px solid #ccc;
        padding: 20px;
        /*background: #FFFFDF none repeat scroll 0 0;*/
        color: #000;
    }

    legend {
        display: block;
        width: 100%;
        max-width: 100%;
        padding: 0;
        margin-bottom: .5rem;
        font-size: 1.5rem;
        line-height: inherit;
        color: inherit;
        white-space: normal;
    }

    .input-group-addon {
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 400;
        line-height: 1;
        color: #555;
        text-align: center;
        background-color: #eee;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>

</body>

</html>
