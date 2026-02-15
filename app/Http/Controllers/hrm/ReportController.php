<?php

namespace App\Http\Controllers\hrm;

use App\Supports\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Model\UsersPersonModel;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\Section;
use App\Model\SubSection;
use App\Model\EmployeeGroup;
use App\Model\Department;
use App\Model\Designation;
use App\Model\JobGrade;
use App\Model\SubUnit;
use App\Model\WorkLocation;
use App\Model\EmployeePersonalInfo;
// use App\Model\EmployeeAdressDetail;
// use App\Model\EmployeeIdentificationSupporting;
use App\Model\EmployeeEducationalQualification;
// use App\Model\EducationalQualificationList;
// use App\Model\EmployeeReference;
// use App\Model\EmployeeProfessionalQualification;
// use App\Model\EmployeeEmploymentHistory;
// use App\Model\EmployeeFamilyDetail;
// use App\Model\EmployeeTrainingRecord;
// use App\Model\EmployeeProfessionalMembership;
// use App\Model\EmployeeBankAccountDetail;
// use App\Model\EmployeeEmergencyContact;
use App\Model\LeaveSetup;
use App\Model\LeaveType;
use App\Model\EmployeeApproval;
use App\Model\OfficeTimeSetup;
use App\Model\AttendanceSetup;
use App\Model\Attendance;
// use App\Model\HolidaySetup;
use App\Model\DistrictModel;
use App\Model\UnitModel;
use App\Model\LeaveApplication;
// use App\Model\LeaveAdjustment;
use DateTime;
// use permission;
// use Cache;
use Auth;
use DB;
use PDF;
use Mail;
use Session;
use DatePeriod;
use DateInterval;
use Carbon\CarbonPeriod;

// use Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $project_id = Auth::guard('user')->user()->project_id;
        $branch_id = Auth::guard('user')->user()->branch_id;
        $data['paginate_data'] = Employee::valid()->project()
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('sub_sections', 'sub_sections.id', '=', 'employees.employee_section')
            ->leftJoin('employee_groups', 'employee_groups.id', '=', 'employees.employee_section')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->select(
                'employees.*',
                'company_sbus.sbu_name',
                'sections.section_name',
                'sub_sections.sub_section_name',
                'employee_groups.employee_group_name',
                'departments.department_name',
                'designations.designation_name',
                'sub_units.sub_unit_name',
                'work_locations.work_location_name'
            )
            ->when($search_key, function ($query, $search_key) {
                $query->where(function ($query2) use ($search_key) {
                    $query2->where('employees.employee_fullname', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('employees.employee_mobile', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('employees.employee_joining_date', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('employees.employee_id_no', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('company_sbus.sbu_name', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('departments.department_name', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('designations.designation_name', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('sub_units.sub_unit_name', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('work_locations.work_location_name', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('sections.section_name', 'LIKE', '%' . $search_key . '%');
                });
                return $query;
            })->where('employees.project_id', $project_id)->orderBy($sort, $order)->paginate($paginate_num);

        $company_sbu_data = CompanySbu::valid()->project()->where('sbu_status', '=', 1)->get();
        $data['company_count'] = $company_sbu_data->count();
        $department_data = Department::valid()->project()->where('department_status', '=', 1)->get();
        $data['department_count'] = $department_data->count();
        $designation_data = Designation::valid()->project()->where('designation_status', '=', 1)->get();
        $data['designation_count'] = $designation_data->count();
        $employee_data = Employee::valid()->project()->where('valid', '=', 1)->get();
        $data['employee_count'] = $employee_data->count();
        return response()->json($data);
    }

    public function find_report()
    {
        // $employee_list = new Employee();
        // $employee_ids = $employee_list->Employee_id();
        // $employee_id = $employee_ids['employee_id'];
        $employee_ids = Session::get('employee_ids');
        // $employee_id = $employee_ids['employee_id'];

        $data['AllcompanySbuData'] = Session::get('Allcompany_sbu_data');
        $data['company_sbu_data'] = Session::get('company_sbu_data');
        $data['AllsectionData'] = Session::get('Allsection_data');
        $data['section_data'] = Session::get('section_data');
        $data['AllsubSectionData'] = Session::get('Allsub_section_data');
        $data['sub_section_data'] = Session::get('sub_section_data');
        $data['AllsubUnitData'] = Session::get('Allsub_unit_data');
        $data['sub_unit_data'] = Session::get('sub_unit_data');
        $data['AllunitData'] = Session::get('Allunit_data');
        $data['unit_data'] = Session::get('unit_data');
        $data['AllworkLocationData'] = Session::get('Allwork_location_data');
        $data['work_location_data'] = Session::get('work_location_data');
        $data['AlldepartmentData'] = Session::get('Alldepartment_data');
        $data['department_data'] = Session::get('department_data');


        // $data['AllcompanySbuData'] = $employee_list->report_filter_data()['Allcompany_sbu_data'];
        // $data['company_sbu_data'] = $employee_list->report_filter_data()['company_sbu_data'];
        // $data['AllsectionData'] = $employee_list->report_filter_data()['Allsection_data'];
        // $data['section_data'] = $employee_list->report_filter_data()['section_data'];
        // $data['AllsubSectionData'] = $employee_list->report_filter_data()['Allsub_section_data'];
        // $data['sub_section_data'] = $employee_list->report_filter_data()['sub_section_data'];
        // $data['AllsubUnitData'] = $employee_list->report_filter_data()['Allsub_unit_data'];
        // $data['sub_unit_data'] = $employee_list->report_filter_data()['sub_unit_data'];
        // $data['AllunitData'] = $employee_list->report_filter_data()['Allunit_data'];
        // $data['unit_data'] = $employee_list->report_filter_data()['unit_data'];
        // $data['AllworkLocationData'] = $employee_list->report_filter_data()['Allwork_location_data'];
        // $data['work_location_data'] = $employee_list->report_filter_data()['work_location_data'];
        // $data['AlldepartmentData'] = $employee_list->report_filter_data()['Alldepartment_data'];
        // $data['department_data'] = $employee_list->report_filter_data()['department_data'];
        // $employee_data =$employee_list->report_filter_data()['employee_data'];

        $officeTime = OfficeTimeSetup::valid()->project()->whereIn('type', ['2', '3'])->where('office_time_status', 1)->orderBy('priority', 'ASC')->get();
        $data['officeTime'] = array();
        foreach ($officeTime as $value) {
            array_push($data['officeTime'], ['id' => $value['id'], 'text' => $value['title'] . " [ " . date('h:i A', strtotime($value['office_start_time'])) . " - " . date('h:i A', strtotime($value['office_end_time'])) . " ] "]);
        }

        // $data['company_sbu_data']=array();
        // $data['section_data']=array();
        // $data['sub_section_data']=array();
        // $data['sub_unit_data']=array();
        // $data['work_location_data']=array();
        // $data['department_data']=array();
        $data['designation_data'] = array();
        $data['jobgrade_data'] = array();
        $data['employee_data'] = array();
        $data['employee_data_approval'] = array();
        $data['employee_group_data'] = array();


        // $company_sbu_data=CompanySbu::valid()->project()->whereIn('id',$employee_ids['sub'])->orderBy('priority', 'ASC')->get();
        // $section_data=Section::valid()->project()->whereIn('id',$employee_ids['section'])->orderBy('priority', 'ASC')->get();
        // $sub_section_data=SubSection::valid()->project()->whereIn('id',$employee_ids['subsection'])->orderBy('priority', 'ASC')->get();
        // $department_data=Department::valid()->project()->whereIn('id',$employee_ids['department'])->orderBy('priority', 'ASC')->get();

        $designation_data = Designation::valid()
            ->project()->whereIn('id', $employee_ids['designation'])
            ->orderBy('priority', 'ASC')
            ->get();

        $jobgrade_data = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();

        $employee_data_approval = Employee::valid()->project()
            ->select('employees.*', 'designations.designation_name')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->whereIn('employee_sbu', $employee_ids['sub'])
            ->whereIn('employee_department', $employee_ids['department'])->get();

        $employee_data = Employee::valid()->project()
            ->select('employees.*', 'designations.designation_name')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->get()->keyBy('employee_id_no')
            ->all();

        $data['leave_type_data'] = array();
        $leave_type_data = LeaveType::valid()->project()->get();

        foreach ($leave_type_data as $value) {
            array_push($data['leave_type_data'], ['id' => $value['id'], 'text' => $value['leave_type_name']]);
        }

        // $employee_data=Employee::valid()->project()
        //               ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
        //               ->select(
        //                 'employees.*',
        //                 'designations.designation_name'
        //               )
        //               ->whereIn('employee_sbu',$employee_ids['sub'])->whereIn('employee_department',$employee_ids['department'])
        //               ->orderBy('priority', 'ASC')->get();
        // $sub_unit_data=SubUnit::valid()->project()->whereIn('id',$employee_ids['subunit'])->orderBy('priority', 'ASC')->get();
        // $work_location_data=WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get();

        $employee_group_data = EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get();

        // array_push($data['company_sbu_data'],['id'=>'','text'=>'All Select']);
        // foreach ($company_sbu_data as $value) {
        //   array_push($data['company_sbu_data'],['id'=>$value['id'],'text'=>$value['sbu_name']]);
        // }
        //   array_push($data['section_data'],['id'=>'','text'=>'All Select']);
        // foreach ($section_data as $value) {
        //   array_push($data['section_data'],['id'=>$value['id'],'text'=>$value['section_name']]);
        // }
        //  array_push($data['sub_section_data'],['id'=>'','text'=>'All Select']);
        // foreach ($sub_section_data as $value) {
        //   array_push($data['sub_section_data'],['id'=>$value['id'],'text'=>$value['sub_section_name']]);
        // }
        array_push($data['employee_group_data'], ['id' => '', 'text' => 'All Select']);

        foreach ($employee_group_data as $value) {
            array_push($data['employee_group_data'], ['id' => $value['id'], 'text' => $value['employee_group_name']]);
        }

        //  array_push($data['department_data'],['id'=>'','text'=>'All Select']);
        // foreach ($department_data as $value) {
        //   array_push($data['department_data'],['id'=>$value['id'],'text'=>$value['department_name']]);
        // }
        array_push($data['designation_data'], ['id' => '', 'text' => 'All Select']);

        foreach ($designation_data as $value) {
            array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
        }

        array_push($data['jobgrade_data'], ['id' => '', 'text' => 'All Select']);

        foreach ($jobgrade_data as $value) {
            array_push($data['jobgrade_data'], ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        }

        array_push($data['employee_data'], ['id' => '', 'text' => 'All Select']);

        foreach ($employee_data as $value) {
            array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . ':' . $value['employee_fullname'] . '-' . $value['designation_name']]);
        }

        array_push($data['employee_data_approval'], ['id' => '', 'text' => 'All Select']);

        foreach ($employee_data_approval as $value) {
            // return response($value);
            // array_push($data['employee_data_approval'],['id'=>$value['id'],'text'=>$value['employee_id_no'].' : '.$value['employee_fullname']]);
            array_push($data['employee_data_approval'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . ':' . $value['employee_fullname'] . '-' . $value['designation_name']]);
        }

        // array_push($data['sub_unit_data'],['id'=>'','text'=>'All Select']);
        // foreach ($sub_unit_data as $value) {
        //   array_push($data['sub_unit_data'],['id'=>$value['id'],'text'=>$value['sub_unit_name']]);
        // }
        // array_push($data['work_location_data'],['id'=>'','text'=>'All Select']);
        // foreach ($work_location_data as $value) {
        //   array_push($data['work_location_data'],['id'=>$value['id'],'text'=>$value['work_location_name']]);
        // }

        $data['AttStatus'] = [];
        array_push($data['AttStatus'], ['id' => '', 'text' => 'All']);
        array_push($data['AttStatus'], ['id' => '1', 'text' => 'Present']);
        array_push($data['AttStatus'], ['id' => '2', 'text' => 'Late']);
        array_push($data['AttStatus'], ['id' => '6', 'text' => 'Leave']);
        array_push($data['AttStatus'], ['id' => '3', 'text' => 'Absent']);

        $data['emplyeeCategory'] = [];
        array_push($data['emplyeeCategory'], ['id' => '', 'text' => 'All']);
        array_push($data['emplyeeCategory'], ['id' => '1', 'text' => 'Management']);
        array_push($data['emplyeeCategory'], ['id' => '2', 'text' => 'Non-Management']);

        $data['employeeType'] = [];
        array_push($data['employeeType'], ['id' => '', 'text' => 'All']);
        array_push($data['employeeType'], ['id' => '1', 'text' => 'Permanent']);
        array_push($data['employeeType'], ['id' => '2', 'text' => 'Probationary']);
        array_push($data['employeeType'], ['id' => '3', 'text' => 'Cotractual']);
        array_push($data['employeeType'], ['id' => '6', 'text' => 'Casual']);
        array_push($data['employeeType'], ['id' => '4', 'text' => 'Temporary']);
        array_push($data['employeeType'], ['id' => '5', 'text' => 'Intern']);

        $data['attendanceColumn'] = array();
        array_push($data['attendanceColumn'], ['id' => 'section_name', 'text' => 'Section']);
        array_push($data['attendanceColumn'], ['id' => 'sub_section_name', 'text' => 'Sub Section']);
        array_push($data['attendanceColumn'], ['id' => 'age', 'text' => 'Age']);
        array_push($data['attendanceColumn'], ['id' => 'adob', 'text' => 'DOB Actual']);
        array_push($data['attendanceColumn'], ['id' => 'cdob', 'text' => 'DOB Certificate']);
        // array_push($data['attendanceColumn'],['id'=>'salary','text'=>'Salary']);
        array_push($data['attendanceColumn'], ['id' => 'permanent_district', 'text' => 'District']);
        array_push($data['attendanceColumn'], ['id' => 'employee_marital_status', 'text' => 'Marital Status']);
        array_push($data['attendanceColumn'], ['id' => 'employee_blood_group', 'text' => 'Blood Group']);
        array_push($data['attendanceColumn'], ['id' => 'employee_children_no', 'text' => 'Kids']);
        array_push($data['attendanceColumn'], ['id' => 'employee_work_location', 'text' => 'Work Location']);
        array_push($data['attendanceColumn'], ['id' => 'employee_job_grade', 'text' => 'Grade']);
        array_push($data['attendanceColumn'], ['id' => 'service_length', 'text' => 'Service Length']);
        array_push($data['attendanceColumn'], ['id' => 'emplyee_category_mgt_non_mgt', 'text' => 'Employee Category']);
        array_push($data['attendanceColumn'], ['id' => 'employee_type', 'text' => 'Employment Type']);
        array_push($data['attendanceColumn'], ['id' => 'employee_group', 'text' => 'Employee Group']);
        array_push($data['attendanceColumn'], ['id' => 'employee_gender', 'text' => 'Gender']);
        array_push($data['attendanceColumn'], ['id' => 'employee_reporting_to', 'text' => 'Reporting to/Superior']);
        array_push($data['attendanceColumn'], ['id' => 'educational_qualification', 'text' => 'Educational Qualification']);

        // array_push($data['attendanceColumn'],['id'=>'employee_work_location','text'=>'Work Location']);
        // array_push($data['attendanceColumn'],['id'=>'employee_children_no','text'=>'Kids']);

        $data['district_data'] = array();
        $district_data = DistrictModel::orderBy('name', 'ASC')->get();
        array_push($data['district_data'], ['id' => '', 'text' => 'All Select']);

        foreach ($district_data as $value) {
            array_push($data['district_data'], ['id' => $value['id'], 'text' => $value['name'] . ' - ' . $value['bn_name']]);
        }

        $data['approval_infos'] = EmployeeApproval::valid()->project()->get();
        // $data['approval_infos']=EmployeeApproval::valid()->project()->where('ea_employee_id',$id)->get();
        $data['from_date'] = date('Y-m-d');
        $data['to_date'] = date('Y-m-d');

        return response($data);
    }


    public function column_real_name($columnArray)
    {
        $column_data = array();
        foreach ($columnArray as $key => $value) {
            // echo "<pre>"; print_r($columnArray); die();
            if ($value == 'employee_id_no') {
                $column_data[] = 'ID';
            }
            if ($value == 'employee_full_name') {
                $column_data[] = 'Name';
            }

            if ($value == 'sbu_name') {
                $column_data[] = 'Company';
            }
            if ($value == 'department_name') {
                $column_data[] = 'Department';
            }
            if ($value == 'designation_name') {
                $column_data[] = 'Designation';
            }
            if ($value == 'section_name') {
                $column_data[] = 'Section';
            }
            if ($value == 'sub_section_name') {
                $column_data[] = 'Sub Section';
            }
            if ($value == 'shift_time') {
                $column_data[] = 'Shift Time';
            }
            if ($value == 'in_time') {
                $column_data[] = 'In Time';
            }
            if ($value == 'out_time') {
                $column_data[] = 'Out Time';
            }
            if ($value == 'late') {
                $column_data[] = 'Late By';
            }
            if ($value == 'status') {
                $column_data[] = 'Status';
            }
            if ($value == 'remarks') {
                $column_data[] = 'Remarks';
            }

            if ($value == 'employee_joining_date') {
                $column_data[] = 'Date of Joining';
            }
            if ($value == 'employee_mobile') {
                $column_data[] = 'Mobile Number';
            }
            if ($value == 'employee_marital_status') {
                $column_data[] = 'Marital Status';
            }
            if ($value == 'employee_blood_group') {
                $column_data[] = 'Blood Group';
            }
            if ($value == 'permanent_district') {
                $column_data[] = 'Home District';
            }
            if ($value == 'employee_children_no') {
                $column_data[] = 'Kids';
            }
            if ($value == 'age') {
                $column_data[] = 'Age';
            }
            if ($value == 'salary') {
                $column_data[] = 'Salary';
            }
            if ($value == 'employee_work_location') {
                $column_data[] = 'Work Location';
            }
            if ($value == 'employee_status') {
                $column_data[] = 'Status';
            }
            if ($value == 'employee_job_grade') {
                $column_data[] = 'Job Grade';
            }
            if ($value == 'service_length') {
                $column_data[] = 'Service Length';
            }

            if ($value == 'emplyee_category_mgt_non_mgt') {
                $column_data[] = 'Employee Category';
            }
            if ($value == 'employee_type') {
                $column_data[] = 'Employment Type';
            }
            if ($value == 'employee_group') {
                $column_data[] = 'Employee Group';
            }
            if ($value == 'employee_group') {
                $column_data[] = 'Employee Group';
            }
            if ($value == 'employee_reporting_to') {
                $column_data[] = "Reporting to/Superior";
            }
            if ($value == 'educational_qualification') {
                $column_data[] = 'Educational Qualification';
            }
            if ($value == 'adob') {
                $column_data[] = 'DOB Actual';
            }
            if ($value == 'cdob') {
                $column_data[] = 'DOB Certificate';
            }


            //leave report
            if ($value == 'request_date') {
                $column_data[] = 'Req. Date';
            }
            if ($value == 'request_time') {
                $column_data[] = 'Req. Time';
            }
            if ($value == 'approval_date') {
                $column_data[] = 'Appr. Date';
            }
            if ($value == 'approved_time') {
                $column_data[] = 'Appr. Time';
            }
            if ($value == 'approved_by') {
                $column_data[] = 'Appr. by';
            }
            if ($value == 'leave_type') {
                $column_data[] = 'L. Type';
            }
            if ($value == 'from_date') {
                $column_data[] = 'From';
            }
            if ($value == 'to_date') {
                $column_data[] = 'To';
            }
            if ($value == 'leave_total_days') {
                $column_data[] = '#Days';
            }
            if ($value == 'leave_status') {
                $column_data[] = 'L. Status';
            }
            // if ($value == 'leave_balance') {
            //     $column_data[] = 'L. Balance';
            // }

        }

        return $column_data;
    }


    // public function search_report__(Request $Request){
    //   $from_date_formated = date("Y-m-d");
    //   // $from_date_formated = date("2020-09-16");
    //   $employee_info=Employee::select('employees.id','employees.employee_id_no','employees.employee_fullname as employee_full_name','employees.employee_sbu','employees.employee_section','employees.employee_department','employees.employee_designation','employees.employee_sub_unit','employees.employee_sub_unit')
    //   ->valid()
    //   ->where('employees.employee_status',1);
    //   $employee_info=$employee_info->get()->toArray();
    //   $employee_ids=collect($employee_info)->pluck('employee_id_no')->toArray();
    //   $employee_primary_ids=collect($employee_info)->pluck('id')->toArray();
    //   $in_data1= DB::table('attendance_log')
    //                 ->select(
    //                   DB::RAW('min(attendance_log.id) as in_id'),
    //                   'attendance_log.employee_id',
    //                   'TransactionDate',
    //                   'TransactionTime as in_time',
    //                 )
    //                 ->whereIn('employee_id', $employee_ids)
    //                 ->whereDate('TransactionDate', '=', $from_date_formated)
    //                 ->groupBy(DB::RAW('employee_id'))
    //                 ->get()->toArray();
    //   $out_data1 = DB::select("SELECT employee_id,TransactionDate,TransactionTime as out_time FROM attendance_log WHERE id IN (SELECT MAX(id) FROM attendance_log WHERE TransactionDate = '". $from_date_formated."' GROUP BY employee_id ) ORDER BY id ASC");

    //   $office_time = AttendanceSetup::valid()
    //                  ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
    //                  ->select(
    //                   'attendance_setups.employee_id',
    //                   'office_time_setups.office_start_time',
    //                   'office_time_setups.office_end_time'
    //                 )
    //                 ->whereIn('attendance_setups.employee_id', $employee_primary_ids)
    //                 ->groupBy(DB::RAW('attendance_setups.employee_id'))
    //                 ->get()->toArray();
    //   $holiday_data = HolidaySetup::valid()
    //                 ->whereRaw('"'.$from_date_formated.'" between `holiday_start_date` and `holiday_end_date`')
    //                 ->first();
    //   $all_data =$employee_info;
    //   if (!empty($all_data)) {
    //   $attendance_data = array();
    //     foreach ($all_data as $key => $value) {
    //       $attendance_data['employee_id']= isset($value['id'])?$value['id']:'';
    //       $attendance_data['employee_card_no']= isset($value['employee_id_no'])?$value['employee_id_no']:'';

    //       $in_data=collect($in_data1)->where('employee_id',$value['employee_id_no'])->first();
    //       $out_data=collect($out_data1)->where('employee_id',$value['employee_id_no'])->first();
    //       $office_time_data=collect($office_time)->where('employee_id',$value['id'])->first();

    //       $start_time = isset($office_time_data)?$office_time_data['office_start_time']:'00:00:00';
    //       $end_time = isset($office_time_data)?$office_time_data['office_end_time']:'00:00:00';

    //          if (empty($in_data) && empty($out_data)) {
    //             if(date('w', strtotime($from_date_formated)) == 5 || date('w', strtotime($from_date_formated)) == 6) {
    //               $pstatus = '4';
    //               $remarks = 'Weekend';
    //             }elseif(!empty($holiday_data)){
    //               $pstatus = '5';
    //               $remarks = 'Holiday';
    //             }
    //             else {
    //               $pstatus = '3';
    //               $remarks = 'Absent';
    //             }
    //             // echo "<pre>"; print_r($remarks); die();
    //             $attendance_data['pdate'] =$from_date_formated;
    //             $attendance_data['intime'] ='00:00:00';
    //             $attendance_data['outime'] ='00:00:00';
    //             $attendance_data['latetime'] ='00:00:00';
    //             $attendance_data['start_time'] = $start_time;
    //             $attendance_data['end_time'] = $end_time;
    //             $attendance_data['pstatus'] = $pstatus;
    //             $attendance_data['status'] ='1';
    //             $attendance_data['remarks'] = $remarks;
    //             $attendance_data['shift_time'] =$start_time.'-'.$end_time;
    //          }else{
    //             $intime = date("G:i:s", strtotime($in_data->in_time));
    //             $outime = date("G:i:s", strtotime($out_data->out_time));
    //             if ($start_time!='00:00:00' && $intime>$start_time) {
    //               $time1 = new DateTime($intime);
    //               $time2 = new DateTime($start_time);
    //               $interval = $time1->diff($time2);
    //               $latetime = $interval->format('%H:%I:%S');
    //             }else{
    //               $latetime = '00:00:00';
    //             }

    //             $attendance_data['pdate'] =$from_date_formated;
    //             $attendance_data['intime'] = $intime;
    //             if ($in_data->in_time==$out_data->out_time) {
    //               $attendance_data['outime'] ='00:00:00';
    //             }else{
    //               $attendance_data['outime'] = $outime;
    //             }
    //             $attendance_data['latetime'] = $latetime;
    //             $attendance_data['start_time'] = $start_time;
    //             $attendance_data['end_time'] = $end_time;
    //             if ($latetime>'00:00:00') {
    //               $attendance_data['pstatus'] ='2';
    //               $attendance_data['remarks'] ='Late';
    //             }else{
    //               $attendance_data['pstatus'] ='1';
    //               $attendance_data['remarks'] ='Present';
    //             }
    //             $attendance_data['status'] ='1';
    //             $attendance_data['shift_time'] = $start_time.'-'.$end_time;
    //          }
    //         // $attendance_check = DB::table('attendance')->select('employee_id','employee_card_no','pdate')->where('pdate',$from_date_formated)->first();
    //         // echo "<pre>"; print_r($attendance_check);  echo "<pre>";
    //         // if (!empty($attendance_check)) {
    //         //   DB::table('attendance')->update($attendance_data);
    //         // }else{
    //           DB::table('attendance')->insert($attendance_data);
    //         // }
    //       }/*loop end*/
    //       // echo "<pre>"; print_r($columnArray); die();
    //    }
    //    return "Attendance data updated!";
    // }

    /* office time query needed */
    /* employee wise attendance log query */
    /* employee wise leave query */
    /* holiday query && weekend */
    /* Manual attendance query */

    public function search_report(Request $Request)
    {



        $from_date = isset(request()->from_date) ? request()->from_date : '';
        $to_date = isset(request()->to_date) ? request()->to_date : '';
        $strDate1 = substr($from_date, 4, 11);
        $strDate2 = substr($to_date, 4, 11);

        $search_option['from_date_formated'] = $from_date_formated = date('Y-m-d', strtotime($strDate1));
        $search_option['to_date_formated'] = $to_date_formated = date('Y-m-d', strtotime($strDate2));
        $search_option['checkedattcolsadd'] = $checkedattcolsadd = request()->checkedattcolsadd;
        $search_option['report_type'] = $report_type = request()->report_type;
        $search_option['att_report_type'] = $att_report_type = request()->att_report_type;

        $search_option['employee_sbu'] = $employee_sbu = $Request->employee_sbu;
        $search_option['employee_work_location'] = $employee_work_location = collect($request->work_location_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_department'] = $employee_department = request()->employee_department;
        $search_option['employee_designation'] = $employee_designation = request()->employee_designation;
        $search_option['employee_id'] = $employee_id = request()->employee_id;
        $date_print['from_date_formated'] = $from_date_formated;

        $search_option['employee_work_location'] = $employee_work_location = collect($request->AttStatus_value)->where('id', '!=', '')->pluck('id')->toArray();

        $search_option['emplyee_category_mgt_non_mgt'] = $emplyee_category_mgt_non_mgt = collect($request->employee_Category_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_type'] = $employee_type = collect($request->employee_type_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_group'] = $employee_group = collect($request->employee_group_value)->where('id', '!=', '')->pluck('id')->toArray();
        // $search_option['reporting_to'] = $reporting_to = collect($request->reporting_name_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['reporting_to'] = $reporting_to = $request->employee_reporting_to;




        // if ($report_type==1 && $att_report_type==1 && !empty($checkedattcolsadd)) {
        // return $this->find_daily_attendance($report_type,$att_report_type, $employee_sbu, $from_date_formated,$to_date_formated,$checkedattcolsadd);
        // }
        if ($report_type == 1 && $att_report_type == 1) {
            return $this->find_daily_attendance($report_type, $att_report_type, $employee_sbu, $from_date_formated, $to_date_formated, $checkedattcolsadd, $search_option);
            // return $this->find_daily_attendance_new($search_option);
        } elseif ($report_type == 1 && $att_report_type == 3 && !empty($employee_id)) {
            $searchOption = $this->find_individual_attendance($search_option);
            // return $this->reportDetails($searchOption);
            return response()->json($this->reportDetails($searchOption));
            // return $this->Newfind_individual_attendance($report_type,$att_report_type, $employee_sbu, $from_date_formated,$to_date_formated,$checkedattcolsadd,$search_option,$employee_id);
        } elseif ($report_type == 1 && $att_report_type == 2) {
            return $this->find_daily_summary($search_option);
        } elseif ($report_type == 1 && $att_report_type == 4) {
            return $this->find_periodic_attendance($search_option);
        } elseif ($report_type == 1 && $att_report_type == 5) {
            return $this->find_periodic_detail_attendance($search_option);
        } elseif ($report_type == 2) {
            return $this->find_employee_detail($search_option, $checkedattcolsadd);
        }
    }


    public function empploy_report(Request $request)
    {
        // dd($request);
        // echo "s";

        // echo "<pre>"; print_r([$request->report_type,$request->turnover_view_type]);
        // exit();
        // return request()->employee_id;
        // $employee_sbu=collect($request['sbu_name_value'])->pluck('id')->toArray();
        // $employee_department=collect($request->department_name_value)->pluck('id')->toArray();
        // $employee_designation=collect($request->designation_name_value)->pluck('id')->toArray();
        // $employee_id=collect($request->designation_name_value)->pluck('id')->toArray();
        $from_date = isset(request()->from_date) ? request()->from_date : '';
        $to_date = isset(request()->to_date) ? request()->to_date : '';
        $strDate1 = substr($from_date, 4, 11);
        $strDate2 = substr($to_date, 4, 11);
        $search_option['from_date_formated'] = $from_date_formated = date('Y-m-d', strtotime($strDate1));
        $search_option['to_date_formated'] = $to_date_formated = date('Y-m-d', strtotime($strDate2));
        $search_option['employee_id'] = $employee_id = collect($request->designation_name_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_ids'] = $employee_ids = request()->employee_id;
        // request()->employee_id;
        $date_print['from_date_formated'] = $from_date_formated;
        $search_option['checkedattcolsadd'] = $checkedattcolsadd = $request->checkedattcolsadd;
        $search_option['report_type'] = $report_type = $request->report_type;
        $search_option['att_report_type'] = $att_report_type = $request->att_report_type;
        $search_option['employee_sbu'] = $employee_sbu = collect($request['sbu_name_value'])->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_sbus'] = $employee_sbus = $request->employee_sbu;
        // $request->employee_sbu;
        $search_option['employee_department'] = $employee_department = collect($request->department_name_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_departments'] = $employee_departments = $request->employee_department;
        // $request->employee_department;
        $search_option['employee_designation'] = $employee_designation = collect($request->designation_name_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_designations'] = $employee_designations = $request->employee_designation;
        // $request->employee_designation;
        $search_option['employee_section'] = $employee_section = collect($request->section_value)->where('id', '!=', '')->pluck('id')->toArray();
        // $request->employee_section;
        $search_option['employee_sub_section'] = $employee_sub_section = collect($request->sub_section_value)->where('id', '!=', '')->pluck('id')->toArray();
        // $request->employee_sub_section;
        $search_option['employee_work_location'] = $employee_work_location = collect($request->work_location_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_job_grade'] = $employee_job_grade = collect($request->jobgradeData_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['OfficeTime'] = $OfficeTime = collect($request->OfficeTime)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['sub_unit'] = $sub_unit = collect($request->sub_unit_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['unit'] = $unit = collect($request->unit_value)->where('id', '!=', '')->pluck('id')->toArray();
        // $request->jobgradeData_value;

        $search_option['service_length_from'] = $service_length_from = $request->service_length_from;
        $search_option['service_length_to'] = $service_length_to = $request->service_length_to;

        $search_option['age_from'] = $age_from = $request->age_from;
        $search_option['age_to'] = $age_to = $request->age_to;
        $search_option['salary_from'] = $salary_from = $request->salary_from;
        $search_option['salary_to'] = $salary_to = $request->salary_to;
        $search_option['leave_view_type'] = $leave_view_type = $request->leave_view_type;
        $search_option['permanent_district'] = $permanent_district = collect($request->district_value)->where('id', '!=', '')->pluck('id')->toArray();
        // $request->permanent_district;
        $search_option['employee_marital_status'] = $employee_marital_status = $request->employee_marital_status;
        $search_option['employee_gender'] = $employee_gender = $request->employee_gender;
        $search_option['employee_blood_group'] = $employee_blood_group = $request->employee_blood_group;
        $search_option['att_status'] = $att_status = collect($request['AttStatus_value'])->where('id', '!=', '')->pluck('id')->toArray();

        $search_option['emplyee_category_mgt_non_mgt'] = $emplyee_category_mgt_non_mgt = collect($request->employee_Category_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_type'] = $employee_type = collect($request->employee_type_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_group'] = $employee_group = collect($request->employee_group_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['reporting_to'] = $reporting_to = collect($request->reporting_name_value)->where('id', '!=', '')->pluck('id')->toArray();
        // $search_option['reporting_to'] = $reporting_to = $request->employee_reporting_to;
        $search_option['employee_status'] = $employee_status = $request->employee_status;
        $search_option['leave_view_type'] = $leave_view_type = $request->leave_view_type;
        $search_option['leave_type_info'] = collect($request->leave_type_info)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['leave_status'] = $request->leave_status;
        $search_option['sbu_wise_report_type'] = $request->sbu_wise_report_type;


        $search_option['turnover_view_type'] = $turnover_view_type = $request->turnover_view_type; // turnover
        $search_option['turnover_year'] = $turnover_year = $request->turnover_year; // turnover
        $search_option['turnover_month'] = $turnover_month = $request->turnover_month; // turnover
        // return $turnover_month;
        // echo "<pre>";
        // print_r(collect($request->AttStatus_value)->where('id','!=','')->pluck('id')->toArray());
        // exit();
        if ($report_type == 1 && $att_report_type == 1) {
            return $this->find_daily_attendance($report_type, $att_report_type, $employee_sbu, $from_date_formated, $to_date_formated, $checkedattcolsadd, $search_option);
        } elseif ($report_type == 1 && $att_report_type == 3 && !empty($employee_ids)) {
            return $this->find_individual_attendance($search_option);
        } elseif ($report_type == 1 && $att_report_type == 2) {
            return $this->find_daily_summary($search_option);
        } elseif ($report_type == 1 && $att_report_type == 4) {
            return $this->find_periodic_attendance($search_option);
        } elseif ($report_type == 1 && $att_report_type == 5) {
            return $this->find_periodic_detail_attendance($search_option);
        } elseif ($report_type == 1 && $att_report_type == 6) {
            return $this->find_attendance_late_report($search_option);
        } elseif ($report_type == 2) {
            return $this->employees_detail_reports($search_option, $checkedattcolsadd);
        } elseif ($report_type == 3) {
            return $this->sbu_wise_employee_find($search_option);
        } elseif ($report_type == 4) {
            return $this->joining_report($search_option);
        } elseif ($report_type == 7 && $turnover_view_type == 1) {
            return $this->yearly_turnover_report($search_option, $checkedattcolsadd);
        } elseif ($report_type == 7 && $turnover_view_type == 2) {
            return $this->monthly_turnover_report($search_option, $checkedattcolsadd);
        } elseif ($report_type == 6) {
            return $this->resing_report($search_option);
        } elseif ($report_type == 5 && $leave_view_type == 2) {
            return $this->leave_report($search_option, $checkedattcolsadd);
        } elseif ($report_type == 5 && $leave_view_type == 1) {
            return $this->summary_leave_report($search_option, $checkedattcolsadd);
        } else {
            echo "No Data Found";
        }
    }

    // public function leave_report($search_option, $checkedattcolsadd)
    // {
    //     if (!empty($checkedattcolsadd)) {
    //         $columnArray = $checkedattcolsadd;
    //     } else {
    //         $columnArray = [];
    //     }
    //     $employee_list = new Employee();
    //     $employee_ids = $employee_list->Employee_id();
    //     $employee_id = $employee_ids['employee_id'];
    //     if (!empty($search_option['employee_sbu'])) {
    //         $employeeSbu = $search_option['employee_sbu'];
    //     } else {
    //         $employeeSbu = $employee_ids['sub'];
    //     }
    //     $employeeDepartment = [];
    //     if (!empty($search_option['employee_department'])) {
    //         $employeeDepartment = $search_option['employee_department'];
    //     } else {
    //         $employeeDepartment = $employee_ids['department'];
    //     }
    //     if (count($columnArray) > 0) {
    //         $columNameArray = array("employee_id_no", "employee_full_name", "designation_name", "department_name", "section_name", "employee_work_location", "employee_joining_date", "service_length", "request_date", "request_time", "approval_date", "approved_time", "approved_by", "leave_type", "from_date", "to_date", "leave_total_days", "leave_status", "remarks");
    //         $column_data = $allcolumnArray = array_merge($columNameArray, $columnArray);
    //         $column_name_data = $this->column_real_name($allcolumnArray);
    //     } else {
    //         $column_data = $columNameArray = array("employee_id_no", "employee_full_name", "designation_name", "department_name", "section_name", "employee_work_location", "employee_joining_date", "service_length", "request_date", "request_time", "approval_date", "approved_time", "approved_by", "leave_type", "from_date", "to_date", "leave_total_days", "leave_status", "remarks");
    //         $column_name_data = $this->column_real_name($columNameArray);
    //     }
    //     $leave_from_date_check = $search_option['from_date_formated'];
    //     $leave_to_date_check = $search_option['to_date_formated'];
    //     $employee_info = Employee::valid()
    //         ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
    //         ->leftJoin('leave_applications', 'employees.id', '=', 'leave_applications.employee_id')
    //         ->leftJoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
    //         ->leftJoin('leave_approval', 'leave_approval.leave_apply_id', '=', 'leave_applications.id')
    //         ->join('employees as approval_info', 'approval_info.id', '=', 'leave_approval.leave_approve_by')
    //         ->select(
    //             'employees.id',
    //             'employees.employee_reporting_to',
    //             'employees.employee_id_no',
    //             'employees.employee_fullname as employee_full_name',
    //             'employees.employee_sbu',
    //             'employees.employee_section',
    //             'employees.employee_department',
    //             'employees.employee_designation',
    //             'employees.employee_sub_unit',
    //             'employees.employee_sub_unit',
    //             'employees.employee_joining_date',
    //             'employees.employee_mobile',
    //             'employees.employee_status',
    //             'employees.employee_work_location',
    //             'employees.employee_sub_section',
    //             'employees.employee_joining_date',
    //             'employees.employee_type',
    //             DB::raw('DATE_FORMAT(leave_applications.leave_apply_date,"%d-%b-%Y") AS request_date'),
    //             DB::raw('DATE_FORMAT(leave_applications.leave_from_date,"%d-%b-%Y") AS from_date'),
    //             DB::raw('DATE_FORMAT(leave_applications.leave_to_date,"%d-%b-%Y") AS to_date'),
    //             'leave_applications.leave_total_day as leave_total_days',
    //             'leave_types.leave_type_name as leave_type',
    //             'leave_applications.leave_reason as remarks',
    //             DB::raw('TIME(leave_applications.created_at) AS request_time'),
    //             DB::raw('TIME(leave_approval.updated_at) AS approved_time'),
    //             DB::raw('(CASE
    //             WHEN leave_applications.leave_apply_status = "1" THEN "Requested"
    //             WHEN leave_applications.leave_apply_status = "2" THEN "Approved"
    //             WHEN leave_applications.leave_apply_status = "3" THEN "Forwarded"
    //             WHEN leave_applications.leave_apply_status = "4" THEN "Rejected"
    //             WHEN leave_applications.leave_apply_status = "5" THEN "Rejected"
    //             ELSE ""
    //             END) AS leave_status'),
    //             'leave_approval.leave_approve_date as approval_date',
    //             'approval_info.employee_fullname as approved_by',
    //         )
    //         ->whereIn('employees.employee_sbu', $employeeSbu)
    //         ->where('employees.employee_department', '!=', 132)
    //         ->whereIn('employees.employee_department', $employeeDepartment)
    //         ->whereDate('leave_applications.leave_from_date', '>=', $leave_from_date_check)
    //         ->whereDate('leave_applications.leave_to_date', '<=', $leave_to_date_check)
    //     ;
    //     if (!empty($search_option['employee_ids'])) {
    //         $employee_info->where('employees.id', $search_option['employee_ids']);
    //     }
    //     if (!empty($search_option['leave_status'])) {
    //         $employee_info->where('leave_applications.leave_apply_status', $search_option['leave_status']);
    //     }
    //     if (!empty($search_option['leave_type_info'])) {
    //         $employee_info->whereIn('leave_types.id', $search_option['leave_type_info']);
    //     }
    //     if (!empty($search_option['employee_designation'])) {
    //         $employee_info->whereIn('employees.employee_designation', $search_option['employee_designation']);
    //     }
    //     // if (!empty($search_option['employee_status'])) {
    //     //     if ($search_option['employee_status'] != 1 && $search_option['employee_status'] != 2) {
    //     //         $employee_info->where('employee_status', 0);
    //     //     } else {
    //     //         $employee_info->where('employees.employee_status', $search_option['employee_status']);
    //     //     }
    //     // }
    //     // dd($search_option['employee_status']);
    //     if (!empty($search_option['employee_section'])) {
    //         $employee_info->whereIn('employees.employee_section', $search_option['employee_section']);
    //     }
    //     if (!empty($search_option['employee_sub_section'])) {
    //         $employee_info->whereIn('employees.employee_sub_section', $search_option['employee_sub_section']);
    //     }
    //     if ($search_option['employee_work_location']) {
    //         $employee_info->whereIn('employees.employee_work_location', $search_option['employee_work_location']);
    //     }
    //     if ($search_option['employee_type']) {
    //         $employee_info->whereIn('employees.employee_type', $search_option['employee_type']);
    //     }
    //     if ($search_option['reporting_to']) {
    //         $Allreporting_to = Employee::valid()->whereIn('id', $search_option['reporting_to'])->get()->keyBy('employee_id_no')->all();
    //         $reporting_to = collect($Allreporting_to)->pluck('employee_id_no')->all();
    //         $employee_info->whereIn('employee_reporting_to', $reporting_to);
    //     } else {
    //         if (!empty($checkedattcolsadd)) {
    //             if (in_array('employee_reporting_to', $checkedattcolsadd)) {
    //                 $Allreporting_to = Employee::valid()->get()->keyBy('employee_id_no')->all();
    //             }
    //         }
    //     }
    //     $employee_info = $employee_info->orderBy('employees.employee_sbu')->orderBy('employees.employee_section')->orderBy('employees.employee_department')->orderBy('designations.priority')->get()->toArray();

    //     // dd($employee_info);
    //     $employee_ids = collect($employee_info)->pluck('employee_id_no')->toArray();
    //     $employee_primary_ids = collect($employee_info)->pluck('id')->toArray();
    //     if (!empty($employee_sbu)) {
    //         $company_sbus = CompanySbu::valid()->whereIn('id', $employee_sbu)->get()->toArray();
    //     } else {
    //         $company_sbus = CompanySbu::valid()->get()->toArray();
    //     }
    //     $employee_section = Section::valid()->get()->toArray();
    //     $employee_sub_section = SubSection::valid()->get()->toArray();
    //     // $employee_district = DistrictModel::get()->toArray();
    //     $employee_department = Department::valid()->get()->toArray();
    //     $employee_designation = Designation::valid()->get()->toArray();
    //     $WorkLocation = WorkLocation::valid()->get()->toArray();
    //     $employeeType = [];
    //     array_push($employeeType, ['id' => '', 'text' => 'All']);
    //     array_push($employeeType, ['id' => '1', 'text' => 'Permanent']);
    //     array_push($employeeType, ['id' => '2', 'text' => 'Probationary']);
    //     array_push($employeeType, ['id' => '3', 'text' => 'Cotractual']);
    //     array_push($employeeType, ['id' => '6', 'text' => 'Casual']);
    //     array_push($employeeType, ['id' => '4', 'text' => 'Temporary']);
    //     array_push($employeeType, ['id' => '5', 'text' => 'Intern']);
    //     $employeePersonalInfo = EmployeePersonalInfo::valid()->whereIn('employee_id', $employee_primary_ids)->get()->toArray();
    //     $all_data = $employee_info;
    //     if (!empty($column_name_data) && $search_option['report_type'] == 5) {
    //         $leaveInfo = LeaveType::valid()->project()->get()->toarray();
    //         // $authorizedLive = LeaveSetup::valid()->project()->where('leave_status',1);
    //         // if (!empty($search_option['leave_type_info'])) {
    //         //     $authorizedLive->whereIn('leave_type', $search_option['leave_type_info']);
    //         // }
    //         // $authorizedLive = $authorizedLive->get();
    //         $thisYearsFristday = date('Y-m-d', strtotime(date("Y") . '-' . '01' . '-' . '01'));
    //         //$earnedLeave = DB::table('earned_leave')->where('leave_status',1)->where('date','<',$thisYearsFristday)->get();
    //         // $availedLive = LeaveApplication::valid()->project()->where('leave_apply_status', 2)
    //         // ->whereDate('leave_applications.leave_from_date', '>=', $leave_from_date_check)
    //         // ->whereDate('leave_applications.leave_to_date', '<=', $leave_to_date_check);
    //         // if (!empty($search_option['leave_type_info'])) {
    //         //     $availedLive->whereIn('leave_type', $search_option['leave_type_info']);
    //         // }
    //         // $availedLive = $availedLive->get()
    //         // ->toarray();
    //         // $earnedLeave_opening = DB::table('earned_leave')->where('leave_status',1)->where('date','<',$thisYearsFristday)->get()->toarray();
    //         foreach ($all_data as $key => $value) {

    //             // $aviledLive=collect($authorizedLive)->where('leave_type',$value['leave_type'])->first();
    //             //$authorizedLives=collect($availedLive)->where('leave_type',$value['leave_type'])->where('employee_id',$value['id'])->where('leave_apply_status',2)
    //             //->whereDate('leave_applications.leave_from_date', '>=', $leave_from_date_check)
    //             //->whereDate('leave_applications.leave_to_date', '<=', $leave_to_date_check)
    //             //->sum('leave_total_day');
    //             //$previousBalance=collect($earnedLeave)->where('leave_type',$value['leave_type'])->where('employee_id',$value['id'])->where('leave_apply_status',2)
    //             //->where('leave_apply_date','>=',$thisYearsFristday)->sum('earned_day');
    //             //$all_data[$key]['balance'] = (($aviledLive['leave_day_no'] + $previousBalance) - $authorizedLives);

    //             $sbu_name = collect($company_sbus)->where('id', $value['employee_sbu'])->first();
    //             $empPersonalinfo = collect($employeePersonalInfo)->where('employee_id', $value['id'])->first();
    //             $section_name = collect($employee_section)->where('id', $value['employee_section'])->first();
    //             $department_name = collect($employee_department)->where('id', $value['employee_department'])->first();
    //             $designation_name = collect($employee_designation)->where('id', $value['employee_designation'])->first();
    //             $work_locationName = collect($WorkLocation)->where('id', $value['employee_work_location'])->first();
    //             $employeeTypes = collect($employeeType)->where('id', $value['employee_type'])->first();
    //             if (!empty($value['employee_sub_section'])) {
    //                 $sub_section_name = collect($employee_sub_section)->where('id', $value['employee_sub_section'])->first();
    //             } else {
    //                 $sub_section_name = [];
    //             }
    //             if (!empty($sub_section_name['sub_section_name'])) {
    //                 $all_data[$key]['sub_section_name'] = isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : 'No Data!';
    //             } else {
    //                 $all_data[$key]['sub_section_name'] = isset($value['employee_sub_section']) ? $value['employee_sub_section'] : 'No Data!';
    //             }
    //             if (!empty($value['employee_joining_date']) && $value['employee_joining_date'] != '0000-00-00') {
    //                 $all_data[$key]['employee_joining_date'] = date("d-M-Y", strtotime($value['employee_joining_date']));
    //             } else {
    //                 $all_data[$key]['employee_joining_date'] = 'No Data!';
    //             }
    //             if ($search_option['reporting_to']) {
    //                 $all_data[$key]['employee_reporting_to'] = $Allreporting_to[$value['employee_reporting_to']]['employee_fullname'] ?? 'No Data!';
    //             } else {
    //                 if (!empty($checkedattcolsadd)) {
    //                     if (in_array('employee_reporting_to', $checkedattcolsadd)) {
    //                         $all_data[$key]['employee_reporting_to'] = $Allreporting_to[$value['employee_reporting_to']]['employee_fullname'] ?? 'No Data!';
    //                     }
    //                 }
    //             }
    //             $all_data[$key]['designation_name'] = isset($designation_name['designation_name']) ? $designation_name['designation_name'] : 'No Data!';
    //             $all_data[$key]['department_name'] = isset($department_name['department_name']) ? $department_name['department_name'] : 'No Data!';
    //             $all_data[$key]['section_name'] = isset($section_name['section_name']) ? $section_name['section_name'] : 'No Data!';
    //             $all_data[$key]['sbu_name'] = isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : 'No Data!';
    //             $all_data[$key]['employee_work_location'] = isset($work_locationName['work_location_name']) ? $work_locationName['work_location_name'] : 'No Data!';
    //             $employee_joining_date = isset($value['employee_joining_date']) ? $value['employee_joining_date'] : '';
    //             if (empty($employee_joining_date) || $employee_joining_date == '0000-00-00') {
    //                 $employeoJoining = isset($value['employee_joining_date']) ? $value['employee_joining_date'] : '';
    //                 if ($employeoJoining == 0 || $employeoJoining == '0000-00-00') {
    //                     $employeoJoining = '';
    //                 }
    //             }
    //             $employeoJoining = $employee_joining_date;
    //             $employeoJoining1 = strtotime($employee_joining_date);
    //             $date2 = date('Y-m-d');
    //             if ($employeoJoining1) {
    //                 $Joining = new DateTime($employeoJoining); // Your date of birth
    //                 $today = new Datetime(date('Y-m-d'));
    //                 $diff = $today->diff($Joining);
    //                 $JoiningDates = $diff->y . '.' . $diff->m;
    //                 $JoiningDates1 = $diff->y;
    //             } else {
    //                 $JoiningDates = 'No Data!';
    //                 $JoiningDates1 = 0;
    //             }
    //             $all_data[$key]['service_length'] = $JoiningDates;
    //             $all_data[$key]['service_length1'] = $JoiningDates1;
    //         }/*loop end*/
    //     }
    //     $all_data1 = $all_data;
    //     if (!empty($search_option['service_length_from']) || !empty($search_option['service_length_to'])) {
    //         if (!empty($search_option['service_length_from']) && !empty($search_option['service_length_to'])) {
    //             $all_data1 = collect($all_data1)->where('service_length', '!=', 'No Data!')->where('service_length1', '>=', $search_option['service_length_from'])->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
    //         } elseif (!empty($search_option['service_length_from'])) {
    //             $all_data1 = collect($all_data1)->where('service_length', '!=', 'No Data!')->where('service_length1', '>=', $search_option['service_length_from'])->toArray();
    //         } elseif (!empty($search_option['service_length_to'])) {
    //             $all_data1 = collect($all_data1)->where('service_length', '!=', 'No Data!')->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
    //         } else {
    //             $all_data1 = $all_data1;
    //         }
    //     }
    //     $totaalEmplyees = count($all_data1);
    //     // $date_report = date("d M,Y");
    //     if (strtotime($leave_from_date_check) != strtotime($leave_to_date_check)) {
    //         $date_report = date("d M, Y", strtotime($leave_from_date_check)) . ' - ' . date("d M, Y", strtotime($leave_to_date_check));
    //     } else {
    //         $date_report = date("d M, Y", strtotime($leave_from_date_check));
    //     }
    //     $report_name = "Detailed Leave Report";
    //     $company_id = $search_option['employee_sbu'];
    //     $created_by = Auth::guard('user')->user()->name;
    //     $table = "<table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'>
    //        <div   class='section-to-print col-md-12'>
    //        <table style='width:100%'> <tr> <td style='width:20%'>
    //        <div class='row' style='margin-left: 21px;'>
    //         <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";
    //     if (!empty($company_id)) {
    //         $companyLogo1 = collect($company_sbus)->where('id', $company_id[0])->first();
    //         if (!empty($companyLogo1)) {
    //             if ($companyLogo1['sbu_logo'] != "") {
    //                 $url = '/company_logo/' . $companyLogo1["sbu_logo"];
    //                 $table .= '<img src="' . $url . '" style="width:25%;">';
    //             } else {
    //                 echo 'No Logo Found';
    //             }
    //         } else {
    //             echo 'No Logo Found';
    //         }
    //     } else {
    //         $url = '/company_logo/group_company_logo.png';
    //         $table .= '<img src="' . $url . '" style="width:25%;">';
    //     }
    //     $table .= " </div></td><td style='width:60%'>
    //         <div class='col-md-12' style='padding: 0px'>
    //           <h3 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h3>
    //           <h4 class='text-center' style='margin:0px;text-align: center!important;'>";
    //     if (!empty($companyLogo)) {
    //         echo $companyLogo['sbu_name'];
    //     }
    //     $table .= "       </h4>
    //           <h5 class='text-center' style='text-align: center!important;'>" . $report_name . "</h5>
    //           <h6 class='text-center' style='text-align: center!important;'>
    //            Date: " . $date_report . "</h6>
    //         </div> </td> <td style='width:20%'>
    //         <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
    //           <p ><strong> Print Date :</strong>" . date('d M,Y') . "</p>
    //           <p style='margin-top: -7px'><strong> Created By :</strong> " . $created_by . "</p>
    //           <p style='margin-top: -7px'><strong> Total Employee :</strong> " . $totaalEmplyees . "</p>
    //         </div>
    //         </div></td></tr></table>";
    //     $table .= "<table  class='table table-bordered' border='0' style='width:100%'>
    //               <thead>
    //                 <tr style='background: #eee;'>
    //                   <th class='ths' style='padding:2px 10px; width: 5%; text-align: center;vertical-align: middle;'>Sl.</th>";
    //     foreach ($column_name_data as $key => $value) {
    //         $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>" . $value . "</th>";
    //     }
    //     $table .= "  </tr>
    //               </thead>
    //               <tbody>";
    //     $i = 0;
    //     foreach ($all_data1 as $key => $single_data) {
    //         $i++;
    //         $table .= " <tr class='body_td'>
    //                   <td  class='ths' style='width: 5%; text-align: center;vertical-align: middle;'>" . $i . "</td>";
    //         foreach ($column_data as $key => $value) {
    //             $valuData = isset($single_data[$value]) ? $single_data[$value] : '';
    //             $table .= "         <td  class='ths $value' style='vertical-align: middle;'>" . $valuData . "</td>";
    //         }
    //         $table .= "  </tr>";
    //     }
    //     $table .= "</tbody>
    //             </table></td></tr></table> ";
    //     return $table;
    // }

    
    
    public function leave_report($search_option, $checkedattcolsadd)
    {
        if (!empty($checkedattcolsadd)) {
            $columnArray = $checkedattcolsadd;
        } else {
            $columnArray = [];
        }

        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();

        $employeeSbu = !empty($search_option['employee_sbu'])
            ? $search_option['employee_sbu']
            : $employee_ids['sub'];

        $employeeDepartment = !empty($search_option['employee_department'])
            ? $search_option['employee_department']
            : $employee_ids['department'];

        if (count($columnArray) > 0) {
            $columNameArray = [
                "employee_id_no","employee_full_name","designation_name",
                "department_name","section_name","employee_work_location",
                "employee_joining_date","service_length","request_date",
                "request_time","approval_date","approved_time","approved_by",
                "leave_type","from_date","to_date","leave_total_days",
                "leave_status","remarks"
            ];
            $column_data = $allcolumnArray = array_merge($columNameArray, $columnArray);
            $column_name_data = $this->column_real_name($allcolumnArray);
        } else {
            $column_data = $columNameArray = [
                "employee_id_no","employee_full_name","designation_name",
                "department_name","section_name","employee_work_location",
                "employee_joining_date","service_length","request_date",
                "request_time","approval_date","approved_time","approved_by",
                "leave_type","from_date","to_date","leave_total_days",
                "leave_status","remarks"
            ];
            $column_name_data = $this->column_real_name($columNameArray);
        }

        $leave_from_date_check = $search_option['from_date_formated'];
        $leave_to_date_check   = $search_option['to_date_formated'];

        /* ===== latest approval only (duplicate fix) ===== */
        $latestApproval = DB::table('leave_approval as la1')
            ->select('la1.*')
            ->whereIn('la1.id', function ($q) {
                $q->select(DB::raw('MAX(id)'))
                    ->from('leave_approval')
                    ->groupBy('leave_apply_id');
            });

        $employee_info = Employee::valid()
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('leave_applications', 'employees.id', '=', 'leave_applications.employee_id')
            ->leftJoinSub($latestApproval, 'leave_approval', function ($join) {
                $join->on('leave_approval.leave_apply_id', '=', 'leave_applications.id');
            })
            ->leftJoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
            ->leftJoin('employees as approval_info', 'approval_info.id', '=', 'leave_approval.leave_approve_by')

            ->select(
                'employees.id',
                'employees.employee_reporting_to',
                'employees.employee_id_no',
                'employees.employee_fullname as employee_full_name',
                'employees.employee_sbu',
                'employees.employee_section',
                'employees.employee_department',
                'employees.employee_designation',
                'employees.employee_type',              // ✅ FIX
                'employees.employee_joining_date',
                'employees.employee_work_location',
                'employees.employee_sub_section',

                DB::raw('DATE_FORMAT(leave_applications.leave_apply_date,"%d-%b-%Y") AS request_date'),
                DB::raw('DATE_FORMAT(leave_applications.leave_from_date,"%d-%b-%Y") AS from_date'),
                DB::raw('DATE_FORMAT(leave_applications.leave_to_date,"%d-%b-%Y") AS to_date'),

                'leave_applications.leave_total_day as leave_total_days',
                'leave_types.leave_type_name as leave_type',
                'leave_applications.leave_reason as remarks',

                DB::raw('TIME(leave_applications.created_at) AS request_time'),
                DB::raw('TIME(leave_approval.updated_at) AS approved_time'),

                DB::raw('(CASE
                WHEN leave_applications.leave_apply_status = "1" THEN "Requested"
                WHEN leave_applications.leave_apply_status = "2" THEN "Approved"
                WHEN leave_applications.leave_apply_status = "3" THEN "Forwarded"
                WHEN leave_applications.leave_apply_status = "4" THEN "Rejected"
                WHEN leave_applications.leave_apply_status = "5" THEN "Rejected"
                ELSE ""
            END) AS leave_status'),

                'leave_approval.leave_approve_date as approval_date',
                'approval_info.employee_fullname as approved_by'
            )

            ->whereIn('employees.employee_sbu', $employeeSbu)
            ->where('employees.employee_department', '!=', 132)
            ->whereIn('employees.employee_department', $employeeDepartment)
            ->whereDate('leave_applications.leave_from_date', '>=', $leave_from_date_check)
            ->whereDate('leave_applications.leave_to_date', '<=', $leave_to_date_check);

        if (!empty($search_option['employee_ids'])) {
            $employee_info->where('employees.id', $search_option['employee_ids']);
        }

        if (!empty($search_option['leave_status'])) {
            $employee_info->where('leave_applications.leave_apply_status', $search_option['leave_status']);
        }

        if (!empty($search_option['leave_type_info'])) {
            $employee_info->whereIn('leave_types.id', $search_option['leave_type_info']);
        }

        if (!empty($search_option['employee_designation'])) {
            $employee_info->whereIn('employees.employee_designation', $search_option['employee_designation']);
        }

        if (!empty($search_option['employee_section'])) {
            $employee_info->whereIn('employees.employee_section', $search_option['employee_section']);
        }

        if (!empty($search_option['employee_sub_section'])) {
            $employee_info->whereIn('employees.employee_sub_section', $search_option['employee_sub_section']);
        }

        if (!empty($search_option['employee_work_location'])) {
            $employee_info->whereIn('employees.employee_work_location', $search_option['employee_work_location']);
        }

        if (!empty($search_option['employee_type'])) {
            $employee_info->whereIn('employees.employee_type', $search_option['employee_type']);
        }

        $employee_info = $employee_info
            ->orderBy('employees.employee_sbu')
            ->orderBy('employees.employee_section')
            ->orderBy('employees.employee_department')
            ->orderBy('designations.priority')
            ->get()
            ->toArray();

        // dd($employee_info);
        $employee_ids = collect($employee_info)->pluck('employee_id_no')->toArray();
        $employee_primary_ids = collect($employee_info)->pluck('id')->toArray();
        if (!empty($employee_sbu)) {
            $company_sbus = CompanySbu::valid()->whereIn('id', $employee_sbu)->get()->toArray();
        } else {
            $company_sbus = CompanySbu::valid()->get()->toArray();
        }
        $employee_section = Section::valid()->get()->toArray();
        $employee_sub_section = SubSection::valid()->get()->toArray();
        // $employee_district = DistrictModel::get()->toArray();
        $employee_department = Department::valid()->get()->toArray();
        $employee_designation = Designation::valid()->get()->toArray();
        $WorkLocation = WorkLocation::valid()->get()->toArray();
        $employeeType = [];
        array_push($employeeType, ['id' => '', 'text' => 'All']);
        array_push($employeeType, ['id' => '1', 'text' => 'Permanent']);
        array_push($employeeType, ['id' => '2', 'text' => 'Probationary']);
        array_push($employeeType, ['id' => '3', 'text' => 'Cotractual']);
        array_push($employeeType, ['id' => '6', 'text' => 'Casual']);
        array_push($employeeType, ['id' => '4', 'text' => 'Temporary']);
        array_push($employeeType, ['id' => '5', 'text' => 'Intern']);
        $employeePersonalInfo = EmployeePersonalInfo::valid()->whereIn('employee_id', $employee_primary_ids)->get()->toArray();
        $all_data = $employee_info;
        if (!empty($column_name_data) && $search_option['report_type'] == 5) {
            $leaveInfo = LeaveType::valid()->project()->get()->toarray();
            // $authorizedLive = LeaveSetup::valid()->project()->where('leave_status',1);
            // if (!empty($search_option['leave_type_info'])) {
            //     $authorizedLive->whereIn('leave_type', $search_option['leave_type_info']);
            // }
            // $authorizedLive = $authorizedLive->get();
            $thisYearsFristday = date('Y-m-d', strtotime(date("Y") . '-' . '01' . '-' . '01'));
            //$earnedLeave = DB::table('earned_leave')->where('leave_status',1)->where('date','<',$thisYearsFristday)->get();
            // $availedLive = LeaveApplication::valid()->project()->where('leave_apply_status', 2)
            // ->whereDate('leave_applications.leave_from_date', '>=', $leave_from_date_check)
            // ->whereDate('leave_applications.leave_to_date', '<=', $leave_to_date_check);
            // if (!empty($search_option['leave_type_info'])) {
            //     $availedLive->whereIn('leave_type', $search_option['leave_type_info']);
            // }
            // $availedLive = $availedLive->get()
            // ->toarray();
            // $earnedLeave_opening = DB::table('earned_leave')->where('leave_status',1)->where('date','<',$thisYearsFristday)->get()->toarray();
            foreach ($all_data as $key => $value) {

                // $aviledLive=collect($authorizedLive)->where('leave_type',$value['leave_type'])->first();
                //$authorizedLives=collect($availedLive)->where('leave_type',$value['leave_type'])->where('employee_id',$value['id'])->where('leave_apply_status',2)
                //->whereDate('leave_applications.leave_from_date', '>=', $leave_from_date_check)
                //->whereDate('leave_applications.leave_to_date', '<=', $leave_to_date_check)
                //->sum('leave_total_day');
                //$previousBalance=collect($earnedLeave)->where('leave_type',$value['leave_type'])->where('employee_id',$value['id'])->where('leave_apply_status',2)
                //->where('leave_apply_date','>=',$thisYearsFristday)->sum('earned_day');
                //$all_data[$key]['balance'] = (($aviledLive['leave_day_no'] + $previousBalance) - $authorizedLives);

                $sbu_name = collect($company_sbus)->where('id', $value['employee_sbu'])->first();
                $empPersonalinfo = collect($employeePersonalInfo)->where('employee_id', $value['id'])->first();
                $section_name = collect($employee_section)->where('id', $value['employee_section'])->first();
                $department_name = collect($employee_department)->where('id', $value['employee_department'])->first();
                $designation_name = collect($employee_designation)->where('id', $value['employee_designation'])->first();
                $work_locationName = collect($WorkLocation)->where('id', $value['employee_work_location'])->first();
                $employeeTypes = collect($employeeType)->where('id', $value['employee_type'])->first();
                if (!empty($value['employee_sub_section'])) {
                    $sub_section_name = collect($employee_sub_section)->where('id', $value['employee_sub_section'])->first();
                } else {
                    $sub_section_name = [];
                }
                if (!empty($sub_section_name['sub_section_name'])) {
                    $all_data[$key]['sub_section_name'] = isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : 'No Data!';
                } else {
                    $all_data[$key]['sub_section_name'] = isset($value['employee_sub_section']) ? $value['employee_sub_section'] : 'No Data!';
                }
                if (!empty($value['employee_joining_date']) && $value['employee_joining_date'] != '0000-00-00') {
                    $all_data[$key]['employee_joining_date'] = date("d-M-Y", strtotime($value['employee_joining_date']));
                } else {
                    $all_data[$key]['employee_joining_date'] = 'No Data!';
                }
                if ($search_option['reporting_to']) {
                    $all_data[$key]['employee_reporting_to'] = $Allreporting_to[$value['employee_reporting_to']]['employee_fullname'] ?? 'No Data!';
                } else {
                    if (!empty($checkedattcolsadd)) {
                        if (in_array('employee_reporting_to', $checkedattcolsadd)) {
                            $all_data[$key]['employee_reporting_to'] = $Allreporting_to[$value['employee_reporting_to']]['employee_fullname'] ?? 'No Data!';
                        }
                    }
                }
                $all_data[$key]['designation_name'] = isset($designation_name['designation_name']) ? $designation_name['designation_name'] : 'No Data!';
                $all_data[$key]['department_name'] = isset($department_name['department_name']) ? $department_name['department_name'] : 'No Data!';
                $all_data[$key]['section_name'] = isset($section_name['section_name']) ? $section_name['section_name'] : 'No Data!';
                $all_data[$key]['sbu_name'] = isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : 'No Data!';
                $all_data[$key]['employee_work_location'] = isset($work_locationName['work_location_name']) ? $work_locationName['work_location_name'] : 'No Data!';
                $employee_joining_date = isset($value['employee_joining_date']) ? $value['employee_joining_date'] : '';
                if (empty($employee_joining_date) || $employee_joining_date == '0000-00-00') {
                    $employeoJoining = isset($value['employee_joining_date']) ? $value['employee_joining_date'] : '';
                    if ($employeoJoining == 0 || $employeoJoining == '0000-00-00') {
                        $employeoJoining = '';
                    }
                }
                $employeoJoining = $employee_joining_date;
                $employeoJoining1 = strtotime($employee_joining_date);
                $date2 = date('Y-m-d');
                if ($employeoJoining1) {
                    $Joining = new DateTime($employeoJoining); // Your date of birth
                    $today = new Datetime(date('Y-m-d'));
                    $diff = $today->diff($Joining);
                    $JoiningDates = $diff->y . '.' . $diff->m;
                    $JoiningDates1 = $diff->y;
                } else {
                    $JoiningDates = 'No Data!';
                    $JoiningDates1 = 0;
                }
                $all_data[$key]['service_length'] = $JoiningDates;
                $all_data[$key]['service_length1'] = $JoiningDates1;
            }/*loop end*/
        }
        $all_data1 = $all_data;
        if (!empty($search_option['service_length_from']) || !empty($search_option['service_length_to'])) {
            if (!empty($search_option['service_length_from']) && !empty($search_option['service_length_to'])) {
                $all_data1 = collect($all_data1)->where('service_length', '!=', 'No Data!')->where('service_length1', '>=', $search_option['service_length_from'])->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
            } elseif (!empty($search_option['service_length_from'])) {
                $all_data1 = collect($all_data1)->where('service_length', '!=', 'No Data!')->where('service_length1', '>=', $search_option['service_length_from'])->toArray();
            } elseif (!empty($search_option['service_length_to'])) {
                $all_data1 = collect($all_data1)->where('service_length', '!=', 'No Data!')->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
            } else {
                $all_data1 = $all_data1;
            }
        }
        $totaalEmplyees = count($all_data1);
        // $date_report = date("d M,Y");
        if (strtotime($leave_from_date_check) != strtotime($leave_to_date_check)) {
            $date_report = date("d M, Y", strtotime($leave_from_date_check)) . ' - ' . date("d M, Y", strtotime($leave_to_date_check));
        } else {
            $date_report = date("d M, Y", strtotime($leave_from_date_check));
        }
        $report_name = "Detailed Leave Report";
        $company_id = $search_option['employee_sbu'];
        $created_by = Auth::guard('user')->user()->name;
        $table = "<table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'>
           <div   class='section-to-print col-md-12'>
           <table style='width:100%'> <tr> <td style='width:20%'>
           <div class='row' style='margin-left: 21px;'>
            <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";
        if (!empty($company_id)) {
            $companyLogo1 = collect($company_sbus)->where('id', $company_id[0])->first();
            if (!empty($companyLogo1)) {
                if ($companyLogo1['sbu_logo'] != "") {
                    $url = '/company_logo/' . $companyLogo1["sbu_logo"];
                    $table .= '<img src="' . $url . '" style="width:25%;">';
                } else {
                    echo 'No Logo Found';
                }
            } else {
                echo 'No Logo Found';
            }
        } else {
            $url = '/company_logo/group_company_logo.png';
            $table .= '<img src="' . $url . '" style="width:25%;">';
        }
        $table .= " </div></td><td style='width:60%'>
            <div class='col-md-12' style='padding: 0px'>
              <h3 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h3>
              <h4 class='text-center' style='margin:0px;text-align: center!important;'>";
        if (!empty($companyLogo)) {
            echo $companyLogo['sbu_name'];
        }
        $table .= "       </h4>
              <h5 class='text-center' style='text-align: center!important;'>" . $report_name . "</h5>
              <h6 class='text-center' style='text-align: center!important;'>
               Date: " . $date_report . "</h6>
            </div> </td> <td style='width:20%'>
            <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
              <p ><strong> Print Date :</strong>" . date('d M,Y') . "</p>
              <p style='margin-top: -7px'><strong> Created By :</strong> " . $created_by . "</p>
              <p style='margin-top: -7px'><strong> Total Employee :</strong> " . $totaalEmplyees . "</p>
            </div>
            </div></td></tr></table>";
        $table .= "<table  class='table table-bordered' border='0' style='width:100%'>
                  <thead>
                    <tr style='background: #eee;'>
                      <th class='ths' style='padding:2px 10px; width: 5%; text-align: center;vertical-align: middle;'>Sl.</th>";
        foreach ($column_name_data as $key => $value) {
            $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>" . $value . "</th>";
        }
        $table .= "  </tr>
                  </thead>
                  <tbody>";
        $i = 0;
        foreach ($all_data1 as $key => $single_data) {
            $i++;
            $table .= " <tr class='body_td'>
                      <td  class='ths' style='width: 5%; text-align: center;vertical-align: middle;'>" . $i . "</td>";
            foreach ($column_data as $key => $value) {
                $valuData = isset($single_data[$value]) ? $single_data[$value] : '';
                $table .= "         <td  class='ths $value' style='vertical-align: middle;'>" . $valuData . "</td>";
            }
            $table .= "  </tr>";
        }
        $table .= "</tbody>
                </table></td></tr></table> ";
        return $table;
    }
    
    public function summary_leave_report($search_option, $checkedattcolsadd)
    {
        // return [$search_option];
        // echo "<pre>";
        // print_r($checkedattcolsadd);
        // exit();
        if (!empty($checkedattcolsadd)) {
            $columnArray = $checkedattcolsadd;
        } else {
            $columnArray = [];
        }
        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];
        if (!empty($search_option['employee_sbu'])) {
            $employeeSbu = $search_option['employee_sbu'];
        } else {
            $employeeSbu = $employee_ids['sub'];
        }
        $employeeDepartment = [];
        if (!empty($search_option['employee_department'])) {
            $employeeDepartment = $search_option['employee_department'];
        } else {
            $employeeDepartment = $employee_ids['department'];
        }
        if (count($columnArray) > 0) {
            $columNameArray = array("employee_id_no", "employee_full_name", "designation_name", "department_name", "section_name", "employee_work_location", "employee_joining_date", "service_length");
            $column_data = $allcolumnArray = array_merge($columNameArray, $columnArray);
            $column_name_data = $this->column_real_name($allcolumnArray);
        } else {
            $column_data = $columNameArray = array("employee_id_no", "employee_full_name", "designation_name", "department_name", "section_name", "employee_work_location", "employee_joining_date", "service_length");
            $column_name_data = $this->column_real_name($columNameArray);
        }
        $leave_from_date_check = $search_option['from_date_formated'];
        $leave_to_date_check = $search_option['to_date_formated'];
        $employee_info = Employee::valid()
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('leave_applications', 'employees.id', '=', 'leave_applications.employee_id')
            ->leftJoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
            ->leftJoin('leave_approval', 'leave_approval.leave_apply_id', '=', 'leave_applications.id')
            ->join('employees as approval_info', 'approval_info.id', '=', 'leave_approval.leave_approve_by')
            ->select(
                'employees.id',
                'employees.employee_reporting_to',
                'employees.employee_id_no',
                'employees.employee_fullname as employee_full_name',
                'employees.employee_sbu',
                'employees.employee_section',
                'employees.employee_department',
                'employees.employee_designation',
                'employees.employee_sub_unit',
                'employees.employee_sub_unit',
                'employees.employee_joining_date',
                'employees.employee_mobile',
                'employees.employee_status',
                'employees.employee_work_location',
                'employees.employee_sub_section',
                'employees.employee_joining_date',
                'employees.employee_type',
                'employee_personal_infos.employee_gender',
                'leave_applications.leave_apply_date as request_date',
                'leave_applications.leave_from_date as from_date',
                'leave_applications.leave_to_date as to_date',
                'leave_applications.leave_total_day as leave_total_days',
                'leave_types.leave_type_name as leave_type',
                'leave_applications.leave_reason as remarks',
                DB::raw('TIME(leave_applications.created_at) AS request_time'),
                DB::raw('TIME(leave_approval.updated_at) AS approved_time'),
                DB::raw('(CASE
                WHEN leave_applications.leave_apply_status = "1" THEN "Requested"
                WHEN leave_applications.leave_apply_status = "2" THEN "Approved"
                WHEN leave_applications.leave_apply_status = "3" THEN "Forwarded"
                WHEN leave_applications.leave_apply_status = "4" THEN "Rejected"
                WHEN leave_applications.leave_apply_status = "5" THEN "Rejected"
                ELSE ""
                END) AS leave_status'),
                'leave_approval.leave_approve_date as approval_date',
                'approval_info.employee_fullname as approved_by',
            )
            ->valid()
            ->whereIn('employees.employee_sbu', $employeeSbu)
            ->where('employees.employee_department', '!=', 132)
            ->whereIn('employees.employee_department', $employeeDepartment)
            //   ->whereDate('leave_applications.leave_from_date', '>=', $leave_from_date_check)
            //   ->whereDate('leave_applications.leave_to_date', '<=', $leave_to_date_check)
        ;
        if (!empty($search_option['employee_ids'])) {
            $employee_info->where('employees.id', $search_option['employee_ids']);
        }
        if (!empty($search_option['leave_status'])) {
            $employee_info->where('leave_applications.leave_apply_status', $search_option['leave_status']);
        }
        if (!empty($search_option['leave_type_info'])) {
            $employee_info->whereIn('leave_types.id', $search_option['leave_type_info']);
        }
        if (!empty($search_option['employee_designation'])) {
            $employee_info->whereIn('employees.employee_designation', $search_option['employee_designation']);
        }
        // if (!empty($search_option['employee_status'])) {
        //     if ($search_option['employee_status'] != 1 && $search_option['employee_status'] != 2) {
        //         $employee_info->where('employee_status', 0);
        //     } else {
        //         $employee_info->where('employees.employee_status', $search_option['employee_status']);
        //     }
        // }
        if (!empty($search_option['employee_section'])) {
            $employee_info->whereIn('employees.employee_section', $search_option['employee_section']);
        }
        if (!empty($search_option['employee_sub_section'])) {
            $employee_info->whereIn('employees.employee_sub_section', $search_option['employee_sub_section']);
        }
        if ($search_option['employee_work_location']) {
            $employee_info->whereIn('employees.employee_work_location', $search_option['employee_work_location']);
        }
        if ($search_option['employee_type']) {
            $employee_info->whereIn('employees.employee_type', $search_option['employee_type']);
        }
        if ($search_option['reporting_to']) {
            $Allreporting_to = Employee::valid()->whereIn('id', $search_option['reporting_to'])->get()->keyBy('employee_id_no')->all();
            $reporting_to = collect($Allreporting_to)->pluck('employee_id_no')->all();
            $employee_info->whereIn('employee_reporting_to', $reporting_to);
        } else {
            if (!empty($checkedattcolsadd)) {
                if (in_array('employee_reporting_to', $checkedattcolsadd)) {
                    $Allreporting_to = Employee::valid()->get()->keyBy('employee_id_no')->all();
                }
            }
        }
        $employee_info = $employee_info->groupBy('employees.id')->orderBy('employees.employee_sbu')->orderBy('employees.employee_section')->orderBy('employees.employee_department')->orderBy('designations.priority')->get()->toArray();
        $employee_ids = collect($employee_info)->pluck('employee_id_no')->toArray();
        $employee_primary_ids = collect($employee_info)->pluck('id')->toArray();
        if (!empty($employee_sbu)) {
            $company_sbus = CompanySbu::valid()->whereIn('id', $employee_sbu)->get()->toArray();
        } else {
            $company_sbus = CompanySbu::valid()->get()->toArray();
        }
        $employee_section = Section::valid()->get()->toArray();
        $employee_sub_section = SubSection::valid()->get()->toArray();
        // $employee_district = DistrictModel::get()->toArray();
        $employee_department = Department::valid()->get()->toArray();
        $employee_designation = Designation::valid()->get()->toArray();
        $WorkLocation = WorkLocation::valid()->get()->toArray();
        $employeeType = [];
        array_push($employeeType, ['id' => '', 'text' => 'All']);
        array_push($employeeType, ['id' => '1', 'text' => 'Permanent']);
        array_push($employeeType, ['id' => '2', 'text' => 'Probationary']);
        array_push($employeeType, ['id' => '3', 'text' => 'Cotractual']);
        array_push($employeeType, ['id' => '6', 'text' => 'Casual']);
        array_push($employeeType, ['id' => '4', 'text' => 'Temporary']);
        array_push($employeeType, ['id' => '5', 'text' => 'Intern']);
        $employeePersonalInfo = EmployeePersonalInfo::valid()->whereIn('employee_id', $employee_primary_ids)->get()->toArray();
        $all_data = $employee_info;
        if (!empty($column_name_data) && $search_option['report_type'] == 5) {
            $leaveInfo = LeaveType::valid()->project()->get()->toarray();
            $authorizedLive = LeaveSetup::valid()->project()->where('leave_status', 1);
            if (!empty($search_option['leave_type_info'])) {
                $authorizedLive->whereIn('leave_type', $search_option['leave_type_info']);
            }
            $authorizedLive = $authorizedLive->get();
            $thisYearsFristday = date($leave_from_date_check, strtotime(date("Y") . '-' . '01' . '-' . '01'));
            $this_year_only = date($leave_from_date_check, strtotime(date("Y")));
            // $availedLive=LeaveApplication::valid()->project()->where('leave_apply_date','<=',date("Y-m-d"))->get();
            // $earnedLeave=DB::table('earned_leave')->where('employee_id',$user_data->employee_id)->where('leave_status',1)->where('date','<',$thisYearsFristday)->get();
            foreach ($all_data as $key => $value) {
                // ->whereBetween('pdate', [$search_option['from_date_formated'],$search_option['to_date_formated']])
                // $aviledLive=collect($authorizedLive)->where('leave_type',$value['id'])->first();
                // $authorizedLives=collect($availedLive)->where('leave_type',$value['id'])->where('employee_id',$user_data->employee_id)->where('leave_apply_status',2)->where('leave_apply_date','>=',$thisYearsFristday)->sum('leave_total_day');
                // $previousBalance=collect($earnedLeave)->where('leave_type',$value['id'])->where('employee_id',$user_data->employee_id)->where('leave_apply_status',2)->where('leave_apply_date','>=',$thisYearsFristday)->sum('earned_day');
                // $leaveInfo[$key]['balance']=(($aviledLive['leave_day_no']+$previousBalance)-$authorizedLives);

                // $leaveInfo=LeaveType::valid()->project()->get();
                // $authorizedLive=LeaveSetup::valid()->project()->where('leave_status',1)->get();
                $availedLive = LeaveApplication::valid()->project()->where('employee_id', $value['id'])->where('leave_apply_status', 2)
                    ->whereDate('leave_applications.leave_from_date', '>=', $leave_from_date_check)
                    ->whereDate('leave_applications.leave_to_date', '<=', $leave_to_date_check);
                if (!empty($search_option['leave_type_info'])) {
                    $availedLive->whereIn('leave_type', $search_option['leave_type_info']);
                }
                // ->where('leave_apply_date', '>=', $thisYearsFristday)->where('leave_apply_date','<=',date("Y-m-d"))
                $availedLive = $availedLive->get()
                    ->toarray()
                ;
                $earnedLeave_opening = DB::table('earned_leave')->where('employee_id', $value['id'])->where('leave_status', 1)->where('date', '<', $thisYearsFristday)->get()->toarray();
                $earnedLeave_cf = DB::table('earned_leave')->where('employee_id', $value['id'])->where('leave_status', 1)->whereBetween('date', [$leave_from_date_check, $leave_to_date_check])->get()->toarray();
                foreach ($leaveInfo as $key1 => $lv_info) {
                    $aviledLive = collect($authorizedLive)->where('leave_type', $lv_info['id'])->first();
                    $authorizedLives = collect($availedLive)->where('leave_type', $lv_info['id'])->sum('leave_total_day');
                    $previousBalance = collect($earnedLeave_opening)->where('leave_type', $lv_info['id'])->sum('earned_day');
                    $earn_leave_cf = collect($earnedLeave_cf)->where('leave_type', $lv_info['id'])->sum('earned_day');
                    $leaveInfo[$key1]['entitlementThisYear'] = $aviledLive['leave_day_no'] ?? 0;
                    $leaveInfo[$key1]['previousBalance'] = $previousBalance;
                    $leaveInfo[$key1]['earn_leave_cf'] = $earn_leave_cf;
                    $leaveInfo[$key1]['totalDay'] = $authorizedLives;
                    $leaveInfo[$key1]['totalEntitlement'] = ($aviledLive['leave_day_no'] ?? 0) + $previousBalance;
                    $leaveInfo[$key1]['balance'] = ((($aviledLive['leave_day_no'] ?? 0) + $previousBalance) - $authorizedLives);
                }
                $all_data[$key]['employee_leaveInfo'] = $leaveInfo;

                $sbu_name = collect($company_sbus)->where('id', $value['employee_sbu'])->first();
                $empPersonalinfo = collect($employeePersonalInfo)->where('employee_id', $value['id'])->first();
                $section_name = collect($employee_section)->where('id', $value['employee_section'])->first();
                $department_name = collect($employee_department)->where('id', $value['employee_department'])->first();
                $designation_name = collect($employee_designation)->where('id', $value['employee_designation'])->first();
                $work_locationName = collect($WorkLocation)->where('id', $value['employee_work_location'])->first();
                $employeeTypes = collect($employeeType)->where('id', $value['employee_type'])->first();
                if (!empty($value['employee_sub_section'])) {
                    $sub_section_name = collect($employee_sub_section)->where('id', $value['employee_sub_section'])->first();
                } else {
                    $sub_section_name = [];
                }
                if (!empty($sub_section_name['sub_section_name'])) {
                    $all_data[$key]['sub_section_name'] = isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : 'No Data!';
                } else {
                    $all_data[$key]['sub_section_name'] = isset($value['employee_sub_section']) ? $value['employee_sub_section'] : 'No Data!';
                }
                if (!empty($value['employee_joining_date']) && $value['employee_joining_date'] != '0000-00-00') {
                    $all_data[$key]['employee_joining_date'] = date("d-M-Y", strtotime($value['employee_joining_date']));
                } else {
                    $all_data[$key]['employee_joining_date'] = 'No Data!';
                }
                if ($search_option['reporting_to']) {
                    $all_data[$key]['employee_reporting_to'] = $Allreporting_to[$value['employee_reporting_to']]['employee_fullname'] ?? 'No Data!';
                } else {
                    if (!empty($checkedattcolsadd)) {
                        if (in_array('employee_reporting_to', $checkedattcolsadd)) {
                            $all_data[$key]['employee_reporting_to'] = $Allreporting_to[$value['employee_reporting_to']]['employee_fullname'] ?? 'No Data!';
                        }
                    }
                }
                $all_data[$key]['designation_name'] = isset($designation_name['designation_name']) ? $designation_name['designation_name'] : 'No Data!';
                $all_data[$key]['department_name'] = isset($department_name['department_name']) ? $department_name['department_name'] : 'No Data!';
                $all_data[$key]['section_name'] = isset($section_name['section_name']) ? $section_name['section_name'] : 'No Data!';
                $all_data[$key]['sbu_name'] = isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : 'No Data!';
                $all_data[$key]['employee_work_location'] = isset($work_locationName['work_location_name']) ? $work_locationName['work_location_name'] : 'No Data!';
                $employee_joining_date = isset($value['employee_joining_date']) ? $value['employee_joining_date'] : '';
                if (empty($employee_joining_date) || $employee_joining_date == '0000-00-00') {
                    $employeoJoining = isset($value['employee_joining_date']) ? $value['employee_joining_date'] : '';
                    if ($employeoJoining == 0 || $employeoJoining == '0000-00-00') {
                        $employeoJoining = '';
                    }
                }
                $employeoJoining = $employee_joining_date;
                $employeoJoining1 = strtotime($employee_joining_date);
                $date2 = date('Y-m-d');
                if ($employeoJoining1) {
                    $Joining = new DateTime($employeoJoining); // Your date of birth
                    $today = new Datetime(date('Y-m-d'));
                    $diff = $today->diff($Joining);
                    $JoiningDates = $diff->y . '.' . $diff->m;
                    $JoiningDates1 = $diff->y;
                } else {
                    $JoiningDates = 'No Data!';
                    $JoiningDates1 = 0;
                }
                $all_data[$key]['service_length'] = $JoiningDates;
                $all_data[$key]['service_length1'] = $JoiningDates1;
            }/*loop end*/
        }
        $all_data1 = $all_data;
        if (!empty($search_option['service_length_from']) || !empty($search_option['service_length_to'])) {
            if (!empty($search_option['service_length_from']) && !empty($search_option['service_length_to'])) {
                $all_data1 = collect($all_data1)->where('service_length', '!=', 'No Data!')->where('service_length1', '>=', $search_option['service_length_from'])->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
            } elseif (!empty($search_option['service_length_from'])) {
                $all_data1 = collect($all_data1)->where('service_length', '!=', 'No Data!')->where('service_length1', '>=', $search_option['service_length_from'])->toArray();
            } elseif (!empty($search_option['service_length_to'])) {
                $all_data1 = collect($all_data1)->where('service_length', '!=', 'No Data!')->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
            } else {
                $all_data1 = $all_data1;
            }
        }
        $totaalEmplyees = count($all_data1);
        // $date_report = date("d M,Y");
        if (strtotime($leave_from_date_check) != strtotime($leave_to_date_check)) {
            $date_report = date("d M, Y", strtotime($leave_from_date_check)) . ' - ' . date("d M, Y", strtotime($leave_to_date_check));
        } else {
            $date_report = date("d M, Y", strtotime($leave_from_date_check));
        }
        $report_name = "Summary Leave Report";
        $company_id = $search_option['employee_sbu'];
        $created_by = Auth::guard('user')->user()->name;
        $leave_type_info = LeaveType::valid()->project()->where('leave_short_type', '!=', 'AL')->get();
        $table = "<table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'>
           <div   class='section-to-print col-md-12'>
           <table style='width:100%'> <tr> <td style='width:20%'>
           <div class='row' style='margin-left: 21px;'>
            <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";
        if (!empty($company_id)) {
            $companyLogo1 = collect($company_sbus)->where('id', $company_id[0])->first();
            if (!empty($companyLogo1)) {
                if ($companyLogo1['sbu_logo'] != "") {
                    $url = '/company_logo/' . $companyLogo1["sbu_logo"];
                    $table .= '<img src="' . $url . '" style="width:25%;">';
                } else {
                    echo 'No Logo Found';
                }
            } else {
                echo 'No Logo Found';
            }
        } else {
            $url = '/company_logo/group_company_logo.png';
            $table .= '<img src="' . $url . '" style="width:25%;">';
        }
        $table .= " </div></td><td style='width:60%'>
            <div class='col-md-12' style='padding: 0px'>
              <h3 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h3>
              <h4 class='text-center' style='margin:0px;text-align: center!important;'>";
        if (!empty($companyLogo)) {
            echo $companyLogo['sbu_name'];
        }
        $table .= "       </h4>
              <h5 class='text-center' style='text-align: center!important;'>" . $report_name . "</h5>
              <h6 class='text-center' style='text-align: center!important;'>
               Date: " . $date_report . "</h6>
            </div> </td> <td style='width:20%'>
            <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
              <p ><strong> Print Date :</strong>" . date('d M,Y') . "</p>
              <p style='margin-top: -7px'><strong> Created By :</strong> " . $created_by . "</p>
              <p style='margin-top: -7px'><strong> Total Employee :</strong> " . $totaalEmplyees . "</p>
            </div>
            </div></td></tr></table>";
        $table .= "<table  class='table table-bordered' border='0' style='width:100%'>
                  <thead>
                    <tr>
                        <th colspan='9' class='ths text-center' style='border: 2px solid #ddd; padding: 0px !important;'>General Column</th>
                        <th colspan='2' class='ths text-center' style='border: 2px solid #ddd; padding: 0px !important;'>L. Record</th>
                        <th colspan='5' class='ths text-center' style='border: 2px solid #ddd; padding: 0px !important;'>Earned Leave/ Annual Leave</th>";
        foreach ($leave_type_info as $key => $value) {
            $table .= "<th colspan='3' class='ths text-center' style='border: 2px solid #ddd; padding: 0px !important;'> " . $value['leave_type_name'] . "</th>";
        }
        $table .= "
                    </tr>
                    <tr style='background: #eee;'>
                        <th class='ths' style='padding:2px 10px; width: 5%; text-align: center;vertical-align: middle;'>Sl.</th>";
        foreach ($column_name_data as $key => $value) {
            $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>" . $value . "</th>";
        }

        $table .= "     <th class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>From</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>To</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>Op. Balance</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>Balance CF</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>T. Entitle.</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>T. Availed</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>Balance</th>";
        foreach ($leave_type_info as $key => $value) {
            if ($value['leave_short_type'] == 'LWP') {
                $table .= "<th class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>Availed</th>";
                break;
            } else {
                $table .= "<th class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>Entitle.</th>
                                <th class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>Availed</th>
                                <th class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>Balance</th>";
            }
        }
        $table .= "
                    </tr>
                  </thead>
                  <tbody>";
        $i = 0;
        foreach ($all_data1 as $key => $single_data) {
            // echo '<pre>';
            // print_r($single_data);
            // die();
            $i++;
            $table .= " <tr class='body_td'>
                      <td  class='ths' style='width: 5%; text-align: center;vertical-align: middle;'>" . $i . "</td>";
            foreach ($column_data as $key => $value) {
                $valuData = isset($single_data[$value]) ? $single_data[$value] : '';
                $table .= " <td  class='ths $value' style='vertical-align: middle;'>" . $valuData . "</td>";
            }
            $table .= " <td  class='ths $value' style='vertical-align: middle;'>" . date("d-M-Y", strtotime($leave_from_date_check)) . "</td>";
            $table .= " <td  class='ths $value' style='vertical-align: middle;'>" . date("d-M-Y", strtotime($leave_to_date_check)) . "</td>";
            foreach ($single_data['employee_leaveInfo'] as $key => $emp_lv_info) {
                if ($emp_lv_info['leave_short_type'] == 'AL') {
                    $table .= " <td  class='ths text-center ths service_length' style='vertical-align: middle;'>" . $emp_lv_info['previousBalance'] . "</td>";
                    $table .= " <td  class='text-center ths service_length' style='vertical-align: middle;'>" . $emp_lv_info['earn_leave_cf'] . "</td>";
                    $table .= " <td  class='text-center ths service_length' style='vertical-align: middle;'>" . $emp_lv_info['entitlementThisYear'] . "</td>";
                    $table .= " <td  class='text-center ths service_length' style='vertical-align: middle;'>" . $emp_lv_info['totalDay'] . "</td>";
                    $table .= " <td  class='text-center ths service_length' style='vertical-align: middle;'>" . $emp_lv_info['balance'] . "</td>";
                }
                if (($emp_lv_info['leave_short_type'] == 'CL' || $emp_lv_info['leave_short_type'] == 'SL') && $single_data['employee_gender'] == 2) {
                    if ($single_data['employee_gender'] == 2) {
                        $table .= " <td  class='text-center ths service_length' style='vertical-align: middle;'>" . $emp_lv_info['entitlementThisYear'] . "</td>";
                        $table .= " <td  class='text-center ths service_length' style='vertical-align: middle;'>" . $emp_lv_info['totalDay'] . "</td>";
                        $table .= " <td  class='text-center ths service_length' style='vertical-align: middle;'>" . $emp_lv_info['balance'] . "</td>";
                    }
                }
                if ($emp_lv_info['leave_short_type'] == 'ML' && $single_data['employee_gender'] == 2) {
                    $table .= " <td  class='text-center ths service_length' style='vertical-align: middle;'>" . '0' . "</td>";
                    $table .= " <td  class='text-center ths service_length' style='vertical-align: middle;'>" . '0' . "</td>";
                    $table .= " <td  class='text-center ths service_length' style='vertical-align: middle;'>" . '0' . "</td>";
                }
                if (($emp_lv_info['leave_short_type'] == 'ML' || $emp_lv_info['leave_short_type'] == 'CL' || $emp_lv_info['leave_short_type'] == 'SL') && $single_data['employee_gender'] == 1) {
                    $table .= " <td  class='text-center ths service_length' style='vertical-align: middle;'>" . $emp_lv_info['entitlementThisYear'] . "</td>";
                    $table .= " <td  class='text-center ths service_length' style='vertical-align: middle;'>" . $emp_lv_info['totalDay'] . "</td>";
                    $table .= " <td  class='text-center ths service_length' style='vertical-align: middle;'>" . $emp_lv_info['balance'] . "</td>";
                }
                if ($emp_lv_info['leave_short_type'] == 'LWP') {
                    $table .= " <td  class='text-center ths service_length' style='vertical-align: middle;'>" . $emp_lv_info['totalDay'] . "</td>";
                }
            }
            $table .= " </tr>";
        }
        $table .= "</tbody>
                    </table></td></tr></table>";
        return $table;
    }
    public function joining_report($search_option)
    {
        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];

        $employee_sbu = [];
        if ($search_option['employee_sbu']) {
            $employee_sbu = $search_option['employee_sbu'];
            $employee_department = [];

            if ($search_option['employee_department']) {
                $employee_department = $search_option['employee_department'];
            } else {
                $employee_department = $employee_ids['department'];
            }
            $employee_info = Employee::valid()
                ->select('employees.*', 'employee_identification_supportings.nid_number', 'employee_adress_details.present_holding_no', 'employee_personal_infos.employee_mobile as p_employee_mobile', 'employee_personal_infos.employee_blood_group', 'employee_personal_infos.employee_dob_certificate', 'work_locations.work_location_name', 'designations.designation_name', 'company_sbus.sbu_name', 'departments.department_name', 'employee_personal_infos.employee_gender')
                ->leftjoin('employee_adress_details', 'employees.id', '=', 'employee_adress_details.ead_employee_id')
                ->leftjoin('employee_personal_infos', 'employees.id', '=', 'employee_personal_infos.employee_id')
                ->leftjoin('employee_identification_supportings', 'employees.id', '=', 'employee_identification_supportings.eis_employee_id')
                ->leftjoin('designations', 'employees.employee_designation', '=', 'designations.id')
                ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
                ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
                ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
                ->where('employees.employee_department', '!=', 132)
                ->whereIn('employee_sbu', $employee_sbu);
            //   ->whereIn('employee_department', $employee_department);

            if ($search_option['from_date_formated'] && $search_option['to_date_formated']) {
                $employee_info->whereBetween('employees.employee_joining_date', [$search_option['from_date_formated'], $search_option['to_date_formated']]);
            }
            if (!empty($employee_department)) {
                $employee_info->whereIn('employee_department', $employee_department);
            }
            if ($search_option['employee_designation']) {
                $employee_info->where('employee_designation', $search_option['employee_designation']);
            }
            // if (!empty($search_option['employee_sbu'])) {
            //     $employee_info->whereIn('employee_sbu', $search_option['employee_sbu']);
            // }
            if (!empty($search_option['unit'])) {
                $employee_info->whereIn('employee_unit', $search_option['unit']);
            }
            if (!empty($search_option['sub_unit'])) {
                $employee_info->whereIn('employee_sub_unit', $search_option['sub_unit']);
            }
            if (!empty($search_option['employee_section'])) {
                $employee_info->whereIn('employee_section', $search_option['employee_section']);
            }
            if (!empty($search_option['employee_sub_section'])) {
                $employee_info->whereIn('employee_sub_section', $search_option['employee_sub_section']);
            }


            if ($search_option['employee_work_location']) {
                $employee_info->where('employee_work_location', $search_option['employee_work_location']);
            }

            $employee_info = $employee_info->orderBy('employees.employee_sbu')->orderBy('employees.employee_section')->orderBy('employees.employee_department')->get()->toArray();


            // $employee_ids = collect($employee_info)->pluck('employee_id_no')->toArray();

            $all_data = collect($employee_info)->groupBy('department_name')->toArray();
            $company_id = $search_option['employee_sbu'];
            $employeeSbu = [];
            if (!empty($search_option['employee_sbu'])) {
                $employeeSbu = $search_option['employee_sbu'];
            } else {
                $employeeSbu = $employee_ids['sub'];
            }
            if (!empty($employeeSbu)) {
                $company_sbus = CompanySbu::valid()->whereIn('id', $employeeSbu)->get()->toArray();
            } else {
                $company_sbus = CompanySbu::valid()->get()->toArray();
            }
            // dd($all_data);
            $table = "<table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'>
                <div   class='section-to-print col-md-12'>
                <table style='width:100%'> <tr> <td style='width:20%'>
                <div class='row' style='margin-left: 21px;'>
                <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";

            if (!empty($company_id)) {
                $companyLogo1 = collect($company_sbus)->where('id', $company_id[0])->first();
                // echo "<pre>";
                // print_r($companyLogo1['sbu_name']);
                if (!empty($companyLogo1)) {
                    if ($companyLogo1['sbu_logo'] != "") {
                        $url = '/company_logo/' . $companyLogo1["sbu_logo"];
                        $table .= '<img src="' . $url . '" style="width:25%;">';
                    } else {
                        echo 'No Logo Found';
                    }
                } else {
                    echo 'No Logo Found';
                }
            } else {
                $url = '/company_logo/group_company_logo.png';
                $table .= '<img src="' . $url . '" style="width:25%;">';
            }
            $table .= " </div></td><td style='width:60%'>
      <div class='col-md-12' style='padding: 0px'>
        <h3 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h3>
        <h4 class='text-center' style='margin:0px;text-align: center!important;'>" . $companyLogo1['sbu_name'] ?? '' . "</h4>";
            $table .= "
        <h5 class='text-center' style='text-align: center!important;'>" . "Employee Joining Report" . "</h5>
        <h6 class='text-center' style='text-align: center!important;'>

          Date: " . date("d M, Y") . "</h6>
      </div> </td> <td style='width:20%'>
      <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
        <p ><strong> Print Date :</strong>" . date('d M,Y') . "</p>
        <p style='margin-top: -7px'><strong> Created By :</strong> " . Auth::guard('user')->user()->name . "</p>
      </div>
      </div></td></tr></table>
                    <table class='table table-bordered' border='0' style='width:100%'>
                      <thead>
                        <tr style='background: #eee;'>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Sl.</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>ID</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Name</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Designation</th>";
            $table .= "<th class='ths' style='padding:2px 10px; text-align: center;'>DOJ</th>";
            $table .= "<th class='ths' style='padding:2px 10px; text-align: center;'>Work location</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Address</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>DOB</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Gender</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>NID</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>BG</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Contact</th>
                        </tr>
                      </thead>";
            $i = 0;
            foreach ($all_data as $key => $single_data) {
                // dd($single_data);
                $sbuName = collect($single_data)->first();
                //  echo"<pre>";
                // print_r($sbuName['department_name']);
                // exit();
                $table .= "<tr style='border: none;'>
                    <td style='border: none;text-align: center;'></td>
                    <td style='border: none;text-align: right;'><strong>Department:</strong></td>
                    <td colspan='3' style='border: none;text-align: left;'><strong>" . $sbuName['department_name'] ?? ' ' . "</strong></td>
                    <td style='border: none;text-align: center;'></td>
                    <td style='border: none;text-align: right;'><strong>SBU:</strong></td>
                    <td colspan='3' style='border: none;text-align: left;'><strong>" . $sbuName['sbu_name'] ?? ' ' . "</strong></td>
                  </tr>";
                foreach ($single_data as $key => $value) {
                    $i++;
                    if ($value['employee_gender'] == 1) {
                        $employee_gender = 'Female';
                    } else if ($value['employee_gender'] == 2) {
                        $employee_gender = 'Male';
                    } else {
                        $employee_gender = 'Other';
                    }
                    $table .= "<tr class='body_td ths'>
                          <td style='text-align: left;'>" . $i . "</td>
                          <td class='text-left ths'>" . $value['employee_id_no'] . "</td>
                          <td  >" . $value['employee_fullname'] . "</td>
                          <td >" . $value['designation_name'] . "</td>";
                    $table .= "<td  class='ths text-left'>" . date("d-M-Y", strtotime($value['employee_joining_date'])) . "</td>
                          <td class='ths text-left'>" . $value['work_location_name'] . "</td>
                          <td class='ths text-left'>" . $value['present_holding_no'] . "</td>
                          <td class='ths text-left'>" . date("d-M-Y", strtotime($value['employee_dob_certificate'])) . "</td>
                          <td class='ths text-left'>" . $employee_gender . "</td>
                          <td class='ths text-left'>" . $value['nid_number'] . "</td>
                          <td class='ths text-left'>" . $value['employee_blood_group'] . "</td>
                          <td class='ths text-left'>" . $value['employee_mobile'] ?? $value['p_employee_mobile'] . "</td>
                        </tr>";
                }
            }
            $table .= "        </tbody>
                    </table>
                  </div></td></tr></table>";

            return $table;
            // return view('layouts.report', compact('all_data', 'column_data', 'column_name_data', 'date_report', 'company_id', 'company_sbus', 'created_by', 'report_name'));
        } else {
            return "Please Select SBU";
        }
    }

    public function sbu_wise_employee_find($search_option = null)
    {

        // dd($search_option);
        // $employee_list = new Employee();
        // $employee_ids = $employee_list->Employee_id();
        // $employee_id = $employee_ids['employee_id'];

        $employeeSbu = [];
        if (!empty($search_option['employee_sbu'])) {
            $employeeSbu = $search_option['employee_sbu'];
        } else {
            // $employeeSbu = $employee_ids['sub'];
            $employeeSbu = [];
        }
        $employeeDepartment = [];
        if (!empty($search_option['employee_department'])) {
            $employeeDepartment = $search_option['employee_department'];
        } else {
            // $employeeDepartment = $employee_ids['department'];
            $employeeDepartment = [];
        }
        $employeeDesignation = [];
        if (!empty($search_option['employee_designation'])) {
            $employeeDesignation = $search_option['employee_designation'];
        } else {
            // $employeeDesignation = $employee_ids['designation'];
            $employeeDesignation = [];
        }
        $employeeWorkLocation = [];
        if (!empty($search_option['employee_work_location'])) {
            $employeeWorkLocation = $search_option['employee_work_location'];
        } else {
            // $employeeWorkLocation = $employee_ids['work_location'];
            $employeeWorkLocation = [];
        }

        // dd($employeeWorkLocation);

        $emplyId = Employee::valid()->where('employees.employee_status', 1)
            ->where('employees.employee_department', '!=', 132)
            ->where('employee_joining_date', '<=', date('Y-m-d'))
        ;
        // ->whereIn('employee_department',$employeeDepartments);
        if (!empty($search_option['employee_sbu'])) {
            $emplyId->where('employees.employee_sbu', $search_option['employee_sbu']);
        }
        if (!empty($search_option['employee_department'])) {
            $emplyId->where('employees.employee_department', $search_option['employee_department']);
        }
        if (!empty($search_option['employee_designation'])) {
            $emplyId->where('employees.employee_designation', $search_option['employee_designation']);
        }
        if (!empty($search_option['employee_work_location'])) {
            $emplyId->whereIn('employee_work_location', $search_option['employee_work_location']);
        }
        $emplyIds = $emplyId->pluck('id')->toarray();

        // dd($emplyIds);
        // $resignationsEmpId = DB::table('resignations')->where('resignation_status', 2)->where('effective_date', '>=', $search_option['to_date_formated'])->pluck('employee_id')->toarray();

        // $allemplyid = array_merge($emplyIds, $resignationsEmpId);

        if ($search_option['sbu_wise_report_type'] == 1) {
            $employee_info = Employee::valid()
                ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
                ->select(
                    array(
                        "company_sbus.sbu_name",
                        DB::raw("count(employees.id) as total_employee"),
                        DB::raw("SUM(CASE WHEN employee_type = '1' THEN 1 ELSE 0 END) AS permanent_employee"),
                        DB::raw("SUM(CASE WHEN employee_type = '2' THEN 1 ELSE 0 END) AS probationary_employee"),
                        DB::raw("SUM(CASE WHEN employee_type = '3' THEN 1 ELSE 0 END) AS contractual_employee"),
                        DB::raw("SUM(CASE WHEN employee_type = '4' THEN 1 ELSE 0 END) AS casual_employee"),
                        DB::raw("SUM(CASE WHEN employee_type = '5' THEN 1 ELSE 0 END) AS temporary_employee"),
                        DB::raw("SUM(CASE WHEN employee_type = '6' THEN 1 ELSE 0 END) AS intern_employee"),
                    )
                )
                // ->where('employee_status','=','1')
                ->whereIn('employees.id', $emplyIds)
                //   ->whereIn('employee_sbu', $employeeSbu)
                //   ->whereIn('employee_department', $employeeDepartment)
                //   ->whereIn('employee_designation', $employeeDesignation)
                //   ->whereIn('employee_work_location', $employeeWorkLocation)
            ;

            if (!empty($employeeSbu)) {
                $employee_info->whereIn('employee_sbu', $employeeSbu);
            }
            if (!empty($employeeDepartment)) {
                $employee_info->whereIn('employee_department', $employeeDepartment);
            }
            if (!empty($employeeDesignation)) {
                $employee_info->whereIn('employee_designation', $employeeDesignation);
            }
            if (!empty($employeeWorkLocation)) {
                $employee_info->whereIn('employee_work_location', $employeeWorkLocation);
            }
            $employee_info = $employee_info->groupBy('employees.employee_sbu')->orderBy('company_sbus.priority', 'ASC')->get()->toArray();
            // dd($employee_info);
            //  $data['management_employee'] = collect($employee_info)->where('emplyee_category_mgt_non_mgt','1')->toArray();
            //  $data['non_management_employee'] = collect($employee_info)->where('emplyee_category_mgt_non_mgt','2')->toArray();

            //  echo "<pre>"; print_r($employee_info); exit();
            if (!empty($employeeSbu)) {
                $company_sbus = CompanySbu::valid()->whereIn('id', $employeeSbu)->get()->toArray();
            } else {
                $company_sbus = CompanySbu::valid()->get()->toArray();
            }
            $date_report = date("d M, Y");
            $report_name = "Active Employee List";
            $company_id = $search_option['employee_sbu'];
            $created_by = Auth::guard('user')->user()->name;
        } else {
            $employee_info = Employee::valid()
                ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
                ->select(
                    array(
                        "company_sbus.sbu_name",
                        DB::raw("count(employees.id) as total_employee"),
                        DB::raw("SUM(CASE
          WHEN emplyee_category_mgt_non_mgt = '1' THEN 1 ELSE 0 END) AS management_employee"),
                        DB::raw("SUM(CASE
          WHEN emplyee_category_mgt_non_mgt = '2' THEN 1 ELSE 0 END) AS non_management_employee"),
                    )
                )
                // ->where('employee_status','=','1')
                ->whereIn('employees.id', $emplyIds)
                //   ->whereIn('employee_sbu', $employeeSbu)
                //   ->whereIn('employee_department', $employeeDepartment)
                //   ->whereIn('employee_designation', $employeeDesignation)
                //   ->whereIn('employee_work_location', $employeeWorkLocation)
            ;

            if (!empty($employeeSbu)) {
                $employee_info->whereIn('employee_sbu', $employeeSbu);
            }
            if (!empty($employeeDepartment)) {
                $employee_info->whereIn('employee_department', $employeeDepartment);
            }
            if (!empty($employeeDesignation)) {
                $employee_info->whereIn('employee_designation', $employeeDesignation);
            }
            if (!empty($employeeWorkLocation)) {
                $employee_info->whereIn('employee_work_location', $employeeWorkLocation);
            }
            $employee_info = $employee_info->groupBy('employees.employee_sbu')->orderBy('company_sbus.priority', 'ASC')->get()->toArray();
            //  $data['management_employee'] = collect($employee_info)->where('emplyee_category_mgt_non_mgt','1')->toArray();
            //  $data['non_management_employee'] = collect($employee_info)->where('emplyee_category_mgt_non_mgt','2')->toArray();

            //  echo "<pre>"; print_r($employee_info); exit();
            if (!empty($employeeSbu)) {
                $company_sbus = CompanySbu::valid()->whereIn('id', $employeeSbu)->get()->toArray();
            } else {
                $company_sbus = CompanySbu::valid()->get()->toArray();
            }
            $date_report = date("d M, Y");
            $report_name = "Active Employee List";
            $company_id = $search_option['employee_sbu'];
            $created_by = Auth::guard('user')->user()->name;
        }
        if ($search_option['sbu_wise_report_type'] == 1) {
            $table = "<table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'>
      <div   class='section-to-print col-md-12'>
      <table style='width:100%'> <tr> <td style='width:20%'>
      <div class='row' style='margin-left: 21px;'>
      <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";
            if (!empty($company_id)) {
                $companyLogo1 = collect($company_sbus)->where('id', $company_id[0])->first();
                if (!empty($companyLogo1)) {
                    if ($companyLogo1['sbu_logo'] != "") {
                        $url = '/company_logo/' . $companyLogo1["sbu_logo"];
                        $table .= '<img src="' . $url . '" style="width:25%;">';
                    } else {
                        echo 'No Logo Found';
                    }
                } else {
                    echo 'No Logo Found';
                }
            } else {
                $url = '/company_logo/group_company_logo.png';
                $table .= '<img src="' . $url . '" style="width:25%;">';
            }
            $table .= " </div></td><td style='width:60%'>
      <div class='col-md-12' style='padding: 0px'>
        <h3 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h3>
        <h4 class='text-center' style='margin:0px;text-align: center!important;'>";
            if (!empty($companyLogo)) {
                echo $companyLogo['sbu_name'];
            }
            $table .= "       </h4>
        <h5 class='text-center' style='text-align: center!important;'>" . $report_name . "</h5>
        <h6 class='text-center' style='text-align: center!important;'>

          Date: " . $date_report . "</h6>
      </div> </td> <td style='width:20%'>
      <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
        <p ><strong> Print Date :</strong>" . date('d M,Y') . "</p>
        <p style='margin-top: -7px'><strong> Created By :</strong> " . $created_by . "</p>
      </div>
      </div></td></tr></table>";

            $table .= "<table  class='table table-bordered active-employee' border='0' style='width:100%'>
            <thead>
              <tr style='background: #eee;'>
                <th class='ths' style='padding:2px 10px; width: 10%; text-align: center;vertical-align: middle;background: #dfdfdf;'>Sl.</th>
                <th class='ths' style='padding:2px 10px; width: 30%; text-align: center;vertical-align: middle;background: #dfdfdf;'>SBU/Unit</th>
                <th class='ths' style='padding:2px 10px; width: 20%; text-align: center;vertical-align: middle;background: #dfdfdf;'>Permanent</th>
                <th class='ths' style='padding:2px 10px; width: 20%; text-align: center;vertical-align: middle;background: #dfdfdf;'>Contractual</th>
                <th class='ths' style='padding:2px 10px; width: 20%; text-align: center;vertical-align: middle;background: #dfdfdf;'>Casual</th>
                <th class='ths' style='padding:2px 10px; width: 20%; text-align: center;vertical-align: middle;background: #dfdfdf;'>Total</th>
              </tr>
            </thead>
            <tbody>";
            $j = 0;
            $total_permanent_employee = 0;
            $total_probationary_employee = 0;
            $total_contractual_employee = 0;
            $total_casual_employee = 0;
            $total_temporary_employee = 0;
            $total_intern_employee = 0;
            $total_employee_type = 0;
            foreach ($employee_info as $single_data) {
                // dd($single_data);
                $total_permanent_employee += $single_data['permanent_employee'];
                $total_probationary_employee += $single_data['probationary_employee'];
                $total_contractual_employee += $single_data['contractual_employee'];
                $total_casual_employee += $single_data['casual_employee'];
                $total_temporary_employee += $single_data['temporary_employee'];
                $total_intern_employee += $single_data['intern_employee'];
                $all_total_employee = $single_data['permanent_employee'] + $single_data['probationary_employee'] + $single_data['contractual_employee'] + $single_data['casual_employee'] + $single_data['temporary_employee'] + $single_data['intern_employee'];
                $total_employee_type += $all_total_employee;

                $j++;
                $table .= "<tr>
                    <td class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>" . $j . "</td>
                    <td class='ths' style='padding:2px 10px; text-align: left;vertical-align: middle;'>" . $single_data['sbu_name'] . "</td>
                    <td class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>" . ($single_data['permanent_employee'] + $single_data['probationary_employee']) . "</td>
                    <td class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>" . $single_data['contractual_employee'] . "</td>
                    <td class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>" . ($single_data['casual_employee'] + $single_data['temporary_employee'] + $single_data['intern_employee']) . "</td>
                    <td class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>" . $all_total_employee . "</td>
                  </tr>";
            }
            // dd($total_permanent_employee, $total_probationary_employee);
            $table .= "</tbody>
          <tbody>
              <tr style='background: #eee;'>
                <th class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;background: #dfdfdf;' colspan='2'>Total</th>
                <th class='ths' style='padding:2px 10px; width: 20%; text-align: center;vertical-align: middle;background: #dfdfdf;'>" . ($total_permanent_employee + $total_probationary_employee) . "</th>
                <th class='ths' style='padding:2px 10px; width: 20%; text-align: center;vertical-align: middle;background: #dfdfdf;'>" . $total_contractual_employee . "</th>
                <th class='ths' style='padding:2px 10px; width: 20%; text-align: center;vertical-align: middle;background: #dfdfdf;'>" . ($total_casual_employee + $total_temporary_employee + $total_intern_employee) . "</th>
                <th class='ths' style='padding:2px 10px; width: 20%; text-align: center;vertical-align: middle;background: #dfdfdf;'>" . $total_employee_type . "</th>
              </tr>
            </tbody>
          </table></td></tr></table>
          <small style='text-align: center;'><i>Permanent = Permanent Type + Probationary Type Employee; Contractual = Contractual Type Employee; Casual = Casual Type + Temporary Type + Intern Type Employee;</i></small>
          ";
            return $table;
        } else {
            $table = "<table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'>
        <div   class='section-to-print col-md-12'>
        <table style='width:100%'> <tr> <td style='width:20%'>
        <div class='row' style='margin-left: 21px;'>
        <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";
            if (!empty($company_id)) {
                $companyLogo1 = collect($company_sbus)->where('id', $company_id[0])->first();
                if (!empty($companyLogo1)) {
                    if ($companyLogo1['sbu_logo'] != "") {
                        $url = '/company_logo/' . $companyLogo1["sbu_logo"];
                        $table .= '<img src="' . $url . '" style="width:25%;">';
                    } else {
                        echo 'No Logo Found';
                    }
                } else {
                    echo 'No Logo Found';
                }
            } else {
                $url = '/company_logo/group_company_logo.png';
                $table .= '<img src="' . $url . '" style="width:25%;">';
            }
            $table .= " </div></td><td style='width:60%'>
        <div class='col-md-12' style='padding: 0px'>
          <h3 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h3>
          <h4 class='text-center' style='margin:0px;text-align: center!important;'>";
            if (!empty($companyLogo)) {
                echo $companyLogo['sbu_name'];
            }
            $table .= "       </h4>
          <h5 class='text-center' style='text-align: center!important;'>" . $report_name . "</h5>
          <h6 class='text-center' style='text-align: center!important;'>

            Date: " . $date_report . "</h6>
        </div> </td> <td style='width:20%'>
        <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
          <p ><strong> Print Date :</strong>" . date('d M,Y') . "</p>
          <p style='margin-top: -7px'><strong> Created By :</strong> " . $created_by . "</p>
        </div>
        </div></td></tr></table>";

            $table .= "<table  class='table table-bordered active-employee' border='0' style='width:100%'>
              <thead>
                <tr style='background: #eee;'>
                  <th class='ths' style='padding:2px 10px; width: 10%; text-align: center;vertical-align: middle;background: #dfdfdf;'>Sl.</th>
                  <th class='ths' style='padding:2px 10px; width: 30%; text-align: center;vertical-align: middle;background: #dfdfdf;'>SBU/Unit</th>
                  <th class='ths' style='padding:2px 10px; width: 20%; text-align: center;vertical-align: middle;background: #dfdfdf;'>Management</th>
                  <th class='ths' style='padding:2px 10px; width: 20%; text-align: center;vertical-align: middle;background: #dfdfdf;'>Non-Management</th>
                  <th class='ths' style='padding:2px 10px; width: 20%; text-align: center;vertical-align: middle;background: #dfdfdf;'>Total</th>
                </tr>
              </thead>
              <tbody>";
            $i = 0;
            $total_management_employee = 0;
            $total_non_management_employee = 0;
            $total_employee = 0;
            foreach ($employee_info as $single_data) {
                $total_management_employee += $single_data['management_employee'];
                $total_non_management_employee += $single_data['non_management_employee'];
                $total_employee += $single_data['total_employee'];
                $i++;
                $table .= "<tr>
                      <td class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>" . $i . "</td>
                      <td class='ths' style='padding:2px 10px; text-align: left;vertical-align: middle;'>" . $single_data['sbu_name'] . "</td>
                      <td class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>" . $single_data['management_employee'] . "</td>
                      <td class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>" . $single_data['non_management_employee'] . "</td>
                      <td class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;'>" . $single_data['total_employee'] . "</td>
                    </tr>";
            }
            $table .= "</tbody>
            <tbody>
                <tr style='background: #eee;'>
                  <th class='ths' style='padding:2px 10px; text-align: center;vertical-align: middle;background: #dfdfdf;' colspan='2'>Total</th>
                  <th class='ths' style='padding:2px 10px; width: 20%; text-align: center;vertical-align: middle;background: #dfdfdf;'>" . $total_management_employee . "</th>
                  <th class='ths' style='padding:2px 10px; width: 20%; text-align: center;vertical-align: middle;background: #dfdfdf;'>" . $total_non_management_employee . "</th>
                  <th class='ths' style='padding:2px 10px; width: 20%; text-align: center;vertical-align: middle;background: #dfdfdf;'>" . $total_employee . "</th>
                </tr>
              </tbody>
            </table></td></tr></table> ";
            return $table;
        }



    }
    public function resing_report($search_option)
    {

        // dd($search_option);
        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        // $employee_id = $employee_ids['employee_id'];

        //   echo "<pre>";
        //  print_r($search_option['employee_sbu']);
        //  exit();
        $employee_sbu = [];
        if ($search_option['employee_sbu']) {
            $employee_sbu = $search_option['employee_sbu'];
            $employee_department = [];

            if ($search_option['employee_department']) {
                $employee_department = $search_option['employee_department'];
            } else {
                $employee_department = $employee_ids['department'];
            }
            $employee_info = Employee::valid()
                ->select('employees.*', 'work_locations.work_location_name', 'separation_type', 'separation_reason', 'separation_date', 'last_working_date', 'effective_date', 'designations.designation_name', 'company_sbus.sbu_name', 'departments.department_name')
                //   ->leftjoin('employee_adress_details', 'employees.id', '=', 'employee_adress_details.ead_employee_id')
                //   ->leftjoin('employee_personal_infos', 'employees.id', '=', 'employee_personal_infos.employee_id')
                //   ->leftjoin('employee_identification_supportings', 'employees.id', '=', 'employee_identification_supportings.eis_employee_id')
                ->leftjoin('resignations', 'employees.id', '=', 'resignations.employee_id')
                ->leftjoin('designations', 'employees.employee_designation', '=', 'designations.id')
                ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
                ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
                ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
                ->where('resignations.resignation_status', 2)
                ->where('employees.employee_department', '!=', 132)
                ->whereIn('employee_sbu', $employee_sbu);

            if ($search_option['from_date_formated'] && $search_option['to_date_formated']) {
                $employee_info->whereBetween('resignations.last_working_date', [$search_option['from_date_formated'], $search_option['to_date_formated']]);
            }
            if (!empty($employee_department)) {
                $employee_info->whereIn('employee_department', $employee_department);
            }
            if ($search_option['employee_designation']) {
                $employee_info->where('employee_designation', $search_option['employee_designation']);
            }
            if (!empty($search_option['unit'])) {
                $employee_info->whereIn('employee_unit', $search_option['unit']);
            }
            if (!empty($search_option['sub_unit'])) {
                $employee_info->whereIn('employee_sub_unit', $search_option['sub_unit']);
            }
            if (!empty($search_option['employee_section'])) {
                $employee_info->whereIn('employee_section', $search_option['employee_section']);
            }
            if (!empty($search_option['employee_sub_section'])) {
                $employee_info->whereIn('employee_sub_section', $search_option['employee_sub_section']);
            }
            if ($search_option['employee_work_location']) {
                $employee_info->where('employee_work_location', $search_option['employee_work_location']);
            }

            $employee_info = $employee_info->orderBy('employees.employee_sbu')->orderBy('employees.employee_section')->orderBy('employees.employee_department')->get()->toArray();



            $all_data = collect($employee_info)->groupBy('department_name')->toArray();
            $company_id = $search_option['employee_sbu'];
            $employeeSbu = [];
            if (!empty($search_option['employee_sbu'])) {
                $employeeSbu = $search_option['employee_sbu'];
            } else {
                $employeeSbu = $employee_ids['sub'];
            }
            if (!empty($employeeSbu)) {
                $company_sbus = CompanySbu::valid()->whereIn('id', $employeeSbu)->get()->toArray();
            } else {
                $company_sbus = CompanySbu::valid()->get()->toArray();
            }
            // dd($all_data);
            $table = "<table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'>
                <div   class='section-to-print col-md-12'>
                <table style='width:100%'> <tr> <td style='width:20%'>
                <div class='row' style='margin-left: 21px;'>
                <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";

            if (!empty($company_id)) {
                $companyLogo1 = collect($company_sbus)->where('id', $company_id[0])->first();
                // echo "<pre>";
                // print_r($companyLogo1['sbu_name']);
                if (!empty($companyLogo1)) {
                    if ($companyLogo1['sbu_logo'] != "") {
                        $url = '/company_logo/' . $companyLogo1["sbu_logo"];
                        $table .= '<img src="' . $url . '" style="width:25%;">';
                    } else {
                        echo 'No Logo Found';
                    }
                } else {
                    echo 'No Logo Found';
                }
            } else {
                $url = '/company_logo/group_company_logo.png';
                $table .= '<img src="' . $url . '" style="width:25%;">';
            }
            $table .= " </div></td><td style='width:60%'>
      <div class='col-md-12' style='padding: 0px'>
        <h3 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h3>
        <h4 class='text-center' style='margin:0px;text-align: center!important;'>" . $companyLogo1['sbu_name'] ?? '' . "</h4>";
            $table .= "
        <h5 class='text-center' style='text-align: center!important;'>" . "Employee Resignation Report" . "</h5>
        <h6 class='text-center' style='text-align: center!important;'>

          Date: " . date("d M, Y") . "</h6>
      </div> </td> <td style='width:20%'>
      <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
        <p ><strong> Print Date :</strong>" . date('d M,Y') . "</p>
        <p style='margin-top: -7px'><strong> Created By :</strong> " . Auth::guard('user')->user()->name . "</p>
      </div>
      </div></td></tr></table>
                    <table class='table table-bordered' border='0' style='width:100%'>
                      <thead>
                        <tr style='background: #eee;'>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Sl.</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>ID</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Name</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Designation</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>SBU</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Department</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Work location</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Separation Type </th>";

            $table .= "<th class='ths' style='padding:2px 10px; text-align: center;'>Joining Date </th>";
            $table .= "  <th class='ths' style='padding:2px 10px; text-align: center;'>Resignation Date</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Last Working Date</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Service Length</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Reason</th>
                        </tr>
                      </thead>";
            $i = 0;
            foreach ($all_data as $key => $single_data) {
                // $sbuName =  collect($single_data)->first();
                // $table .= "<tr style='border: none;'>
                //     <td style='border: none;text-align: center;'></td>
                //     <td style='border: none;text-align: right;'><strong>Department:</strong></td>
                //     <td colspan='3' style='border: none;text-align: left;'><strong>".$sbuName['department_name'] ?? ' ' ."</strong></td>
                //     <td style='border: none;text-align: center;'></td>
                //     <td style='border: none;text-align: right;'><strong>SBU:</strong></td>
                //     <td colspan='3' style='border: none;text-align: left;'><strong>".$sbuName['sbu_name'] ?? ' ' ."</strong></td>
                //   </tr>";
                foreach ($single_data as $key => $value) {

                    $separationType = '';
                    if ($value['separation_type'] == 1) {
                        $separationType = 'Resignation';
                    } else if ($value['separation_type'] == 2) {
                        $separationType = 'Termination';
                    } else if ($value['separation_type'] == 3) {
                        $separationType = 'Retired';
                    } else if ($value['separation_type'] == 4) {
                        $separationType = 'Retracement';
                    } else if ($value['separation_type'] == 5) {
                        $separationType = 'Died';
                    }

                    $employee_joining_date = isset($value['employee_joining_date']) ? $value['employee_joining_date'] : '';
                    if (empty($employee_joining_date) || $employee_joining_date == '0000-00-00') {
                        $employeoJoining = isset($value['employee_joining_date']) ? $value['employee_joining_date'] : '';
                        if ($employeoJoining == 0 || $employeoJoining == '0000-00-00') {
                            $employeoJoining = '';
                        }
                    }
                    $employeoJoining = $employee_joining_date;

                    $employeoJoining1 = strtotime($employee_joining_date);

                    $separation_date = isset($value['last_working_date']) ? $value['last_working_date'] : '';
                    if (empty($separation_date) || $separation_date == '0000-00-00') {
                        $separation_dates = isset($value['last_working_date']) ? $value['last_working_date'] : '';
                        if ($separation_dates == 0 || $separation_dates == '0000-00-00') {
                            $separation_dates = '';
                        }
                    }
                    $separation_dates = $separation_date;
                    $separation_dates1 = strtotime($separation_date);

                    if ($employeoJoining1) {
                        $Joining = new DateTime($employeoJoining); // Your date of birth
                        $today = new Datetime($separation_dates);
                        $diff = $today->diff($Joining);
                        // $JoiningDates = $diff->y . '.' . $diff->m;
                        $JoiningDates = (float) ($diff->days) / 365;
                        $JoiningDates1 = $diff->y;
                    } else {
                        $JoiningDates = 0;
                        $JoiningDates1 = 0;
                    }
                    // echo"<>pre>";
                    // print_r($JoiningDates);
                    // exit();
                    $service_length = $JoiningDates;
                    $service_length1 = $JoiningDates1;

                    $i++;
                    $table .= "<tr class='body_td ths'>
                          <td style='text-align: center;'>" . $i . "</td>
                          <td class='text-center ths'>" . $value['employee_id_no'] . "</td>
                          <td class='ths text-left' >" . $value['employee_fullname'] . "</td>
                          <td class='ths text-left'>" . $value['designation_name'] . "</td>
                          <td class='ths text-left'>" . $value['sbu_name'] . "</td>
                          <td class='ths text-left'>" . $value['department_name'] . "</td>
                          <td class='ths text-left'>" . $value['work_location_name'] . "</td>";
                    $table .= " <td  class='ths text-left'>" . $separationType . "</td>
                          <td class='ths text-center'>" . date("d-M-Y", strtotime($value['employee_joining_date'])) . "</td>
                          <td class='ths text-center'>" . date("d-M-Y", strtotime($value['separation_date'])) . "</td>
                          <td class='ths text-center'>" . date("d-M-Y", strtotime($value['last_working_date'])) . "</td>
                          <td class='ths text-center'>" . number_format($service_length, 2) . "</td>
                          <td class='ths text-left'>" . $value['separation_reason'] . "</td>
                        </tr>";
                }
            }
            $table .= "        </tbody>
                    </table>
                  </div></td></tr></table>";

            return $table;
            // return view('layouts.report', compact('all_data', 'column_data', 'column_name_data', 'date_report', 'company_id', 'company_sbus', 'created_by', 'report_name'));
        } else {
            return "Please Select SBU";
        }
    }


    public function employees_detail_reports($search_option, $checkedattcolsadd)
    {
        //   return $search_option;
        // echo "<pre>";
        // print_r($checkedattcolsadd);
        // exit();
        if (!empty($checkedattcolsadd)) {
            $columnArray = $checkedattcolsadd;
        } else {
            $columnArray = [];
        }

        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        // $employee_id = $employee_ids['employee_id'];


        $employeeSbu = [];
        if (!empty($search_option['employee_sbu'])) {
            $employeeSbu = $search_option['employee_sbu'];
        } else {
            $employeeSbu = $employee_ids['sub'];
        }
        $employeeDepartment = [];
        if (!empty($search_option['employee_department'])) {
            $employeeDepartment = $search_option['employee_department'];
        } else {
            $employeeDepartment = $employee_ids['department'];
        }


        if (count($columnArray) > 0) {
            $columNameArray = array("employee_id_no", "employee_full_name", "designation_name", "department_name", "employee_joining_date", "employee_mobile", "sbu_name", "employee_status");
            $column_data = $allcolumnArray = array_merge($columNameArray, $columnArray);

            $column_name_data = $this->column_real_name($allcolumnArray);
        } else {
            $column_data = $columNameArray = array("employee_id_no", "employee_full_name", "designation_name", "section_name", "department_name", "employee_joining_date", "employee_mobile", "sbu_name", "employee_status");
            $column_name_data = $this->column_real_name($columNameArray);
        }


        $employee_info = Employee::leftjoin('employee_adress_details', 'employees.id', '=', 'employee_adress_details.ead_employee_id')
            ->leftjoin('employee_personal_infos', 'employees.id', '=', 'employee_personal_infos.employee_id')
            // ->leftjoin('employee_educational_qualifications', 'employees.id', '=', 'employee_educational_qualifications.eeq_employee_id')
            ->select(
                'employees.id',
                'employees.employee_reporting_to',
                'employees.employee_id_no',
                'employees.employee_fullname as employee_full_name',
                'employees.employee_sbu',
                'employees.employee_section',
                'employees.employee_department',
                'employees.employee_designation',
                'employees.employee_sub_unit',
                'employees.employee_sub_unit',
                'employees.employee_joining_date',
                'employees.employee_mobile',
                'employees.employee_status',
                'employee_adress_details.permanent_district',
                'employee_personal_infos.employee_marital_status',
                'employee_personal_infos.employee_blood_group',
                'employee_personal_infos.employee_children_no',
                'employee_personal_infos.employee_dob_actual',
                'employee_personal_infos.employee_dob_actual as adob',
                'employee_personal_infos.employee_dob_certificate',
                'employee_personal_infos.employee_dob_certificate as cdob',
                'employees.employee_work_location',
                'employees.employee_sub_section',
                'employees.employee_joining_date',
                'employees.employee_job_grade',
                'employees.employee_group',
                'employees.employee_type',
                'employees.emplyee_category_mgt_non_mgt',
                'employee_personal_infos.employee_gender',
                DB::raw('(DATEDIFF(NOW(), employees.employee_joining_date))/365 as service_length')
            )
            ->valid()
            ->where('employee_joining_date', '<=', date('Y-m-d'))
            ->where('employees.employee_department', '!=', 132)
            ->whereIn('employee_sbu', $employeeSbu)
            ->whereIn('employee_department', $employeeDepartment);

        //   dd();

        if (!empty($search_option['employee_designation'])) {
            $employee_info->whereIn('employee_designation', $search_option['employee_designation']);
        }


        if (!empty($search_option['employee_status'])) {
            if ($search_option['employee_status'] == 'All') {
                $employee_info->whereIn('employee_status', [1, 2, 3, 0]);
            } elseif ($search_option['employee_status'] == 3) {
                $employee_info->where('employee_status', 0);
            } else {
                $employee_info->where('employee_status', $search_option['employee_status']);
            }
        }

        // if (!empty($search_option['employee_designation'])) {
        //     $employee_info->where('employee_designation',$search_option['employee_designation']);
        // }
        // if ( !=0) {
        //     $employee_info->where('employee_designation',$search_option['employee_designation']);
        // }
        // if ($search_option['employee_designation'] !=0) {
        //     $employee_info->where('employee_designation',$search_option['employee_designation']);
        // }
        if (!empty($search_option['employee_section'])) {
            $employee_info->whereIn('employee_section', $search_option['employee_section']);
        }
        if (!empty($search_option['employee_sub_section'])) {
            $employee_info->whereIn('employee_sub_section', $search_option['employee_sub_section']);
        }
        if (!empty($search_option['permanent_district'])) {
            $employee_info->whereIn('permanent_district', $search_option['permanent_district']);
        }
        if ($search_option['employee_marital_status'] != 0) {
            $employee_info->where('employee_marital_status', $search_option['employee_marital_status']);
        }
        if ($search_option['employee_blood_group']) {
            // return $search_option['employee_blood_group'];
            $employee_info->where('employee_blood_group', $search_option['employee_blood_group']);
        }
        if ($search_option['employee_work_location']) {
            // return $search_option['employee_blood_group'];
            $employee_info->whereIn('employee_work_location', $search_option['employee_work_location']);
        }

        if ($search_option['emplyee_category_mgt_non_mgt']) {
            $employee_info->whereIn('emplyee_category_mgt_non_mgt', $search_option['emplyee_category_mgt_non_mgt']);
        }
        if ($search_option['employee_type']) {
            $employee_info->whereIn('employee_type', $search_option['employee_type']);
        }
        if ($search_option['employee_group']) {
            $employee_info->whereIn('employee_group', $search_option['employee_group']);
        }
        if ($search_option['employee_gender'] != 0) {
            $employee_info->where('employee_gender', $search_option['employee_gender']);
        }
        if ($search_option['reporting_to']) {
            $Allreporting_to = Employee::valid()->whereIn('id', $search_option['reporting_to'])->get()->keyBy('employee_id_no')->all();
            $reporting_to = collect($Allreporting_to)->pluck('employee_id_no')->all();
            $employee_info->whereIn('employee_reporting_to', $reporting_to);
        } else {
            if (!empty($checkedattcolsadd)) {
                if (in_array('employee_reporting_to', $checkedattcolsadd)) {
                    $Allreporting_to = Employee::valid()->get()->keyBy('employee_id_no')->all();
                }
            }
        }




        $employee_info = $employee_info->orderBy('employees.employee_sbu')->orderBy('employees.employee_section')->orderBy('employees.employee_department')->get()->toArray();

        // echo"<pre>";
        // print_r($employee_info);
        // exit();
        $employee_ids = collect($employee_info)->pluck('employee_id_no')->toArray();
        $employee_primary_ids = collect($employee_info)->pluck('id')->toArray();

        if (!empty($employee_sbu)) {
            $company_sbus = CompanySbu::valid()->whereIn('id', $employee_sbu)->get()->toArray();
        } else {
            $company_sbus = CompanySbu::valid()->get()->toArray();
        }
        $employee_section = Section::valid()->get()->toArray();
        $employee_sub_section = SubSection::valid()->get()->toArray();
        $employee_district = DistrictModel::get()->toArray();
        $employee_department = Department::valid()->get()->toArray();
        $employee_designation = Designation::valid()->get()->toArray();
        $WorkLocation = WorkLocation::valid()->get()->toArray();
        // $employee_sub_unit = SubUnit::valid()->get()->toArray();
        $jobgrade_data = JobGrade::valid()->get()->toArray();

        if (!empty($checkedattcolsadd)) {
            if (in_array('educational_qualification', $checkedattcolsadd)) {
                $EducationalQualificationListData = EmployeeEducationalQualification::valid()->whereIn('eeq_employee_id', $employee_primary_ids)->get()->toArray();
            }
        }

        // echo"<pre>";
        // print_r($EducationalQualificationListData);
        // exit();

        $emplyeeCategory = [];
        array_push($emplyeeCategory, ['id' => '', 'text' => 'All']);
        array_push($emplyeeCategory, ['id' => '1', 'text' => 'Management']);
        array_push($emplyeeCategory, ['id' => '2', 'text' => 'Non-Management']);

        $employeeGender = [];
        array_push($employeeGender, ['id' => '1', 'text' => 'Female']);
        array_push($employeeGender, ['id' => '2', 'text' => 'Male']);
        array_push($employeeGender, ['id' => '3', 'text' => 'Others']);

        $employeeType = [];
        array_push($employeeType, ['id' => '', 'text' => 'All']);
        array_push($employeeType, ['id' => '1', 'text' => 'Permanent']);
        array_push($employeeType, ['id' => '2', 'text' => 'Probationary']);
        array_push($employeeType, ['id' => '3', 'text' => 'Cotractual']);
        array_push($employeeType, ['id' => '6', 'text' => 'Casual']);
        array_push($employeeType, ['id' => '4', 'text' => 'Temporary']);
        array_push($employeeType, ['id' => '5', 'text' => 'Intern']);
        $employee_group_data = EmployeeGroup::valid()->project()->get();

        // $employeePersonalInfo = EmployeePersonalInfo::valid()->whereIn('employee_id', $employee_primary_ids)->get()->toArray();

        $all_data = $employee_info;
        if (!empty($column_name_data) && $search_option['report_type'] == 2) {
            foreach ($all_data as $key => $value) {
                // echo"<pre>";
                // print_r($value);
                // exit();

                $sbu_name = collect($company_sbus)->where('id', $value['employee_sbu'])->first();
                // $empPersonalinfo = collect($employeePersonalInfo)->where('employee_id', $value['id'])->first();
                $section_name = collect($employee_section)->where('id', $value['employee_section'])->first();
                $department_name = collect($employee_department)->where('id', $value['employee_department'])->first();
                $designation_name = collect($employee_designation)->where('id', $value['employee_designation'])->first();
                $work_locationName = collect($WorkLocation)->where('id', $value['employee_work_location'])->first();
                $jobgradeData = collect($jobgrade_data)->where('id', $value['employee_job_grade'])->first();
                $employeeGenders = collect($employeeGender)->where('id', $value['employee_gender'])->first();


                $emplyee_category = collect($emplyeeCategory)->where('id', $value['emplyee_category_mgt_non_mgt'])->first();
                $employeeTypes = collect($employeeType)->where('id', $value['employee_type'])->first();
                $employee_groupData = collect($employee_group_data)->where('id', $value['employee_group'])->first();
                if (!empty($checkedattcolsadd)) {
                    if (in_array('educational_qualification', $checkedattcolsadd)) {
                        $EducationalName = collect($EducationalQualificationListData)->where('eeq_employee_id', $value['id'])->where('eeq_highest_education', 1)->first();
                        $all_data[$key]['educational_qualification'] = isset($EducationalName['eeq_degree_name']) ? $EducationalName['eeq_degree_name'] : 'No Data!';
                    }
                }

                if (!empty($value['employee_sub_section'])) {
                    $sub_section_name = collect($employee_sub_section)->where('id', $value['employee_sub_section'])->first();
                } else {
                    $sub_section_name = [];
                }
                if (!empty($value['permanent_district'])) {
                    $district_name = collect($employee_district)->where('id', $value['permanent_district'])->first();
                } else {
                    $district_name = [];
                }

                if (!empty($sub_section_name['sub_section_name'])) {
                    $all_data[$key]['sub_section_name'] = isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : 'No Data!';
                } else {
                    $all_data[$key]['sub_section_name'] = isset($value['employee_sub_section']) ? $value['employee_sub_section'] : 'No Data!';
                }
                if (!empty($value['employee_dob_actual']) && $value['employee_dob_actual'] != '0000-00-00') {
                    $all_data[$key]['adob'] = date("d-M-Y", strtotime($value['employee_dob_actual']));
                } else {
                    $all_data[$key]['adob'] = 'No Data!';
                }

                if (!empty($value['employee_dob_certificate']) && $value['employee_dob_certificate'] != '0000-00-00') {
                    $all_data[$key]['cdob'] = date("d-M-Y", strtotime($value['employee_dob_certificate']));
                } else {
                    $all_data[$key]['cdob'] = 'No Data!';
                }
                if (!empty($value['employee_joining_date']) && $value['employee_joining_date'] != '0000-00-00') {
                    $all_data[$key]['employee_joining_date'] = date("d-M-Y", strtotime($value['employee_joining_date']));
                } else {
                    $all_data[$key]['employee_joining_date'] = 'No Data!';
                }
                if ($search_option['reporting_to']) {
                    $all_data[$key]['employee_reporting_to'] = $Allreporting_to[$value['employee_reporting_to']]['employee_fullname'] ?? 'No Data!';
                } else {
                    if (!empty($checkedattcolsadd)) {
                        if (in_array('employee_reporting_to', $checkedattcolsadd)) {
                            $all_data[$key]['employee_reporting_to'] = $Allreporting_to[$value['employee_reporting_to']]['employee_fullname'] ?? 'No Data!';
                        }
                    }
                }


                // echo"<pre>";
                // print_r($value['employee_reporting_to']);
                // exit();


                $all_data[$key]['designation_name'] = isset($designation_name['designation_name']) ? $designation_name['designation_name'] : 'No Data!';
                $all_data[$key]['department_name'] = isset($department_name['department_name']) ? $department_name['department_name'] : 'No Data!';
                $all_data[$key]['section_name'] = isset($section_name['section_name']) ? $section_name['section_name'] : 'No Data!';
                $all_data[$key]['sbu_name'] = isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : 'No Data!';
                $all_data[$key]['employee_work_location'] = isset($work_locationName['work_location_name']) ? $work_locationName['work_location_name'] : 'No Data!';

                $all_data[$key]['employee_blood_group'] = isset($value['employee_blood_group']) ? $value['employee_blood_group'] : 'No Data!';

                $all_data[$key]['permanent_district'] = isset($district_name['name']) ? $district_name['name'] : 'No Data!';
                $all_data[$key]['employee_job_grade'] = isset($jobgradeData['jobgrade_name']) ? $jobgradeData['jobgrade_name'] : 'No Data!';
                $all_data[$key]['employee_mobile'] = isset($value['employee_mobile']) ? $value['employee_mobile'] : 'No Data!';

                $all_data[$key]['emplyee_category_mgt_non_mgt'] = isset($emplyee_category['text']) ? $emplyee_category['text'] : 'No Data!';
                $all_data[$key]['employee_type'] = isset($employeeTypes['text']) ? $employeeTypes['text'] : 'No Data!';
                $all_data[$key]['employee_group'] = isset($employee_groupData['employee_group_name']) ? $employee_groupData['employee_group_name'] : 'No Data!';
                $all_data[$key]['employee_gender'] = isset($employeeGenders['text']) ? $employeeGenders['text'] : 'No Data!';


                if ($value['employee_marital_status'] == 1) {
                    $marital_status = 'Single';
                } elseif ($value['employee_marital_status'] == 2) {
                    $marital_status = 'Married';
                } elseif ($value['employee_marital_status'] == 3) {
                    $marital_status = 'Widowed';
                } elseif ($value['employee_marital_status'] == 4) {
                    $marital_status = 'Divorced';
                } elseif ($value['employee_marital_status'] == 5) {
                    $marital_status = 'Separated ';
                } else {
                    $marital_status = 'No Data !';
                }
                $all_data[$key]['employee_marital_status'] = $marital_status;

                if ($value['employee_status'] == 1) {
                    $employee_status = 'Active';
                } elseif ($value['employee_status'] == 0) {
                    $employee_status = 'Inactive';
                } elseif ($value['employee_status'] == 2) {
                    $employee_status = 'Resign';
                } else {
                    $employee_status = 'Others';
                }

                $all_data[$key]['employee_status'] = $employee_status;

                $employee_dob = isset($value['employee_dob_actual']) ? $value['employee_dob_actual'] : '';
                if (empty($employee_dob) || $employee_dob == '0000-00-00') {
                    $employee_dob = isset($value['employee_dob_certificate']) ? $value['employee_dob_certificate'] : '';
                    if ($employee_dob == 0 || $employee_dob == '0000-00-00') {
                        $employee_dob = '';
                    }
                }


                $employee_dob1 = strtotime($employee_dob);
                if ($employee_dob1) {
                    $bday = new DateTime($employee_dob); // Your date of birth
                    $today = new Datetime(date('Y-m-d'));
                    $diff = $today->diff($bday);
                    $birthDates = $diff->y . '.' . $diff->m;
                    // $birthDates=$diff->y.' Y '. $diff->m.' M '. $diff->d .' D';
                    $birthDates1 = $diff->y;
                } else {
                    $birthDates = 'No Data!';
                    $birthDates1 = 0;
                }

                $all_data[$key]['age'] = $birthDates;
                $all_data[$key]['age1'] = (int) $birthDates1;


                $employee_joining_date = isset($value['employee_joining_date']) ? $value['employee_joining_date'] : '';
                if (empty($employee_joining_date) || $employee_joining_date == '0000-00-00') {
                    $employeoJoining = isset($value['employee_joining_date']) ? $value['employee_joining_date'] : '';
                    if ($employeoJoining == 0 || $employeoJoining == '0000-00-00') {
                        $employeoJoining = '';
                    }
                }
                $employeoJoining = $employee_joining_date;
                // return $employeoJoining;

                $employeoJoining1 = strtotime($employee_joining_date);
                // $date1 = $employee_data['employee_joining_date'];
                $date2 = date('Y-m-d');

                if ($employeoJoining1) {
                    $Joining = new DateTime($employeoJoining); // Your date of birth
                    $today = new Datetime(date('Y-m-d'));
                    $diff = $today->diff($Joining);
                    $JoiningDates = $diff->y . '.' . $diff->m;
                    // $JoiningDates=$diff->y.' Y '. $diff->m.' M '. $diff->d .' D';
                    $JoiningDates1 = $diff->y;
                } else {
                    $JoiningDates = 'No Data!';
                    $JoiningDates1 = 0;
                }
                $all_data[$key]['service_length'] = $JoiningDates;
                $all_data[$key]['service_length1'] = $JoiningDates1;




                // if(!empty($value['employee_dob_actual'])){
                //   $birthDate=date($value['employee_dob_actual']);
                //   if($birthDate=='0000-00-00'){

                //   }else{

                //   }

                // $bday = new DateTime($birthDate); // Your date of birth
                // $today = new Datetime(date('Y-m-d'));
                // $diff = $bday->diff($today);
                // $birthDates=$diff->y.' Y '. $diff->m.' M '. $diff->d .' D';
                //   // $birthDates=$value['employee_dob_actual'];
                // }else{
                //   $birthDates='No Data!';
                // }
                // $all_data[$key]['age']=$employee_dob;
            }/*loop end*/
        }

        //   echo "<pre>";
        // print_r($search_option['age_to']);
        // exit();
        $all_data1 = $all_data;
        if (!empty($search_option['age_from']) || !empty($search_option['age_to'])) {
            if (!empty($search_option['age_from']) && !empty($search_option['age_to'])) {
                $all_data1 = collect($all_data)->where('age1', '!=', 0)->where('age1', '>=', $search_option['age_from'])->where('age1', '<=', $search_option['age_to'])->toArray();
            } elseif (!empty($search_option['age_from'])) {
                $all_data1 = collect($all_data)->where('age1', '!=', 0)->where('age1', '>=', $search_option['age_from'])->toArray();
            } elseif (!empty($search_option['age_to'])) {
                $all_data1 = collect($all_data)->where('age1', '!=', 0)->where('age1', '<=', $search_option['age_to'])->toArray();
            } else {
                $all_data1 = $all_data;
            }
        }

        // else{
        //   $all_data1=$all_data;
        // }
        
        if (!empty($search_option['service_length_from']) || !empty($search_option['service_length_to'])) {
        //     echo "<pre>";
        // print_r([$search_option, $all_data1]);
        // exit();
            if ((!empty($search_option['service_length_from']) || !empty($search_option['service_length_from']) == 0) && !empty($search_option['service_length_to'])) {
                // $all_data1 = collect($all_data1)->where('service_length', '!=', 'No Data!')->where('service_length1', '>=', $search_option['service_length_from'])->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
                $all_data1 = collect($all_data1)->where('service_length', '>=', $search_option['service_length_from'])->where('service_length', '<=', $search_option['service_length_to'])->toArray();
            } elseif (!empty($search_option['service_length_from'])) {
                $all_data1 = collect($all_data1)->where('service_length', '>=', $search_option['service_length_from'])->toArray();
            } elseif (!empty($search_option['service_length_to'])) {
                $all_data1 = collect($all_data1)->where('service_length', '<=', $search_option['service_length_to'])->toArray();
            } else {
                $all_data1;
            }
        }


        // echo "<pre>";
        // print_r($all_data1);
        // exit();
        // else{
        //   $all_data1=$all_data;
        // }
        $totaalEmplyees = count($all_data1);

        $date_report = date("d M,Y");
        $report_name = "Employee Report";


        $company_id = $search_option['employee_sbu'];
        $created_by = Auth::guard('user')->user()->name;

        $table = "<table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'>

           <div   class='section-to-print col-md-12'>
           <table style='width:100%'> <tr> <td style='width:20%'>
           <div class='row' style='margin-left: 21px;'>
            <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";
        if (!empty($company_id)) {
            $companyLogo1 = collect($company_sbus)->where('id', $company_id[0])->first();

            if (!empty($companyLogo1)) {
                if ($companyLogo1['sbu_logo'] != "") {
                    $url = '/company_logo/' . $companyLogo1["sbu_logo"];
                    $table .= '<img src="' . $url . '" style="width:25%;">';
                } else {
                    echo 'No Logo Found';
                }
            } else {
                echo 'No Logo Found';
            }
        } else {
            $url = '/company_logo/group_company_logo.png';
            $table .= '<img src="' . $url . '" style="width:25%;">';
        }
        $table .= " </div></td><td style='width:60%'>
            <div class='col-md-12' style='padding: 0px'>
              <h3 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h3>
              <h4 class='text-center' style='margin:0px;text-align: center!important;'>";
        if (!empty($companyLogo)) {
            echo $companyLogo['sbu_name'];
        }
        $table .= "       </h4>
              <h5 class='text-center' style='text-align: center!important;'>" . $report_name . "</h5>
              <h6 class='text-center' style='text-align: center!important;'>

               Date: " . $date_report . "</h6>
            </div> </td> <td style='width:20%'>
            <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
              <p ><strong> Print Date :</strong>" . date('d M,Y') . "</p>
              <p style='margin-top: -7px'><strong> Created By :</strong> " . $created_by . "</p>
              <p style='margin-top: -7px'><strong> Total Employee :</strong> " . $totaalEmplyees . "</p>
            </div>
            </div></td></tr></table>";

        $table .= "<table  class='table table-bordered' border='0' style='width:100%'>
                  <thead>
                    <tr style='background: #eee;'>
                      <th class='ths' style='padding:2px 10px; width: 5%; text-align: center;vertical-align: middle;'>Sl.</th>";
        foreach ($column_name_data as $key => $value) {
            $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>" . $value . "</th>";
        }
        $table .= "  </tr>
                  </thead>
                  <tbody>";
        $i = 0;
        foreach ($all_data1 as $key => $single_data) {
            $i++;
            $table .= " <tr class='body_td'>
                      <td  class='ths' style='width: 5%; text-align: center;vertical-align: middle;'>" . $i . "</td>";
            foreach ($column_data as $key => $value) {
                // echo"<pre>";
                // print_r($value);

                $valuData = isset($single_data[$value]) ? $single_data[$value] : '';
                $table .= "         <td  class='ths $value' style='vertical-align: middle;'>" . $valuData . "</td>";
            }
            $table .= "  </tr>";
        }
        $table .= "</tbody>
                </table></td></tr></table> ";
        return $table;
    }

    public function yearly_turnover_report($search_option, $checkedattcolsadd)
    {
        if ($search_option['employee_sbu']) {
            $employee_list = new Employee();
            $employee_ids = $employee_list->Employee_id();
            $employee_sbu = [];
            $employee_sbu = [$search_option['employee_sbu']];
            $employee_department = [];
            if ($search_option['employee_department']) {
                $employee_department = [$search_option['employee_department']];
            } else {
                $employee_department = $employee_ids['department'];
            }
            $employee_info = Employee::valid()
                ->select(
                    'employees.id as employee_id',
                    'work_locations.work_location_name',
                    'employees.employee_sbu',
                    'employees.employee_work_location',
                    'employees.employee_joining_date',
                    'employees.emplyee_category_mgt_non_mgt',
                    'resignations.separation_date',
                )
                ->leftJoin('resignations', 'resignations.employee_id', '=', 'employees.id')
                ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
                ->where('employee_work_location', '!=', '')
                ->whereIn('employee_sbu', $employee_sbu)
                ->where('employees.employee_department', '!=', 132)
                ->whereIn('employee_department', $employee_department)
            ;
            if (!empty($search_option['employee_sbu'])) {
                $employee_info->whereIn('employee_sbu', $search_option['employee_sbu']);
            }
            if (!empty($search_option['unit'])) {
                $employee_info->whereIn('employee_unit', $search_option['unit']);
            }
            if (!empty($search_option['sub_unit'])) {
                $employee_info->whereIn('employee_sub_unit', $search_option['sub_unit']);
            }
            if (!empty($search_option['employee_section'])) {
                $employee_info->whereIn('employee_section', $search_option['employee_section']);
            }
            if (!empty($search_option['employee_sub_section'])) {
                $employee_info->whereIn('employee_sub_section', $search_option['employee_sub_section']);
            }
            if ($search_option['employee_work_location']) {
                $employee_info->where('employee_work_location', $search_option['employee_work_location']);
            }
            if ($search_option['employee_designation']) {
                $employee_info->where('employee_designation', $search_option['employee_designation']);
            }
            // $all_data =  (clone $employee_info)->get();
            $all_work_location_data = (clone $employee_info)->select(
                'work_locations.work_location_name',
                'employees.employee_sbu',
                'employees.employee_work_location',
            )->groupBy('employee_work_location')->groupBy('work_locations.work_location_name')->get();

            $company_id = $search_option['employee_sbu'];
            $employeeSbu = [];
            if (!empty($search_option['employee_sbu'])) {
                $employeeSbu = $search_option['employee_sbu'];
            } else {
                $employeeSbu = $employee_ids['sub'];
            }
            if (!empty($employeeSbu)) {
                $company_sbus = CompanySbu::valid()->whereIn('id', $employeeSbu)->get()->toArray();
            } else {
                $company_sbus = CompanySbu::valid()->get()->toArray();
            }

            $table = "<table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'>
                        <div   class='section-to-print col-md-12'>
                        <table style='width:100%'> <tr> <td style='width:20%'>
                        <div class='row' style='margin-left: 21px;'>
                        <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";

            if (!empty($company_id)) {
                $companyLogo1 = collect($company_sbus)->where('id', $company_id[0])->first();
                if (!empty($companyLogo1)) {
                    if ($companyLogo1['sbu_logo'] != "") {
                        $url = '/company_logo/' . $companyLogo1["sbu_logo"];
                        $table .= '<img src="' . $url . '" style="width:25%;">';
                    } else {
                        echo 'No Logo Found';
                    }
                } else {
                    echo 'No Logo Found';
                }
            } else {
                $url = '/company_logo/group_company_logo.png';
                $table .= '<img src="' . $url . '" style="width:25%;">';
            }
            $table .= " </div></td><td style='width:60%'>
                    <div class='col-md-12' style='padding: 0px'>
                        <h4 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h4>
                        <h5 class='text-center' style='margin:0px;text-align: center!important;'>" . $companyLogo1['sbu_name'] ?? '' . "</h5>";
            $table .= "
                        <h5 class='text-center' style='text-align: center!important;'>" . "Monthly Turnover Summary - " . $search_option['turnover_year'] . "</h5>
                        <h6 class='text-center' style='text-align: center!important;'>
                        Date: " . date("d M, Y") . "</h6>
                    </div> </td> <td style='width:20%'>
                        <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
                        <p ><strong> Print Date :</strong>" . date('d M,Y') . "</p>
                        <p style='margin-top: -7px'><strong> Created By :</strong> " . Auth::guard('user')->user()->name . "</p>
                    </div>
                    </div></td></tr></table>
                    <table class='table table-bordered turnover-employee-bg' border='0' style='width:100%'>
                        <thead class='turnover-header'>
                            <tr style='background: #eee;'>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>SL.</th>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>Location</th>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>January</th>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>February</th>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>March</th>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>April</th>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>May</th>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>June</th>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>July</th>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>August</th>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>September</th>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>October</th>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>November</th>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>December</th>
                                <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>YTD</th>
                            </tr>
                        </thead>";
            // $previous_month_last_day = date('Y-m-d', strtotime(date($search_option['turnover_year'].'-'.$search_option['turnover_month'].'-t').'last day of previous month'));
            // $search_month_last_day = date("Y-m-t", strtotime(date($search_option['turnover_year'].'-'.$search_option['turnover_month'].'-d')));
            // $year_start_date = date('Y-m-d', strtotime($search_option['turnover_year'].'/01/01'));
            // $year_end_date = date('Y-m-d', strtotime($search_option['turnover_year'].'/12/31'));
            // return response([$previous_month_last_day, $search_month_last_day]);

            $i = 0;
            foreach ($all_work_location_data as $key => $value) {
                $i++;
                $total_overall_trunover_rate = 0;
                $table .= "
                <tr class='body_td ths'>
                    <td style='text-align: center;'>" . $i . "</td>
                    <td class='text-left ths'>" . $value['work_location_name'] . "</td>";
                for ($j = 1; $j <= 12; $j++) {
                    $previous_month_last_day = date('Y-m-d', strtotime(date($search_option['turnover_year'] . '-' . $j . '-t') . 'last day of previous month'));
                    $search_month_last_day = date("Y-m-t", strtotime(date($search_option['turnover_year'] . '-' . $j . '-d')));

                    $opening_no_emp = (clone $employee_info)->where('employee_work_location', $value['employee_work_location'])->where('employee_joining_date', '<=', $previous_month_last_day)->count();
                    $closing_no_emp = (clone $employee_info)->where('employee_work_location', $value['employee_work_location'])->where('employee_joining_date', '<=', $search_month_last_day)->count();

                    $average_no_employee = round(($opening_no_emp + $closing_no_emp) / 2, 1);

                    $employee_resigning_no = (clone $employee_info)->where('employee_work_location', $value['employee_work_location'])->whereIn('emplyee_category_mgt_non_mgt', [1, 2])->where('employee_status', 2)->whereYear('separation_date', '=', $search_option['turnover_year'])->whereMonth('separation_date', '=', $j)->count();
                    // return response([$opening_no_emp, $closing_no_emp, $average_no_employee, $employee_resigning_no]);
                    $overall_trunover_rate = 0;
                    if ($average_no_employee > 0) {
                        $overall_trunover_rate = round(($employee_resigning_no / $average_no_employee) * 100, 1);
                    }
                    $total_overall_trunover_rate += $overall_trunover_rate;
                    $table .= "<td class='ths' style='padding:2px 10px;
                            text-align: center; border: 1px solid #ddd;'>" . $overall_trunover_rate . "% </td>";
                }
                $table .= "<th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>" . round($total_overall_trunover_rate, 1) . "% </th>";
                $table .= "</tr>";
            }
            $table .= "</tbody>
                    </table>
                  </div></td></tr></table>";
            return $table;
        } else {
            return "Please Select SBU";
        }
    }

    public function monthly_turnover_report($search_option, $checkedattcolsadd)
    {
        if ($search_option['employee_sbu']) {
            $previousdate = new DateTime($search_option['turnover_year'] . '-' . $search_option['turnover_month'] . '-01');
            $previousdate->modify("last day of previous month");
            $previous_month_last_day = $previousdate->format("Y-m-d");

            $searchdate = new DateTime($search_option['turnover_year'] . '-' . $search_option['turnover_month'] . '-01');
            $searchdate->modify("last day of this month");
            $search_month_last_day = $searchdate->format("Y-m-d");

            $opening_emp_date = date('Y-m-d', strtotime($previous_month_last_day));
            $closing_emp_date = date('Y-m-d', strtotime($search_month_last_day));
            $report_header_month_year = date('M\' Y', strtotime($search_month_last_day));
            $employee_list = new Employee();
            $employee_ids = $employee_list->Employee_id();
            $employee_sbu = [];
            $employee_sbu = [$search_option['employee_sbu']];
            $employee_department = [];
            if ($search_option['employee_department']) {
                $employee_department = [$search_option['employee_department']];
            } else {
                $employee_department = $employee_ids['department'];
            }
            $employee_info = Employee::valid()
                ->select(
                    'employees.id as employee_id',
                    'work_locations.work_location_name',
                    'employees.employee_sbu',
                    'employees.employee_work_location',
                    'employees.employee_joining_date',
                    'employees.emplyee_category_mgt_non_mgt',
                    'resignations.separation_date'
                )
                ->leftJoin('resignations', 'resignations.employee_id', '=', 'employees.id')
                ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
                ->where('employee_work_location', '!=', '')
                ->whereIn('employee_sbu', $employee_sbu)
                ->where('employees.employee_department', '!=', 132)
                ->whereIn('employee_department', $employee_department)
            ;
            if ($search_option['employee_designation']) {
                $employee_info->where('employee_designation', $search_option['employee_designation']);
            }
            if (!empty($search_option['employee_sbu'])) {
                $employee_info->whereIn('employee_sbu', $search_option['employee_sbu']);
            }
            if (!empty($search_option['unit'])) {
                $employee_info->whereIn('employee_unit', $search_option['unit']);
            }
            if (!empty($search_option['sub_unit'])) {
                $employee_info->whereIn('employee_sub_unit', $search_option['sub_unit']);
            }
            if (!empty($search_option['employee_section'])) {
                $employee_info->whereIn('employee_section', $search_option['employee_section']);
            }
            if (!empty($search_option['employee_sub_section'])) {
                $employee_info->whereIn('employee_sub_section', $search_option['employee_sub_section']);
            }
            if ($search_option['employee_work_location']) {
                $employee_info->where('employee_work_location', $search_option['employee_work_location']);
            }
            // $all_data =  (clone $employee_info)->get();
            $all_work_location_data = (clone $employee_info)->select(
                'work_locations.work_location_name',
                'employees.employee_sbu',
                'employees.employee_work_location',
            )->groupBy('employee_work_location')->get();

            $company_id = $search_option['employee_sbu'];
            $employeeSbu = [];
            if (!empty($search_option['employee_sbu'])) {
                $employeeSbu = $search_option['employee_sbu'];
            } else {
                $employeeSbu = $employee_ids['sub'];
            }
            if (!empty($employeeSbu)) {
                $company_sbus = CompanySbu::valid()->whereIn('id', $employeeSbu)->get()->toArray();
            } else {
                $company_sbus = CompanySbu::valid()->get()->toArray();
            }

            $table = "<table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'>
                    <div   class='section-to-print col-md-12'>
                    <table style='width:100%'> <tr> <td style='width:20%'>
                    <div class='row' style='margin-left: 21px;'>
                    <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";

            if (!empty($company_id)) {
                $companyLogo1 = collect($company_sbus)->where('id', $company_id[0])->first();
                if (!empty($companyLogo1)) {
                    if ($companyLogo1['sbu_logo'] != "") {
                        $url = '/company_logo/' . $companyLogo1["sbu_logo"];
                        $table .= '<img src="' . $url . '" style="width:25%;">';
                    } else {
                        echo 'No Logo Found';
                    }
                } else {
                    echo 'No Logo Found';
                }
            } else {
                $url = '/company_logo/group_company_logo.png';
                $table .= '<img src="' . $url . '" style="width:25%;">';
            }
            $table .= " </div></td>
                        <td style='width:60%'>
                            <div class='col-md-12' style='padding: 0px'>
                                <h4 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h4>
                                <h5 class='text-center' style='margin:0px;text-align: center!important;'>" . $companyLogo1['sbu_name'] ?? '' . "</h5>";
            $table .= "
                                <h5 class='text-center' style='text-align: center!important;'>" . "Employee Trunover Report for the month of " . $report_header_month_year . "</h5>
                                <h6 class='text-center' style='text-align: center!important;'>
                                Date: " . date("d M, Y") . "</h6>
                            </div>
                        </td>
                        <td style='width:20%'>
                            <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
                                <p ><strong> Print Date :</strong> " . date('d M, Y') . "</p>
                                <p style='margin-top: -7px'><strong> Created By :</strong> " . Auth::guard('user')->user()->name . "</p>
                            </div>
                            </div>
                        </td>
                        </tr>
                        </table>
                        <table class='table table-bordered' border='0' style='width:100%'>
                            <thead class='turnover-header'>
                                <tr style='background: #eee;'>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;' colspan='6'></th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;' colspan='3'>Management Employee</th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;' colspan='3'>Non-management Employee</th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;' colspan='2'>Overall</th>
                                    </tr>
                                    <tr style='background: #eee;'>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>Sl.</th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>Location</th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>Opening No. of Employee " . $opening_emp_date . "</th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>Closing No. of Employee " . $closing_emp_date . "</th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>Average Number of Employee</th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>No. of Issued Appointment Letter</th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>No. of New Joining Employee</th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>No. of Resigned Employee</th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>Turnover Rate</th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>No. of New Joining Employee</th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>No. of Resigned Employee
                                    </th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>Turnover Rate
                                    </th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>Total Separated Employee
                                    </th>
                                    <th class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>No. of Resigned Turnover Rate (%)
                                    </th>
                                </tr>
                            </thead>";
            $i = 0;
            $total_opening_no_emp = 0;
            $total_closing_no_emp = 0;
            $total_average_no_employee = 0;
            $total_issued_appoinment_emp = 0;
            $total_management_employee_joining_no = 0;
            $total_management_employee_resigning_no = 0;
            $total_management_turnover_rate = 0;
            $total_nonmanagement_employee_joining_no = 0;
            $total_nonmanagement_employee_resigning_no = 0;
            $total_nonmanagement_turnover_rate = 0;
            $total_mang_nonmng_separated_employee = 0;
            $total_overall_trunover_rate = 0;
            foreach ($all_work_location_data as $key => $value) {
                $opening_no_emp = (clone $employee_info)->where('employee_work_location', $value['employee_work_location'])->where('employee_joining_date', '<=', $previous_month_last_day)->count();

                $closing_no_emp = (clone $employee_info)->where('employee_work_location', $value['employee_work_location'])->where('employee_joining_date', '<=', $search_month_last_day)->count();

                $average_no_employee = round(($opening_no_emp + $closing_no_emp) / 2, 1);

                $issued_appoinment_emp = (clone $employee_info)->where('employee_work_location', $value['employee_work_location'])->whereMonth('employee_appoinment_date', '=', $search_option['turnover_month'])->whereYear('employee_appoinment_date', '=', $search_option['turnover_year'])->count();


                $management_employee_joining_no = (clone $employee_info)->where('employee_work_location', $value['employee_work_location'])->where('emplyee_category_mgt_non_mgt', 1)->whereMonth('employee_joining_date', '=', $search_option['turnover_month'])->whereYear('employee_joining_date', '=', $search_option['turnover_year'])->count();

                $management_employee_resigning_no = (clone $employee_info)->where('employee_work_location', $value['employee_work_location'])->where('emplyee_category_mgt_non_mgt', 1)->where('employee_status', 2)->whereMonth('separation_date', '=', $search_option['turnover_month'])->whereYear('separation_date', '=', $search_option['turnover_year'])->count();

                $nonmanagement_employee_joining_no = (clone $employee_info)->where('employee_work_location', $value['employee_work_location'])->where('emplyee_category_mgt_non_mgt', 2)->whereMonth('employee_joining_date', '=', $search_option['turnover_month'])->whereYear('employee_joining_date', '=', $search_option['turnover_year'])->count();

                $nonmanagement_employee_resigning_no = (clone $employee_info)->where('employee_work_location', $value['employee_work_location'])->where('emplyee_category_mgt_non_mgt', 2)->where('employee_status', 2)->whereMonth('separation_date', '=', $search_option['turnover_month'])->whereYear('separation_date', '=', $search_option['turnover_year'])->count();

                $overall_trunover_rate = 0;
                if ($average_no_employee > 0) {
                    $overall_trunover_rate = round((($management_employee_resigning_no + $nonmanagement_employee_resigning_no) / $average_no_employee) * 100, 1);
                }

                $management_turnover_rate = $nonmanagement_turnover_rate = 0;
                if ($average_no_employee > 0) {
                    $management_turnover_rate = round($management_employee_resigning_no / $average_no_employee * 100, 1);
                    $nonmanagement_turnover_rate = round($nonmanagement_employee_resigning_no / $average_no_employee * 100, 1);
                }
                $mang_nonmng_separated_employee = $management_employee_resigning_no + $nonmanagement_employee_resigning_no;
                $i++;
                $total_opening_no_emp += $opening_no_emp;
                $total_closing_no_emp += $closing_no_emp;
                $total_average_no_employee += $average_no_employee;
                $total_issued_appoinment_emp += $issued_appoinment_emp;
                $total_management_employee_joining_no += $management_employee_joining_no;
                $total_management_employee_resigning_no += $management_employee_resigning_no;
                $total_management_turnover_rate += $management_turnover_rate;
                $total_nonmanagement_employee_joining_no += $nonmanagement_employee_joining_no;
                $total_nonmanagement_employee_resigning_no += $nonmanagement_employee_resigning_no;
                $total_nonmanagement_turnover_rate += $nonmanagement_turnover_rate;
                $total_mang_nonmng_separated_employee += $mang_nonmng_separated_employee;
                $total_overall_trunover_rate += $overall_trunover_rate;
                $table .= "<tr class='body_td ths'>
                                    <td style='text-align: center;'>" . $i . "</td>
                                    <td class='text-left ths'>" . $value['work_location_name'] . "</td>
                                    <td style='text-align: center;'>" . $opening_no_emp . "</td>
                                    <td style='text-align: center;'>" . $closing_no_emp . "</td>
                                    <td style='text-align: center;'>" . $average_no_employee . "</td>
                                    <td style='text-align: center;'>" . $issued_appoinment_emp . "</td>
                                    <td style='text-align: center;'>" . $management_employee_joining_no . "</td>
                                    <td style='text-align: center;'>" . $management_employee_resigning_no . "</td>
                                    <td style='text-align: center;'>" . $management_turnover_rate . "%</td>
                                    <td style='text-align: center;'>" . $nonmanagement_employee_joining_no . "</td>
                                    <td style='text-align: center;'>" . $nonmanagement_employee_resigning_no . "</td>
                                    <td style='text-align: center;'>" . $nonmanagement_turnover_rate . "%</td>
                                    <td style='text-align: center;'>" . $mang_nonmng_separated_employee . "</td>
                                    <td style='text-align: center;'>" . $overall_trunover_rate . "% </td>
                                </tr>";
            }
            $table .= "<tr class='body_td ths'>
                                    <th  class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;' colspan='2'> Grand Total </th>
                                    <th  class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>" . $total_opening_no_emp . "</th>
                                    <th  class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>" . $total_closing_no_emp . "</th>
                                    <th  class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>" . $total_average_no_employee . "</th>
                                    <th  class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>" . $total_issued_appoinment_emp . "</th>
                                    <th  class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>" . $total_management_employee_joining_no . "</th>
                                    <th  class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>" . $total_management_employee_resigning_no . "</th>
                                    <th  class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>" . $total_management_turnover_rate . "%</th>
                                    <th  class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>" . $total_nonmanagement_employee_joining_no . "</th>
                                    <th  class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>" . $total_nonmanagement_employee_resigning_no . "</th>
                                    <th  class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>" . $total_nonmanagement_turnover_rate . "%</th>
                                    <th  class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>" . $total_mang_nonmng_separated_employee . "</th>
                                    <th  class='ths' style='padding:2px 10px; text-align: center; border: 1px solid #ddd;'>" . $total_overall_trunover_rate . "% </th>
                                </tr>";
            $table .= "</tbody>
                    </table>
                  </div></td></tr></table>";
            return $table;
        } else {
            return "Please Select SBU";
        }
    }


    // public function find_employee_detail($search_option,$checkedattcolsadd){


    //   $columnArray= $checkedattcolsadd;
    //   $employee_list = new Employee();
    //   $employee_ids=$employee_list->Employee_id();
    //   $employee_id=$employee_ids['employee_id'];

    //   $employee_sbu=[];
    //   if($search_option['employee_sbu'] !=0){
    //     $employee_sbu=[$search_option['employee_sbu']];
    //   }else{
    //     $employee_sbu=$employee_ids['sub'];
    //   }
    //   $employee_department=[];
    //   if($search_option['employee_department'] !=0){
    //     $employee_department=[$search_option['employee_department']];
    //   }else{
    //     $employee_department=$employee_ids['department'];
    //   }


    //   if(count($columnArray) > 1){
    //     $columNameArray= array("employee_id_no", "employee_full_name","designation_name","section_name","department_name","employee_joining_date","employee_mobile","sbu_name","employee_status");
    //     $column_data= $allcolumnArray=array_merge($columNameArray,$columnArray);
    //     $column_name_data = $this->column_real_name($allcolumnArray);
    //   }else{
    //    $column_data= $columNameArray= array("employee_id_no", "employee_full_name","designation_name","section_name","department_name","employee_joining_date","employee_mobile","sbu_name","employee_status");
    //    $column_name_data = $this->column_real_name($columNameArray);
    //   }

    //   //  echo"<pre>";
    //   // print_r($search_option);
    //   // exit();
    //    $employee_info=Employee::leftjoin('employee_adress_details','employees.id','=','employee_adress_details.ead_employee_id')
    //    ->leftjoin('employee_personal_infos','employees.id','=','employee_personal_infos.employee_id')
    //    ->select('employees.id','employees.employee_id_no','employees.employee_fullname as employee_full_name','employees.employee_sbu','employees.employee_section','employees.employee_department','employees.employee_designation','employees.employee_sub_unit','employees.employee_sub_unit','employees.employee_joining_date','employees.employee_mobile','employees.employee_status',
    //     'employee_adress_details.permanent_district','employee_personal_infos.employee_marital_status','employee_personal_infos.employee_blood_group','employee_personal_infos.employee_children_no','employee_personal_infos.employee_dob_actual'
    //   )
    //   ->valid()
    //   ->whereIn('employee_sbu',$employee_sbu)
    //   ->whereIn('employee_department',$employee_department);

    //   if ($search_option['employee_designation'] !=0) {
    //       $employee_info->where('employee_designation',$search_option['employee_designation']);
    //   }

    //   $employee_info=$employee_info->orderBy('employees.employee_sbu')->orderBy('employees.employee_section')->orderBy('employees.employee_department')->get()->toArray();


    //   $employee_ids=collect($employee_info)->pluck('employee_id_no')->toArray();
    //   $employee_primary_ids=collect($employee_info)->pluck('id')->toArray();

    //   if (!empty($employee_sbu)) {
    //        $company_sbus=CompanySbu::valid()->where('id',$employee_sbu)->get()->toArray();
    //   }else{
    //        $company_sbus=CompanySbu::valid()->where('id',$employee_ids['sub'])->get()->toArray();
    //   }
    //   $employee_section=Section::valid()->get()->toArray();
    //   $employee_department=Department::valid()->get()->toArray();
    //   $employee_designation=Designation::valid()->get()->toArray();
    //   $employee_sub_unit=SubUnit::valid()->get()->toArray();
    //   $employeePersonalInfo=EmployeePersonalInfo::valid()->whereIn('employee_id',$employee_primary_ids)->get()->toArray();
    //   $employeePersonalInfo=EmployeePersonalInfo::valid()->whereIn('employee_id',$employee_primary_ids)->get()->toArray();


    //   $all_data =$employee_info;
    //   if (!empty($column_name_data) && $search_option['report_type']==2) {
    //     foreach ($all_data as $key => $value) {

    //       $sbu_name=collect($company_sbus)->where('id',$value['employee_sbu'])->first();
    //       $empPersonalinfo=collect($employeePersonalInfo)->where('employee_id',$value['id'])->first();
    //       $section_name=collect($employee_section)->where('id',$value['employee_section'])->first();
    //       $department_name=collect($employee_department)->where('id',$value['employee_department'])->first();
    //       $designation_name=collect($employee_designation)->where('id',$value['employee_designation'])->first();
    //       $sub_section_name=collect($employee_sub_unit)->where('id',$value['employee_sub_unit'])->first();
    //       $all_data[$key]['sub_section_name'] = isset($sub_section_name['sub_section_name'])?$sub_section_name['sub_section_name']:'';
    //       $all_data[$key]['designation_name']= isset($designation_name['designation_name'])?$designation_name['designation_name']:'';
    //       $all_data[$key]['department_name']= isset($department_name['department_name'])?$department_name['department_name']:'';
    //       $all_data[$key]['section_name'] = isset($section_name['section_name'])?$section_name['section_name']:'';
    //       $all_data[$key]['sbu_name']= isset($sbu_name['sbu_name'])?$sbu_name['sbu_name']:'';

    //        if($value['employee_marital_status'] == 1){
    //           $marital_status='Single';
    //         }elseif ($value['employee_marital_status']== 2) {
    //           $marital_status='Single';
    //         }elseif ($value['employee_marital_status']== 3){
    //           $marital_status='Widowed';
    //         }elseif ($value['employee_marital_status']== 4){
    //           $marital_status='Divorced';
    //         }elseif ($value['employee_marital_status']== 5){
    //           $marital_status='Separated ';
    //         }else{
    //           $marital_status='-';
    //         }
    //         $all_data[$key]['employee_marital_status']=$marital_status;

    //         if($value['employee_status'] == 1){
    //            $employee_status='Active';
    //          }elseif ($value['employee_status']== 0) {
    //            $employee_status='Inactive';
    //          }
    //          $all_data[$key]['employee_status']=$employee_status;

    //         if(!empty($value['employee_dob_actual'])){
    //           $birthDate=date($value['employee_dob_actual']);
    //           $bday = new DateTime($birthDate); // Your date of birth
    //           $today = new Datetime(date('Y-m-d'));
    //           $diff = $today->diff($bday);
    //           $birthDates=$diff->y.' years '. $diff->m.' month '. $diff->d .' days';
    //         }else{
    //           $birthDates='0 years, 0 month, 0 days';
    //         }
    //         $all_data[$key]['age']=$birthDates;


    //       }/*loop end*/
    //     }

    //   //   echo "<pre>";
    //   // print_r($all_data);
    //   // exit();


    //   $date_report=date("d M,Y");
    //   $report_name="Employee Report";

    //   // $dailyinfo = $all_data->get()->toArray();
    // //   // echo "<pre>"; print_r($daily_attendance); die();
    //   $company_id = $search_option['employee_sbu'];
    //   $created_by=Auth::guard('user')->user()->name;

    //   return view('layouts.report',compact('all_data','column_data','column_name_data','date_report','company_id','company_sbus','created_by','report_name'));
    // }

    public function reportMail($company_id, $company_sbus, $sbuNames, $report_name, $date_report, $created_by, $column_name_data, $all_data, $column_data)
    {
        $data1['company_id'] = $company_id;
        $data1['company_sbus'] = $company_sbus;
        $data1['sbuNames'] = $sbuNames;
        $data1['report_name'] = $report_name;
        $data1['date_report'] = $date_report;
        $data1['created_by'] = $created_by;
        $data1['column_name_data'] = $column_name_data;
        $data1['all_data'] = $all_data;
        $data1['column_data'] = $column_data;
        // ["abdullah@gemconcorp.com","monirul.sk2012@gmail.com","faruk.cse14@gmail.com"]
        $data["email"] = ["abdullah@gemconcorp.com", "monirul.sk2012@gmail.com", "faruk.cse14@gmail.com"];
        $data["title"] = "Daily Attendance Report";
        $data["body"] = "Please check Your Attach file..";

        // $pdf = app('dompdf.wrapper');
        // $pdf->getDomPDF()->set_option("enable_php", true);
        // // $data1 = ['title' => 'Testing Page Number In Body'];
        // $pdf->loadView('emails.daily_attendance_report', $data1)->setPaper('a4', 'landscape');

        $pdf = PDF::loadView('emails.daily_attendance_report', $data1)->setPaper('a4', 'landscape');

        // return $data1;
        Mail::send('emails.myTestMail', $data, function ($message) use ($data, $pdf) {
            $message->to($data["email"], $data["email"])
                ->subject($data["title"])
                ->attachData($pdf->output(), "text.pdf");
        });
    }
    public function find_periodic_detail_attendance($search_option)
    {
        ini_set('memory_limit', '-1');

        $emplyId = Employee::where('employees.employee_status', 1)->where('employees.employee_department', '!=', 132); // 132 = BOD(Board of Director) department id
        // ->whereIn('employee_department',$employeeDepartments);
        if (!empty($search_option['employee_sbu'])) {
            $emplyId->whereIn('employees.employee_sbu', $search_option['employee_sbu']);
        }
        if (!empty($search_option['employee_department'])) {
            $emplyId->whereIn('employees.employee_department', $search_option['employee_department']);
        }
        if (!empty($search_option['employee_designation'])) {
            $emplyId->whereIn('employees.employee_designation', $search_option['employee_designation']);
        }
        if (!empty($search_option['employee_work_location'])) {
            $emplyId->whereIn('employee_work_location', $search_option['employee_work_location']);
        }
        if (!empty($search_option['unit'])) {
            $emplyId->whereIn('employee_unit', $search_option['unit']);
        }
        if (!empty($search_option['sub_unit'])) {
            $emplyId->whereIn('employee_sub_unit', $search_option['sub_unit']);
        }
        if (!empty($search_option['employee_section'])) {
            $emplyId->whereIn('employee_section', $search_option['employee_section']);
        }

        if (!empty($search_option['employee_sub_section'])) {
            $emplyId->whereIn('employee_sub_section', $search_option['employee_sub_section']);
        }
        $emplyIds = $emplyId->pluck('id')->toarray();


        $resignationsEmpId = DB::table('resignations')->where('resignation_status', 2)->where('effective_date', '>=', $search_option['to_date_formated'])->pluck('employee_id')->toarray();

        $allemplyid = array_merge($emplyIds, $resignationsEmpId);

        $periodic_attendance = DB::table('attendance')->leftJoin('employees', 'employees.id', '=', 'attendance.employee_id')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->select(
                'employees.employee_fullname',
                'employees.employee_joining_date',
                'employees.employee_id_no',
                'company_sbus.sbu_name',
                'departments.department_name',
                'designations.designation_name',
                'work_locations.work_location_name',
                'pstatus',
                'attendance.employee_id',
                'pdate',
                'intime',
                'outime',
                'latetime',
                'start_time',
                'end_time',
                'shift_time',
                'status',
                'remarks'
            )
            ->whereBetween('pdate', [$search_option['from_date_formated'], $search_option['to_date_formated']])
            ->whereIn('employees.id', $allemplyid)
            ->where('employees.employee_status', 1)
            // ->whereDate('pdate', '>=', $search_option['from_date_formated'])
            // ->whereDate('pdate', '<=', $search_option['to_date_formated'])
            // ->where('employees.employee_status', 1)
            ->where('attendance.status', 1)
            ->groupBy('attendance.employee_id')
            ->groupBy('attendance.pdate')
            // ->orderBy('company_sbus.sbu_name','ASC')
            ->orderBy('employees.id', 'ASC');
        // ->orderBy('attendance.intime','ASC');
        if (!empty($search_option['employee_sbu'])) {
            $periodic_attendance->whereIn('employees.employee_sbu', $search_option['employee_sbu']);
        }
        if (!empty($search_option['employee_department'])) {
            $periodic_attendance->whereIn('employees.employee_department', $search_option['employee_department']);
        }
        if (!empty($search_option['employee_designation'])) {
            $periodic_attendance->where('employees.employee_designation', $search_option['employee_designation']);
        }
        if (!empty($search_option['employee_work_location'])) {
            $periodic_attendance->whereIn('employee_work_location', $search_option['employee_work_location']);
        }
        if (!empty($search_option['unit'])) {
            $periodic_attendance->whereIn('employee_unit', $search_option['unit']);
        }
        if (!empty($search_option['sub_unit'])) {
            $periodic_attendance->whereIn('employee_sub_unit', $search_option['sub_unit']);
        }
        if (!empty($search_option['employee_section'])) {
            $periodic_attendance->whereIn('employee_section', $search_option['employee_section']);
        }

        if (!empty($search_option['employee_sub_section'])) {
            $periodic_attendance->whereIn('employee_sub_section', $search_option['employee_sub_section']);
        }
        $periodicinfo = $periodic_attendance->get();

        $emplyids = array_pluck($periodicinfo, 'employee_id');
        // $emplyid=  $emplyids->unique()->all();
        $periodicAttendanceSum =
            // DB::table('attendance')->
            Attendance::select('attendance.employee_id', 'pstatus', 'pdate', DB::raw('count(DISTINCT pdate) AS totalDay'))
                //  ->leftJoin('employees','employees.id','=','attendance.employee_id')
                ->whereDate('pdate', '<=', $search_option['to_date_formated'])
                ->whereDate('pdate', '>=', $search_option['from_date_formated'])
                //  ->whereDate('employees.employee_joining_date', '>=', $search_option['from_date_formated'])
                ->whereIn('employee_id', $emplyids)->groupBy('attendance.employee_id')->groupBy('attendance.pstatus')->get();
        // echo"<pre>";
        // print_r($periodicAttendanceSum);
        // exit();

        $total = $prtot = $abtot = $lttot = $osdtot = $levtot = $whtot = 0;
        $emparr = array();



        foreach ($periodicinfo as $row) {
            // echo"<pre>";
            // print_r($row->employee_fullname);
            // exit();
            $emparr[$row->employee_id]['name'] = $row->employee_fullname;
            $emparr[$row->employee_id]['employee_joining_date'] = $row->employee_joining_date;
            $emparr[$row->employee_id]['official_id'] = $row->employee_id_no;
            $emparr[$row->employee_id]['employee_id'] = $row->employee_id;
            $emparr[$row->employee_id]['compname'] = $row->sbu_name;
            $emparr[$row->employee_id]['deptname'] = $row->department_name;
            $emparr[$row->employee_id]['desgname'] = $row->designation_name;
            $emparr[$row->employee_id]['work_location_name'] = $row->work_location_name;
            $emparr[$row->employee_id]['datearr'][] = $row->pstatus;
            $emparr[$row->employee_id]['remarks'][] = $row->remarks;
            $emparr[$row->employee_id]['datearrlist'][] = date('Y-m-d', strtotime($row->pdate));

            $emparr[$row->employee_id]['prtot'] = 0;
            $emparr[$row->employee_id]['lttot'] = 0;
            $emparr[$row->employee_id]['abtot'] = 0;
            $emparr[$row->employee_id]['whtot'] = 0;
            $emparr[$row->employee_id]['levtot'] = 0;
            $emparr[$row->employee_id]['total'] = 0;
            $emparr[$row->employee_id]['totalpayday'] = 0;


            // $prtots=collect($periodicAttendanceSum)->where('employee_id', $row->employee_id)->where('pstatus', 1)->first();
            // $lttots=collect($periodicAttendanceSum)->where('employee_id', $row->employee_id)->where('pstatus', 2)->first();
            // $abtots=collect($periodicAttendanceSum)->where('employee_id', $row->employee_id)->where('pstatus', 3)->first();
            // $whtotH=collect($periodicAttendanceSum)->where('employee_id', $row->employee_id)->where('pstatus', 4)->first();
            // $whtotW=collect($periodicAttendanceSum)->where('employee_id', $row->employee_id)->where('pstatus', 5)->first();
            // $levtot=collect($periodicAttendanceSum)->where('employee_id', $row->employee_id)->where('pstatus', 6)->first();


            // $prtots=collect($periodicAttendanceSum)->where('employee_id', $row->employee_id)->where('pstatus', 1)->first();
            // $emparr[$row->employee_id]= [
            //   'name'=>$row->employee_fullname,
            //   'official_id' => $row->employee_id_no,
            //   'compname' => $row->sbu_name,
            //   'deptname' => $row->department_name,
            //   'desgname' => $row->designation_name,
            //   'work_location_name' => $row->work_location_name,
            //   'datearr' =>[$row->pstatus],
            //   'remarks' => [$row->remarks],
            //   'datearrlist' => [date('d', strtotime($row->pdate))],

            //    'prtot' => 0,
            //   'lttot' => 0,
            //   'abtot' => 0,
            //   'whtot' => 0,
            //   'levtot' => 0,
            //   'total' =>0,
            //   'totalpayday'=>0

            // 'prtot' => ($prtots['totalDay'] ?? 0),
            // 'lttot' => ($lttots['totalDay'] ?? 0),
            // 'abtot' => ($abtots['totalDay'] ?? 0),
            // 'whtot' => ($whtotH['totalDay'] ?? 0)+($whtotW['totalDay'] ?? 0),
            // 'levtot' => ($levtot['totalDay'] ?? 0),
            // 'total' =>($prtots['totalDay'] ?? 0)+($lttots['totalDay'] ?? 0)+($abtots['totalDay'] ?? 0)+($whtotH['totalDay'] ?? 0)+($whtotW['totalDay'] ?? 0)+($levtot['totalDay'] ?? 0),
            // 'totalpayday' => ($prtots['totalDay'] ?? 0)+($lttots['totalDay'] ?? 0)+($whtotH['totalDay'] ?? 0)+($whtotW['totalDay'] ?? 0)+($levtot['totalDay'] ?? 0),
            // ];

            //


            // foreach ($periodicAttendanceSum as $row1) {
            //   if()

            // }

            // $filtered1 = array_filter($periodicAttendanceSum, function($v){return $v['employee_id'] == $row->employee_id && $v['pstatus'] == 1;});


            // if(in_array($row->employee_id, $periodicinfo) && in_array(1, $periodicinfo)){

            // }

            //  echo"<pre>";
            // print_r($emparr);
            // exit();
            // $filter = $row->employee_id;

            // $new_array = array_filter((array)$periodicAttendanceSum, function($var) use ($filter){
            //     return ($var['employee_id'] == $filter);
            // });
            // $filtered_arr = array_filter((array)$periodicAttendanceSum,function($employee){ return $employee->get_salary() > 12000;});

            // //  echo"<pre>";
            // //  print_r($new_array);
            // //  exit();
            // $prtots=collect($periodicAttendanceSum)->where('employee_id', $row->employee_id)->where('pstatus', 1)->first();
            // $emparr[$row->employee_id]['prtot'] = $prtot =$prtots->totalDay ?? 0;
            // $prtot = collect($periodicinfo)->where('employee_id', $row->employee_id)->where('pstatus', 1)->count();
            // $emparr[$row->employee_id]['lttot'] = $lttot = collect($periodicinfo)->where('employee_id', $row->employee_id)->where('pstatus', 2)->count();
            // $emparr[$row->employee_id]['abtot'] = collect($periodicinfo)->where('employee_id', $row->employee_id)->where('pstatus', 3)->count();
            // $emparr[$row->employee_id]['whtot'] = $whtot = collect($periodicinfo)->where('employee_id', $row->employee_id)->whereIn('pstatus', ['4', '5'])->count();
            // $emparr[$row->employee_id]['levtot'] = $levtot= collect($periodicinfo)->where('employee_id', $row->employee_id)->where('pstatus', 6)->count();
            // $emparr[$row->employee_id]['total'] = collect($periodicinfo)->where('employee_id', $row->employee_id)->count();
            // $emparr[$row->employee_id]['totalpayday'] = $prtot+$lttot+$whtot+$levtot;
        }

        //   dd($emparr);
        // exit();
        $step = '+1 day';
        $format = 'd';

        $dates = array();
        $datesname = array();
        $current = strtotime($search_option['from_date_formated']);
        $last = strtotime($search_option['to_date_formated']);
        $j = 0;

        while ($current <= $last) {
            $dt = date('d', $current);

            if ($j == 0) {
                $datesname[] = [
                    'date' => date('Y-m-d', $current),
                    'dateName' => date('M d', $current)
                ];
                $dates[] = date('Y-m-d', $current);
            } elseif ($dt < $j) {
                $dates[] = date('Y-m-d', $current);
                $datesname[] = [
                    'date' => date('Y-m-d', $current),
                    'dateName' => date('M d', $current)
                ];
            } else {
                $dates[] = date('Y-m-d', $current);
            }
            $datesname[] = [
                'date' => date('Y-m-d', $current),
                'dateName' => date('M d', $current)
            ];

            $current = strtotime($step, $current);
            $j = $dt;
        }

        if ($search_option['employee_department']) {
            $deptname = Department::valid()->where('id', $search_option['employee_department'])->first();
            $deptnameName = $deptname['department_name'];
        } else {
            $deptnameName = "All";
        }
        if (!empty($search_option['employee_sbu'])) {
            $sbuName = CompanySbu::valid()->where('id', $search_option['employee_sbu'])->first();
            $esbuName = $sbuName['sbu_name'];
        } else {
            $sbuName = [];
            $esbuName = "All";
        }

        // return $sbuName;

        $date_report = date("d M,Y", strtotime($search_option['from_date_formated'])) . " To " . date("d M,Y", strtotime($search_option['to_date_formated']));
        $created_by = Auth::guard('user')->user()->name;
        $company_id = isset($search_option['employee_sbu']) ? $search_option['employee_sbu'] : '';


        $table = "<table id='tblCustomers' style='width:100%'>
        <tr>
        <td class='ths'>
        <div class='row'>
        <div class='col-md-12'>
                <div id='divTableDataHolder' class='section-to-print col-md-12'>
                  <div class='row' style='margin-left: 21px;'>
                    <table class='sssssss' style='width:100%'>
                    <tr>
                     <td style='width:20%'>
                    <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";
        if (!empty($company_id)) {
            $companyLogo1 = $sbuName;

            if (!empty($companyLogo1)) {
                if ($companyLogo1['sbu_logo'] != "") {
                    $url = '/company_logo/' . $companyLogo1["sbu_logo"];
                    $table .= '<img src="' . $url . '" style="width:25%;">';
                } else {
                    $table .= "No Logo Found";
                }
            } else {
                $table .= "No Logo Found";
            }
        } else {
            $url = '/company_logo/group_company_logo.png';
            $table .= '<img src="' . $url . '" style="width:25%;">';
        }

        $table .= "</div>
                    </td>
                    <td style='width:60%'>
                    <div class='col-md-12' style='padding: 0px'>
                      <h3 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h3>
                      <h5 class='text-center' style='margin:0px;text-align: center!important;'>" . $esbuName . "</h5>
                      <h6 class='text-center'style='margin:0px;text-align: center!important;'>" . $deptnameName . "</h6>
                      <h6 class='text-center' style='margin:0px;text-align: center!important;'>Periodic Attendance Report Details </h6>
                      <h6 class='text-center' style='margin:0px;text-align: center!important;'>

                       Date:  " . $date_report . "</h6>
                    </div>
                    </td> <td style='width:20%'>
                    <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
                      <p ><strong> Print Date :</strong>" . date('d M,Y') . " </p>
                      <p style='margin-top: -7px'><strong> Created By :</strong> " . $created_by . " </p>
                    </div>
                   </td> </tr></table>
                  </div>
                  <div class='tableFixHead'>
                  <table class='table table-bordered' border='0' style='width:100%'>
                    <thead>
                      <tr style='background: #eee;'>
                        <th class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>Sl.</th>
                        <th  class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>ID</th>
                        <th  class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>Name</th>
                        <th  class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>Designation</th>
                        <th  class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>Department</th>
                        <th  class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>Work Location </th>";
        if (empty($company_id)) {
            $table .= "    <th class='ths'  style='padding:2px 8px; text-align: center;vertical-align: middle;'>Company</th>";
        }
        $table .= "     <th title='Date of Joining' class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>DOJ</th>
                        <th  class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>PR</th>
                        <th  class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>AB</th>
                        <th  class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>LT</th>
                        <!-- <th>OSD</th> -->
                        <th  class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>LV</th>
                        <th  class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>HD</th>
                        <th  class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>Tot</th>
                        <th  class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>PD</th>";
        foreach ($dates as $dat) {
            $DateName = collect($datesname)->where('date', $dat)->first();
            $table .= "     <th  class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'> " . $DateName['dateName'] . "</th>";
        }
        $table .= " </tr>
                    </thead>
                    <tbody>";
        $i = 0;
        foreach ($emparr as $emrow) {
            ++$i;


            $table .= " <tr>
                                <td  class='ths' align='center'> " . $i . " </td>
                                <td  class='ths' class='text-center'>" . $emrow['official_id'] . "</td>
                                <td class='ths' > " . $emrow['name'] . " </td>
                                <td class='ths' > " . $emrow['desgname'] . " </td>
                                <td class='ths' > " . $emrow['deptname'] . " </td>
                                <td class='ths' > " . $emrow['work_location_name'] . " </td>
                                ";

            if (empty($company_id)) {
                $table .= "            <td class='ths' >" . $emrow['compname'] . " </td>";
            }
            $table .= " <td class='ths' > " . date('d M, Y', strtotime($emrow['employee_joining_date'])) . " </td>";
            $prtots = collect($periodicAttendanceSum)->where('employee_id', $emrow['employee_id'])->where('pdate', '>=', $emrow['employee_joining_date'])->where('pstatus', 1)->sum('totalDay');
            $lttots = collect($periodicAttendanceSum)->where('employee_id', $emrow['employee_id'])->where('pdate', '>=', $emrow['employee_joining_date'])->where('pstatus', 2)->sum('totalDay');
            $abtots = collect($periodicAttendanceSum)->where('employee_id', $emrow['employee_id'])->where('pdate', '>=', $emrow['employee_joining_date'])->where('pstatus', 3)->sum('totalDay');
            $whtotH = collect($periodicAttendanceSum)->where('employee_id', $emrow['employee_id'])->where('pdate', '>=', $emrow['employee_joining_date'])->where('pstatus', 4)->sum('totalDay');
            $whtotW = collect($periodicAttendanceSum)->where('employee_id', $emrow['employee_id'])->where('pdate', '>=', $emrow['employee_joining_date'])->where('pstatus', 5)->sum('totalDay');
            $levtot = collect($periodicAttendanceSum)->where('employee_id', $emrow['employee_id'])->where('pdate', '>=', $emrow['employee_joining_date'])->where('pstatus', 6)->sum('totalDay');
            $whtotHt = (int) $whtotH + (int) $whtotW;
            $totals = (int) $prtots + (int) $lttots + (int) $abtots + (int) $whtotW + (int) $whtotH + (int) $levtot;
            $totalPD = (int) $prtots + (int) $lttots + (int) $whtotW + (int) $whtotH + (int) $levtot;

            $table .= "           <td  class='ths' align='center' style='background: #eaeef285;'> " . $prtots . "</td>
                                <td  class='ths' align='center' style='background: #eaeef285;'>  " . $abtots . "</td>
                                <td  class='ths' align='center' style='background: #eaeef285;'>" . $lttots . "</td>
                                <td  class='ths' align='center' style='background: #eaeef285;'> " . $levtot . "</td>
                                <td  class='ths' align='center' style='background: #eaeef285;' > " . $whtotHt . "</td>
                                <td  class='ths' align='center' style='background: #eaeef285;font-weight: 600'>" . $totals . "</td>
                                <td  class='ths' align='center' style='background: #eaeef285;font-weight: 600'>" . $totalPD . "</td>
                                ";
            // echo "<pre>";
            // print_r($emrow);
            // exit();
            foreach ($dates as $key => $value) {
                $color = '';
                // if ($key == 0) {
                $date = $value;
                //  date('d', strtotime($value));
                // } else {
                // $date = $value;
                // }
                if (in_array($date, $emrow['datearrlist']) && $emrow['employee_joining_date'] <= $date) {
                    $key_date_list = array_search($date, $emrow['datearrlist']);
                    if ($emrow['datearr'][$key_date_list] == 2) {
                        $color = '#ffc107!important';
                    } elseif ($emrow['datearr'][$key_date_list] == 3) {
                        $color = '#dc3545!important';
                    } else {
                        $color = '#ffffff';
                    }
                }

                $table .= "           <td class='ths' align='center' style='background:" . $color . ";vertical-align: middle;'>";
                // if ($key == 0) {
                //   $date = date('d', strtotime($value));
                // } else {
                //   $date = $value;
                // }
                //    echo"<pre>";
                //    print_r($date);
                //    echo"<pre>";
                //    print_r($emrow['datearrlist']);
                //    echo"<pre>";
                //    print_r($emrow['employee_joining_date'])

                // exit();
                // if($emrow['employee_joining_date'] = $emrow['datearrlist']){
                if (in_array($date, $emrow['datearrlist']) && $emrow['employee_joining_date'] <= $date) {
                    $key_date_list = array_search($date, $emrow['datearrlist']);
                    if ($emrow['datearr'][$key_date_list] == 1) {
                        $table .= " <span style='color:green;'>P</span>";
                    } elseif ($emrow['datearr'][$key_date_list] == 2) {
                        $table .= "<span style='color:#fff;'>L</span>";
                    } elseif ($emrow['datearr'][$key_date_list] == 3) {
                        $table .= "<span style='color:#fff;'>A</span>";
                    } elseif ($emrow['datearr'][$key_date_list] == 4) {
                        $table .= "W";
                    } elseif ($emrow['datearr'][$key_date_list] == 5) {
                        $table .= "H";
                    } elseif ($emrow['datearr'][$key_date_list] == 6) {
                        // $table .= "LV";
                        $table .= $emrow['remarks'][$key_date_list];
                    }
                } else {
                    $table .= "-";
                }
                // }else{
                //   $table .= "-";
                // }
                $table .= " </td>";
                // echo "<pre>";
                // print_r($table);
                // exit();
            }
            // exit();
        }
        if ($i < 1) {
            $table .= "<h2>No data found</h2>";
        }
        $table .= "
                    </tbody>
                  </table>
                  </div>
                </div>
              </div></div></td></tr></table> ";


        return $table;



        // return view('reports.periodic_detail_report',compact('emparr','search_option','company_id','dates','periodicinfo','deptnameName','created_by','date_report','esbuName','sbuName'));
    }

    public function find_periodic_attendance($search_option)
    {
        $emplyId = Employee::where('employees.employee_status', 1)->where('employees.employee_department', '!=', 132);
        if (!empty($search_option['employee_sbu'])) {
            $emplyId->whereIn('employees.employee_sbu', $search_option['employee_sbu']);
        }
        if (!empty($search_option['employee_department'])) {
            $emplyId->whereIn('employees.employee_department', $search_option['employee_department']);
        }
        if (!empty($search_option['employee_designation'])) {
            $emplyId->whereIn('employees.employee_designation', $search_option['employee_designation']);
        }
        if (!empty($search_option['employee_work_location'])) {
            $emplyId->whereIn('employee_work_location', $search_option['employee_work_location']);
        }
        if (!empty($search_option['unit'])) {
            $emplyId->whereIn('employee_unit', $search_option['unit']);
        }
        if (!empty($search_option['sub_unit'])) {
            $emplyId->whereIn('employee_sub_unit', $search_option['sub_unit']);
        }
        if (!empty($search_option['employee_section'])) {
            $emplyId->whereIn('employee_section', $search_option['employee_section']);
        }

        if (!empty($search_option['employee_sub_section'])) {
            $emplyId->whereIn('employee_sub_section', $search_option['employee_sub_section']);
        }
        $emplyIds = $emplyId->pluck('id')->toarray();


        $resignationsEmpId = DB::table('resignations')->where('resignation_status', 2)->where('effective_date', '>=', $search_option['to_date_formated'])->pluck('employee_id')->toarray();

        $allemplyid = array_merge($emplyIds, $resignationsEmpId);

        $periodic_attendance = DB::table('attendance')->leftJoin('employees', 'employees.id', '=', 'attendance.employee_id')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->select(
                'employees.employee_fullname',
                'employees.employee_joining_date',
                'employees.employee_id_no',
                'company_sbus.sbu_name',
                'departments.department_name',
                'designations.designation_name',
                'work_locations.work_location_name',
                'pstatus',
                'attendance.employee_id',
                'pdate',
                'intime',
                'outime',
                'latetime',
                'start_time',
                'end_time',
                'shift_time',
                'status',
                'remarks'
            )
            ->whereBetween('pdate', [$search_option['from_date_formated'], $search_option['to_date_formated']])
            ->whereIn('employees.id', $allemplyid)
            ->where('employees.employee_status', 1)
            ->where('attendance.status', 1)
            ->groupBy('attendance.employee_id')
            ->groupBy('attendance.pdate')
            ->orderBy('employees.id', 'ASC');
        if (!empty($search_option['employee_sbu'])) {
            $periodic_attendance->whereIn('employees.employee_sbu', $search_option['employee_sbu']);
        }
        if (!empty($search_option['employee_department'])) {
            $periodic_attendance->whereIn('employees.employee_department', $search_option['employee_department']);
        }
        if (!empty($search_option['employee_designation'])) {
            $periodic_attendance->where('employees.employee_designation', $search_option['employee_designation']);
        }
        if (!empty($search_option['employee_work_location'])) {
            $periodic_attendance->whereIn('employee_work_location', $search_option['employee_work_location']);
        }
        if (!empty($search_option['unit'])) {
            $periodic_attendance->whereIn('employee_unit', $search_option['unit']);
        }
        if (!empty($search_option['sub_unit'])) {
            $periodic_attendance->whereIn('employee_sub_unit', $search_option['sub_unit']);
        }
        if (!empty($search_option['employee_section'])) {
            $periodic_attendance->whereIn('employee_section', $search_option['employee_section']);
        }

        if (!empty($search_option['employee_sub_section'])) {
            $periodic_attendance->whereIn('employee_sub_section', $search_option['employee_sub_section']);
        }
        $periodicinfo = $periodic_attendance->get();

        $emplyids = array_pluck($periodicinfo, 'employee_id');
        $periodicAttendanceSum =
            Attendance::select('attendance.employee_id', 'pstatus', 'pdate', DB::raw('count(DISTINCT pdate) AS totalDay'))
                ->whereDate('pdate', '<=', $search_option['to_date_formated'])
                ->whereDate('pdate', '>=', $search_option['from_date_formated'])
                ->whereIn('employee_id', $emplyids)->groupBy('attendance.employee_id')->groupBy('attendance.pstatus')->get();
        $total = $prtot = $abtot = $lttot = $osdtot = $levtot = $whtot = 0;
        $emparr = array();



        foreach ($periodicinfo as $row) {
            $emparr[$row->employee_id]['name'] = $row->employee_fullname;
            $emparr[$row->employee_id]['employee_joining_date'] = $row->employee_joining_date;
            $emparr[$row->employee_id]['official_id'] = $row->employee_id_no;
            $emparr[$row->employee_id]['employee_id'] = $row->employee_id;
            $emparr[$row->employee_id]['compname'] = $row->sbu_name;
            $emparr[$row->employee_id]['deptname'] = $row->department_name;
            $emparr[$row->employee_id]['desgname'] = $row->designation_name;
            $emparr[$row->employee_id]['work_location_name'] = $row->work_location_name;
            $emparr[$row->employee_id]['datearr'][] = $row->pstatus;
            $emparr[$row->employee_id]['remarks'][] = $row->remarks;
            $emparr[$row->employee_id]['datearrlist'][] = date('Y-m-d', strtotime($row->pdate));

            $emparr[$row->employee_id]['prtot'] = 0;
            $emparr[$row->employee_id]['lttot'] = 0;
            $emparr[$row->employee_id]['abtot'] = 0;
            $emparr[$row->employee_id]['whtot'] = 0;
            $emparr[$row->employee_id]['levtot'] = 0;
            $emparr[$row->employee_id]['total'] = 0;
            $emparr[$row->employee_id]['totalpayday'] = 0;
        }

        $step = '+1 day';
        $format = 'd';

        $dates = array();
        $datesname = array();
        $current = strtotime($search_option['from_date_formated']);
        $last = strtotime($search_option['to_date_formated']);
        $j = 0;

        while ($current <= $last) {
            $dt = date('d', $current);

            if ($j == 0) {
                $datesname[] = [
                    'date' => date('Y-m-d', $current),
                    'dateName' => date('M d', $current)
                ];
                $dates[] = date('Y-m-d', $current);
            } elseif ($dt < $j) {
                $dates[] = date('Y-m-d', $current);
                $datesname[] = [
                    'date' => date('Y-m-d', $current),
                    'dateName' => date('M d', $current)
                ];
            } else {
                $dates[] = date('Y-m-d', $current);
            }
            $datesname[] = [
                'date' => date('Y-m-d', $current),
                'dateName' => date('M d', $current)
            ];

            $current = strtotime($step, $current);
            $j = $dt;
        }

        if ($search_option['employee_department']) {
            $deptname = Department::valid()->where('id', $search_option['employee_department'])->first();
            $deptnameName = $deptname['department_name'];
        } else {
            $deptnameName = "All";
        }
        if (!empty($search_option['employee_sbu'])) {
            $sbuName = CompanySbu::valid()->where('id', $search_option['employee_sbu'])->first();
            $esbuName = $sbuName['sbu_name'];
        } else {
            $sbuName = [];
            $esbuName = "All";
        }

        // return $sbuName;

        $date_report = date("d M,Y", strtotime($search_option['from_date_formated'])) . " To " . date("d M,Y", strtotime($search_option['to_date_formated']));
        $created_by = Auth::guard('user')->user()->name;
        $company_id = isset($search_option['employee_sbu']) ? $search_option['employee_sbu'] : '';

        $table = "<table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'><div  class='section-to-print col-md-12'>
                    <div class='col-md-12'>
                     <div class='row' style='margin-left: 21px;'>
                     <table class='sssssss' style='width:100%'> <tr> <td style='width:20%'>
                      <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";

        if (!empty($sbuName)) {
            $companyLogo = $sbuName;
            if (!empty($companyLogo)) {
                if ($companyLogo['sbu_logo'] != "") {
                    $url = '/company_logo/' . $companyLogo["sbu_logo"];
                    $table .= '<img src="' . $url . '" style="width:25%;">';
                } else {
                    $table .= "No Logo Found";
                }
            } else {
                $url = '/company_logo/group_company_logo.png';
                $table .= '<img src="' . $url . '" style="width:25%;">';
            }
        } else {
            $url = '/company_logo/group_company_logo.png';
            $table .= '<img src="' . $url . '" style="width:25%;">';
        }
        $table .= "      </div>
                      </td>
                      <td style='width:60%'>
                      <div class='col-md-12' style='padding: 0px'>
                        <h3 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h3>
                        <h5 class='text-center' style='margin:0px;text-align: center!important;'>" . $esbuName . "</h4>
                        <h6 class='text-center' style='margin:0px;text-align: center!important;'>" . $deptnameName . "</h6>
                        <h6 class='text-center' style='margin:0px;text-align: center!important;' >Periodic Attendance Report</h6>
                        <h6 class='text-center' style='margin:0px;text-align: center!important;'>
                         Date:  " . $date_report . "</h6>
                      </div>
                      </td>
                      <td style='width:60%'>
                      <div class='col-md-12' style='padding: 0px; margin-top: 17px;'>
                        <p ><strong> Print Date :</strong> " . date('d M,Y') . " </p>
                        <p style='margin-top: -7px'><strong> Created By :</strong>" . $created_by . " </p>
                      </div>
                    </div>
                      <br>
                    </div></td> </tr></table>
                    <table class='table table-bordered' border='0' style='width:100%'>
                      <thead>
                        <tr style='background: #eee;'>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Sl.</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>ID</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Name</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Designation</th>
                          <th  class='ths' style='padding:2px 8px; text-align: center;vertical-align: middle;'>Department</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Work Location</th>"
        ;
        if (empty($company_id)) {
            $table .= "            <th class='ths' style='padding:2px 10px; text-align: center;'>Company</th>";
        }
        $table .= "           <th class='ths' style='padding:2px 10px; text-align: center;'>Present</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Absent</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Late</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Leave</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Holiday</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Total</th>
                          <th class='ths' style='padding:2px 10px; text-align: center;'>Pay Days</th>
                        </tr>
                      </thead>";
        $i = 0;
        foreach ($emparr as $key => $single_data) {
            $i++;
            $table .= "           <tr class='body_td ths'>
                          <td class='ths' style='text-align: center;'>" . $i . "</td>
                          <td class='text-center ths'>" . $single_data['official_id'] . "</td>
                          <td  class='ths' >" . $single_data['name'] . "</td>
                          <td class='ths' >" . $single_data['desgname'] . "</td>
                          <td class='ths' > " . $single_data['deptname'] . " </td>
                          <td class='ths' >" . $single_data['work_location_name'] . "</td>";
            if (empty($company_id)) {
                $table .= "           <td class='ths' >" . $single_data['compname'] . "</td>";
            }
            $prtots = collect($periodicAttendanceSum)->where('employee_id', $single_data['employee_id'])->where('pdate', '>=', $single_data['employee_joining_date'])->where('pstatus', 1)->sum('totalDay');
            $lttots = collect($periodicAttendanceSum)->where('employee_id', $single_data['employee_id'])->where('pdate', '>=', $single_data['employee_joining_date'])->where('pstatus', 2)->sum('totalDay');
            $abtots = collect($periodicAttendanceSum)->where('employee_id', $single_data['employee_id'])->where('pdate', '>=', $single_data['employee_joining_date'])->where('pstatus', 3)->sum('totalDay');
            $whtotH = collect($periodicAttendanceSum)->where('employee_id', $single_data['employee_id'])->where('pdate', '>=', $single_data['employee_joining_date'])->where('pstatus', 4)->sum('totalDay');
            $whtotW = collect($periodicAttendanceSum)->where('employee_id', $single_data['employee_id'])->where('pdate', '>=', $single_data['employee_joining_date'])->where('pstatus', 5)->sum('totalDay');
            $levtot = collect($periodicAttendanceSum)->where('employee_id', $single_data['employee_id'])->where('pdate', '>=', $single_data['employee_joining_date'])->where('pstatus', 6)->sum('totalDay');
            $whtotHt = (int) $whtotH + (int) $whtotW;
            $totals = (int) $prtots + (int) $lttots + (int) $abtots + (int) $whtotW + (int) $whtotH + (int) $levtot;
            $totalPD = (int) $prtots + (int) $lttots + (int) $whtotW + (int) $whtotH + (int) $levtot;

            $table .= "           <td  class='ths' align='center' style='background: #eaeef285;'> " . $prtots . "</td>
                            <td  class='ths' align='center' style='background: #eaeef285;'>  " . $abtots . "</td>
                            <td  class='ths' align='center' style='background: #eaeef285;'>" . $lttots . "</td>
                            <td  class='ths' align='center' style='background: #eaeef285;'> " . $levtot . "</td>
                            <td  class='ths' align='center' style='background: #eaeef285;' > " . $whtotHt . "</td>
                            <td  class='ths' align='center' style='background: #eaeef285;font-weight: 600'>" . $totals . "</td>
                            <td  class='ths' align='center' style='background: #eaeef285;font-weight: 600'>" . $totalPD . "</td>
                            ";
        }
        $table .= "        </tbody>
                    </table>
                  </div></td></tr></table>";

        return $table;

        // return view('reports.periodic_report',compact('periodicinfo','emparr','company_id','search_option','created_by','date_report','esbuName','deptnameName','sbuName'));
    }

    public function find_daily_summary($search_option)
    {
        //   if(!empty($search_option['employee_sbu'])){
        //     $company_sbuId=[$search_option['employee_sbu']];
        //   }else{
        //     $company_sbu=CompanySbu::valid()->where('id',$search_option['employee_sbu'])->first();
        //     $company_sbuId=collect($company_sbu)->pluck('id')->toArray();
        //   }



        //   $employee_info=Employee::valid()->where('employee_status',1);
        //                 if (!empty($search_option['employee_sbu'])) {
        //                     $employee_info->where('employee_sbu',$search_option['employee_sbu']);
        //                 }
        //                 if (!empty($search_option['employee_department'])) {
        //                     $employee_info->where('employee_department',$search_option['employee_department']);
        //                 }
        //                 if (!empty($search_option['employee_sbu'])) {
        //                     $employee_info->where('employee_sbu',$search_option['employee_sbu']);
        //                 }
        // $employeeInfo=$employee_info->get()->toArray();
        // $employeeInfoId=collect($employeeInfo)->pluck('id')->toArray();
        // $present_data = DB::table('attendance')
        //               ->leftJoin('employees', 'employees.id', '=', 'attendance.employee_id')
        //               ->whereIn('employee_id',$employeeInfoId)
        //               ->get();
        // $employee_department=Department::valid()->get()->toArray();
        // $employee_designation=Designation::valid()->get()->toArray();



        // ->toArray();

        // echo "<pre>";
        // print_r($company_sbuId);
        // exit();





        // $present_data = DB::table('attendance')
        //               ->leftJoin('employees', 'employees.id', '=', 'attendance.employee_id')
        //               // ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        //               // ->select(DB::raw("count(attendance.id) as present_count"))
        //               ->whereDate('pdate', '=', $search_option['from_date_formated'])
        //               ->where('pstatus', 1);
        //               if (!empty($search_option['employee_sbu'])) {
        //                   $present_data->where('employees.employee_sbu',$search_option['employee_sbu']);
        //               }
        //               if (!empty($search_option['employee_department'])) {
        //                   $present_data->where('employees.employee_department',$search_option['employee_department']);
        //               }
        //               if (!empty($search_option['employee_sbu'])) {
        //                   $present_data->where('employees.employee_sbu',$search_option['employee_sbu']);
        //               }
        // $all_data['present_data'] = $present_data->first();

        // $late_data  = DB::table('attendance')
        //               ->leftJoin('employees', 'employees.id', '=', 'attendance.employee_id')
        //               ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        //               ->select(DB::raw("count(attendance.id) as late_count"))
        //               ->whereDate('pdate', '=', $search_option['from_date_formated'])
        //               ->where('pstatus', 2);
        //               if (!empty($search_option['employee_sbu'])) {
        //                   $present_data->where('employees.employee_sbu',$search_option['employee_sbu']);
        //               }
        // $all_data['late_data'] = $late_data->first();

        // $absent_data = DB::table('attendance')
        //               ->leftJoin('employees', 'employees.id', '=', 'attendance.employee_id')
        //               ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        //               ->select(DB::raw("count(attendance.id) as absent_count"))
        //               ->whereDate('pdate', '=', $search_option['from_date_formated'])
        //               ->where('pstatus', 3);
        //               if (!empty($search_option['employee_sbu'])) {
        //                 $absent_data->where('employees.employee_sbu',$search_option['employee_sbu']);
        //               }
        // $all_data['absent_data'] = $absent_data->first();
        // // print_r($absent_data->getBindings() );

        // $leave_data = DB::table('attendance')
        //               ->leftJoin('employees', 'employees.id', '=', 'attendance.employee_id')
        //               ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        //               ->select(DB::raw("count(attendance.id) as leave_count"))
        //               ->whereDate('pdate', '=', $search_option['from_date_formated'])
        //               ->where('pstatus', 6);
        //               if (!empty($search_option['employee_sbu'])) {
        //                 $leave_data->where('employees.employee_sbu',$search_option['employee_sbu']);
        //               }
        //  $all_data['leave_data'] = $leave_data->first();
        // $all_data['search_option'] = $search_option;

        $table = "
              <table id='tblCustomers' style='width:100%'>
                 <tbody>
                    <tr>
                       <td>
                          <div class='row'>
                             <div class='section-to-print col-md-12'>
                                <table style='width:100%'>
                                   <tbody>
                                      <tr>
                                         <td style='width:20%'>
                                            <div class='row' style='margin-left: 21px;'>
                                               <div class='col-md-12' style='padding: 0px;margin-top: 17px;'> </div>
                                            </div>
                                         </td>
                                         <td style='width:60%'>
                                            <div class='col-md-12' style='padding: 0px'>
                                               <h3 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h3>
                                               <h4 class='text-center' style='margin:0px;text-align: center!important;'>       </h4>
                                               <h5 class='text-center' style='text-align: center!important;'>Daily Attendance Summary Report</h5>
                                               <h6 class='text-center' style='text-align: center!important;'>
                                                  Date: 07 Feb,2021
                                               </h6>
                                            </div>
                                         </td>
                                         <td style='width:20%'>
                                            <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
                                               <p><strong> Print Date :</strong>07 Feb,2021</p>
                                               <p style='margin-top: -7px'><strong> Created By :</strong> Md. Monirul Islam</p>
                                            </div>
                                         </td>
                                      </tr>
                                   </tbody>
                                </table>
                                <table class='table table-bordered' border='0' style='width:100%'>
                                   <thead>
                                      <tr style='background: #eee;'>
                                         <th class='ths' style='padding:2px 10px; width: 5%; text-align: center;vertical-align: middle;'>Sl.</th>
                                         <th class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>ID</th>
                                         <th class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Name</th>
                                         <th class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Designation</th>
                                         <th class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Section</th>
                                         <th class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Department</th>
                                         <th class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Date of Joining</th>
                                         <th class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Mobile Number</th>
                                         <th class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Company</th>
                                         <th class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Status</th>
                                      </tr>
                                   </thead>
                                   <tbody>
                                      <tr class='body_td'>
                                         <td class='ths' style='width: 5%; text-align: center;vertical-align: middle;'>1</td>
                                         <td class='ths' style='vertical-align: middle;'>100149</td>
                                         <td class='ths' style='vertical-align: middle;'>Zakir Ahmed Zakir</td>
                                         <td class='ths' style='vertical-align: middle;'>Chief Financial Officer</td>
                                         <td class='ths' style='vertical-align: middle;'>No Data!</td>
                                         <td class='ths' style='vertical-align: middle;'>Accounts, Finance &amp; New Business(Int.)</td>
                                         <td class='ths' style='vertical-align: middle;'>2009-07-01</td>
                                         <td class='ths' style='vertical-align: middle;'>1713330020</td>
                                         <td class='ths' style='vertical-align: middle;'>Gemcon Group Corporate</td>
                                         <td class='ths' style='vertical-align: middle;'>Active</td>
                                      </tr>
                                      <tr class='body_td'>
                                         <td class='ths' style='width: 5%; text-align: center;vertical-align: middle;'>2</td>
                                         <td class='ths' style='vertical-align: middle;'>100393</td>
                                         <td class='ths' style='vertical-align: middle;'>Asadullhil Galib</td>
                                         <td class='ths' style='vertical-align: middle;'>Executive</td>
                                         <td class='ths' style='vertical-align: middle;'>New Business (Int.)</td>
                                         <td class='ths' style='vertical-align: middle;'>Accounts, Finance &amp; New Business(Int.)</td>
                                         <td class='ths' style='vertical-align: middle;'>2019-11-03</td>
                                         <td class='ths' style='vertical-align: middle;'>01674666516</td>
                                         <td class='ths' style='vertical-align: middle;'>Gemcon Group Corporate</td>
                                         <td class='ths' style='vertical-align: middle;'>Active</td>
                                      </tr>
                                   </tbody>
                                </table>
                             </div>
                          </div>
                       </td>
                    </tr>
                 </tbody>
              </table>
      ";


        return $table;
        // view('reports.daily_summary',compact('all_data'));
    }

    public function find_individual_attendance($search_option)
    {
        $employee_info = Employee::select('*')->valid()
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->select(
                'employees.*',
                'company_sbus.sbu_name',
                'company_sbus.sbu_logo',
                'departments.department_name',
                'sub_units.sub_unit_name',
                'designations.designation_name'
            )
            // ->where('employees.employee_status',1)
            ->where('employees.employee_department', '!=', 132)
            ->where('employees.id', $search_option['employee_ids']);
        // if (!empty($search_option['employee_sbus'])) {
        //  $employee_info->wherein('employee_sbu',$search_option['employee_sbus']);
        // }
        $all_data['employee_info'] = $employee_info->first();

        $all_data['attendance_data'] = DB::table('attendance')
            ->where('employee_id', $search_option['employee_ids'])
            ->whereDate('pdate', '>=', $search_option['from_date_formated'])
            ->whereDate('pdate', '<=', $search_option['to_date_formated'])
            ->groupBy('attendance.pdate')
            ->orderBy('attendance.pdate', 'ASC')
            ->orderBy('attendance.intime', 'ASC')
            ->get()
            ->toArray();
        $all_data['search_option'] = $search_option;

        // echo"<pre>";
        // print_r(  $all_data['attendance_data']);
        // exit();

        $company_id = isset($search_option['employee_sbus']) ? $search_option['employee_sbus'] : '';

        if ($search_option['employee_departments']) {
            $deptname = Department::valid()->where('id', $search_option['employee_departments'])->first();
            $deptnameName = $deptname['department_name'];
        } else {
            if (!empty($all_data['employee_info']['employee_department'])) {
                $deptname = Department::valid()->where('id', $all_data['employee_info']['employee_department'])->first();
                $deptnameName = $deptname['department_name'];
            } else {
                $deptnameName = 'No Data!';
            }
        }
        if (!empty($search_option['employee_sbus'])) {
            $sbuName = CompanySbu::valid()->wherein('id', $search_option['employee_sbus'])->first();
            $esbuName = $sbuName['sbu_name'];
        } else {
            $sbuName = [];
            $esbuName = "All";
        }


        $date_report = date("d M,Y", strtotime($search_option['from_date_formated'])) . " To " . date("d M,Y", strtotime($search_option['to_date_formated']));
        $created_by = Auth::guard('user')->user()->name;
        $table = " <table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'><div id='' class='section-to-print col-md-12'>
                    <div class='col-md-12'>
                      <div class='col-md-12'>
                      <div class='row' style='margin-left: 21px;'>
                      <table class='sssssss' style='width:100%'> <tr> <td style='width:20%'>
                      <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";
        if (!empty($sbuName)) {
            $companyLogo = $sbuName;
            if (!empty($companyLogo)) {
                if ($companyLogo['sbu_logo'] != "") {
                    $url = '/company_logo/' . $companyLogo["sbu_logo"];
                    $table .= '<img src="' . $url . '" style="width:25%;">';
                } else {
                    $table .= "No Logo Found";
                }
            } else {
                $url = '/company_logo/group_company_logo.png';
                $table .= '<img src="' . $url . '" style="width:25%;">';
            }
        } else {
            $url = '/company_logo/group_company_logo.png';
            $table .= '<img src="' . $url . '" style="width:25%;">';
        }
        // dd($all_data['employee_info']);
        if (!empty($all_data['employee_info'])) {
            $names = $all_data['employee_info']['employee_fullname'] . " [ " . $all_data['employee_info']['employee_id_no'];
            $designation_name = $all_data['employee_info']['designation_name'];
            $department_name = $all_data['employee_info']['department_name'];
            $sub_unit_name = $all_data['employee_info']['sub_unit_name'];
            $sbu_name = $all_data['employee_info']['sbu_name'];
        } else {
            $names = 'No Data!';
            $designation_name = 'No Data!';
            $department_name = 'No Data!';
            $sub_unit_name = 'No Data!';
            $sbu_name = 'No Data!';
        }

        $table .= "         <h6  style='margin:0px;'>
                          " . $names . " ]
                        </h6>

                         <p  style='margin:0px;'><strong> Designation: </strong> " . $designation_name . "</p>
                         <p  style='margin:0px;'><strong> Department: </strong> " . $department_name . "</p>
                         <p  style='margin:0px;'><strong> Sub Unit: </strong> " . $sub_unit_name . "</p>

                      </div>
                       </td>
                      <td style='width:60%'>
                      <div class='col-md-12' style='margin:0px;text-align: center!important;'>
                        <h3 class='text-center' sstyle='margin:0px;text-align: center!important;'>Gemcon Group</h3>
                        <h5 class='text-center' style='margin:0px;text-align: center!important;'>" . $sbu_name . "</h5>
                        <h5 class='text-center' style='margin:0px;text-align: center!important;'>" . $deptnameName . "</h5>
                        <h6 class='text-center' style='margin:0px;text-align: center!important;'>Individual Attendance Report</h6>
                        <h6 class='text-center' style='margin:0px;text-align: center!important;'>" . $date_report . "</h6>
                      </div>
                       </td>
                      <td style='width:20%'>
                      <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
                        <p ><strong> Print Date :</strong> " . date('d M,Y') . " </p>
                        <p style='margin-top: -7px'><strong> Created By :</strong> " . $created_by . " </p>
                      </div>
                      </td> </tr></table>

                    </div>
                      <br>
                    </div>
                     <table class='table table-bordered' border='0' style='width:100%'>
                      <thead>
                        <tr style='background: #eee;'>
                          <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Sl.</th>
                          <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Date</th>
                          <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Shift</th>
                          <th class='ths text-center' style='padding:2px 10px; text-align: center;'>In Time</th>
                          <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Out Time</th>
                          <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Late</th>
                          <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Start Time</th>
                          <th class='ths text-center' style='padding:2px 10px; text-align: center;'>End Time</th>
                          <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Assigned OT</th>
                          <th class='ths text-center' style='padding:2px 10px; width: 5%; text-align: center;'>Remarks</th>
                        </tr>
                      </thead>
                      <tbody>";

        $i = 0;
        foreach ($all_data['attendance_data'] as $key => $single_data) {
            $i++;
            $pdate = date('d M Y', strtotime($single_data->pdate));
            $row1 = isset($single_data->pdate) ? $pdate : '';
            $row2 = isset($single_data->intime) ? $single_data->intime : '';
            $row3 = isset($single_data->outime) ? $single_data->outime : '';
            $row4 = isset($single_data->latetime) ? $single_data->latetime : '';
            $row5 = isset($single_data->start_time) ? $single_data->start_time : '';
            $row6 = isset($single_data->end_time) ? $single_data->end_time : '';
            $row7 = isset($single_data->remarks) ? $single_data->remarks : '';
            $row8 = isset($single_data->ot_entry) ? $single_data->ot_entry : '';

            $attendance_setups = DB::table('attendance_setups')
                ->leftJoin('office_time_setups', 'attendance_setups.attendance_office_time', '=', 'office_time_setups.id')
                ->where('start_date', '<=', $single_data->pdate)
                ->where('end_date', '>=', $single_data->pdate)
                ->where('employee_id', $all_data['employee_info']['id'])
                ->first();


            $table .= "        <tr class='body_td'>
                          <td class='ths' style='text-align: center;'>" . $i . "</td>
                          <td class='text-center'>
                            " . $row1 . "
                          </td>
                          <td class='text-center ths'>" . ($attendance_setups ? $attendance_setups->title : '--') . "</td>
                          <td class='text-center ths'>" . $row2 . "</td>
                          <td class='text-center ths'>" . $row3 . "</td>
                          <td class='text-center ths'>" . $row4 . "</td>
                          <td class='text-center ths'>" . $row5 . "</td>
                          <td class='text-center ths'>" . $row6 . "</td>
                          <td class='text-center ths'>" . $row8 . "</td>
                          <td class='text-center ths'>" . $row7 . "</td>
                        </tr>";
        }
        $table .= "          </tbody>
                    </table>
                  </div> </td></tr></table>";

        return $table;

        //   view('reports.individual_report',compact('all_data','deptnameName','sbuName','date_report','created_by','sbuName'));
    }

    public function find_daily_attendance(
        $report_type,
        $att_report_type,
        $employee_sbu,
        $from_date_formated,
        $to_date_formated,
        $checkedattcolsadd,
        $search_option
    ) {
        $column_data = [];
        $columnArray = [];

        // return Location::getLocation(23.757252438644148, 90.37703376580758);

        if (count($column_data) > 1) {
            $column_name_data = $this->column_real_name($columnArray);
        } else {
            $column_data = $columNameArray = [
                "employee_id_no",
                "employee_full_name",
                "designation_name",
                "department_name",
                "employee_work_location",
                "sbu_name",
                "shift_time",
                "in_time",
                "out_time",
                "late",
                "status",
                "remarks"
            ];
        }

        $employee_list = new Employee();
        $employee_id_call = $employee_list->Employee_id();

        $employeeSbu = [];
        if (count($employee_sbu) > 0) {
            $employeeSbu = $employee_sbu;
        } else {
            $employeeSbu = $employee_id_call['sub'];
        }

        $employeeDepartment = [];
        if (!empty($search_option['employee_department'])) {
            $employeeDepartment = $search_option['employee_department'];
        } else {
            $employeeDepartment = $employee_id_call['department'];
        }

        $emplyId = Employee::query()
            ->whereIn('employee_sbu', $employeeSbu)
            ->where('employees.employee_department', '!=', 132)
            ->where('employees.employee_status', 1);

        if (!empty($search_option['employee_designation'])) {
            $emplyId->whereIn('employee_designation', $search_option['employee_designation']);
        }

        if (!empty($search_option['employee_work_location'])) {
            $emplyId->whereIn('employee_work_location', $search_option['employee_work_location']);
        }

        if (!empty($search_option['unit'])) {
            $emplyId->whereIn('employee_unit', $search_option['unit']);
        }

        if (!empty($search_option['sub_unit'])) {
            $emplyId->whereIn('employee_sub_unit', $search_option['sub_unit']);
        }

        if (!empty($search_option['employee_section'])) {
            $emplyId->whereIn('employee_section', $search_option['employee_section']);
        }

        if (!empty($search_option['employee_sub_section'])) {
            $emplyId->whereIn('employee_sub_section', $search_option['employee_sub_section']);
        }

        if (!empty($search_option['employee_department'])) {
            $emplyId->whereIn('employee_department', $search_option['employee_department']);
        }

        if (!empty($search_option['employee_designation'])) {
            $emplyId->whereIn('employee_designation', $search_option['employee_designation']);
        }
        if (!empty($search_option['employee_ids'])) {
            $emplyId->where('employees.id', $search_option['employee_ids']);
        }

        if (!empty($search_option['employee_ids'])) {
            $emplyId->where('employees.id', $search_option['employee_ids']);
        }

        $emplyIds = $emplyId->pluck('id')->toarray();

        $resignationsEmpId = DB::table('resignations')
            ->where('resignation_status', 2)
            ->where('effective_date', '>=', $from_date_formated)
            ->pluck('employee_id')
            ->toarray();

        $allemplyid = array_merge($emplyIds, $resignationsEmpId);
        $attendanceTime = AttendanceSetup::query()
            ->select(
                'attendance_setups.*',
                'office_time_setups.office_start_time as office_start_time',
                'office_time_setups.title',
                'office_time_setups.office_end_time as office_end_time',
                'office_time_setups.lateConsiderTime as lateConsiderTime',
                'office_time_setups.office_type as office_type',
                'office_time_setups.type as type',
                'office_time_end_date',
                'office_time_start_date'
            )
            ->leftJoin(
                'office_time_setups',
                'office_time_setups.id',
                '=',
                'attendance_setups.attendance_office_time'
            )
            ->whereIn('attendance_setups.employee_id', $allemplyid)
            ->where('start_date', '<=', $from_date_formated)
            ->where('end_date', '>=', $from_date_formated);

        if (!empty($search_option['OfficeTime'])) {
            $attendanceTime->whereIn('attendance_setups.attendance_office_time', $search_option['OfficeTime']);
        }

        $attendanceTime = $attendanceTime->get();

        if (!empty($search_option['OfficeTime'])) {
            $AllemplyIds = collect($attendanceTime)->pluck('employee_id')->toarray();
        } else {
            $AllemplyIds = $allemplyid;
        }

        $employee_info = Employee::query()
            ->select(
                'employees.id',
                'employees.employee_id_no',
                'employees.employee_fullname as employee_full_name',
                'employees.employee_sbu',
                'employees.employee_section',
                'employees.employee_department',
                'employees.employee_designation',
                'employees.employee_sub_unit',
                'employees.employee_sub_unit',
                'employees.employee_work_location',
                'employees.employee_section',
                'employees.employee_sub_section',
                'employees.employee_department',
                'employees.employee_designation'
            )
            ->valid()
            ->whereIn('employee_sbu', $employeeSbu)
            ->where('employees.employee_department', '!=', 132)
            ->WhereIn('id', $AllemplyIds);

        if (!empty($search_option['employee_designation'])) {
            $employee_info->whereIn('employee_designation', $search_option['employee_designation']);
        }

        if (!empty($search_option['employee_work_location'])) {
            $employee_info->whereIn('employee_work_location', $search_option['employee_work_location']);
        }

        if (!empty($search_option['unit'])) {
            $employee_info->whereIn('employee_unit', $search_option['unit']);
        }

        if (!empty($search_option['sub_unit'])) {
            $employee_info->whereIn('employee_sub_unit', $search_option['sub_unit']);
        }

        if (!empty($search_option['employee_section'])) {
            $employee_info->whereIn('employee_section', $search_option['employee_section']);
        }

        if (!empty($search_option['employee_sub_section'])) {
            $employee_info->whereIn('employee_sub_section', $search_option['employee_sub_section']);
        }

        if (!empty($search_option['employee_department'])) {
            $employee_info->whereIn('employee_department', $search_option['employee_department']);
        }

        if (!empty($search_option['employee_designation'])) {
            $employee_info->whereIn('employee_designation', $search_option['employee_designation']);
        }

        if (!empty($search_option['employee_ids'])) {
            $employee_info->where('employees.id', $search_option['employee_ids']);
        }

        $employee_info = $employee_info
            ->orderBy('employees.employee_id_no')
            ->orderBy('employees.employee_sbu')
            ->orderBy('employees.employee_section')
            ->orderBy('employees.employee_department')
            ->get();


        $employee_ids = collect($employee_info)->pluck('employee_id_no')->toArray();
        $employee_primary_ids = collect($employee_info)->pluck('id')->toArray();

        $employee_ids = collect($employee_info)->pluck('employee_id_no')->toArray();
        $employee_primary_ids = collect($employee_info)->pluck('id')->toArray();

        if (!empty($employeeSbu)) {
            $company_sbus = CompanySbu::valid()->whereIn('id', $employeeSbu)->get()->toArray();
            $sbuName = collect($company_sbus)->first();

            $sbuNames = $sbuName['sbu_name'];
        } else {
            $company_sbus = CompanySbu::valid()->whereIn('id', $employee_id_call['sub'])->get()->toArray();
            $sbuNames = 'All';
        }

        $employee_section = Section::valid()->whereIn('id', $employee_id_call['section'])->get()->toArray();
        $employee_department = Department::valid()->whereIn('id', $employeeDepartment)->get()->toArray();
        $employee_designation = Designation::valid()->whereIn('id', $employee_id_call['designation'])->get()->toArray();
        $employee_sub_unit = SubUnit::valid()->whereIn('id', $employee_id_call['subunit'])->get()->toArray();
        $WorkLocation = WorkLocation::valid()->get()->toArray();
        $employee_sub_unit = SubUnit::valid()->get()->toArray();

        $attendance_data = DB::table('attendance_log')
            ->whereIn('employee_id', $employee_ids)
            ->where('TransactionDate', $from_date_formated)
            ->where('valid', '=', 1)
            ->get()->toArray();

        $manulAttendance = DB::table('manual_attendances')
            ->whereIn('employee_id_no', $employee_ids)
            ->where('manual_attendance_date', $from_date_formated)
            ->where('manual_attendance_status', 1)
            ->where('attendance_type', 1)
            ->where('valid', '=', 1)
            ->get()->toArray();
        $manulAbsent = DB::table('manual_attendances')
            ->whereIn('employee_id_no', $employee_ids)
            ->where('manual_attendance_date', $from_date_formated)
            ->where('manual_attendance_status', 1)
            ->where('attendance_type', 2)
            ->where('valid', '=', 1)
            ->get()->toArray();

        $approve_late_request = DB::table('late_approve_requests')
            ->whereIn('employee_id', $employee_primary_ids)
            ->where('late_date', $from_date_formated)
            ->where('late_approve_status', '=', 2)
            ->get();

        $company_sbu_data = DB::table('company_sbus')->get();

        $holidayFind = DB::table('holiday_setups')
            ->leftJoin(
                'holiday_permissions',
                'holiday_permissions.holiday_id',
                '=',
                'holiday_setups.id'
            )
            ->select('holiday_setups.*', 'holiday_permissions.*')
            ->where('holiday_start_date', '<=', $from_date_formated)
            ->where('holiday_end_date', '>=', $from_date_formated)
            ->where('sbu_permission', $employee_sbu)
            ->get();

        $holiday_find = array();

        if ($holidayFind) {
            foreach ($holidayFind as $key => $value) {
                $period_holiday = CarbonPeriod::create($value->holiday_start_date, $value->holiday_end_date);
                foreach ($period_holiday as $date) {
                    array_push($holiday_find, $date->format('Y-m-d'));
                }
            }
        }

        $indLeaveInfo1 = DB::table('leave_applications')
            ->leftJoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
            ->where('leave_from_date', '<=', $from_date_formated)
            ->where('leave_to_date', '>=', $from_date_formated)
            ->whereIn('employee_id', $employee_primary_ids)
            ->where('leave_applications.leave_apply_status', '=', 2)
            ->get();

        $attendance_dataNew = [];
        $attendances = [];

        foreach ($employee_info as $key => $value) {
            // dd($value);
            $approve_late_request = collect($approve_late_request)
                ->where('late_request_id', $value->id)
                ->first();

            $approve_late_find = array();
            if ($approve_late_request) {
                foreach ($approve_late_request as $date) {
                    array_push($approve_late_find, $date->late_date);
                }
            }

            $companySbu_data = collect($company_sbu_data)
                ->where('id', $value->employee_sbu)
                ->first();

            $weekend = explode(",", $companySbu_data->weekend);

            $attendance_time = collect($attendanceTime)
                ->where('employee_id', $value->id)
                ->where('start_date', '<=', $from_date_formated)
                ->where('end_date', '>=', $from_date_formated)
                ->first();

            if (empty($attendance_time)) {
                $attendance_time = $companySbu_data;
                $attendance_time->office_type = 1;
                $attendance_time->type = 1;
                $attendance_time->title = 'Default Office Time';
            }

            $holiday_permission = [];

            $holiday_permission = collect($holidayFind)
                ->where('holiday_start_date', '<=', $from_date_formated)
                ->where('holiday_end_date', '>=', $from_date_formated);

            foreach ($holiday_permission as $key => $permission) {
                if (!empty($permission->sbu_permission) && $permission->sbu_permission == $value->employee_sbu) {
                    $holiday_permission = [1];
                } elseif (!empty($permission->unit_permission) && ($permission->unit_permission == $value->employee_unit)) {
                    $holiday_permission = [1];
                } elseif (!empty($permission->sub_unit_permission) && $permission->sub_unit_permission == $value->employee_sub_unit) {
                    $holiday_permission = [1];
                } elseif (!empty($permission->department_permission) && $permission->department_permission == $value->employee_department) {
                    $holiday_permission = [1];
                } elseif (!empty($permission->section_permission) && $permission->section_permission == $value->employee_section) {
                    $holiday_permission = [1];
                } elseif (!empty($permission->sub_section_permission) && $permission->sub_section_permission == $value->employee_sub_section) {
                    $holiday_permission = [1];
                } elseif (!empty($permission->work_location_permission) && $permission->work_location_permission == $value->employee_work_location) {
                    $holiday_permission = [1];
                } elseif (!empty($permission->employee_id) && $permission->employee_id == $value->id) {
                    $holiday_permission = [1];
                } else {
                    $holiday_permission = [];
                }
            }

            if (count($holiday_permission) == 0) {
                $holiday_find = '';
            }

            if (count($holiday_permission) > 0) {
                if (!empty($attendance_setups_data)) {
                    $holiday_find = '';
                }
            }

            // Ramadan time setup task by Faruk Khan Start
            $ramadan_office_time = OfficeTimeSetup::valid()->where('type', 1)->where('office_time_status', 1)->first(); // for Ramadan office time profile attendance view purposes
            // if($value1->format("Y-m-d") == "2024-03-12"){
            //     dd($attendance_time, $attendance_setups_data,  $ramadan_office_time);

            // }
            // dd($value1->format("Y-m-d"));
            if (empty($attendance_setups_data) && !empty($ramadan_office_time) && ($from_date_formated >= $ramadan_office_time->office_time_start_date) && ($from_date_formated <= $ramadan_office_time->office_time_end_date)) {

                $attendance_time->office_start_time = isset($ramadan_office_time->office_start_time) ? $ramadan_office_time->office_start_time : '00:00:00';

                $attendance_time->office_end_time = isset($ramadan_office_time->office_end_time) ? $ramadan_office_time->office_end_time : '00:00:00';

                $attendance_time->lateConsiderTime = isset($ramadan_office_time->lateConsiderTime) ? $ramadan_office_time->lateConsiderTime : '00:00:00';

            } elseif (!empty($ramadan_office_time) && $from_date_formated < $ramadan_office_time->office_time_start_date) {
                if (!empty($attendance_time) && !empty($attendance_time->start_date) && ($from_date_formated >= $attendance_time->start_date) && ($from_date_formated <= $attendance_time->end_date)) {
                    $attendance_time->office_start_time = isset($attendance_time->office_start_time) ? $attendance_time->office_start_time : '00:00:00';
                    $attendance_time->office_end_time = isset($attendance_time->office_end_time) ? $attendance_time->office_end_time : '00:00:00';
                } else {
                    $attendance_time->office_start_time = isset($attendance_time->office_start_time) ? $attendance_time->office_start_time : '00:00:00';
                    $attendance_time->office_end_time = isset($attendance_time->office_end_time) ? $attendance_time->office_end_time : '00:00:00';
                }
            } else {
                $attendance_time->office_start_time = isset($attendance_time->office_start_time) ? $attendance_time->office_start_time : '00:00:00';
                $attendance_time->office_end_time = isset($attendance_time->office_end_time) ? $attendance_time->office_end_time : '00:00:00';
            }
            // Ramadan time setup task by Faruk Khan End

            $sbu_name = collect($company_sbus)->where('id', $value->employee_sbu)->first();
            $WorkLocations = collect($WorkLocation)->where('id', $value->employee_work_location)->first();
            $section_name = collect($employee_section)->where('id', $value->employee_section)->first();
            $department_name = collect($employee_department)->where('id', $value->employee_department)->first();
            $designation_name = collect($employee_designation)->where('id', $value->employee_designation)->first();
            $sub_section_name = collect($employee_sub_unit)->where('id', $value->employee_sub_unit)->first();


            $indLeaveInfo = collect($indLeaveInfo1)->where('employee_id', $value->id)->toArray();
            $ind_leave_info = array();
            if ($indLeaveInfo) {
                foreach ($indLeaveInfo as $key => $value_a) {
                    $period_live = CarbonPeriod::create($value_a->leave_from_date, $value_a->leave_to_date);
                    foreach ($period_live as $date) {
                        array_push($ind_leave_info, $date->format('Y-m-d'));
                    }
                }
            }

            $start_timeall = date('A', strtotime($attendance_time->office_start_time));
            $end_timeall = date('A', strtotime($attendance_time->office_end_time));
            if ($start_timeall == 'PM' && $end_timeall == 'AM') {
                $date = new DateTime($from_date_formated);
                $date->modify('+1 day');
                $lastDate = $date->format('Y-m-d');
                $endTime = date('h:i A', strtotime($attendance_time->office_end_time));
                $startTime = date('h:i A', strtotime($attendance_time->office_start_time));

                if (date('A') != 'PM') {
                    $intime = collect(collect($attendance_data)->where('TransactionDate', $from_date_formated)
                        ->where('ServerRecordTime', '<=', strtotime($endTime))
                        // ->where('ServerRecordTime','<=',strtotime($startTime))
                        ->where('employee_id', $value->employee_id_no)->sortByDesc('ServerRecordTime')->values()->all())->first();
                } else {
                    $intime = collect(collect($attendance_data)->where('TransactionDate', $from_date_formated)
                        // ->where('ServerRecordTime','<=',strtotime($endTime))
                        // ->where('ServerRecordTime','<=',strtotime($startTime))
                        ->where('employee_id', $value->employee_id_no)->sortByDesc('ServerRecordTime')->values()->all())->first();
                }
                if (!empty($intime)) {
                    if (date('A', strtotime($intime->TransactionTime)) == 'PM') {
                        $intime = $intime;
                    } else {
                        $intime = [];
                    }
                } else {
                    $intime = [];
                }

                // print_r($endTime);
                // print_r(date('A'));
                //  echo "<pre>";
                // print_r($outtime);
                // exit();
                $outtime = DB::table('attendance_log')
                    // ->where('employee_id',$value->id)
                    // ->where('ServerRecordTime','<=', strtotime($attendance_time->office_start_time))
                    ->where('TransactionDate', $lastDate)
                    ->where('employee_id', $value->employee_id_no)
                    // ->where('employee_id','9000081')
                    ->where('valid', '=', 1)
                    ->orderBy('ServerRecordTime', 'ASC')
                    ->first();

                //        echo "<pre>";
                // print_r($intime);
                // exit();
                // collect(collect($attendance_data)->where('TransactionDate',$lastDate)->where('TransactionTime', '<=', $start_timeall)->where('employee_id',$value->employee_id_no)->sortByDesc('id')->values()->all())->first();
            } else {
                $intime = collect(collect($attendance_data)->where('TransactionDate', $from_date_formated)->where('employee_id', $value->employee_id_no)->sortBy('id')->values()->all())->first();
                $outtime = collect(collect($attendance_data)->where('TransactionDate', $from_date_formated)->where('employee_id', $value->employee_id_no)->sortByDesc('id')->values()->all())->first();
            }


            // echo "<pre>";
            // print_r(strtotime('05:47 AM '));
            //   echo "<pre>";
            //   print_r($attendance_data);
            //   exit();

            //$timestr=1648043569;
            // date_default_timezone_set('Asia/Dhaka');
            // $currentTime = DateTime::createFromFormat( 'U', $timestr );
            //$datetime=$currentTime->setTimezone(new DateTimeZone('UTC'));
            // if(1648159200 <= 1648102651){
            //   echo "string";
            // }



            // exit();
            // $intime=collect(collect($attendance_data)->where('TransactionDate',$from_date_formated)->where('employee_id',$value->employee_id_no)->sortBy('id')->values()->all())->first();
            // $outtime=collect(collect($attendance_data)->where('TransactionDate',$from_date_formated)->where('employee_id',$value->employee_id_no)->sortByDesc('id')->values()->all())->first();

            $manulAttendances = collect($manulAttendance)
                ->where('manual_attendance_date', $from_date_formated)
                ->where('employee_id_no', $value->employee_id_no)
                ->first();

            $manulAbsents = collect($manulAbsent)
                ->where('manual_attendance_date', $from_date_formated)
                ->where('employee_id_no', $value->employee_id_no)
                ->first();

            $office_start_time = isset($attendance_time->office_start_time) ? $attendance_time->office_start_time : '00:00:00';
            $office_end_time = isset($attendance_time->office_end_time) ? $attendance_time->office_end_time : '00:00:00';

            $Toffice_time = strtotime($office_end_time) - strtotime($office_start_time);

            if (!empty($attendance_time)) {
                if (!empty($manulAttendances)) {
                    $intimes = $manulAttendances->manual_start_time;
                    $outtimes = $manulAttendances->manual_end_time;
                    // if(!empty($attendance_time->lateConsiderTime)){
                    //      $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                    //  }else{
                    //      $lateConsiderTime=strtotime($office_start_time);
                    //  }
                    if (!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) != date('H:i', strtotime('00:00:00'))) {
                        $lateConsiderTime = date('H:i', strtotime($attendance_time->lateConsiderTime));
                    } else {
                        $lateConsiderTime = date('H:i', strtotime($office_start_time));
                    }

                    if (date('H:i', strtotime($intimes)) <= $lateConsiderTime) {
                        $late_time = '00:00';
                        $status = "P";
                        $statusId = 1;
                        $remarks = "";
                    } else {
                        if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
                            $late_time = strtotime($intimes) - strtotime($office_start_time);
                            $late_time = date('H:i', $late_time);
                            $status = "L(A)";
                            $statusId = 1;
                            $remarks = "Late Approved";
                        } else {
                            $late_time = strtotime($intimes) - strtotime($office_start_time);
                            $late_time = date('H:i', $late_time);
                            $status = "L";
                            $statusId = 2;
                            $remarks = "";
                        }
                    }

                    $work_time = strtotime($outtimes) - strtotime($intimes);

                    if ($work_time > 0) {
                        if ($work_time - $Toffice_time > 0) {
                            if ((($work_time - $Toffice_time) / 3600) <= 0.30) {
                                $ot = ($work_time - $Toffice_time) / 3600;
                            } else {
                                $ot = 0;
                            }
                        } else {
                            $ot = 0;
                        }
                    } else {
                        $ot = 0;
                    }


                    $attendances = [
                        "employee_id_no" => $value['employee_id_no'],
                        "employee_full_name" => $value['employee_full_name'],
                        "employee_sub_unit" => $value['employee_sub_unit'],
                        "sub_section_name" => isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : '',
                        "designation_name" => isset($designation_name['designation_name']) ? $designation_name['designation_name'] : '',
                        "department_name" => isset($department_name['department_name']) ? $department_name['department_name'] : '',
                        "department_id" => isset($department_name['id']) ? $department_name['id'] : '',
                        'department_priority' => isset($department_name['priority']) ? $department_name['priority'] : '',
                        "section_name" => isset($section_name['section_name']) ? $section_name['section_name'] : '',
                        "sbu_name" => isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : '',
                        "employee_work_location" => isset($WorkLocations['work_location_name']) ? $WorkLocations['work_location_name'] : '',
                        "machineno" => 0,
                        "uploadid" => 0,
                        "employee_id" => $value->id,
                        "employee_card_no" => $value->employee_id_no,
                        "pdate" => $from_date_formated,
                        "in_time" => date('h:i A', strtotime($intimes)),
                        "out_time" => date('h:i A', strtotime($outtimes)),
                        "late" => $late_time,
                        "check_in_location" => '',
                        "check_out_location" => '',
                        "start_time" => date('h:i A', strtotime($office_start_time)),
                        "end_time" => date('h:i A', strtotime($office_end_time)),
                        "pstatus" => $statusId,
                        "status" => $status,
                        "remarks" => $remarks,
                        "shift_time" => date('h:i A', strtotime($office_start_time)) . " - " . date('h:i A', strtotime($office_end_time)),
                        "shift_name" => $attendance_time->title,
                        "ot" => $ot,
                    ];
                } elseif (!empty($manulAbsents)) {
                    $attendances = [
                        "employee_id_no" => $value['employee_id_no'],
                        "employee_full_name" => $value['employee_full_name'],
                        "employee_sub_unit" => $value['employee_sub_unit'],
                        "sub_section_name" => isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : '',
                        "designation_name" => isset($designation_name['designation_name']) ? $designation_name['designation_name'] : '',
                        "department_name" => isset($department_name['department_name']) ? $department_name['department_name'] : '',
                        "department_id" => isset($department_name['id']) ? $department_name['id'] : '',
                        'department_priority' => isset($department_name['priority']) ? $department_name['priority'] : '',
                        "section_name" => isset($section_name['section_name']) ? $section_name['section_name'] : '',
                        "sbu_name" => isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : '',
                        "employee_work_location" => isset($WorkLocations['work_location_name']) ? $WorkLocations['work_location_name'] : '',
                        "machineno" => 0,
                        "uploadid" => 0,
                        "employee_id" => $value->id,
                        "employee_card_no" => $value->employee_id_no,
                        "pdate" => $from_date_formated,
                        "in_time" => '00:00',
                        "out_time" => '00:00',
                        "late" => '00:00',
                        "check_in_location" => '',
                        "check_out_location" => '',
                        "start_time" => date('h:i A', strtotime($office_start_time)),
                        "end_time" => date('h:i A', strtotime($office_end_time)),
                        "pstatus" => 3,
                        "status" => "A",
                        "remarks" => $manulAbsents->manual_remarks,
                        "shift_time" => date('h:i A', strtotime($office_start_time)) . " - " . date('h:i A', strtotime($office_end_time)),
                        "shift_name" => $attendance_time->title,
                        "ot" => 0,
                    ];
                } elseif ($attendance_time->type == 2) {

                    if (!empty($intime) && !empty($outtime)) {
                        $intimes = $intime->TransactionTime;
                        // $outtimes =$outtime->TransactionTime;
                        if (strtotime($intimes) == strtotime($outtime->TransactionTime)) {
                            $outtimes = '0:00';
                        } else {
                            $outtimes = $outtime->TransactionTime;
                        }

                        if ($attendance_time->office_type == 2) {
                            $status = "W";
                            $statusId = 1;
                            $remarks = "";
                        } else {
                            // if(!empty($attendance_time->lateConsiderTime)){
                            //     $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                            // }else{
                            //     $lateConsiderTime=strtotime($office_start_time);
                            // }
                            if (!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) != date('H:i', strtotime('00:00:00'))) {
                                $lateConsiderTime = date('H:i', strtotime($attendance_time->lateConsiderTime));
                            } else {
                                $lateConsiderTime = date('H:i', strtotime($office_start_time));
                            }

                            if (date('H:i', strtotime($intimes)) <= $lateConsiderTime) {
                                $late_time = '00:00';
                                $status = "P";
                                $statusId = 1;
                                $remarks = "";
                            } else {
                                if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
                                    $late_time = strtotime($intimes) - strtotime($office_start_time);
                                    $late_time = date('H:i', $late_time);
                                    $status = "L(A)";
                                    $statusId = 1;
                                    $remarks = "Late Approved";
                                } else {
                                    $late_time = strtotime($intimes) - strtotime($office_start_time);
                                    $late_time = date('H:i', $late_time);
                                    $status = "L";
                                    $statusId = 2;
                                    $remarks = "";
                                }
                            }
                        }
                        $work_time = strtotime($outtimes) - strtotime($intimes);
                        if ($work_time > 0) {
                            if ($work_time - $Toffice_time >= 0) {
                                if ((($work_time - $Toffice_time) / 3600) <= 0.30) {
                                    $ot = ($work_time - $Toffice_time) / 3600;
                                } else {
                                    $ot = 0;
                                }
                            } else {
                                $ot = 0;
                            }
                        } else {
                            $ot = 0;
                        }

                        if ($outtimes === '0:00') {
                            $outtimes = '00.00';
                        } else {
                            $outtimes = date('h:i A', strtotime($outtimes));
                        }

                        $attendances = [
                            "employee_id_no" => $value['employee_id_no'],
                            "employee_full_name" => $value['employee_full_name'],
                            "employee_sub_unit" => $value['employee_sub_unit'],
                            "sub_section_name" => isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : '',
                            "designation_name" => isset($designation_name['designation_name']) ? $designation_name['designation_name'] : '',
                            "department_name" => isset($department_name['department_name']) ? $department_name['department_name'] : '',
                            "department_id" => isset($department_name['id']) ? $department_name['id'] : '',
                            'department_priority' => isset($department_name['priority']) ? $department_name['priority'] : '',
                            "section_name" => isset($section_name['section_name']) ? $section_name['section_name'] : '',
                            "sbu_name" => isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : '',
                            "employee_work_location" => isset($WorkLocations['work_location_name']) ? $WorkLocations['work_location_name'] : '',
                            "machineno" => 0,
                            "uploadid" => 0,
                            "employee_id" => $value->id,
                            "employee_card_no" => $value->employee_id_no,
                            "pdate" => $from_date_formated,
                            "in_time" => date('h:i A', strtotime($intimes)),
                            "out_time" => $outtimes,
                            "late" => $late_time,
                            "check_in_location" => '',
                            "check_out_location" => '',
                            "start_time" => date('h:i A', strtotime($office_start_time)),
                            "end_time" => date('h:i A', strtotime($office_end_time)),
                            "pstatus" => $statusId,
                            "status" => $status,
                            "remarks" => $remarks,
                            "shift_time" => date('h:i A', strtotime($office_start_time)) . " - " . date('h:i A', strtotime($office_end_time)),
                            "shift_name" => $attendance_time->title,
                            "ot" => $ot,
                        ];

                    } elseif (!empty($intime) && empty($outtime)) {
                        if (!empty($intime->TransactionTime)) {
                            $intimes = $intime->TransactionTime;
                        } else {
                            $intimes = "00:00";
                        }
                        // if(strtotime($intimes) == strtotime($outtime->TransactionTime)){
                        $outtimes = '0:00';
                        // }else{
                        //   $outtimes=$outtime->TransactionTime;
                        // }
                        if ($attendance_time->office_type == 2) {
                            $status = "W";
                            $statusId = 1;
                            $remarks = "";
                        } else {
                            if (!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) != date('H:i', strtotime('00:00:00'))) {
                                $lateConsiderTime = date('H:i', strtotime($attendance_time->lateConsiderTime));
                            } else {
                                $lateConsiderTime = date('H:i', strtotime($office_start_time));
                            }

                            if (date('H:i', strtotime($intimes)) <= $lateConsiderTime) {
                                $late_time = '00:00';
                                $status = "P";
                                $statusId = 1;
                                $remarks = "";
                            } else {
                                if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
                                    $late_time = strtotime($intimes) - strtotime($office_start_time);
                                    $late_time = date('H:i', $late_time);
                                    $status = "L(A)";
                                    $statusId = 1;
                                    $remarks = "Late Approved";
                                } else {
                                    $late_time = strtotime($intimes) - strtotime($office_start_time);
                                    $late_time = date('H:i', $late_time);
                                    $status = "L";
                                    $statusId = 2;
                                    $remarks = "";
                                }
                            }
                        }

                        $work_time = strtotime($outtimes) - strtotime($intimes);
                        if ($work_time > 0) {
                            if ($work_time - $Toffice_time >= 0) {
                                if ((($work_time - $Toffice_time) / 3600) <= 0.30) {
                                    $ot = ($work_time - $Toffice_time) / 3600;
                                } else {
                                    $ot = 0;
                                }
                            } else {
                                $ot = 0;
                            }
                        } else {
                            $ot = 0;
                        }

                        if ($outtimes === '0:00') {
                            $outtimes = '00.00';
                        } else {
                            $outtimes = date('h:i A', strtotime($outtimes));
                        }
                        $attendances = [
                            "employee_id_no" => $value['employee_id_no'],
                            "employee_full_name" => $value['employee_full_name'],
                            "employee_sub_unit" => $value['employee_sub_unit'],
                            "sub_section_name" => isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : '',
                            "designation_name" => isset($designation_name['designation_name']) ? $designation_name['designation_name'] : '',
                            "department_name" => isset($department_name['department_name']) ? $department_name['department_name'] : '',
                            "department_id" => isset($department_name['id']) ? $department_name['id'] : '',
                            'department_priority' => isset($department_name['priority']) ? $department_name['priority'] : '',
                            "section_name" => isset($section_name['section_name']) ? $section_name['section_name'] : '',
                            "sbu_name" => isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : '',
                            "employee_work_location" => isset($WorkLocations['work_location_name']) ? $WorkLocations['work_location_name'] : '',
                            "machineno" => 0,
                            "uploadid" => 0,
                            "employee_id" => $value->id,
                            "employee_card_no" => $value->employee_id_no,
                            "pdate" => $from_date_formated,
                            "in_time" => date('h:i A', strtotime($intimes)),
                            "out_time" => $outtimes,
                            "late" => $late_time,
                            "check_in_location" => '',
                            "check_out_location" => '',
                            "start_time" => date('h:i A', strtotime($office_start_time)),
                            "end_time" => date('h:i A', strtotime($office_end_time)),
                            "pstatus" => $statusId,
                            "status" => $status,
                            "remarks" => $remarks,
                            "shift_time" => date('h:i A', strtotime($office_start_time)) . " - " . date('h:i A', strtotime($office_end_time)),
                            "shift_name" => $attendance_time->title,
                            "ot" => $ot,
                        ];
                    } else {
                        if ($attendance_time['office_type'] == 2) {
                            $status = "W";
                            $statusId = 4;
                            $remarks = "";
                        } elseif (!empty($holiday_find) && in_array($from_date_formated, $holiday_find)) {
                            $status = "H";
                            $statusId = 5;
                            $remarks = "";
                        } elseif (!empty($ind_leave_info) && in_array($from_date_formated, $ind_leave_info)) {
                            $laveType = collect($indLeaveInfo)->where('leave_from_date', '<=', $from_date_formated)->where('leave_to_date', '>=', $from_date_formated)->first();
                            $status = $laveType->leave_short_type;
                            $statusId = 6;
                            $remarks = "";
                        } else {
                            $status = "A";
                            $statusId = 3;
                            $remarks = "";
                        }

                        $attendances = [
                            "employee_id_no" => $value['employee_id_no'],
                            "employee_full_name" => $value['employee_full_name'],
                            "employee_sub_unit" => $value['employee_sub_unit'],
                            "sub_section_name" => isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : '',
                            "designation_name" => isset($designation_name['designation_name']) ? $designation_name['designation_name'] : '',
                            "department_name" => isset($department_name['department_name']) ? $department_name['department_name'] : '',
                            "department_id" => isset($department_name['id']) ? $department_name['id'] : '',
                            'department_priority' => isset($department_name['priority']) ? $department_name['priority'] : '',
                            "section_name" => isset($section_name['section_name']) ? $section_name['section_name'] : '',
                            "sbu_name" => isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : '',
                            "employee_work_location" => isset($WorkLocations['work_location_name']) ? $WorkLocations['work_location_name'] : '',
                            "machineno" => 0,
                            "uploadid" => 0,
                            "employee_id" => $value->id,
                            "employee_card_no" => $value->employee_id_no,
                            "pdate" => $from_date_formated,
                            "in_time" => '00:00',
                            "out_time" => '00:00',
                            "late" => '00:00',
                            "check_in_location" => '',
                            "check_out_location" => '',
                            "start_time" => date('h:i A', strtotime($office_start_time)),
                            "end_time" => date('h:i A', strtotime($office_end_time)),
                            "pstatus" => $statusId,
                            "status" => $status,
                            "remarks" => $remarks,
                            "shift_time" => date('h:i A', strtotime($office_start_time)) . " - " . date('h:i A', strtotime($office_end_time)),
                            "shift_name" => $attendance_time->title,
                            "ot" => 0,
                        ];
                    }
                } else {
                    if (!empty($intime) && !empty($outtime)) {
                        if ($intime->latitude && $intime->longitude) {
                            $inLocation = Location::getLocation($intime->latitude, $intime->longitude);
                        }else{
                            $inLocation = '';
                        }
                        if ($outtime->latitude && $outtime->longitude) {
                            $outLocation = Location::getLocation($outtime->latitude, $outtime->longitude);
                        }else{
                            $outLocation = '';
                        }

                        $intimes = $intime->TransactionTime;
                        //$outtimes =$outtime->TransactionTime;
                        if (strtotime($intimes) == strtotime($outtime->TransactionTime)) {
                            $outtimes = '0:00';
                        } else {
                            $outtimes = $outtime->TransactionTime;
                        }
                        $late_time = '00:00';
                        if (in_array(date('D', strtotime($from_date_formated)), $weekend)) {
                            $status = "W";
                            $statusId = 1;
                            $remarks = "";
                        } else {
                            //  if(!empty($attendance_time->lateConsiderTime)){
                            //     $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                            // }else{
                            //     $lateConsiderTime=strtotime($office_start_time);
                            // }
                            $late_time = '00:00';
                            if (!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) != date('H:i', strtotime('00:00:00'))) {
                                $lateConsiderTime = date('H:i', strtotime($attendance_time->lateConsiderTime));
                            } else {
                                $lateConsiderTime = date('H:i', strtotime($office_start_time));
                            }

                            if (date('H:i', strtotime($intimes)) <= $lateConsiderTime) {
                                $late_time = '00:00';
                                $status = "P";
                                $statusId = 1;
                                $remarks = "";
                            } else {
                                if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
                                    $late_time = strtotime($intimes) - strtotime($office_start_time);
                                    $late_time = date('H:i', $late_time);
                                    $status = "L(A)";
                                    $statusId = 1;
                                    $remarks = "Late Approved";
                                } else {
                                    $late_time = strtotime($intimes) - strtotime($office_start_time);
                                    $late_time = date('H:i', $late_time);
                                    $status = "L";
                                    $statusId = 2;
                                    $remarks = "";
                                }
                            }
                        }
                        $work_time = strtotime($outtimes) - strtotime($intimes);
                        if ($work_time > 0) {
                            if ($work_time - $Toffice_time >= 0.30) {
                                if ((($work_time - $Toffice_time) / 3600) <= 0.30) {
                                    $ot = ($work_time - $Toffice_time) / 3600;
                                } else {
                                    $ot = 0;
                                }
                            } else {
                                $ot = 0;
                            }
                        } else {
                            $ot = 0;
                        }

                        if ($outtimes === '0:00') {
                            $outtimes = '00.00';
                        } else {
                            $outtimes = date('h:i A', strtotime($outtimes));
                        }
                        $attendances = [
                            "employee_id_no" => $value['employee_id_no'],
                            "employee_full_name" => $value['employee_full_name'],
                            "employee_sub_unit" => $value['employee_sub_unit'],
                            "sub_section_name" => isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : '',
                            "designation_name" => isset($designation_name['designation_name']) ? $designation_name['designation_name'] : '',
                            "department_name" => isset($department_name['department_name']) ? $department_name['department_name'] : '',
                            "department_id" => isset($department_name['id']) ? $department_name['id'] : '',
                            'department_priority' => isset($department_name['priority']) ? $department_name['priority'] : '',
                            "section_name" => isset($section_name['section_name']) ? $section_name['section_name'] : '',
                            "sbu_name" => isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : '',
                            "employee_work_location" => isset($WorkLocations['work_location_name']) ? $WorkLocations['work_location_name'] : '',
                            "machineno" => 0,
                            "uploadid" => 0,
                            "employee_id" => $value->id,
                            "employee_card_no" => $value->employee_id_no,
                            "pdate" => $from_date_formated,
                            "in_time" => date('h:i A', strtotime($intimes)),
                            "out_time" => $outtimes,
                            "late" => $late_time,
                            "check_in_location" => $inLocation,
                            "check_out_location" => $outLocation,
                            "start_time" => date('h:i A', strtotime($office_start_time)),
                            "end_time" => date('h:i A', strtotime($office_end_time)),
                            "pstatus" => $statusId,
                            "status" => $status,
                            "remarks" => $remarks,
                            "shift_time" => date('h:i A', strtotime($office_start_time)) . " - " . date('h:i A', strtotime($office_end_time)),
                            "shift_name" => $attendance_time->title,
                            "ot" => $ot,
                        ];
                    } else {
                        // return $ind_leave_info;
                        // print_r($ind_leave_info);
                        if ((in_array(date('D', strtotime($from_date_formated)), $weekend))) {
                            $status = "W";
                            $statusId = 4;
                            $remarks = "";
                        } elseif (!empty($holiday_find) && in_array($from_date_formated, $holiday_find)) {
                            $status = "H";
                            $statusId = 5;
                            $remarks = "";
                        } elseif (!empty($ind_leave_info) && in_array($from_date_formated, $ind_leave_info)) {
                            $laveType = collect($indLeaveInfo)->where('leave_from_date', '<=', $from_date_formated)->where('leave_to_date', '>=', $from_date_formated)->first();
                            $status = $laveType->leave_short_type;
                            $statusId = 6;
                            $remarks = "";
                        } else {
                            $status = "A";
                            $statusId = 3;
                            $remarks = "";
                        }
                        //      $all_data[$key]['shift_time'] ='09:00-18:00';
                        // $all_data[$key]['in_time'] ='00:00';
                        // $all_data[$key]['out_time'] ='00:00';
                        // $all_data[$key]['late'] ='00:00';
                        // $all_data[$key]['status'] = '';
                        // $all_data[$key]['remarks'] ='Office Time not Set';

                        $attendances = [
                            "employee_id_no" => $value['employee_id_no'],
                            "employee_full_name" => $value['employee_full_name'],
                            "employee_sub_unit" => $value['employee_sub_unit'],
                            "sub_section_name" => isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : '',
                            "designation_name" => isset($designation_name['designation_name']) ? $designation_name['designation_name'] : '',
                            "department_name" => isset($department_name['department_name']) ? $department_name['department_name'] : '',
                            "department_id" => isset($department_name['id']) ? $department_name['id'] : '',
                            'department_priority' => isset($department_name['priority']) ? $department_name['priority'] : '',
                            "section_name" => isset($section_name['section_name']) ? $section_name['section_name'] : '',
                            "sbu_name" => isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : '',
                            "employee_work_location" => isset($WorkLocations['work_location_name']) ? $WorkLocations['work_location_name'] : '',
                            "machineno" => 0,
                            "uploadid" => 0,
                            "employee_id" => $value->id,
                            "employee_card_no" => $value->employee_id_no,
                            "pdate" => $from_date_formated,
                            "in_time" => '00:00',
                            "out_time" => '00:00',
                            "late" => '00:00',
                            "check_in_location" => '',
                            "check_out_location" => '',
                            "start_time" => date('h:i A', strtotime($office_start_time)),
                            "end_time" => date('h:i A', strtotime($office_end_time)),
                            "pstatus" => $statusId,
                            "status" => $status,
                            "remarks" => $remarks,
                            "shift_time" => date('h:i A', strtotime($office_start_time)) . " - " . date('h:i A', strtotime($office_end_time)),
                            "shift_name" => $attendance_time->title,
                            "ot" => 0,
                        ];
                    }
                }
            }
            $attendance_dataNew[] = $attendances;
        }


        $date_report = date("d M,Y", strtotime($from_date_formated));

        $company_id = $employee_sbu;
        $created_by = Auth::guard('user')->user()->name;
        if (!empty($search_option['att_status'])) {
            $att_types = '';
            foreach ($search_option['att_status'] as $value) {
                if ($value == 1) {
                    $att_types = $att_types . 'Present';
                } elseif ($value == 2) {
                    $att_types = $att_types . ', Late';
                } elseif ($value == 6) {
                    $att_types = $att_types . ', Leave';
                } elseif ($value == 3) {
                    $att_types = $att_types . ', Absent';
                }
            }
            $report_name = "Daily Attendance [ " . $att_types . " ] Report";
            $all_data = collect($attendance_dataNew)->whereIn('pstatus', $search_option['att_status'])->toArray();
        } else {
            $report_name = "Daily Attendance Report";
            $all_data = $attendance_dataNew;
        }

        // dd($all_data);

        // return $all_data;
        // echo "<pre>";
        // print_r($company_id);
        // exit();
        $SubUnitId = collect(collect($all_data)->unique('employee_sub_unit')->values()->all())->pluck('employee_sub_unit')->toarray();

        // employee_sub_unit
        $allSubUnits = collect($employee_sub_unit)->whereIn('id', $SubUnitId)->toarray();
        //   echo "<pre>";
        //   print_r($allSubUnits);
        //   exit();
        $table = "<table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'>

           <div   class='section-to-print col-md-12'>
           <table style='width:100%'> <tr> <td style='width:20%'>
           <div class='row' style='margin-left: 21px;'>
            <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";
        // if (!empty($company_id)) {
        $companyLogo1 = collect($company_sbus)->where('id', 21)->first();

        if (!empty($companyLogo1)) {
            if ($companyLogo1['sbu_logo'] != "") {
                $url = '/company_logo/' . $companyLogo1["sbu_logo"];
                $table .= '<img src="' . $url . '" style="width:25%;">';
            } else {
                $table .= 'No Logo Found';
            }
        } else {
            $table .= 'No Logo Found';
        }
        // }else{
        //   $url= '/company_logo/group_company_logo.png';
        //   $table.='<img src="'.$url.'" style="width:25%;">';

        // }
        $table .= " </div></td><td style='width:60%'>
            <div class='col-md-12' style='padding: 0px'>
              <h3 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h3>
              <h4 class='text-center' style='margin:0px;text-align: center!important;'>" . $sbuNames . "</h4>
              <h5 class='text-center' style='text-align: center!important;'>" . $report_name . "</h5>
              <h6 class='text-center' style='text-align: center!important;'>

               Date: " . $date_report . "</h6>
            </div> </td> <td style='width:20%'>
            <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
              <p ><strong> Print Date :</strong>" . date('d M,Y') . "</p>
              <p style='margin-top: -7px'><strong> Created By :</strong> " . $created_by . "</p>
            </div>
            </div></td></tr></table>";

        $table .= "<table  class='table table-bordered' border='0' style='width:100%'>
                  <thead>
                    <tr style='background: #eee;'>
                      <th class='ths' style='padding:2px 10px; width: 5%; text-align: center;vertical-align: middle;'>Sl.</th>";
        // foreach ($column_name_data as $key => $value){
        $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>ID</th>";
        $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Name</th>";
        $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Position</th>";
        $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Department</th>";
        $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Shift</th>";
        $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>In Time </th>";
        $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Out Time </th>";
        $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Late By </th>";
        $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>OT </th>";
        $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Status </th>";
        $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;' title='Check In Location'>C. In Loc. </th>";
        $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;' title='Check Out Location'>C. Out Loc. </th>";
        $table .= "<th  class='ths' style='padding:2px 10px;text-align: center;vertical-align: middle;'>Remarks </th>";
        // }
        $table .= "  </tr>
              </thead>
              <tbody>";
        $i = 0;

        foreach ($allSubUnits as $key_1 => $value) {
            # code...
            $all_datas = collect($all_data)
                ->where('employee_sub_unit', $value['id'])
                ->sortBy('department_priority')
                ->groupBy('department_id')
                ->toarray();

            foreach ($all_datas as $key_2 => $singleData) {
                $all_deps = collect($all_data)
                    ->where('employee_sub_unit', $value['id'])
                    ->where('department_id', $key_2)
                    ->sortBy('employee_id_no')
                    ->toarray();

                $department_name = collect($all_data)
                    ->where('employee_sub_unit', $value['id'])
                    ->where('department_id', $key_2)
                    ->first();

                $table .= " <tr class='body_td'>
                          <th  class='ths' colspan='14' style='width: 5%; text-align: left;vertical-align: middle;'>
                           <b> Sub Unit :</b> " . $value['sub_unit_name'] . "
                          <b>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; Department :</b> " . $department_name['department_name'] . "
                          </th>
                       </tr>";

                foreach ($all_deps as $key => $single_data) {
                    $i++;
                    $table .= " <tr class='body_td'>
                            <td  class='ths' style='width: 5%; text-align: center;vertical-align: middle;'>" . $i . "</td>";
                    // foreach ($column_data as $key => $value){
                    // $valuData=isset($single_data[$value])?$single_data[$value]:'';
                    $table .= "         <td  class='ths' style='vertical-align: middle;'>" . $single_data['employee_id_no'] . "</td>";
                    $table .= "         <td  class='ths' style='vertical-align: middle;'>" . $single_data['employee_full_name'] . "</td>";
                    $table .= "         <td  class='ths' style='vertical-align: middle;'>" . $single_data['designation_name'] . "</td>";
                    $table .= "         <td  class='ths' style='vertical-align: middle;'>" . $single_data['department_name'] . "</td>";
                    $table .= "         <td  class='ths' style='vertical-align: middle; text-align:center'>" . $single_data['shift_name'] . "</td>";
                    // $table.="         <td  class='ths' style='vertical-align: middle;'>". $single_data['shift_name'].' [ '. $single_data['shift_time']. ' ] '."</td>";
                    // $table.="         <td  class='ths' style='vertical-align: middle;'>".$single_data['shift_time']."</td>";
                    $table .= "         <td  class='ths' style='vertical-align: middle;'>" . $single_data['in_time'] . "</td>";
                    $table .= "         <td  class='ths' style='vertical-align: middle;'>" . $single_data['out_time'] . "</td>";
                    $table .= "         <td  class='ths' style='vertical-align: middle;'>" . $single_data['late'] . "</td>";
                    $table .= "         <td  class='ths' style='vertical-align: middle;'>" . number_format($single_data['ot'], 1) . "</td>";
                    $table .= "         <td  class='ths' style='vertical-align: middle;text-align:center'>" . $single_data['status'] . "</td>";
                    $table .= "         <td  class='ths' style='vertical-align: middle;'>" . $single_data['check_in_location'] . "</td>";
                    $table .= "         <td  class='ths' style='vertical-align: middle;'>" . $single_data['check_out_location'] . "</td>";
                    $table .= "         <td  class='ths' style='vertical-align: middle;'>" . $single_data['remarks'] . "</td>";

                    // }
                    $table .= "  </tr>";
                }
            }
        }
        $table .= "</tbody>
            </table></td></tr></table> ";
        // $this->reportMail($company_id,$company_sbus,$sbuNames,$report_name,$date_report,$created_by,$column_name_data,$all_data,$column_data);

        return $table;


        // return view('layouts.report',compact('all_data','column_data','column_name_data','date_report','company_id','company_sbus','created_by','report_name'));
    }



    public function Newfind_individual_attendance($report_type, $att_report_type, $employee_sbu, $from_date_formated, $to_date_formated, $checkedattcolsadd, $search_option, $employee_id)
    {
        // echo "<pre>";
        // print_r($employee_id);
        // exit();
        $column_data = $columnArray = explode(',', $checkedattcolsadd);
        if (count($column_data) > 1) {
            $column_name_data = $this->column_real_name($columnArray);
        } else {
            $column_data = $columNameArray = array("date", "in_time", "out_time", "late", "shift_time", "status");
            $column_name_data = $this->column_real_name($columNameArray);
        }

        // Date,In Time ,Out Time ,Late,Start Time ,End Time ,Remarks

        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        // $employee_id=$employee_ids['employee_id'];

        $employee_sbu = [];


        if (!empty($search_option['employee_sbu'])) {
            $employee_sbu = [$search_option['employee_sbu']];
        } else {
            $employee_sbu = $employee_ids['sub'];
        }
        $employee_department = [];
        if (!empty($search_option['employee_department'])) {
            $employee_department = [$search_option['employee_department']];
        } else {
            $employee_department = $employee_ids['department'];
        }

        //   echo "<pre>";
        // print_r($search_option['employee_sbu']);
        // exit();


        $date_print['from_date_formated'] = $from_date_formated;
        $employee_info = Employee::select('employees.id', 'employees.employee_id_no', 'employees.employee_fullname as employee_full_name', 'employees.employee_sbu', 'employees.employee_section', 'employees.employee_department', 'employees.employee_designation', 'employees.employee_sub_unit', 'employees.employee_sub_unit')
            ->valid()
            ->where('employees.employee_status', 1)
            ->where('employees.employee_department', '!=', 132)
            ->where('employees.id', $employee_id);
        // ->whereIn('employee_sbu',$employee_sbu)
        // ->whereIn('employee_department',$employee_department);

        // if ($employee_sbu !=0) {
        //     $employee_info->where('employee_sbu',$employee_sbu);
        // }
        // if ($search_option['employee_department'] !=0) {
        //     $employee_info->where('employee_department',$search_option['employee_department']);
        // }
        if ($search_option['employee_designation'] != 0) {
            $employee_info->where('employee_designation', $search_option['employee_designation']);
        }



        $employee_info = $employee_info->orderBy('employees.employee_sbu')->orderBy('employees.employee_section')->orderBy('employees.employee_department')->get()->toArray();


        $employee_ids = collect($employee_info)->pluck('employee_id_no')->toArray();
        $employee_primary_ids = collect($employee_info)->pluck('id')->toArray();
        if (!empty($employee_sbu)) {
            $company_sbus = CompanySbu::valid()->where('id', $employee_sbu)->get()->toArray();
        } else {
            $company_sbus = CompanySbu::valid()->whereIn('id', $employee_ids['sub'])->get()->toArray();
        }
        $employee_section = Section::valid()->get()->toArray();
        $employee_department = Department::valid()->get()->toArray();
        $employee_designation = Designation::valid()->get()->toArray();
        $employee_sub_unit = SubUnit::valid()->get()->toArray();

        $in_data1 = DB::table('attendance_log')
            ->select(
                DB::RAW('min(attendance_log.id) as in_id'),
                'attendance_log.employee_id',
                'TransactionDate',
                'TransactionTime as in_time'
            )
            ->whereIn('employee_id', $employee_ids)
            ->whereDate('TransactionDate', '>=', $from_date_formated)
            ->whereDate('TransactionDate', '<=', $to_date_formated)
            ->groupBy(DB::RAW('TransactionDate'))
            ->get()->toArray();
        $out_data1 = DB::select("SELECT employee_id,TransactionDate,TransactionTime as out_time FROM attendance_log WHERE id IN (SELECT MAX(id) FROM attendance_log  WHERE TransactionDate >= '" . $from_date_formated . "' AND TransactionDate <= '" . $to_date_formated . "'  GROUP BY employee_id ) ORDER BY id ASC");

        $office_time = AttendanceSetup::valid()
            ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
            ->select(
                'attendance_setups.employee_id',
                'office_time_setups.office_start_time',
                'office_time_setups.office_end_time',
                'office_time_setups.lateConsiderTime'
            )
            ->whereIn('attendance_setups.employee_id', $employee_primary_ids)
            ->groupBy(DB::RAW('attendance_setups.employee_id'))
            ->get()->toArray();


        $all_data = $employee_info;



        if (!empty($column_name_data) && $report_type == 1 && $att_report_type == 1) {
            foreach ($all_data as $key => $value) {
                $sbu_name = collect($company_sbus)->where('id', $value['employee_sbu'])->first();
                $section_name = collect($employee_section)->where('id', $value['employee_section'])->first();
                $department_name = collect($employee_department)->where('id', $value['employee_department'])->first();
                $designation_name = collect($employee_designation)->where('id', $value['employee_designation'])->first();
                $sub_section_name = collect($employee_sub_unit)->where('id', $value['employee_sub_unit'])->first();
                $all_data[$key]['sub_section_name'] = isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : '';
                $all_data[$key]['designation_name'] = isset($designation_name['designation_name']) ? $designation_name['designation_name'] : '';
                $all_data[$key]['department_name'] = isset($department_name['department_name']) ? $department_name['department_name'] : '';
                $all_data[$key]['section_name'] = isset($section_name['section_name']) ? $section_name['section_name'] : '';
                $all_data[$key]['sbu_name'] = isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : '';

                $in_data = collect($in_data1)->where('employee_id', $value['employee_id_no'])->first();
                $out_data = collect($out_data1)->where('employee_id', $value['employee_id_no'])->first();
                $office_time_data = collect($office_time)->where('employee_id', $value['id'])->first();
                // echo "<pre>"; print_r($office_time_data); die();

                if (empty($in_data) && empty($out_data)) {
                    $all_data[$key]['shift_time'] = '09:00-18:00';
                    $all_data[$key]['in_time'] = '00:00';
                    $all_data[$key]['out_time'] = '00:00';
                    $all_data[$key]['late'] = '00:00';
                    $all_data[$key]['status'] = 'A';
                    $all_data[$key]['remarks'] = '';
                } else {
                    if (!empty($office_time_data)) {
                        $all_data[$key]['shift_time'] = date("g:i A", strtotime($office_time_data['office_start_time'])) . " - " . date("g:i A", strtotime($office_time_data['office_end_time']));
                        $all_data[$key]['in_time'] = $in_data->in_time;
                        $all_data[$key]['out_time'] = $out_data->out_time;
                        $letTime = strtotime($in_data->in_time) - strtotime($office_time_data['lateConsiderTime']);
                        if ($letTime > 0) {
                            $late_time = strtotime($in_data->in_time) - strtotime($office_time_data['office_start_time']);
                            $late = date('H:i', $late_time);
                            $all_data[$key]['late'] = $late;
                            $all_data[$key]['status'] = 'L';
                        } else {
                            $all_data[$key]['late'] = '00:00';
                            $all_data[$key]['status'] = 'P';
                        }
                        $all_data[$key]['remarks'] = '';
                    } else {
                        $all_data[$key]['shift_time'] = '09:00-18:00';
                        $all_data[$key]['in_time'] = '00:00';
                        $all_data[$key]['out_time'] = '00:00';
                        $all_data[$key]['late'] = '00:00';
                        $all_data[$key]['status'] = '';
                        $all_data[$key]['remarks'] = 'Office Time not Set';
                    }
                }
            }/*loop end*/
            // echo "<pre>"; print_r($all_data); die();
            // $all_data = $data;
        }

        $date_report = date("d M,Y", strtotime($from_date_formated));
        $report_name = "Daily Attendance Report";
        //  echo "<pre>";
        // print_r($date_report);
        // exit();
        // $dailyinfo = $all_data->get()->toArray();
        //   // echo "<pre>"; print_r($daily_attendance); die();
        $company_id = $employee_sbu;
        $created_by = Auth::guard('user')->user()->name;

        return view('layouts.report', compact('all_data', 'column_data', 'column_name_data', 'date_report', 'company_id', 'company_sbus', 'created_by', 'report_name'));
    }

    public function get_report_sbu(Request $request)
    {
        // return response($request);
        $sbu_type = '';
        $unit_type = '';
        $sub_unit_type = '';
        $department_type = '';
        $section_type = '';
        $sub_section_type = '';
        $employee_type = '';
        $worklocation_type = '';
        $datas = request()->json()->all();

        $types = $datas['type'];
        $employeeInfo = Employee::valid()->project()->get()->toArray();
        if ($types == 1) {
            $data['unit_data'] = array();
            $sbu_id = collect($datas['info'])->pluck('id');
            $unitId = collect(collect($employeeInfo)->whereIn('employee_sbu', $sbu_id)->unique('employee_unit')->values()->all())->pluck('employee_unit');
            $unit_data = UnitModel::valid()->project()->whereIn('id', $unitId)->get();
            array_push($data['sub_unit_data'], ['id' => '', 'text' => 'All Select']);
            foreach ($unit_data as $value) {
                array_push($data['unit_data'], ['id' => $value['id'], 'text' => $value['unit_name']]);
            }
        }

        foreach ($datas as $key => $value) {
            if ($value['type'] == 1) {
                $sbu_ids[] = $value['id'];
                $sbu_type = $value['type'];
            }
            if ($value['type'] == 2) {
                $unit_ids[] = $value['id'];
                $unit_type = $value['type'];
            }
            if ($value['type'] == 3) {
                $sub_unit_ids[] = $value['id'];
                $sub_unit_type = $value['type'];
            }
            if ($value['type'] == 4) {
                $department_ids[] = $value['id'];
                $department_type = $value['type'];
            }
            if ($value['type'] == 5) {
                $section_ids[] = $value['id'];
                $section_type = $value['type'];
            }
            if ($value['type'] == 6) {
                $sub_section_ids[] = $value['id'];
                $sub_section_type = $value['type'];
            }
            if ($value['type'] == 7) {
                $employee_ids[] = $value['id'];
                $employee_type = $value['type'];
            }
            if ($value['type'] == 8) {
                $worklocation_ids[] = $value['id'];
                $worklocation_type = $value['type'];
            }
        }
        $query = Employee::valid()->project();
        if ($sbu_type == 1) {
            $query->whereIn('employees.employee_sbu', $sbu_ids);
        }
        if ($unit_type == 2) {
            $query->whereIn('employees.employee_unit', $unit_ids);
        }
        if ($sub_unit_type == 3) {
            $query->whereIn('employees.employee_sub_unit', $sub_unit_ids);
        }
        if ($department_type == 4) {
            $query->whereIn('employees.employee_department', $department_ids);
        }
        if ($section_type == 5) {
            $query->whereIn('employees.employee_section', $section_ids);
        }
        if ($sub_section_type == 6) {
            $query->whereIn('employees.employee_sub_section', $sub_section_ids);
        }
        if ($employee_type == 7) {
            $query->whereIn('employees.id', $employee_ids);
        }
        if ($worklocation_type == 8) {
            $query->whereIn('employees.employee_work_location', $worklocation_ids);
        }
        $all_info_get = $query->get();

        $employee_units = collect($all_info_get)->pluck('employee_unit');
        $data['unit_findings'] = UnitModel::valid()->project()->whereIn('id', $employee_units)->get();
        $employee_sub_units = collect($all_info_get)->pluck('employee_sub_unit');
        $data['sub_units_findings'] = SubUnit::valid()->project()->whereIn('id', $employee_sub_units)->get();
        $employee_work_locations = collect($all_info_get)->pluck('employee_work_location');
        $data['work_location_findings'] = WorkLocation::valid()->project()->whereIn('id', $employee_work_locations)->get();
        $employee_departments = collect($all_info_get)->pluck('employee_department');
        $data['department_findings'] = Department::valid()->project()->whereIn('id', $employee_departments)->get();
        return response($data);
    }

    public function find_attendance_late_report_old($search_option)
    {
        // echo"<pre>";
        // print_r($search_option);
        // exit();

        $begin = new DateTime($search_option['from_date_formated']);
        $end = new DateTime($search_option['to_date_formated']);
        $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

        $employee_info = Employee::select('*')->valid()
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->select(
                'employees.*',
                'company_sbus.sbu_name',
                'company_sbus.sbu_logo',
                'departments.department_name',
                'sub_units.sub_unit_name',
                'designations.designation_name',
                'sections.section_name',
                'work_locations.work_location_name',
            )
            ->where('employees.employee_department', '!=', 132)
            ->where('employees.employee_status', 1)
            //   ->where('employees.id', $search_option['employee_ids'])
        ;
        if (!empty($search_option['employee_sbu'])) {
            $employee_info->wherein('employee_sbu', $search_option['employee_sbu']);
        }
        if (!empty($search_option['unit'])) {
            $employee_info->wherein('unit', $search_option['unit']);
        }
        if (!empty($search_option['sub_unit'])) {
            $employee_info->wherein('sub_unit', $search_option['sub_unit']);
        }
        if (!empty($search_option['employee_department'])) {
            $employee_info->wherein('employee_department', $search_option['employee_department']);
        }
        if (!empty($search_option['employee_section'])) {
            $employee_info->wherein('employee_section', $search_option['employee_section']);
        }
        if (!empty($search_option['employee_sub_section'])) {
            $employee_info->wherein('employee_sub_section', $search_option['employee_sub_section']);
        }
        if (!empty($search_option['employee_work_location'])) {
            $employee_info->wherein('employee_work_location', $search_option['employee_work_location']);
        }
        if (!empty($search_option['employee_designation'])) {
            $employee_info->where('employees.id', $search_option['employee_designation']);
        }
        if (!empty($search_option['employee_id'])) {
            $employee_info->where('employees.id', $search_option['employee_id']);
        }
        $all_data['employee_info'] = $employee_info->orderBy('designations.priority')->get()->toArray();

        $emplyids = array_pluck($all_data['employee_info'], 'id');
        //  echo"<pre>";
        // print_r($emplyids);
        // exit();
        $periodicAttendanceSum =
            Attendance::select('attendance.employee_id', 'pstatus', 'pdate', DB::raw('count(DISTINCT pdate) AS totalDay'))
                ->whereDate('pdate', '<=', $search_option['to_date_formated'])
                ->whereDate('pdate', '>=', $search_option['from_date_formated'])
                ->whereIn('employee_id', $emplyids)->groupBy('attendance.employee_id')->groupBy('attendance.pstatus')->get();
        $total = $prtot = $abtot = $lttot = $osdtot = $levtot = $whtot = 0;

        $all_data['attendance_data'] = DB::table('attendance')
            ->whereIn('employee_id', $emplyids)
            ->whereDate('pdate', '>=', $search_option['from_date_formated'])
            ->whereDate('pdate', '<=', $search_option['to_date_formated'])
            ->orderBy('attendance.pdate', 'ASC')
            ->orderBy('attendance.intime', 'ASC')
            ->get()
            ->toArray();
        $all_data['search_option'] = $search_option;

        // echo"<pre>";
        // print_r($all_data['attendance_data']);
        // exit();

        $company_id = isset($search_option['employee_sbus']) ? $search_option['employee_sbus'] : '';

        if ($search_option['employee_department']) {
            $deptname = Department::valid()->where('id', $search_option['employee_department'])->first();
            $deptnameName = $deptname['department_name'];
        } else {
            if (!empty($all_data['employee_info']['employee_department'])) {
                $deptname = Department::valid()->where('id', $all_data['employee_info']['employee_department'])->first();
                $deptnameName = $deptname['department_name'];
            } else {
                $deptnameName = 'No Data!';
            }
        }
        if (!empty($search_option['employee_sbu'])) {
            $sbuName = CompanySbu::valid()->wherein('id', $search_option['employee_sbu'])->first();
            $esbuName = $sbuName['sbu_name'];
        } else {
            $sbuName = [];
            $esbuName = "All";
        }


        $date_report = date("d M,Y", strtotime($search_option['from_date_formated'])) . " To " . date("d M,Y", strtotime($search_option['to_date_formated']));
        $created_by = Auth::guard('user')->user()->name;
        $table = " <table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'><div id='' class='section-to-print col-md-12'>
                    <div class='col-md-12'>
                      <div class='col-md-12'>
                      <div class='row' style='margin-left: 21px;'>
                      <table class='sssssss' style='width:100%'> <tr> <td style='width:20%'>
                      <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";
        if (!empty($sbuName)) {
            $companyLogo = $sbuName;
            if (!empty($companyLogo)) {
                if ($companyLogo['sbu_logo'] != "") {
                    $url = '/company_logo/' . $companyLogo["sbu_logo"];
                    $table .= '<img src="' . $url . '" style="width:25%;">';
                } else {
                    $table .= "No Logo Found";
                }
            } else {
                $url = '/company_logo/group_company_logo.png';
                $table .= '<img src="' . $url . '" style="width:25%;">';
            }
        } else {
            $url = '/company_logo/group_company_logo.png';
            $table .= '<img src="' . $url . '" style="width:25%;">';
        }

        // echo"<pre>";
        // print_r($all_data['employee_info']);
        // exit();
        // dd($all_data['employee_info']);
        if (!empty($all_data['employee_info'])) {
            $names = $all_data['employee_info'][0]['employee_fullname'] . " [ " . $all_data['employee_info'][0]['employee_id_no'];
            $designation_name = $all_data['employee_info'][0]['designation_name'];
            $department_name = $all_data['employee_info'][0]['department_name'];
            $sub_unit_name = $all_data['employee_info'][0]['sub_unit_name'];
            $sbu_name = $all_data['employee_info'][0]['sbu_name'];
        } else {
            $names = 'No Data!';
            $designation_name = 'No Data!';
            $department_name = 'No Data!';
            $sub_unit_name = 'No Data!';
            $sbu_name = 'No Data!';
        }

        $table .= "
                        <!--
                        <h6  style='margin:0px;'>
                          " . $names . " ]
                        </h6>

                         <p  style='margin:0px;'><strong> Designation: </strong> " . $designation_name . "</p>
                         <p  style='margin:0px;'><strong> Department: </strong> " . $department_name . "</p>
                         <p  style='margin:0px;'><strong> Sub Unit: </strong> " . $sub_unit_name . "</p>
                        -->

                      </div>
                       </td>
                      <td style='width:60%'>
                      <div class='col-md-12' style='margin:0px;text-align: center!important;'>
                        <h3 class='text-center' sstyle='margin:0px;text-align: center!important;'>Gemcon Group</h3>
                        <h5 class='text-center' style='margin:0px;text-align: center!important;'>" . $sbu_name . "</h5>
                        <h5 class='text-center' style='margin:0px;text-align: center!important;'>" . $deptnameName . "</h5>
                        <h6 class='text-center' style='margin:0px;text-align: center!important;'>Attendance Late Report</h6>
                        <h6 class='text-center' style='margin:0px;text-align: center!important;'>" . $date_report . "</h6>
                      </div>
                       </td>
                      <td style='width:20%'>
                      <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
                        <p ><strong> Print Date :</strong> " . date('d M,Y') . " </p>
                        <p style='margin-top: -7px'><strong> Created By :</strong> " . $created_by . " </p>
                      </div>
                      </td> </tr></table>

                    </div>
                      <br>
                    </div>
                     <table class='table table-bordered' border='0' style='width:100%'>
                        <!--
                        <thead>
                            <tr style='background: #eee;'>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>SL.</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Name</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>ID</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Designation</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Department</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Section</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Work Location</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Date of Joining</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Date</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Shift</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Shift Hour</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>In Time</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Out Time</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Late</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Working Hour</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Extra/Short Hour</th>
                            <th class='ths text-center' style='padding:2px 10px; width: 5%; text-align: center;'>Remarks</th>
                            </tr>
                        </thead>
                        -->
                      <tbody>
                      <table class='table table-condensed' style='border-collapse:collapse;'>
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Section</th>
                                <th>W. Location</th>
                                <th>DOJ</th>
                                <th>Present</th>
                                <th>Late</th>
                                <th>Absent</th>
                                <th>Leave</th>
                            </tr>
                        </thead>
                        <tbody>";
        $i = 0;
        foreach ($all_data['employee_info'] as $key => $emp_value) {
            $i++;
            $prtots = collect($periodicAttendanceSum)->where('employee_id', $emp_value['id'])->where('pdate', '>=', $emp_value['employee_joining_date'])->where('pstatus', 1)->sum('totalDay');
            $lttots = collect($periodicAttendanceSum)->where('employee_id', $emp_value['id'])->where('pdate', '>=', $emp_value['employee_joining_date'])->where('pstatus', 2)->sum('totalDay');
            $abtots = collect($periodicAttendanceSum)->where('employee_id', $emp_value['id'])->where('pdate', '>=', $emp_value['employee_joining_date'])->where('pstatus', 3)->sum('totalDay');
            $whtotH = collect($periodicAttendanceSum)->where('employee_id', $emp_value['id'])->where('pdate', '>=', $emp_value['employee_joining_date'])->where('pstatus', 4)->sum('totalDay');
            $whtotW = collect($periodicAttendanceSum)->where('employee_id', $emp_value['id'])->where('pdate', '>=', $emp_value['employee_joining_date'])->where('pstatus', 5)->sum('totalDay');
            $levtot = collect($periodicAttendanceSum)->where('employee_id', $emp_value['id'])->where('pdate', '>=', $emp_value['employee_joining_date'])->where('pstatus', 6)->sum('totalDay');
            $whtotHt = (int) $whtotH + (int) $whtotW;
            $totals = (int) $prtots + (int) $lttots + (int) $abtots + (int) $whtotW + (int) $whtotH + (int) $levtot;
            $totalPD = (int) $prtots + (int) $lttots + (int) $whtotW + (int) $whtotH + (int) $levtot;
            if ($emp_value['employee_joining_date'] != '') {
                $date_of_joining = date('d M, Y', strtotime($emp_value['employee_joining_date']));
            } else {
                $date_of_joining = '';
            }

            $table .= "<tr data-toggle='collapse' data-target='#demo$i' class='accordion-toggle'>
                                <td class='text-center'> $i </td>
                                <td class='text-center'>" . $emp_value['employee_id_no'] . "</td>
                                <td>" . $emp_value['employee_fullname'] . "</td>
                                <td>" . $emp_value['designation_name'] . "</td>
                                <td>" . $emp_value['department_name'] . "</td>
                                <td>" . $emp_value['section_name'] . "</td>
                                <td>" . $emp_value['work_location_name'] . "</td>
                                <td>" . $date_of_joining . "</td>
                                <td class='text-center'>" . $prtots . "</td>
                                <td class='text-center'>" . $lttots . "</td>
                                <td class='text-center'>" . $abtots . "</td>
                                <td class='text-center'>" . $levtot . "</td>
                            </tr>
                            <tr >
                                <td colspan='13' class='hiddenRow'>
                                    <div class='accordian-body collapse' id='demo$i'>
                                        <table class='table table-striped' style='width:100%'>
                                            <thead>
                                                <tr style='background: #eee;'>
                                                    <th class='text-center'>SL.</th>
                                                    <th class='text-center'>Date</th>
                                                    <th class='text-center'>Shift</th>
                                                    <th class='text-center'>Shift Hour</th>
                                                    <th class='text-center'>In Time</th>
                                                    <th class='text-center'>Out Time</th>
                                                    <th class='text-center'>Late</th>
                                                    <th class='text-center'>Working Hour</th>
                                                    <th class='text-center'>Extra/Short Hour</th>
                                                    <th class='text-center'>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
            $j = 0;
            foreach ($daterange as $date) {
                $date = strtotime("+$j day", strtotime($search_option['from_date_formated']));
                $j++;
                $ind_attendance = collect($all_data['attendance_data'])->where('employee_id', $emp_value['id'])->where('pdate', date('Y-m-d', $date))->first();
                $get_shift_info = DB::table('attendance_setups')
                    ->leftJoin('office_time_setups', 'attendance_setups.attendance_office_time', '=', 'office_time_setups.id')
                    ->where('start_date', '<=', date('Y-m-d', $date))
                    ->where('end_date', '>=', date('Y-m-d', $date))
                    ->where('employee_id', $emp_value['id'])
                    ->first();
                $shift_title = isset($get_shift_info) ? $get_shift_info->title : '-';
                $intime = isset($ind_attendance->intime) ? $ind_attendance->intime : '-';
                $outime = isset($ind_attendance->outime) ? $ind_attendance->outime : '-';
                $latetime = isset($ind_attendance->latetime) ? $ind_attendance->latetime : '-';
                $start_time = isset($ind_attendance->start_time) ? $ind_attendance->start_time : '-';
                $end_time = isset($ind_attendance->end_time) ? $ind_attendance->end_time : '-';
                $shift_time = isset($ind_attendance->shift_time) ? $ind_attendance->shift_time : '-';
                $remarks = isset($ind_attendance->remarks) ? $ind_attendance->remarks : '-';

                $intimes = date('H:i', strtotime($intime));
                $outtimes = date('H:i', strtotime($outime));
                $work_time = strtotime($outtimes) - strtotime($intimes);

                $start_timess = date('H:i', strtotime($start_time));
                $end_timess = date('H:i', strtotime($end_time));
                $office_time = strtotime($end_timess) - strtotime($start_timess);
                $find_extra_second = $work_time - $office_time;
                if ($find_extra_second > 0) {
                    $extra_or_short_time = $find_extra_second;
                    $hour_of_extra_short = gmdate('H:i', $extra_or_short_time);
                } else {
                    $extra_or_short_time = -($find_extra_second);
                    $hour_of_extra_short = (gmdate('H:i', $extra_or_short_time));
                    if ($find_extra_second == 0) {
                        $hour_of_extra_short = '-';
                    } else {
                        $hour_of_extra_short = '(' . $hour_of_extra_short . ')';
                    }
                }
                if ($intime != '00:00:00') {
                    $hour_of_extra_short = $hour_of_extra_short;
                    $intime = $intime;
                    $outime = $outime;

                } else {
                    $hour_of_extra_short = '-';
                    $intime = '-';
                    $outime = '-';

                }
                if ($work_time != 0) {
                    $work_time = gmdate('H:i', $work_time);
                } else {
                    if ($intimes == 0 && $outtimes == 0) {
                        $work_time = gmdate('H:i', $work_time);
                    } else {
                        $work_time = '-';
                    }
                }
                $work_time = isset($work_time) ? $work_time : '-';
                $table .= "<tr>
                                                    <td class='text-center'> $j </td>
                                                    <td class='text-center'>" . date('d M, Y', $date) . "</td>
                                                    <td class='text-center'>" . $shift_title . "</td>
                                                    <td class='text-center'>" . $shift_time . "</td>
                                                    <td class='text-center'>" . $intime . "</td>
                                                    <td class='text-center'>" . $outime . "</td>
                                                    <td class='text-center'>" . $latetime . "</td>
                                                    <td class='text-center'>" . $work_time . "</td>
                                                    <td class='text-center'>" . $hour_of_extra_short . "</td>
                                                    <td class='text-center'>" . $remarks . "</td>
                                                </tr>";
            }
            $table .= "</tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>";
        }
        $table .=
            "</tbody>
                    </table>

                <style>
                    .table-collapse-inout tr {
                        cursor: pointer;
                    }
                    .hiddenRow {
                        padding: 0 4px !important;
                        background-color: #eeeeee;
                        font-size: 13px;
                    }
                </style>
                <script>



                    $(document).ready(function(){
                        $('.accordion-toggle').click(function(){
                          $('.accordian-body').removeClass('show');
                          $('.accordian-body').addClass('hide');
                        });
                      });


                </script>

                      ";



        return $table;

        //   view('reports.individual_report',compact('all_data','deptnameName','sbuName','date_report','created_by','sbuName'));
    }
    public function find_attendance_late_report($search_option)
    {
        $begin = new DateTime($search_option['from_date_formated']);
        $end = new DateTime($search_option['to_date_formated']);
        $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

        $employee_info = Employee::select('*')->valid()
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->select(
                'employees.*',
                'company_sbus.sbu_name',
                'company_sbus.sbu_logo',
                'departments.department_name',
                'sub_units.sub_unit_name',
                'designations.designation_name',
                'sections.section_name',
                'work_locations.work_location_name',
            )
            ->where('employees.employee_department', '!=', 132)
            ->where('employees.employee_status', 1)
            //   ->where('employees.id', $search_option['employee_ids'])
        ;
        if (!empty($search_option['employee_sbu'])) {
            $employee_info->wherein('employee_sbu', $search_option['employee_sbu']);
        }
        if (!empty($search_option['unit'])) {
            $employee_info->wherein('employee_unit', $search_option['unit']);
        }
        if (!empty($search_option['sub_unit'])) {
            $employee_info->wherein('employee_sub_unit', $search_option['sub_unit']);
        }
        if (!empty($search_option['employee_department'])) {
            $employee_info->wherein('employee_department', $search_option['employee_department']);
        }
        if (!empty($search_option['employee_section'])) {
            $employee_info->wherein('employee_section', $search_option['employee_section']);
        }
        if (!empty($search_option['employee_sub_section'])) {
            $employee_info->wherein('employee_sub_section', $search_option['employee_sub_section']);
        }
        if (!empty($search_option['employee_work_location'])) {
            $employee_info->wherein('employee_work_location', $search_option['employee_work_location']);
        }
        if (!empty($search_option['employee_designation'])) {
            $employee_info->where('employees.id', $search_option['employee_designation']);
        }
        if (!empty($search_option['employee_ids'])) {
            $employee_info->where('employees.id', $search_option['employee_ids']);
        }
        $all_data['employee_info'] = $employee_info->orderBy('designations.priority')->get()->toArray();

        $emplyids = array_pluck($all_data['employee_info'], 'id');
        //  echo"<pre>";
        // print_r($emplyids);
        // exit();
        $periodicAttendanceSum =
            Attendance::select('attendance.employee_id', 'pstatus', 'pdate', DB::raw('count(DISTINCT pdate) AS totalDay'))
                ->whereDate('pdate', '<=', $search_option['to_date_formated'])
                ->whereDate('pdate', '>=', $search_option['from_date_formated'])
                ->whereIn('employee_id', $emplyids)->groupBy('attendance.employee_id')->groupBy('attendance.pstatus')->get();
        $total = $prtot = $abtot = $lttot = $osdtot = $levtot = $whtot = 0;

        $all_data['attendance_data'] = DB::table('attendance')
            ->whereIn('employee_id', $emplyids)
            ->whereDate('pdate', '>=', $search_option['from_date_formated'])
            ->whereDate('pdate', '<=', $search_option['to_date_formated'])
            ->orderBy('attendance.pdate', 'ASC')
            ->orderBy('attendance.intime', 'ASC')
            ->get()
            ->toArray();
        $all_data['search_option'] = $search_option;

        // echo"<pre>";
        // print_r($all_data['attendance_data']);
        // exit();

        $company_id = isset($search_option['employee_sbus']) ? $search_option['employee_sbus'] : '';

        if ($search_option['employee_department']) {
            $deptname = Department::valid()->where('id', $search_option['employee_department'])->first();
            $deptnameName = $deptname['department_name'];
        } else {
            if (!empty($all_data['employee_info']['employee_department'])) {
                $deptname = Department::valid()->where('id', $all_data['employee_info']['employee_department'])->first();
                $deptnameName = $deptname['department_name'];
            } else {
                $deptnameName = 'No Data!';
            }
        }
        if (!empty($search_option['employee_sbu'])) {
            $sbuName = CompanySbu::valid()->wherein('id', $search_option['employee_sbu'])->first();
            $esbuName = $sbuName['sbu_name'];
        } else {
            $sbuName = [];
            $esbuName = "All";
        }


        $date_report = date("d M,Y", strtotime($search_option['from_date_formated'])) . " To " . date("d M,Y", strtotime($search_option['to_date_formated']));
        $created_by = Auth::guard('user')->user()->name;
        $table = " <table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'><div id='' class='section-to-print col-md-12'>
                    <div class='col-md-12'>
                      <div class='col-md-12'>
                      <div class='row' style='margin-left: 21px;'>
                      <table class='sssssss' style='width:100%'> <tr> <td style='width:20%'>
                      <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";
        if (!empty($sbuName)) {
            $companyLogo = $sbuName;
            if (!empty($companyLogo)) {
                if ($companyLogo['sbu_logo'] != "") {
                    $url = '/company_logo/' . $companyLogo["sbu_logo"];
                    $table .= '<img src="' . $url . '" style="width:25%;">';
                } else {
                    $table .= "No Logo Found";
                }
            } else {
                $url = '/company_logo/group_company_logo.png';
                $table .= '<img src="' . $url . '" style="width:25%;">';
            }
        } else {
            $url = '/company_logo/group_company_logo.png';
            $table .= '<img src="' . $url . '" style="width:25%;">';
        }

        // echo"<pre>";
        // print_r($all_data['employee_info']);
        // exit();
        // dd($all_data['employee_info']);
        if (!empty($all_data['employee_info'])) {
            $names = $all_data['employee_info'][0]['employee_fullname'] . " [ " . $all_data['employee_info'][0]['employee_id_no'];
            $designation_name = $all_data['employee_info'][0]['designation_name'];
            $department_name = $all_data['employee_info'][0]['department_name'];
            $sub_unit_name = $all_data['employee_info'][0]['sub_unit_name'];
            $sbu_name = $all_data['employee_info'][0]['sbu_name'];
        } else {
            $names = 'No Data!';
            $designation_name = 'No Data!';
            $department_name = 'No Data!';
            $sub_unit_name = 'No Data!';
            $sbu_name = 'No Data!';
        }

        $table .= "
                        <!--
                        <h6  style='margin:0px;'>
                          " . $names . " ]
                        </h6>

                         <p  style='margin:0px;'><strong> Designation: </strong> " . $designation_name . "</p>
                         <p  style='margin:0px;'><strong> Department: </strong> " . $department_name . "</p>
                         <p  style='margin:0px;'><strong> Sub Unit: </strong> " . $sub_unit_name . "</p>
                        -->

                      </div>
                       </td>
                      <td style='width:60%'>
                      <div class='col-md-12' style='margin:0px;text-align: center!important;'>
                        <h3 class='text-center' sstyle='margin:0px;text-align: center!important;'>Gemcon Group</h3>
                        <h5 class='text-center' style='margin:0px;text-align: center!important;'>" . $sbu_name . "</h5>
                        <h5 class='text-center' style='margin:0px;text-align: center!important;'>" . $deptnameName . "</h5>
                        <h6 class='text-center' style='margin:0px;text-align: center!important;'>Attendance Late Report</h6>
                        <h6 class='text-center' style='margin:0px;text-align: center!important;'>" . $date_report . "</h6>
                      </div>
                       </td>
                      <td style='width:20%'>
                      <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
                        <p ><strong> Print Date :</strong> " . date('d M,Y') . " </p>
                        <p style='margin-top: -7px'><strong> Created By :</strong> " . $created_by . " </p>
                      </div>
                      </td> </tr></table>

                    </div>
                      <br>
                    </div>
                     <table class='table table-striped' border='0' style='width:100%'>
                        <!--
                        <thead>
                            <tr style='background: #eee;'>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>SL.</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Name</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>ID</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Designation</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Department</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Section</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Work Location</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Date of Joining</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Date</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Shift</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Shift Hour</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>In Time</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Out Time</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Late</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Working Hour</th>
                            <th class='ths text-center' style='padding:2px 10px; text-align: center;'>Extra/Short Hour</th>
                            <th class='ths text-center' style='padding:2px 10px; width: 5%; text-align: center;'>Remarks</th>
                            </tr>
                        </thead>
                        -->
                      <tbody>
                      <table class='table table-condensed' style='border-collapse:collapse;'>
                        <!--
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Section</th>
                                <th>W. Location</th>
                                <th>DOJ</th>
                                <th>Present</th>
                                <th>Late</th>
                                <th>Absent</th>
                                <th>Leave</th>
                            </tr>
                        </thead>
                        -->
                        <thead>
                            <tr style='background: #eee;'>
                                <th class='text-center'>SL.</th>
                                <th class='text-center'>Date</th>
                                <th class='text-center'>ID</th>
                                <th class='text-center'>Name</th>
                                <th class='text-center'>Designation</th>
                                <th class='text-center'>Department</th>
                                <th class='text-center'>Section</th>
                                <th class='text-center'>W. Location</th>
                                <th class='text-center'>DOJ</th>
                                <th class='text-center'>Shift</th>
                                <th class='text-center'>Shift Hour</th>
                                <th class='text-center'>In Time</th>
                                <th class='text-center'>Out Time</th>
                                <th class='text-center'>Late</th>
                                <th class='text-center'>Working Hour</th>
                                <th class='text-center'>Extra/Short Hour</th>
                                <th class='text-center'>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>";
        $i = 0;
        foreach ($all_data['employee_info'] as $key => $emp_value) {
            $i++;
            $prtots = collect($periodicAttendanceSum)->where('employee_id', $emp_value['id'])->where('pdate', '>=', $emp_value['employee_joining_date'])->where('pstatus', 1)->sum('totalDay');
            $lttots = collect($periodicAttendanceSum)->where('employee_id', $emp_value['id'])->where('pdate', '>=', $emp_value['employee_joining_date'])->where('pstatus', 2)->sum('totalDay');
            $abtots = collect($periodicAttendanceSum)->where('employee_id', $emp_value['id'])->where('pdate', '>=', $emp_value['employee_joining_date'])->where('pstatus', 3)->sum('totalDay');
            $whtotH = collect($periodicAttendanceSum)->where('employee_id', $emp_value['id'])->where('pdate', '>=', $emp_value['employee_joining_date'])->where('pstatus', 4)->sum('totalDay');
            $whtotW = collect($periodicAttendanceSum)->where('employee_id', $emp_value['id'])->where('pdate', '>=', $emp_value['employee_joining_date'])->where('pstatus', 5)->sum('totalDay');
            $levtot = collect($periodicAttendanceSum)->where('employee_id', $emp_value['id'])->where('pdate', '>=', $emp_value['employee_joining_date'])->where('pstatus', 6)->sum('totalDay');
            $whtotHt = (int) $whtotH + (int) $whtotW;
            $totals = (int) $prtots + (int) $lttots + (int) $abtots + (int) $whtotW + (int) $whtotH + (int) $levtot;
            $totalPD = (int) $prtots + (int) $lttots + (int) $whtotW + (int) $whtotH + (int) $levtot;
            if ($emp_value['employee_joining_date'] != '') {
                $date_of_joining = date('d M, Y', strtotime($emp_value['employee_joining_date']));
            } else {
                $date_of_joining = '';
            }

            $j = 0;
            foreach ($daterange as $date) {
                $date = strtotime("+$j day", strtotime($search_option['from_date_formated']));
                $j++;
                $ind_attendance = collect($all_data['attendance_data'])->where('employee_id', $emp_value['id'])->where('pdate', date('Y-m-d', $date))->first();
                $get_shift_info = DB::table('attendance_setups')
                    ->leftJoin('office_time_setups', 'attendance_setups.attendance_office_time', '=', 'office_time_setups.id')
                    ->where('start_date', '<=', date('Y-m-d', $date))
                    ->where('end_date', '>=', date('Y-m-d', $date))
                    ->where('employee_id', $emp_value['id'])
                    ->first();
                $shift_title = isset($get_shift_info) ? $get_shift_info->title : '-';
                $intime = isset($ind_attendance->intime) ? $ind_attendance->intime : '-';
                $outime = isset($ind_attendance->outime) ? $ind_attendance->outime : '-';
                $latetime = isset($ind_attendance->latetime) ? $ind_attendance->latetime : '-';
                $start_time = isset($ind_attendance->start_time) ? $ind_attendance->start_time : '-';
                $end_time = isset($ind_attendance->end_time) ? $ind_attendance->end_time : '-';
                $shift_time = isset($ind_attendance->shift_time) ? $ind_attendance->shift_time : '-';
                $remarks = isset($ind_attendance->remarks) ? $ind_attendance->remarks : '-';

                $intimes = date('H:i', strtotime($intime));
                $outtimes = date('H:i', strtotime($outime));
                $work_time = strtotime($outtimes) - strtotime($intimes);

                $start_timess = date('H:i', strtotime($start_time));
                $end_timess = date('H:i', strtotime($end_time));
                $office_time = strtotime($end_timess) - strtotime($start_timess);
                $find_extra_second = $work_time - $office_time;
                if ($find_extra_second > 0) {
                    $extra_or_short_time = $find_extra_second;
                    $hour_of_extra_short = gmdate('H:i', $extra_or_short_time);
                } else {
                    $extra_or_short_time = -($find_extra_second);
                    $hour_of_extra_short = (gmdate('H:i', $extra_or_short_time));
                    if ($find_extra_second == 0) {
                        $hour_of_extra_short = '-';
                    } else {
                        $hour_of_extra_short = '(' . $hour_of_extra_short . ')';
                    }
                }
                if ($intime != '00:00:00') {
                    $hour_of_extra_short = $hour_of_extra_short;
                    $intime = $intime;
                    $outime = $outime;

                } else {
                    $hour_of_extra_short = '-';
                    $intime = '-';
                    $outime = '-';

                }
                if ($work_time != 0) {
                    $work_time = gmdate('H:i', $work_time);
                } else {
                    if ($intimes == 0 && $outtimes == 0) {
                        $work_time = gmdate('H:i', $work_time);
                    } else {
                        $work_time = '-';
                    }
                }
                $work_time = isset($work_time) ? $work_time : '-';
                $table .= "<tr>
                                            <td class='text-center'> $j </td>
                                            <td class='text-center'>" . date('d M, Y', $date) . "</td>
                                            <td class='text-center'>" . $emp_value['employee_id_no'] . "</td>
                                            <td>" . $emp_value['employee_fullname'] . "</td>
                                            <td>" . $emp_value['designation_name'] . "</td>
                                            <td>" . $emp_value['department_name'] . "</td>
                                            <td>" . $emp_value['section_name'] . "</td>
                                            <td>" . $emp_value['work_location_name'] . "</td>
                                            <td>" . $date_of_joining . "</td>
                                            <td class='text-center'>" . $shift_title . "</td>
                                            <td class='text-center'>" . $shift_time . "</td>
                                            <td class='text-center'>" . $intime . "</td>
                                            <td class='text-center'>" . $outime . "</td>
                                            <td class='text-center'>" . $latetime . "</td>
                                            <td class='text-center'>" . $work_time . "</td>
                                            <td class='text-center'>" . $hour_of_extra_short . "</td>
                                            <td class='text-center'>" . $remarks . "</td>
                                        </tr>";
            }

            $table .= "
                            <!--
                            <tr data-toggle='collapse' data-target='#demo$i' class='accordion-toggle'>
                                <td class='text-center'> $i </td>
                                <td class='text-center'>" . $emp_value['employee_id_no'] . "</td>
                                <td>" . $emp_value['employee_fullname'] . "</td>
                                <td>" . $emp_value['designation_name'] . "</td>
                                <td>" . $emp_value['department_name'] . "</td>
                                <td>" . $emp_value['section_name'] . "</td>
                                <td>" . $emp_value['work_location_name'] . "</td>
                                <td>" . $date_of_joining . "</td>
                                <td class='text-center'>" . $prtots . "</td>
                                <td class='text-center'>" . $lttots . "</td>
                                <td class='text-center'>" . $abtots . "</td>
                                <td class='text-center'>" . $levtot . "</td>
                            </tr>

                            <tr>
                                <td colspan='13' class='hiddenRow'>
                                    <div class='accordian-body collapse' id='demo$i'>
                                        <table class='table table-striped' style='width:100%'>
                                            <thead>
                                                <tr style='background: #eee;'>
                                                    <th class='text-center'>SL.</th>
                                                    <th class='text-center'>ID</th>
                                                    <th class='text-center'>Name</th>
                                                    <th class='text-center'>Designation</th>
                                                    <th class='text-center'>Department</th>
                                                    <th class='text-center'>Section</th>
                                                    <th class='text-center'>W. Location</th>
                                                    <th class='text-center'>DOJ</th>
                                                    <th class='text-center'>Date</th>
                                                    <th class='text-center'>Shift</th>
                                                    <th class='text-center'>Shift Hour</th>
                                                    <th class='text-center'>In Time</th>
                                                    <th class='text-center'>Out Time</th>
                                                    <th class='text-center'>Late</th>
                                                    <th class='text-center'>Working Hour</th>
                                                    <th class='text-center'>Extra/Short Hour</th>
                                                    <th class='text-center'>Remarks</th>
                                                </tr>
                                            </thead>
                                 -->
                                            <tbody>";
            // $j = 0;
            // foreach($daterange as $date){
            //     $date = strtotime("+$j day", strtotime($search_option['from_date_formated']));
            //     $j++;
            //     $ind_attendance = collect($all_data['attendance_data'])->where('employee_id', $emp_value['id'])->where('pdate', date('Y-m-d', $date))->first();
            //     $get_shift_info = DB::table('attendance_setups')
            //     ->leftJoin('office_time_setups', 'attendance_setups.attendance_office_time', '=', 'office_time_setups.id')
            //     ->where('start_date', '<=', date('Y-m-d', $date))
            //     ->where('end_date', '>=', date('Y-m-d', $date))
            //     ->where('employee_id', $emp_value['id'])
            //     ->first();
            //     $shift_title = isset($get_shift_info) ? $get_shift_info->title : '-';
            //     $intime = isset($ind_attendance->intime) ? $ind_attendance->intime : '-';
            //     $outime = isset($ind_attendance->outime) ? $ind_attendance->outime : '-';
            //     $latetime = isset($ind_attendance->latetime) ? $ind_attendance->latetime : '-';
            //     $start_time = isset($ind_attendance->start_time) ? $ind_attendance->start_time : '-';
            //     $end_time = isset($ind_attendance->end_time) ? $ind_attendance->end_time : '-';
            //     $shift_time = isset($ind_attendance->shift_time) ? $ind_attendance->shift_time : '-';
            //     $remarks = isset($ind_attendance->remarks) ? $ind_attendance->remarks : '-';

            //     $intimes = date('H:i', strtotime($intime));
            //     $outtimes = date('H:i', strtotime($outime));
            //     $work_time = strtotime($outtimes) - strtotime($intimes);

            //     $start_timess = date('H:i', strtotime($start_time));
            //     $end_timess = date('H:i', strtotime($end_time));
            //     $office_time = strtotime($end_timess) - strtotime($start_timess);
            //     $find_extra_second = $work_time - $office_time;
            //     if($find_extra_second > 0 ){
            //         $extra_or_short_time = $find_extra_second;
            //         $hour_of_extra_short = gmdate('H:i', $extra_or_short_time);
            //     }else{
            //         $extra_or_short_time = -($find_extra_second);
            //         $hour_of_extra_short = (gmdate('H:i', $extra_or_short_time));
            //         if($find_extra_second == 0 ){
            //             $hour_of_extra_short = '-';
            //         }else{
            //             $hour_of_extra_short = '('.$hour_of_extra_short.')';
            //         }
            //     }
            //     if($intime != '00:00:00'){
            //         $hour_of_extra_short = $hour_of_extra_short;
            //         $intime = $intime;
            //         $outime = $outime;

            //     }else{
            //         $hour_of_extra_short = '-';
            //         $intime = '-';
            //         $outime = '-';

            //     }
            //     if($work_time != 0){
            //         $work_time = gmdate('H:i', $work_time);
            //     }else{
            //         if($intimes == 0 && $outtimes == 0){
            //             $work_time = gmdate('H:i', $work_time);
            //         }else{
            //             $work_time = '-';
            //         }
            //     }
            //     $work_time = isset($work_time) ? $work_time : '-';
            //     $table .= "<tr>
            //             <td class='text-center'> $j </td>
            //             <td class='text-center'>" .$emp_value['employee_id_no']. "</td>
            //             <td>" .$emp_value['employee_fullname']. "</td>
            //             <td>" .$emp_value['designation_name']. "</td>
            //             <td>" .$emp_value['department_name']. "</td>
            //             <td>" .$emp_value['section_name']. "</td>
            //             <td>" .$emp_value['work_location_name']. "</td>
            //             <td>" .$date_of_joining. "</td>
            //             <td class='text-center'>" .date('d M, Y', $date). "</td>
            //             <td class='text-center'>" .$shift_title. "</td>
            //             <td class='text-center'>" .$shift_time. "</td>
            //             <td class='text-center'>" .$intime. "</td>
            //             <td class='text-center'>" .$outime. "</td>
            //             <td class='text-center'>" .$latetime. "</td>
            //             <td class='text-center'>" .$work_time. "</td>
            //             <td class='text-center'>" .$hour_of_extra_short. "</td>
            //             <td class='text-center'>" .$remarks. "</td>
            //         </tr>";
            //     }
            //     $table .="</tbody>
            // </table>
            // </div>
            // </td>
            // </tr>";
        }
        $table .=
            "</tbody>
                    </table>

                <style>
                    .table-collapse-inout tr {
                        cursor: pointer;
                    }
                    .hiddenRow {
                        padding: 0 4px !important;
                        background-color: #eeeeee;
                        font-size: 13px;
                    }
                </style>
                <script>



                    $(document).ready(function(){
                        $('.accordion-toggle').click(function(){
                          $('.accordian-body').removeClass('show');
                          $('.accordian-body').addClass('hide');
                        });
                      });


                </script>

                      ";



        return $table;

        //   view('reports.individual_report',compact('all_data','deptnameName','sbuName','date_report','created_by','sbuName'));
    }


    // public function search_report(Request $Request){
    //   $from_date = request()->from_date;
    //   $to_date = request()->to_date;
    //   $strDate1 = substr($from_date,4,11);
    //   $strDate2 = substr($to_date,4,11);
    //   $from_date_formated = date('Y-m-d', strtotime($strDate1));
    //   $to_date_formated = date('Y-m-d', strtotime($strDate2));
    //   $report_type = request()->report_type;
    //   $employee_sbu = request()->employee_sbu;
    //   $att_report_type = request()->att_report_type;
    //   $checkedattcolsadd = request()->checkedattcolsadd;
    //   // $column_data['columnArray'] = $columnArray= explode(',', $checkedattcolsadd);
    //   $column_data= $columnArray= explode(',', $checkedattcolsadd);
    //   $column_name_data = $this->column_real_name($columnArray);
    //   // echo "<pre>"; print_r($column_name_data); die();
    //   $date_print['from_date_formated'] = $from_date_formated;


    //   /* office time query needed */
    //   /* employee wise attendance log query */
    //   /* employee wise leave query */
    //   /* holiday query && weekend */
    //   /* */
    //   $all_data =array();
    //   if (!empty($column_name_data) && $report_type==1 && $att_report_type==1) {
    //       $query =DB::table('employees')
    //       ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
    //       ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
    //       ->leftJoin('sub_sections', 'sub_sections.id', '=', 'employees.employee_section')
    //       ->leftJoin('employee_groups', 'employee_groups.id', '=', 'employees.employee_section')
    //       ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
    //       ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
    //       ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
    //       ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
    //       ->select(
    //         // 'employees.*',
    //         'employees.employee_id_no',
    //         'employees.employee_fullname',
    //         'company_sbus.sbu_name',
    //         'sections.section_name',
    //         'sub_sections.sub_section_name',
    //         'employee_groups.employee_group_name',
    //         'departments.department_name',
    //         'designations.designation_name',
    //         'sub_units.sub_unit_name',
    //         'work_locations.work_location_name'
    //       )->where('employees.employee_status',1);
    //     if (!empty($employee_sbu)) {
    //         $query->where('employees.employee_sbu',$employee_sbu);
    //     }
    //     $all_employee= $query->get();

    //     foreach ($all_employee as $key => $value) {
    //       $data['employee_id_no'] = isset($value->employee_id_no)?$value->employee_id_no:'';
    //       $data['employee_full_name'] = isset($value->employee_fullname)?$value->employee_fullname:'';
    //       $data['sbu_name'] = isset($value->sbu_name)?$value->sbu_name:'';
    //       $data['section_name'] = isset($value->section_name)?$value->section_name:'';
    //       $data['department_name'] = isset($value->department_name)?$value->department_name:'';
    //       $data['designation_name'] = isset($value->designation_name)?$value->designation_name:'';
    //       $data['sub_section_name'] = isset($value->sub_section_name)?$value->sub_section_name:'';

    //       $in_data= DB::table('attendance_log')
    //                 ->select(
    //                   DB::RAW('min(attendance_log.id) as in_id'),
    //                   'attendance_log.employee_id',
    //                   'TransactionDate',
    //                   'TransactionTime as in_time',
    //                 )
    //                 ->where('employee_id', '=', $value->employee_id_no)
    //                 ->whereDate('TransactionDate', '=', $from_date_formated)
    //                 ->groupBy(DB::RAW('employee_id'))
    //                 ->get();
    //       $out_data = DB::select("SELECT employee_id,TransactionDate,TransactionTime as out_time FROM attendance_log WHERE id IN
    //                   (SELECT MAX(id) FROM attendance_log
    //                   WHERE TransactionDate = '".$from_date_formated."'
    //                   AND employee_id = '". $value->employee_id_no."'
    //                   GROUP BY employee_id
    //                   )
    //                   ORDER BY id ASC");
    //       // $shift_time = $company_sbu_data=OfficeTimeSetup::valid()->project()->where('employee_id', '=', $value->employee_id_no)->first();

    //       // echo "<pre>"; print_r($shift_time); echo "<pre>";

    //          if ($in_data->isEmpty() && count($out_data)==0) {
    //            $data['shift_time'] = '09:00 - 18:00';
    //            $data['in_time'] = '00:00';
    //            $data['out_time'] = '00:00';
    //            $data['late'] = '00:00';
    //            $data['status'] = 'A';
    //            $data['remarks'] = '';
    //            array_push($all_data,$data);
    //          }else{
    //             $data['shift_time'] = '09:00 - 18:00';
    //             $data['in_time'] = $in_data[0]->in_time;
    //             $data['out_time'] = $out_data[0]->out_time;
    //             $data['late'] = '00:00';
    //             $data['status'] = 'P';
    //             $data['remarks'] = '';
    //             array_push($all_data,$data);
    //          }

    //       }/*loop end*/
    //       // echo "<pre>"; print_r($columnArray); die();
    //       // $all_data = $data;
    //    }
    //   return view('layouts.report',compact('all_data','column_data','column_name_data','date_print'));
    // }
}
