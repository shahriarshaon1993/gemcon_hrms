<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\ValidationException;
use Validator;
// use Illuminate\Validation\ValidationException;
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
use App\Model\DocumentFolder;
use App\Model\DocumentFile;
// use App\Http\Controllers\Controller;

use DB;
use Hash;
use Response;
use DateTime;
use DateInterval;
use DatePeriod;
use \Carbon\CarbonPeriod;
// use Carbon;



class AppraisalController extends Controller
{


    public function index(){

           return view('layouts.appraisal');
    }



}