<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CaseHearing;
use App\Http\Resources\calendar\CaseHearingCollection;
use App\Http\Resources\calendar\GccAppealHearingCollection;
use App\Http\Resources\calendar\RM_CaseHearingCollection;
use App\Models\GccAppeal;
use App\Models\GccCauseList;
use App\Models\RM_CaseHearing;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_old()
    {
        $appealHearing = GccCauseList::select('id','appeal_id', 'case_decision_id', 'conduct_date' ,DB::raw('count(*) as total'))
        ->orderby('id', 'DESC')
        ->groupBy('conduct_date');

        $data['hearingCalender'] = GccAppealHearingCollection::collection($appealHearing->get());

        //  $hearingCalender = CaseHearing::select('id','case_id', 'hearing_comment', 'hearing_date' ,DB::raw('count(*) as total'))
        //     ->orderby('id', 'DESC')
        //     ->groupBy('hearing_date');
        // $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());
        $data['page_title'] = 'আদালত';
        return view('dashboard.calendar.calendar')->with($data);
    }
    public function index()
    {
        $appealHearing = GccAppeal::select('id', 'next_date' ,DB::raw('count(*) as total'));
        if(globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28)
         {
            $appealHearing->where('court_id',globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->where('is_hearing_required',1);
         }
         elseif(globalUserInfo()->role_id == 6)
         {
            $appealHearing->whereIn('appeal_status', ['ON_TRIAL_DC'])->where('district_id', user_office_info()->district_id)->where('is_hearing_required',1);
         }
         elseif(globalUserInfo()->role_id == 34)
         {
            

            $appealHearing->whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])->where('updated_by', globalUserInfo()->id)->where('division_id', user_office_info()->division_id)->where('is_hearing_required',1);
         }
         elseif(globalUserInfo()->role_id == 25)
         {
             $appealHearing->whereIn('appeal_status', ['ON_TRIAL_LAB_CM'])->where('updated_by', globalUserInfo()->id)->where('is_hearing_required',1);
         }
         $appealHearing->orderby('id', 'DESC')->groupBy('next_date');
        

        $data['hearingCalender'] = GccAppealHearingCollection::collection($appealHearing->get());

        //  $hearingCalender = CaseHearing::select('id','case_id', 'hearing_comment', 'hearing_date' ,DB::raw('count(*) as total'))
        //     ->orderby('id', 'DESC')
        //     ->groupBy('hearing_date');
        // $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());
        // return $data;
        $data['page_title'] = 'আদালত';
        return view('dashboard.calendar.calendar')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
