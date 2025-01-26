@extends('layouts.default')

@section('content')
    <style type="text/css">
        .tg {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }

        .tg td {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            overflow: hidden;
            padding: 6px 5px;
            word-break: normal;
        }

        .tg th {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            font-weight: normal;
            overflow: hidden;
            padding: 6px 5px;
            word-break: normal;
        }

        .tg .tg-nluh {
            background-color: #dae8fc;
            border-color: #cbcefb;
            text-align: left;
            vertical-align: top
        }

        .tg .tg-19u4 {
            background-color: #ecf4ff;
            border-color: #cbcefb;
            font-weight: bold;
            text-align: right;
            vertical-align: top
        }
    </style>

    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            {{-- <div class="card-title"> --}}
            <div class="container">
                <div class="row">
                    <div class="col-10">
                        <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="2">প্রতিষ্ঠান এর তথ্য</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">প্রতিষ্ঠানের নাম</th>
                                {{-- @dd($organization) --}}
                                <td>{{ en2bn($organization->office_name_bn) ?? '-' }} </td>
                            </tr>
                            <tr>
                                <th scope="row">বিভাগ</th>
                                <td>{{ $division->division_name_bn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">জেলা</th>
                                <td>{{ $district->district_name_bn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">উপজেলা</th>
                                <td>{{ $upazila->upazila_name_bn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">প্রাতিষ্ঠানের ধরণ</th>
                                <td>{{ $organization->organization_type ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">প্রাতিষ্ঠানের ঠিকানা</th>
                                <td>{{ $organization->organization_physical_address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">প্রাতিষ্ঠানের আইডি (রাউটিং নং )</th>
                                <td>{{ $organization->organization_routing_id ?? '-' }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">

                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="7">প্রাতিষ্ঠানিক প্রতিনিধির তালিকা</th>
                        </thead>
                        <thead>
                            <tr style="text-align:center">
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="100">নাম</th>
                                <th scope="row" width="100">মোবাইল নম্বর</th>
                                <th scope="row" width="100">পদবী</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $k = 1; @endphp
                            @foreach ($users as $user)
                                <tr style="text-align:center">
                                    <td>{{ en2bn($k) }}.</td>
                                    <td>{{ $user->name ?? '-' }}</td>
                                    <td>{{ $user->mobile_no ?? '-' }}</td>
                                    <td>{{ $user->designation ?? '-' }}</td>
                                </tr>
                                @php $k++; @endphp
                            @endforeach
                        </tbody>
                    </table>

                    <br>

                </div>

            </div>
            <br>

            <br>




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
        <!--end::Page Scripts-->
    @endsection
