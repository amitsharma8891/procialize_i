   <!---client header view--->
    <?php $this->load->view(CLIENT_HEADER)?>
    
    <!---client header view--->
    
    
    <!----event top navigation---->
    <?php $this->load->view(EVENT_TOP_NAVIGATION)?>
    <!----event top navigation---->
    
     <!---top navigation modal--->
    <?php $this->load->view('client/includes/event_top_navigation_modal')?>
    <!---top navigation modal--->
     
    </div>
    
   
    
    <div class="contentpanel">
    <div class="panel panel-default panel-stat">
		<div class="panel-heading panel-heading-alt">
		
      <div class="row">
        
		<div class="col-xs-12">
                <?php 
                    if($attendee_detail)
                    { 
                        $attendee                                               = $attendee_detail;
                ?>
              <div class="stat attnd">
                <div class="row">
                  <div class="col-xs-4">
                    <div class="thumb">
                        <img src="<?php echo SITE_URL.'uploads/'.front_image('attendee',$attendee['attendee_image']) ?>" alt="" class="img-responsive userlogo"/>
		    </div>
                  </div>
                  <div class="col-xs-8 eventdet">
					<h4><?php echo $attendee['attendee_name']?></h4>
                    <small class="stat-label mr10"><?php echo $attendee['attendee_designation']?> - <?php echo $attendee['attendee_company']?></small>
                    <small class="stat-label mr10"><?php echo $attendee['attendee_city'].', '.$attendee['attendee_country'] ?></small>
                  </div>
                </div><!-- row -->
				
				<hr class="mt9">
                                <?php if($this->session->userdata('client_attendee_id') != $attendee['attendee_id']) {?>
				<div class="row">
					<div class="col-xs-6">
                                         <a class="btn btn-success input-sm btn-block newmsglink" data-toggle="modal" data-target="#new_msg">Send Message</a>
					</div>
					<div class="col-xs-6">
                                            <a href="<?php echo SITE_URL.'events/set-meeting/'.$attendee['attendee_id']?>" class="btn btn-success input-sm btn-block">Set Meeting</a>
					</div>
				</div>
                                <?php } ?>
				
				<div class="panel panel-dark mt9">
					<div class="panel-heading">
						<ul class="photo-meta br1">
						  <li class="active"><a href="#info" data-toggle="tab">Info</a></li>
						  <li><a href="#sessions" data-toggle="tab">Sessions</a></li>
						  <li><a href="#activities" data-toggle="tab">Activities</a></li>
						  <li><a href="#events" data-toggle="tab">Events</a></li>
						</ul>
					</div>
					<div class="panel-body">
					<div class="tab-content">
					  <div class="tab-pane active" id="info">
                                              
						
						
                                                <?php
                                                    if($attendee['attendee_industry'])
                                                        echo '<p><strong>Industry:</strong>'.$attendee['attendee_industry'].'</p>';
                                                    if($attendee['attendee_functionality'])
                                                        echo '<p><strong>Functionality:</strong>'.$attendee['attendee_functionality'].'</p>';
                                                    if($attendee['attendee_website'])
                                                        echo '<p><strong>Website:</strong> '.stripslashes($attendee['attendee_website']).'</p><br>';
                                                    
                                                ?>
                                                

<!--						<p><strong>Email:</strong> <?php //echo $attendee['attendee_email']?></p>-->
<!--						<p><strong>Mobile:</strong> <?php //echo $attendee['attendee_phone']?></p><br>-->

						<!--<p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>-->
						<p class="text-justify"><?php echo stripslashes($attendee['attendee_description'])  ?></p>
					  </div>
                                            <div class="tab-pane" id="sessions">
                                                <?php
                                                    if($attendee_session)
                                                    {
                                                        foreach($attendee_session as $key => $session)
                                                        {
                                                            ?>
                                                
                                                <a href="<?php echo SITE_URL.'client/event/session_detail/'.$session['session_id']?>">
                                                                <div class="row">
                                                                <div class="col-xs-12">
                                                                      <h4><?php echo $session['session_name'] ?></h4>
                                                                      <small class="stat-label"><?php echo $session['session_date']?></small>
                                                                      <small class="stat-label"><?php echo $session['track_name']?></small>
                                                                </div>
                                                                </div>
                                                            </a><!-- row -->
                                                            
                                                            
                                                            <?php
                                                            if($key != count($attendee_session)-1) 
                                                                echo "<hr>"; 
                                                        }
                                                    }else{ echo 'No Session!'; }
                                                ?>
                                                
                                            </div>
                                            <div class="tab-pane" id="activities">
                                                <?php 
                                                    if($activity)
                                                    {
                                                        //display($activity);
                                                        foreach($activity as $key1 => $act)
                                                        {
                                                            if($act['notification_type'] == 'Sh' || $act['notification_type'] == 'Sav')
                                                            {
                                                                if($act['notification_type'] == 'Sh')
                                                                    $type = 'Shared';
                                                                elseif($act['notification_type'] == 'Sav')
                                                                    $type = 'Saved';

                                                                if($act['receiver_data']['type_of_user'] == 'A')
                                                                {
                                                                    $user_type  = 'Attendee';
                                                                    $detail_page = 'attendee';
                                                                }
                                                                elseif($act['receiver_data']['type_of_user'] == 'E')
                                                                {
                                                                    $user_type  = 'Exhibitor';
                                                                    $detail_page = 'exhibitor';
                                                                }
                                                                if($act['receiver_data']['type_of_user'] == 'S')
                                                                {
                                                                    $user_type  = 'Speaker';
                                                                    $detail_page = 'speaker';
                                                                }
                                                                    
                                                            ?>
                                                
                                                                <div class="row">
                                                                <div class="col-xs-12">
                                                                      <h4><?php echo $type?> profile of <?php echo $user_type.' <a href="'.SITE_URL.'events/'.$detail_page.'-detail/'.@$act['receiver_data']['attendee_id'].'">'. $act['receiver_data']['name'].'</a>'?> (<?php echo @$act['receiver_data']['designation']?>, <?php echo @$act['receiver_data']['company_name']?>)</h4>
                                                                      <small class="stat-label"><?php echo date('d M Y',  strtotime($act['notification_date']))?>, <?php echo $act['event_name']?></small>
                                                                </div>
                                                                </div>
                                                            
                                                            
                                                            <?php
                                                            if($key1 != count($activity)-1) 
                                                                echo "<hr>"; 
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo 'No Activity';
                                                    }
                                                ?>
                                                
                                            </div>
                                          <div class="tab-pane" id="events">

                                              
                                              <?php
                                                    if($attendee_previous_event)
                                                    {
                                                        //display($attendee_previous_event);
                                                        foreach($attendee_previous_event as $key1 => $event1)
                                                        {
                                                            ?>
                                                            
                                                            
                                                            <div class="stat well well-sm">
															<h4 class="tits_1"><?php echo $event1['event_name'] ?></h4>
                                                                <div class="row">
                                                                  <div class="col-xs-4">
                                                                    <div class="thumb">
                                                                        <img class="img-responsive userlogo" src="<?php echo SITE_URL.'uploads/events/logo/'.$event1['event_logo']?>">
                                                                    </div>
                                                                  </div>
                                                                  <div class="col-xs-5 eventdet">
                                                                    <h4>
                                                                   <?php 
                                                                        $start_date                                             = $event1['event_start'];                          
                                                                        $end_date                                               = $event1['event_end'];                          

                                                                        echo date('d',  strtotime($start_date)).'-'.date('d',  strtotime($end_date)).' '.date('M',  strtotime($start_date)).', '.date('Y',  strtotime($start_date))
                                                                    ?>
                                                                    </h4>
                                                                    <small class="stat-label"><?php echo $event1['event_city'].' , '.$event1['event_country']?></small>
                                                                    <small class="stat-label mb6"><?php echo $event1['event_industry'].', '.$event1['event_functionality']?></small>
                                                                  </div>
                                                                  <div class="col-xs-3">
                                                                        <small class="stat-label">
                                                                                <div class="thumb">
                                                                                <img src="<?php echo SITE_URL.'uploads/organizer/logo/'.$event1['organiser_photo']?>" class="img-responsive userlogor" alt="Organizer"/>
                                                                                </div>
                                                                        </small>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            <?php
                                                            //if($key1 != count($attendee_previous_event)-1) 
                                                              //  echo "<hr>"; 
                                                        }
                                                    }
                                                ?>
                                                            
                                          </div>
					</div>
					</div>
				</div>
                                   
				
              </div><!-- stat -->
			   <?php }?>
        </div><!-- col-sm-6 -->
		
      </div><!-- row -->
      </div>
	</div>
    </div><!-- contentpanel -->
    <input type="hidden" name="subject_type" id="subject_type_notfication" value="<?php echo $attendee['attendee_type']?>">
    <input type="hidden" name="subject_id" id="subject_id_notfication" value="<?php echo $attendee['attendee_id']?>">
  </div><!-- mainpanel -->
  
  <div class="rightpanel">
      
      <!--Right panel view--->
      <?php  $this->load->view(CLIENT_RIGHT_PANEL)?>
      <!--Right panel view--->
    
  </div><!-- rightpanel -->
  
  
</section>


<?php $this->load->view(CLIENT_FOOTER)?>
