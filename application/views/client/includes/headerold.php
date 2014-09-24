<!DOCTYPE html>
<html xmlns:g="http://base.google.com/ns/1.0" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns#"><head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<head>
    <title>Procialize</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="author" content="">
  
  <?php 
    $page   = $this->uri->segment(2);
    $page_array = array(
        'attendee-detail',
        'speaker-detail',
        'exhibitor-detail',
    );
        $title = 'Procialize';
        $image = CLIENT_IMAGES.'fb_test.jpg';
        $description = 'A Platform to professionally socialize';
        $url = 'http://procialize.in/beta';
    if (in_array($page, $page_array))
    {
        
        if(isset($target_user_type) && isset($fb_share_data))
        {
            $share_date = $fb_share_data;
            if($target_user_type == 'A')
            {
                $title        = $share_date['attendee_name'];
                $image        = CLIENT_IMAGES.'fb_test.jpg';//SITE_URL.'uploads/'.front_image('attendee',$share_date['attendee_image']);
                $description  = $share_date['attendee_description'];
                $url          = SITE_URL.'events/attendee-detail/'.$share_date['attendee_id'];
            }
            elseif($target_user_type == 'E')
            {
                $title        = $share_date['exhibitor_name'];
                $image        = SITE_URL.'uploads/'.front_image('exhibitor',$share_date['exhibitor_logo']);
                $description  = $share_date['exhibitor_description'];
                $url          = SITE_URL.'events/exhibitor-detail/'.$share_date['exhibitor_id'];
            }
            elseif($target_user_type == 'S')
            {
                $title        = $share_date['attendee_name'];
                $image        = SITE_URL.'uploads/'.front_image('speaker',$share_date['attendee_image']);
                $description  = $share_date['attendee_description'];
                $url          = SITE_URL.'events/speaker-detail/'.$share_date['attendee_id'];
            }
        }
    }
  ?>

<meta charset="iso-8859-1">
<meta property="fb:app_id" content="664018516966781"/>
<meta property="fb:admins" content="1408549756094246" />
<meta property="og:locale" content="en_US"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="<?php echo $title?>"/>
<meta property="og:description" content="<?php echo $description?>"/>
<meta property="og:url" content="<?php echo $url?>"/>
<meta property="og:site_name" content="procialize.in"/>
<meta property="og:image" content="<?php echo $image?>"/>

  <!--<a href="<?php echo SITE_URL?>" data-image="<?php echo CLIENT_IMAGES?>pl.png" data-title="Procialize" data-desc="A Platform to professionally socialize" class="btnShare"><h4><i class="fa fa-facebook-square"></i> Facebook</h4></a>-->
  <link rel="shortcut icon" href="<?php echo CLIENT_IMAGES?>favicon.png" type="image/png">


  
  
  <link href="<?php echo CLIENT_CSS?>style.default.css" rel="stylesheet">
 <!-- <link href="<?php echo CLIENT_CSS?>jquery-ui.css" rel="stylesheet">-->
  
  
  
  <script src="<?php echo CLIENT_SCRIPTS?>jquery-1.10.2.min.js"></script>

  <script src="<?php echo CLIENT_SCRIPTS?>jquery-migrate-1.2.1.min.js"></script>

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
  
<script type="text/javascript">
  var SITE_URL                                                                  = '<?php echo SITE_URL?>';
  
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=664018516966781&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
   
</script>
</head>

<body>
<div id="fb-root"></div>
<section>
  
  <div class="leftpanel">
    
      <?php 
        if(!$this->session->userdata('client_user_id'))
        {
            ?>
            <div class="logopanel_button">
                <a href="<?php echo SITE_URL?>user/login-view"><button class="btn btn-success btn-block center-block " type="button">Login /  Sign up</button></a>
            </div><!-- logopanel -->   
            <?php
        }
      ?>
     
    
    
    
    <div class="leftpanelinner">    
        
        <!-- This is only visible to small devices -->		
        <?php 
            if($this->session->userdata('client_user_id'))
            {
        ?>
        <a href="<?php echo SITE_URL?>profile-view">       
            <div class="">   
                <div class="media userlogged">
                    <?php 
                        $profile_pic_path = '';
                        if($this->session->userdata('client_user_type') == 'A')
                            $profile_pic_path = 'attendee';
                        elseif($this->session->userdata('client_user_type') == 'E')
                            $profile_pic_path = 'exhibitor';
                        elseif($this->session->userdata('client_user_type') == 'S')
                            $profile_pic_path = 'speaker';
                    ?>
                    <img alt="" src="<?php echo SITE_URL.'uploads/'.  front_image($profile_pic_path, $this->session->userdata('client_user_image'))?>" class="media-object">
                    <div class="media-body">
                    <span class="pull-right"> <i class="fa fa-cog fa_font_14"></i></span>
                        <h4><?php echo $this->session->userdata('client_user_name');?></h4>
                        <span><?php echo $this->session->userdata('client_user_designation');?> </span><br/><span> <?php echo $this->session->userdata('client_user_company');?></span>
                    </div>

                </div>
            </div>
	</a>
            <?php } ?>
       <ul class="nav nav-pills nav-stacked nav-bracket">
            <li><a href="<?php echo SITE_URL?>events"><i class="fa fa-home"></i> <span>Home</span></a></li>
            <li><a href="<?php echo SITE_URL?>search"><i class="fa fa-search"></i> <span>Search Events</span></a></li>
            <?php if($this->session->userdata('client_user_id')) {?>
            <li><a href="<?php echo SITE_URL?>user/saved/exhibitor"><i class="fa fa-briefcase"></i> <span>Saved Exhibitors</span></a></li>
            <li><a href="<?php echo SITE_URL?>user/saved/attendee"><i class="fa fa-user"></i> <span>Saved Attendees</span></a></li>
            <li><a href="<?php echo SITE_URL?>user/saved/speaker"><i class="fa fa-microphone"></i> <span>Saved Speakers</span></a></li>
            <?php 
                $page   = $this->uri->segment(2);
                $page_array = array(
                    'attendee-detail',
                    'speaker-detail',
                    'exhibitor-detail',
                );
                
                if(!in_array($page, $page_array))
                {
            ?>
            <li><a href="javascript:;"  data-toggle="modal" data-target="#share_left_procialize" onClick="share_social('Event')"><i class="fa fa-share-alt"></i> <span>Share Procialize</span></a></li>
            <?php }
                
                } ?>
            <li><a href="<?php echo SITE_URL?>welcome"><i class="fa fa-list-ul"></i> <span>About Procialize</span></a></li>
            <?php if($this->session->userdata('client_user_id')) {?>
            <li><a href="<?php echo SITE_URL?>client/event/logout"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>
             <?php } ?>
      </ul>      
    </div><!-- leftpanelinner -->
  </div><!-- leftpanel -->
  
	<div class="mainpanel">
	<div class="page-background" id="background_section">
            <div class="bg-img" id="px_background_img"></div>
		</div>
            
            <?php 
            $count =0;
                if($this->session->userdata('client_event_id') && $this->uri->segment(1) == 'events' && $this->uri->segment(2) != '')
                {
                    $add  = (show_normal_ad());
                    ?>

            
                    <?php 
                        if($add)
                        {
                            echo '<div class="ad-bar">';
                        
                            $i = 1;
                            foreach($add as $val)
                            {
                                if($val['normal_ad'])
                                {
                                    $count++
                                ?>
                                        <div id='div<?php echo $i?>'  style="display:none" > 
                                            <a href="<?php echo 'http://'.$val['link']?>" target="_blank" onclick="push_ad_analytics()"><img src="<?php echo SITE_URL.'uploads/sponsor/normal_ad/'.$val['normal_ad']?>" class="center-block img-responsive" style="height:50px;" ></a>
                                        </div>

                                <?php
                                }
                                $i++;
                            }
                            echo '</div>';
                        }
                     ?>
					 
                    
         <?php
                }
            ?>
        <script type="text/javascript">
                $(document).ready(function() {
                   
                    var timer = setInterval( showDiv, 5000);
                    var counter = 1;

                    function showDiv() {
                      if (counter ===0) { counter++; return; }

                      $('div','.ad-bar')
                        .stop()
                        .hide()
                        .filter( function() { return this.id.match('div' + counter); })   
                        .show('slow');
                      counter == '<?php echo $count?>'? counter = 0 : counter++; 

                    }
                });
            
            </script>
    <div class="headerbar">
      
      <a class="menutoggle"><i class="fa fa-bars"></i></a>
      <a href="<?php echo SITE_URL?>events" class="logotop"><img src="<?php echo CLIENT_IMAGES?>pl.png"></a>
	  <p class="titletop">&nbsp;</p>
      
      <div class="header-right">
        <ul class="headermenu">
            <?php 
                $save_icon  = saved_icon($this->uri->segment(2),$this->uri->segment(3));
                echo $save_icon;
            ?>
            
          <?php 
                $share_icon  = share_icon($this->uri->segment(2),$this->uri->segment(3));
                echo $share_icon;
          ?>
       <li>
            <div class="btn-group">
              <a href="<?php echo SITE_URL?>notification">
              <button class="btn btn-default dropdown-toggle tp-icon">
                <i class="glyphicon glyphicon-envelope"></i>
                 <?php 
                    if(getClientNotification())
                        echo '<span class="badge">'.getClientNotification().'</span>';
                ?>
              </button></a>
            </div>
</li>
<li>
    <a href="javascript:;" onClick="updateSocialNotification()" id="chatview" class="btn btn-default tp-icon chat-icon">
                <i class="glyphicon glyphicon-comment"></i>
                <?php 
                //display(socialNotification());
                //show_query();
                if(socialNotification())
                 echo '<span class="badge social_badge">N</span>';
                ?>
                
                       
            </a>
          </li>
        </ul>
      </div><!-- header-right -->
      
    </div><!-- headerbar -->    
    
    
    <!--top share pop up---->
    <div id="share" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Share via</h4>
			</div>
      
			<div class="modal-body">
                                     <a href="#"  id="gmail_share" ><h4><i class="fa fa-envelope"></i> Email</h4></a>
                                        <div class="gshare" style="display:none;">
                                        
                                            <form class="form-horizontal" id="share_via_email_form" onSubmit="return false;">
                                            <div class="form-group">
                                                <p>To: </p>
                                                <input type="text" name="send_to_email" id="send_to_email" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <p>Subject: </p>
                                                <input type="text" name="send_to_email_subject" id="send_to_email_subject" class="form-control" value="Procialize: Interesting <?php echo @$type . ' '.@$title ?> <?php ?>">
                                            </div>

                                        
                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" name="send_message_body" id="send_message_body" placeholder="Write your message here">Hi,

I came across this interesting profile of <?php echo $type . ' '.$title ?> in "<?php echo $this->session->userdata('client_event_name')?>".

Use the App to explore this person and socialize more with people of your interest.

Cheers. 
</textarea>
                                            </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success input-sm btn-block">Send</button>
                                        </div>
                                    </form>
                                       
                                       
                                        </div>
					<hr class="mt9">
                                        <?php 
                                        
                                        ?>
					<!--<a href="javascript:;" class="socialShare" ><h4><i class="fa fa-facebook-square"></i> Facebook</h4></a>-->
                                        <!--<a href="<?php echo $url?>" data-image="<?php echo $image?>" data-title="<?php echo $title?>" data-desc="<?php echo $description?>" class="socialShare"><h4><i class="fa fa-facebook-square"></i> Facebook</h4></a>-->
                                        <!--<div class="fb-share-button" data-href="<?php echo $url?>" data-type="link" data-image="<?php echo $image?>pl.png" data-title="Procialize" data-desc="A Platform to professionally socialize">Share</div>-->
                                        
			</div>
			</div>
    		</div>
	</div>
    <!--top share pop up---->
    
    
    
    <!---left share procialize--->
    <div id="share_left_procialize" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Share Procialize</h4>
			</div>
      
			<div class="modal-body">
                            <!--<a href="javascript:;" class="socialShare"><h4><i class="fa fa-globe"></i> Email</h4></a>--> 
					<!--<hr class="mt9">-->
<!--                                        <a href="mailto:email@mysite.com?subject=Hi there&amp;body=This is my body message" target="_blank"  id="gmail_share" ><h4><i class="fa fa-envelope"></i> Gmail</h4></a>
-->                                    <a href="#"  id="procialize_gmail_share" ><h4><i class="fa fa-envelope"></i> Email</h4></a>
                                        <div class="procialize_gshare" style="display:none;">
                                        
                                            <form class="form-horizontal" id="share_procialize_form" onSubmit="return false;">
                                            <div class="form-group">
                                                <p>To: </p>
                                                <input type="text" name="share_procialize_to_email" id="share_procialize_to_email" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <p>Subject: </p>
                                                <input type="text" name="share_procialize_to_email_subject" id="share_procialize_to_email_subject" class="form-control" value="Interesting App Procialize">
                                            </div>

                                        
                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" name="share_procialize_message_body" id="share_procialize_message_body" placeholder="Write your message here">Hi,

I came across this interesting App "Procialize" which allows users to professionally socialize, view complete event details (Agenda, Speakers, Attendees, Exhibitors) on the App, and do lot more. 

I strongly recommend you to use this App and increase your Professional network. 

Cheers. 
</textarea>
                                            </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success input-sm btn-block">Send</button>
                                        </div>
                                    </form>
                                       
                                       
                                        </div>
					<hr class="mt9">
<!--                                        <a href="javascript:;" ><h4><i class="fa fa-facebook-square"></i> Facebook</h4></a>-->
                                        <!--<a href="<?php echo SITE_URL?>" data-image="<?php echo CLIENT_IMAGES?>pl.png" data-title="Procialize" data-desc="A Platform to professionally socialize" class="btnShare"><h4><i class="fa fa-facebook-square"></i> Facebook</h4></a>-->
                                        <div class="fb-share-button"  data-type="link"></div>
			</div>
			</div>
    		</div>
	</div>
    <!---left share procialize--->
    
<script type="text/javascript">
    
    
    
</script>
    
    
    