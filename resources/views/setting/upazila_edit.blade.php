@extends('layouts.default')

@section('content')

<!--begin::Card-->
<div class="card card-custom col-12">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-label"> উপজেলার বিস্তারিত </h3>
      </div>
      <!-- <div class="card-toolbar">        
         <a href="{{ url('upazila') }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-list"></i> ব্যবহারকারীর তালিকা
         </a>                
      </div> -->
   </div>

   <form action="{{ route('upazila.update', $upazila->id) }}" method="POST">
      @csrf
		@php
	  	if($upazila->status == 1){
	        $checkedEnable = 'checked';	      
	     }else{
	        $checkedEnable = '';	       
	     }
		@endphp

      <div class="card-body">
	      	@if ($message = Session::get('success'))
	      	<div class="alert alert-success">
	         <p>{{ $message }}</p>
	      	</div>
	      	@endif
         <div class="mb-12">
            <div class="form-group row">
               <div class="col-lg-4">
                  <label>নামঃ</label>
                  <input type="text" name="name_bn" class="form-control" placeholder="" value="{{ $upazila->upazila_name_bn}}" />
               </div>
               <div class="col-lg-4">
                  <label>বি.বি.এস কোডঃ</label>
                  <input type="text" name="bbs_code" class="form-control" placeholder="" value="{{ $upazila->upazila_bbs_code}}" />
               </div>
            </div>

               	<div class="col-lg-4">
                  <label>স্ট্যাটাস</label>
					<div class="radio-inline">
						<label class="radio">
						<input type="radio" name="status" value="1" <?=$upazila->status == 1?'checked':'';?> />
						<span></span>এনাবল</label>
						<label class="radio">
						<input type="radio" name="status" value="0" <?=$upazila->status == 0?'checked':'';?> />
						<span></span>ডিসএবল</label>
					</div>
                </div>
            </div>
         </div>
      </div>

      <div class="card-footer">
         <div class="row">
            <div class="col-lg-12">
               <button type="submit" class="btn btn-primary font-weight-bold mr-2">সংরক্ষণ</button>
            </div>
         </div>
      </div>

   </form>
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


