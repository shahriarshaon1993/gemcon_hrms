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

	<div class="col-md-12">
		<div id="divTableDataHolder" class="section-to-print col-md-12">
			<!-- <div class="col-md-12">
				<div class="col-md-12">
					<div class="col-md-12" style="padding: 0px;">
					<div class="col-md-2 float-left" style="padding: 0px;">
				

						<?php 

						if (!empty($company_id)) {
							$companyLogo=collect($periodicinfo)->where('id',$company_id[0])->first();
							
							if(!empty($companyLogo)){

								if($companyLogo['sbu_logo'] !=""){ ?>
									<img src="{{asset('company_logo/'.$companyLogo['sbu_logo'])}}"  style="width:50%;">
							<?php 							
								}else{
									echo 'No Logo Found';
								}
							}else{
								echo 'No Logo Found';
							}	
						}else{ ?>

							<img src="{{asset('company_logo/group_company_logo.png')}}" width="100
									" height="60" >
					<?php		
							
						}	
					?>

					</div>

				<div class="col-md-6" style="padding: 0px">
					<h3 class="text-center">Gemcon Group</h3>
					<h4 class="text-center">
						<?php 
						if(!empty($companyLogo)){
							echo $companyLogo['sbu_name'];
						}  ?>
					</h4>
					<h6 class="text-center">Periodic Attendance Report Details</h65>
					<h6 class="text-center">

					 Date:  <?php date("d M,Y"); ?> </h6>
				</div>
				<div class="col-md-3" style="padding: 0px;margin-top: 17px;">
					<p ><strong> Print Date :</strong> <?php echo date("d M,Y"); ?> </p>
					<p style="margin-top: -7px"><strong> Created By :</strong> {{ $created_by}} </p>
				</div>


				</div>
				<br>
			</div> -->
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
					<h6 class="text-center">Periodic Attendance Report Details </h6>
						
					<h6 class="text-center">

					 Date:  {{$date_report}}</h6>
				</div>
				<div class="col-md-3" style="padding: 0px;margin-top: 17px;">
					<p ><strong> Print Date :</strong> <?php echo date("d M,Y"); ?> </p>
					<p style="margin-top: -7px"><strong> Created By :</strong> {{ $created_by}} </p>
				</div>
			</div>	
			<table class="table table-bordered" border="1">
				<thead>
				  <tr style="background: #eee;">
				  	<th style="padding:2px 8px; text-align: center;vertical-align: middle;">#</th>
				  	<th style="padding:2px 8px; text-align: center;vertical-align: middle;">Employee ID</th>
				  	<th style="padding:2px 8px; text-align: center;vertical-align: middle;">Name</th>
				  	<th style="padding:2px 8px; text-align: center;vertical-align: middle;">Designation</th>
				  	<?php if (empty($company_id)) {?>
				  	<th style="padding:2px 8px; text-align: center;vertical-align: middle;">Company</th>
				  	<?php } ?>
				  	<th style="padding:2px 8px; text-align: center;vertical-align: middle;">Pr</th>
                    <th style="padding:2px 8px; text-align: center;vertical-align: middle;">Ab</th>
                    <th style="padding:2px 8px; text-align: center;vertical-align: middle;">Lt</th>
                    <!-- <th>OSD</th> -->
                    <th style="padding:2px 8px; text-align: center;vertical-align: middle;">Lv</th>
                    <th style="padding:2px 8px; text-align: center;vertical-align: middle;">Hd</th>
                    <th style="padding:2px 8px; text-align: center;vertical-align: middle;">Tot</th>
                    <?php foreach ($dates as $dat) { ?>
                        <th style="padding:2px 8px; text-align: center;vertical-align: middle;"><?php echo $dat; ?></th>
                    <?php } ?>
				  </tr>
			  </thead>
			  <tbody>
			  	<?php
                    $i = 0;
                    foreach ($emparr as $emrow) {
                    	// echo "<pre>"; print_r($emrow); exit();
                        ?>
                        <tr>
                            <td align="center"><?php echo ++$i; ?></td>
                            <td class="text-center"><?php echo $emrow['official_id'] ?></td>
        				  	<td><?php echo $emrow['name'] ?></td>
        				  	<td><?php echo $emrow['desgname'] ?></td>
        				  	<?php if (empty($company_id)) {?>
        				  	<td><?php echo $emrow['compname'] ?></td>
        				  	<?php } ?>
                            <td align="center" style="background: #eaeef285;"><?php echo $emrow['prtot']; ?></td>
                            <td align="center" style="background: #eaeef285;"><?php echo $emrow['abtot']; ?></td>
                            <td align="center" style="background: #eaeef285;"><?php echo $emrow['lttot']; ?></td>
                            <td align="center" style="background: #eaeef285;"><?php echo $emrow['levtot']; ?></td>
                            <td align="center" style="background: #eaeef285;" ><?php echo $emrow['whtot']; ?></td>
                            <td align="center" style="background: #eaeef285;font-weight: 600"><?php echo $emrow['total']; ?></td> 
                            <?php 
                            foreach ($dates as $key => $value):
                            	$color='';
                            	if($key==0){
                        			$date=date('d',strtotime($value));
                        		}else{
                        			$date=$value;
                        		} 
	                            if (in_array( $date, $emrow['datearrlist'])) 
	                           	{
	                            	$key_date_list = array_search($date, $emrow['datearrlist']);
	                            	if($emrow['datearr'][$key_date_list]==2){
	                            		$color='#ffc107!important';
	                            	}elseif($emrow['datearr'][$key_date_list]==3){
	                            		$color='#dc3545!important';
	                            	}else{
	                            		$color='#ffffff';
	                            	}
	                             }
                            ?>
                            	<td align="center" style="background:{{$color}};vertical-align: middle;">
                            		<?php 
                            		if($key==0){
                            			$date=date('d',strtotime($value));
                            		}else{
                            			$date=$value;
                            		}
                            		
                            		if (in_array( $date, $emrow['datearrlist'])) 
                            		  {
                            		 	$key_date_list = array_search($date, $emrow['datearrlist']);
                            		 	// echo "<pre>";
                            		 	// print_r($date);
                            		 	// exit();

                                    	if ($emrow['datearr'][$key_date_list]==1) {
                                    		echo "<span style='color:green;'>P</span>";
                                    		
                                    	}elseif($emrow['datearr'][$key_date_list]==2){
                                    		echo "<span style='color:#fff;'>L</span>";
                                    		
                                    	}elseif($emrow['datearr'][$key_date_list]==3){
                                    		echo "<span style='color:#fff;'>A</span>";
                                    	
                                    	}elseif($emrow['datearr'][$key_date_list]==4 || $emrow['datearr'][$key_date_list]==5){
                                    		echo "W/H";
                                    		
                                    	}elseif($emrow['datearr'][$key_date_list]==6 || $emrow['datearr'][$key_date_list]==7){
                                    		echo "LV";
                                    	} 
                            		  }else{
                                		echo "-";
                                	}
                                    ?>
                            	</td>	
                            <?php 
		                   endforeach 
                        ?>
                        <?php
                        }
                        if ($i < 1) {
                            ?>
                        <!-- <tr> -->
                            <h2>No data found</h2>
                        <!-- </tr> -->
                    <?php } ?> 
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

