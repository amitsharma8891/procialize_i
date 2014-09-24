   <!---client header view--->
    <?php $this->load->view(CLIENT_HEADER)?>
    
    <!---client header view--->
    
    
    <!----event top navigation---->
    <?php $this->load->view(EVENT_TOP_NAVIGATION)?>
    <!----event top navigation---->
   </div>
    
    
    <div class="contentpanel">
    <div class="panel panel-default panel-stat">
		<div class="panel-heading panel-heading-alt">
		
      <div class="row">
        
		<div class="col-xs-12">
              <div class="stat attnd">
                <div class="row">
                  <div class="col-xs-12">
			<h4><?php echo $session_detail['session_name']?></h4>
                    <small class="stat-label">
                            <?php echo date('d M Y',  strtotime($session_detail['session_start_time']))?> 
                            <?php echo date('H.i',  strtotime($session_detail['session_start_time'])).'-'.date('H.i',  strtotime($session_detail['session_end_time']))?> 
                    </small>
                    <small class="stat-label"><?php echo $session_detail['track_name']?></small>
                  </div>
                </div><!-- row -->
				
				<hr class="mt9">
                                
                                <div class="row" id="rsvp_row" style="display: none">
                                     <div class="col-xs-12">
					<a data-toggle="modal" data-target="#RSVP" class="btn btn-success input-sm btn-block mt9">RSVP</a>
                                    </div>
                                </div>
                                
                                <div class="row" id="ask_question_row" style="display: none">
                                    <div class="col-xs-6 expandBar">
                                    <a class="btn btn-success input-sm btn-block newmsglink" data-toggle="modal" data-target="#new_msg">Ask Question</a> 
                                    </div>
                                    <?php if($session_detail['session_profile'])
                                            {
                                                if(file_exists(UPLOADS.'session/'.$session_detail['session_profile']))
                                                {
                                                    $expand_bar_flag            = FALSE;
                                                    ?>
                                                        <div class="col-xs-6">
                                                            <a class="btn btn-success input-sm btn-block" href="<?php echo SITE_URL.'client/event/download/SESSION/'.$session_detail['session_id'].'/'.$session_detail['session_profile'];?>" download>Download Profile</a>
                                                        </div>
                                                    <?php
                                                }
                                                else
                                                    $expand_bar_flag            = TRUE;
                                            }
                                            else
                                            {
                                               $expand_bar_flag            = TRUE;
                                            }
                                    ?>
                                    
				</div>
				
				<div class="panel panel-dark mt9">
                                    <div class="panel-heading">
                                        <ul class="photo-meta br1">
                                            <?php 
                                                $rsvp_flag_modal = FALSE;
                                                $attendee_modal   = 'href = "javascript:;" data-toggle="modal" data-target="#RSVP"';
                                                $question_modal   = 'href = "javascript:;" data-toggle="modal" data-target="#RSVP"';
                                                $info_modal       = 'href = "javascript:;" data-toggle="modal" data-target="#RSVP"';
                                                if($session_attendee)
                                                {
                                                    foreach($session_attendee as $attendee)
                                                    {
                                                        if($attendee['attendee_id'] == $this->session->userdata('client_attendee_id'))
                                                        {
                                                            $rsvp_flag_modal = TRUE;
                                                            break;
                                                        }

                                                    }

                                                    if($rsvp_flag_modal)
                                                    {
                                                        $attendee_modal           = 'href="#attendees" data-toggle="tab"';
                                                        $question_modal           =  'href="#questions" data-toggle="tab"';   
                                                        $info_modal               =  'onclick="save_feedback()"';   
                                                    }
                                                }
                                            ?>
                                          <li class="active"><a href="#info" data-toggle="tab">Info</a></li>
                                          <li><a href="#speakers" data-toggle="tab">Speakers (<?php echo count($session_speaker)?>)</a></li>
                                          <li><a <?php echo $attendee_modal?>>Attendees (<?php echo count($session_attendee)?>)</a></li>
                                          <li><a <?php echo $question_modal?>>Questions (<?php echo count($session_question)?>)</a></li>
                                        </ul>
                                    </div>
					<div class="panel-body">
					<div class="tab-content">
					  <div class="tab-pane active" id="info">
<!--						<p class="text-justify">Information technology (IT) is the application of computers and telecommunications equipment to store, retrieve, transmit and manipulate data, often in the context of a business or other enterprise. The term is commonly used as a synonym for computers and computer networks, but it also encompasses other information distribution technologies such as television and telephones. Several industries are associated with information technology, including computer hardware, software, electronics, semiconductors, internet, telecom equipment, e-commerce and computer services.</p>-->
						<p class="text-justify"><?php echo $session_detail['session_description']?></p>
						<hr class="mt9">
                                                <div id="feedback_div">
							<h4>Kindly share feedback for the session</h4> 
							<br>
							<p class="rating mt10" style="color: #369095;"><input type="number" name="rating" id="rating" class="rating"></p>
                                                        <input type="hidden" name="feedback_type" id="feedback_type" value="session">
                                                        <input type="hidden" name="target_id" id="target_id" value="<?php echo $session_detail['session_id']?>">
							<br>
                                                        <a class="btn btn-success input-sm btn-block newmsglink mb10" <?php echo $info_modal?>>Submit</a>
                                                </div>
							<div class="tinystat mr20">
							
							  <small class="stat-label">Total number of Attendees who gave feedback
							  <h4><?php echo $session_detail['total_feedback_count']?></h4>
							</small><small class="stat-label">
						  	</small></div>
					  </div>
					  <div class="tab-pane" id="speakers">
                                              <?php 
                                                if($session_speaker)
                                                {
                                                    //display($session_speaker);
                                                    foreach($session_speaker as $speaker)
                                                    {
                                                        ?>
                                                    <a href="<?php echo SITE_URL.'events/speaker-detail/'.$speaker['attendee_id']?>">
                                                        <div class="stat well well-sm attnd">
                                                            <div class="row">
                                                              <div class="col-xs-4">
                                                                <div class="thumb">
                                                                    <img src="<?php echo SITE_URL.'uploads/'.front_image('speaker',$speaker['attendee_image'])?>" alt="" class="img-responsive userlogo"/>
                                                                </div>
                                                              </div>
                                                              <div class="col-xs-6 eventdet">
                                                                <h4><?php echo $speaker['attendee_name']?></h4>
                                                                <small class="stat-label"><?php echo designation_company($speaker['attendee_designation'],$speaker['attendee_company'])?></small>
                                                                <small class="stat-label"><?php echo industry_functionality($speaker['attendee_industry'],$speaker['attendee_functionality'])?></small>
                                                                <small class="stat-label"><?php echo $speaker['attendee_city']?></small>
                                                              </div>
                                                              <div class="col-xs-2">
                                                                  
                                                              </div>
                                                            </div><!-- row -->
                                                        </div><!-- stat -->
                                                    </a><!-- row -->        
                                                        <?php
                                                    }
                                                }
                                                else
                                                {
                                                    echo 'No Speakers!';
                                                }
                                              ?>
                                            
					  </div>
                                            <?php
                                                $rsvp_flag = FALSE;
                                                $attendee_tab   = '';
                                                $question_tab   = '';
                                                if($session_attendee)
                                                {
                                                    foreach($session_attendee as $attendee)
                                                    {
                                                        if($attendee['attendee_id'] == $this->session->userdata('client_attendee_id'))
                                                        {
                                                            $rsvp_flag = TRUE;
                                                            break;
                                                        }
                                                            
                                                    }
                                                    
                                                    if($rsvp_flag)
                                                    {
                                                        $attendee_tab           = 'id="attendees"';
                                                        $question_tab           =  'id="questions"';   
                                                    }
                                                }
                                            ?>
                                            
                                            <div class="tab-pane" <?php echo $attendee_tab?>>
                                              <?php
                                                $div_id     = 'rsvp_row';
                                                if($session_attendee)
                                                {
                                                    foreach($session_attendee as $attendee)
                                                    {
                                                        if($attendee['attendee_id'] == $this->session->userdata('client_attendee_id'))
                                                            $div_id = 'ask_question_row';
                                                        
                                                        ?>
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
                                                                        <small class="stat-label"><?php echo designation_company($attendee['attendee_designation'],$attendee['attendee_company'])?></small>
                                                                        <small class="stat-label"><?php echo industry_functionality($attendee['attendee_industry'],$attendee['attendee_functionality'])?></small>
                                                                        <small class="stat-label"><?php echo $attendee['attendee_city']?></small>
                                                                      </div>
                                                                      
                                                                    </div><!-- row -->
                                                                </div><!-- stat -->
                                                            </a>
                                                        <?php
                                                    }
                                                }
                                                else
                                                {
                                                    echo 'No Attendee!';
                                                }
                                              ?>
                                            
                                              
					</div>
                                            
					  <div class="tab-pane" <?php echo $question_tab?>>
						<?php 
                                                    if($session_question)
                                                    {
                                                        foreach($session_question as $question)
                                                        {
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                      <div class="stat well well-sm attnd">
                                                                      <h4><?php echo $question['question']?></h4>
                                                                      <small class="stat-label"><?php echo $question['name']?> (<?php echo $question['designation'].', '.$question['company_name'].') ',date('d M Y',strtotime($question['created_date']))?>)</small>
                                                                      </div>
                                                                </div>
                                                              </div><!-- row -->
                                                            <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo 'No Questions!';
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
  
  
<div id="new_msg" class="modal fade">
    <div class="modal-dialog">
         <div id="success_msg"></div>
        <div class="modal-content question_form_div">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">New Question</h4>
            </div>
           
            <form class="form-horizontal" role="form" id="session_question_form" onsubmit="return false;">
                <div class="modal-body">

                   <div class="col-sm-8">
                                  <div class="form-group">
                          <p>Questions will be answered by Speakers at the time of session. Write your question below:</p>
                    </div>


                      <div class="form-group">
                          <textarea class="form-control" name="question" id="question" rows="3" placeholder="Write your question here"></textarea>
                      </div>
                      <div class="form-group">
                          <input type="hidden" name="session" value="<?php echo $session_detail['session_id'];?>">
                       <button type="submit" class="btn btn-success input-sm btn-block">Send</button>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>

            </form>
        </div>
    </div>
</div>
  
  <div class="rightpanel">
      
      <!--Right panel view--->
      <?php  $this->load->view(CLIENT_RIGHT_PANEL)?>
      <!--Right panel view--->
    
  </div><!-- rightpanel -->
  
  
</section>

<!----rsvp pop up--->


<div class="modal fade" id="RSVP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<p class="text-center">RSVP this Session to get access to Attendees,  Questions etc.</p>
				<!--<p class="text-center">Passcode will be sent to your registered email id</p>-->
				<p class="text-center"><strong>RSVP Now!</strong></p>
			</div>
		</div>
          <button class="btn btn-success btn-block" onclick="attendee_rsvp('<?php echo $session_detail['session_id'];?>')">Interested? RSVP to the Session</button>
      </div>
    </div>
  </div>
</div>

<!----rsvp pop up--->


<script type="text/javascript">
$(document).ready(function()
{
    if('<?php echo $expand_bar_flag?>')
    {
        $('.expandBar').removeClass('col-xs-6');
        $('.expandBar').addClass('col-xs-12');
    }
   if($.cookie('<?php echo $session_detail['session_id']?>') == 'session') 
       $("#feedback_div").remove();
   
    
   $("#"+'<?php echo $div_id?>').show();
   $("#session_question_form").submit(function()
   {
       var form_data                                                            = $("#session_question_form").serialize();
       var question                                                              = $("#question").val();
       if(!question)
           return false;
       $.ajax({
                type                                                            : 'POST',
                url                                                             : SITE_URL+"client/event/add_session_quetion",
                dataType                                                        : 'json',
                data                                                            : form_data,
                success: function(msg)
                {
                    var data                                                    = eval(msg);
                    if(data.error == 'success')
                    {
                        $(".question_form_div").hide();
                        var redirect = location.reload();
                        show_ajax_success('Success',data.msg,redirect);
                    }
                    else
                    {
                        show_ajax_success('Success',data.msg);
                    }
                    
                }
            });
   }); 
});    
    
function attendee_rsvp(session_id)
{
    $.ajax({
                type                                                            : 'POST',
                url                                                             : SITE_URL+"client/event/session_rsvp",
                dataType                                                        : 'json',
                data                                                            : {
                                                                                    session_id				: session_id
                                                                                   },
                success: function(msg)
                {
                    var data                                                    = eval(msg);
                    if(data.error == 'success')
                    {
                        $("#")
                        $(".remove_rsvp").remove();
                        //alert(data.msg);
                        location.reload();
                    }
                    else
                    {
                        $("#RSVP").modal('hide');
                        show_ajax_success('ERROR',data.msg)
                    }
                    
                }
            });
}
</script>
<?php $this->load->view(CLIENT_FOOTER)?>
