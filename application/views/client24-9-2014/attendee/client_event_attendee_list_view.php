   <!---client header view--->
    <?php $this->load->view(CLIENT_HEADER)?>
    
    <!---client header view--->
    
    
    <!----event top navigation---->
    <?php $this->load->view(EVENT_TOP_NAVIGATION)?>
    <!----event top navigation---->
    
    <input type="text" id="search_user" onkeyup="serach_user('attendee')" class="form-control input-sm mt18" placeholder="Search Name, Industry, Functionality, Location, Company">
    </div>
    
    <div class="contentpanel">
    <div class="panel panel-default panel-stat">
		<div class="">
		
       <div class="row" id="ajax_attendee">
        <?php 
            if($attendee_list)
            {
                foreach($attendee_list as $attendee)
                {
        ?>
            <div class="col-xs-12">
                <a href="<?php echo SITE_URL.EVENT_CONTROLLER_PATH.'attendee-detail/'.$attendee['attendee_id']?>">
			  <div class="stat well well-sm attnd">
                <div class="row">
                  <div class="col-xs-4">
                    <div class="thumb">
                        <img src="<?php echo SITE_URL.'uploads/'.front_image('attendee',$attendee['attendee_image'])?>" alt="" class="img-responsive userlogo"/>
		    </div>
                  </div>
                  <div class="col-xs-8 eventdet">
					<h4><?php echo $attendee['attendee_name']?></h4>
                    
                    <small class="stat-label mr10"><?php echo designation_company($attendee['attendee_designation'],$attendee['attendee_company'])?></small>
                    <small class="stat-label mr10"><?php echo industry_functionality($attendee['attendee_industry'],$attendee['attendee_functionality'])?></small>
                    <small class="stat-label mr10"><?php echo $attendee['attendee_city']?></small>
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
                echo '<div class="col-xs-12">No Attendee for this event</div>';
            }
        ?>
		
		
      </div><!-- row -->
      <div class="col-xs-12 load_more">
                    <a href="javascript:;">
                        <div class="stat well well-sm attnd">
                            <div class="row">
                                <div class="col-xs-4"> </div>
                                <div class="col-xs-8 eventdet">
                                    <h4 class="load_more_loader">Load More...</h4>
                                    
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
      <div class="row" >
          <div class="col-xs-12 user_list_loader text-center" >
              
          </div>
      </div>
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
<script type="text/javascript">
    
    var total_count = '<?php echo $total_attendee?>';
    var per_page    = '<?php echo PAGE_LIMIT?>';
    var count = 1;
    var scroll = 'scroll';
    $(document).ready(function ()
    {
        $(".load_more").click(function ()
        {
            if(total_count >  (per_page*count))
            {
                serach_user('attendee',count,scroll);
                count++;
            }
            else
            {
                $(".load_more").remove();
            }
            
        });
    });
    /*$(window).scroll(function(e){
        //alert('91');
        //e.preventDefault(); 
            if  ($(window).scrollTop() == $(document).height() - $(window).height()){
                alert('91');
              if(total_count >  (per_page*count))
              {
                  serach_user('attendee',count,scroll);
              }
               
               count++;
            }
            else
            {
                alert($(window).scrollTop());
                //alert($(document).height() - $(window).height());
            }
    }); */
    /*$(window).scroll(function () {
        alert('test');
    if ($(window).scrollTop() +1 >= $(document).height() - $(window).height()) {
        //$('body').css('background','red');
        if(total_count >  (per_page*count))
              {
                  serach_user('attendee',count,scroll);
              }
               
               count++;
    }else{
        //$('body').css('background','none');
    }
});*/

</script>

<?php $this->load->view(CLIENT_FOOTER)?>
