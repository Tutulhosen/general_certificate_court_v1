
@extends('layouts.default')
@section('content')
    <!--begin::Card-->
    <div class="row">
        <div class="card card-custom col-12">
            <div class="card-header flex-wrap py-5">
                <div class="card-title">
                   <h2 > {{ $page_title }} </h2>
                </div>
                <div class="card-toolbar">
                   <a href="{{ route('certificate.assistent.gco.list.create.form.manual') }}" class="btn btn-sm btn-primary font-weight-bolder">
                      <i class="la la-plus"></i>সার্টিফিকেট সহকারী এন্ট্রি ম্যানুয়াল
                   </a> 
                </div>
             </div>
            {{-- @php 
             dd($peshkar_users)
             
            @endphp --}}

            @if(Session::has('message'))
            <div class="alert-success p-5">
                {{ Session::get('message') }}
            </div>
            @endif
      <table class="table table-striped border">
        <thead>
            <tr>
                <th class="font-weight-bolder text-center">নাম</th>
                <th class="font-weight-bolder text-center">ইউজারনেম</th>
                <th class="font-weight-bolder text-center">মোবাইল</th>
                <th class="font-weight-bolder text-center">ইমেইল এড্রেস</th>
                <th class="font-weight-bolder text-center">নথি/সাধারণ</th>
                <th class="font-weight-bolder text-center">পদক্ষেপ</th>
                <th class="font-weight-bolder text-center">অ্যাক্টিভ</th>
            </tr>
        </thead>
        @foreach($peshkar_users as $value)
        <tr>
           <td class="text-center">{{ $value->name }}</td>
           <td class="text-center">{{ $value->username }}</td>
           <td class="text-center">{{ $value->mobile_no }}</td>
           <td class="text-center">{{ isset($value->email) ? $value->email : '--' }}</td>
           <td class="text-center">
            @php 
            if($value->doptor_user_flag==1)
            {

                echo 'নথি ইউজার';
            }
            else {
                echo 'সাধারণ ইউজার';
            }
            @endphp
           </td>
           <td class="text-center">
            @php 
            if($value->doptor_user_flag==1)
            {

                echo '---';
            }
            else {
                echo '<a href="'.route('certificate.assistent.gco.list.create.form.manual.update',['id'=>$value->id]).'" class="btn btn-primary">সংশোধন</a>';
            }
            @endphp

            
          
          </td>
           <td>
            @php 
             if($value->peshkar_active==1)
             {
                echo '<button class="btn btn-primary active" data-user='.$value->id.'>অ্যাক্টিভ</button>';
             }
             else 
             {
               echo '<button class="btn btn-danger active" data-user='.$value->id.'>ইন অ্যাক্টিভ</button>';
             }
            @endphp
            
        
           </td>
        </tr>

        @endforeach
      </table>     
        </div>
    </div>

    <!--end::Card-->
   @include('certificate_assistent.inc._certificate_assistent_create_js')

@endsection

@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
@endsection