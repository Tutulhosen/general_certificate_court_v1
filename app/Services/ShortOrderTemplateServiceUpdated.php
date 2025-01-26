<?php

namespace App\Services;

use App\Models\Upazila;
use App\Models\CrpcSection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AppealRepository;
use App\Models\EmCaseShortdecisionTemplates;
use App\Models\GccCaseShortdecisionTemplates;


class ShortOrderTemplateServiceUpdated
{
    public static function getShortOrderTemplateListByAppealId($appealId)
    {
        $templateList = DB::table('gcc_case_shortdecision_templates')
            ->where('appeal_id', $appealId)
            ->get();
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
        return $shortOrderTemplate->id;
    }
    public static function generateShortOrderTemplate($shortOrders, $appealId, $causeList, $requestInfo)

    {
        // dd($shortOrders, $appealId, $causeList, $requestInfo);
        $appealInfo = AppealRepository::getAllAppealInfo($appealId);
        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        if ($appealInfo['appeal']->case_entry_type === "RUNNING") {
            $appealInfo['appeal']->newCaseNo = DataConversionService::toBangla($appealInfo['appeal']->manual_case_no);
            $appealInfo['appeal']->case_no = $caseNo;
            // dd("come if", $appealInfo['appeal']);
        } else {
            $appealInfo['appeal']->case_no = $caseNo;
            $appealInfo['appeal']->newCaseNo =  null;
            // dd("come else", $appealInfo['appeal']);
        }

        // dd($shortOrders);
        // self::deleteShortOrderTemplate($causeList->id);
        // if(count($shortOrders)>0){
        if ($shortOrders != null) {
            // dd($shortOrders);
            $templateIds = [];
            foreach ($shortOrders as $shortOrder) {
                if ($shortOrder == 21) {
                    $templateName = 'সার্টিফিকেট খাতকের প্রতি দাবির নোটিশ (১০ ক ধারা)';
                    $shortOrderTemplate = self::getCertificateDefaulterNoticeSectionTenShortOrderTemplate($appealInfo, $requestInfo);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    $templateName = 'সার্টিফিকেট রাজকীয় প্রাপ্যের সার্টিফিকেট';
                    $shortOrderTemplate = self::getRajokioPrappoShortOrderTemplate($appealInfo, $requestInfo);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                } elseif ($shortOrder == 2 || $shortOrder == 3) {

                    $templateName = 'সার্টিফিকেট খাতকের প্রতি দাবী (৭ ধারা)';
                    $shortOrderTemplate = self::getCertificateDefaulterNoticeSectionSevenShortOrderTemplate($appealInfo, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    $templateName = 'সার্টিফিকেট  রাজকীয় প্রাপ্যের সার্টিফিকেট';
                    $shortOrderTemplate = self::getRajokioPrappoShortOrderTemplate($appealInfo, $requestInfo);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                } elseif ($shortOrder == 5) {
                    $templateName = 'ক্রোক পরোয়ানা';
                    $shortOrderTemplate = self::generateCrokeTemplate($appealInfo, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                } elseif ($shortOrder == 17) {

                    $templateName = '৭৭ মোতাবেক কারণ দর্শানো নোটিশ জারী';
                    $shortOrderTemplate = self::getSeventySevenShortOrderTemplate($appealInfo, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                } elseif ($shortOrder == 6 || $shortOrder == 7 || $shortOrder == 11) {

                    $templateName = '২৯ ধারার নোটিশ (গ্রেফতারী পরোয়ানা)';
                    $shortOrderTemplate = self::getTwentyNineShortOrderTemplate($appealInfo, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                } elseif ($shortOrder == 18) {
                    $templateName = 'দেনাদারকে সিভিল জেলে  এ সোপর্দ করার আদেশ';
                    $shortOrderTemplate = self::getSentToCivilCourtTemplate($appealInfo, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                } elseif ($shortOrder == 19) {
                    $templateName = 'সার্টিফিকেট কার্যকরী করার উদ্দেশ্যে জেলে আটক বাক্তিকে মুক্তি করার আদেশ';
                    $shortOrderTemplate = self::getReleasePerson($appealInfo, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                } elseif ($shortOrder == 20) {
                    $templateName = 'নিলাম ইস্তেহার';
                    $shortOrderTemplate = self::getAuctionNoticeShortOrderTemplate($appealInfo, $requestInfo);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);

                    $templateName = 'নিলাম ইস্তেহার প্রকাশ করার জন্য নাজিরকে আদেশ';
                    $shortOrderTemplate = self::getOrderToNajirForAuctionNoticeShortOrderTemplate($appealInfo, $requestInfo);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);

                    return $templateIds;
                    // dd($templateName);
                } elseif ($shortOrder == 22) {
                    // dd('come');
                    $templateName = 'নিলাম ঘোষণাপত্র স্থির';
                    $shortOrderTemplate = self::getDetermineAuctionTemplate($appealInfo, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);

                    return $templateIds;
                } elseif ($shortOrder == 23) {
                    $templateName = 'নিলাম দখল অর্পণের আদেশ';
                    $shortOrderTemplate = self::getAuctionPossessionShortOrderTemplate($appealInfo, $requestInfo);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);

                    $templateName = 'অস্থাবর সম্পত্তির দখলকারীকে সম্পত্তি নিলামে বিক্রি সম্পর্কে নোটিশ';
                    $shortOrderTemplate = self::getNoticeToOccupierShortOrderTemplate($appealInfo, $requestInfo);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                } else {
                    return null;
                }
            }
        }
    }
    /******* যা যা লাগবে সেগুলো */
    //--------------------------সার্টিফিকেট খাতকের প্রতি দাবী ( ১০(ক) ধারা) 10 (k) templete ------------------------------------------
    public static function getCertificateDefaulterNoticeSectionTenShortOrderTemplate($appealInfo, $requestInfo)
    {

        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);
        $defaulter = $appealInfo['defaulterCitizen'];
        $applicantCitizen = $appealInfo['applicantCitizen'];
        $appealBanglaDay = DataConversionService::toBangla(date('d', strtotime($appealInfo['appeal']->created_at)));
        $appealBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($appealInfo['appeal']->created_at)));
        $appealBanglaYear = DataConversionService::toBangla(date('Y', strtotime($appealInfo['appeal']->created_at)));
        $conduct_date_modify_array = explode('-', date_formater_helpers_v2($requestInfo->conductDate));
        $conduct_date_modify_string = $conduct_date_modify_array[2] . '/' . $conduct_date_modify_array[1] . '/' . $conduct_date_modify_array[0];
        $location = $office_name->office_name_bn;

        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;


        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $case_data_mapping = DB::table('gcc_appeals')
            ->join('office', 'gcc_appeals.office_id', 'office.id')
            ->join('district', 'gcc_appeals.district_id', 'district.id')
            ->where('gcc_appeals.id', $requestInfo->appealId)
            ->select('gcc_appeals.loan_amount_text', 'gcc_appeals.loan_amount', 'office.office_name_bn', 'office.organization_physical_address', 'district.district_name_bn')
            ->first();
        $office_info = get_office_by_id(globalUserInfo()->office_id);

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($modified_conduct_date)));
        $distric_name = DB::table('district')
            ->where('id', '=', $office_info->district_id)
            ->first();
        //$trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        //$trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));
        $amount_to_pay_as_remaining = $requestInfo->amount_to_pay_as_remaining;
        $amount_to_pay_as_costing = $requestInfo->amount_to_pay_as_costing;
        $total_amount = $amount_to_pay_as_costing + $amount_to_pay_as_remaining;
        // dd($amount_to_pay_as_costing, $amount_to_pay_as_remaining);

        $template = '
        <div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">
                <div style="display: flex; justify-content: space-between; padding: 0px 50px ; margin: 30px 0;">
                    <h5>বাংলাদেশ ফর্ম নং-১০
                    </h5>
                    <h5>(পরিশিষ্টের ফরম নং- ৩১)</h3>
                </div>
                <h4 style="font-weight: bold;">সার্টিফিকেট খাতকের প্রতি দাবির নোটিশ
                </h4>
                <h5>(১০ ক ধারা দ্রষ্টব্য)</h5>
                <p style="font-weight: bold; margin-top: 10px;">সার্টিফিকেট মোকদ্দমা নম্বর: ' . $appealInfo['appeal']->case_no . '</br>' .'ম্যানুয়াল মামলা নংঃ ' . $appealInfo['appeal']->newCaseNo . '. ' . '
                </p>
            </div>
        </header>
        <div class="all_content">
        <p>পাওনাদার ' . $applicantCitizen[0]->citizen_name . ' ধার্য তারিখ: ' . $trialBanglaDate . ' জনাব ' . $defaulter->citizen_name . ' পিতার নাম ' . $defaulter->father . ' ' . $defaulter->present_address . '</p>
        <p style="margin-top: 15px">আপনাকে এতদ্বারা জানানো যাইতেছে যে, আপনার নিকট ' . $applicantCitizen[0]->organization . ' বাবদ প্রাপ্য
 ' . en2bn($amount_to_pay_as_remaining) . ' টাকার নিমিত্ত আপনার বিরুদ্ধে একখানি সার্টিফিকেট বঙ্গদেশের রাজকীয় প্রাপ্য আদায় বিষয়ক ১৯১৩ সনের আইনের দ্বারা অদ্য আমার অফিসে গাথিয়া রাখা হইয়াছে। অত্র নোটিশ জারি হইবার সময় হইতে ৩০ দিনের মধ্যে আপনি সম্পূর্ণ ' . en2bn($total_amount) . ' টাকা এবং আদায় খরচ বাবদ ' . en2bn($amount_to_pay_as_costing) . ' টাকা আমার অফিসে জমা দিবেন। অত্র নোটিশ জারি হইবার পর হইতে উক্ত দাবীর টাকা সম্পূর্ণরূপে প্রদত্ত না হয় তাবৎ দান, বিক্রয় বা বন্ধক দ্বারা বা প্রকারান্তরে আপনার স্থাবর বা অস্থাবর সম্পত্তি হস্তান্তরিত করিতে নিষেধ করা যাইতেছে। অত্র আদেশ অমান্য করিলে আইন মোতাবেক কার্য করা হইবে।
        </p>
        <p>
            আপনি সার্টিফিকেটে যে নম্বর ও বৎসর তাহা উল্লেখ করিয়া মানি অর্ডারযোগে উক্ত টাকা পাঠাইতে পারেন।
        </p>
 <p>
    তারিখ অদ্য ' . $appealBanglaYear . ' সনের ' . $appealBanlaMonth . ' মাসের ' . $appealBanglaDay . ' দিবস।
 </p>
         
        
 <div style="padding-top: 20px;padding-bottom: 50px">
 <span style="float: right">
     <p style=" text-align : center; color: blueviolet;">
             <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
             
             <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
         সার্টিফিকেট   অফিসার <br>
     </p>
    ' .
            $location .
            ', '  .
            '
 </span>
    </div>
    </div>
    </div>
        ';

        return $template;
    }


    //-------------------------- সার্টিফিকেট খাতকের প্রতি দাবী (৭ ধারা) ------------------------------------------///
    public static function getCertificateDefaulterNoticeSectionSevenShortOrderTemplate($appealInfo, $requestInfo)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        $location = $office_name->office_name_bn;
        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);
        $defaulter = $appealInfo['defaulterCitizen'];
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;

        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $case_data_mapping = DB::table('gcc_appeals')
            ->join('office', 'gcc_appeals.office_id', 'office.id')
            ->join('district', 'gcc_appeals.district_id', 'district.id')
            ->where('gcc_appeals.id', $requestInfo->appealId)
            ->select('gcc_appeals.loan_amount_text', 'gcc_appeals.loan_amount', 'office.office_name_bn', 'office.organization_physical_address', 'district.district_name_bn')
            ->first();
        $amount_to_pay_as_remaining = $requestInfo->amount_to_pay_as_remaining;
        $amount_to_pay_as_costing = $requestInfo->amount_to_pay_as_costing;

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($modified_conduct_date)));
        //$trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        //$trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));

        $template =
            '<div style="">
                          <header>
                          <div style="display: flex; justify-content: space-between">
                          <p>বাংলাদেশ ফরম নং- ১০৩০</p>
                          <p>(পরিশিষ্টের ফরম নং- ৩)</p>
                        </div>
                              <div style="text-align: center">
                                  <h3>সার্টিফিকেটমত খাতকের প্রতি নোটিশ</h3>
                                  <h3>( ৭ ধারা দেখুন ) </h3>
                                  <h3>সার্টিফিকেট মোকদ্দমা নম্বর-(' .
            $case_in_text .
            ')</h3>
                              </div>
                          </header>
                          <br>
                          <div style="font-size:  medium; text-align:justify">
                          <div style="display: flex; justify-content: space-between;">
                          <span style="float:left">জনাব  ' .
            $defaulter->citizen_name .
            ' </span>
                          <span style="padding-right: 50px;">
                          সমীপেষু।
                          </span>
                          </div>
                              
                              <br>
                              <br>
                              <span style="">
                              আপনাকে এতদ্বারা জ্ঞাত করান যাইতেছে যে, আপনার নিকট হইতে ' .
            $case_data_mapping->office_name_bn .
            ', ' .
            ', বাবদ প্রাপ্য ' .
            en2bn($case_data_mapping->loan_amount) .
            ' (' .
            $case_data_mapping->loan_amount_text .
            ' টাকা মাত্র) টাকার নিমিত্ত আপনার বিরুদ্ধে একখানি   ৪ ও ৬ ধারা মোতাবেক নিম্নস্বাক্ষরকারীর কোর্টে একটি সার্টিফিকেট মামলা রুজু করা হইয়াছে। আপনি এই নোটিশ জারি করার ৩০ দিনের মধ্যে উক্ত টাকা সম্পূর্ণ অথবা আংশিক দায়দেনা অস্বীকার করিয়া আবেদন পত্র দাখিল করিতে পারেন। আপনি যদি উক্ত ৩০ (ত্রিশ) দিনের মধ্যে দায় দেনা অস্বীকার করিয়া আবেদন দায়ের করিতে অথবা আপনি যদি কারণ দর্শাইতে ব্যার্থ হন অথবা এরূপ সার্টিফিকেট কেস কেন কার্যকর করা হইবে না তার পর্যাপ্ত কারণ না দর্শান তাহইলে উহা উক্ত আইনে বিধান মোতাবেক কার্যকরী করা হইবে, যতক্ষণ পর্যন্ত আপনি ' . en2bn($amount_to_pay_as_remaining) . ' টাকা বকেয়া বাবদ এবং ' . en2bn($amount_to_pay_as_costing) . ' টাকা খরচ আদায় বাবদ আমার অফিসে পরিশোধ না করিবেন।</span>
                              <br>
                              <br>
                              <span style="">উক্ত টাকা পরিশোধ না করা পর্যন্ত আপনার স্তাবর সম্পত্তি অথবা অংশ বিশেষ বিক্রি,দান,মর্গেজ অথবা অন্যান্যভাবে হস্তান্তর করিতে নিষেধ করা হইলো। ইতোমধ্যে আপনি যদি অস্তাবর সম্পত্তি অংশ বিশেষ গোপনে অপসারণ বা হস্তান্তর করেন তাহইলে সার্টিফিকেট ততক্ষখনাত কার্যকর হইবে। </span>
                              <br>
                              <br>
                              <span style="">উপরের বর্ণিত সার্টিফিকেট এক কপি এই সংগে যুক্ত করা হইলো। আপনি সার্টিফিকেট নম্বর ও বছর উল্লেখ করে টাকা জমা দিয়ে তার প্রমানক দাখিল করিতে পারেন।</span>
                               <br><br>
                              <span style=""> তারিখঃ ' .
            $trialBanglaDate .
            ' </span><span>
                          </div>
                          <br>
                          <br>
                          <div style="padding:20px">
                          <span style="float: right">
                           <p style=" text-align : center; color: blueviolet;">
                                   <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
                                   
                                   <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
                               সার্টিফিকেট   অফিসার <br>
                           </p>
                          ' .
            $location .
            ', '  .
            '
                       </span>
                          </div>
                      </div>';

        return $template;
    }

    //---------------------------------সার্টিফিকেট  রাজকীয় প্রাপ্যের সার্টিফিকেট  ------------------------------------------------
    public static function getRajokioPrappoShortOrderTemplate($appealInfo, $requestInfo)
    {

        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        $defaulter = $appealInfo['defaulterCitizen'];
        $applicantCitizen = $appealInfo['applicantCitizen'];
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;
        $appealBanglaDay = DataConversionService::toBangla(date('d', strtotime($appealInfo['appeal']->created_at)));
        $appealBanglaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($appealInfo['appeal']->created_at)));
        $appealBanglaYear = DataConversionService::toBangla(date('Y', strtotime($appealInfo['appeal']->created_at)));
        $office_info = get_office_by_id(globalUserInfo()->office_id);
        $court_fee_amount = $requestInfo->court_fee_amount;
        $interest_rate = $requestInfo->interestRate;
        if (isset($court_fee_amount) && !empty($court_fee_amount)) {
            $court_fee = DataConversionService::toBangla($requestInfo->court_fee_amount);
        } else {
            $court_fee = '..............';
        }
        // dd($requestInfo->court_fee_amount, $court_fee);
        $interest = DataConversionService::toBangla($requestInfo->amount_to_pay_as_costing);
        // $amount_to_pay_as_costing_bng = DataConversionService::toBangla($requestInfo->amount_to_pay_as_costing);
        // $total_jari_bng = DataConversionService::toBangla($requestInfo->total_jari);
        $interestAmount = (int)$requestInfo->amount_to_pay_as_remaining * (int) $interest_rate / 100;
        $interestAmountBng = DataConversionService::toBangla($interestAmount);
        $total_amount = (int)$appealInfo['appeal']->loan_amount + (int)$interestAmount +  (int)$court_fee_amount + (int)$requestInfo->amount_to_pay_as_costing;
        $total_amount_bng = DataConversionService::toBangla($total_amount);
        // dd($total_amount_bng);
        // dd($total_amount,$requestInfo->amount_to_pay_as_costing, $appealInfo);
        // dd($requestInfo->court_fee_amount); 
        $distric_name = DB::table('district')
            ->where('id', '=', $office_info->district_id)
            ->first();
        // dd($distric_name);
        $location = $office_name->office_name_bn;

        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $case_data_mapping = DB::table('gcc_appeals')
            ->join('office', 'gcc_appeals.office_id', 'office.id')
            ->join('district', 'gcc_appeals.district_id', 'district.id')
            ->where('gcc_appeals.id', $requestInfo->appealId)
            ->select('gcc_appeals.loan_amount_text', 'gcc_appeals.loan_amount', 'office.office_name_bn', 'office.organization_physical_address', 'district.district_name_bn')
            ->first();

        $organization_full_address = $case_data_mapping->office_name_bn . ', ' . $case_data_mapping->organization_physical_address . ', ' . $case_data_mapping->district_name_bn;
        $template =
            ' <style>
            table,
            th,
            td {
              border: 1px solid black;
              border-collapse: collapse;
              padding: 10px;
              padding-bottom: 5px;
              font-weight: normal;
            }
            #all_content {
              padding: 10ex;
            }
            hr{
              margin: 0;
            }
          </style>
                <div id="all_content" class="arrest-warrant">
      <header>
        <div style="display: flex; justify-content: space-between">
          <p>বাংলাদেশ ফরম নং ১০২৭</p>
          <p>(পরিশিষ্টের ফরম নং- ১)</p>
        </div>
        <div style="text-align: center">
          <h4>রাজকীয় প্রাপ্যের সার্টিফিকেট</h4>
          <h4>[ ৪ ও ৬ নং ধারা দেখুন। ]</h4>
          <p style="margin-top: 30px">
            <span style="margin-right:10px;">................</span>   ' . "'" . ' র সাটিফিকেট
            কর্মচারীর অফিসে গাঁথিয়া রাখা সার্টিফিকেট নং ' . $appealInfo['appeal']->case_no . '</br>' .'ম্যানুয়াল মামলা নংঃ ' . $appealInfo['appeal']->newCaseNo . '
          </p>
        </div>
      </header>
      <table>
        <tr>
          <th width="50%" style="text-align: center;">সার্টিফিকেটধারীর নাম ও ঠিকানা</th>
          <th style="text-align: center;"> নামঃ ' . $applicantCitizen[0]->citizen_name . ', ঠিকানাঃ ' . $applicantCitizen[0]->present_address . '</th>
          <th></th>
        </tr>
        <tr>
          <th>
            সুদ থাকিলে সুদসমেত এবং ৫ ধারার (২) প্রকরণানুযায়িক ফিসসমেত রাজকীয়
            প্রাপ্য বাবদ যত টাকার নিমিত্ত এই সার্টিফিকেটে স্বাক্ষর করা গেল এবং
            যে কাজের নিমিত্ত ঐ টাকা প্রাপ্য। সার্টিফিকেটমত খাতকের নাম ও ঠিকানা
            যে রাজকীয় প্রাপ্যের নিমিত্ত এই সার্টিফিকেট স্বাক্ষর করা গেল সেই
            প্রাপ্যের আরও বিবরণ।
          </th>
          <th>
          <p style="text-align: center; font-weight: 800">টাকা</p>
          <p>আসল</p>
          <p>সুদ</p>
          <p>অন্যান্য</p>
          <p>কোর্ট ফি</p>
          <p>প্রসেস ফি</p>
          <p><b>মোট</b></p>
        </th>
        <th>
          <p style="text-align: center; font-weight: 800"></p>
          <p>' . $requestInfo->totalLoanAmount . '</p>
          <p>' . $interestAmountBng . '</p>
          <p> .............. </p>
          <p>' . $court_fee  . '</p>
          <p>' . $interest . '</p>
          <p> <b>' . $total_amount_bng . '</b></p>
        </th>
        </tr>
        <tr>
          <td>সার্টিফিকেটমত খাতকের নাম ও ঠিকানা</td>
          <td colspan="2">নামঃ ' . $defaulter->citizen_name . ', ঠিকানাঃ ' . $defaulter->present_address . '</td>
        </tr>
        <tr>
          <td>
            যে রাজকীয় প্রাপ্যের নিমিত্ত এই
            সার্টিফিকেট স্বাক্ষর করা গেল সেই প্রাপ্যের আরও বিবরণ।
          </td>
          <td colspan="2"></td>
        </tr>
      </table>
      <div>
        <br />
        <br />
        <span>
            ' . $distric_name->district_name_bn . '
        </span>
        <hr />
        <br />
        <span>আমি এই সার্টিফিকেট দিতেছি যে পূর্ব পৃষ্ঠায় উল্লিখিত টাকা সার্টিফিকেটমত খাতক (গণ) হইতে সার্টিফিকেটধারীর প্রাপ্য ও ন্যায়মতে আদায়যোগ্য এবং মোকদ্দমা করিয়া আদায় সম্বন্ধে আইনমতে বাধা নাই।
        </span>
        <p style="margin: 10px 0;">তারিখ অদ্য ' . $appealBanglaYear . ' সালের ' . $appealBanglaMonth . ' মাসের ' . $appealBanglaDay . ' দিবস।</p>
        <div style="padding-top: 20px;padding-bottom: 50px">
    <span style="float: right">
     <p style=" text-align : center; color: blueviolet;">
             <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
             
             <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
         সার্টিফিকেট   অফিসার <br>
     </p>
    ' .
            $location .
            ', '  .
            '
 </span>
    </div>
      </div>
    </div>';
        // dd($template);
        return $template;
    }
    //---------------------------------সার্টিফিকেট  খাতকের প্রতি W/A ইস্যু করা হোক  ------------------------------------------------
    public static function getDefaulterJailWarrentShortOrderTemplate($appealInfo, $requestInfo)
    {
        $offender = $appealInfo['defaulterCitizen'];
        $lawSection = DataConversionService::toBangla($appealInfo['appeal']->law_section);
        $appealBanglaDay = DataConversionService::toBangla(date('d', strtotime($appealInfo['appeal']->created_at)));
        $appealBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($appealInfo['appeal']->created_at)));
        $appealBanglaYear = DataConversionService::toBangla(date('Y', strtotime($appealInfo['appeal']->created_at)));

        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);

        $trialBanglaYear = DataConversionService::toBangla(date('Y', strtotime($modified_conduct_date)));
        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));

        $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);

        $office_info = get_office_by_id(globalUserInfo()->office_id);
        //$office_name=
        $distric_name = DB::table('district')
            ->where('id', '=', $office_info->district_id)
            ->first();
        $location = $office_info->office_name_bn;

        $template =
            '<style>
                td{
                    padding-top: 10px;
                    padding-bottom: 10px;
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
        <p class="text-center">যেহেতু বাংলাদেশের রাজকীয় প্রাপ্য আদায় বিষয়ক ১৯১৩ সালের আইনের ' .
            $lawSection .
            ' ধারানুসারে</p>
        <div style="padding-top: 20px">
            <table width="100%" class="table">
                <tr>
                    <td width="10%" style="border: 1px solid black">
                        <p style="padding-top: 20px">মূল্য দাবী...</p>
                        <p>সুদ.........</p>

                    </td>
                    <td width="10%" style="border: 1px solid black">টাকা </br> ' .
            $loanAmountBng .
            '</td>
                    <td width="10%" style="border: 1px solid black">পঃ </td>
                    <td width="50%" rowspan="2">
                        <div style="text-align: justify;">
                            সার্টিফিকেট  খাতক
                            জনাব ' .
            $offender->citizen_name .
            ' এর বিরুদ্ধে ' .
            $appealBanglaYear .
            ' সালের ' .
            $appealBanlaMonth .
            ' মাসের ' .
            $appealBanglaDay .
            ' দিবসে
                            ' .
            $appealInfo['appeal']->case_no . '</br>' .'ম্যানুয়াল মামলা নংঃ ' . $appealInfo['appeal']->newCaseNo .
            '  নম্বরে<span style="padding-left: 40px">এক </span> সার্টিফিকেট এই অফিসে গাঁথিয়া রাখা
                            হইয়াছে, এবং পার্শ্বে লিখিত টাকা তাহার নিকট হইতে উক্ত
                            সার্টিফিকেট বাবদ প্রাপ্য, এবং যেহেতু উক্ত সার্টিফিকেটের দাবী
                            পরিশোধ কল্পে সার্টিফিকেটধারীকে উক্ত
                            ' .
            $loanAmountBng .
            ' টাকা প্রদত্ত করা হয় নাই।

                        </div>

                        <div style="text-align: justify;">
                            <span style="padding-left: 40px">অতএব,</span> এতদ্বারা আপনাকে আদেশ করা যাইতেছে যে,
                            আপনি উক্ত সার্টিফিকেটমত খাতককে গ্রেফতার করিবেন,এবং
                            সার্টিফিকেটমত খাতক এই পরোয়ানা জারীর খরচ বাবদ ' .
            $loanAmountBng .
            '
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
            <span style="padding-left: 40px"> আপনাকে </span> আরও আদেশ করা যাইতেছে যে, আপনি ' .
            $trialBanglaYear .
            ' সালের ' .
            $trialBanlaMonth .
            ' মাসের ' .
            $trialBanglaDay .
            ' দিবসে বা তৎপূর্বে যে দিবসে ও যে প্রকারে এই ওয়ারেন্ট জারি করা হইয়াছে অথবা উহা জারি না হইবার কারণ বিজ্ঞাপক পৃষ্ঠালিপিসহ উহা ফিরাইয়া দিবেন।
        </div>
        <div style="padding-top: 20px">
            <span style="padding-left: 40px"> তারিখ অদ্য ' .
            $trialBanglaYear .
            ' সালের ' .
            $trialBanlaMonth .
            ' মাসের ' .
            $trialBanglaDay .
            ' দিবসে।
        </div>
        <div style="padding-top: 20px;padding-bottom: 100px">
            <span style="float: right">
                <p style=" text-align : center; color: blueviolet;">
                        <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
                        
                        <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
                    সার্টিফিকেট   অফিসার <br>
                </p>
               ' .
            $location .
            ', ' .
            $distric_name->district_name_bn .
            '
            </span>
        </div>
    </div>';
        return $template;
    }
    //---------------------------------------ক্রোক---------------------------------//
    public static function generateCrokeTemplate($appealInfo, $requestInfo)

    {
        // dd($requestInfo->interestRate, $appealInfo['appeal']);
        $offender = $appealInfo['defaulterCitizen'];
        $lawSection = DataConversionService::toBangla($appealInfo['appeal']->law_section);
        $appealBanglaDay = DataConversionService::toBangla(date('d', strtotime($appealInfo['appeal']->created_at)));
        $appealBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($appealInfo['appeal']->created_at)));
        $appealBanglaYear = DataConversionService::toBangla(date('Y', strtotime($appealInfo['appeal']->created_at)));

        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);

        $trialBanglaYear = DataConversionService::toBangla(date('Y', strtotime($modified_conduct_date)));
        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));

        $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $amount_to_pay_as_remaining_bng = DataConversionService::toBangla($requestInfo->amount_to_pay_as_remaining);
        $interest_rate = $requestInfo->interestRate;
        $amount_to_pay_as_costing_bng = DataConversionService::toBangla($requestInfo->amount_to_pay_as_costing);
        $total_jari_bng = DataConversionService::toBangla($requestInfo->total_jari);
        $interestAmount = (int)$requestInfo->amount_to_pay_as_remaining * (int) $interest_rate / 100;
        $interestAmountBng = DataConversionService::toBangla($interestAmount);
        // dd($interestAmount, $amount_to_pay_as_remaining_bng, $amount_to_pay_as_costing_bng, $total_jari_bng);exit;
        $office_info = get_office_by_id(globalUserInfo()->office_id);
        //$office_name=
        $distric_name = DB::table('district')
            ->where('id', '=', $office_info->district_id)
            ->first();
        $location = $office_info->office_name_bn;

        $template =
            '<div id="crimieDescription" class="arrest-warrant">
            <header>
            <div style="display: flex; justify-content: space-between">
            <p>বাংলাদেশ ফরম নং ১১৭৭</p>
            <p>(পরিশিষ্টের ফরম নং- ১১ক)</p>
          </div>
                <div style="text-align: center">
                    <h3>অস্থাবর সম্পত্তি ক্রোকের পরোয়ানা</h3>
                    <h4>(১৩ ও ১৪ ধারা দ্রষ্টব্য)</h4>
                </div>
            </header>
            <div class="all_content">
            <p>প্রাপকঃ .................</p>
            <p>যেহেতু বাংলাদেশের রাজকীয় প্রাপ্য আদায় বিষয়ক ১৯১৩ সালের আইনের ' .
            $lawSection .
            ' ধারানুসারে</p>
                <div style="text-align: justify; margin-bottom: 8px;">
                    সার্টিফিকেট খাতক
                    জনাব ' .
            $offender->citizen_name .
            ' এর বিরুদ্ধে ' .
            $appealBanglaYear .
            ' সালের ' .
            $appealBanlaMonth .
            ' মাসের ' .
            $appealBanglaDay .
            ' দিবসে
                    ' .
            $appealInfo['appeal']->case_no . '</br>' .'ম্যানুয়াল মামলা নংঃ ' . $appealInfo['appeal']->newCaseNo .
            '  নম্বরে এক সার্টিফিকেট এই অফিসে গাঁথিয়া রাখা 
                    হইয়াছে, এবং পার্শ্বে লিখিত টাকা তাহার নিকট হইতে উক্ত
                    সার্টিফিকেট বাবদ প্রাপ্য, এবং যেহেতু উক্ত সার্টিফিকেটের দাবী
                    পরিশোধ কল্পে সার্টিফিকেটধারীকে উক্ত  ' .
            $loanAmountBng .
            ' টাকা প্রদত্ত করা হয় নাই।
    
                </div>
    
                <div style="text-align: justify; margin-bottom: 8px;">
                    <span>অতএব,</span> এতদ্বারা আপনাকে আদেশ করা যাইতেছে যে,
                     আপনি উক্ত সার্টিফিকেটমত খাতকের অস্থাবর সম্পত্তি ক্রোক
                     করিবেন, এবং সার্টিফিকেটমত খাতক আপনাকে উক্ত
                     টাকা, যা এই পরোয়ানা জারীর খরচ বাবদ ' .
            $loanAmountBng .
            '
                    টাকা না দিলে আপনি এই আদালত হইতে অন্য কোন হুকুম না পাওয়া পর্যন্ত উহা ক্রোক রাখিবেন।
                </div>
                <div>
                    <span > আপনাকে </span> আরও আদেশ করা যাইতেছে যে, যে তারিখে ও যে প্রকারে এই পরোয়ানা জারী করা হয় অথবা উহা জারী না হইয়া থাকিলে কি কারণে জারী হয় নাই তাহা উহার পৃষ্ঠে লিখিয়া ' .
            $trialBanglaYear .
            ' সালের ' .
            $trialBanlaMonth .
            ' মাসের ' .
            $trialBanglaDay .
            ' দিবসে অথবা তৎপূর্বে এই পরোয়ানা ফেরত দিবেন।
                </div>
                
                <div style="padding-top: 20px; width: 100%;" >
                <table style="width: 50%; margin: auto;" class="table">
                    <tr>
                        <td width="10%" style="border: 1px solid black">
                            <p>শিরোনাম</p>
                        </td>
                        <td width="10%" style="border: 1px solid black">টাকা </td>
                        <td width="10%" style="border: 1px solid black">পঃ </td>
                       <!-- -->
                    </tr>
                    <tr>
                        <td width="10%" style="border: 1px solid black">
                            <p style="padding-top: 20px">মূল দাবী: </p>
                            <p>সুদ:</p>
                        </td>
                        <td width="10%" style="border: 1px solid black">
                            <p style="padding-top: 20px">' . $loanAmountBng . ' </p>
                            <p>' . $interestAmountBng . '</p>
                        </td>
                        <td width="10%" style="border: 1px solid black"> </td>
                       <!-- -->
                    </tr>
                    <tr>
                        <td width="10%" style="border: 1px solid black">
    
                            <p>খরচ: </p>
                            <p>জারী: </p>
                            <p> মোট: </p>
                        </td>
                        <td width="10%" style="border: 1px solid black">
                            <p>' . $amount_to_pay_as_costing_bng . ' </p>
                            <p> .................. </p>
                            <p> ' . $total_jari_bng . ' </p>
                        </td>
                        <td width="10%" style="border: 1px solid black"></td>
                    </tr>
                </table>
            </div>
            <div style="padding-top: 20px">
                    <span> তারিখঃ অদ্য ' .
            $trialBanglaYear .
            ' সালের ' .
            $trialBanlaMonth .
            ' মাসের ' .
            $trialBanglaDay .
            ' দিবসে।
                </div>
            <div style="padding-top: 20px;">
                <span style="float: right">
                   <p style=" text-align : center; color: blueviolet;">
                            <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
                            
                            <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
                        সার্টিফিকেট   অফিসার <br>
                    </p>
                    ' .
            $location .
            ', ' .
            '
                </span>
            </div>
            
        </div>
    
    </div>
';
        return $template;
    }
    //---------------------------------------৭৭ মোতাবেক কারণ দর্শানো নোটিশ জারী---------------------------------//
    /* 
 <p style="text-align: center;border-top: 1px solid #0d0808">
            *যে স্থলে অস্থাবর সম্পত্তির কতক অংশ মাত্র ক্রোক করিবার হুকুম হয় সে স্থলে এখানে “টাকা মূল্যের” এই কথাগুলি যোগ করিয়া দিতে হইবে।
         </p>
         <div>
                 <p style="text-align: center;border-top: 1px solid #0d0808">
                    *যে স্থলে অস্থাবর সম্পত্তির কতক অংশ মাত্র ক্রোক করিবার হুকুম হয় সে স্থলে এখানে “টাকা মূল্যের” এই কথাগুলি যোগ করিয়া দিতে হইবে।
                 </p>
                </div>

*/
    public static function getSeventySevenShortOrderTemplate($appealInfo, $requestInfo)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $location = $office_name->office_name_bn;
        //$loanMoney=DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        //$offenderAddress=$offender->present_address;
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;
        $applicant_name = $appealInfo['applicantCitizen'][0]->citizen_name;
        $modified_trial_date = date_formater_helpers_make_bd($requestInfo->trialDate);
        $defaulter = $appealInfo['defaulterCitizen'];
        $office_info = get_office_by_id(globalUserInfo()->office_id);
        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);
        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($modified_conduct_date)));
        $distric_name = DB::table('district')
            ->where('id', '=', $office_info->district_id)
            ->first();

        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $template =
            '<div id="crimieDescription" class="arrest-warrant">
        <header>
        <div style="display: flex; justify-content: space-between">
        <p>বাংলাদেশ ফরম নং- ১০</p>
        <p>(পরিশিষ্টের ফরম নং- ৩০)</p>
      </div>
            <div style="text-align: center">
                <h3>গ্রেফতারী পরোয়ানা কেন ইস্যু করা হইবে না <br> তাহার কারণ দর্শাইবার নোটিশ </h3>
                <h4>
                    ( বিধি - ৭৭ দ্রষ্টব্য )
                </h4>
            </div>
        </header>
        <br>
        <div>
            
            <div>প্রাপক: ' . $defaulter->citizen_name . '</div>
            <div style="text-align: justify;line-height: 30px;">
                যেহেতু জনাব ' .
            $applicant_name .
            ', উক্ত সার্টিফিকেট কেস নং . ' .
            $case_in_text .
            '
                কার্যকরী করার জন্য আপনাকে গ্রেফতার এবং আটক করার জন্য আবেদন করিয়াছেন ,
                অতএব আপনাকে জেলে আমার সম্মুখে ' .
            en2bn($modified_trial_date) .
            '
                তারিখে হাজির হইয়া উক্ত সার্টিফিকেট  কেন কার্যকরী করার জন্য কেন আপনাকে সিভিল জেলে সোপর্দ করা হইবেনা
                তা কারণ দর্শাইতে হইবে।
            </div>
           
        </div>
        <div style="padding-top: 20px;">
 <span style="float: right">
     <p style=" text-align : center; color: blueviolet;">
             <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
             
             <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
         সার্টিফিকেট   অফিসার <br>
     </p>
    ' .
            $location .
            ', ' .
            '
 </span>
</div>

        <div>
           <p> কোর্টের সিল দেওয়া হলো</p>
           <p> তারিখ: ' . $trialBanglaDate . '</p>
        </div>
        </div>';
        return $template;
    }
    //---------------------------------------২৯ ধারার নোটিশ (গ্রেফতারী পরোয়ানা) ---------------------------------//
    public static function getTwentyNineShortOrderTemplate($appealInfo, $requestInfo)
    {
        // dd($requestInfo->warrantExecutorName);
        // exit;
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $location = $office_name->office_name_bn;
        //$loanMoney=DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        //$offenderAddress=$offender->present_address;
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;
        $interest_amount = (int) $requestInfo->amount_to_pay_as_remaining * (int) $requestInfo->interestRate / 100;
        // dd($interest_amount, $requestInfo->amount_to_pay_as_remaining, $requestInfo); exit;
        $applicant_name = $appealInfo['applicantCitizen'][0]->citizen_name;
        $modified_created_date = date_formater_helpers_make_bd_v2(explode(' ', $appealInfo['appeal']->created_at)[0]);
        $conduct_date_modify_array = explode('-', date_formater_helpers_v2($requestInfo->conductDate));
        $conduct_date_modify_string = $conduct_date_modify_array[2] . '/' . $conduct_date_modify_array[1] . '/' . $conduct_date_modify_array[0];

        $total_amt = $requestInfo->main_amount_29_dhara + $requestInfo->interest_29_dhara + $requestInfo->costing_29_dhara + $requestInfo->working_amount_29_dhara;
        if ($requestInfo->working_amount_29_dhara) {
            $total_jari = round($requestInfo->total_jari + $requestInfo->working_amount_29_dhara, 2);
        } else {
            $total_jari = round($requestInfo->total_jari, 2);
        }


        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $template =
            '<div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">
                <h3>ফর্ম নং- ৮</h3>
                <h3>(বাংলাদেশ ফর্ম নং ১০৩৪)</h3>
                <h3>গ্রেফতারী পরোয়ানা (২৯ ধারা দ্রষ্টব্য)</h3>
            </div>
        </header>
        <br>
        <div>
            <div>
                <p style="text-align: justify;line-height: 30px;"> 
                প্রাপক: <br>
                ' . $requestInfo->warrantExecutorName . '
               </p>
            </div>
            <div style="text-align: justify;line-height: 30px;">
            যেহেতু  সার্টিফিকেট নং ' . $case_in_text . ' তারিখ ' . en2bn($modified_created_date) . ' সরকারি বকেয়া পাওনা আদায় আইন ১৯১৩ এর ৫ ধারা মোতাবেক দায়ের করা হয়েছিল সার্টিফিকেট  দেনাদার জনাব ' . $offender->citizen_name . ' এর বিরুদ্ধে এবং নিম্নে বর্ণিত ' . $total_amt . ' টাকা উক্ত সার্টিফিকেট বাবদ তাহার নিকট প্রাপ্যঃ
            <table style="width: 80%">
                        <tr>
                            <th width="10%" style="text-align: justify">মুল দাবি</th>
                            <th width="30%" style="text-align: justify">' . en2bn($requestInfo->amount_to_pay_as_remaining) . ' টাকা</th>
                        </tr>
                        <tr>
                        <th width="10%" style="text-align: justify">সুদ</th>
                            <th width="30%" style="text-align: justify">' . en2bn($interest_amount) . ' টাকা</th>
                        </tr>
                        <tr>
                        <th width="10%" style="text-align: justify">খরচ</th>
                            <th width="30%" style="text-align: justify">' . en2bn($requestInfo->amount_to_pay_as_costing) . '  টাকা</th>
                        </tr>
                        <tr>
                        <th width="10%" style="text-align: justify">কার্যকরীকরন</th>
                            <th width="30%" style="text-align: justify">' . en2bn($requestInfo->working_amount_29_dhara) . ' টাকা</th>
                        </tr>
                        <th width="10%" style="text-align: justify">মোট</th>
                            <th width="30%" style="text-align: justify">' . en2bn($total_jari) . ' টাকা</th>
                        </tr>
             </table>
             এবং যেহেতু উক্ত ' . en2bn($total_jari) . ' টাকা সার্টিফিকেট দাবিদারের নিকট উক্ত সার্টিফিকেটের দাবি মিটাইবার জন্য পরিশোধ করা হয় নাই।
             উক্ত সার্টিফিকেট  দেনাদারকে গ্রেফতার করে এবং যতক্ষণ পর্যন্ত উক্ত সার্টিফিকেট  দেনাদার আপনার নিকট ' . en2bn($total_jari) . '  টাকা এই প্রসেস  কার্যকরী করার খরচসহ প্রদান না করে , তাকে দ্রুত কোর্টে হাজির করার আদেশ দেওয়া হইতেছে। আপনাকে পরোয়ানা ' . en2bn($requestInfo->trialDate) . ' তারিখ বা তার পূর্বে কিভাবে ইহা কার্যকরী করা হয়েছে অথবা কি কারনে ইহা কার্যকরী করা হয়নাই তার পৃষ্ঠাংকন ফেরত দেয়ার জন্য আরও আদেশ দেওয়া হইতেছে। 
            </div>
            <div>
                <span style="">আমার স্বাক্ষর ও আদালতের মোহর যুক্ত মতে দেওয়া গেল। </span>
                
            </div>
        </div>
        <div style="text-align: left; margin-top: 50px;">
            <span style="">তারিখঃ ' . en2bn($conduct_date_modify_string) . '</span>
        </div>
        <div style="padding-top: 20px;padding-bottom:30px">
    <span style="float: right">
     <p style=" text-align : center; color: blueviolet;">
             <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
             
             <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
         সার্টিফিকেট   অফিসার <br>
     </p>
    ' .
            $location .
            ', '  .
            '
 </span>
    </div>
    </div>';

        // dd($template);exit;
        return $template;
    }

    //--------------------------------------- দেনাদারকে সিভিল জেলে সোপর্দ ---------------------------------//
    public static function getSentToCivilCourtTemplate($appealInfo, $requestInfo)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $location = $office_name->office_name_bn;
        //$loanMoney=DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        //$offenderAddress=$offender->present_address;
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;
        $applicant_name = $appealInfo['applicantCitizen'][0]->citizen_name;
        $modified_created_date = date_formater_helpers_make_bd_v2(explode(' ', $appealInfo['appeal']->created_at)[0]);
        $conduct_date_modify_array = explode('-', date_formater_helpers_v2($requestInfo->conductDate));
        $conduct_date_modify_string = $conduct_date_modify_array[2] . '/' . $conduct_date_modify_array[1] . '/' . $conduct_date_modify_array[0];

        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }
        $amount_to_deposite = $requestInfo->amount_to_deposite;
        $days_in_court = $requestInfo->days_in_court;
        $daily_cost_ta_da = $requestInfo->daily_cost_ta_da;

        $template =
            '<div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">
                <h3>সার্টিফিকেট দেনাদারকে সিভিল জেলে সোপর্দ করার আদেশ</h3>
                <h4>
                    ( বিধি - ২৯ দ্রষ্টব্য )
                </h4>
            </div>
        </header>
        <br>
        <div>
            <div>
            <p style="text-align: justify;line-height: 30px;"> 
            প্রাপক: ' . $requestInfo->warrantExecutorName . '<br>
            ভারপাপ্ত কর্মকর্তা,<br>সিভিল জেল
           </p>
            </div>
            <div style="text-align: justify;line-height: 30px;">
            যেহেতু জনাব ' . $offender->citizen_name . ' যাকে আমার সন্মুখে আজ ' . en2bn($conduct_date_modify_string) . ' তারিখে আনায়ন করা হয়েছে অত্র অফিসে
            দায়েরকৃত ' . $case_in_text . '  নং সার্টিফিকেট কেসে ১৯১৩ সালের সরকারি বকেয়া পাওনা আদায় আইনের ৫ ধারার অধীনে এবং সে সার্টিফিকেট আদেশ দেয়া 
            হয়েছিল যে ' . en2bn($amount_to_deposite) . ' টাকা পরিশোধ করবেন ।
            <br>
            
            যেহেতু উক্ত ' . en2bn($amount_to_deposite) . ' টাকা পরিশোধ করেন নাই অথবা তিনি আমাকে এই মর্মে সন্তুষ্ট করেন নাই যে তিনি আটক অবস্থা থেকে মুক্তি পেতে পারেন । অতএব আপনাকে আদেশ দেওয়া হইতেছে আপনি উক্ত জনাব ' . $offender->citizen_name . ' সিভিল জেলে গ্রহণ করে অনাধিক
            ' . en2bn($days_in_court) . ' দিন জেলে আটকে অথবা যতদিন না উক্ত সার্টিফিকেট সম্পূর্ণরুপে পরিশোধ অথবা উক্ত আইনের ৩১ অথবা ৩২ ধারার শর্ত মোতাবেক
            মুক্তি পাওয়া অধিকার হয় এবং আমি এতদ্বারা ' . en2bn($daily_cost_ta_da) . ' টাকা হারে দৈনিক ভাতা নির্ধারণ করিলাম তার মাসিক খোরপোষ ভাতা এবং এই আদেশে আটক থাকার সময়ের জন্য । 
            
            </div>
        </div>
        <div style="text-align: left">
            <span style="">তারিখঃ ' . en2bn($conduct_date_modify_string) . '</span>
        </div>
        <div style="text-align: right">
            <span> সার্টিফিকেট অফিসার </span><br>
            ' .
            $location .
            '
        </div>
    </div>';

        return $template;
    }

    //--------------------------------------- সার্টিফিকেট কার্যকরী করার উদ্দেশ্যে জেলে আটক বাক্তিকে মুক্তি করার আদেশ ---------------------------------//
    public static function getReleasePerson($appealInfo, $requestInfo)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $location = $office_name->office_name_bn;
        //$loanMoney=DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        //$offenderAddress=$offender->present_address;
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;
        $applicant_name = $appealInfo['applicantCitizen'][0]->citizen_name;
        $modified_created_date = date_formater_helpers_make_bd_v2(explode(' ', $appealInfo['appeal']->created_at)[0]);
        $conduct_date_modify_array = explode('-', date_formater_helpers_v2($requestInfo->conductDate));
        $conduct_date_modify_string = $conduct_date_modify_array[2] . '/' . $conduct_date_modify_array[1] . '/' . $conduct_date_modify_array[0];

        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }


        $template =
            '<div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">
                <h3>সার্টিফিকেট কার্যকরী করার উদ্দেশ্যে জেলে আটক বাক্তিকে মুক্তি করার আদেশ</h3>
                <h4>
                    ( ধারা ৩১ এবং ৩২ দ্রষ্টব্য )
                </h4>
            </div>
        </header>
        <br>
        <div>
            <div>
            <p style="text-align: justify;line-height: 30px;"> 
            প্রাপক: ' . $requestInfo->warrantExecutorName . '<br>
            ভারপাপ্ত কর্মকর্তা, সিভিল জেল
           </p>
            </div>
            <div style="text-align: justify;line-height: 30px;">
            এতদ্বারা আজকের আদেশ মোতাবেক আপনার জিম্মায় আটক সার্টিফিকেট দেনাদার জনাব ' . $offender->citizen_name . 'কে মুক্ত করার নির্দেশ দেওয়া হইলো ।
            
            </div>
            <div>
                <span style="">আমার স্বাক্ষর ও আদালতের মোহর যুক্ত মতে দেওয়া গেল। </span>
                
            </div>
        </div>
        <div style="text-align: left">
            <span style="">তারিখঃ ' . en2bn($conduct_date_modify_string) . '</span>
        </div>
        <div style="text-align: right">
            <span> সার্টিফিকেট অফিসার </span><br>
            ' .
            $location .
            '
        </div>
    </div>';
        return $template;
    }



    /****************************/
    public static function getCertificateRequestShortOrderTemplate($appealInfo, $causeList)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $location = $office_name->office_name_bn;
        $defaulter = $appealInfo['defaulterCitizen'];
        $guarantorCitizen = $appealInfo['guarantorCitizen'];
        // dd($appealInfo);
        $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));
        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($causeList->conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($causeList->conduct_date)));
        $trialTime = date('h:i:s a', strtotime($causeList->conduct_time));
        $trialBanglaYear = DataConversionService::toBangla(date('Y', strtotime($causeList->conduct_date)));

        $template =
            '
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
             <span style="float: right; font-size: medium">' .
            Session::get('districtName') .
            ' সার্টিফিকেট অফিসার মহাশয় বরাবরেষু</span>
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
                        <td>১ । ঋণ গ্রহীতা - ' .
            $defaulter->citizen_name .
            ', পিতা -' .
            $defaulter->father .
            ' ,মাতা -' .
            $defaulter->mother .
            '</td>
                        <td>ব্যবসায়িক ঠিকানা - ' .
            $defaulter->present_address .
            '  ,স্থায়ী ঠিকানা - ' .
            $defaulter->permanent_address .
            '</td>
                        <td>' .
            $loanAmountBng .
            ' টাকা </td>
                        <td>0</td>
                        <td></td>
                    </tr>
                    <tr style="word-spacing: 4px;text-align: justify;">
                        <td>গ্যারান্টর -' .
            ($guarantorCitizen != null ? $guarantorCitizen->citizen_name : '') .
            ', পিতা -' .
            ($guarantorCitizen != null ? $guarantorCitizen->father : '') .
            ' ,মাতা -' .
            ($guarantorCitizen != null ? $guarantorCitizen->mother : '') .
            '</td>
                        <td>ব্যবসায়িক ঠিকানা -' .
            $defaulter->present_address .
            '</td>
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
                    ' .
            $trialBanglaYear .
            ' সালের ' .
            $trialBanlaMonth .
            ' মাসের ' .
            $trialBanglaDay .
            ' তারিখে সত্য পাঠযুক্ত করা গেল ।


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

    //---------------------------------সার্টিফিকেট  রাজকীয় প্রাপ্য  আইনের ৭৭ ধারা। ------------------------------------------------
    public static function getRajokioPrappoAinerDharaShortOrderTemplate($appealInfo, $causeList)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $location = $office_name->office_name_bn;
        $loanMoney = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        $offenderAddress = $offender->present_address;

        $template =
            '<div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">
                <h3>গ্রেফতারী পরোয়ানা কেন বাহির করা হইবে না <br> তাহার কারণ দর্শাইবার নোটিশ </h3>
                <h4>
                    ( রাজকীয় প্রাপ্য আইনের ৭৭ ধারা )
                </h4>
            </div>
        </header>
        <div>
            <p style="text-align: right">সার্টিফিকেট মোকদ্দমা নং ' .
            $appealInfo['appeal']->case_no . '</br>' .'ম্যানুয়াল মামলা নংঃ ' . $appealInfo['appeal']->newCaseNo .
            '</p>
        </div>
        <br>
        <div>
            <div>
                <p style="text-align: justify;line-height: 30px;"> প্রতি (খাতক): ' .
            $offender->citizen_name .
            ' পিতার নাম: ' .
            $offender->father .
            ' ঠিকানা: ' .
            $offender->present_address .
            ' </p>
            </div>
            <div style="text-align: justify;line-height: 30px;">
                <span style="margin-left: 30px">আপনাকে জানানো যাচ্ছে যে, </span>উক্ত সার্টিফিকেট মোকদ্দমার ' .
            $loanMoney .
            '
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
            ' .
            $location .
            '
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
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $location = $office_name->office_name_bn;
        $loanMoney = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        $offenderAddress = $offender->present_address;
        $currentBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));

        $template =
            '<div style="padding-top: 5%;">
            <div style="text-align: center">
                 <span>
                 গণপ্রজাতন্ত্রী বাংলাদেশ সরকার </br>
                ' .
            $location .
            '</br>
                 ( জেনারেল সার্টিফিকেট আদালত )</br>
                </span>
            </div></br>

            <div>
                <span>
                     স্বারক  সংখ্যাঃ  ৩৬৯  জি সি ও
                </span>
                <span style="float: right">
                     তারিখঃ ' .
            $currentBanglaDate .
            '
                </span>
            </div></br>
            <div>
                বিষয় : সার্টিফিকেট মামলা নং - ' .
            $appealInfo['appeal']->case_no . '</br>' .'ম্যানুয়াল মামলা নংঃ ' . $appealInfo['appeal']->newCaseNo .
            '  এর  খাতক ' .
            $offender->citizen_name .
            '  পিতা /স্বামী ' .
            $offender->father .
            ' ঠিকানা ' .
            $offenderAddress .
            ' এর বিরুদ্ধে জারীর জন্য প্রেরিত গ্রেফতারী/ক্রোকী পরোয়ানা রি-কল প্রদান প্রসঙ্গে ।
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
                    ' .
            $location .
            '</td> </tr>
            </table></div>

    </div>';

        return $template;
    }

    //---------------------------------মামলার প্রত্যহার------------------------------------------------
    public static function getCaseRejectionApplicationShortOrderTemplate($appealInfo, $causeList)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
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

        $loanMoney = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        $offenderAddress = $offender->present_address;
        $currentBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));

        $template =
            '<div style="padding-top: 5%;">
        <span>
        বরাবর ' .
            $unoHeader .
            '
        জেনারেল সার্টিফিকেট অফিসার</br>
        ' .
            $location .
            '।</br>
        </br>
        বিষয় : সার্টিফিকেট মামলা নং - ' .
            $appealInfo['appeal']->case_no . '</br>' .'ম্যানুয়াল মামলা নংঃ ' . $appealInfo['appeal']->newCaseNo .
            ' প্রত্যাহার</br>
        </br>
        মহোদয়,</br>
        </span>
        <span style=";">সবিনয়ে জানাচ্ছি যে,</span> <span>
        উপজেলা পরিষদের বকেয়া টাকা আদায়ের লক্ষে আপনার আদালতে সার্টিফিকেট মামলা দায়ের করা হল।
        দায়েরকৃত ' .
            $appealInfo['appeal']->case_no . '</br>' .'ম্যানুয়াল মামলা নংঃ ' . $appealInfo['appeal']->newCaseNo .
            ' নং মামলার খাতক ' .
            $offender->citizen_name .
            ', পিতা-' .
            $offender->father .
            ', ' .
            $offenderAddress .
            '
        দাবীকৃত ' .
            $loanMoney .
            ' টাকা উপজেলা হাটবাজার হিশাব নং - ____________ তে জমা করে জমা স্লিপ নিম্ন স্বাক্ষরকারীর
        নিকট দাখিল করেছেন।
        </span></br>
        </br>
        <span style=";">এমতাবস্থায়,</span> <span>
        বর্ণিত মামলাটি প্রত্যাহারের প্রয়োজনীয় ব্যবস্থা গ্রহণের জন্য সবিনয়ে অনুরোধ করছি।</br>
        সংযুক্ত : জমা স্লিপ-০১ প্রস্থ।
        </span></br>
               </br>
        তারিখ : ' .
            $currentBanglaDate .
            '</br>
        <div style="float: right">
            <span style="margin-left: 20px">নিবেদক-</span></br>
            ' .
            $UpazilaPorishoderPhokhe .
            '
            ' .
            $appealInfo['appeal']->gco_name .
            '</br>
             জেনারেল সার্টিফিকেট অফিসার</br>
            ' .
            $appealInfo['appeal']->office_name .
            '</br>
        </div>
        </br>
        <span>
        দেখলাম</br>
        </br>
        জেনারেল সার্টিফিকেট অফিসার</br>
        ' .
            $unoHeader .
            '
        ' .
            $location .
            '</br>
        </span>

    </div>';
        //dd($template);
        return $template;
    }

    //---------------------------------------ক্রোক---------------------------------//

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
        $trialBanglaYear = DataConversionService::toBangla(date('Y', strtotime($causeList->conduct_date)));

        $appealBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($appeal->case_date)));
        $appealBanglaDay = DataConversionService::toBangla(date('d', strtotime($appeal->case_date)));
        $appealBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($appeal->case_date)));
        $appealBanglaYear = DataConversionService::toBangla(date('Y', strtotime($appeal->case_date)));

        $template =
            '<div style="font-size: medium;padding-top: 5%;">
                        <header>
                            <div style="text-align: center">
                                <h4>" কেন গ্রেফতারী পরোয়ানা ইস্যু করা হইবে না তাহার কারণ দর্শানোর নোটিশ "
                                <br>
                                 (বিধি  -৭৭ )</h4>
                                <br>

                            </div>
                        </header>
                        <div>
                             <p> প্রতি : জনাব  ' .
            $defaulter->citizen_name .
            ' পিতা ' .
            $defaulter->father .
            ' </p>

                                <p>সাং ............. পো : ................... উপজেলা ................</p>
                                <p> জেলা ................................ ।</p>
                            <p>
                                &emsp; যেহেতু ১৯৯৩ সালের পাবলিক ডিমান্ড রিকভারি এক্টের ৪/৬ ধারা অনুসারে আপনার বিরুদ্ধে ' .
            $appeal->case_no .
            ' নম্বরের এক সার্টিফিকেট ' .
            $appealBanglaYear .
            ' সালের ' .
            $appealBanlaMonth .
            ' মাসের ' .
            $appealBanglaDay .
            ' দিবসে এই অফিসে গাথিয়া রাখা হইয়াছে এবং যেহেতু আপনি দাবীকৃত অর্থ পরিশোধ করেন নাই সেহেতু আপনি আগামী ' .
            $trialBanglaDate .
            ' খ্রি  তারিখ আমার সম্মুখে হাজির হইয়া কেন আপনাকে দেওয়ানী কারাগারে সোপর্দ করা হইবে না তাহার কারণ দর্শাইবেন ।

                            </p>
                            <br>
                                
                                <br><br>
                                <p align="right">
                                    <p style=" text-align : center; color: blueviolet;">
                                            <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
                                            
                                            <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
                                        সার্টিফিকেট   অফিসার <br>
                                    </p>
                                    জেলা প্রশাসকের কার্যালয়, ' .
            user_district_name() .
            '
                                   
                                </p>

                        </div>
                 </div>';

        return $template;
    }



    //  নিলাম ইস্তেহার
    public static function getAuctionNoticeShortOrderTemplate($appealInfo, $requestInfo)
    {

        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        dd($appealInfo);
        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);
        $defaulter_name = $appealInfo['defaulterCitizen']->citizen_name;
        $applicant_name = $appealInfo['applicantCitizen'][0]->citizen_name;
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;
        $location = $office_name->office_name_bn;

        /* dd('nilam info', $applicant_name, $defaulter_name, );
        exit; */
        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $case_data_mapping = DB::table('gcc_appeals')
            ->join('office', 'gcc_appeals.office_id', 'office.id')
            ->join('district', 'gcc_appeals.district_id', 'district.id')
            ->where('gcc_appeals.id', $requestInfo->appealId)
            ->select('gcc_appeals.loan_amount_text', 'gcc_appeals.loan_amount', 'office.office_name_bn', 'office.organization_physical_address', 'district.district_name_bn')
            ->first();
        $amount_to_pay_as_remaining = $requestInfo->amount_to_pay_as_remaining;
        $amount_to_pay_as_costing = $requestInfo->amount_to_pay_as_costing;

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($modified_conduct_date)));

        $appealBanglaDay = DataConversionService::toBangla(date('d', strtotime($appealInfo['appeal']->created_at)));
        $appealBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($appealInfo['appeal']->created_at)));
        $appealBanglaYear = DataConversionService::toBangla(date('Y', strtotime($appealInfo['appeal']->created_at)));

        $template = '
        
        <div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">
                <h3>ফর্ম নং- ২১</h3>
                <h3>(বাংলাদেশ ফর্ম নং ১০৪১)</h3>
                <h4>নিলাম ইস্তেহার</h4>
                <h4>(বিধি - ৪৬ দ্রষ্টব্য)</h4>
            </div>
        </header>
        <div class="all_content">
            <p>প্ৰাপক :</p>
        <p>সার্টিফিকেট নং ' . $appealInfo['appeal']->case_no . '</br>' .'ম্যানুয়াল মামলা নংঃ ' . $appealInfo['appeal']->newCaseNo . ' এতদ্বারা নোটিস দেয়া যাচ্ছে যে ১৯১৩ সনের সরকারি বকেয়া দাবি আদায় আইনের ২নং তফসিলের ৪৪ বিধি এবং আমার প্রদত্ত আদেশ মোতাবেক সংযুক্ত তফসিলে বর্ণিত সম্পত্তি পার্শ্বে উল্লেখিত সার্টিফিকেট কেসে দাবিদার দাবি হাল নাগাদ খরচ এবং সুদসহ টাকা ' . $requestInfo->loan_amount_with_interest . '. । </p>
            <div style="text-align: justify; margin-bottom: 8px;">সার্টিফিকেট দাবিদার ' . $applicant_name . '।</div>
            <div style="text-align: justify; margin-bottom: 8px;">সার্টিফিকেট দেনাদার ' . $defaulter_name . '।</div>
            <p>নিলাম বিক্রি প্রকাশ্যে অনুষ্ঠিত হবে এবং সম্পত্তি তফসিলের বর্ণনা মোতবেক উপরে বর্ণিত সার্টিফিকেট দেনাদারের নিম্ন তফসিল বর্ণিত সম্পত্তি নিলামে বিক্রি হবে ।</p>
            <p>কোনো স্থগিত আদেশ না হলে নিলাম অনুষ্ঠান করবেন জনাব………।</p>
            <p>মাসিক নিলাম .................. তারিখে .................. সময় .................. স্থান।</p>
            <p>উপরে বর্ণিত ঋণ এবং নিলাম খরচ যদি অর্পন করা হয় অথবা পরিশোধ করা হয় নিলাম অনুষ্ঠানের পূর্বে তাহলে নিলাম অনুষ্ঠান বন্ধ করা হবে । নিলামে সাধারণত জনগণকে ব্যক্তিগতভাবে অথবা ক্ষমতাপ্রাপ্ত এজেন্টের মাধ্যমে অংশ গ্রহণে আহবান জানানো যাচ্ছে। নিম্নে বিস্তারিত শর্ত দেয়া হলো -</p>
            <section>
                <h5 style="font-weight: bold; text-align: center; margin: 20px 0px ;">নিলামের শর্ত</h5>
                <div style="margin-top: 2px; text-align:justify;">১। নিম্ন তফসিল বর্ণিত বিবরণ সার্টিফিকেট অফিসারের নিকট বর্ণনা করা হয়েছে । ইস্তেহারে কোনো ভুল ত্রুটি পরিলক্ষিত হলে তার জন্য সার্টিফিকেট অফিসার জবাবাদিহি করতে বাধ্য নন ।</div>
                <div style="margin-top: 2px; text-align:justify;">২। নিলামের বিড বর্ধিত করণের স্তর সম্পর্কে নিলাম অনুষ্ঠানকারী কর্মকর্তা সিদ্ধান্ত গ্রহণ করবেন । নিলামের অর্থের পরিমাণ সম্পর্কে কোনো মতদ্বৈততা দেখা দিলে ইহা পুনরায় নিলাম ডাকে দেয়া হবে ।</div>
                <div style="margin-top: 2px; text-align:justify;">৩ । সর্বোচ্চ ডাককারীকে, নিলামের ক্রেতা ঘোষণা করা হবে । তবে শর্ত এই যে তাকে বিধি মোতাবেক নিলাম ডাকের যোগ্য হতে হবে এবং আরও শর্ত এই যে নিলাম অনুষ্ঠানকারী কর্মকর্তা স্ববিবেচনায় সর্বোচ্চ ডাককারীকে নিলাম গ্রহণে বিরত রাখতে পারেন যদি উক্ত মূল্য অপর্যাপ্ত হয় ।</div>
                <div style="margin-top: 2px; text-align:justify;">৪। রেকর্ডে কারণ বর্ণনা করে নিলাম অনুষ্ঠানকারী কর্মকর্তা স্ববিবেচনায় ১৯১৩ সনের সরকারি বকেয়া পাওনা আদায় আইনের ২নং তফসিলের ৫০ বিধির শর্ত সাপেক্ষে নিলাম অনুষ্ঠান মুলতবি করতে পারেন।</div>
                <div style="margin-top: 2px; text-align:justify;">৫। অস্থাবর সম্পত্তির ক্ষেত্রে প্রত্যেকটি লটের মূল্য নিলামের সময় অথবা নিলাম অনুষ্ঠানকারী কর্মকর্তা নিলাম শেষ করার পর যেভাবে নির্দেশ দেন এবং মূল্য পরিশোধে ব্যর্থ সম্পত্তি পুনরায় নিলাম করতে হবে। 
                </div>
                <div style="margin-top: 2px; text-align:justify;">৬। স্থাবর সম্পত্তির ক্ষেত্রে যে ব্যক্তিকে ক্রেতা হিসেবে ঘোষণা করা হয়। ঘোষণা করার পর অবিলম্বে তিনি মোট মূল্যের ২৫% জমা দিবেন নিলাম অনুষ্ঠানকারী কর্মকর্তার নিকট জমা দিতে ব্যর্থ হলে তাৎক্ষণিকভাবে সম্পত্তি পুনঃনিলাম করতে হবে ।</div>
                <div style="margin-top: 2px; text-align:justify;">৭ । নিলাম অনুষ্ঠান বন্ধ হওয়ার পর পঞ্চদশ দিবসের অফিস ছুটি হওয়ার পূর্বে নিলাম ক্রেতাকে সম্পূর্ণ ক্রয় মূল্য পরিশোধ করতে হবে। তবে ঐ দিন যদি সরকারি ছুটি বা সপ্তাহিক ছুটি হয় তা হলে পরবর্তী কার্যদিবসের মধ্যে জমা দিতে হবে ।</div>
                <div style="margin-top: 2px; text-align:justify;">৮। অবশিষ্ট ক্রয় মূল্য অনুমোদিত সময়ের মধ্যে পরিশোধ করতে ব্যর্থ হলে সম্পত্তি পুনরায় নিলাম ইস্তেহার জারি করে পুনঃনিলামে বিক্রি করতে হবে । সার্টিফিকেট অফিসার সমীচিন মনে করলে নিলাম খরচের টাকা বাদ দিয়ে অবশিষ্ট অর্থ সরকারের বাজেয়াপ্ত করতে পারেন এবং ব্যর্থ ক্রেতার ঐ সম্পত্তি অথবা ইহার অংশ বিশেষের দাবি বাজেয়াপ্ত হবে । </div>
                <p>কোর্টের সিল দেয়া হলো ।</p>
                <p>তারিখ : ' . $trialBanglaDate . '</p>
                <div style="padding-top: 20px;">
 <span style="float: right">
     <p style=" text-align : center; color: blueviolet;">
             <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
             
             <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
         সার্টিফিকেট   অফিসার <br>
     </p>
    ' .
            $location .
            ', ' .
            '
 </span>
    </div>
            </section>
            <section>
                <div style="padding-top: 20px; width: 100%; padding-bottom: 20px;">
                    <p style="text-align: center;">সম্পত্তির তফসিল</p>
                    <table style="width: 50%; margin:auto; margin-top:250px;" class="table">
                        <tr>
                            <td width="10%" style="border: 1px solid black">
                                <p style="padding-top: 20px">লট নং</p>
                            </td>
                            <td width="10%" style="border: 1px solid black">একাধিক দেনাদার হলে প্রত্যেকের নাম এবং নিলামে বিক্রি সম্পত্তির বিবরণ</td>
                            <td width="10%" style="border: 1px solid black">সম্পত্তিতে আরোপিত রাজস্ব</td>
                            <td width="10%" style="border: 1px solid black">সম্পত্তিতে যদি কোন দাবি করা হয়ে থাকে এবং সম্পত্তির প্রকৃতি এবং মুল্য সম্পর্কিত বিবরণ</td>
                        </tr>
                        <tr>
                            <td width="10%" style="border: 1px solid black">
                                1
                            </td>
                            <td width="10%" style="border: 1px solid black">2</td>
                            <td width="10%" style="border: 1px solid black">3</td>
                            <td width="10%" style="border: 1px solid black">4</td>
                        </tr>
                        <tr>
                            <td width="10%" style="border: 1px solid black">
                                1
                            </td>
                            <td width="10%" style="border: 1px solid black">2</td>
                            <td width="10%" style="border: 1px solid black">3</td>
                            <td width="10%" style="border: 1px solid black">4</td>
                        </tr>
                        <tr>
                            <td width="10%" style="border: 1px solid black">
                                1
                            </td>
                            <td width="10%" style="border: 1px solid black">2</td>
                            <td width="10%" style="border: 1px solid black">3</td>
                            <td width="10%" style="border: 1px solid black">4</td>
                        </tr>
                    </table>
                </div>
            </section>  
    </div>
    </div>
        ';

        // dd($template); exit;

        return $template;
    }

    //নিলাম ইস্তেহার প্রকাশ করার জন্য নাজিরকে আদেশ
    public static function getOrderToNajirForAuctionNoticeShortOrderTemplate($appealInfo, $requestInfo)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);
        $defaulter = $appealInfo['defaulterCitizen'];
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;
        $office_info = get_office_by_id(globalUserInfo()->office_id);
        $location = $office_name->office_name_bn;
        // dd($office_info,$office_name);
        $distric_name = DB::table('district')
            ->where('id', '=', $office_info->district_id)
            ->first();

        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $case_data_mapping = DB::table('gcc_appeals')
            ->join('office', 'gcc_appeals.office_id', 'office.id')
            ->join('district', 'gcc_appeals.district_id', 'district.id')
            ->where('gcc_appeals.id', $requestInfo->appealId)
            ->select('gcc_appeals.loan_amount_text', 'gcc_appeals.loan_amount', 'office.office_name_bn', 'office.organization_physical_address', 'district.district_name_bn')
            ->first();

        $amount_to_pay_as_remaining = $requestInfo->amount_to_pay_as_remaining;
        $amount_to_pay_as_costing = $requestInfo->amount_to_pay_as_costing;

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($modified_conduct_date)));
        //$trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        //$trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));

        $template = '
        <div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">
                <h3>ফর্ম নং – ২২</h3>
                <h3>বাংলাদেশ ফর্ম নং ১০৪২</h3>
                <h4>নিলাম ইস্তেহার প্রকাশ করার জন্য নাজিরকে আদেশ</h4>
                <h4>(বিধি - ৪৬ দ্রষ্টব্য)</h4>
            </div>
        </header>
        <div class="all_content">
            <p> প্রাপক : নাজির,</p>
            <p> ' . $distric_name->district_name_bn . ' কালেক্টরেট । </p>
        <p>যেহেতু, সার্টিফিকেট দেনাদারের এই সঙ্গে সংযুক্ত তফসিলে বর্ণিত সম্পত্তি সার্টিফিকেট কেস নং ' . $appealInfo['appeal']->case_no . '</br>' .'ম্যানুয়াল মামলা নংঃ ' . $appealInfo['appeal']->newCaseNo . ' তারিখ ' . $trialBanglaDate . '. নিলামে বিক্রি তারিখ উক্ত করার আদেশ দেয়া হয়েছে এবং উক্ত সম্পত্তি নিলাম বিক্রির ইস্তেহার আপনার নিকট হস্তান্তর করা হলো এবং আপনাকে এই মর্মে আদেশ দেয়া যাচ্ছে যে ঢোল সহরত করে তফসিলে বর্ণিত সম্পত্তির বিষয় ইস্তেহার প্রকাশ করতে হবে এবং এক কপি ইস্তেহার সম্পতির প্রকাশ্য স্থানে টাঙ্গাতে এবং পরে এক কপি আমার অফিসে টাঙ্গাতে হবে । তারপর ইস্তেহার কত তারিখ এবং কি পদ্ধতিতে প্রকাশ করা হয়েছে সে সম্পর্কে আমার নিকট রিপোর্ট দিতে হবে ।</p>
        <p> তারিখ : ' . $trialBanglaDate . '</p>
        <p style="width:100%; text-align:center;">তফসিল বিবরণ:</p>
    
        <div>
    
        <table style="margin-top: 20px">
        <tr style="text-align:center;">
            <td style="border: 1px solid black; height:40px; font-weight: 800;">নং</td>
            <td style="border: 1px solid black; height:40px; font-weight: 800;">দাগ নং</td>
            <td style="border: 1px solid black; height:40px; font-weight: 800;">দাগে মোট জমির পরিমান</td>
            <td style="border: 1px solid black; height:40px; font-weight: 800;">জমির শ্রেণি</td>
            <td style="border: 1px solid black; height:40px; font-weight: 800;">খতিয়ান</td>
            <td style="border: 1px solid black; height:40px; font-weight: 800;">মৌজা</td>
            <td style="border: 1px solid black; height:40px; font-weight: 800;">উপজেলা</td>
            <td style="border: 1px solid black; height:40px; font-weight: 800;">জেলা</td>
            
        </tr>
        <tr>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        </tr>      
        <tr>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        </tr>      
        <tr>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
            <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        </tr>      
    </table>    
    
        </div>
        <div style="padding-top: 20px;padding-bottom: 100px">
        <span style="float: right">
            <p style=" text-align : center; color: blueviolet;">
                    <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
                    
                    <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
                সার্টিফিকেট   অফিসার <br>
            </p>
           ' .
            $office_info->office_name_bn .
            ' ' .
            '
        </span>
       </div>
    </div>
    </div> 
        ';

        return $template;
    }

    //অস্থাবর সম্পত্তির দখলকারীকে সম্পত্তি নিলামে বিক্রি সম্পর্কে নোটিস
    public static function getNoticeToOccupierShortOrderTemplate($appealInfo, $requestInfo)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);
        $defaulter = $appealInfo['defaulterCitizen'];
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;
        $location = $office_name->office_name_bn;

        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $case_data_mapping = DB::table('gcc_appeals')
            ->join('office', 'gcc_appeals.office_id', 'office.id')
            ->join('district', 'gcc_appeals.district_id', 'district.id')
            ->where('gcc_appeals.id', $requestInfo->appealId)
            ->select('gcc_appeals.loan_amount_text', 'gcc_appeals.loan_amount', 'office.office_name_bn', 'office.organization_physical_address', 'district.district_name_bn')
            ->first();
        $amount_to_pay_as_remaining = $requestInfo->amount_to_pay_as_remaining;
        $amount_to_pay_as_costing = $requestInfo->amount_to_pay_as_costing;

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($modified_conduct_date)));
        //$trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        //$trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));

        $template = '
        <div id="crimieDescription" class="arrest-warrant">
        <header>
          <div style="text-align: center">
            <h3>ফর্ম নং – ২৪</h3>
            <h3>
              অস্থাবর সম্পত্তির দখলকারীকে সম্পত্তি নিলামে বিক্রি সম্পর্কে নোটিস
            </h3>
            <h4>(বিধি – ৫৯ (২) দ্রষ্টব্য)</h4>
          </div>
        </header>
        <div class="all_content">
          <p>প্রাপক :</p>
          <p>
            যেহেতু জনাব ......................... নং ' . $appealInfo['appeal']->case_no . '</br>' .'ম্যানুয়াল মামলা নংঃ ' . $appealInfo['appeal']->newCaseNo . ' তাং সার্টিফিকেট কার্যকরী করার জন্য
            নিলামের মাধ্যমে ক্রেতা হয়েছেন, আপনাকে ঐ সম্পত্তি ...................................... ব্যতীত অন্য
            কাহারও নিকট অর্পন করতে নিষেধ করা হলো ।
          </p>
          <p>কোর্টের সিল দেয়া হলো ।</p>
          <p>তারিখ : ' . $trialBanglaDate . '</p>
          <div style="padding-top: 20px;padding-bottom: 50px">
    <span style="float: right">
     <p style=" text-align : center; color: blueviolet;">
             <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
             
             <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
         সার্টিফিকেট   অফিসার <br>
     </p>
    ' .
            $location .
            ', '  .
            '
 </span>
    </div>
        </div>
      </div>
        ';

        return $template;
    }
    public static function getDetermineAuctionTemplate($appealInfo, $requestInfo)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);
        $defaulter = $appealInfo['defaulterCitizen'];
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;
        $appealBanglaDay = DataConversionService::toBangla(date('d', strtotime($appealInfo['appeal']->created_at)));
        $appealBanglaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($appealInfo['appeal']->created_at)));
        $appealBanglaYear = DataConversionService::toBangla(date('Y', strtotime($appealInfo['appeal']->created_at)));
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        $location = $office_name->office_name_bn;

        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $case_data_mapping = DB::table('gcc_appeals')
            ->join('office', 'gcc_appeals.office_id', 'office.id')
            ->join('district', 'gcc_appeals.district_id', 'district.id')
            ->where('gcc_appeals.id', $requestInfo->appealId)
            ->select('gcc_appeals.loan_amount_text', 'gcc_appeals.loan_amount', 'office.office_name_bn', 'office.organization_physical_address', 'district.district_name_bn')
            ->first();
        $amount_to_pay_as_remaining = $requestInfo->amount_to_pay_as_remaining;
        $amount_to_pay_as_costing = $requestInfo->amount_to_pay_as_costing;

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($modified_conduct_date)));
        //$trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        //$trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));

        $template = '
        <div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">
                
                <div style="display: flex; justify-content: space-between; padding: 0px 50px ; margin: 30px 0;">
                    <h5>বাংলাদেশ ফর্ম নং-১০৪০
                    </h5>
                    <h5>(পরিশিষ্টের ফরম নং- ২০)</h3>
                </div>
                <h4 style="font-weight: bold;">কোন নিলামের ঘোষণাপত্র স্থির করিবার জন্য নির্দিষ্ট দিনের নোটিশ।
                </h4>
                <h5 style="margin-top: 10px">(বিধি ৪৬ দেখুন)
                </h5>
            </div>
        </header>
        <div class="all_content">
        <p>সার্টিফিকেট খাতক ' . $defaulter->citizen_name . ' বরাবরেষু।</p>
        <p style="margin-top: 30px">যেহেতু ' . $trialBanglaDate . ' এর মামলা নং ' . $appealInfo['appeal']->case_no . '</br>' .'ম্যানুয়াল মামলা নংঃ ' . $appealInfo['appeal']->newCaseNo . ' সার্টিফিকেটের দাবিসূত্রে আপনার নিম্নলিখিত সম্পত্তির শ্রীঘ্রই নিলাম হইবে, অতএব আপনাকে এতদ্বারা জানান যাইতেছে যে, ' . $appealBanglaYear . ' সালের ' . $appealBanglaMonth . ' মাসের ' . $appealBanglaDay . ' দিবস নিলামের ঘোষণাপত্রের শর্তসকল স্থির করিবার জন্য নির্দিষ্ট হইয়াছে।
        </p>
        <p>
            সার্টিফিকেট সম্বন্ধে খরচ ও সবসমেত আপনার নিকট হইতে মোট ' . $amount_to_pay_as_remaining . ' টাকা পাওনা হইতেছে।
        </p>
 <p>
    অত্র আদালতের মোহরযুক্ত মতে ২০ ............... সালের ............... মাসের ................ দিবসে প্রদত্ত হইল।
 </p>
         
        <p style="width:100%; text-align:center;">সম্পত্তির বিবরণ:</p>
    
    <div>

    <table style="margin-top: 20px">
    <tr style="text-align:center;">
        <td style="border: 1px solid black; height:40px; font-weight: 800;">নং</td>
        <td style="border: 1px solid black; height:40px; font-weight: 800;">দাগ নং</td>
        <td style="border: 1px solid black; height:40px; font-weight: 800;">দাগে মোট জমির পরিমান</td>
        <td style="border: 1px solid black; height:40px; font-weight: 800;">জমির শ্রেণি</td>
        <td style="border: 1px solid black; height:40px; font-weight: 800;">খতিয়ান</td>
        <td style="border: 1px solid black; height:40px; font-weight: 800;">মৌজা</td>
        <td style="border: 1px solid black; height:40px; font-weight: 800;">উপজেলা</td>
        <td style="border: 1px solid black; height:40px; font-weight: 800;">জেলা</td>
        
    </tr>
    <tr>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
    </tr>      
    <tr>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
    </tr>      
    <tr>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
        <td style="border: 1px solid black; height: 80px; width: 150px;"></td>
    </tr>      
</table>    

    </div>
        
    <div style="padding-top: 20px;padding-bottom: 100px">
    <span style="float: right">
        <p style=" text-align : center; color: blueviolet;">
                <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
                
                <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
            সার্টিফিকেট   অফিসার <br>
        </p>
       ' .
            $location .
            ', '  .
            '
    </span>
   </div>
    </div>
    </div>
        ';
        return $template;
    }
    public static function getAuctionPossessionShortOrderTemplate($appealInfo, $requestInfo)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        $location = $office_name->office_name_bn;

        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);
        $defaulter = $appealInfo['defaulterCitizen'];
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;

        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $case_data_mapping = DB::table('gcc_appeals')
            ->join('office', 'gcc_appeals.office_id', 'office.id')
            ->join('district', 'gcc_appeals.district_id', 'district.id')
            ->where('gcc_appeals.id', $requestInfo->appealId)
            ->select('gcc_appeals.loan_amount_text', 'gcc_appeals.loan_amount', 'office.office_name_bn', 'office.organization_physical_address', 'district.district_name_bn')
            ->first();
        $amount_to_pay_as_remaining = $requestInfo->amount_to_pay_as_remaining;
        $amount_to_pay_as_costing = $requestInfo->amount_to_pay_as_costing;

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($modified_conduct_date)));
        //$trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        //$trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));

        $template = '
        <div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">

                <div style="display: flex; justify-content: space-between; padding: 0px 50px ; margin: 30px 0;">
                    <h5>বাংলাদেশ ফর্ম নং-১০</h5>
                    <h5>(পরিশিষ্টের ফরম নং- ২৯)</h3>
                </div>
                <h4 style="font-weight: bold;">ভূমি নিলাম ক্রয়কারীকে দখল অর্পণের আদেশ</h4>
                <h5>(বিধি-৭৫ দ্রষ্টব্য)
                </h5>
            </div>
        </header>
        <div class="all_content">
        <p>প্রাপক:</p>
        <p><span style="margin-left: 40px;">যেহেতু </span>জনাব ................................... কে সার্টিফিকেট কেস নং ' . $appealInfo['appeal']->case_no . '</br>' .'ম্যানুয়াল মামলা নংঃ ' . $appealInfo['appeal']->newCaseNo . '
     তাং .................................. এর প্রত্যায়িত ক্রেতা ঘোষণা করা হয়েছে; অতএব উক্ত প্রত্যায়িত ক্রেতাকে নিলামে ক্রয়কৃত সম্পত্তির দখল অর্পণ করার জন্য আপনাকে আদেশ দেয়া যাচ্ছে।</p>
        <p>
            কোর্টের সীল দেয়া হলো
        </p>
 
         
    <div style="margin-left: 60px; margin-top: 50px;">
        <p>তারিখ: ' . $trialBanglaDate . '</p>
        <div style="">
        <span style="float: right">
         <p style="text-align: center; color: blueviolet;">
                 <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
                 
                 <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
             সার্টিফিকেট   অফিসার <br>
         </p>
        ' .
            $location .
            ', '  .
            '
     </span>
        </div>    </div>
        
    </div>
    </div>
        ';
        return $template;
    }
}
