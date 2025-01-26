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
            <li class="menu-item {{ request()->is('calendar') ? 'menu-item-active' :  ''}}" aria-haspopup="true">
               <a href="{{ route('calendar') }}" class="menu-link">
                  <span class="menu-text font-weight-bolder"><i class="fas fa-tachometer-alt"></i> ক্যালেন্ডার</span>
               </a>
            </li>

            <li class="menu-item {{ request()->is('case/*', 'messages_group', 'case') ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
               <a href="javascript:;" class="menu-link menu-toggle">
                  <span class="menu-text font-weight-bolder"><i class="fas fa-layer-group"></i> কোর্ট পরিচালনা</span>
                  <i class="menu-arrow"></i>
               </a>
               <div class="menu-submenu">
                  <i class="menu-arrow"></i>
                  <ul class="menu-subnav">
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ url('case/add') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                            <span class="menu-text font-weight-bolder">  সার্টিফিকেট মামলা তৈরি করুন </span>
                        </a>
                    </li>
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ url('appeal/list') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                            <span class="menu-text font-weight-bolder"> চলমান মামলা </span>
                        </a>
                    </li>
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ route('rmcase.index') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                            <span class="menu-text font-weight-bolder"> নিষ্পত্তি মামলা</span>
                        </a>
                    </li>
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ route('rmcase.index') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                            <span class="menu-text font-weight-bolder"> মুলতবি মামলা </span>
                        </a>
                    </li>
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ route('rmcase.index') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                            <span class="menu-text font-weight-bolder">  অর্থ আদায়                                            </span>
                        </a>
                    </li>
                  </ul>
               </div>
            </li>
            <li class="menu-item {{ request()->is('dashboard') ? '' : '' }}" aria-haspopup="true">
                <a href="{{ url('dashboard') }}" class="menu-link">
                   <span class="menu-text font-weight-bolder"><i class="fas fa-tachometer-alt"></i>  রেজিষ্টার</span>
                </a>
            </li>
            <li class="menu-item {{ request()->is('dashboard') ? '' : '' }}" aria-haspopup="true">
                <a href="{{ url('dashboard') }}" class="menu-link">
                   <span class="menu-text font-weight-bolder"><i class="fas fa-tachometer-alt"></i>নথি </span>
                </a>
            </li>
            <li class="menu-item {{ request()->is('dashboard') ? '' : '' }}" aria-haspopup="true">
                <a href="{{ url('dashboard') }}" class="menu-link">
                   <span class="menu-text font-weight-bolder"><i class="fas fa-tachometer-alt"></i> সাহায্য </span>
                </a>
            </li>
            {{-- // ========== Notification start =================== --}}
            <li class="menu-item {{ request()->is(['hearing_date', 'results_completed', 'new_sf_list']) ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="menu-text font-weight-bolder"><i class="fas fa-bell"></i></i> নোটিফিকেশন</span>
                    @if ($notification_count != 0)
                    <span class="menu-label">
                        <span class="label label-rounded label-danger">{{ $notification_count }}</span>
                    </span>
                    @endif
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                    @if (Auth::user()->role_id == 2)
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('hearing_date') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                            <span class="menu-text font-weight-bolder">শুনানির তারিখ নির্ধারণ করা হয়েছে</span>
                            <span class="menu-label">
                                <span class="label label-rounded label-danger">{{ $CaseHearingCount }}</span>
                            </span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('rm_hearing_date') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                            <span class="menu-text font-weight-bolder">শুনানির তারিখ নির্ধারণ করা হয়েছে(রাজস্ব মামলা)</span>
                            <span class="menu-label">
                                <span class="label label-rounded label-danger">{{ $RmCaseHearingCount }}</span>
                            </span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('results_completed') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                            <span class="menu-text font-weight-bolder">ফলাফল সম্পন্ন</span>
                            <span class="menu-label">
                                <span class="label label-rounded label-danger">{{ $CaseResultCount }}</span>
                            </span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('newSFlist') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                            <span class="menu-text font-weight-bolder">নতুন এস এফ</span>
                            <span class="menu-label">
                                <span class="label label-rounded label-danger">{{ $total_sf_count }}</span>
                            </span>
                            </a>
                        </li>
                    @else
                        @forelse ($case_status as $row)
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route('action.receive', $row->cs_id) }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                <span class="menu-text font-weight-bolder">{{ $row->status_name }}</span>
                                <span class="menu-label">
                                    <span class="label label-rounded label-danger">{{ $row->total_case }}</span>
                                </span>
                                </a>
                            </li>
                            @empty
                        @endforelse
                        @forelse ($rm_case_status as $row)
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route('rmcase.action.receive', $row->case_status_id) }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                <span class="menu-text font-weight-bolder">{{ $row->case_status->status_name }}</span>
                                <span class="menu-label">
                                    <span class="label label-rounded label-danger">{{ $row->total_case }}</span>
                                </span>
                                </a>
                            </li>
                            @empty
                        @endforelse
                        @if(count($case_status) == 0 && count($rm_case_status) == 0)
                            <div class="d-flex align-items-center rounded p-5 mb-5">
                                <span>কোন নোটিফিকেশন পাওয়া যায়নি</span>
                            </div>
                        @endif
                    @endif
                    </ul>
                </div>
            </li>
            {{-- =========== Notification End =================== --}}
            <li class="menu-item {{ request()->is('app.setting.index') ? 'menu-item-open' : '' }}" aria-haspopup="true">
                <a href="{{ route('app.setting.index') }}" class="menu-link">
                   <span class="menu-text font-weight-bolder"><i class="fas fa-cog"></i> অ্যাপস সেটিংস</span>
                </a>
             </li>
            <li class="menu-item {{ request()->is('messages', 'messages/*', 'messages_recent','messages_request') ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="menu-text font-weight-bolder"><i class="fas fa-file-contract"></i> বার্তা</span>
                    @if($Ncount !=0)
                    <span class="menu-label">
                        <span class="label label-rounded label-danger">{{ $Ncount }}</span>
                    </span>
                    @endif
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ route('messages_recent') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                            <span class="menu-text font-weight-bolder">সাম্প্রতিক বার্তা</span>
                            @if($NewMessagesCount !=0)
                            <span class="menu-label">
                                <span class="label label-rounded label-danger">{{ $NewMessagesCount }}</span>
                            </span>
                            @endif
                        </a>
                    </li>
                    @if ($msg_request_count != 0)
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ route('messages_request') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                            <span class="menu-text font-weight-bolder">নতুন বার্তা অনুরোধ</span>
                            <span class="menu-label">
                                <span class="label label-rounded label-danger">{{ $msg_request_count }}</span>
                            </span>
                        </a>
                    </li>
                    @endif
                        <li class="menu-item" aria-haspopup="true">
                        <a href="{{ route('messages') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                            <span class="menu-text font-weight-bolder">ব্যবহারকারীর তালিকা</span>
                        </a>
                        </li>
                    </ul>
                </div>
            </li>
         </ul> <!--end::Menu Nav-->
      </div> <!--end::Menu Container-->
   </div> <!--end::Aside Menu-->
</div> <!-- /aside-left -->
