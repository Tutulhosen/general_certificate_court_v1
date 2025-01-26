<?php
$roleID = Auth::user()->role_id;
$officeInfo = user_office_info();
?>
<form class="form-inline" method="GET">

   @if($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4)
   <div class="container">
      <div class="row">
         <div class="col-lg-4">
            <div class="form-group mb-2">
               <select name="division" class="form-control w-100">
                  <option value="">-বিভাগ নির্বাচন করুন-</option>
                  @foreach ($divisions as $value)
                  <option value="{{ $value->id }}"> {{ $value->division_name_bn }} </option>
                  @endforeach
               </select>
            </div>
         </div>
         <div class="col-lg-4">
            <div class="form-group mb-2">
               <select name="district" id="district_id" class="form-control w-100">
                  <option value="">-জেলা নির্বাচন করুন-</option>
               </select>
            </div>
         </div>
         <div class="col-lg-4 mb-2">
            <select name="upazila" id="upazila_id" class="form-control w-100">
               <option value="">-উপজেলা নির্বাচন করুন-</option>
            </select>
         </div>
      </div>
   </div>

   <div class="container">
      <div class="row">
         <div class="col-lg-4 mb-2">
            <select name="court" id="court_id" class="form-control form-control w-100">
               <option value="">-আদালত নির্বাচন করুন-</option>

            </select>
         </div>

         <div class="col-lg-4">
            <div class="form-group mb-2">
               <select name="gp" class="form-control w-100">
                  <option value="">-জিপি নির্বাচন করুন-</option>
                  @foreach ($gp_users as $value)
                  <option value="{{ $value->id }}"> {{ $value->name }} </option>
                  @endforeach
               </select>
            </div>
         </div>
         <div class="col-lg-4">
            <div class="form-group mb-2">
               <select name="role" class="form-control w-100">
                  <option value="">-ইউজার রোল নির্বাচন করুন-</option>
                  @foreach ($user_role as $value)
                  <option value="{{ $value->id }}"> {{ $value->role_name }} </option>
                  @endforeach
               </select>
            </div>
         </div>
      </div>
   </div>



   @elseif($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13)
   <div class="container">
      <div class="row">

         <div class="col-lg-4">
            <div class="form-group mb-2">
               <select name="upazila"  id="upazila_id" class="form-control w-100">
                  <option value="">-উপজেলা নির্বাচন করুন-</option>
                  @foreach ($upazilas as $value)
                  <option value="{{ $value->id }}"> {{ $value->upazila_name_bn }} </option>
                  @endforeach
               </select>
            </div>
         </div>
         <div class="col-lg-4">
            <div class="form-group mb-2">
               <select name="court" class="form-control w-100">
                  <option value="">-আদালত নির্বাচন করুন-</option>
                  @foreach ($courts as $value)
                  <option value="{{ $value->id }}"> {{ $value->court_name }} </option>
                  @endforeach
               </select>
            </div>
         </div>

      </div>
   </div>

   @endif

   <div class="container p-0">
      <div class="row">
         <div class="col-lg-4 mb-5">
            <input type="text" name="date_start"  class="w-100 form-control common_datepicker" placeholder="তারিখ হতে" autocomplete="off">
         </div>
         <div class="col-lg-4 mb-5">
            <input type="text" name="date_end" class="w-100 form-control common_datepicker" placeholder="তারিখ পর্যন্ত" autocomplete="off">
         </div>
         <div class="col-lg-4">
               <input type="text" class="form-control w-100" name="case_no" placeholder="মামলা নং" value="">
         </div>
         <div class="col-lg-12 col-lg-2 text-right my-4">
            <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান করুন</button>
         </div>
      </div>
   </div>

</form>

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

            // Court Dropdown
      /*jQuery('select[name="district"]').on('change',function(){
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
               url : '{{url("/")}}/court/dropdownlist/getdependentcourt/' +dataID,
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
@endsection
