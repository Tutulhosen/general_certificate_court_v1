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
            <form action="{{ route('mouja.save') }}" class="form" method="POST">
            @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-4 mb-5">
                            <label>বিভাগের নাম <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm"name="division_id" id="division_id">
                                <option>-- নির্বাচন করুন --</option>
                                @foreach ($districts as $value)
                                    <option value="{{ $value->division_id }}"> {{ $value->division_name_bn }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 mb-5">
                            <label>জেলা <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" name="district_id" id="district">
                                <option value="">-- নির্বাচন করুন --</option>
                                @foreach ($districts as $value)
                                    <option value="{{ $value->id }}"> {{ $value->district_name_bn }} </option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="col-lg-4 mb-5">
                            <label>উপজেলা <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" name="upazila_id" id="upazila_id">
                                <span id="loading"></span>
                                <option value="">-- নির্বাচন করুন --</option>
                                @foreach ($upazilas as $value)
                                    <option value="{{ $value->id }}"> {{ $value->upazila_name_bn }} </option>
                                @endforeach 
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                    	<div class="form-group col-lg-6">
				                <label for="mouja_name_bn" class=" form-control-label">মৌজার নাম <span class="text-danger">*</span></label>
				                <input type="text" id="mouja_name_bn" name="mouja_name_bn" placeholder="মৌজার নাম লিখুন" class="form-control form-control-sm">
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
                          <h4 class="modal-title">মৌজা এন্ট্রি প্রিভিউ</h4>
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
                                    <td class="tg-nluh" id="previewDistrict"></td>
                                </tr>
                                <tr>
                                    <th class="tg-19u4 text-center">উপজেলা </th>
                                    <td class="tg-nluh" id="previewUpazila_id"></td>
                                </tr>
                                <tr>
                                    <th class="tg-19u4 text-center">মৌজার নাম</th>
                                    <td class="tg-nluh" id="previewMouja_name_bn"></td>
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



    <script>
        $('document').ready(function(){
            $('#preview').on('click',function(){
                var division_id = $('#division_id option:selected').text();
                var district = $('#district option:selected').text();
                var upazila_id = $('#upazila_id option:selected').text();
                var mouja_name_bn = $('#mouja_name_bn').val();
                $('#previewDivision_id').html(division_id);
                $('#previewDistrict').html(district);
                $('#previewUpazila_id').html(upazila_id);
                $('#previewMouja_name_bn').html(mouja_name_bn);
                
            });
        });  
    </script>
    @endsection     

   
    <!--end::Page Scripts-->


