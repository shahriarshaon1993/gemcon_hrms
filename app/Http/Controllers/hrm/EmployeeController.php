<?php

namespace App\Http\Controllers\hrm;

use App\Model\Floor;
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

// use App\Model\EmployeeIdRange;
use App\Model\payroll\Salary;
use App\Model\AttendanceSetup;
use App\Helper\ResponseUtil;
use Response;
use DateTime;
use Cache;
use Auth;
use DB;
use App\Model\DistrictModel;
use App\Model\UpazilaModel;
use App\Model\UnionModel;
use App\Model\EmployeeTransfer;
use App\Model\OfficeTimeSetup;
use App\Model\WorkArea;
use App\Model\EmployeeHistory;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $cache = Cache::get('permission');
        $permission = collect($cache)->where('menu_uid', '=', 'EmployeeList')->where('role_id',
            Auth::guard('user')->user()->role_id)->toArray();
        foreach ($permission as $child) {
            if ($child['link_uid'] == 'add') {
                $data['add'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'edit') {
                $data['edit'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'delete') {
                $data['delete'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'more_info') {
                $data['more_info'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'emp_profile') {
                $data['emp_profile'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'emp_request') {
                $data['emp_request'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'portal_user') {
                $data['portal_user'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'reset_password') {
                $data['reset_password'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'leave_apply') {
                $data['leave_apply'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'manual_attendance') {
                $data['manual_attendance'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'resign_request') {
                $data['resign_request'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'employee_transfer') {
                $data['employee_transfer'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'promotion_increment') {
                $data['promotion_increment'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'appointment') {
                $data['appointment'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'idcard') {
                $data['idcard'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'name') {
                $data['name'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'time') {
                $data['time'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'image') {
                $data['image'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'designation') {
                $data['designation'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'jobgrade') {
                $data['jobgrade'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'sbu') {
                $data['sbu'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'unit') {
                $data['unit'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'subunit') {
                $data['subunit'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'department') {
                $data['department'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'section') {
                $data['section'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'subsection') {
                $data['subsection'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'worklocation') {
                $data['worklocation'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'employeetype') {
                $data['employeetype'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'probmonth') {
                $data['probmonth'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'duedate') {
                $data['duedate'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'employeegroup') {
                $data['employeegroup'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'leavegroup') {
                $data['leavegroup'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'portaluser') {
                $data['portaluser'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'durationtype') {
                $data['durationtype'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'attendancebonus') {
                $data['attendancebonus'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'salarytype') {
                $data['salarytype'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'reporting') {
                $data['reporting'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'emailid') {
                $data['emailid'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'pabx') {
                $data['pabx'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'pmobile') {
                $data['pmobile'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'omobile') {
                $data['omobile'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'joiningdate') {
                $data['joiningdate'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'religion') {
                $data['religion'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'status') {
                $data['status'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'employeecategory') {
                $data['employeecategory'] = $child['link_uid'];
            } else {
                $data['approve'] = $child['link_uid'];
            }
        }
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $search_key_velue = $request->input('search_inpu_all');


        // if(($search_key =='Active') || ($search_key=='Inactive') || ($search_key=='Resign') || ($search_key=='Joing') || ($search_key=='team')){
        //   $search_key = '';
        //   $search_key_velue =$request->input('search_key');
        // }else{

        //   $search_key = $request->input('search_key');
        //   $search_key_velue ='';
        // }
        // return response()->json($search_key_velue);
        $order = $request->input('order');
        $sort = $request->input('sort');
        $project_id = Auth::guard('user')->user()->project_id;
        $branch_id = Auth::guard('user')->user()->branch_id;

        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];

        $company_sbu = Auth::guard('user')->user()->company_sbu;
        $unit = Auth::guard('user')->user()->unit;
        $sub_unit = Auth::guard('user')->user()->sub_unit;
        $department = Auth::guard('user')->user()->department;
        $section = Auth::guard('user')->user()->section;
        $sub_section = Auth::guard('user')->user()->sub_section;
        $user_type = Auth::guard('user')->user()->user_type;
        $paginate_data = Employee::valid()->project()
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
                    $query2->where('employees.employee_fullname', 'LIKE', '%'.$search_key.'%')
                        ->orWhere('employees.employee_mobile', 'LIKE', '%'.$search_key.'%')
                        ->orWhere('employees.employee_joining_date', 'LIKE', '%'.$search_key.'%')
                        ->orWhere('employees.employee_id_no', 'LIKE', '%'.$search_key.'%')
                        ->orWhere('company_sbus.sbu_name', 'LIKE', '%'.$search_key.'%')
                        ->orWhere('departments.department_name', 'LIKE', '%'.$search_key.'%')
                        ->orWhere('designations.designation_name', 'LIKE', '%'.$search_key.'%')
                        ->orWhere('sub_units.sub_unit_name', 'LIKE', '%'.$search_key.'%')
                        ->orWhere('work_locations.work_location_name', 'LIKE', '%'.$search_key.'%')
                        ->orWhere('employees.employee_status', 'LIKE', '%'.$search_key.'%')
                        ->orWhere('sections.section_name', 'LIKE', '%'.$search_key.'%');
                });
                return $query;
            })->whereIn('employees.id', $employee_id);
        // }
        if ($search_key_velue == 'Active') {
            $paginate_data = $paginate_data->where('employees.employee_status', 1);
        } elseif ($search_key_velue == 'Inactive') {
            $paginate_data = $paginate_data->where('employees.employee_status', 0);
        } elseif ($search_key_velue == 'Resign') {
            $paginate_data = $paginate_data->where('employees.employee_status', 2);
        } elseif ($search_key_velue == 'Joing') {
            $paginate_data = $paginate_data->where('employees.employee_status', 3);
        } elseif ($search_key_velue == 'team') {
            $paginate_data = $paginate_data->where('employees.employee_status', 1)->where('employee_reporting_to',
                Auth::guard('user')->user()->employee_card_no);
        }
        // })->where('employees.employee_status',1)->whereIn('employees.id',$employee_id);

        $employeeAll = $paginate_data;
        $data['paginate_data'] = $employeeAll->orderBy($sort, $order)->paginate($paginate_num);
        $employeeAlls = Employee::valid()->project()->whereIn('id', $employee_id)->get();
        // $employeeAll->get()->toArray();
        $employeesCounts = collect(collect($employeeAlls)->pluck('employee_designation')->unique()->values('employee_designation')->all())->toArray();
        $data['company_count'] = count($employee_ids['sub']);
        $data['department_count'] = count($employee_ids['department']);
        $data['designation_count'] = count($employeesCounts);
        $data['employee_count'] = count(collect(collect($employeeAlls)->where('employee_status',
            1)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['newJoining'] = count(collect(collect($employeeAlls)->where('employee_status',
            3)->pluck('id')->unique()->values('id')->all())->toArray());
        // $my_team_employees = Employee::valid()->project()->where('employee_reporting_to', Auth::guard('user')->user()->employee_card_no)->get();
        $data['my_team_employees'] = count(collect(collect($employeeAlls)->where('employee_status',
            1)->where('employee_reporting_to',
            Auth::guard('user')->user()->employee_card_no)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['inactive_employee_count'] = count(collect(collect($employeeAlls)->where('employee_status',
            0)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['resign_semployee_count'] = count(collect(collect($employeeAlls)->where('employee_status',
            2)->pluck('id')->unique()->values('id')->all())->toArray());

        return response()->json($data);
    }

    public function getEmployeeData(Request $request)
    {
        $employee_id = $request->input('employee_id');
        $employee_data = Employee::valid()->project()
            ->select(
                'employees.*',
                'company_sbus.sbu_name'
            )
            ->join('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->where('employees.id', $employee_id)->first();
        return response()->json($employee_data);
    }

    public function get_employee_data_bangla(Request $request)
    {
        $employee_id = $request->input('employee_id');
        $employee_data = Employee::valid()->project()
            ->select(
                'employees.*',
                'company_sbus.sbu_name',
                'employee_adress_details.present_holding_no',
                'employee_adress_details.present_address_bangla',
                'employee_adress_details.present_vill_area',
                'employee_adress_details.present_post_office',
                'employee_adress_details.present_house_name',
                'employee_adress_details.present_road_no',
                'employee_adress_details.present_road_name',
                'districts.name as d_name',
                'upazilas.name as up_name',
                'employee_personal_infos.employee_nid_name_bangla',
                'employee_personal_infos.employee_nick_name',
                'employee_personal_infos.employee_father_name_bangla',
                'employee_personal_infos.employee_mother_name_bangla',
                'employee_personal_infos.employee_gender',
                'work_locations.work_location_name',
                'work_locations.work_location_bangla',
                'designations.designation_name',
                'designations.designation_name_bangla',
                'designations.designation_name',
                'salaries.gross_salary',
                'salaries.gross_salary_bangla',
                'salaries.gross_salary_bangla_text',
                'departments.department_name',
          )
            ->leftjoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftjoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftjoin('employee_adress_details', 'employee_adress_details.ead_employee_id', '=', 'employees.id')
            ->leftjoin('districts', 'districts.id', '=', 'employee_adress_details.present_district')
            ->leftjoin('upazilas', 'upazilas.id', '=', 'employee_adress_details.present_thana')
            ->leftjoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->leftjoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->leftjoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftjoin('salaries', 'salaries.employee_id', '=', 'employees.id')
            ->where('employees.id', $employee_id)->first();
        //  return $employee_data;
        $repotingTo = Employee::valid()->project()
            ->leftjoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftjoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->where('employees.employee_id_no', $employee_data['employee_reporting_to'])->first();
        $employee_data->signature_settings =DB::table('signature_settings')->where('signature_settings.valid', 1)
            ->select(
                'employees.employee_fullname',
                'employees.employee_name_bangla',
                'designations.designation_name',
                'designations.designation_name_bangla',
                'departments.department_name',
                'departments.department_name_bangla',
                'signature_settings.signature_image',
            )
            ->leftjoin('employees', 'employees.id', '=', 'signature_settings.employee_id')
            ->leftjoin('departments', 'departments.id', '=', 'signature_settings.employee_department')
            ->leftjoin('designations', 'designations.id', '=', 'signature_settings.employee_designation')
            // ->where('signature_settings.employee_sbu', 11)
            ->where('signature_settings.employee_id', 2007)
            ->orderBy('signature_settings.signature_priority', 'ASC')
            ->get();
        $employee_data->repotingToDepartment = $repotingTo['department_name'];
        $employee_data->repotingToDesignations = $repotingTo['designation_name'];
        $employee_joining_date = date("d F Y", strtotime($employee_data->employee_joining_date));
        $employee_confirmation_due_date = date("d F Y", strtotime($employee_data->employee_confirmation_due_date));
        $employee_due_month = $employee_data->employee_due_month;
        if ($employee_data->employee_sbu == 11 || $employee_data->employee_sbu == 12) {
            $dataget = Employee::where('employee_id_no', '>', '220021')->where('employee_id_no', '<=',
                $employee_data->employee_id_no)->count('id');
            $employee_id_bangla = (784 + $dataget);
        } else {
            $employee_id_bangla = 0;
        }
        $employee_id_bangla = $employee_id_bangla;
        $gross_salary = $employee_data->gross_salary;
        if (!empty($employee_data->employee_appoinment_date)) {
            $today_date = date("d F Y", strtotime($employee_data->employee_appoinment_date));
        } else {
            $today_date = date("d F Y");
        }

        $present_year = date("Y");
        $data['amount_word'] = $this->inword($today_date);
        $data['today_date_bangla'] = $this->date_change_english_2bangla($today_date);
        $data['today_date_en'] = $today_date;
        $data['joining_date_bangla'] = $this->date_change_english_2bangla($employee_joining_date);
        $data['joining_date_en'] = $employee_joining_date;
        $data['confirmation_due_date_bangla'] = $this->date_change_english_2bangla($employee_confirmation_due_date);
        $data['due_month_bangla'] = $this->no_change_english_2bangla($employee_due_month);
        $employee_data->gross_salary_bangla = $this->no_change_english_2bangla($gross_salary);
        $data['year_bangla'] = $this->no_change_english_2bangla($present_year);
        $data['year_en'] = $present_year;
        $data['serial_bangla'] = $this->no_change_english_2bangla($employee_id_bangla);
        $data['serial_en'] = $employee_id_bangla;
        $data['gross_salary_inwords'] = self::inword($gross_salary);
        $data['salary_inwords_bangla'] = '';
        $employee_data->employee_due_month_text = self::inwordText($employee_due_month);
        $employee_data->gross_salary_inwords = self::inword($gross_salary);
        // $data['salary_inwords_bangla'] = $this->translate_en_2bn($data['gross_salary_inwords']);
        $data['employee_data'] = $employee_data;
        return response()->json($data);
    }

    public function translate_en_2bn($text = null)
    {
        $from_lan = 'en';
        $to_lan = 'bn';
        $json = json_decode(file_get_contents('https://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q='.urlencode($text).'&langpair='.$from_lan.'|'.$to_lan));
        $translated_text = $json->responseData->translatedText;
        return $translated_text;
    }

    public function date_change_english_2bangla($english_date = null)
    {
        $search_array = array(
            "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন",
            "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", ":", ","
        );
        $replace_array = array(
            "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December", ":", ","
        );
        $en_number = str_replace($replace_array, $search_array, $english_date);
        return $en_number;
    }

    public function no_change_english_2bangla($number = null)
    {
        $en = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];
        $bn = ["১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০"];
        $en2bn = str_replace($en, $bn, $number);
        return $en2bn;
    }

    public static function inword($Total_Credit_Amount)
    {
        $number = $Total_Credit_Amount;
        $no = round($number);
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            '0' => '', '1' => 'One', '2' => 'Two',
            '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
            '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
            '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
            '13' => 'Thirteen', '14' => 'Fourteen',
            '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
            '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty',
            '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
            '60' => 'Sixty', '70' => 'Seventy',
            '80' => 'Eighty', '90' => 'Ninety'
        );
        $digits = array('', 'Hundred', 'Thousand', 'Lac', 'Crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? '' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number]." ".$digits[$counter].$plural." ".$hundred : $words[floor($number / 10) * 10]." ".$words[$number % 10]." ".$digits[$counter].$plural." ".$hundred;
            } else {
                $str[] = null;
            }
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $p = $result."Taka Only";
        return $p;
    }

    public static function inwordText($Total_Credit_Amount)
    {
        $number = $Total_Credit_Amount;
        $no = round($number);
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            '0' => '', '1' => 'One', '2' => 'Two',
            '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
            '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
            '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
            '13' => 'Thirteen', '14' => 'Fourteen',
            '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
            '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty',
            '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
            '60' => 'Sixty', '70' => 'Seventy',
            '80' => 'Eighty', '90' => 'Ninety'
        );
        $digits = array('', 'Hundred', 'Thousand', 'Lac', 'Crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? '' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number]." ".$digits[$counter].$plural." ".$hundred : $words[floor($number / 10) * 10]." ".$words[$number % 10]." ".$digits[$counter].$plural." ".$hundred;
            } else {
                $str[] = null;
            }
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $p = $result;
        return $p;
    }

    public function employee_Id_Create($id)
    {
        $data['employee_id_no'] = $this->employee_new_id_create($id);
        return response($data);
    }

    public function employee_new_id_create($id)
    {
        $rangeid = DB::table('employee_id_serial_start_list')
            // EmployeeIdRange::
            ->where('sbu_id', $id)->first();
        $employee_id_no = Employee::where('employee_id_no', '>=', $rangeid->start_code)->where('employee_id_no', '<=',
            $rangeid->end_code)->orderBy('employee_id_no', 'DESC')->first();
        if (!empty($employee_id_no)) {
            $employee_id_no = $employee_id_no['employee_id_no'];
            $employee_id_no = $employee_id_no + 1;
        } else {
            $employee_id_no = $rangeid['start_code'] + 1;
        }
        // $data['employee_id_no'] = $employee_id_no;
        return $employee_id_no;
    }

    public function create()
    {
        $data['company_sbu_data'] = array();
        $data['section_data'] = array();
        $data['sub_section_data'] = array();
        $data['sub_unit_data'] = array();
        $data['unit_data'] = array();
        $data['work_location_data'] = array();
        $data['work_area'] = array();
        $data['department_data'] = array();
        $data['designation_data'] = array();
        $data['jobgrade_data'] = array();
        $data['employee_data'] = array();
        $data['employee_data_approval'] = array();
        $data['employee_group_data'] = array();
        $data['role_id'] = Auth::guard('user')->user()->user_type;

        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];
        // ->whereIn('id',$employee_ids['sub'])
        $company_sbu_data = CompanySbu::valid()->project()->whereIn('id', $employee_ids['sub'])->get();
        // ->whereIn('id',$employee_ids['section'])
        $section_data = Section::valid()->project()->get();
        // ->whereIn('id',$employee_ids['subsection'])
        // ->whereIn('id',$employee_ids['department'])

        // echo "<pre>";
        // print_r($section_data);
        // exit();
        $sub_section_data = SubSection::valid()->project()->orderBy('priority', 'ASC')->get();
        $department_data = Department::valid()->project()->orderBy('priority', 'ASC')->get();
        $designation_data = Designation::valid()->project()->orderBy('priority', 'ASC')->get();
        $jobgrade_data = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();
        $employee_data_approval = Employee::valid()->project()->whereIn('employee_sbu',
            $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->where('employee_status',
            1)->get();
        // return response($employee_data_approval);
        $employee_data = Employee::valid()->project()->whereIn('employee_sbu',
            $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->where('employee_status',
            1)->get()->keyBy('employee_id_no')->all();
        // ->whereIn('id',$employee_ids['unit'])
        $unit_data = UnitModel::valid()->project()->orderBy('priority', 'ASC')->get();
        // ->whereIn('id',$employee_ids['subunit'])
        $sub_unit_data = SubUnit::valid()->project()->orderBy('priority', 'ASC')->get();
        $work_location_data = WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get();
        $work_area = WorkArea::valid()->project()->orderBy('priority', 'ASC')->get();
        $employee_group_data = EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get();


        foreach ($company_sbu_data as $value) {
            array_push($data['company_sbu_data'], [
                'id' => $value['id'],
                'text' => $value['sbu_name'],
                'office_start_time' => $value['office_start_time'],
                'office_end_time' => $value['office_end_time'],
                'shift_time' => $value['office_start_time'].'-'.$value['office_end_time']
            ]);
        }
        foreach ($section_data as $value) {
            array_push($data['section_data'], ['id' => $value['id'], 'text' => $value['section_name']]);
        }
        foreach ($sub_section_data as $value) {
            array_push($data['sub_section_data'], ['id' => $value['id'], 'text' => $value['sub_section_name']]);
        }
        foreach ($employee_group_data as $value) {
            array_push($data['employee_group_data'], ['id' => $value['id'], 'text' => $value['employee_group_name']]);
        }
        foreach ($department_data as $value) {
            array_push($data['department_data'], ['id' => $value['id'], 'text' => $value['department_name'],]);
        }
        foreach ($designation_data as $value) {
            array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
        }
        foreach ($jobgrade_data as $value) {
            array_push($data['jobgrade_data'], ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        }
        foreach ($employee_data as $value) {
            array_push($data['employee_data'], [
                'id' => $value['employee_id_no'], 'employeeNo' => $value['id'],
                'text' => $value['employee_id_no'].' - '.$value['employee_fullname']
            ]);
        }

        foreach ($employee_data_approval as $value) {
            // return response($value);
            array_push($data['employee_data_approval'], [
                'id' => $value['id'], 'employee_name' => $value['employee_fullname'],
                'employee_ids' => $value['employee_id_no'],
                'text' => $value['employee_id_no'].' : '.$value['employee_fullname']
            ]);
        }
        foreach ($sub_unit_data as $value) {
            array_push($data['sub_unit_data'], ['id' => $value['id'], 'text' => $value['sub_unit_name']]);
        }

        foreach ($unit_data as $value) {
            // return response($value);
            array_push($data['unit_data'], ['id' => $value['id'], 'text' => $value['unit_name']]);
        }

        foreach ($work_location_data as $value) {
            array_push($data['work_location_data'], ['id' => $value['id'], 'text' => $value['work_location_name']]);
        }
        foreach ($work_area as $value) {
            array_push($data['work_area'], ['id' => $value['id'], 'text' => $value['work_location_name']]);
        }

        $data['office_time_data'] = array();
        $office_time_data = OfficeTimeSetup::valid()->project()->where('type', 1)->get();
        foreach ($office_time_data as $value) {
            array_push($data['office_time_data'],
                ['id' => $value['id'], 'text' => $value['office_start_time'].' - '.$value['office_end_time']]);
        }

        $data['approval_infosss'] = ['0' => ['id' => 0, 'permission_type' => '', 'permission_id' => '']];

        $data['approval_infos'] = [
            '0' => [
                'id' => 0, 'ea_approve_by' => '', 'employees_ids' => '', 'ea_approve_by_name' => ''
            ]
        ];
        $data['employee_id_no'] = 'xxxxxx';
        $data['allEmployees'] = $employee_data;
        $data['employee_interview_date'] = date('Y-m-d');
        $data['employee_appoinment_date'] = date('Y-m-d');
        $data['employee_joining_date'] = date('Y-m-d');
        $data['employee_status'] = 3;
        $data['employee_sbu'] = Auth::guard('user')->user()->company_sbu;
        $data['employee_section'] = Auth::guard('user')->user()->section;

        // $data['approval_infos']=EmployeeApproval::valid()->project()->get();
        // $data['approval_infos']=EmployeeApproval::valid()->project()->where('ea_employee_id',$id)->get();
        return response($data);
    }

    public function store(Request $request)
    {
//        return $request->input('floor_number');
        // return response($request);
        $validate = [
            // 'employee_id_no' => 'required|unique:employees,employee_id_no,' . $request->id,
            'employee_fullname' => 'required',
            'employee_department' => 'required',
            'employee_dob_certificate' => 'required',
            'employee_joining_date' => 'required',
            'employee_sbu' => 'required',
            'employee_salary_type' => 'required',
            'attendance_bonus_get' => 'required',
            'salary_duration_type' => 'required',
            'employee_reporting_to' => 'required',
            'emplyee_category_mgt_non_mgt' => 'required',
            'employee_type' => 'required',
            'employee_job_grade' => 'required',
            'employee_designation' => 'required',
            'employee_blood_group' => 'required',
            'employee_gender' => 'required',
            'employee_marital_status' => 'required',
            'proximity_no',
            'finger_print',
            'floor_number',
        ];
        $request->validate($validate);
        $data = $request->only(
            'attendance_bonus_get',
            'employee_salary_type',
            'salary_duration_type',
            'employee_id_no',
            'employee_fullname',
            'employee_sbu',
            'employee_department',
            'employee_designation',
            'employee_job_grade',
            'employee_mobile',
            'employee_reporting_to',
            'employee_machine_id',
            'employee_leave_group',
            'employee_work_location',
            'work_area',
            'employee_remarks',
            'employee_section',
            'employee_sub_unit',
            'employee_interview_date',
            'employee_appoinment_date',
            'employee_type',
            'employee_type_bangla',
            'employee_sub_section',
            'emplyee_category_mgt_non_mgt',
            'employee_group',
            'employee_due_month',
            'employee_confirmation_due_date',
            'official_mobile_no',
            'official_email_id',
            'desk_phone_no',
            'employee_unit',
            'employee_number',
            'proximity_no',
            'finger_print',
            'floor_number'
        );
        // dd($data);
        if ($request->employee_status == false) {
            $data['employee_status'] = 0;
            $employee_status = 0;
        } else {
            $data['employee_status'] = 1;
            $employee_status = 1;
        }

        if ($request->employee_image) {
            $image = $request->employee_image;
        } else {
            $image = '';
        }
        if (!empty($image)) {
            $exploded = explode(',', $image);
            if (strlen($request->employee_image) >= 800) {
                $decoded = base64_decode($exploded[1]);
                $exploded1 = explode(';', $exploded[0]);
                $exploded2 = explode('/', $exploded1[0]);
                if (str_contains($exploded2[1], 'jpeg')) {
                    $str_contains = 'jpeg';
                } else {
                    $str_contains = 'png';
                }
                $fileName = str_random().'.'.$str_contains;

                $path = public_path().'/images/'.$fileName;
                file_put_contents($path, $decoded);
                $data['employee_image'] = $fileName;
            }
        } else {
            $data['employee_image'] = '';
        }
        if ($request['employee_interview_date']) {
            $data['employee_interview_date'] = date('Y-m-d', strtotime($request['employee_interview_date']));
        }
        if ($request['employee_appoinment_date']) {
            $data['employee_appoinment_date'] = date('Y-m-d', strtotime($request['employee_appoinment_date']));
        }
        if ($request['employee_joining_date']) {
            $data['employee_joining_date'] = date('Y-m-d', strtotime($request['employee_joining_date']));
        }

        try {
            DB::beginTransaction();
            if (!empty($request->id)) {
                if ($request->make_user == 1) {
                    $user = DB::table('users_person')->where('employee_card_no', '=',
                        $request->employee_id_no)->first();
                    // return response($user);

                    if (empty($user)) {
                        $user_data['employee_card_no'] = $request->employee_id_no;
                        $user_data['name'] = $request->employee_fullname;
                        $user_data['employee_id'] = $request->id;
                        $user_data['company_id'] = $request->company_id;
                        $user_data['password'] = Hash::make('123456');
                        $user_data['status'] = 1;
                        $user_data['role_id'] = 1;
                        $user_data['project_id'] = Auth::guard('user')->user()->project_id;
                        $user_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                        $user_data['user_type'] = $request->user_type;
                        $user_data['company_sbu'] = $request->employee_sbu;
                        $user_data['unit'] = $request->employee_unit;
                        $user_data['sub_unit'] = $request->employee_sub_unit;
                        $user_data['department'] = $request->employee_department;
                        $user_data['section'] = $request->employee_section;
                        $user_data['sub_section'] = $request->employee_sub_section;

                        DB::table('users_person')->insert($user_data);
                    } else {
                        $user_data['employee_card_no'] = $request->employee_id_no;
                        $user_data['name'] = $request->employee_fullname;
                        $user_data['employee_id'] = $request->id;
                        $user_data['company_id'] = $request->company_id;
                        // $user_data['password']= Hash::make('123456');
                        $user_data['status'] = 1;
                        // $user_data['role_id']=1;
                        $user_data['project_id'] = Auth::guard('user')->user()->project_id;
                        $user_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                        $user_data['user_type'] = $request->user_type;
                        $user_data['company_sbu'] = $request->employee_sbu;
                        $user_data['unit'] = $request->employee_unit;
                        $user_data['sub_unit'] = $request->employee_sub_unit;
                        $user_data['department'] = $request->employee_department;
                        $user_data['section'] = $request->employee_section;
                        $user_data['sub_section'] = $request->employee_sub_section;
                        DB::table('users_person')->where('employee_card_no', '=',
                            $request->employee_id_no)->update($user_data);
                    }
                } else {
                    DB::table('users_person')->where('employee_card_no', '=', $request->employee_id_no)->delete();
                }

                $update_data = Employee::valid()->project()->findOrFail($request->id);
                $data['updated_by'] = Auth::guard('user')->user()->id;
                $data['employee_status'] = $employee_status;
                $save_data = $update_data->update($data);
                $approval_infos = collect($request['approval_infos'])->where('ea_approve_by', '!=', '')->toArray();

                if ($approval_infos !== '') {
                    DB::table('employee_approvals')->where('ea_employee_id', '=', $request->id)->delete();
                    $i = 0;
                    foreach ($approval_infos as $key => $value) {
                        $i++;
                        $approval_data['ea_employee_id'] = $request->id;
                        $approval_data['ea_approval_lavel'] = $i;
                        $approval_data['ea_approve_by'] = $value['ea_approve_by'];
                        $approval_data['project_id'] = Auth::guard('user')->user()->project_id;
                        $approval_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                        $approval_data['created_by'] = Auth::guard('user')->user()->id;
                        DB::table('employee_approvals')->insert($approval_data);
                    }
                }
                $this->personalInfoStore($request);
                $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
            } else {
                if ($request->emplyeeIdEditeValue == 1) {
                    $data['employee_id_no'] = $request->employee_id_no;
                    $data['employee_number'] = $request->employee_id_no;
                } else {
                    $data['employee_id_no'] = $this->employee_new_id_create($request->employee_sbu);
                    $data['employee_number'] = $this->employee_new_id_create($request->employee_sbu);
                }
                $data['project_id'] = Auth::guard('user')->user()->project_id;
                $data['branch_id'] = Auth::guard('user')->user()->branch_id;
                $data['created_by'] = Auth::guard('user')->user()->id;
                $save_data = Employee::create($data);
                if ($request->make_user == 1) {
                    $user = DB::table('users_person')->where('employee_card_no', $request->employee_id_no)->first();
                    if (empty($user)) {
                        $user_data['employee_card_no'] = $save_data->employee_id_no;
                        $user_data['name'] = $request->employee_fullname;
                        $user_data['employee_id'] = $save_data->id;
                        $user_data['company_id'] = $request->company_id;
                        $user_data['password'] = Hash::make('123456');
                        $user_data['status'] = 1;
                        $user_data['role_id'] = 1;
                        $user_data['project_id'] = Auth::guard('user')->user()->project_id;
                        $user_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                        $user_data['user_type'] = $request->user_type;
                        $user_data['company_sbu'] = $request->employee_sbu;
                        // $user_data['unit']=$request->unit;
                        $user_data['sub_unit'] = $request->employee_sub_unit;
                        $user_data['department'] = $request->employee_department;
                        $user_data['section'] = $request->employee_section;
                        $user_data['sub_section'] = $request->employee_sub_section;
                        // return response($user_data);
                        DB::table('users_person')->insert($user_data);
                    }
                }
                // return response($save_data->id);
                $approval_infos = collect($request['approval_infos'])->where('ea_approve_by', '!=', '')->toArray();
                if ($approval_infos !== '') {
                    $i = 0;
                    foreach ($approval_infos as $key => $value) {
                        $i++;
                        // return response($value);
                        $approval_data['ea_employee_id'] = $save_data->id;
                        $approval_data['ea_approval_lavel'] = $i;
                        $approval_data['ea_approve_by'] = $value['ea_approve_by'];
                        $approval_data['project_id'] = Auth::guard('user')->user()->project_id;
                        $approval_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                        $approval_data['created_by'] = Auth::guard('user')->user()->id;
                        DB::table('employee_approvals')->insert($approval_data);
                    }
                }
                $request['id'] = $save_data->id;
                $this->personalInfoStore($request);
                $message = ['status' => 1, 'message' => 'Your data is successfully saved', 'data' => $save_data];
            }
            DB::commit();
            return response($message);
        } catch (\Exception $exception) {
            DB::rollBack();
            $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
            return response($exception);
        }
    }

    public function employee_promotion(Request $request)
    {
        return response($request);
        $validate = [
            'effective_date' => 'required',
        ];
        $request->validate($validate);
        $data = $request->only(
            'employee_id',
            'employee_sbu',
            'employee_department',
            'employee_designation',
            'employee_job_grade',
            'employee_reporting_to',
            'employee_work_location',
            'employee_section',
            'employee_sub_section',
            'employee_unit',
            'employee_sub_unit',
            'employee_type',
            'employee_group',
        );

        if ($request['effective_date']) {
            $request_data['effective_date'] = date('Y-m-d', strtotime($request['effective_date']));
        }
        try {
            DB::beginTransaction();
            if (!empty($request->id)) {
                $update_data = Employee::valid()->project()->findOrFail($request->id);
                $data['updated_by'] = Auth::guard('user')->user()->id;
                $data['updated_at'] = date('Y-m-d');
                $data['desk_phone_no'] = $request['desk_phone_no'];
                $save_data = $update_data->update($data);
                $data['employee_id'] = $update_data->id;
                $data['previous_salary'] = $request['totalSalary'];
                $data['new_salary'] = $request['new_salary'];
                $data['increment_amount'] = $request['total_increment'];
                $data['one_off_bonus'] = $request['one_off_bonus'];
                $data['remarks'] = $request['remarks'];
                $data['effective_date'] = $request['effective_date'];
                $data['project_id'] = Auth::guard('user')->user()->project_id;
                $data['branch_id'] = Auth::guard('user')->user()->branch_id;
                $data['created_by'] = Auth::guard('user')->user()->id;
                $data['created_at'] = date('Y-m-d');
                $data['history_status'] = 1;
                $data['pi_first_date'] = isset($update_data['employee_joining_date']) ? $update_data['employee_joining_date'] : '';
                $data['pi_last_date'] = $request['effective_date'];
                $save_data = EmployeeHistory::create($data);
                if ($request['car_allowance_status'] == 1) {
                    $car_allowance_amount = $request['car_allowance_amount'];
                } else {
                    $car_allowance_amount = 0;
                }
                $increment_data['employee_id'] = $update_data->id;
                $increment_data['gross_salary'] = $request['total_increment'];
                $increment_data['basic_salary'] = $request['total_increment'] * 0.60;
                $increment_data['housing_allowance'] = $request['total_increment'] * 0.30;
                $increment_data['medical_allowance'] = $request['total_increment'] * 0.05;
                $increment_data['conveyance_allowance'] = $request['total_increment'] * 0.05;
                $increment_data['type'] = 2;
                $increment_data['increment_type'] = 1;
                $increment_data['salary_status'] = 1;
                $increment_data['salary_on_gross_basic'] = 2;
                $increment_data['company_sbu_id'] = $request['employee_sbu'];
                $increment_data['salary_sbu_id'] = $request['employee_sbu'];
                $increment_data['confirmation_date'] = $request['effective_date'];
                $increment_data['entry_date'] = date('Y-m-d');
                $increment_data['salary_goes_to'] = $request['salary_goes_to'];
                $increment_data['car_allowance_status'] = $request['car_allowance_status'] ?? 0;
                $increment_data['project_id'] = Auth::guard('user')->user()->project_id;
                $increment_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                $increment_data['car_allowance_amount'] = isset($car_allowance_amount) ? $car_allowance_amount : 0;
                $salary_increment = Salary::create($increment_data);
                $message = ['status' => 1, 'message' => 'Data Successfully Saved!'];
            }
            DB::commit();
            return response($message);
        } catch (\Exception $exception) {
            DB::rollBack();
            $message = ['status' => 0, 'message' => 'Opps! Something went worng.'];
            return response($exception);
        }
    }

    public function promotion_increment_info($id)
    {

        // $employee_list = new Employee();
        // $employee_ids = $employee_list->Employee_id();
        // $employee_id = $employee_ids['employee_id'];
        $data = Employee::valid()->project()->findOrFail($id);
        $data['user_employee_data'] = Employee::valid()->project()
            ->leftJoin('employees as emp', 'employees.employee_reporting_to', '=', 'emp.employee_id_no')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('sub_sections', 'sub_sections.id', '=', 'employees.employee_sub_section')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
            ->leftJoin('employee_groups', 'employee_groups.id', '=', 'employees.employee_group')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')

            //   designation_name
            ->select(
                'employees.*',
                'emp.employee_fullname as repotingTonname',
                'company_sbus.sbu_name',
                'sections.section_name',
                'sub_sections.sub_section_name',
                'departments.department_name',
                'designations.designation_name',
                'sub_units.sub_unit_name',
                'work_locations.work_location_name',
                'employee_personal_infos.employee_gender',
                'job_grades.jobgrade_name',
                'employee_groups.employee_group_name',
                'designations.priority as desPriority',
                'job_grades.priority as jobGPriority',
                'employee_groups.priority as empgrPriority',
        )
            ->where('employees.employee_status', 1)->where('employees.id', $id)->first();

        $companysbu_data_list = CompanySbu::valid()->project()
            // ->whereIn('id', $employee_ids['sub'])
            ->get()->keyBy('id')->all();
        $section_data_list = Section::valid()->project()->orderBy('section_name', 'ASC')->get()->keyBy('id')->all();
        $sub_section_data_list = SubSection::valid()->project()->orderBy('sub_section_name',
            'ASC')->get()->keyBy('id')->all();
        $employee_group_data_list = EmployeeGroup::valid()->project()
            // ->where('priority','<=',$data['user_employee_data']->empgrPriority)
            ->orderBy('employee_group_name', 'ASC')->get()->keyBy('id')->all();
        $department_list = Department::valid()->project()->orderBy('department_name', 'ASC')->get()->keyBy('id')->all();
        $designation_data_list = Designation::valid()->project()
            // ->where('priority','<=',$data['user_employee_data']->desPriority)
            ->orderBy('designation_name', 'ASC')->get()->keyBy('id')->all();
        $jobgrade_data_list = JobGrade::valid()->project()
            // ->where('priority','<=',$data['user_employee_data']->jobGPriority)
            ->orderBy('jobgrade_name', 'ASC')->get()->keyBy('id')->all();
        $employee_data_list = Employee::valid()->project()
            // ->whereIn('employee_sbu', $employee_ids['sub'])
            // ->whereIn('employee_department', $employee_ids['department'])
            ->get()->keyBy('id')->all();
        $employee_reporting = Employee::valid()->project()
            // ->whereIn('employee_sbu', $employee_ids['sub'])
            // ->whereIn('employee_department', $employee_ids['department'])
            ->get()->keyBy('employee_id_no')->all();
        $sub_unit_data_list = SubUnit::valid()->project()->orderBy('sub_unit_name', 'ASC')->get()->keyBy('id')->all();
        $unit_data_list = UnitModel::valid()->project()->orderBy('unit_name', 'ASC')->get()->keyBy('id')->all();
        $work_location_data_list = WorkLocation::valid()->project()->orderBy('work_location_name',
            'ASC')->get()->keyBy('id')->all();
        if (!$data->employee_sbu) {
            $data->sbu_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->sbu_name_value = [
                'id' => $data->employee_sbu, 'text' => $companysbu_data_list[$data->employee_sbu]->sbu_name
            ];
        }
        if (!$data->employee_section) {
            $data->section_value = ['id' => '', 'text' => ''];
        } else {
            $data->section_value = [
                'id' => $data->employee_section, 'text' => $section_data_list[$data->employee_section]->section_name
            ];
        }
        if (!$data->employee_sub_section) {
            $data->sub_section_value = ['id' => '', 'text' => ''];
        } else {
            $data->sub_section_value = [
                'id' => $data->employee_sub_section,
                'text' => $sub_section_data_list[$data->employee_sub_section]->sub_section_name
            ];
        }
        if (!$data->employee_group) {
            $data->employee_group_value = ['id' => '', 'text' => ''];
        } else {
            $data->employee_group_value = [
                'id' => $data->employee_group,
                'text' => $employee_group_data_list[$data->employee_group]->employee_group_name
            ];
        }
        if (!$data->employee_department) {
            $data->department_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->department_name_value = [
                'id' => $data->employee_department,
                'text' => $department_list[$data->employee_department]->department_name
            ];
        }
        if (!$data->employee_designation) {
            $data->designation_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->designation_name_value = [
                'id' => $data->employee_designation,
                'text' => $designation_data_list[$data->employee_designation]->designation_name
            ];
        }
        if (!$data->employee_job_grade) {
            $data->jobgrade_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->jobgrade_name_value = [
                'id' => $data->employee_job_grade,
                'text' => $jobgrade_data_list[$data->employee_job_grade]->jobgrade_name
            ];
        }
        if (!$data->employee_reporting_to) {
            $data->employee_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->employee_name_value = [
                'id' => $data->employee_reporting_to,
                'text' => $data->employee_reporting_to.' - '.$employee_reporting[$data->employee_reporting_to]->employee_fullname
            ];
        }
        if (!$data->employee_sub_unit) {
            $data->sub_unit_value = ['id' => '', 'text' => ''];
        } else {
            $data->sub_unit_value = [
                'id' => $data->employee_sub_unit, 'text' => $sub_unit_data_list[$data->employee_sub_unit]->sub_unit_name
            ];
        }
        if (!$data->employee_unit) {
            $data->unit_value = ['id' => '', 'text' => ''];
        } else {
            $data->unit_value = [
                'id' => $data->employee_unit, 'text' => $unit_data_list[$data->employee_unit]->unit_name
            ];
        }
        if (!$data->employee_work_location) {
            $data->work_location_value = ['id' => '', 'text' => ''];
        } else {
            $data->work_location_value = [
                'id' => $data->employee_work_location,
                'text' => $work_location_data_list[$data->employee_work_location]->work_location_name
            ];
        }
        $company_sbu_data = array();
        $section_data = array();
        $sub_section_data = array();
        $employee_group_data = array();
        $department_data = array();
        $designation_data = array();
        $jobgrade_data = array();
        $employee_data = array();
        $unit_data = array();
        $sub_unit_data = array();
        $work_location_data = array();
        array_push($company_sbu_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($companysbu_data_list as $value) {
            array_push($company_sbu_data, ['id' => $value['id'], 'text' => $value['sbu_name']]);
        }
        array_push($section_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($section_data_list as $value) {
            array_push($section_data, ['id' => $value['id'], 'text' => $value['section_name']]);
        }
        array_push($sub_section_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($sub_section_data_list as $value) {
            array_push($sub_section_data, ['id' => $value['id'], 'text' => $value['sub_section_name']]);
        }
        array_push($employee_group_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($employee_group_data_list as $value) {
            array_push($employee_group_data, ['id' => $value['id'], 'text' => $value['employee_group_name']]);
        }
        array_push($department_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($department_list as $value) {
            array_push($department_data, ['id' => $value['id'], 'text' => $value['department_name']]);
        }
        array_push($designation_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($designation_data_list as $value) {
            array_push($designation_data, ['id' => $value['id'], 'text' => $value['designation_name']]);
        }
        array_push($jobgrade_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($jobgrade_data_list as $value) {
            array_push($jobgrade_data, ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        }
        array_push($employee_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($employee_data_list as $value) {
            array_push($employee_data, [
                'id' => $value['employee_id_no'], 'employeeNo' => $value['id'],
                'text' => $value['employee_id_no'].' - '.$value['employee_fullname']
            ]);
        }
        array_push($sub_unit_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($sub_unit_data_list as $value) {
            array_push($sub_unit_data, ['id' => $value['id'], 'text' => $value['sub_unit_name']]);
        }
        array_push($unit_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($unit_data_list as $value) {
            array_push($unit_data, ['id' => $value['id'], 'text' => $value['unit_name']]);
        }
        array_push($work_location_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($work_location_data_list as $value) {
            array_push($work_location_data, ['id' => $value['id'], 'text' => $value['work_location_name']]);
        }
        $data->company_sbu_data = $company_sbu_data;
        $data->section_data = $section_data;
        $data->sub_section_data = $sub_section_data;
        $data->employee_group_data = $employee_group_data;
        $data->department_data = $department_data;
        $data->designation_data = $designation_data;
        $data->jobgrade_data = $jobgrade_data;
        $data->employee_data = $employee_data;
        $data->sub_unit_data = $sub_unit_data;
        $data->unit_data = $unit_data;
        $data->work_location_data = $work_location_data;

        $emp_salary = Salary::valid()->project()
            ->selectRaw(
                'salaries.*,
            sum(gross_salary) as gross_salary,
            sum(provident_fund_amount) as pf,
            sum(car_allowance_amount) as car_allowance_amount,
            sum(others_allowance) as others_allowance,
            sum(conveyance_allowance) as conveyance_allowance
            '
            )
            // ->where('confirmation_date', '<=', date('Y-m-d'))
            ->where('employee_id', $id)
            ->groupBy('employee_id')
            ->get();
        $salary_goes_to = Salary::valid()->project()
            ->select(
                'salary_goes_to'
            )
            ->where('employee_id', $id)
            ->where('type', 1)
            ->get();
        $salary_goes_count = count($salary_goes_to);

        if ($salary_goes_count == 1 && $salary_goes_to[0]['salary_goes_to'] == 1) {
            $data['salary_goes_to'] = 1;
            $data['salary_goes_to1'] = 'Cash';
        } elseif ($salary_goes_count == 2 && $salary_goes_to[0]['salary_goes_to'] == 1) {
            $data['salary_goes_to'] = 2;
            $data['salary_goes_to1'] = 'Bank';
        } else {
            $data['salary_goes_to'] = 2;
            $data['salary_goes_to1'] = 'Bank';
        }

        $data['salary_goes_info'] = $salary_goes_to;
        $data['emp_salary'] = $emp_salary;
        $gross_salary = collect($emp_salary)->sum('gross_salary');
        $car_allowance_amount = collect($emp_salary)->sum('car_allowance_amount');
        $others_allowance = collect($emp_salary)->sum('others_allowance');
        $pf = collect($emp_salary)->sum('pf');
        $data['totalSalary'] = number_format((($gross_salary + $car_allowance_amount + $others_allowance)), 2);
        $data['totalSalary_int'] = $gross_salary + $car_allowance_amount + $others_allowance;
        $one_off_bonus = EmployeeHistory::valid()->project()
            ->select('one_off_bonus', 'effective_date', 'remarks')
            ->whereDate('effective_date', '<=', date('Y-m-d'))
            ->where('employee_id', $id)
            ->OrderBy('id', 'desc')
            ->first();
        $carAllowace = collect($emp_salary)->where('car_allowance_amount', '!=', 0)->first();
        if ($carAllowace) {
            $data['car_allowance_status'] = 1;
            $data['car_allowance_amount'] = $car_allowance_amount;
            $data['car_allowance_status1'] = 1;

        } else {
            $data['car_allowance_status'] = 0;
            $data['car_allowance_amount'] = 0;
            $data['car_allowance_status1'] = 2;

        }
        if ($one_off_bonus) {
            $effective_date = $one_off_bonus->effective_date;
        } else {
            $effective_date = $data['user_employee_data']->employee_joining_date;
        }
        $data['remarks'] = $one_off_bonus->remarks ?? '';
        $data['effective_date1'] = date('d M Y', strtotime($effective_date));
        $data['effective_date'] = date('Y-m-d');
        $data['new_salary'] = $data['totalSalary_int'];
        $data['total_increment'] = 0;
        // form_data.effective_date
        $data['one_off_bonus'] = isset($one_off_bonus->one_off_bonus) ? $one_off_bonus->one_off_bonus : 0;
        $data['one_off_bonus1'] = isset($one_off_bonus->one_off_bonus) ? $one_off_bonus->one_off_bonus : 0;
        return response($data);
    }

    public function make_attendance_office_time(
        $employee_id = false,
        $joining_date = false,
        $office_time = false,
        $type = false
    ) {
        $data['employee_id'] = $employee_id;
        $data['attendance_type'] = 1;
        $data['attendance_category'] = 1;
        $data['attendance_machine_no'] = 4;
        $data['attendance_office_time'] = $office_time;
        $data['attendance_setup_status'] = 1;
        $data['start_date'] = $joining_date;
        $newEndingDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($joining_date))." + 1 year"));

        $data['end_date'] = $newEndingDate;
        if ($type != 1) {
            $update_data = AttendanceSetup::valid()->project()->findOrFail($employee_id);
            $data['updated_by'] = Auth::guard('user')->user()->id;
            $save_data = $update_data->update($data);
            // $message=['status' => 1, 'message' => 'Your data is successfully updated'];
        } else {
            $data['project_id'] = Auth::guard('user')->user()->project_id;
            $data['branch_id'] = Auth::guard('user')->user()->branch_id;
            $data['created_by'] = Auth::guard('user')->user()->id;
            $save_data = AttendanceSetup::create($data);
            // $message=['status' => 1, 'message' => 'Your data is successfully saved'];
        }
    }

    public function store_Emp_info(Request $request)
    {
        $validate = [
            'employee_fullname' => 'required',
            'employee_id_no' => 'required|unique:employees,employee_id_no,'.$request->id,
        ];
        $request->validate($validate);
        $data = $request->only(
            'employee_id_no',
            'employee_fullname',
            'employee_sbu',
            'employee_department',
            'employee_designation',
            'employee_job_grade',
            'employee_mobile',
            'employee_reporting_to',
            'employee_machine_id',
            'employee_leave_group',
            'employee_work_location',
            'employee_remarks',
            'employee_section',
            'employee_sub_unit',
            'employee_interview_date',
            'employee_appoinment_date',
            'employee_type',
            'employee_sub_section',
            'emplyee_category_mgt_non_mgt',
            'employee_group',
            'official_mobile_no',
            'official_email_id',
            'desk_phone_no',
            'employee_unit',
            'employee_number'
        );
        if ($request->employee_status == false) {
            $data['employee_status'] = 0;
            $employee_status = 0;
        } else {
            $data['employee_status'] = 1;
            $employee_status = 1;
        }


        if ($request->employee_image) {
            $image = $request->employee_image;
        } else {
            $image = '';
        }
        if (!empty($image)) {
            $exploded = explode(',', $image);
            if (strlen($request->employee_image) >= 800) {
                $decoded = base64_decode($exploded[1]);
                $exploded1 = explode(';', $exploded[0]);
                $exploded2 = explode('/', $exploded1[0]);
                if (str_contains($exploded2[1], 'jpeg')) {
                    $str_contains = 'jpeg';
                } else {
                    $str_contains = 'png';
                }
                $fileName = str_random().'.'.$str_contains;

                $path = public_path().'/images/'.$fileName;
                file_put_contents($path, $decoded);
                $data['employee_image'] = $fileName;
            }
        } else {
            $data['employee_image'] = '';
        }
        if ($request['employee_joining_date']) {
            $data['employee_joining_date'] = date('Y-m-d', strtotime($request['employee_joining_date']));
        }
        // return response($request->make_user);
        try {
            DB::beginTransaction();
            if (!empty($request->id)) {
                if ($request->make_user == 1) {
                    $user = DB::table('users_person')->where('employee_card_no', '=',
                        $request->employee_id_no)->first();
                    // return response($user);
                    if (empty($user)) {
                        $user_data['employee_card_no'] = $request->employee_id_no;
                        $user_data['name'] = $request->employee_fullname;
                        $user_data['employee_id'] = $request->id;
                        $user_data['company_id'] = $request->company_id;
                        $user_data['password'] = Hash::make('123456');
                        $user_data['status'] = 1;
                        $user_data['role_id'] = 1;
                        $user_data['project_id'] = Auth::guard('user')->user()->project_id;
                        $user_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                        $user_data['user_type'] = $request->user_type;
                        $user_data['company_sbu'] = $request->employee_sbu;
                        $user_data['unit'] = $request->employee_unit;
                        $user_data['sub_unit'] = $request->employee_sub_unit;
                        $user_data['department'] = $request->employee_department;
                        $user_data['section'] = $request->employee_section;
                        $user_data['sub_section'] = $request->employee_sub_section;
                        DB::table('users_person')->insert($user_data);
                    } else {
                        $user_data['employee_card_no'] = $request->employee_id_no;
                        $user_data['name'] = $request->employee_fullname;
                        $user_data['employee_id'] = $request->id;
                        $user_data['company_id'] = $request->company_id;
                        // $user_data['password']= Hash::make('123456');
                        $user_data['status'] = 1;
                        // $user_data['role_id']=1;
                        $user_data['project_id'] = Auth::guard('user')->user()->project_id;
                        $user_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                        $user_data['user_type'] = $request->user_type;
                        $user_data['company_sbu'] = $request->employee_sbu;
                        $user_data['unit'] = $request->employee_unit;
                        $user_data['sub_unit'] = $request->employee_sub_unit;
                        $user_data['department'] = $request->employee_department;
                        $user_data['section'] = $request->employee_section;
                        $user_data['sub_section'] = $request->employee_sub_section;
                        DB::table('users_person')->where('employee_card_no', '=',
                            $request->employee_id_no)->update($user_data);
                    }
                }

                $update_data = Employee::valid()->project()->findOrFail($request->id);
                $data['updated_by'] = Auth::guard('user')->user()->id;
                $data['employee_status'] = $employee_status;
                $save_data = $update_data->update($data);
                $approval_infos = collect($request['approval_infos'])->where('ea_approve_by', '!=', '')->toArray();
                if ($approval_infos !== '') {
                    DB::table('employee_approvals')->where('ea_employee_id', '=', $request->id)->delete();
                    $i = 0;
                    foreach ($approval_infos as $key => $value) {
                        $i++;
                        $approval_data['ea_employee_id'] = $request->id;
                        $approval_data['ea_approval_lavel'] = $i;
                        $approval_data['ea_approve_by'] = $value['ea_approve_by'];
                        $approval_data['project_id'] = Auth::guard('user')->user()->project_id;
                        $approval_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                        $approval_data['created_by'] = Auth::guard('user')->user()->id;
                        DB::table('employee_approvals')->insert($approval_data);
                    }
                }

                $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
            } else {
                $data['project_id'] = Auth::guard('user')->user()->project_id;
                $data['branch_id'] = Auth::guard('user')->user()->branch_id;
                $data['created_by'] = Auth::guard('user')->user()->id;
                $save_data = Employee::create($data);

                /* User creation when employee entry */
                if ($request->make_user == 1) {
                    $user = DB::table('users_person')->where('employee_card_no', $request->employee_id_no)->first();
                    if (empty($user)) {
                        $user_data['employee_card_no'] = $save_data->employee_id_no;
                        $user_data['name'] = $request->employee_fullname;
                        $user_data['employee_id'] = $save_data->id;
                        $user_data['company_id'] = $request->company_id;
                        $user_data['password'] = Hash::make('123456');
                        $user_data['status'] = 1;
                        $user_data['role_id'] = 1;
                        $user_data['project_id'] = Auth::guard('user')->user()->project_id;
                        $user_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                        $user_data['user_type'] = $request->user_type;
                        $user_data['company_sbu'] = $request->employee_sbu;
                        // $user_data['unit']=$request->unit;
                        $user_data['sub_unit'] = $request->employee_sub_unit;
                        $user_data['department'] = $request->employee_department;
                        $user_data['section'] = $request->employee_section;
                        $user_data['sub_section'] = $request->employee_sub_section;
                        // return response($user_data);
                        DB::table('users_person')->insert($user_data);
                    }
                }

                // return response($save_data->id);

                $approval_infos = collect($request['approval_infos'])->where('ea_approve_by', '!=', '')->toArray();
                if ($approval_infos !== '') {
                    $i = 0;
                    foreach ($approval_infos as $key => $value) {
                        $i++;
                        // return response($value);
                        $approval_data['ea_employee_id'] = $save_data->id;
                        $approval_data['ea_approval_lavel'] = $i;
                        $approval_data['ea_approve_by'] = $value['ea_approve_by'];
                        $approval_data['project_id'] = Auth::guard('user')->user()->project_id;
                        $approval_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                        $approval_data['created_by'] = Auth::guard('user')->user()->id;
                        DB::table('employee_approvals')->insert($approval_data);
                    }
                }

                $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
            }
            DB::commit();
            return response($message);
        } catch (\Exception $exception) {
            DB::rollBack();
            $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
            return response($exception);
        }
    }

    public function edit($id)
    {
        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];

        $data = Employee::valid()->project()->findOrFail($id);

        $companysbu_data_list = CompanySbu::valid()->project()->whereIn('id',
            $employee_ids['sub'])->get()->keyBy('id')->all();
        // ->whereIn('id',$employee_ids['section'])
        $section_data_list = Section::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        // ->whereIn('id',$employee_ids['subsection'])
        $sub_section_data_list = SubSection::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $employee_group_data_list = EmployeeGroup::valid()->project()->orderBy('priority',
            'ASC')->get()->keyBy('id')->all();
        // ->whereIn('id',$employee_ids['department'])
        $department_list = Department::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();

        $designation_data_list = Designation::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $jobgrade_data_list = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $employee_data_list = Employee::valid()->project()->whereIn('employee_sbu',
            $employee_ids['sub'])->whereIn('employee_department',
            $employee_ids['department'])->get()->keyBy('id')->all();
        $employee_reporting = Employee::valid()->project()->whereIn('employee_sbu',
            $employee_ids['sub'])->whereIn('employee_department',
            $employee_ids['department'])->get()->keyBy('employee_id_no')->all();
        // ->whereIn('id',$employee_ids['subunit'])
        $sub_unit_data_list = SubUnit::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        // ->whereIn('id',$employee_ids['unit'])
        $unit_data_list = UnitModel::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $work_location_data_list = WorkLocation::valid()->project()->orderBy('priority',
            'ASC')->get()->keyBy('id')->all();
        $work_area_data_list = WorkArea::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $employee_data_approval = Employee::valid()->project()->whereIn('employee_sbu',
            $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->get();
        $make_user = UsersPersonModel::valid()->project()->where('employee_card_no', $data['employee_id_no'])->first();

        if (!empty($data->employee_sbu)) {
            $data['shift_time'] = $companysbu_data_list[$data->employee_sbu]->office_start_time.' - '.$companysbu_data_list[$data->employee_sbu]->office_end_time;
        } else {
            $data['shift_time'] = '';
        }

        $data['allEmployees'] = $employee_data_list;
        if (!empty($make_user)) {
            $data->make_user = 1;
            $type = $make_user['user_type'];
        } else {
            $data->make_user = 0;
        }

        if (!empty($make_user)) {
            $data->user_type = $make_user['user_type'];
        } else {
            $data->user_type = '';
        }


        $approvalInfos = EmployeeApproval::valid()->project()
            ->select('employee_approvals.*', 'employee_approvals.ea_approval_lavel as indexid',
                'employees.employee_id_no as employees_ids', 'employees.employee_fullname as ea_approve_by_name')
            ->join('employees', 'employee_approvals.ea_approve_by', '=', 'employees.id')
            ->where('ea_employee_id', $data['id'])->get();

        if (!empty($approvalInfos)) {
            $data->approval_infos = $approvalInfos;
        } else {
            $data->approval_infos = [
                '0' => [
                    'id' => 0, 'ea_approve_by' => '', 'employees_ids' => '', 'ea_approve_by_name' => ''
                ]
            ];
        }
        $office_time_data_list = OfficeTimeSetup::valid()->project()->where('type', 1)->get();

        if (!$data->employee_sbu) {
            $data->sbu_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->sbu_name_value = [
                'id' => $data->employee_sbu, 'text' => $companysbu_data_list[$data->employee_sbu]->sbu_name
            ];
        }
        if (!$data->employee_section) {
            $data->section_value = ['id' => '', 'text' => ''];
        } else {
            $data->section_value = [
                'id' => $data->employee_section, 'text' => $section_data_list[$data->employee_section]->section_name
            ];
        }
        if (!$data->employee_sub_section) {
            $data->sub_section_value = ['id' => '', 'text' => ''];
        } else {
            $data->sub_section_value = [
                'id' => $data->employee_sub_section,
                'text' => $sub_section_data_list[$data->employee_sub_section]->sub_section_name
            ];
        }
        if (!$data->employee_group) {
            $data->employee_group_value = ['id' => '', 'text' => ''];
        } else {
            $data->employee_group_value = [
                'id' => $data->employee_group,
                'text' => $employee_group_data_list[$data->employee_group]->employee_group_name
            ];
        }
        if (!$data->employee_department) {
            $data->department_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->department_name_value = [
                'id' => $data->employee_department,
                'text' => $department_list[$data->employee_department]->department_name
            ];
        }
        if (!$data->employee_designation) {
            $data->designation_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->designation_name_value = [
                'id' => $data->employee_designation,
                'text' => $designation_data_list[$data->employee_designation]->designation_name
            ];
        }
        if (!$data->employee_job_grade) {
            $data->jobgrade_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->jobgrade_name_value = [
                'id' => $data->employee_job_grade,
                'text' => $jobgrade_data_list[$data->employee_job_grade]->jobgrade_name
            ];
        }
        if (!$data->employee_reporting_to) {
            $data->employee_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->employee_name_value = [
                'id' => $data->employee_reporting_to,
                'text' => $data->employee_reporting_to.' - '.$employee_reporting[$data->employee_reporting_to]->employee_fullname
            ];
        }
        if (!$data->employee_sub_unit) {
            $data->sub_unit_value = ['id' => '', 'text' => ''];
        } else {
            $data->sub_unit_value = [
                'id' => $data->employee_sub_unit, 'text' => $sub_unit_data_list[$data->employee_sub_unit]->sub_unit_name
            ];
        }
        if (!$data->employee_unit) {
            $data->unit_value = ['id' => '', 'text' => ''];
        } else {
            $data->unit_value = [
                'id' => $data->employee_unit, 'text' => $unit_data_list[$data->employee_unit]->unit_name
            ];
        }
        if (!$data->employee_work_location) {
            $data->work_location_value = ['id' => '', 'text' => ''];
        } else {
            $data->work_location_value = [
                'id' => $data->employee_work_location,
                'text' => $work_location_data_list[$data->employee_work_location]->work_location_name
            ];
        }
        if (!$data->work_area) {
            $data->work_location_value = ['id' => '', 'text' => ''];
        } else {
            $data->work_location_value = [
                'id' => $data->work_area, 'text' => $work_area_data_list[$data->work_area]->work_location_name
            ];
        }
        // return response($data);
        $company_sbu_data = array();
        $section_data = array();
        $sub_section_data = array();
        $employee_group_data = array();
        $department_data = array();
        $designation_data = array();
        $jobgrade_data = array();
        $employee_data = array();
        $employee_data_approval = array();
        $unit_data = array();
        $sub_unit_data = array();
        $work_location_data = array();
        $work_area_data = array();
        $office_time_data = array();
        array_push($company_sbu_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($companysbu_data_list as $value) {
            array_push($company_sbu_data, ['id' => $value['id'], 'text' => $value['sbu_name']]);
        }
        array_push($section_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($section_data_list as $value) {
            array_push($section_data, ['id' => $value['id'], 'text' => $value['section_name']]);
        }
        array_push($sub_section_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($sub_section_data_list as $value) {
            array_push($sub_section_data, ['id' => $value['id'], 'text' => $value['sub_section_name']]);
        }
        array_push($employee_group_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($employee_group_data_list as $value) {
            array_push($employee_group_data, ['id' => $value['id'], 'text' => $value['employee_group_name']]);
        }
        array_push($department_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($department_list as $value) {
            array_push($department_data, ['id' => $value['id'], 'text' => $value['department_name']]);
        }
        array_push($designation_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($designation_data_list as $value) {
            array_push($designation_data, ['id' => $value['id'], 'text' => $value['designation_name']]);
        }
        array_push($jobgrade_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($jobgrade_data_list as $value) {
            array_push($jobgrade_data, ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        }
        array_push($employee_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($employee_data_list as $value) {
            array_push($employee_data, [
                'id' => $value['employee_id_no'], 'employeeNo' => $value['id'],
                'text' => $value['employee_id_no'].' - '.$value['employee_fullname']
            ]);
        }
        array_push($sub_unit_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($sub_unit_data_list as $value) {
            array_push($sub_unit_data, ['id' => $value['id'], 'text' => $value['sub_unit_name']]);
        }
        array_push($unit_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($unit_data_list as $value) {
            array_push($unit_data, ['id' => $value['id'], 'text' => $value['unit_name']]);
        }
        array_push($work_location_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($work_location_data_list as $value) {
            array_push($work_location_data, ['id' => $value['id'], 'text' => $value['work_location_name']]);
        }
        array_push($work_area_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($work_area_data_list as $value) {
            array_push($work_area_data, ['id' => $value['id'], 'text' => $value['work_area_name']]);
        }
        array_push($employee_data_approval, ['id' => '', 'text' => 'Deselect']);
        foreach ($employee_data_list as $value) {
            array_push($employee_data_approval, [
                'id' => $value['id'], 'employee_name' => $value['employee_fullname'],
                'employee_ids' => $value['employee_id_no'],
                'text' => $value['employee_id_no'].' : '.$value['employee_fullname']
            ]);
        }
        array_push($office_time_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($office_time_data_list as $value) {
            array_push($office_time_data,
                ['id' => $value['id'], 'text' => $value['office_start_time'].' - '.$value['office_end_time']]);
        }

        $data->company_sbu_data = $company_sbu_data;
        $data->section_data = $section_data;
        $data->sub_section_data = $sub_section_data;
        $data->employee_group_data = $employee_group_data;
        $data->department_data = $department_data;
        $data->designation_data = $designation_data;
        $data->jobgrade_data = $jobgrade_data;
        $data->employee_data = $employee_data;
        $data->employee_data_approval = $employee_data_approval;
        $data->sub_unit_data = $sub_unit_data;
        $data->unit_data = $unit_data;
        $data->work_location_data = $work_location_data;
        $data->work_area_data = $work_area_data;
        $data->office_time_data = $office_time_data;
        $data->role_id = Auth::guard('user')->user()->user_type;

        $data['user_employee_data'] = Employee::valid()->project()
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('sub_sections', 'sub_sections.id', '=', 'employees.employee_sub_section')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->select(
                'employees.*',
                'company_sbus.sbu_name',
                'sections.section_name',
                'sub_sections.sub_section_name',
                'departments.department_name',
                'designations.designation_name',
                'sub_units.sub_unit_name',
                'work_locations.work_location_name',
                'employee_personal_infos.employee_gender'
            )
            ->where('employee_status', 1)->where('employees.id', $id)->first();
        $personal_data = EmployeePersonalInfo::where('employee_id', '=', $id)->first();
        if (!empty($personal_data)) {
            $data->employee_father_name = $personal_data['employee_father_name'];
            $data->employee_mother_name = $personal_data['employee_mother_name'];
            $data->employee_marital_status = $personal_data['employee_marital_status'];
            $data->employee_gender = $personal_data['employee_gender'];
            $data->employee_blood_group = $personal_data['employee_blood_group'];
            $data->employee_dob_certificate = $personal_data['employee_dob_certificate'];
            $data->employee_dob_actual = $personal_data['employee_dob_actual'];
            $data->employee_religion = $personal_data['employee_religion'];
        } else {
            $data->employee_father_name = '';
            $data->employee_mother_name = '';
            $data->employee_marital_status = '';
            $data->employee_gender = '';
            $data->employee_blood_group = '';
            $data->employee_dob_certificate = '';
            $data->employee_dob_actual = '';
            $data->employee_religion = '';
        }
        return response($data);
    }

    public function destroy($id)
    {
        $delete_data = Employee::valid()->project()->findOrFail($id);
        if ($delete_data->delete()) {
            DB::table('employee_approvals')->where('ea_employee_id', '=', $id)->delete();
            $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
        }
        return response($message);
    }

    public function moreinfo()
    {
        $data['company_sbu_data'] = array();
        $data['section_data'] = array();
        $data['sub_unit_data'] = array();
        $data['work_location_data'] = array();
        $data['department_data'] = array();
        $data['designation_data'] = array();
        $data['jobgrade_data'] = array();
        $data['employee_data'] = array();

        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        // $employee_id = $employee_ids['employee_id'];

        $company_sbu_data = CompanySbu::valid()->project()->whereIn('id', $employee_ids['sub'])->orderBy('priority',
            'ASC')->get();
        $section_data = Section::valid()->project()->whereIn('id', $employee_ids['section'])->orderBy('priority',
            'ASC')->get();
        $department_data = Department::valid()->project()->whereIn('id',
            $employee_ids['department'])->orderBy('priority', 'ASC')->get();
        $designation_data = Designation::valid()->project()->orderBy('priority', 'ASC')->get();
        $jobgrade_data = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();
        $employee_data = Employee::valid()->project()->whereIn('employee_sbu',
            $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->get();
        $sub_unit_data = SubUnit::valid()->project()->whereIn('id', $employee_ids['subunit'])->orderBy('priority',
            'ASC')->get();
        $work_location_data = WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get();

        foreach ($company_sbu_data as $value) {
            array_push($data['company_sbu_data'], ['id' => $value['id'], 'text' => $value['sbu_name']]);
        }
        foreach ($section_data as $value) {
            array_push($data['section_data'], ['id' => $value['id'], 'text' => $value['section_name']]);
        }
        foreach ($department_data as $value) {
            array_push($data['department_data'], ['id' => $value['id'], 'text' => $value['department_name']]);
        }
        foreach ($designation_data as $value) {
            array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
        }
        foreach ($jobgrade_data as $value) {
            array_push($data['jobgrade_data'], ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        }
        foreach ($employee_data as $value) {
            array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_fullname']]);
        }
        foreach ($sub_unit_data as $value) {
            array_push($data['sub_unit_data'], ['id' => $value['id'], 'text' => $value['sub_unit_name']]);
        }
        foreach ($work_location_data as $value) {
            array_push($data['work_location_data'], ['id' => $value['id'], 'text' => $value['work_location_name']]);
        }
        $data['present_district_data'] = array();
        $present_district_data = DistrictModel::orderBy('name', 'ASC')->get();
        foreach ($present_district_data as $value) {
            array_push($data['present_district_data'],
                ['id' => $value['id'], 'text' => $value['name'].' - '.$value['bn_name']]);
        }

        $data['permanent_thana_data'] = array();
        $permanent_thana_data = UpazilaModel::orderBy('name', 'ASC')->get();
        foreach ($permanent_thana_data as $value) {
            array_push($data['permanent_thana_data'],
                ['id' => $value['id'], 'text' => $value['name'].' - '.$value['bn_name']]);
        }

        $data['present_union_data'] = array();
        $present_union_data = UnionModel::orderBy('name', 'ASC')->get();
        foreach ($present_union_data as $value) {
            array_push($data['present_union_data'],
                ['id' => $value['id'], 'text' => $value['name'].' - '.$value['bn_name']]);
        }

        return response($data);
    }

    public function reporting_to_setup()
    {
        $data['company_sbu_data'] = array();
        $data['section_data'] = array();
        $data['sub_unit_data'] = array();
        $data['work_location_data'] = array();
        $data['department_data'] = array();
        $data['designation_data'] = array();
        $data['jobgrade_data'] = array();
        $data['employee_data'] = array();

        $data['employee_data_approval'] = array();

        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];

        $company_sbu_data = CompanySbu::valid()->project()->whereIn('id', $employee_ids['sub'])->orderBy('priority',
            'ASC')->get();
        $section_data = Section::valid()->project()->whereIn('id', $employee_ids['section'])->orderBy('priority',
            'ASC')->get();
        $department_data = Department::valid()->project()->whereIn('id',
            $employee_ids['department'])->orderBy('priority', 'ASC')->get();
        $designation_data = Designation::valid()->project()->orderBy('priority', 'ASC')->get();
        $jobgrade_data = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();
        $employee_data = Employee::valid()->project()->whereIn('employee_sbu',
            $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->get();
        $sub_unit_data = SubUnit::valid()->project()->whereIn('id', $employee_ids['subunit'])->orderBy('priority',
            'ASC')->get();
        $work_location_data = WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get();


        $employee_data_approval = Employee::valid()->project()->whereIn('employee_sbu',
            $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->where('employee_status',
            1)->get();

        foreach ($company_sbu_data as $value) {
            array_push($data['company_sbu_data'], ['id' => $value['id'], 'text' => $value['sbu_name']]);
        }
        foreach ($section_data as $value) {
            array_push($data['section_data'], ['id' => $value['id'], 'text' => $value['section_name']]);
        }
        foreach ($department_data as $value) {
            array_push($data['department_data'], ['id' => $value['id'], 'text' => $value['department_name']]);
        }
        foreach ($designation_data as $value) {
            array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
        }
        foreach ($jobgrade_data as $value) {
            array_push($data['jobgrade_data'], ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        }
        foreach ($employee_data as $value) {
            array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_fullname']]);
        }
        foreach ($sub_unit_data as $value) {
            array_push($data['sub_unit_data'], ['id' => $value['id'], 'text' => $value['sub_unit_name']]);
        }
        foreach ($work_location_data as $value) {
            array_push($data['work_location_data'], ['id' => $value['id'], 'text' => $value['work_location_name']]);
        }
        $data['present_district_data'] = array();
        $present_district_data = DistrictModel::orderBy('name', 'ASC')->get();
        foreach ($present_district_data as $value) {
            array_push($data['present_district_data'],
                ['id' => $value['id'], 'text' => $value['name'].' - '.$value['bn_name']]);
        }

        $data['permanent_thana_data'] = array();
        $permanent_thana_data = UpazilaModel::orderBy('name', 'ASC')->get();
        foreach ($permanent_thana_data as $value) {
            array_push($data['permanent_thana_data'],
                ['id' => $value['id'], 'text' => $value['name'].' - '.$value['bn_name']]);
        }


        $data['present_union_data'] = array();
        $present_union_data = UnionModel::orderBy('name', 'ASC')->get();
        foreach ($present_union_data as $value) {
            array_push($data['present_union_data'],
                ['id' => $value['id'], 'text' => $value['name'].' - '.$value['bn_name']]);
        }

        return response($data);
    }

    public function profile()
    {
        //
    }

    public function profileDetails($id)
    {
        $data['employee_info'] = Employee::valid()->project()
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
            ->select(
                'employees.*',
                'company_sbus.sbu_name',
                'sections.section_name',
                'departments.department_name',
                'designations.designation_name',
                'sub_units.sub_unit_name',
                'work_locations.work_location_name',
                'job_grades.jobgrade_name'
            )->where('employees.id', $id)->first();
        $data['employee_joining_date'] = date("d F Y", strtotime($data['employee_info']->employee_joining_date));
        $date1 = $data['employee_info']->employee_joining_date;
        $service_length = '';
        if (!empty($date1)) {
            $Joining = new DateTime($date1); // Your date of birth
            $today = new Datetime(date('Y-m-d'));
            $diff = $today->diff($Joining);
            $service_length = $diff->y.' Years '.$diff->m.' Months '.$diff->d.' Days ';
        }
        $data['service_length'] = $service_length ?? '';
        $data['personal_infos'] = EmployeePersonalInfo::valid()->project()->where('employee_id', $id)->first();
        $employee_dob = isset($data['personal_infos']->employee_dob_actual) ? $data['personal_infos']->employee_dob_actual : '';
        if (empty($employee_dob) || $employee_dob == '0000-00-00') {
            $employee_dob = isset($data['personal_infos']->employee_dob_certificate) ? $data['personal_infos']->employee_dob_certificate : '';
            if ($employee_dob == 0 || $employee_dob == '0000-00-00') {
                $employee_dob = '';
            }
        }
        $employee_dob1 = strtotime($employee_dob);
        $data['employee_birthday'] = date("d F Y", strtotime($employee_dob));
        if ($employee_dob1) {
            $bday = new DateTime($employee_dob); // Your date of birth
            $today = new Datetime(date('Y-m-d'));
            $diff = $today->diff($bday);
            $birthDates = $diff->y.'.'.$diff->m;
            $birthDates1 = $diff->y;
        } else {
            $birthDates1 = 0;
        }
        $data['employee_age'] = (int) $birthDates1;
        $data['address_info'] = EmployeeAdressDetail::valid()->project()->where('ead_employee_id', $id)->first();
        if (!empty($data['address_info']->permanent_district)) {
            $data['permanent_district'] = DB::table('districts')->where('id',
                $data['address_info']->permanent_district)->first();
        } else {
            $data['permanent_district'] = '';
        }
        if (!empty($data['address_info']->present_thana)) {
            $data['present_thana'] = DB::table('unions')->where('id', $data['address_info']->present_thana)->first();
        } else {
            $data['present_thana'] = '';
        }
        $data['identification_supporting'] = EmployeeIdentificationSupporting::valid()->project()->where('eis_employee_id',
            $id)->first();
        $data['educational_infos'] = EmployeeEducationalQualification::valid()->project()->where('eeq_employee_id',
            $id)->get();
        $higherstEdu = collect($data['educational_infos'])->where('eeq_highest_education', 1)->first();
        if (!empty($higherstEdu)) {
            $data['highest_educstion'] = $higherstEdu['eeq_degree_name'];
        } else {
            $data['highest_educstion'] = 'No Data Found!';
        }
        $data['professional_infos'] = EmployeeProfessionalQualification::valid()->project()->where('pq_employee_id',
            $id)->get();
        $data['employment_history'] = EmployeeEmploymentHistory::valid()->project()->where('eeh_employee_id',
            $id)->get();
        $data['family_details'] = EmployeeFamilyDetail::valid()->project()->where('efd_employee_id', $id)->get();
        $data['training_records'] = EmployeeTrainingRecord::valid()->project()->where('etr_employee_id', $id)->get();
        $data['professinal_memberships'] = EmployeeProfessionalMembership::valid()->project()->where('epm_employee_id',
            $id)->get();
        $data['bank_accounts'] = EmployeeBankAccountDetail::valid()->project()->where('ebc_employee_id', $id)->get();
        $data['emergency_contacts'] = EmployeeEmergencyContact::valid()->project()->where('eec_employee_id',
            $id)->get();
        $data['others_contact_info'] = EmployeeOthersContact::valid()->project()->where('eoc_employee_id', $id)->get();
        $employee_salary = Salary::valid()->project()->where('employee_id', $id)->get();
        $data['employee_present_salary'] = collect($employee_salary)->sum('gross_salary');
        $data['one_off_bonus'] = $employee_salary[0]->one_off_bonus ?? '0.00';
        $data['last_promotion_date'] = $employee_salary[0]->last_promotion_date ?? '';

        return response($data);
    }

    public function moreinfoData($id)
    {
        $data = Employee::valid()->project()
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->leftJoin('employee_adress_details', 'employee_adress_details.ead_employee_id', '=', 'employees.id')
            ->leftJoin('employee_identification_supportings', 'employee_identification_supportings.eis_employee_id',
                '=', 'employees.id')
            ->leftJoin('employee_references', 'employee_references.er_employee_id', '=', 'employees.id')
            ->select(
                'employees.*',
                'employee_personal_infos.*',
                'employee_adress_details.*',
                'employee_identification_supportings.*',
                'employee_references.*',
                'employees.id as id',
                'employee_personal_infos.id as id1',
                'employee_adress_details.id as id2',
                'employee_identification_supportings.id as id3',
                'employee_references.id as id4',
                'employees.employee_mobile as employee_mobile'
            )->where('employees.id', $id)->first();

        if ($data) {
            $data->toArray();
            $make_user = UsersPersonModel::valid()->project()->where('employee_card_no',
                $data['employee_id_no'])->first();
            if (!empty($make_user)) {
                $data->make_user = 1;
                $type = $make_user['user_type'];
            } else {
                $data->make_user = 0;
            }

            if (!empty($make_user)) {
                $data->user_type = $make_user['user_type'];
            } else {
                $data->user_type = '';
            }
        }
        $educational_infos = EmployeeEducationalQualification::valid()->project()->where('eeq_employee_id', $id)->get();
        $professional_infos = EmployeeProfessionalQualification::valid()->project()->where('pq_employee_id',
            $id)->get();
        $employment_histories = EmployeeEmploymentHistory::valid()->project()->where('eeh_employee_id', $id)->get();
        $family_details = EmployeeFamilyDetail::valid()->project()->where('efd_employee_id', $id)->get();
        $training_records = EmployeeTrainingRecord::valid()->project()->where('etr_employee_id', $id)->get();
        $professinal_memberships = EmployeeProfessionalMembership::valid()->project()->where('epm_employee_id',
            $id)->get();
        $bank_accounts = EmployeeBankAccountDetail::valid()->project()->where('ebc_employee_id', $id)->get();
        $emergency_contacts = EmployeeEmergencyContact::valid()->project()->where('eec_employee_id', $id)->get();
        $others_contact_info = EmployeeOthersContact::valid()->project()->where('eoc_employee_id', $id)->get();
        $approvalInfos = EmployeeApproval::valid()->project()
            ->select('employee_approvals.*', 'employee_approvals.ea_approval_lavel as indexid',
                'employees.employee_id_no as employees_ids', 'employees.employee_fullname as ea_approve_by_name')
            ->join('employees', 'employee_approvals.ea_approve_by', '=', 'employees.id')
            ->where('ea_employee_id', $id)->get();

        if (count($approvalInfos) > 0) {
            // dd($approvalInfos);
            $data['approval_infos'] = $approvalInfos;
        } else {
            $data['approval_infos'] = [
                '0' => [
                    'id' => 0, 'ea_approve_by' => '', 'employees_ids' => '', 'ea_approve_by_name' => ''
                ]
            ];
        }
        if ($id == 0) {
            $data['employee_status'] = 1;
            $data['emplyee_category_mgt_non_mgt'] = 2;
            $data['employee_leave_group'] = 1;
            $data['employee_type'] = 2;
            $data['make_user'] = "";
            $data['user_type'] = 0;
        }


        if ($id != 0) {
            $salariy = DB::table('salaries')->where('employee_id', '=', $id)->first();
            if (!empty($salariy)) {
                $data['gross_salary_bangla'] = $salariy->gross_salary_bangla;
                $data['gross_salary_bangla_text'] = $salariy->gross_salary_bangla_text;
            } else {
                $data['gross_salary_bangla'] = 0;
                $data['gross_salary_bangla_text'] = '';
            }
        }

        // this.form_data.employee_status = "1";
        // this.form_data.emplyee_category_mgt_non_mgt = "2";
        // this.form_data.employee_leave_group = "1";
        // this.form_data.employee_type = "2";
        // this.form_data.make_user = "";
        // this.form_data.user_type = "0";
        // $designation_data_list=Designation::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();

        // if(!$data->employee_designation){
        //   $data->designation_name_value = ['id'=>'','text'=>''];
        // }else{
        //   $data->designation_name_value = ['id'=>$data->employee_designation,'text'=>$designation_data_list[$data->employee_designation]->designation_name];
        // }


        if (count($educational_infos) > 0) {
            $data['educational_infos'] = $educational_infos;
            // return response($data['educational_infos']);
        } else {
            $data['educational_infos'] = [
                '0' => [
                    'id' => 0, 'eeq_degree_name' => '', 'eeq_major_group' => '', 'eeq_major_group' => '',
                    'eeq_board_university' => '', 'eeq_session_from' => '', 'eeq_session_to' => '',
                    'eeq_passing_year' => '', 'eeq_division_gpa' => ''
                ]
            ];
        }
        if (count($professional_infos) > 0) {
            $data['professional_infos'] = $professional_infos;
        } else {
            $data['professional_infos'] = [
                '0' => [
                    'id' => 0, 'pq_course_title' => '', 'pq_institute_name' => '', 'pq_location' => '',
                    'pq_duration_from' => '', 'pq_duration_to' => '', 'pq_result' => ''
                ]
            ];
        }
        if (count($employment_histories) > 0) {
            $data['employment_histories'] = $employment_histories;
        } else {
            $data['employment_histories'] = [
                '0' => [
                    'id' => 0, 'eeh_job_title' => '', 'eeh_organization_name' => '', 'eeh_industry_type' => '',
                    'eeh_duration_from' => '', 'eeh_duration_to' => '', 'eeh_service_length' => ''
                ]
            ];
        }
        if (count($family_details) > 0) {
            $data['family_details'] = $family_details;
        } else {
            $data['family_details'] = [
                '0' => [
                    'id' => 0, 'efd_family_member_name' => '', 'efd_relationship' => '', 'efd_date_of_birth' => '',
                    'efd_occupation' => '', 'efd_contact_mobile_no' => ''
                ]
            ];
        }


        if ($id == 0) {
            $data['employee_blood_group'] = 'N/A';
            $rangeid = DB::table('employee_id_serial_start_list')->where('sbu_id',
                Auth::guard('user')->user()->company_sbu)->first();
            $employee_id_no = Employee::where('employee_id_no', '>=', $rangeid->start_code)->where('employee_id_no',
                '<=', $rangeid->end_code)->orderBy('employee_id_no', 'DESC')->first();
            if (!empty($employee_id_no)) {
                $employee_id_no = $employee_id_no['employee_id_no'];
                $employee_id_no = $employee_id_no + 1;
            } else {
                $employee_id_no = $rangeid['start_code'] + 1;
            }
            $data['employee_id_no'] = $employee_id_no;
        }

        // return response($data);

        $references_details = array();
        if (count($references_details) > 0) {
            $data['references_details'] = $references_details;
        } else {
            $data['references_details'] = [
                '0' => [
                    'er_name1' => '',
                    'er_relationship1' => '',
                    'er_occupation1' => '',
                    'er_designation_department1' => '',
                    'er_company_address1' => '',
                    'er_mobile_no1' => '',
                    'er_national_id1' => '',
                    'er_holding_no1' => '',
                    'er_road_no1' => '',
                    'er_house_name1' => '',
                    'er_road_name1' => '',
                    'er_ward_no1' => '',
                    'er_union_pouro_city1' => '',
                    'er_post_office1' => '',
                    'er_thana1' => '',
                    'er_district1' => ''
                ]
            ];
        }
        if (count($training_records) > 0) {
            $data['training_records'] = $training_records;
        } else {
            $data['training_records'] = [
                '0' => [
                    'id' => 0, 'etr_training_title' => '', 'etr_institute_name' => '', 'etr_duration_from' => '',
                    'etr_duration_to' => '', 'etr_sponsored_by' => '', 'etr_certificate_received' => ''
                ]
            ];
        }
        if (count($professinal_memberships) > 0) {
            $data['professinal_memberships'] = $professinal_memberships;
        } else {
            $data['professinal_memberships'] = [
                '0' => [
                    'id' => 0, 'epm_membership_title' => '', 'epm_organization_name' => '', 'epm_obtained_on' => '',
                    'epm_valid_upto' => ''
                ]
            ];
        }
        if (count($bank_accounts) > 0) {
            $data['bank_accounts'] = $bank_accounts;
        } else {
            $data['bank_accounts'] = [
                '0' => [
                    'id' => 0, 'ebc_bank_name' => '', 'ebc_branch_district' => '', 'ebc_ac_holder_name' => '',
                    'ebc_account_number' => ''
                ]
            ];
        }
        if (count($emergency_contacts) > 0) {
            $data['emergency_contacts'] = $emergency_contacts;
        } else {
            $data['emergency_contacts'] = [
                '0' => [
                    'id' => 0, 'eec_name' => '', 'eec_relationship' => '', 'eec_present_address' => '',
                    'eec_mobile_no' => ''
                ]
            ];
        }
        if (count($others_contact_info) > 0) {
            $data['others_contact_info'] = $others_contact_info;
        } else {
            $data['others_contact_info'] = [
                '0' => [
                    'id' => 0, 'eec_name' => '', 'eec_relationship' => '', 'eec_present_address' => '',
                    'eec_mobile_no' => ''
                ]
            ];
        }
        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];

        // ->whereIn('id', $employee_ids['sub'])
        $companysbu_data_list = CompanySbu::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        // ->whereIn('id', $employee_ids['section'])
        $section_data_list = Section::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        // ->whereIn('id', $employee_ids['department'])
        $department_list = Department::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $designation_data_list = Designation::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $jobgrade_data_list = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        // ->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])
        // ->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])
        $employee_data_list = Employee::valid()->project()->whereIn('employee_sbu',
            $employee_ids['sub'])->whereIn('employee_department',
            $employee_ids['department'])->get()->keyBy('id')->all();
        // ->whereIn('id', $employee_ids['subunit'])
        $sub_unit_data_list = SubUnit::valid()->project()->get()->keyBy('id')->all();
        $work_location_data_list = WorkLocation::valid()->project()->orderBy('priority',
            'ASC')->get()->keyBy('id')->all();
        $work_area_data_list = WorkArea::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        // ->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])
        // ->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])
        $employee_data_approval = Employee::valid()->project()->whereIn('employee_sbu',
            $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->where('employee_status',
            1)->get();

        $approvalInfos = EmployeeApproval::valid()->project()
            ->select('employee_approvals.*', 'employee_approvals.ea_approval_lavel as indexid',
                'employees.employee_id_no as employees_ids', 'employees.employee_fullname as ea_approve_by_name')
            ->join('employees', 'employee_approvals.ea_approve_by', '=', 'employees.id')
            ->where('ea_employee_id', $id)->get();

        if (!empty($approvalInfos)) {
            $data['approval_infos'] = $approvalInfos;
        } else {
            $data['approval_infos'] = [
                '0' => [
                    'id' => 0, 'ea_approve_by' => '', 'employees_ids' => '', 'ea_approve_by_name' => ''
                ]
            ];
        }
        if ($id == 0) {
            $emplyee = collect($employee_data_list)->where('id', Auth::guard('user')->user()->employee_id)->first();
            // return  $emplyee;
            $data['employee_salary_type'] = $emplyee['employee_salary_type'] ?? 1;
            $data['attendance_bonus_get'] = $emplyee['attendance_bonus_get'] ?? 1;
            $data['salary_duration_type'] = $emplyee['salary_duration_type'] ?? 1;
            $data['employee_due_month'] = 0;
            $data['employee_confirmation_due_date'] = date('Y-m-d');
        }

        if ($id != 0) {
            $data['employee_search_value'] = ['id' => $data['id'], 'text' => $data['employee_fullname']];
            if (!isset($data['employee_sbu']) || $data['employee_sbu'] == 0) {
                $data['sbu_name_value'] = ['id' => '', 'text' => ''];
            } else {
                $data['sbu_name_value'] = [
                    'id' => $data['employee_sbu'], 'text' => $companysbu_data_list[$data['employee_sbu']]->sbu_name
                ];
            }
        } else {
            $data['employee_sbu'] = Auth::guard('user')->user()->company_sbu;
            if (!isset(Auth::guard('user')->user()->company_sbu)) {
                $data['sbu_name_value'] = ['id' => '', 'text' => ''];
            } else {
                $data['sbu_name_value'] = [
                    'id' => Auth::guard('user')->user()->company_sbu,
                    'text' => $companysbu_data_list[Auth::guard('user')->user()->company_sbu]->sbu_name
                ];
            }
            $data['employee_search_value'] = ['id' => '', 'text' => ''];
        }


        if (!isset($data['employee_sbu']) || $data['employee_sbu'] == 0) {
            $data['sbu_name_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['sbu_name_value'] = [
                'id' => $data['employee_sbu'], 'text' => $companysbu_data_list[$data['employee_sbu']]->sbu_name
            ];
        }
        if ($id != 0) {
            if (!isset($data['employee_section']) || $data['employee_section'] == 0) {
                $data['section_value'] = ['id' => '', 'text' => ''];
            } else {
                $data['section_value'] = [
                    'id' => $data['employee_section'],
                    'text' => $section_data_list[$data['employee_section']]->section_name
                ];
            }
        } else {
            $data['employee_section'] = Auth::guard('user')->user()->section;
            if (!isset($data['employee_section']) || $data['employee_section'] == 0) {
                $data['section_value'] = ['id' => '', 'text' => ''];
            } else {
                $data['section_value'] = [
                    'id' => $data['employee_section'],
                    'text' => $section_data_list[$data['employee_section']]->section_name
                ];
            }
        }
        if (!isset($data['employee_department']) || $data['employee_department'] == 0) {
            $data['department_name_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['department_name_value'] = [
                'id' => $data['employee_department'],
                'text' => $department_list[$data['employee_department']]->department_name
            ];
        }
        if (!isset($data['employee_designation']) || $data['employee_designation'] == 0) {
            $data['designation_name_value'] = ['id' => '', 'text' => ''];
        } else {
            if (!empty($designation_data_list[$data['employee_designation']]->designation_name_bangla)) {
                $designationText = $designation_data_list[$data['employee_designation']]->designation_name.' - '.$designation_data_list[$data['employee_designation']]->designation_name_bangla;
            } else {
                $designationText = $designation_data_list[$data['employee_designation']]->designation_name;
            }
            $data['designation_name_value'] = ['id' => $data['employee_designation'], 'text' => $designationText];
        }
        if (!isset($data['employee_job_grade']) || $data['employee_job_grade'] == 0) {
            $data['jobgrade_name_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['jobgrade_name_value'] = [
                'id' => $data['employee_job_grade'],
                'text' => $jobgrade_data_list[$data['employee_job_grade']]->jobgrade_name
            ];
        }
        $employee_reporting = Employee::valid()->project()->get()->keyBy('employee_id_no')->all();
        // ->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])

        if ($id != 0) {
            if (!empty($employee_reporting[$data->employee_reporting_to])) {
                if (!$data->employee_reporting_to) {
                    $data->employee_name_value = ['id' => '', 'text' => ''];
                } else {
                    $data->employee_name_value = [
                        'id' => $data->employee_reporting_to,
                        'text' => $data->employee_reporting_to.' - '.$employee_reporting[$data->employee_reporting_to]->employee_fullname
                    ];
                }
            } else {
                $data['employee_name_value'] = ['id' => '', 'text' => ''];
            }
        } else {
            if (!isset($data['employee_reporting_to']) || $data['employee_reporting_to'] == 0) {
                $data['employee_name_value'] = ['id' => '', 'text' => ''];
            } else {
                $data['employee_name_value'] = [
                    'id' => $data['id'], 'text' => $employee_data_list[$data['id']]->employee_fullname
                ];
            }
        }

        if (!isset($data['employee_sub_unit']) || $data['employee_sub_unit'] == 0) {
            $data['sub_unit_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['sub_unit_value'] = [
                'id' => $data['employee_sub_unit'],
                'text' => $sub_unit_data_list[$data['employee_sub_unit']]->sub_unit_name
            ];
        }

        if (!isset($data['employee_work_location']) || $data['employee_work_location'] == 0) {
            $data['work_location_value'] = ['id' => '', 'text' => ''];
        } else {
            if (!empty($work_location_data_list[$data['employee_work_location']]->work_location_bangla)) {
                $employee_work_text = $work_location_data_list[$data['employee_work_location']]->work_location_name.' - '.$work_location_data_list[$data['employee_work_location']]->work_location_bangla;
            } else {
                $employee_work_text = $work_location_data_list[$data['employee_work_location']]->work_location_name;
            }
            $data['work_location_value'] = ['id' => $data['employee_work_location'], 'text' => $employee_work_text];
        }

        if (!isset($data['work_area']) || $data['work_area'] == 0) {
            $data['work_area_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['work_area_value'] = [
                'id' => $data['work_area'], 'text' => $work_area_data_list[$data['work_area']]->work_area_name
            ];
        }

        $employee_group_data_list = EmployeeGroup::valid()->project()->orderBy('priority',
            'ASC')->get()->keyBy('id')->all();
        if (!isset($data['employee_group_data']) || $data['employee_group_data'] == 0) {
            $data['employee_group_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['employee_group_value'] = [
                'id' => $data['employee_group_data'],
                'text' => $employee_group_data_list[$data['employee_group_data']]->employee_group_name
            ];
        }

        $present_district_data = array();
        $presentDistrict_data = DistrictModel::orderBy('name', 'ASC')->get()->keyBy('id')->all();

        if (!isset($data['present_district']) || $data['present_district'] == 0) {
            $data['present_district_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['present_district_value'] = [
                'id' => $data['present_district'],
                'text' => $presentDistrict_data[$data['present_district']]->name.' - '.$presentDistrict_data[$data['present_district']]->bn_name
            ];
        }

        $present_district_data = array();
        foreach ($presentDistrict_data as $value) {
            array_push($present_district_data,
                ['id' => $value['id'], 'text' => $value['name'].' - '.$value['bn_name']]);
        }
        $data['present_district_data'] = $present_district_data;

        if (!isset($data['permanent_district']) || $data['permanent_district'] == 0) {
            $data['permanent_district_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['permanent_district_value'] = [
                'id' => $data['present_district'],
                'text' => $presentDistrict_data[$data['permanent_district']]->name.' - '.$presentDistrict_data[$data['permanent_district']]->bn_name
            ];
        }

        $present_district_data = array();
        foreach ($presentDistrict_data as $value) {
            array_push($present_district_data,
                ['id' => $value['id'], 'text' => $value['name'].' - '.$value['bn_name']]);
        }
        $data['present_district_data'] = $present_district_data;


        $permanent_thana_data = array();
        $permanentThana_data = UpazilaModel::orderBy('name', 'ASC')->get()->keyBy('id')->all();
        // echo"<pre>";
        // print_r($data['permanent_thana']);
        // echo"<pre>";
        // print_r($permanentThana_data);
        // exit();

        if (!isset($data['permanent_thana']) || $data['permanent_thana'] == 0) {
            $data['permanent_thana_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['permanent_thana_value'] = [
                'id' => $data['permanent_thana'],
                'text' => $permanentThana_data[$data['permanent_thana']]->name.' - '.$permanentThana_data[$data['permanent_thana']]->bn_name
            ];
        }

        foreach ($permanentThana_data as $value) {
            array_push($permanent_thana_data, ['id' => $value['id'], 'text' => $value['name'].' - '.$value['bn_name']]);
        }
        $data['permanent_thana_data'] = $permanent_thana_data;


        if (!isset($data['present_thana']) || $data['present_thana'] == 0) {
            $data['present_thana_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['present_thana_value'] = [
                'id' => $data['present_thana'],
                'text' => $permanentThana_data[$data['present_thana']]->name.' - '.$permanentThana_data[$data['present_thana']]->bn_name
            ];
        }

        $present_thana_data = array();
        foreach ($permanentThana_data as $value) {
            array_push($present_thana_data, ['id' => $value['id'], 'text' => $value['name'].' - '.$value['bn_name']]);
        }
        $data['present_thana_data'] = $present_thana_data;

        $present_union_data = array();
        $presentUnion_data = UnionModel::orderBy('name', 'ASC')->get()->keyBy('id')->all();

        if (!isset($data['present_union']) || $data['present_union'] == 0) {
            $data['present_union_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['present_union_value'] = [
                'id' => $data['present_union'],
                'text' => $presentUnion_data[$data['present_union']]->name.' - '.$presentUnion_data[$data['present_union']]->bn_name
            ];
        }

        foreach ($presentUnion_data as $value) {
            array_push($present_union_data, ['id' => $value['id'], 'text' => $value['name'].' - '.$value['bn_name']]);
        }
        $data['present_union_data'] = $present_union_data;

        $present_union_data = array();
        if (!isset($data['permanent_union']) || $data['permanent_union'] == 0) {
            $data['permanent_union_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['permanent_union_value'] = [
                'id' => $data['permanent_union'],
                'text' => $presentUnion_data[$data['permanent_union']]->name.' - '.$presentUnion_data[$data['permanent_union']]->bn_name
            ];
        }

        foreach ($presentUnion_data as $value) {
            array_push($present_union_data, ['id' => $value['id'], 'text' => $value['name'].' - '.$value['bn_name']]);
        }
        $data['present_union_data'] = $present_union_data;

        $sub_section_data_list = SubSection::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();

        $unit_data_list = UnitModel::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();

        if (!isset($data['employee_sub_section']) || $data['employee_sub_section'] == 0) {
            $data['sub_section_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['sub_section_value'] = [
                'id' => $data['employee_sub_section'],
                'text' => $sub_section_data_list[$data['employee_sub_section']]->sub_section_name
            ];
        }
        if (!isset($data['employee_group']) || $data['employee_group'] == 0) {
            $data['employee_group_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['employee_group_value'] = [
                'id' => $data['employee_group'],
                'text' => $employee_group_data_list[$data['employee_group']]->employee_group_name
            ];
        }

        if (!isset($data['employee_unit']) || $data['employee_unit'] == 0) {
            $data['unit_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['unit_value'] = [
                'id' => $data['employee_unit'], 'text' => $unit_data_list[$data['employee_unit']]->unit_name
            ];
        }

        if ($id != 0) {
            if (!isset($data['employee_unit']) || $data['employee_unit'] == 0) {
                $data['unit_value'] = ['id' => '', 'text' => ''];
            } else {
                $data['unit_value'] = [
                    'id' => $data['employee_unit'], 'text' => $unit_data_list[$data['employee_unit']]->unit_name
                ];
            }
        } else {
            $data['employee_unit'] = Auth::guard('user')->user()->unit;
            if (!isset($data['employee_unit']) || $data['employee_unit'] == 0) {
                $data['unit_value'] = ['id' => '', 'text' => ''];
            } else {
                $data['unit_value'] = [
                    'id' => $data['employee_unit'], 'text' => $unit_data_list[$data['employee_unit']]->unit_name
                ];
            }
        }

        $company_sbu_data = array();
        $section_data = array();
        $sub_section_data = array();
        $employee_group_data = array();
        $department_data = array();
        $designation_data = array();
        $jobgrade_data = array();
        $employee_data = array();
        $employee_data_approval = array();
        $unit_data = array();
        $sub_unit_data = array();
        $work_location_data = array();
        $work_area_data = array();
        $office_time_data = array();
        array_push($company_sbu_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($companysbu_data_list as $value) {
            array_push($company_sbu_data, ['id' => $value['id'], 'text' => $value['sbu_name']]);
        }
        array_push($section_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($section_data_list as $value) {
            array_push($section_data, ['id' => $value['id'], 'text' => $value['section_name']]);
        }
        array_push($sub_section_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($sub_section_data_list as $value) {
            array_push($sub_section_data, ['id' => $value['id'], 'text' => $value['sub_section_name']]);
        }
        array_push($employee_group_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($employee_group_data_list as $value) {
            array_push($employee_group_data, ['id' => $value['id'], 'text' => $value['employee_group_name']]);
        }
        array_push($department_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($department_list as $value) {
            array_push($department_data, ['id' => $value['id'], 'text' => $value['department_name']]);
        }
        array_push($designation_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($designation_data_list as $value) {
            if (!empty($value['designation_name_bangla'])) {
                $designationText = $value['designation_name'].'-'.$value['designation_name_bangla'];
            } else {
                $designationText = $value['designation_name'];
            }
            array_push($designation_data, ['id' => $value['id'], 'text' => $designationText]);
        }
        array_push($jobgrade_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($jobgrade_data_list as $value) {
            array_push($jobgrade_data, ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        }
        array_push($employee_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($employee_data_list as $value) {
            array_push($employee_data, [
                'id' => $value['id'], 'employeeNo' => $value['employee_id_no'],
                'text' => $value['employee_id_no'].' - '.$value['employee_fullname']
            ]);
        }
        array_push($sub_unit_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($sub_unit_data_list as $value) {
            array_push($sub_unit_data, ['id' => $value['id'], 'text' => $value['sub_unit_name']]);
        }
        array_push($unit_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($unit_data_list as $value) {
            array_push($unit_data, ['id' => $value['id'], 'text' => $value['unit_name']]);
        }
        array_push($work_location_data, ['id' => '', 'text' => 'Desegitlect']);
        foreach ($work_location_data_list as $value) {
            if (!empty($value['work_location_bangla'])) {
                $work_location_text = $value['work_location_name'].' - '.$value['work_location_bangla'];
            } else {
                $work_location_text = $value['work_location_name'];
            }
            array_push($work_location_data, ['id' => $value['id'], 'text' => $work_location_text]);
        }
        array_push($work_area_data, ['id' => '', 'text' => 'Deselect']);
        foreach ($work_area_data_list as $value) {
            array_push($work_area_data, ['id' => $value['id'], 'text' => $value['work_area_name']]);
        }
        array_push($employee_data_approval, ['id' => '', 'text' => 'Deselect']);
        foreach ($employee_data_list as $value) {
            array_push($employee_data_approval, [
                'id' => $value['id'], 'employee_name' => $value['employee_fullname'],
                'employee_ids' => $value['employee_id_no'],
                'text' => $value['employee_id_no'].' : '.$value['employee_fullname']
            ]);
        }
        array_push($office_time_data, ['id' => '', 'text' => 'Deselect']);
        // foreach ($office_time_data_list as $value) {
        //   array_push($office_time_data, ['id' => $value['id'], 'text' => $value['office_start_time'] . ' - ' . $value['office_end_time']]);
        // }

        $data['company_sbu_data'] = $company_sbu_data;
        $data['section_data'] = $section_data;
        $data['sub_section_data'] = $sub_section_data;
        $data['employee_group_data'] = $employee_group_data;
        $data['department_data'] = $department_data;
        $data['designation_data'] = $designation_data;
        $data['jobgrade_data'] = $jobgrade_data;
        $data['employee_data'] = $employee_data;
        $data['employee_data_approval'] = $employee_data_approval;
        $data['sub_unit_data'] = $sub_unit_data;
        $data['unit_data'] = $unit_data;
        $data['work_location_data'] = $work_location_data;
        $data['work_area_data'] = $work_area_data;
        // $data['office_time_data'] =  $office_time_data;
        $data['role_id'] = Auth::guard('user')->user()->user_type;

        $floorQuery = Floor::query()
            ->where('floor_status', 1);

        if (isset($data['id'])) {
            $floorQuery->where('work_location_id', $data['employee_work_location']);
        }

        $data['floors'] = $floorQuery->get()
            ->map(function ($floor) {
                return [
                    'id' => $floor->id,
                    'text' => $floor->floor_number
                ];
            });

        if (isset($data['floor_number'])) {
            $floor = Floor::query()
                ->where('id', $data['floor_number'])
                ->first();

            $data['floor_value'] = ['id' => $floor->id, 'text' => $floor->floor_number];
        }

        return response($data);
    }

    public function getFloors($id)
    {
        $location = WorkLocation::query()
            ->with('floors')
            ->findOrFail($id);

        return $location->floors
            ->map(function ($floor) {
                return [
                    'id' => $floor->id,
                    'text' => $floor->floor_number
                ];
            });
    }

    public function personalInfoStore(Request $request)
    {
        // $validate=[
        //   'salary_duration_type'=>'required',
        //   'attendance_bonus_get'=>'required',
        //   'employee_salary_type'=>'required',
        //   'employee_reporting_to'=>'required',

        //   'employee_joining_date'=>'required',
        //   'employee_dob_certificate'=>'required',
        //   'emplyee_category_mgt_non_mgt'=>'required',
        //   'employee_type'=>'required',
        //   'employee_department'=>'required',
        //   'employee_sbu'=>'required',
        //   'employee_job_grade'=>'required',
        //   'employee_designation'=>'required',
        //   'employee_blood_group'=>'required',
        //   'employee_gender'=>'required',
        //   'employee_mother_name'=>'required',


        // ];
        // $request->validate($validate);
        // this. uris=URL.baseUrl('').split('/');
        // $request->id
        // return $_SERVER['PHP_SELF'];


        $data = $request->only(
            'employee_nid_name',
            'employee_nid_name_bangla',
            'employee_nick_name',
            'employee_father_name',
            'employee_father_name_bangla',
            'employee_mother_name_bangla',
            'employee_mother_name',
            'employee_dob_certificate',
            'employee_spouse_name',
            'employee_gender',
            'employee_marital_status',
            'employee_nationality',
            'employee_email',
            'employee_blood_group',
            'employee_dob_actual',
            'employee_marriage_date',
            'employee_children_no',
            'employee_religion',
            'employee_height',
            'employee_feet',
            'employee_inch',
            'employee_weight',
            'whats_app_no',
            'skype_no'
        );
        if (!empty($request->employee_nid_name)) {
            $data['employee_nid_name'] = $request->employee_nid_name;
        } else {
            $data['employee_nid_name'] = $request->employee_fullname;
        }

        $salariy = DB::table('salaries')->where('employee_id', '=', $request->id)->first();

        dd($salariy);

        if (!empty($salariy)) {
            if ($request->gross_salary_bangla > 0 && $request->gross_salary_bangla_text != '') {
                $data1['updated_by'] = Auth::guard('user')->user()->id;
                $data1['gross_salary_bangla'] = $request->gross_salary_bangla;
                $data1['gross_salary'] = $request->gross_salary_bangla;
                $data1['gross_salary_bangla_text'] = $request->gross_salary_bangla_text;
                DB::table('salaries')->where('employee_id', '=', $request->id)->update($data1);
            } else {

            }
        } else {
            $employees = DB::table('employees')->where('id', '=', $request->id)->first();
            // return $request;
            $data1 = [
                'gross_salary_bangla' => $request->gross_salary_bangla ?? 0,
                'gross_salary_bangla_text' => $request->gross_salary_bangla_text ?? '',
                'employee_id' => $request->id,
                'entry_date' => $employees->employee_joining_date,
                'company_sbu_id' => $employees->employee_sbu,
                'salary_sbu_id' => $employees->employee_sbu,
                'confirmation_date' => $employees->employee_joining_date,
                'salary_goes_to' => 1,
                'gross_salary' => $request->gross_salary_bangla ?? 0,
                'salary_status' => 1,
                'type' => 1,
                'project_id' => 8,
                'branch_id' => Auth::guard('user')->user()->branch_id,
                'created_by' => Auth::guard('user')->user()->id,
            ];

            DB::table('salaries')->insert($data1);
        }

        $personal_data = EmployeePersonalInfo::where('employee_id', '=', $request->id)->first();
        if (!empty($personal_data)) {
            $update_data = EmployeePersonalInfo::where('employee_id', '=', $request->id)->firstOrFail();
            $data['updated_by'] = Auth::guard('user')->user()->id;
            $save_data = $update_data->update($data);
            $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
        } else {
            $data['employee_id'] = $request->id;
            $data['project_id'] = Auth::guard('user')->user()->project_id;
            $data['branch_id'] = Auth::guard('user')->user()->branch_id;
            $data['created_by'] = Auth::guard('user')->user()->id;
            $save_data = EmployeePersonalInfo::create($data);
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
        }
        if (!$save_data) {
            $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
        }
        return response($message);
    }

    public function addressDetails(Request $request)
    {
        $data = $request->only(
            'present_address_bangla',
            'permanent_address_bangla',
            'present_holding_no',
            'present_house_name',
            'present_road_no',
            'present_road_name',
            'present_vill_area',
            'present_ward_no',
            'present_union',
            'present_post_office',
            'present_thana',
            'present_district',
            'present_mobile_2nd',
            'permanent_holding_no',
            'permanent_house_name',
            'permanent_road_no',
            'permanent_road_name',
            'permanent_vill_area',
            'permanent_ward_no',
            'permanent_union',
            'permanent_post_office',
            'permanent_thana',
            'permanent_district',
            'permanent_mobile_3rd'
        );
        $personal_data = EmployeeAdressDetail::where('ead_employee_id', '=', $request->id)->first();
        if (!empty($personal_data)) {
            $update_data = EmployeeAdressDetail::where('ead_employee_id', '=', $request->id)->firstOrFail();
            $data['updated_by'] = Auth::guard('user')->user()->id;
            $save_data = $update_data->update($data);
            $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
        } else {
            $data['ead_employee_id'] = $request->id;
            $data['project_id'] = Auth::guard('user')->user()->project_id;
            $data['branch_id'] = Auth::guard('user')->user()->branch_id;
            $data['created_by'] = Auth::guard('user')->user()->id;
            $save_data = EmployeeAdressDetail::create($data);
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
        }
        if (!$save_data) {
            $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
        }
        return response($message);
    }

    public function identificationSupporting(Request $request)
    {
        // return response($request);
        // $validate=[
        //   'nid_number'=>'required',
        // ];
        // $request->validate($validate);
        $data = $request->only(
            'nid_number',
            'nid_issue_renew_date',
            'nid_expiry_date',
            'passport_number',
            'passport_issue_renew_date',
            'passport_expiry_date',
            'driving_license_number',
            'driving_license_issue_renew_date',
            'driving_license_expiry_date',
            'tin_number',
            'tin_issue_renew_date',
            'tin_expiry_date',
            'birth_cer_number',
            'birth_cer_issue_renew_date',
            'birth_cer_expiry_date'
        );
        $employee_data = EmployeeIdentificationSupporting::where('eis_employee_id', '=', $request->id)->first();
        if (!empty($employee_data)) {
            if ($request->nid_number != null && $request->nid_document != $employee_data->nid_document) {
                $data['nid_document'] = $this->identification_documner_process($request->nid_document);
            } else {
                $data['nid_document'] = $employee_data->nid_document;
            }
            if ($request->passport_number != null && $request->passport_document != $employee_data->passport_document) {
                $data['passport_document'] = $this->identification_documner_process($request->passport_document);
            } else {
                $data['passport_document'] = $employee_data->passport_document;
            }
            if ($request->dl_document != null && $request->dl_document != $employee_data->dl_document) {
                $data['dl_document'] = $this->identification_documner_process($request->dl_document);
            } else {
                $data['dl_document'] = $employee_data->dl_document;
            }
            if ($request->tin_document != null && $request->tin_document != $employee_data->tin_document) {
                $data['tin_document'] = $this->identification_documner_process($request->tin_document);
            } else {
                $data['tin_document'] = $employee_data->tin_document;
            }
            if ($request->birthC_document != null && $request->birthC_document != $employee_data->birthC_document) {
                $data['birthC_document'] = $this->identification_documner_process($request->birthC_document);
            } else {
                $data['birthC_document'] = $employee_data->birthC_document;
            }
            $update_data = EmployeeIdentificationSupporting::where('eis_employee_id', '=', $request->id)->firstOrFail();
            $data['updated_by'] = Auth::guard('user')->user()->id;
            $save_data = $update_data->update($data);
            $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
        } else {
            if ($request->nid_document) {
                $data['nid_document'] = $this->identification_documner_process($request->nid_document);
            }
            if ($request->passport_document) {
                $data['passport_document'] = $this->identification_documner_process($request->passport_document);
            }
            if ($request->dl_document) {
                $data['dl_document'] = $this->identification_documner_process($request->dl_document);
            }
            if ($request->tin_document) {
                $data['tin_document'] = $this->identification_documner_process($request->tin_document);
            }
            if ($request->birthC_document) {
                $data['birthC_document'] = $this->identification_documner_process($request->birthC_document);
            }
            $data['eis_employee_id'] = $request->id;
            $data['project_id'] = Auth::guard('user')->user()->project_id;
            $data['branch_id'] = Auth::guard('user')->user()->branch_id;
            $data['created_by'] = Auth::guard('user')->user()->id;
            $save_data = EmployeeIdentificationSupporting::create($data);
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
        }
        if (!$save_data) {
            $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
        }
        return response($message);
    }

    public function identification_documner_process($image = null)
    {
        if (!empty($image)) {
            $exploded = explode(',', $image);
            if (strlen($image) >= 800) {
                $decoded = base64_decode($exploded[1]);
                $exploded1 = explode(';', $exploded[0]);
                $exploded2 = explode('/', $exploded1[0]);
                if (str_contains($exploded2[1], 'jpeg')) {
                    $str_contains = 'jpeg';
                }
                if (str_contains($exploded2[1], 'jpg')) {
                    $str_contains = 'jpg';
                }
                if (str_contains($exploded2[1], 'pdf')) {
                    $str_contains = 'pdf';
                }
                if (str_contains($exploded2[1], 'doc')) {
                    $str_contains = 'doc';
                }
                if (str_contains($exploded2[1], 'docx')) {
                    $str_contains = 'docx';
                }
                if (str_contains($exploded2[1], 'png')) {
                    $str_contains = 'png';
                }
                $fileName = str_random().'.'.$str_contains;
                $path = public_path().'/identification_files/'.$fileName;
                file_put_contents($path, $decoded);
                return $fileName;
            }
        } else {
            return null;
        }
    }

    public function educationalQualification(Request $request)
    {
        // return response($request->educational_infos);

        if (!empty($request->educational_infos)) {
            $employeesId = $request['id'];
            DB::table('employee_educational_qualifications')->where('eeq_employee_id', '=', $employeesId)->delete();
            foreach ($request->educational_infos as $key => $value) {
                // if(!empty($value['eeq_degree_name']) || !empty($value['eeq_institute_name']) ){
                if ($value['eeq_highest_education'] == 1) {
                    $highest_education = 1;
                } else {
                    $highest_education = 0;
                }
                $educational_data = [
                    'eeq_employee_id' => $request->id,
                    'eeq_degree_name' => $value['eeq_degree_name'],
                    'eeq_major_group' => isset($value['eeq_major_group']) ? $value['eeq_major_group'] : '',
                    'eeq_institute_name' => isset($value['eeq_institute_name']) ? $value['eeq_institute_name'] : '',
                    'eeq_board_university' => isset($value['eeq_board_university']) ? $value['eeq_board_university'] : '',
                    'eeq_session_from' => isset($value['eeq_session_from']) ? $value['eeq_session_from'] : '',
                    'eeq_session_to' => isset($value['eeq_session_to']) ? $value['eeq_session_to'] : '',
                    'eeq_passing_year' => isset($value['eeq_passing_year']) ? $value['eeq_passing_year'] : '',
                    'eeq_division_gpa' => isset($value['eeq_division_gpa']) ? $value['eeq_division_gpa'] : '',
                    'eeq_highest_education' => $highest_education,
                    'project_id' => Auth::guard('user')->user()->project_id,
                    'branch_id' => Auth::guard('user')->user()->branch_id,
                    'created_by' => Auth::guard('user')->user()->id
                ];
                $save_data = EmployeeEducationalQualification::create($educational_data);
                // if(!empty($value['id'])){
                //   $update_data=EmployeeEducationalQualification::valid()->project()->findOrFail($value['id']);
                //   $save_data=$update_data->update($educational_data);
                //   $message=['status' => 1, 'message' => 'Your data is successfully updated'];
                // }else{
                //   $degree_name = EmployeeEducationalQualification::where('eeq_degree_name', '=' ,$value['eeq_degree_name'])->first();
                //   if (!empty($degree_name)) {
                //     $message=['status' => 0, 'message' => 'Same data exist!'];
                //   }else{
                //     $save_data=EmployeeEducationalQualification::create($educational_data);
                //     $message=['status' => 1, 'message' => 'Your data is successfully saved'];
                //   }
                // }
                // }
            }
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
        }
        if (empty($save_data)) {
            $message = ['status' => 0, 'message' => 'please select the necessary input field'];
        }

        return response($message);
    }

    public function professionalQualification(Request $request)
    {
        // return response($request);
        if (!empty($request->professional_infos)) {
            DB::table('employee_professional_qualifications')->where('pq_employee_id', '=', $request->id)->delete();
            foreach ($request->professional_infos as $key => $value) {
                if ($value['pq_course_title'] != '') {
                    $educational_data = [
                        'pq_employee_id' => $request->id,
                        'pq_course_title' => $value['pq_course_title'],
                        'pq_institute_name' => isset($value['pq_institute_name']) ? $value['pq_institute_name'] : '',
                        'pq_location' => isset($value['pq_location']) ? $value['pq_location'] : '',
                        'pq_duration_from' => isset($value['pq_duration_from']) ? $value['pq_duration_from'] : '',
                        'pq_duration_to' => isset($value['pq_duration_to']) ? $value['pq_duration_to'] : '',
                        'pq_result' => isset($value['pq_result']) ? $value['pq_result'] : '',
                        'project_id' => Auth::guard('user')->user()->project_id,
                        'branch_id' => Auth::guard('user')->user()->branch_id,
                        'created_by' => Auth::guard('user')->user()->id
                    ];
                }
                $save_data = EmployeeProfessionalQualification::create($educational_data);
                // if(!empty($value['id'])){
                //   $update_data=EmployeeProfessionalQualification::valid()->project()->findOrFail($value['id']);
                //   $save_data=$update_data->update($educational_data);
                //   $message=['status' => 1, 'message' => 'Your data is successfully updated'];
                // }else{
                //   $degree_name = EmployeeProfessionalQualification::where('pq_course_title', '=' ,$value['pq_course_title'])->first();
                //   if (!empty($degree_name)) {
                //     $message=['status' => 0, 'message' => 'Same data exist!'];
                //   }else{
                //     $save_data=EmployeeProfessionalQualification::create($educational_data);
                //     $message=['status' => 1, 'message' => 'Your data is successfully saved'];
                //   }
                // }
            }
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
            if (empty($save_data)) {
                $message = ['status' => 0, 'message' => 'please select the necessary input field'];
            }
        }
        return response($message);
    }

    public function employmentHistory(Request $request)
    {
        // return response($request);
        if (!empty($request->employment_histories)) {
            DB::table('employee_employment_histories')->where('eeh_employee_id', '=', $request->id)->delete();
            foreach ($request->employment_histories as $key => $value) {
                if ($value['eeh_job_title'] != '') {
                    $educational_data = [
                        'eeh_employee_id' => $request->id,
                        'eeh_job_title' => $value['eeh_job_title'],
                        'eeh_organization_name' => isset($value['eeh_organization_name']) ? $value['eeh_organization_name'] : '',
                        'eeh_industry_type' => isset($value['eeh_industry_type']) ? $value['eeh_industry_type'] : '',
                        'eeh_industry_type' => isset($value['eeh_industry_type']) ? $value['eeh_industry_type'] : '',
                        'eeh_duration_from' => isset($value['eeh_duration_from']) ? $value['eeh_duration_from'] : '',
                        'eeh_duration_from' => isset($value['eeh_duration_from']) ? $value['eeh_duration_from'] : '',
                        'eeh_service_length' => isset($value['eeh_service_length']) ? $value['eeh_service_length'] : '',
                        'project_id' => Auth::guard('user')->user()->project_id,
                        'branch_id' => Auth::guard('user')->user()->branch_id,
                        'created_by' => Auth::guard('user')->user()->id
                    ];
                    $save_data = EmployeeEmploymentHistory::create($educational_data);
                }

                // if(!empty($value['id'])){
                //   $update_data=EmployeeEmploymentHistory::valid()->project()->findOrFail($value['id']);
                //   $save_data=$update_data->update($educational_data);
                //   $message=['status' => 1, 'message' => 'Your data is successfully updated'];
                // }else{
                //   $degree_name = EmployeeEmploymentHistory::where('eeh_job_title', '=' ,$value['eeh_job_title'])->first();
                //   if (!empty($degree_name)) {
                //     $message=['status' => 0, 'message' => 'Same data exist!'];
                //   }else{
                //     $save_data=EmployeeEmploymentHistory::create($educational_data);
                //     $message=['status' => 1, 'message' => 'Your data is successfully saved'];
                //   }
                // }
            }
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
            if (empty($save_data)) {
                $message = ['status' => 0, 'message' => 'please select the necessary input field'];
            }
        }
        return response($message);
    }

    public function familyDetails(Request $request)
    {
        // return response($request);
        if (!empty($request->family_details)) {
            DB::table('employee_family_details')->where('efd_employee_id', '=', $request->id)->delete();
            foreach ($request->family_details as $key => $value) {
                if ($value['efd_family_member_name'] != '') {
                    $educational_data = [
                        'efd_employee_id' => $request->id,
                        'efd_family_member_name' => $value['efd_family_member_name'],
                        'efd_relationship' => isset($value['efd_relationship']) ? $value['efd_relationship'] : '',
                        'efd_date_of_birth' => isset($value['efd_date_of_birth']) ? $value['efd_date_of_birth'] : '',
                        'efd_occupation' => isset($value['efd_occupation']) ? $value['efd_occupation'] : '',
                        'efd_contact_mobile_no' => isset($value['efd_contact_mobile_no']) ? $value['efd_contact_mobile_no'] : '',
                        'project_id' => Auth::guard('user')->user()->project_id,
                        'branch_id' => Auth::guard('user')->user()->branch_id,
                        'created_by' => Auth::guard('user')->user()->id
                    ];
                }
                $save_data = EmployeeFamilyDetail::create($educational_data);
                // if(!empty($value['id'])){
                //   $update_data=EmployeeFamilyDetail::valid()->project()->findOrFail($value['id']);
                //   $save_data=$update_data->update($educational_data);
                //   $message=['status' => 1, 'message' => 'Your data is successfully updated'];
                // }else{
                //   $degree_name = EmployeeFamilyDetail::where('efd_family_member_name', '=' ,$value['efd_family_member_name'])->first();
                //   if (!empty($degree_name)) {
                //     $message=['status' => 0, 'message' => 'Same data exist!'];
                //   }else{
                //     $save_data=EmployeeFamilyDetail::create($educational_data);
                //     $message=['status' => 1, 'message' => 'Your data is successfully saved'];
                //   }
                // }
            }
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
            if (empty($save_data)) {
                $message = ['status' => 0, 'message' => 'please select the necessary input field'];
            }
        }
        return response($message);
    }

    public function references(Request $request)
    {
        return response($request);
        // $validate=[
        //   'er_name1'=>'required',
        // ];
        // $request->validate($validate);
        // $data=$request->only('er_name1','er_relationship1','er_occupation1','er_designation_department1','er_company_address1','er_holding_no1','er_mobile_no1','er_road_no1','er_house_name1','er_road_name1','er_ward_no1','er_union_pouro_city1','er_post_office1','er_thana1','er_district1','er_nid_no1','er_name2','er_relationship2','er_occupation2','er_designation_department2','er_company_address2','er_holding_no2','er_mobile_no2','er_road_no2','er_house_name2','er_road_name2','er_ward_no2','er_union_pouro_city2','er_post_office2','er_thana2','er_district2','er_nid_no2'
        // );
        if ($request->references_details) {
            foreach ($request->references_details as $key => $value) {
                $employee_data = EmployeeReference::where('er_employee_id', '=', $request->id)->first();
                if (!empty($employee_data)) {
                    $update_data = EmployeeReference::where('id', '=', $employee_data['id'])->firstOrFail();
                    $data['updated_by'] = Auth::guard('user')->user()->id;
                    $save_data = $update_data->update($data);
                    $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
                } else {
                    $data['er_employee_id'] = $request->id;
                    $data['project_id'] = Auth::guard('user')->user()->project_id;
                    $data['branch_id'] = Auth::guard('user')->user()->branch_id;
                    $data['created_by'] = Auth::guard('user')->user()->id;
                    $save_data = EmployeeReference::create($data);
                    $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
                }
            }
        }


        if (!$save_data) {
            $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
        }
        return response($message);
    }

    public function trainingRecord(Request $request)
    {
        // return response($request);
        if (!empty($request->training_records)) {
            DB::table('employee_training_records')->where('etr_employee_id', '=', $request->id)->delete();
            foreach ($request->training_records as $key => $value) {
                if ($value['etr_training_title'] != '') {
                    $educational_data = [
                        'etr_employee_id' => $request->id,
                        'etr_training_title' => $value['etr_training_title'],
                        'etr_institute_name' => isset($value['etr_institute_name']) ? $value['etr_institute_name'] : '',
                        'etr_duration_from' => isset($value['etr_duration_from']) ? $value['etr_duration_from'] : '',
                        'etr_duration_to' => isset($value['etr_duration_to']) ? $value['etr_duration_to'] : '',
                        'etr_sponsored_by' => isset($value['etr_sponsored_by']) ? $value['etr_sponsored_by'] : '',
                        'etr_certificate_received' => isset($value['etr_certificate_received']) ? $value['etr_certificate_received'] : '',
                        'project_id' => Auth::guard('user')->user()->project_id,
                        'branch_id' => Auth::guard('user')->user()->branch_id,
                        'created_by' => Auth::guard('user')->user()->id
                    ];
                    $save_data = EmployeeTrainingRecord::create($educational_data);
                }

                // if(!empty($value['id'])){
                //   $update_data=EmployeeTrainingRecord::valid()->project()->findOrFail($value['id']);
                //   $save_data=$update_data->update($educational_data);
                //   $message=['status' => 1, 'message' => 'Your data is successfully updated'];
                // }else{
                //   $degree_name = EmployeeTrainingRecord::where('etr_training_title', '=' ,$value['etr_training_title'])->first();
                //   if (!empty($degree_name)) {
                //     $message=['status' => 0, 'message' => 'Same data exist!'];
                //   }else{
                //
                // $save_data=EmployeeTrainingRecord::create($educational_data);
                //     $message=['status' => 1, 'message' => 'Your data is successfully saved'];
                //   }
                // }
            }
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
            if (empty($save_data)) {
                $message = ['status' => 0, 'message' => 'please select the necessary input field'];
            }
        }
        return response($message);
    }

    public function professionalMembership(Request $request)
    {
        // return response($request);
        if (!empty($request->professinal_memberships)) {
            DB::table('employee_professional_memberships')->where('epm_employee_id', '=', $request->id)->delete();
            foreach ($request->professinal_memberships as $key => $value) {
                if ($value['epm_membership_title'] != '') {
                    $educational_data = [
                        'epm_employee_id' => $request->id,
                        'epm_membership_title' => $value['epm_membership_title'],
                        'epm_organization_name' => isset($value['epm_organization_name']) ? $value['epm_organization_name'] : '',
                        'epm_obtained_on' => isset($value['epm_obtained_on']) ? $value['epm_obtained_on'] : '',
                        'epm_valid_upto' => isset($value['epm_valid_upto']) ? $value['epm_valid_upto'] : '',
                        'project_id' => Auth::guard('user')->user()->project_id,
                        'branch_id' => Auth::guard('user')->user()->branch_id,
                        'created_by' => Auth::guard('user')->user()->id
                    ];
                    $save_data = EmployeeProfessionalMembership::create($educational_data);
                }

                // if(!empty($value['id'])){
                //   $update_data=EmployeeProfessionalMembership::valid()->project()->findOrFail($value['id']);
                //   $save_data=$update_data->update($educational_data);
                //   $message=['status' => 1, 'message' => 'Your data is successfully updated'];
                // }else{
                //   $degree_name = EmployeeProfessionalMembership::where('epm_membership_title', '=' ,$value['epm_membership_title'])->first();
                //   if (!empty($degree_name)) {
                //     $message=['status' => 0, 'message' => 'Same data exist!'];
                //   }else{
                //     $save_data=EmployeeProfessionalMembership::create($educational_data);
                //     $message=['status' => 1, 'message' => 'Your data is successfully saved'];
                //   }
                // }
            }
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
            if (!$save_data) {
                $message = ['status' => 0, 'message' => 'please select the necessary input field'];
            }
        }
        return response($message);
    }

    public function bankAccount(Request $request)
    {
        // return response($request);
        if (!empty($request->bank_accounts)) {
            DB::table('employee_bank_account_details')->where('ebc_employee_id', '=', $request->id)->delete();
            foreach ($request->bank_accounts as $key => $value) {
                if ($value['ebc_bank_name'] != '') {
                    $educational_data = [
                        'ebc_employee_id' => $request->id,
                        'ebc_bank_name' => $value['ebc_bank_name'],
                        'ebc_branch_district' => isset($value['ebc_branch_district']) ? $value['ebc_branch_district'] : '',
                        'ebc_ac_holder_name' => isset($value['ebc_ac_holder_name']) ? $value['ebc_ac_holder_name'] : '',
                        'ebc_account_number' => isset($value['ebc_account_number']) ? $value['ebc_account_number'] : '',
                        'status' => isset($value['status']) ? $value['status'] : 1,
                        'project_id' => Auth::guard('user')->user()->project_id,
                        'branch_id' => Auth::guard('user')->user()->branch_id,
                        'created_by' => Auth::guard('user')->user()->id
                    ];
                    $save_data = EmployeeBankAccountDetail::create($educational_data);
                }

                // if(!empty($value['id'])){
                //   $update_data=EmployeeBankAccountDetail::valid()->project()->findOrFail($value['id']);
                //   $save_data=$update_data->update($educational_data);
                //   $message=['status' => 1, 'message' => 'Your data is successfully updated'];
                // }else{
                //   $degree_name = EmployeeBankAccountDetail::where('ebc_bank_name', '=' ,$value['ebc_bank_name'])->first();
                //   if (!empty($degree_name)) {
                //     $message=['status' => 0, 'message' => 'Same data exist!'];
                //   }else{
                //     $save_data=EmployeeBankAccountDetail::create($educational_data);
                //     $message=['status' => 1, 'message' => 'Your data is successfully saved'];
                //   }
                // }
            }
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
            if (!$save_data) {
                $message = ['status' => 0, 'message' => 'please select the necessary input field'];
            }
        }
        return response($message);
    }

    public function emergencyContact(Request $request)
    {
        // return response($request);
        if (!empty($request->emergency_contacts)) {
            DB::table('employee_emergency_contacts')->where('eec_employee_id', '=', $request->id)->delete();
            foreach ($request->emergency_contacts as $key => $value) {
                if ($value['eec_name'] != '') {
                    $educational_data = [
                        'eec_employee_id' => $request->id,
                        'eec_name' => $value['eec_name'],
                        'eec_relationship' => isset($value['eec_relationship']) ? $value['eec_relationship'] : '',
                        'eec_present_address' => isset($value['eec_present_address']) ? $value['eec_present_address'] : '',
                        'eec_mobile_no' => isset($value['eec_mobile_no']) ? $value['eec_mobile_no'] : '',
                        'project_id' => Auth::guard('user')->user()->project_id,
                        'branch_id' => Auth::guard('user')->user()->branch_id,
                        'created_by' => Auth::guard('user')->user()->id
                    ];
                    $save_data = EmployeeEmergencyContact::create($educational_data);
                }

                // if(!empty($value['id'])){
                //   $update_data=EmployeeEmergencyContact::valid()->project()->findOrFail($value['id']);
                //   $save_data=$update_data->update($educational_data);
                //   $message=['status' => 1, 'message' => 'Your data is successfully updated'];
                // }else{
                //   $degree_name = EmployeeEmergencyContact::where('eec_name', '=' ,$value['eec_name'])->first();
                //   if (!empty($degree_name)) {
                //     $message=['status' => 0, 'message' => 'Same data exist!'];
                //   }else{
                //     $save_data=EmployeeEmergencyContact::create($educational_data);
                //     $message=['status' => 1, 'message' => 'Your data is successfully saved'];
                //   }
                // }
            }
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
            if (!$save_data) {
                $message = ['status' => 0, 'message' => 'please select the necessary input field'];
            }
        }
        return response($message);
    }

    public function othersContactInfo(Request $request)
    {
        // return response($request);
        if (!empty($request->others_contact_info)) {
            DB::table('employee_others_contacts')->where('eoc_employee_id', '=', $request->id)->delete();
            foreach ($request->others_contact_info as $key => $value) {
                if ($value['eoc_title'] != '') {
                    $educational_data = [
                        'eoc_employee_id' => $request->id,
                        'eoc_title' => $value['eoc_title'],
                        'eoc_number' => isset($value['eoc_number']) ? $value['eoc_number'] : '',
                        'eoc_remarks' => isset($value['eoc_remarks']) ? $value['eoc_remarks'] : '',
                        'project_id' => Auth::guard('user')->user()->project_id,
                        'branch_id' => Auth::guard('user')->user()->branch_id,
                        'created_by' => Auth::guard('user')->user()->id
                    ];

                    $save_data = EmployeeOthersContact::create($educational_data);
                }

                // if(!empty($value['id'])){
                //   $update_data=EmployeeOthersContact::valid()->project()->findOrFail($value['id']);
                //   $save_data=$update_data->update($educational_data);
                //   $message=['status' => 1, 'message' => 'Your data is successfully updated'];
                // }else{
                //   $degree_name = EmployeeOthersContact::where('eoc_title', '=' ,$value['eoc_title'])->first();
                //   if (!empty($degree_name)) {
                //     $message=['status' => 0, 'message' => 'Same data exist!'];
                //   }else{
                //     $save_data=EmployeeOthersContact::create($educational_data);
                //     $message=['status' => 1, 'message' => 'Your data is successfully saved'];
                //   }
                // }
            }
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
        }
        if (empty($save_data)) {
            $message = ['status' => 0, 'message' => 'please select the necessary input field'];
        }
        return response($message);
    }

    public function findMaxCode()
    {
        $last_entry_data = Employee::latest()->first();
        $last_code = $last_entry_data['employee_id_no'];
        if ($last_code == 0) {
            $last_code = 100101;
        } else {
            $last_code = $last_code + 1;
        }
        return $last_code;
    }

    public function requested_data($id)
    {
        $data['general_info_temp'] = DB::table('general_info_temp')->where('created_by', $id)->first();
        return response($data);
    }

    public function update_requested_data($sl, $id, $data)
    {
        $per_email = $data;
        // return response()->json($per_email);
        if ($sl == 1) {
            // DB::table('employees')->where('id', '=', $employee_id)->update(array('update_request' => 1,));
            $data = DB::table('employee_personal_infos')->select('employee_email')->where('employee_id', $id)->first();
            DB::table('general_info_temp')->where('created_by', '=', $id)->update(array(
                'email_approve_status' => 1,
                'personal_email_id' => $data->employee_email
            ));
            DB::table('employee_personal_infos')->where('employee_id', '=',
                $id)->update(array('employee_email' => $per_email));
        }
        $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
        return response($message);

        // elseif($sl==2){
        //   DB::table('employee_personal_infos')->where('id', '=', $employee_id)->update(array(
        //        'update_request' => 1,
        //     ));
        // }elseif($sl==3){
        //   DB::table('employee_personal_infos')->where('id', '=', $employee_id)->update(array(
        //        'update_request' => 1,
        //     ));
        // }elseif($sl==4){
        //   DB::table('employee_personal_infos')->where('id', '=', $employee_id)->update(array(
        //        'update_request' => 1,
        //     ));
        // }elseif($sl==5){
        //   DB::table('employee_personal_infos')->where('id', '=', $employee_id)->update(array(
        //        'update_request' => 1,
        //     ));
        // }
    }

    public function profile_image_upload(Request $request)
    {
        $id = $request->employee_id;
        if (empty($id)) {
            $id = Auth::guard('user')->user()->employee_id;
            // echo "<pre>"; dd($id); die();
        }
        if ($request->hasFile('employee_image')) {
            $photo = $request->file('employee_image');
            $new = $photo->getClientOriginalName();
            $photo->move(public_path('/images'), $new);
            $data['employee_image'] = $new;
            $update_data = Employee::where(['id' => $id])->update($data);
        } else {
            $data['employee_image'] = '';
        }

        if (!empty($data['employee_image'])) {
            return redirect()->back()->with("success", "Profile Image Upload Successfull!");
        } else {
            return redirect()->back()->with("error", "Something went wrong!");
        }
    }

    public function reset_password(Request $request)
    {
        if (!empty($request)) {
            if ($request->new_password != $request->reenter_password) {
                $message = ['status' => 0, 'message' => 'Re-enter Password Not Match!'];
                return response($message);
            }
            $password = Hash::make($request->new_password);
            $employee_data = Employee::valid()->where('employee_status', 1)->where('id', $request->id)->first();
            $pass_change_suceessfull = DB::table('users_person')->where('employee_card_no', '=',
                $employee_data['employee_id_no'])->update(array(
                'password' => $password,
                'employee_otp' => null
            ));
            $data['pass_change_suceessfull'] = 1;
        }
        if ($pass_change_suceessfull) {
            $message = ['status' => 1, 'message' => 'Password Changed Successful!'];
            return response($message);
        }
    }

    public function transfer(Request $request)
    {
        $validate = [
            'employee_fullname' => 'required',
        ];
        $request->validate($validate);
        $data = $request->only(
            'employee_id_no',
            'employee_fullname',
            'employee_sbu',
            'employee_department',
            'employee_designation',
            'employee_job_grade',
            'employee_reporting_to',
            'employee_work_location',
            'employee_section',
            'employee_sub_unit',
            'employee_sub_section',
            'employee_group',
            'official_mobile_no',
            'official_email_id',
            'desk_phone_no'
        );

        if ($request['transfer_date']) {
            $transfer_data['transfer_date'] = date('Y-m-d', strtotime($request['transfer_date']));
        }
        try {
            DB::beginTransaction();
            if (!empty($request->id)) {
                $update_data = Employee::valid()->project()->findOrFail($request->id);

                $transfer_data['employee_id'] = $update_data->id;
                $transfer_data['employee_id_no'] = $update_data->employee_id_no;
                $transfer_data['employee_fullname'] = $update_data->employee_fullname;
                $transfer_data['employee_sbu'] = $update_data->employee_sbu;
                $transfer_data['employee_department'] = $update_data->employee_department;
                $transfer_data['employee_designation'] = $update_data->employee_designation;
                $transfer_data['employee_group'] = $update_data->employee_group;
                $transfer_data['employee_job_grade'] = $update_data->employee_job_grade;
                $transfer_data['desk_phone_no'] = $update_data->desk_phone_no;
                $transfer_data['official_mobile_no'] = $update_data->official_mobile_no;
                $transfer_data['official_email_id'] = $update_data->official_email_id;
                $transfer_data['employee_reporting_to'] = $update_data->employee_reporting_to;
                $transfer_data['employee_work_location'] = $update_data->employee_work_location;
                $transfer_data['employee_sub_section'] = $update_data->employee_sub_section;
                $transfer_data['employee_section'] = $update_data->employee_section;
                $transfer_data['emplyee_category_mgt_non_mgt'] = $update_data->emplyee_category_mgt_non_mgt;
                $transfer_data['employee_sub_unit'] = $update_data->employee_sub_unit;
                $transfer_data['employee_unit'] = $update_data->employee_unit;
                $transfer_data['remarks'] = $request['remarks'];
                $transfer_data['employee_type'] = $request['employee_type'];
                $transfer_data['transfer_date'] = $transfer_data['transfer_date'];
                $transfer_data['project_id'] = Auth::guard('user')->user()->project_id;
                $transfer_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                $transfer_data['created_by'] = Auth::guard('user')->user()->id;
                $transfer_data['created_at'] = date('Y-m-d');
                $save_data = EmployeeTransfer::create($transfer_data);

                // return response($request);
                $data['updated_by'] = Auth::guard('user')->user()->id;
                $data['updated_at'] = date('Y-m-d');
                $save_data = $update_data->update($data);
                $message = ['status' => 1, 'message' => 'Transfer is successful!'];
            }
            DB::commit();
            return response($message);
        } catch (\Exception $exception) {
            DB::rollBack();
            $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
            return response($exception);
        }
    }

    public function employeeSelect2()
    {
        $data = array();
        $datas = Employee::valid()->project()->orderBy('employee_fullname', 'asc')->get();
        array_push($data, ['id' => '', 'text' => 'Deselect']);
        foreach ($datas as $value) {
            array_push($data, ['id' => $value['id'], 'text' => $value['employee_fullname'],]);
        }
        $result = $data;
        return Response::json(ResponseUtil::makeResponse($message = null, $result));
    }

    public function employeemoreinfo_nid_check($employee_nid = null)
    {
        $resign_data = Employee::valid()->project()
            ->leftJoin('resignations', 'resignations.employee_id', '=', 'employees.id')
            ->leftJoin('employee_identification_supportings', 'employee_identification_supportings.eis_employee_id',
                '=', 'employees.id')
            // ->where('employee_id', $employee_id)
            ->where('nid_number', $employee_nid)
            ->first();
        if (!empty($resign_data->separation_reason)) {
            $resignation_reason = strtolower(substr(trim($resign_data->separation_reason), 0, 3));
            if ($resignation_reason == 'red') {
                $data = 1;
            } else {
                $data = 0;
            }
        } else {
            $data = 0;
        }
        return response($data);
    }
}
