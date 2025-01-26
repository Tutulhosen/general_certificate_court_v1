    <div class="container">
        <div class="alert alert-danger" style="display:none"></div>

        <div class="alert alert-custom alert-light-success fade show mb-9" role="alert" id="sfCreateSuccess"
            style="display:none">
            <div class="alert-icon">
                <i class="flaticon2-check-mark"></i>
            </div>
            <div class="alert-text font-size-h3">এস এফ প্রতিবেদন সফলভাবে তৈরি হয়েছে</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="ki ki-close"></i>
                    </span>
                </button>
            </div>
        </div>

        <div class="alert alert-custom alert-light-success fade show mb-9" role="alert" id="sfEditSuccess"
            style="display:none">
            <div class="alert-icon">
                <i class="flaticon2-check-mark"></i>
            </div>
            <div class="alert-text font-size-h3">সফলভাবে এস এফ প্রতিবেদন সংশোধন করা হয়েছে</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="ki ki-close"></i>
                    </span>
                </button>
            </div>
        </div>

        <?php if($info->is_sf){ ?>
        <!--begin::Row Edit SF-->
        <div class="row" id="sf_edit_content" style="display: none;">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <!--begin::Form-->
                    <form action="{{ url('action.editsf') }}" class="form" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- <div class="loadersmall"></div> -->
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <fieldset>
                                    <legend style="width: 70%;">কারণ দর্শানো নোটিশের প্যারা ভিত্তিক জবাব সংশোধন করুন</legend>
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <textarea name="sf_details" id="sf_details" class="form-control" rows="13"
                                                spellcheck="false"><?php echo $sf->sf_details; ?></textarea>
                                        </div>
                                        <input type="hidden" name="hide_case_id" id="hide_case_id"
                                            value="{{ $info->id }}">
                                        <input type="hidden" name="hide_sf_id" id="hide_sf_id"
                                            value="{{ $sf->id }}">
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-6">
                                <?php if($info->show_cause_file != NULL){ ?>
                                <embed src="{{ asset('uploads/show_cause/' . $info->show_cause_file) }}"
                                    type="application/pdf" width="100%" height="400px" />
                                <?php } ?>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-7">
                                    <button type="button" id="sfUpdateSubmit"
                                        class="btn btn-primary font-weight-bold font-size-h2 px-8 py-3"><i
                                            class="flaticon2-box icon-3x"></i> সংরক্ষণ করুন</button>
                                    <button type="button" id="closesf_edit_button" class="btn btn-danger ml-2"><i
                                            class="fas fa-times icon-3x"></i></button>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card-->
            </div>
        </div>
        <!--end::Row-->
        <?php } ?>


        <!--begin::Row Create SF-->
        <div class="row" id="sf_content" style="display: none;">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom example example-compact">
                    <!--begin::Form-->
                    <form action="{{ route('action.createsf') }}" class="form" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- <div class="loadersmall"></div> -->
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <fieldset>
                                    <legend style="width: 70%;">কারণ দর্শানো নোটিশের প্যারা ভিত্তিক জবাব লিখুন</legend>
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <textarea name="sf_details" id="sf_details" class="form-control" rows="13"
                                                spellcheck="false"></textarea>
                                        </div>
                                        <input type="hidden" name="hide_case_id" id="hide_case_id"
                                            value="{{ $info->id }}">
                                    </div>
                                    {{-- <input type="submit" class="btn"> --}}
                                </fieldset>
                            </div>

                            <div class="col-md-6">
                                <?php if($info->show_cause_file != NULL){ ?>
                                <embed src="{{ asset('uploads/show_cause/' . $info->show_cause_file) }}"
                                    type="application/pdf" width="100%" height="400px" />
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-7">
                                    <button type="button" id="sfCreateSubmit" class="btn btn-primary font-weight-bold font-size-h2 px-5 py-3">
                                        <i class="flaticon2-box icon-3x"></i>
                                        সংরক্ষণ করুন
                                    </button>
                                    <button type="button" id="Closesf_create" class="btn btn-danger ml-2">
                                        <i class="fas fa-times icon-3x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card-->
            </div>
        </div>
        <!--end::Row-->
        @if (!empty($info->ref_id))
            @if ($ref_case->is_sf == 0)
                <div class="alert-text font-size-h3">পূর্বের মামলার কোন এসএফ প্রতিবেদন তৈরি করা হয়নি
                    !</div>
            @else
                <a href="{{ route('action.pdf_sf', $info->ref_id) }}" target="_blank"
                    class="btn btn-sm btn-success font-size-h5 float-left"> <i class="fa fas fa-file-pdf"></i>
                    <b>পূর্বের মামলার এসএফ প্রতিবেদন</b>
                </a>
            @endif
        @endif
        <br>
        <br>
        <div id="returnSfdetail"></div>
        <?php if($info->is_sf){ ?>
        <div id="sf_docs">
            <a href="{{ route('action.pdf_sf', $info->id) }}" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left">
                <i class="fa fas fa-file-pdf"></i>
                <b>জেনারেট পিডিএফ</b>
            </a>
            @if ($info->status != 3)
                <?php if(Auth::user()->role_id == 12 || Auth::user()->role_id == 8 || Auth::user()->role_id == 9 || Auth::user()->role_id == 10 || Auth::user()->role_id == 11){ ?>
                <a href="javascript:void(0)" id="sf_edit_button" class="btn btn-sm btn-danger font-size-h5 float-right">
                    <i class="fa fas fa-edit"></i> <b>সংশোধন করুন</b>
                </a>
                <?php } ?>
            @endif

            <div class="text-center font-weight-bolder font-size-h2">কারণ দর্শাইবার জবাব</div>
            <div class="text-center font-weight-bolder font-size-h3">মোকামঃ
                {{ $info->court_name }}</div>
            <div class="text-center font-weight-bold font-size-h3"><b>বিষয়ঃ</b> দেওয়ানী মোকাদ্দমা নং
                {{ $info->case_number }} এর প্যারাভিত্তিক জবাব প্রেরণ প্রসঙ্গে</div> <br>
            <p class="font-size-h4">
                @php $badi_sl = 1; @endphp
                @foreach ($badis as $badi)
                    {{ $badi_sl }}। {{ $badi->badi_name }}, পিতা/স্বামীঃ
                    {{ $badi->badi_spouse_name }} <br>
                    সাং {{ $badi->badi_address }}
                    <br>
                    @php $badi_sl++; @endphp
                @endforeach
                ................................................................. বাদী
            </p>

            <div class="font-weight-bolder font-size-h3 mt-5 mb-5">বনাম</div>

            <p class="font-size-h4">
                @php $bibadi_sl = 1; @endphp
                @foreach ($bibadis as $bibadi)
                    {{ $bibadi_sl }}। {{ $bibadi->bibadi_name }}, পিতা/স্বামীঃ
                    {{ $bibadi->bibadi_spouse_name }} <br>
                    সাং {{ $bibadi->bibadi_address }}
                    <br>
                    @php $bibadi_sl++; @endphp
                @endforeach
                ................................................................. বিবাদী
            </p>

            <p class="font-size-h4 mt-15">
                <?php echo nl2br($sf->sf_details); ?>
            </p>

            <table>
                <tr>
                    @foreach ($sf_signatures as $signature)
                        <td width="30%">
                            @if ($signature->signature != null)
                                <img src="{{ asset('uploads/signature/' . $signature->signature) }}"
                                    alt="{{ $signature->name }}" height="50">
                            @endif
                            <br><strong>{{ $signature->name }}</strong><br>
                            <span style="font-size:15px;">{{ $signature->role_name }}<br>
                                {{ $signature->office_name_bn }}<br></span>
                        </td>
                    @endforeach
                </tr>
            </table>
        </div>

        <?php }else{ ?>

        <!--begin::Notice-->
        <div class="alert alert-custom alert-light-danger fade show mb-9" role="alert" id="noSfCreate">
            <div class="alert-icon">
                <i class="flaticon-warning"></i>
            </div>
            <div class="alert-text font-size-h3">এখনও পর্যন্ত কোন এসএফ প্রতিবেদন তৈরি করা হয়নি !
            </div>

            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="ki ki-close"></i>
                    </span>
                </button>
            </div>
        </div>
        <!--end::Notice-->

        <?php if(Auth::user()->role_id == 12){ ?>
        <div class="row justify-content-md-center" id="sf_create_button">
            <div class="col-5">
                <a href="javascript:void(0)" id="sf_create"
                    class="btn btn-primary font-weight-bold font-size-h2 px-12 py-5"><i
                        class="flaticon2-layers icon-3x"></i> এস এফ প্রতিবেদন তৈরি করুন</a>
            </div>
        </div>
        <?php } ?>
        <?php } ?>

    </div>

