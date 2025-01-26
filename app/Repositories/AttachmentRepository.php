<?php

/**
 * Created by PhpStorm.
 * User: destructor
 * Date: 11/29/2017
 * Time: 9:53 PM
 */

namespace App\Repositories;

use App\Appeal;

use App\Models\CauseList;
use App\Models\GccAttachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\GccRunningAppealAttachment;


class AttachmentRepository
{
    public static function appStoreAttachment($appName, $appealId, $causeListId, $captions, $request = null)
    {
        $image_name = $request->file_name['name'];
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;
        $log_file_data = [];
        // $test = [];
        // ["file_name"]['name']
        foreach ($image_name as $key => $file) {

            $fileCategory = $captions[$i];


            $base364mage = substr($file, strpos($file, ',') + 1);

            $extension = explode('/', explode(';', $file)[0])[1];
            $image_data = base64_decode($base364mage);
            //   $fileName=$fileCategory.$appealId.$extension;
            if ($file != "" && $fileCategory != null) {
                $fileName = strtolower($image_data);
                $fileExtension = '.' . $extension;

                $fileContentType = "";
                if (in_array($fileExtension, $image)) {
                    $fileContentType = 'IMAGE';
                }
                if (in_array($fileExtension, $document)) {
                    $fileContentType = 'DOCUMENT';
                }
                if (in_array($fileExtension, $pdf)) {
                    $fileContentType = 'PDF';
                }
                if (in_array($fileExtension, $excel)) {
                    $fileContentType = 'EXCEL';
                }
                if (in_array($fileExtension, $text)) {
                    $fileContentType = 'TEXT';
                }

                $fileName = self::getGUID() . $fileExtension;
                if ($fileContentType != "") {
                    $appealYear = 'APPEAL - ' . date('Y');
                    $appealID = 'AppealID - ' . $appealId;
                    $causeListID = 'CauseListID - ' . $causeListId;

                    $attachmentUrl = config('app.attachmentUrl');

                    $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/' . $causeListID . '/';
                    // dd($filePath);
                    if (!is_dir($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
                    $attachment = new GccAttachment();
                    $attachment->appeal_id = $appealId;
                    $attachment->cause_list_id = $causeListId;
                    $attachment->file_type = $fileContentType;
                    $attachment->file_category = $fileCategory;
                    $attachment->file_name = $fileName;
                    $attachment->file_path = $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/';
                    $attachment->file_submission_date = date('Y-m-d H:i:s');
                    $attachment->created_at = date('Y-m-d H:i:s');
                    // $attachment->created_by = Session::get('userInfo')->username;
                    $attachment->created_by = Auth::user()->username;
                    $attachment->updated_at = date('Y-m-d H:i:s');
                    // $attachment->updated_by = Session::get('userInfo')->username;
                    $attachment->updated_by = Auth::user()->username;
                    // dd($attachment);
                    $attachment->save();
                    // $test[$key] = $attachment;
                    // move_uploaded_file($image_data, $filePath . $fileName);
                    file_put_contents($filePath . $fileName, $image_data);
                    $file_in_log = [

                        'file_category' => $fileCategory,
                        'file_name' => $fileName,
                        'file_path' => $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/'
                    ];
                }
                array_push($log_file_data, $file_in_log);
            }
            $i++;
        }
        // dd($test);
        return json_encode($log_file_data);
    }
    public static function storeAttachment($appName, $appealId, $causeListId, $captions, $storePaymentInfo_payment_id)
    {
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;
        $log_file_data = [];
        // $test = [];
        // ["file_name"]['name']
        foreach ($_FILES['file_name']["name"] as $key => $file) {
            $tmp_name = $_FILES['file_name']["tmp_name"][$key];
            $fileName = $_FILES['file_name']["name"][$key];
            $fileCategory = $captions[$i];
            //dd($tmp_name.$fileName.$fileCategory);

            if ($fileName != "" && $fileCategory != null) {
                $fileName = strtolower($fileName);
                $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                $fileContentType = "";
                if (in_array($fileExtension, $image)) {
                    $fileContentType = 'IMAGE';
                }
                if (in_array($fileExtension, $document)) {
                    $fileContentType = 'DOCUMENT';
                }
                if (in_array($fileExtension, $pdf)) {
                    $fileContentType = 'PDF';
                }
                if (in_array($fileExtension, $excel)) {
                    $fileContentType = 'EXCEL';
                }
                if (in_array($fileExtension, $text)) {
                    $fileContentType = 'TEXT';
                }

                $fileName = self::getGUID() . $fileExtension;
                if ($fileContentType != "") {
                    $appealYear = 'APPEAL - ' . date('Y');
                    $appealID = 'AppealID - ' . $appealId;
                    $causeListID = 'CauseListID - ' . $causeListId;

                    $attachmentUrl = config('app.attachmentUrl');

                    $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/' . $causeListID . '/';
                    // dd($filePath);
                    if (!is_dir($filePath)) {
                        mkdir($filePath,  0777, TRUE);
                    }
                    $attachment = new GccAttachment();
                    $attachment->appeal_id = $appealId;
                    $attachment->cause_list_id = $causeListId;
                    $attachment->file_type = $fileContentType;
                    $attachment->file_category = $fileCategory;
                    $attachment->file_name = $fileName;
                    $attachment->file_path = $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/';
                    $attachment->file_submission_date = date('Y-m-d H:i:s');
                    $attachment->created_at = date('Y-m-d H:i:s');
                    if (!empty($storePaymentInfo_payment_id) && $_POST['is_payment_file'][$i] == "payment_file") {

                        $attachment->payment_id = $storePaymentInfo_payment_id;
                    }

                    $attachment->created_by = Auth::user()->username;
                    $attachment->updated_at = date('Y-m-d H:i:s');
                    // $attachment->updated_by = Session::get('userInfo')->username;
                    $attachment->updated_by = Auth::user()->username;
                    // dd($attachment);
                    $attachment->save();
                    // $test[$key] = $attachment;
                    move_uploaded_file($tmp_name, $filePath . $fileName);
                    $file_in_log = [

                        'file_category' => $fileCategory,
                        'file_name' => $fileName,
                        'file_path' => $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/'
                    ];
                }
                array_push($log_file_data, $file_in_log);
            }
            $i++;
        }
        // dd($test);
        return json_encode($log_file_data);
    }
    public static function onnannoStoreAttachment($appName, $appealId, $causeListId, $captions, $storePaymentInfo_payment_id)
    {
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;
        $log_file_data = [];
        // $test = [];
        // ["file_name"]['name']
        foreach ($_FILES['file_name']["name"] as $key => $file) {
            $tmp_name = $_FILES['file_name']["tmp_name"][$key];
            $fileName = $_FILES['file_name']["name"][$key];
            $fileCategory = $captions[$i];
            //dd($tmp_name.$fileName.$fileCategory);

            if ($fileName != "" && $fileCategory != null) {
                $fileName = strtolower($fileName);
                $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                $fileContentType = "";
                if (in_array($fileExtension, $image)) {
                    $fileContentType = 'IMAGE';
                }
                if (in_array($fileExtension, $document)) {
                    $fileContentType = 'DOCUMENT';
                }
                if (in_array($fileExtension, $pdf)) {
                    $fileContentType = 'PDF';
                }
                if (in_array($fileExtension, $excel)) {
                    $fileContentType = 'EXCEL';
                }
                if (in_array($fileExtension, $text)) {
                    $fileContentType = 'TEXT';
                }

                $fileName = self::getGUID() . $fileExtension;
                if ($fileContentType != "") {
                    $appealYear = 'APPEAL - ' . date('Y');
                    $appealID = 'AppealID - ' . $appealId;
                    $causeListID = 'CauseListID - ' . $causeListId;

                    $attachmentUrl = config('app.attachmentUrl');

                    $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/' . $causeListID . '/';
                    // dd($filePath);
                    if (!is_dir($filePath)) {
                        mkdir($filePath,  0777, TRUE);
                    }
                    $attachment = new GccRunningAppealAttachment();
                    $attachment->appeal_id = $appealId;
                    // $attachment->cause_list_id = $causeListId;
                    $attachment->file_type = $fileContentType;
                    $attachment->file_category = $fileCategory;
                    $attachment->file_name = $fileName;
                    $attachment->file_path = $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/';
                    // $attachment->file_submission_date = date('Y-m-d H:i:s');
                    $attachment->created_at = date('Y-m-d H:i:s');
                    if (!empty($storePaymentInfo_payment_id) && $_POST['is_payment_file'][$i] == "payment_file") {

                        $attachment->payment_id = $storePaymentInfo_payment_id;
                    }

                    $attachment->created_by = Auth::user()->username;
                    $attachment->updated_at = date('Y-m-d H:i:s');
                    // $attachment->updated_by = Session::get('userInfo')->username;
                    $attachment->updated_by = Auth::user()->username;
                    $attachment->attatch_type = 4;
                    // dd($attachment);
                    $attachment->save();
                    // $test[$key] = $attachment;
                    move_uploaded_file($tmp_name, $filePath . $fileName);
                    $file_in_log = [

                        'file_category' => $fileCategory,
                        'file_name' => $fileName,
                        'file_path' => $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/'
                    ];
                }
                array_push($log_file_data, $file_in_log);
            }
            $i++;
        }
        // dd($test);
        return json_encode($log_file_data);
    }

    public static function getAttachmentListByAppealId($appealId)
    {
        $attachmentList = DB::table('gcc_attachments')->where('appeal_id', $appealId)->get();
        return $attachmentList;
    }

    public static function getAttachmentListByAppealIdAndCauseListId($appealId, $causeListId)
    {
        // $attachmentList=DB::connection('appeal')
        $attachmentList = DB::connection('mysql')
            ->table('gcc_cause_lists')
            ->join('gcc_attachments', 'gcc_cause_lists.id', '=', 'gcc_attachments.cause_list_id')
            ->where('gcc_attachments.appeal_id', $appealId)
            ->where('gcc_cause_lists.id', $causeListId)
            ->get();
        return $attachmentList;
    }

    public static function getAttachmentListByPaymentId($paymentId)
    {
        $attachmentList = DB::connection('appeal')
            ->table('attachments')
            ->where('attachments.payment_id', $paymentId)
            ->get();
        return $attachmentList;
    }

    public static function deleteFileByFileID($fileID, $appeal_id)
    {
        $attachment = GccAttachment::find($fileID);
        $fileName = $attachment->file_name;


        $user = globalUserInfo();


        if ($user->role_id == 28) {

            $activity  = '<span>ফাইল মুছে ফেলা হয়েছে (সার্টিফিকেট সহকারী)</span>';
            $activity .= '<br>';
            $activity .= '<span>ফাইল এর নাম <strong>' . $attachment->file_category . '</strong></span>';
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'সার্টিফিকেট সহকারী';
            }
        } elseif ($user->role_id == 27) {


            $activity = '<span>ফাইল মুছে ফেলা হয়েছে(জেনারেল সার্টিফিকেট অফিসার)</span>';
            $activity .= '<br>';
            $activity .= '<span>ফাইল এর নাম <strong>' . $attachment->file_category . '</strong></span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেনারেল সার্টিফিকেট অফিসার';
            }
        }





        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set("Asia/Dhaka");

        $gcc_log_book = [
            'appeal_id' => $appeal_id,
            'user_id' => $user->id,
            'designation' => $designation,
            'activity' => $activity,
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('gcc_log_book')->insert($gcc_log_book);









        $attachmentUrl = config('app.attachmentUrl');
        $filePath = $attachmentUrl . $attachment->file_path;
        if ($attachment !== false) {
            if ($attachment->delete() === false) {

                $messages = $attachment->getMessages();

                foreach ($messages as $message) {
                    echo $message, "\n";
                }
            } else {
                unlink($filePath . $fileName);
            }
        }
    }

    public static function getGUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public static function storeAttachmentOnPayment($appName, $appealId, $paymentId, $captions)
    {
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;

        foreach ($_FILES["files"]["name"] as $key => $file) {
            $tmp_name = $_FILES["files"]["tmp_name"][$key]['someName'];
            $fileName = $_FILES["files"]["name"][$key]['someName'];
            $fileCategory = $captions[$i]['someCaption'];

            if ($fileName != "" && $fileCategory != null) {
                $fileName = strtolower($fileName);
                $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                $fileContentType = "";
                if (in_array($fileExtension, $image)) {
                    $fileContentType = 'IMAGE';
                }
                if (in_array($fileExtension, $document)) {
                    $fileContentType = 'DOCUMENT';
                }
                if (in_array($fileExtension, $pdf)) {
                    $fileContentType = 'PDF';
                }
                if (in_array($fileExtension, $excel)) {
                    $fileContentType = 'EXCEL';
                }
                if (in_array($fileExtension, $text)) {
                    $fileContentType = 'TEXT';
                }

                $fileName = self::getGUID() . $fileExtension;
                if ($fileContentType != "") {
                    $appealYear = 'APPEAL - ' . date('Y');
                    $appealID = 'AppealID - ' . $appealId;
                    $causeListID = 'PaymentID - ' . $paymentId;

                    $attachmentUrl = config('app.attachmentUrl');

                    $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/' . $causeListID . '/';
                    if (!is_dir($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
                    $attachment = new GccAttachment();
                    $attachment->appeal_id = $appealId;
                    $attachment->payment_id = $paymentId;
                    $attachment->file_type = $fileContentType;
                    $attachment->file_category = $fileCategory;
                    $attachment->file_name = $fileName;
                    $attachment->file_path = $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/';
                    $attachment->file_submission_date = date('Y-m-d H:i:s');
                    $attachment->created_at = date('Y-m-d H:i:s');
                    $attachment->created_by = globalUserInfo()->username;
                    $attachment->updated_at = date('Y-m-d H:i:s');
                    $attachment->updated_by = globalUserInfo()->username;
                    $attachment->save();
                    move_uploaded_file($tmp_name, $filePath . $fileName);
                }
            }
            $i++;
        }
    }
    public static function storeInvestirationCourtFree($appName, $appealId, $captions_main_investigation_report)
    {
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");


        $log_file_data = [];

        $tmp_name = $_FILES['court_fee_file']["tmp_name"];
        $fileName = $_FILES['court_fee_file']["name"];
        $fileCategory = 'x';

        if ($fileName != "" && $fileCategory != null) {
            $fileName = strtolower($fileName);
            $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);

            $fileContentType = "";
            if (in_array($fileExtension, $image)) {
                $fileContentType = 'IMAGE';
            }
            if (in_array($fileExtension, $document)) {
                $fileContentType = 'DOCUMENT';
            }
            if (in_array($fileExtension, $pdf)) {
                $fileContentType = 'PDF';
            }
            if (in_array($fileExtension, $excel)) {
                $fileContentType = 'EXCEL';
            }
            if (in_array($fileExtension, $text)) {
                $fileContentType = 'TEXT';
            }

            $fileName = self::getGUID() . $fileExtension;
            if ($fileContentType != "") {
                $appealYear = 'APPEAL - ' . date('Y');
                $appealID = 'AppealID - ' . $appealId;


                $attachmentUrl = config('app.attachmentUrl');

                $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/';
                // dd($filePath);
                if (!is_dir($filePath)) {
                    mkdir($filePath, 0777, true);
                }
                move_uploaded_file($tmp_name, $filePath . $fileName);
                $file_in_log = [
                    'file_category' => $captions_main_investigation_report,
                    'file_name' => $fileName,
                    'file_path' => $appName . '/' . $appealYear . '/' . $appealID . '/'
                ];
            }
            array_push($log_file_data, $file_in_log);
        }
        // dd($log_file_data);
        if (!empty($log_file_data)) {

            return json_encode($log_file_data);
        } else {
            return null;
        }
    }

    /*------------------------------------------------------------------------------
    running appeal means already this type of appeal running ganeral cetificate code
    --------------------------------------------------------------------------------*/
    public static function runningAppealStoreAttachment($appName, $appealId, $causeListId, $captions, $storePaymentInfo_payment_id, $orderId=null)
    {

        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;
        $logfile_data = [];
        // $test = [];
        // ["file_name"]['name']
        foreach ($_FILES['order_file_name']["name"] as $key => $file) {

            $tmp_name = $_FILES['order_file_name']["tmp_name"][$key];
            $fileName = $_FILES['order_file_name']["name"][$key];
            $fileCategory = @$captions[$i];
            
            // // $fileCategoryParsedObj= json_decode($fileCategoryObj);
            // dd('teo ifl',  $fileCategory, $orderId);
            // // $fileCategory = $fileCategoryParsedObj->name;
            // // $fileOrderId = $fileCategoryParsedObj->orderId;
            // // dd('teo ifl',  $fileCategory, $fileOrderId);
            // exit;
            // //dd($tmp_name.$fileName.$fileCategory);

            if ($fileName != "" && $fileCategory != null) {

                $fileName = strtolower($fileName);
                $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                $fileContentType = "";
                if (in_array($fileExtension, $image)) {
                    $fileContentType = 'IMAGE';
                }
                if (in_array($fileExtension, $document)) {
                    $fileContentType = 'DOCUMENT';
                }
                if (in_array($fileExtension, $pdf)) {
                    $fileContentType = 'PDF';
                }
                if (in_array($fileExtension, $excel)) {
                    $fileContentType = 'EXCEL';
                }
                if (in_array($fileExtension, $text)) {
                    $fileContentType = 'TEXT';
                }

                $fileName = self::getGUID() . $fileExtension;

                if ($fileContentType != "") {
                    $appealYear = 'APPEAL - ' . date('Y');
                    $appealID = 'AppealID - ' . $appealId;
                    $causeListID = 'CauseListID - ' . $causeListId;

                    $attachmentUrl = config('app.attachmentUrl');

                    $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/' . $causeListID . '/';

                    if (!is_dir($filePath)) {
                        mkdir($filePath,  0777, TRUE);
                    }

                    $attachment = new GccRunningAppealAttachment();
                    $attachment->appeal_id = $appealId;
                    $attachment->file_type = $fileContentType;
                    $attachment->file_category = $fileCategory;
                    $attachment->file_name = $fileName;
                    $attachment->file_path = $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/';
                    // $attachment->file_submission_date = date('Y-m-d H:i:s');
                    $attachment->created_at = date('Y-m-d H:i:s');
                    $attachment->created_by = Auth::user()->username;
                    $attachment->updated_at = date('Y-m-d H:i:s');
                    $attachment->updated_by = Auth::user()->username;
                    $attachment->attatch_type = 2;
                    $attachment->orderId= $orderId;
                    $attachment->save();

                    move_uploaded_file($tmp_name, $filePath . $fileName);

                    $file_in_log = [

                        'file_category' => $fileCategory,
                        'file_name' => $fileName,
                        'file_path' => $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/'
                    ];
                }
                array_push($logfile_data, $file_in_log);
            }
            $i++;
        }

        return json_encode($logfile_data);
    }

    public static function runningAppealOrder($appName, $appealId, $causeListId, $captions, $storePaymentInfo_payment_id)
    {
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;
        $logfile_data = [];
        // $test = [];
        // ["file_name"]['name']

        // foreach ($_FILES['order_file_name']["name"] as $key => $file) {

        $tmp_name = $_FILES['onama_file_name']["tmp_name"];
        $fileName = $_FILES['onama_file_name']["name"];
        $fileCategory = $captions;
        //dd($tmp_name.$fileName.$fileCategory);

        if ($fileName != "" && $fileCategory != null) {

            $fileName = strtolower($fileName);
            $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);

            $fileContentType = "";
            if (in_array($fileExtension, $image)) {
                $fileContentType = 'IMAGE';
            }
            if (in_array($fileExtension, $document)) {
                $fileContentType = 'DOCUMENT';
            }
            if (in_array($fileExtension, $pdf)) {
                $fileContentType = 'PDF';
            }
            if (in_array($fileExtension, $excel)) {
                $fileContentType = 'EXCEL';
            }
            if (in_array($fileExtension, $text)) {
                $fileContentType = 'TEXT';
            }

            $fileName = self::getGUID() . $fileExtension;

            if ($fileContentType != "") {
                $appealYear = 'APPEAL - ' . date('Y');
                $appealID = 'AppealID - ' . $appealId;
                $causeListID = 'CauseListID - ' . $causeListId;

                $attachmentUrl = config('app.attachmentUrl');

                $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/' . $causeListID . '/';

                if (!is_dir($filePath)) {
                    mkdir($filePath,  0777, TRUE);
                }

                $attachment = new GccRunningAppealAttachment();
                $attachment->appeal_id = $appealId;
                $attachment->file_type = $fileContentType;
                $attachment->file_category = $fileCategory;
                $attachment->file_name = $fileName;
                $attachment->file_path = $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/';
                // $attachment->file_submission_date = date('Y-m-d H:i:s');
                $attachment->created_at = date('Y-m-d H:i:s');
                $attachment->created_by = Auth::user()->username;
                $attachment->updated_at = date('Y-m-d H:i:s');
                $attachment->updated_by = Auth::user()->username;
                $attachment->attatch_type = 1;
                $attachment->save();

                move_uploaded_file($tmp_name, $filePath . $fileName);

                $file_in_log = [

                    'file_category' => $fileCategory,
                    'file_name' => $fileName,
                    'file_path' => $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/'
                ];
            }
            array_push($logfile_data, $file_in_log);
        }
        $i++;

        // }

        return json_encode($logfile_data);
    }

    public static function runningAppealOrderTemplate($appName, $appealId, $causeListId, $captions, $storePaymentInfo_payment_id)
    {
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;
        $logfile_data = [];
        // $test = [];
        // ["file_name"]['name']

        // foreach ($_FILES['order_file_name']["name"] as $key => $file) {

        $tmp_name = $_FILES['attendance_file_name']["tmp_name"];
        $fileName = $_FILES['attendance_file_name']["name"];
        $fileCategory = $captions;
        //dd($tmp_name.$fileName.$fileCategory);

        if ($fileName != "" && $fileCategory != null) {

            $fileName = strtolower($fileName);
            $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);

            $fileContentType = "";
            if (in_array($fileExtension, $image)) {
                $fileContentType = 'IMAGE';
            }
            if (in_array($fileExtension, $document)) {
                $fileContentType = 'DOCUMENT';
            }
            if (in_array($fileExtension, $pdf)) {
                $fileContentType = 'PDF';
            }
            if (in_array($fileExtension, $excel)) {
                $fileContentType = 'EXCEL';
            }
            if (in_array($fileExtension, $text)) {
                $fileContentType = 'TEXT';
            }

            $fileName = self::getGUID() . $fileExtension;

            if ($fileContentType != "") {
                $appealYear = 'APPEAL - ' . date('Y');
                $appealID = 'AppealID - ' . $appealId;
                $causeListID = 'CauseListID - ' . $causeListId;

                $attachmentUrl = config('app.attachmentUrl');

                $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/' . $causeListID . '/';

                if (!is_dir($filePath)) {
                    mkdir($filePath,  0777, TRUE);
                }

                $attachment = new GccRunningAppealAttachment();
                $attachment->appeal_id = $appealId;
                $attachment->file_type = $fileContentType;
                $attachment->file_category = $fileCategory;
                $attachment->file_name = $fileName;
                $attachment->file_path = $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/';
                // $attachment->file_submission_date = date('Y-m-d H:i:s');
                $attachment->created_at = date('Y-m-d H:i:s');
                $attachment->created_by = Auth::user()->username;
                $attachment->updated_at = date('Y-m-d H:i:s');
                $attachment->updated_by = Auth::user()->username;
                $attachment->attatch_type = 3;
                $attachment->save();

                move_uploaded_file($tmp_name, $filePath . $fileName);

                $file_in_log = [

                    'file_category' => $fileCategory,
                    'file_name' => $fileName,
                    'file_path' => $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/'
                ];
            }
            array_push($logfile_data, $file_in_log);
        }
        $i++;

        // }

        return json_encode($logfile_data);
    }
    /*------------------------------------------------------------------------------
    running appeal means already this type of appeal running ganeral cetificate code
    --------------------------------------------------------------------------------*/
}