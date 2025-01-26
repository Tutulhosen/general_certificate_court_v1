<script>
    String.prototype.endsWith = function(suffix) {
    return this.indexOf(suffix, this.length - suffix.length) !== -1;
    };
    var doAjax_params_default = {
        'url': null,
        'requestType': "GET",
        'contentType': 'application/x-www-form-urlencoded; charset=UTF-8',
        'dataType': 'json',
        'data': {},
        'beforeSendCallbackFunction': null,
        'successCallbackFunction': null,
        'successCallbackMsg': null,
        'completeCallbackFunction': null,
        'errorCallBackFunction': null,
    };

    function doAjax(doAjax_params) {
        var url = doAjax_params['url'];
        var requestType = doAjax_params['requestType'];
        var contentType = doAjax_params['contentType'];
        var dataType = doAjax_params['dataType'];
        var data = doAjax_params['data'];
        var beforeSendCallbackFunction = doAjax_params['beforeSendCallbackFunction'];
        var successCallbackFunction = doAjax_params['successCallbackFunction'];
        var Msg = doAjax_params['successCallbackMsg'];
        var completeCallbackFunction = doAjax_params['completeCallbackFunction'];
        var errorCallBackFunction = doAjax_params['errorCallBackFunction'];

        $.ajax({
            url: url,
            crossDomain: true,
            type: requestType,
            contentType: contentType,
            dataType: dataType,
            data: data,
            beforeSend: function(jqXHR, settings) {
                if (typeof beforeSendCallbackFunction === "function") {
                    beforeSendCallbackFunction();
                }
            },
            success: function(data, textStatus, jqXHR) {
                if (typeof successCallbackFunction === "function") {
                    successCallbackFunction(data,Msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (typeof errorCallBackFunction === "function") {
                    errorCallBackFunction(errorThrown);
                }

            },
            complete: function(jqXHR, textStatus) {
                if (typeof completeCallbackFunction === "function") {
                    completeCallbackFunction();
                }
            }
        });
    }

    function ajaxSuccess(data, msg=''){
        // console.log(data);
        Swal.fire({
            position: "top-right",
            icon: "success",
            title: msg,
            showConfirmButton: false,
            timer: 1500,
        });
        KTApp.unblockPage();
        // $('#deleteFile'+id).hide();
    }
    function ajaxError(data){
        var msg = "";
        if (xhr.status === 0) {
            msg = "Not connect.\n Verify Network." + xhr.responseText;
        } else if (xhr.status == 404) {
            msg = "Requested page not found. [404]" + xhr.responseText;
        } else if (xhr.status == 500) {
            msg = "Internal Server Error [500]." +  xhr.responseText;
        } else if (exception === "parsererror") {
            msg = "Requested JSON parse failed.";
        } else if (exception === "timeout") {
            msg = "Time out error." + xhr.responseText;
        } else if (exception === "abort") {
            msg = "Ajax request aborted.";
        } else {
            msg = "Error:" + xhr.status + " " + xhr.responseText;
        }
        Swal.fire({
            position: "top-right",
            icon: "error",
            title: 'Something went wrong',
            showConfirmButton: false,
            timer: 2500,
        });
        console.log(msg);
        KTApp.unblockPage();
    }
</script>
