<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class LogManagementRepository
{
    public static function citizen_appeal_store($request_data, $appealId, $log_file_data)
    {
        $case_basic_info = [
            'appealId' => $appealId,
            'caseEntryType' => $request_data->caseEntryType,
            'lawSection' => $request_data->lawSection,
            'caseDate' => $request_data->caseDate,
            'totalLoanAmount' => $request_data->totalLoanAmount,
            'totalLoanAmountText' => $request_data->totalLoanAmountText,
            'applicant_office_name' => user_office_info()->office_name_bn,
            'organization_physical_address' => user_office_info()->organization_physical_address,
            'organization_routing_id' => user_office_info()->organization_routing_id,
            'organization_type' => user_office_info()->organization_type,
        ];

        $case_basic_info = json_encode($case_basic_info);
        $defaulter = json_encode($request_data->defaulter);

        $applicant = [];

        $outeriteration = sizeof($request_data->applicant['name']);
        for ($i = 0; $i < $outeriteration; $i++) {
            $applicantchild = [];
            foreach ($request_data->applicant as $key => $value) {
                $applicantchild[$key] = isset($request_data->applicant[$key][$i]) ? $request_data->applicant[$key][$i] : null;
            }

            array_push($applicant, $applicantchild);
        }

        //dd($witness);

        $user = globalUserInfo();

        $activity = 'মামলার আবেদন ( প্রাতিষ্ঠানিক প্রতিনিধি )';
        $activity .= '<br>';

        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');
        $gcc_log_book = [
            'appeal_id' => $appealId,
            'user_id' => $user->id,
            'designation' => $user->designation,
            'activity' => $activity,
            'files' => $log_file_data,
            'case_basic_info' => $case_basic_info,
            'applicant' => json_encode($applicant),
            'defaulter' => $defaulter,
            'details_url' => '/log/logid/details',
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($em_log_book);
        DB::table('gcc_log_book')->insert($gcc_log_book);
    }
    public static function cer_asst_appeal_store($request_data, $appealId, $log_file_data)
    {
        //nominees

        if (isset($request_data->nominee) && !empty($request_data->nominee) && $request_data->nominee_already =="nominee_already_not" && in_array($request_data->shortOrder[0],[23,24,25])) {
            $nomineeFlag = true;
            foreach ($request_data->nominee['name'] as $key => $value) {
                if (!isset($value)) {
                    $nomineeFlag = false;
                    break;
                }
            }
            foreach ($request_data->nominee['phn'] as $key => $value) {
                if (!isset($value)) {
                    $nomineeFlag = false;
                    break;
                }
            }
            foreach ($request_data->nominee['presentAddress'] as $key => $value) {
                if (!isset($value)) {
                    $nomineeFlag = false;
                    break;
                }
            }
            foreach ($request_data->nominee['nid'] as $key => $value) {
                if (!isset($value)) {
                    $nomineeFlag = false;
                    break;
                }
            }
            if ($nomineeFlag) {
                $nominees = [];

                $outeriteration = sizeof($request_data->nominee['name']);
                for ($i = 0; $i < $outeriteration; $i++) {
                    $nomineechild = [];
                    foreach ($request_data->nominee as $key => $value) {
                        $nomineechild[$key] = isset($request_data->nominee[$key][$i]) ? $request_data->nominee[$key][$i] : null;
                    }

                    array_push($nominees, $nomineechild);
                }
                $details_url = '/log/logid/details';
            } else {
                $details_url = null;
            }
        } else {
            $details_url = null;
        }

        $user = globalUserInfo();
        if ($user->role_id == 28) {
            if ($request_data->status = 'SEND_TO_GCO') {
                $activity = 'সংশোধন ও প্রেরণ জেনারেল সার্টিফিকেট অফিসার বরাবর';
                $activity .= '<br>';
                $activity .= $request_data->note;
            } else {
                $activity = 'জেনারেল সার্টিফিকেট অফিসার বরাবর';
                $activity .= '<br>';
                $activity = '<span>মামলা চলমান : ' . $request_data->note . '</span>';
            }

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'সার্টিফিকেট সহকারী';
            }
        } 
         
        

        if (isset($request_data->manual_case_no) && $request_data->already_manual_case_no=="no") {
            
            $activity .= '<br>';
            $activity .= '<span>ম্যানুয়াল মামলা নং  : ' . $request_data->manual_case_no . '</span>';
        }
        if (isset($request_data->court_fee_amount) && $request_data->already_court_fee=="no") {
            
            $activity .= '<br>';
            $activity .= '<span>কোর্ট ফি পরিমাণ  : ' . $request_data->court_fee_amount . '</span>';
        }

        if (isset($request_data->TodayPaymentPaymentCollection)) {
            $activity .= '<br>';
            $activity .= '<span>প্রদেয় অর্থের পরিমাণ  : ' . $request_data->TodayPaymentPaymentCollection . '</span>';
        }

        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $gcc_log_book = [
            'appeal_id' => $appealId,
            'user_id' => $user->id,
            'designation' => $designation,
            'activity' => $activity,
            'files' => $log_file_data,
            'nominees' => isset($nominees) ? json_encode($nominees) : null,
            'details_url' => isset($details_url) ? $details_url : null,
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($em_log_book);
        DB::table('gcc_log_book')->insert($gcc_log_book);
    }
    public static function Appealfiledelete($attachment, $appeal_id)
    {
        $user = globalUserInfo();

        if ($user->role_id == 28) {
            $activity = '<span>ফাইল মুছে ফেলা হয়েছে পেশকার (ইএম)</span>';
            $activity .= '<br>';
            $activity .= '<span>ফাইল এর নাম <strong>' . $attachment->file_category . '</strong></span>';
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'পেশকার (ইএম)';
            }
        } elseif ($user->role_id == 27) {
            $activity = '<span>ফাইল মুছে ফেলা হয়েছে(নির্বাহী ম্যাজিস্ট্রেট)</span>';
            $activity .= '<br>';
            $activity .= '<span>ফাইল এর নাম <strong>' . $attachment->file_category . '</strong></span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'নির্বাহী ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 37) {
            $activity = '<span>ফাইল মুছে ফেলা হয়েছে(জেলা ম্যাজিস্ট্রেট)</span>';
            $activity .= '<br>';
            $activity .= '<span>ফাইল এর নাম <strong>' . $attachment->file_category . '</strong></span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 38) {
            $activity = '<span>ফাইল মুছে ফেলা হয়েছে(অতিরিক্ত জেলা ম্যাজিস্ট্রেট)</span>';
            $activity .= '<br>';
            $activity .= '<span>ফাইল এর নাম <strong>' . $attachment->file_category . '</strong></span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 39) {
            $activity = '<span>ফাইল মুছে ফেলা হয়েছে পেশকার (ডিম / এডিম) </span>';
            $activity .= '<br>';
            $activity .= '<span>ফাইল এর নাম <strong>' . $attachment->file_category . '</strong></span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'পেশকার (ডিম / এডিম)';
            }
        } elseif ($user->role_id == 7) {
            $activity = '<span>ফাইল মুছে ফেলা হয়েছে অতিরিক্ত জেলা প্রশাসক (এডিসি) </span>';
            $activity .= '<br>';
            $activity .= '<span>ফাইল এর নাম <strong>' . $attachment->file_category . '</strong></span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা প্রশাসক (এডিসি)';
            }
        }
        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $em_log_book = [
            'appeal_id' => $appeal_id,
            'user_id' => $user->id,
            'designation' => $designation,
            'activity' => $activity,
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }
    public static function storeOnTrialInfo($request_data, $appealId, $log_file_data)
    {
        //dd($log_file_data);
        $user = globalUserInfo();
        
        if ($request_data->status == 'CLOSED') {
            $activity = '<span>মামলা নিষ্পত্তি করা হয়েছে : ' . $request_data->note . '</span>';
            $activity .= '<br>';
            $activity .= '<span>সম্পূর্ণ আদেশ প্রকাশের তারিখ : ' . $request_data->finalOrderPublishDate . '</span>';
            $activity .= '<br>';
            if ($request_data->orderPublishDecision == 1) {
                $activity .= '<span>সম্পূর্ণ আদেশ প্রকাশ  হ্যাঁ </span>';
            } else {
                $activity .= '<span>সম্পূর্ণ আদেশ প্রকাশ  না </span>';
            }
        } elseif ($request_data->status == 'REJECTED') {
            $activity = '<span>মামলা বাতিল করা হয়েছে : ' . $request_data->note . '</span>';
            $activity .= '<br>';
            $activity .= '<span>পরবর্তী তারিখ : ' . $request_data->trialDate . '</span>';
            $activity .= '<br>';
            $activity .= '<span>সময়  : ' . $request_data->trialTime . '</span>';
            $activity .= '<br>';
        } elseif ($request_data->status == 'ON_TRIAL') {
            $activity = '<span>মামলা চলমান : ' . $request_data->note . '</span>';
            $activity .= '<br>';
            $activity .= '<span>পরবর্তী তারিখ : ' . $request_data->trialDate . '</span>';
            $activity .= '<br>';
            $activity .= '<span>সময়  : ' . $request_data->trialTime . '</span>';
            $activity .= '<br>';
        } else {
            $activity = '<span>মামলা গ্রহণ ও সংক্ষিপ্ত আদেশ : ' . $request_data->note . '</span>';
            $activity .= '<br>';
            $activity .= '<span>পরবর্তী তারিখ : ' . $request_data->trialDate . '</span>';
            $activity .= '<br>';
            $activity .= '<span>সময়  : ' . $request_data->trialTime . '</span>';
            $activity .= '<br>';
        }

        if (!empty($request_data->warrantExecutorName)) {
            $activity .= '<span>ওয়ারেন্ট বাস্তবায়নকারী নাম : ' . $request_data->warrantExecutorName . '</span>';
            $activity .= '<br>';
        }
        if (!empty($request_data->warrantExecutorInstituteName)) {
            $activity .= '<span>ওয়ারেন্ট বাস্তবায়নকারী প্রতিষ্ঠানের নাম: ' . $request_data->warrantExecutorInstituteName . '</span>';
            $activity .= '<br>';
        }
        if (!empty($request_data->warrantExecutorMobile)) {
            $activity .= '<span>ওয়ারেন্ট বাস্তবায়নকারী মোবাইল: ' . $request_data->warrantExecutorMobile . '</span>';
            $activity .= '<br>';
        }
        if (!empty($request_data->warrantExecutorEmail)) {
            $activity .= '<span>ওয়ারেন্ট বাস্তবায়নকারী ইমেইল: ' . $request_data->warrantExecutorEmail . '</span>';
            $activity .= '<br>';
        }
        if (!empty($request_data->warrantExecutorDesignation)) {
            $activity .= '<span>ওয়ারেন্ট বাস্তবায়নকারী পদবী: ' . $request_data->warrantExecutorDesignation . '</span>';
            $activity .= '<br>';
        }

        if (!empty($request_data->main_amount_29_dhara)) {
            $activity .= '<span>মূল দাবি: ' . $request_data->main_amount_29_dhara . '</span>';
            $activity .= '<br>';
        }
        if (!empty($request_data->interest_29_dhara)) {
            $activity .= '<span>সুদ: ' . $request_data->interest_29_dhara . '</span>';
            $activity .= '<br>';
        }
        if (!empty($request_data->costing_29_dhara)) {
            $activity .= '<span>খরচ: ' . $request_data->costing_29_dhara . '</span>';
            $activity .= '<br>';
        }
        if (!empty($request_data->working_amount_29_dhara)) {
            $activity .= '<span>কার্যকরীকরন: ' . $request_data->working_amount_29_dhara . '</span>';
            $activity .= '<br>';
        }
       
        if (!empty($request_data->amount_to_deposite)) {
            $activity .= '<span>জমা করতে হবে (টাকা): ' . $request_data->amount_to_deposite . '</span>';
            $activity .= '<br>';
        }
        if (!empty($request_data->days_in_court)) {
            $activity .= '<span>যত দিন এর জন্য জেলে প্রেরণ : ' . $request_data->days_in_court . '</span>';
            $activity .= '<br>';
        }
        if (!empty($request_data->daily_cost_ta_da)) {
            $activity .= '<span>দৈনিক ভাতা: ' . $request_data->daily_cost_ta_da . '</span>';
            $activity .= '<br>';
        }

        if (!empty($request_data->amount_to_pay_as_remaining)) {
            $activity .= '<span>৭ ধারার নোটিশ প্রয়োজনীয় তথ্য বকেয়া (টাকা): ' . $request_data->amount_to_pay_as_remaining . '</span>';
            $activity .= '<br>';
        }
        if (!empty($request_data->amount_to_pay_as_costing)) {
            $activity .= '<span>৭ ধারার নোটিশ প্রয়োজনীয় তথ্য খরচ  (টাকা): ' . $request_data->amount_to_pay_as_costing . '</span>';
            $activity .= '<br>';
        }
        if (!empty($request_data->amount_to_pay_as_remaining_10ka)) {
            $activity .= '<span>১০ ক  ধারার নোটিশ প্রয়োজনীয় তথ্য বকেয়া (টাকা): ' . $request_data->amount_to_pay_as_remaining_10ka . '</span>';
            $activity .= '<br>';
        }
        if (!empty($request_data->amount_to_pay_as_costing_10ka)) {
            $activity .= '<span>১০ ক ধারার নোটিশ প্রয়োজনীয় তথ্য খরচ  (টাকা): ' . $request_data->amount_to_pay_as_costing_10ka . '</span>';
            $activity .= '<br>';
        }

        
        if ($user->role_id == 27) {
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেনারেল সার্টিফিকেট অফিসার';
            }
        } elseif ($user->role_id == 6) {
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেলা প্রশাসক';
            }
        } elseif ($user->role_id == 34) {
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'বিভাগীয় কমিশনার';
            }
        } elseif ($user->role_id == 25) {
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'ভূমি আপীল বোর্ড চেয়ারপারসন';
            }
        } elseif ($user->role_id == 2) {
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'Admin';
            }
        } elseif ($user->role_id == 1) {
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'Admin';
            }
        }

        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');
        $gcc_log_book = [
            'appeal_id' => $appealId,
            'user_id' => $user->id,
            'designation' => $designation,
            'activity' => $activity,
            'files' => $log_file_data,
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        DB::table('gcc_log_book')->insert($gcc_log_book);
    }

    public static function investigationreportsubmit($request_data, $investigator_details_array)
    {
        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $em_log_book = [
            'appeal_id' => $request_data['appeal_id'],
            'user_id' => '',
            'activity' => 'তদন্ত রিপোর্ট জমা দেয়া হয়েছে',
            'investigation_report' => json_encode($request_data),
            'investigator_details' => json_encode($investigator_details_array),
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }
    public static function investigationreportAccept($request_data, $investigator_details_array)
    {
        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $em_log_book = [
            'appeal_id' => $request_data['appeal_id'],
            'user_id' => '',
            'activity' => 'তদন্ত রিপোর্ট জমা দেয়া হয়েছে',
            'investigation_report' => json_encode($request_data),
            'investigator_details' => json_encode($investigator_details_array),
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }

    public static function investigationreportDelete($investigation_report_array, $investigator_details_array, $appeal_id)
    {
        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $user = globalUserInfo();

        if ($user->role_id == 28) {
            $activity = '<span>তদন্ত রিপোর্ট মুছে ফেলেছেন পেশকার (ইএম)</span>';
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'ইএম';
            }
        } elseif ($user->role_id == 27) {
            $activity = '<span>তদন্ত রিপোর্ট মুছে ফেলেছেন (নির্বাহী ম্যাজিস্ট্রেট)</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'নির্বাহী ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 37) {
            $activity = '<span>তদন্ত রিপোর্ট মুছে ফেলেছেন (জেলা ম্যাজিস্ট্রেট)</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 38) {
            $activity = '<span>তদন্ত রিপোর্ট মুছে ফেলেছেন (অতিরিক্ত জেলা ম্যাজিস্ট্রেট)</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 7) {
            $activity = '<span>তদন্ত রিপোর্ট মুছে ফেলেছেন (অতিরিক্ত জেলা প্রশাসক (এডিসি))</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা প্রশাসক (এডিসি)';
            }
        }

        $em_log_book = [
            'appeal_id' => $appeal_id,
            'user_id' => $user->id,
            'activity' => $activity,
            'designation' => $designation,
            'investigation_report' => json_encode($investigation_report_array),
            'investigator_details' => json_encode($investigator_details_array),
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }
    public static function investigationreportApprove($investigation_report_array, $investigator_details_array, $appeal_id)
    {
        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $user = globalUserInfo();

        if ($user->role_id == 28) {
            $activity = '<span>তদন্ত রিপোর্ট গ্রহণ করেছেন পেশকার (ইএম)</span>';
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = ' পেশকার ইএম';
            }
        } elseif ($user->role_id == 27) {
            $activity = '<span>তদন্ত রিপোর্ট গ্রহণ করেছেন (নির্বাহী ম্যাজিস্ট্রেট)</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'নির্বাহী ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 37) {
            $activity = '<span>তদন্ত রিপোর্ট গ্রহণ করেছেন (জেলা ম্যাজিস্ট্রেট)</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 38) {
            $activity = '<span>তদন্ত রিপোর্ট গ্রহণ করেছেন (অতিরিক্ত জেলা ম্যাজিস্ট্রেট)</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 7) {
            $activity = '<span>তদন্ত রিপোর্ট গ্রহণ করেছেন (অতিরিক্ত জেলা প্রশাসক (এডিসি))</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা প্রশাসক (এডিসি)';
            }
        }

        $em_log_book = [
            'appeal_id' => $appeal_id,
            'user_id' => $user->id,
            'activity' => $activity,
            'designation' => $designation,
            'investigation_report' => json_encode($investigation_report_array),
            'investigator_details' => json_encode($investigator_details_array),
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }

    public static function assign_ADC($appeal_id, $user_adc)
    {
        // dd($user);

        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $user = globalUserInfo();

        if ($user->role_id == 37) {
            $activity = '<span>অতিরিক্ত জেলা প্রশাসক কে এই মামলাটি  আসাইন করেছেন জেলা ম্যাজিস্ট্রেট</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর নাম মামলা ' . $user_adc['name'] . '</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর নাম মোবাইল ' . $user_adc['mobile_no'] . '</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর ইমেইল ' . $user_adc['email'] . '</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর দপ্তর আইডি / ইউজারনেম ' . $user_adc['username'] . '</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেলা ম্যাজিস্ট্রেট';
            }
        }

        $em_log_book = [
            'appeal_id' => $appeal_id,
            'user_id' => $user->id,
            'activity' => $activity,
            'designation' => $designation,
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }

    public static function remove_assign_ADC($appeal_id, $user_adc)
    {
        //dd($user);

        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $user = globalUserInfo();

        if ($user->role_id == 37) {
            $activity = '<span>অতিরিক্ত জেলা প্রশাসক কে এই মামলাটি থেকে আবসান করেছেন জেলা ম্যাজিস্ট্রেট</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর নাম মামলা ' . $user_adc['name'] . '</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর নাম মোবাইল ' . $user_adc['mobile_no'] . '</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর ইমেইল ' . $user_adc['email'] . '</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর দপ্তর আইডি / ইউজারনেম ' . $user_adc['username'] . '</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেলা ম্যাজিস্ট্রেট';
            }
        }

        $em_log_book = [
            'appeal_id' => $appeal_id,
            'user_id' => $user->id,
            'activity' => $activity,
            'designation' => $designation,
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }
}
