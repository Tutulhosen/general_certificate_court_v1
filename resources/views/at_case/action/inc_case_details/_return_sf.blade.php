
@if($info->is_sf)
{{-- {{ $numb }} --}}
{{-- {{ random_int(100, 999) }} --}}
    <div id="{{ 'sf_docs'.$numb }}">
        <a href="{{ route('action.pdf_sf', $info->id) }}" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left">
            <i class="fa fas fa-file-pdf"></i>
            <b>জেনারেট পিডিএফ</b>
        </a>
        @if ($info->status != 3)
            <?php if(Auth::user()->role_id == 12 || Auth::user()->role_id == 8 || Auth::user()->role_id == 9 || Auth::user()->role_id == 10 || Auth::user()->role_id == 11){ ?>
            <a href="javascript:void(0)" id="{{ 'sf_edit_button2'.$numb }}" class="btn btn-sm btn-danger font-size-h5 float-right">
                <i class="fa fas fa-edit"></i> <b>সংশোধন করুন</b>
            </a>
            <?php } ?>
        @endif

        <div class="text-center font-weight-bolder font-size-h2">কারণ দর্শাইবার জবাব</div>
        <div class="text-center font-weight-bolder font-size-h3">মোকামঃ
            {{ $info->court_name }}</div>
        <div class="text-center font-weight-bold font-size-h3"><b>বিষয়ঃ</b> দেওয়ানী মোকাদ্দমা নং
            {{ $info->case_number }} এর প্যারাভিত্তিক জবাব প্রেরণ প্রসঙ্গে</div> <br>
        <p class="font-size-h4">
            @php $badi_sl = 1; @endphp
            @foreach ($badis as $badi)
                {{ $badi_sl }}। {{ $badi->badi_name }}, পিতা/স্বামীঃ
                {{ $badi->badi_spouse_name }} <br>
                সাং {{ $badi->badi_address }}
                <br>
                @php $badi_sl++; @endphp
            @endforeach
            ................................................................. বাদী
        </p>

        <div class="font-weight-bolder font-size-h3 mt-5 mb-5">বনাম</div>

        <p class="font-size-h4">
            @php $bibadi_sl = 1; @endphp
            @foreach ($bibadis as $bibadi)
                {{ $bibadi_sl }}। {{ $bibadi->bibadi_name }}, পিতা/স্বামীঃ
                {{ $bibadi->bibadi_spouse_name }} <br>
                সাং {{ $bibadi->bibadi_address }}
                <br>
                @php $bibadi_sl++; @endphp
            @endforeach
            ................................................................. বিবাদী
        </p>

        <p class="font-size-h4 mt-15">
            <?php echo nl2br($sf->sf_details); ?>
        </p>

        <table>
            <tr>
                @foreach ($sf_signatures as $signature)
                    <td width="30%">
                        @if ($signature->signature != null)
                            <img src="{{ asset('uploads/signature/' . $signature->signature) }}"
                                alt="{{ $signature->name }}" height="50">
                        @endif
                        <br><strong>{{ $signature->name }}</strong><br>
                        <span style="font-size:15px;">{{ $signature->role_name }}<br>
                            {{ $signature->office_name_bn }}<br></span>
                    </td>
                @endforeach
            </tr>
        </table>
    </div>
@endif

@if($info->is_sf)
    <!--begin::Row Edit SF-->
    <div class="row" id="sf_edit_content" style="display: none;">
        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <!--begin::Form-->
                <form action="{{ url('action.editsf') }}" class="form" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- <div class="loadersmall"></div> -->
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <fieldset>
                                <legend style="width: 70%;">কারণ দর্শানো নোটিশের প্যারা ভিত্তিক জবাব সংশোধন করুন</legend>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <textarea name="sf_details" id="{{ 'sf_details'.$numb }}" class="form-control" rows="13"
                                            spellcheck="false"><?php echo $sf->sf_details; ?></textarea>
                                    </div>
                                    <input type="hidden" name="hide_case_id" id="hide_case_id"
                                        value="{{ $info->id }}">
                                    <input type="hidden" name="hide_sf_id" id="hide_sf_id"
                                        value="{{ $sf->id }}">
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-md-6">
                            <?php if($info->show_cause_file != NULL){ ?>
                            <embed src="{{ asset('uploads/show_cause/' . $info->show_cause_file) }}"
                                type="application/pdf" width="100%" height="400px" />
                            <?php } ?>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-7">
                                <button type="button" id="{{ 'sfUpdateSubmit'.$numb }}"
                                    class="btn btn-primary font-weight-bold font-size-h2 px-8 py-3"><i
                                        class="flaticon2-box icon-3x"></i> সংরক্ষণ করুন</button>
                                <button type="button" id="{{ 'closesf_edit_button'.$numb }}" class="btn btn-danger ml-2"><i
                                        class="fas fa-times icon-3x"></i></button>

                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Row-->
    @endif

    <script>
    // $(document).ready(function() {
        $('{{ '#sf_edit_button2'.$numb }}').click(function() {
            // alert('minar');
            $('#sf_edit_content').show();
            // $('#sf_docs').hide(1000);
            $('{{ '#sf_docs'.$numb }}').hide(1000);
            // $('#sf_edit_button').hide(1000);
        });

        $('{{ '#closesf_edit_button'.$numb }}').click(function() {
            $('#sf_edit_content').hide(1000);
            $('{{ '#sf_docs'.$numb }}').show(1000);
            // $('#sf_edit_button').hide(1000);
        });

        $('{{ '#sfUpdateSubmit'.$numb }}').click(function(e) {
            // var radioValue = $("input[name='group']:checked").val();
            // alert($('#hide_case_id').val());
            // var id = $('#hide_case_id').val();
            e.preventDefault();

            console.log($('#hide_case_id').val());
            console.log($('#hide_sf_id').val());
            console.log($('{{ '#sf_details'.$numb }}').val());

            $.ajax({
                url: "{{ url('/action/editsf') }}",
                method: 'post',
                data: {
                    case_id: $('#hide_case_id').val(),
                    sf_id: $('#hide_sf_id').val(),
                    sf_details: $('{{ '#sf_details'.$numb }}').val()
                },
                success: function(result) {
                    if (result.errors) {
                        $('.alert-danger').html('');

                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<li>' + value + '</li>');
                        });
                    } else {
                        // result.sfdata
                        $('.alert-danger').hide();
                        $('#sf_edit_content').hide();
                        $('#sfEditSuccess').show();
                        $('{{ '#sf_docs'.$numb }}').hide(1000);
                        $('.ajax').remove();
                        $('#returnSfdetail').append( '<label class="ajax" style="display: block !important;">' + result.html + '</label>');

                    }
                }
            });
        });
    // });

    </script>
