@extends('layouts.default')

@section('content')
    <!--begin::Row-->


    <div class="row">

        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>

                    <div class="card-toolbar"> <a href="{{ route('get.organization.add') }}"
                            class="btn btn-sm btn-primary font-weight-bolder"> <i class="la la-plus"></i>নতুন প্রতিষ্ঠান
                            এন্ট্রি </a> </div>

                </div>
                <div class="card-body">
                    <table class="table table-hover mb-6 font-size-h6">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" width="30">#</th>
                                <th scope="col">প্রতিষ্ঠানের নাম</th>
                                <th scope="col">প্রতিষ্ঠানের নাম ( ইংরেজি )</th>
                                <th scope="col">প্রতিষ্ঠানের ধরণ</th>
                                <th scope="col">প্রতিষ্ঠানের ঠিকানা</th>
                                <th scope="col">প্রাতিষ্ঠানের আইডি (রাউটিং নং )</th>
                                <th scope="col">স্ট্যাটাস</th>
                                <th scope="col">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($list_of_org as $key => $row)
                                @php
                                    if ($row->is_varified_org == 1) {
                                        $status =
                                            '<span class="label label-inline label-light-primary font-weight-bold">এনাবল</span>';
                                    } else {
                                        $status =
                                            '<span class="label label-inline label-light-primary font-weight-bold">ডিসএবল</span>';
                                    }
                                    switch ($row->organization_type) {
                                        case 'BANK':
                                            $org_type = 'ব্যাংক';
                                            break;
                                        case 'GOVERNMENT':
                                            $org_type = 'সরকারি প্রতিষ্ঠান';
                                            break;
                                        case 'OTHER_COMPANY':
                                            $org_type = 'স্বায়ত্তশাসিত প্রতিষ্ঠান';
                                            break;
                                    }
                                @endphp
                                <tr>
                                    <td scope="row" class="tg-bn">{{ en2bn($key + $list_of_org->firstItem()) }}.</td>
                                    <td>{{ en2bn($row->office_name_bn) }}</td>
                                    <td>{{ $row->office_name_en }}</td>
                                    <td>{{ $org_type }}</td>
                                    <td>{{ $row->organization_physical_address }}</td>
                                    <td>{{ $row->organization_routing_id }}</td>
                                    <td><?= $status ?></td>
                                    <td>
                                        <div class="btn-group float-right">
                                            <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle"
                                                type="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">পদক্ষেপ</button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"
                                                    href="{{ route('get.organization.details', encrypt($row->id)) }}">বিস্তারিত
                                                    তথ্য</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('get.organization.edit', encrypt($row->id)) }}">সংশোধন</a>
                                            </div>
                                            <div class="dropdown-menu dropdown-menu-right">
                                            </div>
                                            {{-- <a href=""
                                                class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">সংশোধন</a> --}}
                                        </div>
                                    </td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {!! $list_of_org->links() !!}
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection

@section('styles')
@endsection

@section('scripts')
@endsection
