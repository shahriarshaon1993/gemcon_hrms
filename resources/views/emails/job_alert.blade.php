<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Job Opening at Gemcon Group</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:30px 0;">
    <tr>
        <td align="center">

            <!-- Main Container -->
            <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                <!-- Header -->
                <tr>
                    <td style="background-color:#fafafa; padding:20px 30px; border-bottom:1px solid #e6e6e6;">
                        <a href="https://www.gemcongroup.com" target="_blank" style="text-decoration:none;">
                            <img src="https://gemcongroup.com/wp-content/uploads/2018/04/logo_gemcon.png"
                                 alt="Gemcon Group"
                                 style="width:130px; height:auto; display:block;">
                        </a>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px; color:#333333; font-size:15px; line-height:1.6;">

                        @php
                            $name = $data['name'] ?? null;
                            $deadline = isset($data['deadline']) ? \Carbon\Carbon::parse($data['deadline'])->format('d M Y') : 'N/A';
                        @endphp

                        @if(!empty($name))
                            <p style="margin-top:0;">
                                Dear <strong>{{ $name }}</strong>,
                            </p>
                        @else
                            <p style="margin-top:0;">Hello,</p>
                        @endif

                        <p>
                            We’re pleased to inform you that <strong>Gemcon Group</strong> has published a new job opening that may match your profile.
                        </p>

                        <p>
                            You are receiving this notification because you previously applied or registered through our career portal.
                        </p>

                        <p style="margin:20px 0 10px; font-weight:bold;">
                            🔔 New Job Opening
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
                            <tr>
                                <td style="padding:6px 0;"><strong>Position:</strong></td>
                                <td style="padding:6px 0;">{{ $data['position'] }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;"><strong>Department:</strong></td>
                                <td style="padding:6px 0;">{{ $data['department'] }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;"><strong>Location:</strong></td>
                                <td style="padding:6px 0;">{{ $data['location'] }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;"><strong>Application Deadline:</strong></td>
                                <td style="padding:6px 0;">
                                    {{ $deadline }}
                                </td>
                            </tr>
                        </table>

                        <p>
                            We encourage you to review the details and apply if the role aligns with your skills and career goals.
                        </p>

                        <!-- CTA Button -->
                        <p style="margin:25px 0;">
                            <a href="https://hrms.gemconit.com/career" target="_blank"
                               style="background-color:#0a3d62; color:#ffffff; text-decoration:none; padding:12px 22px; border-radius:5px; display:inline-block; font-weight:bold;">
                                👉 Apply Now
                            </a>
                        </p>

                        <p>
                            Thank you for your continued interest in career opportunities at <strong>Gemcon Group</strong>.
                            We look forward to receiving your application.
                        </p>

                        <p style="margin-top:30px;">
                            Warm regards,<br>
                            <strong>Human Resources Team</strong><br>
                            Gemcon Group
                        </p>

                        <p style="margin-top:15px; font-size:13px;">
                            🌐 <a href="https://www.gemcongroup.com" style="color:#0a3d62; text-decoration:none;">www.gemcongroup.com</a>
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color:#f1f3f5; padding:15px 30px; text-align:center; font-size:12px; color:#666666;">
                        © 2026 Gemcon Group. All rights reserved.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
