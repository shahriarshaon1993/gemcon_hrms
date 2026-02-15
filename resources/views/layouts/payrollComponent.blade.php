    <div class="col-md-12" style="padding: 0px;">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#SalaryInfo" role="tab" aria-controls="home" aria-selected="true">Salary Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="my-profile-tab" data-toggle="tab" href="#ProvidentFund" role="tab" aria-controls="my-profile" aria-selected="false">Provident Fund</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="my-profile-tab" data-toggle="tab" href="#LoanAdvance" role="tab" aria-controls="my-profile" aria-selected="false">Loan & Advance</a>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="SalaryInfo" style="padding:0px;" role="tabpanel" aria-labelledby="home-tab1">
            <div class="row" style="margin-left: -11px; margin-right: -11px; margin-top:15px;">
                <!-- <div class="col-6 col-sm-4 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fa fa-list"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total </span>
                <span class="info-box-number "> {{$present_day_count }}</span>
            </div>
            <div role="separator" class="dropdown-divider"></div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fa fa-clock-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Confirmation Date</span>
                <span class="info-box-number ">
                    {{$late_day_count}}
                </span>
            </div>
            <div role="separator" class="dropdown-divider"></div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Present Basic</span>
                <span class="info-box-number "> {{$present_day_count }}</span>
            </div>
            <div role="separator" class="dropdown-divider"></div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Present Gross</span>
                <span class="info-box-number ">
                    {{$late_day_count }}
                </span>
            </div>
            <div role="separator" class="dropdown-divider"></div>
        </div>
    </div> -->

                <div class="col-6 col-sm-4 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-clock-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Present</span>
                            <span class="info-box-number "> {{$present_day_count }}</span>
                        </div>
                        <div role="separator" class="dropdown-divider"></div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-clock-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Late</span>
                            <span class="info-box-number ">
                                {{$late_day_count }}
                            </span>
                        </div>
                        <div role="separator" class="dropdown-divider"></div>
                    </div>
                </div>

                <div class="clearfix hidden-md-up"></div>
                <div class="col-6 col-sm-4 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-clock-o"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Absent</span>
                            <span class="info-box-number ">
                                {{$absent_day_count }}
                            </span>
                        </div>
                        <div role="separator" class="dropdown-divider"></div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info  elevation-1"><i class="fa fa-clock-o"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pay Days</span>
                            <span class="info-box-number ">
                                {{$pay_days }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class='col-md-5 text-left float-left' style="padding-top:10px;">
                        <h5>
                            <i class="fa fa-bars"></i>
                            Salary Info
                        </h5>
                    </div>

                    <div class="col-md-7 text-right float-left" style="padding-top:10px;padding-right:0px;">

                        <strong>
                            Total Gross Salary:
                            <span style="color: green;">
                                <?php if ($gross_salary) : ?>
                                    <?php echo number_format($gross_salary, 2, '.', ','); ?>
                                <?php endif ?>
                            </span>
                        </strong>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="col-md-12 backToFolderList" style="padding:0px;">
                        <h5 class='col-md-6 text-left float-left' style="margin-top:10px; padding:0px; cursor: pointer;">
                            <i class="fa fa-bars"></i>
                            Salary List
                        </h5>
                    </div>
                </div>

                <?php if (empty($cash_salary)) : ?>
                    <?php
                    $col_md = '4';
                    ?>
                <?php else : ?>
                    <?php
                    $col_md = '2';
                    ?>
                <?php endif ?>
                <div class="col-md-<?php echo $col_md; ?>" style="top:30px;">
                    <table class="table table-striped table-bordered salaryListTable" cellspacing="0" style="font-size:12px; border: none; ">
                        <thead>
                            <tr class="text-center">
                                <th colspan="2" style='border:1px solid #ddd !important;'>Bank Salary</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th class="align-middle" style="padding:6px;">Gross - Bank</th>
                                <th class='text-right' style="padding:6px;">
                                    <?php
                                    echo isset($bank_salary['gross_salary']) ? number_format($bank_salary['gross_salary'], 2, '.', ',') : 0;
                                    ?>
                                </th>
                            <tr style="background-color:#fff;">
                                <td class="align-middle" style="padding:6px;">Basic</td>
                                <td class='text-right' style="padding:6px;">
                                    <?php
                                    echo isset($bank_salary['basic_salary']) ? number_format($bank_salary['basic_salary'], 2, '.', ',') : 0;
                                    ?>
                                </td>
                            </tr>
                            <tr style="background-color:#fff;">
                                <td class="align-middle" style="padding:6px;">House</td>
                                <td class='text-right' style="padding:6px;">
                                    <?php
                                    echo isset($bank_salary['housing_allowance']) ? number_format($bank_salary['housing_allowance'], 2, '.', ',') : 0;
                                    ?>
                                </td>
                            </tr>
                            <tr style="background-color:#fff;">
                                <td class="align-middle" style="padding:6px;">Transport</td>
                                <td class='text-right' style="padding:6px;">
                                    <?php
                                    echo isset($bank_salary['medical_allowance']) ? number_format($bank_salary['medical_allowance'], 2, '.', ',') : 0;
                                    ?>
                                </td>
                            </tr>
                            <tr style="background-color:#fff;">
                                <td class="align-middle" style="padding:6px;">Medical</td>
                                <td class='text-right' style="padding:6px;">
                                    <?php
                                    echo isset($bank_salary['conveyance_allowance']) ? number_format($bank_salary['conveyance_allowance'], 2, '.', ',') : 0;
                                    ?>
                                </td>
                            </tr>
                            <tr style="background-color:#fff;">
                                <td class="align-middle" style="padding:6px;">Others </td>
                                <td class='text-right' style="padding:6px;">
                                    <?php
                                    echo isset($bank_salary['others_allowance']) ? number_format($bank_salary['others_allowance'], 2, '.', ',') : 0;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="align-middle" style="padding:6px;">Total Bank </td>
                                <th class='text-right' style="padding:6px;">
                                    <?php
                                    if (!empty($bank_salary['gross_salary'])) {

                                        echo number_format($bank_salary['gross_salary'] + $bank_salary['others_allowance'], 2, '.', ',');
                                    } else {
                                        echo "0.00";
                                    }
                                    ?>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($cash_salary)) { ?>
                    <div class="col-md-2" style="top:30px;">
                        <table class="table table-striped table-bordered salaryListTable" cellspacing="0" style="font-size:12px; border: none;">
                            <thead>
                                <tr class="text-center">
                                    <th colspan="2" style='border:1px solid #ddd !important;'>Cash Salary</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="align-middle" style="padding:6px;">Gross - Cash</th>
                                    <th class='text-right' style="padding:6px;">
                                        <?php
                                        echo isset($cash_salary['gross_salary']) ? number_format($cash_salary['gross_salary'], 2, '.', ',') : 0;
                                        ?>
                                    </th>
                                <tr style="background-color:#fff;">
                                    <td class="align-middle" style="padding:6px;">Basic</td>
                                    <td class='text-right' style="padding:6px;">
                                        <?php
                                        echo isset($cash_salary['basic_salary']) ? number_format($cash_salary['basic_salary'], 2, '.', ',') : 0;
                                        ?>
                                    </td>
                                </tr>
                                <tr style="background-color:#fff;">
                                    <td class="align-middle" style="padding:6px;">House</td>
                                    <td class='text-right' style="padding:6px;">
                                        <?php
                                        echo isset($cash_salary['housing_allowance']) ? number_format($cash_salary['housing_allowance'], 2, '.', ',') : 0;
                                        ?>
                                    </td>
                                </tr>
                                <tr style="background-color:#fff;">
                                    <td class="align-middle" style="padding:6px;">Transport</td>
                                    <td class='text-right' style="padding:6px;">
                                        <?php
                                        echo isset($cash_salary['medical_allowance']) ? number_format($cash_salary['medical_allowance'], 2, '.', ',') : 0;
                                        ?>
                                    </td>
                                </tr>
                                <tr style="background-color:#fff;">
                                    <td class="align-middle" style="padding:6px;">Medical</td>
                                    <td class='text-right' style="padding:6px;">
                                        <?php
                                        echo isset($cash_salary['conveyance_allowance']) ? number_format($cash_salary['conveyance_allowance'], 2, '.', ',') : 0;
                                        ?>
                                    </td>
                                </tr>
                                <tr style="background-color: #cdcdcd;`">
                                    <td class="align-middle" style="padding:6px;">Car Allowance </td>
                                    <td class='text-right' style="padding:6px;">
                                        <?php
                                        echo isset($cash_salary['car_allowance_amount']) ? number_format($cash_salary['car_allowance_amount'], 2, '.', ',') : 0;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align-middle" style="padding:6px;">Total Cash </td>
                                    <th class='text-right' style="padding:6px;">
                                        <?php
                                        if (!empty($cash_salary['gross_salary'])) {

                                            echo number_format($cash_salary['gross_salary'] + $cash_salary['car_allowance_amount'], 2, '.', ',');
                                            # code...
                                        } else {
                                            echo "0.00";
                                        }
                                        ?>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>

                <div class="col-md-8" style="padding: 0px">
                    <table id="salaryListTable" class="table table-striped table-bordered salaryListTable" cellspacing="0" style="font-size:12px; border: none;">
                        <thead>
                            <tr class="text-center">
                                <th scope='col' style='border:1px solid #ddd !important;'>#</th>
                                <th scope='col' style='border:1px solid #ddd !important;'>Date/Month </th>
                                <th scope='col' style='border:1px solid #ddd !important;'>Gross </th>
                                <th scope='col' style='border:1px solid #ddd !important;'>Basic </th>
                                <th scope='col' style='border:1px solid #ddd !important;'>House </th>
                                <th scope='col' style='border:1px solid #ddd !important;'> Medical </th>
                                <th scope='col' style='border:1px solid #ddd !important; '> Transport </th>
                                <th scope='col' style='border:1px solid #ddd !important; '> Others </th>
                                <th scope='col' style='border:1px solid #ddd !important; '> Deduction </th>
                                <th scope='col' style='border:1px solid #ddd !important; '> Net Pay </th>
                                <th scope='col' style='border:1px solid #ddd !important; '> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($monthly_salary_info)) : ?>
                                <?php
                                $i = 0;
                                foreach ($monthly_salary_info as $key => $salary) :
                                    $i++;
                                ?>
                                    <tr role="row" class="odd">
                                        <td class="text-center sorting_1">
                                            {{$i}}
                                        </td>
                                        <td class="text-center">
                                            {{$salary['paymonth']}}
                                        </td>
                                        <td class="text-right">
                                            {{number_format($salary['gross_salary'], 2, '.', ',')}}
                                        </td>
                                        <td class="text-right">
                                            {{number_format($salary['basic'], 2, '.', ',')}}
                                        </td>
                                        <td class="text-right">
                                            {{number_format($salary['houserent'], 2, '.', ',')}}
                                        </td>
                                        <td class="text-right">
                                            {{number_format($salary['medical'], 2, '.', ',')}}
                                        </td>
                                        <td class="text-center">
                                            {{number_format($salary['transport'], 2, '.', ',')}}
                                        </td>
                                        <td class="text-right">
                                            {{number_format($salary['total_additions'], 2, '.', ',')}}
                                        </td>
                                        <td class="text-right">
                                            {{number_format($salary['total_deduction'], 2, '.', ',')}}
                                        </td>
                                        <td class="text-center">
                                            {{number_format($salary['netpay'], 2, '.', ',')}}
                                        </td>
                                        <td class="text-center">

                                            <button title="Schedule" class="btn btn-xs btn-info pay_slip_modal" href="#" data-toggle="modal" data-target="#pay_slip_modal" data-whatever="@getbootstrap" data-payroll_id="<?php echo $salary['id']; ?>" data-employee_id="<?php echo $salary['empid']; ?>">
                                                <i class="fa fa-credit-card"></i> Pay Slip
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>

                            <?php else : ?>
                                <?php echo 'No Data Found!' ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="ProvidentFund" style="padding:0px;" role="tabpanel" aria-labelledby="home-tab">
            <div class="row" style="margin-left: -11px; margin-right: -11px; margin-top:15px;">
                <div class="col-6 col-sm-4 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-list"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">No. of Month</span>
                            <span class="info-box-number "> {{$no_of_month}}</span>
                        </div>
                        <div role="separator" class="dropdown-divider"></div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Employee Contribution</span>
                            <span class="info-box-number ">
                                {{number_format($total_emp_contribution, 2, '.', ',') }}
                            </span>
                        </div>
                        <div role="separator" class="dropdown-divider"></div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-industry"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Company Contribution</span>
                            <span class="info-box-number "> {{number_format($total_comp_contribution, 2, '.', ',')}}</span>
                        </div>
                        <div role="separator" class="dropdown-divider"></div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total PF</span>
                            <span class="info-box-number ">
                                {{number_format($total_emp_contribution+$total_comp_contribution, 2, '.', ',')}}
                            </span>
                        </div>
                        <div role="separator" class="dropdown-divider"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 backToFolderList" style="padding:0px;">
                <h5 class='col-md-6 text-left float-left' style="margin-top:10px; padding:0px; cursor: pointer;">
                    <i class="fa fa-bars"></i>
                    Provident Fund
                </h5>
            </div>
            <table id="providentFundListTable" class="table table-striped table-bordered" cellspacing="0" style="font-size:12px; border: none;">
                <thead>
                    <tr class="text-center">
                        <th scope='col' style='border:1px solid #ddd !important;'>#</th>
                        <th scope='col' style='border:1px solid #ddd !important;'>Month </th>
                        <th scope='col' style='border:1px solid #ddd !important;'>Date </th>
                        <th scope='col' style='border:1px solid #ddd !important; width: 30%;'>Employee Contribution </th>
                        <th scope='col' style='border:1px solid #ddd !important;'>Company Contribution </th>
                        <th scope='col' style='border:1px solid #ddd !important;'> Total </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($provident_fund_info)) : ?>
                        <?php
                        $i = 0;
                        foreach ($provident_fund_info as $key => $provident) :
                            $i++;
                        ?>
                            <tr role="row" class="odd">
                                <td class="text-center sorting_1">
                                    {{$i}}
                                </td>
                                <td class="text-center">
                                    {{date('F', strtotime($provident['pf_date']))}}
                                </td>
                                <td class="text-center">
                                    {{date('d M Y', strtotime($provident['pf_date']))}}
                                </td>
                                <td class="text-center">
                                    {{number_format($provident['pf_employee_amount'], 2, '.', ',')}}
                                </td>
                                <td class="text-center">
                                    {{number_format($provident['pf_company_amount'], 2, '.', ',')}}
                                </td>
                                <td class="text-center">
                                    {{number_format($provident['pf_employee_amount']+$provident['pf_company_amount'], 2, '.', ',')}}
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <?php echo 'No Data Found!' ?>
                    <?php endif ?>

                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="LoanAdvance" style="padding:0px;" role="tabpanel" aria-labelledby="home-tab">
            <div class="row" style="margin-left: -11px; margin-right: -11px; margin-top:15px;">
                <div class="col-6 col-sm-4 col-md-3" style="max-width: 20%;">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-list"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Loan</span>
                            <span class="info-box-number ">
                                <?php if ($total_loan_amount) : ?>
                                    {{number_format($total_loan_amount, 2, '.', ',') }}

                                <?php else : ?>
                                    {{number_format(0, 2, '.', ',') }}
                                <?php endif ?>
                            </span>
                        </div>
                        <div role="separator" class="dropdown-divider"></div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3" style="max-width: 20%;">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-money"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Ongoing Loan</span>
                            <span class="info-box-number ">
                                <?php if (!empty($current_loan_amount)) : ?>
                                    {{number_format($current_loan_amount, 2, '.', ',') }}
                                <?php else : ?>
                                    {{number_format(0, 2, '.', ',') }}
                                <?php endif ?>
                            </span>
                        </div>
                        <div role="separator" class="dropdown-divider"></div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3" style="max-width: 20%;">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">EMI: <strong>
                                    <?php if (!empty($paid_no_of_loan)) {
                                        echo $paid_no_of_loan;
                                    } else {
                                        echo '0';
                                    } ?>/<?php if (!empty($emp_loan_info_remaining)) {
                        echo $emp_loan_info_remaining['no_of_installment'];
                    } else {
                        echo '0';
                    }
                    ?>

                                </strong></span>
                            <span class="info-box-number ">
                                <?php if (!empty($paid_loan_amount)) : ?>
                                    {{number_format($total_paid_loan_amount, 2, '.', ',') }}
                                <?php else : ?>
                                    {{number_format(0, 2, '.', ',') }}
                                <?php endif ?>
                            </span>
                        </div>
                        <div role="separator" class="dropdown-divider"></div>
                    </div>
                </div>

                <div class="col-6 col-sm-4 col-md-3" style="max-width: 20%;">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Current Due</span>
                            <span class="info-box-number ">
                                <?php if (!empty($current_loan_amount) > 0) :
                                    $a = (int)$current_loan_amount;
                                    $b = (int)$total_paid_loan_amount;
                                ?>
                                    {{number_format($a - $b, 2, '.', ',') }}
                                <?php else : ?>
                                    {{number_format(0, 2, '.', ',') }}
                                <?php endif ?>
                            </span>
                        </div>
                        <div role="separator" class="dropdown-divider"></div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3" style="max-width: 20%;">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-list"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Paid</span>
                            <span class="info-box-number ">
                                <?php if (!empty($total_paid_loan_amount) > 0) : ?>
                                    {{number_format($total_paid_loan_amount, 2, '.', ',') }}
                                <?php else : ?>
                                    {{number_format(0, 2, '.', ',') }}
                                <?php endif ?>
                            </span>
                        </div>
                        <div role="separator" class="dropdown-divider"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 backToFolderList" style="padding:0px;">
                <h5 class='col-md-6 text-left float-left' style="margin-top:10px; padding:0px; cursor: pointer;">
                    <i class="fa fa-bars"></i>
                    Loan & Advance
                </h5>
            </div>
            <table id="loanListTable" class="table table-striped table-bordered loanListTable" cellspacing="0" style="font-size:12px; border: none;">
                <thead>
                    <tr class="text-center">
                        <th scope='col' style='border:1px solid #ddd !important;'>#</th>
                        <th scope='col' style='border:1px solid #ddd !important;'>Date </th>
                        <th scope='col' style='border:1px solid #ddd !important;'>No of Installment </th>
                        <th scope='col' style='border:1px solid #ddd !important;'>Loan Amount </th>
                        <th scope='col' style='border:1px solid #ddd !important;'>Paid </th>
                        <th scope='col' style='border:1px solid #ddd !important;'>Due </th>
                        <th scope='col' style='border:1px solid #ddd !important;'>Deduction Policy </th>
                        <th scope='col' style='border:1px solid #ddd !important;'> Status </th>
                        <th scope='col' style='border:1px solid #ddd !important;'> Action </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($employee_loan_info)) : ?>
                        <?php $i = 0;
                        foreach ($employee_loan_info as $key => $loan) :
                            $i++;
                            if ($loan['loan_deduct_policy'] == 1) {
                                $loan_policy = 'Auto';
                            } else {
                                $loan_policy = 'Manual';
                            }
                        ?>
                            <tr role="row" class="odd">
                                <td class="text-center sorting_1">
                                    {{$i}}
                                </td>
                                <td class="text-center">
                                    <?php
                                    echo date('d M Y', strtotime($loan['disburse_date']));
                                    ?>
                                </td>
                                <td class="text-center">
                                    {{$loan['no_of_installment']}}
                                </td>
                                <td class="text-right">
                                    {{$loan['loan_amount']}}
                                </td>
                                <td class="text-right">
                                    {{$loan['paid_amount']}}
                                </td>
                                <td class="text-right">
                                    {{$loan['loan_amount']-$loan['paid_amount']}}
                                </td>
                                <td class="text-center">
                                    {{$loan_policy}}
                                </td>
                                <td class="text-center">
                                    <?php if ($loan['loan_clearance_status'] == 1) : ?>
                                        <span style="color:green;">Clear</span>
                                    <?php else : ?>
                                        <span style="color:red;">Not Clear</span>
                                    <?php endif ?>
                                    <!-- {{$loan['loan_clearance_status']}} -->
                                </td>
                                <td class="text-center">
                                    <a title="Schedule" class="btn btn-xs btn-info loan_schedule_modal" href="#" data-toggle="modal" data-target="#loan_schedule_modal" data-whatever="@getbootstrap" data-loan_id="<?php echo $loan['id']; ?>" data-employee_id="<?php echo $loan['employee_id']; ?>">
                                        <i class="fa fa-calendar"></i> Schedule
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <?php echo "No Data Found!"; ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

      <!-- Pay Slip Modal Below -->
      <div class="modal fade" id="pay_slip_modal" tabindex="-1" role="dialog" aria-labelledby="pay_slip_modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-list"></i> Pay Slip</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <table width="100%">
                            <tr>
                                <td colspan="3" style="width: 20%; text-align: right;">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <p><i>Printing Date: <span id="print_date_id"></span></i>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">
                                    <div class="col-md-12">
                                        <img id="sbu_logo" alt="Logo" class="card-img-top  rounded" style="margin-top: 2px; width: 100px; border-radius: 50px;">
                                    </div>
                                </td>
                                <td style="width: 60%; text-align: center;">
                                    <div class="col-md-12 text-center">
                                        <h4>Pay Slip</h4>
                                        <h5>Month of <span id="salary_date_id"></span></h5>
                                    </div>
                                </td>
                                <td style="width: 20%;"></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table width="100%">
                                        <tr>
                                            <td width="50%">
                                                <div class="col-md-12 text-left">
                                                    <h6 id="employee_fullname_id"></h6>
                                                    <span id="designation_name_id"></span>
                                                </div>
                                            </td>
                                            <td style="text-align: right;" width="50%">
                                                <div class="col-md-12 text-right">Employee ID : <span id="employee_id_no_id"></span>
                                                    <br>Location : <span id="work_location_name_id"></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr class="bank_salary_section" class="trs" style="border-top: 1px solid rgb(108, 117, 125); border-bottom: 1px solid rgb(108, 117, 125); background: rgb(238, 238, 238) none repeat scroll 0% 0%; font-size: 15px; font-weight: 600;">
                                <td colspan="2" class="trs" style="padding: 0px 5px;">Gross Salary - Bank</td>
                                <td class="trs" style="text-align: right; padding: 0px 5px;" id="gross_salary_id"></td>
                            </tr>
                            <tr class="bank_salary_section">
                                <td colspan="2" style="padding: 0px 5px;">Arrears/Addition</td>
                                <td style="text-align: right; padding: 0px 5px;" id="total_additions_id"></td>
                            </tr>
                            <tr class="bank_salary_section">
                                <td colspan="2" style="padding: 0px 5px;">Employee PF</td>
                                <td style="text-align: right; padding: 0px 5px;">( <span id="deduction_pfbasic_id"></span> )</td>
                            </tr>
                            <tr class="bank_salary_section">
                                <td colspan="2" style="padding: 0px 5px;">With Holding TAX</td>
                                <td style="text-align: right; padding: 0px 5px;">( <span id="deduction_tax_id"></span> )</td>
                            </tr>
                            <tr class="bank_salary_section">
                                <td colspan="2" style="padding: 0px 5px;">Deduction</td>
                                <td style="text-align: right; padding: 0px 5px;">( <span id="total_deduction_id"></span> )</td>
                            </tr>
                            <tr class="bank_salary_section" class="trs" style="border-top: 1px solid rgb(108, 117, 125); border-bottom: 1px solid rgb(108, 117, 125); background: rgb(238, 238, 238) none repeat scroll 0% 0%; font-size: 15px; font-weight: 600;">
                                <td colspan="2" class="trs" style="padding: 0px 5px;">Net Payable(Bank)</td>
                                <td class="trs" style="text-align: right; padding: 0px 5px;" id="netpay_id"></td>
                            </tr>
                            <tr class="bank_salary_section" style="line-height: 8px;">
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr class="bank_salary_section" class="trs" style="border-top: 1px solid rgb(108, 117, 125); border-bottom: 1px solid rgb(108, 117, 125); background: rgb(238, 238, 238) none repeat scroll 0% 0%; font-size: 15px; font-weight: 600;">
                                <td colspan="2" class="trs" style="padding: 0px 5px;">Opening Balance PF</td>
                                <td class="trs" style="text-align: right; padding: 0px 5px;" id="openigPf_id"></td>
                            </tr>
                            <tr class="bank_salary_section">
                                <td colspan="2" style="padding: 0px 5px;">Employee PF</td>
                                <td style="text-align: right; padding: 0px 5px;" id="Pf_id"></td>
                            </tr>
                            <tr class="bank_salary_section">
                                <td colspan="2" style="padding: 0px 5px;">Company's Contribution PF</td>
                                <td style="text-align: right; padding: 0px 5px;" id="clPf_id"></td>
                            </tr>
                            <tr class="bank_salary_section" class="trs" style="border-top: 1px solid rgb(108, 117, 125); border-bottom: 1px solid rgb(108, 117, 125); background: rgb(238, 238, 238) none repeat scroll 0% 0%; font-size: 15px; font-weight: 600;">
                                <td colspan="2" class="trs" style="padding: 0px 5px;">Closing Balance PF</td>
                                <td class="trs" style="text-align: right; padding: 0px 5px;" id="closingPf_id"></td>
                            </tr>
                            <tr style="line-height: 8px;">
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <table id="salary_type_hide_show" style="display: none;">
                                <tr class="trs" style="border-top: 1px solid rgb(108, 117, 125); border-bottom: 1px solid rgb(108, 117, 125); background: rgb(238, 238, 238) none repeat scroll 0% 0%; font-size: 15px; font-weight: 600;">
                                    <td colspan="2" class="trs" style="padding: 0px 5px;">Gross Salary â€“ Cash</td>
                                    <td class="trs" style="text-align: right; padding: 0px 5px;" id="gross_salary_id_cash"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding: 0px 5px;">Employee PF</td>
                                    <td style="text-align: right; padding: 0px 5px;">( <span id="deduction_pfbasic_id_cash"></span> )</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding: 0px 5px;">Car Allowance</td>
                                    <td style="text-align: right; padding: 0px 5px;" id="car_allowance_id_cash"></td>
                                </tr>
                                <tr class="trs" style="border-top: 1px solid rgb(108, 117, 125); border-bottom: 1px solid rgb(108, 117, 125); background: rgb(238, 238, 238) none repeat scroll 0% 0%; font-size: 15px; font-weight: 600;">
                                    <td colspan="2" class="trs" style="padding: 0px 5px;">Net Payable(Cash)</td>
                                    <td class="trs" style="text-align: right; padding: 0px 5px;" id="netpay_id_cash"></td>
                                </tr>
                            </table>
                            <tr style="line-height: 8px;">
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <hr style="margin-top: 1rem; margin-bottom: 0rem; border-top: 1.6px solid rgb(52, 58, 65);">
                                    <div class="text-center">
                                        <p class="text-center"><i>This is computer generated copy and does not required any signature.</i>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- Pay Slip Modal End -->
    <!-- Loan Schedule Modal Below -->
    <div class="modal fade" id="loan_schedule_modal" tabindex="-1" role="dialog" aria-labelledby="loan_schedule_Label" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-money"></i> Loan Amount: <strong class="loan_amount_id"></strong> </h5>
                    <h5 class="modal-title"> &nbsp;&nbsp;|| &nbsp;&nbsp;<i class="fa fa-money"></i> Total Paid: <strong class="paid_loan_amount_id"></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="col-md-12">
                            <div>
                                <!-- <label class="control-label">Schedule Info:</label> -->
                                <table id="loanListTable" class="table table-hover table-bordered loan_salary_info_table loanListTable" style="width: 100%;">
                                    <thead>
                                        <tr class="text-center;">
                                            <th style="text-align: center; vertical-align: middle; background: rgb(245, 245, 245) none repeat scroll 0% 0%;">SL</th>
                                            <th style="text-align: center; vertical-align: middle; background: rgb(245, 245, 245) none repeat scroll 0% 0%;">Date</th>
                                            <th style="text-align: center; vertical-align: middle; background: rgb(245, 245, 245) none repeat scroll 0% 0%;">Loan</th>
                                            <th style="text-align: center; vertical-align: middle; background: rgb(245, 245, 245) none repeat scroll 0% 0%;">EMI</th>
                                            <th style="text-align: center; vertical-align: middle; background: rgb(245, 245, 245) none repeat scroll 0% 0%;">Rest</th>
                                            <th style="text-align: center; vertical-align: middle; background: rgb(245, 245, 245) none repeat scroll 0% 0%;"> Policy</th>
                                            <th style="text-align: center; vertical-align: middle; background: rgb(245, 245, 245) none repeat scroll 0% 0%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id='loanListAppendData'>

                                    </tbody>
                                    <tfoot>
                                        <th colspan="3" style="text-align: right;">
                                            Loan: <strong class="loan_amount_id" style="color:orange;"></strong>

                                        </th>
                                        <!-- <th> || </th> -->
                                        <th colspan="2">
                                            Total Paid: <strong class="paid_loan_amount_id" style="color:green;"></strong>
                                        </th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
