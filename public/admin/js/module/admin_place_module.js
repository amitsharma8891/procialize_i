function CKupdate() {
    for (var instance in CKEDITOR.instances)
        CKEDITOR.instances[instance].updateElement();
}

$(document).ready(function()
{
    $("#email_template_form").submit(function()
    {
        CKupdate(); 
        var form_data = $("#email_template_form").serialize();
        $.ajax(
                {
                    type: "POST",
                    url: SITE_URL + "manage/place/validate_place",
                    dataType: "json",
                    data: form_data,
//                    data: {body: body, name: name, subject: subject, status: status},
                    success: function(message)
                    {
                        var val = eval(message);
                        if (val.error == 'success')
                        {
                            window.location.href = SITE_URL + 'manage/place';
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