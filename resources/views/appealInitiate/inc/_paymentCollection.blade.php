
<div class="form-group">
    <div class="form-group" id="officer">
        <fieldset>
            <legend></legend>
            <h3 id="defenceWarrantExecutor">অর্থ আদায় এর তথ্য</h3>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warrantExecutorName"class="control-label"><span style="color: #FF0000">*</span>মোট দাবী</label>
                        <input name="totalDemandPaymentCollection" id="totalDemandPaymentCollection" class="form-control form-control-sm" value="{{ en2bn($appeal->loan_amount) }}" required readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warrantExecutorInstituteName"
                            class="control-label"><span
                                style="color:#FF0000">*</span>অদ্য আদায়কৃত</label>
                        <input name="collectSoFarPaymentCollection"id="collectSoFarPaymentCollection" class="form-control form-control-sm" value="{{ en2bn($collection_payment_so_far) }}" required readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warrantExecutorMobile"class="control-label"><span style="color: #FF0000">*</span>প্রদেয়</label>
                        <input name="TodayPaymentPaymentCollection" id="TodayPaymentPaymentCollection"class="form-control form-control-sm" value="" required >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warrantExecutorMobile"class="control-label"><span style="color: #FF0000">*</span>মোট বকেয়া</label>
                        <input name="TotalRemainingPaymentPaymentCollection" id="TotalRemainingPaymentPaymentCollection"class="form-control form-control-sm" value="{{ en2bn((int)$appeal->loan_amount - (int)$collection_payment_so_far) }}" required readonly>
                    </div>
                </div>
                <input type="hidden" value="{{ en2bn((int)$appeal->loan_amount - (int)$collection_payment_so_far) }}" name="TotalRemainingPaymentPaymentCollectionBckp" id="TotalRemainingPaymentPaymentCollectionBckp">
            </div>
            
        </fieldset>
         
    </div>
</div>
