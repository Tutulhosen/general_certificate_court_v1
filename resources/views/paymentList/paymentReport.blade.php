<link href="{{ asset('css/app.css') }}" rel="stylesheet">


<div class="contentForm">
    <div class="row">
        <div class="panel-heading" style="text-align: center;font-size: x-large;">
            @lang('message.paymentListHead')
        </div>
        <p style="text-align: center">@lang('message.caseNo'): <span id="paymentCaseNo"></span></p>
        <div id="body" style="margin-top: auto;margin-left: 20px;margin-right: 20px;">
                <div class="table-responsive">
                    <table id='paymentTablePrint' class="table table-condensed table-bordered table-striped margin-0">
                        <thead>
                        <tr>
                            <th >@lang('message.SL')</th>
                            <th >@lang('message.Installments')</th>
                            <th >@lang('message.date')</th>
                            <th >@lang('message.auctionSale')</th>
                            <th >@lang('message.auctionDate')</th>
                            <th >@lang('message.auctioneerName')</th>
                            <th >@lang('message.auctioneerRecipientName')</th>
                            <th >@lang('message.ReceiptNo')</th>
                            {{--<th >@lang('message.Attachments')</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            {{--<td></td>--}}
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
    </div>

</div>