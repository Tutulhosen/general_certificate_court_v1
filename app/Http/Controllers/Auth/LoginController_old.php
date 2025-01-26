<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        } else {
            $user_create = $this->test_login_fun($request->email, $request->password);
            //dd($user_create);
            if ($user_create) {
                if (Auth::attempt(['username' => $request->email, 'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'])) {
                    return response()->json(['success' => 'Successfully logged in!']);
                }
            }
        }
        return response()->json(['error' => 'Please Enter Valid Credential!']);
    }

    public function test_login_fun($test_email, $test_password)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => DOPTOR_ENDPOINT().'/api/user/verify',
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
            $ref_origin_unit_org_id = $response2['data']['organogram_info'][array_key_first($response2['data']['organogram_info'])]['ref_origin_unit_org_id'];

            $username = DB::table('users')
                ->where('username', $response->data->user->username)
                ->first();

            if (empty($username)) {
                $office_info = $response->data->office_info[0];

                if ($ref_origin_unit_org_id == 533) {
                    return $this->Divisional_Commissioner_create($response, $office_info, $ref_origin_unit_org_id);
                }

                if ($ref_origin_unit_org_id == 51) {
                    return $this->DC_create($response, $office_info, $ref_origin_unit_org_id);
                }

                $GCO = ['570', '127698'];
                if (in_array($ref_origin_unit_org_id, $GCO)) {
                    return $this->GCO_create($response, $office_info, $ref_origin_unit_org_id);
                }

                $assitent_gco = ['255571','165667', '94965', '128397', '178770', '124194', '8530', '97323', '128396', '165757', '97324','178771', '136569', '9903'];

                if (in_array($ref_origin_unit_org_id, $assitent_gco)) {
                    return $this->Assitent_GCO_create($response, $office_info, $ref_origin_unit_org_id);
                }
            } else {
                return 1;
            }
        }
    }

    public function DC_create($response, $office_info, $ref_origin_unit_org_id)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $dis_name_en = explode(' ', $office_info->office_name_en);

        $dis_name_en = end($dis_name_en);

        $district = DB::table('district')
            ->where('district_name_en', strtoupper($dis_name_en))
            ->select('id', 'district_name_bn', 'district_name_en', 'division_bbs_code', 'district_bbs_code')
            ->first();
        $division = DB::table('division')
            ->where('division_bbs_code', $district->division_bbs_code)
            ->first();

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_id = DB::table('office')->insertGetId([
            'level' => 3,
            'parent' => null,
            'parent_name' => null,
            'office_name_bn' => $office_info->office_name_bn,
            'office_name_en' => $office_info->office_name_en,
            'unit_name_bn' => $office_info->unit_name_bn,
            'unit_name_en' => $office_info->unit_name_en,
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $district_bbs_code,
            'office_unit_organogram_id' => $ref_origin_unit_org_id,
            'is_gcc' => 1,
            'is_organization' => 0,
            'status' => 1,
        ]);


        if (isset($office_id)) {
            //dd('sdbds');
            
            //dd($office_id);

            $role_id = 6;
            $designation = $office_info->designation;
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);
            $user = [
                'name' => $response->data->employee_info->name_bng,
                'username' => $response->data->user->username,
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $response->data->employee_info->personal_mobile,
                'email' => $response->data->employee_info->personal_email,
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
            ];
        }
        $user_create = DB::table('users')->insert($user);

        return $user_create;
    }

    public function GCO_create($response, $office_info, $ref_origin_unit_org_id)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $upazila_bbs_code = null;

        $dis_name_en = explode(' ', $office_info->office_name_en);

        $dis_name_en = end($dis_name_en);

        $district = DB::table('district')
            ->where('district_name_en', strtoupper($dis_name_en))
            ->select('id', 'district_name_bn', 'district_name_en', 'division_bbs_code', 'district_bbs_code')
            ->first();
        $division = DB::table('division')
            ->where('division_bbs_code', $district->division_bbs_code)
            ->first();

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_id = DB::table('office')->insertGetId([
            'level' => 3,
            'parent' => null,
            'parent_name' => null,
            'office_name_bn' => $office_info->office_name_bn,
            'office_name_en' => $office_info->office_name_en,
            'unit_name_bn' => $office_info->unit_name_bn,
            'unit_name_en' => $office_info->unit_name_en,
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,
            'office_unit_organogram_id' => $ref_origin_unit_org_id,
            'is_gcc' => 1,
            'is_organization' => 0,
            'status' => 1,
        ]);

        //dd($office_create);
        if (isset($office_id)) {
            //dd('sdbds');
           
            //dd($office_id);

            $role_id = 27;
            $designation = $office_info->designation;
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);
            $user = [
                'name' => $response->data->employee_info->name_bng,
                'username' => $response->data->user->username,
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $response->data->employee_info->personal_mobile,
                'email' => $response->data->employee_info->personal_email,
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
            ];
        }
        $user_create = DB::table('users')->insert($user);

        return $user_create;
    }


    public function Assitent_GCO_create($response, $office_info, $ref_origin_unit_org_id)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $upazila_bbs_code = null;

        $dis_name_en = explode(' ', $office_info->office_name_en);

        $dis_name_en = end($dis_name_en);

        $district = DB::table('district')
            ->where('district_name_en', strtoupper($dis_name_en))
            ->select('id', 'district_name_bn', 'district_name_en', 'division_bbs_code', 'district_bbs_code')
            ->first();
        $division = DB::table('division')
            ->where('division_bbs_code', $district->division_bbs_code)
            ->first();

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_create = DB::table('office')->insert([
            'level' => 3,
            'parent' => null,
            'parent_name' => null,
            'office_name_bn' => $office_info->office_name_bn,
            'office_name_en' => $office_info->office_name_en,
            'unit_name_bn' => $office_info->unit_name_bn,
            'unit_name_en' => $office_info->unit_name_en,
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,
            'office_unit_organogram_id' => $ref_origin_unit_org_id,
            'is_gcc' => 1,
            'is_organization' => 0,
            'status' => 1,
        ]);

        //dd($office_create);
        if ($office_create) {
            //dd('sdbds');
            $office_id = DB::table('office')
                ->orderBy('id', 'desc')
                ->first();
            //dd($office_id);

            $role_id = 28;
            $designation = $office_info->designation;
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);
            $user = [
                'name' => $response->data->employee_info->name_bng,
                'username' => $response->data->user->username,
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $response->data->employee_info->personal_mobile,
                'email' => $response->data->employee_info->personal_email,
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
            ];
        }
        $user_create = DB::table('users')->insert($user);

        return $user_create;
    }






    public function Divisional_Commissioner_create($response, $office_info, $ref_origin_unit_org_id)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $district_id = null;
        $dis_name_bn = null;
        $dis_name_en = null;
        $district_bbs_code = null;
        $upazila_bbs_code = null;

        $div_name_en = explode(' ', $office_info->office_name_en);

        $div_name_en = end($div_name_en);

        $division = DB::table('division')
            ->where('division_name_en', strtoupper($div_name_en))
            ->first();

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $office_id = DB::table('office')->insertGetId([
            'level' => 2,
            'parent' => null,
            'parent_name' => null,
            'office_name_bn' => $office_info->office_name_bn,
            'office_name_en' => $office_info->office_name_en,
            'unit_name_bn' => $office_info->unit_name_bn,
            'unit_name_en' => $office_info->unit_name_en,
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,
            'office_unit_organogram_id' => $ref_origin_unit_org_id,
            'is_gcc' => 1,
            'is_organization' => 0,
            'status' => 1,
        ]);

        //dd($office_create);
        if (isset($office_id)) {
            //dd('sdbds');
            // $office_id = DB::table('office')
            //     ->orderBy('id', 'desc')
            //     ->first();
            //dd($office_id);

            $role_id = 34;
            $designation = $office_info->designation;
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);
            $user = [
                'name' => $response->data->employee_info->name_bng,
                'username' => $response->data->user->username,
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $response->data->employee_info->personal_mobile,
                'email' => $response->data->employee_info->personal_email,
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
            ];
        }
        $user_create = DB::table('users')->insert($user);

        return $user_create;
    }
}
