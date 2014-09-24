   <!---client header view--->
    <?php $this->load->view(CLIENT_HEADER)?>
    
    <!---client header view--->
    
    
    <!----event top navigation---->
    <?php //$this->load->view(EVENT_TOP_NAVIGATION)?>
    <!----event top navigation---->
    
     
    
    
    <div class="contentpanel">
    <div class="panel panel-default panel-stat">
		<div class="panel-heading-alt">
		
       <div class="row" id="ajax_attendee">
        <?php 
            if($saved_profile)
            {
                //display($saved_profile);
                if($page_type == 'exhibitor')
                {
                    foreach($saved_profile as $key =>$value)
                    {
                        
                   
                    ?>
           <script type="text/javascript">
                $(document).ready(function() 
                {
                    //col-sm-6
                    var width = screen.width
                    $(".changeListClass").removeClass('col-sm-6 col-md-4');
                    if(width <= 1024)
                    {
                        //alert(width+'in if');
                        $(".changeListClass").addClass('col-sm-12 col-md-12');
                    }
                   else
                   {
                       //alert(width+'in else');
                       $(".changeListClass").addClass('col-sm-6 col-md-4');
                   }
                       
                })  
                </script>
                        <div class="col-sm-6 col-md-4 changeListClass">
			
                                <div class="stat well well-sm exhbt">
                                    <a href="<?php echo SITE_URL.'events/exhibitor-detail/'.$value['receiver_data']['target_id']?>">
                                                  <div class="row">
                                    <div class="col-xs-4">
                                      <div class="thumb">
                                          <img src="<?php echo SITE_URL.'uploads/'.front_image('exhibitor',$value['receiver_data']['exhibitor_logo'])?>" alt="" class="img-responsive userlogo"/>
                                                          </div>
                                    </div>
                                    <div class="col-xs-8 eventdet">
                                        <?php if($value['receiver_data']['exhibitor_featured'] == 1) {?>	
                                     <span class="pull-right mr10">
                                          <p class="featured_icon"><i class="fa fa-bookmark"></i></p>
                                                          </span>
                                        <?php } ?>

                                                          <h4><?php echo $value['receiver_data']['exhibitor_name']?></h4>
                                      <small class="stat-label"><?php echo $value['receiver_data']['exhibitor_city'].', '.$value['receiver_data']['exhibitor_country']?></small>
                                      <small class="stat-label"><?php echo $value['receiver_data']['exhibitor_industry']?></small>
                                      <small class="stat-label">Stall Number: <strong><?php echo $value['receiver_data']['stall_number']?></strong></small>
                                    </div>

                                  </div><!-- row -->
                                  </a>

                                  <!--<p class="exinfo"><strong>Website:</strong> www.infinisystem.com</p>-->

                                          <?php if($value['receiver_data']['exhibitor_featured'] == 1) {?>
                                                  <hr>
                                                  <p class="exinfo"><strong>Email:</strong> <?php echo $value['receiver_data']['exhibitor_email'] ?></p>
                                  <?php }?>

                                </div><!-- stat -->
                          </div><!-- col-sm-6 -->
                    <?php
                     }
                }
                else
                {
                    foreach($saved_profile as $profile)
                    {
                        if($profile['subject_type'] == 'S')
                            $detail  = 'speaker';
                        elseif($profile['subject_type'] == 'A')
                        $detail  = 'attendee';
        ?>
            <div class="col-xs-12">
                <a href="<?php echo SITE_URL.EVENT_CONTROLLER_PATH.$detail.'-detail/'.$profile['receiver_data']['target_id']?>">
			  <div class="stat well well-sm attnd">
                <div class="row">
                  <div class="col-xs-4">
                    <div class="thumb">
                        <img src="<?php echo SITE_URL.'uploads/'.front_image('attendee',$profile['receiver_data']['attendee_image'])?>" alt="" class="img-responsive userlogo"/>
		    </div>
                  </div>
                  <div class="col-xs-8 eventdet">
					<h4><?php echo $profile['receiver_data']['name']?></h4>
                    
                    <small class="stat-label mr10"><?php echo designation_company($profile['receiver_data']['designation'],$profile['receiver_data']['company_name'])?></small>
                    <small class="stat-label mr10"><?php echo industry_functionality($profile['receiver_data']['attendee_industry'],$profile['receiver_data']['attendee_functionality'])?></small>
                    <small class="stat-label mr10"><?php echo $profile['receiver_data']['attendee_city']?></small>
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
            } 
            else 
            {
                echo '
                    <div class="panel-heading panel-heading-alt">
                    <div class="row">
                        <div class="col-xs-12">
				<div class="stat">
					
					<div class="omb_login">
						<!--<h3 class="omb_authTitle">Login / Sign up</h3>-->
						<h3 class="text-center" style="color:#58595b">Sorry!</h3>
                        <h4 class="text-center" style="color:#58595b; margin-bottom:10px;" >No Data Found</h4>
                        
                        <div class="row omb_row-sm-offset-3 mb10">
                            <div class="col-xs-12 col-sm-6">	
                                <!--<form class="omb_loginForm" action="" autocomplete="off" method="POST">-->
                                    
                                <!--</form>-->
                            </div>
                        </div>
					</div>
					
				</div><!-- stat -->
			</div>
                    </div>
                    </div>';
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
