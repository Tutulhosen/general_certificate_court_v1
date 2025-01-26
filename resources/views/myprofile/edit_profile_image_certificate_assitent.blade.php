@extends('layouts.default')


@section('content')
<style>
	.thumb{
		width: 200px;
		height: 200Spx;
	}
</style>
<div class="container">

	<div class="row">
		<div class="col-md-12 text-center">
			<span class="text-dark flex-root font-weight-bolder font-size-h6">
				@if($userManagement->profile_pic != NULL)
				   <img src="{{url('/')}}/uploads/profile/{{ $userManagement->profile_pic }}" width="200" height="200" class="image_preview">
				@else
				   <img src="{{url('/')}}/uploads/profile/default.jpg" width="200" height="200" class="image_preview">
				@endif
			</span>
		</div>
	</div>
	<div class="row py-5">
		<div class="col-md-12 text-center">
			<form action="{{ route('my-profile.image_update') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="form-group" id="step1Content">
				<div class="col-md-12 mb-5 ">
				   <fieldset>
					  <legend>প্রোফাইল ইমেজ সংযুক্তি<span class="text-danger">*</span></legend>
						 <label  class=" form-control-label"> </label>
						 <div class="form-group">
							<label></label>
							<div></div>
							<div class="custom-file">
							   <input type="file" name="image" accept="image/*" class="custom-file-input" id="profile_image_input" onChange="attachmentTitleMainReport()"/>
							   <label class="custom-file-label custom-input" for="customFile">ইমেজ নির্বাচন করুন</label>
							</div>
						 </div>
				   </fieldset>
				</div>
				</div>
				<div class="row">
					<div class="col-lg-12 text-center">
					  <button type="submit" class="btn btn-primary font-weight-bold mr-2">সংরক্ষণ করুন</button>
					</div>
				 </div>
			 </form>
		</div>
	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
	$('#profile_image_input').on('change',function(){
        attachmentTitleMainReport();
    });
    
    $(document).ready(function(){
        $("#step1Content").load(location.href + " #step1Content");
    });

    function attachmentTitleMainReport() {
        // var value = $('#customFile' + id).val();
        var value = $('#profile_image_input')[0].files[0];
        
        const fsize  = $('#profile_image_input')[0].files[0].size;
        const file_size = Math.round((fsize / 1024));
                
        var file_extension=value['name'].split('.').pop().toLowerCase();      
        //alert(value['name']);
        if($.inArray(file_extension, ['jpg','png']) == -1) {
            Swal.fire(
				
                        'ফাইল ফরম্যাট jpg,png হতে হবে ',
                        
                        );

                       $('#profile_image_input').val('');
                       $("#step1Content").load(location.href + " #step1Content");
                       
            }
            else if (file_size > 2048 ) {
                Swal.fire(
                        
                        'ফাইল সাইজ অনেক বড় , ফাইল সাইজ ২ মেগাবাইটের কম হতে হবে',
                        
                        );

                        $('#profile_image_input').val('');
                        $("#step1Content").load(location.href + " #step1Content");
                        
            }
            
           else
           {

			
               var reader = new FileReader();
 
               reader.onload = function(){
                $(".image_preview").attr("src", reader.result);
              }
 
              reader.readAsDataURL(value);
            
               $('.custom-input').text(value['name']); 
           }

        
       
    }
</script>


@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page--}}
@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>

<script type="text/javascript">
$(document).ready(function(){
        $(':input[type=file]').on('change', function(){ //on file input change

            if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
            {
                $('#thumb-output').html(''); //clear html of output element
                    var data = $(this)[0].files; //this file data

                    $.each(data, function(index, file){ //loop though each file
                        if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                            var fRead = new FileReader(); //new filereader
                            fRead.onload = (function(file){ //trigger function on successful read
                            return function(e) {
                                var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element
                                $('#thumb-output').append(img); //append image to output element
                            };
                            })(file);
                            fRead.readAsDataURL(file); //URL representing the file's data.
                        }
                    });
            }else{
                alert("Your browser doesn't support File API!"); //if File API is absent
            }
        });


    });
</script>

<!--end::Page Scripts-->
@endsection