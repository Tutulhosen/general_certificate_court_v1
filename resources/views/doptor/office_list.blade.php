@extends('layouts.default')

@section('content')
    <!--begin::Card-->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    অফিস নির্বাচন করুন
                </h3>
            </div>
        </div>
        <div class="card-body">
            {{-- @php 
           dd($all_DC_UNO_office);
           
          @endphp --}}
            <table class="table table-striped table-hover">
                <thead>

                    <tr>
                        <td>ক্রম</td>
                        <td>অফিসের নাম</td>
                        <td>প্রবেশ করুন</td>
                    </tr>
                </thead>
                <tr>
                    @php $increment=1; @endphp
                    @foreach ($all_DC_UNO_office as $value)
                <tr>
                    <td>{{ $increment }}</td>
                    <td>{{ $value['office_name_bng'] }}</td>
                    <td><a class="btn btn-primary"
                            href="{{ route('doptor.user.management.user_list', ['office_id' => encrypt($value['id'])]) }}">প্রবেশ
                            করুন</a></td>

                </tr>
                @php $increment++; @endphp
                @endforeach
                </tr>
            </table>
            <div>
            </div>
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
