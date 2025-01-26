    <div class="container">

        @if (!empty($info->ref_id))
            @if ($ref_case->sf_report == '')

                <div class="alert-text font-size-h3">কোন এসএফ এর চূড়ান্ত প্রতিবেদন পাওয়া যায়নি!
                </div>
            @else
                <a href="{{ asset('uploads/sf_report/' . $ref_case->sf_report) }}" target="_blank"
                    class="btn btn-sm btn-success font-size-h5 float-left"> <i class="fa fas fa-file-pdf"></i><b>পূর্বের
                        মামলার চূড়ান্ত এফএফ প্রতিবেদন</b>
                    <!-- <embed src="{{ asset('uploads/sf_report/' . $ref_case->sf_report) }}" type="application/pdf" width="100%" height="600px" /> -->
                </a>
            @endif
        @endif
        <br>
        <br>

        <div class="alert alert-danger" style="display:none"></div>

        <div class="alert alert-custom alert-light-success fade show mb-9" role="alert" id="sfReportUploadSuccess"
            style="display:none">
            <div class="alert-icon">
                <i class="flaticon2-check-mark"></i>
            </div>
            <div class="alert-text font-size-h3"> সফলভাবে এস এফের চুড়ান্ত প্রতিবেদন আপলোড করা হয়েছে</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="ki ki-close"></i>
                    </span>
                </button>
            </div>
        </div>
        <div id="sfInstantView">
            @if($info->sf_report)
            <embed class="hide_old_finalSF" src="{{ asset('uploads/sf_report/' . $info->sf_report) }}" type="application/pdf" width="100%"
                height="600px" />
            @else
            <!--begin::Notice-->
            <div id="hide_old_finalSF" class="alert alert-custom alert-light-danger fade show mb-9" role="alert">
                <div class="alert-icon">
                    <i class="flaticon-warning"></i>
                </div>
                <div class="alert-text font-size-h3">চুড়ান্ত প্রতিবেদন আপলোড করা হয়নি</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="ki ki-close"></i>
                        </span>
                    </button>
                </div>
            </div>
            <!--end::Notice-->
            @endif
        </div>

        <?php if(Auth::user()->role_id == 13 || Auth::user()->role_id == 16){ ?>
        <div class="row justify-content-md-center mt-5">
            <form method="POST" action="javascript:void(0)" id="ajax-file-upload" enctype="multipart/form-data">
                @csrf
                <fieldset style="width: 500px;">
                    <legend>চুড়ান্ত প্রতিবেদনের স্ক্যান কপি সংযুক্তি <span class="text-danger">*</span></legend>
                    <div class="col-lg-12 mb-5">
                        <div class="form-group">
                            <label></label>
                            <div></div>
                            <div class="custom-file">
                                <input type="file" name="sf_report" class="custom-file-input" id="customFile" required/>
                                <label class="custom-file-label" for="customFile">ফাইল নির্বাচন
                                    করুন</label>
                            </div>
                        </div>

                        <input type="hidden" name="hide_case_id" id="hide_case_id" value="{{ $info->id }}">
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>

                        <!-- <div id="uploadStatus"></div> -->
                    </div>
                </fieldset>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-7">
                            <button type="submit" class="btn btn-primary font-weight-bold font-size-h2 px-5 py-3"><i
                                    class="flaticon2-box icon-3x"></i> আপলোড করুন</button>
                        </div>
                    </div>
                </div>

            </form>

            <div class='progress' id="progress_div"></div>
            <div class='bar' id='bar1'></div>
            <div class='percent' id='percent1'></div>

        </div>

        <?php } ?>

    </div>
