<script>
// ========== Form Submission ========= Start =========
function myFunction() {
    Swal.fire({
        title: "আপনি কি সংরক্ষণ করতে চান?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "হ্যাঁ",
        cancelButtonText: "না",
    })
    .then(function(result) {
        if (result.value) {
            // setTimeout(() => {
            $('form#appealCase').submit();
            // }, 5000);
            KTApp.blockPage({
                // overlayColor: '#1bc5bd',
                overlayColor: 'black',
                opacity: 0.2,
                // size: 'sm',
                message: 'Please wait...',
                state: 'danger' // a bootstrap color
            });
            Swal.fire({
                position: "top-right",
                icon: "success",
                title: "সফলভাবে সাবমিট করা হয়েছে!",
                showConfirmButton: false,
                timer: 1500,
            });
            // toastr.success("সফলভাবে সাবমিট করা হয়েছে!", "Success");
        }
    });
}
function formSubmit() {
    $('#status').val('SEND_TO_GCO');
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
function primaryNote(){
    var organaization = $('#applicantOrganization_1').val() ? $('#applicantOrganization_1').val() : "প্রতিষ্ঠানের নাম ";
    var case_date = $('#case_date').val() ? $('#case_date').val() : ' তারিখ ';
    case_date = NumToBangla.replaceNumbers(case_date);
    var defaulterName = $('#defaulterName_1').val() ? $('#defaulterName_1').val() : ' খাতকের নাম ';
    var totalLoanAmount = $('#totalLoanAmount').val() ? $('#totalLoanAmount').val() : '  টাকার পরিমাণ ';
    totalLoanAmount = NumToBangla.replaceNumbers(totalLoanAmount);
    var totalLoanAmountText = $('#totalLoanAmountText').val() ? $('#totalLoanAmountText').val() : '';
    var lawSection = $('#lawSection').val() ? $('#lawSection').val() : ' সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫ ধারা ';
    var GenActivitiesDefault = organaization + " হতে " + case_date +" তারিখে " + defaulterName + " এর নিকট হতে "+totalLoanAmount+ " (" + totalLoanAmountText + ") টাকা আদায়ের জন্য " + lawSection + " মতে একটি অনুরোধপত্র পাওয়া গিয়েছে। \n\nদেখলাম। দাবী আদায়যোগ্য বিবেচিত হওয়ায় ১০ নং রেজিস্টার বহিতে লিপিবদ্ধ করে সার্টিফিকেট রিকুইজিশনে স্বাক্ষর করা হল। সার্টিফিকেট খাতকের প্রতি ১০(ক) ধারার নোটিশ জারি করা হোক। আগামি (০১ মাসের  মধ্যে) প্রসেস সার্ভারকে নোটিশ জারির এস আর দাখিল করার জন্য বলা হল।";
    // var activitiesDefault = "প্রতিষ্ঠানের নাম হতে তারিখে খাতকের নাম এর নিকট হতে টাকার পরিমাণ টাকা আদায়ের জন্য সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫ ধারা মতে একটি অনুরোধপত্র পাওয়া গিয়েছে। <br/> দেখলাম। দাবী আদায়যোগ্য বিবেচিত হওয়ায় ১০ নং রেজিস্টার বহিতে লিপিবদ্ধ করে সার্টিফিকেট রিকুইজিশনে স্বাক্ষর করা হল। সার্টিফিকেট খাতকের প্রতি ১০(ক) ধারার নোটিশ জারি করা হোক। আগামি (০১ মাসের  মধ্যে) প্রসেস সার্ভারকে নোটিশ জারির এস আর দাখিল করার জন্য বলা হল।";
    $('#note').val(GenActivitiesDefault);
}
$("#applicantOrganization_1").change(function(){
    primaryNote();
});
$("#case_date").change(function(){
    primaryNote();
});
$("#defaulterName_1").change(function(){
    primaryNote();
});
$("#totalLoanAmount").change(function(){
    setTimeout(function(){
        primaryNote();
    },2000);
});
$("#totalLoanAmountText").change(function(){
    primaryNote();
});
$("#lawSection").change(function(){
    primaryNote();
});
// ================= Activities ========= end =========

// ============= Add Attachment Row ========= start =========
$("#addFileRow").click(function(e) {
    addFileRowFunc();
});
//add row function
function addFileRowFunc() {
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
}
//Attachment Title Change
function attachmentTitle(id) {
    var value = $('#customFile' + id).val();
    $('.custom-input' + id).text(value);
}
//remove Attachment
function removeBibadiRow(id) {
    $(id).closest("tr").remove();
}
// =============== Add Attachment Row ===================== end =========================

// Number to Bangla Word ========================= start ====================
$("#totalLoanAmount").change(function(){
    var num = parseInt($("#totalLoanAmount").val());
    if(num.toString().length < 16) {
        $("#totalLoanAmountText").val(NumToBangla.convert(num));
    } else{
    toastr.error('টাকার পরিমাণ অনেক দীর্ঘ', "Error");
    }
});
// Number to Bangla Word ========================= end ====================

// Multiple Nominee ================================= start ==============================
        //remove Nominee
        $("#RemoveNominee").on('click', function() {
            var chXou = $("#accordionExample3").children().length;
            if (chXou != 1) {
                $("#accordionExample3 .card:last").remove();
                // var chXou1 = $("#accordionExample3 .card:last").html();
                // console.log(chXou1);
            } else {
                console.log('fasle');
            }
        });
        //add Nominee
        $("#AddNominee").on('click', function() {
            var count = parseInt($('#NomineeCount').val());
            $('#NomineeCount').val(count + 1);
            var addNominee = '';
            addNominee += '<div id="cloneNomenee" class="card">';
            addNominee += '<div class="card-header" id="headingOne3">';
            addNominee +=
                '    <div class="card-title collapsed h4" data-toggle="collapse" data-target="#collapseOne' +
                count + '">';
            addNominee += '        উত্তরাধিকারীর তথ্য &nbsp; <span id="spannCount">(' + (count + 1) + ')</span>';
            addNominee += '    </div>';
            addNominee += '</div>';
            addNominee += '<div id="collapseOne' + count + '" class="collapse" data-parent="#accordionExample3">';
            addNominee += '    <div class="card-body">';
            addNominee += '        <div class="clearfix">';
            addNominee += '            <div class="row">';
            addNominee += '      <div class="col-md-12">';
            addNominee += '           <div class="text-dark font-weight-bold h4">';
            addNominee += '                <label for="">নাগরিক সন্ধান করুন </label>';
            addNominee += '                </div>';
            addNominee += '            </div>';
            addNominee += '            <div class="col-md-6">';
            addNominee += '                <div class="form-group">';
            addNominee += '                    <input required type="text" id="nomineeCiNID_'+ (count + 1) +'" class="form-control" placeholder="Enter NID No." name="nominee[ciNID][]">';
            addNominee += '                </div>';
            addNominee += '            </div>';
            addNominee += '            <div class="col-md-6">';
            addNominee += '                <div class="form-group">';
            addNominee += '                    <input required type="text" id="nomineeDob_'+ (count + 1) +'" name="nominee[dob][]" placeholder="Enter Date of Birth" id="dob" class="form-control common_datepicker" autocomplete="off">';
            addNominee += '                </div>';
            addNominee += '            </div>';
            addNominee += '            <div class="col-md-12">';
            addNominee += '                <div class="form-group">';
            addNominee += '                    <input type="button" name="nomineeCCheck_'+ (count + 1) +'" name="nominee[cCheck][]" onclick="checkNomineeCitizen(\'nominee\', '+ (count + 1) +')" class="btn btn-danger" value="নাগরিকের তথ্য সন্ধান করুন"> <span class="ml-5" id="res_nominee_'+ (count + 1) +'"></span>';
            addNominee += '                </div>';
            addNominee += '          </div>';
            addNominee += '                <div class="col-md-6">';
            addNominee += '                    <div class="form-group">';
            addNominee += '                        <label for="nomineeName_'+ (count + 1) +'"';
            addNominee += '                            class="control-label"><span';
            addNominee += '                                style="color:#FF0000"></span>উত্তরাধিকারীর';
            addNominee += '                            নাম</label>';
            addNominee += '                        <input name="nominee[name][]"';
            addNominee += '                            id="nomineeName_'+ (count + 1) +'"';
            addNominee += '                            class="form-control form-control-sm"';
            addNominee += '                            value="">';
            addNominee += '                        <input type="hidden"';
            addNominee += '                            name="nominee[type][]"';
            addNominee += '                            class="form-control form-control-sm"';
            addNominee += '                            value="5">';
            addNominee += '                        <input type="hidden"';
            addNominee += '                            name="nominee[id][]"';
            addNominee += '                            id="nomineeId_'+ (count + 1) +'"';
            addNominee += '                            class="form-control form-control-sm"';
            addNominee += '                            value="">';
            addNominee += '                        <input type="hidden"';
            addNominee += '                            name="nominee[email][]"';
            addNominee += '                            id="nomineeEmail_'+ (count + 1) +'"';
            addNominee += '                            class="form-control form-control-sm"';
            addNominee += '                            value="">';
            addNominee += '                        <input type="hidden"';
            addNominee += '                            name="nominee[thana][]"';
            addNominee += '                            id="nomineeThana_'+ (count + 1) +'"';
            addNominee += '                            class="form-control form-control-sm"';
            addNominee += '                            value="">';
            addNominee += '                        <input type="hidden"';
            addNominee += '                            name="nominee[upazilla][]"';
            addNominee += '                            id="nomineeUpazilla_'+ (count + 1) +'"';
            addNominee += '                            class="form-control form-control-sm"';
            addNominee += '                            value="">';
            addNominee += '                        <input type="hidden"';
            addNominee += '                            name="nominee[designation][]"';
            addNominee += '                            id="nomineeDesignation_'+ (count + 1) +'"';
            addNominee += '                            class="form-control form-control-sm"';
            addNominee += '                            value="">';
            addNominee += '                        <input type="hidden"';
            addNominee += '                            name="nominee[organization][]"';
            addNominee += '                            id="nomineeOrganization_'+ (count + 1) +'"';
            addNominee += '                            class="form-control form-control-sm"';
            addNominee += '                            value="">';
            addNominee += '                    </div>';
            addNominee += '                </div>';
            addNominee += '                <div class="col-md-6">';
            addNominee += '                    <div class="form-group">';
            addNominee += '                        <label for="nomineePhn_'+ (count + 1) +'"';
            addNominee += '                            class="control-label">মোবাইল</label>';
            addNominee += '                        <input name="nominee[phn][]"';
            addNominee += '                            id="nomineePhn_'+ (count + 1) +'"';
            addNominee += '                            class="form-control form-control-sm"';
            addNominee += '                            value="">';
            addNominee += '                    </div>';
            addNominee += '                </div>';
            addNominee += '            </div>';
            addNominee += '            <div class="row">';
            addNominee += '                <div class="col-md-6">';
            addNominee += '                    <div class="form-group">';
            addNominee += '                        <label for="nomineeNid_'+ (count + 1) +'"';
            addNominee += '                            class="control-label"><span';
            addNominee += '                                style="color:#FF0000"></span>জাতীয়';
            addNominee += '                            পরিচয় পত্র</label>';
            addNominee += '                        <input name="nominee[nid][]"';
            addNominee += '                            id="nomineeNid_'+ (count + 1) +'"';
            addNominee += '                            class="form-control form-control-sm"';
            addNominee += '                            value="">';
            addNominee += '                    </div>';
            addNominee += '                </div>';
            addNominee += '                <div class="col-md-6">';
            addNominee += '                    <div class="form-group">';
            addNominee += '                        <label for="nomineeGender_'+ (count + 1) +'"';
            addNominee += '                            class="control-label">নারী /';
            addNominee += '                            পুরুষ</label>';
            addNominee += '                        <select style="width: 100%;"';
            addNominee += '                            class="selectDropdown form-control"';
            addNominee += '                            name="nominee[gender][]"';
            addNominee += '                            id="nomineeGender_'+ (count + 1) +'">';
            addNominee += '                            <option value="">';
            addNominee += '                                বাছাই করুন</option>';
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
            addNominee += '                        <label for="nomineeFather_'+ (count + 1) +'"';
            addNominee += '                            class="control-label"><span';
            addNominee += '                                style="color:#FF0000"></span>পিতার';
            addNominee += '                            নাম</label>';
            addNominee += '                        <input name="nominee[father][]"';
            addNominee += '                            id="nomineeFather_'+ (count + 1) +'"';
            addNominee += '                            class="form-control form-control-sm"';
            addNominee += '                            value="">';
            addNominee += '                    </div>';
            addNominee += '                </div>';
            addNominee += '                <div class="col-md-6">';
            addNominee += '                    <div class="form-group">';
            addNominee += '                        <label for="nomineeMother_'+ (count + 1) +'"';
            addNominee += '                            class="control-label"><span';
            addNominee += '                                style="color:#FF0000"></span>মাতার';
            addNominee += '                            নাম</label>';
            addNominee += '                        <input name="nominee[mother][]"';
            addNominee += '                            id="nomineeMother_'+ (count + 1) +'"';
            addNominee += '                            class="form-control form-control-sm"';
            addNominee += '                            value="">';
            addNominee += '                    </div>';
            addNominee += '                </div>';
            addNominee += '            </div>';
            addNominee += '            <div class="row">';
            addNominee += '                <div class="col-md-6">';
            addNominee += '                    <div class="form-group">';
            addNominee += '                        <label for="nomineeAge_'+ (count + 1) +'"';
            addNominee += '                            class="control-label"><span';
            addNominee += '                                style="color:#FF0000"></span>বয়স</label>';
            addNominee += '                        <input name="nominee[age][]"';
            addNominee += '                            id="nomineeAge_'+ (count + 1) +'"';
            addNominee += '                            class="form-control form-control-sm"';
            addNominee += '                            value="">';
            addNominee += '                    </div>';
            addNominee += '                </div>';
            addNominee += '                <div class="col-md-6">';
            addNominee += '                    <div class="form-group">';
            addNominee += '                        <label';
            addNominee += '                            for="nomineePresentAddree_'+ (count + 1) +'">ঠিকানা</label>';
            addNominee += '                        <textarea';
            addNominee += '                            id="nomineePresentAddree_'+ (count + 1) +'"';
            addNominee += '                            name="nominee[presentAddress][]"';
            addNominee += '                            rows="1"';
            addNominee += '                            class="form-control form-control-sm element-block blank"';
            addNominee += '                            aria-describedby="note-error"';
            addNominee += '                            aria-invalid="false"></textarea>';
            addNominee += '                    </div>';
            addNominee += '                </div>';
            addNominee += '            </div>';
            addNominee += '        </div>';
            addNominee += '    </div>';
            addNominee += '  </div>';
            addNominee += '</div>';

            // console.log(addNominee);
            $('#accordionExample3').append(addNominee);

        })
// Multiple Nominee ================================= End ==============================


// common datepicker =============== start
$('.common_datepicker').datepicker({
    format: "dd/mm/yyyy",
    todayHighlight: true,
    orientation: "bottom left"
});
// common datepicker =============== end

</script>
