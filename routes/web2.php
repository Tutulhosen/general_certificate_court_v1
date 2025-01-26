<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Repositories\AppealRepository;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NDoptorUserData;
use App\Http\Controllers\NIDVerification;
use App\Http\Controllers\CauseListController;
use App\Http\Controllers\DummiDataController;
use App\Http\Controllers\JitsiMeetController;
use App\Http\Controllers\MyprofileController;
use App\Repositories\OnlineHearingRepository;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CaseMappingController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PDFgenerateController;
use App\Http\Controllers\LogManagementController;
use App\Http\Controllers\AppealInitiateController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserExitsCheckController;
use App\Http\Controllers\ApiCitizenCheckController;
use App\Http\Controllers\NDoptorUserManagementAdmin;
use App\Http\Controllers\CdapUserManagementController;
use App\Http\Controllers\OrganizationManagementController;
use App\Http\Controllers\CertificateAssistentManageController;
use App\Http\Controllers\CertificateAssistentSettingController;

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

Route::middleware('auth')->group(function () {

    Route::middleware(['doptor_user_active_middlewire'])->group(function () {

        Route::post('citizen_check', [ApiCitizenCheckController::class, 'citizen_check'])->name('citizen_check');

        Route::group(['prefix' => 'case-mapping/', 'as' => 'case-mapping.'], function () {

            Route::get('/index', [CaseMappingController::class, 'index'])->name('index');
            Route::post('/show_court', [CaseMappingController::class, 'show_court'])->name('show_court');
            Route::post('/store', [CaseMappingController::class, 'store'])->name('store');
        });

        Route::middleware(['gccrouteprotect'])->group(function () {
            Route::group(['prefix' => 'role-permission/', 'as' => 'role-permission.'], function () {

                Route::get('/index', [RolePermissionController::class, 'index'])->name('index');
                Route::post('/show_permission', [RolePermissionController::class, 'show_permission'])->name('show_permission');
                Route::post('/store', [RolePermissionController::class, 'store'])->name('store');
            });
        });

        Route::get('/jisti/meet/{appeal_id}', [JitsiMeetController::class, 'index'])->name('jitsi.meet');

        Route::get('/en2bn', function (Request $request) {
            return response()->json([
                'status' => 'success',
                'notify' => en2bn($request->notify),
            ]);
        })->name('en2bn');

        Route::middleware(['gccrouteprotect'])->group(function () {
            Route::get('/log_index', [LogManagementController::class, 'index'])->name('log.indx');
            Route::get('/log_index_search', [LogManagementController::class, 'log_index_search'])->name('log_index_search');
            Route::get('/log_index_single/{id}', [LogManagementController::class, 'log_index_single'])->name('log_index_single');
            Route::get('/create_log_pdf/{id}', [LogManagementController::class, 'create_log_pdf'])->name('create_log_pdf');
            Route::get('/log/logid/{id}', [LogManagementController::class, 'log_details_single_by_id'])->name('log_details_single_by_id');
        });

        Route::get('/doptor/user/management/office_list', [NDoptorUserData::class, 'office_list'])->name('doptor.user.management.office_list');

        Route::get('/doptor/user/management/user_list/{office_id}', [NDoptorUserData::class, 'user_list'])->name('doptor.user.management.user_list');

        Route::post('/doptor/user/management/user_list/store/gco/dc', [NDoptorUserData::class, 'user_store_gco_dc'])->name('doptor.user.management.store.gco.dc');

        Route::post('/doptor/user/management/user_list/store/gco/uno', [NDoptorUserData::class, 'user_store_gco_uno'])->name('doptor.user.management.store.gco.uno');

        Route::get('/doptor/user/management/user_list/segmented/all/{office_id}', [NDoptorUserData::class, 'all_user_list_from_doptor_segmented'])->name('doptor.user.management.user_list.segmented.all');

        Route::get('/doptor/user/management/search/user_list/segmented/all/{office_id}', [NDoptorUserData::class, 'all_user_list_from_doptor_segmented_search'])->name('doptor.search.all.members');

        Route::get('/certificate_asst/list/', [CertificateAssistentManageController::class, 'certificate_assistent_list'])->name('certificate.assistent.gco.list');

        Route::get('/certificate_asst/create/form', [CertificateAssistentManageController::class, 'certificate_assistent_create_form'])->name('certificate.assistent.gco.list.create.form');

        Route::get('/certificate_asst/create/form/search', [CertificateAssistentManageController::class, 'certificate_assistent_create_form_search'])->name('certificate.assistent.gco.list.create.form.search');

        Route::get('/certificate_asst/create/form/manual', [CertificateAssistentManageController::class, 'certificate_assistent_create_form_manual'])->name('certificate.assistent.gco.list.create.form.manual');

        Route::post('/certificate_asst/create/form/submit/manual', [CertificateAssistentManageController::class, 'certificate_assistent_create_form_manual_submit'])->name('certificate.assistent.gco.list.create.form.manual.submit');

        Route::get('/certificate_asst/update/form/{id}', [CertificateAssistentManageController::class, 'certificate_assistent_update_form'])->name('certificate.assistent.gco.list.create.form.manual.update');

        Route::post('/certificate_asst/update/form/submit/manual', [CertificateAssistentManageController::class, 'certificate_assistent_update_submit_manual'])->name('certificate.assistent.gco.list.update.form.manual.submit');

        Route::get('/certificate_asst/active/', [CertificateAssistentManageController::class, 'certificate_assistent_active'])->name('certificate.assistent.active');

        Route::post('/doptor/user/management/user_list/store/certificate/dc', [CertificateAssistentManageController::class, 'store_certificate_asst_dc'])->name('doptor.user.management.store.certificate.dc');

        Route::post('/doptor/user/management/user_list/store/gco/dc', [CertificateAssistentManageController::class, 'store_gco_dc'])->name('doptor.user.management.store.gco.dc');

        Route::post('/doptor/user/management/user_list/store/adc/dc', [CertificateAssistentManageController::class, 'store_adc_dc'])->name('doptor.user.management.store.adc.dc');

        Route::post('/doptor/user/management/user_list/store/certificate/uno', [CertificateAssistentManageController::class, 'store_certificate_asst_uno'])->name('doptor.user.management.store.certificate.uno');

        Route::get('/doptor/user/check', [NDoptorUserData::class, 'doptor_user_check']);

        /******                            User management BY admin                                       *******/
        Route::middleware(['settings_protection_from_citizen_middlewire'])->group(function () {
            Route::group(['prefix' => 'admin/doptor/management', 'as' => 'admin.doptor.management.'], function () {

                Route::post('/import/dortor/offices', [NDoptorUserData::class, 'import_doptor_office'])->name('import.offices');

                Route::get('/dropdownlist/getdependentdistrict/{id}', [NDoptorUserData::class, 'getDependentDistrictForDoptor']);
                Route::get('/dropdownlist/getdependentupazila/{id}', [NDoptorUserData::class, 'getDependentUpazilaForDoptor']);

                Route::get('/import/dortor/offices/search', [NDoptorUserData::class, 'imported_doptor_office_search'])->name('import.offices.search');

                Route::get('/user_list/segmented/all/{office_id}', [NDoptorUserManagementAdmin::class, 'all_user_list_from_doptor_segmented'])->name('user_list.segmented.all');

                Route::get('/search/user_list/segmented/all/{office_id}', [NDoptorUserManagementAdmin::class, 'all_user_list_from_doptor_segmented_search'])->name('search.all.members');

                Route::post('/divisional/commissioner/create', [NDoptorUserManagementAdmin::class, 'divisional_commissioner_create_by_admin'])->name('divisional.commissioner.create');

                Route::post('/district/commissioner/create', [NDoptorUserManagementAdmin::class, 'district_commissioner_create_by_admin'])->name('dictrict.commissioner.create');

                Route::post('/aditional/district/commissioner/create', [NDoptorUserManagementAdmin::class, 'aditional_district_commissioner_create_by_admin'])->name('aditional.dictrict.commissioner.create');

                Route::post('/dc/office/gco', [NDoptorUserManagementAdmin::class, 'gco_dc_create_by_admin'])->name('gco.dc.create');

                Route::post('/dc/office/certificate/assistent', [NDoptorUserManagementAdmin::class, 'store_certificate_asst_dc_by_admin'])->name('certificate.assistent.create.dc');

                Route::post('/uno/office/gco', [NDoptorUserManagementAdmin::class, 'gco_uno_create_by_admin'])->name('gco.uno.create');

                Route::post('/uno/office/certificate/assistent', [NDoptorUserManagementAdmin::class, 'store_certificate_asst_uno_by_admin'])->name('certificate.assistent.create.uno');

            });
            Route::get('certificate_asst-short-decision', [CertificateAssistentSettingController::class, 'shortDecision'])->name('certificate_asst.short.decision');
            Route::get('certificate_asst-short-decision/create', [CertificateAssistentSettingController::class, 'shortDecisionCreate'])->name('certificate_asst.short.decision.create');
            Route::post('certificate_asst-short-decision/store', [CertificateAssistentSettingController::class, 'shortDecisionStore'])->name('certificate_asst.short.decision.store');
            Route::get('certificate_asst-short-decision/edit/{id}', [CertificateAssistentSettingController::class, 'shortDecisionEdit'])->name('certificate_asst.short.decision.edit');
            Route::post('certificate_asst-short-decision/update/{id}', [CertificateAssistentSettingController::class, 'shortDecisionUpdate'])->name('certificate_asst.short.decision.update');

            Route::get('certificate_asst-short-decision/details/create/{id}', [CertificateAssistentSettingController::class, 'shortDecisionDetailsCreate'])->name('certificate_asst.short.decision.details.create');
            Route::post('certificate_asst-short-decision/details/store', [CertificateAssistentSettingController::class, 'shortDecisionDetailsStore'])->name('certificate_asst.short.decision.details.store');

        });

        Route::get('/get/orderSheets/pdf/{id}', [PDFgenerateController::class, 'getOrderSheetsPDF'])->name('get.orderSheets.pdf');

        /*** ** NEW ORGANIZATION ENTRY** */

        Route::get('/get/organization/list', [OrganizationManagementController::class, 'get_organization_list'])->name('get.organization.list');

        Route::get('/get/organization/details/{id}', [OrganizationManagementController::class, 'get_organization_details'])->name('get.organization.details');
        
        Route::get('/get/organization/edit/{id}', [OrganizationManagementController::class, 'get_organization_edit'])->name('get.organization.edit');

        Route::post('post/organization/update', [OrganizationManagementController::class, 'post_organization_update'])->name('post.organization.update');

        Route::get('get/organization/add', [OrganizationManagementController::class, 'get_organization_add'])->name('get.organization.add');

        Route::post('post/organization/store', [OrganizationManagementController::class, 'post_organization_add'])->name('post.organization.store');

        Route::get('get/organization/change/applicant', [OrganizationManagementController::class, 'get_organization_change_by_applicant'])->name('get.organization.change.applicant');

        Route::post('post/organization/change/applicant', [OrganizationManagementController::class, 'post_organization_change_by_applicant'])->name('post.organization.change.applicant');

        //=======================NEW Short Decision Certificate_asst===============//

        //=======================NEW Short Decision Certificate_asst===============//
        Route::post('/number/field/check', [AppealInitiateController::class, 'number_field_check'])->name('number.field.check');
        Route::post('/number/field/check/with/remainig/taka', [AppealInitiateController::class, 'number_field_check_remainig_taka'])->name('number.field.check.remainig.taka');

        Route::get('get/attendence/print/{appeal_id}/{citizen_id}/{citizen_type_id}/{citizen_name}/{citizen_designation?}', [AppealInitiateController::class, 'getAttendenceShit'])->name('get.attendence.print');

    });

    Route::post('/paginate/causelist/auth/user', [CauseListController::class, 'paginate_causelist_auth_user'])->name('paginate.causelist.auth.user');
});

Route::get('/voice_to_tex', function () {
    return view('_voice_to_text_ours');
})->name('voice_to_tex');




Route::get('/disable/certificate_asst/{level}', function ($level) {

    if ($level == 4) {

        $data['title'] = 'Disabled Peskar User';
        $data['message1'] = 'আপনাকে ডিজেবল করে রাখা হয়েছে';
        $data['message2'] = 'আপনি আনুগ্রহ করে আপনার উপজেলার , উপজেলা নির্বাহী  মহাদয়ের সাথে যোগাযোগ করুন';
    } elseif ($level == 3) {
        $data['title'] = 'Disabled Peskar User';
        $data['message1'] = 'আপনাকে ডিজেবল করে রাখা হয়েছে';
        $data['message2'] = 'আপনি আনুগ্রহ করে আপনার জেলার , জেনারেল সার্টিফিকেট অফিসার অথবা জেলা প্রশাসক মহাদয়ের সাথে যোগাযোগ করুন';
    }
    $callbackurl = url('/');
    $zoom_join_url = DOPTOR_ENDPOINT().'/logout?' . 'referer=' . base64_encode($callbackurl);
    
    $data['callbackurl']=$zoom_join_url;
    return view('certificate_assistent.disable_certificate_assistent')->with($data);
});

Route::get('/disable/doptor/user/{role}', function ($role) {

    $data['title'] = 'Disabled Doptor User';
    $data['message1'] = 'আপনাকে ডিজেবল করে রাখা হয়েছে';
    if ($role == 34) {

        $data['message2'] = 'আপনি আনুগ্রহ করে আপনি A2I , System Admin অথবা জনপ্রশাসন মন্ত্রণালয় এর সাথে যোগাযোগ করুন';
    } else if ($role == 6) {
        $data['message2'] = 'আপনি আনুগ্রহ করে আপনি A2I , System Admin অথবা জনপ্রশাসন মন্ত্রণালয় এর সাথে যোগাযোগ করুন';
    } else if ($role == 27) {
        $data['message2'] = 'আপনি আনুগ্রহ করে আপনার জেলার , জেলা প্রশাসক মহাদয়ের সাথে যোগাযোগ করুন';
    }
    $callbackurl = url('/');
    $zoom_join_url = DOPTOR_ENDPOINT().'/logout?' . 'referer=' . base64_encode($callbackurl);
    
    $data['callbackurl']=$zoom_join_url;
    
    return view('doptor.disable_doptor_user')->with($data);
});

Route::post('/username/exits', [UserExitsCheckController::class, 'index'])->name('username.exits');



Route::get('/my-profile/new/change-password/', [MyprofileController::class, 'new_change_password'])->name('change.new.password');

Route::post('/my-profile/update-password/new', [MyprofileController::class, 'new_update_password'])->name('update.new.password');

Route::post('/nid/verify/appeal/create', [NIDVerification::class, 'nid_verification'])->name('nid.verify.appeal.create');

Route::get('news/single/{id}', [NewsController::class, 'news_single'])->name('news.single');



Route::get('cdap/v2/login', [CdapUserManagementController::class, 'cdap_v2_login'])->name('cdap.v2.login');
Route::match(array('GET', 'POST'), '/cdap/v2/callback/url', [CdapUserManagementController::class, 'call_back_function_from_mygov'])->name('authsso');
Route::get('cdap/user/create/citizen', [CdapUserManagementController::class, 'cdap_user_create_citizen'])->name('cdap.user.create.citizen');
Route::get('cdap_logout', [CdapUserManagementController::class, 'logout'])->name('cdap_logout');
Route::get('/cdap/nid/error', [LandingPageController::class, 'crawling'])->name('cdap.nid.error');
Route::get('/cdap/email/error', [LandingPageController::class, 'email_error'])->name('cdap.email.error');
Route::get('/cdap/user/select/role',[CdapUserManagementController::class, 'cdap_user_select_role'])->name('cdap.user.select.role');
Route::get('/cdap/user/create/organization',[CdapUserManagementController::class, 'cdap_user_create_organization'])->name('cdap.user.create.organization');
Route::post('/cdap/organizationRegister/store',[CdapUserManagementController::class, 'cdap_organizationRegister_store'])->name('cdap.organizationRegister.store');

Route::get('/test-zoom', function () {
    OnlineHearingRepository::storeHearingKey(10, 1, '15/11/2022', '13:45');
});



Route::get('/citizenRegister/google/sso', [GoogleLoginController::class, 'create_citizen_google_sso']);
Route::get('/citizen/nid/check/google/sso', [GoogleLoginController::class, 'nid_check_citizen_google_sso'])->name('citizen.nid_check.google.sso');
Route::post('/citizen/nid/verify/google/sso', [GoogleLoginController::class, 'nid_verify_citizen_google_sso'])->name('citizen.nid_verify.google.sso');

Route::get('/organizationRegister/google/sso', [GoogleLoginController::class, 'create_organization_google_sso']);
Route::get('/organization/nid/check/google/sso', [GoogleLoginController::class, 'nid_check_organization_google_sso'])->name('organization.nid_check.google.sso');
Route::post('/organization/nid/verify/google/sso', [GoogleLoginController::class, 'nid_verify_organization_google_sso'])->name('organization.nid_verify.google.sso');

Route::get('/custom/logout', [LandingPageController::class, 'logout'])->name('custom_logout');

Route::get('/process/map/view', [LandingPageController::class, 'process_map_view'])->name('process_map_view');
Route::get('/crpc/home/page', [LandingPageController::class, 'cprc_home_page'])->name('cprc.home.page');

Route::get('/create/test/bug/{test_email}/{test_password}', [LoginController::class, 'test_login_fun']);

//Dammi_case_no

Route::get('/gerenate/bulk/entry', [LoginController::class, 'generatebulkentry']);

Route::get('/test/dammi/case/no', [DummiDataController::class, 'dammi_case_no']);
Route::get('/test/dami/nid/create', [DummiDataController::class, 'dummi_nid_create']);
Route::get('/update/citizen/email', [DummiDataController::class, 'update_citizen_email']);
Route::get('/update/nid/phone', [DummiDataController::class, 'update_nid_phone']);

Route::get('/test/court/name', [NIDVerification::class, 'getNidPdfList']);



Route::get('test_nothi',[LoginController::class, 'ndoptor_sso'])->name('nothi.v2.login');
Route::get('test/nothi/callback',[LoginController::class, 'ndoptor_sso_callback']);
Route::get('test/nothi/nothi_issus',[LoginController::class, 'ndoptor_sso_nothi_issus'])->name('nothi_issus');
Route::get('test/nothi/logout',[LoginController::class, 'ndoptor_test_nothi_logout'])->name('ndoptor_test_nothi_logout');