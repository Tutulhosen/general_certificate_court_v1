
    $("#AddNominee").on('click', function() {
        // var count = parseInt($('#NomineeCount').val());
        var count = parseInt($('#NomineeCount').val());
        // alert(count);
        $('#NomineeCount').val(++count);
        var addNominee = '';
        addNominee += '<div id="" class="card cloneNomenee_' + (count) + '">';
        addNominee += '<div class="card-header" id="headingOne3">';
        addNominee +=
            '    <div class="card-title collapsed h4" data-toggle="collapse" data-target="#collapse' +
            count + '">';
        addNominee += '        উত্তরাধিকারীর তথ্য &nbsp; <span id="spannCount">(' + (count) + ')</span>';
        addNominee += '    </div>';
        addNominee += '</div>';
        addNominee += '<div id="collapse' + count + '" class="collapse" data-parent="#accordionExample3">';
        addNominee += '    <div class="card-body">';
        addNominee += '        <div class="clearfix">';


        addNominee += ' <div class="row">';
        addNominee += '<div class="col-md-12">';
        addNominee += '<div class="text-dark font-weight-bold">';
        addNominee += '<label for="">জাতীয় পরিচয়পত্র যাচাই : </label>';
        addNominee += '</div>';
        addNominee += '</div>';
        addNominee += '<div class="col-md-4">';
        addNominee += '<div class="form-group">';
        addNominee +=
            '<input required type="text"  class="form-control check_nid_number_0" data-nomineerow-index="' + (
                count) + '" placeholder="উদাহরণ- 19825624603112948" id="nominee_nid_input_' + (count) +
            '" onclick="addDatePicker(this.id)">';

        addNominee += '<span id="res_applicant_1"></span>';

        addNominee += '</div>';
        addNominee += '</div>';
        addNominee += '<div class="col-md-4">';
        addNominee += '<div class="form-group">';
        addNominee += '<div class="input-group">';


        addNominee += '<input required type="text" id="nominee_dob_input_' + (count) +
            '" placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী) বছর/মাস/তারিখ" {{-- id="dob" --}} class="form-control common_datepicker_1" autocomplete="off" data-nomineerow-index="' +
            (count + 1) + '" >';
        addNominee += '</div>';
        addNominee += '</div>';
        addNominee += '</div>';
        addNominee += '<div class="col-md-4">';
        addNominee += '<div class="form-group">';
        addNominee += '<div class="input-group">';

        addNominee += '<input type="button" id="nominee_nid_' + (count) + '" data-nomineerow-index="' + (
                count) +
            '" class="btn btn-primary check_nid_button" onclick="NIDCHECKnominee(this.id)" value="সন্ধান করুন">';


        addNominee += '</div>';
        addNominee += '</div>';
        addNominee += '</div>';
        addNominee += '</div>';

        addNominee += '     <div class="row">';
        addNominee += '                <div class="col-md-6">';
        addNominee += '                    <div class="form-group">';
        addNominee += '                        <label for="nomineeName_' + (count) + '"';
        addNominee += '                            class="control-label"><span';
        addNominee += '                                style="color:#FF0000">*</span>উত্তরাধিকারীর';
        addNominee += '                            নাম</label>';
        addNominee += '                        <input name="nominee[name][]"';
        addNominee += '                            id="nomineeName_' + (count) + '"';
        addNominee +=
            '                            class="form-control form-control-sm validation nid_data_pull_warning"';
        addNominee += '                            value=""  readonly>';
        addNominee += ' <div class="required_message hide">This Field is required</div>';
        addNominee += '                        <input type="hidden"';
        addNominee += '                            name="nominee[type][]"';
        addNominee += '                            class="form-control form-control-sm"';
        addNominee += '                            value="5">';
        addNominee += '                        <input type="hidden"';
        addNominee += '                            name="nominee[id][]"';
        addNominee += '                            id="nomineeId_' + (count) + '"';
        addNominee += '                            class="form-control form-control-sm"';
        addNominee += '                            value="">';
        addNominee += '                        <input type="hidden"';
        addNominee += '                            name="nominee[thana][]"';
        addNominee += '                            id="nomineeThana_' + (count) + '"';
        addNominee += '                            class="form-control form-control-sm"';
        addNominee += '                            value="">';
        addNominee += '                        <input type="hidden"';
        addNominee += '                            name="nominee[upazilla][]"';
        addNominee += '                            id="nomineeUpazilla_' + (count) + '"';
        addNominee += '                            class="form-control form-control-sm"';
        addNominee += '                            value="">';
        addNominee += '                        <input type="hidden"';
        addNominee += '                            name="nominee[designation][]"';
        addNominee += '                            id="nomineeDesignation_' + (count) + '"';
        addNominee += '                            class="form-control form-control-sm"';
        addNominee += '                            value="">';
        addNominee += '                        <input type="hidden"';
        addNominee += '                            name="nominee[organization][]"';
        addNominee += '                            id="nomineeOrganization_' + (count) + '"';
        addNominee += '                            class="form-control form-control-sm"';
        addNominee += '                            value="">';
        addNominee += '                    </div>';
        addNominee += '                </div>';
        addNominee += '                <div class="col-md-6">';
        addNominee += '                    <div class="form-group">';
        addNominee += '                        <label for="nomineePhn_' + (count) + '"';
        addNominee +=
            '                            class="control-label"><span style="color:#FF0000">*</span>মোবাইল</label>';
        addNominee += '                        <input name="nominee[phn][]"';
        addNominee += '                            id="nomineePhn_' + (count) + '"';
        addNominee +=
            '                            class="form-control form-control-sm phone validation "';
        addNominee += '                            value="" placeholder="ইংরেজিতে দিতে হবে">';
        addNominee += ' <div class="required_message hide">This Field is required</div>';
        addNominee += '                    </div>';
        addNominee += '                </div>';
        addNominee += '            </div>';
        addNominee += '            </div>';

        addNominee += '            <div class="row">';
        addNominee += '                <div class="col-md-6">';
        addNominee += '                    <div class="form-group">';
        addNominee += '                        <label for="nomineeNid_' + (count) + '"';
        addNominee += '                            class="control-label"><span';
        addNominee += '                                style="color:#FF0000">*</span>জাতীয়';
        addNominee += '                            পরিচয় পত্র</label>';
        addNominee += '                        <input name="nominee[nid][]"';
        addNominee += '                            id="nomineeNid_' + (count) + '"';
        addNominee +=
            '                            class="form-control form-control-sm validation nid_data_pull_warning email"';
        addNominee += '                            value=""  readonly>';
        addNominee += ' <div class="required_message hide">This Field is required</div>';
        addNominee += '                    </div>';
        addNominee += '                </div>';
        addNominee += '                <div class="col-md-6">';
        addNominee += '                    <div class="form-group">';
        addNominee += '                        <label for="nomineeGender_' + (count) + '"';
        addNominee += '                            class="control-label">লিঙ্গ</label>';

        addNominee += '                        <select style="width: 100%;"';
        addNominee += '                            class="selectDropdown form-control"';
        addNominee += '                            name="nominee[gender][]"';
        addNominee += '                            id="nomineeGender_' + (count) + '">';

        addNominee += '                            <option value="MALE">';
        addNominee += '                                পুরুষ</option>';
        addNominee += '                            <option value="FEMALE">';
        addNominee += '                                নারী</option>';
        addNominee += '                        </select>';
        addNominee += '                    </div>';
        addNominee += '                </div>';
        addNominee += '            </div>';
        addNominee += '            <div class="row">';
        addNominee += '                <div class="col-md-6">';
        addNominee += '                    <div class="form-group">';
        addNominee += '                        <label for="nomineeFather_' + (count) + '"';
        addNominee += '                            class="control-label"><span';
        addNominee += '                                style="color:#FF0000"></span>পিতার';
        addNominee += '                            নাম</label>';
        addNominee += '                        <input name="nominee[father][]"';
        addNominee += '                            id="nomineeFather_' + (count) + '"';
        addNominee += '                            class="form-control form-control-sm"';
        addNominee += '                            value=""  readonly>';
        addNominee += '                    </div>';
        addNominee += '                </div>';
        addNominee += '                <div class="col-md-6">';
        addNominee += '                    <div class="form-group">';
        addNominee += '                        <label for="nomineeMother_' + (count) + '"';
        addNominee += '                            class="control-label"><span';
        addNominee += '                                style="color:#FF0000"></span>মাতার';
        addNominee += '                            নাম</label>';
        addNominee += '                        <input name="nominee[mother][]"';
        addNominee += '                            id="nomineeMother_' + (count) + '"';
        addNominee += '                            class="form-control form-control-sm"';
        addNominee += '                            value=""  readonly>';
        addNominee += '                    </div>';
        addNominee += '                </div>';
        addNominee += '            </div>';
        addNominee += '            <div class="row">';
        addNominee += '                <div class="col-md-6">';
        addNominee += '                    <div class="form-group">';
        addNominee += '                        <label for="nomineeAge_' + (count) + '"';
        addNominee += '                            class="control-label"><span';
        addNominee += '                                style="color:#FF0000"></span>বয়স</label>';
        addNominee += '                        <input name="nominee[age][]"';
        addNominee += '                            id="nomineeAge_' + (count) + '"';
        addNominee += '                            class="form-control form-control-sm"';
        addNominee += '                            value="">';
        addNominee += '                    </div>';
        addNominee += '                </div>';
        addNominee += '                <div class="col-md-6">';
        addNominee += '                    <div class="form-group">';
        addNominee += '          <label for="nomineePresentAddree_' + (count) + '"><span';
        addNominee += '                                style="color:#FF0000">*';
        addNominee += '                            </span>ইমেইল</label>';

        addNominee += '<input type="email" name="nominee[email][]" id="nomineeEmail_' + (
                count) +
            '" class="form-control form-control-sm email validation " value="">';
        addNominee += ' <div class="required_message hide">This Field is required</div>';
        addNominee += '                    </div>';

        addNominee += '            </div>';

        addNominee += '         <div class="row">';

        addNominee += '         </div>';
        addNominee += '         <div class="col-md-12">';
        addNominee += '          <div class="form-group">';
        addNominee += '          <label for="nomineePresentAddree_' + (count) + '"><span';
        addNominee += '                                style="color:#FF0000">*';
        addNominee += '                            </span>বর্তমান ঠিকানা</label>';
        addNominee += '                        <textarea id="nomineePresentAddree_' + (count) + '"';
        addNominee += '                            name="nominee[presentAddress][]" rows="3"';
        addNominee +=
            '                            class="form-control element-block blank validation nid_data_pull_warning"';
        addNominee += '                            aria-describedby="note-error"';
        addNominee +=
            '                            aria-invalid="false"  readonly></textarea>';
        addNominee += ' <div class="required_message hide">This Field is required</div>';
        addNominee += '         </div>';
        addNominee += '         </div>';


        addNominee += '         <div class="col-md-12">';
        addNominee += '          <div class="form-group">';
        addNominee += '          <label for="nomineePermanentAddree_' + (count) + '"><span';
        addNominee += '                                style="color:#FF0000">*';
        addNominee += '                            </span> স্থায়ী ঠিকানা</label>';
        addNominee += '                        <textarea id="nomineePermanentAddress_' + (count) + '"';
        addNominee += '                            name="nominee[permanentAddress][]" rows="3"';
        addNominee +=
            '                            class="form-control element-block blank validation nid_data_pull_warning"';
        addNominee += '                            aria-describedby="note-error"';
        addNominee +=
            '                            aria-invalid="false"  readonly></textarea>';
        addNominee += ' <div class="required_message hide">This Field is required</div>';
        addNominee += '         </div>';
        addNominee += '         </div>';



        addNominee += '</div></div></div></div>';






        // console.log(addNominee);
        $('#nomineeInfo #collapseOne3').append(addNominee);

    });


    function NIDCHECKnominee(id) {
        var Id = '#' + id;
        //alert(id);
        var element = document.getElementById(id);
        var row_index_nominee = element.dataset.nomineerowIndex;
        // alert(row_index_nominee);

        var nid_number = document.getElementById('nominee_nid_input_' + row_index_nominee).value;
        var dob_number = document.getElementById('nominee_dob_input_' + row_index_nominee).value;


        //swal.showLoading();

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

                    let gender = '';
                    let remove_alert = 100000;


                    $("#nomineeName_" + row_index_nominee).val('');
                    $("#nomineeName_" + row_index_nominee).removeClass(
                        'nid_data_pull_warning');
                    $("#nomineeName_" + row_index_nominee).prop('readonly', false);

                    $("#nomineeFather_" + row_index_nominee).val('');
                    $("#nomineeFather_" + row_index_nominee).prop('readonly', false);
                    $("#nomineeFather_" + row_index_nominee).removeClass(
                        'nid_data_pull_warning');

                    $("#nomineeMother_" + row_index_nominee).val('');
                    $("#nomineeMother_" + row_index_nominee).prop('readonly', false);
                    $("#nomineeMother_" + row_index_nominee).removeClass(
                        'nid_data_pull_warning');

                    $("#nomineePresentAddree_" + row_index_nominee).text('');
                    $("#nomineePresentAddree_" + row_index_nominee).prop('readonly',
                        false);
                    $("#nomineePresentAddree_" + row_index_nominee).removeClass(
                        'nid_data_pull_warning');
                        $("#nomineePermanentAddress_" + row_index_nominee).text(response
                        .present_address);
                    $("#nomineePermanentAddress_" + row_index_nominee).prop('readonly',
                    false);
                    $("#nomineePermanentAddress_" + row_index_nominee).removeClass(
                        'nid_data_pull_warning');    

                    $("#nomineeGender_" + row_index_nominee).find(':selected').removeAttr(
                        'selected');
                    $("#nomineeGender_" + row_index_nominee).find(':disabled').removeAttr(
                        'disabled');


                    $("#nomineeNid_" + row_index_nominee).val('');
                    $("#nomineeNid_" + row_index_nominee).prop(
                        'readonly', false);
                    $("#nomineeNid_" + row_index_nominee)
                        .removeClass('nid_data_pull_warning');
                    $("#edit_defaulter_email_" + row_index_nominee).val('');

                } else if (response.success == 'success') {

                    Swal.fire({
                        icon: 'success',
                        text: response.message,

                    });

                    let opposite_gender = ' ';

                    if (response.gender == 'MALE') {
                        opposite_gender = 'FEMALE';
                    } else {
                        opposite_gender = 'MALE';
                    }

                    $("#nomineeName_" + row_index_nominee).val(response.name_bn);

                    $("#nomineeName_" + row_index_nominee).addClass(
                        "nid_data_pull_warning")

                    $("#nomineeName_" + row_index_nominee).prop('readonly', true);

                    $("#nomineeGender_" + row_index_nominee).find('option[value="' +
                        response.gender + '"]').attr('selected', 'selected');

                    $("#nomineeGender_" + row_index_nominee).find('option[value="' +
                        opposite_gender + '"]').attr('disabled', 'disabled');

                    $("#nomineeFather_" + row_index_nominee).val(response.father);
                    $("#nomineeFather_" + row_index_nominee).prop('readonly', true);
                    $("#nomineeFather_" + row_index_nominee).addClass(
                        'nid_data_pull_warning');

                    $("#nomineeMother_" + row_index_nominee).val(response.mother);
                    $("#nomineeMother_" + row_index_nominee).prop('readonly', true);
                    $("#nomineeMother_" + row_index_nominee).addClass(
                        'nid_data_pull_warning');

                    $("#nomineeNid_" + row_index_nominee).val(response.national_id);
                    $("#nomineeNid_" + row_index_nominee).prop(
                        'readonly', true);
                    $("#nomineeNid_" + row_index_nominee)
                        .addClass('nid_data_pull_warning');

                    $("#nomineePresentAddree_" + row_index_nominee).text(response
                        .present_address);
                    $("#nomineePresentAddree_" + row_index_nominee).prop('readonly',
                        true);
                    $("#nomineePresentAddree_" + row_index_nominee).addClass(
                        'nid_data_pull_warning');
                     
                    $("#nomineePermanentAddress_" + row_index_nominee).text(response
                        .present_address);
                    $("#nomineePermanentAddress_" + row_index_nominee).prop('readonly',
                        true);
                    $("#nomineePermanentAddress_" + row_index_nominee).addClass(
                        'nid_data_pull_warning');

                        
                    $("#edit_defaulter_email_" + row_index_nominee).val(response.email);

                    $('#defaulter_withness_change').val('has_changed');

                }
            }
        });

    }

    $(document).on('click', '.nid_data_pull_warning', function() {

        Swal.fire(
            '',
            'অনুগ্রহ পূর্বক সংশ্লিষ্ট ব্যাক্তির জাতীয় পরিচয়পত্র নম্বর এবং জন্ম তারিখ প্রদান করুন ( ফর্ম এর উপরের দিকে দেখুন )। জাতীয় পরিচয়পত্র থেকে পিতার নাম, মাতার নাম, লিঙ্গ, ঠিকানা পেয়ে যাবেন যা পরিবর্তনযোগ্য নয় । তবে জাতীয় পরিচয়পত্র নম্বর এবং জন্ম তারিখ প্রদান করার পরেও যদি আপনার তথ্য না আসে সেক্ষেত্রে আপনি তথ্য গুলো টাইপ করে দিতে পারবেন',
            'question'


        )

    });

