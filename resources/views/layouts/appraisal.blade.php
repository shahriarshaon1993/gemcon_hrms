<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0"><meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BPT </title>
  <link rel="apple-touch-icon" href="app-assets/images/ico/apple-icon-120.png">
  <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">
  <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors.min.css">
  <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/extensions/dragula.min.css">
  <!-- END: Vendor CSS-->
  <!-- BEGIN: Theme CSS-->
  <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
  <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap-extended.css">
  <link rel="stylesheet" type="text/css" href="/app-assets/css/colors.css">
  <link rel="stylesheet" type="text/css" href="/app-assets/css/components.css">
  <link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/vertical-menu.css">
  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
  <!-- END: Custom CSS-->
  <style>
    body {
      zoom: 80% !important;
      -moz-zoom: 80% !important;
    }
  </style>
</head>

<body class="vertical-layout boxicon-layout no-card-shadow 2-columns navbar-sticky footer-static pace-running pace-running page-scrolled vertical-overlay-menu pace-done menu-open" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
  <div id="app">
    <div class="page-wrappers">
      <frontend-header></frontend-header>
      <router-view />
      <frontend-footer></frontend-footer>
    </div>

  </div>

  <script src="/app-assets/vendors/js/vendors.min.js"></script>
   
    <script src="/app-assets/js/core/app-menu.js"></script>
    <script src="/app-assets/js/core/app.js"></script>

  <!-- <script src="<?php echo url(route('payroll.jsBaseURLs')); ?>"></script>   -->
  <script src="{{asset('js/app.js')}}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

</body>
</html>