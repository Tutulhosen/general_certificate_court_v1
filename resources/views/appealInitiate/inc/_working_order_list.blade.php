<fieldset class="mb-8 p-7">
    <legend>কার্যক্রম </legend>
    <div class="panel panel-info">


        @include('appealInitiate.inc._gco_last_order')

        <div class="panel-body">
            <div hidden="hidden" id="paymentInformation" class="row">
                <div class="col-md-3">
                    <div class="form-group"><label for="totalLoan" class="control-label btn-block">দাবিকৃত অর্থের
                            পরিমাণ</label>
                        <div id="totalLoan" class="text-primary">0 টাকা</div>
                    </div>
                </div>
                <div hidden="hidden" id="auctionBlock" class="col-md-3">
                    <div class="form-group"><label for="auctionSale" class="control-label btn-block">নিলামে বিক্রিত
                            অর্থ</label>
                        <div id="auctionSale" class="text-primary">0 টাকা</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group"><label for="totalPaidAmount" class="control-label btn-block">পরিশোধকৃত
                            অর্থের পরিমাণ</label>
                        <div id="totalPaidAmount" class="text-primary">0 টাকা</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group"><label for="dueAmount" class="control-label btn-block">বকেয়া</label>
                        <div id="dueAmount" class="text-primary">0 টাকা</div> <input type="hidden" value=""
                            id="dueAmountValue">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="form-label">খুঁজুন (গৃহীত ব্যবস্থা / নথি উপস্থাপন)</label>
                        <input type="text" id="search_short_order_important" class="form-control">
                    </div>
                </div>

            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group"><label>গৃহীত ব্যবস্থা / নথি উপস্থাপন</label>
                        <div class="form-control form-control-sm search_on_order"
                            style="height: 253px; overflow-y: scroll;">
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
                    <div class="form-group"><label for="note">আদেশের উপর গৃহীত ব্যবস্থা</label>
                        <textarea id="note" name="note" rows="10" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" id="paymentcollection_form_details" style="display: none;">
                        <div class="card card-custom mb-5 shadow">
                            <div class="card-header bg-primary-o-50">
                                <div class="card-title">

                                    <h3 class="card-label"> অর্থ আদায় এর তথ্য </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('appealInitiate.inc._paymentCollection')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" id="29_dhara_time_apply" style="display: none;">
                        <div class="card card-custom mb-5 shadow">
                            <div class="card-header bg-primary-o-50">
                                <div class="card-title">

                                    <h3 class="card-label"> সংগ্রহের জন্য দিন </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('appealInitiate.inc._29_dhara_time_apply')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($appeal->case_no != 'অসম্পূর্ণ মামলা')
                @include('appealInitiate.inc._citizen_attendence')
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>তারিখ</label>

                        <input readonly type="text" name="conductDate" id="conductDate"
                            value="{{ date('d-m-Y', strtotime(now())) ?? '' }}" class="form-control form-control-sm "
                            placeholder="দিন/মাস/তারিখ" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>
