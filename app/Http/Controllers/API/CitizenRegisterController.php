<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Rules\IsEnglish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\NIDVerificationRepository;
use App\Repositories\CitizenNIDVerifyRepository;
use App\Repositories\OrganizationCaseMappingRepository;

class CitizenRegisterController extends BaseController
{

    public function citizen_registration_otp_send(Request $request, $role_id)
    {
 
        $if_not_varified_accout=DB::table('users')->where('username',$request->mobile_no)->where('is_verified_account', 0)->whereIn('role_id', [35,36])->first();
        if (!empty($if_not_varified_accout)) {
            DB::table('users')->where('username',$request->mobile_no)->where('is_verified_account', 0)->whereIn('role_id', [35,36])->delete();
        }
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
            return $this->sendErrormgs('Validation Error.', $validator->errors());
        }

        $FourDigitRandomNumber = rand(1111, 9999);

        $result = DB::table('users')->insertGetId([
            'name' => $request->input_name,
            'username' => $request->mobile_no,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'role_id' => $role_id,
            'otp' => $FourDigitRandomNumber,
            'password' => Hash::make('google_sso_login_password_14789_gcc_ourt_otp_based'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        if ($result) {
           
            $message = 'সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $FourDigitRandomNumber . ' ধন্যবাদ।';
            $mobile = $request->mobile_no;

            $this->send_sms($mobile, $message);
            $data=[
                'user_id' => $result,
                
            ];

            return $this->sendResponse($data, 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে');
            
        } else {
            return 'Something went wrong!!';
        }
    }

    public function citizen_registration_otp_verify(Request $request, $user_id)
    {
        $given_otp = $request->otp;
        if ($given_otp) {
            $result = User::where('otp', $given_otp)->where('id', $user_id)->first();
            if (empty($result)) {

                return $this->sendErrormgs('error', 'সঠিক ওটিপি প্রদান করুন');
            } else {
    
                return $this->sendResponse($result, 'তথ্য পাওয়া গিয়েছে');
            }
        } else {
            return $this->sendErrormgs('error', 'অনুগ্রহ করে ওটিপি প্রদান করুন');
        
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
            
            return $this->sendErrormgs('Validation Error.', $message);
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
                $data=[
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
                ];
                return $this->sendResponse($data, 'তথ্য পাওয়া গিয়েছে');
                
            } else {
                return $this->sendErrormgs('Validation Error.', 'কোন তথ্য খুজে পাওয়া যায় নাই');
                
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

        ];
        $message = '';
        foreach ($fields_message as $key => $value) {
            if (empty($request->$key)) {
                $message .= $value . ' ,';
            }
        }

        if ($message != '') {
            return $this->sendErrormgs('Validation Error.', $message);
        } else {
            $exits_user_by_nid = DB::table('users')
                ->where('citizen_nid', $request->citizen_nid)
                ->first();
            if (!empty($exits_user_by_nid)) {
                $message .= 'জাতীয় পরিচয় পত্র ' . $request->citizen_nid . ' দিয়ে ইতিমধ্যে ' . $exits_user_by_nid->mobile_no . ' এর সাথে নিবন্ধিত করা হয়েছে';
            }
        }

        $user_info=DB::table('users')->where('id', $request->created_by)->first();

        if($user_info->role_id == 35)
       {

        $office= DB::table('office')
            ->select('office_name_bn')
            ->where('id', $user_info->office_id)
            ->first();
            $organization=$office->office_name_bn;

       }elseif($user_info->role_id == 36)
       {
          $organization=null;
       }
        
    
        $data = [
            'citizen_name' => $request->name,
            'citizen_phone_no' => $user_info->mobile_no,
            'citizen_NID' => $request->citizen_nid,
            'citizen_gender' => $request->citizen_gender,
            'present_address' => $request->presentAddress,
            'permanent_address' => $request->permanentAddress,
            'dob' => str_replace('/', '-', $request->dob),
            'email' => $user_info->email,
            'father' => $request->father,
            'mother' => $request->mother,
            'designation'=>$user_info->designation,
            'organization'=>$organization,
            'organization_id'=>$user_info->organization_id ,
            'organization_employee_id'=>$user_info->organization_employee_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by'=>$user_info->id
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
        if($user_info->role_id==35 && $user_info->office_id !="OTHERS")
        {
            OrganizationCaseMappingRepository::employeeOrgizationCaseMapping($user_info->office_id,$ID,$user_info->id);
        } 
        User::where('id', $user_info->id)->update(
            [
                'citizen_id' => $ID,
                'is_verified_account' => 1,
                'name' => $request->name,
                'citizen_nid' => $request->citizen_nid,
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );

        return $this->sendResponse(null, 'সফলভাবে আপনার প্রোফাইল সত্যায়িত হয়েছে');
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

    public function send_sms_old($to, $message)
    {

        $token = $this->get_token();
        $curl = curl_init();
        $m = curl_escape($curl, $message);
        $url = 'http://si.mysoftheaven.com/api/v1/sms?to=' . $to . '&message=' . $m;
  
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
        // dd($response);
        curl_close($curl);
        return $response;
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

    public function getDependentOrganizationType(Request $request)
    {
       

        $a=[
            [
                'organization_type'=>'ব্যাংক',
                'value'=>'BANK',
            ],
            [
                'organization_type'=>'সরকারি প্রতিষ্ঠান',
                'value'=>'GOVERNMENT',
            ],
            [
                'organization_type'=>'স্বায়ত্তশাসিত প্রতিষ্ঠান',
                'value'=>'OTHER_COMPANY',
            ],
        ];


        

      
        return $this->sendResponse($a, 'তথ্য পাওয়া গিয়েছে');
    }

    public function getDependentOrganization(Request $request)
    {
       
        $office_information = DB::table("office")
        ->where("division_id",$request->division_id)
        ->where("district_id",$request->district_id)
        ->where("upazila_id",$request->upazila_id)
        ->where('organization_type',$request->organization_type)
        ->where('status',1)
        ->where('is_organization',1)
        ->select("office_name_bn as office_name","id as value")
        ->get()->toArray();

        $off_manual=[
            'office_name' =>'অনন্যা',
            "value" => 'OTHERS',
        ];
        
        // $result = $office_information->toArray() + [$off_manual];
       $a= array_merge($office_information, [$off_manual]);

      
        return $this->sendResponse($a, 'তথ্য পাওয়া গিয়েছে');
    }

    public function getdependentOfficeName($id)
    {
        $office_address_routing_no= DB::table("office")->where("id",$id)->select("office_name_bn","office_name_en","organization_physical_address","organization_routing_id")->first();
        return $this->sendResponse($office_address_routing_no, 'তথ্য পাওয়া গিয়েছে');
    }

    public function CitizenRegistrationWithPassword(Request $request)
    {
        $user_info=DB::table('users')->where('id', $request->user_id)->first();
        if ($user_info) {
            if ($user_info->role_id==35) {
                $input = $request->all();
                $validator = Validator::make($input, [
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
        
                if ($validator->fails()) {
                    return $this->sendErrormgs('Validation Error.', $validator->errors());
                }
        
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
                return $this->sendResponse(null, 'পাসওয়ার্ড ও প্রাতিষ্ঠানিক হালনাগাদ হয়েছে');
            } elseif($user_info->role_id==36) {
                $input = $request->all();
           
                $validator = Validator::make($input,
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
                if ($validator->fails()) {
                    return $this->sendErrormgs('Validation Error.', $validator->errors());
                }
        
                User::where('id', $request->user_id)->update(['password' => Hash::make($request->password)]);
    
                return $this->sendResponse(null, 'পাসওয়ার্ড হালনাগাদ হয়েছে');
    
            }
        }else {
            return $this->sendErrormgs('Validation Error.', "user not found");
        }
        
        
        


    }


    public function user_check_forget_password(Request $request)
    {
        $input = $request->all();
            $validator = Validator::make($input,
            [
                'mobile_number' => 'required',
            ],
            [
                'mobile_number.required' => 'মোবাইল নং লিখুন',
            ],
        );

        if ($validator->fails()) {
            return $this->sendErrormgs('Validation Error.', $validator->errors());
        }

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
                $data=[
                    'user_id' =>$user->id
                ];

                return $this->sendResponse($data, 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন');

            }
        } else {
            return $this->sendErrormgs('Validation Error.', 'আপনার তথ্য পাওয়া যায়নি');
        }
    }
 

    public function mobile_first_registration_otp_verify(Request $request)
    {
        $otp = $request->otp_1 . $request->otp_2 . $request->otp_3 . $request->otp_4;
        // return $otp;
        if (empty($request->otp_1) || empty($request->otp_2) || empty($request->otp_3) || empty($request->otp_4)) {
            return $this->sendErrormgs('Validation Error.', '৪ ডিজিটের ওটিপি প্রদান করুন');
        }
        $result = User::where('otp', $otp)
            ->where('id', $request->user_id)
            ->first();
        // return $result;
        if (empty($result)) {

                return $this->sendErrormgs('Validation Error.', 'ওটিপি ভুল হয়েছে');
        } else {

            return $this->sendResponse(null, 'মোবাইল নম্বর যাচাই সফল হয়েছে');
        }
    }



    public function mobile_first_password_match(Request $request)
    {
        $input = $request->all();
            $validator = Validator::make($input,
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

        if ($validator->fails()) {
            return $this->sendErrormgs('Validation Error.', $validator->errors());
        }

        User::where('id', $request->user_id)->update(['password' => Hash::make($request->password)]);

            return $this->sendResponse(null, 'পাসওয়ার্ড হালনাগাদ হয়েছে');
    }


    public function mobile_first_registration_otp_resend(Request $request, $user_id)
    {
 
        $otp = rand(1111, 9999);

        $update_otp = DB::table('users')
            ->where('id', '=', $user_id)
            ->update([
                'otp' => $otp,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        if ($update_otp) {
            $user = User::where('id', $user_id)->first();

            $mobile = $user->mobile_no;

            $message = 'সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $otp . ' ধন্যবাদ।';
            // $m = str_replace(' ', '%20', $message);

            $this->send_sms($mobile, $message);



            return $this->sendResponse(null, 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন');
        }
    }


}
