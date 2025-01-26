@extends('layouts.default')

@section('content')
    <!--begin::Row-->
    <div class="row">

        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    <div class="card-toolbar">
                        {{-- @include('appealTrial.inc._send_section') --}}
                    </div>
                </div>

                <!-- <div class="loadersmall"></div> -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('withError'))
                    <div class="alert alert-danger text-center">
                        {{ Session::get('withError') }}
                    </div>
                @endif
                <!--begin::Form-->
                <form id="appealCase" action="" class="form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="appealId" value="{{ $appeal->id }}">
                    <input type="hidden" name="noteId" id="noteId" class="form-control" value="">

                    @if (count($nomineeCitizen) > 0)
                        <input type="hidden" name="is_nominee_attach" id="is_nominee_attach" class="form-control"
                            value="attached_required">
                    @else
                        <input type="hidden" name="is_nominee_attach" id="is_nominee_attach" class="form-control"
                            value="not_attached_not_required">
                    @endif

                    <!-- Added First 3 Short Order by default -->
                    @if ($appeal->appeal_status == 'SEND_TO_GCO')
                        <input value="1" type="hidden" name="defaulter_reg_notification">
                    @else
                        <input value="0" type="hidden" name="defaulter_reg_notification">
                    @endif

                    <div class="card-body">
                        <div class="row mb-8 ">
                            <div class="col-md-12">
                                <div class="example-preview">
                                    <ul class="nav nav-pills nav-fill">
                                        <li class="nav-item">
                                            <a class="nav-link px-0 active " id="regTab0" data-toggle="tab"
                                                href="#regTab_0">
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
                                                                            <a class="nav-link px-0" id="regTab4" data-toggle="tab" href="#regTab_4">
                                                                                <span class="nav-icon">
                                                                                    <i class="flaticon2-chat-1"></i>
                                                                                </span>
                                                                                <span class="nav-text">আইনজীবীর তথ্য</span>
                                                                            </a>
                                                                        </li> -->
                                        @if (count($nomineeCitizen) > 0)
                                            <li class="nav-item">
                                                <a class="nav-link px-0 " id="regTab5" data-toggle="tab" href="#regTab_5">
                                                    <span class="nav-icon">
                                                        <i class="flaticon2-chat-1"></i>
                                                    </span>
                                                    <span class="nav-text">উত্তরাধিকারীর তথ্য</span>
                                                </a>
                                            </li>
                                        @endif

                                    </ul>
                                    <hr>
                                    <div class="tab-content mt-5" id="myTabContent4">

                                        @include('appealInitiate.inc._case_details')

                                        @include('appealInitiate.inc._applicant_info')
                                        @include('appealInitiate.inc._defaulter_info')
                                        @if (count($nomineeCitizen) > 0)
                                            @include('appealTrial.inc._nominee_info')
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        <fieldset class="mb-8 p-7" style="background: none;" id="legalReportSection">
                            @include('appealTrial.inc._legalReportSection')
                        </fieldset>
                        @include('appealInitiate.inc._court_fee')
                        @include('appealInitiate.inc._previous_order_list')
                        @include('appealInitiate.inc._voice_to_text')
                        @include('appealTrial.inc._working_order_list')
                        <fieldset class=" mb-8">
                            <div class="rounded d-flex align-items-center justify-content-between flex-wrap px-5 py-0 mb-2">
                                <div class="d-flex align-items-center mr-2 py-2">
                                    <h3 class="mb-0 mr-8">সংযুক্তি</h3>
                                </div>
                            </div>
                            @forelse ($attachmentList as $key => $row)
                                <div class="form-group mb-2" id="deleteFile{{ $row->id }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn bg-success-o-75"
                                                type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                        </div>
                                        {{-- <input readonly type="text" class="form-control" value="{{ asset($row->file_path . $row->file_name) }}" /> --}}
                                        <input readonly type="text" class="form-control"
                                            value="{{ $row->file_category ?? '' }}" />
                                        <div class="input-group-append">
                                            <a href="{{ asset($row->file_path . $row->file_name) }}" target="_blank"
                                                class="btn btn-sm btn-success font-size-h5 float-left">
                                                <i class="fa fas fa-file-pdf"></i>
                                                <b>দেখুন</b>
                                                {{-- <embed src="{{ asset('uploads/sf_report/'.$data[0]['case_register'][0]['sf_report']) }}" type="application/pdf" width="100%" height="600px" />  --}}
                                            </a>
                                            {{-- <a href="minarkhan.com" class="btn btn-success" type="button">দেখুন </a> --}}
                                        </div>
                                        {{-- <div class="input-group-append">
                                                <a href="javascript:void(0);" id="" onclick="deleteFile({{ $row->id }},{{ $id }} )" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                    <b>মুছুন</b>
                                                </a>
                                            </div> --}}
                                    </div>
                                </div>
                            @empty
                                <div class="pt-5">
                                    <p class="text-center font-weight-normal font-size-lg">কোনো সংযুক্তি খুঁজে পাওয়া যায়নি
                                    </p>
                                </div>
                            @endforelse
                        </fieldset>
                        <fieldset class=" mb-8">
                            <div
                                class="rounded bg-success-o-100 d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
                                <div class="d-flex align-items-center mr-2 py-2">
                                    <h3 class="mb-0 mr-8">সংযুক্তি (যদি থাকে)</h3>
                                </div>
                                <!--end::Info-->
                                <!--begin::Users-->
                                <div class="symbol-group symbol-hover py-2">
                                    <div class="symbol symbol-30 symbol-light-primary" data-toggle="tooltip"
                                        data-placement="top" title="" role="button"
                                        data-original-title="Add New File">
                                        <div id="addFileRow">
                                            <span class="symbol-label font-weight-bold bg-success">
                                                <i class="text-white fa flaticon2-plus font-size-sm"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Users-->
                            </div>
                            <div class="mt-3 px-5">
                                <table width="100%" class="border-0 px-5" id="fileDiv"
                                    style="border:1px solid #dcd8d8;">
                                    <tr></tr>
                                </table>
                                <input type="hidden" id="other_attachment_count" value="1">
                            </div>
                        </fieldset>
                        <div class="row buttonsDiv">
                            <div class="col-md-12 text-center">
                                <div class="form-group">
                                    <button id="orderPreviewBtn" type="button" class="btn btn-primary"
                                        data-toggle="modal" data-target="#exampleModal" disabled
                                        onclick="orderPreview()">
                                        প্রিভিউ ও সংরক্ষণ
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card-body-->
                </form>
            </div>
        </div>
        @include('appealTrial.inc.__modal')
        @include('appealTrial.inc.__orderPreview')
    </div>
@endsection

@section('styles')
@endsection

@section('scripts')
    @include('appealTrial.inc._script')
@endsection
<script>
    function validate(evt) {
        var theEvent = evt || window.event;
        // Handle paste
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
            // Handle key press
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
        // Get the value entered in amount_to_pay_as_remaining
        const remainingAmount = document.getElementById('amount_to_pay_as_remaining').value;
        if (remainingAmount.length > 2) {
            const costingAmount = parseInt(remainingAmount) * 2.5 / 100;
            document.getElementById('amount_to_pay_as_costing').value = costingAmount;

        } else {
            document.getElementById('amount_to_pay_as_costing').value = '';
        }
        const interestRate = document.getElementById('interestRate');
           
        if (interestRate.value) {
            const interestRateAmount = parseInt(remainingAmount) + (parseInt(remainingAmount) * parseFloat(interestRate.value) / 100);
            const newTotalJari = interestRateAmount + parseFloat(document.getElementById('amount_to_pay_as_costing')
                .value);

            document.getElementById('total_jari').value = newTotalJari;
        } else {
            const total_jari= parseFloat(document.getElementById(
                'amount_to_pay_as_costing').value) + parseFloat(remainingAmount);
                document.getElementById('total_jari').value = String(total_jari)
        }      
    }
</script>