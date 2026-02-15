<?php
namespace App\Mail;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Myclass\PHPMailer;
// use App\Myclass\SMTP;
use PDF;
use DB;

class MailSent extends Model
{
    // public function reportMail($company_id=null, $company_sbus=null, $sbuNames=null, $report_name=null, $date_report=null, $created_by, $column_name_data, $all_data, $column_data)

    public function reportMail($leaveType =null, $leaveReason=null, $totalDays=null, $startDate=null, $endDate=null, $employeeName=null, $employeeId=null, $employeePhone=null, $data=null)
    {
        DB::table('email_templates')->where()->first();
        $data1['company_id'] = $company_id;
        $data1['company_sbus'] = $company_sbus;
        $data1['sbuNames'] = $sbuNames;
        $data1['report_name'] = $report_name;
        $data1['date_report'] = $date_report;
        $data1['created_by'] = $created_by;
        $data1['column_name_data'] = $column_name_data;
        $data1['all_data'] = $all_data;
        $data1['column_data'] = $column_data;
        // ["abdullah@gemconcorp.com","faruk.cse14@gmail.com","faruk.cse14@gmail.com"]
        $data["email"] = ["faruk.cse14@gmail.com"];
        $data["title"] = "Daily Attendance Report";
        $data["body"] = "Please check Your Attach file..";

        $pdf = PDF::loadView('emails.daily_attendance_report', $data1)->setPaper('a4', 'landscape');

        $user_email = 'noreply@gemcongroup.com';
        $send_to = 'faruk.cse14@gmail.com';
        $send_to_name = 'Faruk Khan';
        $user = 'Human Resources Management System';
        $title = 'Leave Applications';
        $name = 'Faruk Khan';
        $name = "Faruk Khan [100407]";

        $data['email'] = 'faruk.cse14@gmail.com';
        $data['title'] = $title;
        $data['name'] = $name;
        // $data['check_user'] = $check_user;
        $message = view('emails.myTestMail', $data);

        $phpMail = new PHPMailer();

        $phpMail->AddAddress($send_to, $send_to_name);
        $phpMail->AddReplyTo($user_email, $user);
        $msg = $message;

        $phpMail->FromName = $user;
        $phpMail->From = $user_email;
        $phpMail->Sender = $user_email;
        $phpMail->IsHTML(true);
        // $phpMail->Host = "172.16.1.2";
        $phpMail->Host = "mail.gemcongroup.com";
        $phpMail->IsSMTP();
        $phpMail->Mailer   = "smtp";
        $phpMail->Subject = 'Leave Applications';
        // (isset($setting_data->mail_subject) ? $setting_data->mail_subject : 'IT Asset Update');
        $phpMail->Body = $msg;
        $phpMail->addStringAttachment($pdf->output(), "text.pdf");
        // $phpMail->AddEmbeddedImage('img/2u_cs_mini.jpg', 'logo_2u');
        // $phpMail->AddEmbeddedImage('../images/namDiams.png', 'logoimg', 'namDiames.png');//the last param the second 'a' was missing...


        $phpMail->SMTPAuth = true;
        $phpMail->Username = "noreply@gemcongroup.com";
        $phpMail->Password = "sfftw6";
        $phpMail->Port = 465;
        $msg = "";
        $phpMail->Send();
        $phpMail->ClearAddresses();
        $phpMail->ClearAttachments();
    }

    public function manualAttendance(
        $attendanceIssues = null, 
        $attendanceDate = null, 
        $startTime=null, 
        $endtime=null, 
        $manualRemarks=null,
        $ea_approve_by=[], 
        $employeeId=null)
    {
        $templates = DB::table('email_templates')->where('template_name','manual_ attendance')->first();

        $emplyInfo = DB::table('employees')->where('id',$employeeId)->first();

        $sendCCMail = collect(DB::table('email_templates_cc_info')->where('email_template_id', $templates->id)->where('company_id', $emplyInfo->employee_sbu)->get())->pluck('employee_wise_cc')->toarray();

        $approveInfo = collect(DB::table('employees')->whereIn('id', $ea_approve_by)->get())->pluck('official_email_id')->toarray();

        if(!empty($templates->email_to)){
            $mailTo = explode(',', $templates->email_to);
        }else{
            $mailTo = [];
        }

        if(!empty($templates->email_cc)){
            $sendCommonCCMail = explode(',', $templates->email_cc);
        }else{
            $sendCommonCCMail = [];
        }

        if(!empty($templates->email_bcc)){
            $sendBCCMails = explode(',', $templates->email_bcc);
        }else{
            $sendBCCMails = [];
        }

        
        // $sendCCMail = explode(',', $templates->employee_wise_cc);
        
        // $sendCommonCCMail = explode(',', $templates->email_cc);
        
        // $sendBCCMail = explode(',', $templates->email_bcc);

        $sendToMail = array_merge($approveInfo, $mailTo);
        $sendCCMail = array_merge($sendCCMail, $sendCommonCCMail);
        $sendBCCMail = $sendBCCMails;

        $data['attendanceIssues'] = $attendanceIssues;
        $data['attendanceDate'] = $attendanceDate;
        $data['startTime'] = $startTime;
        $data['endtime']  = $endtime;
        $data['manualRemarks']  = $manualRemarks;

        $data['employeeName'] = $employeeName = $emplyInfo->employee_fullname;
        $data['employeeId'] = $employeeId = $emplyInfo->employee_id_no;
        $data['employeePhone'] = $employeePhone = $emplyInfo->employee_mobile;


        $data["email"] = $sendToMail;
        $data["title"] = "Manual Attendance Request";
        $data["body"] = $templates->email_body;
        // $pdf = PDF::loadView('emails.daily_attendance_report', $data1)->setPaper('a4', 'landscape');
        $user_email = 'noreply@gemcongroup.com';

        $send_to = $emplyInfo->official_email_id ?? '' ;
        $email_cc = $sendCCMail;
        $email_bcc = $sendBCCMail;
        $send_to_name = $employeeName;
        $user = 'Human Resources Management System';
        $title = 'Manual Attendance Request';
        $data['title'] = $title;
        $data['name'] = $employeeName;

        $message = '';
        eval("\$message = \"$templates->email_body\";");
        $subject ='';
        eval("\$subject = \"$templates->subject\";");


        $phpMail = new PHPMailer();
        $phpMail->AddAddress($send_to, $send_to_name);
        $phpMail->AddReplyTo($user_email, $user);
        foreach ($sendToMail as $key_1 => $value1) {
            $phpMail->AddAddress($value1);
        }
        foreach ($email_cc as $key_1 => $value) {
            $phpMail->addCC($value);
        }
        foreach ($email_bcc as $key_1 => $value) {
            $phpMail->addBCC($value);
        }
        $msg = $message;
        $phpMail->FromName = $user;
        $phpMail->From = $user_email;
        $phpMail->Sender = $user_email;
        $phpMail->IsHTML(true);
        // $phpMail->Host = "172.16.1.2";
        $phpMail->Host = "mail.gemcongroup.com";
        $phpMail->IsSMTP();
        $phpMail->Mailer   = "smtp";
        $phpMail->Subject = $subject;
        $phpMail->Body = $msg;
        $phpMail->SMTPAuth = true;
        $phpMail->Username = "noreply@gemcongroup.com";
        $phpMail->Password = "sfftw6";
        $phpMail->Port = 465;
        $msg = "";
        $phpMail->Send();
        $phpMail->ClearAddresses();
        $phpMail->ClearAttachments();
    }

    public function leaveMail($leaveType =null, $leaveReason=null, $totalDays=null, $startDate=null, $endDate=null, $ea_approve_by=[], $employeeId=null, $data1=null)
    {
        $templates = DB::table('email_templates')->where('template_name','leave')->first();

        $emplyInfo = DB::table('employees')->where('id',$employeeId)->first();

        $sendCCMail = collect(DB::table('email_templates_cc_info')->where('email_template_id', $templates->id)->where('company_id', $emplyInfo->employee_sbu)->get())->pluck('employee_wise_cc')->toarray();


        $approveInfo = collect(DB::table('employees')->whereIn('id', $ea_approve_by)->get())->pluck('official_email_id')->toarray();

        if(!empty($templates->email_to)){
            $mailTo = explode(',', $templates->email_to);
        }else{
            $mailTo = [];
        }

        if(!empty($templates->email_cc)){
            $sendCommonCCMail = explode(',', $templates->email_cc);
        }else{
            $sendCommonCCMail = [];
        }

        if(!empty($templates->email_bcc)){
            $sendBCCMails = explode(',', $templates->email_bcc);
        }else{
            $sendBCCMails = [];
        }

        
        // $sendCCMail = explode(',', $templates->employee_wise_cc);
        
        // $sendCommonCCMail = explode(',', $templates->email_cc);
        
        // $sendBCCMail = explode(',', $templates->email_bcc);

        $sendToMail = array_merge($approveInfo, $mailTo);
        $sendCCMail = array_merge($sendCCMail, $sendCommonCCMail);
        $sendBCCMail = $sendBCCMails;

        $data['totalDays'] = $totalDays;
        $data['leaveType'] = $leaveType;
        $data['leaveReason'] = $leaveReason;
        $data['startDate']  = $startDate;
        $data['endDate']  = $endDate;

        $data['employeeName'] = $employeeName = $emplyInfo->employee_fullname;
        $data['employeeId'] = $employeeId = $emplyInfo->employee_id_no;
        $data['employeePhone'] = $employeePhone = $emplyInfo->employee_mobile;


        $data["email"] = $sendToMail;
        $data["title"] = "Leave Approve Request";
        $data["body"] = $templates->email_body;
        // $pdf = PDF::loadView('emails.daily_attendance_report', $data1)->setPaper('a4', 'landscape');
        $user_email = 'noreply@gemcongroup.com';

        $send_to = $emplyInfo->official_email_id ?? '' ;
        $email_cc = $sendCCMail;
        $email_bcc = $sendBCCMail;
        $send_to_name = $employeeName;
        $user = 'Human Resources Management System';
        $title = 'Leave Applications';
        $data['title'] = $title;
        $data['name'] = $employeeName;

        $message = '';
        eval("\$message = \"$templates->email_body\";");
        $subject ='';
        eval("\$subject = \"$templates->subject\";");


        $phpMail = new PHPMailer();
        $phpMail->AddAddress($send_to, $send_to_name);
        $phpMail->AddReplyTo($user_email, $user);
        foreach ($sendToMail as $key_1 => $value1) {
            $phpMail->AddAddress($value1);
        }
        foreach ($email_cc as $key_1 => $value) {
            $phpMail->addCC($value);
        }
        foreach ($email_bcc as $key_1 => $value) {
            $phpMail->addBCC($value);
        }
        $msg = $message;
        // dd($phpMail);
        $phpMail->FromName = $user;
        $phpMail->From = $user_email;
        $phpMail->Sender = $user_email;
        $phpMail->IsHTML(true);
        // $phpMail->Host = "172.16.1.2";
        $phpMail->Host = "mail.gemcongroup.com";
        $phpMail->IsSMTP();
        $phpMail->Mailer   = "smtp";
        $phpMail->Subject = $subject;
        $phpMail->Body = $msg;
        $phpMail->SMTPAuth = true;
        $phpMail->Username = "noreply@gemcongroup.com";
        $phpMail->Password = "sfftw6";
        $phpMail->Port = 465;
        $msg = "";
        $phpMail->Send();
        $phpMail->ClearAddresses();
        $phpMail->ClearAttachments();
    }

    public function lateMail($in_time =null, $actual_in_time=null, $late_date=null, $late_reason=null, $ea_approve_by=[], $employeeId=null, $data1=null)
    {
        $templates = DB::table('email_templates')->where('template_name','late')->first();

        $emplyInfo = DB::table('employees')->where('id',$employeeId)->first();

        $sendCCMail = collect(DB::table('email_templates_cc_info')->where('email_template_id', $templates->id)->where('company_id', $emplyInfo->employee_sbu)->get())->pluck('employee_wise_cc')->toarray();


        $approveInfo = collect(DB::table('employees')->whereIn('id', $ea_approve_by)->get())->pluck('official_email_id')->toarray();

        if(!empty($templates->email_to)){
            $mailTo = explode(',', $templates->email_to);
        }else{
            $mailTo = [];
        }

        if(!empty($templates->email_cc)){
            $sendCommonCCMail = explode(',', $templates->email_cc);
        }else{
            $sendCommonCCMail = [];
        }

        if(!empty($templates->email_bcc)){
            $sendBCCMails = explode(',', $templates->email_bcc);
        }else{
            $sendBCCMails = [];
        }

        $sendToMail = array_merge($approveInfo, $mailTo);
        $sendCCMail = array_merge($sendCCMail, $sendCommonCCMail);
        $sendBCCMail = $sendBCCMails;

        $sendCommonCCMail = explode(',', $templates->email_cc);
        $sendToMail = array_merge($approveInfo, $mailTo);
        // $data['totalDays'] = $totalDays = 1;
        // $data['leaveType'] = $leaveType = 'Late';
        $data['employeeName'] = $employeeName = $emplyInfo->employee_fullname;
        $data['employeeId'] = $employeeId = $emplyInfo->employee_id_no;
        $data['employeePhone'] = $employeePhone = $emplyInfo->employee_mobile;

        $data['lateDate'] = $lateDate  = $late_date;
        $data['lateReason'] = $lateReason = $late_reason;
        $data['inTime'] = $inTime = $in_time;
        $data['actualInTime'] = $actualInTime = $actual_in_time;

        $data["email"] = $sendToMail;
        $data["title"] = "Late Approve Request";
        $data["body"] = $templates->email_body;
        // $pdf = PDF::loadView('emails.daily_attendance_report', $data1)->setPaper('a4', 'landscape');
        $user_email = 'noreply@gemcongroup.com';

        $send_to = $emplyInfo->official_email_id ?? '' ;
        $email_cc = $sendCCMail;
        $email_bcc = $sendBCCMail;
        $send_to_name = $employeeName;
        $user = 'Human Resources Management System';
        $title = 'Late Approve Request';
        $data['title'] = $title;
        $data['name'] = $employeeName;

        $message = '';
        eval("\$message = \"$templates->email_body\";");
        $subject ='';
        eval("\$subject = \"$templates->subject\";");


        $phpMail = new PHPMailer();
        $phpMail->AddAddress($send_to, $send_to_name);
        $phpMail->AddReplyTo($user_email, $user);
        foreach ($sendToMail as $key_1 => $value1) {
            $phpMail->AddAddress($value1);
        }
        foreach ($email_cc as $key_1 => $value) {
            $phpMail->addCC($value);
        }
        foreach ($email_bcc as $key_1 => $value) {
            $phpMail->addBCC($value);
        }
        $msg = $message;
        $phpMail->FromName = $user;
        $phpMail->From = $user_email;
        $phpMail->Sender = $user_email;
        $phpMail->IsHTML(true);
        // $phpMail->Host = "172.16.1.2";
        $phpMail->Host = "mail.gemcongroup.com";
        $phpMail->IsSMTP();
        $phpMail->Mailer   = "smtp";
        $phpMail->Subject = $subject;
        $phpMail->Body = $msg;
        $phpMail->SMTPAuth = true;
        $phpMail->Username = "noreply@gemcongroup.com";
        $phpMail->Password = "sfftw6";
        $phpMail->Port = 465;
        $msg = "";
        $phpMail->Send();
        $phpMail->ClearAddresses();
        $phpMail->ClearAttachments();
    }

    public function NoteMail($add_note_issues =null, $add_note_date=null, $out_time=null, $return_time=null, $add_note_remarks=null, $ea_approve_by=[], $employeeId=null, $data1=null)
    {
        $templates = DB::table('email_templates')->where('template_name','note')->first();
        $emplyInfo = DB::table('employees')->where('id',$employeeId)->first();

        $sendCCMail = collect(DB::table('email_templates_cc_info')->where('email_template_id', $templates->id)->where('company_id', $emplyInfo->employee_sbu)->get())->pluck('employee_wise_cc')->toarray();

        $approveInfo = collect(DB::table('employees')->whereIn('id', $ea_approve_by)->get())->pluck('official_email_id')->toarray();

        if(!empty($templates->email_to)){
            $mailTo = explode(',', $templates->email_to);
        }else{
            $mailTo = [];
        }

        if(!empty($templates->email_cc)){
            $sendCommonCCMail = explode(',', $templates->email_cc);
        }else{
            $sendCommonCCMail = [];
        }

        if(!empty($templates->email_bcc)){
            $sendBCCMails = explode(',', $templates->email_bcc);
        }else{
            $sendBCCMails = [];
        }

        // $sendCommonCCMail = explode(',', $templates->email_cc);
        // $sendToMail = array_merge($approveInfo, $mailTo);

        $sendToMail = array_merge($approveInfo, $mailTo);
        $sendCCMail = array_merge($sendCCMail, $sendCommonCCMail);
        $sendBCCMail = $sendBCCMails;

        $data['add_note_issues'] = $add_note_issues;
        $data['add_note_date'] = $add_note_date;
        $data['out_time'] = $out_time;
        $data['return_time']  = $return_time;
        $data['add_note_remarks']  = $add_note_remarks;

        $data['employeeName'] = $employeeName = $emplyInfo->employee_fullname;
        $data['employeeId'] = $employeeId = $emplyInfo->employee_id_no;
        $data['employeePhone'] = $employeePhone = $emplyInfo->employee_mobile;


        $data["email"] = $sendToMail;
        $data["title"] = "Leave Approve Request";
        $data["body"] = $templates->email_body;
        // $pdf = PDF::loadView('emails.daily_attendance_report', $data1)->setPaper('a4', 'landscape');
        $user_email = 'noreply@gemcongroup.com';
        $send_to = $emplyInfo->official_email_id ?? '' ;
        $email_cc = $sendCCMail;
        $email_bcc = $sendBCCMail;
        // $send_to = 'faruk.khan@gemcongroup.com' ;
        // $email_common_cc = 'faruk.cse14@gmail.com';
        $send_to_name = $employeeName;
        $user = 'Human Resources Management System';
        $title = 'Note Request';
        $data['title'] = $title;
        $data['name'] = $employeeName;

        $message = '';
        eval("\$message = \"$templates->email_body\";");
        $subject ='';
        eval("\$subject = \"$templates->subject\";");


        $phpMail = new PHPMailer();
        $phpMail->AddAddress($send_to, $send_to_name);
        $phpMail->AddReplyTo($user_email, $user);
        foreach ($sendToMail as $key_1 => $value1) {
            $phpMail->AddAddress($value1);
        }
        foreach ($email_cc as $key_1 => $value) {
            $phpMail->addCC($value);
        }
        foreach ($email_bcc as $key_1 => $value) {
            $phpMail->addBCC($value);
        }
        $msg = $message;
        $phpMail->FromName = $user;
        $phpMail->From = $user_email;
        $phpMail->Sender = $user_email;
        $phpMail->IsHTML(true);
        // $phpMail->Host = "172.16.1.2";
        $phpMail->Host = "mail.gemcongroup.com";
        $phpMail->IsSMTP();
        $phpMail->Mailer   = "smtp";
        $phpMail->Subject = $subject;
        $phpMail->Body = $msg;
        $phpMail->SMTPAuth = true;
        $phpMail->Username = "noreply@gemcongroup.com";
        $phpMail->Password = "sfftw6";
        $phpMail->Port = 465;
        $msg = "";
        $phpMail->Send();
        $phpMail->ClearAddresses();
        $phpMail->ClearAttachments();
    }

    public function birthday_wish($company_logo = NULL, $employee_image = NULL, $employee_name = NULL, $sbu_name = NULL, $official_email_id = NULL, $employee_email = NULL)
    {
        $mailTo = ['faruk.cse14@gmail.com', 'faruk.khan@gemcongroup.com'];
        $sendToMail = $mailTo;
        $data["email"] = $sendToMail;
        $data["title"] = "Birthday Wish";
        $user_email = 'noreply@gemcongroup.com';
        $send_to = '' ;
        $send_to_name = $employee_name;
        $user = 'Human Resources Management System';
        $title = 'Birthday Wish';
        $data['title'] = $title;
        $data['name'] = $employee_name;
        $birthday_wish = 'blank_gemcon_birthdayh_wish.jpg';
        $url_birthday_wish = 'https://hrms.gemconit.com/birthday_wish/' . $birthday_wish;
        if(!empty($company_logo)){
            $url_company_logo = 'https://hrms.gemconit.com/company_logo/' . $company_logo;
        }else{
            $url_company_logo = '';
        }
        if(!empty($employee_image)){
            $url_employee_image = 'https://hrms.gemconit.com/images/' . $employee_image;
        }else{
            $url_employee_image = 'https://hrms.gemconit.com/images/default.png';
        }
        $message = '
            <html>
                <body>
                    <div class="col-md-12">
                        <img src="' . $url_birthday_wish . '" alt="Birthday Wish" width="576" height="720">
                        <div>
                        <img style="position: absolute;top: 4%;left: 35%;width: 8%;" src="' . $url_company_logo . '" alt='. $sbu_name .'>
                        <img style="position: absolute;top: 19.6%;left: 20%;border-radius: 50%;object-fit: cover;" src="' . $url_employee_image . '" alt='. $employee_name .' width="235" height="235"> 
                        <span style="position: absolute;top: 77.4%;left: 12%;font-size: 18px;font-weight: 500;">' . $employee_name . '</span>
                    </div>
                </div>
                </body>
            </html> 
        ';
        $subject ='Birthday Wish! Happy Birthday to You!';
        $phpMail = new PHPMailer();
        $phpMail->AddAddress($send_to, $send_to_name);
        $phpMail->AddReplyTo($user_email, $user);
        foreach ($sendToMail as $key_1 => $value1) {
            $phpMail->AddAddress($value1);
        }
        $msg = $message;
        $phpMail->FromName = $user;
        $phpMail->From = $user_email;
        $phpMail->Sender = $user_email;
        $phpMail->IsHTML(true);
        // $phpMail->Host = "172.16.1.2";
        $phpMail->Host = "mail.gemcongroup.com";
        $phpMail->IsSMTP();
        $phpMail->Mailer   = "smtp";
        $phpMail->Subject = $subject;
        $phpMail->Body = $msg;
        $phpMail->SMTPAuth = true;
        $phpMail->Username = "noreply@gemcongroup.com";
        $phpMail->Password = "sfftw6";
        $phpMail->Port = 465;
        $msg = "";
        $phpMail->Send();
        $phpMail->ClearAddresses();
        $phpMail->ClearAttachments();
    }

}
