<?php use Illuminate\Support\Facades\DB; ?>
@extends('layouts.landing')

@section('content')


    {{-- @dd('come') --}}


    <style type="text/css">
        fieldset {
            border: 1px solid #ddd !important;
            margin: 0;
            xmin-width: 0;
            padding: 10px;
            position: relative;
            border-radius: 4px;
            background-color: #d5f7d5;
            padding-left: 10px !important;
        }

        fieldset .form-label {
            color: black;
        }

        legend {
            font-size: 14px;
            font-weight: bold;
            width: 45%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 5px 5px 10px;
            background-color: #5cb85c;
        }
    </style>
    <!--begin::Card-->
    <div class="card card-custom">
        <!-- <div class="card-header flex-wrap py-5">
                                      <div class="card-title">
                                      </div>
                                      
                                   </div> -->
        <div class="card-body overflow-auto">


            <fieldset class="mb-6" style="background-image: url({{ asset('images/causlist.png') }})">
                <!-- <legend >ফিল্টারিং ফিল্ড সমূহ</legend> -->
                @include('causeList.inc.search')
            </fieldset>

            <table class="table mb-6 font-size-h5 caulist-table">
                <thead class="thead-customStyle2 font-size-h6 text-center">
                    <tr>
                        <h1 class="text-center mt-15" style="color: #371c7e; font-weight: 600;">জেনারেল সার্টিফিকেট আদালত
                        </h1>
                        <h2 class="text-center" style="color: #371c7e; font-weight: 600">দৈনিক কার্যতালিকা</h2>
                        @if ($division_name != null)
                            <h5 style="color: #371c7e;" class="text-center">বিভাগঃ {{ $division_name }} </h5>
                        @endif
                        @if ($district_name != null)
                            <h5 style="color: #371c7e;" class="text-center">জেলাঃ {{ $district_name }} </h5>
                        @endif
                        @if ($court_name != null)
                            <h5 style="color: #371c7e;" class="text-center">আদালতঃ {{ $court_name }} </h5>
                        @endif
                        @if ($dateFrom == $dateTo)
                            <h5 style="color: #371c7e;" class="text-center mb-6">তারিখঃ {{ en2bn($dateFrom) }}
                                খ্রিঃ</h5>
                        @else
                            <h3 style="color: #371c7e;" class="text-center mb-6">তারিখঃ {{ en2bn($dateFrom) }}
                                হতে {{ en2bn($dateTo) }} খ্রিঃ</h3>
                        @endif
                    </tr>
                </thead>
                <thead class="thead-customStyle2 font-size-h6 text-center">
                    <tr>
                        <th scope="col" width='10'>ক্রমিক নং</th>
                        <th scope="col" width='100'>মামলা নম্বর</th>
                        <th scope="col" width='100'>পক্ষ</th>
                        <th scope="col" width='100'>পরবর্তী তারিখ</th>
                        <th scope="col" width='100'>সর্বশেষ আদেশ</th>
                    </tr>
                </thead>
                {{-- @@dd(causelistdata) --}}
                <?php
                // echo '<pre>';
                // print_r($coselist);
                
                // echo '<pre>';
                // print_r($coselist);
                ?>
                @if (!empty($causelistdata))
                @foreach ($causelistdata as $key => $item)
                        <?php
                    
                        if ($item->type == 1) {
                            $data = DB::table('gcc_appeal_citizens')
                                ->join('gcc_citizens', 'gcc_citizens.id', 'gcc_appeal_citizens.citizen_id')
                                ->where('gcc_appeal_citizens.appeal_id', $item->appealid)
                                ->whereIn('gcc_appeal_citizens.citizen_type_id', [1, 2])
                                ->select('gcc_appeal_citizens.citizen_type_id', 'gcc_citizens.citizen_name', 'gcc_citizens.id')
                                ->get();
                        
                            $datalist = [
                                'applicant_name' => $data[1]->citizen_name,
                                'defaulter_name' => $data[0]->citizen_name,
                            ];
                            $nodedata = DB::table('gcc_notes_modified')
                                ->join('gcc_case_shortdecisions', 'gcc_notes_modified.case_short_decision_id', 'gcc_case_shortdecisions.id')
                                ->where('gcc_notes_modified.appeal_id', $item->appealid)
                                ->select('gcc_notes_modified.conduct_date as conduct_date', 'gcc_case_shortdecisions.case_short_decision as short_order_name', 'gcc_notes_modified.manual_short_decision as manual_decision_name')
                                ->orderBy('gcc_notes_modified.id', 'desc')
                                ->first();
                        }
                        
                        if ($item->type == 0) {
                            $custom_notes = DB::table('causelist_order')
                                ->where('causelist_id', $item->causelist_id)
                                ->orderby('id', 'desc')
                                ->first();
                        }
                        
                        ?>
                        <tbody>
                            <tr>
                                <td scope="row" class="text-center">{{ en2bn($key + 1) }}</td>
                                <td class="text-center">
                                    @if (isset($item->case_entry_type))
                                    {{-- @dd($item->case_entry_type) --}}
                                        @if ($item->case_entry_type == 'RUNNING')
                                            {{ en2bn($item->caseno) }}/ <br>{{ en2bn($item->manual_case_no) }} <br>
                                            (পুরাতন চলমান মামলা)
                                        @else
                                            {{ en2bn($item->caseno) }} <br> 
                                        @endif
                                    @else
                                        {{ en2bn($item->caseno) }}
                                    @endif

                                </td>
                                @if ($item->type == 1)
                                    <td class="text-center">
                                        {{ isset($datalist['applicant_name']) ? $datalist['applicant_name'] : '-' }}
                                        <br> <b>vs</b><br>
                                        {{ isset($datalist['defaulter_name']) ? $datalist['defaulter_name'] : '-' }}
                                    </td>
                                @else
                                    <td class="text-center">
                                        {{ isset($item->org_representative) ? $item->org_representative : '-' }}
                                        <br> <b>vs</b><br>
                                        {{ isset($item->defaulter_name) ? $item->defaulter_name : '-' }}
                                    </td>
                                @endif
                                @if ($item->type == 1)
                                    @if ($item->appeal_status == 'ON_TRIAL' || $item->appeal_status == 'ON_TRIAL_DM')
                                        @if (date('Y-m-d', strtotime(now())) == $item->next_date)
                                            <td style="text-align: center" class="blink_me text-danger">
                                                <span>*</span>{{ en2bn($item->next_date) }}<span>*</span>
                                            </td>
                                        @else
                                            <td style="text-align: center">{{ en2bn($item->next_date) }}</td>
                                        @endif
                                    @else
                                        <td class="text-danger">
                                            {{ appeal_status_bng($item->appeal_status) }}</td>
                                    @endif
                                @else
                                    {{-- @dd($custom_notes->appeal_status) --}}
                                    @if ($custom_notes !== null && $custom_notes->appeal_status == 'ON_TRIAL')
                                        {{-- @dd($custom_notes) --}}
                                        @if (date('Y-m-d', strtotime(now())) == $custom_notes->next_date)
                                            <td style="text-align: center" class="blink_me text-danger">
                                                <span>*</span>{{ en2bn($custom_notes->next_date) }}<span>*</span>
                                            </td>
                                        @else
                                            <td style="text-align: center">{{ en2bn($custom_notes->next_date) }}</td>
                                        @endif
                                    @else
                                        @if ($custom_notes !== null)
                                            <td class="text-danger text-center fw-bolder"
                                                style="font-size:20px;font-weight: lighter;">
                                                @if ($custom_notes->appeal_status == 'CLOSED')
                                                    {{ '------' }}
                                                @else
                                                    {{ appeal_status_bng($custom_notes->appeal_status) }}
                                                @endif
                                            </td>
                                        @endif
                                    @endif
                                @endif


                                <td class="text-center">
                                    @if ($item->type == 1)
                                        @if ($nodedata->manual_decision_name)
                                            {{ isset($nodedata->manual_decision_name) ? $nodedata->manual_decision_name : '' }}
                                        @else
                                            {{ isset($nodedata->short_order_name) ? $nodedata->short_order_name : ' ' }}
                                        @endif
                                    @else
                                        {{ isset($custom_notes->short_order_name) ? $custom_notes->short_order_name : ' ' }}
                                    @endif

                                </td>
                                {{-- @include('dashboard.citizen._lastorder') --}}
                            </tr>
                        </tbody>
                    @endforeach
                @endif
            </table>


            <div class="d-flex justify-content-center">
                {{ $causelistdata->links() }}
            </div>
        </div>
    </div>
    </div>
    </div>

    </div>
    <!--end::Card-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"git 
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>



@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
    <!-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <!-- <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
                           <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
                         -->


    <!--end::Page Scripts-->
@endsection
