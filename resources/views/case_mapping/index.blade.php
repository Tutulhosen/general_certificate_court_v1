@extends('layouts.default')

@section('content')
    <!--begin::Card-->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    আদালত নির্বাচন 
                </h3>
            </di
       <div class="card-body">
        <div class="alert alert-danger" role="alert" id="court_select_alert">
            আদালত নির্বাচন করুন
        </div>
        <form action="" id="case_mapping_form">
            @csrf

            <div class="form-group mb-2 mr-2">
                <select name="court_id" class="form-control" id="court_id">
                    <option value="0">-আদালত নির্বাচন করুন-</option>
                    @foreach ($available_court as $available_courts)
                        <option value="{{ $available_courts->id }}">{{ $available_courts->court_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="upzill_list">
                <table class="table table-hover mb-6 font-size-h6">
                    <thead class="thead-light">
                        <tr>
                            <!-- <th scope="col" width="30">#</th> -->
                            <th scope="col">
                                সিলেক্ট করুণ
                            </th>
                            <th scope="col">উপজেলার নাম</th>

                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($upzillas as $upzilla)
                            <?php
                            ?>
                            <tr>
                                <td>
                                    <div class="checkbox-inline">
                                        <label class="checkbox">
                                            <input type="checkbox" name="upzilla_case_mapping[]"
                                                value="{{ $upzilla->id }}" class="check_upzilla" /><span></span>
                                    </div>
                                </td>
                                <td>{{ $upzilla->upazila_name_bn }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="text-center">

                <button type="submit" class="btn btn-primary">নিশ্চিত করুন</button>
            </div>
        </form>
       </div>
    </div>

    <!--end::Card-->



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('#court_select_alert').hide();


        $('#court_id').on('change', function() {

            swal.showLoading();
            $('.upzill_list').empty();

            var formdata = new FormData();

            $.ajax({
                url: '{{ route('case-mapping.show_court') }}',
                method: 'post',
                data: {
                    id: $('#court_id :selected').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.close();
                        $('.upzill_list').html(response.html);

                    }
                }
            });
        })





        $("#case_mapping_form").on('submit', function(event) {
            event.preventDefault();
            var permission = true;
            if ($('#court_id :selected').val() == 0) {
                permission = false;
                $('#court_select_alert').show();
            }

            if (permission) {

                $('#court_select_alert').hide();

                const fd = new FormData(this);

                // confirm the court //


                $.ajax({
                    url: '{{ route('case-mapping.store') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {

                            Swal.fire(
                                'সফলভাবে সাবমিট করা হয়েছে'
                            )
                        }
                        else
                        {
                            var text= response.upname +'  উপজেলা '+ response.active_court +' অধীনে';
                            Swal.fire(
                                text
                            )
                        }

                    }
                });
            }

        })
    </script>
@endsection


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
