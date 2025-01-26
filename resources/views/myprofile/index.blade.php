@extends('layouts.default')

@section('content')
 

<!--begin::Card-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h2 > ইউজার ম্যানেজমেন্ট </h2>
      </div>
      <div class="card-toolbar">        
         <a href="{{ route('user-management.create') }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-plus"></i>নতুন ইউজার এন্ট্রি
         </a>                
      </div>
   </div>
   <div class="card-body">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         <p>{{ $message }}</p>
      </div>
      @endif
      <table class="table table-hover mb-6 font-size-h6">
         <thead class="thead-customStyle2 ">
            <tr>
               <th scope="col" width="30">#</th>
               <th scope="col">নাম</th>
               <th scope="col">ইউজারনেম</th>
               <th scope="col">ইউজার রোল</th>
               <th scope="col">অফিসের নাম</th>
               <th scope="col">ইমেইল এড্রেস</th>
              <!--  <th scope="col">স্ট্যাটাস</th> -->
               <th scope="col" width="150">পদক্ষেপ</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($users as $row)
            <tr>
               <th scope="row" class="tg-bn">{{ en2bn(++$i) }}</th>
               <td>{{ $row->name }}</td>
               <td>{{ $row->username }}</td>
               <td>{{ $row->role_name }}</td>
               <td>{{ $row->office_name_bn }}, {{ $row->upazila_name_bn }} {{ $row->district_name_bn }}</td>
               <td>{{ $row->email }}</td>
               <!-- <td>
                  <span class="label label-inline label-light-primary font-weight-bold">Pending</span>
               </td> -->
               <td>
                  <a href="{{ route('user-management.show', $row->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">বিস্তারিত</a>
                  <a href="{{ route('user-management.edit', $row->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">সংশোধন</a>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>      
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


