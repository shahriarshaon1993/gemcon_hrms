    <div class="row">
        <div class="col-md-9 table-responsive" style="margin-bottom: -14px;">
            <h5 style="margin-bottom: 25px;"><i class="fa fa-bars"></i> Employee Directory
                <span style="float: right; padding-left: 15px;">
                    <button class="btn btn-warning" href="#" onclick="pabx_show()" data-toggle="modal" data-target="#pabxNoModal" data-whatever="@getbootstrap">PABX</button>
                </span>
                <span style="float: right; padding-left: 15px;">
                    <button class="btn btn-warning" href="#" data-toggle="modal" data-target="#emailListModal" data-whatever="@getbootstrap">Email List</button>
                </span>
                <span id="grid_hide_show" style="float: right; cursor:pointer; margin-top: 6px; font-size:18px;">
                    <i class="fa fa-list"></i>
                </span>
                <span id="grid_hide_show1" style="float: right; display: none; cursor:pointer; margin-top: 6px; font-size:18px;">
                    <i class="fa fa-th-large"></i>
                </span>
            </h5>
            <label style="margin-bottom: 25px; width: 100%">
                <div class="input-group"><span style="font-size: 19px;border-radius: 5px 0px 0px 5px;" class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" style=" background: #ffc10724;border-radius: 0px 5px 5px 0px;box-shadow: 0 0 0 0rem rgb(0 123 255 / 0%);" name="serach" id="serach" class="form-control" placeholder="Search Employee (ID or Name)" />
                </div>
            </label>
            <table id="" class="table table-striped table-bordered list_view" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center" style="padding: .75rem;">#</th>
                        <th class="text-center" style="padding: .75rem;">Emp ID</th>
                        <th class="text-center" style="padding: .75rem;">Name</th>
                        <th class="text-center" style="padding: .75rem;">Comp/SBU</th>
                        <th class="text-center" style="padding: .75rem;">Department</th>
                        <th class="text-center" style="padding: .75rem;">Designation</th>
                        <th class="text-center" style="padding: .75rem;">Action</th>
                    </tr>
                </thead>
                <tbody id="exampleDataTable123">
                    @include('layouts.pagination_data')
                </tbody>
            </table>
            <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
            <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
            <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
            <input type="hidden" name="view_type" id="view_type" value="1" />
            <div class="grid_view col-md-12" id="exampleDataTable1234" style="display: none;">
                @include('layouts.pagination_data_grid')
            </div>
        </div>
        <div class="col-md-3" style="border: 1px solid #e0e0e0;padding:0px;">
            <div class="col-md-12" style="padding:8px;background: #ffa63d;color:#fff;">
                <i class="fa fa-list"> Employee Information</i>
            </div>
            <div class="col-md-12 employee_directory_profile" style="text-align: center;margin-top:15px;">
                <?php if (!empty($employee_image) && file_exists(public_path('images/' . $employee_image))) : ?>
                    <img id="employee_image" class="img-responsive text-center" src="{{asset('images/'.$employee_image )}}" style="height: 130px; width: 107px;">
                <?php else : ?>
                    <img id="employee_image" class="img-responsive text-center" src="{{asset('images/default.png')}}" style="height: 130px; width: 107px;">
                <?php endif ?>
                <?php if(!empty($download) == 'download'){ ?>
                <a title="Download" class="btn btn-lg image-download" href="{{asset('images/'.$employee_image )}}" download="<?php echo $employee_image ?>"><i class="fa fa-download" aria-hidden="false"></i></a>
                <?php } ?>
                <h1 class="qr_code_data_1" style="font-size:20px; font-weight: bold; margin-top: 5px; margin-bottom: 0px;">
                    <span id="employee_fullname" class="" name="name" placeholder="Employee's Name">
                        {{isset($employee_data['employee_fullname'])?$employee_data['employee_fullname']:$user->name}}
                    </span>
                </h1>
                <p class="qr_code_data_2" style="margin-bottom: 2px;">
                    <span id="designation_name">{{isset($employee_data['designation_name'])?$employee_data['designation_name']:'Not Found!' }}</span>, <span id="section_name">
                        {{ isset($employee_data['section_name'])?$employee_data['section_name']:''}}
                    </span>
                </p>
                <p id="department_name" class="qr_code_data_3" style="margin-bottom: 2px;">
                    {{isset($employee_data['department_name'])?$employee_data['department_name']:'Not Found!'}}
                </p>
                <p id="sbu_name" class="qr_code_data_4" style="margin-bottom: 2px;">
                    {{isset($employee_data['sbu_name'])?$employee_data['sbu_name']:'Not Found!'}}
                </p>

                <div style="margin-top: 5px;">
                    <?php
                        if($employee_data['employee_status'] == '1'){
                            $status = 'Active';
                            $color = 'green';
                        }elseif($employee_data['employee_status'] == '0'){
                            $status = 'Inactive';
                            $color = 'red';
                        }elseif($employee_data['employee_status'] == '2'){
                            $status = 'Resigned';
                            $color = 'red';
                        }else{
                            $status = '';
                            $color = '#dddddd';
                        }
                    ?>
                    <span id="employee_status_text" class="background_color" style="background: <?php echo $color; ?>;color: #fff;padding: 2px 10px;border-radius: 15px;">
                        {{ $status }}
                    </span>
                </div>
                <div class="col-md-12 float-left text-left" style="padding:0px;margin-top: 30px; ">
                    <p style="margin-bottom:4px;">
                        <?php
                        $employee_dob = isset($employee_data['employee_dob_actual']) ? $employee_data['employee_dob_actual'] : '';

                        if (empty($employee_dob) || $employee_dob == '0000-00-00') {
                            $employee_dob = isset($employee_data['employee_dob_certificate']) ? $employee_data['employee_dob_certificate'] : '';
                            if ($employee_dob == 0 || $employee_dob == '0000-00-00') {
                                $employee_dob = '';
                            }
                        }
                        ?>
                        <i class="fa fa-birthday-cake" style="color:orange;     padding-right:5px;"></i>
                        <span id="employee_dob_actual" class="qr_code_data_7"><?php echo date('d F', strtotime($employee_dob)); ?>

                        </span>
                    </p>
                    <p style="padding-right: 30px; font-size: 13px; margin-bottom:4px;">
                        <i class="fa fa-tint" style="color:orange;     padding-right: 10px;font-size: 18px"></i> Blood Group
                        <span class="qr_code_data_9" id="employee_blood_group" style="background-color: #e04d4d; border-radius:4px; padding:0px 5px; color:#fff">{{isset($employee_data['employee_blood_group'])?$employee_data['employee_blood_group']:'Not Found!'}}
                        </span>
                    </p>

                    <p style="margin-bottom:4px;">
                        <?php
                        $official_mobile = isset($employee_data['employee_mobile']) ? $employee_data['employee_mobile'] : '';
                        if (!empty($official_mobile)) {
                            $mobile_no = $official_mobile;
                        } else {
                            $mobile_no = isset($employee_data['employee_mobile']) ? $employee_data['employee_mobile'] : 'Not Found!';
                        }
                        ?>
                        <i class="fa fa-phone-square" style="color:orange;     padding-right: 10px;"></i>
                        <span id="employee_mobile" class="qr_code_data_6">{{$mobile_no}}</span>
                    </p>
                    <p style="margin-bottom:4px;">
                        <?php
                        $desk_phone = isset($employee_data['desk_phone_no']) ? $employee_data['desk_phone_no'] : '';
                        if (!empty($desk_phone)) {
                            $desk_phone = $desk_phone;
                        } else {
                            $desk_phone = 'Not Found!';
                        }
                        ?>
                        <i class="fa fa-fax" style="color:orange;     padding-right: 10px;"></i><span id="desk_phone" class="qr_code_data_6">{{$desk_phone}}</span>
                    </p>


                    <p style="margin-bottom:4px;">
                        <?php
                        $official_email = isset($employee_data['official_email_id']) ? $employee_data['official_email_id'] : '';
                        if (!empty($official_email)) {
                            $email_id = $official_email;
                        } else {
                            $email_id = isset($employee_data['employee_email']) ? $employee_data['employee_email'] : 'Not Found!';
                        }
                        ?>
                        <i class="fa fa-envelope" style="color:orange;     padding-right: 10px;"></i><span id="official_email_id" class="qr_code_data_7">{{$email_id}}</span>
                    </p>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="pabxNoModal" tabindex="-1" role="dialog" aria-labelledby="serviceRequestLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 65%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title col-md-10" id="serviceRequestLabel">
                        <i class="fa fa-list"></i>
                        PABX List
                    </h5>
                    <button id="clickBtnPrint" type="button" class="btn-success">
                        <i class="fa fa-print"></i> Print
                    </button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin:0px;">
                        <div class="col-md-12">
                            <input class="col-md-3 float-right" type="text" id="myInput" onkeyup="pabxSearchFunction()" placeholder="Search for PABX extension..." title="Type in a name">
                        </div>
                    </div>

                    <div class="col-md-12" id="pabxListPrint">
                        <div class="row">
                            <div class="col-md-2" style="text-align: center;">
                                <img width="70" height="46" src="{{asset('admin_assets/images/gemcon-logo.png')}}" style="margin-top:28px;">
                            </div>
                            <div class="col-md-10" style="text-align: center;">
                                <a href="/index" class="fa o_menu_toggle" title="Applications" aria-label="Applications"> </a>
                                <h2> Gemcon Group</h2>
                                <h3>PABX Extensions</h3>
                                <br>
                            </div>
                        </div>
                        <div class="container-fluid" id="container-fluid">
                            <div id="grid">
                                @php

                                foreach ($sbueName as $key => $value) {
                                $emply=collect($pabxnumber)->where('employee_sbu',$value['id'])->toArray();
                                $depertId=collect($emply)->pluck('employee_department')->toArray();
                                $deprtment=collect($depertment)->whereIn('id',$depertId)->toArray();
                                @endphp
                                <div class="grid-item col-md-3">
                                    <div class="row pabxListPrint" style="border: 1px solid #ddd;">
                                        <div class="col-md-12 pabxListPrint" style="background: #121213;color: #fff;padding: 2px 4px;">
                                            <h5 style="color: #fff; margin-bottom: 0;line-height: 27px;text-overflow: ellipsis;width: 100%;overflow: hidden;white-space: nowrap;" title="{{$value['sbu_name']}}">
                                                <img width="40" height="22" src="{{asset('company_logo/'.$value['sbu_logo'])}}" style="margin-top:-3px;"> {{$value['sbu_name']}}
                                            </h5>
                                        </div>

                                        @php
                                        foreach ($deprtment as $key1 => $value1) {
                                        $dpemply=collect($pabxnumber)->where('employee_sbu',$value['id'])->where('employee_department',$value1['id'])->toArray();
                                        @endphp
                                        <div class="col-md-12 pabxListPrint" style="background:#ddd;">
                                            <h5 style="margin-bottom: 0;line-height: 27px;text-overflow: ellipsis;width: 100%;overflow: hidden;white-space: nowrap;" title="{{$value1['department_name']}}"><strong> {{$value1['department_name']}}</strong></h5>
                                        </div>
                                        @php
                                        foreach ($dpemply as $key2 => $value2) {
                                        @endphp
                                        <div class="col-md-12 pabxListPrint" style="padding:0px;">
                                            <div class="row" style="margin:0px; border-bottom:1px solid #ddd;">
                                                <div class="col-md-10" style="text-overflow: ellipsis;width: 100%;overflow: hidden;white-space: nowrap;" title="{{$value2['employee_fullname']}} [  {{$value2['employee_id_no']}} ]">
                                                    <span>{{$value2['employee_fullname']}} [ {{$value2['employee_id_no']}} ]</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>{{$value2['desk_phone_no']}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                        }

                                        }
                                        @endphp
                                    </div>
                                </div>
                                @php

                                }
                                @endphp

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="emailListModal" tabindex="-1" role="dialog" aria-labelledby="serviceRequestLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 65%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title col-md-10">
                        <i class="fa fa-list"></i>
                        Email List
                    </h5>
                    <button id="clickBtnEmailPrint" type="button" class="btn-success">
                        <i class="fa fa-print"></i> Print
                    </button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin:0px;">
                        <div class="col-md-12">
                            <input class="col-md-3 float-right" type="text" id="myEmailInput" onkeyup="emailSearchFunction()" placeholder="Search for Email ID" title="Search for Email">
                        </div>
                    </div>
                    <div class="col-md-12" id="emailListPrint">
                        <div class="row">
                            <div class="col-md-2" style="text-align: center;">
                                <img width="70" height="46" src="{{asset('admin_assets/images/gemcon-logo.png')}}" style="margin-top:28px;">
                            </div>
                            <div class="col-md-9" style="text-align: center;">
                                <a href="/index" class="fa o_menu_toggle" title="Applications" aria-label="Applications"> </a>
                                <h2> Gemcon Group</h2>
                                <h3>Email List</h3>
                                <br>
                            </div>
                        </div>
                        @php
                        foreach ($sbueNameEmail as $key => $value) {
                        $emply=collect($emailListData)->where('employee_sbu',$value['id'])->toArray();
                        $depertId=collect($emply)->pluck('employee_department')->toArray();
                        $deprtment=collect($depertmentEmail)->whereIn('id',$depertId)->toArray();
                        @endphp
                        <div class="col-md-12 float-left" style="margin-right:10px;">
                            <div class="row emailListPrint" style="border: 1px solid #ddd;">
                                <div class="col-md-12 emailListPrint" style="background: #121213;color: #fff;padding: 2px 4px;">
                                    <h5 style="color: #fff;margin-bottom: 0;line-height: 27px;text-overflow: ellipsis;width: 100%;overflow: hidden;white-space: nowrap;" title="{{$value['sbu_name']}}">
                                        <img width="40" height="22" src="{{asset('company_logo/'.$value['sbu_logo'])}}" style="margin-top:-3px;"> {{$value['sbu_name']}}
                                    </h5>
                                </div>
                                @php
                                foreach ($deprtment as $key1 => $value1) {
                                $dpemply=collect($emailListData)->where('employee_sbu',$value['id'])->where('employee_department',$value1['id'])->toArray();
                                @endphp
                                <div class="col-md-12 emailListPrint" style="background:#ddd;">
                                    <h5 style="margin-bottom: 0;line-height: 27px;text-overflow: ellipsis;width: 100%;overflow: hidden;white-space: nowrap;" title="{{$value1['department_name']}}"><strong> {{$value1['department_name']}}</strong></h5>
                                </div>
                                @php
                                foreach ($dpemply as $key2 => $value2) {
                                @endphp
                                <div class="col-md-12 emailListPrint" style="padding:0px;">
                                    <div class="row" style="margin:0px; border-bottom:1px solid #ddd;">
                                        <div class="col-md-7 float-left" style="text-overflow: ellipsis;width: 100%;overflow: hidden;white-space: nowrap;" title="{{$value2['employee_fullname']}} [  {{$value2['employee_id_no']}} ]">
                                            <span>{{$value2['employee_fullname']}} [ {{$value2['employee_id_no']}} ] - {{$value2['designation_name']}}</span>
                                        </div>
                                        <div class="col-md-5 text-right">
                                            <span>
                                                @php
                                                if(!empty($value2['official_email_id'])){
                                                echo $value2['official_email_id'];
                                                }else {
                                                echo $value2['employee_email'];
                                                }
                                                @endphp
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @php
                                }
                                }
                                @endphp
                            </div>
                        </div>
                        @php
                        }
                        @endphp

                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

 <script type="text/javascript">
    
    function pabx_show() {
            $("#container-fluid").animate({
                height: "auto"
            }, 500);
            setTimeout(function() {
                $('#grid').masonry({
                    itemSelector: '.grid-item'
                });
            }, 500);
    }
    $("#grid_hide_show").click(function() {
        $('#grid_hide_show1').css('display', 'inline');
        $('#grid_hide_show').css('display', 'none');
        $(".grid_view").show();
        $(".list_view").hide();
        var view_type = 2;
        $("#view_type").val(view_type);
    });
    $("#grid_hide_show1").click(function() {
        $('#grid_hide_show1').css('display', 'none');
        $('#grid_hide_show').css('display', 'inline');
        $(".grid_view").hide();
        $(".list_view").show();
        var view_type = 1;
        $("#view_type").val(view_type);
    });
    $("#clickBtnEmailPrint").click(function() {
            var cssss = '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" media="screen, print" />';
            w = window.open(null, 'Print_Page', 'scrollbars=yes');
            w.document.write(cssss);
            w.document.write(cssss + jQuery('#emailListPrint').html());
            w.document.close();
            w.print();
    });
    $("#clickBtnPrint").click(function() {
            var cssss = '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" media="screen, print" />';
            w = window.open(null, 'Print_Page', 'scrollbars=yes');
            w.document.write(cssss);
            w.document.write(cssss + jQuery('#pabxListPrint').html());
            w.document.close();
            w.print();
    });

    function fetch_data(page, sort_type, sort_by, query, view_type) {
            if (query.toString().length >= 5 || query.toString().length == 0) {
                $.ajax({
                    url: "/pagination/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&query=" + query + "&viewType=" + view_type,
                    success: function(data) {
                        // console.log(data);
                        if (view_type == 1) {
                            $('#exampleDataTable123').html('');
                            $('#exampleDataTable123').html(data);
                        } else {
                            $('#exampleDataTable1234').html('');
                            $('#exampleDataTable1234').html(data);
                            $('#grid_hide_show1').css('display', 'inline'); // you could still use `.hide()` here
                            $('#grid_hide_show').css('display', 'none'); // you could still use `.hide()` here
                            $(".grid_view").show();
                            $(".list_view").hide();
                        }
                    }
                })
            }
        }

</script>
