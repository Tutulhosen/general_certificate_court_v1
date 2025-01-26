@extends('layouts.default')
@yield('style')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

@section('content')


{{-- -------------calendar start---------- --}}
@include('dashboard.calendar.calender_need')

{{-- -------------calendar end---------- --}}


{{-- -------------callender end---------- --}}

@include('dashboard.calendar.calender_need_js')

 {{-- -------------callender end---------- --}}

@endsection


