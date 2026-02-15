<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Model\UserMultiLevelPermission;
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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Model
{
    use Notifiable, LogsActivity;

    protected $table = 'employees';

    protected $guarded = array('id','created_at','updated_at');

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['created','updated','deleted'];
    protected static $logName = 'Employee';
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

    public function scopeValid($query)
    {
        return $query->where('employees.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('employees.project_id', $project_id);
    }
    // protected $connection = 'mysql';
    // public function hrStationarySummaryPos()
    // {
    //     return $this->hasMany(HrStationarySummaryPos::class);
    // }

    public function Employee_id()
    {
        $UserMultiLevelPermission = UserMultiLevelPermission::valid()->where('project_id', Auth::guard('user')->user()->project_id)->where('employee_id', Auth::guard('user')->user()->employee_id)->get()->toArray();

        // return $UserMultiLevelPermission;
        if (!empty($UserMultiLevelPermission)) {
            $allEmployees = Employee::valid()->where('project_id', Auth::guard('user')->user()->project_id)->get()->toArray();
            $data['employee_id'] = [];
            $data['sub'] = [];
            $data['unit'] = [];
            $data['subunit'] = [];
            $data['department']=[];
            $data['section']=[];
            $data['subsection']=[];
            $data['work_location']=[];
            $data['designation']=[];

            $employee_id=[];
            $sub=[];
            $unit=[];
            $subunit=[];
            $department=[];
            $section=[];
            $subsection=[];
            $work_location=[];
            $designation=[];


            foreach ($UserMultiLevelPermission as $key => $value) {
                if (!empty($value['sbu_permission'])) {
                    $allEmployee=collect($allEmployees)->where('employee_sbu', '=', $value['sbu_permission'])->toArray();
                }

                if (!empty($value['unit_permission'])) {
                    $allEmployee=collect($allEmployees)->where('employee_sbu', '=', $value['sbu_permission'])->where('employee_unit', '=', $value['unit_permission'])->toArray();
                }
                if (!empty($value['sub_unit_permission'])) {
                    $allEmployee=collect($allEmployees)->where('employee_sbu', '=', $value['sbu_permission'])->where('employee_sub_unit', '=', $value['sub_unit_permission'])->toArray();
                }
                if (!empty($value['department_permission'])) {
                    $allEmployee=collect($allEmployees)->where('employee_sbu', '=', $value['sbu_permission'])->where('employee_department', '=', $value['department_permission'])->toArray();
                }
                if (!empty($value['section_permission'])) {
                    $allEmployee=collect($allEmployees)->where('employee_sbu', '=', $value['sbu_permission'])->where('employee_section', '=', $value['section_permission'])->toArray();
                }
                if (!empty($value['sub_section_permission'])) {
                    $allEmployee=collect($allEmployees)->where('employee_sbu', '=', $value['sbu_permission'])->where('employee_sub_section', '=', $value['sub_section_permission'])->toArray();
                }
                if (!empty($value['work_location_permission'])) {
                    $allEmployee=collect($allEmployees)->where('employee_sbu', '=', $value['sbu_permission'])->where('employee_work_location', '=', $value['work_location_permission'])->toArray();
                }


                // return $allEmployee;
                $data['employee_id'][]=array_merge($employee_id, collect(collect($allEmployee)->pluck('id')->unique()->values('id')->all())->toArray());
                $data['sub'][]=array_merge($sub, collect(collect($allEmployee)->pluck('employee_sbu')->unique()->values('employee_sbu')->all())->toArray());
                $data['unit'][]=array_merge($unit, collect(collect($allEmployee)->pluck('employee_unit')->unique()->values('employee_unit')->all())->toArray());
                $data['subunit'][]=array_merge($subunit, collect(collect($allEmployee)->pluck('employee_sub_unit')->unique()->values('employee_sub_unit')->all())->toArray());
                $data['department'][]=array_merge($department, collect(collect($allEmployee)->pluck('employee_department')->unique()->values('employee_department')->all())->toArray());
                $data['section'][]=array_merge($section, collect(collect($allEmployee)->pluck('employee_section')->unique()->values('employee_section')->all())->toArray());
                $data['subsection'][]=array_merge($subsection, collect(collect($allEmployee)->pluck('employee_sub_section')->unique()->values('employee_sub_section')->all())->toArray());
                $data['designation'][]=array_merge($designation, collect(collect($allEmployee)->pluck('employee_designation')->unique()->values('employee_designation')->all())->toArray());
                $data['work_location'][]=array_merge($work_location, collect(collect($allEmployee)->pluck('employee_work_location')->unique()->values('employee_work_location')->all())->toArray());
            }


            if (!empty($data['employee_id'])) {
                $data['employee_id']=array_flatten($data['employee_id']);
            }
            if (!empty($data['sub'])) {
                $data['sub']=array_flatten($data['sub']);
            }
            if (!empty($data['unit'])) {
                $data['unit']=array_flatten($data['unit']);
            }
            if (!empty($data['subunit'])) {
                $data['subunit']=array_flatten($data['subunit']);
            }
            if (!empty($data['department'])) {
                $data['department']=array_flatten($data['department']);
            }
            if (!empty($data['section'])) {
                $data['section']=array_flatten($data['section']);
            }
            if (!empty($data['subsection'])) {
                $data['subsection']=array_flatten($data['subsection']);
            }
            if (!empty($data['designation'])) {
                $data['designation']=array_flatten($data['designation']);
            }
            if (!empty($data['work_location'])) {
                $data['work_location']=array_flatten($data['work_location']);
            } else {
                $data['work_location']=[];
            }

            return $data;
        } else {
            $userType=Auth::guard('user')->user()->user_type;
            if ($userType==1) {
                # group user
                $employee=Employee::valid()->where('project_id', Auth::guard('user')->user()->project_id)->get()->toArray();
                $data['employee_id']=collect(collect($employee)->pluck('id')->unique()->values('id')->all())->toArray();
                $data['sub']=collect(collect($employee)->pluck('employee_sbu')->unique()->values('employee_sbu')->all())->toArray();
                $data['unit']=collect(collect($employee)->pluck('employee_unit')->unique()->values('employee_unit')->all())->toArray();
                $data['subunit']=collect(collect($employee)->pluck('employee_sub_unit')->unique()->values('employee_sub_unit')->all())->toArray();
                $data['department']=collect(collect($employee)->pluck('employee_department')->unique()->values('employee_department')->all())->toArray();
                $data['section']=collect(collect($employee)->pluck('employee_section')->unique()->values('employee_section')->all())->toArray();
                $data['subsection']=collect(collect($employee)->pluck('employee_sub_section')->unique()->values('employee_sub_section')->all())->toArray();
                $data['designation']=collect(collect($employee)->pluck('employee_designation')->unique()->values('employee_designation')->all())->toArray();
                $data['work_location']=collect(collect($employee)->pluck('employee_work_location')->unique()->values('employee_work_location')->all())->toArray();
            } elseif ($userType==2) {
                # sub/company user.''
                // $employee=Employee::valid()->where('project_id',Auth::guard('user')->user()->project_id)
                // ->where('employee_sbu',Auth::guard('user')->user()->company_sbu)->get()->toArray();
                $sbus = Employee::valid()->where('project_id', Auth::guard('user')->user()->project_id)
                         ->where('employee_sbu', Auth::guard('user')->user()->company_sbu)->get()->toArray();
                $employee=collect($sbus)->where('employee_sbu', Auth::guard('user')->user()->company_sbu)->toArray();

                $data['employee_id']=collect(collect($employee)->pluck('id')->unique()->values('id')->all())->toArray();

                $data['sub']=collect(collect($employee)->pluck('employee_sbu')->unique()->values('employee_sbu')->all())->toArray();

                $data['unit']=collect(collect($sbus)->pluck('employee_unit')->unique()->values('employee_unit')->all())->toArray();

                $data['subunit']=collect(collect($sbus)->pluck('employee_sub_unit')->unique()->values('employee_sub_unit')->all())->toArray();

                $data['department']=collect(collect($sbus)->pluck('employee_department')->unique()->values('employee_department')->all())->toArray();

                $data['section']=collect(collect($sbus)->pluck('employee_section')->unique()->values('employee_section')->all())->toArray();

                $data['subsection']=collect(collect($sbus)->pluck('employee_sub_section')->unique()->values('employee_sub_section')->all())->toArray();
                $data['designation']=collect(collect($sbus)->pluck('employee_designation')->unique()->values('employee_designation')->all())->toArray();
                $data['work_location']=collect(collect($employee)->pluck('employee_work_location')->unique()->values('employee_work_location')->all())->toArray();
            } elseif ($userType==3) {
                # unit user...
                // $employee=Employee::valid()->where('project_id',Auth::guard('user')->user()->project_id)
                // ->where('employee_unit',Auth::guard('user')->user()->unit)->get()->toArray();
                $sbus=Employee::valid()->where('project_id', Auth::guard('user')->user()->project_id)
                         ->where('employee_sbu', Auth::guard('user')->user()->company_sbu)->get()->toArray();
                $employee=collect($sbus)->where('employee_unit', Auth::guard('user')->user()->unit)->toArray();

                $data['employee_id']=collect(collect($employee)->pluck('id')->unique()->values('id')->all())->toArray();

                $data['sub']=collect(collect($employee)->pluck('employee_sbu')->unique()->values('employee_sbu')->all())->toArray();

                $data['unit']=collect(collect($sbus)->pluck('employee_unit')->unique()->values('employee_unit')->all())->toArray();

                $data['subunit']=collect(collect($sbus)->pluck('employee_sub_unit')->unique()->values('employee_sub_unit')->all())->toArray();

                $data['department']=collect(collect($sbus)->pluck('employee_department')->unique()->values('employee_department')->all())->toArray();

                $data['section']=collect(collect($sbus)->pluck('employee_section')->unique()->values('employee_section')->all())->toArray();

                $data['subsection']=collect(collect($sbus)->pluck('employee_sub_section')->unique()->values('employee_sub_section')->all())->toArray();
                $data['designation']=collect(collect($sbus)->pluck('employee_designation')->unique()->values('employee_designation')->all())->toArray();
                $data['work_location']=collect(collect($employee)->pluck('employee_work_location')->unique()->values('employee_work_location')->all())->toArray();
            } elseif ($userType==4) {
                $sbus=Employee::valid()->where('project_id', Auth::guard('user')->user()->project_id)
                         ->where('employee_sbu', Auth::guard('user')->user()->company_sbu)->get()->toArray();
                $employee=collect($sbus)->where('employee_sub_unit', Auth::guard('user')->user()->sub_unit)->toArray();

                $data['employee_id']=collect(collect($employee)->pluck('id')->unique()->values('id')->all())->toArray();

                $data['sub']=collect(collect($employee)->pluck('employee_sbu')->unique()->values('employee_sbu')->all())->toArray();

                $data['unit']=collect(collect($sbus)->pluck('employee_unit')->unique()->values('employee_unit')->all())->toArray();

                $data['subunit']=collect(collect($sbus)->pluck('employee_sub_unit')->unique()->values('employee_sub_unit')->all())->toArray();

                $data['department']=collect(collect($sbus)->pluck('employee_department')->unique()->values('employee_department')->all())->toArray();

                $data['section']=collect(collect($sbus)->pluck('employee_section')->unique()->values('employee_section')->all())->toArray();

                $data['subsection']=collect(collect($sbus)->pluck('employee_sub_section')->unique()->values('employee_sub_section')->all())->toArray();
                $data['designation']=collect(collect($sbus)->pluck('employee_designation')->unique()->values('employee_designation')->all())->toArray();
                $data['designation']=collect(collect($sbus)->pluck('employee_designation')->unique()->values('employee_designation')->all())->toArray();
                $data['work_location']=collect(collect($employee)->pluck('employee_work_location')->unique()->values('employee_work_location')->all())->toArray();
            } elseif ($userType==5) {
                $sbus=Employee::valid()->where('project_id', Auth::guard('user')->user()->project_id)
                         ->where('employee_sbu', Auth::guard('user')->user()->company_sbu)->get()->toArray();
                $employee=collect($sbus)->where('employee_department', Auth::guard('user')->user()->department)->toArray();
                $departments=collect($sbus)->where('employee_department', Auth::guard('user')->user()->department)->toArray();


                $data['employee_id']=collect(collect($employee)->pluck('id')->unique()->values('id')->all())->toArray();

                $data['sub']=collect(collect($employee)->pluck('employee_sbu')->unique()->values('employee_sbu')->all())->toArray();

                $data['unit']=collect(collect($sbus)->pluck('employee_unit')->unique()->values('employee_unit')->all())->toArray();

                $data['subunit']=collect(collect($sbus)->pluck('employee_sub_unit')->unique()->values('employee_sub_unit')->all())->toArray();

                $data['department']=collect(collect($departments)->pluck('employee_department')->unique()->values('employee_department')->all())->toArray();

                $data['section']=collect(collect($departments)->pluck('employee_section')->unique()->values('employee_section')->all())->toArray();

                $data['subsection']=collect(collect($departments)->pluck('employee_sub_section')->unique()->values('employee_sub_section')->all())->toArray();
                $data['designation']=collect(collect($sbus)->pluck('employee_designation')->unique()->values('employee_designation')->all())->toArray();
                $data['work_location']=collect(collect($employee)->pluck('employee_work_location')->unique()->values('employee_work_location')->all())->toArray();
            } elseif ($userType==6) {
                $sbus=Employee::valid()->where('project_id', Auth::guard('user')->user()->project_id)
                         ->where('employee_sbu', Auth::guard('user')->user()->company_sbu)->get()->toArray();
                $employee=collect($sbus)->where('employee_section', Auth::guard('user')->user()->section)->toArray();
                $departments=collect($sbus)->where('employee_department', Auth::guard('user')->user()->department)->toArray();

                $data['employee_id']=collect(collect($employee)->pluck('id')->unique()->values('id')->all())->toArray();


                $data['sub']=collect(collect($employee)->pluck('employee_sbu')->unique()->values('employee_sbu')->all())->toArray();

                $data['unit']=collect(collect($sbus)->pluck('employee_unit')->unique()->values('employee_unit')->all())->toArray();

                $data['subunit']=collect(collect($sbus)->pluck('employee_sub_unit')->unique()->values('employee_sub_unit')->all())->toArray();

                $data['department']=collect(collect($departments)->pluck('employee_department')->unique()->values('employee_department')->all())->toArray();

                $data['section']=collect(collect($departments)->pluck('employee_section')->unique()->values('employee_section')->all())->toArray();

                $data['subsection']=collect(collect($departments)->pluck('employee_sub_section')->unique()->values('employee_sub_section')->all())->toArray();
                $data['designation']=collect(collect($sbus)->pluck('employee_designation')->unique()->values('employee_designation')->all())->toArray();
                $data['work_location']=collect(collect($employee)->pluck('employee_work_location')->unique()->values('employee_work_location')->all())->toArray();
            } elseif ($userType==7) {
                $sbus=Employee::valid()->where('project_id', Auth::guard('user')->user()->project_id)
                         ->where('employee_sbu', Auth::guard('user')->user()->company_sbu)->get()->toArray();
                $employee=collect($sbus)->where('employee_sub_section', Auth::guard('user')->user()->sub_section)->toArray();
                $departments=collect($sbus)->where('employee_department', Auth::guard('user')->user()->department)->toArray();

                $data['employee_id']=collect(collect($employee)->pluck('id')->unique()->values('id')->all())->toArray();

                $data['sub']=collect(collect($employee)->pluck('employee_sbu')->unique()->values('employee_sbu')->all())->toArray();

                $data['unit']=collect(collect($sbus)->pluck('employee_unit')->unique()->values('employee_unit')->all())->toArray();

                $data['subunit']=collect(collect($sbus)->pluck('employee_sub_unit')->unique()->values('employee_sub_unit')->all())->toArray();

                $data['department']=collect(collect($departments)->pluck('employee_department')->unique()->values('employee_department')->all())->toArray();

                $data['section']=collect(collect($departments)->pluck('employee_section')->unique()->values('employee_section')->all())->toArray();

                $data['subsection']=collect(collect($departments)->pluck('employee_sub_section')->unique()->values('employee_sub_section')->all())->toArray();
                $data['designation']=collect(collect($sbus)->pluck('employee_designation')->unique()->values('employee_designation')->all())->toArray();
                $data['work_location']=collect(collect($employee)->pluck('employee_work_location')->unique()->values('employee_work_location')->all())->toArray();
            } elseif ($userType==8) {
                # Normal Employee...
                $sbus=Employee::valid()->where('project_id', Auth::guard('user')->user()->project_id)
                         ->where('employee_sbu', Auth::guard('user')->user()->company_sbu)->get()->toArray();

                $employee=collect($sbus)->where('id', Auth::guard('user')->user()->id)->toArray();
                $departments=collect($sbus)->where('employee_department', Auth::guard('user')->user()->department)->toArray();

                $data['employee_id']=collect(collect($employee)->pluck('id')->unique()->values('id')->all())->toArray();

                $data['sub']=collect(collect($employee)->pluck('employee_sbu')->unique()->values('employee_sbu')->all())->toArray();

                $data['unit']=collect(collect($sbus)->pluck('employee_unit')->unique()->values('employee_unit')->all())->toArray();

                $data['subunit']=collect(collect($sbus)->pluck('employee_sub_unit')->unique()->values('employee_sub_unit')->all())->toArray();

                $data['department']=collect(collect($departments)->pluck('employee_department')->unique()->values('employee_department')->all())->toArray();

                $data['section']=collect(collect($departments)->pluck('employee_section')->unique()->values('employee_section')->all())->toArray();

                $data['subsection']=collect(collect($departments)->pluck('employee_sub_section')->unique()->values('employee_sub_section')->all())->toArray();
                $data['designation']=collect(collect($sbus)->pluck('employee_designation')->unique()->values('employee_designation')->all())->toArray();
                $data['work_location']=collect(collect($employee)->pluck('employee_work_location')->unique()->values('employee_work_location')->all())->toArray();
            }
            return $data;
        }
    }

    public function report_filter_data()
    {
        $emplyData = Employee::valid()->project()
                ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
                ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
                ->leftJoin('unit_models', 'unit_models.id', '=', 'employees.employee_unit')
                ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
                ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
                ->leftJoin('sub_sections', 'sub_sections.id', '=', 'employees.employee_sub_section')
                ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
                ->select(
                    'employees.employee_sbu',
                    'company_sbus.sbu_name',
                    'company_sbus.priority as sub_priority',
                    'employees.employee_sub_unit',
                    'sub_units.sub_unit_name',
                    'sub_units.priority as su_units_priority',
                    'employees.employee_unit',
                    'unit_models.unit_name',
                    'unit_models.priority as units_priority',
                    'employees.employee_department',
                    'departments.department_name',
                    'departments.priority as dep_priority',
                    'employees.employee_section',
                    'sections.section_name',
                    'sections.priority as section_priority',
                    'employees.employee_sub_section',
                    'sub_sections.sub_section_name',
                    'sub_sections.priority as sub_section_priority',
                    'employees.employee_work_location',
                    'work_locations.work_location_name',
                    'work_locations.priority as work_priority',
                    'employees.id',
                    'employees.employee_fullname',
                    'employees.employee_id_no'
                )
                ->whereIn('employees.id', $this->Employee_id()['employee_id'])
                ->get()->toArray();
        // $Allsub_Data=collect($emplyData)->unique('employee_sbu')->values()->toArray();
        // $Allunit_data=collect($emplyData)->unique('employee_unit')->values()->toArray();
        // $Allsub_unit_data=collect($emplyData)->unique('employee_sub_unit')->values()->toArray();
        // $Alldepartment_data=collect($emplyData)->unique('employee_department')->values()->toArray();
        // $Allsection_data=collect($emplyData)->unique('employee_section')->values()->toArray();
        // $Allsub_section_data=collect($emplyData)->unique('employee_sub_section')->values()->toArray();
        // $Allwork_location_data=collect($emplyData)->unique('employee_work_location')->values()->toArray();

        $data['company_sbu_data'] = array();
        $data['section_data'] = array();
        $data['sub_section_data'] = array();
        $data['sub_unit_data'] = array();
        $data['unit_data'] = array();
        $data['work_location_data'] = array();
        $data['department_data'] = array();
        $data['designation_data'] = array();
        $data['jobgrade_data'] = array();
        $data['employee_data'] = array();
        $data['employee_data_approval'] = array();
        // $data['employee_group_data'] = array();
        array_push($data['section_data'], ['id' => '', 'text' => 'Deselect']);
        array_push($data['sub_section_data'], ['id' => '', 'text' => 'Deselect']);
        // array_push($data['employee_group_data'], ['id' => '', 'text' => 'Deselect']);

        // array_push($data['designation_data'], ['id' => '', 'text' => 'Deselect']);
        // array_push($data['jobgrade_data'], ['id' => '', 'text' => 'Deselect']);
        array_push($data['employee_data'], ['id' => '', 'text' => 'Deselect']);
        array_push($data['sub_unit_data'], ['id' => '', 'text' => 'Deselect']);
        array_push($data['unit_data'], ['id' => '', 'text' => 'Deselect']);
        array_push($data['work_location_data'], ['id' => '', 'text' => 'Deselect']);
        array_push($data['department_data'], ['id' => '', 'text' => 'Deselect']);
        $sbusid=0;
        $unitid=0;
        $subunitid=0;
        $depid=0;
        $sectionid=0;
        $subsectionid=0;
        $workid=0;
        $empid=0;

        foreach ($emplyData as $value) {
            array_push($data['company_sbu_data'], ['sub_priority' => $value['sub_priority'],'id' => $value['employee_sbu'], 'text' => $value['sbu_name']]);

            array_push($data['unit_data'], ['units_priority' => $value['units_priority'],'id' => $value['employee_unit'], 'text' => $value['unit_name'],'sbu_id' => $value['employee_sbu']]);

            array_push($data['sub_unit_data'], ['su_units_priority' => $value['su_units_priority'],'id' => $value['employee_sub_unit'], 'text' => $value['sub_unit_name'],'sbu_id' => $value['employee_sbu'],'unit_id' => $value['employee_unit']]);

            array_push($data['department_data'], ['dep_priority' => $value['dep_priority'],'id' => $value['employee_department'], 'text' => $value['department_name'],'sbu_id' => $value['employee_sbu'],'unit_id' => $value['employee_unit'],'sub_unit_id' => $value['employee_sub_unit']]);

            array_push($data['section_data'], ['section_priority' => $value['section_priority'],'id' => $value['employee_section'], 'text' => $value['section_name'],'sbu_id' => $value['employee_sbu'],'unit_id' => $value['employee_unit'],'sub_unit_id' => $value['employee_sub_unit'],'dep_id' => $value['employee_department']]);

            array_push($data['sub_section_data'], ['sub_section_priority' => $value['sub_section_priority'],'id' => $value['employee_sub_section'], 'text' => $value['sub_section_name'],'sbu_id' => $value['employee_sbu'],'unit_id' => $value['employee_unit'],'sub_unit_id' => $value['employee_sub_unit'],'dep_id' => $value['employee_department'],'section_id' => $value['employee_section']]);

            array_push($data['work_location_data'], ['work_priority' => $value['work_priority'],'id' => $value['employee_work_location'], 'text' => $value['work_location_name'],'sbu_id' => $value['employee_sbu'],'unit_id' => $value['employee_unit'],'sub_unit_id' => $value['employee_sub_unit'],'dep_id' => $value['employee_department'],'section_id' => $value['employee_section'],'sub_section_id' => $value['employee_sub_section']]);

            array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . ' - ' . $value['employee_fullname'],'sbu_id' => $value['employee_sbu'],'unit_id' => $value['employee_unit'],'sub_unit_id' => $value['employee_sub_unit'],'dep_id' => $value['employee_department'],'section_id' => $value['employee_section'],'work_id' => $value['employee_work_location']]);

            // array_push($data['employee_group_data'], ['id' => $value['id'], 'text' => $value['employee_group_name']]);

            // array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
            // array_push($data['jobgrade_data'], ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        }

        $data['Allcompany_sbu_data'] =collect(collect($data['company_sbu_data'])->sortBy('sub_priority')->toArray())->all();
        $data['Allunit_data'] = collect(collect($data['unit_data'])->sortBy('units_priority')->toArray())->all();
        $data['Allsub_unit_data'] = collect(collect($data['sub_unit_data'])->sortBy('su_units_priority')->toArray())->all();
        $data['Alldepartment_data'] =collect(collect($data['department_data'])->sortBy('dep_priority')->toArray())->all();
        $data['Allsection_data'] =  collect(collect($data['section_data'])->sortBy('section_priority')->toArray())->all();
        $data['Allsub_section_data'] = collect(collect($data['sub_section_data'])->sortBy('sub_section_priority')->toArray())->all();
        $data['Allwork_location_data'] = collect(collect($data['work_location_data'])->sortBy('work_priority')->toArray())->all();
        $data['Allemployee_data'] =collect(collect($data['employee_data'])->sortBy('employee_id_no')->toArray())->all();

        $data['company_sbu_data'] =collect(collect($data['company_sbu_data'])->sortBy('sub_priority')->toArray())->unique('id')->values()->all();
        $data['unit_data'] = collect(collect($data['unit_data'])->sortBy('units_priority')->toArray())->unique('id')->values()->all();
        $data['sub_unit_data'] = collect(collect($data['sub_unit_data'])->sortBy('su_units_priority')->toArray())->unique('id')->values()->all();
        $data['department_data'] = collect(collect($data['department_data'])->sortBy('dep_priority')->toArray())->unique('id')->values()->all();
        $data['section_data'] =  collect(collect($data['section_data'])->sortBy('section_priority')->toArray())->unique('id')->values()->all();
        $data['sub_section_data'] = collect(collect($data['sub_section_data'])->sortBy('sub_section_priority')->toArray())->unique('id')->values()->all();
        $data['work_location_data'] = collect(collect($data['work_location_data'])->sortBy('work_priority')->toArray())->unique('id')->values()->all();
        $data['employee_data'] = collect(collect($data['employee_data'])->sortBy('employee_id_no')->toArray())->unique('id')->values()->all();

        // $data['designation_data'] = $data['company_sbu_data']->unique('employee_sbu');
        // $data['jobgrade_data'] = $data['company_sbu_data']->unique('employee_sbu');

        // $data['employee_data_approval'] = $data['company_sbu_data']->unique('employee_sbu');

        return $data;
        // collect()->pluck();
    }

    public function report_filter($data)
    {
        return response()->json($data);
    }

    public function sbu()
    {
        return $this->belongsTo(CompanySbu::class, 'employee_sbu');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'employee_department');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'employee_designation');
    }

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class, 'floor_number', 'id');
    }

    public function reporting(): BelongsTo
    {
        return $this->belongsTo(self::class, 'employee_reporting_to', 'employee_id_no');
    }
}
