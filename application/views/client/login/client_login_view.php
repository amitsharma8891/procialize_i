   <!---client header view--->
    <?php $this->load->view(CLIENT_HEADER)?>
    
    <!---client header view--->
    
  
    
<script type="text/javascript" src="http://platform.linkedin.com/in.js">
  api_key: <?php echo LI_APP_ID ?>
  
  authorize: true
</script>
<script type="text/javascript">


    function onLinkedInLoad() 
    {
        LinkedINAuth();//added(remove to make it )
        IN.Event.on(IN, "auth", onLinkedInAuth);
    }
    function LinkedINAuth()
    {
       IN.UI.Authorize().place();
    }
        // 2. Runs when the viewer has authenticated
        function onLinkedInAuth() {
            
                           
            onLinkedInLoad();
            $(".linkedin_loader").html('<img src="<?php echo CLIENT_IMAGES?>/loaders/loader8.gif">');                
            $("#in_auth").hide();  
            IN.API.Profile("me").fields("id","first-name", "last-name", "email-address","pictureUrl","industry","positions","skills","location","public-profile-url","phone-numbers","publications").result(function (data) {
        member = data.values[0]; 
        //make ajax call to update with database
            $.ajax({
                type                                                            : "POST",
                url                                                             : SITE_URL+"client/social_login/linkedin",
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


<div class="contentpanel">
    <div class="panel panel-default panel-stat">
		<div class="panel-heading panel-heading-alt">
		
		  <div class="row">
			
			<div class="col-xs-12">
				<div class="stat">
					
					<div class="omb_login">
						<!--<h3 class="omb_authTitle">Login / Sign up</h3>-->
						<h3 class="text-center" style="color:#58595b">Login / Sign up</h3>
                        <h4 class="text-center" style="color:#58595b; margin-bottom:10px;" >Already have an account? Login</h4>
                        <div class="row omb_row-sm-offset-3">
                            <div class="col-xs-12 col-sm-6">	
                                <!--<form class="omb_loginForm" action="" autocomplete="off" method="POST">-->
                                <form class="omb_loginForm" id="login_form" onsubmit="return false">
                                    <center><span id="user_error" style="color: red;"></span></center>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                    </div>
                                    <span class="help-block"></span>
                                                        
                                    <div class="input-group mb10">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input  type="password" class="form-control" name="password" id="password" placeholder="Password">
                                    </div>
    
                                    <div class="email_loagin_loader text-center" style="width: 100%"></div><button id="email_login" class="btn btn-success btn-block" type="submit">Login</button>
                                <!--</form>-->
                                </form>
                            </div>
                        </div>
                        <div class="row omb_row-sm-offset-3">
                            <div class="col-xs-6 col-sm-3">
                                <label class="checkbox" style="color:#58595b; margin-bottom:10px; font-size:13px;">
                                    <input type="checkbox" value="remember-me">Remember Me
                                </label>
                            </div>
                            <div class="col-xs-6 col-sm-3 mt10">
<!--                                <label class="checkbox" >
                                    <a href="#" data-toggle="modal" data-target="#password" class="mt10">Forgot Password?</a>
                                </label>
                                
--> 
							 <p class="">
                                    <a href="#" data-toggle="modal" data-target="#forget_password" class="mt10">Forgot Password?</a>
                             </p>
                           </div>
                        </div>	
                        
                        <div class="row omb_row-sm-offset-3">
                            <div class="col-xs-12 col-sm-6">
                                <hr>
                            </div>
                        </div>
                        
                        <h4 class="text-center" style="color:#58595b; margin-bottom:10px;">Login / Sign up using</h4>
                      
                        <div class="row omb_row-sm-offset-3">
                            <div class="col-xs-12 col-sm-6 mb10">
                                <div class="linkedin_loader text-center" style="width: 100%"></div><button id="in_auth" class="btn btn-primary btn-block" type="submit" onclick="onLinkedInAuth()"><i class="fa fa-linkedin visible-xs fa_new"></i> <span class="hidden-xs">LinkedIn</span></button>
                            </div>
                        </div>
                        <p class="text-center" style="color:#58595b; margin-bottom:10px;">We recommend sign up via Linkedin. <a href="#" data-toggle="modal" data-target="#why">Why?</a></p>
                       
                        <div class="row omb_row-sm-offset-3 omb_socialButtons">
                            <div class="col-xs-6 col-sm-3">
				<div id="fb-root"></div>				
                                <div class="fb_loader text-center" style="width: 100%"></div><button id="fb-auth" class="btn omb_btn-facebook btn-block" type="submit">
                                        <i class="fa fa-facebook visible-xs fa_new"></i>
                                        <span class="hidden-xs" >Facebook</span>
                                </button>
									
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <a href="<?php echo SITE_URL?>user/register">
                                    <button class="btn omb_btn-facebook btn-block" type="button">Email Id</button>
				</a>		

                           </div>	
                
				
				            	
                        </div>
                        
                          <br>  	
					</div>
					
				</div><!-- stat -->
			</div><!-- col-sm-6 -->
			
		  </div><!-- row -->
      </div>
	</div>
    </div><!-- contentpanel -->

    
    
  </div><!-- mainpanel -->
  
  <div class="rightpanel">
      
      <!--Right panel view--->
      <?php  $this->load->view(CLIENT_RIGHT_PANEL)?>
      <!--Right panel view--->
    
  </div><!-- rightpanel -->
  
  
</section>
<!----login view modal---->
<div id="why" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Why LinkedIn?</h4>
		</div>
      
		<div class="modal-body">
      	<p>You will save time as most of your information can be extracted from LinkedIn</p>
     	<hr class="mb9">
		<p>You can see your connections who are attending the Event</p>
     	<hr class="mb9">
		<p>We promise you, we won’t store your LinkedIn password or any other confidential information</p>
     	<hr class="mb9">
		<p>We also promise you that we won’t post anything on your behalf</p>
		<hr class="mb9">
		<h4 style="text-align:center;">Sign up via Linkedin</h4>
		<button class="btn btn-primary btn-block" type="submit" onclick="onLinkedInLoad()"><i class="fa fa-linkedin visible-xs"></i> <span class="hidden-xs">LinkedIn</span></button>
        </div>
    </div>
	</div>
</div>


<!--##########################forget password#########--->
<div id="forget_password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Forgot Password?</h4>
			</div>
                    <form id="forget_password_form" onsubmit="return false;">
			<div class="modal-body">
					<p>Your Password will be sent to your registered email id.</p>
					<p>Please enter your Email Id</p>
                                        <input type="text" name="forget_password_email" id="forget_password_email" class="form-control" placeholder="Email Id">
					<button type="submit" class="btn btn-success input-sm btn-block mt10">Send</button>
			</div>
                    </form>
			</div>
    		</div>
	</div>
<!--##########################forget password#########--->
<!----login view modal---->

<script type="text/javascript">
var session_user                                                            = '';
var button;
var userInfo;

    window.fbAsyncInit = function() 
    {
        FB.init({ appId: '<?php echo FB_APP_ID;?>', //replace the appId by genuine app id
        status: true, 
        cookie: true,
        xfbml: true,
        oauth: true
    });
    function updateButton(response) 
    {
         button       =   document.getElementById('fb-auth');
         userInfo     =   document.getElementById('user-info');

        if (response.status === 'connected')
        {
            FB.api('/me', function(info) 
            {

            });
            button.onclick = function() 
            {
                $(".fb_loader").html('<img src="<?php echo CLIENT_IMAGES?>/loaders/loader8.gif">');                
            $("#fb-auth").hide();
           FB.api('/me', function(info) 
           {
                login(response, info);
           });	
            };
        }
        else 
        {
            //button.innerHTML = '<img src="ui/client/images/facebook_login.png" />';
            button.onclick = function() {
                FB.login(function(response) {
                    if (response.authResponse) {
                        FB.api('/me', function(info) {
                            login(response, info);
                        });           
                    } else {
                        //user cancelled login or did not grant authorization
                        //showLoader(false);
                    }
                }, {scope:'email,user_birthday,status_update,publish_stream,user_about_me'});          
            }
        }
    }

        // run once with current status and whenever the status changes
        FB.getLoginStatus(updateButton);
        FB.Event.subscribe('auth.statusChange', updateButton);        
    };
    (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol 
            + '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
    }());
    function login(response, info){
        //alert('test76');
        console.log(info);
        if (response.authResponse) {

            var fb_id                   = info.id;
            var first_name              = info.first_name;
            var last_name               = info.last_name;
            var email                   = info.email;
            var public_profile_url      = info.link;
            var profile_pic             = 'https://graph.facebook.com/' + info.id + '/picture?width=300&height=300';
            $.ajax({
                    type                : "post",
                    url                 : SITE_URL+"client/social_login/facebook",
                    data                : {
                                            'fb_id'                 :fb_id,
                                            'first_name'            :first_name,
                                            'last_name'             :last_name,
                                            'email'                 :email,
                                            'public_profile_url'    :public_profile_url,
                                            'profile_pic'           :profile_pic
                                          },
                    dataType            : "json",
                    success: function(msg)
                    {
                        var value1                                                           = eval(msg);
                       //$('#filelist').html(value1.image);
                       location.reload();
                       $(".fb_loader").html('');                
                       $("#fb-auth").show();

                    }
                }); // End ajax method


        }
    }

    function logout(res)
    {
        window.location.href                                            = 'client/logout';    
    }
     </script>        
    <!---fb login---->
               
               
<!--    <button id="fb-auth" style="border: 0 none;"><img src="ui/client/images/facebook_login.png" />Facebook </button>-->
            
           
           
<script type="text/javascript">
$(document).ready(function()
{
   $("#login_form").submit(function()
    {
        $(".email_loagin_loader").html('<img src="<?php echo CLIENT_IMAGES?>/loaders/loader8.gif">');
        $("#email_login").hide();
        var data                                                                = $( "#login_form" ).serialize();
        //var event_id            = $("#hidden_event_id").val();
        $.ajax({
                type                                                            : "POST",
                url                                                             : SITE_URL+"client/user/login",
                dataType                                                        : "json",
                data                                                            : data,
                success : function(msg)
                {
                    var val                                                     = eval(msg);
                    if(val.error == 'error')
                    {
                        $("#user_error").html(val.msg);
                        $(".email_loagin_loader").html('');
                        $("#email_login").show();
                    }
                        

                    if(val.error == 'success' )
                    {
                        //window.location.href = val.redirect;
                        location.reload();
                    }
                        //window.location.href = SITE_URL+'events/event-detail/'+event_id;

                }
            });
    }); 
    
    //chosen
   $("#forget_password_form").submit(function ()
   {
       var email        = $("#forget_password_email").val();
       
       if(!email)
           return false;
       
       $.ajax({
                type                                                            : "POST",
                url                                                             : SITE_URL+"client/user/verify_change_password",
                dataType                                                        : "json",
                data                                                            : {'email':email},
                success : function(msg)
                {
                    var val                                                     = eval(msg);
                    if(val.error == 'error')
                    {
                        $("#forget_password").modal('hide');
                        show_ajax_success('Error',val.msg);
                         $(".email_loagin_loader").html('');
                         $("#email_login").show();
                    }

                    if(val.error == 'success' )
                    {
                        $("#forget_password").modal('hide');
                        show_ajax_success('Success',val.msg);
                    }

                }
            });
       
       
   })
});
</script>
<?php $this->load->view(CLIENT_FOOTER)?>
