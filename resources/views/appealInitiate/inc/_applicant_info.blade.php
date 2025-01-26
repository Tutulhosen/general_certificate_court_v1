<div role="tabpanel" aria-labelledby="regTab1" class="tab-pane fade" id="regTab_1">
    <div class="panel panel-info radius-none">
        <div style="margin: 10px" id="accordion" role="tablist" aria-multiselectable="true" class="panel-group notesDiv">
            <section class="panel panel-primary applicantInfo" id="applicantInfo">
                <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                    @forelse ($applicantCitizen as $key => $item)
                        @php
                            $count = ++$key;
                        @endphp
                        <div id="cloneApplicant" class="card">
                            <input type="hidden" id="ApplicantCount" value="1">
                            <div class="card-header" id="headingOne3">
                                <div class="card-title h4 {{ $count == 1 ? '' : 'collapsed' }}" data-toggle="collapse"
                                    data-target="#collapseOne3{{ $count }}">
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
                                                    <label for="applicantName_1" class="control-label">আবেদনকারীর
                                                        নাম</label>
                                                    <input name="applicant[name][]" id="applicantName_1"
                                                        class="form-control form-control-sm name-group"
                                                        value="{{ $item->citizen_name ?? '' }}" readonly>
                                                    <input type="hidden" name="applicant[type][]"
                                                        class="form-control form-control-sm" value="1">
                                                    <input type="hidden" name="applicant[id][]" id="applicantId_1"
                                                        class="form-control form-control-sm"
                                                        value="{{ $item->id ?? '' }}">
                                                    <input type="hidden" name="applicant[thana][]"
                                                        id="applicantThana_1" class="form-control form-control-sm"
                                                        value="">
                                                    <input type="hidden" name="applicant[upazilla][]"
                                                        id="applicantUpazilla_1" class="form-control form-control-sm"
                                                        value="">
                                                    <input type="hidden" name="applicant[age][]" id="applicantAge_1"
                                                        class="form-control form-control-sm" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="applicantOrganizationID_1" class="control-label">
                                                        প্রাতিষ্ঠানিক প্রতিনিধির, EmployeeID </label>
                                                    <input name="applicant[organization_employee_id][]"
                                                        id="applicantOrganizationID_1"
                                                        class="form-control form-control-sm name-group"
                                                        value="{{ $item->organization_employee_id ?? '' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                
                                                    <div class="form-group">
                                                        <label for="applicantDesignation_1"
                                                            class="control-label">পদবি</label>
                                                        <input name="applicant[designation][]" id="applicantDesignation_1"
                                                            class="form-control form-control-sm name-group"
                                                            value="{{ $item->designation ?? '' }}" readonly>
                                                    </div>
                                                
                                            </div>
                                          
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="applicantGender_1" class="control-label">লিঙ্গ</label>
                                                    <select style="width: 100%;"
                                                        class="selectDropdown form-control form-control-sm"
                                                        name="applicant[gender][]" id="applicantGender_1">

                                                        <option value="MALE"
                                                            {{ $item->citizen_gender == 'MALE' ? 'selected' : 'disabled' }}>
                                                            পুরুষ</option>
                                                        <option value="FEMALE"
                                                            {{ $item->citizen_gender == 'FEMALE' ? 'selected' : 'disabled' }}>
                                                            নারী</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="applicantFather_1" class="control-label"><span
                                                            style="color:#FF0000"></span>পিতার নাম</label>
                                                    <input name="applicant[father][]" id="applicantFather_1"
                                                        class="form-control form-control-sm"
                                                        value="{{ $item->father ?? '' }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="applicantMother_1" class="control-label"><span
                                                            style="color:#FF0000"></span>মাতার নাম</label>
                                                    <input name="applicant[mother][]" id="applicantMother_1"
                                                        class="form-control form-control-sm"
                                                        value="{{ $item->mother ?? '' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="applicantNid_1" class="control-label"><span
                                                            style="color:#FF0000"></span>জাতীয় পরিচয়
                                                        পত্র</label>
                                                    <input name="applicant[nid][]" id="applicantNid_1"
                                                        class="form-control form-control-sm"
                                                        value="{{ $item->citizen_NID ?? '' }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="applicantPhn_1" class="control-label"><span
                                                            style="color:#FF0000">*
                                                        </span>মোবাইল</label>
                                                    <input name="applicant[phn][]" id="applicantPhn_1"
                                                        class="form-control form-control-sm"
                                                        value="{{ $item->citizen_phone_no ?? '' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="applicantEmail_1"><span style="color:#ff0000d8">*
                                                        </span>ইমেইল</label>
                                                    <input type="email" name="applicant[email][]"
                                                        id="applicantEmail_1" class="form-control form-control-sm"
                                                        value="{{ $item->email ?? '' }}" readonly>
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

        {{-- <div style="text-align: right;margin: 10px;">
                                                    <button type="button" id="RemoveApplicant" class="btn btn-danger">
                                                        বাতিল
                                                    </button>
                                                    <button id="AddApplicant" type="button" class="btn btn-primary">
                                                        আবেদনকারী যোগ করুন
                                                    </button>
                                                </div> --}}
    </div>
</div>
