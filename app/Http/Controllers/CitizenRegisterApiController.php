<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\NIDVerificationRepository;
use App\Repositories\CitizenNIDVerifyRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class CitizenRegisterApiController extends Controller
{
    public function citizen_registration_otp_send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input_name' => 'required',
            'email' => 'nullable|email|unique:users,email',
            'mobile_no' => 'required|unique:users,mobile_no|size:11|regex:/(01)[0-9]{9}/',
        ], [
            'input_name.required' => 'পুরো নাম লিখুন',
            'email.unique' => 'আপনার ইমেইল দিয়ে দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
            'mobile_no.required' => 'মোবাইল নং দিতে হবে',
            'mobile_no.size' => 'মোবাইল নং দিতে হবে ১১ সংখ্যার ইংরেজিতে',
            'mobile_no.unique' => 'আপনার মোবাইল নং দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422); // 422 is the standard HTTP response code for validation errors
        }

        $FourDigitRandomNumber = rand(1111, 9999);

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
            $message = " সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: " . $FourDigitRandomNumber . "\r\n" . "ধন্যবাদ।";
            $mobile = $request->mobile_no;
            $this->send_sms($mobile, $message);
            return response()->json([
                'user_id' => $result,
                'success' => 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।',
                'verify_url' => 'citizen/registration/otp/verify',
                'otp' => $FourDigitRandomNumber
            ], 200);
        } else {
            return 'Something went wrong!!';
        }
    }

    public function citizen_registration_otp_verify(Request $request)
    {
        $given_otp = $request->otp;
        if ($given_otp) {
            $result = User::where('otp', $given_otp)->where('id', $request->user_id)->first();
            if (empty($result)) {
                return response()->json(["message" => 'সঠিক ওটিপি প্রদান করুন']);
            } else {
                return response()->json([
                    "message" => 'তথ্য পাওয়া গিয়েছে',
                    'password_reset_url' => '/citizen/registration/password/reset',
                    $result
                ]);
            }
        } else {
            return response()->json(["message" => 'অনুগ্রহ করে ওটিপি প্রদান করুন']);
        }
    }

    public function citizen_registration_password_reset(Request $request)
    {
        // dd($request->all()); 
        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required|min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'required|min:6',
                'user_id' => 'required'
            ],
            [
                'password.required_with' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'password.same' => 'উভয় ক্ষেত্রে একই পাসওয়ার্ড লিখুন',
                'confirm_password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন, ৬ সংখ্যার বেশি হতে হবে',
            ],
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        } else {
            $result = User::where('id', $request->user_id)->update(['password' => Hash::make($request->password)]);
            if ($result) {
                return response()->json([
                    'success' => 'পাসওয়ার্ড হালনাগাদ হয়েছে',
                ]);
            } else {
                return response()->json([
                    'message' => 'ইউজারের তথ্য পাওয়া যাই নি',
                ]);
            }
        }
    }

    public function citizen_registration_nid_verify_store(Request $request, NIDVerificationRepository $nidVerificationRepository)
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

    public function citizen_registration_manually_verify_store(Request $request)
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
            'citizen_phone_no' => 'মোবাইল নাম্বার দিতে হবে',
            'id' => 'ইউজার আইডি দিতে হবে'

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
        } else {
            $exits_user_by_nid = DB::table('users')
                ->where('citizen_nid', $request->citizen_nid)
                ->first();
            if (!empty($exits_user_by_nid)) {
                $message .= 'জাতীয় পরিচয় পত্র ' . $request->citizen_nid . ' দিয়ে ইতিমধ্যে ' . $exits_user_by_nid->mobile_no . ' এর সাথে নিবন্ধিত করা হয়েছে';
            }
        }
        $data = [
            'citizen_name' => $request->name,
            'citizen_phone_no' => $request->citizen_phone_no,
            'citizen_NID' => $request->citizen_nid,
            'citizen_gender' => $request->citizen_gender,
            'present_address' => $request->presentAddress,
            'permanent_address' => $request->permanentAddress,
            'dob' => str_replace('/', '-', $request->dob),
            'email' => $request->email,
            'father' => $request->father,
            'mother' => $request->mother,
            'designation' => $request->designation,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $request->id
        ];
        // return $data;
        $nid_exits = DB::table('gcc_citizens')
            ->where('citizen_NID', $request->citizen_nid)
            ->first();
        if (!empty($nid_exits)) {
            DB::table('gcc_citizens')
                ->where('citizen_NID', $request->citizen_nid)
                ->update($data);
            $ID = $nid_exits->id;
        } else {
            $ID = DB::table('gcc_citizens')->insertGetId($data);
        }
        User::where('id', $request->id)->update(
            [
                'citizen_id' => $ID,
                'is_verified_account' => 1,
                'name' => $request->name,
                'citizen_nid' => $request->citizen_nid,
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );
        return response()->json([
            'success' => 'success',
            'message' => 'সফলভাবে আপনার প্রোফাইল সত্যায়িত হয়েছে',
        ]);
    }

    public function send_sms_old($to, $message)
    {
        return [$to, $message];
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
}
