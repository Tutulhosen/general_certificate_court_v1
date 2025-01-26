@extends('layouts.citizen.citizen')
@section('content')
<!-- <div class="container"> -->
    <!-- <div class="row justify-content-center"> -->
        
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

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
            <form method="POST" action="{{ route('update.new.password') }}">
                @csrf 
                  
                @if(Session::has('errorMSG'))
                <div class="alert alert-danger">
                 {{ Session::get('errorMSG') }}
                </div>
                @endif
                
                <div class="mb-5">
                    <label for="exampleInputEmail1" class="form-label">নতুন পাসওয়ার্ড</label>
                    <div class="input-group" id="show_hide_password_new_password">
                    <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                    <div class="input-group-addon bg-secondary">
                        <a href=""><i class="fa fa-eye-slash p-5 mt-1"
                                aria-hidden="true"></i></a>
                    </div>
                </div>
                <div id="password-strength-status" class="text-danger mb-3 py-5 d-none"></div>
                <div class="mb-3 py-3">
                    <label for="exampleInputEmail1" class="form-label">নতুন কনফার্ম পাসওয়ার্ড</label>
                    <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                    
                    <span id='message'></span>

                </div>
                      
                      <div class="text-center py-5">
                        <button type="submit" class="btn btn-primary">
                            পাসওয়ার্ড হালনাগাদ 
                         </button>
                      </div>
                        
                    
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- </div> -->
<!-- </div> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

            $('#new_password, #new_confirm_password').on('keyup', function() {

            if ($('#new_password').val() == $('#new_confirm_password').val()) {
                $('#message').html('Matching').css('color', 'green');
            } else
                $('#message').html('Not Matching').css('color', 'red');
            });


      $("#new_password").on('keyup', function() {
              
              var number = /([0-9])/;
              var alphabets = /([a-zA-Z])/;
              var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
              if ($('#new_password').val().length < 6) {
                  $('#password-strength-status').removeClass();
                  $('#password-strength-status').addClass('weak-password');
                  $('#password-strength-status').html("দুর্বল (অন্তত 6টি অক্ষর হতে হবে।)");
                  jQuery('#password').removeClass('waring-border-field-succes');
                  jQuery('#password').addClass('waring-border-field');
              } else {
                  if ($('#new_password').val().match(number) && $('#new_password').val().match(alphabets) && $(
                          '#new_password').val().match(special_characters)) {
                      $('#password-strength-status').removeClass();
                      $('#password-strength-status').addClass('strong-password');
                      $('#password-strength-status').html("শক্তিশালী");
                      jQuery('#new_password').removeClass('waring-border-field');
                      jQuery('#new_password').addClass('waring-border-field-succes');
                  } else {
                      $('#password-strength-status').removeClass();
                      $('#password-strength-status').addClass('medium-password');
                      $('#password-strength-status').html(
                          "মাঝারি (বর্ণমালা, সংখ্যা এবং বিশেষ অক্ষর বা কিছু সংমিশ্রণ অন্তর্ভুক্ত করা উচিত।)"
                      );
                      jQuery('#new_password').removeClass('waring-border-field');
                      jQuery('#new_password').addClass('waring-border-field-succes');
                  }
              }
          });

          $("#show_hide_password_new_password a").on('click', function(event) {
          event.preventDefault();
          if ($('#show_hide_password_new_password input').attr("type") == "text") {
              $('#show_hide_password_new_password input').attr('type', 'password');
              $('#show_hide_password_new_password i').addClass("fa-eye-slash");
              $('#show_hide_password_new_password i').removeClass("fa-eye");
          } else if ($('#show_hide_password_new_password input').attr("type") == "password") {
              $('#show_hide_password_new_password input').attr('type', 'text');
              $('#show_hide_password_new_password i').removeClass("fa-eye-slash");
              $('#show_hide_password_new_password i').addClass("fa-eye");
          }
      });
</script>




@endsection