  @php
    $roleID = Auth::user()->role_id;
    $officeInfo = user_office_info();
  @endphp  

@extends('layouts.default')

@section('content')
 

<!--begin::Card-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-title h2 font-weight-bolder"> {{ $page_title }} </h3>
      </div>
      <!-- <div class="card-toolbar">        
         <a href="{{ route('user-management.create') }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-plus"></i>নতুন অফিস এন্ট্রি
         </a>                
      </div> -->
   </div>
   <div class="card-body">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         <p>{{ $message }}</p>
      </div>
      @endif
      @include('office_ulo.searchForAdd')

      <!-- <form class="form-inline" method="GET">      
                
         <div class="form-group mb-2 mr-2">
            <select name="division" class="form-control">
               <option value="">-বিভাগ নির্বাচন করুন-</option>
               @foreach ($divisions as $value)
               <option value="{{ $value->id }}"> {{ $value->division_name_bn }} </option>
               @endforeach
            </select>
         </div>
         <div class="form-group mb-2 mr-2">
            <select name="district" id="district_id" class="form-control">
               <option value="">-জেলা নির্বাচন করুন-</option>              
            </select>
         </div>
         <div class="form-group mb-2 mr-2">
            <select name="upazila" id="upazila_id" class="form-control">
               <option value="">-উপজেলা নির্বাচন করুন-</option>               
            </select>
         </div>
         <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান করুন</button>
      </form> -->

         @if($offices != NULL)
            <form action="{{ url('/ulo/save') }}" class="form-group" method="POST">
                @csrf

                @if($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4 )
                  <input type="hidden" name="division" value="{{$_GET['division']}}">
                  <input type="hidden" name="district" value="{{$_GET['district']}}">
                  <input type="hidden" name="upazila" value="{{$_GET['upazila']}}">
                @elseif($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13)
                  <input type="hidden" name="division" value="{{$officeInfo->division_id}}">
                  <input type="hidden" name="district" value="{{$officeInfo->district_id}}">
                  <input type="hidden" name="upazila" value="{{$_GET['upazila']}}">
                @endif
                <div class="form-group mb-2 mr-2">
                     <select name="office_id" class="form-control">
                        <option value="">-ভূমি অফিস নির্বাচন করুন-</option>
                        @foreach ($ulos as $value)
                        <option value="{{ $value->id }}"> {{ $value->office_name_bn }} </option>
                        @endforeach
                     </select>
                  </div>
               <table class="table table-hover mb-6 font-size-h6" >
                   <thead class="thead-light">
                      <tr>
                         <!-- <th scope="col" width="30">#</th> -->
                          <th scope="col" >
                           সিলেক্ট করুণ
                        </th>
                         <th scope="col">মৌজার নাম</th>
                         <th scope="col">জে.এল নং</th>
                      </tr>
                   </thead>
                   <tbody>
                      @foreach ($offices as $row)
                      <?php
                        if($row->status == 1){
                            $officeStatus = '<span class="label label-inline label-light-primary font-weight-bold">এনাবল</span>';
                         }else{
                            $officeStatus = '<span class="label label-inline label-light-primary font-weight-bold">ডিসএবল</span>';
                         }
                      ?>
                     <tr>
                        <td>
                           <div class="checkbox-inline">
                              <label class="checkbox">
                              <input type="checkbox" name="mouja_id[]"  value="{{ $row->id }}" /><span></span>
                           </div>
                        </td>
                         <td>{{ $row->mouja_name_bn }}</td>
                         <td>{{ en2bn($row->jl_no) }}</td>
                      </tr>
                      @endforeach
                   </tbody>
               </table>  
                   <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2">সংরক্ষণ করুন</button>
            </form>  
         @endif
   </div>
</div>
<!--end::Card-->

@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->
@endsection     

{{-- Scripts Section Related Page--}}
@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
<!--end::Page Scripts-->


   <script type="text/javascript">
     jQuery(document).ready(function ()
      {


			// $("#listForm").hide();
			$("#upazila_id").click(function(){
			// $("#listForm").show();
			});

			/*$("#no").click(function(){
			$("#listForm").hide();
			});*/


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
                 url : '/ulo/dropdownlist/getdependentdistrict/' +dataID,
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
             if(dataID)
             {
               jQuery.ajax({
                 url : '/ulo/dropdownlist/getdependentupazila/' +dataID,
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
               }
               else
               {
                  $('select[name="upazila"]').empty();
               }
            });

         // Upazila Land Office Dropdown
         jQuery('select[name="upazila"]').on('change',function(){
             var dataID = jQuery(this).val(); 
             // var category_id = jQuery('#category_id option:selected').val();
             jQuery("#ulo_id").after('<div class="loadersmall"></div>');
             // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
             // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
             // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
             // jQuery('.loadersmall').remove();
             if(dataID)
             {
               jQuery.ajax({
                 url : '/ulo/dropdownlist/getdependentulo/' +dataID,
                 type : "GET",
                 dataType : "json",
                 success:function(data)
                 {
                  jQuery('select[name="ulo"]').html('<div class="loadersmall"></div>');
                     //console.log(data);
                     // jQuery('#mouja_id').removeAttr('disabled');
                     // jQuery('#mouja_id option').remove();
                     
                     jQuery('select[name="ulo"]').html('<option value="">-- নির্বাচন করুন --</option>');
                     jQuery.each(data, function(key,value){
                      jQuery('select[name="ulo"]').append('<option value="'+ key +'">'+ value +'</option>');
                   });
                     jQuery('.loadersmall').remove();
                     // $('select[name="mouja"] .overlay').remove();
                     // $("#loading").hide();
                  }
               });
               }
               else
               {
                  $('select[name="upazila_land_office"]').empty();
               }
            });
         });
   </script>

   <!--end::Page Scripts-->
   @endsection



