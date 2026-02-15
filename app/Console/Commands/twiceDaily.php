<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;
use DateTime;
// use App\Console\Commands\CarbonPeriod;


class twiceDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dummy:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attendance will update daily!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        try {
            DB::beginTransaction();
            $from_date_formated =date('Y-m-d');
            //    date('Y-m-d');
            //    date('Y-m-d');
                // date('Y-m-d');
                // date('Y-m-d') ;
                // date('Y-m-d')
            $emplyIds=DB::table('employees') ->where('valid',1)->where('employee_status',1)->pluck('id')->toarray();
            $resignationsEmpId=DB::table('resignations')->where('resignation_status',2)->where('effective_date','>=',$from_date_formated)->pluck('employee_id')->toarray();
            
            $allemplyid=array_merge($emplyIds, $resignationsEmpId);

            $employee_info=DB::table('employees')
                            ->select('employees.id','employees.employee_id_no','employees.employee_fullname as employee_full_name','employees.employee_sbu','employees.employee_section','employees.employee_department','employees.employee_designation','employees.employee_sub_unit','employees.employee_sub_unit')
                            // ->valid()
                            ->whereIn('id',$allemplyid)
                            ->get()->toArray();
            $employee_ids=collect($employee_info)->pluck('employee_id_no')->toArray();  
            $employee_primary_ids=collect($employee_info)->pluck('id')->toArray();


                $attendance_data= DB::table('attendance_log')
                                ->whereIn('employee_id', $employee_ids)
                                ->where('TransactionDate', $from_date_formated)
                                ->where('valid', '=', 1)
                                ->get()->toArray();
                $manulAttendance=DB::table('manual_attendances')
                                ->whereIn('employee_id_no', $employee_ids)
                                ->where('manual_attendance_date', $from_date_formated)
                                ->where('manual_attendance_status',1)
                                ->where('valid', '=', 1)
                                ->get()->toArray();

                $attendanceTime = DB::table('attendance_setups')
                                    ->select('attendance_setups.*','office_time_setups.office_start_time as office_start_time','office_time_setups.office_end_time as office_end_time','office_time_setups.lateConsiderTime as lateConsiderTime','office_time_setups.office_type as office_type','office_time_setups.type as type')
                                    ->leftJoin('office_time_setups','office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
                                    ->whereIn('attendance_setups.employee_id', $employee_primary_ids)
                                    // ->where('office_time_end_date','>=',$from_date_formated)
                                    // ->where('office_time_start_date','<=',$from_date_formated)
                                    ->where('start_date','>=',$from_date_formated)
                                    ->where('end_date','<=',$from_date_formated)
                                    ->get(); 
                $approve_late_request =DB::table('late_approve_requests')
                                    ->whereIn('employee_id', $employee_primary_ids)
                                    ->where('late_date', $from_date_formated)
                                    ->where('late_approve_status', '=', 2)
                                    ->get();

                $company_sbu_data=DB::table('company_sbus')->get(); 


                //  $approve_late_find = array();
                //  if ($approve_late_request) {
                //      foreach ($approve_late_request as $date) {
                //          array_push($approve_late_find, $date->late_date); 
                //      }
                //  }

                $holidayFind = DB::table('holiday_setups')
                                    ->select('holiday_setups.*')
                                    ->where('holiday_start_date', $from_date_formated)
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
                $indLeaveInfo1 =DB::table('leave_applications')
                            ->leftJoin('leave_types','leave_types.id','=','leave_applications.leave_type')
                            ->where('leave_from_date', $from_date_formated)
                            ->whereIn('employee_id', $employee_primary_ids)
                            ->where('leave_applications.leave_apply_status', '=', 2)
                            ->get();          
                // $ind_leave_info = array(); 
                // if ($indLeaveInfo) {
                //     foreach ($indLeaveInfo as $key => $value) {
                //         $period_live = CarbonPeriod::create($value->leave_from_date, $value->leave_to_date);
                //         foreach ($period_live as $date) {
                //             array_push($ind_leave_info, $date->format('Y-m-d')); 
                //         }
                //     }
                    
                // }

            $pay_days_count = 0;
                $holiday_count = 0;
                $leave_count = 0;
                $present_day_count = 0;
                $late_day_count = 0;
                $absent_day_count = 0;
                $total_late_time = 0;
                $total_work_time = 0;

                $late_times = array();
                $work_times = array();
                $dataLength = 0; 
                $attendance_dataNew=[];
                //$attendances=[];
                $from_date_formated = date('Y-m-d', strtotime($from_date_formated));
                $emaploeeAttendall=DB::table('attendance')->where('pdate',$from_date_formated)->get()->toArray();  

                foreach($employee_info as $key => $value){

                $indLeaveInfo=collect($indLeaveInfo1)->where('employee_id',$value->id)->toArray();
                $ind_leave_info = array(); 
                if ($indLeaveInfo) {
                    foreach ($indLeaveInfo as $key => $value_a) {
                        $period_live = CarbonPeriod::create($value_a->leave_from_date, $value_a->leave_to_date);
                        foreach ($period_live as $date) {
                            array_push($ind_leave_info, $date->format('Y-m-d')); 
                        }
                        
                    }
                        
                }

                    $attendance_time=collect($attendanceTime)->where('employee_id',$value->id)->first();
                    $companySbu_data=collect($company_sbu_data)->where('id',$value->employee_sbu)->first();
                    $weekend= explode(",",$companySbu_data->weekend);

                    $attendance_time=collect($attendanceTime)->where('employee_id',$value->id)
                                    ->where('start_date','<=',$from_date_formated)
                                    ->where('end_date','>=',$from_date_formated)
                                        ->first();

                    if(empty($attendance_time)){
                    $attendance_time=$companySbu_data;
                    $attendance_time->office_type=1;
                    $attendance_time->type=1;
                    
                    }

                    $approve_lateRequest=collect($approve_late_request)->where('employee_id', $value->id)->toArray();

                    $approve_late_find = array();
                    if ($approve_late_request) {
                    foreach ($approve_lateRequest as $date) {
                        array_push($approve_late_find, $date->late_date);
                        
                    }
                    }
                
                // exit();
                    $intime=collect(collect($attendance_data)->where('TransactionDate',$from_date_formated)->where('employee_id',$value->employee_id_no)->sortBy('id')->values()->all())->first();
                    $outtime=collect(collect($attendance_data)->where('TransactionDate',$from_date_formated)->where('employee_id',$value->employee_id_no)->sortByDesc('id')->values()->all())->first();
                    $manulAttendances=collect($manulAttendance)->where('manual_attendance_date',$from_date_formated)->where('employee_id_no',$value->employee_id_no)->first();
                    $office_start_time = isset($attendance_time->office_start_time)?$attendance_time->office_start_time:'00:00:00';
                    $office_end_time = isset($attendance_time->office_end_time)?$attendance_time->office_end_time:'00:00:00';
                
                if(!empty($attendance_time)){
                    if(!empty($manulAttendances)){
                        $intimes =date('H:i', strtotime($manulAttendances->manual_start_time));
                        $outtimes =date('H:i', strtotime($manulAttendances->manual_end_time));

                        // if(!empty($attendance_time->lateConsiderTime)){
                        //      $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                        //  }else{
                        //      $lateConsiderTime=strtotime($office_start_time);
                        //  }
                            if(!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))){
                                $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                            }else{
                                $lateConsiderTime=date('H:i', strtotime($office_start_time));
                            }

                        if (strtotime($intimes) <=  strtotime($lateConsiderTime)) {
                                $late_time = '00:00';
                                $status="Present";
                                $statusId=1;
                        }else{
                            if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
                                $late_time = strtotime($intimes) - strtotime($office_start_time);
                                $late_time = date('H:i',$late_time);
                                $status="Late(Approved)";
                                $statusId=1;
                            }else{
                                $late_time = strtotime($intimes) - strtotime($office_start_time);
                                $late_time = date('H:i',$late_time);
                                $status="Late";
                                $statusId=2;
                            }
                        }

                        $work_time = strtotime($outtimes) - strtotime($intimes);
                        $attendances=[
                                "machineno"=>0,
                                "uploadid"=>0,
                                "employee_id"=>$value->id,
                                "employee_card_no"=>$value->employee_id_no,
                                "pdate"=>$from_date_formated,
                                "intime" => $intimes,
                                "outime" => $outtimes,
                                "latetime"=>$late_time,
                                "start_time" => date('H:i', strtotime($office_start_time)),
                                "end_time" => date('H:i', strtotime($office_end_time)),
                                "pstatus"=>$statusId,
                                "status"=>1,
                                "remarks"=>$status,
                                "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                            ];  


                    }else if($attendance_time->type==2){

                        if(!empty($intime) && !empty($outtime)){
                            $intimes =date('H:i', strtotime($intime->TransactionTime));
                            $outtimes =date('H:i', strtotime($outtime->TransactionTime));
                            
                            if($attendance_time->office_type ==2){
                                $status="Weekend";
                                $statusId=1;
                                $late_time = '00:00';
                            }else{
                                // if(!empty($attendance_time->lateConsiderTime)){
                                //     $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                                // }else{
                                //     $lateConsiderTime=strtotime($office_start_time);
                                // }
                                if(!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))){
                                    $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                                }else{
                                    $lateConsiderTime=date('H:i', strtotime($office_start_time));
                                }
                                if (strtotime($intimes) <=  strtotime($lateConsiderTime)) {
                                    $late_time = '00:00';
                                    $status="Present";
                                    $statusId=1;
                                }else{
                                    if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
                                        $late_time = strtotime($intimes) - strtotime($office_start_time);
                                        $late_time = date('H:i',$late_time);
                                        $status="Late(Approved)";
                                        $statusId=1;
                                    }else{
                                        $late_time = strtotime($intimes) - strtotime($office_start_time);
                                        $late_time = date('H:i',$late_time);
                                        $status="Late";
                                        $statusId=2;
                                    }
                                }

                            }
                            $work_time = strtotime($outtimes) - strtotime($intimes);

                            $attendances=[
                                "machineno"=>0,
                                "uploadid"=>0,
                                "employee_id"=>$value->id,
                                "employee_card_no"=>$value->employee_id_no,
                                "pdate"=>$from_date_formated,
                                "intime" => $intimes,
                                "outime" => $outtimes,
                                "latetime"=>$late_time,
                                "start_time" => date('H:i', strtotime($office_start_time)),
                                "end_time" => date('H:i', strtotime($office_end_time)),
                                "pstatus"=>$statusId,
                                "status"=>1,
                                "remarks"=>$status,
                                "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                            ];  



                        }else{
                            if ($attendance_time->office_type==2) {
                                $status="Weekend";
                                $statusId=4;

                            }elseif (!empty($holiday_find) && in_array($from_date_formated, $holiday_find)) {
                                $status="Holiday";
                                $statusId=5;
                            }elseif (!empty($ind_leave_info) && in_array($from_date_formated, $ind_leave_info)) {
                                $laveType=collect($indLeaveInfo)->where('leave_from_date','<=',$from_date_formated)->where('leave_to_date','>=',$from_date_formated)->first();
                                $status=$laveType->leave_short_type;
                                $statusId=6;
                            }else{
                                $status="Absent";
                                $statusId=3;
                            }

                            $attendances=[
                                "machineno"=>0,
                                "uploadid"=>0,
                                "employee_id"=>$value->id,
                                "employee_card_no"=>$value->employee_id_no,
                                "pdate"=>$from_date_formated,
                                "intime" => '00:00:00',
                                "outime" => '00:00:00',
                                "latetime"=>'00:00:00',
                                "start_time" => date('H:i', strtotime($office_start_time)),
                                "end_time" => date('H:i', strtotime($office_end_time)),
                                "pstatus"=>$statusId,
                                "status"=>1,
                                "remarks"=>$status,
                                "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                            ];  

                        }


                    }else{

                        if(!empty($intime) && !empty($outtime)){
                            $intimes =date('H:i', strtotime($intime->TransactionTime));
                            $outtimes =date('H:i', strtotime($outtime->TransactionTime));
                            
                            if(in_array(date('D',strtotime($from_date_formated)), $weekend)){
                                $status="Weekend";
                                $statusId=1;
                                $late_time = '00:00';
                            }else{
                                //  if(!empty($attendance_time->lateConsiderTime)){
                                //     $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                                // }else{
                                //     $lateConsiderTime=strtotime($office_start_time);
                                // }
                                if(!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))){
                                    $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                                }else{
                                    $lateConsiderTime=date('H:i', strtotime($office_start_time));
                                }

                                if (strtotime($intimes) <=  strtotime($lateConsiderTime)) {
                                    $late_time = '00:00';
                                    $status="Present";
                                    $statusId=1;
                                }else{

                                    if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
                                        $late_time = strtotime($intimes) - strtotime($office_start_time);
                                        $late_time = date('H:i',$late_time);
                                        $status="Late(Approved)";
                                        $statusId=1;
                                    }else{
                                        $late_time = strtotime($intimes) - strtotime($office_start_time);
                                        $late_time = date('H:i',$late_time);
                                        $status="Late";
                                        $statusId=2;
                                    }
                                }

                            }
                            $work_time = strtotime($outtimes) - strtotime($intimes);

                            $attendances=[
                                "machineno"=>0,
                                "uploadid"=>0,
                                "employee_id"=>$value->id,
                                "employee_card_no"=>$value->employee_id_no,
                                "pdate"=>$from_date_formated,
                                "intime" => $intimes,
                                "outime" => $outtimes,
                                "latetime"=>$late_time,
                                "start_time" => date('H:i', strtotime($office_start_time)),
                                "end_time" => date('H:i', strtotime($office_end_time)),
                                "pstatus"=>$statusId,
                                "status"=>1,
                                "remarks"=>$status,
                                "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                            ];  



                        }else{
                            if ((in_array(date('D',strtotime($from_date_formated)), $weekend))) {
                                $status="Weekend";
                                $statusId=4;
                                $late_time = '00:00';

                            }elseif (!empty($holiday_find) && in_array($from_date_formated, $holiday_find)) {
                                $status="Holiday";
                                $statusId=5;
                                $late_time = '00:00';
                            }elseif (!empty($ind_leave_info) && in_array($from_date_formated, $ind_leave_info)) {
                                $laveType=collect($indLeaveInfo)->where('leave_from_date','<=',$from_date_formated)->where('leave_to_date','>=',$from_date_formated)->first();
                                $status=$laveType->leave_short_type;
                                $statusId=6;
                            }else{
                                $status="Absent";
                                $statusId=3;
                                $late_time = '00:00';
                            }

                            $attendances=[
                                "machineno"=>0,
                                "uploadid"=>0,
                                "employee_id"=>$value->id,
                                "employee_card_no"=>$value->employee_id_no,
                                "pdate"=>$from_date_formated,
                                "intime" => '00:00:00',
                                "outime" => '00:00:00',
                                "latetime"=>'00:00:00',
                                "start_time" => date('H:i', strtotime($office_start_time)),
                                "end_time" => date('H:i', strtotime($office_end_time)),
                                "pstatus"=>$statusId,
                                "status"=>1,
                                "remarks"=>$status,
                                "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                            ];  

                        }


                    }
                }


                $emaploeeAttends = collect($emaploeeAttendall)
                ->where('employee_card_no', $value->employee_id_no)
                ->where('employee_id', $value->id)
                ->where('pdate', $from_date_formated)
                ->first();
                $as =0;  
                    if(!empty($emaploeeAttends)){
                        $aaa=DB::table('attendance')
                                    ->where('employee_card_no',$value->employee_id_no)
                                    ->where('employee_id',$value->id)
                                    ->where('pdate',$from_date_formated)
                                    ->update($attendances);
                                    $as = 1;
        
                    }else{

                        DB::table('attendance')->insert($attendances);
                        //$attendance_dataNew[]=$attendances;
                        $as = 1;
                    }



                }

           // $dd=DB::table('attendance')->insert($attendance_dataNew);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }


  \Log::info("Cron is working fine!");
      exit();


        



    }
}
