@extends('layouts.default')



@if (globalUserInfo()->doptor_user_flag == 1)

    @section('content')
        <!--begin::Card-->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

        <div class="card">


            <div class="card-header flex-wrap py-5">
                <div class="card-title">
                    <h2> {{ $page_title }} </h2>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('certificate.assistent.gco.list') }}"
                        class="btn btn-sm btn-primary font-weight-bolder">
                        <i class="la la-plus"></i> সার্টিফিকেট সহকারী ম্যানুয়াল
                    </a>
                </div>
            </div>

            <div class="card-body">
                @php
                    
                    if (isset($_GET['search_key'])) {
                        $case_no = $_GET['search_key'];
                    } else {
                        $case_no = null;
                    }
                @endphp

                <form class="form-inline" method="GET"
                    action="{{ route('certificate.assistent.gco.list.create.form.search') }}">
                    <div class="container mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control " name="search_key"
                                    placeholder="নাম, নথি আইডি, পদবী" value="{{ $case_no }}" required>
                            </div>
                            <div class="col-md-2 mt-1">
                                <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান
                                    করুন</button>
                            </div>
                        </div>
                    </div>
                </form>


                <table class="table table-striped table-hover" id="example" width="100%">
                    <thead>

                        <tr>
                            <td>ক্রম</td>
                            <td>নাম</td>
                            <td>পদবী</td>
                            <td>পদবী ইংরেজি</td>
                            <td>রোল</td>
                            <td>আদালত নির্বাচন</td>
                            <td>স্ট্যাটাস</td>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $increment = 1;
                            $list_of_others = array_reverse($list_of_others);
                           
                        @endphp
                        @foreach ($list_of_others as $value)
                            @php
                                $is_gco = false;
                                if (globalUserInfo()->role_id==6) {
                                    if ($value['role_id'] == 6) {
                                    $is_gco = true;
                                }
                                }elseif (globalUserInfo()->role_id==7) {
                                    if ($value['role_id'] == 6 || $value['role_id'] == 7) {
                                    $is_gco = true;
                                }
                                }elseif (globalUserInfo()->role_id==27) {
                                    if ($value['role_id'] == 6 || $value['role_id'] == 7 || $value['role_id'] == 27) {
                                    $is_gco = true;
                                }
                                }
                                
                            @endphp
                            <tr>
                                <input type="hidden" name="" id="office_name_bn_{{ $increment }}"
                                    value="{{ $value['office_name_bn'] }}">
                                <input type="hidden" name="" id="office_name_en_{{ $increment }}"
                                    value="{{ $value['office_name_en'] }}">
                                <input type="hidden" name="" id="unit_name_bn_{{ $increment }}"
                                    value="{{ $value['unit_name_bn'] }}">
                                <input type="hidden" name="" id="unit_name_en_{{ $increment }}"
                                    value="{{ $value['unit_name_en'] }}">
                                <input type="hidden" name="" id="designation_bng_{{ $increment }}"
                                    value="{{ $value['designation_bng'] }}">
                                <input type="hidden" name="" id="office_id_{{ $increment }}"
                                    value="{{ $value['office_id'] }}">
                                <input type="hidden" name="" id="username_{{ $increment }}"
                                    value="{{ $value['username'] }}">
                                <input type="hidden" name="" id="employee_name_bng_{{ $increment }}"
                                    value="{{ $value['employee_name_bng'] }}">

                                <td>{{ $increment }}</td>

                                <td><input type="text" class="form-control" value="{{ $value['employee_name_bng'] }}"
                                        readonly>
                                </td>
                                <td><input type="text" class="form-control" value="{{ $value['designation_bng'] }}"
                                        readonly>
                                </td>
                                <td><input type="text" class="form-control" value="{{ $value['designation_eng'] }}"
                                        readonly>
                                </td>
                                <td>


                                    @if ($is_gco)
                                        @if ($value['role_id'] == 6)
                                        <input type="text" class="form-control" value=" জেলা প্রশাসক" readonly>
                                        @endif
                                        @if ($value['role_id'] == 7) 
                                        <input type="text" class="form-control" value="অতিরিক্ত জেলা প্রশাসক (রাজস্ব)" readonly>
                                        @endif
                                        @if ($value['role_id'] == 27) 
                                        <input type="text" class="form-control" value="জিসিও" readonly>
                                        @endif
                                          
                                    @else
                                    <select name="role_select" class="court_selects form-control form-control-sm"
                                        class="form-control form-control-sm" id="role_id_{{ $increment }}">

                                        <option value="0">কোন রোল দেওয়া হয় নাই</option>

                                        @foreach ($available_role as $available_role_single)
                                            @php
                                                $selected=' ';
                                                if ($available_role_single->id == $value['role_id']) {
                                                    $selected='selected';
                                                }
                                            @endphp
                                            <option value="{{ $available_role_single->id }}" {{ $selected }}>
                                                {{ $available_role_single->role_name }}</option>
                                        @endforeach

                                    </select>
                                    @endif

                                </td>
                                <td>
                                    @php
                                        if ($is_gco) {
                                            $disabled='disabled';
                                        } else {
                                            $disabled=' ';
                                        }
                                    @endphp

                                    <select name="court_select" class="court_select form-control form-control-sm"
                                        class="form-control form-control-sm" id="{{ $increment }}">

                                        <option value="0" {{ $disabled }} selected>কোন আদালত দেওয়া হয় নাই</option>

                                        @foreach ($available_court_picker as $available_court_single)
                                            @php
                                                $selected=' ';
                                                if ($available_court_single->id == $value['court_id']) {
                                                    $selected='selected';
                                                }
                                            @endphp
                                            <option value="{{ $available_court_single->id }}" {{ $selected }}
                                                {{ $disabled }}>
                                                {{ $available_court_single->court_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    @foreach ($available_court_picker as $available_court_single)
                                        @if ($available_court_single->id == $value['court_id'])
                                            <button
                                                class="btn-sm btn btn-primary court_name_{{ $increment }}">{{ $available_court_single->court_name }}
                                                এনাবেল</button>
                                        @else
                                            <button class="btn-sm btn btn-danger court_name_{{ $increment }}">কোন আদালত
                                                দেয়া
                                                হয়
                                                নাই ডিজেবেল</button>
                                        @endif
                                    @endforeach

                                </td>
                            </tr>
                            @php $increment++; @endphp
                        @endforeach

                    </tbody>
                </table>

                <div>
                </div>
            </div>
        </div>
        <!--end::Card-->


        @if (globalUserInfo()->role_id == 27)
            @if ($level == 4)
                @include('certificate_assistent.inc._certificate_assistent_create_uno_js')
            @endif
            @if ($level == 3)
                @include('certificate_assistent.inc._certificate_assistent_create_js')
            @endif
        @endif
        @if (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 7)
            @include('certificate_assistent.inc._certificate_assistent_create_js')
        @endif
    @endsection


@endif
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
    <!--end::Page Scripts-->
    <script>
        $(document).ready(function() {



            var myTable = $('#example').DataTable({
                searching: false,
                ordering: false,
            });

        });
    </script>
@endsection
