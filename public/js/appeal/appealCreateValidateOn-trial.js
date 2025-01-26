"use strict";

// Class definition
var KTProjectsAdd = (function () {
    // Base elements
    var _wizardEl;
    var _formEl;
    var _wizardObj;
    var fv;
    var _validations = [];

    // Private functions to form Wizard
    var _initWizard = function () {
        // Initialize form wizard
        _wizardObj = new KTWizard(_wizardEl, {
            startStep: 1, // initial active step number
            clickableSteps: false, // allow step clicking
        });

        // Validation before going to next page
        _wizardObj.on("change", function (wizard) {
            if (wizard.getStep() > wizard.getNewStep()) {
                return; // Skip if stepped back
            }

            // Validate form before change wizard step
            var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step
            if (validator) {
                validator.validate().then(function (status) {
                    console.log("statusfas", status);
                    if (status == "Valid") {
                        wizard.goTo(wizard.getNewStep());

                        KTUtil.scrollTop();
                    } else {
                        KTUtil.scrollTop();
                       
                        // }
                    }
                });
            }

            return false; // Do not change wizard step, further action will be handled by he validator
        });

        // Change event
        _wizardObj.on("changed", function (wizard) {
            KTUtil.scrollTop();
        });

        // Submit event
        _wizardObj.on("submit", function (wizard) {
            var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

            if (validator) {
                validator.validate().then(function (status) {
                    if (status == "Valid") {
                        Swal.fire({
                            title: "আপনি কি সংরক্ষণ করতে চান?",
                            text: "আপনি ভুল তথ্য প্রদান করলে আপনার অভিযোগ বাতিল হতে পারে এবং আপনার বিরুদ্ধে আইনগত ব্যবস্থা নেয়া হতে পারে",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "হ্যাঁ",
                            cancelButtonText: "না",
                        }).then(function (result) {
                            if (result.value) {
                                _formEl.submit(); // Submit form
                                KTApp.blockPage({
                                    // overlayColor: '#1bc5bd',
                                    overlayColor: "black",
                                    opacity: 0.2,
                                    // size: 'sm',
                                    message: "Please wait...",
                                    state: "danger", // a bootstrap color
                                });
                                Swal.fire({
                                    position: "top-right",
                                    icon: "success",
                                    title: "সফলভাবে সাবমিট করা হয়েছে!",
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                            } else if (result.dismiss === "cancel") {
                                return;
                            }
                        });
                    }
                });
            }
            return false; // Do not submit, further action will be handled by he validator
        });
    };

    // form validation start

    var _initValidation = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        // Step 1 start

        _validations.push(
            FormValidation.formValidation(_formEl, {
                fields: {
                    // Step 1
                    caseNo: {
                        validators: {
                            notEmpty: {
                                message: "ম্যানুয়াল মামলা নম্বর দিতে হবে",
                            },
                        },
                    },
                    caseDate: {
                        validators: {
                            notEmpty: {
                                message: "আবেদনের তারিখ দিতে হবে",
                            },
                        },
                    },
                    totalLoanAmount: {
                        validators: {
                            notEmpty: {
                                message: "টাকার পরিমান দিতে হবে",
                            },
                            regexp: {
                                regexp: new RegExp("^[0-9০-৯]+$"),
                                message: "The input is not valid",
                            },
                        },
                    },
                    // court_fee: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: "কোর্ট ফি দিতে হবে",
                    //         },
                    //         regexp: {
                    //             regexp: new RegExp("^[0-9০-৯]"),
                    //             message: "The input is not valid",
                    //         },
                    //     },
                    // },
                    // court_fee_attached: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: "কোর্ট ফি সংযুক্তি দিতে হবে",
                    //         },
                    //     },
                    // },
                    // process_fee: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: "প্রসেস ফি দিতে হবে",
                    //         },
                    //         regexp: {
                    //             regexp: new RegExp("^[0-9০-৯]"),
                    //             message: "The input is not valid",
                    //         },
                    //     },
                    // },
                    court_id: {
                        validators: {
                            notEmpty: {
                                message: "আদালত নির্বাচন করুন",
                            },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: "",
                    }),
                    icon: new FormValidation.plugins.Icon({
                        valid: "fa fa-check",
                        invalid: "fa fa-times",
                        validating: "fa fa-refresh",
                    }),
                },
            })
        );
        // step 1 end

        // Step 2 start
        _validations.push(
            FormValidation.formValidation(_formEl, {
                fields: {
                    "applicant[upazila_id][0]": {
                        validators: {
                            notEmpty: {
                                message: "উপজেলা নির্বাচন করুন",
                            },
                        },
                    },

                    "applicant_organization[Type][0]": {
                        validators: {
                            notEmpty: {
                                message: "প্রতিষ্ঠানের ধরন নির্বাচন করুন",
                            },
                        },
                    },
                    "applicant[organization][0]": {
                        validators: {
                            notEmpty: {
                                message: "প্রতিষ্ঠান নির্বাচন করুন",
                            },
                        },
                    },
                    "applicant[name][0]": {
                        validators: {
                            notEmpty: {
                                message: "আবেদনকারীর নাম দিতে হবে",
                            },
                        },
                    },
                    "applicant[organization_routing_id][0]": {
                        validators: {
                            notEmpty: {
                                message: "রাউটিং নাম্বার দিতে হবে",
                            },
                            callback: {
                                callback: function (value, validator) {
                                    var countryValue =
                                        $("#applicantTypeBank").val();

                                    // Debugging: Check the value of countryValue
                                    // console.log('Country Value:', countryValue);

                                    if (countryValue === "BANK") {
                                        // Debugging: Check if condition is met
                                        // console.log('Inside BANK condition');
                                        // return value !== ''; // State is required for BANK
                                        // validator.enableFieldValidators('applicant[organization_routing_id][0]', true);
                                        return value !== ""; // Validate as required for BANK
                                    } else {
                                        // Disable validation (State is optional for other countries)
                                        validator.enableFieldValidators(
                                            "applicant[organization_routing_id][0]",
                                            false
                                        );
                                        return true;
                                    }

                                    // State is optional for other countries
                                    // return true;
                                },
                            },
                        },
                    },
                    "applicant[phn][0]": {
                        validators: {
                            regexp: {
                                // regexp:  "(^(\\+88|0088)?(01){1}[3456789]{1}(\\d){8})$",
                                regexp: "(^(01){1}[3-9]{1}(\\d){8})$",
                                message: "মোবাইল নং সঠিক নয়",
                            },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: "",
                    }),
                    icon: new FormValidation.plugins.Icon({
                        valid: "fa fa-check",
                        invalid: "fa fa-times",
                        validating: "fa fa-refresh",
                    }),
                },
            })
        );
        // end step 2

        // step 3 start
        _validations.push(
            FormValidation.formValidation(_formEl, {
                fields: {
                    "defaulter[name]": {
                        validators: {
                            notEmpty: {
                                message: "ঋণগ্রহীতার নাম দিতে হবে",
                            },
                        },
                    },
                    "defaulter[phn]": {
                        validators: {
                            regexp: {
                                // regexp:  "(^(\\+88|0088)?(01){1}[3456789]{1}(\\d){8})$",
                                regexp: "(^(01){1}[3-9]{1}(\\d){8})$",
                                message: "মোবাইল নং সঠিক নয়",
                            },
                        },
                    },
                },
                plugins: {
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: "",
                    }),
                    icon: new FormValidation.plugins.Icon({
                        valid: "fa fa-check",
                        invalid: "fa fa-times",
                        validating: "fa fa-refresh",
                    }),
                },
            })
        );

        // step 3 end

        // step 4 start
        _validations.push(
            FormValidation.formValidation(_formEl, {
                fields: {},
                plugins: {
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: "",
                    }),
                    icon: new FormValidation.plugins.Icon({
                        valid: "fa fa-check",
                        invalid: "fa fa-times",
                        validating: "fa fa-refresh",
                    }),
                },
            })
        );
        // step 4 start
    };

    return {
        // public functions
        init: function () {
            _wizardEl = KTUtil.getById("appealWizard");
            _formEl = KTUtil.getById("appealCase");

            _initWizard();
            _initValidation();
        },
    };
})();

jQuery(document).ready(function () {
    KTProjectsAdd.init();
});
