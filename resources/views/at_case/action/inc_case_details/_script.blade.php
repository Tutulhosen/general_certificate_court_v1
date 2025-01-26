<script type="text/javascript">


    $(document).ready(function() {
        var SITEURL = "{{ URL('/') }}";

        // Create for new sf document hide create button
        $('#sf_create').click(function() {
            $('#sf_content').show();
            // $('#sf_notice').hide(1000);
            $('#noSfCreate').hide(500);
            $('#sf_create_button').hide(500);
        });

        // Close for new sf document hide create button
        $('#Closesf_create').click(function() {
            $('#sf_content').hide(1000);
            // $('#sf_notice').hide(1000);
            $('#noSfCreate').show(500);
            $('#sf_create_button').show(1000);
        });

        // Submit SF answer by ULAO
        $('#sfCreateSubmit').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('atcase.action.createsf') }}",
                method: 'post',
                data: {
                    case_id: $('#hide_case_id').val(),
                    sf_details: $('#sf_details').val()
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
                        $('#sf_content').hide();
                        $('#sfCreateSuccess').show();
                        $('#noSfCreate').hide();
                        $('#returnSfdetail').append(result.html);

                        console.log(result.html);
                    }
                }
            });
        });

        // Click edit button hide sf document and show edit form
        $('#sf_edit_button').click(function() {
            $('#sf_edit_content').show();
            $('#sf_docs').hide(1000);
            // $('#sf_edit_button').hide(1000);
        });

        // Click close edit button hide sf document and show edit form
        $('#closesf_edit_button').click(function() {
            $('#sf_edit_content').hide(1000);
            $('#sf_docs').show(1000);
            // $('#sf_edit_button').hide(1000);
        });

        // Edit Submit SF answer by AC (Land), ULAO, Kanango, Survayer
        $('#sfUpdateSubmit').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('atcase.action.editsf') }}",
                method: 'post',
                data: {
                    case_id: $('#hide_case_id').val(),
                    sf_id: $('#hide_sf_id').val(),
                    sf_details: $('#sf_details').val()
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
                        console.log(result.html);
                        $('.alert-danger').hide();
                        $('#sf_edit_content').hide();
                        $('#sfEditSuccess').show();
                        $('#sf_docs').hide(1000);
                        $('.ajax').remove();
                        $('#returnSfdetail').append( '<label class="ajax" style="display: block !important;">' + result.html + '</label>');

                    }
                }
            });
        });
        /*$("#status_id").click(function(){
            case_status_dd();
        });*/
        // By Default Load Case Status checked User Role Foward ID
        case_status_dd();

        // On Change Load Case Status checked User Role Foward ID
        jQuery('input[type=radio][name=group]').on('change',function(){
            case_status_dd();
        });


        // Case Hearing Data and File Progress Bar
        $('#ajax-hearing-file-upload').submit(function(e) {
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
                url: "{{ route('atcase.action.file_store_hearing') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSubmit: function() {
                    $(".progress-bar").width('0%');
                    $("#uploadStatus").html('Uploading FILE');
                },
                success: (data) => {
                    this.reset();
                    $('#hearingAddSuccess').show();
                    console.log(data);
                    console.log(data.html);
                    $('.ajax').remove();
                    $('#caseHearingList').empty();
                    $('#caseHearingList').append('<label class="ajax" style="display:block !important;">' + data.html + '</label>')
                },
                error: function(data) {
                    // $("#uploadStatus").html('<p>File upload fail! Please try again</p>');
                    console.log(data);
                }
            });
        });

        // At Case final SF Report Progress Bar
        $('#ajax-file-upload').submit(function(e) {
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
                url: "{{ route('atcase.action.file_store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSubmit: function() {
                    $(".progress-bar").width('0%');
                    $("#uploadStatus").html('Uploading FILE');
                },
                success: (data) => {
                    this.reset();
                    $('#sfReportUploadSuccess').show();
                    $('.ajax').remove();
                    $('#hide_old_finalSF').remove();
                    $('.hide_old_finalSF').remove();
                    $('#sfInstantView').empty();
                    $('#customFile').val(null);
                    $('#sfInstantView').empty();
                    $('#sfInstantView').append( '<label class=".ajax" style="display:block !important;">' + data.html + '</label>');
                    console.log(data);
                    console.log(data.html);

                },
                error: function(data) {
                    $("#uploadStatus").html('<p>File upload fail! Please try again</p>');
                    console.log(data);
                }
            });
        });


        // Case result file upload Progress Bar
        $("#resultUpSuccess").hide();
        $('#ajax-caseResult-upload').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            // console.log(formData);
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
                url: "{{ route('atcase.action.result_update') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSubmit: function() {
                    // document.getElementById("progress_div").style.display="block";
                    // var percentVal = '0%';
                    // bar.width(percentVal);
                    // percent.html(percentVal);
                    $(".progress-bar").width('0%');
                    $("#uploadStatus").html('Uploading FILE');
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
                        $('#result_update_content').hide();
                        $('#haventResult').hide();
                        $('#resultUpSuccess').show();
                        $('#resultUpdateSuccess').show();
                        $('#caseResultUpdate').empty();
                        $('#caseResultUpdate').append(result.html);
                        console.log(result.html)
                        // $('#sf_docs').hide(1000);
                    }
                }
            });
        });
        //============High Court JS=================//

        $("#highCourtDiv").hide();
        $("#yes").click(function() {
            $("#highCourtDiv").show();
        });

        $("#no").click(function() {
            $("#highCourtDiv").hide();
        });

        /* $("#solicitorDiv").hide();
          $(document).ready(function(){
             $("#court_name").change(function(){
                var court_id = document.getElementById("court_name").value;
                if(court_id == 1 || court_id == 2)
                   $("#solicitorDiv").show();
                else
                   $("#solicitorDiv").hide();
               // alert("The text has been changed.");
             });
          });*/

        //============//High Court JS=================//

        //============Lost Reason=================//

        $("#lostReason").hide();
        $("#lost").click(function() {
            $("#lostReason").show();
        });

        $("#win").click(function() {
            $("#lostReason").hide();
        });

        //============//Lost Reason=================//
        // Case SF Report Progress Bar
        /*var bar = $('.bar');
        var percent = $('.percent');
        $('form').ajaxForm({
           beforeSend: function() {
              var percentVal = '0%';
              bar.width(percentVal)
              percent.html(percentVal);
           },
           uploadProgress: function(event, position, total, percentComplete) {
              var percentVal = percentComplete + '%';
              bar.width(percentVal)
              percent.html(percentVal);
           },
           complete: function(xhr) {
              alert('File Has Been Uploaded Successfully');
              // window.location.href = SITEURL +"/"+"ajax-file-upload-progress-bar";
           }
        });*/

        // Case forwared to other by popup modal
        $('#formSubmit').click(function(e) {
            var radioValue = $("input[name='group']:checked").val();
            // alert(radioValue);
            e.preventDefault();

            $.ajax({
                url: "{{ url('/action/forward') }}",
                method: 'post',
                data: {
                    case_id: $('#hide_case_id').val(),
                    group: radioValue,
                    status_id: $('#status_id').val(),
                    comment: $('#comment').val()
                },
                success: function(result) {
                    if (result.errors) {
                        $('.alert-danger').html('');

                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<li>' + value + '</li>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('#caseForwardModal').modal('hide');
                        $('#forwardSuccess').show();
                        $('#forwardButton').hide();
                    }
                }
            });
        });

        //============//Hearing add=================//
        // Click hearing add button hide alert box
        $('#hearing_add_button').click(function() {
            $('#hearing_add_content').show();
            $('#hearing_content').hide(1000);
            $('#hearing_add_button').hide(1000);
        });
        $('#hearing_add_button_close').click(function() {
            $('#hearing_add_button').show();
            $('#hearing_content').show(1000);
            $('#hearing_add_content').hide(1000);
            // $('#hearing_add_button_close').hide(1000);
        });

        // Hearing Upload
        // $('#hearingSubmit').click(function(e) {
        $('#hearingSubmit').submit(function(e) {
            e.preventDefault();
            // alert('ok');

            // var form_Data = new FormData();
            var formData = new FormData(this);
            // alert(formData);

            $.ajax({
                url: "{{ url('/action/hearingadd') }}",
                method: 'POST',
                data: formData,
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
                        $('#hearing_add_content').hide();
                        $('#hearingAddSuccess').show();
                        // $('#sf_docs').hide(1000);
                    }
                },

            });
        });

        <?php
     if($info->is_win != 0){
        ?>
        $('#result_update_content').hide();
        <?php
     }
     ?>


        // Update Case Result by GP
        $('#resultSubmit').click(function(e) {
            var radioValueIsWin = $("input[name='is_win']:checked").val();
            var radioValueLosrAppeal = $("input[name='is_lost_appeal']:checked").val();
            var radioValueInGovtFav = $("input[name='in_favour_govt']:checked").val();

            // var id = $('#hide_case_id').val();
            e.preventDefault();

            $.ajax({
                method: 'post',
                url: "{{ url('/action/result_update') }}",
                data: {
                    case_id: $('#hide_case_id').val(),
                    lost_reason: $('#lost_reason').val(),
                    court_name: $('#court_name').val(),
                    condition_name: $('#condition_name').val(),
                    is_win: radioValueIsWin,
                    is_lost_appeal: radioValueLosrAppeal,
                    in_favour_govt: radioValueInGovtFav
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
                        $('#result_update_content').hide();
                        $('#resultUpdateSuccess').show();
                        // $('#sf_docs').hide(1000);
                    }
                }
            });
        });

         $('select[name="status_id"]').change(function(e) {

            e.preventDefault();
            var roleID =$('input[type=radio][name=group]:checked').val();
             $.ajax({

                url: '{{ url("/")}}/action/getDependentCaseStatus/' + roleID,
                type : "GET",
                dataType : "json",
                  success: function(result) {
                    if (result.errors) {
                        console.log(result.errors);
                        /*$('.alert-danger').html('');
*/
                        /*$.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<li>' + value + '</li>');
                        });*/

                    } else {
                        console.log(result.success);
                        console.log(result.case_status);
                        // $('#status_id').empty();

                        jQuery.each(result.case_status, function(key,value){
                            // $('select[name="status_id"]').val();
                            var status_id = $('select[name="status_id"]').val();
                            if(status_id == value.id){
                                console.log(value.id);
                                $('#changeRemarks').empty();
                                $('#changeRemarks').append('<label class="text-primary font-size-h4">মন্তব্য প্রদান করুন <span class="text-danger">*</span> </label> <textarea name="comment" id="comment" class="form-control form-control-solid" rows="7" style="border: 1px solid #ccc;">'+value.status_templete+'</textarea>');
                            }
                        });


                    }
                }
            });

        });

    });

    // common datepicker
    $('.common_datepicker').datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        orientation: "bottom left"
    });


    function case_status_dd(){
    // alert(1);
    // =========== Case Status ================//
    // jQuery('input[type=radio][name=group]').on('change',function(){
        var roleID = jQuery('input[type=radio][name=group]:checked').val();
        // var roleID = jQuery(this).val();
        // alert(roleID);

        jQuery("#status_id").after('<div class="loadersmall"></div>');

        if(roleID)
        {
          jQuery.ajax({
            url: '{{ url("/")}}/action/getDependentCaseStatus/' + roleID,
            type : "GET",
            dataType : "json",
            success:function(data)
            {
                jQuery('select[name="status_id"]').html('<div class="loadersmall"></div>');
                //console.log(data);
                // jQuery('#mouja_id').removeAttr('disabled');
                // jQuery('#mouja_id option').remove();

                jQuery('select[name="status_id"]').html('<option value="">-- নির্বাচন করুন --</option>');
                jQuery.each(data.case_status, function(key,value){
                    jQuery('select[name="status_id"]').append('<option value="'+ value.id +'">'+ value.status_name +'</option>');
                });
                jQuery('.loadersmall').remove();
                // $('select[name="mouja"] .overlay').remove();
                // $("#loading").hide();
            }
        });
      }
      else
      {
          $('select[name="status_id"]').empty();
      }
    // });
    }



    // Initialization
    jQuery(document).ready(function() {
        //KTCkeditor.init();
    });
</script>
