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
        
      <a href=""></a>
      @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
     @endif

        <form action="{{ route('post.organization.update') }}" method="POST">
            @csrf
                <input type="hidden" value="{{ $organization->id }}" name="office_id">

            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="mb-12">
                    <div class="form-group row">
            
                        <div class="col-lg-12" style="margin-top:20px;">
                            <label>প্রতিষ্ঠানের নাম</label>
                            <input type="text" class="form-control" name="office_name_bn" value="{{ $organization->office_name_bn }}" required>
                            @error('office_name_bn')
                            <div class="alert alert-danger"> প্রতিষ্ঠানের নাম বাংলাতে দিন</div>
                        @enderror
                        </div>
                        <div class="col-lg-12" style="margin-top:20px;">
                            <label> প্রতিষ্ঠানের নাম ( ইংরেজি )</label>
                            <input type="text" class="form-control" name="office_name_en" value="{{ $organization->office_name_en }}" required>
                            @error('office_name_en')
                            <div class="alert alert-danger"> প্রতিষ্ঠানের নাম ইংরেজিতে দিন</div>
                        @enderror
                        </div>
                        <div class="col-lg-12" style="margin-top:20px;">
                            <label>প্রতিষ্ঠানের ধরণ</label>
                            <select class="form-control" aria-label=".form-select-lg example" name="organization_type"
                                    id="organization_type" required>
                            
                                    <option value=" ">প্রতিষ্ঠানের ধরন নির্বাচন করুন </option>
                                    <option value="BANK" <?= $organization->organization_type  == "BANK" ? 'selected' : '' ?>>ব্যাংক</option>
                                    <option value="GOVERNMENT" <?= $organization->organization_type  == "GOVERNMENT" ? 'selected' : '' ?>>সরকারি প্রতিষ্ঠান</option>
                                    <option value="OTHER_COMPANY" <?= $organization->organization_type  == "OTHER_COMPANY" ? 'selected' : '' ?>>স্বায়ত্তশাসিত প্রতিষ্ঠান</option>
                                </select>
                        </div>
                        <div class="col-lg-12" style="margin-top:20px;">
                            <label>প্রতিষ্ঠানের ঠিকানা</label>
                            <textarea name="organization_physical_address" class="form-control" id="" cols="30" rows="10" required>{{ $organization->organization_physical_address }}</textarea>
                            @error('organization_physical_address')
                            <div class="alert alert-danger">প্রতিষ্ঠানের ঠিকানা দিন</div>
                        @enderror
                            
                        </div>
                        <div class="col-lg-12" style="margin-top:20px;">
                            <label>প্রাতিষ্ঠানের আইডি (রাউটিং নং ) ( ইংরেজি )</label>
                            <input type="text" class="form-control only_english" name="organization_routing_id" value="{{ $organization->organization_routing_id }}" required>
                            @error('organization_routing_id')
                            <div class="alert alert-danger"> রাউটিং নং ইংরেজিতে দিন</div>
                         @enderror
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <label>স্ট্যাটাস</label>
                    <div class="radio-inline">
                        <label class="radio">
                            <input type="radio" name="active_status" value="1"
                                <?= $organization->is_varified_org  == 1 ? 'checked' : '' ?> />
                            <span></span>এনাবল</label>
                        <label class="radio">
                            <input type="radio" name="active_status" value="0"
                                <?= $organization->is_varified_org  == 0 ? 'checked' : '' ?> />
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
    <script src="assets/js/pages/custom/login/login-3.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            
            $(".only_english").keypress(function(event){
                    var ew = event.which;
                    if(ew == 32)
                        return true;
                    if(48 <= ew && ew <= 57)
                        return true;
                    if(65 <= ew && ew <= 90)
                        return true;
                    if(97 <= ew && ew <= 122)
                        return true;
                    return false;
            });

        });
    </script>
@endsection
