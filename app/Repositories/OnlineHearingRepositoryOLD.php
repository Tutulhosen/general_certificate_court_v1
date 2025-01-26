<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class OnlineHearingRepository
{
    public static function storeHearingKey($appealId)
    {
        $appeal_id=$appealId;
        $today=date('y-m-d');
        $appels_details=DB::table('gcc_appeals')->where('id','=',$appeal_id)->first();
        $create_date=explode(' ',$appels_details->created_at)[0];
        $create_date_at=explode('-',$create_date);


        $jitsi_link='https://meet.jit.si/'.$create_date_at[0].'JitsiMeetOnlin'.'_'.$create_date_at[1].'_'.'eHearingbangladesh'.'-'.explode('-',$today)[0].'_'.$appeal_id.'_'.$appels_details->court_id.'APICertificateCourt'.'_'.explode('-',$today)[2].'_'.$create_date_at[2].'_'.'VeryImportant'.'_'.$appels_details->office_id.'_'.'people'.$appels_details->division_id.'republicof'.'_'.$appels_details->district_id.'_'.explode('-',$today)[1].'BANGLADESH'.'10_96_17_98_17_Dhaka_Saudi_1216_Sudonbhor';

        

        DB::table('gcc_appeals')->where('id','=',$appealId)->update([
          'hearing_key'=>$jitsi_link,
          'is_hearing_host_active'=>0
        ]);  
    }
}