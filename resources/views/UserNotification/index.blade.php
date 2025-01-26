@extends('layouts.default')

@section('content')

<!--begin::Card-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
      </div>
      @if(Auth::user()->role_id == 5)
      <div class="card-toolbar">
         <a href="{{ url('case/add') }}" class="btn btn-sm btn-primary font-weight-bolder">
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
               <th scope="col">পরবর্তী শুনানির তারিখ</th>
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
            <tr>
               <td scope="row" class="tg-bn">{{ en2bn(++$i) }}.</td>
               <td>{{ en2bn($row->case_register->case_number) ?? '' }}</td>
               <td>{{ en2bn($row->case_register->case_date) ?? '' }}</td>
               <td class="text-danger">
                   {{ en2bn(App\Models\CaseHearing::select('hearing_date')->orderby('id', 'DESC')->where('case_id', $row->case_id)->first()->hearing_date ?? '') }}
                   {{-- {{ en2bn($row->hearing_date) ?? '' }} --}}
                </td>
               <td>{{ $row->case_register->court->court_name ?? '' }}</td>
               <td>{{ $row->case_register->upazila->upazila_name_bn ?? '' }}</td>
               <td>{{ $row->case_register->mouja->mouja_name_bn ?? '' }}</td>
               <td>
                   <a class="btn btn-primary btn-sm" href="{{ route('case.details', $row->case_register->id) }}">বিস্তারিত</a>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>

      <div class="d-flex justify-content-center">
         {{-- {!! $cases->links() !!} --}}
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


