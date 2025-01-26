@extends('layouts.default')

@section('content')

<!--begin::Card-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
      </div>
      @if(Auth::user()->role_id == 5 || Auth::user()->role_id == 8 || Auth::user()->role_id == 19)
      <div class="card-toolbar">
         <a href="{{ route('atcase.create') }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-plus"></i>নতুন মামলা এন্ট্রি
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

     {{-- @include('case.search') --}} 

      <table class="table table-hover mb-6 font-size-h5">
         <thead class="thead-light font-size-h6">
            <tr>
               <th scope="col" width="30">#</th>
               <th scope="col">মামলা নং</th>
               <th scope="col">মামলার তারিখ</th>
               <th scope="col">মামলার কারণ</th>
               <th scope="col">আদালতের নাম</th>
               <th scope="col">বিভাগ</th>
               <th scope="col">জেলা</th>
               <!-- <th scope="col">অফিস হতে প্রেরণের তারিখ</th>
               <th scope="col">জবাব পাওয়ার তারিখ</th>
               <th scope="col">বিজ্ঞ জি.পি নিকট প্রেরণ</th> -->
               <!-- <th scope="col" width="100">স্ট্যাটাস</th> -->
               <th scope="col" width="70">পদক্ষেপ</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($cases as $key => $row)
            <?php
               // if($row->status == 1){
               //    $caseStatus = '<span class="label label-inline label-light-primary font-weight-bold">নতুন মামলা</span>';
               // }
            ?>
            <tr>
               <td scope="row" class="tg-bn">{{ en2bn(++$key) }}.</td>
               <td>{{ $row->case_no }}</td>
               <td>{{ en2bn($row->case_date) }}</td>
               <td>
                   {{ $row->case_reason }}
                </td>
               <td>{{ $row->court->court_name }}</td>
               <td>{{ $row->division->division_name_bn }}</td>
               <td>{{ $row->district->district_name_bn }}</td>
               <!-- <td><?php //$caseStatus?></td> -->
               <td>
                  <div class="btn-group float-right">
                     <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                     <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('atcase.show', $row->id) }}">বিস্তারিত তথ্য</a>

                        @if (Auth::user()->role_id == 5 || Auth::user()->role_id == 6 || Auth::user()->role_id == 7 || Auth::user()->role_id == 8 || Auth::user()->role_id == 9 || Auth::user()->role_id == 19)
                           @if($row->status != 3)
                           <a class="dropdown-item" href="{{ route('atcase.edit', $row->id) }}">সংশোধন করুন</a>
                           @endif
                        @endif

                        @if(Auth::user()->role_id == 5)
                           @if($row->is_lost_appeal == 0)
                              <div class="dropdown-divider"></div>
                                 @if($row->status == 2)
                                  <a class="alert alert-success" href="javascript:void(0)">আপিল করা হয়েছে</a>
                                 @else
                                 <a class="dropdown-item" href="{{ route('case.create_appeal', $row->id) }}">মামলা আপিল করুন</a>
                                 @endif
                              </div>
                           @endif
                        @endif
                  </div>
                  <!-- <a href="{{ route('case.details', $row->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">বিস্তারিত </a>
                  <a href="{{ route('case.edit', $row->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">সংশোধন</a> -->
               </td>
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
   <!-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
   <!--end::Page Vendors Styles-->
   @endsection

   {{-- Scripts Section Related Page--}}
   @section('scripts')
   <!-- <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
   <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
 -->


<!--end::Page Scripts-->
@endsection


