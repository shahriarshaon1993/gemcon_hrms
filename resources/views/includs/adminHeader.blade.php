<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel ={csrfToken:'{{ csrf_token() }}'}</script>
    <title>HRM-Admin Panel</title>

    <!--=== CSS ===-->

    <!-- Bootstrap -->
    <link href="{{asset('melon/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- jQuery UI -->
    <!--<link href="plugins/jquery-ui/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />-->
    <!--[if lt IE 9]>
        <link rel="stylesheet" type="text/css" href="plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/>
    <![endif]-->

    <!-- Theme -->
    <link href="{{asset('melon/assets/css/main.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('melon/assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('melon/assets/css/responsive.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('melon/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('melon/assets/css/login.css')}}" rel="stylesheet" type="text/css" />

    <!-- table sort  -->
     <link href="{{asset('melon/assets/css/table-sort.css')}}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{asset('melon/assets/css/fontawesome/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('melon/assets/css/newfontawesome/font-awesome.min.css')}}">
    <!--[if IE 7]>
        <link rel="stylesheet" href="assets/css/fontawesome/font-awesome-ie7.min.css">
    <![endif]-->

    <!--[if IE 8]>
        <link href="assets/css/ie8.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
    <link rel="stylesheet" href="{{asset('melon/assets/css/custom.css')}}">
    <link type="text/css"  href="{{asset('melon/assets/css/vue-multiselect.min.css')}}"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
</head>
