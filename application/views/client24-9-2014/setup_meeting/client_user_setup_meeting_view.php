   <!---client header view--->
    <?php $this->load->view(CLIENT_HEADER)?>
    
    <!---client header view--->
    
    
    <!----event top navigation---->
    <?php $this->load->view(EVENT_TOP_NAVIGATION)?>
    <!----event top navigation---->
    </div>
	
	<div class="contentpanel">
        <div class="panel panel-default panel-stat">
		<div class="row">
			<div class="col-sm-12">
				<div class="calendarw">
					<iframe class="well well-sm" style="zoom:0.60" width="100%" height="1000" frameborder="0" src="<?php echo SITE_URL.'client/event/setup_meeting_iframe/'.$target_attendee_id?>">
					</iframe>
				</div>
			</div>
        </div>
        </div>
    </div><!-- contentpanel -->
    
  </div><!-- mainpanel -->
  
  
  <!--<div id="get_data"><a href="javascript:;">Get Data</a></div>-->
  <div class="rightpanel">
      
      <!--Right panel view--->
      <?php  $this->load->view(CLIENT_RIGHT_PANEL)?>
      <!--Right panel view--->
    
  </div><!-- rightpanel -->
  
  
</section>


<?php $this->load->view(CLIENT_FOOTER)?>
