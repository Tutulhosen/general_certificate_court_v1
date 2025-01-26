<?php

use Illuminate\Http\Request;

use App\Models\CaseActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\MinarController;
use App\Http\Controllers\NDoptorUserData;
use App\Http\Controllers\PagesController;
use App\Repositories\UserAgentRepository;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\AppealController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CauseListController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontHomeController;
use App\Http\Controllers\JitsiMeetController;
use App\Http\Controllers\MyprofileController;
use App\Http\Controllers\NothiListController;
use App\Http\Controllers\AppealListController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Office_ULOController;
use App\Http\Controllers\AppealTrialController;
use App\Http\Controllers\CaseMappingController;
use App\Http\Controllers\HearingTimeController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\AtCaseActionController;
use App\Http\Controllers\CaseRegisterController;
use App\Http\Controllers\FormDownLoadController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ReviewAppealController;
use App\Http\Controllers\CitizenAppealController;
use App\Http\Controllers\LogManagementController;
use App\Http\Controllers\RM_CaseActionController;
use App\Http\Controllers\AppealInitiateController;
use App\Http\Controllers\AtCaseRegisterController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ApiCitizenCheckController;
use App\Http\Controllers\CaseActivityLogController;
use App\Http\Controllers\CitizenRegisterController;
use App\Http\Controllers\RM_CaseRegisterController;
use App\Http\Controllers\NDoptorUserManagementAdmin;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\CitizenAppealListController;
use App\Http\Controllers\OtherCaseRegisterController;
use App\Http\Controllers\RM_CaseActivityLogController;
use App\Http\Controllers\OrganizationRegisterController;
use App\Http\Controllers\AppealInfo\AppealInfoController;
use App\Http\Controllers\AppealInfo\AppealViewController;
use App\Http\Controllers\CertificateAssistentManageController;
use App\Http\Controllers\AppealInfo\CitizenAppealInfoController;
use App\Http\Controllers\AppealInfo\CitizenAppealViewController;
use App\Http\Controllers\CustomcauseListController;
use App\Http\Controllers\GetAppealPdfGenerateController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\RunningAttachmentController;
use Illuminate\Support\Facades\Session;


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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();
Auth::routes([
    'login'    => true,
    'logout'   => true,
    'register' => true,
    'reset'    => true,   // for resetting passwords
    'confirm'  => false,  // for additional password confirmations
    'verify'   => false,  // for email verification
]);
// https://github.com/laravel/ui/blob/2.x/src/AuthRouteMethods.php

// Route::get('/publicHome', function () {
//     return view('public_home');
// });


// Route::get('/', function () {
//     return view('publicHomeH');
// })->name('home');



Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function () {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});
Route::post('/store-session/modal', function (Request $request) {
    Session::put('modal_shown', $request->input('value'));

    return response()->json(['message' => 'Session value stored successfully']);
});


Route::get('/', [LandingPageController::class, 'index'])->name('home');

Route::get('/privacy-policy', [LandingPageController::class, 'policy'])->name('policy');

Route::get('/login/page', [LandingPageController::class, 'show_log_in_page'])->name('show_log_in_page');

Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');

Route::get('appeal/get/shortOrderSheets/{id}', [AppealInfoController::class, 'getAppealShortOrderSheets'])->name('appeal.getShortOrderSheets');
Route::get('appeal/get/orderSheets/{id}', [AppealInfoController::class, 'getAppealOrderSheets'])->name('appeal.getOrderSheets');

Route::get('/txt', [CitizenRegisterController::class, 'txt']);
Route::get('/citizenRegister', [CitizenRegisterController::class, 'create']);
Route::get('/citizen/nid/check', [CitizenRegisterController::class, 'nid_check'])->name('citizen.nid_check');
Route::post('/citizen/nid/verify', [CitizenRegisterController::class, 'nid_verify'])->name('citizen.nid_verify');
Route::get('/citizen/mobile/check/{user_id}', [CitizenRegisterController::class, 'mobile_check'])->name('citizen.mobile_check');
Route::post('/citizen/mobile/verify', [CitizenRegisterController::class, 'mobile_verify'])->name('citizen.mobile_verify');
Route::post('/citizenRegister/store', [CitizenRegisterController::class, 'store'])->name('citizenRegister.store');

Route::get('/citizen/reg/opt/resend/{user_id}', [CitizenRegisterController::class, 'citizen_registration_otp_resend'])->name('citizen.reg.otp.resend');


Route::get('/organizationRegister', [OrganizationRegisterController::class, 'create']);
Route::get('/organization/nid/check', [OrganizationRegisterController::class, 'nid_check'])->name('organization.nid_check');
Route::post('/organization/nid/verify', [OrganizationRegisterController::class, 'nid_verify'])->name('organization.nid_verify');
Route::get('/organization/mobile/check/{user_id}', [OrganizationRegisterController::class, 'mobile_check'])->name('organization.mobile_check');
Route::post('/organization/mobile/verify', [OrganizationRegisterController::class, 'mobile_verify'])->name('organization.mobile_verify');
Route::post('/organizationRegister/store', [OrganizationRegisterController::class, 'store'])->name('organizationRegister.store');

Route::get('/organization/reg/opt/resend/{user_id}', [CitizenRegisterController::class, 'organization_registration_otp_resend'])->name('organization.reg.otp.resend');


Route::post('/csLogin', [LoginController::class, 'csLogin']);
Route::post('/administrativeLogin', [LoginController::class, 'administrativeLogin']);

Route::post('/cdap/user/verify/login', [LoginController::class, 'cdap_user_login_verify'])->name('cdap.user.verify.login');

Route::get('/logincheck', [DashboardController::class, 'logincheck']);
Route::group(['prefix' => 'generalCertificate/'], function () {
    Route::get('appealCreate', [AppealController::class, 'create'])->name('appealCreate');
    route::get('/case/dropdownlist/getdependentdistrict/{id}', [AppealController::class, 'getDependentDistrict']);
    route::get('/case/dropdownlist/getdependentupazila/{id}', [AppealController::class, 'getDependentUpazila']);
    route::get('/case/dropdownlist/getdependentcourt/{id}', [AppealController::class, 'getDependentCourt']);
    route::post('/case/dropdownlist/getdependentorganization', [AppealController::class, 'getDependentOrganization']);
    route::get('/case/dropdownlist/getdependentOfficeName/{id}', [AppealController::class, 'getdependentOfficeName']);
});

// Route::get('/', [DashboardController::class, 'logincheck']);
Route::get('public_home', [FrontHomeController::class, 'public_home']);
Route::get('hearing-case-list', [FrontHomeController::class, 'dateWaysCase'])->name('dateWaysCase');
Route::get('rm-case-hearing-list', [FrontHomeController::class, 'dateWaysRMCase'])->name('dateWaysRMCase');
Route::get('appeal_hearing_list', [FrontHomeController::class, 'appeal_hearing_list'])->name('appeal_hearing_list');

Route::get('/cause_list', [CauseListController::class, 'index'])->name('cause_list');



Route::middleware('auth')->group(function () {

    Route::get('/download/form', [FormDownLoadController::class, 'index']);
    Route::get('/download/usermanual', [FormDownLoadController::class, 'usermanual']);


    Route::get('/support/center', [SupportController::class, 'support_form_page'])->name('support.center');

    Route::get('citizen/support/center', [SupportController::class, 'citizen_support_form_page'])->name('support.center.citizen');

    Route::post('/support/center/post/form/citizen', [SupportController::class, 'support_form_post_citizen'])->name('support.form.post.citizen');

    Route::post('/support/center/post/form/office', [SupportController::class, 'support_form_post'])->name('support.form.post.officer');
    Route::get('appeal/case/trackingfilter/', [CustomcauseListController::class, 'case_tracking'])->name('appeal.case-trackingfilter');
    Route::middleware(['doptor_user_active_middlewire'])->group(function () {

        Route::post('citizen_check', [ApiCitizenCheckController::class, 'citizen_check'])->name('citizen_check');

        // appeal
        Route::middleware(['gccrouteprotect'])->group(function () {

            Route::group(['prefix' => 'appeal/', 'as' => 'appeal.'], function () {
                Route::get('create', [AppealInitiateController::class, 'create'])->name('create');
                Route::post('store', [AppealInitiateController::class, 'store'])->name('store');
                Route::get('edit/{id}', [AppealInitiateController::class, 'edit'])->name('edit');
                Route::get('delete/{id}', [AppealInitiateController::class, 'delete'])->name('delete');
                Route::post('deleteFile/{id}/{appeal_id}', [AppealInitiateController::class, 'fileDelete'])->name('fileDelete');
                Route::post('appealCitizenDelete/{id}', [AppealInitiateController::class, 'appealCitizenDelete'])->name('appealCitizenDelete');
                Route::get('modalcaseList', [AppealInitiateController::class, 'modalcaseList'])->name('modalcaseList');

                Route::get('list', [AppealListController::class, 'index'])->name('index');
                Route::get('pending_list', [AppealListController::class, 'pending_list'])->name('pending_list');
                Route::get('draft_list', [AppealListController::class, 'draft_list'])->name('draft_list');
                Route::get('rejected_list', [AppealListController::class, 'rejected_list'])->name('rejected_list');
                Route::get('all_case', [AppealListController::class, 'all_case'])->name('all_case');
                Route::get('closed_list', [AppealListController::class, 'closed_list'])->name('closed_list');
                Route::get('postponed_list', [AppealListController::class, 'postponed_list'])->name('postponed_list');
                Route::get('trial_date_list', [AppealListController::class, 'trial_date_list'])->name('trial_date_list');
                Route::get('arrest_warrent_list', [AppealListController::class, 'arrest_warrent_list'])->name('arrest_warrent_list');
                Route::get('crock_order_list', [AppealListController::class, 'crock_order_list'])->name('crock_order_list');
                Route::get('review_appeal_list', [AppealListController::class, 'review_appeal_list'])->name('review_appeal_list');
                // Route::get('trial/{id}', [AppealListController::class, 'show'])->name('details');
                Route::get('trial/{id}', [AppealTrialController::class, 'showTrialPage'])->name('trial');
                Route::post('trial/report_add', [AppealTrialController::class, 'report_add'])->name('trial.report_add');
                Route::get('trial/attendance_print/{id}', [AppealTrialController::class, 'attendance_print'])->name('trial.attendance_print');
                Route::get('status_change/{id}', [AppealTrialController::class, 'status_change'])->name('status_change');
                Route::post('/appeal/store/ontrial', [AppealTrialController::class, 'storeOnTrialInfo'])->name('appealStoreOnTrial');
                Route::get('collectPaymentList', [AppealTrialController::class, 'collectPaymentList'])->name('collectPaymentList');
                Route::get('collectPayment/{id}', [AppealTrialController::class, 'collectPaymentAmount'])->name('collectPayment');
                Route::get('printCollectPayment/{id}', [AppealTrialController::class, 'printCollectPaymentAmount'])->name('printCollectPayment');
                Route::post('save/appealPayment', [AppealTrialController::class, 'storeAppealPaymentInfo'])->name('storeAppealPaymentInfo');
                Route::get('delete/appealPaymentDelete/{id}', [AppealTrialController::class, 'deletePaymentInfoById'])->name('deleteAppealPaymentInfo');
                Route::get('getKharijApplicationSheets/{id}', [AppealTrialController::class, 'getKharijApplicationSheets'])->name('getKharijApplicationSheets');

                Route::get('/hearing/time/update', [HearingTimeController::class, 'create'])->name('hearingTimeUpdate');
                Route::post('/hearing/time/update/store', [HearingTimeController::class, 'store'])->name('hearingTimeUpdateStore');

                // Route::get('/appeal/collectPaymentList/', [AppealTrialController::class, 'collectPaymentList'])->name('collectPaymentList');


                Route::get('/nothiView/{id}', [NothiListController::class, 'nothiViewPage'])->name('nothiView');
                Route::post('/appeal/get/appealnama', 'AppealInfo\AppealInfoController@getAppealOrderSheets')->name('getAppealOrderLists');
                // Route::get('/appeal/get/appealnama', [NothiListController::class, 'nothiViewPage'])->name('nothiView');

                Route::get('/get/warrentOrderSheets/{id}', [AppealInfoController::class, 'getAppealWarrentOrderSheet'])->name('getWarrentOrderSheets');
                Route::get('/get/crockOrderSheets/{id}', [AppealInfoController::class, 'getAppealCrockOrderSheet'])->name('getCrockOrderSheets');

                Route::get('view/{id}', [AppealViewController::class, 'showAppealViewPage'])->name('appealView');

                Route::post('make/autofill/ruisition', [AppealViewController::class, 'makeAutofillRuisition'])->name('make.autofill.ruisition');
                Route::get('with/action/required', [AppealListController::class, 'appeal_with_action_required'])->name('appeal_with_action_required');

                Route::get('/old/dismiss/case', [ArchiveController::class, 'show_old_dismiss_case'])->name('old.dismiss.case');
                Route::get('/old/dismiss/case/entry/form', [ArchiveController::class, 'show_old_dsimiss_case_entry_form'])->name('old.dismiss.case.entry.from');
                Route::post('/old/dismiss/case/store', [ArchiveController::class, 'old_dsimiss_case_store'])->name('old.dismiss.case.store');
                Route::get('/old/dismiss/case/details/{id}', [ArchiveController::class, 'old_dsimiss_case_details'])->name('old.dismiss.case.details');
                Route::get('/generate-pdf/{id}', [ArchiveController::class, 'generate_pdf'])->name('generate.pdf');
                Route::post('get/dynamic/name/defulter/applicant', [AppealTrialController::class, 'get_dynamic_name_defulter_applicant'])->name('get.dynamic.name.defulter.applicant');

                Route::get('/causeList/case/entry/form', [CustomcauseListController::class, 'show_old_dsimiss_case_entry_form'])->name('causeList.case.entry.from');
                Route::post('/causelist/case/store', [CustomcauseListController::class, 'case_store'])->name('causeList.case.store');
                Route::get('/causelist/case/list', [CustomcauseListController::class, 'show_causelist'])->name('causelist.case.list');
                Route::get('/causelist/case/details/{id}', [CustomcauseListController::class, 'causelist_details'])->name('causelist.case.details');
                Route::get('/causelist/case/edit/{id}', [CustomcauseListController::class, 'causelist_edit'])->name('causelist.case.edit');
                Route::post('/causeList/case/update/from', [CustomcauseListController::class, 'causelist_update'])->name('causelist.case.update');

                Route::get('currentAppealEntryList', [AppealListController::class, 'currentAppealEntryList'])->name('currentAppealEntryList');
                Route::get('currentAppealEntryFrom', [AppealInitiateController::class, 'currentAppealEntryFrom'])->name('currentAppealEntryFrom');
                Route::post('currentAppealStore', [AppealInitiateController::class, 'currentAppealStore'])->name('currentAppealStore');
                route::get('getdependentOfficeName/{id}', [AppealInitiateController::class, 'getdependentOfficeName']);
                Route::get('runningview/{id}', [AppealViewController::class, 'runningAppealViewPage'])->name('appealrunningview');
                Route::get('runningAppeal/attachment/create/{id}', [AppealViewController::class, 'runningAppealAttachmentCreate'])->name('runningAppealAttachmentCreate');
                Route::post('/generate-pdf', [GetAppealPdfGenerateController::class, 'index'])->name('generateAppeal.pdf');
                Route::post('/attachment/adeshnama/{id}', [RunningAttachmentController::class, 'adeshnamaAttachment'])->name('adeshnama.attachment');
                Route::post('/attachment/adeshTemplete/{id}', [RunningAttachmentController::class, 'adeshTempleteAttachment'])->name('adeshTemplete.attachment');
                Route::post('/attachment/attendance/{id}', [RunningAttachmentController::class, 'attendanceAttachment'])->name('attendance.attachment');
                Route::post('/attachment/onnanno/{id}', [RunningAttachmentController::class, 'onnannoAttachment'])->name('onnanno.attachment');
                

                Route::get('currentAppealEditFrom/{id}', [AppealInitiateController::class, 'currentAppealEditFrom'])->name('currentAppealEditFrom');
                Route::post('currentAppealEdit', [AppealInitiateController::class, 'currentAppealEdit'])->name('currentAppealEdit');
            });
        });

        Route::middleware(['gccrouteprotect2'])->group(function () {
            Route::group(['prefix' => 'citizen/', 'as' => 'citizen.'], function () {
                Route::get('appeal/create/old', [CitizenAppealController::class, 'creates'])->name('appeal.create_old');
                Route::get('appeal/create', [CitizenAppealController::class, 'create'])->name('appeal.create');
                Route::post('appeal/store', [CitizenAppealController::class, 'store'])->name('appeal.store');
                Route::get('appeal/edit/{id}', [CitizenAppealController::class, 'edit'])->name('appeal.edit');
                Route::post('appeal/kharij_application', [CitizenAppealController::class, 'kharij_application'])->name('appeal.kharij_application');
                Route::get('appeal/list', [CitizenAppealListController::class, 'index'])->name('appeal.index');
                Route::get('appeal/all_case', [CitizenAppealListController::class, 'all_case'])->name('appeal.all_case');
                Route::get('appeal/pending_list', [CitizenAppealListController::class, 'pending_list'])->name('appeal.pending_list');
                Route::get('appeal/draft_list', [CitizenAppealListController::class, 'draft_list'])->name('appeal.draft_list');
                Route::get('appeal/rejected_list', [CitizenAppealListController::class, 'rejected_list'])->name('appeal.rejected_list');
                Route::get('appeal/closed_list', [CitizenAppealListController::class, 'closed_list'])->name('appeal.closed_list');
                Route::get('appeal/postponed_list', [CitizenAppealListController::class, 'postponed_list'])->name('appeal.postponed_list');
                Route::get('appeal/trial_date_list', [CitizenAppealListController::class, 'trial_date_list'])->name('appeal.trial_date_list');
                Route::get('register', [CitizenRegisterController::class, 'create'])->name('register');
                Route::get('appeal/view/{id}', [CitizenAppealViewController::class, 'showAppealViewPage'])->name('appeal.appealView');
                Route::get('nothiView/{id}', [NothiListController::class, 'citizenNothiViewPage'])->name('nothiView');
                Route::get('appeal/review/create/{id}', [ReviewAppealController::class, 'create'])->name('appeal.review.create');
                Route::post('appeal/review/store', [ReviewAppealController::class, 'store'])->name('appeal.review.store');

                Route::get('appeal/case-traking/{id}', [CitizenAppealViewController::class, 'showAppealTrakingPage'])->name('appeal.case-traking');

                Route::post('/appeal/get/appealnama', 'AppealInfo\CitizenAppealInfoController@getAppealOrderSheets')->name('getAppealOrderLists');
                // Route::get('/appeal/get/appealnama', [NothiListController::class, 'nothiViewPage'])->name('nothiView');
                //Route::get('appeal/get/orderSheets/{id}', [CitizenAppealInfoController::class, 'getAppealOrderSheets'])->name('getOrderSheets');
                Route::get('appeal/get/shortOrderSheets/{id}', [CitizenAppealInfoController::class, 'getAppealShortOrderSheets'])->name('getShortOrderSheets');
                Route::get('appeal/get/warrentOrderSheets/{id}', [CitizenAppealInfoController::class, 'getAppealWarrentOrderSheet'])->name('getWarrentOrderSheets');
                Route::get('appeal/get/crockOrderSheets/{id}', [CitizenAppealInfoController::class, 'getAppealCrockOrderSheet'])->name('getCrockOrderSheets');
                Route::get('appeal/case/trackingfilter/', [CustomcauseListController::class, 'case_tracking'])->name('appeal.case-trackingfilter');

                // Route::get('appeal/case/tracking/show/', [CustomcauseListController::class, 'case_tracking_show'])->name('appeal.case.tracking.show');
            });
        });

        Route::group(['prefix' => 'register/', 'as' => 'register.'], function () {
            Route::get('list', [RegisterController::class, 'index'])->name('list');
            Route::get('printPdf', [RegisterController::class, 'registerPrint'])->name('printPdf');
        });

        // Route::get('site_setting', [SiteSettingController::class, 'edit'])->name('app.setting.index');
        // Route::post('site_setting', [SiteSettingController::class, 'update'])->name('app.setting.update');

        // setting
        Route::get('site_setting', [SiteSettingController::class, 'edit'])->name('app.setting.index');
        Route::post('site_setting', [SiteSettingController::class, 'update'])->name('app.setting.update');

        Route::get('/home', [HomeController::class, 'index']);
        Route::get('/databaseCaseCheck', [HomeController::class, 'databaseCaseCheck']);
        Route::get('/databaseDataUpdated', [HomeController::class, 'databaseDataUpdated']);

        /////****************** Dashboard *****************/////
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/hearing-case-details/{id}', [DashboardController::class, 'hearing_case_details'])->name('dashboard.hearing-case-details');
        Route::get('/dashboard/hearing-today', [DashboardController::class, 'hearing_date_today'])->name('dashboard.hearing-today');
        Route::get('/dashboard/hearing-tomorrow', [DashboardController::class, 'hearing_date_tomorrow'])->name('dashboard.hearing-tomorrow');
        Route::get('/dashboard/hearing-nextWeek', [DashboardController::class, 'hearing_date_nextWeek'])->name('dashboard.hearing-nextWeek');
        Route::get('/dashboard/hearing-nextMonth', [DashboardController::class, 'hearing_date_nextMonth'])->name('dashboard.hearing-nextMonth');

        Route::post('/dashboard/ajax-case-status', [DashboardController::class, 'ajaxCaseStatus'])->name('dashboard.case-status-report');
        Route::post('/dashboard/ajax-payment-report', [DashboardController::class, 'ajaxPaymentReport'])->name('dashboard.payment-report');
        Route::post('/dashboard/ajax-crpc-pie-chart', [DashboardController::class, 'ajaxPieChart'])->name('dashboard.crpc-pie-chart');


        /////******************* Action *****************/////
        Route::get('/action/receive/{id}', [ActionController::class, 'receive'])->name('action.receive');
        Route::get('/action/details/{id}', [ActionController::class, 'details'])->name('action.details');
        Route::post('/action/forward', [ActionController::class, 'store'])->name('action.forward');
        Route::post('/action/createsf', [ActionController::class, 'create_sf'])->name('action.createsf');
        Route::post('/action/editsf', [ActionController::class, 'edit_sf'])->name('action.editsf');
        // Route::post('/action/hearingadd', [ActionController::class, 'hearing_add'])->name('action.hearingadd');
        // Route::get('/action/hearingadd', [ActionController::class, 'hearing_add']);
        Route::post('/action/hearingadd', [ActionController::class, 'hearing_store'])->name('action.hearingadd');
        Route::post('/action/file_store_hearing', [ActionController::class, 'file_store_hearing']);

        Route::post('/action/result_update', [ActionController::class, 'result_update'])->name('action.result_update');

        Route::get('/action/pdf_sf/{id}', [ActionController::class, 'pdf_sf'])->name('action.pdf_sf');
        Route::get('/action/testpdf', [ActionController::class, 'test_pdf'])->name('action.testpdf');

        // Route::get('ajax-file-upload-progress-bar', 'ProgressBarUploadFileController@index');
        Route::post('/action/file_store', [ActionController::class, 'file_store']);
        Route::post('/action/file_save', [ActionController::class, 'file_save']);
        Route::get('/action/getDependentCaseStatus/{id}', [ActionController::class, 'getDependentCaseStatus']);
        // Route::get('file', [FileController::class, 'index']);
        // Route::post('store-file', [FileController::class, 'store']);

        /////*************** Case Register *************/////
        // Route::resource('case', CaseRegisterController::class);
        Route::get('/case', [CaseRegisterController::class, 'index'])->name('case');
        Route::get('/case/running_case', [CaseRegisterController::class, 'running_case'])->name('case.running');
        Route::get('/case/appeal_case', [CaseRegisterController::class, 'appeal_case'])->name('case.appeal');
        Route::get('/case/complete_case', [CaseRegisterController::class, 'complete_case'])->name('case.complete');
        Route::get('/case/old', [CaseRegisterController::class, 'old_case'])->name('case.old');
        Route::get('/case/add', [CaseRegisterController::class, 'create']);
        Route::get('/case/create', [CaseRegisterController::class, 'old_case_create']);
        Route::post('/case/save', [CaseRegisterController::class, 'store']);
        Route::post('/case/saved', [CaseRegisterController::class, 'old_case_store']);
        Route::post('/case/appeal/save/{id}', [CaseRegisterController::class, 'store_appeal_case']);
        Route::get('/case/details/{id}', [CaseRegisterController::class, 'show'])->name('case.details');
        Route::get('/case/sflog/details/{id}', [CaseRegisterController::class, 'sflog_details'])->name('case.sflog.details');
        Route::get('/case/edit/{id}', [CaseRegisterController::class, 'edit'])->name('case.edit');
        Route::get('/case/old/edit/{id}', [CaseRegisterController::class, 'old_case_edit'])->name('case.old_edit');
        Route::post('/case/update/{id}', [CaseRegisterController::class, 'update']);
        Route::post('/case/old/update/{id}', [CaseRegisterController::class, 'old_case_update'])->name('case.old_update');
        Route::get('/case/appeal/create/{id}', [CaseRegisterController::class, 'create_appeal_case'])->name('case.create_appeal');
        route::get('/case/dropdownlist/getdependentdistrict/{id}', [CaseRegisterController::class, 'getDependentDistrict']);
        route::get('/case/dropdownlist/getdependentupazila/{id}', [CaseRegisterController::class, 'getDependentUpazila']);
        route::get('/court/dropdownlist/getdependentcourt/{id}', [CaseRegisterController::class, 'getDependentCourt']);
        route::get('/case/dropdownlist/getdependentmouja/{id}', [CaseRegisterController::class, 'getDependentMouja']);
        route::get('/case/dropdownlist/getdependentgp/{id}', [CaseRegisterController::class, 'getDependentGp']);
        route::post('/case/ajax_badi_del/{id}', [CaseRegisterController::class, 'ajaxBadiDelete']);
        route::post('/case/ajax_bibadi_del/{id}', [CaseRegisterController::class, 'ajaxBibadiDelete']);
        route::post('/case/ajax_survey_del/{id}', [CaseRegisterController::class, 'ajaxSurvayDelete']);


        ////********************Other Case Register*****************************///
        Route::get('/case/writ/create', [OtherCaseRegisterController::class, 'writ_create'])->name('case.writ');
        Route::get('/case/contempt/create', [OtherCaseRegisterController::class, 'contempt_create'])->name('case.contempt');
        Route::get('/case/review/create', [OtherCaseRegisterController::class, 'review_create'])->name('case.review');

        /////****************** Report Module *************/////
        Route::get('/report', [ReportController::class, 'index'])->name('report');
        Route::get('/report/case', [ReportController::class, 'caselist'])->name('report.case');
        Route::post('/report/pdf', [ReportController::class, 'pdf_generate']);
        // Route::get('/report/old-case', [ReportController::class, 'old_case']);


        //============ News Route Start ==============//
        Route::get('/news/list', [NewsController::class, 'index'])->name('news.list');
        Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
        Route::get('/news/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
        Route::post('/news/update/{id}', [NewsController::class, 'update'])->name('news.update');
        Route::get('/news/delete/{id}', [NewsController::class, 'destroy'])->name('news.delete');
        Route::get('news/status/{status}/{id}', [NewsController::class, 'status'])->name('status.update');


        //============ Case Activity Log Start ==============//
        Route::get('/case_audit', [CaseActivityLogController::class, 'index'])->name('case_audit.index');
        Route::get('/case_audit/details/{id}', [CaseActivityLogController::class, 'show'])->name('case_audit.show');
        Route::get('/case_audit/pdf-Log/{id}', [CaseActivityLogController::class, 'caseActivityPDFlog'])->name('case_audit.caseActivityPDFlog');
        Route::get('/case_audit/case_details/{id}', [CaseActivityLogController::class, 'reg_case_details'])->name('case_audit.reg_case_details');
        Route::get('/case_audit/sf/details/{id}', [CaseActivityLogController::class, 'sflog_details'])->name('case_audit.sf.details');
        //============ Case Activity Log End ==============//


        /////************** User Management **************/////
        Route::resource('user-management', UserManagementController::class);
        /////************** MY Profile **************/////
        // Route::resource('my-profile', MyprofileController::class);
        Route::get('/my-profile', [MyprofileController::class, 'index'])->name('my-profile.index');
        Route::get('/my-profile/basic', [MyprofileController::class, 'basic_edit'])->name('my-profile.basic_edit');
        Route::post('/my-profile/basic/update', [MyprofileController::class, 'basic_update'])->name('my-profile.basic_update');
        Route::get('/my-profile/image', [MyprofileController::class, 'imageUpload'])->name('my-profile.imageUpload');
        Route::post('/my-profile/image/update', [MyprofileController::class, 'image_update'])->name('my-profile.image_update');
        Route::get('/my-profile/change-password', [MyprofileController::class, 'change_password'])->name('change.password');
        Route::post('/my-profile/update-password', [MyprofileController::class, 'update_password'])->name('update.password');
        // Route::get('/my-profile', [MyprofileController::class, 'index'])->name('my-profile.index');
        /////************** Office Setting **************/////
        // Route::resource('office-setting', OfficeController::class);
        Route::get('/office', [OfficeController::class, 'index'])->name('office');
        route::get('/office/create', [OfficeController::class, 'create'])->name('office.create');
        Route::post('/office/save', [OfficeController::class, 'store'])->name('office.save');
        route::get('/office/edit/{id}', [OfficeController::class, 'edit'])->name('office.edit');
        route::post('/office/update/{id}', [OfficeController::class, 'update'])->name('office.update');
        route::get('/office/dropdownlist/getdependentdistrict/{id}', [OfficeController::class, 'getDependentDistrict']);
        route::get('/office/dropdownlist/getdependentupazila/{id}', [OfficeController::class, 'getDependentUpazila']);


        /////************** Office_ULO Setting **************/////
        // Route::resource('office_ulo-setting', Office_ULOController::class);
        Route::get('/ulo', [Office_ULOController::class, 'index'])->name('ulo');
        route::get('/ulo/create', [Office_ULOController::class, 'create'])->name('ulo.create');
        route::post('/ulo/save', [Office_ULOController::class, 'store'])->name('ulo.save');
        route::get('/ulo/edit/{id}', [Office_ULOController::class, 'edit'])->name('ulo.edit');
        route::post('/ulo/update/{id}', [Office_ULOController::class, 'update'])->name('ulo.update');
        route::get('/ulo/dropdownlist/getdependentdistrict/{id}', [Office_ULOController::class, 'getDependentDistrict']);
        route::get('/ulo/dropdownlist/getdependentupazila/{id}', [Office_ULOController::class, 'getDependentUpazila']);
        route::get('/ulo/dropdownlist/getdependentulo/{id}', [Office_ULOController::class, 'getDependentULO']);
        /////************** Court Setting **************/////
        // Route::resource('court-setting', CourtController::class);
        route::get('/court', [CourtController::class, 'index'])->name('court');
        route::get('/court/create', [CourtController::class, 'create'])->name('court.create');
        Route::post('/court/save', [CourtController::class, 'store'])->name('court.save');
        route::get('/court/edit/{id}', [CourtController::class, 'edit'])->name('court.edit');
        route::post('/court/update/{id}', [CourtController::class, 'update'])->name('court.update');
        route::get('/court-setting/dropdownlist/getdependentdistrict/{id}', [CourtController::class, 'getDependentDistrict']);
        route::get('/court-setting/dropdownlist/getDependentUpazila/{id}', [CourtController::class, 'getDependentUpazila']);

        /////************** General Setting **************/////
        // Route::resource('setting', SettingController::class);
        //=======================division===============//
        Route::get('/division', [SettingController::class, 'division_list'])->name('division');
        Route::get('/division/edit/{id}', [SettingController::class, 'division_edit'])->name('division.edit');
        Route::post('/division/update/{id}', [SettingController::class, 'division_update'])->name('division.update');

        //======================= //division===============//
        Route::get('/settings/district', [SettingController::class, 'district_list'])->name('district');
        Route::get('/settings/district/edit/{id}', [SettingController::class, 'district_edit'])->name('district.edit');
        Route::post('/settings/district/update/{id}', [SettingController::class, 'district_update'])->name('district.update');
        Route::get('/settings/upazila', [SettingController::class, 'upazila_list'])->name('upazila');
        Route::get('/settings/upazila/edit/{id}', [SettingController::class, 'upazila_edit'])->name('upazila.edit');
        Route::post('/settings/upazila/update/{id}', [SettingController::class, 'upazila_update'])->name('upazila.update');
        Route::get('/settings/mouja', [SettingController::class, 'mouja_list'])->name('mouja');
        Route::get('/settings/mouja/add', [SettingController::class, 'mouja_add'])->name('mouja-add');
        Route::get('/settings/mouja/edit/{id}', [SettingController::class, 'mouja_edit'])->name('mouja.edit');
        Route::post('/settings/mouja/save', [SettingController::class, 'mouja_save'])->name('mouja.save');
        Route::post('/settings/mouja/update/{id}', [SettingController::class, 'mouja_update'])->name('mouja.update');
        Route::get('/settings/survey', [SettingController::class, 'survey_type_list'])->name('survey');
        /*Route::get('/survey/edit/{id}', [SettingController::class, 'survey_edit'])->name('survey.edit');
        Route::post('/survey/update/{id}', [SettingController::class, 'survey_update'])->name('survey.update');*/
        Route::get('/case_type', [SettingController::class, 'case_type_list'])->name('case-type');
        Route::get('/case_status', [SettingController::class, 'case_status_list'])->name('case-status');
        Route::get('/case_status/add', [SettingController::class, 'case_status_add'])->name('case-status.add');
        Route::get('/case_status/details/{id}', [SettingController::class, 'case_status_details'])->name('case-status.details');
        Route::post('/case_status/store', [SettingController::class, 'case_status_store'])->name('case-status.store');
        Route::get('/case_status/edit/{id}', [SettingController::class, 'case_status_edit'])->name('case-status.edit');
        Route::post('/case_status/update/{id}', [SettingController::class, 'case_status_update'])->name('case-status.update');
        /*Route::get('/case_type/edit/{id}', [SettingController::class, 'case_type_edit'])->name('case_type.edit');
        Route::post('/case_type/update/{id}', [SettingController::class, 'case_type_update'])->name('case_type.update');*/
        Route::get('/court_type', [SettingController::class, 'court_type_list'])->name('court-type');
        /*Route::get('/court_type/edit/{id}', [SettingController::class, 'court_type_edit'])->name('court_type.edit');
        Route::post('/court_type/update/{id}', [SettingController::class, 'court_type_update'])->name('court_type.update');*/
        //=======================Short Decision===============//


        Route::middleware(['settings_protection_from_citizen_middlewire'])->group(function () {
            Route::get('/settings/short-decision', [SettingController::class, 'shortDecision'])->name('settings.short-decision');
            Route::get('/settings/short-decision/create', [SettingController::class, 'shortDecisionCreate'])->name('settings.short-decision.create');
            Route::post('/settings/short-decision/store', [SettingController::class, 'shortDecisionStore'])->name('settings.short-decision.store');
            Route::get('/settings/short-decision/edit/{id}', [SettingController::class, 'shortDecisionEdit'])->name('settings.short-decision.edit');
            Route::post('/settings/short-decision/update/{id}', [SettingController::class, 'shortDecisionUpdate'])->name('settings.short-decision.update');
        });


        /////************** //General Setting **************/////
        Route::resource('projects', ProjectController::class);
        Route::get('/form-layout', function () {
            return view('form_layout');
        });
        Route::get('/list', function () {
            return view('list');
        });

        //=================== Notification Start ================
        Route::get('/results_completed', [UserNotificationController::class, 'results_completed'])->name('results_completed');
        Route::get('/hearing_date', [UserNotificationController::class, 'hearing_date'])->name('hearing_date');
        Route::get('/rmcase/hearing_date', [UserNotificationController::class, 'rm_hearing_date'])->name('rm_hearing_date');
        Route::get('/new_sf_list', [UserNotificationController::class, 'newSFlist'])->name('newSFlist');
        Route::get('/new_sf_details/{id}', [UserNotificationController::class, 'newSFdetails'])->name('newSFdetails');
        //=================== Notification End ==================

        //=================== Message Start ================
        //=================== Message Start ================
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
        //=================== Message End ================
        Route::get('/messages', [MessageController::class, 'messages'])->name('messages');
        Route::get('/messages_recent', [MessageController::class, 'messages_recent'])->name('messages_recent');
        Route::get('/messages_request', [MessageController::class, 'messages_request'])->name('messages_request');
        Route::get('/messages/{id}', [MessageController::class, 'messages_single'])->name('messages_single');
        Route::get('/messages_remove/{id}', [MessageController::class, 'messages_remove'])->name('messages_remove');
        Route::post('/messages/send', [MessageController::class, 'messages_send'])->name('messages_send');
        Route::get('/messages_group', [MessageController::class, 'messages_group'])->name('messages_group');
        // Route::get('/hearing_date', [MessageController::class, 'hearing_date'])->name('hearing_date');
        // Route::get('/new_sf_list', [MessageController::class, 'newSFlist'])->name('newSFlist');
        // Route::get('/new_sf_details/{id}', [MessageController::class, 'newSFdetails'])->name('newSFdetails');
        //=================== Message End ==================
        Route::get('/script', [MessageController::class, 'script']);


        //CivilSuit-v2 AT Case Route start from here
        Route::group(['prefix' => 'atcase/', 'as' => 'atcase.'], function () {
            /********************AT Case Register Start*****************************/
            Route::get('create', [AtCaseRegisterController::class, 'create'])->name('create');
            Route::get('index', [AtCaseRegisterController::class, 'index'])->name('index');
            Route::post('store', [AtCaseRegisterController::class, 'store'])->name('store');
            Route::get('show/{id}', [AtCaseRegisterController::class, 'show'])->name('show');
            Route::get('edit/{id}', [AtCaseRegisterController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [AtCaseRegisterController::class, 'update'])->name('update');
            Route::post('ajax_badi_del/{id}', [AtCaseRegisterController::class, 'ajaxBadiDelete']);
            Route::post('ajax_bibadi_del/{id}', [AtCaseRegisterController::class, 'ajaxBibadiDelete']);
            Route::post('ajax_order_del/{id}', [AtCaseRegisterController::class, 'ajaxOrderDelete']);
            Route::post('ajax_judge_del/{id}', [AtCaseRegisterController::class, 'ajaxJudgeDelete']);

            /******************** // AT Case Register End *****************************/

            /////*******************  Action Start *****************/////
            Route::group(['prefix' => 'action/', 'as' => 'action.'], function () {
                Route::get('receive/{id}', [AtCaseActionController::class, 'receive'])->name('receive');
                Route::get('details/{id}', [AtCaseActionController::class, 'details'])->name('details');
                Route::post('forward', [AtCaseActionController::class, 'store'])->name('forward');
                Route::post('createsf', [AtCaseActionController::class, 'create_sf'])->name('createsf');
                Route::post('editsf', [AtCaseActionController::class, 'edit_sf'])->name('editsf');
                Route::post('hearingadd', [AtCaseActionController::class, 'hearing_store'])->name('hearingadd');
                Route::post('file_store_hearing', [AtCaseActionController::class, 'file_store_hearing'])->name('file_store_hearing');
                Route::post('result_update', [AtCaseActionController::class, 'result_update'])->name('result_update');
                Route::get('pdf_sf/{id}', [AtCaseActionController::class, 'pdf_sf'])->name('pdf_sf');
                Route::get('testpdf', [AtCaseActionController::class, 'test_pdf'])->name('testpdf');
                Route::post('file_store', [AtCaseActionController::class, 'file_store'])->name('file_store');
                Route::post('file_save', [AtCaseActionController::class, 'file_save']);
                Route::get('getDependentCaseStatus/{id}', [AtCaseActionController::class, 'getDependentCaseStatus']);
            });
            /////******************* // Action End *****************/////
        });

        //CivilSuit-v2 RM Case Route start from here
        Route::group(['prefix' => 'rmcase/', 'as' => 'rmcase.'], function () {
            /********************AT Case Register Start*****************************/
            Route::get('create', [RM_CaseRegisterController::class, 'create'])->name('create');
            Route::get('index', [RM_CaseRegisterController::class, 'index'])->name('index');
            Route::post('store', [RM_CaseRegisterController::class, 'store'])->name('store');
            Route::get('show/{id}', [RM_CaseRegisterController::class, 'show'])->name('show');
            Route::get('edit/{id}', [RM_CaseRegisterController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [RM_CaseRegisterController::class, 'update'])->name('update');
            Route::post('ajax_badi_del/{id}', [RM_CaseRegisterController::class, 'ajaxBadiDelete']);
            Route::post('ajax_bibadi_del/{id}', [RM_CaseRegisterController::class, 'ajaxBibadiDelete']);
            Route::post('ajax_file_del/{id}', [RM_CaseRegisterController::class, 'ajaxFileDelete']);
            Route::post('ajax_order_del/{id}', [RM_CaseRegisterController::class, 'ajaxOrderDelete']);
            Route::post('ajax_judge_del/{id}', [RM_CaseRegisterController::class, 'ajaxJudgeDelete']);
            Route::get('appeal/create/{id}', [RM_CaseRegisterController::class, 'create_appeal'])->name('create_appeal');
            Route::post('appeal/store/{id}', [RM_CaseRegisterController::class, 'store_appeal'])->name('store_appeal');


            /******************** // AT Case Register End *****************************/

            /////*******************  Action Start *****************/////
            Route::group(['prefix' => 'action/', 'as' => 'action.'], function () {
                Route::get('receive/{id}', [RM_CaseActionController::class, 'receive'])->name('receive');
                Route::get('details/{id}', [RM_CaseActionController::class, 'details'])->name('details');
                Route::post('forward', [RM_CaseActionController::class, 'store'])->name('forward');
                Route::post('createsf', [RM_CaseActionController::class, 'create_sf'])->name('createsf');
                Route::post('editsf', [RM_CaseActionController::class, 'edit_sf'])->name('editsf');
                Route::post('hearingadd', [RM_CaseActionController::class, 'hearing_store'])->name('hearingadd');
                Route::post('file_store_hearing', [RM_CaseActionController::class, 'file_store_hearing'])->name('file_store_hearing');
                Route::post('hearing_result_upload', [RM_CaseActionController::class, 'hearing_result_upload'])->name('hearing_result_upload');
                Route::post('result_update', [RM_CaseActionController::class, 'result_update'])->name('result_update');
                Route::get('pdf_sf/{id}', [RM_CaseActionController::class, 'pdf_sf'])->name('pdf_sf');
                Route::get('testpdf', [RM_CaseActionController::class, 'test_pdf'])->name('testpdf');
                Route::post('file_store', [RM_CaseActionController::class, 'file_store'])->name('file_store');
                Route::post('file_save', [RM_CaseActionController::class, 'file_save']);
                Route::get('getDependentCaseStatus/{id}', [RM_CaseActionController::class, 'getDependentCaseStatus']);
            });
            /////******************* // Action End *****************/////

            //============ RM Case Activity Log Start ==============//
            Route::get('/case_audit', [RM_CaseActivityLogController::class, 'index'])->name('case_audit.index');
            Route::get('/case_audit/details/{id}', [RM_CaseActivityLogController::class, 'show'])->name('case_audit.show');
            Route::get('/case_audit/pdf-Log/{id}', [RM_CaseActivityLogController::class, 'caseActivityPDFlog'])->name('case_audit.caseActivityPDFlog');
            Route::get('/case_audit/case_details/{id}', [RM_CaseActivityLogController::class, 'reg_case_details'])->name('case_audit.reg_case_details');
            Route::get('/case_audit/sf/details/{id}', [RM_CaseActivityLogController::class, 'sflog_details'])->name('case_audit.sf.details');
            //============ RM Case Activity Log End ==============//
        });
    });
});



Route::get('support/center/no_auth', [SupportController::class, 'support_form_page_no_auth'])->name('support.center.citizen.no.auth');

Route::post('/support/center/post/no/auth', [SupportController::class, 'support_form_post_no_auth'])->name('support.form.post.no.auth');