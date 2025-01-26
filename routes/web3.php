<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\MobileFirstRegistrationController;

Route::get('/applicant/login/registration',[MobileFirstRegistrationController::class,'applicant_login_registration'])->name('applicant.login.registration');
Route::get('/administrative/login',[MobileFirstRegistrationController::class,'administrative_login_registration'])->name('administrative.login.registration');

Route::get('/mobile/first/registration/opt/form/{role_id}', [MobileFirstRegistrationController::class, 'mobile_first_registration_opt_form'])->name('mobile.first.registration.opt.form');

Route::post('/mobile/first/registration/opt/send', [MobileFirstRegistrationController::class, 'mobile_first_registration_opt_send'])->name('mobile.first.registration.opt.send');

Route::get('/mobile/first/registration/citizen/mobile/check/{user_id}', [MobileFirstRegistrationController::class, 'mobile_first_registration_otp_check'])->name('mobile.first.registration.citizen.mobile.check');

Route::get('/mobile/first/registration/citizen/reg/opt/resend/{user_id}', [MobileFirstRegistrationController::class, 'mobile_first_registration_otp_resend'])->name('mobile.first.registration.citizen.reg.opt.resend');

Route::post('/mobile/first/registration/otp/verify', [MobileFirstRegistrationController::class, 'mobile_first_registration_otp_verify'])->name('mobile.first.registration.otp.verify');

Route::get('/reset/password/after/otp/{user_id}', [MobileFirstRegistrationController::class, 'reset_password_after_otp'])->name('reset.password.after.otp');

Route::post('/mobile/first/password/match', [MobileFirstRegistrationController::class, 'mobile_first_password_match'])->name('mobile.first.password.match');

Route::post('/mobile/first/password/match/organization', [MobileFirstRegistrationController::class, 'mobile_first_password_match_organization'])->name('mobile.first.password.match.organization');



Route::post('/new/nid/verify/mobile/reg/first', [MobileFirstRegistrationController::class, 'new_nid_verify_mobile_reg_first'])->name('new.nid.verify.mobile.reg.first');

Route::post('/verify/account/mobile/reg/first', [MobileFirstRegistrationController::class, 'verify_account_mobile_reg_first'])->name('verify.account.mobile.reg.first');


Route::get('/google/sso/auth', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.sso.auth');
Route::get('/login/google/callback', [GoogleLoginController::class, 'redirectFromGoogleSSO'])->name('login.google.callback');
Route::get('/after/google/get/email/nid/profile/create', [GoogleLoginController::class, 'nid_verification_profile_create'])->name('after.google.get.email.nid.profile.create');

//forgate password 
Route::get('applicant/forget/password', [MobileFirstRegistrationController::class, 'forget_password'])->name('applicant.forget.password');
Route::post('applicant/forget/password/usercheck', [MobileFirstRegistrationController::class, 'user_check_forget_password'])->name('user.check.forget.password');