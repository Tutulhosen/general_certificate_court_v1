    
@extends('layouts.default')

@section('content')
    <!--begin::Row-->
    
  
    <style>
        .hide {
            display: none;
        }

        .show {
            display: block;
        }

        .waring-border-field {
            border: 2px solid tomato;
        }

        .warning-message-alert {
            color: red;
        }

        .waring-message-alert-success {
            color: aqua;
        }

        .waring-border-field-succes {
            border: 2px solid aqua;
        }
    </style>
  
    <div class="row">

        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    <div class="card-toolbar">
                        <!-- <div class="example-tools justify-content-center">
                            <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                            <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                        </div> -->
                    </div>
                </div>

                <!-- <div class="loadersmall"></div> -->
                @if ($errors->any())
                    <div class="alert alert-danger text-center">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                 @if(Session::has('Errormassage'))
                 <div class="alert alert-danger text-center">
                    {{ Session::get('Errormassage') }}
                 </div>
                 @endif
                <!--begin::Form-->
                <form id="appealCase" action="" class="form" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="appealId" value="{{ $appeal->id }}">
                    <input type="hidden" name="appealType" value="edit">

                    @if ($appeal->appeal_status == 'SEND_TO_ASST_GCO')
                        <input type="hidden" name="status" id="" value="SEND_TO_GCO">
                    @else
                        <input type="hidden" name="status" id="" value="{{ $appeal->appeal_status }}">
                    @endif
                    
                    <div class="card-body">
                        <div class="row mb-8 ">
                            <div class="col-md-12">
                                <div class="example-preview">
                                    <ul class="nav nav-pills nav-fill">
                                        <li class="nav-item">
                                            <a class="nav-link px-0 active " id="regTab0" data-toggle="tab" href="#regTab_0">
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
                                        @if($appeal->is_nominee_required ==1 )
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
                                        @if($appeal->is_nominee_required == 1)
                                        @include('appealInitiate.inc._nominee_info')
                                        {{-- @dd('come') --}}
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
                        @include('appealInitiate.inc._working_order_list')
                        {{-- @dd('dfasd') --}}
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
                                                <button class="btn bg-success-o-75" type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                            </div>
                                            {{-- <input readonly type="text" class="form-control" value="{{ asset($row->file_path . $row->file_name) }}" /> --}}
                                            <input readonly type="text" class="form-control" value="{{ $row->file_category ?? '' }}" />
                                            <div class="input-group-append">
                                                <a href="{{ asset($row->file_path . $row->file_name) }}" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left">
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
                                    <p class="text-center font-weight-normal font-size-lg">কোনো সংযুক্তি খুঁজে পাওয়া যায়নি</p>
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
                                        data-placement="top" title="" role="button" data-original-title="Add New File">
                                        <div id="addFileRow">
                                            <span class="symbol-label font-weight-bold bg-success">
                                                <i class="text-white fa flaticon2-plus font-size-sm"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Users-->
                            </div>
                            <div class="mt-3 px-5 " id="fileDivLocationReload">
                                <table width="100%" class="border-0 px-5" id="fileDiv" style="border:1px solid #dcd8d8;">
                                    <tr></tr>
                                </table>
                                <input type="hidden" id="other_attachment_count" value="1">
                            </div>
                        </fieldset>
                        <div class="row buttonsDiv">
                            <div class="col-md-12 text-center">
                                <div class="form-group">
                                    <button id="orderPreviewBtn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" disabled onclick="orderPreview()">
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
    
    </div>

    @include('appealInitiate.inc.__modal')
    @include('appealInitiate.inc.__orderPreview')
@endsection

@section('styles')
@endsection

@section('scripts')
    <script src="{{ asset('js/number2banglaWord.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    

    @include('appealInitiate.appealCreateEdit_Js')
@endsection
