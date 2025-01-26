@extends('layouts.default')
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>
        </div>
        <div class="card-body overflow-auto bg-light">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            <div class="row">
                <div class="col-xl-4">
                    <!--begin::Nav Panel Widget 2-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Wrapper-->
                            <div class="d-flex justify-content-between flex-column pt-4 h-100">
                                <!--begin::Container-->
                                <div class="pb-5">
                                    <div class="pt-1">
                                        <div class="d-flex align-items-center pb-9">
                                            <div class="symbol symbol-45 symbol-light mr-4">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-2x svg-icon-dark-50">
                                                        <i class="text-primary fas fa-file-alt"></i>
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column flex-grow-1">
                                                <a href="#" class="text-dark-75 text-hover-primary mb-1 h4">মামলা
                                                    নম্বর</a>
                                                <span class="text-primary h5">{{ $caseNumber }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center pb-9">
                                            <div class="symbol symbol-45 symbol-light mr-4">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-2x svg-icon-dark-50">
                                                        <i class="text-success fas fa-money-bill-alt"></i>
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column flex-grow-1">
                                                <a href="#" class="text-dark-75 text-hover-primary mb-1 h4">দাবিকৃত
                                                    অর্থের পরিমাণ</a>
                                                <span class="text-success h5">{{ $totalLoanAmount }} .BDT</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center pb-9">
                                            <div class="symbol symbol-45 symbol-light mr-4">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-2x svg-icon-dark-50">
                                                        <i class="text-danger fas fa-money-bill-alt"></i>
                                                    </span>
                                                </span>
                                            </div>


                                            
                                            <div class="d-flex flex-column flex-grow-1">
                                                <a href="#" class="text-dark-75 text-hover-primary mb-1 h4">বকেয়া</a>
                                                <span class="text-danger h5">{{ $totalDueAmount }} .BDT</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Body-->
                                </div>
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Nav Panel Widget 2-->
                </div>
                <div class="col-xl-8">
                    <div class="card card-custom bg-white gutter-b">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bold font-size-h4 text-dark-75">অর্থ আদায় করুন</span>
                            </h3>
                        </div>
                        <div class="card-body pt-1">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="kt_tab_pane_7_2" role="tabpanel"
                                    aria-labelledby="kt_tab_pane_7_2">
                                    <!--begin::Form-->
                                    <form id="paymentForm" action="{{ route('appeal.storeAppealPaymentInfo') }}"
                                        class="form" id="kt_form_7_2" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{ $appealId }}" name="appealId">
                                        <div id="auctionRow" class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control bg-white" name="auctioneerName" placeholder="নিলাম কারীর নাম">
                                                    <input type="hidden" name="isNilam" id="isNilam">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control bg-white" name="auctioneerRecipientName" placeholder="নিলাম গ্রহীতার নাম">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input placeholder="নিলামের তারিখ" class="form-control bg-white" name="auctionDate" type="text" onfocus="(this.type='date')" id="date">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control bg-white" name="auctionSale" placeholder="নিলামে বিক্রিত অর্থ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-6">
                                            <input type="text" class="form-control bg-white" name="installMentPay" placeholder="জমা/কিস্তি">
                                        </div>
                                        <div class="form-group mb-6">
                                            <input placeholder="অর্থ আদায়ের তারিখ" class="form-control bg-white" name="payDate" type="text" onfocus="(this.type='date')" id="date">
                                        </div>
                                        <div class="form-group mb-6">
                                            <input type="text" class="form-control bg-white"
                                                name="payReceipt" placeholder="সূত্র/রশিদ নম্বর">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-6">
                                                    <input type="text"
                                                        class="form-control bg-white"
                                                        name="att_file_caption" placeholder="সংযুক্তি (যদি থাকে)">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-6">
                                                    <div class="custom-file">
                                                        <input type="file" name="att_file"
                                                            class="custom-file-input form-control min-h-50px font-size-lg"
                                                            id="customFile" />
                                                        <label class="custom-file-label" for="customFile">সংযুক্তি </label>
                                                    </div>
                                                    {{-- <input type="file" class="form-control border-0 form-control-solid pl-6 min-h-50px font-size-lg" name="installMentPay" placeholder="সংযুক্তি (যদি থাকে)"> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <input type="button" onclick="myFunction()"
                                                class="btn btn-primary font-weight-bold" value="সংরক্ষণ">
                                        </div>
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Tap pane-->
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-custom bg-white gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="py-2 card-label font-weight-bold font-size-h4 text-dark-75"> সাম্প্রতিক অর্থ
                                    আদায় </span>
                            </h3>
                            <div class="card-toolbar">
                                <ul class="nav nav-pills nav-pills-sm nav-dark">
                                    <li class="nav-item">
                                        <a class="py-2 px-4 btn btn-info" target="_blank" 
                                            href="{{ route('appeal.printCollectPayment', encrypt($caseID)) }}">প্রিন্ট</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-1">
                            <table id="paymentInfoTable" class="table table-condensed table-bordered table-striped margin-0">
                                <thead>
                                    <tr>
                                        <th class="wide-10">ক্রমিক</th>
                                        <th class="wide-10">জমা/কিস্তি </th>
                                        <th class="wide-10">তারিখ</th>
                                        <th class="wide-10">নিলামে বিক্রিত অর্থ</th>
                                        <th class="wide-10">নিলামের তারিখ </th>
                                        <th class="wide-10">নিলাম কারীর নাম</th>
                                        <th class="wide-10">নিলাম গ্রহীতার নাম</th>
                                        <th class="wide-10">সূত্র/রশিদ নম্বর</th>
                                        <th class="wide-10">সংযুক্তি</th>
                                        <th class="wide-10">প্রক্রিয়া</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paymentList as $key => $val)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $val->paid_loan_amount }}</td>
                                        <td>{{ $val->paid_date }}</td>
                                        <td>{{ $val->auctioned_sale }}</td>
                                        <td>{{ $val->auctioned_date }}</td>
                                        <td>{{ $val->auctioneer_name }}</td>
                                        <td>{{ $val->auctioneer_recipient_name }}</td>
                                        <td>{{ $val->receipt_no }}</td>
                                        <td>
                                            @if ($val->att_file_caption == '')
                                                -
                                            @else
                                                <a target="_blank" class="btn btn-success" href="{{ asset($val->att_file) }}">
                                                    <i class="fas fa-eye h6"></i>
                                                    দেখুন
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a onclick="return confirm('Are you sure?')" href="{{ route('appeal.deleteAppealPaymentInfo', encrypt($val->id)) }}" class="btn btn-danger"> মুছুন </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
        </div>
        <script>
            function myFunction() {
                Swal.fire({
                        title: "আপনি কি সংরক্ষণ করতে চান?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "হ্যাঁ",
                        cancelButtonText: "না",
                    })
                    .then(function(result) {
                        if (result.value) {
                            // setTimeout(() => {
                            $('form#paymentForm').submit();
                            // }, 5000);
                            KTApp.blockPage({
                                // overlayColor: '#1bc5bd',
                                overlayColor: 'black',
                                opacity: 0.2,
                                // size: 'sm',
                                message: 'Please wait...',
                                state: 'danger' // a bootstrap color
                            });
                        }
                    });
            }
        </script>
    @endsection
    @section('jsComponent')
        <script src="{{ asset('js/appeal/appealCreate.js') }}"></script>
        <script src="{{ asset('js/appeal/appeal-ui-utils.js') }}"></script>
        <script src="{{ asset('js/initiate/init.js') }}"></script>
        <script src="{{ asset('js/initiate/paymentInfoInit.js') }}"></script>
        <script src="{{ asset('js/englishToBangla/convertEngToBangla.js') }}"></script>
        <script src="{{ asset('js/fileUpload.js') }}"></script>
    @endsection
