<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 
	<style type="text/css">
		body{
			font-size: 12px;
			font-weight: normal;
			text-align: left;
		}
		.body_td td{
			padding: 2px 10px;
		}

		@media print {
		  body * {
		    visibility: hidden;
		  }
		  .section-to-print, .section-to-print * {
		    visibility: visible;
		  }
		}
	</style>       
</head>
<body>
	<div class="col-md-12">
		<button id="myButtonControlID" class="btn-success float-right" style="margin-left:10px;">Export</button>
		<button onclick="window.print()" class="btn-info float-right">Print</button>
	</div>
	<br>
	<div class="container">
		<div id="divTableDataHolder" class="section-to-print col-md-12">
			<!-- <div class="col-md-12">
				<h3 class="text-center">Gemcon Group</h3>
				<h5 class="text-center">Daily Attendance Report</h5>
				<h6 class="text-center">
				 Date: <?php //echo $date_print['from_date_formated']; ?></h6>
			</div> -->
			<?php 
				// echo "<pre>"; print_r($all_data); die();
			 ?>
			<div class="col-lg-12"> 
                <h3>Daily Attendance Summary Report 
                </h3>
                <div class="row">
                    <div class="col-md-10">Date <b>
                    	<?php 
                    		echo $from_date = date('d M Y', strtotime($all_data['search_option']['from_date_formated']));
                    	 ?>
                    </b></div>
                </div>

                <div class="row"><div class="col-md-10">Company:  <b>
                	<?php 
                		echo isset($all_data['company_sbu']['sbu_name'])?$all_data['company_sbu']['sbu_name']:'';
                	 ?>
                </b></div></div>
                    
                <div class="table-responsive" style=" margin:auto;">
                    <table border="1" style=" width: 250px; margin-top: 20px; font-size: 14px; ">                       
                        <tbody><tr>
                            <td style=" width: 75%; padding-left: 5px;">Present</td>
                            <td style=" width: 25%; text-align: center;">
                            	<?php 
                            		echo $all_data['present_data']->present_count;
                            	 ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left: 5px;"> Absent</td>
                            <td align="center">
                            	<?php 
                            		echo $all_data['absent_data']->absent_count;
                            	 ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left: 5px;"> Late</td>
                            <td align="center">
                            	<?php 
                            		echo $all_data['late_data']->late_count;
                            	 ?>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td style="padding-left: 5px;"> OSD</td>
                            <td align="center">1</td>
                        </tr> -->
                        <tr>
                            <td style="padding-left: 5px;"> Leave</td>
                            <td align="center">
                            	<?php 
                            		echo $all_data['leave_data']->leave_count;
                            	 ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left: 5px;"><b>Total Employee</b></td>
                            <td align="center"><b>
                            	<?php 
                            		echo $all_data['present_data']->present_count+$all_data['absent_data']->absent_count+$all_data['late_data']->late_count+$all_data['leave_data']->leave_count;
                            	 ?>
                            </b></td>
                        </tr>
                    </tbody></table>
                </div>             
            </div>
		</div>
	</div>
<script type="text/javascript">
	$("[id$=myButtonControlID]").click(function(e) {
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=divTableDataHolder]').html()));
    e.preventDefault();
});
</script>
</body>
</html>

