<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UsersPersonModel;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\Section;
use App\Model\Department;
use App\Model\Designation;
use App\Model\JobGrade;
use App\Model\SubUnit;
use App\Model\WorkLocation;
use App\Model\EmployeePersonalInfo;
use App\Model\EmployeeAdressDetail;
use App\Model\EmployeeIdentificationSupporting;
use App\Model\EmployeeEducationalQualification;
use App\Model\EmployeeReference;
use App\Model\EmployeeProfessionalQualification;
use App\Model\EmployeeEmploymentHistory;
use App\Model\EmployeeFamilyDetail;
use App\Model\EmployeeTrainingRecord;
use App\Model\EmployeeProfessionalMembership;
use App\Model\EmployeeBankAccountDetail;
use App\Model\EmployeeEmergencyContact;
use permission;
use Cache;
use Auth;
use DB;
// use Request;

class DashboardController extends Controller
{
    
    public function dashboardSummary(){
        $employee_list = new Employee();
        $employee_ids=$employee_list->Employee_id();
        $employee_id=$employee_ids['employee_id'];
        
        $company_sbu_data=CompanySbu::valid()->project()->where('sbu_status', '=', 1)->whereIn('id',$employee_ids['sub'])->get();
        $data['company_count'] = $company_sbu_data->count();
        $department_data=Department::valid()->project()->where('department_status', '=', 1)->whereIn('departments.id',$employee_ids['department'])->get();
        $data['department_count'] = $department_data->count();
        $designation_data=Designation::valid()->project()->where('designation_status', '=', 1)->whereIn('id',$employee_ids['designation'])->get();
        $data['designation_count'] = $designation_data->count();
        $employee_data=Employee::valid()->project()->where('employee_status', '=', 1)->whereIn('employee_sbu',$employee_ids['sub'])->whereIn('employee_department',$employee_ids['department'])->get();
        $data['employee_count'] = $employee_data->count();
        return response($data);
    }

  

    
}
