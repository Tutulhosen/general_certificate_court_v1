@extends('layouts.default')
@yield('style')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
@section('content')
    @include('dashboard.inc.icon_card')
    @include('dashboard.citizen.cause_list_gco_and_asc')
    {{-- @dd(session()->all()) --}}

@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}

