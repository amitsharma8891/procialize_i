<!DOCTYPE html>
<html xmlns:g="http://base.google.com/ns/1.0" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns#"><head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">


        <title><?php echo getSetting()->app_name; ?> - Networking Simplified</title>
        <meta name="description" content="Procialize enables event attendees to network with one another, without barriers of acquaintance. Exhibitors and sponsors can feature their products and services, and thereby provide them a better return on their investment at events. Finally, event organizers a platform on which they can manage networking at their events and earn more revenues from each stakeholder i.e Exhibitors, Speakers, Sponsors and Attendees.">
        <meta name="keywords" content="procialize, procialize app, procialize application, procialize mobile app, procialize mobile application, event organizing app, event listings, event agenda, event management, event management app, event management mobile appication, procialize plus, procialize +, event sessions, exhibitor listing">
        <meta name="author" content="Infini Systems">
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="<?php echo CLIENT_IMAGES ?>favicon.png" type="image/png">




        <link href="<?php echo CLIENT_CSS ?>style.default.css" rel="stylesheet">
       <!-- <link href="<?php echo CLIENT_CSS ?>jquery-ui.css" rel="stylesheet">-->
        <?php //include 'setting.php';?>



        <script src="<?php echo CLIENT_SCRIPTS ?>jquery-1.10.2.min.js"></script>

        <script src="<?php echo CLIENT_SCRIPTS ?>jquery-migrate-1.2.1.min.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

        <script type="text/javascript">
            SITE_URL = '<?php echo SITE_URL ?>';
            var FB_APP_ID = '<?php echo FB_APP_ID ?>';
            var LI_APP_ID = '<?php echo LI_APP_ID ?>';

        </script>

        <style type="text/css">
            .truncate {
                width: 100%;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .page-background {
                background-image: url("<?php echo SITE_URL . 'uploads/app_background/' . getSetting()->app_background_image ?>");
            }
        </style>
    </head>

    <body>
        <?php //echo '---->'.getSetting()->app_background_image.UPLOADS.'app_background/'.getSetting()->app_background_image?>
        <div id="fb-root"></div>
        <section>

            <div class="leftpanel">

                <?php
                if (!$this->session->userdata('client_user_id')) {
                    ?>
                    <div class="logopanel_button">
                        <a href="<?php echo SITE_URL ?>user/login-view"><button class="btn btn-success btn-block center-block " type="button">Login /  Sign up</button></a>
                    </div><!-- logopanel -->   
                    <?php
                }
                ?>




                <div class="leftpanelinner">    

                    <!-- This is only visible to small devices -->		
                    <?php
                    if ($this->session->userdata('client_user_id')) {
                        ?>
                        <a href="<?php echo SITE_URL ?>profile-view">       
                            <div class="">   
                                <div class="media userlogged">
                                    <?php
                                    $profile_pic_path = '';
                                    if ($this->session->userdata('client_user_type') == 'A')
                                        $profile_pic_path = 'attendee';
                                    elseif ($this->session->userdata('client_user_type') == 'E')
                                        $profile_pic_path = 'exhibitor';
                                    elseif ($this->session->userdata('client_user_type') == 'S')
                                        $profile_pic_path = 'speaker';
                                    ?>
                                    <img alt="" src="<?php echo SITE_URL . 'uploads/' . front_image($profile_pic_path, $this->session->userdata('client_user_image')) ?>" class="media-object">
                                    <div class="media-body">
                                        <span class="pull-right pr10"> <i class="fa fa-cog fa_font_14"></i></span>
                                        <h4><?php echo $this->session->userdata('client_user_name'); ?></h4>
                                        <span><?php echo $this->session->userdata('client_user_designation'); ?> </span>
                                        <?php if ($this->session->userdata('client_user_designation')) echo '<br/>'; ?>
                                        <span> <?php echo $this->session->userdata('client_user_company'); ?></span>
                                    </div>

                                </div>
                            </div>
                        </a>
                    <?php } ?>
                    <ul class="nav nav-pills nav-stacked nav-bracket">
                        <li><a href="<?php echo SITE_URL ?>events"><i class="fa fa-home"></i> <span>Home</span></a></li>
                        <li><a href="<?php echo SITE_URL ?>search"><i class="fa fa-search"></i> <span>Search Events</span></a></li>
                        <?php if ($this->session->userdata('client_user_id') && $this->session->userdata('client_event_id')) { ?>
                            <li><a href="<?php echo SITE_URL ?>user/saved/exhibitor"><i class="fa fa-briefcase"></i> <span>Saved Exhibitors</span></a></li>
                            <li><a href="<?php echo SITE_URL ?>user/saved/attendee"><i class="fa fa-user"></i> <span>Saved Attendees</span></a></li>
                            <li><a href="<?php echo SITE_URL ?>user/saved/speaker"><i class="fa fa-microphone"></i> <span>Saved Speakers</span></a></li>
                            <li><a href="javascript:;"  data-toggle="modal" data-target="#share_left_procialize" onClick="share_social('Event')"><i class="fa fa-share-alt"></i> <span>Share <?php echo getSetting()->app_name; ?></span></a></li>
                        <?php } ?>
<!--                        <li><a href="http://procialize.net/metropolis-sponsors" target="blank"><i class="fa fa-money"></i> <span>Our Sponsors</span></a></li>-->
                        <li><a href="<?php echo SITE_URL ?>welcome"><i class="fa fa-list-ul"></i> <span>About <?php echo getSetting()->app_name; ?></span></a></li>
                        <?php if ($this->session->userdata('client_user_id')) { ?>
                            <li><a href="<?php echo SITE_URL ?>client/event/logout"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>
                        <?php } ?>
                    </ul>      
                </div><!-- leftpanelinner -->
            </div><!-- leftpanel -->

            <div class="mainpanel">
                <div class="page-background" id="background_section">
                    <div class="bg-img" id="px_background_img"></div>
                </div>

                <?php
                $count = 0;
                if ($this->session->userdata('client_event_id') && $this->uri->segment(1) == 'events' && $this->uri->segment(2) != '') {
                    $add = (show_normal_ad());
                    //display($add);
                    ?>


                    <?php
                    if ($add) {
                        echo '<div class="ad-bar">';

                        $i = 1;
                        foreach ($add as $val) {
                            if ($val['normal_ad']) {
                                $count++
                                ?>
                                <div id='div<?php echo $i ?>'  style="display:none" > 
                                    <a href="<?php echo 'http://' . $val['link'] ?>" target="_blank" onClick="push_ad_analytics('<?php echo $this->session->userdata('client_attendee_id') ?>', '<?php echo $this->session->userdata('client_user_type') ?>', 'normal_ad', '<?php echo $val['id'] ?>', '<?php echo $this->session->userdata('client_event_id') ?>')"><img src="<?php echo SITE_URL . 'uploads/sponsor/normal_ad/' . $val['normal_ad'] ?>" class="center-block img-responsive" style="height:50px;" ></a>
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

                        var timer = setInterval(showDiv, 5000);
                        var counter = 1;

                        function showDiv() {
                            if (counter === 0) {
                                counter++;
                                return;
                            }

                            $('div', '.ad-bar')
                                    .stop()
                                    .hide()
                                    .filter(function() {
                                        return this.id.match('div' + counter);
                                    })
                                    .show('slow');
                            counter == '<?php echo $count ?>' ? counter = 0 : counter++;

                        }
                    });

                </script>
                <div class="headerbar">

                    <a class="menutoggle"><i class="fa fa-bars"></i></a>
                    <a href="<?php echo SITE_URL ?>events" class="logotop"><img src="<?php echo SITE_URL . 'uploads/app_logo/' . getSetting()->app_logo_big ?>"></a>
                    <p class="titletop">&nbsp;</p>

                    <div class="header-right">
                        <ul class="headermenu">
                            <?php
                            $save_icon = saved_icon($this->uri->segment(2), $this->uri->segment(3));
                            echo $save_icon;
                            ?>

                            <?php
                            $share_icon = share_icon($this->uri->segment(2), $this->uri->segment(3));
                            echo $share_icon;
                            ?>
                            <li>
                                <div class="btn-group">
                                    <a href="<?php echo SITE_URL ?>notification">
                                        <button class="btn btn-default dropdown-toggle tp-icon">
                                            <i class="glyphicon glyphicon-envelope"></i>
                                            <?php
                                            if (getClientNotification())
                                                echo '<span class="badge message_badge">' . getClientNotification() . '</span>';
                                            else
                                                echo '<span class="badge message_badge"></span>';
                                            ?>
                                        </button></a>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:;" onClick="updateSocialNotification()" id="chatview" class="btn btn-default tp-icon chat-icon">
                                    <i class="glyphicon glyphicon-comment mt3"></i>
                                    <?php
//display(socialNotification());
//show_query();
                                    if (socialNotification())
                                        echo '<span class="badge social_badge">!</span>';
                                    else
                                        echo '<span class="badge social_badge"></span>';
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
                                            <input type="text" name="send_to_email_subject" id="send_to_email_subject" class="form-control">
                                        </div>


                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" name="send_message_body" id="send_message_body" placeholder="Write your message here"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success input-sm btn-block">Send</button>
                                        </div>
                                    </form>


                                </div>
                                <hr class="mt9">
                                <?php
                                $title = '';
                                $image = '';
                                $description = '';
                                $url = '';
                                if (isset($target_user_type) && isset($fb_share_data)) {
                                    $share_date = $fb_share_data;
                                    if ($target_user_type == 'A') {
                                        $title = $share_date['attendee_name'];
                                        $image = SITE_URL . 'uploads/' . front_image('attendee', $share_date['attendee_image']);
                                        $description = $share_date['attendee_description'];
                                        $url = SITE_URL . 'events/attendee-detail/' . $share_date['attendee_id'];
                                    } elseif ($target_user_type == 'E') {
                                        $title = $share_date['exhibitor_name'];
                                        $image = SITE_URL . 'uploads/' . front_image('exhibitor', $share_date['exhibitor_logo']);
                                        $description = $share_date['exhibitor_description'];
                                        $url = SITE_URL . 'events/exhibitor-detail/' . $share_date['exhibitor_id'];
                                    } elseif ($target_user_type == 'S') {
                                        $title = $share_date['attendee_name'];
                                        $image = SITE_URL . 'uploads/' . front_image('speaker', $share_date['attendee_image']);
                                        $description = $share_date['attendee_description'];
                                        $url = SITE_URL . 'events/speaker-detail/' . $share_date['attendee_id'];
                                    }
                                }
                                ?>
                                <!--<a href="javascript:;" class="socialShare" ><h4><i class="fa fa-facebook-square"></i> Facebook</h4></a>-->
                                <a href="<?php echo $url ?>" data-image="<?php echo $image ?>" data-title="<?php echo $title ?>" data-desc="<?php echo $description ?>" class="socialShare"><h4><i class="fa fa-facebook-square"></i> Facebook</h4></a>


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
                                <h4 class="modal-title" id="myModalLabel">Share <?php echo getSetting()->app_name; ?></h4>
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
                                            <input type="text" name="share_procialize_to_email_subject" id="share_procialize_to_email_subject" class="form-control" value="<?php echo $this->session->userdata('client_first_name') . ',' . $this->session->userdata('client_user_company') . ' wants you to check out this networking app'; ?>" >
                                        </div>


                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" name="share_procialize_message_body" id="share_procialize_message_body" placeholder="Write your message here">
                                                    Your connection <?php echo $this->session->userdata('client_first_name') . ',' . $this->session->userdata('client_user_company') ?> is using <?php echo getSetting()->app_name; ?> to network with other attendees, speakers and exhibitors at <?php echo $this->session->userdata('client_event_name') ?>
                                            </textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success input-sm btn-block">Send</button>
                                        </div>
                                    </form>


                                </div>
                                <hr class="mt9">
<!--                                        <a href="javascript:;" ><h4><i class="fa fa-facebook-square"></i> Facebook</h4></a>-->
                                <a href="<?php echo SITE_URL ?>" data-image="<?php echo CLIENT_IMAGES ?>pl.png" data-title="<?php echo getSetting()->app_name; ?>" data-desc="A Platform to professionally socialize" class="btnShare"><h4><i class="fa fa-facebook-square"></i> Facebook</h4></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!---left share procialize--->

                <script type="text/javascript">



                </script>


