<?php


namespace App\Services;


use App\Models\GccCaseShortdecisionTemplates;
use App\Models\Upazila;
use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ShortOrderTemplateService
{
    public static function getShortOrderTemplateListByAppealId($appealId)
    {
        $shortOrderTemplateList = DB::connection('mysql')
            ->table('gcc_cause_lists')
            ->join('gcc_case_shortdecision_templates', 'gcc_cause_lists.id', '=', 'gcc_case_shortdecision_templates.cause_list_id')
            ->where('gcc_case_shortdecision_templates.appeal_id', $appealId)
            ->select(
                'gcc_case_shortdecision_templates.id',
                'gcc_case_shortdecision_templates.appeal_id',
                'gcc_case_shortdecision_templates.template_name',
                'gcc_case_shortdecision_templates.template_full',
                'gcc_cause_lists.trial_date',
                'gcc_cause_lists.conduct_date'
            )
            ->get();

        $index = 1;
        $templateList =  array();

        foreach ($shortOrderTemplateList as $shortOrderTemplate) {
            $template['index'] = DataConversionService::toBangla($index);
            $template['appeal_id'] = $shortOrderTemplate->appeal_id;
            $template['id'] = $shortOrderTemplate->id;
            $template['template_name'] = $shortOrderTemplate->template_name;
            $template['conduct_date'] = DataConversionService::toBangla(date('d-m-Y', strtotime($shortOrderTemplate->conduct_date)));
            $template['template_full'] = $shortOrderTemplate->template_full;

            $index++;
            array_push($templateList, $template);
        }
        // dd($templateList);
        return $templateList;
    }

    public static function deleteShortOrderTemplate($causeListId)
    {
        $shortOrderList = GccCaseShortdecisionTemplates::where('cause_list_id', $causeListId);
        // dd($shortOrderList);
        $shortOrderList->delete();
        return;
    }

    public static function storeShortOrderTemplate($shortOrderId, $appealId, $causeListId, $shortOrderTemplateContent, $templateName)
    {
        $shortOrderTemplate = new GccCaseShortdecisionTemplates();
        $shortOrderTemplate->appeal_id = $appealId;
        $shortOrderTemplate->cause_list_id = $causeListId;
        $shortOrderTemplate->case_shortdecision_id = $shortOrderId;
        $shortOrderTemplate->template_full = $shortOrderTemplateContent;
        $shortOrderTemplate->template_header = '';
        $shortOrderTemplate->template_body = '';
        $shortOrderTemplate->template_name = $templateName;
        $shortOrderTemplate->created_at = date('Y-m-d H:i:s');
        $shortOrderTemplate->created_by = Auth::user()->username;
        $shortOrderTemplate->updated_at = date('Y-m-d H:i:s');
        $shortOrderTemplate->updated_by = Auth::user()->username;
        $shortOrderTemplate->save();
    }
    public static function generateShortOrderTemplate($shortOrders, $appealId, $causeList)
    {
        $appealInfo = AppealRepository::getAllAppealInfo($appealId);

        self::deleteShortOrderTemplate($causeList->id);
        // if(count($shortOrders)>0){
        if ($shortOrders != null) {
            // dd($causeList);
            foreach ($shortOrders as $shortOrder) {



                /* initial opertaions */

                if ($shortOrder == 1000) {

                    if ($appealInfo['appeal']->applicant_type == 'BANK') {
                        // dd($appealInfo);
                        $templateName = "সার্টিফিকেট খাতকের প্রতি দাবী ( ১০(ক) ধারা)";
                        $shortOrderTemplate = self::getCertificateDefaulterNoticeSectionTenShortOrderTemplate($appealInfo, $causeList);
                        self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $shortOrderTemplate, $templateName);
                        // dd($appealInfo['appeal']);
                    } else {
                        $sevenTemplateName = "সার্টিফিকেট খাতকের প্রতি দাবী ( ৭ ধারা )";
                        // dd($sevenTemplateName);
                        $sevenShortOrderTemplate = self::getCertificateDefaulterNoticeSectionSevenShortOrderTemplate($appealInfo, $causeList);
                        self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $sevenShortOrderTemplate, $sevenTemplateName);
                    }
                }
                if ($shortOrder == 2000) {
                    $templateName = "রাজকীয় প্রাপ্যের সার্টিফিকেট";
                    $shortOrderTemplate = self::getRajokioPrappoShortOrderTemplate($appealInfo, $causeList);
                    self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $shortOrderTemplate, $templateName);
                }
                if ($shortOrder == 3000) {
                    $templateName = "সার্টিফিকেট নিমিত্ত অনুরোধ পত্র";
                    $shortOrderTemplate = self::getCertificateRequestShortOrderTemplate($appealInfo, $causeList);
                    // dd($shortOrderTemplate);
                    self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $shortOrderTemplate, $templateName);
                }


                //--------------------------সার্টিফিকেট খাতকের প্রতি দাবী------------------------------------------//
                if ($shortOrder == 24) {

                    if ($appealInfo['appeal']->applicant_type == 'BANK') {
                        // dd($appealInfo);
                        $templateName = "সার্টিফিকেট খাতকের প্রতি দাবী ( ১০(ক) ধারা)";
                        $shortOrderTemplate = self::getCertificateDefaulterNoticeSectionTenShortOrderTemplate($appealInfo, $causeList);
                        self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $shortOrderTemplate, $templateName);

                        $templateName = "সার্টিফিকেট নিমিত্ত অনুরোধ পত্র";
                        $shortOrderTemplate = self::getCertificateRequestShortOrderTemplate($appealInfo, $causeList);
                        self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $shortOrderTemplate, $templateName);

                        $templateName = "রাজকীয় প্রাপ্যের সার্টিফিকেট";
                        $shortOrderTemplate = self::getRajokioPrappoShortOrderTemplate($appealInfo, $causeList);
                        self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $shortOrderTemplate, $templateName);
                    } else {
                        $sevenTemplateName = "সার্টিফিকেট খাতকের প্রতি দাবী ( ৭ ধারা )";
                        // dd($sevenTemplateName);
                        $sevenShortOrderTemplate = self::getCertificateDefaulterNoticeSectionSevenShortOrderTemplate($appealInfo, $causeList);
                        self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $sevenShortOrderTemplate, $sevenTemplateName);

                        $templateName = "সার্টিফিকেট নিমিত্ত অনুরোধ পত্র";
                        $shortOrderTemplate = self::getCertificateRequestShortOrderTemplate($appealInfo, $causeList);
                        self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $shortOrderTemplate, $templateName);

                        $templateName = "রাজকীয় প্রাপ্যের সার্টিফিকেট";
                        $shortOrderTemplate = self::getRajokioPrappoShortOrderTemplate($appealInfo, $causeList);
                        self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $shortOrderTemplate, $templateName);
                    }
                }

                //-------------------সার্টিফিকেট নিমিত্ত অনুরোধ পত্র---------------------------//


                //-------------ক্রোক--------------------//
                if ($shortOrder == 26) {
                    $templateName = "ক্রোক পরোয়ানা";
                    $shortOrderTemplate = self::generateCrokeTemplate($appealInfo, $causeList);
                    self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $shortOrderTemplate, $templateName);
                }

                //-------------দেওয়ানী কারাগারে প্রেরণের জন্য কারণ দর্শানো--------------------//
                if ($shortOrder == 11) {
                    $templateName = "দেওয়ানী কারাগারে প্রেরণের জন্য কারণ দর্শানো";
                    $shortOrderTemplate = self::getReasonToCriminalJailShortOrderTemplate($appealInfo, $causeList);
                    self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $shortOrderTemplate, $templateName);
                }

                //-------------সার্টিফিকেট  খাতকের প্রতি W/A ইস্যু করা হোক ।--------------------//
                if ($shortOrder == 7) {
                    $templateName = "W/A ইস্যু";
                    $shortOrderTemplate = self::getDefaulterJailWarrentShortOrderTemplate($appealInfo, $causeList);
                    self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $shortOrderTemplate, $templateName);
                }
                //-------------সার্টিফিকেট ধারক মামলা প্রত্যাহারের জন্য আবেদন করেছেন ।--------------------//
                if ($shortOrder == 31) {
                    $templateName = "মামলার নিষ্পত্তি";
                    $shortOrderTemplate = self::getCaseRejectionApplicationShortOrderTemplate($appealInfo, $causeList);
                    self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $shortOrderTemplate, $templateName);
                }
                //-------------সার্টিফিকেট খাতকের প্রতি ইস্যুকৃত পরোয়ানা প্রত্যাহার করা হলো। প্রসেস রি-কল করা হোক ।--------------------//
                if ($shortOrder == 6) {
                    $templateName = "পরোয়ানা রি-কল";
                    $shortOrderTemplate = self::getPoroanaRecallShortOrderTemplate($appealInfo, $causeList);
                    self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $shortOrderTemplate, $templateName);
                }
                //-------------সার্টিফিকেট রাজকীয় প্রাপ্যের সার্টিফিকেট।--------------------//

                //-------------সার্টিফিকেট W/A ইস্যু করার পূর্বের নোটিশ (৭৭ ধার)--------------------//
                if ($shortOrder == 12) {
                    $templateName = "W/A ইস্যু করার পূর্বের নোটিশ (৭৭ ধারা)";
                    $shortOrderTemplate = self::getRajokioPrappoAinerDharaShortOrderTemplate($appealInfo, $causeList);
                    self::storeShortOrderTemplate($shortOrder, $appealId, $causeList->id, $shortOrderTemplate, $templateName);
                }
            }
        }
    }

    //----------- সার্টিফিকেট নিমিত্ত অনুরোধ পত্র-----------------------------------------//
    public static function getCertificateRequestShortOrderTemplate($appealInfo, $causeList)
    {
        $office_name = DB::table('office')->where('id', '=', globalUserInfo()->office_id)->first();

        $location = $office_name->office_name_bn;
        $defaulter = $appealInfo['defaulterCitizen'];
        $guarantorCitizen = $appealInfo['guarantorCitizen'];
        // dd($appealInfo);
        $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));
        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($causeList->conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($causeList->conduct_date)));
        $trialTime = date('h:i:s a', strtotime($causeList->conduct_time));
        $trialBanglaYear = DataConversionService::toBangla(date("Y", strtotime($causeList->conduct_date)));

        $template = '
                    <style>
                        table, th, td {
                            border: 1px solid black;
                            border-collapse: collapse;
                            padding: 10px;
                            font-weight: normal;
                        }
                    </style>
            <div >
                <span style="font-size:  medium;">বাংলাদেশ ফরম নং ১০২৮  </span>
                        <header>
                            <div style="text-align: center">
                                <h3>সার্টিফিকেটের নিমিত্ত অনুরোধপত্র</h3>
                                <h3>(৫ নং ধারা দেখুন )। </h3>
                            </div>
                        </header>
             <br>
             <span style="float: right; font-size: medium">' . Session::get('districtName') . ' সার্টিফিকেট অফিসার মহাশয় বরাবরেষু</span>
             <br>
             <br>
            <div style="height:100%">
               <table width="100%">
                    <colgroup><col>
                    </colgroup><colgroup span="2"></colgroup>
                    <colgroup span="2"></colgroup>
                    <tbody><tr>
                        <th width="20%" rowspan="2">সার্টিফিকেট মত খাতকের নাম</th>
                        <th width="40%" rowspan="2">সার্টিফিকেট মত খাতকের ঠিকানা</th>
                        <th width="20%" colspan="2" scope="colgroup">যত রাজকীয় প্রাপ্যের নিমিত্ত এই অনুরোধপত্র <br> দেওয়া গেল</th>
                        <th width="20%" rowspan="2">যে প্রকারের রাজকীয় প্রাপ্যের নিমিত্ত এই অনুরোধ পত্র দেওয়া গেল</th>
                    </tr>
                    <tr>
                        <th scope="col"> টাকা</th>
                        <th scope="col"> পয়সা </th>
                    </tr>
                    <tr style="word-spacing: 4px;text-align: justify;">
                        <td>১ । ঋণ গ্রহীতা - ' . $defaulter->citizen_name . ', পিতা -' . $defaulter->father . ' ,মাতা -' . $defaulter->mother . '</td>
                        <td>ব্যবসায়িক ঠিকানা - ' . $defaulter->present_address . '  ,স্থায়ী ঠিকানা - ' . $defaulter->permanent_address . '</td>
                        <td>' . $loanAmountBng . ' টাকা </td>
                        <td>0</td>
                        <td></td>
                    </tr>
                    <tr style="word-spacing: 4px;text-align: justify;">
                        <td>গ্যারান্টর -' . ($guarantorCitizen != null ? $guarantorCitizen->citizen_name : '') . ', পিতা -' . ($guarantorCitizen != null ? $guarantorCitizen->father : '') . ' ,মাতা -' . ($guarantorCitizen != null ? $guarantorCitizen->mother : '') . '</td>
                        <td>ব্যবসায়িক ঠিকানা -' . $defaulter->present_address . '</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody></table>
                 <br>
                <div style="float: right;">
                     <span> [ অপর পৃষ্ঠায় দেখুন ] </span>

                 </div>
            </div>




                <div style="font-size:  medium;padding-top: 25%">

                    <span>
                     উক্ত    ......র স্থানে .................................... উপলক্ষ্যে উপরিলিখিত টাকা পাওনা আছে এ বিষয়ে অনুসন্ধান করিয়া আমার প্রতীতি জন্মিয়াছে ।  আপনার নিকট অনুরোধ ঐ টাকা আদায় করিবেন ।
                    </span>
                    <br>
                    <br>

                        <span>
                    ' . $trialBanglaYear . ' সালের ' . $trialBanlaMonth . ' মাসের ' . $trialBanglaDay . ' তারিখে সত্য পাঠযুক্ত করা গেল ।


                </span></div>
                <br>
                <br>
                <div style="float: right;font-size:medium;">
                     <span> প্রতিষ্ঠানের দায়িত্বপ্রাপ্ত ব্যক্তির নাম ও পদবি</span>

                    <br>
                    <br>
                 </div>
            </div>';
        // dd($template);
        return $template;
    }

    //--------------------------সার্টিফিকেট খাতকের প্রতি দাবী (৭ ধারা) ------------------------------------------
    public static function getCertificateDefaulterNoticeSectionSevenShortOrderTemplate($appealInfo, $causeList)
    {

        $court_id = $appealInfo['appeal']->court_id;
        $court_name = DB::table('court')->where('id', '=', $court_id)->first();
        $office_name = DB::table('office')->where('id', '=', globalUserInfo()->office_id)->first();

        // dd($appealInfo);
        $defaulter = $appealInfo['defaulterCitizen'];
        $applicant = $appealInfo['applicantCitizen'];
        $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));
        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($causeList->conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($causeList->conduct_date)));
        $trialTime = date('h:i:s a', strtotime($causeList->conduct_time));
        $trialBanglaYear = DataConversionService::toBangla(date("Y", strtotime($causeList->conduct_date)));

        $template = '<div style="padding-top: 5%;">
                        <header>
                            <div><span>বাংলাদেশ ফরম নং ১০৩০</span></div>
                            <div style="text-align: center">
                                <h3>সার্টিফিকেট খাতকের প্রতি নোটিশ</h3>
                                <h4>(৭ ধারা দেখুন ।) </h4>
                            </div>
                        </header>
                        <br>

                        <div style="font-size:  medium;">
                            <span style="float:left">জনাব  ' . $defaulter->citizen_name . ' </span>
                            <span style="float:  right;">সমীপেষু । </span>
                            <br>
                            <br>
                            <span style="margin-left: 40px">আপনাকে</span><span>
                             এতদ্বারা জ্ঞাত করা যাইতেছে যে , আপনার নিকট হইতে ঋন বাবদ প্রাপ্য ' . $loanAmountBng . ' টাকার নিমিত্ত আপনার বিরুদ্ধে
                              একখানি  সার্টিফিকেট বঙ্গদেশের রাজকীয় প্রাপ্য আদায় বিষয়ক ১৯১৩ সনের আইনের ৪ ও ৬ ধারানুসারে
                              অদ্য আমার অফিসে গাঁথিয়া রাখা হইয়াছে ।যদি আপনি উক্ত টাকা দিবার দায়িত্ব অস্বীকার করেন তাহা হইলে এই নোটিশ জারী
                              হইবার সময় হইতে ত্রিশ দিনের মধ্যে আপনি সম্পূর্ণ বা আংশিকভাবে দায়িত্ব অস্বীকারকরণসূচক একখানি দরখাস্ত আমার অফিসে দাখিল করিতে পারেন ।
                               উক্ত ত্রিশ দিনের মধ্যে যদি আপনি ঐরূপ দরখাস্ত দাখিল করিতে ত্রুটি করেন কিংবা ঐ সার্টিফিকেট কেন জারী কেন করা হইবে না
                               তাহার কারণ দর্শাইতে ত্রুটি করেন বা যথেষ্ট কারণ না দেখান তাহা হইলে আপনি প্রাপ্য বাবত ' . $loanAmountBng . ' টাকা এবং আদায়ের খরচা
                               বাবত ...... টাকা আমার অফিসে না দিলে উহা উক্ত আইনের বিধানানুসারে জারী করা হইবে । যাবৎ উক্ত
                              টাকা ঐরূপে প্রদত্ত না হয় তাবৎ দান, বিক্রয় বা বন্ধক দ্বারা বা প্রকারান্তরে আপনার স্থাবর  সম্পত্তি হস্থান্তর
                              করিতে আপনাকে নিষেধ করা যাইতেছে । যদি আপনি ইতিমধ্যে আপনার অস্থাবর সম্পত্তির কোন অংশ গোপন করেন , স্থানান্তরিত করেন বা
                              বিক্রয় করেন তাহা হইলে সার্টিফিকেট অবিলম্বে জারী করা হইবে ।
                            </span>
                            <br>
                            <br>
                            <span style="margin-left: 40px">উক্ত সার্টিফিকেটের একখানি নকল এই নোটিশে সংযুক্ত করা গেল । </span>

                          	<br>
                            <br>
                            <span style="margin-left: 40px">আপনি </span><span>

                           সার্টিফিকেটের যে নম্বর ও উহা যে বৎসরের তাহা উল্লেখ করিয়া মানি অর্ডার যোগে ঐ টাকা পাঠাইতে পারেন ।

                            </span>
                             <br><br>
                            <span style="margin-left: 40px"> তারিখ , </span><span>
                            অদ্য ' . $trialBanglaYear . ' সনের ' . $trialBanlaMonth . ' মাসের ' . $trialBanglaDay . ' দিবস ।  </span>

                        </div>
                        <br>
                        <br>
                        <div style="float: right;font-size:medium;">
                             <span style="float: right">সার্টিফিকেট অফিসার । </span>
                                <br>
                            <span>' . $office_name->office_name_bn . '</span>
                            <br>
                            <br>
                         </div>
                    </div>';

        return $template;
    }

    //--------------------------সার্টিফিকেট খাতকের প্রতি দাবী ( ১০(ক) ধারা) ------------------------------------------
    public static function getCertificateDefaulterNoticeSectionTenShortOrderTemplate($appealInfo, $causeList)
    {

        $court_id = $appealInfo['appeal']->court_id;
        $court_name = DB::table('court')->where('id', '=', $court_id)->first();



        $office_name = DB::table('office')->where('id', '=', globalUserInfo()->office_id)->first();

        $defaulter = $appealInfo['defaulterCitizen'];
        $applicant = $appealInfo['applicantCitizen'][0];
        $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));
        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($causeList->conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($causeList->conduct_date)));
        $trialTime = date('h:i:s a', strtotime($causeList->conduct_time));
        $trialBanglaYear = DataConversionService::toBangla(date("Y", strtotime($causeList->conduct_date)));


        $template = '<div style="padding-top: 5%;">
                        <header>
                            <div><span>From No. 51</span></div>
                            <div style="text-align: center">
                                <h3>সার্টিফিকেট খাতকের প্রতি দাবীর নোটিশ</h3>
                                <h4>১০/ক ধারা দেখুন । </h4>
    							<h4>সার্টিফিকেট মোকদ্দমা নম্বর - ' . en2bn($appealInfo['appeal']->case_no) . ' </h4>
    							<h4>L. L. F. No </h4>
                            </div>
                        </header>
                        <br>

                        <div style="font-size:  medium;">
                            <span style="float:left">জনাব  ' . $defaulter->citizen_name . ' </span>
                            <br>
                            <br>
                            <span>আপনাকে
                             এতদ্বারা জ্ঞাত করা যাইতেছে যে , আপনার নিকট ' . $applicant->organization . ' প্রাপ্য বাবদ ' . $loanAmountBng . ' টাকার নিমিত্ত আপনার বিরুদ্ধে
                              একখানি  সার্টিফিকেট বংগ দেশের রাজকীয় প্রাপ্য আদায় বিষয়ক ১৯১৩ সনের আইনের ৪ ও ৬  ধারা
                              মতে অদ্য আমার অফিসে গাঁথিয়া রাখা হইয়াছে । অত্র নোটিশ জারী হইবার সময় হইতে ৩০ (ত্রিশ) দিনের মধ্যে আপনি সম্পূর্ণ ' . $loanAmountBng . '
                              টাকা এবং আদায় খরচ বাবদ ........ টাকা আমার অফিসে দিবেন । অত্র নোটিশ জারী হইবার পর হইতে যে যাবৎ উক্ত দাবীর
                              টাকা সম্পূর্ণরুপে প্রদত্ত না হয় তাবৎ দান বিক্রয় বা বন্ধক দ্বারা বা পক্ষান্তরে আপনার স্থাবর বা অস্থাবর সম্পত্তি হস্থান্তর করিতে নিষেধ করা যাইতেছে ।
                              অত্র আদেশ অমান্য করিলে আইন মোতাবেক কার্য করা হইবে ।
                            </span>
                            <br>
                            
                                <span>

                           আপনি সার্টিফিকেটের যে নম্বর ও উহা যে বৎসরের তাহা উল্লেখ করিয়া মানি অর্ডার যোগে ঐ টাকা পাঠাইতে পারেন ।
                           তারিখ অদ্য ' . $trialBanglaYear . ' সনের ' . $trialBanlaMonth . ' মাসের ' . $trialBanglaDay . ' দিবস 
                            </span>

                        </div>
                        <br>
                        <br>
                        <div style="float: right;font-size:medium;">
                             <span style="float: right">সার্টিফিকেট অফিসার</span>
                                <br>
                            <span>' . $office_name->office_name_bn . '</span>
                            <br>
                            <br>
                         </div>
                    </div>';

        return $template;
    }

    //---------------------------------সার্টিফিকেট  খাতকের প্রতি W/A ইস্যু করা হোক  ------------------------------------------------
    public static function  getDefaulterJailWarrentShortOrderTemplate($appealInfo, $causeList)
    {

        $offender = $appealInfo['defaulterCitizen'];
        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        $lawSection = DataConversionService::toBangla($appealInfo['appeal']->law_section);
        $appealBanglaDay = DataConversionService::toBangla(date('d', strtotime($appealInfo['appeal']->created_at)));
        $appealBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($appealInfo['appeal']->created_at)));
        $appealBanglaYear = DataConversionService::toBangla(date("Y", strtotime($appealInfo['appeal']->created_at)));

        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($causeList->conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($causeList->conduct_date)));
        $trialBanglaYear = DataConversionService::toBangla(date("Y", strtotime($causeList->conduct_date)));

        $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));

        $office_name = DB::table('office')->where('id', '=', globalUserInfo()->office_id)->first();
        $location = $office_name->office_name_bn;


        $template = '<style>
                td{
                    padding-top: 10px;
                    padding-bottom: 10px;
                }
                .all_content{
                    padding: 10ex;    /* background-color: #0d0808; */
                    }
                </style>
        <div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: left">
                বাংলাদেশ ফরম নং ১০৩৫
            </div>
            <div style="text-align: center">
                <h3>গ্রেফতারী ওয়ারেন্ট</h3>
                <h4>(২৯ ধারা দেখুন।)</h4>
            </div>
        </header>
        <div class="all_content">
        <p class="text-center">যেহেতু বাংলাদেশের রাজকীয় প্রাপ্য আদায় বিষয়ক ১৯১৩ সালের আইনের ' . $lawSection . ' ধারানুসারে</p>
        <div style="padding-top: 20px; width: 100%">
            <table style="padding-top: 20px; padding-bottom: 100px;" class="table">
                <tr>
                    <td width="10%" style="border: 1px solid black">
                        <p style="padding-top: 20px">মূল্য দাবী...</p>

                        <p>সুদ.........</p>

                    </td>
                    <td width="10%" style="border: 1px solid black">টাকা </br> ' . $loanAmountBng . '</td>
                    <td width="10%" style="border: 1px solid black">পঃ </td>
                    <td width="50%" rowspan="2">
                        <div style="text-align: justify;">
                            সার্টিফিকেট  খাতক
                            জনাব ' . $offender->citizen_name . ' এর বিরুদ্ধে ' . $appealBanglaYear . ' সালের ' . $appealBanlaMonth . ' মাসের ' . $appealBanglaDay . ' দিবসে
                            ' . $caseNo . '  নম্বরে<span style="padding-left: 40px">এক </span> সার্টিফিকেট এই অফিসে গাঁথিয়া রাখা
                            হইয়াছে, এবং পার্শ্বে লিখিত টাকা তাহার নিকট হইতে উক্ত
                            সার্টিফিকেট বাবদ প্রাপ্য, এবং যেহেতু উক্ত সার্টিফিকেটের দাবী
                            পরিশোধ কল্পে সার্টিফিকেটধারীকে উক্ত
                            ' . $loanAmountBng . ' টাকা প্রদত্ত করা হয় নাই।

                        </div>

                        <div style="text-align: justify;">
                            <span style="padding-left: 40px">অতএব,</span> এতদ্বারা আপনাকে আদেশ করা যাইতেছে যে,
                            আপনি উক্ত সার্টিফিকেটমত খাতককে গ্রেফতার করিবেন,এবং
                            সার্টিফিকেটমত খাতক এই পরোয়ানা জারীর খরচ বাবদ ' . $loanAmountBng . '
                            টাকা আপনাকে না দিলে সুবিধামত সত্ত্বরতা তাহাকে আদালতের সম্মুখে উপস্থিত করিবেন।
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="10%" style="border: 1px solid black">

                        <p>খরচ......</p>

                        <p>জারী......</p>

                        <p>মোট......</p>
                    </td>
                    <td width="10%" style="border: 1px solid black"></td>
                    <td width="10%" style="border: 1px solid black"></td>
                </tr>
            </table>
        </div>
        <div>
            <span style="padding-left: 40px"> আপনাকে </span> আরও আদেশ করা যাইতেছে যে, আপনি ' . $trialBanglaYear . ' সালের ' . $trialBanlaMonth . ' মাসের ' . $trialBanglaDay . ' দিবসে বা তৎপূর্বে যে দিবসে ও যে প্রকারে এই ওয়ারেন্ট জারি করা হইয়াছে অথবা উহা জারি না হইবার কারণ বিজ্ঞাপক পৃষ্ঠালিপিসহ উহা ফিরাইয়া দিবেন।
        </div>
        <div style="padding-top: 20px">
            <span style="padding-left: 40px"> তারিখ অদ্য ' . $trialBanglaYear . ' সালের ' . $trialBanlaMonth . ' মাসের ' . $trialBanglaDay . ' দিবসে।
        </div>
        <div style="padding-top: 20px;padding-bottom: 100px">
            <span style="float: right">
                <p style=" text-align : center; color: blueviolet;">
                        <img src="' . globalUserInfo()->signature . '" alt="signature" width="100" height="50">
                        
                        <br>' . '<b>' . globalUserInfo()->name . '</b>' . '<br> ' . '
                    সার্টিফিকেট   অফিসার <br>
                </p>
               ' . $location . '
            </span>
        </div>
    </div>';

        //dd($template);
        return $template;
    }

    //---------------------------------সার্টিফিকেট  রাজকীয় প্রাপ্যের সার্টিফিকেট  ------------------------------------------------
    public static function getRajokioPrappoShortOrderTemplate($appealInfo, $causeList)
    {

        $office_name = DB::table('office')->where('id', '=', globalUserInfo()->office_id)->first();

        $location = $office_name->office_name_bn;

        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        $loanMoney = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        $applicant = $appealInfo['applicantCitizen'][0];
        $offenderAddress = $offender->present_address;

        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($causeList->conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($causeList->conduct_date)));
        $trialBanglaYear = DataConversionService::toBangla(date("Y", strtotime($causeList->conduct_date)));

        $template = '<style>
                table, th, td {
                    border: 1px solid black;
                    border-collapse: collapse;
                    padding: 10px;
                    font-weight: normal;
                }
                </style>
                <div id="crimieDescription" class="arrest-warrant">
                    <div style="min-height: 100%">
                    <header>
                        <div style="text-align: left">
                            বাংলাদেশ ফরম নং ১০২৭
                        </div>
                        <div style="text-align: center">
                            <h3>রাজকীয় প্রাপ্যের সার্টিফিকেট</h3>
                            <h4 style="display: inline-block; border-top: 1px dashed #222; border-bottom: 1px dashed #222; padding: 10px; margin: 10px 0;">
                                [ ৪ ও ৬ ধারা দেখুন ]
                            </h4>
                        </div>
                    </header>

                    <div style="margin-top: 5%;margin-bottom: 5%">' . $location . ' এর সার্টিফিকেট অফিসারের অফিসে গাঁথিয়া রাখা সার্টিফিকেট নং  ' . $caseNo . ' </div>

                    <table style="width: 100%">
                        <tr>
                            <th width="35%" style="text-align: justify">সার্টিফিকেটধারীর নাম ও ঠিকানা।</th>
                            <td colspan="2">' . $applicant->citizen_name . ' , ' . $applicant->present_address . '</td>
                        </tr>
                        <tr>
                            <th style="text-align: justify"> সুদ থাকিলে সুদসমেত এবং ৫ ধারার (২) প্রকরণানুযায়ীক ফিসসমেত রাজকীয় প্রাপ্য বাবদ যত টাকার নিমিত্ত
                                এই সার্টিফিকেটে স্বাক্ষর করা গেল এবং যে কাজের নিমিত্ত ঐ টাকা প্রাপ্য ।</th>
                            <td> <p style="text-align: center">' . $loanMoney . ' টাকা</p> </td> <td></td>
                        </tr>
                        <tr>
                            <th style="text-align: justify">সার্টিফিকেটমত খাতকের নাম ও ঠিকানা</th>
                            <td colspan="2">' . $offender->citizen_name . ' , ' . $offenderAddress . '</td>
                        </tr>
                        <tr>
                            <th style="text-align: justify">যে রাজকীয় প্রাপ্যের নিমিত্ত এই সার্টিফিকেট স্বাক্ষর করা গেল সেই প্রাপ্যের আরও বিবরণ।</th>
                            <td colspan="2"> </td>
                        </tr>
                    </table>

                    </div>
                    <div style="padding-top: 10%">
                        <div style="margin-bottom: 10%">
                            <span >আমি </span> এই সার্টিফিকেট দিতেছি যে পূর্ব পৃষ্ঠায় উল্লেখিত টাকা সার্টিফিকেটমত  খাতক (গণ) হইতে সার্টিফিকেটধারীর প্রাপ্য ও
                            ন্যায়মতে আদায়যোগ্য এবং মোকদ্দমা করিয়া আদায় সম্বন্ধে আইনমতে বাধ্য নাই।
                        </div>
                        <div>
                            তারিখ অদ্য ' . $trialBanglaYear . '  সালের  ' . $trialBanlaMonth . ' মাসের ' . $trialBanglaDay . ' দিবস
                        </div>
                        </br>
                        <div style="float: right">
                            <span style="float: right;"> সার্টিফিকেট অফিসার </span><br>
                            ' . $location . '
                        </div>
                    </div>
            </div>';

        return $template;
    }


    //---------------------------------সার্টিফিকেট  রাজকীয় প্রাপ্য  আইনের ৭৭ ধারা। ------------------------------------------------
    public static function getRajokioPrappoAinerDharaShortOrderTemplate($appealInfo, $causeList)
    {

        $office_name = DB::table('office')->where('id', '=', globalUserInfo()->office_id)->first();

        $location = $office_name->office_name_bn;
        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        $loanMoney = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        $offenderAddress = $offender->present_address;

        $template = '<div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">
                <h3>গ্রেফতারী পরোয়ানা কেন বাহির করা হইবে না <br> তাহার কারণ দর্শাইবার নোটিশ </h3>
                <h4>
                    ( রাজকীয় প্রাপ্য আইনের ৭৭ ধারা )
                </h4>
            </div>
        </header>
        <div>
            <p style="text-align: right">সার্টিফিকেট মোকদ্দমা নং ' . $caseNo . '</p>
        </div>
        <br>
        <div>
            <div>
                <p style="text-align: justify;line-height: 30px;"> প্রতি (খাতক): ' . $offender->citizen_name . ' পিতার নাম: ' . $offender->father . ' ঠিকানা: ' . $offender->present_address . ' </p>
            </div>
            <div style="text-align: justify;line-height: 30px;">
                <span style="margin-left: 30px">আপনাকে জানানো যাচ্ছে যে, </span>উক্ত সার্টিফিকেট মোকদ্দমার ' . $loanMoney . '
                টাকা আদায়ের জন্য কেন আপনাকে গ্রেফতার করা হইবে না তাহা নোটিশ পাওয়ার
                ....................... তারিখের মধ্যে এই আদালতে হাজির হইয়া তাহার কারণ
                দর্শাইবেন।  অন্যথায় সার্টিফিকেট আইনানুযায়ী যথারীতি ব্যবস্থা গ্রহণ করা হইবে।
            </div>
            <div>
                <span style="margin-left: 30px">আমার স্বাক্ষর ও আদালতের মোহর যুক্ত মতে দেওয়া গেল। </span>
            </div>
        </div>
        <div style="text-align: right">
            <span> সার্টিফিকেট অফিসার </span><br>
            ' . $location . '
        </div>

        <div>
           <h5 > বিঃ দ্রঃ এই নোটিশ অগ্রাহ্য করা হইলে গ্রেফতারী পরোয়ানা ইস্যু করা হইবে।</h5>
        </div>
    </div>';

        return $template;
    }

    //---------------------------------সার্টিফিকেট  পরোয়ানা রি-কল ------------------------------------------------
    public static function getPoroanaRecallShortOrderTemplate($appealInfo, $causeList)
    {


        $office_name = DB::table('office')->where('id', '=', globalUserInfo()->office_id)->first();

        $location = $office_name->office_name_bn;
        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        $loanMoney = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        $offenderAddress = $offender->present_address;
        $currentBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));


        $template = '<div style="padding-top: 5%;">
            <div style="text-align: center">
                 <span>
                 গণপ্রজাতন্ত্রী বাংলাদেশ সরকার </br>
                ' . $location . '</br>
                 ( জেনারেল সার্টিফিকেট আদালত )</br>
                </span>
            </div></br>

            <div>
                <span>
                     স্বারক  সংখ্যাঃ  ৩৬৯  জি সি ও
                </span>
                <span style="float: right">
                     তারিখঃ ' . $currentBanglaDate . '
                </span>
            </div></br>
            <div>
                বিষয় : সার্টিফিকেট মামলা নং - ' . $caseNo . '  এর  খাতক ' . $offender->citizen_name . '  পিতা /স্বামী ' . $offender->father . ' ঠিকানা ' . $offenderAddress . ' এর বিরুদ্ধে জারীর জন্য প্রেরিত গ্রেফতারী/ক্রোকী পরোয়ানা রি-কল প্রদান প্রসঙ্গে ।
            </div></br>
            <div>
               <span>
              উপর্যুক্ত বিষয়ে আপনাকে জানানো যাচ্ছে যে, পিডিআর এক্ট ১৯১৩ এর বিধানমতে উল্লেখিত সার্টিফিকেট মামলার সমুদয় সরকারী দাবির টাকা আদায়ের লক্ষে উপরোক্ত খাতক/খাতকগণের বিরুদ্ধে গ্রেফতারী/ক্রোকী পরোয়ানা প্রেরণ করা হয়েছিল। উক্ত খাতক/খাতকগণ ইতোমধ্যে উচ্চ আদালতে আপীল দায়ের করেছেন/আংশিক পরিশোধ করেছেন/আপত্তি দাখিল করেছেন/আপোষ/মীমাংসা/সমুদয় অর্থ পরিশোধ করেছেন ।
            </span>
            </div></br>
            <div>
                <span>এমতাবস্থায়, উক্ত খাতক/খাতকগণের বিরুদ্ধে তামিলের নিমিত্তে আপনার থানায় প্রেরিত সকল গ্রেফতারী/ক্রোকী পরোয়ানা পরবর্তী নির্দেশ না দেয়া পর্যন্ত আপাততঃ বিনা জারীতে/বিনা তামিলে রি-কল দেয়ার নির্দেশ দেয়া হল।</span>
            </div></br>
            <div><table width="100%">
              <tr><td>ভারপ্রাপ্ত  কর্মকর্তা </br>
                    .................</td> <td class="text-right">জেনারেল সার্টিফিকেট  অফিসার</br>
                    ' . $location . '</td> </tr>
            </table></div>

    </div>';

        return $template;
    }


    //---------------------------------মামলার প্রত্যহার------------------------------------------------
    public static function getCaseRejectionApplicationShortOrderTemplate($appealInfo, $causeList)
    {
        $office_name = DB::table('office')->where('id', '=', globalUserInfo()->office_id)->first();
        $location = $office_name->office_name_bn;

        if ($office_name->level == 4) {
            $unoHeader = ' </br>
             উপজেলা নির্বাহী অফিসার</br>
             ও</br>';

            $UpazilaPorishoderPhokhe = 'উপজেলা পরিষদের পক্ষে</br>';
        } else {
            $unoHeader = '</br>';
            $UpazilaPorishoderPhokhe = '<br>';
        }



        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        $loanMoney = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        $offenderAddress = $offender->present_address;
        $currentBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));


        $template = '<div style="padding-top: 5%;">
        <span>
        বরাবর ' . $unoHeader . ' 
        জেনারেল সার্টিফিকেট অফিসার</br>
        ' . $location . '।</br>
        </br>
        বিষয় : সার্টিফিকেট মামলা নং - ' . $caseNo . ' প্রত্যাহার</br>
        </br>
        মহোদয়,</br>
        </span>
        <span style="margin-left: 40px;">সবিনয়ে জানাচ্ছি যে,</span> <span>
        উপজেলা পরিষদের বকেয়া টাকা আদায়ের লক্ষে আপনার আদালতে সার্টিফিকেট মামলা দায়ের করা হল।
        দায়েরকৃত ' . $caseNo . ' নং মামলার খাতক ' . $offender->citizen_name . ', পিতা-' . $offender->father . ', ' . $offenderAddress . '
        দাবীকৃত ' . $loanMoney . ' টাকা উপজেলা হাটবাজার হিশাব নং - ____________ তে জমা করে জমা স্লিপ নিম্ন স্বাক্ষরকারীর
        নিকট দাখিল করেছেন।
        </span></br>
        </br>
        <span style="margin-left: 40px;">এমতাবস্থায়,</span> <span>
        বর্ণিত মামলাটি প্রত্যাহারের প্রয়োজনীয় ব্যবস্থা গ্রহণের জন্য সবিনয়ে অনুরোধ করছি।</br>
        সংযুক্ত : জমা স্লিপ-০১ প্রস্থ।
        </span></br>
               </br>
        তারিখ : ' . $currentBanglaDate . '</br>
        <div style="float: right">
            <span style="margin-left: 20px">নিবেদক-</span></br>
            ' . $UpazilaPorishoderPhokhe . '
            ' . $appealInfo['appeal']->gco_name . '</br>
             জেনারেল সার্টিফিকেট অফিসার</br>
            ' . $appealInfo['appeal']->office_name . '</br>
        </div>
        </br>
        <span>
        দেখলাম</br>
        </br>
        জেনারেল সার্টিফিকেট অফিসার</br>
        ' . $unoHeader . '
        ' . $location . '</br>
        </span>

    </div>';
        //dd($template);
        return $template;
    }

    //---------------------------------------ক্রোক---------------------------------//
    public static function generateCrokeTemplate($appealInfo, $causeList)
    {

        $offender = $appealInfo['defaulterCitizen'];
        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        $lawSection = DataConversionService::toBangla($appealInfo['appeal']->law_section);
        $appealBanglaDay = DataConversionService::toBangla(date('d', strtotime($appealInfo['appeal']->created_at)));
        $appealBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($appealInfo['appeal']->created_at)));
        $appealBanglaYear = DataConversionService::toBangla(date("Y", strtotime($appealInfo['appeal']->created_at)));

        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($causeList->conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($causeList->conduct_date)));
        $trialBanglaYear = DataConversionService::toBangla(date("Y", strtotime($causeList->conduct_date)));

        $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));

        $office_name = DB::table('office')->where('id', '=', globalUserInfo()->office_id)->first();

        /* 
        $template= '<style>
                td{
                    padding-top: 10px;
                    padding-bottom: 10px;
                }
                </style>
        <div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: left">
                বাংলাদেশ ফরম নং ১১৭৭
            </div>
            <div style="text-align: center">
                <h3>১১ক নং ফরম।</h3>
                <h3>অস্থাবর সম্পত্তি ক্রোকের পরোয়ানা</h3>
                <h4>(১৩ ও ১৪ ধারা দ্রষ্টব্য)</h4>
            </div>
        </header>
        <p class="text-center">যেহেতু বাংলাদেশের রাজকীয় প্রাপ্য আদায় বিষয়ক ১৯১৩ সালের আইনের '.$lawSection.' ধারানুসারে</p>
        <div style="padding-top: 20px">
            <table width="100%" class="table">
                <tr>
                    <td width="10%" style="border: 1px solid black">
                        <p style="padding-top: 20px">মূল্য দাবী...</p>

                        <p>সুদ.........</p>

                    </td>
                    <td width="10%" style="border: 1px solid black">টাকা </br> '.$loanAmountBng.' </td>
                    <td width="10%" style="border: 1px solid black">পঃ </td>
                    <td width="50%" rowspan="2">
                        <div style="text-align: justify;">
                            সার্টিফিকেট খাতক
                            জনাব '.$offender->citizen_name.' র বিরুদ্ধে '.$appealBanglaYear.' সালের '.$appealBanlaMonth.' মাসের '.$appealBanglaDay.' দিবসে
                            '.$caseNo.'  নম্বরে এক সার্টিফিকেট এই অফিসে গাঁথিয়া রাখা
                            হইয়াছে, এবং পার্শ্বে লিখিত টাকা তাহার নিকট হইতে উক্ত
                            সার্টিফিকেট বাবদ প্রাপ্য, এবং যেহেতু উক্ত সার্টিফিকেটের দাবী
                            পরিশোধ কল্পে সার্টিফিকেটধারীকে উক্ত  '.$loanAmountBng.' টাকা প্রদত্ত করা হয় নাই।

                        </div>

                        <div style="text-align: justify;">
                            <span style="padding-left: 40px">অতএব,</span> এতদ্বারা আপনাকে আদেশ করা যাইতেছে যে,
                             আপনি উক্ত সার্টিফিকেটমত খাতকের *অস্থাবর সম্পত্তি ক্রোক
                             করিবেন, এবং সার্টিফিকেটমত খাতক আপনাকে উক্ত
                             টাকা, যা এই পরোয়ানা জারীর খরচ বাবদ '.$loanAmountBng.'
                            টাকা না দিলে আপনি এই আদালত হইতে অন্য কোন হুকুম না পাওয়া পর্যন্ত উহা ক্রোক রাখিবেন।
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="10%" style="border: 1px solid black">

                        <p>খরচ......</p>

                        <p>জারী......</p>

                        <p>মোট......</p>
                    </td>
                    <td width="10%" style="border: 1px solid black"></td>
                    <td width="10%" style="border: 1px solid black"></td>
                </tr>
            </table>
        </div>
        <div>
            <span style="padding-left: 40px"> আপনাকে </span> আরও আদেশ করা যাইতেছে যে, যে তারিখে ও যে প্রকারে এই পরোয়ানা জারী করা হয় অথবা উহা জারী না হইয়া থাকিলে কি কারণে জারী হয় নাই তাহা ইহার পৃষ্ঠে লিখিয়া '.$trialBanglaYear.' সালের '.$trialBanlaMonth.' মাসের '.$trialBanglaDay.' দিবসে অথবা তৎপূর্বে এই পরোয়ানা ফেরত দিবেন।
        </div>
        <div style="padding-top: 20px">
            <span style="padding-left: 40px"> তারিখ অদ্য '.$trialBanglaYear.' সালের '.$trialBanlaMonth.' মাসের '.$trialBanglaDay.' দিবসে।
        </div>
        <div style="padding-top: 20px;padding-bottom: 100px">
            <span style="float: right">
               <p style=" text-align : center; color: blueviolet;">
                        <img src="'.globalUserInfo()->signature.'" alt="signature" width="100" height="50">
                        
                        <br>'.'<b>'. globalUserInfo()->name .'</b>'.'<br> '.'
                    সার্টিফিকেট   অফিসার <br>
                </p>
               '. $office_name->office_name_bn.'
            </span>
        </div>
        <div>
         <p style="text-align: center;border-top: 1px solid #0d0808">
            *যে স্থলে অস্থাবর সম্পত্তির কতক অংশ মাত্র ক্রোক করিবার হুকুম হয় সে স্থলে এখানে “টাকা মূল্যের” এই কথাগুলি যোগ করিয়া দিতে হইবে।
         </p>
        </div>
    </div>' */
        $template = ' <div id="crimieDescription" class="arrest-warrant">
   <header>
       <div style="text-align: left">
           বাংলাদেশ ফরম নং ১১৭৭
       </div>
       <div style="text-align: center">
           <h3>১১ক নং ফরম।</h3>
           <h3>অস্থাবর সম্পত্তি ক্রোকের পরোয়ানা</h3>
           <h4>(১৩ ও ১৪ ধারা দ্রষ্টব্য)</h4>
       </div>
   </header>
   <div class="all_content">
   <p>প্রাপক,</p>
   <p>যেহেতু বাংলাদেশের রাজকীয় প্রাপ্য আদায় বিষয়ক ১৯১৩ সালের আইনের ' . $lawSection . ' ধারানুসারে</p>
   <div style="text-align: justify; margin-bottom: 5px;">
       সার্টিফিকেট খাতক
       জনাব ' . $offender->citizen_name . ' এর বিরুদ্ধে ' . $appealBanglaYear . ' সালের ' . $appealBanlaMonth . ' মাসের ' . $appealBanglaDay . ' দিবসে
       ' . $caseNo . '  নম্বরে এক সার্টিফিকেট এই অফিসে গাঁথিয়া রাখা
       হইয়াছে, এবং পার্শ্বে লিখিত টাকা তাহার নিকট হইতে উক্ত
       সার্টিফিকেট বাবদ প্রাপ্য, এবং যেহেতু উক্ত সার্টিফিকেটের দাবী
       পরিশোধ কল্পে সার্টিফিকেটধারীকে উক্ত  ' . $loanAmountBng . ' টাকা প্রদত্ত করা হয় নাই।

   </div>

   <div style="text-align: justify;">
       <span>অতএব,</span> এতদ্বারা আপনাকে আদেশ করা যাইতেছে যে,
        আপনি উক্ত সার্টিফিকেটমত খাতকের *অস্থাবর সম্পত্তি ক্রোক
        করিবেন, এবং সার্টিফিকেটমত খাতক আপনাকে উক্ত
        টাকা, যা এই পরোয়ানা জারীর খরচ বাবদ ' . $loanAmountBng . '
       টাকা না দিলে আপনি এই আদালত হইতে অন্য কোন হুকুম না পাওয়া পর্যন্ত উহা ক্রোক রাখিবেন।
   </div>
   <div style="margin-top: 10px;">
       <span> আপনাকে </span> আরও আদেশ করা যাইতেছে যে, যে তারিখে ও যে প্রকারে এই পরোয়ানা জারী করা হয় অথবা উহা জারী না হইয়া থাকিলে কি কারণে জারী হয় নাই তাহা ইহার পৃষ্ঠে লিখিয়া ' . $trialBanglaYear . ' সালের ' . $trialBanlaMonth . ' মাসের ' . $trialBanglaDay . ' দিবসে অথবা তৎপূর্বে এই পরোয়ানা ফেরত দিবেন।
   </div>
   <div style="padding-top: 20px">
       <table width="100%" class="table">
           <tr>
               <td width="10%" style="border: 1px solid black">
                   <p style="padding-top: 20px">মূল্য দাবী...</p>
                   <p>সুদ.........</p>
               </td>
               <td width="10%" style="border: 1px solid black">টাকা </br> ' . $loanAmountBng . ' </td>
               <td width="10%" style="border: 1px solid black">পঃ </td>
           </tr>
           <tr>
               <td width="10%" style="border: 1px solid black">

                   <p>খরচ......</p>

                   <p>জারী......</p>

                   <p>মোট......</p>
               </td>
               <td width="10%" style="border: 1px solid black"></td>
               <td width="10%" style="border: 1px solid black"></td>
           </tr>
       </table>
   </div>
   <div style="padding-top: 20px">
       <span style="padding-left: 40px"> তারিখ অদ্য ' . $trialBanglaYear . ' সালের ' . $trialBanlaMonth . ' মাসের ' . $trialBanglaDay . ' দিবসে।
   </div>
   <div style="padding-top: 20px;padding-bottom: 100px">
       <span style="float: right">
          <p style=" text-align : center; color: blueviolet;">
                   <img src="' . globalUserInfo()->signature . '" alt="signature" width="100" height="50">
                   
                   <br>' . '<b>' . globalUserInfo()->name . '</b>' . '<br> ' . '
               সার্টিফিকেট   অফিসার <br>
           </p>
          ' . $office_name->office_name_bn . '
       </span>
   </div>
   <div>
    <p style="text-align: center;border-top: 1px solid #0d0808">
       *যে স্থলে অস্থাবর সম্পত্তির কতক অংশ মাত্র ক্রোক করিবার হুকুম হয় সে স্থলে এখানে “টাকা মূল্যের” এই কথাগুলি যোগ করিয়া দিতে হইবে।
    </p>
   </div>
   </div>
</div>';
        return $template;
    }

    //---------------------------------দেওয়ানী কারাগারে প্রেরণের জন্য কারণ দর্শানো ------------------------------------------------
    public static function getReasonToCriminalJailShortOrderTemplate($appealInfo, $causeList)
    {
        $template = '';
        $defaulter = $appealInfo['defaulterCitizen'];
        $appeal = $appealInfo['appeal'];

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));
        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($causeList->conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($causeList->conduct_date)));
        $trialTime = date('h:i:s a', strtotime($causeList->conduct_time));
        $trialBanglaYear = DataConversionService::toBangla(date("Y", strtotime($causeList->conduct_date)));


        $appealBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($appeal->case_date)));
        $appealBanglaDay = DataConversionService::toBangla(date('d', strtotime($appeal->case_date)));
        $appealBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($appeal->case_date)));
        $appealBanglaYear = DataConversionService::toBangla(date("Y", strtotime($appeal->case_date)));



        $template = '<div style="font-size: medium;padding-top: 5%;">
                        <header>
                            <div style="text-align: center">
                                <h4>" কেন গ্রেফতারী পরোয়ানা ইস্যু করা হইবে না তাহার কারণ দর্শানোর নোটিশ "
                                <br>
                                 (বিধি  -৭৭ )</h4>
                                <br>
                            </div>
                        </header>
                        <div>
                             <p> প্রতি : জনাব  ' . $defaulter->citizen_name . ' পিতা ' . $defaulter->father . ' </p>

                                <p>সাং ............. পো : ................... উপজেলা ................</p>
                                <p> জেলা ................................ ।</p>
                            <p>
                                &emsp; যেহেতু ১৯৯৩ সালের পাবলিক ডিমান্ড রিকভারি এক্টের ৪/৬ ধারা অনুসারে আপনার বিরুদ্ধে ' . $appeal->case_no . ' নম্বরের এক সার্টিফিকেট ' . $appealBanglaYear . ' সালের ' . $appealBanlaMonth . ' মাসের ' . $appealBanglaDay . ' দিবসে এই অফিসে গাথিয়া রাখা হইয়াছে এবং যেহেতু আপনি দাবীকৃত অর্থ পরিশোধ করেন নাই সেহেতু আপনি আগামী ' . $trialBanglaDate . ' খ্রি  তারিখ আমার সম্মুখে হাজির হইয়া কেন আপনাকে দেওয়ানী কারাগারে সোপর্দ করা হইবে না তাহার কারণ দর্শাইবেন ।

                            </p>
                            <br>
                                <p align="center">
                                    অদ্য ' . $trialBanglaYear . ' সালের ' . $trialBanlaMonth . ' মাসের ' . $trialBanglaDay . ' দিবস ।
                                </p>
                                <br><br>
                                <p align="right">
                                    <p style=" text-align : center; color: blueviolet;">
                                            <img src="' . globalUserInfo()->signature . '" alt="signature" width="100" height="50">
                                            
                                            <br>' . '<b>' . globalUserInfo()->name . '</b>' . '<br> ' . '
                                        সার্টিফিকেট   অফিসার <br>
                                    </p>
                                    জেলা প্রশাসকের কার্যালয়, ' . user_district_name() . '
                                   
                                </p>

                        </div>
                 </div>';

        return $template;
    }
}
