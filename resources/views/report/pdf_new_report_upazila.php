
    
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
                    <?= en2bn(date('d-m-Y')) ?>
                </div>
                <div class="col-6 text-center float-left" style="border: 0px solid red;">
                    <p class="text-center" style="margin-top: -10;"><span style="font-size:25px;font-weight: bold;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</span><br> <span style="font-size:18">জেনারেল সার্টিফিকেট শাখা  </span></p>
					<div style="font-size:18px; margin-top:-10px"><u><?= $page_title ?></u></div>
                    <div style="font-size:18px; margin-top:-10px"><u><?= en2bn($year) ?></u></div>
					<p class="text-center" style="font-size:18; margin-top:10px">বিভাগঃ 
					<?php 
						if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 8) {
							echo get_divison_name($division)->division_name_bn;
						} else {
							echo get_divison_name(user_division())->division_name_bn;
						}
					?>
					 , জেলাঃ  
					 <?php 
						if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 8 || globalUserInfo()->role_id == 34) {
							echo get_district_name($district)->district_name_bn;
						} else {
							echo get_district_name(user_district()->id)->district_name_bn;
						}
					?>
					  , উপজেলাঃ  <?= get_upazila_name($upazila)->upazila_name_bn ?></p>
				
					
                </div>
           
            </div>
        </div>

        

        <div class="priview-demand">
            <table class="table table-hover table-bordered report" >
                <thead class="headding">
                <tr>
						<th class="text-center" width="50" rowspan="2" >ক্রম</th>
						
						<th class="text-center">১</th>
						<th class="text-center">২</th>
						<th class="text-center">৩</th>
						<th class="text-center">৪</th>
						<th class="text-center">৫</th>
						<th class="text-center">৬</th>
						<th class="text-center">৭</th>

			

					</tr>
                    <tr>

                        <th class="text-left">তারিখ</th>
                        <th class="text-center">প্রতিষ্ঠানিক প্রতিনিধি কর্তৃক রিকুইজিশন সাবমিট </th>
                        <th class="text-center"> সার্টিফিকেট সহকারী কর্তৃক আবেদন উপস্থাপন</th>
                        <th class="text-center"> জেনারেল সার্টিফিকেট অফিসার কর্তৃক গ্রহণকৃত মামলা</th>
                        <th class="text-center"> আজকের দিনের পরিচালিত মামলা </th>
                        <th class="text-center">মোট দায়েরকৃত দাবি </th>
                        <th class="text-center">মোট আদায়কৃত দাবি</th>
                        
                        
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = $grandTotal = 0;
                    $submit_by_org=$present_by_gco_asst=$accept_by_gco=$today_action=$total_claimed_amount=$total_recieved_amount=0;
                    foreach ($results as $row) {

                        $submit_by_org += $row['submit_by_org'];
                        $present_by_gco_asst += $row['present_by_gco_asst'];
                        $accept_by_gco += $row['accept_by_gco'];
                        $today_action += $row['today_action'];
                        $total_claimed_amount += $row['total_claimed_amount'];
                        $total_recieved_amount += $row['total_recieved_amount'];
                      
                        

                        $i++;
                    ?>
                        <tr>
                            <td class="text-center"><?= en2bn($i) ?>.</td>
                            <td class="text-left"><?= en2bn($row['date_range']) ?></td>
                            <td class="text-center"><?= en2bn($row['submit_by_org']) ?></td>
                            <td class="text-center"><?= en2bn($row['present_by_gco_asst']) ?></td>
                            <td class="text-center"><?= en2bn($row['accept_by_gco']) ?></td> 
                            <td class="text-center"><?= en2bn($row['today_action']) ?></td>
                            <td class="text-center"><?= en2bn($row['total_claimed_amount']) ?></td>
                            <td class="text-center"><?= en2bn($row['total_recieved_amount']) ?></td>
                            
                          
                            
                        </tr>
                    <?php } ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td>সর্বমোট</td>
                                <td class="text-center"><?= en2bn($submit_by_org) ?></td>
                                <td class="text-center"><?= en2bn($present_by_gco_asst) ?></td>
                                <td class="text-center"><?= en2bn($accept_by_gco) ?></td>
                                <td class="text-center"><?= en2bn($today_action) ?></td>
                                <td class="text-center"><?= en2bn($total_claimed_amount) ?></td>
                                <td class="text-center"><?= en2bn($total_recieved_amount) ?></td>
                      
                            </tr>
                </tbody>

            </table>
        </div>

    </div>

</body>

</html>
