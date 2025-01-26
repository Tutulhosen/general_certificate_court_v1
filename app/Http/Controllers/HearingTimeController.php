<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Models\GccAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use GrahamCampbell\ResultType\Result;
use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\OnlineHearingRepository;

class HearingTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28) {
            $results = GccAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL'])
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('court_id', globalUserInfo()->court_id);
                
            // code...
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        }
        elseif (globalUserInfo()->role_id == 6) {
            $results = GccAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL_DC'])
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('district_id', user_district()->id);
                
            // code...
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        }
        elseif (globalUserInfo()->role_id == 34) {
            $results = GccAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('division_id', user_division());
                
            // code...
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no']);
            }
            $results=$results->paginate(10);
        }
        elseif (globalUserInfo()->role_id == 25) {
            $results = GccAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL_LAB_CM'])
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('updated_by', globalUserInfo()->id);
                
            // code...
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no']);
            }
            $results=$results->paginate(10);
        }
        // return $results->appealCitizens;
        $data['results'] = $results;
        // $date=date($request->date);
        $caseStatus = 1;
        $data['page_title']  = ' শুনানির তারিখ হয়েছে এমন মামলার সময় পরিবর্তন ফর্ম ';
        // return $data;
        return view('hearing.timeUpdate')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;

        if(empty($request->trialUpdatedTime))
        {
            return response()->json([
                'success'=>'error',
                'message'=>'সময় দিতে হবে ',

            ]);
        }
        date_default_timezone_set('Asia/Dhaka');
        $time_in_24hr=date('H:i');
        $requestHour=explode(':',$request->trialUpdatedTime)[0];
        $requestMinitue=explode(':',$request->trialUpdatedTime)[1];
        
        $currentHour=explode(':',$time_in_24hr)[0];
        $currentMinitue=explode(':',$time_in_24hr)[1];

        if($currentHour>$requestHour)
        {
            return response()->json(
                [
                    'success'=>'error',
                     'message'=>'আপনি শুনানির সময় বর্তমান সময়ের আগে দিয়েছেন !',
                     
                ]
            );
        }
        elseif($currentHour == $requestHour)
        {
            if($currentMinitue>$requestMinitue)
            {
                return response()->json(
                    [
                        'success'=>'error',
                         'message'=>'আপনি শুনানির সময় বর্তমান সময়ের আগে দিয়েছেন !',
                        
                    ]
                );
            }
        }

        $appealIds=[];
        array_push($appealIds,$request->appeal_id);
        $role_id=globalUserInfo()->role_id;


        $beforeTotalTime = strtotime($request->trialUpdatedTime) - 300;
        $afterTotalTime = strtotime($request->trialUpdatedTime) + 300;

        $beforeTimeSting = date("H:i:s", $beforeTotalTime);
        $afterTimeSting = date("H:i:s", $afterTotalTime);


        if($role_id == 27)
        {
            $exiting_trail_date=GccAppeal::select('case_no','next_date_trial_time')->where('next_date', date('Y-m-d', strtotime(now())))->where('updated_by',globalUserInfo()->id)->where('court_id',globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL'])->whereNotIn('id',$appealIds)->whereBetween('next_date_trial_time',[$beforeTimeSting,$afterTimeSting])->get();
        }
        elseif($role_id == 6)
        {
            $exiting_trail_date=GccAppeal::select('case_no','next_date_trial_time')->where('next_date', date('Y-m-d', strtotime(now())))->where('updated_by',globalUserInfo()->id)->where('district_id', user_district()->id)->whereIn('appeal_status', ['ON_TRIAL_DC'])->whereNotIn('id',$appealIds)->whereBetween('next_date_trial_time',[$beforeTimeSting,$afterTimeSting])->get();
        }
        elseif($role_id == 34)
        {
            $exiting_trail_date=GccAppeal::select('case_no','next_date_trial_time')->where('next_date', date('Y-m-d', strtotime(now())))->where('updated_by',globalUserInfo()->id)->whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])->where('division_id', user_office_info()->division_id)->whereNotIn('id',$appealIds)->whereBetween('next_date_trial_time',[$beforeTimeSting,$afterTimeSting])->get();
        }
        elseif($role_id == 25)
        {
            $exiting_trail_date=GccAppeal::select('case_no','next_date_trial_time')->where('next_date', date('Y-m-d', strtotime(now())))->where('updated_by',globalUserInfo()->id)->whereNotIn('id',$appealIds)->whereBetween('next_date_trial_time',[$beforeTimeSting,$afterTimeSting])->get();
        } 

        if(count($exiting_trail_date)>0) 
        {
            $message ='ইতিমধ্যে  ';
            $message .=date('Y-m-d', strtotime(now())).' তারিখে ';
            foreach($exiting_trail_date as $row)
            {
                $bela = '';
                if(!empty($row->next_date_trial_time)){
                    if(date('a', strtotime($row->next_date_trial_time)) == 'am'){
                        $bela = "সকাল";
                    }else{
                        $bela = "বিকাল";
                    }
                }
                
                
                $message .=$bela.' '.date('h:i', strtotime($row->next_date_trial_time)).' মিনিটের সময়  '.$row->case_no.' নং আভিযোগের শুনানির সময় দেয়া আছে';
                $message .=', ';
            }

            return response()->json([
                'success' => 'error',
                'message'=>$message,
            ]);

        }
 



        $results=DB::table('gcc_appeals')->where('id','=',$request->appeal_id)->first();
         
        $em_short_note=DB::table('gcc_notes_modified')->where('appeal_id','=',$request->appeal_id)->orderBy('id', 'DESC')->first();
        
        
        $date_sigment=explode('-',$results->next_date);  
        $next_date_final=$date_sigment[2].'/'.$date_sigment[1].'/'.$date_sigment[0];
        
        
        
        
        $updated=GccAppeal::where('id',$request->appeal_id)->update(['next_date_trial_time'=>$request->trialUpdatedTime]);
        
       
       


        $bela = '';
        if(!empty($request->trialUpdatedTime)){
            if(date('a', strtotime($request->trialUpdatedTime)) == 'am'){
                $bela = "সকাল";
            }else{
                $bela = "বিকাল";
            }
        }
        $updatedTrialTime = $bela.' '.en2bn(date('h:i', strtotime($request->trialUpdatedTime))); 
        if ($updated) {
            
            OnlineHearingRepository::storeHearingKey($request->appeal_id,$em_short_note->case_short_decision_id,$next_date_final,$request->trialUpdatedTime);

            return response()->json([
                'success'=>'success',
                'updatedTrialTime'=>$updatedTrialTime,
                'message'=>'শুনানির সময় সফল ভাবে আপডেট করা হয়েছে ',

            ]);
        }

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
