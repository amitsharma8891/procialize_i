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
        <?php 
            if($event['attendee_list'])
            {
                foreach($event['attendee_list'] as $attendee)
                {
        ?>
            <div class="col-xs-12">
                <a href="<?php echo SITE_URL.EVENT_CONTROLLER_PATH.'attendee-detail/'.$attendee['attendee_id']?>">
			  <div class="stat well well-sm attnd">
                <div class="row">
                  <div class="col-xs-4">
                    <div class="thumb">
                        <img src="<?php echo SITE_URL.'uploads/attendee/'.$attendee['attendee_image']?>" alt="" class="img-responsive userlogo"/>
		    </div>
                  </div>
                  <div class="col-xs-6 eventdet">
					<h4><?php echo $attendee['attendee_name']?></h4>
                    <small class="stat-label"><?php echo $attendee['attendee_location']?></small>
                    <small class="stat-label">Information Tech, Design</small>
                  </div>
                        <div class="col-xs-2">
                        <small class="stat-label attp"><?php echo $attendee['attendee_city']?></small>
                  </div>
                </div><!-- row -->
              </div><!-- stat -->
			  </a>
			  
			  
        </div><!-- col-sm-6 -->
        <?php
                }
            } 
            else 
            {
                echo '<div class="col-xs-12">No Attendee for this event</div>';
            }
        ?>
		
		
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
