
    
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $page_title ?></title>
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
        .table-hover.table-bordered.report th,
        .table-hover.table-bordered.report td {
            border: 1px solid black; /* Makes cell borders bold */
        }
    </style>
</head>

<body>
	<div class="priview-body">
		<div class="priview-header">
        <div class="row">
                <div class="col-3 text-left float-left" style="border: 0px solid red; font-size:small;text-align:left;">
                    <?= en2bn(date('d-m-Y')) ?> <br><br><br>
                    বিভাগঃ <?=user_office_info()->div_name_bn?> ।

                </div>
                
                <div class="col-6 text-center float-left" style="border: 0px solid red;">
                    <p class="text-center" style="margin-top: 0;"><span style="font-size:25px;font-weight: bold;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</span><br> <span style="font-size:18">জেনারেল সার্টিফিকেট শাখা  </span></p>
                    <div style="font-size:18px;"><u><?= $page_title ?></u></div>
                    <div style="font-size:18px;"><?= en2bn($date_start) ?> থেকে <?= en2bn($date_end) ?> তারিখ পর্যন্ত</div>
                    <?php //!empty($data_status)?'ব্যাক্তিগত ডাটার স্ট্যাটাসঃ '.func_datasheet_status($data_status).'<br>':''
                    ?>
                    <?php // !empty($division_info->div_name_bn)?'বিভাগঃ '.$division_info->div_name_bn.'<br>':''
                    ?>
                </div>
                <div class="col-2 text-center float-right" style="border: 0px solid red; font-size:small; float:right;">
                    <!-- আদালতের সকল সেবা এক ঠিকানায় -->
                </div>
            </div>
        </div>

        <br> 

        <div class="priview-demand">
            <table class="table table-hover table-bordered report">
                <thead class="headding">
                    <tr>
                        <th class="text-center" width="50">ক্রম</th>
                        <th class="text-left">জেলার নাম</th>
                        <th class="text-center">জেনারেল সার্টিফিকেট অফিসারের আদালতে বিচারাধীন মামলা</th>
                        <th class="text-center">অতিরিক্ত জেলা প্রশাসক (রাজস্ব) এর আদালতে বিচারাধীন আপিল মামলা</th>
                        <th class="text-center">অতিরিক্ত বিভাগীয় কমিশনার (রাজস্ব) এর আদালতে বিচারাধীন আপিল মামলা</th>
                        <th class="text-center">সার্টিফিকেট অফিসারের আদালতে গ্রহনের জন্য অপেক্ষমাণ রিকুইজিশন</th>
                        <th class="text-center">সার্টিফিকেট সহকারীর গ্রহনের জন্য অপেক্ষমাণ রিকুইজিশন</th>
                        <th class="text-center">অতিরিক্ত বিভাগীয় কমিশনার (রাজস্ব) এর আদালতে নিস্পত্তিকৃত আপিল মামলা</th>
                        <th class="text-center">অতিরিক্ত জেলা প্রশাসক (রাজস্ব) এর  আদালতে নিস্পত্তিকৃত আপিল মামলা</th>
                        <th class="text-center">জেনারেল সার্টিফিকেট আদালতে নিস্পত্তিকৃত মোট মামলা</th>

                        
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = $grandTotal = 0;
                    $RUNNING_CASE_AT_GCO=$RUNNING_APPEAL_CASE_AT_ADC=$RUNNING_APPEAL_CASE_AT_ADIVC=$PANDING_CASE_AT_GCO=$PANDING_CASE_AT_ASST_GCO=$CLOSED_APPEAL_CASE_AT_ADIVC=$CLOSED_APPEAL_CASE_AT_ADC=$CLOSED_CASE_AT_GCC=0;
                    foreach ($results as $row) {
                        
                        $RUNNING_CASE_AT_GCO += $row['RUNNING_CASE_AT_GCO'];
                        $RUNNING_APPEAL_CASE_AT_ADC += $row['RUNNING_APPEAL_CASE_AT_ADC'];
                        $RUNNING_APPEAL_CASE_AT_ADIVC += $row['RUNNING_APPEAL_CASE_AT_ADIVC'];
                        $PANDING_CASE_AT_GCO += $row['PANDING_CASE_AT_GCO'];
                        $PANDING_CASE_AT_ASST_GCO += $row['PANDING_CASE_AT_ASST_GCO'];
                        $CLOSED_APPEAL_CASE_AT_ADIVC += $row['CLOSED_APPEAL_CASE_AT_ADIVC'];
                        $CLOSED_APPEAL_CASE_AT_ADC += $row['CLOSED_APPEAL_CASE_AT_ADC'];
                        $CLOSED_CASE_AT_GCC += $row['CLOSED_CASE_AT_GCC'];

                        $i++;
                    ?>
                        <tr>
                            <td class="text-center"><?= en2bn($i) ?>.</td>
                            <td class="text-left"><?= $row['district_name_bn'] ?></td>
                            <td class="text-center"><?= en2bn($row['RUNNING_CASE_AT_GCO']) ?></td>
                            <td class="text-center"><?= en2bn($row['RUNNING_APPEAL_CASE_AT_ADC']) ?></td>
                            <td class="text-center"><?= en2bn($row['RUNNING_APPEAL_CASE_AT_ADIVC']) ?></td>
                            <td class="text-center"><?= en2bn($row['PANDING_CASE_AT_GCO']) ?></td>
                            <td class="text-center"><?= en2bn($row['PANDING_CASE_AT_ASST_GCO']) ?></td>
                            <td class="text-center"><?= en2bn($row['CLOSED_APPEAL_CASE_AT_ADIVC']) ?></td>
                            <td class="text-center"><?= en2bn($row['CLOSED_APPEAL_CASE_AT_ADC']) ?></td>
                            <td class="text-center"><?= en2bn($row['CLOSED_CASE_AT_GCC']) ?></td>
                            
                        </tr>
                    <?php } ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td>সর্বমোট</td>
                                <td class="text-center"><?= en2bn($RUNNING_CASE_AT_GCO) ?></td>
                                <td class="text-center"><?= en2bn($RUNNING_APPEAL_CASE_AT_ADC) ?></td>
                                <td class="text-center"><?= en2bn($RUNNING_APPEAL_CASE_AT_ADIVC) ?></td>
                                <td class="text-center"><?= en2bn($PANDING_CASE_AT_GCO) ?></td>
                                <td class="text-center"><?= en2bn($PANDING_CASE_AT_ASST_GCO) ?></td>
                                <td class="text-center"><?= en2bn($CLOSED_APPEAL_CASE_AT_ADIVC) ?></td>
                                <td class="text-center"><?= en2bn($CLOSED_APPEAL_CASE_AT_ADC) ?></td>
                                <td class="text-center"><?= en2bn($CLOSED_CASE_AT_GCC) ?></td>

                                

                      
                            </tr>
                </tbody>

            </table>
        </div>

    </div>

</body>

</html>
