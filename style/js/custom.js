/**
 * Created by Asmoria-Y on 20.01.2015.
 */

$(document).ready(function () {
    //$(document).on('click', '#sbmt', function(){
    //    alert($('input[name="a_email"]').val());
    //})

});
var Form;
function ajaxSubmit_c(s) {
    switch (s) {
        case 'register':
            event.preventDefault ? event.preventDefault() : (event.returnValue = false);
            var sUrl_r = '/modules/profiler/register';//$('#register_main').attr('action');
            var form = document.forms.namedItem("register_main"); //$(document.forms.parentNode).html("register_main");
            $(form.parentNode).html();
            var oData_r = new FormData(document.forms.namedItem("register_main"));
            $.ajax({
                url: sUrl_r,
                type: 'POST',
                data: oData_r,
                contentType: false,
                processData: false,
                success: function (sResponce) {
                    if(sResponce == 'Success'){
                    $('.modal-body').html(sResponce);
                    $('#success').hide();}
                    else {
                        $('.modal-body').html(sResponce + $(form.parentNode).html());
                    }
                }

            });
            break;
        case 'auth':
            event.preventDefault ? event.preventDefault() : (event.returnValue = false);
            Form = $('.logout-wrap').html();
            console.log(Form);
            var sUrl_a = '/modules/profiler/auth';
            var oData_a = new FormData(document.forms.namedItem("auth_main"));
            $.ajax({
                url: sUrl_a,
                type: 'POST',
                data: oData_a,
                contentType: false,
                processData: false,
                dataType: 'JSON',
                success: function (sResponce) {
                    $('.navbar-right').html(sResponce);
                    if(sResponce.status == 'ok'){
                    $('.auth_form').hide();
                    $('.logout-wrap').html(sResponce.content);//('<div class="navbar-right"><a class="btn btn-primary logout" href="modules/profiler/logout">Logout</a></div>');
                }
                    else {
                        //console.log(Form);
                        $('.auth_form').hide();
                        $('.logout-wrap').html('<div class = "error-text">Error, try again</div>');
                        setTimeout("$('.logout-wrap').html(Form);", 3000);
                        //$('.auth_form').show();
                    }
            }});
            break;
        default:
            document.write('Error JS');
    }
}
