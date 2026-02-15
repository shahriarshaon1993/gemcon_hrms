<?php 
// $i=0;
$i = $employee_data_directory->perPage() * ($employee_data_directory->currentPage() - 1);
foreach ($employee_data_directory as $key => $value):

  // echo "<pre>"; print_r($value); echo "<pre>";
  $i++;
 ?>
<tr id="list_view">
    <td class="text-center"><?php echo $i; ?></td>
    <td class="text-center"><?php echo $value['employee_id_no'] ?></td>
    <td class="text-left"><?php echo $value['employee_fullname'] ?></td>
    <td class="text-left"><?php echo $value['sbu_name'] ?></td>
    <td class="text-left"><?php echo $value['department_name'] ?></td>
    <td class="text-left"><?php echo $value['designation_name'] ?></td>
    <td class="text-center">
      <?php
       $dob = $value['employee_dob_actual'];
       $employee_dob = isset($value['employee_dob_actual'])?$value['employee_dob_actual']:'';

       if (empty($employee_dob) || $employee_dob=='0000-00-00') {
           $employee_dob = isset($value['employee_dob_certificate'])?$value['employee_dob_certificate']:'';
           if ($employee_dob==0 || $employee_dob=='0000-00-00') {
               $employee_dob = '';
           }
       }
       $employee_dob = strtotime($employee_dob);
       if ($employee_dob) {
          $employee_dob =  date('d F', $employee_dob); 
       }else{
          $employee_dob = 'No birthday available!' ;
       }

       $employee_status = isset($value['employee_status'])?$value['employee_status']:0;
        if ($employee_status==1) {
            $employee_status_text =  'Active';
            $background_color = 'green';
        }else if($employee_status==2){
            $employee_status_text =  'Resigned';
            $background_color = 'red';
        }else if($employee_status==0){
            $employee_status_text =  'Inactive';
            $background_color = 'red';
        }else{
            $employee_status_text =  'Not available!' ;
            $background_color = '#dddddd';
        }
      ?>

      <button style="background: transparent;border:none;" id="all_employee_data_view" class=" all_employee_data_view"
      data-employee_image = "<?php echo $value['employee_image'] ?>"
      data-employee_id_no = "<?php echo $value['employee_id_no'] ?>"
      data-employee_fullname = "<?php echo $value['employee_fullname'] ?>"
      data-sbu_name = "<?php echo $value['sbu_name'] ?>"
      data-department_name = "<?php echo $value['department_name'] ?>"
      data-designation_name = "<?php echo $value['designation_name'] ?>"
      data-employee_dob_actual = "<?php echo $employee_dob; ?>"
      data-employee_blood_group = "<?php echo $value['employee_blood_group'] ?>"
      data-employee_mobile = "<?php echo $value['employee_mobile'] ?>"
      data-employee_mobile_office = "<?php echo $value['official_mobile_no'] ?>"
      data-section_name = "<?php echo $value['section_name'] ?>"
      data-desk_phone = "<?php echo $value['desk_phone_no'] ?>"
      data-official_email_id = "<?php echo $value['official_email_id'] ?>"
      data-employee_status_text = "<?php echo $employee_status_text ?>"
      data-background_color = "<?php echo $background_color ?>"
      >
      <i class="fa fa-eye"></i>
      </button>
    </td>
</tr>
<?php endforeach ?>


<!-- <tfoot> -->
<tr>
   <td colspan="7" align="center">
    {!! $employee_data_directory->links() !!}
   </td>
</tr>



<script type="text/javascript">
  $( ".all_employee_data_view" ).click(function() {

    employee_image = $(this).data("employee_image");
    employee_id_no = $(this).data("employee_id_no");
    employee_fullname = $(this).data("employee_fullname");
    sbu_name = $(this).data("sbu_name");
    department_name = $(this).data("department_name");
    designation_name = $(this).data("designation_name");
    section_name = $(this).data("section_name");
    employee_dob_actual = $(this).data("employee_dob_actual");
    employee_blood_group = $(this).data("employee_blood_group");
    employee_mobile = $(this).data("employee_mobile");
    employee_mobile_office = $(this).data("employee_mobile_office");
    // section_name = $(this).data("section_name");
    // alert(section_name);
    
    desk_phone = $(this).data("desk_phone");
    // alert(desk_phone);
    official_email_id = $(this).data("official_email_id");
    employee_status_text = $(this).data("employee_status_text");
    background_color = $(this).data("background_color");

    // && file_exists(public_path('images/'.$employee_image))

    // alert(employee_image);
    // $(".employee_directory_profile #employee_image").text(employee_image);
    if (employee_image!='') {
      $(".employee_directory_profile #employee_image").attr("src", "images/"+employee_image);
    }else{
      $(".employee_directory_profile #employee_image").attr("src", "images/default.png");
    }
    if (employee_id_no) {
      $(".employee_directory_profile #employee_id_no").text(employee_id_no);
    }else{
      $(".employee_directory_profile #employee_id_no").text('Not Found!');
    }
    if (employee_fullname) {
      $(".employee_directory_profile #employee_fullname").text(employee_fullname);
    }else{
      $(".employee_directory_profile #employee_fullname").text('Not Found!');
    }
    if (sbu_name) {
      $(".employee_directory_profile #sbu_name").text(sbu_name);
    }else{
      $(".employee_directory_profile #sbu_name").text('Not Found!');
    }
    if (department_name) {
      $(".employee_directory_profile #department_name").text(department_name);
    }else{
      $(".employee_directory_profile #department_name").text('Not Found!');
    }
    if (designation_name) {
      $(".employee_directory_profile #designation_name").text(designation_name);
    }else{
      $(".employee_directory_profile #designation_name").text('Not Found!');
    }
    if (section_name) {
      $(".employee_directory_profile #section_name").text(section_name);
    }else{
      $(".employee_directory_profile #section_name").text('');
    }
    if (employee_dob_actual) {
      $(".employee_directory_profile #employee_dob_actual").text(employee_dob_actual);
    }else{
      $(".employee_directory_profile #employee_dob_actual").text('Not Found!');
    }
    if (employee_mobile_office || employee_mobile) {
      if(employee_mobile_office){
        $(".employee_directory_profile #employee_mobile").text(employee_mobile_office);
      }else{
        $(".employee_directory_profile #employee_mobile").text(employee_mobile);
      }
    }else{
      $(".employee_directory_profile #employee_mobile").text('Not Found!');
    }

    if (desk_phone) {
      $(".employee_directory_profile #desk_phone").text(desk_phone);
    }else{
      $(".employee_directory_profile #desk_phone").text('Not Found!');
    }
    if (official_email_id) {
      $(".employee_directory_profile #official_email_id").text(official_email_id);
    }else{
      $(".employee_directory_profile #official_email_id").text('Not Found!');
    }
    if (employee_blood_group) {
      $(".employee_directory_profile #employee_blood_group").text(employee_blood_group);
    }else{
      $(".employee_directory_profile #employee_blood_group").text('Not Found!');
    }
    if (employee_status_text) {
      $(".employee_directory_profile #employee_status_text").text(employee_status_text);
    }else{
      $(".employee_directory_profile #employee_status_text").text('Not Found!');
    }
    if (background_color) {
      $('.background_color').css({'background-color':background_color});
    }else{
      $('.background_color').css({'background-color':''});
    }


    var base_url = window.location.origin;
    if (employee_image) {
      $(".image-download").attr("href", base_url+'/images/'+employee_image);
      $('.image-download').attr("download", employee_image)
    }else{
      $(".image-download").attr("href", 'images/default.png');
      $('.image-download').attr("download", employee_image)
    }

    // $(".employee_directory_profile #employee_fullname").text(employee_fullname);
    // $(".employee_directory_profile #sbu_name").text(sbu_name);
    // $(".employee_directory_profile #department_name").text(department_name);
    // $(".employee_directory_profile #designation_name").text(designation_name);
    // $(".employee_directory_profile #employee_dob_actual").text(employee_dob_actual);
    // $(".employee_directory_profile #employee_blood_group").text(employee_blood_group);
    // $(".employee_directory_profile #employee_mobile").text(employee_mobile);
    // $(".employee_directory_profile #desk_phone").text(desk_phone);
    // $(".employee_directory_profile #official_email_id").text(official_email_id);
});
</script>
