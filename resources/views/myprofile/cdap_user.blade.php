
@extends('layouts.citizen.citizen')

@section('content')
    @php //echo $userManagement->name;
    //exit();
    if(globalUserInfo()->role_id == 35)
    {
        $role_name="প্রাতিষ্ঠানিক প্রতিনিধি";
    }else
    {
        $role_name="নাগরিক";
    }
    @endphp

    <!--begin::Card-->
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label"> ব্যবহারকারীর বিস্তারিত </h3>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @endif
                {{-- @foreach ($userManagement as $userManagement) --}}
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">নামঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">{{ $userManagement->name }}</span>
                    </div>
                    <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">ইউজার রোলঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">{{ $role_name }}</span>
                    </div>
                    <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">মোবাইল নাম্বারঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">{{ $userManagement->mobile }}</span>
                    </div>
                    <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">ইমেইল এড্রেসঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">{{ $userManagement->email }}</span>
                    </div>
                    <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">এন আই ডিঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">{{ $userManagement->nid }}</span>
                    </div>
                    <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">পিতার নামঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">{{ $userManagement->father_name  }}</span>
                    </div>
                    <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">মাতার নামঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">{{ $userManagement->mother_name }}</span>
                    </div>
                    
                    <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">লিঙ্গঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">{{ $userManagement->gender === "Male" ? "পুরুষ" : "মহিলা" }}</span>
                    </div>
                    <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">প্রোফাইল ইমেজঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">
                            @if ( $profile_pic != null)
                                <img class="img-fluid" src="{{ url('/') }}/uploads/profile/{{  $profile_pic  }}" width="200"
                                    height="200">
                            @else
                                <img src="{{ url('/') }}/uploads/profile/default.jpg" width="200" height="200">
                            @endif
    
                        </span>
                       
                    </div>
                    <!--  <div class="d-flex mb-3">
                     <span class="text-dark-100 flex-root font-weight-bold font-size-h6">স্ট্যাটাসঃ</span>
                     <span class="text-dark flex-root font-weight-bolder font-size-h6"></span>
                  </div> -->
                </div>
                {{-- @endforeach --}}
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
