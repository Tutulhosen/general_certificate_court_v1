<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class NIDVerificationRepository
{
    public  function new_nid_verify_mobile_reg_first_api_call($requestInfo)
    {
        $get_additional_info_citizen = CitizenNIDVerifyRepository::getAdditionalInfoFromCitizen($requestInfo);
        $dob_in_db = str_replace('/', '-', $requestInfo->dob_number);
        $getNIDDataChunk = $this->getDataFromNIDVerificationAPi($requestInfo->nid_number, $dob_in_db);
       
        if (isset($getNIDDataChunk->success)) {
           
            if ($getNIDDataChunk->success) {
                $getNIDData = $getNIDDataChunk->data;

                $permanentAddressFromAPi = $getNIDData->address->permanentAddress;
                $presentAddressFromAPi = $getNIDData->address->presentAddress;
               
                $presentAddress_homeOrHoldingNo = isset($permanentAddressFromAPi->homeOrHoldingNo) ? $permanentAddressFromAPi->homeOrHoldingNo : '';
                $presentAddress_additionalVillageOrRoad = isset($permanentAddressFromAPi->additionalVillageOrRoad) ? $permanentAddressFromAPi->additionalVillageOrRoad : '';
               
                $presentAddress_additionalMouzaOrMoholla = isset($permanentAddressFromAPi->additionalMouzaOrMoholla) ? $permanentAddressFromAPi->additionalMouzaOrMoholla : '';
               
                $presentAddress_unionOrWard = isset($permanentAddressFromAPi->unionOrWard) ? $permanentAddressFromAPi->unionOrWard : '';
                $presentAddress_cityCorporationOrMunicipality = isset($permanentAddressFromAPi->cityCorporationOrMunicipality) ? $permanentAddressFromAPi->cityCorporationOrMunicipality : '';
               
                $presentAddress_postOffice = isset($permanentAddressFromAPi->postOffice) ? $permanentAddressFromAPi->postOffice : '';
                $presentAddress_postalCode = isset($permanentAddressFromAPi->postalCode) ? $permanentAddressFromAPi->postalCode : '';
                $presentAddress_upozila = isset($permanentAddressFromAPi->upozila) ? $permanentAddressFromAPi->upozila : '';
                $presentAddress_district = isset($permanentAddressFromAPi->district) ? $permanentAddressFromAPi->district : '';
                $presentAddress_division = isset($permanentAddressFromAPi->division) ? $permanentAddressFromAPi->division : ' ';
               
                $presentAddress_homeOrHoldingNo = isset($presentAddressFromAPi->homeOrHoldingNo) ? $presentAddressFromAPi->homeOrHoldingNo : '';
                $presentAddress_additionalVillageOrRoad = isset($presentAddressFromAPi->additionalVillageOrRoad) ? $presentAddressFromAPi->additionalVillageOrRoad : '';
               
                $presentAddress_additionalMouzaOrMoholla = isset($presentAddressFromAPi->additionalMouzaOrMoholla) ? $presentAddressFromAPi->additionalMouzaOrMoholla : '';
               
                $presentAddress_unionOrWard = isset($presentAddressFromAPi->unionOrWard) ? $presentAddressFromAPi->unionOrWard : '';
                $presentAddress_cityCorporationOrMunicipality = isset($presentAddressFromAPi->cityCorporationOrMunicipality) ? $presentAddressFromAPi->cityCorporationOrMunicipality : '';
               
                $presentAddress_postOffice = isset($presentAddressFromAPi->postOffice) ? $presentAddressFromAPi->postOffice : '';
                $presentAddress_postalCode = isset($presentAddressFromAPi->postalCode) ? $presentAddressFromAPi->postalCode : '';
                $presentAddress_upozila = isset($presentAddressFromAPi->upozila) ? $presentAddressFromAPi->upozila : '';
                $presentAddress_district = isset($presentAddressFromAPi->district) ? $presentAddressFromAPi->district : '';
                $presentAddress_division = isset($presentAddressFromAPi->division) ? $presentAddressFromAPi->division : ' ';
               
                $permanentAddress = $presentAddress_homeOrHoldingNo . ', ' . $presentAddress_additionalVillageOrRoad . ', ' . $presentAddress_additionalMouzaOrMoholla . ', ' . $presentAddress_unionOrWard . ' ' . $presentAddress_cityCorporationOrMunicipality . ', ' . $presentAddress_postOffice . '-' . $presentAddress_postalCode . ', ' . $presentAddress_upozila . ', ' . $presentAddress_district . ', ' . $presentAddress_division;
               
                $presentAddress = $presentAddress_homeOrHoldingNo . ', ' . $presentAddress_additionalVillageOrRoad . ', ' . $presentAddress_additionalMouzaOrMoholla . ', ' . $presentAddress_unionOrWard . ', ' . $presentAddress_cityCorporationOrMunicipality . ', ' . $presentAddress_postOffice . '-' . $presentAddress_postalCode . ', ' . $presentAddress_upozila . ', ' . $presentAddress_district . ', ' . $presentAddress_division;

                return response()->json([
                    'success' => 'success',
                    'name_bn' => $getNIDData->name,
                    'father' => $getNIDData->father_name,
                    'mother' => $getNIDData->mother_name,
                    'national_id' => $getNIDData->nid,
                    'gender' => strtoupper($getNIDData->gender),
                    'permanent_address' => $permanentAddress,
                    'present_address' => $presentAddress,
                    'dob' => $requestInfo->dob_number,
                    'email' => $get_additional_info_citizen['email'],
                    'designation' => $get_additional_info_citizen['designation'],
                    'organization' => $get_additional_info_citizen['organization'],
                    'organization_id' => $get_additional_info_citizen['organization_id'],
                    'message' => 'এন আই ডি তে সফলভাবে তথ্য পাওয়া গিয়েছে',
                ]);
            } else {
                return response()->json([
                    'success' => 'error',
                    'message' => $getNIDDataChunk->message,
                ]);
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => $getNIDDataChunk->message,
            ]);
        }
    }
    public function getDataFromNIDVerificationAPi($nid,$dob)
    {

        $idp_url = mygov_nid_verification_api_endpoint();
        $idp_api_key = mygov_nid_verification_api_key();
        $token_code = $this->getCustomBarrierTokenForNIDVerification();

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $idp_url . '/nid-brn-verifier-v2',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'dob' => "$dob",
                'verifier' => 'nid',
                'nid' => "$nid",
                ),
            CURLOPT_HTTPHEADER => array(
                'api-key: ' . $idp_api_key . '',
                "authorization: Bearer $token_code",
                'Accept: application/json',
            ),
        ));

        $final_results = curl_exec($curl);

        //$err = curl_error($curl);

        curl_close($curl);
        // echo $response;

        return json_decode($final_results);
    }
    public function getCustomBarrierTokenForNIDVerification()
    {
        $currentTime = \Carbon\Carbon::now();
        $thresholdTime = $currentTime->subHours(12);

        $expirationTime = DB::table('custom_tokens')
            ->where('token_name', 'IDPAPIToken')
            ->where('updated_at', '>=', $thresholdTime)
            ->first();

        if (empty($expirationTime)) {

            $login_token_data = $this->createTokenFromApi();

            if (!empty($login_token_data->message) && (($login_token_data->message === "API rate limit exceeded") || ($login_token_data->message === "Your IP address is not allowed"))) {
                $login_token = 1;
            } else {
                if ($login_token_data->success === false) {
                    $login_token = 1;
                } else {
                    // update Token
                    DB::table('custom_tokens')
                        ->updateOrInsert(
                            ['token_name' => 'IDPAPIToken'],
                            ['token' => $login_token_data->token]
                        );
                    $login_token = $login_token_data->token;
                }
            }
            // dd($login_token_data);
        } else {
            $login_token = $expirationTime->token;
        }

        return $login_token;
    }
    public function createTokenFromApi()
    {

        $idp_email = mygov_nid_verification_api_email();
        $idp_password = mygov_nid_verification_api_password();
        $idp_api_key = mygov_nid_verification_api_key();
        $idp_url = mygov_nid_verification_api_endpoint();
         
        // IDP Client Login API
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $idp_url . '/mygov-login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('email' => "$idp_email", 'password' => "$idp_password"),
            CURLOPT_HTTPHEADER => array(
                'api-key: ' . $idp_api_key . '',
                'Accept: application/json',
            ),
        ));

        $response = curl_exec($curl);
        $final_results = curl_exec($curl);

        curl_close($curl);

        //$err = curl_error($curl);

        $login_token = json_decode($final_results);

        return $login_token;
    }
}
