<?php
/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 2/1/18
 * Time: 6:27 PM
 */

namespace App\Services;


use App\Models\Appeal;
use App\Repositories\CauseListRepository;
use App\Repositories\CauseListShortDecisionRepository;
use Illuminate\Support\Facades\Session;

class SmsService
{
    public static function SendSmsMessage($mobile, $message)
    {
       $ms = DataConversionService::toEnglish($mobile);
        $txt = $message;
        $txt = urlencode($txt);

        $options = stream_context_create(array('http'=>
            array(
                'timeout' => 5 //10 seconds
            )
        ));

        if (substr($ms, 0, 3) != '+88') {
                $ms = '+88' . $ms;
        }
        try{
//            $Response = file_get_contents("http://123.49.3.58:8081/web_send_sms.php?ms=" . $ms . "&txt=" . $txt . "&username=pmoffice&password=pmoffice",false,$options);
//            $Response = file_get_contents("https://bulksms.teletalk.com.bd/link_sms_send.php?op=SMS&user=A2IPMO&pass=piRiton100ml&mobile=".$ms. "&charset=UTF-8&sms=".$txt,false,$options);
            $Response = file_get_contents("https://bulksms.teletalk.com.bd/link_sms_send.php?op=SMS&user=ecourt_user&pass=RVuS7vXs&mobile=".$ms. "&charset=UTF-8&sms=".$txt,false,$options);

        }catch (\Exception $e){
            $Response = 'error';
        }


        if ($Response == 'error') {
            return false;
        }

        return true;
    }

    public static function getUserDesignationEnglishText(){
        $role=Session::get('userRole');
        $text='';
        $location=Session::get('userInfo')->district_name_eng;
        if($role=='DM'){
            $text='District Magistrate'.', '.$location;
        }elseif ($role=='ADM'){
            $text='Additional District Magistrate'.', '.$location;
        }elseif ($role=='Peshkar'){
            $text='Peshkar'.', '.$location;
        }elseif ($role=='GCO'){
            $text='General Certificate Officer'.', '.$location;
        }
        return $text;
    }

    public static function getSmsFormat($appealId,$citizenInfo,$todayCauseListId){
        $template='';
        $shortDecisionTemplate='';
        $designationText=Session::get('userInfo')->designation_bng;
        $location= Session::get('userInfo')->district_name_bng;
        $appeal=Appeal::find($appealId);
        $banglaCaseNo = DataConversionService::toBangla($appeal->case_no);
        $futureCauseList=CauseListRepository::getPreviousCauseListId($appealId);
        $banglaTrialDate= DataConversionService::toBangla($futureCauseList->trial_date);
        $shortDecisions=CauseListShortDecisionRepository::getCauseListShortOrderInfoByCauseListId($todayCauseListId);
        if(count($shortDecisions)>0){
            $shortDecisionTemplate.='';
            foreach ($shortDecisions as $shortDecision){
                $shortDecisionTemplate.=$shortDecision->case_short_decision.',';
            }
        }
        $template='জনাব/জনাবা, মামলা নং: '.$banglaCaseNo.', পরবর্তী শুনানির তারিখ: '.$banglaTrialDate .', '.$designationText.', '.$location.', বিস্তারিত জানার জন্য: causelist.ecourt.gov.bd';

/*        $template='Dear '.$citizenInfo['offenderCitizen']->citizen_name .
                    ', Case No :'.$appeal->case_no.', Next Trial Date :'.$futureCauseList->trial_date .', Short Order :'.$shortDecisionTemplate;*/
        return $template;
    }




}