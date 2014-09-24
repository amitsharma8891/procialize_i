<html>
    <head>
        <script src="<?php echo CLIENT_SCRIPTS?>jquery-1.10.2.min.js"></script>
        <script type="text/javascript">
        var SITE_URL = '<?php echo SITE_URL?>';
        </script>
    </head>
    <body>
    
  
        <div id="linkedin_loader"></div>
<script type="text/javascript" src="http://platform.linkedin.com/in.js">
    api_key: 75jkhafjcxrmm6
  
    authorize: true;    
    
</script>
<script type="text/javascript">
var SITE_URL = '<?php echo SITE_URL?>';
    $(document).ready(function ()
    {
        //alert('Login Through Linkedin');
        $("#linkedin_loader").html('Please Wait...');
        setTimeout(function() {
            
        onLinkedInLoad();
        }, 1000);
        
    });
    function onLinkedInLoad() 
    {
        $("#linkedin_loader").html('');
        LinkedINAuth();//added(remove to make it )
        IN.Event.on(IN, "auth", onLinkedInAuth);
    }
    function LinkedINAuth()
    {
       IN.UI.Authorize().place();
    }
        // 2. Runs when the viewer has authenticated
        function onLinkedInAuth() {
            
             $("#linkedin_loader").html('');              
            //onLinkedInLoad();
            $(".linkedin_loader").html('<img src="<?php echo CLIENT_IMAGES?>/loaders/loader8.gif">');                
            $("#in_auth").hide();  
            IN.API.Profile("me").fields("id","first-name", "last-name", "email-address","pictureUrl","industry","positions","skills","location","public-profile-url","phone-numbers","publications").result(function (data) {
        member = data.values[0]; 
        //make ajax call to update with database
            $.ajax({
                type                                                            : "POST",
                url                                                             : SITE_URL+"API/event_api_call/linkedin_login",
                dataType                                                        : "json",
                data                                                            : {
                                                                                    'linkedin_id':member.id,
                                                                                    'email':member.emailAddress,
                                                                                    'first_name':member.firstName,
                                                                                    'last_name':member.lastName,
                                                                                    'profile_pic':member.pictureUrl,
                                                                                    'industry':member.industry,
                                                                                    'position':member.positions,
                                                                                    'skills':member.skills,
                                                                                    'location':member.location,
                                                                                    'public_profile_url':member.publicProfileUrl,
                                                                                   },
                success : function(msg)
                {
                    var val                                                     = eval(msg);
                    
                    if(val.error == 'error' )
                    {
                        alert('Something Went Wrong');
                        $(".linkedin_loader").html('');                
                        $("#in_auth").show();  
                    }
                    if(val.error == 'success' )
                    {
                        location.reload();
                    }
                    

                }
            });
        
        //console.log(data);
            }).error(function (data) {
                console.log(data);
            });
        }
</script>

    </body>
</html>
    