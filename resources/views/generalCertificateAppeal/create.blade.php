@extends('layouts.app')

@section('content')

@php
$pass_year_data = '<option value="">-- নির্বাচন করুন --</option>';
for($i=1995;$i<=date('Y');$i++){
$pass_year_data .= '<option value="'.$i.'">'.$i.'</option>';
}



@endphp


<style type="text/css">
    #badiDiv td{padding: 5px; border-color: #ccc;}
    #badiDiv th{padding: 5px;text-align:center;border-color: #ccc; color: black;}
    #bibadiDiv td{padding: 5px; border-color: #ccc;}
    #bibadiDiv th{padding: 5px;text-align:center;border-color: #ccc; color: black;}
    #fileDiv td{padding: 5px; border-color: #ccc;}
    #fileDiv th{padding: 5px;text-align:center;border-color: #ccc; color: black;}
    #surveyDiv td{padding: 5px; border-color: #ccc;}
    #surveyDiv th{padding: 5px;text-align:center;border-color: #ccc; color: black;}
</style>
<!--begin::Row-->
<div class="container">
    <div class="col-md-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header bg-success">
                <h3 class="card-title h3 font-weight-bolder">{{ $page_title }}</h3>
                <div class="card-toolbar">
                    
                </div>
            </div>

            <!-- <div class="loadersmall"></div> -->
            @if ($errors->any())
            <div class="card-body">
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <!--begin::Form-->
            <form action="{{ route('rmcase.store') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <fieldset class="mb-8">
                        <div class="from-group row">
                            
                            <div class="col-lg-4 mb-3">
                                <label> মামলা নম্বর <span class="text-danger">*</span></label>
                                <input type="text" name="case_no" id="case_no" class="form-control form-control-sm" placeholder="মামলা নং ">
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label>নাম <span class="text-danger">*</span></label>
                                <input type="text" name="case_no" id="case_no" class="form-control form-control-sm" placeholder="নাম ">
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label>প্রতিষ্ঠানের নাম <span class="text-danger">*</span></label>
                                <input type="text" name="case_no" id="case_no" class="form-control form-control-sm" placeholder="প্রতিষ্ঠানের নাম ">
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label>পদবি <span class="text-danger">*</span></label>
                                <input type="text" name="case_no" id="case_no" class="form-control form-control-sm" placeholder="পদবি ">
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label>ফোন নম্বর <span class="text-danger">*</span></label>
                                <input type="text" name="case_no" id="case_no" class="form-control form-control-sm" placeholder="ফোন নম্বর ">
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label>ইমেইল</label>
                                <input type="text" name="case_no" id="case_no" class="form-control form-control-sm" placeholder="ইমেইল ">
                            </div>
                            <div class="col-lg-4 mb-3">
                                 <label>বিভাগ <span class="text-danger">*</span></label>
                                   <select name="division" class="form-control form-control-sm">
                                      <option value="">-বিভাগ নির্বাচন করুন-</option>
                                      @foreach ($divisions as $value)
                                      <option value="{{ $value->id }}"> {{ $value->division_name_bn }} </option>
                                      @endforeach
                                   </select>
                             </div>
                             <div class="col-lg-4 mb-3">
                                    <label>জেলা <span class="text-danger">*</span></label>
                                   <select name="district" id="district_id" class="form-control form-control-sm">
                                      <option value="">-জেলা নির্বাচন করুন-</option>

                                   </select>
                             </div>
                             <div class="col-lg-4 mb-3">
                                <label>উপজেলা <span class="text-danger">*</span></label>
                                <select name="upazila" id="upazila_id" class="form-control form-control-sm">
                                   <option value="">-উপজেলা নির্বাচন করুন-</option>
                                </select>
                             </div>
                        
                            <div class="col-lg-12 mb-1">
                                <label>আপত্তির কারণ/বিষয় <span class="text-danger">*</span></label>
                                <!-- <label></label> -->
                                <textarea name="comments" class="form-control" id="comments" rows="4" spellcheck="false"></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div> <!--end::Card-body-->

        
            <div class="card-footer">
              <div class="row">
                    <div class="col-lg-5"></div>
                    <div class="col-lg-6">
                        <!-- <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary mr-3" id="preview">প্রিভিউ</button> -->
                        <button type="submit" class="btn btn-success mr-2" onclick="return confirm('আপনি কি সংরক্ষণ করতে চান?')">সংরক্ষণ করুন</button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="myModal">

                <div class="modal-dialog modal-xl">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h3 class="modal-title">নতুন মামলার তথ্য</h3>
                          <button type="button" class="close" data-dismiss="modal">×</button>
                      </div>

                      <!-- Modal body -->
                      <div class="modal-body">
                       <div class="row">

                         <label><h4>সাধারণ তথ্য</h4></label>
                         <table class="tg">
                            <thead>
                                <tr>
                                    <th class="tg-19u4 text-center">মৌজা </th>
                                </tr>
                                <tr>
                                    <td class="tg-nluh" id="previewMouja_id"></td>
                                </tr>
                                <tr>
                                    <th class="tg-19u4 text-center">মামলার ধরণ</th>
                                    <th class="tg-19u4 text-center">মামলা নং </th>
                                    <th class="tg-19u4 text-center">মামলা রুজুর তারিখ</th>
                                </tr>
                                <tr>
                                    <td class="tg-nluh" id="previewCase_type"></td>
                                    <td class="tg-nluh" id="previewCase_no"></td>
                                    <td class="tg-nluh" id="previewCase_date"></td>

                                </tr>
                            </thead>
                        </table>
                        <br>
                        <br>
                        <div class="col-lg-6 mb-5"></div>
                        <table class="tg">
                            <thead>
                                <tr>
                                    <th class="tg-19u4 text-center">মন্তব্য</th>
                                </tr>
                                <tr>
                                    <td class="tg-nluh" id="previewComments"></td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

              </div>
          </div>
      </div>

      </form>
      <!--end::Form-->
    </div>
</div>
<!--end::Card-->
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
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<!-- <script>
        // common datepicker
        $('.common_datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            orientation: "bottom left"
        });
    </script> -->

    <script type="text/javascript">
        jQuery(document).ready(function ()
        {
            
            var load_url = "{{ asset('media/custom/preload.gif') }}";


             //=============District================//


            jQuery('select[name="division"]').on('change',function(){
                // alert(1);
                var dataID = jQuery(this).val();
                // var category_id = jQuery('#category_id option:selected').val();
                jQuery("#district_id").after('<div class="loadersmall"></div>');
                

                if(dataID)
                {
                  jQuery.ajax({
                    url : '{{url("/")}}/generalCertificate/case/dropdownlist/getdependentdistrict/' +dataID,
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

                //===========Upazila================//


            jQuery('select[name="district"]').on('change',function(){
                var dataID = jQuery(this).val();

                // var category_id = jQuery('#category_id option:selected').val();
                jQuery("#upazila_id").after('<div class="loadersmall"></div>');
                // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
                // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
                // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
                // jQuery('.loadersmall').remove();

                if(dataID)
                {
                  jQuery.ajax({
                    url : '{{url("/")}}/generalCertificate/case/dropdownlist/getdependentupazila/' +dataID,
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
              }
              else
              {
                  $('select[name="upazila"]').empty();
              }
          });


                //===========Mouja================//


            jQuery('select[name="upazila"]').on('change',function(){
                var dataID = jQuery(this).val();

                // var category_id = jQuery('#category_id option:selected').val();
                jQuery("#mouja_id").after('<div class="loadersmall"></div>');
                // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
                // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
                // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
                // jQuery('.loadersmall').remove();

                if(dataID)
                {
                  jQuery.ajax({
                    url : '{{url("/")}}/case/dropdownlist/getdependentmouja/' +dataID,
                    type : "GET",
                    dataType : "json",
                    success:function(data)
                    {
                        jQuery('select[name="mouja"]').html('<div class="loadersmall"></div>');
                        //console.log(data);
                        // jQuery('#mouja_id').removeAttr('disabled');
                        // jQuery('#mouja_id option').remove();

                        jQuery('select[name="mouja"]').html('<option value="">-- নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key,value){
                            jQuery('select[name="mouja"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        jQuery('.loadersmall').remove();
                        // $('select[name="mouja"] .overlay').remove();
                        // $("#loading").hide();
                    }
                });
              }
              else
              {
                  $('select[name="mouja"]').empty();
              }
          });
        });

        
    </script>

    <script>

        /*var numbers = { 0: '০', 1 :'১', 2 :'২', 3 :'৩', 4 :'৪', 5 :'৫', 6 :'৬', 7 :'৭', 8 :'৮',9 :'৯'  };

        function replaceNumbers(input) {
            var output = [];
            for (var i = 0; i < input.length; ++i) {
                if (numbers.hasOwnProperty(input[i])) {
                  output.push(numbers[input[i]]);
              } else {
                  output.push(input[i]);
              }
          }
          return output.join('');
      }

      document.getElementById('r').textContent = replaceNumbers('count');*/
  </script>

  <script>
    function myFunction() {
      confirm("আপনি কি সংরক্ষণ করতে চান?");
  }

  $('document').ready(function(){
    $('#preview').on('click',function(){
        var court = $('#court option:selected').text();
        var division = $('#division_id option:selected').text();
        var district_n = $('#district_id option:selected').text();
        var upazila = $('#upazila_id option:selected').text();
        var mouja_id = $('#mouja_id option:selected').text();
        var case_type = $('#case_type option:selected').text();
        var case_no = $('#case_no').val();
        var case_date = $('#case_date').val();
        var tafsil = $('#tafsil').val();
        var chowhaddi = $('#chowhaddi').val();
        var comments = $('#comments').val();
        var count=0;
        var badi_name = $("form input[name='badi_name[]']").map(function()
           {count++; return (count+'. '+$(this).val()+'<br>')}).get();
        var badi_spouse_name = $("form input[name='badi_spouse_name[]']").map(function()
          {return ($(this).val()+'<br>')}).get();
        var badi_address = $("form input[name='badi_address[]']").map(function()
          {return ($(this).val()+'<br>')}).get();
        var count=0;
        var bibadi_name = $("form input[name='bibadi_name[]']").map(function()
          {count++; return (count+'. '+$(this).val()+'<br>')}).get();
        var bibadi_spouse_name = $("form input[name='bibadi_spouse_name[]']").map(function()
          {return ($(this).val()+'<br>')}).get();
        var bibadi_address = $("form input[name='bibadi_address[]']").map(function()
          {return ($(this).val()+'<br>')}).get();
        var count=0;
        var st_id = $("form select[name='st_id[]']").map(function()
           {return ($(this).find("option:selected").text())+'   '}).get();
        var count=0;
        var khotian_no = $("form input[name='khotian_no[]']").map(function()
          {count++; return (count+'. '+$(this).val()+'<br>')}).get();
        var count=0;
        var daag_no = $("form input[name='daag_no[]']").map(function()
          {count++; return (count+'. '+$(this).val()+'<br>')}).get();
        var count=0;
        var lt_id = $("form select[name='lt_id[]']").map(function()
           {return ($(this).find("option:selected").text())+'   '}).get();
        var count=0;
        var land_size = $("form input[name='land_size[]']").map(function()
          {count++; return (count+'. '+$(this).val()+'<br>')}).get();
        var count=0;
        var land_demand = $("form input[name='land_demand[]']").map(function()
          {count++; return (count+'. '+$(this).val()+'<br>')}).get();
        var count=0;

               /* var role_id = $('#role_id option:selected').text();
               var office_id = $('#office_id option:selected').text();*/
               $('#previewCourt').html(court);
               $('#previewDivision').html(division);
               $('#previewDistrict').html(district_n);
               $('#previewUpazila').html(upazila);
               $('#previewMouja_id').html(mouja_id);
               $('#previewCase_type').html(case_type);
               $('#previewCase_no').html(case_no);
               $('#previewCase_date').html(case_date);
               $('#previewTafsil').html(tafsil);
               $('#previewChowhaddi').html(chowhaddi);
               $('#previewComments').html(comments);
               $('#previewBadi_name').html(badi_name);
               $('#previewBadi_spouse_name').html(badi_spouse_name);
               $('#previewBadi_address').html(badi_address);
               $('#previewBibadi_name').html(bibadi_name);
               $('#previewBibadi_spouse_name').html(bibadi_spouse_name);
               $('#previewBibadi_address').html(bibadi_address);
               $('#previewSt_id').html(st_id);
               $('#previewKhotian_no').html(khotian_no);
               $('#previewDaag_no').html(daag_no);
               $('#previewLt_id').html(lt_id);
               $('#previewLand_size').html(land_size);
               $('#previewLand_demand').html(land_demand);

           });
});
</script>
<script type="text/javascript">
    function attachmentTitle(id){
        var value=$('#customFile'+id).val();
        $('.custom-input'+id).text(value);
    }
</script>
<!--end::Page Scripts-->
@endsection







