<?php use Illuminate\Support\Facades\DB; ?>
<style type="text/css">
    .blink_me {
        animation: blinker 1s linear infinite;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }

    table,
    td {
        border: 3px solid #f0f9ff;
    }

    td {
        background: #ffffff;
    }
</style>

<div class="card-header flex-wrap py-5">
    <div class="card-title">
        <h3 class="card-title h2 font-weight-bolder">কজ লিস্ট </h3>
    </div>
</div>
<div class="card-body overflow-auto">
    <div class="caulist-tablesdfdfd">

        <table class="table mb-6 font-size-h5">
            <thead class="thead-customStyleCauseList font-size-h6 text-center">
                <tr>
                    <th scope="col" width="10">ক্রমিক নং</th>
                    <th scope="col" width="100">মামলা নম্বর</th>
                    <th scope="col" width="100">পক্ষ </th>
                    <!-- <th scope="col">অ্যাডভোকেট </th> -->
                    <th scope="col" width="100">পরবর্তী তারিখ</th>
                    <th scope="col" width="100">সর্বশেষ আদেশ</th>
                </tr>
            </thead>
            @if (!empty($appeal))
                @forelse($appeal as $key=>$value)
                    <?php
                    if ($value->type == 1) {
                        $data = DB::table('gcc_appeal_citizens')
                            ->join('gcc_citizens', 'gcc_citizens.id', 'gcc_appeal_citizens.citizen_id')
                            ->where('gcc_appeal_citizens.appeal_id', $value->appealid)
                            ->whereIn('gcc_appeal_citizens.citizen_type_id', [1, 2])
                            ->select('gcc_appeal_citizens.citizen_type_id', 'gcc_citizens.citizen_name', 'gcc_citizens.id')
                            ->get();
                    
                        $datalist = [
                            'applicant_name' => $data[1]->citizen_name,
                            'defaulter_name' => $data[0]->citizen_name,
                        ];
                        $nodedata = DB::table('gcc_notes_modified')
                            ->join('gcc_case_shortdecisions', 'gcc_notes_modified.case_short_decision_id', 'gcc_case_shortdecisions.id')
                            ->where('gcc_notes_modified.appeal_id', $value->appealid)
                            ->select('gcc_notes_modified.conduct_date as conduct_date', 'gcc_case_shortdecisions.case_short_decision as short_order_name', 'gcc_notes_modified.manual_short_decision as manual_decision_name')
                            ->orderBy('gcc_notes_modified.id', 'desc')
                            ->first();
                    }
                    
                    if ($value->type == 0) {
                        $custom_notes = DB::table('causelist_order')
                            ->where('causelist_id', $value->causelist_id)
                            ->orderby('id', 'desc')
                            ->first();
                    }
                    ?>
                    <tbody>
                        <tr>
                            <td scope="row" class="text-center">{{ en2bn($key + 1) }}</td>
                            <td class="text-center">
                                @if (isset($value->case_entry_type))
                                {{-- @dd($value->case_entry_type) --}}
                                    @if ($value->case_entry_type == 'RUNNING')
                                        {{ en2bn($value->caseno) }}/ <br>{{ en2bn($value->manual_case_no) }} <br>
                                        (পুরাতন চলমান মামলা)
                                    @else
                                        {{ en2bn($value->caseno) }} <br> 
                                    @endif
                                @else
                                    {{ en2bn($value->caseno) }}
                                @endif
                             

                            </td>
                            @if ($value->type == 1)
                                <td class="text-center">
                                    {{ isset($datalist['applicant_name']) ? $datalist['applicant_name'] : '-' }}
                                    <br> <b>vs</b><br>
                                    {{ isset($datalist['defaulter_name']) ? $datalist['defaulter_name'] : '-' }}
                                </td>
                            @else
                                <td class="text-center">
                                    {{ isset($value->org_representative) ? $value->org_representative : '-' }}
                                    <br> <b>vs</b><br>
                                    {{ isset($value->defaulter_name) ? $value->defaulter_name : '-' }}
                                </td>
                            @endif

                            @if ($value->type == 1)
                                @if ($value->appeal_status == 'ON_TRIAL' || $value->appeal_status == 'ON_TRIAL_DM')
                                    @if (date('Y-m-d', strtotime(now())) == $value->next_date)
                                        <td style="text-align: center;" class="blink_me text-danger">
                                            <span>*</span>{{ en2bn($value->next_date) }}<span>*</span>
                                        </td>
                                    @else
                                        <td style="text-align: center;">{{ en2bn($value->next_date) }}</td>
                                    @endif
                                @else
                                    <td class="text-danger">
                                        {{ appeal_status_bng($value->appeal_status) }}</td>
                                @endif
                            @else
                                @if ($custom_notes != null && $custom_notes->appeal_status == 'ON_TRIAL')
                                    @if (date('Y-m-d', strtotime(now())) == $custom_notes->last_order_date)
                                        <td class="blink_me text-danger">
                                            <span>*</span>{{ en2bn($custom_notes->last_order_date) }}<span>*</span>
                                        </td>
                                    @else
                                        <td>{{ en2bn($custom_notes->last_order_date) }}</td>
                                    @endif
                                @else
                                    @if ($custom_notes != null)
                                        <td class="text-danger">
                                            {{ appeal_status_bng($custom_notes->appeal_status) }}</td>
                                    @endif
                                @endif
                            @endif





                            <td class="text-center">
                                @if ($value->type == 1)
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

                @empty
                    <p>কোনো তথ্য খুঁজে পাওয়া যায় নি </p>
                @endforelse
            @endif
        </table>

    </div>
    <?php $total_page = ceil($running_case_paginate / 10); ?>
    <div class="text-center">
        <div class="btn-group" role="group" aria-label="Basic example">{{ $appeal->links() }}</div>
        {{-- - <div class="btn-group" role="group" aria-label="Basic example">

                <?php
                
                $total_page = ceil($running_case_paginate / 10);
                if($total_page > 0){
                ?>
                    <button type="button" class="btn  previous btn-outline-primary">Previous</button>
                <?php
                }
                for ($i=1;$i<=$total_page;$i++){
                if($i==1) {
                    $active ='btn-primary active';
                }else {
                    $active ='btn-outline-primary';
                }
                ?>
                    <button type="button" class="btn    paginate <?= $active ?>" data-paginate="<?= $i ?>"
                        id="paginate_id_<?= $i ?>"><?= $i ?></button>
                    <?php  
                    
                }
                if($total_page > 0){
                ?>
                <button type="button" class="btn next btn-outline-primary">Next</button>
                <?php
                }
                ?>
            </div> - --}}
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    // $('.previous').hide();
    $('.paginate').on('click', function() {

        //alert($(this).data('paginate'));
        $('.paginate').each(function() {
            $(this).removeClass('btn-primary active');
            $(this).addClass('btn-outline-primary');
        });

        $(this).removeClass('btn-outline-primary');
        $(this).addClass('btn-primary active');

        var page_no = $(this).data('paginate');

        swal.showLoading();

        var formdata = new FormData();

        $.ajax({
            url: '{{ route('paginate.causelist.auth.user') }}',
            method: 'post',
            data: {

                page_no: page_no,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                Swal.close();
                if (response.success == 'error') {
                    Swal.fire({

                        text: response.message,

                    })
                } else if (response.success == 'success') {

                    // Swal.fire({
                    //     icon: 'success',
                    //     text: response.message,

                    // });
                    //alert(response.updatedTrialTime)
                    $('.caulist-table').empty();
                    $('.caulist-table').html(response.html);

                }
            }
        });

        // var maximum_page={{ $total_page }};

        // if($('#paginate_id_'+maximum_page).hasClass('btn-primary'))
        // {
        //     $('.next').hide();
        // }
        // else
        // {
        //     $('.next').show();
        // }
        // if($('#paginate_id_1').hasClass('btn-outline-primary'))
        // {

        //     $('.previous').show();
        // }
        // else
        // {
        //     $('.previous').hide();
        // }
    })

    var maximum_page = {{ $total_page }};



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

                    swal.showLoading();

                    var formdata = new FormData();

                    $.ajax({
                        url: '{{ route('paginate.causelist.auth.user') }}',
                        method: 'post',
                        data: {

                            page_no: page_no_next,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.close();
                            if (response.success == 'error') {
                                Swal.fire({

                                    text: response.message,

                                })
                            } else if (response.success == 'success') {

                                // Swal.fire({
                                //     icon: 'success',
                                //     text: response.message,

                                // });
                                //alert(response.updatedTrialTime)
                                $('.caulist-table').empty();
                                $('.caulist-table').html(response.html);





                            }
                        }
                    });
                }


            }
        });
        if (page_no_next <= maximum_page) {

            $('#paginate_id_' + page_no_next).removeClass('btn-outline-primary');
            $('#paginate_id_' + page_no_next).addClass('btn-primary active');
        }




        // if ($('#paginate_id_' + maximum_page).hasClass('btn-primary')) {
        //     $('.next').hide();
        // } else {
        //     $('.next').show();
        // }
    })


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
                    swal.showLoading();

                    var formdata = new FormData();

                    $.ajax({
                        url: '{{ route('paginate.causelist.auth.user') }}',
                        method: 'post',
                        data: {

                            page_no: page_no_previous,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.close();
                            if (response.success == 'error') {
                                Swal.fire({

                                    text: response.message,

                                })
                            } else if (response.success == 'success') {

                                // Swal.fire({
                                //     icon: 'success',
                                //     text: response.message,

                                // });
                                //alert(response.updatedTrialTime)
                                $('.caulist-table').empty();
                                $('.caulist-table').html(response.html);





                            }
                        }
                    });
                }


            }
        });

        if (page_no_previous >= 1) {
            $('#paginate_id_' + page_no_previous).removeClass('btn-outline-primary');
            $('#paginate_id_' + page_no_previous).addClass('btn-primary active');
        }



        // if ($('#paginate_id_1').hasClass('btn-primary')) {
        //     $('.previous').hide();
        // } else {
        //     $('.previous').show();
        // }

    })
</script>
<!-- <div class="row">
</div> -->
