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
			<div class="col-md-12">
				<div class="col-md-12" style="padding: 0px;">
					<div class="col-md-2 float-left" style="padding: 0px;">
						<?php 
							if (!empty($company_id)) {
								$companyLogo=collect($dailyinfo)->where('id',$company_id)->first();
								if(!empty($companyLogo)){
									if($companyLogo['sbu_logo'] !=""){ ?>
										<img src="{{asset('company_logo/'.$value->sbu_logo)}}" width="70
										" height="50" class="rounded-circle">
								<?php 							
									}else{
										echo '';
									}
								}else{
									echo '';
								}	
							}else{
								echo '';
							}	
						?>

						
					</div>
					<div class="col-md-10 float-left" style="padding: 0px;">
						<h5 class="text-center" style="margin:0px;">Daily Attendance Report</h5>
						<h6 class="text-center" style="margin:0px;">
							Company: <?php 
								if (!empty($company_id)) {
									foreach ($dailyinfo as $key => $value) {}
									echo isset($value->sbu_name)?$value->sbu_name:'';
								}else{
									echo 'All';
								}
							 ?>
						</h6>
						<p class="text-center" style="margin:0px;">
							<strong>
							 Date: 
							 <?php 
							 	$from_date = date('d M Y', strtotime($search_option['from_date_formated']));
							 	echo $from_date; 
							 ?>
						 	</strong>
						 </p>
					 </div>
				</div>
				<br>
			</div>
			<table class="table table-bordered" border="1">
				<thead>
				  <tr style="background: #eee;">
				  	<th style="padding:2px 10px; text-align: center;">#</th>
				  	<th style="padding:2px 10px; text-align: center;">Employee ID</th>
				  	<th style="padding:2px 10px; text-align: center;">Name</th>
				  	<th style="padding:2px 10px; text-align: center;">Designation</th>
				  	<th style="padding:2px 10px; text-align: center;">Department</th>
				  	<?php if (empty($company_id)): ?>
				  	<th style="padding:2px 10px; text-align: center;">Company</th>
				  	<?php endif ?>
				  	<th style="width:12%; padding:0px !important; text-align: center;">Shift</th>
				  	<th style="padding:2px 10px; text-align: center;">In</th>
				  	<th style="padding:2px 10px; text-align: center;">Out</th>
				  	<th style="padding:2px 10px; text-align: center;">Late</th>
				  	<th style="padding:2px 10px; text-align: center;">Status</th>
				  </tr>
			  </thead>
			  <tbody>
			  	<?php
			  	$i=0;
			  	foreach ($dailyinfo as $key => $single_data): 
			  	// echo "<pre>"; print_r($single_data); die();
			  	 	$i++;
			  	?>
				  <tr class="body_td">
				  	<td style="text-align: center;"><?php echo $i; ?></td>
				  	<td class="text-center"><?php echo $single_data->employee_id_no ?></td>
				  	<td><?php echo $single_data->employee_fullname ?></td>
				  	<td><?php echo $single_data->designation_name ?></td>
				  	<td><?php echo $single_data->department_name ?></td>
				  	<?php if (empty($company_id)): ?>
				  	<td><?php echo $single_data->sbu_name ?></td>
				  	<?php endif ?>
				  	<td class="text-center" style="padding:0px !important; text-align: center;"><?php echo $single_data->shift_time ?></td>
				  	<td class="text-center"><?php echo $single_data->intime ?></td>
				  	<td class="text-center"><?php echo $single_data->outime ?></td>
				  	<td class="text-center"><?php echo $single_data->latetime ?></td>
				  	<td class="text-center"><?php 
				  		// echo $single_data->pstatus 
				  		if ($single_data->pstatus==1) {
				  			echo "<span style='color:green;'>P</span>";
				  			
				  		}elseif($single_data->pstatus==2){
				  			echo "L";
				  			
				  		}elseif($single_data->pstatus==3){
				  			echo "A";
				  		
				  		}elseif($single_data->pstatus==4){
				  			echo "W/H";
				  			
				  		}elseif($single_data->pstatus==5){
				  			echo "H";
				  			
				  		}elseif($single_data->pstatus==6 || $single_data->pstatus==7){
				  			echo "LV";
				  		} 
				  	?></td>
				  </tr>
			  	<?php endforeach ?>
			  </tbody>
			</table>
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

