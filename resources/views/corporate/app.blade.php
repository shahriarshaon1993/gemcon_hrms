@include('includs.corporateHeader')

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
                <a class="navbar-brand" href="index.html">
                    <img src="{{asset('melon/assets/img/logo.png')}}" alt="logo" />
                    <strong>ME</strong>LON
                </a>
                <!-- /logo -->

                <!-- Sidebar Toggler -->
                <a href="#" class="toggle-sidebar bs-tooltip" data-placement="bottom" data-original-title="Toggle navigation">
                    <i class="icon-reorder"></i>
                </a>
                <!-- /Sidebar Toggler -->

                <ul class="nav navbar-nav navbar-left hidden-xs hidden-sm"> 
                    <li> <a href="#"> {{$corporateInfo->name}} - [Consolidated Inventory] </a> </li> 
                </ul> 


                <!-- Top Right Menu -->
                <ul class="nav navbar-nav navbar-right">


                    <!-- User Login Dropdown -->
                    <li><a href="{{url(route('user.home'))}}">Go to Root</a></li>
                    <li class="dropdown user user-layout" id="set-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!--<img alt="" src="assets/img/avatar1_small.jpg" />-->
                            <div class="profile-img">
                                <img src="{{asset('images/'.$user->photo)}}">
                                <span class="username">{{$user->name}}</span>
                                <i class="icon-caret-down small"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="pages_user_profile.html"><i class="icon-user"></i> My Profile</a></li>
                            <li>
                                <user-header-link></user-header-link>
                            </li>
                            <li><a href="{{ route('user.logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><i class="icon-key"></i> Log Out</a></li>
                        </ul>
                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
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
                    
                    <corporate-sidebar></corporate-sidebar>

                </div>
                <div id="divider" class="resizeable"></div>
            </div>
            <!-- /Sidebar -->

            <div id="content">
                <div class="container">
                    <!-- Breadcrumbs line -->
                   <!--  <div class="crumbs">
                        <ul id="breadcrumbs" class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="index.html">Dashboard</a>
                            </li>
                            <li class="current">
                                <a href="pages_calendar.html" title="">Calendar</a>
                            </li>
                        </ul>
                    </div> -->
                    <bredcrumb></bredcrumb>
                    <!-- /Breadcrumbs line -->
                    <!--=== Page Content ===-->
                <div class="row">
                    <router-view></router-view>
                </div>
                <!-- /Page Content -->
            </div>
                <!-- /.container -->
            </div>
        </div>

 </div> 
 <script src="<?php echo url(route('corporate.jsBaseURLs', [$corporateInfo->id])); ?>"></script>     
 <script src="{{asset('js/app.js')}}"></script>
@include('includs.corporateFooter')
</body>
</html>