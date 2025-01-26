<?php
/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 1/17/18
 * Time: 3:37 PM
 */

namespace App\Services;


use App\Models\Appeal;
use App\Models\AppealOrderSheet;
use App\Models\CaseShortdecisions;
use App\Models\CaseShortdecisionTemplates;
use App\Models\GccAppealOrderSheet;
use App\Models\GccCaseShortdecisions;
use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mcms\Models\OrderSheet;

class AppealOrderSheetService
{
    public static function storeAppealOrderSheet($appealId,$appealObjectFromUi,$trialDate){
        $user = globalUserInfo();
        $appeal=AppealRepository::getAllAppealInfo($appealId);
        $orderSheetHeader=self::getAppealOrderSheetHeader($appeal);
        $orsheetTable=self::getAppealOrderSheetTable($appeal,$appealObjectFromUi,$trialDate);
        // dd('minar check test ok');
        $fullTableBody=$orsheetTable['body'];
        $tableTh=$orsheetTable['tableTh'];
        $tableBody=$orsheetTable['tableBody'];
        $tableClose=$orsheetTable['orderTableClose'];

        $appealOrderSheet=new GccAppealOrderSheet();
        $appealOrderSheet->appeal_id=$appealId;
        $appealOrderSheet->appeal_case_no=$appeal['appeal']->case_no ;//date('Y-m-d', strtotime(str_replace('/', '-', $trialDate)));
        $appealOrderSheet->order_header=$orderSheetHeader;
        $appealOrderSheet->order_detail_full_table=$fullTableBody;
        $appealOrderSheet->order_detail_table_body=$tableBody;
        $appealOrderSheet->order_detail_table_th=$tableTh;
        $appealOrderSheet->order_detail_table_close=$tableClose;

        $appealOrderSheet->created_at=date('Y-m-d H:i:s');
        $appealOrderSheet->created_by=$user->username;
        $appealOrderSheet->updated_at=date('Y-m-d H:i:s');
        $appealOrderSheet->updated_by=$user->username;
        $appealOrderSheet->save();

    }
    public static function storeAppealShortOrders($appealId,$appealObjectFromUi,$causeListId){
        $user = globalUserInfo();
        $appeal=AppealRepository::getAllAppealInfo($appealId);
        $orderSheetHeader=self::getAppealOrderSheetHeader($appeal);
        $orsheetTable=self::getAppealOrderSheetTable($appeal,$appealObjectFromUi);
        $fullTableBody=$orsheetTable['body'];
        $tableTh=$orsheetTable['tableTh'];


        $shortOrders=$appealObjectFromUi->shortOrder;

        foreach ($shortOrders as $shortOrder){
            $appealOrderSheet=new CaseShortdecisionTemplates();
            $appealOrderSheet->appeal_id=$appealId;
            $appealOrderSheet->cause_list_id=$causeListId;
            $appealOrderSheet->case_shortdecision_id=$shortOrder;
            $appealOrderSheet->template_header=$orderSheetHeader;
            $appealOrderSheet->template_body=$fullTableBody;

            $appealOrderSheet->created_at=date('Y-m-d H:i:s');
            $appealOrderSheet->created_by=$user->username;
            $appealOrderSheet->updated_at=date('Y-m-d H:i:s');
            $appealOrderSheet->updated_by=$user->username;
            $appealOrderSheet->save();
        }

    }

    public static function getLastOrderSheetByAppealId($appealId){

        $orderSheet=AppealOrderSheet::where('appeal_id',$appealId)
            ->orderBy('id', 'desc')
            ->first();
        return $orderSheet;
    }

    public static function destroyOrderSheetByOrderSheetId($orderSheetId){
        $orderSheet=AppealOrderSheet::where('id',$orderSheetId);
        $orderSheet->delete();
        return;
    }

    public static function getAppealOrderSheetHeader($appealInfo){
         $noteCauseList=$appealInfo['noteCauseList'];
         $length=count($noteCauseList);
         $noteFirstDate = date('d-m-Y',strtotime($noteCauseList[0]->conduct_date));
         $noteLastDate = date('d-m-Y',strtotime($noteCauseList[$length-1]->conduct_date));
         $banglaYear=DataConversionService::toBangla(date("Y", strtotime($noteLastDate)));
         $header="<p class=\"form-bd\" style=\"text-align: left;\">বাংলাদেশ ফরম নম্বর -  ২৭০ <br>" . "</p>" .
            "        <h2 style=\"text-align: center;\"> আদেশপত্র</h2>" .
            "        <p style=\"text-align: center;\">" .
             "           (১৯১৭  সালের  রেকর্ড  ম্যানুয়েলের  ১২৯ নং  বিধি ) &nbsp;<br><span>" .
             "আদেশপত্র, তারিখ  ".DataConversionService::toBangla($noteFirstDate)." হইতে  ". DataConversionService::toBangla($noteLastDate)." পর্যন্ত ।</span> <br><span> ".
             "জেলা :".Session::get('districtName')." , ".$banglaYear ." সালের ". DataConversionService::toBangla($noteLastDate) ." পর্যন্ত ।</span> <br><br><span style='float: left'> ".
            "মামলার ধরন :".$appealInfo['appeal']->law_section."</span><span style='float: right;'> মামলা নম্বর-&nbsp;". DataConversionService::toBangla($appealInfo['appeal']->case_no) ."</span></p><div id=\"dependent\">" .
            " </span></div><br>";

         return $header;
    }

    public static function getAppealOrderSheetTh(){
        $th= "        <table cellspacing=\"0\" cellpadding=\"0\" border=\"1\" width=\"100%\">" .
            "            <thead><tr>" .
            "                <td valign=\"middle\" width=\"5%\" align=\"center\"> আদেশের ক্রমিক নং ও তারিখ</td>" .
            "                <td valign=\"middle\" width=\"75%\" align=\"center\"> আদেশ ও অফিসারের স্বাক্ষর</td>" .
            "                <td valign=\"middle\" width=\"10%\" align=\"center\">  আদেশের উপর গৃহীত ব্যবস্থা</td>" .
            "            </tr></thead>" .
            "            <tbody>" ;

        return $th;
    }

    public static function getAppealOrderTableClose(){
        $tableClose= "                " .
            "                ".
            "            </tbody>" .
            "        </table>" ;

        return $tableClose;
    }

    public static function getAppealShortOrderTextForOrdersheet($shortOrders){

        $content='';
        $sl=1;

        // dd($shortOrders);
        // if(count($shortOrders)>0){
        if($shortOrders != null){
            foreach ($shortOrders as $shortOrder){
                $content.=DataConversionService::toBangla($sl).'। '.GccCaseShortdecisions::find($shortOrder)->case_short_decision .'<br>';
                $sl++;
            }
        }

        return $content;
    }

    public static function getAppealOrderSheetTableContent($appealObjectFromUi,$orderNoBng,$trialDate){
        $user = globalUserInfo();
        $signature ='';
        if($appealObjectFromUi->oldCaseFlag == '1'){
            $signature = '';
        }else{
            $signature = $user->username;
        }
        $shortOrdersText=self::getAppealShortOrderTextForOrdersheet($appealObjectFromUi->shortOrder);
        // dd('minar check test getAppealOrderSheetTableContent');

        $tableContent="             <tr></tr><td valign=\"top\" align=\"center\">" .
            "                    <span class=\"underline\" ;=\"\"> ". $orderNoBng ."</span><br>"
           . DataConversionService::toBangla($trialDate) .
            "                </td>" .
            "                <td style=\"padding:5px; text-align : justify;\"><div><span>".$appealObjectFromUi->note."</span></div>" .

            "                    <table  border=\"0\" width=\"100%\" align=\"center\">" .
            "                        <tbody>" .
            "                        <tr>" .
            "                            <td width=\"30%\">" .
            "                            </td>" .
            "                            <td width=\"70%\" align=\"center\">" .
            "                                <span>&nbsp;". DataConversionService::toBangla($trialDate)."</span>" .
            "                            </td>" .
            "                        </tr>" .
            "                        <tr>" .
            "                            <td width=\"30%\">" .
            "                            </td>" .
            "                            <td width=\"70%\" align=\"center\">" .
            "                                <span>".   $signature ."</span>" .
            "                            </td>" .
            "                        </tr>" .
            "                        <tr>" .
            "                            <td width=\"30%\">" .
            "                            </td>" .
            "                            <td width=\"70%\" align=\"center\">" .
            "                                <span>".   $user->designation_bng ."</span>" .
            "                            </td>" .
            "                        </tr>" .
            "                        <tr>" .
            "                            <td width=\"30%\">" .
            "                            </td>" .
            "                            <td width=\"70%\" align=\"center\">" .
            "                                <span>". $user->office_name_bng."</span>" .
            "                            </td>" .
            "                        </tr>" .
            "                        </tbody>" .
            "                    </table>" .
            "                </td>".
            "<td style=\"padding:5px; text-align : justify;\"><div><span>".$shortOrdersText."</span></div></td>";
        return $tableContent;
    }

    public static function getAppealOrderSheetTable($appealInfo,$appealObjectFromUi,$trialDate){

        $appealId=$appealInfo['appeal']->id;

        $orders=GccAppealOrderSheet::where('appeal_id',$appealInfo['appeal']->id)
        ->get();
        $orderNoBng=DataConversionService::toBangla(count($orders)+1);

        $orderTableTh=self::getAppealOrderSheetTh();
        $orderTableClose=self::getAppealOrderTableClose();
        $orderTableBody=self::getAppealOrderSheetTableContent($appealObjectFromUi,$orderNoBng,$trialDate);
        // dd('minar check test getAppealOrderSheetTable ok' );

        $body= $orderTableTh.$orderTableBody.$orderTableClose;

        return ["body"=>$body,"tableBody"=>$orderTableBody,"tableTh"=>$orderTableTh,"orderTableClose"=>$orderTableClose];

    }

}
