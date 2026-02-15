@include('includs.adminHeader')

<body>

    <!-- Header -->
    <div id="app">

            <header class="header navbar navbar-fixed-top" role="banner">
                <!-- Top Navigation Bar -->
                <div class="container">

                    <!-- Only visible on smartphones, menu toggle -->
                    <ul class="nav navbar-nav">
                        <li class="nav-toggle"><a href="javascript:void(0);" title=""><i class="icon-reorder"></i></a></li>
                    </ul>

                    <!-- Logo -->
                    <a class="navbar-brand" href="#">
                        <img src="{{asset('favicon.png')}}" alt="logo" />
                        HRM-Admin Panel
                    </a>
                    <!-- /logo -->

                    <!-- Sidebar Toggler -->
                    <a href="#" class="toggle-sidebar bs-tooltip" data-placement="bottom" data-original-title="Toggle navigation">
                        <i class="icon-reorder"></i>
                    </a>
                    <!-- /Sidebar Toggler -->

                    <!-- Top Right Menu -->
                    <ul class="nav navbar-nav navbar-right">

                        <!-- User Login Dropdown -->
                        <li class="dropdown user" id="set-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!--<img alt="" src="assets/img/avatar1_small.jpg" />-->
                                <i class="icon-male"></i>
                                <span class="username">{{$admin->name}}</span>
                                <i class="icon-caret-down small"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="pages_user_profile.html"><i class="icon-user"></i> My Profile</a></li>
                                <li>
                                    <admin-header-link></admin-header-link>
                                </li>
                                <li><a href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="icon-key"></i> Log Out</a></li>
                            </ul>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                    @csrf
                            </form>
                        </li>
                        <!-- /user login dropdown -->
                    </ul>
                    <!-- /Top Right Menu -->
                </div>
                <!-- /top navigation bar -->
            </header> <!-- /.header -->
            <div id="container">
                <div id="sidebar" class="sidebar-fixed">
                    <div id="sidebar-content">

                        <!-- Search Input -->
                            <!-- <form class="sidebar-search">

                                <div class="input-box">
                                    <button type="submit" class="submit">
                                        <i class="icon-search"></i>
                                    </button>
                                    <span>
                                        <input type="text" placeholder="Search...">
                                    </span>
                                </div>
                                
                            </form> -->
                        <!-- Search Results -->

                        <div class="sidebar-search-results">

                            <i class="icon-remove close"></i>
                            <!-- Documents -->
                            <div class="title">
                                Documents
                            </div>
                            <ul class="notifications">
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="col-left">
                                            <span class="label label-info"><i class="icon-file-text"></i></span>
                                        </div>
                                        <div class="col-right with-margin">
                                            <span class="message"><strong>John Doe</strong> received $1.527,32</span>
                                            <span class="time">finances.xls</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="col-left">
                                            <span class="label label-success"><i class="icon-file-text"></i></span>
                                        </div>
                                        <div class="col-right with-margin">
                                            <span class="message">My name is <strong>John Doe</strong> ...</span>
                                            <span class="time">briefing.docx</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <!-- /Documents -->
                            <!-- Persons -->
                            <div class="title">
                                Persons
                            </div>
                            <ul class="notifications">
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="col-left">
                                            <span class="label label-danger"><i class="icon-female"></i></span>
                                        </div>
                                        <div class="col-right with-margin">
                                            <span class="message">Jane <strong>Doe</strong></span>
                                            <span class="time">21 years old</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div> <!-- /.sidebar-search-results -->

                        <!--=== Navigation ===-->
                        
                        <admin-sidebar></admin-sidebar>

                    </div>
                    <div id="divider" class="resizeable"></div>
                </div>
                <!-- /Sidebar -->

                <div id="content">
                    <div class="container" style="width: 80%;margin: 120px 143px;">
                    <!-- Breadcrumbs line -->

                    <bredcrumb></bredcrumb>
                    <!-- /Breadcrumbs line -->
                    <!--=== Page Content ===-->
                    <div class="row">
                        <router-view :key="$route.fullPath"></router-view>
                    </div>
                    <!-- /Page Content -->
                </div>
                    <!-- /.container -->
                </div>
            </div>

    </div>
</body>    
<script src="<?php echo url(route('admin.jsBaseURLs')); ?>"></script>
<script src="{{asset('js/app.js')}}"></script>
@include('includs.adminFooter')