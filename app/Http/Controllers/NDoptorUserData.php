<?php

namespace App\Http\Controllers;

use App\Repositories\NDoptorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class NDoptorUserData extends Controller
{
    public function index(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => doptor_endpoint().'/api/user/current_desk',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => ['username' => $request->nothiID],
            CURLOPT_HTTPHEADER => ['api-version: 1'],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        $response2 = json_decode($response, true);

        //var_dump($response2);
        if ($response2['status'] == 'success') {
            return response()->json([
                'success' => 'success',
                'investigatorName' => $response2['data']['employee_info']['name_bng'],
                'investigatorInstituteName' => $response2['data']['office_info'][0]['office_name_bn'],
                'investigatorMobile' => $response2['data']['employee_info']['personal_mobile'],
                'investigatorEmail' => $response2['data']['employee_info']['personal_email'],
                'investigatorDesignation' => $response2['data']['office_info'][0]['designation'],
            ]);
        } else {
            return response()->json([
                'error' => 'error',
            ]);
        }
    }

    public function peshkar_doptor_check(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => doptor_endpoint().'/api/user/current_desk',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => ['username' => $request->nothiID],
            CURLOPT_HTTPHEADER => ['api-version: 1'],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        $response2 = json_decode($response, true);

        //var_dump($response2);
        if ($response2['status'] == 'success') {
            if (isset($response2['data']['office_info'][0]['designation'])) {
                $designation = $response2['data']['office_info'][0]['designation'];
            } else {
                $designation = ' ';
            }
            if (isset($response2['data']['office_info'][0]['office_name_bn'])) {
                $office_name = $response2['data']['office_info'][0]['office_name_bn'];
            } else {
                $office_name = ' ';
            }

            return response()->json([
                'success' => 'success',
                'username' => $response2['data']['user']['username'],
                'name' => $response2['data']['employee_info']['name_bng'],
                'office_name' => $office_name,
                'mobile_no' => $response2['data']['employee_info']['personal_mobile'],
                'email' => $response2['data']['employee_info']['personal_email'],
                'designation_nothi' => $designation,
            ]);
        } else {
            return response()->json([
                'error' => 'error',
            ]);
        }
    }

    public function office_list()
    {
        if (is_int(globalUserInfo()->username)) {
            $username = globalUserInfo()->username;
        } else {
            $username = 200000001311;
        }

        $get_token_response = NDoptorRepository::getToken($username);

        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];

            //$office_list_endpoint='/'.;

            $get_all_office_response = NDoptorRepository::getAllOffice($token);

            //dd($get_all_office_response );

            if ($get_all_office_response['status'] == 'error') {
                return redirect('/doptor/user/check')->with('success', 'you are not Doptor User');
            }

            $all_offices_related_DC = $get_all_office_response['data'][globalUserInfo()->doptor_office_id];

            $all_DC_UNO_office = [];
            foreach ($all_offices_related_DC as $value) {
                if ($value['office_layer_id'] == 22 && $value['office_origin_id'] == 16) {
                    array_push($all_DC_UNO_office, $value);
                }
                if ($value['office_layer_id'] == 23 && $value['office_origin_id'] == 17) {
                    array_push($all_DC_UNO_office, $value);
                }
            }
            //dd($all_DC_UNO_office);

            $data['page_title'] = 'জেনারেল সার্টিফিকেট আদালতের ইউজার ম্যানেজমেন্ট,  অফিস নির্বাচন';

            $data['all_DC_UNO_office'] = $all_DC_UNO_office;

            //dd($data);

            return view('doptor.office_list')->with($data);
        }
    }
    public function user_list($office_id)
    {
        //dd($office_id);

        $office_id = decrypt($office_id);

        $username = globalUserInfo()->username;
        $get_token_response = NDoptorRepository::getToken($username);

        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];

            $response_after_decode = NDoptorRepository::get_employee_list_by_office($token, $office_id);

            if ($response_after_decode['status'] == 'success') {
                $user_list = NDoptorRepository::verifyGCO($response_after_decode['data']);

                $json_decode_user_list = json_decode($user_list, true);

                $available_court = NDoptorRepository::courtlist_district();

                //dd($available_court);

                if (array_key_exists('list_of_GCO_DC_office_flag', $json_decode_user_list)) {
                    $data['page_title'] = 'জেনারেল সার্টিফিকেট আদালতের ইউজার ম্যানেজমেন্ট,  জেনারেল সার্টিফিকেট অফিসার নির্বাচন';

                    $data['list_of_GCO_DC_office'] = $json_decode_user_list['list_of_GCO_DC_office'];

                    //dd($json_decode_user_list['list_of_ADC']);
                    $data['office_id'] = $office_id;
                    $data['available_court'] = $available_court;

                    return view('doptor.user_list_gco')->with($data);
                } elseif (array_key_exists('list_of_UNO_flag', $json_decode_user_list)) {
                    $data['page_title'] = 'জেনারেল সার্টিফিকেট আদালতের ইউজার ম্যানেজমেন্ট,  উপজেলা নির্বাহী অফিসার (জেনারেল সার্টিফিকেট অফিসার)';
                    $data['office_id'] = $office_id;
                    $data['list_of_UNO'] = $json_decode_user_list['list_of_UNO'];
                    $available_court = NDoptorRepository::courtlist_upazila();
                    $data['available_court'] = $available_court;
                    return view('doptor.user_list_uno')->with($data);
                }

                //dd($data);
            }
        }
    }

    public function user_store_gco_dc(Request $request)
    {
        $get_current_desk = NDoptorRepository::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                //var_dump('g');
                //exit();
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    $username_DC = globalUserInfo()->username;
                    $get_token_response = NDoptorRepository::getToken($username_DC);
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepository::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepository::GCO_DC_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {
                                $court = NDoptorRepository::courtlist_district();
                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    $username_DC = globalUserInfo()->username;
                    $get_token_response = NDoptorRepository::getToken($username_DC);
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepository::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepository::GCO_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {
                            $court = NDoptorRepository::courtlist_district();
                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function user_store_gco_uno(Request $request)
    {
        $get_current_desk = NDoptorRepository::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                //var_dump('g');
                //exit();
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    $username_DC = globalUserInfo()->username;
                    $get_token_response = NDoptorRepository::getToken($username_DC);
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepository::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepository::GCO_UNO_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {
                                $court = NDoptorRepository::courtlist_upazila();
                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    $username_DC = globalUserInfo()->username;
                    $get_token_response = NDoptorRepository::getToken($username_DC);
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepository::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepository::GCO_UNO_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {
                            $court = NDoptorRepository::courtlist_upazila();
                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function doptor_user_check()
    {
        return view('doptor.not_doptor_user');
    }

    public function all_user_list_from_doptor_segmented($office_id)
    {
        
        //dd($office_id);
        $office_id = decrypt($office_id);

        $username = globalUserInfo()->username;
        $get_token_response = NDoptorRepository::getToken($username);

        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];

            $response_after_decode = NDoptorRepository::get_employee_list_by_office($token, $office_id);

            if ($response_after_decode['status'] == 'success') {
                $everything = NDoptorRepository::all_user_list_from_doptor_segmented($response_after_decode['data']);

                $list_of_others = json_decode($everything, true)['list_of_others'];

                if ($office_id == globalUserInfo()->doptor_office_id) {
                    $data['page_title'] = 'জেনারেল সার্টিফিকেট আদালতের ইউজার ম্যানেজমেন্ট,  জেলা প্রশাসক এর সকল অফিসার নির্বাচন';
                    $data['list_of_GCO_DC_office'] = $list_of_others;
                    $data['office_id'] = $office_id;
                    $data['available_court'] = NDoptorRepository::courtlist_district();
                    $data['available_role'] = NDoptorRepository::rolelist_district();

                    return view('doptor.user_list_gco_others')->with($data);
                } else {
                    $data['page_title'] = 'জেনারেল সার্টিফিকেট আদালতের ইউজার ম্যানেজমেন্ট,  উপজেলা নির্বাহী অফিসার এর সকল অফিসার নির্বাচন';
                    $data['office_id'] = $office_id;
                    $data['list_of_UNO'] = $list_of_others;
                    $data['available_court'] = NDoptorRepository::courtlist_upazila();
                    $data['available_role'] = NDoptorRepository::rolelist_upazila();
                    return view('doptor.user_list_uno_others')->with($data);
                }
            }
        }
    }
    public function all_user_list_from_doptor_segmented_search($office_id, Request $request)
    {
        //dd($request->search_key);

        $office_id = decrypt($office_id);

        $list_of_others_fianl=[];

        $username = globalUserInfo()->username;
        $get_token_response = NDoptorRepository::getToken($username);

        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];

            $response_after_decode = NDoptorRepository::get_employee_list_by_office($token, $office_id);

            if ($response_after_decode['status'] == 'success') {
                if ($office_id == globalUserInfo()->doptor_office_id) {
                    $data['page_title'] = 'জেনারেল সার্টিফিকেট আদালতের ইউজার ম্যানেজমেন্ট,  জেলা প্রশাসক এর সকল অফিসার নির্বাচন';
                    $data['office_id'] = $office_id;
                    $data['available_court'] = NDoptorRepository::courtlist_district();
                    $data['available_role'] = NDoptorRepository::rolelist_district();

                    $search_keys = ['username', 'designation_bng', 'designation_eng', 'unit_name_en', 'unit_name_bn', 'employee_name_bng', 'employee_name_eng'];

                    $everything = NDoptorRepository::all_user_list_from_doptor_segmented_search($response_after_decode['data']);

                    $list_of_all = json_decode($everything, true)['list_of_all'];


                    foreach ($search_keys as $value) {
                        
                        $search_by_key = NDoptorRepository::search_revisions($list_of_all, $request->search_key, $value);

                        if (!empty($search_by_key)) {

                             $list_of_others=[];

                            foreach($search_by_key  as $list)
                            {
                                array_push($list_of_others,$list_of_all[$list]);

                            }
                            $list_of_others_fianl=$list_of_others;
                            break;
                        }
                    }



                    $data['list_of_GCO_DC_office'] = $list_of_others_fianl;

                    return view('doptor.user_list_gco_others')->with($data);
                    
                } else {
                    $data['page_title'] = 'জেনারেল সার্টিফিকেট আদালতের ইউজার ম্যানেজমেন্ট,  উপজেলা নির্বাহী অফিসার এর সকল অফিসার নির্বাচন';
                    $data['office_id'] = $office_id;

                    $data['available_court'] = NDoptorRepository::courtlist_upazila();
                    $data['available_role'] = NDoptorRepository::rolelist_upazila();
                    $search_keys = ['username', 'designation_bng', 'designation_eng', 'unit_name_en', 'unit_name_bn', 'employee_name_bng', 'employee_name_eng'];

                    $everything = NDoptorRepository::all_user_list_from_doptor_segmented_search($response_after_decode['data']);

                    $list_of_all = json_decode($everything, true)['list_of_all'];  
                    foreach ($search_keys as $value) {
                        
                        $search_by_key = NDoptorRepository::search_revisions($list_of_all, $request->search_key, $value);

                        if (!empty($search_by_key)) {

                             $list_of_others=[];

                            foreach($search_by_key  as $list)
                            {
                                array_push($list_of_others,$list_of_all[$list]);

                            }
                            $list_of_others_fianl=$list_of_others;
                            break;
                        }
                    }
                    $data['list_of_UNO'] = $list_of_others_fianl;

                    return view('doptor.user_list_uno_others')->with($data);

                }
            }
        }
    }


     //ADMIN PANEL IMPORTANT //



    public function import_doptor_office(Request $request)
    {
        $username = 100000006515;

        $office_lavel = $request->office_lavel;

        if ($office_lavel == 2) {
            $get_token_response = NDoptorRepository::getToken($username);
            $token = $get_token_response['data']['token'];
            $get_all_office_response = NDoptorRepository::getAllOfficeBangladesh($token, 8);

            $Ministry_of_Public_Administration = $get_all_office_response['data'][8];

            foreach ($Ministry_of_Public_Administration as $value) {
                if ($value['office_layer_id'] == 21 && $value['office_origin_id'] == 15) {
                    $exits = DB::table('doptor_offices')
                        ->where('office_id', '=', $value['id'])
                        ->first();
                    $office_data = [
                        'office_id' => $value['id'],
                        'office_name_bng'=>$value['office_name_bng'],
                        'office_origin_id' => $value['office_origin_id'],
                        'office_layer_id' => $value['office_layer_id'],
                        'geo_division_id' => $value['geo_division_id'],
                        'geo_district_id' => $value['geo_district_id'],
                        'geo_upazila_id' => $value['geo_upazila_id'],
                    ];
                    if (empty($exits)) {
                        DB::table('doptor_offices')->insert($office_data);
                    } else {
                        DB::table('doptor_offices')
                            ->where('geo_division_id', '=', $value['geo_division_id'])
                            ->where('geo_district_id', '=', $value['geo_district_id'])
                            ->where('geo_upazila_id', '=', $value['geo_upazila_id'])
                            ->update($office_data);
                    }
                }
            }
            return response()->json([
                'success'=>'success'
                ]);
        } elseif ($office_lavel == 3) {
            $divisional_offices = DB::table('doptor_offices')
                ->where('office_layer_id', '=', 21)
                ->where('office_origin_id', '=', 15)
                ->get();

            $get_token_response = NDoptorRepository::getToken($username);
            $token = $get_token_response['data']['token'];

            foreach ($divisional_offices as $divisional_office) {
                $get_all_office_response = NDoptorRepository::getAllOfficeBangladesh($token, $divisional_office->office_id);

                $divisional_office_api = $get_all_office_response['data'][$divisional_office->office_id];
                foreach ($divisional_office_api as $value) {
                    if ($value['office_layer_id'] == 22 && $value['office_origin_id'] == 16) {
                        $exits = DB::table('doptor_offices')
                            ->where('office_id', '=', $value['id'])
                            ->first();
                        $office_data = [
                            'office_id' => $value['id'],
                            'office_origin_id' => $value['office_origin_id'],
                            'office_name_bng'=>$value['office_name_bng'],
                            'office_layer_id' => $value['office_layer_id'],
                            'geo_division_id' => $value['geo_division_id'],
                            'geo_district_id' => $value['geo_district_id'],
                            'geo_upazila_id' => $value['geo_upazila_id'],
                        ];
                        if (empty($exits)) {
                            DB::table('doptor_offices')->insert($office_data);
                        } else {
                            DB::table('doptor_offices')
                            ->where('geo_division_id', '=', $value['geo_division_id'])
                            ->where('geo_district_id', '=', $value['geo_district_id'])
                            ->where('geo_upazila_id', '=', $value['geo_upazila_id'])
                            ->update($office_data);
                        }
                    }
                }
            }
            return response()->json([
                'success'=>'success'
                ]);
        }
        else if($office_lavel == 4)
        {
            $district_offices = DB::table('doptor_offices')
                ->where('office_layer_id', '=', 22)
                ->where('office_origin_id', '=', 16)
                ->get();

            $get_token_response = NDoptorRepository::getToken($username);
            $token = $get_token_response['data']['token'];

            foreach ($district_offices as $district_office) {
                $get_all_office_response = NDoptorRepository::getAllOfficeBangladesh($token, $district_office->office_id);

                $district_office_api = $get_all_office_response['data'][$district_office->office_id];
                foreach ($district_office_api as $value) {
                    if ($value['office_layer_id'] == 23 && $value['office_origin_id'] == 17) {
                        $exits = DB::table('doptor_offices')
                            ->where('office_id', '=', $value['id'])
                            ->first();
                        $office_data = [
                            'office_id' => $value['id'],
                            'office_name_bng'=>$value['office_name_bng'],
                            'office_origin_id' => $value['office_origin_id'],
                            'office_layer_id' => $value['office_layer_id'],
                            'geo_division_id' => $value['geo_division_id'],
                            'geo_district_id' => $value['geo_district_id'],
                            'geo_upazila_id' => $value['geo_upazila_id'],
                        ];
                        if (empty($exits)) {
                            DB::table('doptor_offices')->insert($office_data);
                        } else {
                            DB::table('doptor_offices')
                            ->where('office_id', '=', $value['id'])
                            ->update($office_data);
                        }
                    }
                }
            }
            return response()->json([
                'success'=>'success',
                'message'=>'সফলভাবে লোড হয়েছে'
                ]);
        }
        return response()->json([
        'success'=>'error',
        'message'=>''
        ]);
    }

   
    
    public function getDependentDistrictForDoptor($id)
    {
        $subcategories = DB::table("geo_districts")->where("geo_division_id",$id)->pluck("district_name_bng","id");
        return json_encode($subcategories);
    }

    public function getDependentUpazilaForDoptor($id)
    {
        $subcategories = DB::table("geo_upazilas")->where("geo_district_id",$id)->pluck("upazila_name_bng","id");
        return json_encode($subcategories);
    }

    public function imported_doptor_office_search(Request $request)
    {
        $data['page_title'] = 'জেনারেল সার্টিফিকেট আদালতের ইউজার ম্যানেজমেন্ট,  অফিস নির্বাচন';

        $query=DB::table('doptor_offices')
        ->select('geo_divisions.division_name_bng','geo_districts.district_name_bng','geo_upazilas.upazila_name_bng','doptor_offices.office_name_bng','doptor_offices.office_id')
        ->leftjoin('geo_divisions','doptor_offices.geo_division_id','=','geo_divisions.id')
        ->leftjoin('geo_districts','doptor_offices.geo_district_id','=','geo_districts.id')
        ->leftjoin('geo_upazilas','doptor_offices.geo_upazila_id','=','geo_upazilas.id');          
        if (!empty($request->division)) {

            $query->where('geo_divisions.id', $request->division);
        }
        if(!empty($request->district))
        {
            $query->where('geo_districts.id', $request->district);
        }
        if(!empty($request->upazila))
        {
            $query->where('geo_upazilas.id', $request->upazila);
        }
        $all_office_bangladesh=$query->paginate(50);
        $data['divisions'] = DB::table('geo_divisions')->get();   

                                                
      $data['all_office_bangladesh'] = $all_office_bangladesh;

        return view('doptor.office_list_admin_all')->with($data);
    }

}
