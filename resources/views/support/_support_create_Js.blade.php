<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js" integrity="sha512-tWHlutFnuG0C6nQRlpvrEhE4QpkG1nn2MOUMWmUeRePl4e3Aki0VB6W1v3oLjFtd0hVOtRQ9PHpSfN6u6/QXkQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // ========== Form Submission ========= Start =========

    // ================= Activities ========= end =========

    // ============= Add Attachment Row ========= start =========
    $("#addFileRow").click(function(e) {
        addFileRowFunc();
    });
    //add row function
    function addFileRowFunc() {
        var count = parseInt($('#other_attachment_count').val());
        $('#other_attachment_count').val(count + 1);
        var items = '';
        items += '<tr>';
        items +=
            '<td><input type="text" name="file_type[]" class="form-control form-control-sm" placeholder="ফাইলের নাম দিন" id="file_name_important' +
            count + '" ></td>';
        items += '<td><div class="custom-file"><input type="file" name="file_name[]" onChange="attachmentTitle(' +
            count + ',this)" class="custom-file-input" id="customFile' + count +
            '" /><label class="custom-file-label custom-input' + count + '" for="customFile' + count +
            '">ফাইল নির্বাচন করুন </label></div></td>';
        items +=
            '<td width="40"><a href="javascript:void();" class="btn btn-sm btn-danger font-weight-bolder pr-2" onclick="removeBibadiRow(this)"> <i class="fas fa-minus-circle"></i></a></td>';
        items += '</tr>';
        $('#fileDiv tr:last').after(items);
    }
    //Attachment Title Change
    function attachmentTitle(id, obj) {
        // var value = $('#customFile' + id).val();
        var value = $('#customFile' + id)[0].files[0];

        const fsize = $('#customFile' + id)[0].files[0].size;
        const file_size = Math.round((fsize / 1024));

        var file_extension = value['name'].split('.').pop().toLowerCase();

        if ($.inArray(file_extension, ['pdf', 'docx','jpg','png','zip']) == -1) {
            Swal.fire(

                'ফাইল ফরম্যাট PDF, docx, jpg, png হতে হবে ',

            )
            $(obj).closest("tr").remove();
        }
        if (file_size > 30720) {
            Swal.fire(

                'ফাইল সাইজ অনেক বড় , ফাইল সাইজ ১৫ মেগাবাইটের কম হতে হবে',

            )
            $(obj).closest("tr").remove();
        }

        var custom_file_name = $('#file_name_important' + id).val();
        if (custom_file_name == "") {
            Swal.fire(

                'ফাইল এর প্রথমে যে নাম দেয়ার field আছে সেখানে ফাইল এর নাম দিন ',

            )
            $(obj).closest("tr").remove();
        }



        // console.log(value['name']);
        $('.custom-input' + id).text(value['name']);
    }
    //remove Attachment
    function removeBibadiRow(id) {
        $(id).closest("tr").remove();
    }
   
    $('#main_file_input').on('change',function(){
        attachmentTitleMainReport();
    });
    
    $(document).ready(function(){
        $("#step1Content").load(location.href + " #step1Content");
    });

    function attachmentTitleMainReport() {
        // var value = $('#customFile' + id).val();
        var value = $('#main_file_input')[0].files[0];
        
        const fsize  = $('#main_file_input')[0].files[0].size;
        const file_size = Math.round((fsize / 1024));
                
        var file_extension=value['name'].split('.').pop().toLowerCase();      
        //alert(value['name']);
        if($.inArray(file_extension, ['pdf','docx']) == -1) {
            Swal.fire(
                        
                        'ফাইল ফরম্যাট PDF,docx হতে হবে ',
                        
                        );

                       $('#main_file_input').val('');
                       $("#step1Content").load(location.href + " #step1Content");
                       
            }
            else if (file_size > 2048 ) {
                Swal.fire(
                        
                        'ফাইল সাইজ অনেক বড় , ফাইল সাইজ ২ মেগাবাইটের কম হতে হবে',
                        
                        );

                        $('#main_file_input').val('');
                        $("#step1Content").load(location.href + " #step1Content");
                        
            }
            
           else
           {
               
               $('.custom-input').text(value['name']); 
           }

        
       
    }


    $('#support_email').on('keyup',function(){
       

       $('#input_support_email').html($('#support_email').val());
   })
   
</script>

