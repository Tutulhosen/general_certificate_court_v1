<div class="form-group">
    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                <h4 class="bg-gray-300 card-title h4 py-3 text-center">সার্টিফিকেট সহকারী কর্তৃক গৃহীত ব্যবস্থা, {{ en2bn($certificate_asst_initial_comments['order_date_certificate_asst'] ?? '') }}</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bg-gray-100 rounded-md rounded-right-0">
                                    <div class="p-4 h5">
                                        {!! nl2br($certificate_asst_initial_comments['certificate_asst_order'] ?? '') !!}</div>
                                </div>
                            </div>
                        </div>
                        @if(!empty($certificate_asst_initial_comments['certificate_asst_files']))
                        <div class="row">
                            <fieldset class="col-md-12 border-0 bg-white">
                                @forelse (json_decode($certificate_asst_initial_comments['certificate_asst_files'],true) as $key => $row)
                                    <div class="form-group mb-2"
                                        id="">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn bg-success-o-75"
                                                    type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                            </div>
                                            <input readonly type="text"
                                                class="form-control-md form-control "
                                                value="{{ $row['file_category'] ?? '' }}" />
                                            <div class="input-group-append">
                                                <a href="{{ asset($row['file_path'] . $row['file_name']) }}"
                                                    target="_blank"
                                                    class="btn btn-sm btn-success font-size-h5 float-left">
                                                    <i
                                                        class="fa fas fa-file-pdf"></i>
                                                    <b>দেখুন</b>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </fieldset>
                        </div>
                        @endif

                    </div>
                  
                </div>
            </div>
        </div>
    </div>
</div>