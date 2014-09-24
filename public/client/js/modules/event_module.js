$(document).ready(function() 
{
    var source                                        = SITE_URL+'client/event/search?type='
    var type                                          = '';
    if(type != '')
    {
        source                                        = 'client/event/autocomplete?type=';
    }
    $( "#search_" ).autocomplete(
      {

              source                                  :source,
              minLength                               :3,
              width                                   : 320,
              max                                     : 10,
              select: function(event,ui ) {
                  //alert(ui.item.label);
                      window.location.href            = SITE_URL+'events?term='+ui.item.value;
                  }
     }).keydown(function(e)
         {
             if (e.keyCode === 13)
             {
                 search_();
             }
         });
          
        
    

    $('.open_gallery img').click(function(e)
    {
        e.preventDefault();
        $("#gallery_image_pop").modal('show');
        $(".place_gallery_image").html('<img class="img-responsive" src="'+$(this).attr("src")+'">');
    });
    
    $("#passcode_form").submit(function(e)
    {
        e.preventDefault();
        var passcode                                                            = $("#passcode").val();
        //if(!passcode)
            //return false;
        $.ajax(
        {
            type                                                                : "POST",
            url                                                                 : SITE_URL+"client/event/event_login",
            dataType                                                            : "json",
            data                                                                : {'passcode':passcode},
            success : function(message)
            {
                var val                                                         = eval(message);
                
                if(val.error == 'success')
                {
                    $("#passcode").val('');
                    location.reload();
                }
                else
                {
                    show_ajax_success('Error',val.msg);
                }
                
                    

            }
        });
    });//passcode form ends
    
    var width = screen.width
    if(width == 768)
    {
        $(".changeListClass").removeClass('col-sm-6 col-md-4');
        $(".changeListClass").addClass('col-sm-12');
    }

   else
    {
       $(".changeListClass").addClass('col-sm-6 col-md-4');  
    }
    
    $("#send_message_form").submit(function (e)
    {
        e.preventDefault();
        $("#send_message_btn").hide();
       $(".loader").html('Please Wait...');
        var form_data           = $("#send_message_form").serialize();
        var message             = $("#message_text_val").val();
        
        if(!message)
        {
            //alert('Please give message');
            $("#message_text_val_err").html('This field is required.')
            $("#send_message_btn").show();
            $(".loader").html('');
            return false;
        }
            
         $.ajax({
                type                                                            : 'POST',
                url                                                             : SITE_URL+"client/event/send_message",
                dataType                                                        : 'json',
                data                                                            : form_data,
                success: function(msg)
                {
                    var data                                                    = eval(msg);
                    if(data.error == 'success')
                    {
                        $("#")
                        $(".remove_rsvp").remove();
                        //$("#new_msg").modal('hide');
                        //$("#ajax_success_message").modal('show');
                        //$("#ajax_success_message_body").html(data.msg);
                        alert(data.msg);
                        location.reload();
                    }
                    else
                    {
                        $("#send_message_btn").show();
                        $(".loader").html('');
                        $("#ajax_success_message").modal('show');
                        $("#ajax_success_message_body").html(data.msg);
                    }
                    
                }
            });
    });
           
     jQuery(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap'});   
});//document ready ends here

function search_()
{
    if($("#search_").val() != '')
    window.location.href                            = "?type=&term="+encodeURIComponent($("#search_").val());
} 

function event_registration()
{
    $.ajax(
    {
            type                                                                : "POST",
            url                                                                 : SITE_URL+"client/event/event_registration",
            dataType                                                            : "json",
            //data                                                                : data,
            success : function(msg)
            {
                var val                                                         = eval(msg);
                $(".modal").modal('hide');
                show_ajax_success('Success',val.msg);
            }
    });
    
}

function serach_user(type,offset,scroll)
{
    //alert(scroll);
    //$("#ajax_attendee").html('Please Wait....');
    if(scroll == 'scroll')
    {
        $(".user_list_loader").show();
        $(".user_list_loader").html('<img src="'+SITE_URL+'public/client/images/loaders/loader8.gif">');
    }
    var keyword  = $("#search_user").val()
    
    if(keyword)
    {
        $(".load_more").hide();
    }
    
    $.ajax(
    {
         type                                                                   : "GET",
         url                                                                    : SITE_URL+"client/event/search_user",
         dataType                                                               : "json",
         data                                                                   : {'type':type,'term':keyword,'offset':offset,'scroll':scroll},
         success : function(message)
         {
             var val                                                            = eval(message);
            $(".user_list_loader").hide();
            $(".user_list_loader").html('');  
            if(scroll == 'scroll')
                $("#ajax_attendee").append(val.user);
            else
                $("#ajax_attendee").html(val.user);



         }
     });
     return false;
}