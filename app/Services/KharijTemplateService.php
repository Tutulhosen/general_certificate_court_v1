<?php


namespace App\Services;


use App\Models\GccCaseKharijTemplates;
use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class KharijTemplateService
{
    public static function getShortOrderTemplateListByAppealId($appealId){
        $shortOrderTemplateList=DB::connection('mysql')
            ->table('gcc_cause_lists')
            ->join('gcc_case_shortdecision_templates', 'gcc_cause_lists.id', '=', 'gcc_case_shortdecision_templates.cause_list_id')
            ->where('gcc_case_shortdecision_templates.appeal_id',$appealId )
            ->select('gcc_case_shortdecision_templates.id','gcc_case_shortdecision_templates.appeal_id',
                'gcc_case_shortdecision_templates.template_name','gcc_case_shortdecision_templates.template_full',
                'gcc_cause_lists.trial_date','gcc_cause_lists.conduct_date')
            ->get();

        $index = 1;
        $templateList =  array ();

        foreach ($shortOrderTemplateList as $shortOrderTemplate)
        {
            $template['index'] = DataConversionService::toBangla($index);
            $template['appeal_id'] = $shortOrderTemplate->appeal_id;
            $template['id'] = $shortOrderTemplate->id;
            $template['template_name'] = $shortOrderTemplate->template_name;
            $template['conduct_date'] = DataConversionService::toBangla(date('d-m-Y',strtotime($shortOrderTemplate->conduct_date)));
            $template['template_full'] = $shortOrderTemplate->template_full;

            $index++;
            array_push($templateList, $template);
        }
        // dd($templateList);
        return $templateList;
    }

    public static function deleteShortOrderTemplate($causeListId){
        $shortOrderList=GccCaseKharijTemplates::where('cause_list_id',$causeListId);
        // dd($shortOrderList);
        $shortOrderList->delete();
        return;
    }

    public static function storeKharijTemplate($appealId,$shortOrderTemplateContent,$templateName){
        $kharijTemplate=new GccCaseKharijTemplates();
        $kharijTemplate->appeal_id=$appealId;
        $kharijTemplate->template_full=$shortOrderTemplateContent;
        $kharijTemplate->template_header='';
        $kharijTemplate->template_body='';
        $kharijTemplate->template_name=$templateName;
        $kharijTemplate->created_at=date('Y-m-d H:i:s');
        $kharijTemplate->created_by=Auth::user()->username;
        $kharijTemplate->updated_at=date('Y-m-d H:i:s');
        $kharijTemplate->updated_by=Auth::user()->username;
        $kharijTemplate->save();
    }
    public static function generateKharijTemplate($shortOrders,$appealId){
        $appealInfo=AppealRepository::getAllAppealInfo($appealId);
        // dd($causeList);
        $shortOrderTemplate=self::getCertificateKharijRequestTemplate($appealInfo);
        // dd($shortOrderTemplate);
            

    }

    //----------- মামলা খারিজের আবেদন পত্র-----------------------------------------//
    public static function getCertificateKharijRequestTemplate($appealInfo){
        $templateName="মামলা খারিজের আবেদন পত্র";
        $appealId= $appealInfo['appeal']->id;
        $location= $appealInfo['appeal']->office_name;
        $defaulter=$appealInfo['defaulterCitizen'];
        $guarantorCitizen=$appealInfo['guarantorCitizen'];
        // dd($appealInfo);
        $loanAmountBng=DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
       $htmlbreak='<br><br>';

        $template='
                   <style>
                        table, th, td {
                            border: 1px solid black;
                            border-collapse: collapse;
                            padding: 10px;
                            font-weight: normal;
                            text-align: center;
                        }
                    </style>
        <div >
                        <header>
                            <div style="text-align: center !important">
                                <table width="100%">
                                    <tr>
                                        <td width="20%">
                                            
                                        </td>
                                        <td width="40%">
                                           <h3>'. user_office_name() .'</h3>
                                           <br>'.user_district_name() .'
                                        </td>
                                        <td width="40%">
                                          '. globalUserInfo()->mobile_no .'<br>
                                          '. globalUserInfo()->email .'<br>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </header>
             <br>
             <span style="float: left; font-size: medium;padding: 10px;">সুত্র নংঃ প্রশাঃ</span>
             <span style="float: right; font-size: medium;padding: 10px;">তারিখঃ '. en2bn(date('Y-m-d')) .'</span>
             <br>
             <br>
             <br>
            <div style="height:100%; padding: 10px;">

                <span style="float: left; font-size: medium">জেনারেল সার্টিফিকেট অফিসার <br> জেনারেল সার্টিফিকেট আদালত <br>'.user_district_name().'
                </span>
                <br><br><br><br><br>
                <span style="float: left;">
                বিষয়ঃ  <u> সার্টিফিকেট মোকাদ্দমা খারিজ প্রসঙ্গে। </u>
                </span>
                <br><br><br><br><br>
                 <span style="float: left;">প্রিয় মহোদয়,</span>
                <br><br><br>
                 <span style="float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;আপনার অবগতির জন্য জানানো যাচ্ছে যে, নিম্ন বর্ণিত সার্টিফিকেট খাতক ঋণের সমুদয় টাকা পরিশোধ করেছে । এমতাবস্থায় সার্টিফিকেট ম্মোকাদ্দমাটি খারিজ করার অনুরোধ করা হোল।
                 </span>
                <br><br><br>
                <br>
               <table width="100%">
                    <colgroup><col>
                    </colgroup><colgroup span="2"></colgroup>
                    <colgroup span="2"></colgroup>
                    <tbody>
                        <tr>
                            <th width="25%" >সার্টিফিকেট মত খাতকের নাম</th>
                            <th width="35%" >সার্টিফিকেট মত খাতকের ঠিকানা</th>
                            <th width="10%">পরিশোধিত টাকার পরিমাণ</th>
                            <th width="30%" >মন্তব্য</th>
                        </tr>
                        
                        <tr>
                        <td>১ । ঋণ গ্রহীতা - '.$defaulter->citizen_name.', পিতা -'.$defaulter->father.' ,মাতা -'.$defaulter->mother.'</td>
                        <td>ব্যবসায়িক ঠিকানা - '.$defaulter->present_address .'.'.$htmlbreak.',স্থায়ী ঠিকানা - '.$defaulter->permanent_address.'</td>
                        <td>'.$loanAmountBng.' টাকা </td>
                        <td>'.$appealInfo['appeal']->kharij_reason.'</td>
                        </tr>
                    
                    </tbody>
                </table>
                 <br>
                <div style="float: left;">
                    <span> আপনার বিশ্বস্ত </span>
                    <br><br><br>
                    <span>
                        '.globalUserRoleInfo()->role_name.'<br>
                         '. user_office_name() .'
                    </span>

                 </div>
            </div>
        </div>';
        self::storeKharijTemplate($appealId,$template,$templateName);
    }



}
