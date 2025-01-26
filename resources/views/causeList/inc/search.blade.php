@php
    
    if (!empty($_GET['date_start'])) {
        $date_start = $_GET['date_start'];
    } else {
        $date_start = '';
    }
    
    if (!empty($_GET['date_end'])) {
        $date_end = $_GET['date_end'];
    } else {
        $date_end = '';
    }
    if(!empty($_GET['district']))
    {
      $district_info=DB::table('district')->where('id',$_GET['district'])->get();
    }
    if(!empty($_GET['court']))
    {
      $court_info=DB::table('court')->where('id',$_GET['court'])->get();
    }
    if(!empty($_GET['case_no']))
    {
      $case_no=$_GET['case_no'];
    }else
    {
      $case_no='';
    }
@endphp
<form class="form-inline" method="GET" id="landin_page_causelist_search_form">

    <input type="hidden" value="" name="offset" id="landin_page_causelist_search_form_offset">

    <div class="container">
        <div class="row">
            <div class="col-lg-2 mb-5">
                <select name="division" class="form-control form-control w-100">
                    <option value="">বিভাগ নির্বাচন করুন-</option>
                    <?php
                   foreach ($divisions as $value)
                   {
                     if(!empty($_GET['division'])&&($_GET['division']==$value->id))
                     {
                        $selected='selected';
                     }
                     else {
                        $selected=' ';
                     }
                     ?>

                    <option value="{{ $value->id }}" <?= $selected ?>> {{ $value->division_name_bn }} </option>
                    <?php
                   }
               
                 ?>
                </select>
            </div>
            <div class="col-lg-2 mb-5">
                <!-- <label>জেলা <span class="text-danger">*</span></label> -->
                <select name="district" id="district_id" class="form-control form-control w-100">
                    <option value="">জেলা নির্বাচন করুন-</option>
                    <?php
                    if(!empty($district_info))
                    {
                     foreach ($district_info as $value)
                   {
                     
                     ?>
                    <option value="{{ $value->id }}" selected> {{ $value->district_name_bn }} </option>
                    <?php
                   }
                    }

                 ?>
                </select>
            </div>
            <div class="col-lg-2 mb-5">
                <select name="court" id="court_id" class="form-control form-control w-100">
                    <option value="">আদালত নির্বাচন করুন-</option>
                    <?php
                    if(!empty($court_info))
                    {
                     foreach ($court_info as $value)
                   {
                     
                     ?>
                    <option value="{{ $value->id }}" selected> {{ $value->court_name }} </option>
                    <?php
                   }
                    }

                 ?>
                </select>
            </div>
            <div class="col-lg-2 mb-5">
               <input type="text" name="case_no" class="w-100 form-control"
                   placeholder="মামলা নম্বর" autocomplete="off" value="<?= $case_no ?>">
           </div>
            <div class="col-lg-2 mb-5">
                <input type="text" name="date_start" class="w-100 form-control common_datepicker"
                    placeholder="তারিখ হতে" autocomplete="off" value="<?= $date_start ?>">
            </div>
            <div class="col-lg-2 mb-5">
                <input type="text" name="date_end" class="w-100 form-control common_datepicker"
                    placeholder="তারিখ পর্যন্ত" autocomplete="off" value="<?= $date_end ?>">
            </div>
            <div class="col-lg-2 text-left">
                <button type="submit" class="btn btn-info font-weight-bolder mb-2 ml-2">অনুসন্ধান করুন</button>
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
      //}
      // Load Court
      var courtID = jQuery(this).val();
      // var category_id = jQuery('#category_id option:selected').val();
      jQuery("#court_id").after('<div class="loadersmall"></div>');
      
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
      
   });
         // Court Dropdown
   jQuery('select[name="district"]').on('change',function(){
      var dataID = jQuery(this).val();
     
      jQuery("#court_id").after('<div class="loadersmall"></div>');
      
      if(dataID)
      {
         jQuery.ajax({
            url : '{{url("/")}}/generalCertificate/case/dropdownlist/getdependentcourt/' +dataID,
            type : "GET",
            dataType : "json",
            success:function(data)
            {
               jQuery('select[name="upazila"]').html('<div class="loadersmall"></div>');
               
               jQuery('select[name="court"]').html('<option value="">-- নির্বাচন করুন --</option>');
               jQuery.each(data, function(key,value){
                  jQuery('select[name="court"]').append('<option value="'+ key +'">'+ value +'</option>');
               });
               jQuery('.loadersmall').remove();
               
            }
         });
      }
      else
      {
         $('select[name="court"]').empty();
      }
   });
 $("#case_no").keyup(function(){
     var amount = $("#case_no").val();
     $("#case_no").val(NumToBangla.replaceNumbers(amount));
 });
});

//=====================Num2Bangla====================//
   var NumToBangla = {
      replaceNumbers: function(input) {
           var numbers = {
               0: '০',
               1: '১',
               2: '২',
               3: '৩',
               4: '৪',
               5: '৫',
               6: '৬',
               7: '৭',
               8: '৮',
               9: '৯'
           };
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
   }
//=====================//Num2Bangla====================//
 </script>

  
@endsection
