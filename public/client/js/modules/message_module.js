$(document).ready(function() 
{
    $("#reply_form").submit(function(e) 
    {
        e.preventDefault();
        var form_data                                                           = $("#reply_form").serialize();
        $.ajax({
                type                                                            : 'POST',
                url                                                             : SITE_URL+"client/event/reply_message",
                dataType                                                        : 'json',
                data                                                            : form_data,
                success: function(msg)
                {
                    var data                                                    = eval(msg);
                    if(data.error == 'success')
                    {
                        $("#")
                        $(".remove_rsvp").remove();
                        $("#message_text").val('');
                        var redirect = location.reload();
                        show_ajax_success('Success',data.msg,redirect);
                    }
                    else
                    {
                        show_ajax_success('Success',data.msg,redirect);
                    }
                    
                }
            });
    });
           
     jQuery(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap'});   
});//document ready ends here


function meeting_reply(responce_type)
{
    var target_id               = $("#target_id").val();                                                          
    var target_type             = $("#target_type").val();                                                          
    var event_id                = $("#event_id").val();                                                          
    var notification_id         = $("#notification_id").val();                                                          
    var meeting_id              = $("#meeting_id").val(); 
    var meeting_reply_text      = $("#meeting_reply_text").val(); 
    if(responce_type == 'decline')
        meeting_reply_text      = $("#meeting_reply_decline_text").val(); 
    
    $.ajax({
                type                                                            : 'POST',
                url                                                             : SITE_URL+"client/event/reply_meeting",
                dataType                                                        : 'json',
                data                                                            : {
                                                                                    'target_id' : target_id,       
                                                                                    'target_type' : target_type,       
                                                                                    'event_id' : event_id,       
                                                                                    'notification_id' : notification_id,       
                                                                                    'meeting_id' : meeting_id,       
                                                                                    'meeting_reply_text' : meeting_reply_text,       
                                                                                    'responce_type' : responce_type,       
                                                                                    },
                success: function(msg)
                {
                    var data                                                    = eval(msg);
                    if(data.error == 'success')
                    {
                        
                        $("#setupmeeting").modal('hide');
                        $("#declinemeeting").modal('hide');
                        $("#ajax_success_message").modal('show');
                        $("#ajax_success_message_body").html(data.msg);
                        //location.reload();
                    }
                    else
                    {
                        $("#setupmeeting").modal('hide');
                        $("#declinemeeting").modal('hide');
                        $("#ajax_success_message").modal('show');
                        $("#ajax_success_message_body").html(data.msg);
                    }
                    
                }
            });
}
