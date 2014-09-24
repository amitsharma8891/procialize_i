  <!---client header view--->
    <?php $this->load->view(CLIENT_HEADER)?>
    <script type="text/javascript" src="<?php echo CLIENT_SCRIPTS?>/modules/message_module.js"></script>
    <!---client header view--->

    <?php if($this->session->userdata('client_user_id') && $this->session->userdata('client_event_id')) {?>
    <!----event top navigation---->
    <?php $this->load->view(EVENT_TOP_NAVIGATION)?>
    <!----event top navigation---->
     
    </div>
    <?php }?>
    
    
    <div class="contentpanel">
    <div class="panel panel-default panel-stat">
		<div class="panel-heading-alt">
		
      <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="stat well well-sm attnd">
                        <?php 
                        //display($notification_detail);
                            if($notification_detail)
                            {
                                $attnedee_id                                    = $this->session->userdata('client_attendee_id');
                                ?>
                        
                            <?php 
                                if($notification_view_type == 'Msg')
                                {
                            ?>
                        <form class="" id="reply_form" role="form" onsubmit="return false">
                            <div class="form-group">
                                <?php 
                                foreach($notification_detail as $notify)
                                {
                                    $message_id                                 = $notify['message_id'];
                                    $event_id                                   = $notify['event_id'];
                                    
                                    
                                        
                                    
                                    if($attnedee_id == $notify['object_id'])
                                    {
                                        //echo '----->'.$notify['object_type'];
                                        if($notify['object_type'] == 'A')
                                            $user_type  = 'attendee'; 
                                        elseif($notify['object_type'] == 'E')
                                            $user_type  = 'exhibitor'; 
                                        elseif($notify['object_type'] == 'S')
                                            $user_type  = 'speaker';
                                        
                                        $target_attendee_id                     = $notify['subject_id'];
                                        $target_attendee_type                     = $notify['subject_type'];
                                        $to[]                                   = $notify;
                                        echo '<p><b><a href="'.SITE_URL.'events/'.$user_type.'-detail/'.$notify['object_id'].'">'.$notify['attendee_name'].'</a></b> <small>('.date('d M Y h.i A',strtotime($notify['notification_date'])).') </small>: '.$notify['notification_content'].' </p>';
                                    }
                                    else
                                    {
                                        //echo '----->'.$notify['subject_type'];
                                        if($notify['object_type'] == 'A')
                                            $user_type  = 'attendee'; 
                                        elseif($notify['object_type'] == 'E')
                                            $user_type  = 'exhibitor'; 
                                        elseif($notify['object_type'] == 'S')
                                            $user_type  = 'speaker';
                                        
                                        $target_attendee_id                     = $notify['object_id'];
                                        $target_attendee_type                     = $notify['object_type'];
                                        $from[]                                   = $notify;
                                        echo '<p><b><a href="'.SITE_URL.'events/'.$user_type.'-detail/'.$notify['object_id'].'">'.$notify['attendee_name'].'</a></b> <small>('.date('d M Y h.i A',strtotime($notify['notification_date'])).') </small>: '.$notify['notification_content'].' </p>';
                                    }
                                    echo '<hr class="msg4_rply">';
                                   
                                }
                                ?>
                                
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" name="message_text" id="message_text" placeholder="Write a reply"></textarea>
                            </div>
                            <div class="form-group">
                                
                                
                                <input type="hidden" name="message_id" id="message_id" value="<?php echo $message_id?>">
                                <input type="hidden" name="target_attendee_id" id="target_attendee_id" value="<?php echo $target_attendee_id?>">
                                <input type="hidden" name="target_attendee_type" id="target_attendee_type" value="<?php echo $target_attendee_type?>">
                                <input type="hidden" name="event_id" id="event_id" value="<?php echo $notification_detail[0]['event_id']?>">
                                
                            <button type="submit" class="btn btn-success input-sm btn-block sndmsg">Send</button>
                            </div>
                            </form>
                                <?php } elseif($notification_view_type == 'F') {  ?>
                                        <small class="stat-label">Feedback request from <?php echo @$notification_detail[0]['organizer_name']?> (Organizer)</small>
                                        <small class="stat-label"><?php echo date('Y-m-d',strtotime($notification_detail[0]['notification_date']))?>,  <?php echo @$notification_detail[0]['event_name']?></small>
                                        <hr class="mt9">
                                        <div id="feedback_div1">
                                        <h4>Kindly provide your Feedback for the  <?php echo @$notification_detail[0]['event_name']?></h4> 
                                        <br>
                                        <p class="rating mt10"><input type="number" name="rating" id="rating" class="rating"></p>
                                        <br>
                                        <input type="hidden" name="feedback_type" id="feedback_type" value="event_feedback">
                                        <!--<input type="hidden" name="target_id" id="target_id" value="<?php //echo $notification_detail[0]['event_id']?>">-->
                                        <input type="hidden" name="target_id" id="target_id" value="<?php echo $notification_id?>">
                                        <input type="hidden" name="feedback_id" id="feedback_id" value="<?php echo $notification_id?>">
                                        <a class="btn btn-success input-sm btn-block newmsglink mb10" onclick="save_feedback()">Submit</a>
                                        </div>
                                        <div class="tinystat mr20">
                                        <div class="datainfo">
                                            <small class="stat-label"><span>Total number of Attendees who gave feedback</span></small>
                                          <h4><?php echo $notification_detail[0]['event_total_user']?></h4>
                                        </div>
                                        </div>
                                        
                                        <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                if($.cookie('<?php echo $notification_id?>') == 'event_feedback') 
                                                  $("#feedback_div1").remove();
                                            });
                                        </script>
                                        <!----Meeting Response----->
                                <?php } elseif($notification_view_type == 'Mtg') { ;?>
                                        
                                        <small class="stat-label">Attendee - <?php echo $notification_detail[0]['attendee_name']. ' ('.$notification_detail[0]['company_name'].', '.$notification_detail[0]['designation'].')' ?>  sent you a meeting request</small>
                                        <small>Date: <?php echo date('d M Y',strtotime($notification_detail[0]['start_time']))?>, Time: <?php echo date('h.i A',strtotime($notification_detail[0]['start_time']))?> - <?php echo date('h.i A',strtotime($notification_detail[0]['end_time']))?></small>
						<small class="stat-label"><?php echo date('d M Y',strtotime($notification_detail[0]['notification_date'])).', '.$notification_detail[0]['event_name']?></small>
						<hr class="mt9">
						<h4><?php echo 'Message from '.$notification_detail[0]['attendee_name'].' : '.$notification_detail[0]['notification_content']?></h4>
						<?php if($notification_detail[0]['approve'] == 0) {?>
						<div class="row">
							<div class="col-xs-6">
								<a href="#" data-target="#setupmeeting" data-toggle="modal" class="btn btn-success btn-sm btn-block mt10" >Confirm Meeting</a>
							</div>
							<div class="col-xs-6">
								<a href="javascript:;" class="btn btn-default btn-sm btn-block mt10" data-target="#declinemeeting" data-toggle="modal">Decline Meeting</a>
							</div>
						</div>
                                                <?php }elseif($notification_detail[0]['approve'] == 1) { ?>
                                                <div class="row">
							<div class="col-xs-6">
                                                            <h4>You have confirmed the meeting.</h4>
							</div>
                                                </div>
                                                <?php }else{?>
                                                <div class="row">
							<div class="col-xs-6">
                                                            <h4>You have declined meeting.</h4>
							</div>
                                                </div>
                                                <?php }?>
                                                <input type="hidden" name="target_id" id="target_id" value="<?php echo $notification_detail[0]['object_id']?>">
                                                <input type="hidden" name="target_type" id="target_type" value="<?php echo $notification_detail[0]['object_type']?>">
                                                <input type="hidden" name="event_id" id="event_id" value="<?php echo $notification_detail[0]['event_id']?>">
                                                <input type="hidden" name="event_id" id="event_id" value="<?php echo $notification_detail[0]['notification_id']?>">
                                                <input type="hidden" name="meeting_id" id="meeting_id" value="<?php echo $notification_detail[0]['meeting_id']?>">
                                                
                                                <div id="setupmeeting" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                                    <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel">Setup Meeting</h4>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                            <form class="form-horizontal" role="form">
                                                                                    <div class="form-group">
<!--                                                                                            <p>To: Jigar Shah</p>-->
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                            <textarea class="form-control" id="meeting_reply_text" rows="3" placeholder="Hi, It's a good idea to meet and talk about our common interest. Will see you at the time specified. Cheers!"></textarea>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <button type="button" class="btn btn-success input-sm btn-block sndmsg" onclick="meeting_reply('approve')">Send</button>
                                                                                    </div>
                                                                            </form>
                                                            </div>
                                                        </div>
                                                            </div>
                                                    </div>

                                                    <div id="declinemeeting" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                        <div class="modal-content">
                                                                    <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel">Decline  Meeting</h4>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                            <form class="form-horizontal" role="form">
                                                                                    <div class="form-group">
<!--                                                                                            <p>To: Jigar Shah</p>-->
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <textarea class="form-control" id="meeting_reply_decline_text" rows="3" placeholder="Hi, It's a good idea to meet and talk about our common interest. Will see you at the time specified. Cheers!"></textarea>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <button type="button" class="btn btn-success input-sm btn-block sndmsg" onclick="meeting_reply('decline')">Send</button>
                                                                                    </div>
                                                                            </form>
                                                            </div>
                                                        </div>
                                                            </div>
                                                    </div>

                                <?php } elseif($notification_view_type == 'S') {?>
                                
                                <?php  }elseif($notification_view_type == 'N') {?>
                                                <div class="row">
						  <div class="col-xs-12">
							<div class="stat well well-sm attnd">
							<h4 align="justify"><?php echo $notification_detail[0]['notification_content']?></h4>
							<small class="stat-label"><?php echo $notification_detail[0]['event_name']?></small>
							<small class="stat-label"><?php echo date('d M Y',strtotime($notification_detail[0]['notification_date']))?></small>
							</div>
						  </div>
			</div>
                                <?php }?>
                         
                         <input type="hidden" name="notification_type" id="notification_type" value="<?php echo $notification_view_type?>">
                        
                        <?php
                            }
                        ?>
                    </div>
                </div>	
            </div>
			
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
<?php $this->load->view(CLIENT_FOOTER)?>
