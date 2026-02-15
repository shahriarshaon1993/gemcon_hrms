<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel ={csrfToken:'{{ csrf_token() }}'}</script>
    <title>HRM-Admin Panel, Gemcon Group</title>
    <!-- <link rel="apple-touch-icon" href="{{asset('melon/assets/img/logo.png')}}"> -->
    <link type="image/x-icon" rel="shortcut icon" sizes="16x16" href="{{asset('favicon.png')}}"/>
    <!-- <link rel="shortcut icon" href="{{asset('melon/assets/img/logo.png')}}"> -->

    <link href="{{asset('melon/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" href="assets/css/style.css"> 

    <link href="{{asset('melon/assets/css/main.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('melon/assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('melon/assets/css/responsive.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('melon/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('melon/assets/css/login.css')}}" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">


    <!-- table sort  -->
     <link href="{{asset('melon/assets/css/table-sort.css')}}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{asset('melon/assets/css/fontawesome/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('melon/assets/css/newfontawesome/font-awesome.min.css')}}">


    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{asset('melon/assets/css/vue-multiselect.min.css')}}">
    <link rel="stylesheet" href="{{asset('melon/assets/css/custom.css')}}">
    <link type="text/css"  href="{{asset('melon/assets/css/vue-multiselect.min.css')}}"/>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@voerro/vue-tagsinput@2.0.2/dist/style.css">
    <link rel="stylesheet" href="https://timf.imikrof.com/css/jquery.treegrid.css">


    <style>  
        body{
  overflow-x: hidden;
  background-color: #eaeaea;
}
.top{
  top: 0;
  z-index: 1;
  width: 100%;
  position: fixed;
}
.p-t-56{
  padding-top: 56px;
}
.bg-purple{
  background-color: #7E57C2;
}
.index-0{
  z-index: 0 !important;
}
.ellipsis {
  width: 90%;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}

.custom-navbar .navbar-nav .nav-item{
  border-left: 1px solid rgba(255,255,255,0.2);
}
.custom-navbar .navbar-nav .nav-item .nav-link{
  padding: .5rem 1rem;
  
}

.custom-navbar .navbar-nav .nav-item-search .btn{
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
}
.navbar-card .side-navbar{
   height: 100% !important;
   width: auto;
   position: fixed;
   /* z-index: 1; */
   /* left: 0; */
   /* overflow-x: hidden; */
}
.navbar-card .side-navbar{
  height: auto;
  min-height: 300px;
  padding-top: .5rem;
  padding-bottom: .5rem;
  background-color: #E0E0E0;
}
.navbar-card .side-navbar .nav{
  flex-direction: column;
}
.navbar-card .side-navbar .nav-item .nav-link{
    display: flex;
    color: #777;
    font-weight: 500;
    padding: .5rem 1rem;
    flex-direction: column;
    text-align: center;
    transition: 0.8s;
  }
.navbar-card .side-navbar .nav-item .nav-link:hover{
  color: #666;
  background-color: #BDBDBD;
}
.navbar-card .side-navbar .nav-item .nav-link .icon{
  font-size: 1.5em;
  margin-bottom: .25rem;
}

.nav-custom .nav .nav-item .nav-link{
  color: #6c757d;
  font-weight: 500;
  transition: 0.8s;
  border-right: 2px solid rgba(0,0,0,0.2);
}
.nav-custom .nav .nav-item .nav-link:hover{
  background-color: #CFD8DC;
}
.nav-custom .nav .nav-item:last-child .nav-link{
  border-right: 0;
}

.default-card a{
  text-decoration: none !important;
}
.default-card a:hover{
  text-decoration: none !important;
}
.default-card a .card-thumb{
  padding: 1rem 1rem 0 1rem;
}
.default-card a .card-thumb img{
  width: 100%;
  height: auto;
}
.default-card a .card-title{
  color: #6c757d;
}

.cart-box{
  display: block;
  overflow: hidden;
}
.cart-box .cart-header{
  display: flex;
  flex-direction: row;
  background-color: #fff;
  justify-content: space-between;
}
.list-default{
  margin: 0;
  padding: 0;
  display: block;
  overflow: auto;
  list-style-type: none;
}
.list-default .list-group-item{
  padding: 0;
  display: flex;
  flex-direction: row;
  background-color: #fff;
  border-bottom: 1px solid rgba(0,0,0,0.2);
}
.list-default .list-group-item .l-container{
  flex-grow: 1;
}
.list-default .list-group-item .l-container,
.list-default .list-group-item .r-container{
  display: flex;
}
.list-default .list-group-item .thumb-container{
  display: block;
}
.list-default .list-group-item .thumb-container img{
  width: 64px;
  height: 64px;
}
.list-default .list-group-item .title-container{
  /* width: 300px; */
    flex-grow: 1;
    padding: .5rem .25rem;
}
.list-default .list-group-item .title-container .title{
  font-size: 1.06em;
}
.list-default .list-group-item .title-container .currency {
  font-weight: 600;
}

.list-default .list-group-item .option-container{
  padding: .8rem .25rem;
}
.list-default .list-group-item .action-container{
  padding: .8rem .25rem;
}

.btn-pos{
  color: #fff;
  background-color: #7E57C2;
  border-color: #7E57C2;
}

.btn-pos:focus {
  color: #fff;
  background-color: #673AB7;
  border-color: #673AB7;
  box-shadow: 0 0 0 0.2rem rgba(75, 0, 255, 0.25);
}

.btn-pos:hover {
  color: #fff;
  background-color: #673AB7;
  border-color: #673AB7;
}
    </style>

</head>
<body >

    <div class="login">
      
       <!-- Logo -->
    <div class="logo">
        <strong>ADMIN</strong> LOGIN
    </div>
    <!-- /Logo -->

    <!-- Login Box -->
    <div class="box">
        <div class="content">
            <!-- Login Formular -->
            <h3 class="form-title">Sign In to your Account</h3>
            @if (session('status'))
                <div class="alert alert-danger">
                    {{ session('status') }}
                </div>
            @endif
            <form class="form-vertical login-form" method="POST" action="{{ route('admin.login.submit') }}">
                 @csrf
                <!-- Title -->

                <!-- Error Message -->
                <div class="alert fade in alert-danger" style="display: none;">
                    <i class="icon-remove close" data-dismiss="alert"></i>
                    Enter any username and password.
                </div>

                <!-- Input Fields -->
                <div class="form-group">
                    <!--<label for="username">Username:</label>-->
                    <div class="input-icon">
                        <i class="icon-user"></i>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}"  autocomplete="off" autofocus placeholder="User Name" />

                        @error('username')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <!--<label for="password">Password:</label>-->
                    <div class="input-icon">
                        <i class="icon-lock"></i>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="off" placeholder="Password" />

                        @error('password')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <!-- /Input Fields -->

                <!-- Form Actions -->
                <div class="form-actions">
                    <label class="checkbox pull-left"><input type="checkbox" class="uniform" name="remember"> Remember me</label>
                    <button type="submit" class="submit btn btn-primary pull-right" style="background: #ff9900;">
                        Sign In <i class="icon-angle-right"></i>
                    </button>
                </div>
            </form>
            <!-- /Login Formular -->
        </div> <!-- /.content -->

        <!-- Forgot Password Form -->
        <div class="inner-box">
            <div class="content">
                <!-- Close Button -->
                <i class="icon-remove close hide-default"></i>

                <!-- Link as Toggle Button -->
                <a href="#" class="forgot-password-link">Forgot Password?</a>

                <!-- Forgot Password Formular -->
                <form class="form-vertical forgot-password-form hide-default" action="login.html" method="post">
                    <!-- Input Fields -->
                    <div class="form-group">
                        <!--<label for="email">Email:</label>-->
                        <div class="input-icon">
                            <i class="icon-envelope"></i>
                            <input type="text" name="email" class="form-control" placeholder="Enter email address" data-rule-required="true" data-rule-email="true" data-msg-required="Please enter your email." />
                        </div>
                    </div>
                    <!-- /Input Fields -->

                    <button type="submit" class="submit btn btn-default btn-block">
                        Reset your Password
                    </button>
                </form>
                <!-- /Forgot Password Formular -->

                <!-- Shows up if reset-button was clicked -->
                <div class="forgot-password-done hide-default">
                    <i class="icon-ok success-icon"></i> <!-- Error-Alternative: <i class="icon-remove danger-icon"></i> -->
                    <span>Great. We have sent you an email.</span>
                </div>
            </div> <!-- /.content -->
        </div>
        <!-- /Forgot Password Form -->
    </div>
    <!-- /Login Box -->

        <table width="50%" style="margin: auto; background-color: #f9f9f9; color:#212529;margin-top: 5%;" >
            <tbody style="border: 1px solid transparent" >   
                <tr style="margin: auto; background-color: #f9f9f9; color:#212529;border-bottom: 10px solid #f9f9f9;"> 
                    <td class=" text-center" style="border: 1px solid white !important;">  
                    <hr style="margin-top: 0px; margin-bottom: 5px;border: 0;border-top: 1px solid #eee;">
                    <?php 
                        $yers=date('Y');
                    ?>
                    © <?php echo $yers; ?>  Gemcon Group. All rights reserved. Developed by Gemcon Group IT.
                    </td>
                </tr> 
            </tbody>
        </table>
    
    </div>  
    
<!--=== JavaScript ===-->
  <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>

<script type="text/javascript" src="{{asset('melon/assets/js/jquery.treegrid.js')}}"></script>

    <script type="text/javascript" src="{{asset('melon/assets/js/libs/jquery-1.10.2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('melon/bootstrap/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/assets/js/libs/lodash.compat.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('melon/assets/js/printThis.js')}}"></script>

    <!-- Smartphone Touch Events -->
    <script type="text/javascript" src="{{asset('melon/plugins/touchpunch/jquery.ui.touch-punch.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/plugins/event.swipe/jquery.event.move.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/plugins/event.swipe/jquery.event.swipe.js')}}"></script>

    <!-- General -->
    <script type="text/javascript" src="{{asset('melon/assets/js/libs/breakpoints.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/plugins/respond/respond.min.js')}}"></script> <!-- Polyfill for min/max-width CSS3 Media Queries (only for IE8) -->
    <script type="text/javascript" src="{{asset('melon/plugins/cookie/jquery.cookie.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/plugins/slimscroll/jquery.slimscroll.horizontal.min.js')}}"></script>


    <script type="text/javascript" src="{{asset('melon/plugins/sparkline/jquery.sparkline.min.js')}}"></script>


    <!-- Forms -->
    <script type="text/javascript" src="{{asset('melon/plugins/uniform/jquery.uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/plugins/select2/select2.min.js')}}"></script>

    <!-- App -->
    <script type="text/javascript" src="{{asset('melon/assets/js/app_them.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/assets/js/plugins.js')}}"></script>


    <script type="text/javascript" src="{{asset('melon/assets/js/plugins.form-components.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <!-- Demo JS -->
    <script type="text/javascript" src="{{asset('melon/assets/js/custom.js')}}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>







    <script>

       


        function initAllJs(){
            "use strict";
            App.init(); // Init layout and core plugins
            Plugins.init(); // Init all plugins
            FormComponents.init(); // Init all form-specific plugins
        }
        function focusTest(rowItem){

            if(rowItem){
                var slecttyp = ".table-focus-input input#"+Object.keys(rowItem).length;
                
                $(slecttyp).focus();
            }else{

                $(".table-focus-input input#1").focus();
            }
        }
        function focusInput(rowItem){
             // console.log(  );

            if(rowItem){
              var slecttyp =$( ".table-focus-input input#"+Object.keys(rowItem).length);
              var qty = $(".table-focus-input input#"+Object.keys(rowItem).length+'qty');

              if(slecttyp.val() == '' )
              {
                slecttyp.focus();

              }
              if(slecttyp.val() != ''){
                qty.focus();
              }

            }else{
                var product_name=$(".table-focus-input input#1");
                var product_qty=$(".table-focus-input input#1qty");
                if(product_name.val()=='')
                {
                  product_name.focus();
                }
                if(product_name.val() != '') {
                    product_qty.focus();
                }


            }


        }
        $(document).ready(function(){
           /* setTimeout(function(){
                "use strict";

                App.init(); // Init layout and core plugins
                Plugins.init(); // Init all plugins
                FormComponents.init(); // Init all form-specific plugins
            }, 1000);*/
            $('#set-dropdown>a').click(function(){
                if($(this).parent().hasClass("show")){
                    $(this).parent().removeClass("open");
                }else{
                    $(this).parent().addClass("open");
                }
            });
        });

      

    </script>
 

</body>
</html>