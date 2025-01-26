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
            <form action="{{ route('court.update' , $courts->id) }}" class="form" method="POST">
            @csrf
                <div class="card-body">
                    <div class="form-group row">
                            <div class="col-lg-3 mb-5">
                                <label>বিভাগ <span class="text-danger">*</span></label>
                                <select name="division" id="division_id" class="form-control form-control-sm" >
                                    <option value="">-- নির্বাচন করুন --</option>
                                    @foreach ($division as $value)
                                    <option value="{{ $value->id }}"  {{ $value->id == $courts->division_id ? "selected" : ''}}> {{ $value->division_name_bn }} </option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-lg-3 mb-5">
                                <label>জেলা <span class="text-danger">*</span></label>
                                <select name="district" id="district_id" class="form-control form-control-sm" >
                                    <option value="">-- নির্বাচন করুন --</option>
                                     @foreach ($districts as $value)
                                    <option value="{{ $value->id }}"  {{ $value->id == $courts->district_id ? "selected" : ''}}> {{ $value->district_name_bn }} </option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="court_name" class=" form-control-label">আদালতের নাম <span class="text-danger">*</span></label>
                                <input type="text" id="court_name" name="court_name" placeholder="আদালতের নাম লিখুন" class="form-control form-control-sm" value="{{ $courts->court_name }}">
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
                                    <th class="tg-19u4 text-center">আদালতের ধরণ </th>
                                    <td class="tg-nluh" id="previewCt_id"></td>
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
        jQuery(document).ready(function ()
        {
            //Load First row

            // Dynamic Dropdown
            var load_url = "{{ asset('media/custom/preload.gif') }}";

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
                    url : '/court-setting/dropdownlist/getdependentdistrict/' +dataID,
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


