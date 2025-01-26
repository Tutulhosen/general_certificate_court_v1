<?php

namespace App\Http\Controllers;

use App\Repositories\AppealListRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class GetAppealPdfGenerateController extends Controller
{
    function index(Request $request)
    {

        if ($request->expectsJson()) {
            $results = AppealListRepository::RoleWaysPendingAppealList();
            return Response::json(['data' => $results]);
        }
        $date = date($request->date);
        // dd($request->all()['page_title'], $date);
        $caseStatus = [1];
        $userRole = globalUserInfo()->role_id;
        // dd($userRole);
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Auth::user()->username;
        }
        if ($userRole == 6) {
            // $results=[];
            $data['page_title'] = $request->all()['page_title'];
        } else {
            $data['page_title'] = $request->all()['page_title'];
        }

        if ($request->all()['page_title'] == "সকল মামলার তালিকা") {
            $results = AppealListRepository::RoleWaysAllAppealList();
        } elseif ($request->all()['page_title'] == 'চলমান মামলার তালিকা') {
            $results = AppealListRepository::RoleWaysRunningAppealList();
        } elseif ($request->all()['page_title'] == 'নিষ্পত্তিকৃত মামলার তালিকা') {
            $results = AppealListRepository::RoleWaysClosedAppealList();
        } elseif ($request->all()['page_title'] == 'পুরাতন নিষ্পত্তিকৃত মামলা') {
            $results = AppealListRepository::RoleWaysClosedAppealList();
        }else {
            $results = AppealListRepository::RoleWaysPendingAppealList();
        }
        $data['results'] = $results;

        $html = view('appeal_pdf')->with($data);
        $this->generatePamentPDF($html);
    }

    public function generatePamentPDF($html)
    {
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font' => 'kalpurush',

        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}