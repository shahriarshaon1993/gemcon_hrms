<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\hrm\ShiftingSetupController;
use Auth;
use Session;
use App\Model\payroll\TaxSetting;
use App\Model\payroll\DailyProduction;
use App\Model\Employee;
use App\Model\OfficeTimeSetup;
use App\Model\payroll\BundleSetting;
use App\Model\payroll\GradeSetting;
use App\Model\payroll\LineSetting;
use App\Model\payroll\MachineSetting;
use App\Model\payroll\ProductSetting;
use App\Model\CompanySbu;
use App\Model\AttendanceSetup;
use App\Model\Department;
use App\Model\UnitModel;
use App\Model\SubUnit;
use Cache;
use Carbon\Carbon;
use DB;
use DateTime;
use DateTimezone;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DailyProductionController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];
        $cache = Cache::get('permission');
        $permission = collect($cache)->where('menu_uid', '=', 'TaxSetting')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
        foreach ($permission as $child) {
            if ($child['link_uid'] == 'add') {
                $data['add'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'edit') {
                $data['edit'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'delete') {
                $data['delete'] = $child['link_uid'];
            } else {
                $data['view'] = $child['link_uid'];
            }
        }
        // employee production data
        $data['employee_production_infos'] = [
          '0' =>
          [
            'id' => 0,
            'employee_id' => '',
            'employees_ids' => '',
            'employeesName' => '',
            'production_date' => '',
            'shift_name' => '',
            'product_name' => '',
            'bundle_name' => '',
            'grade_name' => '',
            'product_quantity' => 0,
            'product_qt_quantity' => 0,
            'line_name' => '',
            'machine_name' => '',
            'product_rate'=>0,
            'amount'=>0,
          ]
        ];
        $data['product_qt_quantity']=0;
        $data['product_quantity']=0;

        $data['employee_data_approval'] = array();
        $employee_data_approval = Employee::valid()->project()->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->where('employee_status', 1)->whereIn('employees.id', $employee_id)->where('employee_salary_type', 2)->get();
        foreach ($employee_data_approval as $value) {
            array_push($data['employee_data_approval'], ['id' => $value['id'], 'employee_name' => $value['employee_fullname'], 'employee_ids' => $value['employee_id_no'], 'text' => $value['employee_id_no'] . ' : ' . $value['employee_fullname']]);
        }
        $data['employeeShift'] = array();
        $employee_data_shift = OfficeTimeSetup::valid()->project()->where('type', 2)->get();
        foreach ($employee_data_shift as $value) {
            array_push(
                $data['employeeShift'],
                [
                  'id' => $value['id'],
                  'text' => $value['title']
                ]
            );
        }
        $data['product_array'] = array();
        $product_data_list = ProductSetting::valid()->project()->get();
        foreach ($product_data_list as $value) {
            array_push($data['product_array'], ['id' => $value['id'], 'text' => $value['product_name']]);
        }
        $data['bundle_array'] = array();
        $bundle_data_list = BundleSetting::valid()->project()->get();
        foreach ($bundle_data_list as $value) {
            array_push($data['bundle_array'], ['id' => $value['id'], 'text' => $value['bundle_name']]);
        }
        $data['product_grade_array'] = array();
        $product_grade_list = GradeSetting::valid()->project()->get();
        foreach ($product_grade_list as $value) {
            array_push(
                $data['product_grade_array'],
                [
                  'id' => $value['id'],
                  'text' => $value['grade_name'],
                  'product_rate' => $value['product_rate']
                ]
            );
        }
        $data['line_array'] = array();
        $line_data_list = LineSetting::valid()->project()->get();
        foreach ($line_data_list as $value) {
            array_push($data['line_array'], ['id' => $value['id'], 'text' => $value['line_name']]);
        }
        $data['machine_array'] = array();
        $machine_data_list = MachineSetting::valid()->project()->get();
        foreach ($machine_data_list as $value) {
            array_push($data['machine_array'], ['id' => $value['id'], 'text' => $value['machine_name']]);
        }
        $data['company_sbu_data'] = array();
        $companysbu_data_list = CompanySbu::valid()->project()->whereIn('id', $employee_ids['sub'])->get()->all();
        foreach ($companysbu_data_list as $value) {
            array_push($data['company_sbu_data'], ['id' => $value['id'], 'text' => $value['sbu_name']]);
        }
        $data['sbu_name_value'] = [
          'id' => 21,
          'text' => 'Gem Jute Ltd'
        ];
        $data['production_date']=date('Y-m-d');
        $data['sbu_id'] = 21;
        return response($data);
    }
    public function store(Request $request)
    {
        // try {
        // DB::beginTransaction();
        $employee_production_infos = collect($request['employee_production_infos'])->where('employee_id', '!=', '')->toArray();
        if ($employee_production_infos != '') {
            $i = 0;
            foreach ($employee_production_infos as $key => $value) {
                $i++;
                $product_data['production_code'] = $i;
                $product_data['employee_id'] = $value['employee_id'];
                $product_data['sbu_id'] = $request->sbu_id;
                $product_data['production_date'] = $value['production_date'];
                $product_data['shift_id'] = $value['shift_id'] ?? '';
                $product_data['product_id'] = $value['product_id'];
                $product_data['bundle_id'] = $value['bundle_id'] ?? '';
                $product_data['grade_id'] = $value['grade_id'];
                $product_data['product_quantity'] = $value['product_quantity'];
                $product_data['product_qt_quantity'] = $value['product_qt_quantity'] ?? 0;
                $product_data['product_rate'] = $value['product_rate'];
                $product_data['line_id'] = $value['line_id'] ?? '';
                $product_data['machine_id'] = $value['machine_id'] ?? '';
                $product_data['amount'] = $value['amount'];
                $product_data['project_id'] = Auth::guard('user')->user()->project_id;
                $product_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                $product_data['created_by'] = Auth::guard('user')->user()->id;

                // $save_data = DB::table('daily_production_entries')->insert([$product_data]);
                $save_data = DailyProduction::create($product_data);
                // dd($product_data);
            }
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
        }
        if (!$save_data) {
            $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
        }
        // DB::commit();
        return response($message);
        // } catch (\Exception $exception) {
        // DB::rollBack();
        $message = ['status' => 0, 'message' => 'Ops! Something went wornggg.'];
        // return response($exception);
        // }
        return response($message);
    }


    public function find_employee(Request $request)
    {
        $data = array();
        $employee_data_list = AttendanceSetup::valid()->project()
          ->leftJoin('daily_production_entries', 'daily_production_entries.employee_id', '=', 'attendance_setups.employee_id')
          ->leftJoin('employees', 'employees.id', '=', 'attendance_setups.employee_id')
          ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
          ->select(
              'employees.*',
              'daily_production_entries.*',
              'daily_production_entries.id as daily_production_entries_id',
              'attendance_setups.id as attendance_setup_id',
              'office_time_setups.id as office_time_setup_id',
              'employees.id as employee_id',
          )
          ->where('attendance_setups.attendance_office_time', '=', $request->shift_id)
          ->where('attendance_setups.start_date', '=', $request->production_date)
          ->where('employees.employee_sbu', '=', $request->sbu_id)
          ->get();
        // return response($employee_data_list);
        $product_grade_list = GradeSetting::valid()->project()->where('id', $request->grade_id)->first();
        $product_data_list = ProductSetting::valid()->project()->where('id', $request->product_id)->first();
        $bundle_data_list = BundleSetting::valid()->project()->where('id', $request->bundle_id)->first();
        foreach ($employee_data_list as $value) {
            $total_amount = 0;
            if (!empty($value['product_qt_quantity'])) {
                $total_quantity = $value['product_quantity'] + $value['product_qt_quantity'];
                if (!empty($product_grade_list['product_rate'])) {
                    $total_amount = $total_quantity * $product_grade_list['product_rate'];
                } else {
                    $total_amount = 0;
                }
            } elseif (!empty($value['product_quantity'])) {
                $total_quantity = $value['product_quantity'];
                if (!empty($product_grade_list['product_rate'])) {
                    $total_amount = $total_quantity * $product_grade_list['product_rate'];
                } else {
                    $total_amount = 0;
                }
            }
            array_push(
                $data,
                [
                  'approvalnamevalue1' => '',
                  'indexid' => '',
                  'employee_id' => $value['employee_id'],
                  'employees_ids' => $value['employee_id_no'],
                  'employeesName' => $value['employee_fullname'],
                  'production_date' => isset($request->production_date) ? $request->production_date : '',
                  'shift_name' => $request->shift_name,
                  'shift_id' => $request->shift_id,
                  'product_name' => $request->product_name,
                  'product_id' => $request->product_id,
                  'bundle_name' => $request->bundle_name,
                  'bundle_id' => $request->bundle_id,
                  'grade_name' => $request->grade_name,
                  'grade_id' => $request->grade_id,
                  'product_quantity' => $value['product_quantity'],
                  'product_qt_quantity' => $value['product_qt_quantity'],
                  'product_rate' => isset($product_grade_list['product_rate']) ? $product_grade_list['product_rate'] : '',
                  'line_name' => $value['line_name'],
                  'line_id' => $value['line_id'],
                  'machine_name' => $value['machine_name'],
                  'machine_id' => $value['machine_id'],
                  'amount' => $total_amount,
                  'shiftData' => [
                    'id' => $request->shift_id,
                    'text' => $request->shift_name
                  ],
                  'productData' => [
                    'id' => $request->product_id,
                    'text' => $request->product_name
                  ],
                  'bundleData' => [
                    'id' => $request->bundle_id,
                    'text' => $request->bundle_name
                  ],
                  'gradeData' => [
                    'id' => $request->grade_id,
                    'text' => $request->grade_name
                  ],
                ]
            );
        }
        return response($data);
    }

    public function edit($id)
    {
        $edit_data = TaxSetting::valid()->project()->findOrFail($id);
        return response($edit_data);
    }

    public function destroy($id)
    {
        $delete_data = DailyProduction::valid()->project()->findOrFail($id);
        if ($delete_data->delete()) {
            $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
        }
        return response($message);
    }

    public function create()
    {
        $data['employee_data'] = array();
        $employee_data = Employee::valid()->project()->get();
        foreach ($employee_data as $value) {
            array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_fullname']]);
        }
        return response($data);
    }

    public function findDepartmentMaxCode()
    {
        $last_entry_data = TaxSetting::latest()->first();
        $department_last_code = $last_entry_data['department_code'];
        if ($department_last_code == 0) {
            $department_last_code = 101;
        } else {
            $department_last_code = $department_last_code + 1;
        }
        return $department_last_code;
    }
    public function daily_production_list(Request $request)
    {
        $employee_data = DailyProduction::valid()->project();
        if ($request->from_date != '' && $request->to_date != '') {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $to_date = date('Y-m-d', strtotime($request->to_date));
            $employee_data->whereBetween('production_date', [$from_date, $to_date]);
        }

        $employee_data->groupBy('production_date');
        $employee_data->with('getalldata');
        if ($request->from_date == '' && $request->to_date == '') {
            $employee_data->limit(20);
        }
        $employee_data_list = $employee_data->get()->toArray();
        // echo "<pre>";
        // print_r($employee_data_list);
        // exit();
        return response($employee_data_list);
    }
    public function daily_production_report(Request $request)
    {
        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        // $employee_id = $employee_ids['employee_id'];
        $data['employeeShift'] = array();
        $employee_data_shift = OfficeTimeSetup::valid()->project()->where('type', 2)->get();
        foreach ($employee_data_shift as $value) {
            array_push(
                $data['employeeShift'],
                [
                  'id' => $value['id'],
                  'text' => $value['title']
                ]
            );
        }
        $data['product_array'] = array();
        $product_data_list = ProductSetting::valid()->project()->get();
        foreach ($product_data_list as $value) {
            array_push($data['product_array'], ['id' => $value['id'], 'text' => $value['product_name']]);
        }
        $data['bundle_array'] = array();
        $bundle_data_list = BundleSetting::valid()->project()->get();
        foreach ($bundle_data_list as $value) {
            array_push($data['bundle_array'], ['id' => $value['id'], 'text' => $value['bundle_name']]);
        }
        $data['product_grade_array'] = array();
        $product_grade_list = GradeSetting::valid()->project()->get();
        foreach ($product_grade_list as $value) {
            array_push(
                $data['product_grade_array'],
                [
                  'id' => $value['id'],
                  'text' => $value['grade_name'],
                  'product_rate' => $value['product_rate']
                ]
            );
        }
        $data['line_array'] = array();
        $line_data_list = LineSetting::valid()->project()->get();
        foreach ($line_data_list as $value) {
            array_push($data['line_array'], ['id' => $value['id'], 'text' => $value['line_name']]);
        }
        $data['machine_array'] = array();
        $machine_data_list = MachineSetting::valid()->project()->get();
        foreach ($machine_data_list as $value) {
            array_push($data['machine_array'], ['id' => $value['id'], 'text' => $value['machine_name']]);
        }
        $data['company_sbu_data'] = array();
        $companysbu_data_list = CompanySbu::valid()->project()->whereIn('id', $employee_ids['sub'])->get();
        foreach ($companysbu_data_list as $value) {
            array_push($data['company_sbu_data'], ['id' => $value['id'], 'text' => $value['sbu_name']]);
        }
        $data['sbu_name_value'] = [
          'id' => 21,
          'text' => 'Gem Jute Ltd'
        ];
        $data['sbu_id'] = 21;

        $employee_data_approval = Employee::valid()->project()->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->get();
        $data['employee_data_approval'] = array();
        array_push($data['employee_data_approval'], ['id' => '', 'text' => 'All Select']);
        foreach ($employee_data_approval as $value) {
            array_push($data['employee_data_approval'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . ':' . $value['employee_fullname'] . '-' . $value['designation_name']]);
        }
        // $data['company_sbu_data']=array();
        //   $data['section_data']=array();
        //   $data['sub_section_data']=array();
          $data['sub_unit_data']=array();
          $data['unit_data']=array();
        //   $data['work_location_data']=array();
          $data['department_data']=array();
        //   $data['designation_data']=array();
        //   $data['jobgrade_data']=array();
        //   $data['employee_data']=array();
        //   $data['employee_data_approval']=array();
        //   $data['employee_group_data']=array();
        //   $company_sbu_data=CompanySbu::valid()->project()->get();
        //   $section_data=Section::valid()->project()->get();
        //   $sub_section_data=SubSection::valid()->project()->get();
          $department_data = Department::valid()->project()->get();
        //   $designation_data=Designation::valid()->project()->get();
        //   $jobgrade_data=JobGrade::valid()->project()->get();
        //   $employee_data_approval=Employee::valid()->project()->get();
        //   $employee_data=Employee::valid()->project()->get()->keyBy('id')->all();
          $unit_data = UnitModel::valid()->project()->get();
          $sub_unit_data = SubUnit::valid()->project()->get();
        //   $work_location_data=WorkLocation::valid()->project()->get();
        //   $employee_group_data=EmployeeGroup::valid()->project()->get();
        foreach ($department_data as $value) {
            array_push($data['department_data'], ['id'=>$value['id'],'text'=>$value['department_name'],]);
        }
        foreach ($sub_unit_data as $value) {
            array_push($data['sub_unit_data'], ['id'=>$value['id'],'text'=>$value['sub_unit_name']]);
        }

        foreach ($unit_data as $value) {
            // return response($value);
            array_push($data['unit_data'], ['id'=>$value['id'],'text'=>$value['unit_name']]);
        }
        // dd($request);
        $flag = 0;
        $unit_value = [];
        $sub_unit_value = [];
        $department_name_value = [];
        // return response($request->unit_value);
        $employee_data = DailyProduction::valid()->project();
        if ($request->from_date != '' && $request->to_date != '') {
            // dd($request->from_date, $request->to_date);
            $from_date = Carbon::parse($request->from_date)->format('Y-m-d');
            $to_date = Carbon::parse($request->to_date)->format('Y-m-d');
            $data['report_name'] = "Daily Production Report [ ".date('d F Y', strtotime($from_date))." To ". date('d F Y', strtotime($to_date))." ]";
            $data['report_title'] = "Daily Production Report";
            $data['reportDate'] = date('d F Y');
            $employee_data->whereBetween('production_date', [$from_date, $to_date]);
            $flag = 1;
            $unit_value = collect($request->unit_value)->where('id','!=',0)->pluck('id');
            $sub_unit_value = collect($request->sub_unit_value)->where('id','!=',0)->pluck('id');
            $department_name_value = collect($request->department_name_value)->where('id','!=',0)->pluck('id');
            
        }
        
        if ($request->employee_id != '') {
            $employee_data->where('employee_id', $request->employee_id);
            $flag = 1;
        }
   
        if ($request->shift_id != '') {
            $employee_data->where('shift_id', $request->shift_id);
            $flag = 1;
        }
        if ($request->product_id != '') {
            $employee_data->where('product_id', $request->product_id);
            $flag = 1;
        }
        if ($request->bundle_id != '') {
            $employee_data->where('bundle_id', $request->bundle_id);
            $flag = 1;
        }
        if ($request->grade_id != '') {
            $employee_data->where('grade_id', $request->grade_id);
            $flag = 1;
        }
        if ($request->line_id != '') {
            $employee_data->where('line_id', $request->line_id);
            $flag = 1;
        }
        if ($request->machine_id != '') {
            $employee_data->where('machine_id', $request->machine_id);
            $flag = 1;
        }
        if ($request->sbu_id != '') {
            $employee_data->where('sbu_id', $request->sbu_id);
            $flag = 1;
        }
        
        
        $employee_data->with('joinemployee', 'joinsbu', 'joinshift', 'joinproduct', 'joinbundle', 'joingrade', 'joinline', 'joinmachine');
        //   ->select('daily_production_entries.*','daily_production_entries.product_id',DB::raw('SUM(daily_production_entries.amount) as amount'), DB::raw('SUM(daily_production_entries.product_quantity) as product_quantity'), DB::raw('SUM(daily_production_entries.product_qt_quantity) as product_qt_quantity'))
        //   ->groupBy('production_code')
        //   ->groupBy('employee_id')
        //   ->groupBy('production_date');
        
        // if ($request->employee_department != '') {
        //     $employee_data->where('employee_department', $request->employee_department);
        //     $flag = 1;
        // }
        
        // if ($request->employee_unit != '')  {
        //     $employee_data->where('employee_unit', $request->employee_unit);
        //     $flag = 1;
        // }
        // if ($request->employee_sub_unit != '') {
        //     $employee_data->where('employee_sub_unit', $request->employee_sub_unit);
        //     $flag = 1;
        // }
        if (!$flag) {
            $employee_data->limit(20);
        }
        $employee_data_list = $employee_data->get();
        $data['quantity'] = collect($employee_data_list)->sum('product_quantity');
        $data['oTQty'] = collect($employee_data_list)->sum('product_qt_quantity');
        $data['total_amount'] = collect($employee_data_list)->sum('amount');	

        $data['employee_data_list'] = $employee_data_list;

        return response($data);
    }
    public function change_status(Request $request)
    {
        $employee_data = DailyProduction::valid()->project()->where('id', $request->id)->first();
        // return response($employee_data);
        if ($employee_data->approve_status == 0) {
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date= $dt->format('Y-m-d g:i');
            $employee_data =DailyProduction::valid()->where('id', $request->id)->update([
              'approve_at'=>$date,
              'approve_by'=>Auth::guard('user')->user()->id,
              'approve_status'=>1,
            ]);
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
            return response($message);
        } else {
            $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
            return response($message);
        }
    }
}
