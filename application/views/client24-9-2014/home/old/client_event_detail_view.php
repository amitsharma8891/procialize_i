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
              <div class="stat well well-sm">
                <div class="row">
                  <div class="col-xs-4">
                    <div class="thumb">
                        <img src="<?php echo SITE_URL.'uploads/'.front_image('logo',$event['event_logo'])?>" alt="" class="img-responsive userlogo"/>
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
						<!--<img src="<?php //echo CLIENT_IMAGES?>epc.png" class="img-responsive userlogor" />-->
						</div>
					</small>
					<small class="stat-label">
						<div class="thumb">
						<img src="<?php echo CLIENT_IMAGES?>tradeindia.png" class="img-responsive userlogor" />
						</div>
					</small>
                  </div>
                </div><!-- row -->
                
				<h4 class="tits"><?php echo $event['event_name']?></h4>
				<hr class="mb9">
				<a class="btn btn-success input-sm btn-block mb9">Event Registration</a>
				
				<input type="text" class="form-control input-sm mb9" placeholder="Already Registered? Enter Passcode">
				<hr class="mb9">
				<div class="panel panel-dark panel-event">
					<div class="panel-heading">
					  <ul class="photo-meta">
						<li><a href="#">Common Connections</a></li>
					  </ul>
					</div>
					<div class="panel-body">
						<div class="row">
						<div class="col-xs-6 temp text-center">
						  <ul class="social-list">
									<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>1.jpg"></a></li>
									<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>2.jpg"></a></li>
									<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>3.jpg"></a></li>
									<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>4.jpg"></a></li>
									<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>1.jpg"></a></li>
								</ul>
						  <h5>10 Industry</h5>
						</div>
						<div class="brbr"></div>
						<div class="col-xs-6 temp text-center">
						  <ul class="social-list">
									<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>1.jpg"></a></li>
									<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>2.jpg"></a></li>
									<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>3.jpg"></a></li>
									<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>4.jpg"></a></li>
									<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>1.jpg"></a></li>
								</ul>
						  <h5>6 Location</h5>
						</div>
					  </div>
					</div>
				</div>
				
				<address>
				<strong>Venue:</strong> <?php echo $event['event_location']?><br>
				<strong>Email:</strong> <?php echo $event['contact_email']?><br>
				<strong>Website:</strong> <?php echo $event['website']?><br>
				</address>
				
				<ul class="list-inline mb5">
					<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>gallery1.png"></a></li>
					<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>gallery2.png"></a></li>
					<li><a href="#"><img class="img-responsive" src="<?php echo CLIENT_IMAGES?>gallery3.png"></a></li>
				</ul>
				
				<img src="<?php echo CLIENT_IMAGES?>googlemaps.png" class="img-responsive thumb mapimg mb9">
				
				<!--<p class="text-justify">Home Expo India is a composite platform for showcasing India's products for the Home segment, comprising 3 sub shows; Indian Furnishings, Floorings & Textiles Show (IFFTEX); Indian Houseware & Decoratives Show (IHDS) and Indian Furniture & Accessories Show (IFAS).</p>-->
				
				<p class="text-justify"><?php echo $event['event_description']?></p>
				
				<a class="btn btn-success input-sm btn-block mt9">Event Registration</a>
				
              </div><!-- stat -->
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
