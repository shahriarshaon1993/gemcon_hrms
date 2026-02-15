<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Model\UsersPersonModel;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\Section;
use App\Model\SubSection;
use App\Model\EmployeeGroup;
use App\Model\Department;
use App\Model\Designation;
use App\Model\JobGrade;
use App\Model\SubUnit;
use App\Model\UnitModel;
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
use App\Model\EmployeeOthersContact;
use App\Model\EmployeeApproval;
use App\Model\EmployeeIdRange;
use App\Model\LeaveType;
use App\Model\LeaveSetup;
use App\Model\LeaveApplication;
use App\Model\AttendanceSetup;
use App\Model\UserMultiLevelPermission;
use permission;
use Cache;
use Auth;
use DB;
use App\Model\DistrictModel;
use App\Model\UpazilaModel;
use App\Model\UnionModel;
use App\Model\EmployeeTransfer;
use App\Model\OfficeTimeSetup;

class UserMultiPermissionController extends Controller
{
    public function index(Request $request){
      $data['company_sbu_data']=array();
      $data['section_data']=array();
      $data['sub_section_data']=array();
      $data['sub_unit_data']=array();
      $data['unit_data']=array();
      $data['work_location_data']=array();
      $data['department_data']=array();
      $data['designation_data']=array();
      $data['employee_data']=array();

      $employee_list = new Employee();
      $employee_ids=$employee_list->Employee_id();
      $employee_id=$employee_ids['employee_id'];

      $company_sbu_data=CompanySbu::valid()->project()->whereIn('id',$employee_ids['sub'])->get();
      $section_data=Section::valid()->project()->whereIn('id',$employee_ids['section'])->get();
      $sub_section_data=SubSection::valid()->project()->whereIn('id',$employee_ids['subsection'])->get();
      $department_data=Department::valid()->project()->whereIn('id',$employee_ids['department'])->get();
      $designation_data=Designation::valid()->project()->get();
      $employee_data=Employee::valid()->project()->whereIn('employee_sbu',$employee_ids['sub'])->whereIn('employee_department',$employee_ids['department'])->get()->keyBy('employee_id_no')->all();
      $unit_data=UnitModel::valid()->project()->whereIn('id',$employee_ids['unit'])->get();
      $sub_unit_data=SubUnit::valid()->project()->whereIn('id',$employee_ids['subunit'])->get();
      $work_location_data=WorkLocation::valid()->project()->get();
      // ->whereIn('id',$employee_ids['work_location'])

      
      foreach ($company_sbu_data as $value) {
        array_push($data['company_sbu_data'],[
          'id'=>$value['id'],
          'text'=>$value['sbu_name'],
        ]);
      } 
      foreach ($section_data as $value) {
        array_push($data['section_data'],['id'=>$value['id'],'text'=>$value['section_name']]);
      } 
      foreach ($sub_section_data as $value) {
        array_push($data['sub_section_data'],['id'=>$value['id'],'text'=>$value['sub_section_name']]);
      }
      
      foreach ($department_data as $value) {
        array_push($data['department_data'],['id'=>$value['id'],'text'=>$value['department_name'],]);
      }
      foreach ($designation_data as $value) {
        array_push($data['designation_data'],['id'=>$value['id'],'text'=>$value['designation_name']]);
      }
    
      foreach ($employee_data as $value) {
        array_push($data['employee_data'],['id'=>$value['id'],'employeeNo'=>$value['id'],'text'=>$value['employee_id_no'].' - '.$value['employee_fullname'],'employee_id_no'=>$value['employee_id_no'],]);
      }
    
      foreach ($sub_unit_data as $value) {
        array_push($data['sub_unit_data'],['id'=>$value['id'],'text'=>$value['sub_unit_name']]);
      }

      foreach ($unit_data as $value) {
         // return response($value);
        array_push($data['unit_data'],['id'=>$value['id'],'text'=>$value['unit_name']]);
      }

      foreach ($work_location_data as $value) {
        array_push($data['work_location_data'],['id'=>$value['id'],'text'=>$value['work_location_name']]);
      }
      
      $data['userPermission']=['0' =>['id'=>0,'employee_id'=>'','group_permission'=>'','sbu_permission'=>'','unit_permission'=>'','sub_unit_permission'=>'','department_permission'=>'','section_permission'=>'','sub_section_permission'=>'','work_location_permission'=>'']];

      $data['allEmployees']=$employee_data;

      return response()->json($data);
    }


    public function userPermissionGet($id){
      $employee_list = new Employee();
      $employee_ids=$employee_list->Employee_id();
      $employee_id=$employee_ids['employee_id'];
      $UserMultiLevel=UserMultiLevelPermission::valid()->project()->where('employee_id',$id)->get();

      if(!empty($UserMultiLevel[0]['id'])){
         $company_sbu_data=CompanySbu::valid()->project()->whereIn('id',$employee_ids['sub'])->get();
          $section_data=Section::valid()->project()->whereIn('id',$employee_ids['section'])->get();
          $sub_section_data=SubSection::valid()->project()->whereIn('id',$employee_ids['subsection'])->get();
          $department_data=Department::valid()->project()->whereIn('id',$employee_ids['department'])->get();
          $unit_data=UnitModel::valid()->project()->whereIn('id',$employee_ids['unit'])->get();
          $sub_unit_data=SubUnit::valid()->project()->whereIn('id',$employee_ids['subunit'])->get();
          $work_location_data=WorkLocation::valid()->project()->get();
          // ->whereIn('id',$employee_ids['work_location'])

          foreach ($UserMultiLevel as $key => $value) {
            $sbu=collect($company_sbu_data)->where('id',$value['sbu_permission'])->first();
            $section=collect($section_data)->where('id',$value['section_permission'])->first();
            $sub_section=collect($sub_section_data)->where('id',$value['sub_section_permission'])->first();
            $department=collect($department_data)->where('id',$value['department_permission'])->first();
            $unit=collect($unit_data)->where('id',$value['unit_permission'])->first();
            $sub_unit=collect($sub_unit_data)->where('id',$value['sub_unit_permission'])->first();
            $work=collect($work_location_data)->where('id',$value['work_location_permission'])->first();

            // return response()->json($sub_section);
            if(!empty($sbu)){
              $UserMultiLevel[$key]['sbu_name']=$sbu['sbu_name'];
            }else{
               $UserMultiLevel[$key]['sbu_name']='';
            }
            if(!empty($section)){
               $UserMultiLevel[$key]['section_name']=$section['section_name'];
            }else{
               $UserMultiLevel[$key]['section_name']='';
            }
            if(!empty($sub_section)){
              $UserMultiLevel[$key]['sub_section_name']=$sub_section['sub_section_name'];
            }else{
               $UserMultiLevel[$key]['sub_section_name']='';
            }
            if(!empty($department)){
              $UserMultiLevel[$key]['department_name']=$department['department_name'];
            }else{
               $UserMultiLevel[$key]['department_name']='';
            }
            if(!empty($unit)){
              $UserMultiLevel[$key]['unit_name']=$unit['unit_name'];
            }else{
              $UserMultiLevel[$key]['unit_name']='';
            }
            if(!empty($sub_unit)){
              $UserMultiLevel[$key]['sub_unit_name']=$sub_unit['sub_unit_name'];
            }else{
               $UserMultiLevel[$key]['sub_unit_name']='';
            }
            if(!empty($work)){
              $UserMultiLevel[$key]['work_location_name']=$work['work_location_name'];
            }else{
              $UserMultiLevel[$key]['work_location_name']='';
            }
          }

        }else{

           $UserMultiLevel=['0' =>['id'=>0,'employee_id'=>'','group_permission'=>'','sbu_permission'=>'','unit_permission'=>'','sub_unit_permission'=>'','department_permission'=>'','section_permission'=>'','sub_section_permission'=>'','work_location_permission'=>'']];
        }

    
      return response()->json($UserMultiLevel);
    }


     public function store(Request $request){

      // try {
      //   DB::beginTransaction();
        $userPermission=collect($request->userPermission)->where('employee_id','!=','')->toArray();
        if(!empty($userPermission)){
            $insert_array=[];
             DB::table('user_multilevel_permissions')->where('employee_id',$request['employee_id'])->delete();
            foreach ($userPermission as $key => $value) {
                $unit_permission='';
                $sub_unit_permission='';
                $department_permission='';
                $section_permission='';
                $sub_section_permission='';
                $work_location_permission='';
                $group_permission=Auth::guard('user')->user()->project_id;
                if(!empty($value['unit_permission'])){
                  $unit_permission=$value['unit_permission'];
                }
                if(!empty($value['sub_unit_permission'])){
                  $sub_unit_permission=$value['sub_unit_permission'];
                }
                if(!empty($value['department_permission'])){
                  $department_permission=$value['department_permission'];
                }
                if(!empty($value['section_permission'])){
                  $section_permission=$value['section_permission'];
                }
                if(!empty($value['sub_section_permission'])){
                  $sub_section_permission=$value['sub_section_permission'];
                }
                if(!empty($value['work_location_permission'])){
                  $work_location_permission=$value['work_location_permission'];
                }

               if(!empty($value['sbu_permission'])){
                 $insert_array[]=[
                  "employee_id"=>$value['employee_id'],
                  // "group_permission"=>$value1['date'],
                  "sbu_permission"=>$value['sbu_permission'],
                  "unit_permission"=>$unit_permission,
                  "sub_unit_permission"=>$sub_unit_permission,
                  "department_permission"=>$department_permission,
                  "section_permission"=>$section_permission,
                  "sub_section_permission"=>$sub_section_permission,
                  "work_location_permission"=>$work_location_permission,
                  "project_id"=>Auth::guard('user')->user()->project_id,
                  "branch_id"=>Auth::guard('user')->user()->branch_id,
                  "created_by"=>Auth::guard('user')->user()->id,
                  "created_by"=>date('Y-m-d H:i:s'),
                ];
               } 
                
            }

             UserMultiLevelPermission::insert($insert_array);
      // DB::commit();
      $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
      return response($message);
    // } catch (\Exception $exception) {
    //     DB::rollBack();
    //     $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
    //     return response($exception);
    // }


// return response()->json($insert_array);

        }else{
           // return response($request->employee_id);
            DB::table('user_multilevel_permissions')->where('employee_id',$request['employee_id'])->delete();
           $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
          return response($message);

        }
      //   foreach ($request->employee_data_approvaldat as $key => $value) {
      //     $emp_name=$value['employee_fullname'];
      //     $emp_id_no=$value['employee_id_no'];
      //     $emp_id=$value['id'];
      //     $emn=0;
      //     foreach ($value['datesLists'] as $key => $value1) {
      //       if (!empty($value1['shiftTimeid']['id'])) {
      //          $emn++;
      //         DB::table('attendance_setups')->where('start_date','=',$value1['date'])
      //               ->where('employee_id',$emp_id)->delete();
      //         if($emn > 0 ){
      //           $finds=DB::table('attendance_setups')->where('employee_id','=',$emp_id)
      //           ->where('end_date','>=',$value1['date'])
      //           ->update([
      //              'end_date' =>  date('Y-m-d', strtotime('-1 day', strtotime($value1['date']))),
      //           ]);
      //         }      

      //         $insert_array[]=[
      //           "employee_id"=>$emp_id,
      //           "start_date"=>$value1['date'],
      //           "end_date"=>$value1['date'],
      //           "attendance_office_time"=>$value1['shiftTimeid']['id'],
      //           "attendance_setup_status"=>1,
      //           "attendance_type"=>1,
      //           "attendance_category"=>1,
      //           "attendance_machine_no"=>4,
      //           "project_id"=>Auth::guard('user')->user()->project_id,
      //           "branch_id"=>Auth::guard('user')->user()->branch_id,
      //           "created_by"=>Auth::guard('user')->user()->id,
      //           "created_by"=>date('Y-m-d H:i:s'),
      //         ];
      //       }else{
      //         $insert_array[]=[
      //           "employee_id"=>$emp_id,
      //           "start_date"=>"",
      //           "end_date"=>"",
      //           "attendance_office_time"=>"",
      //           "attendance_setup_status"=>1,
      //           "attendance_type"=>1,
      //           "attendance_category"=>1,
      //           "attendance_machine_no"=>4,
      //           "project_id"=>Auth::guard('user')->user()->project_id,
      //           "branch_id"=>Auth::guard('user')->user()->branch_id,
      //           "created_by"=>Auth::guard('user')->user()->id,
      //           "created_by"=>date('Y-m-d H:i:s'),
      //         ];
      //       }
      //     }
      // }

      // $insert_array_find=collect($insert_array)->where('attendance_office_time','!=',"")->toArray();
      // AttendanceSetup::insert($insert_array_find);


      // return response()->json($UserMultiLevel);

     }






    


    
}
