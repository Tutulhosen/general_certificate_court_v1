<?php

namespace App\Repositories;


use App\Models\GccAppealCitizen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class AppealCitizenRepository
{
    public static function storeAppealCitizen($citizenId,$appealId,$citizenTypeId){
        $globalUserInfo = globalUserInfo();
        $transactionStatus=false;
        $appealCitizen=self::getAppealCitizenByAppealIdAndCitizenId($appealId,$citizenId,$citizenTypeId);
        // if(count($appealCitizen)<1){
        //     $appealCitizen=new AppealCitizen();
        // }
        if($appealCitizen == null){
            $appealCitizen=new GccAppealCitizen();
        }
        $appealCitizen->appeal_id=$appealId;
        $appealCitizen->citizen_id=$citizenId;
        $appealCitizen->citizen_type_id=$citizenTypeId;
        $appealCitizen->created_at=date('Y-m-d H:i:s');
        // $appealCitizen->created_by=Session::get('userInfo')->username;
        $appealCitizen->created_by=$globalUserInfo->username;
        $appealCitizen->updated_at=date('Y-m-d H:i:s');
        // $appealCitizen->updated_by=Session::get('userInfo')->username;
        $appealCitizen->updated_by=$globalUserInfo->username;
        if($appealCitizen->save()){
            // dd($appealCitizen);
            $transactionStatus=true;
        };
        return $transactionStatus;
    }

    public static function destroyAppealCitizen($appealId){
        $citizen=array();
        $i=0;
        $appealCitizens=GccAppealCitizen::where('appeal_id',$appealId)->get();
        foreach ($appealCitizens as $appealCitizen){
            $citizen[$i]=$appealCitizen->citizen_id;
            $appealCitizen->delete();
            $i++;
        }

        return $citizen;
    }
    public static function getAppealCitizenByAppealIdAndCitizenId($appealId,$citizenId,$citizenTypeId){
        $appealCitizen=GccAppealCitizen::where('appeal_id', $appealId)
        ->where('citizen_id', $citizenId)
        ->where('citizen_type_id', $citizenTypeId)
        ->first();
        return $appealCitizen;
    }

    public static function checkAppealCitizenExist($citizen_id){
        if(isset($citizen_id)){
            $citizen = GccAppealCitizen::where('citizen_id', $citizen_id)->first();
        }else{
            $citizen=new GccAppealCitizen();
        }
        // dd($citizen);
        return $citizen;
    }
    public static function checkAppealCitizenExistByAppelCitizen($appealId, $citizen_id){
        $appealCitizen = GccAppealCitizen::where('citizen_id', $citizen_id)->where('appeal_id', $appealId);
        return $appealCitizen;
    }


}
