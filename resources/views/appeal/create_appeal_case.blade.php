@extends('layouts.default')

@section('content')

@php
$pass_year_data = '<option value="">-- নির্বাচন করুন --</option>';
for($i=1995;$i<=date('Y');$i++){
$pass_year_data .= '<option value="'.$i.'">'.$i.'</option>';
}
@endphp

<?php
// print_r($surveys); exit;
$survey_data = '<option value="">-- নির্বাচন করুন --</option>';
for($i=0;$i<sizeof($surveys);$i++){
    $survey_data .= '<option value="'.$surveys[$i]->id.'">'.$surveys[$i]->st_name.'</option>';
}

$land_type_data = '<option value="">-- নির্বাচন করুন --</option>';
for($i=0;$i<sizeof($surveys);$i++){
    $land_type_data .= '<option value="'.$land_types[$i]->id.'">'.$land_types[$i]->lt_name.'</option>';
}
?>

<style type="text/css">
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
            <form action="{{ url('/case/appeal/save/'.$info->id) }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                {{--@method('PUT')--}}
                <div class="card-body">
                    <fieldset class=" mb-8">
                        <legend>সাধারণ তথ্য</legend>

                        <div class="form-group row">
                            <div class="col-lg-4 mb-5">
                                <label>আদালতের নাম <span class="text-danger">*</span></label>
                                <select name="court" class="form-control form-control-sm">
                                    <option value=""> -- নির্বাচন করুন --</option>
                                    @foreach ($courts as $value)
                                    <option value="{{ $value->id }}"> {{ $value->court_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 mb-5">
                                <label>উপজেলা <span class="text-danger">*</span></label>
                                <select name="upazila" id="upazila" class="form-control form-control-sm" >
                                    <option value="">-- নির্বাচন করুন --</option>
                                    @foreach ($upazilas as $value)
                                    <option value="{{ $value->id }}" {{ $value->id == $info->upazila_id ? "selected" : ''}}> {{ $value->upazila_name_bn }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 mb-5">
                                <label>মৌজা <span class="text-danger">*</span></label>
                                <select name="mouja" id="mouja_id" class="form-control form-control-sm">
                                    <!-- <span id="loading"></span> -->
                                    <option value="">-- নির্বাচন করুন --</option>
                                    @foreach ($moujas as $value)
                                    <option value="{{ $value->id }}" {{ $value->id == $info->mouja_id ? "selected" : ''}}> {{ $value->mouja_name_bn }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- <div class="col-lg-4 mb-5">
                                <label>মামলার ধরণ <span class="text-danger">*</span></label>
                                <select name="case_type" class="form-control form-control-sm">
                                    <option value="">-- নির্বাচন করুন --</option>
                                    @foreach ($case_types as $value)
                                    <option value="{{ $value->id }}" {{ $value->id == $info->ct_id ? "selected" : ''}}> {{ $value->ct_name }} </option>
                                    @endforeach
                                </select>
                            </div> -->
                            <div class="col-lg-4 mb-5">
                                <label>মামলা নং <span class="text-danger">*</span></label>
                                <input type="text" name="case_no" class="form-control form-control-sm" placeholder="মামলা নং " >
                            </div>
                            <div class="col-lg-4 mb-5">
                                <label>মামলা রুজুর তারিখ <span class="text-danger">*</span></label>
                                <input type="text" name="case_date" class="form-control form-control-sm common_datepicker" placeholder="দিন/মাস/তারিখ" autocomplete="off">
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group row">
                        <div class="col-lg-6 mb-5">
                            <fieldset>
                                <legend>বাদীর বিবরণ</legend>
                                <div id="msgBadi"> </div>
                                <table width="100%" border="1" id="badiDiv" style="border:1px solid #dcd8d8;">
                                    <tr>
                                        <th>বাদীর নাম <span class="text-danger">*</span></th>
                                        <th>পিতা/স্বামীর নাম</th>
                                        <th>ঠিকানা</th>
                                        <th width="50">
                                            <a href="javascript:void();" id="addBadiRow" class="btn btn-sm btn-primary font-weight-bolder pr-2"><i class="fas fa-plus-circle"></i></a>
                                        </th>
                                    </tr>
                                    @foreach ($badis_list as $value)
                                    <tr>
                                    	<td><input type="text" name="badi_name[]" class="form-control form-control-sm" value="{{ $value->badi_name }}"  placeholder=""></td>
        								<td><input type="text" name="badi_spouse_name[]" class="form-control form-control-sm" value="{{ $value->badi_spouse_name }}"  placeholder=""></td>
           								<td><input type="text" name="badi_address[]" class="form-control form-control-sm" value="{{ $value->badi_address }}"  placeholder=""></td>
            							<td><a href="javascript:void();" class="btn btn-sm btn-danger font-weight-bolder pr-2" data-id="{{ $value->id }}"  onclick="removeRowBadiFunc(this)"> <i class="fas fa-minus-circle"></i></a></td>
            							<input type="hidden" name="hide_badi_id[]" value="{{ $value->id }}">
                                    </tr>
                                   @endforeach
                                </table>
                            </fieldset>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <fieldset>
                                <legend>বিবাদীর বিবরণ</legend>
                                <div id="msgBibadi"> </div>
                                <table width="100%" border="1" id="bibadiDiv" style="border:1px solid #dcd8d8;">
                                    <tr>
                                        <th>বিবাদীর নাম <span class="text-danger">*</span></th>
                                        <th>পিতা/স্বামীর নাম</th>
                                        <th>ঠিকানা</th>
                                        <th width="50">
                                            <a href="javascript:void();" id="addBibadiRow" class="btn btn-sm btn-primary font-weight-bolder pr-2"><i class="fas fa-plus-circle"></i></a>
                                        </th>
                                    </tr>
                                    @foreach ($bibadis_list as $value)
                                    <tr>
                                    	<td><input type="text" name="bibadi_name[]" value="{{ $value->bibadi_name }}" class="form-control form-control-sm" placeholder=""></td>
                                       <td><input type="text" name="bibadi_spouse_name[]" value="{{ $value->bibadi_spouse_name }}" class="form-control form-control-sm" placeholder=""></td>
                                       <td><input type="text" name="bibadi_address[]" value="{{ $value->bibadi_address }}" class="form-control form-control-sm" placeholder=""></td>
                                       <td><a href="javascript:void();" class="btn btn-sm btn-danger font-weight-bolder pr-2" data-id="{{ $value->id }}" onclick="removeRowBibadiFunc(this)"> <i class="fas fa-minus-circle"></i></a></td>
                                       <input type="hidden" name="hide_bibadi_id[]" value="{{ $value->id }}">
                                   </tr>
                                   @endforeach
                               </table>
                           </fieldset>
                       </div>
                   </div>

                   <fieldset class="mb-8">
                    <legend>তফশীল বিবরণ </legend>
                    <div class="form-group row">
                        <div class="col-lg-12 mb-5">
                            <label></label>
                            <textarea name="tafsil" class="form-control" id="exampleTextarea" rows="3" spellcheck="false" value="{{ $info->tafsil }}">{{ $info->tafsil }}</textarea>
                        </div>
                    </div>
                </fieldset>

                <div class="form-group row">
                    <div class="col-lg-12 mb-5">
                        <fieldset>
                            <legend>জরিপের বিবরণ</legend>
                                <div id="msgSurvey"> </div>
                            <table width="100%" border="1" id="surveyDiv" style="border:1px solid #dcd8d8;">
                                <tr>
                                    <th>জরিপের ধরণ <span class="text-danger">*</span></th>
                                    <th>খতিয়ান নং</th>
                                    <th>দাগ নং</th>
                                    <th>জমির শ্রেণী</th>
                                    <th>জমির পরিমাণ (শতক)</th>
                                    <th>নালিশী জমির পরিমাণ (শতক)</th>
                                    <th width="50">
                                        <a href="javascript:void();" id="addSurveyRow" class="btn btn-sm btn-primary font-weight-bolder pr-2"><i class="fas fa-plus-circle"></i></a>
                                    </th>
                                </tr>
                                @foreach ($survey_list as $value)
                                <tr>
									<td>
										<select name="st_id[]" class="form-control form-control-sm">
											@foreach ($surveys as $val)
	                                    		<option value="{{ $val->id }}" {{ $val->id == $value->st_id ? "selected" : ''}}> {{ $val->st_name }} </option>
	                                   		 @endforeach
                               			</select>
                               		</td>
            						<td><input type="text" name="khotian_no[]" class="form-control form-control-sm" value="{{ $value->khotian_no }}"  placeholder=""></td>
            						<td><input type="text" name="daag_no[]" class="form-control form-control-sm" value="{{ $value->daag_no }}"  placeholder=""></td>
            						<td>
            							<select name="lt_id[]" class="form-control form-control-sm">
            								@foreach ($land_types as $val)
                                    			<option value="{{ $val->id }}" {{ $val->id == $value->lt_id ? "selected" : ''}}> {{ $val->lt_name }} </option>
                                   			@endforeach
            							</select>
            						</td>
            						<td><input type="number" name="land_size[]" class="form-control form-control-sm" value="{{ $value->land_size }}"  placeholder=""></td>
            						<td><input type="number" name="land_demand[]" class="form-control form-control-sm" value="{{ $value->land_demand }}"  placeholder=""></td>
            						<td><a href="javascript:void();" class="btn btn-sm btn-danger font-weight-bolder pr-2" onclick="removeRowSurveyFunc(this)"> <i class="fas fa-minus-circle"></i></a></td>
            						<input type="hidden" name="hide_survey_id[]" value="{{ $value->id }}">
                                </tr>
                                @endforeach
                            </table>
                        </fieldset>
                    </div>
                </div>


                <fieldset>
                    <legend>চৌহদ্দীর বিবরণ </legend>
                    <div class="col-lg-12 mb-5">
                        <label></label>
                        <textarea name="chowhaddi" class="form-control" id="exampleTextarea" rows="3" spellcheck="false" value="{{ $info->chowhaddi }}">{{ $info->chowhaddi }}</textarea>
                    </div>
                </fieldset>
                <br>
                <div class="form-group row">
                    <div class="col-lg-6 mb-5">
                        <fieldset>
                            <legend>কারণ দর্শাইবার স্ক্যান কপি সংযুক্তি <span class="text-danger">*</span></legend>
                            <div class="col-lg-12 mb-5">
                                <div class="form-group">
                                    <label></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" name="show_cause" class="custom-file-input" id="customFile" />
                                        <label class="custom-file-label" for="customFile">ফাইল নির্বাচন করুন</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-lg-6 mb-5">
                        <fieldset>
                            <legend>মন্তব্য </legend>
                            <div class="col-lg-12 mb-5">
                                <label></label>
                                <textarea name="comments" class="form-control" id="comments" rows="1" spellcheck="false"value="{{ $info->comments }}">{{ $info->comments }}</textarea>
                            </div>
                        </fieldset>
                    </div>
                </div>


               <!--  <fieldset class="col-lg-6 mb-6">
                    <legend>কারণ দর্শাইবার স্ক্যান কপি সংযুক্তি</legend>
                    <div class="col-lg-6 mb-5">
                        <div class="form-group">
                            <label></label>
                            <div></div>
                            <div class="custom-file">
                                <input type="file" name="show_cause" class="custom-file-input" id="customFile" />
                                <label class="custom-file-label" for="customFile">ফাইল নির্বাচন করুন</label>
                            </div>
                        </div>
                    </div>
                </fieldset>
 -->
            </div> <!--end::Card-body-->

                <!-- <div class="card-footer text-right bg-gray-100 border-top-0">
                    <button type="reset" class="btn btn-primary">সংরক্ষণ করুন</button>
                </div> -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-5"></div>
                        <div class="col-lg-7">
                            <button type="submit" class="btn btn-primary mr-2">সংরক্ষণ করুন</button>
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
        var hostname = window.location.host;
        console.log(hostname);
        jQuery(document).ready(function ()
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //Load First row
            // addBadiRowFunc();
            // addBibadiRowFunc();
            // addSurveyRowFunc();

            // Dynamic Dropdown
            var load_url = "{{ asset('media/custom/preload.gif') }}";

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
                    url : '{{url("/")}}/case/dropdownlist/getdependentmouja/'+dataID,
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
            items+= '<input type="hidden" name="hide_badi_id[]">';
            items+= '</tr>';

            $('#badiDiv tr:last').after(items);
            //scout_id_select2_dd();
        }

        //remove row
        function removeBadiRow(id){
            $(id).closest("tr").remove();
        }

        function removeRowBadiFunc(id){
          var dataId = $(id).attr("data-id");
        	// dd($id);
          alert(dataId);

          if (confirm("Are you sure you want to delete this information from database?") == true) {
            $.ajax({
                type: "POST",
                url: "/case/ajax_badi_del/"+dataId,
                success: function (response) {
                    $("#msgBadi").addClass('alert alert-success').html(response);
                    $(id).closest("tr").remove();
                }
            	});
        	}
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

        function removeRowBibadiFunc(id){
          var dataId = $(id).attr("data-id");
          alert(dataId);

          if (confirm("Are you sure you want to delete this information from database?") == true) {
            $.ajax({
                type: "POST",
                url: "/case/ajax_bibadi_del/"+dataId,
                success: function (response) {
                    $("#msgBibadi").addClass('alert alert-success').html(response);
                    $(id).closest("tr").remove();
                }
            	});
        	}
    	}



    /************************ Add multiple Survey *************************/
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

    function removeRowSurveyFunc(id){
      var dataId = $(id).attr("data-id");
      // alert(dataId);

      if (confirm("Are you sure you want to delete this information from database?") == true) {
        $.ajax({
            type: "POST",
            url: "/case/ajax_survey_del/"+dataId,
            success: function (response) {
                $("#msgSurvey").addClass('alert alert-success').html(response);
                $(id).closest("tr").remove();
            }
        	});
    	}
	}
    </script>
    <!--end::Page Scripts-->
    @endsection







