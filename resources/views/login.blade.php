@extends('layouts.inventory-login')
@section('content')
  <div id="wrapwrap" class="">
        <main>
            <div class="container py-5">
                <div style="max-width: 300px;" class="card border-0 mx-auto bg-100 rounded-0 shadow-sm bg-white o_database_list">
                    <div class="card-body">
                        <div class="text-center pb-3 border-bottom mb-4">
                            <img alt="Logo" style="max-height:80px; max-width: 100%; width:auto" src="asset/gemcon-logo.png"/>
                        </div>
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        @if (session('status'))
                            <div class="alert alert-danger">
                               {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('user.login.submit') }}">  
                           @csrf
                           <div class="alert fade in alert-danger" style="display: none;">
                              <i class="icon-remove close" data-dismiss="alert"></i>
                                 Enter any username and password.
                          </div> 
                            <div class="form-group field-login">
                                <label for="login">User ID</label>
                                 <input id="userid" type="text"  name="userid" value="{{ old('userid') }}"  autocomplete="off" autofocus class="@error('userid') is-invalid @enderror form-control form-control-lg rounded-0 border-left-6"
                                              placeholder=" User ID">
                                            
                            </div>
                            @error('userid')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                            @enderror

                            <div class="form-group field-password">
                                <label for="password">Password</label>
                                <input type="password" name="password" autocomplete="off" class="form-control  @error('password') is-invalid @enderror form-control-lg rounded-0 border-left-6"
                                              placeholder="Password">
                                            
                            </div>
                              @error('password')
                                <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            <div class="clearfix oe_login_buttons text-center mb-1 pt-3">
                                <!-- <button type="submit" class="btn btn-primary btn-block">Log in</button> -->
                                <!-- <button type="submit" class="btn btn btn-warning btn-lg btn-block pos-bottom rounded-0 z-index-10 mt-4">Log In </button> -->
                                <div class="progress-logging">
                                   <!-- <button type="submit" class="btn btn btn-warning btn-lg btn-block pos-bottom rounded-0 z-index-10 mt-4">Log In </button> -->
                                    <button type="submit" class="btn btn btn-warning btn-lg btn-block pos-bottom rounded-0 z-index-10 mt-4 ladda-button" data-style="expand-left"><span class="ladda-label">Log In </span></button>
                                </div>
                               <!--  <a type="submit" class="btn btn-primary btn-block">Log in</a> -->
                                <div class="justify-content-between mt-2 d-flex small">
                                    <!-- <a href="signupd41d.php">Don't have an account?</a> -->
                                    <a href="#" data-menu="settings" style="text-align: left;font-size: 13px;padding: .25rem 0rem !important;color: #0543b6;" data-toggle="modal" data-target="#resetPassword" data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false">Reset Password</a>
                                </div>
                                <div class="o_login_auth"></div>
                            </div>
                            <input type="hidden" name="redirect"/>
                        </form>


                        <div class="modal fade" id="resetPassword" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="changePasswordModalLabel">Reset Password</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="false">&times;</span>
                                    </button>
                                  </div>
                                    <form id="email_send_for_pass_change_id">
                                    <div class="modal-body">
                                        <div class="row col-md-12"> 
                                        <label for="current-password" class="col-sm-4 control-label float-left">User ID<sup style="color:red;">*</sup></label>
                                        <div class="col-sm-8 float-left">
                                          <div class="form-group">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                                            <input type="text" class="form-control" id="employee_user_id" name="employee_userid" placeholder="Keep your UserID" required>
                                          </div>
                                        </div>            
                                          <label for="current-password" class="col-sm-4 control-label float-left">Email<sup style="color:red;">*</sup></label>
                                          <div class="col-sm-8 float-left">
                                            <div class="form-group">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                                              <input type="email" class="form-control" id="employee_email_id" name="employee_email" placeholder="Keep your email that are liked with this account!" required>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="padding: 10px 35px;">
                                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                      <!-- <button id="userIDandEmail" type="submit" class="btn btn-success ladda-button" data-style="expand-right" data-size="xs">Submit</button> -->
                                      <button id="userIDandEmail"  type="submit" class="btn btn-success  ladda-button" data-style="expand-left"><span class="ladda-label">Submit</span></button>
                                    </div>
                                    </form>

                                    <!-- OTP send section start -->
                                    <form id="one_time_pass_id" style="display: none;">

                                    <div class="modal-body">
                                        <div class="row col-md-12">             
                                          <label for="current-password" class="col-sm-4 control-label float-left">OTP<sup style="color:red;">*</sup></label>
                                          <div class="col-sm-8 float-left">
                                            <div class="form-group">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                                              <input type="hidden" name="employee_userid" class="employee_userid_id"> 
                                              <!-- <input type="text" class="form-control" id="current-email" name="employee_userid" placeholder="Keep your UserID" required> -->
                                              <input type="number" class="form-control" name="employee_otp" placeholder="Enter your OTP">
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="padding: 10px 35px;">
                                      <button type="button" id="backToEmailPage"><i class="fa fa-backward"></i> Back</button>
                                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                    </form>
                                    <!-- OTP send section start -->

                                    <!-- OTP send section start -->
                                    <form id="new_pass_two_times" style="display: none;">
                                    <div class="modal-body">
                                        <div class="row col-md-12">             
                                          <label for="password" class="col-sm-5 control-label float-left">New Password<sup style="color:red;">*</sup></label>
                                          <div class="col-sm-7 float-left">
                                            <div class="form-group">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                                              <input type="hidden" name="employee_userid" class="employee_userid_id"> 
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
                                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </form>
                              <!-- OTP send section start -->
                            </div>
                          </div>
                        </div>

<script>
    @if (session('status'))
        toastr.success('{{ session('status') }}', 'Success', {
            closeButton: true,
            newestOnTop: true,
            progressBar: true,
        });
    @endif

    $("#email_send_for_pass_change_id").submit(function(stay){
      // alert('ok');
      // Ladda.bind( '#userIDandEmail', { timeout: 1000000 } );
      var l = Ladda.create(document.querySelector('#userIDandEmail'));
	 	  l.start();
       var formdata = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: "{{ url('/') }}/emailSendForPassChange",
            data: formdata,
            success: function (data) {
              // console.log(data);
              if (data.userid_match==4) {
                alert('User ID Not Match, Enter Correct UserID!');
                return false;
              }
              if (data.email_match == 3 || data.email_match == 2) {
                alert('Email Not Match, Enter Correct Email Address!');
                return false;
              }
              if (data.email_match==1) {
                $('.employee_userid_id').val(data.employee_userid);
                $('#one_time_pass_id').css('display', 'inline');
                $('#email_send_for_pass_change_id').css('display', 'none');
                alert('A OTP has been sent to your email, check your email!');
                $("#email_send_for_pass_change_id")[0].reset();
                // $('#lateApproveRequest').modal('toggle');
              }
              l.stop()
            },
        });
        stay.preventDefault(); 
    });

    $("#backToEmailPage").on('click', function(){
      // alert('fasf');
        $('#one_time_pass_id').css('display', 'none');
        $('#email_send_for_pass_change_id').css('display', 'inline');
    });

    $("#one_time_pass_id").submit(function(stay){
      // alert('ok');
      var l = Ladda.create(this);
	 	  l.start();
       var formdata = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: "{{ url('/') }}/otpChecking",
            data: formdata,
            success: function (data) {
              if (data.otp_match==1) {
                 alert('OTP Match! Enter your new password!');
                 $('.employee_userid_id').val(data.employee_userid);
                 $('#new_pass_two_times').css('display', 'inline');
                 $('#one_time_pass_id').css('display', 'none');
                 $('#email_send_for_pass_change_id').css('display', 'none');
                 $("#one_time_pass_id")[0].reset();
               }else if(data.otp_match==0){
                  alert('OTP Not Match! Enter Correct OTP!');
                  return false;
               }
               l.stop();
            },
        });
        stay.preventDefault(); 
    });

    $("#new_pass_two_times").submit(function(stay){
      // alert('ok');
        var l = Ladda.create(this);
        l.start();
       var formdata = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: "{{ url('/') }}/createNewPass",
            data: formdata,
            success: function (data) {
              if (data.pass_change_suceessfull==1) {
               alert('Password Changed Successful!');
                $('#resetPassword').modal('toggle');
                $(this).find('#resetPassword')[0].reset();
              }else{
                alert('Password & Confirmation Password Not Match!');
                return false;
              }  
              l.stop();
            },
        });
        stay.preventDefault(); 
    });

    $("#employee_user_id").on('input', function(stay){
      // var formdata = $(this).serialize();
      var l = Ladda.create(this);
	 	  l.start();
      var employee_userid = $('#employee_user_id').val();
      if(!employee_userid){
        $('#employee_email_id').val('');
      }
      if(employee_userid.length >= 6 ){
        $.ajax({
            type: 'POST',
            url: "{{ url('/') }}/find_user_email_id",
            // data: formdata,
            data: {
              "_token": "{{ csrf_token() }}",
              "employee_userid": employee_userid
            },
            success: function (data) {
              if (data.employee_email_id != '') {
                $('#employee_email_id').val(data.employee_email_id);
              }else if(data.employee_email_id==0){
                alert('Email ID Not Found! Please enter your correct Employee ID.');
                return false;
              }
              l.stop();
            },
        });
      }
      stay.preventDefault(); 
    });

    // Bind normal buttons
    // Ladda.bind( 'div:not(.progress-demo) button', { timeout: 1000000 } );

    //calculate the time before calling the function in window.onload
    var beforeload = (new Date()).getTime();

    // function getPageLoadTime() {
    //   //calculate the current time in afterload
    //   var afterload = (new Date()).getTime();
    //   // now use the beforeload and afterload to calculate the seconds
    //   seconds = (afterload - beforeload) / 1000;
    //   // Place the seconds in the innerHTML to show the results
    //   // $("#load_time").text('Loaded in  ' + seconds + ' sec(s).');
    //   return seconds;
    // }

    // window.onload = getPageLoadTime;

    // alert(getPageLoadTime());

    // Bind progress buttons and simulate loading progress
    Ladda.bind( '.progress-logging button', {
        callback: function( instance ) {
            var progress = 0;
            var interval = setInterval( function() {
                progress = Math.min( progress + Math.random() * 0.03, 1 );
                // progress = Math.min( progress + Math.random() * seconds, 1 );
                // alert(progress);
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
</script>

<script type="text/javascript">
            //  $(document).ready(function() {
            //      console.log("Time until DOMready: ", Date.now()-timerStart);
            //  });
            //  $(window).load(function() {
            //      console.log("Time until everything loaded: ", Date.now()-timerStart);
            //  });
        </script>
@endsection

