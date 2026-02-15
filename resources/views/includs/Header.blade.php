<!DOCTYPE html>
<html style="height: 100%;">
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gemcon Group || HRM</title>
    <link type="image/x-icon" rel="shortcut icon" sizes="16x16" href="favicon.png"/>

    <link rel="stylesheet" href="https://msurguy.github.io/ladda-bootstrap/dist/ladda-themeless.min.css">
    <script src="https://msurguy.github.io/ladda-bootstrap/dist/spin.min.js"></script>
    <script src="https://msurguy.github.io/ladda-bootstrap/dist/ladda.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda-themeless.min.css"> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda.min.css"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/spin.min.js"></script> -->

    <!-- <link href="{{URL::asset('new_desgin/fonts/lucidagrande-font.css')}}" rel="stylesheet"> -->
    <link type="text/css" rel="stylesheet" href="{{asset('asset/css/web.assets_common.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('asset/css/web.assets_frontend.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('asset/css/web.assets_backend.css')}}"/>
    <script defer="defer" type="text/javascript" src="{{asset('asset/js/web.assets_common_minimal_js.js')}}"></script>
    <script defer="defer" type="text/javascript" src="{{asset('asset/js/web.assets_backend.js')}}"></script>
    <script defer="defer" type="text/javascript" src="{{asset('asset/js/web.assets_frontend_minimal_js.js')}}"></script>
    <!-- script defer="defer" type="text/javascript" data-src="{{asset('asset/js/web.assets_common_lazy.js')}}"></script>
    <script defer="defer" type="text/javascript" data-src="{{asset('asset/js/web.assets_frontend_lazy.js')}}"></script> -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
      <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css"> -->
      <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
      <script src = "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
      <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
  <!--    <link href="https://cdn-na.infragistics.com/igniteui/2020.1/latest/css/themes/infragistics/infragistics.theme.css" rel="stylesheet" /> -->
     <link href="https://cdn-na.infragistics.com/igniteui/2020.1/latest/css/structure/infragistics.css" rel="stylesheet" />
     <script src="https://ajax.aspnetcdn.com/ajax/modernizr/modernizr-2.8.3.js"></script>
     <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>

     <link rel="stylesheet" href="{{asset('pagination/jquery.paginate.css')}}" />
     <script src="{{asset('pagination/jquery.paginate.js')}}"></script>
       <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
     <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
  <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
</head>
<body class="o_home_menu_background">
