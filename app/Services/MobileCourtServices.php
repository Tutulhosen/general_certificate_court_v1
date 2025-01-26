<?php
/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 12/27/17
 * Time: 3:38 PM
 */

namespace App\Services;


class MobileCourtServices
{
    public static function getCriminalListByCaseNo ($caseNo)
    {

        $parameters = "caseNo=" . $caseNo;
        $url = config('app.mobileUrl')."mobile/searchForCase";
        $client = curl_init($url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($client, CURLOPT_POST, true);
        curl_setopt($client, CURLOPT_POSTFIELDS, $parameters);
        $response = curl_exec($client);

        $criminalList = json_decode($response);

        return $criminalList;
    }

    public static function getCriminalProsecutionInfo ($caseNo, $criminalId)
    {

        $parameters = "caseNo=" . $caseNo . "&criminalId=" . $criminalId;
        $url = config('app.mobileUrl') . "mobile/searchForCriminalProsecution";
        $client = curl_init($url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($client, CURLOPT_POST, true);
        curl_setopt($client, CURLOPT_POSTFIELDS, $parameters);
        $response = curl_exec($client);
        $criminalInfo = json_decode($response);

        return $criminalInfo;
    }

}