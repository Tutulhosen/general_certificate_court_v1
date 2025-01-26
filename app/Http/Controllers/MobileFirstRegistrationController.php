<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use App\Rules\IsEnglish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Repositories\NIDVerificationRepository;
use App\Repositories\CitizenNIDVerifyRepository;

class MobileFirstRegistrationController extends Controller
{
    public function applicant_login_registration()
    {
        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();
        $data['page_title'] = 'লগইন / নিবন্ধন';

        return view('mobile_first_registration._new_login_page_with_registration_btn')->with($data);
    }

    public function mobile_first_registration_opt_form(Request $request, $role_id)
    {
        $cookieData = $request->cookie('Gmail_info');
        if (!empty($cookieData) && isset($cookieData)) {
            $data['results'] = $cookieData;
        }
        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();

        if (decrypt($role_id) == 36) {
            $data['role_id'] = 36;
            $data['page_title'] = 'নাগরিকের নাম এবং মোবাইল নাম্বার যাচাইকরণ';
            $data['name_field_label'] = 'নাগরিকের নাম';
            $data['mobile_field_label'] = 'মোবাইল নং';
            $data['email_field_label'] = 'ইমেইল';
        } elseif (decrypt($role_id) == 35) {
            $data['role_id'] = 35;
            $data['page_title'] = ' প্রাতিষ্ঠানিক প্রতিনিধির নাম এবং মোবাইল নাম্বার যাচাইকরণ';
            $data['name_field_label'] = 'প্রাতিষ্ঠানিক প্রতিনিধির নাম';
            $data['mobile_field_label'] = 'মোবাইল নং';
            $data['email_field_label'] = 'ইমেইল';
        } else {
            return redirect()->route('/');
        }
        // return $data;
        return view('mobile_first_registration.mobile_number_form')->with($data);
    }
    public function mobile_first_registration_opt_send(Request $request)
    {
        
        $if_not_varified_accout=DB::table('users')->where('username',$request->mobile_no)->where('is_verified_account', 0)->whereIn('role_id', [35,36])->first();
        if (!empty($if_not_varified_accout)) {
            DB::table('users')->where('username',$request->mobile_no)->where('is_verified_account', 0)->whereIn('role_id', [35,36])->delete();
        }
        $request->validate(
            [
                'input_name' => 'required',
                'email' => 'nullable|email|unique:users,email',
                'mobile_no' => 'required|unique:users,mobile_no|size:11|regex:/(01)[0-9]{9}/',
            ],
            [
                'input_name.required' => 'পুরো নাম লিখুন',
                'citizen_nid.unique' => 'আপনার জাতীয় পরিচয় পত্র দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
                'email.unique' => 'আপনার ইমেইল দিয়ে দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
                'mobile_no.required' => 'মোবাইল নং দিতে হবে',
                'mobile_no.size' => 'মোবাইল নং দিতে হবে ১১ সংখ্যার ইংরেজিতে',
                'mobile_no.unique' => 'আপনার মোবাইল নং দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
            ],
        );
        $FourDigitRandomNumber = rand(1111, 9999);

        // return $request;
        $result = DB::table('users')->insertGetId([
            'name' => $request->input_name,
            'username' => $request->mobile_no,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'otp' => $FourDigitRandomNumber,
            'password' => Hash::make('google_sso_login_password_14789_gcc_ourt_otp_based'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($result) {

            $message = 'সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $FourDigitRandomNumber . ' ধন্যবাদ।';
            // $m = str_replace(' ', '%20', $message);
            $mobile = $request->mobile_no;
            $this->send_sms($mobile, $message);

            return redirect()
                ->route('mobile.first.registration.citizen.mobile.check', ['user_id' => encrypt($result)])
                ->with('success', 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন');
        }
    }
    public function mobile_first_registration_otp_check(Request $request, $user_id)
    {
        
        $cookieData = $request->cookie('Gmail_info');
        if (!empty($cookieData) && isset($cookieData)) {
            $data['gmail'] = $cookieData;
        }
        
        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();
        // return $data;

        $data['page_title'] = 'নাগরিক মোবাইল নম্বর ভেরিফিকেশন';
        $data['user_id'] = decrypt($user_id);
        $user = User::where('id', decrypt($user_id))->first();
        $data['updated_at_otp'] = $user->updated_at;
        $data['mobile'] = $user->mobile_no;
        return view('mobile_first_registration.mobile_check')->with($data);
    }
    public function mobile_first_registration_otp_resend($user_id)
    {
        $otp = rand(1111, 9999);

        $update_otp = DB::table('users')
            ->where('id', '=', decrypt($user_id))
            ->update([
                'otp' => $otp,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        if ($update_otp) {
            $user = User::where('id', decrypt($user_id))->first();

            $mobile = $user->mobile_no;

            $message = 'সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $otp . ' ধন্যবাদ।';
            // $m = str_replace(' ', '%20', $message);

            $this->send_sms($mobile, $message);

            return redirect()
                ->route('mobile.first.registration.citizen.mobile.check', ['user_id' => encrypt($user->id)])
                ->with('success', 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন');
        }
    }

    public function mobile_first_registration_otp_verify(Request $request)
    {
        $otp = $request->otp_1 . $request->otp_2 . $request->otp_3 . $request->otp_4;
        // return $otp;
        $result = User::where('otp', $otp)
            ->where('id', $request->user_id)
            ->first();
        // return $result;
        if (empty($result)) {
            return redirect()
                ->back()
                ->withErrors(['ওটিপি ভুল হয়েছে']);
        } else {
            return redirect()->route('reset.password.after.otp', ['user_id' => encrypt($request->user_id)]);
        }
    }

    public function reset_password_after_otp(Request $request, $user_id)
    {
        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();
        $data['user_id'] = decrypt($user_id);
        $user = User::where('id', decrypt($user_id))->first();

        $cookieData = $request->cookie('Gmail_info');
       
        if (!empty($cookieData) && isset($cookieData)) {
            if ($user->role_id == 36) {
                User::where('id', $request->user_id)->update(['password' => 'google_sso_login_password_14789_gcc_ourtm#P52s@ap$V']);
                if (Auth::loginUsingId($request->user_id)) {
                    return redirect('/dashboard');
                }
            } else {
                $data['gmail'] = $cookieData;
                $data['division'] = DB::table('division')->get();
                $data['page_title'] = 'প্রতিষ্ঠান নির্বাচন';
                return view('mobile_first_registration._registration_event_password_with_office')->with($data);
            }
        }

        if ($user->role_id == 36) {
            $data['page_title'] = 'পাসওয়ার্ড হালনাগাদ';
           
            return view('mobile_first_registration._registration_event_password')->with($data);
        } elseif ($user->role_id == 35 && !empty($user->office_id)) {
            $data['page_title'] = 'পাসওয়ার্ড হালনাগাদ';
          
            return view('mobile_first_registration._registration_event_password')->with($data);
        } elseif ($user->role_id == 35) {
          
            $data['division'] = DB::table('division')->get();
            $data['page_title'] = 'পাসওয়ার্ড হালনাগাদ এবং প্রতিষ্ঠান নির্বাচন';
            return view('mobile_first_registration._registration_event_password_with_office')->with($data);
        }
    }
    public function mobile_first_password_match(Request $request)
    {
        $request->validate(
            [
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'min:6',
            ],
            [
                'password.required_with' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'password.same' => 'উভয় ক্ষেত্রে একই পাসওয়ার্ড লিখুন',
                'confirm_password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন, ৬ সংখ্যার বেশি হতে হবে',
            ],
        );

        User::where('id', $request->user_id)->update(['password' => Hash::make($request->password)]);
        return redirect()
            ->route('applicant.login.registration')
            ->with('success', 'পাসওয়ার্ড হালনাগাদ হয়েছে');
    }
    public function mobile_first_password_match_organization(Request $request)
    {
        $request->validate(
            [
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'organization_id' => ['required', new IsEnglish()],
                'confirm_password' => 'min:6',
                'office_id' => 'required',
                'division_id' => 'required',
                'district_id' => 'required',
                'upazila_id' => 'required',
                'organization_type' => 'required',
                'office_name_bn' => 'required',
                'office_name_en' => ['required', new IsEnglish()],
                'organization_physical_address' => 'required',
                'organization_employee_id' => 'required',
                'designation' => 'required',
            ],
            [
                'division_id.required' => 'বিভাগ নির্বাচন করুন',
                'district_id.required' => 'জেলা নির্বাচন করুন',
                'upazila_id.required' => 'উপজেলা নির্বাচন করুন',
                'organization_type.required' => 'প্রতিষ্ঠানের ধরন নির্বাচন করুন',
                'office_name_bn.required' => 'প্রতিষ্ঠানের নাম বাংলাতে দিন',
                'office_name_en.required' => 'প্রতিষ্ঠানের নাম ইংরেজিতে দিন',
                'organization_physical_address.required' => 'প্রতিষ্ঠানের ঠিকানা দিন',
                'office_id.required' => 'অফিস নির্বাচন করুন',
                'organization_id.required' => 'রাউটিং নং দিতে হবে',
                'password.required_with' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'confirm_password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন, ৬ সংখ্যার বেশি হতে হবে',
                'password.same' => 'উভয় ক্ষেত্রে একই পাসওয়ার্ড লিখুন',
                'organization_employee_id.required' => 'প্রতিনিধির EmployeeID দিতে হবে',
                'designation.required' => 'পদবী দিতে হবে',
            ],
        );

        if ($request->office_id == 'OTHERS') {
            $office['office_name_bn'] = $request->office_name_bn;
            $office['office_name_en'] = $request->office_name_en;
            $office['division_id'] = $request->division_id;
            $office['district_id'] = $request->district_id;
            $office['upazila_id'] = $request->upazila_id;
            $office['organization_type'] = $request->organization_type;
            $office['organization_physical_address'] = $request->organization_physical_address;
            $office['organization_routing_id'] = $request->organization_id;
            $office['is_organization'] = 1;
            $office_id = DB::table('office')->insertGetId($office);
        } else {
            $office_id = $request->office_id;
        }
        $cookieData = $request->cookie('Gmail_info');
        if (!empty($cookieData) && isset($cookieData)) {
            $password = 'google_sso_login_password_14789_gcc_ourtm#P52s@ap$V';
        } else {
            $password = $request->password;
        }
        $organization_deligate = [
            'designation' => $request->designation,
            'password' => Hash::make($password),
            'office_id' => $office_id,
            'organization_id' => $request->organization_id,
            'organization_employee_id' => $request->organization_employee_id,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        User::where('id', $request->user_id)->update($organization_deligate);

        if (!empty($cookieData) && isset($cookieData)) {
            if (Auth::loginUsingId($request->user_id)) {
                return redirect('/dashboard');
            }
        }

        return redirect()
            ->route('applicant.login.registration')
            ->with('success', 'পাসওয়ার্ড ও প্রাতিষ্ঠানিক হালনাগাদ হয়েছে');
    }

    public function new_nid_verify_mobile_reg_first(Request $request, NIDVerificationRepository $nidVerificationRepository)
    {
        $fields_message = [
            'nid_number' => 'জাতীয় পরিচয় পত্র দিতে হবে',
            'dob_number' => 'জাতীয় পরিচয় পত্র অনুযায়ী জন্ম তারিখ দিতে হবে',
        ];

        $message = '';
        foreach ($fields_message as $key => $value) {
            if (empty($request->$key)) {
                $message .= $value . ' ,';
            }
        }
        if ($message != '') {
            return response()->json([
                'success' => 'error',
                'message' => $message,
            ]);
        }

        $dob_in_db = str_replace('/', '-', $request->dob_number);
        if (pull_from_api_not_local_dummi()) {
            return $nidVerificationRepository->new_nid_verify_mobile_reg_first_api_call($request);
        } else {
            $Nid_information = DB::table('dummy_nids')
                ->where('national_id', '=', $request->nid_number)
                ->where('dob', '=', $dob_in_db)
                ->first();
            $get_additional_info_citizen = CitizenNIDVerifyRepository::getAdditionalInfoFromCitizen($request);

            if (!empty($Nid_information)) {
                return response()->json([
                    'success' => 'success',
                    'name_bn' => $Nid_information->name_bn,
                    'father' => $Nid_information->father,
                    'mother' => $Nid_information->mother,
                    'national_id' => $Nid_information->national_id,
                    'gender' => $Nid_information->gender,
                    'present_address' => $Nid_information->present_address,
                    'permanent_address' => $Nid_information->permanent_address,
                    'dob' => $request->dob_number,
                    'email' => $get_additional_info_citizen['email'],
                    'designation' => $get_additional_info_citizen['designation'],
                    'organization' => $get_additional_info_citizen['organization'],
                    'organization_id' => $get_additional_info_citizen['organization_id'],
                    'message' => 'এন আই ডি তে সফলভাবে তথ্য পাওয়া গিয়েছে',
                ]);
            } else {
                return response()->json([
                    'success' => 'error',
                    'message' => 'কোন তথ্য খুজে পাওয়া যায় নাই',
                ]);
            }
        }
    }
    public function verify_account_mobile_reg_first(Request $request)
    {
        $fields_message = [
            'citizen_nid' => 'জাতীয় পরিচয় পত্র দিতে হবে',
            'name' => 'জাতীয় পরিচয় পত্র অনুযায়ী বাংলাতে নাম দিতে হবে',
            'father' => 'জাতীয় পরিচয় পত্র অনুযায়ী বাংলাতে পিতার নাম দিতে হবে',
            'mother' => 'জাতীয় পরিচয় পত্র অনুযায়ী বাংলাতে মাতার নাম দিতে হবে',
            'dob' => 'জাতীয় পরিচয় পত্র অনুযায়ী জন্ম তারিখ দিতে হবে',
            'citizen_gender' => 'লিঙ্গ দিতে হবে',
            'permanentAddress' => 'জাতীয় পরিচয় পত্র অনুযায়ী স্থায়ী ঠিকানা দিতে হবে',
            'presentAddress' => 'জাতীয় পরিচয় পত্র অনুযায়ী বর্তমান ঠিকানা দিতে হবে',
        ];
        $message = '';
        foreach ($fields_message as $key => $value) {
            if (empty($request->$key)) {
                $message .= $value . ' ,';
            }
        }

        $exits_user_by_nid = DB::table('users')
            ->where('citizen_nid', $request->citizen_nid)
            ->first();
        if (!empty($exits_user_by_nid)) {
            $message .= 'জাতীয় পরিচয় পত্র ' . $request->citizen_nid . ' দিয়ে ইতিমধ্যে ' . $exits_user_by_nid->mobile_no . ' এর সাথে নিবন্ধিত করা হয়েছে';
        }

        if ($message != '') {
            return response()->json([
                'success' => 'error',
                'message' => $message,
            ]);
        }

        CitizenNIDVerifyRepository::verify_citizen_by_nid($request);

        return response()->json([
            'success' => 'success',
            'message' => 'সফলভাবে আপনার প্রোফাইল সত্যায়িত হয়েছে',
        ]);
    }

    //forget password page
    public function forget_password()
    {
        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();
        // return $data;

        $data['page_title'] = 'নাগরিক পাসওয়ার্ড রিসেট ফর্ম';

        return view('citizen.password_reset_form')->with($data);
    }

    public function user_check_forget_password(Request $request)
    {
        $request->validate(
            [
                'mobile_number' => 'required',
            ],
            [
                'mobile_number.required' => 'মোবাইল নং লিখুন',
            ],
        );

        $user = DB::table('users')
            ->where('mobile_no', '=', $request->mobile_number)
            ->first();
        if (!empty($user)) {
            $otp = rand(1111, 9999);

            $update_otp = DB::table('users')
                ->where('id', '=', $user->id)
                ->update([
                    'otp' => $otp,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
             
            if ($update_otp) {

                $mobile = $user->mobile_no;

                $message = 'পাসওয়ার্ড রিসেট করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $otp . ' ধন্যবাদ।';
                // $m = str_replace(' ', '%20', $message);

                $this->send_sms($mobile,$message);
                return redirect()
                    ->route('mobile.first.registration.citizen.mobile.check', ['user_id' => encrypt($user->id)])
                    ->with('success', 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন');
            }
        } else {
            return redirect()
                ->back()
                ->with('Errormessage', 'আপনার তথ্য পাওয়া যায়নি');
        }
    }

    public function send_sms($to, $message)
    {
        $curl = curl_init();
        $new_message = curl_escape($curl, $message);
        $newto='88'.$to;
        $url = 'http://103.69.149.50/api/v2/SendSMS?SenderId=8809617612638&Is_Unicode=true&ClientId=ec63aede-1c7e-4a5a-a1ad-36b72ab30817&ApiKey=AeHZPUEZXIILtxg0VEaGjsK%2BuPNlzhCDW0VuFRmcchs%3D&Message=' . $new_message . '&MobileNumbers=' . $newto;
        // dd($url);
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        return $response;
    }

    
   
    public function get_token()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://si.mysoftheaven.com/api/v1/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('email' => 'a2i@gmail.com', 'password' => 'mhl!a2i@2041', 'api_secret' => '2qwertyudfcvgbhn'),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function send_smsold($to, $message)
    {
        $url = 'http://si.mysoftheaven.com/api/v1/sms?to=' . $to . '&message=' . $message . '';
        $token = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            // CURLOPT_HTTPHEADER => array(
            //     $token
            // ),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }


    // alamin administrative login 
    public function administrative_login_registration()
    {
        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();
        $data['page_title'] = 'লগইন / নিবন্ধন';

        return view('mobile_first_registration.administrative_login_registration')->with($data);
    }
}