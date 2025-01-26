@if (globalUserInfo()->role_id != 25)
<a href="javascript:void(0)" class="btn btn-info btn-shadow" data-toggle="modal" data-target="#caseForwardModal"
    id="forwardButton">
    <i class="fa fas fa-file-import"></i> প্রেরণ করুন
</a>
@endif

<!-- Modal-->
<div class="modal fade" id="caseForwardModal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title font-weight-bolder font-size-h3" id="exampleModalLabel">মামলা পুনর্বিবেচনার জন্য
                    প্রেরণ করুন
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" style="display:none"></div>

                <form id="caseRivisionForm" class="form" method="GET" action="{{ route('appeal.status_change', encrypt($appeal->id)) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row mb-0">
                        <div class="col-lg-12">
                            <!-- <div class="form-group"> -->
                            <label class="text-primary font-size-h4">
                                প্রাপক নির্বাচন করুন <span class="text-danger">*</span></label>
                            <div class="radio-list">
                                <div class="form-check">
                                    @if(globalUserInfo()->role_id == 6)
                                        <input class="form-check-input" type="radio" name="status" value="SEND_TO_DIV_COM" checked>
                                        <label class="form-check-label" for="appeal_status">
                                            &nbsp;  বিভাগীয় কমিশনার
                                        </label>
                                    @elseif(globalUserInfo()->role_id == 34)
                                        <input class="form-check-input" type="radio" name="status" value="SEND_TO_NBR_CM" checked>
                                        <label class="form-check-label" for="appeal_status">
                                            &nbsp; ভূমি আপিল বোর্ড
                                        </label>
                                    @else
                                        <input class="form-check-input" type="radio" name="status" value="SEND_TO_DC" checked>
                                        <label class="form-check-label" for="appeal_status">
                                            &nbsp; জেলা প্রশাসক
                                        </label>
                                    @endif
                                </div>

                                {{-- @foreach ($roles as $row)
                                @if ($row->id == 5 || $row->id == 6 || $row->id == 7 || $row->id == 8 || $row->id == 9 || $row->id == 10 || $row->id == 11 || $row->id == 12 || $row->id == 13 || $row->id == 14 || $row->id == 15 || $row->id == 16)

                                    @php
                                        if ($row->id == Auth::user()->role_id) {
                                            $disable = 'disabled';
                                            $radio_disable = 'radio-disabled';
                                            $checked = 'checked';
                                        } else {
                                            $disable = '';
                                            $radio_disable = '';
                                            $checked = '';
                                        }
                                    @endphp

                                    @php
                                        if ($row->id == $forward_map->forward_role_id) {
                                            $checked = 'checked';
                                        } else {
                                            $checked = '';
                                        }
                                    @endphp

                                    <label class="radio {{ $radio_disable }}">
                                        <input type="radio" name="group" value="{{ $row->id }}"
                                            {{ $disable }} {{ $checked }} />
                                        <span></span>{{ $row->role_name }}
                                    </label>
                                @endif
                            @endforeach --}}
                            </div>
                            <!-- </div> -->
                        </div>

                        <div class="col-lg-12 mt-3">
                            {{-- <div class="form-group">
                                <label class="text-primary font-size-h4">স্ট্যাটাস নির্বাচন করুন
                                    <span class="text-danger">*</span></label>
                                <select name="status_id" id="status_id" class="form-control form-control-sm">
                                    <option value="">-- নির্বাচন করুন --</option>
                                </select>
                            </div> --}}
                            {{-- <div class="form-group" id="changeRemarks">
                                <label class="text-primary font-size-h4">মন্তব্য প্রদান করুন
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea name="comment" id="comment" class="form-control form-control-solid" rows="4"
                                    style="border: 1px solid #ccc;"></textarea>
                            </div> --}}
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold font-size-h5"
                    data-dismiss="modal">বন্ধ করুন</button>
                <button type="button" id="formSubmit" class="btn btn-primary font-weight-bold font-size-h5"><i class="fa fas fa-file-import"></i> পাঠিয়ে দিন</button>
            </div>
        </div>
    </div>
</div>
