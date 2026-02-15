<div class="col-md-12 table-responsive folder_list_section" style="padding-bottom: 15px;">
    <h5 style="margin-bottom: 25px;">
        <i class="fa fa-bars"></i> Folder List
        <span id="folder_grid_hide_show1" style="float: right; cursor:pointer; margin-top: 6px; font-size:18px;">
            <i class="fa fa-th-large"></i>
        </span>
        <span id="folder_grid_hide_show" style="float: right; display: none;  cursor:pointer; margin-top: 6px; font-size:18px;">
            <i class="fa fa-list"></i>
        </span>
    </h5>
    <div class="folder_grid_view" id="folder_exampleDataTable123" style="padding:0px; margin-left:-15px;">
        @include('layouts.folder_pagination_data_grid')
    </div>
    <input type="hidden" name="hidden_page" id="folder_hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="folder_hidden_column_name" value="id" />
    <input type="hidden" name="hidden_sort_type" id="folder_hidden_sort_type" value="asc" />
    <input type="hidden" name="view_type" id="folder_view_type" value="1" />

    <table class="table table-striped table-bordered folder_list_view" style="width:100%;display: none;">
        <thead>
            <tr>
                <th class="text-center" style="padding: .75rem;">#</th>
                <th class="text-center" style="padding: .75rem;">
                    Folder Name
                </th>
                <th class="text-center" style="padding: .75rem;">Last Modified</th>
                <!-- <th class="text-center" style="padding: .75rem;">Folder Size</th> -->
                <th class="text-center" style="padding: .75rem;">Created by</th>
                <th class="text-center" style="padding: .75rem;">Created at</th>
                <th class="text-center" style="padding: .75rem;">Folder Status</th>
                <th class="text-center" style="padding: .75rem;">Permission</th>
                <th class="text-center" style="padding: .75rem;">Action</th>
            </tr>
        </thead>
        <tbody id="folder_exampleDataTable1234">
            @include('layouts.folder_pagination_data')
        </tbody>
    </table>

</div>
<div class="col-md-12 fileListInfo" style="display: none;">
    <div class="col-md-12 backToFolderList" style="padding:0px;">
        <h5 class='col-md-6 text-left float-left' style="margin-top:10px; padding:0px; cursor: pointer;">
            <i class="fa fa-arrow-up"></i>
            File List
        </h5>
        <div class="col-md-6  text-right backToFolderList float-left" style="display: inline; padding:0px;">
            <a class="btn btn-default" style="background: #eaeaea;"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
    <table id="fileListTable" class="table table-striped table-bordered fileListTable" cellspacing="0" style="font-size:12px; border: none;    ">
        <thead>
            <tr class="text-center">
                <th scope='col' style='border:1px solid #ddd !important;'>#</th>
                <th scope='col' style='border:1px solid #ddd !important;'>File Name </th>
                <th scope='col' style='border:1px solid #ddd !important;'>File Type </th>
                <th scope='col' style='border:1px solid #ddd !important;'>File Expiration </th>
                <th scope='col' style='border:1px solid #ddd !important;'>Notification Period </th>
                <th scope='col' style='border:1px solid #ddd !important;'>Email Notify </th>
                <th scope='col' style='border:1px solid #ddd !important;'> File Size </th>
                <th scope='col' style='border:1px solid #ddd !important;'> File Status </th>
                <th scope='col' style='border:1px solid #ddd !important; '> Action </th>
            </tr>
        </thead>
        <tbody id='fileListAppendData'>
        </tbody>
    </table>
</div>
<script type="text/javascript">
      /* Worked at 21/1/2021*/
      $("#folder_grid_hide_show").click(function() {
            $('#folder_grid_hide_show1').css('display', 'inline');
            $('#folder_grid_hide_show').css('display', 'none');
            $(".folder_grid_view").show();
            $(".folder_list_view").hide();
            var view_type = 2;
            $("#folder_view_type").val(view_type);
        });
        $("#folder_grid_hide_show1").click(function() {
            $('#folder_grid_hide_show1').css('display', 'none');
            $('#folder_grid_hide_show').css('display', 'inline');
            $(".folder_grid_view").hide();
            $(".folder_list_view").show();
            var view_type = 1;
            $("#folder_view_type").val(view_type);
        });

        $(".backToFolderList").click(function() {
            $('.folder_list_section').show(500);
            $('.fileListInfo').hide(500);
        });

        $(".folder_all_employee_data_view").click(function() {
            $('.folder_list_section').hide(500);
            folder_id = $(this).data("folder_id");
            folder_name = $(this).data("folder_name");
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/findFileList/" + folder_id,
                success: function(data) {
                    // console.log(data.file_list_data[i]);

                    // j =0;
                    $('#fileListTable').dataTable().fnDestroy();
                    $("#fileListAppendData").find("tr:gt(0)").remove();
                    $('#fileListAppendData').empty();
                    for (var i = 0; i < data.file_list_data.length; i++) {
                        j = i + 1;
                        // j++;
                        if (data.file_list_data[i].file_status == 1) {
                            file_status = 'Active';
                        } else if (data.file_list_data[i].file_status == 2) {
                            file_status = 'Inactive';
                        }

                        if (data.file_list_data[i].email_notify == 1) {
                            Emailed = 'Emailed';
                        } else if (data.file_list_data[i].email_notify == 2) {
                            Emailed = 'Not Emailed';
                        } else {
                            Emailed = 'Not Emailed';
                        }

                        $('#fileListAppendData').append(
                            '<tr class="text-center">' +
                            '<td>' + j + '</td>' +
                            '<td class="text-left"> <i class="fa fa-file" aria-hidden="false"></i> ' + data.file_list_data[i].file_name + '</td>' +
                            '<td class="text-left">' + data.file_list_data[i].type_name + '</td>' +
                            '<td>' + data.file_list_data[i].expiration_date + '</td>' +
                            '<td>' + data.file_list_data[i].notification_period + '</td>' +
                            '<td>' + Emailed + '</td>' +
                            '<td>' + data.file_list_data[i].file_size + '</td>' +
                            '<td>' + file_status + '</td>' +
                            '<td style="width: 20%;">' +
                            '<a class="viewDownloadAttachment" data-file_id="' + data.file_list_data[i].id + '" data-type="1" target="_blank" title="View" href="/document_file/' + data.file_list_data[i].file_attachment + '"> <i class="fa fa-eye"></i> View </a> | ' +
                            '<a class="viewDownloadAttachment" data-file_id="' + data.file_list_data[i].id + '" data-type="2" download title="Download" target="_blank" href="/document_file/' + data.file_list_data[i].file_attachment + '"><i class="fa fa-download"></i> Download </a>' +
                            '</td>' +
                            '</tr>'
                        );
                    }
                    $('#fileListTable').dataTable({
                        "destroy": true,
                        "pageLength": 5,
                        "bLengthChange": false,
                        "bFilter": true,
                        "bInfo": false,
                        "bAutoWidth": false
                    });

                    $('.fileListInfo').show(500);
                },
                error: function() {
                    // alert('Error occured!');
                    console.log('Error occured!');
                }
            });
        });
        $(document).on('click', '.viewDownloadAttachment', function() {
            // alert('file_id');
            var file_id = $(this).data("file_id");
            var action_type = $(this).data("type");
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/veiw_or_download/file_access_log/" + file_id + '/' + action_type,
                success: function(data) {
                    // console.log(data);
                },
                error: function() {
                    alert('Error occured!');
                }
            });
        });
        /* Worked at 21/1/2021*/
</script>