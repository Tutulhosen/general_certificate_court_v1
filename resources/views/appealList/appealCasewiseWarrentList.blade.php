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
   <div class="card-body overflow-auto">
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
               {{-- <th scope="col">ক্রমিক নং</th> --}}
               <th scope="col">সার্টিফিকেট অবস্থা</th>
               <th scope="col">মামলা নম্বর</th>
               <th scope="col">পূর্ববর্তী মামলার নং</th>
               <!-- <th scope="col">আবেদনকারীর নাম</th> -->
               <th scope="col">জেনারেল সার্টিফিকেট অফিসার</th>
               <th scope="col">পরবর্তী তারিখ</th>
               <!-- <th scope="col">অফিস হতে প্রেরণের তারিখ</th>
               <th scope="col">জবাব পাওয়ার তারিখ</th>
               <th scope="col">বিজ্ঞ জি.পি নিকট প্রেরণ</th> -->
               <!-- <th scope="col" width="100">স্ট্যাটাস</th> -->
               <th scope="col" width="70">পদক্ষেপ</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($results as $key => $row)
                <tr>

                    <td scope="row" class="tg-bn">{{ en2bn($key+ $results->firstItem()) }}.</td>
                    <td> {{ appeal_status_bng($row->appeal_status) }}</td> {{-- Helper Function for Bangla Status --}}
                    <td>{{ $row->case_no }}</td>
                    <td>{{ $row->prev_case_no }}</td>
                    <td>{{ $row->gco_name }}</td>
                    <td>{{ en2bn($row->next_date) }}</td>
                    <td>
                        <div class="btn-group float-right">
                            <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('appeal.appealView', encrypt($row->id)) }}">বিস্তারিত তথ্য</a>
                                <a class="dropdown-item" href="{{ route('appeal.getWarrentOrderSheets', encrypt($row->id)) }}">গ্রেপ্তারি পরোয়ানা</a>
                                
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
         </tbody>
      </table>

      <div class="d-flex justify-content-center">
         {!! $results->links() !!}
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


