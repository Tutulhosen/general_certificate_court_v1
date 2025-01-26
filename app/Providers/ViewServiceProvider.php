<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use App\Providers\AppServiceProvider;
use App\Models\User;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use App\Models\GccAppeal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Models\Message;
use App\Models\SiteSetting;

class ViewServiceProvider extends AppServiceProvider
{
        public function boot()
    {

        $setting = SiteSetting::first();
        View::share('setting', $setting);

        // $this->messages_inc_search();

        // $this->composeFooter();
        // Schema::defaultstringLength(191);
        // Paginator::useBootstrap();

        // view()->composer('home', function ($view)
        // {
        //     $users = Auth::user()->id;

        //     $view->with('users', $users);
        // });

        view()->composer('at_case.at_case_register.create', function ($view)
        {
            $divisions = Division::all();
            $districts = District::all();
            $upazilas = Upazila::all();
            $view->with([
                'divisions' => $divisions,
                'districts' => $districts,
                'upazilas' => $upazilas
            ]);
        });


        view()->composer('at_case.at_case_register.edit', function ($view)
        {
            $divisions = Division::all();
            $districts = District::all();
            $upazilas = Upazila::all();
            $view->with([
                'divisions' => $divisions,
                'districts' => $districts,
                'upazilas' => $upazilas
            ]);
        });


        view()->composer('messages.inc.search', function ($view)
        {
            $roleID = Auth::user()->role_id;
            $officeInfo = user_office_info();
            // Dorpdown
            $upazilas = NULL;
            $courts = DB::table('court')->select('id', 'court_name')->get();
            $divisions = DB::table('division')->select('id', 'division_name_bn')->get();
            $user_role = DB::table('role')->select('id', 'role_name')->get();

            if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13 || $roleID == 16){
                $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
                $upazilas = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

            }elseif($roleID == 9 || $roleID == 10 || $roleID == 11 || $roleID == 12){
                $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
            }

            $gp_users = DB::table('users')->select('id', 'name')->where('role_id', 13)->get();

            $view->with([
                'upazilas' => $upazilas,
                'courts' => $courts,
                'divisions' => $divisions,
                'gp_users' => $gp_users,
                'user_role' => $user_role,
            ]);

        });

        // view()->composer('layouts.base.aside', function ($view)
        // {
        //     $notification_count = 0;
        //     $case_status = [];
        //     $rm_case_status = [];
        //     $officeInfo = user_office_info();
        //     $roleID = Auth::user()->role_id;
        //     $districtID = DB::table('office')
        //     ->select('district_id')->where('id',Auth::user()->office_id)
        //     ->first()->district_id;

        //    if( $roleID == 6 ) {
        //         $total_pending_case = GccAppeal::whereIn('appeal_status', ['SEND_TO_DC'])->where('district_id',user_office_info()->district_id)->count();
        //         $CaseTrialCount = GccAppeal::where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('updated_by', globalUserInfo()->id)->where('district_id',user_office_info()->district_id)->count();

              
        //         // dd($dfsdf);

        //         $notification_count = $CaseTrialCount + $total_pending_case;

        //     } elseif( $roleID == 25 ) {
        //         $total_pending_case = GccAppeal::whereIn('appeal_status', ['SEND_TO_LAB_CM'])->count();
        //         $CaseTrialCount = GccAppeal::where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('updated_by', globalUserInfo()->id)->count();

              
        //         // dd($dfsdf);

        //         $notification_count = $CaseTrialCount + $total_pending_case;

        //     } elseif( $roleID == 27 ) {
        //         $total_pending_case = GccAppeal::whereIn('appeal_status', ['SEND_TO_GCO'])->where('court_id', globalUserInfo()->court_id)->count();
                
        //         $CaseTrialCount = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('court_id', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->count();
                
        //         $CaseRunningCountActionRequired = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])
        //         ->where('court_id', globalUserInfo()->court_id)
        //         ->where('action_required', 'GCO')
        //         ->count();


        //         $reviewedCaseCount = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_LAB_CM'])->where('court_id', globalUserInfo()->court_id)->where('is_applied_for_review', 1)->count();

              

        //         $notification_count = $CaseTrialCount + $total_pending_case + $reviewedCaseCount+$CaseRunningCountActionRequired;

        //     }  elseif( $roleID == 28 ) {
        //         $CaseTrialCount = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('court_id', globalUserInfo()->court_id)->count();
                
        //         $CaseRunningCountActionRequired = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])
        //         ->where('court_id', globalUserInfo()->court_id)
        //         ->where('action_required', 'ASST')
        //         ->count();


        //         $total_pending_case = GccAppeal::whereIn('appeal_status', ['SEND_TO_ASST_GCO'])->where('court_id', globalUserInfo()->court_id)->count();
        //         $reviewedCaseCount = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_LAB_CM'])->where('court_id', globalUserInfo()->court_id)->where('is_applied_for_review', 1)->count();
        //         // dd($dfsdf);

        //         $notification_count =  $CaseTrialCount + $total_pending_case + $reviewedCaseCount+$CaseRunningCountActionRequired;

        //     } elseif( $roleID == 34 ) {
        //         $total_pending_case = GccAppeal::whereIn('appeal_status', ['SEND_TO_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();
        //         $CaseTrialCount = GccAppeal::where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->whereIn('appeal_status', ['ON_TRIAL'])->where('updated_by', globalUserInfo()->id)->where('division_id', user_office_info()->division_id)->count();

              
        //         // dd($dfsdf);

        //         $notification_count = $CaseTrialCount + $total_pending_case;

        //     }  elseif( $roleID == 35 ) {
        //         $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
        //         ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
        //         ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
        //         ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
        //         ->where('gcc_appeal_citizens.citizen_type_id', '=', 1)
        //         ->whereIn('gcc_appeals.appeal_status', ['ON_TRIAL'])
        //         ->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)
        //         ->select('gcc_appeal_citizens.appeal_id')
        //         ->get();
    
        //         $CaseTrialCount = count($appeal_ids_from_db);

        //         $notification_count = $CaseTrialCount;

        //     } elseif( $roleID == 36 ) {

        //         $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
        //         ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
        //         ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
        //         ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
        //         ->whereIn('gcc_appeal_citizens.citizen_type_id', [2,5])
        //         ->whereIn('gcc_appeals.appeal_status', ['ON_TRIAL'])
        //         ->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)
        //         ->select('gcc_appeal_citizens.appeal_id')
        //         ->get();
    
        //         $CaseTrialCount = count($appeal_ids_from_db);

        //         $notification_count = $CaseTrialCount;

        //     } else {
        //         //for role id : 5,6,7,8,13
        //         $case_status = DB::table('case_register')
        //             ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
        //             ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
        //             ->groupBy('case_register.cs_id')
        //             ->where('case_register.district_id','=', $officeInfo->district_id)
        //             ->where('case_register.action_user_group_id', $roleID)
        //             ->get();
               
        //         // dd($rm_case_status);
        //     }

        //    if( $roleID != 2 && $roleID != 6 && $roleID != 25 && $roleID != 27  && $roleID != 28 && $roleID != 32  && $roleID != 33 && $roleID != 34   && $roleID != 35  ){
        //         foreach ($case_status as $row){
        //              $notification_count += $row->total_case;
        //         }
        //         foreach ($rm_case_status as $row){
        //              $notification_count += $row->total_case;
        //         }

        //         $view->with([
        //             'notification_count' => $notification_count,
        //             'case_status' => $case_status,
        //             'rm_case_status' => $rm_case_status,
        //         ]);

        //     } elseif ($roleID == 27 || $roleID == 28) {
        //         $view->with([
        //             'notification_count' => $notification_count,
        //             'total_pending_case' => $total_pending_case,
        //             'CaseTrialCount' => $CaseTrialCount,
        //             'reviewedCaseCount' => $reviewedCaseCount,
        //             'CaseRunningCountActionRequired'=>$CaseRunningCountActionRequired
        //         ]);
        //     }  elseif ($roleID == 6 || $roleID == 25 || $roleID == 34) {
        //         $view->with([
        //             'notification_count' => $notification_count,
        //             'total_pending_case' => $total_pending_case,
        //             'CaseTrialCount' => $CaseTrialCount,
        //         ]);
        //     }  elseif ($roleID == 32) {
        //         $view->with([
        //             'notification_count' => $notification_count,
        //             'CaseCrockCount' => $CaseCrockCount,
        //         ]);
        //     } elseif ($roleID == 33) {
        //         $view->with([
        //             'notification_count' => $notification_count,
        //             'CaseWarrentCount' => $CaseWarrentCount,
        //         ]);
        //     } elseif ($roleID == 35) {
        //         $view->with([
        //             'notification_count' => $notification_count,
        //             'CaseTrialCount' => $CaseTrialCount,
        //         ]);
        //     } else {
        //         $view->with([
        //             'notification_count' => $notification_count,
        //             'CaseHearingCount' => $CaseHearingCount,
        //             'CaseResultCount' => $CaseResultCount,
        //             'total_sf_count' => $total_sf_count,
        //         ]);
        //     }
        //     //

        //     //Message Notification --- start
        //     $NewMessagesCount = Message::select('id')
        //         ->where('user_receiver', Auth::user()->id)
        //         ->where('receiver_seen', 0)
        //         ->where('msg_reqest', 0)
        //         ->count();
        //     $msg_request_count = Message::orderby('id', 'DESC')
        //         // ->select('user_sender', 'user_receiver', 'msg_reqest')
        //         ->Where('user_receiver', [Auth::user()->id])
        //         ->Where('msg_reqest', 1)
        //         ->groupby('user_sender')
        //         ->count();
        //     $Ncount = $NewMessagesCount + $msg_request_count;

        //     $view->with([
        //         'Ncount' => $Ncount,
        //         'NewMessagesCount' => $NewMessagesCount,
        //         'msg_request_count' => $msg_request_count,
        //     ]);
        //     //Message Notification  --- End



        // });

        view()->composer('layouts.base.header', function ($view)
        {
            $notification_count = 0;
            $case_status = [];
            $rm_case_status = [];
            $officeInfo = user_office_info();
            $roleID = Auth::user()->role_id;
            if($roleID != 25){
                $districtID = DB::table('office')
                ->select('district_id')->where('id', Auth::user()->office_id)
                ->first()->district_id;
            }

            if( $roleID == 9 || $roleID == 10 || $roleID == 11  || $roleID == 21 ){

                $case_status = DB::table('case_register')
                    ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                    ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                    ->groupBy('case_register.cs_id')
                    ->where('case_register.upazila_id','=', $officeInfo->upazila_id)
                    ->where('case_register.action_user_group_id', $roleID)
                    ->get();
                

            } elseif( $roleID == 22 || $roleID == 23){

                $case_status = DB::table('case_register')
                    ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                    ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                    ->groupBy('case_register.cs_id')
                    ->where('case_register.upazila_id','=', $officeInfo->upazila_id)
                    ->where('case_register.action_user_group_id', $roleID)
                    ->get();
               

            } elseif( $roleID == 14 ) {
                $case_status = DB::table('case_register')
                    ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                    ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                    ->groupBy('case_register.cs_id')
                    ->where('case_register.action_user_group_id', $roleID)
                    ->get();

            } elseif( $roleID == 12 ) {
                $moujaIDs = DB::table('mouja_ulo')->where('ulo_office_id', Auth::user()->office_id)->pluck('mouja_id');
                $case_status = DB::table('case_register')
                    ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                    ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                    ->groupBy('case_register.cs_id')
                    ->whereIn('case_register.mouja_id', $moujaIDs)
                    ->where('case_register.action_user_group_id', $roleID)
                    ->get();
            } elseif( $roleID == 2 ) {
                $total_sf_count = DB::table('case_register')
                    ->where('is_sf', 1)
                    ->where('status', 1)
                    ->get()
                    ->count();
                $CaseResultCount = DB::table('case_register')
                    ->where('status', '!=', 1)
                    ->get()
                    ->count();

                $CaseHearingCount = DB::table('case_hearing')
                    ->distinct()
                    ->join('case_register', 'case_hearing.case_id', '=', 'case_register.id')
                    ->where('case_register.status', 1)
                    ->select('case_id')
                    ->get()
                    ->count();

              
                // dd($dfsdf);

                $notification_count = $CaseResultCount + $CaseHearingCount + $total_sf_count;

            } elseif( $roleID == 6 ) {
                $total_pending_case = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_DC'])->where('district_id',user_office_info()->district_id)->count();
                $CaseTrialCount = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('updated_by', globalUserInfo()->id)->where('district_id',user_office_info()->district_id)->count();

              
                // dd($dfsdf);

                $notification_count = $CaseTrialCount + $total_pending_case;

            } elseif( $roleID == 25 ) {
                $total_pending_case = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_LAB_CM'])->count();

                $CaseTrialCount = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL_LAB_CM'])->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('updated_by', globalUserInfo()->id)->count();

              
                // dd($dfsdf);

                $notification_count = $CaseTrialCount + $total_pending_case;

            } elseif( $roleID == 27 ) {
                $total_pending_case = GccAppeal::whereIn('appeal_status', ['SEND_TO_GCO'])->where('court_id', globalUserInfo()->court_id)->count();
                
                $CaseTrialCount = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('court_id', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->count();
                
                $CaseRunningCountActionRequired = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])
                ->where('court_id', globalUserInfo()->court_id)
                ->where('action_required', 'GCO')
                ->count();


                $reviewedCaseCount = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_LAB_CM'])->where('court_id', globalUserInfo()->court_id)->where('is_applied_for_review', 1)->count();

              
                // dd($reviewedCaseCount);

                $notification_count = $CaseTrialCount + $total_pending_case + $reviewedCaseCount+$CaseRunningCountActionRequired;

            }  elseif( $roleID == 28 ) {
                $CaseTrialCount = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('court_id', globalUserInfo()->court_id)->count();
                
                $CaseRunningCountActionRequired = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])
                ->where('court_id', globalUserInfo()->court_id)
                ->where('action_required', 'ASST')
                ->count();


                $total_pending_case = GccAppeal::whereIn('appeal_status', ['SEND_TO_ASST_GCO'])->where('court_id', globalUserInfo()->court_id)->count();
                $reviewedCaseCount = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_LAB_CM'])->where('court_id', globalUserInfo()->court_id)->where('is_applied_for_review', 1)->count();
                // dd($dfsdf);

                $notification_count =  $CaseTrialCount + $total_pending_case + $reviewedCaseCount+$CaseRunningCountActionRequired;

            } elseif( $roleID == 34 ) {
                $total_pending_case = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();
                $CaseTrialCount = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])->where('updated_by', globalUserInfo()->id)->where('division_id', user_office_info()->division_id)->count();

              
                // dd($dfsdf);

                $notification_count = $CaseTrialCount + $total_pending_case;

            }  elseif( $roleID == 32 ) {
                $CaseCrockCount = DB::table('gcc_case_shortdecision_templates')
                    ->where('gcc_case_shortdecision_templates.case_shortdecision_id','=', 9)
                    ->count();

                $notification_count = $CaseCrockCount;

            }  elseif( $roleID == 33 ) {
                $CaseWarrentCount = DB::table('gcc_case_shortdecision_templates')
                    ->where('gcc_case_shortdecision_templates.case_shortdecision_id','=', 7)
                    ->count();

                $notification_count = $CaseWarrentCount;

            }  elseif( $roleID == 35 ) {
                $CaseTrialCount = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('created_by', globalUserInfo()->id)->count();

                $notification_count = $CaseTrialCount;

            }  else {
                //for role id : 5,6,7,8,13
                $case_status = DB::table('case_register')
                    ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                    ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                    ->groupBy('case_register.cs_id')
                    ->where('case_register.district_id','=', $officeInfo->district_id)
                    ->where('case_register.action_user_group_id', $roleID)
                    ->get();
               
                // dd($rm_case_status);
            }

           if( $roleID != 2 && $roleID != 6 && $roleID != 25 && $roleID != 27  && $roleID != 28 && $roleID != 32  && $roleID != 33 && $roleID != 34   && $roleID != 35  ){
                foreach ($case_status as $row){
                     $notification_count += $row->total_case;
                }
                foreach ($rm_case_status as $row){
                     $notification_count += $row->total_case;
                }

                $view->with([
                    'notification_count' => $notification_count,
                    'case_status' => $case_status,
                    'rm_case_status' => $rm_case_status,
                ]);

            } elseif ($roleID == 27 || $roleID == 28) {
                $view->with([
                    'notification_count' => $notification_count,
                    'total_pending_case' => $total_pending_case,
                    'CaseTrialCount' => $CaseTrialCount,
                    'reviewedCaseCount' => $reviewedCaseCount,
                    'CaseRunningCountActionRequired'=>$CaseRunningCountActionRequired,
                ]);
            }  elseif ($roleID == 6 || $roleID == 25 || $roleID == 34) {
                $view->with([
                    'notification_count' => $notification_count,
                    'total_pending_case' => $total_pending_case,
                    'CaseTrialCount' => $CaseTrialCount,
                ]);
            }  elseif ($roleID == 32) {
                $view->with([
                    'notification_count' => $notification_count,
                    'CaseCrockCount' => $CaseCrockCount,
                ]);
            } elseif ($roleID == 33) {
                $view->with([
                    'notification_count' => $notification_count,
                    'CaseWarrentCount' => $CaseWarrentCount,
                ]);
            } elseif ($roleID == 35) {
                $view->with([
                    'notification_count' => $notification_count,
                    'CaseTrialCount' => $CaseTrialCount,
                ]);
            } else {
                $view->with([
                    'notification_count' => $notification_count,
                    'CaseHearingCount' => $CaseHearingCount,
                    'CaseResultCount' => $CaseResultCount,
                    'total_sf_count' => $total_sf_count,
                ]);
            }
            //

            //Message Notification --- start
            $NewMessagesCount = Message::select('id')
                ->where('user_receiver', Auth::user()->id)
                ->where('receiver_seen', 0)
                ->where('msg_reqest', 0)
                ->count();
            $msg_request_count = Message::orderby('id', 'DESC')
                // ->select('user_sender', 'user_receiver', 'msg_reqest')
                ->Where('user_receiver', [Auth::user()->id])
                ->Where('msg_reqest', 1)
                ->groupby('user_sender')
                ->count();
            $Ncount = $NewMessagesCount + $msg_request_count;

            $view->with([
                'Ncount' => $Ncount,
                'NewMessagesCount' => $NewMessagesCount,
                'msg_request_count' => $msg_request_count,
            ]);
            //Message Notification  --- End



        });

        view()->composer('layouts.citizen.base.aside', function ($view)
        {
            $notification_count = 0;
            $case_status = [];
            $rm_case_status = [];
            $officeInfo = user_office_info();
            $roleID = Auth::user()->role_id;
            if( $roleID == 35 ) {
                $districtID = DB::table('office')
                ->select('district_id')->where('id',Auth::user()->office_id)
                ->first()->district_id;

                $CaseTrialCount = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('created_by', globalUserInfo()->id)->count();

                $notification_count = $CaseTrialCount;

            }elseif( $roleID == 36 ) {
               

                $CaseTrialCount = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('created_by', globalUserInfo()->id)->count();

                $notification_count = $CaseTrialCount;

            }  else {
                //for role id : 5,6,7,8,13
                $case_status = DB::table('case_register')
                    ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                    ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                    ->groupBy('case_register.cs_id')
                    ->where('case_register.district_id','=', $officeInfo->district_id)
                    ->where('case_register.action_user_group_id', $roleID)
                    ->get();
               
                // dd($rm_case_status);
            }

           if( $roleID != 35  ){
                foreach ($case_status as $row){
                     $notification_count += $row->total_case;
                }
                foreach ($rm_case_status as $row){
                     $notification_count += $row->total_case;
                }

                $view->with([
                    'notification_count' => $notification_count,
                    'case_status' => $case_status,
                    'rm_case_status' => $rm_case_status,
                ]);

            
            }elseif( $roleID != 36  ){
                foreach ($case_status as $row){
                     $notification_count += $row->total_case;
                }
                foreach ($rm_case_status as $row){
                     $notification_count += $row->total_case;
                }

                $view->with([
                    'notification_count' => $notification_count,
                    'case_status' => $case_status,
                ]);

            
            } else {
                $view->with([
                    'notification_count' => $notification_count,
                    'CaseTrialCount' => $CaseTrialCount,
                ]);
            }
            //

            //Message Notification --- start
            $NewMessagesCount = Message::select('id')
                ->where('user_receiver', Auth::user()->id)
                ->where('receiver_seen', 0)
                ->where('msg_reqest', 0)
                ->count();
            $msg_request_count = Message::orderby('id', 'DESC')
                // ->select('user_sender', 'user_receiver', 'msg_reqest')
                ->Where('user_receiver', [Auth::user()->id])
                ->Where('msg_reqest', 1)
                ->groupby('user_sender')
                ->count();
            $Ncount = $NewMessagesCount + $msg_request_count;

            $view->with([
                'Ncount' => $Ncount,
                'NewMessagesCount' => $NewMessagesCount,
                'msg_request_count' => $msg_request_count,
            ]);
            //Message Notification  --- End



        });


    }
    public function register()
    {
        //
    }

}
