<?php
/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 11/30/17
 * Time: 1:02 PM
 */
namespace App\Repositories;


use App\Models\Appeal;
use App\Models\GccAppealCitizen;
use App\Models\GccCitizen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class CitizenRepository
{
    public static function storeCitizen($appealInfo, $citizenList,$appealId){
        // return $appealInfo->all();
        $globalUserInfo = globalUserInfo();
        // $citizenList['applicant'] = $appealInfo->applicant;
        $citizenList['defaulter'] = $appealInfo->defaulter;
        $citizenList['guarantor'] = $appealInfo->guarantor;
        $citizenList['lawyer'] = $appealInfo->lawyer;
        // $citizenList['police'] = $appealInfo->police;
        $multiCtz['nominees'] = $appealInfo->nominee;
        $multiCtz['applicants'] = $appealInfo->applicant;

        $transactionStatus=true;
        $storeId = [];
        $citizenArray = self::getCitizenByAppealId($appealId);
        foreach ($citizenArray as $citizen) {
            $citizen = self::getCitizenByCitizenId($citizen->id);
            if($citizen->delete()){
                $appealCitizen = self::getAppealCitizenByCitizenId($citizen->id);
                $appealCitizen->delete();
            }
        }
        function storeCtg($appealId, $reqCitizen){
            $globalUserInfo = globalUserInfo();
            if($reqCitizen['id']){
                $citizen = CitizenRepository::checkCitizenExist($reqCitizen['id']);
            }
            // $citizen = new GccCitizen();
            // dd($reqCitizen);
            $citizen->citizen_name = $reqCitizen['name'];
            $citizen->citizen_phone_no = $reqCitizen['phn'];
            $citizen->citizen_NID = $reqCitizen['nid'];
            $citizen->citizen_gender = $reqCitizen['gender'];
            $citizen->father = $reqCitizen['father'];
            $citizen->mother = $reqCitizen['mother'];
            $citizen->designation = $reqCitizen['designation'];
            $citizen->organization = $reqCitizen['organization'];
            $citizen->present_address = $reqCitizen['presentAddress'];
            $citizen->email = $reqCitizen['email'];
            $citizen->thana = $reqCitizen['thana'];
            $citizen->upazilla = $reqCitizen['upazilla'];
            $citizen->age = $reqCitizen['age'];

            $citizen->created_at = date('Y-m-d H:i:s');
            // $citizen->created_by = Session::get('userInfo')->username;
            $citizen->created_by =  $citizen->created_by = $globalUserInfo->username;
            $citizen->updated_at = date('Y-m-d H:i:s');
            // $citizen->updated_by = Session::get('userInfo')->username;
            $citizen->updated_by = $globalUserInfo->username;
            return $citizen;
        }
        $i=1;
        foreach ($citizenList as $reqCitizen) {
            $citizen = storeCtg($appealId,  $reqCitizen);
            if ($citizen->save()) {
                // dd($citizen);
                $storeId[$i] = $citizen;
                $i++;
                $transactionStatus = AppealCitizenRepository::storeAppealCitizen($citizen->id, $appealId, $reqCitizen['type']);
                if (!$transactionStatus) {
                    $transactionStatus = false;
                    break;
                }
            } else {
                $transactionStatus = false;
                break;
            }
            if($transactionStatus == false)
                break;
        }
        foreach($multiCtz as $nominees){
            for ($i=0; $i<sizeof($nominees['name']); $i++) {
                $citizen = CitizenRepository::checkCitizenExist($nominees['id'][$i]);
                // $citizen = new GccCitizen();
                $citizen->citizen_name = $nominees['name'][$i];
                $citizen->citizen_phone_no = $nominees['phn'][$i];
                $citizen->citizen_NID = $nominees['nid'][$i];
                $citizen->citizen_gender = $nominees['gender'][$i];
                $citizen->father = $nominees['father'][$i];
                $citizen->mother = $nominees['mother'][$i];
                $citizen->designation = $nominees['designation'][$i];
                $citizen->organization = $nominees['organization'][$i];
                $citizen->present_address = $nominees['presentAddress'][$i];
                $citizen->email = $nominees['email'][$i];
                $citizen->thana = $nominees['thana'][$i];
                $citizen->upazilla = $nominees['upazilla'][$i];
                $citizen->age = $nominees['age'][$i];

                $citizen->created_at = date('Y-m-d H:i:s');
                // $citizen->created_by = Session::get('userInfo')->username;
                $citizen->created_by =  $citizen->created_by = $globalUserInfo->username;
                $citizen->updated_at = date('Y-m-d H:i:s');
                // $citizen->updated_by = Session::get('userInfo')->username;
                $citizen->updated_by = $globalUserInfo->username;
                // dd($citizen);


                if ($citizen->save()) {
                    // dd($citizen);
                    $storeId[$i.'1'] = $citizen;
                    $transactionStatus = AppealCitizenRepository::storeAppealCitizen($citizen->id, $appealId, $nominees['type'][$i]);
                    if (!$transactionStatus) {
                        $transactionStatus = false;
                        break;
                    }
                } else {
                    $transactionStatus = false;
                    break;
                }

                if($transactionStatus == false)
                    break;

            }
        }
        // dd($storeId);
            // dd($transactionStatus);
        return $transactionStatus;
    }

    // public static function getCitizenByCitizenId($citizenId){
    //     $citizen=GccCitizen::find($citizenId);
    //     return $citizen;
    // }
    // public static function getAppealCitizenByCitizenId($citizenId){
    //     $appealCitizen=GccAppealCitizen::find($citizenId);
    //     return $appealCitizen;
    // }
    public static function getCitizenByAppealId($appealId){

        // $citizen=DB::connection('appeal')
        //     ->select(DB::raw(
        //         "SELECT * FROM citizens
        //          JOIN appeal_citizens ac ON ac.citizen_id=citizens.id
        //          WHERE ac.appeal_id =$appealId"
        //     ));

        $citizens = DB::table('gcc_citizens')
        ->join('gcc_appeal_citizens as ac', 'ac.citizen_id', '=', 'gcc_citizens.id')
        ->where('ac.appeal_id', $appealId)
        ->get();

        return $citizens;
    }

    public static function destroyCitizen($citizenIds){

        foreach ($citizenIds as $citizenId){
            $citizen=GccCitizen::where('id',$citizenId);
            $citizen->delete();
        }

        return;
    }

    public static function getOffenderLawyerCitizen($appealId){
        $lawerCitizen=[];
        $offenderCitizen=[];

        $appeal = Appeal::find($appealId);
        //prepare applicant citizen,lawyer citizen,offender citizen
        $citizens=$appeal->appealCitizens;
        foreach ($citizens as $citizen){
            $citizenTypes = $citizen->citizenType;
            foreach ($citizenTypes as $citizenType){
                if($citizenType->id==1){
                    $offenderCitizen=$citizen;
                }
                if($citizenType->id==4){
                    $lawerCitizen=$citizen;
                }
            }
        }

        return ['offenderCitizen'=>$offenderCitizen,
                'lawerCitizen'=>$lawerCitizen ];

    }
    public static function checkCitizenExist($citizen_id){
        if(isset($citizen_id)){
            $citizen=GccCitizen::find($citizen_id);
        }else{
            $citizen=new GccCitizen();
        }
        // dd($citizen);
        return $citizen;
    }

}
