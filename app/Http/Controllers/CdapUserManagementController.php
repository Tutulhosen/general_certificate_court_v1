<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Rules\IsEnglish;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use App\Repositories\CdapUserManagementRepository;

class CdapUserManagementController extends Controller
{
    public function cdap_v2_login()
    {
        $redirect_url = route('home') . '/cdap/v2/callback/url';
        $random = Str::random(40);
        $queries = http_build_query([
            'response_type' => 'code',
            'client_id' => mygov_client_id(),
            'redirect_uri' => $redirect_url,
            'scope' => 'openid',
            'state' => $random,
        ]);

        return redirect(mygov_endpoint() . '/oauth/authorize?' . $queries);
    }

    public function call_back_function_from_mygov(Request $request)
    {
        $redirect_url = route('home') . '/cdap/v2/callback/url';
        $response = Http::post(
            mygov_endpoint() . '/oauth/token',

            [
                'grant_type' => 'authorization_code',
                'client_id' => mygov_client_id(),
                'client_secret' => mygov_client_secret(),
                'redirect_uri' => $redirect_url,
                'code' => $request->code,
            ]
        );
        $data = $response->json();
        
        if (empty($data)) {
            return redirect()->away(route('home'));
        }
        $access_token = $data['access_token'];
        
        session(['access_token_cdap' => $access_token]);

        Cookie::queue('access_token_cdap', $access_token, 120);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => mygov_endpoint() . '/api/user',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json', 'api-version: 1', 'Authorization: Bearer ' . $access_token],
        ]);

        $response1 = curl_exec($curl);

        curl_close($curl);

        //dd(json_decode($response1, true));

        $data_from_cdap = json_decode($response1, true);

        $user_exits_check_by_nid = DB::table('users')
            ->where('citizen_nid', '=', $data_from_cdap['data']['nid'])
            ->whereNotNull('citizen_nid')
            ->where('is_cdap_user', '=', 0)
            ->first();

        if (!empty($user_exits_check_by_nid)) {
            return redirect()->route('show_log_in_page')->with(['cdap_nid_error' => 'আপনার এন আই ডি দিয়ে ইতিমধ্যে নিবন্ধভুক্ত আপনি সাধারণ লগইন বাটন দিয়ে লগইন করুন']);
        }

        $cdap_user_exits = DB::table('cdap_users')
            ->where('mobile', '=', $data_from_cdap['data']['mobile'])
            ->where('nid', '=', $data_from_cdap['data']['nid'])
            ->first();

        if (empty($cdap_user_exits)) {

            if ($data_from_cdap['data']['nid_verify'] == 0) {

                return redirect()->route('cdap.nid.error');

            } else {
                return redirect()->route('cdap.user.select.role');
            }
        } else {
            $userdata = CdapUserManagementRepository::update_cdap_user_with_login($data_from_cdap);

            if (Auth::attempt(['username' => $userdata['username'], 'password' => $userdata['password']])) {
                return redirect()->route('dashboard');
            }
        }

    }

    public function cdap_user_select_role()
    {
        //dd($request);
        $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status', 1)->get();
        $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status', 1)->get();
        // return $data;
        return view('cdapSSOcitizen.registration')->with($data);
    }
    public function cdap_user_create_citizen(Request $request)
    {

        $access_token = $request->cookie('access_token_cdap');
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => mygov_endpoint() . '/api/user',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json', 'api-version: 1', 'Authorization: Bearer ' . $access_token],
        ]);

        $response1 = curl_exec($curl);

        curl_close($curl);

        $data_from_cdap = json_decode($response1, true);
        //create_cdap_user_citizen_with_login
        $userdata = CdapUserManagementRepository::create_cdap_user_citizen_with_login($data_from_cdap);

        if (Auth::attempt(['username' => $userdata['username'], 'password' => $userdata['password']])) {
            return redirect()->route('dashboard');
        }
    }
    public function cdap_user_create_organization(Request $request)
    {
        $access_token = $request->cookie('access_token_cdap');
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => mygov_endpoint() . '/api/user',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json', 'api-version: 1', 'Authorization: Bearer ' . $access_token],
        ]);

        $response1 = curl_exec($curl);

        curl_close($curl);

        $data_from_cdap = json_decode($response1, true);
        
        if(isset($data_from_cdap['message']))
        {
            return redirect()->route('cdap.v2.login');
        }
        if (empty($data_from_cdap['data']['email'])) {

            return redirect()->route('cdap.email.error');
        }
        
        $data['data_from_cdap']=$data_from_cdap;
        $data['division']=DB::table('division')->get();
        return view('cdapSSOcitizen.organization_reg')->with($data);
        
    }
    public function cdap_organizationRegister_store(Request $request)
    {
        
        $request->validate(
            [
                'name' => 'required',
                'citizen_nid' => 'required|unique:users,citizen_nid',
                'email' => 'email | required | unique:users,email',
                'mobile_no' => 'required|size:11|regex:/(01)[0-9]{9}/',
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'organization_id' => ['required',new IsEnglish()],
                'confirm_password' => 'min:6',
                'office_id'=>'required',
                'division_id'=>'required',
                'district_id'=>'required',
                'upazila_id'=>'required',
                'organization_type'=>'required',
                'office_name_bn'=>'required',
                'office_name_en'=>['required',new IsEnglish()],
                'organization_physical_address'=>'required',
                'organization_employee_id'=>'required',
                'designation'=>'required'
            ],
            [    
                'division_id.required'=>'বিভাগ নির্বাচন করুন',
                'district_id.required'=>'জেলা নির্বাচন করুন',
                'upazila_id.required'=>'উপজেলা নির্বাচন করুন',
                'organization_type.required'=>'প্রতিষ্ঠানের ধরন নির্বাচন করুন',
                'office_name_bn.required'=>'প্রতিষ্ঠানের নাম বাংলাতে দিন',
                'office_name_en.required'=>'প্রতিষ্ঠানের নাম ইংরেজিতে দিন',
                'organization_physical_address.required'=>'প্রতিষ্ঠানের ঠিকানা দিন',
                'office_id.required'=>'অফিস নির্বাচন করুন',
                'name.required' => 'পুরো নাম লিখুন',
                'citizen_nid.unique' => 'আপনার জাতীয় পরিচয় পত্র দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
                'email.unique' => 'আপনার ইমেইল  দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
                'email.required' => 'আপনার ইমেইল লিখুন',
                'mobile_no.required' => 'মোবাইল নং দিতে হবে',
                'organization_id.required'=>'রাউটিং নং দিতে হবে',
                'password.required_with' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'confirm_password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন, ৬ সংখ্যার বেশি হতে হবে',
                'password.same'=>'উভয় ক্ষেত্রে একই পাসওয়ার্ড লিখুন',
                'organization_employee_id.required'=>'প্রতিনিধির EmployeeID দিতে হবে',
                'designation.required'=>'পদবী দিতে হবে'
            ],
        );
        $access_token = $request->cookie('access_token_cdap');
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => mygov_endpoint() . '/api/user',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json', 'api-version: 1', 'Authorization: Bearer ' . $access_token],
        ]);

        $response1 = curl_exec($curl);

        curl_close($curl);

        $data_from_cdap = json_decode($response1, true);
        $userdata = CdapUserManagementRepository::create_cdap_user_organization_with_login($request,$data_from_cdap);
        if (Auth::attempt(['username' => $userdata['username'], 'password' => $userdata['password']])) {
            return redirect()->route('dashboard');
        }
    }
    

    public static function logout()
    {
        $access_token = Session::get('access_token_cdap');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => mygov_endpoint() . '/api/logout',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $access_token",
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        session()->forget('access_token_cdap');

        return redirect()->route('home');

    }
    

}
