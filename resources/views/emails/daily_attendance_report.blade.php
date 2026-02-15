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
  <script type="text/php">
    if (isset($pdf)) {
        $x = 250;
        $y = 10;
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 14;
        $color = array(255,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
</script>
  <div class="col-md-12" style="size: landscape;">
<table id="tblCustomers" style="width:100%"> <tr> <td > <div class="row"> 
           <div   class="section-to-print col-md-12">
           <table style="width:100%"> <tr> <td style="width:20%">
           <div class="row" style="margin-left: 21px;">  
            <div class="col-md-12" style="padding: 0px;margin-top: 17px;">
              @php 
                  if (!empty($company_id)) {
                  $companyLogo1=collect($company_sbus)->where("id",$company_id[0])->first();
                  
                  if(!empty($companyLogo1)){

                    if($companyLogo1["sbu_logo"] !=""){ 
                      $url= "/company_logo/".$companyLogo1["sbu_logo"];
                      
                    }else{
                      $table.="No Logo Found";
                    }
                  }else{
                    $table.="No Logo Found";
                  } 
                }else{ 
                  $url= "/company_logo/group_company_logo.png";
                  
                               
                } 
             @endphp
            </div></td><td style="width:60%">
            <div class="col-md-12" style="padding: 0px">
              <h3 class="text-center" style="margin:0px;text-align: center!important;">Gemcon Group</h3>
              <h4 class="text-center" style="margin:0px;text-align: center!important;">{{$sbuNames}}</h4>
              <h5 class="text-center" style="text-align: center!important;">{{$report_name}}</h5>
              <h6 class="text-center" style="text-align: center!important;">

               Date: {{$date_report}}</h6>
            </div> </td> <td style="width:20%">
            <div class="col-md-12" style="padding: 0px;margin-top: 17px;">
              <p ><strong> Print Date :</strong>{{date("d M,Y")}}</p>
              <p style="margin-top: -7px"><strong> Created By :</strong> {{ $created_by}}</p>
            </div>
            </div>
          </td>
        </tr>
      </table>

          <table  class="table table-bordered" border="0" style="width:100%">
                  <thead>
                    <tr style="background: #eee;">
                      <th class="ths" style="padding:2px 10px; width: 5%; text-align: center;vertical-align: middle;">#</th>
                       @php foreach ($column_name_data as $key => $value){ @endphp
          <th  class="ths" style="padding:2px 10px;text-align: center;vertical-align: middle;">{{$value}}</th>
                     @php   } @endphp  
            </tr>
                  </thead>
                  <tbody>
                    @php 
                    $i=0;
                     foreach ($all_data as $key => $single_data){ 
                      $i++;
                      @endphp 
           <tr class="body_td">
                      <td  class="ths" style="width: 5%; text-align: center;vertical-align: middle;">{{$i}}</td>
                        @php  foreach ($column_data as $key => $value){
                            $valuData=isset($single_data[$value])?$single_data[$value]:'';
                        @endphp 
                   <td  class="ths" style="vertical-align: middle;">{{$valuData}}</td>
                         @php } @endphp 
            </tr>
                  @php   } @endphp 
          </tbody>
                </table>
              </td>
            </tr>
          </table> 
        </div>
         <script type="text/php">
    if (isset($pdf)) {
        $x = 250;
        $y = 10;
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 14;
        $color = array(255,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
</script>
</body>
</html>
