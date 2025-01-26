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
   <div class="card-body overflow-auto">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         <p>{{ $message }}</p>
      </div>
      @endif
      @if($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4)
         {{-- @include('court.search') --}}
      @endif
      <table class="table table-hover mb-6 font-size-h6">
         <thead class="thead-customStyle2">
            <tr>
               <th scope="col">ক্রমিক নং</th>
               <th scope="col">নাম</th>
               <th scope="col">ইউজার</th>
               <th scope="col">ইউজার রোল</th>
               <th scope="col">অফিসের নাম</th>
               <th scope="col">ইমেইল এড্রেস</th>
               <th scope="col">পদক্ষেপ</th>
            </tr>
         </thead>
         <tbody>
            {{-- @foreach ($msg_request as $msg)
                <tr>
                    <th scope="row" class="tg-bn">
                        @if ($msg->sender->profile_pic != null)
                        <img style="width: 40px; border-radius: 60%;"
                           src="{{ url('/') }}/uploads/profile/{{ $msg->sender->profile_pic }}" alt="">
                        @else
                        @php
                           $str = $msg->sender->username;
                        @endphp
                           <span class="badge badge-danger rounded-circle text-capitalize h3 mr-3">{{ substr($str, 0, 1) }}</span>
                        @endif
                     </th>
                    <td>{{ $msg->sender->name ?? '' }} <span class="badge badge-danger">নতুন</span></td>
                    <td>{{ $msg->sender->username ?? '' }}</td>
                    <td>{{ $msg->sender->role->role_name ?? '' }}</td>
                    <td>{{ $msg->sender->office->office_name_bn ?? '' }}, {{ $msg->sender->office->upazila->upazila_name_bn ?? '' }} {{ $msg->sender->office->district->district_name_bn ?? '' }}</td>
                    <td>{{ $msg->sender->email ?? '' }}</td>
                    <td>
                    <a href="{{ route('messages_single', $msg->sender->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">বার্তা পাঠান</a>
                    </td>
                </tr>
            @endforeach --}}
            @forelse($users as $user)
                @php
                    $Ncount = App\Models\Message::select('id')
                    ->where('user_sender', $user->id)
                    ->where('user_receiver', Auth::user()->id)
                    ->where('receiver_seen', 0)
                    ->count();
                    // dd($Ncount);
                @endphp
                <tr>
                    {{-- <th scope="row" class="tg-bn">{{ en2bn(++$i) }}</th> --}}
                        <th scope="row" class="tg-bn">
                            @if ($user->profile_pic != null)
                            <div class="symbol symbol-circle symbol-40">
                                <img alt="Pic" src="{{ url('/') }}/uploads/profile/{{ $user->profile_pic }}"/>
                                {{-- <i class="symbol-badge bg-primary"></i> --}}
                            </div>
                           @else
                           @php
                              $str = $user->username;
                           @endphp
                            <div class="symbol symbol-circle symbol-40">
                                <span class="symbol-label bg-danger font-size-h4 text-capitalize text-light">{{ substr($str, 0, 1) }}</span>
                            </div>
                           @endif
                        </th>
                        {{-- @if ($user->profile_pic != null)
                        <img style="width: 40px; border-radius: 60%;"
                           src="{{ url('/') }}/uploads/profile/{{ $user->profile_pic }}" alt="">
                        @else
                        @php
                           $str = $user->username;
                        @endphp
                           <span class="badge badge-danger rounded-circle text-capitalize h3 mr-3">{{ substr($str, 0, 1) }}</span>
                        @endif --}}
                    <td>{{ $user->name ?? '' }} <span class="badge badge-danger">{{ $Ncount != 0 ? $Ncount : ''  }}</span></td>
                    <td>{{ $user->username ?? '' }}</td>
                    <td>{{ $user->role->role_name ?? '' }}</td>
                    <td>{{ $user->office->office_name_bn ?? '' }}, {{ $user->office->upazila->upazila_name_bn ?? '' }} {{ $user->office->district->district_name_bn ?? '' }}</td>
                    <td>{{ $user->email ?? '' }}</td>
                    <td>
                    <a href="{{ route('messages_single', $user->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">বার্তা পাঠান</a>
                    </td>
                </tr>
            @empty
            @endforelse
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


