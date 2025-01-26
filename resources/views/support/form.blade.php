@extends('layouts.default')




@section('content')
    <!--begin::Card-->
    <div class="card">
        <div class="p-5 m-5">
            <h1 class="text-center">সাপোর্ট</h1>
            <h3 class="text-center">আপনার সাপোর্ট ফর্মটি  osTicket | Support Ticketing System এ প্রদান করা হবে এবং পরবর্তী আপডেট <spna id="input_support_email">{{  isset(globalUserInfo()->email) ? globalUserInfo()->email : old('support_email') }}</spna> ইমেইল এ প্রদান করা হবে </h3>
            <form action="{{ route('support.form.post.officer') }}" method="post"  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="caseNo" class="form-label">নাম <span class="text-danger">*</span></label>
                            <input type="text" name="support_name" id="support_name"
                                class="form-control"value="{{ isset(globalUserInfo()->name) ? globalUserInfo()->name : old('support_name') }}">
                                @error('support_name')
                            <div class="alert alert-danger mt-4">{{ $message }}</div>
                        @enderror
                        </div>
                        
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">ইমেল <span class="text-danger">*</span></label>
                            <input type="email" name="support_email" id="support_email"
                                class="form-control"value="{{ isset(globalUserInfo()->email) ? globalUserInfo()->email : old('support_email') }}">
                                @error('support_email')
                                    <div class="alert alert-danger mt-4">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">মোবাইল <span class="text-danger">*</span></label>
                            <input type="text" name="support_mobail" id="support_mobail" class="form-control"
                                value="{{ isset(globalUserInfo()->mobile_no) ? globalUserInfo()->mobile_no : old('support_mobail') }}">
                                @error('support_mobail')
                                    <div class="alert alert-danger mt-4">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">বিষয় <span class="text-danger">*</span></label>
                            <input type="text" name="support_subject" id="support_subject" class="form-control"
                                placeholder="বিষয় প্রদান করুন" value="{{ old('support_subject') }}">
                                @error('support_subject')
                                    <div class="alert alert-danger mt-4">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3 form-group">
                            <label class="form-label">বিস্তারিত <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="support_details">{{ old('support_details') }}</textarea>
                            @error('support_details')
                                <div class="alert alert-danger mt-4">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="rounded d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
                            <input type="hidden" name="note" id="note" class="form-control " value="">
                            <div class="d-flex align-items-center mr-2 py-2">
                                <h3 class="mb-0 mr-8">সংযুক্তি (যদি থাকে)</h3>
                            </div>
                            <div class="symbol-group symbol-hover py-2">
                                <div class="symbol symbol-30 symbol-light-primary" data-toggle="tooltip"
                                    data-placement="top" title="" role="button"
                                    data-original-title="Add New File">
                                    <div id="addFileRow">
                                        <span class="symbol-label font-weight-bold bg-success">
                                            <i class="text-white fa flaticon2-plus font-size-sm"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mt-3 px-5">
                            <table width="100%" class="border-0 px-5" id="fileDiv"
                                style="border:1px solid #dcd8d8;">
                                <tr></tr>
                            </table>
                            <input type="hidden" id="other_attachment_count" value="1">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary p-5 me-5">প্রেরণ</button>
            </form>

        </div>
    </div>

    @include('support._support_create_Js')

    <!--end::Card-->
@endsection

