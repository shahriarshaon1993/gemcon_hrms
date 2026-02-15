<?php

namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\Department;
use App\Model\Designation;
use App\Model\JobGrade;
use App\Model\LeaveType;
use App\Model\LeaveApplication;
use App\Model\Resignation;
use App\Model\EmployeeApproval;
use App\Model\Rejoin;
use App\Model\ResignationApproval;
use Cache;
use permission;
use App\Model\UsersPersonModel;
use DB;

class ResignationController extends Controller
{
  public function rejoin_report(Request $request)
  {
    
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = collect($request['employee_name_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // $employee_ids['employee_id'];
    $employee_data_approval = [];
    $section_id = collect($request['section_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // $request['section_id'];
    $subsection_id = collect($request['sub_section_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // $request['subsection_id'];
    $employee_groupsubunit_id = $request['employee_groupsubunit_id'];
    $subunit_id = collect($request['sub_unit_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // $request['subunit_id'];
    $unit_id = collect($request['unit_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // $request['unit_id'];
    $employee_work_location = collect($request['work_location_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // $request['employee_work_location'];
    $department_id = collect($request['department_name_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // $request['department_id'];
    $sbu_id = collect($request['sbu_name_value'])->where('id', '!=', '')->pluck('id')->toArray();


    $rejoinreport = Rejoin::valid()->project()
      ->leftJoin('employees', 'employees.id', '=', 'rejoin.employee_id')
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->select('rejoin.*', 'company_sbus.sbu_name', 'departments.department_name', 'rejoin.id as id', 'employees.id as employee_id', 'employees.employee_id_no', 'employees.employee_fullname', 'designations.designation_name')
      ->where(function ($rejoinreport) use ($section_id, $subsection_id, $employee_groupsubunit_id, $subunit_id, $unit_id, $employee_work_location, $department_id) {
        if (!empty($section_id)) {
          $rejoinreport->whereIn('employee_section', $section_id);
        }
        if (!empty($subsection_id)) {
          $rejoinreport->whereIn('employee_sub_section', $subsection_id);
        }
        if (!empty($employee_groupsubunit_id)) {
          $rejoinreport->whereIn('employee_group', $employee_groupsubunit_id);
        }
        if (!empty($subunit_id)) {
          $rejoinreport->whereIn('employee_sub_unit', $subunit_id);
        }
        if (!empty($unit_id)) {
          $rejoinreport->whereIn('employee_unit', $unit_id);
        }
        if (!empty($employee_work_location)) {
          $rejoinreport->whereIn('employee_work_location', $employee_work_location);
        }
        if (!empty($department_id)) {
          $rejoinreport->whereIn('employee_department', $department_id);
        }
      })
      ->get();
    // ->paginate($paginate_num);
    // $sortData = $paginate_data;
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = $employee_ids['employee_id'];

    $data['AllcompanySbuData'] = $employee_list->report_filter_data()['Allcompany_sbu_data'];
    $data['company_sbu_data'] = $employee_list->report_filter_data()['company_sbu_data'];
    $data['AllsectionData'] = $employee_list->report_filter_data()['Allsection_data'];
    $data['section_data'] = $employee_list->report_filter_data()['section_data'];
    $data['AllsubSectionData'] = $employee_list->report_filter_data()['Allsub_section_data'];
    $data['sub_section_data'] = $employee_list->report_filter_data()['sub_section_data'];
    $data['AllsubUnitData'] = $employee_list->report_filter_data()['Allsub_unit_data'];
    $data['sub_unit_data'] = $employee_list->report_filter_data()['sub_unit_data'];
    $data['AllunitData'] = $employee_list->report_filter_data()['Allunit_data'];
    $data['unit_data'] = $employee_list->report_filter_data()['unit_data'];
    $data['AllworkLocationData'] = $employee_list->report_filter_data()['Allwork_location_data'];
    $data['work_location_data'] = $employee_list->report_filter_data()['work_location_data'];
    $data['AlldepartmentData'] = $employee_list->report_filter_data()['Alldepartment_data'];
    $data['department_data'] = $employee_list->report_filter_data()['department_data'];

    $data['rejoinreport'] = $rejoinreport;

    return response()->json($data);
  }
  public function rejoin(Request $request)
  {
    $cache = Cache::get('permission');
    $permission = collect($cache)->where('menu_uid', '=', 'rejoin_list')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
    foreach ($permission as $child) {
      if ($child['link_uid'] == 'add') {
        $data['add'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'edit') {
        $data['edit'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'delete') {
        $data['delete'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'self') {
        $data['self'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'others') {
        $data['others'] = $child['link_uid'];
      } else {
        $data['approve'] = $child['link_uid'];
      }
    }
    $paginate_num = $request->input('paginate_num');
    $search_key = $request->input('search_key');
    $order = $request->input('order');
    $sort = $request->input('sort');
    $project_id = Auth::guard('user')->user()->project_id;
    $branch_id = Auth::guard('user')->user()->branch_id;
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = $employee_ids['employee_id'];

    $paginate_data = Rejoin::valid()->project()
      ->leftJoin('employees', 'employees.id', '=', 'rejoin.employee_id')
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      // ->leftJoin('leave_types','leave_types.id','=','rejoin.leave_type')
      // ->leftJoin('employees as emp','emp.id','=','rejoin.leave_reliever')
      ->select('rejoin.*', 'company_sbus.sbu_name', 'departments.department_name', 'rejoin.id as id', 'employees.id as employee_id', 'employees.employee_id_no', 'employees.employee_fullname', 'designations.designation_name')
      ->when($search_key, function ($query, $search_key) {
        $query->where(function ($query2) use ($search_key) {
          $query2->where('employees.employee_fullname', 'LIKE', '%' . $search_key . '%')
                 ->orWhere('employees.employee_id_no', 'LIKE', '%' . $search_key . '%');
        });
        return $query;
      })->whereIn('employees.id', $employee_id)->where('rejoin.project_id', $project_id)->orderBy($sort, $order);
    // ->paginate($paginate_num);
    $sortData = $paginate_data;
    $data['paginate_data'] = $sortData->paginate($paginate_num);

    return response()->json($data);
  }
  public function create_rejoin()
  {
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = $employee_ids['employee_id'];

    $user_id = Auth::guard('user')->user()->id;
    $user_data = UsersPersonModel::valid()->project()->where('id', $user_id)->first();
    $user_employee_data = array();

    // $data['employee_joining_date_custom'] = date('j M Y', strtotime($user_employee_data->employee_joining_date));
    $user_employee_data_all = Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name'
      )
      ->whereIn('employee_sbu', $employee_ids['sub'])->where('employees.employee_status', 2)->whereIn('employee_department', $employee_ids['department'])
      ->get()->keyBy('id');
    $data['user_employee_data'] = $user_employee_data;
    $data['user_employee_data_all'] = $user_employee_data_all;
    $data['employee_data'] = array();
    $employee_data = Employee::valid()->project()->whereIn('employee_sbu', $employee_ids['sub'])->where('employee_status', 2)->whereIn('employee_department', $employee_ids['department'])->get();
    foreach ($employee_data as $value) {
      array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . ' : ' . $value['employee_fullname']]);
    }
    $data['leave_type_data'] = array();
    $leave_type_data = LeaveType::valid()->project()->get();
    foreach ($leave_type_data as $value) {
      array_push($data['leave_type_data'], ['id' => $value['id'], 'text' => $value['leave_type_name']]);
    }
    $data['last_working_date'] = date('Y-m-d');
    $data['effective_date'] = date('Y-m-d');
    $data['separation_date'] = date('Y-m-d');
    $data['joining_date'] = date('Y-m-d');
    

    return response($data);
  }
  public function store_rejoin(Request $request)
  {

    // return response($request);
    $validate = [
      'rejoin_apply_by' => 'required',
      'joining_date' => 'required',
      'effective_date' => 'required'
    ];
    $request->validate($validate);
    $data = $request->only(
      'joining_date',
      'effective_date'
    );

    $data['employee_id'] = $others_apply = $request->rejoin_apply_by;
    $data['created_by'] = Auth::guard('user')->user()->id;

    if (!empty($request->id)) {
      $update_data = Rejoin::valid()->project()->findOrFail($request->id);
      $data['updated_by'] = Auth::guard('user')->user()->id;
      $save_data = $update_data->update($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
    } else {
      if (!empty($others_apply)) {
        $resign_data = Rejoin::valid()->project()->select('*')->where('employee_id', '=', $request->rejoin_apply_by)->first();
      } else {
        $resign_data = Rejoin::valid()->project()->select('*')->where('employee_id', '=', Auth::guard('user')->user()->id)->first();
      }
      if (!empty($resign_data)) {
        $message = ['status' => 0, 'message' => 'Request already exist!'];
        return response($message);
      }

      try {
        DB::beginTransaction();
        $employee_data = Employee::where('id', $request->rejoin_apply_by)->first();

        $data['previous_joining_date'] = $employee_data->employee_joining_date;
        $data['previous_effective_date'] = $employee_data->employee_confirmation_due_date;
        $data['remark'] = $request->remark;
        $data['project_id'] = Auth::guard('user')->user()->project_id;
        $data['branch_id'] = Auth::guard('user')->user()->branch_id;
        $data['created_by'] = Auth::guard('user')->user()->id;
        $save_data = Rejoin::create($data);

        $employee_data->employee_status = 1;
        $employee_data->save();
        Resignation::where('employee_id', $request->rejoin_apply_by)->update(['resignation_status' => 5]);
        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
        $message = ['status' => 0, 'message' => 'Request already exist!'];
        return response($message);
      }





      $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    }
    if (!$save_data) {
      $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
    }
    return response($message);
  }
  public function index(Request $request)
  {
    $cache = Cache::get('permission');
    $permission = collect($cache)->where('menu_uid', '=', 'resignation')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
    foreach ($permission as $child) {
      if ($child['link_uid'] == 'add') {
        $data['add'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'edit') {
        $data['edit'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'delete') {
        $data['delete'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'self') {
        $data['self'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'others') {
        $data['others'] = $child['link_uid'];
      } else {
        $data['approve'] = $child['link_uid'];
      }
    }
    $paginate_num = $request->input('paginate_num');
    $search_key = $request->input('search_key');
    $order = $request->input('order');
    $sort = $request->input('sort');
    $project_id = Auth::guard('user')->user()->project_id;
    $branch_id = Auth::guard('user')->user()->branch_id;
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = $employee_ids['employee_id'];

    $paginate_data = Resignation::valid()->project()
      ->leftJoin('employees', 'employees.id', '=', 'resignations.employee_id')
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      // ->leftJoin('leave_types','leave_types.id','=','resignations.leave_type')
      // ->leftJoin('employees as emp','emp.id','=','resignations.leave_reliever')
      ->select('resignations.*', 'company_sbus.sbu_name', 'departments.department_name', 'resignations.id as id', 'employees.id as employee_id', 
      'employees.employee_id_no', 'employees.employee_fullname','employees.employee_joining_date', 'designations.designation_name')
      ->when($search_key, function ($query, $search_key) {
        $query->where(function ($query2) use ($search_key) {
          $query2->where('employees.employee_fullname', 'LIKE', '%' . $search_key . '%')
          ->orWhere('employees.employee_id_no', 'LIKE', '%' . $search_key . '%');
        });
        return $query;
      })->whereIn('employees.id', $employee_id)->where('resignations.project_id', $project_id)->orderBy($sort, $order);
    // ->paginate($paginate_num);
    $sortData = $paginate_data;
    $data['paginate_data'] = $sortData->paginate($paginate_num);
    $sortGetData = $sortData->get();
    $data['requestApplications'] = count($sortGetData);
    $data['pendingApplications'] = count(collect($sortGetData)->whereIn('resignation_status', ['1', '3'])->toArray());
    $data['acceptedApplications'] = count(collect($sortGetData)->where('resignation_status', 2)->toArray());
    $data['rejectedApplications'] = count(collect($sortGetData)->where('resignation_status', 4)->toArray());

    return response()->json($data);

    // return response()->json($data);
  }

  public function emp_create($id)
  {
    $user_employee_data = Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name'
      )
      ->where('employees.id', $id)->whereIn('employees.employee_status', [1, 0])->first();
    $data['user_employee_data'] = $user_employee_data;
    $data['employee_id'] = $user_employee_data->id;
    $data['employee_joining_date_custom'] = date('j M Y', strtotime($user_employee_data->employee_joining_date));
    return response()->json($data);
  }

  public function create()
  {
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = $employee_ids['employee_id'];

    $user_id = Auth::guard('user')->user()->id;
    $user_data = UsersPersonModel::valid()->project()->where('id', $user_id)->first();
    $user_employee_data = Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name'
      )
      ->where('employees.id', $user_data->employee_id)->whereIn('employees.employee_status', [1, 0])->first();

    $data['employee_joining_date_custom'] = date('j M Y', strtotime($user_employee_data->employee_joining_date));
    $user_employee_data_all = Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name'
      )
      ->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employees.employee_status', [1, 0])->whereIn('employee_department', $employee_ids['department'])
      ->get()->keyBy('id');
    $data['user_employee_data'] = $user_employee_data;
    $data['user_employee_data_all'] = $user_employee_data_all;
    $data['employee_data'] = array();
    $employee_data = Employee::valid()->project()->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->whereIn('employee_status', [1, 0])->get();
    foreach ($employee_data as $value) {
      array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . ' : ' . $value['employee_fullname']]);
    }
    $data['leave_type_data'] = array();
    $leave_type_data = LeaveType::valid()->project()->get();
    foreach ($leave_type_data as $value) {
      array_push($data['leave_type_data'], ['id' => $value['id'], 'text' => $value['leave_type_name']]);
    }
    $data['last_working_date'] = date('Y-m-d');
    $data['effective_date'] = date('Y-m-d');
    $data['separation_date'] = date('Y-m-d');

    return response($data);
  }

  public function store(Request $request)
  {

    // return response($request);
    $validate = [
      'separation_type' => 'required'
    ];
    $request->validate($validate);
    $data = $request->only(
      'separation_type',
      'separation_reason',
      'separation_date',
      'last_working_date',
      'effective_date'
    );

    if (!empty($request->resignation_apply_by)) {
      // $user_id = $request->resignation_apply_by;
      $data['employee_id'] = $others_apply = $request->resignation_apply_by;
      $data['created_by'] = Auth::guard('user')->user()->id;
    } elseif ($request->employee_form_submit == 1) {
      $data['employee_id'] = $others_apply = $request->employee_id;
      $data['created_by'] = Auth::guard('user')->user()->id;
    } else {
      $data['employee_id'] = Auth::guard('user')->user()->id;
      $data['created_by'] = Auth::guard('user')->user()->id;
    }
    $data['resignation_status'] = 1;

    // $attachments_count = count($request->resignation_attachment);
    // return response($attachments_count);

    // if (count($request->resignation_attachment)) {
    if (!empty($request->resignation_attachment)) {
      $exploded = explode(',', $request->resignation_attachment);
      if (strlen($request->resignation_attachment) >= 800) {
        $decoded = base64_decode($exploded[1]);
        $exploded1 = explode(';', $exploded[0]);
        $exploded2 = explode('/', $exploded1[0]);
        if (str_contains($exploded2[1], 'jpeg')) {
          $str_contains = 'jpeg';
        } elseif (str_contains($exploded2[1], 'pdf')) {
          $str_contains = 'pdf';
        } elseif (str_contains($exploded2[1], 'doc')) {
          $str_contains = 'doc';
        } elseif (str_contains($exploded2[1], 'docx')) {
          $str_contains = 'docx';
        } else {
          $str_contains = 'png';
        }

        $fileName = str_random() . '.' . $str_contains;
        $path = public_path() . '/attachments/' . $fileName;
        file_put_contents($path, $decoded);
        $data['resignation_attachment'] = $attachments['resignation_file'] = $fileName;
      }
    }
    // } 

    if (!empty($request->id)) {
      $update_data = Resignation::valid()->project()->findOrFail($request->id);
      $data['updated_by'] = Auth::guard('user')->user()->id;
      $save_data = $update_data->update($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
    } else {
      if (!empty($others_apply)) {
        $resign_data = Resignation::valid()->project()->select('*')->where('employee_id', '=', $request->resignation_apply_by)->first();
      } else {
        $resign_data = Resignation::valid()->project()->select('*')->where('employee_id', '=', Auth::guard('user')->user()->id)->first();
      }
      if (!empty($resign_data)) {
        $message = ['status' => 0, 'message' => 'Request already exist!'];
        return response($message);
      }
      // return response($resign_data);

      if (!empty($data['employee_id'])) {

        $employee_reporting_to = Employee::valid()->project()->select('employee_reporting_to')->where('id', '=', $data['employee_id'])->first();
        // return response($employee_reporting_to);
        if (!empty($employee_reporting_to->$employee_reporting_to) || $employee_reporting_to->$employee_reporting_to == 0) {
          // return response($employee_reporting_to);
          $reporting_id = trim($employee_reporting_to->employee_reporting_to);
          $employee_reporting = Employee::valid()->project()->select('id')->where('employee_id_no', '=', $reporting_id)->first();
          // return response($employee_reporting);
        } else {
          // return response('$employee_reporting_to');
          $message = ['status' => 0, 'message' => 'Reporting manager not set!'];
          return response($message);
        }
        if ($employee_reporting == '') {
          $message = ['status' => 0, 'message' => 'Reporting manager not set!'];
          return response($message);
        }

        // return response($employee_reporting);
      }

      $data['project_id'] = Auth::guard('user')->user()->project_id;
      $data['branch_id'] = Auth::guard('user')->user()->branch_id;
      $data['created_by'] = Auth::guard('user')->user()->id;
      $save_data = Resignation::create($data);


      /* Data sent to Resignation Attachment Table*/

      $attachments['resignation_id'] = $save_data->id;
      $attachments['project_id'] = Auth::guard('user')->user()->project_id;
      $attachments['branch_id'] = Auth::guard('user')->user()->branch_id;
      $attachments['created_by'] = Auth::guard('user')->user()->id;
      DB::table('resignation_attachments')->insert($attachments);

      /* Data sent to approval table */
      $employee_approvals_data = EmployeeApproval::valid()->project()->where('ea_employee_id', $data['employee_id'])->get();

      if (!$employee_approvals_data->isEmpty() && !empty($save_data)) {
        $i = 0;
        foreach ($employee_approvals_data as $key => $value) {
          $i++;
          $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
          $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id;
          $approve_data['created_by'] = Auth::guard('user')->user()->id;
          $approve_data['resignation_id'] = $save_data->id;
          $approve_data['approve_by'] = $value['ea_approve_by'];
          // $approve_data['leave_approve_status']= 1; 
          DB::table('resignation_approvals')->insert($approve_data);
          $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
        }
      } else {

        // return response($employee_approvals_data);
        $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
        $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id;
        $approve_data['created_by'] = Auth::guard('user')->user()->id;
        $approve_data['resignation_id'] = $save_data->id;
        $approve_data['approve_by'] = $employee_reporting['id'];
        // $approve_data['leave_approve_status']= 1;
        $save = DB::table('resignation_approvals')->insert($approve_data);
        $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
      }
      if (!empty($others_apply)) {
        // return response($others_apply);
        $employee_data['employee_status'] = 2;
        $employee_data['valid'] = 1;
        $udate_data = DB::table('employees')->where('id', $others_apply)->update($employee_data);

        $resignations_datap['resignation_status'] = 2;
        $udate_data = DB::table('resignations')->where('employee_id', $others_apply)->update($resignations_datap);

        $resignationsApprovalp['approve_by'] = Auth::guard('user')->user()->id;
        $resignationsApprovalp['approve_date'] = date('Y-m-d');
        $resignationsApprovalp['resignation_status'] = 2;
        $udate_data = DB::table('resignation_approvals')->where('resignation_id', $save_data->id)->update($resignationsApprovalp);
      }

      $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    }
    if (!$save_data) {
      $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
    }
    return response($message);
  }

  public function edit($id)
  {
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = $employee_ids['employee_id'];

    $data = Resignation::valid()->project()->findOrFail($id);
    $data['leave_apply_date_custom'] = date('j M Y', strtotime($data->leave_apply_date));
    $data['leave_from_date_custom'] = date('l, j M Y', strtotime($data->leave_from_date));
    $data['leave_to_date_custom'] = date('l, j M Y', strtotime($data->leave_to_date));
    $data['created_at_custom'] = date('D, j M Y, h:i A', strtotime($data->created_at));

    $user_employee_data = Employee::project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name'
      )
      ->where('employees.id', $data->employee_id)->first();

    if (!empty($user_employee_data->employee_joining_date)) {
      $data['employee_joining_date_custom'] = date('j M Y', strtotime($user_employee_data->employee_joining_date));
    } else {
      $data['employee_joining_date_custom'] = '';
    }

    $data['resignation_comments'] = ResignationApproval::project()
      ->leftJoin('employees', 'employees.id', '=', 'resignation_approvals.approve_by')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->select(
        'employees.*',
        'resignation_approvals.comments',
        'designations.designation_name'
      )
      ->where('resignation_id', $id)->get();
    // $data['employee_joining_date_custom'] = date('j M Y', strtotime($user_employee_data->employee_joining_date));
    $data['user_employee_data'] = $user_employee_data;
    $employee_data_list = Employee::valid()->project()->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->get()->keyBy('id')->all();
    $leave_type_data_list = LeaveType::valid()->project()->get()->keyBy('id')->all();
    if (!$data->leave_reliever) {
      $data->employee_name_value = ['id' => '', 'text' => ''];
    } else {
      $data->employee_name_value = ['id' => $data->leave_reliever, 'text' => $employee_data_list[$data->leave_reliever]->employee_fullname];
    }
    if (!$data->leave_type) {
      $data->leave_type_value = ['id' => '', 'text' => ''];
    } else {
      $data->leave_type_value = ['id' => $data->leave_type, 'text' => $leave_type_data_list[$data->leave_type]->leave_type_name];
    }
    $employee_data = array();
    $leave_type_data = array();
    foreach ($employee_data_list as $value) {
      array_push($employee_data, ['id' => $value['id'], 'text' => $value['employee_fullname']]);
    }
    foreach ($leave_type_data_list as $value) {
      array_push($leave_type_data, ['id' => $value['id'], 'text' => $value['leave_type_name']]);
    }
    $data->employee_data =  $employee_data;
    $data->leave_type_data =  $leave_type_data;
    // $data['leave_type_data']=array();

    // foreach ($leave_type_data as $value) {
    //   array_push($data['leave_type_data'],['id'=>$value['id'],'text'=>$value['leave_type_name']]);
    // }

    // $edit_data=Resignation::valid()->project()->findOrFail($id);
    return response($data);
  }
  public function destroy($id)
  {
    $delete_data = Resignation::valid()->project()->findOrFail($id);
    if ($delete_data->resignation_status == 2) {
      $message = ['status' => 0, 'message' => 'Approved data, you can not delete!'];
      return response($message);
    }
    if ($delete_data->delete()) {
      DB::table('resignation_approvals')->where('resignation_id', $id)->delete();
      DB::table('resignation_attachments')->where('resignation_id', $id)->delete();

      $employee_data['employee_status'] = 1;
      $employee_data['valid'] = 1;

      $udate_data = DB::table('employees')->where('id', $delete_data->employee_id)->update($employee_data);
      $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
    }
    return response($message);
  }

  public function approveOrReject(Request $request)
  {
    $resignation_id = $request->id;
    $user_id = Auth::guard('user')->user()->id;
    $user_data = UsersPersonModel::valid()->project()->where('id', $user_id)->first();
    $approval_info = EmployeeApproval::valid()->project()->where('ea_approve_by', $user_data->employee_id)->where('ea_employee_id', $request->employee_id)->first();
    if (empty($approval_info)) {
      $message = ['status' => 0, 'message' => 'You have no permission!'];
      return response($message);
    }
    // $approval_info=EmployeeApproval::valid()->project()->where('ea_approve_by', $user_data->employee_id)->first();
    // return response($approval_info);
    if (!empty($approval_info)) {
      $ea_approval_lavel = $approval_info->ea_approval_lavel;
      $ea_employee_id = $approval_info->ea_employee_id;
      $ea_approve_by = $approval_info->ea_approve_by;
      if ($ea_approval_lavel == 1) {
        if ($request->approve_reject_status == 1) {
          $data['resignation_status'] = 2;
        } else {
          $data['resignation_status'] = 4;
        }
      } else {
        if ($request->approve_reject_status == 1) {
          $data['resignation_status'] = 3;
        } else {
          $data['resignation_status'] = 4;
        }
      }
      $data['approve_date'] = date("Y-m-d");
      $data['comments'] = $request->comments;
      // $data['leave_view_date']= date("Y-m-d");
      $data['updated_at'] = date("Y-m-d H:i:s");
      // return response($leave_app_id);
      $udate_data = DB::table('resignation_approvals')->where('resignation_id', $resignation_id)->where('approve_by', $ea_approve_by)->update($data);
      // $leave_data['leave_apply_status'] = $data['leave_approve_status'];
      $udate_data = Resignation::valid()->project()->where('id', $resignation_id)->update(array('resignation_status' => $data['resignation_status']));
      // ->update('leave_apply_status',$data['leave_approve_status']);
      if ($udate_data && $request->approve_reject_status == 1) {
        $employee_data['employee_status'] = 2;
        $udate_data = DB::table('employees')->where('id', $request->employee_id)->update($employee_data);
        $message = ['status' => 1, 'message' => 'Resignation status updated!'];
      } else {
        $message = ['status' => 1, 'message' => 'Resignation rejected!'];
      }
      return response($message);
    }
  }
}
