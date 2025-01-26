@extends('layouts.default')

@section('content')

<!--begin::Card-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-label"> কেস রেজিস্টার </h3>
      </div>
      <div class="card-toolbar">        
         <a href="#" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-plus"></i>New Record
         </a>                
      </div>
   </div>
   <div class="card-body">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         <p>{{ $message }}</p>
      </div>
      @endif
      <table class="table table-hover mb-6">
         <thead class="thead-light">
            <tr>
               <th scope="col" width="30">#</th>
               <th scope="col">নাম</th>
               <th scope="col">ইউজারনেম</th>
               <th scope="col">ইউজার রোল</th>
               <th scope="col">অফিসের নাম</th>
               <th scope="col">ইমেইল এড্রেস</th>
               <th scope="col">স্ট্যাটাস</th>
               <th scope="col">পদক্ষেপ</th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <th scope="row">1</th>
               <td>a</td>
               <td>s</td>
               <td>s</td>
               <td>s</td>
               <td>s</td>
               <td>
                  <span class="label label-inline label-light-primary font-weight-bold">Pending</span>
               </td>
               <td>
                  <a href="#" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">View</a>
                  <a href="#" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">Edit</a>
               </td>
            </tr>
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


