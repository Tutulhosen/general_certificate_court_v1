@extends('layouts.default')

@section('content')


<!--begin::Card-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
      </div>

      @if(Auth::user()->role_id == 5 OR Auth::user()->role_id == 8)
      <div class="card-toolbar">
      <a href="{{ url('case/create') }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-plus"></i>পুরাতন চলমান মামলা এন্ট্রি
         </a>
      </div>
      @endif
   </div>

   <div class="card-body">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         {{ $message }}
      </div>
      @endif

      <!-- <form class="form-inline" method="GET">
         <div class="form-group mb-2 mr-2">
            <select name="court" class="form-control">
               <option value="">-আদালত নির্বাচন করুন-</option>
               @foreach ($courts as $value)
               <option value="{{ $value->id }}"> {{ $value->court_name }} </option>
               @endforeach
            </select>
         </div>
         <div class="form-group mb-2 mr-2">
            <input type="text" class="form-control " name="case_no" placeholder="মামলা নং" value="">
         </div>
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
         <div class="form-group mb-2 mr-2">
            <select name="gp" class="form-control">
               <option value="">-জিপি নির্বাচন করুন-</option>
               @foreach ($gp_users as $value)
               <option value="{{ $value->id }}"> {{ $value->name }} </option>
               @endforeach
            </select>
         </div>
         <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান করুন</button>
      </form> -->

      @include('case.search')

      <table class="table table-hover mb-6 font-size-h5">
         <thead class="thead-light">
            <tr>
               <th scope="col" width="30">#</th>
               <th scope="col">মামলা নং</th>
               <th scope="col">মামলার তারিখ</th>
               <th scope="col">আদালতের নাম</th>
               <th scope="col">উপজেলা</th>
               <th scope="col">মৌজা</th>
               <!-- <th scope="col">অফিস হতে প্রেরণের তারিখ</th>
               <th scope="col">জবাব পাওয়ার তারিখ</th>
               <th scope="col">বিজ্ঞ জি.পি নিকট প্রেরণ</th> -->
               <!-- <th scope="col" width="100">স্ট্যাটাস</th> -->
               <th scope="col" width="70">পদক্ষেপ</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($cases as $row)
            <?php
               // if($row->status == 1){
               //    $caseStatus = '<span class="label label-inline label-light-primary font-weight-bold">নতুন মামলা</span>';
               // }
            ?>
            <tr>
               <td scope="row">{{ en2bn(++$i) }}.</td>
               <td>{{ $row->case_number }}</td>
               <td>{{ $row->case_date }}</td>
               <td>{{ $row->court_name }}</td>
               <td>{{ $row->upazila_name_bn }}</td>
               <td>{{ $row->mouja_name_bn }}</td>
               <!-- <td><?php //$caseStatus?></td> -->
               <td>
                  <div class="btn-group float-right">
                     <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                     <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('case.details', $row->id) }}">বিস্তারিত তথ্য</a>
                        @if (Auth::user()->role_id == 6 || Auth::user()->role_id == 7 || Auth::user()->role_id == 8 || Auth::user()->role_id == 9)
                        <a class="dropdown-item" href="{{ route('case.old_edit', $row->id) }}">সংশোধন করুন</a>
                        @endif

                        @if(Auth::user()->role_id == 5)
                           @if($row->is_lost_appeal == 0)
                              <div class="dropdown-divider"></div>
                                 @if($row->status == 3)
                                  <a class="alert alert-success" href="javascript:void(0)">আপিল করা হয়েছে</a>
                                 @else
                                 <a class="dropdown-item" href="{{ route('case.create_appeal', $row->id) }}">মামলা আপিল করুন</a>
                                 @endif
                              </div>
                           @endif
                        @endif
                     </div>
                  </div>
                  <!-- <a href="{{ route('case.details', $row->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">বিস্তারিত </a>
                  <a href="{{ route('case.old_edit', $row->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">সংশোধন</a>
               </td> -->
            </tr>
            @endforeach
         </tbody>
      </table>

      <div class="d-flex justify-content-center">
         {!! $cases->links() !!}
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
   });
</script>

<!--end::Page Scripts-->
@endsection



