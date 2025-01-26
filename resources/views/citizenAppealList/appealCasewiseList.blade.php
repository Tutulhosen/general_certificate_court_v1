@extends('layouts.citizen.citizen')

@section('content')

    <style>
        .blink {
            animation: blinker 1.5s linear infinite;
            color: red;
            font-family: sans-serif;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>

    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>
            @if (Auth::user()->role_id == 5)
                <div class="card-toolbar">
                    <a href="{{ url('case/add') }}" class="btn btn-sm btn-primary font-weight-bolder">
                        <i class="la la-plus"></i>নতুন মামলা এন্ট্রি
                    </a>
                </div>
            @endif
        </div>
        <div class="card-body overflow-auto">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif

            @include('appeal.search')
            @php
                $trial_date = date('Y-m-d', strtotime(now()));
                $trial_time = date('H:i:s', strtotime(now()));
                $today = date('Y-m-d', strtotime(now()));
                $today_time = date('H:i:s', strtotime(now()));
            @endphp
          
            <table class="table table-hover mb-6 font-size-h5">
                <thead class="thead-light font-size-h6">
                    <tr>
                        <th scope="col" width="30">#</th>
                        <th scope="col">সার্টিফিকেট অবস্থা</th>
                        <th scope="col">মামলা নম্বর</th>
                        <th scope="col">ম্যানুয়াল মামলা নম্বর</th>
                        <th scope="col">আবেদনকারীর নাম</th>
                        <th scope="col">জেনারেল সার্টিফিকেট আদালত</th>
                        <th scope="col" width="70">পদক্ষেপ</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                    
                    $increment_print=1;
                     
                    @endphp

                    @if ($results != null)
                        @foreach ($results as $key => $row)
                            @if (!empty($row))
                                @if ($row->appeal_status == 'CLOSED')
                                    @php
                                        $finalOrderDate = date_create($row->final_order_publish_date);
                                        $today = date_create(date('Y-m-d', strtotime(now())));
                                        $diff = date_diff($finalOrderDate, $today);
                                        $diff2 = date_diff($today, $finalOrderDate);
                                        $difference = $diff->format('%a');
                                        $difference2 = $diff2->format('%a');
                                    @endphp
                                @endif
                                <tr>
                                    @if (globalUserInfo()->role_id != 36)
                                        <td scope="row" class="tg-bn">{{ en2bn($key + $results->firstItem()) }}.</td>
                                    @else
                                        <td scope="row" class="tg-bn">{{ en2bn($increment_print++) }}.</td>
                                    @endif
                                    <td> {{ isset($row->appeal_status) ? appeal_status_bng($row->appeal_status) : '-' }}</td>
                                    {{-- Helper Function for Bangla Status --}}
                                    <td>{{ isset($row->case_no) ? $row->case_no : '-' }}</td>
                                    <td>{{ $row->manual_case_no }}</td>
                                    @if ($row->is_applied_for_review == 0)
                                    <td>
                                         {{-- @dd($row->id); --}}
                                         @php 
                                        $applicant_name=DB::table('gcc_appeal_citizens')
                                         ->join('gcc_citizens','gcc_appeal_citizens.citizen_id','gcc_citizens.id')
                                         ->where('gcc_appeal_citizens.appeal_id',$row->id)
                                         ->where('gcc_appeal_citizens.citizen_type_id',1)
                                         ->select('gcc_citizens.citizen_name')
                                         ->first();
                                         @endphp
                                        {{ $applicant_name->citizen_name }}
                                    </td>
                                @else
                                    <td>{{ $row->reviewerName->name }}</td>
                                @endif
                                    <td>{{ isset($row->court->court_name) ? $row->court->court_name : '-' }}</td>
                                    <td>
                                        <div class="btn-group float-right">
                                            <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle"
                                                type="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">পদক্ষেপ</button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"
                                                    href="{{ route('citizen.appeal.appealView', encrypt($row->id)) }}">বিস্তারিত
                                                    তথ্য</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('citizen.appeal.case-traking', encrypt($row->id)) }}">মামলা
                                                    ট্র্যাকিং</a>

                                                <a class="dropdown-item"
                                                    href="{{ route('citizen.nothiView', encrypt($row->id)) }}">নথি
                                                    দেখুন</a>

                                                    @if ($row->next_date == $today && $row->next_date_trial_time <= $today_time && $row->appeal_status != 'CLOSED' && $row->is_hearing_required == 1)
                                                    <a class="dropdown-item blink"
                                                        href="{{ route('jitsi.meet', ['appeal_id' => encrypt($row->id)]) }}"
                                                        style="color: red;" target="_blank">অনলাইন শুনানি</a>
                                                   @endif
                                                {{-- @if (globalUserInfo()->role_id == 35 && $row->appeal_status == 'ON_TRIAL')
                                                    @if ($row->is_applied_for_karij == 0)
                                                        <a href="#" class="dropdown-item case_modal_loader"
                                                            data-toggle="modal" data-id="{{ $row->id }}">
                                                            খারিজের আবেদন
                                                        </a>
                                                    @elseif($row->is_applied_for_karij == 1)
                                                        <a class="dropdown-item" href="#" style="color: green;">
                                                            খারিজের জন্য আবেদিত
                                                        </a>
                                                    @endif
                                                @endif --}}

                                                @if ($row->appeal_status == 'CLOSED')
                                                    @if (globalUserInfo()->role_id == 36)
                                                        @if ($row->final_order_publish_status == 1 && $difference <= 15 && $row->reviewed_to_lab == 0)
                                                            @if ($row->is_applied_for_review == 0)
                                                                @if ($row->final_order_publish_date <= date('Y-m-d', strtotime(now())))
                                                                    <a href="{{ route('citizen.appeal.review.create', encrypt($row->id)) }}"
                                                                        class="dropdown-item">
                                                                        রিভিউ আবেদন
                                                                    </a>
                                                                @endif
                                                            @elseif($row->is_applied_for_review == 1)
                                                                <a class="dropdown-item" href="#"
                                                                    style="color: green;">
                                                                    রিভিউর জন্য আবেদিত
                                                                </a>
                                                            @elseif($difference2 > 0)
                                                                <a class="dropdown-item" href="#" style="color: red;">
                                                                    রিভিউ আবেদনের সময় হয়নি
                                                                </a>
                                                            @else
                                                                <a class="dropdown-item" href="#" style="color: red;">
                                                                    রিভিউ আবেদনের সময় শেষ
                                                                </a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-danger">কোনো তথ্য খুঁজে পাওয়া যায় নি </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @if (globalUserInfo()->role_id != 36)
                <div class="d-flex justify-content-center">
                    {!! $results->links() !!}
                </div>
            @endif
        </div>
        @if (isset($results))
            <div class="modal fade" id="case_modal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="staticBackdrop" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="ReportForm" method="POST" action="javascript:void(0)">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">মামলা খারিজের আবেদন করুন</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="row mb-5">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>মন্তব্য <span class="text-danger"></span></label>
                                                <textarea required name="kharij_reason" id="kharij_reason" class="form-control" rows="5" spellcheck="false"></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="hide_case_id" id="hidden_id_paste" value="">
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary btn-link" data-dismiss="modal">বন্ধ
                                    করুন </button>
                                <div id="submit" class="bg-dark"></div>
                                <input id="submit" type="button"
                                    onclick="ReportFormSubmit({{ isset($key) ? $key : '' }})" class="btn btn-primary"
                                    value="সংরক্ষণ করুন">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        <!--end::Card-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $('.case_modal_loader').on('click', function() {

                //alert();
                $('#hidden_id_paste').val($(this).data('id'));
                $('#case_modal').modal('show');

            })

            function ReportFormSubmit(id) {
                console.log(id);

                let kharij_reason = $("#kharij_reason").val();
                let hide_case_id = $("#hidden_id_paste").val();
                let _token = $('meta[name="csrf-token"]').attr('content');

                // var formData = new FormData();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('citizen.appeal.kharij_application') }}",
                    data: {
                        kharij_reason: kharij_reason,
                        hide_case_id: hide_case_id,
                        _token: _token
                    },
                    success: (data) => {
                        // form[0].reset();
                        toastr.success(data.success, "Success");
                        console.log(data);
                        // console.log(data.html);
                        // $('.ajax').remove();
                        // $('#legalReportSection').empty();
                        // $('#legalReportSection').append(data.data)
                        // $('#hearing_add_button_close').click()
                        // $("#"+ formId + " #submit").removeClass('spinner spinner-white spinner-right disabled');
                        $('.modal').modal('hide');
                        location.reload();
                        // form[0].reset();
                        // window.history.back();


                    },
                    error: function(data) {
                        console.log(data);
                        // $("#"+ formId + " #submit").removeClass('spinner spinner-white spinner-right disabled');

                    }
                });
            }
        </script>
    @endsection

    {{-- Includable CSS Related Page --}}
    @section('styles')
        <!-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
        <!--end::Page Vendors Styles-->
    @endsection

    {{-- Scripts Section Related Page --}}


    @section('scripts')
    @endsection
