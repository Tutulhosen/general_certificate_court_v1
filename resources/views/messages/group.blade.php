@php
$roleID = Auth::user()->role_id;
$officeInfo = user_office_info();
@endphp

@extends('layouts.default')

@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }} </h3>
            </div>
            {{-- <div class="card-toolbar">
         <a href="{{ route('court.create') }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-plus"></i>নতুন আদালত এন্ট্রি
         </a>
      </div> --}}
        </div>
        <div class="card-body p-0">
            @if ($message = Session::get('success'))
                <div class="alert alert-success m-5">
                    <p class="m-0">{{ $message }}</p>
                </div>
            @endif
            {{-- @if ($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4)
         @include('court.search')
      @endif --}}
            <form action="{{ route('messages_send') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="case_id" value="{{ request()->c }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset>
                                {{-- <legend>বার্তা প্রেরণ</legend> --}}
                                <div class=" col-12 row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name" class=" form-control-label">বার্তা তৈরি করুন
                                                <span class="text-danger">*</span></label>
                                                @php
                                                    $case = App\Models\CaseRegister::findOrFail(request()->c, ['case_number']);
                                                @endphp
                                            <textarea name="messages" id="" class="form-control form-control-sm" rows="5">রেফারেন্স মামলা নং # {{ $case->case_number }}</textarea>
                                            <span style="color: red">
                                                {{ $errors->first('message') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary font-weight-bold mr-2">প্রেরণ করুন</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <div class="overflow-auto">
                            <table class="table table-hover mb-6 font-size-h6 ">
                                <thead class="thead-customStyle2">
                                   <tr>
                                      <th scope="col" width="30">
                                          <input type="checkbox" name="checkall" id="checkall" checked>
                                      </th>
                                      <th scope="col" width="30">ক্রমিক নং</th>
                                      <th scope="col">নাম</th>
                                      <th scope="col">ইউজার রোল</th>
                                      <th scope="col">অফিসের নাম</th>
                                      <th scope="col">ইমেইল এড্রেস</th>
                                      {{-- <th scope="col">পদক্ষেপ</th> --}}
                                   </tr>
                                </thead>
                                <tbody>
                                   @foreach ($users as $row)
                                       @if ($row->id != Auth::user()->id)
                                           <tr>
                                               <td>
                                                <input class="form-control single_check" type="checkbox" name="receiver[]" id="single_check" value="{{ $row->id }}" checked>
                                                </td>
                                               {{-- <th scope="row" class="tg-bn">{{ en2bn(++$i) }}</th> --}}
                                               <th scope="row" class="tg-bn">
                                                  @if ($row->profile_pic != null)
                                                  <img style="width: 40px; border-radius: 60%;"
                                                     src="{{ url('/') }}/uploads/profile/{{ $row->profile_pic }}" alt="">
                                                  @else
                                                  @php
                                                     $str = $row->username;
                                                  @endphp
                                                     <span class="badge badge-danger rounded-circle text-capitalize h3 mr-3">{{ substr($str, 0, 1) }}</span>
                                                  @endif
                                               </th>
                                               <td>{{ $row->name ?? '' }}</td>
                                               <td>{{ $row->role->role_name ?? '' }}</td>
                                               <td>{{ $row->office->office_name_bn ?? '' }}, {{ $row->office->upazila->upazila_name_bn ?? '' }}, {{ $row->office->district->district_name_bn ?? '' }}</td>
                                               <td>{{ $row->email ?? '' }}</td>
                                               {{-- <td>
                                                   <a href="{{ route('messages_single', $row->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">বার্তা পাঠান</a>
                                               </td> --}}
                                           </tr>
                                       @endif
                                   @endforeach
                                </tbody>
                             </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            {{-- <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8" style="max-height: 400px; overflow: scroll;">
                    <table class="table table-hover mb-6 font-size-h6">
                        <thead class="thead-light">
                            <tr>
                                <th>
                                    @if ($user->profile_pic != null)
                                        <img style="width: 40px; border-radius: 60%;"
                                            src="{{ url('/') }}/uploads/profile/{{ $user->profile_pic }}" alt="">
                                    @else
                                        <img style="width: 40px; border-radius: 60%;"
                                            src="{{ url('/') }}/uploads/profile/default.jpg" alt="">
                                    @endif
                                    {{ $user->name }},
                                    <span class="text-primary">{{ $user->role->role_name }}</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $key => $row)
                                @if ($row->user_sender == Auth::user()->id)
                                    <tr align="right">
                                        <td>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    {{ $row->messages }}
                                                    <p class="text-primary">
                                                        {{ $row->created_at }}
                                                    </p>

                                                </div>
                                                <div class="col-md-2">
                                                    @if (Auth::user()->profile_pic != null)
                                                        <img style="width: 50px; border-radius: 50%;"
                                                            src="{{ url('/') }}/uploads/profile/{{ Auth::user()->profile_pic }}"
                                                            alt="">
                                                    @else
                                                        <img style="width: 50px; border-radius: 50%;"
                                                            src="{{ url('/') }}/uploads/profile/default.jpg" alt="">
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    @if ($user->profile_pic != null)
                                                        <img style="width: 50px; border-radius: 50%;"
                                                            src="{{ url('/') }}/uploads/profile/{{ $user->profile_pic }}"
                                                            alt="">
                                                    @else
                                                        <img style="width: 50px; border-radius: 50%;"
                                                            src="{{ url('/') }}/uploads/profile/default.jpg" alt="">
                                                    @endif
                                                </div>
                                                <div class="col-md-10">
                                                    {{ $row->messages }}
                                                    <p class="text-primary">
                                                        {{ $row->created_at }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> --}}

            {{-- {!! $courts->links() !!} --}}
        </div>
    </div>
    <!--end::Card-->
@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#checkall").change(function() {
                if (this.checked) {
                    $(".single_check").each(function() {
                        this.checked=true;
                    });
                } else {
                    $(".single_check").each(function() {
                        this.checked=false;
                    });
                }
            });

            $(".single_check").click(function () {
                if ($(this).is(":checked")) {
                    var isAllChecked = 0;

                    $(".single_check").each(function() {
                        if (!this.checked)
                            isAllChecked = 1;
                    });

                    if (isAllChecked == 0) {
                        $("#checkall").prop("checked", true);
                    }
                }
                else {
                    $("#checkall").prop("checked", false);
                }
            });
        });

        // $('#checkall').change(function() {
        //     var checkboxes = $('.single_check');
        //     // var checkboxes = $(this).closest('form').find(':checkbox');
        //     checkboxes.prop('checked', $(this).is(':checked'));
        // });
        // $('.single_check').change(function() {
        //     var checkboxes = $('#checkall');
        //     // var checkboxes = $(this).closest('form').find(':checkbox');
        //     checkboxes.prop('checked', $(this).is(':checked'));
        // });
    </script>
@endsection
{{-- <!--end::Page Scripts--> --}}
