<!---client header view--->
<?php $this->load->view(CLIENT_HEADER) ?>

<!---client header view--->


<!----event top navigation---->
<?php $this->load->view(EVENT_TOP_NAVIGATION) ?>
<!----event top navigation---->
</div>
<?php //  display($event)?>
<div class="contentpanel">
    <div class="panel panel-default panel-stat">
        <div class="">

            <div class="row">

                <div class="col-xs-12">
                    <div class="stat well well-sm">
                        <h4 class="tits_1"><?php echo $event['event_name'] ?></h4>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="thumb">
                                    <img src="<?php echo SITE_URL . 'uploads/events/logo/' . $event['event_logo'] ?>" alt="" class="img-responsive userlogo"/>
                                </div>
                            </div>
                            <div class="col-xs-8 eventdet">
                                <span class="pull-right mr10">
                                    <small class="stat-label">
                                        <div class="thumb">
                                            <img src="<?php echo SITE_URL . 'uploads/organizer/logo/' . $event['organiser_photo'] ?>" class="img-responsive userlogor" alt="Organizer"/>
                                        <!--<img src="<?php //echo CLIENT_IMAGES  ?>epc.png" class="img-responsive userlogor" />-->
                                        </div>
                                    </small>

                                </span>
                                <h4>
                                    <?php
                                    $start_date = $event['event_start'];
                                    $end_date = $event['event_end'];

                                    echo date('d', strtotime($start_date)) . '-' . date('d', strtotime($end_date)) . ' ' . date('M', strtotime($start_date)) . ',' . date('Y', strtotime($start_date))
                                    ?>
                                    <!--15-18 Apr, 2014-->  
                                </h4>		
                                <small class="stat-label mr10"><?php echo $event['event_city'] . ' , ' . $event['event_country'] ?></small>
                                <small class="stat-label mr10"><?php echo $event['event_industry'] . ',' . $event['event_functionality'] ?></small>
                            </div>
                         
                        </div><!-- row -->


                        <hr class="mb9">
                        <?php
                        if (!passcode_validatation()) {
                            ?>
                            <a href="javascript:;" data-toggle="modal" data-target="#SignUp" class="btn btn-success input-sm btn-block mb9">Event Registration</a>
                            <form id="passcode_form" onsubmit="return false">
                                <div class="input-group">
                                    <input type="text" name="passcode" id="passcode" class="form-control" placeholder="Already Registered? Enter Passcode">
                                    <span class="input-group-btn"><input type="submit" name="submit" value="Submit" class="btn btn-default"></span>
                                </div>
                            </form>
                            <hr class="mb9">
                        <?php } ?>
                        <?php if ($common_industry || $common_location) { ?>
                            <div class="panel panel-dark panel-event">
                                <div class="panel-heading">
                                    <ul class="photo-meta">
                                        <li><a >Common Connections</a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <?php if ($common_industry) { ?>
                                            <div class="col-xs-6 temp text-left">
                                                <ul class="social-list">
                                                    <?php
                                                    if ($common_industry) {
                                                        foreach ($common_industry as $indus) {
                                                            echo '<li><a href="' . SITE_URL . 'events/attendee-detail/' . $indus['attendee_id'] . '"><img class="img-responsive" src="' . SITE_URL . 'uploads/' . front_image('attendee', $indus['attendee_image']) . '" title="' . $indus['attendee_name'] . '" alt="' . $indus['attendee_name'] . '"></a></li>';
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                                <h5><?php echo count($common_industry) ?> Industry</h5>
                                            </div>
                                        <?php } ?>
                                        <div class="brbr"></div>
                                        <?php if ($common_location) { ?>
                                            <div class="col-xs-6 temp text-left">
                                                <ul class="social-list">
                                                    <?php
                                                    if ($common_location) {
                                                        foreach ($common_location as $location) {
                                                            echo '<li><a href="' . SITE_URL . 'events/attendee-detail/' . $location['attendee_id'] . '"><img class="img-responsive" src="' . SITE_URL . 'uploads/' . front_image('attendee', $location['attendee_image']) . '" title="' . $location['attendee_name'] . '" alt="' . $location['attendee_name'] . '"></a></li>';
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                                <h5><?php echo count($common_location) ?> Location</h5>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <address>
                            <strong>Event Map:</strong> <a href="<?php echo SITE_URL . 'client/event/get_image_map_exhibitor/parent/' . $this->session->userdata('client_event_id'); ?>">Show Event Map</a><br>
                            <strong>Venue:</strong> <?php echo $event['event_location'] ?><br>
                            <strong>Email:</strong> <?php echo $event['contact_email'] ?><br>
                            <?php if ($event['website']) { ?>
                                <strong>Website:</strong> <a href="<?php echo 'http://' . $event['website'] ?>" target="_blank"><?php echo $event['website'] ?></a><br>
                            <?php } ?>
                        </address>
                        <?php
                        if ($event['floor_plan']) {
                            if (file_exists(UPLOADS . 'events/floorplan/' . $event['floor_plan'])) {
                                ?>

                                <a class="btn btn-success input-sm btn-block mb9" href="<?php echo SITE_URL . 'client/event/download/EVENT/' . $target_user_id . '/' . $event['floor_plan'] ?>" >Download Event Map</a>
                                <?php
                            }
                        }
                        ?>
                        <ul class="list-inline mb5">
                            <?php
                            if ($event['image1']) {
                                if (file_exists(UPLOADS . 'events/images/' . $event['image1']))
                                    echo '<li class="open_gallery"><a href="javascript:;" ><img class="img-responsive" src="' . SITE_URL . 'uploads/events/images/' . $event['image1'] . '"></a></li>';
                            }
                            if ($event['image2']) {
                                if (file_exists(UPLOADS . 'events/images/' . $event['image2']))
                                    echo '<li class="open_gallery"><a href="javascript:;" ><img class="img-responsive" src="' . SITE_URL . 'uploads/events/images/' . $event['image2'] . '"></a></li>';
                            }
                            if ($event['image3']) {
                                if (file_exists(UPLOADS . 'events/images/' . $event['image3']))
                                    echo '<li class="open_gallery"><a href="javascript:;" ><img class="img-responsive" src="' . SITE_URL . 'uploads/events/images/' . $event['image3'] . '"></a></li>';
                            }
                            ?>
                        </ul>
                        <p class="text-justify"><?php echo $event['event_description'] ?></p>
                        <br>
                        <!---google map integrations---->

                        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
                        <script>
                            function initialize() {
                                var myLatlng = new google.maps.LatLng('<?php echo $event['event_latitude'] ?>', '<?php echo $event['event_longitude'] ?>');
                                var mapOptions = {
                                    zoom: 12,
                                    center: myLatlng,
                                    //mapTypeControl: false,
                                    //scrollwheel: false,
                                    //keyboardShortcuts: false,
                                    //draggable: false,

                                }
                                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

                                var marker = new google.maps.Marker({
                                    position: myLatlng,
                                    map: map,
                                    //title: 'Hello World!'
                                });
                            }

                            google.maps.event.addDomListener(window, 'load', initialize);
                            google.maps.event.addDomListener(window, 'resize', initialize);

                        </script>

                        <!---google map integrations ends---->
                        <div class="mb5" style="border:1px solid rgba(0,0,0,0.4); border-radius: 4px; height: 225px" id="map-canvas"></div>
                                      <!--<img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php //echo $event['event_latitude']  ?>,<?php //echo $event['event_longitude']  ?>&zoom=14&size=400x400&sensor=false" class="img-responsive thumb mapimg mb9">-->



                        <?php
                        if (!passcode_validatation()) {
                            ?>
                            <a href="javascript:;" data-toggle="modal" data-target="#SignUp" class="btn btn-success input-sm btn-block mb9">Event Registration</a>
                        <?php } ?>

                    </div><!-- stat -->
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

<input type="hidden" name="subject_type" id="subject_type_notfication" value="<?php echo $target_user_type ?>">
<input type="hidden" name="subject_id" id="subject_id_notfication" value="<?php echo $target_user_id ?>">
</section>

<!---image gallery pop up---->

<div id="gallery_image_pop"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Gallery</h4>
            </div>

            <div class="modal-body">
                <center> <div class="place_gallery_image"></div></center>
            </div>


        </div>
    </div>

</div>
<!---image gallery pop up---->



<!---splash add---->
<?php
//echo $_SERVER['HTTP_REFERER'];
//$temp_refferer = explode('/',$_SERVER['HTTP_REFERER']);
$splash_show_flag = FALSE;
$events_url = $this->uri->segment(1);
$referrer = @$_SERVER['HTTP_REFERER'];
$pos1 = strpos($referrer, '?type');
$pos2 = strpos($referrer, '?industry');
$splash_id = '';
if (@$_SERVER['HTTP_REFERER'] == SITE_URL . 'events/' || @$_SERVER['HTTP_REFERER'] == SITE_URL . 'events' || $pos1 !== false || $pos2 !== false) {

    $splash_ad = show_normal_ad();
    //display($splash_ad);
    $splash_image = '';
    foreach ($splash_ad as $key => $val) {
        if ($val['splash_ad'] && file_exists(UPLOADS . 'sponsor/splash_ad/' . $val['splash_ad'])) {
            $splash_id = $val['id'];
            $splash_image = $val['splash_ad'];
            $splash_show_flag = TRUE;
        }
    }
}
?>
<!---splash add---->
<!---Splash Add  pop up---->

<div id="splash_ad_pop"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" >
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Click anywhere to close</h4>
            </div>
            <div class="modal-body " >
                <a href="javascript:;" class="place_splash_image" onclick="push_ad_analytics('<?php echo $this->session->userdata('client_attendee_id') ?>', '<?php echo $this->session->userdata('client_user_type') ?>', 'splash_ad', '<?php echo $splash_id ?>', '<?php echo $this->session->userdata('client_event_id') ?>')"></a>
            </div>
        </div>
    </div>
</div>
<!---image gallery pop up---->

<script type="text/javascript">
    $(document).ready(function()
    {
<?php
if ($splash_show_flag) {
    ?>
            $("#splash_ad_pop").modal('show');
            $(".place_splash_image").html('<img class="img-responsive" src="<?php echo SITE_URL . 'uploads/sponsor/splash_ad/' . $splash_image ?>">');
    <?php
}
?>



        $(".btn").click(function()
        {

        });
    });

    function open_gallery(image)
    {
        alert($(this).attr("src"));
        //$("#gallery_image_pop").modal('show');
    }

</script>

<?php $this->load->view(CLIENT_FOOTER) ?>
<style>
    .place_splash_image img{margin: 0 auto;}
</style>