$(document).ready(function() 
{
    $("#mesaage_checkbox").click(function ()
    {
        if($(this).is(':checked'))
            $("#search_all_user").attr('disabled','disabled');
        else
            $("#search_all_user").removeAttr('disabled');
    });
    setInterval(function(){update_notification()}, (60*500));
     $('#gmail_share').click(function() {
                $('.gshare').slideToggle("fast");
        });
        
     $("#procialize_gmail_share").click(function()
        {
            $('.procialize_gshare').slideToggle("fast");
        });
        $(".socialSave").click(function()
        {
            
            var subject_id  = $("#subject_id_notfication").val();
            var subject_type = $("#subject_type_notfication").val();
            var value   = $(this).val();
            //alert(subject_id);
            if(value)
            {
                $(".socialSave").removeClass('active');
                saveToggle(subject_id,subject_type,'Sav','delete');
                $(".socialSave").val('');
                return false;
            }
            else
            {
                $(".socialSave").addClass('active');
                saveToggle(subject_id,subject_type,'Sav','insert');
                $(".socialSave").val('TRUE');
                return false;
            }
            //alert($(this).val());
        });
        
        
        $(".socialShare").click(function()
        {
            elem = $(this);
            postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image'));
            var subject_id  = $("#subject_id_notfication").val();
            var subject_type = $("#subject_type_notfication").val();
            setTimeout(function(){saveToggle(subject_id,subject_type,'Sh','insert');}, 8000);
            return false;
            
        });
        
        
        $("#share_via_email_form").submit(function()
        {
            //var form_data       = $("#send_email_form").val();
            var to              = $("#send_to_email").val()
            var body            = $("#send_message_body").val()
            var subject         = $("#send_to_email_subject").val()
            var subject_id      = $("#subject_id_notfication").val();
            var subject_type    = $("#subject_type_notfication").val();
            
            if(!to)
                return false;
            
            $.ajax({
                type                                                            : 'POST',
                url                                                             : SITE_URL+"client/user_notification/share_via_email",
                dataType                                                        : 'json',
                data                                                            : {'subject_id':subject_id,'subject_type':subject_type,'to':to,'subject':subject,'body':body},
                success: function(msg)
                {
                    var data                                                    = eval(msg);
                    if(data.error == 'success')
                    {
                        $(".remove_rsvp").remove();
                        $("#message_text").val('');
                        $("#share").modal('hide');
                        var redirect = location.reload();
                        show_ajax_success('Success',data.msg,redirect);
                        
                        
                    }
                    else
                    {
                        alert(data.msg);
                    }
                    
                }
            });
        });
        
        $("#share_procialize_form").submit(function()
        {
            //var form_data       = $("#send_email_form").val();
            var to              = $("#share_procialize_to_email").val()
            var body            = $("#share_procialize_message_body").val()
            var subject         = $("#share_procialize_to_email_subject").val()
            
            
            if(!to)
                return false;
            
            $.ajax({
                type                                                            : 'POST',
                url                                                             : SITE_URL+"client/user_notification/share_procialize",
                dataType                                                        : 'json',
                data                                                            : {'to':to,'subject':subject,'body':body},
                success: function(msg)
                {
                    var data                                                    = eval(msg);
                    if(data.error == 'success')
                    {
                        $(".remove_rsvp").remove();
                        $("#message_text").val('');
                        $("#share_left_procialize").modal('hide');
                        //var redirect = location.reload();
                        show_ajax_success('Success','Shared Successfully');
                        
                    }
                    else
                    {
                        show_ajax_success('Error',data.msg);
                    }
                    
                }
            });
        });   
        
        $('.btnShare').click(function(){
        elem = $(this);
        postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image'));

        //setTimeout(function(){$("#share_left_procialize").modal('hide')}, 3000);
        return false;
        });
});//document ready ends here

window.fbAsyncInit = function(){
        FB.init({
            appId: FB_APP_ID, status: true, cookie: true, xfbml: true }); 
        };
        (function(d, debug){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];if   (d.getElementById(id)) {return;}js = d.createElement('script'); js.id = id; js.async = true;js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";ref.parentNode.insertBefore(js, ref);}(document, /*debug*/ false));
        function postToFeed(title, desc, url, image){
        var obj = {method: 'feed',link: url, picture: image,name: title,description: desc};
        function callback(response)
        {
            if (response) 
            {
                $("#share_left_procialize").modal('hide');
            }
        }
        FB.ui(obj, callback);
        }

function save_feedback()
{
    var rating          = $("#rating").val();
    var feedback_type   = $("#feedback_type").val();
    var target_id       = $("#target_id").val();
    if(!rating)
        return false;
    
    $.cookie(target_id, feedback_type, { expires: 365 });
    $.ajax({
                type                                                            : 'POST',
                url                                                             : SITE_URL+"client/user_notification/feedback",
                dataType                                                        : 'json',
                data                                                            : {'target_id':target_id,'rating':rating,'feedback_type':feedback_type},
                success: function(msg)
                {
                    var data                                                    = eval(msg);
                    if(data.error == 'success')
                    {
                        $("#")
                        $(".remove_rsvp").remove();
                        $("#message_text").val('');
                        //alert(data.msg);
                        $("#ajax_success_message").modal('show');
                        $("#ajax_success_message_body").html(data.msg);
                        
                        location.reload();
                    }
                    else
                    {
                        alert(data.msg);
                    }
                    
                }
            });
    
}

function show_ajax_success(error_type,message,redirect)
{
    $("#ajax_success_message").modal('show');
    $(".modal-title").html(error_type);
    $("#ajax_success_message_body").html(message);
    setTimeout(function(){
        if(redirect)
        {
            window.location.href = redirect;
            //$("#ajax_success_message").modal('hide');
        }
        else
        {
            $("#ajax_success_message").modal('hide');
        }
    }, 5000);
}

function share_social()
    {
        var subject_id  = $("#subject_id_notfication").val();
        var subject_type = $("#subject_type_notfication").val();
        //saveToggle(subject_id,subject_type,'Sh','insert','');
    }
    
    function saveToggle(subject_id,subject_type,type,toggle_flag)
    {
        $.ajax({
                type                                                            : 'POST',
                url                                                             : SITE_URL+"client/user_notification/saveToggle",
                dataType                                                        : 'json',
                data                                                            : {'subject_id':subject_id,'subject_type':subject_type, 'type':type,'toggle_flag':toggle_flag},
                success: function(msg)
                {
                    var data                                                    = eval(msg);
                    if(data.error == 'success')
                    {
                        $(".remove_rsvp").remove();
                        $("#message_text").val('');

                        $("#share").modal('hide');
                        //var redirect = location.reload();
                        if(type == 'Sav')
                        show_ajax_success('Success',data.msg)
                        return false;
                    }
                    else
                    {
                        var redirect = location.reload();
                        show_ajax_success('Error',data.msg);
                        return false;
                    }
                    
                }
            });
    }
    
    function share()
    {
        
    }
    
    function updateSocialNotification()
    {
        $.ajax({
                type                                                            : 'POST',
                url                                                             : SITE_URL+"client/user_notification/update_social_notification",
                dataType                                                        : 'json',
               // data                                                            : {'subject_id':subject_id,'subject_type':subject_type, 'type':type,'toggle_flag':toggle_flag},
                success: function(msg)
                {
                    var data                                                    = eval(msg);
                    if(data.error == 'success')
                    {
                        $('.social_badge').remove();
                    }
                    
                    
                }
            });
    }
    
function push_ad_analytics(objetc_id,object_type,type,ad_id,event_id)
{
    $.ajax({
            type                                                                : 'POST',
            url                                                                 : SITE_URL+"client/user_notification/push_ad_analytics",
            dataType                                                            : 'json',
            data                                                                : {'object_id':objetc_id,'object_type':object_type,'ad_type':type,'ad_id':ad_id,'event_id':event_id},
            success: function(msg)
            {
                var data                                                        = eval(msg);
                
                

            }
        });
        
        $("#splash_ad_pop").modal('hide');
}

function update_notification()
{
    $.ajax({
            type                                                                : 'POST',
            url                                                                 : SITE_URL+"client/user_notification/web_push_notification",
            dataType                                                            : 'json',
            //data                                                                : {'object_id':objetc_id,'object_type':object_type,'ad_type':type,'ad_id':ad_id,'event_id':event_id},
            success: function(msg)
            {
                var val                                                         = eval(msg);
                if(val.message_count != 0)
                {
                    $(".message_badge").html(val.message_count);
                }
                if(val.social_notify)
                {
                    $(".social_badge").html('!');
                }
                

            }
        });
        
        
}