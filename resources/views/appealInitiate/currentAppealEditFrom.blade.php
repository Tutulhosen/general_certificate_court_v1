@extends('layouts.default')

@section('content')
<div class="row">
    @if (Session::has('Errormassage'))
        <div class="alert alert-danger text-center">
            {{ Session::get('Errormassage') }}
        </div>
    @endif
    <div class="col-md-12">
       <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title h2 font-weight-bolder" style="padding-top: 30px;">{{ $page_title }}</h3>
                
            </div>
      
            <div class="row justify-content-center mt-5 mb-10 px-8 mb-lg-15 px-lg-10">
                <div class="col-xl-12 col-xxl-7">
                    <!--begin::Form Wizard-->
                    <form id="appealCase" action="{{route('appeal.currentAppealEdit')}}" class="form" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="appeal_id" id="appeal_id" value="{{$appeal_id}}">
                        {{-- <div ></div> --}}

                        <div class="pb-5" >
                            
                            <legend class="font-weight-bold text-dark"><strong
                                style="font-size: 20px !important">আবেদনকারীর তথ্য (1)</strong></legend>
                        
                        
                         

                            <div class="row">
                                <div class="col-lg-4 mb-5">
                                <div class="form-group">
                                        <label class="control-label"><span style="color:#FF0000">* </span>উপজেলা নির্বাচন করুন </label>
                                        <select class="form-control" name="upazila_id" aria-label=".form-select-lg example" id="upazila_id">
                                            <option value="{{$upazila->id}}">{{$upazila->upazila_name_bn}}</option>
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-5">
                                    <div class="form-group">

                                        <label><span style="color:#FF0000">* </span> প্রতিষ্ঠানের ধরন নির্বাচন করুন </label>
                                        <select class="form-control" aria-label=".form-select-lg example" id="applicant_organization" name="applicant_organization"  >
                                            <option value="{{$org_type}}">{{org_type($org_type)}} </option>
                                            
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="applicantOrganization_1" class="control-label">
                                            <span style="color:#FF0000">* </span> প্রতিষ্ঠানের নাম</label>
                                            

                                            <select class="form-control" aria-label=".form-select-lg example" name="office" id="applicantOrganization_1">
                                                <option value="">প্রতিষ্ঠান নির্বাচন করুন </option>
                                                @foreach ($office as $item)
                                                <option value="{{$item->id}}">{{$item->office_name_bn}}</option>
                                                @endforeach
                                            </select>
                                            
                                    </div>

                                </div>
                                
                            </div>

                        </div>
                        
                        <button class="btn btn-lg btn-success">সংরক্ষণ</button>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form Wizard-->
                </div>
            </div>
       </div>
    </div>
</div>
@endsection