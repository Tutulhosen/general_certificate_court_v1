<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<style type="text/css">
		.priview-body{font-size: 16px;color:#000;margin: 25px;}
		.priview-header{margin-bottom: 10px;text-align:center;}
		.priview-header div{font-size: 18px;}
		.priview-memorandum, .priview-from, .priview-to, .priview-subject, .priview-message, .priview-office, .priview-demand, .priview-signature{padding-bottom: 20px;}
		.priview-office{text-align: center;}
		.priview-imitation ul{list-style: none;}
		.priview-imitation ul li{display: block;}
		.date-name{width: 20%;float: left;padding-top: 23px;text-align: right;}
		.date-value{width: 70%;float:left;}
		.date-value ul{list-style: none;}
		.date-value ul li{text-align: center;}
		.date-value ul li.underline{border-bottom: 1px solid black;}
		.subject-content{text-decoration: underline;}
		.headding{border-top:1px solid #000;border-bottom:1px solid #000;}

		.col-1{width:8.33%;float:left;}
		.col-2{width:16.66%;float:left;}
		.col-3{width:25%;float:left;}
		.col-4{width:33.33%;float:left;}
		.col-5{width:41.66%;float:left;}
		.col-6{width:50%;float:left;}
		.col-7{width:58.33%;float:left;}
		.col-8{width:66.66%;float:left;}
		.col-9{width:75%;float:left;}
		.col-10{width:83.33%;float:left;}
		.col-11{width:91.66%;float:left;}
		.col-12{width:100%;float:left;}

		.table{width:100%;border-collapse: collapse;}
		.table td, .table th{border:1px solid #ddd;}
		.table tr.bottom-separate td,
		.table tr.bottom-separate td .table td{border-bottom:1px solid #ddd;}
		.borner-none td{border:0px solid #ddd;}
		.headding td, .total td{border-top:1px solid #ddd;border-bottom:1px solid #ddd;}
		.table td{padding:5px;}
		.text-center{text-align:center;}
		.text-right{text-align:right;}
		.text-left{text-align:left;}
		.float-left{float: left;}
		.float-right{float: right;}
		b{font-weight:500;}
	</style>
</head>
<body>
	<div class="priview-body">
		<div class="priview-header">
			
				<?php foreach($appealOrderLists as $key=>$row){?>
               <div class="contentForm" style="font-size: medium;">
                <?php if($key == 0){?>
                <div id="head">
                    <?php echo nl2br($row->order_header); ?>
                </div>
                <?php } ?>
                <?php }?>

			
	    </div>
		

		<div class="priview-demand">

	       	<table  border="1" width="1200px" autosize="0">
                        <thead>
							<tr>
								<td valign="middle" width="5%" align="center"> আদেশের ক্রমিক নং ও তারিখ</td>
								<td valign="middle" width="75%" align="center"> আদেশ ও অফিসারের স্বাক্ষর</td>
								<td valign="middle" width="10%" align="center"> আদেশের উপর গৃহীত ব্যবস্থা</td>
							</tr>
                        </thead>
                        <?php foreach($appealOrderLists as $key=>$row){?>
                        
                            <?php echo $row->order_detail_table_body; ?>
                        
                        <?php }?>
                    </table>
				
		</div>

	</div>

</body>
</html>
