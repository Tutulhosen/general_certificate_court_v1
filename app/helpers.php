<?php

// namespace App\Http\Controllers;
// use Illuminate\Support\Str;

use App\Models\User;
use App\Models\CaseActivityLog;
use App\Models\RM_CaseActivityLog;
// use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

if (!function_exists('appeal_status_bng')) {
    function appeal_status_bng($appeal_status)
    {
        if ($appeal_status == 'SEND_TO_GCO') {
            // $getStatus = "প্রেরণ(সহকারী কমিশনার)";
            $getStatus = 'গ্রহণের জন্য অপেক্ষমান';
        } elseif ($appeal_status == 'SEND_TO_ASST_GCO') {
            // $getStatus = "প্রেরণ(সহকারী কমিশনার)";
            $getStatus = 'গ্রহণের জন্য অপেক্ষমান (সার্টিফিকেট সহকারী)';
        } elseif ($appeal_status == 'ON_TRIAL') {
            $getStatus = 'জেনারেল সার্টিফিকেট অফিসারের আদালতে বিচারাধীন';
        } elseif ($appeal_status == 'ON_TRIAL_DC') {
            $getStatus = 'জেলা প্রশাসকের আদালতে বিচারাধীন';
        } elseif ($appeal_status == 'ON_TRIAL_DIV_COM') {
            $getStatus = 'বিভাগীয় কমিশনারের আদালতে বিচারাধীন';
        } elseif ($appeal_status == 'ON_TRIAL_LAB_CM') {
            $getStatus = 'ভূমি আপিল বোর্ড চেয়ারম্যানের আদালতে বিচারাধীন';
        } elseif ($appeal_status == 'SEND_TO_DC') {
            // $getStatus = "প্রেরণ(জেলা প্রশাসক)";
            $getStatus = 'গ্রহণের জন্য অপেক্ষমান (জেলা প্রশাসক)';
        } elseif ($appeal_status == 'SEND_TO_DIV_COM') {
            // $getStatus = "প্রেরণ(বিভাগীয় কমিশনার)";
            $getStatus = 'গ্রহণের জন্য অপেক্ষমান (বিভাগীয় কমিশনার)';
        } elseif ($appeal_status == 'SEND_TO_LAB_CM') {
            // $getStatus = "প্রেরণ(জাতীয় রাজস্ব বোর্ড)";
            $getStatus = 'গ্রহণের জন্য অপেক্ষমান (ভূমি আপিল বোর্ড)';
        } elseif ($appeal_status == 'RESEND_TO_DM') {
            $getStatus = 'পুন:প্রেরণ(সংশ্লিষ্ট আদালত)'; //হস্তান্তর
        } elseif ($appeal_status == 'RESEND_TO_Peshkar') {
            $getStatus = 'পুন:প্রেরণ(উচ্চমান সহকারী)'; //হস্তান্তর
        } elseif ($appeal_status == 'CLOSED') {
            $getStatus = 'নিষ্পন্ন'; //হস্তান্তর
        } elseif ($appeal_status == 'REJECTED') {
            $getStatus = 'খারিজকৃত ';
        } elseif ($appeal_status == 'DRAFT') {
            $getStatus = 'খসড়া'; //হস্তান্তর
        } else {
            $getStatus = $appeal_status;
        }
        return $getStatus;
    }
}

if (!function_exists('case_dicision_status_bng')) {
    function case_dicision_status_bng($appeal_status)
    {
        if ($appeal_status == 'SEND_TO_GCO') {
            $getStatus = 'গ্রহণের জন্য অপেক্ষমান ';
        } elseif ($appeal_status == 'ON_TRIAL') {
            $getStatus = 'চলমান ';
        } elseif ($appeal_status == 'RESEND_TO_DM') {
            $getStatus = 'চলমান ';
        } elseif ($appeal_status == 'RESEND_TO_Peshkar') {
            $getStatus = 'চলমান ';
        } elseif ($appeal_status == 'CLOSED') {
            $getStatus = 'নিষ্পত্তি হয়েছে';
        } elseif ($appeal_status == 'REJECTED') {
            $getStatus = 'অগৃহীত';
        } elseif ($appeal_status == 'DRAFT') {
            $getStatus = 'খসড়া';
        } else {
            $getStatus = $appeal_status;
        }
        return $getStatus;
    }
}

if (!function_exists('globalUserInfo')) {
    function globalUserInfo()
    {
        // $userInfo = Session::get('userInfo')->username; //when sso connected
        $userInfo = Auth::user(); //when laravel default auth system.
        return $userInfo;
    }
}

if (!function_exists('globalUserRoleInfo')) {
    function globalUserRoleInfo()
    {
        // $userInfo = Session::get('userInfo')->username; //when sso connected
        $userRole = Auth::user()->role_id;
        return DB::table('role')
            ->select('role_name')
            ->where('id', $userRole)
            ->first();
        //when laravel default auth system.
        // return $userInfo;
    }
}

if (!function_exists('globalUserOfficeInfo')) {
    function globalUserOfficeInfo()
    {
        // $userInfo = Session::get('userInfo')->username; //when sso connected
        $userOffice = Auth::user()->office_id;
        return DB::table('office')
            ->select('office_name_bn')
            ->where('id', $userOffice)
            ->first();
        //when laravel default auth system.
        // return $userInfo;
    }
}

if (!function_exists('user_office_info')) {
    function user_office_info()
    {
        $user = Auth::user();
        return DB::table('users')
            ->select('office.*', 'users.id AS user_id', 'division.id AS division_id', 'division.division_name_bn', 'district.id  AS district_id', 'district.district_name_bn', 'upazila.id  AS upazila_id', 'upazila.upazila_name_bn', 'office.office_name_bn')
            ->leftJoin('office', 'users.office_id', '=', 'office.id')
            ->leftJoin('division', 'office.division_id', '=', 'division.id')
            ->leftJoin('district', 'office.district_id', '=', 'district.id')
            ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
            ->where('users.id', $user->id)
            ->first();
    }
}

if (!function_exists('user_office_name')) {
    function user_office_name()
    {
        $user = Auth::user();
        return $office = DB::table('office')
            ->select('office_name_bn')
            ->where('office.id', $user->office_id)
            ->first()->office_name_bn;
    }
}

if (!function_exists('user_district_name')) {
    function user_district_name()
    {
        $user = Auth::user();
        return $district = DB::table('office')
            ->select('district_name_bn')
            ->join('district', 'office.district_id', '=', 'district.id')
            ->where('office.id', $user->office_id)
            ->first()->district_name_bn;
    }
}

if (!function_exists('user_upazila_name')) {
    function user_upazila_name()
    {
        $user = Auth::user();
        return $upazila = DB::table('office')
            ->select('upazila_name_bn')
            ->join('upazila', 'office.upazila_id', '=', 'upazila.id')
            ->where('office.id', $user->office_id)
            ->first()->upazila_name_bn;
    }
}

if (!function_exists('user_division')) {
    function user_division()
    {
        $user = Auth::user();
        return DB::table('users')
            ->select('division.id', 'division.division_name_bn')
            ->leftJoin('office', 'users.office_id', '=', 'office.id')
            ->join('division', 'office.division_id', '=', 'division.id')
            ->where('users.id', $user->id)
            ->first()->id;
    }
}

if (!function_exists('user_district')) {
    function user_district()
    {
        $user = Auth::user();
        return $district = DB::table('office')
            ->select('district.district_name_bn AS district_name', 'district.id')
            ->join('district', 'office.district_id', '=', 'district.id')
            ->where('office.id', $user->office_id)
            ->first();
    }
}

if (!function_exists('user_upazila')) {
    function user_upazila()
    {
        $user = Auth::user();
        return $upazila = DB::table('office')
            ->select('upazila_id')
            ->join('upazila', 'office.upazila_id', '=', 'upazila.id')
            ->where('office.id', $user->office_id)
            ->first()->upazila_id;
    }
}

if (!function_exists('user_email')) {
    function user_email()
    {
        $user = Auth::user();
        return $user->email;
    }
}

if (!function_exists('bn2en')) {
    function bn2en($item)
    {
        return App\Http\Controllers\CommonController::bn2en($item);
        // echo $item;
    }
}
if (!function_exists('get_divison_name')) {
    function get_divison_name($div_id)
    {
        return DB::table('division')->where('id', $div_id)->first();

    }
}
if (!function_exists('get_district_name')) {
    function get_district_name($dis_id)
    {
        return DB::table('district')->where('id', $dis_id)->first();
        
    }
}
if (!function_exists('get_upazila_name')) {
    function get_upazila_name($upa_id)
    {
        return DB::table('upazila')->where('id', $upa_id)->first();
        
    }
}
if (!function_exists('en2bn')) {
    function en2bn($item)
    {
        return App\Http\Controllers\CommonController::en2bn($item);
        // echo $item;
    }
}

if (!function_exists('case_status')) {
    function case_status($item)
    {
        if ($item == 1) {
            $result = "<span class='label label-success'>Enable</span>";
        } else {
            $result = "<span class='label label-warning'>Disable</span>";
        }
        return $result;
    }
}

// if (!function_exists('english2bangli')) {
//    function english2bangli($item) {
//       // return CommonController::en2bn($item);
//       return 'A';
//    }
// }

if (!function_exists('case_activity_logs')) {
    function case_activity_logs($data)
    {
        $user = Auth::user();
        $userDivision = user_division();
        $userDistrict = user_district();
        $userOffice = user_office_info();

        $log = new CaseActivityLog();
        $log->user_id = $user->id;
        $log->case_register_id = $data['case_register_id'];
        $log->user_roll_id = $user->role_id;
        $log->activity_type = $data['activity_type'];
        $log->message = $data['message'];
        $log->office_id = $user->office_id;
        $log->division_id = $userDivision == null ? null : $userDivision;
        $log->district_id = $userDistrict == null ? null : $userDistrict;
        $log->upazila_id = $userOffice->upazila_id == null ? null : $userOffice->upazila_id;
        $log->old_data = $data['old_data'];
        $log->new_data = $data['new_data'];
        $log->ip_address = request()->ip();
        $log->user_agent = request()->userAgent();
        $log->save();
        return $log;
    }
}

if (!function_exists('RM_case_activity_logs')) {
    function RM_case_activity_logs($data)
    {
        $user_id = Auth::user()->id;
        $user_info = User::where('id', $user_id)
            ->with('office', 'role')
            ->get()
            ->toArray();
        $user_info = array_merge($user_info, [
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $log = new RM_CaseActivityLog();
        $log->user_info = json_encode($user_info);
        $log->rm_case_id = $data['rm_case_id'];
        $log->activity_type = $data['activity_type'];
        $log->massage = $data['message'];
        $log->old_data = $data['old_data'];
        $log->new_data = $data['new_data'];
        $log->save();
        return $log;
    }
}
if (!function_exists('is_english')) {
    function is_english($string)
    {
        $string = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/', '', $string));

        if (!preg_match('/[^A-Za-z0-9]/', $string)) {
            // '/[^a-z\d]/i' should also work.
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('get_office_by_id')) {
    function get_office_by_id($office_id)
    {
        return DB::table('office')
            ->where('id', $office_id)
            ->first();
    }
}

if (!function_exists('date_formater_helpers_make_bd')) {
    function date_formater_helpers_make_bd($requestDate)
    {
        if (!empty($requestDate)) {
            $date_1 = explode('/', $requestDate);

            //dd($date_1[2] . '-' . $date_1[0] . '-' . $date_1[1]);
            return $date_1[2] . '-' . $date_1[1] . '-' . $date_1[0];
        } else {
            return null;
        }
    }
}
if (!function_exists('date_formater_helpers_make_bd_v2')) {
    function date_formater_helpers_make_bd_v2($requestDate)
    {
        if (!empty($requestDate)) {
            $date_1 = explode('-', $requestDate);

            //dd($date_1[2] . '-' . $date_1[0] . '-' . $date_1[1]);
            return $date_1[2] . '-' . $date_1[1] . '-' . $date_1[0];
        } else {
            return null;
        }
    }
}

if (!function_exists('date_formater_helpers_v2')) {
    function date_formater_helpers_v2($requestDate)
    {
        if (!empty($requestDate)) {
            $date_1 = explode('-', $requestDate);

            //dd($date_1[2] . '-' . $date_1[0] . '-' . $date_1[1]);
            return $date_1[2] . '-' . $date_1[1] . '-' . $date_1[0];
        } else {
            return null;
        }
    }
}

if (!function_exists('get_short_order_name_by_id')) {
    function get_short_order_name_by_id($ID)
    {
        return DB::table('gcc_case_shortdecision_templates')
            ->where('id', $ID)
            ->first()->template_name;
    }
}


/****** SI issues start Here  */
if (!function_exists('dorptor_widget')) {
    function dorptor_widget()
    {
        try {
            $response = Http::get(DOPTOR_ENDPOINT() . '/api/switch/widget');
          
            return json_decode($response)->data;
        } catch (\Exception $e) {
            return;
        }
    }
}
if (!function_exists('DOPTOR_ENDPOINT')) {
    function DOPTOR_ENDPOINT()
    {
        return 'https://api-training.doptor.gov.bd';
        // return 'https://n-doptor-api.nothi.gov.bd/';
    }
}
if (!function_exists('doptor_client_id')) {
    function doptor_client_id()
    {
        return 'BDNT4N';
    }
}
if (!function_exists('doptor_password')) {
    function doptor_password()
    {
        return "B5$1CF";
    }
}

if (!function_exists('mygov_endpoint')) {
    function mygov_endpoint()
    {
        return 'https://beta-idp.stage.mygov.bd';
    }
}
if (!function_exists('mygov_client_id')) {
    function mygov_client_id()
    {
        return '978366b3-089a-4175-bb3c-56d73b56de00';
    }
}
if (!function_exists('mygov_client_secret')) {
    function mygov_client_secret()
    {
        return 'p7kxZj4AmV9K5JFa8BAQEsUEkzb2VT4X46UClG02';
    }
}

if (!function_exists('mygov_nid_verification_api_endpoint')) {
    function mygov_nid_verification_api_endpoint()
    {
        return 'https://si.stage.mygov.bd';
    }
}

if (!function_exists('mygov_nid_verification_api_key')) {
    function mygov_nid_verification_api_key()
    {
        return 'pG1mNkZjqM';
    }
}

if (!function_exists('mygov_nid_verification_api_password')) {
    function mygov_nid_verification_api_password()
    {
        return '#radeuigccmygov@31idai32';
    }
}

if (!function_exists('mygov_nid_verification_api_email')) {
    function mygov_nid_verification_api_email()
    {
        return 'jafrin.ahammed@gcc.gov.bd';
    }
}

if (!function_exists('org_type')) {
    function org_type($type)
    {
        if ($type=="BANK") {
            return 'ব্যাংক';
        }
        if ($type=="GOVERNMENT") {
            return 'সরকারি প্রতিষ্ঠান';
        }
        if ($type=="OTHER_COMPANY") {
            return 'স্বায়ত্তশাসিত প্রতিষ্ঠান';
        }
        
    }
}
