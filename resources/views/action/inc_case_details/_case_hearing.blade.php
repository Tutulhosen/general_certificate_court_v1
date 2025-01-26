    <div class="container">

        <div class="alert alert-danger" style="display:none"></div>

        <div class="alert alert-custom alert-light-success fade show mb-9" role="alert" id="hearingAddSuccess"
            style="display:none">
            <div class="alert-icon">
                <i class="flaticon2-check-mark"></i>
            </div>
            <div class="alert-text font-size-h3">শুনানির তারিখ ও অন্যান্য তথ্য সংরক্ষণ করা হয়েছে
            </div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="ki ki-close"></i>
                    </span>
                </button>
            </div>
        </div>

        <?php if(Auth::user()->role_id == 8 || Auth::user()->role_id == 13 || Auth::user()->role_id == 14 || Auth::user()->role_id == 16){ ?>
        <a href="javascript:void(0)" id="hearing_add_button" class="btn btn-danger float-right"><i
                class="fa fas fa-landmark"></i> <b>শুনানির তারিখ যুক্ত করুন</b></a>
        <?php } ?>

        <div class="clearfix"></div>

        <div id="hearing_content">
            @if (!empty($info->ref_id))

                <h3>পূর্বের মামলার শুনানি বা আদেশের তথ্য</h3>
                <table class="table table-hover mb-6 font-size-h5">
                    <thead class="thead-light  font-size-h3">
                        <tr>
                            <th scope="col" width="30">#</th>
                            <th scope="col" width="200">শুনানির তারিখ</th>
                            <th scope="col" width="200">সংযুক্তি</th>
                            <th scope="col">মন্তব্য</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @foreach ($ref_case_hearings as $row)
                            <tr>
                                <td scope="row">{{ en2bn(++$i) }}.</td>
                                <td>{{ $row->hearing_date }}</td>
                                <td>
                                    <a href="#" class="btn btn-success btn-shadow" data-toggle="modal"
                                        data-target="#orderAttachmentModalOld">
                                        <i class="fa fas fa-file-pdf icon-md"></i> সংযুক্তি
                                    </a>

                                    <!-- Modal-->
                                    <div class="modal fade" id="orderAttachmentModalOld" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title font-weight-bolder font-size-h3"
                                                        id="exampleModalLabel">সংযুক্তি</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <i aria-hidden="true" class="ki ki-close"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <embed src="{{ asset('uploads/order/' . $row->hearing_file) }}"
                                                        type="application/pdf" width="100%" height="400px" />

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                        class="btn btn-light-primary font-weight-bold font-size-h5"
                                                        data-dismiss="modal">বন্ধ করুন</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- /modal -->
                                </td>
                                <td>{{ $row->hearing_comment }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @endif
            <br>
            <br>
            <div id="caseHearingList">
                @include('action/inc_case_details/_single_hearing_data')
            </div>

        </div>

        <!--begin::Row Create SF-->
        <div class="row" id="hearing_add_content" style="display: none;">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom example example-compact">
                    <div>
                        <a href="javascript:void(0)" id="hearing_add_button_close" class="mb-2 btn btn-danger float-right">
                            <i class="fa fas fa-arrow-alt-circle-left"></i> <b>পূর্বে ফিরে যান</b>
                        </a>
                    </div>
                    <!--begin::Form id="hearingSubmit"-->
                    <form method="POST" action="javascript:void(0)" id="ajax-hearing-file-upload"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-5">
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>শুনানির তারিখ <span class="text-danger">*</span></label>
                                                <input type="text" name="hearing_date" id="hearing_date"
                                                    class="form-control form-control-sm common_datepicker"
                                                    placeholder="দিন/মাস/তারিখ" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label>শুনানির প্রতিবেদনের স্ক্যান কপি সংযুক্তি
                                                    <span class="text-danger">*</span></label>
                                                <div></div>
                                                <div class="custom-file">
                                                    <input type="file" name="hearing_report" class="custom-file-input"
                                                        id="customFile" />
                                                    <label class="custom-file-label" for="customFile">ফাইল নির্বাচন
                                                        করুন</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>মন্তব্য <span class="text-danger">*</span></label>
                                            <textarea name="hearing_comment" id="hearing_comment" class="form-control"
                                                rows="5" spellcheck="false"></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="hide_case_id" id="hide_case_id"
                                        value="{{ $info->id }}">
                                    <div class="progress">
                                        <div class="progress-bar"></div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-7">
                                    <button type="submit"
                                        class="btn btn-primary font-weight-bold font-size-h2 px-8 py-3"><i
                                            class="flaticon2-box icon-3x"></i> সংরক্ষণ করুন</button>
                                    <!--
                               <button type="button" id="hearingSubmit" class="btn btn-primary font-weight-bold font-size-h2 px-8 py-3"><i class="flaticon2-box icon-3x"></i> সংরক্ষণ করুন</button> -->
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

    </div>
