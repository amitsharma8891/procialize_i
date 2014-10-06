$(document).ready(function()
{

    //$( "#slider_filelist" ).sortable();
    //$( "#slider_filelist" ).disableSelection();

    $("#setting_form").submit(function()
    {
        var form_data = $("#setting_form").serialize();
        $.ajax(
                {
                    type: "POST",
                    url: SITE_URL + "manage/setting/validate_setting",
                    dataType: "json",
                    data: form_data,
                    success: function(message)
                    {
                        var val = eval(message);
                        if (val.error == 'success')
                        {
                            alert('Update Successfully!');
//                    location.reload();
                            window.location = SITE_URL + "manage/index";
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