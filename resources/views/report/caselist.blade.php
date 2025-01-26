@extends('layouts.default')

@section('content')

<!--begin::Row-->
<div class="row">

   <div class="col-md-12">
      <!--begin::Card-->
      <div class="card card-custom gutter-b example example-compact">
         <div class="card-header">
            <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            <div class="card-toolbar">
               <!-- <div class="example-tools justify-content-center">
                  <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                  <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
               </div> -->
            </div>
         </div>

         <!-- <div class="loadersmall"></div> -->

         <!--begin::Form-->
         <!-- <form class="form" method="GET"> -->
         <form action="{{ url('report/pdf') }}" class="form" method="POST" target="_blank">
            @csrf
            <div class="card-body">
               @if ($errors->any())
               <div class="alert alert-danger">
                  <ul>
                     @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
               @endif
               <fieldset class="mb-6">
                  <legend>ফিল্টারিং ফিল্ড সমূহ</legend>

                  <div class="form-group row">
                     <div class="col-lg-4 mb-5">
                        <select name="division" class="form-control form-control-sm">
                           <option value="">-বিভাগ নির্বাচন করুন-</option>
                           @foreach ($divisions as $value)
                           <option value="{{ $value->id }}"> {{ $value->division_name_bn }} </option>
                           @endforeach
                        </select>
                     </div>
                     <div class="col-lg-4 mb-5">
                        <!-- <label>জেলা <span class="text-danger">*</span></label> -->
                        <select name="district" id="district_id" class="form-control form-control-sm">
                           <option value="">-জেলা নির্বাচন করুন-</option>
                        </select>
                     </div>
                     <div class="col-lg-4 mb-5">
                        <!-- <label>উপজেলা </label> -->
                        <select name="upazila" id="upazila_id" class="form-control form-control-sm">
                           <option value="">-উপজেলা নির্বাচন করুন-</option>
                        </select>
                     </div>
                     <div class="col-lg-4 mb-5">
                        <select name="court" id="court_id" class="form-control form-control-sm">
                           <option value="">-আদালত নির্বাচন করুন-</option>

                        </select>
                     </div>
                     <div class="col-lg-4 mb-5">
                        <input type="text" name="date_start"  class="form-control form-control-sm common_datepicker" placeholder="তারিখ হতে" autocomplete="off">
                     </div>
                     <div class="col-lg-4 mb-5">
                        <input type="text" name="date_end" class="form-control form-control-sm common_datepicker" placeholder="তারিখ পর্যন্ত" autocomplete="off">
                     </div>

                     <div class="col-lg-4 mb-5">
                        <select name="role" id="role" class="form-control form-control-sm">
                           <option value="">-ইউজার রোল নির্বাচন করুন-</option>
                           @foreach ($roles as $value)
                           <option value="{{ $value->id }}" {{ old('role') == $value->id ? 'selected' : '' }}> {{ $value->role_name }} </option>
                           @endforeach
                        </select>
                     </div>

                     <div class="col-lg-4 mb-5">
                        <select id="year" class="form-control form-control-sm" name="year">
                           <option value="">সাল নির্বাচন করুন</option>
                           {{ $year = date('Y') }}
                           @for ($year = 1971; $year <= 2021; $year++)
                           <option value="{{ $year }}">{{ en2bn($year) }}</option>
                           @endfor
                        </select>
                     </div>

                     <div class="col-lg-4 mb-5">
                        <select  class="form-control" id="month" name="month">
                           <option value=""> মাস নির্বাচন করুন </option>
                           @foreach(range(1,12) as $month)
                           <option value="{{$month}}">
                              {{ date("M", strtotime('2016-'.$month)) }}
                           </option>
                           @endforeach
                        </select>
                     </div>

                  </div>
               </fieldset>
                  <div class="row">
                     <fieldset class="col-lg-5 mb-6 ml-1 ">
                        <legend>সংখ্যা ভিত্তিক রিপোর্ট বাটন</legend>
                        <button type="submit" name="btnsubmit" value="pdf_num_division" class="btn btn-info btn-cons margin-top"> বিভাগ ভিত্তিক</button>
                        <button type="submit" name="btnsubmit" value="pdf_num_district" onclick="return validFunc1()" class="btn btn-info btn-cons margin-top"> জেলা ভিত্তিক</button>
                        <button type="submit" name="btnsubmit" value="pdf_num_upazila" onclick="return validFunc2()" class="btn btn-info btn-cons margin-top"> উপজেলা ভিত্তিক</button>
                     </fieldset>

                     <fieldset class="col-lg-5 mb-6 ml-1 ">
                        <legend>সাল ভিত্তিক রিপোর্ট বাটন</legend>
                        <button type="submit" name="btnsubmit" value="pdf_num_division_year" class="btn btn-info btn-cons margin-top"> বিভাগ ভিত্তিক</button>
                        <button type="submit" name="btnsubmit" value="pdf_num_district_year" onclick="return validFunc1()" class="btn btn-info btn-cons margin-top"> জেলা ভিত্তিক</button>
                        <button type="submit" name="btnsubmit" value="pdf_num_upazila_year" onclick="return validFunc2()" class="btn btn-info btn-cons margin-top"> উপজেলা ভিত্তিক</button>
                     </fieldset>
                  </div>
                  <div class="row">
                     <fieldset class="col-lg-5 mb-6 ml-1 ">
                        <legend>মাস ভিত্তিক রিপোর্ট বাটন</legend>
                        <button type="submit" name="btnsubmit" value="pdf_num_division_month" class="btn btn-info btn-cons margin-top"> বিভাগ ভিত্তিক</button>
                        <button type="submit" name="btnsubmit" value="pdf_num_district_month" onclick="return validFunc1()" class="btn btn-info btn-cons margin-top"> জেলা ভিত্তিক</button>
                        <button type="submit" name="btnsubmit" value="pdf_num_upazila_month" onclick="return validFunc2()" class="btn btn-info btn-cons margin-top"> উপজেলা ভিত্তিক</button>
                     </fieldset>

                     <fieldset class="col-lg-6 mb-6 ml-1 ">
                        <legend>তালিকা ভিত্তিক রিপোর্ট বাটন</legend>
                        <button type="submit" name="btnsubmit" value="pdf_courtwise" class="btn btn-info btn-cons margin-top"> আদালত ভিত্তিক</button>
                        <button type="submit" name="btnsubmit" value="pdf_case" class="btn btn-info btn-cons margin-top"> মামলার তালিকা</button>
                        <button type="submit" name="btnsubmit" value="pdf_userrolewise" class="btn btn-info btn-cons margin-top">ইউজার রোল ভিত্তিক মামলার তালিকা</button>
                     </fieldset>
                  </div>

            </div> <!--end::Card-body-->

            <!-- <div class="card-footer">
               <div class="row">
                  <div class="col-lg-4"></div>
                  <div class="col-lg-7">
                     <button type="submit" class="btn btn-success mr-2">সংরক্ষণ করুন</button>
                  </div>
               </div>
            </div> -->

         </form>
         <!--end::Form-->
      </div>
      <!--end::Card-->
   </div>

</div>
<!--end::Row-->

@endsection

{{-- Includable CSS Related Page --}}
@section('styles')

<!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page--}}
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

<script type="text/javascript">
   jQuery(document).ready(function ()
   {
      // District Dropdown
      jQuery('select[name="division"]').on('change',function(){
         var dataID = jQuery(this).val();
            // var category_id = jQuery('#category_id option:selected').val();
            jQuery("#district_id").after('<div class="loadersmall"></div>');
            // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
            // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
            // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
            // jQuery('.loadersmall').remove();
            if(dataID)
            {
               jQuery.ajax({
                  url : '{{url("/")}}/case/dropdownlist/getdependentdistrict/' +dataID,
                  type : "GET",
                  dataType : "json",
                  success:function(data)
                  {
                     jQuery('select[name="district"]').html('<div class="loadersmall"></div>');
                     //console.log(data);
                     // jQuery('#mouja_id').removeAttr('disabled');
                     // jQuery('#mouja_id option').remove();

                     jQuery('select[name="district"]').html('<option value="">-- নির্বাচন করুন --</option>');
                     jQuery.each(data, function(key,value){
                        jQuery('select[name="district"]').append('<option value="'+ key +'">'+ value +'</option>');
                     });
                     jQuery('.loadersmall').remove();
                     // $('select[name="mouja"] .overlay').remove();
                     // $("#loading").hide();
                  }
               });
            }
            else
            {
               $('select[name="district"]').empty();
            }
         });

      // Upazila Dropdown
   jQuery('select[name="district"]').on('change',function(){
         var dataID = jQuery(this).val();
         // var category_id = jQuery('#category_id option:selected').val();
         jQuery("#upazila_id").after('<div class="loadersmall"></div>');
          // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
          // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
          // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
          // jQuery('.loadersmall').remove();
          /*if(dataID)
          {*/
            jQuery.ajax({
             url : '{{url("/")}}/case/dropdownlist/getdependentupazila/' +dataID,
             type : "GET",
             dataType : "json",
             success:function(data)
             {
               jQuery('select[name="upazila"]').html('<div class="loadersmall"></div>');
                  //console.log(data);
                  // jQuery('#mouja_id').removeAttr('disabled');
                  // jQuery('#mouja_id option').remove();

                  jQuery('select[name="upazila"]').html('<option value="">-- নির্বাচন করুন --</option>');
                  jQuery.each(data, function(key,value){
                    jQuery('select[name="upazila"]').append('<option value="'+ key +'">'+ value +'</option>');
                 });
                  jQuery('.loadersmall').remove();
                  // $('select[name="mouja"] .overlay').remove();
                  // $("#loading").hide();
               }
            });
         //}

         // Load Court
         var courtID = jQuery(this).val();
         // var category_id = jQuery('#category_id option:selected').val();
         jQuery("#court_id").after('<div class="loadersmall"></div>');
         // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
         // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
         // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
         // jQuery('.loadersmall').remove();
         // if(courtID)
         // {
            jQuery.ajax({
               url : '{{url("/")}}/court/dropdownlist/getdependentcourt/' +courtID,
               type : "GET",
               dataType : "json",
               success:function(data)
               {
                  jQuery('select[name="court"]').html('<div class="loadersmall"></div>');
                  //console.log(data);
                  // jQuery('#mouja_id').removeAttr('disabled');
                  // jQuery('#mouja_id option').remove();

                  jQuery('select[name="court"]').html('<option value="">-- নির্বাচন করুন --</option>');
                  jQuery.each(data, function(key,value){
                     jQuery('select[name="court"]').append('<option value="'+ key +'">'+ value +'</option>');
                  });
                  jQuery('.loadersmall').remove();
                  // $('select[name="mouja"] .overlay').remove();
                  // $("#loading").hide();
               }
            });
         //}
         /*else
         {
            $('select[name="upazila"]').empty();
            $('select[name="court"]').empty();
         }*/
      });

/*      // Court Dropdown
      jQuery('select[name="district"]').on('change',function(){
         var dataID = jQuery(this).val();
         // var category_id = jQuery('#category_id option:selected').val();
         jQuery("#court_id").after('<div class="loadersmall"></div>');
         // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
         // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
         // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
         // jQuery('.loadersmall').remove();
         if(dataID)
         {
            jQuery.ajax({
               url : '/court/dropdownlist/getdependentcourt/' +dataID,
               type : "GET",
               dataType : "json",
               success:function(data)
               {
                  jQuery('select[name="upazila"]').html('<div class="loadersmall"></div>');
                  //console.log(data);
                  // jQuery('#mouja_id').removeAttr('disabled');
                  // jQuery('#mouja_id option').remove();

                  jQuery('select[name="court"]').html('<option value="">-- নির্বাচন করুন --</option>');
                  jQuery.each(data, function(key,value){
                     jQuery('select[name="court"]').append('<option value="'+ key +'">'+ value +'</option>');
                  });
                  jQuery('.loadersmall').remove();
                  // $('select[name="mouja"] .overlay').remove();
                  // $("#loading").hide();
               }
            });
         }
         else
         {
            $('select[name="court"]').empty();
         }
      });*/
   });
</script>
<!--end::Page Scripts-->
@endsection
