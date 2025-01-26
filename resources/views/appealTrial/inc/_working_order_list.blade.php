<fieldset class="mb-8 p-7">
    <legend>কার্যক্রম </legend>
    <div class="panel panel-info" id="appeal_date_time_status_new">

        @include('appealInitiate.inc._cer_asst_initial_comments')

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="form-label">খুঁজুন (আদেশের ধরন)</label>
                        <input type="text" id="search_short_order_important" class="form-control">
                    </div>
                </div>

            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group"><label>আদেশের ধরন</label>
                        <div class="form-control form-control-sm" style="height: 253px; overflow-y: scroll;">
                            @forelse ($shortOrderList as $row)
                                @php
                                    $checked = '';
                                    if (count($notApprovedShortOrderCauseList) > 0) {
                                        foreach ($notApprovedShortOrderCauseList as $key => $value) {
                                            // dd($notApprovedShortOrderCauseList);
                                            if ($value->case_shortdecision_id == $row->id) {
                                                $checked = 'checked';
                                            }
                                        }
                                    }
                                @endphp
                                <label class="radio radio-outline radio-primary mb-3 radio_id_{{ $row->id ?? '' }}">
                                    <input value="{{ $row->id ?? '' }}" type="radio" class="shortOrderCheckBox"
                                        onchange="updateNote(this)" name="shortOrder[]"
                                        id="shortOrder_{{ $row->id ?? '' }}" desc="{{ $row->delails ?? '' }}"
                                        {{ $checked }}>
                                    <span class="mr-2 case_short_decision_data"
                                        data-string="{{ $row->case_short_decision ?? '' }}"
                                        data-row_id_index="{{ $row->id ?? '' }}"></span>
                                    {{ $row->case_short_decision ?? '' }}
                                </label>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group"><label for="note">আদেশ</label>
                        <textarea id="note" name="note" rows="10" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="row" style="padding: 20px 0; display: none" id="manual_short_decision_container">
                <div class="col-md-12">
                    <div class="from-group">
                        <label for="manual_short_decision" class="control-label"><b>মানুয়াল আদেশের ধরন</b></label>
                        <input type="text" name="manual_short_decision" id="manual_short_decision" value=""
                            class="form-control form-control-sm " placeholder="মানুয়াল আদেশ" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" id="warrantExecutorDetails" style="display: none;">
                        <div class="card card-custom mb-5 shadow">
                            <div class="card-header bg-primary-o-50">
                                <div class="card-title">
                                    <h3 class="card-label" id='warrantExecutorHeading'>ওয়ারেন্ট বাস্তবায়নকারীর তথ্য
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('appealTrial.inc._warrentExecutorDetails')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" id="auctionOrderPossessionDetails" style="display: none;">
                        <div class="card card-custom mb-5 shadow">
                            <div class="card-header bg-primary-o-50">
                                <div class="card-title">

                                    <h3 class="card-label">নিলাম দখল অর্পণের কিছু প্রয়োজনীয় তথ্য</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('appealTrial.inc._auction_order_aditional_info')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" id="29_dhara_additional_info" style="display: none;">
                        <div class="card card-custom mb-5 shadow">
                            <div class="card-header bg-primary-o-50">
                                <div class="card-title">

                                    <h3 class="card-label">২৯ ধারার ( গ্রেফতারী পরোয়ানা ) প্রয়োজনীয় তথ্য</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('appealTrial.inc._29_dhara_additional_info')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" id="_zill_sent_addtional_info" style="display: none;">
                        <div class="card card-custom mb-5 shadow">
                            <div class="card-header bg-primary-o-50">
                                <div class="card-title">

                                    <h3 class="card-label">দেনাদারকে সিভিল জেলে সোপর্দ প্রয়োজনীয় তথ্য</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('appealTrial.inc._zill_sent_addtional_info')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" id="_seventh_order_addtional" style="display: none;">
                        <div class="card card-custom mb-5 shadow">
                            <div class="card-header bg-primary-o-50">
                                <div class="card-title">
                                    <h3 class="card-label" id="unique">৭ ধারার নোটিশ জারী কিছু প্রয়োজনীয় তথ্য</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('appealTrial.inc._7_dahara_aditional_info')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" id="_10ka_order_addtional" style="display: none;">
                        <div class="card card-custom mb-5 shadow">
                            <div class="card-header bg-primary-o-50">
                                <div class="card-title">

                                    <h3 class="card-label"> ১০(ক) ধারার নোটিশ জারী কিছু প্রয়োজনীয় তথ্য</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('appealTrial.inc._10ka_dahara_aditional_info')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="appeal_date_time_status">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="offenderGender" class="control-label"> অবস্থা</label>
                        <select name="status" id="status" class=" form-control form-control-sm">
                            @if (globalUserInfo()->role_id == 27)
                                <option value="ON_TRIAL">চলমান</option>
                            @elseif(globalUserInfo()->role_id == 6)
                                <option value="ON_TRIAL_DC">চলমান</option>
                            @elseif(globalUserInfo()->role_id == 34)
                                <option value="ON_TRIAL_DIV_COM">চলমান</option>
                            @elseif(globalUserInfo()->role_id == 25)
                                <option value="ON_TRIAL_LAB_CM">চলমান</option>
                            @endif
                            <!-- <option value="2">মুলতবি</option> -->
                            <option value="CLOSED">নিষ্পতি হয়েছে</option>

                        </select>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="row form-group">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>আদেশের তারিখ</label>

                                <input readonly type="text" name="conductDate" id="conductDate"
                                    value="{{ date('d-m-Y', strtotime(now())) ?? '' }}"
                                    class="form-control form-control-sm " placeholder="দিন/মাস/তারিখ"
                                    autocomplete="off">
                            </div>

                        </div>
                        <div class="col-md-8" id="newnextDatePublish">
                            <div class="row form-group">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>পরবর্তী তারিখ</label>
                                        <input type="text" onchange="updateNoteWithData(this)" name="trialDate"
                                            id="trialDate" class="form-control form-control-sm "
                                            placeholder="দিন/মাস/তারিখ" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="trialTime" class="control-label">সময় </label>
                                    <input class="form-control  form-control-sm" type="time" name="trialTime"
                                        id="trialTime" value="13:45" id="example-time-input">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8" id="neworderPublish" style="display: none;">
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="offenderGender" class="control-label"> সম্পূর্ণ আদেশ
                                            প্রকাশ</label>

                                        <div class="radio"><label>
                                                <input onchange="neworderPublishDate(this)" id="neworderPublishYse"
                                                    type="radio" name="orderPublishDecision" value="1"
                                                    class="orderPublishDecision" checked="checked">
                                                হ্যাঁ</label> <label class="ml-2"><input
                                                    onchange="neworderPublishDate(this)" id="neworderPublishNo"
                                                    type="radio" name="orderPublishDecision" value="0"
                                                    class="orderPublishDecision"> না</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="finalOrderPublishDate" style="display: block;">
                                    <div class="form-group">
                                        <label for="offenderGender" class="control-label"> সম্পূর্ণ আদেশ প্রকাশের
                                            তারিখ</label>

                                        <input type="text" name="finalOrderPublishDate"
                                            id="finalOrderPublishDateNow" class="form-control form-control-sm"
                                            placeholder="দিন/মাস/তারিখ" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>
