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
			 <div class="row" style="margin-left: 21px;"> 		
				<div class="col-md-3" style="padding: 0px;margin-top: 17px;">
					<!-- width="100 -->
									<!-- " height="60" -->
					<?php 
							// echo "<pre>";
							// print_r($company_sbus);
							// exit();
						if (!empty($sbuName)) {
							$companyLogo=$sbuName;							
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
				</div>

				<div class="col-md-6" style="padding: 0px">
					<h3 class="text-center" style="margin:0px;">Gemcon Group</h3>
					<h5 class="text-center" style="margin:0px;">
						{{$esbuName}}
					</h4>
					<h6 class="text-center" style="margin:0px;">{{$deptnameName}}</h6>
					<h6 class="text-center">Periodic Attendance Report</h6>
						
					<h6 class="text-center">

					 Date:  {{$date_report}}</h6>
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
				  	<th style="padding:2px 10px; text-align: center;">Employee ID</th>
				  	<th style="padding:2px 10px; text-align: center;">Name</th>
				  	<th style="padding:2px 10px; text-align: center;">Designation</th>
				  	<?php if (empty($company_id)): ?>
				  	<th style="padding:2px 10px; text-align: center;">Company</th>
				  	<?php endif ?>
				  	<th style="padding:2px 10px; text-align: center;">Present</th>
				  	<th style="padding:2px 10px; text-align: center;">Absent</th>
				  	<th style="padding:2px 10px; text-align: center;">Late</th>
				  	<th style="padding:2px 10px; text-align: center;">Leave</th>
				  	<th style="padding:2px 10px; text-align: center;">Holiday</th>
				  	<th style="padding:2px 10px; text-align: center;">Total</th>
				  </tr>
			  </thead>
			  <tbody>
			  	<?php
			  	$i=0;
			  	foreach ($emparr as $key => $single_data): 
			  	// echo "<pre>"; print_r($single_data); die();
			  	 	$i++;
			  	?>
				  <tr class="body_td">
				  	<td style="text-align: center;"><?php echo $i; ?></td>
				  	<td class="text-center"><?php echo $single_data['official_id'] ?></td>
				  	<td><?php echo $single_data['name'] ?></td>
				  	<td><?php echo $single_data['desgname'] ?></td>
				  	<?php if (empty($company_id)): ?>
				  	<td><?php echo $single_data['compname'] ?></td>
				  	<?php endif ?>
				  	<td class="text-center"><?php echo $single_data['prtot'] ?></td>
				  	<td class="text-center"><?php echo $single_data['abtot'] ?></td>
				  	<td class="text-center"><?php echo $single_data['lttot'] ?></td>
				  	<td class="text-center"><?php echo $single_data['levtot'] ?></td>
				  	<td class="text-center"><?php echo $single_data['whtot'] ?></td>
				  	<td class="text-center"><?php echo $single_data['total'] ?></td>
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

