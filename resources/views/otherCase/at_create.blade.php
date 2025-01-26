@extends('layouts.default')

@section('content')

@php
$pass_year_data = '<option value="">-- Select --</option>';
for($i=1995;$i<=date('Y');$i++){
$pass_year_data .= '<option value="'.$i.'">'.$i.'</option>';
}
@endphp

<?php
// print_r($surveys); exit;
$survey_data = '<option value="">-- Select --</option>';
for($i=0;$i<sizeof($surveys);$i++){
    $survey_data .= '<option value="'.$surveys[$i]->id.'">'.$surveys[$i]->st_name.'</option>';
}

$land_type_data = '<option value="">-- Select --</option>';
for($i=0;$i<sizeof($land_types);$i++){
    $land_type_data .= '<option value="'.$land_types[$i]->id.'">'.$land_types[$i]->lt_name.'</option>';
}
?>

<style type="text/css">
    #justisDiv td{padding: 5px; border-color: #ccc;}
    #justisDiv th{padding: 5px;text-align:center;border-color: #ccc; color: black;}
    #advocateDiv td{padding: 5px; border-color: #ccc;}
    #advocateDiv th{padding: 5px;text-align:center;border-color: #ccc; color: black;}
    #witnessDiv td{padding: 5px; border-color: #ccc;}
    #witnessDiv th{padding: 5px;text-align:center;border-color: #ccc; color: black;}
    #badiDiv td{padding: 5px; border-color: #ccc;}
    #badiDiv th{padding: 5px;text-align:center;border-color: #ccc; color: black;}
    #bibadiDiv td{padding: 5px; border-color: #ccc;}
    #bibadiDiv th{padding: 5px;text-align:center;border-color: #ccc; color: black;}
    #surveyDiv td{padding: 5px; border-color: #ccc;}
    #surveyDiv th{padding: 5px;text-align:center;border-color: #ccc; color: black;}
</style>
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
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!--begin::Form-->
            <form action="{{ url('case/save') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <fieldset class="mb-8">
                        <legend>General Information</legend>
                        <div class="form-group row">
                            <div class="col-lg-4 mb-5">
                                <label>Court Name<span class="text-danger">*</span></label>
                                <select name="court" id="court" class="form-control form-control-sm">
                                    <option value=""> -- Select --</option>
                                    @foreach ($courts as $value)
                                    <option value="{{ $value->id }}" {{ old('court') == $value->id ? 'selected' : '' }}> {{ $value->court_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 mb-5">
                                <label>Upazila <span class="text-danger">*</span></label>
                                <select name="upazila" id="upazila_id" class="form-control form-control-sm" >
                                    <option value="">-- Select --</option>
                                     @foreach ($upazilas as $value)
                                    <option value="{{ $value->id }}" {{ old('upazila') == $value->id ? 'selected' : '' }}> {{ $value->upazila_name_bn }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 mb-5">
                                <label>Mouja <span class="text-danger">*</span></label>
                                <select name="mouja" id="mouja_id" class="form-control form-control-sm">
                                    <!-- <span id="loading"></span> -->
                                    <option value="">-- Select --</option>
                                </select>
                            </div><!--
                            <div class="col-lg-4 mb-5">
                                <label>মামলার ধরণ <span class="text-danger">*</span></label>
                                <select name="case_type" id="case_type" class="form-control form-control-sm">
                                    <option value="">-- Select --</option>
                                    @foreach ($case_types as $value)
                                    <option value="{{ $value->id }}" {{ old('case_type') == $value->id ? 'selected' : '' }}> {{ $value->ct_name }} </option>
                                    @endforeach
                                </select>
                            </div> -->
                            <div class="col-lg-4 mb-5">
                                <label>Case No <span class="text-danger">*</span></label>
                                <input type="text" name="case_no" id="case_no" class="form-control form-control-sm" placeholder="Case No ">
                            </div>
                            <div class="col-lg-4 mb-5">
                                <label>Case Filing Date<span class="text-danger">*</span></label>
                                <input type="text" name="case_date" id="case_date" class="form-control form-control-sm common_datepicker" placeholder="Date/Month/Year" autocomplete="off">
                            </div>
                        </div>
                    </fieldset>

                     <div class="form-group row">
                        <div class="col-lg-6 mb-5">
                            <fieldset>
                                <legend>Plaintiff Details</legend>
                                <table width="100%" border="1" id="badiDiv" style="border:1px solid #dcd8d8;">
                                    <tr>
                                        <th>Plaintiff name <span class="text-danger">*</span></th>
                                        <th>Father/Husband name</th>
                                        <th>Address</th>
                                        <th width="50">
                                            <a href="javascript:void();" id="addBadiRow" class="btn btn-sm btn-primary font-weight-bolder pr-2"><i class="fas fa-plus-circle"></i></a>
                                        </th>
                                    </tr>
                                    <tr></tr>
                                </table>
                            </fieldset>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <fieldset>
                                <legend>Defendant details</legend>
                                <table width="100%" border="1" id="bibadiDiv" style="border:1px solid #dcd8d8;">
                                    <tr>
                                        <th>Defendant name <span class="text-danger">*</span></th>
                                        <th>Father/Husband name</th>
                                        <th>Address</th>
                                        <th width="50">
                                            <a href="javascript:void();" id="addBibadiRow" class="btn btn-sm btn-primary font-weight-bolder pr-2"><i class="fas fa-plus-circle"></i></a>
                                        </th>
                                    </tr>
                                    <tr></tr>
                                </table>
                            </fieldset>
                        </div>
                    </div>

                    
                    <div class="form-group row">
                        <div class="col-lg-6 mb-5">
                            <fieldset>
                                <legend>Justis details</legend>
                                <table width="100%" border="1" id="justisDiv" style="border:1px solid #dcd8d8;">
                                    <tr>
                                        <th>Justis name <span class="text-danger">*</span></th>
                                        <th>Designation</th>
                                        <th width="50">
                                            <a href="javascript:void();" id="addJustisRow" class="btn btn-sm btn-primary font-weight-bolder pr-2"><i class="fas fa-plus-circle"></i></a>
                                        </th>
                                    </tr>
                                    <tr></tr>
                                </table>
                            </fieldset>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <fieldset>
                                <legend>Advocate Details</legend>
                                <table width="100%" border="1" id="advocateDiv" style="border:1px solid #dcd8d8;">
                                    <tr>
                                        <th>Advocate name <span class="text-danger">*</span></th>
                                        <th>Designation</th>
                                        <th width="50">
                                            <a href="javascript:void();" id="addAdvocateRow" class="btn btn-sm btn-primary font-weight-bolder pr-2"><i class="fas fa-plus-circle"></i></a>
                                        </th>
                                    </tr>
                                    <tr></tr>
                                </table>
                            </fieldset>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6 mb-5">
                            <fieldset>
                                <legend>Witness Details</legend>
                                <table width="100%" border="1" id="witnessDiv" style="border:1px solid #dcd8d8;">
                                    <tr>
                                        <th>Witness name <span class="text-danger">*</span></th>
                                        <th>Designation</th>
                                        <th>Address</th>
                                        <th width="50">
                                            <a href="javascript:void();" id="addWitnessRow" class="btn btn-sm btn-primary font-weight-bolder pr-2"><i class="fas fa-plus-circle"></i></a>
                                        </th>
                                    </tr>
                                    <tr></tr>
                                </table>
                            </fieldset>
                        </div>
                    </div>

                    <br>
                    <div class="form-group row">
                        <div class="col-lg-6 mb-5">
                            <fieldset>
                                <legend>Reason letter scanned copy attachment <span class="text-danger">*</span></legend>
                                <div class="col-lg-12 mb-5">
                                    <div class="form-group">
                                        <label></label>
                                        <div></div>
                                        <div class="custom-file">
                                            <input type="file" name="show_cause" class="custom-file-input" id="customFile" />
                                            <label class="custom-file-label" for="customFile">File Select</label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <fieldset>
                                <legend>Comments </legend>
                                <div class="col-lg-12 mb-5">
                                    <label></label>
                                    <textarea name="comments" class="form-control" id="comments" rows="2" spellcheck="false"></textarea>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                </div> <!--end::Card-body-->

                <!-- <div class="card-footer text-right bg-gray-100 border-top-0">
                    <button type="reset" class="btn btn-primary">সংরক্ষণ করুন</button>
                </div> -->
            <div class="card-footer">
              <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-7">
                        <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary mr-3" id="preview">Preview</button>
                        <button type="submit" class="btn btn-success mr-2" onclick="return confirm('Do You Want To Save?')">Save</button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="myModal">

                <div class="modal-dialog modal-xl">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h3 class="modal-title"> Case Details</h3>
                          <button type="button" class="close" data-dismiss="modal">×</button>
                      </div>

                      <!-- Modal body -->
                      <div class="modal-body">
                       <div class="row">

                         <label><h4>General Information</h4></label>
                         <table class="tg">
                            <thead>
                                <tr>
                                    <th class="tg-19u4 text-center">Court name </th>
                                    <!-- <th class="tg-19u4 text-center">বিভাগ </th>
                                    <th class="tg-19u4 text-center">জেলা </th> -->
                                    <th class="tg-19u4 text-center">Upazila </th>
                                    <th class="tg-19u4 text-center">Mouja </th>
                                </tr>
                                <tr>
                                    <td class="tg-nluh" id="previewCourt"></td>
                                   <!--  <td class="tg-nluh" id="previewDivision"></td>
                                    <td class="tg-nluh" id="previewDistrict"></td> -->
                                    <td class="tg-nluh" id="previewUpazila"></td>
                                    <td class="tg-nluh" id="previewMouja_id"></td>

                                </tr>
                                <tr>
                                   <!--  <th class="tg-19u4 text-center">মামলার ধরণ</th> -->
                                    <th class="tg-19u4 text-center">Case No </th>
                                    <th class="tg-19u4 text-center">Case filing date</th>
                                </tr>
                                <tr>
                                    <!-- <td class="tg-nluh" id="previewCase_type"></td> -->
                                    <td class="tg-nluh" id="previewCase_no"></td>
                                    <td class="tg-nluh" id="previewCase_date"></td>

                                </tr>
                            </thead>
                        </table>
                        <br>
                        <br>
                        <table class="tg">
                            <label><h4>Plaintiff Details</h4></label>
                            <thead>
                                <tr>
                                    <th class="tg-19u4 text-center">Plaintiff name</th>
                                    <th class="tg-19u4 text-center">Father/Husband name</th>
                                    <th class="tg-19u4 text-center">Address</th>
                                </tr>
                                <tr>
                                    <td class="tg-nluh" id="previewBadi_name"></td>
                                    <td class="tg-nluh" id="previewBadi_spouse_name"></td>
                                    <td class="tg-nluh" id="previewBadi_address"></td>

                                </tr>
                            </thead>
                        </table>
                        <br>
                        <br>
                        <table class="tg">
                            <label><h4>Defendant Details</h4></label>
                            <thead>
                                <tr>
                                    <th class="tg-19u4 text-center">Defendant name </th>
                                    <th class="tg-19u4 text-center">Father/Husband name</th>
                                    <th class="tg-19u4 text-center">Address</th>
                                </tr>
                                <tr>
                                    <td class="tg-nluh" id="previewBibadi_name"></td>
                                    <td class="tg-nluh" id="previewBibadi_spouse_name"></td>
                                    <td class="tg-nluh" id="previewBibadi_address"></td>
                                </tr>

                            </thead>
                        </table>
                        <br>
                        <br>
                        <table class="tg">
                            <label><h4>Details of the Survey</h4></label>
                            <thead>
                                <tr>
                                    <th class="tg-19u4 text-center">Type of the Survey </th>
                                    <th class="tg-19u4 text-center">Daag No</th>
                                    <th class="tg-19u4 text-center">Ledger no</th>
                                </tr>
                                <tr>
                                    <td class="tg-nluh" id="previewSt_id"></td>
                                    <td class="tg-nluh" id="previewKhotian_no"></td>
                                    <td class="tg-nluh" id="previewDaag_no"></td>
                                </tr>

                                <tr>
                                    <th class="tg-19u4 text-center">Land class</th>
                                    <th class="tg-19u4 text-center">Amount of land (percent)</th>
                                    <th class="tg-19u4 text-center">Amount of Complaint Land (percent)</th>
                                </tr>
                                <tr>
                                    <td class="tg-nluh" id="previewLt_id"></td>
                                    <td class="tg-nluh" id="previewLand_size"></td>
                                    <td class="tg-nluh" id="previewLand_demand"></td>

                                </tr>
                            </thead>
                        </table>
                        <div class="col-lg-6 mb-5"></div>
                        <table class="tg">
                            <thead>
                                <tr>
                                    <th class="tg-19u4 text-center">Tafsil details</th>
                                    <th class="tg-19u4 text-center">Chowhoddi details</th>
                                    <th class="tg-19u4 text-center">Coments</th>

                                </tr>
                                <tr>
                                    <td class="tg-nluh" id="previewTafsil"></td>
                                    <td class="tg-nluh" id="previewChowhaddi"></td>
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
            //Load First row
            addJustisRowFunc();
            addAdvocateRowFunc();
            addWitnessRowFunc();
            addBadiRowFunc();
            addBibadiRowFunc();
            addSurveyRowFunc();

            // Dynamic Dropdown
            var load_url = "{{ asset('media/custom/preload.gif') }}";


                            //===========District================//


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

                        jQuery('select[name="district"]').html('<option value="">-- Select --</option>');
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
                    url : '{{url("/")}}/case/dropdownlist/getdependentupazila/' +dataID,
                    type : "GET",
                    dataType : "json",
                    success:function(data)
                    {
                        jQuery('select[name="upazila"]').html('<div class="loadersmall"></div>');
                        //console.log(data);
                        // jQuery('#mouja_id').removeAttr('disabled');
                        // jQuery('#mouja_id option').remove();

                        jQuery('select[name="upazila"]').html('<option value="">-- Select --</option>');
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

                        jQuery('select[name="mouja"]').html('<option value="">-- Select --</option>');
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

        /*********************** Add multiple Justis *************************/
        $("#addJustisRow").click(function(e) {
            addJustisRowFunc();
        });

        //add row function
        function addJustisRowFunc(){


            var items = '';
            items+= '<tr>';
            items+= '<td><input type="text" name="justis_name[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><input type="text" name="justis_designation[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><a href="javascript:void();" class="btn btn-sm btn-danger font-weight-bolder pr-2" onclick="removeJustisRow(this)"> <i class="fas fa-minus-circle"></i></a></td>';
            items+= '</tr>';

            $('#justisDiv tr:last').after(items);


            //scout_id_select2_dd();
        }

        //remove row
        function removeJustisRow(id){
            $(id).closest("tr").remove();
        }

        /*********************** Add multiple Advocate *************************/
        $("#addAdvocateRow").click(function(e) {
            addBadiRowFunc();
        });

        //add row function
        function addAdvocateRowFunc(){


            var items = '';
            items+= '<tr>';
            items+= '<td><input type="text" name="advocate_name[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><input type="text" name="advocate_designation[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><a href="javascript:void();" class="btn btn-sm btn-danger font-weight-bolder pr-2" onclick="removeAdvocateRow(this)"> <i class="fas fa-minus-circle"></i></a></td>';
            items+= '</tr>';

            $('#advocateDiv tr:last').after(items);


            //scout_id_select2_dd();
        }

        //remove row
        function removeAdvocateRow(id){
            $(id).closest("tr").remove();
        }

        /*********************** Add multiple Witness *************************/
        $("#addWitnessRow").click(function(e) {
            addWitnessRowFunc();
        });

        //add row function
        function addWitnessRowFunc(){


            var items = '';
            items+= '<tr>';
            items+= '<td><input type="text" name="witness_name[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><input type="text" name="witness_designation[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><input type="text" name="witness_address[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><a href="javascript:void();" class="btn btn-sm btn-danger font-weight-bolder pr-2" onclick="removeWitnessRow(this)"> <i class="fas fa-minus-circle"></i></a></td>';
            items+= '</tr>';

            $('#witnessDiv tr:last').after(items);


            //scout_id_select2_dd();
        }

        //remove row
        function removeWitnessRow(id){
            $(id).closest("tr").remove();
        }

        /*********************** Add multiple badi *************************/
        $("#addBadiRow").click(function(e) {
            addBadiRowFunc();
        });

        //add row function
        function addBadiRowFunc(){


            var items = '';
            items+= '<tr>';
            items+= '<td><input type="text" name="badi_name[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><input type="text" name="badi_spouse_name[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><input type="text" name="badi_address[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><a href="javascript:void();" class="btn btn-sm btn-danger font-weight-bolder pr-2" onclick="removeBadiRow(this)"> <i class="fas fa-minus-circle"></i></a></td>';
            items+= '</tr>';

            $('#badiDiv tr:last').after(items);


            //scout_id_select2_dd();
        }

        //remove row
        function removeBadiRow(id){
            $(id).closest("tr").remove();
        }

        /************************ Add multiple bibadi *************************/
        $("#addBibadiRow").click(function(e) {
            addBibadiRowFunc();
        });

        //add row function
        function addBibadiRowFunc(){
            var items = '';
            items+= '<tr>';
            items+= '<td><input type="text" name="bibadi_name[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><input type="text" name="bibadi_spouse_name[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><input type="text" name="bibadi_address[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><a href="javascript:void();" class="btn btn-sm btn-danger font-weight-bolder pr-2" onclick="removeBibadiRow(this)"> <i class="fas fa-minus-circle"></i></a></td>';
            items+= '</tr>';

            $('#bibadiDiv tr:last').after(items);
            //scout_id_select2_dd();
        }

        //remove row function
        function removeBibadiRow(id){
            $(id).closest("tr").remove();
        }

        /************************ Add multiple survey *************************/
        $("#addSurveyRow").click(function(e) {
            addSurveyRowFunc();
        });

        //add row function
        function addSurveyRowFunc(){
            var items = '';
            items+= '<tr>';
            items+= '<td><select name="st_id[]" class="form-control form-control-sm"><?php echo $survey_data;?></select></td>';
            items+= '<td><input type="text" name="khotian_no[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><input type="text" name="daag_no[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><select name="lt_id[]" class="form-control form-control-sm"><?php echo $land_type_data;?></select></td>';
            items+= '<td><input type="number" name="land_size[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><input type="number" name="land_demand[]" class="form-control form-control-sm" placeholder=""></td>';
            items+= '<td><a href="javascript:void();" class="btn btn-sm btn-danger font-weight-bolder pr-2" onclick="removeSurveyRow(this)"> <i class="fas fa-minus-circle"></i></a></td>';
            items+= '</tr>';

            $('#surveyDiv tr:last').after(items);
            //scout_id_select2_dd();
        }

        //remove row function
        function removeSurveyRow(id){
            $(id).closest("tr").remove();
        }
    </script>

    <script>

        var numbers = { 0: '০', 1 :'১', 2 :'২', 3 :'৩', 4 :'৪', 5 :'৫', 6 :'৬', 7 :'৭', 8 :'৮',9 :'৯'  };

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

      document.getElementById('r').textContent = replaceNumbers('count');
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
<!--end::Page Scripts-->
@endsection







