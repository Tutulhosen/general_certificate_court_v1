@extends('layouts.default')

@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('settings.short-decision.create') }}" class="btn btn-sm btn-primary font-weight-bolder">
                    <i class="la la-plus"></i>নতুন জিসিও এর আদেশ এন্ট্রি
                </a>
            </div>
        </div>
        <div class="card-body">
            {{-- @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif --}}
            <form class="form-inline" method="GET">
                <div class="container">
                   <div class="row">
                      <div class="col-lg-3 mb-5">
                         <input type="text" name="search_short_order_name" class="w-100 form-control" placeholder="জিসিও এর আদেশ" autocomplete="off">
                      </div>
                      <div class="col-lg-3 col-lg-2 text-right">
                     </div>
                     <div class="col-lg-3 col-lg-2 text-right">
                    </div>
                      <div class="col-lg-3 col-lg-2 text-right">
                         <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান করুন</button>
                      </div>
                   </div>
                </div>
             
             </form>
            <table class="table table-hover mb-6 font-size-h6">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="30">#</th>
                        <th scope="col">জিসিও এর আদেশ</th>
                        <th scope="col">আদেশের বিস্তারিত</th>
                        <th scope="col" width="100">স্ট্যাটাস</th>
                        <th scope="col" width="150">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($shortDecision as $key => $row)
                        @php
                            if ($row->active_status == 1) {
                                $status = '<span class="label label-inline label-light-primary font-weight-bold">এনাবল</span>';
                            } else {
                                $status = '<span class="label label-inline label-light-primary font-weight-bold">ডিসএবল</span>';
                            }
                        @endphp
                        <tr>
                            <td scope="row" class="tg-bn">{{ en2bn($key + $shortDecision->firstItem()) }}.</td>
                            <td>{{ en2bn($row->case_short_decision) }}</td>
                            <td>{{ $row->delails }}</td>
                            <td><?= $status ?></td>
                            <td>
                                <a href="{{ route('settings.short-decision.edit', $row->id) }}"
                                    class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">সংশোধন</a>
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {!! $shortDecision->links() !!}
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
        <!--end::Page Scripts-->
    @endsection
