<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
    <!--begin::Logo-->
    <a href="{{ url('dashboard') }}">
        {{-- <img height="40" alt="Logo" src="{{ asset('media/logos/civil-suit-logo.png') }}" /> --}}
        <img height="40" alt="Logo" src="{{ asset(App\Models\SiteSetting::first()->site_logo) }}" />
        <!-- <span style="font-weight: bold;color: white;">Civil Suit</span> -->
    </a>
    <!--end::Logo-->
    <!--begin::Toolbar-->
    <div class="d-flex align-items-center">
        <!--begin::Aside Mobile Toggle-->

        <!--end::Aside Mobile Toggle-->

        <!--begin::Topbar Mobile Toggle-->
        <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
            <span class="svg-icon2 svg-icon-xl">
                <!--begin::Svg Icon | path:media/svg/icons/General/User.svg-->
                <i class="fas fa-user"></i>
                <!--end::Svg Icon-->
            </span>
        </button>
        <!--end::Topbar Mobile Toggle-->
    </div>
    <!--end::Toolbar-->
</div>
