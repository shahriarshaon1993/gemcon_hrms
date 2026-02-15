<style>
.loader {
  border: 10px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #fec23c;
  border-bottom: 16px solid #fec23c;
  width: 80px;
  height: 80px;
      position: fixed;
    left: 50%;
    top: 50%;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

#loader-wrapper .loader {
    position: fixed;
    top: 0;
    width: 100%;
    height: 100%;
    background: #222222;
}
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
@include('includs.deshboard_header')
	<?php 
	$employsData=DB::table('employees')->where('id',Auth::guard('user')->user()->employee_id)->first();
	$companyTheme=DB::table('company_sbus')->where('id',$employsData->employee_sbu)->first();
	if(!empty($companyTheme)){
		$backgroundCollor=$companyTheme->modal_header_color;
		$fontColor=$companyTheme->header_font_color;
		$fontSizes=$companyTheme->header_font_size.'px';
	}else{
		$backgroundCollor='#fec23c';
		$fontColor='#fff';
		$fontSizes='15px';
	}

	
?>
	<div class="loader loader-wrapper">
		
	</div>
	 <nav class="main-header navbar navbar-expand navbar-white navbar-light"  style="background: {{$backgroundCollor}}">
	 	 <ul class="navbar-nav">
		      <li class="nav-item">
		        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		      </li>
		      <li class="nav-item d-none d-sm-inline-block">
		        <a href="/index" class="nav-link">Home</a>
		      </li>
		    </ul>
		    <!-- SEARCH FORM -->
		    <form class="form-inline ml-3">
		      <div class="input-group input-group-sm">
		        <input class="form-control form-control-navbar" id="myInput" type="search" placeholder="Search" aria-label="Search">
		        <div class="input-group-append">
		          <button class="btn btn-navbar" id="myBtn" type="submit">
		            <i class="fas fa-search"></i>
		          </button>
		        </div>
		      </div>
		    </form>
	 	<!-- <div id="app"> -->

       		<!-- <pos-topbar></pos-topbar>  -->
       <!-- </div> -->
       	
	 	 <!-- Right navbar links -->
		    <ul class="navbar-nav ml-auto">
		      <li class="nav-item">
		        <a class="nav-link" href="/index"><i class="fas fa-th-large"></i></a>
		            <!-- <router-link to="/index" class="nav-link">
		              <i class="fas fa-th-large"></i>
		            </router-link> -->
		      </li>
		      <!-- <li class="nav-item">
		        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
		            class="fas fa-th-large"></i></a>
		      </li> -->
		      <!-- Messages Dropdown Menu -->
		      <!-- <li class="nav-item dropdown">
		        <a class="nav-link" data-toggle="dropdown" href="#">
		          <i class="far fa-comments"></i>
		          <span class="badge badge-danger navbar-badge">3</span>
		        </a>
		        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
		          <a href="#" class="dropdown-item">
		            <div class="media">
		              <img src="admin_assets/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
		              <div class="media-body">
		                <h3 class="dropdown-item-title">
		                  Brad Diesel
		                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
		                </h3>
		                <p class="text-sm">Call me whenever you can...</p>
		                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
		              </div>
		            </div>
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item">
		            <div class="media">
		              <img src="admin_assets/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
		              <div class="media-body">
		                <h3 class="dropdown-item-title">
		                  John Pierce
		                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
		                </h3>
		                <p class="text-sm">I got your message bro</p>
		                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
		              </div>
		            </div>
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item">
		            <div class="media">
		              <img src="admin_assets/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
		              <div class="media-body">
		                <h3 class="dropdown-item-title">
		                  Nora Silvester
		                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
		                </h3>
		                <p class="text-sm">The subject goes here</p>
		                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
		              </div>
		            </div>
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
		        </div>
		      </li> -->
		      <!-- Notifications Dropdown Menu -->
		      <li class="nav-item dropdown">
		        <a class="nav-link" data-toggle="dropdown" href="#">
		          <i class="far fa-bell"></i>
		          <span class="badge badge-warning navbar-badge">15</span>
		        </a>
		        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
		          <span class="dropdown-item dropdown-header">15 Notifications</span>
		          <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item">
		            <i class="fas fa-envelope mr-2"></i> 4 new messages
		            <span class="float-right text-muted text-sm">3 mins</span>
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item">
		            <i class="fas fa-users mr-2"></i> 8 friend requests
		            <span class="float-right text-muted text-sm">12 hours</span>
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item">
		            <i class="fas fa-file mr-2"></i> 3 new reports
		            <span class="float-right text-muted text-sm">2 days</span>
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
		        </div>
		      </li>

		      <!-- Notifications Dropdown Menu -->
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" style="padding-top:4px;">
		            <!-- <img src="{{asset('admin_assets/images/default.png')}}" width="30" height="30" class="rounded-circle"> -->
		            <?php 

		            // echo "<pre>"; print_r($employee_data); 
		            	$username = isset($user->name)?$user->name:'';
		            	$employee_image = isset($employee_data['employee_image'])?$employee_data['employee_image']:'';
		             ?>
		             <?php if (!empty($employee_image)): ?>
		             	<img src="{{asset('images/'.$employee_image )}}" width="30" height="30" class="rounded-circle">
		             <?php else: ?>
		             	<img src="{{asset('images/default.png')}}" width="30" height="30" class="rounded-circle">
		             <?php endif ?>
		            <span>{{$username}}</span>
		        </a>
		        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right profile-setting">
		          <!-- <a href="#" class="dropdown-item">
		            <i class="fa fa-user mr-2"></i> Profile
		          </a> -->
		          <a href="#" class="dropdown-item">
		            <i class="fa fa-key mr-2"></i> Change Password
		          </a>

		          <div class="dropdown-divider"></div>
		          <a href="{{ route('user.logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="dropdown-item">  <i class="fa fa-sign-out-alt mr-2"></i> Log Out</a>

		          <!-- <a href="http://localhost/gemconerp/index.php" class="dropdown-item">
		            <i class="fa fa-sign-out-alt mr-2"></i> Logout
		          </a> -->
		          <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                       @csrf
                </form>
		        </div>
		      </li>
		    </ul>
	 </nav>



<div id="app">

       <!-- <pos-topbar></pos-topbar>   -->
       <pos-sidebar></pos-sidebar>
        <div class="content-wrapper">
	        <bredcrumb></bredcrumb>
	        <!-- <div class="row">  -->
	        		<router-view></router-view>
	       <!-- </div> -->
	        

       </div>
        
</div>  
<style type="text/css">
	.modal-header {
	    background: {{ $backgroundCollor }};
	    color:{{ $fontColor }};
	}
	.modal-header > h4{
		 font-size:{{$fontSizes}};
	}

</style>
<script src="<?php echo url(route('payroll.jsBaseURLs')); ?>"></script>  
<script src="{{asset('js/app.js')}}"></script>
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>

@include('includs.deshboard_footer')
</body>
</html>
<script type="text/javascript">
	$('.dropdown-toggle').dropdown();
</script>
<script>
	$(document).ready(function(){
	    $("#myBtn").click(function(){
	        var str = $("#myInput").val();
	        var url = window.location.href;
	        if(str === '1001'){
	        	var myWindow = window.open(url+'salary_list');
	        }
	        if(str === '1002'){
	        	var myWindow = window.open(url+'provident_fund');
	        }
	        if(str === '1003'){
	        	var myWindow = window.open(url+'gratuity_fund');
	        }
	        if(str === '1004'){
	        	var myWindow = window.open(url+'arrear_others_allowance');
	        }
	        if(str === '1005'){
	        	var myWindow = window.open(url+'increment_list');
	        }
	        if(str === '1006'){
	        	var myWindow = window.open(url+'loan_advance');
	        }
	        if(str === '1007'){
	        	var myWindow = window.open(url+'salary_setting');
	        }
	        if(str === '1008'){
	        	var myWindow = window.open(url+'tax_setting');
	        }
	        if(str === '1009'){
	        	var myWindow = window.open(url+'payroll_permission');
	        }
	        if(str === '1010'){
	        	var myWindow = window.open(url+'payroll_permission_assign');
	        }
	        if(str === '1011'){
	        	var myWindow = window.open(url+'payrollprocess');
	        }
	        if(str === '1012'){
	        	var myWindow = window.open(url+'payroll_list');
	        }
	        if(str === '1013'){
	        	var myWindow = window.open(url+'pay_slip');
	        }
	        
	        // alert(myWindow);
	    });
	});
</script>