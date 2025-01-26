<?php

namespace App\Http\Controllers\API;

use App\Models\GccAppeal;
use App\Models\CaseHearing;
// use Validator;
use App\Models\CaseRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Repositories\AppealRepository;
use App\Repositories\CertificateAsstNoteRepository;
// use Validator;
// use Auth;
use App\Http\Resources\calendar\CaseHearingCollection;

class DashboardController extends BaseController
{
    public function test()
    {
        // Counter
        //$data['total_case'] = DB::table('case_register')->count();
        $data['Hello'] = 'Hello';
        // dd($data);
        // echo 'Hellollll'; exit;
        return $this->sendResponse($data, 'test successfully.');
    }

    // use AuthenticatesUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $data = [];

        $roleID = globalUserInfo()->role_id;
        $userID = globalUserInfo()->id;
        $court_id = globalUserInfo()->court_id;
        $division_id = $request->division_id;
        $district_id = $request->district_id;
        $office_id = globalUserInfo()->office_id;

        if ($roleID == 1) {
            // Superadmi dashboard

            // Counter
            $data['total_case'] = GccAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();
            $data['running_case'] = GccAppeal::where('appeal_status', 'ON_TRIAL')->count();
            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->count();
            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_ASST_GCO', 'SEND_TO_GCO'])->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->count();
            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

            return $this->sendResponse($data, 'সুপার অ্যাডমিন.'); //Superadmi Data

        } elseif ($roleID == 2) {

            $data['total_case'] = GccAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();
            $data['running_case'] = GccAppeal::where('appeal_status', 'ON_TRIAL')->count();
            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->count();
            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_ASST_GCO', 'SEND_TO_GCO'])->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->count();
            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

            return $this->sendResponse($data, 'উপসচিব.'); //Superadmi Data

        } elseif ($roleID == 6) {

            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DC'])->where('district_id', user_district()->id)->count();

            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_DC'])->where('district_id', user_district()->id)->count();

            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_DC'])->where('district_id', user_district()->id)->count();

            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('district_id', user_district()->id)->count();

            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('district_id', user_district()->id)->count();

            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('district_id', user_office_info()->district_id)->count();

            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('district_id', user_office_info()->district_id)->count();

            $data['total_court'] = DB::table('court')->whereNotIn(
                'id',
                [1, 2]
            )->count();

            return $this->sendResponse($data, 'জেলা প্রশাসক.');
        } elseif ($roleID == 14) {

            $data['total_case'] = DB::table('case_register')->count();
            $data['running_case'] = DB::table('case_register')->where('status', 1)->count();
            $data['appeal_case'] = DB::table('case_register')->where('status', 2)->count();
            $data['completed_case'] = DB::table('case_register')->where('status', 3)->count();

            return $this->sendResponse($data, 'LAB Chairman Data.');
        } elseif ($roleID == 20) {
            $data['page_title'] = 'অ্যাডভোকেট এর ড্যাশবোর্ড';
            return view('dashboard.office_head')->with($data);
        } elseif ($roleID == 24) {
            // Superadmin dashboard
            // Counter
            $data['total_case'] = GccAppeal::count();
            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL', 'SEND_TO_GCO'])->count();
            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->count();
            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();
            $data['total_sf_count'] = CaseRegister::orderby('id', 'desc')->where('is_sf', 1)->where('status', 1)->get()->count();

            return $this->sendResponse($data, 'অফিস সহকারী (এলএবি).');
        } elseif ($roleID == 25) {

            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_LAB_CM', 'CLOSED'])->where('updated_by', globalUserInfo()->id)->count();

            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_LAB_CM'])->count();

            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_LAB_CM'])->where('updated_by', globalUserInfo()->id)->count();

            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('updated_by', globalUserInfo()->id)->count();

            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('updated_by', globalUserInfo()->id)->count();

            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->count();

            return $this->sendResponse($data, 'চেয়ারম্যান(ভূমী আপীল বোর্ড).');
        } elseif ($roleID == 27) {

            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL', 'CLOSED'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('court_id', globalUserInfo()->court_id)->count();
            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_GCO'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('court_id', globalUserInfo()->court_id)->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('court_id', globalUserInfo()->court_id)->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('court_id', globalUserInfo()->court_id)->count();

            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('court_id', $court_id)->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('court_id', $court_id)->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('court_id', $court_id)->count();
            $data['pending_case_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_GCO'])->where('court_id', $court_id)->count();

            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

            return $this->sendResponse($data, 'জিসিও.');
        } elseif ($roleID == 28) {
            // asst GCO dashboard

            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL', 'CLOSED'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('court_id', globalUserInfo()->court_id)->count();
            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_ASST_GCO'])->where('court_id', globalUserInfo()->court_id)->count();

            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('court_id', globalUserInfo()->court_id)->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('court_id', globalUserInfo()->court_id)->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('court_id', globalUserInfo()->court_id)->count();

            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

            return $this->sendResponse($data, 'সার্টিফিকেট সহকারী.');
        } elseif ($roleID == 32) {
            $moujaIDs = DB::table('mouja_ulo')->where('ulo_office_id', $office_id)->pluck('mouja_id');

            $data['total_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->count();
            $data['running_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 1)->count();
            $data['appeal_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 2)->count();
            $data['completed_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 3)->count();

            return $this->sendResponse($data, 'সাব রেজিস্ট্রার.');
        } elseif ($roleID == 33) {
            $moujaIDs = DB::table('mouja_ulo')->where('ulo_office_id', $office_id)->pluck('mouja_id');

            $data['total_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->count();
            $data['running_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 1)->count();
            $data['appeal_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 2)->count();
            $data['completed_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 3)->count();

            return $this->sendResponse($data, 'ভারপ্রাপ্ত কর্মকর্তা(ওসি).');
        } elseif ($roleID == 34) {
            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();

            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();

            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();

            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('division_id', user_office_info()->division_id)->count();

            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('division_id', user_office_info()->division_id)->count();

            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('division_id', user_office_info()->division_id)->count();

            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

            return $this->sendResponse($data, 'বিভাগীয় কমিশনার.');
        } elseif ($roleID == 35) {

            $data['total_case'] = $this->total_case_count_applicant()['total_count'];
            $data['running_case'] = $this->total_running_case_count_applicant()['total_count'];
            $data['pending_case'] = $this->total_pending_case_count_applicant()['total_count'];
            $data['completed_case'] = $this->total_completed_case_count_applicant()['total_count'];

            $data['draft_case'] = GccAppeal::where('created_by', $userID)->where('appeal_status', 'DRAFT')->count();
            $data['rejected_case'] = GccAppeal::where('created_by', $userID)->where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = GccAppeal::where('created_by', $userID)->where('appeal_status', 'POSTPONED')->count();

            return $this->sendResponse($data, 'প্রাতিষ্ঠানিক প্রতিনিধি');
        } elseif ($roleID == 36) {
            $totalCase = 0;
            $totalRunningCase = 0;
            $totalCompleteCase = 0;

            $array_case_list_to_causlist = [];

            $citizen_id = DB::table('gcc_citizens')
                ->where('citizen_NID', globalUserInfo()->citizen_nid)
                ->select('id')
                ->get();

            if (!empty($citizen_id)) {
                foreach ($citizen_id as $key => $value) {
                    // return $value;
                    $appeal_no = DB::table('gcc_appeal_citizens')
                        ->where('citizen_id', $value->id)
                        ->where('citizen_type_id', 2)
                        ->select('appeal_id')
                        ->get();
                }
            } else {
                $appeal_no = null;
            }

            if (!empty($appeal_no)) {
                foreach ($appeal_no as $key => $value) {
                    if (!empty($value)) {

                        $all_case = GccAppeal::where('id', $value->appeal_id)->whereIn('appeal_status', ['CLOSED', 'ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])->first();

                        if ($all_case) {

                            array_push($array_case_list_to_causlist, $all_case->id);

                            $totalCase++;
                        }
                        $running_case = GccAppeal::where('id', $value->appeal_id)->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])->first();
                        if ($running_case) {
                            $totalRunningCase++;
                        }
                        $completed_case = GccAppeal::where('id', $value->appeal_id)->whereIn('appeal_status', ['CLOSED'])->first();
                        if ($completed_case) {
                            $totalCompleteCase++;
                        }
                    }
                }
            }

            // return $all_case;

            $data['total_case'] = $totalCase;
            $data['running_case'] = $totalRunningCase;
            $data['completed_case'] = $totalCompleteCase;
            $data['pending_case'] = GccAppeal::where('review_applied_by', globalUserInfo()->id)->whereIn('appeal_status', ['SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_LAB_CM'])->count();
            /*$data['total_case'] = GccAppeal::count();
            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL', 'SEND_TO_GCO'])->count();
            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->count();
            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->count();*/

            return $this->sendResponse($data, 'নাগরিক');
        } else {
            $data = array();
            return $this->sendResponse($data, 'Sorry dose not fill up requirement.');
        }
    }

    /*  public function total_case_count_applicant()
    {
        $user = globalUserInfo();
        $appeal_ids_as_agent = [];
        $appeal_ids_as_applicant = [];

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->where('gcc_appeal_citizens.citizen_type_id', '=', 1)
            ->whereIn('gcc_appeals.appeal_status', ['CLOSED', 'ON_TRIAL'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
            array_push($appeal_ids_as_agent, $appeal_ids_from_db_single->appeal_id);

        }

        $appeal_ids_applicant = GccAppeal::orderby('id', 'DESC')->where('created_by', $user->id)->whereIn('appeal_status', ['ON_TRIAL',  'CLOSED'])->select('id')->get();

        foreach ($appeal_ids_applicant as $appeal_ids_applicant_single) {
            array_push($appeal_ids_as_applicant, $appeal_ids_applicant_single->id);

        }
        $total_case = array_merge($appeal_ids_as_agent, $appeal_ids_as_applicant);

        return GccAppeal::WhereIn('ID', $total_case)->count();
    } */
    public function total_case_count_applicant()
    {

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('gcc_appeal_citizens.citizen_type_id', [1, 2, 5])
            ->whereIn('gcc_appeals.appeal_status', ['CLOSED', 'ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        $appeal_id_array = [];
        $count = 0;
        foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
            array_push($appeal_id_array, $appeal_ids_from_db_single->appeal_id);
            $count++;
        }

        return ['total_count' => $count, 'appeal_id_array' => $appeal_id_array];
    }
    /*  public function total_running_case_count_applicant()
    {
        $user = globalUserInfo();
        $appeal_ids_as_agent = [];
        $appeal_ids_as_applicant = [];

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->where('gcc_appeal_citizens.citizen_type_id', '=', 1)
            ->whereIn('gcc_appeals.appeal_status', ['ON_TRIAL'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
            array_push($appeal_ids_as_agent, $appeal_ids_from_db_single->appeal_id);

        }

        $appeal_ids_applicant = GccAppeal::orderby('id', 'DESC')->where('created_by', $user->id)->whereIn('appeal_status', ['ON_TRIAL'])->select('id')->get();

        foreach ($appeal_ids_applicant as $appeal_ids_applicant_single) {
            array_push($appeal_ids_as_applicant, $appeal_ids_applicant_single->id);

        }
        $total_case = array_merge($appeal_ids_as_agent, $appeal_ids_as_applicant);

        return GccAppeal::WhereIn('ID', $total_case)->count();
    } */
    public function total_running_case_count_applicant()
    {

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('gcc_appeal_citizens.citizen_type_id', [1, 2, 5])
            ->whereIn('gcc_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        return ['total_count' => count($appeal_ids_from_db), 'appeal_id_array' => ''];
    }
    /*    public function total_pending_case_count_applicant()
    {
        $user = globalUserInfo();
        $appeal_ids_as_agent = [];
        $appeal_ids_as_applicant = [];

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->where('gcc_appeal_citizens.citizen_type_id', '=', 1)
            ->whereIn('gcc_appeals.appeal_status', ['SEND_TO_GCO', 'SEND_TO_ASST_GCO'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
            array_push($appeal_ids_as_agent, $appeal_ids_from_db_single->appeal_id);

        }

        $appeal_ids_applicant = GccAppeal::orderby('id', 'DESC')->where('created_by', $user->id)->whereIn('appeal_status', ['SEND_TO_GCO', 'SEND_TO_ASST_GCO'])->select('id')->get();

        foreach ($appeal_ids_applicant as $appeal_ids_applicant_single) {
            array_push($appeal_ids_as_applicant, $appeal_ids_applicant_single->id);

        }
        $total_case = array_merge($appeal_ids_as_agent, $appeal_ids_as_applicant);

        return GccAppeal::WhereIn('ID', $total_case)->count();
    } */
    public function total_pending_case_count_applicant()
    {

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('gcc_appeal_citizens.citizen_type_id', [1, 2, 5])
            ->whereIn('gcc_appeals.appeal_status', ['SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_LAB_CM', 'SEND_TO_GCO', 'SEND_TO_ASST_GCO'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();


        return ['total_count' => count($appeal_ids_from_db), 'appeal_id_array' => ''];
    }
    /*  public function total_completed_case_count_applicant()
    {
        $user = globalUserInfo();
        $appeal_ids_as_agent = [];
        $appeal_ids_as_applicant = [];

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->where('gcc_appeal_citizens.citizen_type_id', '=', 1)
            ->whereIn('gcc_appeals.appeal_status', ['CLOSED'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
            array_push($appeal_ids_as_agent, $appeal_ids_from_db_single->appeal_id);

        }

        $appeal_ids_applicant = GccAppeal::orderby('id', 'DESC')->where('created_by', $user->id)->whereIn('appeal_status', ['CLOSED'])->select('id')->get();

        foreach ($appeal_ids_applicant as $appeal_ids_applicant_single) {
            array_push($appeal_ids_as_applicant, $appeal_ids_applicant_single->id);

        }
        $total_case = array_merge($appeal_ids_as_agent, $appeal_ids_as_applicant);

        return GccAppeal::WhereIn('ID', $total_case)->count();
    } */
    public function total_completed_case_count_applicant()
    {

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('gcc_appeal_citizens.citizen_type_id', [1, 2, 5])
            ->whereIn('gcc_appeals.appeal_status', ['CLOSED'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        return ['total_count' => count($appeal_ids_from_db), 'appeal_id_array' => ''];
    }
 
    public function dashboardCauseList()
    {
        $all_appeal = GccAppeal::where('case_no', '!=', 'অসম্পূর্ণ মামলা')->whereIn('appeal_status', ['ON_TRIAL'])->get();
        $appeal_array = [];
        foreach ($all_appeal as $appeal_single) {
            $exists = DB::table('gcc_manual_causelist')->where('case_no', '=', $appeal_single->case_no)->first();

            if (empty($exists)) {
                // dd($appeal_single->case_no);
                DB::table('gcc_manual_causelist')->insert([
                    'case_no' => $appeal_single->case_no,
                    'appeal_id' => $appeal_single->id,
                    'court_id' => $appeal_single->court_id,
                    'division_id' => $appeal_single->division_id,
                    'district_id' => $appeal_single->district_id,
                    'upazila_id' => $appeal_single->upazila_id,
                    'next_date' => $appeal_single->next_date,
                    'type'     => 1
                ]);
            }
        }

        $roleID = Auth::user()->role_id;

        if ($roleID == 28 || $roleID == 27) {


            $data = array();

            $causelistdata = DB::table('gcc_manual_causelist')
                ->leftJoin('gcc_appeals', 'gcc_appeals.id', '=', 'gcc_manual_causelist.appeal_id')
                ->leftJoin('custom_causelist', 'custom_causelist.id', '=', 'gcc_manual_causelist.causelist_id')
                ->select(
                    'gcc_manual_causelist.appeal_id as id',
                    'gcc_manual_causelist.case_no',
                    'gcc_appeals.case_date',
                    'gcc_manual_causelist.next_date',
                    'gcc_appeals.office_id',
                    'gcc_appeals.office_name',
                    'gcc_appeals.district_id',
                    'gcc_appeals.district_name',
                    'gcc_appeals.division_id',
                    'gcc_appeals.division_name',
                    'gcc_appeals.law_section',
                    'gcc_appeals.loan_amount_text',
                    'gcc_appeals.loan_amount',
                    'gcc_appeals.peshkar_office_id',
                    'gcc_appeals.peshkar_name',
                    'gcc_appeals.peshkar_email',
                    'gcc_appeals.gco_name',
                    'gcc_appeals.gco_user_id',
                    'gcc_appeals.gco_office_id',
                    'gcc_appeals.court_id',
                    'gcc_manual_causelist.type',
                    'gcc_manual_causelist.causelist_id',
                    'gcc_manual_causelist.division_id',
                    'gcc_manual_causelist.district_id',
                    'gcc_manual_causelist.court_id',
                    'custom_causelist.defaulter_name',
                    'custom_causelist.org_representative'
                );
            $causelistdata = $causelistdata->where('gcc_manual_causelist.court_id', '=', globalUserInfo()->court_id)->get();

            if (!$causelistdata->isEmpty()) {
                foreach ($causelistdata as $key => $value) {
                    $data['appeal'][$key]['appealInfo'] = $value;
                    if ($value->type == 1) {
                        $citizenLists = DB::table('gcc_appeal_citizens')
                            ->select('citizen_id', 'citizen_type_id', 'appeal_id')
                            ->where('appeal_id', $value->id)->get();

                        foreach ($citizenLists as $citizenList) {

                            if ($citizenList->citizen_type_id == 1) {
                                $data['appeal'][$key]['applicantCitizen'] = DB::table('gcc_citizens')
                                    ->select('id as citizen_id', 'citizen_name')
                                    ->where('id', $citizenList->citizen_id)->get();
                            } else if ($citizenList->citizen_type_id == 2) {
                                $data['appeal'][$key]['defaulterCitizen'] = DB::table('gcc_citizens')
                                    ->select('id as citizen_id', 'citizen_name')
                                    ->where('id', $citizenList->citizen_id)->get();
                            }
                        }
                        $data['appeal'][$key]['notes'] = DB::table('gcc_notes_modified')
                            ->join('gcc_case_shortdecisions', 'gcc_notes_modified.case_short_decision_id', 'gcc_case_shortdecisions.id')
                            ->where('gcc_notes_modified.appeal_id', $value->id)
                            ->select('gcc_notes_modified.conduct_date as conduct_date', 'gcc_case_shortdecisions.case_short_decision as short_order_name')
                            ->orderBy('gcc_notes_modified.id', 'desc')
                            ->first();
                    } else {
                        $data['appeal'][$key]['defaulterCitizen'] = [
                            [
                            'citizen_id' => null,
                            'citizen_name' => $value->defaulter_name,
    
                            ],];
                        $data['appeal'][$key]['applicantCitizen'] =
                            [[
                                'citizen_id' => null,
                                'citizen_name' => $value->org_representative,
    
                            ],];
                        $custom_notes = DB::table('causelist_order')->where('causelist_id', $value->causelist_id)->orderby('id', 'desc')->first();
                        $data['appeal'][$key]['notes'] = [
                            "conduct_date" => null,
                            "short_order_name" => $custom_notes->short_order_name
                        ];
                    }
                }
            } else {
                $data['appeal'] = [];
            }

            if (empty($data)) {
                return $this->sendResponse($data, 'Data Not Found.');
            } else {
                return $this->sendResponse($data, 'Data Found Success.');
            }
        }
    }
    public function dashboardCauseListOld()
    {

        $data = [];
        $roleID = Auth::user()->role_id;
        $userID = globalUserInfo()->id;


        if (!empty($roleID)) {
            $data['authuserinfo'] = array(
                "id" => Auth::user()->id,
                'name' => Auth::user()->name,
                'username' => Auth::user()->username,
                "role_id" => 28
            );
        }


        // $court_id = $request->court_id;
        // $division_id = $request->division_id;
        // $district_id = $request->district_id;
        // $office_id = $request->office_id;
        // if(globalUserInfo()->is_verified_account == 1 && mobile_first_registration())
        // {
        //  $data['varified'] = 'non_verified_account';
        //  return $this->sendResponse($data,'Account verified');
        // }
        // if ($roleID == 1) {


        //     // Superadmi dashboard

        //     // Counter
        //     $data['total_case'] = GccAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();

        //     $data['running_case'] = GccAppeal::where('appeal_status', 'ON_TRIAL')->count();
        //     $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->count();
        //     $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_ASST_GCO', 'SEND_TO_GCO'])->count();
        //     $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->count();
        //     $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->count();
        //     $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->count();

        //     $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
        //     $data['total_user'] = DB::table('users')->count();
        //     $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

        //     // Drildown Statistics
        //     $division_list = DB::table('division')
        //         ->select('division.id', 'division.division_name_bn', 'division.division_name_en', 'division.division_bbs_code')
        //         ->get();

        //     $divisiondata = array();
        //     $districtdata = array();
        //     $upazilatdata = array();



        //     // Division List
        //     foreach ($division_list as $division) {

        //         $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->division_bbs_code);

        //         // District List
        //         $district_list = DB::table('district')->select('district.id', 'district.district_name_bn', 'district.district_bbs_code')->where('division_id', $division->id)->get();

        //         foreach ($district_list as $district) {

        //             $dis_data[$division->division_bbs_code][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->district_bbs_code);

        //             $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)
        //                 ->where('division_id', $division->id)->get();

        //             foreach ($upazila_list as $upazila) {
        //                 $upa_data[$district->district_bbs_code][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
        //             }

        //             $upadata = $upa_data[$district->district_bbs_code];
        //             $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->district_bbs_code, 'data' => $upadata);
        //         }

        //         $disdata = $dis_data[$division->division_bbs_code];

        //         $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->division_bbs_code, 'data' => $disdata);

        //         $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); //$districtdata;  $upazilatdata;
        //         // $data['dis_upa_data'] = array_merge($upazilatdata);
        //     }
        //     $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        //  } elseif ($roleID == 34) {
        //     // Divitional Commitionar dashboard
        //     // echo 'hello'; exit;

        //     // Counter
        //     $data['total_case'] = GccAppeal::whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();

        //     $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();

        //     $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();

        //     $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('division_id', user_office_info()->division_id)->count();

        //     $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('division_id', user_office_info()->division_id)->count();

        //     $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('division_id', user_office_info()->division_id)->count();

        //     $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
        //     $data['total_user'] = DB::table('users')->count();
        //     $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
        //     $data['total_mouja'] = DB::table('mouja')->count();
        //     $data['total_ct'] = DB::table('case_type')->count();
        //     $data['total_sf_count'] = CaseRegister::orderby('id', 'desc')->where('is_sf', 1)->where('status', 1)->get()->count();
        //     $data['pending_case_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();

        //     $data['trial_date_list'] = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required',1)->whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])->where('updated_by', globalUserInfo()->id)->where('division_id', user_office_info()->division_id)->count();

        //     $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list'];

        //     $data['cases'] = DB::table('case_register')
        //         ->select('case_register.*')
        //         ->get();

        //     // Drildown Statistics
        //     $division_list = DB::table('division')
        //         ->select('division.id', 'division.division_name_bn', 'division.division_name_en')
        //         ->get();

        //     $divisiondata = array();
        //     $districtdata = array();
        //     // $dis_data=array();
        //     $upazilatdata = array();

        //     // Division List
        //     foreach ($division_list as $division) {

        //         // Division Data
        //         $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->id);

        //         // District List
        //         $district_list = DB::table('district')->select('district.id', 'district.district_name_bn')->where('division_id', $division->id)->get();
        //         foreach ($district_list as $district) {

        //             $dis_data[$division->id][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->id);

        //             // Upazila Data

        //             $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)->get();
        //             foreach ($upazila_list as $upazila) {
        //                 // $upa_count = $this->Employee_model->get_count_employees('', '', '', '', $upazila->id);
        //                 // $number3 = (int) $upa_count['count']; //exit;
        //                 $upa_data[$district->id][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
        //             }

        //             $upadata = $upa_data[$district->id];
        //             $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->id, 'data' => $upadata);
        //         }

        //         $disdata = $dis_data[$division->id];
        //         $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->id, 'data' => $disdata);

        //         $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); //$districtdata;  $upazilatdata;
        //     }
        //     // dd($result);
        //     // $data['divisiondata'] = $divisiondata;
        //     // dd($data['division_arr']);

        //     $hearingCalender = CaseHearing::select('id', 'case_id', 'hearing_comment', 'hearing_date', DB::raw('count(*) as total'))
        //         ->orderby('id', 'DESC')
        //         ->groupBy('hearing_date');
        //     $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());

        //     $data['districts'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', user_office_info()->division_id)->get();

        //     // View

        //     $appeal = GccAppeal::where('division_id', user_division())->whereIn('appeal_status', ['ON_TRIAL'])->get();
        //     // $data['appeal']  = $appeal;
        //     if ($appeal != null || $appeal != '') {
        //         foreach ($appeal as $key => $value) {
        //             $data['appeal'][$key]['appealInfo'] = AppealRepository::getAllAppealInfo($value->id);
        //             $data['appeal'][$key]['notes'] = DB::table('gcc_notes')
        //                 ->where('appeal_id', $value->id)
        //                 ->leftjoin('gcc_case_shortdecisions', 'gcc_notes.case_short_decision_id', '=', 'gcc_case_shortdecisions.id')->select('gcc_case_shortdecisions.case_short_decision', 'gcc_notes.*')
        //                 ->get();
        //             // $data["notes"] = $value->appealNotes;
        //         }
        //     } else {
        //         $data['appeal'][$key]['appealInfo'] = '';
        //         $data['appeal'][$key]['notes'] = '';
        //     }

        //     //dd(user_division());

        //     $data['page_title'] = 'আদালত';
        //     return view('dashboard.admin_div_com')->with($data);

        // }
        // if($roleID ==2){
        //  // Admin dashboard
        //     // Counter
        //     $data['total_case'] = GccAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();
        //     $data['running_case'] = GccAppeal::where('appeal_status', 'ON_TRIAL')->count();
        //     $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->count();
        //     $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_ASST_GCO', 'SEND_TO_GCO'])->count();
        //     $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->count();
        //     $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->count();
        //     $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->count();
        //     $data['total_user'] = DB::table('users')->count();
        //     $data['total_office'] = DB::table('office')->where('is_gcc', 1)->count();
        //     $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

        //     $data['cases'] = DB::table('case_register')
        //         ->select('case_register.*')
        //         ->get();

        //     // Drildown Statistics
        //     $division_list = DB::table('division')
        //         ->select('division.id', 'division.division_name_bn', 'division.division_name_en', 'division.division_bbs_code')
        //         ->get();

        //     $divisiondata = array();
        //     $districtdata = array();
        //     // $dis_data=array();
        //     $upazilatdata = array();

        //     // Division List
        //     foreach ($division_list as $division) {

        //         $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->id);

        //         // District List
        //         $district_list = DB::table('district')->select('district.id', 'district.district_name_bn', 'district.district_bbs_code')->where('division_id', $division->id)->get();
        //         foreach ($district_list as $district) {

        //             $dis_data[$division->id][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->district_bbs_code);

        //             $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)
        //                 ->where('division_id', $division->id)->get();

        //             foreach ($upazila_list as $upazila) {
        //                 $upa_data[$district->district_bbs_code][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
        //             }

        //             $upadata = $upa_data[$district->district_bbs_code];
        //             $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->district_bbs_code, 'data' => $upadata);
        //         }

        //         $disdata = $dis_data[$division->id];
        //         $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->id, 'data' => $disdata);

        //         $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata);

        //     }
        //     $hearingCalender = CaseHearing::select('id', 'case_id', 'hearing_comment', 'hearing_date', DB::raw('count(*) as total'))
        //         ->orderby('id', 'DESC')
        //         ->groupBy('hearing_date');
        //     $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());

        //     $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
        // }

        // if($roleID ==6){
        //     // DC dashboard
        //     // Counter

        //     $data['total_case'] = GccAppeal::whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DC'])->where('district_id', user_district()->id)->count();

        //     $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_DC'])->where('district_id', user_district()->id)->count();

        //     $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_DC'])->where('district_id', user_district()->id)->count();

        //     $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('district_id', user_district()->id)->count();

        //     $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('district_id', user_district()->id)->count();

        //     $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('district_id', user_office_info()->district_id)->count();

        //     $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('district_id', user_office_info()->district_id)->count();

        //     $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
        //     $data['total_user'] = DB::table('users')->count();
        //     $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
        //     $data['total_mouja'] = DB::table('mouja')->count();
        //     $data['total_ct'] = DB::table('case_type')->count();
        //     $data['total_sf_count'] = CaseRegister::orderby('id', 'desc')->where('is_sf', 1)->where('status', 1)->get()->count();

        //     $data['cases'] = DB::table('case_register')
        //         ->select('case_register.*')
        //         ->get();

        //     $data['pending_case_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_DC'])->where('district_id', user_office_info()->district_id)->count();

        //     $data['trial_date_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL_DC'])->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required',1)->where('district_id', user_office_info()->district_id)->count();

        //     $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list'];

        //     // Drildown Statistics
        //     $division_list = DB::table('division')
        //         ->select('division.id', 'division.division_name_bn', 'division.division_name_en')
        //         ->get();

        //     $divisiondata = array();
        //     $districtdata = array();
        //     // $dis_data=array();
        //     $upazilatdata = array();

        //     // Division List
        //     foreach ($division_list as $division) {
        //         // $data_arr[$item->id] = $this->get_drildown_case_count($item->id);
        //         // Division Data
        //         $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->id);

        //         // District List
        //         $district_list = DB::table('district')->select('district.id', 'district.district_name_bn')->where('division_id', $division->id)->get();
        //         foreach ($district_list as $district) {
        //             // $dis_count = $this->Employee_model->get_count_employees('', '', '', $district->id);
        //             // $number2 = (int) $dis_count['count']; //exit;
        //             $dis_data[$division->id][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->id);
        //             // Upazila Data
        //             // $upazila_list = $this->Common_model->get_data_where('upazilas', 'district_id', $district->id);
        //             $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)->get();
        //             foreach ($upazila_list as $upazila) {
        //                 // $upa_count = $this->Employee_model->get_count_employees('', '', '', '', $upazila->id);
        //                 // $number3 = (int) $upa_count['count']; //exit;
        //                 $upa_data[$district->id][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
        //             }

        //             $upadata = $upa_data[$district->id];
        //             $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->id, 'data' => $upadata);
        //         }

        //         $disdata = $dis_data[$division->id];
        //         $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->id, 'data' => $disdata);

        //         $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); //$districtdata;  $upazilatdata;
        //     }
        //     // dd($result);
        //     // $data['divisiondata'] = $divisiondata;
        //     // dd($data['division_arr']);

        //     $hearingCalender = CaseHearing::select('id', 'case_id', 'hearing_comment', 'hearing_date', DB::raw('count(*) as total'))
        //         ->orderby('id', 'DESC')
        //         ->groupBy('hearing_date');
        //     $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());

        //     $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', user_office_info()->district_id)->get();

        //     // View
        //     $data['page_title'] = 'আদালত';
        //     return view('dashboard.admin_dc')->with($data);


        // }

        if ($roleID == 27) {
            // Counter
            //   $data['total_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL', 'CLOSED'])->where('court_id', globalUserInfo()->court_id)->count();
            //   $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', globalUserInfo()->court_id)->count();
            //   $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('court_id', globalUserInfo()->court_id)->count();
            //   $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_GCO'])->where('court_id', globalUserInfo()->court_id)->count();
            //   $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('court_id', globalUserInfo()->court_id)->count();
            //   $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('court_id', globalUserInfo()->court_id)->count();
            //   $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('court_id', globalUserInfo()->court_id)->count();

            //   $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            //   $data['total_user'] = DB::table('users')->count();
            //   $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            //   $data['total_mouja'] = DB::table('mouja')->count();
            //   $data['total_ct'] = DB::table('case_type')->count();
            //   $data['pending_case_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_GCO'])->where('court_id', globalUserInfo()->court_id)->count();
            //   $data['trial_date_list'] = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required',1)->where('court_id', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->count();
            //   $data['CaseRunningCountActionRequired']=GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])
            //   ->where('court_id', globalUserInfo()->court_id)
            //   ->where('action_required', 'GCO')
            //   ->count();
            //   $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list']+$data['CaseRunningCountActionRequired'];

            // Drildown Statistics
            $division_list = DB::table('division')
                ->select('division.id', 'division.division_name_bn', 'division.division_name_en')
                ->get();

            $divisiondata = array();
            $districtdata = array();

            $upazilatdata = array();

            $appeal = GccAppeal::where('court_id', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->get();
            if (!$appeal->isEmpty()) {
                // if ($appeal != null || $appeal != '') {
                foreach ($appeal as $key => $value) {
                    $citizen_info = AppealRepository::getCauselistCitizen($value->id);
                    $notes = CertificateAsstNoteRepository::get_last_order_list($value->id);
                    if (isset($citizen_info) && !empty($citizen_info)) {
                        $citizen_info = $citizen_info;
                    } else {
                        $citizen_info = null;
                    }
                    if (isset($notes) && !empty($notes)) {
                        $notes = $notes;
                    } else {
                        $notes = null;
                    }

                    $data['appeal'][$key]['citizen_info'] = $citizen_info;
                    $data['appeal'][$key]['notes'] = $notes;
                }
            } else {

                // $data['appeal'][$key]['citizen_info'] = '';
                // $data['appeal'][$key]['notes'] = '';
                $data['appeal'] = [];
            }

            //   $hearingCalender = CaseHearing::select('id', 'case_id', 'hearing_comment', 'hearing_date', DB::raw('count(*) as total'))
            //       ->orderby('id', 'DESC')
            //       ->groupBy('hearing_date');
            //   $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());

            //   $data['running_case_paginate'] = GccAppeal::where('court_id', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->count();

            return $this->sendResponse($data, 'জিসিও');
        } elseif ($roleID == 28) {

            // asst GCO dashboard
            // Counter
            // $data['total_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL', 'CLOSED'])->where('court_id', globalUserInfo()->court_id)->count();
            // $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', globalUserInfo()->court_id)->count();
            // $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('court_id', globalUserInfo()->court_id)->count();
            // $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_ASST_GCO'])->where('court_id', globalUserInfo()->court_id)->count();

            // $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('court_id', globalUserInfo()->court_id)->count();
            // $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('court_id', globalUserInfo()->court_id)->count();
            // $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('court_id', globalUserInfo()->court_id)->count();

            // $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            // $data['total_user'] = DB::table('users')->count();
            // $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

            // $data['pending_case_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_ASST_GCO'])->where('court_id', globalUserInfo()->court_id)->count();
            // $data['trial_date_list'] = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required',1)->where('court_id', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->count();
            // $data['CaseRunningCountActionRequired']=GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])
            // ->where('court_id', globalUserInfo()->court_id)
            // ->where('action_required', 'ASST')
            // ->count();
            // $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list']+$data['CaseRunningCountActionRequired'];

            // $data['cases'] = DB::table('case_register')
            //     ->select('case_register.*')
            //     ->get();

            // Drildown Statistics
            $division_list = DB::table('division')
                ->select('division.id', 'division.division_name_bn', 'division.division_name_en')
                ->get();

            $divisiondata = array();
            $districtdata = array();
            $upazilatdata = array();

            // Division List
            // foreach ($division_list as $division) {
            //     // Division Data
            //     $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->id);

            //     // District List
            //     $district_list = DB::table('district')->select('district.id', 'district.district_name_bn')->where('division_id', $division->id)->get();
            //     foreach ($district_list as $district) {
            //         $dis_data[$division->id][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->id);
            //         // Upazila Data
            //         $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)->get();
            //         foreach ($upazila_list as $upazila) {

            //             $upa_data[$district->id][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
            //         }

            //         $upadata = $upa_data[$district->id];
            //         $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->id, 'data' => $upadata);
            //     }

            //     $disdata = $dis_data[$division->id];
            //     $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->id, 'data' => $disdata);

            //     $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); 
            // }

            $appeal = GccAppeal::where('court_id', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->get();

            // || $appeal != null || $appeal != ''
            if (!$appeal->isEmpty()) {
                foreach ($appeal as $key => $value) {
                    $citizen_info = AppealRepository::getCauselistCitizen($value->id);
                    $notes = CertificateAsstNoteRepository::get_last_order_list($value->id);
                    if (isset($citizen_info) && !empty($citizen_info)) {
                        $citizen_info = $citizen_info;
                    } else {
                        $citizen_info = null;
                    }
                    if (isset($notes) && !empty($notes)) {
                        $notes = $notes;
                    } else {
                        $notes = null;
                    }

                    $data['appeal'][$key]['citizen_info'] = $citizen_info;
                    $data['appeal'][$key]['notes'] = $notes;
                }
            } else {

                $data['appeal'] = [];
                // $data['appeal'][$key]['citizen_info'] = '';
                // $data['appeal'][$key]['notes'] = '';
            }

            // return ($appeal->isNotEmpty()?$data:$data['appeal']=[]);

            // $hearingCalender = CaseHearing::select('id', 'case_id', 'hearing_comment', 'hearing_date', DB::raw('count(*) as total'))
            //     ->orderby('id', 'DESC')
            //     ->groupBy('hearing_date');
            // $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());
            // $data['running_case_paginate'] = GccAppeal::where('court_id', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->count();

            return $this->sendResponse($data, '  সার্টিফিকেট সহকারী');
        } elseif ($roleID == 35) {


            $total_case_count_applicant = $this->total_case_applicant();
            // $data['total_case'] = $total_case_count_applicant['total_count'];
            $appeal = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case_count_applicant['appeal_id_array'])->get();

            // if ($appeal != null || $appeal != '') {
            if (!$appeal->isEmpty()) {
                foreach ($appeal as $key => $value) {
                    $citizen_info = AppealRepository::getCauselistCitizen($value->id);
                    $notes = CertificateAsstNoteRepository::get_last_order_list($value->id);
                    if (isset($citizen_info) && !empty($citizen_info)) {
                        $citizen_info = $citizen_info;
                    } else {
                        $citizen_info = null;
                    }
                    if (isset($notes) && !empty($notes)) {
                        $notes = $notes;
                    } else {
                        $notes = null;
                    }

                    $data['appeal'][$key]['citizen_info'] = $citizen_info;
                    $data['appeal'][$key]['notes'] = $notes;
                    // $data["notes"] = $value->appealNotes;
                }
            } else {

                // $data['appeal']['citizen_info'] = '';
                // $data['appeal']['notes'] = '';
                $data['appeal'] = [];
            }

            return $this->sendResponse($data, ' প্রাতিষ্ঠানিক প্রতিনিধি ');
        } elseif ($roleID == 36) {
            // dd(1);
            // if(globalUserInfo()->is_verified_account == 0 && mobile_first_registration())
            // {
            //     $data['page_title'] = 'নাগরিকের ড্যাশবোর্ড';
            //     return view('mobile_first_registration.non_verified_account')->with($data);
            // }
            // $total_running_case_count_defaulter = $this->total_running_case_count_defaulter();
            $total_case_count_defaulter = $this->total_case_count_defaulter();
            // $total_pending_case_count_defaulter = $this->total_pending_case_count_defaulter();
            // $total_completed_case_count_defaulter = $this->total_completed_case_count_defaulter();

            // $data['total_case'] = $total_case_count_defaulter['total_count'];
            // $data['running_case'] = $total_running_case_count_defaulter['total_count'];
            // $data['pending_case'] = $total_pending_case_count_defaulter['total_count'];
            // $data['completed_case'] = $total_completed_case_count_defaulter['total_count'];

            $appeal = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case_count_defaulter['appeal_id_array'])->get();

            // if ($appeal != null || $appeal != '') {
            if (!$appeal->isEmpty()) {
                foreach ($appeal as $key => $value) {
                    $citizen_info = AppealRepository::getCauselistCitizen($value->id);
                    $notes = CertificateAsstNoteRepository::get_last_order_list($value->id);
                    if (isset($citizen_info) && !empty($citizen_info)) {
                        $citizen_info = $citizen_info;
                    } else {
                        $citizen_info = null;
                    }
                    if (isset($notes) && !empty($notes)) {
                        $notes = $notes;
                    } else {
                        $notes = null;
                    }

                    $data['appeal'][$key]['citizen_info'] = $citizen_info;
                    $data['appeal'][$key]['notes'] = $notes;
                    // $data["notes"] = $value->appealNotes;
                }
            } else {

                // $data['appeal'][$key]['citizen_info'] = '';
                // $data['appeal'][$key]['notes'] = '';
                $data['appeal'] = [];
            }

            // $data['running_case_paginate'] = GccAppeal::WhereIn('ID', $total_case_count_defaulter['appeal_id_array'])->count();

            // $data['page_title'] = 'নাগরিকের ড্যাশবোর্ড';
            // // dd($data);
            // return view('dashboard.citizen')->with($data);
            return $this->sendResponse($data, ' নাগরিক ');
        }
    }


    public function total_case_applicant()
    {

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('gcc_appeal_citizens.citizen_type_id', [1, 2, 5])
            ->whereIn('gcc_appeals.appeal_status', ['CLOSED', 'ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        $appeal_id_array = [];
        $count = 0;
        foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
            array_push($appeal_id_array, $appeal_ids_from_db_single->appeal_id);
            $count++;
        }

        return ['total_count' => $count, 'appeal_id_array' => $appeal_id_array];
    }

    public function total_case_count_defaulter()
    {

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('gcc_appeal_citizens.citizen_type_id', [2, 5])
            ->whereIn('gcc_appeals.appeal_status', ['CLOSED', 'ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        $appeal_id_array = [];
        $count = 0;
        foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
            array_push($appeal_id_array, $appeal_ids_from_db_single->appeal_id);
            $count++;
        }

        return ['total_count' => $count, 'appeal_id_array' => $appeal_id_array];
    }

    public function get_drildown_case_count($division = null, $district = null, $upazila = null, $status = null)
    {
        $query = DB::table('gcc_appeals')->whereNotIn('appeal_status', ['DRAFT']);

        if ($division != null) {
            $query->where('division_id', $division);
        }
        if ($district != null) {
            $query->where('district_id', $district);
        }
        if ($upazila != null) {
            $query->where('upazila_id', $upazila);
        }

        return $query->count();
    }
}
