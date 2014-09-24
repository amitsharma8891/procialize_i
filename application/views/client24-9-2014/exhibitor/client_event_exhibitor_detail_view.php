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
    
    <?php //display($exhibitor_detail);?>
    <div class="contentpanel">
    <div class="panel panel-default panel-stat">
		<div class="panel-heading panel-heading-alt">
      <div class="row">
        
		<div class="col-xs-12">
              <div class="stat attnd exhbt">
                <div class="row">
                  <div class="col-xs-4">
                    <div class="thumb">
						<img src="<?php echo SITE_URL.'uploads/'.front_image('exhibitor',$exhibitor_detail['exhibitor_logo'])?>" alt="" class="img-responsive userlogo"/>
					</div>
                  </div>
                  <div class="col-xs-8 eventdet">
                   <span class="pull-right mr10">
                       <?php if($exhibitor_detail['exhibitor_featured'] == 1) {?>	
						<p class="featured_icon"><i class="fa fa-bookmark"></i></p>
                       <?php }?>
					</span>
                    
					<h4><?php echo $exhibitor_detail['exhibitor_name']?></h4>
                    <small class="stat-label"><?php echo $exhibitor_detail['exhibitor_city'].', '.$exhibitor_detail['exhibitor_country']?></small>
                    <small class="stat-label"><?php echo $exhibitor_detail['exhibitor_industry']?></small>
                    <?php if($exhibitor_detail['stall_number']){?>
                    <small class="stat-label">Stall Number: <strong><?php echo $exhibitor_detail['stall_number']?></strong></small>
                    <?php }?>
                  </div>
				  
                </div><!-- row -->
				
				<hr class="mt9">
                                <?php if($this->session->userdata('client_attendee_id') != $exhibitor_detail['attendee_id']) {?>
                                <div class="row">
					<div class="col-xs-6">
					<a class="btn btn-success input-sm btn-block newmsglink" data-toggle="modal" data-target="#new_msg">Send Message</a>
					</div>
					<div class="col-xs-6">
                                            <a href="<?php echo SITE_URL.'events/set-meeting/'.$exhibitor_detail['attendee_id']?>" class="btn btn-success input-sm btn-block">Set Meeting</a>
					</div>
				</div>
                                <?php } ?>
				
				
				<div class="panel panel-dark mt9">
					<div class="panel-heading">
						<ul class="photo-meta br1">
						  <li class="active"><a href="#info" data-toggle="tab">Info</a></li>
						  <li><a href="#offers" data-toggle="tab">Notifications</a></li>
						  <li><a href="#activities" data-toggle="tab">Activities</a></li>
						</ul>
					</div>
					<div class="panel-body">
					<div class="tab-content">
					  <div class="tab-pane active" id="info">
                                              <?php 
                                                if($exhibitor_detail['exhibitor_industry'])
                                                    echo '<p><strong>Industry:</strong>'.$exhibitor_detail['exhibitor_industry'].'</p>';
                                                if($exhibitor_detail['exhibitor_functionality'])
                                                    echo '<p><strong>Functionality:</strong>'.$exhibitor_detail['exhibitor_functionality'].'</p>';
                                                if($exhibitor_detail['first_name'] || $exhibitor_detail['last_name'])
                                                    echo '<p><strong>Contact:</strong> '.$exhibitor_detail['first_name'].' ' .$exhibitor_detail['last_name'].'</p>';
                                              ?>
						
						


						

						<?php if($exhibitor_detail['brochure'])
                                                    {
                                                        if(file_exists(UPLOADS.'exhibitor/brochure/'.$exhibitor_detail['brochure']))
                                                        {
                                                            ?>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <a class="btn btn-success input-sm btn-block newmsglink" href="<?php echo SITE_URL?>client/event/download/E/<?php echo $target_user_id.'/'.$exhibitor_detail['brochure']?>">Download Brochure</a>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        }
                                                    }
                                                ?>
<!--							<div class="col-xs-6">
                                                            <a class="btn btn-success input-sm btn-block newmsglink" href="<?php echo SITE_URL?>client/event/download/E/<?php echo $exhibitor_detail['brochure']?>">Download Brochure</a>
							</div>-->
<!--							<div class="col-xs-6">
							<a class="btn btn-success input-sm btn-block">View Stall Map</a>
							</div>-->
						
						
						<ul class="list-inline mt9">
                                                     <?php 
                                                            if($exhibitor_detail['image1'])
                                                            {
                                                                if(file_exists(UPLOADS.'exhibitor/'.$exhibitor_detail['image1']))
                                                                echo '<li class="open_gallery"><a href="#"><img class="img-responsive" src="'.SITE_URL.'uploads/exhibitor/'.$exhibitor_detail['image1'].'"></a></li>';
                                                            }
                                                            if($exhibitor_detail['image2'])
                                                            {
                                                                if(file_exists(UPLOADS.'exhibitor/'.$exhibitor_detail['image2']))
                                                                echo '<li class="open_gallery"><a href="#"><img class="img-responsive" src="'.SITE_URL.'uploads/exhibitor/'.$exhibitor_detail['image2'].'"></a></li>';
                                                            }
                                                            
                                                        ?>
							
						</ul>
						
						<p class="text-justify"><?php echo $exhibitor_detail['exhibitor_description']?></p>
						<!--<p class="text-justify">Established in 2006 with a vision to grow and excel, Infini Systems has now grown to 39 IT Professionals. With Clients across six countries, combined with extensive & in-depth knowledge about the various domains and technology platforms, we offer our clients the most appropriate solutions. Our experience in managing technology projects, right from selecting appropriate tools and platforms, to implementing information technology solutions has a proven track record.</p>-->
					  </div>
                                            <div class="tab-pane" id="offers">
                                                <?php 
                                                    if($exhibitor_notification)
                                                    {
                                                        //display($exhibitor_notification);
                                                        foreach($exhibitor_notification as $key2 => $noti)
                                                        {
                                                            
                                                            ?>
                                                
                                                                <div class="row">
                                                                <div class="col-xs-12">
                                                                      <h4><?php echo $noti['notification_content'] ?></h4>
                                                                      <small class="stat-label"><?php echo date('d M Y',  strtotime($noti['notification_date']))?>, <?php echo $noti['event_name']?></small>
                                                                </div>
                                                                </div>
                                                
                                                                
                                                               
                                                            
                                                            
                                                            <?php
                                                            if($key2 != count($exhibitor_notification)-1) 
                                                                echo "<hr>"; 
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo 'No Notification';
                                                    }
                                                    ?>
                                            </div>
                                          <div class="tab-pane" id="activities">
                                              <?php 
                                                    if($activity)
                                                    {
                                                        
                                                        foreach($activity as $key1 => $act)
                                                        {
                                                            if($act['notification_type'] == 'Sh' || $act['notification_type'] == 'Sav')
                                                            {
                                                                if($act['notification_type'] == 'Sh')
                                                                    $type = 'Shared';
                                                                elseif($act['notification_type'] == 'Sav')
                                                                    $type = 'Saved';

                                                                if($act['receiver_data']['attendee_type'] == 'A')
                                                                {
                                                                    $user_type  = 'Attendee';
                                                                    $detail_page = 'attendee';
                                                                }
                                                                elseif($act['receiver_data']['attendee_type'] == 'E')
                                                                {
                                                                    $user_type  = 'Exhibitor';
                                                                    $detail_page = 'exhibitor';
                                                                }
                                                                if($act['receiver_data']['attendee_type'] == 'S')
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
					</div>
					</div>
				</div>
				
              </div><!-- stat -->
			  
        </div><!-- col-sm-6 -->
		
      </div><!-- row -->
      </div>
	</div>
    </div><!-- contentpanel -->
    
  </div><!-- mainpanel -->
      <input type="hidden" name="subject_type" id="subject_type_notfication" value="<?php echo $target_user_type?>">
    <input type="hidden" name="subject_id" id="subject_id_notfication" value="<?php echo $target_user_id?>">
  <div class="rightpanel">
      
      <!--Right panel view--->
      <?php  $this->load->view(CLIENT_RIGHT_PANEL)?>
      <!--Right panel view--->
    
  </div><!-- rightpanel -->
  
</section>
<!---image gallery pop up---->

<div id="gallery_image_pop"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Image Gallery</h4>
            </div>
      	<center>
        <div class="modal-body place_gallery_image">
            
        </div>
        </center>
      
    </div>
  </div>
  
</div>
<!---image gallery pop up---->
<script type="text/javascript">
$(document).ready(function ()
{
    $('.open_gallery img').click(function()
    {
        //alert($(this).attr("src"));
        $("#gallery_image_pop").modal('show');
        $(".place_gallery_image").html('<img class="img-responsive" src="'+$(this).attr("src")+'">');
    });
});
</script>
<?php $this->load->view(CLIENT_FOOTER)?>
