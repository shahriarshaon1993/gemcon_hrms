<!DOCTYPE html>

<html>
<body style="margin:0; padding:0; background-color:#f4f6f9; font-family: Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9; padding:30px 0;">
    <tr>
        <td align="center">

            ```
            <!-- Container -->
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden;">

                <!-- Header (FIXED COLOR MATCH) -->
                <tr>
                    <td style="background:#2196f3; padding:25px;">
                        <table width="100%">
                            <tr>
                                <td align="left">
                                    <img src="https://hrms.gemconit.com/asset/gemcon-logo.png" width="90">
                                </td>
                                <td align="right">
                                    <img src="https://hrms.gemconit.com/company_logo/{{$employee->sbu->sbu_logo}}" width="90">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td align="center" style="padding:50px 25px; background:#2196f3; color:#ffffff;">

                        <!-- Profile Image FIXED (NO OVAL ISSUE) -->
                        <table cellpadding="0" cellspacing="0" style="margin-bottom:30px;">
                            <tr>
                                <td align="center" width="180" height="180" style="border-radius:50%; overflow:hidden; border:5px solid #ffffff;">
                                    <img src="https://hrms.gemconit.com/images/{{$employee->employee_image}}"
                                         width="180" height="180"
                                         style="display:block;">
                                </td>
                            </tr>
                        </table>

                        <!-- Title (SIMPLE BUT CLEAN) -->

                        <div style="font-size:72px; color:#ffffff; font-weight:500; line-height:1; font-family: 'Brush Script MT', 'Segoe Script', 'Lucida Handwriting', cursive;">
                            Happy
                        </div>

                        <!-- BIRTHDAY (same strong corporate style) -->
                        <div style="font-size:38px; letter-spacing:3px; color:#ffb300; font-weight:bold; line-height:1.2;">
                            BIRTHDAY
                        </div>

                        <!-- Name -->
                        <div style="background:#ffffff; color:#333; display:inline-block; padding:12px 25px; border-radius:6px; margin:25px 0;">
                            <strong style="font-size:20px;">{{$employee->employee_fullname}}</strong>
                        </div>

                        <!-- Message (UNCHANGED TEXT) -->
                        <p style="font-size:16px; line-height:1.8; margin-top:20px; max-width:420px;">
                            Wishing you good health, happiness and a prosperous year ahead. May all your dreams come true and success follow you in every step.
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td align="center" style="background:#ffb300; padding:18px; color:#ffffff; font-size:13px;">
                        © {{ \Carbon\Carbon::now()->year }} {{$employee->sbu->sbu_name}}. All rights reserved.
                    </td>
                </tr>

            </table>
            ```

        </td>
    </tr>
</table>

</body>
</html>
