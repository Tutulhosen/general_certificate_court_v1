@extends('layouts.citizen.citizen')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3" id="leftBar">
                {{-- layouts/sidemenu.blade.php --}}
                @include('layouts.sidemenu')
            </div>
            <div class="col-md-9" id="rightBar">
                <a href="#" title="Collapse Sidebar" id="keyCollapseSidebar" class="key-sidebar" onclick="initiate.dCollapse('#leftBar', '#rightBar')">
                    <i id="keyIcon" class="fa fa-angle-left"></i>
                </a>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <strong class="panel-title">@lang('message.Search')</strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="">
                            <input type="hidden" name="dateFromCalender" id="dateFromCalender"  value="{{$date}}">
                            <input type="hidden"  id="gcoUserName"  value="{{$gcoUserName}}">
                            <div class="row">
                                {{--<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">--}}
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                    <div class="form-group">
                                        <label for="appealCaseNo" class="control-label">@lang('message.appealCaseNo')</label>
                                        <input name="appealCaseNo" id="appealCaseNo" class="form-control" value="">
                                    </div>
                                </div>
                                {{--<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">--}}
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 hidden">
                                    <div class="form-group">
                                        <label for="gcoList" class="control-label">@lang('message.gcoName')</label>
                                        <select style="width: 100%;" class="selectDropdown form-control" id="gcoList" name="gcoList">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="caseStatus" class="control-label">@lang('message.caseStatus')</label>
                                        <select style="width: 100%;" class="selectDropdown form-control" id="caseStatus" name="caseStatus">
                                        </select>
                                    </div>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-8">
                                    <div class="form-group">
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
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="appealStatus" class="control-label">@lang('message.appealStatus')</label>
                                        <select style="width: 100%;" class="selectDropdown form-control" id="appealStatus" name="appealStatus">
                                            <option value="">@lang('message.emptyText')</option>
                                            <option value="SEND_TO_GCO">@lang('message.submitToGco')</option>
                                            <option value="ON_TRIAL">@lang('message.onTrial')</option>
                                            <option value="ON_DC_TRIAL"> জেলা প্রশাসকের নিকট বিচারাধীন</option>
                                            {{--<option value="DRAFT">@lang('message.draft')</option>--}}
                                        </select>
                                    </div>
                                </div>
                                @if(session('userRoleCode') != 'RecordroomOfficer_' & session('userRoleCode') != 'Peshkar_' & session('userRoleCode') != 'GCO_')
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="upazillaId" class="control-label"> উপজেলা</label>
                                            <select style="width: 100%;" class="selectDropdown form-control" id="upazillaId" name="upazillaId">
                                                <option value="">@lang('message.emptyText')</option>
                                                @foreach($upazilaList as $upazila)
                                                    <option value={{$upazila->id}}>{{$upazila->upazila_name_bangla}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <hr class="margin-top-5 margin-bottom-15">
                                    <div class="text-right">
                                        <button class="btn btn-primary" type="button" onclick="nothiList.searchBySearchParameter()">
                                            <i class="fa fa-search"></i> @lang('message.search')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <strong class="panel-title">
                            @lang('message.nothiList')
                        </strong>
                    </div>
                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table nothi-table table-bordered table-hover table-responsive" id="nothi-table">
                                <thead>
                                <tr>
                                    <th>@lang('message.appealId')</th>
                                    <th>@lang('message.appealStatus')</th>
                                    <th>@lang('message.caseNo')</th>
                                    <th>পূর্ববর্তী মামলার নং</th>
                                    <th>@lang('message.gcoName')</th>
                                    <th>@lang('message.caseDecision')</th>
                                    <th>@lang('message.trialDate')</th>
                                    <th>@lang('message.action')</th>
                                </tr>
                                </thead>
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
    <script src="{{ asset('js/initiate/nothiTableInitiate.js') }}"></script>

@endsection