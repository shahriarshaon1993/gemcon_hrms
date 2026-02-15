<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Interview Confirmation {{ $candidate->position->designation_name }}</title>
    <style>
      /* General resets */
      body { margin: 0; padding: 0; background-color: #f2f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; }
      table { border-collapse: collapse; }
      a { color: #3869D4; text-decoration: none; }

      /* Container */
      .email-wrap { width: 100%; padding: 20px 0; }
      .email-body { width: 100%; max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 6px; overflow: hidden; }
      .email-header { padding: 24px; text-align: left; }
      .logo { max-width: 140px; height: auto; }

      .email-content { padding: 24px; color: #333333; font-size: 16px; line-height: 1.5; }
      .greeting { margin-bottom: 12px; font-weight: 600; }
      .muted { color: #6b7280; font-size: 14px; }

      .btn { display: inline-block; padding: 12px 20px; border-radius: 6px; background-color: #2563EB; color: #ffffff; font-weight: 600; }

      .details { background: #f8fafc; padding: 12px; border-radius: 6px; margin: 16px 0; font-size: 15px; }

      .footer { padding: 16px 24px; font-size: 13px; color: #6b7280; text-align: center; }

      @media (max-width: 420px) {
        .email-content { padding: 16px; font-size: 15px; }
        .email-header { padding: 16px; }
      }
    </style>
  </head>
  <body>
    <table class="email-wrap" width="100%" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center">
          <table class="email-body" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td class="email-content">
                <p class="greeting">Dear <strong>{{ $candidate->jac_candidate_name }}</strong>,</p>

                <p>Thank you for shortlisting me for the <strong>{{ $candidate->position->designation_name }}</strong> role at <strong>{{$candidate->company->sbu_name}}</strong>. I’m excited about the opportunity and would like to confirm my availability for the interview.</p>

                {{-- <div class="details">
                  <p style="margin:6px 0;"><strong>Proposed Date &amp; Time:</strong><br>[Proposed Date &amp; Time]</p>
                  <p style="margin:6px 0;"><strong>Mode:</strong> [In-person / Zoom / Teams / Phone]</p>
                  <p style="margin:6px 0;"><strong>Contact:</strong> [Phone Number] | [Email Address]</p>
                </div> --}}

                <p>If that time works for you, please confirm and share any joining details (link, address, or instructions). If you prefer a different schedule, I’m happy to adjust—please let me know a few alternatives.</p>

                <p>I look forward to discussing how my experience with <em></em> and web application development can contribute to <strong>{{$candidate->company->sbu_name}}</strong>.</p>

                <p style="margin:20px 0 8px;"><a href="mailto:[Email Address]?subject=Interview%20Confirmation%20-%20[Position%20Name]">Confirm via Email</a></p>

                <p class="muted">Best regards,<br>
                <strong>Human Resources</strong><br>
              </td>
            </tr>

          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
