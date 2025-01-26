<?php use Illuminate\Support\Facades\DB; ?>
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

                    table, th, td {
            border: 1px solid;
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
                    <?= en2bn(date('d-m-Y')) ?>
                </div>
                <div class="col-6 text-center float-left" style="border: 0px solid red;">
                    <p class="text-center" style="margin-top: 0;"><span
                            style="font-size:25px;font-weight: bold;">জেনারেল সার্টিফিকেট আদালত</span><br> <span
                            style="font-size:small">মন্ত্রিপরিষদ বিভাগ, বাংলাদেশ সচিবালয়, ঢাকা</span></p>
                    <!-- <div style="font-size:18px;"><u><?= $page_title ?></u></div> -->
                    <?php //!empty($data_status)?'ব্যাক্তিগত ডাটার স্ট্যাটাসঃ '.func_datasheet_status($data_status).'<br>':''
                    ?>
                    <?php // !empty($division_info->div_name_bn)?'বিভাগঃ '.$division_info->div_name_bn.'<br>':''
                    ?>
                </div>
                <div class="col-2 text-center float-right" style="border: 0px solid red; font-size:small; float:right;">
                    আদালতের সকল সেবা এক ঠিকানায়
                </div>
            </div>
        </div>

        <div class="priview-memorandum">
            <div class="row">
                <div class="col-12 text-center">
                    <div style="font-size:18px;"><u><?= $page_title ?></u></div>
                    <div style="font-size:18px;"><u><?= en2bn(date('Y')) ?></u></div>
                    <?php //!empty($data_status)?'ব্যাক্তিগত ডাটার স্ট্যাটাসঃ '.func_datasheet_status($data_status).'<br>':''
                    ?>
                    <?php // !empty($division_info->div_name_bn)?'বিভাগঃ '.$division_info->div_name_bn.'<br>':''
                    ?>

                </div>
            </div>
        </div>

        <div class="priview-demand">
            <div class="row">
                <div class="col-md-12">

                </div>

                <div class="col-md-5">
                    <h5><span class="font-weight-bolder">মামলা নং: </span><?= en2bn($info->case_no) ?></h5>
                    <h5><span class="font-weight-bolder">আদালতের নাম: </span> <?= $info->court_name ?></h5>
                    <h5><span class="font-weight-bolder">জেলা: </span> <?= $info->district_name_bn ?></h5>
                    <h5><span class="font-weight-bolder">উপজেলা: </span> <?= $info->upazila_name_bn ?></h5>
                    <h5><span class="font-weight-bolder">বিভাগ: </span> <?= $info->division_name_bn ?></h5>
                    <?php 
                        
                        if (isset($lawerCitizen[0]['citizen_name']) > 0)
                        {
                            ?>
                    <h5><span class="font-weight-bolder">উত্তরাধিকারের বিবরণ:</span></h5>
                    <table class="table">
                        <tr>
                            <th scope="row" width="10">ক্রম</th>
                            <th scope="row" width="200">নাম</th>
                            <th scope="row">পিতা/স্বামীর নাম</th>

                            <th scope="row">ঠিকানা</th>
                        </tr>
                        

                        

                        <?php $k = 1; 
                                foreach ($lawerCitizen as $nominee)
                                {
                                     ?>
                                     <tr>
                                     <td><?= en2bn($k) ?>.</td>
                     <td><?= $nominee->citizen_name ?? '-' ?></td>
                     <td><?= $nominee->father ?? '-' ?></td>
                     <td><?= $nominee->organization ?? '-' ?></td>
                     </tr>
                                     <?php
                                      $k++; 
                                }
                                ?>
                    </table>
                    <?php
                        }
                        ?>
                </div>
                <div class="col-md-7">
                    <h5>
                        <span class="font-weight-bolder">মামলার ফলাফল:</span>
                        <?php
                            switch ($info->appeal_status) {
                                case 'ON_TRIAL':
                                    echo 'বিচারাধীন';
                                    break;
                                case 'SEND_TO_GCO':
                                    echo 'গ্রহণের জন্য অপেক্ষমান (জিসিও) ';
                                    break;
                                case 'SEND_TO_ASST_GCO':
                                    echo 'গ্রহণের জন্য অপেক্ষমান (সার্টিফিকেট সহকারী)';
                                    break;
                                case 'SEND_TO_DC':
                                    echo 'গ্রহণের জন্য অপেক্ষমান (জেলা প্রশাসক)';
                                    break;
                                case 'SEND_TO_DIV_COM':
                                    echo 'গ্রহণের জন্য অপেক্ষমান (বিভাগীয় কমিশনার)';
                                    break;
                                case 'SEND_TO_NBR_CM':
                                    echo 'গ্রহণের জন্য অপেক্ষমান (এলএবি চেয়ারম্যান)';
                                    break;
                                case 'CLOSED':
                                    echo 'নিষ্পন্ন';
                                    break;
                                case 'REJECTED':
                                    echo 'খারিজকৃত';
                                    break;
                            
                                default:
                                    echo 'Unknown';
                                    break;
                            }
                        ?>
                    </h5>
                    <h5><span class="font-weight-bolder">ধারকের বিবরণ:</span></h5>
                    <?php $k = 1; ?>
                    <table class="table">
                        <tr>
                            <th scope="row" width="10">ক্রম</th>
                            <th scope="row" width="200">নাম</th>
                            <th scope="row">পিতা/স্বামীর নাম</th>
                            <th scope="row">প্রাতিষ্ঠানিক আইডি</th>
                            <th scope="row">ঠিকানা</th>
                        </tr>
                        <?php
                        foreach ($applicantCitizen as $badi)
                        {
                            ?>
                             <tr>
                                <td><?= en2bn($k) ?>.</td>
                                <td> <?= $badi->citizen_name ?? '-' ?></td>
                                <td> <?= $badi->father ?? '-' ?></td>
                                <td> <?= $badi->organization_id ?? '-' ?></td>
                                <td><?= $badi->organization ?? '-' ?></td>
                            </tr>
                            <?php
                            $k++;
                        }
                        ?>
                    </table>

                    <h5><span class="font-weight-bolder">খাতকের বিবরণ:</span></h5>
                    <?php $k = 1; ?>
                    <table class="table">
                        <tr>
                            <th scope="row" width="10">ক্রম</th>
                            <th scope="row" width="200">নাম</th>
                            <th scope="row">পিতা/স্বামীর নাম</th>

                            <th scope="row">ঠিকানা</th>
                        </tr>
                        <?php $k = 1; ?>

                        <tr>
                            <td><?= en2bn($k) ?>.</td>
                            <td><?= $defaulterCitizen->citizen_name ?? '-' ?></td>
                            <td><?= $defaulterCitizen->father ?? '-' ?></td>
                            <td><?= $defaulterCitizen->organization ?? '-' ?></td>
                        </tr>
                        <?php  $k++; ?>
                    </table>

                    <?php if (isset($nomineeCitizen[0]['citizen_name']) > 0)
                    {
                        ?>
                         <h5><span class="font-weight-bolder">উত্তরাধিকারের বিবরণ:</span></h5>
                        <table class="table">
                            <tr>
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="200">নাম</th>
                                <th scope="row">পিতা/স্বামীর নাম</th>

                                <th scope="row">ঠিকানা</th>
                            </tr>
                            <?php $k = 1; ?>
                            <?php foreach ($nomineeCitizen as $nominee)
                            {
                                 ?>
                                 <tr>
                                    <td><?= en2bn($k) ?>.</td>
                                    <td><?= $nominee->citizen_name ?? '-' ?></td>
                                    <td><?= $nominee->father ?? '-' ?></td>
                                    <td><?= $nominee->organization ?? '-' ?></td>
                                </tr>
                                 <?php
                                 $k++;
                            }
                                
                                 
                                 ?>
                        
                        </table>
                

                        <?php
                    }
                      ?>  
                           
                </div>

                <div class="col-md-12" style="margin-top: 25px;padding-top:50px; word-spacing: 10px">
                    <table class="tg">
                        <thead>
                            <tr>
                                <th class="font-weight-bolder">তারিখ ও সময়</th>
                                <th class="font-weight-bolder">ব্যবহারকারীর নাম</th>
                                <th class="font-weight-bolder">ব্যবহারকারীর পদবি</th>
                                <th class="font-weight-bolder">অ্যাক্টিভিটি</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            foreach ($case_details as $case_details_single){
                                $user_name = DB::table('users')
                                ->select('name')
                                ->where('id', '=', $case_details_single->user_id)
                                ->first();
                            
                           
                            ?>

                                <tr>

                                <td><?= en2bn($case_details_single->created_at) ?></td>
                                <td><?= $user_name->name ?></td>
                                <td><?= $case_details_single->designation ?></td>
                                <td><?php
                                    echo $case_details_single->activity;
                                    echo '<br>';
                                    if (!empty($case_details_single->files)) {
                                        $files = json_decode($case_details_single->files);
                                        
                                        echo ' যে যে ফাইল আপলোড হয়েছে ';
                                        echo '<br>';

                                        if(!empty($files->file_path))
                                        {
                                            echo 'জারিকারের রিপোর্ট ফাইল';
                                        }
                                        else
                                        {

                                            foreach ($files as $file) {
                                                
                                                    echo " ফাইলের নাম ".'<strong style="color: green">'.$file->file_category.'</strong>'.'  '; 
                                                    
                                            }
                                        }
                                        }
                                    
                                ?></td>
                                </tr>
                            
                            <?php
                            }
                              ?>  
                                
                            

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
