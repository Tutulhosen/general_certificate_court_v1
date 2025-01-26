use Illuminate\Support\Facades\DB;
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?=$page_title?></title>
    <style type="text/css">
        .priview-body {
            font-size: 16px;
            color: #000;
            margin: 25px;
        }

        .priview-header {
            margin-bottom: 10px;
            text-align: center;
        }

        .priview-header div {
            font-size: 18px;
        }

        .priview-memorandum,
        .priview-from,
        .priview-to,
        .priview-subject,
        .priview-message,
        .priview-office,
        .priview-demand,
        .priview-signature {
            padding-bottom: 20px;
        }

        .priview-office {
            text-align: center;
        }

        .priview-imitation ul {
            list-style: none;
        }

        .priview-imitation ul li {
            display: block;
        }

        .date-name {
            width: 20%;
            float: left;
            padding-top: 23px;
            text-align: right;
        }

        .date-value {
            width: 70%;
            float: left;
        }

        .date-value ul {
            list-style: none;
        }

        .date-value ul li {
            text-align: center;
        }

        .date-value ul li.underline {
            border-bottom: 1px solid black;
        }

        .subject-content {
            text-decoration: underline;
        }

        .headding {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .col-1 {
            width: 8.33%;
            float: left;
        }

        .col-2 {
            width: 16.66%;
            float: left;
        }

        .col-3 {
            width: 25%;
            float: left;
        }

        .col-4 {
            width: 33.33%;
            float: left;
        }

        .col-5 {
            width: 41.66%;
            float: left;
        }

        .col-6 {
            width: 50%;
            float: left;
        }

        .col-7 {
            width: 58.33%;
            float: left;
        }

        .col-8 {
            width: 66.66%;
            float: left;
        }

        .col-9 {
            width: 75%;
            float: left;
        }

        .col-10 {
            width: 83.33%;
            float: left;
        }

        .col-11 {
            width: 91.66%;
            float: left;
        }

        .col-12 {
            width: 100%;
            float: left;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td,
        .table th {
            border: 1px solid #ddd;
        }

        .table tr.bottom-separate td,
        .table tr.bottom-separate td .table td {
            border-bottom: 1px solid #ddd;
        }

        .borner-none td {
            border: 0px solid #ddd;
        }

        .headding td,
        .total td {
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        .table td {
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        b {
            font-weight: 500;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div class="priview-body">
        <div class="priview-header">
            <div class="row">
                <div class="col-3 text-left float-left">
                    <?=en2bn(date('d-m-Y'))?>
                </div>
                <div class="col-12 text-center float-left">
                    <p class="text-center" style="margin-top: 0;"><span style="font-size:20px;font-weight: bold;">জেনারেল
                            সার্টিফিকেট আদালত</span><br> মন্ত্রিপরিষদ বিভাগ, বাংলাদেশ সচিবালয়, ঢাকা</p>
                    <!-- <div style="font-size:18px;"><u><?=$page_title?></u></div> -->
                    <?php

if ($_GET['printHeading'] != '' && $_GET['date_start'] != '') {
    ?>
                    <div class="card-title" style="text-align: center;">
                        <h3 class="card-title h2 font-weight-bolder"><?=$_GET['printHeading']?></h3>
                        <h4 class="card-title h4 font-weight-bolder"><?=en2bn($_GET['date_start'])?> হতে
                            <?=en2bn($_GET['date_end'])?></h4>
                    </div>
                    <?php
} elseif ($_GET['printHeading'] != '' && $_GET['date_start'] == '') {
    ?>
                    <div class="card-title" style="text-align: center;">
                        <h3 class="card-title h2 font-weight-bolder"><?=$_GET['printHeading']?></h3>
                    </div>
                    <?php
} else {
    ?>
                    <div class="card-title" style="text-align: center;">
                        <h3 class="card-title h2 font-weight-bolder"><?=$page_title?></h3>
                    </div>
                    <?php
}

?>





                </div>
            </div>
        </div>


        <div class="priview-demand">
            <table>
                <thead class="headding" border="2px">
                    <tr>
                        <?php
if (isset($req['kromikNo'])) {
    ?>
                        <th class="serialNo" scope="col" width="30"> ক্রমিক নম্বর</th>
                        <?php
}

if (isset($req['appealStatus'])) {
    ?>
                        <th class="appealStat" scope="col">আপিল অবস্থা</th>
                        <?php
}

if (isset($req['caseNo'])) {
    ?>
                        <th class="caseNum" scope="col">মামলা নম্বর</th>
                        <?php
}

if (isset($req['caseDecision'])) {
    ?>
                        <th class="caseResult" scope="col">মামলার সিদ্ধান্ত</th>
                        <?php
}

if (isset($req['relatedCourt'])) {
    ?>
                        <th class="courtName" scope="col">সংশ্লিষ্ট আদালত</th>
                        <?php

}

if (isset($req['nextHearingDate'])) {
    ?>
                        <th class="nxtSunaniDate" scope="col">পরবর্তী শুনানীর তারিখ</th>
                        <?php
}

if (isset($req['nextHearingTime'])) {
    ?>
                        <th class="nxtSunaniTime" scope="col">পরবর্তী শুনানীর সময়</th>
                        <?php

}

if (isset($req['appellantName'])) {
    ?>
                        <th class="applicantName" scope="col">আপীলকারীর নাম</th>
                        <?php

}

if (isset($req['ruleName'])) {
    ?>
                        <th class="lawName" scope="col"> লঙ্ঘিত আইন ও ধারা</th>
                        <?php
}

?>
                    </tr>
                </thead>
                <tbody>
                    <?php
foreach ($results as $key => $row) {
    ?>
                    <tr>
                        <?php
if (isset($req['kromikNo'])) {
        ?>
                        <td scope="row" class="tg-bn serialNo"><?=en2bn($key + 1)?>.</td>
                        <?php
}

    ?>
                        <?php
if (isset($req['appealStatus'])) {
        ?>
                        <td class="appealStat"><?=appeal_status_bng($row->appeal_status)?></td>
                        <?php
}

    ?>
                        <?php
if (isset($req['caseNo'])) {
        ?>
                        <td class="caseNum"><?=$row->case_no?></td>
                        <?php
}

    ?>
                        <?php
if (isset($req['caseDecision'])) {
        ?>
                        <td class="caseResult"><?=case_dicision_status_bng($row->appeal_status)?></td>
                        <?php
}

    ?>
                        <?php
if (isset($req['relatedCourt'])) {
        ?>
                        <td class="courtName"><?=isset($row->court->court_name) ? $row->court->court_name : '-'?></td>
                        <?php
}

    ?>
                        <?php
if (isset($req['nextHearingDate'])) {
        ?>
                        <td class="nxtSunaniDate">

                            <?php
$hearingDate = null;

        foreach ($row->appealCauseList as $key => $item) {
            if ($item->trial_date == '1970-01-01') {
                $hearingDate = '  ---  ';
            } else {
                $hearingDate = $item->trial_date;
            }
        }

        if (isset($hearingDate)) {
            echo en2bn($hearingDate);
        } else {
            echo '--';
        }

        ?>
                        </td>
                        <?php
}

    ?>
                        <?php
if (isset($req['nextHearingTime'])) {
        ?>
                        <td class="nxtSunaniTime">
                            <?php
$hearingTime = null;
        ?>
                            <?php
foreach ($row->appealCauseList as $key => $item) {
            if (date('a', strtotime($item->trial_time)) == 'am') {
                $time = 'সকাল';
            } else {
                $time = 'বিকাল';
            }

            if (isset($item->trial_time) && $item->trial_date != '1970-01-01') {
                $hearingTime = $time . ' ' . en2bn(date('h:i', strtotime($item->trial_time)));
            } else {
                $hearingTime = '----';
            }
        }

        if (isset($hearingTime)) {
            echo $hearingTime;
        } else {
            echo '--';
        }
        ?>

                        </td>
                        <?php
}
    ?>
                        <?php

    ?>
                        <?php
if (isset($req['appellantName'])) {
        ?>
                        <td class="applicantName">

                            <?php
$appName = null;
        ?>
                            <?php
foreach ($row->appealCitizens as $key => $item) {
            foreach ($item->citizenType as $i => $it) {
                if ($it->citizen_type == 'applicant') {
                    foreach ($item->citizensAppealJoin as $activeCheck) {
                        if ($activeCheck->active == 1 && $appName == null && $row->id == $activeCheck->appeal_id) {
                            $appName = $item->citizen_name;
                        }
                    }
                }
            }
        }

        if (isset($appName)) {
            echo $appName;
        } else {
            echo '  ';
        }

        ?>
                        </td>

                        <?php
}
    ?>

                        <?php

    ?>








                    </tr>
                    <?php

    if (isset($req['ruleName'])) {
        ?>
                    <td class="lawName"><?=$row->law_section?></td>
                    <?php
}

}

?>
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>
