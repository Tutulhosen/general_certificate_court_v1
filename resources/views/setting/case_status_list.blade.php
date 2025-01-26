@extends('layouts.default')

@section('content')

<!--begin::Card-->
<div class="card card-custom col-lg-12 m-auto">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
      </div>
      <div class="card-toolbar">        
         <a href="{{ route('case-status.add') }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-plus"></i>নতুন স্ট্যাটাস এন্ট্রি
         </a>                
      </div>
   </div>
      <div class="card-body">
         @if ($message = Session::get('success'))
         <div class="alert alert-success">
            {{ $message }}
         </div>
         @endif
         <table class="table table-hover mb-6 font-size-h6">
            <thead class="thead-light">
               <tr>
                  <th scope="col">#</th>
                  <th scope="col">মামলার স্ট্যাটাসের নাম</th>
                  <th scope="col">পদক্ষেপ</th>
            </thead>
            <tbody>
            	@php $i=1 @endphp
            	@foreach ($case_status as $row)
                  <tr>
                     <td scope="row" class="tg-bn">{{ en2bn($i) }}.</td>
                     <td>{{ $row->status_name }}</td>
                     <td>
                        <div class="btn-group float-right">
                           <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                           <div class="dropdown-menu">
                              <a class="dropdown-item" href="{{ route('case-status.details', $row->id) }}">বিস্তারিত তথ্য</a>
                                 <a class="dropdown-item" href="{{ route('case-status.edit', $row->id) }}">সংশোধন করুন</a>
                                <div class="dropdown-divider"></div>
                           </div>
                        </div>
                     </td>
                     
                  </tr>
                  @php $i++ @endphp
               @endforeach
            </tbody>
         </table>
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


