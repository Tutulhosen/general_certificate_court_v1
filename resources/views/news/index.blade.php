@extends('layouts.default')

@section('content')


<!--begin::Card-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-title h2 font-weight-bolder">{{ $page_title }} </h3>
      </div>
      <div class="card-toolbar">
         <a href="{{ route('news.create') }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-plus"></i>নতুন সংবাদ এন্ট্রি
         </a>
      </div>
   </div>
   <div class="card-body">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         <p>{{ $message }}</p>
      </div>
      @endif
      @if(Session::has('status_update'))
      <div  class="alert alert-success" role="alert">{{Session::get('status_update')}}</div>
      @endif
      <div class="card-header-sm bg-primary-o-50">
        <div class="card-title-sm">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="short-tab" data-toggle="tab" href="#short">
                        <span class="nav-icon">
                            <i class="flaticon2-chat-1 text-primary"></i>
                        </span>
                        <span class="nav-text text-dark h6 mt-2">খবর</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="big-tab" data-toggle="tab" href="#big" aria-controls="big">
                        <span class="nav-icon">
                            <i class="flaticon2-chat-1 text-primary"></i>
                        </span>
                        <span class="nav-text text-dark h6 mt-2">জনপ্রিয় সংবাদ</span>
                    </a>
                </li>
            </ul>
        </div>
      </div>

      <div class="card-body" id="CaseDetails">
           <div class="tab-content mt-5" id="myTabContent">
               <div class="tab-pane fade active show" id="short" role="tabpanel"aria-labelledby="short-tab">
                  <div class="clearfix">
                       <div class="row">
                           <table class="table table-hover mb-6 font-size-h6">
                              <thead class="thead-light text-center">
                                 <tr>
                                    <h3>খবরের তালিকা</h3>
                                    <!-- <th scope="col" colspan="7">Short News</th> -->
                                 </tr>
                                 <tr>
                                    <th scope="col" width="30">#</th>
                                    <th scope="col">খবরের বিস্তারিত</th>
                                    <th scope="col">স্ট্যাটাস</th>
                                    <th scope="col">অ্যাকশন</th>
                                 </tr>
                              </thead>
                              <tbody class=" text-center">
                                 @foreach($short_news as $key => $row)
                                       @php
                                          $currentStatus = '';
                                          if($row->status == 1){
                                             $currentStatus = 'প্রকাশিত হয়েছে'; 
                                          }else{
                                             $currentStatus = 'সরিয়ে ফেলা হয়েছে';
                                          }
                                       @endphp
                   
                                       <tr class="text-center">
                                          <td width="1">{{$key+1}}</td>
                                          <td>{{$row->news_details}}</td>
                                          @if($row->status == 1)
                                             <td class="text-success">{{$currentStatus}}</td>
                                          @else
                                             <td class="text-danger">{{$currentStatus}}</td>
                                          @endif
                                          <td width="300">
                                             <a href="{{url('news/edit/'.$row->id)}}"style="color: white !important;">
                                                <button type="button" class="btn-sm btn btn-success">সম্পাদনা</button>
                                             </a>
                                                @if($row->status==1)
                                                   <a href="{{url('news/status/0/'.$row->id)}}"style="color: white !important;">
                                                      <button type="button" class="btn-sm btn btn-warning">অপসারণ</button>
                                                   </a>
                                                @elseif($row->status==0)
                                                   <a href="{{url('news/status/1/'.$row->id)}}"style="color: white !important;">
                                                      <button type="button" class="btn-sm btn btn-primary">পাবলিশ </button>
                                                   </a>
                                                @endif
                                             <a href="{{url('news/delete/'.$row->id)}}" style="color: white !important;"><button type="button" class="btn-sm btn btn-danger"> মুছে ফেলুন</button>
                                             </a>
                                          </td>
                                           
                                       </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="big" role="tabpanel" aria-labelledby="big-tab">
                  <div class="clearfix">
                       <div class="row">
                           <table class="table table-hover mb-6 font-size-h6">
                              <thead class="thead-light text-center">
                                 <tr>
                                    <h3>জনপ্রিয় সংবদের তালিকা </h3>
                                 </tr>
                                 <tr>
                                    <th scope="col" width="30">#</th>
                                    <th scope="col">শিরনাম</th>
                                    <th scope="col">লেখকের নাম</th>
                                    <th scope="col">তারিখ</th>
                                    <th scope="col">বিস্তারিত</th>
                                    <th scope="col">স্ট্যাটাস</th>
                                    <th scope="col">অ্যাকশন</th>
                              </thead>
                              <tbody class=" text-center">
                                 @foreach($big_news as $key => $row)
                                       @php
                                          $currentStatus = '';
                                          if($row->status == 1){
                                             $currentStatus = 'প্রকাশিত হয়েছে'; 
                                          }else{
                                             $currentStatus = 'সরিয়ে ফেলা হয়েছে';
                                          }
                                       @endphp
                   
                                       <tr class="text-center">
                                          <td width="1">{{$key+1}}</td>
                                          <td>{{$row->news_title}}</td>
                                          <td>{{$row->news_writer}}</td>
                                          <td>{{$row->news_date}}</td>
                                          <td>{{$row->news_details}}</td>
                                          @if($row->status == 1)
                                             <td class="text-success">{{$currentStatus}}</td>
                                          @else
                                             <td class="text-danger">{{$currentStatus}}</td>
                                          @endif
                                          <td width="300">
                                             <a href="{{url('news/edit/'.$row->id)}}"style="color: white !important;">
                                                <button type="button" class="btn-sm btn btn-success">সম্পাদনা</button>
                                             </a>
                                                @if($row->status==1)
                                                   <a href="{{url('news/status/0/'.$row->id)}}"style="color: white !important;">
                                                      <button type="button" class="btn-sm btn btn-warning">অপসারণ</button>
                                                   </a>
                                                @elseif($row->status==0)
                                                   <a href="{{url('news/status/1/'.$row->id)}}"style="color: white !important;">
                                                      <button type="button" class="btn-sm btn btn-primary">পাবলিশ </button>
                                                   </a>
                                                @endif
                                             <a href="{{url('news/delete/'.$row->id)}}" style="color: white !important;"><button type="button" class="btn-sm btn btn-danger">মুছে ফেলুন</button>
                                             </a>
                                          </td>
                                           
                                       </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                  </div>
               </div>
           </div>
      </div>
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
         // upazila Dropdown
         jQuery('select[name="district"]').on('change',function(){
            var dataID = jQuery(this).val();
            jQuery("#upazila_id").after('<div class="loadersmall"></div>');
            
            if(dataID)
            {
               jQuery.ajax({
                  url : '/court-setting/dropdownlist/getdependentupazila/' +dataID,
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
<!--end::Page Scripts-->
@endsection


