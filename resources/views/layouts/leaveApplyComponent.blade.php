<div class="modal fade" id="applyLeave" tabindex="-1" role="dialog" aria-labelledby="applyLeaveLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="min-width: 55%;">
        <form id="leave_application_submit" class="well form-horizontal needs-validation leave-application">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="col-md-10" v-if="add_new_type!=5"><i class="fa fa-bars"></i> Leave Application</h4>
                    <div class=" text-right backToServiceListdiv" style="display: none;">
                        <a href="#" class="backToServiceList" style="color: black;"><i class="fa fa-backward"></i> Back to List</a>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modify-wraper modal-body1">
                        <div class="col-md-12">
                            <div class="row col-md-12" style="padding:5px;">
                                <div class="col-md-6 employee-info-table" style="padding:0px;">
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td style="padding: 0.5rem;">Employee ID</td>
                                                <td style="padding: 0.5rem;">:</td>
                                                <td style="padding: 0.5rem;">
                                                    <input type="hidden" name="" value="<?php echo $employee_data['id'] ?>">
                                                    <?php echo isset($employee_data['employee_id_no']) ? $employee_data['employee_id_no'] : '';  ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0.5rem;">Employee Name</td>
                                                <td style="padding: 0.5rem;">:</td>
                                                <td style="padding: 0.5rem;"><?php echo isset($employee_data['employee_fullname']) ? $employee_data['employee_fullname'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0.5rem;">Designation</td>
                                                <td style="padding: 0.5rem;">:</td>
                                                <td style="padding: 0.5rem;"><?php echo isset($employee_data['designation_name']) ? $employee_data['designation_name'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0.5rem;">Department</td>
                                                <td style="padding: 0.5rem;">:</td>
                                                <td style="padding: 0.5rem;"><?php echo isset($employee_data['department_name']) ? $employee_data['department_name'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0.5rem;">Company/SBU/Project</td>
                                                <td style="padding: 0.5rem;">:</td>
                                                <td style="padding: 0.5rem;"><?php echo isset($employee_data['sbu_name']) ? $employee_data['sbu_name'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0.5rem;">Contact Phone</td>
                                                <td style="padding: 0.5rem;">:</td>
                                                <td style="padding: 0.5rem;"><?php echo isset($mobile_no) ? $mobile_no : ''; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-3 leave-info text-center" style="margin:auto;">
                                    <span id="leave_info_div" style="display: none;">
                                        <h5 style="font-size: 16px; font-weight: bold;"><span class="totalDayss_no"></span>/<span id="tleave_day_no"></span> Days of <span id="leave_type_name_id"></span> Leave</h5>
                                        <h5><span id="tremaining_days"></span> days remaining</h5>
                                    </span>
                                </div>
                                <?php if ($employee_image && file_exists(public_path('images/' . $employee_image))) : ?>
                                    <div class="col-md-3 leave-info text-right">
                                        <samp><img src="{{asset('images/'.$employee_image )}}" class="card-img-top border rounded" style="margin-top: 2px; width: 150px; height: 170px;"></samp>
                                    </div>
                                <?php else : ?>
                                    <div class="col-md-3 leave-info text-right">
                                        <img src="{{asset('images/default.png')}}" style="margin-top: 2px; width: 150px; height: 170px;">
                                    </div>
                                <?php endif ?>
                            </div>
                            <span>
                                <input name="employee_id" type="hidden" value="<?php echo isset($employee_data['employee_id']) ? $employee_data['employee_id'] : ''; ?>">
                                <input id="row_id" name="id" type="hidden">
                                <div class="row" style="margin: 0px;">
                                    <div class="col-md-12" style="padding:0px;">
                                        <div class="col-md-7 float-left" style="padding:0px;">
                                            <div class="row form-group col-md-12" style="margin-bottom: 20px !important;">
                                                <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                    <label class="control-label">Leave Type <span class="required_sign">*</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
                                                    <div class="input-group" id="leave_type_id_select2">
                                                        <select id="leave_type_id" name="leave_type" class="js-example-basic-single" name="state">
                                                            <option>--Select--</option>
                                                            <?php foreach ($leave_type_info as $key => $value) : ?>
                                                                <option value="<?php echo $value['leave_type'] ?>"><?php echo $value['leave_type_name'] ?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group col-md-12" style="margin-bottom: 20px !important;">
                                                <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                    <label class="control-label">Date <span class="required_sign">*</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
                                                    <div class="form-group datepicker-container">
                                                        <div class="col-md-6 float-left" style="padding: 0px;">
                                                            <div class="input-group">
                                                                <div class="col-md-12" style="padding: 0px;">
                                                                    <input id="change_leave_from_date" name="leave_from_date" type="date" style="width: 100%;">
                                                                    <input name="add_new_type" value="1" type="hidden" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 float-left" style="padding: 0px;">
                                                            <div class="input-group">
                                                                <div class="col-md-12" style="padding: 0px;">
                                                                    <input id="change_leave_to_date" name="leave_to_date" type="date" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group col-md-12" style="margin-bottom: 20px !important;">
                                                <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                    <label class="control-label">Reason for Leave <span class="required_sign">*</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
                                                    <div class="input-group">
                                                        <textarea name="leave_reason" placeholder="" required="required" type="text" class="form-control leave_reason_text"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group col-md-12" style="margin-bottom: 20px !important;">
                                                <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                    <label class="control-label">Address, on Leave
                                                    </label>
                                                </div>
                                                <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
                                                    <div class="input-group">
                                                        <textarea name="address_leave" placeholder="" class="form-control address_on_leave"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group col-md-12" style="margin-bottom: 20px !important;">
                                                <div class="col-md-4 float-left" style="padding-left: 0px;">
                                                    <label class="control-label">Responsible
                                                        <!-- <span class="required_sign">*</span> -->
                                                    </label>
                                                </div>
                                                <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
                                                    <div class="input-group">
                                                        <select name="leave_reliever" id="mySelectResponsible" class="js-example-basic-single" name="state">
                                                            <option>--Select--</option>
                                                            <?php foreach ($all_employee_data as $key => $value) : ?>
                                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['text']; ?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group col-md-12" style="margin-bottom: 20px !important;">
                                                <div class="col-md-4 float-left" style="padding-left: 0px;padding-right: 0px;">
                                                    <label class="control-label">Respon. Contact
                                                        <!-- <span class="required_sign">*</span> -->
                                                    </label>
                                                </div>
                                                <div class="col-md-8 float-left inputGroupContainer" style="padding: 0px;">
                                                    <div class="input-group">
                                                        <input id="rsp_employee_mobile" name="leave_reliever_contact"   type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-5 float-left" style="padding:0px;">
                                            <table id="dtBasicExample" class="table table-striped table-bordered leave-table" cellspacing="0" width="100%" style="font-size:12px;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="5" class="th-sm text-left">
                                                            <i class="fa fa-calendar"></i>
                                                            My Leave
                                                        </th>
                                                    </tr>
                                                    <tr class="text-center;" style="border: 1px solid #ddd;">
                                                        <th style="width: 40%; text-align: center; vertical-align: middle; background: rgb(245, 245, 245); border: 1px solid rgb(52, 58, 64);">Type</th>
                                                        <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Entitle.</th>
                                                        <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Prev. Balance</th>
                                                        <th style="width: 20%;text-align: center;vertical-align: middle;background: #f5f5f5;">Total Entitle.</th>
                                                        <th style="width: 15%;text-align: center;vertical-align: middle;background: #f5f5f5;">Availed</th>
                                                        <th style="width: 15%;text-align: center;vertical-align: middle;background: #f5f5f5;">Bal.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($leaveInfo as $key => $form_data) : ?>
                                                    <tr>
                                                        <td style="padding:0px;">{{ $form_data['leave_type_name']  }}</td>
                                                        <td class="text-center">{{ $form_data['entitlementThisYear'] }}
                                                        </td>
                                                        <td class="text-center">
                                                        {{ $form_data['previousBalance'] }}
                                                        </td>
                                                        <td class="text-center">
                                                        {{ $form_data['totalEntitlement'] }}
                                                        </td>
                                                        <td class="text-center">{{ $form_data['totalDay'] }}</td>
                                                        <td class="text-center">{{ $form_data['balance'] }}</td>
                                                    </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                                <!-- <tbody>
                                                    <tr>
                                                        <td style="text-align:left;">Leave</td>
                                                        <?php foreach ($leave_type_info as $key => $value) : ?>
                                                            <td><?php echo $value['leave_type_name']; ?></td>
                                                        <?php endforeach ?>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:left;">Entitlement</td>
                                                        <?php foreach ($leave_type_info as $key => $value) : ?>
                                                            <td><?php echo $value['leave_day_no']; ?></td>
                                                        <?php endforeach ?>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:left;">Prev. Balance</td>
                                                        <?php foreach ($leave_available as $key => $value) : ?>
                                                            <td><?php echo $value['Prev']; ?></td>
                                                        <?php endforeach ?>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align:left;">Total Entitle.</td>
                                                        <?php foreach ($leave_available as $key => $value) : ?>
                                                            <td><?php echo $value['totalEntitle']; ?></td>
                                                        <?php endforeach ?>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:left;">Availed</td>
                                                        <?php foreach ($leave_consumed as $key => $value) : ?>
                                                            <td><?php echo $value; ?></td>
                                                        <?php endforeach ?>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:left;">Balance</td>
                                                        <?php foreach ($leave_available as $key => $value) : ?>
                                                            <td><?php echo $value['leave_remaining']; ?></td>
                                                        <?php endforeach ?>
                                                    </tr>
                                                </tbody> -->
                                            </table>
                                            <div class="row form-group col-md-12" style="margin-bottom: 20px !important;">
                                                <div class="col-md-12 float-left" style="padding-left: 0px;">
                                                    <label class="control-label">Upload Attachment</label>
                                                </div>
                                                <div class="col-md-12 float-left inputGroupContainer" style="padding-left: 0px !important; margin-bottom: 10px;">
                                                    <div class="col-md-4 inputGroupContainer float-left" style="padding-left: 0px !important;">
                                                        <input name="leave_attachment" type="file">
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            <p>
                                                <span id="rsp_designation_name"></span>
                                            </p>
                                            <p>
                                                <span id="rsp_sbu_name"></span>
                                            </p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="apply_type" value="1" class="lwutpay">
                                    <input type="hidden" name="leave_holiday" value="0" checked="checked" class="leave_holiday">
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-actions col-md-12">
                        <div class="form-actions col-md-8" style="float: right;padding:0px;">
                            <input id='send_leave_request' type="submit" tabindex="4" value="Send Request" class="btn btn-sm btn-info float-right col-md-3" style="font-size: 14px; padding-bottom: 3px; margin-left:10px;">

                            <input id='update_leave_request' type="submit" tabindex="4" value="Update Request" class="btn btn-sm btn-info float-right col-md-3" style="font-size: 14px; padding-bottom: 3px; margin-left:10px; display:none;">

                            <input title="Leave Form Preview" data-toggle="modal" data-target="#leaveForm " data-whatever="@getbootstrap" data-backdrop="static" data-keyboard="false" tabindex="4" value="Leave Form" class="btn btn-sm btn-success leaveForm  float-right col-md-3" style="font-size: 14px; padding: 3px 20px">

                            <button type="button" class="btn btn-sm btn-default float-right col-md-3 close" data-dismiss="modal" aria-label="Close" style="font-size: 14px; margin-top: 0px;background: #e9e9e9;    padding: 6px;margin-right: 10px;    color: #000;border: 1px solid #aaa;">Cancel</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
</div>

