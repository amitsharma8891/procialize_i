<?php $thisPage = "index"; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="<?php echo base_url() ?>public/admin/images/favicon.png" type="image/png">
        <title>Procialize Dashboard</title>
        <link href="<?php echo base_url(); ?>public/admin/css/style.default.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/admin/css/jquery.datatables.css" rel="stylesheet">
        <style type="text/css">
            .dataTables_filter {
                width:100%;
                margin-top:20px;
            }
            
            .dataTables_filter input {
                width:92%;
            }
        </style>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="<?php echo base_url(); ?>public/admin/js/html5shiv.js"></script>
          <script src="<?php echo base_url(); ?>public/admin/js/respond.min.js"></script>
          <![endif]-->
    </head>

    <body>

        <!-- Preloader -->
        <div id="preloader">
            <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
        </div>
        <section>
            <div class="leftpanel">
                <?php $this->load->view('admin/leftpanel') ?>
            </div>
            <!-- leftpanel -->

            <div class="mainpanel">
                <div class="headerbar">
                    <?php $this->load->view('admin/header') ?>
                </div>
                <!-- headerbar -->

                <div class="pageheader">
                    <h2><i class="fa fa-align-right fa-rotate-90"></i> Dashboard </h2>
                </div>
                <?php echo ($this->session->flashdata('message')); ?>

                <div class="contentpanel">
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
                                                <h4><?php echo $total_attendees; ?></h4>
                                            </div>
                                            <div class="col-xs-4"> <small class="stat-label">Exhibitors</small>
                                                <h4><?php echo $total_exhibitors; ?></h4>
                                            </div>
                                            <div class="col-xs-4"> <small class="stat-label">Speakers</small>
                                                <h4><?php echo $total_speakers; ?></h4>
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
                                                <h1><?php echo $msg_rcv + $msg_sent + $meet_rcv + $meet_sent + $not ?></h1>
                                            </div>
                                        </div>
                                        <!-- row -->

                                        <div class="mb15"></div>
                                        <div class="row">
                                            <div class="col-xs-2"> <small class="stat-label">Messages (to me)</small>
                                                <h4><?php echo $msg_rcv ?></h4>
                                            </div>
                                            <div class="col-xs-2"> <small class="stat-label">Messages (by me)</small>
                                                <h4><?php echo $msg_sent ?></h4>
                                            </div>
                                            <div class="col-xs-2"> <small class="stat-label">Meetings (with me)</small>
                                                <h4><?php echo $meet_rcv ?></h4>
                                            </div>
                                            <div class="col-xs-2"> <small class="stat-label">Meeting (by me)</small>
                                                <h4><?php echo $meet_sent ?></h4>
                                            </div>
                                            <div class="col-xs-2"> <small class="stat-label">Notifications (by me)</small>
                                                <h4><?php echo $not ?></h4>
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
                                               
                                            </div>
                                        </div>
                                        <!-- row -->

                                        <div class="mb15"></div>
                                        <div class="row">
                                            
                                            <div class="col-xs-6"> <small class="stat-label">Total viewed</small>
                                                <h4><?php echo $arr_exh_view; ?></h4>
                                            </div>
                                            <div class="col-xs-6"> <small class="stat-label">My viewed</small>
                                                <h4><?php echo $arr_exh_current_view ?></h4>
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
                                                
                                            </div>
                                        </div>
                                        <!-- row -->

                                        <div class="mb15"></div>
                                        <div class="row">
                                            <div class="col-xs-6"> <small class="stat-label">Total saved</small>
                                                <h4><?php echo $saveExhibitor ?></h4>
                                            </div>
                                            <div class="col-xs-6"> <small class="stat-label">My Saved</small>
                                                <h4><?php echo $saveCurrentExhibitor ?></h4>
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
                                                
                                            </div>
                                        </div>
                                        <!-- row -->

                                        <div class="mb15"></div>
                                        <div class="row">
                                            <!-- <div class="col-xs-3"> <small class="stat-label">Event</small>
                                                <h4><?php echo $sharedEvent ?></h4>
                                            </div> -->
                                            
                                            <div class="col-xs-6"> <small class="stat-label">Total Shared .</small>
                                                <h4><?php echo $sharedExhibitor ?></h4>
                                            </div>
                                            <div class="col-xs-6"> <small class="stat-label">My Shared</small>
                                                <h4><?php echo $sharedCurrentExhibitor ?></h4>
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
                                              
                                            </div>
                                        </div>
                                        <!-- row -->

                                        <div class="mb15"></div>
                                        <div class="row">
                                            
                                            <div class="col-xs-6"> <small class="stat-label">Total Downloaded</small>
                                                <h4><?php echo $download_exh_pro ?></h4>
                                            </div>
                                            <div class="col-xs-6"> <small class="stat-label">My Downloaded</small>
                                                <h4><?php echo $download_exh_pro_curr ?></h4>
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
                    <div class="row" style="display:none;">
                        <div class="col-sm-4 col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h5 class="subtitle mb5">COMMON INTEREST GROUP</h5>
                                    <p class="mb15">Attendees / Exhibitors / Speakers having common interest group (Industry / Functionality / Country / City)</p>
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4">
                                            <div id="donut-chart2" style="text-align: center; height: 298px;"></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div id="donut-chart3" style="text-align: center; height: 298px;"></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div id="donut-chart4" style="text-align: center; height: 298px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- panel-body --> 
                            </div>
                            <!-- panel --> 

                        </div>
                    </div>

                    <div class="row">  
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-btns">
                                    <a href="#" class="panel-close">&times;</a>
                                    <a href="#" class="minimize">&minus;</a>
                                </div><!-- panel-btns -->
                                <h5 class="panel-title panel-title-alt">EVENT TURNOUT </h5>
                                <p>Total no. of visits to the Event page v/s no. of Registrations v/s no. of Registered Attendees who used the App for the Event </p>
                            </div><!-- panel-heading -->
                            <div class="panel-body">

                                <div class="tinystat mr20">
                                    <div id="sparkline" class="chart mt5"></div>
                                    <div class="datainfo">
                                        <span class="text-muted">No. Of Visits</span>
                                        <h4><?php echo $event_visit; ?></h4>
                                    </div>
                                </div><!-- tinystat -->

                                <div class="tinystat mr20">
                                    <div id="sparkline2" class="chart mt5"></div>
                                    <div class="datainfo">
                                        <span class="text-muted">NO. OF REGISTRATION</span>
                                        <h4><?php echo $registerAttendee; ?></h4>
                                    </div>
                                </div><!-- tinystat -->

                                <div class="tinystat mr20">
                                    <div id="sparkline3" class="chart mt5"></div>
                                    <div class="datainfo">
                                        <span class="text-muted"> NO. OF ATTENDEES WHO USED THE APP</span>
                                        <h4><?php echo $attendeeApp; ?></h4>
                                    </div>
                                </div><!-- tinystat -->

                            </div><!-- panel-body -->
                        </div>
                    </div>    


                    <div class="row">
                        <div class="col-sm-8 col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-btns"> <a href="#" class="panel-close">&times;</a> <a href="#" class="minimize">&minus;</a> </div>
                                    <!-- panel-btns -->
                                    <h5 class="panel-title">MEETINGS SET</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="col-sm-3">
                                        <form action="#" method="post">
                                           <!-- <select class="form-control input-sm mb15">
                                                <option>Event Name </option>
                                                <option>Event Name 1</option>
                                                <option>Event Name 2</option>
                                            </select> -->
                                        </form>
                                    </div>
                                    <table class="table mb30">
                                        <thead>
                                            <tr>
                                                <th>No. of Meetings</th>
                                                <th>Confirmed</th>
                                                <th>Declined</th>
                                                <th>No Response</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $no_of_meetings ?></td>
                                                <td><?php echo $confirmed ?></td>
                                                <td><?php echo $declined ?></td>
                                                <td><?php echo $no_response ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-btns"> <a href="#" class="panel-close">&times;</a> <a href="#" class="minimize">&minus;</a> </div>
                                    <!-- panel-btns -->
                                    <h5 class="panel-title">DATA TABLE - EVENT</h5>
                                    <p>Analysis by Industry / Functionality / Country / City</p>
                                </div>
                                <div class="panel-body">
                                    <form action="" method="post" id="city_country_stat">

                                        <div class="col-sm-3">
                                            <select name="type_of_user" id="type_of_user" class="form-control input-sm mb15">
                                                <option <?php echo ($tou == 'A')? 'selected':'' ?> value='A'>Attendees </option>
                                                <option <?php echo ($tou == 'E')? 'selected':'' ?> value='E'>Exhibitor </option>
                                                <option <?php echo ($tou == 'S')? 'selected':'' ?> value='S'>Speaker </option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <select name="type_of_stat" class="form-control input-sm mb15" id="type_of_stat">
                                                <option <?php echo ($tos == 'industry')? 'selected':'' ?> value="industry">Industry </option>
                                                <option <?php echo ($tos == 'functionality')? 'selected':'' ?> value="functionality">Functionality</option>
                                                <option <?php echo ($tos == 'city')? 'selected':'' ?> value="city">City</option>
                                                <option <?php echo ($tos == 'country')? 'selected':'' ?> value="country">Country</option>
                                            </select>
                                        </div>
                                    </form>
                                    <table class="table" id="table1">
                                        <thead>
                                            <tr>
                                                <th>Topic</th>
                                                <th>Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($interests as $interest) { ?>
                                            <tr>
                                                <td><?php echo $interest['display_name']; ?></td>
                                            <td><?php echo $interest['cnt']; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-btns"> <a href="#" class="panel-close">&times;</a> <a href="#" class="minimize">&minus;</a> </div>
                                    <!-- panel-btns -->
                                    <h5 class="panel-title">DATA TABLE - SESSION</h5>
                                    <p>Session level detail</p>
                                </div>
                                <div class="panel-body">
                                    <div class="panel panel-success panel-stat">
                                        <div class="panel-heading">
                                            <div class="stat" style="max-width:100%">
                                                <div class="row">
                                                    <div class="col-xs-2"> <img src="<?php echo base_url() ?>public/admin/images/is-user.png" alt=""> </div>
                                                    <div class="col-xs-10"> <small class="stat-label">Total Sessions</small>
                                                        <h1><?php echo count($sessions); ?></h1>
                                                    </div>
                                                </div>
                                                <!-- row -->
                                                <?php
                                                $ses_attend = 0;
                                                $ses_spk = 0;
                                                $ses_quest = 0;
                                                $ses_feed = 0;
                                                foreach ($sessions as $res) {
                                                    $ses_attend += $res['session_attendees'];
                                                    $ses_spk += $res['session_speaker'];
                                                    $ses_quest += $res['session_question'];
                                                    $ses_feed += $res['total'];
                                                }
                                                ?>
                                                <div class="mb15"></div>
                                                <div class="row">
                                                    <div class="col-xs-3"> <small class="stat-label">Attendees</small>
                                                        <h4><?php echo $ses_attend; ?></h4>
                                                    </div>
                                                    <div class="col-xs-3"> <small class="stat-label">Speakers</small>
                                                        <h4><?php echo $ses_spk; ?></h4>
                                                    </div>
                                                    <div class="col-xs-3"> <small class="stat-label">Questions</small>
                                                        <h4><?php echo $ses_quest; ?></h4>
                                                    </div>
                                                    <div class="col-xs-3"> <small class="stat-label">Feedback</small>
                                                        <h4><?php echo $ses_feed; ?></h4>
                                                    </div>
                                                </div>
                                                <!-- row --> 
                                            </div>
                                            <!-- stat --> 

                                        </div>
                                        <!-- panel-heading --> 
                                    </div>
                                    <form action="#" method="post">
                                        <div class="col-sm-3">
                                           <!-- <select class="form-control input-sm mb15">
                                                <option>Event Name </option>
                                                <option>Event Name 1</option>
                                                <option>Event Name 2</option>
                                            </select> -->
                                        </div>
                                        <div class="col-sm-3">
                                            <!-- <select class="form-control input-sm mb15">
                                                <option>Session Name </option>
                                                <option>Attendees 1</option>
                                                <option>Attendees 2</option>
                                            </select> -->
                                        </div>
                                    </form>
                                    <?php if (count($sessions) > 0) { ?>
                                        <table class="table" id="table2">
                                            <thead>
                                                <tr>
                                                    <th>Session Name</th>
                                                    <th>Attendee Count</th>
                                                    <th>Speaker Count</th>
                                                    <th>Questions Asked</th>
                                                    <th>Total Feedback</th>
                                                    <th>Avg Feedback</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($sessions as $session) { ?>
                                                    <tr class="gradeA">
                                                        <td><?php echo $session['name'] ?></td>
                                                        <td><?php echo $session['session_attendees'] ?></td>
                                                        <td><?php echo $session['session_speaker'] ?></td>
                                                        <td><?php echo $session['session_question'] ?></td>
                                                        <td><?php echo $session['total'] ?></td>
                                                        <td><?php echo($session['total'] != 0) ? number_format($session['star'] / $session['total'], 2) : 0; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        No session available
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Important-->

                    <div id="basicflot" style="width: 100%; height: 300px; margin-bottom: 20px; display:none;"></div>
                    <div id="line-chart" style="height: 248px; display:none;"></div>

                    <!--Important--> 

                </div>
                <!-- contentpanel --> 

                <!-- contentpanel --> 

            </div>
            <!-- mainpanel -->

            <div class="rightpanel">
                <?php $this->load->view('admin/rightpanel') ?>
            </div>
            <!-- rightpanel --> 

        </section>

        <!-- graph & data table js --> 
        <script src="<?php echo base_url(); ?>public/admin/js/jquery-1.10.2.min.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/flot/flot.min.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/flot/flot.resize.min.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/morris.min.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/raphael-2.1.0.min.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/dashboard.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.datatables.min.js"></script> 
        <!-- graph & data table js --> 

        <script src="<?php echo base_url(); ?>public/admin/js/jquery-migrate-1.2.1.min.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/bootstrap.min.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/modernizr.min.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.sparkline.min.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/toggles.min.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/retina.min.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/jquery.cookies.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/bootstrap-timepicker.min.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/chosen.jquery.min.js"></script> 
        <script src="<?php echo base_url(); ?>public/admin/js/custom.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/underscore-min.js"></script>
        <script src="<?php echo base_url(); ?>public/admin/js/notification.js"></script>

        <script src="<?php echo base_url(); ?>public/admin/js/chosen.jquery.min.js"></script>
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
        <script type="text/javascript">
            $(document).ready(function() {
                $('.sub-menu').click(function() {
                    var event_id = $(this).attr('data');
                    $.cookie('event_id', event_id, {expires: 7, path: '/'});
                });
                $('.sub-menu a').click(function() {
                    var menu_name = $(this).attr('data');
                    $.cookie('menu_name', menu_name, {expires: 7, path: '/'});
                });

<?php if ($this->session->flashdata('show_popup')) { ?>
                    $('#tour').modal('show');
<?php } ?>
               $('#type_of_user,#type_of_stat').change(function(){
                   $('#city_country_stat').submit();
               });
            });

        </script>

        <div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
                        <h4 class="modal-title" id="myModalLabel">Compose</h4>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open(base_url() . 'manage/notification/add', array('id' => 'notification', 'name' => 'notification-form')); ?>

                        <div class="row mb10">
                            <!--<div class="col-sm-1">
                                Type
                            </div>-->
                            <div class="col-sm-3">
                                <?php
                                $type = $this->session->userdata('type_of_user');
                                if ($type != 'E') {
                                    ?>
                                    <select name= "type" type="select" class="form-control chosen-select">
                                        <option value="">Choose Type</option>
                                        <option value="A">Alert</option>
                                        <option value="N">Notification</option>
                                        <option value="F">Feedback</option>

                                    </select>
                                <?php } else { ?>
                                    Send Notification
                                    <input type="hidden" name="type" value="N" />
                                <?php } ?>

                            </div>
                            <div style="color:#a94442;"> <?php echo form_error('type'); ?></div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input name="now" type="checkbox" id="now" value="1" checked="checked">
                                    </span>
                                    <input type="text" value="Now" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <input ntype="text" class="form-control " name="notification_date" placeholder="Select Date" id="notification_date">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    <div class="bootstrap-timepicker"><input id="start_time" name="notification_time" placeholder="From" type="text" class="form-control time-picker ui-timepicker-input"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb10">
                            <div class="col-sm-12">
                                <textarea id="announcement_content" name ='content' rows="6" class="form-control" placeholder="Write text for the post to be displayed in the notification section"></textarea>
                            </div>
                            <div style="color:#a94442;"> <?php echo form_error('content'); ?></div>
                        </div>
                        <div class="row mb10">
                            <div class="col-sm-12">
                                <?php echo form_dropdown('attendee_id[]', getAttendee_dropdown(), '', 'class="form-control chosen-select" id="attendee" multiple   placeholder="Type" data-placeholder="Attendee "'); ?>

                            </div>

                        </div>
                        <div class="row mb10">
                            <div class="col-sm-12">
                                <ul class="list-inline mb5">
                                    <li>
                                        <!--                                        <div class="ckbox ckbox-default">
                                                                                    <select name ='type1' type="select" class="form-control">
                                                                                        <option value="selected">Type</option>
                                                                                        <option value="A">A</option>
                                                                                        <option value="B">BZ</option>
                                                                                    </select>
                                                                                </div>-->

                                    </li>

<!--                                    <li><input name ='alll' type="checkbox" id="alll" value="1" > <label for="alll">All</label></li>
                                    <li><input name ='exhibitor' class="select_all" type="checkbox" id="exhibitors" value="1"> <label for="exhibitors">Exhibitors</label></li>-->
                                    <!--<li><input name ='speaker' class="select_all" type="checkbox" id="speakers" value="1"> <label for="speakers">Speakers</label></li>-->
                                    <li><input name ='attendee' class="select_all" type="checkbox" id="attendee" value="1"> <label for="attendee">All Attendee, Speakers, Exhibitors </label></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                $data = array("name" => "btnSubmit", "id" => "btnSubmit", "value" => "Send", "class" => "btn btn-success btn-block");
                                echo form_submit($data);
                                ?>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

		</div>


    </body>
</html>
