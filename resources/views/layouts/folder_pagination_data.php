<?php 
$i=0;
foreach ($all_folder_info as $key => $value):
  // echo "<pre>"; print_r($value); echo "<pre>";
  $i++;
 ?>
<tr id="folder_list_view">
    <td class="text-center"><?php echo $i; ?></td>
    <td style="cursor: pointer;" class="text-left folder_all_employee_data_view"
      data-folder_id = "<?php echo $value['id']; ?>"
      data-folder_name = "<?php echo $value['folder_name']; ?>"
    >
      <i class="fa fa-folder" style="color: orange; padding-right: 15px; padding-left: 15px;"></i>
      <?php echo $value['folder_name'] ?>
    </td>
    <td class="text-center"><?php  echo date("j F, Y, g:i a", strtotime($value['updated_at'])); ?></td>
    <!-- <td class="text-left"></td> -->
    <td class="text-left"><?php echo $value['employee_fullname']; ?></td>
    <td class="text-center"><?php  echo date("j F, Y, g:i a", strtotime($value['created_at'])); ?></td>
    <td class="text-center" style="color:green;">
      <?php
        if ($value['folder_status']==1) {
          echo 'Active';
        }else{
          echo "Inactive";
        }
      ?>
    </td>
    <!-- <td class="text-left">You have no permission!</td> -->
    <td class="text-left"></td>
    <td style="cursor: pointer;" class="text-center folder_all_employee_data_view"
      data-folder_id = "<?php echo $value['id']; ?>"
      data-folder_name = "<?php echo $value['folder_name']; ?>"
    >
        <i class="fa fa-eye"></i>
      </button>
    </td>
</tr>
<?php endforeach ?>


<!-- <tfoot> -->
<!-- <tr>
   <td colspan="8" align="center">
    {!! $employee_data_directory->links() !!}
   </td>
</tr> -->



