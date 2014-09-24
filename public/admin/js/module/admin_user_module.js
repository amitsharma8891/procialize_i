
$(document).ready(function()
{

    //$( "#slider_filelist" ).sortable();
    //$( "#slider_filelist" ).disableSelection();

    $("#form1").submit(function()
    {

        var form_data = $("#form1").serialize();
        $.ajax(
                {
                    type: "POST",
                    url: SITE_URL + "manage/user/validate_user",
                    dataType: "json",
                    data: form_data,
                    success: function(message)
                    {
                        var val = eval(message);
                        if (message.email == 'email_not_match')
                        {
                            $("#email_err").show();
                            $("#email_err").html("Email id can’t be changed once registered, please delete and re-create the profile if required.");
                        } else {
                            $("#email_err").hide();
                            $("#email_err").html();
                        }
                        if (message.current_pass == 'not_match')
                        {
                            $("#current_password_err").show();
                            $("#current_password_err").html("Current password Is not matched Please try again!!");
                        } else {
                            $("#current_password_err").hide();
                            $("#current_password_err").html();
                        }
                        if (typeof (val.password_err) == 'undefined') {
//                            if (message.email != 'email_not_match') {
                            $('span[id!="current_password_err"]').html('');
                            if (message.email == 'email_not_match')
                            {
                                $("#email_err").show();
                                $("#email_err").html("Email id can’t be changed once registered, please delete and re-create the profile if required.");
                            } else {
                                $("#email_err").hide();
                                $("#email_err").html();
                            }
//                            }
                        }
                        if (val.error == 'success')
                        {
                            window.location.href = SITE_URL + 'manage/index';
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