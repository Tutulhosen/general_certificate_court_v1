<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class NDoptorRepository
{
    public static function DC_create($response, $office_info, $ref_origin_unit_org_id)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $district = self::get_district($office_info);

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

        $office_data = [
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
            'upazila_bbs_code' => null,
            'office_unit_organogram_id' => $ref_origin_unit_org_id,
            'is_gcc' => 1,
            'is_organization' => 0,
            'status' => 1,

        ];

        $office_id = self::OfficeExitsCheck($office_data);

        //dd($office_create);
        if (isset($office_id)) {

            $role_id = 6;
            $designation = $office_info->designation;
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);

            $court_id = DB::table('court')->where('district_id', '=', $district_id)->where('division_id', '=', $division_id)
                ->where('level', '=', 1)->first();

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
                'doptor_office_id' => $office_info->office_id,
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'court_id' => $court_id->id,
            ];
        }
        $user_create = DB::table('users')->insert($user);

        return $user_create;
    }

    public static function Divisional_Commissioner_create($response, $office_info, $ref_origin_unit_org_id)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $district_id = null;
        $dis_name_bn = null;
        $dis_name_en = null;
        $district_bbs_code = null;
        $upazila_bbs_code = null;

        $division = self::get_division($office_info);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $office_data = [
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

        ];

        $office_id = self::OfficeExitsCheck($office_data);

        //dd($office_create);
        if (isset($office_id)) {

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
                'doptor_office_id' => $office_info->office_id,
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
            ];
        }
        $user_create = DB::table('users')->insert($user);

        return $user_create;
    }

    public static function get_district($office_info)
    {
        $get_token_response = Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->post(doptor_endpoint().'/api/client/login', [
                'client_id' => doptor_client_id(),
                'username' => 200000001311,
                'password' => doptor_password(),
            ])
            ->throw()
            ->json();

        //dd($get_token_response);

        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];

            //$office_list_endpoint='/'.;

            $get_office_response = Http::withHeaders([
                'api-version' => 1,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}",
            ])
                ->post(doptor_endpoint().'/api/offices', [
                    'office_ids' => $office_info->office_id,
                    'type' => 'both',
                ])
                ->throw()
                ->json();

            // if ($get_office_response['status'] == 'success') {
            //     $get_office_response['data'][$office_info->office_id]['geo_district_id']
            // }

            if ($get_office_response['status'] == 'success') {
                $district_from_geo = DB::table('geo_districts')
                    ->where('id', '=', $get_office_response['data'][$office_info->office_id]['geo_district_id'])
                    ->first();

                $district = DB::table('district')
                    ->where('district_name_en', $district_from_geo->district_name_eng)
                    ->select('id', 'district_name_bn', 'district_name_en', 'division_bbs_code', 'district_bbs_code')
                    ->first();

                return $district;
            }
        }
    }
    public static function get_division($office_info)
    {
        $get_token_response = Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->post(doptor_endpoint().'/api/client/login', [
                'client_id' => doptor_client_id(),
                'username' => 200000001311,
                'password' => doptor_password(),
            ])
            ->throw()
            ->json();

        //dd($get_token_response);

        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];

            //$office_list_endpoint='/'.;

            $get_office_response = Http::withHeaders([
                'api-version' => 1,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}",
            ])
                ->post(doptor_endpoint().'/api/offices', [
                    'office_ids' => $office_info->office_id,
                    'type' => 'both',
                ])
                ->throw()
                ->json();

            if ($get_office_response['status'] == 'success') {
                $division_from_geo = DB::table('geo_divisions')
                    ->where('id', '=', $get_office_response['data'][$office_info->office_id]['geo_division_id'])
                    ->first();

                $division = DB::table('division')
                    ->where('division_name_en', $division_from_geo->division_name_eng)
                    ->first();

                return $division;
            }
        }
    }

    public static function verifyGCO($data)
    {
        if ($data[0]['office_id'] != globalUserInfo()->doptor_office_id) {
            //return $data;

            $list_of_UNO = [];

            foreach ($data as $value) {
                if (str_contains($value['designation_eng'], 'UNO Officer')) {

                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();

                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                    } else {
                        $value['court_id'] = null;
                    }

                    array_push($list_of_UNO, $value);
                } else if (str_contains($value['designation_eng'], 'UNO')) {
                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();

                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                    } else {
                        $value['court_id'] = null;
                    }

                    array_push($list_of_UNO, $value);
                } else if (str_contains($value['designation_eng'], 'Uno')) {
                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();

                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                    } else {
                        $value['court_id'] = null;
                    }

                    array_push($list_of_UNO, $value);
                }

            }

            return json_encode([
                'list_of_UNO_flag' => 1,
                'list_of_UNO' => $list_of_UNO,
            ]);
        } else {
            $list_of_GCO_DC_office = [];

            foreach ($data as $value) {
                if (str_contains($value['unit_name_en'], 'Certificate') && str_contains($value['designation_eng'], 'GCO')) {

                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();

                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                    } else {
                        $value['court_id'] = null;
                    }
                    array_push($list_of_GCO_DC_office, $value);
                } else if (str_contains($value['unit_name_en'], 'certificate') && str_contains($value['designation_eng'], 'gco')) {

                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();

                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                    } else {
                        $value['court_id'] = null;
                    }
                    array_push($list_of_GCO_DC_office, $value);
                }
            }

            return json_encode([
                'list_of_GCO_DC_office_flag' => 1,
                'list_of_GCO_DC_office' => $list_of_GCO_DC_office,
            ]);
        }
    }
    public static function courtlist_district()
    {
        $office = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        //district_id
        //status
        $query = DB::table('court');
        $query->where('level', '=', 1);
        if (!empty($office->district_id)) {
            $query->where('district_id', '=', $office->district_id);
        }
        if (!empty($office->division_id)) {
            $query->where('division_id', '=', $office->division_id);
        }
        $court = $query->get();

        return $court;

        //$courtlist=DB::table('court')
    }

    public static function courtlist_upazila()
    {
        $office = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        //district_id
        //status
        $query = DB::table('court');
        $query->where('level', '=', 0);
        if (!empty($office->district_id)) {
            $query->where('district_id', '=', $office->district_id);
        }
        if (!empty($office->division_id)) {
            $query->where('division_id', '=', $office->division_id);
        }
        $court = $query->get();

        return $court;
    }

    public static function GCO_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

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

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

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
                'peshkar_active' => 0,
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
                'peshkar_active' => 0,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }

    }

    public static function ADC_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

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

            $role_id = 7;

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
    public static function ADC_DC_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {

        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

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

            $role_id = 7;

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
                'peshkar_active' => 0,
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
                'peshkar_active' => 0,
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

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila = self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);

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

        // $office_id = DB::table('office')->insertGetId($office_data);

        //dd($office_create);
        if (isset($office_id)) {
            //dd('sdbds');
            // $office_id = DB::table('office')
            //     ->orderBy('id', 'desc')
            //     ->first();
            //dd($office_id);

            $role_id = 27;

            $designation = $user_info_from_request['designation_bng'] . '(জিসিও)';
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

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila = self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);

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
                'peshkar_active' => 0,
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
                'peshkar_active' => 0,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }

    }

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
    public static function getAllOffice($token)
    {
        return Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$token}",
        ])
            ->post(doptor_endpoint().'/api/offices/relation-offices', [
                'office_ids' => globalUserInfo()->doptor_office_id,
                'type' => 'both',
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

    public static function signature()
    {
        // if(globalUserInfo()->doptor_user_flag == 1)
        // {
        //     $username=globalUserInfo()->username;
        //     $token=self::getToken($username);
        //     //dd($token) ;
        //     if($token['status'] == 'success')
        //     {
        //         $parse_token=$token['data']['token'];
        //         $signature= Http::withHeaders([
        //              'api-version' => 1,
        //              'Content-Type' => 'application/json',
        //              'Accept' => 'application/json',
        //              'Authorization' => "Bearer {$parse_token}",
        //          ])
        //              ->post(DOPTOR_ENDPOINT().'/api/user/signatures/', [
        //                  'usernames' => $username,
        //                  'encode' => 'base64',
        //              ])
        //              ->throw()
        //              ->json();

        //              //dd($signature);

        //              if($signature['status']=='success')
        //              {
        //                 DB::table('users')
        //                 ->where('username','=',$username)
        //                 ->update(['signature'=>$signature['data'][0]['signature']]);

        //              }
        //     }

        // }

        if (globalUserInfo()->doptor_user_flag == 1) {
            $username = globalUserInfo()->username;
            $token = self::getToken($username);
            //dd($token) ;
            if ($token['status'] == 'success') {
                $parse_token = $token['data']['token'];
                $signature = Http::withHeaders([
                    'api-version' => 1,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer {$parse_token}",
                ])
                    ->post(DOPTOR_ENDPOINT().'/api/user/signatures/', [
                        'usernames' => $username,
                        'encode' => '1',
                    ])
                    ->throw()
                    ->json();

                if ($signature['status'] == 'error') {
                    $signature_with_url = Http::withHeaders([
                        'api-version' => 1,
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => "Bearer {$parse_token}",
                    ])
                        ->post(DOPTOR_ENDPOINT().'/api/user/signatures/', [
                            'usernames' => $username,
                            'encode' => 'base64',
                        ])
                        ->throw()
                        ->json();

                    //dd($signature);

                    if ($signature_with_url['status'] == 'success') {
                        DB::table('users')
                            ->where('username', '=', $username)
                            ->update(['signature' => $signature_with_url['data'][0]['signature']]);

                    }
                } else {
                    $doptor_image_photo = $signature['data'][0]['signature'];

                    if (!empty($doptor_image_photo)) {
                        $base64_str = substr($doptor_image_photo, strpos($doptor_image_photo, ',') + 1);

                        $extension = isset(explode('/', explode(';', $doptor_image_photo)[0])[1]) ? explode('/', explode(';', $doptor_image_photo)[0])[1]:explode('/', explode(';', $doptor_image_photo)[1])[1];

                        $image_data = base64_decode($base64_str); // decode the image

                        //dd($image_data);

                        $imageName = 'Doptor_' . $signature['data'][0]['username'] . '.' . $extension;
                        $upload_path = '/uploads/signature/';
                        file_put_contents(public_path() . $upload_path . $imageName, $image_data);
                        $singnature_path = '/uploads/signature/' . $imageName;

                        DB::table('users')
                            ->where('username', '=', $username)
                            ->update(['signature' => $singnature_path]);
                    }
                }

            }

        }

    }

    public static function profilePicture()
    {
        if (globalUserInfo()->doptor_user_flag == 1) {
            $username = globalUserInfo()->username;
            $token = self::getToken($username);
            //dd($token) ;

            $currentdesk = self::current_desk($username);

            if ($currentdesk['status'] == 'success') {
                $employee_record_ids = $currentdesk['data']['employee_info']['id'];
            }

            if ($token['status'] == 'success') {
                $parse_token = $token['data']['token'];
                $profile_pic = Http::withHeaders([
                    'api-version' => 1,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer {$parse_token}",
                ])
                    ->post(DOPTOR_ENDPOINT().'/api/user/images/', [
                        'employee_record_ids' => $employee_record_ids,
                        'encode' => 'base64',
                    ])
                    ->throw()
                    ->json();

                //dd($signature);

                if ($profile_pic['status'] == 'success') {
                    DB::table('users')
                        ->where('username', '=', $username)
                        ->update(['profile_pic' => $profile_pic['data'][0]['image']]);

                }
            }

        }

    }

    public static function all_user_list_from_doptor_segmented($data)
    {
        $list_of_UNO = [];
        $list_of_GCO_DC_office = [];
        $list_of_others = [];

        foreach ($data as $value) {
            if (str_contains($value['designation_eng'], 'UNO Officer')) {

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

                array_push($list_of_UNO, $value);

            } else if (str_contains($value['designation_eng'], 'UNO')) {
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

                array_push($list_of_UNO, $value);
            } else if (str_contains($value['designation_eng'], 'Uno')) {
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

                array_push($list_of_UNO, $value);
            } else if (str_contains($value['unit_name_en'], 'Certificate') && str_contains($value['designation_eng'], 'GCO')) {

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
                array_push($list_of_GCO_DC_office, $value);
            } else if (str_contains($value['unit_name_en'], 'certificate') && str_contains($value['designation_eng'], 'gco')) {

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
                array_push($list_of_GCO_DC_office, $value);
            } else {

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
                array_push($list_of_others, $value);
            }

        }

        //dd($list_of_others);

        return json_encode([
            'list_of_UNO' => $list_of_UNO,
            'list_of_GCO_DC_office' => $list_of_GCO_DC_office,
            'list_of_others' => $list_of_others,

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
        if (globalUserInfo()->role_id == 6) {
            return DB::table('role')->whereIn('id', [27, 28, 7])->get();
          
        } elseif (globalUserInfo()->role_id == 7) {
            return DB::table('role')->whereIn('id', [27, 28])->get();
        } elseif (globalUserInfo()->role_id == 27) {
            return DB::table('role')->whereIn('id', [28])->get();
        }
        

    }
    public static function rolelist_upazila()
    {
        return DB::table('role')->whereIn('id', [27, 28])->get();
    }
    
    public static function certificate_assistent_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

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
                'peshkar_active' => 1,
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

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

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
                $peshkar_active = 0;
            } else {
                $doptor_user_active = 1;
                $peshkar_active = 1;
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
                'peshkar_active' => $peshkar_active,
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
                $peshkar_active = 0;
            } else {
                $doptor_user_active = 1;
                $peshkar_active = 1;
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
                'peshkar_active' => $peshkar_active,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }

    }



    public function certificate_assistent_UNO_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];
        $geo_upazila_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_upazila_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila = self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);

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

        // $office_id = DB::table('office')->insertGetId($office_data);

        //dd($office_create);
        if (isset($office_id)) {
            //dd('sdbds');
            // $office_id = DB::table('office')
            //     ->orderBy('id', 'desc')
            //     ->first();
            //dd($office_id);

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
                'peshkar_active' => 1,
                'court_id' => $user_info_from_request['court_id'],
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }
    public function certificate_assistent_UNO_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];
        $geo_upazila_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_upazila_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila = self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);

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
                $peshkar_active = 0;
            } else {
                $doptor_user_active = 1;
                $peshkar_active = 1;
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
                'peshkar_active' => $peshkar_active,
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
                $peshkar_active = 0;
            } else {
                $doptor_user_active = 1;
                $peshkar_active = 1;
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
                'peshkar_active' => $peshkar_active,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }
    }

    public static function search_revisions($dataArray, $search_value, $key_to_search, $other_matching_value = null, $other_matching_key = null)
    {
        // This function will search the revisions for a certain value
        // related to the associative key you are looking for.
        $keys = array();
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

    public static function getAllOfficeBangladesh($token, $lavel)
    {
        return Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$token}",
        ])
            ->post(doptor_endpoint().'/api/offices/relation-offices', [
                'office_ids' => $lavel,
                'type' => 'both',
            ])
            ->throw()
            ->json();
    }

    public static function get_district_from_geo_distcrict_with_district($geo_district_id)
    {

        $query = DB::table('district')
            ->join('geo_districts', 'district.district_bbs_code', '=', 'geo_districts.bbs_code')
            ->where('geo_districts.id', '=', $geo_district_id)
            ->select('district.id', 'geo_districts.district_name_bng', 'district.district_name_en', 'district.district_bbs_code', 'district.district_name_bn')
            ->first();

        return $query;
    }

    public static function get_division_from_geo_division_with_division($geo_division_id)
    {
        $query = DB::table('division')
            ->join('geo_divisions', 'division.division_bbs_code', '=', 'geo_divisions.bbs_code')
            ->where('geo_divisions.id', '=', $geo_division_id)
            ->select('division.id', 'geo_divisions.division_name_bng', 'division.division_name_en', 'division.division_name_bn')
            ->first();

        return $query;
    }
    public static function get_upazila_from_geo_upazila_with_upazila($geo_upazila_id)
    {
        $geo_upazila = DB::table('geo_upazilas')->where('id', '=', $geo_upazila_id)->first();

        $district = self::get_district_from_geo_distcrict_with_district($geo_upazila->geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_upazila->geo_division_id);

        $upazila = DB::table('upazila')
            ->where('upazila_name_en', '=', $geo_upazila->upazila_name_eng)
            ->where('district_id', '=', $district->id)
            ->where('division_id', '=', $division->id)
            ->first();

        return $upazila;

    }
    public static function verifyDoptorUser($username, $password)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => doptor_endpoint().'/api/user/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => ['username' => $username, 'password' => $password],
            CURLOPT_HTTPHEADER => ['api-version: 1'],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }
    public static function verifyCurrentDesk($username)
    {
        if(empty($username)){
            return ['status'=>false,'role_id'=>null];
        }else
        {
            $data=self::current_desk($username);
           
            if($data['status']!="success")
            {
                return ['status'=>false,'role_id'=>null,'level'=>null];  
            }else
            {
                
                $find_by_username=DB::table('users')->where('username',$username)->first();
                // dd($data['data']['office_info'][0]['office_id']);
                if(!empty($find_by_username))
                {
                    if ($find_by_username->username=='200000093169' || $find_by_username->username=='200000033050') {
                        return ['status'=>false,'role_id'=>null,'level'=>null];
                    }
                    if($find_by_username->doptor_office_id !=$data['data']['office_info'][0]['office_id'])
                    {
                        if($find_by_username->role_id != 28)
                        {
                            return ['status'=>true,'role_id'=>$find_by_username->role_id,'level'=>null];  

                        }else
                        {
                            $office=DB::table('office')->where('id','=',$find_by_username->office_id)->first();

                            return ['status'=>true,'role_id'=>$find_by_username->role_id,'level'=>$office->level];  
                        }
                    }else
                    {
                        return ['status'=>false,'role_id'=>null,'level'=>null]; 
                    }
                }else
                {
                    return ['status'=>false,'role_id'=>null,'level'=>null];   
                }
                
            }
        }

    }
}
