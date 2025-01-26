<style>
    #password-strength-status {
        padding: 5px 10px;
        color: #FFFFFF;
        border-radius: 4px;
        margin-top: 5px;
    }

    .medium-password {
        background-color: #b7d60a;
        border: #BBB418 1px solid;
    }

    .weak-password {
        background-color: #ce1d14;
        border: #AA4502 1px solid;
    }

    .strong-password {
        background-color: #12CC1A;
        border: #0FA015 1px solid;
    }

    .waring-border-field {
        border: 2px solid #f5c6cb !important;

    }

    .warning-message-alert {
        color: red;
    }

    .waring-border-field-succes {
        border: 2px solid #c3e6cb !important;

    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {

        function isEmail($email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test($email);
        }
        jQuery('#email').on('keyup', function() {


            if (!isEmail(jQuery('#email').val())) {

                jQuery('#email').addClass('waring-border-field');
                jQuery('#email').removeClass('waring-border-field-succes');
                jQuery('#email').next('.required_message').removeClass(
                    'd-none');
                jQuery('#email').next('.required_message').addClass(
                    'd-block warning-message-alert');
                jQuery('#email').next('.required_message').text(
                    'Invalid Email Address');
            } else {
                jQuery('#email').addClass('waring-border-field-succes');
                jQuery('#email').removeClass('waring-border-field');
                jQuery('#email').next('.required_message').addClass('d-none');
                jQuery('#email').next('.required_message').removeClass(
                    'd-block warning-message-alert');

            }

        })
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("fa-eye-slash");
                $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("fa-eye-slash");
                $('#show_hide_password i').addClass("fa-eye");
            }
        });

        $("#password").on('keyup', function() {
            var number = /([0-9])/;
            var alphabets = /([a-zA-Z])/;
            var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
            if ($('#password').val().length < 6) {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('weak-password');
                $('#password-strength-status').html("দুর্বল (অন্তত 6টি অক্ষর হতে হবে।)");
                jQuery('#password').removeClass('waring-border-field-succes');
                jQuery('#password').addClass('waring-border-field');
            } else {
                if ($('#password').val().match(number) && $('#password').val().match(alphabets) && $(
                        '#password').val().match(special_characters)) {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('strong-password');
                    $('#password-strength-status').html("শক্তিশালী");
                    jQuery('#password').removeClass('waring-border-field');
                    jQuery('#password').addClass('waring-border-field-succes');
                } else {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('medium-password');
                    $('#password-strength-status').html(
                        "মাঝারি (বর্ণমালা, সংখ্যা এবং বিশেষ অক্ষর বা কিছু সংমিশ্রণ অন্তর্ভুক্ত করা উচিত।)"
                    );
                    jQuery('#password').removeClass('waring-border-field');
                    jQuery('#password').addClass('waring-border-field-succes');
                }
            }
        });



        $('#peshkar_form_manaul_button').on('click', function(e) {
            e.preventDefault();



            var permission = true;


            jQuery('.validation').each(function() {


                if (jQuery(this).val() == '') {
                    jQuery(this).addClass('waring-border-field');
                    jQuery(this).removeClass('waring-border-field-succes');
                    jQuery(this).next('.required_message').removeClass('d-none');
                    jQuery(this).next('.required_message').addClass(
                        'd-block warning-message-alert');
                    permission = false;
                } else {
                    jQuery(this).removeClass('waring-border-field');
                    jQuery(this).addClass('waring-border-field-succes');
                    jQuery(this).next('.required_message').addClass('d-none');
                    jQuery(this).next('.required_message').removeClass(
                        'd-block warning-message-alert');
                }


                jQuery(this).on('keyup', function() {
                    if (jQuery(this).val() == '') {
                        jQuery(this).addClass('waring-border-field');
                        jQuery(this).next('.required_message').removeClass('d-none');
                        jQuery(this).next('.required_message').addClass(
                            'd-block warning-message-alert');
                        jQuery(this).removeClass('waring-border-field-succes');
                        permission = false;
                    } else {
                        jQuery(this).removeClass('waring-border-field');
                        jQuery(this).addClass('waring-border-field-succes');
                        jQuery(this).next('.required_message').addClass('d-none');
                        jQuery(this).next('.required_message').removeClass(
                            'd-block warning-message-alert');
                    }
                })



            });

            jQuery('#email').on('keyup', function() {


                if (!isEmail(jQuery('#email').val())) {
                    permission = false;
                    jQuery('#email').addClass('waring-border-field');
                    jQuery('#email').removeClass('waring-border-field-succes');
                    jQuery('#email').next('.required_message').removeClass(
                        'd-none');
                    jQuery('#email').next('.required_message').addClass(
                        'd-block warning-message-alert');
                    jQuery('#email').next('.required_message').text(
                        'Invalid Email Address');
                } else {
                    jQuery('#email').addClass('waring-border-field-succes');
                    jQuery('#email').removeClass('waring-border-field');
                    jQuery('#email').next('.required_message').addClass('d-none');
                    jQuery('#email').next('.required_message').removeClass(
                        'd-block warning-message-alert');

                }

            })
            if (jQuery('#email').val() != '') {
                if (!isEmail(jQuery('#email').val())) {
                    permission = false;
                    jQuery('#email').addClass('waring-border-field');
                    jQuery('#email').removeClass('waring-border-field-succes');
                    jQuery('#email').next('.required_message').removeClass(
                        'd-none');
                    jQuery('#email').next('.required_message').addClass(
                        'd-block warning-message-alert');
                    jQuery('#email').next('.required_message').text(
                        'Invalid Email Address');
                } else {
                    jQuery('#email').addClass('waring-border-field-succes');
                    jQuery('#email').removeClass('waring-border-field');
                    jQuery('#email').next('.required_message').addClass('d-none');
                    jQuery('#email').next('.required_message').removeClass(
                        'd-block warning-message-alert');

                }
            }
            if (jQuery('#password').val() == '') {

                jQuery('#password').addClass('waring-border-field');
                jQuery('#password').removeClass('waring-border-field-succes');
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('weak-password');
                $('#password-strength-status').html("পাসওয়ার্ড দিতে হবে");
                permission = false;
            } else {
                jQuery('#password').removeClass('waring-border-field');
                jQuery('#password').addClass('waring-border-field-succes');
                $('#password-strength-status').removeClass();

            }

            if (permission) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('username.exits') }}",
                    data: {
                        username: $('#username').val(),
                        email: $('#email').val(),
                        _token: '{{ csrf_token() }}'

                    },
                    success: (result) => {
                        if (result.success == 'success') {
                            var new_permission = true;
                            if (result.is_username_found == 1) {
                                $('#username_alert_hide').removeClass(
                                    'd-none  warning-message-alert');
                                $('#username_alert_hide').addClass(
                                    'd-block  warning-message-alert');
                                $('#username_alert_hide').html(
                                    'ইউজারলেম ইতিমধ্যে ব্যাবহার করা হয়েছে');
                                jQuery('#username').addClass('waring-border-field');
                                new_permission = false;

                            }
                            if (result.is_email_found == 1) {
                                $('#email_alert_hide').removeClass(
                                    'd-none  warning-message-alert');
                                $('#email_alert_hide').addClass(
                                    'd-block  warning-message-alert');
                                $('#email_alert_hide').html(
                                    'ইমেইল ইতিমধ্যে ব্যাবহার করা হয়েছে');
                                jQuery('#email').addClass('waring-border-field');
                                new_permission = false;
                            }
                            if (new_permission) {
                                $('#peshkar_form_manaul').submit();
                            }

                        }
                    },
                    error: (error) => {
                        // console.log(error);

                    }
                });
            }






        });










    });
</script>
