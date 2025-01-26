@include('layouts.base.inc._permission')
@php
global $menu;
@endphp


<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <!--begin::Brand-->
    <div class="brand flex-column-auto" id="kt_brand">
        <!--begin::Logo-->
        <a href="{{ url('dashboard') }}" class="brand-logo">
            <!-- <img alt="Logo" src="media/logos/logo-light.png" /> -->
            {{-- <img alt="Logo" src="{{ asset('media/logos/civil-suit-logo.png') }}" height="45" class="mr-4" style="border: 0px solid #8a8a8a; padding: 2px;" /> --}}
            <img alt="Logo" src="{{ asset(App\Models\SiteSetting::first()->site_logo) }}" height="45"
                class="mr-4" style="border: 0px solid #8a8a8a; padding: 2px;" />
            <!-- <span style="font-weight: bold; font-size: 25px; color: white;">Civil Suit</span> -->
        </a>
        <!--end::Logo-->
        <!--begin::Toggle-->
        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <span class="svg-icon svg-icon svg-icon-xl">
                <!--begin::Svg Icon | path:media/svg/icons/Navigation/Angle-double-left.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                    height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path
                            d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                            fill="#000000" fill-rule="nonzero"
                            transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                        <path
                            d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero" opacity="0.3"
                            transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </button>
        <!--end::Toolbar-->
    </div>
    <!--end::Brand-->

    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <!--begin::Menu Container-->
        <div id="kt_aside_menu" class="aside-menu" data-menu-vertical="1" data-menu-scroll="1"
            data-menu-dropdown-timeout="500">
            <!--begin::Menu Nav-->
            <ul class="menu-nav">


                @if (in_array(1, $menu))
                    <li class="menu-item {{ request()->is('dashboard') ? 'menu-item-active' : '' }}"
                        aria-haspopup="true">
                        <a href="{{ url('dashboard') }}" class="menu-link">
                            <span class="menu-text font-weight-bolder"><i class="fas fa-warehouse"></i>
                                ড্যাশবোর্ড</span>
                        </a>
                    </li>
                @endif
                 @if (in_array(99, $menu))
                    <li class="menu-item {{ request()->is('role-permission/index') ? 'menu-item-active' : '' }}"
                        aria-haspopup="true">
                        <a href="{{ url('role-permission/index') }}" class="menu-link">
                            <span class="menu-text font-weight-bolder"><i class="fas fa-universal-access"></i>
                                রোল পারমিশন</span>
                        </a>
                    </li>
                @endif
                @if (in_array(2, $menu))
                    <li class="menu-item {{ request()->is('calendar') ? 'menu-item-active' : '' }}"
                        aria-haspopup="true">
                        <a href="{{ route('calendar') }}" class="menu-link">
                            <span class="menu-text font-weight-bolder"><i class="far fa-calendar-alt"></i>
                                ক্যালেন্ডার</span>
                        </a>
                    </li>
                @endif
                @if (in_array(3, $menu))
                    <li class="menu-item {{ request()->is('appeal/*', 'messages_group', 'case') ? 'menu-item-open' : '' }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-text font-weight-bolder"><i class="fas fa-layer-group"></i> কোর্ট
                                পরিচালনা</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (in_array(4, $menu))
                                    <li class="menu-item {{ request()->is('appeal/create') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('appeal.create') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text font-weight-bolder"> সার্টিফিকেট রিকুইজিশন
                                                প্রক্রিয়াকরন </span>
                                        </a>
                                    </li>
                                @endif
                                @if (in_array(5, $menu))
                                    <li class="menu-item {{ request()->is('appeal/draft_list') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('appeal.draft_list') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text font-weight-bolder"> খসড়া মামলা </span>
                                        </a>
                                    </li>
                                @endif
                                @if (in_array(7, $menu))
                                    <li class="menu-item {{ request()->is('appeal/pending_list') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a style="pointer-events: block" href="{{ route('appeal.pending_list') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text font-weight-bolder"> গ্রহণের জন্য অপেক্ষমান </span>
                                        </a>
                                    </li>
                                @endif
                                @if (in_array(6, $menu))
                                    <li class="menu-item {{ request()->is('appeal/list') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a style="pointer-events: block" href="{{ route('appeal.index') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text font-weight-bolder"> চলমান মামলা </span>
                                        </a>
                                    </li>
                                @endif

                                @if (in_array(8, $menu))
                                    <li class="menu-item {{ request()->is('appeal/closed_list') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a style="pointer-events: block" href="{{ route('appeal.closed_list') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text font-weight-bolder"> নিষ্পত্তি মামলা </span>
                                        </a>
                                    </li>
                                @endif
                               
                                @if (in_array(10, $menu))
                                    <li class="menu-item {{ request()->is('appeal/rejected_list') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a style="pointer-events: block" href="{{ route('appeal.rejected_list') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text font-weight-bolder"> বাতিলকৃত মামলা </span>
                                        </a>
                                    </li>
                                @endif
                                @if (in_array(11, $menu))
                                    <li class="menu-item {{ request()->is('appeal/collectPaymentList') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a style="pointer-events: pointer"
                                            href="{{ route('appeal.collectPaymentList') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text font-weight-bolder"> অর্থ আদায় </span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif
                @if (in_array(40, $menu))
                    <li class="menu-item {{ request()->is('appeal/*', 'messages_group', 'case') ? 'menu-item-open' : '' }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-text font-weight-bolder"><i class="fas fa-layer-group"></i> সেটিংস</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                
                                @if (in_array(16, $menu))
                                    <li class="menu-item {{ request()->is('office') ? 'menu-item-open' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('office') }}" class="menu-link">
                                            <span class="menu-text font-weight-bolder"><i class="la la-briefcase"></i> অফিস
                                                সেটিংস</span>
                                        </a>
                                    </li>
                                @endif
                                @if (in_array(17, $menu))
                                    <li class="menu-item {{ request()->is('app.setting.index') ? 'menu-item-open' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('app.setting.index') }}" class="menu-link">
                                            <span class="menu-text font-weight-bolder"><i class="fas fa-cog"></i> অ্যাপস
                                                সেটিংস</span>
                                        </a>
                                    </li>
                                @endif
                                @if (in_array(26, $menu))
                                    <li class="menu-item {{ request()->is('court') ? 'menu-item-open' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('court') }}" class="menu-link">
                                            <span class="menu-text font-weight-bolder"><i class="fas fa-balance-scale"></i> আদালত সেটিংস</span>
                                        </a>
                                    </li>
                                @endif

                                @if (in_array(27, $menu))
                                    <li class="menu-item {{ request()->is('settings.short-decision') ? 'menu-item-open' : '' }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('settings.short-decision') }}" class="menu-link">
                                            <span class="menu-text font-weight-bolder"><i class="fas fa-file"></i> সংক্ষিপ্ত
                                                আদেশ</span>
                                        </a>
                                    </li>
                                @endif    
                            </ul>
                        </div>
                    </li>
                @endif
                @if (in_array(12, $menu))
                    <li class="menu-item {{ request()->is('register/list') ? '' : '' }}" aria-haspopup="true">
                        <a href="{{ url('register/list') }}" class="menu-link">
                            <span class="menu-text font-weight-bolder"><i class="fas fa-pen-square"></i>
                                রেজিষ্টার</span>
                        </a>
                    </li>
                @endif



                @if (in_array(39, $menu))
                    <li class="menu-item {{ request()->is('dashboard') ? '' : '' }}" aria-haspopup="true">
                        <a href="{{ url('case-mapping/index') }}" class="menu-link">
                            <span class="menu-text font-weight-bolder"><i class="fas fa-hands-helping"></i> ম্যাপিং
                            </span>
                        </a>
                    </li>
                @endif


                @if (in_array(14, $menu))
                    {{-- // ========== Notification start =================== --}}
                    <li class="menu-item {{ request()->is(['hearing_date', 'results_completed', 'new_sf_list']) ? 'menu-item-open' : '' }} cs_notification"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-text font-weight-bolder"><i class="fas fa-bell"></i></i>
                                নোটিফিকেশন</span>
                            @if ($notification_count != 0)
                                <span class="menu-label">
                                    <span class="label label-rounded label-danger cs_notification_count"
                                        data-notification={{ $notification_count }}></span>
                                </span>
                            @endif
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">

                                @if (in_array(22, $menu))
                                    @if ($total_pending_case > 0)
                                        <li class="menu-item" aria-haspopup="true">
                                            <a href="{{ route('appeal.pending_list') }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                <span class="menu-text font-weight-bolder"> গ্রহণের জন্য অপেক্ষমান
                                                </span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ en2bn($total_pending_case) }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                                @if (in_array(23, $menu))
                                    @if ($CaseTrialCount > 0)
                                        <li class="menu-item" aria-haspopup="true">
                                            <a href="{{ route('appeal.trial_date_list') }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                <span class="menu-text font-weight-bolder"> শুনানির তারিখ </span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ en2bn($CaseTrialCount) }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                                @if (in_array(43, $menu))
                                @if ($reviewedCaseCount > 0)

                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="##" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text font-weight-bolder"> চলমান মামলাতে পদক্ষেপ নিতে হবে</span>
                                            <span class="menu-label">
                                                <span
                                                    class="label label-rounded label-danger">{{ en2bn($reviewedCaseCount) }}</span>
                                            </span>
                                        </a>
                                    </li>
                                @endif
                            @endif

                                @if (in_array(24, $menu))
                                    @if ($CaseWarrentCount > 0)
                                        <li class="menu-item" aria-haspopup="true">
                                            <a href="{{ route('appeal.arrest_warrent_list') }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                <span class="menu-text font-weight-bolder"> গ্রেপ্তারি পরোয়ানা জারি
                                                </span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ en2bn($CaseWarrentCount) }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                                @if (in_array(25, $menu))
                                    @if ($CaseCrockCount > 0)
                                        <li class="menu-item" aria-haspopup="true">
                                            <a href="{{ route('appeal.crock_order_list') }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                <span class="menu-text font-weight-bolder"> ক্রোকের আদেশ </span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ en2bn($CaseCrockCount) }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                                @if (in_array(29, $menu))
                                    @if ($reviewedCaseCount > 0)

                                        <li class="menu-item" aria-haspopup="true">
                                            <a href="{{ route('appeal.review_appeal_list') }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                <span class="menu-text font-weight-bolder"> রিভিউয়ের জন্য আবেদন </span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ en2bn($reviewedCaseCount) }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                {{-- =========== Notification End =================== --}}
                @if (in_array(15, $menu))
                    <li class="menu-item {{ request()->is('user-management') ? 'menu-item-open' : '' }}"
                        aria-haspopup="true">
                        <a href="{{ url('user-management') }}" class="menu-link">
                            <span class="menu-text font-weight-bolder"><i class="fas fa-users"></i> ইউজার
                                ম্যানেজমেন্ট</span>
                        </a>
                    </li>
                @endif
                @if (in_array(28, $menu))
                    <li class="menu-item {{ request()->is('report') ? 'menu-item-open' : '' }}"
                        aria-haspopup="true">
                        <a href="{{ route('report') }}" class="menu-link">
                            <span class="menu-text font-weight-bolder"><i class="fas fa-clipboard-check"></i>
                                রিপোর্ট</span>
                        </a>
                    </li>
                @endif
                @if (in_array(18, $menu))


                    <li class="menu-item {{ request()->is('messages', 'messages/*', 'messages_recent', 'messages_request') ? 'menu-item-open' : '' }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-text font-weight-bolder"><i class="fas fa-envelope-square"></i>
                                বার্তা</span>
                            @if ($Ncount != 0)
                                <span class="menu-label">
                                    <span class="label label-rounded label-danger">{{ $Ncount }}</span>
                                </span>
                            @endif
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">

                                @if (in_array(19, $menu))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('messages_recent') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text font-weight-bolder">সাম্প্রতিক বার্তা</span>
                                            @if ($NewMessagesCount != 0)
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ $NewMessagesCount }}</span>
                                                </span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                                @if (in_array(20, $menu))
                                    @if ($msg_request_count != 0)
                                        <li class="menu-item" aria-haspopup="true">
                                            <a href="{{ route('messages_request') }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                <span class="menu-text font-weight-bolder">নতুন বার্তা অনুরোধ</span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ $msg_request_count }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                                @if (in_array(21, $menu))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('messages') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text font-weight-bolder">ব্যবহারকারীর তালিকা</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif
                @if (in_array(13, $menu))
                    <li class="menu-item {{ request()->is('dashboard') ? '' : '' }}" aria-haspopup="true">
                        <a href="{{ url('dashboard') }}" class="menu-link">
                            <span class="menu-text font-weight-bolder"><i class="fas fa-hands-helping"></i> সাপোর্ট
                            </span>
                        </a>
                    </li>
                @endif

                @if (in_array(101, $menu))
                <li class="menu-item {{ request()->is('dashboard') ? '' : '' }}" aria-haspopup="true">
                    <a href="{{ url('log_index') }}" class="menu-link">
                        <span class="menu-text font-weight-bolder"><i class="fas fa-hands-helping"></i> মামলা কার্যকলাপ নিরীক্ষা 
                        </span>
                    </a>
                </li>
            @endif
            </ul>
            <!--end::Menu Nav-->
        </div>
        <!--end::Menu Container-->
    </div>
    <!--end::Aside Menu-->
</div> <!-- /aside-left -->
