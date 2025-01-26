<script src="{{ asset('js/number2banglaWord.js') }}"></script>
<script>
    var recuision_global;
    var globalNote;

    function deleteFile(id) {
        Swal.fire({
                title: "আপনি কি মুছে ফেলতে চান?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "হ্যাঁ",
                cancelButtonText: "না",
            })
            .then(function(result) {
                if (result.value) {
                    KTApp.blockPage({
                        // overlayColor: '#1bc5bd',
                        overlayColor: 'black',
                        opacity: 0.2,
                        // size: 'sm',
                        message: 'Please wait...',
                        state: 'danger' // a bootstrap color
                    });

                    var url = "{{ url('appeal/deleteFile') }}/" + id;

                    // return;
                    $.ajax({
                        url: url,
                        dataType: "json",
                        type: "Post",
                        async: true,
                        data: {},
                        success: function(data) {

                            Swal.fire({
                                position: "top-right",
                                icon: "success",
                                title: "সফলভাবে মুছে ফেলা হয়েছে!",
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            KTApp.unblockPage();
                            $('#deleteFile' + id).hide();
                        },
                        error: function(xhr, exception) {
                            var msg = "";
                            if (xhr.status === 0) {
                                msg = "Not connect.\n Verify Network." + xhr.responseText;
                            } else if (xhr.status == 404) {
                                msg = "Requested page not found. [404]" + xhr.responseText;
                            } else if (xhr.status == 500) {
                                msg = "Internal Server Error [500]." + xhr.responseText;
                            } else if (exception === "parsererror") {
                                msg = "Requested JSON parse failed.";
                            } else if (exception === "timeout") {
                                msg = "Time out error." + xhr.responseText;
                            } else if (exception === "abort") {
                                msg = "Ajax request aborted.";
                            } else {
                                msg = "Error:" + xhr.status + " " + xhr.responseText;
                            }

                            KTApp.unblockPage();
                        }
                    })
                    // toastr.success("সফলভাবে সাবমিট করা হয়েছে!", "Success");
                }
            });
    }

    function getval(sel) {
        var status = sel.value
        if (status == 'CLOSED') {
            $("#orderPublish").show();
            $("#nextDatePublish").hide();
            $("#note").val('');
            $('.shortOrderCheckBox').each(function(index) {
                if ($(this).is(":checked")) {
                    if ($(this).val() == 24) {

                        makeDynamicrequisition();
                    } else {
                        var data =
                            "সার্টিফিকেট ধারক উপস্থিত/অনুপস্থিত। সার্টিফিকেট খাতক উপস্থিত/অনুপস্থিত। ১০(ক) ধারার নোটিশ জারি হয়েছে/হয়নি। নোটিশ জারি অন্তে এস আর ফেরত পাওয়া গিয়েছে/যায়নি।দেখলাম।" +
                            "\n\n" + $(this).attr('desc');
                        $("#note").val(data)
                    }

                }
            });


            // $("#note").val('');
            // // var data =
            // //     "সার্টিফিকেট ধারক উপস্থিত/অনুপস্থিত। সার্টিফিকেট খাতক উপস্থিত/অনুপস্থিত। ১০(ক) ধারার নোটিশ জারি হয়েছে/হয়নি। নোটিশ জারি অন্তে এস আর ফেরত পাওয়া গিয়েছে/যায়নি।দেখলাম।" +
            // //     "\n\n" + $('#shortOrder_31').attr("desc");
            // $("#note").val(data)

        } else {
            $("#nextDatePublish").show();
            $("#orderPublish").hide();
        }
    }

    function orderPublishDate(sel) {
        var status = sel.value
        if (status == 'YES') {
            // alert(status);
            $("#finalOrderPublishDate").show();
        }
        if (status == 'NO') {
            // alert(status);
            $("#finalOrderPublishDate").hide();
        }
    }

    function sdfsdf(id) {

        var url = "{{ url('appeal/deleteFile') }}/" + id;

        $.ajax({
            url: url,
            dataType: "json",
            type: "Post",
            async: true,
            data: {},
            success: function(data) {

                $('#deleteFile' + id).hide();
            },
            error: function(xhr, exception) {
                var msg = "";
                if (xhr.status === 0) {
                    msg = "Not connect.\n Verify Network." + xhr.responseText;
                } else if (xhr.status == 404) {
                    msg = "Requested page not found. [404]" + xhr.responseText;
                } else if (xhr.status == 500) {
                    msg = "Internal Server Error [500]." + xhr.responseText;
                } else if (exception === "parsererror") {
                    msg = "Requested JSON parse failed.";
                } else if (exception === "timeout") {
                    msg = "Time out error." + xhr.responseText;
                } else if (exception === "abort") {
                    msg = "Ajax request aborted.";
                } else {
                    msg = "Error:" + xhr.status + " " + xhr.responseText;
                }

            }
        })
    }

    // appendShortOrderCheckBox: function(a, e) {
    //     var t = "",
    //         n = "";
    //     $(".orderCheckBox").empty(),
    //     $.each(a, function(a, e) {
    //         t += "<label class='checkbox'><input  value=\"" + e.id +
    //             '" type="checkbox" class="shortOrderCheckBox" onchange="appealUiUtils.updateNote(this)" name="shortOrder[' +
    //             a + ']" id="shortOrder_' + e.id + '" desc="' + e.delails + '" />' + e.case_short_decision +
    //             "</label>"
    //     }),
    //     $(".orderCheckBox").append(t),
    //     e.length > 0 &&
    //     $.each(e, function(a, e) {
    //         n = "#shortOrder_" + e.case_shortdecision_id,
    //         $(n).attr("checked", "checked")
    //     })
    // },
    // initAppealTrial: function() {
    //     var e = $("#appealId").val(),
    //         t = "";
    //     e ? appealPopulate.getAppealInfo(e).done(function(e, a, n) {
    //         null != e.data.citizenAttendance[0] && ($("#applicantCitizenAttendanceId").val(e.data.citizenAttendance[0].id), $("#citizenAttendanceApplicantCitizenId").val(e.data.citizenAttendance[0].citizen_id), "ABSENT" == e.data.citizenAttendance[0].attendance ? $("#applicantAttendanceAbsent").attr("checked", !0) : ($("#applicantAttendanceAbsent").attr("checked", !1), $("#applicantAttendancePresent").attr("checked", !0)), $("#defaulterCitizenAttendanceId").val(e.data.citizenAttendance[1].id), $("#citizenAttendanceDefaulterCitizenId").val(e.data.citizenAttendance[1].citizen_id), "ABSENT" == e.data.citizenAttendance[1].attendance ? $("#defaulterAttendanceAbsent").attr("checked", !0) : ($("#defaulterAttendanceAbsent").attr("checked", !1), $("#defaulterAttendancePresent").attr("checked", !0)));
    //         e.data.appealCauseList.length;
    //         var p = e.data.notApprovedShortOrderCauseList;
    //         appealUiUtils.populateAppealSpanInfo(e), e.data.approvedNoteCauseList.length > 0 && ($("#approvedNoteOrderList").removeClass("hidden"), appealUiUtils.appendNotes(e.data.appeal, e.data.approvedNoteCauseList, e.data.attachmentList)), e.data.notApprovedNoteCauseList.length > 0 && (t = e.data.notApprovedNoteCauseList[0].order_text + "\n\n", $("#noteId").val(e.data.notApprovedNoteCauseList[0].noteId), $("#causeListId").val(e.data.notApprovedNoteCauseList[0].cause_list_id)), e.data.attachmentList.length > 0 && appealUiUtils.appendAttachmentsForView(e.data.attachmentList), appealUiUtils.setInitialTrialOrderText(t), appealPopulate.getShortOrderList().done(function(e, t, a) { appealUiUtils.appendShortOrderCheckBox(e.shortOrderList, p) }), appealPopulate.hajiraPrintSectionDataPopulate()
    //     }).fail(function() { $.alert("ত্রুটি ", "অবহিতকরণ বার্তা") }) : $.alert("তথ্য পাওয়া যায়নি ", "অবহিতকরণ বার্তা")
    // },

    function updateNote(a) {

        var order_id = $(a).val();
        if (order_id) {
            $('#manual_short_decision_container').show();
        } else {
            $('#manual_short_decision_container').hide();
        }
        if (order_id == 11 || order_id == 15 || order_id == 9 || order_id == 6 || order_id == 7 || order_id == 19 ||
            order_id == 18 || order_id == 23) {
            if (order_id == 23) {
                $('#auctionOrderPossessionDetails').show();
                $('#warrantExecutorHeading').text('আইনশৃঙ্খলা বাহিনীর তথ্য');
            } else {
                $('#auctionOrderPossessionDetails').hide();
                $('#warrantExecutorHeading').text('ওয়ারেন্ট বাস্তবায়নকারীর তথ্য');

            }
            $("#warrantExecutorDetails").show();
        } else {
            $("#warrantExecutorDetails").hide();
            $('#auctionOrderPossessionDetails').hide()
        }
        /* if (order_id ==23) {
            $("#warrantExecutorDetails").show();
            $('#auctionOrderPossessionDetails').show()
        } else {
            $("#warrantExecutorDetails").hide();
            $('#auctionOrderPossessionDetails').hide()
        } */
        if (order_id == 18) {
            $('#_zill_sent_addtional_info').show();
        } else {
            $('#_zill_sent_addtional_info').hide();
        }
        if (order_id == 2 || order_id == 3 || order_id == 21 || order_id == 5 || order_id == 6 || order_id == 7 ||
            order_id == 11) {
            $('#_seventh_order_addtional').show();
            let cardLabel;
            switch (order_id) {
                case '2':
                    cardLabel = '৭ ধারার নোটিশ জারীর জন্য প্রয়োজনীয় তথ্য';
                    break;
                case '3':
                    cardLabel = 'পুনঃ ৭ ধারার নোটিশ জারীর জন্য প্রয়োজনীয় তথ্য';
                    break;
                case '6':
                    cardLabel = '২৯ ধারার নোটিশ (গ্রেফতারী পরোয়ানা) জারীর জন্য প্রয়োজনীয় তথ্য';
                    break;
                case '7':
                    cardLabel = 'পুনঃ ২৯ ধারার নোটিশ (গ্রেফতারী পরোয়ানা) জারীর জন্য প্রয়োজনীয় তথ্য';
                    break;
                case '11':
                    cardLabel = 'W/A ইস্যু জারীর জন্য প্রয়োজনীয় তথ্য';
                    break;
                case '21':
                    cardLabel = '১০ (ক) ধারার নোটিশ জারীর জন্য প্রয়োজনীয় তথ্য';
                    break;
                    /* case '21':
                        cardLabel = '১০ (ক) ধারার জন্য প্রয়োজনীয় তথ্য';
                        break; */
                default:
                    cardLabel = 'ক্রোক পরোয়ানার জন্য প্রয়োজনীয় তথ্য';
                    break;
            }
            if (order_id == 6) {
                $('#working_amount_29_dhara').show();
            } else {
                $('#working_amount_29_dhara').hide();
            }
            $('#_seventh_order_addtional .card-label').text(cardLabel);
        } else {
            $('#_seventh_order_addtional').hide();
        }

        if (order_id == 14 || order_id == 19) {
            $('#status  option[value="CLOSED"]').prop("selected", true);
            $('#appeal_date_time_status #newnextDatePublish').css('display', 'none');
            $('#appeal_date_time_status #neworderPublish').css('display', 'block');
        } else {
            $('#status  option[value="CLOSED"]').prop("selected", false);
            $('#appeal_date_time_status #newnextDatePublish').css('display', 'block');
            $('#appeal_date_time_status #neworderPublish').css('display', 'none');
        }

        makeOrderWithClean(order_id)
        $("#orderPreviewBtn").attr('disabled', false);
    }

    function makeOrderWithClean(order_id) {


        $("#note").val('');
        var data = $('#shortOrder_' + order_id).attr("desc");
        console.log($("input[name='appealId']").val())
        $.ajax({
            url: '{{ route('appeal.get.dynamic.name.defulter.applicant') }}',
            method: 'post',
            data: {

                appeal_id: $("input[name='appealId']").val(),
                law_sec_id: $("input[name='law_sec_id']").val(),
                details: $('#shortOrder_' + order_id).attr("desc"),
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('from dynamic case no', response);
                if (response.success == 'success') {
                    $("#note").val('');
                    var data = response.message;
                    $("#note").val(data)
                    globalNote = data;
                }
            }
        });
        $("#note").val(data)
    }

    function updateNoteWithData(a) {
        var date = NumToBangla.replaceNumbers($(a).val());
        globalNote = document.getElementById("note").value;
        if (date == "") {
            if (globalNote.includes("পরবর্তী তারিখ: ")) {
                globalNote = removeLastLine(globalNote);
                globalNote = $.trim(globalNote);
            }
        }

        $('.shortOrderCheckBox').each(function(index) {
            if ($(this).is(":checked")) {
                if (globalNote.includes("পরবর্তী তারিখ: ")) {
                    globalNote = removeLastLine(globalNote);
                    globalNote = $.trim(globalNote);
                }

                var data = globalNote + "\n\n\nপরবর্তী তারিখ: " + date;
                $("#note").val(data)
            }
        });


        // var data = $("#note").val() + "\n\n\nপরবর্তী তারিখ: " + date;
        //$("#note").val(data)
        $("#orderPreviewBtn").attr('disabled', false);
    }

    function removeLastLine(x) {
        if (x.lastIndexOf("\n") > 0) {
            return x.substring(0, x.lastIndexOf("\n"));
        } else {
            return x;
        }
    }

    function orderPreview() {


        var description = $("#note").val();
        $("#orderContaint").html(description);
    }

    function saveAsOnTrial(a) {

        var n = $("#appealForm"),
            t = new FormData(n[0]),
            l = $("#userRoleCode").val();
        if ("GCO_" == l) {
            var p = t.get("note").replace(/\r\n|\r|\n/g, "<br />");
            t.append("note", p)
        }
        if ("GCO_" != l & "Peshkar_" != l)
            "ON_TRIAL" === a ? t.append("status", "ON_TRIAL") : t.append("status", "ON_DC_TRIAL");
        else if (3 == $("#appealDecision").val()) t.append("status", "CLOSED");
        else if (4 == $("#appealDecision").val()) {
            var i = $("#getUserRole").val();
            "DM" == i ? t.append("status", "RESEND_TO_PESHKAR") : "ADM" == i && t.append("status", "RESEND_TO_DM")
        } else 2 == $("#appealDecision").val() ? t.append("status", "POSTPONED") : t.append("status", "ON_TRIAL");
        t.append(
                "appealId",
                $("#appealId").val()),
            $("#oldCaseFlag").is(":checked") ?
            t.append("oldCaseFlag", $("#oldCaseFlag").val()) :
            t.append("oldCaseFlag", "0"),
            $.confirm({
                resizable: !1,
                height: 250,
                width: 400,
                modal: !0,
                title: "বিচারকার্যক্রম তথ্য",
                titleClass: "modal-header",
                content: "বিচারকার্যক্রম সংরক্ষণ করতে চান ?",
                buttons: {
                    "না": function() {},
                    "হ্যাঁ": function() {
                        $("#loadingModal").show(),
                            appeal.appealSave(e, "/appeal/store/ontrial", t).done(function(a, e, n) {
                                $("#loadingModal").hide(), "true" == a.flag ? ($.alert(
                                        " বিচারকার্যক্রম  সম্পন্ন  হয়েছে", "অবহিতকরণ বার্তা"),
                                    setTimeout(function() {
                                        window.location = "/appeal/list"
                                    }, 3e3)) : $.alert("ত্রুটি", "অবহিতকরণ বার্তা")
                            }).fail(function() {
                                $("#loadingModal").hide(), $.alert("ত্রুটি", "অবহিতকরণ বার্তা")
                            })
                    }
                }
            })
        // }
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
                        "সার্টিফিকেট ধারক উপস্থিত/অনুপস্থিত। সার্টিফিকেট খাতক উপস্থিত/অনুপস্থিত। ১০(ক) ধারার নোটিশ জারি হয়েছে/হয়নি। নোটিশ জারি অন্তে এস আর ফেরত পাওয়া গিয়েছে/যায়নি।দেখলাম।" +
                        "\n\n" + response.message;
                    $("#note").val(data)
                    recuision_global = data;
                }
            }
        });
    }
</script>
@include('appealInitiate.appealCreate_Js')
<script>
    $(document).ready(function() {
        $('#CaseDetails input').prop('disabled', true);
        $('#CaseDetails select').prop('disabled', true);
        $('#CaseDetails textarea').prop('disabled', true);
    });
</script>




@include('components.Ajax')
<script>
    $("#ReportForm").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
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

        });
    });

    function ReportFormSubmit(formId) {

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

    function AttPrintHideShow(type) {
        var att = $('input[name="citizenAttendance[' + type + '][attendance]"]:checked').val();
        if (att == 'ABSENT') {
            $("#attVic" + type).addClass("d-none");
        } else {
            $("#attVic" + type).removeClass("d-none");
        }

    }

    $(document).ready(function() {
        $("#formSubmit").click(function() {
            $("#caseRivisionForm").submit(); // Submit the form
        });
    });

    /*** Code BY Touhid ****/

    $('#status').on('change', function() {
        if ($(this).val() == "CLOSED") {
            $('#appeal_date_time_status #newnextDatePublish').css('display', 'none');
            $('#appeal_date_time_status #neworderPublish').css('display', 'block');
        } else {
            $('#appeal_date_time_status #newnextDatePublish').css('display', 'block');
            $('#appeal_date_time_status #neworderPublish').css('display', 'none');
        }
    })

    function neworderPublishDate(opt) {
        var status = opt.value

        if (status == 1) {

            $("#finalOrderPublishDateNow").show();
        }
        if (status == 0) {

            $("#finalOrderPublishDateNow").hide();
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
