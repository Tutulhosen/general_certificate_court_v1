@extends('layouts.default')

@section('content')
    <!--begin::Card-->
    <div class="row">
        <div class="card card-custom col-12">
            <div class="card-header flex-wrap py-5">
                <div class="card-title">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                </div>

                <div class="card-toolbar">
                    <a href="{{ route('certificate.assistent.gco.list') }}" class="btn btn-sm btn-primary font-weight-bolder">
                        <i class="la la-list"></i> সার্টিফিকেট সহকারী ম্যানুয়াল
                    </a>
                </div>
            </div>

            @if (Session::has('username_found'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('username_found') }}
                </div>
            @endif

            @if (Session::has('email_found'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('email_found') }}
                </div>
            @endif

            <form action="{{ route('certificate.assistent.gco.list.create.form.manual.submit') }}" method="POST"
                enctype="multipart/form-data" id="peshkar_form_manaul">
                @php
                    
                    $designation = 'সার্টিফিকেট সহকারী';
                    
                @endphp

                @csrf
                <input type="hidden" name="role_id" value="28">
                <input type="hidden" name="court_id" value="{{ $available_court->id }}">
                <input type="hidden" name="office_id" id="office_id" value="{{ $office->id }}">


                <div class="card-body">
                    <fieldset>
                        <div class="pb-5 m-2 text-center">

                            <legend>ব্যবহারকারীর তথ্য</legend>
                        </div>



                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class=" form-control-label">পুরো নাম <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" placeholder="পুরো নাম লিখুন"
                                        class="form-control validation" value="" required>
                                    <div class="d-none required_message" id="name_alert_hide" role="alert">
                                        পুরো নাম দিতে হবে
                                    </div>
                                    @if ($errors->has('name'))
                                        <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="username" class=" form-control-label">ইউজারনেম <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="username" name="username"
                                        placeholder="ব্যবহারকারীর নাম লিখুন" class="form-control validation" value=""
                                        required>
                                    <div class="required_message d-none" id="username_alert_hide" role="alert">
                                        ইউজারনেম দিতে হবে
                                    </div>
                                    @if ($errors->has('username'))
                                        <div class="alert alert-danger">{{ $errors->first('username') }}</div>
                                    @endif
                                </div>
                            </div>



                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mobile_no" class=" form-control-label">মোবাইল নাম্বার <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="mobile_no" id="mobile_no" placeholder="মোবাইল নাম্বার লিখুন"
                                        class="form-control validation" value="" required>

                                    <div class="d-none required_message" id="username_alert_hide" role="alert">
                                        মোবাইল নাম্বার দিতে হবে
                                    </div>
                                    @if ($errors->has('mobile_no'))
                                        <div class="alert alert-danger">{{ $errors->first('mobile_no') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email" class=" form-control-label">ইমেইল এড্রেস </label>
                                    <input type="email" name="email" id="email" placeholder="ইমেইল এড্রেস লিখুন"
                                        class="form-control" value="" required>
                                    <div class="required_message d-none" id="email_alert_hide" role="alert"></div>
                                    @if ($errors->has('email'))
                                        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="role_id" class=" form-control-label">পদবি <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="designation" class="form-control" placeholder=""
                                        value="{{ $designation }}" readonly />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="office_id" class=" form-control-label">অফিস <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="office_name" id="office_name" class="form-control"
                                        value="{{ $office->office_name_bn }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="court_id" class=" form-control-label">আদালত <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="court_name" class="form-control"
                                        value="{{ $available_court->court_name }}" readonly>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group mt-2">
                                    <label>Password</label>
                                    <div class="input-group" id="show_hide_password">
                                        <input type="password" id="password" name="password"
                                            placeholder="ব্যবহারকারীর পাসওয়ার্ড লিখুন"
                                            class="form-control form-control-sm" value="" id="password"
                                            class="required" required>
                                        <span style="color: red">
                                            {{ $errors->first('password') }}
                                        </span>
                                        <div class="input-group-addon bg-secondary">
                                            <a href=""><i class="fa fa-eye-slash p-5 mt-1"
                                                    aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <div id="password-strength-status"></div>
                                    @if ($errors->has('password'))
                                        <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                                    @endif

                                </div>
                            </div>
                        </div>
                </div>


                </fieldset>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button type="button" class="btn btn-primary font-weight-bold mr-2"
                                id="peshkar_form_manaul_button">সংরক্ষণ করুন</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!--end::Card-->
    @include('certificate_assistent.inc._form_validation')
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
