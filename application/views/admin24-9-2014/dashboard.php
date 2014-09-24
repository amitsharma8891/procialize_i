<script type="text/javascript">
    $(document).ready(function() {
<?php if ($this->session->flashdata('show_popup')) { ?>
            $('#tour').modal('show');
<?php } ?>
    
    var organizer_id = $("#organizer").val();
    if(organizer_id)
    {
        get_event(organizer_id);
    }
    });
function get_event(organizer_id)
{
     var organizer_id = $("#organizer").val();
    $.ajax(
        {
            type                                                                : "POST",
            url                                                                 : SITE_URL+"manage/report/get_event",
            dataType                                                            : "json",
            data                                                                : {organizer_id:organizer_id},
            success : function(message)
            {
                var val                                                         = eval(message);
                 $('#event').empty();
                $.each(val, function( index, value ) {
                    $('#event').append("<option value='"+value.event_id+"'>"+value.event_name+"</option>");
                    $('#event').trigger("chosen:updated");
                  });
            }
        });
}
function generate_report(report_type,report_for)
{
    var organizer_id = $("#organizer").val();
    var event_id = $("#event").val();
    
    window.location.href = '<?php echo base_url(); ?>'+'manage/report/generate_report/'+report_type+'/'+report_for+'/'+organizer_id+'/'+event_id;
}
</script>
<?php //display($this->session->all_userdata())
    $get_organizer = $this->organizer_model->getAll();
    //display($get_organizer)
?>
<div class="contentpanel">
    <div class="row">
        <div class="col-xs-2">
            <select name="organizer" id="organizer" onchange="get_event(this.id)" class="form-control col-xs-4">
                <?php 
                    if($get_organizer)
                    {
                        foreach($get_organizer as $org)
                        {
                            echo '<option value="'.$org['organizer_id'].'">'.$org['name'].'</option>';
                        }
                    }
                ?>
                
            </select>
        </div>
        <div class="col-xs-2">
            <select name="event" id="event" class="form-control">
            </select>
                
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-6 col-md-3">
			<div class="panel panel-success panel-stat">
				<div class="panel-heading">
					<div class="stat">
						<div class="row">
							<div class="col-xs-4"> <img src="<?php echo base_url() ?>public/admin/images/is-user.png" alt="" /> </div>
							<div class="col-xs-8"> <small class="stat-label">Total Audience</small>
								<h1><?php echo $total_attendees + $total_exhibitors + $total_speakers; ?></h1>
							</div>
						</div>
						<!-- row -->

						<div class="mb15"></div>
						<div class="row">
							<div class="col-xs-4"> <small class="stat-label">Attendee</small>
                                                            <h4><a href="javascript:;" onclick="generate_report('total_audience','attendee')"><?php echo $total_attendees; ?></a></h4>
							</div>
							<div class="col-xs-4"> <small class="stat-label">Exhibitors</small>
                                                            <h4><a href="javascript:;" onclick="generate_report('total_audience','exhibitor')"><?php echo $total_exhibitors; ?></a></h4>
							</div>
							<div class="col-xs-4"> <small class="stat-label">Speakers</small>
                                                            <h4><a href="javascript:;" onclick="generate_report('total_audience','speaker')"><?php echo $total_speakers; ?></a></h4>
							</div>
						</div>
						<!-- row --> 
					</div>
					<!-- stat --> 

				</div>
				<!-- panel-heading --> 
			</div>
			<!-- panel --> 
          </div>
        <!-- col-sm-6 -->

        <div class="col-sm-6 col-md-3">
            <div class="panel panel-danger panel-stat">
                <div class="panel-heading">
                    <div class="stat">
						<div class="row">
							<div class="col-xs-4"> <img src="<?php echo base_url() ?>public/admin/images/is-money.png" alt="" /> </div>
							<div class="col-xs-8"> <small class="stat-label">Featured</small>
								<h1><?php echo $featured_exhibtior + $total_sponsor ?></h1>
							</div>
						</div>
						<!-- row -->
						<div class="mb15"></div>
						<div class="row">
							<div class="col-xs-6"> <small class="stat-label">Exhibitors</small>
								<h4><?php echo $featured_exhibtior; ?></h4>
							</div>
							<div class="col-xs-6"> <small class="stat-label">Sponsors</small>
								<h4><?php echo $total_sponsor; ?></h4>
							</div>
						</div>
                    </div>
                    <!-- stat --> 

                </div>
                <!-- panel-heading --> 
            </div>
            <!-- panel --> 
        </div>
        <!-- col-sm-6 -->

        <div class="col-sm-6 col-md-6">
		
                            <div class="panel panel-primary panel-stat">
                                <div class="panel-heading">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-xs-2"> <img src="<?php echo base_url() ?>public/admin/images/is-document.png" alt="" /> </div>
                                            <div class="col-xs-10"> <small class="stat-label">Communication</small>
                                                <h1><?php echo $messages + $broadcasts + $communication_meeting + $alert + $communication_feedback + $communication_notification ?></h1>
                                            </div>
                                        </div>
                                        <!-- row -->

                                        <div class="mb15"></div>
                                        <div class="row">
                                            <div class="col-xs-2"> <small class="stat-label">Messages</small>
                                                <h4><?php echo $messages ?></h4>
                                            </div>
                                            <div class="col-xs-2"> <small class="stat-label">Broadcasts</small>
                                                <h4><?php echo $broadcasts ?></h4>
                                            </div>
                                            <div class="col-xs-2"> <small class="stat-label">Meetings</small>
                                                <h4><?php echo $communication_meeting ?></h4>
                                            </div>
                                            <div class="col-xs-2"> <small class="stat-label">Alerts</small>
                                                <h4><?php echo $alert ?></h4>
                                            </div>
                                            <div class="col-xs-2"> <small class="stat-label">Feedback</small>
                                                <h4><?php echo $communication_feedback ?></h4>
                                            </div>
                                            <div class="col-xs-2"> <small class="stat-label">Notific . .</small>
                                                <h4><?php echo $communication_notification ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- stat --> 

                                </div>
                                <!-- panel-heading --> 
                            </div>
                            <!-- panel --> 

		</div>
        <!-- col-sm-6 --> 

    </div>
    <!-- row -->

    <div class="row">
	
                        <div class="col-sm-6 col-md-3">
                            <div class="panel panel-dark panel-stat">
                                <div class="panel-heading">
                                    <div class="stat">
                                        <div class="row">
                                            <div class="col-xs-4"> <img src="<?php echo base_url() ?>public/admin/images/is-user.png" alt="" /> </div>
                                            <div class="col-xs-8"> <small class="stat-label">Profiles Viewed</small>
                                                <h1><?php echo $arr_exh_view + $arr_att_view + $arr_spk_view; ?></h1>
                                            </div>
                                        </div>
                                        <!-- row -->

                                        <div class="mb15"></div>
                                        <div class="row">
                                            <div class="col-xs-4"> <small class="stat-label">Attendee</small>
                                                <h4><?php echo $arr_att_view; ?></h4>
                                            </div>
                                            <div class="col-xs-4"> <small class="stat-label">Exhibitor</small>
                                                <h4><?php echo $arr_exh_view; ?></h4>
                                            </div>
                                            <div class="col-xs-4"> <small class="stat-label">Speaker</small>
                                                <h4><?php echo $arr_spk_view ?></h4>
                                            </div>
                                        </div>
                                        <!-- row --> 
                                    </div>
                                    <!-- stat --> 

                                </div>
                                <!-- panel-heading --> 
                            </div>
                            <!-- panel --> 
                        </div>
                        <!-- col-sm-6 -->

                        <div class="col-sm-6 col-md-3">
                            <div class="panel panel-primary panel-stat">
                                <div class="panel-heading">
                                    <div class="stat">
                                        <div class="row">
                                            <div class="col-xs-4"> <img src="<?php echo base_url() ?>public/admin/images/is-document.png" alt="" /> </div>
                                            <div class="col-xs-8"> <small class="stat-label">Profiles Saved</small>
                                                <h1><?php echo $saveAttendee + $saveExhibitor + $saveSpeaker; ?></h1>
                                            </div>
                                        </div>
                                        <!-- row -->

                                        <div class="mb15"></div>
                                        <div class="row">
                                            <div class="col-xs-4"> <small class="stat-label">Attendee</small>
                                                <h4><?php echo $saveAttendee ?></h4>
                                            </div>
                                            <div class="col-xs-4"> <small class="stat-label">Exhibitors</small>
                                                <h4><?php echo $saveExhibitor ?></h4>
                                            </div>
                                            <div class="col-xs-4"> <small class="stat-label">Speakers</small>
                                                <h4><?php echo $saveSpeaker ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- stat --> 

                                </div>
                                <!-- panel-heading --> 
                            </div>
                            <!-- panel --> 
                        </div>
                        <!-- col-sm-6 -->

                        <div class="col-sm-6 col-md-3">
                            <div class="panel panel-danger panel-stat">
                                <div class="panel-heading">
                                    <div class="stat">
                                        <div class="row">
                                            <div class="col-xs-4"> <img src="<?php echo base_url() ?>public/admin/images/is-document.png" alt="" /> </div>
                                            <div class="col-xs-8"> <small class="stat-label">Profiles Shared</small>
                                                <h1><?php echo $sharedAttendee + $sharedExhibitor + $sharedSpeaker + $sharedEvent; ?></h1>
                                            </div>
                                        </div>
                                        <!-- row -->

                                        <div class="mb15"></div>
                                        <div class="row">
                                            <!-- <div class="col-xs-3"> <small class="stat-label">Event</small>
                                                <h4><?php echo $sharedEvent ?></h4>
                                            </div> -->
                                            <div class="col-xs-3"> <small class="stat-label">Attendee</small>
                                                <h4><?php echo $sharedAttendee ?></h4>
                                            </div>
                                            <div class="col-xs-3"> <small class="stat-label">Exhib . .</small>
                                                <h4><?php echo $sharedExhibitor ?></h4>
                                            </div>
                                            <div class="col-xs-3"> <small class="stat-label">Speakers</small>
                                                <h4><?php echo $sharedSpeaker ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- stat --> 

                                </div>
                                <!-- panel-heading --> 
                            </div>
                            <!-- panel --> 
                        </div>
                        <!-- col-sm-6 -->

                        <div class="col-sm-6 col-md-3">
                            <div class="panel panel-success panel-stat">
                                <div class="panel-heading">
                                    <div class="stat">
                                        <div class="row">
                                            <div class="col-xs-4"> <img src="<?php echo base_url() ?>public/admin/images/is-document.png" alt="" /> </div>
                                            <div class="col-xs-8"> <small class="stat-label">Profile Downloads</small>
                                                <h1><?php echo $download_evt_map + $download_ses_pros + $download_spe_pro + $download_exh_pro ?></h1>
                                            </div>
                                        </div>
                                        <!-- row -->

                                        <div class="mb15"></div>
                                        <div class="row">
                                            <div class="col-xs-3"> <small class="stat-label">E Map</small>
                                                <h4><?php echo $download_evt_map ?></h4>
                                            </div>
                                            <div class="col-xs-3"> <small class="stat-label">Session</small>
                                                <h4><?php echo $download_ses_pros ?></h4>
                                            </div>
                                            <div class="col-xs-3"> <small class="stat-label">Exhib . .</small>
                                                <h4><?php echo $download_exh_pro ?></h4>
                                            </div>
                                            <div class="col-xs-3"> <small class="stat-label">Speakers</small>
                                                <h4><?php echo $download_spe_pro ?></h4>
                                            </div>
                                        </div>
                                        <!-- row --> 

                                    </div>
                                    <!-- stat --> 

                                </div>
                                <!-- panel-heading --> 
                            </div>
                            <!-- panel --> 
                        </div>
                        <!-- col-sm-6 --> 

	</div>


</div>
<!-- contentpanel --> 



<?php
$Usertype = $this->session->userdata('type_of_user');

if ($this->session->userdata('is_superadmin') == 1 || ($Usertype == 'O')) {
    ?>

    <div class="modal fade" id="tour" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="#" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                    </div>
                    <h4 class="panel-title">Tour</h4>
                    <p>This basic wizard will help you to Navigate the Site</p>
                </div>

                <div class="panel-body panel-body-nopadding">

                    <!-- BASIC WIZARD -->
                    <div id="basicWizard" class="basic-wizard">

                        <ul class="nav nav-pills nav-justified">
                            <li><a href="#tab1" data-toggle="tab"><span>Step 1</span></a></li>
                            <li><a href="#tab2" data-toggle="tab"><span>Step 2</span></a></li>
                            <li><a href="#tab3" data-toggle="tab"><span>Step 3</span></a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <img class="img-responsive" src="<?php echo base_url(); ?>public/admin/images/photos/step1.jpg">
                            </div>
                            <div class="tab-pane" id="tab2">
                                <img class="img-responsive" src="<?php echo base_url(); ?>public/admin/images/photos/step2.jpg">
                            </div>
                            <div class="tab-pane" id="tab3">
                                <img class="img-responsive" src="<?php echo base_url(); ?>public/admin/images/photos/step3.jpg">
                            </div>


                        </div><!-- tab-content -->

                        <ul class="pager wizard">
                            <li class="previous"><a href="javascript:void(0)" data-dismiss="modal">Skip</a></li>

                        </ul>

                    </div><!-- #basicWizard -->

                </div><!-- panel-body -->
            </div><!-- panel -->
        </div>
    </div>
<?php } ?>
