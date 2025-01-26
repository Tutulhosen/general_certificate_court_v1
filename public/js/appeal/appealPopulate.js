! function(e) {
    function t(n) { if (a[n]) return a[n].exports; var p = a[n] = { i: n, l: !1, exports: {} }; return e[n].call(p.exports, p, p.exports, t), p.l = !0, p.exports }
    var a = {};
    t.m = e, t.c = a, t.d = function(e, a, n) { t.o(e, a) || Object.defineProperty(e, a, { configurable: !1, enumerable: !0, get: n }) }, t.n = function(e) { var a = e && e.__esModule ? function() { return e.default } : function() { return e }; return t.d(a, "a", a), a }, t.o = function(e, t) { return Object.prototype.hasOwnProperty.call(e, t) }, t.p = "", t(t.s = 173)
}({
    173: function(e, t, a) { e.exports = a(174) },
    174: function(e, t) {
        appealPopulate = e.exports = {
            token: $("meta[name=csrf-token]").attr("content"),
            getUserZillaInfo: function() {
                return $.ajax({
                    headers: { "X-CSRF-Token": this.token },
                    url: "/appeal/get/login_user_zilla",
                    method: "GET",
                    dataType: "json"
                })
            },
            getCaseDecisionList: function() {
                return $.ajax({
                    headers: { "X-CSRF-Token": this.token },
                    url: "/appeal/get/case_decision",
                    method: "GET",
                    dataType: "json"
                })
            },
            getAdmList: function() {
                return $.ajax({
                    headers: { "X-CSRF-Token": this.token },
                    url: "/appeal/get/adm",
                    method: "GET",
                    dataType: "json"
                })
            },
            getThanaList: function() {
                return $.ajax({
                    headers: { "X-CSRF-Token": this.token },
                    url: "/appeal/get/thana",
                    method: "GET",
                    dataType: "json"
                })
            },
            getUpazillaList: function() {
                return $.ajax({
                    headers: { "X-CSRF-Token": this.token },
                    url: "/appeal/get/upazilla",
                    method: "GET",
                    dataType: "json"
                })
            },
            getDmList: function() {
                return $.ajax({
                    headers: { "X-CSRF-Token": this.token },
                    url: "/appeal/get/dm",
                    method: "GET",
                    dataType: "json"
                })
            },
            getGcoList: function() {
                return $.ajax({
                    headers: { "X-CSRF-Token": this.token },
                    url: "/appeal/get/gco",
                    method: "GET",
                    dataType: "json"
                })
            },
            getAppealInfo: function(e) {
                return $.ajax({
                    headers: { "X-CSRF-Token": this.token },
                    url: "/appeal/get",
                    method: "post",
                    data: { appealId: e },
                    dataType: "json"
                })
            },
            getShortOrderList: function() {
                // console.log('mianr getShortOrderList');
                return $.ajax({
                    headers: { "X-CSRF-Token": this.token },
                    url: "/appeal/get/shortorder/",
                    method: "get",
                    dataType: "json"
                })
            },
            hajiraPrintSectionDataPopulate: function() { $("#zilla").append($(".area-name").text()), $("#caseNumber").append($("#caseNo").text()), $("#applicantNameH").append($("#applicantName").text()), $("#applicantNameH").append("<br>" + $("#applicantDesignation").text()), $("#defaulterNameH").append($("#defaulterName").text()), $("#defaulterNameH").append("<br>" + $("#defaulterDesignation").text()) },
            initAppealTrial: function() {
                var e = $("#appealId").val(),
                    t = "";
                e ? appealPopulate.getAppealInfo(e).done(function(e, a, n) {
                    null != e.data.citizenAttendance[0] && ($("#applicantCitizenAttendanceId").val(e.data.citizenAttendance[0].id), $("#citizenAttendanceApplicantCitizenId").val(e.data.citizenAttendance[0].citizen_id), "ABSENT" == e.data.citizenAttendance[0].attendance ? $("#applicantAttendanceAbsent").attr("checked", !0) : ($("#applicantAttendanceAbsent").attr("checked", !1), $("#applicantAttendancePresent").attr("checked", !0)), $("#defaulterCitizenAttendanceId").val(e.data.citizenAttendance[1].id), $("#citizenAttendanceDefaulterCitizenId").val(e.data.citizenAttendance[1].citizen_id), "ABSENT" == e.data.citizenAttendance[1].attendance ? $("#defaulterAttendanceAbsent").attr("checked", !0) : ($("#defaulterAttendanceAbsent").attr("checked", !1), $("#defaulterAttendancePresent").attr("checked", !0)));
                    e.data.appealCauseList.length;
                    var p = e.data.notApprovedShortOrderCauseList;
                    appealUiUtils.populateAppealSpanInfo(e), e.data.approvedNoteCauseList.length > 0 && ($("#approvedNoteOrderList").removeClass("hidden"), appealUiUtils.appendNotes(e.data.appeal, e.data.approvedNoteCauseList, e.data.attachmentList)), e.data.notApprovedNoteCauseList.length > 0 && (t = e.data.notApprovedNoteCauseList[0].order_text + "\n\n", $("#noteId").val(e.data.notApprovedNoteCauseList[0].noteId), $("#causeListId").val(e.data.notApprovedNoteCauseList[0].cause_list_id)), e.data.attachmentList.length > 0 && appealUiUtils.appendAttachmentsForView(e.data.attachmentList), appealUiUtils.setInitialTrialOrderText(t), appealPopulate.getShortOrderList().done(function(e, t, a) { appealUiUtils.appendShortOrderCheckBox(e.shortOrderList, p) }), appealPopulate.hajiraPrintSectionDataPopulate()
                }).fail(function() { $.alert("ত্রুটি ", "অবহিতকরণ বার্তা") }) : $.alert("তথ্য পাওয়া যায়নি ", "অবহিতকরণ বার্তা")
            },
            initAppealInitiate: function() {
                var e = $("#appealId").val();
                $("#iFrameContainer").hide(),
                    e ? appealPopulate.getAppealInfo(e).done(function(e, t, a) {
                        appealUiUtils.populateAppealInitiateInfo(e), appealUiUtils.setCauseListInfo(e.data.appealCauseList),
                            appealUiUtils.setNoteInfo(e.data.appealNote, e.data.appeal), "OLD" == e.data.appeal.case_entry_type && ($("#old").prop("checked", !0).trigger("click"), $("#previouscaseNo").val(e.data.appeal.prev_case_no)), appealUiUtils.populateDropDown(e.data.gcoList, $("#gcoList"), "বাছাই করুন...", e.data.appeal.gco_user_id, "username", "name_bng"), $.each(e.gcoList, function(e, t) { $("#gcoList").val(t.username).trigger("change.select2") }), "" != e.data.attachmentList && appealUiUtils.appendAttachmentsForViewAndDelete(e.data.attachmentList)
                    }).fail(function() { $.alert("ত্রুটি ", "অবহিতকরণ বার্তা") }) : (appealPopulate.getGcoList().done(function(e, t, a) {
                        var n = $("#officeId").val(),
                            p = [];
                        $.each(e.gcoList, function(e, t) { t.office_id == n && p.push(t) }), appealUiUtils.populateDropDown(p, $("#gcoList"), "বাছাই করুন...", "", "username", "name_bng")
                    }), appealUiUtils.setInitialNoteTemplate("", "", "", ""), $("#caseNo").text("সিস্টেম কর্তৃক পূরণকৃত"))
            }
        }
    }
});