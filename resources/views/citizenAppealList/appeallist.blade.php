@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                {{-- layouts/sidemenu.blade.php --}}
                @include('layouts.sidemenu')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <strong class="panel-title">@lang('message.Search')</strong></div>
                    <div class="panel-body">
                        <form method="post" action="">
                            <input type="hidden" name="dateFromCalender" id="dateFromCalender"  value="{{$date}}">
                            <input type="hidden" name="appealCaseStatus" id="appealCaseStatus"  value="{{$caseStatus}}">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                        <div class="form-group">
                                            <label for="caseNo" class="control-label">@lang('message.caseNo')</label>
                                            <input name="caseNo" id="caseNo" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="appealStatus" class="control-label">@lang('message.appealStatus')</label>
                                            <select style="width: 100%;" class="selectDropdown form-control" id="appealStatus" name="appealStatus">
                                                <option value="">@lang('message.emptyText')</option>
                                                <option value="SEND TO DM">@lang('message.submitToDm')</option>
                                                <option value="SEND TO ADM">@lang('message.submitToAdm')</option>
                                                <option value="ON_TRIAL">@lang('message.onTrial')</option>
                                                <option value="CLOSED">@lang('message.closed')</option>
                                                <option value="DRAFT">@lang('message.draft')</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-md-12 col-lg-12">

                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">@lang('message.date') </label>
                                            <div class="row">
                                                <div class="col-sm-6 m-bottom-15">
                                                    <div class="input-group">
                                                        <input class="dateRange input form-control" name="start_date" id="start_date" value=""  type="text"  placeholder="প্রথম তারিখ" />
                                                        <span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <input class="dateRange input form-control" name="end_date" id="end_date" value="" type="text" placeholder="শেষ তারিখ"/>
                                                        <span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                        <div class="form-group">
                                            <label for="caseStatus" class="control-label">@lang('message.caseStatus')</label>
                                            <select style="width: 100%;" class="selectDropdown form-control" id="caseStatus" name="caseStatus">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="admList" class="control-label">@lang('message.admList')</label>
                                            <select style="width: 100%;" class="selectDropdown form-control" id="admList" name="admList">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <hr class="margin-top-5 margin-bottom-15">
                                    <div class="text-center">
                                        <button class="btn btn-primary" type="button" onclick="appealList.searchBySearchParameter()">
                                            <i class="fa fa-search"></i> @lang('message.search')
                                        </button>
                                    </div>
                                </div>

                                </div>
                            </div>
                        </form>


                        {{--<div class="form-group">--}}
                            {{--<label class="control-label">তারিখ </label>--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-sm-3 m-bottom-15">--}}
                                    {{--<div>প্রথম তারিখ</div>--}}
                                    {{--<input class="input form-control" name="start_date" id="start_date" value=""  type="text" required="true" placeholder="প্রথম তারিখ" />--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-3">--}}
                                    {{--<div>শেষ তারিখ</div>--}}
                                    {{--<input class="input form-control" name="end_date" id="end_date" value="" type="text" placeholder="শেষ তারিখ"/>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading">@lang('message.Appeal List')</div>
                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-responsive" id="appeals-table">
                                <thead class="">
                                <tr>
                                    <th>@lang('message.appealId')</th>
                                    <th>@lang('message.appealStatus')</th>
                                    <th>@lang('message.caseNo')</th>
                                    <th>পূর্ববর্তী মামলার নং</th>
                                    <th>@lang('message.applicant')</th>
                                    <th>@lang('message.dmName')</th>
                                    <th>@lang('message.admName')</th>
                                    <th>@lang('message.caseDecision')</th>
                                    <th>@lang('message.trialDate')</th>
                                    <th>@lang('message.action')</th>
                                </tr>
                                </thead>
                                {{--<tfoot>--}}
                                {{--<tr>--}}
                                    {{--<th>@lang('message.appealId')</th>--}}
                                    {{--<th>@lang('message.appealStatus')</th>--}}
                                    {{--<th>@lang('message.caseNo')</th>--}}
                                    {{--<th>@lang('message.dmName')</th>--}}
                                    {{--<th>@lang('message.admName')</th>--}}
                                    {{--<th>@lang('message.caseDecision')</th>--}}
                                    {{--<th>@lang('message.action')</th>--}}
                                {{--</tr>--}}
                                {{--</tfoot>--}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsComponent')
    <script src="{{ asset('js/appeal/appeal-ui-utils.js') }}"></script>
    <script src="{{ asset('js/appeal/appealPopulate.js') }}"></script>
    <script src="{{ asset('js/initiate/init.js') }}"></script>
    <script src="{{ asset('js/englishToBangla/convertEngToBangla.js') }}"></script>
    <script src="{{ asset('js/initiate/datatableInitiate.js') }}"></script>

@endsection

