<!-- Modal-->
<div class="modal fade" id="exampleModalLong" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="ReportForm" method="POST" action="javascript:void(0)" id="ajax-hearing-file-upload" enctype="multipart/form-data">
                    @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">জারিকারকের রিপোর্ট যুক্ত করুন</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">

                    <div class="row mb-5">
                        <div class="col-md-12">
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label> রিপোর্ট'র তারিখ <span class="text-danger">*</span></label>
                                            <input required type="text" name="report_date" id="report_date"
                                                class="form-control form-control-sm"
                                                placeholder="দিন/মাস/বছর" autocomplete="off" value="{{ date('d/m/Y', strtotime(now())) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>রিপোর্ট'র স্ক্যান কপি সংযুক্তি
                                                <span class="text-danger">*</span></label>
                                            <div></div>
                                            <div class="custom-file">
                                                <input required type="file" name="report_file" class="custom-file-input"
                                                    id="customFile" />
                                                <label class="custom-file-label" for="customFile"> ফাইল নির্বাচন
                                                    করুন</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <label>বিস্তারিত <span class="text-danger">*</span></label>
                                        <textarea required name="report_details" id="report_details" class="form-control"
                                            rows="5" spellcheck="false"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="hide_case_id" id="hide_case_id" value="{{ $appeal->id }}">
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary btn-link" data-dismiss="modal">বন্ধ করুন </button>
                <div id="submit" class="bg-dark"></div>
                <input id="submit" type="button"  onclick="ReportFormSubmit('ReportForm')" class="btn btn-primary" value="সংরক্ষণ করুন">
            </div>
        </form>
        </div>
    </div>
</div>

{{-- <script>
     $('#report_date').datepicker({
            setDate: new Date(),
            format: "dd/mm/yyyy",
            todayHighlight: true,
            orientation: "bottom left"
        });
</script> --}}