<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\RaiOrder;
use App\Models\GccAppeal;
use App\Models\GccCitizen;
use Illuminate\Http\UploadedFile;
use App\Services\AdminAppServices;
use Illuminate\Support\Facades\DB;
use App\Services\ProjapotiServices;
use Illuminate\Support\Facades\Auth;
use App\Services\DataConversionService;
use Illuminate\Support\Facades\Session;

class AppealRepository
{
    public static function storeAppealForCertificateAsst($appealInfo)
    {
        $caseDate = bn2en($appealInfo->caseDate);

        $appeal = self::checkAppealExist($appealInfo->appealId);

        $userIn = globalUserInfo();

        if (!empty($appealInfo->court_fee_amount) && isset($appealInfo->court_fee_amount)) {
            $court_fee_amount = bn2en($appealInfo->court_fee_amount);
        } else {
            $court_fee_amount = null;
        }

        if (!empty($appealInfo->manual_case_no) && isset($appealInfo->manual_case_no)) {
            $manual_case_no = $appealInfo->manual_case_no;
        } else {
            $manual_case_no = null;
        }


        try {
            $appeal->case_no = $appealInfo->caseNo;
            $appeal->appeal_status = $appealInfo->status;
            $appeal->updated_at = date('Y-m-d H:i:s');
            $appeal->updated_by = $userIn->id;
            $appeal->action_required = 'GCO';
            $appeal->manual_case_no = $manual_case_no;
            $appeal->court_fee_amount = $court_fee_amount;
            $appeal->save();
            $appealId = $appeal->id;
        } catch (\Exception $e) {
            //dd($e);
            $appealId = null;
        }

        return $appealId;
    }
    public static function storeAppealBYCitizen($appealInfo)
    {

        $caseDate = bn2en($appealInfo->caseDate);

        $appeal = self::checkAppealExist($appealInfo->appealId);

        $userIn = globalUserInfo();
        $officeInfo = user_office_info();

        try {
            $appeal->case_no = 'অসম্পূর্ণ মামলা';
            $appeal->appeal_status = $appealInfo->status;
            $appeal->case_date = date('Y-m-d', strtotime(str_replace('/', '-', $caseDate)));
            $appeal->case_entry_type = $appealInfo->caseEntryType;
            $appeal->law_section = $appealInfo->lawSection;
            $appeal->applicant_type = $appealInfo->applicant_organization['Type'][0];
            $appeal->updated_at = date('Y-m-d H:i:s');
            $appeal->updated_by = $userIn->id;
            $appeal->flag_on_trial = 0;
            $appeal->office_id = $userIn->office_id;
            $appeal->office_name = $officeInfo->office_name_bn;
            $appeal->upazila_bbs_code = $officeInfo->upazila_id;
            $appeal->upazila_id = $officeInfo->upazila_id;
            $appeal->upazila_name = $officeInfo->upazila_name_bn;
            $appeal->district_bbs_code = $officeInfo->district_id;
            $appeal->district_id = $officeInfo->district_id;
            $appeal->district_name = $officeInfo->district_name_bn;
            $appeal->court_id = $appealInfo->court_id;
            $appeal->division_bbs_code = isset($officeInfo->division_bbs_code) ? $officeInfo->division_bbs_code : null;
            $appeal->division_id = $officeInfo->division_id;
            $appeal->division_name = $officeInfo->division_name_bn;
            $appeal->loan_amount = bn2en($appealInfo->totalLoanAmount);
            $appeal->loan_amount_text = $appealInfo->totalLoanAmountText;
            $appeal->office_unit_id = $userIn->role_id;
            $appeal->office_unit_name = $userIn->role->role_name;
            $appeal->created_at = date('Y-m-d H:i:s');
            $appeal->interestRate = $appealInfo->interestRate;

            if ($appealInfo->appealId == null) {
                $appeal->created_by = $userIn->id;
            }


            $appeal->save();
            $appealId = $appeal->id;
        } catch (\Exception $e) {
            dd($e);
            exit;
            $appealId = null;
        }

        return $appealId;
    }

    public static function storeRunningAppealBYAsst($appealInfo)
    {

        if ($appealInfo['court_fee_attached']) {
            $file = $appealInfo['court_fee_attached'];

            // Generate a unique name for the file
            $filename = time() . '_' . $file->getClientOriginalName();
            // Move the file to the public directory
            $file->move(public_path('running_case_court_fee_attached'), $filename);
        } else {
            $filename = null;
        }
        $caseDate = bn2en($appealInfo->caseDate);

        $appeal = self::checkAppealExist($appealInfo->appealId);

        $userIn = globalUserInfo();
        $officeInfo = user_office_info();
        $uplozilainfo = DB::table('upazila')->where('id', $appealInfo->applicant['upazila_id'][0])->first();
        $districtinfo = DB::table('district')->where('id', $uplozilainfo->district_id)->first();
        $divisioninfo = DB::table('division')->where('id', $districtinfo->division_id)->first();
        $orginfo = DB::table('office')->where('organization_routing_id', $appealInfo->applicant['organization'][0])->first();
        // dd($orginfo);
        try {
            $appeal->manual_case_no = $appealInfo->caseNo;
            $appeal->appeal_status = $appealInfo->status;
            $appeal->case_date = date('Y-m-d', strtotime(str_replace('/', '-', $caseDate)));
            $appeal->case_entry_type = $appealInfo->caseEntryType;
            $appeal->law_section = $appealInfo->lawSection;
            $appeal->applicant_type = $appealInfo->applicant_organization['Type'][0];
            $appeal->updated_at = date('Y-m-d H:i:s');
            $appeal->updated_by = $userIn->id;
            $appeal->flag_on_trial = 0;
            
            $appeal->office_id = $orginfo->id;
            $appeal->office_name = $orginfo->office_name_bn ?? ' ';;

            $appeal->upazila_bbs_code = $appealInfo->applicant['upazila_id'][0];
            $appeal->upazila_id = $appealInfo->applicant['upazila_id'][0];
            $appeal->upazila_name =  $uplozilainfo->upazila_name_bn;
            $appeal->district_bbs_code =  $uplozilainfo->district_id;
            $appeal->district_id =  $uplozilainfo->district_id;
            $appeal->district_name = $districtinfo->district_name_bn;
            $appeal->court_id = $appealInfo->court_id;
            $appeal->division_bbs_code = isset($divisioninfo->division_bbs_code) ? $divisioninfo->division_bbs_code : null;
            $appeal->division_id = $districtinfo->division_id;
            $appeal->division_name = $divisioninfo->division_name_bn;
   
            $appeal->running_case_court_fee = bn2en($appealInfo->court_fee);
            $appeal->running_case_process_fee = bn2en($appealInfo->process_fee);
            $appeal->running_case_required_amount = bn2en($appealInfo->totalLoanAmount);
            $appeal->running_case_required_amount_text = $appealInfo->totalLoanAmountText;
            $appeal->running_case_interest = bn2en($appealInfo->totalInterest);
            $appeal->running_case_interest_text = $appealInfo->totalInterestText;
            $appeal->running_case_total_amount = bn2en($appealInfo->totalAmountWithInterest);
            $appeal->interestRate = $appealInfo->interestRate;
            $appeal->running_case_court_fee_attached = $filename;

            $appeal->office_unit_id = $userIn->role_id;
            $appeal->office_unit_name = $userIn->role->role_name;
            $appeal->created_at = date('Y-m-d H:i:s');
            if ($appealInfo->appealId == null) {
                $appeal->created_by = $userIn->id;
            }
            // dd($appeal);
            $appeal->save();
          
            $appealId = $appeal->id;
        } catch (\Exception $e) {
            dd($e);
            exit;
            $appealId = null;
        }
        self::generateCaseNo($appealId);
        return $appealId;
    }
    public static function runningApplealstoreCitizen($appealInfo, $citizenList, $appealId)
    {
        $globalUserInfo = globalUserInfo();

        $citizenList['defaulter'] = $appealInfo->defaulter;


        $multiCtz['applicants'] = $appealInfo->applicant;
        // dd( $multiCtz);


        $transactionStatus = true;
        $storeId = [];

        function storeCtg($appealId, $reqCitizen)
        {

            $citizen = CitizenRepository::checkCitizenExist($reqCitizen['id'], $reqCitizen['nid']);
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
            $citizen->dob = isset($_POST['defaulter_dob_input_smdn']) ? str_replace('/', '-', $_POST['defaulter_dob_input_smdn']) : null;
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
                //  echo "<pre>";
                //  print_r( $transactionStatus);
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
        // dd($multiCtz);

        // exit;

        foreach ($multiCtz as $sCitizen) {
            for ($i = 0; $i < sizeof($sCitizen['name']); $i++) {

                // $sCitizen['id'][$i]
                $id = null;
                $citizen = CitizenRepository::checkCitizenExist($id, $sCitizen['nid'][$i]);
                if (!empty($sCitizen['organization_routing_id'][$i]) == "BANK") {
                    $organization_id = $sCitizen['organization_routing_id'][$i];
                } else {
                    $organization_id = $sCitizen['organization_id'][$i];
                }

                $citizen->citizen_name = $sCitizen['name'][$i];
                $citizen->citizen_phone_no = $sCitizen['phn'][$i];
                $citizen->citizen_NID = $sCitizen['nid'][$i];
                $citizen->citizen_gender = isset($sCitizen['gender'][$i]) ? $sCitizen['gender'][$i] : null;
                $citizen->father = $sCitizen['father'][$i];
                $citizen->mother = $sCitizen['mother'][$i];
                $citizen->designation = isset($sCitizen['designation'][$i]) ? $sCitizen['designation'][$i] : null;
                $citizen->organization = $sCitizen['organization'][$i];
                $citizen->organization_id = isset($organization_id) ?  $organization_id : null;
                $citizen->email = $sCitizen['email'][$i];
                $citizen->thana = $sCitizen['thana'][$i];
                // $citizen->upazilla = $sCitizen['upazilla'][$i];
                // $citizen->age = $sCitizen['age'][$i];
                $citizen->organization_employee_id = isset($sCitizen['organization_employee_id'][$i]) ? $sCitizen['organization_employee_id'][$i] : null;
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
    public static function multiexplode($delimiters, $string)
    {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return $launch;
    }
    public static function getDigitalCaseNumber($userName, $appealId)
    {
        /*
         * total 17 digit
         *  District Code 2 digit
         *  upozila Code 2 digit
         *     court code    2 digit
         *  service id    5 digit
         *  Sequential number  4 Digit
         *  last two digit of year 2 digit
         */
        /*
         * total 20 digit
         *  District Code 2 digit
         *     Office Code    3 digit
         *  service id    5 digit
         *  Sequential number  6 Digit
         *  Year  4 digit
         */
        /*
         * total 18 digit
         * magistrate id  4
         * iffice id  4 digit
         * Sequential number 6
         * year 4
         */

        $magistrate_serviceId = '';
        $magistrate_serviceId_Bng = '';
        $magistrate_serviceId_Eng = '';

        $dmInfo = [];
        if (Session::get('flagForSSOLogin') == 1) {
            $dmInfo = ProjapotiServices::getPermisionWiseUser($userName);
        } else {
            $dmInfo = ProjapotiServices::getPermisionWiseUserLocalDb($userName);
        }

        $divid_mag = $dmInfo[0]->divisionBbsCode;
        $zillaId_mag = $dmInfo[0]->districtId;
        if ($dmInfo[0]->upazilaId) {
            $upozilaid_mag = $dmInfo[0]->upazilaId;
        } else {
            $upozilaid_mag = 0;
        }

        if (isset($dmInfo[0]->identity_no) && $dmInfo[0]->identity_no != '0') {
            $serviceId = $dmInfo[0]->identity_no;
            $width = 5;

            $new_service_strEng = DataConversionService::banToEngNumberConversion($serviceId);
            $new_service_strBng = DataConversionService::engToBanglaNumberConversion($serviceId);

            if ($new_service_strEng != '') {
                $magistrate_serviceId_Eng = str_pad((string) $new_service_strEng, $width, '0', STR_PAD_LEFT);
            } else {
                $magistrate_serviceId_Eng = $serviceId;
            }

            if ($new_service_strBng != '') {
                $magistrate_serviceId_Bng = str_pad((string) $new_service_strBng, $width, '0', STR_PAD_LEFT);
            } else {
                $magistrate_serviceId_Bng = $serviceId;
            }
        } else {
            $magistrate_serviceId_Bng = '00000';
            $magistrate_serviceId_Eng = '00000';
        }

        $part1 = '';
        $upozilacode = '00';

        if (isset($upozilaid_mag)) {
            $upozilacode = $upozilaid_mag;
        } else {
            $upozilacode = '00';
        }

        $part1 = str_pad((string) $zillaId_mag, 2, '0', STR_PAD_LEFT) . str_pad((string) $upozilacode, 2, '0', STR_PAD_LEFT);
        $part2 = '03'; // mobile court 01//appeal court 02 //certificate court 03
        $part_Eng = $magistrate_serviceId_Eng;
        $part_Bng = $magistrate_serviceId_Bng;
        $part4 = '.____.'; // sequential number
        $part5 = date('y');

        $appeals = DB::connection('appeal')->select(
            DB::raw(
                "SELECT appeals.case_no  AS case_no
                 FROM appeals
                 WHERE appeals.id !=$appealId AND appeals.gco_user_id='$userName' AND case_no!='অসম্পূর্ণ মামলা' ",
            ),
        );

        $max_value = count($appeals);
        $lastFourChar = $max_value; // 4th slot is fixed for case number
        $lastFourNumber = (int) $lastFourChar + 1;

        $part4 = str_pad($lastFourNumber, 4, '0', STR_PAD_LEFT);
        $serviceId = substr($userName, -5);
        $code = str_pad($part1, 4, '0', STR_PAD_LEFT) . '.' . str_pad($part2, 2, '0', STR_PAD_LEFT) . '.' . str_pad($serviceId, 5, '0', STR_PAD_LEFT) . '.' . $part4 . '.' . $part5;

        return $code;
    }

    public static function checkAppealExist($appealId)
    {
        if (isset($appealId)) {
            $appeal = GccAppeal::find($appealId);
        } else {
            $appeal = new GccAppeal();
        }
        // dd($appeal);exit;
        return $appeal;
    }

    public static function getAppealByCaseNo($caseNo)
    {
        $appeal = DB::connection('appeal')->select(
            DB::raw(
                "SELECT appeals.case_no  AS case_no
                    FROM appeals
                    WHERE appeals.case_no='$caseNo' ",
            ),
        );
        return $appeal ? $appeal : '$caseNo';
    }

    public static function generateCaseNo($appealId)
    {
        $appeal = GccAppeal::find($appealId);

        $court_details = DB::table('court')
            ->where('id', $appeal->court->id)
            ->first();
        if ($court_details->level == 0) {
            $upazila_name_en = $appeal->upazila->upazila_name_en;
            $upazila_name_en_exploded = explode(' ', $appeal->upazila->upazila_name_en);
            if (!empty($upazila_name_en_exploded[1])) {
                $upazilla_name = $upazila_name_en_exploded[1];
            } else {
                $upazilla_name = $upazila_name_en;
            }

            $part_1 = strtoupper(substr($appeal->district->district_name_en, 0, 3)) . '-' . strtoupper(substr($upazilla_name, 0, 3)) . '-GCC';
        } else {
            $part_1 = strtoupper(substr($appeal->district->district_name_en, 0, 3)) . '-GCC';
        }
        $case_postition = DB::table('gcc_appeals')
            ->selectRaw('count(*) as case_postition')
            ->where('court_id', $appeal->court->id)
            ->where('id', '<=', $appealId)
            ->first()->case_postition;

        $case_no = $part_1 . '-' . $case_postition . '-' . date('Y') . '-' . $appealId;
        $appeal->case_no = $case_no;
        $appeal->save();

        return;
    }

    public static function storeAppeal($appealInfo)
    {
        // dd(date('Y-m-d',strtotime(str_replace('/', '-', $caseDate))));

        // dd($appealInfo);

        $caseDate = bn2en($appealInfo->caseDate);
        $profile = null;
        $usersPermissions = Session::get('userPermissions');
        $appeal = self::checkAppealExist($appealInfo->appealId);
        // $userIn = Session::get('userInfo');
        $userIn = globalUserInfo();
        $officeInfo = user_office_info();
        // dd($officeInfo);
        if ($appealInfo->status == 'SEND_TO_ASST_GCO') {
            $gcc_court_id = DB::table('case_mapping')
                ->select('court_id')
                ->where('district_id', $officeInfo->district_id)
                ->where('upazilla_id', $officeInfo->upazila_id)
                ->where('status', 1)
                ->first();
        }
        try {
            if (globalUserInfo()->role_id == 28 && $appealInfo->status != 'ON_TRIAL') {
                $appeal->case_no = 'অসম্পূর্ণ মামলা';
            }

            $appeal->appeal_status = $appealInfo->status;
            $appeal->case_date = date('Y-m-d', strtotime(str_replace('/', '-', $caseDate)));
            $appeal->case_entry_type = $appealInfo->caseEntryType;
            $appeal->prev_case_no = $appealInfo->previouscaseNo;
            $appeal->law_section = $appealInfo->lawSection;
            $appeal->case_decision_id = $appealInfo->caseDecision;
            $appeal->applicant_type = $appealInfo->applicant_organization['Type'][0];
            $appeal->updated_at = date('Y-m-d H:i:s');
            $appeal->updated_by = $userIn->id;
            $appeal->flag_on_trial = 0;
            $appeal->office_id = $userIn->office_id;
            // $appeal->office_name=$userIn->office_name_bng;
            $appeal->office_name = $officeInfo->office_name_bn;
            // $appeal->upazila_bbs_code=$userIn->upazilaId;
            $appeal->upazila_bbs_code = $officeInfo->upazila_id;
            if ($appealInfo->status == 'SEND_TO_ASST_GCO') {
                $appeal->upazila_id = $officeInfo->upazila_id;
            }
            // $appeal->upazila_name=$userIn->upazila_name_bng;
            $appeal->upazila_name = $officeInfo->upazila_name_bn;
            // $appeal->district_bbs_code=$userIn->districtId;
            // $appeal->district_name=$userIn->district_name_bng;
            $appeal->district_bbs_code = $officeInfo->district_id;
            $appeal->district_id = $officeInfo->district_id;
            $appeal->district_name = $officeInfo->district_name_bn;

            if ($appealInfo->status == 'SEND_TO_ASST_GCO') {
                $appeal->court_id = $appealInfo->court_id;
            }
            // $appeal->division_bbs_code=$userIn->divisionBbsCode;
            // $appeal->division_name=$userIn->divisionName;
            $appeal->division_bbs_code = $officeInfo->division_id;
            $appeal->division_id = $officeInfo->division_id;
            $appeal->division_name = $officeInfo->division_name_bn;
            $appeal->loan_amount = bn2en($appealInfo->totalLoanAmount);
            $appeal->loan_amount_text = $appealInfo->totalLoanAmountText;
            $appeal->comment = isset($appealInfo->comment) ? $appealInfo->comment : null;
            // $appeal->office_unit_id=$userIn->office_unit_id;
            // $appeal->office_unit_name=$userIn->unit_name_bng;
            $appeal->office_unit_id = $userIn->role_id;
            $appeal->office_unit_name = $userIn->role->role_name;
            // dd($appeal);

            if (isset($appealInfo->gcoList)) {
                // if(Session::get('flagForSSOLogin')==1) {
                //     $userInfo=ProjapotiServices::getPermisionWiseUser($appealInfo->gcoList);
                // }else{
                //     $userInfo=ProjapotiServices::getPermisionWiseUserLocalDb($appealInfo->gcoList);
                // }
                // $appeal->gco_office_id = $userInfo[0]->office_id;
                // $appeal->gco_user_id=$appealInfo->gcoList;
                // $appeal->gco_name=$userInfo[0]->name_bng;
                // $appeal->gco_email=$userInfo[0]->personal_email;
                // $appeal->gco_office_unit_organograms=$userInfo[0]->officeUnitOrganogramId;

                $userInfo = User::findOrFail($appealInfo->gcoList);
                $appeal->gco_office_id = $userInfo->office_id;
                $appeal->gco_user_id = $appealInfo->gcoList;
                $appeal->gco_name = $userInfo->name;
                $appeal->gco_email = $userInfo->email;
                $appeal->gco_office_unit_organograms = $userInfo->officeUnitOrganogramId;
            }
            // foreach ($usersPermissions as $Permission)  {
            //     if($Permission->permission_code =='certificateInitiate'){ //Peshkar
            //         $appeal->created_at=date('Y-m-d H:i:s');
            //         $appeal->created_by=$userIn->username;
            //         $appeal->peshkar_name=$userIn->name_bng;
            //         $appeal->peshkar_user_id=$userIn->username;
            //         $appeal->peshkar_email=$userIn->personal_email;
            //         $appeal->peshkar_office_id=$userIn->office_id;
            //         $appeal->peshkar_office_unit_organograms=$userIn->officeUnitOrganogramId;
            //         break;
            //     }
            // }

            $appeal->created_at = date('Y-m-d H:i:s');
            if ($appealInfo->appealId == null) {
                $appeal->created_by = $userIn->id;
            }
            $appeal->peshkar_name = $userIn->name;
            $appeal->peshkar_user_id = $userIn->username;
            $appeal->peshkar_email = $userIn->email;
            $appeal->peshkar_office_id = $userIn->office_id;
            $appeal->peshkar_office_unit_organograms = $userIn->officeUnitOrganogramId;

            $appeal->save();
            // dd($appeal);
            $appealId = $appeal->id;
        } catch (\Exception $e) {
            // dd($e);
            $appealId = null;
        }
        return $appealId;
    }
    public static function storeAppealForOnTrial($appealInfo)
    {

        $appeal = self::checkAppealExist($appealInfo->appealId);
        if ($appeal->case_no == 'অসম্পূর্ণ মামলা') {
            self::generateCaseNo($appeal->id);
        }

        $trialDate = $appealInfo->trialDate;
        $trialDate_format = str_replace('/', '-', $trialDate);

        $finalOrderPublishDate = $appealInfo->finalOrderPublishDate;
        $orderPublishDate_format = str_replace('/', '-', $finalOrderPublishDate);
        // dd($date_format);
        try {
            $appeal->flag_on_trial = 1;
            $appeal->appeal_status = $appealInfo->status;
            $appeal->payment_status = $appealInfo->paymentStatus;
            $appeal->case_decision_id = $appealInfo->appealDecision;
            $appeal->next_date = date('Y-m-d', strtotime($trialDate_format));
            $appeal->next_date_trial_time = $appealInfo->trialTime;
            $appeal->updated_at = date('Y-m-d H:i:s');
            $appeal->updated_by = globalUserInfo()->id;

            if ($appealInfo->status == 'CLOSED') {
                $appeal->final_order_publish_status = $appealInfo->orderPublishDecision;
                $appeal->final_order_publish_date = date('Y-m-d', strtotime($orderPublishDate_format));
                $appeal->is_applied_for_review = 0;
            }
            if ($appealInfo->shortOrder[0] == 12) {
                $appeal->is_nominee_required = 1;
            }
            $appeal->save();
            $appealId = $appeal->id;
        } catch (\Exception $e) {
            $appealId = null;
        }
        return $appealId;
    }

    public static function storeAppealForKharij($appealInfo)
    {
        $appeal = self::checkAppealExist($appealInfo->hide_case_id);
        // dd($appeal);
        // dd($date_format);
        try {
            // dd($appeal);
            $appeal->kharij_reason = $appealInfo->kharij_reason;
            $appeal->is_applied_for_karij = 1;

            $appeal->save();
            $appealId = $appeal->id;
        } catch (\Exception $e) {
            // dd($e);
            $appealId = null;
        }
        return $appealId;
    }

    public static function destroyAppeal($appealId)
    {
        $appeal = GccAppeal::where('id', $appealId);
        $appeal->delete();
        return;
    }

    public static function appealRollback($appealId)
    {
        self::destroyAppeal($appealId);

        CauseListRepository::destroyCauseList($appealId);

        NoteRepository::destroyNote($appealId);

        $citizenIds = AppealCitizenRepository::destroyAppealCitizen($appealId);
        CitizenRepository::destroyCitizen($citizenIds);
    }

    public static function getAllAppealInfo($appealId)
    {
        //variable declare
        $applicantCitizen = [];
        $defaulterCitizen = [];
        $guarantorCitizen = [];
        $lawerCitizen = [];
        $nomineeCitizen = [];
        $policeCitizen = [];
        $issuerCitizen = [];
        $citizenAttendance = [];
        $notApprovedNoteList = [];
        $notApprovedAttachmentList = [];
        $notApprovedShortOrderList = [];

        // $userInfo=Session::get('userInfo');
        $userInfo = globalUserInfo();
        //find appeal
        // $thanas=AdminAppServices::getThana($userInfo->office->district_id);
        $appeal = GccAppeal::find($appealId);
        //prepare applicant citizen,lawyer citizen,offender citizen
        //$citizens=$appeal->appealCitizens;
        // dd($citizens);
        $LegalInfo = LegalInfoRepository::getLegalInfoByAppealId($appealId);
        $noteCauseList = NoteRepository::getNoteCauseListByAppealId($appealId);
        $attachmentList = AttachmentRepository::getAttachmentListByAppealId($appealId);
        $approvedNoteList = NoteRepository::getApprovedNoteList($appealId);

        $notApprovedNoteList = NoteRepository::getNotApprovedNote($appealId);
        // dd($notApprovedNoteList);
        if (count($notApprovedNoteList) > 0) {
            $notApprovedAttachmentList = AttachmentRepository::getAttachmentListByAppealIdAndCauseListId($appealId, $notApprovedNoteList[0]->cause_list_id);
            $notApprovedShortOrderList = CauseListShortDecisionRepository::getShortOrderListByAppealIdAndCauseListId($appealId, $notApprovedNoteList[0]->cause_list_id);
        }

        //get DM role office info
        // $roleOfficeInfo=AdminAppServices::getOfficeInfoByRoleCode('GCO_');
        $roleOfficeInfo = AdminAppServices::getOfficeInfoByRoleCode($userInfo->role_id);
        //get Dm list

        $gcoList = [];

        if (globalUserInfo()->role_id != 36) {
            $gcoList = ProjapotiServices::getUserListByDistrictAndOrganogramOriginId($roleOfficeInfo, $userInfo->office->district_id, $userInfo->office_id);
        }

        $applicantCitizenDB = DB::table('gcc_appeals')
            ->join('gcc_appeal_citizens', 'gcc_appeals.id', '=', 'gcc_appeal_citizens.appeal_id')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->where('gcc_appeals.id', '=', $appealId)
            ->where('gcc_appeal_citizens.citizen_type_id', '=', 1)
            ->select('gcc_citizens.id')
            ->get();

        foreach ($applicantCitizenDB as $applicantCitizenSingle) {
            array_push($applicantCitizen, GCCCitizen::find($applicantCitizenSingle->id));
        }

        $defaulterCitizenDB = DB::table('gcc_appeals')
            ->join('gcc_appeal_citizens', 'gcc_appeals.id', '=', 'gcc_appeal_citizens.appeal_id')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->where('gcc_appeals.id', '=', $appealId)
            ->where('gcc_appeal_citizens.citizen_type_id', '=', 2)
            ->select('gcc_citizens.id')
            ->first();

        $defaulterCitizen = GCCCitizen::find($defaulterCitizenDB->id);

        $nomineeCitizenDB = DB::table('gcc_appeals')
            ->join('gcc_appeal_citizens', 'gcc_appeals.id', '=', 'gcc_appeal_citizens.appeal_id')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->where('gcc_appeals.id', '=', $appealId)
            ->where('gcc_appeal_citizens.citizen_type_id', '=', 5)
            ->select('gcc_citizens.id')
            ->get();

        //dd($nomineeCitizenDB);

        foreach ($nomineeCitizenDB as $witnessCitizenSingle) {
            array_push($nomineeCitizen, GCCCitizen::find($witnessCitizenSingle->id));
        }

        //prepare response
        $data = [
            // 'thanas'  => $thanas,
            'appeal' => $appeal,
            'legalInfo' => $LegalInfo,
            'applicantCitizen' => $applicantCitizen,
            'defaulterCitizen' => $defaulterCitizen,
            'guarantorCitizen' => $guarantorCitizen,
            'lawerCitizen' => $lawerCitizen,
            'nomineeCitizen' => $nomineeCitizen,
            'policeCitizen' => $policeCitizen,
            'issuerCitizen' => $issuerCitizen,
            'appealCauseList' => $appeal->appealCauseList, //appeal causelist model relation
            'appealNote' => $appeal->appealNotes, //appeal note model relation
            'gcoList' => $gcoList,
            'citizenAttendance' => $citizenAttendance,
            'noteCauseList' => $noteCauseList,
            'attachmentList' => $attachmentList,
            'approvedNoteCauseList' => $approvedNoteList,
            'notApprovedNoteCauseList' => $notApprovedNoteList,
            'notApprovedAttachmentCauseList' => $notApprovedAttachmentList,
            'notApprovedShortOrderCauseList' => $notApprovedShortOrderList,
            'loginUserInfo' => Auth::user(),
        ];

        return $data;
    }

    public static function getCauseListAllAppealInfo($appealId)
    {
        //variable declare
        $applicantCitizen = [];
        $defaulterCitizen = [];
        $guarantorCitizen = [];
        $lawerCitizen = [];
        $nomineeCitizen = [];
        $policeCitizen = [];
        $issuerCitizen = [];
        $citizenAttendance = [];
        $notApprovedNoteList = [];
        $notApprovedAttachmentList = [];
        $notApprovedShortOrderList = [];

        // $userInfo=Session::get('userInfo');
        // $userInfo= globalUserInfo();
        //find appeal
        // $thanas=AdminAppServices::getThana($userInfo->office->district_id);
        $appeal = GccAppeal::find($appealId);
        //prepare applicant citizen,lawyer citizen,offender citizen
        $citizens = $appeal->appealCitizens;
        // dd($citizens);
        $LegalInfo = LegalInfoRepository::getLegalInfoByAppealId($appealId);
        $noteCauseList = NoteRepository::getNoteCauseListByAppealId($appealId);
        $attachmentList = AttachmentRepository::getAttachmentListByAppealId($appealId);
        $approvedNoteList = NoteRepository::getApprovedNoteList($appealId);

        $notApprovedNoteList = NoteRepository::getNotApprovedNote($appealId);
        // dd($notApprovedNoteList);
        if (count($notApprovedNoteList) > 0) {
            $notApprovedAttachmentList = AttachmentRepository::getAttachmentListByAppealIdAndCauseListId($appealId, $notApprovedNoteList[0]->cause_list_id);
            $notApprovedShortOrderList = CauseListShortDecisionRepository::getShortOrderListByAppealIdAndCauseListId($appealId, $notApprovedNoteList[0]->cause_list_id);
        }

        //get DM role office info
        // $roleOfficeInfo=AdminAppServices::getOfficeInfoByRoleCode('GCO_');
        // $roleOfficeInfo=AdminAppServices::getOfficeInfoByRoleCode($userInfo->role_id);
        //get Dm list

        $gcoList = [];
        //get Gco list
        // if(Session::get('flagForSSOLogin')==1) {
        //     $gcoList=ProjapotiServices::getUserListByDistrictAndOrganogramOriginIdByAPI($roleOfficeInfo,Session::get('userInfo')->districtId, Session::get('userInfo')->office_id);
        // }else{
        // $gcoList=ProjapotiServices::getUserListByDistrictAndOrganogramOriginId($roleOfficeInfo,$userInfo->office->district_id, $userInfo->office_id);
        // }

        // $min  = [];
        foreach ($citizens as $citizen) {
            // $min []= $citizen->citizenType;
            $citizenTypes = $citizen->citizenType;
            // dd($citizen);

            foreach ($citizenTypes as $citizenType) {
                // $min .= "," .$citizenType->id;
                if ($citizenType->id == 1) {
                    $citizenAttendance[] = CitizenAttendanceRepository::getCitizenAttendanceByParameter($appealId, $citizen->id, $appeal->appealCauseList[count($appeal->appealCauseList) - 1]->conduct_date);
                    $applicantCitizen[] = $citizen;
                }
                if ($citizenType->id == 2) {
                    $citizenAttendance[] = CitizenAttendanceRepository::getCitizenAttendanceByParameter($appealId, $citizen->id, $appeal->appealCauseList[count($appeal->appealCauseList) - 1]->conduct_date);
                    $defaulterCitizen = $citizen;
                    // dd($citizen);
                }
                if ($citizenType->id == 3) {
                    $guarantorCitizen = $citizen;
                }
                if ($citizenType->id == 4) {
                    $lawerCitizen = $citizen;
                }
                if ($citizenType->id == 5) {
                    $nomineeCitizen[] = $citizen;
                }
                if ($citizenType->id == 6) {
                    $policeCitizen = $citizen;
                }
                if ($citizenType->id == 7) {
                    $issuerCitizen = $citizen;
                }
            }
        }
        // dd($min);
        // dd('minar');

        //prepare response
        $data = [
            // 'thanas'  => $thanas,
            'appeal' => $appeal,
            'legalInfo' => $LegalInfo,
            'applicantCitizen' => $applicantCitizen,
            'defaulterCitizen' => $defaulterCitizen,
            'guarantorCitizen' => $guarantorCitizen,
            'lawerCitizen' => $lawerCitizen,
            'nomineeCitizen' => $nomineeCitizen,
            'policeCitizen' => $policeCitizen,
            'issuerCitizen' => $issuerCitizen,
            'appealCauseList' => $appeal->appealCauseList, //appeal causelist model relation
            'appealNote' => $appeal->appealNotes, //appeal note model relation
            'gcoList' => $gcoList,
            'citizenAttendance' => $citizenAttendance,
            'noteCauseList' => $noteCauseList,
            'attachmentList' => $attachmentList,
            'approvedNoteCauseList' => $approvedNoteList,
            'notApprovedNoteCauseList' => $notApprovedNoteList,
            'notApprovedAttachmentCauseList' => $notApprovedAttachmentList,
            'notApprovedShortOrderCauseList' => $notApprovedShortOrderList,
            'loginUserInfo' => Auth::user(),
        ];
        // dd($data);

        return $data;
    }
    public static function getPermissionBasedConditions($usersPermissions)
    {
        $permissionBasedConditions = '';
        $userRole = Session::get('userRole');
        $userOffice = Session::get('userInfo')->office_id;
        $loginUserId = Session::get('userInfo')->username;
        if ($userRole == 'GCO') {
            $permissionBasedConditions = "a.appeal_status NOT IN ('DRAFT','ON_DC_TRIAL') AND ";
        } elseif ($userRole == 'DC' || $userRole == 'DM' || $userRole == 'ADC' || $userRole == 'ADM' || $userRole == 'Admin') {
            $permissionBasedConditions = "a.appeal_status ='ON_DC_TRIAL' AND ";
        } else {
            // Case Transfer Section [ Every one can access from same office ]
            //            $permissionBasedConditions="a.appeal_status!='ON_DC_TRIAL' AND a.peshkar_user_id=$loginUserId AND ";
            $permissionBasedConditions = "a.appeal_status!='ON_DC_TRIAL' AND ";
        }
        $permissionBasedConditions .= "a.office_id=$userOffice ";

        /*$loginOfficeId=Session::get('userInfo')->office_id;
        $permissionBasedConditions="";

        $permissionBasedConditions="a.office_id=$loginOfficeId ";
        $loginUserId = Session::get('userInfo')->username;
        foreach ($usersPermissions as $Permission) {

        if ($Permission->role_name == 'GCO'){
        $permissionBasedConditions="a.appeal_status!='DRAFT' AND a.gco_user_id=$loginUserId ";
        }
        elseif($Permission->role_name == 'Peshkar'){
        $permissionBasedConditions="a.peshkar_user_id=$loginUserId ";
        }

        }*/
        return $permissionBasedConditions;
    }

    public static function getAppealListBySearchParam($request)
    {
        $usersPermissions = Session::get('userPermissions');
        $userInfo = Session::get('userInfo');
        $searchConditions = $caseNoCondition = '';

        //default list populate Condition/user permission based
        $permissionBasedConditions = self::getPermissionBasedConditions($usersPermissions);

        //search parameter
        $searchParameters = $request->searchParameter;

        //search by others field
        if (isset($searchParameters)) {
            if (isset($searchParameters['startDate'])) {
                if (isset($searchParameters['endDate'])) {
                    $endDate = date('Y-m-d', strtotime($searchParameters['endDate']));
                } else {
                    $endDate = date('d-m-Y', time());
                }
                $startDate = date('Y-m-d', strtotime($searchParameters['startDate']));

                $searchConditions .= "AND cl.trial_date BETWEEN '$startDate' AND '$endDate' ";
            }
            if (isset($searchParameters['appealStatus'])) {
                $appealStatus = $searchParameters['appealStatus'];
                $searchConditions .= "AND a.appeal_status='$appealStatus' ";
            }
            if (isset($searchParameters['caseStatus'])) {
                $caseStatus = $searchParameters['caseStatus'];
                $searchConditions .= "AND a.case_decision_id=$caseStatus ";
            }
            if (isset($searchParameters['gcoList'])) {
                $gco = $searchParameters['gcoList'];
                $searchConditions .= "AND a.gco_user_id=$gco ";
            }
            //            else{  // For Peshkar
            //                $userId=Session::get('userInfo')->username;
            //                $searchConditions.="AND a.peshkar_user_id=$userId ";
            //            }
            if (isset($searchParameters['caseNo'])) {
                $caseNo = $searchParameters['caseNo'];
                $searchConditions .= "AND a.case_no='$caseNo' ";
            }
        }

        $appeals = DB::connection('appeal')->select(
            DB::raw(
                "SELECT
                                a.id,
                                a.payment_status,
                                a.appeal_status,
                                a.gco_name,
                                a.case_no,
                                a.prev_case_no,
                                c.citizen_name,
                                CASE
                                   WHEN a.appeal_status = 'CLOSED' THEN \" \"
                                   ELSE  DATE_FORMAT(cl.trial_date,'%d-%m-%Y')
                                END AS trial_date,
                                xl.case_decision,
                                a.flag_on_trial
                            FROM appeals a
                            LEFT JOIN (
                                  SELECT xl.id, xl.appeal_id, xl.trial_date
                                  FROM cause_lists xl
                                  WHERE xl.id = (SELECT MAX(id) FROM cause_lists WHERE appeal_id = xl.appeal_id)
                            ) cl ON cl.appeal_id = a.id
                            LEFT JOIN (
                                SELECT cl2.appeal_id AS AppealID, cl2.id AS CauseListID, GROUP_CONCAT(csd.case_short_decision) AS case_decision
                                FROM cause_lists cl2
                                JOIN (
                                    SELECT MAX(cl1.id)   AS CauseListID, cl1.appeal_id AS AppealID
                                    FROM cause_lists cl1
                                    JOIN ( SELECT MAX(cl0.id) AS CauseListID, cl0.appeal_id AS AppealID FROM cause_lists cl0 GROUP BY cl0.appeal_id ) x0 ON x0.AppealID = cl1.appeal_id AND x0.CauseListID > cl1.id
                                    GROUP BY cl1.appeal_id
                                ) x1 ON x1.AppealID = cl2.appeal_id AND x1.CauseListID = cl2.id
                                LEFT JOIN causelist_caseshortdecisions clcsd ON clcsd.cause_list_id = cl2.id
                                LEFT JOIN case_shortdecisions csd ON csd.id = clcsd.case_shortdecision_id
                                GROUP BY cl2.appeal_id
                            ) xl ON xl.AppealID = a.id
                            JOIN case_decisions AS cd ON a.case_decision_id=cd.id
                            JOIN appeal_citizens ac ON ac.appeal_id=a.id AND ac.citizen_type_id=1
                            JOIN citizens c ON c.id=ac.citizen_id
                          WHERE $permissionBasedConditions  $searchConditions $caseNoCondition AND a.office_id = $userInfo->office_id
                          ORDER BY cl.trial_date ASC,cl.id ASC  ",
            ),
        );

        return $appeals;
    }

    public static function getNothiListBySearchParam($request)
    {
        $userInfo = Session::get('userInfo');
        $userRole = Session::get('userRole');
        $loginUserId = Session::get('userInfo')->username;
        $searchConditions = "a.appeal_status <> 'DRAFT'";

        if ($userRole == 'Peshkar' || $userRole == 'GCO' || $userRole == 'Recordroom Officer') {
            // Case Transfer Section [ Every one can access from same office ]
            //            if($userRole=='Peshkar'){
            //                $searchConditions.="AND a.peshkar_user_id='$loginUserId' ";
            //            }
            $searchConditions .= "AND a.office_id = '$userInfo->office_id'";
        }

        //search parameter
        $searchParameters = $request->searchParameter;

        if (isset($searchParameters)) {
            if (isset($searchParameters['startDate'])) {
                if (isset($searchParameters['endDate'])) {
                    $endDate = date('Y-m-d', strtotime(trim($searchParameters['endDate'])));
                } else {
                    $endDate = date('Y-m-d', time());
                }
                $startDate = date('Y-m-d', strtotime(trim($searchParameters['startDate'])));

                $searchConditions .= "AND cl.trial_date BETWEEN '$startDate' AND '$endDate' ";
            }

            if (isset($searchParameters['appealCaseNo'])) {
                $appealCaseNo = trim($searchParameters['appealCaseNo']);
                $searchConditions .= "AND a.case_no='$appealCaseNo' ";
            }

            if (isset($searchParameters['appealStatus'])) {
                $appealStatus = trim($searchParameters['appealStatus']);
                $searchConditions .= "AND a.appeal_status ='$appealStatus' ";
            }
            if (isset($searchParameters['upazillaId'])) {
                $upazillaId = trim($searchParameters['upazillaId']);
                $searchConditions .= "AND a.upazila_bbs_code ='$upazillaId' ";
            }

            if (isset($searchParameters['caseStatus'])) {
                $caseStatus = trim($searchParameters['caseStatus']);
                $searchConditions .= "AND a.case_decision_id = '$caseStatus' ";
            }
            if (isset($searchParameters['gcoList'])) {
                $gco = $searchParameters['gcoList'];
                $searchConditions .= "AND a.gco_user_id='$gco' ";
            }
        }

        $nothi = DB::connection('appeal')->select(
            DB::raw(
                "SELECT a.id,a.appeal_status,a.gco_name,
                       a.case_no,a.prev_case_no,cd.case_decision,
                        CASE
                           WHEN a.appeal_status = 'CLOSED' THEN \" \"
                           ELSE DATE_FORMAT(cl.trial_date, '%d-%m-%Y')
                        END AS trial_date
                       FROM cause_lists cl
                       JOIN (
                                   SELECT xl.appeal_id, MAX(xl.trial_date) AS trial_date
                                   FROM cause_lists xl
                                   GROUP BY xl.appeal_id
                            ) xl ON xl.appeal_id = cl.appeal_id AND xl.trial_date = cl.trial_date
                       JOIN appeals a ON a.id = cl.appeal_id
                       JOIN case_decisions AS cd ON a.case_decision_id=cd.id
                       WHERE  $searchConditions
                       GROUP BY a.id",
            ),
        );

        return $nothi;
    }

    public static function getAppealCaseAndCriminalId($id)
    {
        // $caseInfo = DB::connection('appeal')
        //     ->select(DB::raw(
        //         "SELECT a.id, a.case_no
        //                FROM appeals a
        //                WHERE a.id = $request->id"
        //     ));
        $caseInfo = DB::connection('mysql')->select(
            DB::raw(
                "SELECT a.id, a.case_no
                       FROM gcc_appeals a
                       WHERE a.id = $id",
            ),
        );
        // dd($caseInfo);
        return $caseInfo;
    }

    public static function getNothiListFromAppeal($id)
    {
        $getALLNothi = DB::table('gcc_attachments')->where('appeal_id', $id)->orderby('id', 'desc')->get();


        $index = 1;
        $nothiList = [];

        foreach ($getALLNothi as $getNothi) {
            $nothi['index'] = DataConversionService::toBangla($index);
            $nothi['id'] = $getNothi->id;
            $nothi['appeal_id'] = $getNothi->appeal_id;
            $nothi['cause_list_id'] = $getNothi->cause_list_id;
            $nothi['conduct_date'] = DataConversionService::toBangla(date('d-m-Y', strtotime($getNothi->created_at)));
            $nothi['file_type'] = $getNothi->file_type;
            $nothi['file_category'] = $getNothi->file_category;
            $nothi['file_name'] = $getNothi->file_name;
            $nothi['file_path'] = $getNothi->file_path;
            $index++;
            array_push($nothiList, $nothi);
        }

        return $nothiList;
    }

    public static function saveRaiOrder($request)
    {
        $transactionStatus = true;

        if (isset($request->sendOrderData)) {
            $id = $request->sendOrderData['raiID'];
            $RaiOrder = RaiOrder::find($id);
            if ($RaiOrder) {
                $RaiOrder->updated_at = date('Y-m-d H:i:s');
                $RaiOrder->updated_by = Session::get('userInfo')->username;
            } else {
                //new role create
                $RaiOrder = new RaiOrder();
                $RaiOrder->appeal_id = $request->sendOrderData['appealID'];
                $RaiOrder->appeal_case_no = $request->sendOrderData['appealCaseno'];
            }

            $RaiOrder->rai_header = $request->sendOrderData['raiOrderHeader'];
            $RaiOrder->rai_details = $request->sendOrderData['raiOrderBody'];
            $RaiOrder->rai_order_text = $request->sendOrderData['raiOrderTextDetails'];
            $RaiOrder->created_at = date('Y-m-d H:i:s');
            $RaiOrder->created_by = Session::get('userInfo')->username;

            if ($RaiOrder->save()) {
                $transactionStatus = true;
            } else {
                $transactionStatus = false;
            }
        }

        return $transactionStatus;
    }

    public static function getAppealandCriminalInfo($request)
    {
        $sqlRes = DB::connection('appeal')->select(
            DB::raw(
                "SELECT cl.trial_date,cl.conduct_date,a.case_no,
                     a.created_at, c.citizen_name,a.law_section,
                    nt.order_text,nt.cause_list_id, nt.created_date, nt.created_by_id,nt.created_by_name
                    FROM appeals a
                    JOIN appeal_citizens ac ON a.id = ac.appeal_id AND ac.citizen_type_id=1
                    JOIN citizens c ON ac.citizen_id = c.id
                    JOIN citizen_types ct ON ac.citizen_type_id = ct.id
                    JOIN notes nt ON a.id =nt.appeal_id
                    JOIN cause_lists cl ON cl.id=nt.cause_list_id
                    WHERE a.id = $request AND ct.id =1",
            ),
        );

        return $sqlRes;
    }
    // public  function fullAppealInfo($appeal){
    //     $appealId = $appeal->id;
    //     $citizens=$appeal->appealCitizens;
    //     $applicantCitizen=[];
    //     $defaulterCitizen=[];
    //     $guarantorCitizen=[];
    //     $lawerCitizen=[];
    //     $nomineeCitizen=[];
    //     $policeCitizen=[];
    //     $citizenAttendance=[];
    //     $notApprovedNoteList=[];
    //     $notApprovedAttachmentList=[];
    //     $notApprovedShortOrderList=[];

    //     foreach ($citizens as $citizen){
    //         $citizenTypes = $citizen->citizenType;

    //         foreach ($citizenTypes as $citizenType){

    //             if($citizenType->id==1){
    //                 $applicantCitizen=$citizen;
    //             }
    //             if($citizenType->id==2){
    //                 $defaulterCitizen=$citizen;
    //             }
    //             if($citizenType->id==3){
    //                 $guarantorCitizen=$citizen;
    //             }
    //             if($citizenType->id==4){
    //                 $lawerCitizen=$citizen;
    //             }
    //             if($citizenType->id==5){
    //                 $nomineeCitizen[]=$citizen;
    //             }
    //             if($citizenType->id==6){
    //                 $policeCitizen=$citizen;
    //             }
    //         }
    //     }
    //         $data['applicantCitizen']= $applicantCitizen;
    //         $data['defaulterCitizen']= $defaulterCitizen;
    //         $data['guarantorCitizen']= $guarantorCitizen;
    //         $data['lawerCitizen']= $lawerCitizen;
    //         $data['nomineeCitizen']= $nomineeCitizen;
    //         $data['policeCitizen']= $policeCitizen;
    //         $data['appealCauseList']= $appeal->appealCauseList; //appeal causelist model relation
    //         $data['appealNote']= $appeal->appealNotes ;         //appeal note model relation
    //         $data['citizenAttendance'] = $citizenAttendance;
    //         $data['noteCauseList']=NoteRepository::getNoteCauseListByAppealId($appealId);
    //         $data['attachmentList'] = AttachmentRepository::getAttachmentListByAppealId($appealId);
    // }

    public static function getCauselistCitizen($appealID)
    {
        $data = DB::table('gcc_appeals')
            ->join('gcc_appeal_citizens', 'gcc_appeals.id', 'gcc_appeal_citizens.appeal_id')
            ->join('gcc_citizens', 'gcc_citizens.id', 'gcc_appeal_citizens.citizen_id')
            ->where('gcc_appeals.id', $appealID)
            ->whereIn('gcc_appeal_citizens.citizen_type_id', [1, 2])
            ->select('gcc_appeal_citizens.citizen_type_id', 'gcc_citizens.citizen_name', 'gcc_appeals.case_no as case_no', 'gcc_appeals.next_date as next_date', 'gcc_appeals.appeal_status as appeal_status', 'gcc_appeals.case_date as case_date', 'gcc_citizens.id', 'gcc_appeals.manual_case_no as manual_case_no')
            ->get();
        //dd($data);
        if (count($data) > 0) {
            return [
                'next_date' => $data[0]->next_date,
                'case_no' => $data[0]->case_no,
                'manual_case_no' => $data[0]->manual_case_no,
                'appeal_status' => $data[0]->appeal_status,
                'applicant_name' => $data[1]->citizen_name,
                'defaulter_name' => $data[0]->citizen_name,
                'case_date' => $data[0]->case_date,
            ];
        } else {
            return null;
        }
    }
}