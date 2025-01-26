@extends('layouts.default')

@section('content')

<!--begin::Card-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-title h2  ">{{ $page_title }}</h3>
      </div>
   </div>
   <div class="card-body">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         {{ $message }}
      </div>
      @endif
      <table class="table table-hover mb-6  font-size-h4">
         <thead class="thead-light">
            <tr>
               <th scope="col" width="30">#</th>
               <th scope="col">আদালতের নাম</th>
               <th scope="col">মামলা নং</th>
               <th scope="col">মন্তব্য</th>               
               <th scope="col" width="150">পদক্ষেপ</th>
            </tr>
         </thead>
         <tbody>
            <?php $i=0; ?>
            @foreach ($hearing as $row)
            <?php
               $caseStatus = '';
               if($row->status == 1){
                  // $caseStatus = '<span class="label label-inline label-light-primary font-weight-bold">নতুন মামলা</span>';
               }
            ?>
            <tr>
               <td scope="row">{{ ++$i }}.</td>
               <td>{{ $row->court_name }}</td>
               <td>{{ $row->case_number }}</td>
               <td>{{ $row->hearing_comment }}</td>                            
               <td>
                  <a href="{{ route('dashboard.hearing-case-details', $row->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">বিস্তারিত </a>
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
   <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
   <!--end::Page Scripts-->
   @endsection


