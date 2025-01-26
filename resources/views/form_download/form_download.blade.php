

@extends('layouts.default')

@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @foreach ($downloadable_files as $key=>$item)
            {{-- @dd($item['file_location']) --}}
            <div class="form-group mb-2" >
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn bg-success-o-75"
                            type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                    </div>
                    {{-- <input readonly type="text" class="form-control" value="{{ asset($row->file_path . $row->file_name) }}" /> --}}
                    <input readonly type="text" class="form-control"
                        value="{{ $item['file_name'] ?? '' }}" />
                    <div class="input-group-append">
                        <a href="{{ $item['file_location']}}"
                            target="_blank"
                            class="btn btn-sm btn-success font-size-h5 float-left">
                            <i class="fa fas fa-file-pdf"></i>
                            <b>ডাউনলোড করুন</b>
                            {{-- <embed src="{{ asset('uploads/sf_report/'.$data[0]['case_register'][0]['sf_report']) }}" type="application/pdf" width="100%" height="600px" />  --}}
                        </a>
                        {{-- <a href="minarkhan.com" class="btn btn-success" type="button">দেখুন </a> --}}
                    </div>
              
                </div>
            </div>
            @endforeach

        </div>
        <!--end::Card-->
    @endsection

    