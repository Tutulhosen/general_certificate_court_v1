<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'err_res' => '',
            'status' => 200,
            'data'    => $result,
        ];

        return response()->json($response, 200);
    }

    public function NewSendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'err_res' => '',
            'status_code' => 200,
            'data'    => $result,
            'total' => $result->total(),
            'prev'  => $result->previousPageUrl(),
            'next'  => $result->nextPageUrl(),
            'current_page'  => $result->CurrentPage(),
            'per_page'  => $result->PerPage(),
        ];
        return response()->json($response, 200);
    }

    public function groupUserResponse($result, $message, $case = [])
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'err_res' => '',
            'status' => 200,
            'case_info' =>$case,
            'data'    => $result,
        ];
        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
            'err_res' => null,
            'status' => $code,
            'data' => null,
        ];

        if(!empty($errorMessages)){
            $response['err_res'] = $errorMessages['error'];
        }

        return response()->json($response, $code);
    }

    public function sendErrormgs($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $errorMessages,
            'err_res' => null,
            'status' => $code,
            'data' => null,
        ];



        return response()->json($response, $code);
    }
}
