<?php

namespace App\Repositories;

use App\Models\EmAppeal;
use App\Models\GccAppeal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailNotificationRepository
{
    public static function send_email_notification($requestInfo, $shortorderTemplateUrl,$shortorderTemplateName)
    {
        
        if ($requestInfo->shortOrder[0] == 1) {
            $sms_details_both = DB::table('gcc_case_shortdecisions')
                ->where('id', '=', $requestInfo->shortOrder[0])
                ->first();

            $casedetails = GccAppeal::where('id', $requestInfo->appealId)->first();

            $caseNo = $casedetails->case_no;
            $loan_amount = $casedetails->loan_amount;

            $applicants_appeal = DB::table('gcc_appeal_citizens')
                ->where('appeal_id', '=', $requestInfo->appealId)
                ->where('citizen_type_id', '=', 1)
                ->get();

            $applicants_appeal_array = [];
            foreach ($applicants_appeal as $applicants_appeal_single) {
                array_push($applicants_appeal_array, $applicants_appeal_single->citizen_id);
            }

            $applicants = DB::table('gcc_citizens')
                ->whereIn('id', $applicants_appeal_array)
                ->get();

            $organization = $applicants[0]->organization;
            $applicant_name_1 = ' / আপনাদের ';

            //organization

            $sms_details_applicant = explode(';', $sms_details_both->template_code)[0];

            $receivers_emails_array = [];
            $receivers_names_array = [];
            foreach ($applicants as $applicantpeoplesingle) {
                array_push($receivers_emails_array, $applicantpeoplesingle->email);
                array_push($receivers_names_array, $applicantpeoplesingle->citizen_name);
                $applicant_name_1 .= $applicantpeoplesingle->citizen_name . ' ';
            }
            $dummy = ['{#caseNo}', '{#name1}', '{#organization}', '{#loanAmount}'];

            $original = [$caseNo, $applicant_name_1, $organization, $loan_amount];

            $message = str_replace($dummy, $original, $sms_details_applicant);

            $email_subject = $sms_details_both->case_short_decision;

            $email_body = $message;

            self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject, $shortorderTemplateUrl,$shortorderTemplateName);

            /* NOW for CITIZEN SMS */

            $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);

            // var_dump($citizenInfo['defaulterCitizen']->email);
            // exit;

            if (empty($citizenInfo['defaulterCitizen']->email)) {
                return;
            }

            $message2 = ' পিডি আর আক্ট ১৯১৩ অনুযায়ী আপনার ' . $citizenInfo['defaulterCitizen']->citizen_name . ' বিরুদ্ধে জেনারেল সার্টিফিকেট আদালতে একটি মামলা করা হয়েছে। প্রত্যাশী সংস্থাঃ ' . $organization . 'ব্যাংক। মামলা নাম্বার ' . $caseNo . '। টাকার পরিমাণ ' . $loan_amount;

            $receivers_emails_array = [];
            $receivers_names_array = [];
            array_push($receivers_emails_array, $citizenInfo['defaulterCitizen']->email);
            array_push($receivers_names_array, $citizenInfo['defaulterCitizen']->citizen_name);
            $email_subject = $sms_details_both->case_short_decision;
            $email_body = $message2;
            self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject, $shortorderTemplateUrl,$shortorderTemplateName);
        }

        $sms_group_7_dhara = [2, 3,17,21];

        if (in_array($requestInfo->shortOrder[0], $sms_group_7_dhara)) {
            if ($requestInfo->is_nominee_attach == 'not_attached_not_required') {
                $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
                if (empty($citizenInfo['defaulterCitizen']->email)) {
                    return;
                }

                $sms_details = DB::table('gcc_case_shortdecisions')
                    ->where('id', '=', $requestInfo->shortOrder[0])
                    ->first();

                $dummy = ['{#name2}', '{#nextdate}'];

                $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

                $message = str_replace($dummy, $original, $sms_details->template_code);

                $receivers_emails_array = [];
                $receivers_names_array = [];
                array_push($receivers_emails_array, $citizenInfo['defaulterCitizen']->email);
                array_push($receivers_names_array, $citizenInfo['defaulterCitizen']->citizen_name);
                $email_subject = $sms_details->case_short_decision;
                $email_body = $message;
           
                self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject, $shortorderTemplateUrl,$shortorderTemplateName);
            } else {
                $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
                
                $sms_details = DB::table('gcc_case_shortdecisions')
                    ->where('id', '=', $requestInfo->shortOrder[0])
                    ->first();

                $dummy = ['{#name2}', '{#nextdate}'];

                $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

                $message = str_replace($dummy, $original, $sms_details->template_code);

                $receivers_emails_array = [];
                $receivers_names_array = [];

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
                foreach ($nominees as $nomineepeoplesingle) {
                    if (!empty($nomineepeoplesingle->email)) {
                        array_push($receivers_emails_array, $nomineepeoplesingle->email);
                        array_push($receivers_names_array, $nomineepeoplesingle->citizen_name);
                    }
                }
                
                if (empty($receivers_emails_array)) {
                    return;
                }
                
                $email_subject = $sms_details->case_short_decision;
                $email_body = $message;
                self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject, $shortorderTemplateUrl,$shortorderTemplateName);
            }
        }

        $sms_group_29_dhara_with_crock = [5];
        if (in_array($requestInfo->shortOrder[0], $sms_group_29_dhara_with_crock)) {
            if ($requestInfo->is_nominee_attach == 'not_attached_not_required') {
                $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
                if (empty($citizenInfo['defaulterCitizen']->email)) {
                    return;
                }

                $sms_details = DB::table('gcc_case_shortdecisions')
                    ->where('id', '=', $requestInfo->shortOrder[0])
                    ->first();

                $dummy = ['{#name2}', '{#nextdate}'];

                $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

                $message = str_replace($dummy, $original, $sms_details->template_code);

                $receivers_emails_array = [];
                $receivers_names_array = [];
                array_push($receivers_emails_array, $citizenInfo['defaulterCitizen']->email);
                array_push($receivers_names_array, $citizenInfo['defaulterCitizen']->citizen_name);
                $email_subject = $sms_details->case_short_decision;
                $email_body = $message;
                self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject, $shortorderTemplateUrl,$shortorderTemplateName);
            } else {
                $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
                
                $sms_details = DB::table('gcc_case_shortdecisions')
                    ->where('id', '=', $requestInfo->shortOrder[0])
                    ->first();

                $dummy = ['{#name2}', '{#nextdate}'];

                $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

                $message = str_replace($dummy, $original, $sms_details->template_code);

                $receivers_emails_array = [];
                $receivers_names_array = [];

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
                foreach ($nominees as $nomineepeoplesingle) {
                    if (!empty($nomineepeoplesingle->email)) {
                        array_push($receivers_emails_array, $nomineepeoplesingle->email);
                        array_push($receivers_names_array, $nomineepeoplesingle->citizen_name);
                    }
                }
                if (empty($receivers_emails_array)) {
                    return;
                }
                
                $email_subject = $sms_details->case_short_decision;
                $email_body = $message;
                self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject, $shortorderTemplateUrl,$shortorderTemplateName);
            }
        }
        
        $warrent_sms_group = [9,15,11,6,7,18,19];
        if (in_array($requestInfo->shortOrder[0], $warrent_sms_group) && !empty($requestInfo->warrantExecutorEmail)) {

            $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
            
            $sms_details = DB::table('gcc_case_shortdecisions')
                ->where('id', '=', $requestInfo->shortOrder[0])
                ->first();

            $dummy = ['{#name2}', '{#nextdate}'];

            $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

            $message = str_replace($dummy, $original, $sms_details->template_code);

            $receivers_emails_array = [];
            $receivers_names_array = [];
            array_push($receivers_emails_array, $requestInfo->warrantExecutorEmail);
            array_push($receivers_names_array, $requestInfo->warrantExecutorName);
            $email_subject = $sms_details->case_short_decision;
            $email_body = $message;
            self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject, $shortorderTemplateUrl,$shortorderTemplateName);
        }
        
        //  ***** মামলা নিস্পতি  *****/
        
        if ($requestInfo->shortOrder[0] == 14) {
            if ($requestInfo->is_nominee_attach == 'not_attached_not_required') {
                $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
                if (empty($citizenInfo['defaulterCitizen']->email)) {
                    return;
                }

                $sms_details = DB::table('gcc_case_shortdecisions')
                    ->where('id', '=', $requestInfo->shortOrder[0])
                    ->first();

                $dummy = ['{#name2}'];

                $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

                $message = str_replace($dummy, $original, $sms_details->template_code);

                $receivers_emails_array = [];
                $receivers_names_array = [];
                array_push($receivers_emails_array, $citizenInfo['defaulterCitizen']->email);
                array_push($receivers_names_array, $citizenInfo['defaulterCitizen']->citizen_name);
                $email_subject = $sms_details->case_short_decision;
                $email_body = $message;
                self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject, $shortorderTemplateUrl,$shortorderTemplateName);
            } else {
                $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
                
                $sms_details = DB::table('gcc_case_shortdecisions')
                    ->where('id', '=', $requestInfo->shortOrder[0])
                    ->first();

                $dummy = ['{#name2}'];

                $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

                $message = str_replace($dummy, $original, $sms_details->template_code);

                $receivers_emails_array = [];
                $receivers_names_array = [];

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
                foreach ($nominees as $nomineepeoplesingle) {
                    if (!empty($nomineepeoplesingle->email)) {
                        array_push($receivers_emails_array, $nomineepeoplesingle->email);
                        array_push($receivers_names_array, $nomineepeoplesingle->citizen_name);
                    }
                }
                if (empty($receivers_emails_array)) {
                    return;
                }
                
                $email_subject = $sms_details->case_short_decision;
                $email_body = $message;
                self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject, $shortorderTemplateUrl,$shortorderTemplateName);
            } 
        }
        
        //  ***** নিলাম  *****/

        if ($requestInfo->shortOrder[0] == 20) {
            if ($requestInfo->is_nominee_attach == 'not_attached_not_required') {
                $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
                if (empty($citizenInfo['defaulterCitizen']->email)) {
                    return;
                }

                $sms_details = DB::table('gcc_case_shortdecisions')
                    ->where('id', '=', $requestInfo->shortOrder[0])
                    ->first();

                $dummy = ['{#name2}','{#nextdate}'];

                $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

                $message = str_replace($dummy, $original, $sms_details->template_code);
                
                $message .='নিলামের জন্য format '.url('').'/download_template/'.'crock.docx'; 

                $receivers_emails_array = [];
                $receivers_names_array = [];
                array_push($receivers_emails_array, $citizenInfo['defaulterCitizen']->email);
                array_push($receivers_names_array, $citizenInfo['defaulterCitizen']->citizen_name);
                $email_subject = $sms_details->case_short_decision;
                $email_body = $message;
                self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject, $shortorderTemplateUrl,$shortorderTemplateName);
            } else {
                $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
                
                $sms_details = DB::table('gcc_case_shortdecisions')
                    ->where('id', '=', $requestInfo->shortOrder[0])
                    ->first();

                $dummy = ['{#name2}','{#nextdate}'];

                $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

                $message = str_replace($dummy, $original, $sms_details->template_code);
                $message .='নিলামের জন্য format '.url('').'/download_template/'.'crock.docx';
                
                $receivers_emails_array = [];
                $receivers_names_array = [];

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
                foreach ($nominees as $nomineepeoplesingle) {
                    if (!empty($nomineepeoplesingle->email)) {
                        array_push($receivers_emails_array, $nomineepeoplesingle->email);
                        array_push($receivers_names_array, $nomineepeoplesingle->citizen_name);
                    }
                }
                if (empty($receivers_emails_array)) {
                    return;
                }
                
                $email_subject = $sms_details->case_short_decision;
                $email_body = $message;
                self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject, $shortorderTemplateUrl,$shortorderTemplateName);
            } 
        }
    }

    public static function send_email($receivers_emails_array = [], $receivers_names_array = [], $email_body, $email_subject, $shortorderTemplateUrl,$shortorderTemplateName)
    {
        $appealId = $_POST['appealId'];
        $court_district = DB::table('gcc_appeals')
            ->join('court', 'gcc_appeals.court_id', 'court.id')
            ->where('gcc_appeals.id', $appealId)
            ->select('court.court_name as court_name')
            ->first();
        $user = globalUserInfo();
        $month_name_mapping = [
            '01' => 'জানুয়ারি',
            '02' => 'ফেব্রুয়ারী',
            '03' => 'মার্চ',
            '04' => 'এপ্রিল',
            '05' => 'মে',
            '06' => 'জুন',
            '07' => 'জুলাই',
            '08' => 'আগষ্ট',
            '09' => 'সেপ্টেম্বর',
            '10' => 'অক্টোবর',
            '11' => 'নভেম্বর',
            '12' => 'ডিসেম্বর',
        ];

        $details = [
            'receivers_emails_array' => $receivers_emails_array,
            'email_subject' => $email_subject,
            'email_body' => $email_body,
            'receivers_names_array' => $receivers_names_array,
            'court_name' => $court_district->court_name,
            'month_name' => $month_name_mapping[date('m')],
            'day' => en2bn(date('d')),
            'year' => en2bn(date('Y')),
            'user_name' => $user->name,
            'user_designation' => $user->role->role_name,
            'shortorderTemplateUrl' => $shortorderTemplateUrl,
            'shortorderTemplateName'=>$shortorderTemplateName
        ];
        
        
        $job = (new \App\Jobs\SendQueueEmail($details))->delay(now()->addSeconds(2));

        dispatch($job);
    }
}
