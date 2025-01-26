<?php
$roleID = Auth::user()->role_id;
$officeInfo = user_office_info();
?>
<form class="form-inline" method="GET">

   <div class="container">
      <div class="row">
         <div class="col-lg-4">
            <div class="form-group mb-2">
               <select name="division" class="form-control w-100">
                  <option value="">-বিভাগ নির্বাচন করুন-</option>
                  @foreach ($divisions as $value)
                  <option value="{{ $value->id }}" {{ request()->division == $value->id ? 'selected' : '' }}> {{ $value->division_name_bn }} </option>
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
         <div class="col-lg-12 col-lg-2 text-right my-4">
            <button type="submit" class="btn btn-success mb-2 ml-2">অনুসন্ধান করুন</button>
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
            jQuery("#district_id").after('<div class="loadersmall"></div>');

            if(dataID)
            {
               jQuery.ajax({
                  url : '{{url("/")}}/case/dropdownlist/getdependentdistrict/' +dataID,
                  type : "GET",
                  dataType : "json",
                  success:function(data)
                  {
                     jQuery('select[name="district"]').html('<div class="loadersmall"></div>');

                     jQuery('select[name="district"]').html('<option value="">-- নির্বাচন করুন --</option>');
                     jQuery.each(data, function(key,value){
                        jQuery('select[name="district"]').append('<option value="'+ key +'">'+ value +'</option>');
                     });
                     jQuery('.loadersmall').remove();

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
         jQuery("#upazila_id").after('<div class="loadersmall"></div>');

            jQuery.ajax({
             url : '{{url("/")}}/case/dropdownlist/getdependentupazila/' +dataID,
             type : "GET",
             dataType : "json",
             success:function(data)
             {
               jQuery('select[name="upazila"]').html('<div class="loadersmall"></div>');

                  jQuery('select[name="upazila"]').html('<option value="">-- নির্বাচন করুন --</option>');
                  jQuery.each(data, function(key,value){
                    jQuery('select[name="upazila"]').append('<option value="'+ key +'">'+ value +'</option>');
                 });
                  jQuery('.loadersmall').remove();
               }
            });

         // Load Court
         var courtID = jQuery(this).val();
         jQuery("#court_id").after('<div class="loadersmall"></div>');

            jQuery.ajax({
               url : '{{url("/")}}/court/dropdownlist/getdependentcourt/' +courtID,
               type : "GET",
               dataType : "json",
               success:function(data)
               {
                  jQuery('select[name="court"]').html('<div class="loadersmall"></div>');

                  jQuery('select[name="court"]').html('<option value="">-- নির্বাচন করুন --</option>');
                  jQuery.each(data, function(key,value){
                     jQuery('select[name="court"]').append('<option value="'+ key +'">'+ value +'</option>');
                  });
                  jQuery('.loadersmall').remove();

               }
            });
      });

   });
</script>
@endsection
