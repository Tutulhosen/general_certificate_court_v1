<div class="form-group">
    <div class="form-group" id="officer">
        <fieldset>
            <legend></legend>
            <h3 id="defenceWarrantExecutor" class="card-label">৭ ধারার নোটিশ প্রয়োজনীয় তথ্য </h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warrantExecutorName"class="control-label"><span
                                style="color: #FF0000">*</span>বকেয়া</label>
                        <input type="text" name="amount_to_pay_as_remaining" id="amount_to_pay_as_remaining"
                            class="form-control form-control-sm input_bangla" value="{{ $appeal->loan_amount }}"
                            autocomplete="off" onkeyup='validate(event)' required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warrantExecutorName"class="control-label"><span style="color: #FF0000">*</span>খরচ
                            (<span style="color: black">2.5%</span>)</label>
                        <input type="text" name="amount_to_pay_as_costing" id="amount_to_pay_as_costing"
                            class="form-control form-control-sm input_bangla" value="{{ $loan_amount_expense }}"
                            autocomplete="off" onkeyup='validate(event)' required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warrantExecutorName"class="control-label"><span style="color: #FF0000">*</span>সুদের
                            হার</label>
                        <input type="text" name="interestRate" id="interestRate"
                            class="form-control form-control-sm input_bangla" value="{{ $appeal->interestRate }}"
                            autocomplete="off" onkeyup='validate(event)' required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warrantExecutorName"class="control-label"><span style="color: #FF0000">*</span>মোট
                            জারী</label>
                        <input type="text" name="total_jari" id="total_jari"
                            class="form-control form-control-sm input_bangla" value="{{ $total_jari }}"
                            autocomplete="off" onkeyup='validate(event)' required>
                    </div>
                </div>
                <div class="col-md-3" style="display: none;" id="working_amount_29_dhara">
                    <div class="form-group">
                        <label for="warrantExecutorName"class="control-label"><span
                                style="color: #FF0000">*</span>কার্যকরীকরন</label>
                        <input type="text" name="working_amount_29_dhara"
                            class="form-control form-control-sm input_bangla" value="" autocomplete="off"
                            onkeypress='validate(event)' required>
                    </div>
                </div>
            </div>
        </fieldset>

    </div>
</div>
