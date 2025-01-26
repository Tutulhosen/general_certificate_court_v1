<?php
$roleID = Auth::user()->role_id;
$officeInfo = user_office_info();
?>
<!-- <form class="form-inline" method="GET"> -->

      
   <div class="container p-0">
      <div class="row">
         <div class="col-lg-4 mb-5">
            <input type="text" name="date_start"  class="w-100 form-control common_datepicker" placeholder="তারিখ হতে" autocomplete="off" value="{{ isset($_GET['date_start']) ? $_GET['date_start'] : '' }}"> 
         </div>
         <div class="col-lg-4 mb-5">
            <input type="text" name="date_end" class="w-100 form-control common_datepicker" placeholder="তারিখ পর্যন্ত" autocomplete="off" value="{{ isset($_GET['date_end']) ? $_GET['date_end'] : ''}}">
         </div>
         <div class="col-lg-4">
               <input type="text" class="form-control w-100" name="case_no" placeholder="মামলা নং" value="{{ isset($_GET['case_no']) ? $_GET['case_no'] : ''}}">
         </div>
         
      </div>
  
      <div class="row">
         <div class="col-lg-4 mb-5">
                <select name="caseStatus" class="form-control w-100">

                  <option {{ isset($_GET['caseStatus']) ? 'selected' : ''}} value="">--মামলার অবস্থা নির্বাচন করুন--</option>
                  <option {{ isset($_GET['caseStatus']) && $_GET['caseStatus']=='ON_TRIAL' ? 'selected' : ''}} value="ON_TRIAL">চলমান মামলা</option>
                  <option {{ isset($_GET['caseStatus']) && $_GET['caseStatus']=='SEND_TO_EM' ? 'selected' : ''}} value="SEND_TO_EM">গ্রহণের জন্য অপেক্ষমান রিকুইজিশন</option>
                 {{--  <option {{ isset($_GET['caseStatus']) && $_GET['caseStatus']=='DRAFT' ? 'selected' : ''}} value="DRAFT">খসড়া মামলা</option>
                  @if(globalUserInfo()->role_id != 28)
                  <option {{ isset($_GET['caseStatus']) && $_GET['caseStatus']=='REJECTED' ? 'selected' : ''}} value="REJECTED">বর্জনকৃত মামলা</option>
                  @endif --}}
                  <option {{ isset($_GET['caseStatus']) && $_GET['caseStatus']=='CLOSED' ? 'selected' : ''}} value="CLOSED">নিষ্পত্তিকৃত মামলা</option>
                <!--   http://127.0.0.1:8000/register/list?date_start=12%2F02%2F2022&date_end=&case_no=&caseStatus=&printHeading=&_token=LlFRAqox0rzNR31WNhuWtzsN05geHsLFS26bhwat&kromikNo=kromikNo&appealStatus=appealStatus&caseNo=caseNo&caseDecision=caseDecision&relatedCourt=relatedCourt&nextHearingTime=nextHearingTime&nextHearingDate=nextHearingDate&appellantName=appellantName&ruleName=ruleName
                   -->
                 
               </select>
         </div>
         <div class="col-lg-4 mb-5">
                <input type="text" class="form-control w-100" name="printHeading" placeholder="শিরোনাম (কেবল প্রিন্টের জন্য)" value="{{ isset($_GET['printHeading']) ? $_GET['printHeading'] : ''}}">
         </div>
         <div class="col-lg-12 col-lg-2 text-right my-4">
            <button type="button" onclick="formSubmit()" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান করুন</button>
         </div>
      </div>   
   </div>

<!-- </form> -->

@section('scripts')
<script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
<script>
   // common datepicker
   $('.common_datepicker').datepicker({
      format: "dd/mm/yyyy",
      todayHighlight: true,
      orientation: "bottom left"
   });
</script>

   
@endsection
