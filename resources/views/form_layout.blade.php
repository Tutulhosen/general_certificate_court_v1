@extends('layouts.default')

@section('content')

<!--begin::Row-->
<div class="row">
    <div class="col-lg-8">
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Advanced Validation</h3>
                <div class="card-toolbar">
                    <!-- <div class="example-tools justify-content-center">
                        <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                    </div> -->
                </div>
            </div>

            <!--begin::Form-->
            <form class="form" id="kt_form_2">
                <div class="card-body">
                    <div class="alert alert-custom alert-light-success d-none" role="alert" id="kt_form_2_msg">
                        <div class="alert-icon">
                            <i class="flaticon2-bell-5"></i>
                        </div>
                        <div class="alert-text font-weight-bold">Oh snap! Change a few things up and try submitting again.</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span> <i class="ki ki-close"></i> </span>
                            </button>
                        </div>
                    </div>
                    <!--begin: Code-->

                    <!--end: Code-->
                    <div class="mb-3">
                        <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">Billing Information:</h3>
                        <div class="mb-2">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>* Cardholder Name:</label>
                                    <input type="text" name="billing_card_name" class="form-control" placeholder="" value="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>* Card Number:</label>
                                    <input type="text" name="billing_card_number" class="form-control" placeholder="" value="4111 1111 1111 1111" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>* Exp Month:</label>
                                    <select class="form-control" name="billing_card_exp_month">
                                        <option value="">Select</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label>* Exp Year:</label>
                                    <select class="form-control" name="billing_card_exp_year">
                                        <option value="">Select</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label>* CVV:</label>
                                    <input type="number" class="form-control" name="billing_card_cvv" placeholder="" value="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-10"></div>
                    <div class="mb-3">
                        <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">Billing Address
                            <i data-toggle="tooltip" data-width="auto" class="mb-3__help" title="If different than the corresponding address"></i></h3>
                            <div class="mb-2">
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>* Address 1:</label>
                                        <input type="text" name="billing_address_1" class="form-control" placeholder="" value="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Address 2:</label>
                                        <input type="text" name="billing_address_2" class="form-control" placeholder="" value="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-5">
                                        <label>* City:</label>
                                        <input type="text" class="form-control" name="billing_city" placeholder="" value="" />
                                    </div>
                                    <div class="col-lg-5">
                                        <label>* State:</label>
                                        <input type="text" class="form-control" name="billing_state" placeholder="" value="" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>* ZIP:</label>
                                        <input type="text" class="form-control" name="billing_zip" placeholder="" value="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-10"></div>
                        <div class="mb-3">
                            <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">Delivery Type:</h3>
                            <div class="mb-2">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="option">
                                                <span class="option-control">
                                                    <span class="radio radio-outline">
                                                        <input type="radio" name="billing_delivery" value="" />
                                                        <span></span>
                                                    </span>
                                                </span>
                                                <span class="option-label">
                                                    <span class="option-head">
                                                        <span class="option-title">Standard Delivery</span>
                                                        <span class="option-focus">Free</span>
                                                    </span>
                                                    <span class="option-body">Estimated 14-20 Day Shipping (Duties and taxes may be due upon delivery)</span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="option">
                                                <span class="option-control">
                                                    <span class="radio radio-outline">
                                                        <input type="radio" name="billing_delivery" value="" />
                                                        <span></span>
                                                    </span>
                                                </span>
                                                <span class="option-label">
                                                    <span class="option-head">
                                                        <span class="option-title">Fast Delivery</span>
                                                        <span class="option-focus">$&#160;8.00</span>
                                                    </span>
                                                    <span class="option-body">Estimated 2-5 Day Shipping (Duties and taxes may be due upon delivery)</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-check"></div>
                                    <div class="form-text text-muted"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">Select Package:</h3>
                            <div class="mb-2">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="option">
                                                <span class="option-control">
                                                    <span class="radio">
                                                        <input type="radio" name="package" value="" />
                                                        <span></span>
                                                    </span>
                                                </span>
                                                <span class="option-label">
                                                    <span class="option-head">
                                                        <span class="option-title">Standard Package</span>
                                                        <span class="option-focus text-primary">Free</span>
                                                    </span>
                                                    <span class="option-body">Estimated 14-20 Day Shipping (Duties and taxes may be due upon delivery)</span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="option">
                                                <span class="option-control">
                                                    <span class="radio">
                                                        <input type="radio" name="package" value="" />
                                                        <span></span>
                                                    </span>
                                                </span>
                                                <span class="option-label">
                                                    <span class="option-head">
                                                        <span class="option-title">Premium Package</span>
                                                        <span class="option-focus text-primary">$&#160;8.00</span>
                                                    </span>
                                                    <span class="option-body">Estimated 2-5 Day Shipping (Duties and taxes may be due upon delivery)</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-check"></div>
                                    <div class="form-text text-muted"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary font-weight-bold mr-2">Validate</button>
                                <button type="reset" class="btn btn-light-primary font-weight-bold">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Row-->

    @endsection

    {{-- Includable CSS Related Page --}}
    @section('styles')

    <!--end::Page Vendors Styles-->
    @endsection     

    {{-- Scripts Section Related Page--}}
    @section('scripts')
    <script src="{{ asset('js/pages/widgets.js') }}"></script>

    <script>
    // Class definition
    var KTFormControls = function () {

        var _initDemo2 = function () {
            FormValidation.formValidation(
                document.getElementById('kt_form_2'),
                {
                    fields: {
                        billing_card_name: {
                            validators: {
                                notEmpty: {
                                    message: 'Card Holder Name is required'
                                }
                            }
                        },
                        billing_card_number: {
                            validators: {
                                notEmpty: {
                                    message: 'Credit card number is required'
                                },
                                creditCard: {
                                    message: 'The credit card number is not valid'
                                }
                            }
                        },
                        billing_card_exp_month: {
                            validators: {
                                notEmpty: {
                                    message: 'Expiry Month is required'
                                }
                            }
                        },
                        billing_card_exp_year: {
                            validators: {
                                notEmpty: {
                                    message: 'Expiry Year is required'
                                }
                            }
                        },
                        billing_card_cvv: {
                            validators: {
                                notEmpty: {
                                    message: 'CVV is required'
                                },
                                digits: {
                                    message: 'The CVV velue is not a valid digits'
                                }
                            }
                        },

                        billing_address_1: {
                            validators: {
                                notEmpty: {
                                    message: 'Address 1 is required'
                                }
                            }
                        },
                        billing_city: {
                            validators: {
                                notEmpty: {
                                    message: 'City 1 is required'
                                }
                            }
                        },
                        billing_state: {
                            validators: {
                                notEmpty: {
                                    message: 'State 1 is required'
                                }
                            }
                        },
                        billing_zip: {
                            validators: {
                                notEmpty: {
                                    message: 'Zip Code is required'
                                },
                                zipCode: {
                                    country: 'US',
                                    message: 'The Zip Code value is invalid'
                                }
                            }
                        },

                        billing_delivery: {
                            validators: {
                                choice: {
                                    min:1,
                                    message: 'Please kindly select delivery type'
                                }
                            }
                        },
                        package: {
                            validators: {
                                choice: {
                                    min:1,
                                    message: 'Please kindly select package type'
                                }
                            }
                        }
                    },

                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        // Validate fields when clicking the Submit button
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        // Submit the form when all fields are valid
                        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                        // Bootstrap Framework Integration
                        bootstrap: new FormValidation.plugins.Bootstrap({
                            eleInvalidClass: '',
                            eleValidClass: '',
                        })
                    }
                }
            );
}

return {
    // public functions
    init: function() {
    // _initDemo1();
    _initDemo2();
}
};
}();

jQuery(document).ready(function() {
    KTFormControls.init();
});
</script>
<!--end::Page Scripts-->
@endsection


