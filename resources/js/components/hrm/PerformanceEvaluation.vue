<template>
    <div>
         <!-- v-if="page_loading" -->
        <div class="widget box">
            <div class="widget-header">
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                                            <h3 class="card-title d-none d-md-block"><i class="fa fa-line-chart"></i> Probation Performance Evaluation</h3>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="card-body col-md-12">
                                        <div class="col-md-12" style="border: 1px solid #ddd;padding:0px;">
                                                <!-- Page Wrapper -->
                                                <div id="wrapper">
                                                    <!-- Content Wrapper -->
                                                    <div id="content-wrapper">
                                                        <!-- Main Content -->
                                                        <div id="content">
                                                            <!-- Begin Page Content -->
                                                            <div class="">
                                                                <div class="tabControl">
                                                                    <div class="">
                                                                        <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
                                                                            <li class="nav-item">
                                                                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-1" role="tab">Performance Assessment Form</a>
                                                                            </li>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-2" role="tab">Competencies Assessment Form</a>
                                                                            </li>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-3" role="tab">Employee Development Form</a>
                                                                            </li>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-4" role="tab">Talent Assessment Form</a>
                                                                            </li>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-5" role="tab">Probation Performance Evaluation Form</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="tab-content p-4 border rounded" id="pills-tabContent">
                                                                        <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-home-tab">
                                                                            <!-- <form @submit.prevent="add({add:'complementary_entry/add'},resetModal)" class="form-horizontal  row-border" id="validate-1"> -->
                                                                            <table style="width:100% !important;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td colspan="8" class="probation_performance_header" style="border-top:1.0pt solid windowtext;">
                                                                                            GEMCON GROUP
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="8" class="probation_performance_header">
                                                                                            PERFORMANCE ASSESSMENT FORM <i>(DD-MMM-YY to DD-MMM-YY)</i>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="8" class="probation_header_subtitle">&nbsp;(For Management Team Members)</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design" style="width:20%;"><br></td>
                                                                                        <td class="white_text_design">NAME</td>
                                                                                        <td colspan="2" class="white_text_design">DESIGNATION</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">Employee:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;width:40%;">
                                                                                            {{employee_datas.employee_fullname}}
                                                                                            <input type="hidden" v-model="form_data.employee_primary_id">
                                                                                            <input type="hidden" v-model="form_data.employee_id">
                                                                                        </td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{employee_datas.designation_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;" >Supervisor:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{ employee_datas.reporting_name || 'Not available'}}</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{ supervisor_designation.designation_name || 'Not available'}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">Second Line Supervisor:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{'Not available'}}</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{'Not available'}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td rowspan="2" class="white_text_design text-left" style="padding-left:5px; vertical-align:middle" >Date of Joining (DD/MM/YY) :</td>
                                                                                        <td rowspan="2" class="white_box_design" style="padding-left:15px; vertical-align:middle">{{employee_datas.employee_joining_date}}</td>
                                                                                        <td class="white_text_design" style="width:15%;">Employee ID:</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{employee_datas.employee_id_no}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design">Job Grade:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{employee_datas.employee_group_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">SBU/Corporate</td>
                                                                                        <td colspan="3" class="white_box_design" style="padding-left:15px;">{{employee_datas.sbu_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">Work Location</td>
                                                                                        <td colspan="3" class="white_box_design" style="padding-left:15px;">{{employee_datas.work_location_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="8" class="kra_kpi_herader">Part 1 : KRA and KPI Measurement</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <table style="width:100% !important;">     
                                                                                <thead>    
                                                                                    <tr>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:4%">Sl #</td>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:15%">Key Result Areas <br>(KRA)</td>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:18%">Key Performance Indicator (KPI)</td>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:22%">MOS</td>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:8%">Weightage <br> (%)</td>
                                                                                        <td colspan="3" class="kra_kpi_sub_herader">Probation End Review</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" style="width:8%">Self<br>(Out of 100)</td>
                                                                                        <td class="kra_kpi_sub_herader" style="width:8%">Supervisor <br>(Out of 100)</td>
                                                                                        <td class="kra_kpi_sub_herader" style="width:8%">Total</td>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <template v-for="(item, index) in items">
                                                                                        <tr :key="item.id">
                                                                                            <td class="kra_kpi_sub_herader" 
                                                                                            >
                                                                                            {{index + 1}}
                                                                                            </td>
                                                                                            <td class="kra_kpi_sub_herader"
                                                                                                :rowspan="rowVisible(index, item, 'kra')"
                                                                                                v-if="
                                                                                                    (items[index > 0 ? index - 1 : 0].kra_id !=
                                                                                                    item.kra_id ||
                                                                                                    index == 0)
                                                                                                "
                                                                                            >
                                                                                            {{
                                                                                                item.krajoin ? item.krajoin.kra_name : ""
                                                                                            }}
                                                                                            </td>
                                                                                        
                                                                                            <td class="kra_kpi_sub_herader"
                                                                                                :rowspan="rowVisible(index, item, 'kpi')"
                                                                                                v-if="
                                                                                                    
                                                                                                    (items[index > 0 ? index - 1 : 0].kpi_id !=
                                                                                                    item.kpi_id ||
                                                                                                    index == 0)
                                                                                                "
                                                                                            >
                                                                                            {{
                                                                                                item.kpijoin ? item.kpijoin.kpi_name : ""
                                                                                            }}
                                                                                            </td>
                                                                                            <td v-if="show_mos == 1" class="kra_kpi_sub_herader"
                                                                                            >
                                                                                            {{ item.mos_name }}
                                                                                            </td>
                                                                                            <td  class="kra_kpi_sub_herader" v-if="show_mos == 1">
                                                                                                <!-- {{ item.weightage ? item.weightage : "" }} -->
                                                                                                {{total_sum_value_weightage(index, item.weightage)}}
                                                                                            </td>
                                                                                            <td  class="kra_kpi_sub_herader" v-if="show_mos == 1">
                                                                                                {{mos_monthwise_total(index, item.mosachievementjoin)}}
                                                                                            </td>
                                                                                            <td  class="kra_kpi_sub_herader" v-if="show_mos == 1">
                                                                                                <input type="number" v-model="item.supervisors_marks" @input="TotalSupervisorValue($event,item.supervisors_marks,index)" style="border:none; text-align:center; font-weight:bold; padding-left: 15px;" placeholder="Enter your value">
                                                                                            </td>
                                                                                            <td  class="kra_kpi_sub_herader" v-if="show_mos == 1">
                                                                                                {{total_store(index, item.weightage , item.supervisors_marks)}}
                                                                                            </td>
                                                                                        </tr>
                                                                                    </template>
                                                                                </tbody>
                                                                                <tbody>     
                                                                                    <tr>
                                                                                        <td colspan="4" class="kra_kpi_herader">Part 1 : Aggregate KRA and KPI score obtained by the Employee</td>
                                                                                        <td class="kra_kpi_sub_herader">{{_total_sum_value_weightage()}}</td>
                                                                                        <td class="kra_kpi_sub_herader">{{_total_sum_value_self()}}</td>
                                                                                        <td class="kra_kpi_sub_herader">{{_total_sum_value_supervisor()}}</td>
                                                                                        <td class="kra_kpi_sub_herader">
                                                                                            {{total_sum_value()}}
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <div class="row navbuttons pt-5" style="padding-top:1rem !important;">
                                                                                <div class="col-6 col-sm-auto" id="btnNext"  @click="btnNext(1)">
                                                                                    <a class="btn btn-success btnNext">Next</a>
                                                                                </div>
                                                                            </div>
                                                                            <!-- </form> -->
                                                                        </div>
                                                                        <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                                            <table style="border: none;border-collapse: collapse;width:100% !important;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td colspan="7" class="probation_performance_header" style="border-top:1.0pt solid windowtext;">
                                                                                            GEMCON GROUP
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="7" class="probation_performance_header">
                                                                                            COMPETENCIES ASSESSMENT FORM <i>(DD-MMM-YY to DD-MMM-YY)</i>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="7" class="probation_header_subtitle">&nbsp;(For Management Team Members)</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design"><br></td>
                                                                                        <td class="white_text_design">NAME</td>
                                                                                        <td colspan="2"  class="white_text_design">DESIGNATION</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">Employee:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;width:40%;">{{employee_datas.employee_fullname}}</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{employee_datas.designation_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;" >Supervisor:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{ employee_datas.reporting_name || 'Not available'}}</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{ supervisor_designation.designation_name || 'Not available'}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">Second Line Supervisor:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{'Not available'}}</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{'Not available'}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td rowspan="2" class="white_text_design text-left" style="padding-left:5px; vertical-align:middle" >Date of Joining (DD/MM/YY) :</td>
                                                                                        <td rowspan="2" class="white_box_design" style="padding-left:15px; vertical-align:middle">{{employee_datas.employee_joining_date}}</td>
                                                                                        <td class="white_text_design" style="width:15%;">Employee ID:</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{employee_datas.employee_id_no}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design">Job Grade:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{employee_datas.employee_group_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">SBU/Corporate</td>
                                                                                        <td colspan="3" class="white_box_design" style="padding-left:15px;">{{employee_datas.sbu_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">Work Location</td>
                                                                                        <td colspan="3" class="white_box_design" style="padding-left:15px;">{{employee_datas.work_location_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="7" class="kra_kpi_herader">Part 2 : Competencies/Skills Measurement</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <table style="width:100% !important;">
                                                                                <thead>    
                                                                                    <tr>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:4%">Sl #</td>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:15%">Critical Success Factors</td>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:18%">Description</td>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:22%">MOS</td>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:8%">Weightage <br> (%)</td>
                                                                                        <td colspan="3" class="kra_kpi_sub_herader">Year End Review</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" style="width:8%">Self<br>(Out of 100)</td>
                                                                                        <td class="kra_kpi_sub_herader" style="width:8%">Supervisor <br>(Out of 100)</td>
                                                                                        <td class="kra_kpi_sub_herader" style="width:8%">Total</td>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <template v-for="(item, index) in items">
                                                                                        <tr :key="item.id">
                                                                                            <td class="kra_kpi_sub_herader" 
                                                                                            >
                                                                                            {{index + 1}}
                                                                                            </td>
                                                                                            <td class="kra_kpi_sub_herader"
                                                                                                :rowspan="rowVisible(index, item, 'kra')"
                                                                                                v-if="
                                                                                                    
                                                                                                    (items[index > 0 ? index - 1 : 0].kra_id !=
                                                                                                    item.kra_id ||
                                                                                                    index == 0)
                                                                                                "
                                                                                            >
                                                                                            {{
                                                                                                item.krajoin ? item.krajoin.kra_name : ""
                                                                                            }}
                                                                                            </td>
                                                                                        
                                                                                            <td class="kra_kpi_sub_herader"
                                                                                                :rowspan="rowVisible(index, item, 'kpi')"
                                                                                                v-if="
                                                                                                    
                                                                                                    (items[index > 0 ? index - 1 : 0].kpi_id !=
                                                                                                    item.kpi_id ||
                                                                                                    index == 0)
                                                                                                "
                                                                                            >
                                                                                            {{
                                                                                                item.kpijoin ? item.kpijoin.kpi_name : ""
                                                                                            }}
                                                                                            </td>
                                                                                            <td v-if="show_mos == 1" class="kra_kpi_sub_herader"
                                                                                            >
                                                                                            {{ item.mos_name }}
                                                                                            </td>
                                                                                            <td  class="kra_kpi_sub_herader" v-if="show_mos == 1">
                                                                                                <!-- {{ item.weightage ? item.weightage : "" }} -->
                                                                                                {{total_sum_value_weightage(index, item.weightage)}}
                                                                                            </td>
                                                                                            <td  class="kra_kpi_sub_herader" v-if="show_mos == 1">
                                                                                                {{mos_monthwise_total(index, item.mosachievementjoin)}}
                                                                                            </td>
                                                                                            <td  class="kra_kpi_sub_herader" v-if="show_mos == 1">
                                                                                                <input type="number" v-model="item.supervisors_marks" @input="TotalSupervisorValue($event,item.supervisors_marks,index)" style="border:none; text-align:center; font-weight:bold; padding-left: 15px;" placeholder="Enter your value">
                                                                                            </td>
                                                                                            <td  class="kra_kpi_sub_herader" v-if="show_mos == 1">
                                                                                                {{total_store(index, item.weightage , item.supervisors_marks)}}
                                                                                            </td>
                                                                                        </tr>
                                                                                    </template>
                                                                                </tbody>
                                                                                <tbody>     
                                                                                    <tr>
                                                                                        <td colspan="4" class="kra_kpi_herader">Part 1 : Aggregate KRA and KPI score obtained by the Employee</td>
                                                                                        <td class="kra_kpi_sub_herader">{{_total_sum_value_weightage()}}</td>
                                                                                        <td class="kra_kpi_sub_herader">{{_total_sum_value_self()}}</td>
                                                                                        <td class="kra_kpi_sub_herader">{{_total_sum_value_supervisor()}}</td>
                                                                                        <td class="kra_kpi_sub_herader">
                                                                                            {{total_sum_value()}}
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <div class="row navbuttons pt-5" style="padding-top:1rem !important;">
                                                                                <div class="col-6 col-sm-auto" id="btnPrevious"  @click="btnPrevious">
                                                                                    <a class="btn btn-primary btnPrevious">Previous</a>
                                                                                </div>
                                                                                <div class="col-6 col-sm-auto" id="btnNext"  @click="btnNext(2)">
                                                                                    <a class="btn btn-success btnNext">Next</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-contact-tab">
                                                                            <table style="border: none;border-collapse: collapse;width:100% !important;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td colspan="7" class="probation_performance_header" style="border-top:1.0pt solid windowtext;">
                                                                                            GEMCON GROUP
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="7" class="probation_performance_header">
                                                                                            EMPLOYEE DEVELOPMENT FORM <i>(DD-MMM-YY to DD-MMM-YY)</i>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="7" class="probation_header_subtitle">(For Management Team Members)</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design"><br></td>
                                                                                        <td class="white_text_design">NAME</td>
                                                                                        <td colspan="2"  class="white_text_design">DESIGNATION</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">Employee:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;width:40%;">{{employee_datas.employee_fullname}}</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{employee_datas.designation_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;" >Supervisor:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{ employee_datas.reporting_name || 'Not available'}}</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{ supervisor_designation.designation_name || 'Not available'}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">Second Line Supervisor:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{'Not available'}}</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{'Not available'}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td rowspan="2" class="white_text_design text-left" style="padding-left:5px; vertical-align:middle" >Date of Joining (DD/MM/YY) :</td>
                                                                                        <td rowspan="2" class="white_box_design" style="padding-left:15px; vertical-align:middle">{{employee_datas.employee_joining_date}}</td>
                                                                                        <td class="white_text_design" style="width:15%;">Employee ID:</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{employee_datas.employee_id_no}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design">Job Grade:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{employee_datas.employee_group_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">SBU/Corporate</td>
                                                                                        <td colspan="3" class="white_box_design" style="padding-left:15px;">{{employee_datas.sbu_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">Work Location</td>
                                                                                        <td colspan="3" class="white_box_design" style="padding-left:15px;">{{employee_datas.work_location_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="7" class="kra_kpi_herader">Part 2 : Competencies/Skills Measurement</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <table style="width:100% !important;">
                                                                                <tbody>   
                                                                                    <tr>
                                                                                        <td colspan="7" class="kra_kpi_herader text-left">
                                                                                            Employee Development Plan: Identify one or two targeted competencies that will enhance current job  effectiveness and/or provide growth opportunities. Then suggest how the employee can advance these areas (include training and non-training activities). Please refer to Competency Definition and Type as detailed in Gemcon Group PMS in the HR Manual for development suggestions.
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="7" class="kra_kpi_sub_herader text-left">COMPETENCY 1:</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="4" class="kra_kpi_sub_herader text-left">Comments:
                                                                                            <textarea v-model="form_data.compentency_comments1" name="" style="width:100%;" rows="3"></textarea>
                                                                                        </td>
                                                                                        <td colspan="3" class="kra_kpi_sub_herader text-left">Development Suggestions:
                                                                                            <textarea v-model="form_data.compentency_suggestions1" name="" style="width:100%;" rows="3"></textarea>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td  colspan="7" class="kra_kpi_sub_herader text-left">COMPETENCY 2:</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="4" class="kra_kpi_sub_herader text-left">Comments:
                                                                                             <textarea v-model="form_data.compentency_comments2" name="" style="width:100%;" rows="3"></textarea>
                                                                                        </td>
                                                                                        <td colspan="3" class="kra_kpi_sub_herader text-left">Development Suggestions:
                                                                                             <textarea v-model="form_data.compentency_suggestions2" name="" style="width:100%;" rows="3"></textarea>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="4" class="kra_kpi_herader text-left">Signature of the employee with date</td>
                                                                                        <td colspan="3" class="kra_kpi_sub_herader"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="4" class="kra_kpi_herader text-left">Signature of the supervsior with date </td>
                                                                                        <td colspan="3" class="kra_kpi_sub_herader"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="4" class="kra_kpi_herader text-left">Signature of the SBU Head/HOD with date </td>
                                                                                        <td colspan="3" class="kra_kpi_sub_herader"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="4" class="kra_kpi_herader text-left">Signature of the Group HoHR/Director with date </td>
                                                                                        <td colspan="3" class="kra_kpi_sub_herader"></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <div class="row navbuttons pt-5" style="padding-top:1rem !important;">
                                                                                <div class="col-6 col-sm-auto" id="btnPrevious"  @click="btnPrevious">
                                                                                    <a class="btn btn-primary btnPrevious">Previous</a>
                                                                                </div>
                                                                                <div class="col-6 col-sm-auto" id="btnNext"  @click="btnNext(3)">
                                                                                    <a class="btn btn-success btnNext">Next</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="tab-pane fade" id="pills-4" role="tabpanel" aria-labelledby="pills-contact-tab">
                                                                            <table style="border: none;border-collapse: collapse;width:100% !important;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td colspan="7" class="probation_performance_header" style="border-top:1.0pt solid windowtext;">
                                                                                            GEMCON GROUP
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="7" class="probation_performance_header">
                                                                                            TALENT ASSESSMENT FORM <i>(DD-MMM-YY to DD-MMM-YY)</i>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="7" class="probation_header_subtitle">&nbsp;(For Management Team Members)</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design"><br></td>
                                                                                        <td class="white_text_design">NAME</td>
                                                                                        <td colspan="2"  class="white_text_design">DESIGNATION</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">Employee:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;width:40%;">{{employee_datas.employee_fullname}}</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{employee_datas.designation_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;" >Supervisor:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{ employee_datas.reporting_name || 'Not available'}}</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{ supervisor_designation.designation_name || 'Not available'}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">Second Line Supervisor:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{'Not available'}}</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{'Not available'}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td rowspan="2" class="white_text_design text-left" style="padding-left:5px; vertical-align:middle" >Date of Joining (DD/MM/YY) :</td>
                                                                                        <td rowspan="2" class="white_box_design" style="padding-left:15px; vertical-align:middle">{{employee_datas.employee_joining_date}}</td>
                                                                                        <td class="white_text_design" style="width:15%;">Employee ID:</td>
                                                                                        <td colspan="2" class="white_box_design" style="padding-left:15px;">{{employee_datas.employee_id_no}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design">Job Grade:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{employee_datas.employee_group_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">SBU/Corporate</td>
                                                                                        <td colspan="3" class="white_box_design" style="padding-left:15px;">{{employee_datas.sbu_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="white_text_design text-left" style="padding-left:5px;">Work Location</td>
                                                                                        <td colspan="3" class="white_box_design" style="padding-left:15px;">{{employee_datas.work_location_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="7" class="kra_kpi_herader">Part 2 : Competencies/Skills Measurement</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <table style="width:100% !important;">
                                                                                <thead>    
                                                                                    <tr>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:4%">Sl #</td>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:15%">Growth Potential Factors</td>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:18%">Key Performance Indicator (KPI)</td>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:22%">MOS</td>
                                                                                        <td rowspan="2" class="kra_kpi_sub_herader" style="width:8%">Weightage <br> (%)</td>
                                                                                        <td colspan="3" class="kra_kpi_sub_herader">Probation End Review</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" style="width:8%">Self<br>(Out of 100)</td>
                                                                                        <td class="kra_kpi_sub_herader" style="width:8%">Supervisor <br>(Out of 100)</td>
                                                                                        <td class="kra_kpi_sub_herader" style="width:8%">Total</td>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <template v-for="(item, index) in items">
                                                                                        <tr :key="item.id">
                                                                                            <td class="kra_kpi_sub_herader" 
                                                                                            >
                                                                                            {{index + 1}}
                                                                                            </td>
                                                                                            <td class="kra_kpi_sub_herader"
                                                                                                :rowspan="rowVisible(index, item, 'kra')"
                                                                                                v-if="
                                                                                                    
                                                                                                    (items[index > 0 ? index - 1 : 0].kra_id !=
                                                                                                    item.kra_id ||
                                                                                                    index == 0)
                                                                                                "
                                                                                            >
                                                                                            {{
                                                                                                item.krajoin ? item.krajoin.kra_name : ""
                                                                                            }}
                                                                                            </td>
                                                                                        
                                                                                            <td class="kra_kpi_sub_herader"
                                                                                                :rowspan="rowVisible(index, item, 'kpi')"
                                                                                                v-if="
                                                                                                    
                                                                                                    (items[index > 0 ? index - 1 : 0].kpi_id !=
                                                                                                    item.kpi_id ||
                                                                                                    index == 0)
                                                                                                "
                                                                                            >
                                                                                            {{
                                                                                                item.kpijoin ? item.kpijoin.kpi_name : ""
                                                                                            }}
                                                                                            </td>
                                                                                            <td v-if="show_mos == 1" class="kra_kpi_sub_herader"
                                                                                            >
                                                                                            {{ item.mos_name }}
                                                                                            </td>
                                                                                            <td  class="kra_kpi_sub_herader" v-if="show_mos == 1">
                                                                                                <!-- {{ item.weightage ? item.weightage : "" }} -->
                                                                                                {{total_sum_value_weightage(index, item.weightage)}}
                                                                                            </td>
                                                                                            <td  class="kra_kpi_sub_herader" v-if="show_mos == 1">
                                                                                                {{mos_monthwise_total(index, item.mosachievementjoin)}}
                                                                                            </td>
                                                                                            <td  class="kra_kpi_sub_herader" v-if="show_mos == 1">
                                                                                                <input type="number" v-model="item.supervisors_marks" @input="TotalSupervisorValue($event,item.supervisors_marks,index)" style="border:none; text-align:center; font-weight:bold; padding-left: 15px;" placeholder="Enter your value">
                                                                                            </td>
                                                                                            <td  class="kra_kpi_sub_herader" v-if="show_mos == 1">
                                                                                                {{total_store(index, item.weightage , item.supervisors_marks)}}
                                                                                            </td>
                                                                                        </tr>
                                                                                    </template>
                                                                                </tbody>
                                                                                <tbody>     
                                                                                    <tr>
                                                                                        <td colspan="4" class="kra_kpi_herader">Part 1 : Aggregate KRA and KPI score obtained by the Employee</td>
                                                                                        <td class="kra_kpi_sub_herader">{{_total_sum_value_weightage()}}</td>
                                                                                        <td class="kra_kpi_sub_herader">{{_total_sum_value_self()}}</td>
                                                                                        <td class="kra_kpi_sub_herader">{{_total_sum_value_supervisor()}}</td>
                                                                                        <td class="kra_kpi_sub_herader">
                                                                                            {{total_sum_value()}}
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <div class="row navbuttons pt-5" style="padding-top:1rem !important;">
                                                                                <div class="col-6 col-sm-auto" id="btnPrevious"  @click="btnPrevious">
                                                                                    <a class="btn btn-primary btnPrevious">Previous</a>
                                                                                </div>
                                                                                <div class="col-6 col-sm-auto" id="btnNext"  @click="btnNext(4)">
                                                                                    <a class="btn btn-success btnNext">Next</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="tab-pane fade" id="pills-5" role="tabpanel" aria-labelledby="pills-contact-tab">
                                                                            <table style="border: none;border-collapse: collapse;width:100% !important;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td colspan="7" class="probation_performance_header" style="border-top:1.0pt solid windowtext;">
                                                                                            GEMCON GROUP
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="7" class="probation_performance_header">
                                                                                            Probation Performance Evaluation Form
                                                                                        </td>
                                                                                    </tr>
                                                                                    
                                                                                    <tr>
                                                                                        <td class="black_text_design text-left" style="padding-left:5px; width:25%;">Name & ID:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;width:30%;">{{employee_datas.employee_fullname}}, {{employee_datas.employee_id_no}}</td>
                                                                                        <td class="black_text_design text-left" style="padding-left:5px;">Designation:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{employee_datas.designation_name}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="black_text_design text-left" style="padding-left:5px;">Department:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;width:30%;">{{employee_datas.department_name}}</td>
                                                                                        <td class="black_text_design text-left" style="padding-left:5px;">Date of Joining:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{employee_datas.employee_joining_date}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="black_text_design text-left" style="padding-left:5px;">SBU/Function:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;width:30%;">{{employee_datas.sbu_name}}</td>
                                                                                        <td class="black_text_design text-left" style="padding-left:5px;">Due Date of Confirmation:</td>
                                                                                        <td class="white_box_design" style="padding-left:15px;">{{employee_datas.employee_confirmation_due_date}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="black_text_design text-left" style="padding-left:5px;">Highest Education:</td>
                                                                                        <td class="black_text_design" style="padding-left:15px;width:30%;">{{'-'}}</td>
                                                                                        <td class="black_text_design text-left" style="padding-left:5px;">Present Salary (Tk.):</td>
                                                                                        <td class="black_text_design" style="padding-left:15px;">{{'-'}}</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <table style="width:100% !important; margin-top:10px;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader">Factors</td>
                                                                                        <td class="kra_kpi_sub_herader">Score</td>
                                                                                        <td class="kra_kpi_sub_herader">Weightage (fixed)</td>
                                                                                        <td class="kra_kpi_sub_herader">Aggregate Score</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" style="text-align:left; padding-left:5px;">KRA & KPI Measurement</td>
                                                                                        <td class="kra_kpi_sub_herader">0</td>
                                                                                        <td class="kra_kpi_sub_herader">60%</td>
                                                                                        <td class="kra_kpi_sub_herader">0</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" style="text-align:left; padding-left:5px;">Competencies/Skills</td>
                                                                                        <td class="kra_kpi_sub_herader">0</td>
                                                                                        <td class="kra_kpi_sub_herader">40%</td>
                                                                                        <td class="kra_kpi_sub_herader">0</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" colspan="3" style="text-align:left; padding-left:5px;"><strong>Individual Performance Assessment Consolidated Score</strong></td>
                                                                                        <td class="kra_kpi_sub_herader">0</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" colspan="3" style="text-align:left; padding-left:5px;"><strong>Indicate Performance Rating Stage</strong></td>
                                                                                        <td class="kra_kpi_sub_herader">0</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" colspan="3" style="text-align:left; padding-left:5px;">Performance Assessment Rating (Outstanding/Excellent=3, Competent/Average=2, Below Average=1)</td>
                                                                                        <td class="kra_kpi_sub_herader">0</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" colspan="3" style="text-align:left; padding-left:5px;"><strong>Aggregate Growth Potential Score Obtained (85 & Above=3, 65 to 84=2, Below 65=1)</strong></td>
                                                                                        <td class="kra_kpi_sub_herader">1</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" colspan="3" style="text-align:left; padding-left:5px;"><strong>Indicate Talent Assessment Stage (Refer to the boxes and state)</strong></td>
                                                                                        <td class="kra_kpi_sub_herader">FALSE</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" colspan="3" style="text-align:left; padding-left:5px;"><strong>Action on the Talent</strong></td>
                                                                                        <td class="kra_kpi_sub_herader">FALSE</td>
                                                                                    </tr>
                                                                                    
                                                                                </tbody>
                                                                            </table>
                                                                            <table style="width:100% !important; margin-top:10px;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" colspan="4" style="text-align:center; padding-left:5px;"><strong><i>Recommendation (by Supervisor/ Evaluator/ Unit head)</i></strong></td>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" style="text-align:left; padding-left:5px; width:20%;">
                                                                                            <input type="checkbox" v-model="form_data.confirmation" @click="supervisors_status(1)">
                                                                                            Confirmation</td>
                                                                                        <td class="kra_kpi_sub_herader"  colspan="3"  rowspan="3" style="text-align:left;">
                                                                                            Any Comment:
                                                                                            <textarea v-model="form_data.supervisors_rec_comment" name="" style="width:100%;" rows="3"></textarea>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" style="text-align:left; padding-left:5px;">
                                                                                            <input type="checkbox" v-model="form_data.extension" @click="supervisors_status(2)">
                                                                                            Extension</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader"  style="text-align:left; padding-left:5px;">
                                                                                            <input type="checkbox" v-model="form_data.termination" @click="supervisors_status(3)">
                                                                                            Termination</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <table style="border: none;margin-top:10px;border-collapse: collapse;width:100% !important;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="black_text_design text-left" style="padding-left:5px; width:25%;">Signature with date of Evaluator/Immediate Supervisor</td>
                                                                                        <td class="black_text_design" style="padding-left:15px;width:30%;"></td>
                                                                                        <td class="black_text_design text-left" style="padding-left:5px;">Designation:</td>
                                                                                        <td class="black_text_design" style="padding-left:15px;"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="black_text_design text-left" style="padding-left:5px; width:25%;">Signature with date of Unit/Function Head</td>
                                                                                        <td class="black_text_design" style="padding-left:15px;width:30%;"></td>
                                                                                        <td class="black_text_design text-left" style="padding-left:5px;">Designation:</td>
                                                                                        <td class="black_text_design" style="padding-left:15px;"></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <table style="width:100% !important; margin-top:10px;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" colspan="4" style="text-align:center; padding-left:5px;"><strong><i>Recommendation (by Supervisor/ Evaluator/ Unit head)</i></strong></td>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" style="text-align:left; padding-left:5px; width:20%;">
                                                                                            <label for="">
                                                                                                <input type="checkbox" v-model="form_data.apporved" @click="hr_status(1)">
                                                                                                Approved
                                                                                            </label>
                                                                                        </td>
                                                                                        <td class="kra_kpi_sub_herader"  colspan="3"  rowspan="3" style="text-align:right; padding-top:60px;">
                                                                                            <!-- <p style="text-align:center;"> -->
                                                                                                <span style="border-top:1px solid #000;">
                                                                                                    Head of HR & Adminidtration <br/>
                                                                                                </span>
                                                                                                <span>Gemcon Group</span>
                                                                                            <!-- </p> -->
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader" style="text-align:left; padding-left:5px;">
                                                                                            <label for="">
                                                                                                <input type="checkbox" v-model="form_data.not_apporved" @click="hr_status(2)">
                                                                                                Not Approved
                                                                                            </label>
                                                                                            </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="kra_kpi_sub_herader"  style="text-align:left; padding-left:5px;">
                                                                                            <label for="">
                                                                                                <input type="checkbox" v-model="form_data.deffered_upto" @click="hr_status(3)">
                                                                                                Deffered up to
                                                                                            </label>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <div class="row navbuttons pt-5" style="padding-top:1rem !important;">
                                                                                <div class="col-6 col-sm-auto" id="btnPrevious"  @click="btnPrevious">
                                                                                    <a class="btn btn-primary btnPrevious">Previous</a>
                                                                                </div>
                                                                                <div class="col-6 col-sm-auto" id="btnNext"  @click="btnNext(5)">
                                                                                    <a class="btn btn-success btnNext">Save</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- <div v-if="!page_loading">
            <pageLoading></pageLoading>
        </div> -->
    </div>
</template>
<script>
import Loading from "../Loading.vue";
import $ from "jquery";
export default {
  data() {
    return {
      total_store_value: [],
      final_total_sum_value_weightage: [],
      final_total_sum_value_self: [],
      final_total_sum_supervisors: [],
      employee_name_value: "",
      employee_datas: [],
      items: [],
      items1: [],
      items2: [],
      itemval: [],
      form_data: {
          'comments1': '',
          'suggestion1': '',
            'comments2': '',
            'suggestion2': '',
            'employee_id': '',
            'id': '',
            'val': '',
      },
      dataItemExel: "",
      show_kra: 1,
      show_kpi: 1,
      show_mos: 1,
      status: "",
      supervisor_designation: "",
      supervisor_data: "",
      mos_total_mark: "",
      total_mos_mark_by_super: "",
      total_supervisor_mark: "",
      total_supervisor_mark_by_super: "",
    };
  },
  created() {
    this.getList();
  },
  components: {
    pageLoading: Loading,
  },
  watch: {
    cim_experience_mark: function (val) {
      // this.form_data.cim_experience_mark = val;
      // this.cim_experience_mark =val;
      // let total=(+this.cim_experience_mark)+ (+this.cim_dressup_mark)+(+this.cim_academic_mark)+(+this.cim_viva_mark)+(+this.cim_written_mark);
      //  this.cim_total_mark=(total).toFixed(2);
      //  this.form_data.cim_total_mark=(total).toFixed(2);
      //  console.log(this.cim_total_mark);
    },
  },
  methods: {
    // viewReport(addUrl, callback) {
    //     console.log(this.form_data);
    //     console.log(URL.baseUrl(addUrl.add));
    //     this.modal_loading = false;
    //     axios.post(URL.baseUrl(addUrl.add), this.form_data)
    //     .then(res => {
    //         console.log(res);
    //         this.page_loading = true;
    //     })
    //     .catch(error => {
    //         console.log(error);
    //         if (error.response.status == 422) {
    //             this.errors = error.response.data.errors;
    //         }
    //         this.page_loading = true;
    //         var msg = 'opps! something went wrong';
    //         this.showToster({ status: 0, message: msg });
    //     });
    // },

    total_sum_value_weightage(index, value) {
        let total = 0;
        total += value;
        this.final_total_sum_value_weightage[index] = parseInt(total);
        return total;
    },
    _total_sum_value_weightage() {
        const sum = this.final_total_sum_value_weightage.reduce((a, b) => a + b, 0);
        return sum;
    },
    total_store(index, weightage, modified_total) {
        this.total_store_value[index] = weightage * modified_total;
        return weightage * modified_total;
    },
    total_sum_value() {
        const sum = this.total_store_value.reduce((a, b) => a + b, 0);
        return sum;
    },
    // total_sum_value_self() {
    //   const sum = this.total_store_value.reduce((a, b) => a + b, 0);
    //   return sum;
    // },
    // total_sum_value_supervisor() {
    //   const sum = this.final_total_sum_supervisors.reduce((a, b) => a + b, 0);
    //   return sum;
    // },
    mos_monthwise_total(index,mos_data) {
      // console.log(mos_data);
      let mos_mark = 0;
      let total_mos_mark =
        mos_mark +
        mos_data.january +
        mos_data.february +
        mos_data.march +
        mos_data.april +
        mos_data.may +
        mos_data.june +
        mos_data.july +
        mos_data.august +
        mos_data.september +
        mos_data.october +
        mos_data.november +
        mos_data.december;
        this.mos_total_mark = total_mos_mark;
        this.final_total_sum_value_self[index] = parseInt(total_mos_mark);
        return total_mos_mark;
    },
     _total_sum_value_self() {
      const sum = this.final_total_sum_value_self.reduce((a, b) => a + b, 0);
      return sum;
    },
    TotalSupervisorValue(event, value, index) {
        let total = 0;
        total += value;
        this.final_total_sum_supervisors[index] = parseInt(total);
        return total;
    },
    _total_sum_value_supervisor() {
      const sum = this.final_total_sum_supervisors.reduce((a, b) => a + b, 0);
      return sum;
    },
    getList() {
      let uri = URL.baseUrl(
        "employees/performance_evaluation/" + this.$route.params.employeeId
      );
      console.log(uri);
      axios
        .get(uri)
        .then((data) => {
          this.items = data.data.data.mos_data;
          console.log(this.items);
          this.items1 = data.data.data.mos_data1;
          this.items2 = data.data.data.mos_data2;
          this.employee_datas = data.data.data.employee_data;
          this.form_data.employee_primary_id = this.employee_datas.employee_id;
          this.form_data.employee_id = this.$route.params.employeeId;
          this.supervisor_designation = data.data.data.supervisor_designation;
        })
        .catch((error) => {
          this.page_loading = true;
          this.showToster({ status: 0, message: "opps! something went wrong" });
        });
    },
    rowVisible(index, item, type) {
      // console.log(this.items);
      let crount = 0;
      this.items.filter((row) => {
        if (type == "kra") {
          if (row.kra_id === item.kra_id) {
            crount += 1;
          }
        } else if (type == "kpi") {
          if (row.kpi_id === item.kpi_id) {
            crount += 1;
          }
        }
      });
      return crount;
    },
    onSelectEmployee(option){
      this.form_data.employee_id = option.id;
    },
    resetModal() {},
    supervisors_status(status) {
        console.log(status);
      if (status == 1) {
        this.form_data.supervisors_rec_status = 1;
        this.form_data.extension = false;
        this.form_data.termination = false;
      } else if (status == 2) {
        this.form_data.supervisors_rec_status = 2;
        this.form_data.confirmation = false;
        this.form_data.termination = false;
      } else if (status == 3) {
        this.form_data.supervisors_rec_status = 3;
        this.form_data.confirmation = 0;
        this.form_data.extension = 0;
      }
    },
    hr_status(status) {
        console.log(status);
      if (status == 1) {
        this.form_data.hr_rec_status = 1;
        this.form_data.extension = false;
        this.form_data.termination = false;
      } else if (status == 2) {
        this.form_data.hr_rec_status = 2;
        this.form_data.confirmation = false;
        this.form_data.termination = false;
      } else if (status == 3) {
        this.form_data.hr_rec_status = 3;
        this.form_data.confirmation = 0;
        this.form_data.extension = 0;
      }
    },
    btnNext(val) {
        var urla =URL.baseUrl('add/performance_evaluation');
        let itemval ='';
        if(this.form_data){
            itemval= this.form_data;
            this.form_data.val = val;
            this.itemval.push({
                id: 'step',
                val:val,
            });
        }else{
            this.items.push({
                id: 'step',
                val:val,
            });
            itemval= this.items;
        }
        let employee_id = this.$route.params.employeeId;
        axios.post(urla, itemval)
                .then(res => {
                    console.log(res);
                    if(res){
                        var msg = 'Successfully updated.';
                        this.showToster({ status: 1, message: msg });
                    }
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                    var msg = 'opps! something went wrong';
                    this.showToster({ status: 0, message: msg });
                });
        $(".nav-pills .active").parent().next("li").find("a").trigger("click");
    },
    btnPrevious() {
        $(".nav-pills .active").parent().prev("li").find("a").trigger("click");
    },
  },
};
</script>
<style>
#pills-tab.nav-pills .nav-link.active,
.nav-pills .show > .nav-link {
  color: #06090c;
  background-color: #fec23c;
  border-radius: 0px;
}
#pills-tab.nav-pills .nav-link:not(.active):hover {
  color: #06090c;
  background-color: #f9e4c2;
  border-radius: 0px;
}
#btnPrevious .btn-primary {
  color: #06090c;
  background-color: #fec23c;
  border-color: #fec23c;
  box-shadow: none;
}
#btnNext .btn-primary {
  color: #06090c;
  background-color: #fec23c;
  border-color: #fec23c;
  box-shadow: none;
}
.probation_performance_header {
  padding: 0px;
  color: black;
  font-size: 16px;
  font-weight: 700;
  font-style: normal;
  text-decoration: none;
  font-family: "Franklin Gothic Book", sans-serif;
  text-align: center;
  vertical-align: middle;
  border: none;
  border-right: 1pt solid black;
  border-bottom: none;
  border-left: 1pt solid windowtext;
  background: #d9d9d9;
  height: 16.2pt;
  width: 100% !important;
}
.probation_header_subtitle {
  padding: 0px;
  color: black;
  font-size: 13px;
  font-weight: 400;
  font-style: normal;
  text-decoration: none;
  font-family: "Franklin Gothic Book", sans-serif;
  text-align: center;
  vertical-align: middle;
  border: none;
  border-top: none;
  border-right: 1pt solid black;
  border-bottom: none;
  border-left: 1pt solid windowtext;
  background: #d9d9d9;
  height: 15.6pt;
}
.white_text_design {
  padding: 0px;
  color: white;
  font-size: 14px;
  font-weight: 700;
  font-style: normal;
  text-decoration: none;
  font-family: "Franklin Gothic Book", sans-serif;
  text-align: center;
  vertical-align: top;
  border: none;
  border-top: 1pt solid windowtext;
  border-right: 0.5pt solid windowtext;
  border-bottom: none;
  border-left: none;
  background: #6f6e6e;
  border-left: 1pt solid windowtext;
  border-bottom: 0.5pt solid windowtext;
}
.white_box_design {
  padding: 0px;
  color: black;
  font-size: 14px;
  font-weight: 700;
  font-style: normal;
  text-decoration: none;
  font-family: "Franklin Gothic Book", sans-serif;
  text-align: general;
  vertical-align: top;
  border: none;
  border-top: 0.5pt solid windowtext;
  border-right: none;
  border-bottom: none;
  border-left: 0.5pt solid windowtext;
  background: white;
  border-right: 1px solid #000;
}
.kra_kpi_herader {
  text-align: center;
  border: 2px solid #000;
  border-right: 1px solid #000;
  color: black;
  font-size: 15px;
  font-weight: 700;
  font-family: "Franklin Gothic Book", sans-serif;
}
.kra_kpi_sub_herader {
  text-align: center;
  border: 2px solid #000;
  border-right: 1px solid #000;
  color: black;
  font-size: 14px;
  font-weight: 700;
  font-family: "Franklin Gothic Book", sans-serif;
}
.black_text_design {
  padding: 0px;
  color: black;
  font-size: 14px;
  font-weight: 700;
  font-style: normal;
  text-decoration: none;
  font-family: "Franklin Gothic Book", sans-serif;
  text-align: center;
  vertical-align: top;
  border: none;
  border-top: 1pt solid windowtext;
  border-right: 0.5pt solid windowtext;
  border-bottom: none;
  border-left: none;
  border-left: 1pt solid windowtext;
  border-bottom: 0.5pt solid windowtext;
}
</style>