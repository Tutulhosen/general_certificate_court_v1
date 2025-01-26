@php
    $roleID = Auth::user()->role_id;
    $officeInfo = user_office_info();
@endphp

@extends('layouts.default')

@section('content')

<style type="text/css">
    #appRowDiv td{padding: 5px; border-color: #ccc;}
    #appRowDiv th{padding: 5px;text-align:center;border-color: #ccc; color: black;}
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
            	@if ($errors->any())
            	 	
				     @foreach ($errors->all() as $error)
				    	<li class="alert alert-danger">{{ $error }}</li>
				     @endforeach
 					
 				@endif
            <!--begin::Form-->
            <form action="{{ route('court.save') }}" class="form" method="POST">
            @csrf
                <div class="card-body">
                    <div class="form-group row">
                        @if($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4 )
                            <div class="col-lg-4 mb-5">
                                <label>বিভাগ <span class="text-danger">*</span></label>
                                <select name="division" id="division_id" class="form-control form-control-sm" >
                                    <option value="">-- নির্বাচন করুন --</option>
                                    @foreach ($division as $value)
                                    <option value="{{ $value->id }}" {{ old('division') == $value->id ? 'selected' : '' }}> {{ $value->division_name_bn }} </option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-lg-4 mb-5">
                                <label>জেলা <span class="text-danger">*</span></label>
                                <select name="district" id="district_id" class="form-control form-control-sm" >
                                    <option value="">-- নির্বাচন করুন --</option>
                                    
                                </select>
                            </div>

                            <div class="col-lg-4 mb-5">
                                <label>আদালতের লেভেল <span class="text-danger">*</span></label>
                                    <div class="radio">
                                        <label>
                                            <input onchange="UpazilaDivHideShow(this)" id="district_level" type="radio"
                                                name="court_level" value="1"
                                                checked="checked" class="">
                                            জেলা
                                        </label>
                                        <label class="ml-2">
                                            <input onchange="UpazilaDivHideShow(this)" id="upazila_level" type="radio"
                                                name="court_level" value="2"
                                                class="">
                                            উপজেলা
                                        </label>
                                    </div>
                                
                            </div>
                            <div class="col-lg-4 mb-5" id="upazilaDiv" style="display: none;">
                                <label>উপজেলা <span class="text-danger">*</span></label>
                                <select name="upazila" id="upazila_id" class="form-control form-control-sm" >
                                    <option value="">-- নির্বাচন করুন --</option>
                                    
                                </select>
                            </div>
                        @elseif(($roleID == 37 || $roleID == 38 || $roleID == 39))    
                            <div class="col-lg-6 mb-5">
                                <label>জেলা <span class="text-danger">*</span></label>
                                <select name="district" id="district_id" class="form-control form-control-sm" >
                                    <option value="">-- নির্বাচন করুন --</option>
                                    @foreach ($district as $value)
                                    <option value="{{ $value->id }}" {{ old('district') == $value->id ? 'selected' : '' }}> {{ $value->district_name_bn }} </option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <label>উপজেলা <span class="text-danger">*</span></label>
                                <select name="upazila" id="upazila_id" class="form-control form-control-sm" >
                                    <option value="">-- নির্বাচন করুন --</option>
                                    
                                </select>
                            </div>
                       
                	    @endif    
                           
                            <div class="form-group col-lg-6">
                                <label for="court_name" class=" form-control-label">আদালতের নাম <span class="text-danger">*</span></label>
                                <input type="text" id="court_name" name="court_name" placeholder="আদালতের নাম লিখুন" class="form-control form-control-sm">
                                <span style="color: red">
                                    {{ $errors->first('name') }}
                                </span>
                            </div>

    		             	<div class="col-lg-3">
    		                  <label>স্ট্যাটাস</label>
    							<div class="radio-inline">
    								<label class="radio">
    								<input type="radio" name="status" value="1" checked="checke" />
    								<span></span>এনাবল</label>
    								<label class="radio">
    								<input type="radio" name="status" value="0" />
    								<span></span>ডিসএবল</label>
    							</div>
    	                	</div>
                    


                </div> <!--end::Card-body-->

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-5"></div>
                        <div class="col-lg-7">
                            <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary mr-3" id="preview">প্রিভিউ</button>
                            <button type="submit" class="btn btn-primary mr-2" onclick="return confirm('আপনি কি সংরক্ষণ করতে চান?')">সংরক্ষণ করুন</button>
                        </div>
                    </div>
                </div>
                    <div class="modal fade" id="myModal">
                    <div class="modal-dialog">
                      <div class="modal-content">
                      
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">আদালত এন্ট্রি প্রিভিউ</h4>
                          <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body">
                           <table class="tg">
                                <tr>
                                    <th class="tg-19u4 text-center">বিভাগের নাম</th>
                                    <td class="tg-nluh" id="previewDivision_id"></td>
                                </tr>
                                <tr>
                                    <th class="tg-19u4 text-center">জেলা</th>
                                    <td class="tg-nluh" id="previewDistrict_id"></td>
                                </tr>
                                <tr>
                                    <th class="tg-19u4 text-center">আদালতের নাম</th>
                                    <td class="tg-nluh" id="previewCourt_name"></td>
                                </tr>
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

<script type="text/javascript">

        function UpazilaDivHideShow(sel){
            var status = sel.value
            if(status == '1'){
                $("#upazilaDiv").hide();
            }else{
                $("#upazilaDiv").show();
            }
        }
        jQuery(document).ready(function ()
        {
            //Load First row

            // Dynamic Dropdown
            var load_url = "{{ asset('media/custom/preload.gif') }}";

            jQuery('select[name="division"]').on('change',function(){
                var dataID = jQuery(this).val(); 
                jQuery("#district_id").after('<div class="loadersmall"></div>');
                
                if(dataID)
                {
                  jQuery.ajax({
                    url : '/court-setting/dropdownlist/getdependentdistrict/' +dataID,
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

            //===========Upazila================//

            

            jQuery('select[name="district"]').on('change',function(){
                var dataID = jQuery(this).val(); 
                jQuery("#upazila_id").after('<div class="loadersmall"></div>');
                
                if(dataID)
                {
                  jQuery.ajax({
                    url : '/court-setting/dropdownlist/getDependentUpazila/' +dataID,
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
              }
              else
              {
                  $('select[name="upazila"]').empty();
              }
          });

        });
</script>        

<script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
<script>
        // common datepicker
        $('.common_datepicker').datepicker({  
            format: "dd/mm/yyyy",         
            todayHighlight: true,
            orientation: "bottom left"
        });
    </script>




    <script>
        $('document').ready(function(){
            $('#preview').on('click',function(){
                var division_id = $('#division_id option:selected').text();
                var district_id = $('#district_id option:selected').text();
                var ct_id = $('#ct_id option:selected').text();
                var court_name = $('#court_name').val();
                $('#previewDivision_id').html(division_id);
                $('#previewDistrict_id').html(district_id);
                $('#previewCt_id').html(ct_id);
                $('#previewCourt_name').html(court_name);
                
            });
        });  
    </script>
    @endsection     

   
    <!--end::Page Scripts-->


