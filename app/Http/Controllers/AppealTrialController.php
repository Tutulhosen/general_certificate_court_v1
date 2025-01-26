<?php

namespace App\Http\Controllers;

use App\Models\AuctionOrder;
use App\Models\User;
use Mcms\Auth\Exception;
use App\Models\GccAppeal;
use App\Models\Attachment;
use App\Models\GccCauseList;
use App\Models\GccLegalInfo;
use Illuminate\Http\Request;
use App\Models\GccPaymentList;
use App\Models\GccAppealCitizen;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\NoteRepository;
use Illuminate\Support\Facades\Http;
use App\Models\GccCaseKharijTemplates;
use App\Repositories\AppealRepository;
use App\Repositories\CitizenRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\CauseListRepository;
use App\Repositories\UserAgentRepository;
use App\Services\AppealOrderSheetService;
use App\Repositories\AttachmentRepository;
use App\Repositories\ShortOrderRepository;
use App\Services\ShortOrderTemplateService;
use App\Repositories\LogManagementRepository;
use App\Repositories\OnlineHearingRepository;
use App\Repositories\SMSNotificationRepository;
use App\Repositories\CitizenAttendanceRepository;
use App\Repositories\EmailNotificationRepository;
use App\Services\ShortOrderTemplateServiceUpdated;
use App\Repositories\CertificateAsstNoteRepository;
use App\Repositories\CauseListShortDecisionRepository;

class AppealTrialController extends Controller
{
    public $permissionCode = 'certificateTrial';

    public function showTrialPage(Request $request, $id)
    {
        $id = decrypt($id);
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();

        $appeal = GccAppeal::findOrFail($id);
        $loan_amount_expense = $appeal->loan_amount * 2.5 / 100;
        $interest_amount = $appeal->loan_amount * (int) $appeal->interestRate / 100;
        $loan_amount_with_interest = $appeal->loan_amount + $interest_amount;
        $total_jari = $loan_amount_with_interest + $loan_amount_expense;
        // dd($interest_amount, $appeal->loan_amount);
        $data = AppealRepository::getAllAppealInfo($id);
        $data['appeal'] = $appeal;
        $data['loan_amount_expense'] = $loan_amount_expense;
        $data['loan_amount_with_interest'] = $loan_amount_with_interest;
        $data['interest_amount'] = $interest_amount;
        $data['total_jari'] = $total_jari;
        $data['notes'] = $appeal->appealNotes;
        $data['districtId'] = $officeInfo->district_id;
        $data['divisionId'] = $officeInfo->division_id;
        $data['office_id'] = $office_id;
        $data['gcoList'] = User::where('office_id', $user->office_id)
            ->where('id', '!=', $user->id)
            ->get();
        $data['shortOrderList'] = ShortOrderRepository::getShortOrderList();
        $data['kharijTemplete'] = GccCaseKharijTemplates::where('appeal_id', $id)
            ->select('template_name', 'template_full')
            ->first();
        $data['certificate_asst_initial_comments'] = CertificateAsstNoteRepository::certificate_asst_initial_comments($id);

        $shortoder_array = CertificateAsstNoteRepository::order_list($id);

        $data['shortoder_array'] = isset($shortoder_array) ? $shortoder_array : [];

        $data['page_title'] = 'জেনারেল সার্টিফিকেট কোর্ট পরিচালনা';
        //return $data;

        return view('appealTrial.appealTrial')->with($data);
    }

    public function getKharijApplicationSheets(Request $request, $id)
    {
        $data['kharijTemplete'] = GccCaseKharijTemplates::where('appeal_id', $id)
            ->select('template_name', 'template_full')
            ->first();

        $data['page_title'] = 'মামলা খারিজের আবেদন পত্র';
        // return $data;
        return view('appealTrial.inc.kharijApplicatin')->with($data);
    }
    // public function showTrialPage(Request $request){
    //     $appealId=$request->id;
    //     $appealDetails = Appeal::where('id',$appealId)->first();
    //     $userRole = Session::get('userRole');

    //     // return view('appealTrial.appealTrial',compact('appealId',$appealId,'appealDetails',$appealDetails,'userRole',$userRole));
    //     return view('appealTrial.appealTrial',compact('appealId', 'appealDetails', 'userRole'));

    // }

    public function lastOrderDelete(Request $request)
    {
        if ($request->ajax()) {
            try {
                $causeListId = $request->causeListId;
                $appealId = $request->appealId;
                $appealDetails = Appeal::where('id', $appealId)->first();

                // Delete Last CauseList
                $lastCauseList = CauseListRepository::getPreviousCauseListId($appealId);
                CauseListRepository::destroyCauseListByCauseListId($lastCauseList->id);

                // Delete citizen Attendance
                $previouseCauseList = CauseListRepository::getPreviousCauseListId($appealId);
                CitizenAttendanceRepository::deletCitizenAttendanceByPreviousCaseDate($previouseCauseList->conduct_date, $appealId);

                // Delete appeal_order_sheets
                $previousOrderSheetList = AppealOrderSheetService::getLastOrderSheetByAppealId($appealId);
                AppealOrderSheetService::destroyOrderSheetByOrderSheetId($previousOrderSheetList->id);

                // Delete Note
                NoteRepository::destroyNoteByCauseListId($appealId, $causeListId);

                // File Delete
                $attachments = Attachment::where('appeal_id', $appealId)
                    ->where('cause_list_id', $causeListId)
                    ->get();
                foreach ($attachments as $attachment) {
                    AttachmentRepository::deleteFileByFileID($attachment->id);
                }

                // Delete Case Short decision
                CauseListShortDecisionRepository::deleteShortOrderListByCauseListId($causeListId);

                // Delete Case Short order template
                ShortOrderTemplateService::deleteShortOrderTemplate($causeListId);

                $flag = 'true';
            } catch (\Exception $e) {
                $flag = 'false';
            }
        }
        return response()->json([
            'flag' => $flag,
        ]);
    }

    public function storeOnTrialInfo(Request $request)
    {
        
        $return_validated = $this->validate_request_data($request);
        if (!empty($return_validated)) {
            return $return_validated;
        }
      
        // dd($request->shortOrder);
        DB::beginTransaction();

        try {
            if ($request->shortOrder != null) {
                // dd('come alfjl;kasjd');
                foreach ($request->shortOrder as $o) {
                    if ($o == 23) {
                        try {
                            $auction_order_id = DB::table('auction_order')->insertGetId([
                                'najirsName' => $request->najirsName,
                                'najirsMobile' => $request->najirsMobile,
                                'najirsEmail' => $request->najirsEmail,
                                'buyersName' => $request->buyersName,
                                'buyersMobile' => $request->buyersMobile,
                                'buyersEmail' => $request->buyersEmail,
                                'appealId' => $request->appealId
                            ]);
                        } catch (\Exception $e) {
                            // Log or display the error message
                            dd($e->getMessage());
                        }
                    }
                }
            }

            $time = $request->trialTime;
            $chngdtime = date('H:i', strtotime($time));
            $appealId = AppealRepository::storeAppealForOnTrial($request);
            $gcc_note_id = NoteRepository::store_gco_note($request, $appealId);
            
            if ($request->file_type && $_FILES['file_name']['name']) {
                $log_file_data = AttachmentRepository::storeAttachment('APPEAL', $appealId, date('Y-m-d'), $request->file_type, null);
            } else {
                $log_file_data = null;
            }
            
            $generateShortOrderTemplateID = ShortOrderTemplateServiceUpdated::generateShortOrderTemplate($request->shortOrder, $appealId, null, $request);
            
            
            
            if (!empty($generateShortOrderTemplateID)) {
                $shortorderTemplateUrl = [];
                $shortorderTemplateName = [];
                foreach ($generateShortOrderTemplateID as $value) {
                    array_push($shortorderTemplateUrl, url('/') . '/appeal/get/shortOrderSheets/' . $value);
                    array_push($shortorderTemplateName, get_short_order_name_by_id($value));
                }
            } else {
                $shortorderTemplateUrl = null;
                $shortorderTemplateName = null;
            }
            DB::table('gcc_notes_modified')
            ->where('id', $gcc_note_id)
            ->update([
                'gcc_attachmets' => $log_file_data,
            ]);
            

            // if ($request->status != 'CLOSED') {
            //     OnlineHearingRepository::storeHearingKey($appealId, $request->shortOrder[0], $request->trialDate, $request->trialTime);
            // }

            //sms
            $this->get_sms_data($request, $shortorderTemplateUrl);
         
    
            if (!empty($generateShortOrderTemplateID)) {

                EmailNotificationRepository::send_email_notification($request, $shortorderTemplateUrl, $shortorderTemplateName);
            }
          
            LogManagementRepository::storeOnTrialInfo($request, $appealId, $log_file_data);
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            $flag = 'false';
            DB::rollback();
            // dd($e);
            $flag = 'false';

            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                'message' => 'Internal Server Error',
                'status' => 'error',
            ]);
        }


        /*-----------------sent sms to defaulter ----------------------*/
        if ($request->defaulter_reg_notification == 1 && $request->status == 'ON_TRIAL') {
            $citizenInfo = CitizenRepository::getDefaulterCitizen($appealId);
            $caseNumber = GccAppeal::where('id', $appealId)->first();
            $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;
            $message = $citizenInfo['defaulterCitizen']->citizen_name . ' আপনার বিরুদ্ধে জেনারেল সার্টিফিকেট আদালতে একটি মামলা করা হয়েছে। মামলা নম্বরঃ ' . $caseNumber->case_no . ' । মামলার বিস্তারিত তথ্য জানার জন্য এই ' . url('/') . ' লিঙ্কে প্রবেশ করুন। ';
            $this->send_sms($mobile, $message);
        }

        return response()->json([
            'success' => 'আদেশ সফলভাবে সংরক্ষণ করা হয়েছে',
            'status' => 'success',
            'message' => 'আদেশ সফলভাবে সংরক্ষণ করা হয়েছে',
        ]);
    }
    public function collectPaymentAmount(Request $request, $id)
    {
        // return $id;
        $appealId = decrypt($id);
        $appeal = GccAppeal::find($appealId);

        $paymentInfo = [];
        $totalLoanAmount = '';
        $caseNumber = '';
        $caseID = '';
        $totalDueAmount = '';
        if (isset($appealId)) {
            $totalLoanAmount = $appeal->loan_amount;
            $caseNumber = $appeal->case_no;
            $caseID = $appeal->id;
            $paymentStatus = $appeal->payment_status;
            $paymentInfo = PaymentService::getPaidListByAppealId($appealId);
            $totalDueAmount = PaymentService::getTotalDueAmount($appealId, $totalLoanAmount);
            $totalAuctionSale = PaymentService::getAuctionTotalAmount($appealId);
            // dd('minar');
        }

        $data = [
            'caseNumber' => $caseNumber,
            'caseID' => $caseID,
            'paymentStatus' => $paymentStatus,
            'totalAuctionSale' => $totalAuctionSale,
            'paymentList' => $paymentInfo,
            'totalLoanAmount' => $totalLoanAmount,
            'totalDueAmount' => $totalDueAmount,
            'appealId' => $appealId,
            'page_title' => 'অর্থ আদায়',
        ];
        // return $data;
        return view('paymentList.paymentList')->with($data);

        // return view('paymentList.paymentList')->with('appealId',$appealId);
    }

    public function printCollectPaymentAmount(Request $request, $id)
    {
        // return $id;
        $appealId = decrypt($id);
        $appeal = GccAppeal::find($appealId);

        $paymentInfo = [];
        $totalLoanAmount = '';
        $caseNumber = '';
        $totalDueAmount = '';
        if (isset($appealId)) {
            $totalLoanAmount = $appeal->loan_amount;
            $caseNumber = $appeal->case_no;
            $paymentStatus = $appeal->payment_status;
            $paymentInfo = PaymentService::getPaidListByAppealId($appealId);
            $totalDueAmount = PaymentService::getTotalDueAmount($appealId, $totalLoanAmount);
            $totalAuctionSale = PaymentService::getAuctionTotalAmount($appealId);
            // dd('minar');
        }

        $data = [
            'caseNumber' => $caseNumber,
            'paymentStatus' => $paymentStatus,
            'totalAuctionSale' => $totalAuctionSale,
            'paymentList' => $paymentInfo,
            'totalLoanAmount' => $totalLoanAmount,
            'totalDueAmount' => $totalDueAmount,
            'appealId' => $appealId,
            'page_title' => 'অর্থ আদায়',
        ];
        // return $data;
        return view('paymentList.printPaymentList')->with($data);

        // return view('paymentList.paymentList')->with('appealId',$appealId);
    }

    public function collectPaymentList(Request $request)
    {
        $results = GccAppeal::orderby('id', 'desc');

        $roleID = globalUserInfo()->role_id;

        if ($roleID == 6) {
            $results = $results->whereIn('appeal_status', ['ON_TRIAL_DC'])->where('district_id', user_district()->id);
        } elseif ($roleID == 27 || $roleID == 28) {
            $results = $results->whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', globalUserInfo()->court_id);
        } elseif ($roleID == 25) {
            $results = $results->whereIn('appeal_status', ['ON_TRIAL_LAB_CM'])->where('updated_by', globalUserInfo()->id);
        } elseif ($roleID == 34) {
            $results = $results->whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])->where('division_id', user_office_info()->division_id);
        }
        $results = $results
            ->whereHas('causelistCaseshortdecision', function ($query) {
                $query->where('case_shortdecision_id', 19);
            })
            ->paginate(20);

        $date = date($request->date);
        $caseStatus = 1;
        $userRole = globalUserInfo()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = globalUserInfo()->username;
        }
        $page_title = 'অর্থ আদায় মামলার তালিকা';
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function storeAppealPaymentInfo(Request $request)
    {
        // return $request;
        $appealId = $request->appealId;
        $lastPayment = PaymentRepository::storePaymentInfo($appealId, $request);
        $paymentId = $lastPayment->id;

        if ($request->att_file_caption && $request->att_file) {
            $appealYear = 'APPEAL - ' . date('Y');
            $appealID = 'AppealID - ' . $appealId;
            $filePath = 'APPEAL/' . $appealYear . '/' . $appealID . '/' . 'paymentInfo/';
            $fileName = $appealId . '_' . time() . '.' . request()->att_file->getClientOriginalExtension();
            $request->att_file->move(public_path($filePath), $fileName);
            $lastPayment->att_file = $filePath . $fileName;
            $lastPayment->att_file_caption = $request->att_file_caption;
            $lastPayment->save();
            $file_in_log = json_encode([
                'file_category' => $request->att_file_caption,
                'file_path' => $filePath . $fileName,
                'file_name' => ' ',
            ]);
        } else {
            $file_in_log = null;
        }
        $user = globalUserInfo();
        if ($user->role_id == 27) {
            $activity = '<span>নিলাম কারীর নাম ' . $request->auctioneerName . '</span>';
            $activity .= '<br>';
            $activity .= '<span>নিলাম গ্রহীতার নাম ' . $request->auctioneerRecipientName . '<span>';
            $activity .= '<br>';
            $activity .= '<span>নিলামের তারিখ ' . $request->auctionDate . '<span>';
            $activity .= '<br>';
            $activity .= '<span>নিলামে বিক্রিত অর্থ ' . $request->auctionSale . '<span>';
            $activity .= '<br>';
            $activity .= '<span>জমা/কিস্তি ' . $request->installMentPay . '<span>';
            $activity .= '<br>';
            $activity .= '<span>অর্থ আদায়ের তারিখ ' . $request->payDate . '<span>';
            $activity .= '<br>';
            $activity .= '<span>সূত্র/রশিদ নম্বর ' . $request->payReceipt . '<span>';
            $activity .= '<br>';
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেনারেল সার্টিফিকেট অফিসার';
            }

            $obj = new UserAgentRepository();

            $browser = $obj->detect()->getInfo();
            date_default_timezone_set('Asia/Dhaka');

            $gcc_log_book = [
                'appeal_id' => $appealId,
                'user_id' => $user->id,
                'designation' => $designation,
                'activity' => $activity,
                'files' => $file_in_log,
                'browser' => $browser,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            //dd($gcc_log_book);
            DB::table('gcc_log_book')->insert($gcc_log_book);
        }

        return redirect()
            ->back()
            ->with('success', 'অর্থ আদায় সফলভাবে সংরক্ষণ করা হয়েছে!');
        return response()->json([
            'flag' => isset($paymentId) ? 'true' : 'false',
        ]);
    }

    public function deletePaymentInfoById($id)
    {
        $id = decrypt($id);
        $msg = 'মামলা সফলভাবে মুছে ফেলা হয়েছে!';
        $paymentInfo = GccPaymentList::find($id);
        if ($paymentInfo->att_file != null) {
            $path = public_path() . '/' . $paymentInfo->att_file;
            unlink($path);
        }
        $paymentInfo->delete();
        return redirect()
            ->back()
            ->with('success', $msg);
    }
    public function status_change(Request $request, $id)
    {
        $id = decrypt($id);
        $msg = 'মামলা সফলভাবে প্রেরণ করা হয়েছে!';
        $appeal = GccAppeal::findOrFail($id);
        $appeal->appeal_status = $request->status;
        $appeal->updated_at = date('Y-m-d H:i:s');
        $appeal->updated_by = globalUserInfo()->id;

        $send_to_whome = ' ';

        if ($request->status == 'REJECTED') {
            $appeal->case_decision_id = 5; //REJECTED
            $msg = 'মামলা সফলভাবে বর্জন করা হয়েছে';
        }
        if ($request->status == 'SEND_TO_DC') {
            $appeal->case_decision_id = 4; //কোর্ট বদলি

            $send_to_whome = 'জেলা প্রশাসকের কাছে পাঠানো হয়েছে';
            if (isset(globalUserInfo()->designation)) {
                $designation = globalUserInfo()->designation;
            } else {
                $designation = 'জেনারেল সার্টিফিকেট অফিসার';
            }
        }
        if ($request->status == 'SEND_TO_DIV_COM') {
            $appeal->case_decision_id = 4; //কোর্ট বদলি
            $send_to_whome = 'বিভাগীয় কমিশনারের কাছে পাঠানো হয়েছে';
            if (isset(globalUserInfo()->designation)) {
                $designation = globalUserInfo()->designation;
            } else {
                $designation = 'জেলা প্রশাসক';
            }
        }
        if ($request->status == 'SEND_TO_NBR_CM') {
            $appeal->case_decision_id = 4; //কোর্ট বদলি

            $send_to_whome = 'ভূমি আপীল বোর্ড চেয়ারপারসন কাছে পাঠানো হয়েছে';
            if (isset(globalUserInfo()->designation)) {
                $designation = globalUserInfo()->designation;
            } else {
                $designation = 'বিভাগীয় কমিশনার';
            }
        }
        // return $appeal;

        if ($appeal->save()) {
            $activity = $send_to_whome;

            $obj = new UserAgentRepository();

            $browser = $obj->detect()->getInfo();
            date_default_timezone_set('Asia/Dhaka');
            $gcc_log_book = [
                'appeal_id' => $id,
                'user_id' => globalUserInfo()->id,
                'designation' => $designation,
                'activity' => $activity,
                'browser' => $browser,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            DB::table('gcc_log_book')->insert($gcc_log_book);
            return redirect(route('appeal.index'))->with('success', $msg);
        }
        return redirect()
            ->back()
            ->with('error', 'দুঃখিত, কিছু ভুল হয়েছে!');
    }

    public function report_add(Request $request)
    {
        if (empty($request->report_file)) {
            return response()->json([
                'error' => 'error',
                'error_details' => 'ফাইল যুক্ত করুন',
            ]);
        }
        if (empty($request->report_details)) {
            return response()->json([
                'error' => 'error',
                'error_details' => 'বিস্তারিত দিন',
            ]);
        }

        $appealId = $request->hide_case_id;
        $legalInfos = GccLegalInfo::where('appeal_id', $appealId)->get();
        if (count($legalInfos) != 0) {
            foreach ($legalInfos as $item) {
                if (isset($item->report_file) && file_exists($item->report_file)) {
                    unlink($item->report_file);
                }
                $item->delete();
            }
        }

        $legalInfo = new GccLegalInfo();
        $legalInfo->appeal_id = $request->hide_case_id;
        $legalInfo->report_date = $request->report_date;
        $legalInfo->report_details = $request->report_details;
        $legalInfo->report_file = 'path';
        $legalInfo->created_by = globalUserInfo()->id;

        $legalInfo->appeal_id = $request->hide_case_id;
        if ($legalInfo->report_file != null) {
            $appealYear = 'APPEAL - ' . date('Y');
            $appealID = 'AppealID - ' . $appealId;
            $filePath = 'APPEAL/' . $appealYear . '/' . $appealID . '/' . 'legalInfo/';

            $fileName = $appealId . '_' . time() . '.' . request()->report_file->getClientOriginalExtension();
            $request->report_file->move(public_path($filePath), $fileName);
            $legalInfo->report_file = $filePath . $fileName;
            // return $fileName;
        }
        if ($legalInfo->save()) {
            DB::table('gcc_appeals')
                ->where('id', $appealId)
                ->update([
                    'is_zarikarok_report_submitted' => 1,
                ]);

            $user = globalUserInfo();

            $log_file_data = json_encode([
                'file_category' => '',
                'file_path' => $filePath . $fileName,
                'file_name' => '',
            ]);
            $activity = '<span>জারিকারের রিপোর্ট ';
            $activity .= '<br>';
            $activity .= '<span>তারিখ : ' . $request->report_date . '</span>';
            $activity .= '<br>';
            $activity .= '<span>বিস্তারিত: ' . $request->report_details . '</span>';

            if ($user->role_id == 27) {
                if (isset($user->designation)) {
                    $designation = $user->designation;
                } else {
                    $designation = 'জেনারেল সার্টিফিকেট অফিসার';
                }
            } elseif ($user->role_id == 28) {
                if (isset($user->designation)) {
                    $designation = $user->designation;
                } else {
                    $designation = 'সার্টিফিকেট সহকারী';
                }
            } elseif ($user->role_id == 6) {
                if (isset($user->designation)) {
                    $designation = $user->designation;
                } else {
                    $designation = 'জেলা প্রশাসক';
                }
            } elseif ($user->role_id == 34) {
                if (isset($user->designation)) {
                    $designation = $user->designation;
                } else {
                    $designation = 'বিভাগীয় কমিশনার';
                }
            } elseif ($user->role_id == 25) {
                if (isset($user->designation)) {
                    $designation = $user->designation;
                } else {
                    $designation = 'ভূমি আপীল বোর্ড চেয়ারপারসন';
                }
            } elseif ($user->role_id == 2) {
                if (isset($user->designation)) {
                    $designation = $user->designation;
                } else {
                    $designation = 'Admin';
                }
            } elseif ($user->role_id == 1) {
                if (isset($user->designation)) {
                    $designation = $user->designation;
                } else {
                    $designation = 'Admin';
                }
            }

            $obj = new UserAgentRepository();

            $browser = $obj->detect()->getInfo();
            date_default_timezone_set('Asia/Dhaka');
            $gcc_log_book = [
                'appeal_id' => $appealId,
                'user_id' => $user->id,
                'designation' => $designation,
                'activity' => $activity,
                'files' => $log_file_data,
                'browser' => $browser,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            DB::table('gcc_log_book')->insert($gcc_log_book);

            $html = view('appealTrial.inc._legalReportSection')
                ->with(['legalInfo' => $legalInfo])
                ->render();
            return Response()->json(['success' => 'জারিকারকের রিপোর্ট সংরক্ষণ করা হয়েছে', 'data' => $html]);
        }
        return Response()->json(['error' => 'Something went wrong!', 'data' => []]);
    }

    public function attendance_print($id)
    {
        $appeal = GccAppeal::find($id);
        $citizens = GccAppealCitizen::with('Citizen')
            ->where('appeal_id', $id)
            ->whereIn('citizen_type_id', [1, 2])
            ->get();
        $data['applicant'] = [
            'citizen_name' => $citizens[0]->citizen_type_id == 1 ? $citizens[0]->citizen->citizen_name : $citizens[1]->citizen->citizen_name,
            'designation' => $citizens[0]->citizen_type_id == 1 ? $citizens[0]->citizen->designation : $citizens[1]->citizen->designation,
        ];
        $data['defaulter'] = [
            'citizen_name' => $citizens[0]->citizen_type_id == 2 ? $citizens[0]->citizen->citizen_name : $citizens[1]->citizen->citizen_name,
            'designation' => $citizens[0]->citizen_type_id == 2 ? $citizens[0]->citizen->designation : $citizens[1]->citizen->designation,
        ];
        $data['trial_date'] = GccCauseList::orderby('id', 'DESC')
            ->where('appeal_id', $id)
            ->first()->trial_date;
        $data['case_no'] = $appeal->case_no;
        $data['district'] = $appeal->district_name;
        $data['page_title'] = 'হাজিরা প্রিন্ট';
        // return $data;
        return view('report.hajira')->with($data);
    }

    // public function send_sms($mobile, $message)
    // {
    //     // print_r($mobile.' , '.$message);exit('zuel');
    //     Http::post('http://bulkmsg.teletalk.com.bd/api/sendSMS', [
    //         'auth' => [
    //             'username' => 'ecourt',
    //             'password' => 'A2ist2#0166',
    //             'acode' => 1005370,
    //         ],
    //         'smsInfo' => [
    //             'message' => $message,
    //             'is_unicode' => 1,
    //             'masking' => 8801552146224,
    //             'msisdn' => [
    //                 '0' => $mobile,
    //             ],
    //         ],
    //     ]);
    // }



    // public function send_sms_multiple($msisdn, $message)
    // {
    //     // print_r($msisdn).'sms' .print_r($message);exit('alis');
    //     //   var_dump($msisdn);
    //     //   var_dump($message);
    //     //   exit('zuel');
    //     //$msisdn=$mobile;

    //     Http::post('http://bulkmsg.teletalk.com.bd/api/sendSMS', [
    //         'auth' => [
    //             'username' => 'ecourt',
    //             'password' => 'A2ist2#0166',
    //             'acode' => 1005370,
    //         ],
    //         'smsInfo' => [
    //             'message' => $message,
    //             'is_unicode' => 1,
    //             'masking' => 8801552146224,
    //             'msisdn' => $msisdn,
    //         ],
    //     ]);
    // }
    public function get_token()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://si.mysoftheaven.com/api/v1/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('email' => 'a2i@gmail.com', 'password' => 'mhl!a2i@2041', 'api_secret' => '2qwertyudfcvgbhn'),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function send_sms($to, $message)
    {
        $curl = curl_init();
        $new_message = curl_escape($curl, $message);
        $newto = '88' . $to;
        $url = 'http://103.69.149.50/api/v2/SendSMS?SenderId=8809617612638&Is_Unicode=true&ClientId=ec63aede-1c7e-4a5a-a1ad-36b72ab30817&ApiKey=AeHZPUEZXIILtxg0VEaGjsK%2BuPNlzhCDW0VuFRmcchs%3D&Message=' . $new_message . '&MobileNumbers=' . $newto;
        
        // dd($url);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    public function send_smsold($to, $message)
    {

        $token = $this->get_token();
        $curl = curl_init();
        $m = curl_escape($curl, $message);
        $url = 'http://si.mysoftheaven.com/api/v1/sms?to=' . $to . '&message=' . $m;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            // CURLOPT_HTTPHEADER => array(
            //     $token
            // ),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function send_sms_multipleold($to, $message)
    {

        $mobile = implode(',', $to);
        $token = $this->get_token();
        $curl = curl_init();
        $m = curl_escape($curl, $message);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://si.mysoftheaven.com/api/v1/sms?to=' . $mobile . '&message=' . $m,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            // CURLOPT_HTTPHEADER => array(
            //     $token
            // ),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    public function send_sms_multiple($to, $message)
    {
        $mobile = '';
        foreach ($to as $newmobile) {
            $mobile .= '88' . $newmobile . ',';
        }
        $newmobile = rtrim($mobile, ',');
        $curl = curl_init();
        $new_message = curl_escape($curl, $message);
        // dd($message);
        $url = 'http://103.69.149.50/api/v2/SendSMS?SenderId=8809617612638&Is_Unicode=true&ClientId=ec63aede-1c7e-4a5a-a1ad-36b72ab30817&ApiKey=AeHZPUEZXIILtxg0VEaGjsK%2BuPNlzhCDW0VuFRmcchs%3D&Message=' . $new_message . '&MobileNumbers=' . $newmobile;
       
        // dd($url);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        // dd($response);
        curl_close($curl);
        return  $response;
    }

    public function get_sms_data($requestInfo, $shortorderTemplateUrl)
    {
        // dd($requestInfo->shortOrder[0]);
        if ($requestInfo->shortOrder[0] == 1) {
            $sms_details_both = DB::table('gcc_case_shortdecisions')
                ->where('id', '=', $requestInfo->shortOrder[0])
                ->first();

            $casedetails = GccAppeal::where('id', $requestInfo->appealId)->first();

            $caseNo = $casedetails->case_no;
            $loan_amount = $casedetails->loan_amount;

            $applicants_appeal = DB::table('gcc_appeal_citizens')
                ->where('appeal_id', '=', $requestInfo->appealId)
                ->where('citizen_type_id', '=', 1)
                ->get();


            $applicants_appeal_array = [];
            foreach ($applicants_appeal as $applicants_appeal_single) {
                array_push($applicants_appeal_array, $applicants_appeal_single->citizen_id);
            }

            $applicants = DB::table('gcc_citizens')
                ->whereIn('id', $applicants_appeal_array)
                ->get();

            $case_data_mapping = DB::table('gcc_appeals')
                ->join('office', 'gcc_appeals.office_id', 'office.id')
                ->join('district', 'gcc_appeals.district_id', 'district.id')
                ->where('gcc_appeals.id', $requestInfo->appealId)
                ->select('gcc_appeals.loan_amount_text', 'gcc_appeals.loan_amount', 'office.office_name_bn', 'office.organization_physical_address', 'district.district_name_bn')
                ->first();
            $orginal_applicants = DB::table('gcc_appeal_citizens')
                ->join('users', 'gcc_appeal_citizens.created_by', 'users.id')
                ->where('gcc_appeal_citizens.appeal_id', '=', $requestInfo->appealId)
                ->where('gcc_appeal_citizens.citizen_type_id', '=', 1)
                ->select('users.name as name')
                ->first();
            if (!empty($orginal_applicants)) {
                $applicant_name_1 = $orginal_applicants->name;
            } else {
                $applicant_name_1 = null;
            }

            // dd($applicant_name_1);
            $organization = $case_data_mapping->office_name_bn . ', ' . $case_data_mapping->district_name_bn . ', ' . ($applicant_name_1);
            $msisdn = [];


            foreach ($applicants as $applicantpeoplesingle) {
                array_push($msisdn, $applicantpeoplesingle->citizen_phone_no);
            }

            $sms_details_applicant = explode(';', $sms_details_both->template_code)[0];

            $dummy = ['{#caseNo}', '{#name1}', '{#organization}', '{#loanAmount}'];

            $original = [$caseNo, $applicant_name_1, $organization, $loan_amount];

            $message = str_replace($dummy, $original, $sms_details_applicant);


            $this->send_sms_multiple($msisdn, $message);


            /* NOW for CITIZEN SMS */

            $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);

            $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;
            $message2 = ' পিডি আর আক্ট ১৯১৩ অনুযায়ী আপনার ' . $citizenInfo['defaulterCitizen']->citizen_name . ' বিরুদ্ধে জেনারেল সার্টিফিকেট আদালতে একটি মামলা করা হয়েছে। প্রত্যাশী সংস্থাঃ ' . $organization . ' মামলা নাম্বার ' . $caseNo . '। টাকার পরিমাণ ' . $loan_amount;
            // dd($message2);exit;
            $this->send_sms($mobile, $message2);

            if (!empty($shortorderTemplateUrl)) {
                foreach ($shortorderTemplateUrl as $value) {
                    $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;
                    $message2 = 'জেনারেল সার্টিফিকেট আদালতে নোটিশ দেখতে প্রবেশ করুন ' . $value;
                    $this->send_sms($mobile, $message2);
                }
            }
        }

        $sms_group_7_dhara = [2, 3, 4, 17, 21];

        if (in_array($requestInfo->shortOrder[0], $sms_group_7_dhara)) {
            if ($requestInfo->is_nominee_attach == 'not_attached_not_required') {
                SMSNotificationRepository::seven_dara_notice_sms_defaulter($requestInfo, $shortorderTemplateUrl);
            } else {
                SMSNotificationRepository::seven_dara_notice_sms_nominee($requestInfo, $shortorderTemplateUrl);
            }
        }

        $sms_crock = [5];

        if (in_array($requestInfo->shortOrder[0], $sms_crock)) {
            if ($requestInfo->is_nominee_attach == 'not_attached_not_required') {
                SMSNotificationRepository::seven_dara_notice_sms_defaulter($requestInfo, $shortorderTemplateUrl);
            } else {
                SMSNotificationRepository::seven_dara_notice_sms_nominee($requestInfo, $shortorderTemplateUrl);
            }
        }

        if ($requestInfo->shortOrder[0] == 14) {
            if ($requestInfo->is_nominee_attach == 'not_attached_not_required') {
                SMSNotificationRepository::case_close_sms_defaulter($requestInfo, $shortorderTemplateUrl);
            } else {
                SMSNotificationRepository::case_close_notice_sms_nominee($requestInfo, $shortorderTemplateUrl);
            }
        }

        if ($requestInfo->shortOrder[0] == 20) {
            if ($requestInfo->is_nominee_attach == 'not_attached_not_required') {
                SMSNotificationRepository::crock_sms_defaulter($requestInfo, $shortorderTemplateUrl);
            } else {
                SMSNotificationRepository::crock_close_notice_sms_nominee($requestInfo, $shortorderTemplateUrl);
            }
        }

        /*** Warrent executor */
        $warrent_sms_group = [9, 15, 11, 6, 7, 18, 19];

        
        if (in_array($requestInfo->shortOrder[0], $warrent_sms_group)) {
            $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);

            $mobile = $requestInfo->warrantExecutorMobile;

            $sms_details = DB::table('gcc_case_shortdecisions')
                ->where('id', '=', $requestInfo->shortOrder[0])
                ->first();
            $caseNumber = GccAppeal::where('id', $requestInfo->appealId)->first();
            $dummy = ['{#caseNo}', '{#name2}', '{#nextdate}'];

            $original = [$caseNumber->case_no, $citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

            $message = str_replace($dummy, $original, $sms_details->template_code);
            $this->send_sms($mobile, $message);

            if (!empty($shortorderTemplateUrl)) {
                foreach ($shortorderTemplateUrl as $value) {
                    $mobile = $requestInfo->warrantExecutorMobile;
                    $message2 = 'জেনারেল সার্টিফিকেট আদালতে নোটিশ দেখতে প্রবেশ করুন ' . $value;
                    $this->send_sms($mobile, $message2);
                }
            }
        }

        /** Hearing And Next Data */

        if ($requestInfo->shortOrder[0] == 13 || $requestInfo->shortOrder[0] == 16) {
            $data_mssdn = DB::table('gcc_citizens')
                ->join('gcc_appeal_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->where('gcc_appeal_citizens.appeal_id', '=', $requestInfo->appealId)
                ->select('gcc_citizens.citizen_phone_no')
                ->get();
                $msisdn = [];
                foreach ($data_mssdn as $data_mssdn) {
                    array_push($msisdn, $data_mssdn->citizen_phone_no);
                }
                
                $sms_details = DB::table('gcc_case_shortdecisions')
                ->where('id', '=', $requestInfo->shortOrder[0])
                ->first();
                
               

            $casedetails = GccAppeal::where('id', $requestInfo->appealId)->first();
            $caseNo = $casedetails->case_no;
            $dummy = ['{#case_no}', '{#nextdate}'];
            $original = [$requestInfo->caseNo, $requestInfo->trialDate];

            $message = str_replace($dummy, $original, $sms_details->template_code);
            // dd($msisdn);
            $this->send_sms_multiple($msisdn, $message);
           
        }
    }
    public function validatePhoneNumberOnTrial($phone_number)
    {
        $phone_number = trim($phone_number);
        if (strlen($phone_number) != 11) {
            return 'size_error';
        } else {
            $pattern = '/(01)[0-9]{9}/';
            $preg_answer = preg_match($pattern, $phone_number);
            if (!$preg_answer) {
                return 'format_error';
            }
        }
    }

    public function validateEmail($email)
    {
        $email = trim($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //Valid email!
            return 'format_ok';
        } else {
            return 'format_error';
        }
    }

    public function validate_request_data($requestInfo)
    {

        // dd('come here', $requestInfo->shortOrder[0]);
        $appeal = DB::table('gcc_appeals')->where('id', $requestInfo->appealId)->first();
        $user = DB::table('users')->where('id', $appeal->updated_by)->first()->name;
        if ($appeal->action_required == "ASST") {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                'message' => 'মামলাটিতে ইতিমধ্যে ' . $user . ' কোর্ট পরিচালনা করেছেন ',
                'div_id' => 'receiver_land_details',
                'status' => 'error',
            ]);
        }

        if (in_array($requestInfo->shortOrder[0], [14, 19]) && $requestInfo->status == 'ON_TRIAL') {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                'message' => 'আপনি মামলা নিষ্পত্তির আদেশ দিয়েছেন সে ক্ষেত্রে অবস্থা চলমান থেকে নিষ্পত্তি দিন',
                'div_id' => 'is_varified_org',
                'status' => 'error',
            ]);
        }
        if ($requestInfo->status == 'CLOSED' && $requestInfo->orderPublishDecision == 1 && empty($requestInfo->finalOrderPublishDate)) {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                'message' => 'সম্পূর্ণ আদেশ প্রকাশের তারিখ দিতে হবে !',
                'div_id' => 'is_varified_org',
                'status' => 'error',
            ]);
        }

        if ($requestInfo->status == 'ON_TRIAL' && empty($requestInfo->trialDate)) {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                'message' => 'পরবর্তী তারিখ দিতে হবে !',
                'div_id' => 'appeal_date_time_status_new',
                'status' => 'error',
            ]);
        }

        if ($requestInfo->status == 'ON_TRIAL_DC' && empty($requestInfo->trialDate)) {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                'message' => 'পরবর্তী তারিখ দিতে হবে !',
                'div_id' => 'appeal_date_time_status_new',
                'status' => 'error',
            ]);
        }
        if ($requestInfo->status == 'ON_TRIAL_DIV_COM' && empty($requestInfo->trialDate)) {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                'message' => 'পরবর্তী তারিখ দিতে হবে !',
                'div_id' => 'appeal_date_time_status_new',
                'status' => 'error',
            ]);
        }
        if ($requestInfo->status == 'ON_TRIAL_LAB_CM' && empty($requestInfo->trialDate)) {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                'message' => 'পরবর্তী তারিখ দিতে হবে !',
                'div_id' => 'appeal_date_time_status_new',
                'status' => 'error',
            ]);
        }

        // $trialDate_fomatted=strrev(str_replace('/','-',$requestInfo->trialDate));

        if (!empty($requestInfo->trialDate) && !empty($requestInfo->trialTime) && $requestInfo->status !== 'CLOSED' && $requestInfo->shortOrder[0] == 16) {
            if ($requestInfo->trialDate == date('d/m/Y', strtotime(now()))) {
                date_default_timezone_set('Asia/Dhaka');
                $time_in_24hr = date('H:i');
                $requestInfoHour = explode(':', $requestInfo->trialTime)[0];
                $requestInfoMinitue = explode(':', $requestInfo->trialTime)[1];

                $currentHour = explode(':', $time_in_24hr)[0];
                $currentMinitue = explode(':', $time_in_24hr)[1];

                if ($currentHour > $requestInfoHour) {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                        'message' => 'আপনি শুনানির সময় বর্তমান সময়ের আগে দিয়েছেন !',
                        'div_id' => 'appeal_date_time_status_new',
                        'status' => 'error',
                    ]);
                } elseif ($currentHour == $requestInfoHour) {
                    if ($currentMinitue > $requestInfoMinitue) {
                        return response()->json([
                            'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                            'message' => 'আপনি শুনানির সময় বর্তমান সময়ের আগে দিয়েছেন !',
                            'div_id' => 'appeal_date_time_status_new',
                            'status' => 'error',
                        ]);
                    }
                }
            }

            $format1 = explode('/', $requestInfo->trialDate);
            $format2 = $format1[2] . '-' . $format1[1] . '-' . $format1[0];

            $appealIds = [];
            array_push($appealIds, $requestInfo->appealId);

            $beforeTotalTime = strtotime($requestInfo->trialTime) - 300;
            $afterTotalTime = strtotime($requestInfo->trialTime) + 300;

            $beforeTimeSting = date('H:i:s', $beforeTotalTime);
            $afterTimeSting = date('H:i:s', $afterTotalTime);

            $role_id = globalUserInfo()->role_id;
            if ($role_id == 27) {
                $exiting_trail_date = GccAppeal::select('case_no', 'next_date_trial_time')
                    ->where('next_date', $format2)
                    ->where('updated_by', globalUserInfo()->id)
                    ->where('court_id', globalUserInfo()->court_id)
                    ->whereIn('appeal_status', ['ON_TRIAL'])
                    ->whereNotIn('id', $appealIds)
                    ->whereBetween('next_date_trial_time', [$beforeTimeSting, $afterTimeSting])
                    ->get();
            } elseif ($role_id == 6) {
                $exiting_trail_date = GccAppeal::select('case_no', 'next_date_trial_time')
                    ->where('next_date', $format2)
                    ->where('updated_by', globalUserInfo()->id)
                    ->where('district_id', user_district()->id)
                    ->whereIn('appeal_status', ['ON_TRIAL_DC'])
                    ->whereNotIn('id', $appealIds)
                    ->whereBetween('next_date_trial_time', [$beforeTimeSting, $afterTimeSting])
                    ->get();
            } elseif ($role_id == 34) {
                $exiting_trail_date = GccAppeal::select('case_no', 'next_date_trial_time')
                    ->where('next_date', $format2)
                    ->where('updated_by', globalUserInfo()->id)
                    ->whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])
                    ->where('division_id', user_office_info()->division_id)
                    ->whereNotIn('id', $appealIds)
                    ->whereBetween('next_date_trial_time', [$beforeTimeSting, $afterTimeSting])
                    ->get();
            } elseif ($role_id == 25) {
                $exiting_trail_date = GccAppeal::select('case_no', 'next_date_trial_time')
                    ->where('next_date', $format2)
                    ->where('updated_by', globalUserInfo()->id)
                    ->whereNotIn('id', $appealIds)
                    ->whereBetween('next_date_trial_time', [$beforeTimeSting, $afterTimeSting])
                    ->get();
            }

            if (count($exiting_trail_date) > 0) {
                $message = 'ইতিমধ্যে  ';
                $message .= $requestInfo->trialDate . ' তারিখে ';
                foreach ($exiting_trail_date as $row) {
                    $bela = '';
                    if (!empty($row->next_date_trial_time)) {
                        if (date('a', strtotime($row->next_date_trial_time)) == 'am') {
                            $bela = 'সকাল';
                        } else {
                            $bela = 'বিকাল';
                        }
                    }

                    $message .= $bela . ' ' . date('h:i', strtotime($row->next_date_trial_time)) . ' মিনিটের সময়  ' . $row->case_no . ' নং আভিযোগের শুনানির সময় দেয়া আছে';
                    $message .= ', ';
                }

                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => $message,
                    'div_id' => 'appeal_date_time_status_new',
                    'status' => 'error',
                ]);
            }
        }

        if ($requestInfo->shortOrder[0] == 11 || $requestInfo->shortOrder[0] == 15 || $requestInfo->shortOrder[0] == 9 || $requestInfo->shortOrder[0] == 6 || $requestInfo->shortOrder[0] == 7 || $requestInfo->shortOrder[0] == 19 || $requestInfo->shortOrder[0] == 18) {
            if (empty($requestInfo->warrantExecutorName)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'ওয়ারেন্ট বাস্তবায়নকারীর নাম দিতে হবে ! ',
                    'div_id' => 'warrantExecutorDetails',
                    'status' => 'error',
                ]);
            }
            if (empty($requestInfo->warrantExecutorInstituteName)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'ওয়ারেন্ট বাস্তবায়নকারীর প্রতিষ্ঠানের নাম দিতে হবে ! ',
                    'div_id' => 'warrantExecutorDetails',
                    'status' => 'error',
                ]);
            }
            if (empty($requestInfo->warrantExecutorMobile)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'ওয়ারেন্ট বাস্তবায়নকারীর মোবাইল নম্বর দিতে হবে ! ',
                    'div_id' => 'warrantExecutorDetails',
                    'status' => 'error',
                ]);
            } else {
                $mobile_error = $this->validatePhoneNumberOnTrial($requestInfo->warrantExecutorMobile);
                if ($mobile_error == 'size_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই !  ',
                        'message' => 'ওয়ারেন্ট বাস্তবায়নকারীর মোবাইল নম্বর ইংরেজিতে 11 digit দিতে হবে! ',
                        'div_id' => 'warrantExecutorDetails',
                        'status' => 'error',
                    ]);
                } elseif ($mobile_error == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                        'message' => 'ওয়ারেন্ট বাস্তবায়নকারীর মোবাইল নম্বর format সঠিক নয় ! ',
                        'div_id' => 'warrantExecutorDetails',
                        'status' => 'error',
                    ]);
                }
            }
            if (!empty($requestInfo->warrantExecutorEmail)) {
                $email_check = $this->validateEmail($requestInfo->warrantExecutorEmail);
                if ($email_check == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                        'message' => 'ওয়ারেন্ট বাস্তবায়নকারীর ইমেইল format সঠিক নয় ! ',
                        'div_id' => 'warrantExecutorDetails',
                        'status' => 'error',
                    ]);
                }
            }
        }



        //Najir's Information Validation

        if ($requestInfo->shortOrder[0] == 23) {


            //For Najir
            if (empty($requestInfo->najirsName)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'নাজিরের নাম দিতে হবে ! ',
                    'div_id' => 'auctionOrderPossessionDetails',
                    'status' => 'error',
                ]);
            }
            if (empty($requestInfo->najirsMobile)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'নাজিরের মোবাইল নম্বর দিতে হবে ! ',
                    'div_id' => 'auctionOrderPossessionDetails',
                    'status' => 'error',
                ]);
            } else {
                $mobile_error = $this->validatePhoneNumberOnTrial($requestInfo->najirsMobile);
                if ($mobile_error == 'size_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই !  ',
                        'message' => 'নাজিরের মোবাইল নম্বর ইংরেজিতে 11 digit দিতে হবে! ',
                        'div_id' => 'auctionOrderPossessionDetails',
                        'status' => 'error',
                    ]);
                } elseif ($mobile_error == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                        'message' => 'নাজিরের মোবাইল নম্বর format সঠিক নয় ! ',
                        'div_id' => 'auctionOrderPossessionDetails',
                        'status' => 'error',
                    ]);
                }
            }
            if (empty($requestInfo->najirsEmail)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'নাজিরের ইমেইল দিতে হবে ! ',
                    'div_id' => 'auctionOrderPossessionDetails',
                    'status' => 'error',
                ]);
            } else {
                $email_check = $this->validateEmail($requestInfo->najirsEmail);
                if ($email_check == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                        'message' => 'নাজিরের ইমেইল format সঠিক নয় ! ',
                        'div_id' => 'auctionOrderPossessionDetails',
                        'status' => 'error',
                    ]);
                }
            }




            //For Buyers
            if (empty($requestInfo->buyersName)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'নিলামকৃত সম্পত্তি ক্রেতার দিতে হবে ! ',
                    'div_id' => 'auctionOrderPossessionDetails',
                    'status' => 'error',
                ]);
            }
            if (empty($requestInfo->buyersEmail)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'নিলামকৃত সম্পত্তি ক্রেতার ইমেইল দিতে হবে ! ',
                    'div_id' => 'auctionOrderPossessionDetails',
                    'status' => 'error',
                ]);
            } else {
                $email_check = $this->validateEmail($requestInfo->buyersEmail);
                if ($email_check == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                        'message' => 'নিলামকৃত সম্পত্তি ক্রেতার ইমেইল format সঠিক নয় ! ',
                        'div_id' => 'auctionOrderPossessionDetails',
                        'status' => 'error',
                    ]);
                }
            }

            if (empty($requestInfo->buyersMobile)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'নিলামকৃত সম্পত্তি ক্রেতার মোবাইল নম্বর দিতে হবে ! ',
                    'div_id' => 'auctionOrderPossessionDetails',
                    'status' => 'error',
                ]);
            } else {
                $mobile_error = $this->validatePhoneNumberOnTrial($requestInfo->buyersMobile);
                if ($mobile_error == 'size_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই !  ',
                        'message' => 'নিলামকৃত সম্পত্তি ক্রেতার মোবাইল নম্বর ইংরেজিতে 11 digit দিতে হবে! ',
                        'div_id' => 'auctionOrderPossessionDetails',
                        'status' => 'error',
                    ]);
                } elseif ($mobile_error == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                        'message' => 'নিলামকৃত সম্পত্তি ক্রেতার মোবাইল নম্বর format সঠিক নয় ! ',
                        'div_id' => 'auctionOrderPossessionDetails',
                        'status' => 'error',
                    ]);
                }
            }
        }



        // if ($requestInfo->shortOrder[0] == 6 || $requestInfo->shortOrder[0] == 7 || $requestInfo->shortOrder[0] == 11) {
        //     $error_mapping = [
        //         'main_amount_29_dhara' => 'মূল দাবি টাকা দিয়ে হবে',
        //         'interest_29_dhara' => 'সুদের পরিমাণ দিতে হবে',
        //         'costing_29_dhara' => 'খরচ পরিমাণ দিতে হবে',
        //         'working_amount_29_dhara' => 'কার্যকরীকরন পরিমাণ দিতে হবে'
        //     ];
        //     foreach ($error_mapping as $key => $value) {
        //         if (empty($requestInfo->$key) || $requestInfo->$key < 0) {
        //             return response()->json([
        //                 'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
        //                 'message' => $value,
        //                 'div_id' => 'warrantExecutorDetails',
        //                 'status' => 'error',
        //             ]);
        //         }
        //     }
        // }


        if ($requestInfo->shortOrder[0] == 18) {
            $error_mapping = [
                'amount_to_deposite' => 'জমা করতে হবে (টাকা) পরিমাণ দিতে হবে',
                'days_in_court' => 'যত দিনের জন্য জেলে যেতে হবে দিতে হবে',
                'daily_cost_ta_da' => 'খরচ পরিমাণ দিতে হবে',
            ];
            foreach ($error_mapping as $key => $value) {
                if (empty($requestInfo->$key) || $requestInfo->$key < 0) {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                        'message' => $value,
                        'div_id' => '_zill_sent_addtional_info',
                        'status' => 'error',
                    ]);
                }
            }
        }
        if ($requestInfo->shortOrder[0] == 2 || $requestInfo->shortOrder[0] == 3) {
            $error_mapping = [
                'amount_to_pay_as_remaining' => '৭ ধারার নোটিশ প্রয়োজনীয় তথ্য বকেয়া (টাকা) পরিমাণ দিতে হবে',
                'amount_to_pay_as_costing' => '৭ ধারার নোটিশ প্রয়োজনীয় তথ্য খরচ (টাকা) পরিমাণ দিতে হবে',
            ];
            foreach ($error_mapping as $key => $value) {
                if (empty($requestInfo->$key) || $requestInfo->$key < 0) {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                        'message' => $value,
                        'div_id' => '_seventh_order_addtional',
                        'status' => 'error',
                    ]);
                }
            }
        }
        /* if ($requestInfo->shortOrder[0] == 21) {
            $error_mapping = [
                'amount_to_pay_as_remaining_10ka' => '১০ ক ধারার নোটিশ প্রয়োজনীয় তথ্য বকেয়া (টাকা) পরিমাণ দিতে হবে',
                'amount_to_pay_as_costing_10ka' => '১০ ক ধারার নোটিশ প্রয়োজনীয় তথ্য খরচ (টাকা) পরিমাণ দিতে হবে',
            ];
            foreach ($error_mapping as $key => $value) {
                if (empty($requestInfo->$key) || $requestInfo->$key < 0) {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                        'message' => $value,
                        'div_id' => '_10ka_order_addtional',
                        'status' => 'error',
                    ]);
                }
            }
        } */
    }
    public function get_dynamic_name_defulter_applicant(Request $request)
    {

        // $applicant_name=$this->get_applicant_info($request->appeal_id);
        // $defulter_name=$this->get_defaulter_people($request->appeal_id);
        // $withness_name= $this->get_withness_people($request->appeal_id);
        // dd($request->appeal_id);
        // dd($request->all());
        $appeal = GccAppeal::where('id', $request->appeal_id)->first();

        if ($appeal->case_entry_type == "RUNNING") {
            $caseNo = $appeal->manual_case_no;
        } else {
            $caseNo = $appeal->case_no;
        }

        $dummy = ['{#caseNo}'];

        $original = [$caseNo];

        $message = str_replace($dummy, $original, $request->details);

        return response()->json([
            'success' => 'success',
            'message' => $message
        ]);
    }
}
