function CKupdate() {
    for (var instance in CKEDITOR.instances)
        CKEDITOR.instances[instance].updateElement();
}

$(document).ready(function()
{

    //$( "#slider_filelist" ).sortable();
    //$( "#slider_filelist" ).disableSelection();

    $("#email_template_form").submit(function()
    {
        CKupdate();
        var form_data = $("#email_template_form").serialize();
//        var body = $("#email_temp_body").val();
////        body = encodeURI(body);
////        Encoder.EncodeType = "numerical";
//
//// or to set it to encode to html entities e.g & instead of &
//        Encoder.EncodeType = "entity";
//        body = Encoder.htmlEncode(body);
////        body = encodeHtmlEntity(body);
//        var name = $("#name").val();
//        var subject = $("#subject").val();
//        var status = $("#status").val();
//        alert(form_data); 
        $.ajax(
                {
                    type: "POST",
                    url: SITE_URL + "manage/email_template/validate_email_template",
                    dataType: "json",
                    data: form_data,
//                    data: {body: body, name: name, subject: subject, status: status},
                    success: function(message)
                    {
                        var val = eval(message);
                        if (val.error == 'success')
                        {
                            window.location.href = SITE_URL + 'manage/email_template';
                        }
                        else
                        {
                            $.each(val, function(index, value)
                            {
                                if (value)
                                    $("#" + index).show();
                                $("#" + index).html(value);
                            });
                        }
                    }
                });
    });
})

function remove_image(id)
{
    //alert(id);
    $("#div_" + id).remove();
}