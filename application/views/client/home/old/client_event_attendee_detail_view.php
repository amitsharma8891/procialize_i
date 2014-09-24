   <!---client header view--->
    <?php $this->load->view(CLIENT_HEADER)?>
    
    <!---client header view--->
    
    
    <!----event top navigation---->
    <?php $this->load->view(EVENT_TOP_NAVIGATION)?>
    <!----event top navigation---->
    
    
    
    <div class="contentpanel">
    <div class="panel panel-default panel-stat">
		<div class="panel-heading">
		
      <div class="row">
        
		<div class="col-xs-12">
                <?php 
                    if($event['attendee_list'])
                    {
                        $attendee                                               = $event['attendee_list'][0];
                ?>
              <div class="stat well well-sm attnd">
                <div class="row">
                  <div class="col-xs-4">
                    <div class="thumb">
                        <img src="<?php echo SITE_URL.'uploads/'.front_image('attendee',$attendee['attendee_image']) ?>" alt="" class="img-responsive userlogo"/>
		    </div>
                  </div>
                  <div class="col-xs-6 eventdet">
					<h4><?php echo $attendee['attendee_name']?></h4>
                    <small class="stat-label">CDO - L&T Tech.</small>
                    <small class="stat-label"><?php echo $attendee['attendee_city'].', '.$attendee['attendee_country'] ?></small>
                  </div>
                </div><!-- row -->
				
				<hr class="mt9">
				<div class="row">
					<div class="col-xs-6">
					<a class="btn btn-success input-sm btn-block">Send Message</a>
					</div>
					<div class="col-xs-6">
					<a class="btn btn-success input-sm btn-block">Set Meeting</a>
					</div>
				</div>
				
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
						<p><strong>Industry:</strong> Information Technology</p>
						<p><strong>Functionality:</strong> Operations</p>
						<p><strong>Linkedin:</strong> <?php echo $attendee['attendee_linkdin']?></p>
						<p><strong>Facebook:</strong> <?php echo $attendee['attendee_facebook']?></p>
						<p><strong>Twitter:</strong> <?php echo $attendee['attendee_twitter']?></p><br>

						<p><strong>Email:</strong> <?php echo $attendee['attendee_email']?></p>
						<p><strong>Mobile:</strong> +91 9773303885</p><br>

						<!--<p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>-->
						<p class="text-justify"><?php echo $attendee['attendee_description']  ?></p>
					  </div>
					  <div class="tab-pane" id="sessions">Sessions</div>
					  <div class="tab-pane" id="activities">Activities</div>
					  <div class="tab-pane" id="events">Events</div>
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
    
  </div><!-- mainpanel -->
  
  <div class="rightpanel">
      
      <!--Right panel view--->
      <?php  $this->load->view(CLIENT_RIGHT_PANEL)?>
      <!--Right panel view--->
    
  </div><!-- rightpanel -->
  
  
</section>


<?php $this->load->view(CLIENT_FOOTER)?>
