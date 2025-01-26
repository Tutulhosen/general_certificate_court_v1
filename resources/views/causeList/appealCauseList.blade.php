@extends('layouts.landing')

@section('content')



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

            <table class="table mb-6 font-size-h5">
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
                        <th scope="col">ক্রমিক নং</th>
                        <th scope="col">মামলা নম্বর</th>
                        <th scope="col">পক্ষ </th>
                        <!-- <th scope="col">অ্যাডভোকেট </th> -->
                        <th scope="col" width="100">পরবর্তী তারিখ</th>
                        <th scope="col">সর্বশেষ আদেশ</th>
                    </tr>
                </thead>
 
                @if (!empty($cose_list))

                    @forelse($cose_list as $key=>$value)
                        <tbody>
                            <tr>
                                <td scope="row" class="text-center">{{ en2bn($key + 1) }}</td>
                                <td class="text-center">{{ en2bn($value['citizen_info']['case_no']) }}</td>
                                <td class="text-center">
                                    {{ isset($value['citizen_info']['applicant_name']) ? $value['citizen_info']['applicant_name'] : '-' }}
                                    <br> <b>vs</b><br>
                                    {{ isset($value['citizen_info']['defaulter_name']) ? $value['citizen_info']['defaulter_name'] : '-' }}
                                </td>

                                @if ($value['citizen_info']['appeal_status'] == 'ON_TRIAL' || $value['citizen_info']['appeal_status'] == 'ON_TRIAL_DM')
                                    @if (date('Y-m-d', strtotime(now())) == $value['citizen_info']['next_date'])
                                        <td class="blink_me text-danger">
                                            <span>*</span>{{ en2bn($value['citizen_info']['next_date']) }}<span>*</span>
                                        </td>
                                    @else
                                        <td>{{ en2bn($value['citizen_info']['next_date']) }}</td>
                                    @endif
                                @else
                                    <td class="text-danger">
                                        {{ appeal_status_bng($value['citizen_info']['appeal_status']) }}</td>
                                @endif
                                @if (isset($value['notes']->manual_decision_name))
                                    <td class="text-center">
                                        {{ $value['notes']->manual_decision_name }}
                                    </td>
                                @else
                                    <td class="text-center">
                                        {{ isset($value['notes']->short_order_name) ? $value['notes']->short_order_name : ' ' }}
                                    </td>
                                @endif
                                {{-- @include('dashboard.citizen._lastorder') --}}
                            </tr>
                        </tbody>

                    @empty
                        <p>কোনো তথ্য খুঁজে পাওয়া যায় নি </p>
                    @endforelse
                @endif
            </table>

            <div class="d-flex justify-content-center">
                {{-- {!! $running_case_paginate->links() !!} --}}
            </div>
        </div>
    </div>
    </div>
    </div>
    @if (empty($cose_list))
        <p class="text-center">কোনো তথ্য খুঁজে পাওয়া যায়নি </p>
        @php $total_page = 0; @endphp
    @else
        <div class="text-center py-5">
            <div class="btn-group" role="group" aria-label="Basic example">

                <?php
                // print_r($running_case_paginate);
                // $total_page = ceil($running_case_paginate / 5);
                $total_page = ceil($running_case_paginate / 7);
             
                ?>
                <button type="button" class="btn  previous btn-outline-primary">Previous</button>
                <?php
                    for ($i=1;$i<=$total_page;$i++){
                    if(!empty($_GET['offset'])&&$i==$_GET['offset']) 
                    {
                        $active ='btn-primary active';
                    }
                    elseif(empty($_GET['offset'])&&$i==1){
                        $active ='btn-primary active';
                    }
                    else {
                        $active ='btn-outline-primary';
                    } 
 

               ?>
                <button type="button" class="btn    paginate <?= $active ?>" data-paginate="<?= $i ?>"
                    id="paginate_id_<?= $i ?>"><?= $i ?></button>
                <?php  
    
                }
                ?>

                <button type="button" class="btn next btn-outline-primary">Next</button>

                <?php
                ?>
            </div>
        </div>
    @endif
    </div>
    <!--end::Card-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var maximum_page ="<?php echo $total_page;?>";
        // alert(maximum_page);

        $('.paginate').on('click', function() {

            //alert($(this).data('paginate'));
            $('.paginate').each(function() {
                $(this).removeClass('btn-primary active');
                $(this).addClass('btn-outline-primary');
            });

            $(this).removeClass('btn-outline-primary');
            $(this).addClass('btn-primary active');

            var page_no = $(this).data('paginate');
            $('#landin_page_causelist_search_form_offset').val(page_no);
            $('#landin_page_causelist_search_form').submit();
        });

        $('.next').on('click', function() {
            var page_no_next = 0;
            $('.paginate').each(function(index, el) {

                if ($(this).hasClass('btn-primary')) {

                    page_no_next = $(this).data('paginate') + 1;

                    if (page_no_next <= maximum_page) {
                        $(this).removeClass('btn-primary active');
                        $(this).addClass('btn-outline-primary');
                    }

                    if (page_no_next <= maximum_page) {

                        $('#landin_page_causelist_search_form_offset').val(page_no_next);
                        $('#landin_page_causelist_search_form').submit();
                    }


                }
            });
            if (page_no_next <= maximum_page) {

                $('#paginate_id_' + page_no_next).removeClass('btn-outline-primary');
                $('#paginate_id_' + page_no_next).addClass('btn-primary active');
            }
        });
        $('.previous').on('click', function() {

            var page_no_previous = 0;

            $('.paginate').each(function(index, el) {


                if ($(this).hasClass('btn-primary')) {

                    page_no_previous = $(this).data('paginate') - 1;

                    if (page_no_previous >= 1) {
                        $(this).removeClass('btn-primary active');
                        $(this).addClass('btn-outline-primary');
                    }
                    if (page_no_previous >= 1) {
                        $('#landin_page_causelist_search_form_offset').val(page_no_previous);
                        $('#landin_page_causelist_search_form').submit();
                    }


                }
            });

            if (page_no_previous >= 1) {
                $('#paginate_id_' + page_no_previous).removeClass('btn-outline-primary');
                $('#paginate_id_' + page_no_previous).addClass('btn-primary active');
            }



        })
    </script>

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
