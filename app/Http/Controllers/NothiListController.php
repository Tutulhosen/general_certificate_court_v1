<?php

/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 12/12/17
 * Time: 12:56 PM
 */

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Models\GccAppeal;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Services\AdminAppServices;
use Illuminate\Support\Facades\DB;
use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\UserAgentRepository;
use App\Services\ShortOrderTemplateService;
use App\Repositories\CitizenAttendanceRepository;
use App\Services\ShortOrderTemplateServiceUpdated;

class NothiListController extends Controller
{
    public $permissionCode = 'certificateNothiList';

    public function index(Request $request)
    {
        $date = date($request->date);
        $userRole = Session::get('userRole');
        $districtId = Session::get('userInfo')->districtId;
        $upazilaList = AdminAppServices::getUpazilla($districtId);
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Session::get('userInfo')->username;
        }
        return view('nothiList.nothiList', compact('date', 'gcoUserName', 'upazilaList'));
    }

    public function nothiData(Request $request)
    {
        $usersPermissions = Session::get('userPermissions');
        $nothiData = AppealRepository::getNothiListBySearchParam($request);

        return response()->json([
            'data' => $nothiData,
            'userPermissions' => $usersPermissions,
            'userName' => Session::get('userInfo')->username

        ]);
    }

    public function nothiViewPage(Request $request)
    {
        $id = decrypt($request->id);
        $caseInfo = GccAppeal::find($id);
        if ($caseInfo->case_entry_type == 'RUNNING') {
            $caseNumber = $caseInfo->manual_case_no;
        } else {
            $caseNumber = $caseInfo->case_no;
        }
        // dd($caseNumber);
        $caseInfo = AppealRepository::getAppealCaseAndCriminalId($id);
        $nothiData = AppealRepository::getNothiListFromAppeal($id);
        $citizenAttendanceList = CitizenAttendanceRepository::getCitizenAttendanceByAppealId($id);
        $shortOrderTemplateList = ShortOrderTemplateServiceUpdated::getShortOrderTemplateListByAppealId($id);
        //dd($shortOrderTemplateList);
        $paymentAttachment = PaymentService::getPaymentAttachmentByAppealId($id);
        $page_title  = 'বিস্তারিত নথি | ' . $caseNumber;




        return view('nothiList.nothiView', compact('nothiData', 'caseInfo', 'shortOrderTemplateList', 'paymentAttachment', 'citizenAttendanceList', 'page_title'));
    }

    public function citizenNothiViewPage(Request $request)
    {
        $id = decrypt($request->id);
        $caseNumber = GccAppeal::find($id)->case_no;
        $caseInfo = AppealRepository::getAppealCaseAndCriminalId($id);
        $nothiData = AppealRepository::getNothiListFromAppeal($id);
        $citizenAttendanceList = CitizenAttendanceRepository::getCitizenAttendanceByAppealId($id);
        $shortOrderTemplateList = ShortOrderTemplateServiceUpdated::getShortOrderTemplateListByAppealId($id);
        //dd($shortOrderTemplateList);
        $paymentAttachment = PaymentService::getPaymentAttachmentByAppealId($id);
        $page_title  = 'বিস্তারিত নথি | ' . $caseNumber;



        return view('citizenNothiList.nothiView', compact('nothiData', 'caseInfo', 'shortOrderTemplateList', 'paymentAttachment', 'citizenAttendanceList', 'page_title'));
    }
}
