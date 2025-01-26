@extends('layouts.default')

@section('content')

<!--begin::Card-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
      </div>
      <div class="card-toolbar">        
         <a href="{{ route('mouja-add') }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-plus"></i>নতুন মৌজা এন্ট্রি
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
               <th scope="col" width="30">#</th>
               <th scope="col">মৌজার নাম</th>
               <th scope="col">বিভাগের নাম</th>
               <th scope="col">জেলার নাম</th>
               <th scope="col">উপজেলার নাম</th>
               <th scope="col" width="100">স্ট্যাটাস</th>
               <th scope="col" width="150">পদক্ষেপ</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($mouja as $row)
            <?php
               if($row->status == 1){
                  $moujaStatus = '<span class="label label-inline label-light-primary font-weight-bold">এনাবল</span>';
               }else{
               	$moujaStatus = '<span class="label label-inline label-light-primary font-weight-bold">ডিসএবল</span>';
               }
            ?>
            <tr>
               <td scope="row" class="tg-bn">{{ en2bn(++$i) }}.</td>
               <td>{{ $row->mouja_name_bn }}</td>
               <td>{{ $row->division_name_bn }}</td>             
               <td>{{ $row->district_name_bn }}</td>
               <td>{{ $row->upazila_name_bn }}</td>
               <td><?=$moujaStatus?></td>
               <td>
                  <a href="{{ route('mouja.edit', $row->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">সংশোধন</a>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
    <div class="d-flex justify-content-center">
         {!! $mouja->links() !!}
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


