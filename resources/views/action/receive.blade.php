@extends('layouts.default')

@section('content')

<!--begin::Card-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
      </div>
   </div>
   <div class="card-body">

      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         {{ $message }}
      </div>
      @endif

      <table class="table table-hover mb-6 font-size-h5">
         <thead class="thead-light font-size-h5">
            <tr>
               <th scope="col" width="30">#</th>
               <th scope="col">আদালতের নাম</th>
               <th scope="col">মামলা নং</th>
               <th scope="col">মামলার তারিখ</th>
               <th scope="col">উপজেলা</th>
               <th scope="col">মৌজা</th>
               <!-- <th scope="col">অফিস হতে প্রেরণের তারিখ</th>
               <th scope="col">জবাব পাওয়ার তারিখ</th>
               <th scope="col">বিজ্ঞ জি.পি নিকট প্রেরণ</th> -->
               <th scope="col" width="100">স্ট্যাটাস</th>
               <th scope="col" width="150">পদক্ষেপ</th>
            </tr>
         </thead>
         <tbody>
            <?php $i=0; ?>
            @foreach ($cases as $row)
            <?php
               $caseStatus = '';
               if($row->status == 1){
                  $caseStatus = '<span class="label label-inline label-light-primary font-weight-bold">নতুন মামলা</span>';
               }elseif ($row->status === 2){
                  $caseStatus = '<span class="label label-inline label-light-primary font-weight-bold">আপিল মামলা</span>';
               }elseif ($row->status === 3){
                  $caseStatus = '<span class="label label-inline label-light-primary font-weight-bold">সম্পাদিত মামলা</span>';
               }
            ?>
            <tr>
               <td scope="row">{{ en2bn(++$i) }}.</td>
               <td>{{ $row->court_name }}</td>
               <td>{{ $row->case_number }}</td>
               <td>{{ $row->case_date }}</td>
               <td>{{ $row->upazila_name_bn }}</td>
               <td>{{ $row->mouja_name_bn }}</td>
               <td><?=$caseStatus?></td>
               <td>
                  <a href="{{ route('action.details', $row->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">বিস্তারিত </a>
                  <!-- <a href="#" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">সংশোধন</a> -->
               </td>
            </tr>
            @endforeach

         </tbody>
      </table>

      <div class="d-flex justify-content-center">
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
   <script src="{{ asset('js/pages/crud/datatables/basic/paginations.js') }}"></script>
   <!--end::Page Scripts-->
   @endsection


