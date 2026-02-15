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
	<style>
		.loader {
		  border: 16px solid #f3f3f3;
		  border-radius: 50%;
		  border-top: 16px solid #3498db;
		  width: 120px;
		  height: 120px;
		  -webkit-animation: spin 2s linear infinite; /* Safari */
		  animation: spin 2s linear infinite;
		}

		/* Safari */
		@-webkit-keyframes spin {
		  0% { -webkit-transform: rotate(0deg); }
		  100% { -webkit-transform: rotate(360deg); }
		}

		@keyframes spin {
		  0% { transform: rotate(0deg); }
		  100% { transform: rotate(360deg); }
		}
</style>     
</head>
<body>
	
<div>
	<div class="col-md-12">
		<button id="btnExport" class="btn-success float-right" style="margin-left:10px;">Export</button>
		<button onclick="window.print()" class="btn-info float-right">Print</button>
	</div>
	<br>
	<div id="tblCustomers" class="container">
		
	</div>
</div>		
<!-- <script type="text/javascript">
	$("[id$=myButtonControlID]").click(function(e) {
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=divTableDataHolder]').html()));
    e.preventDefault();
});
</script> -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="https://rawgit.com/unconditional/jquery-table2excel/master/src/jquery.table2excel.js"></script>

<script type="text/javascript">
	$("#btnExport").click(function () {
            $("#tblCustomers").table2excel({
               exclude: ".noExl",
        filename: "ListOfEmployees.xls",
        exclude_img: true,
        preserveColors: true
            });
        });
</script>



</body>
</html>

