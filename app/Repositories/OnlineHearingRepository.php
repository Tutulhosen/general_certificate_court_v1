<?php

namespace App\Repositories;

use App\Models\GccAppeal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

use App\Repositories\ZoomRepository;

class OnlineHearingRepository
{
    public static function storeHearingKey($appealId, $shortorderid, $trialdate, $trialtime)
    {
        if ($shortorderid == 16) {
            $case_no = DB::table('gcc_appeals')
                ->select('case_no')
                ->where('id', '=', $appealId)
                ->first();
            $short_order_name = DB::table('gcc_case_shortdecisions')
                ->where('id', '=', $shortorderid)
                ->first();

            $meeting_tropic = $case_no->case_no . ' এর জন্য ' . $short_order_name->case_short_decision;

            $date_sigment = explode('/', $trialdate);
            $date_final = $date_sigment[2] . '-' . $date_sigment[1] . '-' . $date_sigment[0];
            $trial_time = $trialtime . ':' . '00';
            $start_date = $date_final . 'T' . $trial_time . 'Z';

            $zoom_meeting = new ZoomRepository();

            try {
                while (1) {
                    $z = $zoom_meeting->createAMeeting([
                        'start_date' => $start_date,
                        'meetingTopic' => $meeting_tropic,
                        'timezone' => 'Asia/Dhaka',
                    ]);

                    if (!empty($z->start_url)) {
                        break;
                    }
                }

                DB::table('gcc_appeals')
                    ->where('id', '=', $appealId)
                    ->update([
                        'zoom_start_url' => $z->start_url,
                        'zoom_join_url' => $z->join_url,
                        'zoom_join_meeting_id' => $z->id,
                        'zoom_join_meeting_password' => $z->password,
                        'is_hearing_host_active' => 0,
                        'is_hearing_required'=>1
                    ]);
            } catch (Exception $ex) {
                echo $ex;
            }
        }else
        {
          DB::table('gcc_appeals')->where('id','=',$appealId)->update([
            'zoom_start_url'=>NULL,
            'zoom_join_url'=>NULL,
            'zoom_join_meeting_id'=>NULL,
            'zoom_join_meeting_password'=>NULL,
            'is_hearing_host_active'=>0,
            'is_hearing_required'=>0
          ]);
        }

        // $appeal_id=$appealId;
        // $today=date('y-m-d');
        // $appels_details=DB::table('gcc_appeals')->where('id','=',$appeal_id)->first();
        // $create_date=explode(' ',$appels_details->created_at)[0];
        // $create_date_at=explode('-',$create_date);

        // $jitsi_link='https://meet.jit.si/'.$create_date_at[0].'JitsiMeetOnlin'.'_'.$create_date_at[1].'_'.'eHearingbangladesh'.'-'.explode('-',$today)[0].'_'.$appeal_id.'_'.$appels_details->court_id.'APICertificateCourt'.'_'.explode('-',$today)[2].'_'.$create_date_at[2].'_'.'VeryImportant'.'_'.$appels_details->office_id.'_'.'people'.$appels_details->division_id.'republicof'.'_'.$appels_details->district_id.'_'.explode('-',$today)[1].'BANGLADESH'.'10_96_17_98_17_Dhaka_Saudi_1216_Sudonbhor';

        // DB::table('gcc_appeals')->where('id','=',$appealId)->update([
        //   'hearing_key'=>$jitsi_link,
        //   'is_hearing_host_active'=>0
        // ]);
    }
}
