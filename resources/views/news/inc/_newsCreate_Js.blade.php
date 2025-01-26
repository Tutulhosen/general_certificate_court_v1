

<script type="text/javascript">
      

     // common datepicker =============== start
    $('.common_datepicker').datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        orientation: "bottom left"
    });
    // common datepicker =============== end  

    function newsHideShow(typeID){
        // var typeID = $('input[name="investigatorType"]').val();
        // alert(typeID);
        if(typeID == 1){
            $("#shortNews").show();
            $("#bigNews").hide();
            $("#bigNewsTitle").hide();
        } else{
            $("#shortNews").hide();
            $("#bigNews").show();
            $("#bigNewsTitle").show();
        }
        // console.log(att);
    } 
    function myFunction() {
        Swal.fire({
            title: "আপনি কি সংরক্ষণ করতে চান?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "হ্যাঁ",
            cancelButtonText: "না",
        })
        .then(function(result) {
            if (result.value) {
                // setTimeout(() => {
                $('form#newsCreate').submit();
                // }, 5000);
                KTApp.blockPage({
                    // overlayColor: '#1bc5bd',
                    overlayColor: 'black',
                    opacity: 0.2,
                    // size: 'sm',
                    message: 'Please wait...',
                    state: 'danger' // a bootstrap color
                });
                Swal.fire({
                    position: "top-right",
                    icon: "success",
                    title: "সফলভাবে সাবমিট করা হয়েছে!",
                    showConfirmButton: false,
                    timer: 1500,
                });
                // toastr.success("সফলভাবে সাবমিট করা হয়েছে!", "Success");
            }
        });
    }
</script>