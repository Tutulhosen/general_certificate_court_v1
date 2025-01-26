<div class="container">
    {{-- $info->is_sf --}}<div class="row">
        <div class="col-md-6">
            <h4 class="font-weight-bolder">সাধারণ তথ্য</h4>
            <table class="tg">
                <tr>
                    <th class="tg-19u4" width="130">আদালতের নাম</th>
                    <td class="tg-nluh">{{ $info->court_name ?? '' }}</td>
                </tr>
                <tr>
                    <th class="tg-19u4">উপজেলা</th>
                    <td class="tg-nluh">{{ $info->upazila_name_bn ?? '' }}</td>
                </tr>
                <tr>
                    <th class="tg-19u4">মৌজা</th>
                    <td class="tg-nluh">{{ $info->mouja_name_bn ?? '' }}</td>
                </tr>
                <tr>
                    <th class="tg-19u4">মামলা নং</th>
                    <td class="tg-nluh">{{ $info->case_number ?? '' }}</td>
                </tr>
                @if (!empty($info->ref_id))
                    <tr>
                        <th class="tg-19u4">পূর্বের মামলা নং</th>
                        <td class="tg-nluh"><a href="{{ route('case.details', $info->ref_id) }}"
                                target="_blank">{{ $info->ref_case_no ?? '' }}</a> </td>
                    </tr>
                @endif
                <tr>
                    <th class="tg-19u4">মামলা রুজুর তারিখ</th>
                    <td class="tg-nluh">{{ en2bn($info->case_date) ?? '' }}</td>
                </tr>
                <tr>
                    <th class="tg-19u4">মামলার বর্তমান অবস্থান</th>
                    <td class="tg-nluh">{{ $info->status_name ?? '' }}, এর জন্য {{ $info->role_name ?? '' }} এর কাছে</td>
                </tr>
                <tr>
                    <th class="tg-19u4">বর্তমান ষ্ট্যাটাস</th>
                    <td class="tg-nluh">
                        @if ($info->status === 1)
                            নতুন চলমান!
                        @elseif ($info->status === 2)
                            আপিল!
                        @elseif ($info->status === 3)
                            সম্পাদিত !
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <h4 class="font-weight-bolder">বাদীর বিবরণ</h4>
            <table class="tg">
                <thead>
                    <tr>
                        <th class="tg-19u4" width="10">ক্রম</th>
                        <th class="tg-19u4 text-center" width="200">নাম</th>
                        <th class="tg-19u4 text-center">পিতা/স্বামীর নাম</th>
                        <th class="tg-19u4 text-center">ঠিকানা</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($info->badis as $key => $badi)
                        <tr>
                            <td class="tg-nluh">{{ en2bn(++$key) }}.</td>
                            <td class="tg-nluh">{{ $badi->name ?? ''}}</td>
                            <td class="tg-nluh">{{ $badi->designation ?? ''}}</td>
                            <td class="tg-nluh">{{ $badi->address ?? '' }}</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>

            <br>
            <h4 class="font-weight-bolder">বিবাদীর বিবরণ</h4>
            <table class="tg">
                <thead>
                    <tr>
                        <th class="tg-19u4" width="10">ক্রম</th>
                        <th class="tg-19u4 text-center" width="200">নাম</th>
                        <th class="tg-19u4 text-center">পিতা/স্বামীর নাম</th>
                        <th class="tg-19u4 text-center">ঠিকানা</th>
                    </tr>
                </thead>
                <tbody>
                    @php $k = 1; @endphp
                    @forelse($info->bibadis as $key => $bibadi)
                        <tr>
                            <td class="tg-nluh">{{ en2bn(++$key) }}.</td>
                            <td class="tg-nluh">{{ $bibadi->name ?? ''}}</td>
                            <td class="tg-nluh">{{ $bibadi->designation ?? ''}}</td>
                            <td class="tg-nluh">{{ $bibadi->address ?? '' }}</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h4 class="font-weight-bolder">জরিপের বিবরণ</h4>
            <table class="tg">
                <thead>
                    <tr>
                        <th class="tg-19u4" width="10">ক্রম</th>
                        <th class="tg-19u4 text-center">জরিপের ধরণ </th>
                        <th class="tg-19u4 text-center">খতিয়ান নং</th>
                        <th class="tg-19u4 text-center">দাগ নং</th>
                        <th class="tg-19u4 text-center">জমির শ্রেণী</th>
                        <th class="tg-19u4" width="150">জমির পরিমাণ (শতক)</th>
                        <th class="tg-19u4" width="170">নালিশী জমির পরিমাণ (শতক)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $k = 1; @endphp
                    {{-- @foreach ($surveys as $survey)
                        <tr>
                            <td class="tg-nluh">{{ en2bn($k) }}.</td>
                            <td class="tg-nluh">{{ $survey->st_name }}</td>
                            <td class="tg-nluh">{{ $survey->khotian_no }}</td>
                            <td class="tg-nluh">{{ $survey->daag_no }}</td>
                            <td class="tg-nluh">{{ $survey->lt_name }}</td>
                            <td class="tg-nluh text-right">{{ $survey->land_size }}</td>
                            <td class="tg-nluh text-right">{{ $survey->land_demand }}</td>
                        </tr>
                        @php $k++; @endphp
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12">
            <h4 class="font-weight-bolder">তফশীল বিবরণ</h4>
            <table class="tg">
                <tr>
                    <td class="tg-nluh font-size-lg font-weight-bold">{{ $info->tafsil ?? '' }}</td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h4 class="font-weight-bolder">চৌহদ্দীর বিবরণ</h4>
            <table class="tg">
                <tr>
                    <td class="tg-nluh font-size-lg font-weight-bold">{{ $info->chowhaddi ?? '' }}</td>
                </tr>
            </table>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12">
            <h4 class="font-weight-bolder">কারণ দর্শাইবার স্ক্যান কপি</h4>

            <?php if($info->notice_file != NULL){ ?>
            <a href="#" class="btn btn-success btn-shadow font-weight-bold font-size-h4" data-toggle="modal"
                data-target="#showCauseModal">
                <i class="fa fas fa-file-pdf icon-md"></i> কারণ দর্শাইবার স্ক্যান কপি
            </a>

            <!-- Modal-->
            <div class="modal fade" id="showCauseModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder font-size-h3" id="exampleModalLabel">কারণ
                                দর্শাইবার
                                স্ক্যান কপি</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <embed src="{{ asset('uploads/show_cause/' . $info->notice_file) }}"
                                type="application/pdf" width="100%" height="400px" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold font-size-h5"
                                data-dismiss="modal">বন্ধ করুন</button>
                        </div>
                    </div>
                </div>
            </div> <!-- /modal -->
            <?php } ?>

        </div>
    </div>
</div>
<!--end::Tab Content-->



