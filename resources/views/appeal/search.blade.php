
<form class="form-inline" method="GET">



   <div class="container">
      <div class="row">
         <div class="col-lg-3 mb-5">
            <input type="text" name="date_start"  class="w-100 form-control common_datepicker" placeholder="তারিখ হতে" autocomplete="off">
         </div>
         <div class="col-lg-3 mb-5">
            <input type="text" name="date_end" class="w-100 form-control common_datepicker" placeholder="তারিখ পর্যন্ত" autocomplete="off">
         </div>
         <div class="col-lg-3">
               <input type="text" class="form-control w-100" name="case_no" placeholder="মামলা নং" value="">
         </div>
         <div class="col-lg-3 ">
            <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান করুন</button>
         </div>
      </div>
   </div>

</form>

@section('scripts')
<script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
