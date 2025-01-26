<?php
/**
 * Created by PhpStorm.
 * User: pranab
 * Date: 11/17/17
 * Time: 5:59 PM
 */
namespace App\Repositories;

use App\Models\GccAppeal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppealListRepository
{
    public static function RoleWaysDraftAppealList()
    {
        $results = GccAppeal::orderby('id', 'desc')->where('appeal_status', 'DRAFT');
        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
        }
        if (!empty($_GET['case_no'])) {
            $results = $results->where('case_no', '=', $_GET['case_no']);
        }
        return $results->paginate(10);
    }
    public static function RoleWaysAllAppealList()
    {
        $results = GccAppeal::orderby('id', 'desc');
        if (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28) {
            $results = $results->whereIn('appeal_status', ['ON_TRIAL', 'CLOSED'])->where('court_id', globalUserInfo()->court_id);
            // code...
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } elseif (globalUserInfo()->role_id == 6) {

            $results = $results->whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DC'])->where('district_id', user_district()->id);
            // code...
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } elseif (globalUserInfo()->role_id == 34) {
            $results = $results->whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DIV_COM'])->where('division_id', user_office_info()->division_id);
            // code...
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } elseif (globalUserInfo()->role_id == 25) {
            $results = $results->whereIn('appeal_status', ['ON_TRIAL_LAB_CM', 'CLOSED'])->where('updated_by', globalUserInfo()->id);
            // code...
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        }
        return $results->paginate(10);
    }
    public static function RoleWaysRunningAppealList()
    {
        $results = GccAppeal::orderby('id', 'desc');
        if (globalUserInfo()->role_id == 1) {
            $results = $results->whereIn('appeal_status', ['ON_TRIAL']);
        }
        if (globalUserInfo()->role_id == 24) {
            $results = $results->whereIn('appeal_status', ['ON_TRIAL_LAB_CM', 'SEND_TO_LAB_CM'])->where('updated_by', globalUserInfo()->id);
        }
        if (globalUserInfo()->role_id == 27) {
            $results = $results->whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', globalUserInfo()->court_id);
        }
        if (globalUserInfo()->role_id == 28) {
            $results = $results->whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', globalUserInfo()->court_id);
        }
        if (globalUserInfo()->role_id == 6) {
            $results = $results->whereIn('appeal_status', ['ON_TRIAL_DC'])->where('district_id', user_district()->id);
        }
        if (globalUserInfo()->role_id == 7) {
            $results = $results->whereIn('appeal_status', ['ON_TRIAL_DC'])->where('district_id', user_district()->id);
        }
        if (globalUserInfo()->role_id == 34) {
            $results = $results->whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])->where('updated_by', globalUserInfo()->id)->where('division_id', user_office_info()->division_id);
        }
        if (globalUserInfo()->role_id == 25) {
            $results = $results->whereIn('appeal_status', ['ON_TRIAL_LAB_CM'])->where('updated_by', globalUserInfo()->id);
        }
        if (!empty($_GET['case_no'])) {
            $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
        }
        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
        }
        return $results->paginate(10);
    }
    public static function RoleWaysPendingAppealList()
    {
        $results = GccAppeal::orderby('id', 'desc');
        if (globalUserInfo()->role_id == 1) {
            $results = $results->whereIn('appeal_status', ['SEND_TO_GCO', 'SEND_TO_ASST_GCO']);
        }
        if (globalUserInfo()->role_id == 27) {
            $results = $results->whereIn('appeal_status', ['SEND_TO_GCO', 'SEND_TO_ASST_GCO'])->where('court_id', globalUserInfo()->court_id);
        }
        if (globalUserInfo()->role_id == 28) {
            $results = $results->whereIn('appeal_status', ['SEND_TO_ASST_GCO'])->where('court_id', globalUserInfo()->court_id);
        }
        if (globalUserInfo()->role_id == 6) {
            $results = $results->where('appeal_status', 'SEND_TO_DC')->where('district_id', user_district()->id);
        }
        if (globalUserInfo()->role_id == 34) {
            $results = $results->where('appeal_status', 'SEND_TO_DIV_COM');
        }
        if (globalUserInfo()->role_id == 25) {
            $results = $results->where('appeal_status', 'SEND_TO_LAB_CM');
        }
        if (!empty($_GET['case_no'])) {
            $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
        }
        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
        }
        return $results->paginate(10);
    }
        public static function RoleWaysClosedAppealList()
    {
        $user = Auth::user();

        if (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28) {

            $results = GccAppeal::orderby('id', 'desc')->where('appeal_status', 'CLOSED')->where('court_id', globalUserInfo()->court_id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

        } elseif (globalUserInfo()->role_id == 6) {

            $results = GccAppeal::orderby('id', 'desc')->where('appeal_status', 'CLOSED')->where('district_id', user_district()->id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);

            }if (!empty($_GET['case_no'])) {

                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

        } elseif (globalUserInfo()->role_id == 7) {

            $results = GccAppeal::orderby('id', 'desc')->where('appeal_status', 'CLOSED')->where('district_id', user_district()->id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);

            }if (!empty($_GET['case_no'])) {

                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

        } elseif (globalUserInfo()->role_id == 34) {
            $results = GccAppeal::orderby('id', 'desc')->where('appeal_status', 'CLOSED')->where('division_id', user_division());

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);

            }if (!empty($_GET['case_no'])) {

                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

        } elseif (globalUserInfo()->role_id == 25) {
            $results = GccAppeal::orderby('id', 'desc')->where('appeal_status', 'CLOSED');

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

        } elseif (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 8) {
            $results = GccAppeal::orderby('id', 'desc')->where('appeal_status', 'CLOSED')->where('updated_by', globalUserInfo()->id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        }

        return $results->paginate(10);
    }
    public static function RoleWaysTrialAppealList()
    {
        if (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28) {
            $results = GccAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL'])
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->where('court_id', globalUserInfo()->court_id);

            // code...
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

        } elseif (globalUserInfo()->role_id == 6) {
            $results = GccAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL_DC'])
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->where('district_id', user_district()->id);

            // code...
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

        } elseif (globalUserInfo()->role_id == 34) {
            $results = GccAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->where('division_id', user_division());

            // code...
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

        } elseif (globalUserInfo()->role_id == 25) {
            $results = GccAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL_LAB_CM'])
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->where('updated_by', globalUserInfo()->id);

            // code...
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

        }
        return $results->paginate(10);
    }

    public static function RoleWaysActionRequiredAppealList()
    {
        $results = GccAppeal::orderby('id', 'desc')
            ->whereIn('appeal_status', ['ON_TRIAL'])
            ->where('court_id', globalUserInfo()->court_id);
        if (globalUserInfo()->role_id == 27) {
            $results =$results->where('action_required','GCO');
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

        }elseif(globalUserInfo()->role_id == 28)
        {
            $results =$results->where('action_required','ASST');
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        }
        return $results->paginate(10);
    }

    public static function case_for_cose_list()
    {
        $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', now())));
        $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', now())));
        $data['divisions'] = DB::table('division')
            ->select('id', 'division_name_bn')
            ->get();
        $division_name = null;
        $district_name = null;
        $court_name = null;
        $appeal = GccAppeal::where('case_no', '!=', 'অসম্পূর্ণ মামলা')->whereIn('appeal_status', ['ON_TRIAL']);
        
        
        

            if (!empty($_GET['division'])) {
                
                
                
                $appeal = $appeal->where('division_id', '=', $_GET['division']);
            }
            if (!empty($_GET['district'])) {
                

                $appeal = $appeal->where('district_id', '=', $_GET['district']);
            }
            if (!empty($_GET['court'])) {
                
                //dd($court_details);
                $appeal = $appeal->where('court_id', '=', $_GET['court']);
            }

            if (!empty($_GET['case_no'])) {
                $appeal = $appeal->where('case_no', 'like', '%' . bn2en($_GET['case_no']) . '%')->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $appeal = $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
           

            if (empty($_GET['division']) && empty($_GET['district']) && empty($_GET['court']) && empty($_GET['case_no']) && empty($_GET['date_start']) && empty($_GET['date_end'])) {
                $appeal = $appeal->where('next_date',$dateFrom);
            }
        

        
        return $appeal->paginate(10);
        // return $appeal;
    }

    public static function case_for_cose_list_new()
    {
        $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', now())));
        $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', now())));
        $data['divisions'] = DB::table('division')
            ->select('id', 'division_name_bn')
            ->get();
        $division_name = null;
        $district_name = null;
        $court_name = null;
        $appeal = GccAppeal::where('case_no', '!=', 'অসম্পূর্ণ মামলা')->whereIn('appeal_status', ['ON_TRIAL']);
        
        
        

            if (!empty($_GET['division'])) {
                
                
                
                $appeal = $appeal->where('division_id', '=', $_GET['division']);
            }
            if (!empty($_GET['district'])) {
                

                $appeal = $appeal->where('district_id', '=', $_GET['district']);
            }
            if (!empty($_GET['court'])) {
                
                //dd($court_details);
                $appeal = $appeal->where('court_id', '=', $_GET['court']);
            }

            if (!empty($_GET['case_no'])) {
                $appeal = $appeal->where('case_no', 'like', '%' . bn2en($_GET['case_no']) . '%')->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $appeal = $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
           

            if (empty($_GET['division']) && empty($_GET['district']) && empty($_GET['court']) && empty($_GET['case_no']) && empty($_GET['date_start']) && empty($_GET['date_end'])) {
                $appeal = $appeal->where('next_date',$dateFrom);
            }
        

        
        // return $appeal->paginate(10);
        return $appeal;
    }
}