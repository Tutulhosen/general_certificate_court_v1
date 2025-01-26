<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class NDoptorRepositoryAdmin
{
    public static function getToken($username)
    {
        return Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->post(doptor_endpoint().'/api/client/login', [
                'client_id' => doptor_client_id(),
                'username' => $username,
                'password' => doptor_password(),
            ])
            ->throw()
            ->json();
    }
    public static function get_employee_list_by_office($token, $office_id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => doptor_endpoint().'/api/get_employee_list_by_office/' . $office_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json', 'api-version: 1', 'Authorization: Bearer ' . $token],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }
    public static function all_user_list_from_doptor_segmented($data)
    {
        $list_of_all = [];

        foreach ($data as $value) {
            $court_id = DB::table('users')
                ->select('court_id', 'role_id')
                ->where('username', '=', $value['username'])
                ->first();

            if (!empty($court_id)) {
                $value['court_id'] = $court_id->court_id;
                $value['role_id'] = $court_id->role_id;
            } else {
                $value['court_id'] = null;
                $value['role_id'] = null;
            }
            array_push($list_of_all, $value);
        }

        return json_encode([
            'list_of_all' => $list_of_all,
        ]);
    }

    public static function all_user_list_from_doptor_segmented_search($data)
    {
        $list_of_all = [];

        foreach ($data as $value) {
            $court_id = DB::table('users')
                ->select('court_id', 'role_id')
                ->where('username', '=', $value['username'])
                ->first();

            if (!empty($court_id)) {
                $value['court_id'] = $court_id->court_id;
                $value['role_id'] = $court_id->role_id;
            } else {
                $value['court_id'] = null;
                $value['role_id'] = null;
            }
            array_push($list_of_all, $value);
        }

        //dd($list_of_others);

        return json_encode([
            'list_of_all' => $list_of_all,
        ]);
    }

    public static function rolelist_district()
    {
        return DB::table('role')
            ->whereIn('id', [27, 28, 6, 7])
            ->get();
    }
    public static function rolelist_upazila()
    {
        return DB::table('role')
            ->whereIn('id', [27, 28])
            ->get();
    }
    public static function courtlist_district($district_id,$division_id)
    {
        $query = DB::table('court');
        $query->where('level', '=', 1);
        if (!empty($district_id)) {
            $query->where('district_id', '=', $district_id);
        }
        if (!empty($division_id)) {
            $query->where('division_id', '=', $division_id);
        }
        $court = $query->get();

        return $court;

        //$courtlist=DB::table('court')
    }
    public static function courtlist_upazila($district_id,$division_id)
    {
        $query = DB::table('court');

        $query->where('level', '=', 0);
        if (!empty($district_id)) {
            $query->where('district_id', '=', $district_id);
        }
        if (!empty($division_id)) {
            $query->where('division_id', '=', $division_id);
        }
        $court = $query->get();

        return $court;

        
    }
    public static function rolelist_division()
    {
        return DB::table('role')
            ->where('id', '=', 34)
            ->get();
    }
    public static function search_revisions($dataArray, $search_value, $key_to_search, $other_matching_value = null, $other_matching_key = null)
    {
        // This function will search the revisions for a certain value
        // related to the associative key you are looking for.
        $keys = [];
        foreach ($dataArray as $key => $cur_value) {
            if (str_contains($cur_value[$key_to_search], $search_value)) {
                if (isset($other_matching_key) && isset($other_matching_value)) {
                    if ($cur_value[$other_matching_key] == $other_matching_value) {
                        $keys[] = $key;
                    }
                } else {
                    // I must keep in mind that some searches may have multiple
                    // matches and others would not, so leave it open with no continues.
                    $keys[] = $key;
                }
            }
        }
        return $keys;
    }
    public static function current_desk($username)
    {
        return Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->post(doptor_endpoint().'/api/user/current_desk', [
                'username' => $username,
            ])
            ->throw()
            ->json();
    }
    public static function get_office_basic_info($token, $office_id)
    {
        return Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$token}",
        ])
            ->post(doptor_endpoint().'/api/offices', [
                'office_ids' => $office_id,
            ])
            ->throw()
            ->json();
    }
    public static function OfficeExitsCheck($office_data)
    {
        $office_id = DB::table('office')
            ->where('level', '=', $office_data['level'])
            ->where('parent', '=', $office_data['parent'])
            ->where('parent_name', '=', $office_data['parent_name'])
            ->where('office_name_bn', '=', $office_data['office_name_bn'])
            ->where('office_name_en', '=', $office_data['office_name_en'])
            ->where('unit_name_bn', '=', $office_data['unit_name_bn'])
            ->where('unit_name_en', '=', $office_data['unit_name_en'])
            ->where('upazila_id', '=', $office_data['upazila_id'])
            ->where('upa_name_bn', '=', $office_data['upa_name_bn'])
            ->where('upa_name_en', '=', $office_data['upa_name_en'])
            ->where('district_id', '=', $office_data['district_id'])
            ->where('dis_name_bn', '=', $office_data['dis_name_bn'])
            ->where('dis_name_en', '=', $office_data['dis_name_en'])
            ->where('division_id', '=', $office_data['division_id'])
            ->where('div_name_bn', '=', $office_data['div_name_bn'])
            ->where('div_name_en', '=', $office_data['div_name_en'])
            ->where('district_bbs_code', '=', $office_data['district_bbs_code'])
            ->where('upazila_bbs_code', '=', $office_data['upazila_bbs_code'])
            ->where('office_unit_organogram_id', '=', $office_data['office_unit_organogram_id'])
            ->where('is_gcc', '=', $office_data['is_gcc'])
            ->where('is_organization', '=', $office_data['is_organization'])
            ->where('status', '=', $office_data['status'])
            ->first();

        if (empty($office_id)) {
            $office_id = DB::table('office')->insertGetId($office_data);

            return $office_id;
        } else {
            return $office_id->id;
        }
    }

    public static function Div_Commissioner_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];

        $division_from_geo = DB::table('geo_divisions')
            ->where('id', '=', $geo_division_id)
            ->first();

        $division = DB::table('division')
            ->where('division_bbs_code', $division_from_geo->bbs_code)
            ->first();

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $office_label = 2;
        $parent = null;
        $parent_name = null;

        $office_unit_organogram_id = 533;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

            'upazila_id' => null,
            'upa_name_bn' => null,
            'upa_name_en' => null,
            'district_id' => null,
            'dis_name_bn' => null,
            'dis_name_en' => null,
            'district_bbs_code' => null,
            'upazila_bbs_code' => null,
        ];

        $office_id = self::OfficeExitsCheck($office_data);

        if (isset($office_id)) {
            $role_id = 34;

            $designation = $user_info_from_request['designation_bng'] . '(বিভাগীয় কমিশনার)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }
    public static function Div_Commissioner_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];

        $division_from_geo = DB::table('geo_divisions')
            ->where('id', '=', $geo_division_id)
            ->first();

        $division = DB::table('division')
            ->where('division_bbs_code', $division_from_geo->bbs_code)
            ->first();

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $office_label = 2;
        $parent = null;
        $parent_name = null;

        $office_unit_organogram_id = 533;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

            'upazila_id' => null,
            'upa_name_bn' => null,
            'upa_name_en' => null,
            'district_id' => null,
            'dis_name_bn' => null,
            'dis_name_en' => null,
            'district_bbs_code' => null,
            'upazila_bbs_code' => null,
        ];
        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {
            $role_id = 34;

            $designation = $user_info_from_request['designation_bng'] . '(বিভাগীয় কমিশনার)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);
            if ($user_info_from_request['role_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => $doptor_user_active,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        } elseif ($updated_office == 0) {
            if ($user_info_from_request['role_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }

            $role_id = 34;

            $designation = $user_info_from_request['designation_bng'] . '(বিভাগীয় কমিশনার)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => $doptor_user_active,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }
    }

    public static function Dis_Commissioner_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        
        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;

        $office_unit_organogram_id = 51;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

            'upazila_id' => null,
            'upa_name_bn' => null,
            'upa_name_en' => null,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'district_bbs_code' =>$district_bbs_code,
            'upazila_bbs_code' => null,
        ];

        $office_id = self::OfficeExitsCheck($office_data);

        if (isset($office_id)) {
            $role_id = 6;

            $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'court_id' => $user_info_from_request['court_id'],
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }
    public static function Ad_Dis_Commissioner_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        
        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;

        $office_unit_organogram_id = 51;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

            'upazila_id' => null,
            'upa_name_bn' => null,
            'upa_name_en' => null,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'district_bbs_code' =>$district_bbs_code,
            'upazila_bbs_code' => null,
        ];

        $office_id = self::OfficeExitsCheck($office_data);

        if (isset($office_id)) {
            $role_id = 7;

            $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'court_id' => $user_info_from_request['court_id'],
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }
    public static function Dis_Commissioner_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        
        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;

        $office_unit_organogram_id = 51;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

            'upazila_id' => null,
            'upa_name_bn' => null,
            'upa_name_en' => null,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'district_bbs_code' =>$district_bbs_code,
            'upazila_bbs_code' => null,
        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);
            if ($updated_office == 1) {
                $role_id = 6;
    
                $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক)';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
    
                //dd($office_id->id);
                if ($user_info_from_request['role_id'] == 0) {
                    $doptor_user_active = 0;
                } else {
                    $doptor_user_active = 1;
                }
    
                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'role_id' => $role_id,
                    'office_id' => $to_update_office_id->office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $employee_info_from_api['personal_email'],
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => $doptor_user_active,
                    'court_id' => $user_info_from_request['court_id'],
                ];
    
                $updated_users = DB::table('users')
                    ->where('username', '=', $user_info_from_request['username'])
                    ->update($user);
    
                if ($updated_users) {
                    return true;
                }
            } elseif ($updated_office == 0) {
                if ($user_info_from_request['court_id'] == 0) {
                    $doptor_user_active = 0;
                } else {
                    $doptor_user_active = 1;
                }
    
                $role_id = 6;
    
                $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক)';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'role_id' => $role_id,
                    'office_id' => $to_update_office_id->office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $employee_info_from_api['personal_email'],
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => $doptor_user_active,
                    'court_id' => $user_info_from_request['court_id'],
                ];
    
                $updated_users = DB::table('users')
                    ->where('username', '=', $user_info_from_request['username'])
                    ->update($user);
    
                if ($updated_users) {
                    return true;
                }
            }

    }
    
    public static function Ad_Dis_Commissioner_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        
        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;

        $office_unit_organogram_id = 51;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

            'upazila_id' => null,
            'upa_name_bn' => null,
            'upa_name_en' => null,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'district_bbs_code' =>$district_bbs_code,
            'upazila_bbs_code' => null,
        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);
            if ($updated_office == 1) {
                $role_id = 7;
    
                $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা প্রশাসক (রাজস্ব))';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
    
                //dd($office_id->id);
                if ($user_info_from_request['role_id'] == 0) {
                    $doptor_user_active = 0;
                } else {
                    $doptor_user_active = 1;
                }
    
                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'role_id' => $role_id,
                    'office_id' => $to_update_office_id->office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $employee_info_from_api['personal_email'],
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => $doptor_user_active,
                    'court_id' => $user_info_from_request['court_id'],
                ];
    
                $updated_users = DB::table('users')
                    ->where('username', '=', $user_info_from_request['username'])
                    ->update($user);
    
                if ($updated_users) {
                    return true;
                }
            } elseif ($updated_office == 0) {
                if ($user_info_from_request['court_id'] == 0) {
                    $doptor_user_active = 0;
                } else {
                    $doptor_user_active = 1;
                }
    
                $role_id = 7;
    
                $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা প্রশাসক (রাজস্ব))';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'role_id' => $role_id,
                    'office_id' => $to_update_office_id->office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $employee_info_from_api['personal_email'],
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => $doptor_user_active,
                    'court_id' => $user_info_from_request['court_id'],
                ];
    
                $updated_users = DB::table('users')
                    ->where('username', '=', $user_info_from_request['username'])
                    ->update($user);
    
                if ($updated_users) {
                    return true;
                }
            }

    }
    
    public static function GCO_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {

        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
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

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

        ];

        $office_id = Self::OfficeExitsCheck($office_data);

        //$office_id = DB::table('office')->insertGetId($office_data);

        //dd($office_create);
        if (isset($office_id)) {

            $role_id = 27;

            $designation = $user_info_from_request['designation_bng'] . '(জিসিও)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'court_id' => $user_info_from_request['court_id'],
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }

    public static function GCO_DC_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
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

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {

            $role_id = 27;

            $designation = $user_info_from_request['designation_bng'] . '(জিসিও)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }
            
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active'=>0
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        } elseif ($updated_office == 0) {
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }
            

            $role_id = 27;

            $designation = $user_info_from_request['designation_bng'] . '(জিসিও)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active'=>0
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }

    }

    public static function certificate_assistent_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
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

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

        ];

        $office_id = Self::OfficeExitsCheck($office_data);

        //$office_id = DB::table('office')->insertGetId($office_data);

        //dd($office_create);
        if (isset($office_id)) {

            $role_id = 28;

            $designation = $user_info_from_request['designation_bng'] . '(সার্টিফিকেট সহকারি)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'peshkar_active'=>1,
                'court_id' => $user_info_from_request['court_id'],
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }
    public static function certificate_assistent_DC_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
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

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {

            $role_id = 28;

            $designation = $user_info_from_request['designation_bng'] . '(সার্টিফিকেট সহকারি)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
                $peshkar_active=0;
            } else {
                $doptor_user_active = 1;
                $peshkar_active=1;
            }
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active'=>$peshkar_active,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        } elseif ($updated_office == 0) {
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
                $peshkar_active=0;
            } else {
                $doptor_user_active = 1;
                $peshkar_active=1;
            }
            $role_id = 28;

            $designation = $user_info_from_request['designation_bng'] . '(সার্টিফিকেট সহকারি)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active'=>$peshkar_active,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }
 
    }

    
    public static function GCO_UNO_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];
        $geo_upazila_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_upazila_id'];


        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila=self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);


        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $upazila_id = $upazila->id;
        $upa_name_bn = $upazila->upazila_name_bn;
        $upa_name_en = $upazila->upazila_name_en;

        $parent_office_data = DB::table('users')
            ->select('office.id', 'office.office_name_bn')
            ->join('office', 'users.office_id', '=', 'office.id')
            ->where('users.role_id', '=', 6)
            ->where('office.district_id', '=', $district_id)
            ->where('office.division_id', '=', $division_id)
            ->whereNotNull('users.doptor_office_id')
            ->first();

        $office_label = 4;
        $parent = $parent_office_data->id;
        $parent_name = $parent_office_data->office_name_bn;
        $upazila_bbs_code = $upazila->upazila_bbs_code;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],

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

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

        ];

        $office_id = Self::OfficeExitsCheck($office_data);

        if (isset($office_id)) {
            
            $role_id = 27;

            $designation = $user_info_from_request['designation_bng'] . '(জিসিও)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'court_id' => $user_info_from_request['court_id'],
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }

    }
    public static function GCO_UNO_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {

        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];
        $geo_upazila_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_upazila_id'];


        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila=self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);
        
        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $upazila_id = $upazila->id;
        $upa_name_bn = $upazila->upazila_name_bn;
        $upa_name_en = $upazila->upazila_name_en;

        $parent_office_data = DB::table('users')
            ->select('office.id', 'office.office_name_bn')
            ->join('office', 'users.office_id', '=', 'office.id')
            ->where('users.role_id', '=', 6)
            ->where('office.district_id', '=', $district_id)
            ->where('office.division_id', '=', $division_id)
            ->whereNotNull('users.doptor_office_id')
            ->first();

        $office_label = 4;
        $parent = $parent_office_data->id;
        $parent_name = $parent_office_data->office_name_bn;
        $upazila_bbs_code = $upazila->upazila_bbs_code;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],

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

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {
            $role_id = 27;

            $designation = $user_info_from_request['designation_bng'] . '(জিসিও)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active'=>0
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        } elseif ($updated_office == 0) {
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }
            $role_id = 27;

            $designation = $user_info_from_request['designation_bng'] . '(জিসিও)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active'=>0
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }

    }

    public static function certificate_assistent_UNO_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];
        $geo_upazila_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_upazila_id'];


        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila=self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $upazila_id = $upazila->id;
        $upa_name_bn = $upazila->upazila_name_bn;
        $upa_name_en = $upazila->upazila_name_en;

        $parent_office_data = DB::table('users')
            ->select('office.id', 'office.office_name_bn')
            ->join('office', 'users.office_id', '=', 'office.id')
            ->where('users.role_id', '=', 6)
            ->where('office.district_id', '=', $district_id)
            ->where('office.division_id', '=', $division_id)
            ->whereNotNull('users.doptor_office_id')
            ->first();

        $office_label = 4;
        $parent = $parent_office_data->id;
        $parent_name = $parent_office_data->office_name_bn;
        $upazila_bbs_code = $upazila->upazila_bbs_code;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],

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

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

        ];

        $office_id = Self::OfficeExitsCheck($office_data);

        if (isset($office_id)) {
            
            $role_id = 28;

            $designation = $user_info_from_request['designation_bng'] . '(সার্টিফিকেট সহকারি)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'peshkar_active'=>1,
                'court_id' => $user_info_from_request['court_id'],
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }
    public static function certificate_assistent_UNO_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];
        $geo_upazila_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_upazila_id'];


        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila=self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $upazila_id = $upazila->id;
        $upa_name_bn = $upazila->upazila_name_bn;
        $upa_name_en = $upazila->upazila_name_en;

        $parent_office_data = DB::table('users')
            ->select('office.id', 'office.office_name_bn')
            ->join('office', 'users.office_id', '=', 'office.id')
            ->where('users.role_id', '=', 6)
            ->where('office.district_id', '=', $district_id)
            ->where('office.division_id', '=', $division_id)
            ->whereNotNull('users.doptor_office_id')
            ->first();

        $office_label = 4;
        $parent = $parent_office_data->id;
        $parent_name = $parent_office_data->office_name_bn;
        $upazila_bbs_code = $upazila->upazila_bbs_code;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],

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

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {
            $role_id = 28;

            $designation = $user_info_from_request['designation_bng'] . '(সার্টিফিকেট সহকারি)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
                $peshkar_active=0;
            } else {
                $doptor_user_active = 1;
                $peshkar_active=1;
            }
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active'=>$peshkar_active,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        } elseif ($updated_office == 0) {
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
                $peshkar_active=0;
            } else {
                $doptor_user_active = 1;
                $peshkar_active=1;
            }
            $role_id = 28;

            $designation = $user_info_from_request['designation_bng'] . '(সার্টিফিকেট সহকারি)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active'=>$peshkar_active,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }
    }


    
    public static function get_district_from_geo_distcrict_with_district($geo_district_id)
    {
        
        $query = DB::table('district')
            ->join('geo_districts', 'district.district_bbs_code', '=', 'geo_districts.bbs_code')
            ->where('geo_districts.id', '=', $geo_district_id)
            ->select('district.id', 'geo_districts.district_name_bng','district.district_name_en','district.district_bbs_code','district.district_name_bn')
            ->first();

        return $query;
    }

    public static function get_division_from_geo_division_with_division($geo_division_id)
    {
        $query = DB::table('division')
            ->join('geo_divisions', 'division.division_bbs_code', '=', 'geo_divisions.bbs_code')
            ->where('geo_divisions.id', '=', $geo_division_id)
            ->select('division.id', 'geo_divisions.division_name_bng','division.division_name_en','division.division_name_bn')
            ->first();

        return $query;
    }
    public static function get_upazila_from_geo_upazila_with_upazila($geo_upazila_id)
    {
        if($geo_upazila_id == 0)
        {
            return null;
        }
        
       $geo_upazila=DB::table('geo_upazilas')->where('id','=',$geo_upazila_id)->first();

       $district=self::get_district_from_geo_distcrict_with_district($geo_upazila->geo_district_id);
       $division=self::get_division_from_geo_division_with_division($geo_upazila->geo_division_id);

       $upazila=DB::table('upazila')
       ->where('upazila_name_en','=',$geo_upazila->upazila_name_eng)
       ->where('district_id','=',$district->id)
       ->where('division_id','=',$division->id)
       ->first();

       return $upazila;

    }


}
