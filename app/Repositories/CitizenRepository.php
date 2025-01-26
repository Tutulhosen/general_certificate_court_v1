<?php


namespace App\Repositories;

use App\Models\Appeal;
use App\Models\GccAppealCitizen;
use App\Models\GccCitizen;
use App\Models\GccAppeal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CitizenRepository
{
    public static function storeCitizen($appealInfo, $citizenList, $appealId)
    {
        
        $globalUserInfo = globalUserInfo();
        
        $citizenList['defaulter'] = $appealInfo->defaulter;
      
      
       
        $multiCtz['applicants'] = $appealInfo->applicant;
        

        $transactionStatus = true;
        $storeId = [];
        
        function storeCtg($appealId, $reqCitizen)
        {
            
            $citizen = CitizenRepository::checkCitizenExist($reqCitizen['id'],$reqCitizen['nid']);
            $citizen->citizen_name = $reqCitizen['name'];
            $citizen->citizen_phone_no = $reqCitizen['phn'];
            $citizen->citizen_NID = $reqCitizen['nid'];
            $citizen->citizen_gender = isset($reqCitizen['gender']) ? $reqCitizen['gender'] : null;
            $citizen->father = $reqCitizen['father'];
            $citizen->mother = $reqCitizen['mother'];
            $citizen->designation = $reqCitizen['designation'];
            $citizen->organization = $reqCitizen['organization'];
            $citizen->present_address = isset($reqCitizen['present_address']) ? $reqCitizen['present_address'] : null;
            $citizen->permanent_address = isset($reqCitizen['permanent_address']) ? $reqCitizen['permanent_address'] : null;
            $citizen->email = $reqCitizen['email'];
            $citizen->thana = $reqCitizen['thana'];
            $citizen->dob = isset($_POST['defaulter_dob_input_smdn']) ? str_replace('/','-',$_POST['defaulter_dob_input_smdn']) : null;
            $citizen->upazilla = $reqCitizen['upazilla'];
            $citizen->age = $reqCitizen['age'];
            $citizen->created_at = date('Y-m-d H:i:s');
            $citizen->updated_at = date('Y-m-d H:i:s');
            $citizen->created_by = globalUserInfo()->id;
            $citizen->updated_by = globalUserInfo()->id;

            return $citizen;
        }
        $i = 1;
        foreach ($citizenList as $reqCitizen) {
            $citizen = storeCtg($appealId, $reqCitizen);
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
            if ($transactionStatus == false) {
                break;
            }
        }
        // dd($storeId);
        foreach ($multiCtz as $sCitizen) {
            for ($i = 0; $i < sizeof($sCitizen['name']); $i++) {
                $citizen = CitizenRepository::checkCitizenExist($sCitizen['id'][$i],$sCitizen['nid'][$i]);
                $citizen->citizen_name = $sCitizen['name'][$i];
                $citizen->citizen_phone_no = $sCitizen['phn'][$i];
                $citizen->citizen_NID = $sCitizen['nid'][$i];
                $citizen->citizen_gender = isset($sCitizen['gender'][$i]) ? $sCitizen['gender'][$i] : null;
                $citizen->father = $sCitizen['father'][$i];
                $citizen->mother = $sCitizen['mother'][$i];
                $citizen->designation = $sCitizen['designation'][$i];
                $citizen->organization = $sCitizen['organization'][$i];
                $citizen->organization_id = isset($sCitizen['organization_id'][$i]) ? $sCitizen['organization_id'][$i] : null;
                $citizen->email = $sCitizen['email'][$i];
                $citizen->thana = $sCitizen['thana'][$i];
                $citizen->upazilla = $sCitizen['upazilla'][$i];
                $citizen->age = $sCitizen['age'][$i];
                $citizen->organization_employee_id=isset($sCitizen['organization_employee_id'][$i]) ? $sCitizen['organization_employee_id'][$i] : null;
                $citizen->created_at = date('Y-m-d H:i:s');
                $citizen->updated_at = date('Y-m-d H:i:s');
                $citizen->created_by = globalUserInfo()->id;
                $citizen->updated_by = globalUserInfo()->id;

                if ($citizen->save()) {
                    $storeId[$i . '1'] = $citizen;
                    $transactionStatus = AppealCitizenRepository::storeAppealCitizen($citizen->id, $appealId, $sCitizen['type'][$i]);
                    if (!$transactionStatus) {
                        $transactionStatus = false;
                        break;
                    }
                } else {
                    $transactionStatus = false;
                    break;
                }

                if ($transactionStatus == false) {
                    break;
                }
            }
        }
        return $transactionStatus;
    }
     
    public static function appstoreCitizen($appealInfo, $citizenList, $appealId)
    {
        
        $globalUserInfo = globalUserInfo();
        
        $citizenList['defaulter'] = $appealInfo->defaulter;
      
      
       
        $multiCtz['applicants'] = $appealInfo->applicant;
        

        $transactionStatus = true;
        $storeId = [];
        
        function appstoreCtg($appealId, $reqCitizen)
        {
            
            $citizen = CitizenRepository::checkCitizenExist($reqCitizen['id'],$reqCitizen['nid']);
            $citizen->citizen_name = $reqCitizen['name'];
            $citizen->citizen_phone_no = $reqCitizen['phn'];
            $citizen->citizen_NID = $reqCitizen['nid'];
            $citizen->citizen_gender = isset($reqCitizen['gender']) ? $reqCitizen['gender'] : null;
            $citizen->father = $reqCitizen['father'];
            $citizen->mother = $reqCitizen['mother'];
            $citizen->designation = $reqCitizen['designation'];
            $citizen->organization = $reqCitizen['organization'];
            $citizen->present_address = isset($reqCitizen['present_address']) ? $reqCitizen['present_address'] : null;
            $citizen->permanent_address = isset($reqCitizen['permanent_address']) ? $reqCitizen['permanent_address'] : null;
            $citizen->email = $reqCitizen['email'];
            $citizen->thana = $reqCitizen['thana'];
            $citizen->dob = isset($_POST['defaulter_dob_input_smdn']) ? str_replace('/','-',$_POST['defaulter_dob_input_smdn']) : null;
            $citizen->upazilla = $reqCitizen['upazilla'];
            $citizen->age = $reqCitizen['age'];
            $citizen->created_at = date('Y-m-d H:i:s');
            $citizen->updated_at = date('Y-m-d H:i:s');
            $citizen->created_by = globalUserInfo()->id;
            $citizen->updated_by = globalUserInfo()->id;

            return $citizen;
        }
        $i = 1;
        foreach ($citizenList as $reqCitizen) {
            $citizen = appstoreCtg($appealId, $reqCitizen);
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
            if ($transactionStatus == false) {
                break;
            }
        }
        // dd($storeId);
        foreach ($multiCtz as $sCitizen) {
       
   
                $citizen = CitizenRepository::checkCitizenExist($sCitizen['id'],$sCitizen['nid']);
                $citizen->citizen_name = $sCitizen['name'];
                $citizen->citizen_phone_no = $sCitizen['phn'];
                $citizen->citizen_NID = $sCitizen['nid'];
                $citizen->citizen_gender = isset($sCitizen['gender']) ? $sCitizen['gender'] : null;
                $citizen->father = $sCitizen['father'];
                $citizen->mother = $sCitizen['mother'];
                $citizen->designation = $sCitizen['designation'];
                $citizen->organization = $sCitizen['organization'];
                $citizen->organization_id = isset($sCitizen['organization_id']) ? $sCitizen['organization_id'] : null;
                $citizen->email = $sCitizen['email'];
                $citizen->thana = $sCitizen['thana'];
                $citizen->upazilla = $sCitizen['upazilla'];
                $citizen->age = $sCitizen['age'];
                $citizen->organization_employee_id=isset($sCitizen['organization_employee_id']) ? $sCitizen['organization_employee_id'] : null;
                $citizen->created_at = date('Y-m-d H:i:s');
                $citizen->updated_at = date('Y-m-d H:i:s');
                $citizen->created_by = globalUserInfo()->id;
                $citizen->updated_by = globalUserInfo()->id;
             
                if ($citizen->save()) {
                    $storeId[$i . '1'] = $citizen;
                    $transactionStatus = AppealCitizenRepository::storeAppealCitizen($citizen->id, $appealId, $sCitizen['type']);
                    if (!$transactionStatus) {
                        $transactionStatus = false;
                        break;
                    }
                } else {
                    $transactionStatus = false;
                    break;
                }

                if ($transactionStatus == false) {
                    break;
                }
            
        }
        return $transactionStatus;
    }
    public static function getCitizenByCitizenId($citizenId)
    {
        $citizen = GccCitizen::find($citizenId);
        return $citizen;
    }
    public static function getAppealCitizenByCitizenId($citizenId)
    {
        $appealCitizen = GccAppealCitizen::find($citizenId);
        return $appealCitizen;
    }
    public static function getCitizenByAppealId($appealId)
    {

        $citizens = DB::table('gcc_citizens')
            ->join('gcc_appeal_citizens as ac', 'ac.citizen_id', '=', 'gcc_citizens.id')
            ->where('ac.appeal_id', $appealId)
            ->get();

        return $citizens;
    }

    public static function destroyCitizen($citizenIds)
    {
        foreach ($citizenIds as $citizenId) {
            $citizen = GccCitizen::where('id', $citizenId);
            $citizen->delete();
        }

        return;
    }

    public static function getOffenderLawyerCitizen($appealId)
    {
        $lawerCitizen = [];
        $offenderCitizen = [];

        $appeal = GccAppeal::find($appealId);
        //prepare applicant citizen,lawyer citizen,offender citizen
        $citizens = $appeal->appealCitizens;
        foreach ($citizens as $citizen) {
            $citizenTypes = $citizen->citizenType;
            foreach ($citizenTypes as $citizenType) {
                if ($citizenType->id == 1) {
                    $offenderCitizen = $citizen;
                }
                if ($citizenType->id == 4) {
                    $lawerCitizen = $citizen;
                }
            }
        }

        return ['offenderCitizen' => $offenderCitizen, 'lawerCitizen' => $lawerCitizen];
    }

    public static function getDefaulterCitizen($appealId)
    {
        $defaulterCitizen = [];

        $appeal = GccAppeal::find($appealId);
        //prepare applicant citizen,lawyer citizen,offender citizen
        $citizens = $appeal->appealCitizens;
        foreach ($citizens as $citizen) {
            $citizenTypes = $citizen->citizenType;
            foreach ($citizenTypes as $citizenType) {
                if ($citizenType->id == 2) {
                    $defaulterCitizen = $citizen;
                }
            }
        }

        return ['defaulterCitizen' => $defaulterCitizen];
    }
    public static function checkCitizenExist($citizen_id,$nid)
    {
        if(isset($citizen_id)){
            $citizen=GccCitizen::find($citizen_id);
        }
        elseif(isset($nid))
        {
            $citizen=GccCitizen::where('citizen_NID',$nid)->first();
            
        }

        if(isset($citizen))
        {
            return $citizen;
        } 
        else{
            $citizen=new GccCitizen();
            return $citizen;
        }


        return $citizen;
    }
}
