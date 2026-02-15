<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Gemcon Group | HRM</title>
  <!-- <link type="image/x-icon" rel="shortcut icon" sizes="16x16" href="favicon.png"/> -->
  <link type="image/x-icon" rel="shortcut icon" sizes="16x16" href="{{asset('favicon.png')}}"/>
   <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"  crossorigin="anonymous">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('admin_assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('admin_assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin_assets/dist/css/adminlte.min.css')}}">

  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

  <link href="{{asset('admin_assets/dist/css/datepicker.min.css')}}" rel="stylesheet">
  <link href="{{asset('admin_assets/assets/css/vue-multiselect.min.css')}}" rel="stylesheet">

  <!-- Custom CSS link -->
  <link rel="stylesheet" href="{{asset('admin_assets/assets/custom.css')}}">

  <link href="{{asset('hrms_dashboard/css/highcharts.css')}}" rel="stylesheet" />
	<!-- Employee From start -->
	<script src="https://code.highcharts.com/maps/highmaps.js"></script>
	<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
	<!-- Employee From end -->
	<link rel="stylesheet" href="{{asset('hrms_dashboard/css/coustomize-grap-chart.css')}}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel="stylesheet" href="css/animate.css">
    <link type="text/css"  href="{{asset('melon/assets/css/vue-multiselect.min.css')}}"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
