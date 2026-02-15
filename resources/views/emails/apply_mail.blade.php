<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Application Received {{ $candidate->position->designation_name }}</title>
  <style>
    /* Basic resets for email clients */
    body, table, td, a { -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
    table, td { mso-table-lspace:0pt; mso-table-rspace:0pt; }
    img { -ms-interpolation-mode:bicubic; display:block; border:0; outline:none; text-decoration:none; }
    body { margin:0; padding:0; width:100% !important; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif; }
    .preheader { display:none !important; visibility:hidden; opacity:0; color:transparent; height:0; width:0; }
    .container { width:100%; max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; }
    .spacer { height:24px; line-height:24px; font-size:1px; }
    .header { padding:20px; text-align:left; background: #ffffff; }
    .logo { max-width:160px; height:auto; }
    .content { padding:24px; color:#1f2937; font-size:16px; line-height:1.5; }
    .h1 { font-size:20px; font-weight:700; color:#0f172a; margin:0 0 8px 0; }
    .muted { color:#6b7280; font-size:14px; }
    .button { display:inline-block; padding:12px 20px; border-radius:6px; text-decoration:none; font-weight:600; }
    .btn-primary { background:#2563eb; color:#ffffff; }
    .footer { padding:18px 24px; font-size:13px; color:#6b7280; text-align:center; background: #fbfdff; }
    @media screen and (max-width:480px) {
      .content { padding:16px; font-size:15px; }
      .header { padding:16px; }
    }
  </style>
</head>
<body>
  <!-- preheader text (shows in inbox preview) -->
  <div class="preheader">We’ve received your application for {{ $candidate->position->designation_name }} — thank you for applying to {{$candidate->company->sbu_name}}.</div>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td align="center" style="padding:20px;">
        <table role="presentation" class="container" cellpadding="0" cellspacing="0" border="0">
          <!-- Header / Logo -->

          <!-- Body -->
          <tr>
            <td class="content">
              <p style="margin:0 0 12px 0;" class="h1">Application Received - {{$candidate->position->designation_name}}</p>

              <p style="margin:0 0 8px 0;" class="muted">
                Dear <strong>{{$candidate->jac_candidate_name}}</strong>,
              </p>

              <p style="margin:0 0 12px 0;">
                Thank you for applying for the position of <strong>{{$candidate->position->designation_name}}</strong> at <strong>{{$candidate->company->sbu_name}}</strong>.
                We have successfully received your application through our career portal.
              </p>

              <p style="margin:0 0 12px 0;">
                Our recruitment team will review your profile and, if shortlisted, we will contact you for the next steps in the selection process.
              </p>

              <p style="margin:0 0 16px 0;">
                We truly appreciate your interest in this position and wish you the very best in your career journey.
              </p>

              <p style="margin:0;">
                Best regards,<br>
                <strong>HR Department</strong><br>
                {{$candidate->company->sbu_name}}
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td class="footer">
              If you did not apply or believe this message was sent in error, please contact us at
              <a href="mailto:mail.gemcongroup.com" style="color:#2563eb; text-decoration:none;">hr@gemcongroup.com</a>.
              <div style="height:8px;"></div>
              © <span id="year">2025</span> {{$candidate->company->sbu_name}}. All rights reserved.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
