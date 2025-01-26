<script>
    // ========== Form Submission ========= Start =========



    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    function isPhone(phone) {
        var regex = /(^(\+8801|8801|01|008801))[1|3-9]{1}(\d){8}$/;
        return regex.test(phone);
    }

    function myFunction() {

        let permission = true;
        if ($('#nomineeNid_1').val() != "") {
            $('.validation').each(function() {

                if ($(this).val() == '') {
                    $(this).addClass('waring-border-field');
                    $(this).next('.required_message').removeClass('hide');
                    $(this).next('.required_message').addClass('show warning-message-alert');
                    permission = false;
                } else {
                    $(this).removeClass('waring-border-field');
                    $(this).next('.required_message').addClass('hide');
                    $(this).next('.required_message').removeClass('show warning-message-alert');
                }


                $(this).on('keyup', function() {
                    if ($(this).val() == '') {
                        $(this).addClass('waring-border-field');
                        $(this).next('.required_message').removeClass('hide');
                        $(this).next('.required_message').addClass(
                            'show warning-message-alert');
                        permission = false;
                    } else if ($(this).hasClass("email")) {
                        if (!isEmail($(this).val())) {
                            permission = false;
                            $(this).addClass('waring-border-field');
                            $(this).next('.required_message').removeClass('hide');
                            $(this).next('.required_message').addClass(
                                'show warning-message-alert');
                            $(this).next('.required_message').text(
                                'Invalid Email Address');
                        } else {
                            $(this).removeClass('waring-border-field');
                            $(this).next('.required_message').addClass('hide');
                            $(this).next('.required_message').removeClass(
                                'show warning-message-alert');

                        }
                    } else if ($(this).hasClass("phone")) {
                        if (!isPhone($(this).val())) {
                            permission = false;
                            $(this).addClass('waring-border-field');
                            $(this).next('.required_message').removeClass('hide');
                            $(this).next('.required_message').addClass(
                                'show warning-message-alert');
                            $(this).next('.required_message').text(
                                'Invalid phone number');
                        } else {
                            $(this).removeClass('waring-border-field');
                            $(this).next('.required_message').addClass('hide');
                            $(this).next('.required_message').removeClass(
                                'show warning-message-alert');

                        }
                    } else {
                        $(this).removeClass('waring-border-field');
                        $(this).next('.required_message').addClass('hide');
                        $(this).next('.required_message').removeClass(
                            'show warning-message-alert');
                    }
                })



            });
        }

        if (permission) {
            $('form#appealCase').submit();
        } else {
            Swal.fire('উত্তরাধিকারীর তথ্যগুলো সঠিকভাবে প্রদান করুন')
        }





        // var textX = $('#button_text_submit').val();
        // if (typeof textX !== 'undefined') {

        //     var button_text_submit = "আপনি কি " + textX + "  করতে চান?";
        // } else {
        //     var button_text_submit = "আপনি কি সংরক্ষণ  করতে চান?";
        // }

        // Swal.fire({
        //         title: button_text_submit,
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonText: "হ্যাঁ",
        //         cancelButtonText: "না",
        //     })
        //     .then(function(result) {
        //         if (result.value) {




        //         }
        //     });
    }

    function formSubmit() {

        // $('#status').val('SEND_TO_GCO');
        myFunction();
    }
    // ========== Form Submission ========= End =========

    // ========== New Case or Old ========= Start =========
    $('input[type=radio][name=caseEntryType]').change(function() {
        if (this.value == 'NEW') {
            $("#prevCaseDiv").addClass("d-none");
        } else {
            $("#prevCaseDiv").removeClass("d-none");
        }
    });
    // ==============New Case or Old ========= end =========

    // ================Activities ========= Start =========
    function primaryNote() {
        var organaization = $('#applicantOrganization_1').val() ? $('#applicantOrganization_1').val() :
            "প্রতিষ্ঠানের নাম ";
        var case_date = $('#case_date').val() ? $('#case_date').val() : ' তারিখ ';
        case_date = NumToBangla.replaceNumbers(case_date);
        var defaulterName = $('#defaulterName_1').val() ? $('#defaulterName_1').val() : ' খাতকের নাম ';
        var totalLoanAmount = $('#totalLoanAmount').val() ? $('#totalLoanAmount').val() : '  টাকার পরিমাণ ';
        totalLoanAmount = NumToBangla.replaceNumbers(totalLoanAmount);
        var totalLoanAmountText = $('#totalLoanAmountText').val() ? $('#totalLoanAmountText').val() : '';
        var lawSection = $('#lawSection').val() ? $('#lawSection').val() : ' সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫ ধারা ';
        var GenActivitiesDefault = organaization + " হতে " + case_date + " তারিখে " + defaulterName + " এর নিকট হতে " +
            totalLoanAmount + " (" + totalLoanAmountText + ") টাকা আদায়ের জন্য " + lawSection +
            " মতে একটি অনুরোধপত্র পাওয়া গিয়েছে। \n\nদেখলাম। দাবী আদায়যোগ্য বিবেচিত হওয়ায় ১০ নং রেজিস্টার বহিতে লিপিবদ্ধ করে সার্টিফিকেট রিকুইজিশনে স্বাক্ষর করা হল। সার্টিফিকেট খাতকের প্রতি ১০(ক) ধারার নোটিশ জারি করা হোক। আগামি (০১ মাসের  মধ্যে) প্রসেস সার্ভারকে নোটিশ জারির এস আর দাখিল করার জন্য বলা হল।";
        // var activitiesDefault = "প্রতিষ্ঠানের নাম হতে তারিখে খাতকের নাম এর নিকট হতে টাকার পরিমাণ টাকা আদায়ের জন্য সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫ ধারা মতে একটি অনুরোধপত্র পাওয়া গিয়েছে। <br/> দেখলাম। দাবী আদায়যোগ্য বিবেচিত হওয়ায় ১০ নং রেজিস্টার বহিতে লিপিবদ্ধ করে সার্টিফিকেট রিকুইজিশনে স্বাক্ষর করা হল। সার্টিফিকেট খাতকের প্রতি ১০(ক) ধারার নোটিশ জারি করা হোক। আগামি (০১ মাসের  মধ্যে) প্রসেস সার্ভারকে নোটিশ জারির এস আর দাখিল করার জন্য বলা হল।";
        $('#note').val(GenActivitiesDefault);
    }
    $("#applicantOrganization_1").change(function() {
        primaryNote();
    });
    $("#case_date").change(function() {
        primaryNote();
    });
    $("#defaulterName_1").change(function() {
        primaryNote();
    });
    $("#totalLoanAmount").change(function() {
        setTimeout(function() {
            primaryNote();
        }, 2000);
    });
    $("#totalLoanAmountText").change(function() {
        primaryNote();
    });
    $("#lawSection").change(function() {
        primaryNote();
    });
    // ================= Activities ========= end =========

    // ============= Add Attachment Row ========= start =========
    $("#addFileRow").click(function(e) {
        addFileRowFunc();
    });
    //add row function
    /* function addFileRowFunc() {
         var count = parseInt($('#other_attachment_count').val());
         $('#other_attachment_count').val(count + 1);
         var items = '';
         items += '<tr>';
         items += '<td><input type="text" name="file_type[]" class="form-control form-control-sm" placeholder=""></td>';
         items += '<td><div class="custom-file"><input type="file" name="file_name[]" onChange="attachmentTitle(' +
             count + ')" class="custom-file-input" id="customFile' + count +
             '" /><label class="custom-file-label custom-input' + count + '" for="customFile' + count +
             '">ফাইল নির্বাচন করুন</label></div></td>';
         items += '<td width="40"><a href="javascript:void();" class="btn btn-sm btn-danger font-weight-bolder pr-2" onclick="removeBibadiRow(this)"> <i class="fas fa-minus-circle"></i></a></td>';
         items += '</tr>';
         $('#fileDiv tr:last').after(items);
     }*/
    function addFileRowFunc() {
        var count = parseInt($('#other_attachment_count').val());
        $('#other_attachment_count').val(count + 1);
        var items = '';
        items += '<tr>';
        items +=
            '<td><input type="hidden" name="is_payment_file[]" value="not_payment_file"><input type="text" name="file_type[]" class="form-control form-control-sm" placeholder="ফাইলের নাম দিন" id="file_name_important' +
            count + '" ></td>';
        items += '<td><div class="custom-file"><input type="file" name="file_name[]" onChange="attachmentTitle(' +
            count + ',this)" class="custom-file-input" id="customFile' + count +
            '" /><label class="custom-file-label custom-input' + count + '" for="customFile' + count +
            '">ফাইল নির্বাচন করুন </label></div></td>';
        items +=
            '<td width="40"><a href="javascript:void();" class="btn btn-sm btn-danger font-weight-bolder pr-2" onclick="removeBibadiRow(this)"> <i class="fas fa-minus-circle"></i></a></td>';
        items += '</tr>';
        $('#fileDiv tr:last').after(items);
    }
    //Attachment Title Change
    /* function attachmentTitle(id) {
         var value = $('#customFile' + id).val();
         $('.custom-input' + id).text(value);
     }*/
    function attachmentTitle(id, obj) {
        // var value = $('#customFile' + id).val();
        var value = $('#customFile' + id)[0].files[0];

        const fsize = $('#customFile' + id)[0].files[0].size;
        const file_size = Math.round((fsize / 1024));

        var file_extension = value['name'].split('.').pop().toLowerCase();

        if ($.inArray(file_extension, ['pdf', 'docx']) == -1) {
            Swal.fire(

                'ফাইল ফরম্যাট PDF,docx হতে হবে ',

            )
            $(obj).closest("tr").remove();
        }
        if (file_size > 2048) {
            Swal.fire(

                'ফাইল সাইজ অনেক বড় , ফাইল সাইজ ২ মেগাবাইটের কম হতে হবে',

            )
            $(obj).closest("tr").remove();
        }

        var custom_file_name = $('#file_name_important' + id).val();
        if (custom_file_name == "") {
            Swal.fire(

                'ফাইল এর প্রথমে যে নাম দেয়ার field আছে সেখানে ফাইল এর নাম দিন ',

            )
            $(obj).closest("tr").remove();
        }

        $('.custom-input' + id).text(value['name']);
    }
    //remove Attachment
    function removeBibadiRow(id) {
        $(id).closest("tr").remove();
    }
    // =============== Add Attachment Row ===================== end =========================

    // Number to Bangla Word ========================= start ====================
    $("#totalLoanAmount").change(function() {
        var amount = $("#totalLoanAmount").val();
        var enAmount = NumToBangla.replaceBn2EnNumbers(amount);
        var num = parseInt(enAmount);
        if (num.toString().length < 16) {
            $("#totalLoanAmountText").val(NumToBangla.convert(num));
        } else {
            toastr.error('টাকার পরিমাণ অনেক দীর্ঘ', "Error");
        }
    });
    $("#totalLoanAmount").keyup(function() {
        var amount = $("#totalLoanAmount").val();
        $("#totalLoanAmount").val(NumToBangla.replaceNumbers(amount));
    });
    // Number to Bangla Word ========================= end ====================

    // Multiple Nominee ================================= start ==============================
    //remove Nominee
    $("#RemoveNominee").on('click', function() {
        var elements = parseInt($('#NomineeCount').val());
        if (elements > 1) {

            var countNegative = parseInt($('#NomineeCount').val());
            Swal.fire({
                title: 'বাতিল করতে চান ?',
                icon: 'info',
                confirmButtonText: 'Log in'
            }).then((result) => {
                if (result['isConfirmed']) {
                    $('.cloneNomenee_' + elements).remove()
                }
            })


            //$('.cloneNomenee_' + countNegative).remove()
            $('#NomineeCount').val(--countNegative);
        } else {
            console.log('fasle');
            Swal.fire({
                position: "top-right",
                icon: "error",
                title: 'আবেদনকারীর তথ্য সর্বনিম্ম একটি থাকতে হবে',
                showConfirmButton: false,
                timer: 1500,
            });
        }

    });

    //add Nominee
    @include('appealInitiate._nominee_multiple');
    // Multiple Nominee ================================= End ==============================

    // Multiple Applicant ================================= start ==============================
    //remove Applicant
    // $("#RemoveApplicant").on('click', function() {
    //     var elements = $("#applicantInfo #accordionExample3 .card").length;
    //     if (elements != 1) {
    //         var citizen_id = $("#applicantInfo #accordionExample3 .card:last #applicantId_1").val();
    //         if (citizen_id) {
    //             Swal.fire({
    //                     title: "আপনি কি মুছে ফেলতে চান?",
    //                     icon: "warning",
    //                     showCancelButton: true,
    //                     confirmButtonText: "হ্যাঁ",
    //                     cancelButtonText: "না",
    //                 })
    //                 .then(function(result) {
    //                     if (result.value) {
    //                         KTApp.blockPage({
    //                             overlayColor: 'black',
    //                             opacity: 0.2,
    //                             message: 'Please wait...',
    //                             state: 'danger' // a bootstrap color
    //                         });
    //                         var params = $.extend({}, doAjax_params_default);
    //                         params['url'] = "{{ url('appeal/appealCitizenDelete') }}/" + citizen_id;
    //                         params['requestType'] = "POST";
    //                         params['data'] = {};
    //                         params['successCallbackFunction'] = ajaxSuccess;
    //                         params['successCallbackMsg'] = "সফলভাবে মুছে ফেলা হয়েছে!";
    //                         params['errorCallBackFunction'] = ajaxError;
    //                         doAjax(params);
    //                         $("#applicantInfo #accordionExample3 .card:last").remove();
    //                     }
    //                 });
    //         } else {
    //             $("#applicantInfo #accordionExample3 .card:last").remove();
    //         }
    //     } else {
    //         console.log('fasle');
    //         Swal.fire({
    //             position: "top-right",
    //             icon: "error",
    //             title: 'আবেদনকারীর তথ্য সর্বনিম্ম একটি থাকতে হবে',
    //             showConfirmButton: false,
    //             timer: 1500,
    //         });
    //     }
    // });

    // //add Applicant
    // $("#AddApplicant").on('click', function() {
    //     var count = $("#applicantInfo #accordionExample3 .card").length;
    //     // var count = parseInt($('#ApplicantCount').val());
    //     $('#ApplicantCount').val(count + 1);
    //     var addApplicant = '';
    //     addApplicant += '<div id="cloneApplicant" class="card">';
    //     addApplicant += '<div class="card-header" id="headingOne3">';
    //     addApplicant += '    <div class="card-title collapsed h4" data-toggle="collapse"';
    //     addApplicant += '        data-target="#collapseOne3' + (count + 1) + '">';
    //     addApplicant += '        প্রতিনিধির তথ্য &nbsp; <span';
    //     addApplicant += '            id="spannCount">(' + (count + 1) + ')</span>';
    //     addApplicant += '    </div>';
    //     addApplicant += '</div>';
    //     addApplicant += '<div id="collapseOne3' + (count + 1) + '" class="collapse"';
    //     addApplicant += '    data-parent="#accordionExample3">';
    //     addApplicant += '    <div class="card-body">';
    //     addApplicant += '        <div class="clearfix">';
    //     addApplicant += '            <div class="row">';
    //     addApplicant += '                {{-- <div class="col-md-12">';
    //     addApplicant +='                    <span style="color: rebeccapurple">আবেদনকারীর নাম/পদবী দু’টি';
    //     addApplicant +='                        ফিল্ডের যেকোন একটি পূরণীয় বাধ্যতামূলক।</span>';
    //     addApplicant +='                    <span style="color:#FF0000">*</span>';
    //     addApplicant +='                </div> --}}';
    //     addApplicant += '                <div class="col-md-12">';
    //     addApplicant += '                    <div class="text-dark font-weight-bold h4">';
    //     addApplicant += '                    <label for="">নাগরিক সন্ধান করুন </label>';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '                <div class="col-md-6">';
    //     addApplicant += '                    <div class="form-group">';
    //     addApplicant += '                        <input required type="text" id="applicantCiNID_' + (count +
    //         1) + '" class="form-control" placeholder="Enter NID No." name="applicant[ciNID][]">';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '                <div class="col-md-6">';
    //     addApplicant += '                    <div class="form-group">';
    //     addApplicant += '                        <input required type="text" id="applicantDob_' + (count + 1) +
    //         '" name="applicant[dob][]" placeholder="Enter Date of Birth" id="dob" class="form-control common_datepicker" autocomplete="off">';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '            </div>';
    //     addApplicant += '            <div class="row">';
    //     addApplicant += '                <div class="col-md-6">';
    //     addApplicant += '                    <div class="form-group">';
    //     addApplicant += '                        <input type="button" id="applicantCCheck_' + (count + 1) +
    //         '" name="applicant[cCheck][]" onclick="checkNomineeCitizen(\'applicant\', ' + (count + 1) +
    //         ')" class="btn btn-danger" value="সন্ধান করুন"> <span class="ml-5" id="res_applicant_' + (count +
    //             1) + '"></span>';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '                <div class="col-md-6">';
    //     addApplicant += '                    <div class="form-group" id="applicant_nidPic_' + (count + 1) +
    //         '"></div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '            </div>';
    //     addApplicant += '            <div class="row">';
    //     addApplicant += '                <div class="col-md-6">';
    //     addApplicant += '                    <div class="form-group">';
    //     addApplicant += '                        <label for="applicantName_' + (count + 1) + '"';
    //     addApplicant += '                            class="control-label">আবেদনকারীর নাম</label>';
    //     addApplicant += '                        <input name="applicant[name][]" id="applicantName_' + (count +
    //         1) + '"';
    //     addApplicant += '                            class="form-control form-control-sm name-group" value="">';
    //     addApplicant += '                        <input type="hidden" name="applicant[type][]"';
    //     addApplicant += '                            class="form-control form-control-sm" value="1">';
    //     addApplicant += '                        <input type="hidden" name="applicant[id][]"';
    //     addApplicant += '                            id="applicantId_' + (count + 1) +
    //         '" class="form-control form-control-sm" value="">';
    //     addApplicant += '                        <input type="hidden" name="applicant[email][]"';
    //     addApplicant += '                            id="applicantEmail_' + (count + 1) +
    //         '" class="form-control form-control-sm"';
    //     addApplicant += '                            value="">';
    //     addApplicant += '                        <input type="hidden" name="applicant[thana][]"';
    //     addApplicant += '                            id="applicantThana_' + (count + 1) +
    //         '" class="form-control form-control-sm"';
    //     addApplicant += '                            value="">';
    //     addApplicant += '                        <input type="hidden" name="applicant[upazilla][]"';
    //     addApplicant += '                            id="applicantUpazilla_' + (count + 1) +
    //         '" class="form-control form-control-sm"';
    //     addApplicant += '                            value="">';
    //     addApplicant += '                        <input type="hidden" name="applicant[age][]"';
    //     addApplicant += '                            id="applicantAge_' + (count + 1) +
    //         '" class="form-control form-control-sm"';
    //     addApplicant += '                            value="">';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '                <div class="col-md-6">';
    //     addApplicant += '                    <div class="form-group">';
    //     addApplicant += '                        <label for="applicantDesignation_' + (count + 1) + '"';
    //     addApplicant += '                            class="control-label">পদবি</label>';
    //     addApplicant += '                        <input name="applicant[designation][]"';
    //     addApplicant += '                            id="applicantDesignation_' + (count + 1) + '"';
    //     addApplicant += '                            class="form-control form-control-sm name-group" value="">';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '            </div>';
    //     addApplicant += '            <div class="row">';
    //     addApplicant += '                <div class="col-md-6">';
    //     addApplicant += '                    <div class="form-group">';
    //     addApplicant += '                        <label for="applicantOrganization_' + (count + 1) + '"';
    //     addApplicant += '                            class="control-label"><span';
    //     addApplicant += '                                style="color:#FF0000">*';
    //     addApplicant += '                            </span> প্রতিষ্ঠানের নাম</label>';
    //     addApplicant += '                        <input name="applicant[organization][]"';
    //     addApplicant += '                            id="applicantOrganization_' + (count + 1) +
    //         '" class="form-control form-control-sm"';
    //     addApplicant += '                            value=""';
    //     addApplicant += '                            onchange="appealUiUtils.changeInitialNote(;">';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '                <div class="col-md-3">';
    //     addApplicant += '                    <div class="form-group">';
    //     addApplicant += '                        <label for="applicantType" class="control-label"><span';
    //     addApplicant += '                                style="color:#FF0000">*';
    //     addApplicant += '                            </span>প্রতিষ্ঠানের ধরন';
    //     addApplicant += '                        </label>';
    //     addApplicant += '                        <div class="radio ml-5">';
    //     addApplicant += '                            <label>';
    //     addApplicant += '                                <input';
    //     addApplicant += '                                    id="applicantTypeBank"';
    //     addApplicant += '                                    class="applicantType" type="radio"';
    //     addApplicant += '                                    name="applicant[Type][]" value="BANK" checked>';
    //     addApplicant += '                                <span class="ml-3">';
    //     addApplicant += '                                    ব্যাংক';
    //     addApplicant += '                                </span>';
    //     addApplicant += '                            </label>';
    //     addApplicant += '                        </div>';
    //     addApplicant += '                        <div class="radio  ml-5">';
    //     addApplicant += '                            <label>';
    //     addApplicant += '                                <input';
    //     addApplicant += '                                    id="applicantTypeOther"';
    //     addApplicant += '                                    class="applicantType" type="radio"';
    //     addApplicant += '                                    name="applicant[Type][]" value="GOVERNMENT">';
    //     addApplicant += '                                <span class="ml-3">';
    //     addApplicant += '                                    সরকারি প্রতিষ্ঠান';
    //     addApplicant += '                                </span>';
    //     addApplicant += '                            </label>';
    //     addApplicant += '                        </div>';
    //     addApplicant += '                        <div class="radio  ml-5">';
    //     addApplicant += '                            <label>';
    //     addApplicant += '                                <input';
    //     addApplicant += '                                    id="applicantTypeOther"';
    //     addApplicant += '                                    class="applicantType" type="radio"';
    //     addApplicant += '                                    name="applicant[Type][]" value="OTHER_COMPANY">';
    //     addApplicant += '                                <span class="ml-3">';
    //     addApplicant += '                                    স্বায়ত্তশাসিত প্রতিষ্ঠান';
    //     addApplicant += '                                </span>';
    //     addApplicant += '                            </label>';
    //     addApplicant += '                        </div>';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '                <div class="col-md-3">';
    //     addApplicant += '                    <div class="form-group">';
    //     addApplicant += '                        <label for="applicantGender_' + (count + 1) + '"';
    //     addApplicant += '                            class="control-label">লিঙ্গ</label>';
    //     addApplicant += '                        <select style="width: 100%;"';
    //     addApplicant += '                            class="selectDropdown form-control form-control-sm"';
    //     addApplicant += '                            name="applicant[gender][]" id="applicantGender_' + (count +
    //         1) + '">';
    //     addApplicant += '                            <option value="">বাছাই করুন</option>';
    //     addApplicant += '                            <option value="MALE">পুরুষ</option>';
    //     addApplicant += '                            <option value="FEMALE">নারী</option>';
    //     addApplicant += '                        </select>';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '            </div>';
    //     addApplicant += '            <div class="row">';
    //     addApplicant += '                <div class="col-md-6">';
    //     addApplicant += '                    <div class="form-group">';
    //     addApplicant += '                        <label for="applicantFather_' + (count + 1) + '"';
    //     addApplicant += '                            class="control-label"><span';
    //     addApplicant += '                                style="color:#FF0000"></span>পিতার নাম</label>';
    //     addApplicant += '                        <input name="applicant[father][]"';
    //     addApplicant += '                            id="applicantFather_' + (count + 1) +
    //         '" class="form-control form-control-sm"';
    //     addApplicant += '                            value="">';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '                <div class="col-md-6">';
    //     addApplicant += '                    <div class="form-group">';
    //     addApplicant += '                        <label for="applicantMother_' + (count + 1) + '"';
    //     addApplicant += '                            class="control-label"><span';
    //     addApplicant += '                                style="color:#FF0000"></span>মাতার নাম</label>';
    //     addApplicant += '                        <input name="applicant[mother][]"';
    //     addApplicant += '                            id="applicantMother_' + (count + 1) +
    //         '" class="form-control form-control-sm"';
    //     addApplicant += '                            value="">';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '            </div>';
    //     addApplicant += '            <div class="row">';
    //     addApplicant += '                <div class="col-md-6">';
    //     addApplicant += '                    <div class="form-group">';
    //     addApplicant += '                        <label for="applicantNid_' + (count + 1) + '"';
    //     addApplicant += '                            class="control-label"><span';
    //     addApplicant += '                                style="color:#FF0000"></span>জাতীয় পরিচয়';
    //     addApplicant += '                            পত্র</label>';
    //     addApplicant += '                        <input name="applicant[nid][]" id="applicantNid_' + (count +
    //         1) + '" class="form-control form-control-sm" value="">';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '                <div class="col-md-6">';
    //     addApplicant += '                    <div class="form-group">';
    //     addApplicant += '                        <label for="applicantPhn_' + (count + 1) + '"';
    //     addApplicant += '                            class="control-label"><span';
    //     addApplicant += '                                style="color:#FF0000">*';
    //     addApplicant += '                            </span>মোবাইল</label>';
    //     addApplicant += '                        <input name="applicant[phn][]" id="applicantPhn_' + (count +
    //         1) + '"';
    //     addApplicant += '                            class="form-control form-control-sm" value="">';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '            </div>';
    //     addApplicant += '            <div class="row">';
    //     addApplicant += '                <div class="col-md-6">';
    //     addApplicant += '                    <div class="form-group">';
    //     addApplicant += '                        <label for="applicantPresentAddree_' + (count + 1) + '"><span';
    //     addApplicant += '                                style="color:#FF0000">*';
    //     addApplicant += '                            </span>প্রতিষ্ঠানের ঠিকানা</label>';
    //     addApplicant += '                        <textarea id="applicantPresentAddree_' + (count + 1) + '"';
    //     addApplicant += '                            name="applicant[presentAddress][]" rows="1"';
    //     addApplicant += '                            class="form-control element-block blank"';
    //     addApplicant += '                            aria-describedby="note-error"';
    //     addApplicant += '                            aria-invalid="false"></textarea>';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '                <div class="col-md-6">';
    //     addApplicant += '                    <div class="form-group">';
    //     addApplicant += '                        <label for="applicantEmail_' + (count + 1) + '"><span';
    //     addApplicant += '                                style="color:#ff0000d8">*';
    //     addApplicant += '                            </span>ইমেইল</label>';
    //     addApplicant += '                            <input type="email" name="applicant[email][]"';
    //     addApplicant += '                            id="applicantEmail_' + (count + 1) +
    //         '" class="form-control form-control-sm"';
    //     addApplicant += '                            value="">';
    //     addApplicant += '                    </div>';
    //     addApplicant += '                </div>';
    //     addApplicant += '            </div>';
    //     addApplicant += '        </div>';
    //     addApplicant += '    </div>';
    //     addApplicant += '</div>';
    //     addApplicant += '</div>';
    //     // console.log(addApplicant);
    //     $('#applicantInfo #accordionExample3').append(addApplicant);

    // })
    // Multiple Nominee ================================= End ==============================


    // common datepicker =============== start
    $('.common_datepicker').datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        orientation: "bottom left"
    });
    // common datepicker =============== end

    // function checkCitizen(div_id) {
    //     var id = '#' + div_id;
    //     var nid = $("input[name='" + div_id + "[ciNID]']").val();
    //     var dob = $("input[name='" + div_id + "[dob]']").val();
    //     $("input[name='" + div_id + "[cCheck]']").val('Checking...');
    //     $("input[name='" + div_id + "[cCheck]']").prop('disabled', true);

    //     $.ajax({
    //         method: "POST",
    //         url: "{{ route('citizen_check') }}",
    //         data: {
    //             'nid': nid,
    //             'dob': dob
    //         },
    //         success: (result) => {
    //             var c = result.data.citizen;
    //             console.log(result);
    //             console.log(c);

    //             var nid = c.citizen_NID;
    //             var gender = c.citizen_gender;
    //             if (gender == 'male') {
    //                 gender = "MALE";
    //             } else {
    //                 gender = "FEMALE";
    //             }
    //             var father = c.father;
    //             var mother = c.mother;
    //             var phone = c.citizen_phone_no;
    //             var name = c.citizen_name;
    //             var nidPic = c.citizen_NID_pic;
    //             $("input[name='" + div_id + "[nid]']").val(nid);
    //             $("select[name='" + div_id + "[gender]'] option[value=" + gender + "]").prop("selected",
    //                 true);
    //             $("input[name='" + div_id + "[father]']").val(father);
    //             $("input[name='" + div_id + "[mother]']").val(mother);
    //             $("input[name='" + div_id + "[phn]']").val(phone);
    //             $("input[name='" + div_id + "[name]']").val(name);
    //             $(id + "_nidPic").empty();
    //             $(id + "_nidPic").append(
    //                 '<img class="w-25 border border-danger rounded border-2" src="{{ url('') }}/' +
    //                 nidPic + '">');
    //             // applicant[nidPic]

    //             $("#res_" + div_id).empty();
    //             $("#res_" + div_id).append(" <span class='text-primary h5'>" + result.message + "</span>");
    //             $("input[name='" + div_id + "[cCheck]']").val('সন্ধান করুন');
    //             $("input[name='" + div_id + "[cCheck]']").prop('disabled', false);
    //         },
    //         error: (error) => {
    //             // console.log(error);
    //             $(id + "_nidPic").empty();
    //             $("#res_" + div_id).empty();
    //             $("#res_" + div_id).append(" <span class='text-danger h5'>" + error.responseJSON.err_res +
    //                 "</span>");
    //             $("input[name='" + div_id + "[cCheck]']").val('সন্ধান করুন');
    //             $("input[name='" + div_id + "[cCheck]']").prop('disabled', false);

    //         }
    //     });
    // }

    // function checkNomineeCitizen(div_id, i) {
    //     var id = '#' + div_id;
    //     var nid = $(id + "CiNID_" + i).val();
    //     var dob = $(id + "Dob_" + i).val();
    //     console.log(nid);
    //     // return;
    //     $(id + "CCheck_" + i).val('Checking...');
    //     $(id + "CCheck_" + i).prop('disabled', true);

    //     $.ajax({
    //         method: "POST",
    //         url: "{{ route('citizen_check') }}",
    //         data: {
    //             'nid': nid,
    //             'dob': dob
    //         },
    //         success: (result) => {
    //             var c = result.data.citizen;
    //             // console.log(result);
    //             // console.log(c);
    //             var nid = c.citizen_NID;
    //             var father = c.father;
    //             var mother = c.mother;
    //             var phone = c.citizen_phone_no;
    //             var name = c.citizen_name;
    //             var gender = c.citizen_gender;
    //             var nidPic = c.citizen_NID_pic;
    //             if (gender == 'male') {
    //                 gender = "MALE";
    //             } else {
    //                 gender = "FEMALE";
    //             }

    //             $(id + "Nid_" + i).val(nid);
    //             $(id + "Gender_" + i + " option[value=" + gender + "]").prop("selected", true);
    //             $(id + "Father_" + i).val(father);
    //             $(id + "Mother_" + i).val(mother);
    //             $(id + "Phn_" + i).val(phone);
    //             $(id + "Name_" + i).val(name);
    //             $(id + "_nidPic_" + i).empty();
    //             $(id + "_nidPic_" + i).append(
    //                 '<img class="w-25 border border-danger rounded border-2" src="{{ url('') }}/' +
    //                 nidPic + '">');


    //             $("#res_" + div_id + '_' + i).empty();
    //             $("#res_" + div_id + '_' + i).append(" <span class='text-primary h5'>" + result.message +
    //                 "</span>");
    //             $(id + "CCheck_" + i).val('সন্ধান করুন');
    //             $(id + "CCheck_" + i).prop('disabled', false);
    //         },
    //         error: (error) => {
    //             // console.log(error);
    //             $(id + "_nidPic_" + i).empty();
    //             $("#res_" + div_id + '_' + i).empty();
    //             $("#res_" + div_id + '_' + i).append(" <span class='text-danger h5'>" + error.responseJSON
    //                 .err_res + "</span>");
    //             $(id + "CCheck_" + i).val('সন্ধান করুন');
    //             $(id + "CCheck_" + i).prop('disabled', false);
    //         }
    //     });
    // }


    /* CODE BY TOUHID */

    function updateNote(a) {
        var order_id = $(a).val();

        if (order_id == 27 || order_id == 28 || order_id == 29 || order_id == 36) {
            $("#paymentcollection_form_details").show();
        } else {
            $("#paymentcollection_form_details").hide();

        }

        createPayementFileField(order_id);




        if (1 == $(a).is(":checked")) {
            var description = $(a).attr("desc");
            var className = $(a).attr("name");
            // var data = $("#note").val() + "<p class='"+className+"'>" + description +"</p>";
            var data = $("#note").val() + "\n" + description;
            $("#note").val(data)
            $("#orderPreviewBtn").attr('disabled', false);
        }

        if (order_id == 1) {
            makeDynamicrequisition();
        }

        makeOrderWithClean(order_id);
    }

    function makeOrderWithClean(order_id) {


        $("#note").val('');
        var data = $('#shortOrder_' + order_id).attr("desc")+"\n\n"+"সদয় পরবর্তী আদেশের জন্যে";;

        $("#note").val(data)
    }

    function makeDynamicrequisition() {
        $.ajax({
            url: '{{ route('appeal.make.autofill.ruisition') }}',
            method: 'post',
            data: {

                appeal_id: $("input[name='appealId']").val(),
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {

                if (response.success == 'success') {
                    $("#note").val('');
                    var data =
                        "অদ্য নথি পেশ করা হলো । " +
                        "\n\n" + response.message +
                        "\n\n"+"সদয় পরবর্তী আদেশের জন্যে";
                    $("#note").val(data)
                    recuision_global = data;
                }
            }
        });
    }


    $('#trialDate,#report_date,#finalOrderPublishDateNow').datepicker({
        startDate: new Date(),
        format: "dd/mm/yyyy",
        todayHighlight: true,
        orientation: "bottom left"
    });








    function addDatePicker(id) {
        $(".common_datepicker_1").datepicker({
            format: 'yyyy/mm/dd'

        });
    }

    function orderPreview() {
        // console.log($("#note").val());
        var description = $("#note").val();
        $("#orderContaint").html(description);
    }


   



    function nid_data_pull_warning_fun() {
        Swal.fire(
            '',
            'অনুগ্রহ পূর্বক সংশ্লিষ্ট ব্যাক্তির জাতীয় পরিচয়পত্র নম্বর এবং জন্ম তারিখ প্রদান করুন ( ফর্ম এর উপরের দিকে দেখুন )। জাতীয় পরিচয়পত্র থেকে পিতার নাম, মাতার নাম, লিঙ্গ, ঠিকানা পেয়ে যাবেন যা পরিবর্তনযোগ্য নয় ।',
            'question'


        )
    }


    // $('.show_hide_attendence_btn').on('click',function(){
    //     if($(this).is(':checked') == false)
    //     {
    //         $(this).hide();
    //     }else
    //     {
    //         $(this).show(); 
    //     }
    // })

    function AttPrintHideShow(type) {
        var att = $('input[name="citizenAttendance[attendance][' + type + ']"]:checked').val();

        if (att == 'ABSENT') {
            $("#attVic_" + type).addClass("d-none");
        } else {
            $("#attVic_" + type).removeClass("d-none");
        }
        // console.log(att);
    }


    function english2bangla(input) {
        var finalEnlishToBanglaNumber = {
            '0': '০',
            '1': '১',
            '2': '২',
            '3': '৩',
            '4': '৪',
            '5': '৫',
            '6': '৬',
            '7': '৭',
            '8': '৮',
            '9': '৯'
        };

        String.prototype.getDigitBanglaFromEnglish = function() {
            var retStr = this;
            for (var x in finalEnlishToBanglaNumber) {
                retStr = retStr.replace(new RegExp(x, 'g'), finalEnlishToBanglaNumber[x]);
            }
            return retStr;
        };


        return input.getDigitBanglaFromEnglish();
    }

    $(document).on('keyup', '#court_fee_amount', function(e) {
        $(this).val(english2bangla($(this).val()));
    })
    $(document).on('keyup', '#court_fee_amount', function(e) {
        var field_value = $(this).val();
        let csrf = '{{ csrf_token() }}';
        $.ajax({
            url: '{{ route('number.field.check') }}',
            method: 'post',
            data: JSON.stringify({
                court_fee_amount: field_value,
                _token: csrf
            }),
            cache: false,
            contentType: 'application/json',
            processData: false,
            dataType: 'json',
            success: function(res) {

                if (!res.is_numeric) {
                    alert('শুধুমাত্র সংখ্যা দিন');
                    $('#court_fee_amount').val('');
                }
            }
        });

    })

    $(document).on('keyup', '#TodayPaymentPaymentCollection', function(e) {
        $(this).val(english2bangla($(this).val()));
    })
    $(document).on('keyup', '#TodayPaymentPaymentCollection', function(e) {
        var field_value = $(this).val();
        var TotalRemainingPaymentPaymentCollection = $('#TotalRemainingPaymentPaymentCollectionBckp').val();
        let csrf = '{{ csrf_token() }}';
        $.ajax({
            url: '{{ route('number.field.check.remainig.taka') }}',
            method: 'post',
            data: JSON.stringify({
                TodayPaymentPaymentCollection: field_value,
                totalDemandPaymentCollection: $('#totalDemandPaymentCollection').val(),
                collectSoFarPaymentCollection: $('#collectSoFarPaymentCollection').val(),
                _token: csrf
            }),
            cache: false,
            contentType: 'application/json',
            processData: false,
            dataType: 'json',
            success: function(res) {

                if (!res.is_numeric) {
                    alert('শুধুমাত্র সংখ্যা দিন');
                    $('#TodayPaymentPaymentCollection').val('');
                    $('#TotalRemainingPaymentPaymentCollection').val(
                        TotalRemainingPaymentPaymentCollection);
                    var data = "অদ্য নথি পেশ করা হলো । "
                    $("#note").val(data)
                }
                if (res.is_overflow) {
                    alert('আপনি অতিরিক্ত টাকা দিয়েছন');
                    $('#TodayPaymentPaymentCollection').val('');
                    $('#TotalRemainingPaymentPaymentCollection').val(
                        TotalRemainingPaymentPaymentCollection);
                    var data = "অদ্য নথি পেশ করা হলো । "
                    $("#note").val(data)
                }
                if (!res.is_overflow && res.is_numeric) {
                    $('#TotalRemainingPaymentPaymentCollection').val(res
                        .TotalRemainingPaymentPaymentCollection);
                    if ($('.shortOrderCheckBox:checked').val() == 27) {
                        var data =
                            "অদ্য নথি পেশ করা হলো । " + $('#shortOrder_27').attr('desc') +
                            "\n\n" + res.message;
                        $("#note").val(data)
                    }

                }
            }
        });

    })

    function ReportFormSubmit(formId) {
        console.log('check');
        $("#" + formId + " #submit").addClass('spinner spinner-dark spinner-left disabled');
        var form = $("#" + formId);

        var formData = new FormData(form[0]);
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                        $(".progress-bar").html(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            type: 'POST',
            url: "{{ route('appeal.trial.report_add') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSubmit: function() {
                $(".progress-bar").width('0%');
                $("#uploadStatus").html('Uploading FILE');
            },
            success: (data) => {
                // form[0].reset();
                if (data.error == "error") {

                    toastr.error(data.error_details);
                    $("#" + formId + " #submit").removeClass(
                        'spinner spinner-white spinner-right disabled');
                } else {

                    toastr.success(data.success, "Success");

                    // console.log(data.html);
                    // $('.ajax').remove();
                    $('#legalReportSection').empty();
                    $('#legalReportSection').append(data.data)
                    // $('#hearing_add_button_close').click()
                    $("#" + formId + " #submit").removeClass(
                        'spinner spinner-white spinner-right disabled');
                    $('.modal').modal('hide');
                    form[0].reset();
                }



            },
            error: function(data) {

                $("#" + formId + " #submit").removeClass('spinner spinner-white spinner-right disabled');

            }
        });
    }

    $("form#appealCase").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        Swal.showLoading()
        $.ajax({
            url: '{{ route('appeal.store') }}',
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'error') {
                    $('#exampleModal').modal('hide');
                    Swal.fire(response.message);
                    toastr.error(response.error);
                    Swal.fire({
                        text: response.message,

                    });
                    //scrollCreate(response.div_id);

                } else {

                    $('#exampleModal').modal('hide');
                    Swal.close();
                    toastr.success(response.success);
                    window.location.replace('/dashboard');
                }
            }
        });
    });

    $('#is_attendence_required').on('change', function() {
        if ($(this).val() == "attendence_required") {
            $('#is_attendence_required_div').show()
        } else {
            $('#is_attendence_required_div').hide()
        }
    });

    function createPayementFileField(order_id) {
        $('.default_file_add').remove();

        if (order_id == 27 || order_id == 36) {

            var count = 0;
            $('#other_attachment_count').val(count + 1);
            var items = '';
            items += '<tr class="default_file_add">';
            items +=
                '<td><input type="hidden" name="is_payment_file[]" value="payment_file"><input type="text" name="file_type[]" class="form-control form-control-sm payment_file" value="টাকা আদায়ের রশিদ"  id="file_name_important' +
                count + '" ></td>';
            items += '<td><div class="custom-file"><input type="file" name="file_name[]" onChange="attachmentTitle(' +
                count + ',this)" class="custom-file-input" id="customFile' + count +
                '" /><label class="custom-file-label custom-input' + count + '" for="customFile' + count +
                '">ফাইল নির্বাচন করুন </label></div></td>';
            items += '</tr>';
            $('#fileDiv tr:last').after(items);

        } else if (order_id == 28 || order_id == 29) {
            var valueFieldarray = [{
                    name_of_slip: 'টাকা আদায়ের রশিদ',
                    is_payment_file: 'payment_file',
                    classNameSelector: 'payment_file'
                },
                {
                    name_of_slip: 'নিষ্পত্তি আবেদন',
                    is_payment_file: 'not_payment_file',
                    classNameSelector: 'close_request'
                }
            ];
            var count = 0;
            $.each(valueFieldarray, function(index, val) {
                count = index + 1;
                var items = '';
                items += '<tr class="default_file_add">';
                items +=
                    '<td><input type="hidden" name="is_payment_file[]" value="' + val.is_payment_file +
                    '"><input type="text" name="file_type[]" class="form-control form-control-sm "' + val
                    .classNameSelector + '" value="' + val.name_of_slip + '"  id="file_name_important' +
                    count + '" ></td>';
                items +=
                    '<td><div class="custom-file"><input type="file" name="file_name[]" onChange="attachmentTitle(' +
                    count + ',this)" class="custom-file-input" id="customFile' + count +
                    '" /><label class="custom-file-label custom-input' + count + '" for="customFile' + count +
                    '">ফাইল নির্বাচন করুন </label></div></td>';
                items += '</tr>';
                $('#fileDiv tr:last').after(items);
            });
            $('#other_attachment_count').val(count + 1);
        } else if (order_id == 33) {
            var count = 0;
            $('#other_attachment_count').val(count + 1);
            var items = '';
            items += '<tr class="default_file_add">';
            items +=
                '<td><input type="hidden" name="is_payment_file[]" value="not_payment_file"><input type="text" name="file_type[]" class="form-control form-control-sm close_request" value="খাতকের দাবী অস্বীকার স্ক্যান কপি"  id="file_name_important' +
                count + '" ></td>';
            items += '<td><div class="custom-file"><input type="file" name="file_name[]" onChange="attachmentTitle(' +
                count + ',this)" class="custom-file-input" id="customFile' + count +
                '" /><label class="custom-file-label custom-input' + count + '" for="customFile' + count +
                '">ফাইল নির্বাচন করুন </label></div></td>';
            items += '</tr>';
            $('#fileDiv tr:last').after(items);
        }
    }


    $('#search_short_order_important').on('keyup', function() {
        $.each($(".case_short_decision_data"), function(key, value) {
            if ($(this).data('string').indexOf($('#search_short_order_important').val()) >= 0) {
                $('.radio_id_' + $(this).data('row_id_index')).show();
            } else {
                $('.radio_id_' + $(this).data('row_id_index')).hide();
            }

        });
    })
</script>