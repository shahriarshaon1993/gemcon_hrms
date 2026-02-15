@include('includs.deshboard_header')
@include('includs.dashboard_header_navbar')
<div id="app">
<pos-sidebar></pos-sidebar>
	<div class="content-wrapper">
		<bredcrumb></bredcrumb>
		<router-view></router-view>
	</div>
</div>  
<script src="<?php echo url(route('hrm.jsBaseURLs')); ?>"></script>  
<script src="{{asset('js/app.js')}}"></script>
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
@include('includs.deshboard_footer')
</body>
</html>





