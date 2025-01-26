<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    if ($('#general_user_check').attr('checked')) {
        $("#general_form").show();
    } 


    $('#nothi_user_check').on('click', function() {
        $("#general_form").show();
    })

    $('#general_user_check').on('click', function() {
        $("#general_form").hide();
          
    })

</script>




 {{-- <script>
   



    $('.active').on('click',function(){
        
        if($(this).hasClass('btn-primary'))
        {
              var active=0;
        }
        else
        {
            var active=1;
        }

        Swal.showLoading();
    $.ajax({
        method: "GET",
        url: "{{ route('peshkar.active') }}",
        data: {

            active: active,
            user_id:$(this).data('user'),
            _token: '{{ csrf_token() }}'

        },
        success: (result) => {
            if (result.success == 'success') {
                Swal.close();
                if($(this).hasClass('btn-primary'))
                {
                    $(this).removeClass('btn-primary');
                    $(this).addClass('btn-danger');
                    $(this).text('ইন অ্যাক্টিভ');
                }
                else
                {
                    $(this).addClass('btn-primary');
                    $(this).removeClass('btn-danger');
                    $(this).text('অ্যাক্টিভ');
                }
               

            }
            if (result.error == 'error') {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'কোন তথ্য পাওয়া যায় নি!',

                })
            }
        },
        error: (error) => {
            // console.log(error);

        }
    });
    });
</script> --}}


<script>
    $('.court_select').on('change', function() {


        const id = $(this).attr('id');
        
        //alert(id);



        var formdata = new FormData();

         

            swal.showLoading();
            $.ajax({
                url: '{{ route('doptor.user.management.store.certificate.uno') }}',
                method: 'post',
                data: {
                    office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                    office_name_en: $('#' + 'office_name_en_' + id).val(),
                    unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                    unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                    designation_bng: $('#' + 'designation_bng_' + id).val(),
                    office_id: $('#' + 'office_id_' + id).val(),
                    username: $('#' + 'username_' + id).val(),
                    employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                    court_id: $(this).find('option:selected').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.close();
                    if (response.success == 'error') {
                        Swal.fire({
                            icon: 'error',
                            text: response.message,

                        })
                    } else if (response.success == 'success') {

                        Swal.fire({
                            icon: 'success',
                            text: response.message,

                        })
                        if (response.court_name == 'No_court') {
                            $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                            $('.court_name_' + id).removeClass('btn-primary');
                            $('.court_name_' + id).addClass('btn-danger');
                        } else {
                            let texthtml = response.court_name + ' এনাবেল';
                            $('.court_name_' + id).html(texthtml);
                            $('.court_name_' + id).removeClass('btn-danger');
                            $('.court_name_' + id).addClass('btn-primary');
                        }
                    }
                }
            });

        

    });
</script>
