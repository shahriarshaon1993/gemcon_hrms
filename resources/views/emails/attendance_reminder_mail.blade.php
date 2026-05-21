<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        /* Reset some default styles */
        body, h1, p {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            margin-bottom: 20px;
        }

        .mt-1 {
            margin-top: 1rem;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: end;
        }

        .text-xl {
            font-size: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #0056b3;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        tr.bg-early-out {
            background-color: #ffd6d8;
        }

        tr.bg-present {
            background-color: #d6ffdf;
        }

        tr.bg-late {
            background-color: #ffe8a2;
        }

        tr.bg-absent {
            background-color: #ffc8cd;
        }

        tr.bg-holiday,
        tr.bg-weekend {
            background-color: #cacaca;
        }

        tr.bg-leave {
            background-color: lightskyblue;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 3px;
        }
    </style>
</head>
<body>
<div class="email-container">
    <p>Attendance record of {{$employee->employee_fullname}} from {{date("01 M Y")}} to {{date("d M Y")}}</p>

    <div class="summery">
        <table style="width: 100%">
            <tr>
                <th class="text-center" colspan="2">In Last {{$totalDays}} Days</th>
            </tr>
            <tr>
                <td>Late Present</td>
                <td class="text-center">
                    {{$attendanceStatus['late_present']}}

                    @if($attendanceStatus['total_late_approve'])
                        (Approved by {{$employee->reporting->employee_fullname}}
                        Sir {{$attendanceStatus['total_late_approve']}})
                    @endif
                </td>
            </tr>
            <tr>
                <td>Early Out</td>
                <td class="text-center">{{$attendanceStatus['total_early_out']}}</td>
            </tr>
            <tr>
                <td>Absent</td>
                <td class="text-center">{{$attendanceStatus['total_absent']}}</td>
            </tr>
            <tr>
                <td>Leave</td>
                <td class="text-center">
                    {{$attendanceStatus['total_leave'] == 0 ? 'N/A' : $attendanceStatus['total_leave'] . ' (Approved by ' . $employee->reporting->employee_fullname . ' Sir)' }}
                </td>
            </tr>
        </table>
    </div>

    <div class="details mt-1">
        <table>
            <tr>
                <th class="text-center text-xl" colspan="7">
                    {{ $employee->sbu->sbu_name }}
                </th>
            </tr>
            <tr>
                <th class="text-center" colspan="7">
                    Department: {{$employee->department->department_name ?? 'N/A'}}
                </th>
            </tr>
            <tr>
                <td class="text-center" colspan="7">
                    Individual Attendance Report of
                    <strong>
                        {{$employee->employee_fullname}}, {{$employee->designation->designation_name ?? 'N/A'}}
                    </strong>
                </td>
            </tr>
            <tr>
                <td class="text-center" colspan="7">
                    {{date("01 M Y")}} to {{date("d M Y")}}
                </td>
            </tr>
            <tr>
                <th class="text-center">SL</th>
                <th class="text-center">Date</th>
                <th class="text-center">In Time</th>
                <th class="text-center">Remarks</th>
                <th class="text-center">Out Time</th>
                <th class="text-center">Remarks</th>
            </tr>

            @foreach($attendances as $attendance)
                @php
                    $inTime = strtotime($attendance->intime);
                    $outTime = strtotime($attendance->outime);
                    $endTime = strtotime($attendance->end_time);
                    $presentDate = strtotime($attendance->pdate);
                    $currentDate = strtotime(date('d-m-Y'));

                    if ($inTime === $outTime) {
                        $outTime = 0;
                    }

                    $workHours = date('H:i', $outTime - $inTime);

                    $isEarlyOut = \App\Helper\Helper::isEarlyOut($attendance);
                    $dailyStatus = \App\Helper\Helper::dailyStatus($attendance);
                @endphp
                <tr class="{{$dailyStatus}}">
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td class="text-center">{{$attendance->pdate->format('d M Y')}}</td>
                    <td class="text-right">{{date('H:i', strtotime($attendance->intime))}}</td>

                    <td>
                        @if($attendance->pstatus == 1)
                            <span title="Present">Present</span>
                        @endif
                        @if($attendance->pstatus == 2)
                            <span title="Late">Late</span>
                        @endif
                        @if($attendance->pstatus == 3)
                            <span title="Absent">Absent</span>
                        @endif
                        @if($attendance->pstatus == 4)
                            <span title="Weekend">Weekend</span>
                        @endif
                        @if($attendance->pstatus == 5)
                            <span title="Holiday">Holiday</span>
                        @endif
                        @if($attendance->pstatus == 6)
                             <span title="Leave">Leave</span>
                        @endif
                    </td>

                    <td class="text-right">{{date('H:i', $outTime)}}</td>

                    <td>
                        @if($attendance->pstatus == 1 && !$isEarlyOut)
                            <span title="Present">Present</span>
                        @endif
                        @if($attendance->pstatus == 2 && !$isEarlyOut)
                            <span title="Late">Late</span>
                        @endif
                        @if($attendance->pstatus == 3)
                            <span title="Absent">Absent</span>
                        @endif
                        @if($attendance->pstatus == 4)
                            <span title="Weekend">Weekend</span>
                        @endif
                        @if($attendance->pstatus == 5)
                            <span title="Holiday">Holiday</span>
                        @endif
                        @if($attendance->pstatus == 6)
                            <span title="Leave">Leave</span>
                        @endif
                        @if($isEarlyOut)
                            <span title="Early Out">Early Out</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

{{--    <p>This is a sample email template. You can customize it as per your requirements.</p>--}}

{{--    <p>Thank you,<br>Your Name</p>--}}
</div>
</body>
</html>
