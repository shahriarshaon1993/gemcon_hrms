@include('includs.signup-register-header')
        <!-- Sub banner start -->
 <section class="header-bg-2 login-register" id="home">
    <div class="stfpp-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="hero-area">
                    <div class="hero-text h-2 text-center">
                        <h2 style="text-transform: uppercase;">Forgot Password</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
 <section class="free-trial section-padding" id="free-trial">
    
<div class="contact-1 content-area-7">
    <div class="container">
        <div class="row">
            
            
            <div class="col-lg-7 col-md-7 col-md-7" style="padding-left:65px;">
                <h3>Reset Password Here</h3><hr>
                <?php if (session('message')): ?>
                    <div class="alert alert-<?php echo session('class'); ?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo  session('message'); ?>
                    </div>
                <?php endif; ?>
                 <form action="{{route('forgotPassword')}}" method="POST">
                    {{@csrf_field()}}
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group name">
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{Request::old('email')}}">
                                @if($errors->has('email'))<p class="text-danger">{{$errors->first('email')}}</p>@endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="send-btn">
                                <input type="submit" class="btn btn-color btn-md btn-message" name="submit" value="Send Varification Link">
                                <span style="margin-left:8px;color:"><a href="{{route('user.login')}}" >Instead login?</a></span>
                            </div>   
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
<!-- Contact 1 end -->
@include('includs.dmo-home-footer')