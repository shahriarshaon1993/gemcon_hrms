<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Department;
use App\Models\MOS;
use Auth;
use DB;
use Illuminate\Http\Request;

/**
 * Class DepartmentController
 * @package App\Http\Controllers\API
 */

class DashboardAPIController extends AppBaseController
{
    public function index(Request $request)
    {
        $user_data = Auth::guard('user')->user();
        if ($user_data->role_id == 5 || $user_data->role_id == 6 || $user_data->role_id == 7) {
            $request['dept_id'] = $user_data->department;
        }

        $achievement_biulder = MOS::select(DB::Raw('SUM(january) as january, SUM(february) as february
        , SUM(march) as march, SUM(april) as april, SUM(may) as may, SUM(june) as june, SUM(july) as july
        , SUM(august) as august, SUM(september) as september, SUM(october) as october, SUM(november) as november
        , SUM(december) as december'))
            ->join('mos_datas', 'mos_datas.mos_id', 'm_o_s.id');
        if ($request->dept_id) {
            $achievement_biulder->where('m_o_s.dept_id', $request->dept_id);
        }

        if ($request->year) {
            $achievement_biulder->where('m_o_s.year', $request->year);
        }


        $achievement = $achievement_biulder->where('mos_datas.type', 'achievement')->first();

        $target_biulder = MOS::select(DB::Raw('SUM(january) as january, SUM(february) as february
        , SUM(march) as march, SUM(april) as april, SUM(may) as may, SUM(june) as june, SUM(july) as july
        , SUM(august) as august, SUM(september) as september, SUM(october) as october, SUM(november) as november
        , SUM(december) as december'))
            ->join('mos_datas', 'mos_datas.mos_id', 'm_o_s.id');
        if ($request->dept_id) {
            $target_biulder->where('m_o_s.dept_id', $request->dept_id);
        }

        if ($request->year) {
            $target_biulder->where('m_o_s.year', $request->year);
        }

        $target = $target_biulder->where('mos_datas.type', 'target')->first();

        ///$data['target'] = $target;
        $data['target'] = [
            $target->january,
            $target->february,
            $target->march,
            $target->april,
            $target->may,
            $target->june,
            $target->july,
            $target->august,
            $target->september,
            $target->october,
            $target->november,
            $target->december,
        ];
        $january_achv = ($achievement->january > 0 ? $achievement->january : $target->january);

        $february_achv  = ($achievement->february > 0 ? $achievement->february : $target->february);
        $march_achv     = ($achievement->march > 0 ? $achievement->march : $target->march);
        $april_achv     = ($achievement->april > 0 ? $achievement->april : $target->april);
        $may_achv       = ($achievement->may > 0 ? $achievement->may : $target->may);
        $june_achv      = ($achievement->june > 0 ? $achievement->june : $target->june);
        $july_achv      = ($achievement->july > 0 ? $achievement->july : $target->july);
        $august_achv    = ($achievement->august > 0 ? $achievement->august : $target->august);
        $september_achv = ($achievement->september > 0 ? $achievement->september : $target->september);
        $october_achv   = ($achievement->october > 0 ? $achievement->october : $target->october);
        $november_achv  = ($achievement->november > 0 ? $achievement->november : $target->november);
        $december_achv  = ($achievement->december > 0 ? $achievement->december : $target->december);

        $data['achievement'] = [
            $achievement->january,
            $achievement->february,
            $achievement->march,
            $achievement->april,
            $achievement->may,
            $achievement->june,
            $achievement->july,
            $achievement->august,
            $achievement->september,
            $achievement->october,
            $achievement->november,
            $achievement->december,
        ];

        $achievement_with_remaining = [
            $january_achv,
            $february_achv,
            $march_achv,
            $april_achv,
            $may_achv,
            $june_achv,
            $july_achv,
            $august_achv,
            $september_achv,
            $october_achv,
            $november_achv,
            $december_achv,

        ];
        $color     = ['#8601af', '#b5179e', '#be00cc', '#7209b7', '#9600a0', '#4c0052', '#8601af', '#b5179e', '#be00cc', '#7209b7', '#9600a0', '#4c0052'];
        $monthArr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $total_rem = 0;
        $total_achv = 0;

        $data['achievement_with_remaining'] = [];
        $data['color'] = [];
        $data['monthname'] = [];
        for ($l = 0; $l < count($achievement_with_remaining); $l++) {
            if ((int) date('m') > $l) {
                array_push($data['achievement_with_remaining'], $achievement_with_remaining[$l]);
                array_push($data['monthname'], $monthArr[$l]);
                array_push($data['color'], $color[$l]);
                $total_achv += $achievement_with_remaining[$l];
            } else {
                //echo $achievement_with_remaining[$l]. "||";
                $total_rem += $achievement_with_remaining[$l];
                //array_push($data['monthname'], $monthArr[$l]);
                
            }
        }
        if((int) date('m') < count($achievement_with_remaining)){
            array_push($data['monthname'], 'Remaining');
            array_push($data['color'], '#b3b8be');
            array_push($data['achievement_with_remaining'], $total_rem);

        }

        $data['performance_value'] = [$total_achv,$total_rem];
        

        //print_r($data['achievement_with_remaining']);exit;
        // echo $data['achievement_with_remaining'][8];exit;

        // $data['achievement'] = [10,8,9,11,5,0,0,0,0,0,0,0];
        //$data['achievement'] = $achievement;

        return $this->sendResponse($data, 'Departments retrieved successfully');
    }

}
