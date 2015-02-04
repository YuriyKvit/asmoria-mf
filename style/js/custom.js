/**
 * Created by Asmoria-Y on 20.01.2015.
 */
function ajaxSubmit_c(){
    event.preventDefault ? event.preventDefault() : (event.returnValue = false);
    var sUrl = $('#register_main').attr('action');
    var  oData = new FormData(document.forms.namedItem("register_main"));
    $.ajax({
        url: sUrl,
        type: 'POST',
        data: oData,
        contentType: false,
        processData: false,
        success: function(sResponce){
            $('.modal-body').html(sResponce);
            $('#success').hide();
        }

    });

}
$(document).ready(function(){


});