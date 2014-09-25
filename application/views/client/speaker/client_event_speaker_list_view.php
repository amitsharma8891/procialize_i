   <!---client header view--->
    <?php $this->load->view(CLIENT_HEADER)?>
    
    <!---client header view--->
    
    
    <!----event top navigation---->
    <?php $this->load->view(EVENT_TOP_NAVIGATION)?>
    <!----event top navigation---->
     <input type="text" id="search_user" onkeyup="serach_user('speaker')" class="form-control input-sm mt18" placeholder="Search Name, Industry, Functionality, Location, Company">
    </div>
    
    
    <div class="contentpanel">
    <div class="panel panel-default panel-stat">
		<!--<div class="panel-heading">-->
		
      <div class="row" id="ajax_attendee">
            <?php 
            if($speaker_list)
            {
                foreach($speaker_list as $attendee)
                {
                    $anchor   = '<a href="'.SITE_URL.EVENT_CONTROLLER_PATH.'speaker-detail/'.$attendee['attendee_id'].'">';
                    if(!passcode_validatation())
                        $anchor   = '<a href="javascript:;" class=""  data-toggle="modal" data-target="#SignUp">';
        ?>
            <div class="col-xs-12">
<!--                <a href="<?php //echo ?>">-->
                <?php echo $anchor;?>
			  <div class="stat well well-sm attnd">
                <div class="row">
                  <div class="col-xs-4">
                    <div class="thumb">
                        <img src="<?php echo SITE_URL.'uploads/'.front_image('speaker',$attendee['attendee_image'])?>" alt="" class="img-responsive userlogo"/>
		    </div>
                  </div>
                  <div class="col-xs-8 eventdet">
					<h4><?php echo $attendee['attendee_name']?></h4>
                    <?php if($attendee['attendee_designation'] || $attendee['attendee_company']) {?>
                    <small class="stat-label mr10"><?php echo designation_company($attendee['attendee_designation'],$attendee['attendee_company'])?></small>
                    <?php } ?>
                    <?php if($attendee['attendee_industry'] || $attendee['attendee_functionality']) {?>
                    <small class="stat-label mr10"><?php echo industry_functionality($attendee['attendee_industry'],$attendee['attendee_functionality'])?></small>
                    <?php }?>
                    <?php if($attendee['attendee_city']) {?>
                    <small class="stat-label mr10"><?php echo $attendee['attendee_city']?></small>
                    <?php } ?>
                  </div>
                        <!--<div class="col-xs-2">
                        <small class="stat-label attp"><?php// echo $attendee['attendee_city']?></small>
                  </div>-->
                </div><!-- row -->
              </div><!-- stat -->
			  </a>
			  
			  
        </div><!-- col-sm-6 -->
        <?php
                }
            } 
            else 
            {
                echo '<div class="col-xs-12">No Speakers for this event</div>';
            }
        ?>
		
	
		
      </div><!-- row -->
     <!-- </div>-->
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
