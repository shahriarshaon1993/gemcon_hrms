<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\PorjectModel;
use App\Model\UsersPersonModel;
use DB;
use DateTime;
use Auth;

class PosDemoRegisterController extends Controller
{
    public function showRegisterForm(){

    	return view('pos-demo-register');
    }

    public function showContactForm(){

        return view('pos-demo-contact');
    }
    public function store(Request $request){
    
        $validation = [
            'name' => 'required',
            'email' => 'required|unique:inv_sales_person,email,'.$request->id,
            'username' =>  'required|unique:inv_sales_person,username,'.$request->id,
        ];


        $data = $request->only('name','designation','email','username');
        // $create_slaes_person = UsersPersonModel::create($sales_person_data);
        if(empty($chk)){
            $data['password'] = bcrypt($request->password);  
            $validation['password'] = 'required';
            $data['created_by']=0;
            $data['project_id']=0;
            $data['branch_id']=0;
            $data['role_id']=0;
            $request->validate($validation);
            // echo"<pre>";
            // print_r($data);
            // exit();
            $save =   UsersPersonModel::create($data); 
             
        return redirect('/')
            ->with('msgHead', "Hello, ".$request->name)
            ->with('msg', "You have successfully registered. A confirmation massege is send to your email.");
        }else{
            return back()
            ->with('msgHead', "Hello, ".$request->name)
            ->with('msg', "You have successfully registered. A confirmation massege is send to your email.");
        }
      
    }

    // public function store(Request $request)
    // {
    // 	/*$validation = [
    //         'username' =>  'required|unique:project_info',
    //         'profession' =>  'required',
    //         'company_name' =>  'required',
    //         'phone' =>  'required',
    //         'email' =>  'required|unique:project_info',
    //         'password'=>'required'
    //     ];*/
    //     $this->validate($request, [
    //        'name' =>  'required',
    //         'phone' =>  'required',
    //         'email' =>  'required|unique:project_info',
    //         'password' => 'required|min:6'
    //     ]);

    //     $data = $request->only('name','phone','email');

    //     $save = PorjectModel::create($data);  
    //     if($save){
    //         $token = uniqid();
    //     	$sales_person_data = $request->only('name','phone','email');
    //         $sales_person_data['project_id'] = $save->id;
    //         $sales_person_data['role_id'] = 3;
    //         $sales_person_data['valid'] = 1;
    //         $sales_person_data['username'] = $save->email;
    //         $sales_person_data['password'] = bcrypt($request->password);
    //     	$create_slaes_person = UsersPersonModel::create($sales_person_data);
    //     	if($create_slaes_person){

    //            /* $mail_data=[
    //                 'subject'=>'Registration Confirmation',
    //                 'name'=>$request->name,
    //                 'email'=>$request->email,
    //             ];

    //             $subject = 'Registration Confirmation';
    //             $template = 'pos.register_confirmation';
    //             $mailFrom = 'Pos';
    //             $name = $request->name;
    //             $email = $request->email;

    //             return redirect(route('message'))
    //             ->with('msgSubject', 'Comfirmation')
    //             ->with('msgHead', "Hello, ".$request->name)
    //             ->with('msg', "You have successfully registered. A confirmation massege is send to your email.<br><br><br><hr><a href='".route('contact')."' style='color:blueviolet;font-size:14px;'>Need to resend the email, change your address, or get help?</a>");

    //             $mail = Mail::send('emails.'.$template, $data, function($m) use ($name, $email, $subject, $mailFrom) {
    //                 if(!empty($mailFrom)) { $m->from('noreplay.tmssict@gmail.com', $mailFrom); }
    //                 $m->to($email, $name)->subject($subject);
    //             });*/

    //             $mail_data=[
    //                 'subject'=>'Registration Confirmation',
    //                 'name'=>$request->name,
    //                 'loginUrl'=>route('user.login'),
    //                 'email'=>$request->email,
    //                 'password'=>$request->password
    //             ];

    //             $fields = array(
    //                 'data' => serialize($mail_data),
    //                 'subject' => 'Registration Confirmation',
    //                 'template' => 'pos.register_confirmation',
    //                 'mailFrom' => 'Pos',
    //                 'name' => $request->name,
    //                 'email' => $request->email
    //             );
    //             $params = http_build_query($fields);
    //             $url = "http://mail.mailbd.com/api";
    //             $ch = curl_init();

    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //             curl_setopt($ch, CURLOPT_URL, $url);
    //             curl_setopt($ch,CURLOPT_POST, count($fields));
    //             curl_setopt($ch,CURLOPT_POSTFIELDS, $params);
    //             curl_exec($ch);
    //             return redirect(route('message'))
    //             ->with('msgSubject', 'Comfirmation')
    //             ->with('msgHead', "Hello, ".$request->name)
    //             ->with('msg', "You have successfully registered. A confirmation massege is send to your email.<br><br><br><hr><a href='".route('contact')."' style='color:blueviolet;font-size:14px;'>Need to resend the email, change your address, or get help?</a>");
    //     	}
    //     }

    // }

    public function message(Request $request) {
        if ($request->session()->has('msg')) {
            return view('pos-demo-login');
        } else {
            return redirect(route('demo-home'));
        }
    }

    public function registerVerify(Request $request) {
        $token = $request->token;
        $data["user"] = DB::table('inv_sales_person')->where('email_verify_token', $token)->first();

        if(!empty($data["user"])) {
            return view('pos-demo-setpass', $data);
        } else {
            return redirect(route('message'))
            ->with('msgSubject', 'Token Expired')
            ->with('msgHead', "Sorry!!")
            ->with('msg', "Your token has expired.<br><br><br><br><br><br>");
        }        
    }

    public function registerVerifyAction(Request $request) {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        try{
            $token = $request->token;
            $user = DB::table('inv_sales_person')->where('email_verify_token', $token)->where('valid','=','0')->first();

            if(!empty($user)) {
                $dateTime = new DateTime;
                $dateTime = $dateTime->format('Y-m-d H:i:s');

                /*$project_code = DB::table('project')->orderBy('project_code', 'desc')->first();
                $project_code = (!empty($project_code)) ? intVal($project_code->project_code)+1 : 1;*/

                DB::beginTransaction();
                DB::table('inv_sales_person')->where('id', $user->id)->update([
                    'password' => bcrypt($request->password),
                    'email_verify_token' => '',
                    'valid' => '1',
                    'updated_by' => $dateTime
                ]);
                DB::commit();

                //Mail
                $mail_data=[
                    'subject'=>'Registration Confirmation',
                    'name'=>$user->name,
                    'loginUrl'=>route('user.login'),
                    'email'=>$user->email,
                    'password'=>$request->password
                ];

                $subject = 'Registration Confirmation';
                $template = 'posmail.register_confirmation';
                $mailFrom = 'Pos';
                $name = $user->name;
                $email = $user->email;

               /* $mail = Mail::send('emails.'.$template, $data, function($m) use ($name, $email, $subject, $mailFrom) {
                    if(!empty($mailFrom)) { $m->from('noreplay.tmssict@gmail.com', $mailFrom); }
                    $m->to($email, $name)->subject($subject);
                });*/

               /* $fields = array(
                    'data' => serialize($mail_data),
                    'subject' => 'Registration Confirmation',
                    'template' => 'posmail.register_confirmation',
                    'mailFrom' => 'Pos',
                    'name' => $user->name,
                    'email' => $user->email
                );
                $params = http_build_query($fields);
                $url = "https://mail.tmss-ict.com/api";
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_POST, count($fields));
                curl_setopt($ch,CURLOPT_POSTFIELDS, $params);
                curl_exec($ch);*/

                //Login
                Auth::guard('user')->loginUsingId($user->id);

                return redirect(route('pos.home'));
            } else {
                return redirect(route('message'))
                    ->with('msgSubject', 'Token Expired')
                    ->with('msgHead', "Sorry!!")
                    ->with('msg', "Your token has expired.<br><br><br><br><br><br>");
            }
        }catch(\Exception $exception){
            return redirect(route('home'));
        }       
    } 

    public function contactAction(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'phone' => 'required',
            'message' => 'required',
        ]);
        try{
            $mail_data=[
              'subject'=>'Pos Client Mail',
              'name'=>$request->name,
              'email'=>$request->email,
              'number'=>$request->phone,
              'mailSubject'=>$request->subject,
              'mailMessage'=>$request->message
            ];


                $fields = array(
                    'data' => serialize($mail_data),
                    'subject' => 'Pos Client Mail',
                    'template' => 'pos.contact_mail',
                    'mailFrom' => 'Pos',
                    'name' => 'TMSS ICT',
                    'email' => 'tmssict@gmail.com'
                );
                $params = http_build_query($fields);
                $url = "http://mail.mailbd.com/api";
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_POST, count($fields));
                curl_setopt($ch,CURLOPT_POSTFIELDS, $params);
                curl_exec($ch);
                

            return redirect(route('message'))
                ->with('msgSubject', 'Thank you for contact us')
                ->with('msgHead', "Hello, ".$request->name)
                ->with('msg', "We have received your message. you have sent message from <span style='color:blue;'>".$request->email."</span>,<br>We will reply to your mail as soon as possible.<br><br><br><br><br><br>");

        }catch(\Exception $exception){
            return redirect(route('home'));
        }
    }
}
