    <div class="container" id="caseResultUpdate">
        <div class="alert alert-danger" style="display:none"></div>
        <div class="alert alert-custom alert-light-success fade show mb-9" role="alert" id="resultSuccess"
            style="display:none">
            <div class="alert-icon">
                <i class="flaticon2-check-mark"></i>
            </div>
            <div class="alert-text font-size-h3">মামলার ফলাফল সংরক্ষণ করা হয়েছে</div>
        </div>

        <?php if($info->result == 1){ ?>
        <div class="mb-3">
            <span class="text-dark-100 flex-root h2 font-weight-bolder">মামলার ফলাফলঃ</span>
            <span class="text-success flex-root font-weight-bold h1"> জয়ী</span>
        </div>
        @if ($info->result_file != null)
            <div class="my-5">
                <span class="text-dark-100 flex-root font-weight-bolder h2">মামলার ফলাফলের দলিল :</span><br>
                <embed src="{{ asset($info->case_result_file) }}" type="application/pdf" width="100%" height="600px" />
            </div>
        @endif

        <?php }elseif($info->result == 0){ ?>
        <div class="mb-3">
            <span class="text-dark-100 flex-root h2 font-weight-bolder">মামলার ফলাফলঃ </span>
            <span class="text-danger flex-root font-weight-bold h1"> পরাজয়</span>
        </div>
        <div class="mb-3">
            <span class=" text-dark-100 flex-root font-weight-bolder h2">পরাজয়ের কারণঃ </span>
            <span class="text-dark flex-root font-weight-bold font-size-h6">"<?= $info->lost_reason ?>"</span>
        </div>
        @if ($info->result_file != null)
            <div class="my-5">
                <span class="text-dark-100 flex-root font-weight-bolder h2">মামলার ফলাফলের দলিল :</span><br>
                <embed src="{{ asset($info->result_file) }}" type="application/pdf" width="100%" height="600px" />
            </div>
        @endif

        <?php } else { ?>

        <div id="haventResult" class="alert alert-custom alert-light-danger fade show mb-9" role="alert">
            <div class="alert-icon">
                <i class="fa fas fa-walking"></i>
            </div>
            <div class="alert-text font-size-h3">এখনো পর্যন্ত মামলাটির কার্যক্রম চলমান, সম্পন্ন
                হয়নি!</div>
        </div>

        <div id="resultUpSuccess" class="alert alert-custom alert-light-success fade show mb-9" role="alert">
            <div class="alert-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="alert-text font-size-h3">মামলার ফলাফল সফলভাবে আপলোড করা হয়েছে!</div>
        </div>

        <?php } ?>



        <?php if(Auth::user()->role_id == 8 || Auth::user()->role_id == 13 || Auth::user()->role_id == 14 || Auth::user()->role_id == 16){ ?>
        <!-- <a href="javascript:void(0)" id="hearing_add_button" class="btn btn-danger float-right"><i class="fa fas fa-landmark"></i> <b>শুনানির তারিখ যুক্ত করুন</b></a> -->

        <!--begin::Row Create SF-->
        <div class="row" id="result_update_content" style="display: black;">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom example example-compact">
                    <!--begin::Form-->
                    @if ($info->in_favour_govt == null)
                        <form id="ajax-caseResult-upload" action="{{ url('action.result_update') }}" class="form"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="hide_case_id" id="hide_case_id" value="{{ $info->id }}">

                            <!-- <div class="loadersmall"></div> -->
                            <div class="row mb-5">
                                <div class="col-md-12">
                                    <fieldset>
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <label>ফলাফল <span class="text-danger">*</span></label>
                                                <div class="radio-inline">
                                                    <label class="radio">
                                                        <input type="radio" name="is_win" id="win" value="1"
                                                            checked="checke" />
                                                        <span></span>জয়</label>
                                                    <label class="radio">
                                                        <input type="radio" name="is_win" id="lost" value="0" />
                                                        <span></span>পরাজয়</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-8" id="lostReason">
                                                <label>পরাজয়ের কারণ </label>
                                                <textarea name="lost_reason" id="lost_reason" class="form-control"
                                                    rows="3" spellcheck="false"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>ফলাফলের ফাইল আপলোড করুন <span
                                                            class="text-danger">*</span></label>
                                                    <div></div>
                                                    <div class="custom-file">
                                                        <input type="file" name="result_file" class="custom-file-input"
                                                            id="result_file">
                                                        <label class="custom-file-label" for="customFile">ফাইল নির্বাচন
                                                            করুন</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mb-5">
                                                <label>মামলার বর্তমান অবস্থা <span class="text-danger">*</span></label>
                                                <select name="condition_name" id="condition_name"
                                                    class="form-control form-control-sm">
                                                    <option value="">-- নির্বাচন করুন --</option>
                                                    {{-- @foreach ($case_condition as $value)
                                                        @if ($value->id != 1)
                                                            <option value="{{ $value->id }}"
                                                                {{ old('condition_name') == $value->id ? 'selected' : '' }}>
                                                                {{ $value->condition_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="form-group row">
                                    <div class="col-lg-4">
                                       <label>মামলার রায় সরকারের পক্ষে গিয়েছে কিনা? <span class="text-danger">*</span></label>
                                       <div class="radio-inline">
                                          <label class="radio">
                                             <input type="radio" name="in_favour_govt" id="in_favour_govt"  value="1" checked="checke"/>
                                             <span></span>হ্যা</label>
                                             <label class="radio">
                                                <input type="radio" name="in_favour_govt" id="in_favour_govt" value="0" /><span></span>না</label>
                                             </div>
                                          </div>

                                          <div class="col-lg-4 mb-5">
                                            <label>মামলার বর্তমান অবস্থা <span class="text-danger">*</span></label>
                                            <select name="condition_name" id="condition_name" class="form-control form-control-sm">
                                             <option value="">-- নির্বাচন করুন --</option>
                                             @foreach ($case_condition as $value)
                                                @if ($value->id != 1)
                                                <option value="{{ $value->id }}" {{ old('condition_name') == $value->id ? 'selected' : '' }}> {{ $value->condition_name }} </option>
                                                @endif
                                             @endforeach
                                          </select>
                                       </div>
                                    </div> --}}
                                        <input type="hidden" name="hide_case_id" id="hide_case_id"
                                            value="{{ $info->id }}">
                                    </fieldset>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-7">
                                        {{-- <button type="button" id="resultSubmit" class="btn btn-primary font-weight-bold font-size-h2 px-8 py-3">
                                            <i class="flaticon2-box icon-3x"></i> সংরক্ষণ করুন
                                        </button> --}}
                                        <button type="submit" id="" class="btn btn-primary font-weight-bold font-size-h2 px-8 py-3">
                                            <i class="flaticon2-box icon-3x"></i> সংরক্ষণ করুন
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                    <!--end::Form-->
                </div>
                <!--end::Card-->
            </div>
        </div>
        <!--end::Row-->

        <?php } ?>

    </div>
