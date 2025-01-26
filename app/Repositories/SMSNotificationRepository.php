<?php

namespace App\Repositories;

use App\Models\EmAppeal;
use App\Models\GccAppeal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SMSNotificationRepository
{
    // public static function send_sms($mobile, $message)
    // {
    //     // print_r($mobile.' , '.$message);exit('zuel');
    //     Http::post('http://bulkmsg.teletalk.com.bd/api/sendSMS', [
    //         'auth' => [
    //             'username' => 'ecourt',
    //             'password' => 'A2ist2#0166',
    //             'acode' => 1005370,
    //         ],
    //         'smsInfo' => [
    //             'message' => $message,
    //             'is_unicode' => 1,
    //             'masking' => 8801552146224,
    //             'msisdn' => [
    //                 '0' => $mobile,
    //             ],
    //         ],
    //     ]);
    // }
    // public static function send_sms_multiple($msisdn, $message)
    // {
    //     // print_r($msisdn).'sms' .print_r($message);exit('alis');
    //     //   var_dump($msisdn);
    //     //   var_dump($message);
    //     //   exit('zuel');
    //     //$msisdn=$mobile;

    //     Http::post('http://bulkmsg.teletalk.com.bd/api/sendSMS', [
    //         'auth' => [
    //             'username' => 'ecourt',
    //             'password' => 'A2ist2#0166',
    //             'acode' => 1005370,
    //         ],
    //         'smsInfo' => [
    //             'message' => $message,
    //             'is_unicode' => 1,
    //             'masking' => 8801552146224,
    //             'msisdn' => $msisdn,
    //         ],
    //     ]);
    // }

    public static function get_token(){
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
        CURLOPT_POSTFIELDS => array('email' => 'a2i@gmail.com','password' => 'mhl!a2i@2041','api_secret' => '2qwertyudfcvgbhn'),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public static function send_smsold($to, $message){
        // $m=str_replace(' ', '%20', $message);
   
        $token=self::get_token();
        $curl = curl_init();
        $m=curl_escape($curl,$message);
        $url='http://si.mysoftheaven.com/api/v1/sms?to='.$to.'&message='.$m;
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
        return $response;
    }
    public static function send_sms($to, $message){
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

    public static function send_sms_multiple($to, $message){
        
       $mobile ='';
       foreach($to as $newmobile){
        $mobile .= '88'.$newmobile.',';
       }
       $newmobile = rtrim($mobile,',');
        $curl = curl_init();
        $new_message = curl_escape($curl, $message);
      
        $url = 'http://103.69.149.50/api/v2/SendSMS?SenderId=8809617612638&Is_Unicode=true&ClientId=ec63aede-1c7e-4a5a-a1ad-36b72ab30817&ApiKey=AeHZPUEZXIILtxg0VEaGjsK%2BuPNlzhCDW0VuFRmcchs%3D&Message=' . $new_message . '&MobileNumbers=' . $newmobile;
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
    
    public static function send_sms_multipleold($to, $message){
        
        // $message = 'সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $otp . ' ধন্যবাদ।';
            // $m=str_replace(' ', '%20', $message);
        // dd($m);exit;
        $mobile = implode(',', $to);
        // dd($mobile);exit;
        $token=self::get_token();
        $curl = curl_init();
        $m=curl_escape($curl,$message);
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://si.mysoftheaven.com/api/v1/sms?to='.$mobile.'&message='.$m.'',
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
        return $response;
    }
    public static function seven_dara_notice_sms_defaulter($requestInfo, $shortorderTemplateUrl)
    {
        $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
        $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;

        $sms_details = DB::table('gcc_case_shortdecisions')
            ->where('id', '=', $requestInfo->shortOrder[0])
            ->first();
        $caseNumber = GccAppeal::where('id', $requestInfo->appealId)->first();
        $dummy = ['{#caseNo}','{#name2}', '{#nextdate}'];
        
        $original = [$caseNumber->case_no, $citizenInfo['defaulterCitizen']->citizen_name,$requestInfo->trialDate];
        $message = str_replace($dummy, $original, $sms_details->template_code);
      
        self::send_sms($mobile, $message);

        if (!empty($shortorderTemplateUrl)) {
            foreach ($shortorderTemplateUrl as $value) {
                $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;
                $message2 = 'জেনারেল সার্টিফিকেট আদালতে নোটিশ দেখতে প্রবেশ করুন ' . $value;
                self::send_sms($mobile, $message2);
            }
        }
    }
    public static function seven_dara_notice_sms_nominee($requestInfo, $shortorderTemplateUrl)
    {
        $nominees_appeal = DB::table('gcc_appeal_citizens')
            ->where('appeal_id', '=', $requestInfo->appealId)
            ->where('citizen_type_id', '=', 5)
            ->get();

        $nominees_appeal_array = [];
        foreach ($nominees_appeal as $nominees_appeal_single) {
            array_push($nominees_appeal_array, $nominees_appeal_single->citizen_id);
        }

        $nominees = DB::table('gcc_citizens')
            ->whereIn('id', $nominees_appeal_array)
            ->get();
        $msisdn = [];
        //organization

        foreach ($nominees as $nomineepeoplesingle) {
            array_push($msisdn, $nomineepeoplesingle->citizen_phone_no);
        }

        $sms_details = DB::table('gcc_case_shortdecisions')
            ->where('id', '=', $requestInfo->shortOrder[0])
            ->first();

        $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
        $caseNumber = GccAppeal::where('id', $requestInfo->appealId)->first();
        $dummy = ['{#caseNo}','{#name2}', '{#nextdate}'];

        $original = [$caseNumber->case_no, $citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

        $message = str_replace($dummy, $original, $sms_details->template_code);
        self::send_sms_multiple($msisdn, $message);

        if (!empty($shortorderTemplateUrl)) {
            foreach ($shortorderTemplateUrl as $value) {
                $message2 = 'জেনারেল সার্টিফিকেট আদালতে নোটিশ দেখতে প্রবেশ করুন ' . $value;

                self::send_sms_multiple($msisdn, $message2);
            }
        }
    }
    public static function case_close_sms_defaulter($requestInfo, $shortorderTemplateUrl)
    {
        $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
        $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;

        $sms_details = DB::table('gcc_case_shortdecisions')
            ->where('id', '=', $requestInfo->shortOrder[0])
            ->first();
        $caseNumber = GccAppeal::where('id', $requestInfo->appealId)->first();
        $caseNumber = GccAppeal::where('id', $requestInfo->appealId)->first();
        $dummy = ['{#caseNo}','{#caseNo}','{#name2}'];

        $original = [$caseNumber->case_no, $caseNumber->case_no, $citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

        $message = str_replace($dummy, $original, $sms_details->template_code);
        self::send_sms($mobile, $message);

        if (!empty($shortorderTemplateUrl)) {
            foreach ($shortorderTemplateUrl as $value) {
                $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;
                $message2 = 'জেনারেল সার্টিফিকেট আদালতে নোটিশ দেখতে প্রবেশ করুন ' . $value;
                self::send_sms($mobile, $message2);
            }
        }
    }
    public static function case_close_notice_sms_nominee($requestInfo, $shortorderTemplateUrl)
    {
        $nominees_appeal = DB::table('gcc_appeal_citizens')
            ->where('appeal_id', '=', $requestInfo->appealId)
            ->where('citizen_type_id', '=', 5)
            ->get();

        $nominees_appeal_array = [];
        foreach ($nominees_appeal as $nominees_appeal_single) {
            array_push($nominees_appeal_array, $nominees_appeal_single->citizen_id);
        }

        $nominees = DB::table('gcc_citizens')
            ->whereIn('id', $nominees_appeal_array)
            ->get();
        $msisdn = [];
        //organization

        foreach ($nominees as $nomineepeoplesingle) {
            array_push($msisdn, $nomineepeoplesingle->citizen_phone_no);
        }

        $sms_details = DB::table('gcc_case_shortdecisions')
            ->where('id', '=', $requestInfo->shortOrder[0])
            ->first();

        $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
        $caseNumber = GccAppeal::where('id', $requestInfo->appealId)->first();
        $dummy = ['{#caseNo}','{#name2}'];

        $original = [$caseNumber->case_no,$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

        $message = str_replace($dummy, $original, $sms_details->template_code);
        self::send_sms_multiple($msisdn, $message);

        if (!empty($shortorderTemplateUrl)) {
            foreach ($shortorderTemplateUrl as $value) {
                $message2 = 'জেনারেল সার্টিফিকেট আদালতে নোটিশ দেখতে প্রবেশ করুন ' . $value;

                self::send_sms_multiple($msisdn, $message2);
            }
        }
    }
    public static function crock_sms_defaulter($requestInfo, $shortorderTemplateUrl)
    {
        $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
        $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;

        $sms_details = DB::table('gcc_case_shortdecisions')
            ->where('id', '=', $requestInfo->shortOrder[0])
            ->first();
        $caseNumber = GccAppeal::where('id', $requestInfo->appealId)->first();
        $dummy = ['{#caseNo}','{#name2}','{#nextdate}'];

        $original = [$caseNumber->case_no, $citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

        $message = str_replace($dummy, $original, $sms_details->template_code);
        $message .='নিলামের জন্য format '.url('').'/download_template/'.'crock.docx'; 
        self::send_sms($mobile, $message);

        if (!empty($shortorderTemplateUrl)) {
            foreach ($shortorderTemplateUrl as $value) {
                $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;
                $message2 = 'জেনারেল সার্টিফিকেট আদালতে নোটিশ দেখতে প্রবেশ করুন ' . $value;
                self::send_sms($mobile, $message2);
            }
        }
    }
    public static function crock_close_notice_sms_nominee($requestInfo, $shortorderTemplateUrl)
    {
        $nominees_appeal = DB::table('gcc_appeal_citizens')
            ->where('appeal_id', '=', $requestInfo->appealId)
            ->where('citizen_type_id', '=', 5)
            ->get();

        $nominees_appeal_array = [];
        foreach ($nominees_appeal as $nominees_appeal_single) {
            array_push($nominees_appeal_array, $nominees_appeal_single->citizen_id);
        }

        $nominees = DB::table('gcc_citizens')
            ->whereIn('id', $nominees_appeal_array)
            ->get();
        $msisdn = [];
        //organization

        foreach ($nominees as $nomineepeoplesingle) {
            array_push($msisdn, $nomineepeoplesingle->citizen_phone_no);
        }

        $sms_details = DB::table('gcc_case_shortdecisions')
            ->where('id', '=', $requestInfo->shortOrder[0])
            ->first();

        $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
        $caseNumber = GccAppeal::where('id', $requestInfo->appealId)->first();
        $dummy = ['{#caseNo}','{#name2}','{#nextdate}'];

        $original = [$caseNumber->case_no,$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

        $message = str_replace($dummy, $original, $sms_details->template_code);
        $message .='নিলামের জন্য format '.url('').'/download_template/'.'crock.docx'; 
        self::send_sms_multiple($msisdn, $message);

        if (!empty($shortorderTemplateUrl)) {
            foreach ($shortorderTemplateUrl as $value) {
                $message2 = 'জেনারেল সার্টিফিকেট আদালতে নোটিশ দেখতে প্রবেশ করুন ' . $value;

                self::send_sms_multiple($msisdn, $message2);
            }
        }
    }
}
