<div class="right-compose">
    <p class="btn">&nbsp;</p>
    <!--        <a data-toggle="modal" data-target="#compose" class="btn btn-success btn-block">Compose</a>-->
</div>

<!-- Tab panes -->

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-justified">
    <li class="active"><a href="#rp-alluser" data-toggle="tab"><i class="fa fa-comments"></i></a></li>
    <li><a href="#rp-favorites" data-toggle="tab"><i class="fa  fa-twitter"></i></a></li>

</ul>
<input type="hidden" id="start_val" name="start_val" value="0">
<input type="hidden" id="end_val" name="end_val" value="10">
<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="rp-alluser">
        <ul class="chatuserlist">
            <?php
            $this->client_notification_model->notification_type = '';
            $this->client_notification_model->attendee_type = '';
            $social_message = getSocialMessages();
//            display($social_message);
//            die;
            if ($social_message && $this->session->userdata('client_user_id') && $this->session->userdata('client_event_id')) {
                echo 'Social messages will be shown here.<br><br>Messages:<ul class="chatuserlist">';
                $i = 0;
                foreach ($social_message as $social) {
//                    display($social);
//                    if ($social['notification_type'] == 'Sh') {
//                        display($social);
//                        continue;
//                    } else {
//                        continue;
//                    } //shared user
//                if (!isset($social['receiver_data']['target_id'])) {
//                    continue;
//                }
//                if ($social['receiver_data']['type_of_user'] == 'O') {
//                    continue;
//                }
                    if (isset($social['receiver_data']['designation']) && isset($social['receiver_data']['company_name'])) {
                        $profile_info = bracket_attendee_attribute($social['receiver_data']['designation'], $social['receiver_data']['company_name'], '-');
                    }
                    $href_subject_type = 'attendee';
                    if ($social['subject_type'] == 'A') {
                        $subject_user_type = 'Attendee';
                        $href_subject_type = 'attendee';
                    } elseif ($social['subject_type'] == 'E') {
                        $subject_user_type = 'Exhibitor';
                        $profile_info = '';
                        $href_subject_type = 'exhibitor';
                    } elseif ($social['subject_type'] == 'S') {
                        $subject_user_type = 'Speaker';
                        $href_subject_type = 'speaker';
                    } elseif ($social['subject_type'] == 'Event') {
                        $subject_user_type = 'Event';
                        $href_subject_type = 'event';
                    } elseif ($social['subject_type'] == 'session') {
                        $subject_user_type = 'Session';
                        $href_subject_type = 'session';
                    } elseif ($social['notification_type'] == 'download_evt_map') {
                        $subject_user_type = 'Download Event map';
                        $href_subject_type = 'session';
                    } elseif ($social['notification_type'] == 'download_ses_map') {
                        $subject_user_type = 'Download Session';
                        $href_subject_type = 'session';
                    }


                    if ($social['object_type'] == 'A') {
                        $object_user_type = 'Attendee';
                        $href_object_type = 'attendee';
                    } elseif ($social['object_type'] == 'E') {
                        $object_user_type = 'Exhibitor';
                        $href_object_type = 'exhibitor';
                    } elseif ($social['object_type'] == 'S') {
                        $object_user_type = 'Speaker';
                        $href_object_type = 'speaker';
                    }

//<li id='.$i.'><div
                    //echo '';
                    if ($social['notification_type'] == 'Msg' && $social['subject_id'] == 0) {//broadcast
                        $html = '<li class="social_noti" id=' . $i . '><div class="media"><div class="media-body"><small>' . $object_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_object_type . '-detail/' . $social['object_id'] . '">' . $social['name'] . ' ' . bracket_attendee_attribute($social['designation'], $social['company_name'], '-') . '</a> 
                                    broadcasted a message: "' . $social['notification_content'] . '"
                                    </small>
                                    <span>' . date('d M Y', strtotime($social['notification_date'])) . ', ' . $social['event_name'] . '</span>';
                        if ($social['object_id'] != $this->session->userdata('client_attendee_id'))
                            $html .= '<a href="' . SITE_URL . 'notification/details/Msg/' . $social['message_id'] . '" class="pull-right badge badge-success"  >Reply</a></div></div></li>';
                        echo $html;
                    }
                    elseif ($social['notification_type'] == 'Sav') { //saved user
                        echo '<li class="social_noti" id=' . $i . '><div class="media"><div class="media-body"><small>' . $object_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_object_type . '-detail/' . $social['object_id'] . '">' . $social['name'] . ' ' . bracket_attendee_attribute($social['designation'], $social['company_name'], '-') . '</a>  saved profile of
                                    ' . $subject_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_subject_type . '-detail/' . $social['receiver_data']['target_id'] . '">' . $social['receiver_data']['name'] . ' ' . $profile_info . ' </a>
                                    </small>
                                    <span>' . date('d M Y', strtotime($social['notification_date'])) . ', ' . $social['event_name'] . '</span></div></div></li>';
                    } elseif ($social['notification_type'] == 'Sh') { //shared user
                        if (!isset($social['receiver_data']['target_id'])) {
                            $social_target_id = $social['subject_id'];
                        } else {
                            $social_target_id = $social['receiver_data']['target_id'];
                        }
                        if (!isset($social['receiver_data']['name']) && !empty($social['receiver_data']['name'])) {
                            $social_reciver_name = $social['receiver_data']['name'];
                        } else {
                            $social_reciver_name = '';
                        }
                        echo '<li  class="social_noti" id=' . $i . '><div class="media"><div class="media-body"><small>' . $object_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_subject_type . '-detail/' . $social['object_id'] . '">' . $social['name'] . ' ' . bracket_attendee_attribute($social['designation'], $social['company_name'], '-') . '</a> Shared profile of
                                    ' . $subject_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_subject_type . '-detail/' . $social_target_id . '">' . $social_reciver_name . ' ' . $profile_info . ' </a>
                                    </small>
                                    <span>' . date('d M Y', strtotime($social['notification_date'])) . ', ' . $social['event_name'] . '</span></div></div></li>';
                    }
//                elseif ($social['notification_type'] == 'view') { //shared user
//                    if ($subject_user_type != 'Event' && $subject_user_type != 'session' && $subject_user_type != 'Session' && $subject_user_type != 'download_ses_map') {
//                        if (!isset($social['receiver_data']['target_id'])) {
//                            $social_target_id = $social['subject_id'];
//                        } else {
//                            $social_target_id = $social['receiver_data']['target_id'];
//                        }
//                        if (isset($social['session_name']) && !empty($social['session_name'])) {
//                            $session_namee = $social['session_name'];
//                        }
//
//                        echo '<li class="social_noti" id='.$i.'><div class="media"><div class="media-body"><small>' . $object_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_subject_type . '-detail/' . $social['object_id'] . '">' . $social['name'] . ' ' . bracket_attendee_attribute($social['designation'], $social['company_name'], '-') . '</a> Viewed profile of
//                                    ' . $subject_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_subject_type . '-detail/' . $social_target_id . '">' . $social['receiver_data']['name'] . ' ' . $profile_info . ' </a>
//                                    </small>
//                                    <span>' . date('d M Y', strtotime($social['notification_date'])) . ', ' . $social['event_name'] . '</span></div></div></li>';
//                    } else {
//                        if ($subject_user_type == 'Session') {
//                            if (isset($social['session_name']) && !empty($social['session_name'])) {
//                                $session_namee = $social['session_name'];
//                            }
//                            if (!isset($social['receiver_data']['target_id'])) {
//                                $social_target_id = $social['subject_id'];
//                            } else {
//                                $social_target_id = $social['receiver_data']['target_id'];
//                            }
//
//                            echo '<li class="social_noti" id='.$i.'><div class="media"><div class="media-body"><small>' . $object_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_subject_type . '-detail/' . $social['object_id'] . '">' . $social['name'] . ' ' . bracket_attendee_attribute($social['designation'], $social['company_name'], '-') . '</a> Viewed 
//                                    ' . $subject_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_subject_type . '-detail/' . $social_target_id . '">' . $session_namee . ' ' . $profile_info . ' </a>
//                                    </small>
//                                    <span>' . date('d M Y', strtotime($social['notification_date'])) . ', ' . $social['event_name'] . '</span></div></div></li>';
//                        }
//                    }
//                }
                    elseif ($social['notification_type'] == 'download_evt_map') { //shared user
                        echo '<li class="social_noti" id=' . $i . '><div class="media"><div class="media-body"><small>' . $object_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_subject_type . '-detail/' . $social['object_id'] . '">' . $social['name'] . ' ' . bracket_attendee_attribute($social['designation'], $social['company_name'], '-') . '</a> Download '
                        . $subject_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_subject_type . '-detail/' . $social['receiver_data']['target_id'] . '">' . $social['event_name'] . ' </a>
                                    </small>
                                    <span>' . date('d M Y', strtotime($social['notification_date'])) . ', ' . $social['event_name'] . '</span></div></div></li>';
                    } elseif ($social['notification_type'] == 'download_ses_map') { //shared user
                        if ($subject_user_type == 'Download Session') {
                            if (!isset($social['receiver_data']['target_id'])) {
                                $social_target_id = $social['subject_id'];
                            } else {
                                $social_target_id = $social['receiver_data']['target_id'];
                            }
                            if (isset($social['session_name']) && !empty($social['session_name'])) {
                                $session_namee = $social['session_name'];
                            }
                            echo '<li class="social_noti" id=' . $i . '><div class="media"><div class="media-body"><small>' . $object_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_subject_type . '-detail/' . $social['object_id'] . '">' . $social['name'] . ' ' . bracket_attendee_attribute($social['designation'], $social['company_name'], '-') . '</a>  '
                            . $subject_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_subject_type . '-detail/' . $social_target_id . '">' . $session_namee . ' ' . $profile_info . ' </a>
                                    </small>
                                    <span>' . date('d M Y', strtotime($social['notification_date'])) . ', ' . $social['event_name'] . '</span></div></div></li>';
                        }
                    } elseif ($social['notification_type'] == 'view') { //shared user
                        if ($subject_user_type == 'Session') {
                            if (isset($social['session_name']) && !empty($social['session_name'])) {
                                $session_namee = $social['session_name'];
                            }
                            if (!isset($social['receiver_data']['target_id'])) {
                                $social_target_id = $social['subject_id'];
                            } else {
                                $social_target_id = $social['receiver_data']['target_id'];
                            }

                            echo '<li class="social_noti" id=' . $i . '><div class="media"><div class="media-body"><small>' . $object_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_subject_type . '-detail/' . $social['object_id'] . '">' . $social['name'] . ' ' . bracket_attendee_attribute($social['designation'], $social['company_name'], '-') . '</a> Viewed 
                                    ' . $subject_user_type . ' - <a href="' . SITE_URL . 'events/' . $href_subject_type . '-detail/' . $social_target_id . '">' . $session_namee . ' ' . $profile_info . ' </a>
                                    </small>
                                    <span>' . date('d M Y', strtotime($social['notification_date'])) . ', ' . $social['event_name'] . '</span></div></div></li>';
                        }
                    }
                    ?>

                    <?php
                    $i++;
                    //echo '</div></div></li>';
                }
                ?>
                <button style="width: 100%" id="load_more"> LOAD MORE
                </button>
                <?php
            } else {
                echo 'Social messages will be shown here.<br><br>Sample Messages:<ul class="chatuserlist">
                            <li><div class="media"><div class="media-body"><small>Attendee - <a href="#">Chintan Lad (C.D.O., Infini Systems)</a>  saved profile of
                                    Exhibitor - <a href="#">Times Travel Fair  </a>
                                    </small>
                                    <span>04 Jun 2014, Trade India 2014</span></div></div></li>               
                            <li><div class="media"><div class="media-body"><small>Attendee - <a href="#">Gautam Udani (Tech. Lead, eClass)</a> shared profile of
                                    Speaker - <a href="#">Abhay Bhatia (Founder, Procialize) </a>
                                    </small>
                                    <span>02 Jun 2014, AfroAsian TelCom</span></div></div></li>';
                echo '</ul>';
            }
            ?>







        </ul>

    </div>
    <div class="tab-pane" id="rp-favorites">

        <?php
        $tweets = '';
        $db_tweets = get_db_tweets($this->session->userdata('client_event_id'));
        if (isset($db_tweets->tweets) && $db_tweets->tweets) {
            $tweets = json_decode($db_tweets->tweets);
        }
        ?>
        <ul class="chatuserlist">
            <?php
            /* if(isset($tweets->statuses) && is_array($tweets->statuses))//for #hashtag
              {
              //if(count($tweets->statuses))
              {

              foreach($tweets as $tweet)
              {
              //foreach($tweet as $t)
              {
              ?>
              <li >
              <div >
              <div class="media"><div class="media-body">
              <small><a href="javascript:;"><?php echo $tweet->user->name?></a> -
              <?php echo $tweet->text;?> </small>
              <span><?php echo date('d M Y',strtotime($tweet->created_at));?></span>
              </div></div>
              </div>
              </li>
              <?php
              }
              }
              }
              } */
            if ($tweets) {
                foreach ($tweets as $tweet) {
                    ?>
                    <li >
                        <div >
                            <div class="media"><div class="media-body">
                                    <small><a href="javascript:;"><?php echo $tweet->user->name ?></a> - 
                                        <?php echo $tweet->text; ?> </small>
                                    <span><?php echo date('d M Y', strtotime($tweet->created_at)); ?></span>
                                </div></div>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>

        </ul>
    </div>
</div><!-- tab-content -->


<!---right panel compose message pop up---->
<div id="compose" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Compose</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <input type="text" class="form-control"  placeholder="Add Attendee, Speaker, Exhibitor">
                    </div>

                    <div class="form-group">
                        <input type="button" class="btn btn-success input-sm btn-block" value="Add" id="addmoreat">
                    </div>
                    <div class="form-group">
                        <div class="checkbox-inline">
                            <label> <input type="checkbox" checked> All Attendees, Speakers, Exhibitors</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="3" placeholder="Write your message here"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-success input-sm btn-block">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!---right panel compose message pop up---->
<script>
    var diffrence = 10;
    var start_value = 0;
    var end_value = $("#end_val").val();
    $(".social_noti").hide();
    $("#" + start_value).addClass("start");
    $("#" + end_value).addClass("stop");
    $(".start").show();
    $("li.start").nextUntil("li.stop").show();
    $("#start_val").val(end_value);
    var sum = Number(end_value) + Number(diffrence);
    $("#end_val").val(sum);
    $("#load_more").click(function() {
        var diffrence = 10;
        var start_value = $("#start_val").val();
        var end_value = $("#end_val").val();
        $(".social_noti").hide();
        $("#" + start_value).addClass("start");
        $("#" + end_value).addClass("stop");
        $(".start").show();
        $("li.start").nextUntil("li.stop").show();
        $("#start_val").val(end_value);
        var sum = Number(end_value) + Number(diffrence);
        $("#end_val").val(sum);
//        $(".social_noti").each(function() {
//            var noti_div_id = $(this).attr("id");
////            $(".social_noti").slice(start_value, end_value).show();
//
////            if (noti_div_id.isBetween(start_value, end_value)) {
//            if (noti_div_id >= start_value && noti_div_id <= end_value) {
//                console.log(noti_div_id);
//                $(this).show();
//            } else {
//                $(this).hide();
//            }
//        });
    });
</script>