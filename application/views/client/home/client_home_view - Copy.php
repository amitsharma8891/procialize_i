    <!---client header view--->
    <?php $this->load->view(CLIENT_HEADER)?>
    
    <!---client header view--->
    
    <div class="pageheader">
        <input type="text" id="search_" class="form-control" placeholder="Trade, Furniture">
      <script type="text/javascript">
          $(document).ready(function(){
              //$("#dia").dialog();
                              var SITE_URL                                      = 'http://192.168.2.107/project-procialize/solution/';
                              var source                                        = SITE_URL+'client/event/search?type='
                              var type                                          = '';
                              if(type != '')
                              {
                                  source                                        = 'client/event/autocomplete?type=';
                              }
                              $( "#search_" ).autocomplete(
                                {
            
                                        source                                  :source,
                                        minLength                               :3,
                                        width                                   : 320,
                                        max                                     : 10,
                                        select: function(event,ui ) {
                                            //alert(ui.item.label);
                                                window.location.href            = SITE_URL+'search?search='+ui.item.value;
                                            }
                               }).keydown(function(e)
                                   {
                                       if (e.keyCode === 13)
                                       {
                                           search_();
                                       }
                                   });
          })
          
        function search_()
        {
            //alert('test');
            if($("#search_").val() != '')
            window.location.href                            = "?type=&term="+encodeURIComponent($("#search_").val());
        }
      </script> 
    </div>
    
    <div class="contentpanel">
    <div class="panel panel-default panel-stat">
		<div class="panel-heading">
	<?php if($event_list) {?>	
      <div class="row">
        
       <?php 
            foreach($event_list as $event)
            {
                
            ?>
            
            <div class="col-sm-6 col-md-3">
              <div class="stat well well-sm">
                  <a href="<?php echo SITE_URL?>events/event-detail/<?php echo $event['event_id']?>">
				<div class="row">
                  <div class="col-xs-4">
                    <div class="thumb">
                        <?php
                            echo '<img src="'.SITE_URL.'uploads/'.front_image('logo',$event['event_logo']).'" alt="" class="img-responsive userlogo"/>'
                        ?>
						
					</div>
                  </div>
                 <div class="col-xs-5 eventdet">
                <h4>
                    <?php 
                        $start_date                                             = $event['event_start'];                          
                        $end_date                                               = $event['event_end'];                          
                        
                        echo date('d',  strtotime($start_date)).'-'.date('d',  strtotime($end_date)).' '.date('M',  strtotime($start_date)).','.date('Y',  strtotime($start_date))
                    ?>
                    <!--15-18 Apr, 2014-->  
                </h4>
                    <small class="stat-label"><?php echo $event['event_city'].' , '.$event['event_country']?></small>
                    <small class="stat-label"><?php echo $event['event_industry'].','.$event['event_functionality']?></small>
                  </div>
				  <div class="col-xs-3">
					<small class="stat-label">
						<div class="thumb">
                                                    <img src="<?php echo SITE_URL.'uploads/'.front_image('organizer',$event['organiser_photo'])?>" class="img-responsive userlogor" alt="Organizer"/>
						</div>
					</small>
					<small class="stat-label">
						<div class="thumb">
						<img src="<?php echo CLIENT_IMAGES?>tradeindia.png" class="img-responsive userlogor" />
						</div>
					</small>
                  </div>
                </div><!-- row -->
                
				<h4 class="tits"><?php echo $event['event_name'] ?></h4>
				</a>
                  <?php 
                    if(!is_null($event['featured'])  && $event['featured'] == 1)
                    {
                  
                  ?>
				<div class="panel panel-dark">
					<div class="panel-heading">
					  <ul class="photo-meta">
						<li><a href="#"> <?php echo count($event['exhibitor_list'])?> Exhibitors</a></li>
						<li><a href="#"> <?php //echo count($event['exhibitor_list'])?> Speakers</a></li>
						<li><a href="#"> <?php echo count($event['attendee_list'])?> Attendees</a></li>
					  </ul>
					</div>
					<div class="panel-body">
						<div class="row">
						<div class="col-xs-6 temp text-center">
                                                    <?php 
                                                        if($event['attendee_list'])
                                                        {
                                                            echo '<ul class="social-list">';
                                                            $i=0;
                                                            foreach($event['attendee_list'] as $attendee)
                                                            {
                                                                $i++;
                                                                echo '<li><a href="javascript:;"><img class="img-responsive" src="'.SITE_URL.'uploads/'.front_image('attendee',$attendee['attendee_image']).'"></a></li>'
                                                                    
                                                        ?>

                                                    <!-- <li><a href="#"><img class="img-responsive" src="<?php //echo CLIENT_IMAGES?>1.jpg"></a></li>-->

                                                        <?php        
                                                        if($i == 3)    
                                                            break;
                                                            }
                                                            echo '</ul><h5>'. count($event['attendee_list']).' Common Connections</h5>';
                                                        }
                                                    ?>    
                                                    
                                                      
									
								
						  
						</div>
						<div class="col-xs-6 weather text-center">
						  <ul class="social-list">
									<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>gallery1.png"></a></li>
									<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>gallery2.png"></a></li>
									<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>gallery3.png"></a></li>
								</ul>
						  <h5>Gallery</h5>
						</div>
					  </div>
					</div>
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
