@extends('layouts.citizen.citizen')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="py-5">আপনার প্রোফাইলটি জাতীয় পরিচয়পত্র দ্বারা ভেরিফাইড (Verified) নয়, আপনি জাতীয় পরিচয়পত্র দ্বারা ভেরিফাইড (Verified) না
                করলে কোন কার্যক্রমে অংশগ্রহণ করতে পারবেন না</h1>
            <h2>ভেরিফাই (verify) করতে নিচের বাটনে ক্লিক করুন</h2>
            <button class="btn btn-primary nid_verify_account">ভেরিফাই (verify)</button>
        </div>
    </div>
    @include('mobile_first_registration._nid_modal')
@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script>
        $(".common_datepicker_1").datepicker({
            format: 'yyyy/mm/dd'

        });

        $('.nid_verify_account').on('click', function() {
            $('#nid_verify_modal').modal('show');
        })

        function NIDCHECK() {
            //var row_index=$('#'+id).data('row-index');

            var nid_number = $('#nid_checking_smdn').val();
            var dob_number = $('#dob_checking_smdn').val();



            swal.showLoading();

            var formdata = new FormData();

            $.ajax({
                url: '{{ route('new.nid.verify.mobile.reg.first') }}',
                method: 'post',
                data: {
                    nid_number: nid_number,
                    dob_number: dob_number,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.close();
                    if (response.success == 'error') {
                        Swal.fire({
                            text: response.message,

                        })
                        $('.nid_data_pull_warning').prop('readonly', false);
                        $('.nid_data_pull_warning').addClass('nid_data_pull_warning_not_required');
                        $("#dob").datepicker({
                            format: 'yyyy/mm/dd'

                        });
                        $('#citizen_nid').val('');
                        $('#name').val('');
                        $('#father').val('');
                        $('#mother').val('');
                        $('#dob').val('');
                        $('#permanentAddress').val('');
                        $('#presentAddress').val('');

                    } else if (response.success == 'success') {

                        Swal.fire({
                            icon: 'success',
                            text: response.message,

                        });


                        let opposite_gender_lawyer = ' ';

                        if (response.gender == 'MALE') {
                            opposite_gender_lawyer = 'FEMALE';
                        } else {
                            opposite_gender_lawyer = 'MALE';
                        }

                        $("#name").val(response.name_bn);
                        $("#name").prop('readonly', true);

                        $("#citizen_gender").find('option[value="' + response.gender + '"]').attr(
                            'selected', 'selected');
                        $("#citizen_gender").find('option[value="' + opposite_gender_lawyer +
                            '"]').attr('disabled', 'disabled');


                        $("#father").val(response.father);
                        $("#father").prop('readonly', true);

                        $("#mother").val(response.mother);
                        $("#mother").prop('readonly', true);

                        $("#citizen_nid").val(response.national_id);
                        $("#citizen_nid").prop('readonly', true);

                        $("#permanentAddress").val(response.permanent_address);
                        $("#permanentAddress").prop('readonly', true);

                        $("#presentAddress").val(response.present_address);
                        $("#presentAddress").prop('readonly', true);

                        $('#dob').val(response.dob)
                        $("#dob").prop('readonly', true);

                        $('.nid_data_pull_warning').removeClass('nid_data_pull_warning_not_required');
                    }
                }
            });
        }

        $('.nid_data_pull_warning').on('click', function() {

            if (!$(this).hasClass('nid_data_pull_warning_not_required')) {
                Swal.fire(
                    '',
                    'অনুগ্রহ পূর্বক সংশ্লিষ্ট ব্যাক্তির জাতীয় পরিচয়পত্র নম্বর এবং জন্ম তারিখ প্রদান করুন ( ফর্ম এর উপরের দিকে দেখুন )। জাতীয় পরিচয়পত্র থেকে পিতার নাম, মাতার নাম, লিঙ্গ, ঠিকানা পেয়ে যাবেন যা পরিবর্তনযোগ্য নয় । তবে জাতীয় পরিচয়পত্র নম্বর এবং জন্ম তারিখ প্রদান করার পরেও যদি আপনার তথ্য না আসে সেক্ষেত্রে আপনি তথ্য গুলো টাইপ করে দিতে পারবেন',
                    'question'
                )
            }
        });
        $('.confirm_btn_verify_by_nid').on('click', function(event) {
            Swal.fire({
                    title: "আপনি ভুল তথ্য প্রদান করলে আপনার অভিযোগ বাতিল হতে পারে এবং আপনার বিরুদ্ধে আইনগত ব্যবস্থা নেয়া হতে পারে",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "হ্যাঁ",
                    cancelButtonText: "না",
                })
                .then(function(result) {
                    if (result.value) {
                        event.preventDefault();
                        swal.showLoading();

                        var formdata = new FormData();

                        $.ajax({
                            url: '{{ route('verify.account.mobile.reg.first') }}',
                            method: 'post',
                            data: {
                                citizen_nid: $('#citizen_nid').val(),
                                name: $('#name').val(),
                                father: $('#father').val(),
                                mother: $('#mother').val(),
                                dob: $('#dob').val(),
                                citizen_gender: $('#citizen_gender').find(":selected").val(),
                                permanentAddress: $('#permanentAddress').val(),
                                presentAddress: $('#presentAddress').val(),
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.close();
                                if (response.success == 'error') {
                                    Swal.fire({
                                        text: response.message

                                    })
                                } else if (response.success == 'success') {

                                    location.reload();
                                }
                            }
                        });
                    }
                });


        })

        $("#dob").datepicker({
            format: 'yyyy/mm/dd'

        });
    </script>
@endsection
