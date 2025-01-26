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
            // console.log(validator);
            if (validator) {
                validator.validate().then(function (status) {
                    if (status == "Valid") {
                        wizard.goTo(wizard.getNewStep());

                        KTUtil.scrollTop();
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
            // alert(validator);
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
                    interestRate: {
                        validators: {
                            notEmpty: {
                                message: "সুদের হার দিতে হবে",
                            },
                            regexp: {
                                regexp: new RegExp("^[0-9০-৯]"),
                                message: "The input is not valid",
                            },
                        },
                    },
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
        // const applicantOrganizationValidators = {
        //     validators: {
        //         notEmpty: {
        //             message: "প্রতিষ্ঠান এর নাম দিতে হবে",
        //         },
        //     },
        // };
        // const applicantDesignationValidators = {
        //     validators: {
        //         notEmpty: {
        //             message: "পদবি দিতে হবে",
        //         },
        //     },
        // };

        // const applicantNIDValidators = {
        //     validators: {
        //         notEmpty: {
        //             message: "এন আই ডি দিতে হবে ",
        //         },
        //         options: {
        //             inclusive: false,
        //             message: "১৩ থেকে ১৭ এর মধ্যে হবে",
        //             min: 13,
        //             max: 17,
        //         },
        //     },
        // };

        // const applicantPhoneValidators = {
        //     validators: {
        //         notEmpty: {
        //             message: "মোবাইল নং দিতে হবে",
        //         },
        //         regexp: {
        //             // regexp: /^([3-9]\d{8})$/,
        //             // regexp: "^(?:01)?\d{11}$",
        //             regexp: "(^(01){1}[3456789]{1}(\\d){8})$",
        //             message: "মোবাইল নং সঠিক নয়",
        //         },
        //     },
        // };
        // const applicantOrganization_physical_addressValidators = {
        //     validators: {
        //         notEmpty: {
        //             message: "প্রতিষ্ঠানের ঠিকানা দিতে হবে",
        //         },
        //     },
        // };
        // const applicantEmailValidators = {
        //     validators: {
        //         // notEmpty: {
        //         //     message: "ইমেইল  দিতে হবে",
        //         // },
        //         emailAddress: {
        //             message: "ইমেইল সঠিক নয়",
        //         },
        //     },
        // };

        // const applicantorganizationIDValidators = {
        //     validators: {
        //         notEmpty: {
        //             message: "প্রাতিষ্ঠানিক আইডি দিতে হবে",
        //         },
        //     },
        // };

        // const applicantNameValidators = {
        //     validators: {
        //         notEmpty: {
        //             message: "আবেদনকারীর নাম দিতে হবে",
        //         },
        //     },
        // };
        // const organization_employee_id_Validators = {
        //     validators: {
        //         notEmpty: {
        //             message: "প্রতিষ্ঠানে আবেদনকারীর EmployeeID দিতে হবে",
        //         },
        //     },
        // };

        // const fv1 = FormValidation.formValidation(_formEl, {
        //     fields: {
        //         // "applicant[name][0]": applicantNameValidators,
        //         // "applicant[organization][0]": applicantOrganizationValidators,
        //         // "applicant[designation][0]": applicantDesignationValidators,
        //         // "applicant[phn][0]": applicantPhoneValidators,
        //         // "applicant[organization_physical_address][0]":
        //             // applicantOrganization_physical_addressValidators,
        //         // "applicant[email][0]": applicantEmailValidators,
        //         // "applicant[nid][0]": applicantNIDValidators,
        //         // "applicant[organization_routing_id][0]":
        //             // applicantorganizationIDValidators,
        //         // "applicant[organization_employee_id][0]":
        //             // organization_employee_id_Validators,
        //     },
        //     plugins: {
        //         submitButton: new FormValidation.plugins.SubmitButton(),
        //         trigger: new FormValidation.plugins.Trigger(),
        //         bootstrap: new FormValidation.plugins.Bootstrap({
        //             //eleInvalidClass: '',
        //             eleValidClass: "",
        //         }),
        //         icon: new FormValidation.plugins.Icon({
        //             valid: "fa fa-check",
        //             invalid: "fa fa-times",
        //             validating: "fa fa-refresh",
        //         }),
        //     },
        // });
     
        // // remove template
        // const removeApplicantRow = function (rowIndex) {
        //     const defaultRow = document.getElementById("RemoveApplicant").value;
        //     if (parseInt(defaultRow) >= 1 || rowIndex >= 1) {
        //         Swal.fire({
        //             title: "আপনি কি মুছে ফেলতে চান?",
        //             icon: "warning",
        //             showCancelButton: true,
        //             confirmButtonText: "হ্যাঁ",
        //             cancelButtonText: "না",
        //         }).then(function (result) {
        //             if (result.value) {
        //                 const row = _formEl.querySelector(
        //                     '[data-row-index="' + rowIndex + '"]'
        //                 );
        //                 // Remove field
        //                 fv1.removeField(
        //                     "applicant[designation][" + rowIndex + "]",
        //                     applicantDesignationValidators
        //                 )
        //                     .removeField(
        //                         "applicant[organization][" + rowIndex + "]",
        //                         applicantOrganizationValidators
        //                     )
        //                     .removeField(
        //                         "applicant[phn][" + rowIndex + "]",
        //                         applicantPhoneValidators
        //                     )
        //                     .removeField(
        //                         "applicant[organization_physical_address][" +
        //                             rowIndex +
        //                             "]",
        //                         applicantOrganization_physical_addressValidators
        //                     )
        //                     .removeField(
        //                         "applicant[nid][" + rowIndex + "]",
        //                         applicantNIDValidators
        //                     )
        //                     .removeField(
        //                         "applicant[organization_routing_id][" +
        //                             rowIndex +
        //                             "]",
        //                         applicantorganizationIDValidators
        //                     )
        //                     .removeField(
        //                         "applicant[email][" + rowIndex + "]",
        //                         applicantEmailValidators
        //                     )
        //                     .removeField(
        //                         "applicant[organization_employee_id][" +
        //                             rowIndex +
        //                             "]",
        //                         organization_employee_id_Validators
        //                     );
        //                     // .removeField(
        //                     //     "applicant[name][" + rowIndex + "]",
        //                     //     applicantNameValidators
        //                     // );

        //                 // Remove row
        //                 document.getElementById("ApplicantAdd").value =
        //                     parseInt(parseInt(rowIndex) - 1);
        //                 document.getElementById("RemoveApplicant").value =
        //                     parseInt(parseInt(rowIndex) - 1);
        //                 row.parentNode.removeChild(row);

        //                 Swal.fire({
        //                     position: "top-right",
        //                     icon: "success",
        //                     title: "সফলভাবে মুছে ফেলা হয়েছে!",
        //                     showConfirmButton: false,
        //                     timer: 1500,
        //                 });
        //             }
        //         });
        //     } else {
        //         Swal.fire({
        //             position: "top-right",
        //             icon: "error",
        //             title: "আবেদনকারীর তথ্য সর্বনিম্ম একটি থাকতে হবে",
        //             showConfirmButton: false,
        //             timer: 1500,
        //         });
        //     }
        // };

        // const applicantTemplate = document.getElementById("applicantTemplate");
        // let applicantRowIndex = 0;
        // document
        //     .getElementById("ApplicantAdd")
        //     .addEventListener("click", function () {
        //         applicantRowIndex =
        //             document.getElementById("ApplicantAdd").value;
        //         applicantRowIndex = parseInt(parseInt(applicantRowIndex) + 1);

        //         const clone = applicantTemplate.cloneNode(true);
        //         clone.removeAttribute("id");

        //         // Show the row
        //         clone.style.display = "block";
        //         clone.setAttribute("data-row-index", applicantRowIndex);

        //         clone.querySelector(
        //             '[data-name="applicant.info"]'
        //         ).textContent =
        //             "আবেদনকারীর তথ্য (" + parseInt(applicantRowIndex + 1) + ")";
        //         clone.removeAttribute("data-name");

        //         // Insert before the template
        //         applicantTemplate.before(clone);

        //         // clone
        //         //     .querySelector('[data-name="applicant.name"]')
        //         //     .setAttribute(
        //         //         "name",
        //         //         "applicant[name][" + applicantRowIndex + "]"
        //         //     );
        //         // clone
        //         //     .querySelector('[data-name="applicant.name"]')
        //         //     .setAttribute(
        //         //         "onclick",
        //         //         "nid_data_pull_warning_function('" +
        //         //             applicantRowIndex +
        //         //             "')"
        //         //     );

        //         clone
        //             .querySelector('[data-name="applicant.type"]')
        //             .setAttribute(
        //                 "name",
        //                 "applicant[type][" + applicantRowIndex + "]"
        //             );

        //         clone
        //             .querySelector('[data-name="applicant.id"]')
        //             .setAttribute(
        //                 "name",
        //                 "applicant[id][" + applicantRowIndex + "]"
        //             );
        //         clone
        //             .querySelector('[data-name="applicant.thana"]')
        //             .setAttribute(
        //                 "name",
        //                 "applicant[thana][" + applicantRowIndex + "]"
        //             );
        //         clone
        //             .querySelector('[data-name="applicant.upazilla"]')
        //             .setAttribute(
        //                 "name",
        //                 "applicant[upazilla][" + applicantRowIndex + "]"
        //             );
        //         clone
        //             .querySelector('[data-name="applicant.age"]')
        //             .setAttribute(
        //                 "name",
        //                 "applicant[age][" + applicantRowIndex + "]"
        //             );
        //         clone
        //             .querySelector(
        //                 '[data-name="applicant.organization_routing_id"]'
        //             )
        //             .setAttribute(
        //                 "name",
        //                 "applicant[organization_routing_id][" +
        //                     applicantRowIndex +
        //                     "]"
        //             );
        //         clone
        //             .querySelector('[data-name="applicant.organization"]')
        //             .setAttribute(
        //                 "name",
        //                 "applicant[organization][" + applicantRowIndex + "]"
        //             );
        //         clone
        //             .querySelector('[data-name="applicant.designation"]')
        //             .setAttribute(
        //                 "name",
        //                 "applicant[designation][" + applicantRowIndex + "]"
        //             );

        //         clone
        //             .querySelector('[data-name="applicant.gender"]')
        //             .setAttribute(
        //                 "name",
        //                 "applicant[gender][" + applicantRowIndex + "]"
        //             );

        //         clone
        //             .querySelector('[data-name="applicant.father"]')
        //             .setAttribute(
        //                 "name",
        //                 "applicant[father][" + applicantRowIndex + "]"
        //             );
        //         clone
        //             .querySelector('[data-name="applicant.father"]')
        //             .setAttribute(
        //                 "onclick",
        //                 "nid_data_pull_warning_function('" +
        //                     applicantRowIndex +
        //                     "')"
        //             );

        //         clone
        //             .querySelector('[data-name="applicant.mother"]')
        //             .setAttribute(
        //                 "name",
        //                 "applicant[mother][" + applicantRowIndex + "]"
        //             );
        //         clone
        //             .querySelector('[data-name="applicant.mother"]')
        //             .setAttribute(
        //                 "onclick",
        //                 "nid_data_pull_warning_function('" +
        //                     applicantRowIndex +
        //                     "')"
        //             );

        //         clone
        //             .querySelector('[data-name="applicant.nid"]')
        //             .setAttribute(
        //                 "name",
        //                 "applicant[nid][" + applicantRowIndex + "]"
        //             );
        //         clone
        //             .querySelector('[data-name="applicant.nid"]')
        //             .setAttribute(
        //                 "onclick",
        //                 "nid_data_pull_warning_function('" +
        //                     applicantRowIndex +
        //                     "')"
        //             );

        //         clone
        //             .querySelector('[data-name="applicant.phn"]')
        //             .setAttribute(
        //                 "name",
        //                 "applicant[phn][" + applicantRowIndex + "]"
        //             );
        //         clone
        //             .querySelector(
        //                 '[data-name="applicant.organization_employee_id"]'
        //             )
        //             .setAttribute(
        //                 "name",
        //                 "applicant[organization_employee_id][" +
        //                     applicantRowIndex +
        //                     "]"
        //             );

        //         clone
        //             .querySelector(
        //                 '[data-name="applicant.organization_physical_address"]'
        //             )
        //             .setAttribute(
        //                 "name",
        //                 "applicant[organization_physical_address][" +
        //                     applicantRowIndex +
        //                     "]"
        //             );
        //         // clone.querySelector('[data-name="applicant.email"]').setAttribute('name', 'applicant[email][]');
        //         clone
        //             .querySelector('[data-name="applicant.email"]')
        //             .setAttribute(
        //                 "name",
        //                 "applicant[email][" + applicantRowIndex + "]"
        //             );

        //         var organization_name_default_from_previous_value =
        //             document.getElementById(
        //                 "organization_name_default_from_previous"
        //             ).value;

        //         clone
        //             .querySelector('[data-name="applicant.organization"]')
        //             .setAttribute(
        //                 "value",
        //                 organization_name_default_from_previous_value
        //             );
        //         clone
        //             .querySelector('[data-name="applicant.organization"]')
        //             .setAttribute("readonly", "readonly");
        //         var organization_routing_id_previous_value =
        //             document.getElementById(
        //                 "organization_routing_id_previous"
        //             ).value;

        //         clone
        //             .querySelector(
        //                 '[data-name="applicant.organization_routing_id"]'
        //             )
        //             .setAttribute(
        //                 "value",
        //                 organization_routing_id_previous_value
        //             );
        //         clone
        //             .querySelector(
        //                 '[data-name="applicant.organization_routing_id"]'
        //             )
        //             .setAttribute("readonly", "readonly");

        //         var organization_physical_address_previous =
        //             document.getElementById(
        //                 "organization_physical_address_previous"
        //             ).value;

        //         clone.querySelector(
        //             '[data-name="applicant.organization_physical_address"]'
        //         ).value = organization_physical_address_previous;

        //         clone
        //             .querySelector(
        //                 '[data-name="applicant.organization_physical_address"]'
        //             )
        //             .setAttribute("readonly", "readonly");

        //         clone
        //             .querySelector('[data-name="applicant.DOBNumber"]')
        //             .setAttribute(
        //                 "data-row-index",
        //                 "" + applicantRowIndex + ""
        //             );
        //         clone
        //             .querySelector('[data-name="applicant.DOBNumber"]')
        //             .setAttribute(
        //                 "id",
        //                 "applicant_dob_input_" + applicantRowIndex + ""
        //             );

        //         clone
        //             .querySelector('[data-name="applicant.NIDNumber"]')
        //             .setAttribute(
        //                 "data-row-index",
        //                 "" + applicantRowIndex + ""
        //             );
        //         clone
        //             .querySelector('[data-name="applicant.NIDNumber"]')
        //             .setAttribute(
        //                 "id",
        //                 "applicant_nid_input_" + applicantRowIndex + ""
        //             );

        //         clone
        //             .querySelector('[data-name="applicant.NIDCheckButton"]')
        //             .setAttribute(
        //                 "data-row-index",
        //                 "" + applicantRowIndex + ""
        //             );
        //         clone
        //             .querySelector('[data-name="applicant.NIDCheckButton"]')
        //             .setAttribute(
        //                 "id",
        //                 "applicant_nid_" + applicantRowIndex + ""
        //             );

        //         var applicantBuutonNIDCHECKID =
        //             "applicant_nid_" + applicantRowIndex;
        //         clone
        //             .querySelector('[data-name="applicant.NIDCheckButton"]')
        //             .setAttribute(
        //                 "onclick",
        //                 "NIDCHECK('" + applicantBuutonNIDCHECKID + "')"
        //             );

        //         // Add new fields
        //         // Note that we also pass the validator rules for new field as the third parameter
        //         fv1.addField(
        //             "applicant[designation][" + applicantRowIndex + "]",
        //             applicantDesignationValidators
        //         )
        //             .addField(
        //                 "applicant[organization][" + applicantRowIndex + "]",
        //                 applicantOrganizationValidators
        //             )
        //             .addField(
        //                 "applicant[phn][" + applicantRowIndex + "]",
        //                 applicantPhoneValidators
        //             )
        //             .addField(
        //                 "applicant[organization_physical_address][" +
        //                     applicantRowIndex +
        //                     "]",
        //                 applicantOrganization_physical_addressValidators
        //             )
        //             .addField(
        //                 "applicant[email][" + applicantRowIndex + "]",
        //                 applicantEmailValidators
        //             )
        //             .addField(
        //                 "applicant[nid][" + applicantRowIndex + "]",
        //                 applicantNIDValidators
        //             )
        //             .addField(
        //                 "applicant[name][" + applicantRowIndex + "]",
        //                 applicantNameValidators
        //             )
        //             .addField(
        //                 "applicant[organization_employee_id][" +
        //                     applicantRowIndex +
        //                     "]",
        //                 organization_employee_id_Validators
        //             )
        //             .addField(
        //                 "applicant[organization_routing_id][" +
        //                     applicantRowIndex +
        //                     "]",
        //                 applicantorganizationIDValidators
        //             );

        //         // Handle the click event of removeButton
        //         document.getElementById("ApplicantAdd").value =
        //             applicantRowIndex;
        //         document.getElementById("RemoveApplicant").value =
        //             applicantRowIndex;
        //         document.getElementById("RemoveApplicant").onclick = function (
        //             e
        //         ) {
        //             // Get the row index
        //             const index = e.target.value;
        //             removeApplicantRow(index);
        //         };
        //     });

        // step 3 start
       

    
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
                                message: 'রাউটিং নাম্বার দিতে হবে',
                            },
                            callback: {
                                callback: function(value, validator) {
                                    var countryValue = $('#applicantTypeBank').val();
                            
                                    // Debugging: Check the value of countryValue
                                    // console.log('Country Value:', countryValue);
                            
                                    if (countryValue === 'BANK') {
                                        // Debugging: Check if condition is met
                                        // console.log('Inside BANK condition');
                                        // return value !== ''; // State is required for BANK
                                        // validator.enableFieldValidators('applicant[organization_routing_id][0]', true);
                                        return value !== ''; // Validate as required for BANK
                                    }else {
                                        // Disable validation (State is optional for other countries)
                                        validator.enableFieldValidators('applicant[organization_routing_id][0]', false);
                                        return true;
                                    }
                            
                                    // State is optional for other countries
                                    // return true;
                                },
                              
                            }
                         
                        },
                    },
                    
                    // "applicant[phn][0]": {
                    //     validators: {
                           
                    //         regexp: {
                    //             // regexp:  "(^(\\+88|0088)?(01){1}[3456789]{1}(\\d){8})$",
                    //             regexp: "(^(01){1}[3-9]{1}(\\d){8})$",
                    //             message: "মোবাইল নং সঠিক নয়",
                    //         },
                    //     },
                    // },
                    
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
        // _validations.push(fv1);
   
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
                    // "defaulter[phn]": {
                    //     validators: {
                           
                    //         regexp: {
                    //             // regexp:  "(^(\\+88|0088)?(01){1}[3456789]{1}(\\d){8})$",
                    //             regexp: "(^(01){1}[3-9]{1}(\\d){8})$",
                    //             message: "মোবাইল নং সঠিক নয়",
                    //         },
                    //     },
                    // },
                    // "defaulter[phn]": {
                    //     validators: {
                    //         notEmpty: {
                    //             message: "মোবাইল নং দিতে হবে",
                    //         },
                    //         regexp: {
                    //             // regexp:  "(^(\\+88|0088)?(01){1}[3456789]{1}(\\d){8})$",
                    //             regexp: "(^(01){1}[3-9]{1}(\\d){8})$",
                    //             message: "মোবাইল নং সঠিক নয়",
                    //         },
                    //     },
                    // },
                    // "defaulter[designation]": {
                    //     validators: {
                    //         notEmpty: {
                    //             message: "পদবি / পেশা দিতে হবে",
                    //         },
                    //     },
                    // },
                    // "defaulter[nid]": {
                    //     validators: {
                    //         notEmpty: {
                    //             message: "এন আইডি দিতে হবে",
                    //         },
                    //     },
                    // },
                    // "defaulter[present_address]": {
                    //     validators: {
                    //         notEmpty: {
                    //             message:
                    //                 "ঋণগ্রহীতার নাম বর্তমান ঠিকানা দিতে হবে",
                    //         },
                    //     },
                    // },
                    // "defaulter[permanent_address]": {
                    //     validators: {
                    //         notEmpty: {
                    //             message:
                    //                 "ঋণগ্রহীতার নাম স্থায়ী ঠিকানা দিতে হবে",
                    //         },
                    //     },
                    // },
                    // "defaulter[email]": {
                    //     validators: {
                    //         emailAddress: {
                    //             message: "সঠিক ইমেইল নয়",
                    //         },
                    //     },
                    // },
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
        // step 3 end

       
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