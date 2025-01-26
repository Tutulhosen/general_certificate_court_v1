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
				    	<div class="alert alert-danger">{{$error}}</div>
				     @endforeach
 					
 				@endif
            <!--begin::Form-->
            <form action="{{ url('/settings/mouja/update/'.$mouja->id) }}" class="form" method="POST">
            @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-4 mb-5">
                            <label>বিভাগের নাম <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm"name="division_id">
                                <option>-- নির্বাচন করুন --</option>
                                @foreach ($districts as $value)
                                    <option value="{{ $value->division_id }}" {{ $value->division_id == $mouja->division_id ? "selected" : ''}}> {{ $value->division_name_bn }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 mb-5">
                            <label>জেলা <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" name="district_id" id="district">
                                <option value="">-- নির্বাচন করুন --</option>
                                @foreach ($districts as $value)
                                    <option value="{{ $value->id }}"  {{ $value->id == $mouja->district_id ? "selected" : ''}}> {{ $value->district_name_bn }} </option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="col-lg-4 mb-5">
                            <label>উপজেলা <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" name="upazila_id">
                                <span id="loading"></span>
                                <option value="">-- নির্বাচন করুন --</option>
                                @foreach ($upazilas as $value)
                                    <option value="{{ $value->id }}"  {{ $value->id == $mouja->upazila_id ? "selected" : ''}}> {{ $value->upazila_name_bn }} </option>
                                @endforeach 
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                    	<div class="form-group col-lg-6">
				                <label for="mouja_name_bn" class=" form-control-label">মৌজার নাম <span class="text-danger">*</span></label>
				                <input type="text" id="mouja_name_bn" name="mouja_name_bn" placeholder="মৌজার নাম লিখুন" class="form-control form-control-sm" value="{{ $mouja->mouja_name_bn }}">
				                <span style="color: red">
	                				{{ $errors->first('name') }}
	                			</span>
				            </div>

		             	<div class="col-lg-4">
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
                    </div>


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
        jQuery(document).ready(function ()
        {
            jQuery('select[name="district"]').on('change',function(){
               var dataID = jQuery(this).val();
               $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
               if(dataID)
               {
                  jQuery.ajax({
                     url : 'dropdownlist/getdependentmouja/' +dataID,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        //console.log(data);
                        jQuery('select[name="upazila"]').html('<option value="">-- নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="upazila"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        $("#loading").hide();
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
    <!--end::Page Scripts-->
    @endsection


