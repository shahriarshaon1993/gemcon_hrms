
    <div class="">
        <div class="row">
            <div class="col-md-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">General Information</a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Educational Information</a>
                    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Training Information</a>
                    <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Others Information</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" style="padding-top: 0px;">
                        <div class="form-group" style="margin:0px;">
                            <div class="col-md-8 float-left" style="padding:0px;">
                                <div class="col-md-12 general-info">
                                    <h5><strong>General Information</strong></h5>
                                    <table class="table table-hover table-responsive" style="margin-bottom:0px; border:none;">
                                        <tbody>
                                            <tr>
                                                <td style="width:150px">Joining Date</td>
                                                <td style="width:30px;">:</td>
                                                <td>
                                                    <?php
                                                    $joining_date = isset($employee_data['employee_joining_date']) ? $employee_data['employee_joining_date'] : '';
                                                    $date = date_create($joining_date);
                                                    $Joining =  date_format($date, 'j F, Y');
                                                    ?>
                                                    {{$Joining}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px">Length of Service</td>
                                                <td style="width:30px;">:</td>
                                                <td>
                                                    <?php
                                                    $date1 = $employee_data['employee_joining_date'];
                                                    $date2 = date('Y-m-d');
                                                    if (!empty($date1)) {
                                                        $diff = abs(strtotime($date2) - strtotime($date1));

                                                        $yearss = floor($diff / (365 * 60 * 60 * 24));
                                                        $monthss = floor(($diff - $yearss * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                                        $dayss = floor(($diff - $yearss * 365 * 60 * 60 * 24 - $monthss * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                                        printf("%d Years, %d Months and %d Days\n", $yearss, $monthss, $dayss);
                                                    } else {
                                                        echo "Not Found!";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px">Reporting To</td>
                                                <td style="width:30px;">:</td>
                                                <td>
                                                    {{isset($employee_data['reporting_boss'])?$employee_data['reporting_boss']:'Not Found!'}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px">Employee Type</td>
                                                <td style="width:30px;">:</td>
                                                <td>
                                                    <?php
                                                    if (!empty($employee_data['employee_type']) && $employee_data['employee_type'] == 1) {
                                                        $employee_type = 'Permanent';
                                                    } elseif (!empty($employee_data['employee_type']) && $employee_data['employee_type'] == 2) {
                                                        $employee_type = 'Probationary';
                                                    } elseif (!empty($employee_data['employee_type']) && $employee_data['employee_type'] == 3) {
                                                        $employee_type = 'Contractual';
                                                    }
                                                    ?>
                                                    <span>{{isset($employee_type)?$employee_type:'Not Found!'}}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                                <div class="col-md-12 general-info" style="margin-top: 30px;">
                                    <h5><strong>Contact Information</strong></h5>
                                    <table class="table table-hover table-responsive" style="margin-bottom:0px; border:none;">
                                        <tbody>
                                            <tr>
                                                <td style="width:150px">Personal Email </td>
                                                <td style="width:30px;">:</td>
                                                <td id="employee_employee_fullname">{{isset($employee_data['employee_email'])?$employee_data['employee_email']:'Not Found!'}}</td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px">Personal Mobile</td>
                                                <td style="width:30px;">:</td>
                                                <td id="employee_personal_mobile">{{isset($employee_data['employee_mobile'])?$employee_data['employee_mobile']:'Not Found!'}}</td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px">Desk Phone</td>
                                                <td style="width:30px;">:</td>
                                                <td id="employee_desk_phone">{{isset($employee_data['desk_phone_no'])?$employee_data['desk_phone_no']:'Not Found!'}}</td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px">WhatsApp</td>
                                                <td style="width:30px;">:</td>
                                                <td id="employee_whats_app">{{isset($employee_data['whats_app_no'])?$employee_data['whats_app_no']:'Not Found!'}}</td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px">Skype</td>
                                                <td style="width:30px;">:</td>
                                                <td id="employee_skype_no">{{isset($employee_data['skype_no'])?$employee_data['skype_no']:'Not Found!'}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4 float-left">
                                <div class="">
                                    <div class="dropdown-menu dropdown-menu-right profile-setting show" role="menu" style="display: inline;">
                                        <p class="dropdown-item" style="margin-bottom: 5px;"><strong>Actions</strong></p>
                                        <!-- <a class="dropdown-item open_general_info" href="dashboards#/employeemoreinfo/{{Auth::guard('user')->user()->employee_id}}">
                                            <i class="fa fa-user" style="color:orange;"></i> Edit Profile
                                        </a> -->
                                        <!-- <a role="menuitem" href="#" data-menu="settings" class="dropdown-item open_general_info" data-toggle="modal" data-target="#changeProfileModal" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">
                                        <i class="fa fa-user" style="color:orange;"></i> Edit Profile</a> -->
                                        <a href="#" role="menuitem" data-menu="settings" class="dropdown-item" data-toggle="modal" data-target="#changePasswordModal" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">
                                            <i class="fa fa-key" style="color:orange;"></i> Change Password
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" style="padding-top: 0px;">
                        <div class="form-group" style="margin:0px;">
                            <div class="col-md-9 float-left" style="padding:0px;">
                                <p class="text-right" style="margin-bottom: 0px;"><strong><i class="fa fa-graduation-cap" style="color:orange;"></i> Highest Education</strong></p>
                                <?php
                                $higherstEdu = collect($educational_details)->where('eeq_highest_education', 1)->first();
                                if (!empty($higherstEdu)) {
                                    $higherseducstion = $higherstEdu['eeq_degree_name'];
                                } else {
                                    $higherseducstion = 'No Data Found!';
                                }
                                ?>
                                <p class="text-right" style="margin-bottom: 0px;">{{$higherseducstion}}</p>
                                <label><strong>Educational Information</strong></label>
                                <table class="table table-hover table-bordered text-center">
                                    <thead>
                                        <tr style="background: whitesmoke">
                                            <th scope="col">#</th>
                                            <th scope="col">Certificates</th>
                                            <th scope="col">Passing Year</th>
                                            <th scope="col">Educational Institute</th>
                                            <th scope="col">Major Subjects</th>

                                            <th scope="col">Result</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($educational_details as $key => $value) :
                                            $i++;
                                        ?>
                                            <tr>
                                                <th scope="row">{{$i}}</th>
                                                <td>
                                                    {{isset($value['eeq_degree_name'])?$value['eeq_degree_name']:'Not Found!'}}
                                                </td>
                                                <td>
                                                    {{isset($value['eeq_passing_year'])?$value['eeq_passing_year']:'Not Found!'}}
                                                </td>
                                                <td>
                                                    {{isset($value['eeq_institute_name'])?$value['eeq_institute_name']:'Not Found!'}}
                                                </td>
                                                <td>
                                                    {{isset($value['eeq_major_group'])?$value['eeq_major_group']:'Not Found!'}}
                                                </td>
                                                <td>
                                                    {{isset($value['eeq_division_gpa'])?$value['eeq_division_gpa']:'Not Found!'}}
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="col-md-3 float-left">
                                <div class="">
                                    <div class="dropdown-menu dropdown-menu-right profile-setting show" role="menu">
                                        <p class="dropdown-item" style="margin-bottom: 5px;"><strong>Actions</strong></p>
                                        <!-- <a role="menuitem" href="#" data-menu="settings" class="dropdown-item open_general_info" data-toggle="modal" data-target="#changeProfileModal" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">
                                        <i class="fa fa-user" style="color:orange;"></i> Edit Profile </a> -->
                                        <!-- <a class="dropdown-item open_general_info" href="dashboards#/employeemoreinfo/{{Auth::guard('user')->user()->employee_id}}">
                                            <i class="fa fa-user" style="color:orange;"></i> Edit Profile
                                        </a> -->
                                        <a href="#" role="menuitem" data-menu="settings" class="dropdown-item" data-toggle="modal" data-target="#changePasswordModal" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">
                                            <i class="fa fa-key" style="color:orange;"></i> Change Password
                                        </a>
                                        <!-- <div role="separator" class="dropdown-divider"></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" style="padding-top: 0px;">
                        <div class="form-group" style="margin:0px;">
                            <div class="col-md-9 float-left" style="padding:0px;">
                                <p class="text-right" style="margin-bottom: 0px;"><strong><i class="fa fa-tasks" style="color:orange;"></i> Recent Training</strong></p>
                                <?php
                                $recentTraining = collect($training_details)->sortByDesc('id')->first();


                                if (!empty($recentTraining)) {
                                    $recentTrainings = $recentTraining['etr_training_title'];
                                } else {
                                    $recentTrainings = 'No Data Found!';
                                }
                                ?>
                                <p class="text-right" style="margin-bottom: 0px;">{{$recentTrainings}}</p>
                                <label><strong>Training Information</strong></label>
                                <table class="table table-hover table-bordered text-center">
                                    <thead>
                                        <tr style="background: whitesmoke">
                                            <th scope="col">#</th>
                                            <th scope="col">Certificates</th>
                                            <!-- <th scope="col">Passing Year</th> -->
                                            <th scope="col">Educational Institute</th>
                                            <th scope="col">Sponsord by</th>
                                            <th scope="col">Result</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($training_details as $key => $value) :
                                            $i++;
                                        ?>
                                            <tr>
                                                <th scope="row">{{$i}}</th>
                                                <td>
                                                    {{isset($value['etr_training_title'])?$value['etr_training_title']:'Not Found!'}}
                                                </td>
                                                <td>
                                                    {{isset($value['etr_institute_name'])?$value['etr_institute_name']:'Not Found!'}}
                                                </td>
                                                <td>
                                                    {{isset($value['etr_sponsored_by'])?$value['etr_sponsored_by']:'Not Found!'}}
                                                </td>
                                                <td>
                                                    {{isset($value['etr_certificate_received'])?$value['etr_certificate_received']:'Not Found!'}}
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3 float-left">
                                <div class="">
                                    <div class="dropdown-menu dropdown-menu-right profile-setting show" role="menu">
                                        <p class="dropdown-item" style="margin-bottom: 5px;"><strong>Actions</strong></p>
                                        <!-- <a role="menuitem" href="#" data-menu="settings" class="dropdown-item open_general_info" data-toggle="modal" data-target="#changeProfileModal" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">
                                        <i class="fa fa-user" style="color:orange;"></i> Edit Profile</a> -->
                                        <!-- <a class="dropdown-item open_general_info" href="dashboards#/employeemoreinfo/{{Auth::guard('user')->user()->employee_id}}">
                                            <i class="fa fa-user" style="color:orange;"></i> Edit Profile
                                        </a> -->
                                        <a href="#" role="menuitem" data-menu="settings" class="dropdown-item" data-toggle="modal" data-target="#changePasswordModal" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">
                                            <i class="fa fa-key" style="color:orange;"></i> Change Password
                                        </a>
                                        <!-- <div role="separator" class="dropdown-divider"></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" style="padding-top: 0px;">
                        <div class="form-group" style="margin:0px;">
                            <div class="col-md-9 float-left" style="padding:0px;">
                                <!-- <p class="text-right" style="margin-bottom: 0px;"><strong><i class="fa fa-tasks" style="color:orange;"></i> Recent Training</strong></p>
                                <p class="text-right" style="margin-bottom: 0px;">Internal Communication ...</p> -->
                                <label><strong>Family Information</strong></label>
                                <table class="table table-hover table-bordered text-center">
                                    <thead>
                                        <tr style="background: whitesmoke">
                                            <th scope="col">#</th>
                                            <th scope="col">Member Name</th>
                                            <th scope="col">Relationship</th>
                                            <th scope="col">Date of Birth</th>
                                            <th scope="col">Occupaton</th>
                                            <th scope="col">Contact No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($family_details as $key => $value) :
                                            $i++;
                                        ?>
                                            <tr>
                                                <th scope="row">{{$i}}</th>
                                                <td>
                                                    {{isset($value['efd_family_member_name'])?$value['efd_family_member_name']:'Not Found!'}}
                                                </td>
                                                <td>
                                                    {{isset($value['efd_relationship'])?$value['efd_relationship']:'Not Found!'}}
                                                </td>
                                                <td>
                                                    {{isset($value['efd_date_of_birth'])?$value['efd_date_of_birth']:'Not Found!'}}
                                                </td>
                                                <td>
                                                    {{isset($value['efd_occupation'])?$value['efd_occupation']:'Not Found!'}}
                                                </td>
                                                <td>
                                                    {{isset($value['efd_contact_mobile_no'])?$value['efd_contact_mobile_no']:'Not Found!'}}
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3 float-left">
                                <div class="">
                                    <div class="dropdown-menu dropdown-menu-right profile-setting show" role="menu">
                                        <p class="dropdown-item" style="margin-bottom: 5px;"><strong>Actions</strong></p>
                                        <!-- <a role="menuitem" href="#" data-menu="settings" class="dropdown-item open_general_info" data-toggle="modal" data-target="#changeProfileModal" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">
                                        <i class="fa fa-user" style="color:orange;"></i> Edit Profile
                                        </a> -->
                                        <!-- <a class="dropdown-item open_general_info" href="dashboards#/employeemoreinfo/{{Auth::guard('user')->user()->employee_id}}">
                                            <i class="fa fa-user" style="color:orange;"></i> Edit Profile
                                        </a> -->
                                        <a href="#" role="menuitem" data-menu="settings" class="dropdown-item" data-toggle="modal" data-target="#changePasswordModal" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">
                                            <i class="fa fa-key" style="color:orange;"></i> Change Password
                                        </a>
                                        <!-- <div role="separator" class="dropdown-divider"></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
