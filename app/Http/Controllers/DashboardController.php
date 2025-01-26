<?php

namespace App\Http\Controllers;

// use Auth;
use App\Http\Resources\calendar\CaseHearingCollection;
use App\Models\CaseHearing;

// use App\Models\AtCaseRegister;
// use App\Models\RM_CaseRgister;
use App\Models\CaseRegister;
use App\Models\GccAppeal;
use App\Repositories\AppealRepository;
use App\Repositories\CertificateAsstNoteRepository;
use App\Repositories\NDoptorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// use App\Http\Resources\calendar\RM_CaseHearingCollection;
// use App\Models\RM_CaseHearing;

// use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use App\Http\Controllers\CommonController;

class DashboardController extends Controller
{

    // use AuthenticatesUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

   
        $all_appeal = GccAppeal::where('case_no', '!=', 'অসম্পূর্ণ মামলা')->whereIn('appeal_status', ['ON_TRIAL'])->get();
        $appeal_array = [];
        foreach ($all_appeal as $appeal_single) {
            $exists =DB::table('gcc_manual_causelist')->where('case_no', '=',$appeal_single->case_no)->first();
            
            if (empty($exists)) {
                // dd($appeal_single->case_no);
                DB::table('gcc_manual_causelist')->insert([
                    'case_no'=>$appeal_single->case_no,
                    'appeal_id'=>$appeal_single->id,
                    'court_id'=>$appeal_single->court_id,
                    'division_id'=>$appeal_single->division_id,
                    'district_id'=>$appeal_single->district_id,
                    'upazila_id'=>$appeal_single->upazila_id,
                    'next_date'=>$appeal_single->next_date,
                    'type'     =>1
                ]);
            }
        }
        // NDoptorRepository::signature();
        // NDoptorRepository::profilePicture();

        $roleID = Auth::user()->role_id;
        $userID = globalUserInfo()->id;


        $user = globalUserInfo();
 
        $data = [];
        $data['rm_case_status'] = [];

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

            // Drildown Statistics
            $division_list = DB::table('division')
                ->select('division.id', 'division.division_name_bn', 'division.division_name_en', 'division.division_bbs_code')
                ->get();

            $divisiondata = array();
            $districtdata = array();
            // $dis_data=array();
            $upazilatdata = array();

            // Division List
            foreach ($division_list as $division) {

                $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->division_bbs_code);

                // District List
                $district_list = DB::table('district')->select('district.id', 'district.district_name_bn', 'district.district_bbs_code')->where('division_id', $division->id)->get();
                foreach ($district_list as $district) {

                    $dis_data[$division->division_bbs_code][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->district_bbs_code);

                    $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)
                        ->where('division_id', $division->id)->get();

                    foreach ($upazila_list as $upazila) {
                        $upa_data[$district->district_bbs_code][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
                    }

                    $upadata = $upa_data[$district->district_bbs_code];
                    $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->district_bbs_code, 'data' => $upadata);
                }

                $disdata = $dis_data[$division->division_bbs_code];
                $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->division_bbs_code, 'data' => $disdata);

                $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); //$districtdata;  $upazilatdata;
                // $data['dis_upa_data'] = array_merge($upazilatdata);
            }
            // dd($result);
            // $data['divisiondata'] = $divisiondata;
            // dd($data['division_arr']);
            //  echo 'Hello'; exit;
            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
            //  dd($data['divisions']);

            // View
            $data['page_title'] = 'সুপার অ্যাডমিন ড্যাশবোর্ড';
            return view('dashboard.superadmin')->with($data);
        } elseif ($roleID == 2) {
            // Admin dashboard
       
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
            // $data['total_mouja'] = DB::table('mouja')->count();
            // $data['total_ct'] = DB::table('case_type')->count();
            // $data['total_sf_count'] = CaseRegister::orderby('id', 'desc')->where('is_sf', 1)->where('status', 1)->get()->count();

            $data['cases'] = DB::table('case_register')
                ->select('case_register.*')
                ->get();

            // Drildown Statistics
            $division_list = DB::table('division')
                ->select('division.id', 'division.division_name_bn', 'division.division_name_en', 'division.division_bbs_code')
                ->get();

            $divisiondata = array();
            $districtdata = array();
            // $dis_data=array();
            $upazilatdata = array();

            // Division List
            foreach ($division_list as $division) {

                $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->id);

                // District List
                $district_list = DB::table('district')->select('district.id', 'district.district_name_bn', 'district.district_bbs_code')->where('division_id', $division->id)->get();
                foreach ($district_list as $district) {

                    $dis_data[$division->id][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->district_bbs_code);

                    $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)
                        ->where('division_id', $division->id)->get();

                    foreach ($upazila_list as $upazila) {
                        $upa_data[$district->district_bbs_code][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
                    }

                    $upadata = $upa_data[$district->district_bbs_code];
                    $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->district_bbs_code, 'data' => $upadata);
                }

                $disdata = $dis_data[$division->id];
                $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->id, 'data' => $disdata);

                $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); //$districtdata;  $upazilatdata;
                // $data['dis_upa_data'] = array_merge($upazilatdata);
            }
            // dd($result);
            // $data['divisiondata'] = $divisiondata;
            // dd($data['division_arr']);

            $hearingCalender = CaseHearing::select('id', 'case_id', 'hearing_comment', 'hearing_date', DB::raw('count(*) as total'))
                ->orderby('id', 'DESC')
                ->groupBy('hearing_date');
            $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());

            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

            // View
            $data['page_title'] = 'মনিটরিং অ্যাডমিনের ড্যাশবোর্ড';
            return view('dashboard.monitoring_admin')->with($data);
        } elseif ($roleID == 6) {
            // DC dashboard
            // Counter

            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DC'])->where('district_id', user_district()->id)->count();

            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_DC'])->where('district_id', user_district()->id)->count();

            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_DC'])->where('district_id', user_district()->id)->count();

            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('district_id', user_district()->id)->count();

            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('district_id', user_district()->id)->count();

            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('district_id', user_office_info()->district_id)->count();

            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('district_id', user_office_info()->district_id)->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();
            $data['total_sf_count'] = CaseRegister::orderby('id', 'desc')->where('is_sf', 1)->where('status', 1)->get()->count();

            $data['cases'] = DB::table('case_register')
                ->select('case_register.*')
                ->get();

            $data['pending_case_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_DC'])->where('district_id', user_office_info()->district_id)->count();

            $data['trial_date_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL_DC'])->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('district_id', user_office_info()->district_id)->count();

            $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list'];

            // Drildown Statistics
            $division_list = DB::table('division')
                ->select('division.id', 'division.division_name_bn', 'division.division_name_en')
                ->get();

            $divisiondata = array();
            $districtdata = array();
            // $dis_data=array();
            $upazilatdata = array();

            // Division List
            foreach ($division_list as $division) {
                // $data_arr[$item->id] = $this->get_drildown_case_count($item->id);
                // Division Data
                $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->id);

                // District List
                $district_list = DB::table('district')->select('district.id', 'district.district_name_bn')->where('division_id', $division->id)->get();
                foreach ($district_list as $district) {
                    // $dis_count = $this->Employee_model->get_count_employees('', '', '', $district->id);
                    // $number2 = (int) $dis_count['count']; //exit;
                    $dis_data[$division->id][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->id);
                    // Upazila Data
                    // $upazila_list = $this->Common_model->get_data_where('upazilas', 'district_id', $district->id);
                    $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)->get();
                    foreach ($upazila_list as $upazila) {
                        // $upa_count = $this->Employee_model->get_count_employees('', '', '', '', $upazila->id);
                        // $number3 = (int) $upa_count['count']; //exit;
                        $upa_data[$district->id][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
                    }

                    $upadata = $upa_data[$district->id];
                    $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->id, 'data' => $upadata);
                }

                $disdata = $dis_data[$division->id];
                $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->id, 'data' => $disdata);

                $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); //$districtdata;  $upazilatdata;
            }
            // dd($result);
            // $data['divisiondata'] = $divisiondata;
            // dd($data['division_arr']);

            $hearingCalender = CaseHearing::select('id', 'case_id', 'hearing_comment', 'hearing_date', DB::raw('count(*) as total'))
                ->orderby('id', 'DESC')
                ->groupBy('hearing_date');
            $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());

            $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', user_office_info()->district_id)->get();

            // View
            $data['page_title'] = 'আদালত';
            return view('dashboard.admin_dc')->with($data);
        } elseif ($roleID == 7) {
            // DC dashboard
            // Counter

            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DC'])->where('district_id', user_district()->id)->count();

            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_DC'])->where('district_id', user_district()->id)->count();

            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_DC'])->where('district_id', user_district()->id)->count();

            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('district_id', user_district()->id)->count();

            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('district_id', user_district()->id)->count();

            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('district_id', user_office_info()->district_id)->count();

            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('district_id', user_office_info()->district_id)->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();
            $data['total_sf_count'] = CaseRegister::orderby('id', 'desc')->where('is_sf', 1)->where('status', 1)->get()->count();

            $data['cases'] = DB::table('case_register')
                ->select('case_register.*')
                ->get();

            $data['pending_case_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_DC'])->where('district_id', user_office_info()->district_id)->count();

            $data['trial_date_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL_DC'])->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('district_id', user_office_info()->district_id)->count();

            $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list'];

            // Drildown Statistics
            $division_list = DB::table('division')
                ->select('division.id', 'division.division_name_bn', 'division.division_name_en')
                ->get();

            $divisiondata = array();
            $districtdata = array();
            // $dis_data=array();
            $upazilatdata = array();

            // Division List
            foreach ($division_list as $division) {
                // $data_arr[$item->id] = $this->get_drildown_case_count($item->id);
                // Division Data
                $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->id);

                // District List
                $district_list = DB::table('district')->select('district.id', 'district.district_name_bn')->where('division_id', $division->id)->get();
                foreach ($district_list as $district) {
                    // $dis_count = $this->Employee_model->get_count_employees('', '', '', $district->id);
                    // $number2 = (int) $dis_count['count']; //exit;
                    $dis_data[$division->id][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->id);
                    // Upazila Data
                    // $upazila_list = $this->Common_model->get_data_where('upazilas', 'district_id', $district->id);
                    $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)->get();
                    foreach ($upazila_list as $upazila) {
                        // $upa_count = $this->Employee_model->get_count_employees('', '', '', '', $upazila->id);
                        // $number3 = (int) $upa_count['count']; //exit;
                        $upa_data[$district->id][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
                    }

                    $upadata = $upa_data[$district->id];
                    $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->id, 'data' => $upadata);
                }

                $disdata = $dis_data[$division->id];
                $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->id, 'data' => $disdata);

                $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); //$districtdata;  $upazilatdata;
            }
            // dd($result);
            // $data['divisiondata'] = $divisiondata;
            // dd($data['division_arr']);

            $hearingCalender = CaseHearing::select('id', 'case_id', 'hearing_comment', 'hearing_date', DB::raw('count(*) as total'))
                ->orderby('id', 'DESC')
                ->groupBy('hearing_date');
            $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());

            $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', user_office_info()->district_id)->get();

            // View
            $data['page_title'] = 'আদালত';
            return view('dashboard.admin_dc')->with($data);
        } elseif ($roleID == 8) {
            // Admin dashboard
            // Counter
            // dd('come');
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
            // $data['total_mouja'] = DB::table('mouja')->count();
            // $data['total_ct'] = DB::table('case_type')->count();
            // $data['total_sf_count'] = CaseRegister::orderby('id', 'desc')->where('is_sf', 1)->where('status', 1)->get()->count();

            $data['cases'] = DB::table('case_register')
                ->select('case_register.*')
                ->get();

            // Drildown Statistics
            $division_list = DB::table('division')
                ->select('division.id', 'division.division_name_bn', 'division.division_name_en', 'division.division_bbs_code')
                ->get();

            $divisiondata = array();
            $districtdata = array();
            // $dis_data=array();
            $upazilatdata = array();

            // Division List
            foreach ($division_list as $division) {

                $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->id);

                // District List
                $district_list = DB::table('district')->select('district.id', 'district.district_name_bn', 'district.district_bbs_code')->where('division_id', $division->id)->get();
                foreach ($district_list as $district) {

                    $dis_data[$division->id][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->district_bbs_code);

                    $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)
                        ->where('division_id', $division->id)->get();

                    foreach ($upazila_list as $upazila) {
                        $upa_data[$district->district_bbs_code][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
                    }

                    $upadata = $upa_data[$district->district_bbs_code];
                    $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->district_bbs_code, 'data' => $upadata);
                }

                $disdata = $dis_data[$division->id];
                $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->id, 'data' => $disdata);

                $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); //$districtdata;  $upazilatdata;
                // $data['dis_upa_data'] = array_merge($upazilatdata);
            }
            // dd($result);
            // $data['divisiondata'] = $divisiondata;
            // dd($data['division_arr']);

            $hearingCalender = CaseHearing::select('id', 'case_id', 'hearing_comment', 'hearing_date', DB::raw('count(*) as total'))
                ->orderby('id', 'DESC')
                ->groupBy('hearing_date');
            $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());

            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

            $data['page_title'] = 'আদালত';
            return view('dashboard.Cabinet_dashboard')->with($data);
        } elseif ($roleID == 14) {
            // Solicitor
            // Get case status by group
            // Counter
            $data['total_case'] = DB::table('case_register')->count();
            $data['running_case'] = DB::table('case_register')->where('status', 1)->count();
            $data['appeal_case'] = DB::table('case_register')->where('status', 2)->count();
            $data['completed_case'] = DB::table('case_register')->where('status', 3)->count();
            // dd($data['case_status']);

            $data['page_title'] = 'আইনজীবীর ড্যাশবোর্ড';
            return view('dashboard.ulao')->with($data);
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

            $data['cases'] = DB::table('case_register')
                ->select('case_register.*')
                ->get();

            // Drildown Statistics
            $division_list = DB::table('division')
                ->select('division.id', 'division.division_name_bn', 'division.division_name_en')
                ->get();

            $divisiondata = array();
            $districtdata = array();
            // $dis_data=array();
            $upazilatdata = array();

            // Division List
            foreach ($division_list as $division) {
                // $data_arr[$item->id] = $this->get_drildown_case_count($item->id);
                // Division Data
                $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->id);

                // District List
                $district_list = DB::table('district')->select('district.id', 'district.district_name_bn')->where('division_id', $division->id)->get();
                foreach ($district_list as $district) {
                    // $dis_count = $this->Employee_model->get_count_employees('', '', '', $district->id);
                    // $number2 = (int) $dis_count['count']; //exit;
                    $dis_data[$division->id][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->id);

                    // Upazila Data
                    // $upazila_list = $this->Common_model->get_data_where('upazilas', 'district_id', $district->id);
                    $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)->get();
                    foreach ($upazila_list as $upazila) {
                        // $upa_count = $this->Employee_model->get_count_employees('', '', '', '', $upazila->id);
                        // $number3 = (int) $upa_count['count']; //exit;
                        $upa_data[$district->id][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
                    }

                    $upadata = $upa_data[$district->id];
                    $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->id, 'data' => $upadata);
                }

                $disdata = $dis_data[$division->id];
                $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->id, 'data' => $disdata);

                $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); //$districtdata;  $upazilatdata;
            }
            // dd($result);
            // $data['divisiondata'] = $divisiondata;
            // dd($data['division_arr']);

            $hearingCalender = CaseHearing::select('id', 'case_id', 'hearing_comment', 'hearing_date', DB::raw('count(*) as total'))
                ->orderby('id', 'DESC')
                ->groupBy('hearing_date');
            $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());

            // View
            $data['page_title'] = 'আদালত';
            return view('dashboard.superadmin')->with($data);
        } elseif ($roleID == 25) {
            // LAB dashboard
            // Counter
            // dd(Auth::user()->office_id);
            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_LAB_CM', 'CLOSED'])->where('updated_by', globalUserInfo()->id)->count();

            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_LAB_CM'])->count();

            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_LAB_CM'])->where('updated_by', globalUserInfo()->id)->count();

            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('updated_by', globalUserInfo()->id)->count();

            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('updated_by', globalUserInfo()->id)->count();

            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->count();
            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();
            $data['total_sf_count'] = CaseRegister::orderby('id', 'desc')->where('is_sf', 1)->where('status', 1)->get()->count();

            $data['cases'] = DB::table('case_register')
                ->select('case_register.*')
                ->get();

            $data['pending_case_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_LAB_CM'])->count();

            $data['trial_date_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL_LAB_CM'])->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->count();
            $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list'];

            // Drildown Statistics
            $division_list = DB::table('division')
                ->select('division.id', 'division.division_name_bn', 'division.division_name_en')
                ->get();

            $divisiondata = array();
            $districtdata = array();
            // $dis_data=array();
            $upazilatdata = array();

            // Division List
            foreach ($division_list as $division) {
                // $data_arr[$item->id] = $this->get_drildown_case_count($item->id);
                // Division Data
                $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->id);

                // District List
                $district_list = DB::table('district')->select('district.id', 'district.district_name_bn')->where('division_id', $division->id)->get();
                foreach ($district_list as $district) {
                    // $dis_count = $this->Employee_model->get_count_employees('', '', '', $district->id);
                    // $number2 = (int) $dis_count['count']; //exit;
                    $dis_data[$division->id][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->id);

                    // Upazila Data
                    // $upazila_list = $this->Common_model->get_data_where('upazilas', 'district_id', $district->id);
                    $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)->get();
                    foreach ($upazila_list as $upazila) {
                        // $upa_count = $this->Employee_model->get_count_employees('', '', '', '', $upazila->id);
                        // $number3 = (int) $upa_count['count']; //exit;
                        $upa_data[$district->id][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
                    }

                    $upadata = $upa_data[$district->id];
                    $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->id, 'data' => $upadata);
                }

                $disdata = $dis_data[$division->id];
                $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->id, 'data' => $disdata);

                $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); //$districtdata;  $upazilatdata;

            }
            // dd($result);
            // $data['divisiondata'] = $divisiondata;
            // dd($data['division_arr']);

            $hearingCalender = CaseHearing::select('id', 'case_id', 'hearing_comment', 'hearing_date', DB::raw('count(*) as total'))
                ->orderby('id', 'DESC')
                ->groupBy('hearing_date');
            $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());

            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
            // dd('come here');

            // View
            $data['page_title'] = 'আদালত';
            return view('dashboard.admin_lab')->with($data);
        } elseif ($roleID == 27) {
            // Gco dashboard
            // Counter
            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL', 'CLOSED'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('court_id', globalUserInfo()->court_id)->count();
            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_GCO'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('court_id', globalUserInfo()->court_id)->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('court_id', globalUserInfo()->court_id)->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('court_id', globalUserInfo()->court_id)->count();
            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();
            $data['pending_case_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_GCO'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['trial_date_list'] = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('court_id', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->count();
            $data['CaseRunningCountActionRequired'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])
                ->where('court_id', globalUserInfo()->court_id)
                ->where('action_required', 'GCO')
                ->count();
            $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list'] + $data['CaseRunningCountActionRequired'];
            /*$data['cases'] = DB::table('case_register')
            ->select('case_register.*')
            ->get();*/

            // Drildown Statistics
            $division_list = DB::table('division')
                ->select('division.id', 'division.division_name_bn', 'division.division_name_en')
                ->get();

            $divisiondata = array();
            $districtdata = array();
            // $dis_data=array();
            $upazilatdata = array();
            
            /*****
             * This is needed when a2i said no need latest one 
             */

            // $appeal = GccAppeal::where('court_id', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->limit(10)->get();
  
            // if ($appeal != null || $appeal != '') {
            //     foreach ($appeal as $key => $value) {
            //         $citizen_info = AppealRepository::getCauselistCitizen($value->id);
            //         $notes = CertificateAsstNoteRepository::get_last_order_list($value->id);
            //         if (isset($citizen_info) && !empty($citizen_info)) {
            //             $citizen_info = $citizen_info;
            //         } else {
            //             $citizen_info = null;
            //         }
            //         if (isset($notes) && !empty($notes)) {
            //             $notes = $notes;
            //         } else {
            //             $notes = null;
            //         }

            //         $data['appeal'][$key]['citizen_info'] = $citizen_info;
            //         $data['appeal'][$key]['notes'] = $notes;
                    
            //     }
            // } else {

            //     $data['appeal'][$key]['citizen_info'] = '';
            //     $data['appeal'][$key]['notes'] = '';
            // }

            
       
            $causelistdata = DB::table('gcc_manual_causelist')
            ->leftJoin('gcc_appeals', 'gcc_appeals.id', '=', 'gcc_manual_causelist.appeal_id')
            ->leftJoin('custom_causelist', 'custom_causelist.id', '=', 'gcc_manual_causelist.causelist_id')
            ->select('gcc_appeals.appeal_status','gcc_appeals.next_date','gcc_appeals.case_entry_type','gcc_appeals.manual_case_no','gcc_manual_causelist.case_no as caseno','gcc_manual_causelist.appeal_id as appealid',
            'gcc_manual_causelist.type','gcc_manual_causelist.causelist_id','gcc_manual_causelist.division_id',
            'gcc_manual_causelist.district_id','gcc_manual_causelist.court_id','gcc_manual_causelist.next_date','custom_causelist.defaulter_name','custom_causelist.org_representative')
            ->where('gcc_manual_causelist.court_id', globalUserInfo()->court_id);
            $data['appeal']=$causelistdata->orderBy('gcc_manual_causelist.id','desc')->paginate(10)->withQueryString();
           
            $hearingCalender = CaseHearing::select('id', 'case_id', 'hearing_comment', 'hearing_date', DB::raw('count(*) as total'))
                ->orderby('id', 'DESC')
                ->groupBy('hearing_date');
            $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());

            $data['running_case_paginate'] = GccAppeal::where('court_id', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->count();

            // return $data;
            // View
            $data['page_title'] = 'জেনারেল সার্টিফিকেট অফিসার ড্যাশবোর্ড';
            return view('dashboard.gco')->with($data);
        } elseif ($roleID == 28) {
            // asst GCO dashboard
            // Counter
            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL', 'CLOSED'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('court_id', globalUserInfo()->court_id)->count();
            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_ASST_GCO'])->where('court_id', globalUserInfo()->court_id)->count();

            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('court_id', globalUserInfo()->court_id)->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('court_id', globalUserInfo()->court_id)->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('court_id', globalUserInfo()->court_id)->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

            $data['pending_case_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_ASST_GCO'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['trial_date_list'] = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->where('court_id', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->count();
            $data['CaseRunningCountActionRequired'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])
                ->where('court_id', globalUserInfo()->court_id)
                ->where('action_required', 'ASST')
                ->count();
            $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list'] + $data['CaseRunningCountActionRequired'];

            $data['cases'] = DB::table('case_register')
                ->select('case_register.*')
                ->get();

            // Drildown Statistics
            $division_list = DB::table('division')
                ->select('division.id', 'division.division_name_bn', 'division.division_name_en')
                ->get();

            $divisiondata = array();
            $districtdata = array();
            // $dis_data=array();
            $upazilatdata = array();

            // Division List
            foreach ($division_list as $division) {
                // $data_arr[$item->id] = $this->get_drildown_case_count($item->id);
                // Division Data
                $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->id);

                // District List
                $district_list = DB::table('district')->select('district.id', 'district.district_name_bn')->where('division_id', $division->id)->get();
                foreach ($district_list as $district) {
                    // $dis_count = $this->Employee_model->get_count_employees('', '', '', $district->id);
                    // $number2 = (int) $dis_count['count']; //exit;
                    $dis_data[$division->id][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->id);

                    // Upazila Data
                    // $upazila_list = $this->Common_model->get_data_where('upazilas', 'district_id', $district->id);
                    $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)->get();
                    foreach ($upazila_list as $upazila) {
                        // $upa_count = $this->Employee_model->get_count_employees('', '', '', '', $upazila->id);
                        // $number3 = (int) $upa_count['count']; //exit;
                        $upa_data[$district->id][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
                    }

                    $upadata = $upa_data[$district->id];
                    $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->id, 'data' => $upadata);
                }

                $disdata = $dis_data[$division->id];
                $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->id, 'data' => $disdata);

                $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); //$districtdata;  $upazilatdata;
            }
           
           

            $causelistdata = DB::table('gcc_manual_causelist')
            ->leftJoin('gcc_appeals', 'gcc_appeals.id', '=', 'gcc_manual_causelist.appeal_id')
            ->leftJoin('custom_causelist', 'custom_causelist.id', '=', 'gcc_manual_causelist.causelist_id')
            ->select('gcc_appeals.appeal_status','gcc_appeals.next_date','gcc_appeals.case_entry_type','gcc_appeals.manual_case_no', 'gcc_manual_causelist.case_no as caseno','gcc_manual_causelist.appeal_id as appealid',
            'gcc_manual_causelist.type','gcc_manual_causelist.causelist_id','gcc_manual_causelist.division_id',
            'gcc_manual_causelist.district_id','gcc_manual_causelist.court_id','gcc_manual_causelist.next_date','custom_causelist.defaulter_name','custom_causelist.org_representative')
            ->where('gcc_manual_causelist.court_id', globalUserInfo()->court_id);
            $data['appeal']=$causelistdata->orderBy('gcc_manual_causelist.id','desc')->paginate(10)->withQueryString();
           
           
            $hearingCalender = CaseHearing::select('id', 'case_id', 'hearing_comment', 'hearing_date', DB::raw('count(*) as total'))
                ->orderby('id', 'DESC')
                ->groupBy('hearing_date');
            $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());
            $data['running_case_paginate'] = GccAppeal::where('court_id', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->count();
            // View
            $data['page_title'] = 'সার্টিফিকেট সহকারী ড্যাশবোর্ড';
            // dd($data);
            return view('dashboard.certificate_assistent')->with($data);
        } elseif ($roleID == 32) {
            $moujaIDs = $this->get_mouja_by_ulo_office_id(Auth::user()->office_id);
            // ULAO office
            // Counter
            // Counter
            $data['total_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->count();
            $data['running_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 1)->count();
            $data['appeal_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 2)->count();
            $data['completed_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 3)->count();

            $data['cases'] = DB::table('case_register')
                ->select('case_register.*')
                ->get();
            // echo $roleID; exit;

            // Get case status by group
            $data['CaseCrockCount'] = DB::table('gcc_case_shortdecision_templates')
                ->where('gcc_case_shortdecision_templates.case_shortdecision_id', '=', 9)
                ->count();

            $data['notifications'] = $data['CaseCrockCount'];
            $data['case_status'] = DB::table('case_register')
                ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                ->groupBy('case_register.cs_id')
                ->whereIn('case_register.mouja_id', $moujaIDs)
                ->where('case_register.action_user_group_id', $roleID)
                ->get();

            // dd($data['case_status']);

            $data['page_title'] = 'আদালত';
            return view('dashboard.admin')->with($data);
        } elseif ($roleID == 33) {
            $moujaIDs = $this->get_mouja_by_ulo_office_id(Auth::user()->office_id);
            // ULAO office
            // Counter
            // Counter
            $data['total_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->count();
            $data['running_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 1)->count();
            $data['appeal_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 2)->count();
            $data['completed_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 3)->count();

            $data['cases'] = DB::table('case_register')
                ->select('case_register.*')
                ->get();
            // echo $roleID; exit;

            // Get case status by group
            $data['CaseWarrentCount'] = DB::table('gcc_case_shortdecision_templates')
                ->where('gcc_case_shortdecision_templates.case_shortdecision_id', '=', 7)
                ->count();

            $data['notifications'] = $data['CaseWarrentCount'];
            // $data['case_status'] = DB::table('case_register')
            // ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
            // ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
            // ->groupBy('case_register.cs_id')
            // ->whereIn('case_register.mouja_id', $moujaIDs)
            // ->where('case_register.action_user_group_id', $roleID)
            // ->get();

            // dd($data['case_status']);

            $data['page_title'] = 'আদালত';
            return view('dashboard.admin')->with($data);
        } elseif ($roleID == 34) {
            // Divitional Commitionar dashboard
            // echo 'hello'; exit;
            // dd(Auth::user()->office_id);
            // 

            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();

            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();

            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();

            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('division_id', user_office_info()->division_id)->count();

            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('division_id', user_office_info()->division_id)->count();

            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('division_id', user_office_info()->division_id)->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();
            $data['total_sf_count'] = CaseRegister::orderby('id', 'desc')->where('is_sf', 1)->where('status', 1)->get()->count();
            $data['pending_case_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();

            $data['trial_date_list'] = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('is_hearing_required', 1)->whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])->where('updated_by', globalUserInfo()->id)->where('division_id', user_office_info()->division_id)->count();

            $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list'];

            $data['cases'] = DB::table('case_register')
                ->select('case_register.*')
                ->get();

            // Drildown Statistics
            $division_list = DB::table('division')
                ->select('division.id', 'division.division_name_bn', 'division.division_name_en')
                ->get();

            $divisiondata = array();
            $districtdata = array();
            // $dis_data=array();
            $upazilatdata = array();

            // Division List
            foreach ($division_list as $division) {
                // $data_arr[$item->id] = $this->get_drildown_case_count($item->id);
                // Division Data
                $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->id);

                // District List
                $district_list = DB::table('district')->select('district.id', 'district.district_name_bn')->where('division_id', $division->id)->get();
                foreach ($district_list as $district) {
                    // $dis_count = $this->Employee_model->get_count_employees('', '', '', $district->id);
                    // $number2 = (int) $dis_count['count']; //exit;
                    $dis_data[$division->id][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->id);

                    // Upazila Data
                    // $upazila_list = $this->Common_model->get_data_where('upazilas', 'district_id', $district->id);
                    $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)->get();
                    foreach ($upazila_list as $upazila) {
                        // $upa_count = $this->Employee_model->get_count_employees('', '', '', '', $upazila->id);
                        // $number3 = (int) $upa_count['count']; //exit;
                        $upa_data[$district->id][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
                    }

                    $upadata = $upa_data[$district->id];
                    $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->id, 'data' => $upadata);
                }

                $disdata = $dis_data[$division->id];
                $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->id, 'data' => $disdata);

                $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); //$districtdata;  $upazilatdata;
            }
            // dd($result);
            // $data['divisiondata'] = $divisiondata;
            // dd($data['division_arr']);

            $hearingCalender = CaseHearing::select('id', 'case_id', 'hearing_comment', 'hearing_date', DB::raw('count(*) as total'))
                ->orderby('id', 'DESC')
                ->groupBy('hearing_date');
            $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());

            $data['districts'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', user_office_info()->division_id)->get();

            // View

            $appeal = GccAppeal::where('division_id', user_division())->whereIn('appeal_status', ['ON_TRIAL'])->get();
            // $data['appeal']  = $appeal;
            if ($appeal != null || $appeal != '') {
                foreach ($appeal as $key => $value) {
                    $data['appeal'][$key]['appealInfo'] = AppealRepository::getAllAppealInfo($value->id);
                    $data['appeal'][$key]['notes'] = DB::table('gcc_notes')
                        ->where('appeal_id', $value->id)
                        ->leftjoin('gcc_case_shortdecisions', 'gcc_notes.case_short_decision_id', '=', 'gcc_case_shortdecisions.id')->select('gcc_case_shortdecisions.case_short_decision', 'gcc_notes.*')
                        ->get();
                    // $data["notes"] = $value->appealNotes;
                }
            } else {
                $data['appeal'][$key]['appealInfo'] = '';
                $data['appeal'][$key]['notes'] = '';
            }

            //dd(user_division());

            $data['page_title'] = 'আদালত';
            return view('dashboard.admin_div_com')->with($data);
        } elseif ($roleID == 35) {

            if (globalUserInfo()->is_verified_account == 0 && mobile_first_registration()) {

                $data['page_title'] = 'প্রাতিষ্ঠানিক কর্মকর্তার ড্যাশবোর্ড';
                return view('mobile_first_registration.non_verified_account')->with($data);
            }

            $total_running_case_count_applicant = $this->total_running_case_count_applicant();
            $total_case_count_applicant = $this->total_case_count_applicant();
            $total_pending_case_count_applicant = $this->total_pending_case_count_applicant();
            $total_completed_case_count_applicant = $this->total_completed_case_count_applicant();

            $data['total_case'] = $total_case_count_applicant['total_count'];
            $data['running_case'] = $total_running_case_count_applicant['total_count'];
            $data['pending_case'] = $total_pending_case_count_applicant['total_count'];
            $data['completed_case'] = $total_completed_case_count_applicant['total_count'];

            $appeal = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case_count_applicant['appeal_id_array'])->limit(10)->get();

            if ($appeal != null || $appeal != '') {
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

                $data['appeal'][$key]['citizen_info'] = '';
                $data['appeal'][$key]['notes'] = '';
            }
            // return $data['appeal'][$key]['appealInfo']['appeal']->case_no;
            // return $data;
            // dd($data['case_status']);
            $data['running_case_paginate'] = GccAppeal::WhereIn('ID', $total_case_count_applicant['appeal_id_array'])->count();
            $data['page_title'] = 'প্রাতিষ্ঠানিক কর্মকর্তার ড্যাশবোর্ড';
            return view('dashboard.organization')->with($data);
        } elseif ($roleID == 36) {
            // dd(1);
            if (globalUserInfo()->is_verified_account == 0 && mobile_first_registration()) {
                $data['page_title'] = 'নাগরিকের ড্যাশবোর্ড';
                return view('mobile_first_registration.non_verified_account')->with($data);
            }
            $total_running_case_count_defaulter = $this->total_running_case_count_defaulter();
            $total_case_count_defaulter = $this->total_case_count_defaulter();
            $total_pending_case_count_defaulter = $this->total_pending_case_count_defaulter();
            $total_completed_case_count_defaulter = $this->total_completed_case_count_defaulter();

            $data['total_case'] = $total_case_count_defaulter['total_count'];
            $data['running_case'] = $total_running_case_count_defaulter['total_count'];
            $data['pending_case'] = $total_pending_case_count_defaulter['total_count'];
            $data['completed_case'] = $total_completed_case_count_defaulter['total_count'];

            $appeal = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case_count_defaulter['appeal_id_array'])->limit(10)->get();

            if ($appeal != null || $appeal != '') {
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

                $data['appeal'][$key]['citizen_info'] = '';
                $data['appeal'][$key]['notes'] = '';
            }

            $data['running_case_paginate'] = GccAppeal::WhereIn('ID', $total_case_count_defaulter['appeal_id_array'])->count();

            $data['page_title'] = 'নাগরিকের ড্যাশবোর্ড';
            // dd($data);
            return view('dashboard.citizen')->with($data);
        }
    }

    public function ajaxCaseStatus(Request $request)
    {
        // dd($request->division);
        // Get Data
        $roleID = Auth::user()->role_id;
        $result = [];
        $str = '';
        $data['division'] = $request->division;
        $data['district'] = $request->district;
        $data['upazila'] = $request->upazila;
        // Convert DB date formate
        $data['dateFrom'] = isset($request->dateFrom) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateFrom))) : null;
        $data['dateTo'] = isset($request->dateTo) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateTo))) : null;

        // Data filtering
        if ($request) {
            if ($roleID == 2 || $roleID == 25) { // Superadmin

                if ($request->division) {
                    $divisionName = $division = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;
                    $str = $divisionName . ' বিভাগের ';
                }
                if ($request->district) {
                    $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
                    $str .= $districtName . ' জেলার ';
                }
                if ($request->upazila) {
                    $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                    $str .= $upazilaName . ' উপজেলা/থানার ';
                }

                if ($request->division) {

                    $str .= 'তথ্য';
                }
            } elseif ($roleID == 34) { // Divitional Comm.
                if ($request->district) {
                    $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
                    $str = $districtName . ' জেলার তথ্য';
                }
            } elseif ($roleID == 6) { // DC
                if ($request->upazila) {
                    $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                    $str = $upazilaName . ' উপজেলা/থানার তথ্য';
                }
            }

            // Get Statistics
            $result['ON_TRIAL'] = $this->statistics_case_status('ON_TRIAL', $data);
            $result['SEND_TO_GCO'] = $this->statistics_case_status('SEND_TO_GCO', $data);
            $result['SEND_TO_ASST_GCO'] = $this->statistics_case_status('SEND_TO_ASST_GCO', $data);
            $result['SEND_TO_DC'] = $this->statistics_case_status('SEND_TO_DC', $data);
            $result['SEND_TO_DIV_COM'] = $this->statistics_case_status('SEND_TO_DIV_COM', $data);
            $result['SEND_TO_LAB_CM'] = $this->statistics_case_status('SEND_TO_LAB_CM', $data);
            $result['CLOSED'] = $this->statistics_case_status('CLOSED', $data);
            $result['REJECTED'] = $this->statistics_case_status('REJECTED', $data);
            $result['ON_TRIAL_DC'] = $this->statistics_case_status('ON_TRIAL_DC', $data);
            $result['ON_TRIAL_DIV_COM'] = $this->statistics_case_status('ON_TRIAL_DIV_COM', $data);
            $result['ON_TRIAL_LAB_CM'] = $this->statistics_case_status('ON_TRIAL_LAB_CM', $data);
        } else {
            if ($roleID == 2 || $roleID == 25) { // Superadmin

                if ($request->division) {
                    $divisionName = $division = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;
                    $str = $divisionName . ' বিভাগের ';
                }
                if ($request->district) {
                    $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
                    $str .= $districtName . ' জেলার ';
                }
                if ($request->upazila) {
                    $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                    $str .= $upazilaName . ' উপজেলা/থানার ';
                }

                if ($request->division) {

                    $str .= 'তথ্য';
                }
            } elseif ($roleID == 34) { // Divitional Comm.
                $str = 'সকল জেলার তথ্য';
            } elseif ($roleID == 6) { // DC
                $str = 'সকল উপজেলা/থানার তথ্য';
            }

            $result['ON_TRIAL'] = $this->statistics_case_status('ON_TRIAL', '');
            $result['SEND_TO_GCO'] = $this->statistics_case_status('SEND_TO_GCO', '');
            $result['SEND_TO_ASST_GCO'] = $this->statistics_case_status('SEND_TO_ASST_GCO', '');
            $result['SEND_TO_DC'] = $this->statistics_case_status('SEND_TO_DC', '');
            $result['SEND_TO_DIV_COM'] = $this->statistics_case_status('SEND_TO_DIV_COM', $data);
            $result['SEND_TO_LAB_CM'] = $this->statistics_case_status('SEND_TO_LAB_CM', $data);
            $result['CLOSED'] = $this->statistics_case_status('CLOSED', '');
            $result['REJECTED'] = $this->statistics_case_status('REJECTED', '');
            $result['ON_TRIAL_DC'] = $this->statistics_case_status('ON_TRIAL_DC', '');
            $result['ON_TRIAL_DIV_COM'] = $this->statistics_case_status('ON_TRIAL_DIV_COM', '');
            $result['ON_TRIAL_LAB_CM'] = $this->statistics_case_status('ON_TRIAL_LAB_CM', '');
        }
        // print_r($result); exit;

        return response()->json(['msg' => $str, 'data' => $result]);
    }

    public function ajaxPieChart(Request $request)
    {
        $roleID = Auth::user()->role_id;
        $result = [];
        $str = '';
        $data['division'] = $request->division;
        $data['district'] = $request->district;
        $data['upazila'] = $request->upazila;
        $totalClaimed = 0;
        $totalReceived = 0;
        // Convert DB date formate
        $data['dateFrom'] = isset($request->dateFrom) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateFrom))) : null;
        $data['dateTo'] = isset($request->dateTo) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateTo))) : null;

        // Data filtering   
        if (!empty($request->division) && empty($request->district) && empty($request->district)) {
            $totalClaimed = 0;
            $totalReceived = 0;
            $divisionName = $division = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;
            $data['districts'] = DB::table('district')->where('division_id', $request->division)->select('id', 'district_name_bn')->get();
            foreach ($data['districts'] as $key => $value) {
                $data['results'][$key]['district_name_bn'] = $value->district_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $claimed = $this->statistics_pament_claimed_by_district($value->id, $data);
                $received = $this->statistics_payment_received_by_district($value->id, $data);
                $data['results'][$key]['claimed'] = $claimed;
                $data['results'][$key]['received'] = $received;
                $totalClaimed += $claimed;
                $totalReceived += $received;
            }
            $data['totalClaimed'] = $totalClaimed;
            $data['totalReceived'] = $totalReceived;
        } elseif (!empty($request->division) && !empty($request->district) && empty($request->upazila)) {
            $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
            $divisionName = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;
            $totalClaimed = 0;
            $totalReceived = 0;
            $data['upazilas'] = DB::table('upazila')->where('district_id', $request->district)->select('id', 'upazila_name_bn')->get();
            foreach ($data['upazilas'] as $key => $value) {
                $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $claimed = $this->statistics_pament_claimed_by_division($value->id, $data);
                $received = $this->statistics_payment_received_by_division($value->id, $data);
                $data['results'][$key]['claimed'] = $claimed;
                $data['results'][$key]['received'] = $received;
                $totalClaimed += $claimed;
                $totalReceived += $received;
            }
            $data['totalClaimed'] = $totalClaimed;
            $data['totalReceived'] = $totalReceived;
        } elseif (!empty($request->division) && !empty($request->district) && !empty($request->upazila)) {
            $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
            $divisionName = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;
            $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;

            $str = $divisionName . ' বিভাগের ';
            $str .= $districtName . ' জেলার ';

            $totalClaimed = $this->statistics_pament_claimed_by_upazila($request->upazila, $data);
            $totalReceived = $this->statistics_payment_received_by_upazila($request->upazila, $data);
            $data['totalClaimed'] = $totalClaimed;
            $data['totalReceived'] = $totalReceived;
        } elseif (!empty($request->division) && !empty($request->district) && !empty($request->upazila)) {
            $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
            $divisionName = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;
            $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;

            $str = $divisionName . ' বিভাগের ';
            $str .= $districtName . ' জেলার ';

            $totalClaimed = $this->statistics_pament_claimed_by_upazila($request->upazila, $data);
            $totalReceived = $this->statistics_payment_received_by_upazila($request->upazila, $data);
            $data['totalClaimed'] = $totalClaimed;
            $data['totalReceived'] = $totalReceived;
        } elseif (empty($request->division) && empty($request->district) && !empty($request->upazila)) {
            $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;

            $totalClaimed = $this->statistics_pament_claimed_by_upazila($request->upazila, $data);
            $totalReceived = $this->statistics_payment_received_by_upazila($request->upazila, $data);
            $data['totalClaimed'] = $totalClaimed;
            $data['totalReceived'] = $totalReceived;
        } else {
            if ($roleID == 8 || $roleID == 2 || $roleID == 25) { // Superadmin
                // dd('come here');
                $str = 'সকল বিভাগের তথ্য';

                $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();


                foreach ($data['divisions'] as $key => $value) {
                    $data['results'][$key]['division_name_bn'] = $value->division_name_bn;
                    $data['results'][$key]['id'] = $value->id;
                    $claimed = $this->statistics_pament_claimed_by_division($value->id, $data);
                    $received = $this->statistics_payment_received_by_division($value->id, $data);
                    $data['results'][$key]['claimed'] = $claimed;
                    $data['results'][$key]['received'] = $received;
                    $totalClaimed += $claimed;
                    $totalReceived += $received;
                }
                $data['totalClaimed'] = $totalClaimed;
                $data['totalReceived'] = $totalReceived;
            }
        }
        // print_r($result); exit;

        return response()->json(['msg' => $str, 'data' => $data]);
    }

    public function ajaxPaymentReport(Request $request)
    {
        // dd($request->division);
        // Get Data
        $roleID = Auth::user()->role_id;
        $result = [];
        $str = '';
        $data['division'] = $request->division;
        $data['district'] = $request->district;
        $data['upazila'] = $request->upazila;
        // Convert DB date formate
        $data['dateFrom'] = isset($request->dateFrom) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateFrom))) : null;
        $data['dateTo'] = isset($request->dateTo) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateTo))) : null;

        // Data filtering
        if (!empty($request->division) && empty($request->district) && empty($request->district)) {
            $divisionName = $division = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;
            $data['districts'] = DB::table('district')->where('division_id', $request->division)->select('id', 'district_name_bn')->get();
            foreach ($data['districts'] as $key => $value) {
                $data['results'][$key]['district_name_bn'] = $value->district_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['claimed'] = $this->statistics_pament_claimed_by_district($value->id, $data);
                $data['results'][$key]['received'] = $this->statistics_payment_received_by_district($value->id, $data);
            }
            $str = $divisionName . ' বিভাগের তথ্য';
            $result = '';
            $result .= '<table class="table table-hover table-bordered report">
            <thead class="table">
                <tr>
                <th class="text-left">জেলার নাম</th>
                <th class="text-center">দাবীকৃত অর্থ (টাকা)</th>
                <th class="text-center">আদায়কৃত অর্থ (টাকা)</th>
                </tr>
            </thead>
            <tbody>';
                $i = $grandTotal = 0;
                foreach ($data['results'] as $row) {
                    $i++;

                    $result .= '<tr>
                <td class="text-left">' . $row["district_name_bn"] . '</td>
                <td class="text-center">' . $row["claimed"] . '</td>
                <td class="text-center">' . $row["received"] . '</td>
                </tr>';
                }
                $result .= '</tbody>
            </table>';
        } elseif (!empty($request->division) && !empty($request->district) && empty($request->upazila)) {
            $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
            $divisionName = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;

            $data['upazilas'] = DB::table('upazila')->where('district_id', $request->district)->select('id', 'upazila_name_bn')->get();
            foreach ($data['upazilas'] as $key => $value) {
                $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['claimed'] = $this->statistics_pament_claimed_by_upazila($value->id, $data);
                $data['results'][$key]['received'] = $this->statistics_payment_received_by_upazila($value->id, $data);
            }
            $str = $divisionName . ' বিভাগের ';
            $str .= $districtName . ' জেলার তথ্য';

            $result = '';
            $result .= '<table class="table table-hover table-bordered report">
            <thead class="table">
                <tr>
                <th class="text-left">উপজেলার নাম</th>
                <th class="text-center">দাবীকৃত অর্থ (টাকা)</th>
                <th class="text-center">আদায়কৃত অর্থ (টাকা)</th>
                </tr>
            </thead>
            <tbody>';
            $i = $grandTotal = 0;
            foreach ($data['results'] as $row) {
                $i++;

                $result .= '<tr>
                    <td class="text-left">' . $row["upazila_name_bn"] . '</td>
                    <td class="text-center">' . $row["claimed"] . '</td>
                    <td class="text-center">' . $row["received"] . '</td>
                </tr>';
            }
            $result .= '</tbody>
             </table>';
        } elseif (!empty($request->division) && !empty($request->district) && !empty($request->upazila)) {
            $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
            $divisionName = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;
            $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;

            $str = $divisionName . ' বিভাগের ';
            $str .= $districtName . ' জেলার ';

            $claimed = $this->statistics_pament_claimed_by_upazila($request->upazila, $data);
            $received = $this->statistics_payment_received_by_upazila($request->upazila, $data);

            $str .= $upazilaName . ' উপজেলা/থানার তথ্য';

            $result = '';
            $result .= '<table class="table table-hover table-bordered report">
                <thead class="table">
                    <tr>
                        <th class="text-left">উপজেলার নাম</th>
                        <th class="text-center">দাবীকৃত অর্থ (টাকা)</th>
                        <th class="text-center">আদায়কৃত অর্থ (টাকা)</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text-left">' . $upazilaName . '</td>
                    <td class="text-center">' . $claimed . '</td>
                    <td class="text-center">' . $received . '</td>
                </tr>';
                        $result .= '</tbody>
                </table>';
        } elseif (empty($request->division) && empty($request->district) && !empty($request->upazila)) {
            $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;

            $claimed = $this->statistics_pament_claimed_by_upazila($request->upazila, $data);
            $received = $this->statistics_payment_received_by_upazila($request->upazila, $data);

            $str = $upazilaName . ' উপজেলা/থানার তথ্য';

            $result = '';
            $result .= '<table class="table table-hover table-bordered report">
            <thead class="table">
                <tr>
                    <th class="text-left">উপজেলার নাম</th>
                    <th class="text-center">দাবীকৃত অর্থ (টাকা)</th>
                    <th class="text-center">আদায়কৃত অর্থ (টাকা)</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-left">' . $upazilaName . '</td>
                <td class="text-center">' . $claimed . '</td>
                <td class="text-center">' . $received . '</td>
            </tr>';
                        $result .= '</tbody>
            </table>';
        } else {

            // Check role wise
            if ($roleID == 2 || $roleID == 8  || $roleID == 25) { // Superadmin
                $str = 'সকল বিভাগের তথ্য';

                $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
                foreach ($data['divisions'] as $key => $value) {
                    $data['results'][$key]['division_name_bn'] = $value->division_name_bn;
                    $data['results'][$key]['id'] = $value->id;
                    $data['results'][$key]['claimed'] = $this->statistics_pament_claimed_by_division($value->id, $data);
                    $data['results'][$key]['received'] = $this->statistics_payment_received_by_division($value->id, $data);
                }

                $result = '';
                $result .= '<table class="table table-hover table-bordered report">
                <thead class="table">
                    <tr>
                    <th class="text-left">বিভাগের নাম</th>
                    <th class="text-center">দাবীকৃত অর্থ (টাকা)</th>
                    <th class="text-center">আদায়কৃত অর্থ (টাকা)</th>
                    </tr>
                </thead>
                <tbody>';
                $i = $grandTotal = 0;
                foreach ($data['results'] as $row) {
                    $i++;

                    $result .= '<tr>
               <td class="text-left">' . $row["division_name_bn"] . '</td>
               <td class="text-center">' . $row["claimed"] . '</td>
               <td class="text-center">' . $row["received"] . '</td>
                </tr>';
                    }
                    $result .= '</tbody>
                </table>';
            } elseif ($roleID == 34) { // Divitional Comm.
                $str = 'সকল জেলার তথ্য';
                $data['districts'] = DB::table('district')->where('division_id', user_office_info()->division_id)->select('id', 'district_name_bn')->get();
                // $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

                foreach ($data['districts'] as $key => $value) {
                    $data['results'][$key]['district_name_bn'] = $value->district_name_bn;
                    $data['results'][$key]['id'] = $value->id;
                    $data['results'][$key]['claimed'] = $this->statistics_pament_claimed_by_district($value->id, $data);
                    $data['results'][$key]['received'] = $this->statistics_payment_received_by_district($value->id, $data);
                }

                $result = '';
                $result .= '<table class="table table-hover table-bordered report">
                <thead class="table">
                    <tr>
                    <th class="text-left">জেলার নাম</th>
                    <th class="text-center">দাবীকৃত অর্থ (টাকা)</th>
                    <th class="text-center">আদায়কৃত অর্থ (টাকা)</th>
                    </tr>
                </thead>
                <tbody>';
                $i = $grandTotal = 0;
                foreach ($data['results'] as $row) {
                    $i++;

                    $result .= '<tr>
               <td class="text-left">' . $row["district_name_bn"] . '</td>
               <td class="text-center">' . $row["claimed"] . '</td>
              <td class="text-center">' . $row["received"] . '</td>
                </tr>';
                    }
                    $result .= '</tbody>
                </table>';
            } elseif ($roleID == 6) { // DC
                $str = 'উপজেলা/থানার তথ্য';

                $data['upazilas'] = DB::table('upazila')->where('district_id', user_office_info()->district_id)->select('id', 'upazila_name_bn')->get();
                // $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

                foreach ($data['upazilas'] as $key => $value) {
                    $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
                    $data['results'][$key]['id'] = $value->id;
                    $data['results'][$key]['claimed'] = $this->statistics_pament_claimed_by_upazila($value->id, $data);
                    $data['results'][$key]['received'] = $this->statistics_payment_received_by_upazila($value->id, $data);
                }
                $result = '';
                $result .= '<table class="table table-hover table-bordered report">
                <thead class="table">
                    <tr>
                    <th class="text-left">উপজেলা/ থানার নাম</th>
                    <th class="text-center">দাবীকৃত অর্থ (টাকা)</th>
                    <th class="text-center">আদায়কৃত অর্থ (টাকা)</th>
                    </tr>
                </thead>
                <tbody>';
                $i = $grandTotal = 0;
                foreach ($data['results'] as $row) {
                    $i++;

                    $result .= '<tr>
               <td class="text-left">' . $row["upazila_name_bn"] . '</td>
               <td class="text-center">' . $row["claimed"] . '</td>
              <td class="text-center">' . $row["received"] . '</td>
                </tr>';
                    }
                    $result .= '</tbody>
                </table>';
            }

           
        }

        return response()->json(['msg' => $str, 'data' => $result]);
    }

    public function statistics_pament_claimed_by_division($id, $data = null)
    {
        $query = DB::table('gcc_appeals')->where('division_id', $id)->whereNotIn('appeal_status', ['REJECTED', 'DRAFT']);
        if ($data['dateFrom'] != null && $data['dateTo'] != null) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$data['dateFrom'], $data['dateTo']]);
        }

        return $query->sum('loan_amount');
        // return $query;
    }

    public function statistics_pament_claimed_by_upazila($id, $data = null)
    {
        $query = DB::table('gcc_appeals')->where('upazila_id', $id)->whereNotIn('appeal_status', ['REJECTED']);
        if ($data['dateFrom'] != null && $data['dateTo'] != null) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$data['dateFrom'], $data['dateTo']]);
        }

        return $query->sum('loan_amount');
        // return $query;
    }

    public function statistics_payment_received_by_division($id, $data = null)
    {
        $query = DB::table('gcc_appeals')->where('division_id', $id)->whereNotIn('appeal_status', ['REJECTED'])->select('id');
        if ($data['dateFrom'] != null && $data['dateTo'] != null) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$data['dateFrom'], $data['dateTo']]);
        }

        $appealId = $query->get();

        $sum = 0;
        foreach ($appealId as $value) {
            $query = DB::table('gcc_payment_lists')->where('appeal_id', $value->id)->sum('paid_loan_amount');
            $sum = $sum + $query;
        }

        return $sum;
    }

    public function statistics_payment_received_by_upazila($id, $data = null)
    {

        $query = DB::table('gcc_appeals')->where('upazila_id', $id)->whereNotIn('appeal_status', ['REJECTED'])->select('id');
        if ($data['dateFrom'] != null && $data['dateTo'] != null) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$data['dateFrom'], $data['dateTo']]);
        }

        $appealId = $query->get();

        $sum = 0;
        foreach ($appealId as $value) {
            $query = DB::table('gcc_payment_lists')->where('appeal_id', $value->id)->sum('paid_loan_amount');
            $sum = $sum + $query;
        }

        return $sum;
    }

    public function statistics_pament_claimed_by_district($id, $data = null)
    {
        $query = DB::table('gcc_appeals')->where('district_id', $id)->whereNotIn('appeal_status', ['REJECTED']);
        if ($data['dateFrom'] != null && $data['dateTo'] != null) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$data['dateFrom'], $data['dateTo']]);
        }

        return $query->sum('loan_amount');
        // return $query;
    }

    public function statistics_payment_received_by_district($id, $data = null)
    {
        $query = DB::table('gcc_appeals')->where('district_id', $id)->whereNotIn('appeal_status', ['REJECTED'])->select('id');
        if ($data['dateFrom'] != null && $data['dateTo'] != null) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$data['dateFrom'], $data['dateTo']]);
        }

        $appealId = $query->get();

        $sum = 0;
        foreach ($appealId as $value) {
            $query = DB::table('gcc_payment_lists')->where('appeal_id', $value->id)->sum('paid_loan_amount');
            $sum = $sum + $query;
        }

        return $sum;
    }

    public function statistics_case_status($status, $data = null)
    {
        $query = DB::table('gcc_appeals')->where('appeal_status', $status);
        if (globalUserInfo()->role_id == 6) {
            $data['district'] = user_district()->id;
        }

        if (globalUserInfo()->role_id == 34) {
            $data['division'] = user_office_info()->division_id;
        }

        if ($data['division']) {
            $query->where('division_id', '=', $data['division']);
        }
        if ($data['district']) {
            $query->where('district_id', '=', $data['district']);
        }
        if ($data['upazila']) {
            $query->where('upazila_id', '=', $data['upazila']);
        }
        if ($data['dateFrom'] != null && $data['dateTo'] != null) {
            $query->whereBetween('case_date', [$data['dateFrom'], $data['dateTo']]);
        }

        return $query->count();
        // return $query;
    }

    public function hearing_date_today()
    {
        $data['hearing'] = DB::table('case_hearing')
            ->join('case_register', 'case_hearing.case_id', '=', 'case_register.id')
            ->join('court', 'case_register.court_id', '=', 'court.id')
            ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
            ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
            ->select('case_hearing.*', 'case_register.id', 'case_register.court_id', 'case_register.case_number', 'case_register.status', 'court.court_name')
            ->where('case_hearing.hearing_date', '=', date('Y-m-d'))
            ->get();

        // dd($data['hearing']);

        $data['page_title'] = 'আজকের দিনে শুনানী/মামলার তারিখ';
        return view('dashboard.hearing_date')->with($data);
    }

    public function hearing_date_tomorrow()
    {
        $d = date('Y-m-d', strtotime('+1 day'));
        $data['hearing'] = DB::table('case_hearing')
            ->join('case_register', 'case_hearing.case_id', '=', 'case_register.id')
            ->join('court', 'case_register.court_id', '=', 'court.id')
            ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
            ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
            ->select('case_hearing.*', 'case_register.id', 'case_register.court_id', 'case_register.case_number', 'case_register.status', 'court.court_name')
            ->where('case_hearing.hearing_date', '=', $d)
            ->get();

        // dd($data['hearing']);
        $data['page_title'] = 'আগামী দিনে শুনানী/মামলার তারিখ';
        return view('dashboard.hearing_date')->with($data);
    }

    public function hearing_date_nextWeek()
    {

        $d = date('Y-m-d', strtotime('+7 day'));
        $data['hearing'] = DB::table('case_hearing')
            ->join('case_register', 'case_hearing.case_id', '=', 'case_register.id')
            ->join('court', 'case_register.court_id', '=', 'court.id')
            ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
            ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
            ->select('case_hearing.*', 'case_register.id', 'case_register.court_id', 'case_register.case_number', 'case_register.status', 'court.court_name')
            ->where('case_hearing.hearing_date', '>=', date('Y-m-d'))
            ->where('case_hearing.hearing_date', '<=', $d)
            ->get();
        // dd($data['hearing']);

        $data['page_title'] = 'আগামী সপ্তাহের শুনানী/মামলার তারিখ';
        return view('dashboard.hearing_date')->with($data);
    }

    public function hearing_date_nextMonth()
    {
        $d = date('Y-m-d', strtotime('+1 month'));
        /* $m = date('m',strtotime($d));
        dd($d);*/
        $data['hearing'] = DB::table('case_hearing')
            ->join('case_register', 'case_hearing.case_id', '=', 'case_register.id')
            ->join('court', 'case_register.court_id', '=', 'court.id')
            ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
            ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
            ->select('case_hearing.*', 'case_register.id', 'case_register.court_id', 'case_register.case_number', 'case_register.status', 'court.court_name')
            ->where('case_hearing.hearing_date', '>=', date('Y-m-d'))
            ->where('case_hearing.hearing_date', '<=', $d)
            ->get();

        // dd($data['hearing']);

        $data['page_title'] = 'আগামী মাসের শুনানী/মামলার তারিখ';
        return view('dashboard.hearing_date')->with($data);
    }

    public function hearing_case_details($id)
    {

        $data['info'] = DB::table('case_register')
            ->join('court', 'case_register.court_id', '=', 'court.id')
            ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
            ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
            // ->join('case_type', 'case_register.ct_id', '=', 'case_type.id')
            ->join('case_status', 'case_register.cs_id', '=', 'case_status.id')
            // ->join('case_badi', 'case_register.id', '=', 'case_badi.case_id')
            // ->join('case_bibadi', 'case_register.id', '=', 'case_bibadi.case_id')
            ->select('case_register.*', 'court.court_name', 'upazila.upazila_name_bn', 'mouja.mouja_name_bn', 'case_status.status_name')
            ->where('case_register.id', '=', $id)
            ->first();
        // dd($data['info']);
        // dd($data['info']);

        $data['badis'] = DB::table('case_badi')
            ->join('case_register', 'case_badi.case_id', '=', 'case_register.id')
            ->select('case_badi.*')
            ->where('case_badi.case_id', '=', $id)
            ->get();

        $data['bibadis'] = DB::table('case_bibadi')
            ->join('case_register', 'case_bibadi.case_id', '=', 'case_register.id')
            ->select('case_bibadi.*')
            ->where('case_bibadi.case_id', '=', $id)
            ->get();

        $data['surveys'] = DB::table('case_survey')
            ->join('case_register', 'case_survey.case_id', '=', 'case_register.id')
            ->join('survey_type', 'case_survey.st_id', '=', 'survey_type.id')
            ->join('land_type', 'case_survey.lt_id', '=', 'land_type.id')
            ->select('case_survey.*', 'survey_type.st_name', 'land_type.lt_name')
            ->where('case_survey.case_id', '=', $id)
            ->get();

        // Get SF Details
        $data['sf'] = DB::table('case_sf')
            ->select('case_sf.*')
            ->where('case_sf.case_id', '=', $id)
            ->first();
        // dd($data['sf']);

        // Get SF Details
        $data['logs'] = DB::table('case_log')
            ->select('case_log.comment', 'case_log.created_at', 'case_status.status_name', 'role.role_name', 'users.name')
            ->join('case_status', 'case_status.id', '=', 'case_log.status_id')
            ->leftJoin('role', 'case_log.send_user_group_id', '=', 'role.id')
            ->join('users', 'case_log.user_id', '=', 'users.id')
            ->where('case_log.case_id', '=', $id)
            ->orderBy('case_log.id', 'desc')
            ->get();
        // dd($data['sf']);

        // Get SF Details
        $data['hearings'] = DB::table('case_hearing')
            ->select('case_hearing.*')
            ->where('case_hearing.case_id', '=', $id)
            ->orderBy('case_hearing.id', 'desc')
            ->get();

        // Dropdown
        $data['roles'] = DB::table('role')
            ->select('id', 'role_name')
            ->where('in_action', '=', 1)
            ->orderBy('sort_order', 'asc')
            ->get();

        // dd($data['bibadis']);

        $data['page_title'] = 'শুনানী মামলার বিস্তারিত তথ্য';
        return view('dashboard.hearing_case_details')->with($data);
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

    public function get_mouja_by_ulo_office_id($officeID)
    {
        return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
        // return DB::table('mouja_ulo')->select('mouja_id')->where('ulo_office_id', $officeID)->get();
        // return DB::table('division')->select('id', 'division_name_bn')->get();
    }

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

        // $appeal_id_array=[];
        // $count=0;
        // foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
        //     array_push($appeal_id_array, $appeal_ids_from_db_single->appeal_id);
        //     $count++;
        // }

        return ['total_count' => count($appeal_ids_from_db), 'appeal_id_array' => ''];
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
    public function total_running_case_count_defaulter()
    {

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('gcc_appeal_citizens.citizen_type_id', [2, 5])
            ->whereIn('gcc_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        return ['total_count' => count($appeal_ids_from_db), 'appeal_id_array' => ''];
    }
    public function total_pending_case_count_defaulter()
    {

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('gcc_appeal_citizens.citizen_type_id', [2, 5])
            ->whereIn('gcc_appeals.appeal_status', ['SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_LAB_CM'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        // $appeal_id_array=[];
        // $count=0;
        // foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
        //     array_push($appeal_id_array, $appeal_ids_from_db_single->appeal_id);
        //     $count++;
        // }

        return ['total_count' => count($appeal_ids_from_db), 'appeal_id_array' => ''];
    }
    public function total_completed_case_count_defaulter()
    {

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('gcc_appeal_citizens.citizen_type_id', [2, 5])
            ->whereIn('gcc_appeals.appeal_status', ['CLOSED'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        // $appeal_id_array=[];
        // $count=0;
        // foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
        //     array_push($appeal_id_array, $appeal_ids_from_db_single->appeal_id);
        //     /;
        // }

        return ['total_count' => count($appeal_ids_from_db), 'appeal_id_array' => ''];
    }
}
