@extends('layouts.default')

@section('content')
    <!--begin::Card-->
    <div class="card card-custom col-12">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label"> {{ $page_title }} </h3>
            </div>
            <!-- <div class="card-toolbar">
             <a href="{{ url('division') }}" class="btn btn-sm btn-primary font-weight-bolder">
                <i class="la la-list"></i> ব্যবহারকারীর তালিকা
             </a>
          </div> -->
        </div>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
     @endif

        <form action="{{ route('settings.short-decision.update', $shortDecision->id) }}" method="POST">
            @csrf
                

            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="mb-12">
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>সংক্ষিপ্ত আদেশ</label>
                            <input type="text" name="case_short_decision" class="form-control" placeholder=""
                                value="{{ $shortDecision->case_short_decision }}" />
                        </div>

                        <div class="col-lg-12" style="margin-top:20px;">
                            <label>আদেশের বিস্তারিত</label>
                            <textarea name="delails" rows="5" class="form-control">{{ $shortDecision->delails }}</textarea>
                        </div>
                        <div class="col-lg-12" style="margin-top:20px;">
                            <label>SMS Template</label>
                            <textarea name="template_code" rows="5" class="form-control">{{ $shortDecision->template_code }}</textarea>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <label>স্ট্যাটাস</label>
                    <div class="radio-inline">
                        <label class="radio">
                            <input type="radio" name="active_status" value="1"
                                <?= $shortDecision->active_status  == 1 ? 'checked' : '' ?> />
                            <span></span>এনাবল</label>
                        <label class="radio">
                            <input type="radio" name="active_status" value="0"
                                <?= $shortDecision->active_status  == 0 ? 'checked' : '' ?> />
                            <span></span>ডিসএবল</label>
                    </div>
                </div>
            </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-primary font-weight-bold mr-2">সংরক্ষণ</button>
            </div>
        </div>
    </div>

    </form>
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
