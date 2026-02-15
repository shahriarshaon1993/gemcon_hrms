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
				<div class="col-md-12">
				

				<div class="row" style="margin-left: 21px;"> 		
				<div class="col-md-3" style="padding: 0px;margin-top: 17px;">
					<!-- width="100 -->
									<!-- " height="60" -->
					<?php 
							
						if (!empty($sbuName)) {
							$companyLogo=$sbuName;				
							// echo "<pre>";
							// print_r($sbuName);
							// exit();			
							if(!empty($companyLogo)){
								if($companyLogo['sbu_logo'] !=""){ ?>
									<img src="{{asset('company_logo/'.$companyLogo['sbu_logo'])}}"  style="width:50%;">
							<?php 							
								}else{
									echo 'No Logo Found';
								}
							}else{ ?>
								<img src="{{asset('company_logo/group_company_logo.png')}}" width="100
									" height="60" >
						<?php	}	
						}else{ ?>

							<img src="{{asset('company_logo/group_company_logo.png')}}" width="100
									" height="60" >
					<?php		
							
						}	
					?>
					<h6  style="margin:0px;">
						<?php echo $all_data['employee_info']['employee_fullname'] ?> [  <?php echo $all_data['employee_info']['employee_id_no'] ?> ]
					<!-- Gemcon Group -->
					</h6>
				
					 <p  style="margin:0px;"><strong> Designation: </strong> <?php echo $all_data['employee_info']['designation_name'] ?></p>
					 
				</div>

				<div class="col-md-6" style="padding: 0px">
					<h3 class="text-center" style="margin:0px;">Gemcon Group</h3>
					<h5 class="text-center" style="margin:0px;"><?php echo $all_data['employee_info']['sbu_name'] ?></h5>
					<h5 class="text-center" style="margin:0px;">{{$deptnameName}}</h5>
					<h6 class="text-center">Individual Attendance Report</h6>
					<h6 class="text-center">{{$date_report}}</h6>
					
				</div>
				<div class="col-md-3" style="padding: 0px;margin-top: 17px;">
					<p ><strong> Print Date :</strong> <?php echo date("d M,Y"); ?> </p>
					<p style="margin-top: -7px"><strong> Created By :</strong> {{ $created_by}} </p>
				</div>
			</div>	
				<br>
			</div>
			<table class="table table-bordered" border="1">
				<thead>
				  <tr style="background: #eee;">
				  	<th style="padding:2px 10px; text-align: center;">#</th>
				  	<th style="padding:2px 10px; text-align: center;">Date</th>
				  	<th style="padding:2px 10px; text-align: center;">In Time</th>
				  	<th style="padding:2px 10px; text-align: center;">Out Time</th>
				  	<th style="padding:2px 10px; text-align: center;">Late</th>
				  	<th style="padding:2px 10px; text-align: center;">Start Time</th>
				  	<th style="padding:2px 10px; text-align: center;">End Time</th>
				  	<!-- <th style="padding:2px 10px; width: 5%; text-align: center;">Status</th> -->
				  	<th style="padding:2px 10px; width: 5%; text-align: center;">Remarks</th>
				  </tr>
			  </thead>
			  <tbody>
			  	<?php
			  	//  echo "<pre>";
			  	// print_r($all_data['search_option']);
			  	// exit();
			  	$i=0;
			  	 foreach ($all_data['attendance_data'] as $key => $single_data): 
			  	 	$i++;
			  	?>
				  <tr class="body_td">
				  	<td style="text-align: center;"><?php echo $i; ?></td>
				  	<td class="text-center">
				  		<?php   
				  			$pdate = date('d M Y', strtotime($single_data->pdate));
				  			echo isset($single_data->pdate)?$pdate:''; 
				  		?>
				  	</td>
				  	<td class="text-center"><?php echo isset($single_data->intime)?$single_data->intime:''; ?></td>
				  	<td class="text-center"><?php echo isset($single_data->outime)?$single_data->outime:''; ?></td>
				  	<td class="text-center"><?php echo isset($single_data->latetime)?$single_data->latetime:''; ?></td>
				  	<td class="text-center"><?php echo isset($single_data->start_time)?$single_data->start_time:''; ?></td>
				  	<td class="text-center"><?php echo isset($single_data->end_time)?$single_data->end_time:''; ?></td>
				  	<!-- <td class="text-center">
				  		<?php
				  		 //echo isset($single_data->pstatus)?$single_data->pstatus:''; 
				  		?>
				  	</td> -->
				  	<td class="text-center"><?php echo isset($single_data->remarks)?$single_data->remarks:''; ?></td>
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

