<!-- Modal-->
<div class="modal  fade" id="nid_verify_modal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="ReportForm" method="POST" action="javascript:void(0)" id="ajax-hearing-file-upload" enctype="multipart/form-data">
                    @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">জাতীয়পত্র দ্বারা সত্যায়ন করুন অথবা নিচের তথ্য পূরন করুন</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-dark font-weight-bold">
                            <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input required type="text" {{-- id="applicantCiNID_1" --}}
                                class="form-control check_nid_number_0" data-row-index='0'
                                placeholder="উদাহরণ- 19825624603112948" id="nid_checking_smdn"
                                onclick="">
                            <span id="res_applicant_1"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group">
                                <input required type="text" id="dob_checking_smdn"
                                    placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী , বছর/মাস/দিন ) "
                                    {{-- id="dob" --}} class="form-control common_datepicker_1"
                                    autocomplete="off">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="button" id=""
                                class="btn btn-primary check_nid_button"
                                onclick="NIDCHECK()" value=" যাচাই করুন">
                        </div>
                    </div>
                </div>
                <form>
                    
                    <div class="form-group row">
                        <div class="col-lg-12 mb-5">
                            <label> জাতীয় পরিচয় পত্র<span class="text-danger">*</span></label>
                            <input type="text" name="citizen_nid" id="citizen_nid"
                                class="form-control form-control-sm  "  >
                        </div>
                        <div class="col-lg-12 mb-5">
                            <label> নাম <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control form-control-sm  "  >
                        </div>
                        <div class="col-lg-12 mb-5">
                            <label> পিতার নাম <span class="text-danger">*</span></label>
                            <input type="text" name="father" id="father"
                                class="form-control form-control-sm  "  >
                        </div>
                        <div class="col-lg-12 mb-5">
                            <label> মাতার নাম <span class="text-danger">*</span></label>
                            <input type="text" name="mother" id="mother"
                                class="form-control form-control-sm  "  >
                        </div>
                        <div class="col-lg-6 mb-5">
                            <label>জন্ম তারিখ <span class="text-danger">*</span></label>
                            <input type="text" name="dob" id="dob"
                                class="form-control form-control-sm  "  >
                        </div>
                        <div class="col-lg-6 mb-5">
                            <label>লিঙ্গ <span class="text-danger">*</span></label>
                            <select name="citizen_gender" id="citizen_gender"
                                class="form-control form-control-sm  " >
                                <!-- <span id="loading"></span> -->
                                <option value="MALE"> পুরুষ </option>
                                <option value="FEMALE"> নারী </option>
                                
                            </select>
                        </div>
                     
                        <div class="col-lg-12 mb-5">
                            <label>স্থায়ী ঠিকানা<span class="text-danger">*</span></label>
                            <textarea name="permanentAddress" id="permanentAddress" class="form-control form-control-sm   "
                                autocomplete="off" value="" ></textarea>
                        
                        </div>
                        <div class="col-lg-12 mb-5">
                            <label>বর্তমান ঠিকানা<span class="text-danger">*</span></label>
                            <textarea name="presentAddress" id="presentAddress" class="form-control form-control-sm   "
                                autocomplete="off" value="" ></textarea>
                        
    
                        </div>
                    </div>
                </form>
               

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary btn-link confirm_btn_verify_by_nid">সংরক্ষণ করুন</button>
                
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Modal-->

   