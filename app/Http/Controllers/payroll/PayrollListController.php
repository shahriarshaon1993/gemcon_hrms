<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
// use Session;
use App\Model\payroll\PayrollList;
use App\Model\payroll\PayrollProcessList;
use App\Model\payroll\ProvidentFund;
use App\Model\Employee;
use App\Model\CompanySbu;
// use App\Model\Department;
// use App\Model\Designation;
// use App\Model\JobGrade;
// use App\Model\LeaveType;
// use App\Model\LeaveApplication;
// use App\Model\EmployeeApproval;
use App\Model\UsersPersonModel;
use App\Model\payroll\SalarySetting;
use App\Model\payroll\Salary;
use Cache;
// use permission;
use DB;

// use App\Model\UserRoleAccess;

class PayrollListController extends Controller
{
    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */

    public function index(Request $request)
    {
        $employee_list = new Employee();
        $employee_ids=$employee_list->Employee_id();
        $employee_id=$employee_ids['employee_id'];

        $cache=Cache::get('permission');
        $permission=collect($cache)->where('menu_uid', '=', 'PayrollList')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
        foreach ($permission as $child) {
            if ($child['link_uid']=='add') {
                $data['add']=$child['link_uid'];
            } elseif ($child['link_uid']=='edit') {
                $data['edit']=$child['link_uid'];
            } elseif ($child['link_uid']=='delete') {
                $data['delete']=$child['link_uid'];
            } else {
                $data['view']=$child['link_uid'];
            }
        }

        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $project_id=Auth::guard('user')->user()->project_id;
        // $branch_id=Auth::guard('user')->user()->branch_id;
        $paginate_data =PayrollProcessList::valid()->project()
        ->leftJoin('company_sbus', 'company_sbus.id', '=', 'payroll_process.companysbu_id')
        ->select(
            'payroll_process.*',
            'company_sbus.sbu_name'
        )
        ->when($search_key, function ($query, $search_key) {
            $query->where(function ($query2) use ($search_key) {
                $query2->where('payroll_process.paymonth', 'LIKE', '%'.$search_key.'%')
                ->orWhere('company_sbus.sbu_name', 'LIKE', '%'.$search_key.'%')
                ;
            });
            return $query;
        })->whereIn('company_sbus.id', $employee_ids['sub']) ->where('payroll_process.project_id', $project_id) ->orderBy($sort, $order);
        // ->paginate($paginate_num);
        $sortData=$paginate_data;
        $sortGetData=$sortData->get();
        $data['total_data']=count($sortGetData);
        $data['active_data']=count(collect($sortGetData)->where('employee_status', 1)->toArray());
        $data['inactive_data']=count(collect($sortGetData)->whereIn('employee_status', 2)->toArray());
        $data['paginate_data'] =$sortData->paginate($paginate_num);

        return response()->json($data);
    }


    public function store(Request $request)
    {
        $validate=[
          'employee_id'=>'required',
          'basic_salary'=>'required'
        ];

        $request->validate($validate);
        $data=$request->only('gross_salary', 'employee_id', 'basic_salary', 'confirmation_date', 'housing_allowance', 'medical_allowance', 'conveyance_allowance', 'overtime_work_compensation', 'employee_status', 'type', 'others_allowance', 'increment_type', 'increment_percentage', 'car_allowance_status', 'car_allowance_amount');

        if (!empty($request->id)) {
            // return response()->json($request);
            $update_data=PayrollProcessList::valid()->project()->findOrFail($request->id);
            $data['updated_by']=Auth::guard('user')->user()->id;
            $save_data=$update_data->update($data);
            $message=['status' => 1, 'message' => 'Your data is successfully updated'];
        } else {
            $data['project_id']=Auth::guard('user')->user()->project_id;
            $data['branch_id']=Auth::guard('user')->user()->branch_id;
            $data['created_by']=Auth::guard('user')->user()->id;
            $data['employee_status']=1;
            $data['type']=2;
            $save_data=PayrollProcessList::create($data);
            $message=['status' => 1, 'message' => 'Your data is successfully saved'];
        }

        if (!$save_data) {
            $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
        }
        return response($message);
    }

    // public function employee_salary_update(Request $request){
    //   $data=$request->only('gross_salary','basic','houserent','medical','transport','arear','medical','car_allowance','deduction_pfbasic','deduction_uniform','deduction_deposit','deduction_tax','deduction_mobilebill','deduction_others');
    //   $save_data = '';
    //   if(!empty($request->id)) {
//     $update_data=PayrollList::valid()->project()->where('empid', $request->id)->where('procsid', $request->procsid)->first();
//     $data['updated_by']= Auth::guard('user')->user()->id;
//     $data['updated_at']=  date('Y-m-d H:i:s');
//     $save_data=$update_data->update($data);
//     $message=['status' => 1, 'message' => 'Your data is successfully updated'];
    //   }
    //   if(!$save_data){
//     $message=['status' => 0, 'message' => 'Opps! Something went worng.'];
    //   }
    //   return response($message);
    // }

    public function edit($id)
    {
        $data=PayrollProcessList::valid()->project()->findOrFail($id);
        $employee_data=array();
        $employee_data_list=Employee::valid()->project()->get()->keyBy('id')->all();
        foreach ($employee_data_list as $value) {
            array_push($employee_data, ['id'=>$value['id'],'text'=>$value['employee_id_no']." - ". $value['employee_fullname']]);
        }

        $employee_list = new Employee();
        $employee_ids=$employee_list->Employee_id();
        $employee_id=$employee_ids['employee_id'];

        $user_employee_data=Employee::valid()->project()
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
          ->select(
              'employees.*',
              'company_sbus.sbu_name',
              'sections.section_name',
              'departments.department_name',
              'designations.designation_name',
              'sub_units.sub_unit_name',
              'work_locations.work_location_name',
              'employee_personal_infos.employee_gender'
          )
          ->where('employees.id', $data->employee_id)->first();

        $user_employee_data_all=Employee::valid()->project()
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
          ->select(
              'employees.*',
              'company_sbus.sbu_name',
              'sections.section_name',
              'departments.department_name',
              'designations.designation_name',
              'sub_units.sub_unit_name',
              'work_locations.work_location_name',
              'employee_personal_infos.employee_gender'
          )->whereIn('employee_sbu', $employee_ids['sub'])
            ->whereIn('employee_department', $employee_ids['department'])
          ->get()->keyBy('id');

        if (!$data->employee_id) {
            $data->employee_name_value = ['id'=>'','text'=>''];
        } else {
            $data->employee_name_value = ['id'=>$data->employee_id,'text'=>$employee_data_list[$data->employee_id]->employee_fullname];
        }

        $salary_setting=SalarySetting::valid()->project()->where('status', 1)->where('company_sbu_id', $user_employee_data->employee_sbu)->first();
        $data->salary_setting = $salary_setting;

        $employee_salary=PayrollProcessList::valid()->project()->where('employee_id', $data->employee_id)->where('type', 1)->first();
        $data->employee_salary = $employee_salary;

        $data->user_employee_data_all = $user_employee_data_all;
        $data->user_employee_data = $user_employee_data;
        $data->employee_data =  $employee_data;
        // return response($salary_setting);
        return response($data);
    }
    public function employee_salary_edit($process_id = null, $id=null)
    {
        $data=PayrollList::valid()->project()
          ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
          ->select(
              'payroll.*',
              'employees.*',
              'employees.id as employee_pri_id',
              'company_sbus.sbu_name',
              'sections.section_name',
              'departments.department_name',
              'designations.designation_name',
              'sub_units.sub_unit_name',
              'work_locations.work_location_name',
              'employee_personal_infos.employee_gender'
          )
          ->where('empid', $id)->where('procsid', $process_id)->first();
        return response($data);
    }

      public function create($id=false)
      {
          $user_id = Auth::guard('user')->user()->id;
          $employee_list = new Employee();
          $employee_ids=$employee_list->Employee_id();
          $employee_id=$employee_ids['employee_id'];

          $user_data=UsersPersonModel::valid()->project()->where('id', $user_id)->first();
          if (!empty($id)) {
              $employee_id = $id;
          } else {
              $employee_id = $user_data->employee_id;
          }
          $user_employee_data=Employee::valid()->project()
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->select(
                'employees.*',
                'company_sbus.sbu_name',
                'sections.section_name',
                'departments.department_name',
                'designations.designation_name',
                'sub_units.sub_unit_name',
                'work_locations.work_location_name',
                'employee_personal_infos.employee_gender'
            )
            ->where('employees.id', $employee_id)->first();
          // return response($user_employee_data->employee_sbu);
          $data['employee_data']=array();
          $employee_data=Employee::valid()->project()->get();
          foreach ($employee_data as $value) {
              array_push($data['employee_data'], ['id'=>$value['id'],'text'=>$value['employee_id_no']." - ". $value['employee_fullname']]);
          }

          $user_employee_data_all=Employee::valid()->project()
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->select(
                'employees.*',
                'company_sbus.sbu_name',
                'company_sbus.id as company_sbu_id',
                'sections.section_name',
                'departments.department_name',
                'designations.designation_name',
                'sub_units.sub_unit_name',
                'work_locations.work_location_name',
                'employee_personal_infos.employee_gender'
            )->whereIn('employee_sbu', $employee_ids['sub'])
              ->whereIn('employee_department', $employee_ids['department'])
            ->get()->keyBy('id');

          $salary_setting=SalarySetting::valid()->project()->where('status', 1)->where('company_sbu_id', $user_employee_data->employee_sbu)->first();
          $employee_salary=PayrollProcessList::valid()
          // ->selectRaw(
          //   'payroll_process.*
          //   '
          // )
          ->project()->where('employee_id', $id)->get();

          $data['salary_setting'] = $salary_setting;
          // $data['employee_salary']= $employee_salary;
          $data['employee_salary']['gross_salary'] = collect($employee_salary)->sum('gross_salary');
          $data['employee_salary']['basic_salary'] = collect($employee_salary)->sum('basic_salary');
          $data['user_employee_data_all'] = $user_employee_data_all;
          $data['user_employee_data'] = $user_employee_data;
          // $data['profile_open'] = 1;
          // this.profile_open = 1;
          return response($data);
      }

      public function payroll_list_details(Request $request)
      {
        //   return response($request);
          $cache = Cache::get('permission');
          $permission=collect($cache)->where('menu_uid', '=', 'PayrollList')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
          foreach ($permission as $child) {
              if ($child['link_uid']=='add') {
                  $data['add']=$child['link_uid'];
              } elseif ($child['link_uid']=='edit') {
                  $data['edit']=$child['link_uid'];
              } elseif ($child['link_uid']=='delete') {
                  $data['delete']=$child['link_uid'];
              } else {
                  $data['view']=$child['link_uid'];
              }
          }
          $payrolInfo=PayrollList::valid()
          ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->where('procsid', $request['page_ref_id'])
          ->orderBy('designations.priority')
          ->get();
          $employee_all_id=collect($payrolInfo)->pluck('empid')->toArray();
          $data['page_ref_id'] = $request['page_ref_id'];
          // $sbu_id = isset()
          $payrollData=PayrollProcessList::valid()->where('id', $request['page_ref_id'])->first();
          // return response($payrollData->companysbu_id);
          $find_comapny_info = CompanySbu::valid()->where('id', $payrollData->companysbu_id)->first();
          $data['company_info'] = isset($find_comapny_info->sbu_name) ? $find_comapny_info->sbu_name : 'Gemcon Group';
          $data['final_settlement'] = $payrollData->settlement;
          $data['company_id'] = $payrollData->companysbu_id;
          // return response($request);
          // return response($data['final_settlement']);
          $attendanceInfo=DB::table('attendance')
                            ->select('attendance.employee_id', 'pstatus', 'pdate', DB::raw('count(DISTINCT pdate) AS totalDay'))
                            ->whereDate('pdate', '>=', $payrollData['startdate'])
                            ->whereDate('pdate', '<=', $payrollData['enddate'])
                            ->whereIn('employee_id', $employee_all_id)
                            ->groupBy('attendance.employee_id')
                            ->groupBy('attendance.pstatus')->get();
          $data['month_name']=$payrollData['paymonth'];
        //   $SalaryInfo=Salary::valid()->whereIn('employee_id', $employee_all_id)->where('company_sbu_id', $payrollData['companysbu_id'])->where('salary_goes_to', $payrollData['type'])->get();
          $employee_data=Employee::valid()->project()
              ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
              ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
              ->leftJoin('employee_bank_account_details', 'employee_bank_account_details.ebc_employee_id', '=', 'employees.id')
              ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
              ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
              ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
              ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
              ->select(
                  'employees.*',
                  'company_sbus.sbu_name',
                  'company_sbus.sbu_short_name',
                  'job_grades.jobgrade_name',
                  'employee_bank_account_details.ebc_account_number',
                  'employee_personal_infos.employee_gender',
                  'designations.designation_name',
                  'departments.department_name',
                  'work_locations.work_location_name'
              )->whereIn('employees.id', $employee_all_id)

              ->get();

            $total_gross_salary = 0;  
            $total_absent_amount = 0;  
            $total_gross_payable = 0;  
            $total_basic = 0;  
            $total_houserent = 0;  
            $total_medical = 0;  
            $total_transport = 0;  
            $total_arear = 0;  
            $total_additional_mobile = 0;  
            $total_car_allowance = 0;  
            $total_incentive = 0;  
            $total_allowance = 0;  
            $total_other_allownce = 0;  
            $total_deduction_pfbasic = 0;  
            $total_deduction_loan = 0;  
            $total_deduction_uniform = 0;  
            $total_deduction_deposit = 0;  
            $total_deduction_tax = 0;  
            $total_deduction_mobilebill = 0;  
            $total_late_deduction = 0;  
            $total_deduction_others = 0;  
            $total_netpay = 0;
            foreach ($payrolInfo as $key => $value) {
                $total_gross_salary += $value['gross_salary'];  
                $total_absent_amount += $value['absent_deduction'];  
                $total_gross_payable += $value['gross_payable'];  
                $total_basic += $value['basic'];  
                $total_houserent += $value['houserent'];  
                $total_medical += $value['medical'];  
                $total_transport += $value['transport'];  
                $total_arear += $value['arear'];  
                $total_additional_mobile += $value['additional_mobile'];  
                $total_car_allowance += $value['car_allowance'];  
                $total_incentive += $value['incentive'];  
                $total_allowance += $value['allowance'];  
                $total_other_allownce += $value['other_allownce'];  
                $total_deduction_pfbasic += $value['deduction_pfbasic'];  
                $total_deduction_loan += $value['deduction_loan'];  
                $total_deduction_uniform += $value['deduction_uniform'];  
                $total_deduction_deposit += $value['deduction_deposit'];  
                $total_deduction_tax += $value['deduction_tax'];  
                $total_deduction_mobilebill += $value['deduction_mobilebill'];  
                $total_late_deduction += $value['late_deduction'];  
                $total_deduction_others += $value['deduction_others'];  
                $total_netpay += $value['netpay'];
              // $payrolInfo[$key]['prtot']=collect($attendanceInfo)->where('employee_id',$value->empid)->where('pstatus',1)->count();
              //   $payrolInfo[$key]['lttot']=collect($attendanceInfo)->where('employee_id',$value->empid)->where('pstatus',2)->count();
              //   $payrolInfo[$key]['abtot']=collect($attendanceInfo)->where('employee_id',$value->empid)->where('pstatus',3)->count();
              //   $payrolInfo[$key]['whtot']=collect($attendanceInfo)->where('employee_id',$value->empid)->whereIn('pstatus',['4','5'])->count();
              //   $payrolInfo[$key]['levtot']=collect($attendanceInfo)->where('employee_id',$value->empid)->where('pstatus',6)->count();
              //   $payrolInfo[$key]['total']=collect($attendanceInfo)->where('employee_id',$value->empid)->count();

              $prtots = collect($attendanceInfo)->where('employee_id', $value->empid)->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 1)->sum('totalDay');
              $lttots = collect($attendanceInfo)->where('employee_id', $value->empid)->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 2)->sum('totalDay');
              $abtots = collect($attendanceInfo)->where('employee_id', $value->empid)->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 3)->sum('totalDay');
              $whtotH = collect($attendanceInfo)->where('employee_id', $value->empid)->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 4)->sum('totalDay');
              $whtotW = collect($attendanceInfo)->where('employee_id', $value->empid)->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 5)->sum('totalDay');
              $levtot = collect($attendanceInfo)->where('employee_id', $value->empid)->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 6)->sum('totalDay');
              $whtotHt = (int) $whtotH + (int) $whtotW ;
              $totals = (int) $prtots + (int) $lttots + (int) $abtots + (int) $whtotW + (int) $whtotH + (int) $levtot ;
              $totalPD = (int) $prtots + (int) $lttots + (int) $whtotW + (int) $whtotH + (int) $levtot ;

              $payrolInfo[$key]['prtot'] = $prtots;
              $payrolInfo[$key]['lttot'] = $lttots;
              $payrolInfo[$key]['abtot'] = $abtots;
              $payrolInfo[$key]['whtot'] = $whtotHt;
              $payrolInfo[$key]['levtot'] = $levtot;
              $payrolInfo[$key]['total'] = $totals;
              $payrolInfo[$key]['pay_day'] = $value['paydays'];

              // $payrolInfo[$key]['pay_day']=(collect($attendanceInfo)->where('employee_id',$value->empid)->count()-collect($attendanceInfo)->where('employee_id',$value->empid)->where('pstatus',3)->count());

              $employeeInfo=collect($employee_data)->where('id', $value->empid)->first();
              $payrolInfo[$key]['employee_id_no']=isset($employeeInfo) ? $employeeInfo['employee_id_no'] : '-';
              $payrolInfo[$key]['employee_fullname']=isset($employeeInfo) ? $employeeInfo['employee_fullname'] : '-';
              $payrolInfo[$key]['designation_name']=isset($employeeInfo) ? $employeeInfo['designation_name'] : '-';
              $payrolInfo[$key]['department_name']=isset($employeeInfo) ? $employeeInfo['department_name'] : '-';
              $payrolInfo[$key]['sbu_short_name']=isset($employeeInfo) ? $employeeInfo['sbu_short_name'] : '-';
              $payrolInfo[$key]['work_location_name']=isset($employeeInfo) ? $employeeInfo['work_location_name'] : '-';
              $payrolInfo[$key]['jobgrade_name']=isset($employeeInfo) ? $employeeInfo['jobgrade_name'] : '-';
              $payrolInfo[$key]['employee_joining_date']=isset($employeeInfo) ? $employeeInfo['employee_joining_date'] : '-';
              $payrolInfo[$key]['ebc_account_number']=isset($employeeInfo) ? $employeeInfo['ebc_account_number'] : '-';
            //   $SalaryInfos=collect($SalaryInfo)->where('employee_id', $value->empid)->first();
              $payrolInfo[$key]['g_salary']=isset($value) ? $value['gross_salary'] : '0';
            //   $payrolInfo[$key]['g_payble']=($value['basic']+$value['houserent']+$value['medical']+$value['transport']);
              $payrolInfo[$key]['g_payble'] = isset($value) ? $value['gross_payable'] : '0';
              $payrolInfo[$key]['page_ref_id']=$request['page_ref_id'];
              // $payrolInfo[$key]['netpay']=($payrolInfo[$key]['g_payble']+ $value['arear']+ $value['additional_mobile']) - ($value['deduction_pfbasic'] + $value['deduction_loan']+$value['deduction_uniform']+$value['deduction_uniform']+$value['deduction_tax']+$value['deduction_mobilebill']+$value['deduction_others']+$value['late_abset_deduction']);

          }
          $data['report_date']=date('d F Y', strtotime($payrollData['startdate'])).' to '. date('d F Y', strtotime($payrollData['enddate']));
          $data['employee_data']=$payrolInfo;

            $data['total_gross_salary'] = $total_gross_salary;
            $data['total_absent_amount'] = $total_absent_amount;
            $data['total_gross_payable'] = $total_gross_payable;
            $data['total_basic'] = $total_basic;
            $data['total_houserent'] = $total_houserent;
            $data['total_medical'] = $total_medical;
            $data['total_transport'] = $total_transport;
            $data['total_arear'] = $total_arear;
            $data['total_additional_mobile'] = $total_additional_mobile;
            $data['total_car_allowance'] = $total_car_allowance;
            $data['total_incentive'] = $total_incentive;
            $data['total_allowance'] = $total_allowance;
            $data['total_other_allownce'] = $total_other_allownce;
            $data['total_deduction_pfbasic'] = $total_deduction_pfbasic;
            $data['total_deduction_loan'] = $total_deduction_loan;
            $data['total_deduction_uniform'] = $total_deduction_uniform;
            $data['total_deduction_deposit'] = $total_deduction_deposit;
            $data['total_deduction_tax'] = $total_deduction_tax;
            $data['total_deduction_mobilebill'] = $total_deduction_mobilebill;
            $data['total_late_deduction'] = $total_late_deduction;
            $data['total_deduction_others'] = $total_deduction_others;
            $data['total_netpay'] = $total_netpay;
            return response()->json($data);
      }

      public function pay_slip_details(Request $request)
      {
          $payslipDetails=PayrollList::valid()
                         ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
                         ->selectRaw(
                             'payroll.*,
                    payroll_process.pay_year,
                    payroll_process.paymonth,
                    payroll_process.startdate,
                    payroll_process.type,
                    payroll_process.process_date,
                    payroll_process.enddate,
                    (payroll.arear+payroll.additional_mobile+payroll.allowance) as total_additions,
                    (payroll.deduction_others+payroll.deduction_uniform+payroll.deduction_deposit+payroll.deduction_mobilebill+payroll.deduction_loan) as total_deduction
                    '
                         )
                         ->where('payroll.id', $request['page_ref_id'])->first();


          if ($payslipDetails['type']==1) {
              $data['salary_type_cash']=1;
              $data['paySlipCash']=$payslipDetails;
              $paySlipDetails=PayrollList::valid()
                        ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
                        ->selectRaw(
                            'payroll.*,
                    payroll_process.paymonth,
                    payroll_process.type,
                    payroll_process.process_date,
                    payroll_process.enddate,
                    (payroll.arear+payroll.additional_mobile+payroll.allowance) as total_additions,
                    (payroll.deduction_others+payroll.deduction_uniform+payroll.deduction_deposit+payroll.deduction_mobilebill+payroll.deduction_loan) as total_deduction
                    '
                        )
                        ->where('pay_year', $payslipDetails['payroll_year'])
                        ->where('paymonth', $payslipDetails['paymonth'])
                        ->where('empid', $payslipDetails['empid'])
                        ->where('type', 2)
                        ->where('payroll.companysbu_id', $payslipDetails['companysbu_id'])
                        ->first();
              if (!empty($paySlipDetails)) {
                  $data['paySlipDetails']=$paySlipDetails;
                  $data['salary_type_bank']=2;
              } else {
                  $data['paySlipDetails']=[];
                  $data['salary_type_bank']=1;
              }
          } else {
              $data['salary_type_bank']=2;
              $data['paySlipDetails']=$payslipDetails;
              $paySlipCash=PayrollList::valid()
                          ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
                          ->selectRaw(
                              'payroll.*,
                    payroll_process.paymonth,
                    payroll_process.enddate,
                    payroll_process.type,
                    payroll_process.process_date,
                    (payroll.arear+payroll.additional_mobile+payroll.allowance) as total_additions,
                    (payroll.deduction_others+payroll.deduction_uniform+payroll.deduction_deposit+payroll.deduction_mobilebill+payroll.deduction_loan) as total_deduction
                    '
                          )
                          ->where('pay_year', $payslipDetails['payroll_year'])
                          ->where('paymonth', $payslipDetails['paymonth'])
                          ->where('empid', $payslipDetails['empid'])
                          ->where('type', 1)
                          ->where('payroll.companysbu_id', $payslipDetails['companysbu_id'])
                          ->first();
              if (!empty($paySlipCash)) {
                  $data['paySlipCash']=$paySlipCash;
                  $data['salary_type_cash']=1;
              } else {
                  $data['paySlipCash']=[];
                  $data['salary_type_cash']=2;
              }
          }

          // if($payslipDetails['type']==2){
          //   $data['paySlipDetails']=$payslipDetails;
          //   $data['salary_type_bank']=2;
          // }else{
          //   $data['salary_type_cash']=1;
          //   $data['paySlipCash']=PayrollList::valid()
    //               ->leftJoin('payroll_process','payroll_process.id','=','payroll.procsid')
    //               ->selectRaw(
    //                 'payroll.*,
    //                 payroll_process.paymonth,
    //                 payroll_process.type,
    //                 payroll_process.process_date,
    //                 (payroll.arear+payroll.additional_mobile+payroll.allowance) as total_additions,
    //                 (payroll.deduction_others+payroll.deduction_uniform+payroll.deduction_deposit+payroll.deduction_mobilebill+payroll.deduction_loan) as total_deduction
    //                 '
    //               )
    //               ->where('paymonth',$payslipDetails['paymonth'])
    //               ->where('empid',$payslipDetails['empid'])
    //               ->where('type',1)
    //               ->where('payroll.companysbu_id',$payslipDetails['companysbu_id'])
    //               ->first();

          // }
          // if($payslipDetails['type']==2){
          //   $data['paySlipCash']=$payslipDetails;
          //   $data['salary_type_bank']=2;

          // }else{
          //   $data['salary_type_cash']=1;
          //   $data['paySlipDetails']=PayrollList::valid()
    //               ->leftJoin('payroll_process','payroll_process.id','=','payroll.procsid')
    //               ->selectRaw(
    //                 'payroll.*,
    //                 payroll_process.paymonth,
    //                 payroll_process.type,
    //                 payroll_process.process_date,
    //                 (payroll.arear+payroll.additional_mobile+payroll.allowance) as total_additions,
    //                 (payroll.deduction_others+payroll.deduction_uniform+payroll.deduction_deposit+payroll.deduction_mobilebill+payroll.deduction_loan) as total_deduction
    //                 '
    //               )
    //               ->where('paymonth',$payslipDetails['paymonth'])
    //               ->where('empid',$payslipDetails['empid'])
    //               ->where('type',2)
    //               ->where('payroll.companysbu_id',$payslipDetails['companysbu_id'])
    //               ->first();
          // }

          // $paySlip=PayrollProcessList::valid()->
          $allPf=ProvidentFund::valid()->where('employee_id', $payslipDetails['empid'])
                                ->where('company_sbu_id', $payslipDetails['companysbu_id'])
                                ->whereDate('pf_date', '<=', $payslipDetails['enddate'])
                                ->get();
          $data['openigPf']=collect($allPf)->where('pf_date', '<', $payslipDetails['enddate'])
                                  ->sum('pf_employee_amount');
          $data['Pf']=collect($allPf)->where('pf_date', '=', $payslipDetails['enddate'])
                                  ->sum('pf_employee_amount');
          $data['clPf']=collect($allPf)->sum('pf_employee_amount');

          $pay_slip_details= Employee::valid()->project()
              // ->leftJoin('employees',  'employees.id', '=', 'payroll.empid')
              ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
              ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
              ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
              ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
              ->selectRaw(
                  'employees.*,
        employees.employee_id_no,
        employees.employee_fullname,
        designations.designation_name,
        departments.department_name,
        company_sbus.sbu_name,
        company_sbus.sbu_logo,
        work_locations.work_location_name
        '
              )->where('employees.id', $payslipDetails['empid'])->first();



          $data['pay_slip_details']=$pay_slip_details;
          $data['sbu_name']=$pay_slip_details['sbu_name'];
          $data['sbu_logo']=$pay_slip_details['sbu_logo'];
          $data['print_date']=date('l d F Y');
          $data['salary_date']=date('F Y', strtotime($payslipDetails['startdate']));



          return response()->json($data);
      }

      public function final_process($id=false)
      {
          $data['id'] = $id;
          return response()->json($data);
      }
      public function final_process_submit(Request $request)
      {
          // return response()->json($request);
          if (!empty($request->id)) {
              $update_data=PayrollProcessList::valid()->project()->findOrFail($request->id);
              $data['updated_by']=Auth::guard('user')->user()->id;
              $data['settlement']=2;
              $save_data=$update_data->update($data);
              $message=['status' => 1, 'message' => 'Your data is successfully updated'];
          } else {
              $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
          }
          return response()->json($message);
      }

      public function destroy($id)
      {
          try {
              DB::beginTransaction();
              $delete_data=PayrollProcessList::valid()->project()->findOrFail($id);
              if ($delete_data->delete()) {
                  // PayrollList::valid()->project()->where('procsid', '=', $id)->destroy();
                  DB::table('payroll')->where('procsid', '=', $id)->delete();
                  // LoanTransaction::valid()->project()->where('payroll_process_id', '=', $id)->destroy();
                  DB::table('loan_adv_transactions')->where('payroll_process_id', '=', $id)->delete();
                  // ProvidentFund::valid()->project()->where('payroll_process_id ', '=', $id)->destroy();
                  DB::table('provident_funds')->where('payroll_process_id', '=', $id)->delete();
                  $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
              }
              DB::commit();
              $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
              return response($message);
          } catch (\Exception $exception) {
              DB::rollBack();
              $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
              return response($exception);
          }
          // return response($message);
      }

      public function employee_salary_update(Request $request)
      {
          // return response($request);
          $data=$request->only('basic', 'houserent', 'medical', 'transport', 'arear', 'car_allowance', 'allowance', 'additional_mobile', 'deduction_pfbasic', 'deduction_loan', 'deduction_uniform', 'deduction_deposit', 'deduction_tax', 'deduction_mobilebill', 'deduction_others');
          $save_data = '';
          if (!empty($request->id)) {
              $update_data=PayrollList::valid()->project()->where('empid', $request->id)->where('procsid', $request->procsid)->first();
              $data['gross_salary'] = ($request->basic + $request->houserent + $request->medical + $request->transport);
              $data['netpay'] = ($request->basic + $request->houserent + $request->medical + $request->transport + $request->arear + $request->car_allowance + $request->allowance + $request->additional_mobile) - ($request->deduction_pfbasic + $request->deduction_loan + $request->deduction_uniform + $request->deduction_deposit + $request->deduction_tax + $request->deduction_mobilebill + $request->deduction_others);
              $data['updated_by']= Auth::guard('user')->user()->id;
              $data['updated_at']=  date('Y-m-d H:i:s');
              $save_data=$update_data->update($data);
              $message=['status' => 1, 'message' => 'Your data is successfully updated'];
          }
          if (!$save_data) {
              $message=['status' => 0, 'message' => 'Opps! Something went worng.'];
          }
          return response($message);
      }

      public function softdelete($process_id = null, $emp_id = null)
      {
          // return response('message');

          try {
              DB::beginTransaction();
              $update_data=PayrollList::valid()->project()->where('empid', $emp_id)->where('procsid', $process_id)->first();
              if ($update_data) {
                  $data['deleted_at']=date('Y-m-d H:i:s');
                  $data['deleted_by']=Auth::guard('user')->user()->id;
                  $data['valid']=0;
                  $save_data=$update_data->update($data);
                  if ($save_data) {
                      DB::table('loan_adv_transactions')->where('payroll_process_id', '=', $process_id)->where('employee_id', '=', $emp_id)->update($data);
                      DB::table('provident_funds')->where('payroll_process_id', '=', $process_id)->where('employee_id', '=', $emp_id)->update($data);
                  }
                  $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
              }
              DB::commit();
              $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
              return response($message);
          } catch (\Exception $exception) {
              DB::rollBack();
              $message=['status' => 0, 'message' => 'Opps! Something went worng.'];
              return response($exception);
          }
          // return response($exception);
      }
}
