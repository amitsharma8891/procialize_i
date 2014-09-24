<script type="text/javascript">
  
  
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=664018516966781&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
   
</script>
<script type="text/javascript" src="<?php echo CLIENT_SCRIPTS?>/modules/event_module.js"></script>
<div class="pageheader">
                <?php
                    //$this->load->model('client/client_event_model');
                    $agenda_list = getSession();//$this->model->getSession(NULL,$this->session->userdata('client_event_id'));
                    $info_highlight           = '';
                    $agenda_highlight         = '';
                    $speaker_highlight        = '';
                    $attendee_highlight       = '';
                    $exhibitor_highlight      = '';
                    if($this->uri->segment(2) == 'agenda')
                        $agenda_highlight      = 'class="active"';
                    elseif($this->uri->segment(2) == 'speaker')
                        $speaker_highlight      = 'class="active"';
                    elseif($this->uri->segment(2) == 'attendee')
                        $attendee_highlight      = 'class="active"';
                    elseif($this->uri->segment(2) == 'exhibitor')
                        $exhibitor_highlight      = 'class="active"';
                    elseif($this->uri->segment(2) == 'event-detail')
                        $info_highlight      = 'class="active"';
                    elseif($this->uri->segment(2) == 'attendee-detail')
                        $active      = 'class="active"';
                    
                    
                    $top_naviagtion_array    = array(
                                                     'Agenda',   
                                                     'Speaker',   
                                                     'Attendee',   
                                                     'Exhibitor',   
                                                     );   
                    if(!$agenda_list)
                        unset($top_naviagtion_array[0]);
                    if($total_speaker == 0)
                        unset($top_naviagtion_array[1]);
                    if($total_exhibitor == 0)
                        unset($top_naviagtion_array[3]);
                    
                ?>
                <div class="navtop">
                    <ul class="photo-meta">
                        <li <?php echo $info_highlight?>>
                            <a class="" href="<?php echo SITE_URL?>events/event-detail/<?php echo $this->session->userdata('client_event_id')?>" href="event.html">
                                <i class="fa fa-list-ul" ></i>
				<span>Info</span></a>
				</li>
                        <?php 
                            
                            foreach($top_naviagtion_array as $nav)
                            {
                                $active= '';
                                if($this->uri->segment(2) == strtolower($nav) || $this->uri->segment(2) == strtolower($nav).'-detail')
                                        $active         = 'class="active"';
                                //elseif()
                                ?>
                                <li <?php echo $active;?> >
                                    <?php 
                                    
                                        if(!passcode_validatation() && ($nav != 'Agenda' && $nav != 'Speaker'))
                                            echo '<a href="javascript:;" class=""  data-toggle="modal" data-target="#SignUp">';
                                        else
                                            echo '<a href="'.SITE_URL.'events/'.strtolower($nav).'" class=""  >';
                                    ?>
                                
				
				<span><?php 
                                    
                                        if($nav == 'Agenda' && $agenda_list)
                                        {
                                             echo '<i class="fa fa-dot-circle-o"></i><span>'.$nav.'</span>';
                                        }
                                        elseif($nav == 'Speaker' && $total_speaker != 0)
                                        {
                                            echo '<i class="fa fa-microphone"><span> ('.$total_speaker.')</span></i><span>'.$nav.'s</span> ';
                                        }
                                            
                                        elseif($nav == 'Attendee' )
                                        {
                                            echo '<i class="fa fa-user"><span> ('.$total_attendee.')</span></i><span>'.$nav.'s</span>';
                                        }
                                            
                                        elseif($nav == 'Exhibitor' && $total_exhibitor != 0)
                                        {
                                            echo  '<i class="fa fa-briefcase"><span> ('.$total_exhibitor.')</span></i><span>'.$nav.'s</span> ';
                                        }
                                            
                                    ?>
                                </span></a>
				</li>
                                <?php 
                            }
                        ?>
                    </ul>
                </div>


<!---top navigation register pop up ---->
<div class="modal fade" id="SignUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<p class="text-center">Get registered with this Event and get access to its  Exhibitors, Attendees  etc.</p>
				<p class="text-center">Passcode will be sent to your registered email id</p>
				<p class="text-center"><strong>Register Now!</strong></p>
			</div>
		</div>
          <button class="btn btn-success btn-block" onclick="event_registration()">Interested? Register for Event</button>
      </div>
    </div>
  </div>
</div>
<!---top navigation register pop up ---->


