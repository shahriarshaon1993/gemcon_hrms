<?php
// use App\Model\Employee;
// use App\Events\ServiceRequestsEvent;
// use Symfony\Component\Routing\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\UserLoginController@showLoginForm')->name('user.login');
Route::post('/user/submit', 'Auth\UserLoginController@login')->name('user.login.submit');
Route::post('/emailSendForPassChange', 'Auth\UserLoginController@emailSendForPassChange');
Route::post('/otpChecking', 'Auth\UserLoginController@otpChecking');
Route::post('/find_user_email_id', 'Auth\UserLoginController@find_user_email_id');
Route::post('/createNewPass', 'Auth\UserLoginController@createNewPass');
// Route::post('/user/credentials','Auth\UserLoginController@postCredentials');
Route::post('/changePassword', 'MasterController@changePassword')->name('changePassword');
Route::post('user/logout', 'Auth\UserLoginController@logout')->name('user.logout');
Route::get('jsBaseURLs', 'AdapterController@jsBaseURLs')->name('jsBaseURLs');
// Route::get('/dashboards/dashboardSummary','MasterController@dashboardSummary');

Route::get('/zoom_meeting', 'MasterController@zoom_meeting');
Route::get('/zoom_meeting_connect/{id}', 'MasterController@zoom_meeting_connect');
Route::get('/dashboards', 'MasterController@dashboard');
Route::get('/dashboards_payroll', 'PayrollMasterController@index');
Route::get('/settings', 'MasterController@dashboard');
Route::get('/generalInfoSubmit', 'MasterController@generalInfoSubmit');

Route::get('/my_profile_component', 'MasterController@myProfileComponent');
Route::get('/employee_Directory_component', 'MasterController@employeeDirectoryComponent');
Route::get('/file_manager_component', 'MasterController@fileManagerComponent');
Route::get('/payroll_component', 'MasterController@payrollComponent');
Route::get('/leave_apply_component', 'MasterController@leaveApplyComponent');




Route::get('/assets_component', 'MasterController@assets_component');
// Route::get('/my_profile_component', 'MasterController@my_profile_component');
// Route::get('/performance_evaluation/{id}', 'HomeDashboarController@performance_evaluation');

Route::get('/daily_birthday_wish', 'MasterController@daily_birthday_wish')->name('daily_birthday_wish');

Route::group(['middleware' => 'auth.user'], function () {
    Route::get('/index', 'MasterController@profileIndex')->name('hrm.home');
    Route::post('/leaveapplication_submit', 'hrm\LeaveApplicationController@store')->name('leaveapplication');
    Route::post('/leaveAdjustmentSend', 'hrm\AdjustLeaveApplicationController@leaveAdjustmentSend')->name('leaveAdjustmentSend');
    Route::get('/pagination/fetch_data', 'MasterController@fetch_data');
    Route::get('/get_responsible_info/{id}', 'MasterController@get_responsible_info');
    Route::get('/findServiceRequestData/{id}', 'MasterController@findServiceRequestData');
    Route::get('/findLateRequestData/{id}', 'MasterController@findLateRequestData');
    Route::get('/findLeaveRequestData/{id}', 'MasterController@findLeaveRequestData');
    Route::get('/findManualAttendanceData/{id}', 'MasterController@findManualAttendanceData');

    Route::get('/findAddNoteData/{id}', 'hrm\AddNoteController@edit');

    Route::post('/sendServiceRequest', 'hrm\ServiceRequestController@store');
    Route::get('/get_last_service_info/{id}', 'MasterController@get_last_service_info');
    Route::get('/serviceDestroy/{id}', 'hrm\ServiceRequestController@destroy');
    Route::get('/serviceCancel/{id}', 'hrm\ServiceRequestController@serviceCancel');
    Route::get('/lateRequestDestroy/{id}', 'hrm\LateRequestController@destroy');
    Route::get('/leaveRequestDestroy/{id}', 'hrm\LeaveApplicationController@destroy');
    Route::get('/manualAttendanceDestroy/{id}', 'hrm\ManualAttendanceController@destroy');
    Route::post('/lateRequestSend', 'hrm\LateRequestController@store');
    Route::post('/profile_image_upload', 'hrm\EmployeeController@profile_image_upload');
    Route::get('/get_service_list_info/{id}', 'MasterController@get_service_list_info');
    Route::get('/get_holiday_list_info/{id}', 'MasterController@get_holiday_list_info');
    Route::post('/sendManualAttendanceRequest', 'hrm\ManualAttendanceController@sendManualAttendanceRequest');
    Route::post('/sendAddNoteRequest', 'hrm\AddNoteController@sendAddNoteRequest');
    Route::get('/emp_create/manualattendance/{id}', 'ManualAttendanceController@create');
    Route::get('/findFileList/{id}', 'MasterController@findFileList');
    Route::get('/veiw_or_download/file_access_log/{id}/{type}', 'hrm\FileAccessLogController@veiw_or_download');
    Route::get('/pay_slip_info/{id}/{employee_id}', 'MasterController@pay_slip_info');
    Route::get('/loan_schedule_info/{id}/{employee_id}', 'MasterController@loan_schedule_info');
    Route::post('/_findActualAnnualLeaveDays', 'hrm\LeaveApplicationController@findActualAnnualLeaveDays');


    Route::get('/find_type_category_product/{id}', 'hrm\GeneralStationaryController@find_type_category_product');
    Route::post('/send_general_stationery_request', 'hrm\GeneralStationaryController@send_general_stationery_request');
    Route::get('/findGeneralStaioneryData/{id}', 'hrm\GeneralStationaryController@findGeneralStaioneryData');
    Route::get('/find_pcategory_product_list/{id}', 'hrm\GeneralStationaryController@find_pcategory_product_list');
    Route::get('/generalStaioneryData/{id}', 'hrm\GeneralStationaryController@destroy');
    // notice+birthday like wish route
    Route::get('/announcement_view/{id}', 'MasterController@announcement_view');
    Route::get('/find_notice_viewer_info/{id}', 'MasterController@find_notice_viewer_info');
    Route::get('/find_notice_vewing_info/{id}/{employeeid}', 'MasterController@find_notice_vewing_info');
    Route::get('/birthday_view/{employeeid}/{wishid}', 'MasterController@birthday_view');
    Route::get('/find_birthday_likers/{employeeid}', 'MasterController@find_birthday_likers');
    Route::get('/find_birthday_liking_info/{employeeid}/{wishid}', 'MasterController@find_birthday_liking_info');


    Route::post('/insurance_assign_submit', 'hrm\InsuranceController@insurance_assign_submit');
    Route::get('/insurance_exclution_submit/{employee_id}', 'hrm\InsuranceController@insurance_exclution_submit');

    Route::post('/get_employee_current_location', 'MasterController@get_employee_current_location');
    Route::get('/find_unreadNotifications/{employee_id}', 'hrm\HomeDashboarController@find_unreadNotifications');

    Route::post('/employee_check_in_time', 'hrm\ManualAttendanceController@employee_check_in_time');
    Route::post('/employee_check_out_time', 'hrm\ManualAttendanceController@employee_check_out_time');

});

Route::group(['middleware' => ['auth.user'], 'prefix' => 'hrm', 'as' => 'hrm.'], function () {
    Route::get('jsBaseURLs', 'AdapterController@hrmJsBaseURLs')->name('jsBaseURLs');
    Route::get('home', 'MasterController@home');
    Route::get('/getmenu', 'MasterController@getUserMenuList');
    Route::group(['namespace' => 'hrm'], function () {
        hrmRoute();
    });
});

Route::group(['middleware' => ['auth.user'], 'prefix' => 'payroll', 'as' => 'payroll.'], function () {

    Route::get('jsBaseURLs', 'AdapterController@payrollJsBaseURLs')->name('jsBaseURLs');

    Route::get('home', 'PayrollMasterController@home');
    Route::get('/getmenu', 'PayrollMasterController@getUserMenuList');

    Route::group(['namespace' => 'payroll'], function () {
        payrollRoute();
    });
});

// Admin
Route::get('/admin/', 'AdminHomeController@index')->name('admin.home');
Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('admin/submit', 'Auth\AdminLoginController@login')->name('admin.login.submit');
Route::post('admin/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
Route::group(['middleware' => ['auth.admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('jsBaseURLs', 'AdapterController@adminJsBaseURLs')->name('jsBaseURLs');
    Route::group(['namespace' => 'admin'], function () {

        Route::get('/list', 'AdminController@index');
        Route::post('/add', 'AdminController@store');
        Route::get('/create', 'AdminController@create');
        Route::delete('delete/{id}', 'AdminController@destroy');
        Route::get('edit/{id}', 'AdminController@show');

        Route::get('/email_configuration/list', 'EmailConfigurationController@index');
        Route::post('/email_configuration/add', 'EmailConfigurationController@store');
        Route::get('/email_configuration/create', 'EmailConfigurationController@create');
        Route::delete('/email_configuration/delete/{id}', 'EmailConfigurationController@destroy');
        Route::get('/email_configuration/edit/{id}', 'EmailConfigurationController@show');

        Route::get('/role/list', 'UserRoleController@index');
        Route::get('/create/role', 'UserRoleController@create');
        Route::post('/add/role', 'UserRoleController@store');
        Route::get('/role/edit/{id}', 'UserRoleController@show');
        Route::delete('/role/delete/{id}', 'UserRoleController@destroy');

        Route::get('/adminrole/list', 'AdminRoleCocntroller@index');
        Route::get('/create/adminrole', 'AdminRoleCocntroller@create');
        Route::post('/add/adminrole', 'AdminRoleCocntroller@store');
        Route::get('/adminrole/edit/{id}', 'AdminRoleCocntroller@show');
        Route::delete('/adminrole/delete/{id}', 'AdminRoleCocntroller@destroy');

        Route::get('/menu/list', 'MenuController@index');
        Route::post('/add/menu', 'MenuController@store');
        Route::get('/create/menu', 'MenuController@create');
        Route::get('/edit/menu/{id}', 'MenuController@show');
        Route::get('/getmenu', 'MenuController@getAdminMenuList');
        Route::delete('/delete/menu/{id}', 'MenuController@destroy');

        Route::post('/passwordchange', 'ChangePasswordController@passwordChange');
        Route::get('/user/list', 'UserController@index');
        Route::post('/user/add', 'UserController@store');
        Route::get('/user/create', 'UserController@create');
        Route::get('/user/branch_list', 'UserController@branch_list');
        Route::delete('/user/delete/{id}', 'UserController@destroy');
        Route::get('/user/edit/{id}', 'UserController@show');

        Route::get('/project/list', 'ProjectListController@index');
        Route::get('/create/project', 'ProjectListController@create');
        Route::post('/add/project', 'ProjectListController@store');
        Route::get('/edit/project/{id}', 'ProjectListController@edit');
        Route::delete('/delete/project/{id}', 'ProjectListController@destroy');
        // branchlist
        Route::get('/branch/list', 'BranchListController@index');
        Route::get('/create/branch', 'BranchListController@create');
        Route::post('/add/branch', 'BranchListController@store');
        Route::get('/edit/branch/{id}', 'BranchListController@edit');
        Route::delete('/delete/branch/{id}', 'BranchListController@destroy');
        Route::any('/delete/branch/approve/{id}', 'BranchListController@approve');


        // termsAndCondition
        Route::get('/em_department/list', 'EmployeeDepartmentController@index');
        Route::get('/create/em_department', 'EmployeeDepartmentController@create');
        Route::post('/add/em_department', 'EmployeeDepartmentController@store');
        Route::get('/edit/em_department/{id}', 'EmployeeDepartmentController@edit');
        Route::delete('/delete/em_department/{id}', 'EmployeeDepartmentController@destroy');

        Route::get('/em_designation/list', 'EmployeeDesignationController@index');
        Route::get('/create/em_designation', 'EmployeeDesignationController@create');
        Route::post('/add/em_designation', 'EmployeeDesignationController@store');
        Route::get('/edit/em_designation/{id}', 'EmployeeDesignationController@edit');
        Route::delete('/delete/em_designation/{id}', 'EmployeeDesignationController@destroy');


        //customer info
        Route::get('/customerinfo/list', 'CompanyConfigurController@index');
        Route::get('/create/customerinfo', 'CompanyConfigurController@create');
        Route::post('/add/customerinfo', 'CompanyConfigurController@store');
        Route::get('/edit/customerinfo/{id}', 'CompanyConfigurController@edit');
        Route::delete('/delete/customerinfo/{id}', 'CompanyConfigurController@destroy');
        // Inventory Category
        // {path:"/payment_mode",component:PaymentMode,meta:{fetchUrl:'payment_mode/list',title:"Payment Mode",subtitle:"Payment Mode",icon:"icon-edit"}},
        Route::get('module_data/list', 'ModuleDataController@index');
        Route::get('/module_data/create', 'ModuleDataController@create');
        Route::post('/module_data/add', 'ModuleDataController@store');
        Route::get('/module_data/edit/{id}', 'ModuleDataController@show');
        Route::delete('/module_data/delete/{id}', 'ModuleDataController@destroy');

        Route::get('/email_templates/list', 'EmailTemplateController@index');
        Route::get('/create/email_templates', 'EmailTemplateController@create');
        Route::post('/add/email_templates', 'EmailTemplateController@store');
        Route::get('/edit/email_templates/{id}', 'EmailTemplateController@edit');
        Route::delete('/delete/email_templates/{id}', 'EmailTemplateController@destroy');

        // Inventory Item
    });
});
// Route::get('/dashboard_main','MasterController@posDashboard');

Route::get('/career', 'JobsController@index')->name('career');
Route::post('/apply', 'JobsController@apply')->name('jobApply');
Route::post('/apply/talent', 'JobsController@applyTalent')->name('applyTalent');
Route::post('/apply/job-alert', 'JobsController@storeJobAlert')->name('applyJobAlert');

Route::post('get-circular', 'JobsController@getCircular')->name('career.circular.show');

function hrmRoute()
{
    // broadcast(new ServiceRequestsEvent('ServiceRequestChannel'));
    // Route::POST('/report_filter', function(Request $request){
    // 	$employee_list = new Employee();
    //        $employee_ids=$employee_list->report_filter($request);
    //    return $request;
    // });

    Route::get('/get_department_company_wise', 'ShiftingSetupController@getDepartmentCompanyWise');
    Route::post('/get_report_sbu', 'ReportController@get_report_sbu');

    // Route::get('/report_filter/{array}','ReportController@report_filter');
    // Route::post('/report_filter','ReportController@report_filter');
    // Route::get('/find_unreadNotifications/{employee_id}','HomeDashboarController@find_unreadNotifications');
    Route::get('/markAsRead_get/{id}', 'HomeDashboarController@markAsRead_get');
    Route::get('/employee_joining', 'HomeDashboarController@employee_joining');

    Route::get('/home_dashboard', 'HomeDashboarController@index');
    Route::post('/find_dashboard_data', 'HomeDashboarController@find_dashboard_data');
    Route::post('/find_recuiting_outgoing', 'HomeDashboarController@find_recuiting_outgoing');
    Route::get('/find_widget_list', 'HomeDashboarController@find_widget_list');
    Route::get('/employee_joining', 'HomeDashboarController@employee_joining');
    Route::POST('/dashboard_update', 'HomeDashboarController@dashboardUpdate');
    Route::get('/employees/performance_evaluation/{id}', 'HomeDashboarController@performance_evaluation');
    Route::post('/add/performance_evaluation', 'HomeDashboarController@store_performance_assessment');
    Route::post('/dashboard_emp_from', 'HomeDashboarController@employeesFrom');
    Route::get('/home_dashboard/headcount_today', 'HomeDashboarController@headcountToday');
    Route::get('/home_dashboard/gender', 'HomeDashboarController@employeesGender');
    Route::post('/dashboard_emp_type', 'HomeDashboarController@employeesType');
    Route::get('/home_dashboard/emp_blood_group', 'HomeDashboarController@employeeBloodGroup');
    Route::post('/emp_today_attendance', 'HomeDashboarController@todayAttendance');
    Route::get('/home_dashboard/emp_recruitment_outgoing', 'HomeDashboarController@recruitmentOutgoing');
    Route::post('/emp_age_group', 'HomeDashboarController@employeeAgeGroup');
    Route::get('/home_dashboard/job_confirmation_due_list', 'HomeDashboarController@jobConfirmationDueList');
    Route::get('/home_dashboard/emp_turnover', 'HomeDashboarController@employeeTurnover');
    Route::get('/home_dashboard/upcoming_event', 'HomeDashboarController@upcomingEvent');
    Route::get('/home_dashboard/unit_wise_emp_salary', 'HomeDashboarController@unitWiseEmployeeSalary');

    Route::get('/activity_log/list', 'HomeDashboarController@activityLog');
    // Route::get('/add/performance_evaluation/{id}', 'HomeDashboarController@store_performance_assessment');

    Route::get('/talent/peoples', 'TalentPeopleController@index');
    Route::delete('/delete/talents/{id}', 'TalentPeopleController@destroy');
    Route::post('/talent/send-mail/{id}', 'TalentPeopleController@send');

    Route::get('/peoples/subscriptions', 'PeopleSubscriptionController@index');
    Route::delete('/delete/subscriptions/{id}', 'PeopleSubscriptionController@destroy');

    Route::get('/dashboards/dashboardSummary', 'DashboardController@dashboardSummary');
    Route::get('/job_circular/list', 'JobCircularController@index');
    Route::get('/create/job_circular', 'JobCircularController@create');
    Route::post('/add/job_circular', 'JobCircularController@store');
    Route::get('/edit/job_circular/{id}', 'JobCircularController@edit');
    Route::delete('/delete/job_circular/{id}', 'JobCircularController@destroy');

    Route::get('/job_circular/viewAllJob', 'JobCircularController@viewAllJob');
    Route::get('/cvlist/job_circular/', 'JobCircularController@cvlist');
    Route::get('/job_circular/cvlist', 'JobCircularController@allcvlist');
    Route::get('/allcvlist/job_circular/{id}', 'JobCircularController@allcvlist');
    Route::get('/candidate-short/{id}', 'JobCircularController@shortList');
    Route::get('/candidate-unlisted/{id}', 'JobCircularController@candidateUnlisted');

    Route::get('/candidate-short-mail/{id}', 'JobCircularController@candidateShortWithMail');
    Route::get('/candidate-send-mail/{id}', 'JobCircularController@candidateSendMail');

    Route::get('/candidate-selected/{id}', 'JobCircularController@selectCandidate');
    Route::get('/candidate-rejected/{id}', 'JobCircularController@rejectCandidate');

    Route::get('/interview_board_call/list', 'InterveiwBoardCallController@index');
    Route::get('/create/interview_board_call', 'InterveiwBoardCallController@create');
    Route::post('/add/interview_board_call', 'InterveiwBoardCallController@store');
    Route::get('/edit/interview_board_call/{id}', 'InterveiwBoardCallController@edit');
    Route::delete('/delete/interview_board_call/{id}', 'InterveiwBoardCallController@destroy');
    Route::get('/emailSendToExaminer/interview_board_call/{id}/{name}/{email}', 'InterveiwBoardCallController@emailSendToExaminer');
    Route::post('/add-marking', 'InterveiwBoardCallController@marksEntry');

    Route::get('/shift_time/list', 'ShiftTimeController@index');
    Route::get('/create/shift_time', 'ShiftTimeController@create');
    Route::post('/add/shift_time', 'ShiftTimeController@store');

    Route::get('/edit/shift_time/{id}', 'ShiftTimeController@edit');
    Route::delete('/delete/shift_time/{id}', 'ShiftTimeController@destroy');

    Route::get('/roaster_setup/list', 'RoasterSetupController@index');
    Route::get('/create/roaster_setup', 'RoasterSetupController@create');
    Route::post('/add/roaster_setup', 'RoasterSetupController@store');
    Route::get('/edit/roaster_setup/{id}', 'RoasterSetupController@edit');
    Route::delete('/delete/roaster_setup/{id}', 'RoasterSetupController@destroy');

    Route::get('/attendance_issue/list', 'AttendanceIssueController@index');
    Route::get('/create/attendance_issue', 'AttendanceIssueController@create');
    Route::post('/add/attendance_issue', 'AttendanceIssueController@store');
    Route::get('/edit/attendance_issue/{id}', 'AttendanceIssueController@edit');
    Route::delete('/delete/attendance_issue/{id}', 'AttendanceIssueController@destroy');

    Route::get('/note_issue/list', 'NoteIssueController@index');
    Route::get('/create/note_issue', 'NoteIssueController@create');
    Route::post('/add/note_issue', 'NoteIssueController@store');
    Route::get('/edit/note_issue/{id}', 'NoteIssueController@edit');
    Route::delete('/delete/note_issue/{id}', 'NoteIssueController@destroy');

    Route::get('/notice/list', 'NoticeController@index');
    Route::get('/create/notice', 'NoticeController@create');
    Route::post('/add/notice', 'NoticeController@store');
    Route::get('/edit/notice/{id}', 'NoticeController@edit');
    Route::delete('/delete/notice/{id}', 'NoticeController@destroy');

    Route::get('/stationary_service/list', 'GeneralStationaryController@index');
    Route::get('/create/stationary_service', 'GeneralStationaryController@create');
    Route::post('/add/stationary_service', 'GeneralStationaryController@store');
    Route::get('/edit/stationary_service/{id}', 'GeneralStationaryController@edit');
    Route::delete('/delete/stationary_service/{id}', 'GeneralStationaryController@destroy');
    Route::post('/approveOrReject/stationary_service', 'GeneralStationaryController@approveOrReject');

    Route::get('/service_request/list', 'ServiceRequestController@index');
    Route::get('/create/service_request', 'ServiceRequestController@create');
    Route::post('/add/service_request', 'ServiceRequestController@store');
    Route::get('/edit/service_request/{id}', 'ServiceRequestController@edit');
    Route::get('/salary_certificate/service_request/{id}', 'ServiceRequestController@salary_certificate');
    Route::delete('/delete/service_request/{id}', 'ServiceRequestController@destroy');
    Route::post('/approveOrReject/service_request', 'ServiceRequestController@approveOrReject');

    Route::get('/late_request/list', 'LateRequestController@index');
    Route::get('/create/late_request', 'LateRequestController@create');
    Route::post('/add/late_request', 'LateRequestController@store');
    Route::get('/edit/late_request/{id}', 'LateRequestController@edit');
    Route::delete('/delete/late_request/{id}', 'LateRequestController@destroy');
    Route::post('/approveOrReject/late_request', 'LateRequestController@approveOrReject');

    Route::get('/note_request/list', 'AddNoteController@index');
    Route::get('/create/note_request', 'AddNoteController@create');
    Route::post('/add/note_request', 'AddNoteController@store');
    Route::get('/edit/note_request/{id}', 'AddNoteController@edit');
    Route::delete('/delete/note_request/{id}', 'AddNoteController@destroy');
    Route::post('/approveOrReject/note_request', 'AddNoteController@approveOrReject');

    Route::post('/roaster_report/find', 'ShiftingSetupController@roaster_report_find');
    Route::post('/roaster/copy', 'ShiftingSetupController@roaster_copy');
    // Route::get('/changing_reporting_to/list', 'ChangingReportingController@index');
    Route::get('/changing_reporting_to/list', 'ChangingReportingController@reporting_to_setup');
    Route::post('/add/ReportingChangeStore', 'ChangingReportingController@ReportingChangeStore');

    Route::get('/transfer_approval_layer/list', 'TransferApprovalLayerController@transfer_approval_setup');
    Route::post('/add/transfer_approval_layer', 'TransferApprovalLayerController@transfer_approval_layer');

    Route::get('/shifting_setup/list', 'ShiftingSetupController@index');
    Route::get('/bulk_shifting_setup/list', 'ShiftingSetupController@bulk_shift_setup');

    Route::get('/attendance_schedule_process/list', 'AttendanceScheduleProcessController@index');
    Route::post('/attendance-send-mail', 'AttendanceScheduleProcessController@sendMail');

    Route::get('/daily_attendance_mailing/list', 'AttendanceScheduleProcessController@daily_mail_send_index');

    Route::post('/add/attendanceScheduleProcess', 'AttendanceScheduleProcessController@attendanceProcessStore');



    Route::post('/add/bulkShiftingSetup', 'ShiftingSetupController@bulkStore');
    Route::get('/create/shifting_setup', 'ShiftingSetupController@create');
    Route::post('/shift_time/roaster_maping', 'ShiftingSetupController@roaster_maping');
    Route::post('/shift_time/fiends', 'ShiftingSetupController@shifting_fiends');
    Route::post('/shift_week/fiends', 'ShiftingSetupController@week_fiends');
    Route::post('/add/shifting_setup', 'ShiftingSetupController@store');
    Route::post('/add/shifting_setup_new', 'ShiftingSetupController@storeNew');

    Route::get('/edit/shifting_setup/{id}', 'ShiftingSetupController@edit');
    Route::delete('/delete/shifting_setup/{id}', 'ShiftingSetupController@destroy');

    Route::get('/employees/list', 'EmployeeController@index');
    Route::post('/reset_password/employees', 'EmployeeController@reset_password');
    Route::get('/create/employees', 'EmployeeController@create');
    Route::get('/create_id/employees/{id}', 'EmployeeController@employee_Id_Create');
    Route::post('/add/employees', 'EmployeeController@store');
    Route::get('/edit/employees/{id}', 'EmployeeController@edit');
    Route::delete('/delete/employees/{id}', 'EmployeeController@destroy');
    Route::get('/requested_data/employees/{id}', 'EmployeeController@requested_data');
    Route::get('/update_requested_data/employees/{sl}/{id}/{data}', 'EmployeeController@update_requested_data');

    Route::post('/employees/store_Emp_info/', 'EmployeeController@store_Emp_info');
    Route::get('/employees/profile/', 'EmployeeController@profile');
    // Route::get('/employees/basic_profile/', 'EmployeeController@basic_profile');
    Route::get('/employees/profileDetails/{id}', 'EmployeeController@profileDetails');
    Route::get('/employees/more-info/', 'EmployeeController@moreinfo');
    Route::get('/employees/more-info-data/{id}', 'EmployeeController@moreinfoData');
    Route::get('/employees/get-floors/{id}', 'EmployeeController@getFloors');
    Route::get('/employeemoreinfo_nid_check/{employee_nid}', 'EmployeeController@employeemoreinfo_nid_check');

    Route::post('employees/personal-info-store/', 'EmployeeController@personalInfoStore');
    Route::post('employees/addressdetails/', 'EmployeeController@addressDetails');
    Route::post('employees/identificationSupporting/', 'EmployeeController@identificationSupporting');
    Route::post('employees/educationalQualification/', 'EmployeeController@educationalQualification');
    Route::post('employees/professionalQualification/', 'EmployeeController@professionalQualification');
    Route::post('employees/employmentHistory/', 'EmployeeController@employmentHistory');
    Route::post('employees/familyDetails/', 'EmployeeController@familyDetails');
    Route::post('employees/references/', 'EmployeeController@references');
    Route::post('employees/trainingRecord/', 'EmployeeController@trainingRecord');
    Route::post('employees/professionalMembership/', 'EmployeeController@professionalMembership');
    Route::post('employees/bankAccount/', 'EmployeeController@bankAccount');
    Route::post('employees/emergencyContact/', 'EmployeeController@emergencyContact');
    Route::post('employees/othersContactInfo/', 'EmployeeController@othersContactInfo');

    Route::get('/department/list', 'DepartmentController@index');
    Route::get('/create/department', 'EmployeeController@create');
    Route::post('/add/department', 'DepartmentController@store');
    Route::get('/edit/department/{id}', 'DepartmentController@edit');
    Route::delete('/delete/department/{id}', 'DepartmentController@destroy');

    Route::get('/designation/list', 'DesignationController@index');
    Route::post('/add/designation', 'DesignationController@store');
    Route::get('/create/designation', 'DesignationController@create');
    Route::get('/edit/designation/{id}', 'DesignationController@edit');
    Route::delete('/delete/designation/{id}', 'DesignationController@destroy');

    Route::get('/jobgrade/list', 'JobGradeController@index');
    Route::post('/add/jobgrade', 'JobGradeController@store');
    Route::get('/edit/jobgrade/{id}', 'JobGradeController@edit');
    Route::delete('/delete/jobgrade/{id}', 'JobGradeController@destroy');

    Route::post('/circular/get-circular', 'CircularDescriptionController@getCircular');
    Route::get('/circular-descriptions', 'CircularDescriptionController@index');
    Route::get('/circular-descriptions/create', 'CircularDescriptionController@create');
    Route::post('/circular-descriptions/store', 'CircularDescriptionController@store');
    Route::delete('/circular-descriptions/delete/{id}', 'CircularDescriptionController@destroy');

    Route::get('/insurance_report/list', 'InsuranceController@index');
    Route::post('/insurance_report/finding', 'InsuranceController@insurance_report_finding');
    // Route::post('/insurance_assign_submit','InsuranceController@insurance_assign_submit');
    Route::get('/insurance_eligible', 'InsuranceController@insurance_eligible_list');
    Route::get('/insurance_eligible/find', 'InsuranceController@insurance_eligible_find');

    Route::post('/find_insurance_eligible_employee', 'InsuranceController@find_insurance_eligible_employee');
    Route::post('/insurance_eligible_store', 'InsuranceController@insurance_eligible_store');

    Route::get('/create/insurance_eligible', 'InsuranceController@create');
    Route::post('/add/insurance_eligible', 'InsuranceController@store');
    Route::get('/edit/insurance_eligible/{id}', 'InsuranceController@edit');
    Route::post('/update/insurance_eligible', 'InsuranceController@update');
    Route::delete('/delete/insurance_eligible/{id}', 'InsuranceController@destroy');

    Route::get('/leave_adjustment_report/list', 'AdjustLeaveApplicationController@adjustment_list');
    Route::post('/leave_adjustment_report/finding', 'AdjustLeaveApplicationController@adjustment_report_finding');
    Route::get('/adjust_create/leave_adjustment_report', 'AdjustLeaveApplicationController@adjust_create');

    Route::get('/ticketopen/list', 'TicketOpenController@index');
    Route::post('/add/ticketopen', 'TicketOpenController@store');
    Route::get('/edit/ticketopen/{id}', 'TicketOpenController@edit');
    Route::delete('/delete/ticketopen/{id}', 'TicketOpenController@destroy');

    Route::get('/ticketsell/list', 'TicketSellController@index');
    Route::post('/add/ticketsell', 'TicketSellController@store');
    Route::post('/search/unusedticket', 'TicketSellController@unusedticket');
    Route::get('/update/useticket', 'TicketSellController@useticket');
    Route::get('/edit/ticketsell/{id}', 'TicketSellController@edit');
    Route::delete('/delete/ticketsell/{id}', 'TicketSellController@destroy');

    Route::get('/companysbu/list', 'CompanySbuController@index');
    Route::post('/add/companysbu', 'CompanySbuController@store');
    Route::get('/create/companysbu', 'CompanySbuController@create');
    Route::get('/edit/companysbu/{id}', 'CompanySbuController@edit');
    Route::delete('/delete/companysbu/{id}', 'CompanySbuController@destroy');

    Route::get('/leavesetup/list', 'LeaveSetupController@index');
    Route::post('/add/leavesetup', 'LeaveSetupController@store');
    Route::get('/create/leavesetup', 'LeaveSetupController@create');
    Route::get('/edit/leavesetup/{id}', 'LeaveSetupController@edit');
    Route::delete('/delete/leavesetup/{id}', 'LeaveSetupController@destroy');

    Route::get('/leavetype/list', 'LeaveTypeController@index');
    Route::post('/add/leavetype', 'LeaveTypeController@store');
    Route::get('/edit/leavetype/{id}', 'LeaveTypeController@edit');
    Route::delete('/delete/leavetype/{id}', 'LeaveTypeController@destroy');

    Route::get('/leaveapplication/list', 'LeaveApplicationController@index');
    Route::get('/create/leaveapplication', 'LeaveApplicationController@create');
    Route::post('/add/leaveapplication', 'LeaveApplicationController@store');
    Route::get('/edit/leaveapplication/{id}', 'LeaveApplicationController@edit');
    Route::delete('/delete/leaveapplication/{id}', 'LeaveApplicationController@destroy');
    Route::post('/approveOrReject/leaveapplication', 'LeaveApplicationController@approveOrReject');
    Route::get('/edit/otherCreate/{id}', 'LeaveApplicationController@other_create');
    Route::get('/emp_create/leaveapplication/{id}', 'LeaveApplicationController@create');
    Route::post('/findActualAnnualLeaveDays', 'LeaveApplicationController@findActualAnnualLeaveDays');

    Route::get('/adjustmentleaveapplication/list', 'AdjustLeaveApplicationController@index');
    Route::get('/create/adjustmentleaveapplication', 'AdjustLeaveApplicationController@create');
    Route::post('/add/adjustmentleaveapplication', 'AdjustLeaveApplicationController@store');
    Route::get('/edit/adjustmentleaveapplication/{id}', 'AdjustLeaveApplicationController@edit');
    Route::delete('/delete/adjustmentleaveapplication/{id}', 'AdjustLeaveApplicationController@destroy');
    Route::post('/approveOrReject/adjustmentleaveapplication', 'AdjustLeaveApplicationController@approveOrReject');

    Route::get('/employee_transfer/list', 'EmployeeTransferController@index');
    Route::get('/create/employee_transfer', 'EmployeeTransferController@create');
    Route::post('/add/employee_transfer', 'EmployeeTransferController@store');
    Route::get('/edit/employee_transfer/{id}', 'EmployeeTransferController@edit');
    Route::delete('/delete/employee_transfer/{id}', 'EmployeeTransferController@destroy');
    Route::post('/approveOrReject/employee_transfer', 'EmployeeTransferController@approveOrReject');
    Route::get('/promotion_increment_info/employees/{id}', 'EmployeeController@promotion_increment_info');
    Route::post('/promotion/employees', 'EmployeeController@employee_promotion');

    Route::get('/holidaysetup/list', 'HolidaySetupController@index');
    Route::get('/create/holidaysetup', 'HolidaySetupController@create');
    Route::post('/add/holidaysetup', 'HolidaySetupController@store');
    Route::get('/edit/holidaysetup/{id}', 'HolidaySetupController@edit');
    Route::delete('/delete/holidaysetup/{id}', 'HolidaySetupController@destroy');

    Route::get('/officetimesetup/list', 'OfficeTimeSetupController@index');
    Route::get('/create/officetimesetup', 'OfficeTimeSetupController@create');
    Route::post('/add/officetimesetup', 'OfficeTimeSetupController@store');
    Route::get('/edit/officetimesetup/{id}', 'OfficeTimeSetupController@edit');
    Route::delete('/delete/officetimesetup/{id}', 'OfficeTimeSetupController@destroy');

    Route::get('/attendancesetup/list', 'AttendanceSetupController@index');
    Route::get('/attendance_log/list', 'AttendanceSetupController@attendance_log');
    Route::get('/create/attendancesetup', 'AttendanceSetupController@create');
    Route::post('/add/attendancesetup', 'AttendanceSetupController@store');
    Route::get('/edit/attendancesetup/{id}', 'AttendanceSetupController@edit');
    Route::delete('/delete/attendancesetup/{id}', 'AttendanceSetupController@destroy');
    Route::post('/approveOrReject/manualattendance', 'ManualAttendanceController@approveOrReject');
    Route::get('/emp_create/manualattendance/{id}', 'ManualAttendanceController@create');
    // Route::get('/report_list','ReportController@find_report');
    Route::get('/report_list/report', 'ReportController@find_report');

    // Route::get('/geilist','ReportController@find_report');
    Route::post('/getlist/report', 'ReportController@search_report');
    // Route::resource('photo', 'ReportController');

    Route::POST('/get_report', 'ReportController@empploy_report');

    Route::get('/attendancemachine/list', 'AttendanceMachineController@index');
    Route::get('/create/attendancemachine', 'AttendanceMachineController@create');
    Route::post('/add/attendancemachine', 'AttendanceMachineController@store');
    Route::get('/edit/attendancemachine/{id}', 'AttendanceMachineController@edit');
    Route::delete('/delete/attendancemachine/{id}', 'AttendanceMachineController@destroy');

    Route::get('/bank_n_branch/list', 'BankNBranchController@index');
    Route::get('/create/bank_n_branch', 'BankNBranchController@create');
    Route::post('/add/bank_n_branch', 'BankNBranchController@store');
    Route::get('/edit/bank_n_branch/{id}', 'BankNBranchController@edit');
    Route::delete('/delete/bank_n_branch/{id}', 'BankNBranchController@destroy');

    Route::get('/educational_qualification_list/list', 'EducationalQualificationListController@index');
    Route::get('/create/educational_qualification_list', 'EducationalQualificationListController@create');
    Route::post('/add/educational_qualification_list', 'EducationalQualificationListController@store');
    Route::get('/edit/educational_qualification_list/{id}', 'EducationalQualificationListController@edit');
    Route::delete('/delete/educational_qualification_list/{id}', 'EducationalQualificationListController@destroy');

    Route::get('/section/list', 'SectionController@index');
    Route::get('/create/section', 'SectionController@create');
    Route::post('/add/section', 'SectionController@store');
    Route::get('/edit/section/{id}', 'SectionController@edit');
    Route::delete('/delete/section/{id}', 'SectionController@destroy');

    Route::get('/sub_section/list', 'SubSectionController@index');
    Route::get('/create/sub_section', 'SubSectionController@create');
    Route::post('/add/sub_section', 'SubSectionController@store');
    Route::get('/edit/sub_section/{id}', 'SubSectionController@edit');
    Route::delete('/delete/sub_section/{id}', 'SubSectionController@destroy');

    Route::get('/employee_group/list', 'EmployeeGroupController@index');
    Route::get('/create/employee_group', 'EmployeeGroupController@create');
    Route::post('/add/employee_group', 'EmployeeGroupController@store');
    Route::get('/edit/employee_group/{id}', 'EmployeeGroupController@edit');
    Route::delete('/delete/employee_group/{id}', 'EmployeeGroupController@destroy');

    Route::get('/unit/list', 'UnitController@index');
    Route::get('/create/unit', 'UnitController@create');
    Route::post('/add/unit', 'UnitController@store');
    Route::get('/edit/unit/{id}', 'UnitController@edit');
    Route::delete('/delete/unit/{id}', 'UnitController@destroy');


    Route::get('/subunit/list', 'SubUnitController@index');
    Route::get('/create/subunit', 'SubUnitController@create');
    Route::post('/add/subunit', 'SubUnitController@store');
    Route::get('/edit/subunit/{id}', 'SubUnitController@edit');
    Route::delete('/delete/subunit/{id}', 'SubUnitController@destroy');

    Route::get('/worklocation/list', 'WorkLocationController@index');
    Route::get('/create/worklocation', 'WorkLocationController@create');
    Route::post('/add/worklocation', 'WorkLocationController@store');
    Route::get('/edit/worklocation/{id}', 'WorkLocationController@edit');
    Route::delete('/delete/worklocation/{id}', 'WorkLocationController@destroy');

    Route::get('/floors/list', 'FloorController@index');
    Route::get('/create/floors', 'FloorController@create');
    Route::post('/add/floors', 'FloorController@store');
    Route::get('/edit/floors/{id}', 'FloorController@edit');
    Route::delete('/delete/floors/{id}', 'FloorController@destroy');

    Route::get('/workarea/list', 'WorkAreaController@index');
    Route::get('/create/workarea', 'WorkAreaController@create');
    Route::post('/add/workarea', 'WorkAreaController@store');
    Route::get('/edit/workarea/{id}', 'WorkAreaController@edit');
    Route::delete('/delete/workarea/{id}', 'WorkAreaController@destroy');

    Route::get('/usersetting/list', 'UserSettingController@index');
    Route::get('/create/usersetting', 'UserSettingController@create');
    Route::post('/add/usersetting', 'UserSettingController@store');
    Route::get('/edit/usersetting/{id}', 'UserSettingController@edit');
    Route::delete('/delete/usersetting/{id}', 'UserSettingController@destroy');

    Route::get('/manualattendance/list', 'ManualAttendanceController@index');
    Route::get('/create/manualattendance', 'ManualAttendanceController@create');
    Route::post('/add/manualattendance', 'ManualAttendanceController@store');

    Route::get('/edit/manualattendance/{id}', 'ManualAttendanceController@edit');
    Route::delete('/delete/manualattendance/{id}', 'ManualAttendanceController@destroy');

    Route::delete('/hard_delete/manualattendance/{id}', 'ManualAttendanceController@hard_delete');

    Route::delete('/find_shift_time/manualattendance//{id}', 'ManualAttendanceController@find_shift_time');
    Route::post('/shift_finds', 'ManualAttendanceController@find_shift_time_get');
    // Route::get('/multi_create/manualattendance', 'ManualAttendanceController@create');

    Route::post('/multi_add/manualattendance', 'ManualAttendanceController@multi_store');


    Route::get('/fiscalyear/list', 'FiscalYearController@index');
    Route::get('/create/fiscalyear', 'FiscalYearController@create');
    Route::post('/add/fiscalyear', 'FiscalYearController@store');
    Route::get('/edit/fiscalyear/{id}', 'FiscalYearController@edit');
    Route::delete('/delete/fiscalyear/{id}', 'FiscalYearController@destroy');

    Route::get('/systemsetup/list', 'SystemSetupController@index');
    Route::get('/create/systemsetup', 'SystemSetupController@create');
    Route::post('/add/systemsetup', 'SystemSetupController@store');
    Route::get('/edit/systemsetup/{id}', 'SystemSetupController@edit');
    Route::delete('/delete/systemsetup/{id}', 'SystemSetupController@destroy');

    Route::get('/doc_category_setup/list', 'DocumentCategoryController@index');
    Route::get('/create/doc_category_setup', 'EmployeeController@create');
    Route::post('/transfer/employees', 'EmployeeController@transfer');
    Route::post('/transfer/employees', 'EmployeeController@transfer');
    Route::post('/add/doc_category_setup', 'DocumentCategoryController@store');
    Route::get('/edit/doc_category_setup/{id}', 'DocumentCategoryController@edit');
    Route::delete('/delete/doc_category_setup/{id}', 'DocumentCategoryController@destroy');

    Route::get('/resignation/list', 'ResignationController@index');
    Route::get('/create/resignation', 'ResignationController@create');
    Route::post('/add/resignation', 'ResignationController@store');
    Route::get('/edit/resignation/{id}', 'ResignationController@edit');
    Route::delete('/delete/resignation/{id}', 'ResignationController@destroy');
    Route::post('/approveOrReject/resignation', 'ResignationController@approveOrReject');
    Route::get('/emp_create/resignation/{id}', 'ResignationController@emp_create');

    Route::get('/absent/list', 'AbsentController@index');
    Route::post('/absent/find', 'AbsentController@report_find');

    Route::any('/rejoin/report', 'ResignationController@rejoin_report');
    Route::get('/rejoin/list', 'ResignationController@rejoin');
    Route::get('/create/rejoin', 'ResignationController@create_rejoin');
    Route::post('/add/rejoin', 'ResignationController@store_rejoin');

    Route::get('/user_multi_permission/list', 'UserMultiPermissionController@index');
    Route::get('/employees_user_permission/{id}', 'UserMultiPermissionController@userPermissionGet');
    Route::post('/add/userMultiPermission', 'UserMultiPermissionController@store');



    Route::get('/document_folder/list', 'DocumentFolderController@index');
    Route::get('/create/document_folder', 'DocumentFolderController@create');
    Route::post('/add/document_folder', 'DocumentFolderController@store');
    Route::get('/edit/document_folder/{id}', 'DocumentFolderController@edit');
    Route::delete('/delete/document_folder/{id}', 'DocumentFolderController@destroy');

    Route::get('/file_type/list', 'FileTypeController@index');
    Route::post('/add/file_type', 'FileTypeController@store');
    Route::get('/create/file_type', 'FileTypeController@create');
    Route::get('/edit/file_type/{id}', 'FileTypeController@edit');
    Route::delete('/delete/file_type/{id}', 'FileTypeController@destroy');

    Route::get('/document_folder/folder_detail_info', 'DocumentFolderController@folder_detail_info');
    // Route::get('/document_folder/folder_detail_info_all/{id}','DocumentFolderController@folder_detail_info_all');

    Route::get('/folder_file/list', 'DocumentFileController@index');
    Route::post('/add/folder_file', 'DocumentFileController@store');
    Route::get('/create/folder_file', 'DocumentFileController@create');
    Route::get('/edit/folder_file/{id}', 'DocumentFileController@edit');
    Route::delete('/delete/folder_file/{id}', 'DocumentFileController@destroy');

    Route::get('/file_access_log/list', 'FileAccessLogController@index');
    Route::post('/add/file_access_log', 'FileAccessLogController@store');
    Route::get('/create/file_access_log', 'FileAccessLogController@create');
    Route::get('/edit/file_access_log/{id}', 'FileAccessLogController@edit');
    Route::delete('/delete/file_access_log/{id}', 'FileAccessLogController@destroy');

    Route::get('/veiw_or_download/file_access_log/{id}/{type}', 'FileAccessLogController@veiw_or_download');

    Route::get('/assets_info/list', 'AssetsInfoController@index');
    Route::post('/add/assets_info', 'AssetsInfoController@store');
    Route::get('/create/assets_info', 'AssetsInfoController@create');
    Route::get('/edit/assets_info/{id}', 'AssetsInfoController@edit');
    Route::delete('/delete/assets_info/{id}', 'AssetsInfoController@destroy');


    Route::get('/salary/list', 'SalaryController@index');
    Route::get('/create/salary', 'SalaryController@create');
    Route::post('/add/salary', 'SalaryController@store');
    Route::get('/edit/salary/{id}', 'SalaryController@edit');
    Route::delete('/delete/salary/{id}', 'SalaryController@destroy');

    Route::get('/increment/list', 'IncrementController@index');
    Route::get('/create/increment', 'IncrementController@create');
    Route::post('/add/increment', 'IncrementController@store');
    Route::get('/edit/increment/{id}', 'IncrementController@edit');
    Route::delete('/delete/increment/{id}', 'IncrementController@destroy');


    Route::get('/others_pabx_email/list', 'OthersPABXEmailController@index');
    Route::get('/create/others_pabx_email', 'OthersPABXEmailController@create');
    Route::post('/add/others_pabx_email', 'OthersPABXEmailController@store');
    Route::get('/edit/others_pabx_email/{id}', 'OthersPABXEmailController@edit');
    Route::delete('/delete/others_pabx_email/{id}', 'OthersPABXEmailController@destroy');
    Route::get('/get_employee_data', 'EmployeeController@getEmployeeData');
    Route::get('/get_employee_data_bangla', 'EmployeeController@get_employee_data_bangla');
    Route::get('/roaster_report_change', 'RoasterSetupController@find_report');
    Route::POST('/get_roaster_report_change', 'RoasterSetupController@empploy_report');
    Route::POST('/shift_update', 'RoasterSetupController@shift_update');

    Route::get('/final_settlement/list', 'FinalSettlementController@index');
    Route::get('/create/final_settlement', 'FinalSettlementController@create');
    Route::post('final_settlement/add', 'FinalSettlementController@store');
    Route::get('/edit/final_settlement/{id}', 'FinalSettlementController@edit');
    Route::delete('/delete/final_settlement/{id}', 'FinalSettlementController@destroy');
}


function payrollRoute()
{
    Route::get('/employee_information/employee_report', 'EmployeeDetailsReportController@index');
    Route::POST('/employee_get_report', 'EmployeeDetailsReportController@empploy_info_payroll_report');

    Route::get('/update/salary/{id}', 'SalaryController@user_update_salary');
    Route::get('/salary/list', 'SalaryController@index');
    Route::get('/create/salary', 'SalaryController@create');
    Route::post('/add/salary', 'SalaryController@store');
    Route::post('/store_or_update/salary', 'SalaryController@store_or_update');
    Route::get('/salary_edit/salary/{id}', 'SalaryController@edit');
    Route::get('/salary_details/salary/{id}', 'SalaryController@salary_details');
    Route::delete('/delete/salary/{id}', 'SalaryController@destroy');


    Route::get('/increment/filedownload', 'IncrementController@getDownload');
    Route::get('/increment/list', 'IncrementController@index');
    Route::get('/create/increment', 'IncrementController@create');
    Route::post('/add/increment', 'IncrementController@store');
    Route::get('/edit/increment/{id}', 'IncrementController@edit');
    Route::get('/other_create/increment/{id}', 'IncrementController@create');
    Route::delete('/delete/increment/{id}', 'IncrementController@destroy');
    Route::post('/add/excel/increment', 'IncrementController@excel');

    Route::get('/payrollprocess', 'PayrollProcessController@index');
    Route::get('/create/payrollprocess', 'PayrollProcessController@create');
    Route::post('/add/payrollprocess', 'PayrollProcessController@store');
    // Route::post('/add/shifting_setup','ShiftingSetupController@store');
    Route::get('/edit/payrollprocess/{id}', 'PayrollProcessController@edit');
    Route::delete('/delete/payrollprocess/{id}', 'PayrollProcessController@destroy');
    Route::post('/payrollprocess/fiends', 'PayrollProcessController@payrollprocess_fiends');

    Route::get('/weeklypayrollprocess/list', 'WeeklyPayrollProcessController@index');
    Route::get('/create/weeklypayrollprocess', 'WeeklyPayrollProcessController@create');
    Route::post('/add/weeklypayrollprocess', 'WeeklyPayrollProcessController@store');
    Route::get('/edit/weeklypayrollprocess/{id}', 'WeeklyPayrollProcessController@edit');
    Route::delete('/delete/weeklypayrollprocess/{id}', 'WeeklyPayrollProcessController@destroy');
    Route::post('/weeklypayrollprocess/fiends', 'WeeklyPayrollProcessController@payrollprocess_fiends');
    Route::POST('/get_weekly_report', 'WeeklyPayrollProcessController@get_weekly_report');

    Route::get('/bonus_process', 'BonusProcessController@index');
    Route::get('/create/bonus_process', 'BonusProcessController@create');
    Route::post('/add/bonus_process', 'BonusProcessController@store');
    Route::get('/edit/bonus_process/{id}', 'BonusProcessController@edit');
    Route::delete('/delete/bonus_process/{id}', 'BonusProcessController@destroy');

    Route::get('/bonus_process_list/list', 'BonusListController@index');
    Route::get('/create/bonus_process_list', 'BonusListController@create');
    Route::post('/add/bonus_process_list', 'BonusListController@store');
    Route::get('/edit/bonus_process_list/{id}', 'BonusListController@edit');
    Route::delete('/delete/bonus_process_list/{id}', 'BonusListController@destroy');
    Route::get('/bonus_process_list/details', 'BonusListController@bonus_process_list_details');
    Route::get('/pay_slip/details', 'BonusListController@pay_slip_details');
    Route::get('/final_process/bonus_process_list/{id}', 'BonusListController@final_process');
    Route::post('/final_process_submit/bonus_process_list', 'BonusListController@final_process_submit');

    Route::get('/line_setting/list', 'LineSettingController@index');
    Route::get('/create/line_setting', 'LineSettingController@create');
    Route::post('/add/line_setting', 'LineSettingController@store');
    Route::get('/edit/line_setting/{id}', 'LineSettingController@edit');
    Route::delete('/delete/line_setting/{id}', 'LineSettingController@destroy');

    Route::get('/machine_setting/list', 'MachineSettingController@index');
    Route::get('/create/machine_setting', 'MachineSettingController@create');
    Route::post('/add/machine_setting', 'MachineSettingController@store');
    Route::get('/edit/machine_setting/{id}', 'MachineSettingController@edit');
    Route::delete('/delete/machine_setting/{id}', 'MachineSettingController@destroy');

    Route::get('/grade_setting/list', 'GradeSettingController@index');
    Route::get('/create/grade_setting', 'GradeSettingController@create');
    Route::post('/add/grade_setting', 'GradeSettingController@store');
    Route::get('/edit/grade_setting/{id}', 'GradeSettingController@edit');
    Route::delete('/delete/grade_setting/{id}', 'GradeSettingController@destroy');

    Route::get('/bundle_setting/list', 'BundleSettingController@index');
    Route::get('/create/bundle_setting', 'BundleSettingController@create');
    Route::post('/add/bundle_setting', 'BundleSettingController@store');
    Route::get('/edit/bundle_setting/{id}', 'BundleSettingController@edit');
    Route::delete('/delete/bundle_setting/{id}', 'BundleSettingController@destroy');

    Route::get('/product_setting/list', 'ProductSettingController@index');
    Route::get('/create/product_setting', 'ProductSettingController@create');
    Route::post('/add/product_setting', 'ProductSettingController@store');
    Route::get('/edit/product_setting/{id}', 'ProductSettingController@edit');
    Route::delete('/delete/product_setting/{id}', 'ProductSettingController@destroy');

    Route::get('/salary_setting/list', 'SalarySettingController@index');
    Route::get('/create/salary_setting', 'SalarySettingController@create');
    Route::post('/add/salary_setting', 'SalarySettingController@store');
    Route::get('/edit/salary_setting/{id}', 'SalarySettingController@edit');
    Route::delete('/delete/salary_setting/{id}', 'SalarySettingController@destroy');

    Route::get('/weekly_bouns_setting/list', 'WeeklyBonusSettingController@index');
    Route::get('/create/weekly_bouns_setting', 'WeeklyBonusSettingController@create');
    Route::post('/add/weekly_bouns_setting', 'WeeklyBonusSettingController@store');
    Route::get('/edit/weekly_bouns_setting/{id}', 'WeeklyBonusSettingController@edit');
    Route::delete('/delete/weekly_bouns_setting/{id}', 'WeeklyBonusSettingController@destroy');

    Route::get('/tax_setting/list', 'TaxSettingController@index');
    Route::get('/create/tax_setting', 'TaxSettingController@create');
    Route::post('/add/tax_setting', 'TaxSettingController@store');
    Route::get('/edit/tax_setting/{id}', 'TaxSettingController@edit');
    Route::delete('/delete/tax_setting/{id}', 'TaxSettingController@destroy');

    Route::get('/loan_advance/list', 'LoanAdvanceController@index');
    Route::get('/create/loan_advance', 'LoanAdvanceController@create');
    Route::post('/add/loan_advance', 'LoanAdvanceController@store');
    Route::get('/edit/loan_advance/{id}', 'LoanAdvanceController@edit');
    Route::delete('/delete/loan_advance/{id}', 'LoanAdvanceController@destroy');
    Route::get('/schedule/loan_advance/{id}', 'LoanAdvanceController@schedule');
    Route::get('/other_create/loan_advance/{id}', 'LoanAdvanceController@create');
    Route::post('/approveOrReject/loan_advance', 'LoanAdvanceController@approveOrReject');

    Route::get('/provident_fund/list', 'ProvidentFundController@index');
    Route::get('/create/provident_fund', 'ProvidentFundController@create');
    Route::get('/other_create/provident_fund/{id}', 'ProvidentFundController@create');
    Route::post('/add/provident_fund', 'ProvidentFundController@store');
    Route::get('/edit/provident_fund/{id}', 'ProvidentFundController@edit');
    Route::delete('/delete/provident_fund/{id}', 'ProvidentFundController@destroy');
    Route::get('/provident_fund/details', 'ProvidentFundController@provident_fund_details');

    Route::get('/gratuity_fund/list', 'GratuityFundController@index');
    Route::get('/create/gratuity_fund', 'GratuityFundController@create');
    Route::get('/other_create/gratuity_fund/{id}', 'GratuityFundController@create');
    Route::post('/add/gratuity_fund', 'GratuityFundController@store');
    Route::get('/edit/gratuity_fund/{id}', 'GratuityFundController@edit');
    Route::delete('/delete/gratuity_fund/{id}', 'GratuityFundController@destroy');
    Route::get('/gratuity_fund/details', 'GratuityFundController@gratuity_fund_details');


    Route::get('/arrear_others_allowance/list', 'ArrearOthersController@index');
    Route::get('/create/arrear_others_allowance', 'ArrearOthersController@create');
    Route::get('/other_create/arrear_others_allowance/{id}', 'ArrearOthersController@create');
    Route::post('/add/arrear_others_allowance', 'ArrearOthersController@store');
    Route::get('/edit/arrear_others_allowance/{id}', 'ArrearOthersController@edit');
    Route::delete('/delete/arrear_others_allowance/{id}', 'ArrearOthersController@destroy');
    Route::get('/arrear_others_allowance/details', 'GratuityFundController@gratuity_fund_details');

    Route::get('/mobile_internet_bills/filedownload', 'MobileInternetBillController@getDownload');
    Route::get('/mobile_internet_bills/list', 'MobileInternetBillController@index');
    Route::get('/create/mobile_internet_bills', 'MobileInternetBillController@create');
    Route::get('/other_create/mobile_internet_bills/{id}', 'MobileInternetBillController@create');
    Route::post('/add/mobile_internet_bills', 'MobileInternetBillController@store');
    Route::get('/edit/mobile_internet_bills/{id}', 'MobileInternetBillController@edit');
    Route::delete('/delete/mobile_internet_bills/{id}', 'MobileInternetBillController@destroy');
    Route::get('/mobile_internet_bills/details', 'MobileInternetBillController@gratuity_fund_details');

    Route::POST('/add/excel', 'MobileInternetBillController@excel');
    Route::get('/payroll_permission/list', 'PayrollPermissionController@index');
    Route::get('/create/payroll_permission', 'PayrollPermissionController@create');
    Route::get('/other_create/payroll_permission/{id}', 'PayrollPermissionController@create');
    Route::post('/add/payroll_permission', 'PayrollPermissionController@store');
    Route::get('/edit/payroll_permission/{id}', 'PayrollPermissionController@edit');
    Route::delete('/delete/payroll_permission/{id}', 'PayrollPermissionController@destroy');
    Route::get('/payroll_permission/details', 'PayrollPermissionController@gratuity_fund_details');
    Route::post('/final_process_submit/payroll_list', 'PayrollListController@final_process_submit');


    Route::get('/payroll_list/list', 'PayrollListController@index');
    Route::get('/create/payroll_list', 'PayrollListController@create');
    Route::post('/add/payroll_list', 'PayrollListController@store');
    Route::get('/edit/payroll_list/{id}', 'PayrollListController@edit');
    Route::delete('/delete/payroll_list/{id}', 'PayrollListController@destroy');
    Route::get('/payroll_list/details', 'PayrollListController@payroll_list_details');
    Route::get('/pay_slip/details', 'PayrollListController@pay_slip_details');
    Route::get('/final_process/payroll_list/{id}', 'PayrollListController@final_process');
    Route::get('/edit/employee_salary/{process_id}/{id}', 'PayrollListController@employee_salary_edit');
    Route::post('/update/employee_salary', 'PayrollListController@employee_salary_update');
    Route::delete('/softdelete/employee_salary/{process_id}/{id}', 'PayrollListController@softdelete');

    Route::get('/weekly_payroll_list/list', 'WeeklyPayrollListController@index');
    Route::get('/create/weekly_payroll_list', 'WeeklyPayrollListController@create');
    Route::post('/add/weekly_payroll_list', 'WeeklyPayrollListController@store');
    Route::get('/edit/weekly_payroll_list/{id}', 'WeeklyPayrollListController@edit');
    Route::delete('/delete/weekly_payroll_list/{id}', 'WeeklyPayrollListController@destroy');
    Route::get('/weekly_payroll_list/details', 'WeeklyPayrollListController@payroll_list_details');
    Route::get('/final_process/weekly_payroll_list/{id}', 'WeeklyPayrollListController@final_process');
    Route::get('/edit_salary/weekly_payroll_list/{process_id}/{id}', 'WeeklyPayrollListController@weekly_employee_salary_edit');
    Route::post('/update_salary/weekly_payroll_list', 'WeeklyPayrollListController@weekly_employee_salary_update');
    Route::delete('/softdelete/weekly_payroll_list/{process_id}/{id}', 'WeeklyPayrollListController@weekly_softdelete');

    Route::get('/pay_slip/list', 'PaySlipController@index');
    Route::get('/create/pay_slip', 'PaySlipController@create');
    Route::post('/add/pay_slip', 'PaySlipController@store');
    Route::get('/edit/pay_slip/{id}', 'PaySlipController@edit');
    Route::delete('/delete/pay_slip/{id}', 'PaySlipController@destroy');

    Route::get('/payroll_permission_assign/list', 'PayrollPermissionAssignController@index');
    Route::get('/create/payroll_permission_assign', 'PayrollPermissionAssignController@create');
    Route::post('/add/payroll_permission_assign', 'PayrollPermissionAssignController@store');
    Route::get('/edit/payroll_permission_assign/{id}', 'PayrollPermissionAssignController@edit');
    Route::delete('/delete/payroll_permission_assign/{id}', 'PayrollPermissionAssignController@destroy');

    Route::get('/others_deduction/list', 'OthersDeductionController@index');
    Route::get('/get_deduction_type', 'OthersDeductionController@get_deduction_type');
    Route::get('/create/others_deduction', 'OthersDeductionController@create');
    Route::post('/add/others_deduction', 'OthersDeductionController@store');
    Route::post('/add/others_deduction_excel', 'OthersDeductionController@excel');
    Route::get('/others_deduction_excel/filedownload', 'OthersDeductionController@getDownload');
    Route::get('/edit/others_deduction/{id}', 'OthersDeductionController@edit');
    Route::delete('/delete/others_deduction/{id}', 'OthersDeductionController@destroy');

    Route::get('/sim_inventory/list', 'SimInventoryController@index');
    Route::get('/create/sim_inventory', 'SimInventoryController@create');
    Route::post('/add/sim_inventory', 'SimInventoryController@store');
    Route::get('/edit/sim_inventory/{id}', 'SimInventoryController@edit');
    Route::delete('/delete/sim_inventory/{id}', 'SimInventoryController@destroy');

    Route::get('/sim_allocation/list', 'SimAllocationController@index');
    Route::get('/create/sim_allocation', 'SimAllocationController@create');
    Route::post('/add/sim_allocation', 'SimAllocationController@store');
    Route::get('/edit/sim_allocation/{id}', 'SimAllocationController@edit');
    Route::delete('/delete/sim_allocation/{id}', 'SimAllocationController@destroy');

    Route::get('/over_time/list', 'OverTimeController@index');
    Route::get('/create/over_time', 'OverTimeController@create');
    Route::post('/add/over_time', 'OverTimeController@store');
    Route::get('/edit/over_time/{id}', 'OverTimeController@edit');
    Route::delete('/delete/over_time/{id}', 'OverTimeController@destroy');

    Route::get('/attendance_bonus/list', 'AttendanceBonusController@index');
    Route::get('/create/attendance_bonus', 'AttendanceBonusController@create');
    Route::post('/add/attendance_bonus', 'AttendanceBonusController@store');
    Route::get('/edit/attendance_bonus/{id}', 'AttendanceBonusController@edit');
    Route::delete('/delete/attendance_bonus/{id}', 'AttendanceBonusController@destroy');

    Route::get('/time_production_rate/list', 'TimeNProductionRateController@index');
    Route::get('/create/time_production_rate', 'TimeNProductionRateController@create');
    Route::post('/add/time_production_rate', 'TimeNProductionRateController@store');
    Route::get('/edit/time_production_rate/{id}', 'TimeNProductionRateController@edit');
    Route::delete('/delete/time_production_rate/{id}', 'TimeNProductionRateController@destroy');


    Route::get('/edit/payrollprocess/{id}', 'PayrollProcessController@edit');
    Route::delete('/delete/payrollprocess/{id}', 'PayrollProcessController@destroy');
    Route::post('/payrollprocess/fiends', 'PayrollProcessController@payrollprocess_fiends');

    Route::get('/salary_setting/list', 'SalarySettingController@index');
    Route::get('/create/salary_setting', 'SalarySettingController@create');
    Route::post('/add/salary_setting', 'SalarySettingController@store');
    Route::get('/edit/salary_setting/{id}', 'SalarySettingController@edit');
    Route::delete('/delete/salary_setting/{id}', 'SalarySettingController@destroy');

    Route::get('/tax_setting/list', 'TaxSettingController@index');
    Route::get('/create/tax_setting', 'TaxSettingController@create');
    Route::post('/add/tax_setting', 'TaxSettingController@store');
    Route::get('/edit/tax_setting/{id}', 'TaxSettingController@edit');
    Route::delete('/delete/tax_setting/{id}', 'TaxSettingController@destroy');

    Route::get('/loan_advance/list', 'LoanAdvanceController@index');
    Route::get('/create/loan_advance', 'LoanAdvanceController@create');
    Route::post('/add/loan_advance', 'LoanAdvanceController@store');
    Route::get('/edit/loan_advance/{id}', 'LoanAdvanceController@edit');
    Route::delete('/delete/loan_advance/{id}', 'LoanAdvanceController@destroy');
    Route::get('/schedule/loan_advance/{id}', 'LoanAdvanceController@schedule');
    Route::get('/other_create/loan_advance/{id}', 'LoanAdvanceController@create');
    Route::post('/approveOrReject/loan_advance', 'LoanAdvanceController@approveOrReject');

    Route::get('/provident_fund/list', 'ProvidentFundController@index');
    Route::get('/create/provident_fund', 'ProvidentFundController@create');
    Route::get('/other_create/provident_fund/{id}', 'ProvidentFundController@create');
    Route::post('/add/provident_fund', 'ProvidentFundController@store');
    Route::get('/edit/provident_fund/{id}', 'ProvidentFundController@edit');
    Route::delete('/delete/provident_fund/{id}', 'ProvidentFundController@destroy');
    Route::get('/provident_fund/details', 'ProvidentFundController@provident_fund_details');

    Route::get('/gratuity_fund/list', 'GratuityFundController@index');
    Route::get('/create/gratuity_fund', 'GratuityFundController@create');
    Route::get('/other_create/gratuity_fund/{id}', 'GratuityFundController@create');
    Route::post('/add/gratuity_fund', 'GratuityFundController@store');
    Route::get('/edit/gratuity_fund/{id}', 'GratuityFundController@edit');
    Route::delete('/delete/gratuity_fund/{id}', 'GratuityFundController@destroy');
    Route::get('/gratuity_fund/details', 'GratuityFundController@gratuity_fund_details');


    Route::get('/arrear_others_allowance/list', 'ArrearOthersController@index');
    Route::get('/create/arrear_others_allowance', 'ArrearOthersController@create');
    Route::get('/other_create/arrear_others_allowance/{id}', 'ArrearOthersController@create');
    Route::post('/add/arrear_others_allowance', 'ArrearOthersController@store');
    Route::post('/excel/arrear_others_allowance', 'ArrearOthersController@excel');
    Route::get('/arrear_others_allowance/filedownload', 'ArrearOthersController@getDownload');
    Route::get('/edit/arrear_others_allowance/{id}', 'ArrearOthersController@edit');
    Route::delete('/delete/arrear_others_allowance/{id}', 'ArrearOthersController@destroy');
    Route::get('/arrear_others_allowance/details', 'GratuityFundController@gratuity_fund_details');

    Route::get('/mobile_internet_bills/list', 'MobileInternetBillController@index');
    Route::get('/create/mobile_internet_bills', 'MobileInternetBillController@create');
    Route::get('/other_create/mobile_internet_bills/{id}', 'MobileInternetBillController@create');
    Route::post('/add/mobile_internet_bills', 'MobileInternetBillController@store');
    Route::get('/edit/mobile_internet_bills/{id}', 'MobileInternetBillController@edit');
    Route::get('/mobile_bill_update', 'MobileInternetBillController@mobile_bill_update');
    Route::get('/mobile_bill_update_request', 'MobileInternetBillController@mobile_bill_update_request');
    Route::delete('/delete/mobile_internet_bills/{id}', 'MobileInternetBillController@destroy');
    Route::get('/mobile_internet_bills/details', 'MobileInternetBillController@gratuity_fund_details');

    Route::POST('/add/excel', 'MobileInternetBillController@excel');
    Route::get('/payroll_permission/list', 'PayrollPermissionController@index');
    Route::get('/create/payroll_permission', 'PayrollPermissionController@create');
    Route::get('/other_create/payroll_permission/{id}', 'PayrollPermissionController@create');
    Route::post('/add/payroll_permission', 'PayrollPermissionController@store');
    Route::get('/edit/payroll_permission/{id}', 'PayrollPermissionController@edit');
    Route::delete('/delete/payroll_permission/{id}', 'PayrollPermissionController@destroy');
    Route::get('/payroll_permission/details', 'PayrollPermissionController@gratuity_fund_details');
    Route::post('/final_process_submit/payroll_list', 'PayrollListController@final_process_submit');

    Route::get('/pay_slip/list', 'PaySlipController@index');
    Route::get('/create/pay_slip', 'PaySlipController@create');
    Route::post('/add/pay_slip', 'PaySlipController@store');
    Route::get('/edit/pay_slip/{id}', 'PaySlipController@edit');
    Route::delete('/delete/pay_slip/{id}', 'PaySlipController@destroy');

    Route::get('/payroll_permission_assign/list', 'PayrollPermissionAssignController@index');
    Route::get('/create/payroll_permission_assign', 'PayrollPermissionAssignController@create');
    Route::post('/add/payroll_permission_assign', 'PayrollPermissionAssignController@store');
    Route::get('/edit/payroll_permission_assign/{id}', 'PayrollPermissionAssignController@edit');
    Route::delete('/delete/payroll_permission_assign/{id}', 'PayrollPermissionAssignController@destroy');

    Route::get('/deduction_option/list', 'DeductionOptionController@index');
    Route::get('/create/deduction_option', 'DeductionOptionController@create');
    Route::post('/add/deduction_option', 'DeductionOptionController@store');
    Route::get('/edit/deduction_option/{id}', 'DeductionOptionController@edit');
    Route::delete('/delete/deduction_option/{id}', 'DeductionOptionController@destroy');
    Route::get('/schedule/deduction_option/{id}', 'DeductionOptionController@schedule');
    Route::get('/other_create/deduction_option/{id}', 'DeductionOptionController@create');
    Route::post('/approveOrReject/deduction_option', 'DeductionOptionController@approveOrReject');

    Route::get('/sim_inventory/list', 'SimInventoryController@index');
    Route::get('/create/sim_inventory', 'SimInventoryController@create');
    Route::post('/add/sim_inventory', 'SimInventoryController@store');
    Route::get('/edit/sim_inventory/{id}', 'SimInventoryController@edit');
    Route::delete('/delete/sim_inventory/{id}', 'SimInventoryController@destroy');

    Route::get('/sim_allocation/list', 'SimAllocationController@index');
    Route::get('/create/sim_allocation', 'SimAllocationController@create');
    Route::post('/add/sim_allocation', 'SimAllocationController@store');
    Route::get('/edit/sim_allocation/{id}', 'SimAllocationController@edit');
    Route::delete('/delete/sim_allocation/{id}', 'SimAllocationController@destroy');

    Route::get('/over_time/list', 'OverTimeController@index');
    Route::get('/create/over_time', 'OverTimeController@create');
    Route::post('/add/over_time', 'OverTimeController@store');
    Route::get('/edit/over_time/{id}', 'OverTimeController@edit');
    Route::delete('/delete/over_time/{id}', 'OverTimeController@destroy');

    Route::get('/attendance_bonus/list', 'AttendanceBonusController@index');
    Route::get('/create/attendance_bonus', 'AttendanceBonusController@create');
    Route::post('/add/attendance_bonus', 'AttendanceBonusController@store');
    Route::get('/edit/attendance_bonus/{id}', 'AttendanceBonusController@edit');
    Route::delete('/delete/attendance_bonus/{id}', 'AttendanceBonusController@destroy');

    Route::get('/daily_production_list', 'DailyProductionController@daily_production_list');
    Route::post('/daily_production/change_status', 'DailyProductionController@change_status');
    Route::post('/daily_production/change_status_all', 'DailyProductionController@change_status_all');
    Route::get('/daily_production_report', 'DailyProductionController@daily_production_report');
    Route::get('/daily_production_entry/list', 'DailyProductionController@index');
    Route::get('/create/daily_production_entry', 'DailyProductionController@create');
    Route::post('/add/daily_production_entry', 'DailyProductionController@store');
    Route::post('/daily_production_entry/find_employee', 'DailyProductionController@find_employee');
    Route::get('/edit/daily_production_entry/{id}', 'DailyProductionController@edit');
    Route::delete('/delete/daily_production_entry/{id}', 'DailyProductionController@destroy');

    Route::get('/ot_adjustment/setup', 'OtAdjustmentController@index');
    Route::get('/ot_adjustment/list', 'OtAdjustmentController@ot_list');
    Route::post('/daily_ot/change_status', 'OtAdjustmentController@change_status');
    Route::post('/daily_ot/change_status_all', 'OtAdjustmentController@change_status_all');
    Route::post('/ot_time/find', 'OtAdjustmentController@shift_time');
    Route::post('/add/ot_setup', 'OtAdjustmentController@store');

    Route::get('/ot_report/report', 'OtAdjustmentController@ot_report');
    Route::get('/weekly_payroll_report/report', 'WeeklyPayrollProcessController@weekly_payroll_report');

    Route::POST('/cash_salary_report', 'WeeklyPayrollProcessController@cash_salary_report');
    Route::POST('/bank_salary_report', 'WeeklyPayrollProcessController@bank_salary_report');
    Route::POST('/details_salary_report', 'WeeklyPayrollProcessController@details_salary_report');
    Route::POST('/pay_slip_report', 'WeeklyPayrollProcessController@pay_slip_report');
    Route::POST('/ot_report', 'WeeklyPayrollProcessController@ot_report');
    Route::POST('/salary_list_report', 'WeeklyPayrollProcessController@salary_list_report');

    Route::POST('/get_weekly_report', 'WeeklyPayrollProcessController@get_weekly_report');
    Route::POST('/get_weekly_report_payment_a', 'WeeklyPayrollProcessController@get_weekly_report_payment_a');
    Route::POST('/get_weekly_report_payment_b', 'WeeklyPayrollProcessController@get_weekly_report_payment_b');
    Route::POST('/get_weekly_report_payment_c', 'WeeklyPayrollProcessController@get_weekly_report_payment_c');
    Route::POST('/get_weekly_report_ledger', 'WeeklyPayrollProcessController@get_weekly_report_ledger');
    Route::POST('/get_weekly_report_deduction', 'WeeklyPayrollProcessController@get_weekly_report_deduction');
    Route::POST('/get_weekly_report_payroll', 'WeeklyPayrollProcessController@get_weekly_report_payroll');
    Route::POST('/get_report', 'OtAdjustmentController@empploy_report');
}

Route::get('/getUserInfo', 'MasterController@getUserInfo');
Route::get('/dashboard_appraisal', 'AppraisalController@index');
Route::get('/user_wise_emp', 'API\DepartmentAPIController@user_wise_emp');


Route::resource('departments', 'API\DepartmentAPIController');
Route::get('departments_all', 'API\DepartmentAPIController@allDept');
Route::get('dept_permission', 'API\DepartmentAPIController@dept_permission');
Route::get('department_setting', 'API\DepartmentAPIController@department_setting');
Route::get('singel_dept/{id}', 'API\DepartmentAPIController@singel_dept');
Route::get('monthly_date_range', 'API\DepartmentAPIController@monthly_date_range');
Route::post('department_settings_update', 'API\DepartmentSettingAPIController@department_settings_update');

Route::resource('k_r_a_s', 'API\KRAAPIController');

Route::get('kra_kpi_mos_tree', 'API\KRAAPIController@kra_kpi_mos_tree');
Route::resource('k_p_i_s', 'API\KPIAPIController');

Route::resource('daily_schedules', 'API\DailyScheduleAPIController');
Route::get('my_daily_schedules', 'API\DailyScheduleAPIController@my_daily_schedules');
Route::get('role', 'API\RoleAPIController@index');
Route::get('kar_kpi_mos_chart', 'API\KRAAPIController@kar_kpi_mos_chart');
Route::post('kra_kpi_setting', 'API\KRAAPIController@kra_kpi_setting');
Route::get('kra_kpi_mos', 'API\KRAAPIController@kra_kpi_mos');
Route::get('kra_delete/{id}', 'API\KRAAPIController@kra_delete');
Route::get('kpi_delete/{id}', 'API\KRAAPIController@kpi_delete');
Route::get('mos_delete/{id}', 'API\KRAAPIController@mos_delete');
Route::get('kra_kpi_mos_dashboard_user', 'API\MOSAPIController@kra_kpi_mos_dashboard_user');
Route::get('kra_kpi_mos_list_user', 'API\MOSAPIController@kra_kpi_mos_list_user');
Route::get('kra_kpi_mos_list', 'API\MOSAPIController@kra_kpi_mos_list');
Route::get('kra_kpi_mos_list2', 'API\MOSAPIController@kra_kpi_mos_list2');
Route::get('kra_details/{id}', 'API\KRAAPIController@kra_details');
Route::get('kpi_details/{id}', 'API\KPIAPIController@kpi_details');
Route::get('bpt_report', 'API\KRAAPIController@bpt_report');
//Route::get('get_task', 'API\DailyScheduleAPIController@getTask');
Route::resource('monthly_reports', 'API\MonthlyReportAPIController');
Route::post('monthly_report_comment', 'API\MonthlyReportAPIController@monthly_report_comment');
Route::get('monthly_report_mail/{dept}/{month}', 'API\MonthlyReportAPIController@monthly_report_mail');
Route::post('monthly_reports_file_upload', 'API\MonthlyReportAPIController@new_file');
Route::resource('monthly_reports_file', 'API\MonthlyReportFileAPIController');
Route::resource('m_o_s', 'API\MOSAPIController');
Route::post('mos_update', 'API\MOSAPIController@mos_update');
Route::resource('m_o_s', 'API\MOSAPIController');
Route::resource('mos_datas', 'API\MosDataAPIController');
Route::resource('mos_datas_user', 'API\MosDataUserAPIController');
Route::resource('tour_users', 'API\TourUserAPIController');
Route::resource('questions', 'API\QuestionAPIController');
Route::get('jd_qus/{user_id}', 'API\QuestionAPIController@jd_qus');
Route::post('update_store', 'API\QuestionAPIController@update_store');
Route::resource('answers', 'API\AnswerAPIController');
Route::resource('user_answers', 'API\UserAnswerAPIController');
Route::resource('answer_results', 'API\AnswerResultAPIController');
Route::resource('user_m_os', 'API\UserMOSAPIController');


Route::get('departmentSelect2', 'API\DepartmentAPIController@departmentSelect2');
Route::get('sbuSelect2', 'hrm\CompanySbuController@sbuSelect2');
Route::get('unitSelect2', 'hrm\UnitController@unitSelect2');
Route::get('subUnitSelect2', 'hrm\SubUnitController@subUnitSelect2');
Route::get('sectionSelect2', 'hrm\SectionController@sectionSelect2');
Route::get('subSectionSelect2', 'hrm\SubSectionController@subSectionSelect2');
Route::get('workLocationSelect2', 'hrm\WorkLocationController@workLocationSelect2');
Route::get('employeeSelect2', 'hrm\EmployeeController@employeeSelect2');
// }
