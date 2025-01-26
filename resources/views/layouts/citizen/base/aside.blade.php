<style type="text/css">
    .blink_me {
      animation: blinker 5s linear infinite;
    }

    @keyframes blinker {
      50% {
        opacity: 0;
      }
    }
</style>

<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
   <!--begin::Brand-->
   <div class="brand flex-column-auto" id="kt_brand">
      <!--begin::Logo-->
      <a href="{{ url('dashboard') }}" class="brand-logo">
         <!-- <img alt="Logo" src="media/logos/logo-light.png" /> -->
         {{-- <img alt="Logo" src="{{ asset('media/logos/civil-suit-logo.png') }}" height="45" class="mr-4" style="border: 0px solid #8a8a8a; padding: 2px;" /> --}}
         <img alt="Logo" src="{{ asset(App\Models\SiteSetting::first()->site_logo) }}" height="45" class="mr-4" style="border: 0px solid #8a8a8a; padding: 2px;" />
         <!-- <span style="font-weight: bold; font-size: 25px; color: white;">Civil Suit</span> -->
      </a>
      <!--end::Logo-->
      <!--begin::Toggle-->
      <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
         <span class="svg-icon svg-icon svg-icon-xl">
            <!--begin::Svg Icon | path:media/svg/icons/Navigation/Angle-double-left.svg-->
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
               <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <polygon points="0 0 24 0 24 24 0 24" />
                  <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                  <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
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
      <div id="kt_aside_menu" class="aside-menu" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
         <!--begin::Menu Nav-->
         <ul class="menu-nav">
            <li class="menu-item {{ request()->is('dashboard') ? 'menu-item-active' : '' }}" aria-haspopup="true">
               <a href="{{ url('dashboard') }}" class="menu-link">
                  <span class="menu-text font-weight-bolder"><i class="fas fa-tachometer-alt"></i> ড্যাশবোর্ড</span>
               </a>
            </li>
            @if(globalUserInfo()->role_id == 35)
            <li class="menu-item {{ request()->is('citizen/appeal/*', 'messages_group', 'case') ? 'menu-item-open' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="menu-text font-weight-bolder"><!-- <i class="fas fa-layer-group"></i> --> <i class="fas fa-cash-register"></i>রিকুজিশন প্রক্রিয়াকরন</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                           
                            <li class="menu-item {{ request()->is('citizen/appeal/create') ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('citizen.appeal.create') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                    <span class="menu-text font-weight-bolder"> সার্টিফিকেট রিকুইজিশান নিবন্ধন</span>
                                </a>
                            </li>
                           
                           
                            <!-- <li class="menu-item {{ request()->is('citizen/appeal/draft_list') ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('citizen.appeal.draft_list') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                    <span class="menu-text font-weight-bolder"> খসড়া রিকুইজিশান </span>
                                </a>
                            </li> -->
                                       
                        </ul>
                    </div>
                </li>
                @endif
                <li class="menu-item {{ request()->is('dashboard') ? '' : '' }}" aria-haspopup="true">
                    <a href="{{ url('dashboard') }}" class="menu-link">
                        <span class="menu-text font-weight-bolder"><i class="fas fa-tachometer-alt"></i> সাপোর্ট </span>
                    </a>
                </li>
                {{-- // ========== Notification start =================== --}}
                            <li class="menu-item {{ request()->is(['hearing_date', 'results_completed', 'new_sf_list']) ? 'menu-item-open' : '' }} cs_notification" 
                                aria-haspopup="true" data-menu-toggle="hover">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="menu-text font-weight-bolder"><i class="fas fa-bell"></i></i> নোটিফিকেশন</span>
                                    @if ($notification_count != 0)
                                        <span class="menu-label">
                                            <span class="label label-rounded label-danger cs_notification_count" data-notification={{ $notification_count }}></span>
                                        </span>
                                    @endif
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">
                                        @if ( $notification_count > 0)
                                            @if($CaseTrialCount>0)
                                                <li class="menu-item" aria-haspopup="true">
                                                    <a href="{{ route('citizen.appeal.trial_date_list') }}" class="menu-link">
                                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                        <span class="menu-text font-weight-bolder">  শুনানির তারিখ </span>
                                                        <span class="menu-label">
                                                            <span
                                                                class="label label-rounded label-danger">{{ en2bn($CaseTrialCount) }}</span>
                                                        </span>
                                                    </a>
                                                </li>
                                            @endif
                                        @else
                                            <li class="menu-item" aria-haspopup="true">
                                                    <a href="#" class="menu-link">
                                                        
                                                        <span class=" text-danger">  কোনো নোটিফিকেশন পাওয়া যায় নি .. </span>
                                                        
                                                    </a>
                                                </li>
                                            
                                            
                                        @endif
                                    </ul>
                                </div>
                            </li>
                                {{-- =========== Notification End =================== --}}
            
         </ul> <!--end::Menu Nav-->
      </div> <!--end::Menu Container-->
   </div> <!--end::Aside Menu-->
</div> <!-- /aside-left -->
