<script src="{{ asset('js/number2banglaWord.js') }}"></script>
<script>
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
                    console.log(url);
                    // return;
                    $.ajax({
                        url: url,
                        dataType: "json",
                        type: "Post",
                        async: true,
                        data: {},
                        success: function(data) {
                            console.log(data);
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
                            console.log(msg);
                            KTApp.unblockPage();
                        }
                    })
                    // toastr.success("সফলভাবে সাবমিট করা হয়েছে!", "Success");
                }
            });
    }

    function sdfsdf(id) {

        var url = "{{ url('appeal/deleteFile') }}/" + id;
        console.log(url);
        $.ajax({
            url: url,
            dataType: "json",
            type: "Post",
            async: true,
            data: {},
            success: function(data) {
                console.log(data);
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
                console.log(msg);
            }
        })
    }



    function updateNote(a) {
        if (1 == $(a).is(":checked")) {
            var description = $(a).attr("desc");
            var className = $(a).attr("name");
            // var data = $("#note").val() + "<p class='"+className+"'>" + description +"</p>";
            var data = $("#note").val() + "\n" + description;
            $("#note").val(data)
            $("#orderPreviewBtn").attr('disabled', false);
        }
        19 == $(a).val() &&
            $("#paymentStatus").val("PAYMENT_REGULAR"),
            16 == $(a).val() &&
            $("#paymentStatus").val("PAYMENT_AUCTION"),
            15 == $(a).val() &&
            $("#paymentStatus").val("PAYMENT_INSTALLMENT")

    }

    function updateNoteWithData(a) {
        var date = $(a).val();
        // var data = $("#note").val() + "<p class='"+className+"'>" + description +"</p>";
        var data = $("#note").val() + "\n\n\nপরবর্তী তারিখ: " + date;
        $("#note").val(data)

    }

    function orderPreview() {
         // console.log($("#note").val());
        var description = $("#note").val();
        $("#orderContaint").html(description);
    }

    function saveAsOnTrial(a) {
        // if($request->userRoleCode){

        // }
        // if ($("#appealForm").valid()) {
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
            url: "{{ route('citizen.appeal.kharij_application') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

        });
    });

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
            url: "{{ route('citizen.appeal.kharij_application') }}",
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
                toastr.success(data.success, "Success");
                console.log(data);
                // console.log(data.html);
                // $('.ajax').remove();
                $('#legalReportSection').empty();
                $('#legalReportSection').append(data.data)
                // $('#hearing_add_button_close').click()
                $("#" + formId + " #submit").removeClass('spinner spinner-white spinner-right disabled');
                $('.modal').modal('hide');
                form[0].reset();


            },
            error: function(data) {
                console.log(data);
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
        // console.log(att);
    }

    $(document).ready(function() {
        $("#formSubmit").click(function() {
            $("#caseRivisionForm").submit(); // Submit the form
        });
    });
</script>
