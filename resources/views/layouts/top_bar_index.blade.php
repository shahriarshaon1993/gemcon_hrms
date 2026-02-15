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
                border-radius: 100%;
                top: 35% !important;
            }
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
                object-fit: cover;
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
            .service_request_btn{
                padding: 0px;
                border: 1px solid #e4e4e4;
                margin-bottom: 10px !important;
            }
            .service_request_btn:hover{
                background: whitesmoke;
                border-color: #e9ecef #e9ecef #dee2e6;
                box-shadow: 0px 1px 3px 0px #d7d7d7;
            }
            .add-note-btn{
                right: 24px; text-align: right; float: right; position:absolute; top: 5px;
            }

            .leave-form-style{
                max-width: 60%;
                height: auto;
            }


            /* For Mobile Device Start */
            @media screen and (max-width: 600px) {
                .leave-form-style{
                    max-width: 100%;
                    height: auto;
                }
                .text_hidden {
                    visibility: hidden;
                    display: none;
                }
                .o_main_navbar > ul.o_menu_systray {
                    left: 0px;
                    right: 10px;
                }
                .employee-profile {
                    width: 100%;
                }
                .employee-profile .profile-img {
                    /* border-bottom: 1px solid #ddd; */
                    padding-bottom: 15px;
                }
                .employee-profile .employee-info {
                    /* border-bottom: 1px solid #ddd; */
                    padding-bottom: 21px !important;
                }
                /* .add-note-btn{
                    top: -16%;
                    width: 40%;
                }
                .add-note-btn a{
                    text-align: center !important;
                    padding: 8px 22px;
                    font-size: 14px;
                    top: 60px;
                    position: absolute;
                    left: 25%;
                    z-index: 9;
                } */
                .employee-others-info{
                    padding-top: 15px;
                    padding-bottom: 15px;
                }
                .modal .modal-content .modal-footer .btn {
                    width: initial !important;
                }
                .service-add-new{
                    right: 15%;
                    position: absolute;
                }
                .general-stationary-add{
                    padding: 5px 0px;
                    text-align: right;
                }
                .o_main_navbar > ul.o_menu_systray > li .dropdown-menu.show {
                    height: 275px;
                    border-bottom: 2px solid #ddd;
                }
                .date-from-mobile{
                    margin-bottom: 20px;
                }
                /* #attendance_modal{
                    display: grid !important;
                    justify-content: center !important;
                    align-items: center !important;
                } */
            }
            /* For Mobile Device End */
        </style>
        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
        <script src="https://www.chartjs.org/dist/2.7.3/Chart.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.min.js"></script>

        <?php
            $current_date_time = date("Y-m-d H:i:s", strtotime('+6 hours'));
            $today_date = date('Y-m-d', strtotime($current_date_time));
            $today_attendances = collect($attendances)->where('dates', $today_date)->first();
            if($today_attendances && $today_attendances['intime'] != '00:00'){
                $today_intime = $today_attendances['intime'];
            }else{
                $today_intime = '';
            }
        ?>

        <script>
            var today_intime = '<?php echo ($today_intime); ?>';
            console.log(today_intime);
            if(today_intime == ''){
                // alert(attendances);
                if (window.innerWidth <= 600) {
                    $(window).on('load', function() {
                        $('#attendance_modal').modal('show');
                        $('#attendance_modal').modal({backdrop: 'static', keyboard: false})
                    });
                }
            }
        </script>

        <!-- Happy Birthday Wish Start-->
         <style>
                .dialog-birthday_message {
                    position: fixed;
                    /* border: 1px solid #bce3ff; */
                    left: 0;
                    right: 0;
                    bottom: 0;
                    top: 5%;
                    z-index: 99;
                    width: 680px;
                    height:520px;
                    /* -webkit-transform: none; */
                    margin: auto;
                }
                .birthday_container {
                    position: relative;
                    margin: 0 auto;
                    width: 100%;
                    height:100%;
                    display: block;
                    /* background:transparent; */
                    overflow: hidden;
                    /* background: #fff5c64d; */
                }
                .balloons {
                    z-index:1;
                    position:absolute;
                    top:40px;
                    left: 50%;
                    margin-left:-35%;
                }
                .birthday_container p {
                    z-index:1;
                    position:absolute;
                    /* bottom:40px; */
                    font-weight: 500;
                    font-size: 50px;
                    margin:0 auto;
                    width:100%;
                    text-align:center;
                    text-shadow: 2px 3px #ddd;
                    bottom: 30%;
                    color: yellowgreen;
                }
                #canvas_confetti {
                    display:inline-block;
                    position: absolute;
                    top:0;
                    left:0;
                    z-index:0;
                    width: 100%;
                    height: 100%;
                    background: floralwhite;
                    border: 1px solid #ddd;
                    opacity: 0.9;
                    border-radius: 10px;
                }
                .balloon-first {
                    display: inline-block;
                    width: 70px;
                    height: 80px;
                    background: hsl(215, 50%, 65%);
                    background: rgba(102, 145, 204,1);
                    border-radius: 80%;
                    position: relative;
                    box-shadow: inset -10px -10px 0 rgba(0, 0, 0, 0.07);
                    margin: 10px 10px;
                    transition: transform 0.5s ease;
                    z-index: 2;
                    animation: balloons 4s ease-in-out infinite;
                    transform-origin: bottom center;
                }

                @keyframes balloons {
                0%,
                100% {
                    transform: translateY(0) rotate(-4deg);
                }
                50% {
                    transform: translateY(-25px) rotate(4deg);
                }
                }

                .balloon-first:before {
                    content: "▲";
                    font-size: 20px;
                    color: hsl(215, 30%, 50%);
                    color: rgba(88, 125, 176,1);
                    display: block;
                    text-align: center;
                    width: 100%;
                    position: absolute;
                    bottom: -13px;
                    z-index: -100;
                }

                .balloon-first:after {
                    display: inline-block;
                    top: 65px;
                    position: absolute;
                    height: 100px;
                    width: 2px;
                    margin: 0 auto;
                    left:34px;
                    content: "";
                    background: rgba(0, 0, 0, 0.1);
                }

                .ballon:nth-child(1) {
                    box-shadow: inset -10px -10px 0 rgba(88, 125, 176,1);
                }
                .balloon-first:nth-child(2) {
                    background: hsl(245, 40%, 65%);
                    animation-duration: 3.5s;
                }

                .balloon-first:nth-child(2):before {
                    color: hsl(245, 40%, 65%);
                }

                .balloon-first:nth-child(3) {
                    background: hsl(139, 50%, 60%);
                    animation-duration: 3s;
                }

                .balloon-first:nth-child(3):before {
                    color: hsl(139, 30%, 50%);
                }

                .balloon-first:nth-child(4) {
                    background: hsl(59, 50%, 58%);
                    animation-duration: 4.5s;
                }

                .balloon-first:nth-child(4):before {
                    color: hsl(59, 30%, 52%);
                }

                .balloon-first:nth-child(5) {
                    background: hsl(23, 55%, 57%);
                    animation-duration: 5s;
                }

                .balloon-first:nth-child(5):before {
                    color: hsl(23, 44%, 46%);
                }
         </style>
         <script>
                var canvas = document.getElementById('canvas_confetti');
                var context = canvas.getContext('2d');
                canvas.width = document.getElementById('birthday_container').clientWidth;
                canvas.height = document.getElementById('birthday_container').clientHeight;
                document.getElementById('birthday_container').appendChild(canvas);
                var calculatedDensity = canvas.width * 0.0085;
                var calculatedVelocity = canvas.width * 0.0037;
                var calculatedLife = canvas.height * .65;
                var calculatedStartingX = canvas.width / 2;
                var particles = {},
                    particleIndex = 0,
                    settings = {
                        density: calculatedDensity,
                        particleSize: 8,
                        particleSizeVariety: 1.5,
                        startingX: calculatedStartingX,
                        startingY: -20,
                        velX: calculatedVelocity,
                        velY:2,
                        gravity: 0.015,
                        //maxLife: 300,
                        maxLife: calculatedLife,
                        particleColours: ["#F06292","#BA68C8","#64B5F6","#4DD0E1","#81C784","#DCE775","#FFD54F","#FF8A65","#EEEEEE"]
                    };
                function Particle() {
                    //Starting positions and velocities
                    this.x = settings.startingX;
                    this.y = settings.startingY;
                    //Random X and Y velocities
                    this.vx = (Math.random() * (settings.velX)) - (settings.velX/2);
                    this.vy = (Math.random() * (settings.velY)) - (settings.velY/2);
                    //this.vx = 10;
                    //this.vy = 10;

                    //Set up rotation & center of origin
                    this.rot = 0;
                    this.centerOfOriginX = -this.particleSize/2;
                    this.centerOfOriginY = -this.particleSize/4;

                    this.particleSize = parseInt((Math.random()*(settings.particleSizeVariety*2)) + settings.particleSize);

                    //Choose a random colour
                    this.particleColor = settings.particleColours[parseInt(Math.random()*settings.particleColours.length)];

                    //Add new particle to index - this is a way to store the particles created
                    particleIndex++;
                    particles[particleIndex] = this;
                    this.id = particleIndex;
                    //Will be used later to remove particle
                    this.life = -10 + parseInt(Math.random()*20);
                }

                //Add a 'draw' method to the Particle function
                Particle.prototype.draw = function() {

                    this.x += this.vx;
                    this.y += this.vy;

                    //calculate rotation
                    var period = 100;
                    this.rot += Math.sin(this.life * 2 * Math.PI / period)/2 * (Math.random()*2);

                    //Add gravity
                    this.vy += settings.gravity;

                    //Age the particle by adding to 'life'
                    this.life++;

                    //Remove the particle if it's old
                    if (this.life >= settings.maxLife) {
                        delete particles[this.id];
                    }

                    //Create shape
                    context.clearRect(0, settings.groundLevel, canvas.width, canvas.height);
                    context.beginPath();
                    context.fillStyle = this.particleColor;
                    //save context position
                    context.save();
                    context.translate(this.x,this.y);

                    var rotationAmount = 5;
                    //rotate by sine value
                    context.rotate(this.rot/rotationAmount);

                    //translate to near random center of origin
                    context.translate(this.centerOfOriginX,this.centerOfOriginY);
                    //context.translate(0,0);

                    context.globalAlpha = 0.9;
                    context.fillRect(0,0,this.particleSize,this.particleSize/2);
                    context.restore();
                }

                //Set up interval to draw particles
                setInterval(function() {
                            //Fillstyle transparency adds motion trails
                            //#673AB7 purple
                            //#2196F3 blue
                            //#009688 teal
                            //#FFEB3B yellow
                            // "rgba(39,174,96,.98)"; green
                            context.fillStyle = '#f7fcfd'
                            context.fillRect(0, 0, canvas.width, canvas.height);

                            // Draw the particles
                            for (var i = 0; i < settings.density; i++) {
                                // Random chance of creating a particle corresponding to an chance of 1 per second per "density" value
                                if (Math.random() > 0.97) {
                                new Particle();
                                }
                            }

                            //Use the draw method for all the particles in particles[]
                            for (var i in particles) {
                            particles[i].draw();
                            }
                        }, 16);

         </script>

        <!-- <div class="dialog-birthday_message">
            <div id="birthday_container" class="birthday_container">
                <div class="balloons">
                    <div class="balloon-first"></div>
                    <div class="balloon-first"></div>
                    <div class="balloon-first"></div>
                    <div class="balloon-first"></div>
                    <div class="balloon-first"></div>
                </div>
                <p>Happy Birthday To You,  </p>
                <p style="bottom: 17%">John! </p>

                <p style="bottom: 50% !important;text-align: center;left: 0%;">
                    <a id="click_me_birthday" style="font-size: 24px; color: orange;" >Click Me</a>
                </p>
                <canvas id="canvas_confetti" width="500px" height="400px"></canvas>
             </div>
        </div> -->

        <!-- Next ballon -->

        <style>
            #balloon-container {
                position: absolute;
                z-index: 9;
                height: 150vh;
                padding: 1em;
                box-sizing: border-box;
                display: flex;
                flex-wrap: wrap;
                overflow: hidden;
                transition: opacity 500ms;
            }

            .balloon {
            height: 125px;
            width: 105px;
            border-radius: 75% 75% 70% 70%;
            position: relative;
            }

            .balloon:before {
            content: "";
            height: 75px;
            width: 1px;
            padding: 1px;
            background-color: #FDFD96;
            display: block;
            position: absolute;
            top: 125px;
            left: 0;
            right: 0;
            margin: auto;
            }

            .balloon:after {
                content: "▲";
                text-align: center;
                display: block;
                position: absolute;
                color: inherit;
                top: 120px;
                left: 0;
                right: 0;
                margin: auto;
            }

            @keyframes float {
            from {transform: translateY(100vh);
            opacity: 1;}
            to {transform: translateY(-300vh);
            opacity: 0;}
            }
        </style>

        <div id="balloon-container">
        </div>
        <!-- <h1 id="birthday_wish_text">Happy Birthday To You Mr. Jhon!</h1> -->

        <script>
            const balloonContainer = document.getElementById("balloon-container");
            function random(num) {
            return Math.floor(Math.random() * num);
            }

            function getRandomStyles() {
                var r = random(255);
                var g = random(255);
                var b = random(255);
                var mt = random(200);
                var ml = random(50);
                var dur = random(5) + 5;
                return `
                background-color: rgba(${r},${g},${b},0.7);
                color: rgba(${r},${g},${b},0.7);
                box-shadow: inset -7px -3px 10px rgba(${r - 10},${g - 10},${b - 10},0.7);
                margin: ${mt}px 0 0 ${ml}px;
                animation: float ${dur}s ease-in infinite
                `;
            }

            function createBalloons(num) {
                var birthday_wish_name = "<?php echo $my_birthday_name; ?>";
                if(birthday_wish_name){
                var birthday_wishing = 'Happy Birthday to You '+birthday_wish_name+'!';
                alert(birthday_wishing);
                    for (var i = num; i > 0; i--) {
                        var balloon = document.createElement("div");
                        console.log(balloon);
                        balloon.className = "balloon";
                        balloon.style.cssText = getRandomStyles();
                        balloonContainer.append(balloon);
                    }
                }
            }

            function removeBalloons() {
            balloonContainer.style.opacity = 0;
            setTimeout(() => {
                balloonContainer.remove();
            }, 500)
            }
            // document.getElementById("click_me_birthday").onclick = function () {
            //     alert('ok');
            //     createBalloons(20);
            // };

            document.addEventListener('DOMContentLoaded', () => {
                document.querySelector('#click_me_birthday').addEventListener('load', () =>
                    {
                        createBalloons(20);
                    }
                )
            });

            // $("#click_me_birthday").on("load", function () {
            //     alert('ok');
            //     //  window.addEventListener("load", () => {
            //         createBalloons(30);
            //     // });
            // });

            window.addEventListener("load", () => {
                createBalloons(20);
                // balloonContainer.style.opacity = 0;
                setTimeout(() => {
                    balloonContainer.style.opacity = 0;
                }, 50000)
            });

            window.addEventListener("click", () => {
                removeBalloons();
            });

        </script>



        <!-- Next ballon -->
        <!-- Happy Birthday Wish End-->

        <!-- Attendance Modal Start -->
        <!-- Check In  -->
        <div class="modal fade" id="attendance_modal" tabindex="-1" role="dialog" aria-labelledby="applyLeaveLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="display:inline; margin-top: 60% !important;">
            <div class="modal-dialog" role="document" style="min-width: 55%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-clock-o"></i>  Attendance</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="false">&times;</span></button>
                    </div>
                    <div class="modal-body" style="padding: 50px; text-align: center;">
                        <input type="hidden" name="current_latitude" id="current_latitude"/>
                        <input type="hidden" name="current_longitude" id="current_longitude"/>
                        <button id="check_in_manual_attendance" type="button" class="btn btn-lg btn-success" style="width: 60%; padding: 15px;">Check In</button>
                        <!-- <button id="check_out_manual_attendance" type="button" class="btn btn-info" style="margin-left: 15px;">Check Out</button> -->
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 2px;background: #e9e9e9;    padding: 5px;margin-right: 3px;    color: #000;border: 1px solid #aaa;    padding-right: 10px;    padding-left: 10px;">Cancel</button>
                    </div> -->
                </div>
            </div>
        </div>

        <!-- Check Out Modal -->
        <div class="modal fade" id="attendance_checkout" tabindex="-1" role="dialog" aria-labelledby="applyLeaveLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="display:inline; margin-top: 60% !important;">
            <div class="modal-dialog" role="document" style="min-width: 55%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-clock-o"></i>  Attendance</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="false">&times;</span></button>
                    </div>
                    <div class="modal-body" style="padding: 50px; text-align: center;">
                        <input type="hidden" name="current_latitude" id="current_latitude"/>
                        <input type="hidden" name="current_longitude" id="current_longitude"/>
                        <button id="check_out_manual_attendance" type="button" class="btn btn-lg btn-secondary" style="width: 60%; padding: 15px; text-transform: capitalize">Check Out</button>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 2px;background: #e9e9e9;    padding: 5px;margin-right: 3px;    color: #000;border: 1px solid #aaa;    padding-right: 10px;    padding-left: 10px;">Cancel</button>
                    </div> -->
                </div>
            </div>
        </div>

        <!-- Attendance Modal End -->

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
                            for (var i = 0; i < data.holidayList.length; i++) {
                                console.log(data);
                                events.push({
                                    id: data.holidayList[i].id,
                                    title: data.holidayList[i].Type,
                                    start: data.holidayList[i].s_date,
                                    end: data.holidayList[i].e_date,
                                });
                            }
                            // console.dir(events);
                            callback(events);
                        },
                        error: function(data) {
                            console.log("Ajax call error");
                        }
                    });
                },
                initialDate: '2020-09-12',
                navLinks: true,
                selectable: true,
                selectHelper: true,
                select: function(arg) {
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
                    <a id="service_list_modal_open" href="#" class="nav-link service_list_modal_open" data-backdrop="static" data-keyboard="false"><i class="fa fa-lg fa-question-circle"></i> <span class="text_hidden">SERVICE REQUEST</span></a>
                </li>
                <li class="dropdown mega-dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#"><i class="fa fa-lg fa-th-large"></i> <span class="text_hidden">ALL MODULE</span></a>
                    <ul class="dropdown-menu mega-dropdown-menu o_home_menu">
                        <div class="o_home_menu_scrollable">

                            <div class="o_apps">
                                <?php if($user->user_type != 8){ ?>
                                <a class="o_app o_menuitem" target="_blank" href="{{url('/dashboards#/job_circular_list')}}">
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
                        <span class="text_hidden">{{$user->name}}</span>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-setting" role="menu" style="  top: 94%;">
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
                    <?php //dd($employee_data); ?>
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
                    <div class="border-top my-3 row d-sm-none"></div>

                    <div class="col-md-12 d-md-none">
                        <a class="add_new_service_modal text-center btn btn-warning" href="#" data-toggle="modal" data-target="#addNoteRequest" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" style="color:#212529; text-decoration: none; width: 40%; padding: 10px; font-size: 14px;">
                            Add Note
                        </a>
                        @if(!empty($today_intime))
                            <a class="add_new_service_modal text-center btn btn-secondary float-right" href="#" data-toggle="modal" data-target="#attendance_checkout" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" style="color:#212529; text-decoration: none; width: 40%; padding: 10px; font-size: 14px; color: #efefef; text-transform: capitalize;">
                                Check Out
                            </a>
                        @else
                        <a class="add_new_service_modal text-center btn btn-success float-right" href="#" data-toggle="modal" data-target="#attendance_modal" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" style="color:#212529; text-decoration: none; width: 40%; padding: 10px; font-size: 14px; color: #efefef; text-transform: capitalize;">
                            Check In
                        </a>
                        @endif
                    </div>
                    <div class="border-top my-3 row d-sm-none"></div>
                    <div class="col-md-3 col-12 float-left employee-others-info" style="min-width: 25% ;">
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
                                    // $date1 = $employee_data['employee_joining_date'];
                                    // $date2 = date('Y-m-d');
                                    // if (!empty($date1)) {
                                        // $diff = abs(strtotime($date2) - strtotime($date1));
                                        // $yearss = floor($diff / (365 * 60 * 60 * 24));
                                        // $monthss = floor(($diff - $yearss * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                        // $dayss = floor(($diff - $yearss * 365 * 60 * 60 * 24 - $monthss * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                        // printf("%dY-%dM-%dD\n", $yearss, $monthss, $dayss);

                                    //     $Joining = new DateTime($date1);
                                    //     $today = new Datetime(date('Y-m-d'));
                                    //     $diff = $today->diff($Joining);
                                    //     echo $JoiningDates = $diff->y . '.' . $diff->m. 'Y';
                                    // } else {
                                    //     echo "Not Found!";
                                    // }

                                        if(!empty($employee_data['service_length'])){
                                            echo round($employee_data['service_length'], 1) .' Years';
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
                                                ?>
                                                <?php
                                                    foreach ($notices as $key => $value) :
                                                        $i++;
                                                ?>
                                                        <div data-noticeid="<?php echo $value['id']; ?>" data-value="<?php echo $i; ?>" data-slide-to="0" class="carousel-item <?php if ($i == 1) { echo 'active'; } ?>" style="background:#fff !important;">
                                                            <table cellspacing="0" width="100%">
                                                                <tr style="background:#fff !important;">
                                                                    <td colspan="5" style="text-align: left; border: none; padding-left: 0px;">
                                                                        <i class="fa fa-bell"> {{$value['notice_title'] }}</i>
                                                                    </td>
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

                                            <?php
                                            //   dd($notice_vewing_info);
                                            if (!empty($notice_vewing_info) && count($notice_vewing_info) > 0) : ?>
                                                <div class="col-md-12">
                                                    <div class="row text_hidden">
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
                                                    <i style="color: orange;" class="fa fa-eye check_view_class"></i>
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
                                                    <div data-employeeid="<?php echo $value['id']; ?>" style="background: #fff !important;" data-target="#carouselsBirthday" data-value="<?php echo $i; ?>" data-slide-to="0" class="carousel-item <?php if ($i == 1) { echo 'active';} ?>" style="padding:0px;">
                                                            <div class="col-md-6 float-left text-left" style="margin-left: 0px; padding:0px;background: #fff !important; padding-left: 2px;">
                                                                <i class="fa fa-user"></i>
                                                                <?php echo $value['employee_fullname']; ?>
                                                            </div>
                                                            <div class="col-md-3 float-left text-left" style="margin-left: 0px; padding:0px;background: #fff !important; text-overflow: ellipsis; width: 118px; overflow: hidden; white-space: nowrap;">
                                                                <?php echo $value['designation_name']; ?>
                                                            </div>
                                                            <div class="col-md-3 float-left text-left" style="margin-left: 0px; padding:0px; text-overflow: ellipsis; width: 118px; overflow: hidden; white-space: nowrap;" title="<?php echo $value['sbu_name']; ?>">
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
                                                    <div class="row text_hidden">
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
                                                    <div class="row text_hidden">
                                                        <div class="col-md-9" style="padding-top: 7px; padding-right: 0px; text-align: right;">
                                                            <a class="" style="color:#0447ab;">
                                                                Birthday
                                                                <span class="birthday_list_sl"><?php echo $i; ?></span>/<?php echo count($today_birthday_info); ?>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-3" style="padding-top: 30px;">
                                                            <a class="col-md-6 float-left carousel-control-next " href="#carouselsBirthday" role="button" data-slide="next" style="color:#0447ab;">
                                                                <span style="padding-right: 5px;color:#0447ab;margin-left: -10px;"> Next</span>
                                                                <i class="fa fa-angle-right" style="color:#0447ab;"></i>
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
                                            <a class="show float-left" id="birthday_like_id" style="border: none; background: transparent;padding: 0px; width: 30% !important;text-align: left; cursor: pointer;">
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
                                            </a>
                                            <a class="show float-left" id="birthday_wish_id" style="border: none; background: transparent;padding: 0px; width: 50% !important; text-align: left; cursor: pointer;">
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
                                            </a>

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
                            <a class="nav-link > <" id="my-profile-tab" data-toggle="tab" href="#my-profile" role="tab" aria-controls="my-profile" aria-selected="false">My Profile</a>
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
                        <li class="nav-item add-note-btn d-none d-sm-block">
                            <a class="add_new_service_modal text-right btn btn-warning" href="#" data-toggle="modal" data-target="#addNoteRequest" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" style="color:#212529; text-decoration: none;">
                                Add Note
                            </a>
                        </li>

                        <li class="nav-item add-note-btn d-none d-sm-block">
                            <a class="text-right btn btn-warning" href="{{ route('daily_birthday_wish') }}" style="color:#212529; text-decoration: none;">
                                Birthday Wish
                            </a>
                        </li>
                    </ul>

                    <!-- $message = ' -->
            <!-- <html> -->
                <!-- <div style="background-image: url(https://www.w3schools.com/html/img_girl.jpg); height: 600px; width: 500px">
                </div> -->
                <!-- <div class='col-md-12' style='border: 1px solid blue; height: 720px; width: 576px;   background: linear-gradient(to bottom right, #ffbd04 18%, #517fb3 90%);'> -->
                    <!-- <img src="{{asset('birthday_wish/blank_gemcon_birthdayh_wish.jpg')}}" alt="Birthday Wish" width="576" height="720"> -->
                    <!-- <div>
                        <img style="position: absolute;top: 2%;left: 23%;width: 10%;" src="{{asset('company_logo/3FjPnV180BxhQ7wV.png')}}" alt="Company Logo">
                        <img style="position: absolute;top: 18.6%;left: 10.8%;border-radius: 50%;object-fit: cover;" src="{{asset('images/9c79o7NekPZZipHt.jpeg')}}" alt="Employee Logo" width="235" height="235">
                        <span style="position: absolute;top: 77%;left: 9%;font-size: 18px;font-weight: 500;">Mr. Abdur Rahman</span>
                    </div> -->
                <!-- </div>  -->

            <!-- </html>     -->

        <!-- '; -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active home-min-height" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row" style="margin-left: -11px; margin-right: -11px;">
                                <div class="col-6 col-sm-4 col-md-2">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-clock-o"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Present</span>
                                            <span class="info-box-number "> {{$present_day_count }}</span>
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
                                                {{$late_day_count }}
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
                                                {{$leave_count }}
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
                                                {{$holiday_count }}
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
                                                {{$absent_day_count }}
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
                                                {{$pay_days }}
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
                                                                } elseif ($att_value['statusId'] == 6) {
                                                                    echo "<span class='btn btn-xs bg-primary' style='height:25px;width:28px;padding:3px;color:#ddd;font-weight:bold' title='Leave'>" . $att_value['Status'] . "</span>";
                                                                } elseif ($att_value['statusId'] == 4 || $att_value['statusId'] == 5) {
                                                                    echo "<span class='btn btn-xs bg-dark' style='height:25px;color:#ddd;font-weight:bold' title='Weekend/Holiday'>" . $att_value['Status'] . "</span>";
                                                                } elseif ($att_value['statusId'] == 3) {
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
                                                            <a class="btn btn-warning apply_leave_class" href="#" data-toggle="modal" data-target="#applyLeave" data-whatever="@getbootstrap" style="color:#212529; text-decoration: none;width: 115px;">
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
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade home-min-height" id="my-profile" role="tabpanel" aria-labelledby="profile-tab" style="padding-left:0px;">
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
                                                <i class="fa fa-user" style="color:orange;"></i> Edit Profile
                                            </a> -->
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
                        </div>
                        <div class="tab-pane fade home-min-height " id="file-manager" role="tabpanel" aria-labelledby="tab5">
                            <div class="col-md-12 table-responsive folder_list_section" style="padding-bottom: 15px;">
                                <h5 style="margin-bottom: 25px;">
                                    <i class="fa fa-bars"></i> Folder List
                                    <span id="folder_grid_hide_show1" style="float: right; cursor:pointer; margin-top: 6px; font-size:18px;">
                                        <i class="fa fa-th-large"></i>
                                    </span>
                                    <span id="folder_grid_hide_show" style="float: right; display: none;  cursor:pointer; margin-top: 6px; font-size:18px;">
                                        <i class="fa fa-list"></i>
                                    </span>
                                </h5>
                                <div class="folder_grid_view" id="folder_exampleDataTable123" style="padding:0px; margin-left:-15px;">
                                    @include('layouts.folder_pagination_data_grid')
                                </div>
                                <input type="hidden" name="hidden_page" id="folder_hidden_page" value="1" />
                                <input type="hidden" name="hidden_column_name" id="folder_hidden_column_name" value="id" />
                                <input type="hidden" name="hidden_sort_type" id="folder_hidden_sort_type" value="asc" />
                                <input type="hidden" name="view_type" id="folder_view_type" value="1" />

                                <table class="table table-striped table-bordered folder_list_view" style="width:100%;display: none;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="padding: .75rem;">#</th>
                                            <th class="text-center" style="padding: .75rem;">
                                                Folder Name
                                            </th>
                                            <th class="text-center" style="padding: .75rem;">Last Modified</th>
                                            <!-- <th class="text-center" style="padding: .75rem;">Folder Size</th> -->
                                            <th class="text-center" style="padding: .75rem;">Created by</th>
                                            <th class="text-center" style="padding: .75rem;">Created at</th>
                                            <th class="text-center" style="padding: .75rem;">Folder Status</th>
                                            <th class="text-center" style="padding: .75rem;">Permission</th>
                                            <th class="text-center" style="padding: .75rem;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="folder_exampleDataTable1234">
                                        @include('layouts.folder_pagination_data')
                                    </tbody>
                                </table>

                            </div>
                            <div class="col-md-12 fileListInfo" style="display: none;">
                                <div class="col-md-12 backToFolderList" style="padding:0px;">
                                    <h5 class='col-md-6 text-left float-left' style="margin-top:10px; padding:0px; cursor: pointer;">
                                        <i class="fa fa-arrow-up"></i>
                                        File List
                                    </h5>
                                    <div class="col-md-6  text-right backToFolderList float-left" style="display: inline; padding:0px;">
                                        <a class="btn btn-default" style="background: #eaeaea;"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                </div>
                                <table id="fileListTable" class="table table-striped table-bordered fileListTable" cellspacing="0" style="font-size:12px; border: none;    ">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope='col' style='border:1px solid #ddd !important;'>#</th>
                                            <th scope='col' style='border:1px solid #ddd !important;'>File Name </th>
                                            <th scope='col' style='border:1px solid #ddd !important;'>File Type </th>
                                            <th scope='col' style='border:1px solid #ddd !important;'>File Expiration </th>
                                            <th scope='col' style='border:1px solid #ddd !important;'>Notification Period </th>
                                            <th scope='col' style='border:1px solid #ddd !important;'>Email Notify </th>
                                            <th scope='col' style='border:1px solid #ddd !important;'> File Size </th>
                                            <th scope='col' style='border:1px solid #ddd !important;'> File Status </th>
                                            <th scope='col' style='border:1px solid #ddd !important; '> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id='fileListAppendData'>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- href="/index" onclick="onLodingOverlay()" -->
                        <div class="tab-pane fade home-min-height" id="assets" role="tabpanel" aria-labelledby="tab4">
                            <div class="w-100 d-flex justify-content-center align-items-center">
                                <div class="spinner"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade home-min-height" id="payroll" role="tabpanel" aria-labelledby="tab5">
                            <div class="col-md-12" style="padding: 0px;">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#SalaryInfo" role="tab" aria-controls="home" aria-selected="true">Salary Info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="my-profile-tab" data-toggle="tab" href="#ProvidentFund" role="tab" aria-controls="my-profile" aria-selected="false">Provident Fund</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="my-profile-tab" data-toggle="tab" href="#LoanAdvance" role="tab" aria-controls="my-profile" aria-selected="false">Loan & Advance</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="SalaryInfo" style="padding:0px;" role="tabpanel" aria-labelledby="home-tab1">
                                    <div class="row" style="margin-left: -11px; margin-right: -11px; margin-top:15px;">
                                        <!-- <div class="col-6 col-sm-4 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-info elevation-1"><i class="fa fa-list"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total </span>
                                        <span class="info-box-number "> {{$present_day_count }}</span>
                                    </div>
                                    <div role="separator" class="dropdown-divider"></div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fa fa-clock-o"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Confirmation Date</span>
                                        <span class="info-box-number ">
                                            {{$late_day_count}}
                                        </span>
                                    </div>
                                    <div role="separator" class="dropdown-divider"></div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-money"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Present Basic</span>
                                        <span class="info-box-number "> {{$present_day_count }}</span>
                                    </div>
                                    <div role="separator" class="dropdown-divider"></div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-money"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Present Gross</span>
                                        <span class="info-box-number ">
                                            {{$late_day_count }}
                                        </span>
                                    </div>
                                    <div role="separator" class="dropdown-divider"></div>
                                </div>
                            </div> -->

                                        <div class="col-6 col-sm-4 col-md-3">
                                            <div class="info-box mb-3">
                                                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-clock-o"></i></span>

                                                <div class="info-box-content">
                                                    <span class="info-box-text">Present</span>
                                                    <span class="info-box-number "> {{$present_day_count }}</span>
                                                </div>
                                                <div role="separator" class="dropdown-divider"></div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <div class="info-box mb-3">
                                                <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-clock-o"></i></span>

                                                <div class="info-box-content">
                                                    <span class="info-box-text">Late</span>
                                                    <span class="info-box-number ">
                                                        {{$late_day_count }}
                                                    </span>
                                                </div>
                                                <div role="separator" class="dropdown-divider"></div>
                                            </div>
                                        </div>

                                        <div class="clearfix hidden-md-up"></div>
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <div class="info-box mb-3">
                                                <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-clock-o"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Absent</span>
                                                    <span class="info-box-number ">
                                                        {{$absent_day_count }}
                                                    </span>
                                                </div>
                                                <div role="separator" class="dropdown-divider"></div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-info  elevation-1"><i class="fa fa-clock-o"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Pay Days</span>
                                                    <span class="info-box-number ">
                                                        {{$pay_days }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class='col-md-5 text-left float-left' style="padding-top:10px;">
                                                <h5>
                                                    <i class="fa fa-bars"></i>
                                                    Salary Info
                                                </h5>
                                            </div>

                                            <div class="col-md-7 text-right float-left" style="padding-top:10px;padding-right:0px;">

                                                <strong>
                                                    Total Gross Salary:
                                                    <span style="color: green;">
                                                        <?php if ($gross_salary) : ?>
                                                            <?php echo number_format($gross_salary, 2, '.', ','); ?>
                                                        <?php endif ?>
                                                    </span>
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="col-md-12 backToFolderList" style="padding:0px;">
                                                <h5 class='col-md-6 text-left float-left' style="margin-top:10px; padding:0px; cursor: pointer;">
                                                    <i class="fa fa-bars"></i>
                                                    Salary List
                                                </h5>
                                            </div>
                                        </div>

                                        <?php if (empty($cash_salary)) : ?>
                                            <?php
                                            $col_md = '4';
                                            ?>
                                        <?php else : ?>
                                            <?php
                                            $col_md = '2';
                                            ?>
                                        <?php endif ?>
                                        <div class="col-md-<?php echo $col_md; ?>" style="top:30px;">
                                            <table class="table table-striped table-bordered salaryListTable" cellspacing="0" style="font-size:12px; border: none; ">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th colspan="2" style='border:1px solid #ddd !important;'>Bank Salary</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <th class="align-middle" style="padding:6px;">Gross - Bank</th>
                                                        <th class='text-right' style="padding:6px;">
                                                            <?php
                                                            echo isset($bank_salary['gross_salary']) ? number_format($bank_salary['gross_salary'], 2, '.', ',') : 0;
                                                            ?>
                                                        </th>
                                                    <tr style="background-color:#fff;">
                                                        <td class="align-middle" style="padding:6px;">Basic</td>
                                                        <td class='text-right' style="padding:6px;">
                                                            <?php
                                                            echo isset($bank_salary['basic_salary']) ? number_format($bank_salary['basic_salary'], 2, '.', ',') : 0;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color:#fff;">
                                                        <td class="align-middle" style="padding:6px;">House</td>
                                                        <td class='text-right' style="padding:6px;">
                                                            <?php
                                                            echo isset($bank_salary['housing_allowance']) ? number_format($bank_salary['housing_allowance'], 2, '.', ',') : 0;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color:#fff;">
                                                        <td class="align-middle" style="padding:6px;">Transport</td>
                                                        <td class='text-right' style="padding:6px;">
                                                            <?php
                                                            echo isset($bank_salary['medical_allowance']) ? number_format($bank_salary['medical_allowance'], 2, '.', ',') : 0;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color:#fff;">
                                                        <td class="align-middle" style="padding:6px;">Medical</td>
                                                        <td class='text-right' style="padding:6px;">
                                                            <?php
                                                            echo isset($bank_salary['conveyance_allowance']) ? number_format($bank_salary['conveyance_allowance'], 2, '.', ',') : 0;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color:#fff;">
                                                        <td class="align-middle" style="padding:6px;">Others </td>
                                                        <td class='text-right' style="padding:6px;">
                                                            <?php
                                                            echo isset($bank_salary['others_allowance']) ? number_format($bank_salary['others_allowance'], 2, '.', ',') : 0;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="align-middle" style="padding:6px;">Total Bank </td>
                                                        <th class='text-right' style="padding:6px;">
                                                            <?php
                                                            if (!empty($bank_salary['gross_salary'])) {

                                                                echo number_format($bank_salary['gross_salary'] + $bank_salary['others_allowance'], 2, '.', ',');
                                                            } else {
                                                                echo "0.00";
                                                            }
                                                            ?>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php if (!empty($cash_salary)) { ?>
                                            <div class="col-md-2" style="top:30px;">
                                                <table class="table table-striped table-bordered salaryListTable" cellspacing="0" style="font-size:12px; border: none;">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th colspan="2" style='border:1px solid #ddd !important;'>Cash Salary</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th class="align-middle" style="padding:6px;">Gross - Cash</th>
                                                            <th class='text-right' style="padding:6px;">
                                                                <?php
                                                                echo isset($cash_salary['gross_salary']) ? number_format($cash_salary['gross_salary'], 2, '.', ',') : 0;
                                                                ?>
                                                            </th>
                                                        <tr style="background-color:#fff;">
                                                            <td class="align-middle" style="padding:6px;">Basic</td>
                                                            <td class='text-right' style="padding:6px;">
                                                                <?php
                                                                echo isset($cash_salary['basic_salary']) ? number_format($cash_salary['basic_salary'], 2, '.', ',') : 0;
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr style="background-color:#fff;">
                                                            <td class="align-middle" style="padding:6px;">House</td>
                                                            <td class='text-right' style="padding:6px;">
                                                                <?php
                                                                echo isset($cash_salary['housing_allowance']) ? number_format($cash_salary['housing_allowance'], 2, '.', ',') : 0;
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr style="background-color:#fff;">
                                                            <td class="align-middle" style="padding:6px;">Transport</td>
                                                            <td class='text-right' style="padding:6px;">
                                                                <?php
                                                                echo isset($cash_salary['medical_allowance']) ? number_format($cash_salary['medical_allowance'], 2, '.', ',') : 0;
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr style="background-color:#fff;">
                                                            <td class="align-middle" style="padding:6px;">Medical</td>
                                                            <td class='text-right' style="padding:6px;">
                                                                <?php
                                                                echo isset($cash_salary['conveyance_allowance']) ? number_format($cash_salary['conveyance_allowance'], 2, '.', ',') : 0;
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr style="background-color: #cdcdcd;`">
                                                            <td class="align-middle" style="padding:6px;">Car Allowance </td>
                                                            <td class='text-right' style="padding:6px;">
                                                                <?php
                                                                echo isset($cash_salary['car_allowance_amount']) ? number_format($cash_salary['car_allowance_amount'], 2, '.', ',') : 0;
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="align-middle" style="padding:6px;">Total Cash </td>
                                                            <th class='text-right' style="padding:6px;">
                                                                <?php
                                                                if (!empty($cash_salary['gross_salary'])) {

                                                                    echo number_format($cash_salary['gross_salary'] + $cash_salary['car_allowance_amount'], 2, '.', ',');
                                                                    # code...
                                                                } else {
                                                                    echo "0.00";
                                                                }
                                                                ?>
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } ?>

                                        <div class="col-md-8" style="padding: 0px">
                                            <table id="salaryListTable" class="table table-striped table-bordered salaryListTable" cellspacing="0" style="font-size:12px; border: none;">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope='col' style='border:1px solid #ddd !important;'>#</th>
                                                        <th scope='col' style='border:1px solid #ddd !important;'>Date/Month </th>
                                                        <th scope='col' style='border:1px solid #ddd !important;'>Gross </th>
                                                        <th scope='col' style='border:1px solid #ddd !important;'>Basic </th>
                                                        <th scope='col' style='border:1px solid #ddd !important;'>House </th>
                                                        <th scope='col' style='border:1px solid #ddd !important;'> Medical </th>
                                                        <th scope='col' style='border:1px solid #ddd !important; '> Transport </th>
                                                        <th scope='col' style='border:1px solid #ddd !important; '> Others </th>
                                                        <th scope='col' style='border:1px solid #ddd !important; '> Deduction </th>
                                                        <th scope='col' style='border:1px solid #ddd !important; '> Net Pay </th>
                                                        <th scope='col' style='border:1px solid #ddd !important; '> Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($monthly_salary_info)) : ?>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($monthly_salary_info as $key => $salary) :
                                                            $i++;
                                                        ?>
                                                            <tr role="row" class="odd">
                                                                <td class="text-center sorting_1">
                                                                    {{$i}}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{$salary['paymonth']}}
                                                                </td>
                                                                <td class="text-right">
                                                                    {{number_format($salary['gross_salary'], 2, '.', ',')}}
                                                                </td>
                                                                <td class="text-right">
                                                                    {{number_format($salary['basic'], 2, '.', ',')}}
                                                                </td>
                                                                <td class="text-right">
                                                                    {{number_format($salary['houserent'], 2, '.', ',')}}
                                                                </td>
                                                                <td class="text-right">
                                                                    {{number_format($salary['medical'], 2, '.', ',')}}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{number_format($salary['transport'], 2, '.', ',')}}
                                                                </td>
                                                                <td class="text-right">
                                                                    {{number_format($salary['total_additions'], 2, '.', ',')}}
                                                                </td>
                                                                <td class="text-right">
                                                                    {{number_format($salary['total_deduction'], 2, '.', ',')}}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{number_format($salary['netpay'], 2, '.', ',')}}
                                                                </td>
                                                                <td class="text-center">

                                                                    <button title="Schedule" class="btn btn-xs btn-info pay_slip_modal" href="#" data-toggle="modal" data-target="#pay_slip_modal" data-whatever="@getbootstrap" data-payroll_id="<?php echo $salary['id']; ?>" data-employee_id="<?php echo $salary['empid']; ?>">
                                                                        <i class="fa fa-credit-card"></i> Pay Slip
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach ?>

                                                    <?php else : ?>
                                                        <?php echo 'No Data Found!' ?>
                                                    <?php endif ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="ProvidentFund" style="padding:0px;" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="row" style="margin-left: -11px; margin-right: -11px; margin-top:15px;">
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <div class="info-box mb-3">
                                                <span class="info-box-icon bg-info elevation-1"><i class="fa fa-list"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">No. of Month</span>
                                                    <span class="info-box-number "> {{$no_of_month}}</span>
                                                </div>
                                                <div role="separator" class="dropdown-divider"></div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <div class="info-box mb-3">
                                                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-user"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Employee Contribution</span>
                                                    <span class="info-box-number ">
                                                        {{number_format($total_emp_contribution, 2, '.', ',') }}
                                                    </span>
                                                </div>
                                                <div role="separator" class="dropdown-divider"></div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <div class="info-box mb-3">
                                                <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-industry"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Company Contribution</span>
                                                    <span class="info-box-number "> {{number_format($total_comp_contribution, 2, '.', ',')}}</span>
                                                </div>
                                                <div role="separator" class="dropdown-divider"></div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <div class="info-box mb-3">
                                                <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-money"></i></span>

                                                <div class="info-box-content">
                                                    <span class="info-box-text">Total PF</span>
                                                    <span class="info-box-number ">
                                                        {{number_format($total_emp_contribution+$total_comp_contribution, 2, '.', ',')}}
                                                    </span>
                                                </div>
                                                <div role="separator" class="dropdown-divider"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 backToFolderList" style="padding:0px;">
                                        <h5 class='col-md-6 text-left float-left' style="margin-top:10px; padding:0px; cursor: pointer;">
                                            <i class="fa fa-bars"></i>
                                            Provident Fund
                                        </h5>
                                    </div>
                                    <table id="providentFundListTable" class="table table-striped table-bordered" cellspacing="0" style="font-size:12px; border: none;">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope='col' style='border:1px solid #ddd !important;'>#</th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>Month </th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>Date </th>
                                                <th scope='col' style='border:1px solid #ddd !important; width: 30%;'>Employee Contribution </th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>Company Contribution </th>
                                                <th scope='col' style='border:1px solid #ddd !important;'> Total </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($provident_fund_info)) : ?>
                                                <?php
                                                $i = 0;
                                                foreach ($provident_fund_info as $key => $provident) :
                                                    $i++;
                                                ?>
                                                    <tr role="row" class="odd">
                                                        <td class="text-center sorting_1">
                                                            {{$i}}
                                                        </td>
                                                        <td class="text-center">
                                                            {{date('F', strtotime($provident['pf_date']))}}
                                                        </td>
                                                        <td class="text-center">
                                                            {{date('d M Y', strtotime($provident['pf_date']))}}
                                                        </td>
                                                        <td class="text-center">
                                                            {{number_format($provident['pf_employee_amount'], 2, '.', ',')}}
                                                        </td>
                                                        <td class="text-center">
                                                            {{number_format($provident['pf_company_amount'], 2, '.', ',')}}
                                                        </td>
                                                        <td class="text-center">
                                                            {{number_format($provident['pf_employee_amount']+$provident['pf_company_amount'], 2, '.', ',')}}
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php else : ?>
                                                <?php echo 'No Data Found!' ?>
                                            <?php endif ?>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="LoanAdvance" style="padding:0px;" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="row" style="margin-left: -11px; margin-right: -11px; margin-top:15px;">
                                        <div class="col-6 col-sm-4 col-md-3" style="max-width: 20%;">
                                            <div class="info-box mb-3">
                                                <span class="info-box-icon bg-info elevation-1"><i class="fa fa-list"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Total Loan</span>
                                                    <span class="info-box-number ">
                                                        <?php if ($total_loan_amount) : ?>
                                                            {{number_format($total_loan_amount, 2, '.', ',') }}

                                                        <?php else : ?>
                                                            {{number_format(0, 2, '.', ',') }}
                                                        <?php endif ?>
                                                    </span>
                                                </div>
                                                <div role="separator" class="dropdown-divider"></div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-3" style="max-width: 20%;">
                                            <div class="info-box mb-3">
                                                <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-money"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Ongoing Loan</span>
                                                    <span class="info-box-number ">
                                                        <?php if (!empty($current_loan_amount)) : ?>
                                                            {{number_format($current_loan_amount, 2, '.', ',') }}
                                                        <?php else : ?>
                                                            {{number_format(0, 2, '.', ',') }}
                                                        <?php endif ?>
                                                    </span>
                                                </div>
                                                <div role="separator" class="dropdown-divider"></div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-3" style="max-width: 20%;">
                                            <div class="info-box mb-3">
                                                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">EMI: <strong>
                                                            <?php if (!empty($paid_no_of_loan)) {
                                                                echo $paid_no_of_loan;
                                                            } else {
                                                                echo '0';
                                                            } ?>/<?php if (!empty($emp_loan_info_remaining)) {
                                                echo $emp_loan_info_remaining['no_of_installment'];
                                            } else {
                                                echo '0';
                                            }
                                            ?>

                                                        </strong></span>
                                                    <span class="info-box-number ">
                                                        <?php if (!empty($paid_loan_amount)) : ?>
                                                            {{number_format($total_paid_loan_amount, 2, '.', ',') }}
                                                        <?php else : ?>
                                                            {{number_format(0, 2, '.', ',') }}
                                                        <?php endif ?>
                                                    </span>
                                                </div>
                                                <div role="separator" class="dropdown-divider"></div>
                                            </div>
                                        </div>

                                        <div class="col-6 col-sm-4 col-md-3" style="max-width: 20%;">
                                            <div class="info-box mb-3">
                                                <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-money"></i></span>

                                                <div class="info-box-content">
                                                    <span class="info-box-text">Current Due</span>
                                                    <span class="info-box-number ">
                                                        <?php if (!empty($current_loan_amount) > 0) :
                                                            $a = (int)$current_loan_amount;
                                                            $b = (int)$total_paid_loan_amount;
                                                        ?>
                                                            {{number_format($a - $b, 2, '.', ',') }}
                                                        <?php else : ?>
                                                            {{number_format(0, 2, '.', ',') }}
                                                        <?php endif ?>
                                                    </span>
                                                </div>
                                                <div role="separator" class="dropdown-divider"></div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-3" style="max-width: 20%;">
                                            <div class="info-box mb-3">
                                                <span class="info-box-icon bg-info elevation-1"><i class="fa fa-list"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Total Paid</span>
                                                    <span class="info-box-number ">
                                                        <?php if (!empty($total_paid_loan_amount) > 0) : ?>
                                                            {{number_format($total_paid_loan_amount, 2, '.', ',') }}
                                                        <?php else : ?>
                                                            {{number_format(0, 2, '.', ',') }}
                                                        <?php endif ?>
                                                    </span>
                                                </div>
                                                <div role="separator" class="dropdown-divider"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 backToFolderList" style="padding:0px;">
                                        <h5 class='col-md-6 text-left float-left' style="margin-top:10px; padding:0px; cursor: pointer;">
                                            <i class="fa fa-bars"></i>
                                            Loan & Advance
                                        </h5>
                                    </div>
                                    <table id="loanListTable" class="table table-striped table-bordered loanListTable" cellspacing="0" style="font-size:12px; border: none;">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope='col' style='border:1px solid #ddd !important;'>#</th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>Date </th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>No of Installment </th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>Loan Amount </th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>Paid </th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>Due </th>
                                                <th scope='col' style='border:1px solid #ddd !important;'>Deduction Policy </th>
                                                <th scope='col' style='border:1px solid #ddd !important;'> Status </th>
                                                <th scope='col' style='border:1px solid #ddd !important;'> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($employee_loan_info)) : ?>
                                                <?php $i = 0;
                                                foreach ($employee_loan_info as $key => $loan) :
                                                    $i++;
                                                    if ($loan['loan_deduct_policy'] == 1) {
                                                        $loan_policy = 'Auto';
                                                    } else {
                                                        $loan_policy = 'Manual';
                                                    }
                                                ?>
                                                    <tr role="row" class="odd">
                                                        <td class="text-center sorting_1">
                                                            {{$i}}
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                            echo date('d M Y', strtotime($loan['disburse_date']));
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            {{$loan['no_of_installment']}}
                                                        </td>
                                                        <td class="text-right">
                                                            {{$loan['loan_amount']}}
                                                        </td>
                                                        <td class="text-right">
                                                            {{$loan['paid_amount']}}
                                                        </td>
                                                        <td class="text-right">
                                                            {{$loan['loan_amount']-$loan['paid_amount']}}
                                                        </td>
                                                        <td class="text-center">
                                                            {{$loan_policy}}
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if ($loan['loan_clearance_status'] == 1) : ?>
                                                                <span style="color:green;">Clear</span>
                                                            <?php else : ?>
                                                                <span style="color:red;">Not Clear</span>
                                                            <?php endif ?>
                                                            <!-- {{$loan['loan_clearance_status']}} -->
                                                        </td>
                                                        <td class="text-center">
                                                            <a title="Schedule" class="btn btn-xs btn-info loan_schedule_modal" href="#" data-toggle="modal" data-target="#loan_schedule_modal" data-whatever="@getbootstrap" data-loan_id="<?php echo $loan['id']; ?>" data-employee_id="<?php echo $loan['employee_id']; ?>">
                                                                <i class="fa fa-calendar"></i> Schedule
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php else : ?>
                                                <?php echo "No Data Found!"; ?>
                                            <?php endif ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade home-min-height" id="kpi-performance" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="w-100 d-flex justify-content-center align-items-center">
                                <div class="spinner"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade home-min-height" id="employee-directory" role="tabpanel" aria-labelledby="tab5">
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
                                                $official_mobile = isset($employee_data['official_mobile_no']) ? $employee_data['official_mobile_no'] : '';
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






        <!-- Others Contact Info Modal -->
        <div class="modal fade" id="changeProfileModal" tabindex="-1" role="dialog" aria-labelledby="changeProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 50%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeProfileModalLabel">Update Profile Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="panel-group" id="accordion">
                            <div class="card">
                                <div class="card-header panel-heading" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <h5 class="mb-0">
                                        <a style="margin:0px; color:#000;" class="btn btn-link">
                                            <i class="more-less fa fa-minus"></i>
                                            <strong>General Information</strong>
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion" style="margin-bottom: 10px;">
                                    <div class="card-body">
                                        <form id="generalInfoForm">
                                            <label for="current-password" class="col-sm-4 control-label float-left">Personal Email</label>
                                            <div class="col-sm-8 float-left">
                                                <div class="form-group">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input id="personal_email" type="email" class="form-control" name="personal_email_id" placeholder="Email ID" required>
                                                </div>
                                            </div>
                                            <label for="password" class="col-sm-4 control-label float-left">Personal Mobile</label>
                                            <div class="col-sm-8 float-left">
                                                <div class="form-group">
                                                    <input id="personal_mobile" type="number" class="form-control" name="personal_mobile_no" placeholder="Mobile No.">
                                                </div>
                                            </div>
                                            <label for="password_confirmation" class="col-sm-4 control-label float-left">WhatsApp</label>
                                            <div class="col-sm-8 float-left">
                                                <div class="form-group">
                                                    <input id="whats_app" type="text" class="form-control" id="password_confirmation" name="whatsapp" placeholder="WhatsApp">
                                                </div>
                                            </div>
                                            <label for="password_confirmation" class="col-sm-4 control-label float-left">Desk Phone</label>
                                            <div class="col-sm-8 float-left">
                                                <div class="form-group">
                                                    <input id="desk_phone" type="number" class="form-control" id="password_confirmation" name="desk_phone" placeholder="Desk Phone">
                                                </div>
                                            </div>
                                            <label for="password_confirmation" class="col-sm-4 control-label float-left">Skype</label>
                                            <div class="col-sm-8 float-left">
                                                <div class="form-group">
                                                    <input id="skype_no" type="text" class="form-control" name="skype_no" placeholder="Skype">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <button id="general_info_submit" type="submit" class="btn btn-success float-right">Request</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header panel-heading" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <h5 class="mb-0">
                                        <a style="margin:0px; color:#000;" class="btn btn-link collapsed">
                                            <i class="more-less fa fa-plus"></i>
                                            <strong>Educational Information</strong>
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        Under Development Educational Information
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header panel-heading" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <h5 class="mb-0">
                                        <a style="margin:0px; color:#000;" class="btn btn-link collapsed">
                                            <i class="more-less fa fa-plus"></i>
                                            <strong>Training Information</strong>
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        Under Development Training Information
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- </div> -->
                        <!--  <div class="form-group">
    <div class="col-sm-offset-5 col-sm-6">
      <button type="submit" class="btn btn-danger">Submit</button>
    </div>
  </div> -->

                    </div>
                    <div class="modal-footer" style="padding: 10px 35px;">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                        <!-- <button type="submit" class="btn btn-success">Submit</button> -->
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-- changeProfileModal -->

        <div class="modal fade" id="birthdayList" tabindex="-1" role="dialog" aria-labelledby="birthdayListLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 30%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="birthdayListLabel"><i class="fa fa-birthday-cake"></i> Birthday List</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-bordered leave-table" cellspacing="0" width="100%" style="font-size:12px;">
                            <thead>
                                <tr>
                                    <th colspan="5">
                                        Today Birthday
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($today_birthday_info) > 0) {

                                    $i = 0;
                                    foreach ($today_birthday_info as $key => $value) :
                                        $i++;
                                ?>
                                        <tr>
                                            <td><i class="fa fa-user"></i></td>
                                            <td class="text-left"><?php echo $value['employee_fullname']; ?></td>
                                            <td class="text-left"><?php echo $value['designation_name']; ?></td>
                                            <td class="text-left"><?php echo $value['department_name']; ?></td>
                                        </tr>
                                    <?php
                                    endforeach;
                                } else {  ?>
                                    <tr>
                                        <td rowspan="4"> No Data Found! </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer" style="padding: 10px 35px;">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                        <!-- <button type="submit" class="btn btn-success">Submit</button> -->
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>


        <div class="modal fade" id="NoticeList" tabindex="-1" role="dialog" aria-labelledby="birthdayListLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="col-md-3 modal-title" id="birthdayListLabel" style="padding-left: 0px;"><i class="fa fa-bell"></i> Notice</h5>
                        <div class="col-md-8 text-right detailsNotice" style="display: none; width: 25%;">
                            <a href="#" id="backToNlist" style="color: #000;"><i class="fa fa-backward"></i> Back</a>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="allNotice" class="table table-striped table-bordered leave-table" cellspacing="0" width="100%" style="font-size:12px;">
                            <!--  <thead >
        <tr>
          <th colspan="5">
            Today Birthday
          </th>
        </tr>
      </thead> -->
                            <tbody>
                                <?php
                                if (count($notices) > 0) {

                                    $i = 0;
                                    foreach ($notices as $key => $value) :

                                        // echo "<pre>"; print_r($notices); die();
                                        $i++;
                                ?>
                                        <tr>
                                            <td><i style="color: orange;" class="fa fa-bell"></i></td>
                                            <td style="text-align: left;"><?php echo $value['notice_title']; ?></td>
                                            <td style="text-align: left;">
                                                <p style="text-overflow: ellipsis;text-align: left;width: 182px;overflow: hidden;white-space: nowrap;"> <?php echo limit_text($value['notice_details'], 10); ?> </p>
                                            </td>
                                            <!-- limit_text -->
                                            <td>
                                                <a href="#" style="color: orange;" id="viewNoticeDetails" data-notice_title="<?php echo $value['notice_title']; ?>" data-notice_details="{{ $value['notice_details']}}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                } else {  ?>
                                    <tr>
                                        <td rowspan="4"> No Data Found! </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                        <div class="detailsNotice" style="background: #000 !important;" id="detailsNotice" style="display: none;">

                            <h3 id="notice_title">

                            </h3>
                        </div>
                        <div class="detailsNotice" id="detailsNotice" style="display: none;">
                            <p id="notice_details">

                            </p>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding: 10px 35px;">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                        <!-- <button type="submit" class="btn btn-success">Submit</button> -->
                    </div>
                    <!-- </form> -->
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

        <div class="modal fade" id="applyLeave" tabindex="-1" role="dialog" aria-labelledby="applyLeaveLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="min-width: 55%;">
                <form id="leave_application_submit" class="well form-horizontal needs-validation leave-application">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="col-md-10" v-if="add_new_type!=5"><i class="fa fa-bars"></i> Leave Application</h4>
                            <div class=" text-right backToServiceListdiv" style="display: none; width: 25%;">
                                <a href="#" class="backToServiceList" style="color: black;"><i class="fa fa-backward"></i> Back</a>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="resetModal">
                                <span aria-hidden="false">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="modify-wraper modal-body1">
                                <div class="col-md-12">
                                    <div class="row col-md-12" style="padding:5px;">
                                        <div class="col-md-6 employee-info-table" style="padding:0px;">
                                            <table class="table table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding: 0.5rem;">Employee ID</td>
                                                        <td style="padding: 0.5rem;">:</td>
                                                        <td style="padding: 0.5rem;">
                                                            <input type="hidden" name="" value="<?php echo $employee_data['id'] ?>">
                                                            <?php echo isset($employee_data['employee_id_no']) ? $employee_data['employee_id_no'] : '';  ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0.5rem;">Employee Name</td>
                                                        <td style="padding: 0.5rem;">:</td>
                                                        <td style="padding: 0.5rem;"><?php echo isset($employee_data['employee_fullname']) ? $employee_data['employee_fullname'] : ''; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0.5rem;">Designation</td>
                                                        <td style="padding: 0.5rem;">:</td>
                                                        <td style="padding: 0.5rem;"><?php echo isset($employee_data['designation_name']) ? $employee_data['designation_name'] : ''; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0.5rem;">Department</td>
                                                        <td style="padding: 0.5rem;">:</td>
                                                        <td style="padding: 0.5rem;"><?php echo isset($employee_data['department_name']) ? $employee_data['department_name'] : ''; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <input type="hidden" id="employee_sbu_id" value="<?php echo $employee_data['employee_sbu'];?>">
                                                        <td style="padding: 0.5rem;">Company/SBU</td>
                                                        <td style="padding: 0.5rem;">:</td>
                                                        <td style="padding: 0.5rem;"><?php echo isset($employee_data['sbu_name']) ? $employee_data['sbu_name'] : ''; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0.5rem;">Contact Phone</td>
                                                        <td style="padding: 0.5rem;">:</td>
                                                        <td style="padding: 0.5rem;"><?php echo isset($mobile_no) ? $mobile_no : ''; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0.5rem;">Joining Date</td>
                                                        <td style="padding: 0.5rem;">:</td>
                                                        <td style="padding: 0.5rem;"><?php
                                                            if(!empty($employee_data['employee_joining_date'])){
                                                                $joining_date = date("jS M Y", strtotime($employee_data['employee_joining_date']));
                                                            }else{ $joining_date = 'Not Found!';}

                                                            echo isset($joining_date) ? $joining_date : ''; ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-3 leave-info text-center" style="margin:auto;">
                                            <span id="leave_info_div" style="display: none;">
                                                <h5 style="font-size: 16px; font-weight: bold;"><span id="totalDayssNo"></span>/<span id="tleave_day_no"></span> Days of <span id="leave_type_name_id"></span> Leave</h5>
                                                <h5><span id="tremaining_days"></span> days remaining</h5>
                                                <input type="hidden" name="leave_total_day" id="leave_total_day">
                                            </span>
                                            <span id="lv_without_pay" style="font-size: 16px; font-weight: bold;"></span>
                                        </div>
                                        <?php if ($employee_image && file_exists(public_path('images/' . $employee_image))) : ?>
                                            <div class="col-md-3 leave-info text-right d-none d-sm-block">
                                                <samp><img src="{{asset('images/'.$employee_image )}}" class="card-img-top border rounded" style="margin-top: 2px; width: 150px; height: 170px;"></samp>
                                            </div>
                                        <?php else : ?>
                                            <div class="col-md-3 leave-info text-right d-none d-sm-block">
                                                <img src="{{asset('images/default.png')}}" style="margin-top: 2px; width: 150px; height: 170px;">
                                            </div>
                                        <?php endif ?>
                                    </div>
                                    <span>
                                        <input name="employee_id" type="hidden" value="<?php echo isset($employee_data['employee_id']) ? $employee_data['employee_id'] : ''; ?>">
                                        <input id="row_id" name="id" type="hidden">
                                        <div class="row" style="margin: 0px;">
                                            <div class="col-md-12" style="padding:0px;">
                                                <div class="col-md-7 float-left" style="padding:0px;">
                                                    <div class="row form-group col-md-12" style="margin-bottom: 20px !important;">
                                                        <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                            <label class="control-label">Leave Type <span class="required_sign">*</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
                                                            <div class="input-group" id="leave_type_id_select2">
                                                                <select id="leave_type_id" name="leave_type" class="js-example-basic-single" name="state">
                                                                    <option selected>--Select--</option>
                                                                    <?php foreach ($leave_type_info as $key => $value) : ?>
                                                                        <option value="<?php echo $value['leave_type'] ?>"><?php echo $value['leave_type_name'] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group col-md-12" style="margin-bottom: 20px !important;">
                                                        <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                            <label class="control-label">Date <span class="required_sign">*</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
                                                            <div class="form-group datepicker-container">
                                                                <div class="col-md-6 float-left date-from-mobile" style="padding: 0px;">
                                                                    <div class="input-group">
                                                                        <div class="col-md-12" style="padding: 0px;">
                                                                            <input id="change_leave_from_date" name="leave_from_date" type="date" style="width: 100%;">
                                                                            <input name="add_new_type" value="1" type="hidden" style="width: 100%;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 float-left" style="padding: 0px;">
                                                                    <div class="input-group">
                                                                        <div class="col-md-12" style="padding: 0px;">
                                                                            <input id="change_leave_to_date" name="leave_to_date" type="date" style="width: 100%;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group col-md-12" style="margin-bottom: 20px !important;">
                                                        <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                            <label class="control-label">Reason for Leave <span class="required_sign">*</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
                                                            <div class="input-group">
                                                                <textarea name="leave_reason" placeholder="" required="required" type="text" class="form-control leave_reason_text"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group col-md-12" style="margin-bottom: 20px !important;">
                                                        <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                            <label class="control-label">Address, on Leave
                                                            </label>
                                                        </div>
                                                        <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
                                                            <div class="input-group">
                                                                <textarea name="address_leave" placeholder="" class="form-control address_on_leave"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group col-md-12" style="margin-bottom: 20px !important;">
                                                        <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                            <label class="control-label">Responsible
                                                                <!-- <span class="required_sign">*</span> -->
                                                            </label>
                                                        </div>
                                                        <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
                                                            <div class="input-group">
                                                                <select name="leave_reliever" id="mySelectResponsible" class="js-example-basic-single" name="state">
                                                                    <option>--Select--</option>
                                                                    <?php foreach ($all_employee_data as $key => $value) : ?>
                                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['text']; ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group col-md-12" style="margin-bottom: 20px !important;">
                                                        <div class="col-md-4 float-left" style="padding-left: 0px;padding-right: 0px;">
                                                            <label class="control-label">Respon. Contact
                                                                <!-- <span class="required_sign">*</span> -->
                                                            </label>
                                                        </div>
                                                        <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
                                                            <div class="input-group">
                                                                <input id="rsp_employee_mobile" name="leave_reliever_contact"   type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-5 float-left" style="padding:0px;">
                                                    <table id="dtBasicExample" class="table table-striped table-bordered leave-table" cellspacing="0" width="100%" style="font-size:12px;">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="5" class="th-sm text-left">
                                                                    <i class="fa fa-calendar"></i>
                                                                    My Leave
                                                                </th>
                                                            </tr>
                                                            <tr class="text-center;" style="border: 1px solid #ddd;">
                                                                <th style="width: 20%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);">Type</th>
                                                                <th style="width: 16%;text-align: center;vertical-align: middle;background: #f5f5f5;">Entitle.</th>
                                                                <th style="width: 18%;text-align: center;vertical-align: middle;background: #f5f5f5;">Prv. Balance</th>
                                                                <th style="width: 18%;text-align: center;vertical-align: middle;background: #f5f5f5;">T. Entitle.</th>
                                                                <th style="width: 15%;text-align: center;vertical-align: middle;background: #f5f5f5;">Availed</th>
                                                                <th style="width: 15%;text-align: center;vertical-align: middle;background: #f5f5f5;">Balance</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach ($leaveInfo as $key => $form_data) : ?>
                                                            <tr>
                                                                <td style="padding:7px 0px;">{{ $form_data['leave_type_name']  }}</td>
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
                                                            </tr>
                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="row form-group col-md-12" style="margin-bottom: 0px !important;">
                                                        <div class="col-md-12 float-left" style="padding-left: 0px;">
                                                            <label class="control-label">Upload Attachment</label>
                                                        </div>
                                                        <div class="col-md-12 float-left inputGroupContainer" style="padding-left: 0px !important; margin-bottom: 10px;">
                                                            <div class="col-md-4 inputGroupContainer float-left" style="padding-left: 0px !important;">
                                                                <input name="leave_attachment" type="file">
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                    <p style="margin:0px;">
                                                        <span id="rsp_designation_name">
                                                    </p>
                                                    <p style="margin:0px;">
                                                        <span id="rsp_sbu_name"></span>
                                                    </p>
                                                </div>
                                            </div>
                                            <input type="hidden" name="apply_type" value="1" class="lwutpay">
                                            <input type="hidden" name="leave_holiday" value="0" checked="checked" class="leave_holiday">
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer leave-modal-footer">
                            <div class="form-actions col-md-12">
                                <div class="form-actions col-md-8" style="float: right;padding:0px;">
                                    <input id='send_leave_request' type="submit" tabindex="4" value="Send Request" class="btn btn-sm btn-info float-right col-md-3" style="font-size: 14px; padding-bottom: 3px; margin-left:10px;">

                                    <input id='update_leave_request' type="submit" tabindex="4" value="Update Request" class="btn btn-sm btn-info float-right col-md-3" style="font-size: 14px; padding-bottom: 3px; margin-left:10px; display:none;">

                                    <!-- d-none d-sm-block -->

                                    <input title="Leave Form Preview" data-toggle="modal" data-target="#leaveForm " data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" tabindex="4" value="Leave Form" class="btn btn-sm btn-success leaveForm  float-right col-md-3" style="font-size: 14px; padding: 3px 20px">

                                    <button type="button" class="btn btn-sm btn-default float-right col-md-3 close" data-dismiss="modal" aria-label="Close" style="font-size: 14px; margin-top: 0px;background: #e9e9e9;    padding: 6px;margin-right: 10px;    color: #000;border: 1px solid #aaa;">Cancel</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Leave form start -->
    <div class="modal fade" id="leaveForm" tabindex="-1" role="dialog" aria-labelledby="leaveCalendarLabel" aria-hidden="true">
        <div class="modal-dialog leave-form-style" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leaveCalendarLabel">
                        <i class="fa fa-bars"></i>
                        Leave Form
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick = "resetModel">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div role="dialog" aria-modal="true" class="v--modal-box v--modal">
                    <div>
                        <div class="modify-wraper modal-body1">
                            <div class="col-md-12">
                                <span>
                                    <div class="row form-group">
                                        <div class="col-md-10"></div>
                                        <div class="col-md-2">
                                            <button id="clickBtnLFPrint" data-toggle="modal" data-target="#myModal1" class="btn-xs btn-success">
                                                <i class="fa fa-print"></i>
                                                Print
                                            </button>
                                        </div>
                                    </div>
                                    <div id="LFListPrint" style="margin-left: 15px; font-size: 12px; margin-right: 15px; margin-top: 0px;">
                                        <table width="98%" cellspacing="0" border="0" cellpadding="7" class="table printTable" style="margin-bottom: -10px;">
                                            <tbody style="border: 0px solid rgb(52, 58, 64);">
                                                <tr valign="bottom">
                                                    <td width="105" style="background: transparent; vertical-align: middle; border-top:0px;">
                                                        <p>
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
                                                            <!-- <img src="company_logo/group_company_logo.png" width="100" height="60"> -->
                                                        </p>
                                                    </td>
                                                    <td colspan="5" width="461" style="background: transparent; vertical-align: middle; border: none !important;">
                                                        <p align="center" style="vertical-align: middle; margin: 0px;"><span style="font-family: Arial, serif;"><strong><span style="font-size: 20px;">Gemcon Group</span></strong>
                                                            </span>
                                                        </p>
                                                        <p align="center" style="margin-bottom: 0rem;"><span style="font-family: Arial, serif; font-size: 18px; margin-top: -15px !important;"><strong>{{isset($employee_data['sbu_name'])?$employee_data['sbu_name']:''}}</strong></span></p>
                                                        <p align="center" style="margin:0px;"><span style="font-family: Arial, serif; font-size: 15px; margin: 0px !important;"><strong>Leave Application Form</strong></span></p>
                                                    </td>

                                                </tr>
                                                <tr valign="bottom" style="">
                                                    <td colspan="7" width="560" style="background: transparent; border: none !important;">
                                                        <p align="right" style="vertical-align: middle; margin: 0px 0px 9px;"><span><strong> Employee ID: <?php echo $employee_data['employee_id_no']; ?>
                                                        </strong>
                                                    </span></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table width="98%" cellspacing="0" border="0" cellpadding="7" class="table">
                                            <tbody style="border: 1px solid rgb(52, 58, 64) !important;">
                                                <tr>
                                                    <td style="width: 32%; border-top: 1px solid rgb(52, 58, 64);"><strong> Applicant's Name </strong></td>
                                                    <td style="width: 1%; border-top: 1px solid rgb(52, 58, 64);"><strong>:</strong></td>
                                                    <td colspan="5" style="width: 85%; border-top: 1px solid rgb(52, 58, 64);"><strong><?php echo $employee_data['employee_fullname']; ?></strong></td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64) !important;">
                                                <tr>
                                                    <td style="width: 32%; border-top: 1px solid rgb(52, 58, 64);"><strong> Employee Status </strong></td>
                                                    <td style="width: 1%; border-top: 1px solid rgb(52, 58, 64);"><strong>:</strong></td>
                                                    <td colspan="5" style="width: 85%; border-top: 1px solid rgb(52, 58, 64);">

                                                        <?php
                                                            if($employee_data['employee_type'] == 1){
                                                                echo 'Permanent';
                                                            }
                                                            elseif($employee_data['employee_type'] == 2){
                                                                echo 'Probationary';
                                                            }
                                                            elseif($employee_data['employee_type'] == 3){
                                                                echo 'Cotractual';
                                                            }
                                                            elseif($employee_data['employee_type'] == 4){
                                                                echo 'Casual';
                                                            }
                                                            elseif($employee_data['employee_type'] == 5){
                                                                echo 'Temporary';
                                                            }
                                                            elseif($employee_data['employee_type'] == 6){
                                                                echo 'Intern';
                                                            }else{
                                                                echo '';
                                                            }
                                                        ?>

                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td style="width: 14%; border-top: 1px solid rgb(52, 58, 64);"><strong>Designation </strong></td>
                                                    <td style="width: 1%; border-top: 1px solid rgb(52, 58, 64);"><strong>:</strong></td>
                                                    <td colspan="5" style="width: 85%; border-top: 1px solid rgb(52, 58, 64);"> <?php echo $employee_data['designation_name']; ?> </td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td style="width: 14%; border-top: 1px solid rgb(52, 58, 64);"><strong>Department </strong></td>
                                                    <td style="width: 1%; border-top: 1px solid rgb(52, 58, 64);"><strong>:</strong></td>
                                                    <td colspan="5" style="width: 85%; border-top: 1px solid rgb(52, 58, 64);"> <?php echo $employee_data['department_name']; ?> </td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td style="width: 14%; border-top: 1px solid rgb(52, 58, 64);"><strong>Company/Project</strong></td>
                                                    <td style="width: 1%; border-top: 1px solid rgb(52, 58, 64);"><strong>:</strong></td>
                                                    <td colspan="5" style="width: 85%; border-top: 1px solid rgb(52, 58, 64);"> <?php echo isset($employee_data['sbu_name']) ? $employee_data['sbu_name'] : ''; ?> </td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td style="width: 14%; border-top: 1px solid rgb(52, 58, 64);"><strong>Location</strong></td>
                                                    <td style="width: 1%; border-top: 1px solid rgb(52, 58, 64);"><strong>:</strong></td>
                                                    <td colspan="5" style="width: 85%; border-top: 1px solid rgb(52, 58, 64);"> <?php echo $employee_data['work_location_name']; ?> </td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td style="width: 14%; border-top: 1px solid rgb(52, 58, 64);"><strong>Date of Joining</strong></td>
                                                    <td style="width: 1%; border-top: 1px solid rgb(52, 58, 64);"><strong>:</strong></td>
                                                    <td colspan="5" style="width: 85%; border-top: 1px solid rgb(52, 58, 64);"> {{ date('d M Y', strtotime($employee_data['employee_joining_date'])) ?? '' }} </td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td style="width: 14%; border-top: 1px solid rgb(52, 58, 64);"><strong>Length of Service</strong></td>
                                                    <td style="width: 1%; border-top: 1px solid rgb(52, 58, 64);"><strong>:</strong></td>
                                                    <td colspan="5" style="width: 85%; border-top: 1px solid rgb(52, 58, 64);"> {{ round($employee_data['service_length'], 1).' Years' ?? '' }} </td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td style="width: 14%; border-top: 1px solid rgb(52, 58, 64);"><strong>Applied for</strong></td>
                                                    <td style="width: 1%; border-top: 1px solid rgb(52, 58, 64);"><strong>:</strong></td>
                                                    <td colspan="5" style="width: 85%; border-top: 1px solid rgb(52, 58, 64);">
                                                        <span class="applied_for1">
                                                            <span style="margin-right: 20px;">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" style="margin: 4px;">Annual Leave
                                                                </label>
                                                            </span>
                                                            <span style="margin-right: 20px;">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" style="margin: 4px;">Casual Leave
                                                                </label>
                                                            </span>
                                                            <span style="margin-right: 20px;"><label class="checkbox-inline">
                                                                    <input type="checkbox" style="margin: 4px;">Sick Leave</label>
                                                            </span>
                                                            <span style="margin-right: 20px;"><label class="checkbox-inline">
                                                                    <input type="checkbox" style="margin: 4px;">Without Pay Leave</label>
                                                            </span>
                                                        </span>

                                                        <span style="margin-right: 20px;" class="applied_for2" style="display:none;">
                                                            <label class="checkbox-inline" id="leave_type_text_lf"></label>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td style="width: 14%; border-top: 1px solid rgb(52, 58, 64);"><strong>Period</strong></td>
                                                    <td style="width: 1%; border-top: 1px solid rgb(52, 58, 64);"><strong>:</strong></td>
                                                    <td colspan="5" style="width: 85%; border-top: 1px solid rgb(52, 58, 64);"><span style="margin-right: 5px; float:left;"><label class="checkbox-inline"><strong> From :</strong></label></span>
                                                        <span style="margin-right: 20px; float:left;">
                                                            <span id="from_date_leave"></span>
                                                            <!-- <input id="from_date_leave" type="text" placeholder="DD / MM / YYYY" name="" style="width: 147px; text-align: center;"> -->
                                                        </span>
                                                        <span style="margin-right: 5px; float:left;"><label class="checkbox-inline"><strong>To :</strong></label></span> <span style="margin-right: 20px; float:left;">
                                                        <span id="to_date_leave"></span>
                                                            <!-- <input id="to_date_leave" type="text" placeholder="DD / MM / YYYY" name="" style="width: 147px; text-align: center;"> -->
                                                        </span> <span style="margin-right: 20px;"><label class="checkbox-inline">
                                                                <strong> Total Days : <span class="totalDayss_no"></span></strong>
                                                            </label></span> <span style="margin-right: 20px;"></span></td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td style="width: 14%; border-top: 1px solid rgb(52, 58, 64);"><strong> Reason </strong></td>
                                                    <td style="width: 1%; border-top: 1px solid rgb(52, 58, 64);"> : </td>
                                                    <td colspan="5" style="width: 85%; border-top: 1px solid rgb(52, 58, 64);" id="leave_reason_id"></td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td style="width: 14%; border-top: 1px solid rgb(52, 58, 64);"><strong> Contact Phone </strong></td>
                                                    <td style="width: 1%; border-top: 1px solid rgb(52, 58, 64);"> : </td>
                                                    <td colspan="5" style="width: 85%; border-top: 1px solid rgb(52, 58, 64);"> <?php echo isset($mobile_no) ? $mobile_no : ''; ?> </td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td style="width: 14%; border-top: 1px solid rgb(52, 58, 64);"><strong> Address, while on Leave </strong></td>
                                                    <td style="width: 1%; border-top: 1px solid rgb(52, 58, 64);"> : </td>
                                                    <td colspan="5" style="width: 85%; border-top: 1px solid rgb(52, 58, 64);" id="addres_while_on_leave"></td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td style="width: 14%; border-top: 1px solid rgb(52, 58, 64);"><strong> Responsibilities hand over to </strong></td>
                                                    <td style="width: 1%; border-top: 1px solid rgb(52, 58, 64);"> : </td>
                                                    <td colspan="5" style="width: 85%; border-top: 1px solid rgb(52, 58, 64);" id="reponsibilities_hand_over_to"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table width="98%" cellpadding="7" class="table">
                                        <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr class="text-center; ">
                                                    <td style="width: 18%;vertical-align: middle;background: rgb(245, 245, 245);border: 1px solid #343a40;" rowspan="5" >
                                                        <strong>Leave Status</strong>
                                                    </td>
                                                    <th style="width: 25%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);">Type</th>
                                                    <th style="width: 14%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);">Entitle.</th>
                                                    <th style="width: 18%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);">Prev. Balance</th>
                                                    <th style="width: 18%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);">Total Entitle.</th>
                                                    <th style="width: 14%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);">Availed</th>
                                                    <th style="width: 14%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);">Balance</th>
                                                </tr>
                                                <?php foreach ($leaveInfo as $key => $form_data) : ?>
                                                <tr>
                                                    <td style="width: 14%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);">{{ $form_data['leave_type_name']  }}</td>
                                                    <td style="width: 14%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);" class="text-center">{{ $form_data['entitlementThisYear'] }}
                                                    </td>
                                                    <td style="width: 14%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);" class="text-center">
                                                    {{ $form_data['previousBalance'] }}
                                                    </td>
                                                    <td style="width: 14%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);" class="text-center">
                                                    {{ $form_data['totalEntitlement'] }}
                                                    </td>
                                                    <td style="width: 14%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);" class="text-center">{{ $form_data['totalDay'] }}</td>
                                                    <td style="width: 14%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);" class="text-center">{{ $form_data['balance'] }}</td>
                                                </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                        <table width="100%" cellspacing="0" border="0" cellpadding="7" class="table">
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td colspan="7" valign="bottom" width="676" style="background: transparent; border: none !important;">

                                                    </td>
                                                </tr>
                                                <tr valign="bottom">
                                                    <td colspan="3" width="320" style="background: transparent; text-align: left; border: none !important;"><strong> Signature of HR Personnel </strong></td>
                                                    <td colspan="4" width="400" style="background: transparent; border: none !important; text-align: right;"><strong> Signature of Applicant with date </strong></td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td colspan="7" width="676" style="background: rgb(245, 245, 245); text-align: center; border-top: 1px solid rgb(52, 58, 64);"> Recommendation (By Immediate Supervisor): </td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td colspan="7" style="background: transparent; border-top: 1px solid rgb(52, 58, 64); padding:0px;"><span style="margin-right: 20px; margin-left: 30%; padding:0px;"><label class="checkbox-inline"><input type="checkbox" style="margin: 4px;">Recommended</label></span> <span style=""><label class="checkbox-inline"><input type="checkbox" style="margin: 4px;">Not Recommended</label></span></td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td rowspan="2" width="105" style="background: transparent; vertical-align: middle; border-top: 1px solid rgb(52, 58, 64); width:30%;"> Reason, if not recommended </td>
                                                    <td rowspan="2" width="105" style="background: transparent; vertical-align: middle; border-top: 1px solid rgb(52, 58, 64);"> : </td>
                                                    <td colspan="5" rowspan="2" valign="bottom" width="557" style="background: transparent; border-top: 1px solid rgb(52, 58, 64);"> &nbsp; </td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr valign="bottom">
                                                    <td width="105" height="2" style="background: transparent; border-top: 1px solid rgb(52, 58, 64); border-left: 1px solid rgb(52, 58, 64);">

                                                    </td>
                                                    <td width="84" style="background: transparent; border-top: 1px solid rgb(52, 58, 64);">

                                                    </td>
                                                    <td width="78" style="background: transparent; border-top: 1px solid rgb(52, 58, 64);">

                                                    </td>
                                                    <td width="98" style="background: transparent; border-top: 1px solid rgb(52, 58, 64);">

                                                    </td>
                                                    <td width="70" style="background: transparent; border-top: 1px solid rgb(52, 58, 64);">

                                                    </td>
                                                    <td width="76" style="background: transparent; border-top: 1px solid rgb(52, 58, 64);">

                                                    </td>
                                                    <td width="82" style="background: transparent; border-top: 1px solid rgb(52, 58, 64); ">

                                                    </td>
                                                </tr>
                                                <tr valign="bottom">
                                                    <td colspan="4" style="background: transparent; width: 14%; border: none !important;"><strong> Name :
                                                       <?php
                                                            if(!empty($approvalfristId->employee_fullname) && $approval2ndId){
                                                                echo $approvalfristId->employee_fullname .' ['. $approvalfristId->employee_id_no .']';
                                                            }else{
                                                                echo '';
                                                            }
                                                       ?>

                                                    </strong>

                                                    </td>
                                                    <td colspan="3" width="368" style="background: transparent; border: none !important; text-align: right;"><strong>Signature with date</strong></td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td colspan="7" width="676" style="background: rgb(245, 245, 245); text-align: center; border-top: 1px solid rgb(52, 58, 64);"> Approval: (By Director/CEO/COO/Head of Department/Project In charge) </td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td colspan="7" style="background: transparent; border-top: 1px solid rgb(52, 58, 64); padding:0px"><span style="margin-right: 20px; margin-left: 36%;"><label class="checkbox-inline"><input type="checkbox" style="margin: 4px;">Approved</label></span> <span style="margin-right: 30%;"><label class="checkbox-inline"><input type="checkbox" style="margin: 4px;">Not Approved</label></span></td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr>
                                                    <td rowspan="2" width="105" style="background: transparent; border-top: 1px solid rgb(52, 58, 64); vertical-align: middle; padding: 0px 10px; width:25%;"> Reason, if not approved </td>
                                                    <td rowspan="2" width="105" style="background: transparent; border-top: 1px solid rgb(52, 58, 64); vertical-align: middle;"> : </td>
                                                    <td colspan="5" rowspan="2" valign="bottom" width="557" style="background: transparent; border-top: 1px solid rgb(52, 58, 64);"> &nbsp; </td>
                                                </tr>
                                            </tbody>
                                            <tbody style="border: 1px solid rgb(52, 58, 64);">
                                                <tr valign="bottom">
                                                    <td width="105" height="4" style="background: transparent; border-top: 1px solid rgb(52, 58, 64);">

                                                    </td>
                                                    <td width="84" style="background: transparent; border-top: 1px solid rgb(52, 58, 64);">

                                                    </td>
                                                    <td width="78" style="background: transparent; border-top: 1px solid rgb(52, 58, 64);">

                                                    </td>
                                                    <td width="98" style="background: transparent; border-top: 1px solid rgb(52, 58, 64);">

                                                    </td>
                                                    <td width="70" style="background: transparent; border-top: 1px solid rgb(52, 58, 64);">

                                                    </td>
                                                    <td width="76" style="background: transparent; border-top: 1px solid rgb(52, 58, 64);">

                                                    </td>
                                                    <td width="82" style="background: transparent; border-top: 1px solid rgb(52, 58, 64);">

                                                    </td>
                                                </tr>
                                                <tr valign="bottom" style="border-top: 0px solid rgb(0, 0, 0);">
                                                     <td rowspan="3" colspan="4" style="background: transparent; width: 14%; border: none !important;"><strong> Name :</strong> <strong>
                                                     <?php
                                                            if(!empty($approval2ndId->employee_fullname)){
                                                                echo $approval2ndId->employee_fullname .' ['. $approval2ndId->employee_id_no .']';
                                                            }else{
                                                                if(!empty($approvalfristId->employee_fullname)){
                                                                    echo $approvalfristId->employee_fullname .' ['. $approvalfristId->employee_id_no .']';
                                                                }else{
                                                                    echo '';
                                                                }
                                                            }
                                                       ?>
                                                        </strong></td>
                                                    <td colspan="4" width="368" style="background: transparent; border: none !important; text-align: right;"><strong>Signature with date</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px 35px;">
                </div>
            </div>
        </div>
    </div>
    <!-- Leave form end -->




    <div class="modal fade" id="leaveCalendar" tabindex="-1" role="dialog" aria-labelledby="leaveCalendarLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leaveCalendarLabel">Service Calendar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="min-height: 600px;">
                    <div id='calendar'></div>
                    <div class="container theme-showcase">
                        <div id="holder" class="row"></div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px 35px;">
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
                        <div class=" text-right backToServiceListdiv" style="display: none; width: 25%;">
                            <a href="#" class="backToServiceList" style="color: black;"><i class="fa fa-backward"></i> Back</a>
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
                                        <div class="col-md-8 float-left inputGroupContainer" style="padding:0px;">
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
                                        <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
                                            <div class="form-group datepicker-container">
                                                <div class="col-md-6 float-left" style="padding: 0px;">
                                                    <div class="input-group">
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <input name="service_date_from" type="date" style="width: 100%;">
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

    <div class="modal fade" id="manualAttendanceRequest" tabindex="-1" role="dialog" aria-labelledby="manualAttendanceLabel" aria-hidden="true">
        <form id="manualAttendance_request_submit" class="well form-horizontal needs-validation leave-application">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title col-md-8" id="manualAttendanceLabel">
                            <i class="fa fa-list"></i>
                            Manual Attendance
                        </h5>
                        <div class="text-right backToServiceListdiv" style="display: none; width: 25%;">
                            <a href="#" class="backToServiceList" style="color: black;"><i class="fa fa-backward"></i> Back</a>
                        </div>
                        <div class="text-right backToServiceCalendar" style="display: none; width: 25%;">
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
                                        <div class="col-md-8 float-left inputGroupContainer" style="padding:0px;">
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
                                        <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
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
                                        <div class="col-md-8 float-left inputGroupContainer" style="padding:0px;">
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
                                        <div class="col-md-8 float-left inputGroupContainer" style="padding:0px;">
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

    <div class="modal fade" id="addNoteRequest" tabindex="-1" role="dialog" aria-labelledby="addNoteRequestLabel" aria-hidden="true">
        <form id="addNoteRequest_request_submit" class="well form-horizontal needs-validation leave-application">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title col-md-9" id="addNoteRequestLabel">
                            <i class="fa fa-list"></i>
                            Add Note / Early Out
                        </h5>
                        <div class=" text-right backToServiceListdiv" style="display: none; width: 25%;">
                            <a href="#" class="backToServiceList" style="color: black;"><i class="fa fa-backward"></i> Back</a>
                        </div>
                        <div class="text-right backToServiceCalendar" style="display: none; width: 25%;">
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
                                            <label class="control-label">Note Issues<span class="required_sign">*</span>
                                            </label>
                                        </div>
                                        <div class="col-md-8 float-left inputGroupContainer" style="padding:0px;">
                                            <div class="input-group service_select">
                                                <select name="add_note_issues" name="state" style="padding-left:5px; height: 27px; border-radius:.25rem;">
                                                    <option>--Select--</option>
                                                    <?php foreach ($note_issues as $key => $value) : ?>
                                                        <option value="{{$value['id']}}">{{$value['note_issue']}}</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                        <div class="col-md-4 float-left" style="padding-left: 0px;">
                                            <label class="control-label">Note Date <span class="required_sign">*</span>
                                            </label>
                                        </div>
                                        <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
                                            <div class="form-group datepicker-container">
                                                <div class="col-md-12 float-left" style="padding-left:0px; padding-right: 0px;">
                                                    <div class="input-group">
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <input class="absent_date_1 absent_date" name="add_note_date" type="date" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                        <div class="col-md-4 float-left" style="padding-left: 0px;">
                                            <label class="control-label">Out/Leave Time <span class="required_sign">*</span>
                                            </label>
                                        </div>
                                        <div class="col-md-8 float-left inputGroupContainer" style="padding:0px;">
                                            <div class="input-group">
                                                <input name="out_time" class="form-control timepicker1" width="100%" style="border:1px solid #aaa !important;" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                        <div class="col-md-4 float-left" style="padding-left: 0px;">
                                            <label class="control-label">Return Time
                                            </label>
                                        </div>
                                        <div class="col-md-8 float-left inputGroupContainer" style="padding:0px;">
                                            <div class="input-group">
                                                <input name="return_time" class="form-control timepicker2" width="100%" style="border:1px solid #aaa !important;" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row  form-group col-md-12" style="margin-bottom: 20px !important; margin:0px;">
                                        <div class="col-md-12 float-left" style="padding-left: 0px;">
                                            <label class="control-label">Remarks/Notes
                                                <!-- <span class="required_sign">*</span> -->
                                            </label>
                                        </div>
                                        <div class="col-md-12 float-left inputGroupContainer" style="padding: 0px;">
                                            <div class="input-group">
                                                <textarea name="add_note_remarks" placeholder="Enter Details" class="form-control" style="height: 100px;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding: 10px 35px; padding-right:25px;">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 2px;background: #e9e9e9;    padding: 5px;margin-right: 3px;    color: #000;border: 1px solid #aaa;    padding-right: 10px;    padding-left: 10px;">Cancel</button>
                        <div class="progress-demo">
                            <!-- <p>
                                <button class="btn btn-danger ladda-button" data-style="expand-right"><span class="ladda-label">expand-right</span></button> -->

                                <!-- <button class="btn btn-danger ladda-button" data-style="expand-left"><span class="ladda-label">expand-left</span></button> -->

                                <!-- <button class="btn btn-danger ladda-button" data-style="contract"><span class="ladda-label">contract</span></button>
                            </p> -->
                            <button type="submit" class="btn btn-info sendRequestBtn ladda-button" data-style="expand-left"><span class="ladda-label">Send Request</span></button>
                        </div>
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
                            General Stationery
                        </h5>
                        <div class=" text-right backToServiceListdiv" style="display: none; width: 25%;">
                            <a href="#" class="backToServiceList" style="color: black;"><i class="fa fa-backward"></i> Back</a>
                        </div>
                        <div class="text-right backToServiceCalendar" style="display: none; width: 25%;">
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
                                        <div class="col-md-8 float-left inputGroupContainer" style="padding:0px;">
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
                                        <div class="col-md-8 float-left inputGroupContainer" style="padding:0px;">
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
                                        <div class="col-md-8 float-left inputGroupContainer" style="padding:0px;">
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
                                        <div class="col-md-7 float-left inputGroupContainer" style="padding: 0px;">
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
                                        <div class="col-md-1 float-left inputGroupContainer general-stationary-add" style="padding-left: 7px;">

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
                        <div class=" text-right backToServiceListdiv" style="display: none; width: 25%;">
                            <a href="#" class="backToServiceList" style="color: black;"><i class="fa fa-backward"></i> Back</a>
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

    <div class="modal fade" id="leaveAdjustment" tabindex="-1" role="dialog" aria-labelledby="serviceRequestLabel" aria-hidden="true">
        <form id="leave_adjustment_submit" class="well form-horizontal needs-validation leave-application">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title col-md-9" id="serviceRequestLabel">
                            <i class="fa fa-list"></i>
                            Leave Adjustment
                        </h5>
                        <div class=" text-right backToServiceListdiv" style="display: none; width: 25%;">
                            <a href="#" class="backToServiceList" style="color: black;"><i class="fa fa-backward"></i> Back</a>
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
                    <div class="text-right service-add-new">
                        <a class="add_new_service_modal text-right btn btn-info" href="#" data-toggle="modal" data-target="#serviceRequest" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">Add New</a>
                    </div>
                    <button type="button" class="close closeServiceList" data-dismiss="modal" aria-label="Close" style="margin-left:0px;">
                        <span aria-hidden="false" style="margin-left:0px;">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input name="employee_id" type="hidden" value="<?php echo $employee_data['employee_id']; ?>">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="row">
                            <div class="col-xs-6 col-md-2 text-left service_request_btn" style = "padding-left: 0px; text-align: center;">
                                    <a class="add_new_service_modal text-right btn btn-default" href="#" data-toggle="modal" data-target="#manualAttendanceRequest" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">Manual Attendance</a>
                                </div>
                                <div class="col-xs-6 col-md-2 text-left service_request_btn" style = "padding-left: 0px; text-align: center;">
                                    <a class="add_new_service_modal text-right btn btn-default" href="#" data-toggle="modal" data-target="#addNoteRequest" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" style="color:#212529; text-decoration: none;">
                                        Add Note / Early Out
                                    </a>
                                </div>
                                <div class="col-xs-6 col-md-2 text-left service_request_btn" style = "padding-left: 0px; text-align: center;">
                                    <a class="add_new_service_modal text-right btn btn-default" href="#" data-toggle="modal" data-target="#generalStationeryRequest" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">General Stationary</a>
                                </div>
                                <div class="col-xs-6 col-md-2 text-left service_request_btn" style = "padding-left: 0px; text-align: center;">
                                    <a class="add_new_service_modal text-right btn btn-default" href="#" data-toggle="modal" data-target="#serviceRequest" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">NOC (No Object. Cert.)</a>
                                </div>
                                <div class="col-xs-6 col-md-2 text-left service_request_btn" style = "padding-left: 0px; text-align: center;">
                                    <a class="add_new_service_modal text-right btn btn-default" href="#" data-toggle="modal" data-target="#serviceRequest" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">Employment Certificate</a>
                                </div>
                                <div class="col-xs-6 col-md-2 text-left service_request_btn" style = "padding-left: 0px; text-align: center;">
                                    <a class="add_new_service_modal text-right btn btn-default" href="#" data-toggle="modal" data-target="#serviceRequest" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">Experience Certificate</a>
                                </div>
                                <div class="col-xs-6 col-md-2 text-left service_request_btn" style = "padding-left: 10px; text-align: center;">
                                    <a class="add_new_service_modal text-right btn btn-default" href="#" data-toggle="modal" data-target="#serviceRequest" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">Salary Certificate</a>
                                </div>
                                <div class="col-xs-6 col-md-2 text-left service_request_btn" style = "padding-left: 0px; text-align: center;">
                                    <a class="add_new_service_modal text-right btn btn-default" href="#" data-toggle="modal" data-target="#serviceRequest" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">Employee Pay Slip</a>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered serviceListTable" cellspacing="0" width="100%" style="font-size:12px; border: none;">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope='col' style='border:1px solid #ddd !important;'>SL</th>
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
    </div>
    <!-- Pay Slip Modal Below -->
    <div class="modal fade" id="pay_slip_modal" tabindex="-1" role="dialog" aria-labelledby="pay_slip_modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-list"></i> Pay Slip</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <table width="100%">
                            <tr>
                                <td colspan="3" style="width: 20%; text-align: right;">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <p><i>Printing Date: <span id="print_date_id"></span></i>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">
                                    <div class="col-md-12">
                                        <img id="sbu_logo" alt="Logo" class="card-img-top  rounded" style="margin-top: 2px; width: 100px; border-radius: 50px;">
                                    </div>
                                </td>
                                <td style="width: 60%; text-align: center;">
                                    <div class="col-md-12 text-center">
                                        <h4>Pay Slip</h4>
                                        <h5>Month of <span id="salary_date_id"></span></h5>
                                    </div>
                                </td>
                                <td style="width: 20%;"></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table width="100%">
                                        <tr>
                                            <td width="50%">
                                                <div class="col-md-12 text-left">
                                                    <h6 id="employee_fullname_id"></h6>
                                                    <span id="designation_name_id"></span>
                                                </div>
                                            </td>
                                            <td style="text-align: right;" width="50%">
                                                <div class="col-md-12 text-right">Employee ID : <span id="employee_id_no_id"></span>
                                                    <br>Location : <span id="work_location_name_id"></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr class="bank_salary_section" class="trs" style="border-top: 1px solid rgb(108, 117, 125); border-bottom: 1px solid rgb(108, 117, 125); background: rgb(238, 238, 238) none repeat scroll 0% 0%; font-size: 15px; font-weight: 600;">
                                <td colspan="2" class="trs" style="padding: 0px 5px;">Gross Salary - Bank</td>
                                <td class="trs" style="text-align: right; padding: 0px 5px;" id="gross_salary_id"></td>
                            </tr>
                            <tr class="bank_salary_section">
                                <td colspan="2" style="padding: 0px 5px;">Arrears/Addition</td>
                                <td style="text-align: right; padding: 0px 5px;" id="total_additions_id"></td>
                            </tr>
                            <tr class="bank_salary_section">
                                <td colspan="2" style="padding: 0px 5px;">Employee PF</td>
                                <td style="text-align: right; padding: 0px 5px;">( <span id="deduction_pfbasic_id"></span> )</td>
                            </tr>
                            <tr class="bank_salary_section">
                                <td colspan="2" style="padding: 0px 5px;">With Holding TAX</td>
                                <td style="text-align: right; padding: 0px 5px;">( <span id="deduction_tax_id"></span> )</td>
                            </tr>
                            <tr class="bank_salary_section">
                                <td colspan="2" style="padding: 0px 5px;">Deduction</td>
                                <td style="text-align: right; padding: 0px 5px;">( <span id="total_deduction_id"></span> )</td>
                            </tr>
                            <tr class="bank_salary_section" class="trs" style="border-top: 1px solid rgb(108, 117, 125); border-bottom: 1px solid rgb(108, 117, 125); background: rgb(238, 238, 238) none repeat scroll 0% 0%; font-size: 15px; font-weight: 600;">
                                <td colspan="2" class="trs" style="padding: 0px 5px;">Net Payable(Bank)</td>
                                <td class="trs" style="text-align: right; padding: 0px 5px;" id="netpay_id"></td>
                            </tr>
                            <tr class="bank_salary_section" style="line-height: 8px;">
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr class="bank_salary_section" class="trs" style="border-top: 1px solid rgb(108, 117, 125); border-bottom: 1px solid rgb(108, 117, 125); background: rgb(238, 238, 238) none repeat scroll 0% 0%; font-size: 15px; font-weight: 600;">
                                <td colspan="2" class="trs" style="padding: 0px 5px;">Opening Balance PF</td>
                                <td class="trs" style="text-align: right; padding: 0px 5px;" id="openigPf_id"></td>
                            </tr>
                            <tr class="bank_salary_section">
                                <td colspan="2" style="padding: 0px 5px;">Employee PF</td>
                                <td style="text-align: right; padding: 0px 5px;" id="Pf_id"></td>
                            </tr>
                            <tr class="bank_salary_section">
                                <td colspan="2" style="padding: 0px 5px;">Company's Contribution PF</td>
                                <td style="text-align: right; padding: 0px 5px;" id="clPf_id"></td>
                            </tr>
                            <tr class="bank_salary_section" class="trs" style="border-top: 1px solid rgb(108, 117, 125); border-bottom: 1px solid rgb(108, 117, 125); background: rgb(238, 238, 238) none repeat scroll 0% 0%; font-size: 15px; font-weight: 600;">
                                <td colspan="2" class="trs" style="padding: 0px 5px;">Closing Balance PF</td>
                                <td class="trs" style="text-align: right; padding: 0px 5px;" id="closingPf_id"></td>
                            </tr>
                            <tr style="line-height: 8px;">
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <table id="salary_type_hide_show" style="display: none;">
                                <tr class="trs" style="border-top: 1px solid rgb(108, 117, 125); border-bottom: 1px solid rgb(108, 117, 125); background: rgb(238, 238, 238) none repeat scroll 0% 0%; font-size: 15px; font-weight: 600;">
                                    <td colspan="2" class="trs" style="padding: 0px 5px;">Gross Salary â€“ Cash</td>
                                    <td class="trs" style="text-align: right; padding: 0px 5px;" id="gross_salary_id_cash"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding: 0px 5px;">Employee PF</td>
                                    <td style="text-align: right; padding: 0px 5px;">( <span id="deduction_pfbasic_id_cash"></span> )</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding: 0px 5px;">Car Allowance</td>
                                    <td style="text-align: right; padding: 0px 5px;" id="car_allowance_id_cash"></td>
                                </tr>
                                <tr class="trs" style="border-top: 1px solid rgb(108, 117, 125); border-bottom: 1px solid rgb(108, 117, 125); background: rgb(238, 238, 238) none repeat scroll 0% 0%; font-size: 15px; font-weight: 600;">
                                    <td colspan="2" class="trs" style="padding: 0px 5px;">Net Payable(Cash)</td>
                                    <td class="trs" style="text-align: right; padding: 0px 5px;" id="netpay_id_cash"></td>
                                </tr>
                            </table>
                            <tr style="line-height: 8px;">
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <hr style="margin-top: 1rem; margin-bottom: 0rem; border-top: 1.6px solid rgb(52, 58, 65);">
                                    <div class="text-center">
                                        <p class="text-center"><i>This is computer generated copy and does not required any signature.</i>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- Pay Slip Modal End -->
    <!-- Loan Schedule Modal Below -->
    <div class="modal fade" id="loan_schedule_modal" tabindex="-1" role="dialog" aria-labelledby="loan_schedule_Label" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-money"></i> Loan Amount: <strong class="loan_amount_id"></strong> </h5>
                    <h5 class="modal-title"> &nbsp;&nbsp;|| &nbsp;&nbsp;<i class="fa fa-money"></i> Total Paid: <strong class="paid_loan_amount_id"></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="col-md-12">
                            <div>
                                <!-- <label class="control-label">Schedule Info:</label> -->
                                <table id="loanListTable" class="table table-hover table-bordered loan_salary_info_table loanListTable" style="width: 100%;">
                                    <thead>
                                        <tr class="text-center;">
                                            <th style="text-align: center; vertical-align: middle; background: rgb(245, 245, 245) none repeat scroll 0% 0%;">SL</th>
                                            <th style="text-align: center; vertical-align: middle; background: rgb(245, 245, 245) none repeat scroll 0% 0%;">Date</th>
                                            <th style="text-align: center; vertical-align: middle; background: rgb(245, 245, 245) none repeat scroll 0% 0%;">Loan</th>
                                            <th style="text-align: center; vertical-align: middle; background: rgb(245, 245, 245) none repeat scroll 0% 0%;">EMI</th>
                                            <th style="text-align: center; vertical-align: middle; background: rgb(245, 245, 245) none repeat scroll 0% 0%;">Rest</th>
                                            <th style="text-align: center; vertical-align: middle; background: rgb(245, 245, 245) none repeat scroll 0% 0%;"> Policy</th>
                                            <th style="text-align: center; vertical-align: middle; background: rgb(245, 245, 245) none repeat scroll 0% 0%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id='loanListAppendData'>

                                    </tbody>
                                    <tfoot>
                                        <th colspan="3" style="text-align: right;">
                                            Loan: <strong class="loan_amount_id" style="color:orange;"></strong>

                                        </th>
                                        <!-- <th>
                                ||
                            </th> -->
                                        <th colspan="2">
                                            Total Paid: <strong class="paid_loan_amount_id" style="color:green;"></strong>
                                        </th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
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
    $("#assets-4").click(function() {
        // alert("You clicked me!");
        $("#kpi-performance").html('<div class="w-100 d-flex justify-content-center align-items-center"><div class="spinner"></div></div>');
        $("#assets").load("/assets_component");
    });

    $("#kpi-performance-tab").click(function() {
        // alert("You clicked me!");
        $("#kpi-performance").html('<div class="w-100 d-flex justify-content-center align-items-center"><div class="spinner"></div></div>');
        $("#kpi-performance").load("/kra_kpi_mos_dashboard_user");
    });
    $(".apply_leave_class").click(function() {
        $("#leave_application_submit")[0].reset();
        $('#send_leave_request').css('display', 'inline');
        $('#update_leave_request').css('display', 'none');
    });

    $('#leave_type_id').on('change', function() {
        var leave_type_text = $("#leave_type_id option:selected").text();
        var leave_type_id = $("#leave_type_id option:selected").val();
        $('#leave_type_text_lf').text(leave_type_text + ' Leave');

        // alert(leave_type_text);

        if (leave_type_text == '--Select--') {
            $('.applied_for1').css('display', 'inline');
            $('.applied_for2').css('display', 'none');
        } else {
            $('.applied_for1').css('display', 'none');
            $('.applied_for2').css('display', 'inline');
        }
        $('#totalDayss').text('');
        $('#change_leave_from_date').val('');
        $('#change_leave_to_date').val('');
        $('#tremaining_days').text('');
        $('.totalDayss_no').text('');
        $('#lv_without_pay').text('');
        $('#leave_info_div').css('display', 'none');
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
        if (window.innerWidth > 600) {
            $('#changePasswordModal').modal({
                backdrop: 'static',
                keyboard: false
            })
            $(window).on('load', function() {
                $('#changePasswordModal').modal('show');
                // $('#attendance_modal').modal('hide');
            });
            $('#changePasswordModal').on('hidden.bs.modal', function() {
                location.reload();
            })
        }
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
        // console.log(leave_type_id);
        var leave_available = <?php echo json_encode($leave_available); ?>;
        var leave_type_info = <?php echo json_encode($leave_type_info); ?>;
        // console.log(leave_available);
        _leave_type_info = leave_type_info.find(data => data.leave_type == leave_type_id);

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
        leave_available = leave_available.find(data => data.leave_type == leave_type_id);
        tleave_day_no = leave_available.leave_remaining;
        // console.log([leave_available, tleave_day_no, totalDayss]);
        // console.log('rrr');
        remaining_days = leave_available.leave_remaining - totalDayss;


        if (tleave_day_no > 0) {
            $('#leave_info_div').css('display', 'inline');
        } else {
            $('#leave_info_div').css('display', 'none');
        }

        var leave_type_text = $('#leave_type_id').find('option:selected').text();
        // alert(leave_type_text);
        $('#totalDayssNo').text(totalDayss);
        $('#tleave_day_no').text(tleave_day_no);
        $('#tremaining_days').text(remaining_days);
        $('#leave_type_name_id').text(leave_type_text);

        var leave_form_date = $('#change_leave_from_date').val();
        var leave_to_date = $('#change_leave_to_date').val();
        // alert(leave_form_date);
        $('#from_date_leave').text(leave_form_date);
        $('#to_date_leave').text(leave_to_date);
        $('.totalDayss_no').text(totalDayss);
        console.log([leave_form_date, leave_to_date, leave_type_id, totalDayss, remaining_days]);
        console.log('fff');
        var employee_id = "<?php echo Auth::guard('user')->user()->employee_id; ?>";
        var employee_sbu = $('#employee_sbu_id').val();
        // var employee_sbu = "<?php //echo Auth::guard('user')->user()->employee_sbu; ?>";
        if((remaining_days) >= 0){
            if(leave_type_id== 1){
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/') }}/_findActualAnnualLeaveDays/",
                    data: {
                        employee_id: employee_id,
                        employee_sbu: employee_sbu,
                        leave_form_date: leave_form_date,
                        leave_to_date: leave_to_date,
                        totalDayss: totalDayss,
                        url_type: 1,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        totalDayss = data.rest_day_except_hw;
                        remaining_days = leave_available.leave_remaining - totalDayss;
                        leave_total_day = totalDayss;
                        $('#leave_total_day').val(leave_total_day);
                        $('#totalDayssNo').text(totalDayss);
                        $('#tremaining_days').text(remaining_days);
                        $('.totalDayss_no').text(totalDayss);
                    },
                    error: function (request, status, error) {
                        console.log(request.responseText);
                    }
                });
            }
            if(leave_type_id == 2){
                if((totalDayss > 3)){
                    alert('Opps! '+leave_type_text+' leave not allowed more than 3 days !');
                    $('#totalDayss').text('');
                    $('#change_leave_from_date').val('');
                    $('#change_leave_to_date').val('');
                    $('#tremaining_days').text('');
                    $('.totalDayss_no').text('');
                    $('#lv_without_pay').text('');
                }else{
                    remaining_days = leave_available.leave_remaining - totalDayss;
                    leave_total_day = totalDayss;
                    $('#leave_total_day').val(leave_total_day);
                }
            }
            if(leave_type_id == 3 || leave_type_id == 5){
                remaining_days = leave_available.leave_remaining - totalDayss;
                leave_total_day = totalDayss;
                    $('#leave_total_day').val(leave_total_day);
            }
        }else{
            if(leave_type_id == 6){
                remaining_days = totalDayss;
                leave_total_day = totalDayss;
                $('#leave_total_day').val(leave_total_day);
                $('#lv_without_pay').text(remaining_days+' Days of Leave without Pay!');
            }else{
                alert('Opps! '+leave_type_text+' leave not available ' + totalDayss + ' Days');
                $('#totalDayss').text('');
                $('#change_leave_from_date').val('');
                $('#change_leave_to_date').val('');
                $('#tremaining_days').text('');
                $('#totalDayssNo').text('');
                $('#leave_info_div').css('display', 'none');
                $('#lv_without_pay').text('');
            }
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
        // event.preventDefault();
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
                    alert('Already leave applied between this date range!');
                    $("#leave_application_submit")[0].reset();
                    $('#select2-leave_type_id-container').text('--select--');
                    $('#select2-mySelectResponsible-container').text('--select--');
                    $('#applyLeave').modal('hide');
                    // document.getElementById("overlay").style.display = "flex";
                    // location.reload();
                }
            },
            error: function() {
                // alert('Error occured!');
                // console.log(data);
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

    $("#addNoteRequest_request_submit").submit(function(e) {
        var formdata = $(this).serialize(); // here $(this) refere to the form its submitting
        $.ajax({
            type: 'POST',
            url: "{{ url('/') }}/sendAddNoteRequest",
            data: formdata, // here $(this) refers to the ajax object not form
            success: function(data) {
                alert('Succesfully Request Submitted!');
                $("#addNoteRequest_request_submit")[0].reset();
                $('#addNoteRequest').modal('hide');
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
        $('#addNoteRequest').modal('hide');
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
        var view_id = $(this).data('view_id');
        // console.log(view_id, 1);

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
                    if(view_id == 1){
                        $('.leave-modal-footer').css('display', 'none');
                    }
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
        } else if (row_type == 5) {
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/findAddNoteData/" + row_id,
                success: function(data) {
                    $("input[id='row_id']").val(row_id);
                    $("select[name='note_issue']").val(data.note_issue).prop('selected', true);
                    $("input[name='add_note_date']").val(data.add_note_date);
                    $("input[name='out_time']").val(data.out_time);
                    $("input[name='return_time']").val(data.return_time);
                    $("textarea[name='add_note_remarks']").val(data.add_note_remarks);
                    $('.backToServiceListdiv').css('display', 'inline');
                    $('.sendRequestBtn').css('display', 'none');
                    $('.updateRequestBtn').css('display', 'inline');
                    $('#serviceList').modal('hide');
                    $('#addNoteRequest').modal('show');
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

        $("#clickBtnPrint").click(function() {
            var cssss = '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" media="screen, print" />';
            w = window.open(null, 'Print_Page', 'scrollbars=yes');
            w.document.write(cssss);
            w.document.write(cssss + jQuery('#pabxListPrint').html());
            w.document.close();
            w.print();
            // setTimeout(w.print(), 1);
        });

        $("#clickBtnEmailPrint").click(function() {
            var cssss = '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" media="screen, print" />';
            w = window.open(null, 'Print_Page', 'scrollbars=yes');
            w.document.write(cssss);
            w.document.write(cssss + jQuery('#emailListPrint').html());
            w.document.close();
            w.print();
            // setTimeout(w.print(), 1);
        });

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
                                    ' <a data-view_id = "1" data-employee_id="' + employee_id + '" data-row_id="' + data.serviceList[i].id + '" data-row_type="' + data.serviceList[i].type_id + '" id="serviceListModal' + j + '" class="serviceListModal" href="#"><i class="fa fa-eye "></i>  </a>' +

                                    cancel_design +
                                    // ' <a style="opacity:0.5"  title="Already Task Completed!" href="#"><i class="fa fa-pencil "></i>  </a>' +

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
        /* Worked at 21/1/2021*/
        $("#folder_grid_hide_show").click(function() {
            $('#folder_grid_hide_show1').css('display', 'inline');
            $('#folder_grid_hide_show').css('display', 'none');
            $(".folder_grid_view").show();
            $(".folder_list_view").hide();
            var view_type = 2;
            $("#folder_view_type").val(view_type);
        });
        $("#folder_grid_hide_show1").click(function() {
            $('#folder_grid_hide_show1').css('display', 'none');
            $('#folder_grid_hide_show').css('display', 'inline');
            $(".folder_grid_view").hide();
            $(".folder_list_view").show();
            var view_type = 1;
            $("#folder_view_type").val(view_type);
        });

        $(".backToFolderList").click(function() {
            $('.folder_list_section').show(500);
            $('.fileListInfo').hide(500);
        });

        $(".folder_all_employee_data_view").click(function() {
            $('.folder_list_section').hide(500);
            folder_id = $(this).data("folder_id");
            folder_name = $(this).data("folder_name");
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/findFileList/" + folder_id,
                success: function(data) {
                    // console.log(data.file_list_data[i]);

                    // j =0;
                    $('#fileListTable').dataTable().fnDestroy();
                    $("#fileListAppendData").find("tr:gt(0)").remove();
                    $('#fileListAppendData').empty();
                    for (var i = 0; i < data.file_list_data.length; i++) {
                        j = i + 1;
                        // j++;
                        if (data.file_list_data[i].file_status == 1) {
                            file_status = 'Active';
                        } else if (data.file_list_data[i].file_status == 2) {
                            file_status = 'Inactive';
                        }

                        if (data.file_list_data[i].email_notify == 1) {
                            Emailed = 'Emailed';
                        } else if (data.file_list_data[i].email_notify == 2) {
                            Emailed = 'Not Emailed';
                        } else {
                            Emailed = 'Not Emailed';
                        }

                        $('#fileListAppendData').append(
                            '<tr class="text-center">' +
                            '<td>' + j + '</td>' +
                            '<td class="text-left"> <i class="fa fa-file" aria-hidden="false"></i> ' + data.file_list_data[i].file_name + '</td>' +
                            '<td class="text-left">' + data.file_list_data[i].type_name + '</td>' +
                            '<td>' + data.file_list_data[i].expiration_date + '</td>' +
                            '<td>' + data.file_list_data[i].notification_period + '</td>' +
                            '<td>' + Emailed + '</td>' +
                            '<td>' + data.file_list_data[i].file_size + '</td>' +
                            '<td>' + file_status + '</td>' +
                            '<td style="width: 20%;">' +
                            '<a class="viewDownloadAttachment" data-file_id="' + data.file_list_data[i].id + '" data-type="1" target="_blank" title="View" href="/document_file/' + data.file_list_data[i].file_attachment + '"> <i class="fa fa-eye"></i> View </a> | ' +
                            '<a class="viewDownloadAttachment" data-file_id="' + data.file_list_data[i].id + '" data-type="2" download title="Download" target="_blank" href="/document_file/' + data.file_list_data[i].file_attachment + '"><i class="fa fa-download"></i> Download </a>' +
                            '</td>' +
                            '</tr>'
                        );
                    }
                    $('#fileListTable').dataTable({
                        "destroy": true,
                        "pageLength": 5,
                        "bLengthChange": false,
                        "bFilter": true,
                        "bInfo": false,
                        "bAutoWidth": false
                    });

                    $('.fileListInfo').show(500);
                },
                error: function() {
                    // alert('Error occured!');
                    console.log('Error occured!');
                }
            });
        });


        $(document).on('click', '.viewDownloadAttachment', function() {
            // alert('file_id');
            var file_id = $(this).data("file_id");
            var action_type = $(this).data("type");
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/veiw_or_download/file_access_log/" + file_id + '/' + action_type,
                success: function(data) {
                    // console.log(data);
                },
                error: function() {
                    alert('Error occured!');
                }
            });
        });
        /* Worked at 21/1/2021*/
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


    $('#carouselNotice').on('slide.bs.carousel', function() {
        var ele = $('#carouselNotice div.active');
        $(".announcement_sl").text(ele.data('value'));
        $(".announcement_view_value").val(ele.data('noticeid'));
        var notice_id = $('.announcement_view_value').val();
        // console.log(notice_id_old);
        // console.log(notice_id);
        if(notice_id){
            var user_employee_id = "<?php echo Auth::guard('user')->user()->id; ?>";
            // alert(user_employee_id);
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/find_notice_viewer_info/" + notice_id,
                success: function(data) {
                    // console.log(url);
                    // console.log(data);
                    $("#notice_viewer_count").text(data.length);
                    $('.listcategories').empty();
                    for (var i = 0; i < data.length; i++) {
                        $(".listcategories").append("<li class='text-left'>" + data[i].employee_fullname + " [" + data[i].employee_id_no + "]</li>");
                    }
                },
                error: function() {
                    // alert('Error occured!');
                    console.log('Error occured!');
                }
            });

            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/find_notice_vewing_info/" + notice_id + '/' + user_employee_id,
                success: function(data) {
                    if (data.length > 0) {
                        $('.check_view_class').css('display', 'inline');
                        $('.eye_view_class').css('display', 'none');
                    } else {
                        $('.check_view_class').css('display', 'none');
                        $('.eye_view_class').css('display', 'inline');
                    }
                },
                error: function() {
                    // alert('Error occured!');
                    console.log('Error occured!');
                }
            });
            // console.log("Changed");
        }else{
            console.log('No notice available!');
        }
    });

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



    $('#carouselsBirthday').on('slide.bs.carousel', function() {
        var ele = $('#carouselsBirthday div.active');
        $(".birthday_list_sl").text(ele.data('value'));
        $(".birthday_employee_id").val(ele.data('employeeid'));
        var employeeid = ele.data('employeeid');
        if (!employeeid) {
            console.log('No birthday available!');
            $('#carouselsBirthday').carousel('pause');
            return false;
        }
        var user_employee_id = "<?php echo Auth::guard('user')->user()->id; ?>";
        $.ajax({
            type: 'GET',
            url: "{{ url('/') }}/find_birthday_likers/" + employeeid,
            success: function(data) {
                j = 0;
                k = 0;
                $('.birthdayLikerList').empty();
                $('.birthdayWisherList').empty();
                $.each(data, function(item, value) {
                    if (item == "birthday_likers") {
                        $.each(value, function(i, object) {
                            j++;
                            $(".birthdayLikerList").append("<li class='text-left'>" + object.employee_fullname + " [" + object.employee_id_no + "]</li>");
                        });
                    }
                    if (item == "birthday_wishers") {
                        $.each(value, function(i, object) {
                            k++;
                            $(".birthdayWisherList").append("<li class='text-left'>" + object.employee_fullname + " [" + object.employee_id_no + "]</li>");
                        });
                    }
                });
                $("#birthday_likers_count").text(j);
                $("#birthday_wishers_count").text(k);
            },
            error: function() {
                console.log('Error occured!');
            }
        });

        $.ajax({
            type: 'GET',
            url: "{{ url('/') }}/find_birthday_liking_info/" + employeeid + '/' + user_employee_id,
            success: function(data) {
                // console.log(Object.keys(data.birthday_wishing_no).length);
                if (data.birthday_liking_no.length > 0) {
                    $('.thums_o_up_class').css('display', 'none');
                    $('.thums_up_class').css('display', 'inline');
                } else {
                    $('.thums_o_up_class').css('display', 'inline');
                    $('.thums_up_class').css('display', 'none');
                }

                if (Object.keys(data.birthday_wishing_no).length > 0) {
                    $('.fa_heart_o_wish').css('display', 'none');
                    $('.fa_heart_wish').css('display', 'inline');
                } else {
                    $('.fa_heart_o_wish').css('display', 'inline');
                    $('.fa_heart_wish').css('display', 'none');
                }
            },
            error: function() {
                console.log('Error occured!');
            }
        });

        // fa_heart_o_wish

    });

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
                //$('.thums_o_up_class').css('display', 'inline');
                //$('.thums_up_class').css('display', 'none');
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
                //$('.fa_heart_o_wish').css('display', 'inline');
                //$('.fa_heart_wish').css('display', 'none');
            },
            error: function() {
                // alert('Error occured!');
                console.log('Error occured!');
            }
        });
    })

    // $('#resetModal').on('click', function() {
    //     alert('ok');
    //     $("#leave_type_id").text('');
    // })
</script>



<script>
    if (window.innerWidth <= 600) {
        if (navigator.geolocation) {
            var location_timeout = setTimeout("geolocFail()", 10000);

            navigator.geolocation.watchPosition(function(position) {
            // navigator.geolocation.getCurrentPosition(function(position) {
                clearTimeout(location_timeout);

                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                $("#current_latitude").val(latitude);
                $("#current_longitude").val(longitude);

                var user_employee_id = "<?php echo Auth::guard('user')->user()->id; ?>";
                var employee_id = "<?php echo Auth::guard('user')->user()->employee_id; ?>";

                // $.ajax({
                //     type: 'POST',
                //     url: "{{ url('/') }}/get_employee_current_location",
                //     data: {
                //         user_employee_id: user_employee_id,
                //         employee_id: employee_id,
                //         latitude: latitude,
                //         longitude: longitude,
                //         _token: "{{ csrf_token() }}",
                //     },
                //     dataType: 'json',
                //     success: function(data) {
                //         console.log(data);
                //     },
                //     error: function() {
                //         console.log('Error occured!');
                //     }
                // });
            }, function(error) {
                clearTimeout(location_timeout);
            });
        } else {
            geolocFail();
        }
    }


    // Bind normal buttons
	Ladda.bind( 'div:not(.progress-demo) button', { timeout: 2000 } );

    // Bind progress buttons and simulate loading progress
    Ladda.bind( '.progress-demo button', {
        callback: function( instance ) {
            var progress = 0;
            var interval = setInterval( function() {
                progress = Math.min( progress + Math.random() * 0.1, 1 );

                instance.setProgress( progress );

                if( progress === 1 ) {
                    instance.stop();
                    clearInterval( interval );
                }
            }, 200 );
        }
    } );

    // You can control loading explicitly using the JavaScript API
    // as outlined below:

    // var l = Ladda.create( document.querySelector( 'button' ) );
    // l.start();
    // l.stop();
    // l.toggle();
    // l.isLoading();
    // l.setProgress( 0-1 );

    $('#check_in_manual_attendance').on('click', function() {
        var firedAlready = false;

        navigator.geolocation.watchPosition(function (position) {
            if(!firedAlready) {
                // alert("i'm tracking you!");
                firedAlready = true;
            }
        },

        function (error) {
            if (error.code == error.PERMISSION_DENIED){
                alert("Please Turn On Your Device Location :-(");
                $('#attendance_checkout').modal('hide');
                return;
            }
        });

        // var work_location_latitue = '<?php //echo json_encode($employee_data['work_location_latitue']); ?>';
        // var work_location_longitude = '<?php //echo json_encode($employee_data['work_location_longitude']); ?>';
        var work_location_radius = '<?php echo json_encode($employee_data['work_location_radius']); ?>';

        var user_employee_id = "<?php echo Auth::guard('user')->user()->id; ?>";
        var employee_id = "<?php echo Auth::guard('user')->user()->employee_id; ?>";
        var employee_id_no = "<?php echo Auth::guard('user')->user()->employee_card_no; ?>";



                var current_latitude = $('#current_latitude').val();
                var current_longitude = $('#current_longitude').val();

                $.ajax({
                    type: 'POST',
                    url: "{{ url('/') }}/get_employee_current_location",
                    data: {
                        user_employee_id: user_employee_id,
                        employee_id: employee_id,
                        latitude: current_latitude,
                        longitude: current_longitude,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                    },
                    error: function() {
                        console.log('Error occured!');
                    }
                });

                // return;
                if (confirm("Are you present in work location?")) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('/') }}/employee_check_in_time",
                        data: {
                            user_employee_id: user_employee_id,
                            employee_id: employee_id,
                            employee_id_no: employee_id_no,
                            current_latitude: current_latitude,
                            current_longitude: current_longitude,
                            work_location_radius: work_location_radius,
                            _token: "{{ csrf_token() }}",
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            if(data.status == 0){
                                alert(data.message);
                                // alert(data);
                                $('#attendance_modal').modal('hide');
                                location.reload();
                            }else{
                                // alert('Check in successful!');
                                alert(data.message);
                                $('#attendance_modal').modal('hide');
                                location.reload();
                            }
                        },
                        error: function() {
                            console.log('Error occured!');
                        }
                    });
                } else {
                    location.reload();
                }



            //     });
            // }
    });


    $('#check_out_manual_attendance').on('click', function() {

        var firedAlready = false;

        navigator.geolocation.watchPosition(function (position) {
            if(!firedAlready) {
                // alert("i'm tracking you!");
                firedAlready = true;
            }
        },

        function (error) {
            if (error.code == error.PERMISSION_DENIED){
                alert("Please Turn On Your Device Location :-(");
                $('#attendance_checkout').modal('hide');
                return;
            }
        });

        var work_location_radius = '<?php echo json_encode($employee_data['work_location_radius']); ?>';
        var user_employee_id = "<?php echo Auth::guard('user')->user()->id; ?>";
        var employee_id = "<?php echo Auth::guard('user')->user()->employee_id; ?>";
        var employee_id_no = "<?php echo Auth::guard('user')->user()->employee_card_no; ?>";

        var current_latitude = $('#current_latitude').val();
        var current_longitude = $('#current_longitude').val();

        $.ajax({
            type: 'POST',
            url: "{{ url('/') }}/get_employee_current_location",
            data: {
                user_employee_id: user_employee_id,
                employee_id: employee_id,
                latitude: current_latitude,
                longitude: current_longitude,
                _token: "{{ csrf_token() }}",
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
            },
            error: function() {
                console.log('Error occured!');
            }
        });

        // console.log(employee_card_no);
        $.ajax({
            type: 'POST',
            url: "{{ url('/') }}/employee_check_out_time",
            data: {
                user_employee_id: user_employee_id,
                employee_id: employee_id,
                employee_id_no: employee_id_no,
                current_latitude: current_latitude,
                current_longitude: current_longitude,
                work_location_radius: work_location_radius,
                _token: "{{ csrf_token() }}",
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if(data.status == 0){
                    // alert('Check Out failed! Try again!');
                    alert(data.message);
                    $('#attendance_checkout').modal('hide');
                    location.reload();
                }else{
                    // alert('Check Out successful!');
                    alert(data.message);
                    $('#attendance_checkout').modal('hide');
                    location.reload();
                }
            },
            error: function() {
                console.log('Error occured!');
            }
        });
    });
</script>

