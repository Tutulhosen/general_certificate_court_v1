@include('layouts.base.inc._permission')
@php
    global $menu;
@endphp


<div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    <div class="container align-items-stretch justify-content-between">
        <!--begin::Topbar-->
        <div class="topbar_wrapper">
            <div class="topbar">
                @auth
                    @if (in_array(1, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click" data-toggle="tooltip"
                                data-placement="right" title data-original-title="" aria-haspopup="true">
                                <a href="{{ url('dashboard') }}"
                                    class="navi-link {{ request()->is('dashboard') ? 'menu-item-active' : '' }}">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary" style="padding-left: 0 !important;">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-xl svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                                            <i class="fa fa-home"></i>
                                            <p class="navi-text">ড্যাশবোর্ড</p>
                                        </span>
                                        <span class="pulse-ring"></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if (in_array(99, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click" data-toggle="tooltip"
                                data-placement="right" title data-original-title="" aria-haspopup="true">
                                <a href="{{ url('role-permission/index') }}"
                                    class="navi-link {{ request()->is('role-permission/index') ? 'menu-item-active' : '' }}">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                            <i class="fas fa-pencil-ruler"></i>
                                            <!--end::Svg Icon-->
                                            <p class="navi-text">রোল পারমিশন</p>
                                        </span>


                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                    @if (in_array(2, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click" data-toggle="tooltip"
                                data-placement="right" title data-original-title="" aria-haspopup="true">
                                <a href="{{ route('calendar') }}"
                                    class="navi-link {{ request()->is('calendar') ? 'menu-item-active' : '' }}">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                            <i class="fas fa-calendar"></i>
                                            <!--end::Svg Icon-->
                                            <p class="navi-text">ক্যালেন্ডার</p>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif




                    @if (in_array(3, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class="btn-clean btn-dropdown mr-2 {{ Str::contains(request()->path(), 'appeal') &&
                                    !Str::contains(request()->path(), 'appeal/with/action/required') &&
                                    !Str::contains(request()->path(), 'appeal/causelist/case/list')
                                        ? 'menu-item-active'
                                        : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <i class="fas fa-gavel"></i>
                                        <p class="navi-text">কোর্ট পরিচালনা</p>
                                    </span>
                                </div>
                            </div>

                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->
                                    @if (in_array(4, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.create') }}"
                                                class="navi-link {{ request()->is('appeal/create') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <i class="fas fa-chalkboard-teacher"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">সার্টিফিকেট রিকুইজিশন
                                                    প্রক্রিয়াকরন</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(5, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.draft_list') }}"
                                                class="navi-link {{ request()->is('appeal/draft_list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <i class="fas fa-book-open"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">খসড়া মামলা</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(7, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.pending_list') }}"
                                                class="navi-link {{ request()->is('appeal/pending_list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <i class="fas fa-book-open"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">গ্রহণের জন্য অপেক্ষমান</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(6, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.index') }}"
                                                class="navi-link {{ request()->is('appeal/list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <i class="fas fa-book-open"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                {{-- @if (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28)
                                                    <span class="navi-text">চলমান মামলা</span>
                                                @else
                                                    <span class="navi-text">চলমান আপিল মামলা</span>
                                                @endif --}}

                                                <span class="navi-text">
                                                    {{ globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28 ? 'চলমান মামলা' : 'চলমান আপিল মামলা' }}</span>

                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(10, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.rejected_list') }}"
                                                class="navi-link {{ request()->is('appeal/rejected_list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <i class="fas fa-book-open"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text"> বাতিলকৃত মামলা</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(11, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.collectPaymentList') }}"
                                                class="navi-link {{ request()->is('appeal/collectPaymentList') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M12,16 C14.209139,16 16,14.209139 16,12 C16,9.790861 14.209139,8 12,8 C9.790861,8 8,9.790861 8,12 C8,14.209139 9.790861,16 12,16 Z M12,20 C7.581722,20 4,16.418278 4,12 C4,7.581722 7.581722,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 Z"
                                                                    fill="#000000" fill-rule="nonzero" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">অর্থ আদায়</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(8, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.closed_list') }}"
                                                class="navi-link {{ request()->is('appeal/closed_list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <i class="fas fa-book"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text"> নিষ্পত্তিকৃত মামলা</span>
                                            </a>
                                        </li>
                                    @endif


                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->


                        </div>
                    @endif




                    @if (in_array(34, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title data-original-title=""
                                aria-haspopup="true">
                                <a href="{{ route('citizen.appeal.cause_list') }}" class="navi-link">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Text\Filter.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path
                                                        d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z"
                                                        fill="#000000" opacity="0.3" />
                                                    <path
                                                        d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z"
                                                        fill="#000000" />
                                                    <rect fill="#000000" opacity="0.3" x="10" y="9" width="7"
                                                        height="2" rx="1" />
                                                    <rect fill="#000000" opacity="0.3" x="7" y="9" width="2"
                                                        height="2" rx="1" />
                                                    <rect fill="#000000" opacity="0.3" x="7" y="13" width="2"
                                                        height="2" rx="1" />
                                                    <rect fill="#000000" opacity="0.3" x="10" y="13" width="7"
                                                        height="2" rx="1" />
                                                    <rect fill="#000000" opacity="0.3" x="7" y="17" width="2"
                                                        height="2" rx="1" />
                                                    <rect fill="#000000" opacity="0.3" x="10" y="17" width="7"
                                                        height="2" rx="1" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                            <p class="navi-text">কার্যতালিকা</p>
                                        </span>


                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif



                    @if (in_array(14, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->

                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is(['hearing_date', 'results_completed', 'new_sf_list', 'appeal/with/action/required']) ? 'menu-item-active' : '' }} cs_notification">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <i class="fas fa-bell"></i></i>
                                        <p class="navi-text">নোটিফিকেশন</p>
                                    </span>

                                    @if (isset($notification_count) && $notification_count != 0)
                                        <span class="menu-label">
                                            <span class="label label-rounded label-danger cs_notification_count"
                                                data-notification={{ $notification_count }}></span>
                                        </span>
                                    @endif
                                </div>
                            </div>



                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->
                                    @if ($notification_count > 0)
                                        @if (in_array(22, $menu))
                                            @if ($total_pending_case > 0)
                                                <li class="navi-item">
                                                    <a href="{{ route('appeal.pending_list') }}" class="navi-link">
                                                        <span class="symbol-20 mr-3">
                                                            <span
                                                                class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </span>
                                                        <span class="navi-text">গ্রহণের জন্য অপেক্ষমান</span>
                                                        <span class="menu-label">
                                                            <span
                                                                class="label label-rounded label-danger">{{ en2bn($total_pending_case) }}
                                                            </span>
                                                        </span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                        @if (in_array(23, $menu))
                                            @if ($CaseTrialCount > 0)
                                                <li class="navi-item">
                                                    <a href="{{ route('appeal.trial_date_list') }}" class="navi-link">
                                                        <span class="symbol-20 mr-3">
                                                            <span
                                                                class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </span>
                                                        <span class="navi-text">শুনানির তারিখ </span>
                                                        <span class="menu-label">
                                                            <span
                                                                class="label label-rounded label-danger">{{ en2bn($CaseTrialCount) }}
                                                            </span>
                                                        </span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                        @if (in_array(44, $menu))
                                            @if ($CaseRunningCountActionRequired > 0)
                                                <li class="navi-item">
                                                    <a href="{{ route('appeal.appeal_with_action_required') }}"
                                                        class="navi-link {{ request()->is('appeal/with/action/required') ? 'menu-item-active' : '' }}">
                                                        <span class="symbol-20 mr-3">
                                                            <span
                                                                class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </span>
                                                        <span class="navi-text">চলমান মামলাতে পদক্ষেপ নিতে হবে</span>
                                                        <span class="menu-label">
                                                            <span
                                                                class="label label-rounded label-danger">{{ en2bn($CaseRunningCountActionRequired) }}
                                                            </span>
                                                        </span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                        @if (in_array(24, $menu))
                                            @if ($CaseWarrentCount > 0)
                                                <li class="navi-item">
                                                    <a href="{{ route('appeal.arrest_warrent_list') }}"
                                                        class="navi-link">
                                                        <span class="symbol-20 mr-3">
                                                            <span
                                                                class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </span>
                                                        <span class="navi-text">গ্রেপ্তারি পরোয়ানা জারি</span>
                                                        <span class="menu-label">
                                                            <span
                                                                class="label label-rounded label-danger">{{ en2bn($CaseWarrentCount) }}
                                                            </span>
                                                        </span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                        @if (in_array(25, $menu))
                                            @if ($CaseCrockCount > 0)
                                                <li class="navi-item">
                                                    <a href="{{ route('appeal.crock_order_list') }}" class="navi-link">
                                                        <span class="symbol-20 mr-3">
                                                            <span
                                                                class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </span>
                                                        <span class="navi-text">ক্রোকের আদেশ</span>
                                                        <span class="menu-label">
                                                            <span
                                                                class="label label-rounded label-danger">{{ en2bn($CaseCrockCount) }}
                                                            </span>
                                                        </span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                        @if (in_array(29, $menu))
                                            @if (isset($reviewedCaseCount) && $reviewedCaseCount > 0)
                                                <li class="navi-item">
                                                    <a href="{{ route('appeal.review_appeal_list') }}" class="navi-link">
                                                        <span class="symbol-20 mr-3">
                                                            <span
                                                                class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </span>
                                                        <span class="navi-text">রিভিউয়ের জন্য আবেদন </span>
                                                        <span class="menu-label">
                                                            <span
                                                                class="label label-rounded label-danger">{{ en2bn($reviewedCaseCount) }}
                                                            </span>
                                                        </span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                    @else
                                        <li class="menu-item" aria-haspopup="true">
                                            <a href="#" class="menu-link ml-2">
                                                <span class=" text-danger"> কোনো নোটিফিকেশন পাওয়া যায়নি </span>
                                            </a>
                                        </li>
                                    @endif
                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>
                    @endif

                    @if (in_array(40, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('case-mapping/*', 'user-management', 'user-management/index', 'app', 'app/setting/index', 'court', 'settings/short-decision', 'case-mapping/index', 'admin/doptor/management/import/dortor/offices/search', 'news/list', 'certificate_asst/create/form', 'certificate_asst-short-decision', 'certificate_asst/list') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <i class="fas fa-cog"></i>
                                        <p class="navi-text">সেটিংস </p>
                                    </span>
                                </div>
                            </div>

                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->
                                    @if (in_array(16, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('office') }}"
                                                class="navi-link {{ request()->is('office') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <i class="la la-briefcase"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">অফিস
                                                    সেটিংস</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(17, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('app.setting.index') }}"
                                                class="navi-link {{ request()->is('app/setting/index') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <i class="fas fa-cog"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">অ্যাপস
                                                    সেটিংস</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(26, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('court') }}"
                                                class="navi-link {{ request()->is('court', 'certificate_asst-short-decision') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <i class="fas fa-balance-scale"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">আদালত সেটিংস</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(27, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('settings.short-decision') }}"
                                                class="navi-link {{ request()->is('settings/short-decision') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                        <i class="fas fa-file"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    <span class="navi-text">সংক্ষিপ্ত
                                                        আদেশ</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(110, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('certificate_asst.short.decision') }}"
                                                class="navi-link {{ request()->is('certificate_asst-short-decision') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                        <i class="fas fa-file"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    <span class="navi-text">গৃহীত ব্যবস্থা</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(39, $menu))
                                        <li
                                            class="navi-item {{ request()->is('case-mapping/index') ? 'menu-item-active' : '' }}">
                                            <a href="{{ url('case-mapping/index') }}" class="navi-link ">
                                                <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                    <i class="fas fa-network-wired"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="navi-text">আদালতের অধিক্ষেত্র নির্ধারণ</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(15, $menu))
                                        <li
                                            class="navi-item {{ request()->is('certificate_asst/create/form') ? 'menu-item-active' : '' }}">
                                            <a href="{{ route('certificate.assistent.gco.list.create.form') }}"
                                                class="navi-link">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <i class="fas fa-user"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    <span class="navi-text">ইউজার ম্যানেজমেন্ট</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(42, $menu))
                                        @if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 1)
                                            <li
                                                class="navi-item {{ request()->is('admin/doptor/management/import/dortor/offices/search') ? 'menu-item-active' : '' }}">
                                                <a href="{{ url('/admin/doptor/management/import/dortor/offices/search') }}"
                                                    class="navi-link">
                                                    <span class="symbol-20 mr-3">
                                                        <span
                                                            class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                            <i class="fas fa-user"></i>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                        <span class="navi-text">দপ্তর ইউজার</span>
                                                </a>
                                            </li>
                                        @else
                                            <li
                                                class="navi-item {{ request()->is('/doptor/user/management/office_list') ? 'menu-item-active' : '' }}">
                                                <a href="{{ url('/doptor/user/management/office_list') }}"
                                                    class="navi-link">
                                                    <span class="symbol-20 mr-3">
                                                        <span
                                                            class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                            <i class="fas fa-user"></i>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                        <span class="navi-text">দপ্তর ইউজার</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                    @if (in_array(114, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('news.list') }}"
                                                class="navi-link {{ request()->is('news/list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3 auth-svg-icon-bar ">
                                                    <i class=" ml-1 fas fa-newspaper"
                                                        style="color: #acdefe !important"></i>
                                                </span>
                                                <span class="navi-text">ফিচার নিউজ</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->

                        </div>
                    @endif

                    @if (in_array(45, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item cs_notification" data-toggle="dropdown" data-offset="10px,0px"
                                title="">
                                <a
                                    class="navi-link {{ request()->is('appeal/closed_list') || request()->is('appeal/old/dismiss/case') ? 'menu-item-active' : '' }}">
                                    <div class=" btn-clean btn-dropdown mr-2">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                            <i class="fas fa-book"></i>
                                            <p class="navi-text">আর্কাইভ</p>
                                        </span>


                                    </div>
                                </a>
                            </div>
                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->
                                    @if (in_array(8, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.closed_list') }}"
                                                class="navi-link {{ request()->is('appeal/closed_list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                <path
                                                                    d="M8,17 C8.55228475,17 9,17.4477153 9,18 L9,21 C9,21.5522847 8.55228475,22 8,22 L3,22 C2.44771525,22 2,21.5522847 2,21 L2,18 C2,17.4477153 2.44771525,17 3,17 L3,16.5 C3,15.1192881 4.11928813,14 5.5,14 C6.88071187,14 8,15.1192881 8,16.5 L8,17 Z M5.5,15 C4.67157288,15 4,15.6715729 4,16.5 L4,17 L7,17 L7,16.5 C7,15.6715729 6.32842712,15 5.5,15 Z"
                                                                    fill="#000000" opacity="0.3"></path>
                                                                <path
                                                                    d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z"
                                                                    fill="#000000"></path>
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text"> নিষ্পত্তিকৃত মামলা</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(46, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.old.dismiss.case') }}"
                                                class="navi-link {{ request()->is('appeal/pending/list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    {{-- <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(12.000000, 7.000000) rotate(-180.000000) translate(-12.000000, -7.000000) "
                                                                    x="11" y="1" width="2"
                                                                    height="12" rx="1" />
                                                                <path
                                                                    d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                                <path
                                                                    d="M14.2928932,10.2928932 C14.6834175,9.90236893 15.3165825,9.90236893 15.7071068,10.2928932 C16.0976311,10.6834175 16.0976311,11.3165825 15.7071068,11.7071068 L12.7071068,14.7071068 C12.3165825,15.0976311 11.6834175,15.0976311 11.2928932,14.7071068 L8.29289322,11.7071068 C7.90236893,11.3165825 7.90236893,10.6834175 8.29289322,10.2928932 C8.68341751,9.90236893 9.31658249,9.90236893 9.70710678,10.2928932 L12,12.5857864 L14.2928932,10.2928932 Z"
                                                                    fill="#000000" fill-rule="nonzero" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span> --}}
                                                    <i class="fas fa-book"></i>
                                                </span>
                                                <span class="navi-text">পুরাতন নিষ্পত্তিকৃত মামলা</span>

                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>
                    @endif
                    @if (in_array(41, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('role-permission/index', 'messages_recent', 'messages', 'register/list', 'support/center', 'report', 'download/form', 'get/organization/list', 'appeal/causelist/case/list', 'appeal/case/trackingfilter') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <i class="fas fa-cog"></i>
                                        <p class="navi-text">অন্যান্য </p>
                                    </span>
                                </div>
                            </div>



                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->


                                    @if (in_array(101, $menu) ||
                                            globalUserInfo()->role_id == 6 ||
                                            globalUserInfo()->role_id == 7 ||
                                            globalUserInfo()->role_id == 8 ||
                                            globalUserInfo()->role_id == 25 ||
                                            globalUserInfo()->role_id == 34)
                                        <div class="dropdown">
                                            <!--begin::Toggle-->
                                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click"
                                                data-toggle="tooltip" data-placement="right" title data-original-title=""
                                                aria-haspopup="true">
                                                <a href="{{ route('log.indx') }}"
                                                    class="navi-link {{ request()->is('log_index') ? 'menu-item-active' : '' }}">
                                                    <div class="btn-dropdown mr-2 pulse pulse-primary">
                                                        <span
                                                            class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                            <i class="fas fa-hands-helping"></i>
                                                            <!--end::Svg Icon-->
                                                            <p class="navi-text">মামলা কার্যকলাপ নিরীক্ষা</p>
                                                        </span>

                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    @if (in_array(28, $menu) || globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 34)
                                        <li class="navi-item">
                                            <a href="{{ route('report') }}"
                                                class="navi-link {{ request()->is('report') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <i class="la la-briefcase"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">রিপোর্ট</span>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- 
    
                                @if (in_array(45, $menu))
                                <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click"
                                    data-toggle="tooltip" data-placement="right" title data-original-title=""
                                    aria-haspopup="true">
                                    <a href="{{ url('citizen/appeal/case/trackingfilter') }}"
                                        class="menu-link {{ request()->is('dashboard') ? '' : '' }}">
                                        <div class="btn-dropdown mr-2 pulse pulse-primary">
                                            <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">


                                                +
                                                <i class="fas fa-road"></i>
                                                <!--end::Svg Icon-->
                                                <p class="navi-text">মামলা ট্র্যাকিং</p>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            @endif
    
                                    --}}
                                    @if (in_array(47, $menu) || globalUserInfo()->role_id == 28)
                                        <!-- <li class="navi-item">
                                                                <a href="{{ route('appeal.causeList.case.entry.from') }}"
                                                                    class="navi-link {{ request()->is('causeList.case.entry.from') ? 'menu-item-active' : '' }}">
                                                                    <span class="symbol-20 mr-3">
                                                                        <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                                        <i class="fas fa-book"></i>
                                                                            
                                                                        </span>
                                                                    </span>
                                                                    <span class="navi-text">কজ লিস্ট এন্ট্রি ফরম</span>
                                                                </a>
                                                            </li>  -->
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.causelist.case.list') }}"
                                                class="navi-link {{ request()->is('appeal/causelist/case/list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <i class="fas fa-book"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">কজ লিস্ট এন্ট্রি</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(49, $menu) || globalUserInfo()->role_id == 28)
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.currentAppealEntryList') }}"
                                                class="navi-link {{ request()->is('appeal/currentAppealEntryList') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <i class="fas fa-book"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">চলমান মামলা এন্ট্রি </span>
                                            </a>
                                        </li>
                                     @endif
                                    @if (in_array(48, $menu))
                                        <li class="navi-item">
                                            <a href="{{ url('appeal/case/trackingfilter') }}"
                                                class="navi-link {{ request()->is('appeal/case/trackingfilter') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <i class="la la-briefcase"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">মামলা ট্র্যাকিং</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(45, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('support.center') }}"
                                                class="navi-link {{ request()->is('support/center') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <i class="la la-briefcase"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">সাপোর্ট</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(18, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('messages') }}"
                                                class="navi-link {{ request()->is('messages') ? 'menu-item-active' : '' }}">
                                                <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                    <i class="fas fa-envelope-square"></i>
                                                    <!--end::Svg Icon-->
                                                    <p class="navi-text">বার্তা</p>
                                                </span>
                                                @if (isset($Ncount) && $Ncount != 0)
                                                    <span class="menu-label">
                                                        <span
                                                            class="label label-rounded label-danger">{{ $Ncount }}</span>
                                                    </span>
                                                @endif
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(19, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('messages_recent') }}"
                                                class="navi-link {{ request()->is('messages_recent') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <i class="fas fa-envelope-open-text"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">সাম্প্রতিক বার্তা</span>
                                                @if (isset($NewMessagesCount) && $NewMessagesCount != 0)
                                                    <span class="menu-label">
                                                        <span
                                                            class="label label-rounded label-danger">{{ $NewMessagesCount }}</span>
                                                    </span>
                                                @endif
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(21, $menu))
                                        @if (isset($msg_request_count) && $msg_request_count != 0)
                                            <li class="navi-item">
                                                <a href="{{ route('messages') }}"
                                                    class="navi-link {{ request()->is('messages') ? 'menu-item-active' : '' }}">
                                                    <span class="symbol-20 mr-3">
                                                        <span
                                                            class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </span>
                                                    <span class="navi-text">ব্যবহারকারীর তালিকা</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (in_array(12, $menu))
                                        <li class="navi-item">
                                            <a href="{{ url('register/list') }}"
                                                class="navi-link {{ request()->is('register/list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <i class="fas fa-pen-square"></i>
                                                    </span>
                                                </span>
                                                <span class="navi-text"> রেজিষ্টার</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(43, $menu))
                                        <li class="navi-item">
                                            <a href="{{ url('/get/organization/list') }}"
                                                class="navi-link {{ request()->is('get/organization/list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <i class="fas fa-pen-square"></i>
                                                    </span>
                                                </span>
                                                <span class="navi-text"> প্রতিষ্ঠান যুক্ত করুন </span>
                                            </a>
                                        </li>
                                    @endif
                                    <li class="navi-item">
                                        <a href="{{ url('/download/form') }}"
                                            class="navi-link {{ request()->is('download/form') ? 'menu-item-active' : '' }}">
                                            <span class="symbol-20 mr-3">
                                                <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                    <i class="fas fa-pen-square"></i>
                                                </span>
                                            </span>
                                            <span class="navi-text"> ফর্ম ডাউনলোড</span>
                                        </a>
                                    </li>

                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->

                        </div>

                    @endif
                    {{-- @if (!empty(globalUserInfo()->doptor_user_flag) && globalUserInfo()->doptor_user_flag == 1)
                    <div class="dropdown">
                        <!--begin::Toggle-->
                        <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click" data-toggle="tooltip"
                            data-placement="right" title data-original-title="" aria-haspopup="true">
                            <a href="{{ url('role-permission/index') }}"
                                class="navi-link {{ request()->is('role-permission/index') ? 'menu-item-active' : '' }}">
                                <div class="btn-dropdown mr-2 pulse pulse-primary">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <i class="fas fa-pencil-ruler"></i>
                                        <!--end::Svg Icon-->
                                        <p class="navi-text"><?= dorptor_widget() ?></p>
                                    </span>


                                </div>
                            </a>
                        </div>
                    </div>
                @endif --}}



                    <div class="topbar-item">
                        <div class="btn  -mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <span class="text-muted font-size-base d-none d-md-inline mr-1">
                                @if (Auth::user()->profile_pic != null)
                                    @if (Auth::user()->doptor_user_flag == 1)
                                        <img src="{{ Auth::user()->profile_pic }}">
                                    @else
                                        <img src="{{ url('/') }}/uploads/profile/{{ Auth::user()->profile_pic }}">
                                    @endif
                                @else
                                    <img src="{{ url('/') }}/uploads/profile/default.jpg">
                                @endif
                            </span>
                            <span class="text-dark font-size-base d-none d-md-inline mr-3 text-left">
                                <i style="float: right; padding-left: 18px; padding-top: 7px;"
                                    class="fas fa-chevron-down"></i>
                                <p style="display: table-cell; margin-top: 4px;">
                                    <b>
                                        @if (count(explode(' ', auth()->user()->name)) > 2)
                                            {{ explode(' ', auth()->user()->name)[0] }}
                                            {{ explode(' ', auth()->user()->name)[1] }}
                                        @else
                                            {{ auth()->user()->name }}
                                        @endif
                                    </b>
                                    <br>{{ Auth::user()->role->role_name }}
                                </p>
                            </span>
                        </div>
                    </div>
                @else
                    <div class="tpbar_text_menu topbar-item mr-2">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <a href="" class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">ধারা ভিত্তিক
                                অপরাধের ধরণ</a>
                        </div>
                    </div>
                    <div class="tpbar_text_menu topbar-item mr-2">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <a href="" class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">প্রসেস
                                ম্যাপ</a>
                        </div>
                    </div>
                    <div class="tpbar_text_menu tpbar_text_mlast topbar-item mr-8">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <a href="" class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">আইন ও
                                বিধি</a>
                        </div>
                    </div>
                    <div class="topbar-item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="topbar_social_icon">
                            <a href="" class="social-svg-icon svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(109, 91, 220);" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512">Copyright 2022 Fonticons, Inc. --><path
                                        d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"
                                        fill="#6d5bdc"></path></svg>
                            </a>
                        </div>
                    </div>

                    <div class="topbar-item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="topbar_social_icon">
                            <a href="" class="social-svg-icon svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(108, 90, 220);" xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                    <path
                                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"
                                        fill="#6c5adc"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="topbar-item mr-8">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="topbar_social_icon">
                            <a href="" class="social-svg-icon svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(108, 90, 220);" xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
                                    <path
                                        d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"
                                        fill="#6c5adc"></path>
                                </svg>
                            </a>
                        </div>
                    </div>




                    <div class="topbar-item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(108, 90, 220);" xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                                    <path
                                        d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"
                                        fill="#6c5adc"></path>
                                </svg>
                                <!--end::Svg Icon-->
                            </span><b> Online Course</b>
                            <!-- <input type="button" id="loginID" class="btn btn-info" value="{{ __('লগইন') }}"
                                                                                        data-toggle="modal" data-target="#exampleModalLong"> -->
                        </div>
                    </div>
                    <div class="topbar-item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path
                                            d="M12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 Z M11.613922,13.2130341 C11.1688026,13.6581534 10.4887934,13.7685037 9.92575695,13.4869855 C9.36272054,13.2054673 8.68271128,13.3158176 8.23759191,13.760937 L6.72658218,15.2719467 C6.67169475,15.3268342 6.63034033,15.393747 6.60579393,15.4673862 C6.51847004,15.7293579 6.66005003,16.0125179 6.92202169,16.0998418 L8.27584113,16.5511149 C9.57592638,16.9844767 11.009274,16.6461092 11.9783003,15.6770829 L15.9775173,11.6778659 C16.867756,10.7876271 17.0884566,9.42760861 16.5254202,8.3015358 L15.8928491,7.03639343 C15.8688153,6.98832598 15.8371895,6.9444475 15.7991889,6.90644684 C15.6039267,6.71118469 15.2873442,6.71118469 15.0920821,6.90644684 L13.4995401,8.49898884 C13.0544207,8.94410821 12.9440704,9.62411747 13.2255886,10.1871539 C13.5071068,10.7501903 13.3967565,11.4301996 12.9516371,11.8753189 L11.613922,13.2130341 Z"
                                            fill="#000000" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span><b>333</b>
                            <!-- <a href="{{ url('/citizenRegister') }}" type="button" class="btn btn-info"
                                                                                        value="">{{ __('নাগরিক নিবন্ধন') }}</a> -->
                        </div>
                    </div>
                @endauth
                <!--end::User-->
            </div>
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
