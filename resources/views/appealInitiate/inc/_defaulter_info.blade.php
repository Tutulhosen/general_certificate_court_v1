 <div role="tabpanel" aria-labelledby="regTab2" class="tab-pane fade "
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
                                                                    <input name="defaulter[name]" id="defaulterName_1" class="form-control form-control-sm" value="{{ $defaulterCitizen->citizen_name ?? '' }}" readonly>
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
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->citizen_phone_no ?? ''}}" readonly>
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
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->citizen_NID ?? ''}}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterGender_1"
                                                                        class="control-label">লিঙ্গ</label>
                                                                    <select style="width: 100%;"
                                                                        class="selectDropdown form-control form-control-sm form-control-sm"
                                                                        name="defaulter[gender]" id="defaulterGender_1">
                                                                       
                                                                        <option value="MALE" {{ $defaulterCitizen->citizen_gender == 'MALE' ? 'selected' : 'disabled'}}  >পুরুষ</option>
                                                                        <option value="FEMALE" {{ $defaulterCitizen->citizen_gender == 'FEMALE' ? 'selected' : 'disabled'}}  >নারী</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <input name="defaulter[organization_id]" id="defaulterOrganizationID_1" type="hidden">
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterFather_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>পিতার নাম</label>
                                                                    <input name="defaulter[father]" id="defaulterFather_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->father ?? '' }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterMother_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>মাতার নাম</label>
                                                                    <input name="defaulter[mother]" id="defaulterMother_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->mother ?? '' }}" readonly>
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
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->designation ?? '' }}" readonly>
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
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->organization ?? '' }}" readonly>
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
                                                                        name="defaulter[presentAddress]" rows="5"
                                                                        class="form-control element-block blank"
                                                                        aria-describedby="note-error"
                                                                        aria-invalid="false" readonly>{{ $defaulterCitizen->present_address ?? '-' }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterEmail_1"><span
                                                                            style="color:#FF0000">
                                                                        </span>ইমেইল</label>
                                                                        <input type="email" name="defaulter[email]"
                                                                        id="defaulterEmail_1" class="form-control form-control-sm"
                                                                        value="{{ $defaulterCitizen->email ?? '' }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>