<div class="grid_view col-md-12"  style="display: none;">
    <?php 
    $i = $employee_data_directory->perPage() * ($employee_data_directory->currentPage() - 1);
    foreach ($employee_data_directory as $key => $value):
        $i++;


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
        <div  id="all_employee_data_view" class="col-md-3 text-center float-left all_employee_data_view" style="border: 1px solid #dee2e6; height: 230px; max-width: 23%; margin:7px;"
            data-employee_image = "<?php echo $value['employee_image'] ?>"
            data-employee_id_no = "<?php echo $value['employee_id_no'] ?>"
            data-employee_fullname = "<?php echo $value['employee_fullname'] ?>"
            data-sbu_name = "<?php echo $value['sbu_name'] ?>"
            data-department_name = "<?php echo $value['department_name'] ?>"
            data-designation_name = "<?php echo $value['designation_name'] ?>"
            data-section_name = "<?php echo $value['section_name'] ?>"
          data-employee_dob_actual = "<?php echo $employee_dob; ?>"
            data-employee_blood_group = "<?php echo $value['employee_blood_group'] ?>"
          data-employee_mobile = "<?php echo $value['employee_mobile'] ?>"
            data-desk_phone = "<?php echo $value['desk_phone_no'] ?>"
            data-official_email_id = "<?php echo $value['official_email_id'] ?>"
            data-employee_status_text = "<?php echo $employee_status_text; ?>"
            data-background_color = "<?php echo $background_color; ?>"

        >

            <?php if (!empty($value['employee_image']) && file_exists(public_path('images/'.$value['employee_image']))): ?>
                 <img id="employee_image" class="img-responsive text-center" src="{{asset('images/'.$value['employee_image'])}}" style="height: 109px; width: 90px;margin-bottom: 10px; margin-top:10px;">
            <?php else: ?>
                 <img id="employee_image" class="img-responsive text-center" src="{{asset('images/default.png')}}" style="height: 109px; width: 90px;margin-bottom: 10px; margin-top:10px;">
            <?php endif ?>
            <p class="text-center" style="margin-bottom: 2px; font-size: 14px;"><?php echo $value['employee_fullname'] ?></p>
            <p class="text-center grid_view_list1" style="margin-bottom: 2px; font-size: 11px;"><?php echo $value['sbu_name'] ?></p>
            <p class="text-center grid_view_list1" style="margin-bottom: 2px; font-size: 11px;"><?php echo $value['department_name'] ?></p>
            <p class="text-center grid_view_list1" style="margin-bottom: 2px; font-size: 11px; margin-bottom:10px;"><?php echo $value['designation_name']; ?><?php if(!empty($value['section_name'])){echo ', ';} ?><?php echo $value['section_name']; ?></p>
        </div>
    <?php endforeach ?>
    </div>
    <div class="row col-md-12 float-right" style="margin:0px;">
        <p>  {!! $employee_data_directory->links() !!}</p>
    </div>

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
        desk_phone = $(this).data("desk_phone");
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
            $(".employee_directory_profile #section_name").text('Not Found!');
        }
        if (employee_dob_actual) {
            $(".employee_directory_profile #employee_dob_actual").text(employee_dob_actual);
        }else{
            $(".employee_directory_profile #employee_dob_actual").text('Not Found!');
        }
        if (employee_mobile) {
            $(".employee_directory_profile #employee_mobile").text(employee_mobile);
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

    <!-- <style type="text/css">
        .grid_view_list{
    text-overflow: ellipsis;
    /*width:150px;*/
    overflow: hidden;
    white-space: nowrap;
}
    </style> -->