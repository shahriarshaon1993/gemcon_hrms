<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Validator;
use Auth;
use Session;
use App\Model\UsersPersonModel;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\Section;
use App\Model\Department;
use App\Model\Designation;
use App\Model\JobGrade;
use App\Model\SubUnit;
use App\Model\WorkLocation;
use App\Model\MenuTable;
use App\Model\UserRole;
use App\Model\UserRoleAccess;
use App\Model\AttendanceSetup;
use App\Model\EmployeeAdressDetail;
use App\Model\EmployeeFamilyDetail;
use App\Model\EmployeeEducationalQualification;
use App\Model\EmployeeTrainingRecord;
use App\Model\EmployeeOthersContact;
use App\Model\LeaveType;
use App\Model\LeaveApplication;
use App\Model\HolidaySetup;
use App\Model\NoticeModel;
use App\Model\NoticePermission;
use App\Model\ServiceRequest;
use App\Model\LateRequest;
use App\Model\AttendanceIssue;
use App\Model\ManualAttendance;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use DB;
use Hash;
use Response;
use DateTime;
use DateInterval;
use DatePeriod;
use \Carbon\CarbonPeriod;
// use Carbon;



class ApiController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
       $paginate_data =Employee::valid()
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
        'company_sbus.id as sbus_id',
        'sections.section_name',
        'sections.id as sections_id',
        'sub_sections.sub_section_name',
        'sub_sections.id as sub_sections_id',
        'employee_groups.employee_group_name',
        'employee_groups.id as employee_group_id',
        'departments.department_name',
        'departments.id as department_id',
        'designations.designation_name',
        'designations.id as designation_id',
        'sub_units.sub_unit_name',
        'sub_units.id as sub_unit_id',
        'work_locations.work_location_name',
        'work_locations.id as work_location_id'
      )->get()->toArray();
        return $paginate_data;
    }
    public function find_employee_data(Request $request){
      $my_token = env('APP_API_TOCKEN'); 
      $token = $request->_token;
      if($token != $my_token){
        return 'You have not authorized!';
        exit();
      }
      $data = Employee::valid()->get()->toArray();
      return response()->json($data);
    }



    public function paginate($items, $perPage = 2, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

   




}