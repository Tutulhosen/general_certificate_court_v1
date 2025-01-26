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
         <h3 class="card-title h2 font-weight-bolder">{{ $page_title }} </h3>
      </div>
   </div>
   <div class="card-body">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         <p>{{ $message }}</p>
      </div>
      @endif
      @include('messages.inc.search')
      @if($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4)
         {{-- @include('court.search') --}}
      @endif
      <div class="overflow-auto">


      <table class="table table-hover mb-6 font-size-h6">
         <thead class="thead-customStyle2">
            <tr>
               <th scope="col" width="30">ক্রমিক নং</th>
               <th scope="col">নাম</th>
               <th scope="col">ইউজার</th>
               <th scope="col">ইউজার রোল</th>
               <th scope="col">অফিসের নাম</th>
               <th scope="col">ইমেইল এড্রেস</th>
               <th scope="col">পদক্ষেপ</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($users as $row)
                @if ($row->id != Auth::user()->id)
                    <tr>
                        {{-- <th scope="row" class="tg-bn">{{ en2bn(++$i) }}</th> --}}
                        <th scope="row" class="tg-bn">
                            @if ($row->profile_pic != null)
                            <div class="symbol symbol-circle symbol-40">
                                <img alt="Pic" src="{{ url('/') }}/uploads/profile/{{ $row->profile_pic }}"/>
                                {{-- <i class="symbol-badge bg-primary"></i> --}}
                            </div>
                           @else
                           @php
                              $str = $row->username;
                           @endphp
                            <div class="symbol symbol-circle symbol-40">
                                <span class="symbol-label bg-danger font-size-h4 text-capitalize text-light">{{ substr($str, 0, 1) }}</span>
                            </div>
                           @endif
                        </th>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->username }}</td>
                        <td>{{ $row->role_name }}</td>
                        <td>{{ $row->office_name_bn }}, {{ $row->upazila_name_bn }} {{ $row->district_name_bn }}</td>
                        <td>{{ $row->email }}</td>
                        <td>
                            <a href="{{ route('messages_single', $row->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">বার্তা পাঠান</a>
                        </td>
                    </tr>
                @endif
            @endforeach
         </tbody>
      </table>
    </div>
      {!! $users->links() !!}
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


