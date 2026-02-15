<div class="folder_grid_view">
    <?php 
    $i=0;
    foreach ($all_folder_info as $key => $value):
        $i++;
     ?>
        <!-- <a href="" style="text-decoration: none; color:#000;"> -->
            <div class="col-md-1 text-center float-left folder_all_employee_data_view" style="cursor: pointer;"
            data-folder_id = "<?php echo $value['id']; ?>"
            data-folder_name = "<?php echo $value['folder_name']; ?>"
            >
                <?php if (!empty($value['folder_name'])): ?>
                     <i class="fa fa-folder" style="font-size: 70px; color: orange;"></i>
                <?php else: ?>
                    <i class="fa fa-folder" style="font-size: 70px; color: orange;"></i>
                <?php endif ?>
                <p class="text-center" style="margin-bottom: 2px; font-size: 14px; margin-top:-8px;text-transform: uppercase;"><?php echo $value['folder_name'] ?></p>
                <p class="text-center grid_view_list1" style="margin-bottom: 2px; font-size: 9px;">
                    <?php 
                        echo date("j F, Y, g:i a", strtotime($value['updated_at']));
                    ?>
                </p>
            </div>
        <!-- </a> -->
    <?php endforeach ?>
    </div>
    <div class="row col-md-12 float-right" style="margin:0px;">
        <!-- <p>  {!! $employee_data_directory->links() !!}</p> -->
    </div>
