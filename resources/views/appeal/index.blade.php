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

      @include('appeal.search')

      <table class="table table-hover mb-6 font-size-h5">
         <thead class="thead-customStyle2 font-size-h6">
            <tr>
               <th scope="col" width="30">ক্রমিক নং</th>
               <th scope="col">সার্টিফিকেট  অবস্থা</th>
               <th scope="col">মামলা নম্বর</th>
               <th scope="col">পূর্ববর্তী মামলার নং</th>
               <th scope="col">আবেদনকারীর নাম</th>
               <th scope="col">জেনারেল  সার্টিফিকেট অফিসার</th>
               <th scope="col">মামলার সিদ্ধান্ত</th>
               <th scope="col">পরবর্তী তারিখ </th>
               <th scope="col">প্রক্রিয়া</th>
              
            </tr>
         </thead>
         <tbody>
            <?php
               // if($row->status == 1){
               //    $caseStatus = '<span class="label label-inline label-light-primary font-weight-bold">নতুন মামলা</span>';
               // }
            ?>
            <tr>
               <td scope="row" class="tg-bn">1</td>
               <td>চলমান মামলা</td>
               <td>2600.03.68287.0004.21</td>
               <td>2600.03.68287.0004.01</td>
               <td>Minar Khan</td>
               <td>Ishtiak Ahamed</td>
               <td>Running</td>
               <td>08-12-2021</td>
               <td>প্রক্রিয়া</td>
            </tr>
         </tbody>
      </table>

      
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


