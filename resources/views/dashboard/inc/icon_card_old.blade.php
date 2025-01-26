
@if ( globalUserInfo()->role_id != 32 &&  globalUserInfo()->role_id != 33 ) 

<div class="row">
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ route('appeal.all_case') }}">
            <div class="card card-custom bg-danger cardCustomBG bg-hover-state-danger card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-danger  mr-2">
                            <span>
                                <i class="fas fa-border-all"></i>
                            </span>
                            <span class="text-light Count">{{ en2bn($total_case) }}</span>
                        </span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3">মোট মামলা</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>


    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ route('appeal.index') }}">
            <div class="card card-custom bg-success cardCustomBG bg-hover-state-success card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-success  mr-2">
                            <span>
                                <i class="fas fa-walking"></i>
                            </span>
                        </span>
                            <span class="text-light  Count">{{ en2bn($running_case) }}</span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3">চলমান মামলা</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ route('appeal.pending_list') }}">
            <div class="card card-custom bg-primary cardCustomBG bg-hover-state-primary card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-primary  mr-2">
                            <span>
                               <i class="fas fa-hands"></i>
                            </span>
                        </span>
                            <span class="text-light  Count">{{ en2bn($pending_case) }}</span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3">গ্রহণের জন্য আবেদন</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    @if(globalUserInfo()->role_id !=27 && globalUserInfo()->role_id !=28)
    
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">

        <a href="{{ route('appeal.rejected_list') }}">
            <div class="card card-custom bg-success cardCustomBG bg-hover-state-success card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-success  mr-2">
                            <span>
                                <i class="fas fa-hourglass-end"></i>
                            </span>
                        </span>
                        <span class="text-light Count">{{ en2bn($rejected_case) }}</span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3">খারিজকৃত মামলা</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endif


    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ route('appeal.closed_list') }}">
            <div class="card card-custom bg-primary cardCustomBG bg-hover-state-primary card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-primary  mr-2">
                            <span>
                                <i class="fas fa-calendar-times"></i>
                            </span>
                        </span>
                            <span class="text-light  Count">{{ en2bn($completed_case) }}</span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3">নিষ্পত্তিকৃত মামলা</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ route('office') }}">
            <div class="card card-custom bg-primary cardCustomBG bg-hover-state-primary card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-primary  mr-2">
                            <span>
                                <i class="fas fa-globe"></i>
                            </span>
                        </span>
                            <span class="text-light  Count">{{ en2bn($total_office) }}</span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3">মোট অফিস</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->


        @if(globalUserInfo()->role_id == 1 || globalUserInfo()->role_id == 2 )
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ route('user-management.index') }}">
            <div class="card card-custom bg-primary cardCustomBG bg-hover-state-primary card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-primary  mr-2">
                            <span>
                                <i class="fas fa-user-friends"></i>
                            </span>
                        </span>
                            <span class="text-light  Count">{{ en2bn($total_user) }}</span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3">মোট ইউজার</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
        @endif
    </div>
@endif
@if( globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28 || globalUserInfo()->role_id == 34)
    
        <div class="row mb-5">
            <div class="col-xl-8">
                @if($notifications > 0)
                    <div class="">
                        <div class="toast-header py-3">
                            <i class="text-primary icon fas fas fa-bell m"></i>
                          <strong class="ml-2 mr-auto">পদক্ষেপ নিতে হবে এমন মামলাসমূহ</strong>
                          <span class="badge badge-danger">{{en2bn($notifications) ?? ''}}</span>
                        </div>
                        @if($pending_case_list > 0)
                        <a href="{{ route('appeal.pending_list') }}">
                            <div class="toast-body bg-light">
                                গ্রহণের জন্য অপেক্ষমান নতুন আবেদন <span class="badge badge-danger ml-5">{{en2bn($pending_case_list) ?? ''}}</span>
                            </div>
                        </a>
                        @endif
                        @if($trial_date_list > 0)
                        <a href="{{ route('appeal.trial_date_list') }}">
                            <div class="toast-body bg-light">
                                শুনানির তারিখ হয়েছে এমন মামলার <span class="badge badge-danger ml-5">{{en2bn($trial_date_list) ?? ''}}</span>
                            </div>
                        </a>
                        @endif
                    </div>
                @else
                    <div class="toast-body bg-light">পদক্ষেপ নিতে হবে এমন কোন মামলা পাওয়া যায়নি</div>
                @endif
            </div>
        </div>
@elseif(globalUserInfo()->role_id == 32)
        <div class="row mb-5">
            <div class="col-xl-8">
                @if($notifications > 0)
                    <div class="">
                        <div class="toast-header py-3">
                            <i class="text-primary icon fas fas fa-bell m"></i>
                          <strong class="ml-2 mr-auto">পদক্ষেপ নিতে হবে এমন মামলাসমূহ</strong>
                          <span class="badge badge-danger">{{en2bn($notifications) ?? ''}}</span>
                        </div>
                        @if($CaseCrockCount > 0)
                        <a href="{{ route('appeal.crock_order_list') }}">
                            <div class="toast-body bg-light">
                                ক্রোকের আদেশ <span class="badge badge-danger ml-5">{{en2bn($CaseCrockCount) ?? ''}}</span>
                            </div>
                        </a>
                        @endif
                        
                    </div>
                @else
                    <div class="toast-body bg-light">পদক্ষেপ নিতে হবে এমন কোন মামলা পাওয়া যায়নি</div>
                @endif
            </div>
        </div>
@elseif(globalUserInfo()->role_id == 33)
        <div class="row mb-5">
            <div class="col-xl-8">
                @if($notifications > 0)
                    <div class="">
                        <div class="toast-header py-3">
                            <i class="text-primary icon fas fas fa-bell m"></i>
                          <strong class="ml-2 mr-auto">পদক্ষেপ নিতে হবে এমন মামলাসমূহ</strong>
                          <span class="badge badge-danger">{{en2bn($notifications) ?? ''}}</span>
                        </div>
                        @if($CaseWarrentCount > 0)
                        <a href="{{ route('appeal.arrest_warrent_list') }}">
                            <div class="toast-body bg-light">
                                গ্রেপ্তারি পরোয়ানা জারি <span class="badge badge-danger ml-5">{{en2bn($CaseWarrentCount) ?? ''}}</span>
                            </div>
                        </a>
                        @endif
                        
                    </div>
                @else
                    <div class="toast-body bg-light">পদক্ষেপ নিতে হবে এমন কোন মামলা পাওয়া যায়নি</div>
                @endif
            </div>
        </div>
@endif








