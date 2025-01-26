                        <div class="row mb-8 " id="CaseDetails">
                            <div class="col-md-12">
                                <div class="example-preview">
                                    <ul class="nav nav-pills nav-fill">
                                        <li class="nav-item">
                                            <a class="nav-link px-0 active" id="regTab0" data-toggle="tab" href="#regTab_0">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">মামলার তথ্য</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link px-0" id="regTab1" data-toggle="tab" href="#regTab_1">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">আবেদনকারীর তথ্য</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link px-0" id="regTab2" data-toggle="tab" href="#regTab_2">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">ঋণগ্রহীতার তথ্য</span>
                                            </a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link px-0" id="regTab3" data-toggle="tab" href="#regTab_3">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">জামানতকারীর তথ্য</span>
                                            </a>
                                        </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link px-0" id="regTab5" data-toggle="tab" href="#regTab_5">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">উত্তরাধিকারীর তথ্য</span>
                                            </a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link px-0" id="regTab6" data-toggle="tab" href="#regTab_6">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">জারিকারকের তথ্য </span>
                                            </a>
                                        </li> -->
                                    </ul>
                                    <hr>
                                    <div class="tab-content mt-5" id="myTabContent4">
                                        <div role="tabpanel" aria-labelledby="regTab0" class="tab-pane fade show active"
                                            id="regTab_0">
                                            <div class="panel panel-info radius-none">
                                                <div class="panel-body">
                                                    <div class="clearfix">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                {{-- <div class="form-group">
                                                                    <label for="caseEntryType" class="control-label"> মামলার ধরন </label>
                                                                    <div class="radio">
                                                                        <label class="mr-5">
                                                                            <input type="radio" id="new" class="caseEntryType mr-2" value="NEW"
                                                                                {{ $appeal->case_entry_type == 'NEW' ? 'checked' : 'disabled' }}
                                                                                name="caseEntryType">নতুন মামলা
                                                                        </label>
                                                                        <label>
                                                                            <input type="radio" id="oldCaseRadio" class="caseEntryType  mr-2"
                                                                                value="OLD" name="caseEntryType"
                                                                                {{ $appeal->case_entry_type == 'OLD' ? 'checked' : 'disabled' }}>পুরাতন মামলা
                                                                        </label>
                                                                    </div>
                                                                </div> --}}
                                                            </div>
                                                            <div class="col-md-6 {{ $appeal->case_entry_type == 'OLD' ? '' : 'd-none' }}" id="prevCaseDiv">
                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <label for="previouscaseNo" class="control-label">পূর্ববর্তী মামলা
                                                                            নম্বর</label>
                                                                        <input type="text" name="previouscaseNo" id="previouscaseNo"
                                                                            class="form-control form-control-sm"
                                                                            value="{{ $appeal->prev_case_no ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="caseNo" class="control-label">মামলা নম্বর</label>
                                                                    <input name="caseNo" id="caseNo" class="form-control form-control-sm"
                                                                        value="{{ $appeal->case_no ?? '' }}" />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>আবেদনের তারিখ  <span class="text-danger">*</span></label>
                                                                    <input type="text" name="caseDate" id="case_date"
                                                                        value="{{ date('d-m-Y', strtotime($appeal->case_date)) ?? '' }}"
                                                                        class="form-control form-control-sm common_datepicker"
                                                                        placeholder="দিন/মাস/তারিখ" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="lawSection" class="control-label">সংশ্লিষ্ট আইন ও ধারা</label>
                                                                    <input name="lawSection" id="lawSection" class="form-control form-control-sm"
                                                                        value="{{ $appeal->law_section ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="totalLoanAmount" class="control-label"><span style="color:#FF0000">*
                                                                        </span>দাবিকৃত অর্থের পরিমাণ</label>
                                                                    <input type="text" name="totalLoanAmount" id="totalLoanAmount"
                                                                        class="form-control form-control-sm" value="{{ en2bn($appeal->loan_amount) ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="totalLoanAmountText" class="control-label">দাবিকৃত অর্থের পরিমাণ
                                                                        (কথায়)</label>
                                                                    <input readonly="readonly" type="text" name="totalLoanAmountText"
                                                                        id="totalLoanAmountText" class="form-control form-control-sm"
                                                                        value="{{ $appeal->loan_amount_text ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(isset($appeal->comment) > 0)
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="comment" class="control-label">সার্টিফিকেট সহকারীর মন্তব্য </label>
                                                                        <textarea readonly="readonly" type="text" name="comment"
                                                                            id="comment" class="form-control form-control-sm"
                                                                            value="{{ $appeal->comment ?? '' }}">{{ $appeal->comment ?? '' }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" aria-labelledby="regTab1" class="tab-pane fade" id="regTab_1">
                                            <div class="panel panel-info radius-none">
                                                <div style="margin: 10px" id="accordion" role="tablist"
                                                    aria-multiselectable="true" class="panel-group notesDiv">
                                                    <section class="panel panel-primary applicantInfo" id="applicantInfo">
                                                        <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                                            @forelse ($applicantCitizen as $key => $item)
                                                                @php
                                                                    $count = ++$key;
                                                                @endphp
                                                                <div id="cloneApplicant" class="card">
                                                                    <input type="hidden" id="ApplicantCount" value="1">
                                                                    <div class="card-header" id="headingOne3">
                                                                        <div class="card-title h4 {{ $count == 1 ? '' : 'collapsed' }}" data-toggle="collapse" data-target="#collapseOne3{{ $count }}">
                                                                            আবেদনকারীর তথ্য &nbsp; <span id="spannCount">({{ $count }})</span>
                                                                        </div>
                                                                    </div>
                                                                    <div id="collapseOne3{{ $count }}" class="collapse {{ $count == 1 ? 'show' : '' }}"
                                                                        data-parent="#accordionExample3">
                                                                        <div class="card-body">
                                                                            <div class="clearfix">
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantName_1"
                                                                                                class="control-label">আবেদনকারীর নাম</label>
                                                                                            <input name="applicant[name][]" id="applicantName_1"
                                                                                                class="form-control form-control-sm name-group" value="{{ $item->citizen_name ?? ''}}">
                                                                                            <input type="hidden" name="applicant[type][]"
                                                                                                class="form-control form-control-sm" value="1">
                                                                                            <input type="hidden" name="applicant[id][]"
                                                                                                id="applicantId_1" class="form-control form-control-sm" value="{{ $item->id ?? ''}}">
                                                                                            <input type="hidden" name="applicant[thana][]"
                                                                                                id="applicantThana_1" class="form-control form-control-sm"
                                                                                                value="">
                                                                                            <input type="hidden" name="applicant[upazilla][]"
                                                                                                id="applicantUpazilla_1" class="form-control form-control-sm"
                                                                                                value="">
                                                                                            <input type="hidden" name="applicant[age][]"
                                                                                                id="applicantAge_1" class="form-control form-control-sm"
                                                                                                value="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantDesignation_1"
                                                                                                class="control-label">পদবি</label>
                                                                                            <input name="applicant[designation][]"
                                                                                                id="applicantDesignation_1"
                                                                                                class="form-control form-control-sm name-group" value="{{ $item->designation ?? ''}}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantOrganization_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000">*
                                                                                                </span> প্রতিষ্ঠানের নাম</label>
                                                                                            <input name="applicant[organization][]"
                                                                                                id="applicantOrganization_1" class="form-control form-control-sm"
                                                                                                value="{{ $item->organization ?? ''}}"
                                                                                                onchange="appealUiUtils.changeInitialNote();">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantType" class="control-label"><span
                                                                                                    style="color:#FF0000">*
                                                                                                </span>প্রতিষ্ঠানের ধরন
                                                                                            </label>
                                                                                            <br>

                                                                                            <select style="width: 100%;"
                                                                                            class="selectDropdown form-control form-control-sm" name="applicant_organization[Type][0]">
                                                                                            
                                                                                            
                                                                                            <option value="BANK"  {{ $appeal->applicant_type == 'BANK' ? 'selected' : 'disabled'}}  >ব্যাংক</option>
                                                                                            <option value="GOVERNMENT" {{ $appeal->applicant_type == 'GOVERNMENT' ? 'selected' : 'disabled'}} >সরকারি প্রতিষ্ঠান</option>
                                                                                            <option value="OTHER_COMPANY" {{ $appeal->applicant_type == 'OTHER_COMPANY' ? 'selected' : 'disabled'}} >স্বায়ত্তশাসিত প্রতিষ্ঠান</option>
                                                                                            </select>
                                                                                     
                                                                                            
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantGender_1"
                                                                                                class="control-label">লিঙ্গ</label>
                                                                                            <select style="width: 100%;"
                                                                                                class="selectDropdown form-control form-control-sm"
                                                                                                name="applicant[gender][]" id="applicantGender_1">
                                                                                                <option value="">বাছাই করুন</option>
                                                                                                <option value="MALE"  {{ $item->citizen_gender == 'MALE' ? 'selected' : ''}}>পুরুষ</option>
                                                                                                <option value="FEMALE" {{ $item->citizen_gender == 'FEMALE' ? 'selected' : ''}}>নারী</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantFather_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>পিতার নাম</label>
                                                                                            <input name="applicant[father][]"
                                                                                                id="applicantFather_1" class="form-control form-control-sm"
                                                                                                value="{{ $item->father?? '' }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantMother_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>মাতার নাম</label>
                                                                                            <input name="applicant[mother][]"
                                                                                                id="applicantMother_1" class="form-control form-control-sm"
                                                                                                value="{{ $item->mother?? '' }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantNid_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>জাতীয় পরিচয়
                                                                                                পত্র</label>
                                                                                            <input name="applicant[nid][]" id="applicantNid_1" class="form-control form-control-sm" value="{{ $item->citizen_NID?? '' }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantPhn_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000">*
                                                                                                </span>মোবাইল</label>
                                                                                            <input name="applicant[phn][]" id="applicantPhn_1"
                                                                                                class="form-control form-control-sm" value="{{ $item->citizen_phone_no?? '' }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantPresentAddree_1"><span
                                                                                                    style="color:#FF0000">*
                                                                                                </span>প্রতিষ্ঠানের ঠিকানা</label>
                                                                                            <textarea id="applicantPresentAddree_1"
                                                                                                name="applicant[presentAddress][]" rows="5"
                                                                                                class="form-control element-block blank"
                                                                                                aria-describedby="note-error"
                                                                                                aria-invalid="false">{{ $item->present_address ?? '' }}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantEmail_1"><span
                                                                                                    style="color:#ff0000d8">*
                                                                                                </span>ইমেইল</label>
                                                                                                <input type="email" name="applicant[email][]"
                                                                                                id="applicantEmail_1" class="form-control form-control-sm"
                                                                                                value="{{ $item->email ?? '' }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" aria-labelledby="regTab2" class="tab-pane fade"
                                            id="regTab_2">
                                            <div class="panel panel-info radius-none">
                                                {{-- <div class="panel-heading radius-none"> --}}
                                                {{-- <h4 class="panel-title">@lang('message.defaulterBlockHeading')</h4> --}}
                                                {{-- </div> --}}
                                                <div class="panel-body">
                                                    <div class="clearfix">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterName_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000">*
                                                                        </span>ঋণগ্রহীতার নাম</label>
                                                                    <input name="defaulter[name]" id="defaulterName_1" class="form-control form-control-sm" value="{{ $defaulterCitizen->citizen_name ?? '' }}">
                                                                    <input type="hidden" name="defaulter[type]"
                                                                        class="form-control form-control-sm" value="2">
                                                                    <input type="hidden" name="defaulter[id]"
                                                                        id="defaulterId_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->id ?? '' }}">
                                                                    <input type="hidden" name="defaulter[email]"
                                                                        id="defaulterEmail_1"
                                                                        class="form-control form-control-sm" value="">
                                                                    <input type="hidden" name="defaulter[thana]"
                                                                        id="defaulterThana_1"
                                                                        class="form-control form-control-sm" value="">
                                                                    <input type="hidden" name="defaulter[upazilla]"
                                                                        id="defaulterUpazilla_1"
                                                                        class="form-control form-control-sm" value="">
                                                                    <input type="hidden" name="defaulter[age]"
                                                                        id="defaulterAge_1"
                                                                        class="form-control form-control-sm" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterPhn_1"
                                                                        class="control-label">মোবাইল</label>
                                                                    <input name="defaulter[phn]" id="defaulterPhn_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->citizen_phone_no ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterNid_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>জাতীয় পরিচয়
                                                                        পত্র</label>
                                                                    <input name="defaulter[nid]" id="defaulterNid_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->citizen_NID }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterGender_1"
                                                                        class="control-label">লিঙ্গ</label>
                                                                    <select style="width: 100%;"
                                                                        class="selectDropdown form-control form-control-sm form-control-sm"
                                                                        name="defaulter[gender]" id="defaulterGender_1">
                                                                        <option value="">বাছাই করুন</option>
                                                                        <option value="MALE" {{ $defaulterCitizen->citizen_gender == 'MALE' ? 'selected' : ''}}>পুরুষ</option>
                                                                        <option value="FEMALE" {{ $defaulterCitizen->citizen_gender == 'FEMALE' ? 'selected' : ''}}>নারী</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterFather_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>পিতার নাম</label>
                                                                    <input name="defaulter[father]" id="defaulterFather_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->father }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterMother_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>মাতার নাম</label>
                                                                    <input name="defaulter[mother]" id="defaulterMother_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->mother }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterDesignation_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000">*
                                                                        </span>পদবি / পেশা</label>
                                                                    <input name="defaulter[designation]"
                                                                        id="defaulterDesignation_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->designation }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterOrganization_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>প্রতিষ্ঠানের
                                                                        নাম</label>
                                                                    <input name="defaulter[organization]"
                                                                        id="defaulterOrganization_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->organization }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterPresentAddree_1"><span
                                                                            style="color:#FF0000">*
                                                                        </span>ঠিকানা</label>
                                                                    <textarea id="defaulterPresentAddree_1"
                                                                        name="defaulter[presentAddress]" rows ="5"
                                                                        class="form-control element-block blank"
                                                                        aria-describedby="note-error"
                                                                        aria-invalid="false">{{ $defaulterCitizen->present_address ?? '-' }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterEmail_1"><span
                                                                            style="color:#FF0000">*
                                                                        </span>ইমেইল</label>
                                                                        <input type="email" name="defaulter[email]"
                                                                        id="defaulterEmail_1" class="form-control form-control-sm"
                                                                        value="{{ $defaulterCitizen->email ?? '-' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->
                                        
                                        <div role="tabpanel" aria-labelledby="regTab5" class="tab-pane fade"
                                            id="regTab_5">
                                            <div class="panel panel-info radius-none ">

                                                {{-- <div class="panel-heading radius-none"> --}}
                                                {{-- <h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4> --}}
                                                {{-- </div> --}}
                                                <div style="margin: 10px" id="accordion" role="tablist"
                                                    aria-multiselectable="true" class="panel-group notesDiv">
                                                    <section class="panel panel-primary nomineeInfo" id="nomineeInfo">
                                                        <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                                            <input type="hidden" id="NomineeCount" value="{{ count($nomineeCitizen) }}">
                                                            @forelse ($nomineeCitizen as $key => $item)
                                                                @php
                                                                    $count = ++$key;
                                                                @endphp
                                                                <div id="cloneNomenee" class="card">
                                                                    <div class="card-header" id="headingOne3">
                                                                        <div class="card-title h4 {{ $count == 1 ? '' : 'collapsed' }}" data-toggle="collapse"
                                                                            data-target="#collapseOne3{{ $count }}">
                                                                            উত্তরাধিকারীর তথ্য &nbsp; <span id="spannCount">({{ $count }})</span>
                                                                        </div>
                                                                    </div>
                                                                    <div id="collapseOne3{{ $count }}" class="collapse {{ $count == 1 ? 'show' : '' }} "
                                                                        data-parent="#accordionExample3">
                                                                        <div class="card-body">
                                                                            <div class="clearfix">
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nomineeName_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>উত্তরাধিকারীর
                                                                                                নাম</label>
                                                                                            <input name="nominee[name][]"
                                                                                                id="nomineeName_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->citizen_name }}">
                                                                                            <input type="hidden"
                                                                                                name="nominee[type][]"
                                                                                                class="form-control form-control-sm"
                                                                                                value="5">
                                                                                            <input type="hidden"
                                                                                                name="nominee[id][]"
                                                                                                id="nomineeId_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->id }}">
                                                                                            <input type="hidden"
                                                                                                name="nominee[email][]"
                                                                                                id="nomineeEmail_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="">
                                                                                            <input type="hidden"
                                                                                                name="nominee[thana][]"
                                                                                                id="nomineeThana_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="">
                                                                                            <input type="hidden"
                                                                                                name="nominee[upazilla][]"
                                                                                                id="nomineeUpazilla_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="">
                                                                                            <input type="hidden"
                                                                                                name="nominee[designation][]"
                                                                                                id="nomineeDesignation_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="">
                                                                                            <input type="hidden"
                                                                                                name="nominee[organization][]"
                                                                                                id="nomineeOrganization_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nomineePhn_1"
                                                                                                class="control-label">মোবাইল</label>
                                                                                            <input name="nominee[phn][]"
                                                                                                id="nomineePhn_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->citizen_phone_no }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nomineeNid_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>জাতীয়
                                                                                                পরিচয় পত্র</label>
                                                                                            <input name="nominee[nid][]"
                                                                                                id="nomineeNid_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->citizen_NID }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nomineeGender_1"
                                                                                                class="control-label">নারী /
                                                                                                পুরুষ</label>
                                                                                            <select style="width: 100%;"
                                                                                                class="selectDropdown form-control form-control-sm"
                                                                                                name="nominee[gender][]"
                                                                                                id="nomineeGender_1">
                                                                                                <option value="">
                                                                                                    বাছাই করুন</option>
                                                                                                <option value="MALE" {{ $item->citizen_gender == 'MALE' ? 'selected' : 'disabled' }}> পুরুষ</option>
                                                                                                <option value="FEMALE" {{ $item->citizen_gender == 'FEMALE' ? 'selected' : 'disabled' }}> নারী</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nomineeFather_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>পিতার
                                                                                                নাম</label>
                                                                                            <input name="nominee[father][]"
                                                                                                id="nomineeFather_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->father }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nomineeMother_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>মাতার
                                                                                                নাম</label>
                                                                                            <input name="nominee[mother][]"
                                                                                                id="nomineeMother_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->mother }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nomineeAge_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>বয়স</label>
                                                                                            <input name="nominee[age][]"
                                                                                                id="nomineeAge_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->age }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="nomineePresentAddree_1">ঠিকানা</label>
                                                                                            <textarea
                                                                                                id="nomineePresentAddree_1"
                                                                                                name="nominee[presentAddress][]"
                                                                                                rows="3"
                                                                                                class="form-control form-control-sm element-block blank"
                                                                                                aria-describedby="note-error"
                                                                                                aria-invalid="false">{{ $item->present_address }}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                            <div class="card">
                                                                <p class="h5 text-center mt-3"> 
                                                                 তথ্য খুঁজে পাওয়া যায়নি... 
                                                                </p>
                                                            </div>
                                                            @endforelse


                                                        </div>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div role="tabpanel" aria-labelledby="regTab6" class="tab-pane fade"
                                            id="regTab_6">
                                            <div class="panel panel-info radius-none ">
                                                {{-- <div class="panel-heading radius-none"> --}}
                                                {{-- <h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4> --}}
                                                {{-- </div> --}}
                                                <div class="panel-body">
                                                    <div class="clearfix">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawyerName_1" class="control-label"><span
                                                                            style="color:#FF0000"></span>জারিকারকের নাম</label>
                                                                    <input name="issuer[name]" id="issuerName_1"
                                                                        class="form-control form-control-sm" value="{{ $issuerCitizen->citizen_name ?? '' }}">
                                                                    <input type="hidden" name="issuer[type]"
                                                                        class="form-control form-control-sm" value="7">
                                                                    <input type="hidden" name="issuer[id]"
                                                                        id="issuerId_1" class="form-control form-control-sm" value="{{ $issuerCitizen->id ?? '' }}">
                                                                    <input type="hidden"
                                                                        name="issuer[thana]"
                                                                        id="issuerThana_1"
                                                                        class="form-control form-control-sm"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="issuer[upazilla]"
                                                                        id="issuerUpazilla_1"
                                                                        class="form-control form-control-sm"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="issuer[designation]"
                                                                        id="issuerDesignation_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $issuerCitizen->designation ?? '' }}">
                                                                    <input type="hidden" name="issuer[organization]"
                                                                        id="issuerOrganization_1" class="form-control form-control-sm"
                                                                        value="">
                                                                    <input type="hidden" name="issuer[age]"
                                                                        id="issuerAge_1" class="form-control form-control-sm" value="">
                                                                    <input type="hidden" name="issuer[mother]"
                                                                        id="issuerMother_1" class="form-control form-control-sm"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="issuer[presentAddress]"
                                                                        id="issuerPresentAddree_1" class="form-control form-control-sm"
                                                                        value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="issuerFather_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>পিতার নাম</label>
                                                                    <input name="issuer[father]" id="issuerFather_1"
                                                                        class="form-control form-control-sm" value="{{ $issuerCitizen->father ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="issuerNid_1" class="control-label"><span
                                                                            style="color:#FF0000"></span>জাতীয় পরিচয়
                                                                        পত্র</label>
                                                                    <input name="issuer[nid]" id="issuerNid_1"
                                                                        class="form-control form-control-sm" value="{{ $issuerCitizen->nid ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="issuerGender_1" class="control-label">নারী
                                                                        / পুরুষ</label>
                                                                    <select style="width: 100%;"
                                                                        class="selectDropdown form-control"
                                                                        name="issuer[gender]" id="issuerGender_1">
                                                                        <option value="">বাছাই করুন</option>
                                                                        <option {{ isset($issuerCitizen->citizen_gender) == 'MALE' ? 'selected' : '' }} value="MALE">পুরুষ</option>
                                                                        <option {{ isset($issuerCitizen->citizen_gender) == 'FEMALE' ? 'selected' : '' }} value="FEMALE">নারী</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="issuerPhn_1"
                                                                        class="control-label">মোবাইল</label>
                                                                    <input name="issuer[phn]" id="issuerPhn_1"
                                                                        class="form-control form-control-sm" value="{{ $issuerCitizen->citizen_phone_no ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="issuerEmail_1"><span
                                                                            style="color:#FF0000">*
                                                                        </span>ইমেইল</label>
                                                                        <input type="email" name="issuer[email]" id="issuerEmail_1" class="form-control form-control-sm" value="{{ $issuerCitizen->email ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="issuerPresentAddree_1">ঠিকানা</label>
                                                                    <textarea
                                                                        id="issuerPresentAddree_1"
                                                                        name="issuer[presentAddress]"
                                                                        rows ="5"
                                                                        class="form-control form-control-sm element-block blank"
                                                                        aria-describedby="note-error"
                                                                        aria-invalid="false">{{ $issuerCitizen->present_address ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
