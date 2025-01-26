@php
   $roleID = Auth::user()->role_id;
   $signature = Auth::user()->signature;
   $officeInfo = user_office_info();
@endphp
<!DOCTYPE html>
<html>
<head>
   <title><?=$page_title?></title>
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
      /*.table tr {line-height: 30px;}*/
      .borner-none td{border:0px solid #ddd;}
      .headding td, .total td{border-top:1px solid #ddd;border-bottom:1px solid #ddd;}
      .table td{padding:5px;}
      .text-center{text-align:center;}
      .text-right{text-align:right;}
      b{font-weight:500;}
   </style>
</head>
<body>

   <div class="priview-body">
      <div class="priview-header">
         <p class="text-center"><span style="font-size:20px;">কারণ দর্শাইবার জবাব</span><br>
            <span style="font-size:12px;">মোকামঃ {{ $info->court_name }}</span>  <br>
            <b>বিষয়ঃ</b> দেওয়ানী মোকাদ্দমা নং {{ $info->case_number }} এর প্যারাভিত্তিক জবাব প্রেরণ প্রসঙ্গে 
         </p>
      </div>
      <div class="priview-memorandum"></div>

      <div class="priview-demand">      
         <p class="font-size-h4">
            @php $badi_sl = 1; @endphp
            @foreach ($badis as $badi)            
            {{$badi_sl}}। {{ $badi->badi_name }}, পিতা/স্বামীঃ {{ $badi->badi_spouse_name }} <br>
            সাং {{ $badi->badi_address }}       
            <br>              
            @php $badi_sl++; @endphp
            @endforeach                     
            ................................................................. বাদী
         </p>

         <div class="font-weight-bolder font-size-h3 mt-5 mb-5">বনাম</div>

         <p class="font-size-h4">
            @php $bibadi_sl = 1; @endphp
            @foreach ($bibadis as $bibadi)            
            {{$bibadi_sl}}। {{ $bibadi->bibadi_name }}, পিতা/স্বামীঃ {{ $bibadi->bibadi_spouse_name }} <br>
            সাং {{ $bibadi->bibadi_address }}       
            <br>              
            @php $bibadi_sl++; @endphp
            @endforeach
            ................................................................. বিবাদী   
         </p>

         <p class="font-size-h4 mt-15">
            <?php echo nl2br($sf->sf_details); ?>
         </p>

         <table>
            <tr>
               <?php foreach ($sf_signatures as $row){ ?>
               <td width="30%">
                  <?php if($row->signature != NULL){ ?>
                  <img src="<?='http://civilsuit.msh/uploads/signature/'.$row->signature?>" alt="<?=$row->name?>" height="50">
                  <?php } ?>
                  <br><strong><?=$row->name ?></strong><br>
                  <span style="font-size:15px;">
                  <?=$row->role_name ?><br>
                  <?=$row->office_name_bn ?><br></span>          
               </td>
               <?php } ?>
            </tr>
         </table>

         <?php /*
         <table class="table table-hover table-bordered report">
            <thead class="headding">
               <tr>
                  <td class="text-center">SL</td>
                  <td class="text-left">Name</td>
                  <td class="text-left">Committee Designation</td>
                  <td class="text-left">Professional Designation</td>
                  <td class="text-left">Office Address</td>
                  <td class="text-left">Mobile No</td>
                  <td class="text-left">Email</td>
               </tr>
            </thead>

            <tbody>
               <?php 
               $i=0;             
               foreach ($members as $row) { 
                  $i++;
                  $name = $row->scout_id != NULL ? $row->first_name:$row->member_name;
                  $mobile = $row->scout_id != NULL ? $row->phone:$row->member_mobile;
                  $email = $row->scout_id != NULL ? $row->email:$row->member_email;
                  ?>
                  <tr style="line-height: 100px;">
                     <td class="text-center"><?=$i?></td>
                     <td class="text-left"><?=$name?></td>
                     <td class="text-left"><?=$row->committee_designation_name?></td>
                     <td class="text-left"><?=$row->member_profession?></td>
                     <td class="text-left"><?=$row->member_address?></td>
                     <td class="text-left"><?=$mobile?></td>
                     <td class="text-left"><?=$email?></td>
                  </tr>
                  <?php } ?>
               </tbody>
            </table> 
         */ ?>
      </div>

   </div>
</body>
</html>