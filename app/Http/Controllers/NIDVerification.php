<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NIDVerification extends Controller
{
    // public function nid_verification(Request $request)
    // {

    //     $dob_in_db=str_replace('/','-',$request->dob_number);
    //     $exit_citizen=DB::table('gcc_citizens')->where('citizen_NID',$request->nid_number)->where('dob', '=', $dob_in_db)->where('citizen_phone_no', '=', $request->mobile_no)->first();

    //     if(!empty($exit_citizen))
    //     {
    //         return response()->json([
    //             'success' => 'success',
    //             'name_bn' => $exit_citizen->citizen_name,
    //             'father' => $exit_citizen->father,
    //             'mother' => $exit_citizen->mother,
    //             'national_id' => $exit_citizen->citizen_NID,
    //             'gender' => $exit_citizen->citizen_gender,
    //             'permanent_address' => $exit_citizen->permanent_address,
    //             'present_address' => $exit_citizen->present_address,
    //             'email'=>$exit_citizen->email,
    //             'designation'=>$exit_citizen->designation,
    //             'organization'=>$exit_citizen->organization,
    //             'organization_id'=>$exit_citizen->organization_id,
    //             'message'=>'সফলভাবে তথ্য পাওয়া গিয়েছে'
    //         ]);
    //     }

    //     $Nid_information = DB::table('dummy_nids')->where('national_id', '=', $request->nid_number)->where('mobile_no', '=', $request->mobile_no)->where('dob', '=', $dob_in_db)->first();

    //     // var_dump($Nid_information);
    //     // exit();
    //     if (!empty($Nid_information)) {

    //         return response()->json([
    //             'success' => 'success',
    //             'name_bn' => $Nid_information->name_bn,
    //             'father' => $Nid_information->father,
    //             'mother' => $Nid_information->mother,
    //             'national_id' => $Nid_information->national_id,
    //             'gender' => $Nid_information->gender,
    //             'permanent_address' => $Nid_information->permanent_address,
    //             'present_address' => $Nid_information->present_address,
    //             'email'=>null,
    //             'designation'=>null,
    //             'organization'=>null,
    //             'organization_id'=>null,
    //             'message'=>'এন আই ডি তে সফলভাবে তথ্য পাওয়া গিয়েছে'
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => 'error',
    //             'message'=>'কোন তথ্য খুজে পাওয়া যায় নাই'
    //         ]);
    //     }
    // }
    public function nid_verification(Request $request)
    {
        $validation_array = [
            'dob_number' => 'জন্ম তারিখ দিতে হবে',
            'mobile_no' => 'NID এর সাথে নিবন্ধিত মোবাইল নং দিতে হবে',
            'nid_number' => 'জাতীয় পরিচয়পত্র নং দিতে হবে',
        ];

        foreach ($validation_array as $key => $value) {
            if (empty($request->$key)) {
                return response()->json([
                    'success' => 'error',
                    'message' => $value,
                ]);
            }
        }

        $email = null;
        $designation = null;
        $organization = null;
        $organization_id = null;

        $dob_in_db = str_replace('/', '-', $request->dob_number);
        $exit_citizen = DB::table('gcc_citizens')->where('citizen_NID', $request->nid_number)->where('dob', '=', $dob_in_db)->where('citizen_phone_no', '=', $request->mobile_no)->first();

        if (!empty($exit_citizen)) {
            // return response()->json([
            //     'success' => 'success',
            //     'name_bn' => $exit_citizen->citizen_name,
            //     'father' => $exit_citizen->father,
            //     'mother' => $exit_citizen->mother,
            //     'national_id' => $exit_citizen->citizen_NID,
            //     'gender' => $exit_citizen->citizen_gender,
            //     'permanent_address' => $exit_citizen->permanent_address,
            //     'present_address' => $exit_citizen->present_address,
            //     'email'=>$exit_citizen->email,
            //     'designation'=>$exit_citizen->designation,
            //     'organization'=>$exit_citizen->organization,
            //     'organization_id'=>$exit_citizen->organization_id,
            //     'message'=>'সফলভাবে তথ্য পাওয়া গিয়েছে'
            // ]);

            $email = $exit_citizen->email;
            $designation = $exit_citizen->designation;
            $organization = $exit_citizen->organization;
            $organization_id = $exit_citizen->organization_id;
        }

        $getNIDDataChunk = $this->getDataFromNIDVerificationAPi($request->nid_number, $request->mobile_no, $dob_in_db);
        //dd($getNIDData);
        if (isset($getNIDDataChunk->success)) {
            if ($getNIDDataChunk->success) {
                $getNIDData = $getNIDDataChunk->data;

                $permanentAddress = $getNIDData->address->permanentAddress->homeOrHoldingNo . ' ' . $getNIDData->address->permanentAddress->postOffice . ' ' . $getNIDData->address->permanentAddress->postalCode . ' ' . $getNIDData->address->permanentAddress->upozila . ' ' . $getNIDData->address->permanentAddress->district . ' ' . $getNIDData->address->permanentAddress->division;

                $presentAddress = $getNIDData->address->presentAddress->homeOrHoldingNo . ' ' . $getNIDData->address->presentAddress->homeOrHoldingNo . ' ' . $getNIDData->address->presentAddress->homeOrHoldingNo . ' ' . $getNIDData->address->presentAddress->homeOrHoldingNo . ' ' . $getNIDData->address->presentAddress->homeOrHoldingNo . ' ' . $getNIDData->address->presentAddress->homeOrHoldingNo . ' ' . $getNIDData->address->presentAddress->homeOrHoldingNo;

                return response()->json([
                    'success' => 'success',
                    'name_bn' => $getNIDData->name,
                    'father' => $getNIDData->father_name,
                    'mother' => $getNIDData->mother_name,
                    'national_id' => $getNIDData->nid,
                    'gender' => strtoupper($getNIDData->gender),
                    'permanent_address' => $permanentAddress,
                    'present_address' => $presentAddress,
                    'email' => $email,
                    'designation' => $designation,
                    'organization' => $organization,
                    'organization_id' => $organization_id,
                    'message' => 'এন আই ডি তে সফলভাবে তথ্য পাওয়া গিয়েছে',
                ]);
            } else {
                return response()->json([
                    'success' => 'error',
                    'message' => 'কোন তথ্য খুজে পাওয়া যায় নাই',
                ]);
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => $getNIDDataChunk->message,
            ]);
        }

    }
    public function getNidPdfList()
    {
        $data['nids'] = DB::table('dummy_nids')->orderBy('id', 'desc')->get();
        return view('report.pdf_nid_list')->with($data);

        //$this->generatePDF($html);
    }
    public function getDataFromNIDVerificationAPi($nid, $phone, $dob)
    {

        $idp_url = mygov_nid_verification_api_endpoint();
        $idp_api_key = mygov_nid_verification_api_key();
        $token_code = $this->getCustomBarrierTokenForNIDVerification();

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $idp_url . '/nid-brn-verifier',
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
                'mobile' => "$phone"),
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
