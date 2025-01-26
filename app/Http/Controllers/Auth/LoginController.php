<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Providers\RouteServiceProvider;
use App\Repositories\NDoptorRepository;
use App\Repositories\CdapUserManagementRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function csLogin(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['success' => 'Successfully logged in!']);
        } elseif (Auth::attempt(['username' => $request->email, 'password' => $request->password])) {
            return response()->json(['success' => 'Successfully logged in!']);
        } elseif (Auth::attempt(['citizen_nid' => $request->email, 'password' => $request->password])) {
            return response()->json(['success' => 'Successfully logged in!']);
        }
        //else {
        //     $user_create = $this->test_login_fun($request->email, $request->password);
        //     //dd($user_create);
        //     if ($user_create) {
        //         if (Auth::attempt(['username' => $request->email, 'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'])) {
        //             return response()->json(['success' => 'Successfully logged in!']);
        //         }
        //     }
        // }
        // if (str_contains($request->email, "100000") || str_contains($request->email, "200000") || str_contains($request->email, "300000") || str_contains($request->email, "400000") || str_contains($request->email, "500000") || str_contains($request->email, "600000") || str_contains($request->email, "700000") || str_contains($request->email, "800000") || str_contains($request->email, "900000")) {
        //     $nothi_status = NDoptorRepository::verifyDoptorUser($request->email, $request->password)['status'];
        //     if ($nothi_status == "error") {
        //         return response()->json(
        //             [
        //                 'error' => 'Please Enter Valid Credential!',
        //                 'nothi_msg' => 'সঠিক নথি আইডি অথবা পাসওয়ার্ড প্রদান করুন',

        //             ]);
        //     } else {

        //         return response()->json(
        //             [
        //                 'error' => 'Please Enter Valid Credential!',
        //                 'nothi_msg' => 'আপনার লগইন সফল হয়েছে। কিন্তু আপনাকে এখনো কোন আদালতে নিযুক্ত করা হয়নি। নিযুক্তি নিশ্চিত করতে  01XXXXXXXXX নাম্বারে যোগাযোগ করুন।',

        //             ]);
        //     }
        // }
        return response()->json(
            [
                'error' => 'Please Enter Valid Credential!',
                'nothi_msg' => 'সঠিক ইমেইল, মোবাইল নং অথবা পাসওয়ার্ড প্রদান করুন ',

            ]
        );
    }

    public function administrativeLogin(Request $request)
    {


        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);



        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $user_exits_check = DB::table('users')
            ->where('username', $request->email)
            ->orWhere('email', $request->email)
            ->orWhere('citizen_nid', $request->email)
            ->first();

        if (!empty($user_exits_check->role_id)) {
            if ($user_exits_check->role_id == 1 || $user_exits_check->role_id == 2 || $user_exits_check->role_id == 8 || $user_exits_check->role_id == 25) {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    return response()->json(['success' => 'Successfully logged in!']);
                } elseif (Auth::attempt(['username' => $request->email, 'password' => $request->password])) {
                    return response()->json(['success' => 'Successfully logged in!']);
                } elseif (Auth::attempt(['citizen_nid' => $request->email, 'password' => $request->password])) {
                    return response()->json(['success' => 'Successfully logged in!']);
                }
            } else {
                return response()->json(
                    [
                        'error' => 'invalid user',
                        'nothi_msg' => 'এখানে শুধুমাত্র প্রশাসনিকগন লগইন করবেন'
                    ]
                );
            }
        }


        //else {
        //     $user_create = $this->test_login_fun($request->email, $request->password);
        //     //dd($user_create);
        //     if ($user_create) {
        //         if (Auth::attempt(['username' => $request->email, 'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'])) {
        //             return response()->json(['success' => 'Successfully logged in!']);
        //         }
        //     }
        // }
        // if (str_contains($request->email, "100000") || str_contains($request->email, "200000") || str_contains($request->email, "300000") || str_contains($request->email, "400000") || str_contains($request->email, "500000") || str_contains($request->email, "600000") || str_contains($request->email, "700000") || str_contains($request->email, "800000") || str_contains($request->email, "900000")) {
        //     $nothi_status = NDoptorRepository::verifyDoptorUser($request->email, $request->password)['status'];
        //     if ($nothi_status == "error") {
        //         return response()->json(
        //             [
        //                 'error' => 'Please Enter Valid Credential!',
        //                 'nothi_msg' => 'সঠিক নথি আইডি অথবা পাসওয়ার্ড প্রদান করুন',

        //             ]);
        //     } else {

        //         return response()->json(
        //             [
        //                 'error' => 'Please Enter Valid Credential!',
        //                 'nothi_msg' => 'আপনার লগইন সফল হয়েছে। কিন্তু আপনাকে এখনো কোন আদালতে নিযুক্ত করা হয়নি। নিযুক্তি নিশ্চিত করতে  01XXXXXXXXX নাম্বারে যোগাযোগ করুন।',

        //             ]);
        //     }
        // }
        return response()->json(
            [
                'error' => 'Please Enter Valid Credential!',
                'nothi_msg' => 'সঠিক ইমেইল, মোবাইল নং অথবা পাসওয়ার্ড প্রদান করুন ',

            ]
        );
    }
    public function test_login_fun($test_email, $test_password)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => DOPTOR_ENDPOINT() . '/api/user/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => ['username' => $test_email, 'password' => $test_password],
            CURLOPT_HTTPHEADER => ['api-version: 1'],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        $response2 = json_decode($response, true);
        $response = json_decode($response);

        if ($response->status == 'success') {

            $username = DB::table('users')
                ->where('username', $response->data->user->username)
                ->first();

            if (empty($username)) {
                if (empty($response2['data']['office_info'])) {
                    return 0;
                }
                $ref_origin_unit_org_id = $response2['data']['organogram_info'][array_key_first($response2['data']['organogram_info'])]['ref_origin_unit_org_id'];

                $office_info = $response->data->office_info[0];

                if ($ref_origin_unit_org_id == 533) {
                    NDoptorRepository::Divisional_Commissioner_create($response, $office_info, $ref_origin_unit_org_id);
                }

                if ($ref_origin_unit_org_id == 51) {
                    NDoptorRepository::DC_create($response, $office_info, $ref_origin_unit_org_id);
                }
            } else {
                return 1;
            }
        }
    }

    public function cdap_user_login_verify(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $token = CdapUserManagementRepository::create_token();
        if ($token['status'] == 'success') {
            $data_from_cdap = CdapUserManagementRepository::call_login_curl($token['token'], $request->password, $request->email);
            if ($data_from_cdap['status'] == 'success') {

                $user_exits_check_by_nid = DB::table('users')
                    ->where('citizen_nid', '=', $data_from_cdap['data']['nid'])
                    ->whereNotNull('citizen_nid')
                    ->where('is_cdap_user', '=', 0)
                    ->first();

                if (!empty($user_exits_check_by_nid)) {
                    return response()->json(['error' => 'আপনার এন আই ডি দিয়ে ইতিমধ্যে নিবন্ধভুক্ত আপনি সাধারণ লগইন বাটন দিয়ে লগইন করুন']);
                }

                $cdap_user_exits = DB::table('cdap_users')
                    ->where('mobile', '=', $data_from_cdap['data']['mobile'])
                    ->where('nid', '=', $data_from_cdap['data']['nid'])
                    ->first();

                if (empty($cdap_user_exits)) {
                    if ($data_from_cdap['data']['nid_verify'] == 0) {
                        return response()->json(
                            [
                                'error' => 'দয়া করে CDAP এ গিয়ে আপনার NID verify করুন',
                                'is_nid_verify' => 1,
                            ]
                        );
                        //return redirect()->back()->with('nid_error','দয়া করে CDAP এ গিয়ে আপনার NID verify করুন');
                    } else {
                        $userdata = CdapUserManagementRepository::create_cdap_user_with_login($data_from_cdap);

                        if (Auth::attempt(['username' => $userdata['username'], 'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'])) {
                            return response()->json(['success' => 'Successfully logged in!']);

                            //return redirect()->route('dashboard');
                        }
                    }
                } else {
                    $userdata = CdapUserManagementRepository::update_cdap_user_with_login($data_from_cdap);

                    if (Auth::attempt(['username' => $userdata['username'], 'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'])) {
                        return response()->json(['success' => 'Successfully logged in!']);

                        //return redirect()->route('dashboard');
                    }
                }
            }
            return response()->json(['error' => 'আপনাকে খুজে পাওয়া যায় নাই']);
        }
    }

    public function ndoptor_sso()
    {
    
        $callbackurl = url('/') . '/test/nothi/callback';
        $zoom_join_url = DOPTOR_ENDPOINT() . '/v2/login?' . 'referer=' . base64_encode($callbackurl);

        return redirect()->away($zoom_join_url);
    }
    public function ndoptor_sso_callback(Request $request)
    {
        $data_get_method = $request->data;
        $data = json_decode(base64_decode($request->data), true);

        if (!isset($data['token'])) {
            return redirect()->route('nothi.v2.login');
        } else {
            $token = $data['token'];
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => DOPTOR_ENDPOINT() . '/api/user/me',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json', 'api-version: 1', 'Authorization: Bearer ' . $token],
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
 
        if ($response->status == 'success') {
            $username = DB::table('users')
                ->where('username', $response->data->user->username)
                ->first();
            
            if (!empty($username)) {
                $is_current_office = NDoptorRepository::verifyCurrentDesk($username->username);
            }
         
            if (empty($username)) {
                return Redirect()->route('nothi_issus');
            } elseif ($is_current_office['status']) {
                if ($is_current_office['role_id'] != 28) {
                    $url = url('/') . '/disable/doptor/user/' . $is_current_office['role_id'];
                    return redirect()->to($url);
                } else {
                    
                    $url = url('/') . '/disable/certificate_asst/' . $is_current_office['level'];
                    return redirect()->to($url);
                }
            } else {
                if (Auth::attempt(['username' => $username->username, 'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'])) {
                    return Redirect()->route('dashboard');
                } else {
                    return Redirect()->route('nothi_issus');
                }
            }
        }
    }
    public function ndoptor_sso_nothi_issus(Request $request)
    {
        $data['title'] = 'Doptor User Not Registered';
        $data['message1'] = 'আপনি নিবন্ধিত নন';

        $data['message2'] = 'আপনার লগইন সফল হয়েছে। কিন্তু আপনাকে এখনো কোন আদালতে নিযুক্ত করা হয়নি। নিযুক্তি নিশ্চিত করতে  01XXXXXXXXX নাম্বারে যোগাযোগ করুন।';
        $callbackurl = url('/');
        $zoom_join_url = DOPTOR_ENDPOINT() . '/logout?' . 'referer=' . base64_encode($callbackurl);

        $data['callbackurl'] = $zoom_join_url;

        return view('doptor.disable_doptor_user')->with($data);
    }


    
}
