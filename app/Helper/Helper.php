<?php

namespace App\Helper;

class Helper
{
    public $count = 0;

    public static function isEarlyOut($attendance): bool
    {
        $status = $attendance->pstatus;
        $outTime = strtotime($attendance->outime);
        $endTime = strtotime($attendance->end_time);
        $presentDate = strtotime($attendance->pdate);
        $currentDate = strtotime(date('d-m-Y'));


        if(($presentDate != $currentDate) && ($status == 1 || $status == 2) && ($outTime < $endTime)) {
            return true;
        }

        return false;
    }

    public static function dailyStatus($attendance): string
    {
        $status = $attendance->pstatus;
        $isEarlyOut = self::isEarlyOut($attendance);

        if($isEarlyOut) return 'bg-early-out';
        if ($status == '1') return 'bg-present';
        if ($status == '2') return 'bg-late';
        if ($status == '3') return 'bg-absent';
        if ($status == '4') return 'bg-weekend';
        if ($status == '5') return 'bg-holiday';
        if ($status == '6') return 'bg-leave';

        return 'bg-default';
    }
}
