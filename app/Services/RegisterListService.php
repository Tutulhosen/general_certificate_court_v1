<?php
/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 1/31/18
 * Time: 2:43 PM
 */

namespace App\Services;


use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RegisterListService
{
    public static function getDefaultRegisterLabelList()
    {
        $columnLabel = ["ক্রমিক নম্বর", "আপিল অবস্থা", "মামলা নম্বর", "সংশ্লিষ্ট আদালত", "মামলার সিদ্ধান্ত", "পরবর্তী শুনানীর তারিখ", "পরবর্তী শুনানীর সময়", "আপীলকারীর নাম", "লঙ্ঘিত আইন ও ধারা"];
        $registerLableList = [];
        for ($i = 0; $i < count($columnLabel); $i++) {
            $registerLableList[$i]['label_name'] = $columnLabel[$i];
        }
        return $registerLableList;

    }

    public static function getRegisterLableByRegisterId($register)
    {
        $registerLabelList = [];

        if ($register == '') {
            $registerLabelList = self::getDefaultRegisterLabelList();
        } else {
            $registerLabelList = DB::connection('appeal')
                ->select(DB::raw(
                    "SELECT rlabel.label_name  
                  FROM register_lists rl
                  JOIN registerlist_registerlabels rrl ON rl.id=rrl.register_id
                  JOIN register_labels rlabel ON rrl.register_label_id=rlabel.id
                  WHERE rl.id=$register"
                ));
        }

        return $registerLabelList;
    }

    public static function getSearchParamCondition($searchParameters)
    {
        $searchConditions = '';
        if (isset($searchParameters)) {
            if (isset($searchParameters['startDate'])) {
                if (isset($searchParameters['endDate'])) {
                    $endDate = date('Y-m-d',strtotime(trim($searchParameters['endDate'])));
                } else {
                    $endDate = date('Y-m-d', time());
                }
                $startDate = date('Y-m-d',strtotime(trim($searchParameters['startDate'])));

                $searchConditions .= "AND cl.trial_date BETWEEN '$startDate' AND '$endDate' ";
            }

            if (isset($searchParameters['appealCaseNo'])) {
                $appealCaseNo = trim($searchParameters['appealCaseNo']);
                $searchConditions .= "AND a.case_no='$appealCaseNo' ";
            }

            if(isset($searchParameters['caseStatus'])){
                $caseStatus=trim($searchParameters['caseStatus']);
                $searchConditions.="AND a.case_decision_id = $caseStatus ";
            }

            if(isset($searchParameters['gcoList'])){
                $gco=trim($searchParameters['gcoList']);
                $searchConditions.="AND a.gco_user_id= $gco ";
            }

        }
        return $searchConditions;
    }

    /*------------------- general Register-----------------------*/
    public static function getBongioRegisterInfoBySearchParam($request)
    {
        $usersPermissions = Session::get('userPermissions');
        $permissionBasedConditions = AppealRepository::getPermissionBasedConditions($usersPermissions);
        $searchConditions = $permissionBasedConditions;

        //search parameter
        $searchParameters = $request->searchParameter;

        $searchConditions .= self::getSearchParamCondition($searchParameters);


        $register = DB::connection('appeal')
            ->select(DB::raw(
                "SELECT
                      a.law_section,
                      concat(c.citizen_name,c.present_address) AS defaulterInfo,
                      a.loan_amount,
                      cls.order_text,
                      pys.paid_loan_amount,
                      pys.last_paid_date,
                      pys.no_of_payment
                    FROM appeals a
                      LEFT JOIN (
                                  SELECT xl.appeal_id, concat(' তারিখ : ', zl.trial_date , ' <br> আদেশ :' ,xl.order_text) AS order_text
                                  FROM appeals a
                                  JOIN notes xl ON a.id = xl.appeal_id
                                  JOIN cause_lists zl ON zl.id = xl.cause_list_id AND a.id = zl.appeal_id
                                  WHERE xl.id = (SELECT MAX(cause_list_id) FROM notes WHERE appeal_id = xl.appeal_id) AND a.appeal_status='CLOSED'
                                ) cls ON cls.appeal_id = a.id
                      JOIN cause_lists cl ON cl.appeal_id=a.id
                      JOIN case_decisions AS cd ON a.case_decision_id=cd.id
                      JOIN appeal_citizens ac ON ac.appeal_id=a.id AND ac.citizen_type_id=1
                      JOIN citizens c ON c.id=ac.citizen_id
                      LEFT JOIN
                                (
                                    SELECT
                                      py.appeal_id AS appeal_id, sum(py.paid_loan_amount) AS paid_loan_amount, count(py.id) AS no_of_payment, max(py.paid_date) AS last_paid_date
                                      FROM payment_lists py
                                  ) pys ON pys.appeal_id = a.id
                                  WHERE $searchConditions
                    GROUP BY a.id"
            ));

        return $register;

    }

    /*------------------- Money Calculation Register-----------------------*/
    public static function getCaseMoneyCalculationRegisterBySearchParam($request)
    {
        $usersPermissions = Session::get('userPermissions');
        $permissionBasedConditions = AppealRepository::getPermissionBasedConditions($usersPermissions);
        $searchConditions = $permissionBasedConditions;

        //search parameter
        $searchParameters = $request->searchParameter;

        $searchConditions .= self::getSearchParamCondition($searchParameters);


        $register = DB::connection('appeal')
            ->select(DB::raw(
                "SELECT  
                      a.case_no,
                      c.khatok,
                      b.dharok,
                      cd.case_decision,
                      a.loan_amount,
                      d.total_paid_loan_amount
                    FROM appeals a
                      JOIN cause_lists cl on a.id = cl.appeal_id and cl.id = (SELECT MAX(cause_list_id) FROM notes WHERE appeal_id = a.id)
                    JOIN case_decisions cd on a.case_decision_id = cd.id
                    JOIN (
                    SELECT a.id as appeal_id, c.citizen_name as dharok FROM appeals a JOIN appeal_citizens ac on a.id = ac.appeal_id
                    JOIN citizens c on c.id = ac.citizen_id WHERE ac.citizen_type_id = 1)b on a.id = b.appeal_id
                    join(SELECT a.id as appeal_id, c.citizen_name as khatok FROM appeals a JOIN appeal_citizens ac on a.id = ac.appeal_id
                        JOIN citizens c on c.id = ac.citizen_id WHERE ac.citizen_type_id = 2)c on a.id = c.appeal_id
                    join(SELECT x.appeal_id,sum(x.amount) total_paid_loan_amount from (
                      SELECT a.id as appeal_id, pl.paid_loan_amount as amount FROM appeals a JOIN payment_lists pl on pl.appeal_id = a.id)x
                      GROUP BY x.appeal_id)d on d.appeal_id = a.id
                    WHERE $searchConditions
                    GROUP BY a.id"
            ));

        return $register;

    }
    /*------------------- রেজিস্টার ১৯ বি -----------------------*/
    public static function getAuctionMoneyCalculationRegisterBySearchParam($request)
    {
        $usersPermissions = Session::get('userPermissions');
        $permissionBasedConditions = AppealRepository::getPermissionBasedConditions($usersPermissions);
        $searchConditions = $permissionBasedConditions;

        //search parameter
        $searchParameters = $request->searchParameter;

        $searchConditions .= self::getSearchParamCondition($searchParameters);


        $register = DB::connection('appeal')
            ->select(DB::raw(
                "SELECT
                  ifnull(a.case_no, '') as case_no,
                  ifnull(z.case_decision, '') as case_decision,
                  ifnull(y.auctioned_date, '') as auctioned_date,
                  ifnull(y.auctioneer_name, '') as auctioneer_name,
                  ifnull(y.auctioneer_recipient_name, '') as auctioneer_recipient_name,
                  ifnull(a.loan_amount, 0) as loan_amount,
                  ifnull(x.total_paid_loan_amount, 0) as total_paid_loan_amount,
                  ifnull(y.auctioned_sale, 0) as auctioned_sale,
                  ifnull(y.paid_money, 0) as paid_money,
                  ifnull(y.auctioned_sale - y.paid_money, 0) as quoted_money
                FROM appeals a
                  JOIN cause_lists cl on a.id = cl.appeal_id and cl.id = (SELECT MAX(cause_list_id) FROM notes WHERE appeal_id = a.id)
                LEFT JOIN (
                SELECT
                  x.appeal_id,
                  sum(x.paid_loan_amount) as total_paid_loan_amount
                FROM (
                SELECT
                  pl.appeal_id,
                  pl.paid_loan_amount
                FROM payment_lists pl
                WHERE pl.is_nilam is NULL) x GROUP BY x.appeal_id)x on a.id = x.appeal_id
                JOIN (
                    SELECT
                      pl.appeal_id,
                      pl.auctioned_date,
                      pl.auctioneer_name,
                      pl.auctioneer_recipient_name,
                      pl.auctioned_sale,
                      pl.paid_loan_amount as paid_money
                    FROM payment_lists pl
                    WHERE  pl.is_nilam = 'is_nilam'
                    )y on a.id = y.appeal_id
                JOIN (SELECT
                        cl.appeal_id AS appeal_id,
                        GROUP_CONCAT(csd.case_short_decision) AS case_decision
                      FROM cause_lists cl
                        JOIN (
                               SELECT MAX(cl1.id) AS CauseListID, cl1.appeal_id AS AppealID
                               FROM cause_lists cl1
                                 JOIN ( SELECT MAX(cl0.id) AS CauseListID, cl0.appeal_id AS AppealID FROM cause_lists cl0 GROUP BY cl0.appeal_id ) x0 ON x0.AppealID = cl1.appeal_id AND x0.CauseListID > cl1.id
                               GROUP BY cl1.appeal_id
                             ) x1 ON x1.AppealID = cl.appeal_id AND x1.CauseListID = cl.id
                        LEFT JOIN causelist_caseshortdecisions clcsd ON clcsd.cause_list_id = cl.id
                        LEFT JOIN case_shortdecisions csd ON csd.id = clcsd.case_shortdecision_id
                      GROUP BY cl.appeal_id)z on a.id = z.appeal_id
                      WHERE $searchConditions"
            ));

        return $register;

    }

    /*------------------- criminal Miss Register-----------------------*/
    public static function getCriminalMissRegisterInfoBySearchParam($request)
    {
        $usersPermissions = Session::get('userPermissions');
        $permissionBasedConditions = AppealRepository::getPermissionBasedConditions($usersPermissions);
        $searchConditions = $permissionBasedConditions;

        //search parameter
        $searchParameters = $request->searchParameter;

        $searchConditions .= self::getSearchParamCondition($searchParameters);


        $register = DB::connection('appeal')
            ->select(DB::raw(
                "SELECT a.case_no,
                          a.conduct_date,
                          a.em_name,
                          concat(a.LawSection,' আদেশ :',a.previous_court_order_text) as lawSecOrderText,
                          a.criminalAddress,
                          a.appeal_short_description,
                          CASE
                               WHEN a.appeal_status = 'CLOSED' THEN \" \"
                               ELSE DATE_FORMAT(cl.trial_date, '%d-%m-%Y')
                          END AS trial_date,
                          a.rai_order_text
                FROM ( SELECT
                         a.id AS appeal_id,
                         cl.id AS cause_list_id,
                         a.peshkar_user_id AS peshkar_user_id,
                         a.dm_user_id,
                         a.adm_user_id,
                         a.case_no,
                         xl.conduct_date,
                         a.em_name,
                         a.previous_court_order_text,
                         GROUP_CONCAT(lb.law_section_title) AS LawSection,
                         concat(c.citizen_name,' ঠিকানা :') as criminalAddress,
                         a.appeal_short_description,
                         ro.rai_order_text,
                         a.appeal_status,
                         a.mobile_court_case_no,
                         a.case_decision_id,
                FROM cause_lists cl
                     JOIN (
                            SELECT xl.appeal_id, xl.conduct_date
                            FROM cause_lists xl
                            WHERE xl.id = (SELECT MIN(id) FROM cause_lists WHERE appeal_id = xl.appeal_id)
                            GROUP BY xl.appeal_id
                          ) xl ON xl.appeal_id = cl.appeal_id
                     JOIN appeals a ON a.id = cl.appeal_id
                     JOIN law_brokens AS lb ON lb.appeal_id=a.id
                     JOIN appeal_citizens ac ON ac.appeal_id=a.id AND ac.citizen_type_id=1
                     JOIN citizens c ON c.id=ac.citizen_id
                     LEFT JOIN rai_orders ro ON ro.appeal_id=a.id
               GROUP BY a.id) a
                      JOIN (
                 SELECT xl.appeal_id, xl.trial_date
                 FROM cause_lists xl
                 WHERE xl.id = (SELECT MAX(id) FROM cause_lists WHERE appeal_id = xl.appeal_id)
                 GROUP BY xl.appeal_id
               ) cl ON cl.appeal_id = a.appeal_id
              WHERE $searchConditions"
            ));


        return $register;
    }

    /*------------------- Init Register-----------------------*/
    public static function getDefaultRegisterInfoBySearchParam($request)
    {

        $usersPermissions = Session::get('userPermissions');
        $userInfo = Session::get('userInfo');
        $permissionBasedConditions = AppealRepository::getPermissionBasedConditions($usersPermissions);
        $searchConditions = $permissionBasedConditions;

        //search parameter
        $searchParameters = $request->searchParameter;

        $searchConditions .= self::getSearchParamCondition($searchParameters);


        $register = DB::connection('appeal')
            ->select(DB::raw(
                "SELECT a.id,a.appeal_status,a.case_no,
                a.gco_name,cd.case_decision, 
                 CASE
                       WHEN a.appeal_status = 'CLOSED' THEN \" \"
                       ELSE DATE_FORMAT(cl.trial_date, '%d-%m-%Y')
                  END AS trial_date,
                CASE
                           WHEN a.appeal_status = 'CLOSED' THEN \" \"
                           ELSE cl.trial_time
                END AS trial_time,
                c.citizen_name,a.law_section AS LawSection
                FROM cause_lists cl
                JOIN (
                    SELECT xl.appeal_id, MAX(xl.id) AS maxCauseId
                    FROM cause_lists xl
                    GROUP BY xl.appeal_id
                ) xl ON xl.appeal_id = cl.appeal_id AND xl.maxCauseId = cl.id
                JOIN appeals a ON a.id = cl.appeal_id
                JOIN case_decisions AS cd ON a.case_decision_id=cd.id
                JOIN appeal_citizens ac ON ac.appeal_id=a.id AND ac.citizen_type_id=1
                JOIN citizens c ON c.id=ac.citizen_id WHERE $searchConditions AND a.office_id = $userInfo->office_id"
            ));

        return $register;

    }

    public static function getCaseWiseGeneralRegisterBySearchParam($request)
    {
        $usersPermissions = Session::get('userPermissions');
        $userInfo = Session::get('userInfo');
        $permissionBasedConditions = AppealRepository::getPermissionBasedConditions($usersPermissions);
        $searchConditions = $permissionBasedConditions;

        //search parameter
        $searchParameters = $request->searchParameter;

        $searchConditions .= self::getSearchParamCondition($searchParameters);

        $register = DB::connection('appeal')
            ->select(DB::raw(
                "SELECT a.id, a.case_no, a.upazila_name, a.loan_amount, current_paid_amount,total_paid_amount,last_trial_date, c.organization,cd.case_decision
                    FROM appeals a
                      LEFT JOIN (
                             SELECT pl.appeal_id, SUM( pl.paid_loan_amount ) AS current_paid_amount
                             FROM payment_lists pl
                             WHERE MONTH( pl.paid_date ) = MONTH( CURRENT_DATE( ) )
                             GROUP BY pl.appeal_id
                           )pl ON pl.appeal_id = a.id
                      LEFT JOIN (
                             SELECT plx.appeal_id, SUM( plx.paid_loan_amount ) AS total_paid_amount
                             FROM payment_lists plx
                             GROUP BY plx.appeal_id
                           )plx ON plx.appeal_id = a.id
                      LEFT JOIN ( SELECT xl.appeal_id,xl.trial_date FROM cause_lists xl
                      WHERE MONTH( xl.trial_date ) = MONTH(CURRENT_DATE())
                           )xl ON xl.appeal_id=a.id
                      LEFT JOIN ( SELECT cls.appeal_id, MAX(cls.trial_date) as last_trial_date FROM cause_lists cls 
                       GROUP BY cls.appeal_id       
                           )cls ON cls.appeal_id=a.id     
                      JOIN appeal_citizens ac ON ac.appeal_id=a.id AND ac.citizen_type_id=1
                      JOIN citizens c ON c.id=ac.citizen_id
                      JOIN case_decisions AS cd ON a.case_decision_id=cd.id
                      WHERE $searchConditions AND a.office_id = $userInfo->office_id
                    GROUP BY a.id"
            ));

        return $register;

    }

    public static function getCaseProgressTest()
    {

        $result1 = DB::connection('appeal')
            ->select(DB::raw(
                "SELECT a.office_id, cl.appeal_id, a.case_no as closedCaseNumber, cl.trial_date as closedCaseTrialDate, c.organization
FROM appeals a
JOIN cause_lists cl ON cl.appeal_id = a.id
JOIN appeal_citizens ac ON ac.appeal_id = a.id AND ac.citizen_type_id = 1
JOIN citizens c ON c.id = ac.citizen_id
WHERE a.office_id = 176 AND MONTH(cl.trial_date) = 2 AND YEAR(cl.trial_date) = 2018 AND cl.case_decision_id = 3"
            ));

        return $result1;

    }

    public static function getCaseProgressRegisterBySearchParam($request)
    {
        $usersPermissions = Session::get('userPermissions');
        $userInfo = Session::get('userInfo');
        $permissionBasedConditions = AppealRepository::getPermissionBasedConditions($usersPermissions);
        $searchConditions = $permissionBasedConditions;

        //search parameter
        $searchParameters = $request->searchParameter;

        if (isset($searchParameters['regiYear'])) {
            $regiYear = trim($searchParameters['regiYear']);
            $regiCurMonth = trim($searchParameters['regiMonth']);

            $regiPreMonth = $regiCurMonth-1;
        }

        $caseProgress = array();

        $searchConditions .= self::getSearchParamCondition($searchParameters);

        $result1 = DB::connection('appeal')
            ->select(DB::raw(
                "SELECT a.office_id, COUNT(a.id) AS LastMonthCaseCount, SUM(a.loan_amount) AS LastMonthCaseAmount
                 FROM appeals a WHERE a.office_id = $userInfo->office_id AND MONTH(a.case_date) = $regiPreMonth AND YEAR(a.case_date) = $regiYear"
            ));

        if($result1){
            foreach ($result1 as $res){
                $caseProgress['office_id' ]= $res->office_id;
                $caseProgress['LastMonthCaseCount' ]= $res->LastMonthCaseCount;
                $caseProgress['LastMonthCaseAmount' ]= $res->LastMonthCaseAmount;
            }
        }else{
            $caseProgress['LastMonthCaseCount' ]= 0;
            $caseProgress['LastMonthCaseAmount' ]= 0;
        }


        $result2 = DB::connection('appeal')
            ->select(DB::raw(
                "SELECT a.office_id, COUNT(a.id) AS CurrentMonthCaseCount, SUM(a.loan_amount) AS CurrentMonthCaseAmount
                    FROM appeals a WHERE a.office_id = $userInfo->office_id AND MONTH(a.case_date) = $regiCurMonth AND YEAR(a.case_date) = $regiYear"
            ));

        if($result2){
            foreach ($result2 as $res){
                $caseProgress['CurrentMonthCaseCount' ]= $res->CurrentMonthCaseCount;
                $caseProgress['CurrentMonthCaseAmount' ]= $res->CurrentMonthCaseAmount;
            }
        }else{
            $caseProgress['CurrentMonthCaseCount' ]= 0;
            $caseProgress['CurrentMonthCaseAmount' ]= 0;
        }



        $result3 = DB::connection('appeal')
            ->select(DB::raw(
                "SELECT cl.office_id, COUNT(cl.appeal_id) AS CurrentMonthClosedCaseCount
                    FROM (
                      SELECT a.office_id, cl.appeal_id
                      FROM appeals a JOIN cause_lists cl ON cl.appeal_id = a.id
                      WHERE a.office_id = $userInfo->office_id AND MONTH(cl.trial_date) = $regiCurMonth AND YEAR(cl.trial_date) = $regiYear AND cl.case_decision_id = 3
                      GROUP BY a.office_id, cl.appeal_id
                    ) cl GROUP BY cl.office_id"
            ));

        if($result3){
            foreach ($result3 as $res){
                $caseProgress['CurrentMonthClosedCaseCount' ]= $res->CurrentMonthClosedCaseCount;
            }
        }else{
            $caseProgress['CurrentMonthClosedCaseCount' ]=0;
        }


        $result4 = DB::connection('appeal')
            ->select(DB::raw("
                SELECT a.office_id, SUM(pl.paid_loan_amount) AS CurrentMonthAmountPaid
                  FROM payment_lists pl
                    JOIN appeals a ON a.id = pl.appeal_id
                    WHERE a.office_id = $userInfo->office_id AND MONTH(pl.paid_date) = $regiCurMonth AND YEAR(pl.paid_date) = $regiYear
                    GROUP BY a.office_id"
            ));

        if($result4){
            foreach ($result4 as $res){
                $caseProgress['CurrentMonthAmountPaid' ]= $res->CurrentMonthAmountPaid;
            }
        }else{
            $caseProgress['CurrentMonthAmountPaid' ]=0;
        }


        $result5 = DB::connection('appeal')
            ->select(DB::raw("SELECT a.office_id,  a.upazila_name, cl.appeal_id, a.case_no as closedCaseNumber, cl.trial_date as closedCaseTrialDate, c.organization
                    FROM appeals a
                    JOIN cause_lists cl ON cl.appeal_id = a.id
                    JOIN appeal_citizens ac ON ac.appeal_id = a.id AND ac.citizen_type_id = 1
                    JOIN citizens c ON c.id = ac.citizen_id
                    WHERE a.office_id = $userInfo->office_id AND MONTH(cl.trial_date) = $regiCurMonth AND YEAR(cl.trial_date) = $regiYear AND cl.case_decision_id = 3"
        ));

        if($result5){
            $closedCaseNumber = '';
            $closedCaseTrialDate = '';
            foreach ($result5 as $res){
                $caseProgress['upazila_name' ]= $res->upazila_name;
                $closedCaseNumber .=$res->closedCaseNumber ."<br/>";
                $caseProgress['closedCaseNumber' ]= $closedCaseNumber;
                $closedCaseTrialDate .= $res->closedCaseTrialDate ."<br/>";
                $caseProgress['closedCaseTrialDate' ]= $closedCaseTrialDate;
                $caseProgress['organization' ]= $res->organization;
            }
        }else{
            $caseProgress['upazila_name' ]=$userInfo->upazila_name_bng;
            $caseProgress['closedCaseNumber' ]= '';
            $caseProgress['closedCaseTrialDate' ]= '';
            $caseProgress['organization' ]= '';
        }

            $caseProgress['totalCaseCount' ] = $caseProgress['LastMonthCaseCount' ] + $caseProgress['CurrentMonthCaseCount' ];
            $caseProgress['totalPaidAmount' ] = $caseProgress['LastMonthCaseAmount' ] + $caseProgress['CurrentMonthCaseAmount'];
            $caseProgress['remainLoanAmount' ] = $caseProgress['totalPaidAmount' ]- $caseProgress['CurrentMonthAmountPaid' ];
            $caseProgress['totalOnTrialCaseCount' ] = $caseProgress['totalCaseCount' ]- $caseProgress['CurrentMonthClosedCaseCount' ];

        return $caseProgress;


    }
}