<?php

namespace App\Http\Controllers;

// use Auth;
use App\Models\Dashboard;
use App\Models\CaseRegister;
use App\Http\Resources\calendar\CaseHearingCollection;
use App\Http\Resources\calendar\RM_CaseHearingCollection;
use App\Models\RM_CaseHearing;
use App\Models\AtCaseRegister;
use App\Models\CaseHearing;
use App\Models\GccCauseList;
use App\Models\GccAppeal;
use App\Models\RM_CaseRgister;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use App\Http\Controllers\CommonController;

class FrontHomeController extends Controller
{
    public function public_home(){
    //    if(Auth::check()){
    //         // dd('checked');
    //      return redirect('dashboard');
    //   }else{
        // return $cases = CaseHearing::orderby('id', 'DESC')->get();

        $cases = CaseHearing::select('id','case_id', 'hearing_comment', 'hearing_date' ,DB::raw('count(*) as total'))
        ->orderby('id', 'DESC')
        ->groupBy('hearing_date');
        $data['case'] = CaseHearingCollection::collection($cases->get());

        $rm_case = RM_CaseHearing::select('id','rm_case_id as case_id', 'comments', 'hearing_date' ,DB::raw('count(*) as total'))
        ->orderby('id', 'DESC')
        ->groupBy('hearing_date');
        $data['rm_case'] = RM_CaseHearingCollection::collection($rm_case->get());

        // return $data;
        // return $data =  array_merge($data['case'], $data['rm_case']);
        return view('front.public_home', compact('data'));
        //  return redirect('login');
    //   }
   }
   public function dateWaysCase(Request $request)
    {
        if(!$request->date_start){
            return response(view('errors.404'), 404);
        }
       $d = $request->date_start;
       $data['hearing'] = DB::table('case_hearing')
       ->join('case_register', 'case_hearing.case_id', '=', 'case_register.id')
       ->join('court', 'case_register.court_id', '=', 'court.id')
       ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
       ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
       ->select('case_hearing.*', 'case_register.id', 'case_register.court_id', 'case_register.case_number', 'case_register.status', 'court.court_name')
       ->where('case_hearing.hearing_date', '=', $d)
       ->get();

        // dd($data['hearing']);

       $data['page_title'] = 'শুনানীর তারিখ: ' . en2bn(date('d-m-Y', strtotime($d))) . 'ইং';
       return view('dashboard.hearing_date')->with($data);
    }
   public function appeal_hearing_list_old(Request $request)
    {
        if(!$request->date_start){
            return response(view('errors.404'), 404);
        }
        $d = $request->date_start;
        $data['hearing'] = GccCauseList::orderby('id', 'DESC')
            // ->with('appeal')
            ->where('conduct_date', '=', $d)
            ->paginate(30);
        $data['page_title'] = 'শুনানীর তারিখ: ' . en2bn(date('d-m-Y', strtotime($d))) . 'ইং';
        return view('hearing.hearing_date')->with($data);
    }
   public function appeal_hearing_list(Request $request)
    {
        if(!$request->date_start){
            return response(view('errors.404'), 404);
        }
        $d = $request->date_start;

         $hearin_date_calendar=GccAppeal::orderby('id', 'DESC')->where('next_date', '=', $d);

         if(globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28)
         {
            $hearin_date_calendar->where('court_id',globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL']);
         }
         elseif(globalUserInfo()->role_id == 6)
         {
            $hearin_date_calendar->whereIn('appeal_status', ['ON_TRIAL_DC'])->where('district_id', user_office_info()->district_id);
         }
         elseif(globalUserInfo()->role_id == 34)
         {
            

            $hearin_date_calendar->whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])->where('updated_by', globalUserInfo()->id)->where('division_id', user_office_info()->division_id);
         }
         elseif(globalUserInfo()->role_id == 25)
         {
             $hearin_date_calendar->whereIn('appeal_status', ['ON_TRIAL_LAB_CM'])->where('updated_by', globalUserInfo()->id);
         }

        $data['results'] = $hearin_date_calendar->where('is_hearing_required',1)->paginate(30);
        
               
           
        $data['page_title'] = 'শুনানীর তারিখ: ' . en2bn(date('d-m-Y', strtotime($d))) . 'ইং';
        // return $data;
        return view('hearing.hearing_date')->with($data);
    }
   public function dateWaysRMCase(Request $request)
    {
        if(!$request->date_start){
            return response(view('errors.404'), 404);
        }
       $d = $request->date_start;
       $data['hearing'] = RM_CaseHearing::where('hearing_date', $d)->get();
    //    $data['hearing'] = DB::table('r_m__case_hearings')
    //    ->join('case_register', 'case_hearing.case_id', '=', 'case_register.id')
    //    ->join('court', 'case_register.court_id', '=', 'court.id')
    //    ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
    //    ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
    //    ->select('case_hearing.*', 'case_register.id', 'case_register.court_id', 'case_register.case_number', 'case_register.status', 'court.court_name')
    //    ->where('case_hearing.hearing_date', '=', $d)
    //    ->get();

        // dd($data['hearing']);

       $data['page_title'] = 'শুনানীর তারিখ: ' . en2bn(date('d-m-Y', strtotime($d))) . 'ইং';
       return view('dashboard.rm_case_hearing_date')->with($data);
    }

}
