<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Action;
use App\Models\CaseRegister;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CommonController;
use App\Models\CaseHearing;
use App\Models\CaseSF;
use App\Models\CaseSFlog;
use App\Models\GccCitizen;
use Validator, Input, Redirect;
// use Mpdf\Mpdf;

class ApiCitizenCheckController extends Controller
{
  public function citizen_check(Request $request){
    //   return $request;
      $dob = $request->dob;
      $date_format = str_replace('/', '-', $dob);
      $dob = date("Y-m-d", strtotime($date_format));
    //   return $dob;

    $data['citizen'] = $citizen = GccCitizen::where('dob', $dob)->where('citizen_NID', $request->nid)->first();
    // return $citizen;
    if($citizen){
        return $this->sendResponse($data, 'সফলভাবে নাগরিকের তথ্য পাওয়া গেছে');
    }
    return $this->sendError('error', 'দুঃখিত ! কোনো নাগরিকের তথ্য পাওয়া যায়নি');
  }


  public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'err_res' => '',
            'status_code' => 200,
            'data'    => $result,
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages, $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
            'err_res' => $errorMessages,
            'status_code' => $code,
            'data' => null,
        ];

        return response()->json($response, $code);
    }
}


