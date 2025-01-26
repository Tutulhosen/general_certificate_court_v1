<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\NDoptorRepository;
use App\Repositories\NDoptorRepositoryAdmin;

class CertificateAssistentManageController extends Controller
{
    //
    public function certificate_assistent_create_form()
    {
        
        $office = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $available_court_picker = DB::table('court')
            ->where('id', '=', globalUserInfo()->court_id)
            ->get();

        //dd($available_court_picker);

        $data['office'] = $office;

        if (globalUserInfo()->doptor_user_flag == 1) {
            $username = globalUserInfo()->username;
            $get_token_response = NDoptorRepository::getToken($username);

            if ($get_token_response['status'] == 'success') {
                $token = $get_token_response['data']['token'];

                $response_after_decode = NDoptorRepository::get_employee_list_by_office($token, globalUserInfo()->doptor_office_id);

                if ($response_after_decode['status'] == 'success') {

                    $everything = NDoptorRepository::all_user_list_from_doptor_segmented($response_after_decode['data']);

                    $list_of_others = json_decode($everything, true)['list_of_others'];

                }
            }

        }
        else
        {

            return redirect('/doptor/user/check')->with('success', 'you are not Doptor User');
        }

        if (globalUserInfo()->role_id == 27) {
          
            if ($office->level == 4) {
                $data['available_court_picker'] = $available_court_picker;
                $data['page_title'] = 'সার্টিফিকেট সহকারী ( জেনারেল সার্টিফিকেট অফিসার ,উপজেলা নির্বাহী অফিসারের কার্যালয় এর জন্য ) তৈরি করুন';
                $data['available_court'] = NDoptorRepository::courtlist_upazila();
                $data['available_role'] = NDoptorRepository::rolelist_upazila();
                $data['list_of_others'] = $list_of_others;
                $data['level'] = 4;
            }
            if ($office->level == 3) {

                $data['available_court_picker'] = $available_court_picker;
                $data['page_title'] = 'সার্টিফিকেট সহকারী ( জেনারেল সার্টিফিকেট অফিসার ,জেলা প্রশাসকের কার্যালয় এর জন্য) তৈরি করুন';
                $data['list_of_others'] = $list_of_others;
                $data['available_court'] = NDoptorRepository::courtlist_district();
                $data['available_role'] = NDoptorRepository::rolelist_district();
                
                $data['level'] = 3;
            }
        } elseif (globalUserInfo()->role_id == 6) {

            $data['available_court_picker'] = $available_court_picker;
            $data['page_title'] = 'সার্টিফিকেট সহকারী ( জেনারেল সার্টিফিকেট অফিসার ,জেলা প্রশাসকের কার্যালয় এর জন্য) তৈরি করুন';
            $data['list_of_others'] = $list_of_others;
            $data['available_court'] = NDoptorRepository::courtlist_district();
            $data['available_role'] = NDoptorRepository::rolelist_district();
            $data['level'] = 3;
        } elseif (globalUserInfo()->role_id == 7) {

            $data['available_court_picker'] = $available_court_picker;
            $data['page_title'] = 'সার্টিফিকেট সহকারী ( জেনারেল সার্টিফিকেট অফিসার ,জেলা প্রশাসকের কার্যালয় এর জন্য) তৈরি করুন';
            $data['list_of_others'] = $list_of_others;
            $data['available_court'] = NDoptorRepository::courtlist_district();
            $data['available_role'] = NDoptorRepository::rolelist_district();
            $data['level'] = 3;
        }

        return view('dm_adm.form')->with($data);
    }
    
    public function certificate_assistent_create_form_search(Request $request)
    {
        
        $list_of_others_fianl=[];
        $office = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $available_court_picker = DB::table('court')
            ->where('id', '=', globalUserInfo()->court_id)
            ->get();

        //dd($available_court_picker);

        $data['office'] = $office;

        if (globalUserInfo()->doptor_user_flag == 1) {
            $username = globalUserInfo()->username;
            $get_token_response = NDoptorRepository::getToken($username);

            if ($get_token_response['status'] == 'success') {
                $token = $get_token_response['data']['token'];

                $response_after_decode = NDoptorRepository::get_employee_list_by_office($token, globalUserInfo()->doptor_office_id);

                if ($response_after_decode['status'] == 'success') {

                    $everything = NDoptorRepository::all_user_list_from_doptor_segmented_search($response_after_decode['data']);

                    $list_of_all = json_decode($everything, true)['list_of_all'];
                    $search_keys = ['username', 'designation_bng', 'designation_eng', 'unit_name_en', 'unit_name_bn', 'employee_name_bng', 'employee_name_eng'];

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

                }
            }

        }
        else
        {
            return redirect('/doptor/user/check')->with('success', 'you are not Doptor User');
        }

        if (globalUserInfo()->role_id == 27) {
            if ($office->level == 4) {
                $data['available_court_picker'] = $available_court_picker;
                $data['page_title'] = 'সার্টিফিকেট সহকারী ( জেনারেল সার্টিফিকেট অফিসার ,উপজেলা নির্বাহী অফিসারের কার্যালয় এর জন্য ) তৈরি করুন';
                $data['available_court'] = NDoptorRepository::courtlist_upazila();
                $data['available_role'] = NDoptorRepository::rolelist_upazila();
                $data['list_of_others'] = $list_of_others_fianl;
                $data['level'] = 4;
            }
            if ($office->level == 3) {

                $data['available_court_picker'] = $available_court_picker;
                $data['page_title'] = 'সার্টিফিকেট সহকারী ( জেনারেল সার্টিফিকেট অফিসার ,জেলা প্রশাসকের কার্যালয় এর জন্য) তৈরি করুন';
                $data['list_of_others'] = $list_of_others_fianl;
                $data['available_court'] = NDoptorRepository::courtlist_district();
                $data['available_role'] = NDoptorRepository::rolelist_district();
                $data['level'] = 3;
            }
        } elseif (globalUserInfo()->role_id == 6) {

            $data['available_court_picker'] = $available_court_picker;
            $data['page_title'] = 'সার্টিফিকেট সহকারী ( জেনারেল সার্টিফিকেট অফিসার ,জেলা প্রশাসকের কার্যালয় এর জন্য) তৈরি করুন';
            $data['list_of_others'] = $list_of_others_fianl;
            $data['available_court'] = NDoptorRepository::courtlist_district();
            $data['available_role'] = NDoptorRepository::rolelist_district();
            $data['level'] = 3;
        }

        elseif (globalUserInfo()->role_id == 7) {

            $data['available_court_picker'] = $available_court_picker;
            $data['page_title'] = 'সার্টিফিকেট সহকারী ( জেনারেল সার্টিফিকেট অফিসার ,জেলা প্রশাসকের কার্যালয় এর জন্য) তৈরি করুন';
            $data['list_of_others'] = $list_of_others_fianl;
            $data['available_court'] = NDoptorRepository::courtlist_district();
            $data['available_role'] = NDoptorRepository::rolelist_district();
            $data['level'] = 3;
        }

        return view('certificate_assistent.form')->with($data);
    }




    public function certificate_assistent_create_form_manual()
    {
        $available_court = DB::table('court')
            ->where('id', '=', globalUserInfo()->court_id)
            ->first();
        $office = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

            if (globalUserInfo()->role_id == 27) {
                if ($office->level == 4) {
            
                    $data['page_title'] = 'সার্টিফিকেট সহকারী ( জেনারেল সার্টিফিকেট অফিসার ,উপজেলা নির্বাহী অফিসারের কার্যালয় এর জন্য ) তৈরি করুন';
                    $data['available_court'] = $available_court;
                    $data['office']=$office; 
                    $data['level'] = 4;
                }
                if ($office->level == 3) {
    
                    
                    $data['page_title'] = 'সার্টিফিকেট সহকারী ( জেনারেল সার্টিফিকেট অফিসার ,জেলা প্রশাসকের কার্যালয় এর জন্য) তৈরি করুন';
                   
                    $data['available_court'] = $available_court;
                    $data['office']=$office;
                    $data['level'] = 3;
                }
            } elseif (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 7) {
    
              
                $data['page_title'] = 'সার্টিফিকেট সহকারী ( জেনারেল সার্টিফিকেট অফিসার ,জেলা প্রশাসকের কার্যালয় এর জন্য) তৈরি করুন';
                
                $data['available_court'] = $available_court;
                $data['office']=$office;
                $data['level'] = 3;
            }
    
            return view('certificate_assistent.form_manual')->with($data);

        }


    public function certificate_assistent_create_form_manual_submit(Request $request)
    {
        //return $request;

        $this->validate(
            $request,
            [
                'name' => 'required',
                'username' => 'required',
                'mobile_no' => 'required',
                'email' => 'email',
                'password' => 'required',
            ],
            [
                'name.required' => 'আপনার নাম দিতে হবে',

                'username.required' => 'আপনার অফিসের নাম দিতে হবে',

                'mobile_no.required' => 'বিষয় দিতে হবে',

                'email.email' => 'সঠিক ইমেল দিতে হবে',

                'password.required' => 'তারিখ দিতে হবে',
            ],
        );

      
            $role_id = 28;
       

        
            $doptor_office_id = globalUserInfo()->doptor_office_id;

            $password = Hash::make($request->password);
            $user_data = [
                'name' => $request->name,
                'username' => $request->username,
                'role_id' => $role_id,
                'court_id' => $request->court_id,
                'mobile_no' => $request->mobile_no,
                'email' => $request->email,
                'password' => $password,
                'designation' => $request->designation,
                'office_id' => $request->office_id,
                'doptor_office_id' => $doptor_office_id,
                'peshkar_active' => 1,
                'created_at' => date('Y-m-d'),
            ];
        

        

        $user_exits_by_username = DB::table('users')
            ->where('username', '=', $request->username)
            ->first();
        $user_exits_by_email = DB::table('users')
            ->where('username', '=', $request->email)
            ->first();

        if (!empty($user_exits_by_username)) {
            $inserted = DB::table('users')
                ->where('id', '=', $user_exits_by_username->id)
                ->update($user_data);
        } elseif (!empty($user_exits_by_email)) {
            $inserted = DB::table('users')
                ->where('id', '=', $user_exits_by_email->id)
                ->update($user_data);
        } else {
            $inserted = DB::table('users')->insert($user_data);
        }
        if ($inserted) {
            return redirect('/peshkar/list/')->with('message', 'সফল ভাবে ইউজার পেশকার যুক্ত হয়েছেন');
        }
    }

    public function certificate_assistent_list()
    {
        $doptor_office_id = globalUserInfo()->doptor_office_id;

        $office = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $available_court = DB::table('court')
            ->where('id', '=', globalUserInfo()->court_id)
            ->first();

        if (globalUserInfo()->role_id == 27) {
            if ($office->level == 4) {

                $peshkar_users = DB::table('users')
                    ->where('role_id', '=', 28)
                    ->where('court_id', '=', $available_court->id)
                    ->where('doptor_office_id', '=', $doptor_office_id)
                    ->orderBy('id', 'DESC')
                    ->get();
                $data['peshkar_users'] = $peshkar_users;
                $data['page_title'] = 'সার্টিফিকেট সহকারী উপজেলা নির্বাহী অফিসার কার্যালয় তালিকা';
            } elseif ($office->level == 3) {
                $peshkar_users = DB::table('users')
                    ->where('role_id', '=', 28)
                    ->where('court_id', '=', $available_court->id)
                    ->where('doptor_office_id', '=', $doptor_office_id)
                    ->orderBy('id', 'DESC')
                    ->get();
                $data['peshkar_users'] = $peshkar_users;
                $data['page_title'] = 'সার্টিফিকেট সহকারী জেলা প্রশাসকের কার্যালয় তালিকা';
            }

        } elseif (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 7) {
            $peshkar_users = DB::table('users')
                ->where('role_id', '=', 28)
                ->where('court_id', '=', $available_court->id)
                ->where('doptor_office_id', '=', $doptor_office_id)
                ->orderBy('id', 'DESC')
                ->get();
            $data['peshkar_users'] = $peshkar_users;
            $data['page_title'] = 'সার্টিফিকেট সহকারী জেলা প্রশাসকের কার্যালয় তালিকা';
        }
        

        $data['available_court'] = $available_court;
        return view('certificate_assistent.certificate_assistent_list')->with($data);
    }
    
  




    public function certificate_assistent_update_form($id)
    {
        $peshkar = DB::table('users')
            ->where('id', '=', $id)
            ->first();

        $data['page_title'] = 'সার্টিফিকেট সহকারী সংশোধন';

        $data['peshkar'] = $peshkar;

        return view('certificate_assistent.form_manual_update')->with($data);
    }

    public function certificate_assistent_update_submit_manual(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'username' => 'required',
                'mobile_no' => 'required',
                'email' => 'email',
                'password' => 'required',
            ],
            [
                'name.required' => 'আপনার নাম দিতে হবে',

                'username.required' => 'আপনার অফিসের নাম দিতে হবে',

                'mobile_no.required' => 'বিষয় দিতে হবে',

                'email.email' => 'সঠিক ইমেল দিতে হবে',

                'password.required' => 'তারিখ দিতে হবে',
            ],
        );

        //dd($_POST);
        
          
        

        
            $password = Hash::make($request->password);
           
            $user_data = [
                 'name' => $request->name,
                'username' => $request->username,
                'mobile_no' => $request->mobile_no,
                'email' => $request->email,
                'password' => $password,
                'updated_at' => date('Y-m-d'),
            ];
        

        $updated = DB::table('users')
            ->where('id', '=', $request->id)
            ->update($user_data);

        if ($updated) {
            return redirect('/peshkar/list/')->with('message', 'সফল ভাবে ইউজার পেশকার যুক্ত হয়েছেন');
        }
    }

    public function peshkar_active(Request $request)
    {
        $user_data = [
            'peshkar_active' => $request->active,
        ];

        $update = DB::table('users')
            ->where('id', '=', $request->user_id)
            ->update($user_data);

        if ($update) {
            return response()->json([
                'success' => 'success',
            ]);
        } else {
            return response()->json([
                'success' => 'error',
            ]);
        }
    }

    public function store_certificate_asst_dc(Request $request)
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

                        $updated = NDoptorRepository::certificate_assistent_DC_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

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

                        $created = NDoptorRepository::certificate_assistent_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
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
    
    public function store_gco_dc(Request $request)
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

                        $updated = NDoptorRepository::gco_DC_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

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

                        $created = NDoptorRepository::gco_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
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

    public function store_adc_dc(Request $request)
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

                        $updated = NDoptorRepository::ADC_DC_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

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

                        $created = NDoptorRepository::ADC_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
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

    public function store_certificate_asst_uno(Request $request)
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

                        $updated = NDoptorRepository::certificate_assistent_UNO_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

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

                        $created = NDoptorRepository::certificate_assistent_UNO_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
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

    public function certificate_assistent_active(Request $request)
    {
        $user_data=[
            'peshkar_active'=>$request->active
          ];
  
          $update = DB::table('users')
          ->where('id', '=', $request->user_id)
          ->update($user_data);
  
          if($update)
          {
              return response()->json([
                  'success' => 'success',
              ]);
          }
          else
          {
              return response()->json([
                  'success' => 'error',
              ]);
          }
    }

    

}
