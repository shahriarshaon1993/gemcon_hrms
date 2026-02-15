@include('includs.Header')

<style type="text/css">
.o_home_menu .o_home_menu_scrollable {
    max-width: 1200px;
}
.o_home_menu .o_home_menu_scrollable .o_apps {
    width: 80%;
}
</style>

<style type="text/css">
    .employee-profile{
        background-color: white;
        border: 1px solid #ced4da;
        box-shadow: 0 5px 20px -15px black;
        width:95%;
        height: auto;
        font-family: "Roboto", "Odoo Unicode Support Noto", sans-serif;
    }
    .oe_button_box {
        width:100%;
        height: 45px;
        border-bottom: 1px solid #ced4da;
        box-shadow: inset 0 -1px 0 #ced4da;
        margin-bottom: 24px;
    }
    .profile-img img{
        max-width: 90px;
        max-height: 90px;
        text-align: right;
    }
    .job-designation{
        color: #999;
    }
    .office-others-info td{
        color: #666666;
        font-weight: normal;
        opacity: 0.5;
        font-size: 1.0em;
    }
    .o_group {
        display: inline-block;
        width: 100%;
        margin: 10px 0;

    }
    .o_group label {
        margin: 0 5px 0 0;
        font-size: 1.08333333rem;
        line-height: 1.5;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .o_td_label {
        width: 0%;
        padding: 0 15px 0 0;
        min-width: 150px;
    }
    .nav.nav-tabs {
        padding-left: 32px;
    }
    .tab-pane.fade{
        padding: 30px;
    }
    .nav-item a{
        color:#666;
        font-size: 1.0rem;
        font-family: "Roboto", "Odoo Unicode Support Noto", sans-serif;
        border-color: rgb(206, 212, 218);
        border-width: 1px;
    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #212529;
        border-top-color: #875A7B;
        border-bottom-color: white;
    }
    .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .nav-tabs .nav-link {
        border-color: #e9ecef #e9ecef #dee2e6;
    }
    .tab-top{
        float: right;
        padding-left: 0px !important;
    }
    .tab-top li{
        border:1px solid #e9ecef;
        padding: 10px;
    }
    .employee-info h1{
        font-size: 2.6rem;
    }
    @media (max-width: 767.98px){
        .employee-info h1{
            font-size: 1.95rem;
        }
        .employee-info h2{
            font-size: 1.3rem;
        }
    }
    .info-box {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        border-radius: .25rem;
        background: #f5f5f5;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 1rem;
        min-height: 65px;
        padding: .5rem;
        position: relative;
        width: 100%;
        text-align: right;
    }
    .info-box .info-box-icon {
        border-radius: .25rem;
        -ms-flex-align: center;
        align-items: center;
        display: -ms-flexbox;
        display: flex;
        font-size: 1.4rem;
        -ms-flex-pack: center;
        justify-content: center;
        text-align: center;
        width: 28px;
        height: 40px;
        margin-top: 7px;
    }
    .bg-info, .bg-info>a {
        color: #fff!important;
    }
    .bg-info {
        background-color: #296e70!important;
    }
    .bg-alert {
        background-color: #8f8853!important;
        color: #fff!important;
    }
    
    .elevation-1 {
        box-shadow: 0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24)!important;
    }
    .info-box .info-box-text, .info-box .progress-description {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 12px;
    }
    .info-box .info-box-content {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        -ms-flex-pack: center;
        justify-content: center;
        line-height: 120%;
        -ms-flex: 1;
        flex: 1;
        padding: 0 3px;
    }
    .info-box .info-box-number {
        display: block;
        margin-top: .25rem;
        font-weight: 700;
    }

    @media (min-width: 768px){
        .col-md-2 {
            max-width: 12.5%;
            padding: 10px;
        }
    }
    table.dataTable thead th, table.dataTable thead td {
        padding: 10px 12px;
        font-size: 12px;
    }
    table.dataTable tbody th, table.dataTable tbody td {
        padding: 5px;
        font-size: 12px;
        text-align: center;
    }
    .dataTables_wrapper .dataTables_paginate {
        font-size: 12px;
    }
    .dataTables_wrapper .dataTables_info {
        font-size: 12px;
    }
    a.canvasjs-chart-credit {
        display: none;
    }
    .box {
        display: flex;
        flex-direction: column;
        margin-bottom: .5rem;
        background-color: #fff;
        border: 1px solid #efe3e5;
        border-radius: 4px;
    }

    .o_home_menu_background:not(.o_home_menu_background_custom) .o_main_navbar {
        background-color: #945b00;
        border-color: #945b00;
    }
    .o_home_menu_background {
        background: #f9f9f9 !important;
    }
    .o_home_menu .o_home_menu_scrollable .o_apps .o_app .o_caption {
        color: #000;
    }
</style>
    @include('layouts.top_bar_index')    
<!-- <div id="app">
    
        <router-view></router-view>


</div>  

<script src="<?php //echo url(route('pos.jsBaseURLs')); ?>"></script>  
<script src="{{asset('js/app.js')}}"></script> -->
@include('includs.Footer')
</body>
</html>