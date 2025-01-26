<?php
/**
 * Created by PhpStorm.
 * User: destructor
 * Date: 11/29/2017
 * Time: 9:50 PM
 */
namespace App\Repositories;

use App\Appeal;

use App\Models\GccCauseList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class CauseListRepository
{
    public static function storeCauseList($caseDesicionId, $appealId,$trialDate,$trialTime,$conductDate,$conductTime,$causeListId){
        $globalUserInfo = globalUserInfo();
        // dd($conductDate);
        if($causeListId){
            $causeList=self::getCauseListByCauseListId($causeListId);
        }else{
            $causeList=new GccCauseList();
        }
        $causeList->appeal_id=$appealId;
        $causeList->trial_date=$trialDate;  //date('Y-m-d', strtotime(str_replace('/', '-', $trialDate)));
        $causeList->trial_time=$trialTime;
        $causeList->conduct_date=$conductDate;  //date('Y-m-d', strtotime(str_replace('/', '-', $trialDate)));
        $causeList->conduct_time=$conductTime;
        $causeList->case_decision_id = $caseDesicionId;
        $causeList->created_at=date('Y-m-d H:i:s');
        $causeList->created_by=$globalUserInfo->username;
        $causeList->updated_at=date('Y-m-d H:i:s');
        $causeList->updated_by=$globalUserInfo->username;
        // dd($causeList);
        $causeList->save();
        return $causeList->id;
    }

    public static function getPreviousCauseListId($appealId){

        $causeLists=GccCauseList::where('appeal_id',$appealId)
                    ->orderBy('id', 'desc')
                    ->first();

       // $previousCauseListId=$causeLists->id;

        return $causeLists;
    }

    public static function destroyCauseList($appealId){
        $causeList=GccCauseList::where('appeal_id',$appealId);
        $causeList->delete();
        return;
    }
    public static function destroyCauseListByCauseListId($causeListId){
        $causeList=GccCauseList::where('id',$causeListId);
        $causeList->delete();
        return;
    }
    public static function getCauseListByCauseListId($causeListId){
        $causeList=GccCauseList::find($causeListId);
        return $causeList;
    }

    public static function getPermissionBasedEventConditions($usersPermissions){

        /*$loginUserId = Session::get('userInfo')->username;
        $userRole=Session::get('userRole');
        $permissionBasedConditions="";
        if($userRole=='GCO'){
            $permissionBasedConditions="a.appeal_status!='DRAFT' AND a.gco_user_id=$loginUserId ";
        }elseif ($userRole=='Peshkar'){
            $permissionBasedConditions="a.peshkar_user_id=$loginUserId ";
        }*/

        $permissionBasedConditions='';
        $userRole=Session::get('userRole');
        $userOffice=Session::get('userInfo')->office_id;
        $userId=Session::get('userInfo')->username;
        if($userRole=='GCO'){
            // Case Transfer Section [ Every one can access from same office ]
//            $permissionBasedConditions="a.appeal_status!='DRAFT' AND a.gco_user_id = $userId AND ";
            $permissionBasedConditions="a.appeal_status!='DRAFT' AND ";
        }
        // Case Transfer Section [ Every one can access from same office ]
//        else{
//            $permissionBasedConditions="a.peshkar_user_id = $userId AND ";
//        }
        $permissionBasedConditions.="a.office_id=$userOffice ";


        return $permissionBasedConditions;
    }

    public static function getCauseListEventList(){
        $usersPermissions = Session::get('userPermissions');
        $permissionBasedConditions=self::getPermissionBasedEventConditions($usersPermissions);

        $causeListEvent=DB::connection('appeal')
            ->select(DB::raw(
                "SELECT group_concat('--কেস নং : ',a.case_no , ', বেঞ্চ সহকারী : ', a.peshkar_name, ', সহকারী কমিশনার (জিসিও) : ',a.gco_name,'<br>' SEPARATOR '') AS case_no, CONCAT (count(cl.id),' টি কেস রয়েছে')  AS case_count, cl.trial_date
                    FROM cause_lists cl
                      JOIN (
                             SELECT xl.appeal_id, MAX(xl.id) AS maxId
                             FROM cause_lists xl
                             GROUP BY xl.appeal_id
                           ) xl ON xl.appeal_id = cl.appeal_id AND xl.maxId = cl.id
                      JOIN appeals a ON a.id = cl.appeal_id
                    WHERE $permissionBasedConditions AND a.appeal_status!='CLOSED' AND a.appeal_status!='POSTPONED'
                    GROUP BY cl.trial_date"
            ));



        return $causeListEvent;
    }


}
