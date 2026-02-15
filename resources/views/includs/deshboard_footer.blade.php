  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 1979-<?php echo date('Y'); ?> <a href="http://gemcongroup.com/" target="_blank">Gemcon Group</a></strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 2.0.1
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"  crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"  crossorigin="anonymous"></script>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('admin_assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('admin_assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>

<!-- DataTables -->
<script src="{{asset('admin_assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<!-- AdminLTE App -->
<script src="{{asset('admin_assets/dist/js/adminlte.js')}}"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('admin_assets/dist/js/demo.js')}}"></script>
<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('admin_assets/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('admin_assets/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('admin_assets/plugins/chart.js/Chart.min.js')}}"></script>
<!-- PAGE SCRIPTS -->
<script src="{{asset('admin_assets/dist/js/pages/dashboard2.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('admin_assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('admin_assets/dist/js/datepicker.min.js')}}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script src="{{asset('admin_assets/assets/js/select2.min.js')}}"></script>

<!-- Custom CSS & JS link -->
<script src="{{asset('admin_assets/assets/custom.js')}}"></script>
</body>
</html>



<script type="text/javascript">
	//Initialize Select2 Elements
	$('.select2').select2()

	//Initialize Select2 Elements
	$('.select2bs4').select2({
	  theme: 'bootstrap4'
	})


</script>

<script type="application/javascript">
	$('.dropdown-toggle').dropdown();
	$(document).ready(function() {
		var employee_id = "<?php echo Auth::guard('user')->user()->employee_id; ?>";
		$.ajax({
			type: 'GET',
			url: "{{ url('/') }}/find_unreadNotifications/" + employee_id,
			success: function(data) {
				const get_leave_application = data.get_leave_application;
				const get_late_application = data.get_late_application;
				const get_manual_attendance = data.get_manual_attendance;
				const get_service_requests = data.get_service_requests;
				const get_stationery_services = data.get_stationery_services;

				const summary_data = data.summary_data;
				const total_notifications = get_leave_application + get_late_application + get_manual_attendance + get_service_requests + get_stationery_services;
				$("#get_leave_application").text(get_leave_application);
				$("#get_late_application").text(get_late_application);
				$("#get_manual_attendance").text(get_manual_attendance);
				$("#get_service_requests").text(get_service_requests);
				$("#get_stationery_services").text(get_stationery_services);
               
				$(".total_notifications").text(total_notifications);
				$("#summary_data").text(summary_data);
			},
			error: function() {
				console.log('Error occured!');
			}
		});
	});

	$('#notificationsMore').on('click', function(event) {
		event.stopPropagation();
        $('.more_notifications').css('display', 'block');
        $('#notificationsLess').css('display', 'block');
		$('#notificationsMore').css('display', 'none');
    });
	$('#notificationsLess').on('click', function(event) {
		event.stopPropagation();
        $('.more_notifications').css('display', 'none');
        $('#notificationsLess').css('display', 'none');
        $('#notificationsMore').css('display', 'block');
    });
</script>
