<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
https://www.itsolutionstuff.com/post/laravel-8-rest-api-with-passport-authentication-tutorialexample.html
use App\Http\Controllers\NDoptorUserData;
use App\Http\Controllers\API\LoginController;
*/

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\SettingsController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\MyProfileController;
use App\Http\Controllers\API\AppealCaseController;
use App\Http\Controllers\API\CaseRegisterController;
use App\Http\Controllers\API\CitizenRegisterController as APICitizenRegisterController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\CitizenRegisterApiController;
use App\Http\Controllers\CitizenRegisterController;
use App\Http\Controllers\NDoptorUserData;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('case/test2', [LoginController::class, 'test'])->name('case.test2');
Route::post('login', [LoginController::class, 'login']);

Route::post('login/cdap', [LoginController::class, 'cdap_user_login_verify']);


Route::post('citizen/registration/otp/send/{role_id}', [APICitizenRegisterController::class, 'citizen_registration_otp_send']);
Route::post('citizen/registration/otp/verify/{user_id}', [APICitizenRegisterController::class, 'citizen_registration_otp_verify']);
Route::post('citizen/registration/password/reset', [APICitizenRegisterController::class, 'citizen_registration_password_reset']);
Route::post('citizen/registration/nid/verify/store', [APICitizenRegisterController::class, 'citizen_registration_nid_verify_store']);
Route::post('citizen/registration/manually/verify/store', [APICitizenRegisterController::class, 'citizen_registration_manually_verify_store']);
Route::post('/registration/citizen/reg/opt/resend/{user_id}', [APICitizenRegisterController::class, 'mobile_first_registration_otp_resend']);
route::post('/getdependentorganization', [APICitizenRegisterController::class, 'getDependentOrganization']);
route::post('/getdependentorganizationtype', [APICitizenRegisterController::class, 'getDependentOrganizationtype']);
route::post('/getdependentOfficeName/{id}', [APICitizenRegisterController::class, 'getdependentOfficeName']);
route::post('/citizen/registration/with/password', [APICitizenRegisterController::class, 'CitizenRegistrationWithPassword']);
route::post('/user_check_forget_password', [APICitizenRegisterController::class, 'user_check_forget_password']);
Route::post('/mobile/first/registration/otp/verify', [APICitizenRegisterController::class, 'mobile_first_registration_otp_verify']);
Route::post('/mobile/first/password/match', [APICitizenRegisterController::class, 'mobile_first_password_match']);

Route::get('setting/division', [SettingsController::class, 'get_division_list'])->name('setting.division');
Route::get('setting/district/{id}', [SettingsController::class, 'get_district_list'])->name('setting.district');
Route::get('setting/upazila/{id}', [SettingsController::class, 'get_upazila_list'])->name('setting.upazila');
Route::get('setting/court/{id}', [SettingsController::class, 'get_court_list'])->name('setting.court');


Route::get('crpc/section/list', [SettingsController::class, 'crpc_section_list'])->name('crpc_section_list');
Route::get('cause_list', [LoginController::class, 'cause_list'])->name('cause.list');
Route::post('user_delete', [LoginController::class, 'user_delete']);

// With Auth
Route::middleware('auth:api')->group( function () {
    Route::get('case/test', [DashboardController::class, 'test'])->name('case.test');
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('court/execute', [AppealCaseController::class, 'court_execute'])->name('court.execute');
    Route::get('appeal/case/details', [AppealCaseController::class, 'appealCaseDetails']);
    Route::get('appeal/case/tracking/{id}', [AppealCaseController::class, 'appealCaseTracking']);
    Route::get('appeal/case/hearing_check/{id}', [AppealCaseController::class, 'checkHearingHostStatus']);
    Route::get('appeal/case/hearing_status/{id}', [AppealCaseController::class, 'hearingHostActiveStatusUpdate']);
    Route::get('dashboard/cause_list', [DashboardController::class, 'dashboardCauseList'])->name('dashboard.cause_list');
    Route::get('appeal/case/caseList', [AppealCaseController::class, 'caseList'])->name('case.caseList');
    Route::post('appeal/case/Store', [AppealCaseController::class, 'store']);
    Route::post('/my-profile/update-password', [AppealCaseController::class, 'update_password']);
    // OLD
    // Route::get('/dashboard/hearing-tomorrow', [DashboardController::class, 'hearing_date_tomorrow'])->name('dashboard.hearing-tomorrow');
    // Route::get('/dashboard/hearing-nextWeek', [DashboardController::class, 'hearing_date_nextWeek'])->name('dashboard.hearing-nextWeek');
    // Route::get('/dashboard/hearing-nextMonth', [DashboardController::class, 'hearing_date_nextMonth'])->name('dashboard.hearing-nextMonth');

	Route::get('case', [CaseRegisterController::class, 'index'])->name('case.index');
	Route::get('citizen/appeal/create', [CaseRegisterController::class, 'appealCreate'])->name('citizen.appeal.create.index');

	Route::get('case/all-case', [CaseRegisterController::class, 'all_case'])->name('case.all-case');
	Route::get('case/all', [CaseRegisterController::class, 'case_list'])->name('case.all');
	Route::get('case/details/{id}', [CaseRegisterController::class, 'details'])->name('case.details.id');
	// Route::get('case/test', [CaseRegisterController::class, 'test'])->name('case.tests');
	Route::get('case/dashboard', [CaseRegisterController::class, 'dashboard'])->name('case.dashboard');
	Route::get('case/case-tracking', [CaseRegisterController::class, 'case_tracking'])->name('case.case_tracking');
    Route::get('case/hearing-date', [CaseRegisterController::class, 'hearing_date'])->name('case.hearing_date');
    Route::get('case/caseNothi', [CaseRegisterController::class, 'caseNothi'])->name('case.caseNothi');

	Route::get('profile/details/{id}', [ProfileController::class, 'details'])->name('profile.details');
	Route::post('profile/update_password', [ProfileController::class, 'update_password'])->name('profile.update_password');
	Route::post('profile/profile_picture', [ProfileController::class, 'profile_picture'])->name('profile.profile_picture');


	Route::get('notification/notify', [NotificationController::class, 'notify'])->name('notification.notify');

	Route::get('/messages/user-list', [MessageController::class, 'messages'])->name('messages.users');
    Route::get('/messages/single/{id}', [MessageController::class, 'messages_single'])->name('messages.single');
    Route::get('/messages/recent', [MessageController::class, 'messages_recent'])->name('messages.recent');
    Route::get('/messages/request', [MessageController::class, 'messages_request'])->name('messages.request');
    Route::get('/messages/remove/{id}', [MessageController::class, 'messages_remove'])->name('messages.remove');
    Route::post('/messages/send', [MessageController::class, 'messages_send'])->name('messages.send');
    Route::get('messages/groups', [MessageController::class, 'messages_groups'])->name('messages.groups');

    Route::get('/my/profile/{user_id}',[MyProfileController::class,'index']);
    // Route::get('/my/profile/{user_id}',[MyProfileController::class,'index']);
    Route::get('get_notification/{roleID}/{court_id}', [NotificationController::class, 'get_notification']);
});

Route::post('test_data', function(Request $request){
    return response()->json([
        'status'=>200,
        'first_name'=>$request->first_name,
        'last_name'=>$request->last_name,
    ]);
});

/*
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    Route::resource('products', ProductController::class);
});
*/

/*
// OLd Route
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('/import/dortor/offices/live', [NDoptorUserData::class, 'import_doptor_office'])->name('import.offices.live');