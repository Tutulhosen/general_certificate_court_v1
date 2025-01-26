<?php

namespace App\Http\Controllers\AppealInfo;

use App\Models\Appeal;
use App\Models\RaiOrder;
use App\Models\CauseList;
use App\Models\CaseDecision;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Services\AdminAppServices;
use Illuminate\Support\Facades\DB;
use App\Models\GccAppealOrderSheet;
use App\Services\ProjapotiServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\MobileCourtServices;
use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\Session;
use App\Repositories\CauseListRepository;
use App\Models\CaseShortdecisionTemplates;
use App\Repositories\ShortOrderRepository;
use App\Models\GccCaseShortdecisionTemplates;
use App\Repositories\CertificateAsstNoteRepository;

class AppealInfoController extends Controller
{
    public $permissionCode = 'certificateView';

    /* public function __construct()
    {
     //   $this->middleware('auth');
        AppealBaseController::__construct();

    }*/

    public function getAppealOrderSheets(Request $request, $id)
    {
        // dd('sfs');
        $data_to_qr_codded = url()->full();
        $imageName = 'QR_' . $id;

        // $content = file_get_contents('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $data_to_qr_codded . '');
        // file_put_contents(public_path() . '/QRCodes/' . $imageName, $content);
        //dd($content);
        //file_put_contents(public_path() . $upload_path . $imageName, $content);

        $appealId = decrypt($id);

        // $data['data_image_path'] = '/QRCodes/' . $imageName;
        $data['data_image_path'] = $data_to_qr_codded;

        $data['appealOrderLists'] = CertificateAsstNoteRepository::generate_order_shit($appealId);
        $data['nothi_id'] = $id;
        $data['page_title'] = 'আদেশ নামা';

        //dd($data['appealOrderLists'] );
        if (!empty($data['appealOrderLists'])) {
            if (Auth::check()) {
                if (!in_array(globalUserInfo()->role_id, [35, 36])) {
                    return view('nothiList.nothiOrderSheetDetails')->with($data);
                } else {
                    return view('citizenNothiList.nothiOrderSheetDetails')->with($data);
                }
            } else {
                return view('nothiList.with_out_auth_nothiOrderSheetDetails')->with($data);
            }
           
        } else {
            return redirect()
                ->back()
                ->with('error', 'এখনও আদেশনামা তৈরি হয় নাই');
        }
    }

    public function getAppealShortOrderSheets(Request $request, $id)
    {
        // dd($appealId);
        $data_to_qr_codded = url()->full();
        $imageName = 'QR_short_decision_template' . $id;

        // $content = file_get_contents('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $data_to_qr_codded . '');
        // file_put_contents(public_path() . '/QRCodes/' . $imageName, $content);

        // $data['data_image_path'] = '/QRCodes/' . $imageName;
        $data['data_image_path'] = $data_to_qr_codded;

        $data['appealShortOrderLists'] = GccCaseShortdecisionTemplates::where('id', $id)->get();
        // return $data['appealShortOrderLists'];
        $data['page_title'] = 'সংক্ষিপ্ত আদেশ';
        $data['nothi_id'] = $id;
        if (Auth::check()) {
            if (!in_array(globalUserInfo()->role_id, [35, 36])) {
                return view('nothiList.nothiShortOrderSheet')->with($data);
            } else {
                return view('citizenNothiList.nothiShortOrderSheet')->with($data);
            }
        } else {
            return view('nothiList.with_out_auth_nothiShortOrderSheet')->with($data);
        }
    }

    public function getAppealWarrentOrderSheet(Request $request, $id)
    {
        $id = decrypt($id);
        // dd($id);
        $data['appealShortOrderLists'] = GccCaseShortdecisionTemplates::where('appeal_id', $id)
            ->where('case_shortdecision_id', 7)
            ->get();
        // return $data['appealShortOrderLists'];
        $data['page_title'] = 'সংক্ষিপ্ত আদেশ';

        return view('nothiList.nothiShortOrderSheet')->with($data);
    }

    public function getAppealCrockOrderSheet(Request $request, $id)
    {
        $id = decrypt($id);
        // dd($id);
        $data['appealShortOrderLists'] = GccCaseShortdecisionTemplates::where('appeal_id', $id)
            ->where('case_shortdecision_id', 9)
            ->get();
        // return $data['appealShortOrderLists'];
        $data['page_title'] = 'সংক্ষিপ্ত আদেশ';

        return view('nothiList.nothiShortOrderSheet')->with($data);
    }

    public function generatePDF($html)
    {
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font' => 'kalpurush',
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function showHelpPage()
    {
        return view('help');
    }

    public function getCaseDecisionList()
    {
        $caseDecisions = CaseDecision::all();
        return response()->json($caseDecisions);
    }

    public function getCalendarEventList()
    {
        //        $causeList=CauseList::all();        //single event
        //        return response()->json($causeList);

        $causeListEvent = CauseListRepository::getCauseListEventList(); //event count
        return response()->json($causeListEvent);
    }

    public function getThana()
    {
        $userInfo = Session::get('userInfo');
        $thanaList = AdminAppServices::getThana($userInfo->districtId);
        return response()->json([
            'thanaList' => $thanaList,
        ]);
    }

    public function getUserZillaFromSession()
    {
        $userDistrictId = Session::get('districtCode');
        $userDistrictName = Session::get('districtName');
        return response()->json([
            'districtCode' => $userDistrictId,
            'districtName' => $userDistrictName,
        ]);
    }

    public function getUpazilla()
    {
        $userInfo = Session::get('userInfo');
        $upazillaList = AdminAppServices::getUpazilla($userInfo->districtId);
        return response()->json([
            'upazillaList' => $upazillaList,
        ]);
    }

    public function getShortTemplateByid(Request $request)
    {
        $shortOrderTemplateId = $request->templateId;
        $shortOrderTemplate = CaseShortdecisionTemplates::find($shortOrderTemplateId);

        return response()->json([
            'shortOrderTemplate' => $shortOrderTemplate,
        ]);
    }

    public function getAppealRayNama(Request $request)
    {
        $appealId = $request->appealId;
        $appealRayNama = RaiOrder::where('appeal_id', $appealId)->get();
        return response()->json([
            'appealRayNama' => $appealRayNama,
        ]);
    }

    public function getAdmList()
    {
        //get Adm list
        $roleOfficeInfo = AdminAppServices::getOfficeInfoByRoleCode('ADM_');

        $admList = [];

        if (Session::get('flagForSSOLogin') == 1) {
            $admList = ProjapotiServices::getUserListByDistrictAndOrganogramOriginIdByAPI($roleOfficeInfo, Session::get('userInfo')->districtId);
        } else {
            $admList = ProjapotiServices::getUserListByDistrictAndOrganogramOriginId($roleOfficeInfo, Session::get('userInfo')->districtId);
        }
        return response()->json([
            'admList' => $admList,
        ]);
    }

    public function getDmList()
    {
        //get DM role office info
        $roleOfficeInfo = AdminAppServices::getOfficeInfoByRoleCode('DM_');
        //get Dm list
        $dmListArray = [];
        $dmList = [];

        //get Dm list
        if (Session::get('flagForSSOLogin') == 1) {
            $dmLists = ProjapotiServices::getUserListByDistrictAndOrganogramOriginIdByAPI($roleOfficeInfo, Session::get('userInfo')->districtId);
        } else {
            $dmLists = ProjapotiServices::getUserListByDistrictAndOrganogramOriginId($roleOfficeInfo, Session::get('userInfo')->districtId);
        }
        foreach ($dmLists as $dmList) {
            $dmListArray[$dmList->username] = $dmList;
        }
        return response()->json([
            'dmList' => $dmListArray,
        ]);
    }

    public function getGcoList()
    {
        //get GCO role office info
        $roleOfficeInfo = AdminAppServices::getOfficeInfoByRoleCode('GCO_');
        //get GCO list
        $gcoListArray = [];
        $gcoLists = [];

        //get Dm list
        if (Session::get('flagForSSOLogin') == 1) {
            $gcoLists = ProjapotiServices::getUserListByDistrictAndOrganogramOriginIdByAPI($roleOfficeInfo, Session::get('userInfo')->districtId, Session::get('userInfo')->office_id);
        } else {
            $gcoLists = ProjapotiServices::getUserListByDistrictAndOrganogramOriginId($roleOfficeInfo, Session::get('userInfo')->districtId, Session::get('userInfo')->office_id);
        }

        foreach ($gcoLists as $gcoList) {
            $gcoListArray[$gcoList->username] = $gcoList;
        }
        return response()->json([
            'gcoList' => $gcoListArray,
        ]);
    }

    public function getAppealInfo(Request $request)
    {
        //this function used by peshkar appeal view populate and Adm Appeal view Populate
        $appealId = $request->appealId;
        $data = AppealRepository::getAllAppealInfo($appealId);
        return response()->json([
            'data' => $data,
        ]);
    }
    public function getShortOrderList()
    {
        $shortOrderList = ShortOrderRepository::getShortOrderList();
        return response()->json([
            'shortOrderList' => $shortOrderList,
        ]);
    }

    public function getCriminalFromMobileCourt(Request $request)
    {
        $caseNo = $request->caseNo;

        $criminalList = MobileCourtServices::getCriminalListByCaseNo($caseNo);

        return response()->json([
            'criminalList' => $criminalList,
        ]);
    }

    public function getCriminalInfoFromMobileCourt(Request $request)
    {
        $caseNo = $request->caseNo;
        $criminalId = $request->criminalId;

        $criminalInfo = MobileCourtServices::getCriminalProsecutionInfo($caseNo, $criminalId);

        return response()->json([
            'criminalInfo' => $criminalInfo,
        ]);
    }

    /**
     * @param Request $request
     */
    public function checkHolidays(Request $request)
    {
        $trialDate = $request->date;

        $dateInfo = AdminAppServices::getHoliday($trialDate);
        return response()->json([
            'dateInfo' => $dateInfo,
        ]);
    }

    public function getPaymentInfo(Request $request)
    {
        $appealId = $request->appealId;
        $paymentInfo = [];
        $totalLoanAmount = '';
        $caseNumber = '';
        $totalDueAmount = '';
        if (isset($appealId)) {
            $totalLoanAmount = Appeal::find($appealId)->loan_amount;
            $caseNumber = Appeal::find($appealId)->case_no;
            $paymentStatus = Appeal::find($appealId)->payment_status;
            $paymentInfo = PaymentService::getPaidListByAppealId($appealId);
            $totalDueAmount = PaymentService::getTotalDueAmount($appealId, $totalLoanAmount);
            $totalAuctionSale = PaymentService::getAuctionTotalAmount($appealId);
        }

        return response()->json([
            'caseNumber' => $caseNumber,
            'paymentStatus' => $paymentStatus,
            'totalAuctionSale' => $totalAuctionSale,
            'paymentList' => $paymentInfo,
            'totalLoanAmount' => $totalLoanAmount,
            'totalDueAmount' => $totalDueAmount,
        ]);
    }
}
