<body class="o_web_client o_home_menu_background">
    <div class="o_notification_manager"></div>
    <header>
        <style type="text/css">
            .tab-content .home-min-height{
                min-height: 600px;
            }
            .spinner {
                height: 60px;
                width: 60px;
                margin: auto;
                display: flex;
                position: absolute;
                -webkit-animation: rotation .8s infinite linear;
                -moz-animation: rotation .8s infinite linear;
                -o-animation: rotation .8s infinite linear;
                animation: rotation .8s infinite linear;
                border-left: 6px solid rgba(255, 129, 0, .25);
                border-right: 6px solid rgba(255, 129, 0, .25);
                border-bottom: 6px solid rgba(255, 129, 0, .25);
                border-top: 6px solid rgba(255, 129, 0, 1);
                /* border-left: 6px solid rgba(0, 174, 239, .15);
  border-right: 6px solid rgba(0, 174, 239, .15);
  border-bottom: 6px solid rgba(0, 174, 239, .15);
  border-top: 6px solid rgba(0, 174, 239, .8); */
                border-radius: 100%;
                top: 35% !important;
            }
            /* .table td, .table th {
                padding: 0px .4rem 0px .4rem;
                vertical-align: top;
                border-top: 1px solid #dee2e6;
            } */

            @-webkit-keyframes rotation {
                from {
                    -webkit-transform: rotate(0deg);
                }

                to {
                    -webkit-transform: rotate(359deg);
                }
            }

            @-moz-keyframes rotation {
                from {
                    -moz-transform: rotate(0deg);
                }

                to {
                    -moz-transform: rotate(359deg);
                }
            }

            @-o-keyframes rotation {
                from {
                    -o-transform: rotate(0deg);
                }

                to {
                    -o-transform: rotate(359deg);
                }
            }

            @keyframes rotation {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(359deg);
                }
            }

            #overlay {
                position: absolute;
                display: none;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 9;
                cursor: pointer;
                height: auto;
                width: 100% !important;
                height: 100% !important;
            }



            .o_home_menu .o_home_menu_scrollable {
                max-width: 100%;
            }

            .o_home_menu {
                height: auto;
            }

            .o_home_menu_background:not(.o_home_menu_background_custom) .o_main_navbar {
                background-color: #f1f1f1;
                border-color: #bbbbbb;
            }

            .profile-img img {
                max-width: 120px;
                max-height: 150px;
            }

            .profile-img img {
                display: inline-block;
                width: 100%;
                height: auto;
                background-repeat: no-repeat;
                background-position: center center;
                background-size: cover;
                border: 1px solid #ddd;
                box-shadow: 0px 0px 5px 0px #919190;
            }

            .o_main_navbar>ul>li>a,
            .o_main_navbar>ul>li>label {
                color: #0a0a0a;
            }

            ul.menu li {
                display: inline;
                padding-left: 0px;
            }

            .employee-info p {
                margin-bottom: 0px;
            }

            .nav.nav-tabs {
                padding-left: 0px;
            }

            .nav-pills .nav-link {
                border: 1px solid #efefef;
                margin-bottom: 5px;
                color: #5f5e5e;
                box-shadow: 0px 0px 2px 1px #e9ecef;
                border-top-color: #e9ecef;
                padding: 11px;
            }

            .pagination {
                margin-bottom: 0px;
            }

            .input-group-addon {
                border-top: 1px solid #ffa63d;
                padding: 6px;
                border-bottom: 1px solid #ffa63d;
                border-left: 1px solid #ffa63d;
                color: #ffffff;
                background: #ffa63d;
            }

            .nav-pills .nav-link.active,
            .nav-pills .show>.nav-link {
                color: #212529;
                background-color: whitesmoke;
                box-shadow: 0px 0px 2px 1px #ddd;
                box-shadow: 0px 0px 2px 1px #e9ecef;
                border-top-color: #e9ecef;
                border-bottom: 3px solid #ffa63d;
                margin-bottom: -3px;
                padding: 11px;
            }

            .nav-pills .nav-link:focus,
            .nav-link:hover {
                color: #212529;
                background-color: whitesmoke;
                box-shadow: 0px 0px 2px 1px #ddd;
                transition: width 5s;
            }

            canvas {
                -moz-user-select: none;
                -webkit-user-select: none;
                -ms-user-select: none;
            }

            .o_home_menu {
                font-size: 14px;
            }

            @media (min-width: 768px) {
                .employee-profile .col-md-2 {
                    margin-left: 3px;
                }
            }

            .mega-dropdown {
                position: static !important;
            }

            .mega-dropdown-menu {
                padding: 20px 0px;
                width: 100%;
                box-shadow: none;
                -webkit-box-shadow: none;
            }

            .mega-dropdown-menu>li>ul {
                padding: 0;
                margin: 0;
            }

            .mega-dropdown-menu>li>ul>li {
                list-style: none;
            }

            .mega-dropdown-menu>li>ul>li>a {
                display: block;
                color: #222;
                padding: 3px 5px;
            }

            .mega-dropdown-menu>li ul>li>a:hover,
            .mega-dropdown-menu>li ul>li>a:focus {
                text-decoration: none;
            }

            .mega-dropdown-menu .dropdown-header {
                font-size: 18px;
                color: #ff3546;
                padding: 5px 60px 5px 5px;
                line-height: 30px;
            }

            .employee-info-table .table td,
            .table th {
                border: none !important;
                padding-bottom: 3px !important;
            }

            .paginate-pagination ul>li>a.page.active {
                opacity: 1;
                font-weight: bold;
                border-bottom: 2px solid #007bff;
            }

            .profile_file_img label {
                display: inline-block;
                padding: 0.5rem;
                font-family: sans-serif;
                border-radius: 0.3rem;
                cursor: pointer;
                margin-top: 1rem;
                position: absolute;
                text-align: center;
                top: 96px;
                left: 41px;
            }

            .fa-camera {
                font-size: 18px;
                border: 1px solid #888484;
                border-radius: 50px;
                padding: 5px;
                background: #fff;
            }

            .page-item.active .page-link {
                z-index: 3;
                color: #fff;
                background-color: #ffa63d;
                border-color: #ffa63d;
            }

            .page-link {
                position: relative;
                display: block;
                padding: .5rem .75rem;
                margin-left: -1px;
                line-height: 1.25;
                color: #0e0e0e;
                background-color: #fff;
                border: 1px solid #dee2e6;
            }

            .top-menu-list {
                position: absolute;
                left: 20%;
                top: 0;
                margin: 0px;
                padding: 0px;
            }

            .top-menu-list li {
                list-style: none;
                display: inline-block;
                margin-right: 10px;
            }

            .top-menu-list li a {
                color: #fff;
                line-height: 58px;
                padding: 16px 16px;
                position: relative;
            }

            .top-menu-list li a i {
                font-size: 28px;
            }

            .tooltiptext {
                visibility: hidden;
                width: 120px;
                background-color: black;
                color: #fff;
                text-align: center;
                border-radius: 6px;
                padding: 5px 0;
                /* Position the tooltip */
                position: absolute;
                z-index: 1;
                left: 0;
                top: 90%;
                line-height: 20px;
            }

            .top-menu-list li a:hover .tooltiptext {
                visibility: visible;
            }

            .daterangepicker {
                margin-top: 0px;
            }

            .daterange-input input {
                border: 1px solid #ddd;
                margin-bottom: 7px;
                text-align: center;
            }

            .nav-tabs .nav-item.show .nav-link,
            .nav-tabs .nav-link.active {
                /*background: #fec23c;*/
                box-shadow: 0px 0px 2px 1px #e9ecef;
                border-top-color: #e9ecef;
                border-bottom: 3px solid #ffa63d;
                margin-bottom: -3px;
                padding: 11px;
                font-size: 15px;
            }

            .nav-tabs .nav-link {
                padding: 11px;
                font-size: 15px;
            }

            .info-box .info-box-icon {
                width: 40px;
                height: 48px;
                margin-top: 0px;
            }

            .info-box .info-box-text,
            .info-box .progress-description {
                font-size: 16px;
            }

            .info-box .info-box-number {
                font-size: 24px;
                margin-top: 10px;
            }

            .info-box {
                padding: 15px 15px;
            }

            .nav-link {
                padding: 4px 30px;
            }

            .employee-profile {
                width: 90%;
            }

            .general-info .table td,
            .table th {
                padding: 2px;
                vertical-align: top;
                border-top: 0px solid #dee2e6;
            }

            @media (min-width: 768px) {
                .col-md-2 {
                    max-width: 12.5%;
                    padding-top: 0px;
                }
            }

            .dropdown-item.active,
            .dropdown-item:active {
                color: #292a2b;
                text-decoration: none;
                background-color: #f5f5f5;
            }

            .leave-table.table-bordered td {
                padding-top: 7px;
                padding-bottom: 7px;
                text-align: center;
            }

            .notice-table.table-bordered td {
                padding-top: 0px;
                padding-bottom: 0px;
                text-align: center;
            }

            .paginate-pagination {
                position: relative;
                left: 1%;
                width: 307% !important;
            }

            .select2-container {
                width: 100% !important;
            }

            .required_sign {
                color: red;
            }

            .dataTables_length label {
                display: inline-flex !important;
            }

            .grid_view_list {
                text-overflow: ellipsis;
                width: 150px;
                overflow: hidden;
                white-space: nowrap;
            }

            .gj-timepicker-bootstrap [role=right-icon] button .gj-icon,
            .gj-timepicker-bootstrap [role=right-icon] button .material-icons {
                top: 4px !important;
            }

            input[type="text"],
            input[type="password"],
            textarea,
            select {
                outline: none !important;
                border: 1px solid#aaa !important;
            }

            @media (min-width: 768px) {
                .tab-content .col-md-2 {
                    margin-left: 0px !important;
                    max-width: 16.666667% !important;
                }

                .qr_code_data_5_top {
                    margin-top: 15px !important;
                }
            }

            .paginate-pagination ul {
                margin: 20px 0px 0px 0px;
                padding: 0;
                list-style: none;
            }

            .modal-header {
                background: #fec23c;
                color: #fff !important;
            }

            @media only screen and (max-width: 450px) {
                .employee-info.text-left {
                    padding: 0px !important;
                }

                .qr_code_data_5 {
                    font-size: 14px;
                    margin-top: 0px !important;
                }

                #myTabContent.tab-pane.fade {
                    padding: 20px !important;
                }

                .employee-profile .col-md-12 {
                    padding: 10px;
                }

                .info-box {
                    padding: 15px 8px;
                }

                .nav.nav-tabs {
                    padding-left: 25px;
                }

                .dropdown-menu.show {
                    position: relative;
                }
            }

            #calendar {
                max-width: 1100px;
                margin: 0 auto;
            }

            .fc,
            .fc *,
            .fc :after,
            .fc :before {
                line-height: 15px;
            }

            .dataTables_wrapper .dataTables_filter input {
                outline: none;
                background: transparent;
                border: 1px solid #dddddd;
            }

            .dataTables_wrapper {
                width: 100%;
            }

            .carousel-control-next,
            .carousel-control-prev {
                opacity: 1 !important;
            }

            .view_wish button {
                outline: 0px !important;
            }

            .show:hover ul.list-categories {
                max-height: inherit;
                opacity: 1;
                position: absolute;
                background: #fff2dc;
                padding-left: 15px;
                padding-right: 15px;
                left: 9px;
                margin-top: 20px;
                border: 1px solid #ddd;
                padding-bottom: 5px;
                padding-top: 5px;
            }

            .list-categories {
                list-style-type: none;
                padding: 0px;
                margin: 0px;
                max-height: 0px;
                opacity: 0;
                overflow: hidden;
                transition: opacity 300ms ease;
                z-index: 1;
                display: inherit;
            }

            .show:hover ul.birthday_like_list {
                max-height: inherit;
                opacity: 1;
                position: absolute;
                background: #fff2dc;
                padding-left: 15px;
                padding-right: 15px;
                left: 9px;
                margin-top: 0px;
                border: 1px solid #ddd;
                padding-bottom: 5px;
                padding-top: 5px;
            }

            .show:hover ul.birthday_wish_list {
                max-height: inherit;
                opacity: 1;
                position: absolute;
                background: #fff2dc;
                padding-left: 15px;
                padding-right: 15px;
                /*left: 9px;*/
                margin-top: 0px;
                border: 1px solid #ddd;
                padding-bottom: 5px;
                padding-top: 5px;
            }

            .birthday_wish_list {
                list-style-type: none;
                padding: 0px;
                margin: 0px;
                max-height: 0px;
                opacity: 0;
                overflow: hidden;
                transition: opacity 300ms ease;
                z-index: 1;
                display: inherit;
            }

            .datepicker-orient-top,
            .datepicker-orient-bottom {
                padding: 20px !important;
                ;
            }
            .image-download{
                position: absolute;
                margin-left: -73px;
                margin-top: 99px;
                border-radius: 25px;
                background: whitesmoke;
                opacity: 0%;
            }
            .image-download:hover{
                opacity: 1 !important;
            }
        </style>
        <!-- <button type="button" class="btn btn-primary" onclick="on()">Turn on overlay effect</button> -->


        <!-- <button type="button" class="btn btn-primary" onclick="on()">Turn on overlay effect</button> -->

        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
        <!-- Bar Chart  -->
        <script src="http://www.chartjs.org/dist/2.7.3/Chart.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

        <link href="http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.css" rel="stylesheet" />
        <script src="http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.min.js"></script>

        <div class="modal fade" id="modal_form_holiday_calendar" tabindex="-1" role="dialog" aria-labelledby="applyLeaveLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="min-width: 55%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-bars"></i> Holiday Calendar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="false">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div id="holiday_calendar"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 2px;background: #e9e9e9;    padding: 5px;margin-right: 3px;    color: #000;border: 1px solid #aaa;    padding-right: 10px;    padding-left: 10px;">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_form_addappt" tabindex="-1" role="dialog" aria-labelledby="applyLeaveLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="min-width: 55%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-bars"></i> Service Calendar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="false">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div id="calendar"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 2px;background: #e9e9e9;    padding: 5px;margin-right: 3px;    color: #000;border: 1px solid #aaa;    padding-right: 10px;    padding-left: 10px;">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="eventModal" class="modal fade eventModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create new event</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="false">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="title">Event title</label>
                            <input type="text" name="title" id="title" />
                        </div>
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="starts-at">Starts at</label>
                            <input type="text" name="starts_at" id="starts-at" />
                        </div>
                        <div class="col-xs-12">
                            <label class="col-xs-4" for="ends-at">Ends at</label>
                            <input type="text" name="ends_at" id="ends-at" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 2px;background: #e9e9e9;    padding: 5px;margin-right: 3px;    color: #000;border: 1px solid #aaa;    padding-right: 10px;    padding-left: 10px;">Cancel</button>
                        <button type="submit" class="btn btn-info">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function onLodingOverlay() {
                document.getElementById("overlay").style.display = "flex";
            }

            function off() {
                document.getElementById("overlay").style.display = "none";
            }


            $("#calendar").fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: function(start, end, callback) {

                    var employee_id = "<?php echo Auth::guard('user')->user()->employee_id; ?>";

                    $.ajax({
                        type: 'GET',
                        url: "{{ url('/') }}/get_service_list_info/" + employee_id,
                        dataType: 'json',
                        success: function(data) {

                            var events = [];
                            for (var i = 0; i < data.serviceList.length; i++) {
                                events.push({
                                    id: data.serviceList[i].id,
                                    title: data.serviceList[i].Type,
                                    start: data.serviceList[i].date,
                                    end: data.serviceList[i].date,
                                });
                            }
                            // console.log("Ajax call success");
                            console.dir(events);
                            callback(events);
                        },
                        error: function(data) {
                            // console.log(data);
                            alert("Ajax call error");
                        }
                    });
                },

                initialDate: '2020-09-12',
                navLinks: true, // can click day/week names to navigate views
                selectable: true,
                selectHelper: true,
                select: function(arg) {
                    // $('#eventModal').modal('toggle');
                    $('#serviceRequest').modal('show');
                    $('.backToServiceListdiv').css('display', 'none');
                    $('.backToServiceCalendar').css('display', 'inline');
                    $('#serviceList').modal('hide');
                    $('#modal_form_addappt').modal('hide');
                },
                eventClick: function(arg) {
                    console.log(arg);
                    // alert(arg);
                    // if (confirm('Are you sure you want to delete this event?')) {
                    //     arg.event.remove()
                    // }
                },

            });

            $("#holiday_calendar").fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: function(start, end, callback) {
                    var employee_id = "<?php echo Auth::guard('user')->user()->employee_id; ?>";
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('/') }}/get_holiday_list_info/" + employee_id,
                        dataType: 'json',
                        success: function(data) {
                            var events = [];
                            for (var i = 0; i < data.serviceList.length; i++) {
                                events.push({
                                    id: data.serviceList[i].id,
                                    title: data.serviceList[i].Type,
                                    start: data.serviceList[i].s_date,
                                    end: data.serviceList[i].e_date,
                                });
                            }
                            console.dir(events);
                            callback(events);
                        },
                        error: function(data) {
                            alert("Ajax call error");
                        }
                    });
                },
                initialDate: '2020-09-12',
                navLinks: true,
                selectable: true,
                selectHelper: true,
                select: function(arg) {
                    // $('#serviceRequest').modal('show');
                    // $('.backToServiceListdiv').css('display', 'none');
                    // $('.backToServiceCalendar').css('display', 'inline');
                    // $('#serviceList').modal('hide');
                    // $('#modal_form_addappt').modal('hide');
                },
                eventClick: function(arg) {
                    console.log(arg);
                },
            });

            $('#modal_form_addappt').on('shown.bs.modal', function() {
                $("#calendar").fullCalendar('render');
            });
            $('#modal_form_holiday_calendar').on('shown.bs.modal', function() {
                $("#holiday_calendar").fullCalendar('render');
            });
        </script>
        <nav class="o_main_navbar" style="background: {{ $employee_data['modal_header_color'] }}">
            <a href="/index" class="fa o_menu_toggle" title="Applications" aria-label="Applications">
                @php
                if(!empty($employee_data['sbu_logo'])){
                @endphp
                <img height="46" src="{{asset('company_logo/'.$employee_data['sbu_logo'])}}" style="margin-top:-3px;">
                @php
                }else{
                @endphp
                <img width="70" height="46" src="{{asset('admin_assets/images/gemcon-logo.png')}}" style="margin-top:-3px;">
                @php
                }
                @endphp
            </a>
            <ul class="o_menu_systray" role="menu">
                <li class="dropdown">
                    <a id="service_list_modal_open" href="#" class="nav-link service_list_modal_open" data-backdrop="static" data-keyboard="false"><i class="fa fa-question-circle"></i> SERVICE REQUEST</a>
                </li>
                <li class="dropdown mega-dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#"><i class="fa fa-th-large"></i> ALL MODULE</a>
                    <ul class="dropdown-menu mega-dropdown-menu o_home_menu">
                        <div class="o_home_menu_scrollable">

                            <div class="o_apps">
                                <?php if($user->user_type != 8){ ?>
                                <a class="o_app o_menuitem" target="_blank" href="#">
                                    <div class="o_app_icon" style="background-image: url('images/module-images/recruitment1.png');"></div>
                                    <div class="o_caption">Recruitment</div>
                                </a>
                                <a class="o_app o_menuitem" target="_blank" href="{{url('/dashboards')}}">
                                    <div class="o_app_icon" style="background-image: url('images/module-images/employee_list.png');"></div>
                                    <div class="o_caption">HRM - Employees</div>
                                </a>
                                <a class="o_app o_menuitem" target="_blank" href="{{url('/dashboards_payroll')}}">
                                    <div class="o_app_icon" style="background-image: url('images/module-images/payroll.png');"></div>
                                    <div class="o_caption">Payroll</div>
                                </a>
                                <a class="o_app o_menuitem" target="_blank" href="{{url('/settings')}}">
                                    <div class="o_app_icon" style="background-image: url('images/module-images/settings.png');"></div>
                                    <div class="o_caption">Settings</div>
                                </a>
                                <a class="o_app o_menuitem" target="_blank" href="{{url('/dashboard_appraisal')}}">
                                    <div class="o_app_icon" style="background-image: url('images/module-images/module.png');"></div>
                                    <div class="o_caption">KPI</div>
                                </a>
                                <a class="o_app o_menuitem" href="#">
                                    <div class="o_app_icon" style="background-image: url('images/module-images/employee_list.png');"></div>
                                    <div class="o_caption">Another Module</div>
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" style="text-decoration: none;color:#000;">
                        <?php
                        $employee_image = isset($employee_data['employee_image']) ? $employee_data['employee_image'] : '';
                        ?>
                        <?php if (!empty($employee_image) && file_exists(public_path('images/' . $employee_image))) : ?>
                            <img src="{{asset('images/'.$employee_image )}}" width="25" height="25" class="rounded-circle">
                        <?php else : ?>
                            <img src="{{asset('images/default.png')}}" width="25" height="25" class="rounded-circle">
                        <?php endif ?>
                        {{$user->name}} <i class="fa fa-caret-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-setting" role="menu">
                        <a href="#" role="menuitem" data-menu="settings" class="dropdown-item" data-toggle="modal" data-target="#changePasswordModal" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">
                            <i class="fa fa-key"></i> Change Password
                        </a>
                        <div role="separator" class="dropdown-divider"></div>
                        <a href="{{ route('user.logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" class="dropdown-item fa fa-sign-out"> <i class="fa fa-sign-out-alt mr-2"></i> Log Out</a>
                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
    <!-- All Module Link -->
    <div class="o_home_menu">
        <div class="o_home_menu_scrollable">
            @if (session('error'))
            <div class="alert alert-danger anyMessage">
                {{ session('error') }}
            </div>
            @endif
            @if (session('success'))
            <div class="alert alert-success anyMessage">
                {{ session('success') }}
            </div>
            @endif

            <!-- Employee Profile Start  -->
            <div class="row clearfix employee-profile">
                <div class="col-md-12" style="margin-top:15px;">
                    <div class="col-md-2 col-6 profile-img float-left">
                        <?php if (!empty($employee_image) && file_exists(public_path('images/' . $employee_image))) : ?>
                            <img class="float-left img-responsive profile_img_upload" src="{{asset('images/'.$employee_image )}}" style="height: 130px; width: 107px;">
                        <?php else : ?>
                            <img class="float-left img-responsive profile_img_upload" src="{{asset('images/default.png')}}" style="height: 130px; width: 107px;">
                            <!-- axcsdfdg -->
                        <?php endif ?>
                        <div class="profile_file_img" style="display: none;">
                            <label class="" for="upload">
                                <i class="fa fa-camera" data-toggle="modal" data-target="#profileImageUpload" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false"></i>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 float-left employee-info text-left" style="padding-right: 15px; min-width: 20%">
                        <?php
                        $section_name = '';
                        if (!empty($employee_data['section_name'])) {
                            $section_name = ', ' . $employee_data['section_name'];
                        }
                        ?>
                        <h1 class="qr_code_data_1" style="font-size:20px; font-weight: bold;"><span class="" name="name" placeholder="Employee's Name">{{isset($employee_data['employee_fullname'])?$employee_data['employee_fullname']:$user->name}}</span></h1>
                        <p class="qr_code_data_2">{{isset($employee_data['designation_name'])?$employee_data['designation_name']:'Not Found!'}}{{$section_name}}</p>
                        <p class="qr_code_data_3">{{isset($employee_data['department_name'])?$employee_data['department_name']:'Not Found!'}}</p>
                        <p class="qr_code_data_4">{{isset($employee_data['sbu_name'])?$employee_data['sbu_name']:'Not Found!'}}</p>
                        <h3 class="qr_code_data_5_top">
                            <strong><i class="fa fa-id-badge" style="color:orange;"></i>
                                <span class="qr_code_data_5">{{isset($employee_data['employee_id_no'])?$employee_data['employee_id_no']:'Not Found!'}}</span></strong>
                        </h3>
                    </div>
                    <div class="col-md-3 col-12 float-left" style="min-width: 25% ;">
                        <p style="margin-bottom: .5rem;">
                            <?php
                            $official_mobile = isset($employee_data['official_mobile_no']) ? $employee_data['official_mobile_no'] : '';
                            if (!empty($official_mobile)) {
                                $mobile_no = $official_mobile;
                            } else {
                                $mobile_no = isset($employee_data['employee_mobile']) ? $employee_data['employee_mobile'] : 'Not Found!';
                            }
                            ?>
                            <i class="fa fa-phone-square" style="color:orange;"></i>
                            <span class="qr_code_data_6">{{$mobile_no}}</span>
                        </p>
                        <p style="margin-bottom: .5rem;">
                            <?php
                            $official_email = isset($employee_data['official_email_id']) ? $employee_data['official_email_id'] : '';
                            if (!empty($official_email)) {
                                $email_id = $official_email;
                            } else {
                                $email_id = isset($employee_data['employee_email']) ? $employee_data['employee_email'] : 'Not Found!';
                            }
                            ?>
                            <i class="fa fa-envelope" style="color:orange;"></i>
                            <span class="qr_code_data_7">{{$email_id}}</span>
                        </p>
                        <p style="margin-bottom: .5rem;">
                            <span class="qr_code_data_8">
                                <i class="fa fa-address-card" style="color:orange;"></i>
                                <?php if (!empty($address_details['present_holding_no'])) : ?>
                                    <?php if (!empty($address_details['present_holding_no'])) : ?>
                                        <?php echo $address_details['present_holding_no']; ?>
                                    <?php endif ?>
                                    <?php
                                    if (!empty($address_details['name'])) : ?>, <?php echo $address_details['name']; ?>
                                <?php endif ?>
                            <?php else : ?>
                                <?php echo "Not Found!"; ?>
                            <?php endif ?>
                            </span>
                        </p>
                        <p style="padding-right: 30px; font-size: 13px;margin-bottom: .5rem;">
                            <i class="fa fa-tint" style="color:orange;font-size: 18px"></i>
                            Blood Group: <span class="qr_code_data_9" style="background-color: #e04d4d; border-radius:4px; padding:0px 5px; color:#fff">{{isset($employee_data['employee_blood_group'])?$employee_data['employee_blood_group']:'Not Found!'}}</span>
                        </p>

                        <p style="padding-right: 30px; font-size: 13px;margin-bottom: .5rem;">
                            <i class="fa fa-suitcase" style="color:orange;"></i>
                            Service Length: <span><strong>
                                    <?php
                                    $date1 = $employee_data['employee_joining_date'];
                                    $date2 = date('Y-m-d');
                                    if (!empty($date1)) {
                                        // $diff = abs(strtotime($date2) - strtotime($date1));
                                        // $yearss = floor($diff / (365 * 60 * 60 * 24));
                                        // $monthss = floor(($diff - $yearss * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                        // $dayss = floor(($diff - $yearss * 365 * 60 * 60 * 24 - $monthss * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                        // printf("%dY-%dM-%dD\n", $yearss, $monthss, $dayss);

                                        $Joining = new DateTime($date1); // Your date of birth
                                        $today = new Datetime(date('Y-m-d'));
                                        $diff = $today->diff($Joining);
                                        echo $JoiningDates = $diff->y . '.' . $diff->m. 'Y';
                                    } else {
                                        echo "Not Found!";
                                    }
                                    ?>
                                </strong>
                            </span>
                        </p>



                    </div>
                    <div class="col-md-2 col-3 float-left  d-none d-sm-block text-center" style="margin:auto;">
                        <div class="div_qr_print" style="margin-bottom: 5px;margin-right: 19% !important;"></div>

                        <script type="text/javascript">
                            var employee_data = $(".qr_code_data_1").text() + ', ' + $(".qr_code_data_2").text() + ', ' + $(".qr_code_data_3").text() + ', ' + $(".qr_code_data_4").text() + ', ' + $(".qr_code_data_6").text() + ', ' + $(".qr_code_data_9").text() + ', ' + $(".qr_code_data_7").text();
                            // alert(employee_data);
                            $('.div_qr_print').data("qr", {
                                    "render": "image",
                                    // "margin":'auto',
                                    "height": 30,
                                    "width": 30,
                                    "margin-left": 19,
                                    "margin-right": 19,

                                    "text": employee_data
                                })
                                .qrcode($('.div_qr_print').data("qr"));
                        </script>
                    </div>
                    <div class="col-md-2 col-12 float-right" style="min-width: 25% ">
                        <table class="table table-striped table-bordered notice-table" cellspacing="0" width="100%" style="font-size:12px;height: 72px;margin-bottom:0px">
                            <thead>
                                <tr style="background:#fff2dc">
                                    <th colspan="6" style="padding-left:5px;">
                                        <i style="color: orange;" class="fa fa-bullhorn"></i>
                                        Announcement
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="text-align: left; background:#fff !important;">
                                    <td colspan="5" style="padding-left:0px;padding-right:0px; height: 39px">
                                        <div id="carouselNotice" class="carousel slide vertical" data-ride="carousel" style="width: 100%;">
                                            <div class="carousel-inner">
                                                <?php
                                                $i = 0;
                                                if (!empty($notices) && count($notices) > 0) {
                                                    foreach ($notices as $key => $value) :
                                                        $i++;
                                                ?>
                                                        <div data-noticeid="<?php echo $value['id']; ?>" data-value="<?php echo $i; ?>" data-slide-to="0" class="carousel-item <?php if ($i == 1) {
                                                                                                                                                                                    echo 'active';
                                                                                                                                                                                } ?>" style="background:#fff !important;">
                                                            <table cellspacing="0" width="100%">
                                                                <tr style="background:#fff !important;">
                                                                    <td colspan="5" style="text-align: left; border: none;">{{$value['notice_title'] }}</td>
                                                                    <td style="border: none; text-align:right;">
                                                                        <a href="#" style="color: orange" data-toggle="modal" data-target="#NoticeList" id="viewNoticeDetails" data-notice_title="<?php echo $value['notice_title']; ?>" data-notice_details="{{ $value['notice_details']}}">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                <?php
                                                    endforeach;
                                                } else {
                                                    echo "No Data Available!";
                                                }
                                                ?>
                                            </div>
                                            <?php if (!empty($notice_vewing_info) && count($notice_vewing_info) > 0) : ?>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-9" style="padding-top: 7px; padding-right: 0px; text-align: right;">
                                                            <a class=" " style="color:#0447ab;">
                                                                Announcement&nbsp;
                                                                <span class="announcement_sl">
                                                                    <?php echo $i; ?></span>/<?php echo count($notices); ?>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-3" style="padding-top: 30px;">
                                                            <a class="col-md-6 float-left carousel-control-next " href="#carouselNotice" role="button" data-slide="next" style="color:#0447ab;">
                                                                <span style="padding-right: 5px;color:#0447ab;margin-left: -10px;"> Next</span> <i class="fa fa-angle-right" style="color:#0447ab;"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php if (!empty($notice_vewing_info) && count($notice_vewing_info) > 0) : ?>
                                    <tr style="background:#fff2dc" class="view_wish">
                                        <th colspan="3" class="text-left" style="padding-left: 6px; font-weight: normal;">
                                            <button class="show" id="announcement_view_clicked" data-value="<?php echo $i; ?>" data-slide-to="0" style="border: none; background: transparent;padding: 0px; width: 15%;height: 0px;text-align: left;">
                                                <input id="announcement_view_value" class="announcement_view_value" type="hidden" name="notice_id" value="<?php echo isset($value['id']) ? $value['id'] : 0; ?>">
                                                <?php if (!empty($notice_vewing_info) && count($notice_vewing_info) > 0) : ?>
                                                    <i style="color: orange;" class="fa fa-check check_view_class"></i>
                                                    <i style="color: orange; display:none;" class="fa fa-eye eye_view_class"></i>
                                                <?php else : ?>
                                                    <i style="color: orange; display:none;" class="fa fa-check check_view_class"></i>
                                                    <i style="color: orange;" class="fa fa-eye eye_view_class"></i>
                                                <?php endif ?>
                                                <span style="color:#0447ab;" id="notice_viewer_count">
                                                    <?php echo count($notice_viewers); ?>
                                                </span>
                                                <ul class="list-categories listcategories ">
                                                    <?php foreach ($notice_viewers as $key => $viewers) : ?>
                                                        <li style="padding-bottom: 3px;" class="text-left"><?php echo $viewers->employee_fullname . ' [' . $viewers->employee_id_no . ']'; ?></li>
                                                    <?php endforeach ?>
                                                </ul>
                                            </button>
                                        </th>
                                        <th colspan="3" class="text-right" style="padding-right:15px;">
                                            <?php
                                            if (count($notices) > 0) { ?>
                                                <a href="#" data-toggle="modal" data-target="#NoticeList" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" style="color:#212529">
                                                    <strong>....</strong>
                                                </a>
                                            <?php } ?>
                                        </th>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <table class="table table-striped table-bordered notice-table" cellspacing="0" width="100%" style="font-size:12px;height: 53px;margin-top: 10px;margin-bottom:0px">
                            <thead>
                                <tr style="background: #fff2dc;">
                                    <th colspan="5" style="padding-left:5px;">
                                        <i style="color: orange;" class="fa fa-birthday-cake"></i>
                                        Today's Birthday
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="text-align: left;">
                                    <td colspan="4" style="padding-left:0px;padding-right:0px;">
                                        <div id="carouselsBirthday" class="carousel slide vertical" data-ride="carousel" style="width: 100%;">
                                            <div class="carousel-inner" style="background: #fff !important;">
                                                <?php
                                                $i = 0;
                                                if (!empty($today_birthday_info) && count($today_birthday_info) > 0) {
                                                    foreach ($today_birthday_info as $key => $value) :
                                                        $i++;
                                                ?>
                                                        <div data-employeeid="<?php echo $value['id']; ?>" style="background: #fff !important;" data-target="#carouselsBirthday" data-value="<?php echo $i; ?>" data-slide-to="0" class="carousel-item <?php if ($i == 1) {
                                                                                                                                                                                                                                                            echo 'active';
                                                                                                                                                                                                                                                        } ?>" style="padding:0px;">
                                                            <div class="col-md-6 float-left text-left" style="margin-left: 0px; padding:0px;background: #fff !important; padding-left: 2px;">
                                                                <i class="fa fa-user"></i>
                                                                <?php echo $value['employee_fullname']; ?>
                                                            </div>
                                                            <div class="col-md-3 float-left text-left" style="margin-left: 0px; padding:0px;background: #fff !important; text-overflow: ellipsis; width: 118px; overflow: hidden; white-space: nowrap;">
                                                                <?php echo $value['designation_name']; ?>
                                                            </div>
                                                            <div class="col-md-3 float-left text-left" style="margin-left: 0px; padding:0px; text-overflow: ellipsis; width: 118px; overflow: hidden; white-space: nowrap;">
                                                                <?php if (!empty($value['sbu_name'])) {
                                                                    echo $value['sbu_name'];
                                                                } elseif ($value['unit_name']) {
                                                                    echo $value['unit_name'];
                                                                } else {
                                                                    echo '';
                                                                }
                                                                ?>
                                                                <?php echo $value['sbu_name']; ?>
                                                            </div>
                                                        </div>
                                                <?php
                                                    endforeach;
                                                } else {
                                                    echo "No Data Available!";
                                                }
                                                ?>
                                            </div>
                                            <?php if (!empty($birthday_wishing_info['birthday_wishing_no']) && count($birthday_wishing_info['birthday_wishing_no']) > 0) { ?>
                                                <div class="col-md-12" style="background: #fff !important;">
                                                    <div class="row">
                                                        <div class="col-md-9" style="padding-top: 7px; padding-right: 0px; text-align: right;">
                                                            <a class=" " style="color:#0447ab;">
                                                                Birthday
                                                                <span class="birthday_list_sl"><?php echo $i; ?></span>/<?php echo count($today_birthday_info); ?>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-3" style="padding-top: 30px;">
                                                            <a class="col-md-6 float-left carousel-control-next " href="#carouselsBirthday" role="button" data-slide="next" style="color:#0447ab;">
                                                                <span style="padding-right: 5px;color:#0447ab;margin-left: -10px;"> Next</span> <i class="fa fa-angle-right" style="color:#0447ab;"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-md-12" style="background: #fff !important;">
                                                    <div class="row">
                                                        <div class="col-md-9" style="padding-top: 7px; padding-right: 0px; text-align: right;">

                                                        </div>
                                                        <div class="col-md-3" style="padding-top: 30px;">
                                                            <a class="col-md-6 float-left carousel-control-next " href="#carouselsBirthday" role="button" data-slide="next" style="color:#0447ab;">
                                                                <span style="padding-right: 5px;color:#0447ab;margin-left: -10px;"> </span>
                                                                <!-- <i class="fa fa-angle-right" style="color:#0447ab;"></i> -->
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>


                                <?php if (!empty($today_birthday_info) && count($today_birthday_info) > 0) { ?>
                                    <tr style="background: #fff2dc;" class="view_wish">
                                        <th colspan="3" class="text-left" style="padding-left: 6px; font-weight: normal;">
                                            <button class="show float-left" id="birthday_like_id" style="border: none; background: transparent;padding: 0px; width: 30% !important;text-align: left;">
                                                <input class="birthday_employee_id" type="hidden" value="<?php echo isset($value['id']) ? $value['id'] : 0; ?>">
                                                <input id="birthdaylike_id" type="hidden" name="notice_id" value="1">
                                                <?php if (!empty($birthday_liking_info['birthday_liking_no']) && count($birthday_liking_info['birthday_liking_no']) > 0) : ?>
                                                    <i style="color: orange; font-weight: bold; display: none;" class="fa fa-thumbs-o-up thums_o_up_class"></i>
                                                    <i style="color: orange; display: inline;" class="fa fa-thumbs-up thums_up_class"></i>
                                                <?php else : ?>
                                                    <i style="color: orange; font-weight: bold; display: inline;" class="fa fa-thumbs-o-up thums_o_up_class"></i>
                                                    <i style="color: orange; display: none;" class="fa fa-thumbs-up thums_up_class"></i>
                                                <?php endif ?>
                                                Like
                                                <span id="birthday_likers_count" style="color:#0447ab;">
                                                    <?php
                                                    if (!empty($birthday_likers['birthday_likers'])) {
                                                        echo count($birthday_likers['birthday_likers']);
                                                    }
                                                    ?>
                                                </span>
                                                <ul class="birthday_wish_list birthday_like_list birthdayLikerList">
                                                    <?php
                                                    if (!empty($birthday_likers['birthday_likers']) && count($birthday_likers['birthday_likers']) > 0) {
                                                        foreach ($birthday_likers['birthday_likers'] as $key => $likers) :
                                                    ?>
                                                            <li style="padding-bottom: 3px;" class="text-left"><?php echo $likers->employee_fullname . ' [' . $likers->employee_id_no . ']'; ?></li>
                                                    <?php
                                                        endforeach;
                                                    }
                                                    ?>
                                                </ul>
                                            </button>
                                            <button class="show float-left" id="birthday_wish_id" style="border: none; background: transparent;padding: 0px; width: 50% !important; text-align: left;">
                                                <input id="birthdaywish_id" type="hidden" value="2">
                                                <?php if (!empty($birthday_wishing_info['birthday_wishing_no']) && count($birthday_wishing_info['birthday_wishing_no']) > 0) : ?>
                                                    <i style="color: orange; font-weight: bold; display:inline;" class="fa fa-heart-o fa_heart_o_wish"></i>
                                                    <i style="color: orange; font-weight: bold; display:none;" class="fa fa-heart fa_heart_wish"></i>

                                                <?php else : ?>
                                                    <i style="color: orange; font-weight: bold; display:none;" class="fa fa-heart-o fa_heart_o_wish"></i>
                                                    <i style="color: orange; font-weight: bold; display:inline;" class="fa fa-heart fa_heart_wish"></i>
                                                <?php endif ?>
                                                Wish <span id="birthday_wishers_count" style="color:#0447ab;">
                                                    <?php
                                                    if (!empty($birthday_wishers['birthday_wishers'])) {
                                                        // code...
                                                        echo count($birthday_wishers['birthday_wishers']);
                                                    }
                                                    ?>
                                                </span>
                                                <ul class="birthday_wish_list birthdayWisherList">
                                                    <?php
                                                    if (!empty($birthday_wishers['birthday_wishers'])) {
                                                        foreach ($birthday_wishers['birthday_wishers'] as $key => $wishers) : ?>
                                                            <li style="padding-bottom: 3px;" class="text-left"><?php echo $wishers->employee_fullname . ' [' . $wishers->employee_id_no . ']'; ?></li>
                                                    <?php
                                                        endforeach;
                                                    }
                                                    ?>
                                                </ul>
                                            </button>

                                        </th>
                                        <th colspan="2" class="text-right" style="padding-right:15px; font-weight: normal; width:20%;">
                                            <?php
                                            if (!empty($today_birthday_info) && count($today_birthday_info) > 0) { ?>
                                                <a href="#" data-toggle="modal" data-target="#birthdayList" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" style="color:#212529">
                                                    <strong>....</strong>
                                                </a>
                                            <?php } ?>
                                        </th>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <div class="col-12 o_group"></div> -->
                <div class="col-md-12" style="padding: 0px;">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Attendance & Leave </a>
                        </li>
                        <?php  if(Auth::guard('user')->user()->user_type != 8){ ?>
                        <li class="nav-item">
                            <a class="nav-link > <" id="my-profile-tab" data-toggle="tab" href="#myProfile" role="tab" aria-controls="myProfile" aria-selected="false">My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="employee-directory-tab" data-toggle="tab" href="#employee-directory" role="tab" aria-controls="employee-directory" aria-selected="false">Employee Directory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="file-manager-tab" data-toggle="tab" href="#file-manager" role="tab" aria-controls="file-manager" aria-selected="false">File Manager</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link assetsInfoId" id="assets-4" data-toggle="tab" href="#assets" role="tab" aria-controls="assets" aria-selected="false">Assets</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="payroll-tab" data-toggle="tab" href="#payroll" role="tab" aria-controls="payroll" aria-selected="false">Payroll</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="kpi-performance-tab" data-toggle="tab" href="#kpi-performance" role="tab" aria-controls="kpi-performance" aria-selected="false">KPI / Performance</a>
                        </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active home-min-height" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row" style="margin-left: -11px; margin-right: -11px;">
                                <div class="col-6 col-sm-4 col-md-2">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-clock-o"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Present</span>
                                            <span class="info-box-number "> {{$present_day_count ?? 0 }}</span>
                                        </div>
                                        <div role="separator" class="dropdown-divider"></div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4 col-md-2">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-clock-o"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Late</span>
                                            <span class="info-box-number ">
                                                {{$late_day_count ?? 0 }}
                                            </span>
                                        </div>
                                        <div role="separator" class="dropdown-divider"></div>
                                    </div>
                                </div>

                                <div class="clearfix hidden-md-up"></div>

                                <div class="col-6 col-sm-4 col-md-2">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-clock-o"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text"> Leave</span>
                                            <span class="info-box-number ">
                                                {{$leave_count ?? 0 }}
                                            </span>
                                        </div>
                                        <div role="separator" class="dropdown-divider"></div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4 col-md-2" title="Weekend & Holiday">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-dark elevation-1"><i class="fa fa-clock-o"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text" title="Weekend & Holiday">W/H</span>
                                            <span class="info-box-number">
                                                {{$holiday_count ?? 0 }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix hidden-md-up"></div>
                                <div class="col-6 col-sm-4 col-md-2">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-clock-o"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Absent</span>
                                            <span class="info-box-number ">
                                                {{$absent_day_count ?? 0 }}
                                            </span>
                                        </div>
                                        <div role="separator" class="dropdown-divider"></div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4 col-md-2">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info  elevation-1"><i class="fa fa-clock-o"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Pay Days</span>
                                            <span class="info-box-number ">
                                                {{$pay_days ?? 0 }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                           
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12 attendance_details" id="attendance_details_reload">
                                    <div class="col-md-5 float-left" style="padding: 0px;">
                                        <h6>
                                            <span style="color:#000;">Attendance Details </span>
                                        </h6>
                                    </div>
                                    <form action="{{URL::to('/index')}}" method="get" id='formId'>
                                        <div class="col-md-3 float-left daterange-input" style="padding:0px;">
                                            <input style="height: 22px;" name="from_date" type="text" class="form-control datepicker from_date_alert" placeholder="From" value="<?php if (!empty($ajax_from_date)) {
                                                                                                                                                                                                     echo $ajax_from_date;
                                                                                                                                                                                                     } ?>">
                                        </div>
                                        <div class="col-md-3 float-left daterange-input" style="padding:0px;">
                                            <input style="height: 22px;" id="datepickerto" name="to_date" type="text" class="form-control datepicker to_date_alert" placeholder="To" value="<?php if (!empty($ajax_to_date)) {
                                                                                                                                                                                                echo $ajax_to_date;
                                                                                                                                                                                            } ?>">
                                        </div>
                                    </form>
                                    <div class="col-md-1 float-left">
                                        <a href="/index" onclick="onLodingOverlay()"><i class="fa fa-refresh" aria-hidden="false" title="Refresh"></i></a>
                                    </div>
                                    <div style="    border: 1px solid #dee2e6;">
                                        <div style="min-height: 68vmin;" class="table-responsive">
                                            <table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" style="font-size:12px; border: none;width: 99.9%;">
                                                <thead>
                                                    <tr>
                                                        <th class="th-sm text-center">Date

                                                        </th>
                                                        <th class="th-sm text-center">Shift Time

                                                        </th>
                                                        <th class="th-sm text-center">In Time

                                                        </th>
                                                        <th class="th-sm text-center">Out Time

                                                        </th>
                                                        <th class="th-sm text-center">Late Hr.

                                                        </th>
                                                        <th class="th-sm text-center">Work Hr.

                                                        </th>
                                                        <th class="th-sm text-center">Status

                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="attendance_pagination">
                                                    <?php foreach ($attendances as $key => $att_value) : ?>
                                                        <tr>
                                                            <td class="text-center" style="width: 25% !important">
                                                                {{$att_value['date']}}
                                                            </td>

                                                            <td class="text-center">{{$att_value['shift_time']}}</td>
                                                            <td class="text-center">{{$att_value['intime']}}</td>
                                                            <td class="text-center">
                                                                <?php if ($att_value['intime'] == $att_value['outtime']) : ?>
                                                                    {{'00:00'}}
                                                                <?php else : ?>
                                                                    {{$att_value['outtime']}}
                                                                <?php endif ?>
                                                            </td>
                                                            <td class="text-center">{{$att_value['late_time']}}</td>
                                                            <td class="text-center">{{$att_value['work_time']}}</td>
                                                            <td class="text-center">
                                                                <?php
                                                                if ($att_value['statusId'] == 1 && $att_value['Status'] != 'W') {
                                                                    echo "<span title='Present' class='btn btn-xs btn-success' style='height:25px;color:#fff;font-weight:bold'>" . $att_value['Status'] . "</span>";

                                                                }elseif ($att_value['statusId'] == 1 && $att_value['Status'] == 'W') {
                                                                    echo '<a title="Present" class="btn btn-xs btn-success leaveAdjustment"  href="#" data-toggle="modal" data-target="#leaveAdjustment" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" style="height:25px;color:#fff;font-weight:bold"
                                                        data-present_date="' . $att_value['dates'] . '"
                                                        >' .
                                                                        $att_value['Status']
                                                                        . ' </a>';

                                                                } elseif ($att_value['statusId'] == 2) {
                                                                    echo '<a title="Late" class="btn btn-xs btn-warning lateApproveRequest"  href="#" data-toggle="modal" data-target="#lateApproveRequest" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" style="height:25px;color:#fff;font-weight:bold"
                                                        data-intime="' . $att_value['intime'] . '"
                                                        data-late_date="' . $att_value['dates'] . '"
                                                        >' .
                                                                        $att_value['Status']
                                                                        . ' </a>';
                                                                } elseif ($att_value['statusId'] == 3) {
                                                                    echo "<span class='btn btn-xs bg-primary' style='height:25px;width:28px;padding:3px;color:#ddd;font-weight:bold' title='Leave'>" . $att_value['Status'] . "</span>";
                                                                } elseif ($att_value['statusId'] == 4) {
                                                                    echo "<span class='btn btn-xs bg-dark' style='height:25px;color:#ddd;font-weight:bold' title='Weekend/Holiday'>" . $att_value['Status'] . "</span>";
                                                                } elseif ($att_value['statusId'] == 5) {
                                                                    echo '<a title="Absent" class="btn btn-xs btn-danger manualAttendanceRequest "  href="#" data-toggle="modal" data-target="#manualAttendanceRequest " data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" style="height:25px;color:#fff;font-weight:bold"
                                                        data-intime="' . $att_value['intime'] . '"
                                                        data-abasent_date="' . $att_value['dates'] . '"
                                                        >' .
                                                                        $att_value['Status']
                                                                        . ' </a>';
                                                                } else {
                                                                    echo "<span class='btn btn-xs btn-danger' style='height:25px;color:#fff;font-weight:bold' title='Absent'>" . $att_value['Status'] . "</span>";
                                                                } ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- <p id='attendance_pagination'> </p>     -->
                                    </div>
                                    <!-- </div> -->
                                </div>
                               
                                <div class="col-md-6 col-sm-12 col-xs-12 float-left">
                                    <div class="col-md-12" style="padding:0px">
                                        <div>
                                            <h6>Attendance Graph</h6>
                                        </div>
                                        <ul class="nav nav-tabs" id="myTab" role="tablist" style="padding-left: 0px;">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="present-tab" data-toggle="tab" href="#present_days" role="tab" aria-controls="present" aria-selected="false">Presents</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " id="home-tab" data-toggle="tab" href="#late_days" role="tab" aria-controls="home" aria-selected="true">Lates</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " id="home-tab" data-toggle="tab" href="#absent_days" role="tab" aria-controls="home" aria-selected="true">Absent</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="present_days" role="tabpanel" aria-labelledby="profile-tab" style="padding: 0px;">
                                                <canvas id="presentCanvas" style="height: 400px !important;"></canvas>
                                            </div>
                                            <div class="tab-pane fade" id="late_days" role="tabpanel" aria-labelledby="contact-tab" style="padding: 0px;">
                                                <canvas id="lateCanvas" style="height: 400px !important;"></canvas>
                                            </div>
                                            <div class="tab-pane fade" id="absent_days" role="tabpanel" aria-labelledby="contact-tab" style="padding: 0px;">
                                                <canvas id="absentCanvas" style="height: 400px !important;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12 table-responsive" style="padding:0px">
                                        <table id="dtBasicExample" class="table table-striped table-bordered leave-table" cellspacing="0" style="font-size:12px;width: 99.9%;">
                                            <thead>
                                                <tr>
                                                    <th colspan="7" class="th-sm text-left">
                                                        <i class="fa fa-calendar"></i>
                                                        My Leave
                                                    </th>
                                                </tr>
                                                <tr class="text-center;" style="border: 1px solid #ddd;">
                                                    <th style="width: 18%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);">Type</th>
                                                    <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Entitle.</th>
                                                    <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Prev. Balance</th>
                                                    <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Total Entitle.</th>
                                                    <th style="width: 15%;text-align: center;vertical-align: middle;background: #f5f5f5;">Availed</th>
                                                    <th style="width: 15%;text-align: center;vertical-align: middle;background: #f5f5f5;">Balance</th>
                                                    <th style="width: 15%;text-align: center;vertical-align: middle;background: #f5f5f5;">Service</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            <?php foreach ($leaveInfo as $key => $form_data) : ?>
                                                <tr>
                                                    <td>{{ $form_data['leave_type_name']  }}</td>
                                                    <td class="text-center">{{ $form_data['entitlementThisYear'] }}
                                                    </td>
                                                    <td class="text-center">
                                                    {{ $form_data['previousBalance'] }}
                                                    </td>
                                                    <td class="text-center">
                                                    {{ $form_data['totalEntitlement'] }}
                                                    </td>
                                                    <td class="text-center">{{ $form_data['totalDay'] }}</td>
                                                    <td class="text-center">{{ $form_data['balance'] }}</td>
                                                    <?php if($key == 0){ ?>
                                                        <td style="vertical-align: middle;">
                                                            <a class="btn btn-warning apply_leave_class" href="#" data-toggle="modal" data-target="#applyLeave" id="app-lyLeave-tab" data-whatever="@getbootstrap" style="color:#212529; text-decoration: none;width: 115px;">
                                                                Apply Leave
                                                            </a>
                                                        </td>
                                                    <?php } ?>
                                                    <?php if($key == 1){ ?>
                                                        <td style="vertical-align: middle;">
                                                            <a class="btn btn-warning leaveCalendar" data-toggle="modal" id="add_appointment" href="#modal_form_addappt" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" style="color:#212529; text-decoration: none; width: 115px;">
                                                                Service Calendar
                                                            </a>
                                                        </td>
                                                    <?php } ?>
                                                    <?php if ($key == 2) { ?>
                                                        <td style="vertical-align: middle;">
                                                            <a class="btn btn-warning holidayCalendar" data-toggle="modal" id="add_appointment" href="#modal_form_holiday_calendar" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" style="color:#212529; text-decoration: none; width: 115px;">
                                                                Holiday Calendar
                                                            </a>
                                                        </td>
                                                    <?php } ?>
                                                    <?php if ($key == 3 || $key == 4) { ?>
                                                        <td style="vertical-align: middle;"></td>
                                                    <?php } ?>
                                                </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                            <!-- <tbody>
                                                <tr>
                                                    <td style="text-align:left;">Leave</td>
                                                    <?php foreach ($leave_type_info as $key => $value) : ?>
                                                        <td><?php echo $value['leave_type_name']; ?></td>
                                                    <?php endforeach ?>
                                                    <td rowspan="2" style="vertical-align: middle;background: #fff;">
                                                        <a class="btn btn-warning leaveCalendar" data-toggle="modal" id="add_appointment" href="#modal_form_addappt" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" style="color:#212529; text-decoration: none;">
                                                            Service Calendar
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:left;">Entitlement</td>
                                                    <?php foreach ($leave_type_info as $key => $value) : ?>
                                                        <td><?php echo $value['leave_day_no']; ?></td>
                                                    <?php endforeach ?>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:left;">Prev. Balance</td>
                                                    <?php foreach ($leave_available as $key => $value) : ?>
                                                        <td><?php echo $value['Prev']; ?></td>
                                                    <?php endforeach ?>
                                                    <td rowspan="2" style="vertical-align: middle;background: #fff;">
                                                        <a class="btn btn-warning holidayCalendar" data-toggle="modal" id="add_appointment" href="#modal_form_holiday_calendar" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" style="color:#212529; text-decoration: none;">
                                                            Holiday Calendar
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:left;">Total Entitle.</td>
                                                    <?php foreach ($leave_available as $key => $value) : ?>
                                                        <td><?php echo $value['totalEntitle']; ?></td>
                                                    <?php endforeach ?>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:left;">Availed</td>
                                                    <?php foreach ($leave_consumed as $key => $value) : ?>
                                                        <td><?php echo $value; ?></td>
                                                    <?php endforeach ?>
                                                    <td rowspan="2" style="vertical-align: middle;background: #fff;">

                                                        <a class="btn btn-warning apply_leave_class" href="#" data-toggle="modal" data-target="#applyLeave" data-whatever="@getbootstrap" style="color:#212529; text-decoration: none;width: 104px;">
                                                            Apply Leave
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:left;">Balance</td>
                                                    <?php foreach ($leave_available as $key => $value) : ?>
                                                        <td><?php echo $value['leave_remaining']; ?></td>
                                                    <?php endforeach ?>
                                                </tr>
                                            </tbody> -->
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade home-min-height" id="myProfile" role="tabpanel" aria-labelledby="profile-tab" style="padding-left:0px;">
                            <div class="w-100 d-flex justify-content-center align-items-center">
                                <div class="spinner"></div>
                            </div>
                        </div>

                        <div class="tab-pane fade home-min-height" id="employee-directory" role="tabpanel" aria-labelledby="tab5">
                            <div class="w-100 d-flex justify-content-center align-items-center">
                                <div class="spinner"></div>
                            </div>
                        </div>
                       
                        <div class="tab-pane fade home-min-height " id="file-manager" role="tabpanel" aria-labelledby="tab5">
                            <div class="w-100 d-flex justify-content-center align-items-center">
                                <div class="spinner"></div>
                            </div>
                        </div>
                        
                     
                        <!-- href="/index" onclick="onLodingOverlay()" -->
                        <div class="tab-pane fade home-min-height" id="payroll" role="tabpanel" aria-labelledby="tab5">
                            <div class="w-100 d-flex justify-content-center align-items-center">
                                <div class="spinner"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade home-min-height " id="file-manager" role="tabpanel" aria-labelledby="tab5">
                            <div class="w-100 d-flex justify-content-center align-items-center">
                                <div class="spinner"></div>
                            </div>
                        </div>
                       
                        <div class="tab-pane fade home-min-height" id="kpi-performance" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="w-100 d-flex justify-content-center align-items-center">
                                <div class="spinner"></div>
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>
        </div>

       
        <!-- Change Password Modal -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <form id="form-change-password" role="form" method="POST" action="{{ route('changePassword') }}" novalidate>
                        <div class="modal-body">
                            <div class="row col-md-12">
                                <label for="current-password" class="col-sm-5 control-label float-left">Current Password<sup style="color:red;">*</sup></label>
                                <div class="col-sm-7 float-left">
                                    <div class="form-group">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="password" class="form-control" id="current-password" name="current-password" placeholder="Password" required>
                                    </div>
                                </div>
                                <label for="password" class="col-sm-5 control-label float-left">New Password<sup style="color:red;">*</sup></label>
                                <div class="col-sm-7 float-left">
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="New Password" data-rule-password="true" required>
                                    </div>
                                </div>
                                <label for="password_confirmation" class="col-sm-5 control-label float-left">Re-enter Password<sup style="color:red;">*</sup></label>
                                <div class="col-sm-7 float-left">
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter Password" data-rule-password_confirmation="true" data-rule-equalTo="#password" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="padding: 10px 35px;">
                            <button href="{{ route('user.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">@csrf
                            </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="profileImageUpload" tabindex="-1" role="dialog" aria-labelledby="serviceRequestLabel" aria-hidden="true">
            <form id="" class="well form-horizontal needs-validation leave-application" action="{{ url('/profile_image_upload') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-dialog" role="document" style="max-width: 30%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="serviceRequestLabel">
                                <i class="fa fa-list"></i>
                                Profile Image Upload
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="false">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input name="employee_id" type="hidden" value="<?php echo $employee_data['employee_id'] ?>">
                            <div class="row" style="margin: 0px;">
                                <div class="col-md-12" style="padding:0px;">
                                    <div class="col-md-12 float-left" style="padding:0px;">
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important;">
                                            <div class="col-md-12 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Upload</label>
                                            </div>
                                            <div class="col-md-12 float-left inputGroupContainer" style="padding-left: 0px !important; margin-bottom: 10px;">
                                                <div class="col-md-4 inputGroupContainer float-left" style="padding-left: 0px !important;">
                                                    <input style="text-overflow: ellipsis;text-align: left;width: 300px;overflow: hidden;white-space: nowrap;" name="employee_image" type="file">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="padding: 10px 15px;">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 2px;background: #e9e9e9;    padding: 5px;margin-right: 3px;    color: #000;border: 1px solid #aaa;padding-right: 10px;    padding-left: 10px;">Cancel</button>
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    
        <div class="modal fade" id="serviceList" tabindex="-1" role="dialog" aria-labelledby="serviceListLabel" aria-hidden="true">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-dialog" role="document" style="min-width: 50%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title serviceListLabel1 col-md-8">
                            <i class="fa fa-list"></i>
                            Service Request
                        </h5>
                        <div class="col-md-3 text-right">
                            <a class="add_new_service_modal text-right btn btn-info" href="#" data-toggle="modal" data-target="#serviceRequest" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">Add New</a>
                        </div>
                        <button type="button" class="close closeServiceList col-md-1" data-dismiss="modal" aria-label="Close" style="margin-left:0px;">
                            <span aria-hidden="false" style="margin-left:0px;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input name="employee_id" type="hidden" value="<?php echo $employee_data['employee_id']; ?>">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="service_list_tab" role="tabpanel" aria-labelledby="profile-tab" style="padding: 0px;">
    
                                <div class="col-md-12 serviceListSection">
                                    <div class="col-md-4 float-left" style="padding-left:0px; padding-right: 20px;">
                                        <div class="info-box mb-4">
                                            <span class="info-box-icon bg-info elevation-1"><i class="fa fa-paper-plane"></i></span>
    
                                            <div class="info-box-content">
                                                <span class="info-box-text">Request</span>
                                                <span class="info-box-number" id="requested_info_id"></span>
                                            </div>
                                            <div role="separator" class="dropdown-divider"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 float-left">
                                        <div class="info-box mb-4">
                                            <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check"></i></span>
    
                                            <div class="info-box-content">
                                                <span class="info-box-text">Approve</span>
                                                <span class="info-box-number" id="approved_info_id"></span>
                                            </div>
                                            <div role="separator" class="dropdown-divider"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 float-left" style="right:-15px; padding-left: 5px;">
                                        <div class="info-box mb-4">
                                            <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-clock-o"></i></span>
    
                                            <div class="info-box-content">
                                                <span class="info-box-text">Pending</span>
                                                <span class="info-box-number" id="pending_info_id"></span>
                                            </div>
                                            <div role="separator" class="dropdown-divider"></div>
                                        </div>
                                    </div>
                                    <!-- <h4 class='text-center' style="margin-top:10px;">Service List</h4> -->
                                    <table class="table table-striped table-bordered serviceListTable" cellspacing="0" width="100%" style="font-size:12px; border: none;    ">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope='col' style='border:1px solid #ddd !important;'>#</th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>Date</th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>Service Type</th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>Purpose</th>
                                                <th scope='col' style='border:1px solid #ddd !important;' class="text-center">Status</th>
                                                <th scope='col' style='border:1px solid #ddd !important;' class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id='ServiceListAppend'>
    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="lateApproveRequest" tabindex="-1" role="dialog" aria-labelledby="serviceRequestLabel" aria-hidden="true">
            <form id="late_request_submit" class="well form-horizontal needs-validation leave-application">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title col-md-9" id="serviceRequestLabel">
                                <i class="fa fa-list"></i>
                                Late Approve Request
                            </h5>
                            <div class=" text-right backToServiceListdiv" style="display: none;">
                                <a href="#" class="backToServiceList" style="color: black;"><i class="fa fa-backward"></i> Back to List</a>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="false">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input name="employee_id" type="hidden" value="<?php echo $employee_data['employee_id'] ?>">
                            <input class="late_date_modal" name="late_date" type="hidden">
                            <input id="row_id" name="id" type="hidden">
                            <div class="row" style="margin: 0px;">
                                <div class="col-md-12" style="padding:0px;">
                                    <div class="col-md-12 float-left" style="padding:0px;">
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">In Time <span class="required_sign">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer">
                                                <div class="input-group">
                                                    <input name="in_time" class="form-control intime_modal" width="100%" style="border:1px solid #aaa !important;" readonly />
    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Actual In Time <span class="required_sign">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer">
                                                <div class="input-group">
                                                    <input name="actual_in_time" class="form-control timepicker" id="timepicker" width="100%" style="border:1px solid #aaa !important;" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row  form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-12 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Late Reason <span class="required_sign">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-12 float-left inputGroupContainer" style="padding: 0px">
                                                <div class="input-group">
                                                    <textarea name="late_reason" placeholder="Enter your reason..." required="required" type="text" class="form-control" style="height: 100px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="padding: 10px 35px;">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 2px;background: #e9e9e9;    padding: 5px;margin-right: 3px;    color: #000;border: 1px solid #aaa;padding-right: 10px;    padding-left: 10px;">Cancel</button>
                            <button type="submit" class="btn btn-info">Send Request</button>
                            <button type="submit" class="btn btn-info updateRequestBtn backToServiceList" style="display: none;">Update Request</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade" id="manualAttendanceRequest" tabindex="-1" role="dialog" aria-labelledby="manualAttendanceLabel" aria-hidden="true">
            <form id="manualAttendance_request_submit" class="well form-horizontal needs-validation leave-application">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title col-md-9" id="manualAttendanceLabel">
                                <i class="fa fa-list"></i>
                                Manual Attendance Request
                            </h5>
                            <div class=" text-right backToServiceListdiv" style="display: none;">
                                <a href="#" class="backToServiceList" style="color: black;"><i class="fa fa-backward"></i> Back to List</a>
                            </div>
                            <div class="text-right backToServiceCalendar" style="display: none;">
                                <a href="#" style="color: black;"><i class="fa fa-backward"></i> Back </a>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="false">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input name="employee_id" type="hidden" value="<?php echo $employee_data['employee_id'] ?>">
                            <input id="row_id" name="id" type="hidden">
                            <div class="row" style="margin: 0px;">
                                <div class="col-md-12" style="padding:0px;">
                                    <div class="col-md-12 float-left" style="padding:0px;">
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Attendance Issues<span class="required_sign">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer" style="padding-right:0px;">
                                                <div class="input-group service_select">
                                                    <select name="manual_attendance_issues" name="state" style="padding-left:5px; height: 27px; border-radius:.25rem;">
                                                        <option>--Select--</option>
                                                        <?php foreach ($attendance_issues as $key => $value) : ?>
                                                            <option value="{{$value['id']}}">{{$value['attendance_issue']}}</option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Attendance Date <span class="required_sign">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer" style="padding-right: 0px;">
                                                <div class="form-group datepicker-container">
                                                    <div class="col-md-12 float-left" style="padding-left:0px; padding-right: 0px;">
                                                        <div class="input-group">
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <input class="absent_date_1 absent_date" name="manual_attendance_date" type="date" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Start Time <span class="required_sign">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer" style="padding-right:0px;">
                                                <div class="input-group">
                                                    <input name="manual_start_time" class="form-control timepicker1" width="100%" style="border:1px solid #aaa !important;" />
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">End Time
                                                </label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer" style="padding-right:0px;">
                                                <div class="input-group">
                                                    <input name="manual_end_time" class="form-control timepicker2" width="100%" style="border:1px solid #aaa !important;" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row  form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-12 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Remarks/Details
                                                    <!-- <span class="required_sign">*</span> -->
                                                </label>
                                            </div>
                                            <div class="col-md-12 float-left inputGroupContainer" style="padding: 0px;">
                                                <div class="input-group">
                                                    <textarea name="manual_remarks" placeholder="Enter Details" class="form-control" style="height: 100px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="padding: 10px 35px; padding-right:25px;">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 2px;background: #e9e9e9;    padding: 5px;margin-right: 3px;    color: #000;border: 1px solid #aaa;    padding-right: 10px;    padding-left: 10px;">Cancel</button>
                            <button type="submit" class="btn btn-info sendRequestBtn">Send Request</button>
                            <button type="submit" class="btn btn-info updateRequestBtn" style="display: none;">Update Request</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade" id="leaveAdjustment" tabindex="-1" role="dialog" aria-labelledby="serviceRequestLabel" aria-hidden="true">
            <form id="leave_adjustment_submit" class="well form-horizontal needs-validation leave-application">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title col-md-9" id="serviceRequestLabel">
                                <i class="fa fa-list"></i>
                                Leave Adjustment Request
                            </h5>
                            <div class=" text-right backToServiceListdiv" style="display: none;">
                                <a href="#" class="backToServiceList" style="color: black;"><i class="fa fa-backward"></i> Back to List</a>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="false">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input name="employee_id" type="hidden" value="<?php echo $employee_data['employee_id'] ?>">
                            <input class="present_date_id" name="present_date" type="hidden">
                            <input id="row_id" name="id" type="hidden">
                            <div class="row" style="margin: 0px;">
                                <div class="col-md-12" style="padding:0px;">
                                    <div class="col-md-12 float-left" style="padding:0px;">
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Present Date <span class="required_sign">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer">
                                                <div class="input-group">
                                                    <input class="absent_date_1 absent_date present_date_id" name="present_date"   type="date" style="width: 100%;" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Adjustment Date <span class="required_sign">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer">
                                                <div class="input-group">
                                                    <input class="absent_date_1 absent_date" name="leave_adjutment_date"  type="date" style="width: 100%;" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row  form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-12 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Remarks
                                                    <!-- <span class="required_sign">*</span> -->
                                                </label>
                                            </div>
                                            <div class="col-md-12 float-left inputGroupContainer" style="padding: 0px">
                                                <div class="input-group">
                                                    <textarea name="leave_adjustment_remarks" placeholder="Enter your remarks..." type="text" class="form-control" style="height: 100px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="padding: 10px 35px;">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 2px;background: #e9e9e9;    padding: 5px;margin-right: 3px;    color: #000;border: 1px solid #aaa;padding-right: 10px;    padding-left: 10px;">Cancel</button>
                            <button type="submit" class="btn btn-info">Send Request</button>
                            <!-- <button type="submit" class="btn btn-info updateRequestBtn backToServiceList" style="display: none;">Update Request</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade" id="serviceList" tabindex="-1" role="dialog" aria-labelledby="serviceListLabel" aria-hidden="true">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-dialog" role="document" style="min-width: 50%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title serviceListLabel1 col-md-8">
                            <i class="fa fa-list"></i>
                            Service Request
                        </h5>
                        <div class="col-md-3 text-right">
                            <a class="add_new_service_modal text-right btn btn-info" href="#" data-toggle="modal" data-target="#serviceRequest" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">Add New</a>
                        </div>
                        <button type="button" class="close closeServiceList col-md-1" data-dismiss="modal" aria-label="Close" style="margin-left:0px;">
                            <span aria-hidden="false" style="margin-left:0px;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input name="employee_id" type="hidden" value="<?php echo $employee_data['employee_id']; ?>">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="service_list_tab" role="tabpanel" aria-labelledby="profile-tab" style="padding: 0px;">
    
                                <div class="col-md-12 serviceListSection">
                                    <div class="col-md-4 float-left" style="padding-left:0px; padding-right: 20px;">
                                        <div class="info-box mb-4">
                                            <span class="info-box-icon bg-info elevation-1"><i class="fa fa-paper-plane"></i></span>
    
                                            <div class="info-box-content">
                                                <span class="info-box-text">Request</span>
                                                <span class="info-box-number" id="requested_info_id"></span>
                                            </div>
                                            <div role="separator" class="dropdown-divider"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 float-left">
                                        <div class="info-box mb-4">
                                            <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check"></i></span>
    
                                            <div class="info-box-content">
                                                <span class="info-box-text">Approve</span>
                                                <span class="info-box-number" id="approved_info_id"></span>
                                            </div>
                                            <div role="separator" class="dropdown-divider"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 float-left" style="right:-15px; padding-left: 5px;">
                                        <div class="info-box mb-4">
                                            <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-clock-o"></i></span>
    
                                            <div class="info-box-content">
                                                <span class="info-box-text">Pending</span>
                                                <span class="info-box-number" id="pending_info_id"></span>
                                            </div>
                                            <div role="separator" class="dropdown-divider"></div>
                                        </div>
                                    </div>
                                    <!-- <h4 class='text-center' style="margin-top:10px;">Service List</h4> -->
                                    <table class="table table-striped table-bordered serviceListTable" cellspacing="0" width="100%" style="font-size:12px; border: none;    ">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope='col' style='border:1px solid #ddd !important;'>#</th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>Date</th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>Service Type</th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>Purpose</th>
                                                <th scope='col' style='border:1px solid #ddd !important;' class="text-center">Status</th>
                                                <th scope='col' style='border:1px solid #ddd !important;' class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id='ServiceListAppend'>
    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="serviceRequest" tabindex="-1" role="dialog" aria-labelledby="serviceRequestLabel" aria-hidden="true">
            <form id="service_request_submit" class="well form-horizontal needs-validation leave-application">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title col-md-9" id="serviceRequestLabel">
                                <i class="fa fa-paper-plane"></i>
                                Service Request
                            </h5>
                            <div class=" text-right backToServiceListdiv" style="display: none;">
                                <a href="#" class="backToServiceList" style="color: black;"><i class="fa fa-backward"></i> Back to List</a>
                            </div>
                            <div class="text-right backToServiceCalendar" style="display: none;">
                                <a href="#" style="color: black;"><i class="fa fa-backward"></i> Back </a>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="false">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input name="employee_id" type="hidden" value="<?php echo isset($employee_data['employee_id']) ? $employee_data['employee_id'] : ''; ?>">
                            <input id="row_id" name="id" type="hidden">
                            <div class="row" style="margin: 0px;">
                                <div class="col-md-12" style="padding:0px;">
                                    <div class="col-md-12 float-left" style="padding:0px;">
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Service Type <span class="required_sign">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer" style="padding-right:0px;">
                                                <div class="input-group service_select">
                                                    <select id="service_type_id" name="service_type" name="state" style="padding-left:5px;">
                                                        <option class="select_service_type">--Select--</option>
                                                        <option value="1">NOC (No Objection Certificate)</option>
                                                        <option value="5">Employment Certificate</option>
                                                        <option value="6">Experience Certificate</option>
                                                        <option value="2">Salary Certificate</option>
                                                        <option value="3">Pay Slip</option>
                                                        <option value="4">Manual Attendance</option>
                                                        <option value="7">General Stationery</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 lastServiceRecived" style="margin-bottom: 20px !important; margin:0px; display: none !important;">
                                            <table class="float-right" style="color:blue; margin-right: 13px;margin-bottom:15px;">
                                                <tbody>
                                                    <tr>
                                                        <td>Last Receving Date :</td>
                                                        <td id="last_receiving_date">22/11/2020</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Purpose :</td>
                                                        <td id="last_purposes">For Indian Visa...</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Date <span class="required_sign">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer" style="padding-right: 0px;">
                                                <div class="form-group datepicker-container">
                                                    <div class="col-md-6 float-left" style="padding: 0px;">
                                                        <div class="input-group">
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <input name="service_date_from" type="date" style="width: 92%;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 float-left" style="padding: 0px;">
                                                        <div class="input-group">
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <input name="service_date_to" type="date" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row  form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-12 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Purpose/Details <span class="required_sign">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-12 float-left inputGroupContainer" style="padding: 0px;">
                                                <div class="input-group">
                                                    <textarea name="service_purpose" placeholder="Enter Details" required="required" type="text" class="form-control" style="height: 100px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="padding: 10px 35px; padding-right:25px;">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 2px;background: #e9e9e9;    padding: 5px;margin-right: 3px;    color: #000;border: 1px solid #aaa;    padding-right: 10px;    padding-left: 10px;">Cancel</button>
                            <button type="submit" class="btn btn-info sendRequestBtn">Send Request</button>
                            <button type="submit" class="btn btn-info updateRequestBtn" style="display: none;">Update Request</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    
        
        <div class="modal fade" id="generalStationeryRequest" tabindex="-1" role="dialog" aria-labelledby="generalStationeryLabel" aria-hidden="true">
            <form id="generalStationeryRequest_submit" class="well form-horizontal needs-validation leave-application">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title col-md-9" id="manualAttendanceLabel">
                                <i class="fa fa-list"></i>
                                General Stationery Request
                            </h5>
                            <div class=" text-right backToServiceListdiv" style="display: none;">
                                <a href="#" class="backToServiceList" style="color: black;"><i class="fa fa-backward"></i> Back to List</a>
                            </div>
                            <div class="text-right backToServiceCalendar" style="display: none;">
                                <a href="#" style="color: black;"><i class="fa fa-backward"></i> Back </a>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="false">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input name="employee_id" type="hidden" value="<?php echo $employee_data['employee_id'] ?>">
                            <input id="row_id" name="id" type="hidden">
                            <div class="row" style="margin: 0px;">
                                <div class="col-md-12" style="padding:0px;">
                                    <div class="col-md-12 float-left" style="padding:0px;">
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Type
                                                </label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer" style="padding-right:0px;">
                                                <div class="input-group service_select">
                                                    <select id="product_type_list" name="product_type" name="state" style="padding-left:5px; height: 27px; border-radius:.25rem;">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Category
                                                </label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer" style="padding-right:0px;">
                                                <div class="input-group service_select">
                                                    <select id="product_category_list" name="product_category" name="state" style="padding-left:5px; height: 27px; border-radius:.25rem;">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Product<span class="required_sign">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-8 float-left inputGroupContainer" style="padding-right:0px;">
                                                <div class="input-group service_select">
                                                    <select id="product_item_list" name="product_item" name="state" style="padding-left:5px; height: 27px; border-radius:.25rem;">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Product Qty<span class="required_sign">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-7 float-left inputGroupContainer" style="padding-right: 0px;">
                                                <div class="form-group datepicker-container">
                                                    <div class="col-md-12 float-left" style="padding-left:0px; padding-right: 0px;">
                                                        <div class="input-group">
                                                            <div class="col-md-10" style="padding: 0px;">
                                                                <input id="product_qty" class="absent_date_1 absent_date" name="product_qty" type="number" step="0.01" style="width: 100%;">
                                                            </div>
                                                            <div class="col-md-2" style="padding-left: 5px;">
                                                                <span id="product_unit_name"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1 float-left inputGroupContainer" style="padding-left: 7px;">
    
                                                 <a class="btn btn-success" id="add_product_data" ><i class="fa fa-plus"></i></a>
    
                                            </div>
                                        </div>
    
                                        <div class="row form-group col-md-12" style="margin-bottom: 0px !important; margin:0px;">
                                            <table id="salaryListTable" class="table table-striped table-bordered salaryListTable" cellspacing="0" style="font-size:12px; border: none;">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope='col' style='border:1px solid #ddd !important;'>#</th>
                                                        <th scope='col' style='border:1px solid #ddd !important;'>Type</th>
                                                        <th scope='col' style='border:1px solid #ddd !important;'>Category</th>
                                                        <th scope='col' style='border:1px solid #ddd !important;'>Product</th>
                                                        <th scope='col' style='border:1px solid #ddd !important;'>P. Qty</th>
                                                        <th scope='col' style='border:1px solid #ddd !important;'>UoM</th>
                                                        <th scope='col' style='border:1px solid #ddd !important; '> Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="stationary_list">
                                                </tbody>
                                            </table>
                                        </div>
    
                                        <div class="row  form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                            <div class="col-md-12 float-left" style="padding-left: 0px;">
                                                <label class="control-label">Remarks/Details</label>
                                            </div>
                                            <div class="col-md-12 float-left inputGroupContainer" style="padding: 0px;">
                                                <div class="input-group">
                                                    <input type="hidden" class = "stationery_no" name="stationery_no" >
                                                    <input type="hidden" class = "stationary_remarks" name="stationary_remarks" >
                                                    <textarea name="stationary_remarks" placeholder="Enter Details" class="form-control stationary_remarks" style="height: 100px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="padding: 10px 35px; padding-right:25px;">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 2px;background: #e9e9e9;    padding: 5px;margin-right: 3px;    color: #000;border: 1px solid #aaa;    padding-right: 10px;    padding-left: 10px;">Cancel</button>
                            <button type="submit" class="btn btn-info sendRequestBtn">Send Request</button>
                            <button type="submit" class="btn btn-info updateRequestBtn" style="display: none;">Update Request</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="applyLeave" tabindex="-1" role="dialog" aria-labelledby="applyLeaveLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="min-width: 55%;">
                <form id="leave_application_submit" class="well form-horizontal needs-validation leave-application">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="col-md-10" v-if="add_new_type!=5"><i class="fa fa-bars"></i> Leave Application</h4>
                            <div class=" text-right backToServiceListdiv" style="display: none;">
                                <a href="#" class="backToServiceList" style="color: black;"><i class="fa fa-backward"></i> Back to List</a>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="false">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="tab-pane fade home-min-height " id="app-lyLeave" role="tabpanel" aria-labelledby="tab5">
                                <div class="w-100 d-flex justify-content-center align-items-center">
                                    <div class="spinner"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="form-actions col-md-12">
                                <div class="form-actions col-md-8" style="float: right;padding:0px;">
                                    <input id='send_leave_request' type="submit" tabindex="4" value="Send Request" class="btn btn-sm btn-info float-right col-md-3" style="font-size: 14px; padding-bottom: 3px; margin-left:10px;">
        
                                    <input id='update_leave_request' type="submit" tabindex="4" value="Update Request" class="btn btn-sm btn-info float-right col-md-3" style="font-size: 14px; padding-bottom: 3px; margin-left:10px; display:none;">
        
                                    <input title="Leave Form Preview" data-toggle="modal" data-target="#leaveForm " data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" tabindex="4" value="Leave Form" class="btn btn-sm btn-success leaveForm  float-right col-md-3" style="font-size: 14px; padding: 3px 20px">
        
                                    <button type="button" class="btn btn-sm btn-default float-right col-md-3 close" data-dismiss="modal" aria-label="Close" style="font-size: 14px; margin-top: 0px;background: #e9e9e9;    padding: 6px;margin-right: 10px;    color: #000;border: 1px solid #aaa;">Cancel</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        
    

        
      






   

    <!--  Loan Schedule Modal End -->
    <?php
    
    function limit_text($text, $limit)
    {

        $text1 = str_replace("<br>", "", $text);
        if (str_word_count($text1, 0) > $limit) {
            $words = str_word_count($text1, 2);
            $pos   = array_keys($words);
            $text  = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
    ?>

</body>
<div id="overlay" onclick="off()">
    <div class="w-100 d-flex justify-content-center align-items-center">
        <div class="spinner"></div>
    </div>
</div>
<script>
    // $('.assetsInfoId').on('click', function(){
    //     $('#assets').css('display', 'inline-block');
    //     var page = $(this).id('#assets');
    //     $('.assets_tab').load(page);
    // });
    // function assets_componet_load(){
    //     alert('assets_componet_load');
    // }
    //<a class="nav-link > <" id="my-profile-tab" data-toggle="tab" href="#my-profile" role="tab" aria-controls="my-profile" aria-selected="false">My Profile</a>

    $("#assets-4").click(function() {
        // alert("You clicked me!");
        $("#kpi-performance").html('<div class="w-100 d-flex justify-content-center align-items-center"><div class="spinner"></div></div>');
        $("#assets").load("/assets_component");
    });

    $("#kpi-performance-tab").click(function() {
        $("#kpi-performance").html('<div class="w-100 d-flex justify-content-center align-items-center"><div class="spinner"></div></div>');
        $("#kpi-performance").load("/kra_kpi_mos_dashboard_user");
    });
    $("#my-profile-tab").click(function() {
        $("#myProfile").html('<div class="w-100 d-flex justify-content-center align-items-center"><div class="spinner"></div></div>');
        $("#myProfile").load("/my_profile_component");
    });
    $("#employee-directory-tab").click(function() {
        $("#employee-directory").html('<div class="w-100 d-flex justify-content-center align-items-center"><div class="spinner"></div></div>');
        $("#employee-directory").load("/employee_Directory_component");
    });
    $("#payroll-tab").click(function() {
        $("#payroll").html('<div class="w-100 d-flex justify-content-center align-items-center"><div class="spinner"></div></div>');
        $("#payroll").load("/payroll_component");
    });

    $("#file-manager-tab").click(function() {
        $("#file-manager").html('<div class="w-100 d-flex justify-content-center align-items-center"><div class="spinner"></div></div>');
        $("#file-manager").load("/file_manager_component");
    });
    $("#app-lyLeave-tab").click(function() {
        alert("You clicked me!");
        $("#app-lyLeave").html('<div class="w-100 d-flex justify-content-center align-items-center"><div class="spinner"></div></div>');
        $("#app-lyLeave").loadLayersModel("/leave_apply_component");
    });

    

    
    $(".apply_leave_class").click(function() {
        $("#leave_application_submit")[0].reset();
        $('#send_leave_request').css('display', 'inline');
        $('#update_leave_request').css('display', 'none');
    });

    $('#leave_type_id').on('change', function() {
        var leave_type_text = $("#leave_type_id option:selected").text();
        $('#leave_type_text_lf').text(leave_type_text + ' Leave');

        // alert(leave_type_text);

        if (leave_type_text == '--Select--') {
            $('.applied_for1').css('display', 'inline');
            $('.applied_for2').css('display', 'none');
        } else {
            $('.applied_for1').css('display', 'none');
            $('.applied_for2').css('display', 'inline');
        }
        console.log(leave_type_text);
    });
    $('.leave_reason_text').on('input', function() {
        var _leave_reason_text = $(".leave_reason_text").val();
        // alert(_leave_reason_text);
        $('#leave_reason_id').text(_leave_reason_text);
        console.log(_leave_reason_text);
    });
    $('.address_on_leave').on('input', function() {
        var _address_on_leave = $(".address_on_leave").val();
        $('#addres_while_on_leave').text(_address_on_leave);
        console.log(_address_on_leave);
    });
    $(document).ready(function() {
        $('#grid').masonry({
            itemSelector: '.grid-item'
        });
    });

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

    $('#assetsTable').dataTable({
        "destroy": true,
        "pageLength": 5,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false
    });
    $('.assetsInfo').show(500);

    

    $('.timepicker').timepicker({
        uiLibrary: 'bootstrap4'
    });
    $('.timepicker1').timepicker({
        uiLibrary: 'bootstrap4'
    });
    $('.timepicker2').timepicker({
        uiLibrary: 'bootstrap4'
    });
    $(document).ready(function() {
        function clear_icon() {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
        }

       

        $(document).on('keyup keydown paste input', '#serach', function() {
            // alert('ddd');
            var query = $('#serach').val();
            // alert();
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = $('#hidden_page').val();
            var view_type = $('#view_type').val();
            // alert(view_type);
            fetch_data(page, sort_type, column_name, query, view_type);
        });

        $(document).on('click', '.sorting', function() {
            var column_name = $(this).data('column_name');
            var order_type = $(this).data('sorting_type');
            var reverse_order = '';
            if (order_type == 'asc') {
                $(this).data('sorting_type', 'desc');
                reverse_order = 'desc';
                clear_icon();
                $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
            }
            if (order_type == 'desc') {
                $(this).data('sorting_type', 'asc');
                reverse_order = 'asc';
                clear_icon
                $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
            }
            $('#hidden_column_name').val(column_name);
            $('#hidden_sort_type').val(reverse_order);
            var page = $('#hidden_page').val();
            var query = $('#serach').val();
            var view_type = $('#view_type').val();
            fetch_data(page, reverse_order, column_name, query, view_type);
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();

            var query = $('#serach').val();

            $('li').removeClass('active');
            $(this).parent().addClass('active');
            var view_type = $('#view_type').val();
            fetch_data(page, sort_type, column_name, query, view_type);
        });

    });
</script>

<script>
    $(document).on("click", ".lateApproveRequest", function() {
        var late_date = $(this).data("late_date");
        var intime = $(this).data("intime");
        $(".intime_modal").val(intime);
        $(".late_date_modal").val(late_date);
    });
    $(document).on("click", ".leaveAdjustment", function() {
        var present_date = $(this).data("present_date");
        $(".present_date_id").val(present_date);
    });

    $(document).on("click", ".manualAttendanceRequest", function() {
        var abasent_date = $(this).data("abasent_date");
        console.log(abasent_date);
        $(".absent_date").val(abasent_date);
        // $(".absent_date_1").css( "display", "none" );
    });


    $(document).on("click", ".open_general_info", function() {
        var employee_personal_email = $('#employee_personal_email').text();
        var employee_personal_mobile = $('#employee_personal_mobile').text();
        var employee_desk_phone = $('#employee_desk_phone').text();
        var employee_whats_app = $('#employee_whats_app').text();
        var employee_skype_no = $('#employee_skype_no').text();
        // alert(employee_desk_phone);
        $(".modal-body #personal_email").val(employee_personal_email);
        $(".modal-body #personal_mobile").val(employee_personal_mobile);
        $(".modal-body #desk_phone").val(employee_desk_phone);
        $(".modal-body #whats_app").val(employee_whats_app);
        $(".modal-body #skype_no").val(employee_skype_no);
    });

    $('#generalInfoForm').submit(function(event) {
        event.preventDefault();
        url = "<?php echo URL::to('/generalInfoSubmit'); ?>"
        $.ajax({
            type: 'get',
            url: url,
            data: $('form').serialize(),
            success: function() {
                alert("Your request is submitted!");

            }
        });
    });

    function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass('fa-plus fa-minus');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);

    $("#datepickerto").datepicker({
        ftodayBtn: "linked",
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy'
    }).on("changeDate", function(e) {
        // $('#loading_spinner').show();
        from_date = $('.from_date_alert').val();
        // var date = "03/05/2013";
        var from_date = from_date.split("/").reverse().join("-");

        to_date = $('.to_date_alert').val();
        var to_date = to_date.split("/").reverse().join("-");
        today = "<?php echo date('Y-m-d'); ?>";

        console.log(to_date);
        console.log(from_date);
        if (!from_date && to_date) {
            alert("Please select from date first!");
            $('.to_date_alert').val() = '';
            return false;
        }
        if (new Date(from_date) == new Date(to_date)) {
            alert('Select a date range!');
            $('.from_date_alert').val() = '';
            $('.to_date_alert').val() = '';
            return false;
        }

        if (from_date == to_date) {
            alert('Select a date range!');
            $('.from_date_alert').val() = '';
            $('.to_date_alert').val() = '';
            return false;
        }

        if (new Date(from_date) > new Date(to_date)) {
            alert('Invalid date range!');
            $('.from_date_alert').val() = '';
            $('.to_date_alert').val() = '';
            return false;
        }
        if (new Date(from_date) > new Date(today)) {
            alert('Invalid date range!');
            $('.to_date_alert').val() = '';
            $('.from_date_alert').val() = '';
            return false;
        }
        if (new Date(to_date) > new Date(today)) {
            alert('Invalid date range!');
            $('.to_date_alert').val() = '';
            $('.from_date_alert').val() = '';
            return false;
        }
        if (new Date(from_date) == new Date(to_date)) {
            alert('Invalid date range!');
            $('.to_date_alert').val() = '';
            $('.from_date_alert').val() = '';
            return false;
        }



        if (from_date && to_date) {
            document.getElementById("overlay").style.display = "flex";
            $('#formId').submit();
        }
    })

    $('.datepicker').datepicker({
        ftodayBtn: "linked",
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy'
    });




    $(document).ready(function() {
        $(".dropdown").hover(
            function() {
                $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideDown("400");
                $(this).toggleClass('open');
            },
            function() {
                $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideUp("400");
                $(this).toggleClass('open');
            }
        );
    });

    <?php if (session('password_change') == 0) { ?>
        $('#changePasswordModal').modal({
            backdrop: 'static',
            keyboard: false
        })
        $(window).on('load', function() {
            $('#changePasswordModal').modal('show');
        });
        $('#changePasswordModal').on('hidden.bs.modal', function() {
            location.reload();
        })
    <?php }  ?>
    setTimeout(function() {
        $('.anyMessage').fadeOut('slow');
    }, 5000); //
    $(document).ready(function() {
        // $('#pay_days').
        // alert();
        var pay_days = $("#pay_days").val();
        $('.pay_days_html').html(pay_days);

        var holiday_count = $("#holiday_count").val();
        $('.holiday_count_html').html(holiday_count);

        var leave_count = $("#leave_count").val();
        $('.leave_count_html').html(leave_count);

        var present_day_count = $("#present_day_count").val();
        // alert(present_day_count);
        $('.present_day_count_html').html(present_day_count);

        var late_day_count = $("#late_day_count").val();
        $('.late_day_count_html').html(late_day_count);

        var absent_day_count = $("#absent_day_count").val();
        $('.absent_day_count_html').html(absent_day_count);

        var late_times_count = $("#late_times_count").val();
        $('.late_times_count_html').html(late_times_count);

        var work_times_count = $("#work_times_count").val();
        $('.work_times_count_html').html(work_times_count);

    });

    $('#attendance_pagination').paginate({
        perPage: 11,
    });


    jQuery('.o_user_menu').on('click', function() {
        if (jQuery('.profile-setting').hasClass('show')) {
            $('.profile-setting').removeClass('show');
        } else {
            $('.profile-setting').addClass('show');
        }
    });
</script>

<script type="text/javascript">
    $('.dropdown-toggle').dropdown();
    /* present days graph*/

    var chartdata = {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>,
            // labels: month,
            datasets: [{
                label: '',
                backgroundColor: '#28a745',
                borderWidth: 1,
                data: <?php echo json_encode($data); ?>
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    }
    var ctx = document.getElementById('presentCanvas').getContext('2d');
    new Chart(ctx, chartdata);

    /* late days graph*/
    var latedaydata = {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>,
            // labels: month,
            datasets: [{
                label: '',
                backgroundColor: '#ffc107',
                borderWidth: 1,
                data: <?php echo json_encode($late_data); ?>
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    }
    var latedayctx = document.getElementById('lateCanvas').getContext('2d');
    new Chart(latedayctx, latedaydata);

    /* absent days graph*/
    var absentdaydata = {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>,
            // labels: month,
            datasets: [{
                label: '',
                backgroundColor: '#dc3545',
                borderWidth: 1,
                data: <?php echo json_encode($absent_data); ?>
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    }
    var absentdayctx = document.getElementById('absentCanvas').getContext('2d');
    new Chart(absentdayctx, absentdaydata);

    $(".dropdown").hover(
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, false).slideDown("400");
            $(this).toggleClass('open');
        },
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, false).slideUp("400");
            $(this).toggleClass('open');
        });

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    $("#mySelectResponsible").on('change', function() {
        var id = $(this).find('option:selected').val();
        var reponsibilities_hand_over_to = $(this).find('option:selected').text();
        $('#reponsibilities_hand_over_to').text(reponsibilities_hand_over_to);
        $.ajax({
            type: 'GET',
            url: "{{ url('/') }}/get_responsible_info/" + id,
            // data: {id: id},
            success: function(data) {
                console.log(data);
                $('#rsp_designation_name').text(data.designation_name);
                $('#rsp_sbu_name').text(data.sbu_name);
                $('#rsp_employee_mobile').val(data.employee_mobile);
            },
        });
    });

    $("#change_leave_to_date").on('change keyup paste', function() {
        var date1 = new Date($('#change_leave_from_date').val());
        var date2 = new Date($('#change_leave_to_date').val());

        // console.log(date1);
        if (date1 == 'Invalid Date') {
            alert('Please select from date first!');
            $('#change_leave_to_date').val('');
            return false;
        }
        const diffTime = Math.abs(date2 - date1);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        totalDayss = (+diffDays) + (+1);
        $('#totalDayss').text(totalDayss);
        var leave_type_id = $('#leave_type_id').find('option:selected').val();
        console.log(leave_type_id);
        var leave_available = <?php echo json_encode($leave_available); ?>;
        var leave_type_info = <?php echo json_encode($leave_type_info); ?>;
        // console.log(leave_available);
        // console.log(leave_type_info);
        _leave_type_info = leave_type_info.find(data => data.leave_type == leave_type_id);
        // _leave_type_info = leave_available.find(data => data.leave_type == leave_type_id);

        // console.log(_leave_type_info);

        if (_leave_type_info === undefined) {
            // alert(leave_type_info);
            alert('Please select leave type first!');
            $('#totalDayss').text('');
            $('#change_leave_from_date').val('');
            $('#change_leave_to_date').val('');
            $('#tremaining_days').text('');
            return false;
        }
        // alert(totalDayss);
        tleave_day_no = _leave_type_info.leave_day_no;
        leave_available = leave_available.find(data => data.leave_type == leave_type_id);
        // console.log(leave_available);
        remaining_days = leave_available.leave_remaining - totalDayss;


        if (remaining_days) {
            $('#leave_info_div').css('display', 'inline');
        } else {
            $('#leave_info_div').css('display', 'none');
        }

        var leave_type_text = $('#leave_type_id').find('option:selected').text();
        // alert(leave_type_text);
        $('#tleave_day_no').text(tleave_day_no);
        $('#tremaining_days').text(remaining_days);
        $('#leave_type_name_id').text(leave_type_text);

        var leave_form_date = $('#change_leave_from_date').val();
        var leave_to_date = $('#change_leave_to_date').val();
        // alert(leave_form_date);
        $('#from_date_leave').text(leave_form_date);
        $('#to_date_leave').text(leave_to_date);
        $('.totalDayss_no').text(totalDayss);

        if((remaining_days) > 0){
            // alert(leave_type_id);
            if((leave_type_id == 3) && (totalDayss > 3)){
                alert('Opps! '+leave_type_text+' leave not allowed more than 3 days !');
                $('#totalDayss').text('');
                $('#change_leave_from_date').val('');
                $('#change_leave_to_date').val('');
                $('#tremaining_days').text('');
                $('#totalDayss_no').text('');
            }else{
                remaining_days = leave_available.leave_remaining - totalDayss;
            }
        }else{
            alert('Opps! '+leave_type_text+' leave not available ' + totalDayss + ' Days');
            $('#totalDayss').text('');
            $('#change_leave_from_date').val('');
            $('#change_leave_to_date').val('');
            $('#tremaining_days').text('');
            $('#totalDayss_no').text('');
        }

    });


    $(document).ready(function() {
        $('#exampleDataTable').DataTable();
    });

    $(document).on("click", "#viewNoticeDetails", function() {
        var notice_title = $(this).data("notice_title");
        var notice_details = $(this).data("notice_details");


        $('.detailsNotice').css('display', 'inline');
        $("#notice_title").text(notice_title);
        $("#notice_details").html(notice_details);
        $('.detailsNotice').show();
        $('#allNotice').hide();
    });

    $(document).on("click", "#backToNlist", function() {
        $('.detailsNotice').css('display', 'none');
        $('.detailsNotice').hide();
        $('#allNotice').show();
    });


    $("#leave_application_submit").submit(function() {
        var formdata = $(this).serialize(); // here $(this) refere to the form its submitting
        $.ajax({
            type: 'POST',
            url: "{{ url('/') }}/leaveapplication_submit",
            data: formdata, // here $(this) refers to the ajax object not form
            success: function(data) {
                console.log(data);
                if (data.status == 1) {
                    alert('Succesfully Form Submitted!');
                    // var page = $(this).attr('href');
                    // $('#serviceList').load(page);
                    $("#leave_application_submit")[0].reset();
                    $('#select2-leave_type_id-container').text('--select--');
                    $('#select2-mySelectResponsible-container').text('--select--');
                    $('#applyLeave').modal('hide');

                    $('#serviceList').modal('hide');
                    document.getElementById("overlay").style.display = "flex";
                    location.reload();
                } else {
                    alert('Error occured!');
                    $("#leave_application_submit")[0].reset();
                    $('#select2-leave_type_id-container').text('--select--');
                    $('#select2-mySelectResponsible-container').text('--select--');
                    $('#applyLeave').modal('hide');
                    document.getElementById("overlay").style.display = "flex";
                    location.reload();
                }
            },
            error: function() {
                // alert('Error occured!');
                console.log('Error occured!');
            }
        });

    });

    $(".service_modal_open").on('click', function() {
        $('.lastServiceRecived').css('display', 'none');
        $(".service_select select").val("");
        $("input[id='row_id']").val("");
        $("#service_request_submit")[0].reset();
        $('.sendRequestBtn').css('display', 'inline');
        $('.updateRequestBtn').css('display', 'none');
        $('#send_leave_request').css('display', 'none');
        $('#update_leave_request').css('display', 'inline');
        // $('#serviceRequest').modal('hide');
        // $('#lateApproveRequest').modal('hide');
        $('#serviceList').modal('hide');
    });

    $(".serviceListModal").on('click', function() {
        // alert('hi');
        $('.lastServiceRecived').css('display', 'none');
        $('#send_leave_request').css('display', 'none');
        $('#update_leave_request').css('display', 'inline');
        $(".service_select select").val("");
        $("#service_request_submit")[0].reset();
        $('.backToServiceList').css('display', 'inline');
    });

    $("#service_request_submit").submit(function() {
        // event.preventDefault();
        var formdata = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: "{{ url('/') }}/sendServiceRequest",
            data: formdata, // here $(this) refers to the ajax object not form
            success: function(data) {
                console.log(data);
                $('#serviceList').modal('hide');
                $('#serviceRequest').modal('hide');
                alert('Succesfully Request Submitted!');
                document.getElementById("overlay").style.display = "flex";
                $("#service_request_submit")[0].reset();
                location.reload();
            },
            error: function() {
                console.log('Error occured!');
            }
        });
    });

    $("#manualAttendance_request_submit").submit(function(e) {
        var formdata = $(this).serialize(); // here $(this) refere to the form its submitting
        $.ajax({
            type: 'POST',
            url: "{{ url('/') }}/sendManualAttendanceRequest",
            data: formdata, // here $(this) refers to the ajax object not form
            success: function(data) {
                alert('Succesfully Request Submitted!');
                $("#manualAttendance_request_submit")[0].reset();
                $('#manualAttendanceRequest').modal('hide');
                $('#serviceList').modal('hide');
                document.getElementById("overlay").style.display = "flex";
                location.reload();
            },
            error: function() {
                // alert('Error occured!');
                console.log('Error occured!');
            }
        });
    });
    $("#onSelectType").on('change', function() {
        var type_id = $(this).find('option:selected').val();
        var type_text = $(this).find('option:selected').text();
        console.log([type_id, type_text]);
        // $.ajax({
        //     type: 'GET',
        //     url: "{{ url('/') }}/find_category_type/" + id,
        //     success: function(data) {
        //         console.log(data);
        //     },
        // });
    });
    $("#service_type_id").on('change', function() {
        // console.log('fff');
        var id = $(this).find('option:selected').val();
        if (id == 4) {
            $('#serviceRequest').modal('hide');
            $('.backToServiceListdiv').css('display', 'inline');
            $('.backToServiceCalendar').css('display', 'none');
            $('#manualAttendanceRequest').modal('toggle');
        }
        if(id == 7) {
            $('#serviceRequest').modal('hide');
            $('.backToServiceListdiv').css('display', 'inline');
            $('.backToServiceCalendar').css('display', 'none');
            $('#generalStationeryRequest').modal('toggle');
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/find_type_category_product/" + id,
                // data: {id: id},
                success: function(data) {
                    console.log(data);
                    let product_type = data.product_type;
                    let product_category = data.product_category;
                    let inventory_product = data.inventory_product;
                    $('#product_type_list').empty();
                    $("#product_type_list").append("<option value='' selected>--Select--</option>");
                    for (var i = 0; i < product_type.length; i++) {
                        $("#product_type_list").append("<option id='onSelectType' class='text-left' value='"+ product_type[i].id +"'>" + product_type[i].catgory_name + "</option>");
                    }
                    $('#product_category_list').empty();
                    $("#product_category_list").append("<option value='' selected>--Select--</option>");
                    for (var i = 0; i < product_category.length; i++) {
                        $("#product_category_list").append("<option class='text-left' value='"+ product_category[i].id +"'>" + product_category[i].category_name + "</option>");
                    }
                    $('#product_item_list').empty();
                    $("#product_item_list").append("<option value='' selected>--Select--</option>");
                    for (var i = 0; i < inventory_product.length; i++) {
                        $("#product_item_list").append("<option data-unit_name='"+inventory_product[i].unit_name+"' data-branch_id='"+inventory_product[i].branch_id+"' data-project_id='"+inventory_product[i].project_id+"' data-id='"+inventory_product[i].last_costs+"' class='text-left' value='"+ inventory_product[i].id +"'>" + inventory_product[i].inv_product_name + "</option>");
                    }
                    // alert(data.last_receiving_date);
                },
            });
        }
        if (id == '') {
            $('.lastServiceRecived').css('display', 'none');
        }
        $.ajax({
            type: 'GET',
            url: "{{ url('/') }}/get_last_service_info/" + id,
            // data: {id: id},
            success: function(data) {
                // alert(data.last_receiving_date);
                $('.lastServiceRecived').css('display', 'inline');

                if (data.service_date) {
                    $('#last_receiving_date').text(data.service_date);
                } else {
                    $('#last_receiving_date').text('No Data Found!');
                }
                if (data.service_purpose) {
                    $('#last_purposes').text(data.service_purpose);
                } else {
                    $('#last_purposes').text('No Data Found!');
                }
            },
        });
    });

    $("#product_category_list").on('change', function() {
        var type_id = $(this).find('option:selected').val();
        var type_text = $(this).find('option:selected').text();
        console.log([type_id, type_text]);
        $.ajax({
            type: 'GET',
            url: "{{ url('/') }}/find_pcategory_product_list/" + type_id,
            success: function(data) {
                // alert(data.last_receiving_date);
                console.log(data);
                let inventory_product = data.inventory_product;
                $('#product_item_list').empty();
                $("#product_item_list").append("<option value='' selected>--Select--</option>");
                for (var i = 0; i < inventory_product.length; i++) {
                    $("#product_item_list").append("<option data-unit_name='"+inventory_product[i].unit_name+"' data-branch_id='"+inventory_product[i].branch_id+"' data-project_id='"+inventory_product[i].project_id+"' data-id='"+inventory_product[i].last_costs+"' class='text-left' value='"+ inventory_product[i].id +"'>" + inventory_product[i].inv_product_name + "</option>");
                }
            },
        });
    });

    $("#product_item_list").on('change', function() {
        // var type_id = $(this).find('option:selected').val();
        // var type_text = $(this).find('option:selected').text();
        var unit_name = $("#product_item_list").find('option:selected').data('unit_name');
        $("#product_unit_name").text(unit_name);
        // console.log([type_id, type_text]);

    });


    var counter = 0;
    $("#add_product_data").on('click', function() {
        var type_id = $("#product_type_list").find('option:selected').val();
        var type_text = $("#product_type_list").find('option:selected').text();
        if(type_id){
            type_id = type_id;
            type_text = type_text;
        }else{
            type_id = '';
            type_text = '';
        }
        var category_id = $("#product_category_list").find('option:selected').val();
        var category_text = $("#product_category_list").find('option:selected').text();
        var item_id = $("#product_item_list").find('option:selected').val();
        var item_text = $("#product_item_list").find('option:selected').text();
        var item_price = $("#product_item_list").find('option:selected').data('id');
        // var uom = $("#product_item_list").find('option:selected').data('id');
        var project_id = $("#product_item_list").find('option:selected').data('project_id');
        var unit_name = $("#product_item_list").find('option:selected').data('unit_name');
        var product_qty = $("#product_qty").val();
        counter++;
        $(".stationary_list").append(
            "<tr role='row' class='odd'>"
                +"<input name='product_type[]' value='"+type_id+"' type='hidden'>"
                +"<input name='product_category[]' value='"+category_id+"' type='hidden'>"
                +"<input name='product_item[]' value='"+item_id+"' type='hidden'>"
                +"<input name='product_qty[]' value='"+product_qty+"' type='hidden'>"
                +"<input name='product_price[]' value='"+item_price+"' type='hidden'>"
                +"<input name='project_id' value='"+project_id+"' type='hidden'>"

                +"<td class='text-left sorting_1'>"+counter+"</td>"
                +"<td class='text-left'>"+type_text+"</td>"
                +"<td class='text-left'>"+category_text+"</td>"
                +"<td class='text-left'>"+item_text+"</td>"
                +"<td class='text-center'>"+product_qty+"</td>"
                +"<td class='text-center'>"+unit_name+"</td>"
                +"<td class='text-center' id='remove_product_data'><a class='btn btn-sm btn-danger' onclick='newtest2(this)'><i class='fa fa-times'></i></a></td>"
            +"</tr>"
        );
    });

    $("#generalStationeryRequest_submit").submit(function(e) {
        e.preventDefault();
        var formdata = $(this).serialize(); // here $(this) refere to the form its submitting
        // console.log(formdata);
        // document.getElementById("overlay").style.display = "flex";
        $.ajax({
            type: 'POST',
            url: "{{ url('/') }}/send_general_stationery_request",
            data: formdata, // here $(this) refers to the ajax object not form
            success: function(data) {
                // console.log(data);
                alert('Succesfully Request Submitted!');
                $("#generalStationeryRequest_submit")[0].reset();
                $('#generalStationeryRequest').modal('hide');
                $('#serviceList').modal('hide');
                document.getElementById("overlay").style.display = "flex";
                location.reload();
                document.getElementById("overlay").style.display = "none";
            },
            error: function() {
                // alert('Error occured!');
                console.log('Error occured!');
            }
        });
    });
    $("#remove_product_data").on('click', function() {
        alert('sdsf');
        $(this).closest("tr").remove();
    });

    function newtest2(elem) {
        $(elem).closest('tr').remove();
    }


    $("#late_request_submit").submit(function() {
        var formdata = $(this).serialize(); // here $(this) refere to the form its submitting
        $.ajax({
            type: 'POST',
            url: "{{ url('/') }}/lateRequestSend",
            data: formdata, // here $(this) refers to the ajax object not form
            success: function(data) {
                alert('Succesfully Request Submitted!');
                $("#late_request_submit")[0].reset();
                $('#lateApproveRequest').modal('hide');
                $('#serviceList').modal('hide');
                document.getElementById("overlay").style.display = "flex";
                location.reload();
            },
            error: function() {
                // alert('Error occured!');
                console.log('Error occured!');
            }
        });
        // stay.preventDefault();
    });

    // $("#leave_adjustment_submit").submit(function() {
    //     var formdata = $(this).serialize(); // here $(this) refere to the form its submitting
    //     $.ajax({
    //         type: 'POST',
    //         url: "{{ url('/') }}/leaveAdjustmentSend",
    //         data: formdata, // here $(this) refers to the ajax object not form
    //         success: function(data) {
    //             console.log(data);
    //             alert('Succesfully Request Submitted!');
    //             $("#leave_adjustment_submit")[0].reset();
    //             $('#leaveAdjustment').modal('hide');
    //             // $('#serviceList').modal('hide');
    //             // document.getElementById("overlay").style.display = "flex";
    //             // location.reload();
    //         },
    //         error: function() {
    //             console.log('Error occured!');
    //         }
    //     });
    // });

    $("#leave_adjustment_submit").submit(function() {
        // alert('ok');
        event.preventDefault();
        var formdata = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: "{{ url('/') }}/leaveAdjustmentSend",
            data: formdata, // here $(this) refers to the ajax object not form
            success: function(data) {
                console.log(data);
                alert('Succesfully Request Submitted!');
                $("#leave_adjustment_submit")[0].reset();
                $('#leaveAdjustment').modal('hide');
                // $('#serviceList').modal('hide');
                // document.getElementById("overlay").style.display = "flex";
                // location.reload();
            },
            error: function() {
                console.log('Error occured!');
            }
        });
    });

    $(document).ready(function() {
        $(".profile_img_upload").hover(function() {
            // $(this).css("background-color", "yellow");
            $('.profile_file_img').css('display', 'inline');
        }, function() {
            // $(this).css("background-color", "pink");
            $('.profile_file_img').css('display', 'none');
        });
    });
    $(document).ready(function() {
        $(".profile_file_img").hover(function() {
            // $(this).css("background-color", "yellow");
            $('.profile_file_img').css('display', 'inline');
        }, function() {
            // $(this).css("background-color", "pink");
            $('.profile_file_img').css('display', 'none');
        });
    });



    $(".backToServiceList").on('click', function() {
        $('#serviceList').modal('show');
        $('#serviceRequest').modal('hide');
        $('#lateApproveRequest').modal('hide');
        $('#applyLeave').modal('hide');
        $('#manualAttendanceRequest').modal('hide');
        $('#generalStationeryRequest').modal('hide');
    });

    $(".backToServiceCalendar").on('click', function() {
        $('#modal_form_addappt').modal('show');
        $('#serviceRequest').modal('hide');
        $('#lateApproveRequest').modal('hide');
        $('#applyLeave').modal('hide');
        $('#manualAttendanceRequest').modal('hide');
        $('#generalStationeryRequest').modal('hide');
    });

    $(".add_new_service_modal").on('click', function() {
        $("#service_request_submit")[0].reset();
        $("#manualAttendance_request_submit")[0].reset();
        $('.backToServiceListdiv').css('display', 'inline');
        $('.sendRequestBtn').css('display', 'inline');
        $('.backToServiceCalendar').css('display', 'none');
        $('.updateRequestBtn').css('display', 'none');
        $('#serviceList').modal('hide');
    });
    $('#ServiceListAppend').on('click', '.serviceListModal', function() {
        var row_id = $(this).data('row_id');
        var row_type = $(this).data('row_type');
        var employee_id = $(this).data('employee_id');

        if (row_type == 1) {
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/findServiceRequestData/" + row_id,
                success: function(data) {
                    // console.log(data);
                    $("select[name='service_type']").val(data.service_type).prop('selected', true);
                    $("input[id='row_id']").val(row_id);
                    $("input[name='service_date_from']").val(data.service_date_from);
                    $("input[name='service_date_to']").val(data.service_date_to);
                    $("textarea[name='service_purpose']").val(data.service_purpose);
                    $('.backToServiceListdiv').css('display', 'inline');
                    $('.sendRequestBtn').css('display', 'none');
                    $('.updateRequestBtn').css('display', 'inline');
                    $('#send_leave_request').css('display', 'none');
                    $('#update_leave_request').css('display', 'inline');
                    $('#serviceList').modal('hide');
                    $('#serviceRequest').modal('show');
                },
                error: function() {
                    // alert('Error occured!');
                    console.log('Error occured!');
                }
            });
        } else if (row_type == 2) {
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/findLateRequestData/" + row_id,
                success: function(data) {
                    $("input[id='row_id']").val(row_id);
                    $("input[name='in_time']").val(data.in_time);
                    $("input[name='actual_in_time']").val(data.actual_in_time);
                    $("textarea[name='late_reason']").val(data.late_reason);
                    $("input[name='late_date']").val(data.late_date);
                    $('.backToServiceListdiv').css('display', 'inline');
                    $('.sendRequestBtn').css('display', 'none');
                    $('.updateRequestBtn').css('display', 'inline');
                    $('#serviceList').modal('hide');
                    $('#lateApproveRequest').modal('show');
                },
                error: function() {
                    console.log('Error occured!');
                }
            });
        } else if (row_type == 3) {
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/findLeaveRequestData/" + row_id,
                success: function(data) {
                    console.log(data.leave_type);
                    $("input[id='row_id']").val(row_id);
                    $('#leave_type_id').val(data.leave_type);
                    $('#leave_type_id').select2().trigger('change');
                    $("select[name='leave_reliever']").val(data.reliever_name).prop('selected', true);
                    $("input[name='leave_from_date']").val(data.leave_from_date);
                    $("input[name='leave_to_date']").val(data.leave_to_date);
                    $("textarea[name='leave_reason']").val(data.leave_reason);
                    $("textarea[name='address_leave']").val(data.address_leave);
                    $('#mySelectResponsible').val(data.reliever_id);
                    $('#mySelectResponsible').select2().trigger('change');
                    $("input[name='leave_reliever_contact']").val(data.leave_reliever_contact);
                    $('.backToServiceListdiv').css('display', 'inline');
                    $('#serviceList').modal('hide');
                    $('#applyLeave').modal('toggle');
                },
                error: function() {
                    // alert('Error occured!');
                    console.log('Error occured!');
                }
            });
        } else if (row_type == 4) {
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/findManualAttendanceData/" + row_id,
                success: function(data) {
                    $("input[id='row_id']").val(row_id);
                    $("select[name='manual_attendance_issues']").val(data.manual_attendance_issues).prop('selected', true);
                    $("input[name='manual_attendance_date']").val(data.manual_attendance_date);
                    $("input[name='manual_start_time']").val(data.manual_start_time);
                    $("input[name='manual_end_time']").val(data.manual_end_time);
                    $("textarea[name='manual_remarks']").val(data.manual_remarks);
                    $('.backToServiceListdiv').css('display', 'inline');
                    $('.sendRequestBtn').css('display', 'none');
                    $('.updateRequestBtn').css('display', 'inline');
                    $('#serviceList').modal('hide');
                    $('#manualAttendanceRequest').modal('show');
                    $('#generalStationeryRequest').modal('show');
                },
                error: function() {
                    // alert('Error occured!');
                    console.log('Error occured!');
                }
            });
        } else if (row_type == 7) {
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/findGeneralStaioneryData/" + row_id,
                success: function(data) {
                    let list_data = data.stationery_summary;
                    console.log(data[0].stationary_remarks);
                    $("input[id='row_id']").val(row_id);
                    let product_type = data.product_type;
                    let product_category = data.product_category;
                    let inventory_product = data.inventory_product;
                    $('#product_type_list').empty();
                    $("#product_type_list").append("<option value='' selected>--Select--</option>");
                    for (var i = 0; i < product_type.length; i++) {
                        $("#product_type_list").append("<option id='onSelectType' class='text-left' value='"+ product_type[i].id +"'>" + product_type[i].catgory_name + "</option>");
                    }
                    $('#product_category_list').empty();
                    $("#product_category_list").append("<option value='' selected>--Select--</option>");
                    for (var i = 0; i < product_category.length; i++) {
                        $("#product_category_list").append("<option class='text-left' value='"+ product_category[i].id +"'>" + product_category[i].category_name + "</option>");
                    }
                    $('#product_item_list').empty();
                    $("#product_item_list").append("<option value='' selected>--Select--</option>");
                    for (var i = 0; i < inventory_product.length; i++) {
                        $("#product_item_list").append("<option data-branch_id='"+inventory_product[i].branch_id+"' data-project_id='"+inventory_product[i].project_id+"' data-id='"+inventory_product[i].last_costs+"' class='text-left' value='"+ inventory_product[i].id +"'>" + inventory_product[i].inv_product_name + "</option>");
                    }
                    $(".stationary_remarks").val(data[0].stationary_remarks);
                    $(".stationery_no").val(data[0].stationery_no);

                    $('.stationary_list').empty();
                    // var counter = 0;
                    for (var m = 0; m < list_data.length; m++) {
                        var stationery_id = list_data[m].id;
                        var category_id = list_data[m].category_id;
                        var category_text = list_data[m].category_text;
                        var type_id = list_data[m].type_id;
                        var type_text = list_data[m].type_text;
                        var item_id = list_data[m].product_id;
                        var item_text = list_data[m].item_text;
                        var item_price = list_data[m].qty_unit_price;
                        var project_id = list_data[m].project_id;
                        var branch_id = list_data[m].branch_id;
                        var product_qty = list_data[m].requestion_qty;
                        var unit_name = list_data[m].unit_name;
                        counter++;
                        $(".stationary_list").append(
                            "<tr role='row' class='odd'>"
                                +"<input name='product_type[]' value='"+data[0].stationery_no+"' type='hidden'>"
                                +"<input name='product_type[]' value='"+stationery_id+"' type='hidden'>"
                                +"<input name='product_type[]' value='"+type_id+"' type='hidden'>"
                                +"<input name='product_category[]' value='"+category_id+"' type='hidden'>"
                                +"<input name='product_item[]' value='"+item_id+"' type='hidden'>"
                                +"<input name='product_qty[]' value='"+product_qty+"' type='hidden'>"
                                +"<input name='product_price[]' value='"+item_price+"' type='hidden'>"
                                +"<input name='project_id' value='"+project_id+"' type='hidden'>"

                                +"<td class='text-left sorting_1'>"+counter+"</td>"
                                +"<td class='text-left'>"+type_text+"</td>"
                                +"<td class='text-left'>"+category_text+"</td>"
                                +"<td class='text-left'>"+item_text+"</td>"
                                +"<td class='text-center'>"+product_qty+"</td>"
                                +"<td class='text-center'>"+unit_name+"</td>"
                                +"<td class='text-center' id='remove_product_data'><a class='btn btn-sm btn-danger' onclick='newtest2(this)'><i class='fa fa-times'></i></a></td>"
                            +"</tr>"
                        );


                    }
                    // var type_id = $("#product_type_list").find('option:selected').val();
                    // var type_text = $("#stationary_remarks").find('option:selected').text();
                    // if(type_id){
                    //     type_id = type_id;
                    //     type_text = type_text;
                    // }else{
                    //     type_id = '';
                    //     type_text = '';
                    // }
                    // var category_id = $("#product_category_list").find('option:selected').val();
                    // var category_text = $("#product_category_list").find('option:selected').text();
                    // var item_id = $("#product_item_list").find('option:selected').val();
                    // var item_text = $("#product_item_list").find('option:selected').text();
                    // var item_price = $("#product_item_list").find('option:selected').data('id');
                    // var project_id = $("#product_item_list").find('option:selected').data('project_id');
                    // var product_qty = $("#product_qty").val();


















                    $('.backToServiceListdiv').css('display', 'inline');
                    $('.sendRequestBtn').css('display', 'none');
                    $('.updateRequestBtn').css('display', 'inline');
                    $('#serviceList').modal('hide');
                    $('#generalStationeryRequest').modal('show');
                },
                error: function() {
                    console.log('Error occured!');
                }
            });
        } else {
            $('#applyLeave').modal('toggle');
        }
    });

    $(document).ready(function() {
        $('#ServiceListAppend').on('click', '.singleServiceDelete', function(ev) {
            console.log(row_type);
            var row_id = $(this).data('row_id');
            var row_type = $(this).data('row_type');
            var employee_id = $(this).data('employee_id');
            if (row_type == 1) {
                if (confirm("Are you sure want to delete?")) {
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('/') }}/serviceDestroy/" + row_id,
                        success: function(data) {
                            alert('Your data is successfully deleted!');
                            $('#serviceList').modal('toggle');
                            document.getElementById("overlay").style.display = "flex";
                            location.reload();
                            $('#serviceList').modal('show');
                        },
                        error: function() {
                            console.log('Error occured!');
                        }
                    });
                }
                return false;
            } else if (row_type == 2) {
                if (confirm("Are you sure want to delete?")) {
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('/') }}/lateRequestDestroy/" + row_id,
                        success: function(data) {
                            alert('Your data is successfully deleted!');
                            $('#serviceList').modal('toggle');
                            document.getElementById("overlay").style.display = "flex";
                            location.reload();
                            $('#serviceList').modal('show');
                        },
                        error: function() {
                            // alert('Error occured!');
                            console.log('Error occured!');
                        }
                    });
                }
                return false;
            } else if (row_type == 3) {
                if (confirm("Are you sure want to delete?")) {
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('/') }}/leaveRequestDestroy/" + row_id,
                        success: function(data) {
                            alert('Your data is successfully deleted!');
                            $('#serviceList').modal('toggle');
                            document.getElementById("overlay").style.display = "flex";
                            location.reload();
                            $('#serviceList').modal('show');
                        },
                        error: function() {
                            // alert('Error occured!');
                            console.log('Error occured!');
                        }
                    });
                }
                return false;
            } else if (row_type == 4) {
                if (confirm("Are you sure want to delete?")) {
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('/') }}/manualAttendanceDestroy/" + row_id,
                        success: function(data) {
                            alert('Your data is successfully deleted!');
                            $('#serviceList').modal('toggle');
                            document.getElementById("overlay").style.display = "flex";
                            // $('#serviceList').modal('toggle');
                            // var page = $(this).attr('href');
                            // $('#serviceList').load(page);
                            location.reload();
                        },
                        error: function() {
                            console.log('Error occured!');
                        }
                    });
                }
                return false;
            }else if (row_type == 7) {
                if (confirm("Are you sure want to delete?")) {
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('/') }}/generalStaioneryData/" + row_id,
                        success: function(data) {
                            alert('Your data is successfully deleted!');
                            $('#serviceList').modal('toggle');
                            document.getElementById("overlay").style.display = "flex";
                            location.reload();
                        },
                        error: function() {
                            console.log('Error occured!');
                        }
                    });
                }
                return false;
            }
             else {
                alert('No data found!');
            }
        });
    });

    $(document).ready(function() {
        $('#ServiceListAppend').on('click', '.singleServiceCancel', function(ev) {
            console.log(row_id);
            var row_id = $(this).data('row_id');
            var row_type = $(this).data('row_type');
            var employee_id = $(this).data('employee_id');
            // if (row_type == 1) {
            if (confirm("Are you sure want to cancel request?")) {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('/') }}/serviceCancel/" + row_id,
                    success: function(data) {
                        alert('Your request successfully sent!');
                        $('#serviceList').modal('toggle');
                        document.getElementById("overlay").style.display = "flex";
                        location.reload();
                        $('#serviceList').modal('show');
                    },
                    error: function() {
                        console.log('Error occured!');
                    }
                });
            }
            return false;
            // }
        });
    });

    $(".closeServiceList").on('click', function() {
        // $(".modal-body").html("");

        // $('#serviceList').reset();
    });

    // $("#service_list_modal_open").on('click', function() {
    $(document).ready(function() {

       

        // $("#clickBtnEmailPrint").click(function() {
        //     var cssss = '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" media="screen, print" />';
        //     w = window.open(null, 'Print_Page', 'scrollbars=yes');
        //     w.document.write(cssss);
        //     w.document.write(cssss + jQuery('#emailListPrint').html());
        //     w.document.close();
        //     w.print();
        //     // setTimeout(w.print(), 1);
        // });

        $("#clickBtnLFPrint").click(function() {
            $("printTable").each(function () {
        this.style.setProperty("border", "1px solid rgb(52, 58, 64);", "important");
        // this.style.setProperty("text-align", "justify", "important");
        // this.style.setProperty("font-size", "1.75rem", "important");
      });
      $("td").each(function () {
        this.style.setProperty("border", "1px solid rgb(52, 58, 64);", "important");
      });
      $("table").each(function () {
        this.style.setProperty("border", "1px solid rgb(52, 58, 64);", "important");
      });
      $("th").each(function () {
        this.style.setProperty("border", "1px solid rgb(52, 58, 64);", "important");
      });
      let contents = document.getElementById("LFListPrint").innerHTML;

      let frame1 = document.createElement("iframe");
      frame1.name = "frame1";
      frame1.style.position = "absolute";
      frame1.style.top = "-1000000px";
      document.body.appendChild(frame1);
      let frameDoc = frame1.contentWindow
        ? frame1.contentWindow
        : frame1.contentDocument.document
        ? frame1.contentDocument.document
        : frame1.contentDocument;
      frameDoc.document.open();
      frameDoc.document.write(
        '<html lang="en"><head><title>Gemcon Group</title>'
      );
      frameDoc.document.write(
        '<link href="https://cdn.rawgit.com/sh4hids/bangla-web-fonts/bangla/stylesheet.css" rel="stylesheet">',
        '<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.0.0-alpha/fullcalendar.print.min.css"/>'
      );
      frameDoc.document.write("</head><body>");
      frameDoc.document.write(contents);
      frameDoc.document.write("</body></html>");
      frameDoc.document.close();
      setTimeout(function () {
        window.frames["frame1"].focus();
        window.frames["frame1"].print();
        document.body.removeChild(frame1);
      }, 500);
      return false;
            // this.style.setProperty("td", ".4rem", "important");
            // this.style.setProperty("text-align", "justify", "important");
            // var cssss = '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" media="screen, print" />';
            // w = window.open(null, 'Print_Page', 'scrollbars=yes');
            // w.document.write(cssss);

            // w.document.write(cssss + jQuery('#LFListPrint').html());
            // w.document.close();
            // w.print();
            // setTimeout(w.print(), 1);
        });

        $(document).ready(function() {
            $("#service_list_modal_open").on('click', function() {
                $('#send_leave_request').css('display', 'none');
                $('#update_leave_request').css('display', 'inline');
                employee_id = "<?php echo Auth::guard('user')->user()->employee_id; ?>";
                $.ajax({
                    type: 'GET',
                    url: "{{ url('/') }}/get_service_list_info/" + employee_id,
                    success: function(data) {
                        console.log(data);
                        $("#ServiceListAppend").find("tr:gt(0)").remove();
                        $('#ServiceListAppend').empty();
                        var requested_info = 0;
                        var approved_info = 0;
                        var cancel_request = '';
                        for (var i = 0; i < data.serviceList.length; i++) {
                            console.log(data.serviceList[i]);
                            j = i + 1;
                            if (data.serviceList[i].status == 1) {
                                requested_info++;
                                status = 'Requested';
                            } else if (data.serviceList[i].status == 2) {
                                approved_info++;
                                status = 'Approve';
                            } else if (data.serviceList[i].status == 3) {
                                status = 'Forwarded';
                            } else if (data.serviceList[i].status == 4) {
                                status = 'Rejected';
                            } else if (data.serviceList[i].status == 6) {
                                status = 'Approve';
                                cancel_request = ' <br> Cancel Request';
                            } else {
                                status = '';
                                cancel_request = '';
                            }

                            if(status == 'Approve' && data.serviceList[i].type_id == 3 && data.serviceList[i].status != 6){
                                cancel_design = '<a data-employee_id="' + employee_id + '" data-row_id="' + data.serviceList[i].id + '" data-row_type="' + data.serviceList[i].type_id + '" id="singleServiceCancel' + j + '" class="singleServiceCancel" href="#" title="Cancel Request" ><i class="fa fa-send-o"></i>  </a> ||';
                                status_cancel = status;
                            }else{
                                cancel_design = '';
                                status_cancel = status + cancel_request;
                            }

                            if (status != 'Approve') {
                                $('#ServiceListAppend').append(
                                    '<tr>' +
                                    '<td class="text-center">' + j + '</td>' +
                                    '<td class="text-center">' + data.serviceList[i].date + '</td>' +
                                    '<td class="text-left">' + data.serviceList[i].Type + '</td>' +
                                    '<td class="text-left">' + data.serviceList[i].purpose + '</td>' +
                                    '<td class="text-center">' + status + '</td>' +
                                    '<td class="text-center" style="width:10%;">' +
                                    '<a data-employee_id="' + employee_id + '" data-row_id="' + data.serviceList[i].id + '" data-row_type="' + data.serviceList[i].type_id + '" id="serviceListModal' + j + '" class="serviceListModal" href="#"><i class="fa fa-pencil "></i>  </a>' +
                                    '|| <a data-employee_id="' + employee_id + '" data-row_id="' + data.serviceList[i].id + '" data-row_type="' + data.serviceList[i].type_id + '" id="singleServiceDelete' + j + '" class="singleServiceDelete" href="#"><i class="fa fa-trash"></i>  </a>' +
                                    '</td>' +
                                    '</tr>'
                                );
                            } else if (status == 'Approve' && data.serviceList[i].type_id == 3){
                                $('#ServiceListAppend').append(
                                    '<tr>' +
                                    '<td class="text-center">' + j + '</td>' +
                                    '<td class="text-center">' + data.serviceList[i].date + '</td>' +
                                    '<td class="text-left">' + data.serviceList[i].Type + '</td>' +
                                    '<td class="text-left">' + data.serviceList[i].purpose + '</td>' +
                                    '<td class="text-center">' + status_cancel + '</td>' +
                                    '<td class="text-center" style="width:10%;">' +
                                    cancel_design +
                                    ' <a style="opacity:0.5"  title="Already Task Completed!" href="#"><i class="fa fa-pencil "></i>  </a>' +
                                    '|| <a style="opacity:0.5" title="Already Task Completed!"  href="#"><i class="fa fa-trash"></i>  </a>' +
                                    '</td>' +
                                    '</tr>'
                                );
                            }
                            else {
                                $('#ServiceListAppend').append(
                                    '<tr>' +
                                    '<td class="text-center">' + j + '</td>' +
                                    '<td class="text-center">' + data.serviceList[i].date + '</td>' +
                                    '<td class="text-left">' + data.serviceList[i].Type + '</td>' +
                                    '<td class="text-left">' + data.serviceList[i].purpose + '</td>' +
                                    '<td class="text-center">' + status + '</td>' +
                                    '<td class="text-center" style="width:10%;">' +

                                    '<a style="opacity:0.5"  title="Already Task Completed!" href="#"><i class="fa fa-pencil "></i>  </a>' +
                                    '|| <a style="opacity:0.5" title="Already Task Completed!"  href="#"><i class="fa fa-trash"></i>  </a>' +
                                    '</td>' +
                                    '</tr>'
                                );
                            }
                        }
                        // console.log(append_data);
                        // var pending_info = requested_info-approved_info_id;
                        var requested_infoo = requested_info + approved_info;
                        $('#requested_info_id').text(requested_infoo);
                        $('#approved_info_id').text(approved_info);
                        $('#pending_info_id').text(requested_info);
                        $('.serviceListTable').dataTable({
                            "destroy": true,
                            "pageLength": 5,
                            "bLengthChange": false,
                            "bFilter": true,
                            "bInfo": false,
                            "bAutoWidth": false
                        });
                        $('#serviceList').modal('show');
                    },
                    error: function() {
                        console.log('Error occured!');
                    }
                });
            });
        });
      
        $('#salaryListTable').dataTable({
            "destroy": true,
            "pageLength": 5,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false
        });
        $('#providentFundListTable').dataTable({
            "destroy": true,
            "pageLength": 5,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false
        });
        $('#loanListTable').dataTable({
            "destroy": true,
            "pageLength": 5,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false
        });
        $(document).on('click', '.pay_slip_modal', function() {
            var payroll_id = $(this).data("payroll_id");
            var employee_id = $(this).data("employee_id");
            $("#Pf_id").text('');
            $("#clPf_id").text('');
            $("#openigPf_id").text('');
            $("#print_date_id").text('');
            $("#salary_date_id").text('');
            $("#sbu_logo_id").text('');
            $("#sbu_name_id").text('');
            $("#salary_type_id").text('');
            $("#employee_fullname_id").text('');
            $("#employee_id_no_id").text('');
            $("#designation_name_id").text('');
            $("#department_name_id").text('');
            $("#work_location_name_id").text('');
            $("#gross_salary_id").text('');
            $("#arear_id").text('');
            $("#total_additions_id").text('');
            $("#deduction_pfbasic_id").text('');
            $("#deduction_tax_id").text('');
            $("#total_deduction_id").text('');
            $("#netpay_id").text('');
            $("#gross_salary_id_cash").text('');
            $("#deduction_pfbasic_id_cash").text('');
            $("#car_allowance_id_cash").text('');
            $("#netpay_id_cash").text('');
            $("#salary_type_id_cash").text('');
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/pay_slip_info/" + payroll_id + '/' + employee_id,
                success: function(data) {
                    console.log(data);
                    $('#sbu_logo').attr('src', 'company_logo/' + data.sbu_logo);
                    $("#Pf_id").text(formatToCurrency(data.Pf));
                    $("#clPf_id").text(formatToCurrency(data.clPf));
                    $("#openigPf_id").text(formatToCurrency(data.openigPf));
                    $("#closingPf_id").text(formatToCurrency(data.openigPf + data.Pf + data.clPf));
                    $("#print_date_id").text(data.print_date);
                    $("#salary_date_id").text(data.salary_date);
                    $("#sbu_logo_id").text(data.sbu_logo);
                    $("#sbu_name_id").text(data.sbu_name);
                    $("#salary_type_id").text(data.salary_type_cash);
                    $("#employee_fullname_id").text(data.pay_slip_details.employee_fullname);
                    $("#employee_id_no_id").text(data.pay_slip_details.employee_id_no);
                    $("#designation_name_id").text(data.pay_slip_details.designation_name);
                    $("#department_name_id").text(data.pay_slip_details.department_name);
                    $("#work_location_name_id").text(data.pay_slip_details.work_location_name);

                    // formatToCurrency(12.34546);
                    $("#gross_salary_id").text(formatToCurrency(data.paySlipDetails.gross_salary));
                    $("#arear_id").text(formatToCurrency(data.paySlipDetails.arear));
                    $("#total_additions_id").text(formatToCurrency(data.paySlipDetails.total_additions));
                    $("#deduction_pfbasic_id").text(formatToCurrency(data.paySlipDetails.deduction_pfbasic));
                    $("#deduction_tax_id").text(formatToCurrency(data.paySlipDetails.deduction_tax));
                    $("#total_deduction_id").text(formatToCurrency(data.paySlipDetails.total_deduction));
                    $("#netpay_id").text(formatToCurrency(data.paySlipDetails.netpay));

                    $("#gross_salary_id_cash").text(formatToCurrency(data.paySlipCash.gross_salary));
                    $("#deduction_pfbasic_id_cash").text(formatToCurrency(data.paySlipCash.deduction_pfbasic));
                    $("#car_allowance_id_cash").text(formatToCurrency(data.paySlipCash.car_allowance));
                    $("#netpay_id_cash").text(formatToCurrency(data.paySlipCash.netpay));

                    $("#salary_type_id_cash").text(data.salary_type_cash);
                    if (data.salary_type_cash == 1) {
                        $('#salary_type_hide_show').css('display', 'inline-block');
                        $('#salary_type_hide_show').css('display', 'table');
                        $('#salary_type_hide_show').css('width', ' 100%');
                    }
                    if (data.salary_type_cash == 1 && data.salary_type_bank == 1) {
                        $('.bank_salary_section').css('display', 'none');
                        $('.bank_salary_section').css('width', ' 100%');
                    }


                },
                error: function() {
                    // alert('Error occured!');
                    console.log('Error occured!');
                }
            });
        });

        $(document).on('click', '.loan_schedule_modal', function() {
            var loan_id = $(this).data("loan_id");
            var employee_id = $(this).data("employee_id");
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/loan_schedule_info/" + loan_id + '/' + employee_id,
                success: function(data) {
                    $(".loan_amount_id").text(data.loan_amount);
                    $(".paid_loan_amount_id").text(data.paid_loan_amounttt);
                    $('#loanListTable').dataTable().fnDestroy();
                    $("#loanListAppendData").find("tr:gt(0)").remove();
                    $('#loanListAppendData').empty();
                    paid_due_amount = 0;
                    c = 0;
                    total_loan_paid = data.paid_loan_amount;
                    for (var i = 0; i < data.loan_schedule.length; i++) {
                        j = i + 1;
                        paid_status = '-';
                        color_code = '';
                        if (total_loan_paid == 0) {
                            paid_status = 'Due';
                            color_code = 'red';
                        } else {
                            paid_due_amount = total_loan_paid - data.loan_schedule[i].installment_amount;
                            total_loan_paid = paid_due_amount;
                            if (paid_due_amount < 0) {
                                total_loan_paid = 0;
                                paid_status = 'Partial';
                                color_code = 'orange';
                            } else if (paid_due_amount >= 0) {
                                paid_status = 'Paid';
                                color_code = 'green';
                            }
                        }

                        /* Loan Deduct Calculation*/
                        loan_amount_int = data.loan_amount_int;
                        schedule_amount = data.loan_schedule[i].installment_amount;
                        if (i == 0) {
                            a = loan_amount_int;
                        } else {
                            a = c;
                        }
                        if (schedule_amount) {
                            b = schedule_amount;
                        } else {
                            b = 0;
                        }
                        c = a - b;
                        $('#loanListAppendData').append(
                            '<tr class="text-center">' +
                            '<td>' + j + '</td>' +
                            '<td class="text-center" style="width:20%">' + data.loan_schedule[i].installment_date + '</td>' +
                            '<td class="text-right">' + Math.round(a).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</td>' +
                            '<td class="text-right">' + Math.round(b).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</td>' +
                            '<td class="text-right">' + Math.round(c).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</td>' +
                            '<td>' + data.loan_schedule[i].loan_deduct_policy + '</td>' +
                            '<td style="color:' + color_code + ';">' + paid_status + '</td>' +
                            '</tr>'
                        );
                    }
                    // $('.loanListTable').show(500);
                },
                error: function() {
                    // alert('Error occured!');
                    console.log('Error occured!');
                }
            });
        });

    })


    function formatToCurrency(amount) {
        return (amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }



    function pabxSearchFunction() {
        var input = document.getElementById("myInput");
        var filter = input.value.toLowerCase();
        var nodes = document.getElementsByClassName('pabxListPrint');
        // alert(nodes);
        console.log(nodes);
        for (i = 0; i < nodes.length; i++) {
            if (nodes[i].innerText.toLowerCase().includes(filter)) {
                nodes[i].style.display = "block";
            } else {
                nodes[i].style.display = "none";
            }
        }
    }

    function emailSearchFunction() {
        var input = document.getElementById("myEmailInput");
        var filter = input.value.toLowerCase();
        var nodes = document.getElementsByClassName('emailListPrint');
        // alert(nodes);
        console.log(nodes);
        for (i = 0; i < nodes.length; i++) {
            if (nodes[i].innerText.toLowerCase().includes(filter)) {
                nodes[i].style.display = "block";
            } else {
                nodes[i].style.display = "none";
            }
        }
    }

    // $("#carouselsBirthday").trigger("change", function(){
    //      console.log("Changed");
    //  });
    // $(".birthday_list_sl").text('1');

    // temporary block for testing
    // $('#carouselNotice').on('slide.bs.carousel', function() {
    //     var ele = $('#carouselNotice div.active');
    //     $(".announcement_sl").text(ele.data('value'));
    //     $(".announcement_view_value").val(ele.data('noticeid'));
    //     var notice_id = $('.announcement_view_value').val();
    //     // console.log(notice_id_old);
    //     console.log(notice_id);
    //     if (!notice_id) {
    //         console.log('No notice available!');
    //         // $('#carouselNotice').carousel('pause');
    //         // return false;
    //     }
    //     var user_employee_id = "<?php echo Auth::guard('user')->user()->id; ?>";
    //     // alert(user_employee_id);
    //     $.ajax({
    //         type: 'GET',
    //         url: "{{ url('/') }}/find_notice_viewer_info/" + notice_id,
    //         success: function(data) {
    //             // console.log(url);
    //             // console.log(data);
    //             $("#notice_viewer_count").text(data.length);
    //             $('.listcategories').empty();
    //             for (var i = 0; i < data.length; i++) {
    //                 $(".listcategories").append("<li class='text-left'>" + data[i].employee_fullname + " [" + data[i].employee_id_no + "]</li>");
    //             }
    //         },
    //         error: function() {
    //             // alert('Error occured!');
    //             console.log('Error occured!');
    //         }
    //     });

    //     $.ajax({
    //         type: 'GET',
    //         url: "{{ url('/') }}/find_notice_vewing_info/" + notice_id + '/' + user_employee_id,
    //         success: function(data) {
    //             if (data.length > 0) {
    //                 $('.check_view_class').css('display', 'inline');
    //                 $('.eye_view_class').css('display', 'none');
    //             } else {
    //                 $('.check_view_class').css('display', 'none');
    //                 $('.eye_view_class').css('display', 'inline');
    //             }
    //         },
    //         error: function() {
    //             // alert('Error occured!');
    //             console.log('Error occured!');
    //         }
    //     });
    //     // console.log("Changed");
    // });

    $('#announcement_view_clicked').on('click', function() {
        var notice_id = $('#announcement_view_value').val();
        $.ajax({
            type: 'GET',
            url: "{{ url('/') }}/announcement_view/" + notice_id,
            success: function(data) {
                alert(data.view_message);
            },
            error: function() {
                // alert('Error occured!');
                console.log('Error occured!');
            }
        });
    });


    // temporary block for testing

    // $('#carouselsBirthday').on('slide.bs.carousel', function() {
    //     var ele = $('#carouselsBirthday div.active');
    //     $(".birthday_list_sl").text(ele.data('value'));
    //     $(".birthday_employee_id").val(ele.data('employeeid'));
    //     var employeeid = ele.data('employeeid');
    //     if (!employeeid) {
    //         console.log('No birthday available!');
    //         $('#carouselsBirthday').carousel('pause');
    //         return false;
    //     }
    //     var user_employee_id = "<?php echo Auth::guard('user')->user()->id; ?>";
    //     $.ajax({
    //         type: 'GET',
    //         url: "{{ url('/') }}/find_birthday_likers/" + employeeid,
    //         success: function(data) {
    //             j = 0;
    //             k = 0;
    //             $('.birthdayLikerList').empty();
    //             $('.birthdayWisherList').empty();
    //             $.each(data, function(item, value) {
    //                 if (item == "birthday_likers") {
    //                     $.each(value, function(i, object) {
    //                         j++;
    //                         $(".birthdayLikerList").append("<li class='text-left'>" + object.employee_fullname + " [" + object.employee_id_no + "]</li>");
    //                     });
    //                 }
    //                 if (item == "birthday_wishers") {
    //                     $.each(value, function(i, object) {
    //                         k++;
    //                         $(".birthdayWisherList").append("<li class='text-left'>" + object.employee_fullname + " [" + object.employee_id_no + "]</li>");
    //                     });
    //                 }
    //             });
    //             $("#birthday_likers_count").text(j);
    //             $("#birthday_wishers_count").text(k);
    //         },
    //         error: function() {
    //             console.log('Error occured!');
    //         }
    //     });

    //     $.ajax({
    //         type: 'GET',
    //         url: "{{ url('/') }}/find_birthday_liking_info/" + employeeid + '/' + user_employee_id,
    //         success: function(data) {
    //             console.log(Object.keys(data.birthday_wishing_no).length);
    //             if (data.birthday_liking_no.length > 0) {
    //                 $('.thums_o_up_class').css('display', 'none');
    //                 $('.thums_up_class').css('display', 'inline');
    //             } else {
    //                 $('.thums_o_up_class').css('display', 'inline');
    //                 $('.thums_up_class').css('display', 'none');
    //             }

    //             if (Object.keys(data.birthday_wishing_no).length > 0) {
    //                 $('.fa_heart_o_wish').css('display', 'none');
    //                 $('.fa_heart_wish').css('display', 'inline');
    //             } else {
    //                 $('.fa_heart_o_wish').css('display', 'inline');
    //                 $('.fa_heart_wish').css('display', 'none');
    //             }
    //         },
    //         error: function() {
    //             console.log('Error occured!');
    //         }
    //     });

    //     // fa_heart_o_wish

    // });

    $('#birthday_like_id').on('click', function() {
        var employee_id = $('.birthday_employee_id').val();
        var like_id = $('#birthdaylike_id').val();
        // alert(like_id);
        // alert(employee_id);
        $.ajax({
            type: 'GET',
            url: "{{ url('/') }}/birthday_view/" + employee_id + '/' + like_id,
            success: function(data) {
                // alert(data.view_message);
                console.log(data.view_message);
            },
            error: function() {
                console.log('Error occured!');
            }
        });
    });

    $('#birthday_wish_id').on('click', function() {
        var employee_id = $('.birthday_employee_id').val();
        var wish_id = $('#birthdaywish_id').val();
        // alert(employee_id);
        // alert(wish_id);
        $.ajax({
            type: 'GET',
            url: "{{ url('/') }}/birthday_view/" + employee_id + '/' + wish_id,
            success: function(data) {
                // alert(data.view_message);
                console.log(data.view_message);
            },
            error: function() {
                // alert('Error occured!');
                console.log('Error occured!');
            }
        });
    })
</script>
