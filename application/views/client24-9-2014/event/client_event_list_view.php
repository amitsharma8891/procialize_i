    <!---client header view--->
    <?php $this->load->view(CLIENT_HEADER)?>
    
    <!---client header view--->
    <script type="text/javascript" src="<?php echo CLIENT_SCRIPTS?>/modules/event_module.js"></script>
    <div class="pageheader">
        <input type="text" id="search_" class="form-control" placeholder="Search Event Name, Industry, Functionality, Location">
    </div>
    
    <div class="contentpanel">
    <div class="panel panel-default panel-stat">
		<div class="event-listing">
	<?php if($event_list) {?>	
      <div class="row">
       <?php 
            foreach($event_list as $event)
            {
                
            ?>
        
                
        <div id="event-list-tweak" class="col-sm-6 col-md-4 changeListClass">
            <div class="stat well well-sm">
                  <?php 
                        $user_id      = $this->session->userdata('client_user_id');
                        $href         = 'href="'.SITE_URL.'login" ';  
                        if($user_id)//SITE_URL.'events/event-detail/'.$event['event_id']
                            $href                                               = 'href="'.SITE_URL.'events/event-detail/'.$event['event_id'].'"' ;
                        
                  ?>
                  <a href="<?php echo SITE_URL.'events/event-detail/'.$event['event_id']?>" id="<?php echo $event['event_id'];?>">
				<h4 class="tits_1"><?php echo $event['event_name'] ?></h4>
				<div class="row">
					<div class="col-xs-4">
						<div class="thumb">
							<?php
								echo '<img src="'.SITE_URL.'uploads/events/logo/'.$event['event_logo'].'" alt="" class="img-responsive userlogo"/>'
							?>
							
						</div>
					</div>
					<div class="col-xs-8 mb6 eventdet">
					<span class="pull-right mr10">
						<small class="stat-label">
							<div class="thumb">
														<img src="<?php echo SITE_URL.'uploads/organizer/logo/'.$event['organiser_photo'];//front_image('organizer',$event['organiser_photo'])?>" class="img-responsive userlogor" alt="Organizer"/>
							</div>
						</small>
					</span>
                <h4>
                    <?php 
                        $start_date                                             = $event['event_start'];                          
                        $end_date                                               = $event['event_end'];                          
                        
                        echo date('d',  strtotime($start_date)).'-'.date('d',  strtotime($end_date)).' '.date('M',  strtotime($start_date)).', '.date('Y',  strtotime($start_date))
                    ?>
                    <!--15-18 Apr, 2014-->  
                </h4>
                    <small class="stat-label mr10"><?php echo city_country($event['event_city'],$event['event_country'])?></small>
                    <small class="stat-label mr10"><?php echo industry_functionality($event['event_industry'],$event['event_functionality'])?></small>
                  </div>
			
                </div><!-- row -->
                
				
				</a>
                  <?php 
                    if(!is_null($event['featured'])  && $event['featured'] == 1)
                    {
                  
                  ?>
				<div class="panel panel-dark">
					<div class="panel-heading">
					  <ul class="photo-meta">
						<li><a> <?php echo $event['count']['total_exhibitor'];?> Exhibitors</a></li>
						<li><a> <?php echo $event['count']['total_speaker'];?> Speakers</a></li>
						<li><a> <?php echo $event['count']['total_attendee'];?> Attendees</a></li>
					  </ul>
					</div>
                                    <?php if($event['attendee_list'] || ($event['image1'] || $event['image2'] || $event['image3']) ) {?>
					<div class="panel-body">
						<div class="row">
						<div class="col-xs-6 temp text-left">
                                                    <?php 
                                                        if($event['attendee_list'])
                                                        {
                                                            echo '<ul class="social-list">';
                                                            $i=0;
                                                            foreach($event['attendee_list'] as $attendee)
                                                            {
                                                                $i++;
                                                                /*if($this->session->userdata('client_user_city')  )
                                                                {
                                                                    if($this->session->userdata('client_user_city') ==  $attendee['attendee_city'])
                                                                    echo '<li><a><img class="img-responsive" src="'.SITE_URL.'uploads/'.front_image('attendee',$attendee['attendee_image']).'"></a></li>';
                                                                }
                                                                else
                                                                {
                                                                    echo '<li><a><img class="img-responsive" src="'.SITE_URL.'uploads/'.front_image('attendee',$attendee['attendee_image']).'"></a></li>';
                                                                }
                                                                */
                                                                echo '<li><a><img class="img-responsive" src="'.SITE_URL.'uploads/'.front_image('attendee',$attendee['attendee_image']).'"></a></li>';
                                                                    
                                                        ?>

                                                    <!-- <li><a href="#"><img class="img-responsive" src="<?php //echo CLIENT_IMAGES?>1.jpg"></a></li>-->

                                                        <?php        
                                                        if($i == 15)    
                                                            break;
                                                            }
                                                            echo '</ul><h5>Attendees</h5>';
                                                        }
                                                    ?>    
                                                    
                                                      
									
								
						  
						</div>
						<div class="col-xs-6 weather text-left" style="border-left: 1px solid #aaa;">
						  <ul class="social-list" style="margin-left:5px;">
                                        <?php 
                                            $gallery_show_flag = FALSE;
                                            if($event['image1'])
                                            {
                                                if(file_exists(UPLOADS.'events/images/'.$event['image1']))
                                                {
                                                    echo '<li><a><img class="img-responsive" src="'.SITE_URL.'uploads/events/images/'.$event['image1'].'"></a></li>';
                                                    $gallery_show_flag = TRUE;
                                                }
                                                
                                            }
                                            if($event['image2'])
                                            {
                                                if(file_exists(UPLOADS.'events/images/'.$event['image2']))
                                                {
                                                    echo '<li><a><img class="img-responsive" src="'.SITE_URL.'uploads/events/images/'.$event['image2'].'"></a></li>';
                                                    $gallery_show_flag = TRUE;
                                                }
                                                
                                            }
                                            if($event['image3'])
                                            {
                                                if(file_exists(UPLOADS.'events/images/'.$event['image3']))
                                                {
                                                    echo '<li><a><img class="img-responsive" src="'.SITE_URL.'uploads/events/images/'.$event['image3'].'"></a></li>';
                                                    $gallery_show_flag = TRUE;
                                                }
                                                
                                            }
                                        ?>
								</ul>
                                                    <?php if($gallery_show_flag) echo '<h5 style="margin-left: 5px;">Gallery</h5>';?>
						  
						</div>
					  </div>
					</div>
                                    <?php }?>
				</div>
                    <?php }?>
				
              </div><!-- stat -->
        </div><!-- col-sm-6 -->
            
            <?php        
            }
       ?>
            
		
      </div><!-- row -->
      
      <?php }?>
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
