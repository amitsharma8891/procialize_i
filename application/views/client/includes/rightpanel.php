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
        
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="rp-alluser">
           <ul class="chatuserlist">
               <?php 
                    $this->client_notification_model->notification_type              = '';
                    $this->client_notification_model->attendee_type                  = '';
                    $social_message     = getSocialMessages();
                    //display($social_message);
                    if($social_message && $this->session->userdata('client_user_id') && $this->session->userdata('client_event_id'))
                    {
                        foreach($social_message as $social)
                        {   
                            $profile_info                                       = bracket_attendee_attribute($social['receiver_data']['designation'],$social['receiver_data']['company_name'],'-');
                            $href_subject_type                                  = 'attendee';
                            if($social['subject_type'] == 'A')
                            {
                                $subject_user_type = 'Attendee';
                                $href_subject_type          = 'attendee';
                            }
                            elseif($social['subject_type'] == 'E')
                            {
                                $subject_user_type = 'Exhibitor';
                                $profile_info       = '';
                                $href_subject_type          = 'exhibitor';
                            }
                            elseif($social['subject_type'] == 'S')
                            {
                                $subject_user_type = 'Speaker';
                                $href_subject_type          = 'speaker';
                            }
                            elseif($social['subject_type'] == 'Event')
                            {
                                $subject_user_type = 'Event';
                                $href_subject_type          = 'event';
                            }
                                
                            
                            if($social['object_type'] == 'A')
                            {
                                $object_user_type = 'Attendee';
                                $href_object_type          = 'attendee';
                            }
                            elseif($social['object_type'] == 'E')
                            {
                                $object_user_type = 'Exhibitor';
                                $href_object_type          = 'exhibitor';
                            }
                            elseif($social['object_type'] == 'S')
                            {
                                $object_user_type = 'Speaker';
                                $href_object_type          = 'speaker';
                            }
                                
                            
                            
                                
                            //echo '';
                            if($social['notification_type'] == 'Msg' && $social['subject_id'] == 0)//broadcast
                            {
                                $html =  '<li><div class="media"><div class="media-body"><small>'.$object_user_type.' - <a href="'.SITE_URL.'events/'.$href_object_type.'-detail/'.$social['object_id'].'">'.$social['name'].' '.bracket_attendee_attribute($social['designation'],$social['company_name'],'-').'</a> 
                                    broadcasted a message: "'.$social['notification_content'].'"
                                    </small>
                                    <span>'.date('d M Y',  strtotime($social['notification_date'])).', '.$social['event_name'].'</span>';
                                if($social['object_id'] != $this->session->userdata('client_attendee_id'))
                                    $html .= '<a href="'.SITE_URL.'notification/details/Msg/'.$social['message_id'].'" class="pull-right badge badge-success"  >Reply</a></div></div></li>';
                                echo $html;
                            }
                            elseif ($social['notification_type'] == 'Sav') //saved user
                            {
                                echo '<li><div class="media"><div class="media-body"><small>'.$object_user_type.' - <a href="'.SITE_URL.'events/'.$href_object_type.'-detail/'.$social['object_id'].'">'.$social['name'].' '.bracket_attendee_attribute($social['designation'],$social['company_name'],'-').'</a>  saved profile of
                                    '.$subject_user_type.' - <a href="'.SITE_URL.'events/'.$href_subject_type.'-detail/'.$social['receiver_data']['target_id'].'">'.$social['receiver_data']['name']. ' '.$profile_info.' </a>
                                    </small>
                                    <span>'.date('d M Y',  strtotime($social['notification_date'])).', '.$social['event_name'].'</span></div></div></li>';
                            }
                            elseif ($social['notification_type'] == 'Sh') //shared user
                            {
                                echo '<li><div class="media"><div class="media-body"><small>'.$object_user_type.' - <a href="'.SITE_URL.'events/'.$href_subject_type.'-detail/'.$social['object_id'].'">'.$social['name'].' '.bracket_attendee_attribute($social['designation'],$social['company_name'],'-').'</a> Shared profile of
                                    '.$subject_user_type.' - <a href="'.SITE_URL.'events/'.$href_subject_type.'-detail/'.$social['receiver_data']['target_id'].'">'.$social['receiver_data']['name']. ' '.$profile_info.' </a>
                                    </small>
                                    <span>'.date('d M Y',  strtotime($social['notification_date'])).', '.$social['event_name'].'</span></div></div></li>';
                            }
                            ?>
               
                            <?php
                            //echo '</div></div></li>';
                        }
                    }
					else
					{
						echo 'Social messages will be shown here.<br><br>Sample Messages:<ul class="chatuserlist">
                            <li><div class="media"><div class="media-body"><small>Attendee - <a href="#">Chintan Lad (C.D.O., Infini Systems)</a>  saved profile of
                                    Exhibitor - <a href="#">Times Travel Fair  </a>
                                    </small>
                                    <span>04 Jun 2014, Trade India 2014</span></div></div></li>               
                            <li><div class="media"><div class="media-body"><small>Attendee - <a href="#">Gautam Udani (Tech. Lead, eClass)</a> shared profile of
                                    Speaker - <a href="#">Abhay Bhatia (Founder, Procialize) </a>
                                    </small>
                                    <span>02 Jun 2014, AfroAsian TelCom</span></div></div></li>               
							</ul>';
					}
               ?>
                
                
				
				
				
				
				
            </ul>
        </div>
        <div class="tab-pane" id="rp-favorites">
            
            <?php 
            if(getTwitterHashTag())
                $twiter_hashtag         = getTwitterHashTag();
            else
                $twiter_hashtag         = DEFAULT_TWITTER_HASHTAG;
            //echo $twiter_hashtag;
            
            include_once APPPATH.'libraries/tweeter_oauth/twitteroauth.php';
            
            $oauth_access_token = "2517362072-9fZgBTq25VOqQolVK2yGwwmZH4gy40kDyWIOrJj";
            $oauth_access_token_secret = "oLZD0UYuK1FJ3QNFwZZ6mqiSIPmgFLqLdVadQQrQjOT5e";
            $consumer_key = "CGdeB0gRrKhD3THZkZf7gNbad";
            $consumer_secret = "RX6LcQfmyoYyzQjX23IAs7LZ2lXoYegJNcnRh5waBpHcvmcPIm";
            
            $twitter = new TwitterOAuth($consumer_key,$consumer_secret,$oauth_access_token,$oauth_access_token_secret);
            $tweets = $twitter->get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.$twiter_hashtag.'&count=10');//make it a library 
            //display($tweets)
            ?>
           <ul class="chatuserlist">
               <?php 
               /*if(isset($tweets->statuses) && is_array($tweets->statuses))//for #hashtag
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
                }*/
                if($tweets)
                {
                    foreach($tweets as $tweet)
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