<!---client header view--->
<?php $this->load->view(CLIENT_HEADER) ?>

<!---client header view--->
<?php if ($this->session->userdata('client_user_id') && $this->session->userdata('client_event_id')) { ?>
    <!----event top navigation---->
    <?php $this->load->view(EVENT_TOP_NAVIGATION) ?>
    <!----event top navigation---->

    </div>
<?php } ?>

<style type="text/css">
    .truncate {
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="contentpanel">
    <div class="panel panel-default panel-stat">
        <div class="panel-heading-alt">

            <div class="row">

                <div class="col-xs-12">

                    <?php
                    //display($this->session->all_userdata());
                    //display($notification);
                    $passcode = '';
                    if ($notification && $this->session->userdata('client_user_id')) {
                        //display($notification);
//                        echo "<pre/>";
//                        print_r($notification);
//                        DIE;

                        foreach ($notification as $notify) {
//                         echo "<pre/>";   print_r($notify);DIE;
                            //echo '<div class="row"><div class="col-xs-12"><div class="stat well well-sm attnd">';
                            if ($notify['object_type'] == 'A') {
                                // echo '41attendee';
                                $type_of_user = 'Attendee - ' . $notify['attendee_name'] . ' (' . designation_company($notify['designation'], $notify['company_name']) . ')';
                            } elseif ($notify['object_type'] == 'E') {
                                //echo '46exhibitor';
                                $type_of_user = 'Exhibitor - <a href="' . SITE_URL . 'events/exhibitor-detail/' . $notify['object_id'] . '">' . $notify['first_name'] . ' ' . $notify['last_name'] . ' (' . designation_company($notify['designation'], $notify['company_name']) . ') </a>';
                            } elseif ($notify['object_type'] == 'O') {
                                //echo 'organizer';
                                $type_of_user = $notify['organizer_name'] . ' (Organizer)';
                            } elseif ($notify['object_type'] == 'Mtg') {
                                $type_of_user = 'Attendee - Jigar Shah (COO, Infini Systems) sent you..';
                            }



                            if ($notify['notification_type'] == 'A') {
                                //echo '44';
                                echo '<div class="row"><div class="col-xs-12"><div class="stat well well-sm attnd"><h4>' . $notify['notification_content'] . '</h4>
                                            <small class="stat-label">' . $type_of_user . '</small>
                                            <small class="stat-label">' . date('d M Y', strtotime($notify['notification_date'])) . ', ' . $notify['event_name'] . '</small></div></div></div>';
                            } elseif ($notify['notification_type'] == 'N') {
                                //echo '52';
//                                $passcode = end(explode(" ", $notify['notification_content']));
                                //echo $passcode;

                                echo '<div class="row"><div class="col-xs-12"><div class="stat well well-sm attnd "><a href="javascript:void(0);" id="passcode_id" class="' . $notify['event_id'] . '"><h4 class="truncate">' . $notify['notification_content'] . '</h4></a>
                                            <small class="stat-label">' . $type_of_user . ' Sent you a message</small>
                                            <small class="stat-label">' . date('d M Y', strtotime($notify['notification_date'])) . ', ' . $notify['event_name'] . '</small></div></div></div>';
                            } elseif ($notify['notification_type'] == 'Passcode') {
                                //echo '52';
                                echo '<div class="row"><div class="col-xs-12"><div class="stat well well-sm attnd "><a href="javascript:;" id="passcode_id1" class="' . $notify['event_id'] . '" onclick="apply_passcode(' . $notify['event_id'] . ','.$notify['notification_content'].')"><h4 class="truncate">Your Passcode for the '.$notify['event_name'].' event is ' . $notify['notification_content'] . '</h4></a>
                                            <small class="stat-label">' . $type_of_user . ' Sent you a message</small>
                                            <small class="stat-label">' . date('d M Y', strtotime($notify['notification_date'])) . ', ' . $notify['event_name'] . '</small></div></div></div>';
                            } elseif ($notify['notification_type'] == 'O') {
                                //echo '69';
                                echo '<div class="row"><div class="col-xs-12"><div class="stat well well-sm attnd"><h4>' . $notify['notification_content'] . '</h4>
                                            <small class="stat-label">' . $type_of_user . '</small>
                                            <small class="stat-label">' . date('d M Y', strtotime($notify['notification_date'])) . ', ' . $notify['event_name'] . '</small></div></div></div>';
                            } elseif ($notify['notification_type'] == 'F') {
                                //echo '76';
                                echo '<div class="row"><div class="col-xs-12"><div class="stat well well-sm attnd"><a href="' . SITE_URL . 'notification/details/F/' . $notify['notification_id'] . '">
                                        <h4>' . $notify['notification_content'] . '</h4>
                                        <small class="stat-label">Feedback request from ' . $notify['organizer_name'] . ' (Organizer)</small>
                                        <small class="stat-label">' . date('d M Y', strtotime($notify['notification_date'])) . ', ' . $notify['event_name'] . '</small>
                                        </a></div></div></div>';
                            } elseif ($notify['notification_type'] == 'Mtg') {
                                //display($notify);
                                $acknowledege_msg = 'Sent you a meeting request';
                                if ($notify['approve'] == 1)
                                    $acknowledege_msg = 'Has accepted your meeting request';
                                elseif ($notify['approve'] == 2)
                                    $acknowledege_msg = 'Has declined your meeting request';
                                $html = '<div class="row"><div class="col-xs-12"><div class="stat well well-sm attnd"><a href="' . SITE_URL . 'notification/details/Mtg/' . $notify['notification_id'] . '">
							
							<h4>' . $type_of_user . ' ' . $acknowledege_msg . '</h4>
							<small class="stat-label" style="color: #3e3d3d;">Message from ' . $notify['first_name'] . ' : ' . $notify['notification_content'] . '</small>
							<small class="stat-label" style="color: #3e3d3d;">' . date('d M Y', strtotime($notify['notification_date'])) . ', ' . $notify['event_name'] . '</small></a>';
                                if ($notify['approve'] == 0) {
                                    $html .= '<small class="stat-label" style="color: #3e3d3d;"><a href="' . SITE_URL . 'notification/details/Mtg/' . $notify['notification_id'] . '"  class="btn btn-success btn-xs mr10">Confirm Meeting</a><a href="' . SITE_URL . 'notification/details/Mtg/' . $notify['notification_id'] . '" class="btn btn-default btn-xs">Decline Meeting</a></small>';
                                }

                                $html .= '</a></div></div></div>';
                                echo $html;
                            } elseif ($notify['notification_type'] == 'Msg') {

                                echo '<div class="row"><div class="col-xs-12"><div class="stat well well-sm attnd"><a href="' . SITE_URL . 'notification/details/Msg/' . $notify['message_id'] . '">
							
							<h4 class="truncate">' . $notify['notification_content'] . '</h4>
							<small class="stat-label" style="color: #3e3d3d;">' . $type_of_user . '  Sent you a message</small>
							<small class="stat-label" style="color: #3e3d3d;">' . date('d M Y', strtotime($notify['notification_date'])) . ', ' . $notify['event_name'] . '</small>
							<small class="stat-label" style="color: #3e3d3d;"><a href="' . SITE_URL . 'notification/details/Msg/' . $notify['message_id'] . '" class="btn btn-success btn-xs mr10">Reply</a></small>
                                            </a></div></div></div>'; //'<small class="stat-label">'.$type_of_user ;
                            } elseif ($notify['notification_type'] == 'Sh') {
                                // echo '110';
                            } elseif ($notify['notification_type'] == 'Sav') {
                                //echo '114';
                            } elseif ($notify['notification_type'] == 'S') {
//                                    /display($notify);
                                echo '<div class="row">
						  <div class="col-xs-12">
							<a href="http://' . $notify['survey_url'] . '" target="_blank">
							<div class="stat well well-sm attnd">
							<h4>Survey Request From Organizer</h4> 
							<small class="stat-label">Survey Title : ' . $notify['notification_content'] . '</small>
							<small class="stat-label">' . date('d M Y', strtotime($notify['notification_date'])) . ', ' . $notify['event_name'] . '</small>
							</div>
							</a>
						  </div>
                                                </div>';
                            }

                            //echo '</div></div></div>';
                            ?>



                            <?php
                        }
                    } else {
                        //echo '<div class="row"><div class="col-xs-12">No Notification Found!</div></div>';
                    }
                    ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="stat well well-sm attnd">
                                <h4 align="justify">Metropolis Support - <br>Contact <a href="mailto:nitin.sharma@mci-group.com">nitin.sharma@mci-group.com</a> for any issues / queries.</h4>
                                <small class="stat-label">Metropolis</small>
                                <!--<small class="stat-label">25 Jan 2014</small>-->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="stat well well-sm attnd">
                                <h4 align="justify">Welcome to Metropolis, official App for the XI Metropolis World Congress, being held in Hyderabad from 6th-11th October, 2014.</h4>
                                <small class="stat-label">Metropolis</small>
                                <!--<small class="stat-label">25 Jan 2014</small>-->
                            </div>
                        </div>
                    </div>


                </div><!-- col-sm-6 -->

            </div><!-- row -->
        </div>
    </div>
</div><!-- contentpanel -->

</div><!-- mainpanel -->

<div class="rightpanel">
    <!--Right panel view--->
    <?php $this->load->view(CLIENT_RIGHT_PANEL) ?>
    <!--Right panel view--->
</div><!-- rightpanel -->

<div id="new_msg" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">New Message</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <p>To, Naitik Vyas</p>
                            <input type="text" class="form-control"  placeholder="Add Attendee">
                            <div class="addattendies" style="width:100%;">

                            </div>
                        </div>

                        <div class="form-group">
                            <input type="button" class="btn btn-success input-sm btn-block" value="Add" id="addmoreat">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" placeholder="Write your message here"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success input-sm btn-block">Send</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
            </div>

            </form>
        </div>
    </div>

</div>

<div id="compose" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Compose</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <input type="text" class="form-control"  placeholder="Add Attendee, Speaker, Exhibitor">
                    </div>

                    <div class="form-group">
                        <input type="button" class="btn btn-success input-sm btn-block" value="Add" id="addmoreat">
                    </div>
                    <div class="form-group">
                        <div class="checkbox-inline">
                            <label> <input type="checkbox" checked> All Attendees, Speakers, Exhibitors</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="3" placeholder="Write your message here"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-success input-sm btn-block">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
<?php $this->load->view(CLIENT_FOOTER) ?>
<script>
    $("#passcode_id").live('click', function() {
        var event_id = $("#passcode_id").attr('class');
        $.ajax({
            type: 'POST',
            url: SITE_URL + "client/event/notification_passcode_validation",
            dataType: 'json',
            data: {event_id: event_id},
            success: function(res)
            {
                res = eval(res);
                if (res.error == 'success') {
//                    alert("sdsad");
                    window.location.href = SITE_URL + 'events/event-detail/' + event_id;
                }
                else {
                    window.location.href = SITE_URL + 'notification';
                }
            }
        });
    });
    function apply_passcode(event_id,passcode)
    {
        var passcode = $.trim(passcode);
        $.ajax({
            type: 'POST',
            url: SITE_URL + "client/event/notification_passcode_validation",
            dataType: 'json',
            data: {event_id: event_id,passcode:passcode},
            success: function(res)
            {
                res = eval(res);
                if (res.error == 'success') {
//                    alert("sdsad");
                    window.location.href = SITE_URL + 'events/event-detail/' + event_id;
                }
                else {
                    window.location.href = SITE_URL + 'notification';
                }
            }
        });
    }
</script>

