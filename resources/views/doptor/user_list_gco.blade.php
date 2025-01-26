@extends('layouts.default')

@section('content')
    <!--begin::Card-->
    
    <div class="card">
        
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
               <h2> জেনারেল সার্টিফিকেট আদালতের ইউজার ম্যানেজমেন্ট,  জেনারেল সার্টিফিকেট অফিসার নির্বাচন </h2>
            </div>
            <div class="card-toolbar">        
               <a href="{{ route('doptor.user.management.user_list.segmented.all',['office_id'=>encrypt($office_id)]) }}" class="btn btn-sm btn-primary font-weight-bolder">
                  <i class="la la-plus"></i>সকল দপ্তর ইউজার 
               </a>                
            </div>
         </div>


        <div class="card-body">
            
            <form action="">
                <input type="hidden" name="" id="office_id_hidden" value="{{ $office_id }}">
                <table class="table table-striped table-hover">
                    <thead>

                        <tr>
                            <td>ক্রম</td>

                            <td>নাম</td>
                            <td>পদবী</td>
                            <td>পদবী ইংরেজি</td>
                            <td>আদালত নির্বাচন</td>
                            <td>স্ট্যাটাস</td>
                        </tr>
                    </thead>
                    <tr>
                        @php $increment=1; @endphp
                        @foreach ($list_of_GCO_DC_office as $value)
                    <tr>
                        <input type="hidden" name="" id="office_name_bn_{{ $increment }}"
                            value="{{ $value['office_name_bn'] }}">
                        <input type="hidden" name="" id="office_name_en_{{ $increment }}"
                            value="{{ $value['office_name_en'] }}">
                        <input type="hidden" name="" id="unit_name_bn_{{ $increment }}"
                            value="{{ $value['unit_name_bn'] }}">
                        <input type="hidden" name="" id="unit_name_en_{{ $increment }}"
                            value="{{ $value['unit_name_en'] }}">
                        <input type="hidden" name="" id="designation_bng_{{ $increment }}"
                            value="{{ $value['designation_bng'] }}">
                        <input type="hidden" name="" id="office_id_{{ $increment }}"
                            value="{{ $value['office_id'] }}">
                        <input type="hidden" name="" id="username_{{ $increment }}"
                            value="{{ $value['username'] }}">
                        <input type="hidden" name="" id="employee_name_bng_{{ $increment }}"
                            value="{{ $value['employee_name_bng'] }}">

                        <td>{{ en2bn($increment) }}</td>

                        <td><input type="text" class="form-control" value="{{ $value['employee_name_bng'] }}" readonly>
                        </td>
                        <td><input type="text" class="form-control" value="{{ $value['designation_bng'] }}" readonly>
                        </td>
                        <td><input type="text" class="form-control" value="{{ $value['designation_eng'] }}" readonly>
                        </td>
                        <td><select name="court_select" class="court_select form-control form-control-sm"
                                class="form-control form-control-sm" id="{{ $increment }}">

                                <option value="0">কোন আদালত দেওয়া হয় নাই</option>

                                @foreach ($available_court as $available_court_single)
                                    @php
                                        $selected=' ';
                                        if ($available_court_single->id == $value['court_id']) {
                                            $selected='selected';
                                        }
                                    @endphp
                                    <option value="{{ $available_court_single->id }}" {{ $selected }}>
                                        {{ $available_court_single->court_name }}</option>
                                @endforeach
                            </select></td>
                        <td>
                            @foreach ($available_court as $available_court_single)
                                @if ($available_court_single->id == $value['court_id'])
                                    <button
                                        class="btn-sm btn btn-primary court_name_{{ $increment }}">{{ $available_court_single->court_name }}
                                        এনাবেল</button>
                                @else
                                    <button class="btn-sm btn btn-danger court_name_{{ $increment }}">কোন আদালত দেয়া হয়
                                        নাই ডিজেবেল</button>
                                @endif
                            @endforeach

                        </td>
                    </tr>
                    @php $increment++; @endphp
                    @endforeach
                    </tr>
                </table>
            </form>
            <div>
            </div>
        </div>
    </div>
    <!--end::Card-->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $('.court_select').on('change', function() {


            const id = $(this).attr('id');
            //console.log($('#'+'office_name_bn_'+id).val());

            // alert($(this).data('username'));

            // alert($(this).find('option:selected').val());

            swal.showLoading();

            var formdata = new FormData();

            $.ajax({
                url: '{{ route('doptor.user.management.store.gco.dc') }}',
                method: 'post',
                data: {
                    office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                    office_name_en: $('#' + 'office_name_en_' + id).val(),
                    unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                    unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                    designation_bng: $('#' + 'designation_bng_' + id).val(),
                    office_id: $('#' + 'office_id_' + id).val(),
                    username: $('#' + 'username_' + id).val(),
                    employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                    court_id: $(this).find('option:selected').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.close();
                    if (response.success == 'error') {
                        Swal.fire({
                            icon: 'error',
                            text: response.message,

                        })
                    } else if (response.success == 'success') {

                        Swal.fire({
                            icon: 'success',
                            text: response.message,

                        })
                        if (response.court_name == 'No_court') {
                            $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                            $('.court_name_' + id).removeClass('btn-primary');
                            $('.court_name_' + id).addClass('btn-danger');
                        } else {
                            let texthtml = response.court_name + ' এনাবেল';
                            $('.court_name_' + id).html(texthtml);
                            $('.court_name_' + id).removeClass('btn-danger');
                            $('.court_name_' + id).addClass('btn-primary');
                        }
                    }
                }
            });

        });
    </script>
@endsection


{{-- Includable CSS Related Page --}}
{{-- Includable CSS Related Page --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
    <!--end::Page Scripts-->
@endsection
