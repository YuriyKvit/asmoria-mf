/**
 * Created by Asmoria-Y on 20.01.2015.
 */
function ajaxSubmit_c(s) {
    switch (s) {
        case 'register':
            event.preventDefault ? event.preventDefault() : (event.returnValue = false);
            var sUrl_r = '/modules/profiler/register';//$('#register_main').attr('action');
            var oData_r = new FormData(document.forms.namedItem("register_main"));
            $.ajax({
                url: sUrl_r,
                type: 'POST',
                data: oData_r,
                contentType: false,
                processData: false,
                success: function (sResponce) {
                    $('.modal-body').html(sResponce);
                    $('#success').hide();
                }

            });
            break;
        case 'auth':
            event.preventDefault ? event.preventDefault() : (event.returnValue = false);
            var sUrl_a = '/modules/profiler/auth';
            var oData_a = new FormData(document.forms.namedItem("auth_main"));
            $.ajax({
                url: sUrl_a,
                type: 'POST',
                data: oData_a,
                contentType: false,
                processData: false,
                success: function (sResponce) {
                    $('.navbar-right').html(sResponce);
                    $('.auth_form').hide();
                }

            });
            break;
        default:
            document.write('Error JS');
    }
}
$(document).ready(function () {


});