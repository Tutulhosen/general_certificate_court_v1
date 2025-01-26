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

		.text-left {
			text-align: left;
		}

		.float-left {
			float: left;
		}

		.float-right {
			float: right;
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
					<p class="text-center" style="margin-top: 0;"><span style="font-size:25px;font-weight: bold;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</span><br> <span style="font-size:small">জেনারেল সার্টিফিকেট শাখা </span></p>
					<p style="padding-top: -15px;">জেলাঃ <?= $dis_data ?></p>
					<div style="font-size:18px; padding-top: -15px;"><u><?= $page_title ?></u></div>
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

		<div class="priview-memorandum">
			<div class="row">
				<div class="col-6 text-left float-left">
					<!-- স্মারক নং -->
				</div>
			</div>
		</div>

		<div class="priview-demand">
			<table class="table table-hover table-bordered report">
				<thead class="headding">
					<tr>
						<th class="text-center" width="50" rowspan="2">ক্রম</th>

						<th class="text-center">১</th>
						<th class="text-center">২</th>
						<th class="text-center">৩</th>
						<th class="text-center">৪</th>
						<th class="text-center">৫</th>
						<th class="text-center">৬</th>
						<th class="text-center">৭</th>
						<th class="text-center">৮</th>
						<th class="text-center">৯</th>
						<th class="text-center">১০</th>
						<th class="text-center">১১</th>

					</tr>
					<tr>
						<!-- <th class="text-center" width="50">ক্রম</th> -->
						<th class="text-left">উপজেলার নাম</th>
						<th class="text-center">গত মাস পর্যন্ত অনিষ্পন্ন মামলার সংখ্যা</th>
						<th class="text-center"> দাবির পরিমাণ<br> (টাকা)</th>
						<th class="text-center">চলতি মাসে নতুন দায়েরকৃত মামলা</th>
						<th class="text-center"> দাবির পরিমাণ<br> (টাকা)</th>
						<th class="text-center">মোট মামলার সংখ্যা<br>(২+৪) </th>
						<th class="text-center">মোট দাবির পরিমাণ<br>(৩+৫)</th>
						<th class="text-center">নিষ্পত্তিকৃত মামলার সংখ্যা</th>
						<th class="text-center">আদায়ের পরিমাণ<br>(আলোচ্য মাস)</th>
						<th class="text-center">অনিষ্পন্ন মামলার সংখ্যা<br>(৬-৮)</th>
						<th class="text-center">দাবির পরিমাণ(টাকা)<br>(৭-৯)</th>

					</tr>
				</thead>
				<tbody>
					<?php
					$ON_TRIAL_PREV_MONTH = $TOTAL_LOAN_PREV_MONTH = $ON_TRIAL_CRNT_MONTH = $TOTAL_LOAN_CRNT_MONTH = $ttotal_case = $ttotal_loan = $TOTAL_CLOSE_CASE = $TOTAL_COLLECT_CRNT_MONTH = $ttotal_due_case = $ttotal_due_loan = 0;
					$i = $grandTotal = 0;
					foreach ($results as $row) {
						$total_case = $row['ON_TRIAL_PREV_MONTH'] + $row['ON_TRIAL_CRNT_MONTH'];
						$total_loan = $row['TOTAL_LOAN_PREV_MONTH'] + $row['TOTAL_LOAN_CRNT_MONTH'];
						$total_due_case = $total_case - $row['TOTAL_CLOSE_CASE'];
						$total_due_loan = $total_loan - $row['TOTAL_COLLECT_CRNT_MONTH'];

						$ON_TRIAL_PREV_MONTH += $row['ON_TRIAL_PREV_MONTH'];
						$TOTAL_LOAN_PREV_MONTH += $row['TOTAL_LOAN_PREV_MONTH'];
						$ON_TRIAL_CRNT_MONTH += $row['ON_TRIAL_CRNT_MONTH'];
						$TOTAL_LOAN_CRNT_MONTH += $row['TOTAL_LOAN_CRNT_MONTH'];
						$ttotal_case += $total_case;
						$ttotal_loan += $total_loan;
						$TOTAL_CLOSE_CASE += $row['TOTAL_CLOSE_CASE'];
						$TOTAL_COLLECT_CRNT_MONTH += $row['TOTAL_COLLECT_CRNT_MONTH'];
						$ttotal_due_case += $total_due_case;
						$ttotal_due_loan += $total_due_loan;
						$i++;
					?>
						<tr>
							<td class="text-center"><?= en2bn($i) ?>.</td>
							<td class="text-left"><?= $row['upazila_name_bn'] ?></td>
							<td class="text-center"><?= en2bn($row['ON_TRIAL_PREV_MONTH']) ?></td>
							<td class="text-center"><?= en2bn($row['TOTAL_LOAN_PREV_MONTH']) ?></td>
							<td class="text-center"><?= en2bn($row['ON_TRIAL_CRNT_MONTH']) ?></td>
							<td class="text-center"><?= en2bn($row['TOTAL_LOAN_CRNT_MONTH']) ?></td>
							<td class="text-center"><?= en2bn($total_case) ?></td>
							<td class="text-center"><?= en2bn($total_loan) ?></td>
							<td class="text-center"><?= en2bn($row['TOTAL_CLOSE_CASE']) ?></td>
							<td class="text-center"><?= en2bn($row['TOTAL_COLLECT_CRNT_MONTH']) ?></td>
							<td class="text-center"><?= en2bn($total_due_case) ?></td>
							<td class="text-center"><?= en2bn($total_due_loan) ?></td>

						</tr>
					<?php } ?>
					<tr>
						<td>&nbsp;</td>
						<td>সর্বমোট</td>
						<td class="text-center"><?= en2bn($ON_TRIAL_PREV_MONTH) ?></td>
						<td class="text-center"><?= en2bn($TOTAL_LOAN_PREV_MONTH) ?></td>
						<td class="text-center"><?= en2bn($ON_TRIAL_CRNT_MONTH) ?></td>
						<td class="text-center"><?= en2bn($TOTAL_LOAN_CRNT_MONTH) ?></td>
						<td class="text-center"><?= en2bn($ttotal_case) ?></td>
						<td class="text-center"><?= en2bn($ttotal_loan) ?></td>
						<td class="text-center"><?= en2bn($TOTAL_CLOSE_CASE) ?></td>
						<td class="text-center"><?= en2bn($TOTAL_COLLECT_CRNT_MONTH) ?></td>
						<td class="text-center"><?= en2bn($ttotal_due_case) ?></td>
						<td class="text-center"><?= en2bn($ttotal_due_loan) ?></td>

					</tr>
				</tbody>
			</table>
		</div>

	</div>

</body>

</html>