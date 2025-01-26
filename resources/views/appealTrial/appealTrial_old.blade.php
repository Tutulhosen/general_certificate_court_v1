
@extends('layouts.default')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                {{-- layouts/sidemenu.blade.php --}}
                {{-- @include('layouts.sidemenu') --}}
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <strong class="panel-title pull-left">@lang('message.headingAppealTrialForm')</strong>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div class="panel panel-info radius-none">
                            <div class="panel-heading radius-none">
                                <h4 class="panel-title">@lang('message.caseInformationBlockHeading')</h4>
                            </div>
                            <div class="panel-body">
                                <div class="clearfix">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="caseEntryType" class="control-label">@lang('message.caseEntryType')</label>
                                                    <span type="text" name="caseEntryType" id="caseEntryType" class="form-control" value=""></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="prevCaseDiv">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="previouscaseNo" class="control-label">@lang('message.previous') @lang('message.caseNo')</label>
                                                    <span type="text" name="previouscaseNo" id="previouscaseNo" class="form-control" value=""></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="caseNo" class="control-label">@lang('message.caseNo')</label>
                                                <span name="caseNo" id="caseNo" class="form-control"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="caseDate" class="control-label">@lang('message.date')</label>
                                                <span name="caseDate" id="caseDate" class="form-control"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="lawSection" class="control-label">@lang('message.lawSection')</label>
                                                <span name="lawSection" id="lawSection" class="form-control" value=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="totalLoanAmount" class="control-label"><span style="color:#FF0000">* </span>@lang('message.totalLoanAmount')</label>
                                                <span  type="text" name="totalLoanAmount" id="totalLoanAmount" class="form-control" value=""></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="totalLoanAmountText" class="control-label">@lang('message.totalLoanAmountText')</label>
                                                <span readonly="readonly" type="text" name="totalLoanAmountText" id="totalLoanAmountText" class="form-control" value=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="row">--}}
                                        {{--<div class="col-md-6">--}}
                                            {{--<div class="form-group">--}}
                                                {{--<label for="lawSection" class="control-label">@lang('message.lawSection')</label>--}}
                                                {{--<span name="lawSection" id="lawSection" class="form-control" value=""></span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-6">--}}
                                            {{--<div class="form-group">--}}
                                                {{--<label for="totalLoanAmount" class="control-label">@lang('message.totalLoanAmount')</label>--}}
                                                {{--<span type="text" name="totalLoanAmount" id="totalLoanAmount" class="form-control" value="" ></span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                </div>
                            </div>
                        </div>
                        <section class="" id="tabs">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tabs-info" role="tablist">
                                <li class="active"><a href="#t1" aria-controls="t1" role="tab" data-toggle="tab"><h4 class="panel-title">@lang('message.applicantBlockHeading')</h4></a></li>
                                <li><a href="#t2" aria-controls="t2" role="tab" data-toggle="tab"><h4 class="panel-title">@lang('message.defaulterBlockHeading')</h4></a></li>
                                <li><a href="#t3" aria-controls="t3" role="tab" data-toggle="tab"><h4 class="panel-title">@lang('message.guarantorBlockHeading')</h4></a></li>
                                <li><a href="#t4" aria-controls="t4" role="tab" data-toggle="tab"><h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4></a></li>
                                <li><a href="#t5" aria-controls="t5" role="tab" data-toggle="tab"><h4 class="panel-title">@lang('message.nomineeBlockHeading')</h4></a></li>
                                <li><a href="#t6" aria-controls="t6" role="tab" data-toggle="tab"><h4 class="panel-title">@lang('message.policeBlockHeading')</h4></a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="t1">
                                    <div class="panel panel-info radius-none">

                                        <div class="panel-body bg-info">
                                            <div class="clearfix">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantName_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.applicant')</label>
                                                            <span name="citizen[1][1][name]" id="applicantName_1" class="form-control" value="" ></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantDesignation_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.designation')</label>
                                                            <span name="citizen[1][1][designation]" id="applicantDesignation_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="applicantType" class="control-label">@lang('message.organizationType')</label>
                                                            <span class="form-control" id="applicantType"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="applicantGender_1" class="control-label">@lang('message.gender')</label>
                                                            <span class="form-control" id="applicantGender_1"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantOrganization_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.organization')</label>
                                                            <span name="citizen[1][1][organization]" id="applicantOrganization_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantFather_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.father')</label>
                                                            <span name="citizen[1][1][father]" id="applicantFather_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantMother_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.mother')</label>
                                                            <span name="citizen[1][1][mother]" id="applicantMother_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantNid_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.nid')</label>
                                                            <span name="citizen[1][1][nid]" id="applicantNid_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantPhn_1" class="control-label">@lang('message.phn')</label>
                                                            <span name="citizen[1][1][phn]" id="applicantPhn_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="applicantPresentAddree_1">@lang('message.organizationAddress')</label>
                                                            <div id="applicantPresentAddree_1" style="min-height:100px" name="citizen[1][1][presentAddress]" class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="t2">
                                    <div class="panel panel-info radius-none ">
                                        <div class="panel-body bg-info">
                                            <div class="clearfix">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="defaulterName_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.defaulter')</label>
                                                            <span name="citizen[2][1][name]" id="defaulterName_1" class="form-control" value=""  ></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="defaulterPhn_1" class="control-label">@lang('message.phn')</label>
                                                            <span name="citizen[2][1][phn]" id="defaulterPhn_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="defaulterNid_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.nid')</label>
                                                            <span name="citizen[2][1][nid]" id="defaulterNid_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="defaulterGender_1" class="control-label">@lang('message.gender')</label>
                                                            <span class="form-control" id="defaulterGender_1"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="defaulterFather_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.father')</label>
                                                            <span name="citizen[2][1][father]" id="defaulterFather_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="defaulterMother_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.mother')</label>
                                                            <span name="citizen[2][1][mother]" id="defaulterMother_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="defaulterDesignation_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.designation')</label>
                                                            <span name="citizen[2][1][designation]" id="defaulterDesignation_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="defaulterOrganization_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.organization')</label>
                                                            <span name="citizen[2][1][organization]" id="defaulterOrganization_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="defaulterPresentAddree_1">@lang('message.businessAddress')</label>
                                                            <div id="defaulterPresentAddree_1" name="citizen[2][1][presentAddress]" style="min-height:100px" class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="t3">
                                    <div class="panel panel-info radius-none ">
                                        <div class="panel-body bg-info">
                                            <div class="clearfix">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="guarantorName_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.guarantor')</label>
                                                            <span name="citizen[3][1][name]" id="guarantorName_1" class="form-control" value=""  ></span>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="guarantorPhn_1" class="control-label">@lang('message.phn')</label>
                                                            <span name="citizen[3][1][phn]" id="guarantorPhn_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="guarantorNid_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.nid')</label>
                                                            <span name="citizen[3][1][nid]" id="guarantorNid_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="guarantorGender_1" class="control-label">@lang('message.gender')</label>
                                                            <span class="form-control"  id="guarantorGender_1"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="guarantorFather_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.father')</label>
                                                            <span name="citizen[3][1][father]" id="guarantorFather_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="guarantorMother_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.mother')</label>
                                                            <span name="citizen[3][1][mother]" id="guarantorMother_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="guarantorDesignation_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.designation')</label>
                                                            <span name="citizen[3][1][designation]" id="guarantorDesignation_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="guarantorOrganization_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.organization')</label>
                                                            <span name="citizen[3][1][organization]" id="guarantorOrganization_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="guarantorPresentAddree_1">@lang('message.presentAddress')</label>
                                                            <div id="guarantorPresentAddree_1" name="citizen[3][1][presentAddress]" style="min-height:100px" class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="t4">
                                    <div class="panel panel-info radius-none ">

                                        <div class="panel-body bg-info">
                                            <div class="clearfix">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerName_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.lawyer')</label>
                                                            <span name="citizen[4][1][name]" id="lawyerName_1" class="form-control" value="" ></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerPhn_1" class="control-label">@lang('message.phn')</label>
                                                            <span name="citizen[4][1][phn]" id="lawyerPhn_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerNid_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.nid')</label>
                                                            <span name="citizen[4][1][nid]" id="lawyerNid_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerGender_1" class="control-label">@lang('message.gender')</label>
                                                            <span class="form-control" id="lawyerGender_1"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerFather_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.father')</label>
                                                            <span name="citizen[4][1][father]" id="lawyerFather_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerMother_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.mother')</label>
                                                            <span name="citizen[4][1][mother]" id="lawyerMother_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerDesignation_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.designation')</label>
                                                            <span name="citizen[4][1][designation]" id="lawyerDesignation_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerOrganization_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.organization')</label>
                                                            <span name="citizen[4][1][organization]" id="lawyerOrganization_1" class="form-control" value=""></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="lawyerPresentAddree_1">@lang('message.presentAddress')</label>
                                                            <div id="lawyerPresentAddree_1" name="citizen[4][1][presentAddress]" style="min-height:100px" class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="t5">
                                    <div class="panel panel-info radius-none ">
                                        {{--<div class="panel-heading radius-none">--}}
                                        {{--<h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4>--}}
                                        {{--</div>--}}
                                        <div style="margin: 10px" id="accordion" role="tablist" aria-multiselectable="true" class="panel-group">
                                            <section class="panel panel-primary nomineeInfo" id="nomineeInfo">
                                                <div class="panel-heading" role="tab" id="headOne">
                                                    <h4 class="panel-title">
                                                        <a class="" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_1" aria-expanded="true">
                                                            (<span class="slNo">1</span>)  @lang('message.nomineeBlockHeading')<i class="fa fa-angle-down pull-right"></i>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_1" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
                                                    <div class="panel-body cpv p-10">
                                                        <div>
                                                            <div class="panel-body bg-info">
                                                                <div class="clearfix">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="nomineeName_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.nomineeName')</label>
                                                                                <span name="citizen[5][1][name]" id="nomineeName_1" class="form-control" value="" ></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="nomineePhn_1" class="control-label">@lang('message.phn')</label>
                                                                                <span name="citizen[5][1][phn]" id="nomineePhn_1" class="form-control" value=""></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="nomineeNid_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.nid')</label>
                                                                                <span name="citizen[5][1][nid]" id="nomineeNid_1" class="form-control" value=""></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="nomineeGender_1" class="control-label">@lang('message.gender')</label>
                                                                                <span id="nomineeGender_1" class="form-control"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="nomineeFather_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.father')</label>
                                                                                <span name="citizen[5][1][father]" id="nomineeFather_1" class="form-control" value=""></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="nomineeMother_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.mother')</label>
                                                                                <span name="citizen[5][1][mother]" id="nomineeMother_1" class="form-control" value=""></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="nomineeAge_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.age')</label>
                                                                                <span name="citizen[5][1][age]" id="nomineeAge_1" class="form-control" value=""></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="nomineePresentAddree_1">@lang('message.presentAddress')</label>
                                                                                <div id="nomineePresentAddree_1" name="citizen[5][1][presentAddress]" style="min-height:100px" class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="t6">
                                    <div class="panel panel-info radius-none ">
                                        {{--<div class="panel-heading radius-none">--}}
                                        {{--<h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4>--}}
                                        {{--</div>--}}
                                        <div class="panel-body bg-info">
                                            <div class="clearfix">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerName_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.policeName')</label>
                                                            <span  id="policeName_1" class="form-control"  ></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="policeFather_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.father')</label>
                                                            <span  id="policeFather_1" class="form-control" ></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="policeDesignation_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.designation')</label>
                                                            <span  id="policeDesignation_1" class="form-control" ></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="policeNid_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.nid')</label>
                                                            <span id="policeNid_1" class="form-control" ></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="policeGender_1" class="control-label">@lang('message.gender')</label>
                                                            <span id="policeGender_1" class="form-control"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="policePhn_1" class="control-label">@lang('message.phn')</label>
                                                            <span  id="policePhn_1" class="form-control" ></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="policeEmail_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.Email')</label>
                                                            <span  id="policeEmail_1" class="form-control" ></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="policeThana_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.thana')</label>
                                                            <span  id="policeThana_1" class="form-control" ></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="policeUpazilla_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.Upazilla')</label>
                                                            <span  id="policeUpazilla_1" class="form-control" ></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div class="hidden" id="approvedNoteOrderList">
                            <div class="panel panel-info trial-order-list">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="#orderList" class="btn-block" data-toggle="collapse" >
                                            @lang('message.note') @lang('message.List')
                                            <i class="fa fa-angle-down pull-right"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div class="panel-body collapse in" id="orderList">
                                    <div class="panel-group notesDiv" id="accordion" role="tablist" aria-multiselectable="true">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <form method="post" id="appealForm" action="">
                            {{csrf_field()}}
                            <input type="hidden" id="appealId" class="form-control" value="{{$appealId}}">
                            <input type="hidden" name="causeListId" id="causeListId"  value="">
                            <input type="hidden" name="noteId" id="noteId"  class="form-control" value="">
                            <input type="hidden" name="userRoleCode" id="userRoleCode"   value="{{ session('userRoleCode') }}">


                            <div class="panel panel-info">
                                <div class="panel-heading raiViewheading">
                                    <span class="panel-title">@lang('message.Karjokrom')</span>
                                </div>

                                <div class="panel-body">
                                    <div class="row" hidden id="paymentInformation">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="totalLoan" class="control-label btn-block">@lang('message.totalLoanAmount')</label>
                                                <div id="totalLoan" class="text-primary">0 টাকা</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" hidden id="auctionBlock">
                                            <div class="form-group">
                                                <label for="auctionSale" class="control-label btn-block">@lang('message.auctionSale')</label>
                                                <div id="auctionSale" class="text-primary">0 টাকা</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="totalPaidAmount" class="control-label btn-block">@lang('message.totalPaidAmount')</label>
                                                <div id="totalPaidAmount" class="text-primary">0 টাকা</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="dueAmount" class="control-label btn-block">@lang('message.dueAmount')</label>
                                                <div id="dueAmount" class="text-primary">0 টাকা</div>
                                                <input type="hidden" value="" id="dueAmountValue">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>@lang('message.ShortOrder')</label>
                                                <div class="orderCheckBox" style="border:1px solid #ccc; height: 215px; overflow-y: scroll; padding: 5px 30px 5px">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="note">@lang('message.note')</label>
                                                <textarea class="form-control" id="note" name="note" rows="10"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="applicantName" class="control-label"><span style="color:#FF0000"></span>@lang('message.applicant')</label>
                                                <span  id="applicantName" class="form-control" ></span>
                                                <input type="hidden" name="citizenAttendance[1][id]" id="applicantCitizenAttendanceId"  class="form-control" value="">
                                                <input type="hidden" name="citizenAttendance[1][appealId]" class="form-control citizenAttendanceAppealId" value="">
                                                <input type="hidden" name="citizenAttendance[1][citizenId]" id="citizenAttendanceApplicantCitizenId"  class="form-control" value="">
                                                <input type="hidden" name="citizenAttendance[1][attendanceDate]"  class="form-control citizenAttendanceApplicantAttendanceDate" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="applicantDesignation" class="control-label"><span style="color:#FF0000"></span>@lang('message.designation')</label>
                                                <span id="applicantDesignation" class="form-control"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="applicantAttendance" class="control-label"><span style="color:#FF0000">* </span>@lang('message.attendance')</label>
                                                <div class="radio">
                                                    <label><input id="applicantAttendancePresent" class="applicantAttendance" type="radio" name="citizenAttendance[1][attendance]" value="PRESENT" checked>@lang('message.present')</label>
                                                    <label><input id="applicantAttendanceAbsent" class="applicantAttendance" type="radio" name="citizenAttendance[1][attendance]" value="ABSENT" >@lang('message.absent')</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="attendance" class="control-label">@lang('message.attendance') @lang('message.print')</label>
                                                <div><button type="button" onclick="appealUiUtils.printHajira('APPLICANT');" class="btn btn-success"><span class="glyphicon glyphicon-print"></span>@lang('message.print')</button></div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="defaulterName" class="control-label"><span style="color:#FF0000"></span>@lang('message.defaulter')</label>
                                                <span id="defaulterName" class="form-control"></span>
                                                <input type="hidden" name="citizenAttendance[2][id]" id="defaulterCitizenAttendanceId"  class="form-control" value="">
                                                <input type="hidden" name="citizenAttendance[2][appealId]"  class="form-control citizenAttendanceAppealId" value="">
                                                <input type="hidden" name="citizenAttendance[2][citizenId]" id="citizenAttendanceDefaulterCitizenId"  class="form-control" value="">
                                                <input type="hidden" name="citizenAttendance[2][attendanceDate]"  class="form-control citizenAttendanceApplicantAttendanceDate" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="defaulterDesignation" class="control-label"><span style="color:#FF0000"></span>@lang('message.designation')</label>
                                                <span id="defaulterDesignation" class="form-control"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="defaulterAttendance" class="control-label"><span style="color:#FF0000">* </span>@lang('message.attendance')</label>
                                                <div class="radio">
                                                    <label><input id="defaulterAttendancePresent" class="defaulterAttendance" type="radio" name="citizenAttendance[2][attendance]" value="PRESENT" checked>@lang('message.present')</label>
                                                    <label><input id="defaulterAttendanceAbsent" class="defaulterAttendance" type="radio" name="citizenAttendance[2][attendance]" value="ABSENT" >@lang('message.absent')</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="attendance" class="control-label">@lang('message.attendance') @lang('message.print')</label>
                                                <div><button type="button" onclick="appealUiUtils.printHajira('DEFAULTER');" class="btn btn-success"><span class="glyphicon glyphicon-print"></span> @lang('message.print')</button></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="offenderGender" class="control-label">@lang('message.status')</label>
                                                <select style="width: 100%;" class="selectDropdown form-control" name="appealDecision" id="appealDecision" onchange="appealUiUtils.hideTrialDate()">
                                                    <option value="1">চলমান</option>
                                                    <option value="2">মুলতবি</option>
                                                    <option value="3">নিষ্পতি হয়েছে</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="offenderGender" class="control-label">স্বাক্ষর</label>
                                                <div><input type="checkbox" id="oldCaseFlag" name="oldCaseFlag" value="1"> কোন স্বাক্ষর নেই</div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="conductDate" class="control-label">@lang('message.orderDate')</label>
                                                    <div class="input-group">
                                                        <input onchange="appealUiUtils.attendanceDateChange();" readonly="readonly" class="conductDate form-control" name="conductDate" id="conductDate" value=""
                                                               type="text"/>
                                                        <span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="trialDate" class="control-label">@lang('message.trialDate')</label>
                                                    <div class="input-group">
                                                        <input readonly="readonly" class="date form-control" onchange="appealUiUtils.trailDateAdd();" name="trialDate" id="trialDate" value="" type="text"/>
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar text-primary"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="trialTime" class="control-label">@lang('message.trialTime')</label>
                                                    <div class="input-group">
                                                        <input class="timepicker form-control" name="trialTime" id="trialTime" value=""
                                                               type="text"/>
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time text-primary"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="userRole" id="getUserRole" value="{{$userRole}}">
                                    <input type="hidden" name="paymentStatus" id="paymentStatus" value="">

                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="form-group">
                                    <div id="AttachedFile" class="panel panel-info"></div>
                                </div>
                            </div>

                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <span class="panel-title">@lang('message.AttachmentTitle')</span>
                                    <button type="button" class="btn btn-xs btn-primary multifileupload pull-right">
                                        <span><i class="glyphicon glyphicon-plus"></i> @lang('message.Attachments')</span>
                                    </button>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class=" photoContainer">
                                            <div class="docs-toggles">

                                            </div>
                                            <div class="docs-galley photoView">

                                            </div>
                                            <div class="docs-buttons" role="group"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row buttonsDiv">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{--<button type="button" onclick="appeal.cancel()" class="btn btn-danger">--}}
                                            {{--@lang('message.cancelForm')--}}
                                        {{--</button>--}}
                                        <button type="button" onclick="appeal.saveAsOnTrial('trail')" class="btn btn-primary">
                                            @lang('message.update')
                                        </button>
                                        @if(session('userRoleCode') != 'RecordroomOfficer_' & session('userRoleCode') != 'Peshkar_' & session('userRoleCode') != 'GCO_')
                                        <button type="button" onclick="appeal.saveAsOnTrialandSendToGco()" class="btn btn-success">
                                            @lang('message.update') ও  সার্টিফিকেট  অফিসারের নিকট প্রেরণ
                                        </button>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="hajiraTemplate" style="display: none; ">
        {{-- @include('reports.hajira') --}}
    </div>
@endsection
@section('jsComponent')

    <script src="{{ asset('js/appeal/appealCreate.js') }}"></script>
    <script src="{{ asset('js/appeal/appeal-ui-utils.js') }}"></script>
    <script src="{{ asset('js/appeal/appealPopulate.js') }}"></script>
    <script src="{{ asset('js/initiate/appealTrial.js') }}"></script>

    <script src="{{ asset('js/initiate/init.js') }}"></script>
    <script src="{{ asset('js/fileUpload.js') }}"></script>
    <script src="{{ asset('js/englishToBangla/convertEngToBangla.js') }}"></script>

@endsection

